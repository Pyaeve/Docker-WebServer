<?php 
    include('inc/config.php');
    
     $productos = Productos::productoImagen();

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <table border="1">
        <tr>
            <td>Producto Codigo</td>
            <td>Producto Nombre</td>
        </tr>
        <?
            echo count($productos);
            foreach ($productos as $rs) {
                echo "<tr><td>".$rs['producto_codigo']."</td><td>".$rs['producto_nombre']."</td></tr>";
            }
        ?>
    </table>
</body>
</html>