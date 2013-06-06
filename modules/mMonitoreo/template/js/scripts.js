var map;  	
var tab_active=0;

$(document).ready(
	function(){
		//pestañas
		$( "#tabs" ).tabs({ 
        	select: function(event, ui) { 
            	tab_active = ui.index; 
            	if(tab_active==0){
					mon_refresh_units();
            	}else{
					stopTimer();
            	}
        	} 
    	});
    	
		//Dialog mensajes		
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

		$("#gral_button_close").click(function() {
			location.href='index.php?m=login&c=login&md=lo';
		});

		$("#gral_button_admin").click(function() {
			location.href='index.php?m=mAdmin';
		});		
					
	});

function updateFields(latInt, lonInt){
	//alert('update');
	var latInt = parseFloat(latInt);
	var lonInt = parseFloat(lonInt);
	
	$("#txt_lat").val(latInt.toFixed(6));
	$("#txt_lon").val(lonInt.toFixed(6));
	
	var point = new GLatLng(latInt,lonInt);
	point_pan = point;
	
}

function init(){
	onload_map();
	tabAd();
	tabRe();
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