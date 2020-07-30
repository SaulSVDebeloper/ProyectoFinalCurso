<?php

include "funcionesProyecto.php";
$mostrar = "";
$num=4;
$precio="";
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
        $tipoProducto =desplegableTipoProductoAjaxDBAdmin(); //creamos el desplegable para el admin
            $xml = "productos.xml";
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='3' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Productos de la Tienda</h3></th><th colspan='2' style='background-color:black; vertical-align:middle;'>".$tipoProducto." </th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'>NOMBRE</td><td style='text-align:center; vertical-align:middle;'>PRECIO</td><td style='text-align:center; vertical-align:middle;'>IMAGEN</td><td style='text-align:center'>ELIMINAR PRODUCTO</td></tr>";
            while($registro = $valido->fetch_assoc()){
                $nombre = $registro['nombre'];
                $img = $registro['imagen'];
                $precio=$registro['precio'];
                $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$registro['nombre'].":</td><td style='text-align:center; vertical-align:middle;'>".$registro['precio']." €</td><td><img src='imgProductos/".$img.".png' width='150' height='150'/></td><td style='text-align:center; vertical-align:middle;'><input type='submit' value='Quitar Producto' class='btn btn-primary' onclick=\"borrarProducto('$nombre');\" style='font-family:fantasy;'></td></tr>";
                $cont++;
            }
            $resul.= "<tr><td colspan='4' style='text-align:center; vertical-align:middle;'><input type='submit' value=' Anterior ' class='btn btn-primary' onclick=\"anterior('$pagina');\">";
            $resul.= " --- ";
            $resul.= "<input type='submit' value=' Siguiente ' class='btn btn-primary' onclick=\"siguiente('$pagina');\"></td></tr>";
            $resul .= "</table>";
            $resul.= "<br><br>";
            echo $resul;

        }else{
            $cargar = "SELECT * FROM `productos`";
            $valido= $conexion->query($cargar);
            $tipoProducto = desplegableTipoProductoAjaxDBAdmin();//creamos el desplegable para el admin
            $xml = "productos.xml";
   
            $resul .= "<table class='table table-striped' style='text-align:center; font-family:fantasy;'>";
            $resul .= "<tr><th colspan='3' style='font-family:fantasy; color:#F3F2BE; font-size:25px; background-color:black; font-family:stretch;'><h3>Productos de la Tienda</h3></th><th colspan='2' style='background-color:black; vertical-align:middle;'>".$tipoProducto." </th></tr>";
            $resul .= "<tr><td style='text-align:center; vertical-align:middle;'>NOMBRE</td><td style='text-align:center; vertical-align:middle;'>PRECIO</td><td style='text-align:center; vertical-align:middle;'>IMAGEN</td><td style='text-align:center'>ELIMINAR PRODUCTO</td></tr>";
            while($registro = $valido->fetch_assoc()){
                $img = $registro['imagen'];
                $nombre = $registro['nombre'];
                $precio=$registro['precio'];
                $tipo = $registro["categoria"];
                //echo "|".$tipo;
                if ($tipo == $mostrar) {
                    $resul.="<tr><td style='text-align:center; vertical-align:middle;'>".$registro['nombre'].":</td><td style='text-align:center; vertical-align:middle;'>".$registro['precio']." €</td><td><img src='imgProductos/".$img.".png' width='150' height='150'/></td><td style='text-align:center; vertical-align:middle;'><input type='submit' value='Quitar Producto' class='btn btn-primary' onclick=\"borrarProducto('$nombre');\" style='font-family:fantasy;'></td></tr>";
                    $cont++;
                }
            }
            $resul .= "";
            $resul .= "</table>";
            echo $resul;
        }
    }
}