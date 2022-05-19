<?php 
// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";
// include "../reportes/reportes.php";
// include "D:/PROGRAMACION/XAMPP/htdocs/turnos-app/reportes/reportes.php";


//////////////////////////////////////////PARAMETROS////////////////////////////////////////////
// consultamos la ultima fecha generada
$consulta0 = mysqli_query($enlace, "SELECT fechaTurno FROM turnos_usuarios ORDER by fechaTurno DESC LIMIT 1");
$ultimaFechaTurno = mysqli_fetch_array($consulta0);
$fecha = $ultimaFechaTurno['fechaTurno'];
$fecha = date('Ymd', strtotime($fecha. ' + 1 days'));


// $fecha= date('Ymd');
$dia = date('d', strtotime($fecha. ' + 0 days'));
$listaTurnos = array();
$e = 0;//empleados

////////////////////BUCLE PARA GENERAR EL LISTADO DE LA TABLA LISTA TURNOS////////////////////
for($i=1; $i<=14; $i++){  //Longitud recorridos del for es igual al numero de dias a generar
    // echo "<h1></h1>";
    // echo "   /  -- DIA .$dia.--  /   ";
    // $fecha ="{$año}{$mes}{$dia}";
    $listaEmpleados = array();
    $listaPuestosHorarios = array();
    //CONSULTA LISTADO DE EMPLEADOS DISPONIBLES (pendiente poner fecha a consultar)
    $consuta1 = "SELECT id, nombre, apellido, telefono
    FROM usuarios
    WHERE estado = 1 AND id NOT IN (SELECT usuarioId FROM permisos WHERE fechaInicio <= $fecha AND fechaFin >= $fecha) 
    ORDER BY id ASC;
    ";

    $resultado1 = mysqli_query($enlace, $consuta1);

    while($fila =mysqli_fetch_array($resultado1)){
        $listaEmpleados[] = array(
            'usuarioId' => $fila['id'],
            'nombre' => $fila['nombre'],
            'apellido' => $fila['apellido'],
            'telefono' => $fila['telefono']
        );
    }
    
    //CONSULTA LISTADO DE PUESTO HORARIOS
    $consulta2 = "SELECT
    puestos_horarios.id AS id, 
    puestos_trabajo.codigo AS puestoTrabajo, 
    puestos_horarios.horaInicio AS horaInicio, 
    puestos_horarios.horaFin AS horaFin, 
    puestos_horarios.observacion AS observacion
    FROM puestos_horarios
    JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
    WHERE puestos_trabajo.estado = 1;
    ";

    $resultado2 = mysqli_query($enlace, $consulta2);

    while($fila =mysqli_fetch_array($resultado2)){
        $listaPuestosHorarios[] = array(
            'puestoId' => $fila['id'],
            'puestoTrabajo' => $fila['puestoTrabajo'],
            'horaInicio' => $fila['horaInicio'],
            'horaFin' => $fila['horaFin'],
            'observacion' => $fila['observacion']
        );
    }


    //bucle recorrido de n° turnos
    $h = 0;//horario
    while(count($listaPuestosHorarios)>0){
        // echo $e;
        // echo $listaEmpleados[$e]['nombre'];
        // echo " - ";
        $listaTurnos[]=array(
            'fechaTurno' => $fecha,
            'usuarioId' => $listaEmpleados[$e]['usuarioId'],
            'nombre' => $listaEmpleados[$e]['nombre'],
            'puesto' => $listaPuestosHorarios[$h]['puestoTrabajo'],
            'puestoId' => $listaPuestosHorarios[$h]['puestoId'],
            'horaInicio' => $listaPuestosHorarios[$h]['horaInicio'],
            'horaFin' => $listaPuestosHorarios[$h]['horaFin']
        );
        
        unset($listaPuestosHorarios[$h]);
        $e++;
        $h++;
        if ($e == (count($listaEmpleados))){
            $e = 0;
        }
    }
    
    
    $dia++;
    

    // echo $fecha;
    $fecha = date('Ymd', strtotime($fecha. ' + 1 days'));

}


// ______________________________________________________________


////////////////////PROCESO DE INSERCION DE DATOS A LA TABLA turnos_usuarios//////////////////
$i=0;
while($i < count($listaTurnos)){
    $usuario = $listaTurnos[$i]['usuarioId'];
    $puesto = $listaTurnos[$i]['puestoId'];
    $fecha = $listaTurnos[$i]['fechaTurno'];
    $consulta3 = "INSERT INTO turnos_usuarios VALUES (null, $usuario, $puesto, DEFAULT, $fecha)";
    mysqli_query($enlace, $consulta3);
    $i++;

}


//Vamos al documento donde se encuentra la plantilla del excel con los turnos a disposicion

// echo '<meta http-equiv="refresh" content="0; url=/turnos-app/reportes/reportes.php">';

// echo '<meta http-equiv="refresh" content="0; url=/turnos-app/vistas/turnos.html">';











































//////////////////PRUEBAS EN CONSOLA//////////////////


//CONSULTA LISTADO DE PUESTO HORARIOS

// $consulta2 = "SELECT
// puestos_horarios.id AS id, 
// puestos_trabajo.codigo AS puestoTrabajo, 
// puestos_horarios.horaInicio AS horaInicio, 
// puestos_horarios.horaFin AS horaFin, 
// puestos_horarios.observacion AS observacion
// FROM puestos_horarios
// JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
// WHERE puestos_trabajo.estado = 1;
// ";

// $resultado2 = mysqli_query($enlace, $consulta2);

// while($fila =mysqli_fetch_array($resultado2)){
//     $listaPuestosHorarios[] = array(
//         'puestoTrabajo' => $fila['puestoTrabajo'],
//         'horaInicio' => $fila['horaInicio'],
//         'horaFin' => $fila['horaFin'],
//         'observacion' => $fila['observacion']
//     );
// }


// //Parametros
// $nEmpleados = count($listaEmpleados);
// $nTurnos = count($listaPuestosHorarios);
// $nTotal = count($listaTurnos);


// //Mostrando los arreglos en console

// $jsonE = json_encode($listaEmpleados);
// $jsonP = json_encode($listaPuestosHorarios);
// $jsonT = json_encode($listaTurnos);

?>
// <script>
    console.log(<?php echo $jsonE;?> );
    console.log(<?php echo $jsonP;?> );
    console.log(<?php echo $jsonT;?> );
    console.log(<?php echo $nEmpleados;?> );
    console.log(<?php echo $nTurnos;?> );
    console.log(<?php echo $nTotal;?> );
</script>



