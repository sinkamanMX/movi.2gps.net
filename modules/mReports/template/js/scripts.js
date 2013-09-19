function rptsSearchResumen(){
	rpscleanTable();
	var idWeek	= $("#rptsCboWeek").val();
	var idGeo 	= $("#rptsCboGeo").val();
	
	if(idWeek < 0 || idGeo < 0){
		$("#rpsMessage").html("Favor de seleccionar No. de Semana y un Centro de Salud.");
		return false;
	}

	$.ajax({
		url: "index.php?m=mReports&c=mGetPrincipal",
		type: "GET",
		data: { 
			idWeek : idWeek,
			idGeo  : idGeo  
		 },
		success: function(data) {
			var result = data;
			if(result=='no-data'){
				$("#rpsMessage").html("Favor de seleccionar No. de Semana y un Centro de Salud.");
			}else if(result=='no-data-info'){
				$("#rpsMessage").html("No existe informacion de los datos seleccionados.");
			}else{
				rpsDrawTable(data);
			}
		}		
	});
}

function rpscleanTable(){
	$("#rpsMessage").removeClass("invisible").addClass("visible");
	$("#rpsTableContent").html("");
}

function rpsDrawTable(datainfo){
	$("#rpsMessage").removeClass("visible").addClass("invisible");
	$("#rpsTableContent").html(datainfo);

	$('#rspTableDet').dataTable({ 
	    "bDestroy": true,
	    "bLengthChange": false,
	    "bPaginate": false,
	    "bFilter": false,
	    "bSort": true,
	    "bAutoWidth": false,
	    "bSortClasses": false,              
	    "oLanguage": {
	        "sInfo": "",
	        "sEmptyTable": "",
	        "sInfoEmpty" : "",
	        "sInfoFiltered": "",
	        "sLoadingRecords": "",
	        "sProcessing": "",
	        "sSearch": "",
	        "sZeroRecords": ""
	    }
	});	
}
