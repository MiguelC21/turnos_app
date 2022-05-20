<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//Selecionamos los puestos horarios donde los puestos estan activos actualmente

$consulta = mysqli_query($enlace, "SELECT
id
FROM usuarios
WHERE estado = 1;
");
$consulta2 = mysqli_query($enlace, "SELECT
id
FROM usuarios
WHERE estado = 1 AND permiso = 0;
");

$activos = mysqli_num_rows($consulta);
$disponibles = mysqli_num_rows($consulta2);

$nRows []= array(
    'activos' => $activos,
    'disponibles' => $disponibles
);

$jsonString = json_encode($nRows);
echo $jsonString;