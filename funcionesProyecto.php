<?php

$conexion = new mysqli('localhost', 'root', '', 'tienda'); //funcion de conexion a la base de datos
if ($conexion->connect_error) {
    echo("Conexión fallida: ");
}

/* ------------------------------------------------------------------------------------------------ */

function validar($pass,$email) { //valida a los usuarios de la base de datos
    global $conexion; //variable global de la conexion con la base de datos;
    $nameUser ="";
    $user = "SELECT `nombre` FROM `clientes` WHERE `email` = '$email';";
    if($valido= $conexion->query($user)){ //recogemos el nombre del user 
        if($valido->num_rows > 0 ){
            while($registro = $valido->fetch_assoc()){
                $nameUser = $registro["nombre"];
            }
        }
    }
    $consultasql="SELECT * FROM `clientes` WHERE `email` = '$email' AND `contrasena` = '$pass';";
    if($valido= $conexion->query($consultasql)){ //hacemos la validacion del user del login
        if($valido->num_rows > 0 ){
            return "true|".$nameUser;
        }else{
            return "false|".$nameUser;
        }
    }
}

/* ------------------------------------------------------------------------------------------------ */

function validarEmail($email){  //valida para que el email esté bien escrito
  $matches = null;
  return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email, $matches));
}

/* ------------------------------------------------------------------------------------------------ */

function validaNombreNum($palabra){ //valida que el nombre sea correcto y no contenga números
    $texto = "/^[a-zA-ZáéíóúÁÉÍÓÚäëïöüÄËÏÖÜàèìòùÀÈÌÒÙ\s]+$/";
    $aux = "";
    $cont = 0;
    for ($i=0; $i < strlen($palabra); $i++) { 
        if (preg_match($texto,$palabra[$i])) {
            
        }else{
            $cont++;
        }
    }
    return $cont;
}

/* ------------------------------------------------------------------------------------------------ */

function crearCookie($nombreUser){//funcion encargada de crear la cookie del user
    setcookie("nombre", $nombreUser, time()+3600);
}

/* ------------------------------------------------------------------------------------------------ */

function cerrarSession($nombreUser){  // cierra la sesion y manda al user al login
    session_start();
    unset($_SESSION);
    setcookie(session_name(),'',time()-3600);
    setcookie("nombre", $nombreUser,time()-3600);
    session_destroy();
    header("location: loginTienda.php");
}

/* ------------------------------------------------------------------------------------------------ */

function validarEmailRegisrto($email){  //valida para que el email a la hora de registrarse y comprueba si ya existe
    $matches = null;
    return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $email, $matches));
}

/* ------------------------------------------------------------------------------------------------ */

function validarContraseña($password,$passwordRepe){ //valida si las dos contraseñas son iguales
    if ($password == $passwordRepe) {
        return true;
    }
    return false;
}

/* ------------------------------------------------------------------------------------------------ */

function recordatorioUser($logueado){ //creamos un recordatorio de los user conectados
    $ruta  = "recordatorio.txt";
    if (isset($ruta)) {
        $fichero = fopen("recordatorio.txt", "a+");
        fwrite($fichero, $logueado . PHP_EOL);
        fclose($fichero);
    }else{
        $fichero = fopen("recordatorio.txt", "w+");
        fwrite($fichero, $logueado . PHP_EOL);
        fclose($fichero);
    }
}

/* ------------------------------------------------------------------------------------------------ */

function agregarNuevoProducto($nombre,$precio,$categoria,$img){ //Añadimos al nuevo producto con  PDO (Solo para el administrador);
    global $conexion;
    $existe = "SELECT `nombre` FROM `productos` WHERE `nombre` = '$nombre';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            return "<u><b><font color ='red'>Ese producto ya existe y no lo podemos agregar</font></b></u>";
        }else{
            $conexionPro = new PDO('mysql:host=localhost; dbname=tienda', 'root', '');
            $conexionPro->exec("INSERT INTO `productos` (`nombre`, `precio`, `categoria`, `imagen`) VALUES ('$nombre', '$precio', '$categoria', '$img');");
            return "Producto añadido correctamente";
        }
    }
    unset($conexionPro);
}

/* ------------------------------------------------------------------------------------------------ */

function tablaNuevoProduct(){ //esta funcion nos permite crear y mostrar la tabla de agregar nuevo producto
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Nuevo Producto</u></th></tr>";
    $resul.= "<tr><td>Tipo de Producto <input type='text' name='tipo' style='border-radius:10px; margin-left:25px;' placeholder='type'></td></tr>";
    $resul.= "<tr><td>Nombre Producto <input type='text' name='nameProducto' style='border-radius:10px; margin-left:20px;' placeholder='Name Product'></td></tr>";
    $resul.= "<tr><td>Precio Producto <input type='text' name='precio' style='border-radius:10px; margin-left:30px;' placeholder='Price'></td></tr>";
    $resul.= "<tr><td>Nombre Imagen <input type='text' name='img' style='border-radius:10px; margin-left:30px;' placeholder='Name Image'></td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Agregar Producto' name='agregar' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;
}

/* ------------------------------------------------------------------------------------------------ */

function desplegableTipoProductoAjaxDB(){ //desplegable del tipo de producto que queremos seleccionar para mostrar con Ajax
    $resul = "";
    $aux =array();
    $atributo = "";
    $dummy ="";
    
    global $conexion;
    $selec = "SELECT categoria FROM `productos`;";
    if($valido= $conexion->query($selec)){ 
        while($registro = $valido->fetch_assoc()){  // nos debuelve un array asociativo del resultado del sql
            $atributo = $registro['categoria'];
            if (!in_array($atributo, $aux)) {
                array_push($aux,$atributo);
            }
        }
    }
    $resul.="<select name='tipo' onchange=\"mostrarDBpag(this.value,0);\"  style='font-family:fantasy; border-radius: 10px;'>";
    $resul.="<option id='elije'>Elija Tipo</option>";
    $resul.="<option id='Todo'>Todo</option>";
    for ($i=0; $i < count($aux); $i++) {
        $resul.="<option id='$aux[$i]'>$aux[$i]</option>";
    }
    $resul.= "</select>";
    return $resul;
}

/* ------------------------------------------------------------------------------------------------ */

function desplegableTipoProductoAjaxDBAdmin(){ //desplegable del tipo de producto que queremos seleccionar para mostrar con Ajax
    $resul = "";
    $aux =array();
    $atributo = "";
    $dummy ="";
    
    global $conexion;
    $selec = "SELECT categoria FROM `productos`;";
    if($valido= $conexion->query($selec)){ 
        while($registro = $valido->fetch_assoc()){  // nos debuelve un array asociativo del resultado del sql
            $atributo = $registro['categoria'];
            if (!in_array($atributo, $aux)) {
                array_push($aux,$atributo);
            }
        }
    }
    /* $resul.="<select name='tipo' onchange=\"mostrarDBAdmin(this.value);\" class='select'>"; */
    $resul.="<select name='tipo' onchange=\"mostrarDBAdmin2(this.value);\" style='font-family:fantasy; border-radius: 10px;'>";
    $resul.="<option id='elije'>Elija Tipo</option>";
    $resul.="<option id='Todo'>Todo</option>";
    for ($i=0; $i < count($aux); $i++) {
        $resul.="<option id='$aux[$i]'>$aux[$i]</option>";
    }
    $resul.= "</select>";
    return $resul;
}

/* ------------------------------------------------------------------------------------------------ */

function comprobarCarro($email){ //comprueba si existe o no el email en la base de datos
    global $conexion; //variable global de la conexion con la base de datos;
    $user = "SELECT * FROM `carro` WHERE `nombreU` = '$email';";
    if($valido= $conexion->query($user)){ //recogemos el nombre del user 
        if($valido->num_rows > 0 ){
            return true;
        }else{
            return false;
        }
    }
}

/* ------------------------------------------------------------------------------------------------ */

function agregarNuevoUser($name,$email,$password){ //incribe al ciente en la base de datos
    global $conexion;
    $existe = "SELECT `email` FROM `clientes` WHERE `email` = '$email';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            return "<u><b><font color ='red'>Ese usuario ya existe</font></b></u>";
        }else{
            $consulta = $conexion->stmt_init(); //devuelve un objeto de la clase mysqli_stmt para poder trabajar con consultas preparadas
            $dummy = "INSERT INTO clientes (nombre, email, contrasena) VALUES (?, ?, ?);"; //no se pueden poner comillas
            $consulta->prepare($dummy);
            $consulta->bind_param("sss", $name, $email, $password);
            $consulta->execute();
            $consulta->close();
            return "Cuenta cliente creada";
        }
    }
}

/* ------------------------------------------------------------------------------------------------ */



function historico(){
    global $conexion;

    if (isset($_COOKIE['nombre'])) { //utilizamos la cookie para poder movernos entre el carro y la tienda
        $name = strtoupper($_COOKIE['nombre']);
    }
    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email']; 
    }
    
    $cargar = "SELECT * FROM `carro` WHERE `nombreU` = '$email';"; //recogemos los datos del user que tiene introducidos dentro del carro
    
    $resul = "";  
    if($valido= $conexion->query($cargar)){ //recogemos el nombre del user 
        if($valido->num_rows > 0 ){
            while($registro = $valido->fetch_assoc()){ //mostramos los datos del carro de casa user y el total a pagar
                $nombreProducto = $registro['nombreP'];
                $cantidadPro=$registro['cantidad'];
            }
        }
    }
    
    $existe = "SELECT `nombre` FROM `productos` WHERE `nombre` = '$nombre';";
    if($valido= $conexion->query($existe)){ //comprobamos si el producto existe en el carro
        if($valido->num_rows > 0 ){
            return "<u><b><font color ='red'>Compra ya existente</font></b></u>";
        }else{
            $conexionPro = new PDO('mysql:host=localhost; dbname=tienda', 'root', '');
            $conexionPro->exec("INSERT INTO `historico` (`cliente`, `producto`, `cantidad`, `idcompra`) VALUES ('$name', '$nombreProducto', '$cantidadPro', null);");
            return "Producto añadido correctamente";
        }
    }
    unset($conexionPro);
    
    
    $cargar = "DELETE FROM `carro` WHERE `nombreU` = '$email';";
    $conexion->query($cargar);

}

function modificarDatos(){
    $desple="";
    $desple=desplegableNombreP();
    $resul="";
    $resul.= "<div style='font-family:fantasy; margin-left:10px;'>";
    $resul.= "<form action='' method='post'>";
    $resul.= "<table class='table' style='text-align:center; font-size:18px;'>";
    $resul.= "<tr><th colspan='2' style='text-align:center; font-size:25px;'><u>Modificar Precio Producto</u></th></tr>";
    $resul.= "<tr><td>Producto ".$desple."</td></tr>";
    $resul.= "<tr><td>Nuevo Precio<input type='text' name='nuevoPrecio' style='border-radius:10px; margin-left:20px;' placeholder='New Price'></td></tr>";
    $resul.= "<tr><td colspan='2' align='center'><input type='submit' class='btn btn-primary' value='Modificar' name='modificarPrecioPro' style='margin-top:5px;'></td></tr>";
    $resul.= "</table>";
    $resul.= "</div>";
    $resul.= "<br>";
    $resul.= "</form>";
    return $resul;

}

function desplegableNombreP(){
    $resul = "";
    $aux =array();
    $nombres = "";
    $dummy ="";
    
    global $conexion;
    $selec = "SELECT * FROM `productos`;";
    if($valido= $conexion->query($selec)){ 
        while($registro = $valido->fetch_assoc()){  // nos debuelve un array asociativo del resultado del sql
            $nombres = $registro['nombre'];
            if (!in_array($nombres, $aux)) {
                array_push($aux,$nombres);
            }
        }
    }
    $resul.="<select name='nombreModificar' style='font-family:fantasy; border-radius: 10px;'>";
    $resul.="<option value='elije'>Elija Producto</option>";
    for ($i=0; $i < count($aux); $i++) {
        $resul.="<option value='$aux[$i]'>$aux[$i]</option>";
    }
    $resul.= "</select>";
    return $resul;
}

function modificarPrecio($precioModifi,$nombrePro){
    //echo $precioModifi."|".$nombrePro;
    $modificar ="";
    global $conexion;
    $modificar = "UPDATE `productos` SET `precio`='$precioModifi' WHERE `nombre` = '$nombrePro';";
    $conexion->query($modificar);            
}