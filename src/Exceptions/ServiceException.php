<?php

namespace ColdBlader\MeiTuan\Exceptions;

use ColdBlader\MeiTuan\Response;

class ServiceException extends Exception{

    protected $response;

    public function __construct(Response $response, string $message = '', int $code = 0, $previous = null)
    {
        $this->response = $response;
        parent::__construct($message, $code, $previous);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }

    public function getResponseCode()
    {
        return $this->getResponse()->getCode();
    }
}
