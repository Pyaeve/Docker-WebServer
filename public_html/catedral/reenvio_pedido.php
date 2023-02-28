<?php
require_once('_sys/init.php');
    $cliente = Clientes::select(902);
    $contraentrega = Contraentrega::select(535);
    $items = Contraentrega_detalle::get("contraentrega_id = 535");
    $ws_articulos = "";
    //pr($contraentrega);
    //exit();
    if(haveRows($items)){
        foreach ($items as $item):
            if($item['producto_id']){
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
            }
        endforeach;
        
        #------DATOS DE ENVIO FARMACIA CATEDRAL------#

        $nombre =  explode(" ", $cliente[0]['cliente_nombre']);
        $apellido = explode(" ", $cliente[0]['cliente_apellido']);
        $ruc = $cliente[0]['cliente_ruc'];
        $ci = $cliente[0]['cliente_cedula'];
        //F = personaa fisica J = empresa
        $cliente_tipo = $cliente[0]['cliente_tipo'] == 1 ? "F" : "J";
        
        $ws_articulos = substr($ws_articulos, 0, -1);
        
        #contraentrega_delivery: 1:Delivery  2:Retiro de sucursal
        $delivery = 2;//$_POST['contraentrega_delivery'];
        $tipo_entrega = $delivery == 1 ? "DELI" : "SUC" ;
        
        #Si seleccino Contraentrega: opcion de pago Efectivo: 1 / POS: 2
        $Metodo_Pago = $_POST['contraentrega_opcion'] == 2 ? "TARJ" : "CONT";
         

        if($contraentrega[0]['direccion_id'] > 0){
            $direcciones = Direcciones::select(112);
            //pr($direcciones);
            //exit();
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
          $sucursal = Sucursales::select(1);
          $_POST['sucursal_id'] = $sucursal[0]['sucursal_id'];
          $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
          
          $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
          if(haveRows($ciudad)){
              $costoenvio = $ciudad[0]['costo_envio'];
          }else{
              $costoenvio = '6000';
          }
          
        }else if($_POST['sucursal_id'] > 0 ){
             $sucursal = Sucursales::select($sucursal_id);
             $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
        }else{
          //$_POST['sucursal_id'] = 1;
          $sucursal_codigo = 155;
        }
        $hora_entrega = date('d/m/Y H:i');
        $deposito = $sucursal_codigo > 0 ? $sucursal_codigo : 7;
        /////////////////////////////////
        /*if($delivery == 1){
          $porcentajes = $costoenvio * 5 / 100;
          $deliveryWs = $costoenvio - $porcentajes;
          $ws_articulos.=',{
            "Cantidad" : "1",
            "Cod_articulo" : "42593",
            "Precio" : "'.$deliveryWs.'"
          }';
        }*/
  		  $dataWs = '{
      	 	"usuario" :"ECO",
      	 	"pass" :"@DMIN",
      	 		"pedidos" : {
      	 			"ArticulosItem" :['.$ws_articulos.'],
      	 			"Pedido":{
      					"CI" : "'.$ci.'",
      					"IdPedido": "'.$contraentrega_id.'",
      					"Primer_Apellido": "'.$apellido[0].'",
      					"Primer_Nombre": "'.$nombre[0].'",
      					"Ruc": "'.$ruc.'",
      					"Segundo_Apellido" : "'.$apellido[1].'",
      					"Segundo_Nombre" : "'.$nombre[1].'",
      					"Tipo" : "'.$cliente_tipo.'",
      					"Metodo_Pago" : "'.$Metodo_Pago.'",
      					"Estado_Pago" : "PEND",
                "Deposito" : "'.$deposito.'",
                "Fecha_Entrega" : "'.$hora_entrega.'",
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
          
/*
          	$session = curl_init($ecommerce_url);
          	curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
          	curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
          	curl_setopt($session, CURLOPT_POST,	true); 
          	curl_setopt($session, CURLOPT_POSTFIELDS, $dataWs); 
          	curl_setopt($session, CURLOPT_HEADER, false); 
          	curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json")); 
          	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
          	$session_response = curl_exec($session);
          	curl_close($session);
*/
         pr($dataWs);
      	
    }

?>
