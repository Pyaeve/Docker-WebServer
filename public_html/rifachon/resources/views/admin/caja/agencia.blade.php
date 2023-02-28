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
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Ver Resumen de Caja</h3>
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
                                <?php $now = date('Y-m-d'); ?>
                               {!! BootForm::open()->get()->action(route('backend.caja.resumen.agencia')) !!}
                               {!! BootForm::hidden('a')->value($agencia) !!}
                               {!! BootForm::date('Desde','f1')->value($now)->required() !!}
                               {!! BootForm::date('Hasta','f2')->value($now)->required() !!}
                               {!! BootForm::submit('Filtrar')->addClass('btn btn-success') !!}
                               {!! BootForm::close() !!}
                            </div>
                        </div>     
                    </div>
            </div>
        </div> 
    </section>
<!-- /.Main content -->
@endsection