@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-md-12">
               {!! Breadcrumbs::render('RifasVender'); !!}
            </div<!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section id="ticket" class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Vender Rifa </h3>
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
                                {!! BootForm::open()->action( route('backend.rifas.vender') )->post() !!}
                              
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                              {!! BootForm::hidden('vendedor_id')->value($vendedor_id)->addClass('vendedor_id') !!}
                                {!! BootForm::hidden('agencia_id')->value($agencia_id) !!}
                                {!! BootForm::hidden('jugada_id')->value($jugada_id)->addClass('jugada_id_h') !!}
                                {!! BootForm::hidden('jugada_fecha')->value($jugada_fecha)->addClass('jugada_fecha_h') !!}
                                {!! BootForm::hidden('zona_id')->value($zona_id) !!}
                                {!! BootForm::hidden('ciudad_id')->value($ciudad_id) !!}
                                           {!! BootForm::text('Agencia','a')->value($agencia_nombre)->disabled() !!}
                                        </div>
                                        <div class="col-md-6">
                                           {!! BootForm::select('Modalidad','modalidad_id')->options($modalidades)->addClass('modalidad') !!}
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                             {!! BootForm::text('Fecha Sorteo','fj')->value($jugada_fecha)->disabled()->addClass('jugada_fecha') !!}
                                        </div>
                                        <div class="col-md-6">
                                                {!! BootForm::text('Nro Jugada','nj')->value($jugada_id)->disabled()->addClass('jugada_id') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                             {!! BootForm::text('Premio 1','jugada_premio_1')->value($jugada_premio1)->disabled()->addClass('jugada_premio_1') !!}
                                        </div>
                                        <div class="col-md-4">
                                               {!! BootForm::text('Premio 2','jugada_premio_2')->value($jugada_premio2)->disabled()->addClass('jugada_premio_2') !!}
                                        </div>
                                        <div class="col-md-4">
                                              {!! BootForm::text('Premio 3','jugada_premio_3')->value($jugada_premio3)->disabled()->addClass('jugada_premio_3') !!}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                             {!! BootForm::text('Precio','jugada_precio')->value($jugada_precio)->disabled()->addClass('jugada_precio') !!}
                                        </div>
                                        <div class="col-md-6">
                                                {!! BootForm::text('Rifa Nro','rifa_nro')->addClass('rifa_nro') !!}
                                        </div>
                                    </div>

                                    
                      
                        
                         
                        
                      
                            
                             
                              
                                
                        
 {!! BootForm::submit('Vender')->addClass('btn btn-primary')->removeClass('btn-default')!!} 
                            <a class="btn btn-primary generar-rifa" href="#">Generar Nro Rifa</a>     
                                 
 
                                </div>
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
         $('.generar-rifa').click(function(){
        
       var a = {!! $agencia_id !!};
       var v= $('.vendedor_id').val();
       var m= $('.modalidad').val();
        
                var url='{!! env('APP_URL') !!}/api/rifas/generar/'+v+'/'+m+'/'+a;
        $.ajax({
            url: url,
            success: function(res) {
                
               //alert(res);
               $.each(res, function (k, j) {
                 $('.rifa_nro').val(j.NRO);
                  
                });
             },
            error: function() {
                alert("No se ha podido obtener la información");
            }
        });
       
    });
    $('.generar-rifa').trigger('click');

    $('.modalidad').change(function(){
      
          var v= this.value;
           // alert(v);
         var url='{!! env('APP_URL') !!}/backend/jugadas/modalidad/'+v;
        $.ajax({
            url: url,
            success: function(res) {
                
               //alert(res);
               $.each(res, function (k, j) {
                     $('.jugada_id').val(j.JUGADA_ID);
                     $('.jugada_fecha').val(j.JUGADA_FECHA);
                     $('.jugada_id_h').val(j.JUGADA_ID);
                     $('.jugada_fecha_h').val(j.JUGADA_FECHA);
                });
             },
            error: function() {
                alert("No se ha podido obtener la información");
            }
        });
    });

@endsection