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

    public function view2()
    {
        return view('view2');
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

    public function authLog(Request $request)
    { 
        if (auth()->user()->username != 'admin') {
            return redirect()->back();
        }
        
        return view('auth_log');
    }

    public function datatableAuthLog(Request $request)
    {
        $query = DB::table('auth_log');

        $datatable = datatables($query);

        return $datatable->toJson();
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
            switch ($filters['pr_department']) {               
                case 'refinery.fraksinasi':
                    $query->whereIn('PRRequestByName', ['REF & FRAC', 'REFINERY', 'FRAKSINASI']);
                    break;
                
                case 'tank.farm':
                    $query->whereIn('PRRequestByName', ['TANK FARM', 'LOGISTIC']);
                    break;
                
                case 'utility':
                    $query->whereIn('PRRequestByName', ['UTILITY', 'BOILER']);
                    break;
                
                case 'laboratorium':
                    $query->whereIn('PRRequestByName', ['LABORATORIUM',]);
                    break;
                
                case 'hrga':
                    $query->whereIn('PRRequestByName', ['GENERAL AFFAIR', 'HRD', 'LEGAL & REGULATION']);
                    break;
                
                case 'maintenance':
                    $query->whereIn('PRRequestByName', ['MAINTENANCE & EI']);
                    break;
                
                case 'it':
                    $query->whereIn('PRRequestByName', ['IT']);
                    break;
                
                case 'hse':
                    $query->whereIn('PRRequestByName', ['HSE']);
                    break;
                
                case 'warehouse':
                    $query->whereIn('PRRequestByName', ['WAREHOUSE']);
                    break;
                
                case 'project':
                    $query->whereIn('PRRequestByName', ['PROJECT']);
                    break;
                
                case 'office.ho':
                    $query->whereIn('PRRequestByName', ['OFFICE HO']);
                    break;
                
                case 'commercial':
                    $query->whereIn('PRRequestByName', ['COMMERCIAL']);
                    break;
                
                default:                    
                    break;
            }
            
        }

        if ($filters['pr_closed'] && $filters['pr_closed'] != 'ALL') {
            $query->where('PRClosed', '=', $filters['pr_closed']);
        }

        if ($filters['pr_created_to_pr_approved_mgr']) {
            $query->where('PRCreatedToPRApprovedMgr', '>=', $filters['pr_created_to_pr_approved_mgr']);
        }

        if ($filters['pr_approved_mgr_to_pr_process']) {
            $query->where('PRApprovedMgrToPRProcess', '>=', $filters['pr_approved_mgr_to_pr_process']);
        }

        if ($filters['pr_process_to_po_created']) {
            $query->where('PRProcessToPOCreated', '>=', $filters['pr_process_to_po_created']);
        }

        if ($filters['po_created_to_po_approved_mgr']) {
            $query->where('POCreatedToPOApprovedMgr', '>=', $filters['po_created_to_po_approved_mgr']);
        }

        if ($filters['po_approved_mgr_to_po_approved_dir']) {
            $query->where('POApprovedMgrToPOApprovedDir', '>=', $filters['po_approved_mgr_to_po_approved_dir']);
        }

        if ($filters['po_approved_mgr_to_good_received']) {
            $query->where('POApprovedDirToPICreated', '>=', $filters['po_approved_mgr_to_good_received']);
        }

        if ($filters['total_length_time']) {
            $query->where('TotalDays', '>=', $filters['total_length_time']);
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
