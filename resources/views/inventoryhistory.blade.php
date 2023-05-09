@extends('layouts.cms')
@section('content-header')
    <h1>
        BBU
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Inventory History</li>
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
      <h3 class="box-title">Inventory History detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   		<div class="table-responsive">
          <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>id</th>
                <th>group_nbr</th>
                <th>seq_nbr</th>
                <th>facility_code</th>
                <th>company_code</th>
                <th>activity_code</th>
                <th>reason_code</th>
                <th>lock_code</th>
                <th>lpn_nbr</th>
                <th>location</th>
                <th>item_code</th>
                <th>item_alternate_code</th>
                <th>item_part_a</th>
                <th>item_part_b</th>
                <th>item_part_c</th>
                <th>item_part_d</th>
                <th>item_part_e</th>
                <th>item_part_f</th>
                <th>item_description</th>
                <th>shipment_nbr</th>
                <th>trailer_nbr</th>
                <th>po_nbr</th>
                <th>po_line_nbr</th>
                <th>vendor_code</th>
                <th>order_nbr</th>
                <th>order_seq_nbr</th>
                <th>to_facility_code</th>
                <th>orig_qty</th>
                <th>adj_qty</th>
                <th>lpns_shipped</th>
                <th>units_shipped</th>
                <th>lpns_received</th>
                <th>units_received</th>
                <th>ref_code_1</th>
                <th>ref_value_1</th>
                <th>ref_code_2</th>
                <th>ref_value_2</th>
                <th>ref_code_3</th>
                <th>ref_value_3</th>
                <th>ref_code_4</th>
                <th>ref_value_4</th>
                <th>ref_code_5</th>
                <th>ref_value_5</th>
                <th>create_date</th>
                <th>invn_attr_a</th>
                <th>invn_attr_b</th>
                <th>invn_attr_c</th>
                <th>shipment_line_nbr</th>
                <th>serial_nbr</th>
                <th>invn_attr_d</th>
                <th>invn_attr_e</th>
                <th>invn_attr_f</th>
                <th>invn_attr_g</th>
                <th>work_order_nbr</th>
                <th>work_order_seq_nbr</th>
                <th>screen_name</th>
                <th>module_name</th>
                <th>ref_code_6</th>
                <th>ref_value_6</th>
                <th>ref_code_7</th>
                <th>ref_value_7</th>
                <th>ref_code_8</th>
                <th>ref_value_8</th>
                <th>ref_code_9</th>
                <th>ref_value_9</th>
                <th>ref_code_10</th>
                <th>ref_value_10</th>
                <th>ref_code_11</th>
                <th>ref_value_11</th>
                <th>ref_code_12</th>
                <th>ref_value_12</th>
                <th>order_type</th>
                <th>shipment_type</th>
                <th>po_type</th>
                <th>billing_location_type</th>
                <th>create_ts</th>
                <th>invn_attr_h</th>
                <th>invn_attr_i</th>
                <th>invn_attr_j</th>
                <th>invn_attr_k</th>
                <th>invn_attr_l</th>
                <th>invn_attr_m</th>
                <th>invn_attr_n</th>
                <th>invn_attr_o</th>
                <th>ref_code_13</th>
                <th>ref_code_14</th>
                <th>ref_value_14</th>
                <th>ref_code_15</th>
                <th>ref_value_15</th>
                <th>ref_code_16</th>
                <th>ref_value_16</th>
                <th>ref_code_17</th>
                <th>ref_value_17</th>
                <th>ref_code_18</th>
                <th>ref_value_18</th>
                <th>ref_code_19</th>
                <th>ref_value_19</th>
                <th>ref_code_20</th>
                <th>ref_value_20</th>
                <th>to_location</th>
                <th>prev_erp_bucket</th>
                <th>current_erp_bucket</th>
                <th>lock_code_prty</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tfoot>
          </table>	
    	</div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>

@endsection

@push('scripts')

<script type="text/javascript">
	$('#viewForm').DataTable({
        "processing": true,
        "serverSide": true,
		"ajax": {
            "url": "{{url('/inventoryhistory/grid')}}",
            "type": "POST",
			'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "columns": [
            { data: 'id', name: 'id' },
			{ data: 'group_nbr', name: 'group_nbr' },
			{ data: 'seq_nbr', name: 'seq_nbr' },
			{ data: 'facility_code', name: 'facility_code' },
			{ data: 'company_code', name: 'company_code' },
			{ data: 'activity_code', name: 'activity_code' },
			{ data: 'reason_code', name: 'reason_code' },
			{ data: 'lock_code', name: 'lock_code' },
			{ data: 'lpn_nbr', name: 'lpn_nbr' },
			{ data: 'location', name: 'location' },
			{ data: 'item_code', name: 'item_code' },
			{ data: 'item_alternate_code', name: 'item_alternate_code' },
			{ data: 'item_part_a', name: 'item_part_a' },
			{ data: 'item_part_b', name: 'item_part_b' },
			{ data: 'item_part_c', name: 'item_part_c' },
			{ data: 'item_part_d', name: 'item_part_d' },
			{ data: 'item_part_e', name: 'item_part_e' },
			{ data: 'item_part_f', name: 'item_part_f' },
			{ data: 'item_description', name: 'item_description' },
			{ data: 'shipment_nbr', name: 'shipment_nbr' },
			{ data: 'trailer_nbr', name: 'trailer_nbr' },
			{ data: 'po_nbr', name: 'po_nbr' },
			{ data: 'po_line_nbr', name: 'po_line_nbr' },
			{ data: 'vendor_code', name: 'vendor_code' },
			{ data: 'order_nbr', name: 'order_nbr' },
			{ data: 'order_seq_nbr', name: 'order_seq_nbr' },
			{ data: 'to_facility_code', name: 'to_facility_code' },
			{ data: 'orig_qty', name: 'orig_qty' },
			{ data: 'adj_qty', name: 'adj_qty' },
			{ data: 'lpns_shipped', name: 'lpns_shipped' },
			{ data: 'units_shipped', name: 'units_shipped' },
			{ data: 'lpns_received', name: 'lpns_received' },
			{ data: 'units_received', name: 'units_received' },
			{ data: 'ref_code_1', name: 'ref_code_1' },
			{ data: 'ref_value_1', name: 'ref_value_1' },
			{ data: 'ref_code_2', name: 'ref_code_2' },
			{ data: 'ref_value_2', name: 'ref_value_2' },
			{ data: 'ref_code_3', name: 'ref_code_3' },
			{ data: 'ref_value_3', name: 'ref_value_3' },
			{ data: 'ref_code_4', name: 'ref_code_4' },
			{ data: 'ref_value_4', name: 'ref_value_4' },
			{ data: 'ref_code_5', name: 'ref_code_5' },
			{ data: 'ref_value_5', name: 'ref_value_5' },
			{ data: 'create_date', name: 'create_date' },
			{ data: 'invn_attr_a', name: 'invn_attr_a' },
			{ data: 'invn_attr_b', name: 'invn_attr_b' },
			{ data: 'invn_attr_c', name: 'invn_attr_c' },
			{ data: 'shipment_line_nbr', name: 'shipment_line_nbr' },
			{ data: 'serial_nbr', name: 'serial_nbr' },
			{ data: 'invn_attr_d', name: 'invn_attr_d' },
			{ data: 'invn_attr_e', name: 'invn_attr_e' },
			{ data: 'invn_attr_f', name: 'invn_attr_f' },
			{ data: 'invn_attr_g', name: 'invn_attr_g' },
			{ data: 'work_order_nbr', name: 'work_order_nbr' },
			{ data: 'work_order_seq_nbr', name: 'work_order_seq_nbr' },
			{ data: 'screen_name', name: 'screen_name' },
			{ data: 'module_name', name: 'module_name' },
			{ data: 'ref_code_6', name: 'ref_code_6' },
			{ data: 'ref_value_6', name: 'ref_value_6' },
			{ data: 'ref_code_7', name: 'ref_code_7' },
			{ data: 'ref_value_7', name: 'ref_value_7' },
			{ data: 'ref_code_8', name: 'ref_code_8' },
			{ data: 'ref_value_8', name: 'ref_value_8' },
			{ data: 'ref_code_9', name: 'ref_code_9' },
			{ data: 'ref_value_9', name: 'ref_value_9' },
			{ data: 'ref_code_10', name: 'ref_code_10' },
			{ data: 'ref_value_10', name: 'ref_value_10' },
			{ data: 'ref_code_11', name: 'ref_code_11' },
			{ data: 'ref_value_11', name: 'ref_value_11' },
			{ data: 'ref_code_12', name: 'ref_code_12' },
			{ data: 'ref_value_12', name: 'ref_value_12' },
			{ data: 'order_type', name: 'order_type' },
			{ data: 'shipment_type', name: 'shipment_type' },
			{ data: 'po_type', name: 'po_type' },
			{ data: 'billing_location_type', name: 'billing_location_type' },
			{ data: 'create_ts', name: 'create_ts' },
			{ data: 'invn_attr_h', name: 'invn_attr_h' },
			{ data: 'invn_attr_i', name: 'invn_attr_i' },
			{ data: 'invn_attr_j', name: 'invn_attr_j' },
			{ data: 'invn_attr_k', name: 'invn_attr_k' },
			{ data: 'invn_attr_l', name: 'invn_attr_l' },
			{ data: 'invn_attr_m', name: 'invn_attr_m' },
			{ data: 'invn_attr_n', name: 'invn_attr_n' },
			{ data: 'invn_attr_o', name: 'invn_attr_o' },
			{ data: 'ref_code_13', name: 'ref_code_13' },
			{ data: 'ref_code_14', name: 'ref_code_14' },
			{ data: 'ref_value_14', name: 'ref_value_14' },
			{ data: 'ref_code_15', name: 'ref_code_15' },
			{ data: 'ref_value_15', name: 'ref_value_15' },
			{ data: 'ref_code_16', name: 'ref_code_16' },
			{ data: 'ref_value_16', name: 'ref_value_16' },
			{ data: 'ref_code_17', name: 'ref_code_17' },
			{ data: 'ref_value_17', name: 'ref_value_17' },
			{ data: 'ref_code_18', name: 'ref_code_18' },
			{ data: 'ref_value_18', name: 'ref_value_18' },
			{ data: 'ref_code_19', name: 'ref_code_19' },
			{ data: 'ref_value_19', name: 'ref_value_19' },
			{ data: 'ref_code_20', name: 'ref_code_20' },
			{ data: 'ref_value_20', name: 'ref_value_20' },
			{ data: 'to_location', name: 'to_location' },
			{ data: 'prev_erp_bucket', name: 'prev_erp_bucket' },
			{ data: 'current_erp_bucket', name: 'current_erp_bucket' },
			{ data: 'lock_code_prty', name: 'lock_code_prty' },
			{ data: 'edit', name: 'edit', orderable: false, searchable: false }
		]
    });
</script>

@endpush