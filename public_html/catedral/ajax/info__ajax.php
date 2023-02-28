<?php 
	require_once('../_sys/init.php');
	if(preg_match('/^(-)?[0-9]+(\.[0-9]+)?$/', $_POST['lat']) && preg_match('/^(-)?[0-9]+(\.[0-9]+)?$/', $_POST['lng'])){

			$zona_id = null;
			$coordenadas = array();
			$p_latitud = $_POST['lat'];
			$p_longitud = $_POST['lng'];
                        
			$datos = Coordenadas::zonas();
			foreach ($datos as $coordenada) {
				if ($zona_id != $coordenada['zona_id']) {
				       
					if ($zona_id != null && Coordenadas::enArea(array('lat'=> floatval($p_latitud), 'lng'=> floatval($p_longitud)), $coordenadas)){

						#Obtener datos del lote
						
	                   $result = array("status"=>"success","description"=>$zona_id);
	                   echo json_encode($result);

					}
					$zona_id = $coordenada['zona_id'];
					$coordenadas = array();
				}
			    $coordenadas[] = array('lat' => floatval($coordenada['coordenada_latitud']), 'lng' => floatval($coordenada['coordenada_longitud']));
			}
			
			if (Coordenadas::enArea(array('lat'=> floatval($p_latitud), 'lng'=> floatval($p_longitud)), $coordenadas)) {
			    //$zona_id = Coordenadas::select($zona_id);
			    $result = array("status"=>"success","description"=>$zona_id);
	            echo json_encode($result);
			}
			
	}
?>