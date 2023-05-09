@extends('layouts.cms')
@section('content-header')
    <h1>
        BBU
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Verified Shipments</li>
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
      <h3 class="box-title">Verified Shipments detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
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
                <th>shipment_nbr</th>
                <th>facility_code</th>
                <th>company_code</th>
                <th>trailer_nbr</th>
                <th>ref_nbr</th>
                <th>shipment_type</th>
                <th>load_nbr</th>
                <th>manifest_nbr</th>
                <th>trailer_type</th>
                <th>vendor_info</th>
                <th>origin_info</th>
                <th>origin_code</th>
                <th>orig_shipped_units</th>
                <th>shipped_date</th>
                <th>orig_shipped_lpns</th>
                <th>shipment_hdr_cust_field_1</th>
                <th>shipment_hdr_cust_field_2</th>
                <th>shipment_hdr_cust_field_3</th>
                <th>shipment_hdr_cust_field_4</th>
                <th>shipment_hdr_cust_field_5</th>
                <th>verification_date</th>
                <th>returned_from_facility_code</th>
                <th>seq_nbr</th>
                <th>lpn_nbr</th>
                <th>lpn_weight</th>
                <th>lpn_volume</th>
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
                <th>shipped_qty</th>
                <th>priority_date</th>
                <th>po_nbr</th>
                <th>pallet_nbr</th>
                <th>putaway_type</th>
                <th>received_qty</th>
                <th>expiry_date</th>
                <th>batch_nbr</th>
                <th>recv_xdock_facility_code</th>
                <th>shipment_dtl_cust_field_1</th>
                <th>shipment_dtl_cust_field_2</th>
                <th>shipment_dtl_cust_field_3</th>
                <th>shipment_dtl_cust_field_4</th>
                <th>shipment_dtl_cust_field_5</th>
                <th>lpn_is_physical_pallet_flg</th>
                <th>po_seq_nbr</th>
                <th>lock_code</th>
                <th>serial_nbr</th>
                <th>invn_attr_d</th>
                <th>invn_attr_e</th>
                <th>invn_attr_f</th>
                <th>invn_attr_g</th>
                <th>rcvd_trailer_nbr</th>
                <th>po_dtl_line_schedule_nbrs</th>
                <th>reference_order_nbr</th>
                <th>reference_order_seq_nbr</th>
                <th>invn_attr_h</th>
                <th>invn_attr_i</th>
                <th>invn_attr_j</th>
                <th>invn_attr_k</th>
                <th>invn_attr_l</th>
                <th>invn_attr_m</th>
                <th>invn_attr_n</th>
                <th>invn_attr_o</th>
                <th>inventory_lock_code</th>
                <th>erp_bucket</th>
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
            "url": "{{url('/verifiedshipments/grid')}}",
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
			{ data: 'shipment_nbr', name: 'shipment_nbr' },
			{ data: 'facility_code', name: 'facility_code' },
			{ data: 'company_code', name: 'company_code' },
			{ data: 'trailer_nbr', name: 'trailer_nbr' },
			{ data: 'ref_nbr', name: 'ref_nbr' },
			{ data: 'shipment_type', name: 'shipment_type' },
			{ data: 'load_nbr', name: 'load_nbr' },
			{ data: 'manifest_nbr', name: 'manifest_nbr' },
			{ data: 'trailer_type', name: 'trailer_type' },
			{ data: 'vendor_info', name: 'vendor_info' },
			{ data: 'origin_info', name: 'origin_info' },
			{ data: 'origin_code', name: 'origin_code' },
			{ data: 'orig_shipped_units', name: 'orig_shipped_units' },
			{ data: 'shipped_date', name: 'shipped_date' },
			{ data: 'orig_shipped_lpns', name: 'orig_shipped_lpns' },
			{ data: 'shipment_hdr_cust_field_1', name: 'shipment_hdr_cust_field_1' },
			{ data: 'shipment_hdr_cust_field_2', name: 'shipment_hdr_cust_field_2' },
			{ data: 'shipment_hdr_cust_field_3', name: 'shipment_hdr_cust_field_3' },
			{ data: 'shipment_hdr_cust_field_4', name: 'shipment_hdr_cust_field_4' },
			{ data: 'shipment_hdr_cust_field_5', name: 'shipment_hdr_cust_field_5' },
			{ data: 'verification_date', name: 'verification_date' },
			{ data: 'returned_from_facility_code', name: 'returned_from_facility_code' },
			{ data: 'seq_nbr', name: 'seq_nbr' },
			{ data: 'lpn_nbr', name: 'lpn_nbr' },
			{ data: 'lpn_weight', name: 'lpn_weight' },
			{ data: 'lpn_volume', name: 'lpn_volume' },
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
			{ data: 'shipped_qty', name: 'shipped_qty' },
			{ data: 'priority_date', name: 'priority_date' },
			{ data: 'po_nbr', name: 'po_nbr' },
			{ data: 'pallet_nbr', name: 'pallet_nbr' },
			{ data: 'putaway_type', name: 'putaway_type' },
			{ data: 'received_qty', name: 'received_qty' },
			{ data: 'expiry_date', name: 'expiry_date' },
			{ data: 'batch_nbr', name: 'batch_nbr' },
			{ data: 'recv_xdock_facility_code', name: 'recv_xdock_facility_code' },
			{ data: 'shipment_dtl_cust_field_1', name: 'shipment_dtl_cust_field_1' },
			{ data: 'shipment_dtl_cust_field_2', name: 'shipment_dtl_cust_field_2' },
			{ data: 'shipment_dtl_cust_field_3', name: 'shipment_dtl_cust_field_3' },
			{ data: 'shipment_dtl_cust_field_4', name: 'shipment_dtl_cust_field_4' },
			{ data: 'shipment_dtl_cust_field_5', name: 'shipment_dtl_cust_field_5' },
			{ data: 'lpn_is_physical_pallet_flg', name: 'lpn_is_physical_pallet_flg' },
			{ data: 'po_seq_nbr', name: 'po_seq_nbr' },
			{ data: 'lock_code', name: 'lock_code' },
			{ data: 'serial_nbr', name: 'serial_nbr' },
			{ data: 'invn_attr_d', name: 'invn_attr_d' },
			{ data: 'invn_attr_e', name: 'invn_attr_e' },
			{ data: 'invn_attr_f', name: 'invn_attr_f' },
			{ data: 'invn_attr_g', name: 'invn_attr_g' },
			{ data: 'rcvd_trailer_nbr', name: 'rcvd_trailer_nbr' },
			{ data: 'po_dtl_line_schedule_nbrs', name: 'po_dtl_line_schedule_nbrs' },
			{ data: 'reference_order_nbr', name: 'reference_order_nbr' },
			{ data: 'reference_order_seq_nbr', name: 'reference_order_seq_nbr' },
			{ data: 'invn_attr_h', name: 'invn_attr_h' },
			{ data: 'invn_attr_i', name: 'invn_attr_i' },
			{ data: 'invn_attr_j', name: 'invn_attr_j' },
			{ data: 'invn_attr_k', name: 'invn_attr_k' },
			{ data: 'invn_attr_l', name: 'invn_attr_l' },
			{ data: 'invn_attr_m', name: 'invn_attr_m' },
			{ data: 'invn_attr_n', name: 'invn_attr_n' },
			{ data: 'invn_attr_o', name: 'invn_attr_o' },
			{ data: 'inventory_lock_code', name: 'inventory_lock_code' },
			{ data: 'erp_bucket', name: 'erp_bucket' },
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
			ajax_download('{{ url("/verifiedshipments/exportVerifiedShipments") }}', IDs, 'IDs');
		}
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
</script>

@endpush