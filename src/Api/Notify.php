<?php

/**
 * 美团API-回调通知
 * @author 寒锋
 * @email 750493919@qq.com
 * @date 2025-02-21 15:20:10
 */

namespace ColdBlader\MeiTuan\Api;

use Exception;
use ColdBlader\MeiTuan\Sign;

class Notify extends AbstractApi
{
    private const VERSION = 2;
    private const API_URL = '';

    private array $data = [];

    public function getVersion(): int
    {
        return self::VERSION;
    }

    public function getApiUrl(): string
    {
        return self::API_URL;
    }

    public function setData(array $data): self
    {
        $this->data = $data;
        return $this;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function verify()
    {
        $data = $this->getData();
        $sign = $data['sign'];
        $new_sing = Sign::makeSign(
            $this->client->getConfig()->getSignKey(),
            Sign::makeContent($data)
        );
        if ($sign !== $new_sing) {
            throw new Exception('签名错误');
        }
        return $data;
    }

    public function success()
    {
        return [
            'code' => 0,
            'message' => 'success',
        ];
    }

    public function fail(string $message = '')
    {
        return [
            'code' => 1,
            'message' => $message ?? 'fail',
        ];
    }
}
