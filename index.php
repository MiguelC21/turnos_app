<?php 
// Includes
include "./modelos/config/conexion.php";
include "./modelos/config/zonaHoraria.php";



$consulta = "SELECT
turnos_usuarios.id AS turnoId,
usuarios.id AS usuarioId,
usuarios.nombre AS nombre,
usuarios.apellido AS apellido,
puestos_horarios.tipoTurnoId AS tipoTurno,
puestos_trabajo.codigo AS puestoTrabajo,
turnos_usuarios.fechaTurno AS fechaTurno,
puestos_horarios.horaInicio AS horaInicio,
puestos_horarios.horaFin AS horaFin
FROM turnos_usuarios
JOIN puestos_horarios ON turnos_usuarios.puestoHorarioId = puestos_horarios.id
JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
JOIN usuarios ON turnos_usuarios.usuarioId = usuarios.id
WHERE turnos_usuarios.fechaTurno >= '$fechaConsulta'
ORDER BY usuarios.id ASC, turnos_usuarios.id ASC ;
";
?>
