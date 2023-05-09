@extends('layouts.cms')
@section('content-header')
    <h1>
        Users
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Users</li>
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
      <h3 class="box-title">Users detail</h3>
      &nbsp;&nbsp;&nbsp;&nbsp;
      <a href="{{ url('/users/create') }}" style="float:right"><span class="fa fa-fw fa-plus" style="font-size:18px"></span><span style="font-size:18px"></span></a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   
      <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Is</th>
            <th>Username</th>
            <th>Role</th>
            <th>Facility Code</th>
            <th>Label Designer Code</th>
            <th>Printer Name</th>
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
		"ajax": "{{url('/users/grid')}}",
        "columns": [
            { data: 'id', name: 'id' },
            { data: 'username', name: 'username' },
			{ data: 'role_id', name: 'role_id' },
			{ data: 'facility_code', name: 'facility_code' },
			{ data: 'label_designer_code', name: 'label_designer_code' },
			{ data: 'printer_name', name: 'printer_name' },
			{ data: 'edit', name: 'edit', orderable: false, searchable: false }
		]
    });
	
	$('#viewForm').on('click', '#btnDelete[data-remote]', function (e) { 
		if (confirm("Are you sure to delete user?")) {		
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