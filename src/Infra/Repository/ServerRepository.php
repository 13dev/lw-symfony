<?php

namespace App\Infra\Repository;

use App\Domain\Common\ValueObject\PriceValueObject;
use App\Domain\Common\ValueObject\RamValueObject;
use App\Domain\Common\ValueObject\StorageValueObject;
use App\Domain\Repository\ServerRepositoryInterface;
use App\Infra\Adapter\SpreadsheetAdapter;
use App\Infra\Dto\ServerDto;
use App\Infra\Iterator\SpreadsheetIterator;
use Doctrine\Common\Collections\ArrayCollection;

class ServerRepository implements ServerRepositoryInterface
{
    public function __construct(private SpreadsheetAdapter $spreadsheetAdapter)
    {
        $this->data()->map(function ($element) {
            return new ServerDto(
                name: $element[0],
                ram: RamValueObject::fromString($element[1]),
                storage: StorageValueObject::fromString($element[2]),
                price: PriceValueObject::fromString($element[4]),
                location: (string)$element[3],
            );
        });
    }


    private function data()
    {
        return new ArrayCollection($this->spreadsheetAdapter->getData());
    }


}
