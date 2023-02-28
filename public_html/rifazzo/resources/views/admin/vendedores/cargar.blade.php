@extends('layouts.bs3.app')

@section('content')
  <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-md-12">
              {!!  Breadcrumbs::render('VendedoresAgregar')!!}
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
      						 <h3 class="card-title">Cargar Nuevo Vendedor</h3>

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
                    <div class="col-md-12">
                      {!! BootForm::open()->action(route('backend.vendedores.guardar'))->enctype('multipart/form-data') !!}

                      <div class="row">
                        <div class="col-md-6">
                            {!! BootForm::hidden('role')->value('Vendedor') !!}
                            {!! BootForm::select('Agencia','agencia_id')->options($agencias)->addClass('agencia') !!}
                        </div>
                        <div class="col-md-6">
                            {!! BootForm::text('Email', 'email')->attr('required') !!}
                          
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          {!! BootForm::text('Nombres', 'nombre')->attr('required') !!}
                           
                        </div>
                        <div class="col-md-6">
                          {!! BootForm::text('Apellidos', 'apellido')->attr('required') !!}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                           {!! BootForm::text('Cedula Nro', 'ci')->attr('required') !!}
                        </div>
                        <div class="col-md-6">
                            {!! BootForm::text('Contacto', 'contacto')->attr('required') !!}
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                           {!! BootForm::password('Contraseña', 'password')->attr('required') !!}
                        </div>
                        <div class="col-md-6">
                           {!! BootForm::select('POS','pos_id')->options($pos)->addClass('pos') !!}
                        </div>
                      </div>
                       <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                      </div>
                       <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                      </div>
                       <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                      </div>
                        <div class="row">
                        <div class="col-md-6"></div>
                        <div class="col-md-6"></div>
                      </div>
                     
                     
                      
                     
                     
                    
                    
                     
                      {!! BootForm::submit('Cargar')->addClass('btn btn-primary') !!}
                      <a class="btn btn-default" href="{!! route('backend.agencias.resumen') !!}">Cancelar</a>
                      {!! BootForm::close() !!}
                    </div>
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