<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;

class ExpenseExport implements FromArray, WithHeadings, ShouldAutoSize
{
    protected $data;

    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return Expense::all();
    // }

    public function __construct($data)
    {
        // dd($data);
        $this->data = $data;
    }

    public function headings(): array
    {
        return [
            'Amount',
            'Category',
            'Expense Date',
            'Remark',
        ];
    }

    /**
    * @return Array
    */

    public function array(): array
    {
        return $this->data->toArray();
    }


}
