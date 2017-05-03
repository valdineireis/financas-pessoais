<?php 
declare(strict_types=1);

namespace VRSFin;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use VRSFin\Plugins\PluginInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Diactoros\Response\SapiEmitter;

class Application
{
    private $serviceContainer;
    private $befores = [];

    public function __construct(ServiceContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    public function service($name)
    {
        return $this->serviceContainer->get($name);
    }

    public function addService(string $name, $service): void
    {
        if (is_callable($service)) {
            $this->serviceContainer->addLazy($name, $service);
        } else {
            $this->serviceContainer->add($name, $service);
        }
    }

    public function plugin(PluginInterface $plugin): void
    {
        $plugin->register($this->serviceContainer);
    }

    public function get($path, $action, $name = null): Application
    {
        $routing = $this->service('routing');
        $routing->get($name, $path, $action);
        return $this;
    }

    public function post($path, $action, $name = null): Application
    {
        $routing = $this->service('routing');
        $routing->post($name, $path, $action);
        return $this;
    }

    public function redirect($path): ResponseInterface
    {
        return new RedirectResponse($path);
    }

    public function route(string $name, array $params = []): ResponseInterface
    {
        $genarator = $this->service('routing.generator');
        $path = $genarator->generate($name, $params);
        return $this->redirect($path);
    }

    public function before(callable $callback): Application
    {
        array_push($this->befores, $callback);
        return $this;
    }

    protected function runBefores(): ?ResponseInterface
    {
        foreach ($this->befores as $callback) {
            $result = $callback($this->service(RequestInterface::class));
            if ($result instanceof ResponseInterface) {
                return $result;
            }
        }

        return null;
    }

    public function start(): void
    {
        $route = $this->service('route');

        if (!$route) {
            $this->internalRedirect('errors.404');
            exit;
        }

        $result = $this->runBefores();
        if ($result) {
            $this->emitResponse($result);
            return;
        }

        /**
         * @var ServerRequestInterface $request 
         */
        $request = $this->service(RequestInterface::class);

        foreach ($route->attributes as $key => $value) {
            $request = $request->withAttribute($key, $value);
        }

        try {
            $callable = $route->handler;
            $response = $callable($request);
            $this->emitResponse($response);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->internalRedirect('errors.403');
        } catch (\Exception $e) {
            $this->internalRedirect('errors.400');
        }
    }

    protected function emitResponse(ResponseInterface $response): void
    {
        $emitter = new SapiEmitter();
        $emitter->emit($response);
    }

    protected function internalRedirect(string $name): void
    {
        $response = $this->route($name);
        $this->emitResponse($response);
    }
}
