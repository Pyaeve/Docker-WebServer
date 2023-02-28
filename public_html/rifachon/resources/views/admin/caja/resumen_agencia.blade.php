@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
         
            <div class="col-md-12">
               {!! Breadcrumbs::render('CajaAgenciaResumen'); !!}
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
                                    <div class="col-md-6">
                                    <?php $now = date('Y-m-d'); ?>
                                         {!! BootForm::open(
)->get()->action(route('backend.caja.resumen.agencia')) !!}
                                  
  {!! BootForm::hidden('a')->value($agencia) !!}
                               {!! BootForm::date('Desde','f1')->value($desde)->value($now)->required() !!}
                               {!! BootForm::submit('Filtrar')->addClass('btn btn-success') !!}
                           </div><div class="col-md-6">
                                  
                                    {!! BootForm::date('Hasta','f2')->value($hasta)->value($now)->required() !!}
                               <a href="{!! route('home') !!}" class="btn btn-primary">Cancelar</a>
  {!! BootForm::close() !!}
                                
                                  </div>
                                    </div>
                                
                                <div class="row">
                                    <div class="col-md-12">

                                        <table class="table table-responsive table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Jugada Nro</th>
                                            <th scope="col">Rifas Vendidas</th>
                                            <th scope="col">Importe Total</th>
                                            <th scope="col">Recaudaci&oacute;n Total</th>
                                            <th scope="col">Comision Total</th>
                                           
                                            
    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($caja as $node)
                                        <tr>
                                           
                                            <td>{!! $node->FECHA !!}</td>
                                            <td>{!! $node->JUGADA_ID !!}</td>
                                          <!--  <td></td> -->
                                           <td align="right">{!! number_format($node->RIFAS_TOTAL, 0,',', '.'); !!}</td>
                                           
                                            <td align="right">{!! number_format($node->IMPORTE_TOTAL, 0,',', '.'); !!}</td>
                                         <td align="right">{!! number_format($node->RECAUDACION_TOTAL, 0,',', '.') !!}</td>
                                           <td align="right">{!! number_format($node->COMISION_TOTAL, 0,',', '.') !!}</td>
                                        </tr>
                                       
                                        @endforeach
                                    </tbody>
                                </table>
                                    </div>
                                
                                </div>
                                <div class="row">
                                    <div class="col-md-12" id="gpx-caja-agencia"></div>
                                    <script type="text/javascript">
                                        function LoadReady(event, chart){
    $('#gpx-caja-agencia').innerHTML ='<img src="' + chart.getImageURI() + '">'
   } 
                                    </script>
                                     <?=$chart->render('ColumnChart', 'CajaAgencia', 'gpx-caja-agencia'); ?>
                                      <table class="table tb-dt table-responsive table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">
                                                Fecha Venta
                                            </th>
                                            <th scope="col">
                                                Hora Venta
                                            </th>
                                            <th scope="col">Rifas Nro</th>
                                            <th scope="col">Rifas Token</th>
                                            <th scope="col">Nro Jugada</th>
                                            <th scope="col">Fecha Jugada</th>
                                            <th scope="col">Vendedor</th>
                                            <th scope="col">Importe</th>
                                            <th scope="col">Comision</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        @foreach($data as $node)
                                        <tr>
                                           <td>{!! $node->VENTA_FECHA !!}</td>
                                            
                                            <td>{!! $node->VENTA_HORA !!}</td>
                                             <td>{!! $node->RIFA_NRO !!}</td>
                                            <td>{!! $node->RIFA_TOKEN !!}</td>
                                            <td>{!! $node->JUGADA_ID !!}</td>
                                            <td>{!! $node->JUGADA_FECHA !!}</td>
                                            <td>{!! $node->VENDEDOR !!}</td>
                                           
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
        </div> 
    </section>
    
<!-- /.Main content -->
@endsection
@section('scripts')
 $('.tb-dt').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "pageLength": 50,
        "order": [[ 0, "desc" ]]
    } );


@endsection