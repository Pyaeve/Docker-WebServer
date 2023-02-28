<?php
	require_once('../_sys/init.php');
	$sucursal = numParam('local');
	$opcionentrega = param('opcionentrega');
	$cliente_id = $_SESSION['cliente']['cliente_id'];
	$product_cant = param('product_cant');
	$productos = explode(",", $product_cant);
	$productos = array_filter($productos);
	$status = "success";
	$count = count($productos, COUNT_RECURSIVE); 
	switch ($opcionentrega) {
		case 'delivery':
			$direcciones = Direcciones::get("cliente_id = ".$cliente_id." AND direccion_predeterminado = 1");
			$sucursal_id =	$direcciones[0]['sucursal_id'];
			if($sucursal_id > 0){
				$sucursales = Sucursales::select($sucursal_id);
				$sucursal_code = $sucursales[0]['sucursal_codigo'];
				$ws ="";
				$alert ="";
				$codeproductAlert = array();

				foreach ($productos as $key => $value) {
					$valor = explode("_", $value);
					$producto_code = $valor[0];
					$cantidad = $valor[1];

					
					#Retorna el stock de la sucursal seleccionada
					$ws.= ws_stockVal($producto_code, $disponibilidad, $sucursal_code);
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						
					}else{
						$alert.= "El producto codigo ".$producto_code." stock insuficiente\n";
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
				$sucursales = Sucursales::select('1');
				$sucursal_code = $sucursales[0]['sucursal_codigo'];
				$ws ="";
				$alert ="";
				$codeproductAlert = array();

				foreach ($productos as $key => $value) {
					$valor = explode("_", $value);
					$producto_code = $valor[0];
					$cantidad = $valor[1];

					
					#Retorna el stock de la sucursal seleccionada
					$ws.= ws_stockVal($producto_code, $disponibilidad, $sucursal_code);
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						
					}else{
						$alert.= "El producto codigo ".$producto_code." stock insuficiente\n";
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
			}


			
		break;
		case 'sucursal':
			if($sucursal > 0){
				$sucursales = Sucursales::select($sucursal);
				$codigo = $sucursales[0]['sucursal_codigo'];
				$ws ="";
				$alert ="";
				$codeproductAlert = array();
				$v = 0;
				for ($i = 0; $i = $count; $i++) {
					
					$valor = explode("_", $productos[$v]);
					$producto_code = $valor[0];
					$cantidad = $valor[1];
					$v = $v+1; 
					#Retorna el stock de la sucursal seleccionada
					$ws.= ws_stockVal($producto_code, $disponibilidad, $codigo);
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						$status = "error";
					}else{
			
						$alert.= "Producto ".$producto_code." con stock insuficiente\n";
						$codeproductAlert[$key] = $producto_code;
						$status = "error";
						$_SESSION['producto_alert'][$key] = $producto_code;
						$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
						print json_encode($result);
						exit;
					}
				}
				$alert.= "c: ".$v;
				/*$v = 0;
				foreach ($productos as $key => $value) {
					$valor = explode("_", $value);
					$producto_code = $valor[0];
					$cantidad = $valor[1];
					$v = $v+1; 
					
					#Retorna el stock de la sucursal seleccionada
					$ws.= ws_stockVal($producto_code, $disponibilidad, $codigo);
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						$status = "error";
						
					}else{
						//$alert.= "El producto codigo hola mundo".$productos[0][0]." stock insuficiente\n";
						//$a = explode("_", $productos[0]);
						$alert.= "El producto codigo :".$producto_code." stock insuficiente\n";
						$codeproductAlert[$key] = $producto_code;
						$status = "error";
						$_SESSION['producto_alert'][$key] = $producto_code;
						$result = array('status'=>$status,'html'=>$alert, "producto_alert" => $codeproductAlert);
						print json_encode($result);
						exit;
					}
				}
				$alert.= "c: ".$v;*/
				

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
				foreach ($productos as $key => $value) {
					$valor = explode("_", $value);
					$producto_code = $valor[0];
					$cantidad = $valor[1];

					
					#Retorna el stock de la sucursal seleccionada
					$ws.= ws_stockVal($producto_code, $disponibilidad, $codigo);
					if($ws > 0 AND $cantidad <= $ws){
						$alert.= "";
						
					}else{
						$alert.= "El producto codigo ".$producto_code." stock insuficiente\n";
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
			}

		
		break;
	}

	
?>