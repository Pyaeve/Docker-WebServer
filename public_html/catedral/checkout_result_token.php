<?php 
  include('inc/config.php');

  $order_id   = param('order');
  $order_id   = urldecode($order_id);
  $order_id   = str_replace(' ', '+', $order_id);
  $pedido_id  = Encryption::Decrypt($order_id, encryptionKey);
  $order_id   = explode('_',$pedido_id);
  $order_id   = $order_id[2];
  $regalo = strlen(param('paramregalo')) > 0 ? param('paramregalo') : ""; 
  $comentario = strlen(param('paramcomentario')) > 0 ? param('paramcomentario') : ""; 
  $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";
  $costo_envio = numParam('costo_envio');
  $producto = Productos::select(9736);
  $precio_del = $producto[0]['producto_precio'];
  $iva_del = $producto[0]['producto_precioIVA'];
  $precio_del_iva = $precio_del + $iva_del;
  $tarjeta = param('tarj');
  #Si ya existe que no vuelva a refrescar y enviar los datos
  $ver = Contraentrega::select($order_id);
  if($ver[0]['contraentrega_pago'] == 1){
    header("Location:productos.php");
  }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <? include("inc/head.php")?>  
    <title>Catedral</title>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
        <style type="text/css">
            .nro{
                width: 15%;
            }
            .table, .table th{ text-align: center} 
        </style>

 <div id="all" style="">
        <div id="content">
            <div class="container">               
                <div class="col-md-12" id="basket">

                    <div class="box">     
                            <?php 
                            if($ver[0]['contraentrega_status'] == 2 ){
                              $payment_response = Payment_response::response($order_id);
                              if(is_array($payment_response)):

                                $response = json_decode($payment_response['response_text']);
                                $shop_process_id = $response->confirmation->shop_process_id;
                                $amount = $response->confirmation->amount;
                                $currency = $response->confirmation->currency;
                                $ticket_number = $response->confirmation->ticket_number;
                                $response_description = $response->confirmation->response_description;
                                $token = md5($private_key . $shop_process_id . "get_confirmation");
                                  

                                $confirmation = array(
                                    "public_key" => $public_key,
                                    "operation" => array(
                                      "token" => $token,
                                      "shop_process_id" => $shop_process_id
                                    )
                                );
                                
                                $session = curl_init($confirmations_url);
                                curl_setopt($session, CURLOPT_POST, 1);
                                curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($confirmation));
                                curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                                $session_response = curl_exec($session);
                                curl_close($session);
                                

                                if($response->confirmation->response_code == "00"){
                                    $pedidos_data = Contraentrega::select($order_id);

                                    if(haveRows($pedidos_data)){
                                        $detalles_data = Contraentrega_detalle::get("contraentrega_id = {$pedidos_data[0]['contraentrega_id']}");
                                        $cliente = Clientes::select($_SESSION['cliente']['cliente_id']);
                                        
                                        if(haveRows($detalles_data)):
                                            $listado = '';
                                            $total = 0;
                                            $envio = 0;
                                            $ws_articulos = "";
                                            #Listado de productos
                                            foreach($detalles_data as $rs){
                                                $detalle_precio   = number_format($rs['producto_precio'],0,'','.');
                                                $precioXcantidad  = $rs['producto_precio']*$rs['detalle_cantidad'];
                                                $detalle_subtotal = number_format($precioXcantidad,0,'','.');
                                                $producto = Productos::select($rs['producto_id']);
                        
                                                $total += $precioXcantidad;
                                                $listado.='<tr>
                                                  <td align="left">'.$producto[0]["producto_nombre"].'</td>
                                                  <td align="center">'.$producto[0]["producto_codigo"].'</td>
                                                  <td align="center">'.number_format($producto[0]['producto_precio'],0,"",".").'</td>
                                                  <td align="center">'.$rs['detalle_cantidad'].'</td>
                                                  <td align="right">Gs. '.number_format($precioXcantidad,0,"",".").'</td>
                                                </tr>';
                                                
                                                $ws_articulos.='{
                                                    "Cantidad" : "'.$rs["detalle_cantidad"].'",
                                                    "Cod_articulo" : "'.$producto[0]["producto_codigo"].'",
                                                    "Precio" : "'.$producto[0]["producto_precio"].'"
                                                },'; 
                                            }
                                            
                                            #------ENVIO---FARMACIA CATEDRAL------#
                                                $nombre =  explode(" ", $cliente[0]['cliente_nombre']);
                                                $apellido = explode(" ", $cliente[0]['cliente_apellido']);
                                                $ruc = $cliente[0]['cliente_ruc'];
                                                $ci = $cliente[0]['cliente_cedula'];
                                                $ws_articulos = substr($ws_articulos, 0, -1);
                                                //F = personaa fisica J = empresa
                                                $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";
                                                
                                                #Opcion de Entrega: 1:Delivery  2:Retiro de sucursal
                                                $tipo_entrega = $pedidos_data[0]['contraentrega_delivery'] == 1 ? "DELI" : "SUC" ;
                                                
                                                $fecha_entrega = date('d/m/Y H:i');//$pedidos_data[0]['contraentrega_horario'];
                                                
                                                #Obtener las direcciones
                                                $direcciones = Direcciones::select($pedidos_data[0]['direccion_id']);
                                                
                                                #Obtener la sucursal
                                                if($pedidos_data[0]['contraentrega_delivery'] == 1){
                                                    $sucursal_cod = Sucursales::select($direcciones[0]['sucursal_id']);
                                                }else{
                                                    $sucursal_cod = Sucursales::select($pedidos_data[0]['sucursal_id']);
                                                } 
                                                
                                                $sucursal_cod = $sucursal_cod[0]['sucursal_codigo'];
                                                $deposito = $sucursal_cod > 0 ? $sucursal_cod : 7;
                                                
                                             
                                                
                                                $denominacion =  $direcciones[0]['direccion_denominacion'];
                                                $direccion_ciudad = $direcciones[0]['direccion_ciudad'];
                                                $nrocasa = strlen($direcciones[0]['direccion_nrocasa']) > 0 ? " nro".$direcciones[0]['direccion_nrocasa'] : "";
                                                $direccion = $direcciones[0]['direccion_direccion'].$nrocasa;
                                                $celular = $direcciones[0]['direccion_tel'];

                                                $mapa = explode(",", $direcciones[0]['direccion_mapa']);
                                                $latitud = $mapa[0];
                                                $longitud = $mapa[1];
                                                $localizacion = $direcciones[0]['direccion_mapa'].", ".$direccion_ciudad;
                                                //////////////////////////////////////////////////////////////////////////////
                                                
                                                $sucursal_id = $pedidos_data[0]['sucursal_id'];
                                                if($sucursal_id > 0){

                                                  $sucursal = Sucursales::select($sucursal_id);
                                                  $_POST['sucursal_id'] = $sucursal[0]['sucursal_id'];
                                                  $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
                                                  
                                                  $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
                                                  /*if(haveRows($ciudad)){
                                                      $costoenvio = 0;//$ciudad[0]['costo_envio'];
                                                  }else{
                                                      $costoenvio = 0;//'6000';
                                                  }*/
                                                  
                                                }else if($_POST['sucursal_id'] > 0 ){
                                                     $sucursal = Sucursales::select($sucursal_id);
                                                     $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
                                                }else{
                                                  //$_POST['sucursal_id'] = 1;
                                                  $sucursal_codigo = 7;
                                                }
                                                $delivery = $pedidos_data[0]['contraentrega_delivery'];
                                                if($delivery == 1){
                                                  $deliveryWs = $precio_del;//$costoenvio - $porcentaje;
                                                  $ws_articulos.=',{
                                                    "Cantidad" : "1",
                                                    "Cod_articulo" : "42593",
                                                    "Precio" : "'.$deliveryWs.'"
                                                  }';
                                                }
                                                #Si seleccino Contraentrega: opcion de pago Efectivo: 1 / POS: 2 / Cred: >=3
        
                                                if($_POST['contraentrega_opcion'] >= 3){
                                                    $Metodo_Pago = "CRED"; 
                                                    $Estado_Pago = "PAG";
                                                    $Forma_Pago = $_POST['contraentrega_opcion'];
                                                }else{
                                                    $Metodo_Pago = $_POST['contraentrega_opcion'] == 2 ? "TARJ" : "CONT";
                                                    $Estado_Pago = "PEND";
                                                    $Forma_Pago = 0;
                                                }

                                                //ACTUALIZAR campo de ws
                                                $productos_pedido = Contraentrega_detalle::get("contraentrega_id = ".$pedidos_data[0]['contraentrega_id'],"");
                                                foreach ($productos_pedido as $pr_pd){
                                                    if(haveRows($pr_pd)){
                                                        
                                                        $prod = Productos::get("producto_id = ".$pr_pd["producto_id"],"");

                                                        #Retorna el stock de la sucursal seleccionada
                                                        $ws = ws_stockVal($prod[0]['producto_codigo'], $disponibilidad, $deposito);

                                                        $_POST['contraentrega_id']    = $pr_pd["contraentrega_id"];
                                                        $_POST['producto_id']         = $pr_pd["producto_id"];
                                                        $_POST['producto_nombre']     = $pr_pd["producto_nombre"];
                                                        $_POST['producto_precio']     = $pr_pd["producto_precio"]; //precio Unitario
                                                        $_POST['detalle_cantidad']    = $pr_pd["detalle_cantidad"];
                                                        $_POST['detalle_cantidad_ws'] = $ws;
                                                        $_POST['detalle_monto']       = $pr_pd["detalle_monto"];
                                                        $_POST['detalle_status']      = $pr_pd["detalle_status"];
                                                        $detalle_id = Contraentrega_detalle::save($pr_pd["detalle_id"]);

                                                    }
                                                }

                                                /////////////////////////////////////////////////////
                                                /*"usuario" :"ECO",
                                                    "pass" :"@DMIN",*/

                                                $dataWs = '{
                                                    "usuario" :"ECO",
                                                    "pass" :"@DMIN",
                                                        "pedidos" : {
                                                            "ArticulosItem" :['.$ws_articulos.'],
                                                            "Pedido":{
                                                                "CI" : "'.$ci.'",
                                                                "IdPedido": "'.$order_id.'",
                                                                "Primer_Apellido": "'.$apellido[0].'",
                                                                "Primer_Nombre": "'.$nombre[0].'",
                                                                "Ruc": "'.$ruc.'",
                                                                "Segundo_Apellido" : "'.$apellido[1].'",
                                                                "Segundo_Nombre" : "'.$nombre[1].'",
                                                                "Tipo" : "'.$cliente_tipo.'",
                                                                "Metodo_Pago" : "TARJ",
                                                                "Estado_Pago" : "PAG",
                                                                "Deposito" : "'.$deposito.'",
                                                                "Fecha_Entrega" : "'.$fecha_entrega.'",
                                                                "Direccion" : "'.$direccion.'",
                                                                "Tipo_Entrega" : "'.$tipo_entrega.'",
                                                                "Telefono" : "'.$celular.'",
                                                                "Nombre_Direccion" : "'.$denominacion.'",
                                                                "Localizacion" : "'.$localizacion.'",
                                                                "latitud" : "'.$latitud.'",
                                                                "longitud" : "'.$longitud.'",            
                                                                "ciudad"    :   "'.$direccion_ciudad.'",
                                                                "forma_pago" : "'.$Forma_Pago.'",
                                                                "comentario" : "'.$comentario.'",
                                                                "regalo"    :   "'.$regalo.'"
                                                            }
                                                        }
                                                }';
                                                try {
                                                    //se actualiza campo body_raw para poder reenviar pedido desde administrador
                                                    Contraentrega::set('body_raw',$dataWs,"contraentrega_id = {$order_id}");
                                                } catch (ParseError $p) {
                                                    $p->getMessage();
                                                    //se actualiza campo body_raw con error.
                                                    Contraentrega::set('body_raw',$p,"contraentrega_id = {$order_id}");
                                                }
                                                /////////////////////////////////////////////////////
                                                $session = curl_init($ecommerce_url_cate);
                                                curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
                                                curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
                                                curl_setopt($session, CURLOPT_POST, true); 
                                                curl_setopt($session, CURLOPT_POSTFIELDS, $dataWs); 
                                                curl_setopt($session, CURLOPT_HEADER, false); 
                                                curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
                                                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                                                $session_response = curl_exec($session);
                                                curl_close($session);
                                                $response = json_decode($session_response);
                                                $salida   = $response->salida;
                                                $cont= strlen($salida);
                                                //envio de correo si web service no responde correcto
                                                if(trim($salida)<>"Correcto" || $cont < 1){

                                                    #------DATOS---PARA EL EMAIL ------#
                                                    $from = array("noresponder@catedral.com" => "Catedral");
                                                    $to = array(
                                                        "danielgaleano884@gmail.com" => "Catedral"
                                                    );
                                                    
                                                    $data = array();
                                                    $data['fecha']  = date('d/m/Y H:i:s');

                                                    $data['cliente'] =  $pedidos_data[0]['cliente_nombres'];
                                                    $data['ruc']    =   $cliente[0]['cliente_ruc'];
                                                    $data['cliente_telefono'] =  $cliente[0]['cliente_telefono'];                                              
                                                    $data['cliente_email'] =  $cliente[0]['cliente_email'];
                                                    $data['tipopago']   = $pedidos_data[0]['contraentrega_formapago'] == 1 ? "Contraentrega" : "Tarjeta de credito";

                                                    $data['cliente_ciudad'] =  $pedidos_data[0]['cliente_ciudad'];
                                                    $data['listado'] = $listado;
                                                    #Opcion de Entrega: 1:Delivery  2:Retiro de sucursal
                                                    if($pedidos_data[0]['contraentrega_delivery'] == 1){ #Para envio via delivery
                                                        #enviar datos de la direccion de entrega por email
                                                        $direcciones = Direcciones::select($pedidos_data[0]['direccion_id']);
                                                        $data['cliente_direccion'] = $direcciones[0]['direccion_direccion'];
                                                        $data['cliente_ciudad'] = $direcciones[0]['direccion_ciudad'];
                                                        $data['cliente_telefono'] =  $direcciones[0]['direccion_tel'];
                                                    
                                                        $sucursal_nombre = Sucursales::select($direcciones[0]['sucursal_id']);
                                                        
                                                        $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
                                                        $data['deposito'] = "<tr><td>Sucursal</td><td>".$sucursal_nombre."</td></tr>";      

                                                        $data['local'] = '<p style="margin-bottom: 0; font-size: 14px;"><b>Tipo de entrega:</b> Delivery</p>';
                                                        $template = "pedido_template.html";
                                                        #Costo de envio
                                                        
                                                        $sucursal_id = $pedidos_data[0]['sucursal_id'];
                                                        $sucursal = Sucursales::select($sucursal_id);
                                                        
                                                        $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
                                                        /*if(haveRows($ciudad)){
                                                            $costoenvio = 0;//$ciudad[0]['costo_envio'];
                                                        }else{
                                                            $costoenvio = 0;//'6000';
                                                        }*/
                            
                                                    }else{#Tipo 2: retiro de la sucursal 
                                                        $sucursal_id = $pedidos_data[0]['sucursal_id'];
                                                        $sucursal = Sucursales::select($sucursal_id);
                                                        $sucursal_nombre = $sucursal[0]['sucursal_nombre'];
                                                        if(haveRows($sucursal)){
                                                            $data['local'] = "<tr><td><b>Retiro de la sucursal:</b></td><td>".$sucursal_nombre."</td></tr>";
                                                        }
                                                        $template = "pedido_sucursal_template.html";
                                                        $costoenvio = NULL;
                                                    }
                                                    
                                                    $totalPrecio  = $total;//Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
                                                    $subtotal =  number_format($totalPrecio,0,'','.');
                                                    
                                                    


                                                    $data['costoenvio'] = $precio_del_iva;
                                                    if($pedidos_data[0]['contraentrega_delivery'] == 1){#Para envio via delivery
                                                        $totalCosto = number_format($precio_del_iva+$totalPrecio,0,'','.');
                                                    }else{#Tipo 2: retiro de la sucursal 
                                                        $totalCosto = number_format($totalPrecio,0,'','.');
                                                    }
                                                    //$totalCosto = number_format($costoenvio+$totalPrecio,0,'','.');
                                                    $data['subtotal'] =  $subtotal;
                                                    $data['total'] =  $totalCosto;
                                                    $data["pedido"] =  $order_id;
                                                    
                                                    //$subject = "Detalles de la Compra - Catedral.com.py";
                                                    $subject = "Ecommerce - Error al procesar venta: $salida ";
                                                    Mail::send($from, $to, $subject, $template, $data);

                                                }
                                                
                                            
                                            #------DATOS---PARA EL EMAIL ------#
                                                $from = array("noresponder@catedral.com" => "Catedral");
                                                $email = strlen($cliente[0]['cliente_email']) > 0 ? $cliente[0]['cliente_email'] : "";
                                                $to = array(
                                                     $email => "Catedral" 
                                                );
                                                
                                                $data = array();
                                                $data['fecha']  = date('d/m/Y H:i:s');

                                                $data['cliente'] =  $pedidos_data[0]['cliente_nombres'];
                                                $data['ruc']    =   $cliente[0]['cliente_ruc'];
                                                $data['cliente_telefono'] =  $cliente[0]['cliente_telefono'];                                              
                                                $data['cliente_email'] =  $cliente[0]['cliente_email'];
                                                $data['tipopago']   = $pedidos_data[0]['contraentrega_formapago'] == 1 ? "Contraentrega" : "Tarjeta de credito";

                                                $data['cliente_ciudad'] =  $pedidos_data[0]['cliente_ciudad'];
                                                $data['listado'] = $listado;
                                                 #Opcion de Entrega: 1:Delivery  2:Retiro de sucursal
                                                if($pedidos_data[0]['contraentrega_delivery'] == 1){ #Para envio via delivery
                                                    #enviar datos de la direccion de entrega por email
                                                    $direcciones = Direcciones::select($pedidos_data[0]['direccion_id']);
                                                    $data['cliente_direccion'] = $direcciones[0]['direccion_direccion'];
                                                    $data['cliente_ciudad'] = $direcciones[0]['direccion_ciudad'];
                                                    $data['cliente_telefono'] =  $direcciones[0]['direccion_tel'];
                                                   
                                                    $sucursal_nombre = Sucursales::select($direcciones[0]['sucursal_id']);
                                                    
                                                    $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
                                                    $data['deposito'] = "<tr><td>Sucursal</td><td>".$sucursal_nombre."</td></tr>";      

                                                    $data['local'] = '<p style="margin-bottom: 0; font-size: 14px;"><b>Tipo de entrega:</b> Delivery</p>';
                                                    $template = "pedido_template.html";
                                                    #Costo de envio
                                                    
                                                    $sucursal_id = $pedidos_data[0]['sucursal_id'];
                                                    $sucursal = Sucursales::select($sucursal_id);
                                                    
                                                    /*$ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
                                                    if(haveRows($ciudad)){
                                                        $costoenvio = 0;//$ciudad[0]['costo_envio'];
                                                    }else{
                                                        $costoenvio = 0;//'6000';
                                                    }*/
                        
                                                }else{#Tipo 2: retiro de la sucursal 
                                                    $sucursal_id = $pedidos_data[0]['sucursal_id'];
                                                    $sucursal = Sucursales::select($sucursal_id);
                                                    $sucursal_nombre = $sucursal[0]['sucursal_nombre'];
                                                    if(haveRows($sucursal)){
                                                        $data['local'] = "<tr><td><b>Retiro de la sucursal:</b></td><td>".$sucursal_nombre."</td></tr>";
                                                    }
                                                    $template = "pedido_sucursal_template.html";
                                                    $costoenvio = NULL;
                                                }
                                                
                                                $totalPrecio  = $total;//Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
                                                $subtotal =  number_format($totalPrecio,0,'','.');
                                                
                                                $data['costoenvio'] = $precio_del_iva;//$costoenvio;
                                                if($pedidos_data[0]['contraentrega_delivery'] == 1){#Para envio via delivery
                                                    $totalCosto = number_format($precio_del_iva+$totalPrecio,0,'','.');
                                                }else{#Tipo 2: retiro de la sucursal 
                                                    $totalCosto = number_format($totalPrecio,0,'','.');
                                                }
                                                
                                                $data['subtotal'] =  $subtotal;
                                                $data['total'] =  $totalCosto;
                                                $data["pedido"] =  $order_id;
                                                
                                                $subject = "Detalles de la Compra - Catedral.com.py";
                                                
                                                #Vaciar carrito
                                                Carrito::emptyCart($cliente[0]['cliente_id']);
                                                //$data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";
                                                Mail::send($from, $to, $subject, $template, $data);
                                                Contraentrega::set('contraentrega_pago',1,"contraentrega_id = {$order_id}");
                                    
                                        endif;
                                    }
                                    

                                    #########################################################################################################
                                    ?>
                                    <h1 class="text-center mt-3 display-7">Confirmación de Compra</h1>
                                    <div class="table-responsive">
                                      <h2 class="text-center display-7">MUCHAS GRACIAS POR TU COMPRA</h2>
                                      <div style="border-radius:10px; margin: 35px 0; padding: 10px; border: 2px solid #0f3b84;">
                                          <p style="line-height:22px;">
                                            <strong style="border-bottom:1px solid #C8C7C7; text-align:center; padding-bottom:4px; float:left; width:100%;">SU PAGO FUE PROCESADO CORRECTAMENTE</strong><br><br>
                                            <strong style="border-bottom:1px solid #C8C7C7; text-align:center; padding-bottom:4px; float:left; width:100%;">El procesador de la tarjeta de crédito retornó el siguiente mensaje:</strong><br><br>
                                            <?php echo $response_description; ?><br><br>
                                            Fecha/Hora de proceso: <span style="color:#000 !important; font-weight:bold !important;"><?php echo date("d/m/Y H:i", strtotime($payment_response['response_timestamp'])); ?></span>.<br />
                                            Numero de pedido: <span style="color:#000 !important; font-weight:bold !important;"><?php echo $order_id; ?></span>.<br />
                                            Ticket No: <span style="color:#000 !important; font-weight:bold !important;"><?php echo $ticket_number; ?></span>.<br />
                                            Monto: Gs. <span style="font-weight:bold !important;"><?php echo number_format($amount,0,",","."); ?></span>
                                          </p>
                                      </div>
                                    </div>
                                    <p class="text-center mt-3 display-7">En un momento recibirás un email con el detalle de tu compra.<br />Muchas Gracias!</p>
                                    <div class="col-auto mbr-section-btn align-center">
                                        <a href="./" class="btn btn-primary display-4">Inicio</a>
                                    </div>
                                    <?php
                                        # 1-Pendiente
                                        # 2-Confirmado
                                        # 3-Rechazado
                                        Contraentrega::set('contraentrega_status',2,"contraentrega_id = {$order_id}");
                                }else{# End pago-exitoso
                                    ?>
                                    <h2>EL PAGO NO FUE PROCESADO</h2>
                                    <div style="border-radius:10px;background:#F5E6AE; padding: 10px;">
                                    <p style="line-height:22px;"><strong style="border-bottom:1px solid #C8C7C7; text-align:center; padding-bottom:4px; float:left; width:100%;">
                                      El procesador de la tarjeta de crédito retornó el siguiente mensaje:</strong><br><br>
                                      <?php echo $response_description; ?><br>
                                      Numero de pedido: <span style="color:#000 !important; font-weight:bold !important;"><?php echo $order_id ?></span>.<br />
                                      Fecha/Hora de proceso: <span style="color:#000 !important; font-weight:bold !important;"><?php echo date("d/m/Y H:i", strtotime($payment_response['response_timestamp'])) ?></span>.<br />
                                      Monto: Gs. <span style="font-weight:bold !important;"><?php echo number_format($amount,0,",",".") ?></span>
                                    </p>
                                    <div class="col-auto mbr-section-btn align-center">
                                        <a href="./" class="btn btn-primary display-4">Inicio</a>
                                    </div>
                                    <?php
                                        if($order_id > 0):
                                            Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$order_id}");
                                   			$token = md5($private_key . $order_id . "rollback" . "0.00");
                                
                                			$data = array(
                                				"public_key" => $public_key,
                                				"operation"	 => array(
                                					"token"				=> $token,
                                					"shop_process_id"	=> $order_id
                                				),
                                			);
                                
                                			$session = curl_init($rollback);
                                			curl_setopt($session, CURLOPT_POST, 1);
                                            curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
                                            curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                                            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                                			$session_response = curl_exec($session);
                                			curl_close($session);
                                
                                			//return $response = json_decode($session_response);
                                    	endif;
             
                                }
                              else:
                                  if($_GET['status'] == "payment_fail"){
                                    if(haveRows($ver)){
                                        echo '<p style="text-align:center; font-size:16px; font-weight:bold; margin:20px 0; padding:10px; border-radius:6px; background:#FFCB20;">El pedido fue anulado</p><p class="aligncenter"><a href="./" class="boton">Volver al inicio</a></p>';

                                        if($order_id > 0){
                                            Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$order_id}");
                                            $token = md5($private_key . $order_id . "rollback" . "0.00");
                                
                                			$data = array(
                                				"public_key" => $public_key,
                                				"operation"	 => array(
                                					"token"				=> $token,
                                					"shop_process_id"	=> $order_id
                                				),
                                			);
                                
                                			$session = curl_init($rollback);
                                			curl_setopt($session, CURLOPT_POST, 1);
                                            curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
                                            curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                                            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                                			$session_response = curl_exec($session);
                                			curl_close($session);
                                        }
                                    }     
                                  }
                                 
                              endif;

                              if(isset($_GET['action'])){ //SI SE CANCELA LA COMPRA

                                  if($_GET['action'] == "cancel"){
                                      echo '<p style="text-align:center; font-size:16px; font-weight:bold; margin:20px 0; padding:10px; border-radius:6px; background:#FFCB20;">El pedido fue anulado</p><p class="aligncenter"><a href="./" class="boton">Volver al inicio</a></p>';
                                        # 1-Pendiente
                                        # 2-Confirmado
                                        # 3-Rechazado
                                        if($order_id > 0){
                                            Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$order_id}");
                                            $token = md5($private_key . $order_id . "rollback" . "0.00");
                                
                                			$data = array(
                                				"public_key" => $public_key,
                                				"operation"	 => array(
                                					"token"				=> $token,
                                					"shop_process_id"	=> $order_id
                                				),
                                			);
                                
                                			$session = curl_init($rollback);
                                			curl_setopt($session, CURLOPT_POST, 1);
                                            curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
                                            curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                                            curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                                			$session_response = curl_exec($session);
                                			curl_close($session);
                                        }

                                  }else{
                                      echo '<p style="text-align:center; font-size:16px; font-weight:bold; margin:20px 0; padding:10px; border-radius:6px; background:#FFCB20;">
                                        Número de pedido incorrecto</p><p class="aligncenter"><a href="./" class="boton">Volver al inicio</a>
                                        </p>';
                                  }

                              }
                              

                            }else{
                                $payment_response = Payment_response::response($order_id);
                                if(is_array($payment_response)){

                                $response = json_decode($payment_response['response_text']);
                                $shop_process_id = $response->confirmation->shop_process_id;
                                $amount = $response->confirmation->amount;
                                $currency = $response->confirmation->currency;
                                $response_description = $response->confirmation->response_description;
                                }
                                echo '<p style="text-align:center; font-size:16px; font-weight:bold; margin:20px 0; padding:10px; border-radius:6px; background:#FFCB20;">
                                Datos ya procesados, '.$response_description.'</p><p class="aligncenter"><a href="./" class="boton">Volver al inicio</a>
                                </p>';
                                if($order_id > 0){
                                    Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$order_id}");
                                    $token = md5($private_key . $order_id . "rollback" . "0.00");
                        
                        			$data = array(
                        				"public_key" => $public_key,
                        				"operation"	 => array(
                        					"token"				=> $token,
                        					"shop_process_id"	=> $order_id
                        				),
                        			);
                        
                        			$session = curl_init($rollback);
                        			curl_setopt($session, CURLOPT_POST, 1);
                                    curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
                                    curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                                    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                        			$session_response = curl_exec($session);
                        			curl_close($session);
                                }

                            }

                            ?>


                    </div>
                    <!-- /.box -->

                </div>
                <!-- /.col-md-9 -->
                   

                </div>
                <!-- /.col-md-3 -->

            </div>
            <!-- /.container -->
        </div>
        <!-- /#content -->
</div>

  <!-- FOOTER -->
    <?php include('inc/footer.php'); ?>
    <!-- TERMINA FOOTER -->

</body>
</html>

