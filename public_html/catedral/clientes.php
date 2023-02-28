<?php

$cedula = $_POST['cedula'];
$enlace = $_POST['enlace'];
$ruc = $_POST['ruc'];
//$cedula = "952800";
//$enlace = "http://appcatedral.farmaciacatedral.com.py:8181/charliJavaEnvironment/rest/ListarClientes";

	try{
		$data = array(
			"cedula" => $cedula,
			"ruc" => $ruc
		);
		$session = curl_init($enlace);
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
		$nombres   = $response->sdt_clientes->nombres;
		$apellidos = $response->sdt_clientes->apellidos;
		$clien_nombre = $response->sdt_clientes->clien_nombre;
		//$nombres   = "DANIEL ANTONIO";
		//$apellidos = "GALEANO CARVALLO";
		//print_r($response['sdt_clientes']);
		echo json_encode(array("clien_nombre"=>$clien_nombre,"nombres"=>$nombres, "apellidos"=>$apellidos));
	
	}catch(ParseError $p){
	
		echo $p->getMessage();
	}

?>
