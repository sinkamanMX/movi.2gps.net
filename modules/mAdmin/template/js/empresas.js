var oTable;
$(document).ready(function () {
  emp_load_datatable();
  $( "#emp_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  $( "#emp_dialog" ).dialog({
    autoOpen:false,
    title:"Editar",
    modal: true,
    buttons: {
      Cancelar: function() {
        $("#emp_dialog" ).dialog( "close" );
        },
      Editar: function() {
        emp_validar_nvo();
      }     
    }
  }); 
    $( "#emp_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      buttons: {
        Aceptar: function() {
          $("#emp_dialog_message" ).dialog( "close" );
        }
      }
    });
  
  
});  
function emp_load_datatable(){
    oTable = $('#emp_table').dataTable({
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
      "sAjaxSource": "index.php?m=mEmpresas&c=mGetTable",
      "aoColumns": [
      { "mData": " ", sDefaultContent: "" },
        { "mData": "ID_EMPRESA", sDefaultContent: "" },
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "ACTIVO", sDefaultContent: "" },
        { "mData": "CREADO", sDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
                edit = "<td><div onclick='emp_edit_function("+full.ID_EMPRESA+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";   
                del = "<td><div onclick='emp_delete_function("+full.ID_EMPRESA+");' class='custom-icon-delete-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>"; 
            var sel = "<td><div onclick='go_clientes("+full.ID_EMPRESA+");' class='custom-icon-select'>"+
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

function emp_edit_function(value){
      $.ajax({
          url: "index.php?m=mEmpresas&c=mGetRow",
          type: "GET",
          data: { data: value },
          success: function(data) {
            var result = data; 
            $('#emp_dialog').html('');
      		  $('#emp_dialog').html(result); 
            $('#emp_dialog').dialog('open');
          }
      }); 
}  

function emp_delete_function(value){
    $( "#emp_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          emp_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#emp_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#emp_dialog_confirm").dialog("open");

}

function emp_delete(value){
	$.ajax({
    	url: "index.php?m=mEmpresas&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data : value},
          success: function(data) {
	          var result = data.result; 

	          if(result=='no-data' || result=='problem'){
	              $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
	              $("#emp_dialog_message" ).dialog('open');             
	          }else if(result=='use'){ 
	              $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
	              $("#emp_dialog_message" ).dialog('open');       
	          }else if(result=='delete'){ 
	              $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
	              $("#emp_dialog_message" ).dialog('open');
	              emp_load_datatable();
	          }else if(result=='no-perm'){ 
	              $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
	              $("#emp_dialog_message" ).dialog('open');       
	          }
        }
      }); 
  }

	function emp_validar_nvo(){
		var errors=0;  

		if($('#emp_name').val().length==0){			
			$('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n de empresa</p>');
			$("#emp_dialog_message" ).dialog('open');   
			errors++;
  		}
		
		if($('#emp_rzon').val().length==0){
			$('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una raz\u00f3n social de la empresa</p>');
			$("#emp_dialog_message" ).dialog('open');   
			errors++;
  		}
		if($('#emp_rfc').val().length==0){
			$('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el RFC de la empresa</p>');
			$("#emp_dialog_message" ).dialog('open');   
			errors++;
		}
		if($('#emp_rep').val().length==0){
			$('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una representante legal</p>');
			$("#emp_dialog_message" ).dialog('open');   
			errors++;
		  }     
		if($('#emp_dir').val().length==0){
			$('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una direcci\u00f3n de la empresa</p>');
			$("#emp_dialog_message" ).dialog('open');   
			errors++;
		  }
		if($('#emp_tel').val().length==0){
			$('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el telefono de la empresa</p>');
			$("#emp_dialog_message" ).dialog('open');   
			errors++;
		  }   

    if($("#emp_mail").val()=="NULL" || $("#emp_mail").val()==""){
        $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                        '</span>Debe escribir un correo electrónico.</p>');
        $("#emp_dialog_message" ).dialog('open');  
        errors++;      
    }else{
      var validar = validar_email($("#emp_mail").val());
      if(!validar){ 
        $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                        '</span>Debe escribir un correo electrónico válido.</p>');
        $("#emp_dialog_message" ).dialog('open');  
        errors++;
      }      
    }         
  
		if(errors==0){ emp_send_row();  } 
	} 

	function emp_send_row(){
      $.ajax({
          url: "index.php?m=mEmpresas&c=mSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
  		      emp_des: $("#emp_name").val(), 
  		      emp_rzn: $("#emp_rzon").val(),
  		      emp_rfc: $("#emp_rfc").val(), 
  		      emp_dir: $("#emp_dir").val(),
  		      emp_rep: $("#emp_rep").val(), 
  		      emp_sta: $("#emp_estatus").val(),
  		      emp_tel: $("#emp_tel").val(),
  		      emp_id:  $("#emp_id").val(),
            emp_obs: $('#emp_obs').val(),
            emp_mail: $('#emp_mail').val()
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#emp_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#emp_dialog').dialog('close');
                $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#emp_dialog_message" ).dialog('open');
                emp_load_datatable();
            }else if(result=='no-perm'){ 
                $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#emp_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#emp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#emp_dialog_message").dialog('open');       
            }
          }
        });
	}


  function validar_email(valor){
        // creamos nuestra regla con expresiones regulares.
        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        // utilizamos test para comprobar si el parametro valor cumple la regla
        if(filter.test(valor))
            return true;
        else
            return false;
  }
