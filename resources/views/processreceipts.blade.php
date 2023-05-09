@extends('layouts.cms')
@section('content-header')
    <h1>
        BBU
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Process Receipts</li>
    </ol>
@endsection

@section('content')


@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
<?php
/*echo "<br />XML<br />";
echo "<pre>";
echo htmlentities($xml);
echo "</pre>";

echo "<br />Response<br />";
echo "<pre>";
echo print_r($xmlResponse);
echo "</pre>";*/
?>
 <div class="box">
    <div class="box-header">
      <h3 class="box-title">Process Receipts detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   		<div class="row">
        	<div class="col-md-4">
                <div class="form-group">
                	<label>Item Receipt No:</label>
                    <select id="RecItem" name="RecItem" class="form-control select2">
                    	<option value="">Select Item Receipt No.</option>
                    @foreach($info_Receipts as $info_Receipt)
                    	@if($selctedID == $info_Receipt->ID)
                        	<option selected="selected" data-ID="{{ $info_Receipt->ID }}" data-ItemCode="{{ $info_Receipt->ItemCode }}" data-Description="{{ $info_Receipt->Description }}" data-isUploadBatch="{{ $info_Receipt->isUploadBatch }}" data-CasesxPallet="{{ $info_Receipt->CasesxPallet }}" data-Batch="{{ $info_Receipt->Batch }}" data-TotalCases="{{ $info_Receipt->TotalCases }}" data-CasesReceived="{{ $info_Receipt->CasesReceived }}" data-PalletsReceived="{{ $info_Receipt->PalletsReceived }}" data-ExpireDate="{{ date('m/d/Y', strtotime($info_Receipt->ExpireDate)) }}"> {{ $info_Receipt->ReceiptNbrItem }}</option>
                        @else
                        	<option data-ID="{{ $info_Receipt->ID }}" data-ItemCode="{{ $info_Receipt->ItemCode }}" data-Description="{{ $info_Receipt->Description }}" data-isUploadBatch="{{ $info_Receipt->isUploadBatch }}" data-CasesxPallet="{{ $info_Receipt->CasesxPallet }}" data-Batch="{{ $info_Receipt->Batch }}" data-TotalCases="{{ $info_Receipt->TotalCases }}" data-CasesReceived="{{ $info_Receipt->CasesReceived }}" data-PalletsReceived="{{ $info_Receipt->PalletsReceived }}" data-ExpireDate="{{ date('m/d/Y', strtotime($info_Receipt->ExpireDate)) }}"> {{ $info_Receipt->ReceiptNbrItem }}</option>
                        @endif
                    @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                	<label>Production Line:</label>
                    <select id="Line" name="Line" class="form-control" style="{{ ($isUploadBatch == "1" ? 'display:none' : 'display:block') }}">
                    	<option value="">Select Line</option>
                        <option value="1" {{ $LineNBR == 1 ? "selected" : "" }}>1</option>
                        <option value="2" {{ $LineNBR == 2 ? "selected" : "" }}>2</option>
                        <option value="3" {{ $LineNBR == 3 ? "selected" : "" }}>3</option>
			<option value="4" {{ $LineNBR == 4 ? "selected" : "" }}>4</option>
			<option value="5" {{ $LineNBR == 5 ? "selected" : "" }}>5</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
            	<div id="ExpireDateDiv" style="display:none">
                <label>Expire Date:</label>
            	<input id="ExpireDate" name="ExpireDate" type="text" class="form-control" value="" placeholder="Expire Date" disabled style="font-size: 20px;"/>
                </div>
            </div>
            <div class="col-md-2">
            	<img class="Loading" style="display:none; height: 30px;" src="{{ url('/loading.gif') }}"/>
            </div>
        </div>
        <div class="row">
        	<div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Item Code:</label>
                            <input id="itemCode" name="itemCode" type="text" class="form-control" value="" placeholder="Item Code" disabled/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Case x Pallet:</label>
                            <input id="CasesxPallet" name="CasesxPallet" type="text" class="form-control" value="" placeholder="Case x Pallet" disabled/>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Batch:</label>
                            <input id="Batch" name="Batch" type="text" class="form-control" value="" placeholder="Batch" disabled/>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Total Order Cases:</label>
                            <input id="TotalCases" name="TotalCases" type="text" class="form-control" value="" placeholder="Total Cases" disabled/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Cases Received:</label>
                            <input id="CasesReceived" name="CasesReceived" type="text" class="form-control" value="" placeholder="Cases Received" disabled/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Pallets Received:</label>
                            <input id="PalletsReceived" name="PalletsReceived" type="text" class="form-control" value="" placeholder="Pallets Received" disabled/>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-md-4">
            	<div style="padding:5px">
                	{!! Form::open([ 'url' => '/processreceipts/print', 'id' => 'printLPnForm' ]) !!}
                        <input type="hidden" name="RcID" id="RcID"/>
                        <input type="hidden" name="LineNBR" id="LineNBR" value="{{ $LineNBR }}"/>
                        <button type="button" name="PrintLPN" id="PrintLPN" class="btn btn-lg btn-default">Print LPN</button>
                    </form>
                </div>
            	<div style="padding:5px">
                    <button type="button" name="ViewLPNs" id="ViewLPNs" class="btn btn-lg btn-default">View LPNs</button>
                </div>
            	<div style="padding:5px">
                    <button type="button" name="NonStandard" id="NonStandard" class="btn btn-lg btn-default">Non Standard</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
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
                    <th>Action</th>
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


<!-- View Modal-->
<div class="modal fade" id="NonStandardModel" tabindex="-1" role="dialog" aria-labelledby="detailModel" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document" style="width:90%">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Non Standard</span></h5>
      <button class="close" type="button" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true"><i class="fa fa-times"></i></span>
      </button>
    </div>
    <div class="modal-body table-responsive">
        <!-- Divider -->
        <div class="table-responsive">
            <img class="Loading" style="display:none; height: 30px;" src="{{ url('/loading.gif') }}"/>
            <table class="table table-bordered" id="dataTableNonStandard" width="100%" cellspacing="0">
                <thead>
                    <th>LPN Number</th>
                    <th width="30%">Current Qty</th>
                    <th>Printed</th>
                    <th>Action</th>
                </thead>
                <tbody id="NonStandardLPNBody">
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
	
	var dataTableViewLPN = $('#dataTableViewLPN').DataTable();
	var dataTableNonStandard = $('#dataTableNonStandard').DataTable();
	var RcID;
	$.ajaxSetup({
		headers: {
		  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
		}
	});
	$("body").on('change', '#RecItem', function(e) {
		updateViews();
	});
	
	$("body").on('change', '#Line', function(e) {		
		$("#LineNBR").val($(this).val())
	});
	
	updateViews();
	function updateViews()
	{
		$("#ExpireDateDiv").hide();
		var selected = $('option:selected', "#RecItem");
		if(selected.val() != "")
		{
			$("#itemCode").val(selected.attr("data-itemCode") +' '+ selected.attr("data-Description"));
			$("#CasesxPallet").val(selected.attr("data-CasesxPallet"));
			$("#Batch").val(selected.attr("data-Batch"));
			$("#TotalCases").val(selected.attr("data-TotalCases"));
			$("#CasesReceived").val(selected.attr("data-CasesReceived"));
			$("#PalletsReceived").val(selected.attr("data-PalletsReceived"));
			if(selected.attr("data-ExpireDate") != '0')
			{
				$("#ExpireDate").val(selected.attr("data-ExpireDate"));
				$("#ExpireDateDiv").show();
			}
			RcID = $("#RecItem option:selected").attr("data-ID");
			$("#RcID").val(RcID);
			
			//alert($("#RecItem option:selected").attr("data-isUploadBatch"))
			if($("#RecItem option:selected").attr("data-isUploadBatch") == 1)
			{
				$("#LineNBR").val("");
				$("#Line").hide();
			}
			else
			{
				$("#Line").show();
			}
		}
	}
	
	$("#PrintLPN").click(function() {
		if(window.confirm("Are you sure to print this LPN?"))
		{
			$(this).attr("disabled", true);
			$("#printLPnForm").submit();
			return true;
		}
		else
		{
			return false;
		}
	});
	
	$("#ViewLPNs").click(function() {
		if($("#RecItem option:selected").val() == "")
		{
			$("#RecItem").focus();
			return false;
		}		
		
		updateViewTable(RcID);
	});
	
	function updateViewTable(RcID)
	{
		$(".Loading").show();
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
					//alert(0)
					$(".Loading").hide();
					dataTableViewLPN.destroy();					
					var Rows = "";
					$.each(response,function(key,value){
						if(value.printed == "1")
						{
							Rows = Rows + '<tr>'+value.id+'</td><td>'+value.lpn_nbr+'</td><td>'+value.item_code+'</td><td>'+value.batch_nbr+'</td><td>'+value.expire_date+'</td><td>'+value.current_qty+'</td><td>'+value.original_qty+'</td><td>Yes</td><td>'+value.printed_by+'</td><td><button id="btnRePrint" href="javascript:void(0)" data-id="'+value.id+'" class="btn btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fa fa-print"></i></span><span class="text"> Re-Print</span></button> </td></tr>';
							//<button href="javascript:void(0)" id="btnDelete" data-message="Are you sure to delete lpn?" data-remote="/processreceipts/'+value.id+'" data-id="'+value.id+'" class="btn btn-danger btn-icon-split"><span class="icon text-white-50"><i class="fa fa-trash"></i></span><span class="text"> Delete</span></button>
						}
						else
						{
							Rows = Rows + '<tr>'+value.id+'</td><td>'+value.lpn_nbr+'</td><td>'+value.item_code+'</td><td>'+value.batch_nbr+'</td><td>'+value.expire_date+'</td><td>'+value.current_qty+'</td><td>'+value.original_qty+'</td><td>No</td><td>'+value.printed_by+'</td><td></td></tr>';
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
	$('#dataTableViewLPN').on('click', '#btnDelete[data-remote]', function (e) { 
		if (confirm($(this).data('message'))) {		
			$(".Loading").show();
			e.preventDefault();		
			var baseUrl = $('meta[name="base-url"]').attr('content');
			var url = baseUrl+$(this).data('remote');
			//alert(url)
			$.ajax({
				url: url,
				type: 'DELETE',
				dataType: 'json',
				data: {method: '_DELETE' , submit: true},
				success: function (response) {
					$(".Loading").hide();
					console.log(response);
				},
				error: function (result, status, err) {
					console.log(result.responseText);
					//alert(status.responseText);
					//alert(err.Message);
				},
			}).always(function (data) {
				updateViewTable(RcID);
			});
		}
		return false;
	});
	
	if('{{$Download}}' == '1')
	{
		//alert('{{ url("/processreceipts/pdf/").'/'.$LPNID }}')
		ajax_download('{{ url("/processreceipts/pdf/").'/'.$LPNID }}', '{{ $LineNBR }}', 'LineNBR');
	}
	
	$(document).on('click', '#btnRePrint', function (e) { 
		//alert($(this).data("id"));
		//alert($(this).closest('tr').find("#current_qty").val());
		$.ajaxSetup({
			headers: {
			  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
		//alert($(this).closest('tr').find("#current_qty").val())
		ajax_download('{{ url("/processreceipts/re-print") }}/'+$(this).data("id"), $(this).closest('tr').find("#current_qty").val(), 'current_qty');
		
		return false;
	});
	
	$("#NonStandard").click(function() {
		if($("#RecItem option:selected").val() == "")
		{
			$("#RecItem").focus();
			return false;
		}		
		
		updateNonStandardTable(RcID);
	});
	
	if('{{$showNonStd}}' == '2')
	{
		swal(
		  '{{$Lpn_Nbr}} successfully printed',
		  '',
		  'success'
		)
	}
	
	if('{{$showNonStd}}' == '1')
	{
		swal(
		  '{{$Lpn_Nbr}} successfully printed',
		  '',
		  'success'
		)
		updateNonStandardTable('{{ $selctedID }}')
	}
	function updateNonStandardTable(RcID)
	{
		$(".Loading").show();
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
					$(".Loading").hide();
					dataTableNonStandard.destroy();					
					var Rows = "";
					$.each(response,function(key,value){
						if(value.printed == "1")
						{
							Rows = Rows + '<tr>'+value.id+'</td><td>'+value.lpn_nbr+'</td><td><span id="current_qty">'+value.current_qty+'</span></td><td>Yes</td><td><button href="javascript:void(0)" disabled class="btn btn-success btn-icon-split"><span class="icon text-white-50"><i class="fa fa-edit"></i></span><span class="text"> Edit</span></button></td></tr>';
						}
						else
						{
							Rows = Rows + '<tr>'+value.id+'</td><td>'+value.lpn_nbr+'</td><td><span id="current_qty">'+value.current_qty+'</span></td><td>No</td><td><button href="javascript:void(0)" value="1" id="btnEdit'+value.id+'" data-remote="/processreceipts/'+value.id+'" data-id="'+value.id+'" class="btn btn-danger btn-icon-split btnEdit"><span class="icon text-white-50"><i class="fa fa-edit"></i></span><span class="text"> Edit</span></button></td></tr>';
						}
					});
					$("#NonStandardLPNBody").html(Rows);
									
					dataTableNonStandard = $('#dataTableNonStandard').DataTable({"pageLength": 5, "lengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]]});
					
					$("#NonStandardModel").modal({
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
	
	$(document).on('click', '.btnEdit', function (e) { 
		//alert($(this).data("type"));
		//alert($(this).val());
		if($(this).val() == "2")
		{
			if (confirm("Are you sure to update the LPN quantity?")) 
			{	
				$(".Loading").show();
				
				$(this).val("1");
				$(this).html('<span class="icon text-white-50"><i class="fa fa-edit"></i></span><span class="text"> Loading...</span>');
				var qtySpan = $(this).closest('tr').find("#current_qty");
				var current_qty = qtySpan.val();
				
				qtySpan.replaceWith('<span id="current_qty">'+current_qty+'</span>');
				
				$.ajaxSetup({
					headers: {
					  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
					}
				});
				$.ajax({
					url: '{{ url("processreceipts/updateQty") }}'+'/'+$(this).data("id"),
					type: 'POST',
					dataType: 'text',
					data: {'current_qty': current_qty, "LineNBR": $("#LineNBR").val(), method: '_GET'},
					success: function (response) {
						console.log(response);
						
						if(response == "0")
						{
							alert("Quantity is same");
						}
						else
						{
							$("#btnEdit"+response).prop("disabled",true);
							$("#btnEdit"+response).html('<span class="icon text-white-50"><i class="fa fa-edit"></i></span><span class="text"> Edit</span>');
							var url = '{{ url('/processreceipts/print-label').'/' }}'+response;
							var token = $('meta[name="csrf-token"]').attr('content');
							//console.log('<form method="POST" action="'+url+'" accept-charset="UTF-8" id="p-form"><input name="_token" type="hidden" value="'+token+'"><input type="hidden" name="LineNBR" id="LineNBR" value="'+$("#LineNBR").val()+'"><input type="hidden" name="RcID" id="RcID" value="'+$("#RcID").val()+'"></form>');
							$('<form method="POST" action="'+url+'" accept-charset="UTF-8" id="p-form"><input name="_token" type="hidden" value="'+token+'"><input type="hidden" name="LineNBR" id="LineNBR" value="'+$("#LineNBR").val()+'"><input type="hidden" name="RcID" id="RcID" value="'+$("#RcID").val()+'"></form>').appendTo('body').submit();
						}
					},
					error: function (result, status, err) {
						alert(result.responseText);
						alert(status.responseText);
						alert(err.Message);
					},
				});	
			}
		}
		else
		{
			var qtySpan = $(this).closest('tr').find("#current_qty");
			var current_qty = qtySpan.html();
			qtySpan.replaceWith("<input id='current_qty' type='text' class='form-control' value='" + current_qty + "' />");
			qtySpan.replaceWith("<a href='#'>Save</a> | <a href='#'>Cancel</a>");
			$(this).val("2");
			$(this).html('<span class="icon text-white-50"><i class="fa fa-save"></i></span><span class="text"> Save</span>');
		}
		
		
	});
	
	$(document).on('click', '#btnPrintLabel', function (e) { 
		/*$(".Loading").show();
		//alert($(this).data("id"));
		//alert($(this).closest('tr').find("#current_qty").val());
		$.ajaxSetup({
			headers: {
			  'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
			}
		});
		//alert($(this).closest('tr').find("#current_qty").html())
		ajax_download('{{ url("/processreceipts/print-label") }}/'+$(this).data("id"), $(this).closest('tr').find("#current_qty").html(), 'current_qty');
		
		return false;*/
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
					  
		console.log($iframe);
	
		iframe_doc.open();
		iframe_doc.write(iframe_html);
		$(iframe_doc).find('form').submit();
	}
</script>

@endpush
