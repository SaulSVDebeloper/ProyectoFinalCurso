<?php
include "funcionesProyecto.php";
global $conexion;


if (isset($_COOKIE['nombre'])) { //utilizamos la cookie para poder movernos entre el carro y la tienda
    $name = strtoupper($_COOKIE['nombre']);
}

if (isset($_REQUEST['email'])) {
    $email = $_REQUEST['email'];
}else{
    $email = "";
}


$cargar = "SELECT * FROM `carro` WHERE `nombreU` = '$email';"; //recogemos los datos del user que tiene introducidos dentro del carro

if($valido = $conexion->query($cargar)){ //recogemos el nombre del user 
    if($valido->num_rows > 0 ){
        while($registro = $valido->fetch_assoc()){ //mostramos los datos del carro de casa user y el total a pagar
            $nombreProducto = $registro['nombreP'];
            $cantidadPro=$registro['cantidad'];
            añadir($name,$email,$nombreProducto,$cantidadPro);
            borrar($email);
        }
    }
}

function añadir($name,$email,$nombreProducto,$cantidadPro){
    global $conexion;
    $existe = "SELECT * FROM `historico` WHERE `cliente` = '$name';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            return "<u><b><font color ='red'>Compra ya existente</font></b></u>";
        }else{
            $conexionPro = new PDO('mysql:host=localhost; dbname=tienda', 'root', '');
            $conexionPro->exec("INSERT INTO `historico` (`cliente`, `producto`, `cantidad`, `idcompra`) VALUES ('$email', '$nombreProducto', '$cantidadPro', NULL)");
            return "Producto añadido correctamente";
        }
    }
    unset($conexionPro);
}

function borrar($email){
    global $conexion;
    $cargar2 = "DELETE FROM `carro` WHERE `nombreU` = '$email';";
    $conexion->query($cargar2);  
}


    