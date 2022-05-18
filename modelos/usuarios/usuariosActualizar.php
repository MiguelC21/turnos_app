<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

// Actualizar
if(isset($_POST['accion'] ) && $_POST['accion'] == "actualizarEstado"){
    //Estado
    
    $idUsuario = $_POST['idUsuario'];
    $estado = $_POST['estado'];

    if($estado=="ACTIVO"){
        
        $actualiza = "UPDATE usuarios SET estado = 0 WHERE id = '$idUsuario'";
        mysqli_query($enlace, $actualiza);
        
    }elseif($estado=='INACTIVO'){
        
        $actualiza = "UPDATE usuarios SET estado= 1 WHERE id = '$idUsuario'";
        mysqli_query($enlace, $actualiza);
    }
        

}elseif(isset($_POST['accion']) && $_POST['accion'] == "actualizarDatos"){
    //Otros datos
    $idUsuario = $_POST['idUsuario'];
    $actualiza = "SELECT * FROM usuarios WHERE id = '$idUsuario'";

    $resultado = mysqli_query($enlace, $actualiza);
    
    if(!$resultado){

        die('Error de consulta '. mysqli_error($enlace));
    }

    $json = array();
    while($fila = mysqli_fetch_array($resultado)) {
    
        $json[]= array(
            'id' => $fila['id'],
            'tipoDocumento' => $fila['tipoDocumentoId'],
            'nDocumento' => $fila['documento'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'correo' => $fila['correo'],
            'telefono' => $fila['telefono'],
            'fechaNacimiento' => $fila['fechaNacimiento'],
            'fechaRegistro' => $fila['fechaRegistro'],
            'estado' => $fila['estado']
        );

    }
    
    $jsonString = json_encode($json[0]);
    echo $jsonString;

    

}

// actualiza los cambios

if(isset($_POST['nombre']) && $_POST["nombre"] != ""){
    $idUsuario = $_POST['id'];
    $tipoDocumento = $_POST["tipoDocumento"];
    $nDocumento = $_POST['nDocumento'];
    $nombre = $_POST["nombre"];
    $apellido = $_POST["apellido"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    $fechaNacimiento = $_POST["fechaNacimiento"];
    
    $consulta = "UPDATE usuarios SET 
    documento = '$nDocumento',
    nombre = '$nombre',
    apellido ='$apellido',
    correo = '$correo',
    telefono = '$telefono',
    fechaNacimiento = '$fechaNacimiento'
    WHERE 
    id = '$idUsuario'";

    //Verificamos error documento repetido

    $inserta = true;
    
    try {
        $resultado = mysqli_query($enlace, $consulta);
    } catch(Exception $ex){
        // echo "Error consulta: " .$ex->getMessage();
        $resp = 'repetido';
        $json = json_encode($resp);
        echo $json;
        $inserta = false;
    }

    if($inserta){
         //Actualizamos la fecha del permiso de cumpleaños
    $año = date('Y');//obtengo año actual
    $dia = date('d', strtotime($fechaNacimiento));//extraigo el dia de la fecha de nacimiento
    $mes = date('m', strtotime($fechaNacimiento));//extraigo el mes de la fecha de nacimiento
    $permiso = date('Y-m-d', strtotime("$año-$mes-$dia"));//convierto los datos a tipo date(fecha)

    $actPermisoCumple = "UPDATE permisos SET 
    fechaInicio = '$permiso', 
    fechaFin = '$permiso' 
    WHERE usuarioId = '$idUsuario' AND tipoPermisoId = 5";

    mysqli_query($enlace, $actPermisoCumple);

    $resp = 'sigue';
    $json = json_encode($resp);
    echo $json;
    
    }

    
    
}

?>