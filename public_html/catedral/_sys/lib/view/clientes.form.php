<?php
clearBuffer();
$cliente_id	= numParam('id');
$tipo = numParam('cliente_tipo');
$seccion = $tipo > 1 ? "Empresa" : "Persona";

$modulename	= "Clientes ".$seccion;

$title		= $cliente_id > 0 ? "Modificar" : "Nuevo";
$data		= Clientes::select($cliente_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
	$_POST['cliente_clave'] = NULL;
else:
	$fields = Clientes::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['cliente_status'] = $_POST['cliente_status'] == NULL ? 1 : $_POST['cliente_status'];
endif;
$callback	= array(
	"success"	=> "clientes.view.php",
	"error"		=> "clientes.form.php"
);


?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('clientes&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons group" style="width:50% !important;"><i></i><a href="" onclick="module('clientes&page=<?php echo pageNumber();?>&cliente_tipo=<?php echo $tipo; ?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('clientes&page=<?php echo pageNumber();?>&cliente_tipo=<?php echo $tipo; ?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="clientes_form" name="clientes_form" method="post" autocomplete="off" onsubmit="savedata('clientes');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['cliente_email']) ? " error" : "";?>">
					<label class="control-label" for="cliente_email">Email</label>
					<div class="controls">
						<input class="" id="cliente_email" name="cliente_email" value="<?php echo htmlspecialchars($_POST['cliente_email']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['cliente_email'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['cliente_email'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<!--<div class="control-group<?php //echo isset($error['cliente_clave']) ? " error" : "";?>">
					<label class="control-label" for="cliente_clave">Clave</label>
					<div class="controls">
						<input class="" id="cliente_clave" name="cliente_clave" value="<?php //echo htmlspecialchars($_POST['cliente_clave']);?>" type="text" style="color:#000;" />
						
						<?php
						//if(isset($error['cliente_clave'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php //echo $error['cliente_clave'];?></span></p>
						<?php
						//endif;
						?>
					</div>
				</div>-->

				<div class="control-group<?php echo isset($error['cliente_nombre']) ? " error" : "";?>">
					<label class="control-label" for="cliente_nombre">Nombres</label>
					<div class="controls">
						<input class="" id="cliente_nombre" name="cliente_nombre" value="<?php echo htmlspecialchars($_POST['cliente_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['cliente_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['cliente_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>



				<!--<div class="control-group<?php //echo isset($error['cliente_direccion']) ? " error" : "";?>">
					<label class="control-label" for="cliente_direccion">Direccion</label>
					<div class="controls">
						<input class="" id="cliente_direccion" name="cliente_direccion" value="<?php //echo htmlspecialchars($cliente_direccion/*$_POST['cliente_direccion']*/);?>" type="text" style="color:#000;" />
						
						<?php
						//if(isset($error['cliente_direccion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php //echo $error['cliente_direccion'];?></span></p>
						<?php
						//endif;
						?>
					</div>
				</div>-->


				<div class="control-group<?php echo isset($error['cliente_telefono']) ? " error" : "";?>">
					<label class="control-label" for="cliente_telefono">Telefono</label>
					<div class="controls">
						<input class="" id="cliente_telefono" name="cliente_telefono" value="<?php echo htmlspecialchars($_POST['cliente_telefono']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['cliente_telefono'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['cliente_telefono'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>


				<div class="control-group<?php echo isset($error['cliente_oferta_correo']) ? " error" : "";?>">
					<label class="control-label" for="cliente_oferta_correo">Oferta Correo</label>
					<div class="controls">
						<input class="" id="cliente_oferta_correo" name="cliente_oferta_correo" value="1" type="checkbox"<?php if($_POST['cliente_oferta_correo'] == 1){?> checked="checked"<?php } ?> />
						
						
						<?php
						if(isset($error['cliente_oferta_correo'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['cliente_oferta_correo'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>



				<div class="control-group<?php echo isset($error['cliente_status']) ? " error" : "";?>">
					<label class="control-label" for="cliente_status">Activo</label>
					<div class="controls">
						<input class="" id="cliente_status" name="cliente_status" value="1" type="checkbox"<?php if($_POST['cliente_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['cliente_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['cliente_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $cliente_id;?>" />
			<input type="hidden" name="cliente_tipo" value="<?php echo $cliente_tipo;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Clientes::save(".$cliente_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('clientes&page=<?php echo pageNumber();?>&cliente_tipo=<?php echo $tipo; ?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	  
	});

</script>
