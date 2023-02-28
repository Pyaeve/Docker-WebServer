<?php

namespace App\Http\Middleware;

use Closure;
use Menu;

class GenerateMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        Menu::make('DevMenuBar', function ($menu) {
            $menu->add('Home','#')->prepend('<i class="nav-icon fas fa-th"></i> ');
            $menu->add('Agencias', '#')->prepend('<i class="nav-icon fas fa-house-user"></i>')->before('<p><i class="nav-icon fas fa-house-user"></i></p>');
            $menu->agencias->add('Cargar', ['route'  => 'backend.agencias.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
        $menu->agencias->add('Resumen', ['route'  => 'backend.agencias.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
        $menu->agencias->add('Agentes','#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
        $menu->agentes->add('Cargar', ['route'  => 'backend.agentes.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
        $menu->agentes->add('Resumen', ['route'  => 'backend.agentes.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
        $menu->add('Supervisores', '#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
        $menu->supervisores->add('Cargar', '#')->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
        $menu->supervisores->add('Resumen', '#')->prepend('<i class="nav-icon fas fa-list"></i>');
        $menu->add('Vendedores', '#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
        $menu->vendedores->add('Cargar', ['route'  => 'backend.vendedores.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
        $menu->vendedores->add('Resumen', ['route'  => 'backend.agencias.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');

       //caja
            $menu->add('Caja','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->caja->add('Cargar', ['route'  => 'backend.caja.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->caja->add('Resumen', ['route'  => 'backend.caja.agencia'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //jugadas
            $menu->add('Jugadas','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->jugadas->add('Cargar', ['route'  => 'backend.jugadas.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->jugadas->add('Resumen', ['route'  => 'backend.jugadas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //rifas
            $menu->add('Rifas','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
       
            $menu->rifas->add('Resumen', ['route'  => 'backend.rifas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
              //utilidades
             $menu->add('Utilidades','#')->prepend('<i class="nav-icon fas fa-tools"></i>');
              $menu->utilidades->add('Calculadora', ['route'  => 'backend.util.calculadora'])->prepend('<i class="nav-icon fas fa-calculator"></i>');

        });
        //menu para Role Supervisor
        Menu::make('SupervisorMenuBar', function ($menu) {
            
           
         //vendeor menu
        Menu::make('UserMenuMain', function ($menu) {
            $menu->add('Home','#')->prepend('<i class="nav-icon fas fa-th"></i> ');
            //caja
            //$menu->add('Consultar SERP','cse')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->add('Consultar SERP', ['route'  => 'backend.serp.consultar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
           /* $menu->caja->add('Resumen', ['route'  => 'backend.caja.vendedor'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //jugadas
            $menu->add('Rifas','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->rifas->add('Vender', ['route'  => 'backend.rifas.vender'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->rifas->add('Resumen', ['route'  => 'backend.rifas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');  */


        });



        return $next($request);
    }   
}
