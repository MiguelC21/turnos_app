<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// ACTUALIZAMOS LOS DATOS DE LA TABLA puestos_horarios

$accion = $_POST['accion'];

if ($accion == "obtener") {  //Actualiza datos
    $id = $_POST['horarioId'];
    
    $consulta = "SELECT id, tipoTurnoId, observacion FROM puestos_horarios WHERE id = '$id'";

    $resultado = mysqli_query($enlace, $consulta);

    $json = array();
    while ($fila = mysqli_fetch_array($resultado)) {

        $json[] = array(
            'id' => $fila['id'],
            'tipoTurnoId' => $fila['tipoTurnoId'],
            'observacion' => $fila['observacion']
        );
    }

    $jsonString = json_encode($json[0]);
    echo $jsonString;
    // echo $id;

} elseif($accion == "actualizar") {  //Actualiza datos

    $tipoTurno = $_POST['tipoTurnoId'];
    $horaInicio = "";
    $horaFin = "";
    $consulta1 = "SELECT horaInicio, horaFin FROM tipo_turnos WHERE id = '$tipoTurno'";

    $respuesta = mysqli_query($enlace, $consulta1);

    while($obj = mysqli_fetch_array($respuesta)){
        $horaInicio = $obj['horaInicio'];
        $horaFin = $obj['horaFin'];
    }


    $id = $_POST['horarioId'];
    $observacion = $_POST['observacion'];
    if ($observacion == ""){
        $observacion = 'Ninguna';
    }
    //Realizamos la actualizacion de los datos
    $consulta = "UPDATE puestos_horarios 
    SET tipoTurnoId = '$tipoTurno', horaInicio = '$horaInicio', horaFin = '$horaFin', observacion = '$observacion' 
    WHERE id = '$id'";

    $resultado = mysqli_query($enlace, $consulta);

    if($resultado){
    // echo "Actualizacion exitoxa";
    }

}

?>