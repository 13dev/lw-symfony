<?php

namespace App\Domain\Common;
use Elao\Enum\Attribute\EnumCase;
use Elao\Enum\Attribute\ReadableEnum;
use Elao\Enum\ReadableEnumInterface;
use Elao\Enum\ReadableEnumTrait;

#[ReadableEnum(prefix: 'currency.')]
enum CurrencyEnum: string implements ReadableEnumInterface
{
    use ReadableEnumTrait;

    #[EnumCase('euro')]
    case Euro = '€';

    #[EnumCase('dollar')]
    case Dollar = '$';

}
