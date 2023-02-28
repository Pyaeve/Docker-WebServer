<?php
require_once("../_sys/init.php");

	if(param("suscripcionesToken") == token("suscripciones")):

		if(!isValidEmail(param('suscripcion_email'))):
			$result = array("status"=>"error" ,'description' => 'Por favor, escribe una dirección de correo válida.', "type"=>"suscripcion_email"  );
			echo json_encode($result);
			exit();
		endif;

		if(!isset($error)):
			$_POST['suscripcion_status'] = 1;

			$_POST['suscripcion_email'] = param('suscripcion_email');


			$error = Suscripciones::save(0);

		endif;

		if(!is_array($error)){
			//Captcha::reset();
			//Mail::send($from, $to, $subject, $template, $data);
			$result = array("status"=>"success","description"=>"Suscripcion realizada!");
			echo json_encode($result);
			exit();
		}else{
			$msg = $error[key($error)];
			$result = array("status"=>"error","description"=>$msg,"type"=>key($error));
			echo json_encode($result);
			exit();
		};

	else:
		$result = array("status"=>"error","description"=>"Error de Autenticación por favor recargue la pagina.","type"=>"autenticacion");
					echo json_encode($result);
			exit();
	endif;

echo json_encode($result);
?>