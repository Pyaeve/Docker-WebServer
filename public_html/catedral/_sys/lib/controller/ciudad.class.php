<?php
class Ciudad extends Mysql{
	protected $tableName	= "ciudad";
	protected $primaryKey = "ciudad_id";
	protected $fields	= array(
		"departamento_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"ciudad_nombre"	=> array("type" => "varchar",	"length"=> 250, "required" => "1", "validation" => "none"),
		"costo_envio"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"ciudad_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['departamento_id']['value']	=	$_POST['departamento_id'];
		$obj->fields['ciudad_nombre']['value']	=	$_POST['ciudad_nombre'];

		$precio = array(",",".");
		$obj->fields['costo_envio']['value']	=	str_replace($precio, "", $_POST['costo_envio']);
		
		$obj->fields['ciudad_status']['value']	=	isset($_POST['ciudad_status']) ? number($_POST['ciudad_status']) : 0;

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
		$obj->change($obj->tableName, "ciudad_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "ciudad_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}ciudad_status = 1 AND ciudad_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}ciudad_status = 1 AND ciudad_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}ciudad_status = 1 AND ciudad_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}ciudad_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE ciudad_status = 1 AND ciudad_hidden = 0{$where}");
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
					self::set("ciudad_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("ciudad_status", 0, $obj->primaryKey . " = {$id}");
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

	public static function combobox($selected=null,$onchange=null,$where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT * FROM ciudad WHERE {$whr}ciudad_status = 1 AND ciudad_hidden = 0 ORDER BY departamento_id ASC";
		$list = $obj->exec($list);
		print '<select name="ciudad_id" id="ciudad_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['ciudad_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['ciudad_id'].'"'.$select.'>'.htmlspecialchars($dat['ciudad_nombre']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function combobox2($selected=null,$onchange=null,$where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";

		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT * FROM ciudad WHERE {$whr}ciudad_status = 1 AND ciudad_hidden = 0 ORDER BY departamento_id ASC";
		$list = $obj->exec($list);
		$html = '<select name="ciudad_id" id="ciudad_combo" style="color:#000;" onchange="">';
			$html .= '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['ciudad_id'] == $selected ? ' selected="selected"' : "";
					$html .= '<option value="'.$dat['ciudad_id'].'"'.$select.'>'.htmlspecialchars($dat['ciudad_nombre']).'</option>';
				endforeach;
			endif;
		$html .= '</select>';
		return $html;
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
}
?>