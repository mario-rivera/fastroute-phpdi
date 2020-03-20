<?php
namespace Umbra\Exception\Handler;

use Umbra\Kernel\Errors\ExceptionHandlerInterface;

class ExceptionHandler implements
    ExceptionHandlerInterface
{
    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    public function __construct(
        ResponseBuilder $responseBuilder
    ) {
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * @param \Throwable $error
     */
    public function handleException(\Throwable $error)
    {
        $this->respond($error);
    }

    public function respond(\Throwable $error)
    {
        $this->responseBuilder->respond($error);
    }
}
