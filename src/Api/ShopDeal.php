<?php

/**
 * 美团API-查询门店团购信息
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class ShopDeal extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/deal/queryshopdeal';
    
    private ?string $source = null;
    private ?int $offset = null;
    private ?int $limit = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }
    
    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setSource(?string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function setOffset(?int $offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    public function setLimit(?int $limit): self
    {
        $this->limit = $limit;
        return $this;
    }

    private function prepareBizParameters(): array
    {
        return [
            'source' => $this->source ?? 2,
            'offset' => $this->offset ?? 0,
            'limit' => $this->limit ?? 50,
        ];
    }

    public function getShopDeal(): array
    {
        $request = new ApiRequest();
        $request->setParameter('appAuthToken', $this->accessToken)
                ->setParameter('biz', $this->prepareBizParameters())
                ->setParameter('version', $this->getVersion());

        $params = [
            RequestOptions::FORM_PARAMS => $request->toArray()
        ];
        
        $response = $this->client->request(
            'POST', 
            $this->getApiUrl(), 
            $params, 
            $this->isCheckSuccess
        );
        
        return $response->getBodyArray();
    }
}
