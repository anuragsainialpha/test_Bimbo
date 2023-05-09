<?php

namespace App\Imports;

use App\Models\OwmItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use DateTime;
use Auth;
use DB;
 
class OwmItemImport implements ToCollection, WithHeadingRow
{
	public $Responses;
	
	
    public function collection(Collection $rows)
    {		
		foreach ($rows as $row) 
        {
			if(isset($row['item_part_a']) && $row['item_part_a'] != "")
			{
				$info_OwmItem = OwmItem::Where('part_a',strval($row['item_part_a']))->OrWhere('barcode',strval($row['barcode']))->First();
				$Method = 'CREATE';
				if(!$info_OwmItem)
				{
					$Method = 'CREATE';
					$info_OwmItem = new OwmItem;
				}
				$info_OwmItem->part_a =  $row['item_part_a'];
				$info_OwmItem->description =  $row['description'];
				$info_OwmItem->barcode =  $row['barcode'];
				$info_OwmItem->cases_per_pallet =  $row['cases_per_pallet'];
				$info_OwmItem->unit_length =  $row['unit_length'];
				$info_OwmItem->unit_width =  $row['unit_width'];
				$info_OwmItem->unit_height =  $row['unit_height'];
				$info_OwmItem->unit_weight =  $row['unit_weight'];
				$info_OwmItem->unit_volume =  $row['unit_volume'];
				$info_OwmItem->std_case_qty =  $row['std_case_qty'];
				$info_OwmItem->external_style =  $row['external_style'];
				$info_OwmItem->product_life =  $row['product_life'];
				$info_OwmItem->percent_acceptable_product_life =  $row['percent_acceptable_product_life'];
				$info_OwmItem->putaway_type =  $row['putaway_type'];
				$info_OwmItem->req_batch_nbr_flg =  $row['req_batch_nbr_flg'];
				$info_OwmItem->company_code = 'USBBU';
				//<MessageId>".$info_OwmItem->id."</MessageId>
				$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
						<LgfData>
						  <Header>
							<DocumentVersion>8.0.0</DocumentVersion>
							<OriginSystem>abc</OriginSystem>
							<ClientEnvCode>qa</ClientEnvCode>
							<ParentCompanyCode>BIMBO</ParentCompanyCode>
							<Entity>item</Entity>
							<TimeStamp>".date('Y-d-m')."T".date('H:i:s')."</TimeStamp>
							<MessageId>".$info_OwmItem->part_a."</MessageId>
						  </Header>
						  <ListOfItems>
							<item>
								<company_code>".$info_OwmItem->company_code."</company_code>
								<item_alternate_code>".$info_OwmItem->item_alternate_code."</item_alternate_code>
								<part_a>".$info_OwmItem->part_a."</part_a>
								<part_b>".$info_OwmItem->part_b."</part_b>
								<part_c>".$info_OwmItem->part_c."</part_c>
								<part_d>".$info_OwmItem->part_d."</part_d>
								<part_e>".$info_OwmItem->part_e."</part_e>
								<part_f>".$info_OwmItem->part_f."</part_f>
								<pre_pack_code>".$info_OwmItem->pre_pack_code."</pre_pack_code>
								<action_code>".$Method."</action_code>
								<description>".$info_OwmItem->description."</description>
								<barcode>".$info_OwmItem->barcode."</barcode>
								<unit_cost>".$info_OwmItem->unit_cost."</unit_cost>
								<unit_length>".$info_OwmItem->unit_length."</unit_length>
								<unit_width>".$info_OwmItem->unit_width."</unit_width>
								<unit_height>".$info_OwmItem->unit_height."</unit_height>
								<unit_weight>".$info_OwmItem->unit_weight."</unit_weight>
								<unit_volume>".$info_OwmItem->unit_volume."</unit_volume>
								<hazmat>".$info_OwmItem->hazmat."</hazmat>
								<recv_type>".$info_OwmItem->recv_type."</recv_type>
								<ob_lpn_type>".$info_OwmItem->ob_lpn_type."</ob_lpn_type>
								<catch_weight_method>".$info_OwmItem->catch_weight_method."</catch_weight_method>
								<order_consolidation_attr>".$info_OwmItem->order_consolidation_attr."</order_consolidation_attr>
								<season_code>".$info_OwmItem->season_code."</season_code>
								<brand_code>".$info_OwmItem->brand_code."</brand_code>
								<cust_attr_1>".$info_OwmItem->cust_attr_1."</cust_attr_1>
								<cust_attr_2>".$info_OwmItem->cust_attr_2."</cust_attr_2>
								<retail_price>".$info_OwmItem->retail_price."</retail_price>
								<net_cost>".$info_OwmItem->net_cost."</net_cost>
								<currency_code>".$info_OwmItem->currency_code."</currency_code>
								<std_pack_qty>".$info_OwmItem->std_pack_qty."</std_pack_qty>
								<std_pack_length>".$info_OwmItem->std_pack_length."</std_pack_length>
								<std_pack_width>".$info_OwmItem->std_pack_width."</std_pack_width>
								<std_pack_height>".$info_OwmItem->std_pack_height."</std_pack_height>
								<std_pack_weight>".$info_OwmItem->std_pack_weight."</std_pack_weight>
								<std_pack_volume>".$info_OwmItem->std_pack_volume."</std_pack_volume>
								<std_case_qty>".$info_OwmItem->std_case_qty."</std_case_qty>
								<max_case_qty>".$info_OwmItem->max_case_qty."</max_case_qty>
								<std_case_length>".$info_OwmItem->std_case_length."</std_case_length>
								<std_case_width>".$info_OwmItem->std_case_width."</std_case_width>
								<std_case_height>".$info_OwmItem->std_case_height."</std_case_height>
								<std_case_weight>".$info_OwmItem->std_case_weight."</std_case_weight>
								<std_case_volume>".$info_OwmItem->std_case_volume."</std_case_volume>
								<dimension1>".$info_OwmItem->dimension1."</dimension1>
								<dimension2>".$info_OwmItem->dimension2."</dimension2>
								<dimension3>".$info_OwmItem->dimension3."</dimension3>
								<hierarchy1_code>".$info_OwmItem->hierarchy1_code."</hierarchy1_code>
								<hierarchy1_description>".$info_OwmItem->hierarchy1_description."</hierarchy1_description>
								<hierarchy2_code>".$info_OwmItem->hierarchy2_code."</hierarchy2_code>
								<hierarchy2_description>".$info_OwmItem->hierarchy2_description."</hierarchy2_description>
								<hierarchy3_code>".$info_OwmItem->hierarchy3_code."</hierarchy3_code>
								<hierarchy3_description>".$info_OwmItem->hierarchy3_description."</hierarchy3_description>
								<hierarchy4_code>".$info_OwmItem->hierarchy4_code."</hierarchy4_code>
								<hierarchy4_description>".$info_OwmItem->hierarchy4_description."</hierarchy4_description>
								<hierarchy5_code>".$info_OwmItem->hierarchy5_code."</hierarchy5_code>
								<hierarchy5_description>".$info_OwmItem->hierarchy5_description."</hierarchy5_description>
								<group_code>".$info_OwmItem->group_code."</group_code>
								<group_description>".$info_OwmItem->group_description."</group_description>
								<external_style>".$info_OwmItem->external_style."</external_style>
								<vas_group_code>".$info_OwmItem->vas_group_code."</vas_group_code>
								<short_descr>".$info_OwmItem->short_descr."</short_descr>
								<putaway_type>".$info_OwmItem->putaway_type."</putaway_type>
								<conveyable>".$info_OwmItem->conveyable."</conveyable>
								<stackability_code>".$info_OwmItem->stackability_code."</stackability_code>
								<sortable>".$info_OwmItem->sortable."</sortable>
								<min_dispatch_uom>".$info_OwmItem->min_dispatch_uom."</min_dispatch_uom>
								<product_life>".$info_OwmItem->product_life."</product_life>
								<percent_acceptable_product_life>".$info_OwmItem->percent_acceptable_product_life."</percent_acceptable_product_life>
								<lpns_per_tier>".$info_OwmItem->cases_per_pallet."</lpns_per_tier>
								<tiers_per_pallet>".$info_OwmItem->tiers_per_pallet."</tiers_per_pallet>
								<velocity_code>".$info_OwmItem->velocity_code."</velocity_code>
								<req_batch_nbr_flg>".$info_OwmItem->req_batch_nbr_flg."</req_batch_nbr_flg>
								<serial_nbr_tracking>".$info_OwmItem->serial_nbr_tracking."</serial_nbr_tracking>
								<regularity_code>".$info_OwmItem->regularity_code."</regularity_code>
								<harmonized_tariff_code>".$info_OwmItem->harmonized_tariff_code."</harmonized_tariff_code>
								<harmonized_tariff_description>".$info_OwmItem->harmonized_tariff_description."</harmonized_tariff_description>
								<full_oblpn_type>".$info_OwmItem->full_oblpn_type."</full_oblpn_type>
								<case_oblpn_type>".$info_OwmItem->case_oblpn_type."</case_oblpn_type>
								<pack_oblpn_type>".$info_OwmItem->pack_oblpn_type."</pack_oblpn_type>
								<description_2>".$info_OwmItem->description_2."</description_2>
								<description_3>".$info_OwmItem->description_3."</description_3>
								<invn_attr_a_tracking>".$info_OwmItem->invn_attr_a_tracking."</invn_attr_a_tracking>
								<invn_attr_a_dflt_value>".$info_OwmItem->invn_attr_a_dflt_value."</invn_attr_a_dflt_value>
								<invn_attr_b_tracking>".$info_OwmItem->invn_attr_b_tracking."</invn_attr_b_tracking>
								<invn_attr_b_dflt_value>".$info_OwmItem->invn_attr_b_dflt_value."</invn_attr_b_dflt_value>
								<invn_attr_c_tracking>".$info_OwmItem->invn_attr_c_tracking."</invn_attr_c_tracking>
								<invn_attr_c_dflt_value>".$info_OwmItem->invn_attr_c_dflt_value."</invn_attr_c_dflt_value>
								<nmfc_code>".$info_OwmItem->nmfc_code."</nmfc_code>
								<conversion_factor>".$info_OwmItem->conversion_factor."</conversion_factor>
								<invn_attr_d_tracking>".$info_OwmItem->invn_attr_d_tracking."</invn_attr_d_tracking>
								<invn_attr_e_tracking>".$info_OwmItem->invn_attr_e_tracking."</invn_attr_e_tracking>
								<invn_attr_f_tracking>".$info_OwmItem->invn_attr_f_tracking."</invn_attr_f_tracking>
								<invn_attr_g_tracking>".$info_OwmItem->invn_attr_g_tracking."</invn_attr_g_tracking>
								<host_aware_item_flg>".$info_OwmItem->host_aware_item_flg."</host_aware_item_flg>
								<packing_tolerance_percent>".$info_OwmItem->packing_tolerance_percent."</packing_tolerance_percent>
							</item>
						  </ListOfItems>
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
				//dd($xmlResponse);
				/*echo "<br />Response<br />";
				echo "<pre>";
				echo print_r($server_output);
				echo "</pre>";*/
				if($xmlResponse->success == "True")
				{
					$info_OwmItem->save();
					
					$this->Responses .= "";
				}
				else
				{
					$this->Responses .= "<br />item_part_a: ".$row['item_part_a']." => ".dom_import_simplexml($xmlResponse->response->message)->nodeValue;
				}
			}
		}
    }
}
