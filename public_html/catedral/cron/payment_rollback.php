<?php
require_once("/hosting/farmaciacatedral/public_html/_sys/init.php");
$db = new DB();
$time_limit = 600;
$sql = "SELECT * FROM contraentrega WHERE contraentrega_status = 1 AND contraentrega_formapago = 2 AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(contraentrega_timestamp) > {$time_limit}";
$res = $db->execute($sql);
print "[".date("Y-m-d H:i:s")."] Rolbacks: " . count($res)."\n";
if(count($res) > 0 && is_array($res)):
	foreach($res as $result):

    	$order_id = $result['contraentrega_id'];
    	if($order_id > 0):
    
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
    
    			$response = json_decode($session_response);
    			//pr($response);
    			//pr($order_id);
    			$update = "UPDATE contraentrega SET contraentrega_status = 3 WHERE contraentrega_id = '{$result['contraentrega_id']}'";
		        $db->execute($update);
    	endif;
		
	
	endforeach;
endif;

?>

