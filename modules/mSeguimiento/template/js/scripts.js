var segTable;
var seg_map;
var ide = -1;
var grados = 0;
//Data velocimetro
    var speedColor = '#474337';
    var rpmColor = '#BBB59C';
    //var kmhArr = [0, 20, 40, 60, 90, 120, 150, 180, 210];
	var kmhArr = [];
    var hiRef = '#A41E09';
    var dialColor = '#FA3421';
    var currentRpm = 0;
    var rpmAccel = [];
    var speedAccel = [];
	
	var temp = [];
    var tCounter = 0,
        tvalCounter = 0;
	
    var spCounter = 0,
        valCounter = 0;
	var seg_kmr = [];
	var seg_kml = [];	
	var seg_tf = [];
	var seg_ifu = [];
	var seg_oil_pre = [];
	var seg_t_cru = [];
	var seg_e_idle = [];
	var seg_e_load = [];
	var seg_e_time = [];



$(document).ready(function () {
	//Declarar tabs
	 $( "#seg_tabs" ).tabs({
      beforeLoad: function( event, ui ) {
        ui.jqXHR.error(function() {
          ui.panel.html(
            "Couldn't load this tab. We'll try to fix this as soon as possible. " +
            "If this wouldn't be a demo." );
        });
      }
    });
	
	//Ejecutar Velocimetro
	seg_velocimetro();
	//Ejecutar temperatura
	seg_temperatura();
	//----------------	
	//height divs
	$("#dseg_tbl").height($("#seg_main").height()-40);
	
	
	
	
	//Definir datepicker
	$(".caja_date").datepicker({
			showOn: "button",
			buttonImage: "public/images/cal.gif",
			buttonImageOnly: true,
			maxDate: '0',
			dateFormat: "yy-mm-dd"
		});
	//Definir botnes buscar
	$( ".search" ).button({
      icons: {
        primary: "ui-icon-search"
      },
      text: false
    })	
	//Definir botnes exportar
	$( ".export" ).button({
      icons: {
        primary: "ui-icon-circle-arrow-s"
      },
      text: false
    })	
	
	
	
	//DECLARAR DIALOG NUEVO/EDICION
	$("#seg_dialog" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		width:  800,
		height: 600,
		buttons: {
			"Guardar": function(){
				seg_validar_datos();
				},
			"Cancelar": function(){
				if($("#seg_dialog" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#seg_dialog" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		});	
	
	//DECLARAR DIALOG IMAGEN
	$("#seg_dialog_img" ).dialog({
		modal: true,
		autoOpen:false,
		overlay: { opacity: 0.2, background: "cyan" },
		resizable: true,
		width:  800,
		height: 600,
		buttons: {
			"Guardar": function(){
				seg_save_img();
				},
			"Cancelar": function(){
				if($("#seg_dialog_img" ).dialog('isOpen')){
					$("#dialog_message").dialog('close');
					}
					$("#seg_dialog_img" ).dialog('close');
				}
				},
		show: "blind",
		hide: "blind"
		})
	//Pintar mapa
	//pseg_mapa();
	//seg_mapa();
	//seg_drw_widgets();
	//seg_get_widgets();	
	//seg_get_data();
	
	
	});
	
//-----------------------------------------------------------------------
function pseg_mapa(){
	//alert("pseg_map")
//$("#dseg_map").height($("#seg_main").height()-40);
	$("#dseg_map").html("Cargando...");
	//setTimeout(seg_mapa(), 8000);
	/*setTimeout(function(){*/
		//alert("seg_mapa")
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 3,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     seg_map = new google.maps.Map(document.getElementById("dseg_map"),mapOptions);
	 /*},5000);*/
}
//-----------------------------------------------------------------------
function seg_mapa(){
	setTimeout(function(){
		//alert($("#dseg_map").height()+"/"+$("#dseg_map").width())
		$("#dseg_map").height($("#seg_main").height()-40);
		$("#dseg_map").html("Cargando...");
	var mapOptions = {
          center: new google.maps.LatLng(19.435113686545755,-99.13316173010253),
          zoom: 3,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        };
     seg_map = new google.maps.Map(document.getElementById("dseg_map"),mapOptions);},1500);
	
	
	
	
	}
//---------------------------------------------------------------------
function seg_getvalues(){
	u = $("#seg_und").val();
	i = $("#seg_dti").val()+" "+$("#seg_hri").val()+":"+$("#seg_mni").val()+":00";
	f = $("#seg_dtf").val()+" "+$("#seg_hrf").val()+":"+$("#seg_mnf").val()+":59";
	
	$.ajax({
		url: "index.php?m=mSeguimiento&c=mGetValues",
		type: "GET",
		data: {
			und : u,
			dti : i,
			dtf : f
			},
		success: function(data) {
			var result = data;
			//alert(result) 
			if(result!=0){
				$('#seg_values').html(result); 
				}
			}
		});		
	
	}	
//----------------------------------------------------------------------
function seg_get_data(){

		u = $("#seg_und").val();
		i = $("#seg_dti").val()+" "+$("#seg_hri").val()+":"+$("#seg_mni").val()+":00";
		f = $("#seg_dtf").val()+" "+$("#seg_hrf").val()+":"+$("#seg_mnf").val()+":00";
		$(document.body).css('cursor','wait');	
		//alert(u+"/"+i+"/"+f)
		//scroll_table=($("#revidencia").height()-172)+"px";
		segTable = $('#tseg_data').dataTable({
		  //"sScrollY": scroll_table,
		  "bDestroy": true,
		  "bLengthChange": true,
		  "bPaginate": false,
		  "bFilter": true,
		  "bSort": true,
		  "bJQueryUI": true,
		  "iDisplayLength": 20,      
		  "bProcessing": true,
		  "bAutoWidth": true,
		  "bSortClasses": false,
		  "sAjaxSource": "index.php?m=mSeguimiento&c=mGetData&und="+u+"&dti="+i+"&dtf="+f,
		  "aoColumns": [
			{ "mData": " ", sDefaultContent: "" },
			
			{ "mData": "GPS_DATETIME", sDefaultContent: "" },
			{ "mData": "TOD", sDefaultContent: "" },
			{ "mData": "VS", sDefaultContent: ""},
			{ "mData": "E_RPM", sDefaultContent: "" },
			{ "mData": "F_ECO", sDefaultContent: "" },
			{ "mData": "E_TEMP", sDefaultContent: ""}			
		  ] , 
		  "aoColumnDefs": [
			{"aTargets": [0],
			  "sWidth": "65px",
			  "bSortable": false,        
			  "mRender": function (data, type, full) {
				//var edit  = '';
				//var del   = '';
				var gra   = '';
				
				var imp = '';
	
				/*edit = "<td><div onclick='geo_nuevo(2,"+full.ID_OBJECT_MAP+");' class='custom-icon-edit-custom'>"+
						"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
						"</div></td>";
	
				del = "<td><div onclick='geo_delete_function("+full.ID_OBJECT_MAP+");' class='custom-icon-delete-custom'>"+
						"<img class='total_width total_height' src='data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=='/>"+
						"</div></td>";*/
						date = "\'"+full.GPS_DATETIME+"\'"
				gra = '<td><div onclick="seg_get_position('+full.LATITUDE+','+full.LONGITUDE+','+date+','+full.TOD+','+full.VS+','+full.E_RPM+','+full.F_ECO+','+full.E_TEMP+')" class="custom-icon-copy">'+
						'<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
						'</div></td>';
						
				/*imp = '<td><div onclick="rev_reporte_pdf('+full.ID_RES_CUESTIONARIO+','+date+','+eqst+','+user+')" >'+
						'<span class="ui-icon ui-icon-document" style="cursor:pointer;"></span>'+
						'</div></td>';		*/
						
				
	
				return '<table><tr>'+gra+'</tr></table>';
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
		
			

	
	

		$(document.body).css('cursor','default');	
		//}
 
	}	
//----------------------------
	
//----------------------------
function seg_get_widgets(){
	//alert("widgets");

	$("#rhi_table tbody tr").each(function(index, element) {
	    $(this).remove();
	});

	u = $("#seg_und").val();
	i = $("#seg_dti").val()+" "+$("#seg_hri").val()+":"+$("#seg_mni").val()+":00";
	f = $("#seg_dtf").val()+" "+$("#seg_hrf").val()+":"+$("#seg_mnf").val()+":00";



	$.ajax({
		url : "index.php?m=mSeguimiento&c=mWidgets",
		type: 'GET',
		data: {
			  und : u,
			  dti : i,
			  dtf : f
			  },
		dataType : 'json',
		success:function(data){
			//$('#rhi_dialog_nvo').dialog('close');				
				$.each(data,function(index,record){
					var row = $('<tr />');
					//fi = "'"+record.FI+"'";
					//ff = "'"+record.FF+"'";
					//$("<td/>").html('<div onclick="rhi_detalle('+fi+','+ff+','+record.ID_U+');" class="custom-icon-edit-custom">'+
                    //'<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
                    //'</div>').appendTo(row);
					$("<td/>").text(record.DATE).appendTo(row);

					row.appendTo("#rhi_table");
				});
			$("#rhi_exp_exe").css("display","");
		}
	});
	
	

		
		$(document.body).css('cursor','wait');
		scroll_table=($("#dseg_lwdgt").height()-60)+"px";
		qstTable = $('#tseg_widget').dataTable({
		  "sScrollY": scroll_table,
		  "bDestroy": true,
		  "bLengthChange": true,
		  "bPaginate": false,
		  "bFilter": true,
		  "bSort": true,
		  "bJQueryUI": true,
		  "iDisplayLength": 20,      
		  "bProcessing": true,
		  "bAutoWidth": false,
		  "bSortClasses": false,
		  "sAjaxSource": "index.php?m=mSeguimiento&c=mWidgets&usr="+u+"&dti="+i+"&dtf="+f,
		  "aoColumns": [
			{ "mData": " ", sDefaultContent: "" },
			{ "mData": "QST", sDefaultContent: "" },

		  ] , 
		  /*"aoColumnDefs": [
			{"aTargets": [0],
			  //"sWidth": "65px",
			  "bSortable": true,        
			  "mRender": function (data, type, full) {
				//var edit  = '';
				//var del   = '';
				var gra   = '';
				
				var imp = '';
	
				
						date = "\'"+full.FECHA+"\'"
						eqst = "'"+full.QST+"'"
						user = "'"+full.NOMBRE_COMPLETO+"'"
				gra = '<td><div onclick="seg_get_preg_resp('+full.ID_RES_CUESTIONARIO+'),seg_get_position('+full.LATITUD+','+full.LONGITUD+','+date+','+eqst+','+user+')" class="custom-icon-copy">'+
						'<img class="total_width total_height" src="data:image/gif;base64,R0lGODlhAQABAJH/AP///wAAAMDAwAAAACH5BAEAAAIALAAAAAABAAEAQAICVAEAOw=="/>'+
						'</div></td>';
						
				imp = '<td><div onclick="seg_reporte_pdf('+full.ID_RES_CUESTIONARIO+','+date+','+eqst+','+user+')" >'+
						'<span class="ui-icon ui-icon-document" style="cursor:pointer;"></span>'+
						'</div></td>';		
						
				
	
				return '<table><tr>'+gra+imp+'</tr></table>';
			}}	
		  ],*/
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
		$(document.body).css('cursor','default');	
		//}
 
	}		
//--------------------------------------------------------------------------
function seg_velocimetro(){


        vchart = new Highcharts.Chart({
            chart: {
                renderTo: 'dseg_vel',
                type: 'gauge',
                alignTicks: false,
				backgroundColor: '#767473',
                events: {
                    redraw: function () {
                        this.ledBox && this.ledBox.destroy();

                        // 2nd pane center
                        var pane = this.panes[1].center;
                        this.ledBox = this.renderer.rect(pane[0] - 50, pane[1], 120, 80, 3).attr({
                            fill: 'rgba(229,137,100, 0.1)',
                            zIndex: 0
                        }).add();
                    }
                }
            },
            title: {
                text: ''
            },
            pane: [{
                startAngle: -120,
                endAngle: 120,
                size: 300,
                background: [{
                    // BG color for rpm
                    backgroundColor: '#1A1815',
                    outerRadius: '68%',
                    innerRadius: '48%'
                }, {
                    // BG color in between speed and rpm
                    backgroundColor: '#38392F',
                    outerRadius: '72%',
                    innerRadius: '67%'
                }, {
                    // BG color for speed
                    //  backgroundColor: '#E4E3DF',
                    backgroundColor: {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.6,
                            r: 1.0
                        },
                        stops: [
                            [0.3, '#A7A9A4'],
                            //[0.6, '#FF04FF'],
                            [0.45, '#DDD'],
                            [0.7, '#EBEDEA'],
                            //[0.7, '#FFFF04'],
                            ]
                    },
                    innerRadius: '72%',
                    outerRadius: '105%'
                }, {
                    // Below rpm bg color
                    // backgroundColor: '#909090',
                    zIndex: 1,
                    backgroundColor: {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.55,
                            r: 0.5
                        },
                        stops: [
                            [0.6, '#48443B'],
                            [0.8, '#909090'],
                            [1, '#FFFFF6']
                        ]
                    },
                    outerRadius: '48%',
                    innerRadius: '40%',
                }, {
                    backgroundColor: '#35382E',
                    zIndex: 1,
                    outerRadius: '40%',
                    innerRadius: '39%'
                }, {
                    backgroundColor: '#16160E',
                    outerRadius: '39%'

                }]
            }, {
                startAngle: -120,
                endAngle: 120,
                size: 200
            }],
            yAxis: [{
                title: {
                    text: ' km/h',
                    y: 178,
                    x: -86,
                    style: {
                        color: speedColor,
                        fontFamily: 'Squada One',
                        fontStyle: 'italic'
                    }
                },
                min: 0,
                max: 210,
                tickInterval: 10,
                tickLength: 6,
                lineWidth: 2,
                lineColor: speedColor,
                tickColor: speedColor,
                minorTickInterval: 5,
                minorTickLength: 3,
                minorTickWidth: 2,
                minorTickColor: speedColor,
                endOnTick: false,
                labels: {
                    rotation: 'auto',
                    step: 2,
                    style: {
                        fontFamily: 'Squada One',
                        fontSize: '28px',
                        color: speedColor,
                    }
                },
                pane: 0
            }, {
                min: 0,
                max: 220,
                tickLength: 2,
                minorTickLength: 2,
                minorTickInterval: 10,
                tickInterval: 10,
                tickPosition: 'outside',
                lineColor: speedColor,
                tickColor: speedColor,
                minorTickPosition: 'outside',
                minorTickColor: speedColor,
                labels: {
                    distance: 5,
                    rotation: 'auto',
                    style: {
                        color: speedColor,
                        zIndex: 0
                    },
                    formatter: function () {
                        var val = null;
                        var label = this.value;
                        $.each(kmhArr, function (idx, kmh) {
                            if (label == kmh) {
                                val = label;
                                return false;
                            }
                        });
                        return val;
                    }
                },
                endOnTick: false,
                offset: -40,
                pane: 0
            }, {
                title: {
                    text: 'rpm x1000',
                    y: 128,
                    x: -38,
                    style: {
                        color: rpmColor,
                        fontFamily: 'Squada One',
                        fontSize: '9px',
                        fontStyle: 'italic'
                    }
                },
                min: 0,
                max: 8,
                //offset: -50,
                minorTickInterval: 0.5,
                tickInterval: 1,
                tickLength: 3,
                minorTickLength: 6,
                lineColor: rpmColor,
                tickWidth: 2,
                minorTickWidth: 2,
                lineWidth: 2,
                labels: {
                    rotation: 'auto',
                    style: {
                        fontFamily: 'Squada One',
                        fontSize: '22px',
                        color: rpmColor
                    },
                    formatter: function () {
                        if (this.value >= 6) {
                            return '<span style="color:' + hiRef + '">' + this.value + "</span>";
                        }
                        return this.value;
                    }
                },
                pane: 1,
                plotBands: [{
                    from: 6,
                    to: 8,
                    color: hiRef,
                    innerRadius: '94%'
                },
				{
                    from: 4,
                    to: 6,
                    color: '#FFFF00',
                    innerRadius: '94%'
                }				
				]
            }],
            tooltip: {
                enabled: false
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Speed',
                yAxis: 0,
                data: [0],
                dataLabels: {
                    color: '#E58964',
                    borderWidth: 0,
                    y: 24,
                    x: 0,
                    style: {
                        fontSize: '40px',
                        fontFamily: 'digital',
                        fontStyle: 'italic'
                    },
                    formatter: function () {
                        return this.y.toFixed(1);
                    }
                },
                dial: {
                    backgroundColor: dialColor,
                    baseLength: '90%',
                    baseWidth: 7,
                    radius: '100%',
                    topWidth: 3,
                    rearLength: '-74%',
                    borderColor: '#B17964',
                    borderWidth: 1
                },
                zIndex: 1,
                pivot: {
                    radius: '0'
                }
            }, {
                name: 'RPM',
                data: [0],
                yAxis: 2,
                dataLabels: {
                    color: '#E58964',
                    borderWidth: 0,
                    y: -20,
                    x: 0,
                    style: {
                        fontSize: '14px',
                        fontFamily: 'digital',
                        fontStyle: 'italic'
                    },
                    formatter: function () {
                        return (this.y * 1000).toFixed(0) + " rpm"
                    }
                },
                dial: {
                    backgroundColor: dialColor,
                    baseLength: '90%',
                    baseWidth: 7,
                    radius: '100%',
                    topWidth: 3,
                    rearLength: '-74%',
                    borderColor: '#631210',
                    borderWidth: 1
                },
                pivot: {
                    radius: '0'
                }
            }]
        }, function (vchart) {
			//alert("function chart")
            // 2nd pane center
            var pane = vchart.panes[1].center;
            vchart.ledBox = vchart.renderer.rect(pane[0] - 50, pane[1], 120, 80, 3).attr({
                fill: 'rgba(229,137,100, 0)',
            }).add();

            var timer = setInterval(function () {
                var val = (rpmAccel[valCounter] === undefined) ? null : rpmAccel[valCounter];
                var speed = (speedAccel[spCounter] === undefined) ? null : speedAccel[spCounter];
                if (val !== null) {
                    vchart.series[1].points[0].update(val);
                    valCounter++;
                }
                if (speed !== null) {
                    vchart.series[0].points[0].update(speed);
                    spCounter++;
                }
                if (speed === null && val === null) {
                    clearInterval(timer);
                }
            }, 200);
        });
    	
	}	
//------------------------------------------------------------------------	
function seg_temperatura(){
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'dseg_tmp',
                type: 'gauge',
                alignTicks: false,
				backgroundColor: '#767473',
                events: {
                    redraw: function () {
                        this.ledBox && this.ledBox.destroy();

                        // 2nd pane center
                        var pane = this.panes[1].center;
                        this.ledBox = this.renderer.rect(pane[0] - 50).attr({
                            fill: 'rgba(229,137,100, 0.1)',
                            zIndex: 0
                        }).add();
                    }
                }
            },
            title: {
                text: 'Temperatura del motor',
				style: {
                        color: '#FFFFFF',
                        fontFamily: 'Squada One',
                        //fontStyle: 'italic'
                    }            },
            pane: [{
                startAngle: -120,
                endAngle: 120,
                size: 200,
                background: [{
                    // BG color for rpm
                    backgroundColor: '#1A1815',
                    outerRadius: '68%',
                    innerRadius: '48%'
                }, {
                    // BG color in between speed and rpm
                    backgroundColor: '#38392F',
                    outerRadius: '72%',
                    innerRadius: '67%'
                }, {
                    // BG color for speed
                    //  backgroundColor: '#E4E3DF',
                    backgroundColor: {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.6,
                            r: 1.0
                        },
                        stops: [
                            [0.3, '#A7A9A4'],
                            //[0.6, '#FF04FF'],
                            [0.45, '#DDD'],
                            [0.7, '#EBEDEA'],
                            //[0.7, '#FFFF04'],
                            ]
                    },
                    innerRadius: '72%',
                    outerRadius: '105%'
                }, {
                    // Below rpm bg color
                    // backgroundColor: '#909090',
                    zIndex: 1,
                    backgroundColor: {
                        radialGradient: {
                            cx: 0.5,
                            cy: 0.55,
                            r: 0.5
                        },
                        stops: [
                            [0.6, '#48443B'],
                            [0.8, '#909090'],
                            [1, '#FFFFF6']
                        ]
                    },
                    outerRadius: '48%',
                    innerRadius: '40%',
                }, {
                    backgroundColor: '#35382E',
                    zIndex: 1,
                    outerRadius: '40%',
                    innerRadius: '39%'
                }, {
                    backgroundColor: '#16160E',
                    outerRadius: '39%'

                }]
            }, {
                startAngle: -120,
                endAngle: 120,
                size: 200
            }],
            yAxis: [{
                title: {
                    text: ' \u00B0C',
                    y: 120,
                    x: -70,
                    style: {
                        color: speedColor,
                        fontFamily: 'Squada One',
                        fontStyle: 'italic'
                    }
                },
                min: -6,
                max:  6,
                tickInterval: 2,
                tickLength: 1,
                lineWidth: 1,
                lineColor: speedColor,
                tickColor: speedColor,
                minorTickInterval: 1,
                minorTickLength: 1,
                minorTickWidth: 1,
                minorTickColor: speedColor,
                endOnTick: false,
                labels: {
                    rotation: 'auto',
                    step: 1,
                    style: {
                        fontFamily: 'Squada One',
                        fontSize: '28px',
                        color: speedColor,
                    }
                },
                pane: 0,
				 plotBands: [{
                    from: 3,
                    to: 6,
                    color: hiRef,
                    innerRadius: '70%'
                },{
                    from: 0,
                    to: 3,
                    color: '#EBEC6E',
                    innerRadius: '70%'
                },{
                    from: -6,
                    to: 0,
                    color: '#55BF3B',
                    innerRadius: '70%'
                }]
            }, {
                title: {/*
                    text: 'rpm x1000',
                    y: 128,
                    x: -38,
                    style: {
                        color: rpmColor,
                        fontFamily: 'Squada One',
                        fontSize: '9px',
                        fontStyle: 'italic'
                    }
                */},
                //min: 0,
                //max: 8,
                //offset: -50,
               // minorTickInterval: 0.5,
                //tickInterval: 1,
                //tickLength: 3,
                //minorTickLength: 6,
                //lineColor: rpmColor,
                //tickWidth: 2,
                //minorTickWidth: 2,
                //lineWidth: 2,
                
                pane: 1,
                plotBands: [{/*
                    from: 6,
                    to: 8,
                    color: hiRef,
                    innerRadius: '94%'
                */}]
            }],
            tooltip: {
                //enabled: false
            },
            credits: {
                //enabled: false
            },
            series: [{
                name: 'Speed',
                yAxis: 0,
                data: [0],
                dataLabels: {
                    color: '#E58964',
                    borderWidth: 0,
                    y: 24,
                    x: 0,
                    style: {
                        fontSize: '40px',
                        fontFamily: 'digital',
                        fontStyle: 'italic'
                    },
                    formatter: function () {
                        return this.y.toFixed(1);
                    }
                },
                dial: {
                    backgroundColor: dialColor,
                    baseLength: '90%',
                    baseWidth: 7,
                    radius: '100%',
                    topWidth: 3,
                    rearLength: '-74%',
                    borderColor: '#B17964',
                    borderWidth: 1
                },
                zIndex: 1,
                pivot: {
                   // radius: '0'
                }
            }]
        }, function (chart) {

            // 2nd pane center
            var pane = chart.panes[1].center;
            chart.ledBox = chart.renderer.rect(pane[0] - 50).attr({
                fill: 'rgba(229,137,100, 0)',
            }).add();

            var timer = setInterval(function () {
               // var val = (rpmAccel[tvalCounter] === undefined) ? null : rpmAccel[tvalCounter];
                var temperature = (temp[tCounter] === undefined) ? null : temp[tCounter];
                //if (val !== null) {
                  //  chart.series[1].points[0].update(val);
                  //  tvalCounter++;
                //}
                if (temperature !== null) {
                    chart.series[0].points[0].update(temperature);
                    tCounter++;
                }
                if (temperature === null ) {
                    clearInterval(timer);
                }
            }, 200);
        });
    }
//-----------------------------------------------------------------------------------------------------------
function seg_fun_kmr(){
	if (seg_kmr.length>0){

			for(i=0; i<seg_kmr.length; i++){
			//doSetTimeout(i);
			//$("#dseg_km").html(seg_kmr[i]+" Km");
			setTimeout(function(i){return function(){$("#dseg_km").html(seg_kmr[i]+" Km");};}(i),200);
			}
			
		
		}
	
	}	
//----------------------------------
function doSetTimeout(i) {
  setTimeout(function() { $("#dseg_km").html(seg_kmr[i]+" Km"); }, 200);
}
//---------------------------------------
function seg_fun_kml(){
	if (seg_kml.length>0){
			for(i=0; i<seg_kml.length; i++){
			setTimeout(function(i){return function(){$("#dseg_gas").html(seg_kml[i]+" Km/l");};}(i),200);
			}
			
			for(i=0; i<seg_tf.length; i++){
			setTimeout(function(i){return function(){$("#seg_tf").html(seg_tf[i]+" l");};}(i),200);
			}
			
			for(i=0; i<seg_ifu.length; i++){
			setTimeout(function(i){return function(){$("#seg_ifu").html(seg_ifu[i]+" hr");};}(i),200);
			}
			
			for(i=0; i<seg_oil_pre.length; i++){
			setTimeout(function(i){return function(){$("#seg_oil_pre").html(seg_oil_pre[i]+" ");};}(i),200);
			}
			for(i=0; i<seg_t_cru.length; i++){
			setTimeout(function(i){return function(){$("#seg_t_cru").html(seg_t_cru[i]+" hr");};}(i),200);
			}
			for(i=0; i<seg_e_idle.length; i++){
			setTimeout(function(i){return function(){$("#seg_e_idle").html(seg_e_idle[i]+" hr");};}(i),200);
			}
			for(i=0; i<seg_e_load.length; i++){
			setTimeout(function(i){return function(){$("#seg_e_load").html(seg_e_load[i]+" kg");};}(i),200);
			}
			for(i=0; i<seg_e_time.length; i++){
			setTimeout(function(i){return function(){$("#seg_e_time").html(seg_e_time[i]+" hr");};}(i),200);
			}									
		}	
	}
	
//------------------------------------------------------------------------------------------------------------	
function seg_get_position(lat,lon,fecha,kmr,vel,rpm,kml,tmp){
	//alert(geo_gmap)
	var myLatlng = new google.maps.LatLng(lat,lon);	
	var data = '<table width="100%"><tr><td colspan="2" align="center" style="background:#4297D7; color:#EAF5F7;"><strong>Resumen</strong></td></tr><tr><td>Fecha:</td><td>'+fecha+'</td></tr><tr><td>Kilometros recorridos:</td><td>'+kmr+' km</td></tr><tr><td>Velocidad: </td><td>'+vel+' km/h</td></tr><tr><td>Revoluciones/minuto:</td><td>'+rpm+'</td></tr><tr><td>Rendimiento combustible: </td><td>'+kml+' km/l</td></tr><tr><td>Temperatura del motor :</td><td>'+tmp+'\u00B0C </td></tr></table>';
	//Pintar marcador
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: seg_map,
		zoom: 8
		});
	google.maps.event.addListener(marker, 'click', function() {
		infoWindow.setContent(data);
		infoWindow.open(seg_map, marker);
		});	
	seg_map.setZoom(18);	
	marker.setMap(seg_map);
	seg_map.setCenter(marker.getPosition());
	
	}
//-------------------------------------------------------------------------------
function seg_export_excel(){
	u = $("#seg_und").val();
	i = $("#seg_dti").val()+" "+$("#seg_hri").val()+":"+$("#seg_mni").val()+":00";
	f = $("#seg_dtf").val()+" "+$("#seg_hrf").val()+":"+$("#seg_mnf").val()+":00";
		
	var url= "index.php?m=mSeguimiento&c=mGetReport&f1="+i+"&f2="+f+"&und="+u; 
	window.location=url;
	return false;
	}	