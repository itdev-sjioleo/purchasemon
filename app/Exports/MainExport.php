<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MainExport implements FromCollection, WithHeadings
{
    use Exportable;

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = DB::connection('ascend')->table('dbo.VIEW_SJIO_PURCHASEMON_MASTER')
            ->where('PRRequestTo', 'PROCUREMENT');

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'PRNumber',
            'PRCreateDate',
            'PRApprovedDateTime',
            'PRRequestByCode',
            'PRRequestByName',
            'PRItemCount',
            'PRClosed',
            'PRRequestTo',
            'InquiryNumber',
            'InqCreateDate',
            'InqApprovedDateTime',
            'InqItemCount',
            'PONumber',
            'POCreateDate',
            'POManApprovedDateTime',
            'PODirApprovedDateTime',
            'POItemCount',
            'PurchaseNumber',
            'PICreateDate',
            'PIItemCount'
        ];
    }
}
