<?php

$aMensajes = Array(
	Array(
		"ID"	=>	"265",
		"ID_UNIT"	=> 25,
		"UNIT"	=> 	"ECO. 25",
		"TIEMPO"=>  "2013-06-15 07:00:15",
		"STATUS"=>  "0",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "121231132adsas"		
	),
	Array(
		"ID"	=>	"265",
		"ID_UNIT"	=> 54,
		"UNIT"	=> 	"ECO. 58",
		"TIEMPO"=>  "2013-07-15 09:00:59",
		"STATUS"=>  "1",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit."		
	),
	Array(
		"ID"	=>	"653",
		"ID_UNIT"	=> 87,
		"UNIT"	=> 	"ECO. 60",
		"TIEMPO"=>  "2013-08-15 09:15:17",
		"STATUS"=>  "1",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "ESTE MENSAJE ES123123"
	),
	Array(
		"ID"	=>	"654",
		"ID_UNIT"	=> 1,
		"UNIT"	=> 	"ECO. 078",
		"TIEMPO"=>  "2013-10-15 10:15:05",
		"STATUS"=>  "1",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "Lorem ipsum dolor sit amet."
	),
	Array(
		"ID"	=>	"622",
		"ID_UNIT"	=> 11,
		"UNIT"	=> 	"ECO. 125",
		"TIEMPO"=>  "2013-09-15 10:15:05",
		"STATUS"=>  "0",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "Lorem ipsum dolor sit amet."
	),
	Array(
		"ID"	=>	"589",
		"ID_UNIT"	=> 80,
		"UNIT"	=> 	"ECO. 55",
		"TIEMPO"=>  "2013-10-16 10:15:05",
		"STATUS"=>  "1",/* Bandeja de Salida: 0-Pendiente de Enviar, 1=Enviado */
		"MESSAGE"=> "Lorem ipsum dolor sit amet."
	)			
);

echo json_encode( $result = array('aaData'=>$aMensajes ) );