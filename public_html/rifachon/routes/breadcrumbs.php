<?php 
Breadcrumbs::for('Home', function ($trail) {
   
    $trail->push('Rifachon', route('home'));
});
Breadcrumbs::for('Zonas', function ($trail) {
   
    $trail->parent('Home');
    $trail->push('Zonas', '#');
});

Breadcrumbs::for('ZonasResumen', function ($trail) {
   
    $trail->parent('Zonas');
    $trail->push('Resumen', route('backend.zonas.resumen'));
});

Breadcrumbs::for('ZonasCargar', function ($trail) {
   
    $trail->parent('Zonas');
    $trail->push('Cargar', '#');
});
//vendedores
Breadcrumbs::for('Vendedores', function ($trail) {
   
    $trail->parent('Home');
    $trail->push('Vendedores', route('backend.vendedores.resumen'));
});

//resumen de vendedores
Breadcrumbs::for('VendedoresAgregar', function ($trail) {
   
    $trail->parent('Vendedores');
    $trail->push('Agregar Nuevo Vendedor/a', '#');
});
//resumen de vendedores
Breadcrumbs::for('VendedoresResumen', function ($trail) {
   
    $trail->parent('Vendedores');
    $trail->push('Resumen', '#');
});
//editar vendedor
Breadcrumbs::for('VendedoresEditar', function ($trail) {
   
    $trail->parent('Vendedores');
    $trail->push('Editar Datos', '#');
});
//jugadas
Breadcrumbs::for('Jugadas', function ($trail) {
   
    $trail->parent('Home');
    $trail->push('Jugadas', '#');
    $trail->push('Resumen', '#');
});

Breadcrumbs::for('JugadasResumen', function ($trail) {
   
    $trail->parent('Vendedores');
    $trail->push('Resumen', '#');
});

//RifasVender
Breadcrumbs::for('RifasVender', function ($trail) {
   
    $trail->parent('Home');
    $trail->push('Rifas', route('backend.rifas.resumen'));
    $trail->push('Vender', '#');
});

//RifasVender
Breadcrumbs::for('RifasVendida', function ($trail) {
   
    $trail->parent('Home');
    $trail->push('Rifas', route('backend.rifas.resumen'));
    $trail->push('Vender', '#');
});


//RifasResumen
Breadcrumbs::for('RifasResumen', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Rifas', route('backend.rifas.resumen'));
    $trail->push('Resumen', '#');
   
});

//CajaResumen
Breadcrumbs::for('CajaAgenciaResumen', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Caja', route('backend.caja.agencia'));
    $trail->push('Resumen', '#');
   
});

//CajaResumen
Breadcrumbs::for('CajaVendedorResumen', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Caja', route('backend.caja.vendedor'));
    $trail->push('Resumen', '#');
   
});


//AgenciasResumen
Breadcrumbs::for('AgenciasResumen', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Agencias','#'); 
    $trail->push('Resumen', '#');
   
});

//AgenciasCargar
Breadcrumbs::for('AgenciasCargar', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Agencias','#'); 
    $trail->push('Cargar', '#');
   
});

//Sorteos 
//Sorteos CARGAR
Breadcrumbs::for('SorteosCargar', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Sorteos','#'); 
    $trail->push('Cargar', '#');
   
});
//Sorteos SORTEAR
Breadcrumbs::for('SorteosSortear', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Sorteos','#'); 
    $trail->push('Cargar', '#');
   
});
//Sorteos RESUMEN
Breadcrumbs::for('SorteosResumen', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Sorteos','#'); 
    $trail->push('Resumen', '#');
   
});


//Uitilidades Calculadora de riegos
Breadcrumbs::for('UtilCalculadora', function ($trail) {
   
    $trail->parent('Home');

    $trail->push('Utilidades','#'); 
    $trail->push('Calculadora de Riesgos por Jugada', '#');
   
});






