<?php
    require_once('inc/config.php');
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
        .cf{
            
        }
  </style>
  <style type="text/css">
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
<section class="content1 cid-scEieb16NW" id="content1-2y" style="">


<div class="container">
    <div class="row">
                <div class="col-md-12 col-md-6 col-lg-12 mt-3 ">
                    <h2 class="pb-2">Historial de Pedidos</h2>
                </div>
                <div id="no-more-tables" class="col-md-12">
    <?
        //$contraentrega = Contraentrega::get("cliente_id =".$cliente_id,"contraentrega_timestamp DESC");
        $contraentrega = Contraentrega::getList("contraentrega_status IN (1,2,3) AND cliente_id =".$cliente_id,"contraentrega_timestamp DESC");
        if(haveRows($contraentrega)){
    ?>
                    <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th class="center">Pedido Nro</th>
                                <th class="center">Fecha</th>
                                <th class="center">Estado</th>
                                <th class="center">Monto Total</th>
                                <th class="center">Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?
                                foreach ($contraentrega as $result):

                                    $contraentrega_detalle = Contraentrega_detalle::get("contraentrega_id = ".$result['contraentrega_id']);
                                    foreach ($contraentrega_detalle as $rs) {
                                       $monto+= $rs['detalle_monto'];
                                    }
                                    $fecha = date('d/m/Y', strtotime($result['contraentrega_timestamp']))
                                    ?>
                            <tr>
                                <td class="center" data-title="Pedido Nro">#<?=$result['contraentrega_id']?></td>
                                <td class="center" data-title="Fecha"><?=$fecha?></td>
                                <!--<td class="center" data-title="Estado">Procesado</td>-->
                                <?php 
                                    switch ($result['contraentrega_status']) { 
                                        case '1':
                                            echo '<td class="center" data-title="Estado">Pendiente</td>';
                                        break;
                                        case '2':
                                            echo '<td class="center" data-title="Estado">Pagado</td>';
                                        break;
                                        case '3':
                                            echo '<td class="center" data-title="Estado">Anulado</td>';
                                        break;
                                    }
                                ?>
                                <td class="center" data-title="Monto Total">Gs <?=number_format( $monto,0,"","."); $monto = 0;//resetea la variable monto?></td>
                                <td class="center" data-title="Detalles">
                                    <a href="detalle-pedido-historial/pedidoNro<?=$result['contraentrega_id']?>" class="btn btnVer btn-primary">Ver<i class="fa fa-chevron-right ml-2"></i></a>
                                </td>
                            </tr>
                                    <?
                                endforeach;
                            ?>

                        </tbody>
                    </table>
    <?
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