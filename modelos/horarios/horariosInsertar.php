<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// INSERTAMOS LOS DATOS EN LA TABLA puestos_horarios

$accion = $_POST['accion'];

if ($accion == "registrar") {  //Actualiza datos
    $codigo = $_POST['codigo'];
    $horaInicio = $_POST['horaInicio'];
    $horaFin = $_POST['horaFin'];


    echo $codigo;
    echo "-----";
    echo $horaInicio;
    echo "-----";
    echo $horaFin;
    

    $consulta = "INSERT INTO tipo_turnos VALUES (null,'$codigo','$horaInicio','$horaFin',DEFAULT)";

    mysqli_query($enlace, $consulta);

}



?>