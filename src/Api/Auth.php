<?php

/**
 * 美团API-获取门店授权url
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use ColdBlader\MeiTuan\Sign;

class Auth extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://open-erp.meituan.com/general/auth';

    private ?string $state = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setState($state)
    {
        $this->state = $state;
        return $this;
    }

    public function getState()
    {
        return $this->state;
    }

    public function getAuthUrl()
    {
        $url = $this->getApiUrl();
        $params = [
            'developerId' => $this->client->getConfig()->getDeveloperId(),
            'timestamp' => time(),
            'businessId' => $this->client->getConfig()->getBusinessId(),
            'charset' => 'UTF-8',
            'state' => $this->getState(),
            'version' => $this->getVersion()
        ];
        $params['sign'] = Sign::makeSign(
            $this->client->getConfig()->getSignKey(),
            Sign::makeContent($params)
        );
        return $url . '?' . http_build_query($params);
    }
}
