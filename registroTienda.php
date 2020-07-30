<?php
include "funcionesProyecto.php";
$resulContra = "";
$resulNombre = "";
$resulEmail = "";
$error = "";
$password ="";
$passwordRepe="";
$resul = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST')  {
    if (isset($_POST['name']) && $_POST['name']!="") { //comprobamos que introduce el nombre y lo validamos 
        $name = $_POST['name'];
        if (validaNombreNum($name) != 0) {
            $error.= "El nombre contiene números<br>";
        }
    }else{
        $error.= "Debe escribir el nombre<br>";
    }
    if (isset($_POST['email']) && $_POST['email']!="") { //comprobamos que introduce un email y lo validamos 
        $email = $_POST['email'];
    }else{
        $error.= "Debe escribir un email<br>";
    }
    if (isset($_POST['password']) && $_POST['password'] != "") { //comprobamos si escribio el pass
        $password = $_POST['password'];
    }else{
        $error.= "Debe escribir la contraseña<br>";
    }
    if (isset($_POST['passwordRepe']) && $_POST['passwordRepe'] != "") {//comprobamos si escribio el pass repetido 
       $passwordRepe = $_POST['passwordRepe'];
    }else{
        $error.= "Debe escribir confirmar la contraseña<br>";
    }
    if ($password!="" && $passwordRepe!="") { //comprobamos que los nombres no esten vacion antes de seguir
        if (!validarContraseña($password,$passwordRepe)) { //validamos la contraseña
            $error.= "Las contraseñas no coindiden<br>";
        }
    }

    if ($error == "") { //comprovamos que las validaciones no contengas errores y seguido agregamos al usuario
        $resul = agregarNuevoUser($name,$email,$password);
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
</head>
<body  background="imgEmpresa/fondo.jpg">
    <?php
        echo "<div class='page-header' style='vertical-align:middle; width:100%; background-image:url(\"imgEmpresa/back2.jpeg\"); text-align:left; font-family:fantasy; font-size: 30px;'>";
        echo "<div class='row'>" ;
        echo "<div class='col-4' style='margin-top:20px; margin-bottom:10px; margin-left:10px;' >Registrate Aquí</div>";
        echo "<div class='col-2 offset-5' style='margin-top:10px; margin-bottom:10px;'><img src='imgEmpresa/logoSaul.png'  style='width:80px; height:80px; float:right;'></div>";
        echo "</div>";
        echo "</div>";
    ?>
    <div class="divRegis">
        <table class="table table-striped" style="text-align:center; font-family:fantasy; margin-top:40px;">
            <form action="" method="post">
                <tr><th colspan="2" style="font-size:20px; font-family:fantasy;"><u>Regístrate con nosotros</u></th></tr>
                <tr>
                    <td>Nombre:</td> <td><input type="text" name="name" style="border-radius:20px;" placeholder='Nombre'></td>
                </tr>
                <tr>
                    <td>Email:</td><td><input type="text" name="email" style="border-radius:20px;" placeholder='Email'></td>
                </tr>
                <tr>
                    <td>Contraseña:</td><td><input type="password" name="password" style="border-radius:20px;" placeholder='Password'></td>
                </tr>    
                <tr>
                    <td>Repite Cotraseña:</td><td><input type="password" name="passwordRepe" style="border-radius:20px;" placeholder="repeat Password"></td>
                </tr>   
                    <tr><td colspan="2"><input type="submit" value="Registrarse" class="btn btn-primary"></td></tr>
            </form>
            <tr><td colspan="2"><a href="loginTienda.php">Volver al Login</a></td></tr>
        </table>
    </div>
    <?php 
        if ($error != "") {
            echo "<div class='error'><h5 style='font-family:fantasy; margin-left:20px; color:red;'>".$error."</h5></div>";
        }
        if ($resul != "") {
            echo "<h4 style='font-family:fantasy; margin-left:20px; margin-top:10px;'>".$resul."</h4>";
        }
    ?>
    
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