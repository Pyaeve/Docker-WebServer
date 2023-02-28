<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class CiudadesController extends Controller
{
    //
    public function ajaxWeb($id){
       $data = DB::select("CALL PRO_LISTAR_CIUDADES_X_ZONA('".$id."');");
       return $data;
   }
}
