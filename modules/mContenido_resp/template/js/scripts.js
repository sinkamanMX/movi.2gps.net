/**/
//var ptoso="";
var rdo=0;
var m='';
var save=0;
var idd = 0;
var ide = 0;
var idp = 0;
//var div='';
var map;
var map2;
var u='';
var style_blue;
var point;
var pointFeature;
var renderer;
var layer_style;
var lat;
var lon;
var lonLat;
var zoom;
var num=0;
var num1=0;
var num2=0;
var num3=0;
var icono_p='';
var n_icon='';
var points = [];
var vectorLayer=null;
var angles = new Array();
var infos = new Array();
var iconos = new Array();
var points = new Array();
var units = new Array();
var units2 = new Array();
var points2= new Array();
var infos2= new Array();
var iconos2= new Array();
var angles2= new Array();

var valid = new Array();

var infos1 = new Array();


var idpo = 0;

var pintaold=-1;
var point_pan= 0;
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
//-------------------------
function change_idpo(id){
//alert(id);
	idpo = id;
}
/*----------------------------------- -------------------------------------------- */
function change_ide(id){
	ide = id;
	//alert(ide);
}
/*----------------------------------- -------------------------------------------- */
var div='';
function change_div(d){

	div = d;
	//alert(div);
}
/*----------------------------------- -------------------------------------------- */
var contas=0;
function init(){
	$('#dialog-acott').find('#tab_cotta').remove();

var cadena='<table border="0" id="tab_cotta" >'+
'<tr><td><img src="public/images/nar_neg.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA TERMINADA, FUERA DE CLIENTE</td></tr>'+
'<tr><td><img src="public/images/nar_roj.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA TERMINADA, FUERA DE CLIENTE, CON RETARDO</td></tr>'+
	'<tr><td><img src="public/images/ver_neg.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA TERMINADA, DENTRO DE CLIENTE</td></tr>'+
	'<tr><td><img src="public/images/roj_neg.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA TERMINADA, DENTRO DE CLIENTE, CON RETARDO</td></tr>'+
	'<tr><td><img src="public/images/az_ver.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA EN PROCESO, FUERA DE CLIENTE</td></tr>'+
	'<tr><td><img src="public/images/az_roj.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA EN PROCESO, FUERA DE CLIENTE, CON RETARDO</td></tr>'+
	'<tr><td><img src="public/images/verd.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA EN PROCESO, DENTRO DE CLIENTE</td></tr>'+
	'<tr><td><img src="public/images/roj_verd.png" style="width:15px;"></img></td><td style=" font-weight: bold;">ENTREGA EN PROCESO, DENTRO DE CLIENTE, CON RETARDO</td></tr>'+
	'<tr><td><img src="public/images/ince.png" style="width:15px;"></img></td><td style=" font-weight: bold;">INCIDENCIAS</td></tr>';
$(cadena).appendTo('#dialog-acott');

if(contas==0){
 $( "#dialog-acott" ).dialog({
								width:300,
								buttons: {
			 
							Ok: function() {
								
				  				$( this ).dialog( "close" );
		  
										}
									  }
									});

r_filtro1();
contas=1;
}



			setInterval(r_filtro1,1800000);				

	           // panel1
				$('#panel1').panel({

					'controls':$('#cntrl').html(),
    				'collapsible':false

				});
	           // dates
				$('#dates').panel({
					

					'controls':$('#cntrl').html(),
    				'collapsible':false

				});	
				$('#dates').hide();			
				$('#panel2').panel({
				'collapsed':true
				});
				
				$( "#start-dates,#start-dates2" ).datepicker({
			showOn: "button",
			buttonImage: "public/images/cal.gif",
			buttonImageOnly: true,
		//	minDate: '0',
			dateFormat: "yy-mm-dd"/*,
			onSelect: function(selected,evnt) {
       			onload1(1);
   			 }*/
		});
				
				
				
				//$('#panelx').tabs();
				$( "#panelx" ).tabs({ active: -4 });
				$( "#tabs-lp" ).tabs();
				//$( "#panelx" ).tabs( "option", "active", 1 );
			   /* $('#panelx').panel({
					'controls':$('#cntrl').html(),
    				'collapsible':false
				});*/
			    $('#panelxa').panel({
					'controls':$('#cntrl').html(),
    				'collapsible':false
				});
			    $('#panelxb').panel({
					'controls':$('#cntrl').html(),
    				'collapsible':false
				});
			    $('#panelxc').panel({
					'controls':$('#cntrl').html(),
    				'collapsible':false
				});								
               // panel interno 2
				$('#panel3').panel({
					'controls':$('#cntrl').html(),
    				'collapsible':false
				});
				// footer
				/* $('#footer').panel({

					'controls':$('#cntrl').html(),
    				'collapsible':false

				});*/
				// botones
              $( "input ubmit, a, button", ".demo" ).button();
			  $( ".b_op" ).button();
			  $( ".b_ic" ).button();
				// combos
				$('select#speedC').selectmenu({style:'dropdown'});
				

			/*$(".b_op" ).button();
						var pickOp={
						maxDate: new Date(),
						showOn: "button",
						buttonImage: "public/images/cal.gif",
						buttonImageOnly: true,
						dateFormat: "yy-mm-dd"
						};*/				
				//$("#start-date").datepicker(pickOp);
				//$("#end-date").datepicker(pickOp);
			///////DIALOG NUEVO	
				
			///////DIALOG crear	
				$("#dialog-crear" ).dialog({
					title: "Nuevo Geo-punto",
					modal: true,
					autoOpen:false,
					overlay: { opacity: 0.2, background: "cyan" },
					width:  700,
					height: 600,
					buttons: {
						
						"Guardar": function(){
							AgregaGeoPunto_Acepta();
						},
			
						"Cancelar": function(){
							if($("#dialog-crear" ).dialog('isOpen')){
							$("#dialog-crear").dialog('close');
							}
							cerrar();
						}
					},
					
					show: "blind",
					hide: "blind"
				}
				);				
			///////DIALOG NUEVO	
					
//.......................................dialog editar..........................//
				$("#dialog_edt" ).dialog({
					title: "Editar {PAGE_TITLE}",
					modal: true,
					autoOpen:false,
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 350,
					height: 455,
					buttons: {
						
						"Guardar": function(){
							validar_datos(2);
							
						},
			
						"Cancelar": function(){
							
							if($("#dialog_edt" ).dialog('isOpen')){
							$("#dialog-message").dialog('close');
							}
							$("#dialog_edt" ).dialog('close');
						
						}
					},
					
					show: "blind",
					hide: "blind",
				}
				);
/*
				$("#dialog_pts" ).dialog({
					title: "Editar {PAGE_TITLE}",
					modal: true,
					autoOpen:false,
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 1150,
					height: 700,
					buttons: {
						
						"Eliminar": function(){
							borrarvje();
							
						},						
						"Guardar": function(){
							validar_ed();
							
						},
			
						"Cancelar": function(){
							
							if($("#dialog_pts" ).dialog('isOpen')){
							$("#dialog-message").dialog('close');
							}
							$("#dialog_pts" ).dialog('close');
						
						}
					},
					
					show: "blind",
					hide: "blind",
				}
				);*/
//.......................................dialog notas..........................//

//.......................................dialog notas..........................//
				$("#dialog_mnote" ).dialog({
					title: "Historial de notas",
					modal: false,
					autoOpen:false,
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 350,
					height: 300,
					show: "blind",
					hide: "blind",
				}
				);	
//.......................................dialog notas X despacho..........................//
			
//.......................................confirmar arribo..........................//
				$("#cfn" ).dialog({
					//title: "Historial de notas",
					modal: false,
					autoOpen:false,
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 400,
					height: 250,
					show: "blind",
					hide: "blind",
					buttons: {
						
						"Guardar": function(){
							cambio();
							
						},
			
						"Cancelar": function(){
							
							if($("#cfn").dialog('isOpen')){
							$("#dialog-message").dialog('close');
							}
							$("#cfn").dialog('close');
						
						}
					}
				}
				);		
//.......................................confirmar entrega..........................//
				$("#cfe" ).dialog({
					//title: "Historial de notas",
					modal: false,
					autoOpen:false,
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 400,
					height: 250,
					show: "blind",
					hide: "blind",
					buttons: {
						
						"Guardar": function(){
							cambio2();
							
						},
			
						"Cancelar": function(){
							
							if($("#cfe").dialog('isOpen')){
							$("#dialog-message").dialog('close');
							}
							$("#cfe").dialog('close');
						
						}
					}
				}
				);																		
//.......................................dialog puntos ed..........................//
											











}

function arrancador(){
	document.oncontextmenu = function () { // Use document as opposed to window for IE8 compatibility
   return false;
};

window.addEventListener('contextmenu', function (e) { // Not compatibile with IE < 9
   e.preventDefault();
}, false);
	
		//r_filtro();
	r_filtro_xc('');
	r_filtro_xa('');
	r_filtro_xb('');
	r_filtro_y();
	//r_filtro_z();

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
	/*var yy="";
	var filt = 0; 
	var text = $('#flt_x').val();
	$('#list_formas').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido2&c=mTabla&txtfil="+text,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				if(result != 0){
					$('#list_formas').html(ajax.responseText);
					tigra_tables('MyDatas', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_formas').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	*/

}
/*-----------------------------------    -------------------------------------------- */
function r_filtro_y(){
	var text = $('#flt_x').val();
	$('#list_formas_y').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido2&c=mTabla_y&txtfil="+text,true);
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
		ajax.open("GET", "index.php?m=mContenido2&c=mTabla_z&txtfil="+text,true);
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
		ajax.open("GET", "index.php?m=mContenido2&c=mTabla_xc&txtfil="+text+"&idd="+x,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				
				//console.log(result);
				if(result != 0){
					$('#list_formas_xc').html(result);
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
		ajax.open("GET", "index.php?m=mContenido2&c=mTabla_xa&txtfil="+text+"&idd="+x,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result)
				console.log(result);
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
		ajax.open("GET", "index.php?m=mContenido2&c=mTabla_xb&txtfil="+text+"&idd="+x,true);
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
function ob_datac(x,y){
	//var text = $('#flt_x').val();
	//$('#list_formas_z').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
//barra_progress();
$('#ptoso').val('');
idpo="";
//alert($('#ptoso').val())
	var ajax = nuevoAjax();
		ajax.open("GET", "index.php?m=mContenido2&c=mDatac&cto="+x+"&idd="+y,true);
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
/*----------------------------------- -------------------------------------------- */
function regs(){
	reg=$("[name='chk']").length;
	$('#reg').html("<b>"+reg+"</b>");
	}
/*  +++++++++++++++++++++++++++++++++++++++++++ DANIEL ++++++++++++++++++++++++++++++++++++  */


//---------función omitir punto de entrega---------
function omitir_punto(){
		$("#dialog-confirm").dialog({
			autoOpen:false,						
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Aceptar": function() {
				proceso_omitir(idpo,$('#cto').val(),$('#idd').val());
				},
				"Cancel": function() {
					$("#dialog-confirm").dialog( "close" );
				}
			}
		});
	if(idpo!=0){
        $('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Esta seguro de omitir el punto de entrega?</p>');
$("#dialog-confirm").dialog("open");
		//
		}
	else{ 
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un punto de la lista del circuito</p>');
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
}
}
//-----------función proceso omitir punto de entrega----------
function proceso_omitir(x,y,z){	
ptoso=($('#ptoso').val()=="")?x:ptoso=ptoso+","+x;
$('#ptoso').val(ptoso);
//alert($('#ptoso').val());
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mDatac&punto="+ptoso+"&cto="+y+"&idd="+z,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  //if(result>0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Punto omitido correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});			  
				if(result != 0){
					$('#list_points_c').html(ajax.responseText);
					tigra_tables('Mydatac', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_points_c').html("<br><br><br><br><center>Circuito sin puntos.</center>");
				}			  
			  
//$('#ptoso').val('');
			//g=$('#idd').val();
			//alert($('#idd').val());
			//mostrar_puntos(g);
			  
			  /*}
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser eliminado</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				  
			 }*/
   }
  }
 ajax.send(null);
 }
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
	if(idp!=0){
        $('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el punto?</p>');
$("#dialog-confirm").dialog("open");
		//
		}
	else{ 
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un punto de la lista</p>');
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
}
}
//...........//
function proceso_borrar(x){	
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mBorrar&punto="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  if(result>0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Punto eliminado correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			g=$('#idd').val();
			//alert($('#idd').val());
			mostrar_puntos(g);
			  
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser eliminado</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				  
			 }
   }
  }
 ajax.send(null);
 }
 //...............................................................................//
 function cancelar(o){
	 //alert("3n7r0")
		$("#dialog-confirm").dialog({
			autoOpen:false,						
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Aceptar": function() {
				proceso_cancelar(idp,o);
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
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
}
}
//---------------------------------------------------------------------------------
function proceso_cancelar(x,o){	
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mCancelar&punto="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  if(result>0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Punto cancelado correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			g=$('#idd').val();
			//alert($('#idd').val());
			r_filtro_xa('');
			r_filtro_xb('');
			r_filtro_xc('');		
			$('#dialog_ptse').dialog('close');
			if(o==1){
			mostrar_puntos($('#idd').val());
			
			}
			
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser cancelado</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				  
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
 ajax.open("GET", "index.php?m=mContenido2&c=mNuevo&und="+und,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		var result=ajax.responseText;
		
		  $('#dialog').html('');
		  //$('#dialog').dialog('open');
		 
		  $(result).appendTo('#dialog');

 			$( "#dialog" ).dialog({
								title: "Nuevo Viaje",
					modal: true,
					overlay: { opacity: 0.2, background: "cyan" },
					width:  350,
					height: 420,
								buttons: {
						
						"Guardar": function(){
							validar_datos_d(0);
							//$("#dialog").dialog('close');
						},
			
						"Cancelar": function(){
						/*	if($("#dialog" ).dialog('isOpen')){
								$("#dialog-message").dialog('close');
							}*/
							$("#dialog").dialog('close');
							cerrar();
						}
					}
									});
		  
		  
	
		  	  
   }
  }
 ajax.send(null);
	}

//........................................................................................//
function validar_datos_d(xdr){
var ifs=0;	

if($('#vj').val()==''){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
return false;
	}

if($('#und').val()==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
return false;
	}

if($('#idv').val()==''){	
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un identificador</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
return false;
	}	

if($('#start-date').val()==''){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha inicial</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
return false;
	}
	
if($('#end-date').val()==''){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha final</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
return false;
	}

var iniciamel=Date.parse($('#start-date').val()+" "+$('#horaInicio').val()+":"+$('#minutoInicio').val()+":00");
var finamel=Date.parse($('#end-date').val()+" "+$('#horaFin').val()+":"+$('#minutoFin').val()+":00");


if( iniciamel > finamel){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un rango de fechas valido</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
return false;
	}		

if($('#tl').val()==''){
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una tolerancia de arribo</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
return false;
	}

	if(ifs==0){
	almacenar_nuevo(xdr);
	$("#dialog").dialog('close');
	$("#dialog_agp").dialog('close');
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
function almacenar_nuevo(xdr){	
var a=$('#vj').val();
var b=$('#und').val();
var c=$('#idv').val();
var d=$('#start-date').val()+" "+$('#horaInicio').val()+":"+$('#minutoInicio').val()+":00";
var e=$('#end-date').val()+" "+$('#horaFin').val()+":"+$('#minutoFin').val()+":00";
var f=$('#tl').val();
($('#stop').is(':checked'))? g=1: g=0;
($('#exc').is(':checked'))? h=1: h=0;
var result=0;

  //$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  	//	$("#dialog_pb" ).dialog('open');
		
//barra_progress();

 var ajax = nuevoAjax();
  ajax.open("GET", "index.php?m=mContenido2&c=mGdrNvo&dsc="+a+"&idv="+c+"&dti="+d+"&dtf="+e+"&stp="+g+"&exc="+h+"&tol="+f+"&und="+b+"&tip="+xdr ,true);
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
				//r_filtro_z();
				//r_filtro();
				
				if(xdr==0){
				add_pts(result);
				}
					
			}

						}
	
  }
  
 ajax.send(null);



	}
//.......................................................................................//	
function add_pts(id){

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mAddpts&idd="+id,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 
		var result=ajax.responseText;
	 //alert(result);
		   $('#dialog_agp').html('');
		  //$('#dialog').dialog('open');
		 
		 // $(result).appendTo('#dialog_pts');
		  
		  $('#dialog_agp').html(result);
		
				 $( "#dialog_agp" ).dialog({
								title: "Editar",
					modal: true,
					overlay: { opacity: 0.2, background: "cyan" },
					width: 1100,
					height: 710,
								buttons: {
						
						"Guardar": function(){
							var xdr=1;
							validar_datos_d(id);
							
						},
			
						"Cancelar": function(){
						/*	if($("#dialog" ).dialog('isOpen')){
								$("#dialog-message").dialog('close');
							}*/
							$("#dialog_agp").dialog('close');
							cerrar();
						}
					}
									});
				
				
				
		 
		  	//alert(ajax.responseText);	  
   }
  }
 ajax.send(null);

//mostrar_puntos(id);

	}
//.......................................................................................//	
function edt_pts(x){
//alert(idd+"/"+ide);
idd=(idd==0)?$('#idd').val():idd;
//ide=(ide==0)?$('#ide_edt_pts').val():ide;
//alert(idd+"/"+ide);
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mEdtpts&idd="+idd+"&ide="+ide+"&btn="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 var result=ajax.responseText;
		  $('#dialog_ptse').html('');
		
		  $('#dialog_ptse').html(result);
		  
		  $( "#dialog_ptse" ).dialog({
								title: "Editar Punto",
					modal: true,
					overlay: { opacity: 0.2, background: "cyan" },
					width:  1000,
					height: 300,
								buttons: {
						
						"Guardar": function(){
								validar_edp();
							//$("#dialog").dialog('close');
						},
			
						"Cancelar": function(){
							
							if($("#dialog_ptse" ).dialog('isOpen')){
							$("#dialog-message").dialog('close');
							}
							$("#dialog_ptse" ).dialog('close');
							
							}
					}
									});
		  
		  
		  
		 	
		  
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
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
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
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				    

						  //  destino1.innerHTML = ajax.responseText;
						
						//$("#dialog_edt" ).dialog('close');	
						//
						//init();
						}else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n no pudo ser almacenada</p>');
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});								
						
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
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
r_filtro();
}	*/
function m2(){
$("#dialog_pb" ).dialog('close');		
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0; width:25px; "></span>La informaci\u00f3n no ha podido ser guardada  correctamente.</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	 
}	
function m3(){	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0; width:25px; "></span>Tipo de archivo no valido</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
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

m=(t.getMonth()<9)?"0"+(parseInt(t.getMonth())+1):parseInt(t.getMonth())+1;
x=(t.getDate()<=9)?"0"+t.getDate():t.getDate();
h=(t.getHours()<=9)?"0"+t.getHours():t.getHours();
i=(t.getMinutes()<=9)?"0"+t.getMinutes():t.getMinutes();
e= t.getFullYear()+"-"+m+"-"+x+" "+h+":"+i+":00";
f=$('#release_date').val()+" "+$('#his').val()+":"+$('#mis').val()+":00";

//alert($('#op').val())
if($('#op').val()==1){
	//alert($('#cte').val());
	
	if($('#tip_clits').val()==1){
		//alert($('#cte').val());
		var codse=$('#cte').val();
		if($('#cte').val()==0 ){
			//alert(codse);
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
return false;
	}
	
		}else{
			
			
			if( $('#cte_3').val()==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
return false;
	}
	
			
			}
	

	
	

if($('#delivery-date').val().length==0){	
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
return false;
	}	

if(a < b | a > c | a<e){
//alert("no entra")	;
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha dentro del rango de fecha inicio y fin del viaje y/o mayor  a la fecha actual: '+e+'</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
return false;
	}

if(f<=a){
//alert("no entra")	;
ifs=ifs+1;	
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La fecha de salida debe ser mayor o igual a la de entrega</p>');
$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
return false;
	}
	//alert (ifs);
/*if(ifs==0){
	agregar_punto();
		}*/	
}
else{	
	var cn=$('#cnt').val;
	for(x=0; x<$('#cnt').val(); x++){
		d=$('#dt'+x).val()+" "+$('#hr'+x).val()+":"+$('#mn'+x).val()+":00";//entrega
		df=$('#dtf'+x).val()+" "+$('#hrf'+x).val()+":"+$('#mnf'+x).val()+":00";//fin
		//alert($("#dt"+x).attr('id'));
		if($('#dt'+x).val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega en el registro </p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
		//alert(df+"<"+d);
		if(df<d){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La fecha fin es menor a la fecha de entrega en el registro '+(x+1)+'</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}			
			
		if(d < b | d > c | d < e){
			//alert(d+"menor"+b+" "+d+"mayor"+c+" "+d+"menor"+e)
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha dentro del rango de fecha inicio y fin del viaje y/o mayor  a la fecha actual: '+e+'</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
			
		/*if($('#cst'+x).val()==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega en el registro </p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}*/
						
		}
/*if(ifs==0){
	agregar_punto();
		}*/		
	}


//alert(ifs);
	if(ifs==0){
	agregar_punto();
		}
	}

//........................................................................................// 
function agregar_punto(){
datap="";	
for(x=0; x<$('#cnt').val(); x++){
	
	if(datap==""){
		datap=$('#pto'+x).val()+"|"+$('#dt'+x).val()+" "+$('#hr'+x).val()+":"+$('#mn'+x).val()+":00"+"|"+$('#obs'+x).val()+"|"+$('#itm'+x).val()+"|"+$('#cst'+x).val()+"|"+$('#dtf'+x).val()+" "+$('#hrf'+x).val()+":"+$('#mnf'+x).val()+":00"+"|"+$('#tol'+x).val();
		}
	else{
		datap=datap+"~"+$('#pto'+x).val()+"|"+$('#dt'+x).val()+" "+$('#hr'+x).val()+":"+$('#mn'+x).val()+":00"+"|"+$('#obs'+x).val()+"|"+$('#itm'+x).val()+"|"+$('#cst'+x).val()+"|"+$('#dtf'+x).val()+" "+$('#hr'+x).val()+":"+$('#mnf'+x).val()+":00"+"|"+$('#tol'+x).val();
		}	
		//alert($('#itm'+x).val())
	}	
//alert(datap);
				var a="";
				var b="";
				var c="";
				var d="";
				var e="";
				var f="";
				var g="";
				var h="";		
 
 var rhs=0;
 if($('#tip_clits').val()==1){
	 rhs=0;
 cte=$('#cte').val();
 ct=cte.split("¬");

 }else{
	  cte=$('#cte_3').val();
 	ct=cte.split("¬");
	rhs=1;
	 }
  var a=ct[0];
 
 var b=$('#idp').val();
 var c=$('#delivery-date').val()+" "+$('#hi').val()+":"+$('#mi').val()+":00";
 var d=$('#obs').val();
 var e=($('#cst').val()== undefined)?"":$('#cst').val();
 //alert($('#cst').val()+"/"+e)
 //var e=$('#cst').val();
 //var f=$('#pld').val();
 var g=$('#idd').val();
 var h=$('#release_date').val()+" "+$('#his').val()+":"+$('#mis').val()+":00";
 var i=$('#tol_ent').val();

//alert($('#release_date').val()+" "+$('#his').val()+":"+$('#mis').val()+":00");
 //h=$('#und').val();


  $('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		
barra_progress();

 var ajax = nuevoAjax();
  //ajax.open("GET", "index.php?m=mContenido2&c=mGdrPto&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&pld="+f+"&idd="+g+"&und="+h,true);
  //alert("index.php?m=mContenido2&c=mGdrPto&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&pld="+f+"&idd="+g+"&datap="+datap+"&dts="+h+"&tol="+i);
  ajax.open("GET", "index.php?m=mContenido2&c=mGdrPto&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&idd="+g+"&datap="+datap+"&dts="+h+"&tol="+i+"&rh="+rhs,true);
  ajax.onreadystatechange=function() {

  	 if (ajax.readyState==4) {
		$("#dialog_pb" ).dialog('close');				
	      result =ajax.responseText;
		  console.log(result);
		  //alert(result)
		   	if(result>0){
				
				save=1;
				//$("#dialog").dialog('close');
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto  se ha almacenado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
				
				r_filtro_y();
				//r_filtro_z();
				$("#list_points_c").html("");
				mostrar_puntos($('#idd').val());
				
				$("#cte option:eq(0)").attr("selected", "selected");
				//$("#und option:eq(0)").attr("selected", "selected");
				$("#hi  option:eq(0)").attr("selected", "selected");
				$("#mi  option:eq(0)").attr("selected", "selected");
				$("#his  option:eq(0)").attr("selected", "selected");
				$("#mis  option:eq(0)").attr("selected", "selected");
				$("#cst option:eq(0)").attr("selected", "selected");
				$('#idp').val("");
				$('#delivery-date').val("");
				$('#release_date').val("");
				$('#obs').val("");
				//$('#cst').val();
				$('#pld').val("");			
				//$('#idd').val();
				//$('#un').val();
				r_filtro_xc('');
				$("#cto option[value='0']").attr("selected",true);
				
			}
			else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser almacenado</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
				}

						}
	
  }
  
 ajax.send(null);



	}	
//----------------------------------------------

function mostrar_puntos(id){
//alert(id);
window.onerror = new Function("return true");
$('#list_points').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
barra_progress();

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery&idd="+id+"&ide="+ide,true);
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
					//alert($('#MyDatap'))
					if($('#MyDatap')!=null){
					tigra_tables('MyDatap', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
					}
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
 ajax.open("GET", "index.php?m=mContenido2&c=mDnotas&ide="+x,true);
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
//----------------------------------------------

function mostrar_notas_dsp(x){
//alert(x);

//$('#list_points').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div>');
//barra_progress();
//alert(x);
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mDnotasdsp&idd="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   
	      var result =ajax.responseText;
		  //alert(result);
			    //if(result!= 0){	
				
					//	}
				if(result == 0){
											
				$('#dialog_mnoted').html('El viaje no cuenta con documentaci\u00f3n');
				
				$("#dialog_mnoted" ).dialog({
					title: "Historial de notas",

					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 250,
					height: 100
		
				}
				);
					
					
						}
				else{
					$('#dialog_mnoted').html(result);
					tigra_tables('MyDatand', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				
				$("#dialog_mnoted" ).dialog({
					title: "Historial de notas",
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 350,
					height: 300
			
				}
				);
				
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
	

		
	if($("#data").val() != data2){
		var ifs=0;	
		
		if($('#dsp').val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n del viaje.</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
		
		if($('#und').val()==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
		
		if($('#idv').val().length==0){	
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un identificador del viaje.</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		return false;
			}	
		
		//if($('#start-date').val().length==0)
		if($('#dti').val().length==0){	
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha inicial</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
		return false;
			}
			
		if($('#dtf').val().length==0){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha final</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
		return false;
			}
			
		if($('#dti').val()>$('#dtf').val()){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un rango de fechas valido</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
		return false;
			}		
		
		if($('#tl').val().length==0){
		ifs=ifs+1;	
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una tolerancia de arribo</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
		return false;
			}
		
			if(ifs==0){
			gdr_ed();
				}		
		}
	else{
		$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		///////////////////////////////////////////////////////////////////////////////////////////
		barra_progress();
		////////////////////////////////////////////////////////////////////////////////////////////////////////////  			
		$("#dialog_pb" ).dialog('close');
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
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

		$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		///////////////////////////////////////////////////////////////////////////////////////////
		barra_progress();
		////////////////////////////////////////////////////////////////////////////////////////////////////////////  	
		
		var ajax = nuevoAjax();
  		ajax.open("GET", "index.php?m=mContenido2&c=mGdrEdt&dsp="+a+"&idv="+b+"&und="+c+"&dti="+d+"&dtf="+e+"&tl="+f+"&st="+st+"&ex="+ex+"&cu="+h+"&idd="+g ,true);
  		ajax.onreadystatechange=function() {
  	 	if (ajax.readyState==4) {
			$("#dialog_pb" ).dialog('close');	
	     	var result =ajax.responseText;
				//alert(result);
			if(result > 0){
				save=1;
				//var x_cadena = ajax.responseText;
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
				$("#dialog_pts" ).dialog('close');
				r_filtro_xc('');			    
						}else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n no pudo ser almacenada</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});								
						
						}
				}	
 
  }
  

 ajax.send(null);
		 	
	}
	
	//----------------------------------------------------
function validar_edp(){
	//var st=($("#st").is(':checked'))?1:0;
	//var ex=($("#ex").is(':checked'))?1:0;
	var data2= $("#cte").val()+'¬'+$("#idp").val()+'¬'+$("#delivery-date").val()+'¬'+$("#hi").val()+'¬'+$("#mi").val()+'¬'+$("#obs").val()+'¬'+$("#cst").val()+'¬'+$("#pld").val();	
	//var u=$("#data").val().split("¬");
	
//////////  	
		
	if($("#data_edp").val() != data2){
		var ifs=0;	
		
		if($('#cte2').val()==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
		
		if($('#idp2').val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un identificador del punto</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
		
		if($('#delivery-date2').val().length==0){	
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de entrega</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		return false;
			}
		if($('#departure_date').val().length==0){	
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha de salida</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		return false;
			}				

		
		if($('#delivery-date2').val()+" "+$('#hi2').val()+":"+$('#mi2').val()+":00" > $('#departure_date').val()+" "+$('#his').val()+":"+$('#mis').val()+":00"){	
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La fecha de salida debe ser mayor a la fecha de entrega</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		return false;
			}		
		
		
			if(ifs==0){
				//alert('todo chido')
			gdr_edp();
				}		
		}
	else{
		$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		///////////////////////////////////////////////////////////////////////////////////////////
		barra_progress();
		//////////////////////////////////////////////////////////////////////////////////////////////////		
		$("#dialog_pb" ).dialog('close');
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
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
		var a=$('#cte2').val();
		var b=$('#idp2').val();
		var c=$('#delivery-date2').val()+" "+$('#hi2').val()+":"+$('#mi2').val()+":00";
		var d=$('#obs2').val();
		var e=$('#cst2' ).val();
		var f=$('#pld').val();
		var g=$('#departure_date').val()+" "+$('#his').val()+":"+$('#mis').val()+":00";
		 //alert(h)

		$('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		///////////////////////////////////////////////////////////////////////////////////////////
		barra_progress();
		//////////////////////////////////////////////////////////////////////////////////////////////////
		var ajax = nuevoAjax();
  		ajax.open("GET", "index.php?m=mContenido2&c=mGdrEdtp&cte="+a+"&idp="+b+"&dte="+c+"&obs="+d+"&cst="+e+"&pld="+f+"&ide="+ide+"&dts="+g,true);
  		ajax.onreadystatechange=function() {
  	 	if (ajax.readyState==4) {
			$("#dialog_pb" ).dialog('close');	
	     	var result =ajax.responseText;
				//alert(result);
			if(result > 0){
				save=1;
				//var x_cadena = ajax.responseText;
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n se ha almacenado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
				$("#dialog_ptse" ).dialog('close');
				r_filtro_xc('');			    
						}else{
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La informaci&oacute;n no pudo ser almacenada</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});								
						
						}
				}	
 
  }
  

 ajax.send(null);
		 	
	}	
//------------------------------------------------------------------------------




/*function mostrar_mapa(op){
		lats.length=0;
	lons.length=0;
	points.length=0;
yp=$("#idd").val(); 
	var colortrue= "#F32424";
	
	 var path = "index.php?m=mContenido2&c=mFollowEdts&ide="+yp;
	//map.clearOverlays();
	
	
$.getJSON(path,function(data) {
		var points = [];
		$.each(data.items, function(i,item){
			var point = new GLatLng(item.unitLatitude, item.unitLong);		
			points.push(point);		    		
		
		 var info = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+'<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_streetview();" class="thickbox popUp">Ver Street View</a></b><br></td></tr>'+'</table>';
		
		map.addOverlay(createUnits(point, i,item.unit,item.unitLatitude,item.unitLong,item.icono,item.angle,item.fecha,info));
	    updateFields(item.unitLatitude, item.unitLong);
			});
			var polyline = new GPolyline(points, colortrue, 5);
		map.addOverlay(polyline);  

	
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
	var latlngbounds = '';
	function muestra_todo(){
	 latlngbounds = new GLatLngBounds( );
  	for ( var i = 0; i < points.length; i++ ){
	   //alert(points[i]);
	    latlngbounds.extend( points[ i ] );
  	}
 	map.setCenter( latlngbounds.getCenter( ),10);
}
	
	*/
	

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
	$('#'+b+'').css("visibility","hidden");		 
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
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery2&it="+it,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		   
	      var result =ajax.responseText;
		  //alert(result);
			    //if(result!= 0){	
				
					//	}
				if(result > 0){						
		$('#idp').val('');
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto ya existe.</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
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
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}
		if($('#note').val().length==0){
		ifs=ifs+1;
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el contenido de la nota</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
		return false;
			}			
if(ifs==0){
var a=$('#tnote').val();
var b=$('#note').val();
var c=$('#ide_edt_pts').val();
var d=$('#idd').val();
var e=$('#op_note').val();

//alert(d);


  $('#dialog_pb').html('<p align="center">Guardando Datos...<div id="progressbar"></div></p>');
  		$("#dialog_pb" ).dialog('open');
		
barra_progress();

 var ajax = nuevoAjax();
  ajax.open("GET", "index.php?m=mContenido2&c=mGdrNot&tnote="+a+"&note="+b+"&ide="+c+"&op="+e+"&idd="+d,true);
  ajax.onreadystatechange=function() {

  	 if (ajax.readyState==4) {
		$("#dialog_pb" ).dialog('close');				
	      result =ajax.responseText;
		  //alert(result);
		  if(result>0){
			  closeb('addnote'); 
			  //document.getElementById('puntos').style.zIndex=0;
			  //document.getElementById('panelPE').style.zIndex=0;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Nota almacenada correctamente</p>');
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			$("#dialog-note" ).dialog('close');
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La nota no pudo ser almacenada</p>');
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				  
			 }		 

						}
	
  }
  
 ajax.send(null);
}


	}	
//-------------------------
function crear_punto(){
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mAdd_GeoPuntos",true);
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
//---------------------------------------------------------


//----------------------------------------------------------------
/*function busca_por_cp(){
	var cp	 = document.getElementById("txt_cp_i").value;
	var path = "index.php?m=mContenido2&c=mFindDirection&cp="+cp;
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
	$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
	return false;
		}
	if(ifs==0)	{
	var ajax = nuevoAjax();
 	ajax.open("GET", "index.php?m=mContenido2&c=mFindDirection&cp="+cp,true);
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
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});  
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
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 		
	  //alert("Debe de ingresar el nombre de la calle.");
	}
}

function show_streetview(){

pestana1(2);
  
	var title = '';
	var name  =	''; 					  
	var href  = '#TB_inline?modal=true';
	var alt   = '';
	var rel   = true;
	var t = title || name || null;
	var a = href  || alt;
	var g = rel   || false;

	onloadpan();
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
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 		
		//alert("Debes de ingresar latitud y longitud");
	}				
}
//-----------------------------------------------------------
function calcula_dir(lat,lon){

	var destino = document.getElementById('divdireccionAdd');
	ajax = nuevoAjax();
	ajax.open("GET", "index.php?m=mContenido2&c=mAdd_GeoPuntosDireccion&lat="+lat+"&lon="+lon,true);
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
												var url = 'index.php?m=mContenido2&c=mAdd_GeoPuntosExe'+
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
													$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 	
															//AgregaGeoPunto_Limpieza();
															$('#dialog-crear').dialog('close');
															
														}else{
															//alert("No se ha podido Agregar el GeoPunto \n Intentelo nuevamente mas Tarde.");
															$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se ha podido Agregar el GeoPunto \n Intentelo nuevamente mas Tarde</p>');
													$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
															//AgregaGeoPunto_Limpieza();
															$('#dialog-crear').dialog('close');
														}
														document.body.style.cursor = 'default';
													}			
												}		
													
												}else{
													$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Longitud, porfavor verifique que el campo no este vacio.</p>');
													$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 	
												//alert("Sin Longitud, porfavor verifique que el campo no este vacio.");
												}
											}else{
											//alert("Sin Latitud, porfavor verifique que el campo no este vacio.");
											$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Latitud, porfavor verifique que el campo no este vacio.</p>');
											$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 	
											}
										}else{
										//alert("Sin Codigo Postal, seleccione una colonia para obtenerlo.");
										$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin C\u00f3digo Postal, seleccione una colonia para obtenerlo.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
										}
									}else{
									//alert("Sin Colonia, porfavor verifique que el campo no este vacio.");
									$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Colonia, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
									}
								}else{
								//alert("Sin Municipio, porfavor verifique que el campo no este vacio.");
								$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Municipio, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
								}
							}else{
							//alert("Sin Estado, porfavor verifique que el campo no este vacio.");
							$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Estado, porfavor verifique que el campo no este vacio</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
							}
						}else{
						//alert("Sin Calle, porfavor verifique que el campo no este vacio.");
						$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Calle, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
						}
					}else{
					//alert("Sin Radio, porfavor verifique que el campo no este vacio.");
					$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Radio, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
					}

			}else{
			//alert("Sin NIP, porfavor verifique que el campo no este vacio.");
			$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin NIP, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		}); 
			}
		}else{
		//alert("Sin Tipo, porfavor verifique que el campo no este vacio.");
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Tipo, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		}
	}else{
	//alert("Sin Nombre, porfavor verifique que el campo no este vacio.");
	$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin Nombre, porfavor verifique que el campo no este vacio.</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
	}
											  
					  
	
		
	}else{
		//alert("Debes de seleccionar un Punto [Lugar] primero");
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debes de seleccionar un Punto [Lugar] primero</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
	}
}else{
	//alert("Debes de seleccionar un Punto [Lugar] primero");
	$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debes de seleccionar un Punto [Lugar] primero</p>');
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
}	


	ajax.send(null);

}
//--------------------------------------------------------------------------------------
//////////////////////////////////////////////////////////////////////////////////////////////
function query3(){
//alert(x);		

$('#cbo_cliente').html('<select class="caja"><option value="0" >Cargando...</option></select>');
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery3",true);
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
		ajax.open("GET", "index.php?m=mContenido2&c=mGetMuni_f&idstat="+edo,true);
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
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
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
		ajax.open("GET", "index.php?m=mContenido2&c=mGetColonys_f&idstat="+edo+"&idmuni="+mun,true);
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
										$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
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
 ajax.open("GET", "index.php?m=mContenido2&c=mNote&op="+op,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  $('#dialog-note').html('');
		 
		  $('#dialog-note').html(ajax.responseText);	
		  	
			$("#dialog-note" ).dialog({
					title: "Nueva Nota",
					overlay: { opacity: 0.2, background: "cyan", width:300 },
					width: 350,
					height: 300,
					buttons: {
						
						"Guardar": function(){
							gdr_note();
							
						},
			
						"Cancelar": function(){
							
							if($("#dialog-note" ).dialog('isOpen')){
							$("#dialog-message").dialog('close');
							}
							$("#dialog-note" ).dialog('close');
						
						}
					}
				}
				);	
		  
		  	  
   }
  }
 ajax.send(null);
	}
//------------------------------------------------------------------------------------------	
function pestana(x){

switch(x)
{
case 1:
  document.getElementById('pritm').style.display = 'none'; 
  document.getElementById('ye').style.display = '';
  break;
case 2:
  document.getElementById('ye').style.display = ''; 
  document.getElementById('pritm').style.display = 'none';
  break;
case 3:
  document.getElementById('ye').style.display = 'none'; 
  document.getElementById('pritm').style.display = 'none';
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
   window.location="public/Descargas/layout.xls";
}	
//---------------------------------------------
function down_format_2()
{
	//window.location="modules/AdRutas/template/descargable/layout.xls";
   window.location="public/Despacho/descargable/layout_puntos.xls";
}	
//---------------------------------------------
function down_format_pto(){
	window.location="public/Despacho/descargable/layout_puntos.xls"
	}
//---------------------------------------------
function down_format_pld(){
	 $.ajax({
          url: "index.php?m=mContenido2&c=mCuestionario",
          type: "GET",
          success: function(data) {
            var result = data; 
            $('#dialog_qst').html('');
            $('#dialog_qst').dialog('open');
			$('#dialog_qst').html(result); 
          }
      });
	}	
//----------------------------------
function cadena_cuestionarios(){
	var qs = "";
	var qt = "";
	$('input[name="qst"]:checked').each(function(){
		//alert($(this).attr("title"));
		qs += (qs == "")?$(this).val():","+$(this).val();
		qt += (qt == "")?$(this).attr("title"):","+$(this).attr("title");
		//cada elemento seleccionado
		
		});
		//alert(qs)
	if(qs!=""){
		generar_excel(qs,qt);
		$('#dialog_qst').dialog('close');
		}
	else{
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar uno o mas cuestionarios.</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		}
	//window.location="public/Despacho/descargable/layout_payload.xls"
	}
//---------------------------
function generar_excel(qs,qt){
	//alert(qs+"/"+qt);
	var url = "index.php?m=mContenido2&c=mExcelPld&qs="+qs+"&qt="+qt;
	window.location = url;
	return false;
	}
//----------------------- funcion que envia el excel.
function enviar_excel(){
	
	if($('#excel').val()==""){			
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un archivo</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		$('#excel').focus();
		return false;
	}
	
	$("#dialog-message").dialog({ title: "" });
	$('#dialog-message').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:280px; position:absolute; top:40%; left:2%;" ></div></div>');
	$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
	
	barra_progress();
	
	document.forms["aver"].submit();
	document.getElementById('excel').value="";
	$("#dialog-message" ).dialog('close');
	
}
//----------------------- funcion que envia el excel.
function enviar_excel_pto(){
	
	if($('#excel_pto').val()==""){			
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un archivo</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		$('#excel_pto').focus();
		return false;
	}
	
	$("#dialog-message").dialog({ title: "" });
	$('#dialog-message').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:280px; position:absolute; top:40%; left:2%;" ></div></div>');
	$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
	
	barra_progress();
	
	document.forms["form_pto"].submit();
	$("#excel_pto").val('');
	//document.getElementById('excel').value="";
	$("#dialog-message" ).dialog('close');
	
}
//----------------------- funcion que envia el excel.
function enviar_excel_pld(){
	
	if($('#excel_pld').val()==""){			
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un archivo</p>');
		$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		$('#excel_pld').focus();
		return false;
	}
	
	$("#dialog-message").dialog({ title: "" });
	$('#dialog-message').html('<div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:280px; position:absolute; top:40%; left:2%;" ></div></div>');
	$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
	
	barra_progress();
	
	document.forms["env_excel_pld"].submit();
	$("#excel_pld").val('');
	//document.getElementById('excel').value="";
	$("#dialog-message" ).dialog('close');
	
}	
 	
//------------------------------------------------------------
function mensaje(g){
																							
document.getElementById('c_content2').innerHTML =g;	 
	//r_filtro();
	r_filtro_xc('');
	r_filtro_xa('');
	r_filtro_xb('');
	r_filtro_y();
	//r_filtro_z();
}

//-----------------------------------------------------------
function mensaje_pto(g){
	$("#c_content3").html(g);
	//r_filtro();
	r_filtro_xc('');
	r_filtro_xa('');
	r_filtro_xb('');
	r_filtro_y();
	//r_filtro_z();
	}
//------------------------------------------
function mensaje_pld(g){
	$("#c_content4").html(g);
	/*r_filtro();
	r_filtro_xc('');
	r_filtro_xa('');
	r_filtro_xb('');
	r_filtro_y();
	r_filtro_z();*/
	}
//--------------- funcion graficas 

function graficas(){

 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mGraficas",true);
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

ajax.open("POST", "index.php?m=mContenido2&c=mGraficas",true);

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
	 var cod_cli =  document.getElementById('COD_CLIENT').value; 
	var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mGraficas_detalles&unidad="+unidad+"&cod_cli="+cod_cli,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 destino.innerHTML = ajax.responseText;	
		   
		 tigra_tables('g_detalle', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
		 	 document.forms["frm_graficas2"].submit();  
   }
  }
 ajax.send(null);
	
}

//-----------------------------------
function dsp_b(x){

switch(x)
{
case 1:
        $('#bx').css("display","");
        $('#bx').css("visibility","visible");
  break;
case 2:
        $('#bxa').css("display","");
        $('#bxa').css("visibility","visible");
  break;
case 3:
        $('#bxb').css("display","");
        $('#bxb').css("visibility","visible");
  break;
case 4:
        $('#bxc').css("display","");
        $('#bxc').css("visibility","visible");
  break;

}

        }
//-----------------------------------	
function exportar(x){

	var url = "index.php?m=mContenido2&c=mGet_Report_XLS";
	var urlComplete = url + "&idd="+x;
	
	//var newWindow=window.open(urlComplete,'Reporte KML','height=600,width=800');
	window.location = urlComplete;
	return false;
}	
//-----------------------------------
function validar_dte(){
x=$('#idd').val();
y=$('#delivery-date').val()+' '+$('#hi').val()+':'+$('#mi').val()+':00';
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery4&idd="+x+"&dte="+y,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 result = ajax.responseText;
		 if(result>0){
			 //ifs=ifs+1;	
			 //alert(ifs);
				$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Fecha asignada a un viaje registardo conanterioridad</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});	
				//return false;
				$('#delivery-date').val('');
				$("#hi option[value='00']").attr("selected",true);
				$("#mi option[value='00']").attr("selected",true);
			 }
   }
  }
 ajax.send(null);
	}
//------------------------------------
function dates(e,x){
//alert (e);	
//alert(event.pageX+','+event.pageY);
/*if (navigator.appName == 'Netscape' && e.which == 3) {
 return false;
}*/
//alert(evt)
if (e.button==2){	
$('#dates').css('left',e.pageX);
$('#dates').css('top',e.pageY);
//$('#dates').css('left',evt.pageX);
//$('#dates').css('top',evt.pageY);		
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery5&ide="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 if(ajax.responseText=!0){
		 $('#detalle').html(ajax.responseText);
		 $('#dates').css('display','');
		 }
	 else{
		 $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin datos disponibles.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		 }
		 //tigra_tables('g_detalle', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
		 	// document.forms["frm_graficas2"].submit();  
   }
  }
 ajax.send(null);
}
	}	
//------------------------------------
function confirmarA(s,ide){
	//alert(s+'/'+ide)
	//alert($("#contenido_confirmacion").css("z-index"))
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery6&ide="+ide,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 //alert(ajax.responseText)
		 if(ajax.responseText=!0){/*
		 $('#contenido_confirmacion').html(ajax.responseText);
		 $('#confirmacion').css('display','');
		 */
		  $('#cfn').html('');
		  $('#cfn').dialog('open');
		  $('#cfn').html(ajax.responseText);		
		 }
	 else{
		 $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin datos disponibles.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		 }
		 //tigra_tables('g_detalle', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
		 	// document.forms["frm_graficas2"].submit();  
   }
  }
 ajax.send(null);
	}
//------------------------------------
function confirmarE(s,ide){
	//alert(s+'/'+ide)
	//alert($("#contenido_confirmacion").css("z-index"))
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mQuery7&ide="+ide,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		 //alert(ajax.responseText)
		 if(ajax.responseText=!0){/*
		 $('#contenido_confirmacion').html(ajax.responseText);
		 $('#confirmacion').css('display','');
		 */
		  $('#cfe').html('');
		  $('#cfe').dialog('open');
		  $('#cfe').html(ajax.responseText);		
		 }
	 else{
		 $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin datos disponibles.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
		 }
		 //tigra_tables('g_detalle', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
		 	// document.forms["frm_graficas2"].submit();  
   }
  }
 ajax.send(null);
	}	
//------------------------------------
function cambio(){
	/*var id = $('#identrega').val();
	var st = $('#status').val();
	if(st==8){var dt = $('#fecha_arribo').val()+" "+$('#hi_dt').val()+":"+$('#mi_dt').val()+":00";}
	if(st==9){
		var dt  = $('#fecha_arribo2').val()+" "+$('#hi_dt2').val()+":"+$('#mi_dt2').val()+":00";
		var dt2 = $('#fecha_salida').val()+" "+$('#hi_dt3').val()+":"+$('#mi_dt3').val()+":00";
		}*/
	var id = $('#identrega').val();	
	var dt = $('#fecha_arribo').val()+" "+$('#hi_dt').val()+":"+$('#mi_dt').val()+":00";
	var ajax = nuevoAjax();
	//ajax.open("GET", "index.php?m=mContenido2&c=mGdrEdtdts&dt="+dt+"&id="+id+"&dt2="+dt2+"&st="+st,true);
	ajax.open("GET", "index.php?m=mContenido2&c=mGdrEdtdts&dt="+dt+"&id="+id,true);
	
	ajax.onreadystatechange=function() {
 	if (ajax.readyState==4) {
		 //alert(ajax.responseText)			
		 if(ajax.responseText==1){
			  $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto ha sido actualizado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
				$('#cfn').dialog('close');
				r_filtro_xc('');
				r_filtro_xa('');
				r_filtro_xb('');	
				$('#dialog_ptse').dialog('close');
				
			 }
		else{
			 $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no ha sido actualizado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			}	 
   }
  }
 ajax.send(null);
}
//------------------------------------
function cambio2(){
	/*var id = $('#identrega').val();
	var st = $('#status').val();
	if(st==8){var dt = $('#fecha_arribo').val()+" "+$('#hi_dt').val()+":"+$('#mi_dt').val()+":00";}
	if(st==9){
		var dt  = $('#fecha_arribo2').val()+" "+$('#hi_dt2').val()+":"+$('#mi_dt2').val()+":00";
		var dt2 = $('#fecha_salida').val()+" "+$('#hi_dt3').val()+":"+$('#mi_dt3').val()+":00";
		}*/
	var id = $('#identrega').val();	
	var dt = $('#fecha_salida').val()+" "+$('#hi_dt3').val()+":"+$('#mi_dt3').val()+":00";
	var ajax = nuevoAjax();
	//ajax.open("GET", "index.php?m=mContenido2&c=mGdrEdtdts&dt="+dt+"&id="+id+"&dt2="+dt2+"&st="+st,true);
	ajax.open("GET", "index.php?m=mContenido2&c=mGdrEdtdts2&dt="+dt+"&id="+id,true);
	
	ajax.onreadystatechange=function() {
 	if (ajax.readyState==4) {
		 //alert(ajax.responseText)			
		 if(ajax.responseText==1){
			  $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto ha sido actualizado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
				$('#cfe').dialog('close');
				r_filtro_xc('');
				r_filtro_xa('');
				r_filtro_xb('');
				$('#dialog_ptse').dialog('close');
				
			 }
		else{
			 $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no ha sido actualizado correctamente.</p>');
				$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			}	 
   }
  }
 ajax.send(null);
}
//.......................................................................................//	
function klr(x){
	//alert(x)
	idp=x
	//alert (idp);
	cancelar(2);

	}
//---------------------------------------------------------------------------------------------
function borrarvje(){
	//alert($('#idd').val())
		$("#dialog-confirm").dialog({
			autoOpen:false,						
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Aceptar": function() {
				proceso_borrarvje($('#idd').val());
				},
				"Cancel": function() {
					$("#dialog-confirm").dialog( "close" );
				}
			}
		});
	//if(idp!=0){
        $('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Esta seguro de borrar el viaje?</p>');
		$("#dialog-confirm").dialog("open");
		//
		/*}
	else{ 
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un punto de la lista</p>');
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});		
}*/
	}	
//----------------------------------------------------------------------------------------------
function proceso_borrarvje(x){
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mBorrardsp&idd="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  if(result==0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Viaje eliminado correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$("#dialog_pts").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			init();
			//r_filtro_xc('');
			//r_filtro_xa('');
			//r_filtro_xb('');
			//g=$('#idd').val();
			//alert($('#idd').val());
			//mostrar_puntos(g);
			  
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El viaje no pudo ser eliminado</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				  
			 }
   }
  }
 ajax.send(null);	
	}
//----------------------------------------------------------------------------------------------
function reprogramar(x){
		$("#dialog-confirm").dialog({
			autoOpen:false,						
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Aceptar": function() {
				proceso_reprogramar(x);
				},
				"Cancel": function() {
					$("#dialog-confirm").dialog( "close" );
				}
			}
		});	

$('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Esta seguro de reprogramar el punto?</p>');
$("#dialog-confirm").dialog("open");
		//
				
	}
//---------------------------------------------------------------------------------
function proceso_reprogramar(x){	
 var ajax = nuevoAjax();
 ajax.open("GET", "index.php?m=mContenido2&c=mReprogramar&punto="+x,true);
 ajax.onreadystatechange=function() {
  	 if (ajax.readyState==4) {
		  result=ajax.responseText;
		  //alert(result)
		  if(result>0){
			  save=1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Punto reprogramado correctamente</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});
			r_filtro_xc('');
			r_filtro_xa('');
			r_filtro_xb('');			
			$('#dialog_ptse').dialog('close');
			//g=$('#idd').val();
			//alert($('#idd').val());
			//r_filtro_xb('');
			//if(o==1){
			//mostrar_puntos($('#idd').val());
			//}
			  }
		  else{
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El punto no pudo ser reprogramado</p>');
			$("#dialog-confirm").dialog("close");
			$( "#dialog-message" ).dialog({
			
			buttons: {
				Aceptar: function() {
					$("#dialog-message" ).dialog( "close" );
					//alert(save)
					if(save==1){r_filtro(); save=0;}
				}
			}
		});				  
			 }
   }
  }
 ajax.send(null);
 }	
  ///------------------------
 
 function r_filtro1(){
	var yy="";
	var filt = 0; 

	var date = $("#start-dates").val();
	if(date==''){
		date='undefined';
		}
	
	fecha=date;
	$('#tab_viaj').html('<tr style="cursor:pointer; " class="inf_viaj"><th rowspan="2" align="center"><div class="demo"><br/><br/><br/><br/>Cargando Datos<br/><div id="progressbar" style=" width:300px;" ></div></div></th></tr>');
		
		barra_progress();
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mContenido2&c=mViajeConst&date="+date,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
		//console.log(result);
				if(result != 0){
					
					$('#tab_viaj').find(".inf_viaj").remove();
					
					var div=result.split('?');
					
					
					
					
		var cadena ='<tr style="cursor:pointer; " class="inf_viaj">'+
 '<th width="15%" rowspan="2"   style="border:#FFFFFF solid 1px; bgcolor="#DBDBDB" id="des_cab_viaj" ></th>'+div[0]+
  '</tr><tr style="cursor:pointer;" class="inf_viaj">'+div[1]+'</tr>'+
  div[2];
					
					
					
					$(cadena).appendTo('#tab_viaj');
			
					//$(div[3]).appendTo('#des_cab_viaj');
				//	$('#list_form_vj').html(ajax.responseText);
					//tigra_tables('MyData', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
				}else{
					$('#list_form_vj').html("<br><br><br><br><center>La busqueda no obtuvo resultados</center>");
				}
			}			
		}		
	ajax.send(null);	
	

}
/////---------------------------------------------------------------------------------------------------

var tipo2=0;
function admap(tipo){	
	
	OpenLayers.Control.CustomNavToolbar = OpenLayers.Class(OpenLayers.Control.Panel, {
	
					
				    initialize: function(options) {
				        OpenLayers.Control.Panel.prototype.initialize.apply(this, [options]);
				        this.addControls([
				          new OpenLayers.Control.Navigation(),
						  //Here it come
				          new OpenLayers.Control.ZoomBox({alwaysZoom:true})
				        ]);
						// To make the custom navtoolbar use the regular navtoolbar style
						this.displayClass = 'olControlNavToolbar'
				    },
					
					
				
				   
				    draw: function() {
				        var div = OpenLayers.Control.Panel.prototype.draw.apply(this, arguments);
                        this.defaultControl = this.controls[0];
				        return div;
				    }
				});
	
	
			var layer_ms = new OpenLayers.Layer.MapServer("Vectorial", 
		"http://201.131.96.16/cgi-bin/mapserv", 	 {map: '/var/www/html/ssp/shapes/emapas.map'} , { numZoomLevels: 20 , minZoomLevel: 5 , maxZoomLevel:19}                                               //{ numZoomLevels: 30 , minZoomLevel: 9 , maxZoomLevel: 30} 
                                              );

 var ghyb = new OpenLayers.Layer.Google(
                "Google Hybrid",
                {type: G_HYBRID_MAP, minZoomLevel: 5, maxZoomLevel: 19, numZoomLevels: 20 }
            );

var mas= new OpenLayers.Layer.Google(
"Google Maps",{ minZoomLevel: 5, maxZoomLevel: 19, numZoomLevels: 20  } // the default
); 
var lonLat = new OpenLayers.LonLat(-101.62354,21.64307);
var zoom;
	
	
	if(tipo==1){
		map = new OpenLayers.Map('mapa', {
 				controls: [
 					
 				
				new OpenLayers.Control.PanPanel(),
               		 	
                                new OpenLayers.Control.LayerSwitcher({'ascending':false}),
                                new OpenLayers.Control.ScaleLine(),
                                new OpenLayers.Control.MousePosition(),
                      
				new OpenLayers.Control.ZoomPanel()
					
 				]
 				
 			});
		
			zoom=3;		
  			map.addLayers([mas,layer_ms,ghyb]);
			map.setCenter (lonLat, 0);
			var layer = new OpenLayers.Layer.Vector();
			
			var panel = new OpenLayers.Control.CustomNavToolbar();
			

				map.addControl(panel);
				
						   AutoSizeFramedCloud = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
            'autoSize': true
       		 });
		

		
		
		
		}else{
				if(tipo==0){
					if(tipo2==0){
					map2 = new OpenLayers.Map('tabs-04', {
 				controls: [
 					
 				
				new OpenLayers.Control.PanPanel(),
               		 	
                                new OpenLayers.Control.LayerSwitcher({'ascending':false}),
                                new OpenLayers.Control.ScaleLine(),
                                new OpenLayers.Control.MousePosition(),
                      
				new OpenLayers.Control.ZoomPanel()
					
 				]
 				
 			});
					
					zoom=3;		
  			map2.addLayers([mas,layer_ms,ghyb]);
			map2.setCenter (lonLat, 0);
			var layer = new OpenLayers.Layer.Vector();
			
			var panel = new OpenLayers.Control.CustomNavToolbar();
			

			map2.addControl(panel);
				
						   AutoSizeFramedCloud = OpenLayers.Class(OpenLayers.Popup.FramedCloud, {
            'autoSize': true
        });
		tipo2=1;
					
					}
					
					}
				}
		

 			
		

			
				renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
                renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
				
				layer_style = OpenLayers.Util.extend({}, OpenLayers.Feature.Vector.style['default']);
                 layer_style.fillOpacity = 0.2;
                layer_style.graphicOpacity = 1;
				
				latlngbounds=new OpenLayers.Bounds();
				
			
				
	
}

function onPopupClose(evt) {
            select.unselectAll();
        }
        function onFeatureSelect(event) {
            var feature = event.feature;
            // Since KML is user-generated, do naive protection against
            // Javascript.
            var content = "<h2>"+feature.attributes.name + "</h2>" + feature.attributes.description;
            if (content.search("<script") != -1) {
                content = "Content contained Javascript! Escaped content below.<br>" + content.replace(/</g, "&lt;");
            }
            popup = new OpenLayers.Popup.FramedCloud("chicken", 
                                     feature.geometry.getBounds().getCenterLonLat(),
                                     new OpenLayers.Size(100,100),
                                     content,
                                     null, true, onPopupClose);
            feature.popup = popup;
            map.addPopup(popup);
        }
        
		function onFeatureUnselect(event) {
            var feature = event.feature;
            if(feature.popup) {
                map.removePopup(feature.popup);
                feature.popup.destroy();
                delete feature.popup;
            }
		}
/////---------------------------------------------------------------------------------------------------
var flag_p=0;
function endload(){

	try{
	
		vectorLayer.removeFeatures(polygonFeature);
				

	 		 map2.removeLayer(vectorLayer);
			 
	   
	  		 vectorLayer=null;
				renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
                renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
				
				layer_style = OpenLayers.Util.extend({}, OpenLayers.Feature.Vector.style['default']);
                 layer_style.fillOpacity = 0.2;
                layer_style.graphicOpacity = 1;
	  vectorLayer = new OpenLayers.Layer.Vector("Linea", {style: layer_style,
                renderers: renderer
				
                        });
	  
	  map2.addLayers([vectorLayer]);
		
	points.splice(0,points.length);
		units2.splice(0,units2.length);
			
	}catch(e){
		
		vectorLayer=null;
			renderer = OpenLayers.Util.getParameters(window.location.href).renderer;
                renderer = (renderer) ? [renderer] : OpenLayers.Layer.Vector.prototype.renderers;
				
				layer_style = OpenLayers.Util.extend({}, OpenLayers.Feature.Vector.style['default']);
                 layer_style.fillOpacity = 0.2;
                layer_style.graphicOpacity = 1;
	  vectorLayer = new OpenLayers.Layer.Vector("Linea", {style: layer_style,
                renderers: renderer
                        });
	  
	  map2.addLayers([vectorLayer]);	
			
		}
		
		
/*if(flag_p==0){
document.getElementById('combo').innerHTML="Cargando...";
}*/
	
	var date = $("#start-dates").val();
	if(date==''){
		date='undefined';
		}
		var id=$("#selectunit").val();


	 var path = "index.php?m=mContenido2&c=mGetXML&day="+date+"&idunit="+id ;
	
$.getJSON(path,function(data) {
		
		$.each(data.items, function(i,item){
			
			var unitLatitude =  item.lat;
	        var unitLong  =  item.lon;
			//var point = new OpenLayers.Geometry.Point(item.lat,item.lon );	
			points.push(new OpenLayers.Geometry.Point(unitLong, unitLatitude));
		//	latlngbounds.extend(new OpenLayers.LonLat(item.unitLong, item.unitLatitude  ));
				   // points.push(point);
					
			var info2 = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+'<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
				  '<tr><td align="left">Fecha/Hora :</td><td align="left">'+ item.fecha	+'</td></tr>'+
				  '<tr><td align="left">Latitud	 :</td><td align="left">'+ item.lat+'</td></tr>'+  
				  '<tr><td align="left">Longitud :</td><td align="left">'+ item.lon	+'</td></tr>'+  
'</table>';

				
					  valid.push(item.unitd);
						units2.push(item.entity+'!'+item.dunit+'!'+item.lon+','+item.lat+'!'+item.ico+'!'+info2+'!'+item.angle);
						
						
						 
						
			
		});
		
		createVisits(id) ;
		var colortrue= "#F32424";
		style_blue = OpenLayers.Util.extend({}, layer_style);
            style_blue.strokeColor = colortrue;
            style_blue.fillColor = colortrue;
			style_blue.strokeOpacity= 0.3 ;
			
			style_blue.strokeWidth = 3;
		 polygonFeature = new OpenLayers.Feature.Vector(
                new OpenLayers.Geometry.LineString(points),null,style_blue);
            vectorLayer.addFeatures([polygonFeature]);
		});
			
		

	}
	
	
//--------------------------------------------------
//--------------------------------------------------
	var flag_p1=0;
	
	
	var tipo3=0;
function onload1(uno){
	
	if(uno==0){}else{
	
	try{
		
		units.splice(0,units.length);
		infos.splice(0,infos.length);
		iconos.splice(0,iconos.length);
		valid.splice(0,valid.length);
		
	
			
	}catch(e){
		
			
			
		}

//if(flag_p1==0){
document.getElementById('combo').innerHTML="Cargando...";
//}
	var colortrue= "#F32424";
	var dateq = $("#start-dates").val();
	if(dateq==''){
		dateq='undefined';
		}
	

	 var path = "index.php?m=mContenido2&c=mGetPoints&date="+dateq;
	

$.getJSON(path,function(data) {
		
		$.each(data.items, function(i,item){
			
			if(item.ident=='0'){
					var point = new OpenLayers.Geometry.Point(item.unitLong,item.unitLatitude );			
	
					 var divi=item.fecha;
					 var divi1=divi.split('!!');
					 var planeado=divi1[0].split(',');
					 var real=divi1[1].split(',');
					 
				var info = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Visita</th></tr>'+'<tr><td align="left">Cliente  	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Estatus       :</td><td align="left">'+ item.estatus	+'</td></tr>'+
				  '<tr><td align="left">Fecha Entrada	 :</td><td align="left">'+ planeado[0]	+'</td></tr>'+
				  '<tr><td align="left">Fecha Salida	 :</td><td align="left">'+ planeado[1]	+'</td></tr>'+
				  '<tr><td align="left">Fecha Arribo	 :</td><td align="left">'+ real[0]	+'</td></tr>'+
				  '<tr><td align="left">Fecha Fin	 :</td><td align="left">'+ real[1]	+'</td></tr>'+
				  '<tr><td align="left">Latitud	 :</td><td align="left">'+ item.unitLatitude+'</td></tr>'+  
				  '<tr><td align="left">Longitud :</td><td align="left">'+ item.unitLong	+'</td></tr>'+  
				  '</table>';
				 
				  var icon='';
				var nue=item.color.indexOf('/');
				 
				if(nue=='-1'){
					
					icon='public/images/BUTTON_'+item.color+'.png';
					}else{
						
						correcto=item.color.split('/');
						icon='public/images/BUTTON_'+correcto[0]+'-'+correcto[1]+'.png'
						}
				 infos.push(item.unitd+'!'+item.unitLong+','+item.unitLatitude+'!'+icon+'!'+info);
				 //iconos.push(icon);	
				
				}else{
					if(item.ident=='1'){
						
						var point = new OpenLayers.Geometry.Point(item.unitLong,item.unitLatitude );			
			
				  
					
					var info2 = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+'<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
				  '<tr><td align="left">Fecha/Hora :</td><td align="left">'+ item.fecha	+'</td></tr>'+
				  '<tr><td align="left">Latitud	 :</td><td align="left">'+ item.unitLatitude+'</td></tr>'+  
				  '<tr><td align="left">Longitud :</td><td align="left">'+ item.unitLong	+'</td></tr>'+  
'</table>';
						
					
					var validacion=cambiar(item.unitd);
					//alert(validacion);
					if(validacion){
						
						}else{
						icon_new='public/images/movila.png';
						
					 // points.push(point);	
					  valid.push(item.unitd);
						units.push(item.unitd+'!'+item.nomunid+'!'+item.unitLong+','+item.unitLatitude+'!'+icon_new+'!'+info2);
						
					iconos.push(icon_new);
				
					//infos.push(item.info2);
						}
					
					}
					}
	

					
		
			updateFields(item.unitLatitude, item.unitLong);
	    	});
		
			
		//if(flag_p1==0){
	
	
			var textselec=" <select name='selectunid' id='selectunit' style='width: 170px;' >"+
                    "<option value='0'>Seleccione una unidad</option>";
			for(i=0;i<units.length;i++){
				var estsel=units[i].split('!');
				textselec+="<option value='"+estsel[0]+"'>"+estsel[1]+"</option>";
				}
				textselec+="</select>";
				
				document.getElementById('combo').innerHTML=textselec;
				flag_p1=1;
		//}
		
  	});
	 
	 if(bandertime==0){
		 recarga();
		 bandertime=1;
		 }else{
			 clearInterval(temporizador);
			recarga();
			 }
		
		}

	}
	
	
	//--------------------------------------------------
//--------------------------------------------------
	
	var bandertime=0;
	var bandertime1=0;
	function cambiar(ide){  
 
	for (var x = 0; x < valid.length;x++) {  
	var entroCarga='';

	if(valid[x]==ide){ 
            entroCarga=true; 
			return entroCarga;
			break;
        } 
			
    } 
	
}  
	

	function updateFields(latInt, lonInt){
	var latInt = parseFloat(latInt);
	var lonInt = parseFloat(lonInt);
	
	$("#txt_lat").val(latInt.toFixed(6));
	$("#txt_lon").val(lonInt.toFixed(6));
	
	var point = new OpenLayers.Geometry.Point(lonInt,latInt);

	}

var temporizador;
var timer_nuw=0;
function recarga(){
		
		temporizador = setInterval(function(){
					recharging();
		
					timer_nuw=1;   },600000);
	
		
  

	}
	
	///////------------------------------------------------------------------------------------------------
	var temporizador1;
var timer_nuw1=0;
function recarga1(){
		
		temporizador1 = setInterval(function(){
					recharging1();
		
					timer_nuw1=1;   },30000);
	
		
  

	}
	
	
	
	
	
	var analiz=0;
		//////////////////////////////__-------------------------------------------------------------------------------------------------------
		
	function createUnits(ide) {
	
		
		try{
	
			 marker2.destroy();

	  	     marker2 ='';

			
	
	  	    marker2 = new OpenLayers.Layer.Markers( "Visitas" );
	

	   map2.addLayer(marker2);

	
			
	}catch(e){
				
			marker2 ='';
			
			
	
	  	    marker2 = new OpenLayers.Layer.Markers( "Visitas" );
		 

	  	 map2.addLayer(marker2);

		}
		
		var size = new OpenLayers.Size(32,35);
    	var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
		
		 for( i=0;i<infos.length;i++){
		   var id=infos[i].split('!');
		  if(ide==id[0]){
			
			    var icon = new OpenLayers.Icon(id[2],size,offset);
			  latlon=id[1].split(',');
			 
			 
			
						var texto=id[3];
					//	var lat_lon=new OpenLayers.LonLat(latlon[0],latlon[1]  );
			latlngbounds.extend(new OpenLayers.LonLat(latlon[0],latlon[1]  ));
		var longitud=latlon[0];
		var latitud=latlon[1];
		globo1(longitud,latitud,texto,icon);
			
			
 		
		
		  }
			
		  }
		  
		  //
	
     
		  
		  map2.setCenter(latlngbounds.getCenterLonLat(),map2.zoomToExtent(latlngbounds));
		}
		
			//var latlngbounds=new OpenLayers.Bounds();
		
		function createVisits(ide) {
	
		
	try{
	
		
			 marker1.destroy();

	  		 marker1 ='';
			
	
		    marker1 = new OpenLayers.Layer.Markers( "Unidad" );

	   map2.addLayer(marker1);
	  
	    latlngbounds='';
	  
	latlngbounds=new OpenLayers.Bounds();
	
			
	}catch(e){
				
		marker1 ='';
			
	
		 	marker1 = new OpenLayers.Layer.Markers( "Unidad" );

	 	 map2.addLayer(marker1);
			
			
		}

	
	
	
	

						
	 
	  	var size = new OpenLayers.Size(20,25);
    	var offset = new OpenLayers.Pixel(-(size.w/2), -size.h);
					  
	 	var icon1 = "public/images/iconos_autos/"; 
	  for( x=0;x<units2.length;x++){
		  var id1=units2[x].split('!');
		  if(ide==id1[0]){
			 
		if(x==units2.length-1){
		
	nuevo=id1[3].split('.');
	nuevo[0]+="_"+id1[5];
	icon_new=nuevo[0]+"."+nuevo[1];


	}else{
		icon_new="carold_"+id1[5]+".png";
		}
		
			 icon2=icon1+icon_new;
			    var icon = new OpenLayers.Icon(icon2,size,offset);
			  latlon=id1[2].split(',');
			
			var texto1=id1[4];
		//  var markerf1 = new OpenLayers.Marker(new OpenLayers.LonLat(latlon[0],latlon[1]),icon);		
			latlngbounds.extend(new OpenLayers.LonLat(latlon[0],latlon[1]  ));
				var longitud1=latlon[0];
				var latitud1=latlon[1];
		globo(longitud1,latitud1,texto1,icon);

			
			  
			  }
		  }
	 createUnits(ide);
	
	 
	 
	 
			}	
//////____________--------------------------------------------------------------------------------------
	function globo(longitud,latitud,texto,icon){
			 var markerf = new OpenLayers.Marker(new OpenLayers.LonLat(longitud,latitud),icon);
		markerf.events.register('click', markerf, function(evt) {
				
				var popup2 = new OpenLayers.Popup.FramedCloud(null,
                                       markerf.lonlat,
                                       null,
                                      texto,

 null,true,null);

                    map2.addPopup(popup2);
				
				 OpenLayers.Event.stop(evt); });
			marker1.addMarker(markerf);
			
			}
			
			function globo1(longitud,latitud,texto,icon){
			 var markerf = new OpenLayers.Marker(new OpenLayers.LonLat(longitud,latitud),icon);
		markerf.events.register('click', markerf, function(evt) {
				
				var popup2 = new OpenLayers.Popup.FramedCloud(null,
                                       markerf.lonlat,
                                       null,
                                      texto,

 null,true,null);

                    map2.addPopup(popup2);
				
				 OpenLayers.Event.stop(evt); });
			marker2.addMarker(markerf);
			
			}
//----------------------------------------------------------------------------------------------------------------------
function recharging() {
	
	onload1();
	var t=$("#selectunit").val();
		//endload(t);
	
	}
	function recharging1() {
	var t=$("#selectunit").val();
	createVisits(t);
	
	}
	
	var fecha='';
	///-------
	///-------
	function pestanaControl(p){
		//alert(p);
		switch(p)
{
case 1:
			document.getElementById('tabs-01').style.display = ''; 
			document.getElementById('pft').style.display='';
			document.getElementById('tabs-02').style.display = 'none';
			document.getElementById('tabs-03').style.display = 'none';
		/*	document.getElementById('tabs-04').style.display = 'none';*/
			document.getElementById('fec').style.display='';
			document.getElementById('comb').style.display='none';
			document.getElementById('comb2').style.display='none';
  r_filtro1();
break;
case 2:
			 document.getElementById('tabs-01').style.display = 'none'; 
		 	 document.getElementById('tabs-02').style.display = '';
	document.getElementById('tabs-03').style.display = 'none';
			 document.getElementById('pft').style.display='none';
 		/*	 document.getElementById('tabs-04').style.display = 'none';*/
 			 document.getElementById('fec').style.display='none';
			 document.getElementById('comb').style.display='none';
			 document.getElementById('comb2').style.display='none';
			 arrancador();
			
	break;
	case 3:
	 		 document.getElementById('tabs-01').style.display = 'none'; 
		 	 document.getElementById('tabs-02').style.display = 'none';
		 document.getElementById('tabs-03').style.display = '';
			 document.getElementById('pft').style.display='none';
 		/*	 document.getElementById('tabs-04').style.display = 'none';*/
 			 document.getElementById('fec').style.display='none';
			 document.getElementById('comb').style.display='none';
			 document.getElementById('comb2').style.display='none';
			 

  imagenes2();
  break;
  case 4:
document.getElementById('tabs-01').style.display = 'none'; 
/*document.getElementById('tabs-02').style.display = 'none';*/
document.getElementById('tabs-03').style.display = 'none';
/*document.getElementById('tabs-04').style.display = '';*/
document.getElementById('pft').style.display='';
document.getElementById('fec').style.display='';
document.getElementById('comb').style.display='';
document.getElementById('comb2').style.display='';

  	admap(0);
	onload1(1);
	cap_map_pan(1);
  break;
  
}
		
		}
		
		var omap=0;
		function cap_map_pan(x){
			omap=x;
			}
		
		function omap_opanel(){

			if(omap==0){
				r_filtro1();
				}else{
		
					endload();
					}
			}
			
			
			
	
			function onload(t,zet){
	
	var latlngbounds=new OpenLayers.Bounds();
	 try{
		points2.splice(0,points2.length);
		infos2.splice(0,infos2.length);
		iconos2.splice(0,iconos2.length);
		angles2.splice(0,angles2.length);
		vectorLayer.removeFeatures(polygonFeature);
				
			  vectorLayer.removeFeatures(pointFeature);
	 		 map.removeLayer(vectorLayer);
			 
	   
	  		 vectorLayer=null;
			
	  vectorLayer = new OpenLayers.Layer.Vector("Capas", {style: layer_style,
                renderers: renderer
				
                        });
	  
	  map.addLayers([vectorLayer]);
	
			
	}catch(e){
				
				vectorLayer=null;
	  vectorLayer = new OpenLayers.Layer.Vector("Capas", {style: layer_style,
                renderers: renderer
                        });
	  
	  map.addLayers([vectorLayer]);
			
			
			
		}
	
	
	
	 //if (GBrowserIsCompatible()) {
	
   
	// }
//	
yp=$("#idd").val();
var lalti='';
var lolng='';
	if(t==1){
		
		 	p=zet;
			n=p.split("¬");
			 lalti=n[1];
			 lolng=n[2];
		}else{
	
	
	 p=$("#punto").val();
			n=p.split("¬"); 
			 lalti=n[0];
			lolng= n[1];
			
		}
	var colortrue= "#F32424";
	 
	 var path = "index.php?m=mContenido2&c=mFollowEdts&ide="+yp;
	 

$.getJSON(path,function(data) {
		
		$.each(data.items, function(i,item){
	
			var point = new OpenLayers.Geometry.Point(item.unitLong,item.unitLatitude );			
			latlngbounds.extend(new OpenLayers.LonLat(item.unitLong, item.unitLatitude  ));
				    points2.push(point);		
					
		 var info = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+'<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_streetview();" class="thickbox popUp">Ver Street View</a></b><br></td></tr>'+'</table>';
		
		angles2.push(item.angle);
		iconos2.push(item.icono);
		infos2.push(item.info);
		
			updateFields(item.unitLatitude, item.unitLong);
	    	});
			style_blue = OpenLayers.Util.extend({}, layer_style);
            style_blue.strokeColor = colortrue;
            style_blue.fillColor = colortrue;
			style_blue.strokeOpacity= 0.3 ;
			
			style_blue.strokeWidth = 3;
		 polygonFeature = new OpenLayers.Feature.Vector(
                new OpenLayers.Geometry.LineString(points2),null,style_blue);
            vectorLayer.addFeatures([polygonFeature]);
			
		
		
		
			var pointr = new OpenLayers.Geometry.Point( lolng,lalti);
			var icon = "public/images/Sucursal.png";
			latlngbounds.extend(new OpenLayers.LonLat(lolng,lalti));

 			 iconos2.push(icon);	

			 points2.push(pointr);
			 
   

createUnits_maps();
		
	// muestra_todo();
	map.setCenter(latlngbounds.getCenterLonLat(),map.zoomToExtent(latlngbounds));
  	});
	 
	 
	

	}
	
	
	function mostrar_mapa(t,zet){

	var latlngbounds=new OpenLayers.Bounds();
	 try{
		points2.splice(0,points2.length);
		
		infos2.splice(0,infos2.length);
		iconos2.splice(0,iconos2.length);
		angles2.splice(0,angles2.length);
		vectorLayer.removeFeatures(polygonFeature);
				
			  vectorLayer.removeFeatures(pointFeature);
	 		 map.removeLayer(vectorLayer);
			 
	   
	  		 vectorLayer=null;
			
	  vectorLayer = new OpenLayers.Layer.Vector("Capas", {style: layer_style,
                renderers: renderer
				
                        });
	  
	  map.addLayers([vectorLayer]);
	
			
	}catch(e){
				
				vectorLayer=null;
	  vectorLayer = new OpenLayers.Layer.Vector("Capas", {style: layer_style,
                renderers: renderer
                        });
	  
	  map.addLayers([vectorLayer]);
			
			
			
		}
	
	
	
	 //if (GBrowserIsCompatible()) {
	
   
	// }
//	
yp=$("#idd").val();
var lalti='';
var lolng='';
	if(t==1){
		
		 	p=zet;
			n=p.split("¬");
			 lalti=n[1];
			 lolng=n[2];
		}else{
	
	
	 p=$("#punto").val();
			n=p.split("¬"); 
			 lalti=n[0];
			lolng= n[1];
			
		}
	var colortrue= "#F32424";
	 
	 var path = "index.php?m=mContenido&c=mFollowEdts&ide="+yp;
	 

$.getJSON(path,function(data) {
		
		$.each(data.items, function(i,item){
	
			var point = new OpenLayers.Geometry.Point(item.unitLong,item.unitLatitude );			
			latlngbounds.extend(new OpenLayers.LonLat(item.unitLong, item.unitLatitude  ));
				    points2.push(point);		
					
		 var info = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+'<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_streetview();" class="thickbox popUp">Ver Street View</a></b><br></td></tr>'+'</table>';
		
		angles2.push(item.angle);
		iconos2.push(item.icono);
		infos2.push(item.info);
		
			updateFields(item.unitLatitude, item.unitLong);
	    	});
			style_blue = OpenLayers.Util.extend({}, layer_style);
            style_blue.strokeColor = colortrue;
            style_blue.fillColor = colortrue;
			style_blue.strokeOpacity= 0.3 ;
			
			style_blue.strokeWidth = 3;
		 polygonFeature = new OpenLayers.Feature.Vector(
                new OpenLayers.Geometry.LineString(points2),null,style_blue);
            vectorLayer.addFeatures([polygonFeature]);
			
		
		
		
			var pointr = new OpenLayers.Geometry.Point( lolng,lalti);
			var icon = "public/images/Sucursal.png";
			latlngbounds.extend(new OpenLayers.LonLat(lolng,lalti));

 			 iconos2.push(icon);	

			 points2.push(pointr);
			 
   

		createUnits_maps();
		
	// muestra_todo();
	map.setCenter(latlngbounds.getCenterLonLat(),map.zoomToExtent(latlngbounds));
  	});
	 
	 
	

	}
	
	function createUnits_maps() {
	 
	 var icon = ""; 
	
          for( i=0;i<points2.length;i++){
		  

	style_blue = OpenLayers.Util.extend({}, layer_style);

	if(i==4){
		style_blue.pointRadius = 14;
	nuevo=iconos2[i].split('.');
	nuevo[0]+="_"+angles2[i];
	icon_new=nuevo[0]+"."+nuevo[1];
	icon="public/images/iconos_autos/"+icon_new;
	
	
	}else{
		if(i==5){
				style_blue.pointRadius = 14;
		icon_new=iconos2[i];
			icon=icon_new;
		}else{
	style_blue.pointRadius = 9;
	icon_new="carold_"+angles2[i]+".png";
	icon="public/images/iconos_autos/"+icon_new;
		}
		}

	
	
	
	
	
            
				
            style_blue.strokeLinecap = "butt";
			style_blue.externalGraphic= icon;
			
	
	
	style_blue.fontColor="#000000";
				style_blue.bgColor="#FFFFFF";
                    style_blue.fontSize= "12px";
                    style_blue.fontFamily= "Arial";
                    style_blue.fontWeight= "bold";
                    style_blue.labelAlign= "cm",
                    style_blue.labelXOffset= -3;
                    style_blue.labelYOffset= -18;
				    style_blue.hoverFillColor= "#FFFFFF";
       				  style_blue.hoverFillOpacity= 0.8;
			
		

               pointFeature = new OpenLayers.Feature.Vector(points2[i],null,style_blue);
 			vectorLayer.addFeatures([pointFeature]);
		

  
			
		  }
			}
			
			
			function onloadpan(){
	myPano = new GStreetviewPanorama(document.getElementById("pano"));
    GEvent.addListener(myPano, "error", handleNoFlash);	
	$("#pano").html("");		

	myPano.setLocationAndPOV(point_pan);
	var time = 5; //time in seconds
    var interval = time * 1000; 
	$(document).oneTime(interval, function(i) { no_street_view(); }, 0);		
}

function handleNoFlash(errorCode) {
	if (errorCode == 603) {
        alert("Error: Flash doesn't appear to be supported by your browser");
       return;
     }
} 

    function close_street(){	
	$("#pano").html("");

}
function no_street_view(){
	if($("#pano").html() == ""){
		$("#pano").html("<b>Street View no cuenta con una vista de este lugar.</b>");			
	}
}
//--------------------------------------------------------------------
function autocompletarcte(x){
	
	var cadena=document.getElementById("data_busc_rh").value;
	var textx=x;
	//alert(cadena);
	var prim=cadena.split('|');
	
	for(i=0;i<prim.length;i++){
		
		var seg=prim[i].split(',');
		
		
		
		var pos=seg[1].indexOf(textx);
		if(pos!=-1){
			//alert(seg[1]);
				$('#cte option[value="'+seg[0].toString()+'"]').attr("selected","selected");

			}
		
		}

	}
	
	 function abrir(){
		$( "#dialog" ).dialog('open');
	}
    function cerrar(){
		$( "#dialog" ).dialog('close');
	}	
	
	
	function change_tipo_geo(x){
		
		var resp=x;
		
		
		if(resp==1){
			$('#cte').css("display","");
			$('#cte_3').css("display","none");
			document.getElementById("cte").disabled=false;
			document.getElementById("cte_3").disabled=true;
			
			
			
			}else{
			
				$('#cte').css("display","none");
			$('#cte_3').css("display","");
			document.getElementById("cte").disabled=true;
			document.getElementById("cte_3").disabled=false;
			
			}
		
		}