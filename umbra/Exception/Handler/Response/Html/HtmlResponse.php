<?php
namespace Umbra\Exception\Handler\Response\Html;

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class HtmlResponse
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
        $message = $e->getMessage();

        $response = $this->response
        ->withStatus(500)
        ->withHeader('Content-Type', 'text/html');

        $response->getBody()->write($message);

        $this->emitter->emit($response);
    }
}
