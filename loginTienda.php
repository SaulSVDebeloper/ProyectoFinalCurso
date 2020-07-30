<?php
include "funcionesProyecto.php";
$resul = "";
$resulvalida = "";
$error = "";
$logueado = ""; 
$aux = array();
$paginacion = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if (isset($_POST['email'])) {
        $email=$_POST['email'];
        if (validarEmail($email) == 0) { //viliadar email bien formado
            $error.= "<u><b><font color ='red'>El email está mal formado</font></b></u><br>";
        } 
    }else{
        $error.= "<u><b><font color ='red'>Debe escribir su email</font></b></u><br><br>";
    }
    if (isset($_POST['pass']) && $_POST['pass'] != "") {
        $pass=$_POST['pass']; 
    }else{
        $error.= "<u><b><font color ='red'>Debe escribir una contraseña</font></b></u><br><br>";
    }

    if ($error == "") {
        $resulValida = validar($pass,$email); //validar a los user y pass
        $aux = explode("|",$resulValida);
        //print_r($aux);
        $nombreUser = $aux[1];
        if ($aux[0] == "true" && $aux[1] == "admin") {
            //echo $nombreUser;
            session_start();
            $_SESSION['nombre'] = $nombreUser;
            $_SESSION['email'] = $email;
            crearCookie($nombreUser);   // creamos la cookie
            $hora = date("F j, Y, g:i a");
            $logueado = $nombreUser.",".$email.",".$hora."|"; 
            recordatorioUser($logueado);
            header("location: indexAdmin.php");// 2º header a la página del admin
        }
        if ($aux[0] == "true" && $aux[1] != "admin") {
            //echo $nombreUser;
            session_start();
            $_SESSION['nombre'] = $nombreUser;
            $_SESSION['email'] = $email;
            echo $_SESSION['email'];
            crearCookie($nombreUser);   // creamos la cookie
            $hora = date("F j, Y, g:i a");
            $logueado = $nombreUser.",".$email.",".$hora."|"; 
            recordatorioUser($logueado);
            header("location: index.php");// 2º header a la página de tienda
        }else{
            $error .= "<u><b><font color ='red'>No tiene cuenta en esta web o la contraseá o email son incorretas</font></b></u><br>";
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
            xmlhttp.open("GET", "ajaxProductosHome.php?valor="+valor+"&pag="+valor2, true);
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
    </script>
</head>
<body onload="mostrarDBpag('Todo',0)" background="imgEmpresa/fondo.jpg">
    <div class="page-header" class='page-header' style='width:auto; height:150px;  background-image:url("imgEmpresa/back2.jpeg"); text-align:left; font-family:fantasy; font-size: 60px; margin-bottom:10px;  position:fixed; top:0; width:100%; '>
            <div class='col-3 float-left' style='margin-top:20px; margin-bottom:10px; margin-left:20px; width:auto;'><p style="float:left; margin-left:10px;">ElectronicStation</p></div>
            <div class='d-none d-sm-none d-md-none d-lg-block  float-right' style='margin-top:25px; margin-bottom:10px; width:auto; margin-right:210px;'><img src='imgEmpresa/logoSaul.png'  style='width:80px; height:80px;'></div>
    </div>
    <div style="height:150px;"></div>
        <table class='table ' style='text-align:center; font-size:18px;'>
            <form action="" method="post" class="form-group" style="font-family:fantasy;">
            <tr><td><u style="font-size: 30px; "><b>Login</b></u></td></tr>
            <tr><td><b>Email:</b></td></tr>
            <tr><td><input type="text" name="email" style='border-radius:10px;' placeholder='User'></td></tr>
            <tr><td><b>Password:</b></td></tr>
            <tr><td><input type="password" name="pass" style='border-radius:10px;'  placeholder='Password'></td></tr>
            <tr><td ><input class="btn btn-primary" type="submit" value="Login" ></td></tr>
            </form>
            <tr><td><a href="registroTienda.php" class="registro"><u style="font-family:fantasy;">Regístrate</u></a></td></tr>
        </table>
    <div class="alertasLogin">
        <?php
            if ($error != "") {
                echo "<div class='error'><h5 style='font-family:fantasy; margin-left:20px; color:red;'>".$error."</h5></div>";
            }
            if ($resul != "") {
                echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px;'>".$resul."</h4>";
            }
        ?>
    </div>
    <span id="resultado"></span>
    <br>
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


