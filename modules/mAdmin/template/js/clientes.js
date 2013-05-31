var oTable;
$(document).ready(function () {
	cli_load_datatable();
	$( "#cli_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
	//Dialog generico		
	$( "#cli_dialog" ).dialog({
		autoOpen:false,
		title:"Editar",
		modal: true,
		width : 400,
		buttons: {
		Cancelar: function() {
			$("#cli_dialog" ).dialog( "close" );
			},
		Editar: function() {
			//alert("editar");
			cli_validar_ed();
			//$("#cli_dialog" ).dialog( "close" );
			}			
		}
	});	
	//Dialog generico		
	$( "#cli_dialog_nvo" ).dialog({
		autoOpen:false,
		title:"Nuevo",
		modal: true,
		width : 400,
		buttons: {
		Cancelar: function() {
			$("#cli_dialog_nvo" ).dialog( "close" );
			},
		Guardar: function() {
			//alert("editar");
			cli_validar_nvo();
			//$("#cli_dialog" ).dialog( "close" );
			}			
		}
	});
		$( "#cli_dialog_message" ).dialog({
			autoOpen:false,
			modal: false,
			buttons: {
				Aceptar: function() {
					$("#cli_dialog_message" ).dialog( "close" );
				}
			}
		});
	
	$("#gral_button_close").click(function() {
		location.href='index.php?m=login&c=login&md=lo';
	});	
});  
function cli_load_datatable(){
	var id_company = $("#global_id_company").val();
    oTable = $('#cli_table').dataTable({
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
      "sAjaxSource": "index.php?m=mClientes&c=adminCliente&id_company="+id_company,
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_CLIENTE", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "NOMBRE", sDefaultContent: "" },
        { "mData": "TELEFONO", sDefaultContent: "" },
        { "mData": "NOMBRE_CONTACTO", sDefaultContent: "" },
        { "mData": "ESTATUS", sDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
          	    edit = "<td><div onclick='cli_edit_function("+full.ID_CLIENTE+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";   
                del = "<td><div onclick='cli_delete_function("+full.ID_CLIENTE+");' class='custom-icon-delete-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>"; 
            	sel = "<td><div onclick='go_options("+full.ID_CLIENTE+");' class='custom-icon-select'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";
            	return '<table><tr>'+edit+del+sel+'</tr></table>';
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
function cli_tpl_nuevo(){
      $.ajax({
          url: "index.php?m=mClientes&c=mAddCliente",
          type: "GET",
          data: {  },
          success: function(data) {
            var result = data; 
            $('#cli_dialog_nvo').html('');
			$('#cli_dialog_nvo').html(result); 
            $('#cli_dialog_nvo').dialog('open');
          }
      });	
	}  
function cli_edit_function(value){
	//alert("value");
      $.ajax({
          url: "index.php?m=mClientes&c=mSetCliente",
          type: "GET",
          data: { data: value },
          success: function(data) {
            var result = data; 
            $('#cli_dialog').html('');
            $('#cli_dialog').dialog('open');
            $('#cli_dialog').html(result); 
          }
      });
} 

  function cli_delete_function(value){
	  //alert(value)
    $( "#cli_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          cli_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#cli_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#cli_dialog_confirm").dialog("open");

  }
//----------------------------------------
function cli_delete(x){
      $.ajax({
          url: "index.php?m=mClientes&c=mDelCliente",
          type: "GET",
          data: { 
		  cli_id:x
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#cli_dialog').dialog('close');
				$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#cli_dialog_message" ).dialog('open');
				cli_load_datatable();
				}
			else{
				alert(result);
				$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#cli_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//----------------------------------------
function cli_validar_ed(){

	var ifs=0;	

	if($('#cli_edt_name').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_rfc').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el RFC del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_rzon').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la raz\u00f3n social del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_tel').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el tel\u00e9fono del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_dir').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la direcci\u00f3n del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_con').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el nombre delcontacto del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_ema').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un e-mail del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}
	if($('#cli_edt_mov').val().length==0){
	ifs=ifs+1;
	$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un n\u00famero de movil del cliente</p>');
	$("#cli_dialog_message" ).dialog('open');		
	return false;
		}

	if($('#cli_edt_preg').val().length==0){
		ifs=ifs+1;
		$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de escribir la pregunta de validación.</p>');
		$("#cli_dialog_message" ).dialog('open');		
		return false;
	}
	if($('#cli_edt_resp').val().length==0){
		ifs=ifs+1;
		$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la respuesta de validación.</p>');
		$("#cli_dialog_message" ).dialog('open');		
		return false;
	}
	
	if(ifs==0){ cli_guardar_cambio();}		
	
	}
//----------------------------------------
function cli_validar_nvo(){
var ifs=0;	

if($('#cli_nvo_name').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_rfc').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el RFC del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_rzon').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la raz\u00f3n social del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_tel').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el tel\u00e9fono del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_dir').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la direcci\u00f3n del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_con').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el nombre delcontacto del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_ema').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un e-mail del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}
if($('#cli_nvo_mov').val().length==0){
ifs=ifs+1;
$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un n\u00famero de movil del cliente</p>');
$("#cli_dialog_message" ).dialog('open');		
return false;
	}							

	if($('#cli_edt_preg').val().length==0){
		ifs=ifs+1;
		$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de escribir la pregunta de validación.</p>');
		$("#cli_dialog_message" ).dialog('open');		
		return false;
	}
	if($('#cli_edt_resp').val().length==0){
		ifs=ifs+1;
		$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la respuesta de validación.</p>');
		$("#cli_dialog_message" ).dialog('open');		
		return false;
	}	
	
	if(ifs==0){cli_guardar_nvo();}	
	
	}	
//-----------------------------------
function cli_guardar_cambio(){
	var id_company = $("#global_id_company").val();
      $.ajax({
          url: "index.php?m=mClientes&c=adminSaveSetCliente",
          type: "GET",
          data: { 
          id_company : id_company,	
		  cli_des: $("#cli_edt_name").val(),
		  cli_rfc: $("#cli_edt_rfc ").val(),
		  cli_rzn: $("#cli_edt_rzon").val(),
		  cli_per: $("#cli_edt_per").val(),
		  cli_tel: $("#cli_edt_tel").val(),
		  cli_dir: $("#cli_edt_dir").val(),
		  cli_con: $("#cli_edt_con").val(),
		  cli_ema: $("#cli_edt_ema").val(),
		  cli_mov: $("#cli_edt_mov").val(),
		  cli_act: $("#cli_edt_act").val(),
		  cli_id:   $("#cli_id").val(),
		  cli_preg:	$('#cli_edt_preg').val(),
		  cli_resp:	$('#cli_edt_resp').val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#cli_dialog').dialog('close');
				$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#cli_dialog_message" ).dialog('open');
				cli_load_datatable();
				}
			else{
				alert(result);
				$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#cli_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//-----------------------------------
function cli_guardar_nvo(){
	var id_company = $("#global_id_company").val();	
      $.ajax({
          url: "index.php?m=mClientes&c=adminSaveAddCliente",
          type: "GET",
          data: { 
          id_company : id_company,	          	
		  cli_des: $("#cli_nvo_name").val(),
		  cli_rfc: $("#cli_nvo_rfc ").val(),
		  cli_rzn: $("#cli_nvo_rzon").val(),
		  cli_per: $("#cli_nvo_per").val(),
		  cli_tel: $("#cli_nvo_tel").val(),
		  cli_dir: $("#cli_nvo_dir").val(),
		  cli_con: $("#cli_nvo_con").val(),
		  cli_ema: $("#cli_nvo_ema").val(),
		  cli_mov: $("#cli_nvo_mov").val(),
		  cli_act: $("#cli_nvo_act").val(),
		  cli_preg:	$('#cli_edt_preg').val(),
		  cli_resp:	$('#cli_edt_resp').val()		  
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#cli_dialog_nvo').dialog('close');
				$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#cli_dialog_message" ).dialog('open');
				cli_load_datatable();
				}
			else{
				alert(result);
				$('#cli_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#cli_dialog_message" ).dialog('open');
				}	
          }
      });	
	}	