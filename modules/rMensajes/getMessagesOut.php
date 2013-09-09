<?php

$aMensajes = Array(
	Array(
		"ID"	=>	"1",
		"UNIT"	=> 	"ECO. 25",
		"TIEMPO"=>  "2013-08-15 07:00:15",
		"STATUS"=>  "0",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "121231132adsas"		
	),
	Array(
		"ID"	=>	"2",
		"UNIT"	=> 	"ECO. 58",
		"TIEMPO"=>  "2013-08-15 09:00:59",
		"STATUS"=>  "0",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit."		
	),
	Array(
		"ID"	=>	"3",
		"UNIT"	=> 	"ECO. 60",
		"TIEMPO"=>  "2013-08-15 09:15:17",
		"STATUS"=>  "1",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "ESTE MENSAJE ES123123"
	),
	Array(
		"ID"	=>	"4",
		"UNIT"	=> 	"ECO. 78",
		"TIEMPO"=>  "2013-08-15 10:15:05",
		"STATUS"=>  "1",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "Lorem ipsum dolor sit amet."
	)			
);

echo json_encode( $result = array('aaData'=>$aMensajes ) );