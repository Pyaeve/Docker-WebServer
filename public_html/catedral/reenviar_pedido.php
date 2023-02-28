<?php
//require_once('../_sys/init.php');
include("inc/config.php");
  
    $pedido_id = numParam('pedido_id');
    #Obtenemos los datos del cliente
    $pedido_cabecera = Contraentrega::select($pedido_id);
    $cliente_id = $pedido_cabecera[0]['cliente_id'];
    $delivery = $pedido_cabecera[0]['contraentrega_delivery'];
    #Si seleccino Contraentrega: opcion de pago Efectivo: 1 / POS: 2
    //$Metodo_Pago = $pedido_cabecera['contraentrega_opcion'] == 2 ? "TARJ" : "CONT";
    $direccion_id = $pedido_cabecera[0]['direccion_id'];
    //echo "<h1>direccion_id: $pedido_cabecera</h1>";
    //print_r($pedido_cabecera['direccion_id']);
    #Si selecciono Contraentrega: opcion de pago Efectivo: 1 / POS: 2 / Cred: >=3
        
    if($pedido_cabecera[0]['contraentrega_opcion'] >= 3){
      $Metodo_Pago = "CRED"; 
      $Estado_Pago = "PAG";
      $Forma_Pago = $pedido_cabecera[0]['contraentrega_opcion'];
    }else{
      $Metodo_Pago = $pedido_cabecera[0]['contraentrega_opcion'] == 2 ? "TARJ" : "CONT";
      $Estado_Pago = "PEND";
      $Forma_Pago = 0;
    }



    #Preparamos para guardar en Contraentrega (deberia ser pedidos en fin)
    /*$_POST['cliente_id'] = $pedido_cabecera[0]['cliente_id'];
    $_POST['cliente_nombres'] = $pedido_cabecera[0]['cliente_nombre'];
    $_POST['cliente_email'] = $pedido_cabecera[0]['cliente_email'];
    $_POST['cliente_telefono'] = $pedido_cabecera[0]['cliente_celular'];*/


    /*#Metodo de pago utilizado
    #Op: 1: Contraentrega 2:Tarjeta  3:Zimple
    $_POST['contraentrega_formapago'] = numParam('metodo_pago');
    
    #Si seleccino Contraentrega: opcion de pago Efectivo: 1 / POS: 2
    $_POST['contraentrega_opcion'] = numParam('ContraentregaopcionPago');
    
    #Opcion de Entrega: 1:Delivery  2:Retiro de sucursal
    $_POST['contraentrega_delivery'] = numParam('opcion_entrega');
    

    #Si opcion_entrega es 1 envia a direccion Id
    #Obtenemos la direccion de envio
    $_POST['direccion_id'] = numParam('retiro_direccion_id');

    $_POST['cliente_zimple']  = param('zimpleP');
    $zimple = param('zimpleP');

    $_POST['contraentrega_formaPagoLocal'] = 0;
    $_POST['contraentrega_horario'] = 0;
    $_POST['contraentrega_status'] = 1;
    
    #Si opcion_entrega es 2 debe estar presenta retiro_de_local para obtener la Id de la sucursal
    $_POST['sucursal_id'] = numParam('retiro_de_local');
    $id_de_sucursal = numParam('retiro_de_local');
    #Nombra Carrito
    $cart_name = Carrito::get("cliente_id =".$cliente[0]['cliente_id']);
    if(haveRows($cart_name)){
      $_POST['carrito_nombre'] = $cart_name[0]['carrito_nombre'];
    }

    $_POST['carrito_id'] = $cart_name[0]['carrito_id'];
    $contraentrega_id = Contraentrega::save(0);
    if(is_array($contraentrega_id)){
        $msg = $contraentrega_id[key($contraentrega_id)];
        $result = array("status"=>"error","description"=>$msg,"type"=>key($contraentrega_id));
        echo json_encode($result);
        exit();
    }*/

    $items = Contraentrega_detalle::getItemsReenvio($pedido_id);
    $html=" ";
    $ws_articulos = "";
    if(haveRows($items)){
        foreach ($items as $item):
            //print_r($item); //cd.detalle_cantidad ,pr.producto_codigo, pr.producto_precio
            $ws_articulos.='{
              "Cantidad" : "'.$item["detalle_cantidad"].'",
             "Cod_articulo" : "'.$item["producto_codigo"].'",
              "Precio" : "'.$item["producto_precio"].'"
            },'; 
                /*if($item['producto_id']){
                $productos = Productos::get('producto_id = '.$item['producto_id']);

                $producto = $productos[0];
                $precio = porcentaje( $item['producto_precio'], $item['producto_oferta_precio']);
                $subtotal = $precio*$item['detalle_cantidad'];
                
                #Guardamos el detalle de la compra
                  $_POST['contraentrega_id']  = $contraentrega_id;
                  $_POST['producto_id']       = $producto['producto_id'];
                  $_POST['producto_nombre']   = $producto['producto_nombre'];
                  $_POST['producto_precio']   = $item['producto_precio']; //precio Unitario
                  $_POST['detalle_cantidad']  = $item['detalle_cantidad'];
                  $_POST['detalle_monto']     = $subtotal;
                  $_POST['detalle_status']    = 1;
                  $detalle_id = Contraentrega_detalle::save(0);
                  if(is_array($detalle_id)){
                      $msg = $detalle_id[key($detalle_id)];
                      $result = array("status"=>"error","description"=>$msg,"type"=>key($detalle_id));
                      echo json_encode($result);
                      exit();
                  }
                  $precioVenta = $producto['producto_precio'] + $producto['producto_precioIVA'];
                $html.='<tr>
                          <td align="left">'.$producto["producto_nombre"].'</td>
                          <td align="center">'.$producto["producto_codigo"].'</td>
                          <td align="center">'.number_format($precioVenta,0,"",".").'</td>
                          <td align="center">'.$item['detalle_cantidad'].'</td>
                          <td align="right">Gs. '.number_format($subtotal,0,"",".").'</td>
                      </tr>';
                      
		        $ws_articulos.='{
 					"Cantidad" : "'.$item["detalle_cantidad"].'",
					"Cod_articulo" : "'.$producto["producto_codigo"].'",
 					"Precio" : "'.$producto["producto_precio"].'"
 				},'; 
            }*/
        endforeach;
        
        #------DATOS DE ENVIO FARMACIA CATEDRAL------#
        #Obtenemos los datos del cliente
        $cliente = Clientes::select($cliente_id);

        $nombre =  explode(" ", $cliente[0]['cliente_nombre']);
        $apellido = explode(" ", $cliente[0]['cliente_apellido']);
        $ruc = $cliente[0]['cliente_ruc'];
        $ci = $cliente[0]['cliente_cedula'];
        //F = personaa fisica J = empresa
        $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";
        
        $ws_articulos = substr($ws_articulos, 0, -1);
               
        $tipo_entrega = $delivery == 1 ? "DELI" : "SUC" ; 

        if($direccion_id > 0){
            $direcciones = Direcciones::select($direccion_id);
            $denominacion =  $direcciones[0]['direccion_denominacion'];
            $direccion_ciudad = $direcciones[0]['direccion_ciudad'];
            $nrocasa = strlen($direcciones[0]['direccion_nrocasa']) > 0 ? " nro".$direcciones[0]['direccion_nrocasa'] : "";
            $direccion = $direcciones[0]['direccion_direccion'].$nrocasa;
            $celular = $direcciones[0]['direccion_tel'];
            $sucursal_id = $direcciones[0]['sucursal_id'];
            $mapa = explode(",", $direcciones[0]['direccion_mapa']);
            $latitud = $mapa[0];
            $longitud = $mapa[1];
            $localizacion = $direcciones[0]['direccion_mapa'].", ".$direccion_ciudad;
        }
        //////////////////////////////////
        if($sucursal_id > 0){
          $sucursal = Sucursales::select($sucursal_id);
          //$_POST['sucursal_id'] = $sucursal[0]['sucursal_id'];
          $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
          
          $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
          if(haveRows($ciudad)){
              $costoenvio = 0;//$ciudad[0]['costo_envio'];
          }else{
              $costoenvio = 0;//'6000';
          }
          
        }
        $hora_entrega = date('d/m/Y H:i');
        $deposito = $sucursal_codigo > 0 ? $sucursal_codigo : 7;
        /////////////////////////////////
        if($delivery == 1){
          $porcentajes = $costoenvio * 10 / 100;
          $deliveryWs = 0;//$costoenvio - $porcentajes;
          $ws_articulos.=',{
            "Cantidad" : "1",
            "Cod_articulo" : "42593",
            "Precio" : "'.$deliveryWs.'"
          }';
        }
  		  $dataWs = '{
      	 	"usuario" :"ECO",
      	 	"pass" :"@DMIN",
      	 		"pedidos" : {
      	 			"ArticulosItem" :['.$ws_articulos.'],
      	 			"Pedido":{
      					"CI" : "'.$ci.'",
      					"IdPedido": "'.$pedido_id.'",
      					"Primer_Apellido": "'.$apellido[0].'",
      					"Primer_Nombre": "'.$nombre[0].'",
      					"Ruc": "'.$ruc.'",
      					"Segundo_Apellido" : "'.$apellido[1].'",
      					"Segundo_Nombre" : "'.$nombre[1].'",
      					"Tipo" : "'.$cliente_tipo.'",
      					"Metodo_Pago" : "'.$Metodo_Pago.'",
      					"Estado_Pago" : "'.$Estado_Pago.'",
                "Deposito" : "'.$deposito.'",
                "Fecha_Entrega" : "'.$hora_entrega.'",
                "Direccion" : "'.$direccion.'",
                "Tipo_Entrega" : "'.$tipo_entrega.'",
                "Telefono" : "'.$celular.'",
                "Nombre_Direccion" : "'.$denominacion.'",
                "Localizacion" : "'.$localizacion.'",
                "latitud" : "'.$latitud.'",
                "longitud" : "'.$longitud.'",            
                "ciudad"    :   "'.$direccion_ciudad.'",
                "forma_pago" : "'.$Forma_Pago.'",
                "comentario" : "",
                "regalo"    :   "N"
      	 			}
      			}
      	}';

        /*try {
          //se actualiza campo body_raw para poder reenviar pedido desde administrador
          Contraentrega::set('body_raw',$dataWs,"contraentrega_id = {$contraentrega_id}");
        } catch (ParseError $p) {
          $p->getMessage();
          //se actualiza campo body_raw con error.
          Contraentrega::set('body_raw',$p,"contraentrega_id = {$contraentrega_id}");
        }*/
        
        //if($cliente[0]['cliente_id'] != 5){
          	$session = curl_init($ecommerce_url_cate);
          	curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
          	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
          	curl_setopt($session, CURLOPT_POST,	true); 
          	curl_setopt($session, CURLOPT_POSTFIELDS, $dataWs); 
          	curl_setopt($session, CURLOPT_HEADER, false); 
          	curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
          	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
          	$session_response = curl_exec($session);
          	curl_close($session);
          	$response = json_decode($session_response);
            $salida   = $response->salida;
        //}
        echo "<h3> Resultado: ".$salida."</h3>";
        echo '<a href="../backend/" class="btn-action glyphicons chevron-left btn-success"> ◀ Volver<i></i></a>';

      	
    }

      

?>
