<?php
namespace Umbra\Routing;

use Psr\Http\Message\ServerRequestInterface;

use DI\Container;
use FastRoute\Dispatcher;

class Router
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var Dispatcher
     */
    private $dispatcher;

    public function __construct(
        Container $container,
        Dispatcher $dispatcher
    ) {
        $this->container = $container;
        $this->dispatcher = $dispatcher;
    }

    public function dispatch(ServerRequestInterface $request)
    {
        $routeInfo = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                throw new Exception\RouteNotFoundException('Route not found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                // ... 405 Method Not Allowed
                $allowedMethods = $routeInfo[1];
                throw new Exception\MethodNotAllowedException('Method not Allowed');
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $parameters = $routeInfo[2];
                return $this->container->call($handler, $parameters);
                break;
        }
    }
}
