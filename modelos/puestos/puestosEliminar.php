<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//ACTUALIZAMOS LOS DATOS DE LA TABLA puestos_trabajo
if($_POST['id']){

    $id = $_POST["id"];
    $consulta1 ="DELETE FROM puestos_horarios WHERE puestoTrabajoId = '$id'";
    $consulta2 ="DELETE FROM puestos_trabajo WHERE id = '$id'";
    
    mysqli_query($enlace, $consulta1);
    mysqli_query($enlace, $consulta2);


}


?>