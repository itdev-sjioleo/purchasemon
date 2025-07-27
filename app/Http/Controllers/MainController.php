<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PalmTickets;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Services\DataTable;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MainExport;
use App\Models\PurchaseRequest;

class MainController extends Controller
{
    public function index()
    {
        return view('master');
    }

    public function summary()
    {
        return view('summary');
    }

    public function detail($pr_id)
    {
        $purchase_request = PurchaseRequest::find($pr_id);
        return view('detail', compact('purchase_request'));
    }

    public function datatable(Request $request)
    {
        $filters = $request->get('filters');

        $query = DB::connection('ascend')->table('dbo.VIEW_SJIO_PURCHASEMON_MASTER');
        
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

        $datatable = datatables($query);

        return $datatable->toJson();
    }

    public function summaryDatatable(Request $request)
    {
        $filters = $request->get('filters');

        $query = DB::connection('ascend')->table('dbo.VIEW_SJIO_PURCHASEMON_SUMMARY')
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
            if($filters['pr_closed'] == 1) {
                $query->where('PRClosed', '=', 1)
                    ->orWhere('PRItemCount', '>', 'PIitemCount');
            } else {
                $query->where('PRClosed', '=', 0);
            }
        }

        $datatable = datatables($query);

        return $datatable->toJson();
    }

    public function export(Request $request)
    {
        $filters = $request->query('filters');

        return (new MainExport($filters))->download('Purchase Monitoring Master.xlsx');
    }

    public function summaryExport(Request $request)
    {
        return (new SummaryExport())->download('Purchase Monitoring Summary.xlsx');
    }
}
