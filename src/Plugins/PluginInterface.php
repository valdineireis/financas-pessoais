<?php 
declare(strict_types=1);

namespace VRSFin\Plugins;

use VRSFin\ServiceContainerInterface;

interface PluginInterface
{
	public function register(ServiceContainerInterface $container);
}