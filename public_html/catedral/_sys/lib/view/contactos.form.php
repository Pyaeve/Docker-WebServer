<?php
clearBuffer();
$modulename	= "Contactos";
$contacto_id	= numParam('id');
$title		= $contacto_id > 0 ? "Modificar" : "Nuevo";
$data		= Contactos::select($contacto_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Contactos::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['contacto_status'] = $_POST['contacto_status'] == NULL ? 1 : $_POST['contacto_status'];
endif;
$callback	= array(
	"success"	=> "contactos.view.php",
	"error"		=> "contactos.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('contactos&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons inbox" style="width:50% !important;"><i></i><a href="" onclick="module('contactos&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('contactos&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="contactos_form" name="contactos_form" method="post" autocomplete="off" onsubmit="savedata('contactos');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['contacto_nombre']) ? " error" : "";?>">
					<label class="control-label" for="contacto_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="contacto_nombre" name="contacto_nombre" value="<?php echo htmlspecialchars($_POST['contacto_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contacto_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contacto_documento']) ? " error" : "";?>">
					<label class="control-label" for="contacto_documento">CI</label>
					<div class="controls">
						<input class="" id="contacto_documento" name="contacto_documento" value="<?php echo htmlspecialchars($_POST['contacto_documento']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contacto_documento'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_documento'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contacto_telefono']) ? " error" : "";?>">
					<label class="control-label" for="contacto_telefono">Tel</label>
					<div class="controls">
						<input class="" id="contacto_telefono" name="contacto_telefono" value="<?php echo htmlspecialchars($_POST['contacto_telefono']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contacto_telefono'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_telefono'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contacto_email']) ? " error" : "";?>">
					<label class="control-label" for="contacto_email">Email</label>
					<div class="controls">
						<input class="" id="contacto_email" name="contacto_email" value="<?php echo htmlspecialchars($_POST['contacto_email']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contacto_email'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_email'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contacto_asunto']) ? " error" : "";?>">
					<label class="control-label" for="contacto_asunto">Asunto</label>
					<div class="controls">
						<input class="" id="contacto_asunto" name="contacto_asunto" value="<?php echo utf8_encode($_POST['contacto_asunto']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['contacto_asunto'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_asunto'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contacto_mensaje']) ? " error" : "";?>">
					<label class="control-label" for="contacto_mensaje">Mensaje</label>
					<div class="controls">
						<textarea class="" id="contacto_mensaje" name="contacto_mensaje" style="color:#000; width:500px; height:160px;"><?php echo utf8_encode($_POST['contacto_mensaje']);?></textarea>
						
						<?php
						if(isset($error['contacto_mensaje'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_mensaje'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['contacto_status']) ? " error" : "";?>">
					<label class="control-label" for="contacto_status">Activo</label>
					<div class="controls">
						<input class="" id="contacto_status" name="contacto_status" value="1" type="checkbox"<?php if($_POST['contacto_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['contacto_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['contacto_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $contacto_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Contactos::save(".$contacto_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('contactos&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
