<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// ACTUALIZAMOS LOS DATOS DE LA TABLA puestos_horarios

$accion = $_POST['accion'];

if ($accion == "eliminar") {  //Actualiza datos
    $id = $_POST['horarioId'];

    $consulta = "UPDATE tipo_turnos SET estado = 0 WHERE id = '$id'";

    $resultado = mysqli_query($enlace, $consulta);

    $consulta2 = "DELETE FROM puestos_horarios WHERE tipoTurnoId = '$id'";

    $resultado = mysqli_query($enlace, $consulta2);

}