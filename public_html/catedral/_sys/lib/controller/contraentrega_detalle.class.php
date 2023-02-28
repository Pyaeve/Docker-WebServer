<?php
class Contraentrega_detalle extends Mysql{
	protected $tableName	= "contraentrega_detalle";
	protected $primaryKey = "detalle_id";
	protected $fields	= array(
		"contraentrega_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"producto_id"	=> array("type" => "bigint", "required" => "1", "validation" => "none"),
		"producto_nombre"	=> array("type" => "varchar",	"length"=> 255, "required" => "0", "validation" => "none"),
		"producto_precio"	=> array("type" => "double", "required" => "1", "validation" => "none"),
		"detalle_cantidad"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"detalle_cantidad_ws"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"detalle_monto"	=> array("type" => "double", "required" => "0", "validation" => "none"),
		"detalle_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"detalle_timestamp"	=> array("type" => "timestamp", "required" => "0", "validation" => "none"),
		"detalle_pago"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['contraentrega_id']['value']	=	$_POST['contraentrega_id'];
		$obj->fields['producto_id']['value']	=	$_POST['producto_id'];
		$obj->fields['producto_nombre']['value']	=	$_POST['producto_nombre'];
		$obj->fields['producto_precio']['value']	=	$_POST['producto_precio'];
		$obj->fields['detalle_cantidad']['value']	=	$_POST['detalle_cantidad'];
		$obj->fields['detalle_cantidad_ws']['value']	=	$_POST['detalle_cantidad_ws'];
		$obj->fields['detalle_monto']['value']	=	$_POST['detalle_monto'];
		$obj->fields['detalle_status']['value']	=	isset($_POST['detalle_status']) ? number($_POST['detalle_status']) : 0;
		# 0-pendiente, 1-confirmado, 2-anulado 
		$obj->fields['detalle_pago']['value']	=	isset($_POST['detalle_pago']) ? number($_POST['detalle_pago']) : 0;

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
		$list = "SELECT detalle_id, detalle_name FROM contraentrega_detalle WHERE detalle_status = 1 AND detalle_hidden = 0 ORDER BY detalle_name ASC";
		$list = $obj->exec($list);
		print '<select name="detalle_id" id="contraentrega_detalle_combo" style="color:#000;">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['detalle_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['detalle_id'].'"'.$select.'>'.htmlspecialchars($dat['detalle_name']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}

	public static function getItems($cliente_id){
		$uid = $cliente_id;

		$check = Contraentrega::getLast("cliente_id = {$uid}");
		$contraentrega_id = ($check[0]['contraentrega_id']>0)?$check[0]['contraentrega_id']:0;

		$obj = new self();
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " INNER JOIN contraentrega ON (contraentrega.contraentrega_id = contraentrega_detalle.contraentrega_id) WHERE contraentrega_detalle.contraentrega_id = '".$contraentrega_id."' AND contraentrega.cliente_id = '".$uid."' AND contraentrega_detalle.detalle_status = 1 AND contraentrega_detalle.detalle_hidden = 0 {$ord}";
		return $obj->execute($sql);
	}

	public static function getItemsReenvio($contraentrega_id){

		$obj = new self();
		$sql = "SELECT * FROM " . $obj->tableName . " INNER JOIN productos ON (contraentrega_detalle.producto_id = productos.producto_id) WHERE contraentrega_detalle.contraentrega_id = ".$contraentrega_id;
		return $obj->execute($sql);
	}

}
?>
