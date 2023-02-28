@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-3">
                <h1 class="m-0">Rifazzo</h1>
            </div><!-- /.col -->
            <div class="col-sm-9">
                <ol class="breadcrumb float-sm-left">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Zonas</a></li>
                    <li class="breadcrumb-item active">Resumen</li>
                </ol>
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
                                <h3 class="card-title">Resumen de Rifas Vendidas</h3>
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
                             <div id="VentasDiariasDIV">                   
                             </div>
                             
                             <?= $chart->render('ColumnChart', 'VentasDiarias', 'VentasDiariasDIV'); ?>
                             
 

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