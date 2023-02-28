<?php
clearBuffer();
$modulename	= "Banners";
$banner_id	= numParam('id');
$title		= $banner_id > 0 ? "Modificar" : "Nuevo";
$data		= Banners::select($banner_id);

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
	$fields = Banners::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['banner_status'] = $_POST['banner_status'] == NULL ? 1 : $_POST['banner_status'];
endif;
$callback	= array(
	"success"	=> "upload.success.php",
	"error"		=> "upload.error.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('banners&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons picture" style="width:50% !important;"><i></i><a href="" onclick="module('banners&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('banners&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="banners_form" name="banners_form" method="post" autocomplete="off" action="js/save" target="upload_frame" enctype="multipart/form-data">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
								<?php
				if($banner_id > 0):
				?>
				<div class="control-group">
					<label class="control-label" for="banner_href">Imagen actual</label>
					<div class="controls">
						<img src="<?php echo $_POST['banner_image_small_url'];?>" />
					</div>
				</div>
				<?php
				endif;
				?>

				<div class="control-group<?php echo isset($error['banner_file_name']) ? " error" : "";?>">
					<label class="control-label" for="banner_file_name">Imagen</label>
					<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Buscar imagen</span><span class="fileupload-exists">Cambiar</span><input type="file" name="banner_file_name" id="banner_file_name" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>
						  	</div>
						</div><label>(Dimensiones para una correcta visualizacion: 1920,420px)</label>
						
						<?php
						if(isset($error['banner_file_name'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['banner_file_name'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['banner_href']) ? " error" : "";?>">
					<label class="control-label" for="banner_href">URL</label>
					<div class="controls">
						<input class="" id="banner_href" name="banner_href" value="<?php echo htmlspecialchars($_POST['banner_href']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['banner_href'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['banner_href'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['banner_orden']) ? " error" : "";?>">
					<label class="control-label" for="banner_orden">Orden</label>
					<div class="controls">
						<input class="" id="banner_orden" name="banner_orden" value="<?php echo htmlspecialchars($_POST['banner_orden']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['banner_orden'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['banner_orden'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['banner_status']) ? " error" : "";?>">
					<label class="control-label" for="banner_status">Activo</label>
					<div class="controls">
						<input class="" id="banner_status" name="banner_status" value="1" type="checkbox"<?php if($_POST['banner_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['banner_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['banner_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $banner_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Banners::save(".$banner_id.")");?>" />
			<input type="hidden" name="option" value="banners" id="option" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('banners&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>
<iframe name="upload_frame" id="upload_frame" style="border:none;width:10px; height:10px;"></iframe>

<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
