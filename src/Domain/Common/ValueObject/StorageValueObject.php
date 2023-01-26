<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\DataUnitEnum;
use App\Domain\Common\DiskTypeEnum;
use InvalidArgumentException;

class StorageValueObject
{
    // This regular expression limits the amount of digits and characters that can be matched,
    // making it less vulnerable to ReDOS attacks.
    private const STORAGE_REGEX_EXPR = '/(\d{1,5})(x)(\d{1,5})(\w{2})(\w{1,20})/';


    public function __construct(
        private readonly DiskTypeEnum $type,
        private readonly DataUnitEnum $unit,
        private readonly int          $capacity,

    )
    {
    }

    /**
     * @throws InvalidArgumentException
     * @param string $value
     * @return static
     */
    public static function fromString(string $value): self
    {
        $matches = [];
        preg_match(self::STORAGE_REGEX_EXPR, $value, $matches);

        [$quantity, $capacity, $unit, $type] = $matches;

        if (empty($matches) || !isset($quantity, $capacity, $unit, $type)) {
            throw new InvalidArgumentException('Invalid storage format.');
        }

        if (!$type = DiskTypeEnum::tryFrom($type)) {
            throw new InvalidArgumentException('Invalid storage type.');
        }

        if (!$unit = DataUnitEnum::tryFrom($unit)) {
            throw new InvalidArgumentException('Invalid storage data unit.');
        }

        return new self(
            type: $type,
            unit: $unit,
            capacity: $quantity * $capacity
        );
    }

    public function getCapacity(): int
    {
        return $this->capacity;
    }

    public function getUnit(): DataUnitEnum
    {
        return $this->unit;
    }

    public function getType(): DiskTypeEnum
    {
        return $this->type;
    }

}
