<?php

namespace App\Infra\Dto;

use App\Domain\Common\ValueObject\PriceValueObject;
use App\Domain\Common\ValueObject\RamValueObject;
use App\Domain\Common\ValueObject\StorageValueObject;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class ServerDto
{
    public function __construct(
        private readonly string $name,
        private readonly RamValueObject $ram,
        private readonly StorageValueObject $storage,
        private readonly PriceValueObject $price,
        private readonly string $location,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRam(): RamValueObject
    {
        return $this->ram;
    }

    public function getStorage(): StorageValueObject
    {
        return $this->storage;
    }

    public function getPrice(): PriceValueObject
    {
        return $this->price;
    }

    public function getLocation(): string
    {
        return $this->location;
    }
}
