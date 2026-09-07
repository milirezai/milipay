<?php

namespace Mili\Milipay\FastDriver;
use Mili\Milipay\FastDriver\Storage\Storage;

class Selector
{
    public function __construct(
        protected readonly Comparison $comparison,
        protected readonly Storage $storage
    ){}
    public function fast(): string
    {
        return $this->comparison->compare($this->storage->defaultDisk()->get());
    }
}
