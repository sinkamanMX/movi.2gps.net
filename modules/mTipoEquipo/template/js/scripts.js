var oTable;
var oTable2;
$(document).ready(function () {
	$( "#teq_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
	$( "#teq_dialog" ).dialog({
		autoOpen:false,
		title:"Editar",
		modal: true,
		height: 550,
		width:  700,
		buttons: {
		  Cancelar: function() {
			 $("#teq_dialog" ).dialog( "close" );
			},
      Aceptar: function() {
			   teq_validar_ed();
			}			
		}
	});	
	//Dialog generico		
	$( "#teq_dialog_nvo" ).dialog({
		autoOpen:false,
		title:"Nuevo",
		modal: true,
		buttons: {
      Cancelar: function() {
			   $("#teq_dialog_nvo" ).dialog( "close" );
      },
      Guardar: function() {
			   teq_validar_nvo();
			}			
		}
	});
		$( "#teq_dialog_message" ).dialog({
			autoOpen:false,
			modal: false,
			buttons: {
				Aceptar: function() {
					$("#teq_dialog_message" ).dialog( "close" );
				}
			}
		});
	teq_load_datatable_tequipos();
});
//--------------------------------- 
function teq_load_datatable_comandos(){
	teq_id=$("#teq_id").val();
	scroll_table=($("#teq_tabs_main").height()-180)+"px";
    oTable = $('#teq_comandos_table').dataTable({
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
      "sAjaxSource": "index.php?m=mTipoEquipo&c=mComando&teq_id="+teq_id,
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
        { "mData": "COD_EQUIPMENT_PROGRAM", sDefaultContent: "" },
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "QUANTITY_BYTES_SENT", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            //if($("#op_update").val()==1){
                //edit = '<td><span style="cursor:pointer" class="ui-icon ui-icon-pencil" onclick="comand_edit_function('+full.COD_EQUIPMENT_PROGRAM+');"></span></td>';
                edit = "<td><div onclick='comand_edit_function("+full.COD_EQUIPMENT_PROGRAM+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            //}
            
            //if($("#op_delete").val()==1){
                //del = '<td><span style="cursor:pointer" class="ui-icon ui-icon-trash" onclick="confirm_comand_delete_function('+full.COD_EQUIPMENT_PROGRAM+');"></span></td>';
                del = "<td><div onclick='confirm_comand_delete_function("+full.COD_EQUIPMENT_PROGRAM+");' class='custom-icon-delete-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            //}    

            return '<table><tr>'+edit+del+'</tr></table>';
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
// teq_load_datatable_tequipos
// --------------------------------
function teq_load_datatable_tequipos(){
	//alert($("#div_dad_teq").height());
	//alert($("#div_dad_teq").height()-180);
	scroll_table=($("#div_dad_teq").height()-130)+"px";
	//alert(scroll_table)
    oTable = $('#teq_tequipo_table').dataTable({
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
      "sAjaxSource": "index.php?m=mTipoEquipo&c=mTequipo",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "COD_TYPE_EQUIPMENT", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "DESCRIPTION", sDefaultContent: "" },
        { "mData": "PORT_DEFAULT", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';


            //if($("#op_update").val()==1){
                //edit = '<td><span style="cursor:pointer" class="ui-icon ui-icon-pencil" onclick="comand_edit_function('+full.COD_EQUIPMENT_PROGRAM+');"></span></td>';
                edit = "<td><div onclick='teq_edit_function("+full.COD_TYPE_EQUIPMENT+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            //}
            
            //if($("#op_delete").val()==1){
                //del = '<td><span style="cursor:pointer" class="ui-icon ui-icon-trash" onclick="confirm_comand_delete_function('+full.COD_EQUIPMENT_PROGRAM+');"></span></td>';
                del = "<td><div onclick='teq_delete_function("+full.COD_TYPE_EQUIPMENT+");' class='custom-icon-delete-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            //} 

            return '<table><tr>'+edit+del+'</tr></table>';
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
//---------------------------------
function teq_load_datatable_eventos(){
	//alert($("#teq_tabs_main").height());
	//alert($("#teq_tabs_main").height()-180);
	teq_id=$("#teq_id").val();
	scroll_table=($("#teq_tabs_main").height()-180)+"px";
	//alert(scroll_table)
    oTable = $('#teq_eventos_table').dataTable({
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
      "sAjaxSource": "index.php?m=mTipoEquipo&c=mEvento&teq_id="+teq_id,
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "COD_EVENT_EQUIPMENT", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "EVENT_REASON", sDefaultContent: "" },
        { "mData": "SEARCH_CODE", sDefaultContent: "" },
        { "mData": "QUANTITY_BYTES_RECEIVE", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "5%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';


            //if($("#op_update").val()==1){
                //edit = '<td><span style="cursor:pointer" class="ui-icon ui-icon-pencil" onclick="comand_edit_function('+full.COD_EQUIPMENT_PROGRAM+');"></span></td>';
                edit = "<td><div onclick='event_edit_function("+full.COD_EVENT_EQUIPMENT+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            //}
            
            //if($("#op_delete").val()==1){
                //del = '<td><span style="cursor:pointer" class="ui-icon ui-icon-trash" onclick="confirm_comand_delete_function('+full.COD_EQUIPMENT_PROGRAM+');"></span></td>';
                del = "<td><div onclick='confirm_event_delete_function("+full.COD_EVENT_EQUIPMENT+");' class='custom-icon-delete-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            //} 

            return '<table><tr>'+edit+del+'</tr></table>';
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
  
//--------------------------------
function teq_tpl_nuevo(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mAddTequipo",
          type: "GET",
          data: {  },
          success: function(data) {
            var result = data; 
            $('#teq_dialog_nvo').html('');
			$('#teq_dialog_nvo').html(result); 
            $('#teq_dialog_nvo').dialog('open');
          }
      });	
	}  
//--------------------------------
function teq_eve_tpl_nuevo(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mAddEventos",
          type: "GET",
          data: {  },
          success: function(data) {
            var result = data; 
            $('#teq_eve_dialog_nvo').html('');
			$('#teq_eve_dialog_nvo').html(result); 
            $('#teq_eve_dialog_nvo').dialog('open');
          }
      });	
	}  	
//--------------------------------
function teq_comand_tpl_nuevo(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mAddComando",
          type: "GET",
          data: {  },
          success: function(data) {
            var result = data; 
            $('#teq_com_dialog_nvo').html('');
			$('#teq_com_dialog_nvo').html(result); 
            $('#teq_com_dialog_nvo').dialog('open');
          }
      });	
	} 		
//--------------------------------	
function teq_edit_function(value){
	//alert("value");
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSetTequipo",
          type: "GET",
          data: { data: value },
          success: function(data) {
            var result = data; 
            $('#teq_dialog').html('');
            $('#teq_dialog').dialog('open');
            $('#teq_dialog').html(result); 
          }
      });
} 
//---------------------------------
function event_edit_function(value){
	//alert("value");
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSetEvento",
          type: "GET",
          data: { data: value },
          success: function(data) {
            var result = data; 
            $('#teq_eve_dialog_edt').html('');
            $('#teq_eve_dialog_edt').dialog('open');
            $('#teq_eve_dialog_edt').html(result); 
          }
      });
}
//---------------------------------
function comand_edit_function(value){
	//alert("value");
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSetComando",
          type: "GET",
          data: { data: value },
          success: function(data) {
            var result = data; 
            $('#teq_com_dialog_edt').html('');
            $('#teq_com_dialog_edt').dialog('open');
            $('#teq_com_dialog_edt').html(result); 
          }
      });
}
//---------------------------------
  function teq_delete_function(value){
	  //alert(value)
    $( "#teq_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          teq_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#teq_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#teq_dialog_confirm").dialog("open");

  }
//----------------------------------------
function teq_delete(x){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mDelTequipo",
          type: "GET",
          data: { 
		  teq_id:x
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#teq_dialog').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				teq_load_datatable_tequipos();
				}
			else{
				//alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//---------------------------------
 function confirm_event_delete_function(value){
	  //alert(value)
    $( "#teq_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          event_delete_function(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#teq_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#teq_dialog_confirm").dialog("open");

  }	
//----------------------------------------
  
function confirm_comand_delete_function(value){
	  //alert(value)
    $( "#teq_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          comand_delete_function(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#teq_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#teq_dialog_confirm").dialog("open");

  }	
//----------------------------------------
function comand_delete_function(x){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mDelComando",
          type: "GET",
          data: { 
		  com_id:x
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#teq_dialog').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				teq_load_datatable_comandos();
				}
			else{
				//alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//----------------------------------------	
function event_delete_function(x){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mDelEvento",
          type: "GET",
          data: { 
		  event_id:x
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#teq_dialog').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				teq_load_datatable_eventos();
				}
			else{
				alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//----------------------------------------
function teq_validar_ed(){
var ifs=0;	

if($('#teq_marc_edt').val()==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una marca </p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#teq_mode_edt').val()==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un modelo</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#teq_tcom_edt').val()==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tipo de comunicaci\u00f3n</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#teq_desc_edt').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}			
if($('#teq_port_edt').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un puerto por defecto</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}


if(ifs==0){
	teq_guardar_cambio();
	}
	
	
	
	}
//----------------------------------	
function eve_validar_nvo(){
var ifs=0;	

if($('#eve_nvo_rzn').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una raz\u00f3n del evento.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#eve_nvo_cod').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un c\u00f3digo de b\u00fasqueda.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#eve_nvo_byt').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un n\u00famero de bytes</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
	
if(ifs==0){
	eve_guardar_nvo();
	}	
	
	}	
//----------------------------------
function com_validar_nvo(){
var ifs=0;	

if($('#com_new_des').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n del comando.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#com_new_com').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un comando.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#com_new_byt').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un n\u00famero de bytes</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
	
if(ifs==0){
	com_guardar_nvo();
	}	
	
	}	
//----------------------------------
function com_validar_edt(){
var ifs=0;	

if($('#com_edt_des').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n del comando.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#com_edt_com').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un comando.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#com_edt_byt').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un n\u00famero de bytes</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
	
if(ifs==0){
	com_guardar_cambio();
	}	
	
	}		
//----------------------------------	
function eve_validar_edt(){
var ifs=0;	

if($('#eve_edt_rzn').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una raz\u00f3n del evento.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#eve_edt_cod').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un c\u00f3digo de b\u00fasqueda.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#eve_edt_byt').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un n\u00famero de bytes</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
	
if(ifs==0){
	eve_guardar_cambio();
	}	
	
	}	
//----------------------------------------
function teq_validar_nvo(){
var ifs=0;	

if($('#teq_marc_nvo').val()==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar una marca.</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#teq_mode_nvo').val()==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un modelo</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#teq_tcom_nvo').val()==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tipo de comunicaci\u00f3n</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
if($('#teq_desc_nvo').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}			
if($('#teq_port_nvo').val().length==0){
ifs=ifs+1;
$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un puerto por defecto</p>');
$("#teq_dialog_message" ).dialog('open');		
return false;
	}
		
	
if(ifs==0){
	teq_guardar_nvo();
	}	
	
	}	
//-----------------------------------
function teq_guardar_cambio(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSaveSetTequipo",
          type: "GET",
          data: { 
		  teq_mod: $("#teq_mode_edt").val(), 
		  teq_com: $("#teq_tcom_edt").val(),
		  teq_des: $("#teq_desc_edt").val(), 
		  teq_prt: $("#teq_port_edt").val(),
		  teq_id:  $("#teq_id").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#teq_dialog').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				teq_load_datatable_tequipos();
				}
			else{
				alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//-----------------------------------
function eve_guardar_cambio(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSaveSetEvento",
          type: "GET",
          data: { 
		  teq_rzn: $("#eve_edt_rzn").val(), 
		  teq_cod: $("#eve_edt_cod").val(),
		  teq_byt: $("#eve_edt_byt").val(), 
		  teq_id:  $("#event_id").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#teq_eve_dialog_edt').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				//teq_load_datatable_tequipos();
				teq_load_datatable_eventos();
				}
			else{
				alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//-----------------------------------
function com_guardar_cambio(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSaveSetComando",
          type: "GET",
          data: { 
		  com_des : $("#com_edt_des").val(), 
		  com_com : $("#com_edt_com").val(),
		  com_byt : $("#com_edt_byt").val(),
		  com_flg : $("#com_edt_flg").val(),
		  com_pas : $("#com_edt_pas").val(),
		  com_id  : $("#com_id").val(),
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#teq_com_dialog_edt').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				//teq_load_datatable_tequipos();
				teq_load_datatable_comandos();
				}
			else{
				alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}	
//-----------------------------------
function teq_guardar_nvo(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSaveAddTequipo",
          type: "GET",
          data: { 
		  teq_mod: $("#teq_mode_nvo").val(), 
		  teq_com: $("#teq_tcom_nvo").val(),
		  teq_por: $("#teq_port_nvo").val(), 
		  teq_des: $("#teq_desc_nvo").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#teq_dialog_nvo').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				//teq_load_datatable();
				teq_load_datatable_tequipos();
				}
			else{
				//alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}	
//--------------------------------	
function eve_guardar_nvo(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSaveAddEvento",
          type: "GET",
          data: { 
		  eve_rzn: $("#eve_nvo_rzn").val(), 
		  eve_cod: $("#eve_nvo_cod").val(),
		  eve_byt: $("#eve_nvo_byt").val(), 
		  teq_id:  $("#teq_id").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#teq_eve_dialog_nvo').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				//teq_load_datatable();
				//teq_load_datatable_tequipos();
				teq_load_datatable_eventos();
				}
			else{
				//alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//--------------------------------	
function com_guardar_nvo(){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mSaveAddComando",
          type: "GET",
          data: { 
		  com_des : $("#com_new_des").val(), 
		  com_com : $("#com_new_com").val(),
		  com_byt : $("#com_new_byt").val(),
		  com_flg : $("#com_new_flg").val(),
		  com_pas : $("#com_new_pas").val(),
		  teq_id  : $("#teq_id").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#teq_com_dialog_nvo').dialog('close');
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				//teq_load_datatable();
				//teq_load_datatable_tequipos();
				teq_load_datatable_comandos();
				}
			else{
				//alert(result);
				$('#teq_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#teq_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//--------------------------------
function teq_modelo(m){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mModelo",
          type: "GET",
          data: {
			  eqp_marca : m
			    },
          success: function(data) {
            var result = data; 
			//alert(result)
            $('#teq_div_modelo').html('');
			$('#teq_div_modelo').html(result); 
            //$('#eqp_dialog_nvo').dialog('open');
          }
      });	
	} 	
//--------------------------------
function teq_modelo_edt(m){
      $.ajax({
          url: "index.php?m=mTipoEquipo&c=mModelo_edt",
          type: "GET",
          data: {
			  eqp_marca : m
			    },
          success: function(data) {
            var result = data; 
			//alert(result)
            $('#teq_div_modelo_edt').html('');
			$('#teq_div_modelo_edt').html(result); 
            //$('#eqp_dialog_nvo').dialog('open');
          }
      });	
	} 	