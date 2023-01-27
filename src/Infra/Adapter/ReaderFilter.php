<?php

namespace App\Infra\Adapter;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;

class ReaderFilter implements IReadFilter
{
    public function readCell($columnAddress, $row, $worksheetName = ''): bool
    {
        // Ignore the header
        if (1 === $row) {
            return false;
        }

        if (Coordinate::columnIndexFromString($columnAddress) > 5) {
            unset($this->columns[$columnAddress]);

            return false;
        }

        return true;
    }
}
