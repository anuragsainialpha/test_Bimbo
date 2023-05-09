<?php
  
namespace App\Http\Controllers;

use App\Models\OwmItem;
use Illuminate\Http\Request;
use App\Imports\OwmItemImport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;
use DB;
  
class OwmItemController extends Controller
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
        return view('owmitem.index');
    }
   
    /**
     * Display the specified resource.
     *
     * @param  \App\OwmItem  $owmitem
     * @return \Illuminate\Http\Response
     */
    public function show(OwmItem $owmitem)
    {
        return view('owmitem.show',compact('owmitem'));
    }
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\OwmItem  $owmitem
     * @return \Illuminate\Http\Response
     */
    public function edit(OwmItem $owmitem)
    {
        return view('owmitem.edit',compact('owmitem'));
    }
  	
	public function importWarehouseItems() 
    {
		$owmItemImport = new OwmItemImport;
        Excel::import($owmItemImport,request()->file('owmitem'));
        return back()->with('Responses', $owmItemImport->Responses);
    }
	
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\OwmItem  $owmitem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OwmItem $owmitem)
    {
		$owmitem->company_code = $request->company_code;
		$owmitem->item_alternate_code = $request->item_alternate_code;
		$owmitem->part_a = $request->part_a;
		$owmitem->part_b = $request->part_b;
		$owmitem->part_c = $request->part_c;
		$owmitem->part_d = $request->part_d;
		$owmitem->part_e = $request->part_e;
		$owmitem->part_f = $request->part_f;
		$owmitem->pre_pack_code = $request->pre_pack_code;
		$owmitem->action_code = $request->action_code;
		$owmitem->description = $request->description;
		$owmitem->barcode = $request->barcode;
		$owmitem->cases_per_pallet = $request->cases_per_pallet;
		$owmitem->unit_cost = $request->unit_cost;
		$owmitem->unit_length = $request->unit_length;
		$owmitem->unit_width = $request->unit_width;
		$owmitem->unit_height = $request->unit_height;
		$owmitem->unit_weight = $request->unit_weight;
		$owmitem->unit_volume = $request->unit_volume;
		$owmitem->hazmat = $request->hazmat;
		$owmitem->recv_type = $request->recv_type;
		$owmitem->ob_lpn_type = $request->ob_lpn_type;
		$owmitem->catch_weight_method = $request->catch_weight_method;
		$owmitem->order_consolidation_attr = $request->order_consolidation_attr;
		$owmitem->season_code = $request->season_code;
		$owmitem->brand_code = $request->brand_code;
		$owmitem->cust_attr_1 = $request->cust_attr_1;
		$owmitem->cust_attr_2 = $request->cust_attr_2;
		$owmitem->retail_price = $request->retail_price;
		$owmitem->net_cost = $request->net_cost;
		$owmitem->currency_code = $request->currency_code;
		$owmitem->std_pack_qty = $request->std_pack_qty;
		$owmitem->std_pack_length = $request->std_pack_length;
		$owmitem->std_pack_width = $request->std_pack_width;
		$owmitem->std_pack_height = $request->std_pack_height;
		$owmitem->std_pack_weight = $request->std_pack_weight;
		$owmitem->std_pack_volume = $request->std_pack_volume;
		$owmitem->std_case_qty = $request->std_case_qty;
		$owmitem->max_case_qty = $request->max_case_qty;
		$owmitem->std_case_length = $request->std_case_length;
		$owmitem->std_case_width = $request->std_case_width;
		$owmitem->std_case_height = $request->std_case_height;
		$owmitem->std_case_weight = $request->std_case_weight;
		$owmitem->std_case_volume = $request->std_case_volume;
		$owmitem->dimension1 = $request->dimension1;
		$owmitem->dimension2 = $request->dimension2;
		$owmitem->dimension3 = $request->dimension3;
		$owmitem->hierarchy1_code = $request->hierarchy1_code;
		$owmitem->hierarchy1_description = $request->hierarchy1_description;
		$owmitem->hierarchy2_code = $request->hierarchy2_code;
		$owmitem->hierarchy2_description = $request->hierarchy2_description;
		$owmitem->hierarchy3_code = $request->hierarchy3_code;
		$owmitem->hierarchy3_description = $request->hierarchy3_description;
		$owmitem->hierarchy4_code = $request->hierarchy4_code;
		$owmitem->hierarchy4_description = $request->hierarchy4_description;
		$owmitem->hierarchy5_code = $request->hierarchy5_code;
		$owmitem->hierarchy5_description = $request->hierarchy5_description;
		$owmitem->group_code = $request->group_code;
		$owmitem->group_description = $request->group_description;
		$owmitem->external_style = $request->external_style;
		$owmitem->vas_group_code = $request->vas_group_code;
		$owmitem->short_descr = $request->short_descr;
		$owmitem->putaway_type = $request->putaway_type;
		$owmitem->conveyable = $request->conveyable;
		$owmitem->stackability_code = $request->stackability_code;
		$owmitem->sortable = $request->sortable;
		$owmitem->min_dispatch_uom = $request->min_dispatch_uom;
		$owmitem->product_life = $request->product_life;
		$owmitem->percent_acceptable_product_life = $request->percent_acceptable_product_life;
		$owmitem->lpns_per_tier = $request->lpns_per_tier;
		$owmitem->tiers_per_pallet = $request->tiers_per_pallet;
		$owmitem->velocity_code = $request->velocity_code;
		$owmitem->req_batch_nbr_flg = $request->req_batch_nbr_flg;
		$owmitem->serial_nbr_tracking = $request->serial_nbr_tracking;
		$owmitem->regularity_code = $request->regularity_code;
		$owmitem->harmonized_tariff_code = $request->harmonized_tariff_code;
		$owmitem->harmonized_tariff_description = $request->harmonized_tariff_description;
		$owmitem->full_oblpn_type = $request->full_oblpn_type;
		$owmitem->case_oblpn_type = $request->case_oblpn_type;
		$owmitem->pack_oblpn_type = $request->pack_oblpn_type;
		$owmitem->description_2 = $request->description_2;
		$owmitem->description_3 = $request->description_3;
		$owmitem->invn_attr_a_tracking = $request->invn_attr_a_tracking;
		$owmitem->invn_attr_a_dflt_value = $request->invn_attr_a_dflt_value;
		$owmitem->invn_attr_b_tracking = $request->invn_attr_b_tracking;
		$owmitem->invn_attr_b_dflt_value = $request->invn_attr_b_dflt_value;
		$owmitem->invn_attr_c_tracking = $request->invn_attr_c_tracking;
		$owmitem->invn_attr_c_dflt_value = $request->invn_attr_c_dflt_value;
		$owmitem->NMFC_code = $request->NMFC_code;
		$owmitem->conversion_factor = $request->conversion_factor;
		$owmitem->invn_attr_d_tracking = $request->invn_attr_d_tracking;
		$owmitem->invn_attr_e_tracking = $request->invn_attr_e_tracking;
		$owmitem->invn_attr_f_tracking = $request->invn_attr_f_tracking;
		$owmitem->invn_attr_g_tracking = $request->invn_attr_g_tracking;
		$owmitem->host_aware_item_flg = $request->host_aware_item_flg;
		$owmitem->packing_tolerance_percent = $request->packing_tolerance_percent;
		$owmitem->un_number = $request->un_number;
		$owmitem->un_class = $request->un_class;
		$owmitem->un_description = $request->un_description;
		$owmitem->packing_group = $request->packing_group;
		$owmitem->proper_shipping_name = $request->proper_shipping_name;
		$owmitem->excepted_qty_instr = $request->excepted_qty_instr;
		$owmitem->limited_qty_flg = $request->limited_qty_flg;
		$owmitem->fulldg_flg = $request->fulldg_flg;
		$owmitem->hazard_statement = $request->hazard_statement;
		$owmitem->shipping_temperature_instr = $request->shipping_temperature_instr;
		$owmitem->carrier_commodity_description = $request->carrier_commodity_description;
		$owmitem->shipping_conversion_factor = $request->shipping_conversion_factor;
		$owmitem->shipping_uom = $request->shipping_uom;
		$owmitem->hazmat_packaging_description = $request->hazmat_packaging_description;
		$owmitem->handle_decimal_qty_flg = $request->handle_decimal_qty_flg;
		$owmitem->dummy_sku_flg = $request->dummy_sku_flg;
		$owmitem->pack_with_wave_flg = $request->pack_with_wave_flg;

		$owmitem->save();
		
		$info_OwmItem = $owmitem;
		$xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
					<LgfData>
					  <Header>
						<DocumentVersion>8.0.0</DocumentVersion>
						<OriginSystem>abc</OriginSystem>
						<ClientEnvCode>qa</ClientEnvCode>
						<ParentCompanyCode>BIMBO</ParentCompanyCode>
						<Entity>item</Entity>
						<TimeStamp>".date('Y-d-m')."T".date('H:i:s')."</TimeStamp>
						<MessageId>".$info_OwmItem->id."</MessageId>
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
							<action_code>UPDATE</action_code>
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
							<lpns_per_tier>".$info_OwmItem->lpns_per_tier."</lpns_per_tier>
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
			
			//$xmlResponse = new \SimpleXMLElement($server_output);

			echo "<br />Response<br />";
			echo "<pre>";
			echo print_r($server_output);
			echo "</pre>";
  
        return redirect()->route('owmitem.index')->with('success','Warehouse Item updated successfully');
    }
	
	/**
     * Create datatable grid
     *
     * 
     * @return \Illuminate\Http\Datatable
     */
	public function grid()
    {
	   $info_OwmItems = OwmItem::All();
	   return Datatables::of($info_OwmItems)
		->addColumn('edit', function ($info_OwmItems) {
				 return '<div class="btn-group btn-group-action">
								<a class="btn btn-info" style="margin-right:2px;" href="'.url('/owmitem/'.$info_OwmItems->id.'/edit').'" title="Edit Data"><i class="fa fa-pencil"></i></a> 
								<a class="btn btn-primary" href="'.url('/owmitem/'.$info_OwmItems->id).'" title="View Data" id="btnDelete" name="btnView"><i class="fa fa-eye"></i></a>
						</div>';
        })
		->editColumn('expcalcm', function ($info_OwmItems) {
			 if($info_OwmItems->expcalcm==1)
				return '<select data-itemid="'.$info_OwmItems->id.'" id="expcalcm" class="form-control expcalcm"><option value="1" selected>Method A</option><option value="2">Method B</option></select>';
			 else
				return '<select data-itemid="'.$info_OwmItems->id.'" id="expcalcm" class="form-control expcalcm"><option value="1">Method A</option><option value="2" selected>Method B</option></select>';
				 	
        })
		->escapeColumns([])
		->removeColumn('type')
		->make(true);
    }
	
	public function updateExpMethod(Request $request, OwmItem $owmitem)
	{
		$owmitem->expcalcm = $request->expcalcm;
		$owmitem->save();
	}
}