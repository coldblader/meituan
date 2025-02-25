<?php

namespace ColdBlader\MeiTuan\Request;

class ApiRequest
{
    private array $parameters = [];
    
    public function setParameter(string $key, $value): self
    {
        $this->parameters[$key] = $value;
        return $this;
    }
    
    public function getParameters(): array
    {
        return $this->parameters;
    }
    
    public function toArray(): array
    {
        return [
            'appAuthToken' => $this->parameters['appAuthToken'] ?? '',
            'biz' => json_encode($this->parameters['biz'] ?? [], JSON_UNESCAPED_UNICODE),
            'version' => $this->parameters['version'] ?? null
        ];
    }
} 