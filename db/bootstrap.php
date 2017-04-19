<?php 

use VRSFin\Application;
use VRSFin\Plugins\AuthPlugin;
use VRSFin\Plugins\DbPlugin;
use VRSFin\ServiceContainer;

$serviceContainer = new ServiceContainer();
$app = new Application($serviceContainer);

$app->plugin(new DbPlugin());
$app->plugin(new AuthPlugin());

return $app;