<?php

use App\Domain\Common\ValueObject\PriceValueObject;
use App\Domain\Common\ValueObject\RamValueObject;
use App\Domain\Common\ValueObject\StorageValueObject;
use App\Domain\Repository\ServerRepositoryInterface;
use App\Infra\Collection\SpreadSheetCollection;
use App\Infra\Dto\ServerDto;

class ServerRepository implements ServerRepositoryInterface
{
    /**
     * @return SpreadSheetCollection<string, ServerDto>
     */
    private $dataSource;

    public function __construct(private SpreadSheetCollection $serversCollection)
    {
        $this->dataSource = $serversCollection->map(function ($element) {
            return new ServerDto(
                name: $element['name'],
                ram: RamValueObject::fromString($element['ram']),
                storage: StorageValueObject::fromString($element['storage']),
                price: PriceValueObject::fromString($element['price']),
                location: (string) $element['location'],
            );
        });
    }


}
