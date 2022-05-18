<?php 
// Includes


$diaSemana = array (
    'Mon' => 'Lunes',
    "Tue" => 'Martes',
    'Wed' => 'Miercoles',
    'Thu' => 'Jueves',
    'Fri' => 'Viernes',
    'Sat' => 'sabado',
    'Sun' => 'Domingo'
);
$meses = array('Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

$dia = date('D');
$mes = date('n');

echo $diaSemana['Tue'];
echo $meses[$mes-1]
?>
