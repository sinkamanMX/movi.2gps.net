<?php
    //bloques de validación
    include('Bloque_movi.php');
    //parametros de entrada pára el login
    $funcion = $_REQUEST['fun'];

    if ($_REQUEST['fun'] == 'Login'){
        echo Login ($_REQUEST['usName'],$_REQUEST['usPassword'],$_REQUEST['imei'],$_REQUEST['vCode'],$_REQUEST['item_app'],$_REQUEST['tipo_app']);
    } 

    if ($_REQUEST['fun'] == 'cuest_usu'){
        echo Cuestionarios($_REQUEST['cod_user']);
    } 

    if ($_REQUEST['fun'] == 'pregun_usu'){
        echo Preguntas($_REQUEST['cod_user']);
    }

    if ($_REQUEST['fun'] == 'int_cuest'){
        echo Tntserta_Cuest(utf8_decode ($_REQUEST["cu"]),
                            utf8_decode ($_REQUEST["cod_u"]),
                            utf8_decode ($_REQUEST["im"]),
                            utf8_decode ($_REQUEST["lat"]),
                            utf8_decode ($_REQUEST["lon"]),
                            utf8_decode ($_REQUEST["alt"]),
                            utf8_decode ($_REQUEST["ang"]),
                            utf8_decode ($_REQUEST["vel"]),
                            utf8_decode ($_REQUEST["feh"]),
                            utf8_decode ($_REQUEST["bat"]),
                            utf8_decode ($_REQUEST["res"]),
                            utf8_decode ($_REQUEST["cellid"]),
                            utf8_decode ($_REQUEST["lac"]),
                            utf8_decode ($_REQUEST["mcc_mnc"]),
                            utf8_decode ($_REQUEST["senal"]),
                            utf8_decode ($_REQUEST["macc"]),
                            utf8_decode ($_REQUEST["senal_w"]),
                            utf8_decode ($_REQUEST["prov"]),
                            utf8_decode ($_REQUEST["fech_r"]),
                            utf8_decode ($_REQUEST["mts_e"]),
                            utf8_decode ($_REQUEST['item_app']),
                            utf8_decode ($_REQUEST['tipo_cuest']),
                            utf8_decode ($_REQUEST['dto_cuanti']),
                            utf8_decode ($_REQUEST['dto_x']),
                            utf8_decode ($_REQUEST['dto_y']),
                            utf8_decode ($_REQUEST['fecha_ini_cap']));
    }

    if ($_REQUEST['fun'] == 'evemto'){
        echo Intserta_evento($_REQUEST["im"],
                             $_REQUEST["feh"],
                             $_REQUEST["bat"],
                             $_REQUEST["cd_ev"],
                             $_REQUEST["cellid"],
                             $_REQUEST["lac"],
                             $_REQUEST["mcc_mnc"],
                             $_REQUEST["senal"],
                             $_REQUEST["macc"],
                             $_REQUEST["senal_w"],
                             $_REQUEST["vel"],
                             $_REQUEST["lon"],
                             $_REQUEST["lat"],
                             $_REQUEST["alt"],
                             $_REQUEST["ang"],
                             $_REQUEST["prov"],
                             $_REQUEST["fech_r"],
                             $_REQUEST["mts_e"]);
    }

    if ($_REQUEST['fun'] == 'd_payload'){	
        echo dame_datos_payload($_REQUEST["cod_user"]);
    }
	
    if ($_REQUEST['fun'] == 'menu_cat'){	
        echo dame_menu_catalogos($_REQUEST["user"]);
    }

    if ($_REQUEST['fun'] == 'archivo_cat'){	
        echo dame_archivo_catalogos($_REQUEST["sub_menu"]);
    }
?>