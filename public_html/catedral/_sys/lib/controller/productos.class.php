<?php
class Productos extends Mysql{
	protected $tableName	= "productos";
	protected $primaryKey = "producto_id";
	protected $fields	= array(
		"categoria_id"	=> array("type" => "bigint", "required" => "0", "validation" => "none"),
		"marca_nombre"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"producto_droga"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"producto_codigo"	=> array("type" => "varchar",	"length"=> 190, "required" => "1", "validation" => "none"),
		"producto_nombre"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"producto_slugit"	=> array("type" => "varchar",	"length"=> 250, "required" => "1", "validation" => "none"),
		"producto_precio"	=> array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
		"producto_precioIVA"	=> array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
		"producto_descuento"	=> array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
		"producto_mostrar"	=> array("type" => "varchar",	"length"=> 10, "required" => "0", "validation" => "none"),

		"producto_precioantes"	=> array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
		"producto_precioantesIVA"	=> array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),

		"producto_descripcion"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"producto_stock"	=> array("type" => "int", "required" => "1", "validation" => "none"),

		"producto_promofechaini"	=> array("type" => "datetime", "required" => "0", "validation" => "none"),
		"producto_promofechafin"	=> array("type" => "datetime", "required" => "0", "validation" => "none"),
		"producto_preciopromo"	=> array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
        "producto_promostatus" => array("type" => "tinyint", "required" => "0", "validation" => "none"),

		"producto_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"producto_recomendado" => array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"producto_mejores" => array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"producto_destacado"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"producto_nivel"	 => array("type" => "varchar",	"length"=> 50, "required" => "0", "validation" => "none"),
		"producto_equivalencia"	 => array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),

	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['categoria_id']['value']	=	$_POST['categoria_id'];
		$obj->fields['marca_nombre']['value']	=	$_POST['marca_nombre'];
		$obj->fields['producto_droga']['value']	=	$_POST['producto_droga'];
		$obj->fields['producto_codigo']['value']	=	$_POST['producto_codigo'];
		
		$obj->fields['producto_descuento']['value']	=	$_POST['producto_descuento'];

		$precio = array(",",".");
		$obj->fields['producto_precio']['value']	=	str_replace($precio, "", $_POST['producto_precio']);
		$obj->fields['producto_precioantes']['value']	=	str_replace($precio, "", $_POST['producto_precioantes']);

		$obj->fields['producto_precioIVA']['value']	=	str_replace($precio, "", $_POST['producto_precioIVA']);
		$obj->fields['producto_precioantesIVA']['value']	=	str_replace($precio, "", $_POST['producto_precioantesIVA']);
		
		$obj->fields['producto_nombre']['value']	=	$_POST['producto_nombre'];
		$obj->fields['producto_mostrar']['value']	=	$_POST['producto_mostrar'];
		if($id > 0){
			$obj->fields['producto_slugit']['value']	=	slugit($_POST['producto_nombre'].$id);
		}else{
			$numero = Productos::getLast();
			$numero = $numero[0]['producto_id']+1;
			$obj->fields['producto_slugit']['value']	=	slugit($_POST['producto_nombre'].$numero);
		}
		$obj->fields['producto_descripcion']['value']	=	$_POST['producto_descripcion'];
		$obj->fields['producto_stock']['value']	=	isset($_POST['producto_stock']) ? number($_POST['producto_stock']) : 0;
		$obj->fields['producto_status']['value']	=	isset($_POST['producto_status']) ? number($_POST['producto_status']) : 0;
		$obj->fields['producto_destacado']['value']	=	isset($_POST['producto_destacado']) ? number($_POST['producto_destacado']) : 0;
        $obj->fields['producto_recomendado']['value']	=	isset($_POST['producto_recomendado']) ? number($_POST['producto_recomendado']) : 0;
        $obj->fields['producto_mejores']['value']	=	isset($_POST['producto_mejores']) ? number($_POST['producto_mejores']) : 0;

        $obj->fields['producto_promofechaini']['value']	=	$_POST['producto_promofechaini'];
        $obj->fields['producto_promofechafin']['value']	=	$_POST['producto_promofechafin'];
		$obj->fields['producto_preciopromo']['value']	=	str_replace($precio, "", $_POST['producto_preciopromo']);
        $obj->fields['producto_promostatus']['value']	=	isset($_POST['producto_promostatus']) ? number($_POST['producto_promostatus']) : 0;
        
        $obj->fields['producto_nivel']['value']	=	isset($_POST['producto_nivel']) ? 0 : "VENTA LIBRE";
        $obj->fields['producto_equivalencia']['value']	=	$_POST['producto_equivalencia'];


		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			@unlink(rootUpload . "productos/" . $file_large);
			@unlink(rootUpload . "productos/" . $file_small);

			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "producto_hidden", 1, $obj->primaryKey . " = {$id}");
		$picture = self::select($id);
		if(count($picture) > 0):
			@unlink($picture[0]['producto_image_small_path']);
			@unlink($picture[0]['producto_image_big_path']);
		endif;

	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "producto_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} producto_status = 1 AND producto_hidden = 0 {$ord}";
		return $obj->execute($sql);
	}

	public static function get2($campos=null,$where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT $campos FROM " . $obj->tableName . " WHERE {$whr} producto_status = 1 AND producto_hidden = 0 {$ord}";
		return $obj->execute($sql);
	}

	public static function val($campos=null,$where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where}";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT $campos FROM " . $obj->tableName . " WHERE {$whr} {$ord}";
		return $obj->execute($sql);
	}
	/*ublic static function getCarrito($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT ca.carrito_id AS carrito_id, ca.carrito_nombre AS nombre_carrito, ca.carrito_timestamp AS carrito_timestamp, cl.cliente_cedula AS cedula, cl.cliente_ruc AS ruc, cl.cliente_nombre AS nombre, cl.cliente_apellido AS apellido FROM " . $obj->tableName . " ca INNER JOIN clientes cl WHERE {$whr}producto_status = 1 AND producto_hidden = 0{$ord}";
		return $obj->execute($sql);			
	}*/

	public static function get_stock($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT producto_codigo, producto_precio, producto_precioantes, producto_precioIVA, producto_precioantesIVA FROM " . $obj->tableName . " WHERE {$whr} producto_hidden = 0{$ord}";
		return $obj->execute($sql);
	}
	
	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}producto_status = 1 AND producto_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}producto_status = 1 AND producto_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}producto_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE producto_status = 1 AND producto_hidden = 0{$where}");
	}

	public static function listing2($limit=10, $page=1, $fields=null, $where=null, $params=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get2($obj->tableName, $limit, $fields, $page, "WHERE producto_status = 1 AND producto_hidden = 0 {$where}", $params);
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
					self::set("producto_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("producto_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT producto_id, categoria_id FROM productos WHERE producto_status = 1 AND producto_hidden = 0 ORDER BY categoria_id ASC";
		$list = $obj->exec($list);
		print '<select name="producto_id" id="productos_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['producto_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['producto_id'].'"'.$select.'>'.htmlspecialchars($dat['categoria_id']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function comboRecomendado($selected=null,$onchange=null){
		$obj = new self();
		$fsel = ($selected == null || $selected == 0) ? ' selected="selected"' : '';
		$list = "SELECT producto_id, producto_nombre FROM productos WHERE producto_status = 1 AND producto_hidden = 0 ORDER BY producto_id ASC";
		$list = $obj->exec($list);
		print '<select name="producto_id" id="productos_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['producto_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['producto_id'].'"'.$select.'>'.htmlspecialchars($dat['producto_nombre']).'</option>';
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
		$sql = "SELECT * FROM productos LIMIT 5";
		return $obj->execute($sql);
	}

	public static function articulos($id){
		$obj = new self();
		if($id > 0):
			$sql = "SELECT count(p.producto_id) as articulos FROM compra_recurrente c
					JOIN compra_recurrente_detalle cd ON cd.compra_id = c.compra_id
					JOIN productos p ON p.producto_id = cd.producto_id
					WHERE c.compra_id = {$id}";
			return $obj->execute($sql);
		endif;
	}

	public static function disponible($id){
		$obj = new self();
		if($id > 0):
			$sql = "SELECT count(p.producto_id) as articulos FROM compra_recurrente c
					JOIN compra_recurrente_detalle cd ON cd.compra_id = c.compra_id
					JOIN productos p ON p.producto_id = cd.producto_id
					WHERE c.compra_id = {$id} AND p.producto_stock > 0 AND p.producto_status = 1 AND p.producto_hidden = 0";
			return $obj->execute($sql);
		endif;
	}
	#retorna la cantidad de productos asociados a una categoria
	public static function producto_menu($categoria_id){
		$obj = new self();
		if($categoria_id > 0){
			$query = "SELECT count(p.producto_id) as cantidad FROM productos p WHERE p.producto_stock > 0 AND p.producto_status = 1 AND p.producto_hidden = 0 AND p.categoria_id = {$categoria_id}";
			return $obj->execute($query);
		}
	}

	public static function categoria_main($categoria_id){
		$obj = new self();
		if($categoria_id > 0){
			$query = "SELECT count(p.producto_id) AS cantidades 
			FROM categorias  c 
			JOIN categorias c2 ON c2.categoria_parent = c.categoria_id 
			JOIN productos p ON p.categoria_id = c2.categoria_id WHERE p.categoria_id = {$categoria_id} AND p.producto_status = 1 AND p.producto_hidden = 0";
			return $obj->execute($query);
		}	
	}

	public static function actualiza($set, $code){
		$obj = new self();
		if(strlen($set) > 0){
			$query = "UPDATE productos SET {$set} WHERE producto_codigo = {$code}";
			return $obj->execute($query);
		}
	}
	
	public static function actualizaciones($precio, $antes, $droga, $stock = NULL, $descripcion, $code){
		$obj = new self();
		$query = 'UPDATE productos 
		SET producto_precio = '.$precio.', 
		producto_precioantes = '.$antes.', 
		producto_droga = "'.$droga.'", producto_nombre = "'.$descripcion.'" WHERE producto_codigo = '.$code;
		/*
		$query = 'UPDATE productos 
		SET producto_precio = '.$precio.', 
		producto_precioantes = '.$antes.', 
		producto_droga = "'.$droga.'", producto_stock = '.$stock.', producto_nombre = "'.$descripcion.'" WHERE producto_codigo = '.$code;*/
		return $obj->execute($query);
	}
	
	public static function updatePrecios($precio, $antes, $precioIva, $precioAnteIva, $descuento, $mostrar, $nombre, $descripcion, $code){
		$obj = new self();
		$descuento = $descuento > 0 ? $descuento : 0;
		$descripcion = str_replace("'", "\'", $descripcion);
		$descripcion = str_replace('"', '\"', $descripcion);
		
		$nombre = str_replace("'", "\'", $nombre);
		$nombre = str_replace('"', '\"', $nombre);
		//$query = 'UPDATE productos SET producto_precio = '.$precio.', producto_precioantes = '.$antes.', producto_precioIVA = '.$precioIva.', producto_precioantesIVA = '.$precioAnteIva.', producto_descuento = '.$descuento.', producto_mostrar = "'.$mostrar.'", producto_descripcion = "{$descripcion}"  WHERE producto_codigo = '.$code;
		$query = 'UPDATE productos SET producto_precio = '.$precio.', producto_precioantes = '.$antes.', producto_precioIVA = '.$precioIva.', producto_precioantesIVA = '.$precioAnteIva.', producto_descuento = '.$descuento.', producto_mostrar = "'.$mostrar.'", producto_descripcion = "'.$descripcion.'", producto_nombre = "'.$nombre.'"  WHERE producto_codigo = '.$code;


		return $obj->execute($query);
	}
	
	public static function updateExcel($precio, $antes, $droga = NULL, $stock, $descripcion = NULL, $recomendado = NULL, $categoria = NULL, $code){
		$obj = new self();
		$descripcion = strlen($descripcion) > 0 ? ", producto_nombre = '{$descripcion}' " : "";
		$droga = strlen($droga) > 0 ? ", producto_droga = '{$droga}' " : "";
		$categoria = strlen($categoria) > 0 ? ", categoria_id = {$categoria} " : "";
		
		$recomendado = numParam($recomendado);
		//Precio Actual
		//$precio = explode(".", $precio);
		//$actual = $precio[0];
		//Precio Anterior
		//$antes = explode(".", $antes);
		//$anterior = $antes[0];

		$query = "UPDATE productos 
		SET producto_precio = {$precio}, 
		producto_precioantes = {$antes}, 
		producto_recomendado = {$recomendado}, 
		producto_stock = {$stock} 
		{$droga}
		{$categoria}
		{$descripcion} WHERE producto_codigo = {$code}";
		return $obj->execute($query);
	}

	public static function stock($precio, $precioIVA, $precioantes, $precioantesIVA, $stock, $visible, $nivel, $descripcion, $code){
		$obj = new self();
		if(strlen($precio) > 0){
		    $stock = $stock > 0 ? $stock : 0;
		    $visible = $stock > 0 ? 1 : 0;
		    
			$query = "UPDATE productos SET producto_precio = {$precio}, producto_precioIVA = {$precioIVA}, producto_precioantes = {$precioantes}, producto_precioantesIVA = {$precioantesIVA}, producto_stock = {$stock}, producto_status = {$visible}, producto_nivel = '{$nivel}', producto_descripcion = '{$descripcion}'
			WHERE producto_codigo = {$code}";
			return $obj->execute($query);
		}
	}
	
	public static function descripciones($descripcion, $code){
		$obj = new self();
		$descripcion = str_replace("'", "\'", $descripcion);
		$query = "UPDATE productos SET producto_descripcion = '{$descripcion}' WHERE producto_codigo = {$code}";
		return $obj->execute($query);

	}
	
	public static function disponibilidad($stock = NUL, $code){
		$obj = new self();
		$query = "UPDATE productos SET producto_stock = {$stock} WHERE producto_codigo = {$code}";
		return $obj->execute($query);
	
	}
	
	public static function recomendado($empreCod = null, $precio = NULL, $precioantes = NUL, $code){
		$obj = new self();
		#1 Pasar todos los productos a estado 0 "No recomendado";
		$sql = "UPDATE productos SET producto_recomendado = 0";
		$obj->execute($sql);
		#2 Cargamos los productos recomendados obtenido del WebServices
		$query = "UPDATE productos SET producto_precio = {$precio}, producto_precioantes = {$precioantes}, producto_recomendado = 1 WHERE producto_codigo = {$code}";
		return $obj->execute($query);
	}

	public static function mejores($empre_Cod = null, $precio = NULL, $precioantes = NUL, $code){
		$obj = new self();
		#1 Pasar todos los productos a estado 0 "No recomendado";
		$sql = "UPDATE productos SET producto_mejores = 0";
		$obj->execute($sql);
		#2 Cargamos los productos recomendados obtenido del WebServices
		$query = "UPDATE productos SET producto_precio = {$precio}, producto_precioantes = {$precioantes}, producto_mejores = 1 WHERE producto_codigo = {$code}";
		return $obj->execute($query);
	}

	public static function promo($fechaini = NULL, $fechafin = NULL, $precio = NULL, $code){
		$obj = new self();
		#El producto con en promocion se desactiva con la fecha
		$query = "UPDATE productos SET producto_preciopromo = {$precio}, producto_promofechaini = '{$fechaini}', producto_promofechafin = '{$fechafin}', producto_promostatus = 1 WHERE producto_id = ".$code;
		return $obj->execute($query);
	}
	
	public static function producto_imagen($code){
		$obj = new self();
		$query = "SELECT p.producto_id, p.producto_codigo, ip.imagen_file_name 
                FROM productos p
                LEFT JOIN imagenes_productos AS ip ON p.producto_id = ip.producto_id
                WHERE ip.imagen_file_name IS NULL AND p.producto_codigo = {$code}";
		return $obj->execute($query);
	}
	
	public static function productoImagen(){
		$obj = new self();
		$query = "SELECT p.producto_id, p.producto_nombre, p.producto_codigo, ip.imagen_file_name 
                FROM productos p
                LEFT JOIN imagenes_productos AS ip ON p.producto_id = ip.producto_id
                WHERE ip.imagen_file_name IS NULL";
		return $obj->execute($query);
			
	}
	
	public static function productopromo(){
	    $obj = new self();
	    $query = "SELECT p.producto_id, p.producto_codigo, p.producto_promofechaini, p.producto_promofechafin, p.producto_promostatus, p.producto_preciopromo, now() AS fecha 
	    FROM productos p 
	    WHERE now() > p.producto_promofechafin";
		return $obj->execute($query);
	}
}
?>