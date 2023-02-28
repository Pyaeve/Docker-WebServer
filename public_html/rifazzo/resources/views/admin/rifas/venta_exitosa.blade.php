@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
           <div class="col-md-12">
               {!! Breadcrumbs::render('RifasVendida'); !!}
            </div<!-- /.col -->
        </div><!-- /.row -->
        </div><!-- /.row -->
        </div> <!-- /.container-fluid -->
         </div> <!-- /.content-header -->
        <!-- Main content -->
        <section  class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Rifa Nro {!! $node->RIFA_NRO !!} vendida con exito!! </h3>
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
                             
                                  <div id="ticket" class="col-md-12 col-sm-12" align="center">
                                        <!-- row -->
                                      <div class="row">
                                        <img class='logo_impresion' src="{!! asset('images/android-icon-144x144.png') !!}">
                                    @foreach($data as $node)
                                        <div  class="col-md-6 col-sm-4">
                                            <p>    <b>Rifa Nro:</b> {!! $node->RIFA_NRO !!}</p>
                                            <p>  <b>Jugada Nro:</b> {!! $node->JUGADA_ID !!}</p>
                                            <p><b>Fecha Sorteo:</b> {!! $node->JUGADA_FECHA !!}</p>
                                            <p>     <b>Agencia:</b> {!! $node->AGENCIA !!}</p>
                                            <p>    <b>Vendedor:</b> {!! $node->VENDEDOR !!}</p>
                                            <p>  <b>Modadlidad:</b> {!! $node->MODALIDAD !!}</p>
                                            <p>      <b>Precio:</b> {!! $node->RIFA_PRECIO !!}</p>
                                            <p>    <b>Premio 1:</b> {!! $node->RIFA_PREMIO_1 !!}</p>
                                            <p>    <b>Premio 2:</b> {!! $node->RIFA_PREMIO_2 !!}</p>
                                            <p>    <b>Premio 3:</b> {!! $node->RIFA_PREMIO_3 !!}</p>
                                        </div>
                                        
                                        
                                    
                                    
                                   
                                        
                                      
                                      
                                   
                                     @endforeach  
                                    </div>
                                    <!-- ./row -->
                                  </div>
                             
                         

                            </div>
                        </div>     
                    </div>
            </div>
        </div> 
    </section>
<!-- /.Main content -->
@endsection
