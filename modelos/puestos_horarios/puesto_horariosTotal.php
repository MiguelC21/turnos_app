<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//Selecionamos los puestos horarios donde los puestos estan activos actualmente

$consulta = mysqli_query($enlace, "SELECT
puestos_horarios.id
FROM puestos_horarios
JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
WHERE puestos_trabajo.estado = 1;
");
$nRows = mysqli_num_rows($consulta);


$jsonString = json_encode($nRows);
echo $jsonString;


