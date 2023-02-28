<?php
clearBuffer();
$modulename	= "Imagenes";
$imagen_id	= numParam('id');
$producto_id = numParam('producto_id');
$producto_codigo = param('producto_codigo');
$pagina = numParam('pagina');


$productos = Productos::select($producto_id);
$producto = $productos['0'];
$producto_title = " > ".$producto['producto_nombre'];


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
<style>
	input{ width: 100%; }
	.oculto{ display: none; }
</style>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title.$producto_title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id; ?>');return!1;">
		<?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title.$producto_title;?></h3>
	<!-- <div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('imagenes_productos&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>&producto_codigo=<?=$producto_codigo?>');return!1;"><i></i>Volver</a>
	</div> -->
</div>
<div class="separator"></div>
<form id="pluploadForm">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">

				<div id="pluploadUploader">
					<p>Su navegador no tiene instalado el complemento, Silverlight, Gears, BrowserPlus o no soporta HTML5.</p>
				</div>

		</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $imagen_id;?>" />
			<input type="hidden" name="imagen_status" value="1" />
			<input type="hidden" name="producto_id" value="<?php echo $producto_id; ?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Imagenes_productos::savefiles(".$imagen_id.")");?>" />
			<input type="hidden" name="option" value="imagenes_productos" id="option" />
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />

			<button type="button" class="btn btn-icon btn-danger glyphicons ok" style='margin-top:20px;' onclick="module('imagenes_productos_multi&page=<?php echo pageNumber();?>&producto_id=<?php echo $producto_id;?>');return!1;"><i></i>Finalizar</button>
		</div>
	</div>
			
</form>
<iframe name="upload_frame" id="upload_frame" style="border:none;width:10px; height:10px;"></iframe>
<script type="text/javascript">
	$(document).ready(function () {
		$('#pluploadForm input[type="radio"]').click(function(){
			$('#pluploadForm input[type="radio"]').attr('checked',false);
			$(this).attr('checked',true);
		})

	});

</script>