<?php

namespace App\Infra\Adapter;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Contracts\Service\Attribute\Required;

class SpreadsheetAdapter
{
    private readonly Spreadsheet $phpSpreadSheetInstance;

    public function __construct(
        private readonly string $filename,
    )
    {
        $this->phpSpreadSheetInstance = IOFactory::load($this->filename);
    }

    public function getActiveSheet(): Worksheet
    {
        return $this->phpSpreadSheetInstance->getActiveSheet();
    }


}
