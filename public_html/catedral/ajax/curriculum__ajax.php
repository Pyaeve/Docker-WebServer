<?php
	require_once("../_sys/init.php");
	if(param("token_cv") == token("trabajeconnosotros")){

		if(!isValidEmail(param('emailc'))):
			$result = array("status"=>"error","description" => "Por favor, escribe una dirección de correo válida.","type"=>"emailc");
			echo json_encode($result);
			exit();	
		endif;

		//echo json_encode($_POST);
		//exit();

		if($_FILES['laboral_file_name']['error'] == 0):
			$format = false;
			switch($_FILES['laboral_file_name']['type']):
				case "application/pdf":
				case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
					$format = true;
					break;
			endswitch;
			if(!$format):
					$result = array("status" => "error","description" => "El formato del archivo que intenta subir es incorrecto","type" => "laboral_file_name");
					echo json_encode($result);
					exit();
			endif;
		else:
			$result = array("status" => "error","description" => "Seleccione un archivo","type" => "laboral_file_name");
			echo json_encode($result);
			exit();
		endif;

		$_POST['laboral_nombre']  = addslashes($_POST['nombre']);
		$_POST['laboral_documento'] = param('documento');
		$_POST['laboral_tel'] = param('telefono');
		$_POST['laboral_email'] = param('emailc');
		$_POST['laboral_edad']  = param('edad');
		$_POST['laboral_sexo'] = param('sexo');
		$_POST['laboral_fechanac'] = param('fecha_nac');

		$_POST['laboral_direccion'] = addslashes($_POST['direccion']);
		$_POST['laboral_barrio'] = param('barrio');
		$_POST['laboral_ciudad'] = param('ciudad');
		$_POST['laboral_lugarnac'] = param('lugar_nac');
		$_POST['laboral_nacionalidad'] = param('nacionalidad');
		$_POST['laboral_profesion'] = param('profesion');
		$_POST['laboral_status'] = 1;
		
		$save = Ofertalaborales::save(0);

		#Datos para email
		$from = array("noresponder@catedral.com.py" => "Trabaje con Nosotros :: catedral.com.py");
		$to   = array("postulaciones@farmaciacatedral.com.py"=> "Trabaje con Nosotros :: catedral.com.py");

		$subject = "Nueva envio de Trabaje con Nosotros";
		$template = "curriculum_template.html";

		$data["subject"] 	= $subject;

		$data["laboral_nombre"]	= "{$_POST['laboral_nombre']}";
		$data["laboral_documento"]	= "{$_POST['laboral_documento']}";
		$data["laboral_tel"]	= "{$_POST['laboral_tel']}";
		$data["laboral_email"]	= "{$_POST['laboral_email']}";
		$data["laboral_edad"]	= "{$_POST['laboral_edad']}";
		$data["laboral_sexo"]	= "{$_POST['laboral_sexo']}";

		$data["laboral_fechanac"]	= "{$_POST['laboral_fechanac']}";
		$data["laboral_direccion"]	= "{$_POST['laboral_direccion']}";
		$data["laboral_barrio"]	= "{$_POST['laboral_barrio']}";
		$data["laboral_ciudad"]	= "{$_POST['laboral_ciudad']}";

		$data["laboral_lugarnac"]	= "{$_POST['laboral_lugarnac']}";
		$data["laboral_nacionalidad"]	= "{$_POST['laboral_nacionalidad']}";
		$data["laboral_profesion"]	= "{$_POST['laboral_profesion']}";
        $data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";

		if(!is_array($save)){
			Mail::send($from, $to, $subject, $template, $data);
			$result = array("status"=>"success","description"=>"Se ha enviado el Curriculum");
			echo json_encode($result);
			exit();	

		}else{
			$msg = $save[key($save)];
			$campo = explode("_", key($save));
			$result = array("status"=>"error","description"=>$msg,"type"=>$campo[1] );
			echo json_encode($result);
			exit();	
		};

	}else{
		$result = array("status"=>"error","description"=>"Error#1","type"=>"autenticacion");
		echo json_encode($result);
		exit();
	}
?>
