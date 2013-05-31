var arrayunits 		= Array();
var draw_acordion	= 0;
var array_selected  = Array();
var markers = [];
var map, infoBubble;
var mon_timer,mon_timer_count;
var info_window='';
var infowindow;
var beachMarker;

function mon_init(){
	$("#mon_tabs").tabs();
    $( ".tabs-bottom .ui-tabs-nav, .tabs-bottom .ui-tabs-nav > *" ).removeClass( "ui-corner-all ui-corner-top" ).addClass( "ui-corner-bottom" );
    $( ".tabs-bottom .ui-tabs-nav" ).appendTo( ".tabs-bottom" );    
    infoWindow = new google.maps.InfoWindow;
}

function onload_map(){      
    var mapOptions = {
      zoom: 5,
      center: new google.maps.LatLng(24.52713, -104.41406),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };
	map = new google.maps.Map(document.getElementById('mon_content'),mapOptions);
    google.maps.event.addListener(map, 'click', function() {
      infoWindow.close();
    });			
	mon_load_units();
	mon_init();
}

function mon_load_units(){
	$.ajax({
		type: "POST",
        url: "index.php?m=mMonitoreo&c=mGetPunits",
        success: function(datos){
			var result = datos;
			if(result!= 0){
				arrayunits=new Array();
				arrayunits=result.split('!');
				if(draw_acordion==0){mon_draw_acordion();}
				else{ mon_refresh_selected();}
			}
        }
	});
}

var mon_array_autocomplete = Array();

function mon_draw_acordion(){


	var mon_div_acordeon = $("<div>", { id: 'mon_acordeon_unidades' })
	var mon_id_group 	= 0;
	var mon_div_info	= "";
	var mon_table_acoredon=';'

	for(var i=0;i<arrayunits.length;i++){
		var arraygroup = arrayunits[i].split('|');
		 var miobjeto   = new Object();
		 miobjeto.label = arraygroup[3];
		 miobjeto.desc  = arrayunits[i];
		 mon_array_autocomplete.push(miobjeto);

		if(arraygroup[0] != mon_id_group){//Si el grupo es diferente se crea opcion de acordeon
			if(mon_div_info!=""){mon_div_info.appendTo(mon_div_acordeon);}

			$('<h3>').html(arraygroup[1]).appendTo(mon_div_acordeon);			
			mon_div_info  = $("<div>");
			mon_table_acoredon = $('<table class="div_units_acordeon">').appendTo(mon_div_info);
			$("<tr><td>&nbsp;</td><td colspan='2' align='center'>Todas</td><td>"+
				  "<div id='mon_group_icon_"+arraygroup[0]+"' "+
				  "class='icon_unit_unselected' style='z-index:-5000'>"+
				  "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+	
				  "</div></td></tr>")
			.appendTo(mon_table_acoredon)
			.click(
				add_event_group(arraygroup[0])						
			)
			.hover(
				function(){
					$(this).addClass('unit-selected');
					$(this).css('cursor','pointer');
				},function() {
					$(this).removeClass('unit-selected');
					$(this).css('cursor','auto');
			});
			mon_id_group  = arraygroup[0];
		}

/*		$("<tr id='div_unit_"+arraygroup[2]+"'><td>&nbsp;</td> <td>"+arraygroup[3]+"</td> <td>"+arraygroup[5]+
			  "</td><td><div id='mon_acordeon_icon_"+arraygroup[2]+"' "+
			  "class='icon_unit_unselected'></div></td></tr>")*/
		$("<tr id='div_unit_"+arraygroup[2]+"'><td>&nbsp;</td> <td>"+arraygroup[3]+"</td> <td><td><div id='mon_acordeon_icon_"+arraygroup[2]+"' "+
			  "class='icon_unit_unselected'></div></td></tr>")
		.appendTo(mon_table_acoredon)
		.click( add_event(miobjeto.desc) )
		.hover(
			function(){ $(this).addClass('unit-selected'); 			$(this).css('cursor','pointer');
			},function() { $(this).removeClass('unit-selected'); 	$(this).css('cursor','auto');
		});
	}

	mon_div_info.appendTo(mon_div_acordeon);	
	mon_div_acordeon.appendTo("#mon_menu_acordeon");
	mon_div_acordeon.accordion();
	draw_acordion=1;

    $( "#tags" ).autocomplete({
      source: mon_array_autocomplete,
      select: function( event, ui ) {      	
		mon_search_unidad(ui.item.desc+"",true);
      },open: function () {
        $(this).data("autocomplete").menu.element.width(500);
    	}
    });
}

function add_event(unit){
    return function() { mon_search_unidad(unit,true); };
}

function add_event_group(group){
    return function() { mon_select_group(group,true); };
}

function mon_select_group(group){
	for(var i=0;i<arrayunits.length;i++){
		var units_info = arrayunits[i].split('|');
		if(units_info[0]==group){
			var className = $('#mon_group_icon_'+group).attr('class');
			
			var existe = jQuery.inArray(arrayunits[i], array_selected);
			if(className=='icon_unit_unselected'){
				if(existe<0){
					mon_search_unidad(arrayunits[i],false);
				}
			}else if(className=='icon_unit_selected'){
				if(existe>=0){
					mon_search_unidad(arrayunits[i],false);
				}
			}
		}
	}

	var total_units=0;
	for(var i=0;i<array_selected.length;i++){
		var units_info = array_selected[i].split('|');
		if(units_info[0]==group){			
			total_units++;
		}
	}
	if(total_units>0){
		$("#mon_group_icon_"+group).removeClass('icon_unit_unselected').addClass('icon_unit_selected');
	}else{
		$("#mon_group_icon_"+group).removeClass('icon_unit_selected').addClass('icon_unit_unselected');
	}

	mon_draw_table();
}

function mon_unselect_units(){
	return function() {
		if(array_selected.length>0){
			for(var i=0;i<array_selected.length;i++){	
				var arraygroup = array_selected[i].split('|');
				$("#mon_acordeon_icon_"+arraygroup[2]).removeClass('icon_unit_selected').addClass('icon_unit_unselected');
				$("#mon_group_icon_"+arraygroup[0]).removeClass('icon_unit_selected').addClass('icon_unit_unselected');
			}
			array_selected = [];
			mon_draw_table();
		}
	};
}

function mon_search_unidad(buscar,draw){	
	var existe = jQuery.inArray(buscar, array_selected);
	var arraygroup = buscar.split('|');
	if(existe<0){
		array_selected.push(buscar);		
		//$("#div_unit_"+arraygroup[2]).addClass("unit-selected");
		$("#mon_acordeon_icon_"+arraygroup[2]).removeClass('icon_unit_unselected').addClass('icon_unit_selected');
		/*mon_draw_table();*/
	}else{
		//$("#div_unit_"+arraygroup[2]).removeClass('unit-selected');
		$("#mon_acordeon_icon_"+arraygroup[2]).removeClass('icon_unit_selected').addClass('icon_unit_unselected');
		array_selected.splice(existe,1);		
	}
	if(draw){
		mon_draw_table();
	}	
}

function mon_draw_table(){
	mon_remove_map();
	$("#mon_tabs_select").html("No se ha seleccionado ninguna unidad.");
	$("#mon_div_timer").addClass("invisible");

	if(array_selected.length>0){    	
		var mon_alerta_unidades	= '<table><tr><td><b>Unidad </b></td>'+
									'<td><b>Evento </b></td>'+
									'<td><b>Fecha  </b></td>'+
									'<td><b>Direccion </b></td></tr>';

		var mon_total_alertas	= 0;
		$("#mon_tabs_select").html("");

		var mon_table = $("<table id='mon_table_selected' class='total_width' border='0'>");
		$("<tr><th><div id='mon_group_icon_rows' class='icon_unit_selected'>"+
			"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+	
			"</div></th>"+
			 "<th>Unidad</th> <th>U.Posicion</th></tr>").appendTo(mon_table).click(
			mon_unselect_units()
		).hover(
			function(){
				$(this).css('cursor','pointer');
			},function() {
				$(this).css('cursor','auto');
		});

		var latlngbounds = new google.maps.LatLngBounds( );

		for(var i=0;i<array_selected.length;i++){
			var unit_info = array_selected[i].split("|");

	        // Se vacia la infromacion en variables para pintar en el mapa la informacion de las undidades
			var id 		= unit_info[2];
			var fecha	= unit_info[5];//--s
			var evt 	= unit_info[6];//--
			var estatus	= unit_info[7];//--
			var colstus	= unit_info[8];//--
			var pdi 	= unit_info[9];//--
			var vel 	= unit_info[10];//--
			var dire 	= unit_info[11];//--
			var priory 	= unit_info[14];//--
			var lat 	= unit_info[12];
			var lon 	= unit_info[13];
			var dunit 	= unit_info[3];//--
			var icons 	= unit_info[15];
			var angulo 	= unit_info[16];
			var colprio = unit_info[4];//--*/
			var content = '<br><div class="div_unit_info ui-widget-content ui-corner-all">'+
							'<div class="ui-widget-header ui-corner-all" align="center">Información de la Unidad</div>'+
						  			'<table><tr><th colspan="2">'+
									'<tr><td align="left">Unidad :</td><td align="left">'	+ dunit +'</td></tr>'+
						  			'<tr><td align="left">Evento :</td><td align="left">'	+ evt	+'</td></tr>'+
						  			'<tr><td align="left">Fecha  :</td><td align="left">'	+ fecha	+'</td></tr>'+
									'<tr><td align="left">Velocidad:</td><td align="left">'	+ vel	+' Km/h.</td></tr>'+
									'<tr><td align="left">Estado:</td><td align="left">'   	+ estatus	+'</td></tr>'+									
									'<tr><td align="left">Dirección:</td><td align="left">'	+ dire	+'</td></tr>'+
									'<tr><td>&nbsp;</td><td align="rigth" colspan="2"<td align="left">'		+ pdi	+'</td></tr>'+
				  					'</table>'+
				  				'</div>';
			var image = '';
			if(vel<5 && priory==0){
				image = 'public/images/car_red.png';	
			}else if(vel>5 && priory==0){
				image = 'public/images/car_green.png';	
			}else  if(priory==1){
				image = 'public/images/car_orange.png';	
			}	

			/*var image = 'public/images/car.png';*/
		    var marker1 = new google.maps.Marker({
			    map: map,
			    position: new google.maps.LatLng(unit_info[12],unit_info[13]),
			    title: 	dunit,
				icon: 	image
		    });
		    markers.push(marker1);
			add_info_marker(marker1,content);

			if(priory==1){
				mon_total_alertas++;
				mon_alerta_unidades += '<tr><td><b>'	+ dunit +'</b></td>'+
										'<td><b>'	+ evt	+'</b></td>'+
										'<td><b>'	+ fecha	+'</b></td>'+
										'<td><b>'	+ dire	+'</b></td></tr>';
			}

			$("<tr>"+
				"<td><div id='mon_div_icon"+unit_info[2]+"' class='icon_unit_selected' onclick='mon_search_unidad(\""+array_selected[i]+"\",true)'>"+
				"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+	
				"</div>"+
				"<td onclick='mon_center_map(\""+array_selected[i]+"\");'>"+unit_info[3]+"</td> "+
				"<td onclick='mon_center_map(\""+array_selected[i]+"\");'>"+unit_info[5]+ "</td>"+
				"<td><div id='mon_div_iconi"+unit_info[2]+"' class='mon_units_info' onclick='mon_get_info(\""+array_selected[i]+"\")'>"+
				"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+"</div>"+				
				"</td></tr>")
			.appendTo(mon_table)
			.hover(
				function(){
					$(this).addClass('unit-selected');
					$(this).css('cursor','pointer');
				},function() {
					$(this).removeClass('unit-selected');
					$(this).css('cursor','auto');
			});	
		}	
		mon_table.appendTo("#mon_tabs_select");
		//map.fitBounds( latlngbounds );

		if(mon_total_alertas>0 && tab_active==0){
			mon_alerta_unidades += '</table>';
			$("#dialog_message").html(mon_alerta_unidades);
			$("#dialog_message").dialog('open');
		}
		$("#mon_div_timer").removeClass("invisible").addClass("visible");
		$("#mon_sel_time").change(function (){
			mon_refresh_units()
		});

		mon_refresh_units();
	}
}

function add_info_marker(marker,content){	
    google.maps.event.addListener(marker, 'click',function() {
      if(infowindow){infoWindow.close();infowindow.setMap(null);}
      var marker = this;
      var latLng = marker.getPosition();
      infoWindow.setContent(content);
      infoWindow.open(map, marker);
      map.setZoom(18);
	  map.setCenter(latLng);      
	});
}

function mon_remove_map(){
	if(markers || markers.length>-1){
		for (var i = 0; i < markers.length; i++) {
	          markers[i].setMap(null);
		}	
		markers = [];
	}

	if(mon_timer!=null){
		mon_timer.stop();	
		mon_timer=null;
	}
	if(mon_timer_count!=null){
		mon_timer_count.stop();
		mon_timer_count=null;
	}	
	$("#mon_time").html("00:00");
}

function mon_refresh_units(){
	var time = $("#mon_sel_time").val();
	if(mon_timer!=null){
		mon_timer.stop();	
		mon_timer=null;
	}
	var secondsreal = time /1000;
	start_counter(secondsreal);
	mon_timer = $.timer(time , function(){
		if(array_selected.length>0){						
			mon_load_units();
		}
	});		
}

var time_lapse=0;
function start_counter(time){
	if(mon_timer_count!=null){
		mon_timer_count.stop();
		mon_timer_count=null;
	}	

	$("#mon_time").html("00:00");	
	var time_lapse = time;
	mon_timer_count = $.timer(1000 , function(){		
		$("#mon_time").html("");
	    var hours = Math.floor(time_lapse / (60 * 60));
	    var divisor_for_minutes = time_lapse % (60 * 60);
	    var minutes = Math.floor(divisor_for_minutes / 60);
	    var divisor_for_seconds = divisor_for_minutes % 60;
	    var seconds = Math.ceil(divisor_for_seconds);

	    $("#mon_time").html(checkTime(minutes) + ":" + checkTime(seconds));
	    time_lapse= time_lapse - 1;
	    if(time_lapse==0){		
	    	mon_timer_count.stop();
			mon_timer_count=null;
		}
	});    
}

function checkTime(i){
	if (i<10){
  		i="0" + i;
  	}
	return i;
}

function mon_refresh_selected(){
	for(var i=0;i<arrayunits.length;i++){
		var units_info = arrayunits[i].split('|');
		for(var u=0;u<array_selected.length;u++){
			var units_selected = array_selected[u].split('|');
			if(units_info[2] == units_selected[2]){
				array_selected[u] = arrayunits[i];
			}
		}
	}
	mon_draw_table();
}

function mon_center_map(unitsinfo){	
	var unit_info = unitsinfo.split("|");	

    /* Se vacia la infromacion en variables para pintar en el mapa la informacion de las undidades*/
	var id 		= unit_info[2];
	var fecha	= unit_info[5];//--s
	var evt 	= unit_info[6];//--
	var estatus	= unit_info[7];//--
	var colstus	= unit_info[8];//--
	var pdi 	= unit_info[9];//--
	var vel 	= unit_info[10];//--
	var dire 	= unit_info[11];//--
	var priory 	= unit_info[14];//--
	var lat 	= unit_info[12];
	var lon 	= unit_info[13];
	var dunit 	= unit_info[3];//--
	var icons 	= unit_info[15];
	var angulo 	= unit_info[16];
	var colprio = unit_info[4];//--

	var image = new google.maps.MarkerImage('public/images/car.png',
		new google.maps.Size(1, 1),
		new google.maps.Point(0,0),
		new google.maps.Point(0, 32));
    var myLatLng 	= new google.maps.LatLng(lat,lon);
    var beachMarker = new google.maps.Marker({
        position: myLatLng,
        map: 	map,
        title: 	dunit,
        icon:   image,
    });

    markers.push(beachMarker);

	var info = '<br><div class="div_unit_info ui-widget-content ui-corner-all">'+
					'<div class="ui-widget-header ui-corner-all" align="center">Información de la Unidad</div>'+
						/*'<div>'+*/
				  			'<table><tr><th colspan="2">'+
							'<tr><td align="left">Unidad :</td><td align="left">'	+ dunit +'</td></tr>'+
				  			'<tr><td align="left">Evento :</td><td align="left">'	+ evt	+'</td></tr>'+
				  			'<tr><td align="left">Fecha  :</td><td align="left">'	+ fecha	+'</td></tr>'+
							'<tr><td align="left">Velocidad:</td><td align="left">'	+ vel	+'</td></tr>'+
							'<tr><td align="left">Estado:</td><td align="left">'   	+ estatus	+'</td></tr>'+									
							'<tr><td align="left">Dirección:</td><td align="left">'	+ dire	+'</td></tr>'+
							'<tr><td>&nbsp;</td><td align="rigth" colspan="2"<td align="left">'		+ pdi	+'</td></tr>'+
		  					'</table>'+
		  				/*'</div>'+*/
		  				'</div>';
	if(infowindow){infoWindow.close();infowindow.setMap(null);}
	infowindow = new google.maps.InfoWindow({
	    content: info
	});
	
	infowindow.open(map,beachMarker);

	var positon = new google.maps.LatLng(lat, lon);
	map.setZoom(18);
	map.setCenter(positon);	
}

function mon_get_info(valor){
	$("#mon_dialog").html("");
	var texto="";
	var unit_info = valor.split("|");
	var option="";
	var mon_imei='';
	if(unit_info[17]!="SC"){
		var comandos = unit_info[17].split("?");
		for(var i=0; i<comandos.length;i++){
			values = comandos[i].split("_");
			option = option + '<option value="'+values[0]+'">'+values[2]+'</option>';
			mon_imei = values[1];
		}

		var table_cmds = $("<table class='total_width'>").appendTo("#mon_dialog");

		$("<tr><td>Comandos:</td><td><select class='caja_txt' id='mon_sel_cmds'>"+option+"<select></td></tr>").appendTo(table_cmds);		
		$("<tr><td valign='top'>Comentarios:</td><td><textarea  id='mon_cmds_com' class='caja_txt_a' /></td></tr>").appendTo(table_cmds);
		$("<input type='hidden' id='mon_cmds_imei' value='"+mon_imei+"' />").appendTo("#mon_dialog");
		$("<input type='hidden' id='mon_cmds_unit' value='"+unit_info[2]+"' />").appendTo("#mon_dialog");
	}else{
		$("<h2>Esta unidad no tiene asignados comandos</h2>").appendTo("#mon_dialog");
	}
	$("#mon_dialog").dialog('open',"position", { my: "left top", at: "left bottom", of: "mon_div_iconi"+unit_info[2] });
}

function mon_send_command(){
	if($("#mon_dialog").html()!='<h2>Esta unidad no tiene asignados comandos</h2>'){

		var imei    = $("#mon_cmds_imei").val();
		var command = $("#mon_sel_cmds").val();
		var comment = $("#mon_cmds_com").val();
		var unit   = $("#mon_cmds_unit").val();

		if(imei!="" && command>0 && comment!=""){
		    $.ajax({
		        url: "index.php?m=mMonitoreo&c=mSetComando",
		        type: "GET",
		        dataType : 'json',
		        data: { data: command,
		        		imei: imei,
		        		comment: comment ,
		        		unit   : unit
		        },
		        success: function(data) {
		          var result = data.result; 

		          if(result=='no-data' || result=='problem'){
		              $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El comando no pudo ser enviado.</p>');
		              $("#dialog_message" ).dialog('open');             	          
		          }else if(result=='send'){ 
		              $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Comando enviado correctamente.</p>');
		              $("#dialog_message").dialog('open');
		              $("#mon_dialog").dialog("close");
		              setTimeout(mon_load_units(),5000);
		          }else if(result=='no-perm'){ 
		              $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
		              $("#dialog_message" ).dialog('open');       
				  }else if(result=='pending'){ 
		              $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se puede enviar este comando, ya que existe uno pendiente por enviar.</p>');
		              $("#dialog_message" ).dialog('open');       
		          }
		        }
		    });
		}else{
	      $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un comando y agregar un comentario.</p>');
	      $("#dialog_message" ).dialog('open');  				
		}
	}else{
		$("#mon_dialog").dialog("close");
	}
}