<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalmTickets;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MainExport;

class MainController extends Controller
{
    public function index()
    {
        return view('main');
    }

    public function datatable(Request $request)
    {
        $filters = $request->get('filters');

        $query = DB::connection('ascend')->table('dbo.VIEW_SJIO_PURCHASEMON_MASTER')
            ->where('PRRequestTo', 'PROCUREMENT');
        
        if ($filters['pr_date_start']) {
            $query->where('PRApprovedDateTime', '>=', $filters['pr_date_start']);
        }

        if ($filters['pr_date_end']) {
            $query->where('PRApprovedDateTime', '<=', $filters['pr_date_end']);
        }

        if ($filters['pr_department'] && $filters['pr_department'] != 'ALL_DEPARTMENT') {
            $query->where('PRRequestByName', '=', $filters['pr_department']);
        }

        $datatable = datatables($query);

        return $datatable->toJson();
    }

    public function export(Request $request)
    {
        return (new MainExport())->download('Purchase Monitoring.xlsx');
    }
}
