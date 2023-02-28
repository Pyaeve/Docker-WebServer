<?php
class Parametros extends Mysql{
	protected $tableName	= "parametros";
	protected $primaryKey = "parametro_id";
	protected $fields	= array(
		"para_parametro"	=> array("type" => "varchar",	"length"=> 250, "required" => "1", "validation" => "unique"),
		"para_valor"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"para_valor_numerico"	=> array("type" => "int",	"length"=> 11, "required" => "0", "validation" => "none"),
		"parametro_status"	=> array("type" => "int",	"length"=> 11, "required" => "0", "validation" => "none"),
		"parametro_timestamp"	=> array("type" => "timestamp ", "required" => "0", "validation" => "none")
	);

	public function __construct(){
	}

	//-- inserta o modifica un registro

	public static function save($id){

		$obj = new self($id);

		$obj->fields['para_parametro']['value']	= $_POST['para_parametro'];
		$obj->fields['para_valor']['value']	= $_POST['para_valor'];
		$obj->fields['para_valor_numerico']['value']	= $_POST['para_valor_numerico'];
		$obj->fields['parametro_status']['value']	= isset($_POST['parametro_status']) ? number($_POST['parametro_status']) : 0;

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
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
			$delete = "UPDATE parametros SET parametro_hidden = 1 WHERE " . $obj->primaryKey . " = {$id}";
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
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} parametro_status = 1 AND parametro_hidden = 0{$ord}";
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

	

	public static function bulk($action, $ids){
		$obj = new self();
		$ids = json_decode($ids);

		switch($action):
			//activar
			case "1":
				foreach($ids as $id):
					$obj->change($obj->tableName, "parametro_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					$obj->change($obj->tableName, "parametro_status", 0, $obj->primaryKey . " = {$id}");
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
