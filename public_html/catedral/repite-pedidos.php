<?php
    require_once('inc/config.php');
        header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
    header("Expires: Sat, 1 Jul 2000 05:00:00 GMT"); // Fecha en el pasado
    if(!Clientes::login()):
        header("Location:productos.php");
        exit;  
    endif;
    if(haveRows($_SESSION['carrito'])){
        header("Location:productos.php");
        exit;
    }

    $session = $_SESSION['cliente'];
    $cliente_id = $_SESSION['cliente']['cliente_id'];

?>
<!DOCTYPE html>
<html  >
<head>
  <? include("inc/head.php")?>  
  <title>Catedral</title>
  <link rel="stylesheet" href="css/font-awesome.min.css">

  <style type="text/css">
        .item{border: 1px solid #d3d3d3; border-radius: 5px;padding: 0; margin-left: 20px;}
        .cid-scEieb16NW{ padding-top: 0; }

        .btn-default {
            color: #333;
            background-color: #fff;
            border-color: #ccc;
        }

        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .pull-left {
            float: left!important;
        }
        .pull-right {
            float: right!important;
        }
        .fa-trash-o{
            color: red;
            font-size: 22px;
        }
        a{
            color: #000
        }
        .count{width: 50%}

        .cid-scEieb16NW img, .cid-scEieb16NW .item-img {
            height: 120px;
        }
        .btn-primary, .btn-primary:active {
            background-color: #0f3b84 !important;
            border-color: #0f3b84 !important;
        }
        .pedidoFecha{
            background: #0f3b84;
            color: #fff;
            padding: 6px 23px;
        }
        .btnVer{
            margin: 0;
            padding: 3px 20px;
        }

        @media screen and (max-width: 561px) {
            .btnVer{
                margin: 0;
                padding: 3px 5px;
            } 
        }

    @media only screen and (max-width: 800px) {
        /* Force table to not be like tables anymore */
        #no-more-tables table,
        #no-more-tables thead,
        #no-more-tables tbody,
        #no-more-tables th,
        #no-more-tables td,
        #no-more-tables tr {
        display: block;
        }
         
        /* Hide table headers (but not display: none;, for accessibility) */
        #no-more-tables thead tr {
        position: absolute;
        top: -9999px;
        left: -9999px;
        }
         
        #no-more-tables tr { border: 1px solid #ccc; }
          
        #no-more-tables td {
        /* Behave like a "row" */
        border: none;
        border-bottom: 1px solid #eee;
        position: relative;
        padding-left: 50%;
        white-space: normal;
        text-align:left;
        }
         
        #no-more-tables td:before {
        /* Now like a table header */
        position: absolute;
        /* Top/left values mimic padding */
        top: 6px;
        left: 6px;
        width: 45%;
        padding-right: 10px;
        white-space: nowrap;
        text-align:left;
        font-weight: bold;
        }
         
        /*
        Label the data
        */
        #no-more-tables td:before { content: attr(data-title); }
        }
</style>

</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW mb-5" id="content1-2y">


<div class="container">
    <div class="row">
                <div class="col-md-12 col-md-6 col-lg-12 mt-3 ">
                    <h2 class="pb-2">Tus compras recordadas son las siguientes</h2>
                </div>
                <div id="no-more-tables" class="col-md-12">
    <?
        //$contraentrega = Contraentrega::get("cliente_id =".$cliente_id." AND carrito_nombre IS NOT NULL ","contraentrega_timestamp DESC");
        $compra_recurrente = Compra_recurrente::get("cliente_id =".$cliente_id,"compra_id ASC");
        if(haveRows($compra_recurrente)){

    ?>
                    <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th class="center">Pedido</th>
                               
                                <th class="center">Cantidad de productos</th>
                                <th class="center"></th>
                                <th class="center"></th>



                            </tr>
                        </thead>
                        <tbody>
                            <?
                                foreach ($compra_recurrente as $result):

                                    //$contraentrega_detalle = Contraentrega_detalle::get("contraentrega_id = ".$result['contraentrega_id']);
                                    $compra_detalle = Compra_recurrente_detalle::get("compra_id = ".$result['compra_id']);
                                    $cantidad =  count($compra_detalle);
                                    $fecha = date('d/m/Y', strtotime($result['compra_timestamp']));

                                    #Verificar que todos los articulos estan disponibles
                                    $articulosTotal = Productos::articulos($result['compra_id']);
                                    $disponible = Productos::disponible($result['compra_id']);
                                    
                                    $ok = $articulosTotal[0]['articulos'] == $disponible[0]['articulos'] ? "1" : "0";
                                    //pr($ok);
                                    ?>
                            <tr>
                                <td class="center" data-title="Nombre"><?=$result['compra_nombre']?></td>
                                <td class="center" data-title="Nombre"><?=$cantidad?></td>

                              
                                <td class="center">
                                    <? if($ok === "1"){?>
                                    <a href="javascript:;" class="btn btnVer btn-primary repite-pedido" rel="<?php echo $result['compra_id']; ?>">Repetir compra
                                        <i class="fa fa-shopping-cart ml-2"></i>
                                    </a>
                                    <?  
                                        }else{
                                            ?>
                                            <a href="detalle-pedido/pedidoNro<?=$result['compra_id']?>" class="btn btnVer btn-primary">
                                                No todos los articulos estan disponibles<i class="fa fa-chevron-right ml-2"></i>
                                            </a>
                                            <?
                                        }
                                    ?>
                                </td>
                                <td class="center">
                                    <a href="detalle-pedido/pedidoNro<?=$result['compra_id']?>" class="btn btnVer btn-primary">
                                        Detalles<i class="fa fa-chevron-right ml-2"></i>
                                    </a>
                                </td>
                            </tr>
                                    <?
                                endforeach;
                            ?>

                        </tbody>
                    </table>
    <?
        }else{
            echo "<div class='space'><p>No se ha encontrado pedidos recientes</p></div>";
        }
    ?>
                </div>
            </div>
    </div>



<!-- TEST END -->
</section>

<!-- FOOTER -->
<? require_once('inc/footer.php'); ?>


  </body>


</html>