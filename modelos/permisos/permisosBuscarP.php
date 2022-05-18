<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// REALIZAR CONSULTAS EN LA LISTA DE PERMISOS
if(isset($_POST['buscarP']) && $_POST["buscarP"] != ""){

    $buscar = $_POST['buscarP'];
    $consulta = "SELECT
    permisos.usuarioId AS usuarioId,
    permisos.id  AS permisoId,
    usuarios.nombre AS nombre,
    usuarios.apellido AS apellido,
    usuarios.telefono AS telefono,
    tipo_permisos.descripcion AS tipoPermiso,
    permisos.fechaInicio AS fechaInicio,
    permisos.fechaFin AS fechaFin,
    permisos.remunerado AS remunerado
    FROM permisos 
    JOIN usuarios ON permisos.usuarioID = usuarios.id
    JOIN tipo_permisos ON permisos.tipoPermisoId = tipo_permisos.id
    WHERE nombre LIKE '%$buscar%' OR apellido LIKE '%$buscar%'
    ORDER BY permisos.tipoPermisoId, usuarios.nombre  ASC";
    
    $resultado = mysqli_query($enlace, $consulta);

    if(!$resultado){

        die('Error de consulta '. mysqli_error($enlace));
    }
    
    $json = array();
    while($fila = mysqli_fetch_array($resultado)) {
    
        $json[]= array(
            'usuarioId' => $fila['usuarioId'],
            'permisoId' => $fila['permisoId'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'telefono' => $fila['telefono'],
            'tipoPermiso' => $fila['tipoPermiso'],
            'fechaInicio' => $fila['fechaInicio'],
            'fechaFin' => $fila['fechaFin'],
            'remunerado' => $fila['remunerado']
        );
    }
    
    $jsonString = json_encode($json);
    echo $jsonString;

}else{ //BUSCAMOS TODOS LOS REGISTROS DE PERMISOS

    //Actualizamos las fechas de cumpleaños que ya pasaron y las ajustamos al siguiente año
    $consulta1 = "UPDATE permisos 
    SET fechaInicio = DATE_ADD(fechaInicio,INTERVAL 1 YEAR)
    WHERE tipoPermisoId = 5 AND fechaInicio < CURDATE()";

    $resultado1 = mysqli_query($enlace,$consulta1);
    
    // seleccionamos el listado de permisos con las fechas ya actualizadas
    $consulta2 = "SELECT
    permisos.usuarioId AS usuarioId,
    permisos.id  AS permisoId,
    usuarios.nombre AS nombre,
    usuarios.apellido AS apellido,
    usuarios.telefono AS telefono,
    tipo_permisos.descripcion AS tipoPermiso,
    permisos.fechaInicio AS fechaInicio,
    permisos.fechaFin AS fechaFin,
    permisos.remunerado AS remunerado
    FROM permisos 
    JOIN usuarios ON permisos.usuarioId = usuarios.id
    JOIN tipo_permisos ON permisos.tipoPermisoId = tipo_permisos.id
    WHERE usuarios.estado = 1
    ORDER BY permisos.tipoPermisoId, usuarios.nombre  ASC";
    
    $resultado2 = mysqli_query($enlace, $consulta2);

    if(!$resultado2){

        die('Error de consulta '. mysqli_error($enlace));
    }
    

    $json = array();
    while($fila = mysqli_fetch_array($resultado2)) {

        $json[]= array(
            'usuarioId' => $fila['usuarioId'],
            'permisoId' => $fila['permisoId'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'telefono' => $fila['telefono'],
            'tipoPermiso' => $fila['tipoPermiso'],
            'fechaInicio' => $fila['fechaInicio'],
            'fechaFin' => $fila['fechaFin'],
            'remunerado' => $fila['remunerado']
        );
    }
    
    $jsonString = json_encode($json);
    echo $jsonString;
    
}



?>