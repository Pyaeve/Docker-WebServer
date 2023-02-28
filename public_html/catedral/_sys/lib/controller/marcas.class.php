<?php
class Marcas extends Mysql{
	protected $tableName	= "marcas";
	protected $primaryKey = "marca_id";
	protected $fields	= array(
		"marca_nombre"	=> array("type" => "varchar",	"length"=> 90, "required" => "1", "validation" => "none"),
		"marca_file_name"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"marca_image_small_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"marca_image_small_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"marca_image_big_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"marca_image_big_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"marca_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['marca_nombre']['value']	=	$_POST['marca_nombre'];
		$obj->fields['marca_status']['value']	=	isset($_POST['marca_status']) ? number($_POST['marca_status']) : 0;



		if(strlen($_FILES['marca_file_name']['name'])> 0):

			if($_FILES['marca_file_name']['error'] == 0):

				if($id > 0):
					$picture = self::select($id);
					if(count($picture) > 0):
						@unlink($picture[0]['marca_image_small_path']);
						@unlink($picture[0]['marca_image_big_path']);
					endif;
				endif;

				$sourceName	 = $_FILES['marca_file_name']['name'];
				$sourceImage = $_FILES['marca_file_name']['tmp_name'];
				$targetImage = strtoupper(uniqid(randomnumbers(6,8).'_'.randomnumbers(6,8).'_'));
				$size = getimagesize($sourceImage);
      			$size_w = $size[0]; // width
      			$size_h = $size[1]; // height

				/* sube la foto */
				$img = new ImageUpload();
				$img->setOutputFormat("JPG");
				$img->fileToResize($sourceImage);
				$img->setAlignment("center");
				$img->setBackgroundColor(array(255, 255, 255));

				$img->setOutputFile($targetImage . "_B");
				$img->setTarget(rootUpload . "marcas/");
				$img->setSize($size_w,$size_h);
				$img->Resize();
				$file_large = $img->getOutputFileName();

				$img->setOutputFile($targetImage . "_S");
				$img->setSize(150,150);
				$img->Resize();
				$file_small = $img->getOutputFileName();

				$obj->fields['marca_file_name']['value']			= $sourceName;
				$obj->fields['marca_image_big_path']['value']	= rootUpload . "marcas/" . $file_large;
				$obj->fields['marca_image_big_url']['value']		= uploadURL  . "marcas/" . $file_large;
				$obj->fields['marca_image_small_path']['value']	= rootUpload . "marcas/" . $file_small;
				$obj->fields['marca_image_small_url']['value']	= uploadURL  . "marcas/" . $file_small;

			else:
				Message::set("Por favor, elija una foto", MESSAGE_ERROR);
				return $obj->error;
			endif;

		else:

			if($id > 0):
				$picture = self::select($id);
				if(count($picture) > 0):
					$obj->fields['marca_file_name']['value']				= $picture[0]['marca_file_name'];
					$obj->fields['marca_image_big_path']['value']		= $picture[0]['marca_image_big_path'];
					$obj->fields['marca_image_big_url']['value']			= $picture[0]['marca_image_big_url'];
					$obj->fields['marca_image_small_path']['value']		= $picture[0]['marca_image_small_path'];
					$obj->fields['marca_image_small_url']['value']		= $picture[0]['marca_image_small_url'];
				endif;
			else:

				Message::set("Por favor, elija una imagen", MESSAGE_ERROR);
				return $obj->error;

			endif;


		endif;
		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			@unlink(rootUpload . "marcas/" . $file_large);
			@unlink(rootUpload . "marcas/" . $file_small);

			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "marca_hidden", 1, $obj->primaryKey . " = {$id}");
		$picture = self::select($id);
		if(count($picture) > 0):
			@unlink($picture[0]['marca_image_small_path']);
			@unlink($picture[0]['marca_image_big_path']);
		endif;

	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "marca_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}marca_status = 1 AND marca_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}marca_status = 1 AND marca_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}marca_status = 1 AND marca_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}marca_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE marca_status = 1 AND marca_hidden = 0{$where}");
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
					self::set("marca_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("marca_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT marca_id, marca_nombre FROM marcas WHERE marca_status = 1 AND marca_hidden = 0 ORDER BY marca_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="marca_id" id="marca_id" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['marca_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['marca_id'].'"'.$select.'>'.htmlspecialchars($dat['marca_nombre']).'</option>';
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