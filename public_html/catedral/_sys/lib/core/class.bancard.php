<?php
class Bancard {
	/*BANCARD*/
    private     $private_key	=  'GRhVTPcYF.kkb.(xNxbfOtJtcntZIu5m(gA8lZ9n';
    private     $public_key		= 'rra93UtE8y6DF5Yiok3pH6dtUP4VBAHc';
	private $service_url	= 'https://vpos.infonet.com.py/vpos/api/0.3/single_buy/rollback';
	
	public static function rollback($order_id){
		$obj = new self();

		if($order_id > 0):

			$token = md5($obj->private_key . $order_id . "rollback" . "0.00");

			$data = array(
				"public_key" => $obj->public_key,
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

			return $response = json_decode($session_response);
		endif;

	}

	public static function test(){
		return "Hola";
	}
}
?>
