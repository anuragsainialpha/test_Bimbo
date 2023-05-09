
@extends('layouts.cms')
@section('content-header')
    <h1>
        BBU
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class="active">Order</li>
    </ol>
@endsection

@section('content')


@if(Session::has('flash_message'))
    <div class="alert alert-success">
        {{ Session::get('flash_message') }}
    </div>
@endif
{!! Form::open([ 'url' => '/order/import', 'files' => true, 'id' => 'sub-form' ]) !!}
 <div class="box">
    <div class="box-header">
      <h3 class="box-title">Order</h3>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
   		<div class="row">
        	<div class="col-md-4">
                <div class="form-group">
                    <input type="file" name="orders" /><br />
                    @if ($errors->has('orders'))
                    <p style="color:red;">{!!$errors->first('orders')!!}</p>
                    @endif
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
	if('{{$Uploaded}}' == '1')
	{
		swal(
		  'Orders successfully uploaded',
		  '',
		  'success'
		)
	}
</script>

@endpush