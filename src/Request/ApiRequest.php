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
        $request = [];
        if (isset($this->parameters['appAuthToken'])) {
            $request['appAuthToken'] = $this->parameters['appAuthToken'] ?? '';
        }
        if (isset($this->parameters['biz'])) {
            $request['biz'] = json_encode($this->parameters['biz'] ?? [], JSON_UNESCAPED_UNICODE);
        }
        if (isset($this->parameters['version'])) {
            $request['version'] = $this->parameters['version'] ?? null;
        }
        if (isset($this->parameters['grantType'])) {
            $request['grantType'] = $this->parameters['grantType'] ?? '';
        }
        if (isset($this->parameters['code'])) {
            $request['code'] = $this->parameters['code'] ?? '';
        }
        if (isset($this->parameters['refreshToken'])) {
            $request['refreshToken'] = $this->parameters['refreshToken'] ?? '';
        }
        return $request;
    }
}
