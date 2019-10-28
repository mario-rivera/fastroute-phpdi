<?php
namespace App\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

class SampleController
{
    public function getHome(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write('Hello World');
        return $response;
    }
}
