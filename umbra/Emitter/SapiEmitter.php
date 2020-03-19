<?php
namespace Umbra\Emitter;

use Psr\Http\Message\ResponseInterface;
use Zend\HttpHandlerRunner\Emitter\SapiEmitter as ZendEmitter;

class SapiEmitter
{
    /**
     * @var ZendEmitter
     */
    private $emitter;

    public function __construct(
        ZendEmitter $emitter
    ) {
        $this->emitter = $emitter;
    }

    public function emit(ResponseInterface $response)
    {
        return $this->emitter->emit($response);
    }
}
