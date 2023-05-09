@extends('layouts.cms')
@section('content-header')
    <h1>
        Owm Items
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Owm Items</li>
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
      <h3 class="box-title">Owm Items detail</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	<div>
      	<hr />
        {!! Form::open(['url' => '/owmitem/import', 'files' => true, 'id' => 'main-form']) !!}
      		<input type="file" name="owmitem" /><br />
            @if ($errors->has('owmitem'))
            <p style="color:red;">{!!$errors->first('owmitem')!!}</p>
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
                <th>part_a</th>
                <th>description</th>
                <th>expcalcm</th>
                <th>barcode</th>
                <th>cases_per_pallet</th>
                <th>unit_length</th>
                <th>unit_width</th>
                <th>unit_height</th>
                <th>unit_weight</th>
                <th>unit_volume</th>
                <th>std_case_qty</th>
                <th>product_life</th>
                <th>percent_acceptable_product_life</th>
                <th>external_style</th>
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
    <div class="modal-body table-responsive" id="modelBody">
        
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
            "url": "{{url('/owmitem/grid')}}",
            "type": "POST",
			'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
        },
        "columns": [
            { data: 'id', name: 'id' },
			{ data: 'part_a', name: 'part_a' },
			{ data: 'description', name: 'description' },
			{ data: 'expcalcm', name: 'expcalcm' },
			{ data: 'barcode', name: 'barcode' },
			{ data: 'cases_per_pallet', name: 'cases_per_pallet' },
			{ data: 'unit_length', name: 'unit_length' },
			{ data: 'unit_width', name: 'unit_width' },
			{ data: 'unit_height', name: 'unit_height' },
			{ data: 'unit_weight', name: 'unit_weight' },
			{ data: 'unit_volume', name: 'unit_volume' },
			{ data: 'std_case_qty', name: 'std_case_qty' },
			{ data: 'product_life', name: 'product_life' },
			{ data: 'percent_acceptable_product_life', name: 'percent_acceptable_product_life' },
			{ data: 'external_style', name: 'external_style' },
			{ data: 'edit', name: 'edit', orderable: false, searchable: false }
		]
    });

	@if (Session::has('Responses'))
		<?php $Responses = Session::get('Responses'); ?>
		@if($Responses == "")
			swal({
				text: "Items have been created",
				icon: 'success'
			});
		@else
			var span = document.createElement("span");
			span.innerHTML = "{!! Session::get('Responses') !!}";
			swal({
				content: span,
				icon: 'warning'
			});
		@endif
	@endif
	
	$(document).on('change', '.expcalcm', function (e) {
		var url = "{{ url('/owmitem/updateExpMethod') }}/" + $(this).data('itemid');	
		//alert(url)
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'text',
			data: {method: '_POST', "_token": "{{ csrf_token() }}" , "expcalcm": $(this).val(), submit: true},
			success: function (response) {
				console.log(response)
			},
			error: function (result, status, err) {
				console.log(result)
			},
		});
	});
</script>

@endpush