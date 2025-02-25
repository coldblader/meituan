<?php

namespace ColdBlader\MeiTuan\Api;

use ColdBlader\MeiTuan\Client;
use ColdBlader\MeiTuan\Contracts\ApiInterface;

abstract class AbstractApi implements ApiInterface
{
    protected Client $client;
    protected ?string $accessToken = null;
    protected bool $isCheckSuccess = true;

    public function __construct(Client $client, ?string $accessToken = null)
    {
        $this->client = $client;
        $this->accessToken = $accessToken;
    }

    public function setIsCheckSuccess(bool $isCheckSuccess): self
    {
        $this->isCheckSuccess = $isCheckSuccess;
        return $this;
    }

    abstract public function getApiUrl(): string;
    abstract public function getVersion(): int;
}
