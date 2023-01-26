<?php

namespace App\Infra\Collection;

use Iterator;

class SpreadSheetCollection
{
    public function __construct(private Iterator $data)
    {
    }

    public static function from(Iterator $data)
    {
        return new self($data);
    }

    public function map(callable $func): self
    {
        foreach ($this->data as $key => $value) {
            $this->data[$key] = $func($value);
        }

        return $this;
    }
}
