<?php
class Clientes extends Mysql{
	protected $tableName	= "clientes";
	protected $primaryKey = "cliente_id";
	protected $fields	= array(
		"cliente_email"	=> array("type" => "varchar",	"length"=> 255, "required" => "0", "validation" => "unique"),
		"cliente_clave"	=> array("type" => "varchar",	"length"=> 32, "required" => "1", "validation" => "none"),
		"cliente_key"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"cliente_nombre"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_apellido"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_ciudad"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"cliente_barrio"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),

		"cliente_direccion"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_telefono"	=> array("type" => "varchar",	"length"=> 20, "required" => "1", "validation" => "none"),
		"cliente_oferta_correo"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"cliente_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		#Persona Fisica = F | Empresa = J
		"cliente_tipo"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"cliente_cedula"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_ruc"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['cliente_email']['value']	=	$_POST['cliente_email'];
		$obj->fields['cliente_key']['value']	=	$_POST['cliente_key'];
		$obj->fields['cliente_nombre']['value']	=	$_POST['cliente_nombre'];
		$obj->fields['cliente_apellido']['value']	=	$_POST['cliente_apellido'];
		
		$obj->fields['cliente_ciudad']['value']	=	$_POST['cliente_ciudad'];
		$obj->fields['cliente_barrio']['value']	=	$_POST['cliente_barrio'];
		$obj->fields['cliente_direccion']['value']	=	$_POST['cliente_direccion'];
		
		$obj->fields['cliente_cedula']['value']	=	$_POST['cliente_cedula'];
		$obj->fields['cliente_ruc']['value']	=	$_POST['cliente_ruc'];

		$obj->fields['cliente_telefono']['value']	=	$_POST['cliente_telefono'];
		$obj->fields['cliente_oferta_correo']['value']	=	isset($_POST['cliente_oferta_correo']) ? number($_POST['cliente_oferta_correo']) : 0;
		$obj->fields['cliente_status']['value']	=	isset($_POST['cliente_status']) ? number($_POST['cliente_status']) : 0;
		$obj->fields['cliente_tipo']['value']	=	isset($_POST['cliente_tipo']) ? number($_POST['cliente_tipo']) : 1;

		$pass = $_POST['cliente_clave'];
		if($id > 0):
			$res = self::select($id);
			if(count($res) > 0 && is_array($res)):
				if(strlen($pass) == 0):
					$obj->fields['cliente_clave']['value'] = $res[0]['cliente_clave'];
				else:
					$obj->fields['cliente_clave']['value']	= md5($_POST['cliente_clave'] . "_" . strtoupper(strrev($_POST['cliente_email'])));
				endif;
			endif;
		else:
			if(strlen($pass) > 0):
				$obj->fields['cliente_clave']['value']		= md5($_POST['cliente_clave'] . "_" . strtoupper(strrev($_POST['cliente_email'])));
			endif;
		endif;

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "cliente_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "cliente_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}cliente_status = 1 AND cliente_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}cliente_status = 1 AND cliente_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}cliente_status = 1 AND cliente_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}cliente_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE cliente_status = 1 AND cliente_hidden = 0{$where}");
	}

	public static function set($field, $value, $where=null){
		$obj = new self();
		$obj->change($obj->tableName, $field, $value, $where);
	}

	public static function bulk($action, $ids){

		$obj = new self();
		$ids = json_decode($ids);

		switch($action):
			//activar
			case "1":
				foreach($ids as $id):
					self::set("cliente_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("cliente_status", 0, $obj->primaryKey . " = {$id}");
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

	public static function combobox($selected=null,$onchange=null){
		$obj = new self();
		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT cliente_id, cliente_email FROM clientes WHERE cliente_status = 1 AND cliente_hidden = 0 ORDER BY cliente_email ASC";
		$list = $obj->exec($list);
		print '<select name="cliente_id" id="clientes_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['cliente_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['cliente_id'].'"'.$select.'>'.htmlspecialchars($dat['cliente_email']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}

	public static function login($data=null){
		if($data == null):
			return isset($_SESSION[Encryption::Encrypt(userLogin)]) ? true : false;
		else:
			return isset($_SESSION[Encryption::Encrypt(userLogin)][Encryption::Encrypt($data)]) ? Encryption::Decrypt($_SESSION[Encryption::Encrypt(userLogin)][Encryption::Encrypt($data)]) : "";
		endif;
	}

	public static function getResetPass($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} {$ord}";
		return $obj->execute($sql);
	}
}
?>