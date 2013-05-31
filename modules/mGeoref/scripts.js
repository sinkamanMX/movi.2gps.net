var oTable;
var evt_apermisos = Array();

$(document).ready(function (){
  evt_load_datatable();
  $( "#evt_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
	//alert('furula');
  //Dialog generico   
  $( "#evt_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:500,
    buttons: {
    Cancelar: function() {
      $("#evt_dialog_nvo" ).dialog( "close" );
      },
    Guardar: function() {
      evt_validar_nvo();
      }     
    }
  });
    $( "#evt_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#evt_dialog_message" ).dialog( "close" );
        }
      }
    });

  // custom css expression for a case-insensitive contains()
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };



});  

function evt_load_datatable(){
    oTable = $('#evt_table').dataTable({
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
      "sAjaxSource": "index.php?m=mEventos&c=mGetTable",
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
      
        { "mData": "DESCRIPTION", sDefaultContent: "" },
        { "mData": "PRIORITY", sDefaultContent: "" },
        { "mData": "FLAG_VISIBLE_CONSOLE", sDefaultContent: "" },
		{ "mData": "FLAG_EVENT_ALERT", sDefaultContent: "" }
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            if($("#evt_update").val()==1){
                edit = '<td><span class="ui-icon ui-icon-pencil" onclick="evt_edit_function('+full.COD_EVENT+','+'\''+full.DESCRIPTION+'\');"></span></td>';
            }
            
            if($("#evt_delete").val()==1){
                del = '<td><span class="ui-icon ui-icon-trash" onclick="evt_delete_function('+full.COD_EVENT+','+'\''+full.DESCRIPTION+'\');"></span></td>';
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

  function evt_edit_function(value){
     
	 
	 $.ajax({
          url: "index.php?m=mEventos&c=mGetRow",
          type: "GET",
          data: { data: value },
          success: function(data) {            
            var result = data;             
             $('#evt_dialog_nvo').html('');
            $('#evt_dialog_nvo').dialog('open');
            $('#evt_dialog_nvo').html(result); 
        
            $( "#sortable1, #sortable2" ).sortable({
                  connectWith: ".connectedSortable"
                });
            listFilter($("#sortable2"),$("#evt_search_av"));
            listFilter($("#sortable1"),$("#evt_search_na"));
          }
      });
	  
	  $('#colorSelector').ColorPicker({
	color: '#0000ff',
	onShow: function (colpkr) {
		$(colpkr).fadeIn(500);
		return false;
	},
	onHide: function (colpkr) {
		$(colpkr).fadeOut(500);
		return false;
	},
	onChange: function (hsb, hex, rgb) {
		$('#colorSelector div').css('backgroundColor', '#' + hex);
	}
	});
	  
  }

  function evt_delete_function(value,name){
    $( "#evt_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          evt_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#evt_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el nombre: '+name+'?</p>');
    $("#evt_dialog_confirm").dialog("open");

  }

  function evt_send_delete(value){
    $.ajax({
        url: "index.php?m=mEventos&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#evt_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#evt_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#evt_dialog_message" ).dialog('open');
              evt_load_datatable();
          }else if(result=='no-perm'){ 
              $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#evt_dialog_message" ).dialog('open');       
          }
        }
    });
  }
/*
  function evt_add_all(){
    $('#sortable1 li').each(function(id){
      $('#sortable2').append("<li class='ui-state-default' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });  
  }

  function evt_remove_all(){
    $('#sortable2 li').each(function(id){
      $('#sortable1').append("<li class='ui-state-default' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });      
  }

  function evt_validar_nvo(){
    evt_apermisos = Array();
    var error=0;  

    if($("#evt_txt_name").val()=="NULL" || $("#evt_txt_name").val()==""){
      $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una el nombre de Grupo.</p>');
      $("#evt_dialog_message" ).dialog('open');  
      error++;
    }

   if($("#evt_txt_nameshort").val()=="NULL" || $("#evt_txt_nameshort").val()==""){
      $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la abreviatura que tendra el grupo.</p>');
      $("#evt_dialog_message" ).dialog('open');  
      error++;
    }    

    $('#sortable1 li').each(function(id){
       evt_apermisos.push($(this).val());      
    });       

    if(error==0){ evt_send_row(); }
  }

  function evt_send_row(){
      $.ajax({
          url: "index.php?m=mGrupos&c=mSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
            evt_id  :  $("#evt_txt_id").val(),             
            name    :  $("#evt_txt_name").val(),
            abr     :  $("#evt_txt_nameshort").val(),
            padre   :  $("#evt_sel_padre").val(),
            permisos: evt_apermisos
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#evt_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#evt_dialog_nvo').dialog('close');
                $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#evt_dialog_message" ).dialog('open');
                evt_load_datatable();
            }else if(result=='no-perm'){ 
                $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#evt_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#evt_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#evt_dialog_message").dialog('open');       
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
  }  */