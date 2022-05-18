<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

if(isset($_POST['permisoId'])){
    $permisoId = $_POST['permisoId'];
    $usuarioId = $_POST['usuarioId'];
    $consulta = "DELETE FROM permisos WHERE id = '$permisoId' ";

    mysqli_query($enlace, $consulta);
    
    $consulta = "UPDATE usuarios SET permiso = 0 WHERE id = '$usuarioId' ";
    mysqli_query($enlace, $consulta);

}


?>