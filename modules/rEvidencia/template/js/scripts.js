var rev_map;
var ide = -1;
var grados = 0;
$(document).ready(function () {
	//Pintar mapa
	rev_mapa();
	
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
	//Definir botnes exportar
	$( ".export" ).button({
      icons: {
        primary: "ui-icon-circle-arrow-s"
      },
      text: false
    })	
	
	//Obtener Evidencias
	rev_get_evidencias();
	
	//DECLARAR DIALOG NUEVO/EDICION
	$("#rev_dialog" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  800,
		height: 600,
		buttons: {
			"Guardar": function(){
				rev_validar_datos();
				},
			"Cancelar": function(){
				if($("#rev_dialog" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#rev_dialog" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		});	
	
	//DECLARAR DIALOG IMAGEN
	$("#rev_dialog_img" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		resizable: true,
		width:  800,
		height: 600,
		buttons: {
			"Guardar": function(){
				rev_save_img();
				},
			"Cancelar": function(){
				if($("#rev_dialog_img" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#rev_dialog_img" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		})	
	});
	
//-----------------------------------------------------------------------
function rev_mapa(){
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 4,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     rev_map = new google.maps.Map(document.getElementById("rev_mapa"),mapOptions);
	
	}
//----------------------------
function rev_get_evidencias(){
	//alert("rev_get_evidencias")
	
	rev_get_preg_resp(-1);
	
		u = ($("#rev_user").val() != -1)?$("#rev_user").val():get_usr();
		i = $("#rev_dti").val()+" "+$("#rev_hri").val()+":"+$("#rev_mni").val()+":00";
		f = $("#rev_dtf").val()+" "+$("#rev_hrf").val()+":"+$("#rev_mnf").val()+":00";
		
		$(document.body).css('cursor','wait');
		scroll_table=($("#revidencia").height()-172)+"px";
		qstTable = $('#rev_evd_table').dataTable({
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
		  "sAjaxSource": "index.php?m=rEvidencia&c=mEvidencia&usr="+u+"&dti="+i+"&dtf="+f,
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
				
				var imp = '';
	
				/*edit = "<td><div onclick='geo_nuevo(2,"+full.ID_OBJECT_MAP+");' class='custom-icon-edit-custom'>"+
						"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
						"</div></td>";
	
				del = "<td><div onclick='geo_delete_function("+full.ID_OBJECT_MAP+");' class='custom-icon-delete-custom'>"+
						"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
						"</div></td>";*/
						date = "\'"+full.FECHA+"\'"
						eqst = "'"+full.QST+"'"
						user = "'"+full.NOMBRE_COMPLETO+"'"
				gra = '<td><div onclick="rev_get_preg_resp('+full.ID_RES_CUESTIONARIO+'),rev_get_position('+full.LATITUD+','+full.LONGITUD+','+date+','+eqst+','+user+')" class="custom-icon-copy">'+
						'<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
						'</div></td>';
						
				imp = '<td><div onclick="rev_reporte_pdf('+full.ID_RES_CUESTIONARIO+','+date+','+eqst+','+user+')" >'+
						'<span class="ui-icon ui-icon-document" style="cursor:pointer;"></span>'+
						'</div></td>';		
						
				
	
				return '<table><tr>'+gra+imp+'</tr></table>';
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
//-----------------------------------------------------------
function get_usr(){
	us = "";
	$("#rev_user option").each(function(){
		if($(this).val()!=-1){
			us += (us=="" )?$(this).val():","+$(this).val();
			}
		});
	return us;	
	}	
//----------------------------
function rev_get_preg_resp(idq){
ide = idq;

		$(document.body).css('cursor','wait');
		scroll_table=($("#rev_det").height()-95)+"px";
		//wtd = ($("#qst_main").width()*.45)+"px"
		qstTable = $('#rev_devd_table').dataTable({
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
		  "sAjaxSource": "index.php?m=rEvidencia&c=mPregresp&id="+idq,
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
//-----------------------------------------------------------------------------
function rev_get_position(lat,lon,fecha,qst,usr){
	//alert(geo_gmap)
	var myLatlng = new google.maps.LatLng(lat,lon);	
	var data = '<table width="100%"><tr><td colspan="2" align="center" style="background:#4297D7; color:#EAF5F7;"><strong>Datos de la evidencia</strong></td></tr><tr><td>Fecha:</td><td>'+fecha+'</td></tr><tr><td>Cuestionario:</td><td>'+qst+'</td></tr><tr><td>Usuario:</td><td>'+usr+'</td></tr></table>';
	//Pintar marcador
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: rev_map,
		zoom: 8
		});
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(data);
		infoWindow.open(rev_map, marker);
		});	
	rev_map.setZoom(18);	
	marker.setMap(rev_map);
	rev_map.setCenter(marker.getPosition());
	
	}	
///----------------------------------------------------------------------------	
function rev_reporte_pdf(id,date,qst,usr){
	//alert(id+","+date+","+qst+","+usr);
	
	    var url= "index.php?m=rEvidencia&c=Reporte_pdf&id="+id+"&date="+date+"&qst="+qst+"&usr="+usr;
		window.location=url;
		//return false;
}
//-------------------------------------------------------------------------
function rev_opn_form(){
	$.ajax({
		url: "index.php?m=rEvidencia&c=mExport_Form",
		type: "GET",
		success: function(data) {
			var result = data; 
			//alert(op)
			
			
			$("#rev_dialog").dialog("open");
			$('#rev_dialog').html(""); 
			$('#rev_dialog').html(result); 
				}
		});		
	}
//-------------------------------------------------------------------------
function rev_validar_datos(){
	var ifs = 0;
	
	var dti = $("#rev_xdti").val()+" "+$("#rev_xhri").val()+":"+$("#rev_xmni").val()+":00";
	var dtf = $("#rev_xdtf").val()+" "+$("#rev_xhrf").val()+":"+$("#rev_xmnf").val()+":59";
	
	if(dti>dtf){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La fecha final debe ser mayor a la fecha inicial.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}	
	
	var qst = $('#rev_qst_sel div').map(function() {
		return this.id;
		}).get();
	if(qst.length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un cuestionario.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
		
	var usr = $('#rev_usr_sel div').map(function() {
		return this.id;
		}).get();
	if(usr.length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar al menos un usuario.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}	
	
	if(ifs==0){
		var u = "";
		var q = "";
		
		for(i=0; i<usr.length; i++){
			u += (u=="")?usr[i]:","+usr[i];
			}

		for(i=0; i<usr.length; i++){
			q += (q=="")?qst[i]:","+qst[i];
			}		
		
		rev_export_excel(dti,dtf,u,q);
		}
	}
	
//-------------------------------------------------------------------------------
function rev_export_excel(dti,dtf,u,q){
	var url= "index.php?m=rEvidencia&c=Reporte_excelM&f1="+dti+"&f2="+dtf+"&usuarios="+u+"&cuestionario="+q; 
	window.location=url;
	return false;
	}
//---------------------------------------
function rev_ver_img(img,id){
	//alert(id)
	$.ajax({
		url: "index.php?m=rEvidencia&c=mImage",
		data : {
			img:img,
			id:id
			},
		type: "GET",
		success: function(data) {
			var result = data; 
			//alert(op)
			
			
				$("#rev_dialog_img").dialog("open");
				$('#rev_dialog_img').html(""); 
				$('#rev_dialog_img').html(result); 
				
				}
		});		
	//alert(img);

	}	
//-------------------------------------------------
function validar_id(){}
//-------------------------------------------------
function rev_save_img(){
	//alert($("#rev_grd_val").val())
	$.ajax({
		url: "index.php?m=rEvidencia&c=mSaveImg",
		data : {
			img : $("#rev_src_val").val(),
			grd : $("#rev_grd_val").val()
			},
		type: "GET",
		success: function(data) {
			var result = data; 
			//alert(result)
			if(result==1){
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La imagen ha sido almacenada correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				//alert(ide)
				rev_get_preg_resp(ide);
				$("#rev_dialog_img").dialog("close");
				}
			else{
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La imagen no ha podido ser almacenada.</p>');
				$("#dialog_message" ).dialog('open');		
				}	
			}
		});		

	}