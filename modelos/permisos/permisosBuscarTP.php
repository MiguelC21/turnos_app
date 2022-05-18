<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

$consulta = "SELECT id, descripcion FROM tipo_permisos WHERE descripcion != 'Cumpleaños'";

$resultado = mysqli_query($enlace, $consulta);

$json = array();

while($fila = mysqli_fetch_array($resultado)){
    if($fila['descripcion'] != 'Cumpleaños'){
        $json[] = array(
            'id' => $fila['id'],
            'descripcion' => $fila['descripcion']
        );
    }
}
$jsonString = json_encode($json);
echo $jsonString;
    