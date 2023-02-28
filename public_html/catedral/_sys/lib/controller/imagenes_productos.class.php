<?php
class Imagenes_productos extends Mysql{
	protected $tableName	= "imagenes_productos";
	protected $primaryKey = "imagen_id";
	protected $fields	= array(
		"producto_id"	=> array("type" => "int", "required" => "1", "validation" => "none"),
		"producto_codigo_img"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none, unique"),

		//"imagen_file_name"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"imagen_image_small_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"imagen_image_small_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"imagen_image_big_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"imagen_image_big_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"imagen_portada"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"imagen_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['producto_id']['value']	=	$_POST['producto_id'];
		$obj->fields['imagen_portada']['value']	=	$_POST['imagen_portada'];
		$obj->fields['producto_codigo_img']['value']	= $_POST['producto_codigo_img'];
		$obj->fields['imagen_status']['value']	=	isset($_POST['imagen_status']) ? number($_POST['imagen_status']) : 0;

		if(strlen($_FILES['imagen_file_name']['name'])> 0):

			if($_FILES['imagen_file_name']['error'] == 0):

				if($id > 0):
					$picture = self::select($id);
					if(count($picture) > 0):
						@unlink($picture[0]['imagen_image_small_path']);
						@unlink($picture[0]['imagen_image_big_path']);
					endif;
				endif;

				$sourceName	 = $_FILES['imagen_file_name']['name'];
				$sourceImage = $_FILES['imagen_file_name']['tmp_name'];
				$targetImage = strtoupper(uniqid(randomnumbers(6,8).'_'.randomnumbers(6,8).'_'));
				$size = getimagesize($sourceImage);
      			$size_w = $size[0]; // width
      			$size_h = $size[1]; // height

				# sube la foto 
				$img = new ImageUpload();
				$img->setOutputFormat("JPG");
				$img->fileToResize($sourceImage);
				$img->setAlignment("center");
				$img->setBackgroundColor(array(255, 255, 255));

				$img->setOutputFile($targetImage . "_B");
				$img->setTarget(rootUpload . "imagenes_productos/");
				$img->setSize($size_w,$size_h);
				$img->Resize();
				$file_large = $img->getOutputFileName();

				$img->setOutputFile($targetImage . "_S");
				$img->setSize(150,150);
				$img->Resize();
				$file_small = $img->getOutputFileName();

				$obj->fields['imagen_file_name']['value']			= $sourceName;
				$obj->fields['imagen_image_big_path']['value']	= rootUpload . "imagenes_productos/" . $file_large;
				$obj->fields['imagen_image_big_url']['value']		= uploadURL  . "imagenes_productos/" . $file_large;
				$obj->fields['imagen_image_small_path']['value']	= rootUpload . "imagenes_productos/" . $file_small;
				$obj->fields['imagen_image_small_url']['value']	= uploadURL  . "imagenes_productos/" . $file_small;

			else:
				Message::set("Por favor, elija una foto", MESSAGE_ERROR);
				return $obj->error;
			endif;
		else:

			if($id > 0):
				$picture = self::select($id);
				if(count($picture) > 0):
					$obj->fields['imagen_file_name']['value']				= $picture[0]['imagen_file_name'];
					$obj->fields['imagen_image_big_path']['value']		= $picture[0]['imagen_image_big_path'];
					$obj->fields['imagen_image_big_url']['value']			= $picture[0]['imagen_image_big_url'];
					$obj->fields['imagen_image_small_path']['value']		= $picture[0]['imagen_image_small_path'];
					$obj->fields['imagen_image_small_url']['value']		= $picture[0]['imagen_image_small_url'];
				endif;
			else:

				Message::set("Por favor, elija una imagen", MESSAGE_ERROR);
				return $obj->error;

			endif;
		endif;

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			@unlink(rootUpload . "imagenes_productos/" . $file_large);
			@unlink(rootUpload . "imagenes_productos/" . $file_small);

			Message::set("Por favor complete correctamente el formulario para continuar ", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*inserta o modifica un registro*/
	public static function savefiles($id){

		$obj = new self($id);
		$producto_codigo_img = str_replace("_", " ", $_FILES['file']['name']);

		$busca = array(".jpg",".png",".gif","-1","-2","-3","-4","-5","-6","-7","-8","-9");
		$producto_codigo_img = str_replace($busca, "", $producto_codigo_img);


		$productos = Productos::get("producto_codigo = '".$producto_codigo_img."' ","producto_id DESC LIMIT 1");
		$producto = $productos[0]; 

		$images = self::get("producto_id = ".$producto['producto_id']);
		#Si ya existe el id no levanta de vuelta 
		$nocargado = Productos::producto_imagen($producto_codigo_img);
        //if(haveRows($nocargado)){
			$obj->fields['producto_id']['value']	=	$producto['producto_id'] > 0 ? $producto['producto_id'] : $_POST['producto_id'];

			$obj->fields['producto_codigo_img']['value']	= $producto_codigo_img;
			$obj->fields['imagen_portada']['value']	=	isset($_POST['imagen_portada']) ? number($_POST['imagen_portada']) : 1;
			$obj->fields['imagen_status']['value']	=	isset($_POST['imagen_status']) ? number($_POST['imagen_status']) : 0;

			if(strlen($_FILES['file']['name'])> 0):
				if($_FILES['file']['error'] == 0):
					if($id > 0):
						$picture = self::select($id);
						if(count($picture) > 0):
							@unlink($picture[0]['imagen_image_small_path']);
							@unlink($picture[0]['imagen_image_big_path']);
						endif;
					endif;

					$sourceName	 = $_FILES['file']['name'];
					$sourceImage = $_FILES['file']['tmp_name'];
					$targetImage = strtoupper(uniqid(randomnumbers(6,8).'_'.randomnumbers(6,8).'_'));

					$size = getimagesize($sourceImage);
	      			$size_w = $size[0]; // 433width
	      			$size_h = $size[1]; // 445height

					/* sube la foto */
					$img = new ImageUpload();
					$img->setOutputFormat("JPG");
					$img->fileToResize($sourceImage);
					$img->setAlignment("center");
					$img->setBackgroundColor(array(255, 255, 255));

					$img->setOutputFile($targetImage . "_B");
					$img->setTarget(rootUpload . "imagenes_productos/");
					$img->setSize($size_w, $size_h);
					$img->Resize();
					$file_large = $img->getOutputFileName();

					$img->setOutputFile($targetImage . "_S");
					$img->setSize(281, 200);
					$img->Resize();
					$file_small = $img->getOutputFileName();

					$obj->fields['imagen_file_name']['value']			= $sourceName;
					$obj->fields['imagen_image_big_path']['value']	= rootUpload . "imagenes_productos/" . $file_large;
					$obj->fields['imagen_image_big_url']['value']		= uploadURL  . "imagenes_productos/" . $file_large;
					$obj->fields['imagen_image_small_path']['value']	= rootUpload . "imagenes_productos/" . $file_small;
					$obj->fields['imagen_image_small_url']['value']	= uploadURL  . "imagenes_productos/" . $file_small;

				else:
					Message::set("Por favor, elija una foto", MESSAGE_ERROR);
					return $obj->error;
				endif;
			else:

				if($id > 0):
					$picture = self::select($id);
					if(count($picture) > 0):
						$obj->fields['imagen_file_name']['value']				= $picture[0]['imagen_file_name'];
						$obj->fields['imagen_image_big_path']['value']		= $picture[0]['imagen_image_big_path'];
						$obj->fields['imagen_image_big_url']['value']			= $picture[0]['imagen_image_big_url'];
						$obj->fields['imagen_image_small_path']['value']		= $picture[0]['imagen_image_small_path'];
						$obj->fields['imagen_image_small_url']['value']		= $picture[0]['imagen_image_small_url'];
					endif;
				else:

					Message::set("Por favor, elija una imagen", MESSAGE_ERROR);
					return $obj->error;

				endif;
			endif;

			if($obj->validate($obj,$id)):
				return $obj->update($obj, $id);
			else:
				
				@unlink(rootUpload . "imagenes_productos/" . $file_large);
				@unlink(rootUpload . "imagenes_productos/" . $file_small);

				Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
				return $obj->error;
			endif;
		//}

	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "imagen_hidden", 1, $obj->primaryKey . " = {$id}");
		$picture = self::select($id);
		if(count($picture) > 0):
			@unlink($picture[0]['imagen_image_small_path']);
			@unlink($picture[0]['imagen_image_big_path']);
		endif;

	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "imagen_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}imagen_status = 1 AND imagen_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}imagen_status = 1 AND imagen_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}imagen_status = 1 AND imagen_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}imagen_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE imagen_status = 1 AND imagen_hidden = 0{$where}");
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
					self::set("imagen_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("imagen_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT imagen_id, producto_id FROM imagenes_productos WHERE imagen_status = 1 AND imagen_hidden = 0 ORDER BY producto_id ASC";
		$list = $obj->exec($list);
		print '<select name="imagen_id" id="imagenes_productos_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['imagen_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['imagen_id'].'"'.$select.'>'.htmlspecialchars($dat['producto_id']).'</option>';
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