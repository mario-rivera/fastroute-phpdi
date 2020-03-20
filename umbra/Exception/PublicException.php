<?php
namespace Umbra\Exception;

use JsonSerializable;

class PublicException extends \RuntimeException implements
    PublicExceptionInterface,
    JsonSerializable
{
    public function jsonSerialize()
    {
        return [
            'error' => [
                'message' => $this->getMessage()
            ]
        ];
    }
}
