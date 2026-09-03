<?php

namespace Mili\Milipay\Contracts;
interface Storage
{
    public function save(array $data): void;
    public function get();
    public function refresh(): void;
}
