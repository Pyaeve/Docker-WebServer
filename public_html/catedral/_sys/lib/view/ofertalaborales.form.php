<?php
clearBuffer();
$modulename	= "Curriculum Vitae";
$laboral_id	= numParam('id');
$title		= $laboral_id > 0 ? "Modificar" : "Nuevo";
$data		= Ofertalaborales::select($laboral_id);

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
	$fields = Ofertalaborales::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['laboral_status'] = $_POST['laboral_status'] == NULL ? 1 : $_POST['laboral_status'];
endif;
$callback	= array(
	"success"	=> "upload.success.php",
	"error"		=> "upload.error.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('ofertalaborales&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('ofertalaborales&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('ofertalaborales&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="ofertalaborales_form" name="ofertalaborales_form" method="post" autocomplete="off" action="js/save" target="upload_frame" enctype="multipart/form-data">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['laboral_nombre']) ? " error" : "";?>">
					<label class="control-label" for="laboral_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="laboral_nombre" name="laboral_nombre" value="<?php echo htmlspecialchars($_POST['laboral_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_documento']) ? " error" : "";?>">
					<label class="control-label" for="laboral_documento">CI</label>
					<div class="controls">
						<input class="" id="laboral_documento" name="laboral_documento" value="<?php echo htmlspecialchars($_POST['laboral_documento']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_documento'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_documento'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_tel']) ? " error" : "";?>">
					<label class="control-label" for="laboral_tel">Teléfono</label>
					<div class="controls">
						<input class="" id="laboral_tel" name="laboral_tel" value="<?php echo htmlspecialchars($_POST['laboral_tel']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_tel'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_tel'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_email']) ? " error" : "";?>">
					<label class="control-label" for="laboral_email">Email</label>
					<div class="controls">
						<input class="" id="laboral_email" name="laboral_email" value="<?php echo htmlspecialchars($_POST['laboral_email']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_email'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_email'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_edad']) ? " error" : "";?>">
					<label class="control-label" for="laboral_edad">Edad</label>
					<div class="controls">
						<input class="" id="laboral_edad" name="laboral_edad" value="<?php echo htmlspecialchars($_POST['laboral_edad']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_edad'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_edad'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_sexo']) ? " error" : "";?>">
					<label class="control-label" for="laboral_sexo">Sexo</label>
					<div class="controls">
						<input class="" id="laboral_sexo" name="laboral_sexo" value="<?php echo htmlspecialchars($_POST['laboral_sexo']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_sexo'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_sexo'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_fechanac']) ? " error" : "";?>">
					<label class="control-label" for="laboral_fechanac">Fecha Nac</label>
					<div class="controls">
						<input class="" id="laboral_fechanac" name="laboral_fechanac" value="<?php echo htmlspecialchars($_POST['laboral_fechanac']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_fechanac'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_fechanac'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_direccion']) ? " error" : "";?>">
					<label class="control-label" for="laboral_direccion">Direccion</label>
					<div class="controls">
						<input class="" id="laboral_direccion" name="laboral_direccion" value="<?php echo htmlspecialchars($_POST['laboral_direccion']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_direccion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_direccion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_barrio']) ? " error" : "";?>">
					<label class="control-label" for="laboral_barrio">Barrio</label>
					<div class="controls">
						<input class="" id="laboral_barrio" name="laboral_barrio" value="<?php echo htmlspecialchars($_POST['laboral_barrio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_barrio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_barrio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_ciudad']) ? " error" : "";?>">
					<label class="control-label" for="laboral_ciudad">Ciudad</label>
					<div class="controls">
						<input class="" id="laboral_ciudad" name="laboral_ciudad" value="<?php echo htmlspecialchars($_POST['laboral_ciudad']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_ciudad'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_ciudad'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_lugarnac']) ? " error" : "";?>">
					<label class="control-label" for="laboral_lugarnac">Lugar Nac</label>
					<div class="controls">
						<input class="" id="laboral_lugarnac" name="laboral_lugarnac" value="<?php echo htmlspecialchars($_POST['laboral_lugarnac']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_lugarnac'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_lugarnac'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_nacionalidad']) ? " error" : "";?>">
					<label class="control-label" for="laboral_nacionalidad">Nacionalidad</label>
					<div class="controls">
						<input class="" id="laboral_nacionalidad" name="laboral_nacionalidad" value="<?php echo htmlspecialchars($_POST['laboral_nacionalidad']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_nacionalidad'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_nacionalidad'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_profesion']) ? " error" : "";?>">
					<label class="control-label" for="laboral_profesion">Profesion</label>
					<div class="controls">
						<input class="" id="laboral_profesion" name="laboral_profesion" value="<?php echo htmlspecialchars($_POST['laboral_profesion']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['laboral_profesion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_profesion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
<?php
				if($laboral_id > 0):
				?>
				<div class="control-group">
					<label class="control-label" for="banner_href">Archivo actual</label>
					<div class="controls">
						<span><?php echo $_POST['laboral_file_name'];?></span>
					</div>
				</div>
				<?php
				endif;
				?>

				<div class="control-group<?php echo isset($error['laboral_file_name']) ? " error" : "";?>">
					<label class="control-label" for="laboral_file_name">Archivo</label>
					<div class="controls">
						<div class="fileupload fileupload-new" data-provides="fileupload">
						  	<div class="input-append">
						    	<div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Buscar archivo</span><span class="fileupload-exists">Cambiar</span><input type="file" name="laboral_file_name" id="laboral_file_name" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Quitar</a>
						  	</div>
						</div>
						
						<?php
						if(isset($error['laboral_file_name'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_file_name'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['laboral_status']) ? " error" : "";?>">
					<label class="control-label" for="laboral_status">Activo</label>
					<div class="controls">
						<input class="" id="laboral_status" name="laboral_status" value="1" type="checkbox"<?php if($_POST['laboral_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['laboral_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['laboral_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $laboral_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Ofertalaborales::save(".$laboral_id.")");?>" />
			<input type="hidden" name="option" value="ofertalaborales" id="option" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('ofertalaborales&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>
<iframe name="upload_frame" id="upload_frame" style="border:none;width:10px; height:10px;"></iframe>

<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
