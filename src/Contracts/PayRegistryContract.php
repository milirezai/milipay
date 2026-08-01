<?php

namespace Milipay\Contracts;

interface PayRegistryContract
{
    public function drivers(array $drivers): self;
    public function getDrivers(): array;

    public function adapters(array $adapters): self;
    public function getAdapters(): array;

    public function facades(array $facades): self;
    public function getFacades(): array;

    public function commands(array $commands): self;
    public function getCommands(): array;

    public function pipes(array $pipes): self;
    public function getPipes(): array;
    public function payloadBuilders(array $payloadBuilder): self;
    public function getPayloadBuilders(): array;

}
