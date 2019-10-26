<?php
require_once(dirname(__DIR__ ) . "/config/bootstrap.php");

$umbra = \UmbraBootstrap\boostrap();

$response = $umbra->dispatch();
echo $response;
