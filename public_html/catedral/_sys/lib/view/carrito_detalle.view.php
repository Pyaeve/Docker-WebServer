<?php
$title = "Carrito_detalle";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$carrito_id = numParam('carrito_id');
$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (detalle_id = '{$search_num}')" : "";
$listing = new Listing();
$listing->pgclick("module('carrito_detalle&page=%s');return!1;");
$listing = $listing->get("carrito_detalle", 10, NULL, $page, "WHERE carrito_id = {$carrito_id} AND detalle_hidden = 0 {$search} ORDER BY detalle_id DESC");

$permissionInsert = permissionInsert('carrito_detalle');
$permissionUpdate = permissionUpdate('carrito_detalle');
$permissionDelete = permissionDelete('carrito_detalle');
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<!--<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons globe" style="display:inline-block !important; float:left !important;"><i></i> <?php //echo $title;?></h3>
	<?php /*if($permissionInsert):?>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('carrito_detalle','0&page=<?php echo $page;?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif*/;?>
	
</div>-->
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons shopping_bag" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	<?php if($permissionInsert):?>
	<div class="buttons pull-right">
		<a href="" class="btn btn-success btn-icon glyphicons circle_arrow_left" onclick="module('carrito');return!1;"><i></i>Volver</a>
	</div>
	<?php endif;?>
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('carrito_detalle&query='+$('#squery').val());return!1;">
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
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_carrito_detalle" id="checkall_carrito_detalle" value="1" /></th>
				<th style="width: 15%;" class="center">ID</th>
				<th style="width: 15%;" class="center">Producto</th>
				<th style="width: 15%;" class="center">Precio</th>
				<th style="width: 15%;" class="center">Cantidad</th>
				<th style="width: 15%;" class="center">Estado</th>

				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_carrito_detalle_<?php echo $list['detalle_id'];?>" value="<?php echo $list['detalle_id'];?>" /></td>
				<td class="center"><?php echo $list['detalle_id'];?></td>
				<td class="center"><?php echo $list['producto_nombre'];?></td>
				<td class="center"><?php echo $list['producto_precio'];?></td>
				<td class="center"><?php echo $list['detalle_cantidad'];?></td>

				<!--<td class="center" style="width: 150px;"><?php /*echo date('d/m/Y H:i', strtotime($list['detalle_timestamp']));*/?></td>-->
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['detalle_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['detalle_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 120px;">
					<a href="" class="btn-action glyphicons folder_open btn-primary" onclick="viewModal('carrito_detalle','<?php echo $list['detalle_id'];?>');return!1;"><i></i></a>
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('carrito_detalle','<?php echo $list['detalle_id'];?>&page=<?php echo $page;?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'carrito_detalle','id':'<?php echo $list['detalle_id'];?>','callback':'view'});return!1;"><i></i></a>
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
				<select style="color:#000;" onchange="checkedAction('carrito_detalle',this);">
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