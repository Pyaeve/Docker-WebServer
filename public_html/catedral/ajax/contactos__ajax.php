<?php
require_once("../_sys/init.php");
	if(param("token_contact") == token("contactos")):

		if(!isValidEmail(param('emailc'))):
			$result = array("status"=>"error","description"=>'Por favor, escribe una dirección de correo válida.', "type"=> "emailc");
			echo json_encode($result);
			exit();	
		endif;

		if(!isset($error)):
			$_POST['contacto_nombre']  = addslashes($_POST['nombre']);
			$_POST['contacto_documento'] = param('documento');
			$_POST['contacto_telefono'] = param('telefono');
			$_POST['contacto_email'] = param('emailc');
			$_POST['contacto_asunto']  = param('asunto');
			$_POST['contacto_mensaje'] = param('mensaje');

			$_POST['contacto_status'] = 1;
			$error = Contactos::save(0);
	
			$from = array("noresponder@catedral.com.py" => "Contactos :: catedral.com.py");
			//$to   = array("diegoamarilla3@gmail.com"=> "Contactos :: catedral.com.py");
			$to   = array("postulaciones@farmaciacatedral.com.py"=> "Trabaje con Nosotros :: catedral.com.py");

			$subject = "Nuevo mensaje recibido";
			$template = "contactos_template.html";
			$data["subject"] 	= $subject;
			$data["contacto_nombre"]	= "{$_POST['contacto_nombre']}";
			$data["contacto_documento"]	= "{$_POST['contacto_documento']}";
			$data["contacto_telefono"]	= "{$_POST['contacto_telefono']}";
			$data["contacto_email"]	= "{$_POST['contacto_email']}";
			$data["contacto_asunto"]	= "{$_POST['contacto_asunto']}";
			$data["contacto_mensaje"]	= "{$_POST['contacto_mensaje']}";
			$data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";
			$data["send_date"] 	= date('d/m/Y H:i:s');
		endif;

		if(!is_array($error)){
			//session_regenerate_id();
			Mail::send($from, $to, $subject, $template, $data);
			$result = array("status"=>"success","description"=>"Mensaje enviado con éxito!");
			echo json_encode($result);
			exit();	
		}else{
			$msg = $error[key($error)];
			$campo = explode("_", key($error));
			$result = array("status"=>"error","description"=>$msg,"type"=>$campo[1]);
			echo json_encode($result);
			exit();	
		};

	else:
		$result = array("status"=>"error","description"=>"Error de Autenticación por favor recargue la pagina.","type"=>"autenticacion");
		echo json_encode($result);
		exit();	
	endif;


?>