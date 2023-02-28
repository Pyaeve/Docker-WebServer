<?php
class Ofertalaborales extends Mysql{
	protected $tableName	= "ofertalaborales";
	protected $primaryKey = "laboral_id";
	protected $fields	= array(
		"laboral_nombre"	=> array("type" => "varchar",	"length"=> 250, "required" => "1", "validation" => "none"),
		"laboral_documento"	=> array("type" => "varchar",	"length"=> 50, "required" => "1", "validation" => "none"),
		"laboral_tel"	=> array("type" => "varchar",	"length"=> 50, "required" => "1", "validation" => "none"),
		"laboral_email"	=> array("type" => "varchar",	"length"=> 150, "required" => "1", "validation" => "none"),
		"laboral_edad"	=> array("type" => "int", "required" => "0", "validation" => "none"),
		"laboral_sexo"	=> array("type" => "varchar",	"length"=> 20, "required" => "0", "validation" => "none"),
		"laboral_fechanac"	=> array("type" => "datetime", "required" => "1", "validation" => "none"),
		"laboral_direccion"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"laboral_barrio"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"laboral_ciudad"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"laboral_lugarnac"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"laboral_nacionalidad"	=> array("type" => "varchar",	"length"=> 90, "required" => "0", "validation" => "none"),
		"laboral_profesion"	=> array("type" => "varchar",	"length"=> 150, "required" => "0", "validation" => "none"),
		"laboral_file_name"	=> array("type" => "text",	"length"=> 65535, "required" => "1", "validation" => "none"),
		"laboral_file_path"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"laboral_file_url"	=> array("type" => "text",	"length"=> 65535, "required" => "0", "validation" => "none"),
		"laboral_status"	=> array("type" => "tinyint", "required" => "1", "validation" => "none"),
	);

	/*inserta o modifica un registro*/

	public static function save($id){

		$obj = new self($id);

		$obj->fields['laboral_nombre']['value']	=	$_POST['laboral_nombre'];
		$obj->fields['laboral_documento']['value']	=	$_POST['laboral_documento'];
		$obj->fields['laboral_tel']['value']	=	$_POST['laboral_tel'];
		$obj->fields['laboral_email']['value']	=	$_POST['laboral_email'];
		$obj->fields['laboral_edad']['value']	=	$_POST['laboral_edad'];
		$obj->fields['laboral_sexo']['value']	=	$_POST['laboral_sexo'];
		$fecha = date('Y-m-d', strtotime($_POST['laboral_fechanac']) );
		$obj->fields['laboral_fechanac']['value']	=	$fecha;
		
		$obj->fields['laboral_direccion']['value']	=	$_POST['laboral_direccion'];
		$obj->fields['laboral_barrio']['value']	=	$_POST['laboral_barrio'];
		$obj->fields['laboral_ciudad']['value']	=	$_POST['laboral_ciudad'];
		$obj->fields['laboral_lugarnac']['value']	=	$_POST['laboral_lugarnac'];
		$obj->fields['laboral_nacionalidad']['value']	=	$_POST['laboral_nacionalidad'];
		$obj->fields['laboral_profesion']['value']	=	$_POST['laboral_profesion'];

		$obj->fields['laboral_status']['value']	=	isset($_POST['laboral_status']) ? number($_POST['laboral_status']) : 0;



		/*sube archivos*/
		if(strlen($_FILES['laboral_file_name']['name'])> 0):

			$sourceName	= $_FILES['laboral_file_name']['name'];
			$sourceFile = $_FILES['laboral_file_name']['tmp_name'];
			$fileExt	= explode(".", $sourceName);
			$fileExt	= strtolower($fileExt[count($fileExt) - 1]);
			$targetFile = strtoupper(uniqid(randomnumbers(6,8).'_'.randomnumbers(6,8).'_'));
			$file_name	= $targetFile . "." . $fileExt;

			if($_FILES['laboral_file_name']['error'] == 0):

				if($id > 0):
					$file = self::select($id);
					if(count($file) > 0):
						@unlink($file[0]['laboral_file_path']);
					endif;
				endif;

				$format = false;

				switch($_FILES['laboral_file_name']['type']):
					case "application/pdf":
					case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
						$format = true;
						break;
				endswitch;

				if($format):
					$obj->fields['laboral_file_name']['value']	= $sourceName;
					$obj->fields['laboral_file_path']['value']	= rootUpload . "ofertalaborales/" . $file_name;
					$obj->fields['laboral_file_url']['value']	= uploadURL  . "ofertalaborales/" . $file_name;
					@move_uploaded_file($sourceFile, rootUpload . "ofertalaborales/" . $file_name);
				else:
					Message::set("El formato del archivo que intenta subir es incorrecto", MESSAGE_ERROR);
					return $obj->error;
				endif;

			else:
				Message::set("Por favor, elija un archivo", MESSAGE_ERROR);
				return $obj->error;
			endif;

		else:

			if($id > 0):
				$file = self::select($id);
				if(count($file) > 0):
					$obj->fields['laboral_file_name']['value']	= $file[0]['laboral_file_name'];
					$obj->fields['laboral_file_path']['value']	= $file[0]['laboral_file_path'];
					$obj->fields['laboral_file_url']['value']	= $file[0]['laboral_file_url'];
				endif;
			else:

				Message::set("Por favor, elija un archivo", MESSAGE_ERROR);
				return $obj->error;

			endif;


		endif;
		if($obj->validate($obj,$id)):
			return $obj->update($obj, $id);
		else:
			
			@unlink(rootUpload . "ofertalaborales/" . $file_large);
			@unlink(rootUpload . "ofertalaborales/" . $file_small);

			Message::set("Por favor complete correctamente el formulario para continuar", MESSAGE_ERROR);
			return $obj->error;
		endif;
	}

	/*oculta o elimina un registro*/
	public static function delete($id){
		$obj = new self();
		$obj->change($obj->tableName, "laboral_hidden", 1, $obj->primaryKey . " = {$id}");
		$picture = self::select($id);
		if(count($picture) > 0):
			@unlink($picture[0]['laboral_image_small_path']);
			@unlink($picture[0]['laboral_image_big_path']);
		endif;

	}

	public static function select($id){
		$obj = new self();
		return $obj->find($obj->tableName, $obj->primaryKey, $id, "laboral_hidden = 0");
	}
	
	
	public static function get($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}laboral_status = 1 AND laboral_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function getFirst($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}laboral_status = 1 AND laboral_hidden = 0 ORDER BY " . $obj->primaryKey . " ASC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getLast($where=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}laboral_status = 1 AND laboral_hidden = 0 ORDER BY " . $obj->primaryKey . " DESC LIMIT 0,1";
		return $obj->execute($sql);
	}

	public static function getAll($where=null,$order=null){
		$obj = new self();
		$whr = $where == null ? "" : "{$where} AND ";
		$ord = $order == null ? "" : " ORDER BY {$order}";
		$sql = "SELECT * FROM " . $obj->tableName . " WHERE {$whr}laboral_hidden = 0{$ord}";
		return $obj->execute($sql);
	}

	public static function listing($limit=10, $page=1, $fields=null, $where=null){
		$obj = new self();
		$listing = new Listing();
		$where = strlen($where) > 0 ? " AND {$where}" : "";
		return $listing->get($obj->tableName, $limit, $fields, $page, "WHERE laboral_status = 1 AND laboral_hidden = 0{$where}");
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
					self::set("laboral_status", 1, $obj->primaryKey . " = {$id}");
				endforeach;
				break;
			//desactivar
			case "2":
				foreach($ids as $id):
					self::set("laboral_status", 0, $obj->primaryKey . " = {$id}");
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
		$list = "SELECT laboral_id, laboral_nombre FROM ofertalaborales WHERE laboral_status = 1 AND laboral_hidden = 0 ORDER BY laboral_nombre ASC";
		$list = $obj->exec($list);
		print '<select name="laboral_id" id="ofertalaborales_combo" style="color:#000;" onchange="">';
			print '<option value=""'.$fsel.'>Seleccionar</option>';
			if(is_array($list) && count($list) > 0):
				foreach($list as $dat):
					$select = $dat['laboral_id'] == $selected ? ' selected="selected"' : "";
					print '<option value="'.$dat['laboral_id'].'"'.$select.'>'.htmlspecialchars($dat['laboral_nombre']).'</option>';
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