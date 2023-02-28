@extends('layouts.bs3.app')

@section('content')
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-md-12">
               {!! Breadcrumbs::render('SorteosCargar'); !!}
            </div<!-- /.col -->
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
      						 <h3 class="card-title">Cargar Nueva Agencia</h3>

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
          					  {!! BootForm::open()->action(route('backend.agencias.guardar'))->enctype('multipart/form-data') !!}
                      {!! BootForm::text('Nombre', 'nombre')->attr('required') !!}
                      {!! BootForm::text('Ruc', 'ruc')->attr('required') !!}
                      {!! BootForm::text('Email', 'email')->attr('required') !!}
                      {!! BootForm::text('Contacto', 'contacto')->attr('required') !!}
                      {!! BootForm::text('Direccion', 'domicilio')->attr('required') !!}
                      {!! BootForm::select('Zona','zona_id')->options($zonas)->addClass('zona') !!}
                      {!! BootForm::select('Ciudad','ciudad_id')->options($ciudades)->addClass('ciudad') !!}
                      {!! BootForm::submit('Cargar')->addClass('btn btn-primary') !!}
                      <a class="btn btn-default" href="{!! route('backend.agencias.resumen') !!}">Cancelar</a>
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
    
      $('.zona').change(function(e){
        var v =  $('.zona').val();
        var url1='{!! env('APP_URL') !!}/backend/ciudades/ajax/'+v;
        $.ajax({
            url: url1,
            dataType:'json',
            beforeSend: function(){
              
              $('#LoaderCircularBlack').show();
         
            }, 
            complete: function(){
                $('#LoaderCircularBlack').hide();
            },

            success: function(res) {
                var el = $('.ciudad');                        
                el.find('option').remove();                          
   
                $.each(res, function (k, j) {
                    el.append($('<option></option>').attr('value', j.ID).text(j.CIUDAD));
                });

               

             },
            error: function() {
                alert("No se ha podido obtener la información");
            }
        });
        
    });
@endsection