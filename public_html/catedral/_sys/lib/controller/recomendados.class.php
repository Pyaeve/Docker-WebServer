<?php
class Recomendados extends Mysql{
	protected $tableName	= "recomendados";
	protected $primaryKey = "recomendado_id";
	protected $fields	= array(
		"producto_id"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"recomendado_fechacreado"	=> array("type" => "date", "required" => "0", "validation" => "none"),
		"recomendado_fechafin"	=> array("type" => "date", "required" => "0", "validation" => "none"),

		"recomendado_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['producto_id']['value']	=	$_POST['producto_id'];

		$fecha = date('Y-m-d', strtotime($_POST['recomendado_fechacreado']));
		$obj->fields['recomendado_fechacreado']['value']	=	$fecha;
		
		$fechaFin = date('Y-m-d', strtotime($_POST['recomendado_fechacreado']."+ 1 week"));
		$obj->fields['recomendado_fechafin']['value']	=	$fechaFin;


		$obj->fields['recomendado_status']['value']	=	isset($_POST['recomendado_status']) ? number($_POST['recomendado_status']) : 0;

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
		$obj->change($obj->tableName, "recomendado_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "recomendado_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}recomendado_status = 1 AND recomendado_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}recomendado_status = 1 AND recomendado_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}recomendado_status = 1 AND recomendado_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}recomendado_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE recomendado_status = 1 AND recomendado_hidden = 0{$where}");
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
					self::set("recomendado_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("recomendado_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT recomendado_id, producto_id FROM recomendados WHERE recomendado_status = 1 AND recomendado_hidden = 0 ORDER BY producto_id ASC";
		$list = $obj->exec($list);
		print '<select name="recomendado_id" id="recomendados_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['recomendado_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['recomendado_id'].'"'.$select.'>'.htmlspecialchars($dat['producto_id']).'</option>';
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