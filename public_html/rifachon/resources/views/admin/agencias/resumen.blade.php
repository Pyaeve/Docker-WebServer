@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
               {!! Breadcrumbs::render('AgenciasResumen'); !!}
            </div<!-- /.col -->
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
                                <h3 class="card-title">Resumen de Zonas</h3>
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
                                            <th scope="col">Agencia</th>
                                            <th scope="col">RUC</th>
                                            <th scope="col">Contacto</th>
                                            <th scope="col">Agente</th>
                                            <th scope="col">Zona</th>
                                            <th scope="col">Ciudad</th>
                                            <th scope="col">Domicilio</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $node)
                                        <tr>
                                        
                                            <td>
                                                <a href="{!! route('backend.agencias.editar',['id'=>$node->ID ]) !!}" class="btn btn-tool"><i class="fa fa-edit"></i></a>
                                                <a href="#" class="btn btn-tool"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td>{!! $node->ID !!}</td>
                                            <td>{!! $node->AGENCIA !!}</td>
                                            <td>{!! $node->RUC !!}</td> 
                                            <td>{!! $node->CONTACTO !!}</td> 
                                            <td>{!! $node->AGENTE !!}</td>
                                            <td>{!! $node->ZONA !!}</td>
                                            <td>{!! $node->CIUDAD !!}</td>
                                            <td>{!! $node->DIRECCION !!}</td>
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