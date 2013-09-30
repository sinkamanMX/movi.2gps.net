var geof_marcadores = [];
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
	//DEFINIR BOTON
	$(".boton").button();
	//CARGAR TABLA GEOPUNTOS
	geo_load_datatable();
	//DECLARAR DIALOG NUEVO/EDICION
	$("#geo_dialog" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  800,
		height: 600,
		buttons: {
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
	//MAPA PRINCIPAL
	geo_mapa();
	
	});
//----------------------------
function geo_load_datatable(){
	//scroll_table=($("#qst_main").height()-125)+"px";
	//wtd = ($("#qst_main").width()*.45)+"px"
    qstTable = $('#geo_table').dataTable({
	  //"sScrollY": scroll_table,
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
function get_evidencias(){
	
	if(idev==-1){
		$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un geopunto.</p>');
		$("#dialog-message" ).dialog('open');	
		}
	else{
		u = ($("#user").val() != -1)?$("#user").val():get_usr();
		i = $("#dti").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00";
		f = $("#dtf").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		//scroll_table=($("#qst_main").height()-125)+"px";
		//wtd = ($("#qst_main").width()*.45)+"px"
		qstTable = $('#geo_evd_table').dataTable({
		  //"sScrollY": scroll_table,
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
		}
 
	}	
//----------------------------
function get_preg_resp(idq){

		u = ($("#user").val() != -1)?$("#user").val():get_usr();
		i = $("#dti").val()+" "+$("#hri").val()+":"+$("#mni").val()+":00";
		f = $("#dtf").val()+" "+$("#hrf").val()+":"+$("#mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		//scroll_table=($("#qst_main").height()-125)+"px";
		//wtd = ($("#qst_main").width()*.45)+"px"
		qstTable = $('#geo_devd_table').dataTable({
		  //"sScrollY": scroll_table,
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
	setTimeout(geo_gmapa(), 5000);
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
//------------------------------------------------------------------------------------
function centra_mapa(lat,lon,dsc,nip,typ,rdo){
	var myLatlng = new google.maps.LatLng(lat,lon);	
	var data = '<table width="100%"><tr><td colspan="2" align="center" style="background:#4297D7; color:#EAF5F7;"><strong>Datos del geopunto</strong></td></tr><tr><td>Descripci&oacute;n:</td><td>'+dsc+'</td></tr><tr><td>NIP:</td><td>'+nip+'</td></tr><tr><td>Tipo:</td><td>'+typ+'</td></tr></table>';
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
		calcula_dir(lat,lon)
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
		geocoder.getLatLng(
		address,
		function(latlng) {
		  if (!latlng) {
			  $('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se ha encontrado nada similar a: '+address+'</p>');
			  $("#dialog-message" ).dialog('open');	
			
		  } else {
			  latitud  = latlng.lat();
			  longitud = latlng.lng();
				autolatitud	= document.getElementById("dglat");
				autolatitud.innerHTML = '<html><input type="text" class="caja_date ui-corner-all" id="glat" value="'+latitud+'"></html>'
				autolongitud	= document.getElementById("dglon");
				autolongitud.innerHTML = '<html><input type="text" class="caja_date ui-corner-all" id="glon" value="'+longitud+'"></html>'
	
				/*gmap.setCenter(point, 16);
				var point = new GLatLng(latitud,longitud);				
				var marker = new GMarker(point);
				gmap.addOverlay(marker);
				marker.openInfoWindowHtml(address);*/
				//myPano.setLocationAndPOV(point);
				var myLatlng = new google.maps.LatLng(latitud,longitud);	
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
		  }
		}
	  );
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
	
if($('#gnip').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un NIP.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}
	
if($('#gres').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el nombre del responsable del PDI.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}	

if($('#gcor').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el correo electr\u00f3nico del responsable.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}

if($('#gcel').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el n\u00famero celular del responsable.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}

/*if($('#gtwt').val().length==0){
ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el twitter del responsable.</p>');
$("#dialog-message" ).dialog('open');		
$('a[href="#tabs1"]').trigger('click');
return false;
	}*/
	
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
	}	
	
var qst = $('#geo_qst_sel div').map(function() {
		return this.id;
		}).get();
if(qst.length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un cuestionario.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs3"]').trigger('click');
return false;
	}
	if(ifs==0){
	save_geo();
	}
	}	
	