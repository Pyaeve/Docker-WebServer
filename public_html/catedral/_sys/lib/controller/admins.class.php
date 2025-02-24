<?php
class Admins extends Mysql{
	protected $tableName	= "admins";
	protected $primaryKey = "admin_id";
	protected $fields	= array(
		"admin_names"	=> array("type" => "varchar",	"length"=> 128, "required" => "1", "validation" => "none"),
		"admin_email"	=> array("type" => "varchar",	"length"=> 128, "required" => "1", "validation" => "email,unique"),
		"admin_password"	=> array("type" => "varchar",	"length"=> 32, "min" => "8", "required" => "1", "validation" => "none"),
		"admin_permission"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"admin_isroot"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"admin_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"admin_hidden"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"admin_last_login"	=> array("type" => "timestamp", "required" => "0", "validation" => "none"),
	);

	public function __construct(){
	}

	//-- inserta o modifica un registro

	public static function save($id){

		$obj = new self($id);

		$obj->fields['admin_names']['value']	= $_POST['admin_names'];
		$obj->fields['admin_email']['value']	= $_POST['admin_email'];
		$obj->fields['admin_status']['value']	= isset($_POST['admin_status']) ? number($_POST['admin_status']) : 0;
		$obj->fields['admin_hidden']['value']	= '0';
		$obj->fields['admin_isroot']['value']	= isset($_POST['admin_isroot']) ? number($_POST['admin_isroot']) : 0;

		if(Login::get("admin_isroot") == 1):
			foreach($_POST as $pk => $pv):
				if(strpos($pk, "_permission_") !== false):
					$key = explode("|", str_replace("_permission_","|",$pk));
					$permission[$key[0]][$key[1]] = true;
				endif;
			endforeach;

			$permission['admins']['update'] = true;
			$obj->fields['admin_permission']['value'] = json_encode($permission);
		endif;

		$pass = $_POST['admin_password'];
		if($id > 0):

			$res = self::select($id);
			if(Login::get("admin_isroot") == 1):
				$obj->fields['admin_isroot']['value'] = isset($_POST['admin_isroot']) ? number($_POST['admin_isroot']) : 0;
			else:
				$obj->fields['admin_isroot']['value'] = $res[0]['admin_isroot'];
			endif;
			if(!isset($permission)):
				$obj->fields['admin_permission']['value'] = $res[0]['admin_permission'];
			endif;

			if(count($res) > 0 && is_array($res)):

				$obj->fields['admin_random_seed']['value'] = $res[0]['admin_random_seed'];

				if(strlen($pass) == 0):
					$obj->fields['admin_password']['value'] = $res[0]['admin_password'];
				else:
					if(passValidation($pass)):
						$obj->fields['admin_password']['value']	= md5($_POST['admin_password'] . "_" . strtoupper(strrev($_POST['admin_email'])));
					else:
						$_POST['admin_password'] = null;
					endif;
				endif;

				if($_POST['admin_email'] != $res[0]['admin_email']):
					if(strlen($pass) == 0):
						$old_password = Encryption::Decrypt($res[0]['admin_random_seed'], strrev(md5($res[0]['admin_random_key'])));
						$obj->fields['admin_password']['value']	= md5("{$old_password}_" . strtoupper(strrev($_POST['admin_email'])));
					else:
						$obj->fields['admin_random_seed']['value'] = Encryption::Encrypt($pass, strrev(md5($res[0]['admin_random_key'])));
						$obj->fields['admin_password']['value']	= md5($_POST['admin_password'] . "_" . strtoupper(strrev($_POST['admin_email'])));
					endif;
				endif;

			endif;
		else:
			$random_key = uniqcode(16,16);
			if(strlen($pass) > 0):
				$obj->fields['admin_random_key']['value']	= $random_key;
				$obj->fields['admin_random_seed']['value']	= Encryption::Encrypt($pass, strrev(md5($random_key)));
				$obj->fields['admin_password']['value']		= md5($_POST['admin_password'] . "_" . strtoupper(strrev($_POST['admin_email'])));
			endif;

		endif;

		if($obj->validate($obj,$id)):
			$obj->update($obj, $id);
		else:
			if(passValidation($pass)):
				Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			else:
				Message::set("La clave debe tener entre 8 a 16 caracteres, al menos una letra mayúscula, una minúscula y un caracter numérico", MESSAGE_ERROR);
			endif;
			return $obj->error;
		endif;
	}

	//-- oculta o elimina un registro
	public static function delete($id){
		$obj = new self();

		$admin = self::select($id);

		if(count($admin) > 0):
			$root = $admin[0]['admin_isroot'] == 1 ? true : false;
		else:
			$root = false;
		endif;

		if(!$root):
			$delete = "UPDATE admins SET admin_hidden = 1 WHERE " . $obj->primaryKey . " = {$id}";
			$obj->Execute($delete);
		else:
			setApplicationJavascript();
			print "alert('El usuario es ROOT y no se puede eliminar');";
			exit;
		endif;
	}

	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}admin_status = 1 AND admin_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function set($field, $value, $where=null){
		$obj = new self();
		$obj->change($obj->tableName, $field, $value, $where);
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id);
	}

	public static function resetpassword($email, $newpassword){
		$obj = new self();

		$res = $obj->find($obj->tableName, "admin_email", $email);

	}

	public static function bulk($action, $ids){
		$obj = new self();
		$ids = json_decode($ids);

		switch($action):
			//activar
			case "1":
				foreach($ids as $id):
					$obj->change($obj->tableName, "admin_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					$obj->change($obj->tableName, "admin_status", 0, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//eliminar
			case "3":
				foreach($ids as $id):
					self::delete($id);
				endforeach;
				break;
		endswitch;

	}

	public static function permission($table,$action=null){
		if(login()):
			if(Login::get("admin_isroot") == 1):
				return true;
			else:

				$data = self::select(Login::get("admin_id"));

				if(haveRows($data)):

					$data = $data[0];

					$permission = @json_decode($data['admin_permission']);

					if($permission instanceof stdClass):

						if($action == null):

							eval('$allow_insert = $permission->' . $table . '->insert == 1 ? true : false;');
							eval('$allow_update = $permission->' . $table . '->update == 1 ? true : false;');
							eval('$allow_delete = $permission->' . $table . '->delete == 1 ? true : false;');
							return $allow_insert || $allow_update || $allow_delete ? true : false;

						else:

							eval('$allow = $permission->' . $table . '->' . strtolower($action) . ' == 1 ? true : false;');
							return $allow;

						endif;

					else:
						return false;
					endif;

				else:
					return false;
				endif;

			endif;
		else:
			return false;
		endif;
	}


	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}

}
?>
