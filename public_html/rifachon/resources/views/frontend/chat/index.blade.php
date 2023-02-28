@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
                {!! Breadcrumbs::render('Home') !!}
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div> <!-- /.container-fluid -->
    </div> <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-outline">
              <div class="card-header ">
               <h4 class="card-title">Ventas</h4>
             
              </div>
              <div class="card-body">
                
                <!-- /.d-flex -->
                <div class="col-md-12">
                    <div id="gpx-ventas7dias-agencia" ></div>
                </div>
             <script type="text/javascript">
                                        function LoadReady(event, chart){
    $('#gpx-ventas7dias-agencia').innerHTML ='<img src="' + chart.getImageURI() + '">'
   } 
                                    </script>
                                     <?=$Ventas7DiasAgencia->render('ColumnChart', 'Ventas7DiasAgencia', 'gpx-ventas7dias-agencia'); ?>

              
            </div>
                </div>
                
            </div>
            <div class="row">
                @role('Developer')
                <div class="col-md-4">
                    <!-- info-box -->
                    <div class="info-box">
                         <span class="info-box-icon bg-info"><i class="fa fa-house-user"></i></span>
                         <div class="info-box-content">
                            <span class="info-box-text">Agencias</span>
                            <span class="info-box-number">{!! $agencias !!}</span>
                            <a href="{!! route('backend.agencias.resumen') !!}" class="info-box-footer">Ver Resumen</a>
                        </div>  
                    </div>
                    <!-- /.info-box -->   
                </div>
                <div class="col-md-4">
                    <!-- info-box -->
                    <div class="info-box">
                         <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                         <div class="info-box-content">
                            <span class="info-box-text">Vendedores</span>
                            <span class="info-box-number">{!! $vendedores !!}</span>
                                <a href="{!! route('backend.vendedores.resumen') !!}" class="info-box-footer">Ver Resumen</a>
                        </div>
                    </div>
                    <!-- /.info-box -->   
                    </div>
                    @else
                        @role('Agente')
                        <div class="col-md-4">
                            <!-- info-box -->
                            <div class="info-box">
                                 <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Vendedores</span>
                                     <span class="info-box-number">{!! $vendedores !!}</span>
                                    <a href="{!! route('backend.vendedores.resumen') !!}" class="info-box-footer">Ver Resumen</a>

                                </div>
                            </div>
                            <!-- /.info-box -->   
                        </div>
                        <div class="col-md-4">
                            <!-- info-box -->
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Rifas</span>
                                    <span class="info-box-number">{!! $rifas !!}</span>
                                    <a href="{!! route('backend.vendedores.resumen') !!}" class="info-box-footer">Ver Resumen</a>
                                </div>
                            </div>
                        <!-- /.info-box -->   
                        </div>
                        <div class="col-md-4">
                            <!-- info-box -->
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fa fa-users"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Jugadas</span>
                                    <span class="info-box-number">{!! $jugadas !!}</span>
                                    <a href="{!! route('backend.jugadas.resumen') !!}" class="info-box-footer">Ver Resumen</a>
                                </div>
                            </div>
                        <!-- /.info-box -->   
                        </div>
                        @endrole
                    @endrole
                </div>

            </div> 
        </section>
    <!-- /.Main content -->
@endsection