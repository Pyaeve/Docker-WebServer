<?php
    require_once('inc/config.php');
    if(!isset($_SESSION['cli_reg'])){
        #Si no existe session redirecciona
        header("Location:productos");
        exit();
    }

    $totalPrecio  = Carrito_detalle::totalCosto($cliente_id);
    $totalItems   = Carrito_detalle::totalItems($cliente_id);

    #Si no existe articulo en el carrito vuelve a productos
    if($totalItems == 0){
        header("Location:productos");
        exit();
    }

    $carritoNombre = Carrito::get("cliente_id = ".$cliente_id);
    $cartName = strlen($_SESSION['carrito']['nombre_carrito']) > 0 ? $_SESSION['carrito']['nombre_carrito'] : strlen($carritoNombre[0]['carrito_nombre']) > 0 ? $carritoNombre[0]['carrito_nombre'] : "";

    $cliente = Clientes::select($cliente_id);
    $cliente = $cliente[0];
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-ES"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es-ES"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es-ES"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es-ES"> <!--<![endif]-->
<head>
  <? include("inc/head.php")?>  

  <title>Catedral</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <style type="text/css">
        .item{border: 1px solid #d3d3d3; border-radius: 5px;padding: 0; margin-left: 20px;}
        .cid-scEieb16NW{ padding-top: 0; }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .pull-left {
            float: left!important;
        }
        .pull-right {
            float: right!important;
        }
        .fa-trash-o{
            color: red;
            font-size: 22px;
        }
        a{
            color: #000
        }
        .count{width: 50%}

        .cid-scEieb16NW img, .cid-scEieb16NW .item-img {
            height: 120px;
        }
        .btn-primary, .btn-primary:active {
            background-color: #0f3b84 !important;
            border-color: #0f3b84 !important;
        }
        #nombraCarrito input{ width: 50% }
        #btn_Nc{ width: 50%; font-size: 13px;}
        /**/
        @media only screen and (max-width: 800px) {
        /* Force table to not be like tables anymore */
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
        display: block;
        }
         
        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
        }
         
        #no-more-tables tr { border: 1px solid #ccc; }
          
        #no-more-tables td {
        /* Behave like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        white-space: normal;
        text-align:left;
        }
         
        #no-more-tables td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        text-align:left;
        font-weight: bold;
        }
         
        /*
        Label the data
        */
        #no-more-tables td:before { content: attr(data-title); }
        }

        .mainficha{
            padding: 0;
            background: #0e3b84;
        }
        .ficha{ color: #fff }
        .ficha:hover{ color: #fff }

        .btn.focus, .btn:focus {
            box-shadow: 0 0 0 0.2rem rgb(255 255 255 / 0%);
        }
        .btn-success {
            background-image: -webkit-linear-gradient(top, #5cb85c 0%, #419641 100%);
            background-image: -o-linear-gradient(top, #5cb85c 0%, #419641 100%);
            background-image: -webkit-gradient(linear, left top, left bottom, from(#5cb85c), to(#419641));
            background-image: linear-gradient(to bottom, #5cb85c 0%, #419641 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#ff5cb85c', endColorstr='#ff419641', GradientType=0);
            filter: progid:DXImageTransform.Microsoft.gradient(enabled = false);
            background-repeat: repeat-x;
            /*border-color: #3e8f3e;*/
            padding: 3px 23px;
        }
        .btn-danger, .btn-danger:active {
            background-color: #c82333 !important;
            border-color: #c82333 !important;
        }
        .btn-danger:hover, .btn-danger:focus, .btn-danger.focus, .btn-danger.active {
            background-color: #ff0000 !important;
            border-color: #ff0000 !important;
        }
  </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">


<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-12 mt-3 mb-4">
            <div class="row">
                <div class="col-md-6 col-lg-7 mt-3">
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-7 border-bottom"><strong>DATOS DE FACTURACI&Oacute;N</strong></h3>
                   
                    <div style="padding: 10px 27px 10px 20px;background: #ebf1fb; font-size: 13px;">
                        <p class="mt-3"><strong>Nombre y Apellido: </strong><?=$cliente['cliente_nombre']?></p>
                        <p ><strong>Cedula: </strong> <?=$cliente['cliente_cedula']?></p>
                        <p ><strong>R.U.C. </strong> <?=$cliente['cliente_ruc']?></p>
                    </div>
                               
                    <div class="bs-example mt-3">
                        <h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-7 border-bottom">
                            <strong>ESCOJA SU OPCI&Oacute;N DE ENTREGA</strong>
                        </h4>
                        <p class="mt-3">
                            <input type="radio" name="opcionentrega" id="retirardesucursal" value="sucursal">
                            <strong>Retirar de la sucursal</strong>
                            <select name="contraentrega_local" class="form-control mt-3" id="contraentrega_local" style="color:#000;">
                                <option value="">Seleccionar Sucursal m&aacute;s cercana</option>
                                <?  
                                    $sucursales = Sucursales::get("sucursal_delivery = 1");
                                    if(haveRows($sucursales)){
                                        foreach ($sucursales as $sucursal) {
                                            echo '<option value="'.$sucursal["sucursal_id"].'">'.$sucursal["sucursal_nombre"].' '.$sucursal["sucursal_direccion"].'</option>';
                                        }
                                    }
                                ?>
                            </select>
                        </p>
                        <p>
                            <input type="radio" name="opcionentrega" id="delivery" value="delivery">
                            <strong>Delivery</strong>
                        </p>
                        <div class="card-header mainficha" id="heading1">
                            <h2 class="mb-1">
                                <button type="button" id="tipo1" class="btn btn-link ficha" data-toggle="collapse" data-target="#collapse1">DIRECCI&Oacute;N DE ENTREGA</button>                                  
                            </h2>
                        </div>
                        <style type="text/css">
                            .direction strong, .help-block{
                                margin-left: 10px;
                            }
                        </style>
                        <div class="card-header" id="heading1">
                            <div class="row">
                                <div class="col-md-12 col-lg-12">
                                    <a href="direcciones" class="btn btn-success">Agregar Direcci&oacute;n<i class="fa fa-chevron-right ml-2"></i></a>
                                </div>
                                <?
                                    $direcciones = Direcciones::get("cliente_id = ".$cliente['cliente_id']);
                                    $cantidad = count($direcciones);
                                    if(haveRows($direcciones)){
                                        foreach ($direcciones as $rsd) {
                                            $checked = $rsd['direccion_predeterminado'] > 0 ? 'checked="checked"' : "";
                        
                                            $slugit = $rsd["direccion_slugit"];
                                            ?>
                                <div class="col-md-6 col-lg-6" id="direccion_<?=$rsd['direccion_id']?>">
                                    <label class="direction">
                                        <input type="radio" onclick="editaDireccion(<?=$rsd['direccion_id']?>,<?=$cliente_id?>)" name="id_direccion_cliente" id="id_direccion_cliente" value="<?=$rsd['direccion_id']?>" <?=$checked?>>
                                        <strong><?=$rsd['direccion_denominacion']?></strong>
                                        <p class="help-block"><?=$rsd['direccion_direccion']?>
                                        <br>Barrio:<?=$rsd['direccion_barrio']?> / <?=$rsd['direccion_ciudad']?></p>
                                    </label>
                                    <button class="btn btn-default btn-block" onclick="window.location.href='direcciones/<?=$slugit?>'">Editar</button>
                                    <button class="btn btn-danger btn-block" onclick="eliminaDireccion(<?=$rsd['direccion_id']?>)">Borrar</button>
                                </div>
                                            <?
                                        }
                                    }
                                ?>                               
                            </div><!--ROW-->
              
                 
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-lg-5 mt-3">
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-2 display-7 text-center border-bottom"><strong>SU PEDIDO</strong></h3>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 text-left"><strong>PRODUCTO</strong></div>
                        <div class="col-md-6 col-lg-6 text-right"><strong>TOTAL</strong></div>
                        <?
                            foreach ($items as $item):
                                if(haveRows($item)){
                                    $subtotal = $item['producto_precio']*$item['detalle_cantidad'];
                        ?>
                            <div class="col-md-6 col-lg-7 listP text-left mt-3"><?=$item['producto_nombre']; ?></div>
                            <div class="col-md-6 col-lg-1 listP text-right mt-3"><?=$item['detalle_cantidad']?></div>
                            <div class="col-md-6 col-lg-4 listP text-right mt-3">Gs. <?=number_format($subtotal,0,'','.'); ?></div>
                        <?php 
                                }
                            endforeach;
                        ?>
                       
                                                              
                     
                        <div class="col-md-6 col-lg-6 listP text-left mt-3"><strong>SUB TOTAL</strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3"><strong>Gs. <?=($totalPrecio>0) ?number_format($totalPrecio,0,'','.') : 0; ?></strong></div>
                        
                        <div class="col-md-6 col-lg-6 listP text-left mt-3"><strong>COSTO DE ENVIO</strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3 " id="envios"><strong> - </strong></div>

                        <div class="col-md-6 col-lg-6 text-left mt-4"><strong>TOTAL</strong></div>

                        <div class="col-md-6 col-lg-6 text-right mt-4" id="montos">
                            <strong>Gs. <?=($totalPrecio>0) ?number_format($totalPrecio,0,'','.') : 0; ?></strong>
                        </div>
                    </div>
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-7 mt-5">
                    <strong>Seleccionar m&eacute;todo de pago</strong></h3>
                    <div class="input-radio mt-2">
                        <input type="radio" name="payment" id="payment-1" value="1">
                        <label for="payment-1"><span></span>Contraentrega </label>
                    </div>        
                    <div class="input-radio">
                        <input type="radio" name="payment" id="payment-2" value="2">
                        <label for="payment-2"><span></span>Pago con tarjeta de Credito</label>
                    </div>
                    
                    <div class="input-radio">
                        <input type="radio" name="payment" id="payment-3" value="3">
                        <label for="payment-3"><span></span>Zimple</label>
                        <div class="w-100 zimple"  style="display: none;">
                            <input type="text" class="form-control" name="zimplecel" id="zimplecel" placeholder="Celular" style="background: #cce0ff">
                        </div>
                    </div>
                       <div class="box-footer">
                    <div class="pull-right">
                        <a href="javascript:;" id="btn_final" class="btn btn-primary">Confirmar compra <i class="fa fa-chevron-right ml-2"></i></a>
                    </div>
                </div>
                </div>

           
             
            </div><!---row-->
        </div>
    </div><!---row-->
</div>
 
</section>
<form method="POST" id="forma_pago_form" name="forma_pago_form">
    <input type="hidden" name="metodo_pago" id="metodo_pago" placeholder="Metodo de Pago">
    <input type="hidden" name="opcion_entrega" id="opcion_entrega" placeholder="opcion_entrega">
    <input type="hidden" name="retiro_de_local" id="retiro_de_local" placeholder="Sucursal Id">
    <input type="hidden" name="retiro_direccion_id" id="retiro_direccion_id" placeholder="Direccion Id">

    <input type="hidden" name="costoD" id="costoD">
    <input type="hidden" name="costoT" id="costoT">
    <input type="hidden" name="zimpleP" id="zimpleP">


    <input type="hidden" name="tokenPago" id="tokenPago" value="<?=token("confirmacion_" . $cliente_id);?>">
</form>
<!-- FOOTER -->
<? require_once('inc/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function(){

        $("input[name=payment]").change(function(){
            var check = $('input[name=payment]:checked').val();
            if(check == '2'){
                $('#forma_pago_form').attr('action', 'pay.php');
                $('.zimple').css({'display':'none'});
                $('input[name=metodo_pago]').val(check);

            }else if(check == '3'){
                $('#forma_pago_form').attr('action', 'pay.php');
                $('.zimple').css({'display':'block'});
                $('input[name=metodo_pago]').val(check);
            }else{
                $('#forma_pago_form').attr('action', '');
                $('.zimple').css({'display':'none'});
                $('input[name=metodo_pago]').val(check);
            }
        });
        
        $("input[name=opcionentrega]").change(function(){
            if($('input[name=opcionentrega]:checked').val() == "delivery"){
                $('input[name=opcion_entrega]').val(1);
            }else{
                $('input[name=opcion_entrega]').val(2);
            }
            costoEnvio();
        });

        $("#contraentrega_local").change(function(){
            var sucursal_id = $(this).val();
            if(sucursal_id > 0){
                 $.ajax({
                    type: "POST",
                    url: "ajax/costos",
                    data: {id:sucursal_id,'accion':'costo_envio'},
                    dataType: "json",
                    success: function(data){
                      if(data.status == "success"){
                        $('#envios').text(data.costo);
                        $('#montos').text(data.total);

                      }
                    }
                });
            }
        });
        
        $("#btn_final").click(function(){
            var check = $('input[name=payment]:checked').val();//metodo de pago
            var local = $('select[name="contraentrega_local"]').val();
            var opcionentrega = $('input[name=opcionentrega]:checked').val();
            var zimple = $('input[name=zimplecel]').val();
            var id_direccion = $('input[name=id_direccion_cliente]:checked').val();

            $('input[name=retiro_de_local]').val(local);
            $('input[name=retiro_direccion_id]').val(id_direccion);
            $('input[name=zimpleP]').val(zimple);


            if(check > 0){
                if(!$("input[name='opcionentrega']").is(':checked')){
                    swal("Atencion", "Seleccionar una Opcion de entrega", "warning");
                }else{
                    ////////////////////////////////////////////////
                    if(check == '3'){
                        if(zimple == false){
                            swal("Atencion", "Completa el campo Celular", "warning");
                            return false;
                        }else{
                            $('#zimplenro').val(zimple);

                        }
                    }
                    ////////////////////////////////////////////////

                    if(opcionentrega == "sucursal" && local == false){
                      $("#contraentrega_local").focus();
                      swal("Atencion", "Seleccionar una Sucursal", "warning");
                    }
                    else if(opcionentrega == "delivery"){
                        if(!id_direccion){
                            swal("Atencion", "Selecciona una direccion de entrega", "warning");
                            return false;
                        }else{
                            formapago('1');
                        }
                    }else{
                        formapago('1');
                    }
                    //
                }
            
            }else{
                swal("Atenci��n", "Seleccione un metodo de Pago", "warning");
            }
        });
    });

    function formapago(nro){
        var check = $('input[name=payment]:checked').val();
        if(check > 0){
            if(check == 2 || check == 3){//pago 
                $('form[name=forma_pago_form]').submit();
            }else{
                $.ajax({
                    type: "POST",
                    url: "ajax/confirmacion",
                    data: $("#forma_pago_form").serialize(),
                    dataType: "json",
                    success: function(data){
                      if(data.status == 'success'){
                          swal({
                            title: "Muchas Gracias!",
                            text: data.description,//"Su compra ha sido realizada!",
                            type: data.status//"success"
                          },function(){
                            location.href='productos.php'; 
                          });
                      }else{
                        swal("Atencion", data.description, "warning");
                      }
                    }
                });
            }

        }else{
          swal("�0�3Atencion!", "Seleccione un metodo de Pago", "warning");
        }
    }
    
    function costoEnvio(){
        var opcionentrega = $('input[name=opcionentrega]:checked').val();
        var sucursal_id = $("#contraentrega_local").val();
        $.ajax({
                type: "POST",
                url: "ajax/costos",
                data: {id:sucursal_id,'accion':'costo_envio',opcionentrega : opcionentrega},
                dataType: "json",
                success: function(data){
                  if(data.status == "success"){
                    var opcionentrega = $('input[name=opcionentrega]:checked').val();
                    $('#envios').text(data.costo);
                    $('#costoD').val(data.costo);
                    $('#montos').text(data.total);
                    $('#costoT').val(data.total);
                    
                  }
                }
        });
        
    }
</script>

  </body>


</html>