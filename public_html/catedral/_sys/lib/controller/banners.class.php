<?php
class Banners extends Mysql{
	protected $tableName	= "banners";
	protected $primaryKey = "banner_id";
	protected $fields	= array(
		"banner_file_name"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"banner_image_small_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"banner_image_small_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"banner_image_big_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"banner_image_big_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"banner_href"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"banner_orden"	=> array("type" => "int",	"length"=> 11, "required" => "0", "validation" => "none"),
		"banner_status"	=> array("type" => "tinyint", "required" => "0", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['banner_href']['value']	=	$_POST['banner_href'];
		$obj->fields['banner_orden']['value']	=	$_POST['banner_orden'];
		$obj->fields['banner_status']['value']	=	isset($_POST['banner_status']) ? number($_POST['banner_status']) : 0;

		

		if(strlen($_FILES['banner_file_name']['name'])> 0):

			if($_FILES['banner_file_name']['error'] == 0):

				if($id > 0):
					$picture = self::select($id);
					if(count($picture) > 0):
						@unlink($picture[0]['banner_image_small_path']);
						@unlink($picture[0]['banner_image_big_path']);
					endif;
				endif;

				$sourceName	 = $_FILES['banner_file_name']['name'];
				$sourceImage = $_FILES['banner_file_name']['tmp_name'];
				$targetImage = strtoupper(uniqid(randomnumbers(6,8).'_'.randomnumbers(6,8).'_'));
				$size = getimagesize($sourceImage);
      			$size_w = 1920;//$size[0]; // width
      			$size_h = 420;//$size[1]; // height

				/* sube la foto */
				$img = new ImageUpload();
				$img->setOutputFormat("JPG");
				$img->fileToResize($sourceImage);
				$img->setAlignment("center");
				$img->setBackgroundColor(array(255, 255, 255));

				$img->setOutputFile($targetImage . "_B");
				$img->setTarget(rootUpload . "banners/");
				$img->setSize($size_w,$size_h);
				$img->Resize();
				$file_large = $img->getOutputFileName();

				$img->setOutputFile($targetImage . "_S");
				$img->setSize(150,150);
				$img->Resize();
				$file_small = $img->getOutputFileName();

				$obj->fields['banner_file_name']['value']			= $sourceName;
				$obj->fields['banner_image_big_path']['value']	= rootUpload . "banners/" . $file_large;
				$obj->fields['banner_image_big_url']['value']		= uploadURL  . "banners/" . $file_large;
				$obj->fields['banner_image_small_path']['value']	= rootUpload . "banners/" . $file_small;
				$obj->fields['banner_image_small_url']['value']	= uploadURL  . "banners/" . $file_small;

			else:
				Message::set("Por favor, elija una foto", MESSAGE_ERROR);
				return $obj->error;
			endif;

		else:

			if($id > 0):
				$picture = self::select($id);
				if(count($picture) > 0):
					$obj->fields['banner_file_name']['value']				= $picture[0]['banner_file_name'];
					$obj->fields['banner_image_big_path']['value']		= $picture[0]['banner_image_big_path'];
					$obj->fields['banner_image_big_url']['value']			= $picture[0]['banner_image_big_url'];
					$obj->fields['banner_image_small_path']['value']		= $picture[0]['banner_image_small_path'];
					$obj->fields['banner_image_small_url']['value']		= $picture[0]['banner_image_small_url'];
				endif;
			else:

				Message::set("Por favor, elija una imagen", MESSAGE_ERROR);
				return $obj->error;

			endif;


		endif;
		$banner = Banners::get2("banner_orden = ".$obj->fields['banner_orden']['value']." AND banner_id <> $id","");
		if(haveRows($banner)){
			Message::set("Entrada duplicada para campo Orden.", MESSAGE_ERROR);
			return $obj->error;
		}
		
		
		

		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
			
		else:
			
			@unlink(rootUpload . "banners/" . $file_large);
			@unlink(rootUpload . "banners/" . $file_small);

			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "banner_hidden", 1, $obj->primaryKey . " = {$id}");
		$picture = self::select($id);
		if(count($picture) > 0):
			@unlink($picture[0]['banner_image_small_path']);
			@unlink($picture[0]['banner_image_big_path']);
		endif;

	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "banner_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}banner_status = 1 AND banner_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function get2($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where}";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr} {$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}banner_status = 1 AND banner_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}banner_status = 1 AND banner_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}banner_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE banner_status = 1 AND banner_hidden = 0{$where}");
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
					self::set("banner_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("banner_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT banner_id, banner_file_name FROM banners WHERE banner_status = 1 AND banner_hidden = 0 ORDER BY banner_file_name ASC";
		$list = $obj->exec($list);
		print '<select name="banner_id" id="banners_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['banner_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['banner_id'].'"'.$select.'>'.htmlspecialchars($dat['banner_file_name']).'</option>';
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