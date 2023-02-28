@extends('layouts.bs3.app')

@section('content')
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

    <!-- Main content -->
    <section class="content">
      	<div class="container-fluid">
          <div id="LoaderCircularBlack"> 
  <div id="LoaderCircularBlack_1" classLoaderCircularBlack="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_2" class="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_3" class="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_4" LoaderCircularBlackclass="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_5" classLoaderCircularBlack="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_6" classLoaderCircularBlack="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_7" class="LoaderCircularBlack"></div>
  <div id="LoaderCircularBlack_8" class="LoaderCircularBlack"></div>
</div>
      		<div class="row">
      			<div class="col-md-12">
      				<div class="card card-primary">
      					<div class="card-header">
      						 <h3 class="card-title">Cargar Nuevo Agente</h3>

          					<div class="card-tools">
            					<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
             					 <i class="fas fa-minus"></i>
            					</button>
          						  <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
              					<i class="fas fa-times"></i>
            					</button>
         					 </div>
      		
       					  </div>
          				<div class="card-body">
          					  {!! BootForm::open()->action(route('backend.agentes.guardar'))->enctype('multipart/form-data') !!}
                      {!! BootForm::select('Agencia','agencia_id')->options($agencias)->addClass('agencia') !!}
                      {!! BootForm::text('Nombres', 'nombre')->attr('required') !!}
                      {!! BootForm::text('Apellidos', 'apellido')->attr('required') !!} 
                      {!! BootForm::text('Contacto', 'contacto')->attr('required') !!}
                      {!! BootForm::text('Direccio&acute;n', 'domicilio')->attr('required') !!}
                      {!! BootForm::email('Correo', 'email')->attr('required') !!}
                      {!! BootForm::password('Contrasde&ntilde;a', 'password')->attr('required') !!}
                      {!! BootForm::submit('Cargar')->addClass('btn btn-primary') !!}
                      <a class="btn btn-default" href="{!! route('backend.agentes.resumen') !!}">Cancelar</a>
                      {!! BootForm::close() !!}
          				</div>
      				</div>
      			</div>
      		</div>
      	</div>
    </section>
     <!-- /.Main content -->
@endsection
@section('scripts')
  $('#LoaderCircularBlack').hide();
    
      
@endsection