<?php

require '../modelos/config/conexion.php';
require '../modelos/config/zonaHoraria.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

$spreadsheet = new Spreadsheet();
$spreadsheet->getProperties()->setCreator("Turnos-app")->setTitle('Turnos___');

$spreadsheet->setActiveSheetIndex(0);
$hojaActiva = $spreadsheet->getActiveSheet();
// Tipo de letra y tamaño de letra general
$spreadsheet->getDefaultStyle()->getFont()->setName('Calibri');
$spreadsheet->getDefaultStyle()->getFont()->setSize(11);

//Stilos del bordes de la tabla
$styleArray = [
    'borders' => [
        'outline' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['argb' => '212529'],
        ],
    ],
];

// Encabezados de la hoja (DATOS)
$hojaActiva
->setCellValue('A2', 'FUNCIONARIOS')
->setCellValue('A3', '2Q MARZO 02')
->setCellValue('B2', 'J')
->setCellValue('B3', '02')
->setCellValue('C2', 'V')
->setCellValue('C3', '03')
->setCellValue('D2', 'S')
->setCellValue('D3', '04')
->setCellValue('E2', 'D')
->setCellValue('E3', '05')
->setCellValue('F2', 'L')
->setCellValue('F3', '06')
->setCellValue('G2', 'M')
->setCellValue('G3', '07')
->setCellValue('H2', 'M')
->setCellValue('H3', '08')
->setCellValue('I2', 'J')
->setCellValue('I3', '09');

// Tamaños de las celdas
$hojaActiva->getColumnDimension('A')->setWidth(40);
$hojaActiva->getColumnDimension('B')->setWidth(10);
$hojaActiva->getColumnDimension('C')->setWidth(10);
$hojaActiva->getColumnDimension('D')->setWidth(10);
$hojaActiva->getColumnDimension('E')->setWidth(10);
$hojaActiva->getColumnDimension('F')->setWidth(10);
$hojaActiva->getColumnDimension('G')->setWidth(10);
$hojaActiva->getColumnDimension('H')->setWidth(10);
$hojaActiva->getColumnDimension('I')->setWidth(10);

//Estilos del encabezado
$spreadsheet->getActiveSheet()->getStyle('A2:I3')->getFont()->setBold(true);
$spreadsheet->getActiveSheet()->getStyle('A2:I3')->getAlignment()->setHorizontal('center');
$spreadsheet->getActiveSheet()->getStyle('A2:I3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('F2F2F2');
$spreadsheet->getActiveSheet()->getStyle('A2:I3')->getFont()->getColor()->setRGB('FFFFFF');
// Aplicando bordes
$spreadsheet->getActiveSheet()->getStyle('A2:I3')->applyFromArray($styleArray);




header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Plantilla_turnos.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');


// $writer = new Xlsx($spreadsheet);
// $writer->save('Planilla_turnos.xlsx');

