<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// ELIMINAMOS LOS DATOS DE LA TABLA puestos_horarios

// $buscar = $_POST['buscarH'];

if(isset($_POST['buscar'])){
    $buscar = $_POST['buscar'];
    $consulta = "SELECT
    id,
    codigo,
    descripcion,
    estado
    FROM puestos_trabajo
    WHERE codigo like '$buscar%' or descripcion like '$buscar%'
    ORDER BY estado DESC, codigo ASC";

$resultado = mysqli_query($enlace, $consulta);

$json = array();
while ($fila = mysqli_fetch_array($resultado)) {

    $json[] = array(
        'puestoId' => $fila['id'],
        'codigo' => $fila['codigo'],
        'descripcion' => $fila['descripcion'],
        'estado' => $fila['estado']
    );
}

$jsonString = json_encode($json);
echo $jsonString;
// echo ('Buscando '+$buscar);


}else{
    $consulta = "SELECT
    id,
    codigo,
    descripcion,
    estado
    FROM puestos_trabajo
    ORDER BY estado DESC, codigo ASC";

$resultado = mysqli_query($enlace, $consulta);

$json = array();
while ($fila = mysqli_fetch_array($resultado)) {

    $json[] = array(
        'puestoId' => $fila['id'],
        'codigo' => $fila['codigo'],
        'descripcion' => $fila['descripcion'],
        'estado' => $fila['estado']
    );
}

$jsonString = json_encode($json);
echo $jsonString;
}

