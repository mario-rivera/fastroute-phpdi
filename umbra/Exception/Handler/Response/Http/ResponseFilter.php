<?php
namespace Umbra\Exception\Handler\Response\Http;

use Psr\Http\Message\ResponseInterface;

use Umbra\Routing\Exception\RouteNotFoundException;
use Umbra\Routing\Exception\MethodNotAllowedException;

class ResponseFilter
{
    public function filterResponse(\Throwable $e, ResponseInterface $response): ResponseInterface
    {
        $filteredResponse = $response->withStatus(500);

        switch ($e) {
            case $e instanceof RouteNotFoundException:
                $filteredResponse = $filteredResponse->withStatus(404);
            break;

            case $e instanceof MethodNotAllowedException:
                $filteredResponse = $filteredResponse->withStatus(405);
            break;
        }

        return $filteredResponse;
    }
}
