<?php
namespace Umbra\Exception\Handler\Response\Console;

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class ConsoleResponse
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
        $message = "ERROR_MESSAGE: {$e->getMessage()}" . PHP_EOL;

        $message .= "FILE: {$e->getFile()}" . PHP_EOL;
        $message .= "LINE: {$e->getLine()}" . PHP_EOL;

        $this->response->getBody()->write($message);
        $this->emitter->emit($this->response);
    }
}
