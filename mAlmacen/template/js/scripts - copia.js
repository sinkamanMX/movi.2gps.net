var funTable,parTable;

$(document).ready(function () {
	$(".boton").button();
	//Cargar tabla principal
	fun_load_datatable();

	//Crear dialog formulario
	$( "#fun_dialog_formu" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 650,
		height: 530,
		buttons: {
			Cancelar: function() {
				fun_delete_pars();
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				fun_val_data();
			}
		}
	});
	//Crear dialog formulario agregar parametrod
	$( "#fun_dialog_formp" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 290,
		height: 335,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				fun_val_data_par();
			}
		}
	});	
	
	});
//----------------------------
function fun_load_datatable(){
	scroll_table=($("#fun_main").height()-125)+"px";
	
    funTable = $('#fun_table').dataTable({
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
      "sAjaxSource": "index.php?m=mFuncion&c=mFuncion",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_FUNCION", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "NOMBRE", sDefaultContent: "" },
        { "mData": "DESCRIPCION", sDefaultContent: "","bSearchable": false },
		{ "mData": "TP", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';

            edit = "<td><div onclick='fun_abrir_formulario("+full.ID_FUNCION+",2);' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='fun_delete_function("+full.ID_FUNCION+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
			/*gra = "<td><div onclick='fun_chart_function("+full.ID_ID_FUNCION+");' class='custom-icon-copy'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";	*/	

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
function fun_abrir_formulario(id,op){
	//alert(id+"/"+op)
	if(op==1){$("#fun_dialog_formu").dialog('option', 'title', 'Agregar funci&oacute;n');}
	if(op==2){$("#fun_dialog_formu").dialog('option', 'title', 'Editar funci&oacute;n');}
	      $.ajax({
          url: "index.php?m=mFuncion&c=mFormulario",
          type: "GET",
          data: {
			  id : id,
			  op : op
			    },
          success: function(data) {
            var result = data; 
			//$('#fun_dialog_formu').dialog( "destroy" );
            $('#fun_dialog_formu').html('');
            $('#fun_dialog_formu').dialog('open');
			$('#fun_dialog_formu').html(result); 
          }
      });
	}
//----------------------------------------------------------------------
function fun_val_data(){
	var ifs = 0;

	if($("#fun_nom").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el nombre de la funci\u00f3n.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if($("#fun_des").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la descripci\u00f3n de la funci\u00f3n.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if($("#fun_fun").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el c\u00f3digo de la funci\u00f3n.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}					
	if(ifs==0){
		fun_save_fun();
		}
	}
//------------------------------------------------------------------------
function fun_save_fun(){
	var pars="";
	var rows = parTable.fnGetNodes();
        for(var i=0;i<rows.length;i++)
        {
            // Get HTML of 3rd column (for example)
		//alert($(rows[i]).find("td:eq(3)").html())
		//console.log($(rows[i]).find("td:eq(3)").html())
            //cells.push($(rows[i]).find("td:eq(3)").html()); 
		pars += (pars=="")?$(rows[i]).find("td:eq(3)").html():','+$(rows[i]).find("td:eq(3)").html();
        }
	//alert($("#fun_tip").val())
	$("#dialog_message").dialog( "option", "modal", true );	
	$('#dialog_message').html('<p align="center"><img src="public/images/cargando.gif" > Procesando datos.Espere un momento, por favor.</p>');
	$("#dialog_message").dialog('open');
	$("body").css("cursor", "progress");
	$.ajax({
		url: "index.php?m=mFuncion&c=mSaveFuncion",
        type: "GET",
		data:{
			nom : $("#fun_nom").val(),
			des : $("#fun_des").val(),
			fun : $("#fun_fun").val(),
			tip : $("#fun_tip").val(),
			par : pars,
			op  : $("#fun_hop").val(),
			id  : $("#fun_hid").val()
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result>0){
			//fun_aps.push(
			fun_load_datatable();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenda satisfactoriamente</p>');
			//$("#dialog_message" ).dialog('open');
			$("body").css("cursor", "default");
			$('#fun_dialog_formu').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no han sido almacenados. Vuelva a int\u00e9ntelo posteriormente.</p>');
			//$("#dialog_message" ).dialog('open');
			}
          }
      });	
	}	
//-------------------------------------------------------------------------
function fun_delete_function(q){
	  $( "#fun_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          fun_send_delete(q);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#fun_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar esta funci\u00f3n?</p>');
    $("#fun_dialog_confirm").dialog("open");		
	}
//-----------------------------------------------------------------------
function fun_send_delete(q){
	//alert(q)
	$("#dialog_message").dialog( "option", "modal", true );	
	$('#dialog_message').html('<p align="center"><img src="public/images/cargando.gif" > Procesando datos.Espere un momento, por favor.</p>');
	$("#dialog_message").dialog('open');
	$("body").css("cursor", "progress");
      $.ajax({
          url: "index.php?m=mFuncion&c=mDelFuncion",
          type: "GET",
          data: { 
		  fun_id : q
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#eqp_dialog').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				$("body").css("cursor", "default");
				fun_load_datatable();
				}
			else{
				//alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}	
          }
      });
	 }	
	 
	//----------------------------
	function fun_load_datatable_fparam(){
	scroll_table=($("#fun_tabs").height()-160)+"px";
	var id = $("#fun_hid").val();
	
    parTable = $('#fun_table_par').dataTable({
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
      "sAjaxSource": "index.php?m=mFuncion&c=mParametro&id="+id,
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_PARAMETRO", sDefaultContent: "","bSearchable": false},
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "TIPO", sDefaultContent: "","bSearchable": false }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            edit = "<td><div onclick='fun_abrir_formulario_par("+full.ID_PARAMETRO+",2);' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='par_delete_function("+full.ID_PARAMETRO+");' class='custom-icon-delete-custom'>"+
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
function fun_abrir_formulario_par(id,op){
	//alert(id+","+op)
	//alert("fun_abrir_formulario_gear")
	if(op == 1){$("#fun_dialog_formp").dialog('option', 'title', 'Agregar par&aacute;metro');}
	if(op == 2){$("#fun_dialog_formp").dialog('option', 'title', 'Editar par&aacute;metro');}
	      $.ajax({
          url: "index.php?m=mFuncion&c=mFormulariop",
          type: "GET",
          data: {
			  id : id,
			  op : op
			    },
          success: function(data) {
            var result = data; 
			//$('#fun_dialog_formu').dialog( "destroy" );
            $('#fun_dialog_formp').html('');
            $('#fun_dialog_formp').dialog('open');
			$('#fun_dialog_formp').html(result); 
          }
      });
	}	
//-----------------------------------------------------------------------	
function fun_val_data_par(){
	var ifs = 0;

	if($("#fun_tit_par").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir una descripci\u00f3n del par\u00e1metro.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if(ifs==0){
		fun_save_par();
		}	
	}
//------------------------------------------------------------------------
function fun_save_par(){
	//alert($("#fun_typ_par").val())
	//alert($("#fun_tit_par").val()+"/"+$("#fun_typ_par").val()+"/"+$("#fun_hopp").val()+"/"+$("#fun_hidp").val());
	$("#dialog_message").dialog( "option", "modal", true );	
	$('#dialog_message').html('<p align="center"><img src="public/images/cargando.gif" > Procesando datos.Espere un momento, por favor.</p>');
	$("#dialog_message").dialog('open');
	$("body").css("cursor", "progress");
	$.ajax({
		url: "index.php?m=mFuncion&c=mSaveParam",
        type: "GET",
		data:{
			des : $("#fun_tit_par").val(),
			typ : $("#fun_typ_par").val(),
			op  : $("#fun_hopp").val(),
			id  : $("#fun_hidp").val(),
			idf : $("#fun_hid").val()
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result==1){
			//fun_aps.push(
			fun_load_datatable_fparam();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido almacenda satisfactoriamente</p>');
			$("body").css("cursor", "default");
			$('#fun_dialog_formp').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no han sido almacenados. Vuelva a int\u00e9ntelo posteriormente.</p>');
			}
          }
      });	
	}	
	
//-------------------------------------------------------------------------
function par_delete_function(q){
	  $( "#fun_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          par_send_delete(q);
          $( this ).dialog( "close" );
        },
        'Cancelar': function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#fun_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar este par\u00e1metro</p>');
    $("#fun_dialog_confirm").dialog("open");		
	}
//-----------------------------------------------------------------------
function par_send_delete(q){
	//alert(q)
	$("#dialog_message").dialog( "option", "modal", true );	
	$('#dialog_message').html('<p align="center"><img src="public/images/cargando.gif" > Procesando datos.Espere un momento, por favor.</p>');
	$("#dialog_message").dialog('open');
	$("body").css("cursor", "progress");
      $.ajax({
          url: "index.php?m=mFuncion&c=mDelParam",
          type: "GET",
          data: { 
		  id : q
		  },
          success: function(data) {
            var result = data; 
            if(result==1){
				//$('#eqp_dialog').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				$("body").css("cursor", "default");
				fun_load_datatable_fparam();
				}
			else{
				//alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}	
          }
      });
	 }		
//-----------------------------------------------------------------------	 
function fun_delete_pars(){
	
	 $.ajax({
          url: "index.php?m=mFuncion&c=mDelParams",
          type: "GET",
          success: function(data) {
            var result = data; 
			//console.log(result)
           /* if(result==1){
				//$('#eqp_dialog').dialog('close');
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				$("body").css("cursor", "default");
				fun_load_datatable_fparam();
				}
			else{
				//alert(result);
				$('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#eqp_dialog_message" ).dialog('open');
				}*/	
          }
      });
	}