<?php


	public function Print(Request $request)
    {
		$info_Receipt = Receipt::FindOrFail($request->RcID);
		
		if($info_Receipt->LpnReceipt()->where('printed',1)->Get()->Count() == "0")
		{
			$infoPushWMS = DB::Select("SELECT m_receipt_lpn.id, m_receipt.wms_asn_nbr, m_receipt_lpn.lpn_nbr, m_receipt_lpn.item_code,
m_receipt_lpn.current_qty,
m_receipt_lpn.batch_nbr, m_receipt_lpn.expire_date
FROM m_receipt
LEFT JOIN m_receipt_lpn ON m_receipt_lpn.receipt_id = m_receipt.id
WHERE m_receipt.wms_asn_nbr = '".$info_Receipt->wms_asn_nbr."'
GROUP BY m_receipt_lpn.lpn_nbr");
			
			
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
						<company_code>BIMBO</company_code>
						<action_code>CREATE</action_code>
						<shipped_date>".date('Y-m-d')."</shipped_date>
						<origin_info>".$info_Receipt->item_code."</origin_info>
						<shipment_type>WO</shipment_type>
						</ib_shipment_hdr>";
						
			foreach($infoPushWMS as $data)
			{
				
				$info_LpnReceiptUpdate = LpnReceipt::FindOrFail($data->id);
				
				$BatchNbrPartsSend = $data->batch_nbr;
				if($info_Receipt->is_upload_batch == "0" && $request->LineNBR != "")
				{
					$BatchNbrParts = explode("-",$data->batch_nbr);
					$BatchNbrPartsSend = $BatchNbrParts[0]."-".$BatchNbrParts[1]."-L0".$request->LineNBR."-".$BatchNbrParts[3];
					$info_LpnReceiptUpdate->batch_nbr = $BatchNbrPartsSend;
					$info_LpnReceiptUpdate->save();
				}
				
				$putaway_type = "";
				//dd($info_LpnReceiptUpdate->OwmItem()->First()->cases_per_pallet); 
				if($info_LpnReceiptUpdate->OwmItem()->First()->cases_per_pallet != $data->current_qty)
				{
					$putaway_type = "<putaway_type>PARTIAL_PALLET</putaway_type>";
				}
				$xml = $xml . "<ib_shipment_dtl>
						<seq_nbr>".$data->id."</seq_nbr>
						<action_code>CREATE</action_code>
						<lpn_nbr>".$data->lpn_nbr."</lpn_nbr>
						<item_part_a>".$data->item_code."</item_part_a>
						<shipped_qty>".$data->current_qty."</shipped_qty>
						<expiry_date>".$data->expire_date."</expiry_date>
						<batch_nbr>".$BatchNbrPartsSend."</batch_nbr>
						".$putaway_type."
						</ib_shipment_dtl>";
				
			}
			
			
			$xml = $xml."			</ib_shipment>
						</ListOfIbShipments>
						</LgfData>";
			
			//echo $xml;
			//dd(1)	;
			$url = 'https://ta17.wms.ocs.oraclecloud.com:443/bimbo_test15/wms/api/init_stage_interface/';
			$username = "prologapp";
			$password = "App@001";
			
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
			$info_Receipt->in_wms = 1;
			$info_Receipt->save();
			
			//dd($info_Receipt );
			
		} //if($info_Receipt->shipped_qty == "0")
		
		
		$info_LpnReceipts = $info_Receipt->LpnReceipt()->where('printed',0)->Get();
		$info_LpnReceipt = $info_LpnReceipts->First();
		
		if($info_LpnReceipts->Count() == 1)
		{
			$info_Receipt->status= "Closed";
			$info_Receipt->save();
		}
		
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL =>
		"https://ta17.wms.ocs.oraclecloud.com:443/bimbo_test15/wms/api/receive_lpn/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "lpn_nbr=".$info_LpnReceipt->lpn_nbr,
		CURLOPT_HTTPHEADER => array(
				"Content-Type: application/x-www-form-urlencoded",
				"Authorization: Basic cHJvbG9nYXBwOkFwcEAwMDE="
			),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		
		
		
		$info_LpnReceipt->printed = 1;
		$info_LpnReceipt->printed_by = Auth::User()->username;
		$info_LpnReceipt->save();
		
		$query = "SELECT m_receipt.id as 'ID', CONCAT(m_receipt.wms_asn_nbr, ' ', m_receipt.item_code) AS 'ReceiptNbrItem',
m_receipt.item_code AS 'ItemCode', m_receipt.std_pallet_qty AS 'CasesxPallet',
m_receipt.batch_nbr AS 'Batch',m_receipt.shipped_qty AS 'TotalCases',
(select IFNULL(SUM(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'CasesReceived', 
(select IFNULL(COUNT(current_qty), 0) from  m_receipt_lpn where receipt_id = m_receipt.id and Printed=1) AS 'PalletsReceived'
FROM m_receipt
LEFT JOIN m_receipt_lpn ON m_receipt_lpn.receipt_id = m_receipt.id
WHERE m_receipt.`status` IN ('Created', 'Receiving Started') AND m_receipt.wms_asn_nbr IS
NOT NULL
GROUP BY m_receipt.id";
		$info_ReceiptsNew = DB::select($query);
		
        return view('processreceipts', array('info_Receipts' => $info_ReceiptsNew, 'selctedID' => $request->RcID, 'Download' => '1', 'LPNID' => $info_LpnReceipt->id, 'LineNBR' => $request->LineNBR));
    }