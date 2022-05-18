<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//Devuelve los datos a actualizar
if (isset($_POST["idPermiso"])){

    $idPermiso = $_POST['idPermiso'];
    $datos = "SELECT
    permisos.usuarioId AS usuarioId,
    permisos.id  AS permisoId,
    usuarios.nombre AS nombre,
    usuarios.apellido AS apellido,
    permisos.tipoPermisoId AS tipoPermiso,
    permisos.fechaInicio AS fechaInicio,
    permisos.fechaFin AS fechaFin,
    permisos.remunerado AS remunerado
    FROM permisos 
    JOIN usuarios ON permisos.usuarioId = usuarios.id
    JOIN tipo_permisos ON permisos.tipoPermisoId = tipo_permisos.id
    WHERE permisos.id = '$idPermiso'
    LIMIT 1";

    $resultado = mysqli_query($enlace, $datos);
    
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
            'tipoPermiso' => $fila['tipoPermiso'],
            'fechaInicio' => $fila['fechaInicio'],
            'fechaFin' => $fila['fechaFin'],
            'remunerado' => $fila['remunerado']
        );
        
    }
    
    $jsonString = json_encode($json[0]);
    echo $jsonString;

}

//Actualiza los cambios realizados
if(isset($_POST['permisoId'])){
    $usuarioId = $_POST['usuarioId'];
    $permisoId = $_POST['permisoId'];
    $tipoPermiso = $_POST['tipoPermiso'];
    $fechaInicio = $_POST['fechaInicio'];
    $fechaFin = $_POST['fechaFin'];
    $remunerado = $_POST['remunerado'];

    $actualizar = "UPDATE permisos SET 
    tipoPermisoId = '$tipoPermiso',
    fechaInicio = '$fechaInicio',
    fechaFin = '$fechaFin',
    remunerado = '$remunerado'
    WHERE
    id = '$permisoId'";

    mysqli_query($enlace, $actualizar);
    
    //Actualizamos el estado del permiso

    $hoy = date('Y-m-d');  //fecha actual para comparar

    if($hoy >= $fechaInicio &&  $hoy <= $fechaFin){ //Modificar
        
        $consulta = "UPDATE usuarios SET permiso = 1 WHERE id = '$usuarioId' ";
        mysqli_query($enlace, $consulta);

    }else{
        
        $consulta = "UPDATE usuarios SET permiso = 0 WHERE id = '$usuarioId' ";
        mysqli_query($enlace, $consulta);
    }

    
    



}
