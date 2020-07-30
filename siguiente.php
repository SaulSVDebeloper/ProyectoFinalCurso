<?php

include "funcionesProyecto.php";

if (isset($_REQUEST['valor'])) {
    $pag= $_REQUEST['valor'];
    $inicio = $pag;
    $paginita = $inicio + 3;
    global $conexion;
    $cargar = "SELECT * FROM `productos`;";
    $resul = "";
    $tipoProducto ="";
    $valido= $conexion->query($cargar); //recogemos el nombre del user 
    $cantidad = $valido->num_rows; //cantidad 14 total productos (5 paginas)
    $cantidad= $cantidad /3;
    $cantidad = ceil($cantidad);
    $cantidad = $cantidad * 3;
    $cantidad = $cantidad - 3;
    if ($pag == $cantidad) {
        $pag = 0 ;
        echo $pag;
    }else{
        $pagina = $pag + 3;
        echo $pagina;
    } 
}