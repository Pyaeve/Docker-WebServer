<?php
require ("../_sys/init.php");

$order_id = number_format($_GET['order'],0,"","");

if($order_id > 0):

	$token = md5($private_key . $order_id . "rollback" . "0.00");

	$data = array(
		"public_key" => $public_key,
		"operation"	 => array(
			"token"				=> $token,
			"shop_process_id"	=> $order_id
		),
	);

	$session = curl_init($obj->service_url);
	curl_setopt($session, CURLOPT_POST, 1);
    curl_setopt($session, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($session, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
    curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
	$session_response = curl_exec($session);
	curl_close($session);

	$response = json_decode($session_response);

    Contraentrega::set('contraentrega_status',3,"contraentrega_id = {$order_id}");
	$cancel_url	= baseURL.'cancel_payment.php?order='.$order_id;
	header("Location:".$cancel_url);


endif;
?>
