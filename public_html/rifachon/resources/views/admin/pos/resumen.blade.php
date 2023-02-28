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
                                <h3 class="card-title">Resumen de POS</h3>
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
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">ID</th>
                                            <th scope="col">IMEI</th>
                                            <th scope="col">SERIAL</th>
                                            <th scope="col">SIM</th>
                                         

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $node)
                                        <tr>
                                            <td>
                                                <a href="{!! route('backend.jugadas.editar',['id'=>$node->ID]) !!}" class="btn btn-tool"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-tool"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td>{!! $node->ID !!}</td>
                                            <td>{!! $node->IMEI !!}</td>
                                            <td>{!! $node->SERIAL !!}</td>
                                            <td>{!! $node->SIM !!}</td> 
                                         
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