<?php
include "funcionesProyecto.php";
session_start();
$name="";
$resul="";
$mostrar = "";
$tablaProductos="";

if (isset($_SESSION['nombre'])) {
    $nombreUser = $_SESSION['nombre'];
    $_SESSION['nombre'] = $nombreUser;
}

if (isset($_COOKIE['nombre'])) {
    $name = strtoupper($_COOKIE['nombre']);
}
if (isset($_SESSION['email'])) {
   $email = $_SESSION['email']; 

}else{
    header('location: loginTienda.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if (isset($_POST['close'])) {   //si el user cierra secion
        cerrarSession($name); 
    }
    if (isset($_POST['miCaro'])) { //el user puede ver su carro
        $nombreCarro = strtolower($name);
        $comprobar = comprobarCarro($email);
        if ($comprobar) {
            header("location: carroUser.php");
        }else{
            $resul .= "No tienes nada en el carrito<br>";
        }
    }
}


function siguiente($pagina){  //funcion de ajax que muestra los productos a los usuarios
    $pagina  = $pagina+4;
    return $pagina;
}

function anterior(){
    $pagina = $pagina-4;
    return $pagina;
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

    function mostrarDBpag(valor,valor2){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        //alert(valor+"|"+valor2);

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
            xmlhttp.open("GET", "mostrarAjaxDBUserPagi.php?valor="+valor+"&pag="+valor2, true);
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
                setTimeout(mostrarDBpag(todo,resultadoAjax),15);
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
                setTimeout(mostrarDBpag(todo,resultadoAjax),15);
                }
            };
            xmlhttp.open("GET", "anterior.php?valor="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
    

    function añadirCarro(valor){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        if (valor.length == 0) {
            document.getElemenById("resultadoAñadir").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("resultadoAñadir").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "ajaxAñadirCarroDB.php?masC="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
</script>  
</head>
<body onload="mostrarDBpag('Todo',0)" background="imgEmpresa/fondo.jpg" > <!-- llamamos a la funcion de ajax para que nada mas cargar cargue todo los productos -->
    
        <?php 
            if ($name != "") {
                echo "<div class='page-header' style='vertical-align:middle; width:100%; background-image:url(\"imgEmpresa/back2.jpeg\"); text-align:left; font-family:fantasy; font-size:30px; height:150px;  position:fixed; top:0;'>";
                    echo "<div class='row' style='width:100%;'>" ;
                        echo "<div class='col-4' style='margin-top:40px; margin-bottom:10px; margin-left:35px;' >Welcome ".$name."</div>";
                        echo "<div class='d-none d-sm-none d-md-none d-lg-block offset-6' style='margin-top:35px; margin-bottom:10px;'><img src='imgEmpresa/logoSaul.png'  style='width:80px; height:80px; float:right;'></div>";
                    echo "</div>";
                echo "</div>";
                echo "<div style='height:150px;'></div>";
            }
            if ($resul!="") {
                echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px;'>".$resul."</h4>";
            }
        ?>
       <!--  <div class="container" style="width:100%; background-color:black; margin-top:10px; "> -->
            <br>
            <form action="" method="post">
                <input type="submit" value="Cerrar Sesión" name="close" class="btn btn-primary" style="margin-left:20px;">
                <input type="submit" value="Mi Carro" name="miCaro" class="btn btn-primary">
                <br><br>
            </form>
        <!-- </div> -->
    
        <div class="page-body">
            <div class="divUser">
                <?php //echo $tablaProductos; ?>
                <span id="resultadoAñadir"></span> 
                <span id="resultadoQuitar"></span>
                <span id="resultado"></span>
            </div>
        </div>
        <br><br>
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