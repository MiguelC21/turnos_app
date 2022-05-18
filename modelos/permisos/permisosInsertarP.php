<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";


//INSERTA LOS DATOS EN LA TABLA PERMISOS
if(isset($_POST['usuarioId'])){

    $id = $_POST['usuarioId'];
    $tipoPermiso = $_POST['tipoPermiso'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $remunerado = $_POST['remunerado'];
    
    $consulta = "INSERT INTO permisos VALUES (null,'$id', '$tipoPermiso','$fechaInicio','$fechaFin','$remunerado')";

    mysqli_query($enlace, $consulta);

//Deshabilitamos el usuario

$hoy = date('Y-m-d');  //fecha actual para comparar

if($hoy >= $fechaInicio && $hoy <= $fechaFin){

    
    $consulta = "UPDATE usuarios SET permiso = 1 WHERE id = '$id' ";
    mysqli_query($enlace, $consulta);

}

}

?>