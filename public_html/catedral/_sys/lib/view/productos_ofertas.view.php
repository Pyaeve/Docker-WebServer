<?php
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$oferta_tipo = numParam('oferta_tipo');
switch ($oferta_tipo) {
	case '1':
	default:
		$title = "Promociones";
	break;
	case '2':
		$title = "Recomendados de la semana";
	break;
	case '3':
		$title = "Mejores productos";
	break;
}


$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (oferta_id = '{$search_num}')" : "";
$listing = new Listing();
$listing->pgclick("module('productos_ofertas&page=%s&oferta_tipo={$oferta_tipo}');return!1;");
$listing = $listing->get("productos_ofertas", 20, NULL, $page, "WHERE oferta_tipo = {$oferta_tipo} AND oferta_hidden = 0 {$search} ORDER BY oferta_id DESC");

$permissionInsert = permissionInsert('productos_ofertas');
$permissionUpdate = permissionUpdate('productos_ofertas');
$permissionDelete = permissionDelete('productos_ofertas');
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons globe" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	<?php if($permissionInsert):?>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('productos_ofertas','0&page=<?php echo $page;?>&oferta_tipo=<?=$oferta_tipo?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif;?>
	
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('productos_ofertas&query='+$('#squery').val());return!1;">
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
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_productos_ofertas" id="checkall_productos_ofertas" value="1" /></th>
				<th style="width: 1%;" class="center">ID</th>
				<th class="center">Productos</th>


				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_productos_ofertas_<?php echo $list['oferta_id'];?>" value="<?php echo $list['oferta_id'];?>" /></td>
				<td class="center"><?php echo $list['oferta_id'];?></td>
				<td class="center">
					<?php 
						$producto = Productos::select($list['producto_id']);
						echo $producto[0]['producto_nombre'];
					?>
						
				</td>


				<td class="center" style="width: 150px;"><?php echo date('d/m/Y H:i', strtotime($list['oferta_timestamp']));?></td>
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['oferta_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['oferta_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 120px;">
					
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('productos_ofertas','<?php echo $list['oferta_id'];?>&page=<?php echo $page;?>&oferta_tipo=<?=$oferta_tipo?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'productos_ofertas','id':'<?php echo $list['oferta_id'];?>','callback':'view','oferta_tipo':'<?=$oferta_tipo?>'});return!1;"><i></i></a>
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
				<select style="color:#000;" onchange="checkedAction('productos_ofertas',this);">
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