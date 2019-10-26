<?php
use Psr\Container\ContainerInterface;

return [
    FastRoute\Dispatcher::class => 
        \DI\factory([\Umbra\Dispatcher\SimpleDispatcherFactory::class, 'create'])
        ->parameter('routes', __DIR__ . "/routes.php"),
];
