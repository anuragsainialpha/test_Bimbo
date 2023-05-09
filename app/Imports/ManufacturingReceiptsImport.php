<?php

namespace App\Imports;

use App\Models\Receipt;
use App\Models\OwmItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DateTime;
use Auth;
use DB;

class ManufacturingReceiptsImport implements ToCollection, WithHeadingRow
{	
	public $autoNumberReceipt;
	
	public function collection(Collection $rows)
    {
		$this->autoNumberReceipt = "";
		foreach ($rows as $row) 
        {
			if(isset($row['item_part_a']) && $row['item_part_a'] != "")
			{
				$autoNumberReceipt = "ASN".sprintf('%07d', DB::Select("SELECT NextVal('Receipt') as 'Seq'")[0]->Seq);
				
				$Item = DB::Select("select * from `owmitems` where `part_a` = '".$row['item_part_a']."' limit 1")[0];
				//dd($Item->std_case_qty );
				$std_pallet_qty = (isset($Item->cases_per_pallet) ? $Item->cases_per_pallet : 10);
				
				if($std_pallet_qty == 0)
				{
					dd("Error");
				}
				
				$juldate = str_pad((date('z')+1), 3, '0', STR_PAD_LEFT);//unixtojd(\Carbon\Carbon::now()->timestamp);
				
				//dd($juldate);
				$is_upload_expire_date = '0';
				if($row['expire_date'] == "")
				{
					
					//$expire_date = date('dmY', strtotime(\Carbon\Carbon::now()->startOfWeek()->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
					//$expire_dateYmd = date('Y-m-d', strtotime(\Carbon\Carbon::now()->startOfWeek()->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
					
					if($Item->expcalcm == "1")
					{						
						if(\Carbon\Carbon::now()->Format('l') == "Saturday")
						{
							$expire_date = date('dmY', strtotime(\Carbon\Carbon::now()->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
							$expire_dateYmd = date('Y-m-d', strtotime(\Carbon\Carbon::now()->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
						}
						else
						{
							$expire_date = date('dmY', strtotime(\Carbon\Carbon::parse('this saturday')->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
							$expire_dateYmd = date('Y-m-d', strtotime(\Carbon\Carbon::parse('this saturday')->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
						}
					}
					else
					{
						$expire_date = date('dmY', strtotime(\Carbon\Carbon::now()->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
						$expire_dateYmd = date('Y-m-d', strtotime(\Carbon\Carbon::now()->Format('Y-m-d'). ' + '.($Item->product_life == "" ? 0 : $Item->product_life).' days'));
					}
				}
				else
				{
					$is_upload_expire_date = '1';
					$date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['expire_date']);
					$expire_date = $date->format('dmY');
					$expire_dateYmd = $date->format('Y-m-d');
					//dd($expire_date);
				}
				//dd($expire_date);
				//dd($row['batch_nbr'] == "" ? "UDE".$juldate."-L01-".$expire_date :  $row['batch_nbr']);
				$ReceiptID = Receipt::insertGetId([
					'facility_code' => 'UDE',
					'create_date' => date('y-m-d H:i'),
					'create_user' => Auth::User()->username,
					'wms_asn_nbr' => $autoNumberReceipt,
					'item_code' => $row['item_part_a'],
					'std_pallet_qty' => $std_pallet_qty,
					'batch_nbr' => $row['batch_nbr'] == "" ? "UDE-".$juldate."-L01-".$expire_date :  $row['batch_nbr'],
					'is_upload_batch' => $row['batch_nbr'] == "" ? 0 :  1,
					'shipped_qty' => $row['total_qty'],
					'received_qty' => '0',
					'status' => 'Created',
				]);
				//dd(Receipt::Where('id',$ReceiptID)->First()); 
				$remainder = $row['total_qty'] % $std_pallet_qty;
				$packets = ($row['total_qty'] - $remainder) / $std_pallet_qty;
				//dd($ReceiptID);
				
				
				$lpnCounts = 0;
				for($i=1; $i<=$packets; $i++)
				{
					$autoNmber = "LPN".sprintf('%07d', DB::Select("SELECT NextVal('ReceiptLPN') as 'Seq'")[0]->Seq);
					DB::Insert("INSERT INTO m_receipt_lpn
							(receipt_id,lpn_nbr,item_code,batch_nbr,expire_date,is_upload_expire_date,current_qty,printed_by,
							original_qty,create_user) VALUES ('".$ReceiptID."', '".$autoNmber."', '".$row['item_part_a']."',
							'".($row['batch_nbr'] == "" ? "UDE-".$juldate."-L01-".$expire_date :  $row['batch_nbr'])."',
							'".$expire_dateYmd."','".$is_upload_expire_date."',
							'".$std_pallet_qty."', '".Auth::User()->username."', '".$std_pallet_qty."', '".Auth::User()->username."')");
					
					$lpnCounts++;
				}
				
				if($remainder != 0)
				{
					$autoNmber = "LPN".sprintf('%07d', DB::Select("SELECT NextVal('ReceiptLPN') as 'Seq'")[0]->Seq);
					DB::Insert("INSERT INTO m_receipt_lpn
							(receipt_id,lpn_nbr,item_code,batch_nbr,expire_date,is_upload_expire_date,current_qty,printed_by,
							original_qty,create_user) VALUES ('".$ReceiptID."', '".$autoNmber."', '".$row['item_part_a']."',
							'".($row['batch_nbr'] == "" ? "UDE-".$juldate."-L01-".$expire_date :  $row['batch_nbr'])."',
							'".$expire_dateYmd."','".$is_upload_expire_date."',
							'".$remainder."', '".Auth::User()->username."', '".$remainder."', '".Auth::User()->username."')");
					$lpnCounts++;
				}
				
				$this->autoNumberReceipt .= "<b>".$autoNumberReceipt." (".$lpnCounts." LPNs)</b><br /><br />";
			}
        }
		
    }
}
