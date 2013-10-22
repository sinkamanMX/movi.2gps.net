$(document).ready(function(){
	$( "#tabs" ).tabs({ 
    	select: function(event, ui){ 
        	tab_active = ui.index; 

        	if(tab_active==1){
				mon_refresh_units();				
				setTimeout(function(){
				        google.maps.event.trigger(map, 'resize');}, 500);
				
        	}else{
        		stopTimer();
        	}        	

    	} 
	});

	loadDashBoard();
		
	$( "#dialog_message" ).dialog({
		autoOpen:false,
		modal: false,
		buttons: {
			Aceptar: function() { 
				$("#dialog_message" ).dialog( "close" );
			}
		}
	});	

	$( "#mon_dialog" ).dialog({
		autoOpen:false,
		modal: true,
		resizable: false,
		title: "Envio de Comandos",
		buttons: {
			Enviar: function() {
				mon_send_command()
			}
		}
	});		


	$( "#mon_dialogAll" ).dialog({
		autoOpen:false,
		modal: true,
		resizable: false,
		title: "Envio de Comandos",
		buttons: {
			Enviar: function() {
				sendCommands()
			}
		}
	});		

	$("#gral_button_close").click(function() {
		location.href='index.php?m=login&c=login&md=lo';
	});

	$("#gral_button_admin").click(function() {
		location.href='index.php?m=mAdmin';
	});		

	$("#gral_button_manual").click(function() {
		window.open('/manuals/manual.pdf');
	}); 

	$("#gral_button_events").click(function() {
			var caracteristicas = "height=560,width=660,scrollTo,resizable=1,scrollbars=1,location=0";
		nueva=window.open("index.php?m=mMonitoreo&c=mShowEvents", 'Popup', caracteristicas);
	});

	tabAd();
	tabRe();
	onload_map();
});	

function loadDashBoard(){
	$("#DashBoard").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mReports&c=default",
        data: "",
        success: function(datos){
			if(datos!=0){
				$("#DashBoard").html(datos);
			}else{
				$("#DashBoard").html("");
			}
        }
	});
}


function menudefault(){
	$("#accordion_container").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mMonitoreo&c=menu",
        data: "",
        success: function(datos){
			if(datos!=0){
				$("#accordion_container").html(datos);
			}else{
				$("#accordion_container").html("No se han Creado un menú");
			}
			
        }
	});
}

//---------------------------------------------
function tabAd(){
	$("#Admon").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mAdmon&c=default",
        data: "",
        success: function(datos){
			//alert(datos)
			if(datos!=0){
				$("#Admon").html(datos);
				menuAd();

			}else{
				$("#Admon").html("No se han Creado Grupos");
			}
			
        }
	});
}
//---------------------------------------------
function menuAd(){
	$("#adn_menu").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mAdmon&c=menu",
        data: "",
        success: function(datos){
			//alert(datos)
			if(datos!=0){
				$("#adn_menu").html(datos);
				//document.getElementById('adn_menu').innerHTML = datos;
				//$("#adn_menu").css('border-color', 'red');

			}else{
				$("#adn_menu").html("No se han Creado Grupos");
			}
			
        }
	});
}
//---------------------------------------------
function tabRe(){
	$("#Report").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mReportes&c=default",
        data: "",
        success: function(datos){
			if(datos!=0){
				$("#Report").html(datos);
				menuRe();

			}else{
				$("#Report").html("No se han Creado Grupos");
			}
			
        }
	});
}
//---------------------------------------------
function menuRe(){
	$("#rep_menu").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mReportes&c=menu",
        data: "",
        success: function(datos){
			//alert(datos)
			if(datos!=0){
				$("#rep_menu").html(datos);
				//document.getElementById('adn_menu').innerHTML = datos;
				//$("#adn_menu").css('border-color', 'red');

			}else{
				$("#rep_menu").html("No se han Creado Grupos");
			}
			
        }
	});
}
//---------------------------------------------
function tabAj(){
	$("#Ajuste").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=mAjuste&c=default",
        data: "",
        success: function(datos){
			if(datos!=0){
				$("#Ajuste").html(datos);

			}else{
				$("#Ajuste").html("No se han Creado Grupos");
			}
			
        }
	});
}