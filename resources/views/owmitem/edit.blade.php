@extends('layouts.cms')
@section('content-header')
    <h1>
        Owm Items
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class=""><a href="/owmitem"><i class="fa fa-users"></i> <span>Owm Items</span></a></li>
        <li class="active">Edit</li>
    </ol>
@endsection

@section('content')


@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
{!! Form::model($owmitem, ['method' => 'PATCH', 'url' => ['/owmitem', $owmitem->id], 'files' => true,'id' => 'main-form']) !!}
 <div class="box">
    <div class="box-header">
      <h3 class="box-title">Owm Item detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   		<div class="table-responsive">
          <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" style="width:50%">
            <tr><td>company_code</td><td><input type="input" value="{{ $owmitem->company_code}}" name="company_code" class="form-control" /></td></tr>
            <tr><td>item_alternate_code</td><td><input type="input" value="{{ $owmitem->item_alternate_code}}" name="item_alternate_code" class="form-control" /></td></tr>
            <tr><td>part_a</td><td><input type="input" value="{{ $owmitem->part_a}}" name="part_a" class="form-control" /></td></tr>
            <tr><td>part_b</td><td><input type="input" value="{{ $owmitem->part_b}}" name="part_b" class="form-control" /></td></tr>
            <tr><td>part_c</td><td><input type="input" value="{{ $owmitem->part_c}}" name="part_c" class="form-control" /></td></tr>
            <tr><td>part_d</td><td><input type="input" value="{{ $owmitem->part_d}}" name="part_d" class="form-control" /></td></tr>
            <tr><td>part_e</td><td><input type="input" value="{{ $owmitem->part_e}}" name="part_e" class="form-control" /></td></tr>
            <tr><td>part_f</td><td><input type="input" value="{{ $owmitem->part_f}}" name="part_f" class="form-control" /></td></tr>
            <tr><td>pre_pack_code</td><td><input type="input" value="{{ $owmitem->pre_pack_code}}" name="pre_pack_code" class="form-control" /></td></tr>
            <tr><td>action_code</td><td><input type="input" value="{{ $owmitem->action_code}}" name="action_code" class="form-control" /></td></tr>
            <tr><td>description</td><td><input type="input" value="{{ $owmitem->description}}" name="description" class="form-control" /></td></tr>
            <tr><td>barcode</td><td><input type="input" value="{{ $owmitem->barcode}}" name="barcode" class="form-control" /></td></tr>
            <tr><td>cases_per_pallet</td><td><input type="input" value="{{ $owmitem->cases_per_pallet}}" name="cases_per_pallet" class="form-control" /></td></tr>
            <tr><td>unit_cost</td><td><input type="input" value="{{ $owmitem->unit_cost}}" name="unit_cost" class="form-control" /></td></tr>
            <tr><td>unit_length</td><td><input type="input" value="{{ $owmitem->unit_length}}" name="unit_length" class="form-control" /></td></tr>
            <tr><td>unit_width</td><td><input type="input" value="{{ $owmitem->unit_width}}" name="unit_width" class="form-control" /></td></tr>
            <tr><td>unit_height</td><td><input type="input" value="{{ $owmitem->unit_height}}" name="unit_height" class="form-control" /></td></tr>
            <tr><td>unit_weight</td><td><input type="input" value="{{ $owmitem->unit_weight}}" name="unit_weight" class="form-control" /></td></tr>
            <tr><td>unit_volume</td><td><input type="input" value="{{ $owmitem->unit_volume}}" name="unit_volume" class="form-control" /></td></tr>
            <tr><td>hazmat</td><td><input type="input" value="{{ $owmitem->hazmat}}" name="hazmat" class="form-control" /></td></tr>
            <tr><td>recv_type</td><td><input type="input" value="{{ $owmitem->recv_type}}" name="recv_type" class="form-control" /></td></tr>
            <tr><td>ob_lpn_type</td><td><input type="input" value="{{ $owmitem->ob_lpn_type}}" name="ob_lpn_type" class="form-control" /></td></tr>
            <tr><td>catch_weight_method</td><td><input type="input" value="{{ $owmitem->catch_weight_method}}" name="catch_weight_method" class="form-control" /></td></tr>
            <tr><td>order_consolidation_attr</td><td><input type="input" value="{{ $owmitem->order_consolidation_attr}}" name="order_consolidation_attr" class="form-control" /></td></tr>
            <tr><td>season_code</td><td><input type="input" value="{{ $owmitem->season_code}}" name="season_code" class="form-control" /></td></tr>
            <tr><td>brand_code</td><td><input type="input" value="{{ $owmitem->brand_code}}" name="brand_code" class="form-control" /></td></tr>
            <tr><td>cust_attr_1</td><td><input type="input" value="{{ $owmitem->cust_attr_1}}" name="cust_attr_1" class="form-control" /></td></tr>
            <tr><td>cust_attr_2</td><td><input type="input" value="{{ $owmitem->cust_attr_2}}" name="cust_attr_2" class="form-control" /></td></tr>
            <tr><td>retail_price</td><td><input type="input" value="{{ $owmitem->retail_price}}" name="retail_price" class="form-control" /></td></tr>
            <tr><td>net_cost</td><td><input type="input" value="{{ $owmitem->net_cost}}" name="net_cost" class="form-control" /></td></tr>
            <tr><td>currency_code</td><td><input type="input" value="{{ $owmitem->currency_code}}" name="currency_code" class="form-control" /></td></tr>
            <tr><td>std_pack_qty</td><td><input type="input" value="{{ $owmitem->std_pack_qty}}" name="std_pack_qty" class="form-control" /></td></tr>
            <tr><td>std_pack_length</td><td><input type="input" value="{{ $owmitem->std_pack_length}}" name="std_pack_length" class="form-control" /></td></tr>
            <tr><td>std_pack_width</td><td><input type="input" value="{{ $owmitem->std_pack_width}}" name="std_pack_width" class="form-control" /></td></tr>
            <tr><td>std_pack_height</td><td><input type="input" value="{{ $owmitem->std_pack_height}}" name="std_pack_height" class="form-control" /></td></tr>
            <tr><td>std_pack_weight</td><td><input type="input" value="{{ $owmitem->std_pack_weight}}" name="std_pack_weight" class="form-control" /></td></tr>
            <tr><td>std_pack_volume</td><td><input type="input" value="{{ $owmitem->std_pack_volume}}" name="std_pack_volume" class="form-control" /></td></tr>
            <tr><td>std_case_qty</td><td><input type="input" value="{{ $owmitem->std_case_qty}}" name="std_case_qty" class="form-control" /></td></tr>
            <tr><td>max_case_qty</td><td><input type="input" value="{{ $owmitem->max_case_qty}}" name="max_case_qty" class="form-control" /></td></tr>
            <tr><td>std_case_length</td><td><input type="input" value="{{ $owmitem->std_case_length}}" name="std_case_length" class="form-control" /></td></tr>
            <tr><td>std_case_width</td><td><input type="input" value="{{ $owmitem->std_case_width}}" name="std_case_width" class="form-control" /></td></tr>
            <tr><td>std_case_height</td><td><input type="input" value="{{ $owmitem->std_case_height}}" name="std_case_height" class="form-control" /></td></tr>
            <tr><td>std_case_weight</td><td><input type="input" value="{{ $owmitem->std_case_weight}}" name="std_case_weight" class="form-control" /></td></tr>
            <tr><td>std_case_volume</td><td><input type="input" value="{{ $owmitem->std_case_volume}}" name="std_case_volume" class="form-control" /></td></tr>
            <tr><td>dimension1</td><td><input type="input" value="{{ $owmitem->dimension1}}" name="dimension1" class="form-control" /></td></tr>
            <tr><td>dimension2</td><td><input type="input" value="{{ $owmitem->dimension2}}" name="dimension2" class="form-control" /></td></tr>
            <tr><td>dimension3</td><td><input type="input" value="{{ $owmitem->dimension3}}" name="dimension3" class="form-control" /></td></tr>
            <tr><td>hierarchy1_code</td><td><input type="input" value="{{ $owmitem->hierarchy1_code}}" name="hierarchy1_code" class="form-control" /></td></tr>
            <tr><td>hierarchy1_description</td><td><input type="input" value="{{ $owmitem->hierarchy1_description}}" name="hierarchy1_description" class="form-control" /></td></tr>
            <tr><td>hierarchy2_code</td><td><input type="input" value="{{ $owmitem->hierarchy2_code}}" name="hierarchy2_code" class="form-control" /></td></tr>
            <tr><td>hierarchy2_description</td><td><input type="input" value="{{ $owmitem->hierarchy2_description}}" name="hierarchy2_description" class="form-control" /></td></tr>
            <tr><td>hierarchy3_code</td><td><input type="input" value="{{ $owmitem->hierarchy3_code}}" name="hierarchy3_code" class="form-control" /></td></tr>
            <tr><td>hierarchy3_description</td><td><input type="input" value="{{ $owmitem->hierarchy3_description}}" name="hierarchy3_description" class="form-control" /></td></tr>
            <tr><td>hierarchy4_code</td><td><input type="input" value="{{ $owmitem->hierarchy4_code}}" name="hierarchy4_code" class="form-control" /></td></tr>
            <tr><td>hierarchy4_description</td><td><input type="input" value="{{ $owmitem->hierarchy4_description}}" name="hierarchy4_description" class="form-control" /></td></tr>
            <tr><td>hierarchy5_code</td><td><input type="input" value="{{ $owmitem->hierarchy5_code}}" name="hierarchy5_code" class="form-control" /></td></tr>
            <tr><td>hierarchy5_description</td><td><input type="input" value="{{ $owmitem->hierarchy5_description}}" name="hierarchy5_description" class="form-control" /></td></tr>
            <tr><td>group_code</td><td><input type="input" value="{{ $owmitem->group_code}}" name="group_code" class="form-control" /></td></tr>
            <tr><td>group_description</td><td><input type="input" value="{{ $owmitem->group_description}}" name="group_description" class="form-control" /></td></tr>
            <tr><td>external_style</td><td><input type="input" value="{{ $owmitem->external_style}}" name="external_style" class="form-control" /></td></tr>
            <tr><td>vas_group_code</td><td><input type="input" value="{{ $owmitem->vas_group_code}}" name="vas_group_code" class="form-control" /></td></tr>
            <tr><td>short_descr</td><td><input type="input" value="{{ $owmitem->short_descr}}" name="short_descr" class="form-control" /></td></tr>
            <tr><td>putaway_type</td><td><input type="input" value="{{ $owmitem->putaway_type}}" name="putaway_type" class="form-control" /></td></tr>
            <tr><td>conveyable</td><td><input type="input" value="{{ $owmitem->conveyable}}" name="conveyable" class="form-control" /></td></tr>
            <tr><td>stackability_code</td><td><input type="input" value="{{ $owmitem->stackability_code}}" name="stackability_code" class="form-control" /></td></tr>
            <tr><td>sortable</td><td><input type="input" value="{{ $owmitem->sortable}}" name="sortable" class="form-control" /></td></tr>
            <tr><td>min_dispatch_uom</td><td><input type="input" value="{{ $owmitem->min_dispatch_uom}}" name="min_dispatch_uom" class="form-control" /></td></tr>
            <tr><td>product_life</td><td><input type="input" value="{{ $owmitem->product_life}}" name="product_life" class="form-control" /></td></tr>
            <tr><td>percent_acceptable_product_life</td><td><input type="input" value="{{ $owmitem->percent_acceptable_product_life}}" name="percent_acceptable_product_life" class="form-control" /></td></tr>
            <tr><td>lpns_per_tier</td><td><input type="input" value="{{ $owmitem->lpns_per_tier}}" name="lpns_per_tier" class="form-control" /></td></tr>
            <tr><td>tiers_per_pallet</td><td><input type="input" value="{{ $owmitem->tiers_per_pallet}}" name="tiers_per_pallet" class="form-control" /></td></tr>
            <tr><td>velocity_code</td><td><input type="input" value="{{ $owmitem->velocity_code}}" name="velocity_code" class="form-control" /></td></tr>
            <tr><td>req_batch_nbr_flg</td><td><input type="input" value="{{ $owmitem->req_batch_nbr_flg}}" name="req_batch_nbr_flg" class="form-control" /></td></tr>
            <tr><td>serial_nbr_tracking</td><td><input type="input" value="{{ $owmitem->serial_nbr_tracking}}" name="serial_nbr_tracking" class="form-control" /></td></tr>
            <tr><td>regularity_code</td><td><input type="input" value="{{ $owmitem->regularity_code}}" name="regularity_code" class="form-control" /></td></tr>
            <tr><td>harmonized_tariff_code</td><td><input type="input" value="{{ $owmitem->harmonized_tariff_code}}" name="harmonized_tariff_code" class="form-control" /></td></tr>
            <tr><td>harmonized_tariff_description</td><td><input type="input" value="{{ $owmitem->harmonized_tariff_description}}" name="harmonized_tariff_description" class="form-control" /></td></tr>
            <tr><td>full_oblpn_type</td><td><input type="input" value="{{ $owmitem->full_oblpn_type}}" name="full_oblpn_type" class="form-control" /></td></tr>
            <tr><td>case_oblpn_type</td><td><input type="input" value="{{ $owmitem->case_oblpn_type}}" name="case_oblpn_type" class="form-control" /></td></tr>
            <tr><td>pack_oblpn_type</td><td><input type="input" value="{{ $owmitem->pack_oblpn_type}}" name="pack_oblpn_type" class="form-control" /></td></tr>
            <tr><td>description_2</td><td><input type="input" value="{{ $owmitem->description_2}}" name="description_2" class="form-control" /></td></tr>
            <tr><td>description_3</td><td><input type="input" value="{{ $owmitem->description_3}}" name="description_3" class="form-control" /></td></tr>
            <tr><td>invn_attr_a_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_a_tracking}}" name="invn_attr_a_tracking" class="form-control" /></td></tr>
            <tr><td>invn_attr_a_dflt_value</td><td><input type="input" value="{{ $owmitem->invn_attr_a_dflt_value}}" name="invn_attr_a_dflt_value" class="form-control" /></td></tr>
            <tr><td>invn_attr_b_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_b_tracking}}" name="invn_attr_b_tracking" class="form-control" /></td></tr>
            <tr><td>invn_attr_b_dflt_value</td><td><input type="input" value="{{ $owmitem->invn_attr_b_dflt_value}}" name="invn_attr_b_dflt_value" class="form-control" /></td></tr>
            <tr><td>invn_attr_c_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_c_tracking}}" name="invn_attr_c_tracking" class="form-control" /></td></tr>
            <tr><td>invn_attr_c_dflt_value</td><td><input type="input" value="{{ $owmitem->invn_attr_c_dflt_value}}" name="invn_attr_c_dflt_value" class="form-control" /></td></tr>
            <tr><td>NMFC_code</td><td><input type="input" value="{{ $owmitem->NMFC_code}}" name="NMFC_code" class="form-control" /></td></tr>
            <tr><td>conversion_factor</td><td><input type="input" value="{{ $owmitem->conversion_factor}}" name="conversion_factor" class="form-control" /></td></tr>
            <tr><td>invn_attr_d_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_d_tracking}}" name="invn_attr_d_tracking" class="form-control" /></td></tr>
            <tr><td>invn_attr_e_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_e_tracking}}" name="invn_attr_e_tracking" class="form-control" /></td></tr>
            <tr><td>invn_attr_f_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_f_tracking}}" name="invn_attr_f_tracking" class="form-control" /></td></tr>
            <tr><td>invn_attr_g_tracking</td><td><input type="input" value="{{ $owmitem->invn_attr_g_tracking}}" name="invn_attr_g_tracking" class="form-control" /></td></tr>
            <tr><td>host_aware_item_flg</td><td><input type="input" value="{{ $owmitem->host_aware_item_flg}}" name="host_aware_item_flg" class="form-control" /></td></tr>
            <tr><td>packing_tolerance_percent</td><td><input type="input" value="{{ $owmitem->packing_tolerance_percent}}" name="packing_tolerance_percent" class="form-control" /></td></tr>
            <tr><td>un_number</td><td><input type="input" value="{{ $owmitem->un_number}}" name="un_number" class="form-control" /></td></tr>
            <tr><td>un_class</td><td><input type="input" value="{{ $owmitem->un_class}}" name="un_class" class="form-control" /></td></tr>
            <tr><td>un_description</td><td><input type="input" value="{{ $owmitem->un_description}}" name="un_description" class="form-control" /></td></tr>
            <tr><td>packing_group</td><td><input type="input" value="{{ $owmitem->packing_group}}" name="packing_group" class="form-control" /></td></tr>
            <tr><td>proper_shipping_name</td><td><input type="input" value="{{ $owmitem->proper_shipping_name}}" name="proper_shipping_name" class="form-control" /></td></tr>
            <tr><td>excepted_qty_instr</td><td><input type="input" value="{{ $owmitem->excepted_qty_instr}}" name="excepted_qty_instr" class="form-control" /></td></tr>
            <tr><td>limited_qty_flg</td><td><input type="input" value="{{ $owmitem->limited_qty_flg}}" name="limited_qty_flg" class="form-control" /></td></tr>
            <tr><td>fulldg_flg</td><td><input type="input" value="{{ $owmitem->fulldg_flg}}" name="fulldg_flg" class="form-control" /></td></tr>
            <tr><td>hazard_statement</td><td><input type="input" value="{{ $owmitem->hazard_statement}}" name="hazard_statement" class="form-control" /></td></tr>
            <tr><td>shipping_temperature_instr</td><td><input type="input" value="{{ $owmitem->shipping_temperature_instr}}" name="shipping_temperature_instr" class="form-control" /></td></tr>
            <tr><td>carrier_commodity_description</td><td><input type="input" value="{{ $owmitem->carrier_commodity_description}}" name="carrier_commodity_description" class="form-control" /></td></tr>
            <tr><td>shipping_conversion_factor</td><td><input type="input" value="{{ $owmitem->shipping_conversion_factor}}" name="shipping_conversion_factor" class="form-control" /></td></tr>
            <tr><td>shipping_uom</td><td><input type="input" value="{{ $owmitem->shipping_uom}}" name="shipping_uom" class="form-control" /></td></tr>
            <tr><td>hazmat_packaging_description</td><td><input type="input" value="{{ $owmitem->hazmat_packaging_description}}" name="hazmat_packaging_description" class="form-control" /></td></tr>
            <tr><td>handle_decimal_qty_flg</td><td><input type="input" value="{{ $owmitem->handle_decimal_qty_flg}}" name="handle_decimal_qty_flg" class="form-control" /></td></tr>
            <tr><td>dummy_sku_flg</td><td><input type="input" value="{{ $owmitem->dummy_sku_flg}}" name="dummy_sku_flg" class="form-control" /></td></tr>
            <tr><td>pack_with_wave_flg</td><td><input type="input" value="{{ $owmitem->pack_with_wave_flg}}" name="pack_with_wave_flg" class="form-control" /></td></tr>



          </table>
          <div class="form-group">
            <label></label>
            {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
         </div>
      </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
{!! Form::close() !!}
@endsection
