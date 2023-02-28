<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UtilController extends Controller
{
    //
    function FormCalculadoraRiesgos(){
        return view('admin.utilidades.calculadora');
    }
}
