@extends('layouts.bs3.app')
@section('content')
<div class="container">
	 <div class="row justify-content-center">
        <div class="col-md-12">
        		
        </div>
    </div>
      <div class="row justify-content-center">
        <div class="col-md-12">

        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3><i class="fa fa-user"></i> Perfil</h3> </div>

                <div class="card-body ">
                    <div class="container">
                        <div class="rowr">
                            <div class="col-md-12">
                                <div class="row">
                                     <div class="col-md-2">
                                        <img width="150px" src="{!! asset('images/default-profile.png') !!}" class="rounded-circle img-responsive "/>
                                </div>
                                 <div class="col-md-10">
                                    <br>
                                    <h3>{!!  $data->name !!} {!!  $data->sername !!}</h3>
                                    <p><i class="fa fa-envelope"></i> {!!  $data->email !!}</p>
                                    <p> <a href="#" class="btn btn-primary"><i class="fa fa-pencil"></i> Editar</a></p>
                                 </div>
                                </div>
                                
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="modal-confirm-drop" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pyaeve.com</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Desea borrar este Contribuyente?</p>
        <input class="modal-data" type="hidden" name="cid" value="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-drop btn btn-primary">Borrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

@endsection
@section('scripts')

     $('.table').DataTable( {
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        }
    } );


    $('.btn-drop').click(function(){
        

        var v= $("#modal-confirm-drop .modal-data").val();
        
                var url='{!! env('APP_URL') !!}/admin/contribuyentes/ajax/borrar/'+v;
        $.ajax({
            url: url,
            success: function(res) {
                
               alert(res);
             },
            error: function() {
                alert("No se ha podido obtener la información");
            }
        });
       
    });

    $('.btn-action-drop').click(function(){

        var btn =$(this);
        $("#modal-confirm-drop .modal-data").val(btn.data('id'));
        $("#modal-confirm-drop").modal('show');
    });
@endsection
