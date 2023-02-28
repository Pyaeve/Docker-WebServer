@extends('layouts.bs3.app')

@section('content')
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row ">
          <div class="col-md-12">
             {!!  Breadcrumbs::render('VendedoresEditar')!!}
          </div>
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
      						 <h3 class="card-title">Editar Datos del Vendedor</h3>

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
          					  {!! BootForm::open()->action(route('backend.vendedores.actualizar'))->enctype('multipart/form-data') !!}
                      {!! BootForm::hidden('vendedor_id')->value($data['id'])!!}

                      {!! BootForm::hidden('agencia_id')->value($data['agencia_id']) !!}
                      {!! BootForm::text('Nombres', 'nombre')->value($data['nombre'])->attr('required') !!}
                      {!! BootForm::text('Apellidos', 'apellido')->value($data['apellido'])->attr('required') !!}
                      {!! BootForm::hidden('zona_id')->value($data['zona_id'])->addClass('zona') !!}
                      {!! BootForm::hidden('ciudad_id')->value($data['ciudad_id'])->addClass('ciudad') !!}
                       {!! BootForm::text('Cedula Nro', 'ci')->value($data['ci']) !!}
                      {!! BootForm::text('Contacto', 'contacto')->value($data['contacto']) !!}
                      {!! BootForm::text('Domicilio', 'domicilio')->value($data['domicilio']) !!}
                      
                      {!! BootForm::submit('Actualizar')->addClass('btn btn-primary') !!}
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
    
      $('.agencia').change(function(e){
       
        var url1='{!! env('APP_URL') !!}/backend/ciudades/ajax/'+v;
        $.ajax({
            url: url1,
            dataType:'json',
            beforeSend: function(){
              
              $('#LoaderCircularBlack').show();
          setTimeout(function () {
            $preloader.children().hide();
          }, 200);
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