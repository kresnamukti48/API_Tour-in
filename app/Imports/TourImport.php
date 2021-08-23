<?php

namespace App\Imports;

use App\Models\Tour;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class TourImport implements ToModel
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Tour([
            'tour_name' => $row[1],
            'regency_id' => $row[2],
            'province_id' => $row[3],
            'user_id' => $row[4],
            'tour_address' => $row[5],
        ]);
    }
}
