<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// ELIMINAMOS LOS DATOS DE LA TABLA puestos_horarios

// $buscar = $_POST['buscarH'];


$consulta = "SELECT
id,
puestoTrabajoId,
TIME_FORMAT(horaInicio,'%H:%i') AS horaInicio,
TIME_FORMAT(horaFin,'%H:%i') AS horaFin,
observacion
FROM puestos_horarios
ORDER BY id ASC";

$resultado = mysqli_query($enlace, $consulta);

$json = array();
while ($fila = mysqli_fetch_array($resultado)) {

    $json[] = array(
        'horarioId' => $fila['id'],
        'puestoId' => $fila['puestoTrabajoId'],
        'horaInicio' => $fila['horaInicio'],
        'horaFin' => $fila['horaFin'],
        'observacion' => $fila['observacion']
    );
}

$jsonString = json_encode($json);
echo $jsonString;


