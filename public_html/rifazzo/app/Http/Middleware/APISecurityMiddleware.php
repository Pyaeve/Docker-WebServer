<?php

namespace App\Http\Middleware;

use Closure;

class APISecurityMiddleware
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
       if(is_object($request)){
            $ret;
              

            foreach ($request as $key => $value) {
                # code...
                $ret[$key]=$value;
            }

            if(is_object($ret['headers'])){
               $obj;
               foreach ($ret['headers'] as $key => $value) {
                   # code...
                  $obj[$key]=$value;
               }
               $res;
               if(array_key_exists("api", $obj)){
                if($obj['api'][0]=="123456"){
                    //$res[]['code']=10101;
                    //$res[0]['msg']="Estas Autorizado";
                    //return $res;
                    return $next($request);
                }else{
                    $res[]['error']=1123;
                    $res[0]['msg']="No estas Autorizado";
                    return $res;  
                }

               }else{
                 $res[]['error']=1123;
                    $res[0]['msg']="No estas Autorizado";
                    return $res;  
               }
                
                
            
            }
                        
        }
       
    }
}
