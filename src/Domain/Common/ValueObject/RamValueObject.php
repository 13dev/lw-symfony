<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Enum\DataUnitEnum;
use App\Domain\Common\Enum\RamTypeEnum;
use JetBrains\PhpStorm\Immutable;

#[Immutable]
class RamValueObject
{
    private const RAM_REGEX_EXPR = '/(\d+)(\w{2})(\w+)/';

    public function __construct(
        private readonly RamTypeEnum $type,
        private readonly DataUnitEnum $unit,
        private readonly int $capacity,
    ) {
    }

    public static function fromString(string $value): self
    {
        $matches = [];
        preg_match(self::RAM_REGEX_EXPR, $value, $matches);

        [$_, $capacity, $dataUnit, $type] = $matches;

        if (empty($matches) || !isset($capacity, $dataUnit, $type)) {
            throw new \InvalidArgumentException('Invalid ram format.');
        }

        if (!$dataUnit = DataUnitEnum::tryFrom($dataUnit)) {
            throw new \InvalidArgumentException('Unknown data unit.');
        }

        if (!$type = RamTypeEnum::tryFrom($type)) {
            throw new \InvalidArgumentException('Unknown ram type.');
        }

        return new self(
            type: $type,
            unit: $dataUnit,
            capacity: (int) $capacity,
        );
    }

    public function getUnit(): DataUnitEnum
    {
        return $this->unit;
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getType(): RamTypeEnum
    {
        return $this->type;
    }
}
