<?php
class Contraentrega extends Mysql{
	protected $tableName	= "contraentrega";
	protected $primaryKey = "contraentrega_id";
	protected $fields	= array(
		"cliente_id"	=> array("type" => "bigint", "required" => "1", "validation" => "none"),
		"carrito_id"	=> array("type" => "bigint", "required" => "0", "validation" => "none"),
		"sucursal_id"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"direccion_id"	=> array("type" => "bigint", "required" => "0", "validation" => "none"),

		"cliente_nombres"	=> array("type" => "varchar",	"length"=> 64, "required" => "0", "validation" => "none"),
		"carrito_nombre"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"contraentrega_horario" => array("type" => "datetime", "required" => "0", "validation" => "none"),
		"cliente_telefono"	=> array("type" => "varchar",	"length"=> 20, "required" => "0", "validation" => "none"),
		"cliente_zimple"	=> array("type" => "varchar",	"length"=> 20, "required" => "0", "validation" => "none"),
        #PagoContraentrega en efectivo / pos
		"contraentrega_opcion"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		
		"contraentrega_formapago" =>	array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		//Tipo 1 Delivery Tipo 2 Retiro de Local contraentrega_pago
		"contraentrega_delivery" =>	array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"contraentrega_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"contraentrega_process_id"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
        "contraentrega_pago"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"body_raw"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none")
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['cliente_id']['value']	=	$_POST['cliente_id'];
		$obj->fields['carrito_id']['value']	=	$_POST['carrito_id'];
		
		$obj->fields['sucursal_id']['value']	=	$_POST['sucursal_id'];
		$obj->fields['direccion_id']['value']	=	$_POST['direccion_id'];


		$fecha = date('Y-m-d H:i:s', strtotime($_POST['contraentrega_horario']) );
		$obj->fields['contraentrega_horario']['value']	=	$fecha;


		$obj->fields['cliente_nombres']['value']	=	$_POST['cliente_nombres'];
		$obj->fields['carrito_nombre']['value']	=	$_POST['carrito_nombre'];
			
		$obj->fields['cliente_telefono']['value']	=	$_POST['cliente_telefono'];
		$obj->fields['cliente_zimple']['value']	=	$_POST['cliente_zimple'];
		

		$obj->fields['contraentrega_formapago']['value']		=	$_POST['contraentrega_formapago'];
        #Contraentrega opcion de pago Efectivo / POS
		$obj->fields['contraentrega_opcion']['value']	=	isset($_POST['contraentrega_opcion']) ? number($_POST['contraentrega_opcion']) : 0;
		
		$obj->fields['contraentrega_delivery']['value']	=	isset($_POST['contraentrega_delivery']) ? number($_POST['contraentrega_delivery']) : 0;
		$obj->fields['contraentrega_status']['value']	=	isset($_POST['contraentrega_status']) ? number($_POST['contraentrega_status']) : 0;
		$obj->fields['contraentrega_pago']['value']	=	isset($_POST['contraentrega_pago']) ? number($_POST['contraentrega_pago']) : 0;

        $obj->fields['contraentrega_process_id']['value']	=	$_POST['contraentrega_process_id'];

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:

			Message::set("Por favor completar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "contraentrega_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "contraentrega_hidden = 0");
	}

	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contraentrega_status = 1 AND contraentrega_hidden = 0{$ord}";
		return $obj->execute($sql);
	}
	
	public static function getList($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} contraentrega_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contraentrega_status = 1 AND contraentrega_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contraentrega_status = 1 AND contraentrega_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}contraentrega_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE contraentrega_status = 1 AND contraentrega_hidden = 0{$where}");
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
					self::set("contraentrega_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("contraentrega_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT contraentrega_id, contraentrega_name FROM contraentrega WHERE contraentrega_status = 1 AND contraentrega_hidden = 0 ORDER BY contraentrega_name ASC";
		$list = $obj->exec($list);
		print '<select name="contraentrega_id" id="contraentrega_combo" style="color:#000;">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['contraentrega_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['contraentrega_id'].'"'.$select.'>'.htmlspecialchars($dat['contraentrega_name']).'</option>';
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
