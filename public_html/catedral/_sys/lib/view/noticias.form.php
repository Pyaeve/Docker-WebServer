<?php
clearBuffer();
$modulename	= "Informacion para Ti";
$noticia_id	= numParam('id');
$title		= $noticia_id > 0 ? "Modificar" : "Nuevo";
$data		= Noticias::select($noticia_id);

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
	$fields = Noticias::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['noticia_status'] = $_POST['noticia_status'] == NULL ? 1 : $_POST['noticia_status'];
endif;
$callback	= array(
	"success"	=> "upload.success.php",
	"error"		=> "upload.error.php"
);
?>
<style>
	.ck-editor__editable {
	    min-height: 400px;
	}
	input, select{ width: 100%;  }
</style>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('noticias&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons cargo" style="width:50% !important;"><i></i><a href="" onclick="module('noticias&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('noticias&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="noticias_form" name="noticias_form" method="post" autocomplete="off" action="js/save" target="upload_frame" enctype="multipart/form-data">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span8">
				<div class="control-group<?php echo isset($error['noticia_titulo']) ? " error" : "";?>">
					<label class="control-label" for="noticia_titulo">Titulo</label>
					<div class="controls">
						<input class="" id="noticia_titulo" name="noticia_titulo" value="<?php echo htmlspecialchars($_POST['noticia_titulo']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['noticia_titulo'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_titulo'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				<!--
				<div class="control-group<?php //echo isset($error['noticia_descripcionbreve']) ? " error" : "";?>">
					<label class="control-label" for="noticia_descripcionbreve">Descripcion Breve</label>
					<div class="controls">
						<textarea class="" id="noticia_descripcionbreve" name="noticia_descripcionbreve" style="color:#000; width:500px; height:160px;">
							<?php //echo htmlspecialchars($_POST['noticia_descripcionbreve']);?></textarea>
						
						<?php
						/*if(isset($error['noticia_descripcionbreve'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_descripcionbreve'];?></span></p>
						<?php
						endif;*/
						?>
					</div>
				</div>-->
				<div class="control-group<?php echo isset($error['noticia_descripcion']) ? " error" : "";?>">
					<label class="control-label" for="noticia_descripcion">Contenido</label>
					<div class="controls">
						<textarea class="" id="noticia_descripcion" name="noticia_descripcion" style="color:#000; width:500px; height:160px;"><?php echo htmlspecialchars($_POST['noticia_descripcion']);?></textarea>
						
						<?php
						if(isset($error['noticia_descripcion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_descripcion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['noticia_fecha']) ? " error" : "";?>">
					<label class="control-label" for="noticia_fecha">Fecha</label>
					<div class="controls">
						<input class="" id="noticia_fecha" name="noticia_fecha" value="<?php echo htmlspecialchars($_POST['noticia_fecha']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['noticia_fecha'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_fecha'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

								<?php
				if($noticia_id > 0):
				?>
				<div class="control-group">
					<label class="control-label" for="banner_href">Imagen actual</label>
					<div class="controls">
						<img src="<?php echo $_POST['noticia_image_small_url'];?>" />
					</div>
				</div>
				<?php
				endif;
				?>

				<div class="control-group<?php echo isset($error['noticia_file_name']) ? " error" : "";?>">
					<label class="control-label" for="noticia_file_name">Imagen Activa</label>
					<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Buscar imagen</span><span class="fileupload-exists">Cambiar</span><input type="file" name="noticia_file_name" id="noticia_file_name" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>
						  	</div>
						</div><label>(Dimensiones 1140,487px)</label>
						
						<?php
						if(isset($error['noticia_file_name'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_file_name'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['noticia_status']) ? " error" : "";?>">
					<label class="control-label" for="noticia_status">Activo</label>
					<div class="controls">
						<input class="" id="noticia_status" name="noticia_status" value="1" type="checkbox"<?php if($_POST['noticia_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['noticia_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['noticia_destacado']) ? " error" : "";?>">
					<label class="control-label" for="noticia_destacado">Destacado</label>
					<div class="controls">
						<input class="" id="noticia_destacado" name="noticia_destacado" value="1" type="checkbox"<?php if($_POST['noticia_destacado'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['noticia_destacado'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['noticia_destacado'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $noticia_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Noticias::save(".$noticia_id.")");?>" />
			<input type="hidden" name="option" value="noticias" id="option" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('noticias&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>
<iframe name="upload_frame" id="upload_frame" style="border:none;width:10px; height:10px;"></iframe>


<script type="text/javascript">
	$(document).ready(function () {
		//$("#info_contenido").wysihtml5();

		$('#btn_aceptar').click(function(){
			$('#noticia_descripcion').val(editor.getData());
		});
	});

	var editor = CKEDITOR.replace( 'noticia_descripcion' );

</script>

