<?php
/*
*/
    header('Content-Type: text/html; charset=UTF-8');
    $db = new sql($config_bd['host'],$config_bd['port'],$config_bd['bname'],$config_bd['user'],$config_bd['pass']);
	$userData = new usersAdministration(); //Nueva Instancia de Admin.
	
	if(!$userAdmin->u_logged())  //Valida Usuario Logeado
		echo '<script>window.location="index.php?m=login"</script>';
		

	
	$idc   = $userAdmin->user_info['ID_CLIENTE'];
    $cadena=' ';
	$cadena2=' ';
	$num=0;
	$sql = "SELECT ID_CIRCUITO,
	NOMBRE,
	ID_CLIENT,
	CREADO, 
	ID_ZONA FROM DSP_CIRCUITO WHERE ID_CLIENT=".$idc;						 	
		

	
			$query = $db->sqlQuery($sql);
			$count = $db->sqlEnumRows($query);
			if($count>0){
				while($row = $db->sqlFetchArray($query)){
					
					if($num==0){
					
					$dato= '<tr id="'.$row['ID_CIRCUITO'].'" class="odd" ><td  style="width: 130px;">
								<input type="hidden" id="'.$row['ID_ZONA'].'" />
								<table border="0"><tbody><tr><td><div onclick="" class="custom-icon-copy"></div></td>
								<td><div onclick="" class="custom-icon-edit-custom"></div></td>
								<td><div onclick="" class="custom-icon-delete-custom"></div></td></tr></tbody></table>
					
					</td>
					<td style="width: 446px;">'.$row['NOMBRE'].'</td>
					<td >'.$row['CREADO'].'</td>
					</tr>';
					$num=1;
					}else{
						$dato= '<tr id="'.$row['ID_CIRCUITO'].'" class="even" ><td style="width: 130px;">
								<input type="hidden" id="'.$row['ID_ZONA'].'" />
								<table border="0"><tbody><tr><td><div onclick="" class="custom-icon-copy"></div></td>
								<td><div onclick="" class="custom-icon-edit-custom"></div></td>
								<td><div onclick="" class="custom-icon-delete-custom"></div></td></tr></tbody></table>
					
					</td>
					<td style="width: 446px;">'.$row['NOMBRE'].'</td>
					<td >'.$row['CREADO'].'</td>
					</tr>';
					$num=0;
						
						}
					
					
					
					if($cadena==' '){
						
						$cadena=$dato;
						$cadena2=$row['ID_CIRCUITO'].','.$row['NOMBRE'];
						
						}else{
							
							$cadena=$cadena.$dato;
							$cadena2=$cadena2.'|'.$row['ID_CIRCUITO'].','.$row['NOMBRE'];
							
							}
					
					
					
				}
			
			}else{
			 $cadena=0;	
			}
	
	
	echo $cadena.'!'.$cadena2;
	
	
$db->sqlClose();


/*<div id="sizer2"  class="sizer" style="width:800px;" >
									<table  border="0" >
									<tr><td> Nombre: </td><td>&nbsp;</td><td ></td><td><a href="#" onclick="editar_todo(\''.$row['ID_CIRCUITO'].'\')" ><img title="Editar" src="public/images/Edit_icon.png" style="width:15px;"></a>&nbsp;<a href="#" onclick="elimina_edit(\''.$row['ID_CIRCUITO'].'\')" ><img title="Eliminar" src="public/images/elimina.png"></a></td></tr>
									<tr><td colspan="4"><font color="#2f4f4f" face="Arial Black" size="1"  >'.$row['NOMBRE'].'</font></td></tr>
									<tr><td colspan="4"><font color="#C0C0C0" face="Arial Black" size="1" >Creacion: '.$row['CREADO'].'</font></td></tr>
												</table></br></div>*/

?>


