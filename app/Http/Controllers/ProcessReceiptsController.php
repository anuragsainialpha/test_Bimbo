<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LpnReceipt;
use App\Models\Receipt;
use DataTables;
use DB;
use Auth;
use PDF;

class ProcessReceiptsController extends Controller
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
                $query = "SELECT m_receipt.id as 'ID', CONCAT(m_receipt.wms_asn_nbr, ' ' ,m_receipt.item_code) AS 'ReceiptNbrItem',
m_receipt.item_code AS 'ItemCode', owmitems.description as 'Description', m_receipt.std_pallet_qty AS 'CasesxPallet',
m_receipt.batch_nbr AS 'Batch', m_receipt.is_upload_batch AS 'isUploadBatch', m_receipt.shipped_qty AS 'TotalCases',
(select IFNULL(SUM(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'CasesReceived',
(select IFNULL(COUNT(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'PalletsReceived',
(select case when is_upload_expire_date=1 then expire_date else expire_date end from m_receipt_lpn where receipt_id = m_receipt.id limit 1) AS 'ExpireDate'
FROM m_receipt
LEFT JOIN owmitems ON owmitems.part_a = m_receipt.item_code
WHERE m_receipt.`status` IN ('Created', 'Receiving Started') AND m_receipt.wms_asn_nbr IS
NOT NULL
GROUP BY m_receipt.id";
                $info_Receipts = DB::select($query);
        return view('processreceipts', array('info_Receipts' => $info_Receipts, 'selctedID' => 0 , 'Download' => '0', 'LPNID' => '', 'LineNBR' => '', 'xml' => '','xmlResponse' => '', 'showNonStd' => '0', 'isUploadBatch' => '0', 'Lpn_Nbr' => '' ));
    }

	public function destroy($id)
    {
                DB::Delete("Delete from m_receipt_lpn where id='$id'");
                return ["OK"];
    }

	public function rePrint(Request $request, $id)
    {
                $info_LpnReceipt = LpnReceipt::FindOrFail($id);
                $info_Receipt = $info_LpnReceipt->Receipt()->First();

                $info_LpnReceipt->printed = 1;
                //$info_LpnReceipt->current_qty = $request->current_qty;
                $info_LpnReceipt->printed_by = Auth::User()->username;
                $info_LpnReceipt->save();

                $data = array("parameters" => array ("facility_id__code" => "UDE" ,"company_id__code" => "USBBU","container_nbr" => $info_LpnReceipt->lpn_nbr), "options" => array ("label_designer_code" => Auth::User()->label_designer_code, "label_count" => 2, "printer_name" => Auth::User()->printer_name) );
                $postdata = json_encode($data);

                $username = env('API_USER');
                $password = env('API_PASS');
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL =>
                env('API_BASE_URL')."wms/lgfapi/v10/print/label/ib_container",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => array(
                                "Content-Type: application/json",
                                "Authorization: Basic ". base64_encode("$username:$password")
                        ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                \Log::info('Re-Print Response: '.$response);
                return array($data, "response" => $response);
                //$pdf = PDF::loadView('pdf', compact('info_Receipt'), compact('info_LpnReceipt'));
                //return $pdf->download($info_LpnReceipt->lpn_nbr.'.pdf');
    }

	public function PrintLabel(Request $request, $id)
    {
                $request->all();
                $info_LpnReceipt = LpnReceipt::FindOrFail($id);
                $info_Receipt = $info_LpnReceipt->Receipt()->First();

                $info_LpnReceipt->printed = 1;
                //$info_LpnReceipt->current_qty = $request->current_qty;
                $info_LpnReceipt->printed_by = Auth::User()->username;
                $info_LpnReceipt->save();

                /*if($info_Receipt->LpnReceipt()->where('printed',1)->Get()->Count() > "0")
                {
                        $username = env('API_USER');
                        $password = env('API_PASS');
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL =>
                        env('API_BASE_URL')."wms/api/receive_lpn/",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "facility_code=UDE&company_code=BIMBO&lpn_nbr=".$info_LpnReceipt->lpn_nbr,
                        CURLOPT_HTTPHEADER => array(
                                        "Content-Type: application/x-www-form-urlencoded",
                                        "Authorization: Basic ". base64_encode("$username:$password")
                                ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);
                }*/

                $query = "SELECT m_receipt.id as 'ID', CONCAT(m_receipt.wms_asn_nbr, ' ' ,m_receipt.item_code) AS 'ReceiptNbrItem',
m_receipt.item_code AS 'ItemCode', owmitems.description as 'Description', m_receipt.std_pallet_qty AS 'CasesxPallet',
m_receipt.batch_nbr AS 'Batch', m_receipt.is_upload_batch AS 'isUploadBatch', m_receipt.shipped_qty AS 'TotalCases',
(select IFNULL(SUM(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'CasesReceived',
(select IFNULL(COUNT(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'PalletsReceived',
(select case when is_upload_expire_date=1 then expire_date else expire_date end from m_receipt_lpn where receipt_id = m_receipt.id limit 1) AS 'ExpireDate'
FROM m_receipt
LEFT JOIN owmitems ON owmitems.part_a = m_receipt.item_code
WHERE m_receipt.`status` IN ('Created', 'Receiving Started') AND m_receipt.wms_asn_nbr IS
NOT NULL
GROUP BY m_receipt.id";
                $info_ReceiptsNew = DB::select($query);

        return view('processreceipts', array('info_Receipts' => $info_ReceiptsNew, 'selctedID' => $request->RcID, 'Download' => '1', 'LPNID' => $info_LpnReceipt->id, 'LineNBR' => $request->LineNBR, 'xml' => '','xmlResponse' => '', 'showNonStd' => '1', 'isUploadBatch' => '0', 'Lpn_Nbr' => $info_LpnReceipt->lpn_nbr));
    }

	public function TestViewPdf(Request $request, $id)
    {
                $info_LpnReceipt = LpnReceipt::FindOrFail($id);
                $info_Receipt = $info_LpnReceipt->Receipt()->First();

                return view('pdf', compact('info_Receipt'), compact('info_LpnReceipt'));
    }

	public function updateQty(Request $request, $id)
    {
                $info_LpnReceipt = LpnReceipt::FindOrFail($id);
                $info_Receipt = $info_LpnReceipt->Receipt()->First();
                $oldQty = $info_LpnReceipt->current_qty;
                $info_LpnReceipt->current_qty = $request->current_qty;
                $info_LpnReceipt->save();
                $postdata = "";
                $returnData = 0;
                if($request->current_qty != $oldQty)
                {
                        $returnData = 1;

                        $Item = DB::Select("select * from `owmitems` where `part_a` = '".$info_Receipt->item_code."' limit 1")[0];
                        if($info_LpnReceipt->is_upload_expire_date == '0')
                        {
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
                                $info_LpnReceipt->expire_date = $expire_dateYmd;
                        }
                        else
                        {
                                $expire_date = date('dmY', strtotime($info_LpnReceipt->expire_date));
                                $expire_dateYmd = $info_LpnReceipt->expire_date;
                        }
                        //Create IB Shipment detail
                        $BatchNbrPartsSend = $info_LpnReceipt->batch_nbr;
                        $juldate = str_pad((date('z')+1), 3, '0', STR_PAD_LEFT);
                        if($info_Receipt->is_upload_batch == "0")
                        {
                                if($request->LineNBR != "")
                                {
                                        $BatchNbrParts = explode("-",$info_LpnReceipt->batch_nbr);
                                        $BatchNbrPartsSend = $BatchNbrParts[0]."-".$juldate."-L0".$request->LineNBR."-".$expire_date;
                                }
                                else
                                {
                                        $BatchNbrParts = explode("-",$info_LpnReceipt->batch_nbr);
                                        $BatchNbrPartsSend = $BatchNbrParts[0]."-".$juldate."-".$BatchNbrParts[2]."-".$expire_date;
                                }
                                $info_LpnReceipt->batch_nbr = $BatchNbrPartsSend;
                        }

                        $info_LpnReceipt->save();

                        $putaway_type = "";
                        //dd($info_LpnReceiptUpdate->OwmItem()->First()->cases_per_pallet);
                        if($info_LpnReceipt->OwmItem()->First()->cases_per_pallet != $info_LpnReceipt->current_qty)
                        {
                                $putaway_type = "<putaway_type>PARTIAL_PALLET</putaway_type>";
                        }

                        $Mehtod = "UPDATE";
                        $DummyDtl = "";
                        if($info_Receipt->LpnReceipt()->where('printed',1)->Get()->Count() == "0")
                        {
                                $info_Receipt->batch_nbr = $BatchNbrPartsSend;
                                $info_Receipt->in_wms = 1;

                                $DummyDtl = "
                                <ib_shipment_dtl>
                                        <seq_nbr>1</seq_nbr>
                                        <action_code>CREATE</action_code>
                                        <lpn_nbr></lpn_nbr>
                                        <lpn_weight></lpn_weight>
                                        <lpn_volume></lpn_volume>
                                        <item_alternate_code></item_alternate_code>
                                        <item_part_a>DUMMY</item_part_a>
                                        <item_part_b></item_part_b>
                                        <item_part_c></item_part_c>
                                </ib_shipment_dtl>";

                                $Mehtod = "CREATE";
                        }

                        $xml = "<?xml version='1.0' encoding='utf-8'?>
                                                <LgfData>
                                                <Header>
                                                <DocumentVersion>19C</DocumentVersion>
                                                <OriginSystem>Host</OriginSystem>
                                                <ClientEnvCode>BIMBO</ClientEnvCode>
                                                <ParentCompanyCode>BIMBO</ParentCompanyCode>
                                                <Entity>ib_shipment</Entity>
                                                <TimeStamp>2018-04-02T12:12:12</TimeStamp>
                                                <MessageId>InboundShipment</MessageId>
                                                </Header>
                                                <ListOfIbShipments>
                                                <ib_shipment>
                                                <ib_shipment_hdr>
                                                <shipment_nbr>".$info_Receipt->wms_asn_nbr."</shipment_nbr>
                                                <facility_code>UDE</facility_code>
                                                <company_code>USBBU</company_code>
                                                <action_code>".$Mehtod."</action_code>
                                                <shipped_date>".date('Y-m-d')."</shipped_date>
                                                <origin_info>".$info_Receipt->item_code."</origin_info>
                                                <shipment_type>WO</shipment_type>
                                                <load_nbr>".$info_Receipt->wms_asn_nbr."</load_nbr>
                                                <cust_field_1>".$info_Receipt->shipped_qty."</cust_field_1>
                                                </ib_shipment_hdr>";


                        $cust_field_1 = "<cust_field_1>2</cust_field_1>";
                        $now = new \DateTime();
                        $begin = new \DateTime('5:00');
                        $end = new \DateTime('16:59');
                        if ($now >= $begin && $now <= $end)
                        {
                                $cust_field_1 = "<cust_field_1>1</cust_field_1>";
                        }

                        $xml = $xml . "<ib_shipment_dtl>
                                                <seq_nbr>".$info_LpnReceipt->id."</seq_nbr>
                                                <action_code>CREATE</action_code>
                                                <lpn_nbr>".$info_LpnReceipt->lpn_nbr."</lpn_nbr>
                                                <item_part_a>".$info_LpnReceipt->item_code."</item_part_a>
                                                <shipped_qty>".$info_LpnReceipt->current_qty."</shipped_qty>
                                                <expiry_date>".$expire_dateYmd."</expiry_date>
                                                <batch_nbr>".$BatchNbrPartsSend."</batch_nbr>
                                                ".$putaway_type."
                                                ".$cust_field_1."
                                                </ib_shipment_dtl>".$DummyDtl;


                        $xml = $xml."                   </ib_shipment>
                                                </ListOfIbShipments>
                                                </LgfData>";

                        //echo $xml;
                        $url = env('API_BASE_URL').'wms/api/init_stage_interface/';
                        $username = env('API_USER');
                        $password = env('API_PASS');

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL,$url);
                        curl_setopt($ch, CURLOPT_POST, 1);
                        curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array("async" => "false", "xml_data" => $xml)));  //Post Fields
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $headers = [
                                'Content-Type: application/x-www-form-urlencoded',
                                'Authorization: Basic ' . base64_encode("$username:$password"),
                        ];
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $server_output = curl_exec ($ch);
                        curl_close ($ch);

                        $xmlResponse = new \SimpleXMLElement($server_output);

                        /*echo "<br />Response<br />";
                        echo "<pre>";
                        echo print_r($xmlResponse);
                        echo "</pre>";*/

                        if($info_Receipt->is_upload_batch == "0"  && $request->LineNBR != "")
                        {
                                $BatchNbrParts = explode("-",$info_Receipt->batch_nbr);
                                $BatchNbrPartsSend = $BatchNbrParts[0]."-".$BatchNbrParts[1]."-L0".$request->LineNBR."-".$BatchNbrParts[3];
                                $info_Receipt->batch_nbr = $BatchNbrPartsSend;
                        }

                        //END Create IB Shipment detail

                        //dd($info_Receipt);

                        //Receive IB Shipment detail
                        $username = env('API_USER');
                        $password = env('API_PASS');
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL =>
                        env('API_BASE_URL')."wms/api/receive_lpn/",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => "facility_code=UDE&company_code=USBBU&lpn_nbr=".$info_LpnReceipt->lpn_nbr,
                        CURLOPT_HTTPHEADER => array(
                                        "Content-Type: application/x-www-form-urlencoded",
                                        "Authorization: Basic " . base64_encode("$username:$password")
                                ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);

                        $info_LpnReceipt->printed = 1;
                        $info_LpnReceipt->printed_by = Auth::User()->username;

                        $info_LpnReceipt->save();


                        $info_LpnReceipts = $info_Receipt->LpnReceipt()->where('printed',0)->Get();
                        if($info_LpnReceipts->Count() == 0)
                        {
                                $info_Receipt->status= "Closed";
                        }

                        $info_Receipt->save();
                        //END Receive IB Shipment detail


                        /*$data = array("parameters" => array ("facility_id__code" => "UDE" ,"company_id__code" => "BIMBO","container_nbr" => $info_LpnReceipt->lpn_nbr), "options" => array ("item_alternate_code" => $info_LpnReceipt->item_code, "batch_nbr" => $info_LpnReceipt->batch_nbr, "expiry_date" => $info_LpnReceipt->expire_date, "adjustment_qty" => ($request->current_qty-$oldQty), "reason_code" => "SP") );
                        $postdata = json_encode($data);
                        $username = env('API_USER');
                        $password = env('API_PASS');
                        $curl = curl_init();
                        curl_setopt_array($curl, array(
                        CURLOPT_URL =>
                        env('API_BASE_URL')."wms/lgfapi/v10/entity/iblpn/modify_item_qty/",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 0,
                        CURLOPT_FOLLOWLOCATION => true,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                        CURLOPT_CUSTOMREQUEST => "POST",
                        CURLOPT_POSTFIELDS => $postdata,
                        CURLOPT_HTTPHEADER => array(
                                        "Content-Type: application/json",
                                        "Authorization: Basic ". base64_encode("$username:$password")
                                ),
                        ));
                        $response = curl_exec($curl);
                        curl_close($curl);*/
                }
                //return $postdata."<-Response->".$response;
                return ($returnData == 0 ? $returnData : $info_LpnReceipt->id);
    }

	public function Print(Request $request)
    {
                $info_Receipt = Receipt::FindOrFail($request->RcID);
                $info_LpnReceipts = $info_Receipt->LpnReceipt()->where('printed',0)->Get();
                $info_LpnReceipt = $info_LpnReceipts->First();

                $Item = DB::Select("select * from `owmitems` where `part_a` = '".$info_Receipt->item_code."' limit 1")[0];
                if($info_LpnReceipt->is_upload_expire_date == '0')
                {
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
                        $info_LpnReceipt->expire_date = $expire_dateYmd;
                }
                else
                {
                        $expire_date = date('dmY', strtotime($info_LpnReceipt->expire_date));
                        $expire_dateYmd = $info_LpnReceipt->expire_date;
                }
                //dd($expire_date);
                $BatchNbrPartsSend = $info_LpnReceipt->batch_nbr;
                $juldate = str_pad((date('z')+1), 3, '0', STR_PAD_LEFT);
                if($info_Receipt->is_upload_batch == "0")
                {
                        if($request->LineNBR != "")
                        {
                                $BatchNbrParts = explode("-",$info_LpnReceipt->batch_nbr);
                                $BatchNbrPartsSend = $BatchNbrParts[0]."-".$juldate."-L0".$request->LineNBR."-".$expire_date;
                        }
                        else
                        {
                                $BatchNbrParts = explode("-",$info_LpnReceipt->batch_nbr);
                                $BatchNbrPartsSend = $BatchNbrParts[0]."-".$juldate."-".$BatchNbrParts[2]."-".$expire_date;
                        }
                        $info_LpnReceipt->batch_nbr = $BatchNbrPartsSend;
                }
                $info_LpnReceipt->save();
                //dd($BatchNbrPartsSend);
                $putaway_type = "";
                //dd($info_LpnReceiptUpdate->OwmItem()->First()->cases_per_pallet);
                if($info_LpnReceipt->OwmItem()->First()->cases_per_pallet != $info_LpnReceipt->current_qty)
                {
					$putaway_type = "<putaway_type>PARTIAL_PALLET</putaway_type>";
                }
				else
				{
					$putaway_type = "<putaway_type>".$Item->putaway_type."</putaway_type>";
				}

                $Mehtod = "UPDATE";
                $DummyDtl = "";
                if($info_Receipt->LpnReceipt()->where('printed',1)->Get()->Count() == "0")
                {
                        $info_Receipt->batch_nbr = $BatchNbrPartsSend;
                        $info_Receipt->in_wms = 1;

                        $DummyDtl = "
                        <ib_shipment_dtl>
                                <seq_nbr>1</seq_nbr>
                                <action_code>CREATE</action_code>
                                <lpn_nbr></lpn_nbr>
                                <lpn_weight></lpn_weight>
                                <lpn_volume></lpn_volume>
                                <item_alternate_code></item_alternate_code>
                                <item_part_a>DUMMY</item_part_a>
                                <shipped_qty>1</shipped_qty>
                                <item_part_b></item_part_b>
                                <item_part_c></item_part_c>
                        </ib_shipment_dtl>";

                        $Mehtod = "CREATE";
                }

                $xml = "<?xml version='1.0' encoding='utf-8'?>
                                        <LgfData>
                                        <Header>
                                        <DocumentVersion>19C</DocumentVersion>
                                        <OriginSystem>Host</OriginSystem>
                                        <ClientEnvCode>BIMBO</ClientEnvCode>
                                        <ParentCompanyCode>BIMBO</ParentCompanyCode>
                                        <Entity>ib_shipment</Entity>
                                        <TimeStamp>2018-04-02T12:12:12</TimeStamp>
                                        <MessageId>InboundShipment</MessageId>
                                        </Header>
                                        <ListOfIbShipments>
                                        <ib_shipment>
                                        <ib_shipment_hdr>
                                        <shipment_nbr>".$info_Receipt->wms_asn_nbr."</shipment_nbr>
                                        <facility_code>UDE</facility_code>
                                        <company_code>USBBU</company_code>
                                        <action_code>".$Mehtod."</action_code>
                                        <shipped_date>".date('Y-m-d')."</shipped_date>
                                        <origin_info>".$info_Receipt->item_code."</origin_info>
                                        <shipment_type>WO</shipment_type>
                                        <load_nbr>".$info_Receipt->wms_asn_nbr."</load_nbr>
                                        <cust_field_1>".$info_Receipt->shipped_qty."</cust_field_1>
                                        </ib_shipment_hdr>";

                $cust_field_1 = "<cust_field_1>2</cust_field_1>";
                $now = new \DateTime();
                $begin = new \DateTime('5:00');
                $end = new \DateTime('16:59');
                if ($now >= $begin && $now <= $end)
                {
                        $cust_field_1 = "<cust_field_1>1</cust_field_1>";
                }
                $xml = $xml . "<ib_shipment_dtl>
                                        <seq_nbr>".$info_LpnReceipt->id."</seq_nbr>
                                        <action_code>CREATE</action_code>
                                        <lpn_nbr>".$info_LpnReceipt->lpn_nbr."</lpn_nbr>
                                        <item_part_a>".$info_LpnReceipt->item_code."</item_part_a>
                                        <shipped_qty>".$info_LpnReceipt->current_qty."</shipped_qty>
                                        <expiry_date>".$expire_dateYmd."</expiry_date>
                                        <batch_nbr>".$BatchNbrPartsSend."</batch_nbr>
                                        ".$putaway_type."
                                        ".$cust_field_1."
                                        </ib_shipment_dtl>".$DummyDtl;


                $xml = $xml."                   </ib_shipment>
                                        </ListOfIbShipments>
                                        </LgfData>";

                //echo $xml;
                \Log::info('ListOfIbShipments Request: '.$xml);
                $url = env('API_BASE_URL').'wms/api/init_stage_interface/';
                $username = env('API_USER');
                $password = env('API_PASS');

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array("async" => "false", "xml_data" => $xml)));  //Post Fields
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $headers = [
                        'Content-Type: application/x-www-form-urlencoded',
                        'Authorization: Basic ' . base64_encode("$username:$password"),
                ];
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $server_output = curl_exec ($ch);
                curl_close ($ch);

                $xmlResponse = new \SimpleXMLElement($server_output);
                \Log::info('ListOfIbShipments Response: '.$server_output);
                /*echo "<br />Response<br />";
                echo "<pre>";
                echo print_r($xmlResponse);
                echo "</pre>";*/

                if($info_Receipt->is_upload_batch == "0"  && $request->LineNBR != "")
                {
                        $BatchNbrParts = explode("-",$info_Receipt->batch_nbr);
                        $BatchNbrPartsSend = $BatchNbrParts[0]."-".$BatchNbrParts[1]."-L0".$request->LineNBR."-".$BatchNbrParts[3];
                        $info_Receipt->batch_nbr = $BatchNbrPartsSend;
                }

                //dd($info_Receipt);

                $curl = curl_init();
                $username = env('API_USER');
                $password = env('API_PASS');
                curl_setopt_array($curl, array(
                CURLOPT_URL =>
                env('API_BASE_URL')."wms/api/receive_lpn/",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "facility_code=UDE&company_code=USBBU&lpn_nbr=".$info_LpnReceipt->lpn_nbr,
                CURLOPT_HTTPHEADER => array(
                                "Content-Type: application/x-www-form-urlencoded",
                                "Authorization: Basic ". base64_encode("$username:$password")
                        ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);

                \Log::info('Receive_lpn Response: '.$response);

                $info_LpnReceipt->printed = 1;
                $info_LpnReceipt->printed_by = Auth::User()->username;

                $info_LpnReceipt->save();


                $info_LpnReceipts = $info_Receipt->LpnReceipt()->where('printed',0)->Get();
                if($info_LpnReceipts->Count() == 0)
                {
                        $info_Receipt->status= "Closed";
                }

                $info_Receipt->save();

                $query = "SELECT m_receipt.id as 'ID', CONCAT(m_receipt.wms_asn_nbr, ' ' ,m_receipt.item_code) AS 'ReceiptNbrItem',
m_receipt.item_code AS 'ItemCode', owmitems.description as 'Description', m_receipt.std_pallet_qty AS 'CasesxPallet',
m_receipt.batch_nbr AS 'Batch', m_receipt.is_upload_batch AS 'isUploadBatch', m_receipt.shipped_qty AS 'TotalCases',
(select IFNULL(SUM(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'CasesReceived',
(select IFNULL(COUNT(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'PalletsReceived',
(select case when is_upload_expire_date=1 then expire_date else expire_date end from m_receipt_lpn where receipt_id = m_receipt.id limit 1) AS 'ExpireDate'
FROM m_receipt
LEFT JOIN owmitems ON owmitems.part_a = m_receipt.item_code
WHERE m_receipt.`status` IN ('Created', 'Receiving Started') AND m_receipt.wms_asn_nbr IS
NOT NULL
GROUP BY m_receipt.id";
                $info_ReceiptsNew = DB::select($query);

        return view('processreceipts', array('info_Receipts' => $info_ReceiptsNew, 'selctedID' => $request->RcID, 'Download' => '1', 'LPNID' => $info_LpnReceipt->id, 'LineNBR' => $request->LineNBR, 'xml' => $xml,'xmlResponse' => $xmlResponse, 'showNonStd' => '2', 'isUploadBatch' => $info_Receipt->is_upload_batch, 'Lpn_Nbr' => $info_LpnReceipt->lpn_nbr));
    }

	public function Pdf(Request $request, $id)
    {
                $info_LpnReceipt = LpnReceipt::FindOrFail($id);
                $info_Receipt = $info_LpnReceipt->Receipt()->First();

                $data = array("parameters" => array ("facility_id__code" => "UDE" ,"company_id__code" => "USBBU","container_nbr" => $info_LpnReceipt->lpn_nbr), "options" => array ("label_designer_code" => Auth::User()->label_designer_code, "label_count" => 2, "printer_name" => Auth::User()->printer_name) );
                $postdata = json_encode($data);

                $username = env('API_USER');
                $password = env('API_PASS');
                $curl = curl_init();
                curl_setopt_array($curl, array(
                CURLOPT_URL =>
                env('API_BASE_URL')."wms/lgfapi/v10/print/label/ib_container",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => $postdata,
                CURLOPT_HTTPHEADER => array(
                                "Content-Type: application/json",
                                "Authorization: Basic ". base64_encode("$username:$password")
                        ),
                ));
                $response = curl_exec($curl);
                curl_close($curl);
                \Log::info('Print Response: '.$response);
                return $response;
                //$pdf = PDF::loadView('pdf', compact('info_Receipt'), compact('info_LpnReceipt'));
        //return $pdf->download($info_LpnReceipt->lpn_nbr.'.pdf');
                /*if($request->view==1)
                {
                        return view('pdf', compact('info_Receipt'), compact('info_LpnReceipt'));
                }
                else
                {
                        $pdf = PDF::loadView('pdf', compact('info_Receipt'), compact('info_LpnReceipt'));
                return $pdf->download($info_LpnReceipt->lpn_nbr.'.pdf');
                }*/

    }

	public function viewLpns(Request $request)
    {
                $query = "SELECT *
                                FROM m_receipt_lpn
                                WHERE m_receipt_lpn.receipt_id = '".$request->receiptid."'";
                return $info_Receipts = DB::select($query);
    }

	public function store(Request $request)
        {
                return $request->all();
        }
}

