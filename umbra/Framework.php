<?php
namespace Umbra;

use DI\Container;

use Umbra\Routing\Router;
use Umbra\Emitter\SapiEmitter;

class Framework
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
     * @return Container
     */
    public function container(): Container
    {
        return $this->container;
    }

    /**
     * @return Router
     */
    public function router(): Router
    {
        return $this->container()->get(Router::class);
    }

    /**
     * @return SapiEmitter
     */
    public function emitter(): SapiEmitter
    {
        return $this->container()->get(SapiEmitter::class);
    }
}
