var oTable;
var grp_apermisos = Array();

$(document).ready(function (){
  grp_load_datatable();
  $( "#grp_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  //Dialog generico   
  $( "#grp_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:500,
    buttons: {
    Cancelar: function() {
      $("#grp_dialog_nvo" ).dialog( "close" );
      },
    Guardar: function() {
      grp_validar_nvo();
      }     
    }
  });
    $( "#grp_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#grp_dialog_message" ).dialog( "close" );
        }
      }
    });

  // custom css expression for a case-insensitive contains()
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };

});  

function grp_load_datatable(){
    var client = $("#global_id_client").val();
    oTable = $('#grp_table').dataTable({
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
      "sAjaxSource": "index.php?m=mGrupos&c=adminGetTable&id_client="+client,
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
        /*{ "mData": "ID", sDefaultContent: "" },*/
        { "mData": "DESCRIPCION", sDefaultContent: "" },
        { "mData": "N_PADRE", sDefaultContent: "" },
        { "mData": "NOMBRE", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            edit = "<td><div onclick='grp_edit_function("+full.ID+");' class='custom-icon-edit-custom'>"+
                    "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                    "</div></td>";        
        
            del = "<td><div onclick='grp_delete_function("+full.ID+");' class='custom-icon-delete-custom'>"+
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

  function grp_edit_function(value){
    var client = $("#global_id_client").val();
      $.ajax({
          url: "index.php?m=mGrupos&c=adminGetRow",
          type: "GET",
          data: { data: value ,id_client :client },
          success: function(data) {            
            var result = data;             
            $('#grp_dialog_nvo').html('');
            $('#grp_dialog_nvo').dialog('open');
            $('#grp_dialog_nvo').html(result); 

            $( "#sortable1, #sortable2" ).sortable({
                  connectWith: ".connectedSortable"
                });
            listFilter($("#sortable2"),$("#grp_search_av"));
            listFilter($("#sortable1"),$("#grp_search_na"));
          }
      });
  }

  function grp_delete_function(value){
    $( "#grp_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          grp_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#grp_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#grp_dialog_confirm").dialog("open");

  }

  function grp_send_delete(value){
    $.ajax({
        url: "index.php?m=mGrupos&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#grp_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#grp_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#grp_dialog_message" ).dialog('open');
              grp_load_datatable();
          }else if(result=='no-perm'){ 
              $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#grp_dialog_message" ).dialog('open');       
          }
        }
    });
  }

  function grp_add_all(){
    $('#sortable1 li').each(function(id){
      $('#sortable2').append("<li class='ui-state-default' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });  
  }

  function grp_remove_all(){
    $('#sortable2 li').each(function(id){
      $('#sortable1').append("<li class='ui-state-default' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });      
  }

  function grp_validar_nvo(){
    grp_apermisos = Array();
    var error=0;  

    if($("#grp_txt_name").val()=="NULL" || $("#grp_txt_name").val()==""){
      $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una el nombre de Grupo.</p>');
      $("#grp_dialog_message" ).dialog('open');  
      error++;
    }

   if($("#grp_txt_nameshort").val()=="NULL" || $("#grp_txt_nameshort").val()==""){
      $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la abreviatura que tendra el grupo.</p>');
      $("#grp_dialog_message" ).dialog('open');  
      error++;
    }    

    $('#sortable1 li').each(function(id){
       grp_apermisos.push($(this).val());      
    });       

    if(error==0){ grp_send_row(); }
  }

  function grp_send_row(){
    var client = $("#global_id_client").val();
      $.ajax({
          url: "index.php?m=mGrupos&c=adminSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
            id_client: client,
            grp_id  :  $("#grp_txt_id").val(),
            name    :  $("#grp_txt_name").val(),
            abr     :  $("#grp_txt_nameshort").val(),
            padre   :  $("#grp_sel_padre").val(),
            permisos: grp_apermisos
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#grp_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#grp_dialog_nvo').dialog('close');
                $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#grp_dialog_message" ).dialog('open');
                grp_load_datatable();
            }else if(result=='no-perm'){ 
                $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#grp_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#grp_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#grp_dialog_message").dialog('open');       
            }
          }
        }); 
  }

  function listFilter(list,input)
  {
    $(input)
      .change( function () {        
        var filter = $(this).val();
        if(filter) {
          // this finds all links in a list that contain the input,
          // and hide the ones not containing the input while showing the ones that do
          $(list).find("a:not(:Contains(" + filter + "))").parent().slideUp();
          $(list).find("a:Contains(" + filter + ")").parent().slideDown();
        } else {
          $(list).find("li").slideDown();
        }
        return false;
      })
    .keyup( function () {
        // fire the above change event after every letter
        $(this).change();
    });
  }  