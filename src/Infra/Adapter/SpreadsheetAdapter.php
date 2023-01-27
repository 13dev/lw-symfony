<?php

namespace App\Infra\Adapter;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SpreadsheetAdapter
{
    private readonly Spreadsheet $phpSpreadSheetInstance;

    public function __construct(
        private readonly string $filename,
    ) {
        $reader = IOFactory::createReader(IOFactory::READER_XLSX);
        $reader->setReadDataOnly(true);
        $reader->setReadEmptyCells(false);
        $reader->setLoadSheetsOnly('Sheet2');

        $this->phpSpreadSheetInstance = $reader->load($this->filename);
    }

    public function getActiveSheet(): Worksheet
    {
        return $this->phpSpreadSheetInstance->getActiveSheet();
    }

    public function toArray(): array
    {
        $activeSheet = $this->getActiveSheet();

        return $activeSheet->rangeToArray(
            range: 'A2:E'.$activeSheet->getHighestRow(),
            nullValue: false,
            calculateFormulas: false,
            formatData: false,
        );
    }
}
