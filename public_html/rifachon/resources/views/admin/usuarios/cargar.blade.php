@extends('layouts.bs3.app')

@section('content')
<div class="container">
	 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-3">
            <h1 class="m-0">Dashboard v2</h1>
          </div><!-- /.col -->
          <div class="col-sm-9">
            <ol class="breadcrumb float-sm-left">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v2</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

              Cargar Usuario
            </div>

                <div class="card-body">
                    {!! BootForm::open()->action(route('backend.usuarios.registrar')) !!}
                    {!! BootForm::select('Rol','role')->options($roles)->addClass('rol') !!}    
                    {!! BootForm::text('Nombre','name')->required() !!}
                    {!! BootForm::text('Apellido','sername')->required() !!}
                    {!! BootForm::text('Email','email')->required() !!}
                    {!! BootForm::password('Contrase&ntilde;a','password') !!}
                    {!! BootForm::password('Confirm','password_confirmation')->id('password-confirm') !!}
                    {!! BootForm::submit('Cargar')->addClass('btn btn-primary') !!}
                    {!! BootForm::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
