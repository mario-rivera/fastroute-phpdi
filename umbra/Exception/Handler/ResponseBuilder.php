<?php
namespace Umbra\Exception\Handler;

use Psr\Http\Message\ServerRequestInterface;

class ResponseBuilder
{
    /**
     * @var Response\Html\HtmlResponse
     */
    private $htmlResponse;

    /**
     * @var Response\Json\JsonResponse
     */
    private $jsonResponse;

    /**
     * @var Response\Console\ConsoleResponse
     */
    private $consoleResponse;

    /**
     * @var ServerRequestInterface
     */
    private $request;

    public function __construct(
        Response\Html\HtmlResponse $htmlResponse,
        Response\Json\JsonResponse $jsonResponse,
        Response\Console\ConsoleResponse $consoleResponse,
        ServerRequestInterface $request
    ) {
        $this->htmlResponse = $htmlResponse;
        $this->jsonResponse = $jsonResponse;
        $this->consoleResponse = $consoleResponse;
        $this->request = $request;
    }

    public function respond(\Throwable $e)
    {
        if (php_sapi_name() === 'cli') {
            return $this->consoleResponse->respond($e);
        }

        $contentType = $this->request->getHeader('Content-Type');
        $responseType = (count($contentType) > 0) ? $contentType[0] : '';
        
        $accept = $this->request->getHeader('Accept');

        switch ($responseType) {
            case 'application/json':
                return $this->jsonResponse->respond($e);

            default:
                return $this->htmlResponse->respond($e);
        }
    }
}
