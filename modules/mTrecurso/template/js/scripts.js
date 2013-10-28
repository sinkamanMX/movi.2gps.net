var trhTable;
var trh_imgTable;


$(document).ready(function () {
	//Definir botnes editar
	gral_btn_edit();
	//Definir botnes note
	gral_btn_note();
	//Definir boton uso general	
	gral_boton();
	//Cargar tabla principal
	trh_load_datatable();
	//Crear dialog formulario
	$( "#trh_dialog_form" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 375,
		height: 600,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				trh_val_data();
			}
		}
	});		
	});
//----------------------------------------
function trh_load_datatable(){
	scroll_table=($("#trh_main").height()-125)+"px";
	trhTable = $('#trh_table').dataTable({
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
      "sAjaxSource": "index.php?m=mTrecurso&c=mGet_Tipo",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_TIPO", sDefaultContent: "","bSearchable": false,"bVisible":    false },
		{ "mData": "IMG", sDefaultContent: "","bSearchable": false,"bSortable": false },
        { "mData": "DESCRIPCION", sDefaultContent: "" },

      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';

            edit = "<td><div onclick='trh_abrir_formulario(2,"+full.ID_TIPO+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='trh_delete_function("+full.ID_TIPO+");' class='custom-icon-delete-custom'>"+
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
function trh_abrir_formulario(op,id){
	if(op==1){$("#trh_dialog_form").dialog('option', 'title', 'Agregar tipo de recurso humano');}
	if(op==2){$("#trh_dialog_form").dialog('option', 'title', 'Editar tipo de recurso humano');}
	      $.ajax({
          url: "index.php?m=mTrecurso&c=mFormulario",
          type: "GET",
          data: {
			  id : id,
			  op : op 
			    },
          success: function(data) {
            var result = data; 
			//$('#qst_dialog_formu').dialog( "destroy" );
            $('#trh_dialog_form').html('');
            $('#trh_dialog_form').dialog('open');
			$('#trh_dialog_form').html(result); 
          }
      });
	}	
//----------------------------------------
function trh_img_load_datatable(){
	//alert($("#trh_dialog_form").height());
	scroll_table=($("#trh_dialog_form").height()-280)+"px";
	//alert(scroll_table)
	trh_imgTable = $('#trh_imgTable').dataTable({
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
      "sAjaxSource": "index.php?m=mTrecurso&c=mGet_Img",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_IMG", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "IMG", sDefaultContent: "" },

      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';

            edit = "<td><div onclick='pre_abrir_formulario(2,"+full.ID_IMG+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='pre_delete_function("+full.ID_IMG+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
					
			var selected = (full.IS_DEFAULT=='SI')?'checked="checked"':'';
			rdo = "<td><input type='radio' name='trh_rimg' value='"+full.ID_IMG+"' "+selected+" /></td>";		

            //return '<table><tr>'+edit+del+rdo+'</tr></table>';
			return '<table><tr>'+rdo+'</tr></table>';
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
//-----------------------------------------
function trh_val_data(){
	
	var ifs = 0;

  if($("#trh_dsc").val().length == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n del tipo de recurso humano .</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  //alert($("#trh_hdsc").val());
  if($("#trh_hdsc").val() > 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La descripci\u00f3n del tipo de recurso humano ya existe, escriba una diferente.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  
  if($("#trh_obs").val().length == 0){
	  //ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El campo de observaciones se enviar\u00e1 vac\u00edo.</p>');
	  $("#dialog_message" ).dialog('open');
	  //return false;
  }  
  
	if(ifs==0){
		trh_save_formp();
		//alert('qst_save_formp');
		}
}	
//----------------------------------------------------------------------
function trh_validar_dsc(txt){
	$.ajax({
		url: "index.php?m=mTrecurso&c=mGet_Dsc",
        type: "GET",
		data:{
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		$("#trh_hdsc").val(result);
          }
      });	
	}	
//------------------------------------------------------------------------
function trh_save_formp(){
//alert($("input[name='trh_rimg']:checked").val());
	$.ajax({
		url: "index.php?m=mTrecurso&c=mSave",
        type: "GET",
		data:{
			tit : $("#trh_dsc").val(),
			icn : $("input[name='trh_rimg']:checked").val(),
			op  : $("#trh_hop").val(),
			id  : $("#trh_hid").val(),
			obs : $("#trh_obs").val()
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result>0){
			trh_load_datatable();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El tipo de geopunto ha sido almacenda satisfactoriamente</p>');
			$("#dialog_message" ).dialog('open');
			$('#trh_dialog_form').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El tipo de geopunto no hasido almacenado. Vuelva a int\u00e9ntelo posteriormente.</p>');
			$("#dialog_message" ).dialog('open');
			}
          }
      });
	}		
//-------------------------------------------------------------------------
function trh_delete_function(idp){
	//alert (idp)
	  $( "#trh_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          trh_send_delete(idp);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#trh_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar este tipo de cuestionario.?</p>');
    $("#trh_dialog_confirm").dialog("open");		
	}
		
//-----------------------------------------------------------------------
function trh_send_delete(idp){	
//alert(idp)
      $.ajax({
          url: "index.php?m=mTrecurso&c=mDelete",
          type: "GET",
          data: { 
		  id : idp
		  },
          success: function(data) {
            var result = data; 
            if(result>0){
			
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				trh_load_datatable();
				}
			else{
				//alert(result);
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#dialog_message" ).dialog('open');
				}	
          }
      });
	 }			