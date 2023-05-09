@extends('layouts.cms')
@section('content-header')
    <h1>
        Owm Items
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class=""><a href="/owmitem"><i class="fa fa-users"></i> <span>Owm Items</span></a></li>
        <li class="active">Show</li>
    </ol>
@endsection

@section('content')


@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
 <div class="box">
    <div class="box-header">
      <h3 class="box-title">Owm Item detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   		<div class="table-responsive">
          <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:50%">
            <tr><td style="width:50%">id</td><td>{{ $owmitem->id }}</td></tr>
            <tr><td>company_code</td><td>{{ $owmitem->company_code }}</td></tr>
            <tr><td>item_alternate_code</td><td>{{ $owmitem->item_alternate_code }}</td></tr>
            <tr><td>part_a</td><td>{{ $owmitem->part_a }}</td></tr>
            <tr><td>part_b</td><td>{{ $owmitem->part_b }}</td></tr>
            <tr><td>part_c</td><td>{{ $owmitem->part_c }}</td></tr>
            <tr><td>part_d</td><td>{{ $owmitem->part_d }}</td></tr>
            <tr><td>part_e</td><td>{{ $owmitem->part_e }}</td></tr>
            <tr><td>part_f</td><td>{{ $owmitem->part_f }}</td></tr>
            <tr><td>pre_pack_code</td><td>{{ $owmitem->pre_pack_code }}</td></tr>
            <tr><td>action_code</td><td>{{ $owmitem->action_code }}</td></tr>
            <tr><td>description</td><td>{{ $owmitem->description }}</td></tr>
            <tr><td>barcode</td><td>{{ $owmitem->barcode }}</td></tr>
            <tr><td>cases_per_pallet</td><td>{{ $owmitem->cases_per_pallet }}</td></tr>
            <tr><td>unit_cost</td><td>{{ $owmitem->unit_cost }}</td></tr>
            <tr><td>unit_length</td><td>{{ $owmitem->unit_length }}</td></tr>
            <tr><td>unit_width</td><td>{{ $owmitem->unit_width }}</td></tr>
            <tr><td>unit_height</td><td>{{ $owmitem->unit_height }}</td></tr>
            <tr><td>unit_weight</td><td>{{ $owmitem->unit_weight }}</td></tr>
            <tr><td>unit_volume</td><td>{{ $owmitem->unit_volume }}</td></tr>
            <tr><td>hazmat</td><td>{{ $owmitem->hazmat }}</td></tr>
            <tr><td>recv_type</td><td>{{ $owmitem->recv_type }}</td></tr>
            <tr><td>ob_lpn_type</td><td>{{ $owmitem->ob_lpn_type }}</td></tr>
            <tr><td>catch_weight_method</td><td>{{ $owmitem->catch_weight_method }}</td></tr>
            <tr><td>order_consolidation_attr</td><td>{{ $owmitem->order_consolidation_attr }}</td></tr>
            <tr><td>season_code</td><td>{{ $owmitem->season_code }}</td></tr>
            <tr><td>brand_code</td><td>{{ $owmitem->brand_code }}</td></tr>
            <tr><td>cust_attr_1</td><td>{{ $owmitem->cust_attr_1 }}</td></tr>
            <tr><td>cust_attr_2</td><td>{{ $owmitem->cust_attr_2 }}</td></tr>
            <tr><td>retail_price</td><td>{{ $owmitem->retail_price }}</td></tr>
            <tr><td>net_cost</td><td>{{ $owmitem->net_cost }}</td></tr>
            <tr><td>currency_code</td><td>{{ $owmitem->currency_code }}</td></tr>
            <tr><td>std_pack_qty</td><td>{{ $owmitem->std_pack_qty }}</td></tr>
            <tr><td>std_pack_length</td><td>{{ $owmitem->std_pack_length }}</td></tr>
            <tr><td>std_pack_width</td><td>{{ $owmitem->std_pack_width }}</td></tr>
            <tr><td>std_pack_height</td><td>{{ $owmitem->std_pack_height }}</td></tr>
            <tr><td>std_pack_weight</td><td>{{ $owmitem->std_pack_weight }}</td></tr>
            <tr><td>std_pack_volume</td><td>{{ $owmitem->std_pack_volume }}</td></tr>
            <tr><td>std_case_qty</td><td>{{ $owmitem->std_case_qty }}</td></tr>
            <tr><td>max_case_qty</td><td>{{ $owmitem->max_case_qty }}</td></tr>
            <tr><td>std_case_length</td><td>{{ $owmitem->std_case_length }}</td></tr>
            <tr><td>std_case_width</td><td>{{ $owmitem->std_case_width }}</td></tr>
            <tr><td>std_case_height</td><td>{{ $owmitem->std_case_height }}</td></tr>
            <tr><td>std_case_weight</td><td>{{ $owmitem->std_case_weight }}</td></tr>
            <tr><td>std_case_volume</td><td>{{ $owmitem->std_case_volume }}</td></tr>
            <tr><td>dimension1</td><td>{{ $owmitem->dimension1 }}</td></tr>
            <tr><td>dimension2</td><td>{{ $owmitem->dimension2 }}</td></tr>
            <tr><td>dimension3</td><td>{{ $owmitem->dimension3 }}</td></tr>
            <tr><td>hierarchy1_code</td><td>{{ $owmitem->hierarchy1_code }}</td></tr>
            <tr><td>hierarchy1_description</td><td>{{ $owmitem->hierarchy1_description }}</td></tr>
            <tr><td>hierarchy2_code</td><td>{{ $owmitem->hierarchy2_code }}</td></tr>
            <tr><td>hierarchy2_description</td><td>{{ $owmitem->hierarchy2_description }}</td></tr>
            <tr><td>hierarchy3_code</td><td>{{ $owmitem->hierarchy3_code }}</td></tr>
            <tr><td>hierarchy3_description</td><td>{{ $owmitem->hierarchy3_description }}</td></tr>
            <tr><td>hierarchy4_code</td><td>{{ $owmitem->hierarchy4_code }}</td></tr>
            <tr><td>hierarchy4_description</td><td>{{ $owmitem->hierarchy4_description }}</td></tr>
            <tr><td>hierarchy5_code</td><td>{{ $owmitem->hierarchy5_code }}</td></tr>
            <tr><td>hierarchy5_description</td><td>{{ $owmitem->hierarchy5_description }}</td></tr>
            <tr><td>group_code</td><td>{{ $owmitem->group_code }}</td></tr>
            <tr><td>group_description</td><td>{{ $owmitem->group_description }}</td></tr>
            <tr><td>external_style</td><td>{{ $owmitem->external_style }}</td></tr>
            <tr><td>vas_group_code</td><td>{{ $owmitem->vas_group_code }}</td></tr>
            <tr><td>short_descr</td><td>{{ $owmitem->short_descr }}</td></tr>
            <tr><td>putaway_type</td><td>{{ $owmitem->putaway_type }}</td></tr>
            <tr><td>conveyable</td><td>{{ $owmitem->conveyable }}</td></tr>
            <tr><td>stackability_code</td><td>{{ $owmitem->stackability_code }}</td></tr>
            <tr><td>sortable</td><td>{{ $owmitem->sortable }}</td></tr>
            <tr><td>min_dispatch_uom</td><td>{{ $owmitem->min_dispatch_uom }}</td></tr>
            <tr><td>product_life</td><td>{{ $owmitem->product_life }}</td></tr>
            <tr><td>percent_acceptable_product_life</td><td>{{ $owmitem->percent_acceptable_product_life }}</td></tr>
            <tr><td>lpns_per_tier</td><td>{{ $owmitem->lpns_per_tier }}</td></tr>
            <tr><td>tiers_per_pallet</td><td>{{ $owmitem->tiers_per_pallet }}</td></tr>
            <tr><td>velocity_code</td><td>{{ $owmitem->velocity_code }}</td></tr>
            <tr><td>req_batch_nbr_flg</td><td>{{ $owmitem->req_batch_nbr_flg }}</td></tr>
            <tr><td>serial_nbr_tracking</td><td>{{ $owmitem->serial_nbr_tracking }}</td></tr>
            <tr><td>regularity_code</td><td>{{ $owmitem->regularity_code }}</td></tr>
            <tr><td>harmonized_tariff_code</td><td>{{ $owmitem->harmonized_tariff_code }}</td></tr>
            <tr><td>harmonized_tariff_description</td><td>{{ $owmitem->harmonized_tariff_description }}</td></tr>
            <tr><td>full_oblpn_type</td><td>{{ $owmitem->full_oblpn_type }}</td></tr>
            <tr><td>case_oblpn_type</td><td>{{ $owmitem->case_oblpn_type }}</td></tr>
            <tr><td>pack_oblpn_type</td><td>{{ $owmitem->pack_oblpn_type }}</td></tr>
            <tr><td>description_2</td><td>{{ $owmitem->description_2 }}</td></tr>
            <tr><td>description_3</td><td>{{ $owmitem->description_3 }}</td></tr>
            <tr><td>invn_attr_a_tracking</td><td>{{ $owmitem->invn_attr_a_tracking }}</td></tr>
            <tr><td>invn_attr_a_dflt_value</td><td>{{ $owmitem->invn_attr_a_dflt_value }}</td></tr>
            <tr><td>invn_attr_b_tracking</td><td>{{ $owmitem->invn_attr_b_tracking }}</td></tr>
            <tr><td>invn_attr_b_dflt_value</td><td>{{ $owmitem->invn_attr_b_dflt_value }}</td></tr>
            <tr><td>invn_attr_c_tracking</td><td>{{ $owmitem->invn_attr_c_tracking }}</td></tr>
            <tr><td>invn_attr_c_dflt_value</td><td>{{ $owmitem->invn_attr_c_dflt_value }}</td></tr>
            <tr><td>NMFC_code</td><td>{{ $owmitem->NMFC_code }}</td></tr>
            <tr><td>conversion_factor</td><td>{{ $owmitem->conversion_factor }}</td></tr>
            <tr><td>invn_attr_d_tracking</td><td>{{ $owmitem->invn_attr_d_tracking }}</td></tr>
            <tr><td>invn_attr_e_tracking</td><td>{{ $owmitem->invn_attr_e_tracking }}</td></tr>
            <tr><td>invn_attr_f_tracking</td><td>{{ $owmitem->invn_attr_f_tracking }}</td></tr>
            <tr><td>invn_attr_g_tracking</td><td>{{ $owmitem->invn_attr_g_tracking }}</td></tr>
            <tr><td>host_aware_item_flg</td><td>{{ $owmitem->host_aware_item_flg }}</td></tr>
            <tr><td>packing_tolerance_percent</td><td>{{ $owmitem->packing_tolerance_percent }}</td></tr>
            <tr><td>un_number</td><td>{{ $owmitem->un_number }}</td></tr>
            <tr><td>un_class</td><td>{{ $owmitem->un_class }}</td></tr>
            <tr><td>un_description</td><td>{{ $owmitem->un_description }}</td></tr>
            <tr><td>packing_group</td><td>{{ $owmitem->packing_group }}</td></tr>
            <tr><td>proper_shipping_name</td><td>{{ $owmitem->proper_shipping_name }}</td></tr>
            <tr><td>excepted_qty_instr</td><td>{{ $owmitem->excepted_qty_instr }}</td></tr>
            <tr><td>limited_qty_flg</td><td>{{ $owmitem->limited_qty_flg }}</td></tr>
            <tr><td>fulldg_flg</td><td>{{ $owmitem->fulldg_flg }}</td></tr>
            <tr><td>hazard_statement</td><td>{{ $owmitem->hazard_statement }}</td></tr>
            <tr><td>shipping_temperature_instr</td><td>{{ $owmitem->shipping_temperature_instr }}</td></tr>
            <tr><td>carrier_commodity_description</td><td>{{ $owmitem->carrier_commodity_description }}</td></tr>
            <tr><td>shipping_conversion_factor</td><td>{{ $owmitem->shipping_conversion_factor }}</td></tr>
            <tr><td>shipping_uom</td><td>{{ $owmitem->shipping_uom }}</td></tr>
            <tr><td>hazmat_packaging_description</td><td>{{ $owmitem->hazmat_packaging_description }}</td></tr>
            <tr><td>handle_decimal_qty_flg</td><td>{{ $owmitem->handle_decimal_qty_flg }}</td></tr>
            <tr><td>dummy_sku_flg</td><td>{{ $owmitem->dummy_sku_flg }}</td></tr>
            <tr><td>pack_with_wave_flg</td><td>{{ $owmitem->pack_with_wave_flg }}</td></tr>


          </table>
          <a href="{{ url('/owmitem') }}" class="btn btn-primary">Go Back</a>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>

@endsection
