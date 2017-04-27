<?php
declare(strict_types=1);

namespace VRSFin\Plugins;

use Interop\Container\ContainerInterface;
use VRSFin\Models\BillReceive;
use VRSFin\Models\BillPay;
use VRSFin\Models\CategoryCost;
use VRSFin\Models\User;
use VRSFin\Repository\RepositoryFactory;
use VRSFin\Repository\StatementRepository;
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

        $container->add('repository.factory', new RepositoryFactory());
        $container->addLazy('category-cost.repository', function(ContainerInterface $container) {
        	return $container->get('repository.factory')->factory(CategoryCost::class);
        });

        $container->addLazy('bill-receive.repository', function(ContainerInterface $container) {
            return $container->get('repository.factory')->factory(BillReceive::class);
        });

        $container->addLazy('bill-pay.repository', function(ContainerInterface $container) {
            return $container->get('repository.factory')->factory(BillPay::class);
        });

        $container->addLazy('user.repository', function(ContainerInterface $container) {
            return $container->get('repository.factory')->factory(User::class);
        });

        $container->addLazy('statement.repository', function() {
            return new StatementRepository();
        });
    }
}