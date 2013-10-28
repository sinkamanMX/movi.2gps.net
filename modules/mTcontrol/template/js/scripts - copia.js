var tunTable;
var tun_imgTable;


$(document).ready(function () {
	//Definir botnes editar
	gral_btn_edit();
	//Definir botnes note
	gral_btn_note();
	//Definir boton uso general	
	gral_boton();
	//Cargar tabla principal
	tun_load_datatable();
	//Crear dialog formulario
	$( "#tun_dialog_form" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 300,
		height: 200,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				tun_val_data();
			}
		}
	});	
	});
//----------------------------------------
function tun_load_datatable(){
	scroll_table=($("#tun_main").height()-125)+"px";
	tunTable = $('#tun_table').dataTable({
	  "sScrollY": scroll_table,
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": false,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,
      //"iDisplayLength": 20,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mTunidad&c=mGet_Tipo",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "COD_TYPE_ENTITY", sDefaultContent: "","bSearchable": false,"bVisible":    false },
		//{ "mData": "IMG", sDefaultContent: "","bSearchable": false,"bSortable": false },
        { "mData": "DESCRIPTION", sDefaultContent: "" },

      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';

            edit = "<td><div onclick='tun_abrir_formulario(2,"+full.COD_TYPE_ENTITY+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='tun_delete_function("+full.COD_TYPE_ENTITY+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
			//gra = "<td><div onclick='qst_chart_function("+full.ID_CUESTIONARIO+");' class='custom-icon-copy'>"+
              //      "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                //    "</div></td>";		

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
//-----------------------------------------------------------------------
function tun_abrir_formulario(op,id){
	
	if(op==1){$("#tun_dialog_form").dialog('option', 'title', 'Agregar tipo de unidad');}
	if(op==2){$("#tun_dialog_form").dialog('option', 'title', 'Editar tipo de unidad');}
	      $.ajax({
          url: "index.php?m=mTunidad&c=mFormulario",
          type: "GET",
          data: {
			  id : id,
			  op : op 
			    },
          success: function(data) {
            var result = data; 
			//$('#qst_dialog_formu').dialog( "destroy" );
            $('#tun_dialog_form').html('');
            $('#tun_dialog_form').dialog('open');
			$('#tun_dialog_form').html(result); 
          }
      });
	}
//-----------------------------------------
function tun_val_data(){
	
	var ifs = 0;

  if($("#tun_dsc").val().length == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n del tipo de unidad .</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  //alert($("#tun_hdsc").val());
  if($("#tun_hdsc").val() > 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La descripci\u00f3n del tipo de unidad ya existe, escriba una diferente.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }

  
	if(ifs==0){
		tun_save_formp();
		//alert('qst_save_formp');
		}
}	
//----------------------------------------------------------------------
function tun_validar_dsc(txt){
	$.ajax({
		url: "index.php?m=mTunidad&c=mGet_Dsc",
        type: "GET",
		data:{
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		$("#tun_hdsc").val(result);
          }
      });	
	}	
//------------------------------------------------------------------------
function tun_save_formp(){
//alert($("input[name='tun_rimg']:checked").val());
	$.ajax({
		url: "index.php?m=mTunidad&c=mSave",
        type: "GET",
		data:{
			tit : $("#tun_dsc").val(),
			op  : $("#tun_hop").val(),
			id  : $("#tun_hid").val()
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result>0){
			tun_load_datatable();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El tipo de unidad ha sido almacenda satisfactoriamente</p>');
			$("#dialog_message" ).dialog('open');
			$('#tun_dialog_form').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El tipo de geopunto no hasido almacenado. Vuelva a int\u00e9ntelo posteriormente.</p>');
			$("#dialog_message" ).dialog('open');
			}
          }
      });
	}	
//-------------------------------------------------------------------------
function tun_delete_function(idp){
	//alert (idp)
	  $( "#tun_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          tun_send_delete(idp);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#tun_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar este tipo de unidad.?</p>');
    $("#tun_dialog_confirm").dialog("open");		
	}	
//-----------------------------------------------------------------------
function tun_send_delete(idp){	
//alert(idp)
      $.ajax({
          url: "index.php?m=mTunidad&c=mDelete",
          type: "GET",
          data: { 
		  id : idp
		  },
          success: function(data) {
            var result = data; 
            if(result>0){
			
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				tun_load_datatable();
				}
			else{
				//alert(result);
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#dialog_message" ).dialog('open');
				}	
          }
      });
	 }		