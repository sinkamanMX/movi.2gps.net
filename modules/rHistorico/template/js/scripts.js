var oTable;
var dTableDet;
var aReport;
var aTableEvt;
var aReportSummary = new Array();
var aReportHistory = new Array();
var aReportDet     = new Array();
var aTableHistorico = new Array();
var aTableEventos  = new Array();
var aEventSelected = new Array();
var map_rhi;
var nameUnit;
var poly = [];
var marcadores = [];
var info_a = new Array();
var infowindow;

$(document).ready(function(){
	$( "#rhi_search" ).button({
		icons: { primary: "ui-icon-search" }
	}).click(function() {
		rhiSearch()  		
	});

	$( "#rhi_exp_exe" ).button({
		icons: { primary: "ui-icon-document" }
	}).click(function() {
  		export_excel()
	}).addClass('invisible');

	$( "#rhi_dialog" ).dialog({
		autoOpen:false,
		title:"Detalle",
		modal: false,
		resizable: false,
		position: 'top',
        width       : $(window).width()-15,
        height      : $(window).height()-15,
		close: function() {
		  $('#rhiDialogEventos').removeClass('visible').addClass('invisible');
		}        
	});		

	//Dialog buscador
	$( "#rhi_dialog_search" ).dialog({
		autoOpen:false,
		position: 'top',
		title:"Buscar",
		modal: true,
		buttons: {
			Cancelar: function() { 				
				$( ".datepicker" ).datepicker( "destroy" )
    			$(this).dialog( "close" )
			},
			Buscar: function()   {  rhivalidateSearch() }			
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

	$( "#tabs_detalle" ).tabs({
	    select: function(event, ui){        
	        if(ui.index!=0){
	        	$('#rhiDialogEventos').removeClass('visible').addClass('invisible');
	        	rhiDrawTableDet()
	        }else{
	        	$('#rhiDialogEventos').removeClass('invisible').addClass('visible');
	        }
	    }
  	});	
	rhi_load_datatable();

	$.widget( "ui.combobox", {
	    _create: function() {
	        var self = this,
	            select = this.element.hide(),
	            selected = select.children( ":selected" ),
	            value = selected.val() ? selected.text() : "Select One...";
	        var input = this.input = $( "<input>" )
	            .insertAfter( select )
	            .val( value )
	            .autocomplete({
	                delay: 0,
	                minLength: 0,
	                source: function( request, response ) {
	                    var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
	                    response( select.children( "option" ).map(function() {
	                        var text = $( this ).text();
	                        if ( this.value && ( !request.term || matcher.test(text) ) )
	                            return {
	                                label: text.replace(
	                                    new RegExp(
	                                        "(?![^&;]+;)(?!<[^<>]*)(" +
	                                        $.ui.autocomplete.escapeRegex(request.term) +
	                                        ")(?![^<>]*>)(?![^&;]+;)", "gi"
	                                    ), "<strong>$1</strong>" ),
	                                value: text,
	                                option: this
	                            };
	                    }) );
	                },open: function () {
        				$(this).data("autocomplete").menu.element.width(265);
    				},
	                select: function( event, ui ) {
	                    ui.item.option.selected = true;
	                    self._trigger( "selected", event, {
	                        item: ui.item.option
	                    });
	                },
	                change: function( event, ui ) {
	                    if ( !ui.item ) {
	                        var matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( $(this).val() ) + "$", "i" ),
	                            valid = false;
	                        select.children( "option" ).each(function() {
	                            if ( $( this ).text().match( matcher ) ) {
	                                this.selected = valid = true;
	                                return false;
	                            }
	                        });
	                        if ( !valid ) {
	                            $( this ).val( "" );
	                            select.val( "" );
	                            input.data( "autocomplete" ).term = "";
	                            return false;
	                        }
	                    }
	                }
	            })
	            .addClass( "comboAutoComplete ui-widget" );

	        input.data( "autocomplete" )._renderItem = function( ul, item ) {
	            return $( "<li></li>" )
	                .data( "item.autocomplete", item )
	                .append( "<a>" + item.label + "</a>" )
	                .appendTo( ul );
	        };

	        this.button = $( "<button type='button'>&nbsp;</button>" )
	            .attr( "tabIndex", -1 )
	            .attr( "title", "Show All Items" )
	            .insertAfter( input )
	            .button({
	                icons: {
	                    primary: "ui-icon-triangle-1-s"
	                },
	                text: false
	            })
	            .removeClass( "ui-corner-all" )
	            .addClass( "ui-corner-right ui-button-icon" )
	            .click(function() {
	                if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
	                    input.autocomplete( "close" );
	                    return;
	                }

	                $( this ).blur();
	                input.autocomplete( "search", "" );
	                input.focus();
	            });
	    },

	    destroy: function() {
	        this.input.remove();
	        this.button.remove();
	        this.element.show();
	        $.Widget.prototype.destroy.call( this );
	    }
	});
}); 

function rhi_load_datatable(){
	scroll_table=($("#rhiTableData").height()-130)+"px";
	$('#rhi_table').dataTable({ 
		"sScrollY": scroll_table,
		"aaData" : aReportSummary,
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
			{ "mData": "", sDefaultContent: "" },
			{ "mData": "tMovimiento", sDefaultContent: "" },
			{ "mData": "tRalenti", sDefaultContent: "" },
			{ "mData": "tDetenido", sDefaultContent: "" },	
			{ "mData": "distancia", sDefaultContent: "" },
			{ "mData": "promedio", sDefaultContent: "" },
			{ "mData": "maxima", sDefaultContent: "" }
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
		"aoColumnDefs": [
		{"aTargets": [0],
		  "sWidth": "5%",
		  "bSortable": false,        
		  "mRender": function (data, type, full) {
		    var iconDetalle  = '';

			iconDetalle  = '<div onclick="rhiShowDetalle();" class="custom-icon-edit-custom">'+
                    '<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
                    '</div>';		   
		    return '<table><tr>'+iconDetalle+'</tr></table>';
		}}
		]
	});
}

function rhiSearch(){
	var startDateTextBox = $('#rhi_from');
	var endDateTextBox   = $('#rhi_to');

	var nowDate 	= new Date();
    var monthDate 	= (nowDate.getMonth() + 1) ;
    	monthDate 	= (monthDate <10 )  ? ("0"+monthDate) : monthDate;
    //var currentDate = nowDate.getFullYear()+"-"+ monthDate + '-' + nowDate.getDate();

    /*
CAMIASD
    */
    var currentDate = nowDate.getFullYear()+"-"+ monthDate + '-' + '19';
    var dateInit 	= currentDate+" 00:00"
    var dateFin 	= currentDate+" 23:59"

	$( "#rhi_dialog_search").dialog('open');
	$( "#rhi_from" ).datetimepicker( "option", "dayNamesMin", [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ] );
	$( "#rhi_from" ).datetimepicker( "option", "monthNames", [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Oktubre", "Noviembre", "Diciembre" ] );
	$( "#rhi_to" ).datetimepicker( "option", "dayNamesMin", [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ] );
	$( "#rhi_to" ).datetimepicker( "option", "monthNames", [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Oktubre", "Noviembre", "Diciembre" ] );
	
	$('#rhi_from').datetimepicker({
		showOn: "both",
		defaultDate: dateInit,
		maxDate: dateFin,
		dateFormat: "yy-mm-dd",
		buttonImage: "public/images/cal.gif",
		buttonImageOnly: true,
		currentText: 'Ahora',
		closeText: 'Listo',
		timeText: '',
		hourText: 'Hora',
		minuteText:'Minutos',	
		showHour: true,
		showMinute: true,	
		timeFormat: 'HH:mm',
		onClose: function(dateText, inst) {
			if (endDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate').getTime()
				var testEndDate = endDateTextBox.datetimepicker('getDate').getTime()
				if (testStartDate > testEndDate)
					endDateTextBox.datetimepicker('setDate', dateText);
			}
			else {
				endDateTextBox.datetimepicker('setDate', dateText);
			}
		},
		onSelect: function (dateText,selectedDateTime){
			var testEndDate = endDateTextBox.datetimepicker('getDate');
			var start = $(this).datetimepicker('getDate');
            endDateTextBox.datetimepicker('option', 'minDate', new Date(start.getTime()));	
			endDateTextBox.datetimepicker('setDate', testEndDate);
		}
	});
	
    $( "#rhi_to" ).datetimepicker({			
		showOn: "both",
		defaultDate: dateInit,
		maxDate: dateFin,
		dateFormat: "yy-mm-dd",
		buttonImage: "public/images/cal.gif",
		buttonImageOnly: true,
		currentText: 'Ahora',
		closeText: 'Listo',
		timeText: '',
		hourText: 'Hora',
		minuteText:'Minutos',
		showHour: true,
		showMinute: true,	
		timeFormat: 'HH:mm',
		onClose: function(dateText, inst){
			if (startDateTextBox.val() != '') {
				var testStartDate = startDateTextBox.datetimepicker('getDate').getTime()
				var testEndDate = endDateTextBox.datetimepicker('getDate').getTime()
				if (testStartDate > testEndDate)
					startDateTextBox.datetimepicker('setDate', dateText);
			}else {
				startDateTextBox.datetimepicker('setDate', dateText);
			}
		},
		onSelect: function (dateText,selectedDateTime){
			var testStartDate = startDateTextBox.datetimepicker('getDate');
			var start = $(this).datetimepicker('getDate');
			startDateTextBox.datetimepicker('option', 'maxDate', new Date(start.getTime()));
			startDateTextBox.datetimepicker('setDate', testStartDate);		
		}		
    });

   if($("#rhi_from").val() == '' && $("#rhi_to").val() == ''){
		$('#rhi_from').val(dateInit);
    	$('#rhi_to').val(dateFin);
	}
}

function getUnits(){
	var idGroup = $('#selgrupo').val();
	if(idGroup>0){
		$.ajax({
			url: "index.php?m=rHistorico&c=mGetUnits",
			type: "GET",
			dataType : 'json',
			data: {datagroup : idGroup },
			success: function(data) {
				var result =  data.items;
				$("#rhiUnits").find('option').remove().end();
				for (var i=0; i<result.length; i++) {
				  $("#rhiUnits").append('<option value="' + result[i].id + '">' + result[i].name + '</option>');
				} 

				$( "#rhiUnits" ).combobox();
			}		
		});	
	}
}

function rhivalidateSearch(){
	var fechaInicial	= 	$('#rhi_from').val();    	
	var fechaFinal		=   $('#rhi_to').val();
	var idGroup			=	$('#selgrupo').val();
	var idUnit			=	$('#rhiUnits').val();
	var errors=0;
	if(fechaInicial==""){
		errors++;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha inicial.</p>');
		$("#dialog_message" ).dialog('open');			
	}
	if(fechaFinal==""){
		errors++;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una fecha final.</p>');
		$("#dialog_message" ).dialog('open');			
	}
	if(idGroup<0){
		errors++;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un grupo.</p>');
		$("#dialog_message" ).dialog('open');			
	}
	if(idUnit<0){
		errors++;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una unidad.</p>');
		$("#dialog_message" ).dialog('open');			
	}

	if(errors>0){
		return false;
	}

	getSummary();
}

function getSummary(){
	aReportSummary   = [];
	aTableHistorico  = [];
	aTableEventos	 = [];	

	var fechaInicial	= 	$('#rhi_from').val();    	
	var fechaFinal		=   $('#rhi_to').val();
	var idGroup			=	$('#selgrupo').val();
	var idUnit			=	$('#rhiUnits').val();
	$( "#rhi_exp_exe" ).removeClass('visible').addClass('invisible');
	$.ajax({
		url : "index.php?m=rHistorico&c=mGetReport",
		type: 'GET',
		data: {
			idUnit	: idUnit,
			idGroup	: idGroup,
			fBegin	: fechaInicial,
			fEnd  	: fechaFinal  
		},
		success:function(data){
			var result = data;
			if(result!= "no-info"){
				$("#rhi_exp_exe").removeClass("invisible").addClass("visible");
				aReport=new Array();
				aReport=result.split('||');
				setSummaryTable();
			}		
		}
	});
}

function setSummaryTable(){
	aReportSummary   = [];
	aTableHistorico  = [];
	aTableEventos	 = [];
	var arraySummary = aReport[0].split("!");

	nameUnit  = arraySummary[6];
	aReportSummary = aReportSummary.concat({ 
		"distancia" :  	arraySummary[0]+" kms.", 
		"maxima" :  	arraySummary[1]+" km/h",
		"promedio"   :  arraySummary[2]+" km/h",
		"tMovimiento" : arraySummary[3],
		"tDetenido" :  	arraySummary[4],
		"tRalenti" :  	arraySummary[5]
	});	

	var arrayHistorico =  aReport[1].split("!");
	for (var i=0;i<arrayHistorico.length;i++){
		var infoHistorico = arrayHistorico[i].split('#');
		aTableHistorico = aTableHistorico.concat({ 
				"FECHA" :  infoHistorico[2], 
				"EVENT" :  infoHistorico[3],
				"VEL"   :  infoHistorico[4],
				"LATIT" :  infoHistorico[5],
				"LONGI" :  infoHistorico[6],
				"DIREC" :  infoHistorico[10]
		});
	}

	var arrayEventos =  aReport[2].split("!");
	for (var i=0;i<arrayEventos.length;i++){
		var infoEventos = arrayEventos[i].split('#');
		aTableEventos = aTableEventos.concat({ 
				"idEventos" 	:  infoEventos[0], 
				"Eventos" 		:  infoEventos[1],
				"totalEvetos"  	:  infoEventos[2]
		});
	}	

	$( "#rhi_dialog_search" ).dialog( "close" );	
	$( "#rhi_exp_exe" ).removeClass('invisible').addClass('visible');
	rhi_load_datatable();	
}

function rhiShowDetalle(){		
	$('#rhi_dialog').dialog('open');	

	$('#tabs_detalle').tabs('option', 'selected', 0);

	$(rhi_dialog).dialog('option', 'title', 'Unidad '+nameUnit);
	$( ".export_excel" ).button({
      icons: {
        primary: "ui-icon-document"
      }
	});	

	var latlng = new google.maps.LatLng(19.435113686545755,-99.13316173010253);
	var myOptions = {
		zoom: 4,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};

	map_rhi    = new google.maps.Map(document.getElementById("tabs_dMapa"), myOptions);
	infowindow = new google.maps.InfoWindow;	
	drawTableEvents();
		
	$('#rhiDialogEventos').removeClass('invisible').addClass('visible');
}

function drawTableEvents(){
	var counterEventos=1;
	var scroll_table=($("#rhiDialogEventos").height()-60)+"px";
	aTableEvt=$('#rhiEventstable').dataTable({ 
		"sScrollY": scroll_table,
		"aaData" : aTableEventos,
	    "bDestroy": true,
	    "bLengthChange": false,
	    "bPaginate": false,
	    "bFilter": false,
	    "bSort": true,
	    "bJQueryUI": true,
	    "bAutoWidth": false,
	    "bSortClasses": false,    
	    "aoColumns": [
			{ "mData": "totalEvetos", sDefaultContent: "" },
			{ "mData": "Eventos", sDefaultContent: "" },
			{ "sTitle": "<input type='checkbox' id='selectAll' onchange='getSelectedAll()'>", sDefaultContent: "" }
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
		"aoColumnDefs": [
			{"aTargets": [2],
			  "sWidth": "5%",
			  "bSortable": false,        
			  "mRender": function (data, type, full) {
			  	var iconDetalle  = '<input type="checkbox" name="rhiCheck" value="'+full.idEventos+'" checked onchange="getSelectedEvents()">';
			  	counterEventos++;
				return 	iconDetalle;
			}}
		]
	});

    setTimeout(function(){
        //aTableEvt.fnAdjustColumnSizing();
         rhiDrawTableMap();
    },5);	    
}

function getSelectedAll(){
	if($('#selectAll').attr('checked')){
		$('input', aTableEvt.fnGetNodes()).attr('checked','checked');
	}else{
		$('input', aTableEvt.fnGetNodes()).attr('checked',false);
	}	
	 rhiDrawTableMap();
}

function getSelectedEvents(){
	aEventSelected  = [];
    $("#rhiEventstable tr input:checked").each(function() {
			aEventSelected.push(parseInt(this.value));
    });
    rhiDrawTableMap();
}

function rhiDrawTableDet(){		
	var scrollTableDet =($("#tabs_detalle").height()-120)+"px";
	dTableDet =  $('#rhi_detcom_table').dataTable({ 
		"sScrollY": scrollTableDet,	
		"aaData" : aTableHistorico,
		"bDestroy": true,
		"bLengthChange": false,
		"bPaginate": false,
		"bFilter": true,
		"bSort": true,
		"bJQueryUI": true,
		"bAutoWidth": true,
		"bSortClasses": false, 
		"aoColumns": [
		  { "mData": "FECHA", sDefaultContent: "" },
		  { "mData": "EVENT", sDefaultContent: "" },
		  { "mData": "VEL", sDefaultContent: "" },
		  { "mData": "LATIT", sDefaultContent: "" },
		  { "mData": "LONGI", sDefaultContent: "" },		  
		  { "mData": "DIREC", sDefaultContent: "" }
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
    setTimeout(function(){
        dTableDet.fnAdjustColumnSizing();
    },10);	
}

function rhiDrawTableMap(){
	$("#tabs_tMapa").html('');
	var aReportDet = aReport[1].split("!");
	clearOverlays();
	if(aReportDet.length>0){
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
		
		for (var i=0;i<aReportDet.length;i++){	
			var infoDet = aReportDet[i].split('#');		
			var unitLatitude  	=  infoDet[5];
			var unitLong  		=  infoDet[6];
			var evento    		=  infoDet[3];
			var fecha     		=  infoDet[2];
			var velocidad		=  infoDet[4];
			var direccion    	=  infoDet[10];
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
			
			var colorCircle = '';
			var image = '';
			if(velocidad<5 && priory==0){
				colorCircle = '#CC0000';
				image = 'public/images/car_red.png';	
			}else if(velocidad>5 && priory==0){
				colorCircle = '#66CC33';
				image = 'public/images/car_green.png';	
			}else  if(priory==1){
				colorCircle = '#FF9900';
				image = 'public/images/car_orange.png';	
			}	
		
			var existeEvent = rhiFindEvento(infoDet[0]); 
			if(existeEvent>-1){
				var marker1 = new google.maps.Marker({
				    map: map_rhi,
					icon: {
					    path: google.maps.SymbolPath.CIRCLE,
					    fillOpacity: 0.5,
					    fillColor: colorCircle,
					    strokeOpacity: 1.0,
					    strokeColor: colorCircle,
					    strokeWeight: 3.0, 
					    scale: 5 //pixels
					  },
				    position: new google.maps.LatLng(unitLatitude,unitLong),
				    title: 	fecha
				});	
				marcadores.push(marker1);

				add_info_marker(marker1,info);

				var a_info= evento+"|"+fecha+"|"+velocidad+"|"+direccion;				

				$("<tr>"+				
					"<td onclick='hist_center_map("+unitLatitude+","+unitLong+",\""+a_info+"\""+",\""+fecha+"\",false);'>"+fecha+ "</td>"+
					"<td onclick='hist_center_map("+unitLatitude+","+unitLong+",\""+a_info+"\""+",\""+fecha+"\",false);'>"+evento+ "</td>"+
					"<td><div class='mon_units_info' onclick='hist_center_map("+unitLatitude+","+unitLong+",\""+a_info+"\""+",\""+fecha+"\",true)'>"+
					"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+"</div>"+				
					"</td></tr>")
				.appendTo(mon_table);
			}
		}

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

function rhiFindEvento(idEvent){	
	var indexOf=-1;
	var controlEventos=0;

    $("#rhiEventstable tr input:checked").each(function() {
		if(parseInt(idEvent) == parseInt(this.value) ){
			indexOf = controlEventos;
		}else{
		}
		controlEventos++;
    });
	return indexOf;
}
//---------------------------------------------------------------	
function clearOverlays() {
  for (var i = 0; i < marcadores.length; i++ ) {
    marcadores[i].setMap(null);
  }

  for (var i = 0; i < poly.length; i++ ) {
    poly[i].setMap(null);
  }
 
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

function hist_center_map(lat,lon,info,title,show_info){
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

function rhiExportExcel(){
	var fechaInicial	= 	$('#rhi_from').val();    	
	var fechaFinal		=   $('#rhi_to').val();
	var idGroup			=	$('#selgrupo').val();
	var idUnit			=	$('#rhiUnits').val();

	var url = "index.php?m=rHistorico&c=mGetReportExcel";
	var urlComplete = url + "&fBegin="+fechaInicial+"&fEnd="+fechaFinal+"&idUnit="+idUnit;
	window.location = urlComplete;
	return false;
}