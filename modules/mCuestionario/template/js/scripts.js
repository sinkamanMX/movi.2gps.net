var qstTable;
var data_qst_resp;
//var qst_preguntas;

//variables mapa
var map_qst;
var qst_points = [];
var qst_poly = [];
var qst_marcadores = [];
var qst_info_a = new Array();
var qst_lats = new Array();
var qst_lons = new Array();
var qst_trayecto;
var qst_infowindow;
//variables mapa

$(document).ready(function () {
	//crear botones
	$(".boton").button();
	//Cargar tabla principal
	qst_load_datatable();
	//Crear dialog grafica,respuestas,mapa
	w = window.innerWidth;
	h = window.innerHeight;
	//alert(w+"/"+h)
	$( "#qst_dialog_chart" ).dialog({
		autoOpen:false,
		title:"Estad\u00edstica",
		modal: true,
		width: w*0.55,
		height: h*0.75,
		
		/*buttons: {
			Cancelar: function() {
				$("#eqp_dialog" ).dialog( "close" );
			},
			Editar: function() {				
				eqp_validar_ed();
			}
		}*/
	});	
	//Crear dialog formulario
	$( "#qst_dialog_formu" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: w*0.35,
		height: h*0.75,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				val_all_pes();
			}
		}
	});
	//Crear dialog formulario agregar pregunta
	$( "#qst_dialog_formp" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 290,
		height: 335,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				val_data_preg();
			}
		}
	});	
	});
//----------------------------
function qst_load_datatable(){
	scroll_table=($("#qst_main").height()-125)+"px";
	wtd = ($("#qst_main").width()*.45)+"px"
    qstTable = $('#qst_table').dataTable({
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
      "sAjaxSource": "index.php?m=mCuestionario&c=mCuestionario",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_CUESTIONARIO", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "RESP", sDefaultContent: "","bSearchable": false }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			var gra   = '';

            edit = "<td><div onclick='qst_abrir_formulario("+full.ID_CUESTIONARIO+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='qst_delete_function("+full.ID_CUESTIONARIO+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
			gra = "<td><div onclick='qst_chart_function("+full.ID_CUESTIONARIO+");' class='custom-icon-copy'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";		

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
//------------------------------------------
function qst_load_table_rdts(){
	//alert(data_qst_resp)
	
	qst = $("#id_qst").val();
	st_dt = $("#start_date_resp").val()+" "+$("#hri_resp").val()+":"+$("#mni_resp").val()+":00";
	nd_dt = $("#end_date_resp").val()+" "+$("#hrf_resp").val()+":"+$("#mnf_resp").val()+":59";
	scroll_table=($("#qst_tabs").height()-180)+"px";
	//alert(scroll_table);
	//wtd = ($("#qst_main").width()*.45)+"px"
    qstTable = $('#qst_table_resp_dates').dataTable({
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
      //"sAjaxSource": "index.php?m=mCuestionario&c=mFechas&st_dt="+st_dt+"&nd_dt="+nd_dt+"&qst="+qst,
	  "aaData" :data_qst_resp,
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "IDRC"    , sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "FECHA"   , sDefaultContent: "" },
		{ "mData": "USR"     , sDefaultContent: ""  },
		{ "mData": "LATIT" , sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "LONGI", sDefaultContent: "","bSearchable": false,"bVisible":    false },
		{ "mData": "DIREC", sDefaultContent: "","bSearchable": false,"bVisible":    false }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "bSortable": false,        
          "mRender": function (data, type, full) {
			var gra   = '';
			fch = '"'+full.FECHA+'"';
			us  = '"'+full.USR+'"';
			dr  = '"'+full.DIREC+'"';
			gra = "<td><div onclick='qst_position("+fch+","+us+","+full.LATIT+","+full.LONGI+","+dr+");qst_load_preg_resp("+full.IDRC+");' class='custom-icon-copy'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";		

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
	}
//------------------------------------------
function qst_chart_function(c){
	      $.ajax({
          url: "index.php?m=mCuestionario&c=mEstadistica",
          type: "GET",
          data: {
			  cuestionario : c
			    },
          success: function(data) {
            var result = data; 
            $('#qst_dialog_chart').html('');
            $('#qst_dialog_chart').dialog('open');
			$('#qst_dialog_chart').html(result); 
          }
      });
	}
//-------------------------------------------
function select_all(sel){
	var s="";
	$('#'+sel+' option').each(function(i) {
		if(s==''){
			if($(this).val()!= -1){
				s=$(this).val();
				}
				//alert(s);
				}
				else{
					if($(this).val()!= -1){
						s+=','+$(this).val();
						}
					}
			});
		//alert(s);
		return s;
	}
//--------------------------------------------
function qst_tabla_resp_data(qst){
	
	st_dt = $("#start_date_resp").val()+" "+$("#hri_resp").val()+":"+$("#mni_resp").val()+":00";
	nd_dt = $("#end_date_resp").val()+" "+$("#hrf_resp").val()+":"+$("#mnf_resp").val()+":59";
	  //qst = $("#id_qst_gral").val;
	  
	  //alert(st_dt+"/"+nd_dt+"/"+qst);
	
	$.ajax({
		url: "index.php?m=mCuestionario&c=mFechas",
        type: "GET",
        //dataType : 'json',
		async : false,
        data: {
			st_dt : st_dt,
			nd_dt : nd_dt,
			qst : qst
			},
        success: function(data) {
			var result = data; 
			//alert(result)
            $('#div_qst_rsp_f').html('');
			$('#div_qst_rsp_f').html(result); 
			}
    });
	}
//--------------------------------------------
function qst_tabla_resp(){
	qstTable= $('#qst_table_resp').dataTable( { 
                "aaData" :data_qst_resp,               
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
				  { "mData": "IDRC"  ,  sDefaultContent: "","bSearchable": false,"bVisible": false},
                  { "mData": "FECHA" , sDefaultContent: "", "sWidth": "15%" },
                  { "mData": "DATOS" , sDefaultContent: "" },
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
                }/*,"aoColumnDefs": [
                  {"aTargets": [0],
                    "sWidth": "10%",
                    "bSortable": false,        
                    "mRender": function (data, type, full) {
                      return '<span id="'+full.IDS+'|'+full.IDE+'" class="ui-icon ui-icon-trash delEnqBtn"></span>';
                  }}
                ]*/
              });
	}	
//--------------------------------------------------------------------------	
function qst_mapa(){
	latlng = new google.maps.LatLng(19.435113686545755,-99.13316173010253);
	myOptions = {
		zoom: 3,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map_qst = new google.maps.Map(document.getElementById("qst_cnt_map_rsp"), myOptions);
	qst_infowindow = new google.maps.InfoWindow;
}	
//--------------------------------------------------------------------------
function qst_position(fecha,usr,lat,lon,dir){
	//alert(f)
clearOverlays();	

//direccion="direcci\u00f3n";
			 
			  //alert(data)
			  if(lat!=0 && lon!=0){

				   

				  //alert(record.DIRE)
				  var info 	  		= "<table><tr><td>Fecha :</td><td>"+fecha +"</td></tr><tr><td>Usuario:</td><td>"+usr+"</tr><tr><td>Direcci\u00f3n:</td><td>"+dir+"</td></tr></table>";
				  /*var info = '<div class="div_unit_info ui-widget-content ui-corner-all">'+
					'<div class="ui-widget-header ui-corner-all" align="center">Información de la Unidad</div>'+
				  			'<table><tr><th colspan="2">'+
				  			'<tr><td align="left">Fecha  :</td><td align="left">'	+ fecha	+'</td></tr>'+
							'<tr><td align="left">Usuario:</td><td align="left">'	+ usr	+'</td></tr>'+
							'<tr><td align="left">Dirección:</td><td align="left">'	+ direccion	+'</td></tr>'+
		  					'</table>'+
		  				'</div>';*/
				  /*if(index==0){
					  var last 			= "<table width='100%'><tr><td colspan='8' style='background:#cccccc'><b>&Uacute;ltima posici&oacute;n</b></td></tr><tr><td><b>Fecha: </b></td><td>"+fecha +"</td><td><b>Velocidad: </b></td><td>"+velocidad+" km/h</td><td><b>Latitud: </b></td><td>"+unitLatitude+"</td><td><b>Longitud: </b></td><td>"+unitLong+"</td></tr><tr><td><b>Direcci&oacute;n: </b></td><td colspan='7'>"+direccion+"</td></tr></table>";
										  if(o==1){
											  $("#ser_last_nvo").html(last).css("width","660px");
											  }
										  if(o==2){
											  $("#ser_last_edt").html(last).css("width","660px");
											  }
										  
					  }*/
				  
				  
				  qst_info_a.push(info);
				  qst_lats.push(lat);
				  qst_lons.push(lon);
				  qst_points.push(new google.maps.LatLng(lat, lon));
				  //var parliament = new google.maps.LatLng(19.435113686545755,-99.13316173010253);
				  var point = new google.maps.LatLng(lat,lon);
				  //var icon = "public/images/green_car.png";
				  var marker = new google.maps.Marker({
					  position: point, 
					  map: map_qst,
					  title: fecha,
					  //icon: icon
					  animation: google.maps.Animation.DROP,
					  //position: parliament
					  });
					  
				 var infowindow = new google.maps.InfoWindow({
					 content: info,
					 size: new google.maps.Size(200, 200)
					 });  
				  google.maps.event.addListener(marker, 'click', function() {
					  infowindow.open(map_qst,marker);
					  });
				  qst_marcadores.push(marker);
				  
				  //alert(points.length)
				  	  /*trayecto = new google.maps.Polyline({
					  path: points,
					  strokeColor: "#FF0000",
					  strokeOpacity: 1.0,
					  strokeWeight: 2
					  });

  trayecto.setMap(map_qst);
  poly.push(trayecto);*/
  var latlngbounds = new google.maps.LatLngBounds();
  	for ( var i = 0; i < qst_points.length; i++ ){
	    latlngbounds.extend( qst_points[ i ] );
  	}
 	//map.setCenter( latlngbounds.getCenter( ), map.getBoundsZoomLevel( latlngbounds ) );
	map_qst.fitBounds(latlngbounds);	
	map_qst.setCenter(latlngbounds.getCenter());
	
	
			  }
			  else{
				  /*if(op==1){
					  $("#ser_last_nvo").html("").css("width","0px");
					  }
				  if(op==2){
					  $("#ser_last_edt").html("").css("width","0px");
					  }*/
				  
				  var center = new google.maps.LatLng(19.435113686545755,-99.13316173010253);
				  map_qst.setCenter(center);
				  map_qst.setZoom(3);
				  google.maps.event.trigger(map_qst, "resize");
				  //$('#ser_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Sin datos disponibles para esta unidad.</p>');
				  //$("#ser_dialog_message" ).dialog('open');
				  }
		  
	}
//---------------------------------------------------------------	
function clearOverlays() {
  for (var i = 0; i < qst_marcadores.length; i++ ) {
    qst_marcadores[i].setMap(null);
  }
  //alert(poly.length);
  for (var i = 0; i < qst_poly.length; i++ ) {
    qst_poly[i].setMap(null);
  }
  //trayecto.setMap(null);
  //reiniciar variables
  qst_points=[];
  qst_marcadores=[];
  qst_poly=[];
}	
//---------------------------------------------------------------
function add_info_marker(marker,content){	
    google.maps.event.addListener(marker, 'click',function() {
      if(qst_infowindow){qst_infowindow.close();qst_infowindow.setMap(null);}
      var marker = this;
      var latLng = marker.getPosition();
      qst_infowindow.setContent(content);
      qst_infowindow.open(map_qst, marker);
      map_qst.setZoom(18);
	  map_qst.setCenter(latLng);      
	});
}
//-------------------------------------------------------------
function qst_center_map(lat,lon,info,title,show_info){
	var unit_info = info.split("|");	
	var info = '<br><div class="div_unit_info ui-widget-content ui-corner-all">'+
					'<div class="ui-widget-header ui-corner-all" align="center">Información de la Evidencia</div>'+
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
        map: 	map_qst,
        title: 	title,
        icon:   image,
    });

    marcadores.push(beachMarker);    
	if(infowindow){infoWindow.close();infowindow.setMap(null);}
		infowindow = new google.maps.InfoWindow({
	    content: info
	});
	
	if(show_info){infowindow.open(map_qst,beachMarker);map_qst.setZoom(18);}

	var positon = new google.maps.LatLng(lat, lon);
	/*if(show_info){map_qst.setZoom(18);}*/
	map_qst.setCenter(positon);	
}
//------------------------------------------
function qst_load_preg_resp(idrc){
	
	scroll_table=($("#qst_cnt_tbl_rsp").height()-75)+"px";
	//alert(scroll_table);
    qstTable = $('#qst_table_preg_resp').dataTable({
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
      "sAjaxSource": "index.php?m=mCuestionario&c=mPregResp&idrc="+idrc,
      "aoColumns": [
		{ "mData": "PREGUNTA"    , sDefaultContent: "" },
        { "mData": "RESPUESTA"   , sDefaultContent: "" }
      ] , 
      "oLanguage": {
          "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
          "sEmptyTable": "No hay registros.",
          "sInfoEmpty" : "No hay registros.",
          "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
          "sLoadingRecords": "Leyendo información",
          "sProcessing": "Procesando",
          "sSearch": "Buscar:",
          "sZeroRecords": "No hay registros"
      }
    }); 
	}
//-----------------------------------------------------------------------
function qst_abrir_formulario(q){
	      $.ajax({
          url: "index.php?m=mCuestionario&c=mFormulario",
          type: "GET",
          data: {
			  cuestionario : q
			    },
          success: function(data) {
            var result = data; 
			//$('#qst_dialog_formu').dialog( "destroy" );
            $('#qst_dialog_formu').html('');
            $('#qst_dialog_formu').dialog('open');
			$('#qst_dialog_formu').html(result); 
          }
      });
	}
//-------------------------------------------------------------------------
function validar_nombre_qst(n){
	$.ajax({
          url: "index.php?m=mCuestionario&c=mNcuestionario",
          type: "GET",
          data: {
			  qst : n
			    },
          success: function(data) {
            var result = data; 
			//alert(result);
			if(result>0){
				$("#qst_tit_val").html('<font color = "red">El cuestionario ya existe.</font>');
				}
			else{
				$("#qst_tit_val").html('');
				}	
          }
      });
	}
//-------------------------------------------------------------------------
function val_pes_pro(){
	var ifs = 0;

	if($("#qst_title").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un titulo del cuestionario.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if($("#qst_tit_val").html() != ""){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El cuestionario ya existe. Escriba un titulo diferente.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}		
	}
//---------------------------------------------------------------------------
function val_pes_tma(){
	var ifs = 0;

	if($("input[type='radio'][name='tema']:checked").val() === undefined){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tema.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	}
//------------------------------------------------------------------------
function val_all_pes(){
	var ifs = 0;

	if($("#qst_title").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un titulo del cuestionario.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
		
	if($("#qst_tit_val").html() != ""){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El cuestionario ya existe. Escriba un titulo diferente.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
		
	if($("input[type='radio'][name='tema']:checked").val() === undefined){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tema.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	
	var qst_preguntas = $('#qst_preg_sel div').map(function() {
		//alert(this.id)
		return this.id;
		//return $(this).val();
		}).get();	
	if(qst_preguntas.length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una o mas preguntas.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	
	var qst_users = $('#qst_user_sel div').map(function() {
		//alert(this.id)
		return this.id;
		//return $(this).val();
		}).get();	
	if(qst_users.length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un o mas usuarios.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
		
	if(ifs==0){
		qst_guardar_form($("#qst_op").val());
		}
		
		
	}	
//------------------------------------------------------------------------------
function qst_guardar_form(op){
	var mlt = ($('#qst_multi_resp').is(':checked'))?1:0;
	var off = ($('#qst_offline').is(':checked'))?1:0;
	//alert(mlt+"/"+off)
	var omlt = $('#qst_old_mlt').val();
	var ooff = $('#qst_old_off').val();
	
	var pre ="";
	var qst_preguntas = $('#qst_preg_sel div').map(function() {
		return this.id;
		}).get();	
	for(i=0; i<qst_preguntas.length; i++){
		pre = (pre=="")?qst_preguntas[i]:pre+","+qst_preguntas[i];
		}
		
	var usr = "";
	var qst_users = $("#qst_user_sel div").map(function(){
		return this.id;
		}).get();
	for(i=0; i<qst_users.length; i++){
		usr += (usr=="")?qst_users[i]:","+qst_users[i];
		}
		

		$.ajax({
          url: "index.php?m=mCuestionario&c=mSaveForm",
          type: "GET",
          data: {
			  tit : $("#qst_title").val(),
			  typ : $("#qst_type").val(),
			  mlt : mlt,
			  off : off,
			  tma : $("input[type='radio'][name='tema']:checked").val(),
			  pre : pre,
			  usr : usr,
			  op  : op,
			  idq : $("#qst_id").val(),
			  
			  otit : $("#qst_old_tit").val(),
			  otyp : $("#qst_old_typ").val(),
			  omlt : omlt,
			  ooff : ooff,
			  otma : $("#qst_old_tma").val(),
			  opre : $("#qst_old_pre").val(),
			  ousr : $("#qst_old_usr").val()
			    },
          success: function(data) {
            var result = data; 
			//alert(result);
			if(result>0){
				message = (op==1)?"El cuestionario ha sido almacenado satisfactoriamente.":"El cuestionario ha sido actualizado satisfactoriamente";
				$('#qst_dialog_formu').dialog('close');
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+message+'</p>');
				$("#dialog_message" ).dialog('open');
				qst_load_datatable();
				}
			else{
				message = (op==1)?"El cuestionario no ha sido almacenado. Vuelva a int\u00e9ntelo posteriormente.":"Los cambios en el cuestionario no han sido almacenados. Vuelva a int\u00e9ntelo posteriormente.";
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+message+'</p>');
				$("#dialog_message" ).dialog('open');
				}	
          }
      });
				

	}
//----------------------------------------------------
function form_preg(){
	      $.ajax({
          url: "index.php?m=mCuestionario&c=mFormulariop",
          type: "GET",
          success: function(data) {
            var result = data; 
			//$('#qst_dialog_formu').dialog( "destroy" );
            $('#qst_dialog_formp').html('');
            $('#qst_dialog_formp').dialog('open');
			$('#qst_dialog_formp').html(result); 
          }
      });
	}	
//-----------------------------------------------------
function selec_preg(p){
	$.ajax({
		url: "index.php?m=mCuestionario&c=mComplemento",
        type: "GET",
		data:{
			idt : p
			},
        success: function(data) {
        var result = data; 
			//$('#qst_dialog_formu').dialog( "destroy" );
            $('#qst_com_pre').html(result);
            //$('#qst_dialog_formp').dialog('open');
			//$('#qst_dialog_formp').html(result); 
          }
      });
	}
//-------------------------------------------------------
function radio_cercania(){
	radio = 0;	
	ra = '';

	for(r=1;r<1000;r++){
		radio = r * 10;
		if(radio<=1000){
			ra +='<option value="'+radio+'" >'+radio+'</option>';
			}
	 }
	$("#qst_com_pre").html('<form name="compts" id="compts"><p><select name="comp" id="qst_comp" class="caja">'+ra+'</select> mts. de radio de distancia</p></form>'); 		 
		
	}
//-----------------------------------------------------------------------------------------------------------------------//
function select_comple(x){
	if(x==1){
		$("#sis_t").html('<form name="compts" id="compts"><p><select name="comp" id="qst_comp" class="caja">'+
					 '<option value="$Fecha" selected="selected">Fecha</option>'+
					 '<option value="$Hora" >Hora</option>'+
					 '<option value="$IMEI" >IMEI</option>'+
					 '<option value="$Usuario" >Usuario</option>'+
				   '</select></p></form>');
	}else{
		$("#sis_t").html('<form name="compts" id="compts"><p><input type="text" id="qst_comp" class="caja_txt" /></p></form>');
		}	
	}	
//-----------------------------------------
function val_data_preg(){
	
	var ifs = 0;

  if($("#qst_tit_pre").val().length == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un titulo de pregunta.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  
   if($("#qst_typ_pre").val() == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tipo de pregunta.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
   }
	if($("[name='valid']").length){
	if($("[name='valid']").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el n\u00famero de caracteres permitidos.</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}
	} 
	
	if($("[name='coma']").length){
	if($("[name='coma']").val().length == 0){
		ifs=ifs+1;
		//alert('Debe escribir al menos un par de elementos separados por el car\u00e1cter ","');
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir al menos un par de elementos separados por el car\u00e1cter ",".</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}
	}	
	
	if($("[name='coma']").length){
	if( $("[name='coma']").val().indexOf(",") == -1){
		ifs=ifs+1;
		//alert('Debe separar cada elemento con el car\u00e1cter "," ');
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe separar cada elemento con el car\u00e1cter ",".</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}	
	}
	
	if($("[name='coma']").length){
		var cont=0;
		n=$("[name='coma']").val().split(",");
		for(var x=0; x<$("[name='coma']").val().split(",").length; x++){
			//alert('x:'+x+'n[x]:'+n[x]);
			if(n[x]=='' || n[x].length==0 ){
				cont++;
				}
			}
	if( cont > 0){
		ifs=ifs+1;
		//alert('Debe escribir un elemento despu\u00e9s del car\u00e1cter ","');
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un elemento despu\u00e9s del car\u00e1cter ",".</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}	
	}		
    
   if($("[name='url']").length){
		if( $("[name='url']").val().indexOf("http://") == -1){
			ifs=ifs+1;
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El campo Url no debe estar vacio y debe iniciar con "http://".</p>');
			$("#dialog_message" ).dialog('open');
			//alert('El campo Url no debe estar vacio y debe iniciar con "http://" ');
		  return false;
		}
	}
	
	
	if(ifs==0){
		qst_save_formp();
		}
}	
//------------------------------------------------------------------------
function qst_save_formp(){
	$.ajax({
		url: "index.php?m=mCuestionario&c=mSavePregunta",
        type: "GET",
		data:{
			tit : $("#qst_tit_pre").val(),
			typ : $("#qst_typ_pre").val(),
			act : $("#qst_act_pre").val(),
			rec : $("#qst_rec_pre").val(),
			req : $("#qst_req_pre").val(),
			com : $("#qst_comp").val()
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result==1){
			preguntas_seleccionadas();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La pregunta ha sido almacenda satisfactoriamente</p>');
			$("#dialog_message" ).dialog('open');
			$('#qst_dialog_formp').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El cuestionario no hasido almacenado. Vuelva a int\u00e9ntelo posteriormente.</p>');
			$("#dialog_message" ).dialog('open');
			}
          }
      });	
	}
//---------------------------------------------------------------------------
function preguntas_seleccionadas(){
	var qst_preguntas = $('#qst_preg_dsp div').map(function() {
		return this.id;
		}).get();
	pre="";	
	for (i=0; i<qst_preguntas.length; i++){
		pre += (pre=="")?qst_preguntas[i]:","+qst_preguntas[i];
		}
	$.ajax({
		url: "index.php?m=mCuestionario&c=mPreguntaS",
        type: "GET",
		data:{
			pre : pre
			},
        success: function(data) {
        var result = data;
		$("#qst_preg_sel").html(result);
          }
      });	
	}	
//--------------------------------------------------------------------
function isNumberKey(evt){
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
 
return true;
}	
//--------------------------------------------------------------------
function buscador_preguntas(op,txt){
	//alert(txt)
	if(op==1){
		$("#qst_bscdr_s").val("");
		}
	else{
		$("#qst_bscdr_d").val("");
		}	
	var div = (op==1)?'qst_preg_sel':'qst_preg_dsp';
	//alert(div);
	var qst_preguntas = $('#'+div+' div').map(function() {
		return this.id;
		}).get();
	pre="";	
	for (i=0; i<qst_preguntas.length; i++){
		pre += (pre=="")?qst_preguntas[i]:","+qst_preguntas[i];
		}
	$.ajax({
		url: "index.php?m=mCuestionario&c=mPreguntaS",
        type: "GET",
		data:{
			pre : pre,
			txt : txt
			},
        success: function(data) {
        var result = data;
		if(op==1){
			$("#qst_preg_dsp").html(result);
			}
		else{
			$("#qst_preg_sel").html(result);
			}	
          }
      });	
	}
//-------------------------------------------------------------------------
function qst_delete_function(q){
	  $( "#qst_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          qst_send_delete(q);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#qst_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar este cuestionario?</p>');
    $("#qst_dialog_confirm").dialog("open");		
	}
//-----------------------------------------------------------------------
function qst_send_delete(q){	
//alert(q)
      $.ajax({
          url: "index.php?m=mCuestionario&c=mDelCuestionario",
          type: "GET",
          data: { 
		  qst_id : q
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#eqp_dialog').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				qst_load_datatable();
				}
			else{
				//alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}	
          }
      });
	 }	
//--------------------------------------------------------------
function buscador_users(op,txt){
	//alert(txt)
	if(op==1){
		$("#qst_bscdr_us").val("");
		}
	else{
		$("#qst_bscdr_ud").val("");
		}	
	var div = (op==1)?'qst_user_sel':'qst_user_dsp';
	//alert(div);
	var qst_users = $('#'+div+' div').map(function() {
		return this.id;
		}).get();
	us = "";	
	for (i=0; i<qst_users.length; i++){
		us += (us == "")?qst_users[i]:","+qst_users[i];
		}
	$.ajax({
		url: "index.php?m=mCuestionario&c=mUsuario",
        type: "GET",
		data:{
			us : us,
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		if(op==1){
			$("#qst_user_dsp").html(result);
			}
		else{
			$("#qst_user_sel").html(result);
			}	
          }
      });	
	}	 