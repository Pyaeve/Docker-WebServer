<?php
clearBuffer();
$modulename	= "sucursales";
$sucursal_id	= numParam('id');
$title		= $sucursal_id > 0 ? "Modificar" : "Nuevo";
$data		= Sucursales::select($sucursal_id);

if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Sucursales::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['sucursal_status'] = $_POST['sucursal_status'] == NULL ? 1 : $_POST['sucursal_status'];
endif;
$callback	= array(
	"success"	=> "sucursales.view.php",
	"error"		=> "sucursales.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('sucursales&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons more_items" style="width:50% !important;"><i></i><a href="" onclick="module('sucursales&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('sucursales&page=<?php echo pageNumber();?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="sucursales_form" name="sucursales_form" method="post" autocomplete="off" onsubmit="savedata('sucursales');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;overflow-y: scroll;height: 700px;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">
				<div class="control-group<?php echo isset($error['sucursal_nombre']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_nombre">Nombre</label>
					<div class="controls">
						<input class="" id="sucursal_nombre" name="sucursal_nombre" value="<?php echo htmlspecialchars($_POST['sucursal_nombre']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['sucursal_nombre'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_nombre'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
				
				<div class="control-group<?php echo isset($error['sucursal_codigo']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_codigo">Codigo de sucursal</label>
					<div class="controls">
						<input class="" id="sucursal_codigo" name="sucursal_codigo" value="<?php echo htmlspecialchars($_POST['sucursal_codigo']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['sucursal_codigo'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_codigo'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['sucursal_direccion']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_direccion">Direccion</label>
					<div class="controls">
						<input class="" id="sucursal_direccion" name="sucursal_direccion" value="<?php echo htmlspecialchars($_POST['sucursal_direccion']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['sucursal_direccion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_direccion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['departamento_id']) ? " error" : "";?>">
					<label class="control-label" for="depa">Departamento</label>
					<div class="controls">
						<?	echo Departamentos::combobox($_POST['departamento_id']);	?>
						<?php
						if(isset($error['departamento_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['departamento_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['ciudad_id']) ? " error" : "";?>">
					<label class="control-label" for="ciudad_id">Ciudad</label>
					<div class="controls">
						<div id="city">
							<? 
							if($_POST['ciudad_id'] > 0){
								echo Ciudad::combobox($_POST['ciudad_id']);
							}else{ ?>
	 							<select name="ciudad_id" id="ciudad_id" class="form-control">
	                                <option value="">Selecciona Ciudad</option>
	                            </select>
                        	<?	}?>
                         </div>					
						<?php
						if(isset($error['ciudad_id'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['ciudad_id'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>



<!--  -->
	<div class="control-group<?php echo isset($error['sucursal_horarios']) ? " error" : "";?>">
		<label class="control-label" for="sucursal_horarios">Horarios</label>
		<div class="controls">
			<div class="datocontent">
				<?	
					$datos = json_decode($_POST['sucursal_horarios']); //Propiedad_detalles::get("propiedad_id = ".$_POST['propiedad_id']);

					if(haveRows($datos)):
						$r=NULL;					
						foreach ($datos as $key => $rs):
							?>
						<input class="dato" id="dato_info<?=$r?>" value="<?=$rs?>" name="dato_info[]" type="text" style="color:#000;" />
						<p class='r'></p>
							<?
						$r++;
						endforeach;
					else:
				?>
							<input class="dato" id="dato_info" name="dato_info[]" type="text" style="color:#000;" />
							<p class='r'></p>
				<?
					endif;
				?>
			</div>

			<a href="javascript:;" onclick="camposdato('add')">[+] A&ntilde;adir campo</a>
			<a href="javascript:;" onclick="camposdato('remove')">[-] Remover campo</a>
			<p>Para eliminar un campo simplemente debe vaciar el campo que desea eliminar y guardarlo</p>
			<?php
			if(isset($error['sucursal_horarios'])):
			?>
			<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_horarios'];?></span></p>
			<?php
			endif;
			?>
		</div>
	</div>

	<div class="control-group<?php echo isset($error['sucursal_tel']) ? " error" : "";?>">
		<label class="control-label" for="sucursal_tel">Telefonos</label>
		<div class="controls">
			<div class="datocontenttel">
				<?	
					$datostel = json_decode($_POST['sucursal_tel']); //Propiedad_detalles::get("propiedad_id = ".$_POST['propiedad_id']);

					if(haveRows($datostel)):
						$r=NULL;					
						foreach ($datostel as $key => $rs):
							?>
						<input class="datotel" id="dato_infotel<?=$r?>" value="<?=$rs?>" name="dato_infotel[]" type="text" style="color:#000;" />
						<p class='r'></p>
							<?
						$r++;
						endforeach;
					else:
				?>
							<input class="datotel" id="dato_infotel" name="dato_infotel[]" type="text" style="color:#000;" />
							<p class='r'></p>
				<?
					endif;
				?>
			</div>

			<a href="javascript:;" onclick="camposdatotel('add')">[+] A&ntilde;adir campo</a>
			<a href="javascript:;" onclick="camposdatotel('remove')">[-] Remover campo</a>
			<p>Para eliminar un campo simplemente debe vaciar el campo que desea eliminar y guardarlo</p>
			<?php
			if(isset($error['sucursal_tel'])):
			?>
			<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_tel'];?></span></p>
			<?php
			endif;
			?>
		</div>
	</div>

	<div class="control-group<?php echo isset($error['sucursal_email']) ? " error" : "";?>">
		<label class="control-label" for="sucursal_email">Email</label>
		<div class="controls">
			<div class="datocontentemail">
				<?	
					$datosemail = json_decode($_POST['sucursal_email']); //Propiedad_detalles::get("propiedad_id = ".$_POST['propiedad_id']);

					if(haveRows($datosemail)):
						$r=NULL;					
						foreach ($datosemail as $key => $rs):
							?>
						<input class="datoemail" id="dato_infoemail<?=$r?>" value="<?=$rs?>" name="dato_infoemail[]" type="text" style="color:#000;" />
						<p class='r'></p>
							<?
						$r++;
						endforeach;
					else:
				?>
							<input class="datoemail" id="dato_infoemail" name="dato_infoemail[]" type="text" style="color:#000;" />
							<p class='r'></p>
				<?
					endif;
				?>
			</div>

			<a href="javascript:;" onclick="camposdatoemail('add')">[+] A&ntilde;adir campo</a>
			<a href="javascript:;" onclick="camposdatoemail('remove')">[-] Remover campo</a>
			<p>Para eliminar un campo simplemente debe vaciar el campo que desea eliminar y guardarlo</p>
			<?php
			if(isset($error['sucursal_email'])):
			?>
			<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_email'];?></span></p>
			<?php
			endif;
			?>
		</div>
	</div>
<!--  -->

				<div class="control-group<?php echo isset($error['sucursal_ubicacion']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_ubicacion">Mapa</label>
					<div class="controls">
						<div style="margin-bottom:5px;">
								                        <a class="btn-action glyphicons pin btn-primary" onclick="placeMarker();" title="Marcar ubicaci��n"><i></i></a>
								                        <a class="divider"></a>
								                        <a class="btn-action glyphicons move btn-primary" onclick="" title="Mover"><i></i></a>
									                </div>
									                <div id="mapcanvas" style="width: 800px; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
									                <input class="LatLng" id="sucursal_ubicacion" name="sucursal_ubicacion" value="<?php echo htmlspecialchars($_POST['sucursal_ubicacion']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['sucursal_ubicacion'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_ubicacion'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

				<div class="control-group<?php echo isset($error['sucursal_status']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_status">Activo</label>
					<div class="controls">
						<input class="" id="sucursal_status" name="sucursal_status" value="1" type="checkbox"<?php if($_POST['sucursal_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['sucursal_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
	            <div class="control-group<?php echo isset($error['sucursal_delivery']) ? " error" : "";?>">
					<label class="control-label" for="sucursal_delivery">Delivery</label>
					<div class="controls">
						<input class="" id="sucursal_delivery" name="sucursal_delivery" value="1" type="checkbox"<?php if($_POST['sucursal_delivery'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['sucursal_delivery'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['sucursal_delivery'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>
						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $sucursal_id;?>" />
			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Sucursales::save(".$sucursal_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button>
			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('sucursales&page=<?php echo pageNumber();?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>

<script src="js/mapcore.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
        $("select[id=departamentos_combo]").change(function(){
              var dept = $('select[id=departamentos_combo]').val();
               $.ajax({
                  url : 'js/data',
                  data: {id:dept,'accion':'ciudad'},
                  type : 'post',
                  dataType : 'json',
                  success : function(data){
                    if(data.status == "success"){
                        $('#city').html(data.html);
                    }
                  }
              });
              return false;
        });
	});

	$(function(){
	    initmap();
	});

	function camposdato(action){
		var total = $('.dato').length;

		if (action=='add') {
			$.ajax({
				url : 'js/datos',
              	data : {cantidad:total},
              	type : 'post',
              	dataType : 'json',
              	success : function(data){
              		console.log(data);
              		if(data.status = "success"){
              			$('.datocontent').append(data.content);
              		}
              	}
			});

		}else{
			//total[(total.length-1)].remove();
			var i = $('.dato').length;
			var resta = i - 1; 
			$('#dato_info'+resta).remove();
			
		}
	}

	function camposdatotel(action){
		var total = $('.datotel').length;

		if (action=='add') {
			$.ajax({
				url : 'js/datostel',
              	data : {cantidad:total},
              	type : 'post',
              	dataType : 'json',
              	success : function(data){
              		if(data.status = "success"){
              			$('.datocontenttel').append(data.content);
              		}
              	}
			});

		}else{
			//total[(total.length-1)].remove();
			var i = $('.datotel').length;
			var resta = i - 1; 
			$('#dato_infotel'+resta).remove();
			
		}
	}

	function camposdatoemail(action){
		var total = $('.datoemail').length;

		if (action=='add') {
			$.ajax({
				url : 'js/datosemail',
              	data : {cantidad:total},
              	type : 'post',
              	dataType : 'json',
              	success : function(data){
              		console.log(data);
              		if(data.status = "success"){
              			$('.datocontentemail').append(data.content);
              		}
              	}
			});

		}else{
			//total[(total.length-1)].remove();
			var i = $('.datoemail').length;
			var resta = i - 1; 
			$('#dato_infoemail'+resta).remove();
			
		}
	}


</script>
