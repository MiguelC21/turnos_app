<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//ACTUALIZAMOS LOS DATOS DE LA TABLA puestos_trabajo

$accion = $_POST['accion'];

if ($accion == "obtener") {  //Actualiza datos

    $id = $_POST['id'];

    $consulta = "SELECT id, codigo, descripcion FROM puestos_trabajo WHERE id = '$id'";

    $resultado = mysqli_query($enlace, $consulta);

    $json = array();
    while ($fila = mysqli_fetch_array($resultado)) {

        $json[] = array(
            'id' => $fila['id'],
            'codigo' => $fila['codigo'],
            'descripcion' => $fila['descripcion']
        );
    }

    $jsonString = json_encode($json[0]);
    echo $jsonString;


} elseif ($accion == "actualizar") { //Actuzaliza datos
    $id = $_POST['id'];
    $codigo = $_POST['codigo'];
    $descripcion = $_POST['descripcion'];
    
    $consulta = "UPDATE puestos_trabajo SET codigo='$codigo', descripcion='$descripcion' WHERE id = '$id'";

    mysqli_query($enlace, $consulta);

} elseif ($accion == "actualizarEstado") { //Actuzaliza el estado
    $id = $_POST['id'];
    $estado = $_POST['estado'];

    if($estado == 'false'){
        $consulta ="UPDATE puestos_trabajo SET estado = 0 WHERE id = '$id'";
        mysqli_query($enlace, $consulta);
        echo "Desactivar estado";
    }elseif($estado == 'true'){
        $consulta ="UPDATE puestos_trabajo SET estado = 1 WHERE id = '$id'";
        mysqli_query($enlace, $consulta);
        echo "Activar estado";
    }
}
