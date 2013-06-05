<?php
	include "common.php";
	include "Database.php";
	$step=0;
    
    $conexion = mysqli_connect($Database['bd_server'],$Database['bd_user'],$Database['bd_pass'],$Database['bd_name']);
    $conexion_movi = mysqli_connect($Database_movi['bd_server'],$Database_movi['bd_user'],$Database_movi['bd_pass'],$Database_movi['bd_name']);
    
    if($conexion && $conexion_movi){	    
		$listEquipments = getListEquipments();
		$step=1;
		if(count($listEquipments)>0){
			$step=2;
			getPositions();
			setPositions();				
			$step=3;		
		}else{
			echo "No hay Equipos registrados";
		}
		echo "Termino-> Step : ".$step;
		
		mysqli_close($conexion);
		mysqli_close($conexion_movi);
    }else{
    	echo "no se pudo conectar a alguna de las bases";
    }