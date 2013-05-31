var oTable;
var oTable2;
var oTable3;
var proc_apermisos = Array();

$(document).ready(function (){
  proc_load_datatable();
  $( "#proc_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  //Dialog generico   
  $( "#proc_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:950,
    buttons: {
      Cancelar: function() { $("#proc_dialog_nvo" ).dialog( "close" ); },
      Guardar: function()  { proc_validar_nvo(); }     
    }
  });
    $( "#proc_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#proc_dialog_message" ).dialog( "close" );
        }
      }
    });
    $('#proc_dialog_nvo').dialog({ width: 630 });
});  

function proc_load_datatable(){
    var client = $("#global_id_client").val();
    oTable = $('#proc_table').dataTable({
      "bDestroy": true,
      "bLengthChange": false,
      "bPaginate": true,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,
      "iDisplayLength": 20,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mProtocolos&c=adminGetTable&id_client="+client,
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
        { "mData": "NAME", sDefaultContent: "" },
        { "mData": "ESTATUS", sDefaultContent: "" },
        { "mData": "CREADO", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            if($("#proc_update").val()==1){
                edit = "<td><div onclick='proc_edit_function("+full.ID+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";
            }
            
            if($("#proc_delete").val()==1){
                del = "<td><div onclick='proc_delete_function("+full.ID+");' class='custom-icon-delete-custom'>"+
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

  function proc_edit_function(value){
    var client = $("#global_id_client").val();
      $.ajax({
          url: "index.php?m=mProtocolos&c=adminGetRow",
          type: "GET",
          data: { data: value ,id_client :client },
          success: function(data) {            
            var result = data;             
            $('#proc_dialog_nvo').html('');            
            $('#proc_dialog_nvo').dialog('open');
            $('#proc_dialog_nvo').html(result); 
            $("#proc_tabs" ).tabs(); 
            console.log($("#proc_txt_id_nvo").val());
            if($("#proc_txt_id_nvo").val()==0){
              $( "#proc_tabs" ).tabs( "option", "disabled", [1]);
            }else{
              enable_contacts(0);
            }
          }
      });
  }

  function proc_delete_function(value){
    $( "#proc_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          proc_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#proc_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#proc_dialog_confirm").dialog("open");

  }

  function proc_send_delete(value){
    $.ajax({
        url: "index.php?m=mProtocolos&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#proc_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#proc_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#proc_dialog_message" ).dialog('open');
              proc_load_datatable();
          }else if(result=='no-perm'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#proc_dialog_message" ).dialog('open');       
          }
        }
    });
  }


  function proc_validar_nvo(){
    var error=0;  

    if($("#proc_txt_name").val()=="NULL" || $("#proc_txt_name").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una descripción.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

   if($("#proc_cbo_unit").val() == -1){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar una unidad.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if(error==0){ proc_send_row(); }
  }

  function proc_send_row(){
    var client = $("#global_id_client").val();
      $.ajax({
          url: "index.php?m=mProtocolos&c=adminSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
            id_client: client,
            data : $("#proc_txt_id_nvo").val(),
            name    : $("#proc_txt_name").val(),
            obs     : $("#proc_txt_obs").val(),
            unit    : $("#proc_cbo_unit").val(),
            status  : $("#proc_cbo_estatus").val()
          },
          success: function(data) {            
            var result = data.result; 
            var new_id = data.id_row

            if(result=='no-data' || result=='problem'){
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#proc_dialog_message" ).dialog('open');             
            }else if(result=='edit'){                 
                proc_load_datatable();
                if($("#proc_txt_id_nvo").val()==0){
                  $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente, ahora puede agregar contactos.</p>');
                  $("#proc_dialog_message" ).dialog('open');                  
                  $("#proc_txt_id_nvo").val(new_id);
                  enable_contacts(1);
                }else{
                  $('#proc_dialog_nvo').dialog('close');
                  $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                  $("#proc_dialog_message" ).dialog('open');                                    
                }                
            }else if(result=='no-perm'){ 
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#proc_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#proc_dialog_message").dialog('open');       
            }
          }
        }); 
  }

function enable_contacts(change){
  if(change==1){
    $( "#proc_tabs" ).tabs( "select", 1)  
  }
  $( "#proc_tabs" ).tabs( "enable" , 1 )  

  var id_row = $("#proc_txt_id_nvo").val();
    oTable2 = $('#proc_table_contacts').dataTable({
      "bDestroy": true,
      "bLengthChange": false,
      "bPaginate": true,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,
      "iDisplayLength": 5,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mProtocolos&c=getTableContacts&data="+id_row,
      "aoColumns": [
        { "mData": " "      , sDefaultContent: "" },
        { "mData": "NOMBRE" , sDefaultContent: "" },
        { "mData": "ROL"    , sDefaultContent: "" },
        { "mData": "HORARIO", sDefaultContent: "" },
        { "mData": "CONSULTA", sDefaultContent: "" },
        { "mData": "AUTORIZA", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
               var edit = '<td><span class="ui-icon ui-icon-pencil" onclick="proc_edit_contact('+full.ID+');"></span></td>';            
               var del = '<td><span class="ui-icon ui-icon-trash" onclick="pro_delete_contact('+full.ID+');"></span></td>';

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

  $("#proc_dialog_contact_nvo").dialog({
    autoOpen:false,
    title:"Contacto",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:400,
    buttons: {
      Cancelar: function() { $(this).dialog( "close" ); },
      Guardar: function()  { proc_validar_contact(); }     
    }
  });
  $('#proc_dialog_contact_nvo').dialog({ width: 600 });
  $( "#proc_add_contact" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    }).click(function() {
      proc_edit_contact(0);
    });  
}

function pro_delete_contact(value){
    $( "#proc_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          proc_send_delete_contact(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#proc_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#proc_dialog_confirm").dialog("open");
}

function proc_send_delete_contact(value){
    $.ajax({
        url: "index.php?m=mProtocolos&c=mDelContact",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#proc_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#proc_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#proc_dialog_message" ).dialog('open');
              enable_contacts(1);
          }else if(result=='no-perm'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#proc_dialog_message" ).dialog('open');       
          }
        }
    });
}

function proc_edit_contact(value){
    var client = $("#global_id_client").val();
    var proc_id = $("#proc_txt_id_nvo").val();
      $.ajax({
          url: "index.php?m=mProtocolos&c=mGetContact",
          type: "GET",
          data: { data: value ,id_client :client , id_proc:proc_id},
          success: function(data) {            
            var result = data;             
            $('#proc_dialog_contact_nvo').html('');            
            $('#proc_dialog_contact_nvo').dialog('open');
            $('#proc_dialog_contact_nvo').html(result);
            $( "#proc_tabs2" ).tabs();
            if($("#proc_txt_id_contact").val()==0){
              $( "#proc_tabs2" ).tabs( "option", "disabled", [1]);
            }else{
              enable_medios(0);
            }            
          }
      });
}

function proc_validar_contact(){
    var error=0;  

    if($("#proc_cont_name").val()=="NULL" || $("#proc_cont_name").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el nombre del contacto.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }


    if($("#proc_cont_hf").val()=="NULL" || $("#proc_cont_hf").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la hora inicial.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#proc_cont_rol").val()=="NULL" || $("#proc_cont_rol").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la hora final.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#proc_cont_clave").val()=="NULL" || $("#proc_cont_clave").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una clave.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#proc_cont_prior").val()=="NULL" || $("#proc_cont_prior").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la prioridad del contacto.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }    

    if(error==0){ proc_send_setrow(); }
}

function proc_send_setrow(){
    var client = $("#global_id_client").val();
      $.ajax({
          url: "index.php?m=mProtocolos&c=adminSetContact",
          type: "GET",
          dataType : 'json',
          data: { 
            id_client: client,
            data : $("#proc_txt_id_contact").val(),
            proc_id : $("#proc_txt_id_protocolo").val(),
            name    : $("#proc_cont_name").val(),
            hi      : $("#proc_cont_hi").val(),
            hf      : $("#proc_cont_hf").val(),
            rol     : $("#proc_cont_rol").val(),
            clave   : $("#proc_cont_clave").val(),
            prior   : $("#proc_cont_prior").val(),
            consul  : $("#proc_cont_consul").val(),
            aut     : $("#proc_cont_aut").val()
          },
          success: function(data) {            
            var result = data.result; 
            var new_id = data.id_row

            if(result=='no-data' || result=='problem'){
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#proc_dialog_message" ).dialog('open');             
            }else if(result=='edit'){
              if($("#proc_txt_id_contact").val()==0){
                  $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente, ahora puede agregar medios de contactos.</p>');
                  $("#proc_dialog_message" ).dialog('open');                  
                  $("#proc_txt_id_contact").val(new_id);
                  enable_medios(1);
                }else{
                  $('#proc_dialog_contact_nvo').dialog('close');
                  $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                  $("#proc_dialog_message" ).dialog('open');                                    
                }
            }else if(result=='no-perm'){ 
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#proc_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#proc_dialog_message").dialog('open');       
            }
          }
        }); 
}

function enable_medios(change){
  if(change==1){
    $( "#proc_tabs2" ).tabs( "select", 1 )  
  }
  $( "#proc_tabs2" ).tabs( "enable" , 1 )  

  var id_row = $("#proc_txt_id_contact").val();
    oTable3 = $('#proc_table_medios').dataTable({
      "bDestroy": true,
      "bLengthChange": false,
      "bPaginate": true,
      "bFilter": true,
      "bSort": true,
      "bJQueryUI": true,
      "iDisplayLength": 5,      
      "bProcessing": true,
      "bAutoWidth": false,
      "bSortClasses": false,
      "sAjaxSource": "index.php?m=mProtocolos&c=mGetTableMedios&data="+id_row,
      "aoColumns": [
        { "mData": " "      , sDefaultContent: "" },
        { "mData": "NAME"   , sDefaultContent: "" },
        { "mData": "DES"    , sDefaultContent: "" },
        { "mData": "PRIORIDAD", sDefaultContent: "" },
        { "mData": "STATUS" , sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
               var edit = '<td><span class="ui-icon ui-icon-pencil" onclick="proc_edit_medio('+full.ID+');"></span></td>';            
               var del = '<td><span class="ui-icon ui-icon-trash" onclick="proc_delete_medio('+full.ID+');"></span></td>';
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

  $("#proc_dialog_medio_nvo").dialog({
    autoOpen:false,
    title:"Contacto",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:600,
    buttons: {
      Cancelar: function() { $(this).dialog( "close" ); },
      Guardar: function()  { proc_validar_medio(); }     
    }
  });
  $('#proc_dialog_medio_nvo').dialog({ width: 300});

  $( "#proc_add_medio" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    }).click(function() {
      proc_edit_medio(0);
    });
}

function proc_delete_medio(value){
    $( "#proc_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          proc_send_delete_medio(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#proc_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#proc_dialog_confirm").dialog("open");
}

function proc_send_delete_medio(value){
    $.ajax({
        url: "index.php?m=mProtocolos&c=mDelMedio",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data){
          var result = data.result;
          if(result=='no-data' || result=='problem'){
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#proc_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#proc_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#proc_dialog_message" ).dialog('open');
              enable_medios(1);
          }else if(result=='no-perm'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#proc_dialog_message" ).dialog('open');       
          }
        }
    });
}

function proc_edit_medio(value){
    var proc_id = $("#proc_txt_id_contact").val();
      $.ajax({
          url: "index.php?m=mProtocolos&c=mGetMedio",
          type: "GET",
          data: { data: value , id_contacto:proc_id},
          success: function(data) {            
            var result = data;             
            $('#proc_dialog_medio_nvo').html('');            
            $('#proc_dialog_medio_nvo').dialog('open');
            $('#proc_dialog_medio_nvo').html(result);  
          }
      });
}

function proc_validar_medio(){
    var error=0;  

    if($("#proc_med_cmedio").val()== -1){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar una forma de contacto.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#proc_med_des").val()=="NULL" || $("#proc_med_des").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir el numero ó correo de contacto.</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#proc_med_prior").val()=="NULL" || $("#proc_med_prior").val()==""){
      $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la prioridad</p>');
      $("#proc_dialog_message" ).dialog('open');  
      error++;
    }

    if(error==0){ proc_send_medio();}  
}

function proc_send_medio(){
   var client = $("#global_id_client").val();
    $.ajax({
        url: "index.php?m=mProtocolos&c=adminSetMedio",
        type: "GET",
        dataType : 'json',
        data: { 
          id_client : client,
          id_contact: $("#proc_med_id_contact").val(),
          data    : $("#proc_txt_id_medio").val(),
          des     : $("#proc_med_des").val(),
          forma   : $("#proc_med_cmedio").val(),
          status  : $("#proc_med_estatus").val(),
          prior   : $("#proc_med_prior").val()
        },
        success: function(data) {            
          var result = data.result;

          if(result=='no-data' || result=='problem'){
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
              $("#proc_dialog_message" ).dialog('open');             
          }else if(result=='edit'){                              
                $('#proc_dialog_medio_nvo').dialog('close');
                $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#proc_dialog_message" ).dialog('open');                                    
                enable_medios(0);
          }else if(result=='no-perm'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#proc_dialog_message").dialog('open');       
          }else if(result=='on-use'){ 
              $('#proc_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
              $("#proc_dialog_message").dialog('open');       
          }
        }
      }); 
}