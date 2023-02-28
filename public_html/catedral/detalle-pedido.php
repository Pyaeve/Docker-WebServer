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
    $id = param('id');
    $id = str_replace("pedidoNro", "", $id);
    if(!$id){
        header("Location:../mis-pedidos.php");
        exit;  
    }

    //$contraentrega_detalle = Contraentrega_detalle::get("contraentrega_id = ".$id);
    $contraentrega_detalle = Compra_recurrente_detalle::get("compra_id = ".$id);

    if(!haveRows($contraentrega_detalle)){
        header("Location:../mis-pedidos.php");
        exit;  
    }

    $contraentrega = Compra_recurrente::select($id);
    $fecha = date('d/m/Y', strtotime($contraentrega[0]['compra_timestamp']));
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
        #content1-2y{
            padding: 0;
        }
        .cf{
            margin: 23px 0;
        }
        .fa{
            padding-left: 5px;
        }
</style>

</head>
<body>
<header class="">
    <?php require_once('inc/header.php'); ?>     
    <?php //require_once('inc/nav.php'); ?>
</header> 
<!-- PRODUCTOS GALERIA -->
<section class="content1 cid-scEieb16NW" id="content1-2y">


<div class="container">
    <div class="row">

        <div class="col-md-6 col-lg-12 mt-3">           
            <h2>Detalles del pedido</h2>
            <p class="pt-2">Pedido Nro: <b><?=$id?></b>  Fecha: <b><?=$fecha?></b></p>
      
            <table class="col-sm-12 table-bordered table-striped table-condensed cf">
                <thead class="cf">
                    <tr>
                        <th class="center">PRODUCTOS </th>
                        <th class="center">CODIGOS</th>
                        <th class="center">CANTIDAD</th>
                        <th ></th>
                    </tr>
                </thead>
                <?
                
                     foreach ($contraentrega_detalle as $cd) {
                        $codigo = Productos::select($cd['producto_id']);

                        ?>
                <tr>
                    <th class="center" data-title="PRODUCTOS" ><?=$cd['producto_nombre']?></th>
                    <th class="center" data-title="CODIGOS"><?=$codigo[0]['producto_codigo']?></th>
                    <th class="center" data-title="TOTAL"><?=number_format( $cd['detalle_cantidad'],0,"",".")?></th>
                    <th class="center" data-title="">
                        <?
                        if($codigo[0]['producto_stock'] > 0 AND $codigo[0]['producto_status'] == 1):
                        ?>
                        <a href="javascript:;" class="btn btnVer btn-primary item_add" rel="<?php echo $codigo[0]['producto_id']; ?>">
                            <span class="d-none d-sm-none d-md-block">Agregar</span>
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                        </a>
                        <?
                        else:
                            ?>
                        <a href="javascript:;" class="btn btnVer btn-primary">
                            <span class="d-none d-sm-none d-md-block">No Disponible</span>
                        </a>
                            <?
                        endif;
                        ?>
                    </th>
                </tr>
                        <?
                     }
                ?>
            </table>
        </div>
        <div class="col-md-6 col-lg-6 mt-3">
            <a href="repite-pedidos" class="btn btnVer btn-primary" style="padding: 13px 30px; margin: 0 0 20px 0;">
                <span class="d-none d-sm-none d-md-block">Volver</span>
                <i class="fa fa-undo" aria-hidden="true"></i>
            </a>
        </div>
        <div class="col-md-6 col-lg-6 mt-3">  </div>
    </div>
</div>
 
</section>

<!-- FOOTER -->
<? require_once('inc/footer.php'); ?>


  </body>


</html>