@extends('layouts.cms')
@section('content-header')
    <h1>
        BBU
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Freezer LPN</li>
    </ol>
@endsection

@section('content')


@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
{!! Form::open([ 'url' => '/freezerlpn', 'id' => 'sub-form' ]) !!}
 <div class="box">
    <div class="box-header">
      <h3 class="box-title">Process Freezer LPN</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   		<div class="row">
        	<div class="col-md-4">
                <div class="form-group">
                    <select id="Line" name="ShippingLocation" class="form-control" required>
                    	<option value="">Freezer Shipping Location</option>
                        @foreach($ShippingLocation as $Data)
                        <option value="{{ $Data->location_barcode }}">{{ $Data->location_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <select id="Line" name="StorageLocation" class="form-control" required>
                    	<option value="">Freezer Storage Location</option>
						@foreach($StorageLocation as $Data)
                        <option value="{{ $Data->location_barcode }}">{{ $Data->location_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Process</button>
                </div>
            </div>
        </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box -->
</div>
</form>
@endsection

@push('scripts')

<script type="text/javascript">
	
</script>

@endpush