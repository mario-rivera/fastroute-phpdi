<?php
namespace Umbra;

use DI\Container;
use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class Umbra
{
    /**
     * @var Container
     */
    private $container;

    public function __construct(
        Container $container
    ) {
        $this->container = $container;
    }

    /**
     * @param string $definition
     */
    public function get(string $definition)
    {
        return $this->container->get($definition);
    }

    public function dispatch(ServerRequestInterface $request)
    {
        $dispatcher = $this->container->get(Dispatcher::class);
        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

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

    public function emit(ResponseInterface $response)
    {
        $emitter = $this->container->get(\Zend\HttpHandlerRunner\Emitter\SapiEmitter::class);
        $emitter->emit($response);
    }
}
