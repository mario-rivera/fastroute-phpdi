<?php
namespace Umbra\Kernel\ErrorHandler;

class ErrorHandler implements
    ErrorHandlerInterface
{
    /**
     * @param \Throwable $e
     */
    public function handleException(\Throwable $e)
    {
        die($e->getMessage());
    }
}
