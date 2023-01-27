<?php

namespace App\Infra\Iterator;

use App\Infra\Adapter\SpreadsheetAdapter;
use Iterator;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/** @deprecated Not using iterator since it is loading more data in memory */
final class SpreadsheetIterator implements Iterator
{
    private const NUM_COLUMNS = 5;
    private const ROW_OFFSET = 2;

    private int $pos = 0;
    private readonly Worksheet $data;

    public function __construct(
        private readonly SpreadsheetAdapter $phpSpreadsheetAdapter,
    )
    {
        $this->data = $this->phpSpreadsheetAdapter->getActiveSheet();
    }

    public function current(): array
    {
        $worksheetData = [];
        foreach (range(1, self::NUM_COLUMNS) as $col) {
            $worksheetData[] = $this->data->getCell([$col, $this->pos + self::ROW_OFFSET])->getValue();
        }

        return [
            'name' => $worksheetData[0],
            'ram' => $worksheetData[1],
            'storage' => $worksheetData[2],
            'price' => $worksheetData[3],
            'location' => $worksheetData[4],
        ];

    }

    public function next(): void
    {
        $this->pos++;
    }

    public function key(): int
    {
        return $this->pos;
    }

    public function valid(): bool
    {
        return is_array($this->current());
    }

    public function rewind(): void
    {
        $this->pos = 0;
    }

}
