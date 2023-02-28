<?php
clearBuffer();
$oferta_id	= numParam('id');
$oferta_tipo = numParam('oferta_tipo');
switch ($oferta_tipo) {
	case '1':
	default:
		$modulename = "Promociones";
	break;
	case '2':
		$modulename = "Recomendados de la semana";
	break;
	case '3':
		$modulename = "Mejores productos";
	break;
}
$title		= $oferta_id > 0 ? "Modificar" : "Nuevo";
$data		= Productos_ofertas::select($oferta_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Productos_ofertas::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['oferta_status'] = $_POST['oferta_status'] == NULL ? 1 : $_POST['oferta_status'];
endif;
$callback	= array(
	"success"	=> "productos_ofertas.view.php",
	"error"		=> "productos_ofertas.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('productos_ofertas&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('productos_ofertas&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('productos_ofertas&page=<?php echo pageNumber();?>&oferta_tipo=<?=$oferta_tipo?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="productos_ofertas_form" name="productos_ofertas_form" method="post" autocomplete="off" onsubmit="savedata('productos_ofertas');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['producto_id']) ? " error" : "";?>">
					<label class="control-label" for="producto_id">Producto</label>
					<div class="controls">
						<?php Productos::comboRecomendado($_POST['producto_id']);?>

						
						<?php
						if(isset($error['producto_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['producto_codigo']) ? " error" : "";?>">
					<label class="control-label" for="producto_codigo">Codigo producto</label>
					<div class="controls">
						<input class="" id="producto_codigo" name="producto_codigo" value="<?php echo htmlspecialchars($_POST['producto_codigo']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['producto_codigo'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['producto_codigo'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<?	if($oferta_tipo == '1'):?>
					<div class="control-group<?php echo isset($error['oferta_depo_codigo']) ? " error" : "";?>">
						<label class="control-label" for="oferta_depo_codigo">DEPO_CODIGO</label>
						<div class="controls">
							<input class="" id="oferta_depo_codigo" name="oferta_depo_codigo" value="<?php echo htmlspecialchars($_POST['oferta_depo_codigo']);?>" type="text" style="color:#000;" />
							
							<?php
							if(isset($error['oferta_depo_codigo'])):
							?>
							<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_depo_codigo'];?></span></p>
							<?php
							endif;
							?>
						</div>
					</div>

					<div class="control-group<?php echo isset($error['oferta_ecommerceempre_code']) ? " error" : "";?>">
						<label class="control-label" for="oferta_ecommerceempre_code">ESPECIALES_ECOMMERCEEMPR_CODIG</label>
						<div class="controls">
							<input class="" id="oferta_ecommerceempre_code" name="oferta_ecommerceempre_code" value="<?php echo htmlspecialchars($_POST['oferta_ecommerceempre_code']);?>" type="text" style="color:#000;" />
							
							<?php
							if(isset($error['oferta_ecommerceempre_code'])):
							?>
							<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_ecommerceempre_code'];?></span></p>
							<?php
							endif;
							?>
						</div>
					</div>
					
					<div class="control-group<?php echo isset($error['oferta_ecommerceprod_code']) ? " error" : "";?>">
						<label class="control-label" for="oferta_ecommerceprod_code">ESPECIALES_ECOMMERCEPROD_CODIG</label>
						<div class="controls">
							<input class="" id="oferta_ecommerceprod_code" name="oferta_ecommerceprod_code" value="<?php echo htmlspecialchars($_POST['oferta_ecommerceprod_code']);?>" type="text" style="color:#000;" />
							
							<?php
							if(isset($error['oferta_ecommerceprod_code'])):
							?>
							<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_ecommerceprod_code'];?></span></p>
							<?php
							endif;
							?>
						</div>
					</div>
				<?  endif;	?>

				<div class="control-group<?php echo isset($error['oferta_precio']) ? " error" : "";?>">
					<label class="control-label" for="oferta_precio">Precio </label>
					<div class="controls">
						<input class="" id="oferta_precio" name="oferta_precio" value="<?php echo htmlspecialchars($_POST['oferta_precio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['oferta_precio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_precio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>


				<div class="control-group<?php echo isset($error['oferta_inicio']) ? " error" : "";?>">
					<label class="control-label" for="oferta_inicio">Fecha inicio</label>
					<div class="controls">
						<input class="" id="oferta_inicio" name="oferta_inicio" value="<?php echo htmlspecialchars($_POST['oferta_inicio']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['oferta_inicio'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_inicio'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['oferta_fin']) ? " error" : "";?>">
					<label class="control-label" for="oferta_fin">Fecha fin</label>
					<div class="controls">
						<input class="" id="oferta_fin" name="oferta_fin" value="<?php echo htmlspecialchars($_POST['oferta_fin']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['oferta_fin'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_fin'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['oferta_status']) ? " error" : "";?>">
					<label class="control-label" for="oferta_status">Activo</label>
					<div class="controls">

						<input class="" id="oferta_status" name="oferta_status" value="1" type="checkbox"<?php if($_POST['oferta_status'] == 1){?> checked="checked"<?php } ?> />
						<?php
						if(isset($error['oferta_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['oferta_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $oferta_id;?>" />
			<input type="hidden" name="oferta_tipo" value="<?php echo $oferta_tipo;?>" />

			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Productos_ofertas::save(".$oferta_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('productos_ofertas&page=<?php echo pageNumber();?>&oferta_tipo=<?=$oferta_tipo?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>


<script type="text/javascript">
	$(document).ready(function () {
	    $('#oferta_inicio').datepicker({
	            pickTime: false,
	            language:'es',
	    });

	    $('#oferta_fin').datepicker({
	            pickTime: false,
	            language:'es',
	    });
	});

</script>
