<?php

/**
 * 美团API-验券记录
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class Verification extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/receipt/querylistbydate';

    private ?string $date = null;
    private ?int $offset = 0;
    private ?int $limit = 50;
    private ?int $type = 0;
    private ?int $bizType = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setDate(string $date)
    {
        $this->date = $date;
        return $this;
    }

    public function setOffset(int $offset)
    {
        $this->offset = $offset ?? 0;
        return $this;
    }

    public function setLimit(int $limit)
    {
        $this->limit = $limit ?? 50;
        return $this;
    }

    public function setType(int $type)
    {
        $this->type = $type ?? 0;
        return $this;
    }

    public function setBizType(int $bizType)
    {
        $this->bizType = $bizType;
        return $this;
    }

    public function getDate()
    {
        if (empty($this->date)) {
            throw new \Exception('date is required');
        }
        return $this->date;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getBizType()
    {
        return $this->bizType;
    }

    private function prepareBizParameters(): array
    {
        $biz = [
            'date' => $this->getDate(),
            'offset' => $this->getOffset(),
            'limit' => $this->getLimit(),
            'type' => $this->getType()
        ];
        if ($this->getBizType()) {
            $biz['bizType'] = $this->getBizType();
        }
        return $biz;
    }

    public function getVerification()
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
