<?php 
	require_once('../../_sys/init.php');

	switch (param('accion')) {

		case 'ciudad':
			$departamento_id = numParam('id');
			$html="";

			if($departamento_id > 0){
				$ciudades = Ciudad::get("departamento_id = {$departamento_id}");
				if(haveRows($ciudades)){

                    $html.='<select name="ciudad_id" id="ciudad_id" class="form-control">
                    			<option value="0">Selecciona Ciudad</option>';

                    foreach ($ciudades as $city) {
						$html.='<option value="'. $city['ciudad_id'].'">'. $city['ciudad_nombre'].'</option>';
					}
					$html.='</select>';


					$result = array('status'=>'success','html'=>$html);
					print json_encode($result);
					exit;
				}else{
					$result = array('status'=>'error','html'=>'Sin datos');
					print json_encode($result);
					exit;
				}
			
			}else{
				$result = array('status'=>'error','html'=>'Sin datos');
				print json_encode($result);
				exit;
			}	
		break;
		
		default:
			# code...
			break;
	}
?>
