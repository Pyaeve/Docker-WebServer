<?php
$title = "Imagenes";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
//----------------------
$producto_id = numParam('producto_id');
$pagina = numParam('pagina');
$productos = Productos::select($producto_id);
$producto = $productos['0'];
$title = "Imagenes > ".$producto['producto_nombre'];
//----------------------

$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (imagen_id = '{$search_num}' OR CONCAT_WS(' ', producto_id) LIKE '%{$search}%')" : "";
$listing = new Listing();

$listing->pgclick("module('imagenes_productos&page=%s&producto_id={$producto_id}');return!1;");
$listing = $listing->get("imagenes_productos", 20, NULL, $page, "WHERE producto_id = '{$producto_id}' AND imagen_hidden = 0 {$search} ORDER BY imagen_id DESC");

$permissionInsert = permissionInsert('imagenes_productos');
$permissionUpdate = permissionUpdate('imagenes_productos');
$permissionDelete = permissionDelete('imagenes_productos');
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons picture" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	<?php if($permissionInsert):?>

	<div class="buttons pull-right">
		<a href="" class="btn btn-success btn-icon glyphicons circle_arrow_left" onclick="module('productos','0&page=<?php echo $page;?>&producto_id=<?php echo $producto_id; ?>&page=<?=$pagina?>');return!1;"><i></i>Volver</a>
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('imagenes_productos','0&page=<?php echo $page;?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif;?>
	
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('imagenes_productos&query='+$('#squery').val());return!1;">
<div class="input-append">
	<input class="span6" id="squery" name="query" type="text" value="<?php echo htmlspecialchars(param('query'));?>" placeholder="Buscar..." />
	<button class="btn" type="submit"><i class="icon-search"></i></button>
</div>
</form>
<?php
if(is_array($listing['list']) && count($listing['list']) > 0):
?>
	<table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
		<thead>
			<tr>
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_imagenes_productos" id="checkall_imagenes_productos" value="1" /></th>
				<th style="width: 1%;" class="center">ID</th>
				<th>Imagen</th>

				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_imagenes_productos_<?php echo $list['imagen_id'];?>" value="<?php echo $list['imagen_id'];?>" /></td>
				<td class="center"><?php echo $list['imagen_id'];?></td>
				<td><img src="<?php echo $list['imagen_image_small_url'];?>" width="120"></td>

				<td class="center" style="width: 150px;"><?php echo date('d/m/Y H:i', strtotime($list['imagen_timestamp']));?></td>
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['imagen_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['imagen_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 120px;">
						<a href="" class="btn-action glyphicons scissors btn-primary" onclick="module('crop&module=imagenes_productos&image_id=<?php echo $list['imagen_id'];?>&image_big_url=<?php echo $list['imagen_image_big_url'];?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i></a>
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('imagenes_productos','<?php echo $list['imagen_id'];?>&page=<?php echo $page;?>&producto_id=<?php echo $producto_id; ?>&pagina=<?=$pagina?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'imagenes_productos','id':'<?php echo $list['imagen_id'];?>','callback':'view','producto_id':'<?php echo $producto_id; ?>','pagina':'<?=$pagina?>'});return!1;"><i></i></a>
					<?php endif;?>
				</td>
			</tr>
		<?php
		endforeach;
		?>
		</tbody>
	</table>
	<div class="separator top form-inline small">
		<div class="pull-left checkboxs_actions hide">
			<div class="row-fluid">
				<select style="color:#000;" onchange="checkedAction('imagenes_productos',this);">
					<option value="0">Seleccionados</option>
					<?php if($permissionUpdate): ?>
					<option value="1">Activar</option>
					<option value="2">Desactivar</option>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<option value="3">Eliminar</option>
					<?php endif;?>
				</select>
			</div>
		</div>
		<div class="pagination pull-right" style="margin: 0;">
			<?php echo $listing['navigation'];?>
		</div>
		<div class="clearfix"></div>
	</div>
<?php
else:
?>
<div class="alert alert-info">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Sin datos</strong> No se encontraron registros</div>
<?php
endif;
?>
</div>
<br/>
<!-- End Content --> 