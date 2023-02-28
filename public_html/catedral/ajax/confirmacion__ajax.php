<?php
require_once('../_sys/init.php');
  #borrar session carrito si existiese
  if(haveRows($_SESSION['carrito'])){ unset($_SESSION['carrito']); }
  if(!Clientes::login()){
    header('location:./');
    exit();
  }
  $token = Encryption::Decrypt($_POST['tokenPago']);  
  list($n,$cliente_token) = explode('_',$token);

  if($_SESSION['cliente']['cliente_id'] == $cliente_token){
    #Obtenemos los datos del cliente
    $cliente = Clientes::select($_SESSION['cliente']['cliente_id']);

    #Preparamos para guardar en Contraentrega (deberia ser pedidos en fin)
    $_POST['cliente_id'] = $cliente[0]['cliente_id'];
    $_POST['cliente_nombres'] = $cliente[0]['cliente_nombre'];
    $_POST['cliente_email'] = $cliente[0]['cliente_email'];
    $_POST['cliente_telefono'] = $cliente[0]['cliente_celular'];

    

    #Metodo de pago utilizado
    #Op: 1: Contraentrega 2:Tarjeta  3:Zimple
    $_POST['contraentrega_formapago'] = numParam('metodo_pago');
    
    #Si seleccino Contraentrega: opcion de pago Efectivo: 1 / POS: 2
    $_POST['contraentrega_opcion'] = numParam('ContraentregaopcionPago');
    
    #Opcion de Entrega: 1:Delivery  2:Retiro de sucursal
    $_POST['contraentrega_delivery'] = numParam('opcion_entrega');
    $costo_envio = numParam('costo_envio');
    $costo_envio_iva = numParam('costo_envio_iva');
    #Si opcion_entrega es 1 envia a direccion Id
    #Obtenemos la direccion de envio
    $_POST['direccion_id'] = numParam('retiro_direccion_id');
    

    $_POST['cliente_zimple']  = param('zimpleP');
    $zimple = param('zimpleP');

    $_POST['contraentrega_formaPagoLocal'] = 0;
    $_POST['contraentrega_horario'] = 0;
    $_POST['contraentrega_status'] = 1;

    $regalo = param('paramregalo');
    $comentario = param('paramcomentario');
    
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
    }
    /*if($cliente[0]['cliente_id'] == 1702){
      $result = array("status"=>"error","description"=>"Ecommerce en mantenimiento".$regalo.$comentario);
      echo json_encode($result);
      exit();
    }*/
    //ACTUALIZAR PRECIOS CARRITOS
    $productos_actualizar = Carrito::getProductosActualizar($cliente[0]['cliente_id']);
    foreach ($productos_actualizar as $pr_ac){
        if(haveRows($pr_ac)){
            Carrito_detalle::set('producto_precio', $pr_ac["nuevo_precio"], 'detalle_id = '.$pr_ac["detalle_id"]);
        }
    }
    $items = Carrito_detalle::getItems($cliente[0]['cliente_id']);
    $html=" ";
    $ws_articulos = "";
    $total_new = 0;
    if(haveRows($items)){
        foreach ($items as $item):
            if($item['producto_id']){
                $productos = Productos::get('producto_id = '.$item['producto_id']);

                $producto = $productos[0];
                $precio = $producto['producto_precio']+$producto['producto_precioIVA'];//porcentaje( $item['producto_precio'], $item['producto_oferta_precio']);
                $subtotal = $precio*$item['detalle_cantidad'];
                
                $total_new += $subtotal;

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
       
        $delivery = $_POST['contraentrega_delivery'];
        $tipo_entrega = $delivery == 1 ? "DELI" : "SUC" ;
        
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
        

        if($_POST['direccion_id'] > 0){
            $direcciones = Direcciones::select($_POST['direccion_id']);
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
        if($_POST['contraentrega_delivery'] == 1){ #Para envio via delivery
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
              $direccion_prede = Direcciones::get("cliente_id = ".$cliente[0]['cliente_id']." AND direccion_predeterminado = 1");
			        $sucursal_id_prede =	$direccion_prede[0]['sucursal_id'];
              $sucursal = Sucursales::select($sucursal_id_prede);
              $sucursal_codigo = $sucursal[0]['sucursal_codigo'];
              //$_POST['sucursal_id'] = 1;
              //$sucursal_codigo = 7;
            }
            $hora_entrega = date('d/m/Y H:i');
            
            /*if($deposito == 0){
              $direccion_prede = Direcciones::get("cliente_id = ".$cliente[0]['cliente_id']." AND direccion_predeterminado = 1");
			        $sucursal_id_prede =	$direccion_prede[0]['sucursal_id'];
              $sucursal = Sucursales::select($sucursal_id_prede);
              $deposito = $sucursal[0]['sucursal_codigo'];
            }*/
            //$deposito = $sucursal_codigo > 0 ? $sucursal_codigo : 7;
        }else{#Tipo 2: retiro de la sucursal 
            $sucursal_nombre = Sucursales::select($id_de_sucursal);
            $deposito = $sucursal_nombre[0]['sucursal_codigo'];
            $costo_envio = 0;
        }
        
        $direccion_id_prede = $_POST['direccion_id'] > 0 ? $_POST['direccion_id'] : numParam('retiro_direccion_id');

        /*if($deposito == 0){
          $deposito = 7;
        }*/
        if($sucursal_codigo > 0){
          $deposito = $sucursal_codigo;
        }

        //validación de depósito
        if($deposito == 0 || empty($deposito)){
          $direccion_prede = Direcciones::get("direccion_id = $direccion_id_prede");
          $sucursal_id_prede =	$direccion_prede[0]['sucursal_id'];
          $sucursal = Sucursales::select($sucursal_id_prede);
          $deposito = $sucursal[0]['sucursal_codigo'];
        }

        /////////////////////////////////
        if($delivery == 1){
          //$porcentajes = $costoenvio * 10 / 100;
          $deliveryWs = $costo_envio;//$costoenvio - $porcentajes;
          $ws_articulos.=',{
            "Cantidad" : "1",
            "Cod_articulo" : "42593",
            "Precio" : "'.$deliveryWs.'"
          }';
          //verificación de horario delivery
          $ws = listar_depositos($deposito, $listardepositos);
          $atencion=$ws[0]->SDT_Listar_Depo[0]->ATENCION_DELI;
          $horario=$ws[0]->SDT_Listar_Depo[0]->HORARIOS_DELI;
          if($atencion == "CERRADO"){
            if(strlen($horario)>0){
              $texto = "Delivery no disponible, recibirá su pedido en el siguiente horario: $horario";
            }           
          }else{
            $texto = "Su compra ha sido realizada.!";
          }
        }else{
          //verificación de horario sucursal
          $ws = listar_depositos($deposito, $listardepositos);
          $atencion=$ws[0]->SDT_Listar_Depo[0]->ATENCION;
          $horario=$ws[0]->SDT_Listar_Depo[0]->HORARIOS;
          if($atencion == "CERRADO"){
              $texto = "La sucursal se encuentra de momento cerrada, horario de atenci&oacute;n: $horario";
          }else{
            $texto = "Su compra ha sido realizada.!";
          }

        }
        
		    //ACTUALIZAR campo de ws
        $productos_pedido = Contraentrega_detalle::get("contraentrega_id = $contraentrega_id","");
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

                //$upd = Mysql::exec("UPDATE contraentrega_detalle SET detalle_cantidad_ws = ".$ws." WHERE contraentrega_detalle = $contraentrega_id AND producto_id = ".$pr_pd["producto_id"]);
                //$upd = ;
	
                //db::execute($upd);

            }
        }
        if($ci == "4333650"){
          $usuario = "TEST";
          $pass = "TEST";
        }else{
          $usuario = "ECO";
          $pass = "@DMIN";
        }
  		  $dataWs = '{
      	 	"usuario" :"'.$usuario.'",
      	 	"pass" :"'.$pass.'",
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
                "comentario" : "'.$comentario.'",
                "regalo"    :   "'.$regalo.'" 
      	 			}
      			}
      	}';
        try {
          //se actualiza campo body_raw para poder reenviar pedido desde administrador
          Contraentrega::set('body_raw',$dataWs,"contraentrega_id = {$contraentrega_id}");
        } catch (ParseError $p) {
          $p->getMessage();
          //se actualiza campo body_raw con error.
          Contraentrega::set('body_raw',$p,"contraentrega_id = {$contraentrega_id}");
        }
        
        /*$dataWs = '{
          "usuario" :"TEST",
          "pass" :"TEST",
          "pedidos" : {
          "ArticulosItem" :[
          {
          "Cantidad" : "1",
          "Cod_articulo" : "81",
          "Precio" : "18866"
          },
          {
          "Cantidad" : "3",
          "Cod_articulo" : "3",
          "Precio" : "15000"
          }
          ],
          "Pedido":{
          "CI" : "3631719",
          "IdPedido": "255",
          "Primer_Apellido": "Francisco",
          "Primer_Nombre": "Bareiro",
          "Ruc": "3631719-5",
          "Segundo_Apellido" : "",
          "Segundo_Nombre" : "",
          "Tipo" : "J",
          "Metodo_Pago" : "CONT",
          "Estado_Pago" : "PEND",
          "Deposito" : "7",
          "Fecha_Entrega" : "02/05/15 07:00",
          "Direccion" : "Choferes del chaco c/ Enfermeras 185",
          "Tipo_Entrega" : "DELI",
          "Telefono" : "0981241217",
         "forma_pago" : "03"
            }
          }
         }';*/
        
        if($cliente[0]['cliente_id'] != 5){
        
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
            $cont= strlen($salida);
            //se vuelve a enviar al web service si web service no responde correcto
            if(trim($salida)<>"Correcto" || $cont < 1){

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
              $cont= strlen($salida);
              try{
                //se envia correo de error a ecommerce@farmaciacatedral.com.py si web service no responde correcto
                if(trim($salida)<>"Correcto" || $cont < 1){
                  #Datos para email
                  $from = array("noreply@farmaciacatedral.com.py" => "Catedral");
                  $to = array("ecommerce@farmaciacatedral.com.py"=>"Catedral",
                  "danielgaleano884@gmail.com" => "Catedral");
                  if($_POST['contraentrega_delivery'] == 1){ #Para envio via delivery
                    $data['local'] = '<tr><td><p style="margin-bottom: 0; font-size: 14px;"><b>Tipo de entrega:</b> </td><td>Delivery.</p></td></tr>';
                    $sucursal_nombre = Sucursales::get("sucursal_codigo = ".$sucursal_codigo);
                    $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
                    $data['deposito'] = "<tr><td>Sucursal</td><td>".$sucursal_nombre."</td></tr>";    
                    
                    $template = "pedido_template.html";
                    
                  
                  }else{#Tipo 2: retiro de la sucursal 
                    $sucursal_nombre = Sucursales::select($id_de_sucursal);
                    $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
                    if(haveRows($sucursal)){
                        $data['local'] = "<tr><td><b>Retiro de la sucursal:</b></td><td>".$sucursal_nombre."</td></tr>";
                        $data['deposito'] = "";   
                    }
                    $template = "pedido_sucursal_template.html";
                  }
        
                  $data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";
        
                  $totalPrecio  = Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
                  $subtotal =  number_format($totalPrecio,0,'','.');

                  if($_POST['contraentrega_delivery'] == 1){#Para envio via delivery
                    //$totalCosto = number_format($costo_envio+$totalPrecio,0,'','.');
                    $totalCosto = number_format($costo_envio+$total_new,0,'','.');
                  }else{#Tipo 2: retiro de la sucursal 
                    //$totalCosto = number_format($totalPrecio,0,'','.');
                    $totalCosto = number_format($total_new,0,'','.');
                  }



                  
                  
                  $data['costoenvio'] = $costo_envio;
                  $data['subtotal'] =  $subtotal;
                  $data['total'] =  $totalCosto;
                  $data['listado'] = $html;
                  $data["subject"] = "Detalles de la Compra";
                  $data["pedido"] =  $contraentrega_id;
    
                  $subject = "Ecommerce - Error al procesar venta: $salida ";

                  Mail::send($from, $to, $subject, $template, $data);

                  

                }
              }catch(ParseError $p){
                
                $p->getMessage();

                #Datos para email
                $from = array("noreply@farmaciacatedral.com.py" => "Catedral");
                $to = array("ecommerce@farmaciacatedral.com.py"=>"Catedral",
                "danielgaleano884@gmail.com" => "Catedral");
                if($_POST['contraentrega_delivery'] == 1){ #Para envio via delivery
                  $data['local'] = '<tr><td><p style="margin-bottom: 0; font-size: 14px;"><b>Tipo de entrega:</b> </td><td>Delivery.</p></td></tr>';
                  $sucursal_nombre = Sucursales::get("sucursal_codigo = ".$sucursal_codigo);
                  $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
                  $data['deposito'] = "<tr><td>Sucursal</td><td>".$sucursal_nombre."</td></tr>";    
                  
                  $template = "pedido_template.html";
                  
                
                }else{#Tipo 2: retiro de la sucursal 
                  $sucursal_nombre = Sucursales::select($id_de_sucursal);
                  $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
                  if(haveRows($sucursal)){
                      $data['local'] = "<tr><td><b>Retiro de la sucursal:</b></td><td>".$sucursal_nombre."</td></tr>";
                      $data['deposito'] = "";   
                  }
                  $template = "pedido_sucursal_template.html";
                }
      
                $data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";
      
                $totalPrecio  = Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
                $subtotal =  number_format($totalPrecio,0,'','.');
                //$totalCosto = number_format($costo_envio+$totalPrecio,0,'','.');
                if($_POST['contraentrega_delivery'] == 1){#Para envio via delivery
                  //$totalCosto = number_format($costo_envio+$totalPrecio,0,'','.');
                  $totalCosto = number_format($costo_envio_iva+$total_new,0,'','.');
                }else{#Tipo 2: retiro de la sucursal 
                  //$totalCosto = number_format($totalPrecio,0,'','.');
                  $totalCosto = number_format($total_new,0,'','.');
                }
                
                $data['costoenvio'] = $costo_envio_iva;
                $data['subtotal'] =  $subtotal;
                $data['total'] =  $totalCosto;
                $data['listado'] = $html;
                $data["subject"] = "Detalles de la Compra";
                $data["pedido"] =  $contraentrega_id;
  
                $subject = "Ecommerce - Error al procesar venta: $p ";

                Mail::send($from, $to, $subject, $template, $data);

                

              }
            }
        }

      	
    }
    
    if(!is_array($contraentrega_id) ){
          #Datos para email
          $from = array("noresponder@catedral.com" => "Catedral");
          $to = array(
              "diego.amarilla@puntopy.com"=>"Catedral", 
              //"danielgaleano884@gmail.com" => "Catedral",
              $cliente[0]['cliente_email'] => "Catedral" );

          $data = array();
          $data["send_date"]  = date('d/m/Y H:i:s');

          $data['cliente'] =  $cliente[0]['cliente_nombre'];
            switch ($_POST['contraentrega_formapago']) {
    		  case 1:
    		    $data['tipopago'] = "Contraentrega";
                break;
            case 2:
            	$data['tipopago'] = "Tarjeta de credito";
            break;
            case 3:
            		    $data['tipopago'] = "Billetera Zimple";
           break;
           case 4:
            $data['tipopago'] = "Crédito Farmacia";
           break;
            }
          if($_POST['direccion_id'] > 0){
            $direcciones = Direcciones::select($_POST['direccion_id']);
            $nrocasa = strlen($direcciones[0]['direccion_nrocasa']) > 0 ? " nro".$direcciones[0]['direccion_nrocasa'] : "";
            
            $data['cliente_direccion'] =  $direcciones[0]['direccion_direccion'].$nrocasa;
            $data['cliente_telefono'] =  $direcciones[0]['direccion_tel'];

            $data['cliente_email'] =  $cliente[0]['cliente_email'];
            $data['cliente_ciudad'] =  $direcciones[0]['direccion_ciudad'];
            $data['cliente_barrio'] = $direcciones[0]['direccion_barrio'];
            $data['ruc']    = $cliente[0]['cliente_ruc'];
          }


          #Token
          $token_cId = Encryption::Encrypt($contraentrega_id);

          if($_POST['contraentrega_delivery'] == 1){ #Para envio via delivery
            $data['local'] = '<tr><td><p style="margin-bottom: 0; font-size: 14px;"><b>Tipo de entrega:</b> </td><td>Delivery.</p></td></tr>';
            $sucursal_nombre = Sucursales::get("sucursal_codigo = ".$sucursal_codigo);
            $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
            $data['deposito'] = "<tr><td>Sucursal</td><td>".$sucursal_nombre."</td></tr>";    
            
            $template = "pedido_template.html";
            

            
          }else{#Tipo 2: retiro de la sucursal 
            $sucursal_nombre = Sucursales::select($id_de_sucursal);
            $sucursal_nombre = $sucursal_nombre[0]['sucursal_nombre'];
            if(haveRows($sucursal)){
                $data['local'] = "<tr><td><b>Retiro de la sucursal:</b></td><td>".$sucursal_nombre."</td></tr>";
                $data['deposito'] = "";   
            }
            $template = "pedido_sucursal_template.html";
          }

          $data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";

          $totalPrecio  = Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
          $subtotal =  number_format($totalPrecio,0,'','.');
          //$totalCosto = number_format($costo_envio_iva+$totalPrecio,0,'','.');
          
          if($_POST['contraentrega_delivery'] == 1){#Para envio via delivery
            //$totalCosto = number_format($costo_envio+$totalPrecio,0,'','.');
            $totalCosto = number_format($costo_envio_iva+$total_new,0,'','.');
          }else{#Tipo 2: retiro de la sucursal 
            //$totalCosto = number_format($totalPrecio,0,'','.');
            $totalCosto = number_format($total_new,0,'','.');
          }


          $data['costoenvio'] = $costo_envio_iva;
          $data['subtotal'] =  $subtotal;
          $data['total'] =  $totalCosto;
          $data['listado'] = $html;
          $data["subject"] = "Detalles de la Compra";
          $data["pedido"] =  $contraentrega_id;

          $subject = "Detalles de la Compra - Catedral.com.py";
          Mail::send($from, $to, $subject, $template, $data);

          #Vaciar carrito
          Carrito::emptyCart($cliente[0]['cliente_id']);

          $texto = strlen($texto) > 0 ? $texto : "Su compra ha sido realizada!";
          
          $result = array("status"=>"success","description"=>$texto,"extra" => $response);
          echo json_encode($result);
          exit();
    }else{
        $result = array("status"=>"error","description"=>'No se ha podido concretar la compra');
        echo json_encode($result);
        exit();
    }
  }else{
    $result = array("status"=>"error","description"=>'Error de autenticaci&oacute;n');
    echo json_encode($result);
    exit();
  }

?>
