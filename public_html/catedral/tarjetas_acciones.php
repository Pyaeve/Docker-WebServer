<?php
require_once('inc/config.php');
/*$cedula = $_POST['cedula'];
$enlace = $_POST['enlace'];
$ruc = $_POST['ruc'];*/
$tarjeta_id = $_POST['tarjeta_id'];
$user_id 	= $_POST['user_id'];
$card_token = $_POST['card_token'];
$accion 	= $_POST['accion'];
$email 		= $_POST['email'];
$telefono 	= $_POST['telefono'];
	if($accion == "delete"){

		$upd = Mysql::exec("UPDATE clientes_tarjetas SET cliente_tarjeta_hidden = 1, cliente_tarjeta_status = 0 WHERE cliente_id = $user_id AND tarjeta_id = $tarjeta_id");
		
		$token = md5($private_key . "delete_card" . $user_id . $card_token);

		try{
			$data = array(
				"public_key" => $public_key,
				"operation"	 => array(
					"token"	 		 => $token,
					"alias_token"	 => $card_token
				),
			);
			$session = curl_init($usercard_url.$user_id."/cards");
			#--------------------------------------------------------------
			curl_setopt($session, CURLOPT_POST, 1);
			curl_setopt($session, CURLOPT_CUSTOMREQUEST, "DELETE");
			curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
			curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
			curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
			$session_response = curl_exec($session);			
			curl_close($session);
			$response = json_decode($session_response);
			#--------------------------------------------------------------
			$status   = $response->status;
			echo json_encode(array("status"=>$status));
			/*print_r($response);
			echo $private_key_staging;*/
		
		}catch(ParseError $p){
		
			echo $p->getMessage();
		}
	}else if($accion == "insert"){

		$tarjeta = Mysql::exec("SELECT CASE WHEN MAX(tarjeta_id) > 0 THEN (MAX(tarjeta_id)+1) WHEN MAX(tarjeta_id) IS NULL THEN 1 END AS tarjeta_id FROM clientes_tarjetas WHERE cliente_id = $user_id");
		$card_id = $tarjeta[0]['tarjeta_id'];
		$token_card = md5($private_key . $card_id . $user_id . "request_new_card");
		
		$data = array(
			"public_key" => $public_key,
			"operation"	 => array(
				"token"				=> $token_card,
				"card_id"			=> $card_id,
				"user_id"			=> $user_id,
				"user_cell_phone"	=> $telefono,
				"user_mail"			=> $email,
				"return_url"		=> $return_urlC
			),
		);
		$session = curl_init($newcard_url);

		#--------------------------------------------------------------
		curl_setopt($session, CURLOPT_POST, 1);
		curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
		curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
		curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$session_response = curl_exec($session);
		
		curl_close($session);
		$response = json_decode($session_response);
		#-------------------------------------------------------------- 
		$status   = $response->status; //add_new_card_success
		$mensaje   = $response->messages[0]->dsc; //add_new_card_success
		if($status == "success"){
			$_POST['cliente_id'] 			 = $user_id;
			$_POST['tarjeta_id'] 			 = $card_id;
			$_POST['cliente_tarjeta_status'] = 1;
			$_POST['cliente_tarjeta_hidden'] = 0;
			$cliente_tarjeta_id = Clientes_tarjetas::save(0);
			if(is_array($cliente_tarjeta_id)){
		        $msg = $cliente_tarjeta_id[key($cliente_tarjeta_id)];
		        $result = array("status"=>"error","mensaje"=>$msg);
		        echo json_encode($result);
		        exit();
		    }
			echo json_encode(array("status"=>$status,"process_id"=>$response->process_id));
		}else{
			echo json_encode(array("status"=>$status,"mensaje"=>$mensaje));
		}
		

	}


?>
