<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Khill\Lavacharts\Lavacharts;

use DB;
use Auth;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user=User::findOrFail(Auth::user()->id);

        if($user->hasRole('Developer')){
            $agencias = DB::select("SELECT FNC_DAME_AGENCIAS_TOTAL() AS TOTAL;");
            $agencias = $agencias[0]->TOTAL;
            $vendedores = DB::select("SELECT FNC_DAME_VENDEDORES_TOTAL() AS TOTAL;");
            $vendedores = $vendedores[0]->TOTAL;
            $pos = DB::select("SELECT FNC_DAME_POS_TOTAL('0') AS TOTAL;");
            $pos = $pos[0]->TOTAL;
            $pos_libres= DB::select("SELECT FNC_DAME_POS_TOTAL('1') AS TOTAL;");
            $pos_libres = $pos_libres[0]->TOTAL;
            $pos_asignados= DB::select("SELECT FNC_DAME_POS_TOTAL('2') AS TOTAL;");
            $pos_asignados = $pos_asignados[0]->TOTAL;
            $rifas=0;
            $jugadas=0;
        //Role o Perfil Supervisor
        }elseif($user->hasRole('Supervisor')){
            $agencias = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".Auth::user()->id."') AS 'AGENCIA_ID'");
            $agencias = $agencias[0]->AGENCIA_ID;
            $fecha = date('Y-m-d');
            $rifas = DB::select("SELECT FNC_DAME_RIFAS_VENDIDAS_X_AGENCIA('".$agencias."','".$fecha."') AS 'TOTAL'");
            $rifas=$rifas[0]->TOTAL;
            $vendedores = DB::select("SELECT FNC_DAME_VENDEDORES_TOTAL_X_AGENCIA('".$agencias."') AS TOTAL;");
            $vendedores = $vendedores[0]->TOTAL;

            $jugadas = DB::select("SELECT FNC_DAME_JUGADAS_TOTAL_X_AGENCIA('".$agencias."') AS 'TOTAL';");
            $jugadas=$jugadas[0]->TOTAL;
            $pos = DB::select("SELECT FNC_DAME_POS_TOTAL('0') AS TOTAL;");
            $pos = $pos[0]->TOTAL;
            $pos_libres= DB::select("SELECT FNC_DAME_POS_TOTAL('1') AS TOTAL;");
            $pos_libres = $pos_libres[0]->TOTAL;
            $pos_asignados= DB::select("SELECT FNC_DAME_POS_TOTAL('2') AS TOTAL;");
            $pos_asignados = $pos_asignados[0]->TOTAL;


        }elseif($user->hasRole('Agente')){
            $agencias = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".Auth::user()->id."') AS 'AGENCIA_ID'");
            $agencias = $agencias[0]->AGENCIA_ID;
            $fecha = date('Y-m-d');
            $rifas = DB::select("SELECT FNC_DAME_RIFAS_VENDIDAS_X_AGENCIA('".$agencias."','".$fecha."') AS 'TOTAL'");
            $rifas=$rifas[0]->TOTAL;
            $vendedores = DB::select("SELECT FNC_DAME_VENDEDORES_TOTAL_X_AGENCIA('".$agencias."') AS TOTAL;");
            $vendedores = $vendedores[0]->TOTAL;

            $jugadas = DB::select("SELECT FNC_DAME_JUGADAS_TOTAL_X_AGENCIA('".$agencias."') AS 'TOTAL';");
            $jugadas=$jugadas[0]->TOTAL;
            $pos = DB::select("SELECT FNC_DAME_POS_TOTAL('0') AS TOTAL;");
            $pos = $pos[0]->TOTAL;
            $pos_libres= DB::select("SELECT FNC_DAME_POS_TOTAL('1') AS TOTAL;");
            $pos_libres = $pos_libres[0]->TOTAL;
            $pos_asignados= DB::select("SELECT FNC_DAME_POS_TOTAL('2') AS TOTAL;");
            $pos_asignados = $pos_asignados[0]->TOTAL;

        }elseif($user->hasRole('Vendedor')){
           
            $vendedor =DB::select("SELECT FNC_DAME_VENDEDOR_ID_X_USUARIO_ID('".Auth::user()->id."') AS 'VENDEDOR_ID'");

            $vendedor=$vendedor[0]->VENDEDOR_ID;


            $agencias = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_VENDEDOR_ID('".$vendedor."') AS 'AGENCIA_ID'");
            $agencias = $agencias[0]->AGENCIA_ID;
            $fecha = date('Y-m-d');
            $rifas = DB::select("SELECT FNC_DAME_RIFAS_VENDIDAS_X_AGENCIA('".$agencias."','".$fecha."') AS 'TOTAL'");
            $rifas=$rifas[0]->TOTAL;
            $vendedores = DB::select("SELECT FNC_DAME_VENDEDORES_TOTAL_X_AGENCIA('".$agencias."') AS TOTAL;");
            $vendedores = $vendedores[0]->TOTAL;

            //dd($agencias);
            $jugadas=0;
            $pos = DB::select("SELECT FNC_DAME_POS_TOTAL('0') AS TOTAL;");
            $pos = $pos[0]->TOTAL;
            $pos_libres= DB::select("SELECT FNC_DAME_POS_TOTAL('1') AS TOTAL;");
            $pos_libres = $pos_libres[0]->TOTAL;
            $pos_asignados= DB::select("SELECT FNC_DAME_POS_TOTAL('2') AS TOTAL;");
            $pos_asignados = $pos_asignados[0]->TOTAL;

        }


        
        $data7dias = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_AGENCIA_7DIAS('".$agencias."');");
        $chart7dias = new Lavacharts(); // See note below for Laravel

        $ventas7dias = $chart7dias->DataTable();

        $ventas7dias->addDateColumn('Fecha')
                ->addNumberColumn('Recaudacion')
                ->addNumberColumn('Importe')
                ->addNumberColumn('Comision');
       
       // dd($use);
        foreach ($data7dias as $node) {
            // code...
            $ventas7dias->addRow([$node->FECHA,$node->RECAUDACION_TOTAL,$node->IMPORTE_TOTAL,$node->COMISION_TOTAL]);
        }
              
                
       
        

        $chart7dias->ColumnChart('Ventas7DiasAgencia', $ventas7dias, [
               
                
                'title' => 'Los ultimos 7 Dias de Ventas',
                    'titleTextStyle' => [
                        'color'    => '#eb6b2c',
                        'fontSize' => 14,
                        
                    ],
                
                
                'animation'=>[
                'startup'=>true,
                'duration'=>1000,
                'easing'=>'inAndOut',
                ],
                'events'=>['ready'=>'LoadReady'],
                'legend'=>['position'=>'out'],
                

                
        ]);
         $ventas7dias->setTimezone('America/Asuncion');

 
        return view('admin.panel.index',['agencias'=>$agencias,'vendedores'=>$vendedores,'rifas'=>$rifas,'jugadas'=>$jugadas,'Ventas7DiasAgencia'=>$chart7dias,'pos'=>$pos,'pos_libres'=>$pos_libres,'pos_asignados'=>$pos_asignados]);
       
    }


    public function ResumenCajaAgenciaWeb(){
         $user = User::findOrFail(Auth::user()->id);
        $_agencia = DB::select("SELECT FNC_DAME_AGENCIA_ID_X_USUARIO_ID('".$user->id."') AS 'AGENCIA_ID';");
        $_agencia = $_agencia[0]->AGENCIA_ID;
        $agencia = isset($_GET['a']) ? $_GET['a'] : $_agencia;
        $f1= isset($_GET['f1']) ? $_GET['f1'] : date('y-m-d');
        $f2= isset($_GET['f2']) ? $_GET['f2'] : date('y-m-d');
        $caja_resumen = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_AGENCIA_RANGO('".$agencia."','".$f1."','".$f2."')");
        $data = DB::select("CALL PRO_VER_RESUMEN_CAJA_X_AGENCIA_RANGO('".$agencia."','".$f1."','".$f2."');");
        $chart = new Lavacharts(); // See note below for Laravel

        $ventas1 = $chart->DataTable();

        $ventas1->addDateColumn('Fecha')
                ->addNumberColumn('Recaudacion')
                ->addNumberColumn('Importe')
                ->addNumberColumn('Comision');
               
       // dd($use);
        foreach ($data as $node) {
            // code...
            $ventas1->addRow([$node->FECHA,$node->RECAUDACION_TOTAL,$node->IMPORTE_TOTAL,$node->COMISION_TOTAL]);
        }
              
                
       
        

        $chart->ColumnChart('CajaAgencia', $ventas1, [
               
                'height'=>400,
                'title' => 'Ventas Diarias De Rifas',
                    'titleTextStyle' => [
                        'color'    => '#eb6b2c',
                        'fontSize' => 20,
                        'alignment'=>'center',
                    ],
                

                'animation'=>[
                'startup'=>true,
                'duration'=>1000,
                'easing'=>'inAndOut',
                ],
                'events'=>['ready'=>'LoadReady'],
                

                
        ]);

        $caja_detalles = DB::select("CALL PRO_VER_DETALLES_CAJA_X_AGENCIA_RANGO('".$agencia."','".$f1."','".$f2."');");
        return view('admin.caja.resumen_agencia',['data'=>$caja_detalles,'chart'=>$chart,'caja'=>$caja_resumen,'agencia'=>$agencia,'desde'=>$f1,'hasta'=>$f2]);

    }
}
