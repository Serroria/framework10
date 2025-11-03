<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Product;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ProductsExport implements FromCollection, WithHeadings, WithEvents
{
/**
     * @var string
     */
    protected $periode;

    public function __construct($periode)
    {
        $this->periode = $periode;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function collection()
    {
        return Product::all();
    }

    public function headings():array{
        return [
            'ID',
            'Name',
            'Unit',
            'Category',
            'Description',
            'Stock',
            'Supplier',
            'Created At',
            'Updated At',
        ];
    }
    public function registerEvents(): array{
        return [
            AfterSheet::class=> function (AfterSheet $event){

                $sheet = $event ->sheet->getDelegate();

                $sheet ->insertNewRowBefore(1,3);
                $sheet ->setCellValue('A1', 'PT BAPAK AGUS');
                $sheet ->setCellValue('A2', 'Rekap Stock Produk Gudang');
                $sheet ->setCellValue('A3',  'Periode: ' . $this->periode);

                $sheet->mergeCells('A1:I1');
                $sheet ->mergeCells('A2:I2');
                $sheet->mergeCells('A3:I3');

                $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A3')->getFont()->setBold(true)->setSize(16);
                $sheet->getStyle('A1:A3')->getAlignment()->setHorizontal('center');

                $sheet->getStyle('A4:I4')->getFont()->setBold(true);
            },
        ];
    }

}
