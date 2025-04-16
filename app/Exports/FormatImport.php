<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class FormatImport implements WithHeadings
{
    protected $headings;

    public function __construct( array $headings)
    {
        $this->headings = $headings;
    }

    public function headings(): array
    {
        return $this->headings;
    }
}
