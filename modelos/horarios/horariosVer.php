<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";


//Obtenemos los horaios de la base de datos con estado activo.

$consulta = "SELECT id, codigo, TIME_FORMAT(horaInicio,'%H:%i') AS horaInicio, TIME_FORMAT(horaFin,'%H:%i') AS  horaFin FROM tipo_turnos WHERE estado = 1";

$resultado = mysqli_query($enlace, $consulta);


$json = array();
while ($fila = mysqli_fetch_array($resultado)) {

    $json[] = array(
        'horarioId' => $fila['id'],
        'codigo' => $fila['codigo'],
        'horaInicio' => $fila['horaInicio'],
        'horaFin' => $fila['horaFin'],
    );
}

$jsonString = json_encode($json);
echo $jsonString;

?>  