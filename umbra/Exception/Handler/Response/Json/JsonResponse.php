<?php
namespace Umbra\Exception\Handler\Response\Json;

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class JsonResponse
{
    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var SapiEmitter
     */
    private $emitter;

    public function __construct(
        ResponseInterface $response,
        SapiEmitter $sapiEmitter
    ) {
        $this->response = $response;
        $this->emitter = $sapiEmitter;
    }

    public function respond(\Throwable $e)
    {
        $message = [
            'error' => $e->getMessage(),
            'debug' => [
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]
        ];

        $response = $this->response
        ->withStatus(500)
        ->withHeader('Content-Type', 'application/json');

        $response->getBody()->write(json_encode($message));

        $this->emitter->emit($response);
    }
}
