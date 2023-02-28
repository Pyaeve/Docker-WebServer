@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
         
            <div class="col-md-12">
               {!! Breadcrumbs::render('Jugadas'); !!}
            </div><!-- /.col -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <!-- card  -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informes de Ventas por Vendedor</h3>
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
                                    
                                         {!! BootForm::open(
)->get()->action(route('backend.informes.vendedores')) !!}
                                  
  {!! BootForm::hidden('a')->value($agencia) !!}
                               {!! BootForm::date('Desde','f1')->value($desde) !!}
                               {!! BootForm::submit('Filtrar')->addClass('btn btn-success') !!}
                           </div><div class="col-md-6">
                                  
                                    {!! BootForm::date('Hasta','f2')->value($hasta) !!}
                               <a href="{!! route('home') !!}" class="btn btn-primary">Cancelar</a>
  {!! BootForm::close() !!}
                                
                                  </div>
                                    </div>

                               <div class="row">
                                    <div id="gpx-informes-vendedor" class="col-md-12">
                                           <script type="text/javascript">
                                        function LoadReady(event, chart){
    $('#gpx-informes-vendedor').innerHTML ='<img src="' + chart.getImageURI() + '">'
   } 
                                    </script>
                                     <?=$chart->render('BarChart', 'InformeVendedores', 'gpx-informes-vendedor'); ?>
                                
                                    </div>
                               </div>  
                            </div>
                        </div>
                        <!-- /card -->  <!-- card  -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Informes de Ventas por Vendedor</h3>
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
                                    <div class="col-md-12">
                                         <table class="table table-responsive table-striped table-dt">
                                    <thead class="table-dark">
                                        <tr>
                                           <th scope="col">Vendedor</th>
                                            <th scope="col">Venta Fecha</th>
                                            <th scope="col">Venta Hora</th>
                                            <th scope="col">Jugada Nro</th>
                                            <th scope="col">Rifas Vendidas</th>
                                            <th scope="col">Recaudacion</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Comision</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $node)
                                        <tr>
                                            <td>{!! $node->VENDEDOR !!}</td>
                                            <td>{!! $node->VENTA_FECHA !!}</td>
                                            <td>{!! $node->VENTA_HORA !!}</td>
                                            <td>{!! $node->JUGADA_ID !!}</td> 
                                            <td>{!! $node->RIFAS_TOTAL !!}</td>
                                            <td>{!! number_format($node->RECAUDACION_TOTAL, 0,',', '.') !!}</td>
                                            <td>{!! number_format($node->IMPORTE_TOTAL, 0,',', '.'); !!}</td>
                                            <td>{!! number_format($node->COMISION_TOTAL, 0,',', '.') !!}</td>
                                      </tr>
                                       
                                        @endforeach
                                    </tbody>
                                </table>
                                    </div>    
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