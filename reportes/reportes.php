<?php



require '../modelos/config/zonaHoraria.php';
require '../vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;


//////////////////////////////////////////////////////////////////Cargamos la plantilla/////////////////////////////////////////////////////////
$reader = IOFactory::createReader('Xlsx');
$spreadsheet = $reader->load('../reportes/plantilla.xlsx');

//CONSULATAMOS LA ULTIMA FECHA GENERADA EN LA BASE DE DATOS
$enlace = mysqli_connect('localhost', 'root', '', 'turnos-app'); //Conexion a la base de datos 

$consulta0 = mysqli_query($enlace, "SELECT fechaTurno FROM turnos_usuarios ORDER by fechaTurno DESC LIMIT 1");
$nRows = mysqli_num_rows($consulta0);
$fechaActual = date('Y-m-d');
//Validamos si la ultima fecha generada es mayor o igaul a la fecha actual
if($nRows > 0 ){
    $ultimaFechaTurno = mysqli_fetch_array($consulta0);
    if($ultimaFechaTurno >= $fechaActual){
        $fecha = $ultimaFechaTurno['fechaTurno'];
        $curFecha = date('Y-m-d', strtotime($fecha. ' - 13 days'));
    }
}else{
    $curFecha = date('Y-m-d', strtotime($fechaActual. ' + 1 days'));
}


// echo "<h1></h1>";
//Datos encabezado para 7 dias
$fechaConsulta = $curFecha;
// echo $fechaConsulta;

$mes = date('n', strtotime($curFecha));
$dia = date('d', strtotime($curFecha));
$diaL = date('D', strtotime($curFecha));
$fechaNombre = $curFecha;
//convirtiendo fechas a español
$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
$diaSemana = array (
    'Mon' => 'Lun',
    'Tue' => 'Mar',
    'Wed' => 'Mie',
    'Thu' => 'Jue',
    'Fri' => 'Vie',
    'Sat' => 'Sab',
    'Sun' => 'Dom'
);



$sheet = $spreadsheet->getActiveSheet();
//Agregamos el nombre del mes
$sheet->setCellValue('A3', $meses[$mes-1].' '.$dia);

$ascii = 66;
for($i=1; $i <= 14; $i++){
    $letra = chr($ascii);

    $sheet->setCellValue($letra.'3', $dia);
    $sheet->setCellValue($letra.'2', $diaSemana[$diaL]);

    $dia = date('d', strtotime($curFecha. " + {$i} days"));
    $diaL = date('D', strtotime($curFecha. " + {$i} days"));

    $ascii++;
}






///////////////////////////////////////AGREGAMOS EL CONTENIDO A LA PLANTILLA/////////////////////////////////////////////

//Traemos los datos de nuetra base de datos
$consulta1 = "SELECT
usuarios.id AS usuarioId,
usuarios.nombre AS nombre,
usuarios.apellido AS apellido
FROM turnos_usuarios
JOIN usuarios ON turnos_usuarios.usuarioId = usuarios.id
WHERE turnos_usuarios.fechaTurno >= '$fechaConsulta'
GROUP BY usuarios.id
ORDER BY usuarios.id ASC;
";

$consulta2 = "SELECT
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

$resultado1 = mysqli_query($enlace, $consulta1);



// ________________________________________________


//Recorremos los datos
$contentStartRow = 4;
$currentContentRow = 4;

while($fila=mysqli_fetch_array($resultado1)){

    $nombreCompleto = "{$fila['nombre']} {$fila['apellido']}";
    $spreadsheet->getActiveSheet()->insertNewRowBefore($currentContentRow+1); //Agregamos una nueva columna
    $sheet->setCellValue('A'.$currentContentRow, $nombreCompleto); //Agregamos los usuarios

    $ascii = 66;
    $userId = $fila['usuarioId'];//Current user
    // echo 'vuelta-';
    $currentFecha = $curFecha;//current fecha

    $resultado2 = mysqli_query($enlace, $consulta2);
    while($col = mysqli_fetch_array($resultado2)){
        $letra = chr($ascii);
        $curUser = $col['usuarioId'];
        $fechaTurno = $col['fechaTurno'];
        $pasa=false;
        // echo chr($ascii);
        $intentos = 0;
        while(!$pasa){
            $letra = chr($ascii);
            if($userId == $curUser){
                // echo "<h1></h1>";
                // echo $userId;
                // echo "-.$curUser";
                // echo "<h1></h1>";
                // echo "$fechaTurno. fecha turno";
                // echo "<h1></h1>";
                // echo "$currentFecha. fecha dia";
                // echo "<h1></h1>";
                // echo $col['tipoTurno'];
                // echo "-";
                // echo $col['puestoTrabajo'];
                

                if($fechaTurno == $currentFecha){
                    $sheet->setCellValue($letra.$currentContentRow, $col['tipoTurno'].$col['puestoTrabajo']);
                    $sheet->getStyle($letra.$currentContentRow)->getAlignment()->setHorizontal('center');
                    $currentFecha = date('Y-m-d', strtotime($currentFecha. ' + 1 days'));
                    $pasa= true;
                }else{
                    $sheet->setCellValue($letra.$currentContentRow, 'L');
                    $sheet->getStyle($letra.$currentContentRow)->getAlignment()->setHorizontal('center');
                    $currentFecha = date('Y-m-d', strtotime($currentFecha. ' + 1 days'));
                    // echo "<h1></h1>";
                    // echo 'Turno Libre - sumar fecha y reasigna turno al puesto anterior';
                    // echo "<h1></h1>";
                    // echo "$fechaTurno. fecha turno";
                    // echo "<h1></h1>";
                    // echo "$currentFecha. fecha dia";
                    // echo "<h1></h1>";
                    // echo "<h1></h1>";
                    // echo $col['tipoTurno'];
                    // echo "-";
                    // echo $col['puestoTrabajo'];
                    
                    $pasa= false;
                }
                // echo "<h1>----------------------------------------------</h1>";
                if($ascii==79){
                    $ascii=65;
                }
                $ascii++;
                
            }
            if ($intentos > 15){
                $pasa =true;
            }
            $intentos++;
            // echo "<h1></h1>";
            // echo $intentos;
            
            
            
        }

    }
    // echo "<h4>----------------------Nuevo User------------------------</h4>";
    $currentContentRow++;

}












////////////////////////////AGREGAMOS LA INFORMACION DE LOS TRUNOS A LA HOJA ////////////////////////////
$currentContentRow = $currentContentRow +3;

$consulta3 = "SELECT codigo, horaInicio, horaFin FROM tipo_turnos WHERE estado = 1";
$tipoTurnos = mysqli_query($enlace, $consulta3);


$color = new \PhpOffice\PhpSpreadsheet\Style\Color('#5F32BD');
$sheet->getStyle('A'.$currentContentRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


$sheet->setCellValue('A'.$currentContentRow, "Cod Horario:");
$sheet->getStyle('A'.$currentContentRow)->getAlignment()->setHorizontal('center');

$currentContentRow++;


while($col = mysqli_fetch_array($tipoTurnos)){

    $sheet->setCellValue('A'.$currentContentRow, " {$col['codigo']}:   De {$col['horaInicio']} a {$col['horaFin']}");
    $sheet->getStyle('A'.$currentContentRow)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


    $currentContentRow++;

}












//////////////////////////////////////////////////////GENERAMOS LA DESCAGA DEL DUCUMENTO///////////////////////////////////////////

$fechaRango = date('Ymd', strtotime($fechaNombre. ' + 13 days'));
$nombrePlantilla = "Turnos_{$fechaNombre}__{$fechaRango}.xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename=.{$nombrePlantilla}");
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');



?>
