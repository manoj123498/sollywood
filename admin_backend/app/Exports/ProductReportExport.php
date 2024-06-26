<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductReportExport implements FromCollection, WithHeadings
{
    protected $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    public function collection(): Collection
    {
        return collect($this->rows)->map(fn($product) => $this->tableBody($product));
    }

    public function headings(): array
    {
        return [
            'Product title',
            'Bar code',
            'Item sold',
            'Net sales',
            'Orders',
            'Category',
        ];
    }

    private function tableBody($product): array
    {
        return [
            'title'         => data_get($product, 'product_title','Title deleted'),
            'bar_code'      => data_get($product, 'bar_code'),
            'quantity'      => data_get($product, 'quantity', 0),
            'sum'           => data_get($product, 'price', 0),
            'orders'        => data_get($product, 'count', 0),
            'category'      => data_get($product, 'category.translation.title','Title deleted'),
        ];
    }
}
