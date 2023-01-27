<?php

namespace App\Infra\Adapter;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Reader\IReadFilter;
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

    public function getData(): array
    {
        return $this->getActiveSheet()->rangeToArray(
            'A2:' . 'E' . $this->getActiveSheet()->getHighestRow(),
            nullValue: false,
            calculateFormulas: false,
            formatData: false,
        );
    }


}
