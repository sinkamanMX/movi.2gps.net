var rev_map;
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
	//Obtener Evidencias
	rev_get_evidencias();
	
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
		scroll_table=($("#revidencia").height()-145)+"px";
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


		$(document.body).css('cursor','wait');
		scroll_table=($("#revidencia").height()-100)+"px";
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
	alert(id+","+date+","+qst+","+usr);
	
	    var url= "index.php?m=rEvidencia&c=Reporte_pdf&id="+id+"&date="+date+"&qst="+qst+"&usr="+usr;
		window.location=url;
		//return false;
}
	