<?php

namespace App\Domain\Common;

enum DataUnitEnum: string
{
    case KB = 'KB';
    case GB = 'GB';
    case TB = 'TB';
}
