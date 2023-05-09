@extends('layouts.cms')
@section('content-header')
    <h1>
        Parameters
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Parameters</li>
    </ol>
@endsection

@section('content')


@if(Session::has('flash_message'))Parameters
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
 <div class="box">
    <div class="box-header">
      <h3 class="box-title">Parameters detail</h3>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a href="{{ url('/parameter/create') }}" style="float:right"><span class="fa fa-fw fa-plus" style="font-size:18px"></span><span style="font-size:18px"></span></a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   
      <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Is</th>
            <th>Parameter</th>
            <th>Value</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tfoot>
      </table>
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
		"ajax": "{{url('/parameter/grid')}}",
        "columns": [
            { data: 'id', name: 'id' },
            { data: 'parameter', name: 'parameter' },
			{ data: 'value', name: 'value' },
			{ data: 'edit', name: 'edit', orderable: false, searchable: false }
		]
    });
	
	$('#viewForm').on('click', '#btnDelete[data-remote]', function (e) { 
		if (confirm("Are you sure to delete parameter?")) {		
			e.preventDefault();		 
			var url = '{{url("/")}}'+$(this).data('remote');
			// confirm then
			$.ajax({
				url: url,
				type: 'DELETE',
				dataType: 'json',
				data: {method: '_DELETE', "_token": "{{ csrf_token() }}" , submit: true},
				error: function (result, status, err) {
					//alert(result.responseText);
					//alert(status.responseText);
					//alert(err.Message);
				},
			}).always(function (data) {
				$('#viewForm').DataTable().draw(false);
			});
		}
		return false;
	});
</script>

@endpush