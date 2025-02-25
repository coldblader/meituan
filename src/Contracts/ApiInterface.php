<?php

namespace ColdBlader\MeiTuan\Contracts;

interface ApiInterface
{
    public function getVersion(): int;
    public function getApiUrl(): string;
    public function setIsCheckSuccess(bool $isCheckSuccess): self;
} 