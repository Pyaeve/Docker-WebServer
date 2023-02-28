<?php
class Carrito_detalle extends Mysql{
	protected $tableName	= "carrito_detalle";
	protected $primaryKey = "detalle_id";
	protected $fields	= array(
		"carrito_id"	=> array("type" => "bigint", "required" => "0", "validation" => "none"),
		"producto_id"	=> array("type" => "bigint", "required" => "1", "validation" => "none"),
		"producto_nombre"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"producto_precio"	=> array("type" => "double", "required" => "0", "validation" => "none"),
		"detalle_monto"	=> array("type" => "double", "required" => "0", "validation" => "none"),
		"detalle_cantidad"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"detalle_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['carrito_id']['value']	=	$_POST['carrito_id'];
		$obj->fields['producto_id']['value']	=	$_POST['producto_id'];
		$obj->fields['producto_nombre']['value']	=	$_POST['producto_nombre'];
		$obj->fields['producto_precio']['value']	=	$_POST['producto_precio'];
		$obj->fields['detalle_monto']['value']	=	$_POST['detalle_monto'];
		$obj->fields['detalle_cantidad']['value']	=	$_POST['detalle_cantidad'];
		$obj->fields['detalle_status']['value']	=	isset($_POST['detalle_status']) ? number($_POST['detalle_status']) : 0;

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
		$obj->change($obj->tableName, "detalle_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "detalle_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_status = 1 AND detalle_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_status = 1 AND detalle_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_status = 1 AND detalle_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}detalle_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE detalle_status = 1 AND detalle_hidden = 0{$where}");
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
					self::set("detalle_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("detalle_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT detalle_id, carrito_id FROM carrito_detalle WHERE detalle_status = 1 AND detalle_hidden = 0 ORDER BY carrito_id ASC";
		$list = $obj->exec($list);
		print '<select name="detalle_id" id="carrito_detalle_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['detalle_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['detalle_id'].'"'.$select.'>'.htmlspecialchars($dat['carrito_id']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}


	public static function getItems($cliente_id,$order=null,$search=null){
		$uid = $cliente_id;

		$check = Carrito::getLast("cliente_id = {$uid}");
		$carrito_id = ($check[0]['carrito_id']>0)?$check[0]['carrito_id']:0;

		$obj = new self();
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$buscar = $search == null ? "" : "AND CONCAT_WS(' ', carrito_detalle.producto_nombre, carrito_detalle.producto_precio) LIKE '%{$search}%'";

		$sql = "SELECT * FROM " . $obj->tableName . " INNER JOIN carrito ON (carrito.carrito_id = carrito_detalle.carrito_id) WHERE carrito_detalle.carrito_id = '".$carrito_id."' AND carrito.cliente_id = '".$uid."' AND carrito_detalle.detalle_status = 1 AND carrito_detalle.detalle_hidden = 0 {$buscar} {$ord}";
		return $obj->execute($sql);
	}

	public static function totalItems($id){
		$obj = new self();
		$res = "SELECT SUM(d.detalle_cantidad) as total FROM carrito_detalle d, carrito c WHERE c.carrito_id = d.carrito_id AND c.cliente_id = '".$id."' AND c.carrito_hidden = 0 AND d.detalle_hidden = 0";
		$res = $obj->execute($res);

		return $res[0]['total'] > 0 ? $res[0]['total'] : 0;
	}

	public static function totalCosto($cliente_id=null){
		$total = 0;

		if($cliente_id != null){
			$check = Carrito::getLast("cliente_id = {$cliente_id}");
			$carrito_id = ($check[0]['carrito_id']>0)?$check[0]['carrito_id']:0;

			$obj = new self();
			$whr = $cliente_id == null ? "" : "carrito_id = {$carrito_id} AND ";
			$sql = "SELECT * FROM carrito_detalle WHERE {$whr} detalle_status = 1 AND detalle_hidden = 0";

			$sql = $obj->execute($sql);

				foreach($sql as $result):
					$producto = Productos::get("producto_id = ".$result['producto_id']);
					$producto_precio = $producto[0]['producto_precio']+$producto[0]['producto_precioIVA'];
					//$total += ($result['detalle_cantidad'] * $result['producto_precio']);
					$total += ($result['detalle_cantidad'] * $producto_precio);
				endforeach;
		}
		return $total;
	}


	public static function totalCosto2($cliente_id=null,$oferta_activa){
		$total = 0;

		if($cliente_id != null){
			$check = Carrito::getLast("cliente_id = {$cliente_id}");
			$carrito_id = ($check[0]['carrito_id']>0)?$check[0]['carrito_id']:0;
			$detalle_oferta = $oferta_activa > 0 ? "AND detalle_oferta = 1" : "AND detalle_oferta = 0";
			$obj = new self();
			$whr = $cliente_id == null ? "" : "carrito_id = {$carrito_id} AND ";
			$sql = "SELECT * FROM carrito_detalle WHERE {$whr} detalle_status = 1 AND detalle_hidden = 0 {$detalle_oferta}";

			$sql = $obj->execute($sql);

				foreach($sql as $result):
					$total += ($result['detalle_cantidad'] * $result['producto_precio']);
				endforeach;
		}
		return $total;
	}

	public static function updateItem($id,$q){
		$obj = new self();
		$res = $obj->exec("SELECT producto_precio FROM carrito_detalle WHERE detalle_id = {$id}");
		$id  = number($id);
		$q   = number($q);
		$obj->change($obj->tableName, "detalle_cantidad", $q, "detalle_id = {$id}");
		$obj->change($obj->tableName, "detalle_monto",  $res[0]['producto_precio']*$q ,"detalle_id = {$id}");
	}
	
	public static function getItemsBasura($cliente_id,$carrito_id, $order=null,$search=null){
		$uid = $cliente_id;

		$check = Carrito::getLast("cliente_id = {$uid}");
		//$carrito_id = ($check[0]['carrito_id']>0)?$check[0]['carrito_id']:0;

		$obj = new self();
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$buscar = $search == null ? "" : "AND CONCAT_WS(' ', carrito_detalle.producto_nombre, carrito_detalle.producto_precio) LIKE '%{$search}%'";

		$sql = "SELECT * FROM " . $obj->tableName . " INNER JOIN carrito ON (carrito.carrito_id = carrito_detalle.carrito_id) WHERE carrito_detalle.carrito_id = '".$carrito_id."' AND carrito.cliente_id = '".$uid."' AND carrito_detalle.detalle_status = 1 AND carrito_detalle.detalle_hidden = 0 {$buscar} {$ord}";
		return $obj->execute($sql);
	}
	
	public static function totalCostoBasura($carrito, $cliente_id=null){
	    $obj = new self();
		$total = 0;
		if($cliente_id != null){
		    $sql = "SELECT * FROM carrito WHERE carrito_id = 191";
		    $check = $obj->execute($sql);
			//$check = Carrito::getLast("cliente_id = {$cliente_id}");
			$carrito_id = ($check[0]['carrito_id']>0)?$check[0]['carrito_id']:0;

			$obj = new self();
			$whr = $cliente_id == null ? "" : "carrito_id = {$carrito_id} AND ";
			$sql = "SELECT * FROM carrito_detalle WHERE {$whr} detalle_status = 1 AND detalle_hidden = 0";

			$sql = $obj->execute($sql);

				foreach($sql as $result):
					$total += ($result['detalle_cantidad'] * $result['producto_precio']);
				endforeach;
		}
		return $total;

	}
	
}
?>