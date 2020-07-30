<?php

session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

include "funcionesProyecto.php";

$product = "";
$precio = "";
$product = $_REQUEST['masC'];
global $conexion;

$existe = "SELECT `nombreP` FROM `carro` WHERE `nombreP` = '$product' AND `nombreU` = '$email';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            $masProducto = "SELECT `cantidad` FROM `carro` WHERE `nombreP` = '$product' AND `nombreU` = '$email';;";
            if($valido= $conexion->query($masProducto)){ //comprobamos si el producto existe en el carro
                if($valido->num_rows > 0 ){
                    while($registro = $valido->fetch_assoc()){
                        $newCantidad = $registro["cantidad"];
                    }
                }
            }
            $newCantidad += 1;
            $addPro = "UPDATE `carro` SET `cantidad`='$newCantidad' WHERE `nombreP` = '$product' AND `nombreU` = '$email';;";
            if ($conexion->query($addPro) === TRUE) {
                //echo "Producto añadido";
            } else {
                echo "No se pudo añadir: " . $addPro . "<br>";
            }
            $conexion->close();
        }else{
            $cargarPrecio = "SELECT `precio` FROM `productos` WHERE `nombre` = '$product';";
            if($valido= $conexion->query($cargarPrecio)){ //recogemos el nombre del user 
                if($valido->num_rows > 0 ){
                    while($registro = $valido->fetch_assoc()){
                        $precio = $registro["precio"];
                    }
                }
            }
            $addPro = "INSERT INTO `carro` (`nombreU`, `nombreP`, `precioP`, `cantidad`, `idcarro`) VALUES ('$email', '$product', '$precio', '1', NULL);";
            if ($conexion->query($addPro) === TRUE) {
                //echo "Producto añadido";
            } else {
                echo "No se pudo añadir: " . $addPro . "<br>";
            }
            $conexion->close();
        }
    }


