<?php

	//include('inc/config.php');
	//require_once('inc/config.php');
	require_once('../_sys/init.php');

	$UserEmail 		= isset($_POST["Email"]) ? $_POST["Email"] : null;
	$UserName 		= isset($_POST["Nombre"]) ? $_POST["Nombre"] : null;
	$UserLastName	= isset($_POST["Apellido"]) ? $_POST["Apellido"] : null;
	$UserAction 	= isset($_POST["Action"]) ? $_POST["Action"] : null;
	
	if($UserAction == "Login"){
		
		//verificar usuario.
		$cliente = Clientes::get("cliente_email = '".$UserEmail."'","");
		if(haveRows($cliente)){
			if(Login::setLoginGoogle($UserEmail,"0")){
				$result = array("status"=>"success",'url' => baseURL, 'session' => "redireccion" );
		    }else{
			   $result = array("status"=>"error","description"=>"Email o Clave incorrecto","type"=>"email");
		    }
		}else{
			//guardar cliente
			$result = array("status"=>"redir","description"=>"crear user","type"=>"email");
		}
	
		
	}else{
		
		$result = array("status"=>"error","description"=>"Email o Clave incorrecto","type"=>"email");
	}
	
	print json_encode($result);
	exit;
?>