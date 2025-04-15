<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UniversalImport implements ToModel, WithHeadingRow
{
    protected $modelClass;
    protected $fields;

    public function __construct(string $modelClass, array $fields)
    {
        $this->modelClass = $modelClass;
        $this->fields = $fields;
    }

    public function model(array $row)
    {
        $data = [];
        foreach ($this->fields as $field) {
            $data[$field] = $row[$field] ?? null;
        }

        return new $this->modelClass($data);
    }
}
