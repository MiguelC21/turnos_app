<?php 
// Includes
include "./modelos/config/conexion.php";
include "./modelos/config/zonaHoraria.php";

$consulta0 = mysqli_query($enlace, "SELECT fechaTurno FROM turnos_usuarios ORDER by fechaTurno DESC LIMIT 1");
$ultimaFechaTurno = mysqli_fetch_array($consulta0);
$fecha = $ultimaFechaTurno['fechaTurno'];
$fecha = date('Ymd', strtotime($fecha. ' + 1 days'));

echo $fecha;




?>
