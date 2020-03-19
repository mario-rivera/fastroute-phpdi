<?php
namespace Umbra\Kernel\ErrorHandler;

interface ErrorHandlerInterface
{
    /**
     * @param \Throwable $e
     */
    public function handleException(\Throwable $e);
}
