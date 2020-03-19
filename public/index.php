<?php
require_once(dirname(__DIR__ ) . "/config/bootstrap.php");

$app = \FrameworkBootstrap\boot();

$request = $app->container()->get(\Psr\Http\Message\ServerRequestInterface::class);
$response = $app->router()->dispatch($request);

$app->emitter()->emit($response);
