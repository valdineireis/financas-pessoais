<?php 

use Psr\Http\Message\ServerRequestInterface;
use VRSFin\Application;
use VRSFin\Plugins\DbPlugin;
use VRSFin\Plugins\RoutePlugin;
use VRSFin\Plugins\ViewPlugin;
use VRSFin\ServiceContainer;

require_once __DIR__ . '/../vendor/autoload.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());

$app->get('/', function(ServerRequestInterface $request) {
	$response = new \Zend\Diactoros\Response();
	$response->getBody()->write("Pagina inicial");
	return $response;
});

require_once __DIR__ . '/../src/controllers/category-costs.php';

$app->start();