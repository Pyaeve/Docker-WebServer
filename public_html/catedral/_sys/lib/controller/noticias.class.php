<?php
class Noticias extends Mysql{
	protected $tableName	= "noticias";
	protected $primaryKey = "noticia_id";
	protected $fields	= array(
		"noticia_titulo"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"noticia_slugit"	=> array("type" => "varchar",	"length"=> 250, "required" => "0", "validation" => "none"),
		"noticia_descripcion"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_descripcionbreve"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_fecha"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_file_name"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"noticia_image_small_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_image_small_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_image_big_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_image_big_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"noticia_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
		"noticia_destacado"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['noticia_titulo']['value']	=	$_POST['noticia_titulo'];
		if($id > 0){
			$obj->fields['noticia_slugit']['value']	=	slugit($_POST['noticia_titulo'].$id);
		}else{
			$numero = Noticias::getLast();
			$numero = $numero[0]['noticia_id']+1;
			$obj->fields['noticia_slugit']['value']	=	slugit($_POST['noticia_titulo'].$numero);
		}
		$obj->fields['noticia_descripcion']['value']	=	$_POST['noticia_descripcion'];
		$obj->fields['noticia_descripcionbreve']['value']	=	$_POST['noticia_descripcionbreve'];
		
		$obj->fields['noticia_fecha']['value']	=	$_POST['noticia_fecha'];
		$obj->fields['noticia_status']['value']	=	isset($_POST['noticia_status']) ? number($_POST['noticia_status']) : 0;
		$obj->fields['noticia_destacado']['value']	=	$_POST['noticia_destacado'];



		if(strlen($_FILES['noticia_file_name']['name'])> 0):

			if($_FILES['noticia_file_name']['error'] == 0):

				if($id > 0):
					$picture = self::select($id);
					if(count($picture) > 0):
						@unlink($picture[0]['noticia_image_small_path']);
						@unlink($picture[0]['noticia_image_big_path']);
					endif;
				endif;

				$sourceName	 = $_FILES['noticia_file_name']['name'];
				$sourceImage = $_FILES['noticia_file_name']['tmp_name'];
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
				$img->setTarget(rootUpload . "noticias/");
				$img->setSize($size_w,$size_h);
				$img->Resize();
				$file_large = $img->getOutputFileName();

				$img->setOutputFile($targetImage . "_S");
				$img->setSize(360,140);
				$img->Resize();
				$file_small = $img->getOutputFileName();

				$obj->fields['noticia_file_name']['value']			= $sourceName;
				$obj->fields['noticia_image_big_path']['value']	= rootUpload . "noticias/" . $file_large;
				$obj->fields['noticia_image_big_url']['value']		= uploadURL  . "noticias/" . $file_large;
				$obj->fields['noticia_image_small_path']['value']	= rootUpload . "noticias/" . $file_small;
				$obj->fields['noticia_image_small_url']['value']	= uploadURL  . "noticias/" . $file_small;

			else:
				Message::set("Por favor, elija una foto", MESSAGE_ERROR);
				return $obj->error;
			endif;

		else:

			if($id > 0):
				$picture = self::select($id);
				if(count($picture) > 0):
					$obj->fields['noticia_file_name']['value']				= $picture[0]['noticia_file_name'];
					$obj->fields['noticia_image_big_path']['value']		= $picture[0]['noticia_image_big_path'];
					$obj->fields['noticia_image_big_url']['value']			= $picture[0]['noticia_image_big_url'];
					$obj->fields['noticia_image_small_path']['value']		= $picture[0]['noticia_image_small_path'];
					$obj->fields['noticia_image_small_url']['value']		= $picture[0]['noticia_image_small_url'];
				endif;
			else:

				Message::set("Por favor, elija una imagen", MESSAGE_ERROR);
				return $obj->error;

			endif;


		endif;
		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			@unlink(rootUpload . "noticias/" . $file_large);
			@unlink(rootUpload . "noticias/" . $file_small);

			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "noticia_hidden", 1, $obj->primaryKey . " = {$id}");
		$picture = self::select($id);
		if(count($picture) > 0):
			@unlink($picture[0]['noticia_image_small_path']);
			@unlink($picture[0]['noticia_image_big_path']);
		endif;

	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "noticia_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}noticia_status = 1 AND noticia_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}noticia_status = 1 AND noticia_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}noticia_status = 1 AND noticia_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}noticia_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE noticia_status = 1 AND noticia_hidden = 0{$where}");
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
					self::set("noticia_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("noticia_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT noticia_id, noticia_titulo FROM noticias WHERE noticia_status = 1 AND noticia_hidden = 0 ORDER BY noticia_titulo ASC";
		$list = $obj->exec($list);
		print '<select name="noticia_id" id="noticias_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['noticia_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['noticia_id'].'"'.$select.'>'.htmlspecialchars($dat['noticia_titulo']).'</option>';
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