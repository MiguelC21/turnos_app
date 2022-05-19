<?php 

// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";

//Consultas

if(isset($_POST['buscarT']) && $_POST["buscarT"] != ""){
    //Buscar
    $buscar = $_POST["buscarT"];
    $consulta = "SELECT
    turnos_usuarios.id AS turnoId,
    usuarios.nombre AS nombre,
    usuarios.apellido AS apellido,
    usuarios.telefono AS telefono,
    puestos_trabajo.codigo AS puestoTrabajo,
    puestos_horarios.horaInicio AS horaInicio,
    puestos_horarios.horaFin AS horaFin,
    puestos_horarios.observacion AS observacion,
    turnos_usuarios.fechaTurno AS fechaTurno
    FROM turnos_usuarios
    JOIN puestos_horarios ON turnos_usuarios.puestoHorarioId = puestos_horarios.id
    JOIN usuarios ON turnos_usuarios.usuarioId = usuarios.id
    JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
    WHERE usuarios.nombre LIKE '%$buscar%' OR usuarios.apellido LIKE '%$buscar%' OR usuarios.telefono LIKE '%$buscar%' OR puestos_trabajo.codigo LIKE '%$buscar%' OR puestos_horarios.horaInicio LIKE '%$buscar%' OR puestos_horarios.horaFin LIKE '%$buscar%' OR puestos_horarios.observacion LIKE '%$buscar%' OR turnos_usuarios.fechaTurno LIKE '%$buscar%'
    ORDER BY turnos_usuarios.fechaTurno DESC, usuarios.nombre ASC 
    LIMIT 500;
    ";

    $resultado = mysqli_query($enlace, $consulta);

    if(!$resultado){

        die('Error de consulta '. mysqli_error($enlace));
    }

    $json = array();
    while($fila = mysqli_fetch_array($resultado)) {

        $json[]= array(
            'turnoId' => $fila['turnoId'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'telefono' => $fila['telefono'],
            'puestoTrabajo' => $fila['puestoTrabajo'],
            'horaInicio' => $fila['horaInicio'],
            'horaFin' => $fila['horaFin'],
            'fechaTurno' => $fila['fechaTurno'],
            'observacion' => $fila['observacion']
        );
    }

    $jsonString = json_encode($json);
    echo $jsonString;

}else{
    //Seleccionar todos
    $consulta = "SELECT
    turnos_usuarios.id AS turnoId,
    usuarios.nombre AS nombre,
    usuarios.apellido AS apellido,
    usuarios.telefono AS telefono,
    puestos_trabajo.codigo AS puestoTrabajo,
    puestos_horarios.horaInicio AS horaInicio,
    puestos_horarios.horaFin AS horaFin, 
    puestos_horarios.observacion AS observacion,
    turnos_usuarios.fechaTurno AS fechaTurno
    FROM turnos_usuarios
    JOIN puestos_horarios ON turnos_usuarios.puestoHorarioId = puestos_horarios.id
    JOIN usuarios ON turnos_usuarios.usuarioId = usuarios.id
    JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
    ORDER BY turnos_usuarios.fechaTurno DESC
    LIMIT 500;
    ";

    $resultado = mysqli_query($enlace, $consulta);

    if(!$resultado){

        die('Error de consulta '. mysqli_error($enlace));
    }

    $json = array();
    while($fila = mysqli_fetch_array($resultado)) {

        $json[]= array(
            'turnoId' => $fila['turnoId'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'telefono' => $fila['telefono'],
            'puestoTrabajo' => $fila['puestoTrabajo'],
            'horaInicio' => $fila['horaInicio'],
            'horaFin' => $fila['horaFin'],
            'fechaTurno' => $fila['fechaTurno'],
            'observacion' => $fila['observacion']
        );
    }

    $jsonString = json_encode($json);
    echo $jsonString;
}

?>