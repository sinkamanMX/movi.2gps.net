$(document).ready(function(){
	var $items = $('#vtab>ul>li');
	$items.mouseover(function() {
	    $items.removeClass('selected');
	    $(this).addClass('selected');
	}).eq(0).mouseover();

	$items.click(function() {
		clearRespMsg();
		clearmsgReadIn();
	    var index = $items.index($(this));
	    $('#vtab>div').hide().eq(index).show();
	    if(index==0){
	    	$(this).addClass('selected');
			msgLoadTable();
	    }else if(index==1){
	    	$(this).addClass('selected');
	    	msgLoadTableOut();
	    }	    
	});

    $( "#dialog_msg" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#dialog_msg" ).dialog( "close" );
        }
      }
    });

	$('#vtab>div').hide().eq(0).show();	
	msgLoadTable();

    $( "#msg_button_cancelIn" ).button().click(function( event ) { clearRespMsg() });	
    $( "#msg_button_sendIn" ).button().click(function( event ) { msgSendRespIn() });		

    $( "#msg_button_cancelNew" ).button().click(function( event ) { clearNewMsg() });	
    $( "#msg_button_sendNew" ).button().click(function( event )   { msgSendNew() });	    
}); 

function msgLoadTable(){
	var scroll_table=($("#vtab").height()-150)+"px";
	var pTable = $('#msgTableIn').dataTable({ 
		"sScrollY": scroll_table,
	    "bDestroy": true,
	    "bLengthChange": false,
	    "bPaginate": true,
	    "bFilter": true,
	    "bSort": true,
	    "bJQueryUI": true,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,
	    "bSortClasses": false,    
	    "sAjaxSource": "index.php?m=rMensajes&c=getMessagesIn",
	      "aoColumns": [
	        { "mData": " ", sDefaultContent: "" },
	        { "mData": "UNIT", sDefaultContent: "" },
	        { "mData": "TIEMPO", sDefaultContent: "" },
	      ] ,        
	    "oLanguage": {
	        "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
	        "sEmptyTable": "No hay registros.",
	        "sInfoEmpty" : "No hay registros.",
	        "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
	        "sLoadingRecords": "Leyendo información",
	        "sProcessing": "Procesando",
	        "sSearch": "Buscar:",
	        "sZeroRecords": "No hay registros",
	    },
		"aoColumnDefs": [
			{"aTargets": [0],
			  "sWidth": "5%",
			  "bSortable": false,        
			  "mRender": function (data, type, full) {
			  	var status =  (full.STATUS==1) ? "Mail_open.png": "Mail.png";
			    
				return  '<div>'+
	                    '<img id="imgIn'+full.ID+'" class="width:24;height23;" src="/public/images/icons/'+status+'"/>'+
	                    '</div>';
			}}
		],
		"fnDrawCallback": function(){
		      $('table#msgTableIn td').bind('mouseenter', function () { $(this).parent().children().each(function(){$(this).addClass('datatablerowhighlight');}); });
		      $('table#msgTableIn td').bind('mouseleave', function () { $(this).parent().children().each(function(){$(this).removeClass('datatablerowhighlight');}); });
				$('#msgTableIn  td').live('click',function(){
					var aPos = pTable.fnGetPosition(this);
					var aData = pTable.fnGetData(aPos[0]);
					msgReadMarkIn(aData.ID,aData);
				});		      
		}
	});
}

function msgReadMarkIn(id,data){
	clearmsgReadIn();
	$("#imgIn"+id).attr("src", "/public/images/icons/Mail_open.png");
	$("#recMsgInRead").removeClass("invisible").addClass("visible");
	$("#mTittleUnit").html(data.UNIT);
	$("#mTimeUnit").html(data.TIEMPO);
	$("#msgDataRead").html(data.MESSAGE);	
	var stringData = data.ID+"|"+data.ID_UNIT+"|"+data.UNIT+"|"+data.MESSAGE;
	$("#idMsgIn").val(stringData);	
}

function clearmsgReadIn(){
	$("#recMsgInRead").removeClass("visible").addClass("invisible");
	$("#mTittleUnit").html("");
	$("#mTimeUnit").html("");
	$("#msgDataRead").html("");
	$("#idMsgIn").val(0);
	clearRespMsg();
}

function clearRespMsg(){
	$("#recMsgInResp").removeClass("visible").addClass("invisible");	
	$("#recMsgDesc").removeClass("visible").addClass("invisible");
	$("#cboMsgs").removeClass("visible").addClass("invisible");
	$("#respMsgText").val("");	
	$(".chzn-select").val('').trigger("liszt:updated");
}

function msgRespdIn(type){ /* 0-> Responder, 1->Reenviar */
	$("#recMsgInResp").removeClass("invisible").addClass("visible");
	$("#recMsgDesc").removeClass("visible").addClass("invisible");
	$("#cboMsgs").removeClass("visible").addClass("invisible");

	var stringData = $("#idMsgIn").val();
	$("#idMsgIn").val(stringData+"|"+type);

	var sData = new Array();
	sData     = stringData.split('|');

	if(type==0){
		$("#recMsgTittle").html("Responder");
		$("#recMsgDesc").html(sData[2]).removeClass("invisible").addClass("visible");
		$("#respMsgText").val("");
	}else{
		$("#recMsgTittle").html("Re Enviar");		
		$("#cboMsgs").removeClass("invisible").addClass("visible");
		$("#respMsgText").val("RE : "+sData[3]);
	}
}
  
function msgSendRespIn(){ /* 0-> Responder, 1->Reenviar */
	var stringData = $("#idMsgIn").val();

	var sData = new Array();
	    sData = stringData.split('|');

	var stype  =  sData[4];
	var idUnit =  sData[1];
	var meesage = $("#respMsgText").val();
	var unitsDestiny = "";

	if(sData[4]==0){
		unitsDestiny = idUnit;
	}else{		
		var units  = $(".chzn-select").val();		
		if(units==null){
			$('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de seleccionar un destinatario.</p>');
			$("#dialog_msg" ).dialog('open'); 
			return false;
		}
		unitsDestiny = units;
	}

	if(meesage.length==0 && meesage==""){
        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de ingresar el mensaje a enviar.</p>');
        $("#dialog_msg" ).dialog('open');
        return false; 		
	}

	var response = stype+"|"+unitsDestiny+"|"+meesage;

	sendRequestResp(response);
}

function sendRequestResp(dataResp){
	var sendData = new Array();
	    sendData = dataResp.split('|');	

	var stype  =  sendData[0];
	var unitsD =  sendData[1];
	var meesage = sendData[2];

	$.ajax({
	  url: "index.php?m=rMensajes&c=mResponseIn",
	  type: "GET",
	  dataType : 'json',
	  data: { 
	  	typemsg : stype,
	    destiny : unitsD,
	    message : meesage 

	  },
	  success: function(data) {
	    var result = data.result; 

	    if(result=='no-data' || result=='problem'){
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
	        $("#dialog_msg" ).dialog('open');             
	    }else if(result=='ok'){ 
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
	        $("#dialog_msg" ).dialog('open');
	        clearmsgReadIn();
	        msgLoadTable();
	    }else if(result=='no-perm'){ 
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
	        $("#dialog_msg").dialog('open');
	    }
	  }
	}); 	
}

function msgLoadTableOut(){
	var scroll_table=($("#vtab").height()-150)+"px";
	var pTable = $('#msgTableOut').dataTable({ 
		"sScrollY": scroll_table,
	    "bDestroy": true,
	    "bLengthChange": false,
	    "bPaginate": true,
	    "bFilter": true,
	    "bSort": true,
	    "bJQueryUI": true,
	    "iDisplayLength": 10,
	    "bAutoWidth": false,
	    "bSortClasses": false,    
	    "sAjaxSource": "index.php?m=rMensajes&c=getMessagesOut",
	      "aoColumns": [
	        { "mData": " ", sDefaultContent: "" },
	        { "mData": "UNIT", sDefaultContent: "" },
	        { "mData": "TIEMPO", sDefaultContent: "" },
	      ] ,        
	    "oLanguage": {
	        "sInfo": "Mostrando _TOTAL_ registros (_START_ a _END_)",
	        "sEmptyTable": "No hay registros.",
	        "sInfoEmpty" : "No hay registros.",
	        "sInfoFiltered": " - Filtrado de un total de  _MAX_ registros",
	        "sLoadingRecords": "Leyendo información",
	        "sProcessing": "Procesando",
	        "sSearch": "Buscar:",
	        "sZeroRecords": "No hay registros",
	    },
		"aoColumnDefs": [
			{"aTargets": [0],
			  "sWidth": "5%",
			  "bSortable": false,        
			  "mRender": function (data, type, full) {
			  	var status =  (full.STATUS==1) ? "Mail_send.png": "Mail_no_send.png";
			    
				return  '<div>'+
	                    '<img id="imgOut'+full.ID+'" class="width:24;height23;" src="/public/images/icons/'+status+'"/>'+
	                    '</div>';
			}}
		],
		"fnDrawCallback": function(){
				$('table#msgTableOut td').bind('mouseenter', function () { $(this).parent().children().each(function(){$(this).addClass('datatablerowhighlight');}); });
				$('table#msgTableOut td').bind('mouseleave', function () { $(this).parent().children().each(function(){$(this).removeClass('datatablerowhighlight');}); });
				$('#msgTableOut  td').live('click',function(){
					var aPos = pTable.fnGetPosition(this);
					var aData = pTable.fnGetData(aPos[0]);
					msgReadMarkOut(aData.ID,aData);
				});		      
		}
	});
}

function msgReadMarkOut(id,data){
	$("#recMsgOutRead").removeClass("invisible").addClass("visible");
	$("#mTittleUnitOut").html(data.UNIT);
	$("#mTimeUnitOut").html(data.TIEMPO);
	$("#msgDataReadOut").html(data.MESSAGE);	
	var stringData = data.ID+"|"+data.ID_UNIT+"|"+data.UNIT+"|"+data.MESSAGE;
	$("#idMsgOut").val(stringData);	
}

function clearmsgReadOut(){
	$("#recMsgOutRead").removeClass("visible").addClass("invisible");
	$("#mTittleUnitOut").html("");
	$("#mTimeUnitOut").html("");
	$("#msgDataReadOut").html("");
	$("#idMsgOut").val(0);
}

function sendRequestResp(){
	var stringData = $("#idMsgOut").val();

	var sData = new Array();
	    sData = stringData.split('|');

	var idUnit =  sData[1];
	var meesage = sData[3];

	$.ajax({
	  url: "index.php?m=rMensajes&c=mResponseOut",
	  type: "GET",
	  dataType : 'json',
	  data: { 
	    destiny : idUnit,
	    message : meesage
	  },
	  success: function(data) {
	    var result = data.result; 

	    if(result=='no-data' || result=='problem'){
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
	        $("#dialog_msg" ).dialog('open');             
	    }else if(result=='ok'){ 
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
	        $("#dialog_msg" ).dialog('open');
	        clearmsgReadOut();
	        msgLoadTableOut();
	    }else if(result=='no-perm'){ 
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
	        $("#dialog_msg").dialog('open');
	    }
	  }
	}); 	
}

function clearNewMsg(){
	$(".chzn-select-new").val('').trigger("liszt:updated");
	$("#respMsgTextNew").val("");	
}

function msgSendNew(){
	var units  = $(".chzn-select-new").val();		
	var message = $("#respMsgTextNew").val();

	if(units==null){
		$('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de seleccionar un destinatario.</p>');
		$("#dialog_msg" ).dialog('open'); 
		return false;
	}

	if(message.length==0 && message==""){
        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Debe de seleccionar el mensaje a enviar.</p>');
        $("#dialog_msg" ).dialog('open');
        return false; 		
	}	

	$.ajax({
	  url: "index.php?m=rMensajes&c=mSendNew",
	  type: "GET",
	  dataType : 'json',
	  data: { 
	    destiny : units,
	    message : message
	  },
	  success: function(data) {
	    var result = data.result; 

	    if(result=='no-data' || result=='problem'){
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
	        $("#dialog_msg" ).dialog('open');             
	    }else if(result=='ok'){ 
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
	        $("#dialog_msg" ).dialog('open');
	        clearNewMsg();	        
	        $('#vtab>div').hide().eq(1).show().mouseover();
	        msgLoadTableOut();
	    }else if(result=='no-perm'){ 
	        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
	        $("#dialog_msg").dialog('open');
	    }
	  }
	}); 	
}