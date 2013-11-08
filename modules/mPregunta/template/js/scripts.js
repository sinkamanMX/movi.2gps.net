var preTable;
//array cuestionarios disponibles
var pre_acd = [];
//array cuestionarios seleccionados
var pre_acs = [];

$(document).ready(function () {
	//Definir botnes editar
	gral_btn_edit();
	//Definir botnes note
	gral_btn_note();
	//Definir boton uso general	
	gral_boton();
	//Cargar tabla principal
	pre_load_datatable();
	//Crear dialog formulario
	$( "#pre_dialog_form" ).dialog({
		autoOpen:false,
		//title:"Estad\u00edstica",
		modal: true,
		width: 700,
		height: 500,
		buttons: {
			Cancelar: function() {
				$(this).dialog( "close" );
			},
			Guardar: function() {				
				pre_val_data();
			}
		}
	});	
	});
//----------------------------------------
function pre_load_datatable(){
	scroll_table=($("#pre_main").height()-125)+"px";
	preTable = $('#pre_table').dataTable({
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
      "sAjaxSource": "index.php?m=mPregunta&c=mGet_Pregunta",
      "aoColumns": [
	    { "mData": " ", sDefaultContent: "" },
		{ "mData": "ID_PREGUNTA", sDefaultContent: "","bSearchable": false,"bVisible":    false },
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "TIPO", sDefaultContent: ""},
		{ "mData": "ACTIVO", sDefaultContent: "" },
		{ "mData": "COMPLEMENTO", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "65px",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
			//var gra   = '';

            edit = "<td><div onclick='pre_abrir_formulario(2,"+full.ID_PREGUNTA+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";

            del = "<td><div onclick='pre_delete_function("+full.ID_PREGUNTA+");' class='custom-icon-delete-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";
			//gra = "<td><div onclick='qst_chart_function("+full.ID_CUESTIONARIO+");' class='custom-icon-copy'>"+
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
function pre_abrir_formulario(op,idp){
	if(op==1){$("#pre_dialog_form").dialog('option', 'title', 'Agregar Pregunta');}
	if(op==2){$("#pre_dialog_form").dialog('option', 'title', 'Editar pregunta');}
	      $.ajax({
          url: "index.php?m=mPregunta&c=mFormulario",
          type: "GET",
          data: {
			  idp : idp,
			  op : op 
			    },
          success: function(data) {
            var result = data; 
			//$('#qst_dialog_formu').dialog( "destroy" );
            $('#pre_dialog_form').html('');
            $('#pre_dialog_form').dialog('open');
			$('#pre_dialog_form').html(result); 
          }
      });
	}	
//-----------------------------------------------------
function pre_selec_preg(p){
	$.ajax({
		url: "index.php?m=mPregunta&c=mComplemento",
        type: "GET",
		data:{
			idt : p
			},
        success: function(data) {
        var result = data; 
			
            $("#pre_sis_t").html('');
			$('#pre_com').html('');
			$('#pre_com').html(result);
            
			
          }
      });
	}	
//-----------------------------------------------------------------------------------------------------------------------//
function select_comple(x){
	//alert(x)
	if(x==1){
		$("#pre_sis_t").html('<form name="compts" id="compts"><p><select name="comp" id="qst_comp" class="caja">'+
					 '<option value="$Fecha" selected="selected">Fecha</option>'+
					 '<option value="$Hora" >Hora</option>'+
					 '<option value="$IMEI" >IMEI</option>'+
					 '<option value="$Usuario" >Usuario</option>'+
				   '</select></p></form>');
	}else{
		$("#pre_sis_t").html('<form name="compts" id="compts"><p><input type="text" id="qst_comp" class="caja_txt" /></p></form>');
		}	
	}	
//-----------------------------------------
function pre_val_data(){
	
	var ifs = 0;

  if($("#pre_tit").val().length == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un t\u00edtulo de pregunta.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  
    if($("#pre_hdsc").val() > 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El t\u00edtulo de la pregunta ya existe, escriba uno diferente.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
  }
  
   if($("#pre_typ").val() == 0){
	  ifs=ifs+1;
	  $('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un tipo de pregunta.</p>');
	  $("#dialog_message" ).dialog('open');
	  return false;
   }
	if($("[name='valid']").length){
	if($("[name='valid']").val().length == 0){
		ifs=ifs+1;
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el n\u00famero de caracteres permitidos.</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}
	} 
	
	if($("[name='coma']").length){
	if($("[name='coma']").val().length == 0){
		ifs=ifs+1;
		//alert('Debe escribir al menos un par de elementos separados por el car\u00e1cter ","');
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir al menos un par de elementos separados por el car\u00e1cter ",".</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}
	}	
	
	if($("[name='coma']").length){
	if( $("[name='coma']").val().indexOf(",") == -1){
		ifs=ifs+1;
		//alert('Debe separar cada elemento con el car\u00e1cter "," ');
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe separar cada elemento con el car\u00e1cter ",".</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}	
	}
	
	if($("[name='coma']").length){
		var cont=0;
		n=$("[name='coma']").val().split(",");
		for(var x=0; x<$("[name='coma']").val().split(",").length; x++){
			//alert('x:'+x+'n[x]:'+n[x]);
			if(n[x]=='' || n[x].length==0 ){
				cont++;
				}
			}
	if( cont > 0){
		ifs=ifs+1;
		//alert('Debe escribir un elemento despu\u00e9s del car\u00e1cter ","');
		$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un elemento despu\u00e9s del car\u00e1cter ",".</p>');
		$("#dialog_message" ).dialog('open');
		return false;
		}	
	}		
    
   if($("[name='url']").length){
		if( $("[name='url']").val().indexOf("http://") == -1){
			ifs=ifs+1;
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El campo Url no debe estar vacio y debe iniciar con "http://".</p>');
			$("#dialog_message" ).dialog('open');
			//alert('El campo Url no debe estar vacio y debe iniciar con "http://" ');
		  return false;
		}
	}
	
	
	if(ifs==0){
		pre_save_formp();
		//alert('qst_save_formp');
		}
}		
//--------------------------------------------------------------------
function isNumberKey(evt){
var charCode = (evt.which) ? evt.which : event.keyCode
if (charCode > 31 && (charCode < 48 || charCode > 57))
return false;
 
return true;
}
//-------------------------------------------------------
function radio_cercania(){
	radio = 0;	
	ra = '';

	for(r=1;r<1000;r++){
		radio = r * 10;
		if(radio<=1000){
			ra +='<option value="'+radio+'" >'+radio+'</option>';
			}
	 }
	$("#pre_com").html('<form name="compts" id="compts"><p><select name="comp" id="qst_comp" class="caja">'+ra+'</select> mts. de radio de distancia</p></form>'); 		 
		
	}
//------------------------------------------------------------------------
function pre_save_formp(){
	var pre_qst_sel = $('#pre_qst_sel div').map(function() {
		return this.id;
		}).get();
	pre_q = "";	
	for (i=0; i<pre_qst_sel.length; i++){
		pre_q += (pre_q=="")?pre_qst_sel[i]:","+pre_qst_sel[i];
		}
	//alert($("#qst_comp").val())	;
	$.ajax({
		url: "index.php?m=mPregunta&c=mSavePregunta",
        type: "GET",
		data:{
			tit : $("#pre_tit").val(),
			typ : $("#pre_typ").val(),
			act : $("#pre_act").val(),
			rec : $("#pre_rec").val(),
			req : $("#pre_req").val(),
			com : $("#qst_comp").val(),
			edt : $("#pre_edt").val(),
			qst : pre_q,
			oqst: $("#pre_hqst").val(),
			op  : $("#pre_hop").val(),
			id  : $("#pre_hid").val()
			},
        success: function(data) {
        var result = data;
		//alert(result) 
		if(result>0){
			pre_load_datatable();
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La pregunta ha sido almacenda satisfactoriamente</p>');
			$("#dialog_message" ).dialog('open');
			$('#pre_dialog_form').dialog('close');
			}
		else{
			$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>La pregunta no hasido almacenada. Vuelva a int\u00e9ntelo posteriormente.</p>');
			$("#dialog_message" ).dialog('open');
			}
          }
      });
	}	
//-------------------------------------------------------------------------
function pre_delete_function(idp){
	//alert (idp)
	  $( "#pre_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          pre_send_delete(idp);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#pre_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Desea borrar esta pregunta?</p>');
    $("#pre_dialog_confirm").dialog("open");		
	}
//-----------------------------------------------------------------------
function pre_send_delete(idp){	
//alert(idp)
      $.ajax({
          url: "index.php?m=mPregunta&c=mDelPregunta",
          type: "GET",
          data: { 
		  id : idp
		  },
          success: function(data) {
            var result = data; 
            if(result>0){
			
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos han sido eliminados correctamente.</p>');
				$("#dialog_message" ).dialog('open');
				pre_load_datatable();
				}
			else{
				//alert(result);
				$('#dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Ha ocurrido un error intentelo nuevamente.</p>');
				$("#dialog_message" ).dialog('open');
				}	
          }
      });
	 }		
//--------------------------------------------------------------------
function buscador_preguntas(op,txt){
	var pre;
	
	prs = "";	
	for (i=0; i < pre_acs.length; i++){
		prs += (prs=="")?pre_acs[i]:","+pre_acs[i];
		}
	
	prd = "";	
	for (i=0; i< pre_acd.length; i++){
		prd += (prd == "")?pre_acd[i]:","+pre_acd[i];
		}

	if(op==1){

		pre = prs;
		}
	else{

		pre = prd;
		}	

	$.ajax({
		url: "index.php?m=mPregunta&c=mCuestionarioS",
        type: "GET",
		data:{
			pre : pre,
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		if(op==1){
			$("#pre_qst_dsp").html(result);
			}
		else{
			$("#pre_qst_sel").html(result);
			}	
          }
      });	
	}	 
//----------------------------------------------------------------------
function pre_validar_dsc(txt){
	$.ajax({
		url: "index.php?m=mPregunta&c=mGet_Dsc",
        type: "GET",
		data:{
			txt : txt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		$("#pre_hdsc").val(result);
          }
      });	
	}
//----------------------------------------------------------------------	
function pre_edt_op(idt){
	$.ajax({
		url: "index.php?m=mPregunta&c=mGetTipo",
        type: "GET",
		data:{
			idt : idt
			},
        success: function(data) {
        var result = data;
		//alert(result)
		if(result=='N'){
			$('#pre_edt option[value="S"]').prop('selected', true);
			$("#pre_edt").prop('disabled',true);
			}
		if(result=='S'){
			$('#pre_edt option[value="S"]').prop('selected', false);
			$("#pre_edt").prop('disabled',false);
			}
	
          }
      });
	}