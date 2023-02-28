<?php 
require_once('_sys/init.php');
clearBuffer();
switch($_SERVER['REQUEST_METHOD']):
	case "POST":
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
			//tarjeta
			$tarjeta 				= param('tarjeta');
			$token_tarjeta 			= param('token_tarjeta');			
			$total_precio_mostrador = numParam('total_precio_mostrador');			

		    #Opcion de Entrega: 1:Delivery  2:Retiro de sucursal
		    $_POST['contraentrega_delivery'] = numParam('opcion_entrega');

		    #Si opcion_entrega es 2 debe estar presenta retiro_de_local para obtener la Id de la sucursal
		    $_POST['sucursal_id'] = numParam('retiro_de_local');

		    #Si opcion_entrega es 1 envia a direccion Id
		    #Obtenemos la direccion de envio
		    $_POST['direccion_id'] = numParam('retiro_direccion_id');
		    $_POST['cliente_zimple']  = param('zimpleP');

		    $zimple = param('zimpleP');

		    $_POST['contraentrega_formaPagoLocal'] = 0;

			$delivery = $_POST['contraentrega_delivery'];

			if($delivery == 1){
				$costoenvio = numParam('costo_envio_iva');
			}else{
				$costoenvio = 0;
			}
 			if($_POST['sucursal_id'] > 0){
		      $sucursal = Sucursales::select($_POST['sucursal_id']);
		      $_POST['sucursal_id'] = $sucursal[0]['sucursal_id'];
		      
		      $ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
		      /*if(haveRows($ciudad)){
		          $costoenvio = 0;//$ciudad[0]['costo_envio'];
		      }else{
		          $costoenvio = 0;//'6000';
		      }*/
		      
		    }else{
		    	$_POST['sucursal_id'] = 1;
		    }

		    $_POST['contraentrega_status'] = 1;

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

		    ///////////////////////////////
		    $items = Carrito_detalle::getItems($cliente[0]['cliente_id']);
		    $html=" ";
		    if(haveRows($items)){
		        foreach ($items as $item):
		            if($item['producto_id']){
		                $productos = Productos::get('producto_id = '.$item['producto_id']);

		                $producto = $productos[0];
		                //$precio = porcentaje( $item['producto_precio'], $item['producto_oferta_precio']);
		                //$subtotal = $precio*$item['detalle_cantidad'];
		                
		                #Guardamos el detalle de la compra
		                  $_POST['contraentrega_id']  = $contraentrega_id;
		                  $_POST['producto_id']       = $producto['producto_id'];
		                  $_POST['producto_nombre']   = $producto['producto_nombre'];
						  if($tarjeta == '039'){
							$precio = $producto['producto_precioantes']+$producto['producto_precioantesIVA'];
							$_POST['producto_precio']   = $precio; //precio Unitario
							$subtotal = $precio*$item['detalle_cantidad'];
						  }else{
							$tarjeta = 0;
							$precio = porcentaje( $item['producto_precio'], $item['producto_oferta_precio']);
		                    $subtotal = $precio*$item['detalle_cantidad'];
							$_POST['producto_precio']   = $item['producto_precio']; //precio Unitario
						  }
		                  
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
		            }
		        endforeach;
		    }

		    if(!is_array($contraentrega_id) ){
		        #Token
		        $token_cId = Encryption::Encrypt($contraentrega_id);

		        $pedido_id = $contraentrega_id;
				if($tarjeta == '039'){
					$totalPrecio = $total_precio_mostrador;
					$additional_data = "039 VS, 039 MS";
				}else{
					$Hoy = Mysql::exec("SELECT date_format(now(),'%Y-%c-%d') AS HOY");
                    $UltimoJueves = Mysql::exec("SELECT date_format(LAST_DAY(NOW()) - ((7 + WEEKDAY(LAST_DAY(NOW())) - 3) % 7),'%Y-%c-%d') AS JUEVES");
                            
                    if($Hoy[0]['HOY'] == $UltimoJueves[0]['JUEVES']){
						$additional_data = "001,002,003,004,005,006,007,008,017,020,026,028,030,040,041,042,043,044,100,101,104,107,113,126,136,137,171,177,178,180,249,250,251,252,253,254,256,257,258,259,261,265,267,276,298,299,410,411,712,713,714,717,801,844,845,901,902,903,904,905,906,907,908,909,910,911,912,914,915,916,917,918,923,925,926";
					}else{
						$additional_data = "";
					}
					$totalPrecio  = Carrito_detalle::totalCosto($cliente[0]['cliente_id']);
					
				}
		        
		        $total =  number_format($totalPrecio,0,'','.');
		        
		        
		        
				$user_id = $cliente[0]['cliente_id'];
		        $total_final = $costoenvio+$totalPrecio;
		        $total_final = number_format(floor($total_final),2,".","");
				//$total_final = number_format(floor(10000),2,".","");
		        $enviaid = Encryption::Encrypt("pedido_id_".$pedido_id, encryptionKey);
		         #BANCARD
				$token = md5($private_key . $pedido_id . $total_final . "PYG");
				$card_id = 5;
				$token_card   = md5($private_key . $card_id . $user_id . "request_new_card");
				$token_charge = md5($private_key . $pedido_id . "charge" . $total_final . "PYG" . $token_tarjeta);
				
		        				
                if($_POST['contraentrega_formapago'] == '3'){
                    $data = array(
    					"public_key" => $public_key,
    					"operation"	 => array(
    						"token"				=> $token,
    						"shop_process_id"	=> $pedido_id,
    						"currency"			=> "PYG",
    						"amount"			=> $total_final,
    						"additional_data"	=> $zimple,
    						"zimple"            => "S",
    						"description"		=> "Catedral - COMPRA ONLINE",
    						"return_url"		=> $return_urlZ . '?order=' . urlencode($enviaid),
    						"cancel_url"		=> $cancel_urlZ . '?order=' . urlencode($enviaid),
    					),
				    );
					$session = curl_init($service_url);
                }else if($_POST['contraentrega_formapago'] == '5'){	
					//md5(private_key + shop_process_id + "charge" + amount + currency +alias_token)				
                    $data = array(
    					"public_key" => $public_key,
    					"operation"	 => array(
    						"token"				 => $token_charge,
    						"shop_process_id"	 => $pedido_id,
    						"amount"			 => $total_final,
							"number_of_payments" => 1,
							"currency"			 => "PYG",
    						"additional_data"	 => $additional_data,
    						"description"		 => "Catedral - COMPRA ONLINE",
    						"alias_token"		 => $token_tarjeta
    					),
    				);
					$session = curl_init($paytoken_url);
                }else if($_POST['contraentrega_formapago'] == '2'){
					
                    $data = array(
    					"public_key" => $public_key,
    					"operation"	 => array(
    						"token"				=> $token,
    						"shop_process_id"	=> $pedido_id,
							"amount"			=> $total_final,
    						"currency"			=> "PYG",
    						"additional_data"	=> $additional_data,//"039 VS, 039 MS",
    						"description"		=> "Catedral - COMPRA ONLINE",
    						"return_url"		=> $return_url . '?order=' . urlencode($enviaid) . '&tarj=' .$tarjeta,
    						"cancel_url"		=> $cancel_url . '?order=' . urlencode($enviaid),
    					),
    				);
					$session = curl_init($service_url);
                }
			
				
				
		
				#--------------------------------------------------------------
				curl_setopt($session, CURLOPT_POST, 1);
                curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
                curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
                $session_response = curl_exec($session);
                
                curl_close($session);
                $response = json_decode($session_response);
                #--------------------------------------------------------------
		        if($response->status == "success"):
            		# 1-Pendiente
            		# 2-Confirmado
            		# 3-Rechazado

		            Contraentrega::set('contraentrega_process_id',$response->process_id,"contraentrega_id = {$contraentrega_id}");
		            unset($_SESSION['carrito']);#Borramos la session carrito
		            session_write_close();
                    if($_POST['contraentrega_formapago'] == 3){
                        header("Location: zimple?process_id=" . $response->process_id);
                    }else if($_POST['contraentrega_formapago'] == 2){
                        header("Location: pagar?process_id=" . $response->process_id . "&deli=" . $delivery . "&tarj=". $tarjeta);
                        //header("Location: pagar_catastro?process_id=" . $response->process_id);
                        
                    }else if($_POST['contraentrega_formapago'] == 5){
                        
						//Contraentrega::set('contraentrega_process_id',$response->shop_process_id,"contraentrega_id = {$contraentrega_id}");
						//$data = json_decode($response);

						$response_log = "INSERT INTO payment_response SET pedido_id = " . $contraentrega_id . ", response_text = '".addslashes($session_response)."'";
	
						db::execute($response_log);

						if($response->confirmation->response_code == "00"){
							Contraentrega::set('contraentrega_status',2,"contraentrega_id = {$contraentrega_id}");
						}else{
							#Pago rechazado
							# 1-Pendiente
							# 2-Confirmado
							# 3-Rechazado
							Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$contraentrega_id}");
						}
						header("Location: checkout_result_token?order=" . urlencode($enviaid));
						//. '?order=' . urlencode($enviaid)
						//header("Location: pagar_test?process_id=" . $response->process_id . "&deli=" . $delivery . "&tarj=". $tarjeta);
                        
                        
                    }
		          
		            exit();
		        else:
		           // Log::write('PedidoID:'.$pedido_id.' - '.$response);
		        	//header("Location:checkout.php?error=yaprocesado");
		        	header("Location:checkout.php?error=yaprocesado".$response->messages[0]->dsc);
		        	//header("Location:checkout.php?error=yaprocesadoo".$_POST['contraentrega_formapago']);
		            exit;
		        endif;
		        #-------------BANCARD END-------------------------------

		          $result = array("status"=>"success","description"=>'Compra realizada!');
		          echo json_encode($result);
		          exit();
		    }else{
		        $result = array("status"=>"error","description"=>'No se ha podido concretar la compra');
		        echo json_encode($result);
		        exit();
		    }
		    ///////////////////////////////
  		}else{
		    $result = array("status"=>"error","description"=>'Error de autenticaci贸n');
		    echo json_encode($result);
		    exit();
  		}
	break;
	default:
		setUnauthorized();
	break;
endswitch;

?>