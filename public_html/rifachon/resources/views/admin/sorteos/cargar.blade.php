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
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                       <!-- carrd -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Cargar Sorteos </h3>
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
                                <div class="col-md-10 offset-md-1">
                                     {!! BootForm::open()->action(route('backend.sorteos.guardar')) !!}
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><b>Jugada Nro:</b> {!! $jugada_id !!}</p>

                                        </div>
                                        <div class="col-md-6">
                                            <p><b>Fecha Sorteo:</b> {!! $jugada_fecha !!}</p> 
                                        </div>
                                    </div>
                                    <div class="row">   
                                   {!! BootForm::hidden('jugada_id')->value($jugada_id) !!}
                                   {!! BootForm::hidden('jugada_fecha')->value($jugada_fecha) !!}
                                        {!! BootForm::hidden('agencia_id')->value($agencia_id) !!}
                                        <div class="col-md-4">
                                           
                                                {!! BootForm::text('Sorteo 1', 'sorteo_1')->attr('required')->maxlength(4)->minlength(4)->addClass('sorteo_1') !!}
                                            
                                        </div> 
                                        <div class="col-md-4">
                                           
                                                {!! BootForm::text('Sorteo 2', 'sorteo_2')->attr('required')->maxlength(4)->minlength(4)->required()->addClass('sorteo_2') !!}
                                           
                                        </div>  
                                        <div class="col-md-4">
                                            
                                                {!! BootForm::text('Sorteo 3', 'sorteo_3')->attr('required')->maxlength(4)->minlength(4)->required()->addClass('sorteo_3') !!}
                                            
                                        </div>   
                                      
                                    </div>
                                    {!! BootForm::submit('Cargar')->addClass('btn btn-primary') !!}
                                      <a class="btn btn-default" href="{!! route('backend.jugadas.resumen') !!}">Cancelar
                                    {!! BootForm::close() !!}
                                    
                                </div>   
                            </div>
    
                        </div>
                        <!-- /card -->
                    </div>
                </div>
            </div>     
        </section>
<!-- /.Main content -->
@endsection
@section('scripts')

@endsection