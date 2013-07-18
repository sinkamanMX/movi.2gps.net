var oTable;
$(document).ready(function () {
	
	eqp_load_datatable();
	$( "#eqp_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
	//Dialog generico		
	$( "#eqp_dialog" ).dialog({
		autoOpen:false,
		title:"Editar",
		modal: true,
		position: { my: "center", at: "top",within : window},		
		buttons: {
		Cancelar: function() {
			$("#eqp_dialog" ).dialog( "close" );
			},
		Editar: function() {
			//alert("editar");
			eqp_validar_ed();
			//$("#eqp_dialog" ).dialog( "close" );
			}			
		}
	});	
	//Dialog generico		
	$( "#eqp_dialog_nvo" ).dialog({
		autoOpen:false,
		title:"Nuevo",
		modal: true,
		position: { my: "center", at: "top",within : window},
		buttons: {
		Cancelar: function() {
			$("#eqp_dialog_nvo" ).dialog( "close" );
			},
		Guardar: function() {
			//alert("editar");
			eqp_validar_nvo();
			//$("#eqp_dialog" ).dialog( "close" );
			}			
		}
	});
		$( "#eqp_dialog_message" ).dialog({
			autoOpen:false,
			modal: false,
			buttons: {
				Aceptar: function() {
					$("#eqp_dialog_message" ).dialog( "close" );
				}
			}
		});
	
	
});  
function eqp_load_datatable(){
    scroll_table=($("#untsTablePrincipal").height()-120)+"px";	
    var client = $("#global_id_client").val();
    oTable = $('#eqp_table').dataTable({
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
      "sAjaxSource": "index.php?m=mUnidades&c=adminEquipo&id_client="+client,
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "COD_ENTITY", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "UNIDAD", sDefaultContent: "" },
        { "mData": "PLAQUE", sDefaultContent: "" },
        { "mData": "SERIE", sDefaultContent: "" },
        { "mData": "IP", sDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            edit = "<td><div onclick='eqp_edit_function("+full.COD_ENTITY+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='eqp_delete_function("+full.COD_ENTITY+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
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
function eqp_tpl_nuevo(){
    var client = $("#global_id_client").val();  
    var company = $("#global_id_company").val();         	
      $.ajax({
          url: "index.php?m=mUnidades&c=adminAddEquipo",
          type: "GET",
          data: { id_client :client ,id_company:company},
          success: function(data) {
            var result = data; 
            $('#eqp_dialog_nvo').html('');
			$('#eqp_dialog_nvo').html(result); 
            $('#eqp_dialog_nvo').dialog('open');
          }
      });	
	}  
function eqp_edit_function(value){
    var client = $("#global_id_client").val(); 
	var company = $("#global_id_company").val();  
      $.ajax({
          url: "index.php?m=mUnidades&c=adminSetEquipo",
          type: "GET",
          data: { data: value ,id_client :client ,id_company:company},
          success: function(data) {
            var result = data; 
            $('#eqp_dialog').html('');
            $('#eqp_dialog').dialog('open');
            $('#eqp_dialog').html(result); 
          }
      });
} 

  function eqp_delete_function(value){
    $( "#eqp_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          eqp_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#eqp_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#eqp_dialog_confirm").dialog("open");

  }
//----------------------------------------
function eqp_delete(x){
    var client = $("#global_id_client").val();  
    var company = $("#global_id_company").val();   	
	//alert(x)
      $.ajax({
          url: "index.php?m=mUnidades&c=mDelEquipo",
          type: "GET",
          data: { 
		  	eqp_id : x,
		    id_client: client,
            id_company:company
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#eqp_dialog').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				eqp_load_datatable();
				}
			else{
				alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//----------------------------------------
function eqp_validar_ed(){

var ifs=0;	

if($('#eqp_edt_mar').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar la marca de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_mod').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el modelo de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_tip').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el tipo de unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_cli').val()<0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_des').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_pla').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir las placas de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_ser').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la serie de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_mot').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el motor de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_edt_gpo').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el grupo de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}														
	
if(ifs==0){
	eqp_guardar_cambio();
	}	
	
	
	}
//----------------------------------------
function eqp_validar_nvo(){
var ifs=0;	

if($('#eqp_nvo_mar').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar la marca de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
//alert($('#eqp_nvo_mod').val())	
if($('#eqp_nvo_mod').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el modelo de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_nvo_tip').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el tipo de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}

if($('#eqp_nvo_cli').val()< 0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_nvo_des').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_nvo_pla').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir las placas de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_nvo_ser').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la serie de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_nvo_mot').val().length==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el motor de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}
if($('#eqp_nvo_gpo').val()==0){
ifs=ifs+1;
$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el grupo de la unidad</p>');
$("#eqp_dialog_message" ).dialog('open');		
return false;
	}								
	
if(ifs==0){
	eqp_guardar_nvo();
	}	
	
	}	
//-----------------------------------
function eqp_guardar_cambio(){
    var client = $("#global_id_client").val();  
    var company = $("#global_id_company").val(); 
	var s='';
	$('#select2 option').each(function(i) {
		if(s==''){
			s=$(this).val();
			//alert(s);
		}
		else{
			s+=','+$(this).val();
		}
	$(this).attr("selected", "selected");
	});	
	//alert(s)	;	
      $.ajax({
          url: "index.php?m=mUnidades&c=adminSaveSetEquipo",
          type: "GET",
          data: { 
            id_client: client,
            id_company:company,
		  eqp_mar: $("#eqp_edt_mar").val(),
		  eqp_mod: $("#eqp_edt_mod ").val(),
		  eqp_tip: $("#eqp_edt_tip").val(),
		  eqp_cli: $("#eqp_edt_cli").val(),
		  eqp_des: $("#eqp_edt_des").val(),
		  eqp_pla: $("#eqp_edt_pla").val(),
		  eqp_ser: $("#eqp_edt_ser").val(),
		  eqp_mot: $("#eqp_edt_mot").val(),
		  eqp_gpo: $("#eqp_edt_gpo").val(),
		  eqp_eqp: s,
		  eqp_id:$("#eqp_id").val(),
		  eqp_status : $("#eqp_nvo_estatus").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#eqp_dialog').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				eqp_load_datatable();
				}
			else{
				alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}	
          }
      });	
	}
//-----------------------------------
function eqp_guardar_nvo(){
    var client = $("#global_id_client").val();  
    var company = $("#global_id_company").val();  		
	var s='';
	$('#select2 option').each(function(i) {
		if(s==''){
			s=$(this).val();
			//alert(s);
		}
		else{
			s+=','+$(this).val();
		}
	$(this).attr("selected", "selected");
	});	
	//alert(s)	;
      $.ajax({
          url: "index.php?m=mUnidades&c=adminSaveAddEquipo",
          type: "GET",
          data: { 
            id_client: client,
            id_company:company,
		  eqp_mar: $("#eqp_nvo_mar").val(),
		  eqp_mod: $("#eqp_nvo_mod ").val(),
		  eqp_tip: $("#eqp_nvo_tip").val(),
		  eqp_cli: $("#eqp_nvo_cli").val(),
		  eqp_des: $("#eqp_nvo_des").val(),
		  eqp_pla: $("#eqp_nvo_pla").val(),
		  eqp_ser: $("#eqp_nvo_ser").val(),
		  eqp_mot: $("#eqp_nvo_mot").val(),
		  eqp_gpo: $("#eqp_nvo_gpo").val(),
		  eqp_eqp: s,
		  eqp_status : $("#eqp_nvo_estatus").val()
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				$('#eqp_dialog_nvo').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				eqp_load_datatable();
				}
			else{
				alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un erros intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}	
          }
      });	
	}	
//--------------------------------
function eqp_modelo(m){
    var client = $("#global_id_client").val();  
    var company = $("#global_id_company").val();  	
      $.ajax({
          url: "index.php?m=mUnidades&c=mModelo",
          type: "GET",
          data: {
			  	eqp_marca : m,
				id_client: client,
            	id_company:company,},
          success: function(data) {
            var result = data; 
			//alert(result)
            $('#div_modelo').html('');
			$('#div_modelo').html(result); 
            //$('#eqp_dialog_nvo').dialog('open');
          }
      });	
	} 	
//--------------------------------
function eqp_modelo_edt(m){
    var client = $("#global_id_client").val(); 			
      $.ajax({
          url: "index.php?m=mUnidades&c=mModelo2",
          type: "GET",
          data: {
			  eqp_marca : m,
			   id_client :client },
          success: function(data) {
            var result = data; 
            $('#div_modelo_edt').html('');
			$('#div_modelo_edt').html(result); 
            //$('#eqp_dialog_nvo').dialog('open');
          }
      });	
	}	