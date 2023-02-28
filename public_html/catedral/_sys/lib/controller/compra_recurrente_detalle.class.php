<?php
class Compra_recurrente_detalle extends Mysql{
	protected $tableName	= "compra_recurrente_detalle";
	protected $primaryKey = "detalle_id";
	protected $fields	= array(
		"compra_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"producto_id"	=> array("type" => "bigint", "required" => "1", "validation" => "none"),
		"producto_nombre"	=> array("type" => "varchar",	"length"=> 255, "required" => "1", "validation" => "none"),
		"detalle_cantidad"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"detalle_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['compra_id']['value']	=	$_POST['compra_id'];
		$obj->fields['producto_id']['value']	=	$_POST['producto_id'];
		$obj->fields['producto_nombre']['value']	=	$_POST['producto_nombre'];
		$obj->fields['detalle_cantidad']['value']	=	$_POST['detalle_cantidad'];
		$obj->fields['detalle_status']['value']	=	isset($_POST['detalle_status']) ? number($_POST['detalle_status']) : 0;

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
		$obj->change($obj->tableName, "detalle_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function borrar($id){
		$obj = new self();
		$sql = "DELETE FROM ".$obj->tableName." WHERE compra_id = {$id}";
		return $obj->execute($sql);
		
	}
	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "detalle_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_status = 1 AND detalle_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_status = 1 AND detalle_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_status = 1 AND detalle_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE detalle_status = 1 AND detalle_hidden = 0{$where}");
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
					self::set("detalle_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("detalle_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT detalle_id, compra_id FROM compra_recurrente_detalle WHERE detalle_status = 1 AND detalle_hidden = 0 ORDER BY compra_id ASC";
		$list = $obj->exec($list);
		print '<select name="detalle_id" id="compra_recurrente_detalle_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['detalle_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['detalle_id'].'"'.$select.'>'.htmlspecialchars($dat['compra_id']).'</option>';
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