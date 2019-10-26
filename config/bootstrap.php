<?php
namespace UmbraBootstrap;
require_once(dirname(__DIR__) . "/vendor/autoload.php");

function boostrap()
{
    $builder = new \DI\ContainerBuilder();
    $builder->addDefinitions( __DIR__ . "/definitions.php");

    $container = $builder->build();

    return $container->get(\Umbra\Umbra::class);
}
