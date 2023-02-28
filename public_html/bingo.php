<?php
//
$posicion=0;
$numeros=[];
$numeros_ordenados=[];
$generados=[];
$generados_ordenados=[];
$total=100;

//creamos unu sorteo de 25 numeros de 1 entre 100 del sorteo

for($fila=1; $fila<=50 ; $fila++){
   // for($columna=1; $columna<=5; $columna++){
        $generados[$posicion]=comprobarRepetido($generados,rand(1,100));
        $posicion+=1;
   // }
           
}
//ordenamos los numeros obtenidos
 //sort($generados);
 //loop recorremos de vuelta con el nuevo orden
 foreach ($generados as $k => $v) {
    $generados_ordenados[]=$v;

 }

//creamos 25 numeros, 1 entre 100, no repetivos
for($fila=1; $fila<=5 ; $fila++){
    for($columna=1; $columna<=5; $columna++){
        $numeros[$posicion]=comprobarRepetido($numeros,rand(1,100));
        $posicion+=1;
    }
           
}
//ordenamos los numeros obtenidos
 sort($numeros);
 //loop recorremos de vuelta con el nuevo orden
 foreach ($numeros as $k => $v) {
    $numeros_ordenados[]=$v;

 }

 //reseteamos la posicion
 $posicion=0;
 //imprimo los numeros sorteamos y tratamos de pintar las que coindican
 foreach($generados_ordenados as $n){

    echo $n." ";
 }

 //creamos la cantidad de 
 for($cant=1; $cant<=$total; $cant++){
    //resteamos de vuelta
 $posicion = 0;
$numeros_ordenados=generar_nro(25,1,100,1);
// empezamos a imprimir la grilla del binguito de 25
echo "<div class='row'>";
echo "<div class='col-md-6'>";

echo "<table class='table' height='600px'border=1>";
echo "<thead><tr> <th colspan='5'>Binguito Nro ".$cant."</th></tr><thead><tbody>";
for($fila=1; $fila<=5 ; $fila++){
    echo "<tr >";

    for($columna=1; $columna<=5; $columna++){
        //verificamos los numero que cpoincidan entre los sorteamos y lo ordenamos 
        if($generados_ordenados[$posicion]==$numeros_ordenados[$posicion]){
            echo "<td style='padding:10px; min-height:100px;min-width:100px;background-color:red; text-align:center'><sup>".($posicion+1)."</sup><b style='font-size:26px'>" . $numeros_ordenados[$posicion]."</b></td>";
                    $posicion+=1;
        }else{
            //en caso que njo coincida los indices con el generado inclusive con el indice de posicon del
            if(in_array($numeros_ordenados[$posicion],$generados_ordenados)){
                //imprmimos nmaranga como backgroiund
                 echo "<td style='min-height:100px;min-width:100px;padding:10px;background-color:orange;text-align:center'><sup>".($posicion+1)."</sup><b style='font-size:26px'>" . $numeros_ordenados[$posicion]."</b></td>";
                    $posicion+=1;
            }else{
                echo "<td style='min-height:100px;min-width:100px;padding:10px; text-align:center'><sup>".($posicion+1)."</sup><b style='font-size:26px'>" . $numeros_ordenados[$posicion]."</b></td>";
                    $posicion+=1;
            }
            
        }
        
    }
    echo "</tr>";
}
echo "</table></div></div>";
  
 }
 
/**
* Algoritmo que recorre el contenido de un array
* y comprueba si el numero pasado por parametros
* se encuentra contenido en este.
* 
*/
function comprobarRepetido($array, $numero){
    //bandera para comprobar si el numero se repite
    $repetido=false;
    //recorre el array mientras el valor no esté contenido
    for($indice=0; $indice<count($array) && $repetido==false; $indice++){
        //si el numero es igual a $valor, devuelve true
        $repetido=($array[$indice]==$numero)?true:false;
    }

    //en caso que el numero se repita, pasa por parametros un nuevo numero
    //y realiza recursividad a si misma 
    if($repetido==true){
        return comprobarRepetido($array,rand(1,100));
    }else{
        return $numero;
    }       
}


function generar_nro($total,$entre_a,$y_b,$ordenar=1){
    $i = 0;
    $total=$total-1;
    $nro=[];
    for($i=0;$i<=$total;$i++){
        $nro[$i]=comprobarRepetido($nro,rand($entre_a,$y_b));
    }
    if($ordenar==1){
        sort($nro);
        $ord=[];
        //loop recorremos de vuelta con el nuevo orden
        foreach ($nro as $k => $v) {
             $ord[]=$v;

        }
        return $ord;

    }
    return $nro;

}

?>