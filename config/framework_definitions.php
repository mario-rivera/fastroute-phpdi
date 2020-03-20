<?php
use Psr\Container\ContainerInterface;
use Nyholm\Psr7\Factory\Psr17Factory;

return [
    'app.env' => (getenv('APP_ENV')) ? getenv('APP_ENV') : 'dev',
    'app.debug' => function (ContainerInterface $c) {
        $debug = getenv('APP_DEBUG');
        if ($debug === false) {
            $debug = ($c->get('app.env') === 'dev');
        }

        return filter_var($debug, FILTER_VALIDATE_BOOLEAN);
    },
    /**
     * Routing
     */
    \FastRoute\Dispatcher::class => 
        \DI\factory([\Umbra\Routing\Factory\SimpleDispatcherFactory::class, 'create'])
        ->parameter('routes', __DIR__ . "/routes.php"),
    /**
     * Request
     */
    \Psr\Http\Message\ServerRequestInterface::class => function (Psr17Factory $factory) {
        $creator = new \Nyholm\Psr7Server\ServerRequestCreator(
            $factory, $factory, $factory, $factory
        );

        return $creator->fromGlobals();
    },
    /**
     * Response
     */
    \Psr\Http\Message\ResponseInterface::class => function (Psr17Factory $factory) {
        return $factory->createResponse(200);
    },
    /**
     * Error Handler
     */
    \Umbra\Kernel\Errors\ExceptionHandlerInterface::class => \DI\get(\Umbra\Exception\Handler\ExceptionHandler::class)
];
