<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// ELIMINAMOS LOS DATOS DE LA TABLA puestos_horarios

$accion = $_POST['accion'];

if ($accion == "eliminar") {  //Actualiza datos
    $id = $_POST['horarioId'];

    $consulta = "DELETE FROM puestos_horarios WHERE id = '$id'";

    $respuesta = mysqli_query($enlace, $consulta);

    if($respuesta){
        echo 'Eliminado Exitosamente!';
    }

}


?>