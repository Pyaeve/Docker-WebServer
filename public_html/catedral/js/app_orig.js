$(document).ready(function(){

        $('#btn_reg').click(function(event) {
                    $('#registroform').validate({
                        messages: {
                            cliente_nombre: "Debe completar el campo nombre.",
                            cliente_apellido: "Debe completar el campo apellido.",
                            cliente_email: "Debe completar el campo E-mail.",
                            cliente_clave: "Debe completar el campo Contraseña"
                        },
                        submitHandler: function(form){
                          $.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });   
                          $('.error').html('');
                          $.ajax({
                            url : 'ajax/registro',
                            data: $('#registroform').serialize(),
                            type : 'post',
                            dataType : 'json',
                            success : function(data){
                                if(data.status=="success"){
                                  if(data.type != "update"){
                                      $("input").not(":submit").val("");
                                      $("textarea").val("");
                                      
                                      setTimeout(function(){ location.reload(); }, 2000);
                                      $("#result").html('<div class="alert alert-success">Su solicitud de registro se ha realizado correctamente</div>');
                                  }else{
                                    //swal("¡Actualización!", "Actualización correcta de sus datos", "success");
                                    $("#result").html('<div class="alert alert-success">Actualización correcta de sus datos</div>');
                                  }
                                 
                                }else{
                                  if(data.description === 'autenticacion'){
                                    //swal("¡Error!", data.description, "warning");
                                    $("#result").html('<div class="alert alert-danger">'+data.description+'</div>');
                                  }else{
                                    $("#"+data.type).focus();
                                    //swal("¡Error!", data.description, "warning"); 
                                    $("#result").html('<div class="alert alert-danger">'+data.description+'</div>');
                                  }
                                }
                                $.unblockUI();
                            }
                          });
                          return false;
                        }
                    });
        });


    $('#btn_login').click(function(){
      $.ajax({
          url : 'ajax/login',
          data: $('#loginForm').serialize(),
          type : 'post',
          dataType : 'json',
          success : function(data){
            console.log(data);
           if(data.status=="success"){
           
               window.location.href = "ajax/carrito_session.php";
        
           }else{
              $("#"+data.type).focus();
               swal("¡Error!", data.description, "warning");
            }
          }
      });
      return false;
    });

  $('#btn_recuperar').click(function(){
      $.ajax({
          url : 'ajax/registro',
          data: $('#recuperar').serialize(),
          type : 'post',
          dataType : 'json',
          success : function(data){
            if(data.status == "success"){
              $('input[name="email"]').val('');
              //swal("Restablecer contraseña", data.description , "success");
                  $(".respuesta").html(data.description);
                  setTimeout(function() {
                    swal({
                        title: "Restablecer contraseña!",
                        text: data.description,
                        type: "success"
                    }, function() {
                        location.reload();
                    });
                }, 1000);
              
            }else{
              swal("¡Atención!", data.description , "warning");
            }
          }
      });
      return false;
  });

  $('#btn_cambio').click(function(){
      $.ajax({
          url : 'ajax/registro',
          data: $('#cambioform').serialize(),
          type : 'post',
          dataType : 'json',
          success : function(data){
            if(data.status == "success"){
              $('input[name="email"]').val('');
              $(".formoid").html(data.description);
            }else{
              swal("¡Atención!", data.description , "warning");
            }
          }
      });
      return false;
  });

  $('#btn_sendCv').click(function(){
      $('.error').html('');
      var form =  document.getElementById('form-job');
      $.ajax({
        url : 'ajax/curriculum',
        data : new FormData(form),
        type : 'post',
        dataType : 'json',
        processData: false,
        contentType: false,
        success : function(data){
          if(data.status=="success"){
            $("input").not(":submit").val("");
            $("textarea").val("");
            //swal("Enviado!", "Curriculum enviado", "success");
            setTimeout(function() {
                swal({
                    title: "Enviado!",
                    text: "Curriculum enviado!",
                    type: "success"
                }, function() {
                    location.reload();
                });
            }, 1000);

          }else{
            $("#"+data.type).focus();
            $("#"+data.type+"-error").html(data.description);
            swal("Atención!", data.description, "warning");

          }
        }
      });
      return false;
  });

  $('#btn_sendContact').click(function(){
      $.ajax({
          url : 'ajax/contactos',
          data: $('#form-contact').serialize(),
          type : 'post',
          dataType : 'json',
          success : function(data){
            if(data.status=="success"){
              $("input").not(":submit").val("");
              $("textarea").val("");
              swal({
                  title: "¡Mensaje enviado!",
                  text: "Su mensaje se ha enviado con exito",
                  type: "success"
              }, function() {
                  location.reload();
              });


            }else{
              $("#"+data.type).focus();
              swal({
                  title: "¡Atención!",
                  text: data.description,
                  type: "warning"
              });
            }
          }
      });
      return false;
  });

  $('#btn_suscribe').click(function(){
      $.ajax({
          url : 'ajax/suscripcion',
          data: $('#form-suscribe').serialize(),
          type : 'post',
          dataType : 'json',
          success : function(data){
            console.log(data);
            if(data.status=="success"){
              $("input").not(":submit").val("");
              swal({
                  title: "Suscripcion realizada!",
                  //text: "Se ha suscripto correctamente",
                  type: "success"
              });
            }else{
              $("#"+data.type).focus();
              swal({
                  title: "¡Atención!",
                  text: data.description,
                  type: "warning"
              });
            }
          }
      });
      return false;
  });

  $('#btn_directions').click(function(){
      $('.error').html();
      $.ajax({
          url : 'ajax/direccion',
          data: $('#direccionform').serialize(),
          type : 'post',
          dataType : 'json',
          success : function(data){
              console.log(data);
            if(data.status=="success"){
                $("input").not(":submit").val("");
                $("textarea").val("");
                setTimeout(function() {
                    swal({
                        title: "Enviado!",
                        text: "Datos guardados!",
                        type: "success"
                    }, function() {
                        //location.reload();
                        location.href = 'checkout.php';
                    });
                }, 1000);
            }else{
              $("#"+data.type).focus();
              $("#"+data.type+"-error").addClass('error');
              $("#"+data.type+"-error").html(data.description);
            }
          }
      });
      return false;
  });
  //Carrito
  $('.item_add').click(function(){
          var producto_id = $(this).attr('rel');
          var cantidad = '1';
          //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
          $.ajax({
            url:'ajax/carrito',
            dataType:'json',
            type:'post',
            data:"accion=agregar&producto_id="+producto_id+"&cantidad="+cantidad,
            success: function(response){
              if(response.status=="success"){
                 var bgColors = [
                    "background-color(#51a351)",
                 ], 
                 i = 0;
                 Toastify({
                    text: "Producto agregado al carrito",
                    duration: 3000,
                    close: i % 3 ? true : false,
                    backgroundColor: bgColors[i % 2],
                  }).showToast();
                 i++;

                $('.itemCartTotal').html(response.items);

              }else{
                swal("¡Atención!", response.description , "warning");
              }
            }
          });
  });
  //Repite
  $('.repite-pedido').click(function(){
      var id = $(this).attr('rel');
      //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
      
      $.ajax({
            url:'ajax/carrito',
            dataType:'json',
            type:'post',
            data:"accion=repite&id="+id,
            success: function(data){
              //console.log(data);
              if(data.status=="success"){
                 window.location.href = 'mi-carrito.php';
                //$('.itemCartTotal').html(response.items);
              }else{
                swal("¡Atención!", data.description , "warning");
              }
            }
      });
  });

  $('.eliminar').on('click',function(){
      //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
      var token = $(this).attr('rel');
      $.ajax({
        url:'ajax/carrito',
        type: 'POST',
        dataType: 'json',
        data:'accion=eliminar&token='+encodeURIComponent(token),
        success: function(response){
          if(response.status == 'success'){
            location.href = 'mi-carrito.php';
          }else{
            swal("Error", response.description, "warning");

          }
        }
      });
  });

  $('.deletecarrito').on('click',function(){
      //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
      $.ajax({
        url:'ajax/carrito',
        dataType:'json',
        type:'post',
        data:"accion=vaciar",
        success: function(response){
          if(response.status=="success"){
            location.href='mi-carrito.php';
          }else{
            swal("Error", response.description, "warning");
          }
        }
      });
  });

  //Validacion de Opcione de Entrega
  $('.ficha').click(function(){
      var opcion = $(this).attr('id');
      if(opcion == "tipo2"){
        $('input[name="tipo"]').val('2');
      }else if (opcion == "tipo3"){
        $('input[name="tipo"]').val('3');
      }else{
        $('input[name="tipo"]').val('1');
      }
  });
  //Al seleccionar una sucursal carga el campo sucursal
  $("select[name=contraentrega_local]").change(function(){
        $('input[name=sucursal]').val($(this).val());
  });

  $('#btn_Nc').click(function(){
    $.ajax({
        type: "POST",
        url: "ajax/registro",
        data: $("#nombraCarrito").serialize(),
        dataType: "json",
        success: function(data){
          if(data.status == "success"){
             var bgColors = [
              "background-color(#51a351)",
            ], 
            i = 0;
            Toastify({
              text: "Carrito Guardado",
              duration: 3000,
              close: i % 3 ? true : false,
              backgroundColor: bgColors[i % 2],
            }).showToast();
            i++;
          }else{
            swal("Atención", data.description, "warning");
          }

        }
    });
  });
  
  $('#checkout').click(function(){
    $.ajax({
            type: "POST",
            url: "ajax/registro",
            data:   {'accion':'iniciosesion'},
            dataType: "json",
            success: function(data) {
              if(data.status == "success"){
                location.href='checkout.php'; 
              }else{
                swal("Atención", data.description, "warning");
              }
            }
      });
  });
  
  $('#busca').on('input', function() {
      var busca = $(this).val();   
      $.ajax({
            type: "POST",
            url: "ajax/busca",
            data:   {'busca':busca},
            dataType: "json",
            success: function(data) {
              if(data.status == "success"){
                $('.search-result').css("display", "block");
                $('#results').html(data.html);
              }
            }
      });
  });
  
  $('#buscaM').on('input', function() {
      var busca = $(this).val();   
      $.ajax({
            type: "POST",
            url: "ajax/busca",
            data:   {'busca':busca},
            dataType: "json",
            success: function(data) {
              if(data.status == "success"){
                $('.search-result').css("display", "block");
                $('#results').html(data.html);
              }
            }
      });
  });

  $('.navbar-toggler').click(function(){
    $('.search-result').css("display", "none");
  });

  $('.flexslider').flexslider({
    animation: "fade",
    controlNav: "thumbnails",
    directionNav:false,
    smoothHeight: true
  });

  $('.flexsliderofertas').flexslider({
        animation: "slide",
        animationLoop: true,
        itemWidth: 330,
        itemMargin: 4,
  });
  
  $('ul.slides li').zoom();

});
/*
function formapago(nro){
    var check = $('input[name=payment]:checked').val();
    var form = "forma_pago_form";
    if(nro == '3'){ form = "forma_pago_formdos"; }
    if(check > 0){
        if(check == '2'){//pago 
            $('form[name='+form+']').submit();
        }else{
            $.ajax({
                type: "POST",
                url: "ajax/confirmacion",
                data: $("#"+form).serialize(),
                dataType: "json",
                success: function(data){
                  console.log(data);
                  if(data.status == 'success'){
                      swal({
                        title: "Muchas Gracias!",
                        text: "Su compra ha sido realizada!",
                        type: "success"
                      },function(){
                        location.href='productos.php'; 
                      });
                  }else{
                    swal("Atención", data.description, "warning");
                  }
                  //if(data.status == 'success'){
                    //location.href='confirmacion.php'; 
                  //}
                }
            });
        }

    }else{
      swal("¡Atención!", "Seleccione un metodo de Pago", "warning");
    }
}
*/

function update(detalle_id){
    var cant = $('#cantidadproducto_'+detalle_id).val();
    cant = parseInt(cant);
    if(cant < 1){
      swal("Error", response.description, "warning");
      return false;
    }

    if(cant > 0){
        //$.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
        $.ajax({
                data:   {detalle_id:detalle_id, accion:'update', cant:cant},
                url:'ajax/carrito',
                type: 'POST',
                dataType: 'json',
                success:  function (data) {
                  //
                       if(data.status == 'success'){
                          location.reload();
                       }else{
                          swal("Error", data.description, "warning");
                       }
                }
           });
      }else{
        swal("Error", "La cantidad debe ser mayor a cero", "warning");
      }

      return false;
}

function editaDireccion(id){
    $.ajax({
        type: "POST",
        url: "ajax/registro",
        data:{id:id,accion:"editaDireccion"},
        dataType: "json",
        success: function(data){
          if(data.status == "success"){
            swal("Actualizado", "Datos actualizados", "success");
          }else{
            swal("Atención", data.description, "warning");
          }

        }
    });
}

function eliminaDireccion(id){
    $.ajax({
        type: "POST",
        url: "ajax/registro",
        data:{id:id,accion:"deleteDireccion"},
        dataType: "json",
        success: function(data){
          if(data.status == "success"){
            $('#direccion_'+id).remove();
          }
          

        }
    });
}
