
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
var listo=0;
var listo1=0;
var listo2=0;
var datse=new Array();

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
var n_icon=new Array();
var unidades_selectud='';
var unidades_lista='';
var vectorLayer=null;


var respuesta = new Array(8);
var n_icon=new Array();
var units = new Array();
var units_s = new Array();
var valid = new Array();
var infos = new Array();
var infos1 = new Array();
var iconos = new Array();
var iconos2 = new Array();
var type = new Array();
var type2 = new Array();
var type2_s = new Array();
var email = new Array();
var email2 = new Array();
var grup= new Array();
var list_u= new Array();
var list_un= new Array();
var list_u2=new Array();
var list_s=new Array();
var list_s2=new Array();
var list_sn=new Array();
respuesta[7]=' ';
var busk_nue1=new Array();
var busk_nue2=new Array();
var busk_nue3='';
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

function init(){
	r_filtro1();
	//admap();
	r_filtro5();
	r_filtro2();
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
function r_filtro1(){
	
	var ajax = nuevoAjax();
	//var url = "index.php?m=rRsalida&c=mGetReport";
		ajax.open("GET", "index.php?m=mAlertasM&c=mGetPoints",true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
			//alert(result);
				if(result != 0){
				var parametro=result.split('!');
				var sel=parametro[0].split('|');
				var objetos=parametro[1].split('|');
				///_________________________________objetos
				
				for(x=0;x<objetos.length;x++){
				
					iconos.push(objetos[x]);
				
				
				}
				
				///__________________________________select
				var cadselect1='';
				var cadselect2='</select>';
				var cadselectod='';
				var cadselect='<select onchange="chekar_selec(this.value)" id="alt_da"><option selected="selected" value="0">Tipo de Alerta</option>';
				
				for(i=0;i<sel.length;i++){
					
					divs=sel[i].split('{');
					cadselect1+= '<option value="'+divs[0]+'"  >'+divs[1]+'</option>';
					
					}
					cadselectod=cadselect+cadselect1+cadselect2;
					document.getElementById('selet').innerHTML=cadselectod;
				 	pestana1();
				
				
				}else{
					alert("Error! Informacion no encontrada");
				}
			}			
		}		
	ajax.send(null);	
	

}


function r_filtro3(){
	
	var ajax = nuevoAjax();
	
		ajax.open("GET", "index.php?m=mAlertasM&c=mGetPGeo",true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
				//alert(result);
						if(result != 0){
							var parametro=result.split('!');
							
							var cadselect1='';
							var cadselect2='</select>';
							var cadtodo='';
							unidades_selectud='';
							var cadselect='<select  style="width:305px;" onchange="cambiar_grup(this.value)"><option selected="selected" value="0">Todos</option>';
							
							for(i=0;i<parametro.length;i++){
					
									divs=parametro[i].split('|');
									cadtodo+= '<option value="'+divs[0]+'"  >'+divs[1]+'</option>';
								
								}
							unidades_selectud=cadselect+cadtodo+cadselect2;
							
						}
					}			
			}		
	ajax.send(null);
	
	}
	
function camb_grup(){}

function cambiar_grup(x){

	var divs="";
	//list_u=new Array();
		for(i=0;i<grup.length;i++){
			
			var parametro=grup[i].split("|");
	
			if(parametro[0]==x){
			
				var pos =list_u.indexOf(parametro[2]);
						if(pos!=-1){
					
				divs+='<tr id="'+parametro[2]+'"><td>'+parametro[3]+'</td><td><a href="#"  onclick="listar_objeto(\''+parametro[2]+'\',\''+parametro[3]+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
				}
			
				}else{
					if(x==0){
						var pos1 =list_u.indexOf(parametro[2]);
						if(pos1!=-1){
						divs+='<tr id="'+parametro[2]+'"><td>'+parametro[3]+'</td><td><a href="#"  onclick="listar_objeto(\''+parametro[2]+'\',\''+parametro[3]+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
							}
						}
					}
			
			}
			unidades_lista='<table id="unidad_l"  > '+divs+'</table>';
			$("#col_uni").find( "#unidad_l" ).remove();
			$( unidades_lista ).appendTo("#col_uni");
	}

function listar_objeto(s,y){
			
			list_sn.push(y);
			list_s.push(s);
			var pos =list_u.indexOf(s);
			list_un.splice( pos, 1 );
			list_u.splice( pos, 1 );
			list_u2.splice(pos,1);
			var divs='<tr id="'+s+'"><td><a href="#"  onclick="quitar_objeto(\''+s+'\',\''+y+'\')" ><img title="click" src="/Alertas/public/images/i_arrow.png" style=" height:12px; width:12px;"></a></td><td>'+y+'</td></tr>';
			list_s2.push(divs);
			$( divs ).appendTo("#col_sel_uni");
			$("#unidad_l").find( "#"+s ).remove();
	
	}
function quitar_objeto(s,y){
			
			list_un.push(y);
			list_u.push(s);
			var pos = list_s.indexOf( s );
				list_sn.splice( pos, 1 );
				list_s.splice( pos, 1 );
				list_s2.splice( pos, 1 );
			var divs='<tr id="'+s+'"><td>'+y+'</td><td><a href="#"  onclick="listar_objeto(\''+s+'\',\''+y+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
			list_u2.push(divs);
			$( divs ).appendTo("#unidad_l");
			$("#col_sel_uni").find( "#"+s ).remove();
	
	}

function r_filtro2(){
	var ajax = nuevoAjax();
	
		ajax.open("GET", "index.php?m=mAlertasM&c=mGetPunits",true);
		ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
				var result =ajax.responseText;
					//alert(result);
				if(result != 0){
				var parametro=result.split('!');
				
				unidades_lista="";
				var divs="";
				
					for(x=0;x<parametro.length;x++){
								grup.push(parametro[x]);
							var sel=parametro[x].split('|');
							list_u.push(sel[2]);
							list_un.push(sel[3]);
							var divs2='<tr id="'+sel[2]+'"><td>'+sel[3]+'</td><td><a href="#"  onclick="listar_objeto(\''+sel[2]+'\',\''+sel[3]+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
							list_u2.push(divs2);
							divs+='<tr id="'+sel[2]+'"><td>'+sel[3]+'</td><td><a href="#"  onclick="listar_objeto(\''+sel[2]+'\',\''+sel[3]+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
					
					}
				
				unidades_lista=divs;
						var but='<input type="button" style="position:absolute; right:10px;" class="b_op" value="Configurar" onclick="popup_conf()" />';
						$("#bu_conf").css('visibility', 'visible');		
						$("#bu_clear").css('visibility', 'visible');	
						$("#bu_guar").css('visibility', 'visible');	
							
						
					
				}
			}			
		}		
	ajax.send(null);
	r_filtro3();
	}
	///___________________________________________________________________________________
function clear_div(){
		if(units_s.length!=0 || list_u2.length!=0 ||email2.length!=0 ){
				listo=0;
				band_ed=0;
				valida_listo=0;
				listo2=0;
				nuve=new Array();
				email2=new Array();
				email=new Array();
				
				for(i=0;i<list_s.length;i++){
						
						var pos =list_u.indexOf( list_s[i]);
								if(pos==-1){
									list_u.push(list_s[i]);
									list_un.push(list_sn[i]);
									var divs='<tr id="'+list_s[i]+'"><td>'+list_sn[i]+'</td><td><a href="#"  onclick="listar_objeto(\''+list_s[i]+'\',\''+list_sn[i]+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
									list_u2.push(divs);
									}
					}
					
					for(o=0;o<list_u.length;o++){
			 			 var pos = list_s.indexOf( list_u[o] );
							list_sn.splice( pos, 1 );
							list_s.splice( pos, 1 );
							list_s2.splice( pos, 1 );
					}
				
					
					
				//list_u2=new Array();
				list_s2=new Array();
				for(o=0;o<=units_s.length;o++){
					//
							if(units_s[o]!=undefined){
							var pos = units.indexOf( units_s[o]);
								if(pos==-1){
								
									units.push( units_s[o]);
									type2.push(type2_s[o]);
									 var $gallery = $( "#"+units_s[o] );
			
									 $($gallery).animate({ height: "120px" });
									 $($gallery).find('.dragbox-content').css('visibility', 'visible');
									 $($gallery).find('#lupa').css('visibility', 'visible');
									  $($gallery).find('#etic').empty();
								
								}
							}
						
						}
					document.getElementById('column2').innerHTML="";
					units_s=new Array();
					type2_s=new Array();
				
						 var selet=$("#alt_da").val();
									if(selet==0){
											filtro_arras();
									}else{
										chekar_selec(selet);
													}
			
			}
		
		}
/*-----------------------------------    -------------------------------------------- */
var ides_f=new Array();
var ides_v=new Array();
	function pestana1(){
			
	
		var contador=0;
		var contador2=0;
		var contador3=12;
		var lista=new Array();
		var lista1='';
		var geo='';
		var colors='';
		var sl='';
		var listaf=' ';
		var ides=new Array();
		type=new Array();
		//alert(iconos[0]);
			for(i=0;i<iconos.length;i++){
				
				lista1=iconos[i].split('{');
				
				if(contador<12){
					
							if(lista1[0]=='1'){colors='ui-widget-header-a'; geo='1';}
							if(lista1[0]=='2'){colors='ui-widget-header-v'; geo='2';}
							if(lista1[0]=='3'){colors='ui-widget-header-b'; geo='3';}
							if(lista1[0]=='4'){colors='ui-widget-header-n'; geo='4';}
							
						sl='item'+lista1[1]+'_'+geo;
						ides_f.push(sl);
						ides_v.push(lista1[0]+'|'+lista1[3]+'|'+lista1[2]);
						ides.push(sl);
						
							lista.push('<div class="dragbox" style="position:relative;" name="tip" id="'+sl+'" >'+
							'<h5 class="'+colors+'" style="font-size:8px;">'+lista1[2]+'</h5>'+
							'<div id="etic" ></div>'+
			 				'<div class="dragbox-content" style="width:10%; height:10%;" >'+
             				'<img id="ico" src="'+lista1[8]+'" alt="The peaks of High Tatras" style="height:40%;" />'+
							'<input type="hidden" id="data_s" value="'+lista1[0]+'|'+lista1[3]+'|'+lista1[2]+'"  />'+
          					'</div>'+
							'<table border="0"><tr><td id="lupa"><a href="#" onclick="popup(\''+sl+'\',\''+lista1[2]+'\',\''+lista1[8]+'\',\''+lista1[3]+'\',\''+lista1[5]+'\')" title="Descripcion" class="ui-icon ui-icon-zoomin">View larger</a></td><td id="modf">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td> </td></tr></table>'+
       						'</div>');
								contador=contador+1;
							
								for(f=0;f<lista.length;f++){
										var pos = units.indexOf( ides[f]);
										if(pos==-1){
											units.push(ides[f]);
											}
									
									var pos1 = type2.indexOf( lista[f]);
										if(pos1==-1){
											type2.push(lista[f]);
											listaf=listaf+lista[f];
											}
											
									}
							if(lista.length==contador3){
								contador3=contador3+12;
								contador=0;
							
								
								
								type.push(listaf);
								listaf='';
								contador2=contador2+1;
								
								}else{
								
									if(i==iconos.length-1){
										contador=0;
										type.push(listaf);
										listaf='';
										contador2=contador2+1;
										}
									
									}
			
					}
		
					
			}
			var tablein='<table border="0" id="controls"><tr>';
			var tablefi='</tr></table>';
			var tableen=' ';
			var boton=' ';
			for(i=0;i<contador2;i++){
				if(boton==' '){
					boton='<td><a href="#" name="'+i+'" onclick="chekar(this.name)" ><img title="" src="/Alertas/public/images/ss.png" style=" width:15px;"></a><td>';
				}else{
					
					boton=boton+'<td>&nbsp;</td>'+'<td><a href="#" name="'+i+'" onclick="chekar(this.name)" ><img title="" src="/Alertas/public/images/ss.png" style=" width:15px;"></a><td>';
					}
						
				}
				tableen=tablein+boton+tablefi;
			$(tableen).appendTo("#onj");
			$(type[0]).appendTo("#column1");
			
			//$("#gallery").append(type[0]);
			//document.getElementById('gallery').innerHTML=;
	

	}
	
	/*----------------------------------- -------------------------------------------- */



////____________________________________________________--
var fict=new Array();
var fict1=new Array();
/*----------------------------------- -------------------------------------------- */
function popup_mod(id,desp,icon,val,def,type,opc){
		
		//alert(respuesta[7]);
		
		document.getElementById('dialog').innerHTML="";
		if(type=='BD'){
			
			
			busk_nue1=new Array();
			busk_nue2=new Array();
			busk_nue3='';
						var ajax = nuevoAjax();
					//var url = "index.php?m=rRsalida&c=mGetReport";
						ajax.open("GET", "index.php?m=mAlertasM&c=mNewQuery&q="+opc,true);
						ajax.onreadystatechange=function() {
						if (ajax.readyState==4) {
								var result =ajax.responseText;
								//alert(result);
								if(result != 0){
								cadena=result;
								var selts=cadena.split('?');
								busk_nue3=selts[1];
								//alert(selts[0]);
								var divse=selts[0].split('|');
								for(i=0;i<divse.length;i++){
									
									var nuev=divse[i].split(',');
									busk_nue1.push(nuev[0]);
									busk_nue2.push(nuev[1]);
									}
									var sda=id.split('_');
									var indo='';
									if(sda[1]=='1'){ indo='<tr><td align="center" colspan="2"><input type="button" class="ui-button" value="Agregar GeoPunto" title="GeoPunto" onclick="window.open(\'/index.php?m=geopuntos\')" style="width:auto;" /></td></tr>';}
									if(sda[1]=='2'){ indo='<tr><td align="center" colspan="2"><input type="button" class="ui-button" value="Agregar GeoCerca" title="Geocerca" onclick="window.open(\'/index.php?m=geocercas\')" style="width:auto;" /></td></tr>';}
									//if(sda[1]==3){ indo='<input type="button" class="b_op" value="Agregar" title="Unidades" onclick="window.open("/index.php?m=geopuntos&c=default")" style=" position:absolute; top:2px; z-index:1; left:1050px;"/>';}
									//if(sda[1]==4){ indo='<input type="button" class="b_op" value="Agregar" title="Aqui" onclick="window.open("/index.php?m=geopuntos&c=default")" style=" position:absolute; top:2px; z-index:1; left:1050px;"/>';}
									
									var dialogo_conf='<div id="accordion"><table border="0" >'+
								'<tr><td colspan="2"><input type="text" size="30" id="bup" title="Buscar" onkeyup="txts(this.value)" /><a href="#" onclick="" ><img title="Buscar" src="/Alertas/public/images/search.png" style=" width:18px;"></a></td></tr>'+
								'<tr><td colspan="2" height="20"><font color="#000000" face="Arial Black" size="2" >Seleccione una Opcion </font></td></tr>'+ 
								'<tr><td colspan="2"><select id="mod_va" style="width:280px;" ></select></td></tr>'+
								'</table></div>';	
								
								document.getElementById('dialog').innerHTML= dialogo_conf;
										
								$( "#dialog" ).dialog({
				width: 310,
			  modal: true,
			  buttons: {
				Ok: function() {
						
					var lista=$("#mod_va").val();
					
					var pos5 =fict.indexOf(id);
					if(pos5==-1){
						fict.push(id);
						fict1.push(lista);
					}else{
						fict.splice( pos5, 1 );
						fict1.splice( pos5, 1 );
						}
					
					var ne_s=id+'-'+lista+'-'+desp+'-'+val;
					var pos = n_icon.indexOf(id);
					if(pos==-1){
						n_icon.push(id);
						if(respuesta[7]==' '){
						respuesta[7]=ne_s;
						}else{
							respuesta[7]=respuesta[7]+'|'+ne_s;
							}
					}else{
						var nuew=respuesta[7].split('|');
							n_icon.splice( pos, 1 );
							n_icon.push(id);
							if(nuew.length!=0){
								respuesta[7]=' ';
								for(i=0;i<nuew.length;i++){
									var md=nuew[i].split('-');
									if(md[0]==id){
										if(respuesta[7]==' '){
										respuesta[7]= ne_s;
										}else{
											respuesta[7]=respuesta[7]+'|'+ne_s;
											}
											
										}else{
												if(respuesta[7]==' '){
													respuesta[7]= nuew[i];
												}else{
													respuesta[7]=respuesta[7]+'|'+nuew[i];
													}
											}
								}
							}else{
								respuesta[7]=ne_s;
								}
						}
					
					
						 $( this ).dialog( "close" );
						 
				},
				Cancelar: function(){
					 $( this ).dialog( "close" );
					}
			  },
			  create: function(event, ui) { 
			var widget = $(this).dialog("widget");
			$(".ui-dialog-titlebar-close span", widget).removeClass("ui-icon-closethick").addClass("ui-icon-minusthick");
		   }
			});
					if(band_ed==0){
					var pos7 =fict.indexOf(id);
					if(pos7==-1){
						ioption(0);
					}else{
						ioption(fict1[pos7]);
						}
						}else{
							var pos8 =units_s.indexOf(id);	
								if(pos8==-1){
									ioption(0);
								}else{
									ioption(nuve[pos8]);
								}
							
							
							
							}
								
								}

						}
						
						}
					ajax.send(null);
			}else{
				if(type=='OP'){
					var dat=opc.split(';');
					var cadena='';
					for(i=0;i<dat.length;i++){
						
						var dat1=dat[i].split('?');
						if(dat1[0]==1){
					cadena+='<option value="'+dat1[0]+'" selected="selected">'+dat1[1]+'</option>';
						}else{
							cadena+='<option value="'+dat1[0]+'">'+dat1[1]+'</option>';
							}
					
					}
					
					var dialogo_conf='<div id="accordion"><table border="0" ><tr><td colspan="2" height="20">'+
    				 '<font color="#000000" face="Arial Black" size="2" >Seleccione una Opcion </font></td></tr>'+ 
					'<tr><td>&nbsp;</td><td><select id="mod_va" >'+cadena+'</select></td></tr></table></div>';	
					
					document.getElementById('dialog').innerHTML= dialogo_conf;
					$( "#dialog" ).dialog({
				width: 310,
			  modal: true,
			  buttons: {
				Ok: function() {
					var lista=$("#mod_va").val();
					
				var ne_s=id+'-'+lista+'-'+desp+'-'+val;
					var pos = n_icon.indexOf(id);
					if(pos==-1){
						n_icon.push(id);
						if(respuesta[7]==' '){
						respuesta[7]=ne_s;
						}else{
							respuesta[7]=respuesta[7]+'|'+ne_s;
							}
					}else{
						var nuew=respuesta[7].split('|');
							n_icon.splice( pos, 1 );
							n_icon.push(id);
							if(nuew.length!=0){
								respuesta[7]=' ';
								for(i=0;i<nuew.length;i++){
									var md=nuew[i].split('-');
									if(md[0]==id){
										if(respuesta[7]==' '){
										respuesta[7]= ne_s;
										}else{
											respuesta[7]=respuesta[7]+'|'+ne_s;
											}
											
										}else{
												if(respuesta[7]==' '){
													respuesta[7]= nuew[i];
												}else{
													respuesta[7]=respuesta[7]+'|'+nuew[i];
													}
											}
								}
							}else{
								respuesta[7]=ne_s;
								}
						}
					
					
						 $( this ).dialog( "close" );
						 
				},
				Cancelar: function(){
					 $( this ).dialog( "close" );
					}
			  },
			  create: function(event, ui) { 
			var widget = $(this).dialog("widget");
			$(".ui-dialog-titlebar-close span", widget).removeClass("ui-icon-closethick").addClass("ui-icon-minusthick");
		   }
			});
					
					
					}
				}
	
	

		
	
	}


function chekar(x){
				
				
  				$("#column1").find(".dragbox").remove();
			$(type[x]).appendTo("#column1");
				
	}
	
function chekar_selec(x){
				document.getElementById('column1').innerHTML="";
			document.getElementById('onj').innerHTML="";
		if(x!=0){
		var separador='';
		var lista='';
		var listaf='';
		var colors='';
		var contador=0;
		var contador2=0;
		var contador3=12;
		type=new Array();
		for(i=0;i<units.length;i++){
			//alert(units[i]);
			separador=units[i].split('_');
			if(separador[1]==x){
			
								contador=contador+1;
						
							listaf=listaf+type2[i];
						
							if(contador==contador3){
							//	contador3=contador3+12;
								contador=0;
							
								
								
								type.push(listaf);
								listaf='';
								contador2=contador2+1;
								
								}else{
								
									
									
									}
							
								
							}
							if(i==units.length-1){
										contador=0;
										type.push(listaf);
										listaf='';
										contador2=contador2+1;
										}
				
			}
			var tablein='<table border="0" id="controls"><tr>';
			var tablefi='</tr></table>';
			var tableen=' ';
			var boton=' ';
			for(i=0;i<contador2;i++){
				if(boton==' '){
					boton='<td><a href="#" name="'+i+'" onclick="chekar(this.name)" ><img title="" src="/Alertas/public/images/ss.png" style=" width:15px;"></a><td>';
				}else{
					
					boton=boton+'<td>&nbsp;</td>'+'<td><a href="#" name="'+i+'" onclick="chekar(this.name)" ><img title="" src="/Alertas/public/images/ss.png" style=" width:15px;"></a><td>';
					}
						
				}
				tableen=tablein+boton+tablefi;
			
			$(tableen).appendTo("#onj");
			$(type[0]).appendTo("#column1");
		}else{
		filtro_arras();
		}
		
}
					


	
	function popup(id,desp,icon,val,def){
	
				document.getElementById('dialog').innerHTML='<table id="'+id+'" border="0" ><tr><td ALIGN="center"><font color="#000000" face="Arial Black" size="2" >'+desp+'</font></td></tr>'+
															'<tr><td ALIGN="center">'+val+'</td></tr>'+
															'<tr><td ALIGN="center"><img src="'+icon+'" alt="The peaks of High Tatras" width="96" height="92" /></td></tr>'+
															'<tr><td ALIGN="center">'+def+'</td></tr>'+
															'</table>';
				 $( "#dialog" ).dialog({
		
			  modal: true,
			  buttons: {
				Ok: function() {
				  $( this ).dialog( "close" );
				}
			  },
			  create: function(event, ui) { 
			var widget = $(this).dialog("widget");
			$(".ui-dialog-titlebar-close span", widget).removeClass("ui-icon-closethick").addClass("ui-icon-minusthick");
		   }
			});

		}
		
	function popup_conf(){	
	var dialogo_conf='';
	
	if(listo==0){
		var dialogo_conf='<div id="accordion"><table border="0" ><tr><td colspan="2" height="20">'+
    	 '<font color="#000000" face="Arial Black" size="2" >Datos </font></td><td>&nbsp;</td>'+ 
		 '<td height="20"><font color="#000000" face="Arial Black" size="2" >Unidades </font></td>'+
		 '</tr><tr ><td colspan="2" height="40" >'+
  		'<div style=" height:224px;">'+
            '<div id="sizer2" class="sizer" style="width:400px;" ><p>'+
			'<table><tr><td colspan="3"> Nombre de la Alerta </td><td></td></tr>'+
			'<tr><td><input type="text" id="id_nom" size="25" class="ui-autocomplete-input" /></td><td></td><td>&nbsp;&nbsp;</td><td></td></tr>'+
			'<tr><td><input type="checkbox"  class="ui-state-default ui-corner-all" id="activo" />Activar </td><td></td><td>&nbsp;&nbsp;</td><td rowspan="4"><div id="list_correo" style="width: 200px; height: 100px; overflow-x:hidden; overflow:auto;" ><table id="tab_og" border="0" ></table></div></td></tr>'+
			'<tr><td colspan="2"><div id="error_nombre"></div></td><td>&nbsp;&nbsp;</td></tr>'+
			'<tr><td colspan="3"> Asigne un correo </td></tr>'+
			'<tr><td><input type="text" id="id_correo" size="25" class="ui-autocomplete-input"  /></td><td><input type="button"  class="ui-state-default ui-corner-all" value="+" onclick="nuew_cor()" /> </td><td>&nbsp;&nbsp;</td></tr>'+
			'<tr><td colspan="2"><div id="correct"></div></td><td>&nbsp;&nbsp;</td></table></p></div><br/>'+
			 
        	'</div></td><td>&nbsp;</td>'+
			'<td rowspan="3" style="heigth:330px; "><div>'+
		     '<div id="sizer1" class="sizer" style="width:340px; heigth:310px; " ><p>'+
			 '<table><tr><td colspan="3"><div style=" position:relative; width:305px; heigth:10px;" id="nuw" class="styled-select">'+unidades_selectud+'</div></td></tr>'+
			 '<tr><td><input type="button" style="" id="bu_guar" class="ui-button" value="Asignar Todos"  onclick="enviar_todos()"/></td><td>&nbsp;&nbsp;</td><td><input type="button" style="" id="bu_guar" class="ui-button" value="Quitar Todos"  onclick="regresar_todos()"/></td></tr>'+
			 '<tr><td>Unidades Disponibles</td><td>&nbsp;&nbsp;</td><td>Unidades Asignadas</td></tr>'+
			 '<tr><td ><div id="col_uni" style="border-radius: 7px; background-color:white; overflow-x:hidden; overflow:auto; width:155px; color:black;  height:300px; position:absolute;" ><table id="unidad_l"  > </table></div></td>'+
			 '<td>&nbsp;&nbsp;</td><td><div style="border-radius: 7px; background-color:white; overflow-x:hidden; overflow:auto; width:155px; color:black;  height:300px; position:absolute;" ><table id="col_sel_uni" ></div></table></td></tr>'+
			 '</table>'+
			 '</p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><div id="error_unidades"></div><br /></div>'+
			'</div></td>'+
				
			'</tr><tr><td colspan="2" height="20">'+
			'<font color="#000000" face="Arial Black" size="2" >Dias y Horas </font></td><td>&nbsp;</td></tr>'+
			'<tr><td colspan="2" rowspan="2"><div>'+
			'<div id="sizer" class="sizer" style="width:400px;" ><p>'+
			'<table border="0"><tr><td >'+
            	'Seleccione los dias:<br />'+
                '<input type="checkbox" id="Lunes"  />Lunes<br />'+
                '<input type="checkbox" id="Martes"  />Martes<br />'+
                '<input type="checkbox" id="Miercoles"  />Miercoles<br />'+
                '<input type="checkbox" id="Jueves"  />Jueves<br />'+
                '<input type="checkbox" id="Viernes"  />Viernes<br />'+
                '<input type="checkbox" id="Sabado"  />Sabado<br />'+
                '<input type="checkbox" id="Domingo"  />Domingo'+
                '<br /></td><td>&nbsp;&nbsp;</td><td>'+
				'Rango Horario: <br /><br />'+
				'Hora Inicio: '+
				'<select id="hri" class="mcaja">'+
                   horas('n')+
                 '</select><span>&nbsp;&nbsp;&nbsp;</span>'+
                  '<select id="mni" class="mcaja">'+
                   minutos('n')+
				    
                  '</select> <br />  <br />'+
				  'Hora Fin: '+
				'<select id="hrf" class="mcaja">'+
                   horas('n')+
                 '</select><span>&nbsp;:&nbsp;</span>'+
                  '<select id="mnf" class="mcaja">'+
              
				  minutos('n')+
                  '</select>'+
				  
				  
				'</td></tr></table>'+
				'</p><div id="error_hrsds"></div><br />'+
             '</div>'+
			
	
	'</div></td><td>&nbsp;</td></tr><tr><td></td><td><div id="progressbar"></div></td><tr></table>'+
    '</div>';
		
	/*class="sizer"*/
		
	
	}else{
		dialogo_conf='<div id="accordion"><table border="0" ><tr><td colspan="2" height="20">'+
    	 '<font color="#000000" face="Arial Black" size="2" >Datos </font></td><td>&nbsp;</td>'+ 
		 '<td height="20"><font color="#000000" face="Arial Black" size="2" >Unidades </font></td>'+
		 '</tr><tr ><td colspan="2" height="40" >'+
  		'<div style=" height:224px;">'+
            '<div id="sizer2" class="sizer" style="width:400px;" ><p>'+
			'<table><tr><td colspan="3"> Nombre de la Alerta </td><td></td></tr>'+
			'<tr><td><input type="text" id="id_nom" size="25" class="ui-autocomplete-input" value="'+respuesta[0]+'" /></td><td></td><td>&nbsp;&nbsp;</td><td></td></tr>';
			if(respuesta[1]==1){
			dialogo_conf+='<tr><td><input type="checkbox"  class="ui-state-default ui-corner-all" id="activo" checked/>Activar </td><td></td><td>&nbsp;&nbsp;</td><td rowspan="4"><div id="list_correo" style="width: 200px; max-width: 208px; height: 100px; overflow-x:auto; overflow:auto;" >';
		
			}else{
			dialogo_conf+='<tr><td><input type="checkbox"  class="ui-state-default ui-corner-all" id="activo" />Activar </td><td></td><td>&nbsp;&nbsp;</td><td rowspan="4"><div id="list_correo" style="width: 200px; max-width: 208px; height: 100px; overflow-x:auto; overflow:auto;" >';
				
				}
			
				
				dialogo_conf+='<table id="tab_og" border="0" ></table></div></td></tr>';
			
		
			dialogo_conf+='<tr><td colspan="2"><div id="error_nombre"></div></td><td>&nbsp;&nbsp;</td></tr>'+
			'<tr><td colspan="3"> Asigne un correo </td></tr>'+
			'<tr><td><input type="text" id="id_correo" size="25" class="ui-autocomplete-input"  /></td><td><input type="button"  class="ui-state-default ui-corner-all" value="+" onclick="nuew_cor()" /> </td><td>&nbsp;&nbsp;</td></tr>'+
			'<tr><td colspan="2"><div id="correct"></div></td><td>&nbsp;&nbsp;</td></table></p></div><br/>'+
			 
        	'</div></td><td>&nbsp;</td>'+
			'<td rowspan="3" style="heigth:310px; "><div>'+
		     '<div id="sizer1" class="sizer" style="width:330px; heigth:310px; " ><p>'+
			 '<table><tr><td colspan="3"><div style=" position:relative; width:305px; heigth:10px;" id="nuw" class="styled-select">'+unidades_selectud+'</div></td></tr>'+
			  '<tr><td><input type="button" style="" id="bu_guar" class="ui-button" value="Asignar Todos"  onclick="enviar_todos()"/></td><td>&nbsp;&nbsp;</td><td><input type="button" style="" id="bu_guar" class="ui-button" value="Quitar Todos"  onclick="regresar_todos()"/></td></tr>'+
			 '<tr><td>Unidades Disponibles</td><td>&nbsp;&nbsp;</td><td>Unidades Asignadas</td></tr>'+
 			'<tr><td ><div id="col_uni" style="border-radius: 7px; background-color:white; overflow-x:hidden; overflow:auto; width:155px; color:black;  height:300px; position:absolute;" ><table id="unidad_l"  > </table></div></td>'+
			 '<td>&nbsp;&nbsp;</td><td><div style="border-radius: 7px; background-color:white; overflow-x:hidden; overflow:auto; width:155px; color:black;  height:300px; position:absolute;" ><table id="col_sel_uni" ></div></table></td></tr>'+
			 '</table>'+
			 '</p><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><div id="error_unidades"></div><br /></div>'+
			'</div></td>'+
				
			'</tr><tr><td colspan="2" height="20">'+
			'<font color="#000000" face="Arial Black" size="2" >Dias y Horas </font></td><td>&nbsp;</td></tr>'+
			'<tr><td colspan="2" rowspan="2"><div>'+
			'<div id="sizer" class="sizer" style="width:400px;" ><p>'+
			'<table border="0"><tr><td >'+
            	'Seleccione los dias:<br />';
				var srs=respuesta[3].split('|');
				
				if(srs[0]==1){
                dialogo_conf+='<input type="checkbox" id="Lunes" checked/>Lunes<br />';
				}else{
					dialogo_conf+='<input type="checkbox" id="Lunes"  />Lunes<br />';
					}
					if(srs[1]==1){
				  dialogo_conf+='<input type="checkbox" id="Martes" checked/>Martes<br />';
				}else{
					  dialogo_conf+='<input type="checkbox" id="Martes" />Martes<br />';
					}
					if(srs[2]==1){
				  dialogo_conf+='<input type="checkbox" id="Miercoles"  checked/>Miercoles<br />';
				}else{
					  dialogo_conf+='<input type="checkbox" id="Miercoles"  />Miercoles<br />';
					}
					if(srs[3]==1){
				  dialogo_conf+='<input type="checkbox" id="Jueves"  checked/>Jueves<br />';
				}else{
					  dialogo_conf+='<input type="checkbox" id="Jueves"  />Jueves<br />';
					}
					if(srs[4]==1){
				  dialogo_conf+='<input type="checkbox" id="Viernes"  checked/>Viernes<br />';
				}else{
					  dialogo_conf+='<input type="checkbox" id="Viernes"  />Viernes<br />';
					}
					if(srs[5]==1){
				  dialogo_conf+='<input type="checkbox" id="Sabado"  checked/>Sabado<br />';
				}else{
					  dialogo_conf+='<input type="checkbox" id="Sabado"  />Sabado<br />';
					}
					if(srs[6]==1){
				  dialogo_conf+='<input type="checkbox" id="Domingo"  checked/>Domingo';
				}else{
					  dialogo_conf+='<input type="checkbox" id="Domingo"  />Domingo';
					}
				
           		var ini=respuesta[4].split(':');
				
				var fini=respuesta[5].split(':')
           
                dialogo_conf+= '<br /></td><td>&nbsp;&nbsp;</td><td>'+
				'Rango Horario: <br /><br />'+
				'Hora Inicio: '+
				'<select id="hri" class="mcaja">'+
                   horas(ini[0])+
                 '</select><span>&nbsp;&nbsp;&nbsp;</span>'+
                  '<select id="mni" class="mcaja">'+
                   minutos(ini[1])+
				    
                  '</select> <br />  <br />'+
				  'Hora Fin: '+
				'<select id="hrf" class="mcaja">'+
                   horas(fini[0])+
                 '</select><span>&nbsp;:&nbsp;</span>'+
                  '<select id="mnf" class="mcaja">'+
              
				  minutos(fini[1])+
                  '</select>'+
				  
				  
				'</td></tr></table>'+
				'</p><div id="error_hrsds"></div><br />'+
             '</div>'+
			
	
	'</div></td><td>&nbsp;</td></tr><tr><td></td><td><div id="progressbar"></div></td><tr></table>'+
    '</div>';
		
		
		}
		document.getElementById('dialogo').innerHTML=dialogo_conf;
		//tigra_tables('unidad_l', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
		 $( "#dialogo" ).dialog({
   	 	width: 845,
      buttons: {
        Aceptar: function() {
   
  			 val_nombre();
			 
        },
		Cancelar: function() {
          $( this ).dialog( "close" );
  
        }
      }
    });
	
	if(listo==1){
	
		 if(email2.length!=0){
			 for(i=0;i<email2.length;i++){
					var dato=email2[i];
					$(dato).appendTo("#tab_og");
				 }
		 	}
		 
		  if(list_u2.length!=0){
			 for(i=0;i<list_u2.length;i++){
					var dato=list_u2[i];
					$(dato).appendTo("#unidad_l");
				 } 
			 }
			 if(list_s2.length!=0){
			 for(i=0;i<list_s2.length;i++){
					var dato=list_s2[i];
					$(dato).appendTo("#col_sel_uni");
				 } 
			 }
		}else{
			  if(list_u2.length!=0){
				 for(i=0;i<list_u2.length;i++){
						var dato=list_u2[i];
						$(dato).appendTo("#unidad_l");
					 } 
			 }
	
			}
		 
	}
	


/*--------__________________________________________________________*/
	function enviar_todos(){
			
			
			for(i=0;i<list_u.length;i++){
				var pos = list_s.indexOf(list_u[i]);
					if(pos==-1){
						list_s.push(list_u[i]);
						list_sn.push(list_un[i]);
						var divs='<tr id="'+list_u[i]+'"><td><a href="#"  onclick="quitar_objeto(\''+list_u[i]+'\',\''+list_un[i]+'\')" ><img title="click" src="/Alertas/public/images/i_arrow.png" style=" height:12px; width:12px;"></a></td><td>'+list_un[i]+'</td></tr>';
						list_s2.push(divs);
						$( divs ).appendTo("#col_sel_uni");
						$("#unidad_l").find( "#"+list_u[i] ).remove();
					}
				}
				for(o=0;o<list_s.length;o++){
					var pos =list_u.indexOf(list_s[o]);
					list_un.splice( pos, 1 );
					list_u.splice( pos, 1 );
					list_u2.splice(pos,1);
		
				}
		
		}
//_____________________________________________________________________________
	function regresar_todos(){
		
		for(i=0;i<list_s.length;i++){
				var pos = list_u.indexOf(list_s[i]);
					if(pos==-1){
						list_u.push(list_s[i]);
						list_un.push(list_sn[i]);
						var divs='<tr id="'+list_s[i]+'"><td>'+list_sn[i]+'</td><td><a href="#"  onclick="listar_objeto(\''+list_s[i]+'\',\''+list_sn[i]+'\')" ><img title="click" src="/Alertas/public/images/d_arrow.png" style=" height:12px; width:12px;"></a></td></tr>';
						list_u2.push(divs);
						$( divs ).appendTo("#unidad_l");
						$("#col_sel_uni").find( "#"+list_s[i] ).remove();
					}
				}
				for(o=0;o<list_u.length;o++){
					var pos =list_s.indexOf(list_u[o]);
					list_sn.splice( pos, 1 );
					list_s.splice( pos, 1 );
					list_s2.splice(pos,1);
		
				}
		
		
		}
	
	////____________________________________________________________________-


	
	
	function minutos(n){
		if(n=='n'){
		var val='';
		   for(i=0;i<60;i++){
			   if(i<=9){
			  val+='<option value="0'+i+'" >0'+i+'</option>';
			   }else{
				   val+='<option value="'+i+'" >'+i+'</option>';
				   }
			 
			   }
			     return val;
		}else{
			var val='';
		   for(i=0;i<60;i++){
		   
			   if(i<=9){
				   var nup='0'+i;
			  	if(nup==n){
			  val+='<option value="'+nup+'" selected="selected" >'+nup+'</option>';
				}else{
					 val+='<option value="'+nup+'" >'+nup+'</option>';
					}
				
			   }else{
				   if(i==n){
				   val+='<option value="'+i+'" selected="selected" >'+i+'</option>';
				   }else{
					    val+='<option value="'+i+'" >'+i+'</option>';
					   }
				   
				   }
			 
			   }
			     return val;
			
			}
		}
		
		var conten=0;
function nuew_cor(){
			var correo= $( "#id_correo" ).val();
			document.getElementById('correct').innerHTML="";
			var dato='';
			var vali= valEmail(correo);
			
			if(vali){
					if(exist_c(correo)){
						conten=conten+1;
						email.push(correo);
						dato='<tr id="tbd'+conten+'"><td>'+correo+'</td><td><a href="#" onclick="delet_corre(\'tbd'+conten+'\',\''+correo+'\')" ><img title="click" src="/Alertas/public/images/elimina.png"></a></td></tr>';
						email2.push(dato);
						$(dato).appendTo("#tab_og");
						}else{
							document.getElementById('correct').innerHTML='<font color="#990000" face="Comic Sans MS">* La dirección de email ya fue agregada</font>';
							$( "#id_correo" ).focus();
							 setTimeout("clears()", 4500);
							}
					
					
				}else{
					document.getElementById('correct').innerHTML='<font color="#990000" face="Comic Sans MS">* La dirección de email es incorrecta</font>';
					$( "#id_correo" ).focus();
					 setTimeout("clears()", 4500);
				}
			}
			
			function clears(){
				
				document.getElementById('correct').innerHTML="";
				
				}
				
				
function delet_corre(elim, corre){
			
		$("#tab_og").find( "#"+elim ).remove();
		var pos = email.indexOf( corre );
		email.splice( pos, 1 );
		email2.splice( pos, 1 );
		
	}
			
			function exist_c(fe){
				var luo=true;
				for(x=0;x<email.length;x++){
					if(fe==email[x]){
						luo=false;
						}
					}
					if(luo){
					return true;
					}else{
						return false;
						}
					
				}
			
function valEmail(valor){    // Cortesía de http://www.ejemplode.com    
 re=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/     
 if(!re.exec(valor))    {       
   return false;    
    }else{      
	   return true;   
	     } 
		 }


function horas(n){
		
		if(n=='n'){
			var val='';
		   for(i=0;i<24;i++){
		   
			   if(i<=9){
				   var nup='0'+i;
			  	
			  val+='<option value="'+nup+'"  >'+nup+'</option>';
			
				
			   }else{
				 
				   val+='<option value="'+i+'"  >'+i+'</option>';
				   
				   }
			 
			   }
			     return val;
		}else{
			var val='';
			for(i=0;i<24;i++){
		   
			   if(i<=9){
				   var nup='0'+i;
			  	if(nup==n){
			  val+='<option value="'+nup+'" selected="selected" >'+nup+'</option>';
				}else{
					 val+='<option value="'+nup+'" >'+nup+'</option>';
					}
				
			   }else{
				   if(i==n){
				   val+='<option value="'+i+'" selected="selected" >'+i+'</option>';
				   }else{
					    val+='<option value="'+i+'" >'+i+'</option>';
					   }
				   
				   }
			 
			   }
			     return val;
			
			}
				 
				 
				 
		}
/*-----------------------------------    -------------------------------------------- */
function filtro_arras(){
			document.getElementById('column1').innerHTML="";
			document.getElementById('onj').innerHTML="";
		var contador=0;
		var contador2=0;
		var contador3=12;
		var lista=new Array();
		var lista1='';
		var colors='';
		var sl='';
		var listaf=' ';
		var ides=new Array();
		type=new Array();
		//alert(iconos[0]);
			for(i=0;i<type2.length;i++){
				//alert(type2.length);
				
				if(contador<12){
					
							
								contador=contador+1;
						
						listaf=listaf+type2[i];
									
							if(contador==contador3){
							//	contador3=contador3+12;
								contador=0;
							
								
								
								type.push(listaf);
								listaf='';
								contador2=contador2+1;
								
								}else{
								
									if(i==type2.length-1){
										contador=0;
										type.push(listaf);
										listaf='';
										contador2=contador2+1;
										}
									
									}
			
					}
		
					
			}
			var tablein='<table border="0" id="controls"><tr>';
			var tablefi='</tr></table>';
			var tableen=' ';
			var boton=' ';
			for(i=0;i<contador2;i++){
				if(boton==' '){
					boton='<td><a href="#" name="'+i+'" onclick="chekar(this.name)" ><img title="" src="/Alertas/public/images/ss.png" style=" width:15px;"></a><td>';
				}else{
					
					boton=boton+'<td>&nbsp;</td>'+'<td><a href="#" name="'+i+'" onclick="chekar(this.name)" ><img title="" src="/Alertas/public/images/ss.png" style=" width:15px;"></a><td>';
					}
						
				}
				tableen=tablein+boton+tablefi;
			$(tableen).appendTo("#onj");
			$(type[0]).appendTo("#column1");
			
			//$("#gallery").append(type[0]);
			//document.getElementById('gallery').innerHTML=;
	
	}
	
	
/*-----------------------------------    -------------------------------------------- */

function val_nombre(){


	if(valida_listo==0){
	var data=0;
	var nombre=$("#id_nom").val();
						var ajax = nuevoAjax();
					//var url = "index.php?m=rRsalida&c=mGetReport";
						ajax.open("GET", "index.php?m=mAlertasM&c=mNewQuery2&q="+nombre,true);
						ajax.onreadystatechange=function() {
						if (ajax.readyState==4) {
								var result =ajax.responseText;
								
									data=result;
									datse.push(data);
								
								 
								}
								
								}
									ajax.send(null);
									 
									 
								barra_progress();
								setTimeout("validacion_general();", 4000);	
	}else{
		barra_progress();
								setTimeout("validacion_general();", 4000);	
		}
								
	}
	
	
	function barra_progress(){
		 
		$( "#progressbar" ).progressbar({
			value:10
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
                        }, 200);
              $( "#progressbar" ).removeClass();  }, 200);
				
				
		}	
		
	
	
function validacion_general(){
	
	var nombre=$("#id_nom").val();   ////-----

	var vali1=$("#activo").is(":checked");
	var aler_act=0;     ///------
	if(vali1==true){
		 aler_act=1;
		}
	var correos=email.length;	///---
	var vali2=$("#Lunes").is(":checked");
	var vali3=$("#Martes").is(":checked");
	var vali4=$("#Miercoles").is(":checked");
	var vali5=$("#Jueves").is(":checked");
	var vali6=$("#Viernes").is(":checked");
	var vali7=$("#Sabado").is(":checked");
	var vali8=$("#Domingo").is(":checked");
	var lun=0;var mar=0;var mier=0;var juev=0;var vier=0;var sab=0;var dom=0; ///---
	if(vali2==true){lun=1;}if(vali3==true){mar=1;}if(vali4==true){mier=1;}if(vali5==true){juev=1;}
	if(vali5==true){vier=1;}if(vali7==true){sab=1;}if(vali8==true){dom=1;}
	var fecha1=$("#hri").val();var fecha2=$("#mni").val();var fecha3=$("#hrf").val();var fecha4=$("#mnf").val();
	var fecha_i=fecha1+':'+fecha2;////------
	var fecha_f=fecha3+':'+fecha4;//////---------
	var unidades=list_s.length; ////-----
	var num1=0;var num2=0;var num3=0;var num4=0;
	var exist=datse.toString();
		datse=new Array();
	//document.getElementById('carg').innerHTML='';
	if(nombre!=''){
			
			if(exist==0 ){
				respuesta[0]=nombre;
				respuesta[1]=aler_act;
				num1=1;
		
			}else{
				document.getElementById('error_nombre').innerHTML='<font color="#990000" face="Comic Sans MS">* El nombre de la alerta ya existe</font>';
				setTimeout("document.getElementById('error_nombre').innerHTML='';", 6000);
				
				}
		}else{
			document.getElementById('error_nombre').innerHTML='<font color="#990000" face="Comic Sans MS">* No se a asignado un nombre a la alerta</font>';
			setTimeout("document.getElementById('error_nombre').innerHTML='';", 6000);
			
			}
			if(correos!=0){
				var cor=email.toString();
				cor= cor.replace(/,/g, '|');
				
				respuesta[2]=cor;
				num2=1;
			}else{
				document.getElementById('correct').innerHTML='<font color="#990000" face="Comic Sans MS">* No ha asignado un correo</font>';
				setTimeout("document.getElementById('correct').innerHTML='';", 6000);
				
				}
			
			if(lun!=0||mar!=0||mier!=0||juev!=0||vier!=0||sab!=0||dom!=0){
					respuesta[3]= lun+'|'+mar+'|'+mier+'|'+juev+'|'+vier+'|'+sab+'|'+dom;
					respuesta[4]= fecha_i;
					respuesta[5]= fecha_f;
					num3=1;
				}else{
						document.getElementById('error_hrsds').innerHTML='<font color="#990000" face="Comic Sans MS">* No se a seleccionado dias</font>';
						setTimeout("document.getElementById('error_hrsds').innerHTML='';", 6000);
						
				}
			if(unidades!=0){
				var cor=list_s.toString();
				cor= cor.replace(/,/g, '|');
				var co2=list_sn.toString();
				co2=co2.replace(/,/g, '|');
				respuesta[6]=cor;
				respuesta[8]=co2;
				
				num4=1;
			}else{
				document.getElementById('error_unidades').innerHTML='<font color="#990000" face="Comic Sans MS">* No has seleccionado unidades</font>';
				setTimeout("document.getElementById('error_unidades').innerHTML='';", 6000);
				
				}
	
		if( num1!=0 && num2!=0 && num3!=0 && num4!=0){
			listo=1;
			$( '#dialogo' ).dialog( "close" );
			//alert(respuesta.toString());
			}
		
	}
	var s_nw=new Array();
function guar_general(){
		
		if(listo!=0){
			 valida_puntos();
			 //alert('entra aqui');
			 //alert(listo+'-'+listo1);
			 if(listo1!=0){
				// alert('entra 2');
				 var arreglo=respuesta.toString();
				 		//alert(arreglo);
						if(listo2==0){
						var url="index.php?m=mAlertasM&c=mGetGuard&q="+arreglo;
						}else{
							var url="index.php?m=mAlertasM&c=mGetGuard2&q="+arreglo+"&d="+listo2;
							
							}
							document.getElementById('cvs').innerHTML='<tr><td align="center" ><font color="#000" face="Arial Black" size="2"  >Guardando...</font></td></tr>';
						var ajax = nuevoAjax();
					
						ajax.open("GET", url,true);
						ajax.onreadystatechange=function() {
						if (ajax.readyState==4) {
								var result =ajax.responseText;
								
								var alertk='';
								if(result==1){
									alertk='<table><tr><td align="center" >Alerta Guardada Satisfactoriamente</td></tr></table>';
									s_nw.push(result);
								}else{
									 alertk='<table><tr><td align="center" >No se a podido Guardar la alerta</td></tr></table>';
									s_nw.push(result);
									}
							
								document.getElementById('dialogo').innerHTML=alertk;
								
											 $( "#dialogo" ).dialog({
											width:200,
											buttons: {
										 
											Ok: function() {
											if(s_nw[0]==1){
												s_nw.splice(0,1);
												 respuesta = new Array(8);
												 respuesta[7]=' ';
												// alert(respuesta[7]);
												 n_icon=new Array();
												 units = new Array();
												 units_s = new Array();
												 valid = new Array();
												 infos = new Array();
												 infos1 = new Array();
												 iconos = new Array();
												 type = new Array();
												 type2 = new Array();
												 type2_s = new Array();
												 email = new Array();
												 email2 = new Array();
												 grup= new Array();
												 list_u= new Array();
												 list_u2=new Array();
												list_s=new Array();
												iconos2 = new Array();
												 list_s2=new Array();
												 nuve=new Array();
												  lista_edi=new Array();
												 ids_edi=new Array();
												 noms_edi=new Array();
												 band_ed=0;
												 listo=0;
												 listo1=0;
												 listo2=0;
												 valida_listo=0;
												 ides_f=new Array();
												 $("#bu_conf").css('visibility', 'hidden');		
												$("#bu_clear").css('visibility', 'hidden');	
												$("#bu_guar").css('visibility', 'hidden');
												document.getElementById('column1').innerHTML="";
												document.getElementById('column2').innerHTML="";
												document.getElementById('onj').innerHTML="";
										
													r_filtro1();
													
													r_filtro5();
													r_filtro2();
												}else{
													s_nw=new Array();
													}
											  $( this ).dialog( "close" );
									  
											}
										  }
										});
				
								 
								}
								
								}
									ajax.send(null);
				 }
			}else{
				var alertk='<table><tr><td align="center" >Verifique la Configuracion de Alerta</td></tr></table>';
				document.getElementById('dialogo').innerHTML=alertk;
		
		 $( "#dialogo" ).dialog({
   	 	width:200,
      	buttons: {
     
		Ok: function() {
          $( this ).dialog( "close" );
  
        }
      }
    });
				}
		
		
		
		}
/*-----------------------------------    -------------------------------------------- */
function valida_puntos(){
	var val_in=0;
	var vals_s=new Array();
	if(units_s.length!=0){
		if(respuesta[7]!=' '){
			
			var resp=respuesta[7].split('|');
		//	alert(resp.length+'=='+units_s.length);
		
			
			if(resp.length==units_s.length){
				listo1=1;
				}else{
					for(i=0;i<units_s.length;i++){
							var pos = n_icon.indexOf( units_s[i]);
								if(pos==-1){
									
									var le=$("#"+units_s[i]).find("#data_s").val();
									
									var sep=le.split('|');
										var alertk='<table><tr><td align="center" >Verifique la Configuracion de la Variable '+sep[2]+'</td></tr></table>';
										document.getElementById('dialogo').innerHTML=alertk;
										 $( "#dialogo" ).dialog({
												width:200,
												buttons: {
											 
												Ok: function() {
												  $( this ).dialog( "close" );
										  
												}
											  }
											});
									
									}
					
					}
						
					
					
					}
			
			}else{
				
						var alertk='<table><tr><td align="center" >Verifique la Configuracion de Variables de Alerta</td></tr></table>';
						document.getElementById('dialogo').innerHTML=alertk;
				
				 $( "#dialogo" ).dialog({
				width:200,
				buttons: {
			 
				Ok: function() {
				  $( this ).dialog( "close" );
		  
				}
			  }
			});
						
				}
			}else{
				
				
						var alertk='<table><tr><td align="center" >No a seleccionado variables de alerta</td></tr></table>';
						document.getElementById('dialogo').innerHTML=alertk;
				
				 $( "#dialogo" ).dialog({
				width:200,
				buttons: {
			 
				Ok: function() {
				  $( this ).dialog( "close" );
		  
				}
			  }
			});
						
				
				}
	}
/*-----------------------------------    -------------------------------------------- */
var lista_edi=new Array();
var ids_edi=new Array();
var noms_edi=new Array();
var var_val=new Array();
function r_filtro5(){
	document.getElementById('cvs').innerHTML='<tr><td align="center" ><font color="#000" face="Arial Black" size="2"  >Cargando...</font></td></tr>';
		var ajax = nuevoAjax();
					//var url = "index.php?m=rRsalida&c=mGetReport";
						ajax.open("GET", "index.php?m=mAlertasM&c=mGetraDat",true);
						ajax.onreadystatechange=function() {
						if (ajax.readyState==4) {
								var result =ajax.responseText;
								if(result != 0){
									
									var parametro=result.split('!');
									document.getElementById('cvs').innerHTML='';
									for(x=0;x<parametro.length;x++){
										//alert(parametro[x]);
										iconos2.push(parametro[x]);		
										var rompe=parametro[x].split(',');
										ids_edi.push(rompe[0]);
										noms_edi.push(rompe[1]);
										var_val.push(rompe[8]);
									
										var dibuja='<tr id="'+rompe[0]+'"><td ><div id="sizer2" class="sizer" style="width:95%;" ><table  border="0" style="width-min:230px">'+
												'<tr><td> Nombre: </td><td>&nbsp;</td><td ></td><td><a href="#" onclick="editar_todo(\''+rompe[0]+'\')" ><img title="Editar" src="/Alertas/public/images/Edit_icon.png" style="width:15px;"></a>&nbsp;<a href="#" onclick="elimina_edit(\''+rompe[0]+'\')" ><img title="Eliminar" src="/Alertas/public/images/elimina.png"></a></td></tr>'+
												'<tr><td colspan="4"><font color="#2f4f4f" face="Arial Black" size="1"  >'+rompe[1]+'</font></td></tr>'+
												'<tr><td colspan="4"><font color="#C0C0C0" face="Arial Black" size="1" >Creacion: '+rompe[11]+'</font></td></tr>'+
												'</table></br></div></td></tr>';
												lista_edi.push(dibuja);
										$(dibuja).appendTo("#cvs");							
									}
							
								}else{
									document.getElementById('cvs').innerHTML='<tr><td><div id="sizer2" class="sizer" style="width:95%;" >'+
																		'<table><tr><td> Este Usuario no tiene alertas</td><td></td></tr>'+
																			'</table></div></td></tr></br>';
								}
								}
								
								}
									ajax.send(null);
									 	
	

}

/*----------------------------------- -------------------------------------------- */
function elimina_edit(x){
								var alertk='<table><tr><td align="center" >¿Desea Eliminar la Alerta?</td></tr></table>';
									document.getElementById('dialog').innerHTML=alertk;
			$( "#dialog" ).dialog({
				width: 180,
			  modal: true,
			  buttons: {
				Aceptar: function() {
					var ajax = nuevoAjax();
					//var url = "index.php?m=rRsalida&c=mGetReport";
						ajax.open("GET", "index.php?m=mAlertasM&c=mDelDat&q="+x,true);
						ajax.onreadystatechange=function() {
						if (ajax.readyState==4) {
								var result =ajax.responseText;
									
									var alertk='<table><tr><td align="center" >'+result+'</td></tr></table>';
									document.getElementById('dialogo').innerHTML=alertk;
				
								 $( "#dialogo" ).dialog({
								width:200,
								buttons: {
			 
							Ok: function() {
								$("#cvs").find( "#"+x ).remove();
								var pos = ids_edi.indexOf( x );
								ids_edi.splice( pos, 1 );
				  				$( this ).dialog( "close" );
		  
										}
									  }
									});
									
									
									}
						}
									ajax.send(null);
									 $( this ).dialog( "close" );
				},
		Cancelar: function() {
          $( this ).dialog( "close" );
  
        }
      }
    });
		
		
		
		
		
	
	}
/*  +++++++++++++++++++++++++++++++++++++++++++ DANIEL ++++++++++++++++++++++++++++++++++++  */
var valida_listo=0;
var nuve=new Array();
var band_ed=0;
function editar_todo(dato){
	
	
	if(valida_listo==0){
		band_ed=1;
		$("#etiqueta").remove();
	var pos = ids_edi.indexOf( dato );
	//alert(iconos2[pos]);
	var esparce=iconos2[pos].split(',');
	listo2=esparce[0];
	respuesta[0]=esparce[1];
	respuesta[1]=esparce[2];
	var corr_ne=esparce[3].split('|');
	for(d=0;d<corr_ne.length;d++){
		email.push(corr_ne[d]);
		var dt='<tr id="tbd'+d+'"><td>'+corr_ne[d]+'</td><td><a href="#" onclick="delet_corre(\'tbd'+d+'\',\''+corr_ne[d]+'\')" ><img title="click" src="/Alertas/public/images/elimina.png"></a></td></tr>';
	email2.push(dt);
	}
	var nom_unid=esparce[9].split('|');
	var id_unids=esparce[7].split('|');
	for(f=0;f<id_unids.length;f++){
		list_s.push(id_unids[f]);
		list_sn.push(nom_unid[f]);
	var divs='<tr id="'+id_unids[f]+'"><td><a href="#"  onclick="quitar_objeto(\''+id_unids[f]+'\',\''+nom_unid[f]+'\')" ><img title="click" src="/Alertas/public/images/i_arrow.png" style=" height:12px; width:12px;"></a></td><td>'+nom_unid[f]+'</td></tr>';
			list_s2.push(divs);
			var posqs = list_u.indexOf( id_unids[f] );
			list_u.splice(posqs,1);
			list_u2.splice(posqs,1);
			list_un.splice(posqs,1);
	}
	
	respuesta[3]=esparce[4];
	respuesta[4]=esparce[5];
	respuesta[5]=esparce[6];
	
	var pdi=esparce[8].split(' and ');
	var cad_valir="";
	
	for(t=0;t<ides_f.length;t++){
			var exx=ides_v[t].split('|');
		
			for(p=0;p<pdi.length;p++){
				var pdi1=pdi[p].split(' = ');
			
				if(exx[1]==pdi1[0]){
				//	alert(pdi1[1]);
						nuve.push(pdi1[1]);
						units_s.push(ides_f[t]);
						
						var lad = units.indexOf( ides_f[t] );
						type2_s.push( type2[lad] );
						type2.splice( lad, 1 );
						units.splice( lad, 1 );
						 
						
							
				}
						/**/
				}
			}
	 filtro_arras();
						for(g=0;g<units_s.length;g++){
							
							$(type2_s[g]).appendTo("#column2");
							
							
							
							var nu=units_s[g].split('item');	
							var nu1=nu[1].split('_');	
						for(l=0;l<iconos.length;l++){
							var dat=iconos[l].split('{');
							if(nu1[0]==dat[1]){
								var $gallery = $( "#"+units_s[g] );
								$($gallery).animate({ height: "41px" });
			 					$($gallery).find('.dragbox-content').css('visibility', 'hidden');
			 					$($gallery).find('#lupa').css('visibility', 'hidden');
								var divsa ='<a href="#" onclick="popup_mod(\''+units_s[g]+'\',\''+dat[2]+'\',\''+dat[8]+'\',\''+dat[3]+'\',\''+dat[5]+'\',\''+dat[10]+'\',\''+dat[11]+'\')" title="View larger image" >Configurar</a>';
																
								$($gallery).find('#etic').empty();
								$($gallery).find('#etic').append(divsa);
									}
								}
							
							}	

					listo=1;
					valida_listo=1;
						}else{
							var alertk='<table><tr><td align="center" >Guarde o Cancele para poder Editar</td></tr></table>';
									document.getElementById('dialogo').innerHTML=alertk;
				
								 $( "#dialogo" ).dialog({
								width:200,
								buttons: {
			 
							Ok: function() {
								$("#cvs").find( "#"+x ).remove();
								var pos = ids_edi.indexOf( x );
								ids_edi.splice( pos, 1 );
				  				$( this ).dialog( "close" );
		  
										}
									  }
									});
							
							}
	
	
	
	
	}
//...........//
function txtls(x){
	if(x!=''){
document.getElementById('cvs').innerHTML='';

for(l=0;l<noms_edi.length;l++){
//alert(x+'-'+noms_edi[l]);	
var pos=noms_edi[l].indexOf(x);
//alert(pos);
if(pos!=-1){
	
	$(lista_edi[l]).appendTo("#cvs");		
	
	}
}
	
	}else{
		document.getElementById('cvs').innerHTML='';
		for(l=0;l<lista_edi.length;l++){
			$(lista_edi[l]).appendTo("#cvs");		
		}
		
		}
	
}

//...........//
function txts(x){

	if(x!=''){
		var conta=0;
		 var nwe=x.toString();
//document.getElementById('cvs').innerHTML='';

for(l=0;l<busk_nue2.length;l++){
//alert(busk_nue2[l]);	
var pos=busk_nue2[l].indexOf(nwe);

if(pos!=-1 && conta==0){
	
	ioption(busk_nue1[l]);
	//$(lista_edi[l]).appendTo("#cvs");		
	conta=1;
	}
}
	
	}else{
		ioption(0);
		/*
		document.getElementById('cvs').innerHTML='';
		for(l=0;l<lista_edi.length;l++){
			$(lista_edi[l]).appendTo("#cvs");		
		}
		
		*/
		}
	}
//...........//

function ioption(x){
		var sdta=x.length;
		var tds=nuve.toString();
		//alert(sdta);
		if(x==0){
			//$(busk_nue3).appendTo("#mod_va");
			
			document.getElementById('mod_va').innerHTML= busk_nue3;
			
			}else{
				document.getElementById('mod_va').innerHTML='';
				
			
			
				
						for(i=0;i<busk_nue1.length;i++){
							
									//alert(busk_nue1[x]);
									var seletsion='';
									if(x.toString()==busk_nue1[i].toString()){
										
											seletsion='<option value="'+busk_nue1[i]+'" selected="selected">'+busk_nue2[i]+'</option>';
						
						
										}else{
											seletsion='<option value="'+busk_nue1[i]+'">'+busk_nue2[i]+'</option>';
						
											}
										$(seletsion).appendTo("#mod_va");
									}
						
					
					
		
				
				}
		//mod_va
	
	}

 //...............................................................................//
 
//---------------------------------------------------------------------------------

 //---------------------------------------------------------------------------------
 
 //...............................................................................//
 
//........................................................................................// 


//........................................................................................//
//........................................................................................// 	

//........................................................................................// 

	
	//----------------------------------------------------
