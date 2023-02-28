<ul>
	<li class="heading"><span>Sistema</span></li>
	<li class="hasSubmenu"> <a data-toggle="collapse" class="glyphicons cogwheels" href="#menu_config"><i></i><span>Configuraciones</span></a>
		<ul class="collapse" id="menu_config">
			<li><a href="" onclick="module('admins');return!1;"><i></i><span>Administradores</span></a></li>
		</ul>

	</li>
	<li class="heading"><span>Contenidos</span></li>
<?php if(access('banners')): ?>
	<li class="glyphicons picture"><a href="" onclick="module('banners');return!1;"><i></i><span>Banners</span></a></li>
<?php endif; ?>
<?php /*if(access('familias')): ?>
	<li class="glyphicons globe"><a href="" onclick="module('familias');return!1;"><i></i><span>Familias</span></a></li>
<?php endif;*/ ?>

<?php if(access('categorias')): ?>
	<li class="glyphicons signal"><a href="" onclick="module('categorias');return!1;"><i></i><span>Categorias</span></a></li>
<?php endif; ?>
<?php if(access('marcas')): ?>
	<li class="glyphicons tags"><a href="" onclick="module('marcas');return!1;"><i></i><span>Marcas</span></a></li>
<?php endif; ?>
<?php if(access('productos')): ?>
	<li class="glyphicons barcode"><a href="" onclick="module('productos');return!1;"><i></i><span>Productos</span></a></li>
<?php endif; ?>

<?php if(access('imagenes_productos')): ?>
	<li class="glyphicons picture"><a href="" onclick="module('imagenes_productos_multi');return!1;"><i></i><span>Imagenes productos</span></a></li>
<?php endif; ?>

<?php if(access('promociones_tipos')): ?>
	<li class="glyphicons globe"><a href="" onclick="module('promociones_tipos');return!1;"><i></i><span>Categoria promociones </span></a></li>
<?php endif; ?>

<!-- TIPOS: 1-promociones / 2-Recomendados / 3-Los mejores -->
<?php /*if(access('productos_ofertas')): ?>
	<li class="glyphicons bookmark"><a href="" onclick="module('productos_ofertas&oferta_tipo=1');return!1;"><i></i><span>Promociones</span></a></li>
<?php endif; ?>
<?php if(access('productos_ofertas')): ?>
	<li class="glyphicons bullhorn"><a href="" onclick="module('productos_ofertas&oferta_tipo=2');return!1;"><i></i><span>Recomendados</span></a></li>
<?php endif; ?>
<?php if(access('productos_ofertas')): ?>
	<li class="glyphicons bell"><a href="" onclick="module('productos_ofertas&oferta_tipo=3');return!1;"><i></i><span>Los mejores</span></a></li>
<?php endif;*/ ?>



<?php if(access('ofertas_imagenes')): ?>
	<li class="glyphicons bookmark"><a href="" onclick="module('ofertas_imagenes');return!1;"><i></i><span>Ofertas Semana Banner</span></a></li>
<?php endif; ?>
<?php if(access('noticias')): ?>
	<li class="glyphicons cargo"><a href="" onclick="module('noticias');return!1;"><i></i><span>Información para Ti</span></a></li>
<?php endif; ?>
<?php if(access('departamentos')): ?>
	<li class="glyphicons globe"><a href="" onclick="module('departamentos');return!1;"><i></i><span>Departamentos</span></a></li>
<?php endif; ?>
<?php if(access('sucursales')): ?>
	<li class="glyphicons more_items"><a href="" onclick="module('sucursales');return!1;"><i></i><span>sucursales</span></a></li>
<?php endif; ?>


<?php if(access('clientes')): ?>
	<li class="glyphicons group"><a href="" onclick="module('clientes');return!1;"><i></i><span>Clientes</span></a></li>
<?php endif; ?>

<?php if(access('contraentrega')): ?>
	<li class="glyphicons shopping_bag"><a href="" onclick="module('contraentrega');return!1;"><i></i><span>Pedidos</span></a></li>
<?php endif; ?>

<?php if(access('sucursales')): ?>
	<li class="glyphicons more_items"><a href="" onclick="module('ofertalaborales');return!1;"><i></i><span>Curriculum</span></a></li>
<?php endif; ?>

<?php if(access('contactos')): ?>
	<li class="glyphicons more_items"><a href="" onclick="module('contactos');return!1;"><i></i><span>Contactos</span></a></li>
<?php endif; ?>
<?php /*if(access('carrito')): ?>
	<li class="glyphicons globe"><a href="" onclick="module('carrito');return!1;"><i></i><span>Carrito</span></a></li>
<?php endif; ?>
<?php if(access('carrito_detalle')): ?>
	<li class="glyphicons globe"><a href="" onclick="module('carrito_detalle');return!1;"><i></i><span>Carrito_detalle</span></a></li>
<?php endif; ?>


<?php if(access('contactos')): ?>
	<li class="glyphicons inbox"><a href="" onclick="module('contactos');return!1;"><i></i><span>Contactos</span></a></li>
<?php endif; */?>

<?php if(access('zona_ecommerce')): ?>
	<li class="glyphicons inbox"><a href="" onclick="module('zona_ecommerce');return!1;"><i></i><span>Zona Ecommerce</span></a></li>
<?php endif; ?>

<?php if(access('suscripciones')): ?>
	<li class="glyphicons e-mail"><a href="" onclick="module('suscripciones');return!1;"><i></i><span>Suscripcion</span></a></li>
<?php endif; ?>
</ul>
