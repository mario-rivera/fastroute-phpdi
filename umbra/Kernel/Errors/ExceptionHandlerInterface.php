<?php
namespace Umbra\Kernel\Errors;

interface ExceptionHandlerInterface
{
    /**
     * @param \Throwable $error
     */
    public function handleException(\Throwable $error);
}
