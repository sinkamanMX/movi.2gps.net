var oTable,evtsTable;
var epo_a_eventos;
var epo_a_evts;
var epo_type=0;
$(document).ready(function (){
  epo_load_datatable();
  $( "#epo_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  //Dialog generico   
  $( "#epo_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:500,
    buttons: {
    Cancelar: function() {
      $("#epo_dialog_nvo" ).dialog( "close" );
      },
    Guardar: function() {
      epo_validar_nvo();
      }     
    }
  });
    $( "#epo_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#epo_dialog_message" ).dialog( "close" );
        }
      }
    });

    $( "#epo_dialog_message2" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center'
    });    

  // custom css expression for a case-insensitive contains()
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };

});  

function epo_load_datatable(){
    scroll_table=($("#eqTablePrincipal").height()-120)+"px";
    oTable = $('#epo_table').dataTable({
      "sScrollY": scroll_table,
      "bDestroy": true,
      "bLengthChange": false,
      "bPaginate": false,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true, 
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mEquipos&c=mGetTable",
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
        { "mData": "ITEM", sDefaultContent: "" },
        { "mData": "TIPO", sDefaultContent: "" },
        { "mData": "PHONE", sDefaultContent: "" },
        { "mData": "IMEI", sDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            if($("#epo_update").val()==1){
                edit = "<td><div onclick='epo_edit_function("+full.ID+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            }
            
            if($("#epo_delete").val()==1){
                del = "<td><div onclick='epo_delete_function("+full.ID+");' class='custom-icon-delete-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";                
            }    

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

  function epo_edit_function(value){
      $.ajax({
          url: "index.php?m=mEquipos&c=mGetRow",
          type: "GET",
          data: { data: value },
          success: function(data) {            
            var result = data;             
            $('#epo_dialog_nvo').html('');
            $('#epo_dialog_nvo').dialog('open');
            $('#epo_dialog_nvo').html(result); 
        
            $("#epo_tabs").tabs();

            $("#epo_txt_tel").numeric();
            $("#epo_txt_tel").attr('maxlength','10');
            $("#epo_txt_imei").numeric();
            $("#epo_txt_time").attr('maxlength','4');
            $("#epo_txt_tx").numeric();
            $("#epo_txt_tx").attr('maxlength','4');
            $("#epo_txt_rx").numeric();
            $("#epo_txt_rx").attr('maxlength','4');
            
            $("#epo_add_events").button().click(function( event ){
              var new_ids = $("#epo_cbo_es :selected").val();
              var new_ide = $("#epo_cbo_ee :selected").val();
              if(new_ide>-1 && new_ids>-1){
                  epo_search_data_tables(new_ids,new_ide);
              }else{
                $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un evento del sistema y uno de equipo.</p>');
                $("#epo_dialog_message" ).dialog('open');   
              }
            }); 

            $("#epo_txt_tel").focusout(function() {
                if($(this).val().length==10){
                        epo_validate($(this).val(),'t',$(this));
                }            
            })

            $("#epo_txt_imei").delay(300).focusout(function() {
                if($(this).val().length>3){
                    epo_validate($(this).val(),'i',$(this));
                }         
            })

            $("#epo_txt_item").delay(300).focusout(function() {
                if($(this).val().length>3){
                    epo_validate($(this).val(),'n',$(this));
                }          
            })

            evtsTable= $('#epo_table_eventos').dataTable( { 
                "aaData" :epo_a_eventos,               
                "bDestroy": true,
                "bLengthChange": false,
                "bPaginate": true,
                "bFilter": true,
                "bSort": true,
                "bJQueryUI": true,
                "iDisplayLength": 10,
                "bAutoWidth": false,
                "bSortClasses": false,    
                "aoColumns": [
                  { "mData": " "    , sDefaultContent: "" },
                  { "mData": "NAME" , sDefaultContent: "" },
                  { "mData": "NAMES", sDefaultContent: "" },
                ] ,           
                "oLanguage": {
                    "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
                    "sEmptyTable": "No hay registros.",
                    "sInfoEmpty" : "No hay registros.",
                    "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
                    "sLoadingRecords": "Leyendo información",
                    "sProcessing": "Procesando",
                    "sSearch": "Buscar:",
                    "sZeroRecords": "No hay registros",
                },"aoColumnDefs": [
                  {"aTargets": [0],
                    "sWidth": "10%",
                    "bSortable": false,        
                    "mRender": function (data, type, full) {
                      return '<span id="'+full.IDS+'|'+full.IDE+'" class="ui-icon ui-icon-trash delEnqBtn"></span>';
                  }}
                ]
              });

            $('#epo_table_eventos span.delEnqBtn').live('click', function(e) {
                e.preventDefault();
                var nRow = $(this).parents('tr')[0];
                evtsTable.fnDeleteRow(nRow);
            });

            $(".rsu").change(function () { 
                if ($("#epo_select_unit").attr("checked")) {
                  epo_type=0;
                  $("#epo_div_crea_unit").removeClass("visible").addClass("invisible");
                  $("#epo_div_cunit").removeClass("invisible").addClass("visible");
                }else {
                  epo_type=1;
                  $("#epo_div_crea_unit").removeClass("invisible").addClass("visible");
                  $("#epo_div_cunit").removeClass("visible").addClass("invisible");
                }
            });            
          }
      });
  }

  function epo_search_data_tables(new_ids,new_ide){
      var existe =0;

      $('#epo_table_eventos tbody tr span').each(function(){
        var attrs = $(this).attr("id").split("|");
        var ids = attrs[0];
        var ide = attrs[0];
        console.log($(this).attr("id"));
        if(new_ids == ids || new_ide == ide){
            existe++;
        }
      });

      if(existe==0){
          var myobjecto = Object();
          myobjecto.IDE  = $("#epo_cbo_es :selected").val();
          myobjecto.NAME = $("#epo_cbo_es :selected").text();
          myobjecto.IDS  = $("#epo_cbo_ee :selected").val();
          myobjecto.NAMES = $("#epo_cbo_ee :selected").text();
          $('#epo_table_eventos').dataTable().fnAddData( [
            myobjecto
          ]);                          
      }else{
          $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>ALguno de los eventos ya se ha registrado.</p>');
          $("#epo_dialog_message" ).dialog('open');    
      }
  }

  function epo_delete_function(value){
    $( "#epo_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          epo_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#epo_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#epo_dialog_confirm").dialog("open");

  }

  function epo_send_delete(value){
    $.ajax({
        url: "index.php?m=mEquipos&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#epo_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#epo_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#epo_dialog_message" ).dialog('open');
              epo_load_datatable();
          }else if(result=='no-perm'){ 
              $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#epo_dialog_message" ).dialog('open');       
          }
        }
    });
  }

  function epo_validar_nvo(){
    var error=0; 
    epo_a_evts = []; 

    if($("#epo_txt_desc").val()=="NULL" || $("#epo_txt_desc").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la descripcion.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#epo_txt_item").val()=="NULL" || $("#epo_txt_item").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el item number.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#epo_txt_tel").val()=="NULL" || $("#epo_txt_tel").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el telefono.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    }       

     if($("#epo_txt_imei").val()=="NULL" || $("#epo_txt_imei").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el IMEI.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    }       
   
    
    if($("#epo_txt_time").val()=="NULL" || $("#epo_txt_time").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el tiempo de reporte.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    } 

    if($("#epo_txt_tx").val()=="NULL" || $("#epo_txt_tx").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el puerto tx.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    } 

    if($("#epo_txt_rx").val()=="NULL" || $("#epo_txt_rx").val()==""){
      $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir  el puerto rx.</p>');
      $("#epo_dialog_message" ).dialog('open');  
      error++;
    }

    $('#epo_table_eventos tbody tr span').each(function(){
      var attrs = $(this).attr("id").split("|");      
      var ids = attrs[0];
      var ide = attrs[0];
      epo_a_evts.push(ids+"|"+ide);
    });    

    if (!$("#epo_select_unit").attr("checked")){

        if($('#eqp_nvo_mar').val()==0){      
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar la marca de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }

        if($('#eqp_nvo_mod').val()==0){
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el modelo de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_tip').val()==0){
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el tipo de unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_cli').val()<0){
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar un cliente</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_des').val().length==0){
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir un nombre o descripci\u00f3n de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_pla').val().length==0){  
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir las placas de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_ser').val().length==0){
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir la serie de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_mot').val().length==0){
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe escribir el motor de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
        if($('#eqp_nvo_gpo').val()==0){      
          $('#eqp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe seleccionar el grupo de la unidad</p>');
          $("#eqp_dialog_message" ).dialog('open');   
          error++;
        }
    }    

    if(error==0){ epo_send_row(); }
  }

  function epo_send_row(){
      $.ajax({
          url: "index.php?m=mEquipos&c=mSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
              epo_id   : $("#epo_txt_id").val(),
              epo_equp : $("#epo_cbo_epo").val(),
              desc    :  $("#epo_txt_desc").val(),
              itemn   :  $("#epo_txt_item").val(),
              itemn2  :  $("#epo_txt_item2").val(),
              tel     :  $("#epo_txt_tel").val(),
              imei    :  $("#epo_txt_imei").val(),
              time    :  $("#epo_txt_time").val(),
              msg     :  $("#epo_cbo_msg").val(),
              vid     :  $("#epo_cbo_vid").val(),
              voz     :  $("#epo_cbo_voz").val(),
              dchp    :  $("#epo_cbo_dchp").val(),
              unit    :  $("#epo_cbo_units").val(),
              tr      :  $("#epo_txt_tx").val(),
              tx      :  $("#epo_txt_rx").val(),
              unit    :  $("#epo_cbo_unit").val(),
              eventos :  epo_a_evts,

              eqp_mar: $("#eqp_nvo_mar").val(),
              eqp_mod: $("#eqp_nvo_mod ").val(),
              eqp_tip: $("#eqp_nvo_tip").val(),
              eqp_cli: $("#eqp_nvo_cli").val(),
              eqp_des: $("#eqp_nvo_des").val(),
              eqp_pla: $("#eqp_nvo_pla").val(),
              eqp_ser: $("#eqp_nvo_ser").val(),
              eqp_mot: $("#eqp_nvo_mot").val(),
              eqp_gpo: $("#eqp_nvo_gpo").val(),
              epo_type:epo_type              
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#epo_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#epo_dialog_nvo').dialog('close');
                $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#epo_dialog_message" ).dialog('open');
                epo_load_datatable();
            }else if(result=='no-perm'){ 
                $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#epo_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#epo_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#epo_dialog_message").dialog('open');       
            }
          }
        }); 
  }

  function epo_validate(value,type,input){
      $.ajax({
          url: "index.php?m=mEquipos&c=mGetValidate",
          type: "GET",
          dataType : 'json',
          data: { 
              epo_id : $("#epo_txt_id").val(),
              valor : value,
              tipo  : type
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='nok'){
                if(type=='t'){
                  $('#epo_dialog_message2').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El telefono ingresado ya se encuentra registrado con otro equipo.</p>');
                }else if(type=='n'){
                  $('#epo_dialog_message2').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El item number ingresado ya se encuentra registrado con otro equipo.</p>');
                }else if(type=='i'){
                  $('#epo_dialog_message2').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>El IMEI ingresado ya se encuentra registrado con otro equipo.</p>');
                }

                $("#epo_dialog_message2" ).dialog('open');             
                input.focus();
            }
          }
        }); 
  }


  function eqp_modelo(m){   
      $.ajax({
          url: "index.php?m=mUnidades&c=mModelo",
          type: "GET",
          data: {
          eqp_marca : m},
          success: function(data) {
            var result = data; 
            $('#div_modelo').html('');
            $('#div_modelo').html(result); 
          }
      }); 
  }   