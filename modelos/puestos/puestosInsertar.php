<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//INSERTAMOS LOS DATOS A LA TABLA puestos_trabajo
$accion = $_POST['accionP'];
$codigo = $_POST['codigo'];
$descripcion = $_POST['descripcion'];
if ($accion == "registrar"){
    $consulta = "INSERT INTO puestos_trabajo VALUES (null, '$codigo','$descripcion', DEFAULT)";
    $resultado = mysqli_query($enlace, $consulta);

    if (!$resultado){

        die('Error de consulta '. mysqli_error($enlace));

    }

}


?>