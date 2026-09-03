<?php

namespace Mili\Milipay\FastDriver;

class Comparison
{
    public function compare(array $data): string
    {
        $sumTime= [];
        foreach ($data as $driver => $times){
            $sumTime[$driver] = $this->resolveTime($times) / count($times);
        }
        foreach ($sumTime as $driver => $time){
            if (min($sumTime)==$time)
                return $driver;
        }
    }
    private function resolveTime(array $times): int
    {
        return array_sum(array_values($times));
    }
}
