<?php

session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
}

include "funcionesProyecto.php";

$product = "";
$precio = "";
$product = $_REQUEST['menosC'];
global $conexion;

$existe = "SELECT `nombreP` FROM `carro` WHERE `nombreP` = '$product' AND `nombreU` = '$email';"; 
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            $masProducto = "SELECT `cantidad` FROM `carro` WHERE `nombreP` = '$product' AND `nombreU` = '$email';";
            if($valido= $conexion->query($masProducto)){ //comprobamos si el producto existe en el carro
                if($valido->num_rows > 0 ){
                    while($registro = $valido->fetch_assoc()){
                        $newCantidad = $registro["cantidad"];
                    }
                }
            }
            $newCantidad -= 1;
            if ($newCantidad == 0) {
                $borrado= "DELETE FROM `carro` WHERE `nombreP` = '$product' AND `nombreU` = '$email';";
                $conexion->query($borrado);
            }else{
                $addPro = "UPDATE `carro` SET `cantidad`='$newCantidad' WHERE `nombreP` = '$product'AND `nombreU` = '$email'; ";
                if ($conexion->query($addPro) === TRUE) {
                    //echo "Producto eliminado";
                } else {
                    echo "No se pudo eliminar el producto: " . $addPro . "<br>";
                }
                $conexion->close();
            }
        }
    }
