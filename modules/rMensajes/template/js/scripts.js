$(document).ready(function(){
	var $items = $('#vtab>ul>li');
	$items.mouseover(function() {
	    $items.removeClass('selected');
	    $(this).addClass('selected');
	}).eq(0).mouseover();


	$items.click(function() {
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
		}
	});

	$('#msgTableIn  td').live('click',function(){
		var aPos = pTable.fnGetPosition(this);
		var aData = pTable.fnGetData(aPos[0]);
		msgReadMarkIn(aData.ID,aData);
	});
}

function msgReadMarkIn(id,data){
	$("#imgIn"+id).attr("src", "/public/images/icons/Mail_open.png");
	$("#recMsgInRead").removeClass("invisible").addClass("visible");
	$("#mTittleUnit").html(data.UNIT);
	$("#mTimeUnit").html(data.TIEMPO);
	$("#msgDataRead").html(data.MESSAGE);
	$("#idMsgIn").val(id);
}

function clearmsgReadIn(){
	$("#recMsgInRead").removeClass("visible").addClass("invisible");
	$("#mTittleUnit").html("");
	$("#mTimeUnit").html("");
	$("#msgDataRead").html("");
	$("#idMsgIn").val(0);	
}

function msgReSend(){
	var id_Msg = $("#idMsgIn").val();
	if(id_Msg>0){
		$.ajax({
		  url: "index.php?m=rMensajes&c=mReSend",
		  type: "GET",
		  dataType : 'json',
		  data: { 
		    msg_id:  $("#idMsgIn").val()
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
	}else{
        $('#dialog_msg').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Favor de seleccionar un mensaje.</p>');
        $("#dialog_msg").dialog('open');
	}
}