var geof_marcadores = [];
var gmain_mrk = [];
var gmain_cir = [];
var gcir = [];
var geoTable;
var geo_map;
var geo_gmap;
var geocoder;
var idev = -1;
$(document).ready(function () {
	
	//Definir datepicker
	$(".caja_date").datepicker({
			showOn: "button",
			buttonImage: "public/images/cal.gif",
			buttonImageOnly: true,
			maxDate: '0',
			dateFormat: "yy-mm-dd"
		});
	//Definir botnes buscar
	$( ".search" ).button({
      icons: {
        primary: "ui-icon-search"
      },
      text: false
    })
	//Definir botnes editar
	$( ".edit" ).button({
      icons: {
        primary: "ui-icon-pencil"
      },
      text: false
    })	
	//Definir botones importar
	$( ".import" ).button({
      icons: {
        primary: "ui-icon-circle-arrow-n"
      },
      text: false
    })
	//DEFINIR BOTON
	$(".boton").button();
	//CARGAR TABLA GEOPUNTOS
	geo_load_datatable();
	get_evidencias();
	get_preg_resp(-1);
	//DECLARAR DIALOG NUEVO/EDICION
	$("#geo_dialog" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  800,
		height: 600,
		
		buttons:
			{
			"Guardar": function(){
				validar_datos();
				},
			"Cancelar": function(){
				if($("#geo_dialog" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#geo_dialog" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		});
	//Declara dialog import
	$("#geo_dialog_import" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  550,
		height: 400,
		buttons: {
			"Importar": function(){
				geo_enviar_excel();
				},
			"Cancelar": function(){
				if($("#geo_dialog_import" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#geo_dialog_import" ).dialog('close');
					geo_load_datatable();
				}
				},
		show: "blind",
		hide: "blind"
		});
	//Declara dialog import payload
	$("#geo_dialog_impay" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  550,
		height: 400,
		buttons: {
			"Importar": function(){
				geo_enviar_excel_pay();
				},
			"Cancelar": function(){
				if($("#geo_dialog_impay" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#geo_dialog_impay" ).dialog('close');
					//geo_load_datatable();
				}
				},
		show: "blind",
		hide: "blind"
		});			
	//Declara dialog editar preguntas respuestas
	$("#geo_dialog_pr" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  820,
		height: 300,
		buttons: {
			"Guardar": function(){
				geo_validar_pr();
				},
			"Cancelar": function(){
				if($("#geo_dialog_pr" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#geo_dialog_pr" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		});				
	//MAPA PRINCIPAL
	geo_mapa();
	//Borrar cookies
	//deleteAllCookies();

	//setTimeout(function(){deleteAllCookies()},600000)
	});
//----------------------------
function geo_load_datatable(){
	scroll_table=($("#geo_main").height()-125)+"px";
	//wtd = ($("#qst_main").width()*.45)+"px"
    qstTable = $('#geo_table').dataTable({
	  "sScrollY": scroll_table,
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": false,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,
      "iDisplayLength": 20,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=geopuntos2&c=mGet_GeoPuntos",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_OBJECT_MAP", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "GEO", sDefaultContent: "" },
		{ "mData": "ITEM_NUMBER", sDefaultContent: "" },
        { "mData": "TYP", sDefaultContent: ""}
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			var gra   = '';

            edit = "<td><div onclick='geo_nuevo(2,"+full.ID_OBJECT_MAP+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='geo_delete_function("+full.ID_OBJECT_MAP+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
					gdsc = "\'"+full.GEO+"\'"
					gnip = "'"+full.ITEM_NUMBER+"'"
					gtyp = "'"+full.TYP+"'"
			gra = '<td><div onclick="centra_mapa('+full.LATITUDE+','+full.LONGITUDE+','+gdsc+','+gnip+','+gtyp+','+full.RADIO+'),change_idev('+full.ID_OBJECT_MAP+'),get_evidencias();" class="custom-icon-copy">'+
                    '<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
                    '</div></td>';

            return '<table><tr>'+gra+edit+del+'</tr></table>';
        }}	
      ],
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
//----------------------------
function validar_id(){
	
	if(idev==-1){
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un Punto de inter\u00e9s.</p>');
		$("#dialog_message" ).dialog('open');	
		}
	}
//----------------------------
function get_evidencias(){
	
	get_preg_resp(-1);
	//alert(idev)
	
	/*if(idev==-1){
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un Punto de interes.</p>');
		$("#dialog-message" ).dialog('open');	
		}
	else{*/
		u = ($("#user").val() != -1)?$("#user").val():get_usr();
		i = $("#dti").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00";
		f = $("#dtf").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		scroll_table=($("#qstion").height()-145)+"px";
		//alert(scroll_table)
		//wtd = ($("#qst_main").width()*.45)+"px"
		qstTable = $('#geo_evd_table').dataTable({
		  "sScrollY": scroll_table,
		  "bDestroy": true,
		  "bLengthChange": true,
		  "bPaginate": false,
		  "bFilter": true,
		  "bSort": true,
		  "bJQueryUI": true,
		  "iDisplayLength": 20,      
		  "bProcessing": true,
		  "bAutoWidth": false,
		  "bSortClasses": false,
		  "sAjaxSource": "index.php?m=geopuntos2&c=mEvidencia&id="+idev+"&usr="+u+"&dti="+i+"&dtf="+f,
		  "aoColumns": [
			{ "mData": " ", sDefaultContent: "" },
			{ "mData": "ID_RES_CUESTIONARIO", sDefaultContent: "","bSearchable": false,"bVisible":    false },
			{ "mData": "FECHA", sDefaultContent: "" },
			{ "mData": "QST", sDefaultContent: "" },
			{ "mData": "NOMBRE_COMPLETO", sDefaultContent: ""}
		  ] , 
		  "aoColumnDefs": [
			{"aTargets": [0],
			  "sWidth": "65px",
			  "bSortable": false,        
			  "mRender": function (data, type, full) {
				//var edit  = '';
				//var del   = '';
				var gra   = '';
	
				/*edit = "<td><div onclick='geo_nuevo(2,"+full.ID_OBJECT_MAP+");' class='custom-icon-edit-custom'>"+
						"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
						"</div></td>";
	
				del = "<td><div onclick='geo_delete_function("+full.ID_OBJECT_MAP+");' class='custom-icon-delete-custom'>"+
						"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
						"</div></td>";*/
						date = "\'"+full.FECHA+"\'"
						eqst = "'"+full.QST+"'"
						user = "'"+full.NOMBRE_COMPLETO+"'"
				gra = '<td><div onclick="get_preg_resp('+full.ID_RES_CUESTIONARIO+'),get_position('+full.LATITUD+','+full.LONGITUD+','+date+','+eqst+','+user+')" class="custom-icon-copy">'+
						'<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
						'</div></td>';
	
				return '<table><tr>'+gra+'</tr></table>';
			}}	
		  ],
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
		$(document.body).css('cursor','default');	
		//}
 
	}	
//----------------------------
function get_preg_resp(idq){
	

		$("#geo_hidpr").val(idq);
		u = ($("#user").val() != -1)?$("#user").val():get_usr();
		i = $("#dti").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00";
		f = $("#dtf").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		scroll_table=($("#qstion").height()-145)+"px";
		//wtd = ($("#qst_main").width()*.45)+"px"
		qstTable = $('#geo_devd_table').dataTable({
		  "sScrollY": scroll_table,
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
		  "sAjaxSource": "index.php?m=geopuntos2&c=mPregresp&id="+idq,
		  "aoColumns": [
			{ "mData": "PREGUNTA", sDefaultContent: "" },
			{ "mData": "RESPUESTA", sDefaultContent: "" }
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
		$(document.body).css('cursor','default');	
 
	}		
//-----------------------------------------------------------
function get_usr(){
	us = "";
	$("#user option").each(function(){
		if($(this).val()!=-1){
			us += (us=="" )?$(this).val():","+$(this).val();
			}
		});
	return us;	
	}	
//-------------------------------------------------------------------------
function geo_nuevo(op,id){
	
	$.ajax({
		url: "index.php?m=geopuntos2&c=mGeopunto",
		type: "GET",
		data: {
			op : op,
			id : id
			},
		success: function(data) {
			var result = data; 
			//alert(op)
			
			
			$("#geo_dialog").dialog("open");
			if(op==1){$("#geo_dialog").dialog('option', 'title', 'Agregar Punto de inter\u00e9s');}
			if(op==2){$("#geo_dialog").dialog('option', 'title', 'Editar Punto de inter\u00e9s');}
			$('#geo_dialog').html(""); 
			$('#geo_dialog').html(result); 
				}
		});	
	}
//-----------------------------------------------------------------------
function geo_mapa(){
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     geo_map = new google.maps.Map(document.getElementById("geo_mapa"),mapOptions);
	
	}
//------------------------------------------------------------------------
function pgeo_gmapa(){
	$("#geo_location_map").height($("#geo_tabs").height()*0.9)
	$("#geo_location_map").html("Cargando...");
	setTimeout(function(){geo_gmapa()},5000)
	
	}
function geo_gmapa(){
	
	
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     geo_gmap = new google.maps.Map(document.getElementById("geo_location_map"),mapOptions);
	
	geocoder = new google.maps.Geocoder();
	
	google.maps.event.addListener(geo_gmap, 'click', function(e) {
		geo_clearOverlays();
		//alert(e.latlng)
		placeMarker(e.latLng, geo_gmap);
		//geo_gmap.setZoom(10);
		//geo_gmap.setCenter(e.latLng);
		

		
		});
	
	}	
//----------------------------------------------------------------
function placeMarker(position, map) {
	geo_clearOverlays();
	if (position){
		latitud  = position.lat();
		longitud = position.lng();
		autolatitud	= document.getElementById("dglat");
		autolatitud.innerHTML = '<html><input type="text" class="caja_date ui-corner-all" id="glat" value="'+latitud+'"></html>'
		autolongitud	= document.getElementById("dglon");
		autolongitud.innerHTML = '<html><input type="text" class="caja_date ui-corner-all" id="glon" value="'+longitud+'"></html>'
			}	
  var marker = new google.maps.Marker({
    position: position,
    map: map,
	zoom: 10,
	center: position
  });
  geof_marcadores.push(marker);
  geo_gmap.panTo(position);
}	
//-----------------------------------------------------------------
function geo_clearOverlays() {
  for (var i = 0; i < geof_marcadores.length; i++ ) {
    geof_marcadores[i].setMap(null);
  }
  //alert(poly.length);
  /*for (var i = 0; i < qst_poly.length; i++ ) {
    qst_poly[i].setMap(null);
  }*/
  //trayecto.setMap(null);
  //reiniciar variables
  //qst_points=[];
  qst_marcadores=[];
  //qst_poly=[];
}
//------------------------------------------------
function geo_main_clearOverlays(){
	for (var i = 0; i < gmain_mrk.length; i++ ) {
    gmain_mrk[i].setMap(null);
	}
	for (var i = 0; i < gmain_cir.length; i++ ) {
    gmain_cir[i].setMap(null);
	}  
	for (var i=0; i<gcir.length; i++){
		gcir[i].setMap(null);
		}
 
	}
//------------------------------------------------------------------------------------
function centra_mapa(lat,lon,dsc,nip,typ,rdo){
	geo_main_clearOverlays();
	var myLatlng = new google.maps.LatLng(lat,lon);	
	var data = '<table width="100%"><tr><td colspan="2" align="center" style="background:#4297D7; color:#EAF5F7;"><strong>Datos del Punto de inter\u00e9s</strong></td></tr><tr><td>Descripci&oacute;n:</td><td>'+dsc+'</td></tr><tr><td>NIP:</td><td>'+nip+'</td></tr><tr><td>Tipo:</td><td>'+typ+'</td></tr></table>';
	//Pintar marcador
	var image = 'public/images/Oficinas.png';
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: geo_map,
		icon : image,
		zoom: 8
		});
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(data);
		infoWindow.open(geo_map, marker);
		});	
	marker.setMap(geo_map);
	gmain_mrk.push(marker);
	//geof_marcadores.push(marker);
	//geo_map.panTo(myLatlng);
	//Pintar circunferencia
	var populationOptions = {
      strokeColor: '#003399',
      strokeOpacity: 0.5,
      strokeWeight: 2,
      fillColor: '#4D70B8',
      fillOpacity: 0.45,
      map: geo_map,
      center: myLatlng,
      radius: rdo
	  };
    geoCircle = new google.maps.Circle(populationOptions);
	
	geoCircle.setMap(geo_map);
	gmain_cir.push(marker);
	gcir.push(geoCircle);
	
	geo_map.setZoom(18);
	geo_map.setCenter(marker.getPosition());

	
	}
//-----------------------------------------------------------------------------
function get_position(lat,lon,fecha,qst,usr){
	//alert(geo_gmap)
	
	var myLatlng = new google.maps.LatLng(lat,lon);	
	var data = '<table width="100%"><tr><td colspan="2" align="center" style="background:#4297D7; color:#EAF5F7;"><strong>Datos de la evidencia</strong></td></tr><tr><td>Fecha:</td><td>'+fecha+'</td></tr><tr><td>Cuestionario:</td><td>'+qst+'</td></tr><tr><td>Usuario:</td><td>'+usr+'</td></tr></table>';
	//Pintar marcador
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: geo_map,
		
		zoom: 8
		});
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(data);
		infoWindow.open(geo_map, marker);
		});	
	marker.setMap(geo_map);
	geo_map.setZoom(18);
	geo_map.setCenter(marker.getPosition());
	
	}	
//-----------------------------------------------------------------------------
function change_idev(id){
	idev = id;
	}	
//-----------------------------------------------------------
function centra_punto(){
	var lon = document.getElementById("glon").value;
	var lat = document.getElementById("glat").value;
	if(lon != "" | lat  != ""){
		geo_clearOverlays();
		var myLatlng = new google.maps.LatLng(lat,lon);	
		//Pintar marcador
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: geo_gmap,
			zoom: 8
			});
		marker.setMap(geo_gmap);
		geof_marcadores.push(marker);
		geo_gmap.setZoom(18);
		geo_gmap.setCenter(marker.getPosition());
		//calcula_dir(lat,lon)
	}else{
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debes de ingresar latitud y longitud.</p>');
		$("#dialog-message" ).dialog('open');	
		//alert("Debes de ingresar latitud y longitud");
	}				
}	
//-----------------------------------------------------------
function calcula_dir(lat,lon){
	$.ajax({
		url: "index.php?m=geopuntos2&c=mAdd_GeoPuntosDireccion",
		type: "GET",
		data: {
			lat : lat,
			lon : lon
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#cnt_dir').html(result); 
				}
			}
		});			
}
//-----------------------------------------------------------
function showAddress(){
	geo_clearOverlays(); 
	var cp		= document.getElementById("gc_p").value;
	var calle		= document.getElementById("gstr").value;
	if(calle.length > 0){
	var idcol	    = document.getElementById("gcol").selectedIndex;
	var colonia   = document.getElementById("gcol").options[idcol].text;
	
	var idmun		= document.getElementById("gmun").selectedIndex;
	var municipio = document.getElementById("gmun").options[idmun].text;
	
	var ideo  	= document.getElementById("gedo").selectedIndex;
	var estado	= document.getElementById("gedo").options[ideo].text;
	
	var pais		= 'Mexico';
	var address 	= estado+","+municipio+","+colonia+","+calle;	
	
	 if (geocoder) {
		 geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
		  latitud  = results[0].geometry.location.lat();
		  longitud = results[0].geometry.location.lng();
		  autolatitud	= document.getElementById("dglat");
		  autolatitud.innerHTML = '<html><input type="text" class="caja_date ui-corner-all" id="glat" value="'+latitud+'"></html>'
		  autolongitud	= document.getElementById("dglon");
		  autolongitud.innerHTML = '<html><input type="text" class="caja_date ui-corner-all" id="glon" value="'+longitud+'"></html>'
        //In this case it creates a marker, but you can get the lat and lng from the location.LatLng
        geo_gmap.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: geo_gmap, 
            position: results[0].geometry.location
        });
		marker.setMap(geo_gmap);
		geof_marcadores.push(marker);
      } else {
        //alert("Geocode was not successful for the following reason: " + status);
      }
    });
		 }
	}else{
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de ingresar el nombre de la calle.</p>');
		$("#dialog-message" ).dialog('open');	
	}
	}	
	
//---------------------------------------------------------------------------------------------
function buscar_mun(id){
	if(id!=0){
	$.ajax({
		url: "index.php?m=geopuntos2&c=mMunicipio",
		type: "GET",
		data: {
			id  : id
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#dgmun').html(result); 
				}
			}
		});			
		}
	}
//--------------------------------------------------------------
function buscar_col(id){
	if(id!=0){
		ide = $("#gedo").val();
	$.ajax({
		url: "index.php?m=geopuntos2&c=mColonia",
		type: "GET",
		data: {
			id  : id,
			ide : ide
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#dgcol').html(result); 
				}
			}
		});			
		}
	}	
//---------------------------------------------------------
function lay(){
	var qst = $('#geo_qst_sel div').map(function() {
		return this.id;
		}).get();
	if(qst.length>0){
	qdata = "";	
	for (i=0; i<qst.length; i++){
		qdata += (qdata=="")?qst[i]:","+qst[i];
		}
	//alert(qdata+"/"+$("#geop").val()+"/"+$("#idg").val());
	$.ajax({
		url: "index.php?m=geopuntos2&c=mPayload",
		type: "GET",
		data: {
			lay : qdata,
			op	: $("#geop").val(),
			idg : $("#idg").val()
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#geo_tabs4').html(result); 
				}
			}
		});				
		}
	else{
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un cuestionario.</p>');
		$("#dialog-message" ).dialog('open');	
		}
	}	
//----------------------------------------------------------
function validar_datos(){
			
	
var ifs=0;	


if($('#gdsc').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}
	
/*if($('#gnip').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un NIP.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}*/
	
/*if($('#gres').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el nombre del responsable del PDI.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}*/	

/*if($('#gcor').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el correo electr\u00f3nico del responsable.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}*/

/*if($('#gcel').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el n\u00famero celular del responsable.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}*/

/*if($('#gtwt').val().length==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el twitter del responsable.</p>');
$("#dialog-message" ).dialog('open');		
$('a[href="#tabs1"]').trigger('click');
return false;
	}
	
if($('#gstr').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una calle o avenida.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}
	
if($('#gedo').val() == 0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un estado.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}		
	
if($('#gmun').val() == 0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un municipio.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}						

if($('#gcol').val() == 0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una colonia.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}	
	
if($('#gc_p').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un codigo postal.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}	
	
if($('#glat').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una latitud.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}		
	
if($('#glon').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una longitud.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs2"]').trigger('click');
return false;
	}	*/
	
var qst = $('#geo_qst_sel div').map(function() {
		return this.id;
		}).get();
/*if(qst.length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un cuestionario.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs3"]').trigger('click');
return false;
	}*/
	if(ifs==0){
	save_geo();
	}
	}	
//-------------------------------------------------------------------
function payload(div){
	var p ="";
		$('#t'+div+'').find(':input').each(function(index, element) {
			//p_r += this.id+"|"+this.value+"¬";
			if(this.value!=""){
				p += (p=="")?this.id+"¬"+this.value:"|"+this.id+"¬"+this.value;
				}
        });
	//alert(p);
	if(p==""){
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe contestar al menos una pregunta para generar QR.</p>');
		$("#dialog_message" ).dialog('open');
		}
	else{
		//alert (p)
		var url= "index.php?m=geopuntos2&c=mGenerarQr&cadena="+p;
				   window.location=url;
				   //window.open(url);
				  
		}	
		
	}	
//-------------------------------------------------------------------------------------------
function save_geo(){
	// set modal dialog
	$("#dialog_message").dialog( "option", "modal", true );	
	$('#dialog_message').html('<p align="center"><img src="public/images/cargando.gif" > Procesando datos.Espere un momento, por favor.</p>');
	$("#dialog_message").dialog('open');
	$("body").css("cursor", "progress");
	var p_r = "";
	c=0;
	
	$('#accordion div').each(function(index, element) {
        
		var id = this.id;
		p_r += id+"~";
		var p ="";
		$('#t'+id+'').find(':input').each(function(index, element) {
			//p_r += this.id+"|"+this.value+"¬";
			//p += (p=="")?this.id+"¬"+this.value:"|"+this.id+"¬"+this.value;
			if(p==""){
				if(this.value!=""){
					p = this.id+"¬"+this.value
					}
				}
			else{
				//alert(this.value)
				if(this.value!=""){
					p += "|"+this.id+"¬"+this.value
					}
				}	
        });
		/*if(c>0){
			p_r += "°";
			}
		c++;*/
		p_r += p;
		p_r += "^";
    });
	//alert(p_r);
	//alert(p_r.length)
	pr = p_r.substring(0, p_r.length-1);
	p_r = pr;
	//alert(p_r);
	var qst = $('#geo_qst_sel div').map(function() {
		return this.id;
		}).get();
	qdata = "";	
	for (i=0; i<qst.length; i++){
		qdata += (qdata=="")?qst[i]:","+qst[i];
		}
		//alert(qdata)
		//alert($("#qtxt").val())
		//
		//alert($("#gedo option:selected").text()+"/"+$("#gmun option:selected").text()+"/"+$("#gcol option:selected").text())
		//alert($("#qtxt").val())
		//alert($("#geop").val())
		var aes = ($("#gaes").is(':checked'))?'S':'N';
		var nen = ($("#gnen").is(':checked'))?'S':'N';
		var nsa = ($("#gnsa").is(':checked'))?'S':'N';
		var nat = ($("#gnat").is(':checked'))?'S':'N';
		var nvr = ($("#gnvr").is(':checked'))?'S':'N';

		var car = $('#geo_usr_sel div').map(function(){
		return this.id;
		}).get();
		car_data = "";
		for(i=0; i < car.length; i++){
			car_data += (car_data=="")?car[i]:','+car[i];
		}	
		
		//alert(aes+","+nen+","+nsa+","+nat+","+nvr);
		//alert(p_r)
		//alert($("#gnip").val());
		//alert($("#gact").val())
	$.ajax({
		url: "index.php?m=geopuntos2&c=mSave",
		type: "GET",
		data: {
			dsc : $("#gdsc").val(),
			typ : $("#gtyp").val(),
			nip : $("#gnip").val(),
			rdo : $("#grdo").val(),
			act : $("#gact").val(),
			str : $("#gstr").val(),
			edo : $("#gedo option:selected").text(),
			mun : $("#gmun option:selected").text(),
			col : $("#gcol option:selected").text(),
			c_p : $("#gc_p").val(),
			lat : $("#glat").val(),
			lon : $("#glon").val(),
			qst : qdata,
			txt : $("#qtxt").val(),
			p_r : p_r,
			res : $("#gres").val(), 
			cor : $("#gcor").val(),
			cel : $("#gcel").val(),
			twt : $("#gtwt").val(),
			op  : $("#geop").val(),
			
			aes : aes,
			nen : nen,
			nsa : nsa,
			nat : nat,
			nvr : nvr,
			
			car : car_data,
			
			id  : $("#idg").val()
			
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result>0){
				geo_load_datatable();
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#dialog_message" ).dialog('open');	
				$("#geo_dialog").dialog("close");
				}
			else{
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados.Vuelva a intentarlo.</p>');
				$("#dialog_message" ).dialog('open');	
				}	
			$("body").css("cursor", "default");
			}
		});
	}		
//------------------------------------------------------------------
function geo_delete_function(id){
	$("#geo_dialog_confirm").dialog({
		autoOpen:false,						
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Aceptar": function() {
				proceso_borrar(id);
				},
			"Cancel": function() {
				$("#geo_dialog_confirm").dialog( "close" );
				}
			}
		});
	if(id!=0){
        $('#geo_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el punto?</p>');
		$("#geo_dialog_confirm").dialog("open");
		//
		}	
				
}
//----------------------------------------
function proceso_borrar(id){
	$("#geo_dialog_confirm").dialog("close");
	//alert(id)
	$.ajax({
		url: "index.php?m=geopuntos2&c=mBorrar",
		type: "GET",
		data: {
			id : id
			},
		success: function(data) {
			
			var result = data;
			//alert(result) 
			if(result>0){
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El Punto de inter\u00e9s ha sido eliminado correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				geo_load_datatable();
				//$('#ev').html('');
				//$('#evc').html('');
				//map.setCenter(new GLatLng(21.698265,-103.447266), 5);
				//map.clearOverlays(); 
				}
			else{
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El geopunto no ha podido ser eliminado. Vuelva intentarlo.</p>');
				$("#dialog_message" ).dialog('open');
				}	
			}
		});	
	}	
//-----------------------------------------------------------
function geo_imp_for(){
	$.ajax({
		url: "index.php?m=geopuntos2&c=mImpform",
		type: "GET",
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#geo_dialog_import').dialog('open'); 
				$('#geo_dialog_import').html(result); 
				}
			}
		});		
	
	}	
//---------------- funcion que permite descargar archivo excel-plantilla

function geo_down_format()
{

   window.location="public/Descargas/Geopuntos/plantilla.xls";
}	
//-----------------------
function geo_down_formpay(){
	var idq = $("#geo_excel_idq").val();
	//alert(idq);
	var url= "index.php?m=geopuntos2&c=plantilla_payload&idq="+idq; 
	window.location=url;
	return false;
	//window.location="public/Descargas/Geopuntos/plantilla_payload.xlsx";
	
	}
//----------------------- funcion que envia el excel.
function geo_enviar_excel(){
	
	if($('#geo_excel').val()==""){			
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un archivo</p>');
		$("#dialog_message" ).dialog('open');
		$('#geo_excel').focus();
		return false;
	}
	else{
		$("#dialog_message").dialog({ title: "Cargando" });
		$('#dialog_message').html('<div class="demo"><div style="position:relative; width:60px; left:120px; "><img src="public/images/ajax_loader.gif" width="60" height="60" ><br/>Cargando...</div></div></div>');
		$("#dialog_message" ).dialog('open');
		
		//barra_progress();
	
		document.forms["geo_form"].submit();
		$("#geo_excel").val("");
		$("#dialog_message" ).dialog('close');		
		
		}
}	
//------------------------------------------------------------
function mensaje(g){
$("#geo_c_content2").html(g)
//document.getElementById('c_content2').innerHTML =g;	 
}
//------------------------------------------------------------
function geo_fedit_pr(){
	//alert("geo_fedit_pr");
	//alert($("#geo_hidpr").val());
	$.ajax({
		url: "index.php?m=geopuntos2&c=mPregrespE",
		type: "GET",
		data: {
			idq : $("#geo_hidpr").val()
			},
		success: function(data) {
			var result = data; 
			//alert(op)
			
			
			$("#geo_dialog_pr").dialog("open");
			$("#geo_dialog_pr").dialog('option', 'title', 'Editar Respuestas');
			$('#geo_dialog_pr').html(""); 
			$('#geo_dialog_pr').html(result); 
				}
		});	
	}

//--------------------------------------------------------------
function geo_buscador_usr(op,txt){
	//alert(txt)
	/*if(op==1){
		$("#geo_bscdr_ud").val("");
		}
	else{
		$("#geo_bscdr_us").val("");
		}*/
	//var div = (op==1)?'geo_usr_dsp':'geo_usr_sel';
	var div = (op==1)?'geo_usr_sel':'geo_usr_dsp';
	//alert(div);
	var geo_users = $('#'+div+' div').map(function() {
		return this.id;
		}).get();
	us = "";	
	for (i=0; i<geo_users.length; i++){
		us += (us == "")?geo_users[i]:","+geo_users[i];
		}
	$.ajax({
		url: "index.php?m=geopuntos2&c=mUsuario",
        type: "GET",
		data:{
			us : us,
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		if(op==1){
			$("#geo_usr_dsp").html(result);
			}
		else{
			$("#geo_usr_sel").html(result);
			}	
          }
      });	
	}		
//--------------------------------------------------------------
function geo_buscador_qst(op,txt){
	//alert(txt)
	/*if(op==1){
		$("#geo_bscdr_us").val("");
		}
	else{
		$("#geo_bscdr_ud").val("");
		}*/	
	//var div = (op==1)?'geo_usr_dsp':'geo_usr_sel';
	var div = (op==1)?'geo_qst_sel':'geo_qst_dsp';
	//alert(div);
	var geo_qst = $('#'+div+' div').map(function() {
		return this.id;
		}).get();
	q = "";	
	for (i=0; i<geo_qst.length; i++){
		q += (q == "")?geo_qst[i]:","+geo_qst[i];
		}
	$.ajax({
		url: "index.php?m=geopuntos2&c=mCuestionario",
        type: "GET",
		data:{
			q : q,
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		if(op==1){
			$("#geo_qst_dsp").html(result);
			}
		else{
			$("#geo_qst_sel").html(result);
			}	
          }
      });	
	}	
//--------------------------------------------------------------
function geo_imp_pay(idq){
	$("#geo_dialog_impay").dialog('option', 'title', 'Importar Payload');
	$.ajax({
		url: "index.php?m=geopuntos2&c=mImpay",
		type: "GET",
		data: {
			idq	: idq
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#geo_dialog_impay').dialog('open'); 
				$('#geo_dialog_impay').html(result); 
				}
			}
		});		
	}	
//--------------------------------------------------------------	
function geo_enviar_excel_pay(){
	if($('#geo_file_pay').val()==""){			
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione un archivo</p>');
		$("#dialog_message" ).dialog('open');
		$('#geo_file_pay').focus();
		return false;
	}
	else{
		$("#dialog_message").dialog( "option", "modal", true );	
		$('#dialog_message').html('<p align="center"><img src="public/images/cargando.gif" > Procesando datos.Espere un momento, por favor.</p>');
		$("#dialog_message").dialog('open');
		$("body").css("cursor", "progress");
		//$("#dialog_message").dialog({ title: "Cargando" });
		//$('#dialog_message').html('<div class="demo"><div style="position:relative; width:60px; left:120px; "><img src="public/images/ajax_loader.gif" width="60" height="60" ><br/>Cargando...</div></div></div>');
		$("#dialog_message" ).dialog('open');
		
		//barra_progress();
	
		document.forms["geo_excel_pay"].submit();
		$("#geo_file_pay").val("");
		$("#dialog_message" ).dialog('close');		
		$("body").css("cursor","default");
		}
}
//--------------------------------------------------------------	
function geo_exp(x){
	if(x==1){
		$.ajax({
			url: "index.php?m=geopuntos2/PHPExcleReader",
			type: "GET",
			success: function(data) {
				var result = data;
				console.log(result)
				geo_insertar_payload(result);
				}
			});		
		}
	}
//--------------------------------------------------------------	
function geo_insertar_payload(str){
	var mensaje = '';
		$.ajax({
			url: "index.php?m=geopuntos2&c=mSavePay",
			type: "POST",
			data: {
				str : str
				},
			success: function(data) {
				var result = data;
				console.log(result)
				
				var res = result.split("¬");
				if(res[0]==1){
					mensaje += 'Se almacenaron '+res[2]+' registros con &eacute;xito.<br>';
					error = res[1].split("|")
					//console.log(error.length);
					for(i=0; i<error.length; i++){
						if(error[i] != ""){
							mensaje += 'El punto de inter\u00e9s '+error[i]+' no existe. Los datos de este no fueron almacenados. Revise su archivo excel y vuelva a intentarlo.<br>';
							}
						}
					$("#geo_con_pay").html(mensaje);
					}
				//console.log(res[0])
				if(res[0] < 0 | res[0]!= 1){
					$("#geo_con_pay").html('Los datos no pudieron ser almacenados. Verifique su archivo de excel.');
					}
				/*else{
					$("#geo_con_pay").html('El payload no ha podido ser almacenado.');
					}*/
				}
			});		
	}