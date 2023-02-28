@extends('layouts.bs3.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-md-12">
            {!!  Breadcrumbs::render('VendedoresResumen')!!}
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
                                <h3 class="card-title">Listado de Vendedores</h3>
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
                                <table class="table table-responsive table-striped table-hover tb-dt">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col"></th>
                                            <th scope="col">ID</th>
                                            <th scope="col">Agencia</th>
                                            <th scope="col">Vendedor</th>
                                            <th scope="col">POS</th>
                                            <th scope="col">Contacto</th>
                                            <th scope="col">Zona</th>
                                            <th scope="col">Ciudad</th>
                                            <th scope="col">Domicilio</th>

                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $node)
                                        <tr>
                                            <td>
                                                <a href="{!! route('backend.vendedores.editar',['id'=>$node->ID]) !!}" class="btn btn-tool"><i class="fa fa-edit"></i></a>
                                                <a href="#" data-vendedor="{!! $node->ID !!}" class="btn-borrar-vendedor btn btn-tool"><i class="fa fa-trash"></i></a>
                                            </td>
                                            <td>{!! $node->ID !!}</td>
                                            <td>{!! $node->AGENCIA !!}</td>
                                            <td>{!! $node->VENDEDOR !!}</td> 
                                             <td>{!! $node->POS_ID !!}</td> 
                                            <td>{!! $node->CONTACTO !!}</td> 
                                          
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
<!-- Modal -->
<div class="modal fade" id="ModalBorrarVendedor" tabindex="-1" role="dialog" aria-labelledby="ModalBorrarVendedorLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ModalBorrarVendedorLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-action-yes" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>
<!-- /.Main content -->
@endsection
@section('scripts')
    $('.btn-borrar-vendedor').click(function(e){
        var vendedor = $(this).data('vendedor');
        alert('Vendedor ID: ' +vendedor);
        $('#ModalBorrarVendedor .modal-body').html('Deseas Eliminar al Vendedor '+vendedor+'?');
        $('#ModalBorrarVendedor').modal('show');

                $('.btn-action-yes').click(function(){
                    alert('se borra el Vendedor '+vendedor);
                });

    });

     $('.tb-dt').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
        "pageLength": 50,
    } );
@endsection