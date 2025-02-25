<?php

/**
 * 美团API-查询已验券信息
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class VerificationConsume extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/receipt/getconsumed';

    private ?string $receiptCode = null;

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setReceiptCode(string $receiptCode)
    {
        $this->receiptCode = $receiptCode;
        return $this;
    }


    public function getReceiptCode()
    {
        if (empty($this->receiptCode)) {
            throw new \Exception('receiptCode is required');
        }
        return $this->receiptCode;
    }

    private function prepareBizParameters(): array
    {
        return [
            'receiptCode' => $this->getReceiptCode()
        ];
    }

    public function getVerificationConsume()
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
