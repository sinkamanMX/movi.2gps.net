//--Variables
var rh_map;
var rh_gmap;
var rh_evdTable;
var rh_idev = -1;
var rhf_marcadores = [];
var rhmain_mrk = [];
var rhmain_cir = [];
var rhcir = [];
//-----------------------
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
	//MAPA PRINCIPAL
	rh_mapa();		
	//CARGAR TABLA GEOPUNTOS
	rh_load_datatable();
	rh_get_evidencias();
	//rh_get_preg_resp(-1);

	//DECLARAR DIALOG NUEVO/EDICION
	$("#rh_dialog" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  800,
		height: 600,
		buttons: {
			"Guardar": function(){
				rh_validar_datos();
				},
			"Cancelar": function(){
				if($("#rh_dialog" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#rh_dialog" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		});	
	});
//-----------------------------------------------------------------------
function rh_mapa(){
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     rh_map = new google.maps.Map(document.getElementById("rh_mapa"),mapOptions);
	
	}	
//--------------------------------------------------	
function rh_load_datatable(){
	scroll_table=($("#rh_main").height()-125)+"px";
    qstTable = $('#rh_table').dataTable({
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
      "sAjaxSource": "index.php?m=mRecursoH&c=mGet_Recurso",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_OBJECT_MAP", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "GEO", sDefaultContent: "" },
		{ "mData": "ITEM_NUMBER", sDefaultContent: "" },
        { "mData": "TYP", sDefaultContent: ""}
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "50px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			var gra   = '';

            edit = "<td><div onclick='rh_nuevo(2,"+full.ID_OBJECT_MAP+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='rh_delete_function("+full.ID_OBJECT_MAP+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
					gdsc = "\'"+full.GEO+"\'"
					gnip = "'"+full.ITEM_NUMBER+"'"
					gtyp = "'"+full.TYP+"'"
			gra = '<td><div onclick="rh_get_latlon('+full.ID_OBJECT_MAP+','+gdsc+','+gnip+','+gtyp+'),change_idrh('+full.ID_OBJECT_MAP+')" class="custom-icon-copy">'+
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
function rh_get_evidencias(){
	//alert("rh_get_evidencias")
	
	rh_get_preg_resp(-1);

		u = ($("#rh_user").val() != -1)?$("#rh_user").val():get_usr();
		i = $("#rh_dti").val()+" "+$("#rh_hri").val()+":"+$("#rh_mni").val()+":00";
		f = $("#rh_dtf").val()+" "+$("#rh_hrf").val()+":"+$("#rh_mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		scroll_table=($("#rh_qstion").height()-180)+"px";
		//alert(scroll_table)
		//wtd = ($("#qst_main").width()*.45)+"px"
		rh_evdTable = $('#rh_evd_table').dataTable({
		  "sScrollY": scroll_table,
		  "sScrollX": "100%",
		  "sScrollXInner": "120%",
		  "bScrollCollapse": true,
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
		  "sAjaxSource": "index.php?m=mRecursoH&c=mEvidencia&id="+rh_idev+"&usr="+u+"&dti="+i+"&dtf="+f,
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
				var gra   = '';
	

						date = "\'"+full.FECHA+"\'"
						eqst = "'"+full.QST+"'"
						user = "'"+full.NOMBRE_COMPLETO+"'"
				gra = '<td><div onclick="rh_get_preg_resp('+full.ID_RES_CUESTIONARIO+'),rh_get_position('+full.LATITUD+','+full.LONGITUD+','+date+','+eqst+','+user+')" class="custom-icon-copy">'+
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
//------------------------------------------------------------------------------------		
function get_usr(){
	us = "";
	$("#rh_user option").each(function(){
		if($(this).val()!=-1){
			us += (us=="" )?$(this).val():","+$(this).val();
			}
		});
	return us;	
	}		
//----------------------------
function rh_get_preg_resp(idq){
	

		$("#rh_hidpr").val(idq);
		u = ($("#rh_user").val() != -1)?$("#rh_user").val():get_usr();
		i = $("#rh_dti").val()+" "+$("#rh_hri").val()+":"+$("#rh_mni").val()+":00";
		f = $("#rh_dtf").val()+" "+$("#rh_hrf").val()+":"+$("#rh_mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		scroll_table=($("#rh_qstion").height()-145)+"px";
		//wtd = ($("#qst_main").width()*.45)+"px"
		qstTable = $('#rh_devd_table').dataTable({
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
		  "sAjaxSource": "index.php?m=mRecursoH&c=mPregresp&id="+idq,
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
//-------------------------------------------------------------------------
function rh_nuevo(op,id){
	$.ajax({
		url: "index.php?m=mRecursoH&c=mGeopunto",
		type: "GET",
		data: {
			op : op,
			id : id
			},
		success: function(data) {
			var result = data; 
			//alert(op)
			
			
			$("#rh_dialog").dialog("open");
			if(op==1){$("#rh_dialog").dialog('option', 'title', 'Agregar Recurso Humano');}
			if(op==2){$("#rh_dialog").dialog('option', 'title', 'Editar Recurso Humano');}
			$('#rh_dialog').html(""); 
			$('#rh_dialog').html(result); 
				}
		});	
	}	
//----------------------------------------------------------
function rh_validar_datos(){
	
var ifs=0;	


if($('#rhdsc').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}
	
if($('#rhnip').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un NIP.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}
	
if($('#rhcor').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el correo electr\u00f3nico del responsable.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}

if($('#rhcel').val().length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el n\u00famero celular del responsable.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#geo_tabs1"]').trigger('click');
return false;
	}

var rh_pdi = $('#rh_pdi_sel div').map(function() {
		return this.id;
		}).get();
if(rh_pdi.length==0){
ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un pdi.</p>');
$("#dialog_message" ).dialog('open');		
$('a[href="#rh_tabs2"]').trigger('click');
return false;
	}	

var cartera = $('#rh_usr_sel div').map(function() {
		return this.id;
		}).get();
if(cartera.length==0){
//ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El recurso humano ser\u00e1 almacenado sin usuarios asociados.</p>');
$("#dialog_message" ).dialog('open');		
//$('a[href="#geo_tabs3"]').trigger('click');

	}
	

	
var qst = $('#rh_qst_sel div').map(function() {
		return this.id;
		}).get();
if(qst.length==0){
//ifs=ifs+1;
$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El recurso humano ser\u00e1 almacenado sin cuestionarios asociados.</p>');
$("#dialog_message" ).dialog('open');		
//$('a[href="#geo_tabs3"]').trigger('click');

	}
	
	
	if(ifs==0){
	
	save_rh();
	}
	}	
//------------------------------------------------------------------------
function prh_gmapa(){
	$("#rh_location_map").height($("#rh_tabs").height()*0.9)
	$("#rh_location_map").html("Cargando...");
	//setTimeout(rh_gmapa(), 1000);
	rh_gmapa();
	}
function rh_gmapa(){
	
	
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     rh_gmap = new google.maps.Map(document.getElementById("rh_location_map"),mapOptions);
	

	
	}			

//---------------------------------------------------------
function rh_lay(){
	
	var qst = $('#rh_qst_sel div').map(function() {
		return this.id;
		}).get();
	if(qst.length>0){
	qdata = "";	
	for (i=0; i<qst.length; i++){
		qdata += (qdata=="")?qst[i]:","+qst[i];
		}
	//alert(qdata+"/"+$("#geop").val()+"/"+$("#idg").val());
	$.ajax({
		url: "index.php?m=mRecursoH&c=mPayload",
		type: "GET",
		data: {
			lay : qdata,
			op	: $("#rhop").val(),
			idg : $("#rh_idg").val()
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#rh_tabs4').html(result); 
				}
			}
		});				
		}
	else{
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un cuestionario.</p>');
		$("#dialog_message" ).dialog('open');	
		}
	}
//-------------------------------------------------------------------
function payload(div){
	var p ="";
		$('#t'+div+'').find(':input').each(function(index, element) {
			//p_r += this.id+"|"+this.value+"¬";
			p += (p=="")?this.id+"¬"+this.value:"|"+this.id+"¬"+this.value;
        });
	if(p==""){
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe contestar al menos una pregunta para generar QR.</p>');
		$("#dialog_message" ).dialog('open');
		}
	else{
		var url= "index.php?m=mRecursoH&c=mGenerarQr&cadena="+p;
				   window.location=url;
				  
		}	
		
	}	
//--------------------------------------------------------	
function rh_centra_punto(lat,lon){
	//var lon = document.getElementById("glon").value;
	//var lat = document.getElementById("glat").value;
	rh_clearOverlays();
	if(lon != 0 | lat  != 0){
		
		var myLatlng = new google.maps.LatLng(lat,lon);	
		//Pintar marcador
		var marker = new google.maps.Marker({
			position: myLatlng,
			map: rh_gmap,
			zoom: 8
			});
		marker.setMap(rh_gmap);
		rhf_marcadores.push(marker);
		rh_gmap.setZoom(18);
		rh_gmap.setCenter(marker.getPosition());
		//rh_calcula_dir(lat,lon)
	}else{
		var myLatlng = new google.maps.LatLng(19.435113686545755,-99.13316173010253);
		rh_gmap.setCenter(myLatlng);
		rh_gmap.setZoom(4);
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El PDI no cuenta con una geolocalizaci\u00f3n disponible</p>');
		$("#dialog_message" ).dialog('open');	
		//alert("Debes de ingresar latitud y longitud");
	}				
}	
//-----------------------------------------------------------------
function rh_clearOverlays() {
  for (var i = 0; i < rhf_marcadores.length; i++ ) {
    rhf_marcadores[i].setMap(null);
  }
  //alert(poly.length);
  /*for (var i = 0; i < qst_poly.length; i++ ) {
    qst_poly[i].setMap(null);
  }*/
  //trayecto.setMap(null);
  //reiniciar variables
  //qst_points=[];
  rhf_marcadores=[];
  //qst_poly=[];
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
//--------------------------------------------------------------------	
function save_rh(){
	$("body").css("cursor", "progress");
	var p_r = "";
	c=0;
	
	$('#accordion div').each(function(index, element) {
        
		var id = this.id;
		p_r += id+"~";
		var p ="";
		$('#t'+id+'').find(':input').each(function(index, element) {
			//p_r += this.id+"|"+this.value+"¬";
			p += (p=="")?this.id+"¬"+this.value:"|"+this.id+"¬"+this.value;
        });
		p_r += p;
		p_r += "^";
    });
	//alert(p_r);
	//alert(p_r.length)
	pr = p_r.substring(0, p_r.length-1);
	p_r = pr;
	//alert(p_r);
	var qst = $('#rh_qst_sel div').map(function() {
		return this.id;
		}).get();
	qdata = "";	
	for (i=0; i<qst.length; i++){
		qdata += (qdata=="")?qst[i]:","+qst[i];
		}
		
	var pdi = $('#rh_pdi_sel div').map(function() {
		return this.id;
		}).get();
	pdi_data = "";	
	for (i=0; i<pdi.length; i++){
		pdi_data += (pdi_data=="")?pdi[i]:","+pdi[i];
		}	
	
	var car = $('#rh_usr_sel div').map(function(){
		return this.id;
		}).get();
	car_data = "";
	for(i=0; i < car.length; i++){
		car_data += (car_data=="")?car[i]:','+car[i];
		}	
	
;
	$.ajax({
		url: "index.php?m=mRecursoH&c=mSave",
		type: "GET",
		data: {
			dsc : $("#rhdsc").val(),
			typ : $("#rhtyp").val(),
			nip : $("#rhnip").val(),

			qst : qdata,
			pdi : pdi_data,
			car : car_data,
			txt : $("#qtxt").val(),
			p_r : p_r,
			//res : $("#gres").val(), 
			cor : $("#rhcor").val(),
			cel : $("#rhcel").val(),
			twt : $("#rhtwt").val(),
			op  : $("#rhop").val(),
			

			
			id  : $("#rh_idg").val()
			
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result>0){
				rh_load_datatable();
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#dialog_message" ).dialog('open');	
				$("#rh_dialog").dialog("close");
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
function rh_delete_function(id){
	$("#rh_dialog_confirm").dialog({
		autoOpen:false,						
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Aceptar": function() {
				proceso_borrar_rh(id);
				},
			"Cancel": function() {
				$("#rh_dialog_confirm").dialog( "close" );
				}
			}
		});
	if(id!=0){
        $('#rh_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el recurso humano?</p>');
		$("#rh_dialog_confirm").dialog("open");
		//
		}	
				
}
//----------------------------------------
function proceso_borrar_rh(id){
	$("#rh_dialog_confirm").dialog("close");
	//alert(id)
	$.ajax({
		url: "index.php?m=mRecursoH&c=mBorrar",
		type: "GET",
		data: {
			id : id
			},
		success: function(data) {
			
			var result = data;
			//alert(result) 
			if(result>0){
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El geopunto ha sido eliminado correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				rh_load_datatable();

				}
			else{
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El geopunto no ha podido ser eliminado. Vuelva intentarlo.</p>');
				$("#dialog_message" ).dialog('open');
				}	
			}
		});	
	}	
//----------------------------
function validar_id_rh(){
	
	if(rh_idev==-1){
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un geopunto.</p>');
		$("#dialog_message" ).dialog('open');	
		}
	}	
//------------------------------------------------------------
function rh_get_latlon(idrh,dsc,nip,tip){
	$.ajax({
		url: "index.php?m=mRecursoH&c=mGetlatlon",
		type: "GET",
		data: {
			idrh : idrh
			},
		success: function(data) {
			var result = data; 
			//alert(result)
			var n=result.split(",");
			if(n[0] == 0 && n[1]== 0){
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El recurso  no cuenta con una geolalizaci\u00f3n.</p>');
				$("#dialog_message" ).dialog('open');
				}
			else{
				lat = n[0];
				lon = n[1];
				//alert(lat+"/"+lon)
				rh_centra_mapa(lat,lon,dsc,nip,tip);
				}	
			}
		});		
	}	
//-----------------------------------------------------------------------------
function change_idrh(id){
		$.ajax({
		url: "index.php?m=mRecursoH&c=mGetIdp",
		type: "GET",
		data: {
			idrh : id
			},
		success: function(data) {
			var result = data; 
			//alert(result)
			rh_idev = result;
			rh_get_evidencias();
			
			
			
				}
		});	
	
	}		
//------------------------------------------------------------------------------------
function rh_centra_mapa(lat,lon,dsc,nip,typ,rdo){
	//alert(lat,lon);
	rh_main_clearOverlays();
	var myLatlng = new google.maps.LatLng(lat,lon);	
	var data = '<table width="100%"><tr><td colspan="2" align="center" style="background:#4297D7; color:#EAF5F7;"><strong>Datos del geopunto</strong></td></tr><tr><td>Descripci&oacute;n:</td><td>'+dsc+'</td></tr><tr><td>NIP:</td><td>'+nip+'</td></tr><tr><td>Tipo:</td><td>'+typ+'</td></tr></table>';
	//Pintar marcador
	var image = 'public/images/Oficinas.png';
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: rh_map,
		icon : image,
		zoom: 8
		});
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(data);
		infoWindow.open(rh_map, marker);
		});	
	marker.setMap(rh_map);
	rhmain_mrk.push(marker);
	//geof_marcadores.push(marker);
	//geo_map.panTo(myLatlng);
	//Pintar circunferencia
	var populationOptions = {
      strokeColor: '#003399',
      strokeOpacity: 0.5,
      strokeWeight: 2,
      fillColor: '#4D70B8',
      fillOpacity: 0.45,
      map: rh_map,
      center: myLatlng,
      radius: rdo
	  };
    geoCircle = new google.maps.Circle(populationOptions);
	
	geoCircle.setMap(rh_map);
	rhmain_cir.push(marker);
	rhcir.push(geoCircle);
	
	rh_map.setZoom(18);
	rh_map.setCenter(marker.getPosition());

	
	}	
//------------------------------------------------
function rh_main_clearOverlays(){
	for (var i = 0; i < rhmain_mrk.length; i++ ) {
    rhmain_mrk[i].setMap(null);
	}
	for (var i = 0; i < rhmain_cir.length; i++ ) {
    rhmain_cir[i].setMap(null);
	}  
	for (var i=0; i<rhcir.length; i++){
		rhcir[i].setMap(null);
		}
 
	}	