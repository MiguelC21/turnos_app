<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// INSERTAMOS LOS DATOS EN LA TABLA puestos_horarios

$accion = $_POST['accion'];

if ($accion == "registrar") {  //Actualiza datos

    // Buscamos la hora de inicio y fin para el horaio que se a seleccionado
    $turnoId = $_POST['tipoTurnoId'];
    $consulta1 = "SELECT horaInicio, horaFin FROM tipo_turnos WHERE id = '$turnoId'";
    
    $horaInicio = "";
    $horaFin = "";
    $respuesta = mysqli_query($enlace, $consulta1);

    while($obj = mysqli_fetch_array($respuesta)){
        $horaInicio = $obj['horaInicio'];
        $horaFin = $obj['horaFin'];
    }
    
    $puestoId = $_POST['puestoId'];
    $observacion = $_POST['observacion'];
    if ($observacion == ""){
        $observacion = 'Ninguna';
    }

    // Insertamos los datos a la tabla puestos_horarios 
    $consulta2 = "INSERT INTO puestos_horarios VALUES (null,'$turnoId','$puestoId','$horaInicio','$horaFin','$observacion')";

    mysqli_query($enlace, $consulta2);
}



?>