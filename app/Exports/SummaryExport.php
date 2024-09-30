<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SummaryExport implements FromCollection, WithHeadings
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
            'PRID',
            'PRNumber',
            'PRItemCount',
            'PRImportance',
            'PRApprovedTime',
            'PRClosed',
            'PRRequestByCode',
            'PRRequestByName',
            'InqCount',
            'InqItemCount',
            'InqLastTime',
            'POCount',
            'POItemCount',
            'POLastTime',
            'POApproveCount',
            'POApproveItemCount',
            'POApproveLastTime',
            'PICount',
            'PIItemCount',
            'PILastTime'
        ];
    }
}
