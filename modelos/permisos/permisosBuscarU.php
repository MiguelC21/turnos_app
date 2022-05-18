<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//Busqueda de los usuarios registrados
if(isset($_POST["buscarU"])){

    $buscarU = $_POST["buscarU"];
    $consulta = "SELECT id, nombre, apellido 
    FROM usuarios 
    WHERE nombre LIKE '%$buscarU%' OR apellido LIKE '%$buscarU%' AND estado = 1
    ORDER BY nombre ASC";
    $resultado = mysqli_query($enlace, $consulta);

    if(!$resultado){

        die('Error de consulta '. mysqli_error($enlace));
    }

    $json = array();
    while($fila = mysqli_fetch_array($resultado)) {
    
        $json[]= array(
            'id' => $fila['id'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido']
        );

    }
    
    $jsonString = json_encode($json);
    echo $jsonString;
}else{
    $consulta = "SELECT id, nombre, apellido 
    FROM usuarios 
    WHERE estado = 1
    ORDER BY nombre ASC";
    $resultado = mysqli_query($enlace, $consulta); 

    if(!$resultado){

        die('Error de consulta '. mysqli_error($enlace));
    }

    $json = array();
    while($fila = mysqli_fetch_array($resultado)) {
    
        $json[]= array(
            'id' => $fila['id'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido']
        );

    }
    
    $jsonString = json_encode($json);
    echo $jsonString;
}




?>