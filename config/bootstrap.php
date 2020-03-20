<?php
namespace FrameworkBootstrap;
require_once(dirname(__DIR__) . "/vendor/autoload.php");

function boot(): \Umbra\Framework
{
    $container = (new \DI\ContainerBuilder())
    ->addDefinitions( __DIR__ . "/framework_definitions.php")
    ->addDefinitions( __DIR__ . "/definitions.php")
    ->build();

    ($container->get(\Umbra\Kernel\Errors\ErrorManager::class))->boot();

    return $container->get(\Umbra\Framework::class);
}
