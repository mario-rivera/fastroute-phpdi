<?php
require_once(dirname(__DIR__ ) . "/config/bootstrap.php");

$app = \UmbraBootstrap\boostrap();

$request = $app->get(\Psr\Http\Message\ServerRequestInterface::class);
$response = $app->dispatch($request);

$app->emit($response);
