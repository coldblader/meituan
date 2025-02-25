<?php

/**
 * 美团API-验券
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use GuzzleHttp\RequestOptions;
use ColdBlader\MeiTuan\Request\ApiRequest;

class VerifyConsume extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = 'https://api-open-cater.meituan.com/ddzh/tuangou/receipt/consume';

    private ?string $receiptCode = null;
    private ?int $count = 1;
    private ?string $requestId = null;
    private ?string $appShopAccountName = '发源地';
    private ?string $appShopAccount = 'fyd';
    private ?string $thirdDeviceId = null;
    private ?string $thirdDeviceLocation = null;
    private ?string $thirdDeviceType = null;
    private ?string $thirdDeviceCity = null;
    private ?string $thirdVenueId = null;
    private ?string $thirdLocationType = null;

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

    public function setCount(int $count)
    {
        $this->count = $count ?? 1;
        return $this;
    }

    public function getCount()
    {
        return $this->count;
    }

    public function setRequestId(string $requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }

    public function getRequestId()
    {
        if (empty($this->requestId)) {
            throw new \Exception('requestId is required');
        }
        return $this->requestId;
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

    public function setThirdDeviceId(string $thirdDeviceId)
    {
        $this->thirdDeviceId = $thirdDeviceId;
        return $this;
    }

    public function getThirdDeviceId()
    {
        return $this->thirdDeviceId;
    }

    public function setThirdDeviceLocation(string $thirdDeviceLocation)
    {
        $this->thirdDeviceLocation = $thirdDeviceLocation;
        return $this;
    }

    public function getThirdDeviceLocation()
    {
        return $this->thirdDeviceLocation;
    }

    public function setThirdDeviceType(string $thirdDeviceType)
    {
        $this->thirdDeviceType = $thirdDeviceType;
        return $this;
    }

    public function getThirdDeviceType()
    {
        return $this->thirdDeviceType;
    }

    public function setThirdDeviceCity(string $thirdDeviceCity)
    {
        $this->thirdDeviceCity = $thirdDeviceCity;
        return $this;
    }

    public function getThirdDeviceCity()
    {
        return $this->thirdDeviceCity;
    }

    public function setThirdVenueId(string $thirdVenueId)
    {
        $this->thirdVenueId = $thirdVenueId;
        return $this;
    }

    public function getThirdVenueId()
    {
        return $this->thirdVenueId;
    }


    public function setThirdLocationType(string $thirdLocationType)
    {
        $this->thirdLocationType = $thirdLocationType;
        return $this;
    }

    public function getThirdLocationType()
    {
        return $this->thirdLocationType;
    }

    private function prepareBizParameters(): array
    {
        $biz = [
            'receiptCode' => $this->getReceiptCode(),
            'count' => $this->getCount(),
            'requestId' => $this->getRequestId(),
            'appShopAccountName' => $this->getAppShopAccountName(),
            'appShopAccount' => $this->getAppShopAccount(),
        ];
        if ($this->getThirdDeviceId()) {
            $biz['thirdDeviceId'] = $this->getThirdDeviceId();
        }
        if ($this->getThirdDeviceLocation()) {
            $biz['thirdDeviceLocation'] = $this->getThirdDeviceLocation();
        }
        if ($this->getThirdDeviceType()) {
            $biz['thirdDeviceType'] = $this->getThirdDeviceType();
        }
        if ($this->getThirdDeviceCity()) {
            $biz['thirdDeviceCity'] = $this->getThirdDeviceCity();
        }
        if ($this->getThirdVenueId()) {
            $biz['thirdVenueId'] = $this->getThirdVenueId();
        }
        if ($this->getThirdLocationType()) {
            $biz['thirdLocationType'] = $this->getThirdLocationType();
        }
        return $biz;
    }


    public function getConsume()
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
