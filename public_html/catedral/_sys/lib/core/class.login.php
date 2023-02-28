<?php
class Login extends Mysql {
	
	public static function set($email, $passw){

		$obj = new self();
		
		$email 	= addslashes(strtolower(trim($email)));
		$passw	= md5($passw . "_" . strrev(strtoupper($email)));
		
		$result	= $obj->find("admins", "admin_email", $email, "admin_status = 1 AND admin_hidden = 0");
		
		if(is_array($result) && count($result) > 0):
		
			$result = $result[0];
			
			$_POST['admin_id'] = $result['admin_id'];
			$_POST['admin_login_ip_address'] = getIpAddress();
			
			if($result['admin_password'] != $passw || $result['admin_status'] != 1):
				
				$_POST['admin_login_response'] = "FAILED";
				Admin_login_attempts::save(0);
				return false;
			else:
				foreach($result as $k => $v):
					$data[Encryption::Encrypt($k)] = Encryption::Encrypt($v);
				endforeach;
				$_SESSION[Encryption::Encrypt(adminLogin)]	= $data;
				$_POST['admin_login_response'] = "SUCCESSFUL";
				Admin_login_attempts::save(0);
				$last_login = "UPDATE admins SET admin_last_login = NOW() WHERE admin_id = {$result['admin_id']}";
				$obj->execute($last_login);
				return true;
			endif;
			
		else:
			return false;
		endif;	
	
	}

	public static function status(){
		//echo "<script>console.log('hola mundo 2');</script>";
		if(isset($_SESSION[Encryption::Encrypt(adminLogin)])):
			$status = $_SESSION[Encryption::Encrypt(adminLogin)];
			$status = count($status);
			return $status > 0 ? true : false;
		else:
			return false;
		endif;
	}

    public static function get($var){
		//echo "<script>console.log('hola mundo 3');</script>";
		$data = $_SESSION[Encryption::Encrypt(adminLogin)][Encryption::Encrypt($var)];
		return Encryption::Decrypt($data);
		
	}
	
	public static function access($section){
		//echo "<script>console.log('hola mundo 4');</script>";
		if(self::status()):
			
			$permission = self::get("admin_permission");
			
			if($permission == "full"):
				return true;
			else:
				if(is_array($permission->access) && count($permission) > 0):
					return in_array($section, $permission->access) ? true : false;
				else:
					return false;
				endif;
			endif;
		else:
			return false;
		endif;
		
	}
	
    //-- crea instancia de la clase
	static private function getInstance($id=null) {
        return new self($id);
    }

      	//Login
	public static function setLogin($email,$password){
		
		$obj = new self();
		$pass = md5($password. "_" .strtoupper(strrev($email)));
		$data = $obj->find("clientes", "cliente_email", $email, "cliente_status = 1 AND cliente_hidden = 0");
		//echo "<script>console.log('hola mundo 5');</script>";
		if(haveRows($data)):
			$data = $data[0];
			if($pass != $data['cliente_clave']):
				$_POST['cliente_login_response'] = "FAILED";
				$rtn = false;
			else:
				foreach($data as $dk => $dv):
					$data[Encryption::Encrypt($k)] = Encryption::Encrypt($v);
					//$_SESSION[Encryption::Encrypt(puntopie_login)][Encryption::Encrypt($dk)] = Encryption::Encrypt($dv);
				endforeach;
				$_SESSION['cliente']['cliente_id'] = $data['cliente_id'];
				$_SESSION['cliente']['cliente_nombre'] = $data['cliente_nombre'];
				$_SESSION['cli_reg'] = md5(date("Y-m-d H:m"));

				$_SESSION[Encryption::Encrypt(userLogin)]	= $data;
				$rtn = true;
			endif;
		else:
			$rtn = false;
		endif;
		return $rtn;
	}

	public static function setLoginGoogle($email,$password){
		
		$obj = new self();
		$pass = md5($password. "_" .strtoupper(strrev($email)));
		$data = $obj->find("clientes", "cliente_email", $email, "cliente_status = 1 AND cliente_hidden = 0");
		//echo "<script>console.log('hola mundo 5');</script>";
		if(haveRows($data)):
			$data = $data[0];
			if($pass == $data['cliente_clave']):
				$_POST['cliente_login_response'] = "FAILED";
				$rtn = false;
			else:
				foreach($data as $dk => $dv):
					$data[Encryption::Encrypt($k)] = Encryption::Encrypt($v);
					//$_SESSION[Encryption::Encrypt(puntopie_login)][Encryption::Encrypt($dk)] = Encryption::Encrypt($dv);
				endforeach;
				$_SESSION['cliente']['cliente_id'] = $data['cliente_id'];
				$_SESSION['cliente']['cliente_nombre'] = $data['cliente_nombre'];
				$_SESSION['cli_reg'] = md5(date("Y-m-d H:m"));

				$_SESSION[Encryption::Encrypt(userLogin)]	= $data;
				$rtn = true;
			endif;
		else:
			$rtn = false;
		endif;
		return $rtn;
	}

}

?>