<?php
    require_once('inc/config.php');
    if(!isset($_SESSION['cli_reg'])){
        #Si no existe session redirecciona
        header("Location:productos");
        exit();
    }
    //ACTUALIZAR PRECIOS CARRITOS
    $productos_actualizar = Carrito::getProductosActualizar($cliente_id);
    foreach ($productos_actualizar as $pr_ac){
        if(haveRows($pr_ac)){
            Carrito_detalle::set('producto_precio', $pr_ac["nuevo_precio"], 'detalle_id = '.$pr_ac["detalle_id"]);
        }
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

    $token = md5($private_key_staging . $cliente_id . "request_user_cards");
    $data = array(
        "public_key" => $public_key_staging,
        "operation"	 => array(
            "token"	 => $token
        ),
    );
    $session = curl_init($usercard_url.$cliente_id."/cards");
    #--------------------------------------------------------------
    curl_setopt($session, CURLOPT_POST, 1);
    curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
    $session_response = curl_exec($session);
    
    curl_close($session);
    $response = json_decode($session_response);

    if($response->status == "success"){
        
        if($response->cards){
            $bc = '<input class="form-check-input" type="radio" name="payment" id="payment-5" value="5">
            <label for="payment-5"><span></span>Pago con tarjeta registrada</label>
            <div class="ml-3 w-100 opciones_bancard" style="display: none; font-size: 14px;" >';
            
            foreach ($response->cards as $key => $cards) {
                $alias_token        = $cards->alias_token;
                $card_masked_number = $cards->card_masked_number;
                $expiration_date    = $cards->expiration_date;
                $card_brand         = $cards->card_brand;
                $card_id            = $cards->card_id;
                $card_type          = $cards->card_type;
                $cartName           = $cards->card_type == "credit" ? "CR&EacuteDITO" : "D&EacuteBITO";
                if($key == 0){

                    $bc .= ' <input class="form-check-input" type="radio" name="opcionpago_bancard" value="'.$alias_token.'" checked="checked">
                    <label><span></span>'.$cartName.' - '.$card_brand.' - '.$card_masked_number.'</label><br>';

                }else{

                    $bc .= ' <input class="form-check-input" type="radio" name="opcionpago_bancard" value="'.$alias_token.'">
                    <label><span></span>'.$cartName.' - '.$card_brand.' - '.$card_masked_number.'</label><br>';

                }
                
                
                    

                
            }
            $bc .= ' </div><br>';

        }else{
            $bc .= '<input class="form-check-input" type="radio" name="payment" id="payment-5" value="5" disabled>
            <label for="payment-5"><span></span>Pago con tarjeta registrada</label>';
        }

    }
    



?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="es-ES"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang="es-ES"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang="es-ES"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="es-ES"> <!--<![endif]-->
<head>
  <?php include("inc/head.php")?>  

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
        .proalert{ color: #f00; }
        a.disabled {
          pointer-events: none;
          cursor: default;
        }

        .checkbox {
            width: 100%;
            margin: 15px auto;
            position: relative;
            display: block;
        }

        .checkbox input[type="checkbox"] {
            width: auto;
            opacity: 0.00000001;
            position: absolute;
            left: 0;
            margin-left: -20px;
        }
        .checkbox label {
            position: relative;
        }
        .checkbox label:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            margin: 4px;
            width: 22px;
            height: 22px;
            transition: transform 0.28s ease;
            border-radius: 3px;
            border: 2px solid #7bbe72;
        }
        .checkbox label:after {
        content: '';
            display: block;
            width: 10px;
            height: 5px;
            border-bottom: 2px solid #7bbe72;
            border-left: 2px solid #7bbe72;
            -webkit-transform: rotate(-45deg) scale(0);
            transform: rotate(-45deg) scale(0);
            transition: transform ease 0.25s;
            will-change: transform;
            position: absolute;
            top: 12px;
            left: 10px;
        }
        .checkbox input[type="checkbox"]:checked ~ label::before {
            color: #7bbe72;
        }

        .checkbox input[type="checkbox"]:checked ~ label::after {
            -webkit-transform: rotate(-45deg) scale(1);
            transform: rotate(-45deg) scale(1);
        }

        .checkbox label {
            min-height: 34px;
            display: block;
            padding-left: 40px;
            margin-bottom: 0;
            font-weight: normal;
            cursor: pointer;
            vertical-align: sub;
        }
        .checkbox label span {
            position: absolute;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
        }
        .checkbox input[type="checkbox"]:focus + label::before {
            outline: 0;
        }
  </style>
</head>
<body>
 <?php 
    require_once('inc/header.php'); 
    require_once('inc/nav.php'); 

?>
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y" style="margin-top: 4.5%;">


<div class="container">
    <div class="row">
        <div class="col-md-6 col-lg-12 mt-3 mb-4">
            <div class="row">
                <div class="col-md-6 col-lg-7 mt-3">
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-7 border-bottom"><strong>DATOS DE FACTURACI&Oacute;N</strong></h3>
                   
                    <div style="padding: 10px 27px 10px 20px;background: #ebf1fb; font-size: 13px;">
                        <p class="mt-3"><strong>Nombre y Apellido: </strong><?php echo $cliente['cliente_nombre']; ?></p>
                        <p ><strong>Cedula: </strong> <?php echo $cliente['cliente_cedula'];?></p>
                        <p ><strong>R.U.C. </strong> <?php echo $cliente['cliente_ruc'];?></p>
                    </div>
                               
                    <div class="bs-example mt-3">
                        <h4 class="mbr-section-title mbr-fonts-style align-center mb-0 display-7 border-bottom">
                            <strong>ESCOJA SU OPCI&Oacute;N DE ENTREGA</strong>
                        </h4>
                        <p class="mt-3">
                            <input class="form-check-input" type="radio" name="opcionentrega" id="delivery" value="delivery">
                            <strong>Delivery </strong>
                            <p id="del_aviso" name="del_aviso" style="display: none; font: menu; color: green;"></p>
                            
                        </p>
                        <div id="delivery_div" style="display:none;">
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
                                    <?php 
                                        $direcciones = Direcciones::get("cliente_id = ".$cliente['cliente_id']);
                                        $cantidad = count($direcciones);
                                        if(haveRows($direcciones)){
                                            foreach ($direcciones as $rsd) {
                                                $checked = $rsd['direccion_predeterminado'] > 0 ? 'checked="checked"' : "";
                            
                                                $slugit = $rsd["direccion_slugit"];
                                                ?>
                                    <div class="col-md-6 col-lg-6" id="direccion_<?php echo $rsd['direccion_id'];?>">
                                        <label class="direction">
                                            <input class="form-check-input" type="radio" onclick="editaDireccion(<?php echo $rsd['direccion_id'];?>,<?php echo $cliente_id;?>)" name="id_direccion_cliente" id="id_direccion_cliente" value="<?php echo $rsd['direccion_id'];?>" <?php echo $checked;?>>
                                            <strong><?php echo $rsd['direccion_denominacion'];?></strong>
                                            <p class="help-block"><?php echo $rsd['direccion_direccion'];?>
                                            <br>Barrio:<?php echo $rsd['direccion_barrio'];?> / <?php echo $rsd['direccion_ciudad'];?></p>
                                        </label>
                                        <button class="btn btn-default btn-block" onclick="window.location.href='direcciones/<?php echo $slugit;?>'">Editar</button>
                                        <button class="btn btn-danger btn-block" onclick="eliminaDireccion(<?php echo $rsd['direccion_id'];?>)">Borrar</button>
                                    </div>
                                                <?php
                                            }
                                        }
                                    ?>                               
                                </div><!--ROW-->
                            </div>
              
                 
                        </div>
                        <p class="mt-3">
                            <input class="form-check-input" type="radio" name="opcionentrega" id="retirardesucursal" value="sucursal">
                            <strong>Retirar de la sucursal (Pick up)</strong>
                            <select name="contraentrega_local" class="form-select form-select-lg mt-3" data-live-search="true" id="contraentrega_local" style="color:#000; display:none;">
                                <option value="">Seleccionar Sucursal</option>
                                <?php  
                                    $sucursales = Sucursales::get("sucursal_delivery IN (1,0) and sucursal_codigo is not null","sucursal_nombre ASC");
                                    if(haveRows($sucursales)){
                                        foreach ($sucursales as $sucursal) {
                                            echo '<option value="'.$sucursal["sucursal_id"].'">'.$sucursal["sucursal_nombre"].': '.$sucursal["sucursal_direccion"].'</option>';

                                        }
                                    }
                                ?>
                            </select>
                            <strong id="aviso_contra_entrega" style="color:red;display:none; margin-top:5px;">Atenci&oacuten: Esta opci&oacuten consiste en que deber&aacute pasar a retirar su pedido en la sucursal que selecciono.</strong>
                        </p>
                      
                        <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="regalo" value="N">
                        <label class="form-check-label" for="regalo"><strong>Para regalo</strong></label>
                        </div>
                        <div class="mt-3" id="obs" style="display:none;">
                            <label for="comentario"><strong>Observaci&oacute;n</strong></label>
                            <input class="form-control" type="text" maxlength="100" id="comentario" name="comentario">
                        </div>
                                                 
                    </div>

                </div>
                <div class="col-md-6 col-lg-5 mt-3">
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-2 display-7 text-center border-bottom"><strong>SU PEDIDO</strong></h3>
                    <div class="row">
                        <div class="col-md-6 col-lg-6 text-left"><strong>PRODUCTO</strong></div>
                        <div class="col-md-6 col-lg-6 text-right"><strong>TOTAL</strong></div>
                        <?php
                            foreach ($items as $item):
                                if(haveRows($item)){
                                    $subtotal = $item['producto_precio']*$item['detalle_cantidad'];
                                    
                                    $producto_code = Productos::select($item['producto_id']);
                                    $producto_val.= $producto_code[0]['producto_codigo']."_".$item['detalle_cantidad'].",";
                                    $subtotal_mostrador = ($producto_code[0]['producto_precioantes']+$producto_code[0]['producto_precioantesIVA'])*$item['detalle_cantidad'];
                                    $totalPrecio_mostrador += $subtotal_mostrador;
                        ?>
                            <div class="col-md-6 col-lg-7 listP text-left mt-3">
                                <?php echo $item['producto_nombre']; ?>
                                <div class="proalert" id="alert_stock_<?php echo $producto_code[0]['producto_codigo'];?>"></div>
                            </div>
                            <div class="col-md-6 col-lg-1 listP text-right mt-3"><?php echo $item['detalle_cantidad'];?></div>
                            <div class="col-md-6 col-lg-4 listP text-right mt-3" name="precio_descuento" style="display:block;">Gs. <?php echo number_format($subtotal,0,'','.'); ?></div>
                            <div class="col-md-6 col-lg-4 listP text-right mt-3" name="precio_mostrador" style="display:none;">Gs. <?php echo number_format($subtotal_mostrador,0,'','.'); ?></div>
                        <?php 
                                }
                            endforeach;
                            //agregado por Daniel Galeano. 13/08/2021
                            //id de producto delivery 9736
                            $producto = Productos::select(9736);
                            $precio_del = $producto[0]['producto_precio'];
                            $iva_del = $producto[0]['producto_precioIVA'];
                            $precio_del_iva = $precio_del + $iva_del;
                            //mínimo de compra
                            $parametro = Parametros::select(1);
                            $compra_minima = $parametro[0]['para_valor_numerico'];
                            //métodos de pago y línea de crédito
                            $ws = credito_clientes($cliente['cliente_cedula']/*3631719*/, $credito_clientes);
                            $cant_pagos = count($ws[0]->clie_cred->FORMAPAGO,1); 
                            $disponible = $ws[0]->clie_cred->DISPONIBLE;
                            $totalPrecio_mostrador_deli = $totalPrecio_mostrador + $precio_del_iva;

                        ?>
                       
                                                              
                        <input type="hidden" name="productos_val" id="productos_val" value="<?php echo $producto_val;?>">
                        <input type="hidden" name="total_precio" id="total_precio" value="<?php echo $totalPrecio;?>">
                        <input type="hidden" name="compra_minima" id="compra_minima" value="<?php echo $compra_minima;?>">
                        <input type="hidden" name="precio_delivery" id="precio_delivery" value="<?php echo $precio_del;?>">
                        <input type="hidden" name="linea_disponible" id="linea_disponible" value="<?php echo $disponible;?>">
                        <div class="col-md-6 col-lg-6 listP text-left mt-3"><strong>SUB TOTAL</strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3" name="sub_total" style="display:block"><strong>Gs. <?php echo ($totalPrecio>0) ?number_format($totalPrecio,0,'','.') : 0; ?></strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3" name="sub_total_mostrador" style="display:none"><strong>Gs. <?php echo ($totalPrecio_mostrador>0) ?number_format($totalPrecio_mostrador,0,'','.') : 0; ?></strong></div>
                        
                        <div class="col-md-6 col-lg-6 listP text-left mt-3"><strong>COSTO DE ENVIO</strong></div>
                        <div class="col-md-6 col-lg-6 listP text-right mt-3 " id="envios"><strong id="compra_otro" name="compra_otro" > - </strong><strong id="compra_del" name="compra_del" style="display: none;"> <?php echo ($totalPrecio>$compra_minima) ? number_format($precio_del_iva,0,'','.') : 0; ?></strong></div>

                        <div class="col-md-6 col-lg-6 text-left mt-4"><strong>TOTAL</strong></div>

                        <div class="col-md-6 col-lg-6 text-right mt-4" id="montos">
                            <strong id="total_sin_del" name="total_sin_del">Gs. <?php echo ($totalPrecio>0) ?number_format($totalPrecio,0,'','.') : 0; ?></strong> <strong id="total_con_del" name="total_con_del" style="display: none;">Gs. <?php echo ($totalPrecio>$compra_minima) ?number_format($totalPrecio+$precio_del_iva,0,'','.') : number_format($totalPrecio,0,'','.'); ?></strong>
                        </div>
                        <div class="col-md-6 col-lg-6 text-right mt-4" id="montos_mostrador" style="display:none;">
                            <strong id="total_sin_del_m" name="total_sin_del_m">Gs. <?php echo ($totalPrecio_mostrador>0) ?number_format($totalPrecio_mostrador,0,'','.') : 0; ?></strong> <strong id="total_con_del_m" name="total_con_del_m" style="display: none;">Gs. <?php echo ($totalPrecio_mostrador>$compra_minima) ?number_format($totalPrecio_mostrador+$precio_del_iva,0,'','.') : number_format($totalPrecio_mostrador,0,'','.'); ?></strong>
                        </div>
                    </div>
                    <h3 class="mbr-section-title mbr-fonts-style align-center mb-0 display-7 mt-5">
                    <strong>Seleccionar m&eacute;todo de pago</strong></h3>
                    <div class="input-radio mt-2">
                        <input class="form-check-input" type="radio" name="payment" id="payment-1" value="1">
                        <label for="payment-1"><span></span>Contraentrega </label>
                        <div class="ml-3 w-100 opciones" style="display: none; font-size: 14px;" >
                            <input class="form-check-input" type="radio" name="opcionpago" id="efectivo" value="1" checked="checked">
                            <label for="payment-2"><span></span>Efectivo</label><br>
                            <input class="form-check-input" type="radio" name="opcionpago" id="pos" value="2">
                            <label for="payment-2"><span></span>POS</label>
                        </div>
                    </div>        
                    <div class="input-radio">
                        <?php  
                        
                        $Hoy = Mysql::exec("SELECT date_format(now(),'%Y-%c-%d') AS HOY");
                        $UltimoJueves = Mysql::exec("SELECT date_format(LAST_DAY(NOW()) - ((7 + WEEKDAY(LAST_DAY(NOW())) - 3) % 7),'%Y-%c-%d') AS JUEVES");
                            
                            if($Hoy[0]['HOY'] <> $UltimoJueves[0]['JUEVES']){ 
                        
                        ?>
                            <input class="form-check-input" type="radio" name="payment" id="payment-2" value="2">
                            <label for="payment-2"><span></span>Pago sin registro de tarjeta de Cr&eacutedito</label>
                            <div class="ml-3 w-100 opciones_tarj" style="display: none; font-size: 14px;" >
                            
                                <input class="form-check-input" type="radio" name="opcionpago_tarj" id="otros" value="otros" checked="checked">
                                <label for="otros"><span></span>OTROS</label><br>
                                <input class="form-check-input" type="radio" name="opcionpago_tarj" id="vision_visa" value="039" >
                                <label for="vision_visa"><span></span>VISION</label><br>
                                <h7 style="color:red;display:none;font-weight: bold;" id="aviso_vision" name="aviso_vision">Atenci&oacuten: Los descuentos de VISION BANCO se realizan en el extracto sobre el precio mostrador!.</h7><br>

                            </div><br>
                            <?php echo $bc; ?>
                        <?php }else{ ?>

                            <input class="form-check-input" type="radio" name="payment" id="payment-2" value="2">
                            <label for="payment-2"><span></span>Pago sin registro de tarjeta de Cr&eacutedito</label>
                            <?php echo $bc; ?>

                        <?php } ?>
                    </div>
                    <?php  if($cant_pagos>0){
                        ?>
                            <div class="input-radio mt-2">
                                <input class="form-check-input" type="radio" name="payment" id="payment-4" value="4">
                                <label for="payment-4"><span></span>Crédito Farmacia</label>
                                <div class="ml-3 w-100 opcionescred" style="display: none; font-size: 14px;" >
                                <?php
                                    for ($i = 0; $i < $cant_pagos; $i++) {
                                        $cod_forma = $ws[0]->clie_cred->FORMAPAGO[$i]->COD_FORMA;
                                        $forma = $ws[0]->clie_cred->FORMAPAGO[$i]->FORMAS;
                                        
                                        echo "<input class=\"form-check-input\" type=\"radio\" name=\"opcionpago\" id=\"$cod_forma\" value= \"$cod_forma\" >";
                                        echo "<label for=\"$cod_forma\"><span> &nbsp; $forma </span></label><br>";
                                        
                                    }
                                ?>
                                    

                                </div>
                            </div> 
                        <?php
                    }?>
                    
                    
                    <div class="input-radio" style="visibility: hidden;">
                        <input class="form-check-input" type="radio" name="payment" id="payment-3" value="3">
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
    <input type="hidden" name="tarjeta" id="tarjeta" placeholder="Tarjeta">
    <input type="hidden" name="token_tarjeta" id="token_tarjeta" placeholder="Token Tarjeta">
    <input type="hidden" name="total_precio_mostrador" id="total_precio_mostrador" value="<?php echo $totalPrecio_mostrador;?>">
    <input type="hidden" name="costo_envio" id="costo_envio" value="<?php echo ($totalPrecio<$compra_minima) ? 0 : $precio_del; ?>">
    <input type="hidden" name="costo_envio_iva" id="costo_envio_iva" value="<?php echo $precio_del_iva; ?>"> 
    <input type="hidden" name="costoD" id="costoD">
    <input type="hidden" name="costoT" id="costoT">
    <input type="hidden" name="zimpleP" id="zimpleP">
    <input type="hidden" name="ContraentregaopcionPago" id="ContraentregaopcionPago">

    <input type="hidden" name="tokenPago" id="tokenPago" value="<?php echo token("confirmacion_" . $cliente_id);?>">
    <input type="hidden" name="paramregalo" id="paramregalo" value="N">
    <input type="hidden" name="paramcomentario" id="paramcomentario" value="">
</form>
<!-- FOOTER -->
<?php require_once('inc/footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        
        $("#regalo").click(function(){

            if (document.getElementById("regalo").checked == true){
                document.getElementById("paramregalo").value = "S";
                $('#obs').css({'display':'block'});
            } else {
                document.getElementById("paramregalo").value = "N";
                document.getElementById("paramcomentario").value = "";
                $('#obs').css({'display':'none'});
            }

        });

        $("input[name=payment]").change(function(){
            var check = $('input[name=payment]:checked').val();
            var check_tarj = $('input[name=opcionpago_tarj]:checked').val();
            var check_token = $('input[name=opcionpago_bancard]:checked').val();
            document.getElementById("tarjeta").value = check_tarj;
            if(check == '2'){
                $('#forma_pago_form').attr('action', 'pay_test.php');
                $('.zimple').css({'display':'none'});
                $('.opciones').css({'display':'none'});
                $('.opcionescred').css({'display':'none'});
                $('.opciones_tarj').css({'display':'block'});
                $('.opciones_bancard').css({'display':'none'});
                $('input[name=metodo_pago]').val(check);           
                $('#aviso_vision').css({'display':'none'});
                $("#otros").prop( "checked", true );
                document.getElementById("token_tarjeta").value = "";
            }/*else if(check == '3'){
                $('#forma_pago_form').attr('action', 'pay.php');
                $('.zimple').css({'display':'block'});
                $('.opciones').css({'display':'none'});
                $('.opcionescred').css({'display':'none'});
                $('input[name=metodo_pago]').val(check);
            }*/else if(check == '4'){
                $('.opciones').css({'display':'none'});
                $('.opcionescred').css({'display':'block'});
                $('.opciones_tarj').css({'display':'none'});
                $('.opciones_bancard').css({'display':'none'});
                $('input[name=metodo_pago]').val(check);
                $('#aviso_vision').css({'display':'none'});
                $('div[name=precio_descuento]').css({'display':'block'});
                $('div[name=precio_mostrador]').css({'display':'none'});
                $('div[name=sub_total_mostrador]').css({'display':'none'});
                $('div[name=sub_total]').css({'display':'block'});
                $('#montos').css({'display':'block'});
                $('#montos_mostrador').css({'display':'none'});
                document.getElementById("token_tarjeta").value = "";

                if($('input[name=opcionentrega]:checked').val() == "delivery"){
                    $('#total_con_del').css({'display':'block'});
                    $('#total_sin_del').css({'display':'none'});
                }else{
                    $('#total_sin_del').css({'display':'block'});
                    $('#total_con_del').css({'display':'none'});
                }
            }else if(check == '1'){
                $('#forma_pago_form').attr('action', '');
                $('.zimple').css({'display':'none'});
                $('.opciones').css({'display':'block'});
                $('.opcionescred').css({'display':'none'});
                $('.opciones_tarj').css({'display':'none'});
                $('.opciones_bancard').css({'display':'none'});
                $('input[name=metodo_pago]').val(check);
                $('#aviso_vision').css({'display':'none'});
                $('div[name=precio_descuento]').css({'display':'block'});
                $('div[name=precio_mostrador]').css({'display':'none'});
                $('div[name=sub_total_mostrador]').css({'display':'none'});
                $('div[name=sub_total]').css({'display':'block'});
                $('#montos').css({'display':'block'});
                $('#montos_mostrador').css({'display':'none'});
                document.getElementById("token_tarjeta").value = "";

                if($('input[name=opcionentrega]:checked').val() == "delivery"){
                    $('#total_con_del').css({'display':'block'});
                    $('#total_sin_del').css({'display':'none'});
                }else{
                    $('#total_sin_del').css({'display':'block'});
                    $('#total_con_del').css({'display':'none'});
                }

            }else if(check == '5'){
                $('#forma_pago_form').attr('action', 'pay_test.php');
                $('.zimple').css({'display':'none'});
                $('.opciones').css({'display':'none'});
                $('.opcionescred').css({'display':'none'});
                $('.opciones_tarj').css({'display':'none'});
                $('.opciones_bancard').css({'display':'block'});
                $('input[name=metodo_pago]').val(check);
                $('#aviso_vision').css({'display':'none'});
                $('div[name=precio_descuento]').css({'display':'block'});
                $('div[name=precio_mostrador]').css({'display':'none'});
                $('div[name=sub_total_mostrador]').css({'display':'none'});
                $('div[name=sub_total]').css({'display':'block'});
                $('#montos').css({'display':'block'});
                $('#montos_mostrador').css({'display':'none'});
                document.getElementById("token_tarjeta").value = check_token;

                if($('input[name=opcionentrega]:checked').val() == "delivery"){
                    $('#total_con_del').css({'display':'block'});
                    $('#total_sin_del').css({'display':'none'});
                }else{
                    $('#total_sin_del').css({'display':'block'});
                    $('#total_con_del').css({'display':'none'});
                }
            }
        });
        $("input[name=opcionpago_tarj]").change(function(){
            var check_tarj = $('input[name=opcionpago_tarj]:checked').val();
            document.getElementById("tarjeta").value = check_tarj;
           
            if(check_tarj == 'otros'){
                
                $('#aviso_vision').css({'display':'none'});
                $('div[name=precio_descuento]').css({'display':'block'});
                $('div[name=precio_mostrador]').css({'display':'none'});
                $('div[name=sub_total_mostrador]').css({'display':'none'});
                $('div[name=sub_total]').css({'display':'block'});
                $('#montos').css({'display':'block'});
                $('#montos_mostrador').css({'display':'none'});
                
                if($('input[name=opcionentrega]:checked').val() == "delivery"){
                    $('#total_con_del').css({'display':'block'});
                    $('#total_sin_del').css({'display':'none'});
                }else{
                    $('#total_sin_del').css({'display':'block'});
                    $('#total_con_del').css({'display':'none'});
                }
            }else if(check_tarj == '039'){
                console.log('039');
                
                $('#aviso_vision').css({'display':'block'});
                $('div[name=precio_mostrador]').css({'display':'block'});
                $('div[name=precio_descuento]').css({'display':'none'});
                $('div[name=sub_total_mostrador]').css({'display':'block'});
                $('div[name=sub_total]').css({'display':'none'});
                $('#montos').css({'display':'none'});
                $('#montos_mostrador').css({'display':'block'});

                if($('input[name=opcionentrega]:checked').val() == "delivery"){
                    $('#total_con_del_m').css({'display':'block'});
                    $('#total_sin_del_m').css({'display':'none'});
                }else{
                    $('#total_sin_del_m').css({'display':'block'});
                    $('#total_con_del_m').css({'display':'none'});
                }
            }
        });
        $("input[name=opcionentrega]").change(function(){
            var check_tarj = $('input[name=opcionpago_tarj]:checked').val();
            if($('input[name=opcionentrega]:checked').val() == "delivery"){
                $('input[name=opcion_entrega]').val(1);
                $('#del_aviso').css({'display':'block'});
                $('#compra_del').css({'display':'block'});
                $('#compra_otro').css({'display':'none'});                
                $('#delivery_div').css({'display':'block'});
                $('#contraentrega_local').css({'display':'none'});
                $('#aviso_contra_entrega').css({'display':'none'});
                if(check_tarj == 'otros'){
                    $('#montos').css({'display':'block'});
                    $('#montos_mostrador').css({'display':'none'});
                    $('#total_sin_del').css({'display':'none'});
                    $('#total_con_del').css({'display':'block'});
                    /**/
                    $('div[name=precio_descuento]').css({'display':'block'});
                    $('div[name=precio_mostrador]').css({'display':'none'});
                    $('div[name=sub_total_mostrador]').css({'display':'none'});
                    $('div[name=sub_total]').css({'display':'block'});
                }else if(check_tarj == '039'){
                    $('#montos').css({'display':'none'});
                    $('#montos_mostrador').css({'display':'block'});
                    $('#total_sin_del_m').css({'display':'none'});
                    $('#total_con_del_m').css({'display':'block'});
                    /**/
                    $('div[name=precio_mostrador]').css({'display':'block'});
                    $('div[name=precio_descuento]').css({'display':'none'});
                    $('div[name=sub_total_mostrador]').css({'display':'block'});
                    $('div[name=sub_total]').css({'display':'none'});
                }else{
                    $('#montos').css({'display':'block'});
                    $('#montos_mostrador').css({'display':'none'});
                    $('#total_sin_del').css({'display':'none'});
                    $('#total_con_del').css({'display':'block'});
                    /**/
                    $('div[name=precio_descuento]').css({'display':'block'});
                    $('div[name=precio_mostrador]').css({'display':'none'});
                    $('div[name=sub_total_mostrador]').css({'display':'none'});
                    $('div[name=sub_total]').css({'display':'block'});
                }
                
            }else{
                $('input[name=opcion_entrega]').val(2);
                $('#del_aviso').css({'display':'none'});
                $('#compra_del').css({'display':'none'});
                $('#compra_otro').css({'display':'block'});
                $('#delivery_div').css({'display':'none'});
                $('#contraentrega_local').css({'display':'block'});
                $('#aviso_contra_entrega').css({'display':'block'});
                if(check_tarj == '2'){
                    $('#montos').css({'display':'block'});
                    $('#montos_mostrador').css({'display':'none'});
                    $('#total_sin_del').css({'display':'block'});
                    $('#total_con_del').css({'display':'none'});
                    /**/
                    $('div[name=precio_descuento]').css({'display':'block'});
                    $('div[name=precio_mostrador]').css({'display':'none'});
                    $('div[name=sub_total_mostrador]').css({'display':'none'});
                    $('div[name=sub_total]').css({'display':'block'});
                }else if(check_tarj == '039'){
                    $('#montos').css({'display':'none'});
                    $('#montos_mostrador').css({'display':'block'});
                    $('#total_sin_del_m').css({'display':'block'});
                    $('#total_con_del_m').css({'display':'none'});
                    /**/
                    $('div[name=precio_mostrador]').css({'display':'block'});
                    $('div[name=precio_descuento]').css({'display':'none'});
                    $('div[name=sub_total_mostrador]').css({'display':'block'});
                    $('div[name=sub_total]').css({'display':'none'});
                }else{
                    $('#montos').css({'display':'block'});
                    $('#montos_mostrador').css({'display':'none'});
                    $('#total_sin_del').css({'display':'block'});
                    $('#total_con_del').css({'display':'none'});
                    /**/
                    $('div[name=precio_descuento]').css({'display':'block'});
                    $('div[name=precio_mostrador]').css({'display':'none'});
                    $('div[name=sub_total_mostrador]').css({'display':'none'});
                    $('div[name=sub_total]').css({'display':'block'});
                }
               
            }
            /*$("input[name=opcionpago_tarj]").change(function(){

            }*/
            costoEnvio();
        });

        /*$("#contraentrega_local").change(function(){
            var sucursal_id = $(this).val();
            $('input[name=retiro_de_local]').val(sucursal_id);
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
        });*/
        
        $("#btn_final").click(function(){
            var check = $('input[name=payment]:checked').val();//metodo de pago
            var local = $('select[name="contraentrega_local"]').val();
            var opcionentrega = $('input[name=opcionentrega]:checked').val();
            var zimple = $('input[name=zimplecel]').val();
            var id_direccion = $('input[name=id_direccion_cliente]:checked').val();
            var opcionpago = $('input[name=opcionpago]:checked').val();
            var token_bancard = $('input[name=opcionpago_bancard]:checked').val();
            
            

            $('input[name=retiro_de_local]').val(local);
            $('input[name=retiro_direccion_id]').val(id_direccion);
            $('input[name=zimpleP]').val(zimple);
            $('input[name=ContraentregaopcionPago]').val(opcionpago);
            $('input[name=token_tarjeta]').val(token_bancard);


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
                            verstock();// formapago('1');
                            $("#btn_final").addClass( "disabled" );
                        }
                    }else{
                       // formapago('1');
                        verstock();
                        $("#btn_final").addClass( "disabled" );
                    }
                    //
                }
            
            }else{
                
                    swal("Atencion", "Seleccione un metodo de Pago", "warning");
                                
            }
        });
    });

    function verstock(){
        $.blockUI({ message: '<h2 class="blockUI" style="padding:20px 20px 20px 20px;"> Aguarde un momento por favor...</h2>' });
        $('.proalert').html("");
        var local = $('select[name="contraentrega_local"]').val();
        var opcionentrega = $('input[name=opcionentrega]:checked').val();
        var product_cant = $('input[name=productos_val]').val();
        var total = $('input[name=total_precio]').val();
        var disponible = $('input[name=linea_disponible]').val();
        var opcionpago = $('input[name=opcionpago]:checked').val();
        $.ajax({
            type: "POST",
            url: "ajax/verifica",
            data: {local:local,opcionentrega:opcionentrega,product_cant:product_cant,total:total,disponible:disponible,opcionpago:opcionpago},
            dataType: "json",
            success: function(data){
                
                if(data.status == "success"){
                    $.unblockUI();
                    formapago('1');
                }else{
                     swal({
                       title: "Atencion", text: data.html+"\n Favor retornar al carrito para su edicion",
                       type: "warning",   
                       showCancelButton: true,   
                       confirmButtonColor: "#DD6B55",   
                       confirmButtonText: "Retornar al carrito!",   
                       closeOnConfirm: false 
                    }, function() {
                        window.location.href = "mi-carrito.php";
                    });
                    $.unblockUI();
              
                  for(var n in data.producto_alert) {
                    $('#alert_stock_'+data.producto_alert[n]).html("---Stock insuficiente---");
                  }
                }
            }
        });
    }
    function formapago(nro){
        var check = $('input[name=payment]:checked').val();
        document.getElementById("paramcomentario").value = document.getElementById("comentario").value;
        if(check > 0){
            if(check == 2 || check == 3 || check == 5){//pago 
                $('form[name=forma_pago_form]').submit();
            }else{
                $.ajax({
                    type: "POST",
                    url: "ajax/confirmacion",
                    data: $("#forma_pago_form").serialize(),
                    dataType: "json",
                    success: function(data){
                        console.log(data);
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
          swal("�Atencion!", "Seleccione un metodo de Pago", "warning");
        }
    }
    
    function costoEnvio(){
       /* var opcionentrega = $('input[name=opcionentrega]:checked').val();
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
        });*/
        
    }
</script>

  </body>


</html>