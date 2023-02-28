<?php
$title = "Demandas Insatisfechas";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (demanda_insatisfecha_id = '{$search_num}')" : "";
$listing = new Listing();
$listing->pgclick("module('demandas_insatisfechas&page=%s');return!1;");
$listing = $listing->get("demandas_insatisfechas", 10, NULL, $page, "WHERE demanda_insatisfecha_id > 0 {$search} ORDER BY demanda_insatisfecha_id DESC");


?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons inbox" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('demandas_insatisfechas&query='+$('#squery').val());return!1;">
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
				<!--<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_zona_ecommerce" id="checkall_zona_ecommerce" value="1" /></th>-->
				<th style="width: 1%;" class="center">ID</th>
				<th class="center">Cedula</th>
				<th class="center">RUC</th>
				<th class="center">Cliente</th>
				<th class="center">Deposito</th>
				<th class="center">Codigo Producto</th>
				<th class="center">Cantidad</th>
				<th class="center">Fecha</th>



				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<!--td class="center uniformjs"><input type="checkbox" name="check_zona_ecommerce_<?php //echo $list['demanda_insatisfecha_id'];?>" value="<?php //echo $list['demanda_insatisfecha_id'];?>" /></td>-->
				<td class="center"><?php echo $list['demanda_insatisfecha_id'];?></td>
				<td class="center"><?php echo $list['cliente_cedula'];?></td>
				<td class="center"><?php echo $list['cliente_ruc'];?></td>
				<td class="center"><?php echo $list['cliente_nombre'].",".$list['cliente_apellido'];?></td>
				<td class="center"><?php echo $list['deposito_codigo'];?></td>
				<td class="center"><?php echo $list['producto_codigo'];?></td>
				<td class="center"><?php echo $list['cantidad'];?></td>
				<td class="center" style="width: 150px;"><?php echo date('d/m/Y H:i', strtotime($list['demanda_insatisfecha_timestamp']));?></td>
				
					
					
				</td>
			</tr>
		<?php
		endforeach;
		?>
		</tbody>
	</table>
	<div class="pagination pull-right" style="margin: 0;">
		<?php echo $listing['navigation'];?>
	</div>
	<div class="clearfix"></div>	
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