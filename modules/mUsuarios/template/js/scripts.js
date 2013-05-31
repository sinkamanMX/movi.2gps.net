var oTable;
var user_apermisos = Array();
var user_units     = Array();
var user_units_com = Array();
var user_units_com_sel = Array();

$(document).ready(function (){
  user_load_datatable();
  $( "#user_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  //Dialog generico   
  $( "#user_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:650,
    buttons: {
    Cancelar: function() {
      $("#user_dialog_nvo" ).dialog( "close" );
      },
    Guardar: function() {
      user_validar_nvo();
      }     
    }
  });
    $( "#user_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#user_dialog_message" ).dialog( "close" );
        }
      }
    });   


  // custom css expression for a case-insensitive contains()
  jQuery.expr[':'].Contains = function(a,i,m){
      return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
  };

});  

function user_load_datatable(){
    oTable = $('#user_table').dataTable({
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
      "sAjaxSource": "index.php?m=mUsuarios&c=mGetTable",
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
        { "mData": "NOMBRE", sDefaultContent: "" },
        { "mData": "USUARIO", sDefaultContent: "" },
        { "mData": "ESTATUS", sDefaultContent: "" },
        { "mData": "CREADO", sDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            if($("#user_update").val()==1){
                edit = "<td><div onclick='user_edit_function("+full.ID+");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";
            }
            
            if($("#user_delete").val()==1){
                del = "<td><div onclick='user_delete_function("+full.ID+");' class='custom-icon-delete-custom'>"+
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

  function user_edit_function(value){
   user_units_com = Array();
   							
	  $.ajax({
          url: "index.php?m=mUsuarios&c=mGetRow",
          type: "GET",
          data: { data: value },
          success: function(data) {            
            var result = data;             
            $('#user_dialog_nvo').html('');
            $('#user_dialog_nvo').dialog('open');
            $('#user_dialog_nvo').html(result); 
            $('#user_accordion').accordion({ autoHeight: false, clearStyle: true });
            $('#user_select_perfil').change(function() {


              if($(this).val()>0){
                user_load_permisos();
                user_load_comands();
              }else if($(this).val()== -1){
                $('#user_accordion').html('');
              }
            });
            $('#user_excepciones').accordion({
              autoHeight: false,
              clearStyle: true
            });  
            $('#user_chk_pass').change(function() {
                var target = $(this);
                var select = target.prop("checked");
                if(select){
                  $('#user_txt_pass').prop('disabled', false);
                }else{
                  $('#user_txt_pass').prop('disabled', true);
                }
            });   
            $( "#user_tabs" ).tabs();   
			
							if(value!=0){
								$('#comand').css("display","inline");
								}else{
								$('#comand').css("display","none");
							}
            
			$( "#sortable2" ).sortable({
                  connectWith: ".connectedSortable",
				  receive: function(event, ui) { 
				  $('#sortable1').each(function(){
				  	var sortorder='';
					var itemorder=$(this).sortable('toArray').toString();
					var columnId=$(this).attr('id');
					sortorder=itemorder.toString();
					//alert(sortorder);
					if(sortorder==''){
						$('#comand').css("display","none");
						}
						//user_load_comands(1);
				  });
				  }
				  
				    }).disableSelection();
				
			$( "#sortable1" ).sortable({
                  connectWith: ".connectedSortable",
				  receive: function(event, ui) { 
				  $('#sortable1').each(function(){
				  		
						
   						//user_load_comands(1);
						$('#comand').css("display","inline");
				  });
				  }
				    }).disableSelection();
					
				
					
				
				$( "#com_sortable1, #com_sortable2" ).sortable({
                  connectWith: ".connectedSortable",
				  receive: function(event, ui) { 
							$(ui.item).find('li').click();
							var sortorder='';
							$('#com_sortable1, #com_sortable2').each(function(){
									
									var itemorder=$(this).sortable('toArray').toString();
									var columnId=$(this).attr('id');
									sortorder=itemorder.toString();
								
								
									
								
								});
							 }
				  
				  
                }).disableSelection();
				
					
				
				
            listFilter($("#sortable2"),$("#grp_search_av"));
            listFilter($("#sortable1"),$("#grp_search_na"));    
			
			listFilter($("#com_sortable2"),$("#grp_search_coman"));
            listFilter($("#com_sortable1"),$("#grp_search_com_env"));   

            $('#user_select_grupo').change(function() {
              if($(this).val()>0){
                user_load_units();
              }else if($(this).val()== -1){
                $('#user_accordion').html('');
              }
            });

          }



      });
  }


	function user_load_comands(){
    user_units_com=[];
    var units = '';
    $('#sortable1 li').each(function(id){
      user_units_com.push($(this).attr('id'));
    });     
    if(user_units_com.length>-1){
			var lista=user_units_com.toString();
        $('#com_sortable2').empty();
        $('#com_sortable1').empty();
        $.ajax({
            url: "index.php?m=mUsuarios&c=mGetRowCom",
            type: "GET",
            data: { data: $("#user_txt_id").val(),
                cod_enty : lista},
            success: function(data) {            
              var result = data;               
                var divi=result.split('|');
                if(divi.length>0){
                  if(divi[0]!=0 && divi[0]!=' ' ){
                    $(divi[0]).appendTo("#com_sortable2");
                  }
                  if(divi[1]!=0 && divi[1]!=' ' ){
                    $(divi[1].toString()).appendTo("#com_sortable1");  
                  }
                }               
            }
          });
      }
		}

  function user_load_permisos(){
      $.ajax({
          url: "index.php?m=mUsuarios&c=mGetPermisos",
          type: "GET",
          data: { data: $('#user_select_perfil').val() },
          success: function(data) {            
            var result = data; 
            $('#user_accordion').html('');
            if(result!="no-data"){
              $('#user_accordion').html(result); 
              $('#user_accordion').accordion( "destroy" );
              $('#user_accordion').accordion({
                autoHeight: false,
                clearStyle: true
              });
            }else{
              $('#user_accordion').html('Este perfil no tiene permisos.'); 
            }
          }
      });
  }

  function user_load_units(){
      $.ajax({
          url: "index.php?m=mUsuarios&c=mGetUnits",
          type: "GET",
          data: { data: $("#user_txt_id").val(),
                  grupo_id : $('#user_select_grupo').val()},
          success: function(data) {            
            var result = data; 
            $('#user_accordion').html('');
            if(result!="no-data"){

              $('#sortable2').html(result); 
              $( "#sortable1, #sortable2" ).sortable({
                    connectWith: ".connectedSortable"
                  }).disableSelection();
              listFilter($("#sortable2"),$("#grp_search_av"));
              listFilter($("#sortable1"),$("#grp_search_na"));   

            }else{
              $('#user_accordion').html('Este grupo no tiene unidades.'); 
            }
          }
      });
  }  

  function user_delete_function(value){
    $( "#user_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          user_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#user_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#user_dialog_confirm").dialog("open");

  }

  function user_send_delete(value){
    $.ajax({
        url: "index.php?m=mUsuarios&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#user_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#user_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#user_dialog_message" ).dialog('open');
              user_load_datatable();
          }else if(result=='no-perm'){ 
              $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#user_dialog_message" ).dialog('open');       
          }
        }
    });
  }

  function user_select_menu(user_id_submenu){
    var element   = $('#user_acordeon_icon_'+user_id_submenu);
    var className = element.attr('class');

    if(className=='icon_unit_unselected'){
      element.removeClass('icon_unit_unselected').addClass('icon_unit_selected');      
      $('#user_select'+user_id_submenu).prop('disabled', false);
    }else if(className=='icon_unit_selected'){
      $('#user_select'+user_id_submenu).prop('disabled', true);
      element.removeClass('icon_unit_selected').addClass('icon_unit_unselected');
    }
  }

  function user_validar_nvo(){
    user_apermisos = Array();
    user_units = Array();
    var error=0;  

    if($("#user_txt_name").val()=="NULL" || $("#user_txt_name").val()==""){
      $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una el nombre del usuario.</p>');
      $("#user_dialog_message" ).dialog('open');  
      error++;
    }

    if($("#user_txt_mail").val()=="NULL" || $("#user_txt_mail").val()==""){
        $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                        '</span>Debe escribir un correo electrónico para el usuario.</p>');
        $("#user_dialog_message" ).dialog('open');  
        error++;      
    }else{
      var validar = validar_email($("#user_txt_mail").val());
      if(!validar){ 
        $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                        '</span>Debe escribir un correo electrónico válido para el usuario.</p>');
        $("#user_dialog_message" ).dialog('open');  
        error++;
      }      
    }

    if($("#user_txt_usuario").val()=="NULL" || $("#user_txt_usuario").val()==""){
      $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir para el usuario.</p>');
      $("#user_dialog_message" ).dialog('open');  
      error++;
    }    

    if($("user_select_perfil").val()>-1){
      $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar el perfil del usuario.</p>');
      $("#user_dialog_message" ).dialog('open');  
      error++;        
    }

    if($("user_select_grupo").val()>-1){
      $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar un grupo al usuario.</p>');
      $("#user_dialog_message" ).dialog('open');  
      error++;        
    }    

    if($("#user_txt_id").val()!=0 && $("#user_txt_pas_ant").val()!=""){
      if($("#user_chk_pass").prop('checked')){
        if($("#user_chk_pass").val()=="NULL" || $("#user_txt_pass").val()==""){
          $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                          '</span>Debe escribir la contraseña del usuario.</p>');
          $("#user_dialog_message" ).dialog('open');  
          error++;
        }                 
      }
    }else{
      if($("#user_txt_pass").val()=="NULL" || $("#user_txt_pass").val()==""){
        $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                        '</span>Debe escribir la contraseña del usuario.</p>');
        $("#user_dialog_message" ).dialog('open');  
        error++;
      }       
    }
    
    $('#user_acordeon2 select').each(function(id){
      if($(this).prop('disabled')==false){ 
          user_apermisos.push($(this).val()+'|'+$(this).attr('id'));
      }
    });

	


    $('#sortable1 li').each(function(id){
       user_units.push($(this).val()+'|'+$(this).attr('id'));
    });     

    if(error==0){ user_send_row(); }
  }

  function user_send_row(){
	     
	$('#com_sortable1 li').each(function(id){
       user_units_com_sel.push($(this).attr('id'));
    });  
	
	var nuev=user_units_com_sel.toString();
	
      $.ajax({
          url: "index.php?m=mUsuarios&c=mSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
            user_id :  $("#user_txt_id").val(),             
            name    :  $("#user_txt_name").val(),
            email   :  $("#user_txt_mail").val(),
            perfil  :  $("#user_select_perfil").val(),
            user    :  $("#user_txt_usuario").val(),
            pass    :  $("#user_txt_pass").val(),
            estatus :  $("#user_sel_estatus").val(),
            grupo   :  $("#user_select_grupo").val(),
            permisos: user_apermisos,
            units   : user_units,
			com     :  nuev
			
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#user_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#user_dialog_nvo').dialog('close');
                $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#user_dialog_message" ).dialog('open');
                user_load_datatable();
            }else if(result=='no-perm'){ 
                $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#user_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#user_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#user_dialog_message").dialog('open');       
            }
          }
        }); 
		user_units_com_sel=Array();
  }

  function validar_email(valor){
        // creamos nuestra regla con expresiones regulares.
        var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
        // utilizamos test para comprobar si el parametro valor cumple la regla
        if(filter.test(valor))
            return true;
        else
            return false;
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

  function grp_add_all(){
    $('#sortable1 li').each(function(id){
      $('#sortable2').append("<li class='ui-state-default' id='"+$(this).attr('id')+"' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });  
  }

  function grp_remove_all(){
    $('#sortable2 li').each(function(id){
      $('#sortable1').append("<li class='ui-state-default' id='"+$(this).attr('id')+"' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });      
  }
  
  function grp_com_add_all(){
    $('#com_sortable1 li').each(function(id){
      $('#com_sortable2').append("<li class='ui-state-default' id='"+$(this).attr('id')+"' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });  
  }

  function grp_com_remove_all(){
    $('#com_sortable2 li').each(function(id){
      $('#com_sortable1').append("<li class='ui-state-default' id='"+$(this).attr('id')+"' value='"+$(this).val()+"'><a href='javascript:void(0)'>"+$(this).text()+"</a></li>");
      $(this).remove();    
    });      
  }