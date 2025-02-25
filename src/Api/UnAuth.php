<?php

/**
 * 美团API-解除授权
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:15:57
 */

namespace ColdBlader\MeiTuan\Api;

use ColdBlader\MeiTuan\Sign;

class UnAuth extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://open-erp.meituan.com/general/unauth';

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }


    public function getAuthUrl()
    {
        $url = $this->getApiUrl();
        $params = [
            'developerId' => $this->client->getConfig()->getDeveloperId(),
            'timestamp' => time(),
            'businessId' => $this->client->getConfig()->getBusinessId(),
            'charset' => 'UTF-8'
        ];
        $params['sign'] = Sign::makeSign(
            $this->client->getConfig()->getSignKey(),
            Sign::makeContent($params)
        );
        return $url . '?' . http_build_query($params);
    }
}
