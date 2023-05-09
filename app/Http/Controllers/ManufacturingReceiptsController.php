<?php
  
namespace App\Http\Controllers;

use App\Models\Receipt;
use Illuminate\Http\Request;
use App\Imports\ManufacturingReceiptsImport;
use App\Exports\ManufacturingReceiptsExport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;
  
class ManufacturingReceiptsController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('manufacturingreceipts');
    }
  	
	public function importManufacturingReceipts() 
    {
		$manufacturingReceiptsImport = new ManufacturingReceiptsImport;
        Excel::import($manufacturingReceiptsImport,request()->file('owmitem'));
        return back()->with('autoNumberReceipt', $manufacturingReceiptsImport->autoNumberReceipt);
    }
	
	public function exportManufacturingReceipts() 
    {
		return Excel::download(new ManufacturingReceiptsExport, 'Receipts.xlsx');
    }
	
	/**
     * Create datatable grid
     *
     * 
     * @return \Illuminate\Http\Datatable
     */
	public function grid()
    {
	   $info_Receipts = Receipt::All();
	   return Datatables::of($info_Receipts)
	    /*->addColumn('edit', function ($info_Receipts) {
				 return '<div class="btn-group btn-group-action">
                                <a href="javascript:void(0)" class="btn btn-primary ViewLPNs" style="margin-right:2px;" data-id="'.$info_Receipts->id.'" title="View"><i class="fa fa-eye"></i> Detail</a> 
                                </div>';
        })*/
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
}