<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";


// Registrando usuarios
if (isset($_POST['nombre']) && $_POST["nombre"] != "") {

$tipoDocumento = $_POST["tipoDocumento"];
$nDocumento = $_POST['nDocumento'];
$nombre = $_POST["nombre"];
$apellido = $_POST["apellido"];
$correo = $_POST["correo"];
$telefono = $_POST["telefono"];
$fechaNacimiento = $_POST["fechaNacimiento"];
$fechaRegistro = "";
$estado = 1;
$permiso = 0;

$consulta1 = "INSERT INTO usuarios VALUES (null,'$tipoDocumento', '$nDocumento', '$nombre', '$apellido', '$correo', '$telefono', '$fechaNacimiento', current_timestamp(), '$estado', $permiso)";

$inserta = true;
try {
    $resultado = mysqli_query($enlace, $consulta1);
} catch(Exception $ex){
    $resp = 'repetido';
    $json = json_encode($resp);
    echo $json;
    $inserta = false;
}

if ($inserta){
    //consulatamos el id del ultimo usuario registrado
    $consulta2 = 'SELECT id, fechaNacimiento FROM usuarios ORDER BY id DESC LIMIT 1';
    $resultado = mysqli_query($enlace, $consulta2);
    while($obj = mysqli_fetch_assoc($resultado)){
    $userId = $obj['id'];
    $fechaNacimiento = $obj['fechaNacimiento'];
    }
    // Agregamos el premiso de cumpleaños
    
    $año = date('Y');//obtengo año actual
    $dia = date('d', strtotime($fechaNacimiento));//extraigo el dia de la fecha de nacimiento
    $mes = date('m', strtotime($fechaNacimiento));//extraigo el mes de la fecha de nacimiento
    $permiso = date('Y-m-d', strtotime("$año-$mes-$dia"));//convierto los datos a tipo date(fecha)
    
    $insertaPermiso = "INSERT INTO permisos VALUES (null, '$userId', 5, '$permiso','$permiso','SI')";
    mysqli_query($enlace, $insertaPermiso);
    
    $resp = 'sigue';
    $json = json_encode($resp);
    echo $json;
    
}


}



