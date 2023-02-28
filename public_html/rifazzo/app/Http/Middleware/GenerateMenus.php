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
            
            $menu->add('Home',['route'=>'home'])->prepend('<i class="nav-icon fas fa-th"></i> ');
          
          
            $menu->add('Vendedores', '#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
            $menu->vendedores->add('Cargar', ['route'  => 'backend.vendedores.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->vendedores->add('Resumen', ['route'  => 'backend.vendedores.resumen'])->prepend('<i class="nav-icon  fas fa-list"></i>');
            //AGENCIAs
             $menu->add('Agencias', '#')->prepend('<i class="nav-icon fas fa-house-user"></i>')->before('<p><i class="nav-icon fas fa-house-user"></i></p>');
            $menu->agencias->add('Cargar', ['route'  => 'backend.agencias.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->agencias->add('Resumen', ['route'  => 'backend.agencias.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
            $menu->agencias->add('Agentes','#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
             //agentes
             $menu->agentes->add('Cargar', ['route'  => 'backend.agentes.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
             $menu->agentes->add('Resumen', ['route'  => 'backend.agentes.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
           
            //POS
              $menu->add('Pos', '#')->prepend('<i class="nav-icon fas fa-mobile-alt"></i> ');
            $menu->pos->add('Cargar', ['route'  => 'backend.pos.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->pos->add('Resumen', ['route'  => 'backend.pos.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //caja
            $menu->add('Caja','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->caja->add('Cargar', ['route'  => 'backend.caja.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->caja->add('Resumen', ['route'  => 'backend.caja.agencia'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //jugadas
            $menu->add('Jugadas','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->jugadas->add('Cargar', ['route'  => 'backend.jugadas.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->jugadas->add('Resumen', ['route'  => 'backend.jugadas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //sorteos
          
            $menu->add('Sorteos','#')->prepend('<i class="nav-icon fas fa-random"></i>');
          
           $menu->sorteos->add('Cargar', ['route'  => 'backend.sorteos.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
             $menu->sorteos->add('Resumen', ['route'  => 'backend.sorteos.resumen'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
             
            //rifas
            $menu->add('Rifas','#')->prepend('<i class="nav-icon fas fa-ticket-alt"></i>');
          
            $menu->rifas->add('Resumen', ['route'  => 'backend.rifas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
              //informes
            $menu->add('Informes','#')->prepend('<i class="nav-icon fas fa-chart-bar"></i>');
          
            $menu->informes->add('de Vendedores', ['route'  => 'backend.informes.vendedores'])->prepend('<i class="nav-icon fas fa-user-chart"></i>');
            //utilidades
             $menu->add('Utilidades','#')->prepend('<i class="nav-icon fas fa-tools"></i>');
              $menu->utilidades->add('Calculadora', ['route'  => 'backend.util.calculadora'])->prepend('<i class="nav-icon fas fa-calculator"></i>');
        });
        //menu para role Agente
         Menu::make('AgenteMenuBar', function ($menu) {
            
            $menu->add('Home',['route'=>'home'])->prepend('<i class="nav-icon fas fa-th"></i> ');
          
           /* $menu->add('Supervisores', '#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
            $menu->supervisores->add('Cargar', '#')->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->supervisores->add('Resumen', '#')->prepend('<i class="nav-icon fas fa-list"></i>'); */
            //vendedores
            $menu->add('Vendedores', '#')->prepend('<i class="nav-icon fas fa-user-tie"></i> ');
            $menu->vendedores->add('Cargar', ['route'  => 'backend.vendedores.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->vendedores->add('Resumen', ['route'  => 'backend.vendedores.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
           
            //POS
              $menu->add('Pos', '#')->prepend('<i class="nav-icon fas fa-mobile-alt"></i> ');
            $menu->pos->add('Cargar', ['route'  => 'backend.pos.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->pos->add('Resumen', ['route'  => 'backend.pos.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //caja
            $menu->add('Caja','#')->prepend('<i class="nav-icon fas ca-money"></i>');
             $menu->caja->add('Cargar', ['route'  => 'backend.caja.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->caja->add('Resumen', ['route'  => 'backend.caja.agencia'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //jugadas
            $menu->add('Jugadas','#')->prepend('<i class="nav-icon fas ca-ruleta-trebol"></i>');
             $menu->jugadas->add('Cargar', ['route'  => 'backend.jugadas.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->jugadas->add('Resumen', ['route'  => 'backend.jugadas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //sorteos
          
            $menu->add('Sorteos','#')->prepend('<i class="nav-icon fas ca-dados"></i>');
          
            $menu->sorteos->add('Cargar', ['route'  => 'backend.sorteos.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
             $menu->sorteos->add('Resumen', ['route'  => 'backend.sorteos.resumen'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            //rifas
            $menu->add('Rifas','#')->prepend('<i class="nav-icon fas fa-ticket-alt"></i>');
          
            $menu->rifas->add('Resumen', ['route'  => 'backend.rifas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');
              //informes
            $menu->add('Informes','#')->prepend('<i class="nav-icon fas fa-chart-bar"></i>');
          
            $menu->informes->add('de Vendedores', ['route'  => 'backend.informes.vendedores'])->prepend('<i class="nav-icon fas fa-user-chart"></i>');
              //utilidades
             $menu->add('Utilidades','#')->prepend('<i class="nav-icon fas fa-tools"></i>');
              $menu->utilidades->add('Calculadora', ['route'  => 'backend.util.calculadora'])->prepend('<i class="nav-icon fas fa-calculator"></i>');
        });

         //vendeor menu
        Menu::make('VendedorMenuBar', function ($menu) {
            $menu->add('Home','#')->prepend('<i class="nav-icon fas fa-th"></i> ');
            //caja
            $menu->add('Caja','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->caja->add('Cargar', ['route'  => 'backend.caja.cargar'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->caja->add('Resumen', ['route'  => 'backend.caja.vendedor'])->prepend('<i class="nav-icon fas fa-list"></i>');
            //jugadas
            $menu->add('Rifas','#')->prepend('<i class="nav-icon fas fa-money-bill-wave"></i>');
             $menu->rifas->add('Vender', ['route'  => 'backend.rifas.vender'])->prepend('<i class="nav-icon fas fa-solid fa-plus-circle"></i>');
            $menu->rifas->add('Resumen', ['route'  => 'backend.rifas.resumen'])->prepend('<i class="nav-icon fas fa-list"></i>');


        });



        return $next($request);
    }   
}
