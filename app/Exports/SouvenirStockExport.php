<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SouvenirStockExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithColumnFormatting
{
    public $collection;

    protected $rowNumber = 0;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * @var SouvenirStock
     */
    public function map($souvenirstock): array
    {
        return [
            ++$this->rowNumber,
            $souvenirstock->souvenir->souvenir_name,
            $souvenirstock->qty_in,
            $souvenirstock->qty_out,
            $souvenirstock->note,
            Date::dateTimeToExcel($souvenirstock->created_at),
        ];
    }

    public function headings(): array
    {
        return [
            '#',
            'Nama Souvenir',
            'Jumlah Masuk',
            'Jumlah Keluar',
            'Catatan',
            'Tanggal Registrasi',
        ];
    }

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
