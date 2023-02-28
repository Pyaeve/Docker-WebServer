<?php
class Categorias extends Mysql{
	protected $tableName	= "categorias";
	protected $primaryKey = "categoria_id";
	protected $fields	= array(
		"categoria_nombre"	=> array("type" => "varchar",	"length"=> 64, "required" => "1", "validation" => "none"),
		"categoria_parent"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"categoria_left"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"categoria_right"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"categoria_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		//"categoria_timestamp"	=> array("type" => "timestamp", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);
		if($id > 0){
			$obj->fields['categoria_slugit']['value']	=	slugit($_POST['categoria_nombre'].$id);
		}else{
			$numero = Categorias::getLast();
			$numero = $numero[0]['categoria_id']+1;
			$obj->fields['categoria_slugit']['value']	=	slugit($_POST['categoria_nombre'].$numero);
		}
		$obj->fields['categoria_nombre']['value']	=	$_POST['categoria_nombre'];
		$obj->fields['categoria_parent']['value']	=	$_POST['categoria_parent'];
		$obj->fields['categoria_left']['value']	=	$_POST['categoria_left'];
		$obj->fields['categoria_right']['value']	=	$_POST['categoria_right'];
		$obj->fields['categoria_status']['value']	=	isset($_POST['categoria_status']) ? number($_POST['categoria_status']) : 0;

		if(number($_POST['categoria_parent']) == 1):
			$res = $obj->find($obj->tableName, "categoria_parent", 0);
		else:
			$res = $obj->select(number($_POST['categoria_parent']));
		endif;
		
		$left	= $res[0]['categoria_left'];
		$right	= $res[0]['categoria_right'];
		
		if($id == 0):
			
			$limit_l = "UPDATE categorias SET categoria_left	= categoria_left  + 2 WHERE categoria_left  > {$left}";
			$limit_r = "UPDATE categorias SET categoria_right	= categoria_right + 2 WHERE categoria_right > {$left}";
			
			$obj->execute($limit_l);
			$obj->execute($limit_r);
			
			$left  = $res[0]['categoria_left'] + 1;
			$right = $res[0]['categoria_left'] + 2;
		
		else:
			
			$res 	= self::select($id);
			$left	= $res[0]['categoria_left'];
			$right	= $res[0]['categoria_right'];
			
		endif;
		
		$obj->fields['categoria_left']['value']	= $left;
		$obj->fields['categoria_right']['value']	= $right;
		

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
		$obj->change($obj->tableName, "categoria_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "categoria_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}categoria_status = 1 AND categoria_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}categoria_status = 1 AND categoria_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}categoria_status = 1 AND categoria_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}categoria_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE categoria_status = 1 AND categoria_hidden = 0{$where}");
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
					self::set("categoria_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("categoria_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT categoria_id, categoria_nombre FROM categorias WHERE categoria_parent = 1 AND categoria_status = 1 AND categoria_hidden = 0 ORDER BY categoria_nombre ASC";
		$list = $obj->exec($list);
		$changeaction = $onchange == null ? "" : ' onchange="'.$onchange.'"';
		print '<select style="color:#000;" name="categoria_id" id="categorias_combo"'.$changeaction.'>';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['categoria_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['categoria_id'].'"'.$select.'>'.htmlspecialchars($dat['categoria_nombre']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
		
	public static function tree($id){
		$obj = new self();
		$id = number($id);
		$sql = "
		SELECT c1.categoria_parent AS p1, c1.categoria_left AS l1, c1.categoria_right AS r1,
		c2.* FROM categorias c1, categorias c2
		WHERE c1.categoria_id = $id AND(
			c2.categoria_id = $id OR(
				c2.categoria_parent >= 0 AND
				c2.categoria_left < c1.categoria_left AND c2.categoria_right > c1.categoria_right
			)
		) ORDER BY c2.categoria_id ASC
		";
		return $obj->execute($sql);
	}
	#Arbol de categorias a la inversa
	public static function catpag($id){
		$obj = new self();
		$id = number($id);
		$sql = "
		SELECT c1.categoria_parent AS p1, c1.categoria_left AS l1, c1.categoria_right AS r1,
		c2.* FROM categorias c1, categorias c2
		WHERE c1.categoria_id = $id AND(
			c2.categoria_id = $id OR(
				c2.categoria_parent >= 0 AND
				c2.categoria_left > c1.categoria_left AND c2.categoria_right < c1.categoria_right
			)
		) ORDER BY c2.categoria_id ASC
		";
		return $obj->execute($sql);
	}
	
	public static function padre($id,$family = NULL){
		$obj = new self();
		$id = number($id);
		$family = $family > 0 ? "AND c2.categoria_parent = ".$family : "";
		$sql = "
		SELECT c1.categoria_parent AS p1, c1.categoria_left AS l1, c1.categoria_right AS r1,
		c2.* FROM categorias c1, categorias c2
		WHERE c1.categoria_id = $id AND(
			c2.categoria_id = $id OR(
				c2.categoria_parent >= 0 AND
				c2.categoria_left < c1.categoria_left AND c2.categoria_right > c1.categoria_right
			)
		) $family
		ORDER BY c2.categoria_id ASC
		";
		return $obj->execute($sql);
	}

	public static function catdata($data){
		$obj = new self();
		$sql = "SELECT * FROM categorias WHERE categoria_nombre RLIKE '{$data}'";
		return $obj->execute($sql);
	}
}
?>