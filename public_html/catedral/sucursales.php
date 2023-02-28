<?php
    include("inc/config.php");
    $productos = Productos::listing(9,pageNumber());
?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>  
  <title>Locales</title>
  <style type="text/css">
      .cid-sczwBedEaV {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background: #ffffff;
        }
        .sucursal{
            padding: 5px 6px;
            margin: 6px 11px;
            
        }
        .sucursal p{
            font-size: 13px;
        }
        .sucursal li{
            margin-bottom: 12px;
            border-bottom: 2px solid #232323;
        }
        ul li{ list-style: none;}
        .sucursal a{color:#232323}
        .menuLocales {
            height: 400px;
            overflow-x: hidden;
        }
        .act_matriz a p{
            line-height: 19px;
        }
        /**********************************************/
        .scrollbar {
            margin-left: 30px;
            float: left;
            height: 300px;
            width: 65px;
            background: #fff;
            overflow-y: scroll;
            margin-bottom: 25px;
        }
        .force-overflow {
            min-height: 450px;
        }

        .scrollbar-primary::-webkit-scrollbar {
            width: 12px;
            background-color: #F5F5F5; }

        .scrollbar-primary::-webkit-scrollbar-thumb {
            border-radius: 10px;
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
            background-color: #4285F4; }

        .scrollbar-primary {
            scrollbar-color: #4285F4 #F5F5F5;
        }


        #mapa {
            height: 500px;
            width: 97%;
            margin: 20px auto;
            border: 2px solid #163e72;
            -webkit-border-radius: 5px 5px 5px 5px !important;
            -moz-border-radius: 5px 5px 5px 5px !important;
            border-radius: 5px 5px 5px 5px !important;

        }

  </style>
</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 

<section class="map1 cid-sczwBedEaV" id="map1-1w">

        <div class="row">
            <div class="col-md-12 col-lg-3 ">
                <div class="flexsearch">
                    <div class="flexsearch--wrapper">
          
                        <form class="flexsearch--form" id="form_search_suc" method="post">
                            <div class="flexsearch--input-wrapper">
                                <input class="flexsearch--input" name="susursal" id="susursal" list="susursal" type="search" placeholder="Buscador de Sucursal">
                                <?
                                    $filtros = Sucursales::opcionfiltro();
                                    if(haveRows($filtros)){
                                        echo '<datalist id="susursal">';
                                        foreach ($filtros as $fm) {
                                            echo "<option data-value='".$fm['sucursal_id']."'>".$fm['sucursal_nombre']."</option>";
                                        }
                                        echo '</datalist>';
                                    }
                                ?>
                            </div>
                            <input type="hidden" name="tkSuc" id="tkSuc" value="<?=token("sucursales")?>">
                            <input type="hidden" name="idSuc" id="idSuc" value="">

                            <label class="flexsearch--submit" id="btn_submit">➜</label>
                        </form>
                    </div>
                </div>

                <ul class="sucursal menuLocales scrollbar-primary" id="cajalinks">
                    <?
                        $sucursales = Sucursales::get();
                        if(haveRows($sucursales)){
                            $i = 0;
                            foreach ($sucursales as $rs):
                                ?>
                    <li class="act_matriz">
                        <a href="javascript:;" onclick="javascript:irapunto(this, <?=$i?>)">
                            <h5><?=$rs['sucursal_nombre']?></h5>
                            <p>
                                <?=$rs['sucursal_direccion']?><br>
                                <? $datoshora = json_decode($rs['sucursal_horarios']);
                                    if(haveRows($datoshora)):
                                        foreach ($datoshora as $hora):
                                            echo $hora." <br>";                
                                        endforeach;
                                    endif;
                                    $datostel = json_decode($rs['sucursal_horarios']);
                                ?>
                             </p>
                        </a>
                    </li>
                                <?
                                $i++;
                            endforeach;
                        }
                    ?>

                </ul>

                
            </div>
            <div class="col-md-12 col-lg-9">
                <div id="mapa"></div>
            </div>

        </div>
</section>

<script type="text/javascript" src="js/jquery-3.4.0.min.js"></script>
<script type="text/javascript" src="js/mood.js"></script>
<script type="text/javascript">
     
        $(function(){
           moodjs.googlemap('mapa', markers, 14, 0);
        });

        $( "#btn_submit" ).click(function() {
            var valor = $("#susursal").val();
            $.ajax({
                url : 'ajax/opcion',
                data: $('#form_search_suc').serialize(),
                type : 'post',
                dataype : 'json',
                success : function(data){
                    console.log(data)
                    //$('#contenedor').html(data.description);
                }
            });
        });
        $('#susursal').on('keyup', function() {
          var susursal = $(this).val();   
          $.ajax({
                type: "POST",
                url: "ajax/opcion",
                data:   {'susursal':susursal},
                dataType: "json",
                success: function(data) {
                  $('#cajalinks').html(data.html);
                  $('#markers').html('');
                  $('#markers').html(data.markers);


                }
          });
        });
        function irapunto(li, obj){
            moodjs.gomarker(obj);
            $("#cajalinks li").click(function(){
                  $("li").removeClass("activo");
                  $(this).addClass("activo");
            });
        }
</script>
<div id="markers">
    <script type="text/javascript">

            var markers = [ 
                  <?php  
                    foreach ($sucursales as $rs):
                        $mapa = explode(",", $rs['sucursal_ubicacion']);
                        $horadata = json_decode($rs['sucursal_horarios']);
                        $horahtml ="";
                                        if(haveRows($horadata)):
                                            foreach ($horadata as $hora):
                                                $horahtml.=$hora." <br>";                
                                            endforeach;
                                        endif;
                    ?>
                    {
                            "nombre":"<?php echo $rs['sucursal_nombre'];?>", 
                            "lat":<?php echo $mapa[0]; ?>, "lng": <?php echo $mapa[1]; ?>, 
                            "info": "<p style='padding:0; margin:0; text-align:center;'><b><?php echo $rs['sucursal_nombre'];?>:</b> <?php echo $rs['sucursal_direccion'];?></p>",
                            "img": 'images/icomapa.png'
                    },
                  <?  
                      endforeach; 
                  ?>
            ];
    </script>
</div>

<script type="text/javascript">
    
</script>
<?php
    include("inc/footer.php");
?>

 <div id="scrollToTop" class="scrollToTop mbr-arrow-up">
    <a style="text-align: center;"><i class="mbr-arrow-up-icon mbr-arrow-up-icon-cm cm-icon cm-icon-smallarrow-up"></i></a>
</div>
    <!-- <input name="animation" type="hidden"> -->
  </body>
</html>