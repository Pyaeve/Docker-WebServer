<?php
    require_once('inc/config.php');
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>
  <title>Repetir Pedidos</title>
  <style>
      .cid-scEyjqCodG{
        background: #fff;
         padding-top: 2rem;
      }
      ul li{color: #000; line-height:3;}

    .cid-scEyjqCodG .counter-container ul li::before {
        background-color: #0f3b84;
    }
    select{ width: 100%; }
  </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<section class="content8 cid-scEyjqCodG" id="content8-3g" style="">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-12">
                <h2 class="mbr-section-title mbr-fonts-style"><strong>Entrega y costos de envío.</strong></h2>
                <span class="linea"></span>
            </div>
            <div class="col-12 col-lg-12 mb-3 pt-3" style="background: #ccdfff; border-radius: 5px">
                
                <h4 class="mbr-section-title mbr-fonts-style"><strong>Calculá el costo de envío</strong></h4>
                <form action="get" id="calculo" class="mt-3 mb-3">

                    <div class="row">
                        <div class="col-lg-4 col-sm-12" id="dept">
                            <? echo Departamentos::comboDept();?>
                        </div>


                        <div class="col-lg-4 col-sm-12" id="ciudades">
                          <select name="ciudad_id" id="ciudad_id" class="form-control">
                                <option value="0">Selecciona Ciudad</option>
                          </select> 
                        </div>

                        <div class="col-lg-4 col-sm-12" id="sucursal">
                            <select name="ubicacion" id="ubicacion" class="form-control">
                                <option value="0">Selecciona dirección y/o ubicación </option>
                            </select>
                        </div>

                        <div class="col-12 col-lg-12 pt-2 pb-2 mt-5 importe"><strong>Importe:</strong> Gs.  </div>
                    </div>
                 </form>
            </div>
            <div class="col-12 col-lg-12">
                <h2 class="mbr-section-title mbr-fonts-style"><strong>Retiro sin costo.</strong></h2>
                <span class="linea"></span>
            </div>
            <div class="counter-container col-md-12 col-lg-12">
                  
                    <p class="m-3">Te damos la facilidad de retirar tus pedidos sin costo alguno de tu sucursal preferida.
                        El horario de retiro dependerá de la sucursal seleccionada. ver sucursales 
                    </p>

                    <p class="m-3">Las entregas se harán de 08:00 a 20:00 hs. todos los días incluyendo los feriados en Asunción y Gran Asunción.</p>
                    <p class="m-3">Para envíos al interior las entregas se realizarán a 48 a 72 horas en días hábiles, previamente coordinado por ambas partes.</p>

                    <p class="m-3">La fecha y horario de entrega puede variar a la programada, la misma será previamente informada al usuario. Para mayor información sobre zonas de cobertura y/o tipos de servicios disponibles favor contactar mediante chat online o llamando al 021 627 7000.</p>
                  
              
            </div>
        </div>
    </div>
</section>


<? require_once('inc/footer.php'); ?>

    <input name="animation" type="hidden">
    <script type="text/javascript">
        $(document).ready(function(){
          $("select[id=departamentos_combo]").change(function(){
              var dept = $('select[id=departamentos_combo]').val();
               $.ajax({
                  url : 'ajax/costos',
                  data: {id:dept,'accion':'ciudad'},
                  type : 'post',
                  dataType : 'json',
                  success : function(data){
                    if(data.status == "success"){
                      var $el = $("#ciudad_id");
                      $el.empty(); // remove old options
                      $.each(data.html, function(key,value) {
                        $el.append($("<option></option>")
                           .attr("value", key).text(value));
                      });
                    }//END data.status
                  }
              });
              return false;
          });

          $("select[name=ciudad_id]").change(function(){
              var city = $('select[name=ciudad_id]').val();
              $.ajax({
                  url : 'ajax/costos',
                  data: {id:city,'accion':'sucursal'},
                  type : 'post',
                  dataType : 'json',
                  success : function(data){

                    if(data.status == "success"){
                      var $el = $("#ubicacion");
                      $el.empty(); // remove old options
                      $.each(data.html, function(key,value) {
                        $el.append($("<option></option>")
                           .attr("value", key).text(value));
                      });
                    }//END data.status
                  }
              });
              return false;
          });


          $("select[name=ubicacion]").change(function(){
              var ubi = $('select[name=ubicacion]').val();
              var city = $('select[name=ciudad_id]').val();
              //console.log(city);
              $.ajax({
                  url : 'ajax/costos',
                  data: {id:ubi,city:city,'accion':'ubicacion'},
                  type : 'post',
                  dataType : 'json',
                  success : function(data){
                    if(data.status == "success"){
                      $('.importe').html(data.html);
                    }//END data.status
                  }
              });
              return false;
          });

        });

    </script>

  </body>
</html>