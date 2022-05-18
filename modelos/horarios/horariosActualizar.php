<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// ACTUALIZAMOS LOS DATOS DE LA TABLA puestos_horarios

$accion = $_POST['accion'];

if ($accion == "obtener") {  //Actualiza datos
    $id = $_POST['horarioId'];
    
    $consulta = "SELECT id, codigo, horaInicio, horaFin FROM tipo_turnos WHERE id = '$id'";

    $resultado = mysqli_query($enlace, $consulta);

    $json = array();
    while ($fila = mysqli_fetch_array($resultado)) {

        $json[] = array(
            'id' => $fila['id'],
            'codigo' => $fila['codigo'],
            'horaInicio' => $fila['horaInicio'],
            'horaFin' => $fila['horaFin']
        );
    }

    $jsonString = json_encode($json[0]);
    echo $jsonString;
    // echo $id;

} elseif($accion == "actualizar") {  //Actualiza datos
    $id = $_POST['horarioId'];
    $codigo = $_POST['codigo'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];

    //Realizamos la actualizacion de los datos
    $consulta = "UPDATE tipo_turnos 
    SET codigo = '$codigo', 
    horaInicio = '$horaInicio', 
    horaFin = '$horaFin'
    WHERE id = '$id'";

    $resultado = mysqli_query($enlace, $consulta);

    //Realizamos la actualizacion de los datos en tabla puestos_horarios

    $consulta2 = "UPDATE puestos_horarios 
    SET horaInicio = '$horaInicio', 
    horaFin = '$horaFin'
    WHERE tipoTurnoId = '$id'";

    $resultado = mysqli_query($enlace, $consulta2);


    

}

?>