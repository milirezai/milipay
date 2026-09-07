<?php

namespace Mili\Milipay\FastDriver;

use Mili\Milipay\Exceptions\MilipayException;

class Comparison
{
    public function compare(array $data): string
    {
        $sumTime = [];
        foreach ($data as $driver => $times){
            $times = array_filter($times, fn ($time) => $time !== null);
            if (empty($times))
                continue;
            $sumTime[$driver] = $this->resolveTime($times) / count($times);
        }
        if (empty($sumTime))
            throw new MilipayException('no successful probe result found for fast driver');

        return array_search(min($sumTime), $sumTime);
    }
    private function resolveTime(array $times): int
    {
        return array_sum(array_values($times));
    }
}