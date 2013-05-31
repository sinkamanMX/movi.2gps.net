var oTable;
$(document).ready(function () {
	emp_load_datatable();
	//Dialog generico		
	$( "#emp_dialog" ).dialog({
		autoOpen:false,
		modal: true,
		buttons: {
		Cancelar: function() {
			//$("#emp_dialog" ).dialog( "close" );
			emp_validar_ed();
			},
		Editar: function() {
			//alert("editar");
			//emp_validar_ed();
			//$("#emp_dialog" ).dialog( "close" );
			}			
		}
	});	
	
});  
function emp_load_datatable(){
	  //alert("load_datatable")
	  //alert(calcDataTableHeight)
    oTable = $('#emp_table').dataTable({
	  //"sScrollY": calcDataTableHeight(),
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": true,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,
      "iDisplayLength": 20,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mEmpresas&c=mEmpresa",
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
            var edit  = '';
            var del   = '';

            //if($("#op_update").val()==1){
                edit = '<td><span style="cursor:pointer" class="ui-icon ui-icon-pencil" onclick="emp_edit_function('+full.ID_EMPRESA+');"></span></td>';
            //}
            
            //if($("#op_delete").val()==1){
                del = '<td><span style="cursor:pointer" class="ui-icon ui-icon-trash" onclick="emp_delete_function('+full.ID_EMPRESA+');"></span></td>';
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
function emp_edit_function(value){
	//alert("value");
      $.ajax({
          url: "index.php?m=mEmpresas&c=mSetEmpresa",
          type: "GET",
          data: { data: value },
          success: function(data) {
            var result = data; 
            $('#emp_dialog').html('');
            $('#emp_dialog').dialog('open');
            $('#emp_dialog').html(result); 
          }
      });
} 

  function delete_function(value){
    $( "#dialog-confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#dialog-confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#dialog-confirm").dialog("open");

  }
function emp_validar_ed(){
//var ifs=0;	

if($('#emp_name').val().length==0){
//ifs=ifs+1;
$('#dialog-message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n de empresa</p>');
$("#dialog-message" ).dialog('open');		
return false;
	}
else{
	//emp_guardar_cambio();
	}	
	
	}