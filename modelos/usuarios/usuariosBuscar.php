<?php

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

$buscar =  $_POST["buscar"] ?? "0";
//Buscar usuarios
if (!empty($buscar)) {

    $consulta = "SELECT 
    usuarios.id As 'id', 
    tipo_documentos.descripcion AS 'tipoDocumentoId', 
    usuarios.documento AS 'documento',
    usuarios.nombre AS 'nombre',
    usuarios.apellido AS 'apellido',
    usuarios.correo AS 'correo',
    usuarios.telefono AS 'telefono',
    usuarios.fechaNacimiento AS 'fechaNacimiento',
    usuarios.fechaRegistro AS 'fechaRegistro',
    usuarios.estado AS 'estado',
    usuarios.permiso AS 'permiso'
    FROM usuarios
    JOIN tipo_documentos ON usuarios.tipoDocumentoId = tipo_documentos.id 
    WHERE usuarios.nombre LIKE '%$buscar%' OR usuarios.apellido LIKE '%$buscar%' OR usuarios.documento LIKE '$buscar%'
    ORDER BY usuarios.id DESC";


    $resultado = mysqli_query($enlace, $consulta);

    if (!$resultado) {

        die('Error de consulta ' . mysqli_error($enlace));
    }

    $json = array();
    while ($fila = mysqli_fetch_array($resultado)) {

        $json[] = array(
            'id' => $fila['id'],
            'tipoDocumento' => $fila['tipoDocumentoId'],
            'nDocumento' => $fila['documento'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'correo' => $fila['correo'],
            'telefono' => $fila['telefono'],
            'fechaNacimiento' => $fila['fechaNacimiento'],
            'fechaRegistro' => $fila['fechaRegistro'],
            'permiso' => $fila['permiso'],
            'estado' => $fila['estado']
        );
    }

    $jsonString = json_encode($json);
    echo $jsonString;
} else {


    //SELECION TODOS LOS DE LA TABLA USUARIOS
    $consulta = "SELECT 
usuarios.id As 'id',
tipo_documentos.descripcion AS 'tipoDocumentoId', 
usuarios.documento AS 'documento',
usuarios.nombre AS 'nombre',
usuarios.apellido AS 'apellido',
usuarios.correo AS 'correo',
usuarios.telefono AS 'telefono',
usuarios.fechaNacimiento AS 'fechaNacimiento',
usuarios.fechaRegistro AS 'fechaRegistro',
usuarios.estado AS 'estado',
usuarios.permiso AS 'permiso'
FROM usuarios 
JOIN tipo_documentos ON usuarios.tipoDocumentoId = tipo_documentos.id
ORDER BY usuarios.nombre ASC;";
    $resultado = mysqli_query($enlace, $consulta); 

    if (!$resultado) {

        die('Error de consulta ' . mysqli_error($enlace));
    }

    $json = array();
    while ($fila = mysqli_fetch_array($resultado)) {
        //------------------------------------------------------------------ 
        // actualizamos los estados del los permisos
        $usuarioId = $fila['id'];
        //Consulatamos los registros del usuario en permisos
        $hoy = date('Y-m-d');  //fecha actual para comparar
        $consulta2 = "SELECT fechaInicio, fechaFin 
        FROM permisos
        WHERE usuarioId = '$usuarioId'";
        $resultado2 = mysqli_query($enlace, $consulta2);
        while ($obj = mysqli_fetch_array($resultado2)){
            $fechaInicio = $obj['fechaInicio'];
            $fechaFin = $obj['fechaFin'];
            if($hoy >= $fechaInicio &&  $hoy <= $fechaFin){ //Actualizar estado
                
                $consulta = "UPDATE usuarios SET permiso = 1 WHERE id = '$usuarioId' ";
                mysqli_query($enlace, $consulta);

            }else{
                
                $consulta = "UPDATE usuarios SET permiso = 0 WHERE id = '$usuarioId' ";
                mysqli_query($enlace, $consulta);
            }
        }
        
        // ---------------------------------------------------------------
        $json[] = array(
            'id' => $fila['id'],
            'tipoDocumento' => $fila['tipoDocumentoId'],
            'nDocumento' => $fila['documento'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'correo' => $fila['correo'],
            'telefono' => $fila['telefono'],
            'fechaNacimiento' => $fila['fechaNacimiento'],
            'fechaRegistro' => $fila['fechaRegistro'],
            'permiso' => $fila['permiso'],
            'estado' => $fila['estado']
        );
    }

    $jsonString = json_encode($json);
    echo $jsonString;
}

