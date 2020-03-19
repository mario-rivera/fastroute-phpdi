<?php
namespace FrameworkBootstrap;
require_once(dirname(__DIR__) . "/vendor/autoload.php");

function boot(): \Umbra\Framework
{
    $builder = (new \DI\ContainerBuilder())
    ->addDefinitions( __DIR__ . "/framework_definitions.php")
    ->addDefinitions( __DIR__ . "/definitions.php");

    $container = $builder->build();

    return $container->get(\Umbra\Framework::class);
}
