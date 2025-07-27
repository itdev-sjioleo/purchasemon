<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MainExport implements FromCollection, WithHeadings
{
    use Exportable;

    private $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $filters = $this->filters;

        $query = DB::connection('ascend')->table('dbo.VIEW_SJIO_PURCHASEMON_MASTER')
            ->select(
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
            )
            ->where('PRRequestTo', 'PROCUREMENT');
        
        if ($filters['pr_date_start']) {
            $query->where('PRCreateDate', '>=', $filters['pr_date_start']);
        }

        if ($filters['pr_date_end']) {
            $query->where('PRCreateDate', '<=', $filters['pr_date_end']);
        }

        if ($filters['pr_department'] && $filters['pr_department'] != 'ALL_DEPARTMENT') {
            $query->where('PRRequestByName', '=', $filters['pr_department']);
        }

        if ($filters['pr_closed'] && $filters['pr_closed'] != 'ALL') {
            $query->where('PRClosed', '=', $filters['pr_closed']);
        }

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
