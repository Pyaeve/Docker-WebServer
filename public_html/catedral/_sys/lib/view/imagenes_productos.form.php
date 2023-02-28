<?php
clearBuffer();
$modulename	= "Imagenes";
$imagen_id	= numParam('id');

$producto_id = numParam('producto_id');
$productos = Productos::select($producto_id);
$producto = $productos['0'];
$producto_codigo_img = $producto['producto_codigo'];
$producto_title = " > ".$producto['producto_nombre'];
$pagina = numParam('pagina');

$title		= $imagen_id > 0 ? "Modificar" : "Nuevo";
$data		= Imagenes_productos::select($imagen_id);

if(isset($_GET['error'])):
	$error = array();
	$_POST = $_GET;
	foreach($_GET as $gk => $gv):
		if(strpos($gk,"error_") !== false):
			$error[str_replace("error_","", $gk)] = $gv;
		endif;
	endforeach;
endif;

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Imagenes_productos::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['imagen_status'] = $_POST['imagen_status'] == NULL ? 1 : $_POST['imagen_status'];
endif;
$callback	= array(
	"success"	=> "upload.success.php",
	"error"		=> "upload.error.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons picture" style="width:50% !important;"><i></i><a href="" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">

		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="imagenes_productos_form" name="imagenes_productos_form" method="post" autocomplete="off" action="js/save" target="upload_frame" enctype="multipart/form-data">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
								<?php
				if($imagen_id > 0):
				?>
				<div class="control-group">
					<label class="control-label" for="banner_href">Imagen actual</label>
					<div class="controls">
						<img src="<?php echo $_POST['imagen_image_small_url'];?>" />
					</div>
				</div>
				<?php
				endif;
				?>

				<div class="control-group<?php echo isset($error['imagen_file_name']) ? " error" : "";?>">
					<label class="control-label" for="imagen_file_name">Imagen</label>
					<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Buscar imagen</span><span class="fileupload-exists">Cambiar</span><input type="file" name="imagen_file_name" id="imagen_file_name" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>
						  	</div>
						</div><label>(Dimensiones 433,445px)</label>
						
						<?php
						if(isset($error['imagen_file_name'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['imagen_file_name'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['imagen_portada']) ? " error" : "";?>">
					<label class="control-label" for="imagen_portada">Portada</label>
					<div class="controls">
						<input class="" id="imagen_portada" name="imagen_portada" value="1" type="checkbox"<?php if($_POST['imagen_portada'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['imagen_portada'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['imagen_portada'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['imagen_status']) ? " error" : "";?>">
					<label class="control-label" for="imagen_status">Activo</label>
					<div class="controls">
						<input class="" id="imagen_status" name="imagen_status" value="1" type="checkbox"<?php if($_POST['imagen_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['imagen_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['imagen_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $imagen_id;?>" />
			<input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>" />
			<input type="hidden" name="producto_codigo_img" value="<?php echo $producto_codigo_img; ?>" />

			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Imagenes_productos::save(".$imagen_id.")");?>" />
			<input type="hidden" name="option" value="imagenes_productos" id="option" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>
<iframe name="upload_frame" id="upload_frame" style="border:none;width:10px; height:10px;"></iframe>

<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
