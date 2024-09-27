<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MainExport implements FromCollection
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

    // public function headings(): array
    // {
    //     return [
    //         'PO Number',
    //         'PO Created Date',
    //         'PO Created By',
    //         'PO Approved Date',
    //         'PO Approved By',
    //         'PO Remarks',
    //         'PO Amount',
    //         'PO Supplier Code',
    //         'PO Supplier Name',
    //         'Sup Bank',
    //         'Sup Account No',
    //         'Sup Account Name',
    //         'GR Number',
    //         'GR Create Date',
    //         'GR Created By',
    //         'GR Reference No',
    //         'GR Amount',
    //         'IR Receipt No',
    //         'IR Create Date',
    //         'IR Created By',
    //         'IR Payment Date',
    //         'IR Net Amount',
    //         'PVR Number',
    //         'PVR Create Date',
    //         'PVR Created By',
    //         'PVR Amount Paid',
    //         'PVR Deducted PPh',
    //         'PVR Net Amount Paid',
    //         'PVR Approved Date',
    //         'PVR Approved By',
    //         'PVR Remarks',
    //         'PV Number',
    //         'PV Create Date',
    //         'PV Created By',
    //         'PV Amount Paid',
    //         'PV Bank Name',
    //         'PV Remarks',
    //     ];
    // }
}
