<?php 
declare(strict_types=1);

namespace VRSFin\Plugins;

use Interop\Container\ContainerInterface;
use VRSFin\ServiceContainerInterface;
use VRSFin\View\ViewRenderer;

class ViewPlugin implements PluginInterface
{
	public function register(ServiceContainerInterface $container)
	{
		$container->addLazy('twig', function(ContainerInterface $container) {
			$loader = new \Twig_loader_Filesystem(__DIR__ . '/../../templates');
			$twig = new \Twig_Environment($loader);

			$genarator = $container->get('routing.generator');
			$twig->addFunction(new \Twig_SimpleFunction('route', 
				function(string $name, array $params = []) use($genarator) {
					return $genarator->generate($name, $params);
				})
			);
			return $twig;
		});

		$container->addLazy('view.renderer', function(ContainerInterface $container) {
			$twigEnvironment = $container->get('twig');
			return new ViewRenderer($twigEnvironment);
		});
	}
}