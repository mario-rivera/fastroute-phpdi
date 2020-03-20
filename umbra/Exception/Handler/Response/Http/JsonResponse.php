<?php
namespace Umbra\Exception\Handler\Response\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

use Umbra\Exception\PublicExceptionInterface;
use JsonSerializable;

class JsonResponse
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var SapiEmitter
     */
    private $emitter;

    public function __construct(
        ContainerInterface $container,
        SapiEmitter $sapiEmitter
    ) {
        $this->container = $container;
        $this->emitter = $sapiEmitter;
    }

    public function respond(\Throwable $e, ResponseInterface $response)
    {
        $debug = $this->container->get('app.debug');

        $data = ['error' => 'Unknown error'];

        if ($e instanceof PublicExceptionInterface) {
            $data = ($e instanceof JsonSerializable) ? $e->jsonSerialize() : ['error' => $e->getMessage()];
        }

        if (is_array($data) && $debug) {
            $data['debug'] = [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ];
        }

        $response = $response
        ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(json_encode($data));

        $this->emitter->emit($response);
    }
}
