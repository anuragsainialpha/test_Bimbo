@extends('layouts.cms')
@section('content-header')
    <h1>
        Manufacturing Receipts
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Manufacturing Receipts</li>
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
      <h3 class="box-title">Manufacturing Receipts detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	<div>
      	<hr />
        {!! Form::open(['url' => '/manufacturingreceipts/import', 'files' => true, 'id' => 'main-form']) !!}
      		<input type="file" name="owmitem" /><br />
            @if ($errors->has('receipt'))
            <p style="color:red;">{!!$errors->first('receipt')!!}</p>
            @endif
            {!! Form::submit('Upload', ['class' => 'btn btn-primary']) !!}
        {!! Form::close() !!}
        <hr />
      </div>
   		<div class="table-responsive">
          <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>id</th>
                <th>item_code</th>
                <th>facility_code</th>
                <th>wms_asn_nbr</th>
                <th>std_pallet_qty</th>
                <th>batch_nbr</th>
                <th>shipped_qty</th>
                <th>received_qty</th>
                <th>status</th>
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

<!-- View Modal-->
<div class="modal fade" id="ImportDetailModel" tabindex="-1" role="dialog" aria-labelledby="ImpoerDetailModel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" style="width:90%">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Import Detail</span></h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fa fa-times"></i></span>
      </button>
    </div>
    <div class="modal-body table-responsive" id="modelBody" style="text-align: center;">
        
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>

<!-- View Modal-->
<div class="modal fade" id="viewModel" tabindex="-1" role="dialog" aria-labelledby="detailModel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" style="width:90%">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">View LPN</span></h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fa fa-times"></i></span>
      </button>
    </div>
    <div class="modal-body table-responsive">
        <!-- Divider -->
        <div class="table-responsive">
            <img class="Loading" style="display:none; height: 30px;" src="{{ url('/loading.gif') }}"/>
            <table class="table table-bordered" id="dataTableViewLPN" width="100%" cellspacing="0">
                <thead>
                    <th>LPN Number</th>
                    <th>Item Code</th>
                    <th>Batch</th>
                    <th>Expiry Date</th>
                    <th>Current Qty</th>
                    <th>Original Qty</th>
                    <th>Printed</th>
                    <th>Printed By</th>
                </thead>
                <tbody id="ViewLPNBody">
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>


@endsection

@push('scripts')

<script type="text/javascript">
    $('#viewForm').DataTable({
        "processing": true,
        "serverSide": true,
		"ajax": {
            "url": "{{url('/manufacturingreceipts/grid')}}",
            "type": "POST",
			'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "columns": [
            { data: 'id', name: 'id' },
			{ data: 'item_code', name: 'item_code' },
			{ data: 'facility_code', name: 'facility_code' },
			{ data: 'wms_asn_nbr', name: 'wms_asn_nbr' },
			{ data: 'std_pallet_qty', name: 'std_pallet_qty' },
			{ data: 'batch_nbr', name: 'batch_nbr' },
			{ data: 'shipped_qty', name: 'shipped_qty' },
			{ data: 'received_qty', name: 'received_qty' },
			{ data: 'status', name: 'status' },
		],
		dom:
		  "<'ui grid'"+
			 "<'row'"+
				"<'col-md-4'l>"+
				"<'pull-right col-md-4'f>"+
			 ">"+
			 "<'row'"+
				"<'col-md-12 mt-5 mb-5'B>"+
			 ">"+
			 "<'row dt-table'"+
				"<'col-md-12'tr>"+
			 ">"+
			 "<'row'"+
				"<'col-md-6'i>"+
				"<'pull-right col-md-6'p>"+
			 ">"+
		  ">",
        buttons: [
			{ extend: 'excel', text: 'Export', className: 'btn btn-success' }
        ]
    });
	
	@if (Session::has('autoNumberReceipt'))
		$("#modelBody").html('{!! Session::get('autoNumberReceipt') !!}');
		$("#ImportDetailModel").modal({
			backdrop: 'static',
			keyboard: false
		}); 
		/*swal(
		  '{!! Session::get('autoNumberReceipt') !!}',
		  '',
		  'success'
		)*/
	@endif
	
	$(document).on('click', '#Export', function (e) { 
		ajax_download('{{ url("/manufacturingreceipts/export") }}/', '1', '1');
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
		iframe_html = "<html><head></head><body><form method='GET' action='" +
					  url +"'>" +
					  '{{ csrf_field() }}' +
					  "<input type=hidden name='" + input_name + "' value='" +
					  data +"'/></form>" +
					  "</body></html>";
					  
		//console.log($iframe);
	
		iframe_doc.open();
		iframe_doc.write(iframe_html);
		$(iframe_doc).find('form').submit();
	}
	
	$(document).on('click', '.ViewLPNs', function (e) { 
		updateViewTable($(this).data("id"));
	});
	var dataTableViewLPN = $('#dataTableViewLPN').DataTable();
	function updateViewTable(RcID)
	{
		$.ajax({
			url: '{{ url("processreceipts/viewlpns") }}',
			type: 'GET',
			dataType: 'json',
			data: {'receiptid': RcID, method: '_GET'},
			success: function (response) {
				//If exist LPN number show next step
				console.log(response);
				if(!jQuery.isEmptyObject(response))
				{
					dataTableViewLPN.destroy();					
					var Rows = "";
					$.each(response,function(key,value){
						if(value.printed == "1")
						{
							Rows = Rows + '<tr>'+value.id+'</td><td>'+value.lpn_nbr+'</td><td>'+value.item_code+'</td><td>'+value.batch_nbr+'</td><td>'+value.expire_date+'</td><td>'+value.current_qty+'</td><td>'+value.original_qty+'</td><td>Yes</td><td>'+value.printed_by+'</td></tr>';
						}
						else
						{
							Rows = Rows + '<tr>'+value.id+'</td><td>'+value.lpn_nbr+'</td><td>'+value.item_code+'</td><td>'+value.batch_nbr+'</td><td>'+value.expire_date+'</td><td>'+value.current_qty+'</td><td>'+value.original_qty+'</td><td>No</td><td>'+value.printed_by+'</td></tr>';
						}
					});
					$("#ViewLPNBody").html(Rows);
									
					dataTableViewLPN = $('#dataTableViewLPN').DataTable({"pageLength": 5, "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]});
					
					$("#viewModel").modal({
						backdrop: 'static',
						keyboard: false
					}); 
					
				}
				
			},
			error: function (result, status, err) {
				alert(result.responseText);
				alert(status.responseText);
				alert(err.Message);
			},
		});
	}
</script>

@endpush