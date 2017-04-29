<?php
declare(strict_types=1);

namespace VRSFin\Plugins;

use Interop\Container\ContainerInterface;
use VRSFin\Auth\Auth;
use VRSFin\Auth\JasnyAuth;
use VRSFin\ServiceContainerInterface;

class AuthPlugin implements PluginInterface
{
    public function register(ServiceContainerInterface $container)
    {
        $container->addLazy(
            'jasny.auth', function (ContainerInterface $container) {
                return new JasnyAuth($container->get('user.repository'));
            }
        );
        $container->addLazy(
            'auth', function (ContainerInterface $container) {
                return new Auth($container->get('jasny.auth'));
            }
        );
    }
}
