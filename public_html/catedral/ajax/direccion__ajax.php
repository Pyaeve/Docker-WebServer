<?php
require_once('../_sys/init.php');
clearBuffer();
switch($_SERVER['REQUEST_METHOD']):
	case "POST":
		$cliente_id = $_SESSION['cliente']['cliente_id'];
		#DEFINIR PARA LA ACTUALIZACION
		if($cliente_id){
			$_POST['cliente_id'] = $cliente_id;
			#Sucursal
			//se comenta codigo original y se inserta nuevo para auto asignación de sucursal mas cercana 17/09/2021 Daniel Galeano
			$ltlnc = explode(",", $_POST['cliente_mapa']);
			$latitudc = $ltlnc[0];
			$longitudc = $ltlnc[1];
			$sucursales = Sucursales::get("sucursal_delivery IN (1) and sucursal_codigo is not null","sucursal_nombre ASC");
			if(haveRows($sucursales)){
				$sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
				$ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
				$latitudi = $ltlni[0];
				$longitudi = $ltlni[1];
				$distancia_inicial = getDistanceBetweenPoints($latitudc, $longitudc, $latitudi, $longitudi, 'km');
				$sucursal_cercana = $sucursal_inicial[0]["sucursal_id"];
				foreach ($sucursales as $sucursal) {
			
					$ltln = explode(",", $sucursal["sucursal_ubicacion"]);
					$latitud = $ltln[0];
					$longitud = $ltln[1];
					$distancia = getDistanceBetweenPoints($latitudc, $longitudc, $latitud, $longitud, 'km');
					if($distancia < $distancia_inicial){

						$distancia_inicial = $distancia;
						$sucursal_cercana = $sucursal["sucursal_id"];

					}
				}
			}

			$sucursal = $sucursal_cercana;
			//$sucursal_id =  numParam('sucursal');
			
			/*if($sucursal_id > 0){
				$sucursales = Sucursales::select($sucursal_id);
				if(!haveRows($sucursales)){
					$result = array("status"=>"error","description"=>"Seleccionar sucursal","type"=>"sucursal");
					echo json_encode($result);
					exit();
				}
				$sucursal = $sucursales[0]['sucursal_id'];
			}else{
				$result = array("status"=>"error","description"=>"Seleccionar sucursal","type"=>"sucursal");
				echo json_encode($result);
				exit();
			}*/
		
			$_POST['sucursal_id'] = $sucursal > 0 ? $sucursal : 1;
			$_POST['direccion_predeterminado'] = numParam('predeterminada');
			$_POST['direccion_denominacion'] = addslashes($_POST['denominacion']);

			$_POST['direccion_ciudad'] = addslashes($_POST['ciudad']);
			$_POST['direccion_barrio'] = addslashes($_POST['barrio']);
			$_POST['direccion_tel'] = addslashes($_POST['tel']);
			$_POST['direccion_direccion'] = $_POST['direccion'];
			$_POST['direccion_mapa'] = $_POST['cliente_mapa'];
			$_POST['direccion_nrocasa'] = $_POST['numero_casa'];
			
			$_POST['direccion_status'] = 1;
			$direccion_id = numParam('direccion_id');

			$save = Direcciones::save($direccion_id);
			if(!is_array($save)){
				if($direccion_id>0){
					Direcciones_sucursales::borrar2($direccion_id);
					$direcciones = Direcciones::get("direccion_id = $direccion_id","direccion_id desc");
				}else{
					$direcciones = Direcciones::get("direccion_id NOT IN (SELECT direccion_id FROM direcciones_sucursales)","direccion_id desc");
				}
				
				if(haveRows($direcciones)){
					
					foreach ($direcciones as $direccion) {
					
						$sucursales = Sucursales::get("sucursal_delivery IN (1) and sucursal_codigo is not null","sucursal_nombre ASC");
						if(haveRows($sucursales)){
							$sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
							$ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
							$latitudi = $ltlni[0];
							$longitudi = $ltlni[1];
							$ltlnc = explode(",", $direccion["direccion_mapa"]);
							$latitudc = $ltlnc[0];
							$longitudc = $ltlnc[1];
							$distancia_inicial = getDistanceBetweenPoints($latitudc, $longitudc, $latitudi, $longitudi, 'km');
							$sucursal_cercana = $sucursal_inicial[0]["sucursal_id"];
							foreach ($sucursales as $sucursal) {
								$ltln = explode(",", $sucursal["sucursal_ubicacion"]);
								$latitud = $ltln[0];
								$longitud = $ltln[1];
								$distancia = getDistanceBetweenPoints($latitudc, $longitudc, $latitud, $longitud, 'km');
								//echo "<b> $distancia $distancia_inicial </b> <br>";
								//if($distancia < $distancia_inicial){
									
									$distancia_inicial = $distancia;
									$sucursal_cercana = $sucursal["sucursal_id"];
									$_POST['direccion_id'] = $direccion["direccion_id"];
									$_POST['sucursal_id'] = $sucursal["sucursal_id"];
									$_POST['distancia_km'] = $distancia_inicial;
									if($distancia_inicial <= 4){
										$save = Direcciones_sucursales::save($direccion_sucursal_id);
						
									}

								//}
							}
							$save = Direcciones_sucursales::save($direccion_sucursal_id);
							
						}
						$direcciones_sucursales = Direcciones_sucursales::get("direccion_id = ".$direccion["direccion_id"],"");
						if(!haveRows($direcciones_sucursales)){
							$sucursal_inicial = Sucursales::get("sucursal_delivery IN (1) AND sucursal_id = 1","sucursal_nombre ASC");
							$ltlni = explode(",", $sucursal_inicial[0]["sucursal_ubicacion"]);
							$latitudi = $ltlni[0];
							$longitudi = $ltlni[1];
							$ltlnc = explode(",", $direccion["direccion_mapa"]);
							$latitudc = $ltlnc[0];
							$longitudc = $ltlnc[1];
							$distancia_inicial = getDistanceBetweenPoints($latitudc, $longitudc, $latitudi, $longitudi, 'km');
							$sucursal_cercana = $sucursal_inicial[0]["sucursal_id"];
							$_POST['direccion_id'] = $direccion["direccion_id"];
							$_POST['sucursal_id'] = $sucursal_inicial[0]["sucursal_id"];
							$_POST['distancia_km'] = $distancia_inicial;
							$save = Direcciones_sucursales::save($direccion_sucursal_id);
							
						}

					}
				}
				$result = array("status"=>"success","description"=>"Datos guardados!");
				echo json_encode($result);
				exit();
			}else{
				$msg = $save[key($save)];
				$type = explode("_", key($save));
				$result = array("status"=>"error","description"=>$msg,"type"=>$type[1]);
				echo json_encode($result);
				exit();
			};

		}
	break;
	default:
		setUnauthorized();
endswitch;
//borrar direcciones duplicadas
Direcciones_sucursales::borrarduplicados();
	
?>