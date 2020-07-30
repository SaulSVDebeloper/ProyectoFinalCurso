<?php

include "funcionesProyecto.php";
session_start();
global $conexion;
$total =0;
$cantidadPro=0;
$precioPro=0;

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; 
}

$cargar = "SELECT * FROM `carro` WHERE `nombreU` = '$email';"; //recogemos los datos del user que tiene introducidos dentro del carro

$resul = "";
$cont = 0;
$resul.= "<table class='table table-striped' style='font-family:fantasy; text-align:center;'>";
$resul.= "<tr><th>Modelo</th><th>Precio</th><th>Cantidad</th><th>Añadir</th><th>Quitar</th></tr>";    //
if($valido= $conexion->query($cargar)){ //recogemos el nombre del user 
    if($valido->num_rows > 0 ){
        while($registro = $valido->fetch_assoc()){ //mostramos los datos del carro de casa user y el total a pagar
            $cantidadPro=$registro['cantidad'];
            $precioPro=$registro['precioP'];
            $precioCantidad=$precioPro*$cantidadPro;
            $total+=$precioCantidad;
            $nombreProducto = $registro['nombreP'];
            $resul.="<tr><td>".$registro['nombreP']."</td><td>".$registro['precioP']."</td><td>".$registro['cantidad']."</td><td><input type='submit' value='Agregar' onclick=\"añadirCarrito('$nombreProducto');\" class='btn btn-primary'></td><td><input type='submit' value='Quitar' onclick=\"quitarCarrito('$nombreProducto');\" class='btn btn-primary'></td></tr>";
        }
    }
}
$resul.="<tr><td style='font-size:25px;'>Total a pagar: </td><td colspan='2' style='font-size:25px; text-align:left;'>".$total." €</td></tr>";
$resul.="</table>";
$resul.="<form action='' method='post'><input type='submit' value='Volver' name='volver' class='btn btn-primary' style='margin-left:10px;'></form> <br>";
$resul.=" <input type='submit' value='Pagar' class='btn btn-primary' onclick=\"pagar('$email');\" style='margin-left:10px;'>";
echo $resul;
    

