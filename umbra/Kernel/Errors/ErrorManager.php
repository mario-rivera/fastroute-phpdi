<?php
namespace Umbra\Kernel\Errors;

class ErrorManager
{
    /**
     * @var ExceptionHandlerInterface
     */
    private $errorHandler;

    public function __construct(
        ExceptionHandlerInterface $errorHandler
    ) {
        $this->errorHandler = $errorHandler;
    }

    /**
     * @see https://www.php.net/manual/en/function.set-error-handler.php
     * @see https://www.php.net/manual/en/function.set-exception-handler.php
     * 
     * @return void
     */
    public function boot()
    {
        set_error_handler([$this, 'onError']);
        set_exception_handler([$this, 'onException']);
    }

    /**
     * @param int $errno
     * @param string $errstr
     * @param string|null $errfile
     * @param int|null $errline
     * @param array|null $errcontext
     */
    public function onError(int $errno, string $errstr, ?string $errfile, ?int $errline, ?array $errcontext)
    {
        // Determine if this error is one of the enabled ones in php config (php.ini, .htaccess, etc)
        $error_is_enabled = (bool)($errno & ini_get('error_reporting') );

        // -- FATAL ERROR
        // throw an Error Exception, to be handled by whatever Exception handling logic is available in this context
        if( in_array($errno, array(E_USER_ERROR, E_RECOVERABLE_ERROR)) && $error_is_enabled ) {
            throw new \ErrorException($errstr, $errno, $errno, $errfile, $errline);
        }

        // -- NON-FATAL ERROR/WARNING/NOTICE
        // Log the error if it's enabled, otherwise just ignore it
        // else if( $error_is_enabled ) {
        //     error_log($errstr, 0);
        // }

        throw new \ErrorException($errstr, $errno, $errno, $errfile, $errline);
    }

    /**
     * @param \Throwable $e
     */
    public function onException(\Throwable $e)
    {
        $this->errorHandler->handleException($e);
    }
}
