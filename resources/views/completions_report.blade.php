@extends('layouts.cms')
@section('content-header')
    <h1>
        Reports
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Print Report</li>
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
      <h3 class="box-title">Completions Report</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
    	<div class="row">
        	<div class="col-sm-4 form-group">
                <label for="exampleInputEmail1">Filter By Print Date/Time:</label>
                <button type="button" class="btn btn-default form-control" id="daterange-btn">
                    <span class="pull-left">
                        <i class="fa fa-calendar"></i> Date/Time range picker
                    </span>
                    <i class="fa fa-caret-down pull-right"></i>
                </button>
                <input type="hidden" name="dateFrom" id="dateFrom" value="{{ Session::get('dateFrom') }}" />
                <input type="hidden" name="dateTo" id ="dateTo" value="{{ Session::get('dateTo') }}" />
            </div>
        </div>
   		<div class="table-responsive">
          <table id="viewForm" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
            	<th>Line Printed</th>
                <th>Item Code</th>
                <th>Description</th>
                <th>Total Cases</th>
                <th>Total Units</th>
                <th>Print Date</th>
                <th>Shift</th>
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
	$('#daterange-btn').daterangepicker(
	  {
		timePicker: true,
        locale: {
          format: 'YYYY-M-D H:mm'
        },
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
		$('#daterange-btn span').html(start.format('YYYY-M-D H:mm') + ' - ' + end.format('YYYY-M-D H:mm'))
		$('#dateFrom').val(start.format('YYYY-M-D H:mm'));
		$('#dateTo').val(end.format('YYYY-M-D H:mm'));
		
		$('#viewForm').DataTable().ajax.url( "{{url('/completions_report/grid').'/'}}"+"?from="+$('#dateFrom').val()+"&to="+$('#dateTo').val() ).load();
	  }
	);
	
	$('#viewForm').DataTable({
        "processing": true,
        "serverSide": true,
		"ajax": {
            "url": "{{url('/completions_report/grid').'/'}}",
            "type": "GET",
			'headers': {'X-CSRF-TOKEN': '{{ csrf_token() }}',
			data: {'from': moment().subtract(29, 'days').format('YYYY-M-D'), 'to':moment().format('YYYY-M-D'), method: '_GET'},
			}
        },
        "columns": [
			{ data: 'Line_Printed', name: 'Line_Printed' },
			{ data: 'item_code', name: 'item_code' },
			{ data: 'Description', name: 'Description' },
			{ data: 'Total_Cases', name: 'Total_Cases' },
			{ data: 'Total_Units', name: 'Total_Units' },
			{ data: 'Print_Date', name: 'Print_Date' },
			{ data: 'Shift', name: 'Shift' },
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
</script>

@endpush