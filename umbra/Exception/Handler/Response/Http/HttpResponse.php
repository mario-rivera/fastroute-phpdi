<?php
namespace Umbra\Exception\Handler\Response\Http;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class HttpResponse
{
    /**
     * @var ServerRequestInterface
     */
    private $request;

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * @var ResponseFilter
     */
    private $responseFilter;

    /**
     * @var HtmlResponse
     */
    private $htmlResponse;

    /**
     * @var JsonResponse
     */
    private $jsonResponse;

    public function __construct(
        ServerRequestInterface $request,
        ResponseInterface $response,
        ResponseFilter $responseFilter,
        HtmlResponse $htmlResponse,
        JsonResponse $jsonResponse
    ) {
        $this->request = $request;
        $this->response = $response;
        $this->responseFilter = $responseFilter;
        $this->htmlResponse = $htmlResponse;
        $this->jsonResponse = $jsonResponse;
    }

    public function respond(\Throwable $e)
    {
        $contentType = $this->request->getHeader('Content-Type');
        $responseType = (count($contentType) > 0) ? $contentType[0] : '';
        
        $accept = $this->request->getHeader('Accept');

        $response = $this->responseFilter->filterResponse($e, $this->response);

        switch ($responseType) {
            case 'application/json':
                return $this->jsonResponse->respond($e, $response);

            default:
                return $this->htmlResponse->respond($e, $response);
        }
    }
}
