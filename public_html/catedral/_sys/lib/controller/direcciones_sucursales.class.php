<?php
class Direcciones_sucursales extends Mysql{
	protected $tableName	= "direcciones_sucursales";
	protected $primaryKey = "direccion_sucursal_id";
	protected $fields	= array(
		"direccion_sucursal_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"direccion_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"sucursal_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"distancia_km"	=> array("type" => "double", "required" => "0", "validation" => "none"),
		"direccion_sucursal_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"direccion_sucursal_hidden"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"direccion_sucursal_timestamp"	=> array("type" => "timestamp	", "required" => "0", "validation" => "none"),
	);

	/*inserta un registro*/

	public static function save($id){

		$obj = new self();
		$sql = "INSERT INTO direcciones_sucursales (direccion_id, sucursal_id, distancia_km) 
		VALUES (".$_POST['direccion_id'].", ".$_POST['sucursal_id'].", ".$_POST['distancia_km'].");";
		return $obj->execute($sql);

	}

	public static function truncate(){

		$obj = new self();
		$sql = "TRUNCATE TABLE direcciones_sucursales;";
		return $obj->execute($sql);

	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "direccion_sucursal_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function borrar($id){
		$obj = new self();
		if($id > 0){
			$sql = "DELETE FROM direcciones_sucursales WHERE direccion_sucursal_id = {$id};";
			return $obj->execute($sql);
		}
	}

	public static function borrar2($id){
		$obj = new self();
		if($id > 0){
			$sql = "DELETE FROM direcciones_sucursales WHERE direccion_id = {$id};";
			return $obj->execute($sql);
		}
	}
	public static function borrarduplicados(){
		$obj = new self();
		$sql = "DELETE t1 FROM direcciones_sucursales t1
		INNER JOIN direcciones_sucursales t2 
		WHERE t1.direccion_sucursal_id < t2.direccion_sucursal_id
		AND t1.direccion_id = t2.direccion_id
		AND t1.sucursal_id = t2.sucursal_id";
		return $obj->execute($sql);
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "direccion_sucursal_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_sucursal_status = 1 AND direccion_sucursal_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getjoin($id){
		if($id > 0){
			$obj = new self();
			$sql = "SELECT ds.sucursal_id, ds.distancia_km FROM direcciones d 
			JOIN direcciones_sucursales ds
			ON d.direccion_id = ds.direccion_id
			WHERE d.cliente_id = $id
			AND d.direccion_predeterminado = 1
			GROUP BY ds.sucursal_id, ds.distancia_km
			ORDER BY ds.distancia_km ASC";
			return $obj->execute($sql);
		}
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_sucursal_status = 1 AND direccion_sucursal_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_sucursal_status = 1 AND direccion_sucursal_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_sucursal_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE direccion_sucursal_status = 1 AND direccion_sucursal_hidden = 0{$where}");
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
					self::set("direccion_sucursal_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("direccion_sucursal_status", 0, $obj->primaryKey . " = {$id}");
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

	/*public static function combobox($selected=null,$onchange=null){
		$obj = new self();
		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT direccion_id, cliente_id FROM direcciones WHERE direccion_status = 1 AND direccion_hidden = 0 ORDER BY cliente_id ASC";
		$list = $obj->exec($list);
		print '<select name="direccion_id" id="direcciones_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['direccion_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['direccion_id'].'"'.$select.'>'.htmlspecialchars($dat['cliente_id']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}*/
	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
}
?>