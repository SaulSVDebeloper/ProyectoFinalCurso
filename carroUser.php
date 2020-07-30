<?php
include "funcionesProyecto.php";
session_start();
$error = "";
$resul = "";
$name = "";
$mostrarCarro = "";

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email']; 
}else{
    header('location: loginTienda.php');
}

if (isset($_SESSION['nombre'])) { //utilizamos la cookie para poder movernos entre el carro y la tienda
    $name = strtoupper($_SESSION['nombre']);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if (isset($_POST['volver'])) {
        header("location: index.php");
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,user-scalable=no initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ElectronicStation</title>
    <script>
        function añadirCarrito(valor){  //funcion de ajax que muestra los productos a los usuarios
            //document.write(valor);
            if (valor.length == 0) {
                document.getElemenById("resultadoAñadir").innerHTML=""; //iguala la variable a vacio
                return; //devuelve vacio
            }else{
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("resultadoAñadir").innerHTML = this.responseText;
                    setTimeout(mostrarAjax("todo2"),20); //nos permite pasado un tiempo llamar a la funcion mostrar
                }
            };
            xmlhttp.open("GET", "añadirDentroCarro.php?masC="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
        }
    }
    function quitarCarrito(valor){  //funcion de ajax que muestra los productos a los usuarios
        //document.write(valor);
        if (valor.length == 0) {
            document.getElemenById("resultadoQuitar").innerHTML=""; //iguala la variable a vacio
            return; //devuelve vacio
        }else{
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("resultadoQuitar").innerHTML = this.responseText;
                    setTimeout(mostrarAjax("todo2"),20); //nos permite pasado un tiempo llamar a la funcion mostrar
                }
            };
            xmlhttp.open("GET", "quitarDentroCarroDB.php?menosC="+valor, true);
            xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
            }
                
        }
        
        function mostrarAjax(){  //funcion de ajax que muestra los productos a los usuarios
            //document.write("hola");
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("mostrar").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "mostrarCarroAjax.php", true);
                xmlhttp.send(); //send() no retornará hasta que reciba la respuesta
            
        }
        function pagar(valor){  //funcion de ajax que muestra los productos a los usuarios
                var pagado = confirm("Seguro que decea pagar")
                if (pagado == true) {
                    var xmlhttp = new XMLHttpRequest();
                    xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("nada").innerHTML = this.responseText;
                        setTimeout(window.location='index.php',20);
                        }
                    };
                    xmlhttp.open("GET", "historicoCompra.php?email="+valor, true);
                    xmlhttp.send();
                }
        }
    </script>
</head>
<body onload="mostrarAjax()" background="imgEmpresa/fondo.jpg">
    <?php
        echo "<div class='page-header' style='vertical-align:middle; width:100%; background-image:url(\"imgEmpresa/back2.jpeg\"); text-align:left; font-family:fantasy; height:150px; font-size:30px;'>";
        echo "<div class='row'>" ;
        echo "<div class='col-4' style='margin-top:50px; margin-bottom:10px; margin-left:20px;' >Welcome ".$name."</div>";
        echo "<div class='col-2 offset-5' style='margin-top:35px; margin-bottom:10px;'><img src='imgEmpresa/logoSaul.png'  style='width:80px; height:80px; float:right;'></div>";
        echo "</div>";
        echo "</div>";
    ?>   
        <?php
            if ($mostrarCarro != "") {
                //echo $mostrarCarro;
            }
            if ($error != "") {
                echo $error;
            }
            if ($resul != "") {
                echo $resul;
            }
        ?>
    </div>
    <span id="mostrar"></span> 
    <span id="nada"></span> 
    <span id="resultadoAñadir"></span> 
    <span id="resultadoQuitar"></span>
</body>
</html>