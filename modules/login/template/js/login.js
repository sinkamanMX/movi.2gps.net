$(document).ready(function(){
	// a workaround for a flaw in the demo system (http://dev.jqueryui.com/ticket/4375), ignore!
	$( "#dialog:ui-dialog" ).dialog( "destroy" );

	$( "#dialog-message" ).dialog({
		autoOpen:false,
		modal: true
	});

	// panel1
	$('#panelLogin').panel({
		'controls'	: $('#cntrl').html(),
		'collapsible':false
	});
			
	$( "button", ".demo" ).button().click(function(){
		val_login();
	});

	$("#lgn_span_a").click(function(){
		rec_pass();
	});

	// dialog
	$("#dialog" ).dialog({
		title: "Nueva Pregunta",
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width: 330,
		height: 240,
		buttons: {	
			"Guardar": function(){
				dts_nq();
			},
			"Cancelar": function(){
				if($("#dialog" ).dialog('isOpen')){
				$("#dialog-message").dialog('close');
				}
				cerrar();
			}
		},
		show: "blind",
		hide: "blind"
	});
	//------------------------
	$("#dialog-confirm").dialog({
		autoOpen:false,						
		resizable: false,
		height:140,
		modal: true,
		buttons: {
			"Aceptar": function() {
			  $("#dialog-confirm").dialog('close');
			}
		}
	});

	$("#nickname").focusout(function(){
		if($(this).val()=="" || $(this).val().length==0){
			$(this).addClass('lgn_caja_error', 3000);
		}else{
			var className = $(this).attr('class');
			if( className !="lgn_caja"){
				$(this).removeClass('lgn_caja_error', 3000);
			}
		}
	});	

	$("#password").focusout(function(){
		if($(this).val()=="" || $(this).val().length==0){
			$(this).addClass('lgn_caja_error', 3000);
		}else{
			var className = $(this).attr('class');
			if( className !="lgn_caja"){
				$(this).removeClass('lgn_caja_error', 3000);
			}
		}
	});	
});



function val_login(){
	var uname = $("#nickname").val();
	var upass = $("#password").val();
	if(uname==""){
		 $("#dialog-confirm").html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">'+
		                              ' </span>Favor de ignresar el nombre de usuario.</p>');
		$("#dialog-confirm").dialog('open');
		return false;
	}
	
	if(upass==""){
		$("#dialog-confirm").html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;">'+
									' </span>Favor de ingresar la contraseña.</p>');
		$("#dialog-confirm").dialog('open');
		return false;	
	}else{
		log_in(uname,upass);
	}
}

function log_in(user,pass){
	$("#dialog-message").html('<p align="center">Accesando...<div id="progressbar"></div></p>');
	  		
	$( "#progressbar" ).progressbar({
		value:1
	});
	   
	var progressUpdater;
	setTimeout(function() {
		$("#progressbar").progressbar('value', 1);
	    progressUpdater = setInterval(function() {
	    	if ($("#progressbar").progressbar('value') == 100) {
	    		clearInterval(progressUpdater);
	    	}
	    	$("#progressbar").progressbar('value', $("#progressbar").progressbar('value') +3);
	    }, 250);
	}, 100);
	
	$("#dialog-message").dialog('open');  	
				
	$("#lgn_div_respuesta").html('');
	
    $.ajax({
        url: "index.php?m=login&c=login",
        type: "GET",
        dataType : 'json',
        data: { vuname: user, vpass: pass , md : 'lg'},
        success: function(data) {
        	var result = data.result; 
        	var module = data.url;
			    $("#dialog-message").dialog('close');
				if(result == 1){
					location.href='index.php?m=mMonitoreo&c=default';
				}else if(result == 2){
					 $("#lgn_div_respuesta").html('Por cuestion de seguridad solo se puede ingresar una vez por usuario.');
				}else{
				    $("#nickname").addClass('lgn_caja_error', 3000);
					$("#password").addClass('lgn_caja_error', 3000);
					$("#lgn_div_respuesta").html('Usuario y/o contraseña incorrectos');
				}
        }
    });
}

function rec_pass(){
	$(location).attr('href','index.php?m=mRecuperaPass&c=default');
}