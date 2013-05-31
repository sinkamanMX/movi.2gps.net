var map;
var units = Array();
var point_pan;
var myPano;  
var id_unit="";

$(document).ready(resetShow);
function resetShow(){
	//alert( $("#RightPane").width() );
	var anRightPane = $("#RightPane").width()/2;
	var anShowL 	= $("#showL").width()/2;
	
	var a_rp= anRightPane - anShowL;
	alert(anRightPane+" - "+anShowL+" - "+a_rp);
	$("#showL").css("left",a_rp);
}

function init(){
	onload_map();
	listUnits();
}

function onload_map(){
	if (GBrowserIsCompatible()) {
        map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(19.508090,-99.234310), 4);
        var customUI = map.getDefaultUI();    
        customUI.maptypes.hybrid = true;
        map.setUI(customUI);
	}
/*		muestra_datos();
		myEventListener = GEvent.bind(map, "click", this, function(overlay, latlng) {
			if (latlng) {
				latitud  = latlng.lat();
				longitud = latlng.lng();
				var r_lat = Math.round(latitud*1000000)/1000000;
				var r_lon = Math.round(longitud*1000000)/1000000;				
				document.getElementById("txt_lat").value = r_lat;
				document.getElementById("txt_lon").value = r_lon;									
			}});
	  }	*/
}

function listUnits(){
	$("#listUnits").html("");
	$.ajax({
		type: "GET",
        url: "index.php?m=silver&c=listUnits",
        data: "",
        success: function(datos){
			$("#listUnits").html(datos);
			$("#example").treeview();
        }
	});
}

function select_cheks(name,tnodes,nodes,tunidades){	
//	alert("change");
	if(tunidades>0){
		for(var i=1 ; i<=tunidades;i++){	
			$("#"+name+"ch"+i).attr('checked', $('#' + name).is(':checked'));
			$("#"+name+"ch"+i).change();
		}
	}	
	
	if(tnodes>0){
		var nodos = nodes;
		var allnodos = nodos.split(',');
		for (var i=0;i<allnodos.length;i++){
			$("#idg"+allnodos[i]).attr('checked', $('#' + name).is(':checked'));
			$("#idg"+allnodos[i]).change();
		}		
	}
	
	var time = 1; //time in seconds
    var interval = time * 1000; 
	$(document).oneTime(interval, function(i) { muestra_seleccionados(); }, 0);			
}

function select_unit(idunit,name){
	var check = $('#' + name).is(':checked');
	var existe = $.inArray(idunit, units);	
	
	if(check){		
		if(existe==-1){
			units.push(idunit);					
		}
	}else{
		if(existe>-1){	
			units.splice( $.inArray(idunit, units), 1 );	
		}
	}
	var time = 1; //time in seconds
    var interval = time * 1000; 
	$(document).oneTime(interval, function(i) { muestra_seleccionados(); }, 0);			
}

var print_units=0;
var a_alertas= Array();

function muestra_seleccionados(){	
	if(print_units==0){
		map.clearOverlays();
		if(units.length>0){
			a_alertas= Array();
			print_units=1;
			var path = "index.php?m=silver&c=mGetPunits&unts="+units;
			$.getJSON(path,function(data) {
				var points = [];
			    $.each(data.items, function(i,item){
					var point = new GLatLng(item.unitLatitude, item.unitLong);		
					points.push(point);		    		
					if(item.show==1){
						var message = "<tr><td>" + item.dunit +"</td>"+
									  "<td>" + item.evt   +"</td>"+
									  "<td>" + item.fecha +"</td>"+
									  "<td>" + item.dir   +"</td></tr>";
						a_alertas.push(message);			  
					}
					//alert(item.dunit+" - "+item.evt);
					var info = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+
				  '<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_streetview();" class="thickbox popUp">Ver Street View</a></b><br></td></tr>'+'<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="seguimiento_id(\''+ item.unit +'\');" class="popUp">Seguimiento</a></b></td></tr>'+'<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_prod_id(\''+ item.unit +'\')" class="popUp">Vista Productividad</a></b></td></tr>'+
  				  '</table>'
					map.addOverlay(createUnits(point, i,item.unit,item.unitLatitude,item.unitLong,info));
	    		});
				muestra_todo(points);
				detalle_upocisiones();
				muestra_alertas();
				print_units=0;				
  			});			
		}else{
			detalle_upocisiones();
			muestra_alertas();
		}
	}
}

function muestra_alertas(){
	if(units.length>0){
		if(a_alertas.length>0){
			var info_a = '<table><tr><td><b>Unidad </b></td>'+
									'<td><b>Evento </b></td>'+
									'<td><b>Fecha  </b></td>'+
									'<td><b>Dirección  </b></td></tr>';
			for(var i=0; i <a_alertas.length; i++){
				info_a = info_a + a_alertas[i];	
			}		
			info_a = info_a + '</table>';
			jAlert(info_a, 'Alertas', function() {
				$.alerts.dialogClass = null; // reset to default
			});
		}
	}
}


function muestra_todo(points){
	var latlngbounds = new GLatLngBounds( );
	for ( var i = 0; i < points.length; i++ ){
		latlngbounds.extend( points[ i ] );
	}
	map.setCenter( latlngbounds.getCenter( ), map.getBoundsZoomLevel( latlngbounds ) );
}	

function createUnits(point,index,uni,lat,lon,info) {
	var baseIcon = new GIcon(G_DEFAULT_ICON);
        baseIcon.shadow = "";
        baseIcon.iconSize = new GSize(20, 22);
        baseIcon.iconAnchor = new GPoint(9, 34);
        baseIcon.infoWindowAnchor = new GPoint(9, 2);
	var icon = "public/images/icon62.png";
    var costumIcon = new GIcon(baseIcon);
        costumIcon.image = icon; 
    markerOptions = { icon:costumIcon };
		
	var marker = new GMarker(point, markerOptions);		
       GEvent.addListener(marker, "click", function() {	
		marker.openInfoWindowHtml(info);
		map.setCenter(point, 17);													 
		//getUnitsInfo(uni, 0 , lat , lon);
	    //marker.openInfoWindowHtml("Marker <b>ejemplo</b>");
	  });
	return marker;
}

/*
GEvent.addListener(marker, "click", function() {
		marker.openInfoWindowHtml(info);
		map.setCenter(point, 17);
	});
*/

var print_lastp=0;

function muestra_upocisiones(){		
	if(print_lastp==0){
		if(units.length>0){
			print_lastp=1;
			var path = "index.php?m=silver&c=mGetPunits&unts="+units;
			$.getJSON(path,function(data) {
				var points = [];
			    $.each(data.items, function(i,item){
					var point = new GLatLng(item.unitLatitude, item.unitLong);		
					points.push(point);
					map.addOverlay(createUnits(point, i,item.unit,item.unitLatitude,item.unitLong));					
	    		});
				muestra_todo(points);
				print_units=0;								
  			});			
		}else{
			detalle_upocisiones();
		}
	}
}


function detalle_upocisiones(){
	$("#detalle_unitsf").html("Cargando información...<img src=public/images/wait.gif>");
	if(units.length>0){			
		$.ajax({
			type: "GET",
	        url: "index.php?m=silver&c=mLastPositions&unts="+units,
	        data: "",
    	    success: function(datos){
				var respuesta = datos;
				if(respuesta != 0){
					$("#detalle_unitsf").html(datos);
					tigra_tables('tdet_units', 0, 0, '#ffffff', '#DDD', '#AEC7F3', '#5283D8');
					contextmenu();
					/*$("#map").css("height", "400px").trigger("resize");	
					$("#BottomPane").css("height", "300px").trigger("resize");*/
				}else{
					$("#detalle_unitsf").html("");
				}
	        }
		});	
	}else{
		$("#detalle_unitsf").html("No hay unidades seleccionadas.");	
	}
}

function detalle_alertas(){

}

function contextmenu() {				
	$("#app_info_det").contextMenu({
		menu: 'Menu_det_units'   //Nombre del DIV
	},

	function(action, el, pos) {
		if(action == "edit"){
			seguimiento();
		}else if(action == "cut"){					
			show_prod();
		}else if(action == "street"){
			show_streetview();
		}
	});																	
}

function center_map(lat,lon,unity,evt,vel){
	var point = new GLatLng(lat,lon);		
	var infort = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+
				  '<tr><td align="left">Unidad   	 :</td><td align="left">'+ unity	+'</td></tr>'+
				  '<tr><td align="left">Evento       :</td><td align="left">'+ evt	+'</td></tr>'+
				  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ vel	+'</td></tr>'+
  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_streetview();" class="thickbox">Ver Street View</a></b><br></td></tr>'+
				  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="seguimiento();" >Seguimiento</a></b></td></tr>'+
				  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_prod();">Vista Productividad</a></b></td></tr>'+				  
				  '</table>';
	point_pan = point;				  
	map.setCenter(point, 17);        
	map.openInfoWindowHtml(point,infort);
}

function show_streetview(){
	var title = '';
	var name  =	''; 					  
	var href  = '#TB_inline?height=330&width=515&inlineId=streetviewer&modal=true';
	var alt   = '';
	var rel   = true;
	var t = title || name || null;
	var a = href  || alt;
	var g = rel   || false;
	tb_show(t,a,g);	
	onloadpan();
}

function onloadpan(){
	myPano = new GStreetviewPanorama(document.getElementById("pano"));
    GEvent.addListener(myPano, "error", handleNoFlash);	
	$("#pano").html("");		
	myPano.setLocationAndPOV(point_pan);
	var time = 5; //time in seconds
    var interval = time * 1000; 
	$(document).oneTime(interval, function(i) { no_street_view(); }, 0);		
}
    
function handleNoFlash(errorCode) {
	if (errorCode == 603) {
        alert("Error: Flash doesn't appear to be supported by your browser");
       return;
     }
} 
	
function close_street(){	
	$("#pano").html("");
	tb_remove();
}

function no_street_view(){
	if($("#pano").html() == ""){
		$("#pano").html("<b>Street View no cuenta con una vista de este lugar.</b>");			
	}
}

function change_id(id){
	id_unit	 = id;
}

function seguimiento(){	
	var url =  'index.php?m=silver&c=mFollow&sesdtmp='+id_unit;	
	window.open(url,'Seguimiento', "width=800,height=600");	
}

function seguimiento_id(ide){	
	var url =  'index.php?m=silver&c=mFollow&sesdtmp='+ide;	
	window.open(url,'Seguimiento', "width=800,height=600");	
}

function show_prod(){	
	var url =  'index.php?m=silver&c=mProductivity&itmp='+id_unit;
	window.open(url,'Seguimiento', "width=800,height=600");
}

function show_prod_id(idU){	
	var url =  'index.php?m=silver&c=mProductivity&itmp='+idU;
	window.open(url,'Seguimiento', "width=800,height=600");
	
}

var maxim=0;
function minimizar(){
	if(maxim==0){
		$("#div_content").show("fast");		
		maxim=1;
		$("#div_infou").animate({"bottom": "0px"}, 200);	
	}else{
		$("#div_content").hide("slow");
 		maxim=0;
 		$("#div_infou").animate({"bottom": "-=150px"}, 200); 		
	}
}


function obtener_posicion(ide,chkbx){
	var chkTmp = eval("$('#"+chkbx+"').is(':checked')");
//	alert(chkTmp);
	if(chkTmp){
		var path = "index.php?m=silver&c=mGetPunits&unts="+ide;
		$.getJSON(path,function(data) {
			var points = [];
			$.each(data.items, function(i,item){
				//alert(item.unitLatitude+" , "+item.unitLong+" , "+item.dunit+" , "+item.evt+" , "+item.vel);
				var point = new GLatLng(item.unitLatitude, item.unitLong);		
				/**/
				var infort = '<table style="font:10px Verdana, Geneva, sans-serif;" class="infoGlobe"><tr><th colspan="2">Informacion de la Unidad</th></tr>'+
							  '<tr><td align="left">Unidad   	 :</td><td align="left">'+ item.dunit +'</td></tr>'+
							  '<tr><td align="left">Evento       :</td><td align="left">'+ item.evt	+'</td></tr>'+
							  '<tr><td align="left">Velocidad	 :</td><td align="left">'+ item.vel	+'</td></tr>'+
			  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_streetview();" class="thickbox">Ver Street View</a></b><br></td></tr>'+
							  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="seguimiento_id(\''+ item.unit +'\');" >Seguimiento</a></b></td></tr>'+
							  '<tr><td colspan="2" align="left"><b><a href="javascript:" onclick="show_prod_id(\''+ item.unit +'\');">Vista Productividad</a></b></td></tr>'+				  
							  '</table>';
				point_pan = point;				  
				map.setCenter(point, 17);        
				map.openInfoWindowHtml(point,infort);
				/**/
				//center_map(item.unitLatitude,item.unitLong,item.dunit,item.evt,item.vel);
	    	});		
		});
	}else{
		return false;
	}
	
}