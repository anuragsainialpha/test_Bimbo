<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Receipt;
use DB;

class ApiController extends Controller
{
	public function postVerifiedShipments(Request $request)
    {
		//alter table owmsvs add column ref_order_nbr varchar(30) after po_dtl_line_schedule_nbrs
		//alter table owmsvs add column ref_order_seq_nbr varchar(30) after ref_order_nbr
		
		$input = file_get_contents('php://input');
		$order_hdr_id="";
		$InsKeys = "";
		$InsValues = "";
		$xmlString = $input;
		$xml = new \SimpleXMLElement($xmlString);
		
		
		$ib_shipment_hdr = $xml->ListOfVerifiedIbShipments->ib_shipment->ib_shipment_hdr;
		
		foreach ($xml->ListOfVerifiedIbShipments->ib_shipment->ib_shipment_dtl as $ib_shipment_dtl)
		{
			$InsKeys .= " shipment_nbr, facility_code, company_code, trailer_nbr, ref_nbr, shipment_type, load_nbr, manifest_nbr, trailer_type, vendor_info, origin_info, origin_code, orig_shipped_units, shipped_date, orig_shipped_lpns, shipment_hdr_cust_field_1, shipment_hdr_cust_field_2, shipment_hdr_cust_field_3, shipment_hdr_cust_field_4, shipment_hdr_cust_field_5, verification_date, returned_from_facility_code,";
		$InsValues .= " '$ib_shipment_hdr->shipment_nbr', '$ib_shipment_hdr->facility_code', '$ib_shipment_hdr->company_code', '$ib_shipment_hdr->trailer_nbr', '$ib_shipment_hdr->ref_nbr', '$ib_shipment_hdr->shipment_type', '$ib_shipment_hdr->load_nbr', '$ib_shipment_hdr->manifest_nbr', '$ib_shipment_hdr->trailer_type', '$ib_shipment_hdr->vendor_info', '$ib_shipment_hdr->origin_info', '$ib_shipment_hdr->origin_code', '$ib_shipment_hdr->orig_shipped_units', '$ib_shipment_hdr->shipped_date', '$ib_shipment_hdr->orig_shipped_lpns', '$ib_shipment_hdr->shipment_hdr_cust_field_1', '$ib_shipment_hdr->shipment_hdr_cust_field_2', '$ib_shipment_hdr->shipment_hdr_cust_field_3', '$ib_shipment_hdr->shipment_hdr_cust_field_4', '$ib_shipment_hdr->shipment_hdr_cust_field_5', '$ib_shipment_hdr->verification_date', '$ib_shipment_hdr->returned_from_facility_code',";
		
			foreach ($ib_shipment_dtl as $key => $value)
			{
				$InsKeys .= " $key,";
				$InsValues .= " '$value',";
			}
			
			if($InsValues != "")
			{
				$InsKeys = rtrim($InsKeys,',');
				$InsValues = rtrim($InsValues,',');
			}
			
			$query = "insert into owmsvs ($InsKeys) values ($InsValues)";
			//DB::insert($query);
			$InsKeys = "";
			$InsValues = "";
			
			$info_Receipt = Receipt::Where('wms_asn_nbr', $ib_shipment_hdr->shipment_nbr)->First();
			if($info_Receipt)
			{
				$info_Receipt->status = 'Closed';
				$info_Receipt->save();
			}
		}
		
		return "OK";
    }
	
	public function postOutboundLoads(Request $request)
    {
		$input = file_get_contents('php://input');
		$order_hdr_id="";
		$InsKeys = "";
		$InsValues = "";
		$xmlString = $input;
		$xml = new \SimpleXMLElement($xmlString);
		
		
		$load = $xml->ListOfShippedLoads->shipped_load->load;
		
		foreach ($xml->ListOfShippedLoads->shipped_load->ob_stop as $ob_stop)
		{
			$InsKeys .= " facility_code, company_code, action_code, load_type, load_manifest_nbr, trailer_nbr, trailer_type, driver, seal_nbr, pro_nbr, route_nbr, freight_class, hdr_bol_nbr, total_nbr_of_oblpns, total_weight, total_volume, total_shipping_charge, ship_date, sched_delivery_date, carrier_code, externally_planned_load_nbr, ship_date_time, sched_delivery_date_time, time_zone_code,";
		$InsValues .= " '$load->facility_code', '$load->company_code', '$load->action_code', '$load->load_type', '$load->load_manifest_nbr', '$load->trailer_nbr', '$load->trailer_type', '$load->driver', '$load->seal_nbr', '$load->pro_nbr', '$load->route_nbr', '$load->freight_class', '$load->hdr_bol_nbr', '$load->total_nbr_of_oblpns', '$load->total_weight', '$load->total_volume', '$load->total_shipping_charge', '$load->ship_date', '$load->sched_delivery_date', '$load->carrier_code', '$load->externally_planned_load_nbr', '$load->ship_date_time', '$load->sched_delivery_date_time', '$load->time_zone_code',";
			
			
			$InsKeys .= " line_nbr, seq_nbr, stop_shipment_nbr, stop_bol_nbr, stop_nbr_of_oblpns, stop_weight, stop_volume, stop_shipping_charge, shipto_facility_code, shipto_name, shipto_addr, shipto_addr2, shipto_addr3, shipto_city, shipto_state, shipto_zip, shipto_country, shipto_phone_nbr, shipto_email, shipto_contact, dest_facility_code, cust_name, cust_addr, cust_addr2, cust_addr3, cust_city, cust_state, cust_zip, cust_country, cust_phone_nbr, cust_email, cust_contact, cust_nbr, order_nbr, ord_date, exp_date, req_ship_date, start_ship_date, stop_ship_date, host_allocation_nbr, customer_po_nbr, sales_order_nbr, sales_channel, dest_dept_nbr, order_hdr_cust_field_1, order_hdr_cust_field_2, order_hdr_cust_field_3, order_hdr_cust_field_4, order_hdr_cust_field_5, order_seq_nbr, order_dtl_cust_field_1, order_dtl_cust_field_2, order_dtl_cust_field_3, order_dtl_cust_field_4, order_dtl_cust_field_5, ob_lpn_nbr, item_alternate_code, item_part_a, item_part_b, item_part_c, item_part_d, item_part_e, item_part_f, pre_pack_code, pre_pack_ratio, pre_pack_ratio_seq, pre_pack_total_units, invn_attr_a, invn_attr_b, invn_attr_c, hazmat, shipped_uom, shipped_qty, pallet_nbr, dest_company_code, batch_nbr, expiry_date, tracking_nbr, master_tracking_nbr, package_type, payment_method, carrier_account_nbr, ship_via_code, ob_lpn_weight, ob_lpn_volume, ob_lpn_shipping_charge, ob_lpn_type, asset_nbr, asset_seal_nbr, serial_nbr, customer_po_type, customer_vendor_code,";
		$InsValues .= " '$ob_stop->line_nbr', '$ob_stop->seq_nbr', '$ob_stop->stop_shipment_nbr', '$ob_stop->stop_bol_nbr', '$ob_stop->stop_nbr_of_oblpns', '$ob_stop->stop_weight', '$ob_stop->stop_volume', '$ob_stop->stop_shipping_charge', '$ob_stop->shipto_facility_code', '$ob_stop->shipto_name', '$ob_stop->shipto_addr', '$ob_stop->shipto_addr2', '$ob_stop->shipto_addr3', '$ob_stop->shipto_city', '$ob_stop->shipto_state', '$ob_stop->shipto_zip', '$ob_stop->shipto_country', '$ob_stop->shipto_phone_nbr', '$ob_stop->shipto_email', '$ob_stop->shipto_contact', '$ob_stop->dest_facility_code', '$ob_stop->cust_name', '$ob_stop->cust_addr', '$ob_stop->cust_addr2', '$ob_stop->cust_addr3', '$ob_stop->cust_city', '$ob_stop->cust_state', '$ob_stop->cust_zip', '$ob_stop->cust_country', '$ob_stop->cust_phone_nbr', '$ob_stop->cust_email', '$ob_stop->cust_contact', '$ob_stop->cust_nbr', '$ob_stop->order_nbr', '$ob_stop->ord_date', '$ob_stop->exp_date', '$ob_stop->req_ship_date', '$ob_stop->start_ship_date', '$ob_stop->stop_ship_date', '$ob_stop->host_allocation_nbr', '$ob_stop->customer_po_nbr', '$ob_stop->sales_order_nbr', '$ob_stop->sales_channel', '$ob_stop->dest_dept_nbr', '$ob_stop->order_hdr_cust_field_1', '$ob_stop->order_hdr_cust_field_2', '$ob_stop->order_hdr_cust_field_3', '$ob_stop->order_hdr_cust_field_4', '$ob_stop->order_hdr_cust_field_5', '$ob_stop->order_seq_nbr', '$ob_stop->order_dtl_cust_field_1', '$ob_stop->order_dtl_cust_field_2', '$ob_stop->order_dtl_cust_field_3', '$ob_stop->order_dtl_cust_field_4', '$ob_stop->order_dtl_cust_field_5', '$ob_stop->ob_lpn_nbr', '$ob_stop->item_alternate_code', '$ob_stop->item_part_a', '$ob_stop->item_part_b', '$ob_stop->item_part_c', '$ob_stop->item_part_d', '$ob_stop->item_part_e', '$ob_stop->item_part_f', '$ob_stop->pre_pack_code', '$ob_stop->pre_pack_ratio', '$ob_stop->pre_pack_ratio_seq', '$ob_stop->pre_pack_total_units', '$ob_stop->invn_attr_a', '$ob_stop->invn_attr_b', '$ob_stop->invn_attr_c', '$ob_stop->hazmat', '$ob_stop->shipped_uom', '$ob_stop->shipped_qty', '$ob_stop->pallet_nbr', '$ob_stop->dest_company_code', '$ob_stop->batch_nbr', '$ob_stop->expiry_date', '$ob_stop->tracking_nbr', '$ob_stop->master_tracking_nbr', '$ob_stop->package_type', '$ob_stop->payment_method', '$ob_stop->carrier_account_nbr', '$ob_stop->ship_via_code', '$ob_stop->ob_lpn_weight', '$ob_stop->ob_lpn_volume', '$ob_stop->ob_lpn_shipping_charge', '$ob_stop->ob_lpn_type', '$ob_stop->asset_nbr', '$ob_stop->asset_seal_nbr', '$ob_stop->serial_nbr', '$ob_stop->customer_po_type', '$ob_stop->customer_vendor_code',"; 
			/*foreach ($ob_stop as $key => $value)
			{
				$InsKeys .= " $key,";
				$InsValues .= " '$value',";
			}*/
			
			if($InsValues != "")
			{
				$InsKeys = rtrim($InsKeys,',');
				$InsValues = rtrim($InsValues,',');
			}
			
			echo $query = "insert into owmobl ($InsKeys) values ($InsValues)";
			DB::insert($query);
			$InsKeys = "";
			$InsValues = "";
		}
		
		return "OK";
    }
	
	public function postInventoryHistory(Request $request)
    {
		$input = file_get_contents('php://input');
		$order_hdr_id="";
		$InsKeys = "";
		$InsValues = "";
		$xmlString = $input;
		$xml = new \SimpleXMLElement($xmlString);
		//alter table owmihs add column lock_code_priority varchar(30) after ref_code_13
		//alter table owmihs change  lock_code_prty  lock_code_priority varchar(30)
		
		foreach ($xml->ListOfInventoryHistories->inventory_history as $inventory_history)
		{
			foreach ($inventory_history as $key => $value)
			{
				$InsKeys .= " $key,";
				$InsValues .= " '$value',";
			}
			
			if($InsValues != "")
			{
				$InsKeys = rtrim($InsKeys,',');
				$InsValues = rtrim($InsValues,',');
			}
			
			$query = "insert into owmihs ($InsKeys) values ($InsValues)";
			DB::insert($query);
			$InsKeys = "";
			$InsValues = "";
		}
		return "OK";
    }
}
