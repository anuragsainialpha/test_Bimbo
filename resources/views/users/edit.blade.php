@extends('layouts.cms')

@section('content-header')
    <h1>
        Users
        <small>Edit User</small>
    </h1>
    <ol class="breadcrumb">
    	<li><a href="/home"><i class="fa fa-home"></i> Dashboard</a></li>
        <li class=""><a href="/users"><i class="fa fa-users"></i> <span>Users</span></a></li>
        <li class="active">Edit Users</li>
    </ol>
@endsection
@section('content')
{!! Form::model($user, ['method' => 'PATCH', 'url' => ['/users', $user->id], 'files' => true,'id' => 'main-form']) !!}
<div class="row">
    <div class="col-md-6">
       <div class="box box-info">
          <div class="box-header">
             <h3 class="box-title">
                <i class="fa fa-users"></i>
                Add Users
             </h3>
          </div>
          <div class="box-body">
             <div class="form-group">
                <label>Username:</label>
                {!! Form::text('username', null, ['class' => 'form-control' , 'placeholder' => 'Username']) !!}
                @if ($errors->has('username'))
                <p style="color:red;">{!!$errors->first('username')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label>Password:</label>
                {!! Form::password('password', ['class' => 'form-control' , 'placeholder' => 'Password']) !!}
                @if ($errors->has('password'))
                <p style="color:red;">{!!$errors->first('password')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label>Role Id:</label>
                {!! Form::text('role_id', null, ['class' => 'form-control' , 'placeholder' => 'Role Id']) !!}
                @if ($errors->has('role_id'))
                <p style="color:red;">{!!$errors->first('role_id')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label>Facility Code:</label>
                {!! Form::text('facility_code', null, ['class' => 'form-control' , 'placeholder' => 'Facility Code']) !!}
                @if ($errors->has('facility_code'))
                <p style="color:red;">{!!$errors->first('facility_code')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label>Label Designer Code:</label>
                {!! Form::text('label_designer_code', null, ['class' => 'form-control' , 'placeholder' => 'Label Designer Code', 'required']) !!}
                @if ($errors->has('label_designer_code'))
                <p style="color:red;">{!!$errors->first('label_designer_code')!!}</p>
                @endif
             </div>
			 <div class="form-group">
                <label>Printer Name:</label>
                {!! Form::text('printer_name', null, ['class' => 'form-control' , 'placeholder' => 'Printer Name', 'required']) !!}
                @if ($errors->has('printer_name'))
                <p style="color:red;">{!!$errors->first('printer_name')!!}</p>
                @endif
             </div>
             <div class="form-group">
                <label>Is Admin:</label>
				<?php
					$defaultSelection = ["1" => "Yes", "0" => "No"];
                ?>
                {!! Form::select('is_admin', $defaultSelection, null, ['class' => 'form-control']) !!}
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