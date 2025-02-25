<?php

/**
 * 美团API-刷新授权access_token
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class RefreshToken extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/oauth/refresh';

    private ?string $refreshToken = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setRefreshToken(string $refreshToken): self
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    public function getRefreshToken(): string
    {
        if (empty($this->refreshToken)) {
            throw new \Exception('refreshToken is required');
        }
        return $this->refreshToken;
    }


    public function refreshToken()
    {
        $request = new ApiRequest();
        $request->setParameter('grantType', 'refresh_token')
            ->setParameter('refreshToken', $this->getRefreshToken());
        $params = [
            RequestOptions::FORM_PARAMS => $request->toArray()
        ];
        $response = $this->client->request('POST', $this->getApiUrl(), $params, $this->isCheckSuccess);
        return $response->getBodyArray();
    }
}
