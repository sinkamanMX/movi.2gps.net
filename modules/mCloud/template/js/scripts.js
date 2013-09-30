
/*------ DESARROLLO CLOUD PRIVADA -------*/
/*------ Desarrollador: Edgar Sanabria Paredes -------*/
/*------ Empresa: Air Logistics GPS -------*/
/*------ Fecha de Desarrollo: 20 Noviembre 2012 -------*/

var key_prin='';
var key_prin1='';
var cat = 0;
var valores = 0;
var valores2 = 0;
var borrar_parametros='';
var borrar_submenu = 0;
var borrar_menu = 0;


var Base64 = {

	// private property
	_keyStr : "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",

	// public method for encoding
	encode : function (input) {
		var output = "";
		var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
		var i = 0;

		input = Base64._utf8_encode(input);

		while (i < input.length) {

			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);

			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;

			if (isNaN(chr2)) {
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)) {
				enc4 = 64;
			}

			output = output +
			this._keyStr.charAt(enc1) + this._keyStr.charAt(enc2) +
			this._keyStr.charAt(enc3) + this._keyStr.charAt(enc4);

		}

		return output;
	},

	// public method for decoding
	decode : function (input) {
		var output = "";
		var chr1, chr2, chr3;
		var enc1, enc2, enc3, enc4;
		var i = 0;

		input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

		while (i < input.length) {

			enc1 = this._keyStr.indexOf(input.charAt(i++));
			enc2 = this._keyStr.indexOf(input.charAt(i++));
			enc3 = this._keyStr.indexOf(input.charAt(i++));
			enc4 = this._keyStr.indexOf(input.charAt(i++));

			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;

			output = output + String.fromCharCode(chr1);

			if (enc3 != 64) {
				output = output + String.fromCharCode(chr2);
			}
			if (enc4 != 64) {
				output = output + String.fromCharCode(chr3);
			}

		}

		output = Base64._utf8_decode(output);

		return output;

	},

	// private method for UTF-8 encoding
	_utf8_encode : function (string) {
		string = string.replace(/\r\n/g,"\n");
		var utftext = "";

		for (var n = 0; n < string.length; n++) {

			var c = string.charCodeAt(n);

			if (c < 128) {
				utftext += String.fromCharCode(c);
			}
			else if((c > 127) && (c < 2048)) {
				utftext += String.fromCharCode((c >> 6) | 192);
				utftext += String.fromCharCode((c & 63) | 128);
			}
			else {
				utftext += String.fromCharCode((c >> 12) | 224);
				utftext += String.fromCharCode(((c >> 6) & 63) | 128);
				utftext += String.fromCharCode((c & 63) | 128);
			}

		}

		return utftext;
	},

	// private method for UTF-8 decoding
	_utf8_decode : function (utftext) {
		var string = "";
		var i = 0;
		var c = c1 = c2 = 0;

		while ( i < utftext.length ) {

			c = utftext.charCodeAt(i);

			if (c < 128) {
				string += String.fromCharCode(c);
				i++;
			}
			else if((c > 191) && (c < 224)) {
				c2 = utftext.charCodeAt(i+1);
				string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
				i += 2;
			}
			else {
				c2 = utftext.charCodeAt(i+1);
				c3 = utftext.charCodeAt(i+2);
				string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
				i += 3;
			}

		}

		return string;
	}

}

/*----------------------------------- -------------------------------------------- */
function change_id(id){
	key_prin='';
	key_prin = id;
	//alert(ide);
}

function change_ide(id){
	key_prin1='';
	key_prin1 = id;

}

function change_m(m){
	valores = m;
	valores2 = 0;
	//alert(valores);
}

function change_n(n){
	valores2 = n;
	valores = 0;
	if(n==99){
	//	alert('busca usuarios para este submenu'+$("#id_menu").val());
		usuario_submenu($("#id_menu").val());
		usuario_submenu_comple($("#id_menu").val());
		 borrar_submenu = $("#id_menu").val();
         borrar_menu = 0;
	}else{
		 borrar_submenu = 0;
         borrar_menu = $("#id_menu").val();
	}
	//alert(valores2);
}

function change_del(v){
	
 borrar_parametros = v;	
// alert(borrar_parametros);
}


function change_idm(n){
$("#id_menu").val(n);
}


function init(){
	combo();
	//r_filtro1();
	/*//admap();
	r_filtro5();
	r_filtro2();*/
	//r_filtro3();

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



	var fecha='';
/*-----------------------------------    -------------------------------------------- */
function r_filtro1(catalogo){
	//alert('hola');
	if(catalogo != -1){
	cat = catalogo;
	$("#catalogos").val(catalogo);
	document.getElementById('browser').innerHTML='';
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mCloud&c=mGetStruct&catalogo="+catalogo,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
			//console.log(result);
	//	alert(result);
				if(result != 0 || result != ""){
								
							$(result).appendTo("#browser");
							$("#browser").treeview();
							
							contextenu(cat);
						
								
							
							}else{
					alert('No existe información');			
							}
			}			
		}		
	ajax.send(null);	
	
	}
}

function get_download(urls){
	
	var result=Base64.decode(urls);
	var gen=result.split('modules');
	var downs='/modules'+gen[1];
	window.open(downs,'_blank');
	//console.log(downs);
	
	}
	
	function convert(urls){
		var result=Base64.decode(urls);
		var gen=result.split('modules');
		var downs='/modules'+gen[1];
		return result;
		}

function contextenu(cat) {	
      	var arraydocs=new Array();
		var arraydevel=new Array();
		
		arraydocs.push('.vid', '.aud', '.doc','.xls','.ppt','.file','.pdf');
		arraydevel.push('.css','.php','.js','.htm','.dwt');
		
	$(".folder").contextMenu({
		menu: 'mycarp'
	},
	
	function(action) {
		
		if(key_prin1 != 0){
			
			switch(action){
				
				case "addfi":
					add_file(cat);
				 // muestra_editar_form(ide);
				break;
				case "addcar":
				//alert(' agregar elemento menu='+valores+', submenu='+valores2);
				nuwcarp(key_prin1,cat,valores,valores2); 
				 // muestra_editar_form(ide);
				break;
				case "renom":
				//alert(' agregar elemento menu='+valores+', submenu='+valores2);
					renombra(key_prin1,cat,valores,valores2);
				 // muestra_editar_form(ide);
				break;
				
				case "delete":
				var bora = borrar_menu+','+borrar_submenu;
				
			document.getElementById('dialog1').innerHTML="<p align='center'>Desea eliminar la Carpeta?</p>";		
				
			 $( "#dialog1" ).dialog({
					width: 200,
				 	 buttons: {
						Aceptar: function() {
   							elimina_fil(key_prin1,2,cat,bora);
			  				$( this ).dialog( "close" );
			 
       						 },
						Cancelar: function() {
          					$( this ).dialog( "close" );
  
							}
						  }
						});	
				break;
			}
			
	
		}
	});	



for(i=0;i<arraydocs.length;i++){
			
	    $(arraydocs[i]).contextMenu({
		menu: 'mydocs'
	},
	
	function(action) {
		
		if(key_prin != 0){
			
			switch(action){
				case "newcat":
				  $( "#dialog_nc" ).dialog( "open" );
				break;
				
				case "descar":
					get_download(key_prin);
				 // muestra_editar_form(ide);
				break;
				
				case "delete":
				
				document.getElementById('dialog1').innerHTML="<p align='center'>Desea eliminar el Archivo?</p>";		
				
			 $( "#dialog1" ).dialog({
					width: 200,
				 	 buttons: {
						Aceptar: function() {
   							elimina_fil(key_prin,1,cat,borrar_parametros);
			  				$( this ).dialog( "close" );
			 
       						 },
						Cancelar: function() {
          					$( this ).dialog( "close" );
  
							}
						  }
						});
				
				 	
				break;
			}
			
	
		}
	});		
			
			}
		
		for(i=0;i<arraydevel.length;i++){
			
			$(arraydevel[i]).contextMenu({
		menu: 'myfil'
	},
	
	function(action) {
		
		if(key_prin != 0){
			
			switch(action){
				case "edit":
				editphp(key_prin);
				 // muestra_editar_form(ide);
				break;
				
				case "descar":
				downphp(key_prin);
				 // muestra_editar_form(ide);
				break;
				
				case "delete":
				
				document.getElementById('dialog1').innerHTML="<p align='center'>Desea eliminar el Archivo?</p>";		
				
			 $( "#dialog1" ).dialog({
					width: 200,
				 	 buttons: {
						Aceptar: function() {
   							elimina_fil(key_prin,1,cat,borrar_parametros);
			  				$( this ).dialog( "close" );
			 
       						 },
						Cancelar: function() {
          					$( this ).dialog( "close" );
  
							}
						  }
						});
				
				 	
				break;
			}
			
	
		}
	});	
			
			}

	$(".imgs").contextMenu({
		menu: 'myimas'
	},
	
	function(action) {
		
		if(key_prin != 0){
			
			switch(action){
				case "vist":
					visualizar(key_prin);
				break;
				
				case "desca":
					get_download(key_prin);
				 // muestra_editar_form(ide);
				break;
				
				case "delete":
				
				document.getElementById('dialog1').innerHTML="<p align='center'>Desea eliminar la Imagen?</p>";		
				
			 $( "#dialog1" ).dialog({
					width: 200,
				 	 buttons: {
						Aceptar: function() {
   							elimina_fil(key_prin,1,cat,borrar_parametros);
			  				$( this ).dialog( "close" );
			 
       						 },
						Cancelar: function() {
          					$( this ).dialog( "close" );
  
							}
						  }
						});

				break;
			}
			
	
		}
	});	
			
			
	}		
	
	function hola(x){
		
		
		if(x==1){
			
			 $( "#dialog" ).dialog( "close" );
			 r_filtro1(cat);
			 document.getElementById('dialog2').innerHTML='<p align="center">El archivo se cargo Correctamente</p>';	
			  $( "#dialog2" ).dialog({
   	 	width: 200,
      buttons: {
        OK: function() {
  				
  			  $( this ).dialog( "close" );
			 
        }
      }
    });
			
			}else{
				
				$('<p align="center">¡No se subio el archivo!</p>').appendTo("#progress-label");
				}

		
		
		}
	
	
	function add_file(){
	
	  //	console.log("holaaaa");
/*		var dialogo_conf='<form action="index.php?m=mCloud&c=mGetSubir&url='+convert(key_prin1)+
		                  '" method="post" enctype="multipart/form-data" target="ifra"><input type="file" name="archivo" id="archivo"></input>'+
						  '<input type="submit" value="Subir Archivo" style="position:absolute; top:35px; left:170px;" onclick="carga()"></input><div id="progressbar"                           style="display:none; position:absolute; top:59px; left:2px; width:310px; "><div id="progress-label">Cargando...</div></div></form>';
*/

	var dialogo_conf='<form action="index.php?m=mCloud&c=mGetSubir&url='+convert(key_prin1)+'&id_menu='+$("#id_menu").val()+'" method="post" enctype="multipart/form-data" target="ifra">'+
				     '<input type="file" name="archivo" id="archivo"></input>'+
					 '</form>';

		document.getElementById('dialog').innerHTML=dialogo_conf;		
			
			
	  
			 $( "#dialog" ).dialog({
   	 	width: 400,height: 170,
      buttons: {
        Subir: function() {
   
  			 // $( this ).dialog( "close" );
			$("form").submit();
        },
		Cancelar: function() {
          $( this ).dialog( "close" );
  
        }
      }
    });
		
		}
		

function elimina_fil(x,t,cat,borrar_parametros){
	
	//alert(x+','+t+','+cat+','+borrar_parametros);
		var ulr=convert(x);
		
		var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mCloud&c=mGetDelet&ulr="+ulr+"&tipo="+t+'&where='+borrar_parametros,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
			console.log(result);
		//alert(result);
				if(result != 0){
					
					if(result!=2){	
								document.getElementById('dialog2').innerHTML='<p align="center">El archivo a sido eliminado</p>';	
					}else{
						document.getElementById('dialog2').innerHTML='<p align="center">La Carpeta fue Eliminada</p>';
						}
			
			}else{
							document.getElementById('dialog2').innerHTML='<p align="center">No se a podido eliminar el archivo</p>';	
				}
	  
			 $( "#dialog2" ).dialog({
   	 	width: 200,
      buttons: {
        OK: function() {
  				 r_filtro1(cat);
  			  $( this ).dialog( "close" );
			 
        }
      }
    });
				
			}			
		}		
	ajax.send(null);	
		
	
	}								
	
	function visualizar(uil){
			$("#coin-slider").find( "#ls" ).remove();
			$("#coin-slider").find( "#ps" ).remove();
			//$('#ls').empty();
			var urls=convert(uil);
			var div=urls.split('/');
			var div2=div[div.length-1].split('.');
			var dibuj='<img id="ls" src="'+urls+'" alt=""  style="width:90%; height:90%; " /></br><p id="ps" align="center" >'+div2[0]+'</p>';
			$(dibuj).appendTo("#coin-slider");
			$("#ps").addClass("nuets");
			//$('#coin-slider').coinslider({ width: 500,height:200 });
			 $( "#dialog3" ).dialog({
   	 	width: 650,
		position: { my: "center", at: "top", of: window },
      buttons: {
      
      }
    });
		
		
		}						

function editphp(urls){
	var result=Base64.decode(urls);
	var gen=result.split('modules');
	var downs=result;
	
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mCloud&c=mGetEdit&ulr="+downs,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				console.log(result);
				
							$(result).appendTo("#column2");
							
			}			
		}		
	ajax.send(null);

	}
	

	
	function nuwcarp(urls,catalogo,v1,v2){
	
	var result=Base64.decode(urls);
	var gen=result.split('modules');
	var downs=result;
	var noms='';
	
	document.getElementById('dialog4').innerHTML='<p align="center"><input type="text" size="20" class="caj_dia" id="nufol" placeholder="Nombre"></p>';
	
	$( "#dialog4" ).dialog({
   	 	width: 190,
		height:150,
      buttons: {
        Aceptar: function() {
  				
				noms=$('#nufol').val();
				var dir=downs+'/'+noms;
  					afir_carp(dir,catalogo,v1,v2);
			  
			  
			  $( this ).dialog( "close" );
			 
        },
		 Cancelar: function() {
  			
  			  $( this ).dialog( "close" );
			 
        }
      }
    });

		}

///-----------------------------------------
		
function afir_carp(noms,catalogo,v1,v2){

	var dir=noms;
	var cadenaz = v1+','+v2+','+$("#catalogos").val()+','+$("#nufol").val()+','+$("#id_menu").val();
	//alert(cadenaz+','+dir);
	var ajax = nuevoAjax();

		ajax.open("GET", "index.php?m=mCloud&c=mGetNewDir&ulr="+dir+"&cade="+cadenaz,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
				console.log(result);
				
				if(result != 0){
							document.getElementById('dialog2').innerHTML='<p align="center">Elemento creado correctamente</p>';
							document.getElementById('id_menu').value = result;	
					}else{
							document.getElementById('dialog2').innerHTML='<p align="center">No se a podido crear el elemento</p>';	
					}
	  
			 $( "#dialog2" ).dialog({
   	 			width: 200,
      			buttons: {
       				 OK: function() {
  						 r_filtro1(catalogo);
						// cadena_menu(catalogo)
  			 		 $( this ).dialog( "close" );
			 
					}
				  }
				});
				
			}			
		}		
	ajax.send(null);
			
			}
			
			
			
			function renombra(urls,cat,valores,valores2){
				
				var result=Base64.decode(urls);
				var gen=result.split('/');
				var viej=gen[gen.length-1].split('.');
				var downs=result;
				var noms='';
	
	document.getElementById('dialog4').innerHTML='<p align="center"><input type="text" size="20" class="caj_dia" id="refol" placeholder="Nuevo Nombre" value="'+viej[0]+'"></p>';
	
	$( "#dialog4" ).dialog({
   	 	width: 190,
		height:150,
      buttons: {
        Aceptar: function() {
  				
				noms=$('#refol').val();
				//var dir=downs+'/'+noms;
  					val_renom(downs,noms,cat,valores,valores2);
			  
			  
			  $( this ).dialog( "close" );
			 
        },
		 Cancelar: function() {
  			
  			  $( this ).dialog( "close" );
			 
        }
      }
    });

				
				
				}
			
function val_renom(noms,names,cat,valores,valores2){
				
		var dir=noms;
		var ajax = nuevoAjax();
	    var id_menu_submenu = $("#id_menu").val();		
				
        ajax.open("GET", "index.php?m=mCloud&c=mGetRenm&ulr="+dir+'&nuws='+names+'&id_menu='+id_menu_submenu+'&v1='+valores+'&v2='+valores2,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			var result =ajax.responseText;
			console.log(result);
			//alert(result);
		   			if(result != 0){
					 	document.getElementById('dialog2').innerHTML='<p align="center">La carpeta a cambiado de nombre</p>';		
					}else{
						 document.getElementById('dialog2').innerHTML='<p align="center">No se a podido cambiar el carpeta</p>';	
				  	}

					$( "#dialog2" ).dialog({
						width: 200,
						buttons: {
							 OK: function() {
									r_filtro1(cat);
									$( this ).dialog( "close" );
										}
								 }
						});
									
					}			
			}		
			ajax.send(null);
	
	}
	
	
	function guar_php(urls){
		
		var downs=urls;
/*	var gen=result.split('modules');
	var downs=result;*/
	var contenido=$("#aredit").val();
	
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mCloud&c=mGetGuard&ulr="+downs+'&conten='+contenido,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				console.log(result);
				
							$(result).appendTo("#column2");
							
			}			
		}		
	ajax.send(null);
		
		}
	
	
	
	
	
	function downphp(urls){
		
	var result=Base64.decode(urls);
	var gen=result.split('modules');
	var downs=result;
	
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mCloud&c=mGetEdit&ulr="+downs,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				console.log(result);
				
							$(result).appendTo("#column2");
							
			}			
		}		
	ajax.send(null);
		
		}

//--------------------------------------- funciones de catalogo

	function CrearCatalogo(){
	//	alert($('#des_catalogo').val());
	var descripcion = $('#des_catalogo').val();
	var clientes = $('#cliente').val();
	
	var ajax = nuevoAjax();
	
	ajax.open("GET", "index.php?m=mCloud&c=mCrearCatalogo&descripcion="+descripcion+"&cliente="+clientes,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				console.log(result);
				if(result>0){
					//alert(result+'terminado');
					 $("#dialog_nc").dialog("close");
					 combo();
				}
				
                
			}			
		}		
	ajax.send(null);

		}

//********************+

function combo(){
	var ajax = nuevoAjax();
	
	var htmlx = '&nbsp;&nbsp;&nbsp;&nbsp;Cat&aacute;logos<select class="selects1"><option >Cargando...</option></select>';
	var htmly = '&nbsp;&nbsp;&nbsp;&nbsp;Cat&aacute;logos<select class="selects1"><option >No hay Catálogos</option></select>';
	
	$("#catalogos-combo").html(htmlx);
	
	ajax.open("GET", "index.php?m=mCloud&c=CargaCombo",true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				  console.log(result);
				  if(result!=0){
					 $("#catalogos-combo").html(result);  
				  }else{
					  $("#catalogos-combo").html(htmly);  
				  }
				 
					//alert(result+'terminado');
			}			
		}		
	ajax.send(null);



}
function cadena_menu(catalogo){
	
	var ajax = nuevoAjax();
	ajax.open("GET", "index.php?m=mCloud&c=mCadenaMenu&catalogo="+catalogo,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				  console.log(result);
				  if(result!=0){
					 $("#id_menu").val(result);  
				  }else{
					 alert('Sin datos');
				  }
				 
					//alert(result+'terminado');
			}			
		}		
	ajax.send(null);
}

//----------------------

function usuario_submenu(id_submenu){
		var ajax = nuevoAjax();
 		
		var htlm =' Usuarios Asignados <select name="origen[]" id="origen" multiple="multiple" size="8" class="selects0">'+
                  '<option value="-1">Cargando Datos </option>'+
                  '</select>';
		var htlm2 ='Usuarios Asignados <select name="origen[]" id="origen" multiple="multiple" size="8" class="selects0">'+
                   '</select>';		  
				  
				  
		$("#conte_1").html(htlm); 
	ajax.open("GET", "index.php?m=mCloud&c=mUsuarioSubmenu&id_submenu="+id_submenu,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				  console.log(result);
				  if(result!=0){
					 $("#conte_1").html(result);  
				  }else{
					 $("#conte_1").html(htlm2);  
				  }
				 
					//alert(result+'terminado');
			}			
		}		
	ajax.send(null);
	
}

//----------------------------

function usuario_submenu_comple(id_submenu){
		var ajax = nuevoAjax();
 		
		var htlm =' Usuarios Disponibles <select name="destino[]" id="destino" multiple="multiple" size="8" class="selects0">'+
                  '<option value="-1">Cargando Datos </option>'+
                  '</select>';
		var htlm2 ='  Usuarios Disponibles <select name="destino[]" id="destino" multiple="multiple" size="8" class="selects0">'+
                   '</select>';		  
				  
				  
		$("#conte_2").html(htlm); 
	ajax.open("GET", "index.php?m=mCloud&c=mUsuarioSubmenuComple&id_submenu="+id_submenu,true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				  console.log(result);
				  if(result!=0){
					 $("#conte_2").html(result);  
				  }else{
					 $("#conte_2").html(htlm2);  
				  }
				 
					//alert(result+'terminado');
			}			
		}		
	ajax.send(null);
}

function recorre_select(){
	var todos = '';
  $("#origen option").each(function(){
	if(todos == ''){
		todos = $(this).attr('value');
	}else{
		todos = todos+','+$(this).attr('value');
	}
   
  });
  todos = todos +'|'+ $("#id_menu").val();
  
  var ajax = nuevoAjax();
  
  if($("#origen option").length > 0){
	  //actualiza
	  ajax.open("GET", "index.php?m=mCloud&c=mActualizaBase&datos="+todos,true);
  }else{
	  // borra todo
	  var id_submenu = $("#id_menu").val();
	  ajax.open("GET", "index.php?m=mCloud&c=mBorraTodoBase&id_submenu="+id_submenu,true);
  }
  
  	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				  console.log(result);
				  if(result!=0){
					 alert('cambios realizados');
				  }else{
					 alert('falla al realizar cambios');  
				  }
				 
					//alert(result+'terminado');
			}			
		}		
	ajax.send(null);
  //alert(todos+'|'+ $("#origen option").length);	
}