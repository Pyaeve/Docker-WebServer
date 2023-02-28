<?php
class Sucursales extends Mysql{
	protected $tableName	= "sucursales";
	protected $primaryKey = "sucursal_id";
	protected $fields	= array(
		"sucursal_nombre"	=> array("type" => "varchar",	"length"=> 100, "required" => "0", "validation" => "none"),
		"sucursal_codigo"  => array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
		"sucursal_direccion"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"departamento_id"	=> array("type" => "int",	"length"=> 11, "required" => "0", "validation" => "none"),
		"ciudad_id"	=> array("type" => "int",	"length"=> 11, "required" => "0", "validation" => "none"),
		"sucursal_tel"	=> array("type" => "varchar",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"sucursal_email"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"sucursal_horarios"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"sucursal_ubicacion"	=> array("type" => "varchar",	"length"=> 200, "required" => "1", "validation" => "none"),
		"sucursal_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
		"sucursal_delivery" => array("type" => "tinyint", "required" => "1", "validation" => "none"),

	);

	/*inserta o modifica un registro*/

	public static function save($id){
		$obj = new self($id);
		function cleararray($valor){
		    foreach ($valor as $key => $result) {
		      if(empty($result)){
		          unset($valor[$key]);
		      }
		      $arrayregenerado = array_merge($valor);
		    }
		    return $arrayregenerado;
		}

		$obj->fields['sucursal_nombre']['value']	=	$_POST['sucursal_nombre'];
		$obj->fields['sucursal_codigo']['value']	=	$_POST['sucursal_codigo'];
		
		$obj->fields['sucursal_direccion']['value']	=	$_POST['sucursal_direccion'];
		$obj->fields['ciudad_id']['value']			=	$_POST['ciudad_id'];
		$obj->fields['departamento_id']['value']	=	$_POST['departamento_id'];
		$obj->fields['sucursal_ubicacion']['value']	=	$_POST['sucursal_ubicacion'];
		$obj->fields['sucursal_status']['value']	=	isset($_POST['sucursal_status']) ? number($_POST['sucursal_status']) : 0;
		$obj->fields['sucursal_delivery']['value']	=	isset($_POST['sucursal_delivery']) ? number($_POST['sucursal_delivery']) : 0;

		$sucursal_horarios = cleararray($_POST['dato_info']);
		$obj->fields['sucursal_horarios']['value']	=	json_encode($sucursal_horarios);

		$sucursal_tel = cleararray($_POST['dato_infotel']);
		$obj->fields['sucursal_tel']['value']	=	json_encode($sucursal_tel);

		$sucursal_email = cleararray($_POST['dato_infoemail']);
		$obj->fields['sucursal_email']['value']	=	json_encode($sucursal_email);


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
		$obj->change($obj->tableName, "sucursal_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "sucursal_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}sucursal_status = 1 AND sucursal_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}sucursal_status = 1 AND sucursal_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}sucursal_status = 1 AND sucursal_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}sucursal_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE sucursal_status = 1 AND sucursal_hidden = 0{$where}");
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
					self::set("sucursal_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("sucursal_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT sucursal_id, sucursal_nombre FROM sucursales WHERE sucursal_status = 1 AND sucursal_hidden = 0 ORDER BY sucursal_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="sucursal_id" id="sucursales_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['sucursal_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['sucursal_id'].'"'.$select.'>'.htmlspecialchars($dat['sucursal_nombre']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function comboboxDelivery($selected=null,$onchange=null){
		$obj = new self();
		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT sucursal_id, sucursal_nombre FROM sucursales WHERE sucursal_status = 1 AND sucursal_hidden = 0 AND sucursal_delivery = 1 ORDER BY sucursal_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="sucursal_id" id="sucursales_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['sucursal_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['sucursal_id'].'"'.$select.'>'.htmlspecialchars($dat['sucursal_nombre']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}
	
	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
	public static function opcionfiltro(){
		$obj = new self();
		$sql = "SELECT s.sucursal_nombre FROM sucursales s
				WHERE s.sucursal_status = 1 AND s.sucursal_hidden = 0 ";
		return $obj->execute($sql);
	}
	
}
?>