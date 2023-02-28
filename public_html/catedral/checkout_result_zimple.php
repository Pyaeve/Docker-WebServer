<?php 
  include('inc/config.php');

  $order_id   = param('order');
  $order_id   = urldecode($order_id);
  $order_id   = str_replace(' ', '+', $order_id);
  $pedido_id  = Encryption::Decrypt($order_id, encryptionKey);
  $order_id   = explode('_',$pedido_id);
  $order_id   = $order_id[2];
  #Si ya existe que no vuelva a refrescar y enviar los datos
  $ver = Contraentrega::select($order_id);
  /*if($ver[0]['contraentrega_status'] == 2){
      header("Location:productos.php");
  }*/
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <? include("inc/head.php")?>  
    <title>Catedral</title>
</head>
<body>
<? 
    require_once('inc/header.php'); 
    require_once('inc/nav.php'); 

?>
        <style type="text/css">
            .nro{
                width: 15%;
            }
            .table, .table th{ text-align: center} 
        </style>

 <div id="all">
        <div id="content">
            <div class="container">               
                <div class="col-md-12" id="basket">

                    <div class="box">     
                            <?php 
                                
                                    $pedidos_data = Contraentrega::select($order_id);
                                    if(haveRows($pedidos_data)){
                                        $detalles_data = Contraentrega_detalle::get("contraentrega_id = {$pedidos_data[0]['contraentrega_id']}");
                                        $cliente = Clientes::select($_SESSION['cliente']['cliente_id']);
                                        
                                        if(haveRows($detalles_data)):
                                            $listado = '';
                                            $total = 0;
                                            $envio = 0;
                                            $ws_articulos = "";
                                            
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
                                            #------ENVIO---FC------#
                                            $nombre =  explode(" ", $cliente[0]['cliente_nombre']);
                                            $apellido = explode(" ", $cliente[0]['cliente_apellido']);
                                            $ruc = $cliente[0]['cliente_ruc'];
                                            $ci = $cliente[0]['cliente_cedula'];
                                            $ws_articulos = substr($ws_articulos, 0, -1);
                                            //F = personaa fisica J = empresa
                                            $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";

                                            $tipo_entrega = $pedidos_data[0]['contraentrega_delivery'] == 1 ? "DELI" : "SUC" ;
                                            $fecha_entrega = date('d/m/Y H:i');//$pedidos_data[0]['contraentrega_horario'];

                                            #Obtener la sucursal
                                            $sucursal_cod = Sucursales::select($pedidos_data[0]['sucursal_id']);
                                            $sucursal_cod = $sucursal_cod[0]['sucursal_codigo'];
                                            $deposito = $sucursal_cod > 0 ? $sucursal_cod : 7;
                                            #Obtener las direcciones
                                            $direcciones = Direcciones::select($pedidos_data[0]['direccion_id']);
                                            $denominacion =  $direcciones[0]['direccion_denominacion'];
                                            $direccion_ciudad = $direcciones[0]['direccion_ciudad'];
                                            $nrocasa = strlen($direcciones[0]['direccion_nrocasa']) > 0 ? " nro".$direcciones[0]['direccion_nrocasa'] : "";
                                            $direccion = $direcciones[0]['direccion_direccion'].$nrocasa;
                                            $celular = $direcciones[0]['direccion_tel'];

                                            $mapa = explode(",", $direcciones[0]['direccion_mapa']);
                                            $latitud = $mapa[0];
                                            $longitud = $mapa[1];
                                            $localizacion = $mapa.", ".$direccion_ciudad;
                                            $metodo_pago = $pedidos_data[0]['contraentrega_formapago'];
                                            switch ($metodo_pago) {
                                                case 1:
                                                    $MetodoPago = "CONT";
                                                break;
                                                case 2:
                                                    $MetodoPago = "TARJ";
                                                break;
                                                case 3:
                                                    $MetodoPago = "ZIMPLE";
                                                break;
                                            }
                                            
                                            //////////////////////////////////////////////////////////////////////////////
                                                $sucursal_id = $pedidos_data[0]['sucursal_id'];
                                                if($sucursal_id > 0){

                                                  $sucursal = Sucursales::select($sucursal_id);
                                                  $_POST['sucursal_id'] = $sucursal[0]['sucursal_id'];
                                                  $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
                                                  
                                                  $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
                                                  if(haveRows($ciudad)){
                                                      $costoenvio = 0;//$ciudad[0]['costo_envio'];
                                                  }else{
                                                      $costoenvio = 0;//'6000';
                                                  }
                                                  
                                                }else if($_POST['sucursal_id'] > 0 ){
                                                     $sucursal = Sucursales::select($sucursal_id);
                                                     $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
                                                }else{
                                                  //$_POST['sucursal_id'] = 1;
                                                  $sucursal_codigo = 7;
                                                }
                                                $delivery = $pedidos_data[0]['contraentrega_delivery'];
                                                /*if($delivery == 1){
                                                  $porcentaje = $costoenvio * 10 / 100;
                                                  $deliveryWs = $costoenvio - $porcentaje;
                                                  $ws_articulos.=',{
                                                    "Cantidad" : "1",
                                                    "Cod_articulo" : "42593",
                                                    "Precio" : "'.$deliveryWs.'"
                                                  }';
                                                }*/
                                            /////////////////////////////////////////////////////
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
                                                            "Metodo_Pago" : "'.$MetodoPago.'",
                                                            "Estado_Pago" : "PEND",
                                                            "Deposito" : "'.$deposito.'",
                                                            "Fecha_Entrega" : "'.$fecha_entrega.'",
                                                            "Direccion" : "'.$direccion.'",
                                                            "Tipo_Entrega" : "'.$tipo_entrega.'",
                                                            "Telefono" : "'.$celular.'",
                                                            "Nombre_Direccion" : "'.$denominacion.'",
                                                            "Localizacion" : "'.$localizacion.'",
                                                            "latitud" : "'.$latitud.'",
                                                            "longitud" : "'.$longitud.'",            
                                                            "ciudad"    :   "'.$direccion_ciudad.'"
                                                        }
                                                    }
                                            }';

                                     
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
                                      
                                            #Ver respuesta del sistema de Catedral
                                            //$response = json_decode($session_response);
                                            
                                            #Datos para email
                                            $from = array("noresponder@catedral.com" => "Catedral");
                                            $email = strlen($cliente[0]['cliente_email']) > 0 ? $cliente[0]['cliente_email'] : "";
                                            $to = array(
                                                "diego.amarilla@puntopy.com"=>"Catedral", 
                                                "sergio@sucursaldigital.com " => "Catedral",
                                                $email => "Catedral" );
                                            
                                            $data = array();
                                            $data['fecha']  = date('d/m/Y H:i:s');
                    
                                            $data['cliente'] =  $pedidos_data[0]['cliente_nombres'];
                                            $data['cliente_direccion'] =  $pedidos_data[0]['cliente_direccion'];
                                            $data['cliente_telefono'] =  $pedidos_data[0]['cliente_telefono'];
                                            $data['cliente_email'] =  $cliente[0]['cliente_email'];
                                            $data['cliente_ciudad'] =  $pedidos_data[0]['cliente_ciudad'];
                                            $data['cliente_barrio'] = $pedidos_data[0]['cliente_barrio'];
                                            $data['listado'] = $listado;
                                            $data['costoenvio'] = $envio;
                                            $total_final =  $total + $envio;
                                            $data['total'] = number_format($total_final,0,"",".");
                                            
                                            $subject = "Detalles de la Compra - Catedral.com.py";
      
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
                                                    if(haveRows($ciudad)){
                                                        $costoenvio = $ciudad[0]['costo_envio'];
                                                    }else{
                                                        $costoenvio = '6000';
                                                    }
                    
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

                                                $totalPrecio  = Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
                                                $subtotal =  number_format($totalPrecio,0,'','.');
                                                
                                                $data['costoenvio'] = $costoenvio;
                                                $totalCosto = number_format($costoenvio+$totalPrecio,0,'','.');
                                                $data['subtotal'] =  $subtotal;
                                                $data['total'] =  $totalCosto;
                                                $data["pedido"] =  $order_id;
                                            Mail::send($from, $to, $subject, $template, $data);
                                    
                                        endif;
                            
                                    

                                    #########################################################################################################
                                    ?>
                                    <h1 class="text-center mt-3 display-7">Solicitud de Pago Billetera Zimple</h1>
                                    <div class="table-responsive">
                                      <!--<h2 class="text-center display-7">MUCHAS GRACIAS POR TU COMPRA</h2>-->
                                      <div style="border-radius:10px; margin: 35px 0; padding: 10px; border: 2px solid #0f3b84;">
                                          <p style="line-height:22px;">
                                            <strong style="border-bottom:1px solid #C8C7C7; text-align:center; padding-bottom:4px; float:left; width:100%;">
                                                El procesador de la tarjeta de crédito retornó el siguiente mensaje:</strong><br><br>
                         
                                            Fecha/Hora de proceso: <span style="color:#000 !important; font-weight:bold !important;">
                                                <?php echo date("d/m/Y H:i", strtotime($pedidos_data[0]['contraentrega_timestamp'])); ?></span>.<br />
                                            Numero de pedido: <span style="color:#000 !important; font-weight:bold !important;"><?php echo $order_id; ?></span>.<br />
                                            Monto: Gs. <span style="font-weight:bold !important;"><?php echo number_format($total,0,",","."); ?></span>
                                          </p>
                                      </div>
                                    </div>
                                    <p class="text-center mt-3 display-7">En un momento recibirás un email con el detalle de tu compra.<br />Muchas Gracias!</p>
                                    <?
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

