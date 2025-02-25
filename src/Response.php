<?php

namespace ColdBlader\MeiTuan;

use BadMethodCallException;
use HughCube\GuzzleHttp\LazyResponse;

class Response
{
    /**
     * @var LazyResponse
     */
    protected $httpResponse;

    public function __construct(LazyResponse $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }


    public function getHttpResponse(): LazyResponse
    {
        return $this->httpResponse;
    }

    public function getBodyArray()
    {
        return $this->httpResponse->toArray(false);
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpResponse->getStatusCode();
    }

    public function getCode()
    {
        $bodyArray = $this->getBodyArray();
        return isset($bodyArray['code']) ? $bodyArray['code'] : null;
    }

    public function getMessage()
    {
        return $this->getBodyArray()['msg'] ?? null;
    }

    public function getTimestamp()
    {
        return $this->getBodyArray()['timestamp'] ?? null;
    }

    const SUCCESS_CODE = [
        0,
        'OP_SUCCESS'
    ];


    public function isSuccess(): bool
    {
        $success_code = array_flip(self::SUCCESS_CODE);
        return isset($success_code[$this->getCode()]);
    }


    public function getData()
    {
        return $this->getBodyArray()['data'] ?? null;
    }

    public function __call($name, $arguments = [])
    {
        if (str_starts_with($name, $prefix = 'getData')) {
            $key = substr($name, strrpos($name, $prefix) + strlen($prefix));

            return $this->getBodyArray()['data'][lcfirst($key)] ?? null;
        }

        return new BadMethodCallException();
    }
}
