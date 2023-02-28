<?php
require_once('../../_sys/init.php');
	// Se limpian las coordenadas 
	Coordenadas::delete_coordenada($_POST['zona_id']);

	// Se registran las nuevas coordenadas
	foreach ($_POST['coordenadas'] as $indice => $coordenada) {

		$_POST['zona_id']			= $_POST['zona_id'];
		$_POST['coordenada_numero']		= $indice;
		$_POST['coordenada_latitud']	= $coordenada['latitud'];
		$_POST['coordenada_longitud']	= $coordenada['longitud'];

		$_POST['coordenada_status']		= 1;
		$error = Coordenadas::save(0);

		if(!is_array($error)){
			$result = array("status"=>"success","description"=>'Se a guardado correctamente los datos','type' => pathToView.'coordenadas.view.php');

		}else{
			$msg = $error[key($error)];
			$result = array("status"=>"error","description"=>$msg,'type' => pathToView.'coordenadas.form.php');
		};

	}
	echo json_encode($result);
?>