<?php
declare(strict_types=1);

namespace VRSFin\Plugins;

use Interop\Container\ContainerInterface;
use VRSFin\Models\CategoryCost;
use VRSFin\Repository\RepositoryFactory;
use VRSFin\ServiceContainerInterface;
use Illuminate\Database\Capsule\Manager as Capsule;

class DbPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $container)
    {
        $capsule = new Capsule();
        $config = include __DIR__ . '/../../config/db.php';
        $capsule->addConnection($config['development']);
        $capsule->bootEloquent();
    }
}