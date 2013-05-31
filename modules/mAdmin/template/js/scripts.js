$(document).ready(function (){
	$("#gral_button_close").click(function() {
		location.href='index.php?m=login&c=login&md=lo';
	});
});  

function go_empresas(){
	if($("#global_id_all").val() == 1){
		$(location).attr('href','index.php?m=mAdmin&c=mEmpresas');
	}
}

function go_clientes(id_empresa){
	$('<form action="index.php?m=mAdmin&c=mClientes" method="POST">').
			     append('<input type="hidden" id="id_company" value="'+id_empresa+'" name="id_company" />')
			     .appendTo('body').submit();
}

function go_options(id_row){
	var company = $("#global_id_company").val();
	$('<form action="index.php?m=mAdmin&c=mOptions" method="POST">').
			     append('<input type="hidden" id="id_company" value="'+company+'" name="id_company" />'+
			     		'<input type="hidden" id="id_client"  value="'+id_row+'" name="id_client" />')
			     .appendTo('body').submit();
}

function adm_abrir_modulo(m){
	$("#accordion_container").html("");
	$.ajax({
		type: "POST",
        url: "index.php?m="+m+"&c=admindefault",
        data: "",
        success: function(datos){
			if(datos!=0){
				$("#adm_content").html(datos);
			}else{
				$("#adm_content").html("No se han Creado un menú");
			}
			
        }
	});
	}