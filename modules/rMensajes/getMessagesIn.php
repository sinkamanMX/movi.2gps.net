<?php

$aMensajes = Array(
	Array(
		"ID"	=>	"1",
		"ID_UNIT"	=> 25,
		"UNIT"	=> 	"ECO. 25",		
		"TIEMPO"=>  "2013-08-15 07:00:15",
		"STATUS"=>  "0",/* Bandeja de Entrada: 0-Pendiente de Leer, 1=Leido */
		"MESSAGE"=> "121231132adsas"		
	),
	Array(
		"ID"	=>	"2",
		"ID_UNIT"	=> 10,
		"UNIT"	=> 	"ECO. 58",
		"TIEMPO"=>  "2013-08-15 09:00:59",
		"STATUS"=>  "0",/* Bandeja de Entrada: 0-Pendiente de Leer, 1=Leido */
		"MESSAGE"=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit."		
	),
	Array(
		"ID"	=>	"3",
		"ID_UNIT"	=> 1,
		"UNIT"	=> 	"ECO. 60",
		"TIEMPO"=>  "2013-08-15 09:15:17",
		"STATUS"=>  "1",/* Bandeja de Entrada: 0-Pendiente de Leer, 1=Leido */
		"MESSAGE"=> "ESTE MENSAJE ES123123"
	),
	Array(
		"ID"	=>	"4",
		"ID_UNIT"	=> 30,
		"UNIT"	=> 	"ECO. 78",
		"TIEMPO"=>  "2013-08-15 10:15:05",
		"STATUS"=>  "1",/* Bandeja de Entrada: 0-Pendiente de Leer, 1=Leido */
		"MESSAGE"=> "Lorem ipsum dolor sit amet."
	)			
);

echo json_encode( $result = array('aaData'=>$aMensajes ) );