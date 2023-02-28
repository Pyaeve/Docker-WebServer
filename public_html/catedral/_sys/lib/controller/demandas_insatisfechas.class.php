<?php
class demandas_insatisfechas extends Mysql{
	protected $tableName	= "demandas_insatisfechas";
	protected $primaryKey = "demanda_insatisfecha_id";
	protected $fields	= array(
		"cliente_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"cliente_cedula"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_ruc"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_nombre"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cliente_apellido"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"deposito_codigo"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"producto_codigo"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"cantidad"	=> array("type" => "int", "required" => "0", "validation" => "none")
		
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['cliente_id']['value']			=	$_POST['cliente_id'];
		$obj->fields['cliente_cedula']['value']		=	$_POST['cliente_cedula'];
		$obj->fields['cliente_ruc']['value']		=	$_POST['cliente_ruc'];
		$obj->fields['cliente_nombre']['value']		=	$_POST['cliente_nombre'];
		$obj->fields['cliente_apellido']['value']	=	$_POST['cliente_apellido'];
		$obj->fields['deposito_codigo']['value']	=	$_POST['sucursal_codigo'];
		$obj->fields['producto_codigo']['value']	=	$_POST['producto_codigo'];
		$obj->fields['cantidad']['value']			=	$_POST['cantidad'];

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	/*public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "cliente_hidden", 1, $obj->primaryKey . " = {$id}");
	}*/

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE {$where}");
	}

	public static function set($field, $value, $where=null){
		$obj = new self();
		$obj->change($obj->tableName, $field, $value, $where);
	}



	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}

}
?>