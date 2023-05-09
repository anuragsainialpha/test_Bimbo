@extends('layouts.cms')

@section('content-header')
    <h1>
        Parameters
        <small>Add Parameter</small>
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class=""><a href="/parameter"><i class="fa fa-cog"></i> <span>Parameters</span></a></li>
        <li class="active">Add Parameters</li>
    </ol>
@endsection
@section('content')
{!! Form::open(['url' => '/parameter', 'files' => true, 'id' => 'main-form']) !!}
<div class="row">
    <div class="col-md-6">
       <div class="box box-info">
          <div class="box-header">
             <h3 class="box-title">
                <i class="fa fa-parameter"></i>
                Add Parameters
             </h3>
          </div>
          <div class="box-body">
             <div class="form-group">
                <label>Paramter:</label>
                {!! Form::text('parameter', null, ['class' => 'form-control' , 'placeholder' => 'Paramter']) !!}
                @if ($errors->has('parameter'))
                <p style="color:red;">{!!$errors->first('parameter')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label>Value:</label>
                {!! Form::text('value', null, ['class' => 'form-control' , 'placeholder' => 'Value']) !!}
                @if ($errors->has('value'))
                <p style="color:red;">{!!$errors->first('value')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label></label>
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
             </div>
          </div>
       </div>
   </div>
</div>
  
{!! Form::close() !!}

@endsection