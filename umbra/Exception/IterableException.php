<?php
namespace Umbra\Exception;

use JsonSerializable;

class IterableException extends PublicException
{
    /**
     * @var iterable
     */
    private $errors;

    public function __construct(iterable $errors = [], $message = 'Multiple errors encountered', $code = 0, \Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct($message, $code, $previous);
    }

    public function jsonSerialize()
    {
        $data = parent::jsonSerialize();
        $data['error']['errors'] = $this->formatErrors();

        return $data;
    }

    public function formatErrors()
    {
        $result = [];
        
        foreach ($this->errors as $error) {
            $message = ($error instanceof JsonSerializable) ? $error : (string) $error;

            $item = ['message' => $message];
            $result[] = $item;
        }

        return $result;
    }
}
