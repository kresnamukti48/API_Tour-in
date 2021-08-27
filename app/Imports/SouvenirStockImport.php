<?php

namespace App\Imports;

use App\Models\SouvenirStock;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class SouvenirStockImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new SouvenirStock([
            'user_id' => $row[1],
            'souvenir_id' => $row[2],
            'date' => $row[3],
            'qty_in' => $row[4],
            'qty_out' => $row[5],
            'note' => $row[5],
        ]);
    }
}
