<?php
$title = "Banners";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (banner_id = '{$search_num}')" : "";
$listing = new Listing();
$listing->pgclick("module('banners&page=%s');return!1;");
$listing = $listing->get("banners", 10, NULL, $page, "WHERE banner_hidden = 0 {$search} ORDER BY banner_orden ASC");

$permissionInsert = permissionInsert('banners');
$permissionUpdate = permissionUpdate('banners');
$permissionDelete = permissionDelete('banners');
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
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('banners','0&page=<?php echo $page;?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif;?>
	
</div>
<div class="separator"></div>
<div class="innerLR" style="padding-bottom: 20px;margin: 0;overflow-y: scroll;height: 700px;">
<form name="searchform" id="searchform" method="get" onsubmit="module('banners&query='+$('#squery').val());return!1;">
<div class="input-append">
	<input class="span6" id="squery" name="query" type="text" value="<?php echo htmlspecialchars(param('query'));?>" placeholder="Buscar..." />
	<button class="btn" type="submit"><i class="icon-search"></i></button>
</div>
</form>
<?php
if(is_array($listing['list']) && count($listing['list']) > 0):
?>
	<div class="pagination pull-right" style="margin: 0;">
		<?php echo $listing['navigation'];?>
	</div>
	<table class="table table-bordered table-condensed table-striped table-vertical-center checkboxs js-table-sortable">
		<thead>
			<tr>
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_banners" id="checkall_banners" value="1" /></th>
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
				<td class="center uniformjs"><input type="checkbox" name="check_banners_<?php echo $list['banner_id'];?>" value="<?php echo $list['banner_id'];?>" /></td>
				<td class="center"><?php echo $list['banner_id'];?></td>
				<td><img src="<?php echo $list['banner_image_small_url'];?>"></td>

				<td class="center" style="width: 150px;"><?php echo date('d/m/Y H:i', strtotime($list['banner_timestamp']));?></td>
				<td class="center" style="width: 80px;"><span class="label label-block label-<?php echo $list['banner_status'] == 1 ? "important" : "inverse";?>"><?php echo $list['banner_status'] == 1 ? "Activo" : "Inactivo";?></span></td>
				<td class="center" style="width: 120px;">
					<a href="" class="btn-action glyphicons scissors btn-primary" onclick="module('crop&module=banners&image_id=<?php echo $list['banner_id'];?>&image_big_url=<?php echo $list['banner_image_big_url'];?>');return!1;"><i></i></a>
					
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('banners','<?php echo $list['banner_id'];?>&page=<?php echo $page;?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'banners','id':'<?php echo $list['banner_id'];?>','callback':'view'});return!1;"><i></i></a>
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
				<select style="color:#000;" onchange="checkedAction('banners',this);">
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