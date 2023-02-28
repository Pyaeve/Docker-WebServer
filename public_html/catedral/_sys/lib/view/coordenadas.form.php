<?php
clearBuffer();
$modulename	= "Coordenadas";

$coordenada_id	= numParam('id');
$zona_id	= numParam('zona_id');

$ecommerce = Zona_ecommerce::select($zona_id);
$modulename.= " ".$ecommerce[0]['zona_nombre'];

$title		= $coordenada_id > 0 ? "Modificar" : "Nuevo";
$data		= Coordenadas::select($coordenada_id);

$view_coordenada = Coordenadas::get("zona_id = ".$zona_id);
#Zona 0 (epicentro)
$zonas = Zona_ecommerce::select($zona_id);
$cordenadas = explode(",", $zonas[0]['zona_mapa']);


if(is_array($data) && count($data) > 0 && empty($_POST)):
	$_POST = $data[0];
else:
	$fields = Coordenadas::getfields();
	foreach($fields as $k => $v):
		if(isset($_POST[$k])):
			$value = empty($_POST[$k]) ? NULL : $_POST[$k];
		else:
			$value = NULL;
		endif;
		$_POST[$k] = $value;
	endforeach;
	$_POST['coordenada_status'] = $_POST['coordenada_status'] == NULL ? 1 : $_POST['coordenada_status'];
endif;
$callback	= array(
	"success"	=> "coordenadas.view.php",
	"error"		=> "coordenadas.form.php"
);
?>
<ul class="breadcrumb">
	<li><a href="" class="glyphicons home" onclick="module('dashboard');return!1;"><i></i> <?php echo sysName;?></a></li>
	<li class="divider"></li>
	<li><a href="" onclick="module('coordenadas&page=<?php echo pageNumber();?>');return!1;"><?php echo $modulename;?></a></li>
	<li class="divider"></li>
	<li><?php echo $title; ?></li>
</ul>
<div class="separator"></div>
<div class="heading-buttons">
	<h3 class="glyphicons globe" style="width:50% !important;"><i></i><a href="" onclick="module('coordenadas&page=<?php echo pageNumber();?>');return!1;"><?php echo htmlspecialchars($modulename);?></a> &gt; <?php echo $title;?></h3>
	<div class="buttons pull-right">
		<a href="" class="btn btn-primary btn-icon glyphicons circle_arrow_left" onclick="module('coordenadas&page=<?php echo pageNumber();?>&zona_id=<?php echo $zona_id;?>');return!1;"><i></i>Volver</a>
	</div>
</div>
<div class="separator"></div>
<form class="form-horizontal" style="margin-bottom: 0;" id="coordenadas_form" name="coordenadas_form" method="post" autocomplete="off" onsubmit="savedata('coordenadas');return!1;">
	<div class="well" style="padding-bottom: 20px; margin: 0;">
		<h4>Informaci&oacute;n de <?php echo $modulename;?></h4>
		<?php Message::alert();?>
		<hr class="separator" />
		<div class="row-fluid">
		<div class="span6">

			<!-- 	<div class="control-group<?php//echo isset($error['coordenada_numero']) ? " error" : "";?>">
					<label class="control-label" for="coordenada_numero">coordenada_numero</label>
					<div class="controls">
						<input class="" id="coordenada_numero" name="coordenada_numero" value="<?php //echo htmlspecialchars($_POST['coordenada_numero']);?>" type="text" style="color:#000;" />
						
						<?php
						/*if(isset($error['coordenada_numero'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['coordenada_numero'];?></span></p>
						<?php
						endif;*/
						?>
					</div>
				</div> -->

				<div class="control-group<?php echo isset($error['coordenada_latitud']) ? " error" : "";?>">
					<label class="control-label" for="coordenada_latitud">Coordenada</label>
					<div class="controls">
						<div style="margin-bottom:5px;">
							<a class="btn-action glyphicons pin btn-primary" onclick="placeMarker();" title="Marcar ubicación"><i></i></a>
							<a class="divider"></a>
							<a class="btn-action glyphicons move btn-primary" onclick="" title="Mover"><i></i></a>
						</div>
						<div id="mapcanvas" style="width: 800px; height: 450px; margin-left:0; border:1px solid #ccc;"></div><br><br>
							<input class="LatLng" id="coordenada_latitud" name="coordenada_latitud" value="<?php echo htmlspecialchars($_POST['coordenada_latitud']);?>" type="text" style="color:#000;" />
						
						<?php
						if(isset($error['coordenada_latitud'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['coordenada_latitud'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>


				<div class="control-group<?php echo isset($error['coordenada_status']) ? " error" : "";?>">
					<label class="control-label" for="coordenada_status">Activo</label>
					<div class="controls">
						<input class="" id="coordenada_status" name="coordenada_status" value="1" type="checkbox"<?php if($_POST['coordenada_status'] == 1){?> checked="checked"<?php } ?> />
						
						<?php
						if(isset($error['coordenada_status'])):
						?>
						<p class="error help-block"><span class="label label-important"><?php echo $error['coordenada_status'];?></span></p>
						<?php
						endif;
						?>
					</div>
				</div>

						</div>
				</div>
		<hr class="separator" />
		<div class="form-actions">
			<input type="hidden" name="id" value="<?php echo $coordenada_id;?>" />
			<input type="hidden" name="zona_id" value="<?php echo $zona_id;?>" />

			<input type="hidden" name="page" value="<?php echo pageNumber();?>" />
			<input type="hidden" name="token" value="<?php echo token("Coordenadas::save(".$coordenada_id.")");?>" />
			
			<input type="hidden" name="callback" value="<?php echo token(json_encode($callback));?>" />
			<!-- <button type="submit" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</button> -->
			<a href="javascript:;" id="btn_guarda" class="btn btn-icon btn-primary glyphicons circle_ok"><i></i>Aceptar</a>

			<button type="button" class="btn btn-icon btn-default glyphicons circle_remove" onclick="module('coordenadas&page=<?php echo pageNumber();?>&zona_id=<?=$zona_id?>');return!1;"><i></i>Cancelar</button>
		</div>
	</div>
</form>
<!--<script src="js/mapcore.js"></script>-->
<script type="text/javascript">
		$('#btn_guarda').click(function(){
			if(poligono != null){
				var coordenadas = [];
				$.each(poligono.getPath().getArray(), function(indice, coordenada){
					coordenadas.push({
						'numero_coordenada': indice,
						'latitud': coordenada.lat(),
						'longitud': coordenada.lng()
					});
				});
				//console.log(coordenadas);
				$.ajax({
					type: 'POST',
					url: 'js/save_coordenada',
					data: {id : <?php echo $coordenada_id; ?>, 
						zona_id: <?php echo $zona_id; ?>,
						coordenadas: coordenadas,
					},
					dataType: 'json',
					success: function(data){
					 	if(data.status == "success"){
					 		module('zona_ecommerce&zona_id=<?php echo $zona_id; ?>');
					 	}	        
					}
				});

			}
		});

		USGSOverlay.prototype = new google.maps.OverlayView();

		function initialize() {
			var mapOptions = {
				zoom: 16,
				mapTypeControl: false,
				center: {lat: <?php echo $cordenadas[0] ? $cordenadas[0] : -25.264885; ?>, lng: <?php echo $cordenadas[1] ? $cordenadas[1] : -57.542627; ?>},
				mapTypeId: 'satellite',//google.maps.MapTypeId.ROADMAP,
			};
			mapa = new google.maps.Map(document.getElementById('mapcanvas'), mapOptions);
				//Coordenada inicial
				<?php if($cordlat1){ ?>
				var coordenadas = [
						['cordenada1',  <?=$cordlat2?>, <?=$cordlng2?>, 2],
						['cordenada2', <?=$cordlat1?>, <?=$cordlng1?>, 1]
				];
				EditMarker(coordenadas, mapa);

				<?php } ?>
			// Herramientas de dibujo
			drawingManager = new google.maps.drawing.DrawingManager({
				drawingMode: google.maps.drawing.OverlayType.POLYGON,
				drawingControl: true,
				drawingControlOptions: {
					position: google.maps.ControlPosition.TOP_CENTER,
					drawingModes: [
						google.maps.drawing.OverlayType.POLYGON
					]
				},
				polygonOptions: {
					strokeColor: '#3D3D00',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#FFFF47',
					fillOpacity: 0.35,
					editable: true
				}
			});
			
			drawingManager.setMap(mapa);
			
			google.maps.event.addListener(drawingManager, 'polygoncomplete', function (polygon) {
				
				var coordenadas = (polygon.getPath().getArray());
				if(coordenadas.length > 2){
					if(poligono != null)
						poligono.setMap(null);
					poligono = polygon;
				}else{
					polygon.setMap(null);
				}
			});

			var coordenadas_area_cobertura = [
			<?php
				foreach ($view_coordenada as $indice => $coordenada) {
					echo ($indice > 0) ? ',' : '';
					echo "new google.maps.LatLng({$coordenada['coordenada_latitud']}, {$coordenada['coordenada_longitud']})";
				}
			?>
			];

			poligono = new google.maps.Polygon({
			  paths: coordenadas_area_cobertura,
			  strokeColor: '#3D3D00',
			  strokeOpacity: 0.8,
			  strokeWeight: 2,
			  fillColor: '#FFFF47',
			  fillOpacity: 0.35,
			  editable: true
			});

			poligono.setMap(mapa);

		}
      	/** @constructor */
		function USGSOverlay(bounds, image, map) {
			this.bounds_ = bounds;
			this.image_ = image;
			this.map_ = map;
			this.div_ = null;
			this.setMap(map);
		}

		USGSOverlay.prototype.onAdd = function() {
			var div = document.createElement('div');
			div.style.borderStyle = 'none';
			div.style.borderWidth = '0px';
			div.style.position = 'absolute';

			// Create the img element and attach it to the div.
			var img = document.createElement('img');
			img.src = this.image_;
			img.style.width = '100%';
			img.style.height = '100%';
			img.style.position = 'absolute';


			div.appendChild(img);

			this.div_ = div;

			// Add the element to the "overlayLayer" pane.
			var panes = this.getPanes();
			panes.overlayLayer.appendChild(div);
		};

		USGSOverlay.prototype.draw = function() {
			var overlayProjection = this.getProjection();
			var sw = overlayProjection.fromLatLngToDivPixel(this.bounds_.getSouthWest());
			var ne = overlayProjection.fromLatLngToDivPixel(this.bounds_.getNorthEast());

			// Resize the image's div to fit the indicated dimensions.
			var div = this.div_;
			div.style.left = sw.x + 'px';
			div.style.top = ne.y + 'px';
			div.style.width = (ne.x - sw.x) + 'px';
			div.style.height = (sw.y - ne.y) + 'px';
		};

		USGSOverlay.prototype.onRemove = function() {
			this.div_.parentNode.removeChild(this.div_);
			this.div_ = null;
		};

		USGSOverlay.prototype.toggle = function(opacidad) {
			this.div_.style.opacity = opacidad;
		};

		function EditMarker(locations, map){
			var bounds = new google.maps.LatLngBounds();
			//setMapOnAll(null);
			for (var i = 0; i < locations.length; i++) {
			    var coordenadas = locations[i];
			    var myLatLng = new google.maps.LatLng(coordenadas[1], coordenadas[2]);
			    bounds.extend(myLatLng);
			}
			var srcImage = '<?=$imagen_del_mapa;?>';
			overlay = new USGSOverlay(bounds, srcImage, map);
			//map.fitBounds(bounds); //Posiciona la visualizaxion
		}

		google.maps.event.addDomListener(window, 'load', initialize);

		
</script>
<script type="text/javascript">
	$(function(){
	    initialize();
	});
</script>

