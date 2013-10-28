/**/
var lat=0;
var lon=0;
var rdo=0;
var m='';
var save=0;
var idd = 0;
var ide = 0;
var idp = 0;
//var div='';
var u='';
var map;
//-------------------------
function change_idd(id){
	idp = id;
	//alert(d);
}
//-------------------------
function change_idp(id){
//alert(d);
	idp = id;
}
/*----------------------------------- -------------------------------------------- */
function change_ide(id){
	ide = id;
	//alert(ide);
}
/*----------------------------------- -------------------------------------------- */

function init(){
	r_filtro();
	r_filtro_xc('');
	r_filtro_xa('');
	r_filtro_xb('');
	r_filtro_y();
	r_filtro_z();

}
///---------------------------------------------------------------------------------------
function nuevoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	}catch(e){
		try{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(E){
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}




/*-----------------------------------    -------------------------------------------- */
function r_filtro(){
	var yy="";
	var filt = 0; 
	var text = $('#flt_x').val();
	$('#list_formas').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido&c=mTabla&txtfil="+text,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					$('#list_formas').html(ajax.responseText);
					tigra_tables('MyData', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_formas').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
/*-----------------------------------    -------------------------------------------- */
function r_filtro_y(){
	var text = $('#flt_x').val();
	$('#list_formas_y').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido&c=mTabla_y&txtfil="+text,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					$('#list_formas_y').html(ajax.responseText);
					tigra_tables('MyDatay', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_formas_y').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
/*-----------------------------------    -------------------------------------------- */
function r_filtro_z(){
	var text = $('#flt_x').val();
	$('#list_formas_z').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido&c=mTabla_z&txtfil="+text,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					$('#list_formas_z').html(ajax.responseText);
					tigra_tables('MyDataz', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_formas_z').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
/*-----------------------------------    -------------------------------------------- */
function r_filtro_xc(x){
	var text = $('#flt_xc').val();
	$('#list_formas_xc').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido&c=mTabla_xc&txtfil="+text+"&idd="+x,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					$('#list_formas_xc').html(ajax.responseText);
					tigra_tables('MyDataxc', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_formas_xc').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
/*-----------------------------------    -------------------------------------------- */
function r_filtro_xa(x){
	var text = $('#flt_xa').val();
	$('#list_formas_xa').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido&c=mTabla_xa&txtfil="+text+"&idd="+x,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					//$('#list_formas').html(ajax.responseText);
					//tigra_tables('MyData', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
					$('#list_formas_xa').html(ajax.responseText);
					tigra_tables('MyDataxa', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');

				}else{
					$('#list_formas_xa').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
/*-----------------------------------    -------------------------------------------- */
function r_filtro_xb(x){
	var text = $('#flt_xb').val();
	$('#list_formas_xb').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido&c=mTabla_xb&txtfil="+text+"&idd="+x,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					//$('#list_formas').html(ajax.responseText);
					//tigra_tables('MyData', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
					$('#list_formas_xb').html(ajax.responseText);
					tigra_tables('MyDataxb', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');

				}else{
					$('#list_formas_xb').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
/*-----------------------------------    -------------------------------------------- */
function ob_datac(x){
	//var text = $('#flt_x').val();
	//$('#list_formas_z').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
//barra_progress();
if(x!=0){
	var ajax = nuevoAjax();
		ajax.open("GET", "index.php?m=mContenido&c=mDatac&cto="+x,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					$('#list_points_c').html(ajax.responseText);
					tigra_tables('Mydatac', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_points_c').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	

}
}
/*----------------------------------- -------------------------------------------- */
function regs(){
	reg=$("[name='chk']").length;
	$('#reg').html("<b>"+reg+"</b>");
	}
/*  +++++++++++++++++++++++++++++++++++++++++++ DANIEL ++++++++++++++++++++++++++++++++++++  */



//...........//
function borrar(){
		$("#dialog-confirm").dialog({
			autoOpen:false,						
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Aceptar": function() {
				proceso_borrar(idp);
				},
				"Cancel": function() {
					$("#dialog-confirm").dialog( "close" );
				}
			}
		});
	/*var checkboxes = document.getElementsByName('chk');	
	var cont = 0;
	var cnt_ifs=0;
	var ids = new Array();
	for (var x=0; x < checkboxes.length; x++) {
 	if (checkboxes[x].checked) {
  	cont = cont + 1;
	ids.push(checkboxes[x].value);
	
 	}
	}*/
	if(idp!=0){
        $('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el punto?</p>');
$("#dialog-confirm").dialog("open");
		//
		}
	else{ 
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un punto de la lista</p>');
			$("#dialog-message" ).dialog('open');		
}
}
//...........//
function proceso_borrar(x){	
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mBorrar&punto="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  if(result>0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Punto eliminado correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$("#dialog-message" ).dialog('open');
			g=$('#idd').val();
			//alert($('#idd').val());
			mostrar_puntos(g);
			  
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser eliminado</p>');
			$("#dialog-confirm").dialog("close");
			$("#dialog-message" ).dialog('open');				  
			 }
   }
  }
 ajax.send(null);
 }
 //...............................................................................//
 function cancelar(){
		$("#dialog-confirm").dialog({
			autoOpen:false,						
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Aceptar": function() {
				proceso_cancelar(idp);
				},
				"Cancel": function() {
					$("#dialog-confirm").dialog( "close" );
				}
			}
		});
	if(idp!=0){
        $('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Esta seguro de cancelar el punto?</p>');
$("#dialog-confirm").dialog("open");
		//
		}
	else{ 
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un punto de la lista</p>');
			$("#dialog-message" ).dialog('open');		
}
}
//---------------------------------------------------------------------------------
function proceso_cancelar(x){	
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mCancelar&punto="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  if(result>0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Punto cancelado correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$("#dialog-message" ).dialog('open');
			g=$('#idd').val();
			//alert($('#idd').val());
			r_filtro_xb('');
			mostrar_puntos($('#idd').val());
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser cancelado</p>');
			$("#dialog-confirm").dialog("close");
			$("#dialog-message" ).dialog('open');				  
			 }
   }
  }
 ajax.send(null);
 }
 //---------------------------------------------------------------------------------
 function chk(){
	 //alert('chk');
	 var checkboxes = document.getElementsByName('chk');	
	 var cont=0;
	 for(var y=0; y<checkboxes.length; y++){
		 if(checkboxes[y].checked){
			 cont=cont+1;
			 }
		 }
		  
		 if(cont<checkboxes.length){
			
			 for (var x=0; x < checkboxes.length; x++) {
			 checkboxes[x].checked=true;
			 }		 		 	 
			 }
		if(cont==checkboxes.length){
			//alert(cont+"=="+checkboxes.length);
			 for (var z=0; z < checkboxes.length; z++) {
			 checkboxes[z].checked=false;
			 }		 		 	 
			 }
	 }
 //...............................................................................//
 function chk2(){
 var cnt=0;
 var checkboxes = document.getElementsByName('chk');		 
 var c=document.getElementById('chk_dad');
 for (var x=0; x < checkboxes.length; x++) {
 if(checkboxes[x].checked){
cnt=cnt+1;	 
 }
 }
 if(cnt<checkboxes.length){
 c.checked=false;
 } 
 else{
c.checked=true;	 
 }
 }
//........................................................................................// 
function nuevo(und){
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mNuevo&und="+und,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  $('#dialog').html('');
		  $('#dialog').dialog('open');
		  $('#dialog').html(ajax.responseText);		  
   }
  }
 ajax.send(null);
	}

//........................................................................................//
function validar_datos_d(){
var ifs=0;	

if($('#vj').val().length==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n</p>');
$("#dialog-message" ).dialog('open');		
return false;
	}

if($('#un').val()==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad</p>');
$("#dialog-message" ).dialog('open');		
return false;
	}

if($('#idv').val().length==0){	
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un identificador</p>');
$("#dialog-message" ).dialog('open');
return false;
	}	

if($('#start-date').val().length==0){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha inicial</p>');
$("#dialog-message" ).dialog('open');	
return false;
	}
	
if($('#end-date').val().length==0){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha final</p>');
$("#dialog-message" ).dialog('open');	
return false;
	}



if( $('#start-date').val()+" "+$('#horaInicio').val()+":"+$('#minutoInicio').val()+":00" >= $('#end-date').val()+" "+$('#horaFin').val()+":"+$('#minutoFin').val()+":00"){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un rango de fechas valido</p>');
$("#dialog-message" ).dialog('open');	
return false;
	}		

if($('#tol').val().length==0){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una tolerancia de arribo</p>');
$("#dialog-message" ).dialog('open');	
return false;
	}

	if(ifs==0){
	almacenar_nuevo();
		}
	}
//........................................................................................// 	
function barra_progress(){
		$( "#progressbar" ).progressbar({
			value:5
		});
		                var progressUpdater;

                setTimeout(function() {
                    $("#progressbar").progressbar('value', 10);
                    progressUpdater = setInterval(function() {
                        if ($("#progressbar").progressbar('value') == 100) {
                            clearInterval(progressUpdater);
                            //$("#dialog-message").dialog("close");
                            //$('#progressTrigger').focus();
                        }
                        $("#progressbar").progressbar('value', $("#progressbar").progressbar('value') + 5);
                        }, 250);
                }, 100);
		}	
//........................................................................................// 
function almacenar_nuevo(){	
var a=$('#vj').val();
var b=$('#un').val();
var c=$('#idv').val();
var d=$('#start-date').val()+" "+$('#horaInicio').val()+":"+$('#minutoInicio').val()+":00";
var e=$('#end-date').val()+" "+$('#horaFin').val()+":"+$('#minutoFin').val()+":00";
var f=$('#tol').val();
($('#stop').is(':checked'))? g=1: g=0;
($('#exc').is(':checked'))? h=1: h=0;
var result=0;

  $('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		
barra_progress();

 var ajax = nuevoAjax();
  ajax.open("GET", "index.php?m=mContenido&c=mGdrNvo&dsc="+a+"&idv="+c+"&dti="+d+"&dtf="+e+"&stp="+g+"&exc="+h+"&tol="+f+"&und="+b ,true);
  ajax.onreadystatechange=function() {

  	 if (ajax.readyState==4) {
		$("#dialog_pb" ).dialog('close');				
	      result =ajax.responseText;
		  //alert(result);
		   			if(result> 0){
				
				save=1;
				$("#dialog").dialog('close');
				//r_filtro_xc('');
				//r_filtro_xa('');
				//r_filtro_xb('');
				r_filtro_y();
				r_filtro_z();
				r_filtro();
				add_pts(result);
			}

						}
	
  }
  
 ajax.send(null);



	}
//.......................................................................................//	
function add_pts(id){

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mAddpts&idd="+id,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  $('#dialog_pts').html('');
		  $('#dialog_pts').dialog('open');
		  $('#dialog_pts').html(ajax.responseText);
		  	//alert(ajax.responseText);	  
   }
  }
 ajax.send(null);

//mostrar_puntos(id);

	}
//.......................................................................................//	
function edt_pts(){
//alert(ide);
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mEdtpts&idd="+idd+"&ide="+ide,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  $('#dialog_ptse').html('');
		  $('#dialog_ptse').dialog('open');
		  $('#dialog_ptse').html(ajax.responseText);
		  	//alert(ajax.responseText);	  
   }
  }
 ajax.send(null);
	}		
//.......................................................................................//	
function meditar(){

	if(ide != -1){ 	 
	var ajax = nuevoAjax();
	ajax.open("GET", "index.php?m="+m+"&c=mEditar&id="+ide,true);
	
	ajax.onreadystatechange=function() {
 	if (ajax.readyState==4) {
		//alert(ajax.responseText);
		 $('#dialog_edt').html(ajax.responseText); 
		 $('#dialog_edt').dialog('open');					
   }
  }
 ajax.send(null);
	}
	else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un modelo de la lista</p>');
			$("#dialog-message" ).dialog('open');	
		}
	}
////////////////////////////////////////////////////////////////////////////////////////////
function almacenar_edicion(){
//--------------------------------------------------------------------------------------------------//
if($("#vdo").is(':checked')) {vdo=1;}else{vdo=0;}
if($("#voz").is(':checked')) {voz=1;}else{voz=0;}
if($("#dhcp").is(':checked')) {dhcp=1;}else{dhcp=0;}
var a=$('#eqp').val();
var b=$('#idr').val();
var c=$('#idr2').val();
var d=$('#tpo').val();
var e=$('#ptx').val();
var e2=$('#prx').val();
var g=$('#tel').val();
var h=$('#imei').val();
var i=$('#udp').val();
var j=$('#prt').val();
var k=$('#ipe').val();
var l=$('#rpt').val();
var f=vdo;
var n=voz;
var o=dhcp;

$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
///////////////////////////////////////////////////////////////////////////////////////////////////
barra_progress();
////////////////////////////////////////////////////////////////////////////////////////////////////////////  

var ajax = nuevoAjax();
  ajax.open("GET", "index.php?m="+m+"&c=mGdrEdt&id="+ide+"&eqp="+a+"&idr="+b+"&idr2="+c+"&tpo="+d+"&ptx="+e+"&prx="+e2+"&tel="+g+"&imei="+h+"&udp="+i+"&prt="+j+"&ipe="+k+"&rpt="+l+"&vdo="+f+"&voz="+n+"&dhcp="+o ,true);
  ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
						$("#dialog_pb" ).dialog('close');	
	     var result =ajax.responseText;
				//alert(result);
			if(result > 0){
				save=1;
					//var x_cadena = ajax.responseText;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
			$("#dialog-message" ).dialog('open');				    

						  //  destino1.innerHTML = ajax.responseText;
						
						//$("#dialog_edt" ).dialog('close');	
						//
						//init();
						}else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n no pudo ser almacenada</p>');
			$("#dialog-message" ).dialog('open');								
						
						}
				}	
 
  }
  

 ajax.send(null);	
	
		
	}
//...........//

////////////////////////////////////////////////////////////////////////////////////////////////
function udp(x){
	//alert('entro');
	if(x==1){
		$('#prt').removeAttr('disabled');
		$('#ipe').removeAttr('disabled');
		}
	if(x==0){
		$('#prt').val("");
		$('#ipe').val("");
		$('#prt').attr("disabled","disabled");
		$('#ipe').attr("disabled","disabled");
		}
	}
//////////////////////////////////////////////////////////////////////////////////////////////
function query2(x){
//alert(x);		
if(x>0){
$('#y').html('<select class="caja"><option value="0" >Cargando...</option></select>');
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m="+m+"&c=mQuery2&id="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   //alert(ajax.responseText);
	      var result =ajax.responseText;
			    if(result!= 0){
				$('#y').html(ajax.responseText);										
						}else{						
				$('#y').html('<select class="caja"><option value="0" >No existen datos asociados</option></select>');			
						}
				
	 }	
 
 }
 ajax.send(null);
}else{
$('#y').html('<select class="caja"><option value="0" >Seleccione un submen&uacute;</option></select>');	
}	 
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function a(){
	if($("#dialog" ).dialog('isOpen')){
	$("#dialog").dialog('close');
	}
	if($("#dialog_edt" ).dialog('isOpen')){
	$("#dialog_edt").dialog('close');
	}	
	
	$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  	$("#dialog_pb" ).dialog('open');
	barra_progress();	
	}
	


/*function m1(){
$("#dialog_pb" ).dialog('close');			
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci\u00f3n se ha Guardado  correctamente</p>'); 
$("#dialog-message" ).dialog('open');
r_filtro();
}	*/
function m2(){
$("#dialog_pb" ).dialog('close');		
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0; width:25px; "></span>La informaci\u00f3n no ha podido ser guardada  correctamente.</p>');
$("#dialog-message" ).dialog('open');	 
}	
function m3(){	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0; width:25px; "></span>Tipo de archivo no valido</p>');
$("#dialog-message" ).dialog('open');
nuevo();
}	
function ch_rmt(){
	//alert($('#rmt').val());
 if($("#ch_img").is(':checked')) {
 $('#rmt').removeAttr('disabled');
 }else{
 $('#rmt').val(""); 
 $('#rmt').attr("disabled","disabled");
 }
	}
	
function nvo_pto(){
	$('#puntos').css("display","");
	
	}
	
function cls_pto(){
	$('#puntos').css("display","none");	
	}	
	
//-----------------------------------------------------------------------------------
function validar_datos_p(){
var ifs=0;	
a=$('#delivery-date').val()+" "+$('#hi').val()+":"+$('#mi').val()+":00";
b=$('#dti').val()+" "+$('#hri').val()+":"+$('#mni').val()+":00";
c= $('#dtf').val()+" "+$('#hrf').val()+":"+$('#mnf').val()+":00";
var t= new Date();
m=(t.getMonth()<9)?"0"+t.getMonth()+1:t.getMonth()+1;
x=(t.getDate()<=9)?"0"+t.getDate():t.getDate();
h=(t.getHours()<=9)?"0"+t.getHours():t.getHours();
i=(t.getMinutes()<=9)?"0"+t.getMinutes():t.getMinutes();
e= t.getFullYear()+"-"+m+"-"+x+" "+h+":"+i+":00";
//alert($('#op').val())
if($('#op').val()==1){
if($('#cte').val()==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
$("#dialog-message" ).dialog('open');		
return false;
	}

if($('#delivery-date').val().length==0){	
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega</p>');
$("#dialog-message" ).dialog('open');
return false;
	}	

if(a < b | a > c | a<e){
//alert("no entra")	;
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha correcta</p>');
$("#dialog-message" ).dialog('open');	
return false;
	}
}
else{	
	var cn=$('#cnt').val;
	for(x=0; x<$('#cnt').val(); x++){
		d=$('#dt'+x).val()+" "+$('#hr'+x).val()+":"+$('#mn'+x).val()+":00";
		//alert($("#dt"+x).attr('id'));
		if($('#dt'+x).val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega en el registro </p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
			
		if(d < b | d > c | d < e){
			//alert(d+"menor"+b+" "+d+"mayor"+c+" "+d+"menor"+e)
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega dentro del rango</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
		}
	}


	if(ifs==0){
	agregar_punto();
		}
	}	
//........................................................................................// 
function agregar_punto(){
datap="";	
for(x=0; x<$('#cnt').val(); x++){
	//datap= (datap=="")?$('#pto'+x).val()+"¬"+$('#dt'+x).val()+"¬"+$('#obs'+x).val():data+"~"+$('#pto'+x).val()+"¬"+$('#dt'+x).val()+"¬"+$('#obs'+x).val();
	if(datap==""){
		datap=$('#pto'+x).val()+"¬"+$('#dt'+x).val()+" "+$('#hr'+x).val()+":"+$('#mn'+x).val()+":00"+"¬"+$('#obs'+x).val()+"¬"+$('#itm'+x).val();
		}
	else{
		datap=datap+"~"+$('#pto'+x).val()+"¬"+$('#dt'+x).val()+" "+$('#hr'+x).val()+":"+$('#mn'+x).val()+":00"+"¬"+$('#obs'+x).val()+"¬"+$('#itm'+x).val();
		}	
		//alert($('#itm'+x).val())
	}	

				var a="";
				var b="";
				var c="";
				var d="";
				var e="";
				var f="";
				var g="";
				var h="";		
 cte=$('#cte').val();
 ct=cte.split("¬")
 var a=ct[0];
 var b=$('#idp').val();
 var c=$('#delivery-date').val()+" "+$('#hi').val()+":"+$('#mi').val()+":00";
 var d=$('#obs').val();
 var e=$('#cst').val();
 var f=$('#pld').val();
 var g=$('#idd').val();

//alert(datap)
 //h=$('#und').val();


  $('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		
barra_progress();

 var ajax = nuevoAjax();
  //ajax.open("GET", "index.php?m=mContenido&c=mGdrPto&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&pld="+f+"&idd="+g+"&und="+h,true);
  ajax.open("GET", "index.php?m=mContenido&c=mGdrPto&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&pld="+f+"&idd="+g+"&datap="+datap,true);
  ajax.onreadystatechange=function() {

  	 if (ajax.readyState==4) {
		$("#dialog_pb" ).dialog('close');				
	      result =ajax.responseText;
		  //alert(result)
		   	if(result==1){
				
				save=1;
				//$("#dialog").dialog('close');
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto  se ha almacenado correctamente.</p>');
				$("#dialog-message" ).dialog('open');
				
				r_filtro_y();
				r_filtro_z();
				$("#list_points_c").html("");
				mostrar_puntos($('#idd').val());
				
				$("#cte option:eq(0)").attr("selected", "selected");
				//$("#und option:eq(0)").attr("selected", "selected");
				$("#hi  option:eq(0)").attr("selected", "selected");
				$("#mi  option:eq(0)").attr("selected", "selected");
				$("#cst option:eq(0)").attr("selected", "selected");
				$('#idp').val("");
				$('#delivery-date').val("");
				$('#obs').val("");
				//$('#cst').val();
				$('#pld').val("");			
				//$('#idd').val();
				//$('#un').val();
				r_filtro_xc('');
				
			}
			else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser almacenada</p>');
				$("#dialog-message" ).dialog('open');	
				}

						}
	
  }
  
 ajax.send(null);



	}	
//----------------------------------------------

function mostrar_puntos(id){
//alert(id);

$('#list_points').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mQuery&idd="+id+"&ide="+ide,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   
	      var result =ajax.responseText;
		  //alert(result);
			    //if(result!= 0){	
				
					//	}
				if(result == 0){						
				$('#list_points').html('No existen puntos asociados');			
						}
				else{
					$('#list_points').html(result);
					tigra_tables('MyDatap', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
					}
				
	 }	
 
 }

	
 ajax.send(null);
}
//----------------------------------------------

function mostrar_notas(x){
//alert(id);

//$('#list_points').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
//barra_progress();

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mDnotas&ide="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   
	      var result =ajax.responseText;
		 // alert(result);
			    //if(result!= 0){	
				
					//	}
				if(result == 0){						
				$('#dialog_mnote').html('No existen puntos asociados');			
						}
				else{
					$('#dialog_mnote').html(result);
					tigra_tables('MyDatan', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
					$("#dialog_mnote" ).dialog('open');	
					}
				
	 }	
 
 }

	
 ajax.send(null);
}

//----------------------------------------------------
function validar_ed(){
	var st=($("#st").is(':checked'))?1:0;
	var ex=($("#ex").is(':checked'))?1:0;
	var data2= $("#dsp").val()+'¬'+$("#idv").val()+'¬'+$("#und").val()+'¬'+$("#dti").val()+'¬'+$("#dtf").val()+'¬'+$("#tl").val()+'¬'+$("#hri").val()+'¬'+$("#mni").val()+'¬'+$("#hrf").val()+'¬'+$("#mnf").val()+'¬'+st+'¬'+ex;	
	var u=$("#data").val().split("¬");
	
		$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		///////////////////////////////////////////////////////////////////////////////////////////
		barra_progress();
		////////////////////////////////////////////////////////////////////////////////////////////////////////////  	
		
	if($("#data").val() != data2){
		var ifs=0;	
		
		if($('#vj').val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
		
		if($('#un').val()==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
		
		if($('#idv').val().length==0){	
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un identificador</p>');
		$("#dialog-message" ).dialog('open');
		return false;
			}	
		
		if($('#start-date').val().length==0){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha inicial</p>');
		$("#dialog-message" ).dialog('open');	
		return false;
			}
			
		if($('#end-date').val().length==0){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha final</p>');
		$("#dialog-message" ).dialog('open');	
		return false;
			}
			
		if($('#start-date').val()>$('#end-date').val()){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un rango de fechas valido</p>');
		$("#dialog-message" ).dialog('open');	
		return false;
			}		
		
		if($('#tol').val().length==0){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una tolerancia de arribo</p>');
		$("#dialog-message" ).dialog('open');	
		return false;
			}
		
			if(ifs==0){
			gdr_ed();
				}		
		}
	else{
		$("#dialog_pb" ).dialog('close');
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
		$("#dialog-message" ).dialog('open');
		$("#dialog_pts" ).dialog('close');
		r_filtro_xc('');
		}	
	}
//---------------------------
function gdr_ed(){
		var st=($("#st").is(':checked'))?1:0;
		var ex=($("#ex").is(':checked'))?1:0;
		var h=($("#und").val() != u[2])?1:0;
		//alert("Si hay cambios");
		var a=$('#dsp').val();
		var b=$('#idv').val();
		var c=$('#und').val();
		var d=$('#dti').val()+" "+$('#hri').val()+":"+$('#mni').val()+":00";
		var e=$('#dtf').val()+" "+$('#hrf').val()+":"+$('#mnf').val()+":00";
		var f=$('#tl' ).val();
		var g=$('#idd').val();
		 //alert(h)


		var ajax = nuevoAjax();
  		ajax.open("GET", "index.php?m=mContenido&c=mGdrEdt&dsp="+a+"&idv="+b+"&und="+c+"&dti="+d+"&dtf="+e+"&tl="+f+"&st="+st+"&ex="+ex+"&cu="+h+"&idd="+g ,true);
  		ajax.onreadystatechange=function() {
  	 	if (ajax.readyState==4) {
			$("#dialog_pb" ).dialog('close');	
	     	var result =ajax.responseText;
				//alert(result);
			if(result > 0){
				save=1;
				//var x_cadena = ajax.responseText;
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
				$("#dialog-message" ).dialog('open');
				$("#dialog_pts" ).dialog('close');
				r_filtro_xc('');			    
						}else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n no pudo ser almacenada</p>');
				$("#dialog-message" ).dialog('open');								
						
						}
				}	
 
  }
  

 ajax.send(null);
		 	
	}
	
	//----------------------------------------------------
function validar_edp(){
	//var st=($("#st").is(':checked'))?1:0;
	//var ex=($("#ex").is(':checked'))?1:0;
	var data2= $("#cte_pto").val()+'¬'+$("#idp_pto").val()+'¬'+$("#delivery_date").val()+'¬'+$("#hi_pto").val()+'¬'+$("#mi_pto").val()+'¬'+$("#obs_pto").val()+'¬'+$("#cst_pto").val()+'¬'+$("#pld").val();	
	//var u=$("#data").val().split("¬");
	
		$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		///////////////////////////////////////////////////////////////////////////////////////////
		barra_progress();
		////////////////////////////////////////////////////////////////////////////////////////////////////////////  	
		
	if($("#data_edp").val() != data2){
		var ifs=0;	
		
		if($('#cte_pto').val()==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
		
		if($('#idp_pto').val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un identificador del punto</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
		
		if($('#delivery_date').val().length==0){	
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega</p>');
		$("#dialog-message" ).dialog('open');
		return false;
			}	
		
			if(ifs==0){
			gdr_edp();
				}		
		}
	else{
		$("#dialog_pb" ).dialog('close');
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
		$("#dialog-message" ).dialog('open');
		$("#dialog_pts" ).dialog('close');
		r_filtro_xc('');
		}	
	}
//---------------------------
function gdr_edp(){
		//var st=($("#st").is(':checked'))?1:0;
		//var ex=($("#ex").is(':checked'))?1:0;
		//var h=($("#und").val() != u[2])?1:0;
		//alert("Si hay cambios");
		var a=$('#cte_pto').val();
		var b=$('#idp_pto').val();
		var c=$('#delivery_date').val()+" "+$('#hi_pto').val()+":"+$('#mi_pto').val()+":00";
		var d=$('#obs_pto').val();
		var e=$('#cst_pto' ).val();
		var f=$('#pld').val();
		 //alert(h)


		var ajax = nuevoAjax();
  		ajax.open("GET", "index.php?m=mContenido&c=mGdrEdtp&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&pld="+f+"&ide="+ide,true);
  		ajax.onreadystatechange=function() {
  	 	if (ajax.readyState==4) {
			$("#dialog_pb" ).dialog('close');	
	     	var result =ajax.responseText;
				//alert(result);
			if(result > 0){
				save=1;
				//var x_cadena = ajax.responseText;
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
				$("#dialog-message" ).dialog('open');
				$("#dialog_ptse" ).dialog('close');
				r_filtro_xc('');			    
						}else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n no pudo ser almacenada</p>');
				$("#dialog-message" ).dialog('open');								
						
						}
				}	
 
  }
  

 ajax.send(null);
		 	
	}	
//------------------------------------------------------------------------------
var info_a = new Array();
var lats = new Array();
var lons = new Array();
var points = new Array();
var map;	
function mostrar_mapa(op){
		lats.length=0;
	lons.length=0;
	points.length=0;
yp=$("#idd").val(); 
	var colortrue= "#F32424";
	
	 var path = "index.php?m=mContenido&c=mFollowEdts&ide="+yp;
	//map.clearOverlays();
	
	
$.getJSON(path,function(data) {
		var points = [];
		$.each(data.items, function(i,item){
			var point = new GLatLng(item.unitLatitude, item.unitLong);		
			points.push(point);		    		
			if(item.show==1){
				var message = "<tr><td>" + item.dunit +"</td>"+
						  "<td>" + item.evt   +"</td>"+
						  "<td>" + item.fecha +"</td>"+
						  "<td>" + item.dir   +"</td></tr>";		  
				jAlert(message, 'Alertas', function() {
					$.alerts.dialogClass = null; // reset to default
				});
			}
			map.addOverlay(createUnits(point, i,item.unit,item.unitLatitude,item.unitLong,item.icono,item.angle,item.fecha));
	    	});
			var polyline = new GPolyline(points, colortrue, 5);
		map.addOverlay(polyline);  
		map.panTo(points[0]);
	
  	});
	 
	
	
	
	if (GBrowserIsCompatible() && lat!=0 && lon!=0) {
		
        var map = (op==1)? new GMap2(document.getElementById("mapa")):new GMap2(document.getElementById("mapa2"));
        map.setCenter(new GLatLng(lat,lon), 13);
        map.setUIToDefault();
		
		// Create our "tiny" marker icon
		var blueIcon = new GIcon(G_DEFAULT_ICON);
		blueIcon.image = "public/images/Sucursal.png";
		// Set up our GMarkerOptions object
		markerOptions = { icon:blueIcon };			
		// Add marker to the map
		var point = new GLatLng(lat,lon);
 		map.addOverlay(new GMarker(point, markerOptions));
	}
	}
	
function createUnits(point,index,uni,lat,lon,icono,angle,info) {
	var baseIcon = new GIcon(G_DEFAULT_ICON);
        baseIcon.shadow = "";
        baseIcon.iconSize = new GSize(20, 22);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);
	
	if(pintaold==4){
		
		
	nuevo=icono.split('.');
	nuevo[0]+="_"+angle;
	icon_new=nuevo[0]+"."+nuevo[1];

	}else{
	
	icon_new="carold_"+angle+".png";
		}

	
	
	var icon = "public/images/iconos_autos/"+icon_new;

  

			
  var costumIcon = new GIcon(baseIcon);
        costumIcon.image = icon; 
    markerOptions = { icon:costumIcon };
		
	var marker = new GMarker(point, markerOptions);		
       	GEvent.addListener(marker, "click", function() {	
		map.setCenter(point,17);
		//getUnitsInfo(uni, 0 , lat , lon);
	    //marker.openInfoWindowHtml("Marker <b>ejemplo</b>");
	  });
	return marker;
			
			pintaold++;
			}
function mostrar(){
	//alert($('#usersTableTitle').css("display"))
//$('#ptsTableTitle').css("display","");
$('#op').val(1);
	}	
function ocultar(){
//$('#ptsTableTitle').css("display","none");
$('#op').val(2);
	}
function mostrar2(){
	//alert($('#usersTableTitle').css("display"))
$('#ptsTableTitle').css("display","");
	}	
function ocultar2(){
$('#ptsTableTitle').css("display","none");
	}	
function closeb(b){
	$('#'+b+'').css("display","none");
	//$('#'+b+'').css("visibility","hidden");		 
	}	
//-------------------------------------------------------------------------------	
function openb(b){
	$(this).keydown(function(tecla){
    if (tecla.keyCode == 113) {
        alert('Tecla F2 presionada '+b);
		//$('.box_sh').css("display","");
    }
});
	}	
	
function change_dt_cte(data){
	//alert(data)
	if(data!=0){
	 var d=data.split("¬");
	 lat=d[1];
	 lon=d[2];
	 rdo=d[3];
	}
	 //alert(lat+","+lon+","+rdo);
	}
function dsp_clr(){
	//alert('ok')
	//document.getElementById('clr').style.display='block';
	$('#clr').css("display","");
	}	
	
function add_note(){
	//alert('ok')
	document.getElementById('puntos').style.zIndex=-1;
	document.getElementById('panelPEx').style.zIndex=-1;
	document.getElementById('addnote').style.display='block';
	//$('#clr').css("display","");
	}	
	
//--	-----------------------------------------------------
function valida_punto(it){
	//alert(it);
if(it!=''){	
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mQuery2&it="+it,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   
	      var result =ajax.responseText;
		  //alert(result);
			    //if(result!= 0){	
				
					//	}
				if(result > 0){						
		$('#idp').val('');
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto ya existe.</p>');
		$("#dialog-message" ).dialog('open');	
				//alert("ya existe");
						}
	 }	
 
 }

	
 ajax.send(null);	
	}
	}
//........................................................................................// 
function gdr_note(){

		var ifs=0;	
		
		if($('#tnote').val()==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tipo de nota</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}
		if($('#note').val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el contenido de la nota</p>');
		$("#dialog-message" ).dialog('open');		
		return false;
			}			
if(ifs==0){
var a=$('#tnote').val();
var b=$('#note').val();
var c=$('#ide_edt_pts').val();
var d=$('#idd').val();
var e=$('#op_note').val();

//alert(e);


  $('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		
barra_progress();

 var ajax = nuevoAjax();
  ajax.open("GET", "index.php?m=mContenido&c=mGdrNot&tnote="+a+"&note="+b+"&ide="+c+"&op="+e+"&idd="+d,true);
  ajax.onreadystatechange=function() {

  	 if (ajax.readyState==4) {
		$("#dialog_pb" ).dialog('close');				
	      result =ajax.responseText;
		  //alert(result);
		  if(result>0){
			  closeb('addnote'); 
			  document.getElementById('puntos').style.zIndex=0;
			  document.getElementById('panelPE').style.zIndex=0;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Nota almacenada correctamente</p>');
			$("#dialog-message" ).dialog('open');
			$("#dialog-note" ).dialog('close');
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La nota no pudo ser almacenada</p>');
			$("#dialog-message" ).dialog('open');				  
			 }		 

						}
	
  }
  
 ajax.send(null);
}


	}	
//-------------------------
function crear_punto(){
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mAdd_GeoPuntos",true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  $('#dialog-crear').html('');
		  $('#dialog-crear').dialog('open');
		  $('#dialog-crear').html(ajax.responseText);
		  //$('#dialog-crear').html('X');		  
   }
  }
 ajax.send(null);
	}
//----------------------------------------------------------------	
function validarIE(e) { // 1
	var key=window.event.keyCode;
	if (key < 48 || key > 57){
	window.event.keyCode=0;
	}
} 	
//----------------------------------------------------------------
/*function busca_por_cp(){
	var cp	 = document.getElementById("txt_cp_i").value;
	var path = "index.php?m=mContenido&c=mFindDirection&cp="+cp;
	var json = new Request.JSON({url: path, onComplete: onLoad});
	json.get();
	function onLoad(obj){
		var results = obj.items;
		if(results.length != 0){
			for (i=0; i<results.length; i++) {
				var tmp = results[i]; 
				var edo = tmp.edo;
				var mun = tmp.mun;					
				var col = tmp.col;					
				document.getElementById("cbo_edo_i").options[0].text = edo;
				document.getElementById("cbo_edo_i").selectedIndex = 0;	
				document.getElementById("cbo_mun_i").options[0].text = mun;
				document.getElementById("cbo_mun_i").selectedIndex = 0;
				document.getElementById("cbo_mun_i").disabled = true;
				document.getElementById("cbo_col_i").options[0].text = col;
				document.getElementById("cbo_col_i").selectedIndex = 0;								
				document.getElementById("cbo_col_i").disabled = true;					
		}
		}else{
			alert("No se ha encontrado coincidencias con el codigo postal que ingreso.");
		}
	}	  
}*/

//----------------------------------------------------------------
function busca_por_cp(){
	var cp	 = document.getElementById("txt_cp_i").value;
	var ifs=0;	
		
	if($('#txt_cp_i').val().length==0){
	ifs=ifs+1;
	$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un c\u00f3digo postal</p>');
	$("#dialog-message" ).dialog('open');		
	return false;
		}
	if(ifs==0)	{
	var ajax = nuevoAjax();
 	ajax.open("GET", "index.php?m=mContenido&c=mFindDirection&cp="+cp,true);
	ajax.onreadystatechange=function() {
		 if (ajax.readyState==4) {
			 result=ajax.responseText;
			      d=result.split("+");

				  $(" select option").each(function () {
                	if($(this).text() == d[0] ){
						$(this).attr("selected",true);
						}
              		});
					
				
			 //alert(result);
				//document.getElementById("cbo_edo_i").options[0].text = d[0];
				//document.getElementById("cbo_edo_i").selectedIndex = 0;	
				document.getElementById("cbo_mun_i").options[0].text = d[1];
				document.getElementById("cbo_mun_i").selectedIndex = 0;
				document.getElementById("cbo_mun_i").disabled = true;
				document.getElementById("cbo_col_i").options[0].text = d[2];
				document.getElementById("cbo_col_i").selectedIndex = 0;								
				document.getElementById("cbo_col_i").disabled = true;			 
			  //$('#dialog-crear').html('');
			  //$('#dialog-crear').dialog('open');
			  //$('#dialog-crear').html(ajax.responseText);
			  //$('#dialog-crear').html('X');		  
	   }
	  }
	ajax.send(null);
	}
	}
//-------------------------------------------------------------------------------------------
function leemapaAdd(){	
	if (GBrowserIsCompatible()) {			
   	   	divmapaAdd = new GMap2(document.getElementById("divmapaAdd"));
       	divmapaAdd.setCenter(new GLatLng(19.508090,-99.234310), 3);
	    var customUI = divmapaAdd.getDefaultUI();
   	    customUI.maptypes.hybrid = true;
    	divmapaAdd.setUI(customUI);	
		
		geocoder = new GClientGeocoder();  //Recibe la Direccion
		
		myEventListener = GEvent.bind(divmapaAdd, "click", this, function(overlay, latlng) {
		divmapaAdd.clearOverlays(); 
			if (latlng){
				g_Seleccion = 3;
				//alert(" El metodo seleccionado es: "+g_Seleccion);
				latitud  = latlng.lat();
				longitud = latlng.lng();
				autolatitud	= document.getElementById("divtxtlat");
				autolatitud.innerHTML = '<html><input type="text" id="txtlatsearch" style="font-family:Verdana, Geneva, sans-serif; font-size:10px;" value="'+latitud+'"></html>'
				autolongitud	= document.getElementById("divtxtlon");
				autolongitud.innerHTML = '<html><input type="text" id="txtlonsearch" style="font-family:Verdana, Geneva, sans-serif; font-size:10px;" value="'+longitud+'"></html>'
				//calcula_dir(latitud,longitud)
 	            var point = new GLatLng(latitud,longitud);				
				divmapaAdd.addOverlay(new GMarker(point));
				//myPano.setLocationAndPOV(point);
				//alert(latitud +" "+longitud);
			}});
    }
}
//-----------------------------------------------------------------------------------------------------
function showAddress(seleccion) {
	g_Seleccion = seleccion;
	//alert(" El metodo seleccionado es: "+g_Seleccion);
	
	leemapaAdd();
	divmapaAdd.clearOverlays(); 
	var cp		= document.getElementById("txt_cp_i").value;
	var calle		= document.getElementById("address").value;
	if(calle.length > 0){
	var idcol	    = document.getElementById("cbo_col_i").selectedIndex;
	var colonia   = document.getElementById("cbo_col_i").options[idcol].text;
	
	var idmun		= document.getElementById("cbo_mun_i").selectedIndex;
	var municipio = document.getElementById("cbo_mun_i").options[idmun].text;
	
	var ideo  	= document.getElementById("cbo_edo_i").selectedIndex;
	var estado	= document.getElementById("cbo_edo_i").options[ideo].text;
	
	var pais		= 'Mexico';
	var address 	= estado+","+municipio+","+colonia+","+calle;	
	
	 if (geocoder) {
		geocoder.getLatLng(
		address,
		function(latlng) {
		  if (!latlng) {
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se ha encontrado nada similar a: '+address+'</p>');
				$("#dialog-message" ).dialog('open');  
			//alert("No se ha encontrado nada similar a: "+address);
		  } else {
			  latitud  = latlng.lat();
			  longitud = latlng.lng();
				autolatitud	= document.getElementById("divtxtlat");
				autolatitud.innerHTML = '<html><input type="text" id="txtlatsearch" style="font-family:Verdana, Geneva, sans-serif; font-size:10px;" value="'+latitud+'"></html>'
				autolongitud	= document.getElementById("divtxtlon");
				autolongitud.innerHTML = '<html><input type="text" id="txtlonsearch" style="font-family:Verdana, Geneva, sans-serif; font-size:10px;" value="'+longitud+'"></html>'
	
				divmapaAdd.setCenter(point, 16);
				var point = new GLatLng(latitud,longitud);				
				var marker = new GMarker(point);
				divmapaAdd.addOverlay(marker);
				marker.openInfoWindowHtml(address);
				//myPano.setLocationAndPOV(point);	            
		  }
		}
	  );
	}
	}else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de ingresar el nombre de la calle</p>');
				$("#dialog-message" ).dialog('open'); 		
	  //alert("Debe de ingresar el nombre de la calle.");
	}
}
//------------------------------------------------------------
function centra_punto(){
	leemapaAdd();
	var lon = document.getElementById("txtlonsearch").value;
	var lat = document.getElementById("txtlatsearch").value;
	if(lon != "" && lat  != ""){
		latitud  = lat;
		longitud = lon;
		divmapaAdd.clearOverlays(); 
		var point = new GLatLng(lat,lon);
		divmapaAdd.setCenter(point, 16);
		divmapaAdd.addOverlay(new GMarker(point));
		//myPano.setLocationAndPOV(point);
		calcula_dir(lat,lon)
	}else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debes de ingresar latitud y longitud</p>');
				$("#dialog-message" ).dialog('open'); 		
		//alert("Debes de ingresar latitud y longitud");
	}				
}
//-----------------------------------------------------------
function calcula_dir(lat,lon){

	var destino = document.getElementById('divdireccionAdd');
	ajax = nuevoAjax();
	ajax.open("GET", "index.php?m=mContenido&c=mAdd_GeoPuntosDireccion&lat="+lat+"&lon="+lon,true);
	ajax.onreadystatechange=function() {
		if(ajax.readyState==1){
			destino.innerHTML = 'Calculando direcccion...<img src=\"modules/gpuntos/template/images/load3.gif\">';
		}else if (ajax.readyState==4) {
			destino.innerHTML = ajax.responseText;
		}
	}		
	ajax.send(null);
}
//-----------------------------------------------------------
function AgregaGeoPunto_Acepta(){

if(longitud != 0 ){			
	if(latitud  != 0){
	
	var nom	= document.getElementById("txtname").value;
	var type	= document.getElementById("txttype").value;
	var nip	= document.getElementById("txtnip").value;
	//var rutex	= cadenita;
	var radio	= document.getElementById("txtradio").value;
	
	//alert("La informacion es: "+nom+" "+type+" "+nip+" "+rute+" "+radio);
	
	var calle	= document.getElementById("address").value;
	//var state	= document.getElementById("cbo_edo_i").value;
	var e      = document.getElementById("cbo_edo_i");		
	var nume    = e.selectedIndex;
	var state    = e.options[nume].text;
	//var mun	= document.getElementById("cbo_mun_i").value;
	var m      = document.getElementById("cbo_mun_i");		
	var numm    = m.selectedIndex;
	var mun    = m.options[numm].text;
	//var col	= document.getElementById("cbo_col_i").value;
	var c      = document.getElementById("cbo_col_i");		
	var numc    = c.selectedIndex;
	var col    = c.options[numc].text;
	var cp	= document.getElementById("txt_cp_i").value;
	
	//alert("La dirección es: "+calle+" "+state+" "+mun+" "+col+" "+cp);
	
	var lat	= document.getElementById("txtlatsearch").value;
	var lon	= document.getElementById("txtlonsearch").value;
	
	if(nom != ""){
		if(type != ""){
			if(nip != ""){
				
					if(radio != ""){
						if(calle != ""){
							if(state != ""){
								if(mun != ""){
									if(col != ""){
										if(cp != ""){
											if(lat != ""){
												if(lon != ""){
													
												//alert("TODO EXCELENTE HASTA ESTE PUNTO");	
												var url = 'index.php?m=mContenido&c=mAdd_GeoPuntosExe'+
												'&nombre='+nom+
												'&tipo='+type+
												'&nip='+nip+
												'&radio='+radio+
												
												'&calle='+calle+
												'&estado='+state+
												'&municipio='+mun+
												'&colonia='+col+
												'&cp='+cp+
												
												'&lat='+lat+
												'&lon='+lon;
												
												document.body.style.cursor = 'wait';
												var ajax = nuevoAjax();
												ajax.open("GET", url,true);
												ajax.onreadystatechange=function(){
													if (ajax.readyState==4){
														var result = ajax.responseText;
														if(result != 0){
															//alert("GeoPunto Agregado Correctamente.");
															query3();
															$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>GeoPunto Agregado Correctamente.</p>');
													$("#dialog-message" ).dialog('open'); 	
															//AgregaGeoPunto_Limpieza();
															$('#dialog-crear').dialog('close');
															
														}else{
															//alert("No se ha podido Agregar el GeoPunto \n Intentelo nuevamente mas Tarde.");
															$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se ha podido Agregar el GeoPunto \n Intentelo nuevamente mas Tarde</p>');
													$("#dialog-message" ).dialog('open');
															//AgregaGeoPunto_Limpieza();
															$('#dialog-crear').dialog('close');
														}
														document.body.style.cursor = 'default';
													}			
												}		
													
												}else{
													$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Longitud, porfavor verifique que el campo no este vacio.</p>');
													$("#dialog-message" ).dialog('open'); 	
												//alert("Sin Longitud, porfavor verifique que el campo no este vacio.");
												}
											}else{
											//alert("Sin Latitud, porfavor verifique que el campo no este vacio.");
											$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Latitud, porfavor verifique que el campo no este vacio.</p>');
											$("#dialog-message" ).dialog('open'); 	
											}
										}else{
										//alert("Sin Codigo Postal, seleccione una colonia para obtenerlo.");
										$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin C\u00f3digo Postal, seleccione una colonia para obtenerlo.</p>');
										$("#dialog-message" ).dialog('open'); 
										}
									}else{
									//alert("Sin Colonia, porfavor verifique que el campo no este vacio.");
									$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Colonia, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open'); 
									}
								}else{
								//alert("Sin Municipio, porfavor verifique que el campo no este vacio.");
								$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Municipio, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open'); 
								}
							}else{
							//alert("Sin Estado, porfavor verifique que el campo no este vacio.");
							$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Estado, porfavor verifique que el campo no este vacio</p>');
										$("#dialog-message" ).dialog('open'); 
							}
						}else{
						//alert("Sin Calle, porfavor verifique que el campo no este vacio.");
						$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Calle, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open'); 
						}
					}else{
					//alert("Sin Radio, porfavor verifique que el campo no este vacio.");
					$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Radio, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open'); 
					}

			}else{
			//alert("Sin NIP, porfavor verifique que el campo no este vacio.");
			$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin NIP, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open'); 
			}
		}else{
		//alert("Sin Tipo, porfavor verifique que el campo no este vacio.");
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Tipo, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open');
		}
	}else{
	//alert("Sin Nombre, porfavor verifique que el campo no este vacio.");
	$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Nombre, porfavor verifique que el campo no este vacio.</p>');
										$("#dialog-message" ).dialog('open');
	}
											  
					  
	
		
	}else{
		//alert("Debes de seleccionar un Punto [Lugar] primero");
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debes de seleccionar un Punto [Lugar] primero</p>');
										$("#dialog-message" ).dialog('open');
	}
}else{
	//alert("Debes de seleccionar un Punto [Lugar] primero");
	$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debes de seleccionar un Punto [Lugar] primero</p>');
										$("#dialog-message" ).dialog('open');
}	


	ajax.send(null);

}
//--------------------------------------------------------------------------------------
//////////////////////////////////////////////////////////////////////////////////////////////
function query3(){
//alert(x);		

$('#cbo_cliente').html('<select class="caja"><option value="0" >Cargando...</option></select>');
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mQuery3",true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   //alert(ajax.responseText);
	      var result =ajax.responseText;
			    if(result!= 0){
				$('#cbo_cliente').html(ajax.responseText);										
						}
				
	 }	
 
 }
 ajax.send(null);	 
}
//----------------------------------------------------------------------------------------
function busca_mun_i(){
	var edo = document.getElementById("cbo_edo_i").value;
	document.getElementById("txt_cp_i").value = "";
	if(edo > 0){
		var destino = document.getElementById('Munis_i');
		ajax = nuevoAjax();
		ajax.open("GET", "index.php?m=mContenido&c=mGetMuni_f&idstat="+edo,true);
		ajax.onreadystatechange=function() {
			if(ajax.readyState==1){
				//destino.innerHTML = 'Cargando lista...<br />';
			}else if (ajax.readyState==4) {
				destino.innerHTML = ajax.responseText;
				document.getElementById("cbo_mun_i").disabled = false;
			}
		}		
		ajax.send(null);
	}else{
		//alert("Favor de seleccionar un estado.")
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un estado.</p>');
										$("#dialog-message" ).dialog('open');
	}
}
//----------------------------------------------------------------------------------------
function busca_col_i(){
	var edo = document.getElementById("cbo_edo_i").value;
	var mun = document.getElementById("cbo_mun_i").value;
	if(edo > 0){
		var destino = document.getElementById('Colony_i');
		//alert(edo+'  - '+mun);
		ajax = nuevoAjax();
		ajax.open("GET", "index.php?m=mContenido&c=mGetColonys_f&idstat="+edo+"&idmuni="+mun,true);
		ajax.onreadystatechange=function(){
			if(ajax.readyState==1){
				//destino.innerHTML = 'Cargando lista...<br />';
			}else if (ajax.readyState==4) {
				destino.innerHTML = ajax.responseText;
				document.getElementById("cbo_col_i").disabled = false;
			}
		}		
		ajax.send(null);
	}else{
		//alert("Favor de seleccionar un municipio.")
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un municipio.</p>');
										$("#dialog-message" ).dialog('open');
	}		
}
//-------------------------------------------------------------------------------------------
function pinta_cp_i(dd){
	//alert(dd);
	
	var cod_post = dd.split('|');
	document.getElementById("txt_cp_i").value =cod_post[1];
	/*var cbo_col_i = document.getElementById("cbo_col_i");		
	var num = cbo_col_i.selectedIndex;
	document.getElementById("txt_cp_i").value = cbo_col_i.options[num].label;*/
}
//........................................................................................// 
function notes(op){
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mNote&op="+op,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  $('#dialog-note').html('');
		  $('#dialog-note').dialog('open');
		  $('#dialog-note').html(ajax.responseText);		  
   }
  }
 ajax.send(null);
	}
//------------------------------------------------------------------------------------------	
function pestana(x){
switch(x)
{
case 1:
  document.getElementById('equis').style.display = ''; 
  document.getElementById('ye').style.display = 'none';
  break;
case 2:
  document.getElementById('ye').style.display = ''; 
  document.getElementById('equis').style.display = 'none';
  break;
case 3:
  document.getElementById('ye').style.display = 'none'; 
  document.getElementById('equis').style.display = 'none';
}
	}
	
	
	
	function pestana1(p){
switch(p)
{
case 1:
  document.getElementById('mapa').style.display = ''; 
  
  document.getElementById('pano').style.display = 'none';
  break;
case 2:
  document.getElementById('pano').style.display = ''; 
  document.getElementById('mapa').style.display = 'none';
  break;
}
	}
	
	
	
	
//---------------- funcion que permite descargar archivo excel-plantilla

function down_format()
{
	//window.location="modules/AdRutas/template/descargable/layout.xls";
   window.location="public/rutas/descargable/layout.xls";
}	
//----------------------- funcion que envia el excel.
function enviar_excel(){
	
	if($('#excel').val()==""){			
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un archivo</p>');
		$("#dialog-message" ).dialog('open');
		$('#excel').focus();
		return false;
	}
	

	/*if($('#cto_imp').val()==""){			
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Escriba un nombre o descripci\u00f3n del circuito</p>');
		$("#dialog-message" ).dialog('open');
		$('#excel').focus();
		return false;
	}*/
	
	$("#dialog-message").dialog({ title: "" });
	$('#dialog-message').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:280px; position:absolute; top:40%; left:2%;" ></div></div>');
	$("#dialog-message" ).dialog('open');
	
	barra_progress();
	
	/* var info  = '<table style="font:15px Verdana, Geneva, sans-serif; width:100%; " border="0">'+
				 			  '<tr><td align="center" >&nbsp;</td></tr>'+
				              '<tr><td align="center" >Procesando Informaci&oacute;n espere...</td></tr>'+
							  '<tr><td align="center" >&nbsp;</td></tr>'+
							  '<tr><td align="center" >&nbsp;</td></tr>'+
							  '<tr><td align="center" ><img src="modules/AdRutas/template/images/progressbar.gif"/></td></tr>'+
							  '</table>';
	
	
	document.getElementById('resumen').innerHTML=info;
	*/
	document.forms["aver"].submit();
	document.getElementById('excel').value="";
	$("#dialog-message" ).dialog('close');
	
}		
//------------------------------------------------------------
function mensaje(g,h){
//document.getElementById('resumen').innerHTML =g;
//document.getElementById('des_barra').style.display='none';
//document.getElementById('carga_excel').style.display='none';
//document.getElementById('carga_excel2').style.display='';


if(h==1){
 //filtra_unidad(); 
 //document.getElementById('carga_excel2').innerHTML =g;
  document.getElementById('c_content2').innerHTML =g;
}else{
//document.getElementById('carga_excel2').innerHTML =g;	 
document.getElementById('c_content2').innerHTML =g;	 

}
// panel2(document.getElementById("x_ruta_o").value,document.getElementById("grupo_x").value,document.getElementById("grupo_x3").value);																							

}


//--------------- funcion graficas 

function graficas(){

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mGraficas",true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
      document.getElementById('graficas').innerHTML = ajax.responseText;	  
   }
  }
  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
 ajax.send(null);
}



		  function detalleAnios(anio, semestre1, semestre2) {
                 detalleDiv = document.getElementById('detalle_chart');
		   	  detalleDiv.innerHTML = "";

ajax = nuevoAjax();

ajax.open("POST", "index.php?m=mContenido&c=mGraficas",true);

ajax.onreadystatechange = function() {

if(ajax.readyState == 4) {

detalleDiv.innerHTML = ajax.responseText

detalleDiv.style.display="block";

}

}

ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");

ajax.send("anio=1987&semestre1=2&semestre2=3")


	  
}

//-----------------------------------
	  
	  function imagenes2(){
		document.forms["frm_graficas"].submit();  
	  }
//--------------------------

function grafix_detalle(unidad){
	//alert('detalle='+unidad);
	var destino = document.getElementById('unidades_z'); 
		document.getElementById('cod_entity').value = unidad;
	var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido&c=mGraficas_detalles&unidad="+unidad,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 destino.innerHTML = ajax.responseText;	
		   
		 tigra_tables('g_detalle', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
		 	 document.forms["frm_graficas2"].submit();  
   }
  }
 ajax.send(null);
	
}