<?php
require_once('../_sys/init.php');
if(!Clientes::login()):
	#Sin realizar login
	$carrito = new Carrito;
	switch(param('accion')){
		case 'agregar':
			$producto = Productos::select(numParam('producto_id'));
			if(haveRows($producto)):
                $precioIva = $producto[0]['producto_precio'] + $producto[0]['producto_precioIVA'];
				$precio = porcentaje( $precioIva, $producto[0]['producto_oferta']);
				$cantidad_select = numParam('cantidad') > 1 ? numParam('cantidad') : 1;
				$articulo = array(
					'producto_id' => $producto[0]['producto_id'],
					'detalle_cantidad'	=>	$cantidad_select, //numParam('cantidad');
					'producto_precio'		=>	$precio,//$producto[0]['producto_precio'],//ver el tema de porsentaje de descuento
					'producto_nombre'		=>	$producto[0]['producto_nombre'],
				);
				#A�0�9ade al carrito
				$carrito->add($articulo);

				$items_carrito = $_SESSION['carrito']['articulos_total'] > '0' ? $_SESSION['carrito']['articulos_total']  : "00";
				//$result = array('status'=>'success','description'=>'Producto agregado al carrito.','type'=>'ok');
				$result = array('status'=>'success','items'=>$items_carrito,'type'=>'success');
				print json_encode($result);

			else:
				$result = array('status'=>'error','description'=>'Error al agregar el producto.','type'=>'error');
				print json_encode($result);
			endif;
		break;

		case 'vaciar':
			$carrito->destroy();
			$result = array('status'=>'success','description'=>'');
			print json_encode($result);
		break;

		case 'eliminar':
			$token = Encryption::Decrypt($_POST['token']);
			list($n,$detalle_id) = explode('_',$token);
			$carrito->remove_producto($detalle_id);
			$result = array('status'=>'success','description'=>''.$detalle_id);
			print json_encode($result);
		break;

		case 'update':
		  $detalle_id = param('detalle_id');
			$cantidad = numParam('cant');
			if($cantidad == 0){
				unset($_SESSION['carrito'][$detalle_id]);
			}else{
				$_SESSION['carrito'][$detalle_id]['detalle_cantidad'] = $cantidad;
			}

			#Actualiza el monto y cantidad total
	    	foreach ($_SESSION['carrito'] as $row)
		    {
		      $precio += ($row['producto_precio'] * $row['detalle_cantidad']);
		      $productos += $row['detalle_cantidad'];
		    }

		    $_SESSION['carrito']["articulos_total"] = $productos;
		    $_SESSION['carrito']["precio_total"] = $precio;


				$result = array('status'=>'success');
				print json_encode($result);
		break;
	}

else:
		#Usuario Logueado
			$session = $_SESSION['cliente'];
			$cliente_id = $_SESSION['cliente']['cliente_id'];
			$cliente = Clientes::select($cliente_id);
			$check = Carrito::getLast("cliente_id= {$cliente_id}");

			switch(param('accion')){
				case 'agregar':

					if(haveRows($check)):
						$carrito_id = $check[0]['carrito_id'];
					else:
						$_POST['cliente_id'] = $cliente_id;
						$_POST['carrito_status'] = 1;
						$carrito_id = Carrito::save(0);

						if(is_array($carrito_id)):
							$result = array('status'=>'error','description'=>'Error al crear el carrito #1','type'=>'error');
							print json_encode($result);
							exit;
						endif;
					endif;

					$producto = Productos::select(numParam('producto_id'));
					//$oferta = Ofertas::select_oferta(numParam('producto_id'));
					if(haveRows($producto)):

						$checkItem = Carrito_detalle::get("carrito_id = {$carrito_id} AND producto_id = {$producto[0]['producto_id']}");
						if(haveRows($checkItem)):
							$detalle_id = $checkItem[0]['detalle_id'];
							$cantidadNueva = $checkItem[0]['detalle_cantidad']+1;
							Carrito_detalle::set('detalle_cantidad',$cantidadNueva,"detalle_id = {$checkItem[0]['detalle_id']}");

						else:
							$cantidad_select = numParam('cantidad') > 1 ? numParam('cantidad') : 1;
							#Guarda nuevo
							$iva = $producto[0]['producto_precioIVA'] > 0 ? $producto[0]['producto_precioIVA'] : 0;
							$producto_precio = $producto[0]['producto_precio'] + $iva;
							if($producto[0]['producto_oferta_estado'] == 1){
                                $precio = porcentaje( $producto_precio, $producto[0]['producto_oferta']);
                            }else{
                                $precio = porcentaje( $producto_precio, $producto[0]['producto_oferta']);
                            }
                            
                            //$iva = $producto[0]['producto_precioIVA'] > 0 ? $producto[0]['producto_precioIVA'] : 0;

							$_POST['carrito_id']			= $carrito_id;
							$_POST['producto_id']			= $producto[0]['producto_id'];
							$_POST['producto_nombre']		= $producto[0]['producto_nombre'];
							$_POST['producto_precio']		= $precio;
							$_POST['detalle_monto']			= 0;
							$_POST['detalle_cantidad']		= $cantidad_select;
							$_POST['detalle_status']		= 1;

							$detalle_id = Carrito_detalle::save(0);
							$cantidadNueva = 1;
							#La reserva se guarda en confirmacion de compra
						endif;

						$neto = $cantidadNueva * $precio;
						Carrito_detalle::set('detalle_monto',$neto,"detalle_id = {$detalle_id}");

						$totalItem = Carrito_detalle::totalItems($cliente_id);

						$result = array('status'=>'success','description'=>'Total items '.$totalItem.' = '.$carrito_id,'type'=>'success');

						if($totalItem > 0){
							$result = array('status'=>'success','items'=>$totalItem,'type'=>'success');
							print json_encode($result);
						}else{
							$result = array('status'=>'error','description'=>'Error al cargar el carrito.#2','type'=>'error');
							print json_encode($result);
						}

					else:
						$result = array('status'=>'error','description'=>'Error al agregar el producto.#3','type'=>'error');
						print json_encode($result);
					endif;

				break;

				case 'repite';

					$compra_id = numParam('id');
					
					if($compra_id > 0){
						//$vuelta = Contraentrega_detalle::get("contraentrega_id =".$carrito_id);
						
						$vuelta = Compra_recurrente_detalle::get("compra_id =".$compra_id);

						if(haveRows($vuelta)):
							#Genera nuevo carrito o aplica a uno activo actual
							if(haveRows($check)):
								$carrito_id = $check[0]['carrito_id'];
							else:
								$_POST['cliente_id'] = $cliente_id;
								$_POST['carrito_status'] = 1;
								$carrito_id = Carrito::save(0);

								if(is_array($carrito_id)):
									$result = array('status'=>'error','description'=>'Error al crear el carrito #1','type'=>'error');
									print json_encode($result);
									exit;
								endif;
							endif;
							#Agregamos los productos al carrito
							foreach ($vuelta as $v):
							    $producto = Productos::select($v['producto_id']);
							    if(haveRows($producto)):
							        #Verifica el carrito detalle si ya existe
							        $checkItem = Carrito_detalle::get("carrito_id = {$carrito_id} AND producto_id = {$producto[0]['producto_id']}");
							        if(haveRows($checkItem)){
            							$detalle_id = $checkItem[0]['detalle_id'];
            							$cantidadNueva = $checkItem[0]['detalle_cantidad'];
            							Carrito_detalle::set('detalle_cantidad',$cantidadNueva,"detalle_id = {$checkItem[0]['detalle_id']}");
            						}else{
            						    #Guarda nuevo carrito detalle
            						    $iva = $producto[0]['producto_precioIVA'] > 0 ? $producto[0]['producto_precioIVA'] : 0;
										$producto_precio = $producto[0]['producto_precio'] + $iva;
										if($producto[0]['producto_oferta_estado'] == 1){
			                                $precio = porcentaje( $producto_precio, $producto[0]['producto_oferta']);
			                            }else{
			                                $precio = porcentaje( $producto_precio, $producto[0]['producto_oferta']);
			                            }
            						    
            						    $_POST['carrito_id']			= $carrito_id;
            							$_POST['producto_id']			= $producto[0]['producto_id'];
            							$_POST['producto_nombre']		= $producto[0]['producto_nombre'];
            							$_POST['producto_precio']		= $precio;
            							$_POST['detalle_monto']			= 0;
            							$_POST['detalle_cantidad']		= $v['detalle_cantidad'];
            							$_POST['detalle_status']		= 1;
            
            							$detalle_id = Carrito_detalle::save(0);
            							$cantidadNueva = $v['detalle_cantidad'];
            						}
							    else:
									$result = array('status'=>'error','description'=>'No hay stock del articulo seleccionado','type'=>'error');
									print json_encode($result);
								endif;
							endforeach;
							
							$totalItem = Carrito_detalle::totalItems($cliente_id);
    						
    						if($totalItem > 0){
    							$result = array('status'=>'success','items'=>"&nbsp;&nbsp;(".$totalItem.")",'type'=>'success');
    							print json_encode($result);
    							exit();
    						}else{
    							$result = array('status'=>'error','description'=>'Error al cargar el carrito.#2','type'=>'error');
    							print json_encode($result);
    							exit();
    						}
						
						else:
							$result = array('status'=>'error','description'=>'No se a encontrado articulos');
							print json_encode($result);
							exit();
						endif;

					}

				break;

				case 'vaciar':
					Carrito::emptyCart($cliente_id);
					$result = array('status'=>'success','description'=>'');
					print json_encode($result);
				break;

				case 'eliminar':
					$carrito_id = $check[0]['carrito_id'];

					$token = Encryption::Decrypt($_POST['token']);
					list($n,$detalle_id) = explode('_',$token);

				 	Carrito_detalle::delete($detalle_id);
				 	$totalItem = Carrito_detalle::totalItems($carrito_id);
					$result = array('status'=>'success','description'=>''.$detalle_id);
					print json_encode($result);
				break;

				case 'update':
					$detalle_id = numParam('detalle_id');
					$cantidad   = numParam('cant');

					if($cantidad):
						Carrito_detalle::set('detalle_cantidad',$cantidad,"detalle_id = ".$detalle_id);
					 	$result = array('status'=>'success','description'=>'actualizado');
					 	print json_encode($result);
					else:
						$result = array('status'=>'error','description'=>'La cantidad debe ser mayor a cero.');
						print json_encode($result);
					endif;
				break;
			}
endif;

?>
