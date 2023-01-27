<?php

declare(strict_types=1);

namespace App\Domain\Common\ValueObject;

use App\Domain\Common\Enum\CurrencyEnum;
use InvalidArgumentException;
use JetBrains\PhpStorm\Immutable;
use JsonSerializable;

#[Immutable]
final class PriceValueObject implements JsonSerializable
{
    // Match any string that starts with € or $ and then followed by one or more digits,
    // with the possibility of a , or . and two digits at the end,
    // it allows for values that might have 4 digits before the decimal point.
    // SUPPORTED_CURRENCY will be replaced with supported currency.
    private const PRICE_REGEX_EXPR = '/(?i)([SUPPORTED_CURRENCY])(\d+(?:[.,]\d{2})?)/u';

    public function __construct(
        private readonly float        $value,
        private readonly CurrencyEnum $currency
    )
    {
    }

    public static function fromString(string $price): self
    {
        $matches = [];
        preg_match(self::buildRegexExpr(), $price, $matches);



        if (empty($matches) || !isset($matches[1], $matches[2])) {

            throw new InvalidArgumentException('Invalid price format');
        }

        if (!$parsedCurrency = CurrencyEnum::tryFrom($matches[1])) {
            throw new InvalidArgumentException('Unknown currency');
        }
        return new self(
            value: (float) $matches[2],
            currency: $parsedCurrency
        );
    }

    public function getCurrency(): CurrencyEnum
    {
        return $this->currency;
    }

    public function getValue(): float
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->currency->value . $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->__toString();
    }

    private static function buildRegexExpr(): string
    {
        return str_replace(
            search: 'SUPPORTED_CURRENCY',
            replace: implode('', array_column(CurrencyEnum::cases(), 'value')),
            subject: self::PRICE_REGEX_EXPR
        );
    }


}
