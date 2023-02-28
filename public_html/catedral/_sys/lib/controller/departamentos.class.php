<?php
class Departamentos extends Mysql{
	protected $tableName	= "departamentos";
	protected $primaryKey = "departamento_id";
	protected $fields	= array(
		"departamento_nombre"	=> array("type" => "varchar",	"length"=> 250, "required" => "1", "validation" => "none"),
		"departamento_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		//"departamento_timestamp"	=> array("type" => "timestamp", "required" => "1", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['departamento_nombre']['value']	=	$_POST['departamento_nombre'];
		$obj->fields['departamento_status']['value']	=	isset($_POST['departamento_status']) ? number($_POST['departamento_status']) : 0;

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
		$obj->change($obj->tableName, "departamento_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "departamento_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}departamento_status = 1 AND departamento_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}departamento_status = 1 AND departamento_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}departamento_status = 1 AND departamento_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}departamento_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE departamento_status = 1 AND departamento_hidden = 0{$where}");
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
					self::set("departamento_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("departamento_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT departamento_id, departamento_nombre FROM departamentos WHERE departamento_status = 1 AND departamento_hidden = 0 ORDER BY departamento_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="departamento_id" id="departamentos_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['departamento_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['departamento_id'].'"'.$select.'>'.htmlspecialchars($dat['departamento_nombre']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function comboDept($selected=null,$onchange=null){
		$obj = new self();
		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT departamento_id, departamento_nombre FROM departamentos WHERE departamento_status = 1 AND departamento_hidden = 0 ORDER BY departamento_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="departamento_id" id="departamentos_combo" style="color:#000;" onchange="" class="form-control">';
			print '<option value=""'.$fsel.'>Selecciona Departamento</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['departamento_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['departamento_id'].'"'.$select.'>'.htmlspecialchars( ucfirst(strtolower($dat['departamento_nombre'])) ).'</option>';
				endforeach;
			endif;
		print '</select>';
	}
	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
	public static function dept_disponible(){
		$obj = new self();
		$query = "SELECT d.* FROM departamentos d JOIN loteamientos l ON l.departamento_id = d.departamento_id WHERE l.loteamiento_status = 1 AND l.loteamiento_hidden = 0 GROUP BY d.departamento_id";
		return $obj->execute($query);
	}
}
?>