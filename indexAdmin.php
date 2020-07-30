<?php
include "funcionesProyecto.php";
session_start();
$name="";
$resul = "";
$error="";
$nombreP ="";
$inicio = 0;
$proximo =0;
$nuevoPrecio = "";
$paginacion = "";
$hiden = 0;
$nuevoProducto="";
$nuevoProducto = tablaNuevoProduct();
$modificarProducto = modificarDatos();
$mostrar = "todo";
$tablaProductos="";
if (isset($_COOKIE['nombre'])) {
    $name = $_COOKIE['nombre'];
}

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; 
 }else{
     header('location: loginTienda.php');
 }

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if (isset($_POST['close'])) {
        cerrarSession($name);
    }
    if (isset($_POST['modificarPrecioPro'])) {
        if (isset($_POST['nombreModificar']) && $_POST['nombreModificar']!="elije") {
            $nombreP = $_POST['nombreModificar'];
           if (isset($_POST['nuevoPrecio'])) {
                $nuevoPrecio = $_POST['nuevoPrecio'];
                //echo $nombreP."!".$nuevoPrecio;
                modificarPrecio($nuevoPrecio,$nombreP);
           }else{
               $error = "Debe introducir un precio.";
           }
        }else{
            $error = "Debe elegir un producto.";
        }
    }
    if (isset($_POST['agregar'])) {
        if (isset($_POST['tipo'])  && $_POST['tipo'] != "") {
            $tipo = $_POST['tipo'];
        }else{
            $error.= "no ha elegido un tipo para el producto<br> ";
        }
        if (isset($_POST['nameProducto']) && $_POST['nameProducto'] != "") {
            $nameProducto = $_POST['nameProducto'];            
        }else{
            $error.= "no ha añadido un nombre para el producto<br> ";
        }
        if (isset($_POST['precio']) && $_POST['precio'] != "") {
            $precio = $_POST['precio'];
        }else{
            $error.= "no ha añadido un precio para el producto<br> ";
        }
        if (isset($_POST['img']) && $_POST['img'] != "") {
            $img = $_POST['img'];
        }else{
            $error.= "no ha añadido una imagen<br>";
        }
        if ($error == "") {
            $resul = agregarNuevoProducto($nameProducto,$precio,$tipo,$img);
        }
        
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ElectronicStation</title>
    <script>
    //este es el lugar para poner ajax
    
    
    function mostrarDBAdmin2(valor,pag){  // funcion de ajax que muestra los productos al admin
        //document.write(valor);
        if (valor.length == 0) {
            document.getElemenById("resultado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultado").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "mostrarAjaxAdminPagi.php?valor="+valor+"&pag="+pag, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }

     function siguiente(valor){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        var todo = "Todo";
        if (valor.length == 0) {
            document.getElemenById("resultado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resultadoAjax = document.getElementById("resultado").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2(todo,resultadoAjax),15);
                }
            };
            xmlhttp.open("GET", "siguiente.php?valor="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
    
    function anterior(valor){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        var todo = "Todo";
        if (valor.length == 0) {
            document.getElemenById("resultado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var resultadoAjax = document.getElementById("resultado").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2(todo,resultadoAjax),15);
                }
            };
            xmlhttp.open("GET", "anterior.php?valor="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
    
    function borrarProducto(valor){  // funcion de ajax que muestra los productos al admin
        //document.write(valor);
        if (valor.length == 0) {
            document.getElemenById("resultadoBorrado").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultadoBorrado").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2("Todo"),20);
                }
            };
            xmlhttp.open("GET", "ajaxBorrarProducto.php?valorBorrar="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }

    function modificar(valor,valor2){  // funcion de ajax que muestra los productos al admin
        //document.write(valor+"|"+valor2);
        if (valor.length == 0) {
            document.getElemenById("resultadoModificar").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultadoModificar").innerHTML = this.responseText;
                setTimeout(mostrarDBAdmin2("Todo"),20);
                }
            };
            xmlhttp.open("GET", "ajaxModificarProducto.php?nombreModi="+valor+"&precioModi="+valor2, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
</script>
</head>
<body onload="mostrarDBAdmin2('Todo',0)" background="imgEmpresa/fondo.jpg"><!--  onload="mostrarDBAdmin2('Todo',0)" -->
    <?php 
    if ($name != "") {
        echo "<div class='page-header' style='vertical-align:middle; width:100%; background-image:url(\"imgEmpresa/back2.jpeg\"); text-align:left; font-family:fantasy; font-size:30px; height:150px; position:fixed; top:0;'>";
            echo "<div class='row' style='width:100%;'>" ;
                echo "<div class='col-4' style='margin-top:40px; margin-bottom:10px; margin-left:35px;' >Welcome ".$name."</div>";
                echo "<div class='d-none d-sm-none d-md-none d-lg-block offset-6' style='margin-top:35px; margin-bottom:10px;'><img src='imgEmpresa/logoSaul.png'  style='width:80px; height:80px; float:right;'></div>";
            echo "</div>";
        echo "</div>";
        echo "<div style='height:150px;'></div>";
    }
    echo "<form action='' method='post'>";
    echo "<input type='submit' value='Cerrar Sesión' name='close' class='btn btn-primary' style='margin-left:90px; margin-top:10px; margin-bottom:10px; font-family:fantasy;'>";
    echo "</form>";
    //echo $tablaProductos;
    if ($resul != "") {
        echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px;'>".$resul."</h4>";
    }
    
    
    if ($nuevoProducto!="") {
        echo $nuevoProducto;
    }
    if ($modificarProducto!="") {
        echo $modificarProducto;
    }

    if ($error != "") {
        echo "<div class='error'><h5 style='font-family:fantasy; margin-left:20px;'>".$error."</h5></div>";
    }

    ?>
    <span id="resultadoBorrado"></span>
    <span id="resultadoModificar"></span>
    <span id="resultado"></span>

    <div style="height:80px;"></div> <!-- estructura -->
        <footer class="page-footer" style="background-color:black; height:80px; color:#F3F2BE; width:100%; position:fixed; bottom:0;">
            <div class='row' style="width:100%;">
                <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"  style="text-aling:center;  width:auto;"><p style="margin-top:20px; margin-left:20px; font-size:14px;">Copyright© 2020 ElectronicStation</p></div>
                <div class="d-none d-sm-block col-md-4 col-lg-4"  style=" text-aling:center; width:auto;"><h3 style="margin-top:20px; margin-bottom:20px; vertical-align:middle; margin-left:43px; float:right;">ElectronicStation</h3></div>
                <div class="d-none d-sm-block col-md-4 col-lg-4"  style=" vertical-align:middle;  width:auto; float:;">
                    <div class="float-right" style="margin-top:20px; margin-right:5px; font-size:14px;"><a href="https://www.facebook.com/profile.php?id=100010020752148"><img src='imgEmpresa/faceboock.png'  style='width:30px; height:30px; border-radius:20px;'></a></div>
                    <div class="float-right" style="margin-top:20px; margin-right:5px; font-size:14px;"><a href="https://twitter.com/ElecStreaming"><img src='imgEmpresa/twitter.png'  style='width:30px; height:30px; border-radius:20px;'></a></div>
                    <div class="float-right" style="margin-top:20px; margin-right:5px; font-size:14px;"><a href="http://electronicstreaming.blogspot.com/"><img src='imgEmpresa/blogicon.png'  style='width:30px; height:30px; border-radius:20px;'></a></div>
                </div>
            </div>
        </footer>
    
</body>
</html>