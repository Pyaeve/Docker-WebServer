<?php
$title = "Pedidos";
$page	 = pageNumber();
$search	 = addslashes(param('query'));
$search_num	 = number($search);
$search	 = strlen(trim($search)) > 0 ? " AND (contraentrega_id = '{$search_num}' OR CONCAT_WS(' ', cliente_nombres) LIKE '%{$search}%')" : "";

$listing = new Listing();
$listing->pgclick("module('contraentrega&page=%s');return!1;");
$listing = $listing->get("contraentrega", 10, NULL, $page, "WHERE contraentrega_hidden = 0 {$search} ORDER BY contraentrega_id DESC");

$permissionInsert = permissionInsert('contraentrega');
$permissionUpdate = permissionUpdate('contraentrega');
$permissionDelete = permissionDelete('contraentrega');
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title;?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons" style="overflow:hidden;">
	<h3 class="glyphicons shopping_bag" style="display:inline-block !important; float:left !important;"><i></i> <?php echo $title;?></h3>
	<?php /*if($permissionInsert):?>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_plus" onclick="create('contraentrega','0&page=<?php echo $page;?>');return!1;"><i></i>Nuevo</a>
	</div>
	<?php endif;*/?>
	
</div>
<div class="separator"></div>
<div class="innerLR">
<form name="searchform" id="searchform" method="get" onsubmit="module('contraentrega&query='+$('#squery').val());return!1;">
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
				<th style="width: 1%;" class="uniformjs"><input type="checkbox" name="checkall_contraentrega" id="checkall_contraentrega" value="1" /></th>
				<th style="width: 1%;" class="center">ID</th>
				<th class="center">Cliente</th>
				<th class="center">Productos</th>
				<th class="center">Metodo Entrega</th>
                <th class="center">Metodo de Pago</th>
    
				<th class="right" colspan="3">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		<?php
		foreach($listing['list'] as $list):
		?>
			<tr class="selectable">
				<td class="center uniformjs"><input type="checkbox" name="check_contraentrega_<?php echo $list['contraentrega_id'];?>" value="<?php echo $list['contraentrega_id'];?>" /></td>
				<td class="center"><?php echo $list['contraentrega_id'];?></td>
				<td class="center">
					<?php echo $list['cliente_id']." = ".$list['cliente_nombres'];?>
				</td>
				<td class="center">
					<a href="" onclick="module('contraentrega_detalle&contraentrega_id=<?php echo $list['contraentrega_id']; ?>');return!1;"><i></i><span>Lista de productos</span></a>
				</td>
				<td class="center">
				    <?php echo $list['contraentrega_delivery'] == 1 ? "Delivery" : "Retiro de sucursal"; ?>
				</td>
	            <td class="center">
				    <?php 
				        switch ($list['contraentrega_formapago']) {
                        	case '1':
                        	    echo "Contraentrega";
                        	break;
                        	case '2':
                        	    echo "Tarjeta credito";
                        	break;
                        	case '3':
                        	    echo "Zimple";
                        	break;
							case '4':
                        	    echo "Credito farmacia";
                        	break;
							case '5':
                        	    echo "Token tarjeta credito";
                        	break;
                        }
						//echo $list['contraentrega_formapago'];

				    ?>
				</td>
				<td class="hidden" value="<?php echo $list['body_raw'];?>"><?php echo $list['body_raw'];?></td>
				<td class="center" style="width: 150px;"><?php echo date('d/m/Y H:i', strtotime($list['contraentrega_timestamp']));?></td>
				<td class="center" style="width: 80px;">
				    <!--<span class="label label-block label-<?php //echo $list['contraentrega_status'] == 1 ? "important" : "inverse";?>"><?php //echo $list['contraentrega_status'] == 1 ? "Activo" : "Inactivo";?></span>-->
				    <?php 
				        switch ($list['contraentrega_status']) { 
				            case '1':
                        	    echo '<a href="" class="btn btn-primary"><i></i>Pendiente</a>';
                        	break;
                        	case '2':
                        	    echo '<a href="" class="btn btn-success"><i></i>Pagado</a>';
                        	break;
                        	case '3':
                        	    echo '<a href="" class="btn btn-danger"><i></i>Anulado</a>';
                        	break;
				        }
				    ?>
				    
				</td>
				<td class="center" style="width: 120px;">
					<!--<a href="" class="btn-action glyphicons folder_open btn-primary" onclick="viewModal('contraentrega','<?php// echo $list['contraentrega_id'];?>');return!1;"><i></i></a>-->
					<?php if($permissionUpdate): ?>
					<a href="" class="btn-action glyphicons pencil btn-success" onclick="create('contraentrega','<?php echo $list['contraentrega_id'];?>&page=<?php echo $page;?>');return!1;"><i></i></a>
					<?php endif;?>
					<?php /*if($permissionDelete): ?>
					<a href="" class="btn-action glyphicons remove_2 btn-danger" onclick="removeit({'option':'contraentrega','id':'<?php echo $list['contraentrega_id'];?>','callback':'view'});return!1;"><i></i></a>
					<?php endif;*/?>
					
				
					<a href="reconfirmacion__ajax.php?id=<?php echo $list['contraentrega_id'];?>" class="btn-action glyphicons refresh btn-danger"><i></i></a>
				
					
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
				<select style="color:#000;" onchange="checkedAction('contraentrega',this);">
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
<script>
	
		
	
	
		/*$.ajax({
			type: "POST",
			url: "/reconfirmacion_ajax.php",
			data: {json:json},
			dataType: "json",
			success: function(data){
				console.log(data);
				if(data.status == 'success'){
					swal({
					title: "Proceso correcto",
					text: "Pedido enviado!",
					type: "success"
					},function(){
					//location.href='_sys/lib/view/contraentrega.view.php'; 
					});
				}else{
					//swal("Atencion", data.description, "warning");
					swal({
					title: "Atencion",
					text: data.description,
					type: "warning"
					},function(){
					//location.href='../backend/dashboard/'; 
					//location.href='../index.php'; 
					});
				}
			}
		});*/
           


</script>