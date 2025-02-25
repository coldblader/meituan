<?php

/**
 * 美团API-撤销验券
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class ReverseConsume extends AbstractApi
{
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/receipt/reverseconsume';
    private const VERSION = 2;

    private ?string $receiptCode = null;
    private ?string $dealId = null;
    private ?string $appShopAccountName = '发源地';
    private ?string $appShopAccount = 'fyd';

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

    public function setDealId(string $dealId)
    {
        $this->dealId = $dealId;
        return $this;
    }

    public function getDealId()
    {
        if (empty($this->dealId)) {
            throw new \Exception('dealId is required');
        }
        return $this->dealId;
    }

    public function setAppShopAccountName(string $appShopAccountName)
    {
        $this->appShopAccountName = $appShopAccountName ?? '发源地';
        return $this;
    }

    public function getAppShopAccountName()
    {
        return $this->appShopAccountName;
    }

    public function setAppShopAccount(string $appShopAccount)
    {
        $this->appShopAccount = $appShopAccount ?? 'fyd';
        return $this;
    }

    public function getAppShopAccount()
    {
        return $this->appShopAccount;
    }

    private function prepareBizParameters(): array
    {
        return [
            'receiptCode' => $this->getReceiptCode(),
            'dealId' => $this->getDealId(),
            'appShopAccountName' => $this->getAppShopAccountName(),
            'appShopAccount' => $this->getAppShopAccount(),
        ];
    }

    public function getReverseConsume()
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
