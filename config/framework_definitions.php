<?php
use Psr\Container\ContainerInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

return [
    \FastRoute\Dispatcher::class => 
        \DI\factory([\Umbra\Routing\Factory\SimpleDispatcherFactory::class, 'create'])
        ->parameter('routes', __DIR__ . "/routes.php"),
    \Psr\Http\Message\ServerRequestInterface::class => function (Psr17Factory $factory) {
        $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
            $factory, $factory, $factory, $factory
        );

        return $creator->fromGlobals();
    },
    \Psr\Http\Message\ResponseInterface::class => function (Psr17Factory $factory) {
        return $factory->createResponse(200);
    }
];
