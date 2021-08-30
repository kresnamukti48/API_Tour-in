<?php

namespace App\Imports;

use App\Models\SouvenirStock;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SouvenirStockImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new SouvenirStock([
            'user_id' => $row['Nama User'],
            'souvenir_id' => $row['Nama Souvenir'],
            'date' => $row['Tanggal'],
            'qty_in' => $row['Jumlah Masuk'],
            'qty_out' => $row['Jumlah Keluar'],
            'note' => $row['Catatan'],
        ]);
    }
}
