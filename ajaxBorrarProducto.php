<?php
include "funcionesProyecto.php";
global $conexion;
$product = "";
$product = $_REQUEST['valorBorrar'];

$cargar = "DELETE FROM `productos` WHERE `nombre` = '$product';";
//echo $cargar;
$conexion->query($cargar);

echo "Producto borrado correctamente";