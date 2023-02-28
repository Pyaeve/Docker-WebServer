<?php
    include("inc/config.php");
    $productos = Productos::listing(9,pageNumber());
?>
<!DOCTYPE html>
<html  >
<head>
  <?php include("inc/head.php")?>  
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
<body class="bg-white">
<!-- header part start -->
    <header class="header-1 fixed-top" style="background: #f1f1f1;">
        <div class="mobile-fix-header">
        </div>
         <div class="container">
             <div class="row header-content ">
             <!--<div class="col-lg-3 col-6">
                <div class="left-part">
                    <p>free shipping on order over $99</p>
                </div>
            </div>
            <div class="col-lg-9 col-6">
                <div class="right-part">
                    <ul>
                        <li><a href="#">today's deal</a></li>
                        <li><a href="#">gift cards</a></li>
                        <li><a href="#">track order</a></li>
                        <li><a href="#">free shipping</a></li>
                        <li><a href="#">free & easy return</a></li>
                        <li>
                            <div class="dropdown language">
                                <div class="select">
                                    <span>English</span>
                                </div>
                                <input type="hidden" name="language">
                                <ul class="dropdown-menu">
                                    <li id="English">English</li>
                                    <li id="French">French</li>
                                    <li id="Spanish">Spanish</li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <div class="dropdown currency">
                                <div class="select">
                                    <span>USD</span>
                                </div>
                                <input type="hidden" name="currency">
                                <ul class="dropdown-menu">
                                    <li id="USD">USD</li>
                                    <li id="EUR">EUR</li>
                                    <li id="INR">INR</li>
                                    <li id="AUD">AUD</li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
           
            </div>
            -->
            </div>
            <div class="row header-content">
            <div class="col-12">
                <div class="header-section  ">
                    <!--   stiky menu    ---> 
                    <div class="brand-logo">
                        <a href="./"> <img src="assets/images/catedral.webp" height="48px" c alt="Farmacia y Perfumeria Catedral"></a>
                    </div>
                    <div class="search-bar">
                        <form action="{!! route('frontend.productos.buscar') !!}">
                           
                            <input name="q" class="search__input" type="text" placeholder="Ej Mentolina">    
                          

                            <button type="submit"  class="btn search-icon"  >
                        </form>
                    </div>
                    <div class="nav-icon">
                        <ul>
                           
                            <li class="onhover-div search-3">
                                <div onclick="openSearch()">
                                    <i class="ti-search mobile-icon-search" ></i>
                                    <img src="./assets/images/search.webp" class=" img-fluid search-img" alt="">
                                </div>
                                <div id="search-overlay" class="search-overlay">
                                    <div>
                                        <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
                                        <div class="overlay-content">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <form>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search a Product">
                                                            </div>
                                                            <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                           
                            <li class="onhover-div user-icon" onclick="OpenLoginModal()">
                                <img src="./assets/images/user.webp" alt="Farmacia y Perfumeria Catedral" class="user-img">
                                <i class="ti-user mobile-icon"></i>
                                <div class="wishlist icon-detail">
                                    <h6 class="up-cls"><a href="mi-cuenta"><span>Mi Cuenta</span></a></h6>
                                    <h6><a href="mi-cuenta">Iniciar</a></h6>
                                </div>
                            </li>
                            <li class="onhover-div cart-icon" "><a href="mi-carrito">
                                <img src="./assets/images/shopping-cart.webp" alt="Farmaicia y Perfumeria Catedral" class="cart-image">
                                <i class="ti-shopping-cart mobile-icon"></i></a>
                                <div class="cart icon-detail">
                                    <h6 class="up-cls"><span class="cart-item-count itemCartTotal"><?php echo $items_carrito; ?></span></h6>
                                   
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- menuu principal -->
    <div class=" navbar-catedral">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav id="main-nav">
                        <div class="toggle-nav">
                            <i class="ti-menu-alt"></i>
                        </div>
                        <ul id="main-menu" class="sm pixelstrap sm-horizontal">
                              <li>
                                <div class="mobile-back text-end">
                                    Cerrar<i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                                </div>
                            </li>
                            <li class="icon-cls">
                                <a href="./"><i class="fa fa-home home-icon" aria-hidden="true"></i>
                                </a>
                            </li>
                             <?php require_once('inc/navtop.php'); ?>
                          
                            
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /menu principal -->
</header>

<!-- Breadcrumbs -->
<!-- breadcrumb start -->
<section class="breadcrumb-section breadcrumb-catedral">
    <div class="container">
        <div class="row">

              <div class="col-md-6 col-lg-12 display-6 navi">
              
                
            
             
            </div>
        </div>
    </div>
</section>
<!-- breadcrumb End -->

<!-- /Breadcrumbs -->

<section class="map1 cid-sczwBedEaV" id="map1-1w" style="margin-top:0%;">
    <div class="container">
        <div class="mbr-section-head mb-4">
            <h3 class="mbr-section-title mbr-fonts-style align-center mb- display-2"><strong>Nuestras Sucursales</strong></h3>
        </div> 
        <div class="row">
            <div class="col-md-12 col-lg-3 ">
                <div class="flexsearch">
                    <div class="flexsearch--wrapper">
          
                        <form class="flexsearch--form" id="form_search_suc" method="post">
                            <div class="flexsearch--input-wrapper">
                                <input class="flexsearch--input" name="susursal" id="susursal" list="susursal" type="search" placeholder="Buscador de Sucursal">
                                <?php
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

                            <!-- <input class="flexsearch--submit" type="submit" value="➜">  -->
                            <label class="flexsearch--submit" id="btn_submit">➜</label>
                        </form>
                    </div>
                </div>

                <ul class="sucursal menuLocales scrollbar-primary" id="cajalinks">
                    <?php
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
                                <?  $datoshora = json_decode($rs['sucursal_horarios']);
                                    $telefonos = json_decode($rs['sucursal_tel']);
                                    if(haveRows($datoshora)):
                                        foreach ($datoshora as $hora):
                                            echo $hora." <br>";                
                                        endforeach;
                                    endif;
                                    
                                    if(haveRows($telefonos)):
                                        echo "Tel: ";
                                        foreach ($telefonos as $tel):
                                            echo $tel." <br>";                
                                        endforeach;
                                    endif;
                                ?>
                             </p>
                        </a>
                    </li>
                                <?php
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
    </div>
        
</section>

<script type="text/javascript" src="js/jquery-3.4.0.min.js"></script>
<script type="text/javascript" src="js/mood.js"></script>
<script type="text/javascript">
     
        $(function(){
           moodjs.googlemap('mapa', markers, 14, 0);
        });

        $( "#susursal" ).change(function() {
            var valor = $(this).val();
            console.log(valor);
           // var id = $("input[name=TypeList]")
            $.ajax({
                url : 'ajax/opcion',
                data: $('#form_search_suc').serialize(),
                type : 'post',
                dataType : 'json',
                success : function(data){
                   // console.log(data)
                    $('#cajalinks').html(data.html);
                }
            });
        });
        /**/
        $('#susursal').keypress(function(e) {
            //var keycode = (e.keyCode ? e.keyCode : e.which);
            var valor = $(this).val();
            /*if (keycode == '13') {
                Buscar();
                e.preventDefault();
                return false;
            }*/
            $.ajax({
                url : 'ajax/opcion',
                data: $('#form_search_suc').serialize(),
                type : 'post',
                dataType : 'json',
                success : function(data){
                   // console.log(data)
                    $('#cajalinks').html(data.html);
                }
            });
        }); 

       $( "#btn_submit" ).click(function() {
            var valor = $("#susursal").val();
            $.ajax({
                url : 'ajax/opcion',
                data: $('#form_search_suc').serialize(),
                type : 'post',
                dataType : 'json',
                success : function(data){
                    //console.log(data)
                    $('#cajalinks').html(data.html);
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
        var markers = [
              <?php  
                foreach ($sucursales as $rs):
                    $mapa = explode(",", $rs['sucursal_ubicacion']);
                    $horadata = json_decode($rs['sucursal_horarios']);
                    $telefonos = json_decode($rs['sucursal_tel']);
                    $horahtml ="";
                                    if(haveRows($horadata)):
                                        foreach ($horadata as $hora):
                                            $horahtml.=$hora." <br>";                
                                        endforeach;
                                    endif;
                                    
                                    if(haveRows($telefonos)):
                                        $horahtml.="Tel: ";
                                        foreach ($telefonos as $tel):
                                            $horahtml.=$tel." <br>";              
                                        endforeach;
                                    endif;
                                    
                ?>
                {
                        "nombre":"<?php echo $rs['sucursal_nombre'];?>", 
                        "lat":<?php echo $mapa[0]; ?>, "lng": <?php echo $mapa[1]; ?>, 
                        "info": "<p style='padding:0; margin:0; text-align:center;'><b><?php echo $rs['sucursal_nombre'];?>:</b> <?php echo $rs['sucursal_direccion'];?> <?=$horahtml?></p>",
                        "img": 'images/icomapa.png'
                },
              <?php  
                  endforeach; 
              ?>
        ];
</script>
<?php
    include("inc/footer.php");
?>