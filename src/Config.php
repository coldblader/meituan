<?php

namespace ColdBlader\MeiTuan;

use GuzzleHttp\RequestOptions;

class Config
{
    protected array $config = [];

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    public function getDeveloperId(): int
    {
        return $this->config['developerId'] ?? 0;
    }

    public function getSignKey(): string
    {
        return $this->config['signKey'] ?? '';
    }

    public function getBusinessId(): int
    {
        return $this->config['businessId'] ?? 0;
    }

    public function enableDebug(): bool
    {
        return boolval($this->config['debug'] ?? false);
    }

    public function getHttp(): array
    {
        return array_merge($this->getDefaultHttp(), $this->config['Http'] ?? []);
    }

    public function getDefaultHttp(): array
    {
        return [
            RequestOptions::TIMEOUT         => 10.0,
            RequestOptions::CONNECT_TIMEOUT => 10.0,
            RequestOptions::READ_TIMEOUT    => 10.0,
            RequestOptions::HEADERS         => ['User-Agent' => null],
        ];
    }
}