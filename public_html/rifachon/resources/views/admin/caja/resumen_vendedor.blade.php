@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
         
            <div class="col-md-12">
                {!! Breadcrumbs::render('CajaVendedorResumen'); !!}
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
                                <h3 class="card-title">Resumen de Caja</h3>
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
                                        {!! BootForm::openHorizontal(['lg'=>[2,10]])->get()->action(route('backend.caja.resumen.vendedor')) !!}
  {!! BootForm::hidden('v')->value($vendedor) !!}
                               {!! BootForm::date('Fecha','f')->value($fecha) !!}
                               {!! BootForm::submit('Filtrar')->addClass('btn btn-success') !!}
{!! BootForm::close() !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Rifas Vendidas</th>
                                            <th scope="col">Importe Total</th>
                                            <th scope="col">Recuadacion Total</th>
                                            <th scope="col">Comision Total</th>
                                           
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($caja as $node)
                                        <tr>
                                           
                                            <td>{!! $node->FECHA !!}</td>
                                           <td>{!! number_format($node->RIFAS_TOTAL, 0,',', '.'); !!}</td>
                                           
                                            <td>{!! number_format($node->IMPORTE_TOTAL, 0,',', '.'); !!}</td>
                                         <td>{!! number_format($node->RECAUDACION_TOTAL, 0,',', '.') !!}</td>
                                           <td>{!! number_format($node->COMISION_TOTAL, 0,',', '.') !!}</td>
                                        </tr>
                                       
                                        @endforeach
                                    </tbody>
                                </table>
                                    </div>
                                
                                </div>
                                <div class="row" 
                                >
                                    <div class="col-md-12" id="gpx-caja-vendedor"></div>
                                    <script type="text/javascript">
                                        function LoadReady(event, chart){
    $('#gpx-caja-vendedor').innerHTML ='<img src="' + chart.getImageURI() + '">'
   } 
                                    </script>
                                     <?=$chart->render('ColumnChart', 'CajaVendedor', 'gpx-caja-vendedor'); ?>
                                </div>
                                <table class="table">
                                    <thead class="table-dark">
                                        <tr>
                                            
                                            <th scope="col">Nro Jugada</th>
                                            <th scope="col">Fecha Jugada</th>
                                        
                                            <th scope="col">Rifas Nro</th>
                                            <th scope="col">Rifas Token</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Comision</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        @foreach($data as $node)
                                        <tr>
                                           
                                            <td>{!! $node->JUGADA_ID !!}</td>
                                            <td>{!! $node->JUGADA_FECHA !!}</td>
                                            <td>{!! $node->RIFA_NRO !!}</td>
                                            <td>{!! $node->RIFA_TOKEN !!}</td>
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
        </div> 
    </section>
     
<!-- /.Main content -->
@endsection
@section('scripts')
 $('.table').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "pageLength": 50,
    } );


@endsection