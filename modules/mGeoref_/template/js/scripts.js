var oTable;
var geos_map=null;         
var drawingManager=null;
var geos_polygon = null;
var marker=null;
var geocoder;
var geos_lat,geos_lon;
var geos_points = [];
var geos_poins_polygon  = [];
var geos_options =  "";

$(document).ready(function (){
  geos_load_datatable();
  $( "#geos_add" ).button({
      icons: {
        primary: "ui-icon-plus"
      },
      text: "Nuevo"
    });
  //Dialog generico   
  $( "#geos_dialog_nvo" ).dialog({
    autoOpen:false,
    title:"Nuevo",
    modal: true,
    position: { my: "center", at: "top",within : window},
    width:720,
    buttons: {
    Cancelar: function() {
      $("#geos_dialog_nvo" ).dialog( "close" );
      },
    Guardar: function() {
      geos_validar_nvo();
      }     
    }
  });
    $( "#geos_dialog_message" ).dialog({
      autoOpen:false,
      modal: false,
      position: 'center',
      buttons: {
        Aceptar: function() {
          $("#geos_dialog_message" ).dialog( "close" );
        }
      }
    }); 
});  

function geos_load_datatable(){
    oTable = $('#geos_table').dataTable({
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
      "sAjaxSource": "index.php?m=mGeoref&c=mGetTable",
      "aoColumns": [
        { "mData": " ", sDefaultContent: "" },
        { "mData": "TIPO", sDefaultContent: "" },
        { "mData": "NOMBRE", sDefaultContent: "" },
        { "mData": "PRIVACIDAD", sDefaultContent: "" },
        { "mData": "FECHA", spanDefaultContent: "" },
      ] , 
      "aoColumnDefs": [
        {"aTargets": [0],
          "sWidth": "10%",
          "bSortable": false,        
          "mRender": function (data, type, full) {
            var edit  = '';
            var del   = '';

            if($("#geos_update").val()==1){
               // edit = '<td><span class="ui-icon ui-icon-pencil" onclick="geos_edit_function('+full.ID+',\''+full.TIPO2+'\');"></span></td>';
			   edit = "<td><div onclick='geos_edit_function("+full.ID+",\""+full.TIPO2+"\");' class='custom-icon-edit-custom'>"+
                        "<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
                        "</div></td>";
            }
            
            if($("#geos_delete").val()==1){
                //del = '<td><span class="ui-icon ui-icon-trash" onclick="geos_delete_function('+full.ID+',\''+full.TIPO2+'\');"></span></td>';
				del = "<td><div onclick='geos_delete_function("+full.ID+",\""+full.TIPO2+"\");' class='custom-icon-delete-custom'>"+
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

  function geos_edit_function(value,type){
    if(value==0){
      $( "#geos_dialog_confirm" ).dialog({
        autoOpen:false,   
        resizable: false, 
        height:140,
        modal: true,
        buttons: {
          "Geo Punto": function() {         
            geos_set_function(value,'G');
          },
          "Geo Cerca": function() {
            geos_set_function(value,'C');
          }
        }
      });

      $('#geos_dialog_confirm').html('<p>¿Que Georeferencia desea crear?</p>');
      $("#geos_dialog_confirm").dialog("open");      
    }else{
      geos_set_function(value,type);
    }
  }

  function geos_set_function(value,type){
    $("#geos_dialog_confirm").dialog("close");
    $.ajax({
        url: "index.php?m=mGeoref&c=mGetRow",
        type: "GET",
        data: { data: value,
                type: type.toLowerCase()  },
        success: function(data){
          var result = data;             
          $('#geos_dialog_nvo').html('');
          $('#geos_dialog_nvo').dialog('open');
          $('#geos_dialog_nvo').html(result); 
          geos_load_map();
        }
    });
  }

  function geos_load_map(){
    geos_lon = ($("#geos_txt_lon").val()!=0) ? $("#geos_txt_lon").val() : -104.41406;
    geos_lat = ($("#geos_txt_lat").val()!=0) ? $("#geos_txt_lat").val() : 24.52713; 

    var  geo_zoom = ($("#geos_txt_id").val()>0) ? 20 : 5; 
    geos_map = geo_zoom;
    geocoder = new google.maps.Geocoder();
    var mapOptions = {
      zoom: geo_zoom,
      center: new google.maps.LatLng(geos_lat,geos_lon),
      mapTypeId: google.maps.MapTypeId.ROADMAP
    };          

    geos_map = new google.maps.Map(document.getElementById('geos_map'),mapOptions); 

    if($("#geos_txt_tipo").val()=='p'){
      geos_function_geop();
    }else{
        $("#geos_start")
          .button()
          .click(function( event ) {
            $(this).prop('disabled', true).addClass("ui-state-active");            
            geos_start_draw();
          });
        $("#geos_drop")
          .button()
          .click(function( event ) {
            $(this).prop('disabled', true);
            $("#geos_start").prop('disabled', false).removeClass("ui-state-active");
            geos_clear_geoc();
          });        
        $("#geos_search")
          .button()
          .click(function( event ) {
            geos_find(3);
          });                    
      geos_function_geoc();
    } 
  }

  function geos_function_geoc(){ 
    if($("#geos_txt_id").val()>0){
      var latlngbounds = new google.maps.LatLngBounds( );

      $("#geos_start").prop('disabled', true).addClass("ui-state-active");
      $("#geos_drop").prop('disabled', false);    

      geos_polygon = new google.maps.Polygon(geos_options);
      geos_polygon.setMap(geos_map); 

      for (i = 0; i < geos_poins_polygon.length; i++) {
        latlngbounds.extend( geos_poins_polygon[i] );
      }
      geos_map.fitBounds( latlngbounds );
    }

    drawingManager = new google.maps.drawing.DrawingManager({
      drawingMode : null,
      drawingControl : false,
      drawingControlOptions : {
        position : null,
        drawingModes : [google.maps.drawing.OverlayType.POLYGON]
      },
          polylineOptions: {
            editable: true
          },
      polygonOptions : {
        strokeColor : "#FF0000",
        strokeOpacity : 0.8,
        strokeWeight : 2,
        fillColor : "#FF0000",
        fillOpacity : 0.35
      }
    });

    drawingManager.setMap(geos_map);

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
      drawingManager.setDrawingMode(null);
      polygon.setEditable(true);
      geos_polygon = polygon;
      $("#geos_start").prop('disabled', false).removeClass("ui-state-active");
      $("#geos_drop").prop('disabled', false);
    }); 
  }


  function geos_start_draw(){    
    geos_clear_geoc();
    drawingManager.setDrawingMode(google.maps.drawing.OverlayType.POLYGON);

    google.maps.event.addListener(drawingManager, 'polygoncomplete', function(polygon) {
      drawingManager.setDrawingMode(null);
      polygon.setEditable(true);
      geos_polygon = polygon;
      $("#geos_start").prop('disabled', false).removeClass("ui-state-active");
      $("#geos_drop").prop('disabled', false);      
    });    
  }

  function geos_clear_geoc() {
    if (geos_polygon) {
      geos_polygon.setMap(null);
      geos_polygon.setEditable(false);
      geos_polygon = null;
    }
  }

  function geos_delete_function(value){
    $( "#geos_dialog_confirm" ).dialog({
      autoOpen:false,   
      resizable: false, 
      height:140,
      modal: true,
      buttons: {
        "Aceptar": function() {         
          geos_send_delete(value);
          $( this ).dialog( "close" );
        },
        Cancel: function() {
          $( this ).dialog( "close" );
        }
      }
    });

    $('#geos_dialog_confirm').html('<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>&iquest;Usted esta seguro de borrar el siguiente registro con el ID: '+value+'?</p>');
    $("#geos_dialog_confirm").dialog("open");
  }

  function geos_send_delete(value){
    $.ajax({
        url: "index.php?m=mGeoref&c=mDelRow",
        type: "GET",
        dataType : 'json',
        data: { data: value },
        success: function(data) {
          var result = data.result; 

          if(result=='no-data' || result=='problem'){
              $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser eliminados</p>');
              $("#geos_dialog_message" ).dialog('open');             
          }else if(result=='use'){ 
              $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Perfil asociado a un usuario. \u00a1 Imposible borrar por el momento!</p>');
              $("#geos_dialog_message" ).dialog('open');       
          }else if(result=='delete'){ 
              $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) eliminado(s) correctamente</p>');
              $("#geos_dialog_message" ).dialog('open');
              geos_load_datatable();
          }else if(result=='no-perm'){ 
              $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
              $("#geos_dialog_message" ).dialog('open');       
          }
        }
    });
  }

  function geos_validar_nvo(){
    if($("#geos_txt_tipo").val()=='p'){
      validate_geop();
    }else{
      validate_geoc();
    }
  }

  function geos_function_geop(){
      $("#geos_search")
          .button()
          .click(function( event ) {
            geos_find(2);
      }); 

        geos_lon = ($("#geos_txt_lon").val()!=0) ? $("#geos_txt_lon").val() : -104.41406;
        geos_lat = ($("#geos_txt_lat").val()!=0) ? $("#geos_txt_lat").val() : 24.52713; 
        marker = new google.maps.Marker({
          map:geos_map,
          draggable:true,
          animation: google.maps.Animation.DROP,
          position: new google.maps.LatLng(geos_lat,geos_lon)
        });
        geos_map.setCenter(new google.maps.LatLng(geos_lat,geos_lon));
       
        var  geo_zoom = ($("#geos_txt_id").val()>0) ? 20 : 5; 
        geos_map.setZoom(geo_zoom);
        google.maps.event.addListener(marker, 'click', toggleBounce);


        $("#geos_cbo_edo").change(function(){
            $.ajax({
              url: "index.php?m=mGeoref&c=mGetMunicipios",
              type: "GET",
              dataType : 'json',
              data: { data: $(this).val() },
              success: function(data) {
                result =  data.items;
                $("#geos_cbo_mun").prop('disabled', false);
                $("#geos_cbo_col").prop('disabled', true);
                $("#geos_cbo_col").find('option').remove().end();
                $("#geos_cbo_mun").find('option').remove().end();
                for (var i=0; i<result.length; i++) {
                  $("#geos_cbo_mun").append('<option value="' + result[i].id + '">' + result[i].name + '</option>');
                } 
              }
          });
        });

        $("#geos_cbo_mun").change(function(){
            $.ajax({
              url: "index.php?m=mGeoref&c=mGetColonias",
              type: "GET",
              dataType : 'json',
              data: { data:$("#geos_cbo_edo").val() , idmun: $(this).val()},
              success: function(data) {
                result =  data.items;
                $("#geos_cbo_col").prop('disabled', false);
                $("#geos_cbo_col").find('option').remove().end();
                for (var i=0; i<result.length; i++) {
                  $("#geos_cbo_col").append('<option value="' + result[i].id + '|'+ result[i].cp + '">' + result[i].name + '</option>');
                } 
              }
          });
        });

        $("#geos_cbo_col").change(function(){
            var elemento = $(this).val();
            valores      = elemento.split('|');
            $("#geos_txt_cp").val(valores[1]);  
        });    
  }

  function toggleBounce() {
    if (marker.getAnimation() != null) {
      marker.setAnimation(null);
    } else {
      marker.setAnimation(google.maps.Animation.BOUNCE);
    }
  }  

  function geos_find(tipo) {
  var address    = '';
    if(tipo==1){
      var calle     = $("#geos_txt_calle").val();
      var colonia   = $("#geos_cbo_edo  :selected").text();
      var municipio = $("#geos_cbo_mun  :selected").text();
      var estado    = $("#geos_cbo_col  :selected").text();
      var cp        = $("#geos_txt_cp").val();

      if(calle!="" && colonia!="" && municipio!="" && estado !=""){
          address = calle+" "+colonia+" "+municipio+" "+estado;
      }else{
          $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se ha encontrado la ubicación.</p>');
          $("#geos_dialog_message" ).dialog('open');
         return false;
      }  
    }else{
       address = document.getElementById('geos_txt_find').value;      
    }
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        geos_map.setCenter(results[0].geometry.location);
        geos_map.setZoom(14);

        if(tipo!=3){
          if(marker){marker.setMap(null);}
          marker = new google.maps.Marker({
              map: geos_map,
              draggable:true,
              animation: google.maps.Animation.DROP,            
              position: results[0].geometry.location
          });
          google.maps.event.addListener(marker, 'click', toggleBounce);
        }  
      }else {
          $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No se ha encontrado la ubicación.</p>');
          $("#geos_dialog_message" ).dialog('open');
      }
    });  
  }

  function validate_geop(){
    var error=0;  

    if($("#geos_search_name").val()=="NULL" || $("#geos_search_name").val()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una descripción.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;
    }   

    if($("#geos_select_tipo").val()<0){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar un tipo de geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;        
    }

    if($("#geos_txt_priv").val()<0){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar la privacidad del geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;        
    }

     if($("#geos_txt_calle").val()=="NULL" || $("#geos_txt_calle").val()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir la calle donde se encuentra el geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;
    }     
    
    if($("#geos_cbo_edo").val()<0 && $("#geos_cbo_edo  :selected").text()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar el estadosdfsd donde se encuentra el geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;        
    }

    if($("#geos_cbo_mun").val()<0 && $("#geos_cbo_mun  :selected").text()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar el municipio donde se encuentra el geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;        
    }    

    if($("#geos_cbo_col").val()<0 && $("#geos_cbo_col  :selected").text()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar la colonia donde se encuentra el geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;        
    }     

    if($("#geos_txt_cp").val()=="NULL" || $("#geos_txt_cp").val()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir  el codigo postal donde se encuentra el geopunto.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;
    }  
	//alert(error)
    if(error==0){ geos_send_edit_geop(); }
  }

  function geos_send_edit_geop(){
	  
      $.ajax({
          url: "index.php?m=mGeoref&c=mSetRowp",
          type: "GET",
          dataType : 'json',
          data: { 
            geos_id   : $("#geos_txt_id").val(),
            name      : $("#geos_search_name").val(),
            calle     : $("#geos_txt_calle").val(),
            noint     : $("#geos_txt_noint").val(),
            noext     : $("#geos_txt_noext").val(),
            colonia   : $("#geos_cbo_edo  :selected").text(),
            municipio : $("#geos_cbo_mun  :selected").text(),
            estado    : $("#geos_cbo_col  :selected").text(),
            cp        : $("#geos_txt_cp").val(),
            tipo    : $("#geos_select_tipo").val(),
            radio   : $("#geos_txt_ra").val(),  
            privacidad: $("#geos_txt_priv").val(),
            lat   : marker.getPosition().lat().toFixed(6),
            lon   : marker.getPosition().lng().toFixed(6)
          },
          success: function(data) {            
            var result = data.result; 
			
            if(result=='no-data' || result=='problem'){
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#geos_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#geos_dialog_nvo').dialog('close');
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#geos_dialog_message" ).dialog('open');
                geos_load_datatable();
            }else if(result=='no-perm'){ 
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#geos_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#geos_dialog_message").dialog('open');       
            }
          }
        }); 
  }

  function validate_geoc(){
    geos_points = [];
    var error=0;  

    if($("#geos_search_name").val()=="NULL" || $("#geos_search_name").val()==""){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe escribir una descripción.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;
    }   

    if($("#geos_txt_color").val()<0){
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>Debe seleccionar un color.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;        
    }

    if (geos_polygon!=null) {

      var contentString='';
      var polygonBounds = geos_polygon.getPath();
      var xy;
        for (var i = 0; i < polygonBounds.length; i++) {
            xy = polygonBounds.getAt(i);
            geos_points.push(xy.lat().toFixed(6)+" "+xy.lng().toFixed(6));
        }
    }else{
      $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;">'+
                                      '</span>No se ha dibujado la geocerca.</p>');
      $("#geos_dialog_message" ).dialog('open');  
      error++;    
    }

    if(error==0){ geos_send_edit_geoc(); }
  }

  function geos_send_edit_geoc(){
      $.ajax({
          url: "index.php?m=mGeoref&c=mSetRow",
          type: "GET",
          dataType : 'json',
          data: { 
            geos_id   : $("#geos_txt_id").val(),
            name      : $("#geos_search_name").val(),
            privacidad: $("#geos_txt_priv").val(),
            color     : $("#geos_txt_color").val(),
            points    : geos_points
          },
          success: function(data) {            
            var result = data.result; 

            if(result=='no-data' || result=='problem'){
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Los datos no pudieron ser guardados,</p>');
                $("#geos_dialog_message" ).dialog('open');             
            }else if(result=='edit'){ 
                $('#geos_dialog_nvo').dialog('close');
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Dato(s) guardado(s) correctamente</p>');
                $("#geos_dialog_message" ).dialog('open');
                geos_load_datatable();
            }else if(result=='no-perm'){ 
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>No tiene permiso para realizar esta acción. <br> Consulte a su administrador.</p>');
                $("#geos_dialog_message").dialog('open');       
            }else if(result=='on-use'){ 
                $('#geos_dialog_message').html('<p align="center"><span class="ui-icon ui-icon-alert" style="float:left; margin:0 1px 25px 0;"></span>Seleccione otro nombre de usuario, el que ingreso ya se encuentra ocupado.</p>');
                $("#geos_dialog_message").dialog('open');       
            }
          }
        }); 
  }  