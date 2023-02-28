<?php
clearBuffer();
$modulename	= "Recomendado de la semana";
$recomendado_id	= numParam('id');
$title		= $recomendado_id > 0 ? "Modificar" : "Nuevo";
$data		= Recomendados::select($recomendado_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Recomendados::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['recomendado_status'] = $_POST['recomendado_status'] == NULL ? 1 : $_POST['recomendado_status'];
endif;
$callback	= array(
	"success"	=> "recomendados.view.php",
	"error"		=> "recomendados.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('recomendados&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('recomendados&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('recomendados&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="recomendados_form" name="recomendados_form" method="post" autocomplete="off" onsubmit="savedata('recomendados');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['producto_id']) ? " error" : "";?>">
					<label class="control-label" for="producto_id">Producto</label>
					<div class="controls">
						<?
							echo Productos::comboRecomendado($_POST['producto_id']);
						?>
						
						<?php
						if(isset($error['producto_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['recomendado_fechacreado']) ? " error" : "";?>">
					<label class="control-label" for="recomendado_fechacreado">Fecha Inicio promoción</label>
					<div class="controls">
						<input class="" id="recomendado_fechacreado" name="recomendado_fechacreado" value="<?php echo htmlspecialchars($_POST['recomendado_fechacreado']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['recomendado_fechacreado'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['recomendado_fechacreado'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>


				<div class="control-group<?php echo isset($error['recomendado_fechafin']) ? " error" : "";?>">
					<label class="control-label" for="recomendado_fechafin">Fecha Fin</label>
					<div class="controls">
						<input class="" id="recomendado_fechafin" name="recomendado_fechafin" value="<?php echo htmlspecialchars($_POST['recomendado_fechafin']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['recomendado_fechafin'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['recomendado_fechafin'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['recomendado_status']) ? " error" : "";?>">
					<label class="control-label" for="recomendado_status">Activo</label>
					<div class="controls">

						<input class="" id="recomendado_status" name="recomendado_status" value="1" type="checkbox"<?php if($_POST['recomendado_status'] == 1){?> checked="checked"<?php } ?> />
						<?php
						if(isset($error['recomendado_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['recomendado_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $recomendado_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Recomendados::save(".$recomendado_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('recomendados&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	    $('#recomendado_fechacreado').datepicker({
	            pickTime: false,
	            language:'es',
	    });

	    $('#recomendado_fechafin').datepicker({
	            pickTime: false,
	            language:'es',
	    });
	});

</script>
