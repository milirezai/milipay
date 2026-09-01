<?php

namespace Mili\Milipay\FastDriver\Contracts;
interface Storage
{
    public function save(array $data): void;
    public function get();
}
