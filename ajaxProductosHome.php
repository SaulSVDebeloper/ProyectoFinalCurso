<?php

include "funcionesProyecto.php";
$mostrar = "";
$num=4;
$img ="";
$mostrar= $_REQUEST['valor'];
//echo $mostrar."*";
if (isset($_REQUEST['pag']) && ($_REQUEST['pag'] != 0)) {
    $pagina= $_REQUEST['pag'];
}else{
    $pagina = 0;
}
/* echo $mostrar."|";
echo $pagina; */

global $conexion;
$cargar = "SELECT * FROM `productos` LIMIT $pagina, 3;";

$resul = "";
$cont = 0;
$tipoProducto ="";
if($valido= $conexion->query($cargar)){ //recogemos el nombre del user 
    if($valido->num_rows > 0 ){
        if ($mostrar == "Todo" || $mostrar == "Elija Tipo" || $mostrar == "") {
        $tipoProducto =desplegableTipoProductoAjaxDB(); //creamos el desplegable para el admin
            $xml = "productos.xml";
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='2' style='color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch; text-align:center;'><h3>Productos de la Tienda</h3></th><th style='background-color:black; vertical-align:middle;'>".$tipoProducto." </th></tr>";
            $resul .= "<tr><td style='vertical-align:middle; font-family:fantasy;'>NOMBRE</td><td style='vertical-align:middle; font-family:fantasy;'>PRECIO</td><td style='vertical-align:middle; font-family:fantasy;'>IMAGEN</td></tr>";
            while($registro = $valido->fetch_assoc()){
                $nombre = $registro['nombre'];
                $img = $registro['imagen'];
                $resul.="<tr><td style='vertical-align:middle; font-family:fantasy;'>".$registro['nombre'].":</td><td style='vertical-align:middle; font-family:fantasy;'>".$registro['precio']." €</td><td><img src='imgProductos/".$img.".png' width='150' height='150'></td></tr>";
                $cont++;
            }
            $resul .= "</table>";
            $resul .= "<div style='text-align:center'>";
            $resul.= "<input type='submit' value=' Anterior ' class='btn btn-primary' onclick=\"anterior('$pagina');\" style='font-family:fantasy;'> ";
            $resul.= " --- ";
            $resul.= "<input type='submit' value=' Siguiente ' class='btn btn-primary' onclick=\"siguiente('$pagina');\" style='font-family:fantasy;'> ";
            $resul.= "</div>";
            echo $resul;

        }else{

            $cargar = "SELECT * FROM `productos`";
            $valido= $conexion->query($cargar);
            $tipoProducto = desplegableTipoProductoAjaxDB();//creamos el desplegable para el admin
            $xml = "productos.xml";
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='2' style=' color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Productos de la Tienda</h3></th><th style='background-color:black; vertical-align:middle;'> ".$tipoProducto." </th></tr>";
            $resul .= "<tr><td style='font-family:fantasy;'>NOMBRE</td><td style='font-family:fantasy;'>PRECIO</td><td style='font-family:fantasy;'>IMAGEN</td></tr>";
            while($registro = $valido->fetch_assoc()){
                $img = $registro['imagen'];
                $nombre = $registro['nombre'];
                $tipo = $registro["categoria"];
                //echo "|".$tipo;
                if ($tipo == $mostrar) {
                    $resul.="<tr><td style='vertical-align:middle; font-family:fantasy;'>".$registro['nombre'].":</td><td style='vertical-align:middle; font-family:fantasy;'>".$registro['precio']." €</td><td><img src='imgProductos/".$img.".png' width='150' height='150'></td></tr>";
                    $cont++;
                }
            }
            $resul .= "</table>";
            echo $resul;
        }
    }
}