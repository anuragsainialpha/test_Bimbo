@extends('layouts.cms')
@section('content-header')
    <h1>
        BBU
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Outbound Loads</li>
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
      <h3 class="box-title">Outbound Loads detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div class="row">
        	<div class="col-sm-3 form-group">
                <label for="exampleInputEmail1">Date range</label>
                <button type="button" class="btn btn-default form-control" id="daterange-btn">
                    <span class="pull-left">
                        <i class="fa fa-calendar"></i> Date range picker
                    </span>
                    <i class="fa fa-caret-down pull-right"></i>
                </button>
                <input type="hidden" name="dateFrom" id="dateFrom" value="{{ Session::get('dateFrom') }}" />
                <input type="hidden" name="dateTo" id ="dateTo" value="{{ Session::get('dateTo') }}" />
            </div>
        </div>
        <div>
            <hr />
			<input type="button" class="btn btn-success" value="Export" id="Export" />
            <hr />
        </div>
   		<div class="table-responsive">
          <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th><input type="checkbox" id="checkAll" /></th>
                <th>id</th>
                <th>hdr_group_nbr</th>
                <th>facility_code</th>
                <th>company_code</th>
                <th>action_code</th>
                <th>load_type</th>
                <th>load_manifest_nbr</th>
                <th>trailer_nbr</th>
                <th>trailer_type</th>
                <th>driver</th>
                <th>seal_nbr</th>
                <th>pro_nbr</th>
                <th>route_nbr</th>
                <th>freight_class</th>
                <th>hdr_bol_nbr</th>
                <th>total_nbr_of_oblpns</th>
                <th>total_weight</th>
                <th>total_volume</th>
                <th>total_shipping_charge</th>
                <th>ship_date</th>
                <th>sched_delivery_date</th>
                <th>carrier_code</th>
                <th>externally_planned_load_nbr</th>
                <th>ship_date_time</th>
                <th>sched_delivery_date_time</th>
                <th>time_zone_code</th>
                <th>line_nbr</th>
                <th>seq_nbr</th>
                <th>stop_shipment_nbr</th>
                <th>stop_bol_nbr</th>
                <th>stop_nbr_of_oblpns</th>
                <th>stop_weight</th>
                <th>stop_volume</th>
                <th>stop_shipping_charge</th>
                <th>shipto_facility_code</th>
                <th>shipto_name</th>
                <th>shipto_addr</th>
                <th>shipto_addr2</th>
                <th>shipto_addr3</th>
                <th>shipto_city</th>
                <th>shipto_state</th>
                <th>shipto_zip</th>
                <th>shipto_country</th>
                <th>shipto_phone_nbr</th>
                <th>shipto_email</th>
                <th>shipto_contact</th>
                <th>dest_facility_code</th>
                <th>cust_name</th>
                <th>cust_addr</th>
                <th>cust_addr2</th>
                <th>cust_addr3</th>
                <th>cust_city</th>
                <th>cust_state</th>
                <th>cust_zip</th>
                <th>cust_country</th>
                <th>cust_phone_nbr</th>
                <th>cust_email</th>
                <th>cust_contact</th>
                <th>cust_nbr</th>
                <th>order_nbr</th>
                <th>ord_date</th>
                <th>exp_date</th>
                <th>req_ship_date</th>
                <th>start_ship_date</th>
                <th>stop_ship_date</th>
                <th>host_allocation_nbr</th>
                <th>customer_po_nbr</th>
                <th>sales_order_nbr</th>
                <th>sales_channel</th>
                <th>dest_dept_nbr</th>
                <th>order_hdr_cust_field_1</th>
                <th>order_hdr_cust_field_2</th>
                <th>order_hdr_cust_field_3</th>
                <th>order_hdr_cust_field_4</th>
                <th>order_hdr_cust_field_5</th>
                <th>order_seq_nbr</th>
                <th>order_dtl_cust_field_1</th>
                <th>order_dtl_cust_field_2</th>
                <th>order_dtl_cust_field_3</th>
                <th>order_dtl_cust_field_4</th>
                <th>order_dtl_cust_field_5</th>
                <th>ob_lpn_nbr</th>
                <th>item_alternate_code</th>
                <th>item_part_a</th>
                <th>item_part_b</th>
                <th>item_part_c</th>
                <th>item_part_d</th>
                <th>item_part_e</th>
                <th>item_part_f</th>
                <th>pre_pack_code</th>
                <th>pre_pack_ratio</th>
                <th>pre_pack_ratio_seq</th>
                <th>pre_pack_total_units</th>
                <th>invn_attr_a</th>
                <th>invn_attr_b</th>
                <th>invn_attr_c</th>
                <th>hazmat</th>
                <th>shipped_uom</th>
                <th>shipped_qty</th>
                <th>pallet_nbr</th>
                <th>dest_company_code</th>
                <th>batch_nbr</th>
                <th>expiry_date</th>
                <th>tracking_nbr</th>
                <th>master_tracking_nbr</th>
                <th>package_type</th>
                <th>payment_method</th>
                <th>carrier_account_nbr</th>
                <th>ship_via_code</th>
                <th>ob_lpn_weight</th>
                <th>ob_lpn_volume</th>
                <th>ob_lpn_shipping_charge</th>
                <th>ob_lpn_type</th>
                <th>asset_nbr</th>
                <th>asset_seal_nbr</th>
                <th>serial_nbr</th>
                <th>customer_po_type</th>
                <th>customer_vendor_code</th>
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
            "url": "{{url('/outboundloads/grid')}}",
            "type": "POST",
			'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
		'columnDefs': [{
			 'targets': 0,
			 'searchable': false,
			 'orderable': false,
			 'className': 'dt-body-center',
			 'render': function (data, type, full, meta){
				 //console.log(full);
				 return '<input type="checkbox" class="exportIDs" name="id[]" value="' + $('<div/>').text(data).html() + '">';
			 }
		}],
        "columns": [
            { data: 'id', name: 'id' },
			{ data: 'id', name: 'id' },
			{ data: 'hdr_group_nbr', name: 'hdr_group_nbr' },
			{ data: 'facility_code', name: 'facility_code' },
			{ data: 'company_code', name: 'company_code' },
			{ data: 'action_code', name: 'action_code' },
			{ data: 'load_type', name: 'load_type' },
			{ data: 'load_manifest_nbr', name: 'load_manifest_nbr' },
			{ data: 'trailer_nbr', name: 'trailer_nbr' },
			{ data: 'trailer_type', name: 'trailer_type' },
			{ data: 'driver', name: 'driver' },
			{ data: 'seal_nbr', name: 'seal_nbr' },
			{ data: 'pro_nbr', name: 'pro_nbr' },
			{ data: 'route_nbr', name: 'route_nbr' },
			{ data: 'freight_class', name: 'freight_class' },
			{ data: 'hdr_bol_nbr', name: 'hdr_bol_nbr' },
			{ data: 'total_nbr_of_oblpns', name: 'total_nbr_of_oblpns' },
			{ data: 'total_weight', name: 'total_weight' },
			{ data: 'total_volume', name: 'total_volume' },
			{ data: 'total_shipping_charge', name: 'total_shipping_charge' },
			{ data: 'ship_date', name: 'ship_date' },
			{ data: 'sched_delivery_date', name: 'sched_delivery_date' },
			{ data: 'carrier_code', name: 'carrier_code' },
			{ data: 'externally_planned_load_nbr', name: 'externally_planned_load_nbr' },
			{ data: 'ship_date_time', name: 'ship_date_time' },
			{ data: 'sched_delivery_date_time', name: 'sched_delivery_date_time' },
			{ data: 'time_zone_code', name: 'time_zone_code' },
			{ data: 'line_nbr', name: 'line_nbr' },
			{ data: 'seq_nbr', name: 'seq_nbr' },
			{ data: 'stop_shipment_nbr', name: 'stop_shipment_nbr' },
			{ data: 'stop_bol_nbr', name: 'stop_bol_nbr' },
			{ data: 'stop_nbr_of_oblpns', name: 'stop_nbr_of_oblpns' },
			{ data: 'stop_weight', name: 'stop_weight' },
			{ data: 'stop_volume', name: 'stop_volume' },
			{ data: 'stop_shipping_charge', name: 'stop_shipping_charge' },
			{ data: 'shipto_facility_code', name: 'shipto_facility_code' },
			{ data: 'shipto_name', name: 'shipto_name' },
			{ data: 'shipto_addr', name: 'shipto_addr' },
			{ data: 'shipto_addr2', name: 'shipto_addr2' },
			{ data: 'shipto_addr3', name: 'shipto_addr3' },
			{ data: 'shipto_city', name: 'shipto_city' },
			{ data: 'shipto_state', name: 'shipto_state' },
			{ data: 'shipto_zip', name: 'shipto_zip' },
			{ data: 'shipto_country', name: 'shipto_country' },
			{ data: 'shipto_phone_nbr', name: 'shipto_phone_nbr' },
			{ data: 'shipto_email', name: 'shipto_email' },
			{ data: 'shipto_contact', name: 'shipto_contact' },
			{ data: 'dest_facility_code', name: 'dest_facility_code' },
			{ data: 'cust_name', name: 'cust_name' },
			{ data: 'cust_addr', name: 'cust_addr' },
			{ data: 'cust_addr2', name: 'cust_addr2' },
			{ data: 'cust_addr3', name: 'cust_addr3' },
			{ data: 'cust_city', name: 'cust_city' },
			{ data: 'cust_state', name: 'cust_state' },
			{ data: 'cust_zip', name: 'cust_zip' },
			{ data: 'cust_country', name: 'cust_country' },
			{ data: 'cust_phone_nbr', name: 'cust_phone_nbr' },
			{ data: 'cust_email', name: 'cust_email' },
			{ data: 'cust_contact', name: 'cust_contact' },
			{ data: 'cust_nbr', name: 'cust_nbr' },
			{ data: 'order_nbr', name: 'order_nbr' },
			{ data: 'ord_date', name: 'ord_date' },
			{ data: 'exp_date', name: 'exp_date' },
			{ data: 'req_ship_date', name: 'req_ship_date' },
			{ data: 'start_ship_date', name: 'start_ship_date' },
			{ data: 'stop_ship_date', name: 'stop_ship_date' },
			{ data: 'host_allocation_nbr', name: 'host_allocation_nbr' },
			{ data: 'customer_po_nbr', name: 'customer_po_nbr' },
			{ data: 'sales_order_nbr', name: 'sales_order_nbr' },
			{ data: 'sales_channel', name: 'sales_channel' },
			{ data: 'dest_dept_nbr', name: 'dest_dept_nbr' },
			{ data: 'order_hdr_cust_field_1', name: 'order_hdr_cust_field_1' },
			{ data: 'order_hdr_cust_field_2', name: 'order_hdr_cust_field_2' },
			{ data: 'order_hdr_cust_field_3', name: 'order_hdr_cust_field_3' },
			{ data: 'order_hdr_cust_field_4', name: 'order_hdr_cust_field_4' },
			{ data: 'order_hdr_cust_field_5', name: 'order_hdr_cust_field_5' },
			{ data: 'order_seq_nbr', name: 'order_seq_nbr' },
			{ data: 'order_dtl_cust_field_1', name: 'order_dtl_cust_field_1' },
			{ data: 'order_dtl_cust_field_2', name: 'order_dtl_cust_field_2' },
			{ data: 'order_dtl_cust_field_3', name: 'order_dtl_cust_field_3' },
			{ data: 'order_dtl_cust_field_4', name: 'order_dtl_cust_field_4' },
			{ data: 'order_dtl_cust_field_5', name: 'order_dtl_cust_field_5' },
			{ data: 'ob_lpn_nbr', name: 'ob_lpn_nbr' },
			{ data: 'item_alternate_code', name: 'item_alternate_code' },
			{ data: 'item_part_a', name: 'item_part_a' },
			{ data: 'item_part_b', name: 'item_part_b' },
			{ data: 'item_part_c', name: 'item_part_c' },
			{ data: 'item_part_d', name: 'item_part_d' },
			{ data: 'item_part_e', name: 'item_part_e' },
			{ data: 'item_part_f', name: 'item_part_f' },
			{ data: 'pre_pack_code', name: 'pre_pack_code' },
			{ data: 'pre_pack_ratio', name: 'pre_pack_ratio' },
			{ data: 'pre_pack_ratio_seq', name: 'pre_pack_ratio_seq' },
			{ data: 'pre_pack_total_units', name: 'pre_pack_total_units' },
			{ data: 'invn_attr_a', name: 'invn_attr_a' },
			{ data: 'invn_attr_b', name: 'invn_attr_b' },
			{ data: 'invn_attr_c', name: 'invn_attr_c' },
			{ data: 'hazmat', name: 'hazmat' },
			{ data: 'shipped_uom', name: 'shipped_uom' },
			{ data: 'shipped_qty', name: 'shipped_qty' },
			{ data: 'pallet_nbr', name: 'pallet_nbr' },
			{ data: 'dest_company_code', name: 'dest_company_code' },
			{ data: 'batch_nbr', name: 'batch_nbr' },
			{ data: 'expiry_date', name: 'expiry_date' },
			{ data: 'tracking_nbr', name: 'tracking_nbr' },
			{ data: 'master_tracking_nbr', name: 'master_tracking_nbr' },
			{ data: 'package_type', name: 'package_type' },
			{ data: 'payment_method', name: 'payment_method' },
			{ data: 'carrier_account_nbr', name: 'carrier_account_nbr' },
			{ data: 'ship_via_code', name: 'ship_via_code' },
			{ data: 'ob_lpn_weight', name: 'ob_lpn_weight' },
			{ data: 'ob_lpn_volume', name: 'ob_lpn_volume' },
			{ data: 'ob_lpn_shipping_charge', name: 'ob_lpn_shipping_charge' },
			{ data: 'ob_lpn_type', name: 'ob_lpn_type' },
			{ data: 'asset_nbr', name: 'asset_nbr' },
			{ data: 'asset_seal_nbr', name: 'asset_seal_nbr' },
			{ data: 'serial_nbr', name: 'serial_nbr' },
			{ data: 'customer_po_type', name: 'customer_po_type' },
			{ data: 'customer_vendor_code', name: 'customer_vendor_code' },
			{ data: 'edit', name: 'edit', orderable: false, searchable: false }
		]
    });
	
	
	$(document).on('click', '#Export', function (e) { 
		var IDs = [];
		$(".exportIDs").each(function()
        {
            if($(this).is(':checked'))
            {
                //$(this).fadeOut();
				IDs.push(this.value);
            }

        });
		
		if(IDs.length === 0)
		{
			alert("Please select records");
		}
		else
		{
			ajax_download('{{ url("/outboundloads/exportOutboundLoads") }}', IDs, 'IDs');
		}
		/*$.ajaxSetup({
			headers: {
			  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			url: '{{ url("/outboundloads/exportOutboundLoads") }}',
			type: 'POST',
			dataType: 'text',
			data: {'IDs': IDs, method: '_POST'},
			success: function (response) {
				console.log(response);
				//
			},
			error: function (result, status, err) {
				alert(result.responseText);
				alert(status.responseText);
				alert(err.Message);
			},
		});*/
	});
	
	$('#checkAll').change(function () {
		$('.exportIDs').prop('checked',this.checked);
	});
	
	function ajax_download(url, data, input_name) {
		var $iframe,
			iframe_doc,
			iframe_html;
	
		//if (($iframe = $('#download_iframe')).length === 0) {
		$iframe = $("<iframe id='download_iframe'" +
					" style='display: none' src='about:blank'></iframe>"
				   ).appendTo("body");
		//}
	
		iframe_doc = $iframe[0].contentWindow || $iframe[0].contentDocument;
		if (iframe_doc.document) {
			iframe_doc = iframe_doc.document;
		}
		iframe_html = "<html><head></head><body><form method='POST' action='" +
					  url +"'>" +
					  '{{ csrf_field() }}' +
					  "<input type=hidden name='" + input_name + "' value='" +
					  data +"'/></form>" +
					  "</body></html>";
					  
		console.log(iframe_html);
	
		iframe_doc.open();
		iframe_doc.write(iframe_html);
		$(iframe_doc).find('form').submit();
	}
	
	$('#daterange-btn').daterangepicker(
	  {
		ranges   : {
		  'Today'       : [moment(), moment()],
		  'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		  'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
		  'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		  'This Month'  : [moment().startOf('month'), moment().endOf('month')],
		  'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		  'This Year'  : [moment().startOf('year'), moment()]
		},
		startDate: moment().subtract(29, 'days'),
		endDate  : moment()
	  },
	  function (start, end) {
		$('#daterange-btn span').html(start.format('YYYY-M-D') + ' - ' + end.format('YYYY-M-D'))
		$('#dateFrom').val(start.format('YYYY-M-D'));
		$('#dateTo').val(end.format('YYYY-M-D'));
		
		$('#viewForm').DataTable().ajax.url( "{{url('/outboundloads/grid')}}?from="+$('#dateFrom').val()+"&to="+$('#dateTo').val() ).load();
	  }
	);
</script>

@endpush