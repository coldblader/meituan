<?php

/**
 * 美团API-查询门店商品信息
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class ProductByType extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/product/queryproductbytype';

    private ?string $type = null;
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

    public function setType(string $type)
    {
        $this->type = $type;
        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPageNo(int $pageNo)
    {
        $this->pageNo = $pageNo ?? 1;
        return $this;
    }

    public function getPageNo()
    {
        if ($this->pageNo < 1) {
            throw new \Exception('pageNo must be greater than 0');
        }
        return $this->pageNo;
    }

    public function setPageSize(int $pageSize)
    {
        $this->pageSize = $pageSize ?? 50;
        return $this;
    }

    public function getPageSize()
    {
        if ($this->pageSize < 1 || $this->pageSize > 100) {
            throw new \Exception('pageSize must be between 1 and 100');
        }
        return $this->pageSize;
    }

    private function prepareBizParameters(): array
    {
        return [
            'type' => $this->getType(),
            'pageNo' => $this->getPageNo(),
            'pageSize' => $this->getPageSize(),
        ];
    }
    public function getProductByType()
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
