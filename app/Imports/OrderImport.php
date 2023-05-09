<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DateTime;
 
class OrderImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rowsUnsort)
    {	
		//dd($rowsUnsort);
		$rows = $rowsUnsort->sortBy('so_number');
		
		$OrderNumber = "";
		$xml = "";
		$seq = 1;
		foreach ($rows as $row) 
        {
			if(isset($row['so_number']) && $row['so_number'] != "")
			{
				if($OrderNumber == "")
				{
					$OrderNumber = $row['so_number'];
					$xml = $this->getHeaderXML($row);
					$seq = 1;
				}
				
				if($OrderNumber != $row['so_number'])
				{
					
					$xml .= $this->getFooterXML($row);
					$this->postXML($xml);
					
					//New order start
					$OrderNumber = $row['so_number'];
					$responseArray = array();
					$xml = $this->getHeaderXML($row);
					$seq = 1;
				}
				
				$xml .= $this->getDetailXML($row, $seq);
				$seq ++;
				$responseArray[] = $row;
			}
		}
		
		if($xml != "")
		{
			$xml .= $this->getFooterXML($row);
			$this->postXML($xml);
		}
		
		//dd(1);
		
    }
	
	function postXML($xml)
	{
		/*echo "<br />XML<br />";
		echo "<pre>";
		echo htmlentities($xml);
		echo "</pre>";*/
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
		
		/*echo "<br />Response<br />";
		echo "<pre>";
		echo print($server_output);
		echo "</pre>";*/
	
	}
	
	function getHeaderXML($row)
	{
		return $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
		<LgfData>
		  <Header>
			<DocumentVersion>".$row['order_source']."</DocumentVersion>
			<OriginSystem>BIMBO</OriginSystem>
			<ClientEnvCode>BIMBO</ClientEnvCode>
			<ParentCompanyCode></ParentCompanyCode>
			<Entity>order</Entity>
			<TimeStamp>".date('Y-m-d')."T".date('H:i:s')."</TimeStamp>
			<MessageId>ord00000001</MessageId>
		  </Header>
		  <ListOfOrders>
			<order>
			  <order_hdr>
				<facility_code>".$row['inventory_org']."</facility_code>
				<company_code>USBBU</company_code>
				<order_nbr>".$row['so_number']."</order_nbr>
				<order_type>SALES_ORDER</order_type>
				<ord_date>".date('Y-m-d')."</ord_date>
				<exp_date></exp_date>
				<req_ship_date>".($row['request_date'] != "" ?(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['request_date']))->format('Y-m-d') : "")."</req_ship_date>
				<dest_facility_code>".$row['customer_acct_number']."</dest_facility_code>
				<cust_name></cust_name>
				<cust_addr></cust_addr>
				<cust_addr2></cust_addr2>
				<cust_addr3></cust_addr3>
				<ref_nbr></ref_nbr>
				<action_code>CREATE</action_code>
				<route_nbr>".$row['so_number']."</route_nbr>
				<cust_city></cust_city>
				<cust_state></cust_state>
				<cust_zip></cust_zip>
				<cust_country></cust_country>
				<cust_phone_nbr></cust_phone_nbr>
				<cust_email></cust_email>
				<cust_contact></cust_contact>
				<cust_nbr></cust_nbr>
				<shipto_facility_code>".$row['customer_acct_number']."</shipto_facility_code>
				<shipto_name></shipto_name>
				<shipto_addr></shipto_addr>
				<shipto_addr2></shipto_addr2>
				<shipto_addr3></shipto_addr3>
				<shipto_city></shipto_city>
				<shipto_state></shipto_state>
				<shipto_zip></shipto_zip>
				<shipto_country></shipto_country>
				<shipto_phone_nbr></shipto_phone_nbr>
				<shipto_email></shipto_email>
				<shipto_contact></shipto_contact>
				<dest_company_code></dest_company_code>
				<priority></priority>
				<ship_via_code></ship_via_code>
				<carrier_account_nbr></carrier_account_nbr>
				<payment_method></payment_method>
				<host_allocation_nbr></host_allocation_nbr>
				<customer_po_nbr>".$row['customer_po_ref']."</customer_po_nbr>
				<sales_order_nbr></sales_order_nbr>
				<sales_channel></sales_channel>
				<dest_dept_nbr></dest_dept_nbr>
				<start_ship_date></start_ship_date>
				<stop_ship_date></stop_ship_date>
				<spl_instr></spl_instr>
				<vas_group_code></vas_group_code>
				<currency_code></currency_code>
				<stage_location_barcode></stage_location_barcode>
				<cust_field_1>".$row['customer_name']."</cust_field_1>
				<cust_field_2>".$row['ship_to_address']."</cust_field_2>
				<cust_field_3></cust_field_3>
				<cust_field_4></cust_field_4>
				<cust_field_5></cust_field_5>
				<ob_lpn_type></ob_lpn_type>
				<gift_msg></gift_msg>
				<sched_ship_date></sched_ship_date>
				<customer_po_type></customer_po_type>
				<customer_vendor_code></customer_vendor_code>
				<cust_date_1>".($row['scheduled_ship_date'] != "" ?(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['scheduled_ship_date']))->format('Y-m-d') : "")."</cust_date_1>
				<cust_date_2></cust_date_2>
				<cust_date_3></cust_date_3>
				<cust_date_4></cust_date_4>
				<cust_date_5></cust_date_5>
				<cust_number_1></cust_number_1>
				<cust_number_2></cust_number_2>
				<cust_number_3></cust_number_3>
				<cust_number_4></cust_number_4>
				<cust_number_5></cust_number_5>
				<cust_decimal_1></cust_decimal_1>
				<cust_decimal_2></cust_decimal_2>
				<cust_decimal_3></cust_decimal_3>
				<cust_decimal_4></cust_decimal_4>
				<cust_decimal_5></cust_decimal_5>
				<cust_short_text_1></cust_short_text_1>
				<cust_short_text_2></cust_short_text_2>
				<cust_short_text_3></cust_short_text_3>
				<cust_short_text_4></cust_short_text_4>
				<cust_short_text_5></cust_short_text_5>
				<cust_short_text_6></cust_short_text_6>
				<cust_short_text_7></cust_short_text_7>
				<cust_short_text_8></cust_short_text_8>
				<cust_short_text_9></cust_short_text_9>
				<cust_short_text_10></cust_short_text_10>
				<cust_short_text_11></cust_short_text_11>
				<cust_short_text_12></cust_short_text_12>
				<cust_long_text_1></cust_long_text_1>
				<cust_long_text_2></cust_long_text_2>
				<cust_long_text_3></cust_long_text_3>
				<order_nbr_to_replace></order_nbr_to_replace>
				<lpn_type_class></lpn_type_class>
				<billto_carrier_account_nbr></billto_carrier_account_nbr>
				<duties_carrier_account_nbr></duties_carrier_account_nbr>
				<duties_payment_method></duties_payment_method>
				<customs_broker_contact></customs_broker_contact>
				<erp_source_hdr_ref></erp_source_hdr_ref>
				<erp_source_system_ref></erp_source_system_ref>
				<group_ref></group_ref>
				<externally_planned_load_flg></externally_planned_load_flg>
			  </order_hdr>";
	}
	
	function getDetailXML($row, $seq)
	{
		return $xml = "<order_dtl>
			<seq_nbr>".$seq."</seq_nbr>
			<item_alternate_code></item_alternate_code>
			<item_part_a>".$row['ordered_item']."</item_part_a>
			<item_part_b></item_part_b>
			<item_part_c></item_part_c>
			<item_part_d></item_part_d>
			<item_part_e></item_part_e>
			<item_part_f></item_part_f>
			<pre_pack_code></pre_pack_code>
			<pre_pack_ratio></pre_pack_ratio>
			<pre_pack_ratio_seq></pre_pack_ratio_seq>
			<pre_pack_total_units></pre_pack_total_units>
			<ord_qty>".$row['ordered_quantity']."</ord_qty>
			<req_cntr_nbr></req_cntr_nbr>
			<action_code>CREATE</action_code>
			<batch_nbr></batch_nbr>
			<invn_attr_a></invn_attr_a>
			<invn_attr_b></invn_attr_b>
			<invn_attr_c></invn_attr_c>
			<cost>1</cost>
			<sale_price>1</sale_price>
			<po_nbr></po_nbr>
			<shipment_nbr></shipment_nbr>
			<dest_facility_attr_a></dest_facility_attr_a>
			<dest_facility_attr_b></dest_facility_attr_b>
			<dest_facility_attr_c></dest_facility_attr_c>
			<ref_nbr_1></ref_nbr_1>
			<host_ob_lpn_nbr></host_ob_lpn_nbr>
			<spl_instr></spl_instr>
			<vas_activity_code></vas_activity_code>
			<cust_field_1></cust_field_1>
			<cust_field_2></cust_field_2>
			<cust_field_3></cust_field_3>
			<cust_field_4></cust_field_4>
			<cust_field_5></cust_field_5>
			<voucher_nbr></voucher_nbr>
			<voucher_amount></voucher_amount>
			<voucher_exp_date></voucher_exp_date>
			<req_pallet_nbr></req_pallet_nbr>
			<lock_code></lock_code>
			<serial_nbr></serial_nbr>
			<item_barcode></item_barcode>
			<uom></uom>
			<cust_date_1></cust_date_1>
			<cust_date_2></cust_date_2>
			<cust_date_3></cust_date_3>
			<cust_date_4></cust_date_4>
			<cust_date_5></cust_date_5>
			<cust_number_1></cust_number_1>
			<cust_number_2></cust_number_2>
			<cust_number_3></cust_number_3>
			<cust_number_4></cust_number_4>
			<cust_number_5></cust_number_5>
			<cust_decimal_1></cust_decimal_1>
			<cust_decimal_2></cust_decimal_2>
			<cust_decimal_3></cust_decimal_3>
			<cust_decimal_4></cust_decimal_4>
			<cust_decimal_5></cust_decimal_5>
			<cust_short_text_1></cust_short_text_1>
			<cust_short_text_2></cust_short_text_2>
			<cust_short_text_3></cust_short_text_3>
			<cust_short_text_4></cust_short_text_4>
			<cust_short_text_5></cust_short_text_5>
			<cust_short_text_6></cust_short_text_6>
			<cust_short_text_7></cust_short_text_7>
			<cust_short_text_8></cust_short_text_8>
			<cust_short_text_9></cust_short_text_9>
			<cust_short_text_10></cust_short_text_10>
			<cust_short_text_11></cust_short_text_11>
			<cust_short_text_12></cust_short_text_12>
			<cust_long_text_1></cust_long_text_1>
			<cust_long_text_2></cust_long_text_2>
			<cust_long_text_3></cust_long_text_3>
			<invn_attr_d></invn_attr_d>
			<invn_attr_e></invn_attr_e>
			<invn_attr_f></invn_attr_f>
			<invn_attr_g></invn_attr_g>
			<ship_request_line></ship_request_line>
			<unit_declared_value></unit_declared_value>
			<invn_attr_h></invn_attr_h>
			<invn_attr_i></invn_attr_i>
			<invn_attr_j></invn_attr_j>
			<invn_attr_k></invn_attr_k>
			<invn_attr_l></invn_attr_l>
			<invn_attr_m></invn_attr_m>
			<invn_attr_n></invn_attr_n>
			<invn_attr_o></invn_attr_o>
			<erp_source_line_ref></erp_source_line_ref>
			<erp_source_shipment_ref></erp_source_shipment_ref>
			<erp_fulfillment_line_ref></erp_fulfillment_line_ref>
			<sales_order_line_ref></sales_order_line_ref>
			<sales_order_schedule_ref></sales_order_schedule_ref>
		  </order_dtl>";
	}
	
	function getFooterXML($row)
	{
		return $xml =  '
						</order>
						</ListOfOrders>
					</LgfData>';
	}
}
