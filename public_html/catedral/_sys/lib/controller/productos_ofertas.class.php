<?php
class Productos_ofertas extends Mysql{
	protected $tableName	= "productos_ofertas";
	protected $primaryKey = "oferta_id";
	protected $fields	= array(
		"producto_id"	=> array("type" => "bigint", "required" => "1", "validation" => "none"),
		"producto_codigo"	=> array("type" => "varchar",	"length"=> 190, "required" => "1", "validation" => "none"),
		"oferta_depo_codigo"	=> array("type" => "bigint", "required" => "0", "validation" => "none"),
		"oferta_ecommerceempre_code"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"oferta_ecommerceprod_code"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"oferta_precio"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"oferta_tipo"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"oferta_inicio"	=> array("type" => "date", "required" => "0", "validation" => "none"),
		"oferta_fin"	=> array("type" => "date", "required" => "0", "validation" => "none"),
		"oferta_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
		"oferta_categoria"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),

	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['producto_id']['value']	=	$_POST['producto_id'];
		$obj->fields['producto_codigo']['value']	=	$_POST['producto_codigo'];
		$obj->fields['oferta_depo_codigo']['value']	=	$_POST['oferta_depo_codigo'];
		$obj->fields['oferta_ecommerceempre_code']['value']	=	$_POST['oferta_ecommerceempre_code'];
		$obj->fields['oferta_ecommerceprod_code']['value']	=	$_POST['oferta_ecommerceprod_code'];
		$obj->fields['oferta_precio']['value']	=	$_POST['oferta_precio'];
		$obj->fields['oferta_tipo']['value']	=	$_POST['oferta_tipo'];
		$obj->fields['oferta_inicio']['value']	=	$_POST['oferta_inicio'];
		$obj->fields['oferta_fin']['value']	=	$_POST['oferta_fin'];
		$obj->fields['oferta_status']['value']	=	isset($_POST['oferta_status']) ? number($_POST['oferta_status']) : 0;
		$obj->fields['oferta_categoria']['value']	=	$_POST['oferta_categoria'];

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
		$obj->change($obj->tableName, "oferta_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "oferta_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}oferta_status = 1 AND oferta_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}oferta_status = 1 AND oferta_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}oferta_status = 1 AND oferta_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}oferta_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE oferta_status = 1 AND oferta_hidden = 0{$where}");
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
					self::set("oferta_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("oferta_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT oferta_id, producto_id FROM productos_ofertas WHERE oferta_status = 1 AND oferta_hidden = 0 ORDER BY producto_id ASC";
		$list = $obj->exec($list);
		print '<select name="oferta_id" id="productos_ofertas_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['oferta_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['oferta_id'].'"'.$select.'>'.htmlspecialchars($dat['producto_id']).'</option>';
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