<?php
require_once("../_sys/init.php");

if($_SERVER['REQUEST_METHOD'] == "POST"):

	$data			= file_get_contents("php://input");
	$response		= json_decode($data);

	$log_file_name	= date("YmdHis");
	$order_id		= $response->operation->shop_process_id;

	$response_log = "INSERT INTO payment_response SET pedido_id = " . $order_id . ", response_text = '".addslashes($data)."'";
	
	db::execute($response_log);

	$order_id = $response->operation->shop_process_id;

	$cliente = Clientes::select($_SESSION['cliente']['cliente_id']);
	if($response->operation->response_code == "00"):
	    	#Pago contraentrega_status
    		# 1-Pendiente
    		# 2-Confirmado
    		# 3-Rechazado
            Contraentrega::set("contraentrega_status",2,"contraentrega_id = {$order_id}");
			$pedidos_data = Contraentrega::getLast("contraentrega_id= {$order_id}");
			if(haveRows($pedidos_data)):
						$detalles_data = Contraentrega_detalle::get("contraentrega_id = {$pedidos_data[0]['contraentrega_id']}");

						if(haveRows($detalles_data)):
							$listado = '';
							$total = 0;
							foreach($detalles_data as $rs){
								$detalle_precio   = number_format($rs['producto_precio'],0,'','.');
								$precioXcantidad  = $rs['producto_precio']*$rs['detalle_cantidad'];
								$detalle_subtotal = number_format($precioXcantidad,0,'','.');
								$producto = Productos::select($rs['producto_id']);
								$producto = $producto[0];
                                
                                $total += $precioXcantidad;
							    $listado.='<tr>
		                          <td align="left">'.$producto["producto_nombre"].'</td>
		                          <td align="center">'.$producto["producto_codigo"].'</td>
		                          <td align="center">'.number_format($producto['producto_precio'],0,"",".").'</td>
		                          <td align="center">'.$rs['detalle_cantidad'].'</td>
		                          <td align="right">Gs. '.number_format($precioXcantidad,0,"",".").'</td>
		                      	</tr>';
							}
						endif;
			endif;
	else:
		#Pago rechazado
		# 1-Pendiente
		# 2-Confirmado
		# 3-Rechazado
		Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$order_id}");
		$token = md5($private_key . $order_id . "rollback" . "0.00");

		$data = array(
			"public_key" => $public_key,
			"operation"	 => array(
				"token"				=> $token,
				"shop_process_id"	=> $order_id
			),
		);

		$session = curl_init($rollback);
		curl_setopt($session, CURLOPT_POST, 1);
        curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
		$session_response = curl_exec($session);
		curl_close($session);
	endif;

	ob_end_clean();

else:
	ob_end_clean();
	header("HTTP/1.0 404 Not Found");
	exit();
endif;
?>
