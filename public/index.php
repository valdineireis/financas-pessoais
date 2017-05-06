<?php 
// Permitindo a leitura de arquivos estáticos
$filename = __DIR__.preg_replace('#(\?.*)$#', '', $_SERVER['REQUEST_URI']);
if (php_sapi_name() === 'cli-server' && is_file($filename)) {
    return false;
}

use Psr\Http\Message\ServerRequestInterface;
use VRSFin\Application;
use VRSFin\Plugins\AuthPlugin;
use VRSFin\Plugins\DbPlugin;
use VRSFin\Plugins\RoutePlugin;
use VRSFin\Plugins\ViewPlugin;
use VRSFin\ServiceContainer;

require_once __DIR__ . '/../vendor/autoload.php';

if (file_exists(__DIR__ . '/../.env')) {
	$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../');
	$dotenv->overload();
}

require_once __DIR__ . '/../src/helpers.php';

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new RoutePlugin());
$app->plugin(new ViewPlugin());
$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

$app->get('/', function(ServerRequestInterface $request) {
	$response = new \Zend\Diactoros\Response();
	$response->getBody()->write("Pagina inicial");
	return $response;
});

require_once __DIR__ . '/../src/controllers/errors.php';
require_once __DIR__ . '/../src/controllers/charts.php';
require_once __DIR__ . '/../src/controllers/statements.php';
require_once __DIR__ . '/../src/controllers/category-costs.php';
require_once __DIR__ . '/../src/controllers/bill-receives.php';
require_once __DIR__ . '/../src/controllers/bill-pays.php';
require_once __DIR__ . '/../src/controllers/users.php';
require_once __DIR__ . '/../src/controllers/auth.php';

$app->start();