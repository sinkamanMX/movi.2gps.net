var oTable;
var oTable2;
var gral_data;
var deta_data;
var map_rhi;
var points = [];
var poly = [];
var marcadores = [];
var info_a = new Array();
var lats = new Array();
var lons = new Array();
var trayecto;
var infowindow;

$(document).ready(function () {
	rhi_load_datatable();	
	//datepicker
	$( ".datepicker" ).datepicker({
		showOn: "button",
		buttonImage: "public/images/cal.gif",
		buttonImageOnly: true,
		maxDate: '0',
		dateFormat: "yy-mm-dd"
	});	

	$( "#rhi_add" ).button({
      icons: {
        primary: "ui-icon-search"
      }
    });

	$('.titulo').panel({
		'controls':$('#cntrl').html(),
		'collapsible':false
	});	

	//Dialog detalle	
	$( "#rhi_dialog" ).dialog({
		autoOpen:false,
		title:"Detalle",
		modal: true,
		width:  700,
		height: 450 
	});	

	//Dialog buscador
	$( "#rhi_dialog_nvo" ).dialog({
		autoOpen:false,
		title:"Buscar",
		modal: true,
		buttons: {
			Cancelar: function() {
				$("#rhi_dialog_nvo" ).dialog( "close" );
			},
			Buscar: function() {
				revisadatos();
			}			
		}
	});

	$( "#rhi_dialog_message" ).dialog({
		autoOpen:false,
		modal: false,
		buttons: {
			Aceptar: function() {
				$("#rhi_dialog_message" ).dialog( "close" );
			}
		}
	});

	$( "#rhi_exp_exe" ).button({
      icons: {
        primary: "ui-icon-document"
      }
	});	
}); 

function rhi_load_datatable(){
    oTable = $('#rhi_table').dataTable({
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": false,
      "bFilter": true,
      "bSort": false,
      "bJQueryUI": true,
      "iDisplayLength": 20,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "aoColumns": [
		  { "mData": " ", sDefaultContent: "" },
		  { "mData": "Fecha", sDefaultContent: "" },
		  { "mData": "Unidad", sDefaultContent: "" },
		  { "mData": "Total de Paradas", sDefaultContent: "" },
		  { "mData": "Paradas autorizadas", sDefaultContent: "" },
		  { "mData": "Paradas no autorizadas", sDefaultContent: "" },
		  { "mData": "Tiempo en movimiento", sDefaultContent: "" },
		  { "mData": "Tiempo detenido autorizado", sDefaultContent: "" },
		  { "mData": "Tiempo detenido no autorizado", sDefaultContent: "" },
		  { "mData": "Velocidad Maxima", sDefaultContent: "" },
		  { "mData": "Total de excesos", sDefaultContent: "" },
		  { "mData": "Kilómetros recorridos", sDefaultContent: "" }
      ] , 
        "oLanguage": {
          "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
          "sEmptyTable": "No hay registros.",
          "sInfoEmpty" : "No hay registros.",
          "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
          "sLoadingRecords": "Leyendo información",
          "sProcessing": "Procesando",
          "sSearch": "Buscar:",
          "sZeroRecords": "No hay registros",
      }
    });
}

function rhi_buscar(){
	$.ajax({
	  url: "index.php?m=rHistorico&c=mBuscadorRhi",
	  type: "GET",
	  data: {  },
	  success: function(data) {
		var result = data; 
		$('#rhi_dialog_nvo').html('');
		$('#rhi_dialog_nvo').html(result); 
		$('#rhi_dialog_nvo').dialog('open');
	  }
	});	
}  

function valida_rango(){
	var radio  =	document.getElementById("rd1").checked;
	var radio2 =	document.getElementById("rd2").checked;
	
	if(radio == true){
		$('#start_date').datepicker('enable');			
		$('#end_date').datepicker('enable');
		$('#hri').attr('disabled',false);
		$('#mni').attr('disabled',false);
		$('#hrf').attr('disabled',false);
		$('#mnf').attr('disabled',false);
		$('#cbo_sem').attr('disabled',true);								
	}else if(radio2 == true){
		$('#start_date').val('');		
		$('#start_date').datepicker('disable');
		$('#end_date').val('');			
		$('#end_date').datepicker('disable');
		$("#hri option[value='00']").attr("selected",true);
		$("#mni option[value='00']" ).attr("selected",true);
		$("#hrf option[value='00']").attr("selected",true);
		$("#mnf option[value='00']" ).attr("selected",true);				
		$('#hri').attr('disabled',true);
		$('#mni').attr('disabled',true);
		$('#hrf').attr('disabled',true);
		$('#mnf').attr('disabled',true);
		$('#cbo_sem').attr('disabled',false);
	}
}	

function damegrupo(){
	$.ajax({
	  url: "index.php?m=rHistorico&c=mGrupo",
	  type: "GET",
	  data: {},
	  success: function(data) {
	    var result = data; 
	    if(result!=0){
			$('#grupos').html(result);
		}else{
			$('#grupos').html(' <select id="selgrupo" style="width:100%" class="caja">'+
			                  ' <option value="0">No hay Grupos Disponibles</option>'+
							  '</select>');
		}	
	  }
	});	
}

function dameunidad(x){
	grupo = $('#selgrupo').val();
	$.ajax({
		url: "index.php?m=rHistorico&c=mUnidad",
		type: "GET",
		data: {gpo : grupo},
		success: function(data) {
			var result = data; 
			if(result!=0){
				$('#unidades').html(result);
			}else{
				$('#unidades').html('<select name="selunidad" id="selunidad" style="width:100%" class="caja">'+
			                      '<option value="0">No hay unidades disponibles</option>'+
			    				  '</select>');
			}	
		}
	});
}

function revisadatos(){
	var radio  =	document.getElementById("rd1").checked;
	var radio2 =	document.getElementById("rd2").checked;
	var ifs=0;
	if(radio == true){
		if($('#start_date').val().length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha inicial</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
			}
		if($('#end_date').val().length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha final</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
			}
		if($("#end_date").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00" < $("#start_date").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00"){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La fecha final debe ser mayor a la fecha inicial</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
			}			
		if($('#selunidad').val()==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
			}
		if($('#velocity').val().length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una velocidad maxima</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
			}			
	}
	
	if(radio2 == true){
		if($('#selunidad').val()==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
			}	
		if($('#velocity').val().length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una velocidad maxima</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	}

	if(ifs==0){
		getInfo();
	}
}

function getInfo(){
	$("#rhi_table tbody tr").each(function(index, element) {
	    $(this).remove();
	});

	var s='';	
	if($('#selunidad').val()== -1){
		$('#selunidad option').each(function(i) {
			if(s==''){
				if($(this).val()!= -1 && $(this).val()!= 0){
					s=$(this).val();
				}
			}else{
				if($(this).val()!= -1 && $(this).val()!= 0){
					s+=','+$(this).val();
				}
			}
		});
		var units	=	s;
	}else{				 
		var units	=	$("#selunidad").val();	
	}

	var radio  =	document.getElementById("rd1").checked;
	var radio2 =	document.getElementById("rd2").checked;
	var fc_ini =	$("#start_date").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00";
	var fc_fin =	$("#end_date").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00";

	var fech   =	$('#cbo_sem').val();
	var tfilt  =0;
	var rdo = $('#cbo_radio').val()/1000;
	var vel = $('#velocity').val();
	
	if(radio == true){
		tipo = 0;
	}else if(radio2 == true){
		tipo = 1;
	}

	$.ajax({
		url : "index.php?m=rHistorico&c=mGet_Report",
		type: 'GET',
		data: {
			  tag  : "getData",
			  tipo : 	tipo,
			  fInicio : fc_ini,
			  fFin : 	fc_fin,
			  unidad : 	units,
			  semana : 	fech,
			  radio : 	rdo,
			  vel : 	vel
			  },
		dataType : 'json',
		success:function(data){
			$('#rhi_dialog_nvo').dialog('close');				
				$.each(data,function(index,record){
					var row = $('<tr />');
					fi = "'"+record.FI+"'";
					ff = "'"+record.FF+"'";
					$("<td/>").html('<div onclick="rhi_detalle('+fi+','+ff+','+record.ID_U+');" class="custom-icon-edit-custom">'+
                    '<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
                    '</div>').appendTo(row);
					$("<td/>").text(record.DATE).appendTo(row);
					$("<td/>").text(record.UNIT).appendTo(row);
					$("<td/>").text(record.PART).appendTo(row);
					$("<td/>").text(record.PARA).appendTo(row);
					$("<td/>").text(record.PARN).appendTo(row);
					$("<td/>").text(record.TMOV).appendTo(row);
					$("<td/>").text(record.TDEA).appendTo(row);
					$("<td/>").text(record.TDEN).appendTo(row);
					$("<td/>").text(record.VELM).appendTo(row);
					$("<td/>").text(record.TEXC).appendTo(row);
					$("<td/>").text(record.KREC).appendTo(row);
					row.appendTo("#rhi_table");
				});
			$("#rhi_exp_exe").css("display","");
		}
	});
}	

function rhi_detalle(fi,ff,und){
	$.ajax({
		url: "index.php?m=rHistorico&c=mDetalle",
		type: "GET",
		data: {
		  fi : fi,
		  ff : ff,
		  idund : und
		},
		success: function(data) {
			var result = data; 
			$('#rhi_dialog').html('');

			var w = ($(window).width())*0.92;
			var h = ($(window).height())*0.90;
			$("#rhi_dialog").dialog( "option", "resizable", false );
			$("#rhi_dialog").dialog( "option", "width", w );
			$("#rhi_dialog").dialog( "option", "height", h );
			$('#rhi_dialog').dialog('open');
			$('#rhi_dialog').html(result); 
		}
	});
}

function rhi_mapa(){
	latlng = new google.maps.LatLng(19.435113686545755,-99.13316173010253);
	myOptions = {
		zoom: 4,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map_rhi = new google.maps.Map(document.getElementById("tabs_dMapa"), myOptions);
	infowindow = new google.maps.InfoWindow;
	/*rhi_ubicar(x,fi,ff);*/
}

function rhi_load_detail_datatable(fi,ff,und){
	$.ajax({
		url: "index.php?m=rHistorico&c=mGet_Detalle_Gral",
		type: "GET",
		data: {
		  fi : fi,
		  ff : ff,
		  idund : und,
		  tag: "getData" 
		 },
		success: function(data) {
			var result = data;
			if(result != 0){
				$('#tabs_dResumen').html('');
				$('#tabs_dResumen').html(result); 
				oTable= $('#rhi_detgral_table').dataTable({ 
				    "aaData" :gral_data,               
				    "bDestroy": true,
				    "bLengthChange": false,
				    "bPaginate": true,
				    "bFilter": true,
				    "bSort": true,
				    "bJQueryUI": true,
				    "iDisplayLength": 10,
				    "bAutoWidth": false,
				    "bSortClasses": false,    
				    "aoColumns": [
				      { "mData": "FECHA", sDefaultContent: "" },
				      { "mData": "EVENT", sDefaultContent: "" },
				      { "mData": "TOTAL", sDefaultContent: "" },
				    ] ,           
				    "oLanguage": {
				        "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
				        "sEmptyTable": "No hay registros.",
				        "sInfoEmpty" : "No hay registros.",
				        "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
				        "sLoadingRecords": "Leyendo información",
				        "sProcessing": "Procesando",
				        "sSearch": "Buscar:",
				        "sZeroRecords": "No hay registros",
				    },
			  });
			}else{
				$('#tabs_dResumen').html('<p align="center">No existen datos asociados</p>'); 
			}
		}
	});
}

function rhi_load_com_datatable(){
	oTable2= $('#rhi_detcom_table').dataTable({ 
		"aaData" :deta_data,               
		"bDestroy": true,
		"bLengthChange": false,
		"bPaginate": true,
		"bFilter": true,
		"bSort": true,
		"bJQueryUI": true,
		"iDisplayLength": 15,
		"bAutoWidth": false,
		"bSortClasses": false,    
		"aoColumns": [
		  { "mData": "FECHA", sDefaultContent: "" },
		  { "mData": "EVENT", sDefaultContent: "" },
		  { "mData": "VEL", sDefaultContent: "" },
		  { "mData": "LATIT", sDefaultContent: "" },
		  { "mData": "LONGI", sDefaultContent: "" },		  
		  { "mData": "DIREC", sDefaultContent: "" },
		] ,           
		"oLanguage": {
		    "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
		    "sEmptyTable": "No hay registros.",
		    "sInfoEmpty" : "No hay registros.",
		    "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
		    "sLoadingRecords": "Leyendo información",
		    "sProcessing": "Procesando",
		    "sSearch": "Buscar:",
		    "sZeroRecords": "No hay registros",
		}
	});	
	rhi_ubicar();
}

//-------------------------------------------------
function export_excel(){
	
	var s='';	
	if($('#selunidad').val()== -1){
			$('#selunidad option').each(function(i) {
			if(s==''){
				if($(this).val()!= -1 && $(this).val()!= 0){
			s=$(this).val();
				}
			//alert(s);
				}
				else{
				if($(this).val()!= -1 && $(this).val()!= 0){
			s+=','+$(this).val();
				}
					}
			});
			//alert(s);
			var units	=	s;
	}else{				 
			var units	=	$("#selunidad").val();	
		}
	var radio  =	document.getElementById("rd1").checked;
	var radio2 =	document.getElementById("rd2").checked;
	var fc_ini =	$("#start_date").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00";
	var fc_fin =	$("#end_date").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00";

	var fech   =	$('#cbo_sem').val();
	var tfilt  =0;
	var rdo = $('#cbo_radio').val()/1000;
	var vel = $('#velocity').val();
	
	if(radio == true){
		tipo = 0;
	}else if(radio2 == true){
		tipo = 1;
	}	
	

	var url = "index.php?m=rHistorico&c=mExcel";
	var urlComplete = url + "&tipo="+tipo+"&fInicio="+fc_ini+"&fFin="+fc_fin+"&unidad="+units+"&semana="+fech;
	
	//var newWindow=window.open(urlComplete,'Reporte KML','height=600,width=800');
	window.location = urlComplete;
	return false;
}
//---------------------------------------------

function rhi_ubicar(){	
	clearOverlays();
	if(deta_data.length>0){
		var latlngbounds = new google.maps.LatLngBounds( );

		var mon_table = $("<table id='hist_table_selected' class='total_width' border='0'>");

		$("<thead><tr><th>Fecha</th><th>Evento</th><th>&nbsp;</th></tr></thead><tbody>")
		.appendTo(mon_table)
		.hover(
			function(){
				$(this).css('cursor','pointer');
			},function() {
				$(this).css('cursor','auto');
		});		

		$.each(deta_data,function(index,record){	
			var tmp 			=  index; 
			var unitLatitude  	=  record.LATIT;
			var unitLong  		=  record.LONGI;
			var evento    		=  record.EVENT;
			var fecha     		=  record.FECHA;
			var velocidad		=  record.VEL;
			var direccion    	=  record.DIREC;
			var priory			= 0;

			var info = '<br><div class="div_unit_info ui-widget-content ui-corner-all">'+
							'<div class="ui-widget-header ui-corner-all" align="center">Información de la Unidad</div>'+
						  			'<table><tr><th colspan="2">'+
						  			'<tr><td align="left">Evento :</td><td align="left">'	+ evento	+'</td></tr>'+
						  			'<tr><td align="left">Fecha  :</td><td align="left">'	+ fecha	+'</td></tr>'+
									'<tr><td align="left">Velocidad:</td><td align="left">'	+ velocidad	+' Km/h.</td></tr>'+
									'<tr><td align="left">Dirección:</td><td align="left">'	+ direccion	+'</td></tr>'+
				  					'</table>'+
				  				'</div>';			

			points.push(new google.maps.LatLng(unitLatitude, unitLong));						
			latlngbounds.extend( new google.maps.LatLng(unitLatitude, unitLong) ); 
			
			var image = '';
			if(velocidad<5 && priory==0){
				image = 'public/images/car_red.png';	
			}else if(velocidad>5 && priory==0){
				image = 'public/images/car_green.png';	
			}else  if(priory==1){
				image = 'public/images/car_orange.png';	
			}	
			var marker1 = new google.maps.Marker({
			    map: map_rhi,
			    position: new google.maps.LatLng(unitLatitude,unitLong),
			    title: 	fecha,
				icon: 	image
			});
			marcadores.push(marker1);
			add_info_marker(marker1,info);

			var a_info= evento+"|"+fecha+"|"+velocidad+"|"+direccion;				

			$("<tr>"+				
				"<td onclick='mon_center_map("+unitLatitude+","+unitLong+",\""+a_info+"\""+",\""+fecha+"\",false);'>"+fecha+ "</td>"+
				"<td onclick='mon_center_map("+unitLatitude+","+unitLong+",\""+a_info+"\""+",\""+fecha+"\",false);'>"+evento+ "</td>"+
				"<td><div class='mon_units_info' onclick='mon_center_map("+unitLatitude+","+unitLong+",\""+a_info+"\""+",\""+fecha+"\",true)'>"+
				"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+"</div>"+				
				"</td></tr>")
			.appendTo(mon_table);
		});
		mon_table.appendTo("#tabs_tMapa");	
		scroll_table=($("#tabs_detMapa").height()-80)+"px";
		$("#hist_table_selected").dataTable({ 
			"sScrollY": scroll_table,
			"bDestroy": true,
			"bLengthChange": false,
			"bPaginate": false,
			"bFilter": true,
			"bSort": true,
			"bJQueryUI": true,
			/*"iDisplayLength": 15,*/
			"bAutoWidth": false,
			"bSortClasses": false,          
			"oLanguage": {
			    "sInfo": " ",
			    "sEmptyTable": "No hay registros.",
			    "sInfoEmpty" : "No hay registros.",
			    "sInfoFiltered": " ",
			    "sLoadingRecords": "Leyendo información",
			    "sProcessing": "Procesando",
			    "sSearch": "Buscar:",
			    "sZeroRecords": "No hay registros",
			}
		});	
		var iconsetngs = {
		    path: google.maps.SymbolPath.BACKWARD_OPEN_ARROW,
		    strokeColor: '#155B90',
		    fillColor: '#155B90',
		    fillOpacity: 1,
		    strokeWeight: 4        
		};

		line = new google.maps.Polyline({
			map: map_rhi,
			path: points,
			strokeColor: "#098EF3",
			strokeOpacity: 1.0,
			strokeWeight: 2,
		    icons: [{
		        icon: iconsetngs,
		        repeat:'35px',         
		        offset: '100%'}]
		}); 	 	  	
		map_rhi.fitBounds(latlngbounds);			
	}
}
//---------------------------------------------------------------	
function clearOverlays() {
  for (var i = 0; i < marcadores.length; i++ ) {
    marcadores[i].setMap(null);
  }
  //alert(poly.length);
  for (var i = 0; i < poly.length; i++ ) {
    poly[i].setMap(null);
  }
  //trayecto.setMap(null);
  //reiniciar variables
  points=[];
  marcadores=[];
  poly=[];
}


function add_info_marker(marker,content){	
    google.maps.event.addListener(marker, 'click',function() {
      if(infowindow){infowindow.close();infowindow.setMap(null);}
      var marker = this;
      var latLng = marker.getPosition();
      infowindow.setContent(content);
      infowindow.open(map_rhi, marker);
      map_rhi.setZoom(18);
	  map_rhi.setCenter(latLng);      
	});
}

function mon_remove_map(){
	for (var i = 0; i < marcadores.length; i++) {
          marcadores[i].setMap(null);
	}	
	marcadores = [];
	lineCoordinates = [];
	if(line){
		line.setMap(null);
	}
}	

function mon_center_map(lat,lon,info,title,show_info){
	var unit_info = info.split("|");	
	var info = '<br><div class="div_unit_info ui-widget-content ui-corner-all">'+
					'<div class="ui-widget-header ui-corner-all" align="center">Información de la Unidad</div>'+
				  			'<table><tr><th colspan="2">'+
				  			'<tr><td align="left">Evento :</td><td align="left">'	+ unit_info[0]	+'</td></tr>'+
				  			'<tr><td align="left">Fecha  :</td><td align="left">'	+ unit_info[1]	+'</td></tr>'+
							'<tr><td align="left">Velocidad:</td><td align="left">'	+ unit_info[2]	+' Km/h.</td></tr>'+
							'<tr><td align="left">Dirección:</td><td align="left">'	+ unit_info[3]	+'</td></tr>'+
		  					'</table>'+
		  				'</div>';	
	var image = new google.maps.MarkerImage('public/images/car.png',
		new google.maps.Size(1, 1),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 32));
    var myLatLng 	= new google.maps.LatLng(lat,lon);
    var beachMarker = new google.maps.Marker({
        position: myLatLng,
        map: 	map_rhi,
        title: 	title,
        icon:   image,
    });

    marcadores.push(beachMarker);    
	if(infowindow){infoWindow.close();infowindow.setMap(null);}
		infowindow = new google.maps.InfoWindow({
	    content: info
	});
	
	if(show_info){infowindow.open(map_rhi,beachMarker);map_rhi.setZoom(18);}

	var positon = new google.maps.LatLng(lat, lon);
	/*if(show_info){map_rhi.setZoom(18);}*/
	map_rhi.setCenter(positon);	
}

function export_excel_detalle(fi,ff,und){
	var url = "index.php?m=rHistorico&c=mExcel_detalle";
	var urlComplete = url + "&unidad="+und+"&fInicio="+fi+"&fFin="+ff;
	window.location = urlComplete;
	return false;
}