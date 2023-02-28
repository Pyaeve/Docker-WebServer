<?php
class Coordenadas extends Mysql{
	protected $tableName	= "coordenadas";
	protected $primaryKey = "coordenada_id";
	protected $fields	= array(
		"zona_id"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"coordenada_numero"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"coordenada_latitud"	=> array("type" => "varchar",	"length"=> 150, "required" => "1", "validation" => "none"),
		"coordenada_longitud"	=> array("type" => "varchar",	"length"=> 150, "required" => "1", "validation" => "none"),
		"coordenada_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['zona_id']['value']	=	$_POST['zona_id'];
		$obj->fields['coordenada_numero']['value']	=	$_POST['coordenada_numero'];
		$obj->fields['coordenada_latitud']['value']	=	$_POST['coordenada_latitud'];
		$obj->fields['coordenada_longitud']['value']	=	$_POST['coordenada_longitud'];
		$obj->fields['coordenada_status']['value']	=	isset($_POST['coordenada_status']) ? number($_POST['coordenada_status']) : 0;

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
		$obj->change($obj->tableName, "coordenada_hidden", 1, $obj->primaryKey . " = {$id}");
	}
	
	
	public static function delete_coordenada($id){
		$obj = new self();
		$sql = "DELETE FROM coordenadas WHERE zona_id = {$id}";
		return $obj->execute($sql);
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "coordenada_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}coordenada_status = 1 AND coordenada_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}coordenada_status = 1 AND coordenada_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}coordenada_status = 1 AND coordenada_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}coordenada_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE coordenada_status = 1 AND coordenada_hidden = 0{$where}");
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
					self::set("coordenada_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("coordenada_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT coordenada_id, zona_id FROM coordenadas WHERE coordenada_status = 1 AND coordenada_hidden = 0 ORDER BY zona_id ASC";
		$list = $obj->exec($list);
		print '<select name="coordenada_id" id="coordenadas_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['coordenada_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['coordenada_id'].'"'.$select.'>'.htmlspecialchars($dat['zona_id']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
	public static function enArea($coordenada, $coordenadas_area_cobertura) {

		$j = count($coordenadas_area_cobertura) - 1;
		$oddNodes = false;

		for ($i = 0; $i < count($coordenadas_area_cobertura); $i++) {
		if (($coordenadas_area_cobertura[$i]['lng']< $coordenada['lng'] && $coordenadas_area_cobertura[$j]['lng']>=$coordenada['lng']
		||   $coordenadas_area_cobertura[$j]['lng']< $coordenada['lng'] && $coordenadas_area_cobertura[$i]['lng']>=$coordenada['lng'])
		&&  ($coordenadas_area_cobertura[$i]['lat']<=$coordenada['lat'] || $coordenadas_area_cobertura[$j]['lat']<=$coordenada['lat'])) {
		  if ($coordenadas_area_cobertura[$i]['lat']+($coordenada['lng']-$coordenadas_area_cobertura[$i]['lng'])/($coordenadas_area_cobertura[$j]['lng']-$coordenadas_area_cobertura[$i]['lng'])*($coordenadas_area_cobertura[$j]['lat']-$coordenadas_area_cobertura[$i]['lat'])<$coordenada['lat']) {
			$oddNodes=!$oddNodes; }}
		$j=$i; }

		return $oddNodes;

	}
	
	public static function zonas(){
		$obj = new self();
		$sql = "SELECT z.zona_id, z.zona_nombre, c.zona_id, c.coordenada_latitud, c.coordenada_longitud from zona_ecommerce z JOIN coordenadas AS c ON c.zona_id = z.zona_id";
		return $obj->execute($sql);
	}

}
?>