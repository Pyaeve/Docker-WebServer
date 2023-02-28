<?php
class Direcciones extends Mysql{
	protected $tableName	= "direcciones";
	protected $primaryKey = "direccion_id";
	protected $fields	= array(
		"cliente_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"sucursal_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"direccion_denominacion"	=> array("type" => "varchar",	"length"=> 150, "required" => "1", "validation" => "none"),
		"direccion_slugit"	=> array("type" => "varchar",	"length"=> 150, "required" => "0", "validation" => "none"),
		"direccion_ciudad"	=> array("type" => "varchar",	"length"=> 50, "required" => "1", "validation" => "none"),
		"direccion_barrio"	=> array("type" => "varchar",	"length"=> 50, "required" => "1", "validation" => "none"),
		"direccion_tel"	=> array("type" => "varchar",	"length"=> 50, "required" => "1", "validation" => "none"),
		"direccion_nrocasa"	=> array("type" => "varchar",	"length"=> 50, "required" => "1", "validation" => "none"),

		"direccion_direccion"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"direccion_mapa"	=> array("type" => "varchar",	"length"=> 120, "required" => "1", "validation" => "none"),
		"direccion_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
		"direccion_predeterminado"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);
		if(isset($_POST['cliente_id']) == 0){
			$dir = Direcciones::get("direccion_id = $id","");
			if(haveRows($dir)){
				$_POST['cliente_id'] 		= $dir[0]["cliente_id"];
				$_POST['direccion_nrocasa'] = isset($_POST['direccion_nrocasa']) ? number($_POST['direccion_nrocasa']) : $dir[0]["direccion_nrocasa"];
			}
		}
		$obj->fields['cliente_id']['value']	=	$_POST['cliente_id'];
		$obj->fields['sucursal_id']['value']	=	$_POST['sucursal_id'];
		$obj->fields['direccion_denominacion']['value']	=	$_POST['direccion_denominacion'];
		
		if($id > 0){
			$obj->fields['direccion_slugit']['value']	=	slugit($_POST['direccion_denominacion'].$id);
		}else{
			$numero = Direcciones::getLast();
			$numero = $numero[0]['direccion_id']+1;
			$obj->fields['direccion_slugit']['value']	=	slugit($_POST['direccion_denominacion'].$numero);
		}


		$obj->fields['direccion_ciudad']['value']			=	$_POST['direccion_ciudad'];
		$obj->fields['direccion_barrio']['value']			=	$_POST['direccion_barrio'];
		$obj->fields['direccion_tel']['value']				=	$_POST['direccion_tel'];
		$obj->fields['direccion_nrocasa']['value']			=	$_POST['direccion_nrocasa'];
		$obj->fields['direccion_direccion']['value']		=	$_POST['direccion_direccion'];
		$obj->fields['direccion_mapa']['value']				=	$_POST['direccion_mapa'];
		$obj->fields['direccion_status']['value']			=	isset($_POST['direccion_status']) ? number($_POST['direccion_status']) : 0;
		$obj->fields['direccion_predeterminado']['value']	=	$_POST['direccion_predeterminado'];

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			//Message::set("idc " .$_POST['cliente_id']." # ".$_POST['direccion_nrocasa'], MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "direccion_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function borrar($id){
		$obj = new self();
		if($id > 0){
			$sql = "DELETE FROM direcciones WHERE direccion_id = {$id};";
			return $obj->execute($sql);
		}
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "direccion_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_status = 1 AND direccion_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_status = 1 AND direccion_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_status = 1 AND direccion_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}direccion_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE direccion_status = 1 AND direccion_hidden = 0{$where}");
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
					self::set("direccion_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("direccion_status", 0, $obj->primaryKey . " = {$id}");
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
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}

	public static function update_coordenadas($direccion_mapa, $id){
		//if(strlen($campos) > 0 && $id > 0){
			$update = "UPDATE $obj->tableName SET direccion_mapa = $direccion_mapa WHERE " . $obj->primaryKey . " = {$id}";
			$obj->Execute($update);
		//}
		
	}
	
}
?>