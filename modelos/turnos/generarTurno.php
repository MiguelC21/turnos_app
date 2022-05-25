<?php 
// Includes
include "../config/conexion.php";
include "../config/zonaHoraria.php";
// include "../reportes/reportes.php";
// include "D:/PROGRAMACION/XAMPP/htdocs/turnos-app/reportes/reportes.php";

///////////////////////////////////VALIDACION NUMERO TURNOS-EMPLEADOS//////////////////////////
//Para obtener un resultado optimo necesitamos tener al menos 
//consulta numero de empleados disponibles
$consulta2 = mysqli_query($enlace, "SELECT
id
FROM usuarios
WHERE estado = 1 AND permiso = 0;
");
//consulta del nuemro total de turnos actuales
$consulta = mysqli_query($enlace, "SELECT
puestos_horarios.id
FROM puestos_horarios
JOIN puestos_trabajo ON puestos_horarios.puestoTrabajoId = puestos_trabajo.id
WHERE puestos_trabajo.estado = 1;
");

//Resultados
$totalUsuarios = mysqli_num_rows($consulta2);
$totalTurnos = mysqli_num_rows($consulta);
$totalTurnos = $totalTurnos + 3;


if($totalUsuarios < $totalTurnos){
    $msg = 'error';
    $msg = json_encode($msg);
    echo $msg;
}else{
    //////////////////////////////////////////PARAMETROS////////////////////////////////////////////
    //ULTIMA FECHA GENEARADA Y FECHA ACTUAL
    $consulta0 = mysqli_query($enlace, "SELECT fechaTurno FROM turnos_usuarios ORDER by fechaTurno DESC LIMIT 1");
    $nRows = mysqli_num_rows($consulta0);
    $fechaActual = date('Ymd');
    if ($nRows > 0){
        $ultimaFechaTurno = mysqli_fetch_array($consulta0);
        $ultimaFechaTurno = $ultimaFechaTurno['fechaTurno'];
        $ultimaFechaTurno = date('Ymd', strtotime($ultimaFechaTurno. ' + 0 days'));
    }
    
    // FECHA ENTREGADA POR EL USUARIO Y CONDICIONALES
    if (isset($_POST["fechaUser"]) AND $_POST["fechaUser"] != ''){
        $fechaUser = $_POST["fechaUser"];
        $fechaUser = date('Ymd', strtotime($fechaUser. ' + 0 days'));
        if (isset($ultimaFechaTurno) AND $fechaUser <= $ultimaFechaTurno){
            $consulta = mysqli_query($enlace, "DELETE FROM turnos_usuarios WHERE fechaTurno >= '$fechaUser'");
            $curFecha = $fechaUser;
            $msg = $curFecha;
        }else{
            $curFecha = $fechaUser;
            $msg = $curFecha;
        }
    }else{
        if(isset($ultimaFechaTurno) AND $ultimaFechaTurno >= $fechaActual){
            $curFecha = date('Ymd', strtotime($ultimaFechaTurno. ' + 1 days'));
            $msg = 'fecha ultimo turno';
        }else{
            $curFecha = $fechaActual;
            $msg = $curFecha;
        }
    }

    // $msg = json_encode($msg);
    // echo $msg;


    $dia = date('d', strtotime($curFecha. ' + 0 days'));
    $listaTurnos = array();
    $e = 0;//empleados

    ////////////////////BUCLE PARA GENERAR EL LISTADO DE LA TABLA LISTA TURNOS////////////////////
    for($i=1; $i<=14; $i++){  //Longitud recorridos del for es igual al numero de dias a generar
        // echo "<h1></h1>";
        // echo "   /  -- DIA .$dia.--  /   ";
        // echo $curFecha;
        
        $listaEmpleados = array();
        $listaPuestosHorarios = array();
        //CONSULTA LISTADO DE EMPLEADOS DISPONIBLES (pendiente poner fecha a consultar)
        $consuta1 = "SELECT id, nombre, apellido, telefono
        FROM usuarios
        WHERE estado = 1 AND id NOT IN (SELECT usuarioId FROM permisos WHERE fechaInicio <= $curFecha AND fechaFin >= $curFecha) 
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
                'fechaTurno' => $curFecha,
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
        

        // echo $curFecha;
        $curFecha = date('Ymd', strtotime($curFecha. ' + 1 days'));

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



    // respuesta
    $msg = 'generados';
    $msg = json_encode($msg);
    echo $msg;

}






//////////////////PRUEBAS EN CONSOLA//////////////////







