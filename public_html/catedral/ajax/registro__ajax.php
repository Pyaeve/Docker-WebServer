<?php
	require_once("../_sys/init.php");
	$accion = param('accion');
	switch ($accion) {
		case 'register':
		    $cliente_email = param('cliente_email');
			if(param("token_registro") == token("registro")){
				//if(!isValidEmail(trim($cliente_email))):
				if(!filter_var(trim($cliente_email), FILTER_VALIDATE_EMAIL)):
					$result = array("status"=>"error","description" => "Por favor, escribe una dirección de correo válida.","type"=>"cliente_email");
					echo json_encode($result);
					exit();	
				endif;

				if(!param('cliente_clave')):
					$result = array("status"=>"error","description" => "Completa el campo Contraseña","type"=>"cliente_clave");
					echo json_encode($result);
					exit();
				endif;

				if(!passValidation_reg(param('cliente_clave'))){
					$result = array("status"=>"error","description" => "La clave debe tener entre 8 a 16 caracteres","type"=>"cliente_clave");
					echo json_encode($result);
					exit();
				}
				#CLIENTES
				$_POST['cliente_status'] = 1;
				$_POST['cliente_tipo'] = numParam('cliente_tipo');
				$_POST['cliente_nombre'] = addslashes($_POST['cliente_nombre']);
				$_POST['cliente_apellido'] = addslashes($_POST['cliente_apellido']);
				$_POST['cliente_cedula'] = param('cliente_cedula');
				$_POST['cliente_email'] = param('cliente_email');
				$_POST['cliente_ruc'] = param('cliente_ruc');
				$_POST['cliente_telefono'] = param('cliente_telefono');
				$_POST['cliente_clave'] = param('cliente_clave');
				$_POST['cliente_key'] = sha1(mt_rand().time().mt_rand().$_SERVER['REMOTE_ADDR']);
				if($_POST['cliente_mapa'] == NULL ){
					$result = array("status"=>"error","description"=>"Selecciona una ubicacion","type"=>"direccion_mapa");
					echo json_encode($result);
					exit();
				}
				
				$error = Clientes::save(0);
				#DIRECCION
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
				/*$sucursal_id =  numParam('sucursal');
				if($sucursal_id > 0){
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
				
				if(!is_array($error)){
					$direccion_id = numParam('direccion_id');
					$_POST['direccion_denominacion'] = param('direccion');
					$_POST['direccion_predeterminado'] = 1;
					$_POST['direccion_ciudad'] = addslashes($_POST['ciudad']);
					$_POST['direccion_barrio'] = addslashes($_POST['barrio']);
					$_POST['direccion_tel'] = addslashes($_POST['cliente_telefono']);
					$_POST['direccion_direccion'] = $_POST['direccion'];

					$_POST['direccion_mapa'] = $_POST['cliente_mapa'];


					$_POST['direccion_nrocasa'] = $_POST['numero_casa'];
					$_POST['direccion_status'] = 1;
					$_POST['cliente_id'] = $error;
					$_POST['sucursal_id'] = $sucursal > 0 ? $sucursal : 1;
					
					$save = Direcciones::save($direccion_id);
					if(!is_array($save)){
						$direcciones = Direcciones::get("direccion_id NOT IN (SELECT direccion_id FROM direcciones_sucursales)","direccion_id desc");
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
						$msg = $error[key($save)];
						$campo = explode("_", key($save));
						$result = array("status"=>"error","description"=>$msg." ".$campo[1],"type"=>key($save));
						echo json_encode($result);
						exit();
					};

					$from = array("noresponder@Catedral.com" => "Catedral");
					$to   = array(
					    "diego.amarilla@puntopy.com"=> "Nuevo Registro Catedral",
					    param('cliente_email') => "Nuevo Registro Catedral"
					);

					$subject = "Nuevo registro recibido Catedral";
					$template = "registro_template.html";
					$data["subject"] 	= $subject;
					$data["cliente_nombre"]	= "{$_POST['cliente_nombre']}";
					$data["cliente_email"]	= "{$_POST['cliente_email']}";
					
					$data["cliente_cedula"]	= "{$_POST['cliente_cedula']}";
					$data["cliente_ruc"]	= "{$_POST['cliente_ruc']}";

					$data["cliente_direccion"]	= "{$_POST['direccion_direccion']}";
					$data["cliente_telefono"]	= "{$_POST['direccion_tel']}";

					$data["cliente_oferta_correo"]	= $_POST['cliente_oferta_correo'] == 1 ? "Si" : "No";
					$data["cliente_oferta_msm"]	= $_POST['cliente_oferta_msm'] == 1 ? "Si" : "No";
					
					$data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";
					$data['code'] = $_POST['cliente_key'];
					$data["send_date"] 	= date('d/m/Y H:i:s');


					Mail::send($from, $to, $subject, $template, $data);
					$result = array("status"=>"success","description"=>'Registro exitoso!');
					echo json_encode($result);
					exit();
				}else{
					$msg = $error[key($error)];
					$campo = explode("_", key($error));
					$result = array("status"=>"error","description"=>$msg." ".$campo[1],"type"=>key($error));
					echo json_encode($result);
					exit();
				}
				
			}else{
				$result = array("status"=>"error","description"=>"Error de Autenticación","type"=>"autenticacion");
				echo json_encode($result);
				exit();
			}
		break;
		case 'update':
			if(param("token_registro") == token("registro")){

				$cliente_id = $_SESSION['cliente']['cliente_id'];

				if($cliente_id){
					if(!isValidEmail(param('cliente_email'))):
						$result = array("status"=>"error","description" => "Por favor, escribe una dirección de correo válida.","type"=>"cliente_email");
						echo json_encode($result);
						exit();	
					endif;

					#Si esta completo el campo pass actualizara la contraseña
					if($_POST['cliente_clave']){
						#Actualizar solo contraseña
						$pass = md5($_POST['cliente_clave'] . "_" . strtoupper(strrev($_POST['cliente_email'])));
						$update = "UPDATE clientes SET cliente_clave = '{$pass}' WHERE cliente_id = {$cliente_id}";
						db::execute($update);
						$result = array('status'=>'success','description'=>'Los cambios se han guardado');
					}

					#CLIENTES
					$_POST['cliente_status'] = 1;
					# F persona fisica | J empresa
					$_POST['cliente_tipo'] = numParam('cliente_tipo');
					$_POST['cliente_nombre'] = addslashes($_POST['cliente_nombre']);
					$_POST['cliente_apellido'] = addslashes($_POST['cliente_apellido']);
					$_POST['cliente_cedula'] = param('cliente_cedula');
					$_POST['cliente_email'] = param('cliente_email');
					$_POST['cliente_ruc'] = param('cliente_ruc');
					$_POST['cliente_telefono'] = param('cliente_telefono');
					$_POST['cliente_clave'] = param('cliente_clave');
					$_POST['cliente_key'] = sha1(mt_rand().time().mt_rand().$_SERVER['REMOTE_ADDR']);
					if($_POST['cliente_mapa'] == NULL ){
						$result = array("status"=>"error","description"=>"Selecciona una ubicacion","type"=>"direccion_mapa");
						echo json_encode($result);
						exit();
					}

					$error = Clientes::save($cliente_id);
					#DIRECCION
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
					
					/*$sucursal_id =  numParam('sucursal');
					//comentado para no obligar cargar sucursal predeterminada
					if($sucursal_id > 0){
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
					#obtener la direccion predeterminada
					$direccion_update = Direcciones::get("cliente_id =".$cliente_id." AND direccion_predeterminado = 1");
					if(!haveRows($direccion_update)){
						$direccion_update = Direcciones::get("cliente_id =".$cliente_id." AND direccion_predeterminado = 0","direccion_id DESC");
					}

					$direccion_id = $direccion_update[0]['direccion_id'];
					Direcciones_sucursales::borrar2($direccion_id);
					/*actualizar direcciones_sucursales*/
					/*$direcciones = Direcciones::get("direccion_id = $direccion_id","direccion_id desc");
					if(haveRows($direcciones)){
						//DELETE DE TABLA Direcciones_sucursales
  						Direcciones_sucursales::borrar2($direccion_id);
						foreach ($direcciones as $direccion) {
							$sucursales = Sucursales::get("sucursal_delivery IN (1)","sucursal_nombre ASC");
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
									if($distancia < $distancia_inicial){
										$distancia_inicial = $distancia;
										$sucursal_cercana = $sucursal["sucursal_id"];
										$_POST['direccion_id'] = $direccion["direccion_id"];
										$_POST['sucursal_id'] = $sucursal["sucursal_id"];
										$_POST['distancia_km'] = $distancia_inicial;
										if($distancia_inicial < 4){
											$save = Direcciones_sucursales::save($direccion_sucursal_id);
										}
									}
								}
							}
						}
					}*/

						
					
					/**/
					
					$_POST['direccion_denominacion'] = param('direccion');
					$_POST['direccion_predeterminado'] = 1;
					$_POST['direccion_ciudad'] = addslashes($_POST['ciudad']);
					$_POST['direccion_barrio'] = addslashes($_POST['barrio']);
					$_POST['direccion_tel'] = addslashes($_POST['cliente_telefono']);
					$_POST['direccion_direccion'] = $_POST['direccion'];

					$_POST['direccion_mapa'] = $_POST['cliente_mapa'];


					$_POST['direccion_nrocasa'] = $_POST['numero_casa'];
					$_POST['direccion_status'] = 1;
					$_POST['cliente_id'] = $error;
					$_POST['sucursal_id'] = $sucursal > 0 ? $sucursal : 1;
					
					$save = Direcciones::save($direccion_id);
					if(!is_array($save)){
						$result = array("status"=>"success","description"=>"Datos guardados!");
						echo json_encode($result);
						$direcciones = Direcciones::get("direccion_id NOT IN (SELECT direccion_id FROM direcciones_sucursales)","direccion_id desc");
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
										if($distancia < $distancia_inicial){
											
											$distancia_inicial = $distancia;
											$sucursal_cercana = $sucursal["sucursal_id"];
											$_POST['direccion_id'] = $direccion["direccion_id"];
											$_POST['sucursal_id'] = $sucursal["sucursal_id"];
											$_POST['distancia_km'] = $distancia_inicial;
											if($distancia_inicial <= 4){
												$save = Direcciones_sucursales::save($direccion_sucursal_id);
								
											}

										}
									}
									//$save = Direcciones_sucursales::save($direccion_sucursal_id);
									
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
						exit();
					}else{
						$msg = $error[key($save)];
						$campo = explode("_", key($save));
						$result = array("status"=>"error","description"=>$msg." ".$campo[1],"type"=>key($save));
						echo json_encode($result);
						exit();
					};

					#DIRECCIONES END


					if(!is_array($error)){
						//Captcha::reset();
						$result = array("status"=>"success","description"=>'Sus datos se han actualizado correctamente!', 'type' => 'update');
						echo json_encode($result);
						exit();
					}else{
						$msg = $error[key($error)];
						$result = array("status"=>"error","description"=>$msg,"type"=>key($error));
						echo json_encode($result);
						exit();
					};
				}

			}else{
				$result = array("status"=>"error","description"=>"Error de Autenticación","type"=>"autenticacion");
				echo json_encode($result);
				exit();
			}
		break;
		case 'recuperar':
			 $email = param('email_reset');
			    
			 if(strlen($email) > 0){
			    $email = trim($email);
			 	$cliente = Clientes::getResetPass("cliente_email = '{$email}'");
			 	if(haveRows($cliente)):
			 		if($cliente[0]['cliente_status'] == 0){
						$result = array('status'=>'error','description'=>'No se puede restablecer la contraseña. \n\r Su cuenta ha sido inhabilitada');
	                    echo json_encode($result);
	                    exit;
			 		}else{
			 			//Envio por email de las instrucciones
			 			$from = array("noresponder@catedral.com.py" => "CATEDRAL :: Sitio Web");
			            $to   = array(
			                $cliente[0]['cliente_email'] => $cliente[0]['cliente_email'],
			            );
			            $subject = "Restablecer Contraseña";
			            $template = "reset_password_template.html";

						$code = Encryption::Encrypt($cliente[0]['cliente_id']);

			            $data['cliente_nombre'] = "{$cliente[0]['cliente_nombre']}";
			            $data['tokenId'] = baseURL."restablecer?token=".$code."_".$cliente[0]['cliente_id'];
			            $data['imagen'] = baseURL."images/logo-farmacia-catedral-6-164x63.jpg";
			            #Enviar por email
			            //session_regenerate_id();
			            Mail::send($from, $to, $subject, $template, $data);

			            $result = array(
			            	"status"=>"success",
			            	"description"=>"Te hemos enviado las instrucciones para restablecer tu clave de acceso a tu cuenta de correo ".$cliente[0]['cliente_email'],
			            );
						echo json_encode($result);
						exit();
			 		}

			 	else:
			 		$result = array("status"=>"error","description"=>"Ocurrió un error al intentar restablecer la contraseña. Por favor, inténtelo nuevamente.");
					echo json_encode($result);
					exit();
			 	endif;

			 }else{
			 	$result = array("status"=>"error","description"=>"Completa el campo.");
				echo json_encode($result);
				exit();
			 }
		break;

		case 'cambio':
		    $code = param('token');
			$cliente_id = Encryption::Decrypt($code);

			if(!param('cliente_clave')):
				$result = array("status"=>"error","description" => "Completa el campo Contraseña","type"=>"cliente_clave");
				echo json_encode($result);
				exit();
			endif;

			if(param('cliente_clave') != param('cliente_clave2')){
				$result = array("status"=>"error","description" => "La contraseña no coincide","type"=>"cliente_pass2");
				echo json_encode($result);
				exit();
			}
			if(!passValidation_reg(param('cliente_clave'))){
				$result = array("status"=>"error","description" => "La clave debe tener entre 8 a 16 caracteres","type"=>"cliente_clave");
				echo json_encode($result);
				exit();
			}

			if($cliente_id > 0){
				$cliente = Clientes::select($cliente_id);
				if(haveRows($cliente)):

					#Actualizar solo contraseña
					$cliente_email = $cliente[0]['cliente_email'];

					$pass = md5($_POST['cliente_clave'] . "_" . strtoupper( strrev($cliente_email) ) );
					$update = Clientes::set("cliente_clave",$pass,"cliente_id=".$cliente_id);
					#Una vez actualizado actualizar session Id
					//Captcha::reset();
					//session_regenerate_id();
					$result = array(
						'status'=>'success',
						'description'=>'<div class="card col-12 col-md-12"><p class="mbr-text mbr-fonts-style mb-4 display-7"><b>Tu clave de acceso ha sido cambiada con éxito.</b> <br>Ya puedes
						<a href="javascript:;" data-toggle="modal" data-target="#loginSession" aria-expanded="false"> iniciar la sesión </a> con tu nueva contraseña.</p></div>');
					echo json_encode($result);
					exit();

				else:
					$result = array("status"=>"error","description"=>"Ocurrió un error al intentar restablecer la contraseña. Por favor, inténtelo nuevamente. #1","type"=>"autenticacion");
					echo json_encode($result);
					exit();
				endif;
			}else{
				$result = array("status"=>"error","description"=>"Ocurrió un error al intentar restablecer la contraseña. Por favor, inténtelo nuevamente. #2","type"=>"autenticacion");
				echo json_encode($result);
				exit();
			}
		break;

		case 'nombreCarrito':
			$nombreCarrito = param('nombre_carrito');
			#verifica si inicio session
			$cliente_id = $_SESSION['cliente']['cliente_id'];
			if($cliente_id > 0){
				#Verifica si ya existe un carrito
				if(strlen($nombreCarrito) > 0):
					
					$carrito = Carrito::get("cliente_id = ".$cliente_id); 
					#Verificar que el carrito tiene productos
					if(haveRows($carrito)){
						//$update = Carrito::set("carrito_nombre",$nombreCarrito,"carrito_id = ".$carrito[0]['carrito_id']);
						
							$verif_name = Compra_recurrente::get("compra_nombre LIKE '{$nombreCarrito}' ","compra_id ASC LIMIT 1");

							$save = haveRows($verif_name) ? $verif_name[0]['compra_id'] : 0;

							$_POST['cliente_id'] = $cliente_id;
							$_POST['compra_nombre'] = $nombreCarrito;
							$_POST['compra_status'] = 1;
							$compra_id = Compra_recurrente::save($save);
							
							if(is_array($compra_id)):
									$result = array('status'=>'error','description'=>'Error al guardar la compra recurrente','type'=>'error');
									print json_encode($result);
									exit;
							endif;
							#Consultamos los productos del carrito detalle actual
							$carrito_detalle = Carrito_detalle::get("carrito_id = ".$carrito[0]['carrito_id']);
							if(haveRows($carrito_detalle)){
								#Borramos todo
								$borrar = Compra_recurrente_detalle::borrar($compra_id);
								foreach ($carrito_detalle as $cd) {
									$_POST['compra_id'] = $compra_id;
									$_POST['producto_id'] = $cd['producto_id'];
									$_POST['producto_nombre'] = $cd['producto_nombre'];
									$_POST['detalle_cantidad'] = $cd['detalle_cantidad'];
									$_POST['detalle_status'] = 1;

									$detalles = Compra_recurrente_detalle::save(0);
								}
							}

						$result = array("status"=>"success");
						echo json_encode($result);
						exit();
					}else{
						$_SESSION['carrito']['nombre_carrito'] = $nombreCarrito;
						$result = array("status"=>"success");
						echo json_encode($result);
						exit();
					}
				endif;
			}else{
				$result = array("status"=>"error", "description" => "Para guardar un carrito debe iniciar sesion");
				echo json_encode($result);
				exit();
			}
		break;
		
		case 'iniciosesion':
			$cliente_id = $_SESSION['cliente']['cliente_id'];
			if($cliente_id > 0){
				$result = array("status"=>"success","description"=>"");
				echo json_encode($result);
				exit();
			}else{
				$result = array("status"=>"error","description"=>"Debe iniciar sesion para continuar");
				echo json_encode($result);
				exit();
			}
		break;
		
		case 'editaDireccion':
				$cliente_id = $_SESSION['cliente']['cliente_id'];
				$id = numParam('id');
				if($id > 0){
					$edit = Direcciones::select($id);
					if(haveRows($edit)){
						#Colocar todo a  0
						foreach ($edit as $rs) {
							Direcciones::set("direccion_predeterminado","0","cliente_id =".$cliente_id);
						}
						Direcciones::set("direccion_predeterminado","1","direccion_id =".$id);
						$result = array("status"=>"success","description"=>"Actualizado");
						echo json_encode($result);
						exit();
					}
			
				}

		break;
		case 'deleteDireccion':
				$cliente_id = $_SESSION['cliente']['cliente_id'];
				$id = numParam('id');
				if($id > 0){
					$edit = Direcciones::borrar($id);	
					$result = array("status"=>"success","description"=>"Borrado");
					echo json_encode($result);
					exit();		
				}

		break;
		default:
				$result = array("status"=>"error","description"=>"Error#1","type"=>"autenticacion");
				echo json_encode($result);
				exit();
		break;
	}
	
	
?>