var xyzTable_x;
var xyzTable_y;
var xyzTable_z;
var xyz_imgTable;
var xyz_type;


$(document).ready(function () {
	//crear tabs
	$( "#tabs_xyz" ).tabs();
	//Definir botnes editar
	gral_btn_edit();
	//Definir botnes note
	gral_btn_note();
	//Definir boton uso general	
	gral_boton();
	//cargar tabla x
	xyz_load_datatable_x();
	//cargar tabla z
	//xyz_load_datatable_z();
	//Crear dialog formulario X
	$( "#xyz_dialog_form" ).dialog({
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
				xyz_val_data();
			}
		}
	});		
	});
//----------------------------------------
function xyz_load_datatable_x(){
	scroll_table=($("#xyz_main").height()-160)+"px";
	xyzTable_x = $('#xyz_table_x').dataTable({
	  "sScrollY": scroll_table,
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": false,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,   
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mTcontrol&c=mGet_X",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_EJE_X", sDefaultContent: "","bSearchable": false,"bVisible":    false },
		//{ "mData": "IMG", sDefaultContent: "","bSearchable": false,"bSortable": false },
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
			eje = "'"+"x"+"'";
            edit = "<td><div onclick='xyz_abrir_formulario(2,"+full.ID_EJE_X+",\"x\");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='xyz_delete_function("+full.ID_EJE_X+",\"x\");' class='custom-icon-delete-custom'>"+
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

//----------------------------------------
function xyz_load_datatable_y(){
	scroll_table=($("#xyz_main").height()-160)+"px";
	xyzTable_y = $('#xyz_table_y').dataTable({
	  "sScrollY": scroll_table,
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": false,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,   
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mTcontrol&c=mGet_Y",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_EJE_Y", sDefaultContent: "","bSearchable": false,"bVisible":    false },
		//{ "mData": "IMG", sDefaultContent: "","bSearchable": false,"bSortable": false },
        { "mData": "DES", sDefaultContent: "" },
		{ "mData": "DZ" , sDefaultContent: "" },

      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';
			eje = "'"+"x"+"'";
            edit = "<td><div onclick='xyz_abrir_formulario(2,"+full.ID_EJE_Y+",\"y\");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='xyz_delete_function("+full.ID_EJE_Y+",\"y\");' class='custom-icon-delete-custom'>"+
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
	
//----------------------------------------
function xyz_load_datatable_z(){
	scroll_table=($("#xyz_main").height()-160)+"px";
	xyzTable_z = $('#xyz_table_z').dataTable({
	  "sScrollY": scroll_table,
      "bDestroy": true,
      "bLengthChange": true,
      "bPaginate": false,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,   
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mTcontrol&c=mGet_Z",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_EJE_Z", sDefaultContent: "","bSearchable": false,"bVisible":    false },
		//{ "mData": "IMG", sDefaultContent: "","bSearchable": false,"bSortable": false },
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
			eje = "'"+"x"+"'";
            edit = "<td><div onclick='xyz_abrir_formulario(2,"+full.ID_EJE_Z+",\"z\");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='xyz_delete_function("+full.ID_EJE_Z+",\"z\");' class='custom-icon-delete-custom'>"+
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
//-----------------------------------------------------------------------
function xyz_abrir_formulario(op,id,typ){
	xyz_type = typ;
	//$('#xyz_dialog_form').dialog( "destroy" );
	
	
	      $.ajax({
          url: "index.php?m=mTcontrol&c=mFormulario_x",
          type: "GET",
          data: {
			  id : id,
			  op : op,
			  typ:typ
			    },
          success: function(data) {
            var result = data; 
			setTimeout(function(){
				if(op==1){$("#xyz_dialog_form").dialog('option', 'title', 'Agregar componente eje '+typ);}
				if(op==2){$("#xyz_dialog_form").dialog('option', 'title', 'Editar componente eje '+typ);}
				$('#xyz_dialog_form').html('');
				$('#xyz_dialog_form').dialog('open');
				$('#xyz_dialog_form').html(result); 
				},750)
			
          }
      });
	}
//----------------------------------------------------------------------
function xyz_validar_dsc(txt){
	$("#xyz_hdsc").val('');
	$.ajax({
		url: "index.php?m=mTcontrol&c=mGet_Dsc",
        type: "GET",
		data:{
			txt : txt,
			typ : xyz_type
			},
        success: function(data) {
        var result = data;
		//alert(result)
		$("#xyz_hdsc").val(result);
          }
      });	
	}	
//----------------------------------------------------------------------	
function xyz_val_data(){
	typ = xyz_type;
	
	var ifs = 0;

  if($("#xyz_dsc").val().length == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n del eje '+typ+'.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  //alert($("#xyz_hdsc").val());
  if($("#xyz_hdsc").val() > 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La descripci\u00f3n del eje '+typ+' ya existe, escriba una diferente.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }

  
	if(ifs==0){
		xyz_save_formp(typ);
		//alert(typ);
		}
}	 	
//------------------------------------------------------------------------
function xyz_save_formp(typ){
//alert($("input[name='xyz_rimg']:checked").val());
//alert($("#xyz_hop").val())
var idz = (typ=='y')?$("#xyz_ejez").val():0;
var fun	= (typ=='y')?$("#xyz_fun").val():0;
var par = (typ=='y')?$("#xyz_par").val():'';

	$.ajax({
		url: "index.php?m=mTcontrol&c=mSave",
        type: "GET",
		data:{
			tit : $("#xyz_dsc").val(),
			op  : $("#xyz_hop").val(),
			id  : $("#xyz_hid").val(),
			typ : typ,
			idz : idz,
			fun : fun,
			par :par
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result>0){
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El componente del eje '+typ+' ha sido almacenda satisfactoriamente</p>');
			$("#dialog_message" ).dialog('open');
			if(typ=='x'){
				xyz_load_datatable_x();
				
				}
			if(typ=='z'){
				xyz_load_datatable_z();
				//$('#xyz_dialog_form').dialog('close');
				}
			if(typ=='y'){
				xyz_load_datatable_y();
				//$('#xyz_dialog_form').dialog('close');
				}
			$('#xyz_dialog_form').dialog('close');			
			$("#xyz_dsc").val('')	
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El componente del eje no hasido almacenado. Vuelva a int\u00e9ntelo posteriormente.</p>');
			$("#dialog_message" ).dialog('open');
			}
          }
      });
	}	
//-------------------------------------------------------------------------
function xyz_delete_function(idp,typ){
	//alert (idp)
	  $( "#xyz_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          xyz_send_delete(idp,typ);
          $( this ).dialog( "close" );
		  //alert(idp+"/"+typ)
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#xyz_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar este componente.?</p>');
    $("#xyz_dialog_confirm").dialog("open");		
	}	
//-----------------------------------------------------------------------
function xyz_send_delete(idp,typ){	
//alert(idp+"/"+typ)
      $.ajax({
          url: "index.php?m=mTcontrol&c=mDelete",
          type: "GET",
          data: { 
		  id : idp,
		  typ:typ
		  },
          success: function(data) {
            var result = data; 
			//alert(result)
            if(result>0){
			
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				if(typ=="x"){
					xyz_load_datatable_x();
					}
				if(typ=="z"){
					xyz_load_datatable_z();
					}
				if(typ=="y"){
					xyz_load_datatable_y();
					}					
				}
			else{
				//alert(result);
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#dialog_message" ).dialog('open');
				}	
          }
      });
	 }			