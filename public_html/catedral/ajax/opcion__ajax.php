<?php
    require_once('../_sys/init.php');
    $susursal = param('susursal');
    $html = "";
    $markers = "";

    if(strlen($susursal) > 0){
        $buscador = Sucursales::get("sucursal_nombre LIKE '%{$susursal}%' OR sucursal_direccion LIKE '%{$susursal}%'");

        if(haveRows($buscador)){
            $i = 0;
            foreach ($buscador as $rs) {
                $nombre = $result['sucursal_nombre'];
                $html.= '<li class="act_matriz">
                        <a href="javascript:;" onclick="javascript:irapunto(this, '.$i.')">
                            <h5>'.$rs["sucursal_nombre"].'</h5>
                            <p>'.$rs["sucursal_direccion"].'<br>';
                            $datoshora = json_decode($rs['sucursal_horarios']);
                            if(haveRows($datoshora)):
                                        foreach ($datoshora as $hora):
                                             $html.= $hora.'<br>';                
                                        endforeach;
                                    endif;
                $html.= '</p></a>
                        </li>';
                $i++;
                //$html.= '<option>'.$nombre.'</option>';
            }

    
            //MARKERS
            $markers.='<script type="text/javascript">
                            var markers = [';
                                    foreach ($buscador as $rsmaker):
                                        $mapa = explode(",", $rsmaker['sucursal_ubicacion']);
                                        $markers.='{
                                                "nombre":"'.$rsmaker["sucursal_nombre"].'", 
                                                "lat":'.$mapa[0].', "lng": '.$mapa[1].', 
                                                "info": "<p style=\'padding:0; margin:0; text-align:center;\'><b>'.$rsmaker['sucursal_nombre'].':</b> '.$rsmaker['sucursal_direccion'].'</p>",
                                                "img": "images/icomapa.png"
                                        },';
                                      endforeach; 
                        $markers.='];
            </script>';

            $result = array('status'=>'success','html'=>$html, 'markers' => $markers);
            print json_encode($result);
            exit;
        }

    }else{
        $sucursales = Sucursales::get();
        if(haveRows($sucursales)){
            $i = 0;
            foreach ($sucursales as $rs) {
                $nombre = $result['sucursal_nombre'];
                $html.= '<li class="act_matriz">
                        <a href="javascript:;" onclick="javascript:irapunto(this, '.$i.')">
                            <h5>'.$rs["sucursal_nombre"].'</h5>
                            <p>'.$rs["sucursal_direccion"].'<br>';
                            $datoshora = json_decode($rs['sucursal_horarios']);
                            if(haveRows($datoshora)):
                                        foreach ($datoshora as $hora):
                                             $html.= $hora.'<br>';                
                                        endforeach;
                                    endif;
                $html.= '</p></a>
                        </li>';
                $i++;
            }

            //MARKERS
            $markers.='<script type="text/javascript">
                            var markers = [';
                                    foreach ($sucursales as $rsmaker):
                                        $mapa = explode(",", $rsmaker['sucursal_ubicacion']);
                                        $markers.='{
                                                "nombre":"'.$rsmaker["sucursal_nombre"].'", 
                                                "lat":'.$mapa[0].', "lng": '.$mapa[1].', 
                                                "info": "<p style=\'padding:0; margin:0; text-align:center;\'><b>'.$rsmaker['sucursal_nombre'].':</b> '.$rsmaker['sucursal_direccion'].'</p>",
                                                "img": "images/icomapa.png"
                                        },';
                                      endforeach; 
                        $markers.='];
            </script>';

            $result = array('status'=>'success','html'=>$html, 'markers' => $markers);
            print json_encode($result);
            exit;
        }
    }

    
?>