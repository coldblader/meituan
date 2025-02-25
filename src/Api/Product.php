<?php

/**
 * 美团API-按商品类型查询门店商品信息
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class Product extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/product/queryproduct';

    private ?int $pageNo = null;
    private ?int $pageSize = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setPageNo(int $pageNo)
    {
        $this->pageNo = $pageNo;
        return $this;
    }

    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize;
        return $this;
    }


    private function prepareBizParameters(): array
    {
        return [
            'pageNo' => $this->pageNo ?? 1,
            'pageSize' => $this->pageSize ?? 50
        ];
    }

    public function getProduct()
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
