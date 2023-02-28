<?php
	require_once('../_sys/init.php');
	//require_once('inc/config.php');
	$sucursal = numParam('local');
	$opcionentrega = param('opcionentrega');
	$cliente_id = $_SESSION['cliente']['cliente_id'];
	$product_cant = param('product_cant');
	$productos = explode(",", $product_cant);
	$productos = array_filter($productos);
	$total = numParam('total');
	$disponible = numParam('disponible');
	$opcionpago = numParam('opcionpago');
	$status = "success";
	if($opcionpago >= 3){
	
		if($total>$disponible){
			$alert.= "La compra supera el límite de línea de crédito, disponible: Gs. $disponible \n";
			$status = "error";
			$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
			print json_encode($result);
			exit;
		}

	}
	switch ($opcionentrega) {
		case 'delivery':
			
			$direcciones = Direcciones::get("cliente_id = ".$cliente_id." AND direccion_predeterminado = 1");
			$sucursal_id =	$direcciones[0]['sucursal_id'];
			if($sucursal_id > 0){
				/*$sucursales = Sucursales::select($sucursal_id);
				$sucursal_code = $sucursales[0]['sucursal_codigo'];*/
				$ws ="";
				$alert = "";
				$codeproductAlert = array();
				/*$alert.= "Ecommerce en Mantenimiento";
				$status = "error";*/
				$direcciones_sucursales = Direcciones_sucursales::getjoin($cliente_id);
				if(haveRows($direcciones_sucursales)){
					foreach ($direcciones_sucursales as $direccion_sucursal) {
						//se obtiene codigo depósito para esa sucursal
						$sucursales = Sucursales::select($direccion_sucursal["sucursal_id"]);
						$sucursal_code = $sucursales[0]['sucursal_codigo'];
						//distancia en km lineales de sucursal a coordenadas del cliente
						$distancia = $direccion_sucursal['distancia_km'];
						//$alert = "";
						$ws ="";
						foreach ($productos as $key => $value) {
							$valor = explode("_", $value);
							$producto_code = $valor[0];
							$cantidad = $valor[1];
												
							#Retorna el stock de la sucursal seleccionada
							$ws = ws_stockVal($producto_code, $disponibilidad, $sucursal_code);
							if($ws > 0 AND $cantidad <= $ws){
								$alert.= "";
								$bandera = 1;
							}else{
								//obtener datos del cliente para guardar en tabla demanda insatisfecha
								$cliente = Clientes::get("cliente_id = ".$cliente_id,"");
								if(haveRows($cliente)){
									$_POST['cliente_id'] 		= $cliente_id;
									$_POST['cliente_cedula'] 	= $cliente[0]["cliente_cedula"];
									$_POST['cliente_ruc'] 		= $cliente[0]["cliente_ruc"];
									$_POST['cliente_nombre']	= $cliente[0]["cliente_nombre"];
									$_POST['cliente_apellido']  = $cliente[0]["cliente_apellido"];
									$_POST['sucursal_codigo']   = $sucursal_code;
									$_POST['producto_codigo']   = $producto_code;
									$_POST['cantidad'] 			= $cantidad;
									//guardado en tabla
									$save = demandas_insatisfechas::save($demandas_insatisfechas_id);
									//guardado en pl-sql por ws
									$data = array( 
										"cliente_cedula" => $cliente[0]["cliente_cedula"],
										"cliente_ruc" => $cliente[0]["cliente_ruc"],
										"cliente_nombre" => $cliente[0]["cliente_nombre"],
										"cliente_apellido" => $cliente[0]["cliente_apellido"],
										"depo_codigo" => $sucursal_code,
										"prod_codigo" => $producto_code,
										"cantidad" => $cantidad
										);
									$session = curl_init("http://201.217.36.19:8584/ords/catedral/rest/demandas_insatisfechas/");
									curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
									curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
									curl_setopt($session, CURLOPT_POST,	true); // usar HTTP POST
									curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
									curl_setopt($session, CURLOPT_HEADER, false); 
									curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
									curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
									$session_response = curl_exec($session);
									curl_close($session);
									$response = json_decode($session_response);
									
								}
								$bandera = 0;
								$status = "error";
								$prod = Productos::get("producto_codigo = ".$producto_code,"");
								$desc_prod = $prod[0]["producto_nombre"]; 
								$alert = "El producto ".$desc_prod." con stock insuficiente, cantidad disponible: $ws \n";
								//$alert = "El producto codigo ".$producto_code." stock insuficiente, cantidad disponible: $ws \n";
								break;
							}
						}
						if($bandera == 1){
							if($distancia>7){
								$alert = "Zona fuera de cobertura, disponible opción retiro de sucursal.";
								$status = "error";
								$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
								print json_encode($result);
								exit;
							}else{
								//$alert = "b: $bandera Ecommerce en Mantenimiento ".$direccion_sucursal["sucursal_id"];
								/*$alert = "c: $ws s: ".$sucursal_code;
								$status = "error";*/
								//actualiza dirección con sucursal con stock
								Direcciones::set("sucursal_id", $direccion_sucursal["sucursal_id"], "direccion_id = ".$direcciones[0]['direccion_id']);
								$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
								print json_encode($result);
								exit;
							}
						}
					}
				}

				if($bandera == 0){
					$status = "error";
					$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
					print json_encode($result);
					exit;
				}
					
				$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
				print json_encode($result);
				exit;
			}else{
				#Si no tiene una sucursal definida
				/*$sucursales = Sucursales::select('1');
				$sucursal_code = $sucursales[0]['sucursal_codigo'];*/
				$ws ="";
				$alert = "";
				$codeproductAlert = array();

				$direcciones_sucursales = Direcciones_sucursales::getjoin($cliente_id);
				if(haveRows($direcciones_sucursales)){
					foreach ($direcciones_sucursales as $direccion_sucursal) {
						//se obtiene codigo depósito para esa sucursal
						$sucursales = Sucursales::select($direccion_sucursal["sucursal_id"]);
						$sucursal_code = $sucursales[0]['sucursal_codigo'];
						//distancia en km lineales de sucursal a coordenadas del cliente
						$distancia = $direcciones_sucursales['distancia_km'];
						$alert = "";
						$ws ="";
						foreach ($productos as $key => $value) {
							$valor = explode("_", $value);
							$producto_code = $valor[0];
							$cantidad = $valor[1];
												
							#Retorna el stock de la sucursal seleccionada
							$ws = ws_stockVal($producto_code, $disponibilidad, $sucursal_code);
							//validar variable
							/*if(empty($ws) AND $ws <> 0){
								$bandera = 0;
								$alert = "Servicio no disponible, intente nuevamente en unos minutos.";
								break;
							}*/
							if($ws > 0 AND $cantidad <= $ws){
								$alert.= "";
								$bandera = 1;
							}else{
								//obtener datos del cliente para guardar en tabla demanda insatisfecha
								$cliente = Clientes::get("cliente_id = ".$cliente_id,"");
								if(haveRows($cliente)){
									$_POST['cliente_id'] 		= $cliente_id;
									$_POST['cliente_cedula'] 	= $cliente[0]["cliente_cedula"];
									$_POST['cliente_ruc'] 		= $cliente[0]["cliente_ruc"];
									$_POST['cliente_nombre']	= $cliente[0]["cliente_nombre"];
									$_POST['cliente_apellido']  = $cliente[0]["cliente_apellido"];
									$_POST['sucursal_codigo']   = $sucursal_code;
									$_POST['producto_codigo']   = $producto_code;
									$_POST['cantidad'] 			= $cantidad;
									//guardado en tabla
									$save = demandas_insatisfechas::save($demandas_insatisfechas_id);
									//guardado en pl-sql por ws
									$data = array( 
										"cliente_cedula" => $cliente[0]["cliente_cedula"],
										"cliente_ruc" => $cliente[0]["cliente_ruc"],
										"cliente_nombre" => $cliente[0]["cliente_nombre"],
										"cliente_apellido" => $cliente[0]["cliente_apellido"],
										"depo_codigo" => $sucursal_code,
										"prod_codigo" => $producto_code,
										"cantidad" => $cantidad
										);
									$session = curl_init("http://201.217.36.19:8584/ords/catedral/rest/demandas_insatisfechas/");
									curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
									curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
									curl_setopt($session, CURLOPT_POST,	true); // usar HTTP POST
									curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
									curl_setopt($session, CURLOPT_HEADER, false); 
									curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
									curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
									$session_response = curl_exec($session);
									curl_close($session);
									$response = json_decode($session_response);
									
								}
								$bandera = 0;
								$prod = Productos::get("producto_codigo = ".$producto_code,"");
								$desc_prod = $prod[0]["producto_nombre"]; 
								$alert.= "El producto ".$desc_prod." con stock insuficiente, cantidad disponible: $ws \n";
								//$alert .= "El producto codigo ".$producto_code." stock insuficiente, cantidad disponible: $ws \n";
								break;
							}
						}
						if($bandera == 1){
							if($distancia>7){
								$alert = "Zona fuera de cobertura, disponible opción retiro de sucursal.";
								$status = "error";
								$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
								print json_encode($result);
								exit;
							}else{
								//$alert = "b: $bandera Ecommerce en Mantenimiento ".$direccion_sucursal["sucursal_id"];
								/*$alert = "c: $ws s: ".$sucursal_code;
								$status = "error";*/
								//actualiza dirección con sucursal con stock
								Direcciones::set("sucursal_id", $direccion_sucursal["sucursal_id"], "direccion_id = ".$direcciones[0]['direccion_id']);
								$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
								print json_encode($result);
								exit;
							}
						}
					}
				}
				

				$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
				print json_encode($result);
				exit;
			}


			
		break;
		case 'sucursal':
			
			if($sucursal > 0){
				$sucursales = Sucursales::select($sucursal);
				$codigo = $sucursales[0]['sucursal_codigo'];
				$ws ="";
				$alert ="";
				$codeproductAlert = array();
				/*$alert.= "Ecommerce en Mantenimiento";
				$status = "error";*/
				foreach ($productos as $key => $value) {
					$valor = explode("_", $value);
					$producto_code = $valor[0];
					$cantidad = $valor[1];

					#Retorna el stock de la sucursal seleccionada
					$ws = ws_stockVal($producto_code, $disponibilidad, $codigo);
					//validar variable
					/*if(empty($ws) AND $ws <> 0){
						$alert .= "Servicio no disponible, intente nuevamente en unos minutos.".$ws;
						$codeproductAlert[$key] = $producto_code;
						$status = "error";
						$_SESSION['producto_alert'][$key] = $producto_code;
						$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
						print json_encode($result);
						exit;
					}*/
					//$status = "error";
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						
					}else{
						//obtener datos del cliente para guardar en tabla demanda insatisfecha
						$cliente = Clientes::get("cliente_id = ".$cliente_id,"");
						if(haveRows($cliente)){
							$_POST['cliente_id'] 		= $cliente_id;
							$_POST['cliente_cedula'] 	= $cliente[0]["cliente_cedula"];
							$_POST['cliente_ruc'] 		= $cliente[0]["cliente_ruc"];
							$_POST['cliente_nombre']	= $cliente[0]["cliente_nombre"];
							$_POST['cliente_apellido']  = $cliente[0]["cliente_apellido"];
							$_POST['sucursal_codigo']   = $codigo;
							$_POST['producto_codigo']   = $producto_code;
							$_POST['cantidad'] 			= $cantidad;
							//$par="id: $cliente_id ci: ".$cliente[0]["cliente_cedula"]." ruc: ".$cliente[0]["cliente_ruc"]." n:".$cliente[0]["cliente_nombre"]." a: ".$cliente[0]["cliente_apellido"]." s: $codigo p: $producto_code c: $cantidad";
							//guardado en tabla
							$save = demandas_insatisfechas::save($demandas_insatisfechas_id);
							//guardado en pl-sql por ws
							$data = array( 
								"cliente_cedula" => $cliente[0]["cliente_cedula"],
								"cliente_ruc" => $cliente[0]["cliente_ruc"],
								"cliente_nombre" => $cliente[0]["cliente_nombre"],
								"cliente_apellido" => $cliente[0]["cliente_apellido"],
								"depo_codigo" => $codigo,
								"prod_codigo" => $producto_code,
								"cantidad" => $cantidad
								);
							$session = curl_init("http://201.217.36.19:8584/ords/catedral/rest/demandas_insatisfechas/");
							curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
							curl_setopt($session, CURLOPT_POST,	true); // usar HTTP POST
							curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
							curl_setopt($session, CURLOPT_HEADER, false); 
							curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
							curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
							$session_response = curl_exec($session);
							curl_close($session);
							$response = json_decode($session_response);
							
						}
						$prod = Productos::get("producto_codigo = ".$producto_code,"");
						$desc_prod = $prod[0]["producto_nombre"]; 
						$alert.= "El producto ".$desc_prod." con stock insuficiente, cantidad disponible: $ws \n";
						//$alert.= "El producto codigo ".$producto_code." stock insuficiente, cantidad disponible.: $ws \n";
						$codeproductAlert[$key] = $producto_code;
						$status = "error";
						$_SESSION['producto_alert'][$key] = $producto_code;
						$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
						print json_encode($result);
						exit;

					}
				}
				
				
				$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
				print json_encode($result);
				exit;
			}else{
				#Si no tiene una sucursal definida
			    $sucursales = Sucursales::select("1");
				$codigo = $sucursales[0]['sucursal_codigo'];
				$ws ="";
				$alert ="";
				$codeproductAlert = array();
				/*$alert.= "Ecommerce en Mantenimiento";
				$status = "error";*/
				foreach ($productos as $key => $value) {
					$valor = explode("_", $value);
					$producto_code = $valor[0];
					$cantidad = $valor[1];

					
					#Retorna el stock de la sucursal seleccionada
					$ws = ws_stockVal($producto_code, $disponibilidad, $codigo);
					//validar variable
					/*if(empty($ws) AND $ws <> 0){
						$alert .= "Servicio no disponible, intente nuevamente en unos minutos.".$ws;
						$codeproductAlert[$key] = $producto_code;
						$status = "error";
						$_SESSION['producto_alert'][$key] = $producto_code;
						$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
						print json_encode($result);
						exit;
					}*/
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						
					}else{
						//obtener datos del cliente para guardar en tabla demanda insatisfecha
						$cliente = Clientes::get("cliente_id = ".$cliente_id,"");
						if(haveRows($cliente)){
							$_POST['cliente_id'] 		= $cliente_id;
							$_POST['cliente_cedula'] 	= $cliente[0]["cliente_cedula"];
							$_POST['cliente_ruc'] 		= $cliente[0]["cliente_ruc"];
							$_POST['cliente_nombre']	= $cliente[0]["cliente_nombre"];
							$_POST['cliente_apellido']  = $cliente[0]["cliente_apellido"];
							$_POST['sucursal_codigo']   = $codigo;
							$_POST['producto_codigo']   = $producto_code;
							$_POST['cantidad'] 			= $cantidad;
							//guardado en tabla
							$save = demandas_insatisfechas::save($demandas_insatisfechas_id);
							//guardado en pl-sql por ws
							$data = array( 
								"cliente_cedula" => $cliente[0]["cliente_cedula"],
								"cliente_ruc" => $cliente[0]["cliente_ruc"],
								"cliente_nombre" => $cliente[0]["cliente_nombre"],
								"cliente_apellido" => $cliente[0]["cliente_apellido"],
								"depo_codigo" => $codigo,
								"prod_codigo" => $producto_code,
								"cantidad" => $cantidad
								);
							$session = curl_init("http://201.217.36.19:8584/ords/catedral/rest/demandas_insatisfechas/");
							curl_setopt($session, CURLOPT_SSL_VERIFYHOST, 0);
							curl_setopt($session, CURLOPT_SSL_VERIFYPEER, 0);
							curl_setopt($session, CURLOPT_POST,	true); // usar HTTP POST
							curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
							curl_setopt($session, CURLOPT_HEADER, false); 
							curl_setopt($session, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
							curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
							$session_response = curl_exec($session);
							curl_close($session);
							$response = json_decode($session_response);
						}
						$prod = Productos::get("producto_codigo = ".$producto_code,"");
						$desc_prod = $prod[0]["producto_nombre"]; 
						$alert.= "El producto ".$desc_prod." con stock insuficiente, cantidad disponible: $ws \n";
						$codeproductAlert[$key] = $producto_code;
						$status = "error";
						$_SESSION['producto_alert'][$key] = $producto_code;
						$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
						print json_encode($result);
						exit;
					}
				}
				
				$status = "error";
				$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
				print json_encode($result);
				exit;
			}

		
		break;
	}

	
?>