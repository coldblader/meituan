<?php

/**
 * 美团API-获取门店授权access_token
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:16:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class AccessToken extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/oauth/token';

    private ?string $code = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getCode(): string
    {
        if (empty($this->code)) {
            throw new \Exception('code is required');
        }
        return $this->code;
    }

    public function getToken()
    {
        $request = new ApiRequest();
        $request->setParameter('grantType', 'authorization_code')
            ->setParameter('code', $this->getCode());
        $params = [
            RequestOptions::FORM_PARAMS => $request->toArray()
        ];
        $response = $this->client->request('POST', $this->getApiUrl(), $params, $this->isCheckSuccess);
        return $response->getBodyArray();
    }
}
