<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use DB;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
	
	/*public function getManufacturingReceipts(Request $request)
    {
		$FileLists = \Storage::disk('manufacturingreceipts')->files();
       	return view('manufacturingreceipts', array('FileLists' => $FileLists));
    }
	
	public function downloadFile($fileName)
    {
		return response()->download(storage_path("app/manufacturingreceipts/{$fileName}"));
    }
	public function uploadManufacturingReceipts(Request $request)
    {
		$request->validate([
            'receipt' => 'required|mimes:xlsx,xls'
        ]);
		$file = $request->file('receipt');
		$originalname = $file->getClientOriginalName();
		$request->receipt->storeAs('manufacturingreceipts',$originalname);
        
       	return redirect('/manufacturingreceipts')->with('success','File upload successfully');
    }*/
	
	public function CompletionsReport()
	{
		return view('completions_report');
	}
	
	public function CompletionsReportGrid(Request $request)
	{
		$Where = "";
		if($request->from != "")
		{
			$Where = "AND (m_receipt_lpn.mod_date) Between CAST('".$request->from."' AS DATETIME) AND CAST('".$request->to."' AS DATETIME) ";
		}
		$Query = "SELECT m_receipt_lpn.printed_by AS 'Line_Printed', m_receipt_lpn.item_code, owmitems.description AS 'Description', SUM(m_receipt_lpn.current_qty) AS 'Total_Cases', 
(SUM(m_receipt_lpn.current_qty))*(owmitems.std_case_qty) AS 'Total_Units',
(m_receipt_lpn.mod_date) AS 'Print_Date',
if((HOUR(m_receipt_lpn.mod_date) IN (5,6,7,8,9,10,11,12,13,14,15,16,17)), 'Shift 1' , 'Shift 2') AS 'Shift'
FROM m_receipt_lpn
LEFT JOIN owmitems ON owmitems.part_a = m_receipt_lpn.item_code
WHERE m_receipt_lpn.printed = '1' ".$Where."
GROUP BY date(m_receipt_lpn.mod_date), m_receipt_lpn.item_code, if((HOUR(m_receipt_lpn.mod_date) IN (5,6,7,8,9,10,11,12,13,14,15,16,17)), 'Shift 1' , 'Shift 2')
ORDER BY date(m_receipt_lpn.mod_date) DESC";
		
		$info_Data = DB::Select($Query);
		return Datatables::of($info_Data)
		->escapeColumns([])
		->make(true);
	}
	
	public function getVerifiedShipments(Request $request)
    {
       	return view('verifiedshipments');
    }
	public function downloadVerifiedShipments($id)
    {
       	return $id;
    }
	public function exportVerifiedShipments(Request $request)
	{
		$info_Data = DB::Select("select item_part_a,  shipped_qty from owmsvs where id in (".$request->IDs.")");
		$Lines = 'StartOptions
D,16777215,0,Tahoma,10
K,13172735,0,Courier,8
S,16777088,0,Tahoma,8
AutoInsert,TRUE
CheckCursor,FALSE
Rows,301
Cols,66
DefaultFont,Tahoma,10
TargetApp,Apps11i
TargetWin,"Oracle Applications - FMGT Cloned from FMGP Data as on MAR 06, 2019 11:10:00 CT"
Description,""
EndOptions
StartShortCuts
TAB,TAB Key,Key Next_item,\{TAB},\{TAB},\{TAB},\{TAB}
ENT,Enter,Depends on Context,\{ENTER},\{ENTER},\{ENTER},\{ENTER}
*UP,Up arrow key,Key Up,\{UP},\{UP},\{UP},\{UP}
*DN,Down arrow key,Key Down,\{DOWN},\{DOWN},\{DOWN},\{DOWN}
*LT,Left arrow key,Depends on Context,\{LEFT},\{LEFT},\{LEFT},\{LEFT}
*RT,Right arrow key,Depends on Context,\{RIGHT},\{RIGHT},\{RIGHT},\{RIGHT}
*SP,Save & Proceed,MENU CUSTOM FILE ACCEPT,\%F%V,\%A%{DOWN 4}{ENTER},\%A%A,
*SAVE,Save,Key Commit_form,\^S,\^S,\{F10},
*NB,Next Block,Key Next_block,\+{PGDN},\+{PGDN},\^{PGDN},
*PB,Previous Block,Key Previous_block,\+{PGUP},\+{PGUP},\^{PGUP},
*NF,Next Field,Key Next_item,\{TAB},\%G%{DOWN}{ENTER},\{TAB},
*PF,Previous Field,Key Previous_item,\+{TAB},\%G%{DOWN 2}{ENTER},\+{TAB},
*NR,Next record,Key Down,\{DOWN},\%G%{DOWN 3}{ENTER},\+{DOWN},
*PR,Previous record,Key Up,\{UP},\%G%{DOWN 4}{ENTER},\+{UP},
*FR,First record,MENU CUSTOM RECORD FIRST,\%V%DF,\%G%{DOWN 5}{ENTER},\%G%F,
*LR,Last record,MENU CUSTOM RECORD LAST,\%V%DL,\%G%{DOWN 6}{ENTER},\%G%L,
*ER,Erase record,Key Clear_record,\{F6},\{F6},\+{F4},
*DR,Delete record,Key Delete_record,\^{UP},\^{UP},\+{F6},
*SB,Space bar,Depends on Context,\{SPACE},\{SPACE},\{SPACE},\{SPACE}
*ST,Select field text,[none],\{HOME}+{END},\{HOME}+{END},\{HOME}+{END},
*BM,Block menu,Key Block_menu,\^B,\^B,\{F5},
*QE,Query enter,Key Enter_query,\{F11},\{F11},\{F7},
*QR,Query run,Key Execute_query,\^{F11},\^{F11},\{F8},
*FI,Find,MENU CUSTOM VIEW FIND,\%V%F,\%Q%{DOWN}{ENTER},,
*FA,Find all,MENU CUSTOM VIEW FIND_ALL,\%V%I,\%Q%{DOWN 2}{ENTER},,
*IR,Insert record,Key Create_record,\^{DOWN},\^{DOWN},\{F6},
*CL,Clear field,Key Clear_item,\{F5},\{F5},\^U,
*FE,Field edit,Key Edit,\^E,\^E,\^E,
*AA,Alt A,Depends on Context,\%A,\%A,\%A,\%A
*AB,Alt B,Depends on Context,\%B,\%B,\%B,\%B
*AC,Alt C,Depends on Context,\%C,\%C,\%C,\%C
*AD,Alt D,Depends on Context,\%D,\%D,\%D,\%D
*AE,Alt E,Depends on Context,\%E,\%E,\%E,\%E
*AF,Alt F,Depends on Context,\%F,\%F,\%F,\%F
*AG,Alt G,Depends on Context,\%G,\%G,\%G,\%G
*AH,Alt H,Depends on Context,\%H,\%H,\%H,\%H
*AI,Alt I,Depends on Context,\%I,\%I,\%I,\%I
*AJ,Alt J,Depends on Context,\%J,\%J,\%J,\%J
*AK,Alt K,Depends on Context,\%K,\%K,\%K,\%K
*AL,Alt L,Depends on Context,\%L,\%L,\%L,\%L
*AM,Alt M,Depends on Context,\%M,\%M,\%M,\%M
*AN,Alt N,Depends on Context,\%N,\%N,\%N,\%N
*AO,Alt O,Depends on Context,\%O,\%O,\%O,\%O
*AP,Alt P,Depends on Context,\%P,\%P,\%P,\%P
*AQ,Alt Q,Depends on Context,\%Q,\%Q,\%Q,\%Q
*AR,Alt R,Depends on Context,\%R,\%R,\%R,\%R
*AS,Alt S,Depends on Context,\%S,\%S,\%S,\%S
*AT,Alt T,Depends on Context,\%T,\%T,\%T,\%T
*AU,Alt U,Depends on Context,\%U,\%U,\%U,\%U
*AV,Alt V,Depends on Context,\%V,\%V,\%V,\%V
*AW,Alt W,Depends on Context,\%W,\%W,\%W,\%W
*AX,Alt X,Depends on Context,\%X,\%X,\%X,\%X
*AY,Alt Y,Depends on Context,\%Y,\%Y,\%Y,\%Y
*AZ,Alt Z,Depends on Context,\%Z,\%Z,\%Z,\%Z
,,,,,,
,,,,,,
EndShortCuts
StartDelays
WindoActivated,7000
CursorBusy,7000
TAB,1000
ENT,1000
*UP,1000
*DN,1000
*LT,1000
*RT,1000
*SP,1000
*SAVE,1000
*NB,1000
*PB,1000
*NF,1000
*PF,1000
*NR,1000
*PR,1000
*FR,1000
*LR,1000
*ER,1000
*DR,1000
*SB,1000
*ST,1000
*BM,1000
*QE,1000
*QR,1000
*FI,1000
*FA,1000
*IR,1000
*CL,1000
*FE,1000
*AA,1000
*AB,1000
*AC,1000
*AD,1000
*AE,1000
*AF,1000
*AG,1000
*AH,1000
*AI,1000
*AJ,1000
*AK,1000
*AL,1000
*AM,1000
*AN,1000
*AO,1000
*AP,1000
*AQ,1000
*AR,1000
*AS,1000
*AT,1000
*AU,1000
*AV,1000
*AW,1000
*AX,1000
*AY,1000
*AZ,1000
EndDelays
StartHeaders
Shortcut,Key,Data,Key,Key,Key,Key,Key,Data,Key,Shortcut,Shortcut,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Key,Key,Data,Key,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Key,Data,Key
EndHeaders
StartData';
		foreach($info_Data as $Data)
		{
			$Lines = $Lines. "
*MC(526,302)	\{DELETE}	".$Data->item_part_a."	\{TAB}	\{DELETE}	".$Data->shipped_qty."	\{TAB}";
		}
		
		$Lines = $Lines. "
EndData
";
		//return $Lines;
		
		return response($Lines)
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'attachment; filename="ItemRec.dlf',
                ]);
	}
	public function getVerifiedShipmentsGrid(Request $request)
    {
       	$info_Data = DB::table('owmsvs')->Get();
		return Datatables::of($info_Data)
		->addColumn('edit', function ($info_Data) {
				 return '<div class="btn-group btn-group-action">
								<a class="btn btn-info" style="margin-right:2px;" href="'.url('/verifiedshipments/'.$info_Data->id.'/download').'" title="Download Data"><i class="fa fa-download"></i></a> 
						</div>';
        })
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
	
	public function getOutboundLoads(Request $request)
    {
       	return view('outboundloads');
    }
	public function downloadOutboundLoads($id)
    {
       	return $id;
    }
	public function exportOutboundLoads(Request $request)
    {
		$info_Data = DB::Select("select order_nbr, item_part_a, sum(shipped_qty) as shipped_qty from owmobl where id in (".$request->IDs.") group by order_nbr, item_part_a");
       	
		$Lines = 'StartOptions
D,16777215,0,Tahoma,10
K,13172735,0,Courier,8
S,16777088,0,Tahoma,8
AutoInsert,TRUE
CheckCursor,FALSE
Rows,301
Cols,66
DefaultFont,Tahoma,10
TargetApp,Apps11i
TargetWin,"Oracle Applications - FMGT Cloned from FMGP Data as on MAR 06, 2019 11:10:00 CT"
Description,""
EndOptions
StartShortCuts
TAB,TAB Key,Key Next_item,\{TAB},\{TAB},\{TAB},\{TAB}
ENT,Enter,Depends on Context,\{ENTER},\{ENTER},\{ENTER},\{ENTER}
*UP,Up arrow key,Key Up,\{UP},\{UP},\{UP},\{UP}
*DN,Down arrow key,Key Down,\{DOWN},\{DOWN},\{DOWN},\{DOWN}
*LT,Left arrow key,Depends on Context,\{LEFT},\{LEFT},\{LEFT},\{LEFT}
*RT,Right arrow key,Depends on Context,\{RIGHT},\{RIGHT},\{RIGHT},\{RIGHT}
*SP,Save & Proceed,MENU CUSTOM FILE ACCEPT,\%F%V,\%A%{DOWN 4}{ENTER},\%A%A,
*SAVE,Save,Key Commit_form,\^S,\^S,\{F10},
*NB,Next Block,Key Next_block,\+{PGDN},\+{PGDN},\^{PGDN},
*PB,Previous Block,Key Previous_block,\+{PGUP},\+{PGUP},\^{PGUP},
*NF,Next Field,Key Next_item,\{TAB},\%G%{DOWN}{ENTER},\{TAB},
*PF,Previous Field,Key Previous_item,\+{TAB},\%G%{DOWN 2}{ENTER},\+{TAB},
*NR,Next record,Key Down,\{DOWN},\%G%{DOWN 3}{ENTER},\+{DOWN},
*PR,Previous record,Key Up,\{UP},\%G%{DOWN 4}{ENTER},\+{UP},
*FR,First record,MENU CUSTOM RECORD FIRST,\%V%DF,\%G%{DOWN 5}{ENTER},\%G%F,
*LR,Last record,MENU CUSTOM RECORD LAST,\%V%DL,\%G%{DOWN 6}{ENTER},\%G%L,
*ER,Erase record,Key Clear_record,\{F6},\{F6},\+{F4},
*DR,Delete record,Key Delete_record,\^{UP},\^{UP},\+{F6},
*SB,Space bar,Depends on Context,\{SPACE},\{SPACE},\{SPACE},\{SPACE}
*ST,Select field text,[none],\{HOME}+{END},\{HOME}+{END},\{HOME}+{END},
*BM,Block menu,Key Block_menu,\^B,\^B,\{F5},
*QE,Query enter,Key Enter_query,\{F11},\{F11},\{F7},
*QR,Query run,Key Execute_query,\^{F11},\^{F11},\{F8},
*FI,Find,MENU CUSTOM VIEW FIND,\%V%F,\%Q%{DOWN}{ENTER},,
*FA,Find all,MENU CUSTOM VIEW FIND_ALL,\%V%I,\%Q%{DOWN 2}{ENTER},,
*IR,Insert record,Key Create_record,\^{DOWN},\^{DOWN},\{F6},
*CL,Clear field,Key Clear_item,\{F5},\{F5},\^U,
*FE,Field edit,Key Edit,\^E,\^E,\^E,
*AA,Alt A,Depends on Context,\%A,\%A,\%A,\%A
*AB,Alt B,Depends on Context,\%B,\%B,\%B,\%B
*AC,Alt C,Depends on Context,\%C,\%C,\%C,\%C
*AD,Alt D,Depends on Context,\%D,\%D,\%D,\%D
*AE,Alt E,Depends on Context,\%E,\%E,\%E,\%E
*AF,Alt F,Depends on Context,\%F,\%F,\%F,\%F
*AG,Alt G,Depends on Context,\%G,\%G,\%G,\%G
*AH,Alt H,Depends on Context,\%H,\%H,\%H,\%H
*AI,Alt I,Depends on Context,\%I,\%I,\%I,\%I
*AJ,Alt J,Depends on Context,\%J,\%J,\%J,\%J
*AK,Alt K,Depends on Context,\%K,\%K,\%K,\%K
*AL,Alt L,Depends on Context,\%L,\%L,\%L,\%L
*AM,Alt M,Depends on Context,\%M,\%M,\%M,\%M
*AN,Alt N,Depends on Context,\%N,\%N,\%N,\%N
*AO,Alt O,Depends on Context,\%O,\%O,\%O,\%O
*AP,Alt P,Depends on Context,\%P,\%P,\%P,\%P
*AQ,Alt Q,Depends on Context,\%Q,\%Q,\%Q,\%Q
*AR,Alt R,Depends on Context,\%R,\%R,\%R,\%R
*AS,Alt S,Depends on Context,\%S,\%S,\%S,\%S
*AT,Alt T,Depends on Context,\%T,\%T,\%T,\%T
*AU,Alt U,Depends on Context,\%U,\%U,\%U,\%U
*AV,Alt V,Depends on Context,\%V,\%V,\%V,\%V
*AW,Alt W,Depends on Context,\%W,\%W,\%W,\%W
*AX,Alt X,Depends on Context,\%X,\%X,\%X,\%X
*AY,Alt Y,Depends on Context,\%Y,\%Y,\%Y,\%Y
*AZ,Alt Z,Depends on Context,\%Z,\%Z,\%Z,\%Z
,,,,,,
,,,,,,
EndShortCuts
StartDelays
WindoActivated,7000
CursorBusy,7000
TAB,1000
ENT,1000
*UP,1000
*DN,1000
*LT,1000
*RT,1000
*SP,1000
*SAVE,1000
*NB,1000
*PB,1000
*NF,1000
*PF,1000
*NR,1000
*PR,1000
*FR,1000
*LR,1000
*ER,1000
*DR,1000
*SB,1000
*ST,1000
*BM,1000
*QE,1000
*QR,1000
*FI,1000
*FA,1000
*IR,1000
*CL,1000
*FE,1000
*AA,1000
*AB,1000
*AC,1000
*AD,1000
*AE,1000
*AF,1000
*AG,1000
*AH,1000
*AI,1000
*AJ,1000
*AK,1000
*AL,1000
*AM,1000
*AN,1000
*AO,1000
*AP,1000
*AQ,1000
*AR,1000
*AS,1000
*AT,1000
*AU,1000
*AV,1000
*AW,1000
*AX,1000
*AY,1000
*AZ,1000
EndDelays
StartHeaders
Shortcut,Key,Data,Key,Key,Key,Key,Key,Data,Key,Shortcut,Shortcut,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Key,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Key,Key,Data,Key,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Shortcut,Key,Data,Key
EndHeaders
StartData';
		foreach($info_Data as $Data)
		{
			$Lines = $Lines. "
*MC(526,302)	\{DELETE}	".$Data->order_nbr."	\{TAB}	\{TAB}	\{TAB}	\{TAB}	\{TAB}	".$Data->item_part_a."	\{TAB}	*MC(906,563)	*MC(541,551)	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{UP}	\{DOWN}	\{DOWN}	\{DOWN}	\{DOWN}	\{DOWN}	\{DOWN}	\{DOWN}	*MC(572,547)	*MC(744,546)	*MC(821,542)	*MC(211,36)	*MC(240,170)	*MC(931,567)	\{TAB}	\{TAB}	".$Data->shipped_qty."	\{TAB}	*MC(109,66)	*MC(155,507)	*MC(200,549)	*MC(1058,771)	*MC(798,536)	*MC(214,36)	*MC(238,172)	*MC(521,290)	\{DELETE}";
		}
		$Lines = $Lines. "
EndData
";
		//return $Lines;
		
		return response($Lines)
                ->withHeaders([
                    'Content-Type' => 'text/plain',
                    'Cache-Control' => 'no-store, no-cache',
                    'Content-Disposition' => 'attachment; filename="FinalShipment.dlf',
                ]);
    }
	public function getOutboundLoadsGrid(Request $request)
    {
		
		if(isset($request->from) && $request->from != "" && isset($request->to) && $request->to != "")
		{
			$info_Data = DB::Select("SELECT * FROM `owmobl` where DATE(ship_date) BETWEEN '".$request->from."' AND '".$request->to."'");
		}
		else
		{
	   		$info_Data = DB::table('owmobl')->Get();
		}
       	
		return Datatables::of($info_Data)
		->addColumn('edit', function ($info_Data) {
				 return '<div class="btn-group btn-group-action">
								<a class="btn btn-info" style="margin-right:2px;" href="'.url('/verifiedshipments/'.$info_Data->id.'/download').'" title="Download Data"><i class="fa fa-download"></i></a> 
						</div>';
        })
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
	
	public function getInventoryHistory(Request $request)
    {
       	return view('inventoryhistory');
    }
	public function downloadInventoryHistory($id)
    {
       	return $id;
    }
	public function getInventoryHistoryGrid(Request $request)
    {
       	$info_Data = DB::table('owmihs')->Get();
		return Datatables::of($info_Data)
		->addColumn('edit', function ($info_Data) {
				 return '<div class="btn-group btn-group-action">
								<a class="btn btn-info" style="margin-right:2px;" href="'.url('/verifiedshipments/'.$info_Data->id.'/download').'" title="Download Data"><i class="fa fa-download"></i></a> 
						</div>';
        })
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
}
