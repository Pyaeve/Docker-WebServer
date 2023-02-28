<?php
class Contactos extends Mysql{
	protected $tableName	= "contactos";
	protected $primaryKey = "contacto_id";
	protected $fields	= array(
		"contacto_nombre"	=> array("type" => "varchar",	"length"=> 255, "required" => "1", "validation" => "none"),
		"contacto_documento"	=> array("type" => "varchar",	"length"=> 255, "required" => "1", "validation" => "none"),
		"contacto_telefono"	=> array("type" => "varchar",	"length"=> 255, "required" => "1", "validation" => "none"),
		"contacto_email"	=> array("type" => "varchar",	"length"=> 255, "required" => "1", "validation" => "none"),
		"contacto_asunto"	=> array("type" => "varchar",	"length"=> 255, "required" => "1", "validation" => "none"),
		"contacto_mensaje"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"contacto_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['contacto_nombre']['value']	=	$_POST['contacto_nombre'];
		$obj->fields['contacto_documento']['value']	=	$_POST['contacto_documento'];
		$obj->fields['contacto_telefono']['value']	=	$_POST['contacto_telefono'];
		$obj->fields['contacto_email']['value']	=	$_POST['contacto_email'];
		$obj->fields['contacto_asunto']['value']	=	$_POST['contacto_asunto'];
		$obj->fields['contacto_mensaje']['value']	=	$_POST['contacto_mensaje'];
		$obj->fields['contacto_status']['value']	=	isset($_POST['contacto_status']) ? number($_POST['contacto_status']) : 0;

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
		$obj->change($obj->tableName, "contacto_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "contacto_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contacto_status = 1 AND contacto_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contacto_status = 1 AND contacto_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contacto_status = 1 AND contacto_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contacto_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE contacto_status = 1 AND contacto_hidden = 0{$where}");
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
					self::set("contacto_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("contacto_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT contacto_id, contacto_nombre FROM contactos WHERE contacto_status = 1 AND contacto_hidden = 0 ORDER BY contacto_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="contacto_id" id="contactos_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['contacto_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['contacto_id'].'"'.$select.'>'.htmlspecialchars($dat['contacto_nombre']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
}
?>