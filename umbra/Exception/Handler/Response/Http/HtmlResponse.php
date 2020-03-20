<?php
namespace Umbra\Exception\Handler\Response\Http;

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter;

class HtmlResponse
{
    /**
     * @var SapiEmitter
     */
    private $emitter;

    public function __construct(
        SapiEmitter $sapiEmitter
    ) {
        $this->emitter = $sapiEmitter;
    }

    public function respond(\Throwable $e, ResponseInterface $response)
    {
        switch ($response->getStatusCode()) {
            case 404:
                ob_start();
                require_once(__DIR__ . '/templates/404.phtml');
                $message = ob_get_contents();
                ob_end_clean();
            break;

            default:
                ob_start();
                require_once(__DIR__ . '/templates/500.phtml');
                $message = ob_get_contents();
                ob_end_clean();
            break;
        }

        $response = $response
        ->withHeader('Content-Type', 'text/html');

        $response->getBody()->write($message);

        $this->emitter->emit($response);
    }
}
