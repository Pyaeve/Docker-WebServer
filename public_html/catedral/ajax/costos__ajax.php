<? require_once('../_sys/init.php');

	switch (param('accion')) {

		case 'ciudad':
			$departamento_id = numParam('id');
			$options = array();

			if($departamento_id > 0){
				$ciudades = Ciudad::get("departamento_id = {$departamento_id}");
				if(haveRows($ciudades)){
					$options[0] = "Selecciona Ciudad";
					foreach ($ciudades as $key => $city) {
						$options[$city['ciudad_id']] = $city['ciudad_nombre'];
					}
										
					$result = array('status'=>'success','html'=>$options);
					print json_encode($result);
					exit;
				}else{
					$result = array('status'=>'error','html'=>'Sin datos');
					print json_encode($result);
					exit;
				}
			
			}else{
				$result = array('status'=>'error','html'=>'Sin datos');
				print json_encode($result);
				exit;
			}	
		break;
		case 'sucursal':
			$ciudad_id = numParam('id');
			if($ciudad_id > 0){
				$sucursales = Sucursales::get("ciudad_id = ".$ciudad_id);
				if(haveRows($sucursales)){
					$options[0] = "Selecciona direccion y/o ubicacion";

                    foreach ($sucursales as $key => $sucursal) {
						$options[$sucursal['sucursal_id']] = $sucursal['sucursal_nombre'];
					}

                  	$result = array('status'=>'success','html'=>$options);
					print json_encode($result);
					exit;

				}else{
					$result = array('status'=>'error','html'=>'Sin datos');
					print json_encode($result);
					exit;
				}
			
			}else{
				$result = array('status'=>'error','html'=>'Sin datos');
				print json_encode($result);
				exit;
			}	
				print json_encode($_POST);
				exit;
		break;
		case 'ubicacion':
			$ciudad_id = numParam('city');
			$sucursal_id = numParam('id');

			if($sucursal_id > 0){
				$ciudad = Ciudad::select($ciudad_id);
				if(haveRows($ciudad)){
					$costo = '<strong>Importe:</strong> Gs. '.$ciudad[0]['costo_envio'];

                  	$result = array('status'=>'success','html'=>$costo);
					print json_encode($result);
					exit;

				}else{
					$result = array('status'=>'error','html'=>'Sin datos');
					print json_encode($result);
					exit;
				}
			
			}else{
				$result = array('status'=>'error','html'=>'Sin datos');
				print json_encode($result);
				exit;
			}	
				print json_encode($_POST);
				exit;
		break;
        case 'costo_envio':
			$sucursal_id = numParam('id');
			if($sucursal_id > 0){
				$sucursal = Sucursales::select($sucursal_id);
				if(haveRows($sucursal)){
					$ciudad = Ciudad::select($sucursal[0]['ciudad_id']);
					if(haveRows($ciudad)){
						if(param('opcionentrega') == "delivery"){
							$costoenvio = $ciudad[0]['costo_envio'];
						}else{
							$costoenvio = 0;
						}

						$cliente_id = $_SESSION['cliente']['cliente_id'];
						$totalPrecio  = Carrito_detalle::totalCosto($cliente_id);
						
						$costo_envio = number_format($costoenvio,0,'','.');
						$total = $totalPrecio + $costoenvio;

						$costo_total = number_format($total,0,'','.');

						$result = array(
							'status'=>'success',
							'costo'=>"Gs. ".$costoenvio,
							"total" => $costo_total,
						);
						print json_encode($result);
						exit;
					}
				}
			}else{

				$ciudad = Ciudad::select(1);
				if(haveRows($ciudad)){
					if(param('opcionentrega') == "delivery"){
						$costoenvio = $ciudad[0]['costo_envio'];
					}else{
						$costoenvio = 0;
					}

					$cliente_id = $_SESSION['cliente']['cliente_id'];
					$totalPrecio  = Carrito_detalle::totalCosto($cliente_id);
					
					$costo_envio = number_format($costoenvio,0,'','.');
					$total = $totalPrecio + $costoenvio;

					$costo_total = number_format($total,0,'','.');

					$result = array(
						'status'=>'success',
						'costo'=>"Gs. ".$costoenvio,
						"total" => $costo_total,
					);
					print json_encode($result);
					exit;
				}
				
			}
		break;
		
		default:
			# code...
			break;
	}
?>
