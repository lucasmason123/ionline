<?php

$meses = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12);
$corte1 = array(1, 2, 3);
$naccionescorte1 = 4;
$naccionescorte2 = 2;
$naccionescorte3 = 1;
$naccionescorte4 = 3;

/***********  META 10.1 ************/
/* ==== Inicializar variables ==== */
$data10_1 = array();
$data10_1['label']['meta'] = '10.1 Porcentaje de cumplimiento de las acciones para el fortalecimiento del programa Más
Adultos Mayores Autovalentes en el periodo.';
//PONDERACION GLOBAL Y DE LOS 4 CORTES
$data10_1['ponderacion'] = '1,0%';
$data10_1[1]['anual'] = 15;
$data10_1[2]['anual'] = 25;
$data10_1[3]['anual'] = 25;
$data10_1[4]['anual'] = 25;
//POONDERACCIÓN ACCIONES [N°ACCION]
//$data10_1['meta'] = '100%';





//DATOS PARA INDICADORES ACCIÓN 1
$data10_1[1]['accion'] = 'Envío de Informe Técnico validado por Director de Servicio de Salud que contenga para este
indicador:<br>
- Información Diagnóstica sobre la capacitación de Líderes Comunitarios del Programa Más
Adultos Mayores Autovalentes en las comunas y establecimientos de su jurisdicción a marzo
2020, dando cuenta de estado de situación a la fecha y los aspectos necesarios de fortalecer
para el fomento del autocuidado en las organizaciones sociales de personas mayores por parte
de la red de salud.<br>
- Planificación de acompañamiento y supervisión técnica del Proceso de Capacitación de Líderes
Comunitarios en comunas y establecimientos de su Jurisdicción.<br>
- Información Diagnóstica sobre el trabajo intersectorial del Programa Más AM Autovalentes y
APS en las comunas y establecimientos de su jurisdicción a marzo 2020, dando cuenta de estado
de situación a la fecha y los aspectos necesarios de fortalecer para el envejecimiento activo y
positivo.<br>
- Planificación de acompañamiento y supervisión técnica del Proceso de Articulación
Intersectorial en las comunas y establecimientos de su Jurisdicción.';
$data10_1[1]['iverificacion'] =9;
$data10_1[1]['verificacion'] = ' Informe Técnico del I Corte entregado para evaluación a la División de Atención Primaria.';
$data10_1[1]['meta'] = '100%';
$data10_1[1]['label']['numerador'] = 'Número de acciones cumplidas para el fortalecimiento del programa Más Adultos Mayores
Autovalentes en el periodo';
$data10_1[1]['label']['denominador'] = 'Número de acciones solicitadas para el fortalecimiento del
programa Más Adultos Mayores Autovalentes en el periodo';

foreach ($meses as $mes) {
    $data10_1[1]['numeradores'][$mes] = 0;
    $data10_1[1]['denominadores'][$mes] = 0;
}

$data10_1[1]['numeradores'][1] = 11;
$data10_1[1]['numeradores'][2] = 12;
$data10_1[1]['numeradores'][3] = 13;
$data10_1[1]['numerador_acumulado'] = array_sum($data10_1[1]['numeradores']);

$data10_1[1]['denominadores'][1] = 11;
$data10_1[1]['denominadores'][2] = 12;
$data10_1[1]['denominadores'][3] = 13;
$data10_1[1]['denominador_acumulado'] = array_sum($data10_1[1]['denominadores']);

$data10_1[1]['cumplimiento'] = ($data10_1[1]['numerador_acumulado'] /
    $data10_1[1]['denominador_acumulado']) * 100;


$data10_1[1]['ponderacion'] = 100;

$data10_1[1]['calculo'] =
    '
Resultado Obtenido                  Porcentaje de Cumplimiento Asignado
x=100,0%.                                          100,0%
X<100,0%                                            0,0%
';
// calculo de cumplimiento
switch ($data10_1[1]['cumplimiento']) {
    case ($data10_1[1]['cumplimiento'] >= 100):
        $data10_1[1]['resultado'] = 100;
        break;
    default:
        $data10_1[1]['resultado'] = 0;
}
$data10_1[1]['cumplimientoponderado'] = (($data10_1[1]['resultado'] * $data10_1[1]['ponderacion']) / 100);


$data10_1['cumplimientoponderado']  = $data10_1[1]['cumplimientoponderado'];