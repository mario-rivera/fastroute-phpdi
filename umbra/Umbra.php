<?php
namespace Umbra;

use DI\Container;
use FastRoute\Dispatcher;

class Umbra
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

    /**
     * @param string $definition
     */
    public function get(string $definition)
    {
        return $this->container->get($definition);
    }

    public function dispatch()
    {
        // Fetch method and URI from somewhere
        $httpMethod = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri = rawurldecode($uri);

        $routeInfo = $this->dispatcher->dispatch($httpMethod, $uri);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                // ... 404 Not Found
                throw new \Exception('Not found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                throw new \Exception('Method not Allowed');
                // ... 405 Method Not Allowed
                break;
            case Dispatcher::FOUND:
                $handler = $routeInfo[1];
                $parameters = $routeInfo[2];
                return $this->container->call($handler, $parameters);
                break;
        }
    }
}
