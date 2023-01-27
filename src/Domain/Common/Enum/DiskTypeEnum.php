<?php

namespace App\Domain\Common\Enum;

enum DiskTypeEnum: string
{
    case SAS = 'SAS';
    case SATA = 'SATA';
    case SATA2 = 'SATA2';
    case SATA3 = 'SATA3';
    case SSD = 'SSD';
}
