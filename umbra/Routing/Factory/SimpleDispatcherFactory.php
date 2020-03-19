<?php
namespace Umbra\Routing\Factory;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

class SimpleDispatcherFactory
{
    public function create($routes): Dispatcher
    {
        $dispatcher = simpleDispatcher(function(RouteCollector $router) use ($routes) {
            require_once($routes);
        });

        return $dispatcher;
    }
}
