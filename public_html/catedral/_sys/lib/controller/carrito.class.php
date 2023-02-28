<?php
class Carrito extends Mysql{
	protected $tableName	= "carrito";
	protected $primaryKey = "carrito_id";
	protected $fields	= array(
		"cliente_id"	=> array("type" => "bigint", "required" => "1", "validation" => "none"),
        "carrito_nombre" => array("type" => "varchar", "length"=> 150, "required" => "0", "validation" => "none"),

		"carrito_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['cliente_id']['value']	=	$_POST['cliente_id'];
    $obj->fields['carrito_nombre']['value']  = $_POST['carrito_nombre'];
    
		$obj->fields['carrito_status']['value']	=	isset($_POST['carrito_status']) ? number($_POST['carrito_status']) : 0;

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
		$obj->change($obj->tableName, "carrito_hidden", 1, $obj->primaryKey . " = {$id}");
	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "carrito_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}carrito_status = 1 AND carrito_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

  public static function getJoin($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}producto_status = 1 AND producto_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}carrito_status = 1 AND carrito_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}carrito_status = 1 AND carrito_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}carrito_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE carrito_status = 1 AND carrito_hidden = 0{$where}");
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
					self::set("carrito_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("carrito_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT carrito_id, carrito_name FROM carrito WHERE carrito_status = 1 AND carrito_hidden = 0 ORDER BY carrito_name ASC";
		$list = $obj->exec($list);
		print '<select name="carrito_id" id="carrito_combo" style="color:#000;">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['carrito_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['carrito_id'].'"'.$select.'>'.htmlspecialchars($dat['carrito_name']).'</option>';
				endforeach;
			endif;
		print '</select>';
	}

	public static function getfields(){
		$obj = new self();
		return $obj->fields;
	}
	
			public static function emptyCart($id){

			$obj = new self();
			$check = "SELECT carrito_id FROM carrito WHERE cliente_id = " .$id." AND carrito_hidden = 0";
			$check = $obj->execute($check);

			if(is_array($check) && count($check) > 0):
				self::delete($check[0]['carrito_id']);
			endif;
		}

		public static function getid(){
			$obj = new self();
			$check = "SELECT carrito_id FROM carrito WHERE cliente_id = " . Usuarios::login("cliente_id")." AND carrito_hidden = 0";
			$check = $obj->execute($check);

			return is_array($check) && count($check) > 0 ? $check[0]['carrito_id'] : 0;
		}

		public static function totalItems(){
			return Carrito_detalle::totalItems();
		}

		public static function updateItem($id, $q){
			Carrito_detalle::updateItem($id,$q);
		}

		public static function deleteItem($id){
			Carrito_detalle::delete($id);
		}

    public static function getProductosActualizar($cliente_id=null){
      if($cliente_id>0){
        $obj = new self();
        $sql = "SELECT productos.producto_id as producto_id, (productos.producto_precio + productos.producto_precioIVA) AS nuevo_precio, carrito_detalle.detalle_id AS detalle_id FROM " . $obj->tableName . "  JOIN carrito_detalle  ON carrito.carrito_id = carrito_detalle.carrito_id JOIN productos ON productos.producto_id = carrito_detalle.producto_id AND carrito.cliente_id = $cliente_id AND carrito.carrito_status = 1 AND carrito.carrito_hidden = 0 AND carrito_detalle.detalle_status = 1 AND carrito_detalle.detalle_hidden = 0 AND carrito_detalle.producto_precio <>  (productos.producto_precio + productos.producto_precioIVA)";
        //$sql = "SELECT * FROM " . $obj->tableName . " LIMIT 10 ";
        return $obj->execute($sql);
      }
    }
	//

  //seteamos el carrito exista o no exista en el constructor
  public function __construct(){
    if(!isset($_SESSION["carrito"]))
    {
      $_SESSION["carrito"] = null;
      $this->carrito["precio_total"] = 0;
      $this->carrito["producto_total"] = 0;
    }
    $this->carrito = $_SESSION['carrito'];
  }

  //añadimos un producto al carrito
  public function add($producto = array())
  {
    //primero comprobamos el articulo a añadir, si está vacío o no es un
    //array lanzamos una excepción y cortamos la ejecución
    if(!is_array($producto) || empty($producto))
    {
      throw new Exception("Error, no se ha podido registrar el producto!", 1);
    }

    //nuestro carro necesita siempre un id producto, cantidad y precio articulo
    if(!$producto["producto_id"] || !$producto["detalle_cantidad"] || !$producto["producto_precio"])
    {
      throw new Exception("Error, el articulo debe tener un id, cantidad y precio!", 1);
    }

    //nuestro carro necesita siempre un id producto, cantidad y precio articulo
    if(!is_numeric($producto["producto_id"]) || !is_numeric($producto["detalle_cantidad"]) || !is_numeric($producto["producto_precio"]))
    {
      throw new Exception("Error, el id, cantidad y precio deben ser números!", 1);
    }

    //debemos crear un identificador único para cada producto
    $detalle_id = md5($producto["producto_id"]);

    //creamos la id única para el producto
    $producto["detalle_id"] = $detalle_id;

    //si no está vacío el carrito lo recorremos
    if(!empty($this->carrito))
    {
      foreach ($this->carrito as $row)
      {
        //comprobamos si este producto ya estaba en el
        //carrito para actualizar el producto o insertar
        //un nuevo producto
        if($row["detalle_id"] === $detalle_id)
        {
          //si ya estaba sumamos la cantidad
          $producto["detalle_cantidad"] = $row["detalle_cantidad"] + $producto["detalle_cantidad"];
        }
      }
    }

    //evitamos que nos pongan números negativos y que sólo sean números para cantidad y precio
      $producto["detalle_cantidad"] = trim(preg_replace('/([^0-9\.])/i', '', $producto["detalle_cantidad"]));
      $producto["producto_precio"] = trim(preg_replace('/([^0-9\.])/i', '', $producto["producto_precio"]));

      //añadimos un elemento total al array carrito para
      //saber el precio total de la suma de este artículo
      $producto["total"] = $producto["detalle_cantidad"] * $producto["producto_precio"];

      //primero debemos eliminar el producto si es que estaba en el carrito
      $this->unset_producto($detalle_id);

      ///ahora añadimos el producto al carrito
      $_SESSION["carrito"][$detalle_id] = $producto;

      //actualizamos el carrito
      $this->update_carrito();

      //actualizamos el precio total y el número de artículos del carrito
      //una vez hemos añadido el producto
      $this->update_precio_cantidad();

  }

  //método que actualiza el precio total y la cantidad
  //de productos total del carrito
  private function update_precio_cantidad()
  {
    //seteamos las variables precio y artículos a 0
    $precio = 0;
    $productos = 0;

    //recorrecmos el contenido del carrito para actualizar
    //el precio total y el número de artículos
    foreach ($this->carrito as $row)
    {
      $precio += ($row['producto_precio'] * $row['detalle_cantidad']);
      $productos += $row['detalle_cantidad'];
    }

    //asignamos a articulos_total el número de artículos actual
    //y al precio el precio actual
    $_SESSION['carrito']["articulos_total"] = $productos;
    $_SESSION['carrito']["precio_total"] = $precio;

    //refrescamos él contenido del carrito para que quedé actualizado
    $this->update_carrito();
  }


  //método que retorna el precio total del carrito
  public function precio_total()
  {
    //si no está definido el elemento precio_total o no existe el carrito
    //el precio total será 0
    if(!isset($this->carrito["precio_total"]) || $this->carrito === null)
    {
      return 0;
    }
    //si no es númerico lanzamos una excepción porque no es correcto
    if(!is_numeric($this->carrito["precio_total"]))
    {
      throw new Exception("El precio total del carrito debe ser un número", 1);
    }
    //en otro caso devolvemos el precio total del carrito
    return $this->carrito["precio_total"] ? $this->carrito["precio_total"] : 0;
  }

  //método que retorna el número de artículos del carrito
  public function articulos_total()
  {
    //si no está definido el elemento articulos_total o no existe el carrito
    //el número de artículos será de 0
    if(!isset($this->carrito["articulos_total"]) || $this->carrito === null)
    {
      return 0;
    }
    //si no es númerico lanzamos una excepción porque no es correcto
    if(!is_numeric($this->carrito["articulos_total"]))
    {
      throw new Exception("El número de artículos del carrito debe ser un número", 1);
    }
    //en otro caso devolvemos el número de artículos del carrito
    return $this->carrito["articulos_total"] ? $this->carrito["articulos_total"] : 0;
  }

  //este método retorna el contenido del carrito
  public function get_content()
  {
    //asignamos el carrito a una variable
    $carrito = $this->carrito;
    //debemos eliminar del carrito el número de artículos
    //y el precio total para poder mostrar bien los artículos
    //ya que estos datos los devuelven los métodos
    //articulos_total y precio_total
    unset($carrito["articulos_total"]);
    unset($carrito["precio_total"]);
    return $carrito == null ? null : $carrito;
  }

  //método que llamamos al insertar un nuevo producto al
  //carrito para eliminarlo si existia, así podemos insertarlo
  //de nuevo pero actualizado
  private function unset_producto($detalle_id)
  {
    unset($_SESSION["carrito"][$detalle_id]);
  }

  //para eliminar un producto debemos pasar la clave única
  //que contiene cada uno de ellos
  public function remove_producto($detalle_id){
    //si no existe el carrito
    if($this->carrito === null)
    {
      throw new Exception("El carrito no existe!", 1);
    }

    //si no existe la id única del producto en el carrito
    if(!isset($this->carrito[$detalle_id])){
      throw new Exception("La detalle_id $detalle_id no existe!", 1);
    }

    //en otro caso, eliminamos el producto, actualizamos el carrito y
    //el precio y cantidad totales del carrito
    unset($_SESSION["carrito"][$detalle_id]);
    $this->update_carrito();
    $this->update_precio_cantidad();
    return true;
  }

  //eliminamos el contenido del carrito por completo
  public function destroy()
  {
    unset($_SESSION["carrito"]);
    $this->carrito = null;
    return true;
  }

  //actualizamos el contenido del carrito
  public function update_carrito()
  {
    self::__construct();
  }

  public static function sumar_reservas($where=null,$order=null){
      $obj = new self();
      $whr = $where == null ? "" : "{$where} AND ";
      $ord = $order == null ? "" : " ORDER BY {$order}";
      $sql = "SELECT SUM(detalle_cantidad) as suma FROM reserva_detalle WHERE {$whr}detalle_status = 2 AND detalle_hidden = 0{$ord}";
      return $obj->execute($sql);
  }

  

}
?>