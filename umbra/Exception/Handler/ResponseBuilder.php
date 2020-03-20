<?php
namespace Umbra\Exception\Handler;

class ResponseBuilder
{
    /**
     * @var Response\Http\HttpResponse
     */
    private $httpResponse;

    /**
     * @var Response\Console\ConsoleResponse
     */
    private $consoleResponse;

    public function __construct(
        Response\Http\HttpResponse $httpResponse,
        Response\Console\ConsoleResponse $consoleResponse
    ) {
        $this->httpResponse = $httpResponse;
        $this->consoleResponse = $consoleResponse;
    }

    public function respond(\Throwable $e)
    {
        if (php_sapi_name() === 'cli') {
            $this->consoleResponse->respond($e);
        } else {
            $this->httpResponse->respond($e);
        }
    }
}
