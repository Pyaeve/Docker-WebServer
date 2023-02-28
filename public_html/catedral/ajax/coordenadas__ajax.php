<?php 
	require_once('../_sys/init.php');
	if(preg_match('/^(-)?[0-9]+(\.[0-9]+)?$/', $_POST['lat']) && preg_match('/^(-)?[0-9]+(\.[0-9]+)?$/', $_POST['lng'])){
	    	$lote_id = null;
			$coordenadas = array();
			$p_latitud = $_POST['lat'];
			$p_longitud = $_POST['lng'];
	}
    /*$coordenadas = Coordenadas::get();
    foreach($coordenadas as $key => $row_coordenada){
		$datos[$row_coordenada['zona_id']]['cobertura'][] = array(
			'lat' => $row_coordenada['coordenada_latitud'], 
			'lng' => $row_coordenada['coordenada_longitud'],
		);
	}
	echo json_encode($datos);*/
	
?>