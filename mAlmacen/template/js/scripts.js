var almTable;

$(document).ready(function () {
	//boton
	gral_btn_add();
	//Cargar tabla principal
	alm_load_datatable();
	//Crear dialog formulario
	$( "#alm_dialog_form" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 650,
		height: 530,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				alm_val_data();
			}
		}
	});	
	});
//----------------------------
function alm_load_datatable(){
	scroll_table=($("#alm_main").height()-125)+"px";
	
    almTable = $('#alm_table').dataTable({
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
      "sAjaxSource": "index.php?m=mAlmacen&c=mAlmacen",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_ALMACEN", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "DESCRIPCION_ALMACEN", sDefaultContent: "" },
        { "mData": "ITEM_NUMBER_ALMACEN", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';

            edit = "<td><div onclick='alm_abrir_formulario("+full.ID_ALMACEN+",2);' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='alm_delete_function("+full.ID_ALMACEN+");' class='custom-icon-delete-custom'>"+
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
//-----------------------------------	
function alm_abrir_formulario(id,op){
	//alert(id+"/"+op)
	if(op==1){$("#alm_dialog_form").dialog('option', 'title', 'Agregar almac\u00e9n');}
	if(op==2){$("#alm_dialog_form").dialog('option', 'title', 'Editar almac\u00e9n');}
	      $.ajax({
          url: "index.php?m=mAlmacen&c=mFormulario",
          type: "GET",
          data: {
			  id : id,
			  op : op
			    },
          success: function(data) {
            var result = data; 
			//$('#fun_dialog_formu').dialog( "destroy" );
            $('#alm_dialog_form').html('');
            $('#alm_dialog_form').dialog('open');
			$('#alm_dialog_form').html(result); 
			edicion_asignados(id);
          }
      });
	}	
//--------------------------------
function get_combo2(id,op){
	 $.ajax({
          url: "index.php?m=mAlmacen&c=mCombo2",
          type: "GET",
          data: {
			  id : id,
			  op : op
			    },
          success: function(data) {
            var result = data; 
			//$('#fun_dialog_formu').dialog( "destroy" );
            $('#alm_dc2').html(result);
          }
      });
	}
//--------------------------------------------------------
function alm_val_data(){
	var ifs = 0;

	if($("#alm_dsc").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'Debe escribir la descripci\u00f3n del almac\u00e9n.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if($("#alm_ddsc").html() != ""){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'La descripci\u00f3n del almac\u00e9n ya \u00e9xiste.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}	
	if($("#alm_alm").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'Debe escribir el identificador del almac\u00e9n.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if($("#alm_dalm").html() != ""){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'El identificador del almac\u00e9n ya \u00e9xiste.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}		
	if($("#alm_alo").val().length > 0 && $("#alm_c1").val() ==-1){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'Debe seleccionar la magnitud de la capacidad de alojamiento.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	if($("#alm_alo").val().length > 0 && $("#alm_c1").val() > 0 && $("#alm_c2").val()==-1){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'Debe seleccionar la unidad de la capacidad de alojamiento.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
		
		//alert($("#tipo_pdi_uni").val()+'-'+$("#origen").find("option").length);
	
	if($("#tipo_pdi_uni").val() == -1){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'Debe elegir una opción de tipo PDI ó Unidad.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
	}
	
	
	if($("#tipo_pdi_uni").val() != -1){
		
       if($("#origen").find("option").length==0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
								  'Debe seleccionar un PDI ó Unidad.</p>');
		$("#dialog_message" ).dialog('open');		
		return false;
		}
	}
		
	
	    if(ifs==0){
			
			var todos = '';
			if($("#tipo_pdi_uni").val() != -1){
			    $("#origen option").each(function(){
					if(todos == ''){
						todos = $(this).attr('value');
					}else{
						todos = todos+','+$(this).attr('value');
					}
	  	        });
			 todos = todos +'|'+$("#alm_hid").val();
			   
			}else{
				todos = '0';
			}
			//alert(todos);
		  alm_save_alm(todos);
		}
	}	
//-------------------------------------------------------
function alm_save_alm(cadena){
	gral_cargando();
	//console.log($("#alm_mer").val())
	$.ajax({
		url: "index.php?m=mAlmacen&c=mSaveAlmacen",
        type: "GET",
		data:{
			dsc : $("#alm_dsc").val(),
			alm : $("#alm_alm").val(),
			tda : $("#alm_tda").val(),
			zon : $("#alm_zon").val(),
			mer : $("#alm_mer").val(),
			cap : $("#alm_alo").val(),
			pat : $("#alm_c2").val(),
			obs : $("#alm_obs").val(),
			op  : $("#alm_hop").val(),
			id  : $("#alm_hid").val(),
			pdi_uni : $("#tipo_pdi_uni").val(), 
			cad : cadena
			},
        success: function(data) {
		$("body").css("cursor", "default");	
        var result = data;
		console.log(result); 
		if(result>0){
			//fun_aps.push(
			alm_load_datatable();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
									  'Los datos han sido almacenda satisfactoriamente</p>');
			
			$('#alm_dialog_form').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>'+
									  'Los datos no han sido almacenados. Vuelva a int\u00e9ntelo posteriormente.</p>');
			//$("#dialog_message" ).dialog('open');
			}
          }
      });
	}	
//-------------------------------------------
function validar_dsc(txt){
	$.ajax({
		url: "index.php?m=mAlmacen&c=mDescripcion",
        type: "GET",
		data:{
			txt : txt,
			},
        success: function(data) {
		
        var result = data;
		//console.log(result) 
		if(result>0){
			$("#alm_ddsc").html('La descripci\u00f3n del almac\u00e9n ya \u00e9xiste.');
			}
		else{
			$("#alm_ddsc").html('');
			}
          }
      });
	}
//-------------------------------------------
function validar_nip(txt){
	$.ajax({
		url: "index.php?m=mAlmacen&c=mNip",
        type: "GET",
		data:{
			txt : txt,
			},
        success: function(data) {
		
        var result = data;
		//console.log(result) 
		if(result>0){
			$("#alm_dalm").html('El identificador del almac\u00e9n ya \u00e9xiste.');
			}
		else{
			$("#alm_dalm").html('');
			}
          }
      });
	}	
//-------------------------------------------------------------------------
function alm_delete_function(q){
	  $( "#alm_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          alm_send_delete(q);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#alm_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar este almac\u00e9n?</p>');
    $("#alm_dialog_confirm").dialog("open");		
	}
//-----------------------------------------------------------------------
function alm_send_delete(q){
	gral_cargando();
      $.ajax({
          url: "index.php?m=mAlmacen&c=mDelAlmacen",
          type: "GET",
          data: { 
		  id : q
		  },
          success: function(data) {
            var result = data; 
			$("body").css("cursor", "default");
            if(result==1){
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				
				alm_load_datatable();
				}
			else{
				//alert(result);
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#dialog_message" ).dialog('open');
				}	
          }
      });
	 }		
	 
//--------------------------- mis funciones

function mostrar_tipo(valor){

	if(valor != -1){	
		if(valor == 1){
		  var ruta = "index.php?m=mAlmacen&c=mTotalPdi";
		}else{
		   var ruta = "index.php?m=mAlmacen&c=mTotalUnidades";	
		}
		
			  $.ajax({
			  url: ruta,
			  type: "GET",
			  success: function(data) {
				var result = data; 
				$('#pdis').html(result); 
			  }
		  });
	}
	
}

function edicion_asignados(id){
	
//	return id;
	 var ruta = "index.php?m=mAlmacen&c=mTotalPdi2";
	
      $.ajax({
          url: ruta,
          type: "GET",
		  data: { 
		  id : id
		  },
          success: function(data) {
            var result = data; 
			$('#pdis').html(result);
          }
      });
	
	
}