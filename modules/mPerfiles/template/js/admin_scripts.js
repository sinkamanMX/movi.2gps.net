var oTable;
var pro_apermisos = Array();

$(document).ready(function () {
  pro_load_datatable();
  $( "#pro_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  //Dialog generico   
  $( "#pro_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top", of: '#opts_div' },
    buttons: {
    Cancelar: function() {
      $("#pro_dialog_nvo" ).dialog( "close" );
      },
    Guardar: function() {
      pro_validar_nvo();
      }     
    }
  });
    $( "#pro_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#pro_dialog_message" ).dialog( "close" );
        }
      }
    });
  
  
});  

function pro_load_datatable(){
    var client = $("#global_id_client").val();    
    oTable = $('#pro_table').dataTable({
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
    "sAjaxSource": "index.php?m=mPerfiles&c=adminGetTable&id_client="+client,
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
        { "mData": "ID", sDefaultContent: "" },
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "ESTATUS", sDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';
                edit = "<td><div onclick='pro_edit_function("+full.ID+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";   
                del = "<td><div onclick='pro_delete_function("+full.ID+");' class='custom-icon-delete-custom'>"+
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

  function pro_edit_function(value){
    var client = $("#global_id_client").val();       
      $.ajax({
          url: "index.php?m=mPerfiles&c=adminGetPerfil",
          type: "GET",
          data: { data: value ,id_client :client },
          success: function(data) {
            var result = data; 
            $('#pro_dialog_nvo').html('');
            $('#pro_dialog_nvo').dialog('open');
            $('#pro_dialog_nvo').html(result); 
            $('#pro_accordion').accordion();
          }
      });
  }

  function pro_delete_function(value){
    $( "#pro_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          pro_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#pro_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#pro_dialog_confirm").dialog("open");

  }

  function pro_send_delete(value){
    $.ajax({
        url: "index.php?m=mPerfiles&c=mDelPerfil",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#pro_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#pro_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#pro_dialog_message" ).dialog('open');
              pro_load_datatable();
          }else if(result=='no-perm'){ 
              $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#pro_dialog_message" ).dialog('open');       
          }
        }
    });
  }

  function pro_select_menu(pro_id_submenu){
    var element   = $('#pro_acordeon_icon_'+pro_id_submenu);
    var className = element.attr('class');

    if(className=='icon_unit_unselected'){
      element.removeClass('icon_unit_unselected').addClass('icon_unit_selected');      
      $('#pro_select'+pro_id_submenu).prop('disabled', false);
    }else if(className=='icon_unit_selected'){
      $('#pro_select'+pro_id_submenu).prop('disabled', true);
      element.removeClass('icon_unit_selected').addClass('icon_unit_unselected');
    }
  }

  function pro_validar_nvo(){
    pro_apermisos = Array();
    var error=0;  

    if($("#pro_txt_name").val()=="NULL" || $("#pro_txt_name").val()==""){
      $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una nombre del Perfil.</p>');
      $("#pro_dialog_message" ).dialog('open');  
      error++;
    }

    $('#pro_acordeon select').each(function(id){
      if($(this).prop('disabled')==false){ 
          pro_apermisos.push($(this).val()+'|'+$(this).attr('id'));
      }
    });

    if(pro_apermisos.length<1){
      $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar al menos un modulo y sus permisos.</p>');
      $("#pro_dialog_message" ).dialog('open');         
      error++;
    }

    if(error==0){ pro_send_row(); }
  }

  function pro_send_row(){
    var client = $("#global_id_client").val();      
      $.ajax({
          url: "index.php?m=mPerfiles&c=adminSetPerfil",
          type: "GET",
          dataType : 'json',
          data: { 
            id_client: client,            
            pro_id:  $("#pro_txt_id").val(), 
            name :   $("#pro_txt_name").val(),
            estatus: $("#pro_sel_estatus").val(),
            permisos: pro_apermisos
          },
          success: function(data) {
            console.log(data);
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#pro_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#pro_dialog_nvo').dialog('close');
                $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#pro_dialog_message" ).dialog('open');
                pro_load_datatable();
            }else if(result=='no-perm'){ 
                $('#pro_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#pro_dialog_message").dialog('open');       
            }
          }
        }); 
  }