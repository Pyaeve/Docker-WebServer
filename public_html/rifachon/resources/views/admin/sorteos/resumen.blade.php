@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
       <div class="row mb-2">
           <div class="col-md-12">
               {!! Breadcrumbs::render('SorteosResumen'); !!}
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Resumen de Sorteos</h3>
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
                                  <div class="row">
                                    <div class="col-md-6">
                                    <?php $now = date('Y-m-d'); ?>
                                         {!! BootForm::open(
)->get()->action(route('backend.sorteos.resumen')) !!}
                                  
  {!! BootForm::hidden('a')->value($agencia_id) !!}
                               {!! BootForm::date('Desde','f1')->value($desde)->required() !!}
                               {!! BootForm::submit('Filtrar')->addClass('btn btn-success') !!}
                           </div><div class="col-md-6">
                                  
                                    {!! BootForm::date('Hasta','f2')->value($hasta)->required() !!}
                               <a href="{!! route('home') !!}" class="btn btn-primary">Cancelar</a>
  {!! BootForm::close() !!}
                                
                                  </div>
                                    </div>
                                <table class="table tb-dt">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nro Jugada</th>
                                            <th scope="col">Fecha Sorteo</th>
                                            <th scope="col">Hora Sorteo</th>
                                            <th scope="col">Nro Sorteo</th>
                                            <th scope="col">Nro Ganador</th>
                                          <th scope="col">Nro Premio</th>
                                          <th scope="col">Premio</th>
                                        

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $node)
                                        <tr>
                                          
                                            <td>{!! $node->JUGADA_ID !!}</td>
                                            <td>{!! $node->SORTEO_FECHA !!}</td>
                                            <td>{!! $node->SORTEO_HORA !!}</td>
                                            <td>{!! $node->SORTEO_ID !!}</td> 
                                            <td>{!! $node->RIFA_NRO !!}</td>
                                            <td>{!! $node->PREMIO_NRO !!}</td>
                                             <td align="right">{!! number_format($node->PREMIO, 0,',', '.') !!}</td>
                                         
                                        </tr>
                                       
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>   
                          
                    </div>
            </div>
        </div> 
    </section>
<!-- /.Main content -->
@endsection
@section('scripts')

@endsection