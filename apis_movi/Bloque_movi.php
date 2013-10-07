<?php

    include('funciones_movi.php');

    //funciones de 
    function Login($usName,$usPassword,$imei,$vCode,$item_app,$tipo_app){ 
        $con = mysql_connect("localhost","savl","397LUP");
        if ($con){
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $cod_user = existeUsuario($usName,$usPassword,$base);
            if ($cod_user > 0){
                if (verifica_grupo($cod_user,$base,&$s)){
                    $version="";
                    $url="";
                    verificaVersion($base,&$version,&$url,$item_app,$cod_user);
                    if ( $version == $vCode){
                        if($tipo_app=="1"){ //tipo 1= equipo de Evidencias movilidad
                            if(existe_equipo($base,$imei)>0){
                                $res =  $resultado["id"]=$cod_user;
                                $resultado["Mensaje"]="OK";	
                            }else{
                                $res =  $resultado["id"]=-1;
                                $resultado["Mensaje"]="El equipo no esta dado de alta ".$imei;	
                            }
                        }else{
                            $res =  $resultado["id"]=$cod_user;
                            $resultado["Mensaje"]="OK";	
                        }
                    }else{
                        if($tipo_app=="1"){
                            if(existe_equipo($base,$imei)>0){
                                $resultado["id"]=$cod_user;
                                $resultado["Mensaje"]="OK,".$version.','.$url;	
                            }else{
                                $res =  $resultado["id"]=-1;
                                $resultado["Mensaje"]="El equipo no esta dado de alta ".$imei;	
                            }
                        }else{
                            $resultado["id"]=$cod_user;
                            $resultado["Mensaje"]="OK,".$version.','.$url;
                        }
                    }
                }else{
                    $resultado["id"]="-4";
                    $resultado["Mensaje"]="El usuario no tiene asociado un grupo y/o unidades";		  
                }
            }else{
                $resultado["id"]="-3";
                $resultado["Mensaje"]="El usuario y/o password son inválidos";	
            }
        }else{
            $resultado["id"]="-1";
            $resultado["Mensaje"]="No hay conexión a base de datos";
        }
        $output[]=$resultado;
        $res= json_encode($output);
        return $res;
    }

    function Cuestionarios($cod_user){ 
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            return "Error de conexion al obtener los cuestionarios";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $sql="SELECT CRM2_VENDEDOR_CUESTIONARIO.ID_CUESTIONARIO,
                          CRM2_VENDEDOR_CUESTIONARIO.ORDEN,
                          CRM2_VENDEDOR_CUESTIONARIO.COD_USER,
                          CRM2_CUESTIONARIOS.DESCRIPCION,
                          CRM2_VENDEDOR_CUESTIONARIO.POR_DEFECTO,
                          CRM2_CUESTIONARIOS.ID_TIPO,
                          CRM2_CUESTIONARIOS.URL,
                          CRM2_TEMA.BARRA,
                          CRM2_TEMA.CABECERA,
                          CRM2_TEMA.CUERPO,
                          CRM2_CUESTIONARIOS.ID_EJE_X,
                          CRM2_CUESTIONARIOS.ID_EJE_Y
                   FROM   CRM2_VENDEDOR_CUESTIONARIO
                          INNER JOIN CRM2_CUESTIONARIOS ON CRM2_CUESTIONARIOS.ID_CUESTIONARIO = CRM2_VENDEDOR_CUESTIONARIO.ID_CUESTIONARIO
                          INNER JOIN CRM2_TEMA ON CRM2_TEMA.ID_TEMA=CRM2_CUESTIONARIOS.TEMA
                   WHERE  CRM2_VENDEDOR_CUESTIONARIO.COD_USER=".$cod_user."
                   ORDER BY CRM2_VENDEDOR_CUESTIONARIO.ORDEN";
            $query=mysql_query($sql);
            $cuenta=0;
            if ($query){
                while($e=mysql_fetch_assoc($query)){
                    $output[]=utf8_encode_array($e);
                    $cuenta++;
                }
            }
            if($cuenta>0){
                return json_encode($output);
            }else{
                return "El usuario no tiene cuestionarios asignados";
            }
        }
    }

    function Preguntas($cod_user){ 
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            return "Error de conexion al obtener las preguntas";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $sql="SELECT CRM2_CUESTIONARIO_PREGUNTAS.ID_CUESTIONARIO,
                         CRM2_CUESTIONARIO_PREGUNTAS.ID_PREGUNTA,
                         CRM2_PREGUNTAS.ID_TIPO,
                         CRM2_PREGUNTAS.DESCRIPCION,
                         CRM2_PREGUNTAS.COMPLEMENTO,
                         CRM2_PREGUNTAS.RECORDADO,
                         CRM2_TIPO_PREG.MULTIMEDIA,
                         CRM2_PREGUNTAS.REQUERIDO
                  FROM CRM2_CUESTIONARIO_PREGUNTAS
                       INNER JOIN CRM2_PREGUNTAS ON
                                  CRM2_PREGUNTAS.ID_PREGUNTA=CRM2_CUESTIONARIO_PREGUNTAS.ID_PREGUNTA
                       INNER JOIN CRM2_VENDEDOR_CUESTIONARIO ON
                                  CRM2_VENDEDOR_CUESTIONARIO.ID_CUESTIONARIO=CRM2_CUESTIONARIO_PREGUNTAS.ID_CUESTIONARIO
                       INNER JOIN CRM2_TIPO_PREG ON
                                  CRM2_TIPO_PREG.ID_TIPO=CRM2_PREGUNTAS.ID_TIPO
                  WHERE CRM2_VENDEDOR_CUESTIONARIO.COD_USER=".$cod_user." 
                  GROUP BY CRM2_CUESTIONARIO_PREGUNTAS.ID_CUESTIONARIO, CRM2_CUESTIONARIO_PREGUNTAS.ID_PREGUNTA
                  ORDER BY CRM2_CUESTIONARIO_PREGUNTAS.ORDEN";
            $query=mysql_query($sql);
            $cuenta=0;
            if ($query){
                while($e=mysql_fetch_assoc($query)){
                    $output[]=utf8_encode_array($e);
                    $cuenta++;
                }
            }
            if($cuenta>0){
                return json_encode($output);
            }else{
                return "El usuario no tiene preguntas en los cuestionarios asignados";
            }
        }
    }

    function dame_datos_payload($cod_user){
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            return "Error de conexion al obtener las preguntas";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $sql="SELECT ADM_GEOREFERENCIAS.ITEM_NUMBER AS COD_OBJECT_MAP,
                         ADM_GEO_PAYLOAD.ID_CUESTIONARIO,
                         ADM_GEO_PAYLOAD.CADENA_PAYLOAD
                  FROM ADM_GEO_PAYLOAD
                         INNER JOIN ADM_GEOREFERENCIAS ON ADM_GEOREFERENCIAS.ID_OBJECT_MAP=ADM_GEO_PAYLOAD.ID_OBJECT_MAP
                         INNER JOIN ADM_USUARIOS ON ADM_USUARIOS.ID_CLIENTE =ADM_GEOREFERENCIAS.ID_CLIENTE
                         INNER JOIN CRM2_VENDEDOR_CUESTIONARIO ON CRM2_VENDEDOR_CUESTIONARIO.ID_CUESTIONARIO=ADM_GEO_PAYLOAD.ID_CUESTIONARIO AND
                         CRM2_VENDEDOR_CUESTIONARIO.COD_USER=ADM_USUARIOS.ID_USUARIO
                  WHERE ADM_USUARIOS.ID_USUARIO=".$cod_user;
            $query=mysql_query($sql);
            if($query){
                 while($e=mysql_fetch_assoc($query)){
                     $output[]=utf8_encode_array($e);
                 }
            }
            echo json_encode($output);
            mysql_close();
        }
    }

    function Tntserta_Cuest($cuestionario,$cod_user,$imei,$lat,$lon,$alt,$ang,$vel,$feh,$bat,$respu,$cellid,$lac,$mcc_mnc,$senal,$macc,$senal_w,$prov,$fecha_red,$mts_error,$item_app,$tipo_cuest,$dto_cuanti,$dto_x,$dto_y,$fecha_ini_cap){
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            return "Error de conexion al obtener las preguntas";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            //creo arreglo
            $reg['cuestionario']=$cuestionario;
            $reg["cod_user"]=$cod_user;
            $reg["imei"]=$imei;
            $reg["lat"]=$lat;
            $reg["lon"]=$lon;
            $reg["alt"]=$alt;
            $reg["ang"]=$ang;
            $reg["vel"]=$vel;
            $reg["feh"]=$feh;
            $reg["bat"]=$bat;
            $reg["respu"]=$respu;
            $reg['cellid']=$cellid;
            $reg['lac']=$lac;
            $reg['mcc_mnc']=$mcc_mnc;
            $reg['senal']=$senal;
            $reg['macc']=$macc;
            $reg['senal_w']=$senal_w;
            $reg["prov"]=$prov;
            $reg["fecha_red"]=$fecha_red;
            $reg["mts_error"]=$mts_error;
            $reg["tipo_cuest"]=$tipo_cuest;
            $reg["dto_cuanti"]=$dto_cuanti;
            $reg["fecha_ini_cap"]=$fecha_ini_cap;
            $reg["dto_x"]=$dto_x;
            $reg["dto_y"]=$dto_y;


            //obtengo el id_respuesta para el nuevo cuestionario
            $reg['respuesta'  ]=inserta_respuestas($reg);
            if($reg['respuesta'  ]>0){
                $reg['cod_client' ]=dame_cod_client_usuario($reg["cod_user"]);
                //version de la aplicacion
                $version="";
                $url="";
                verificaVersion($base,&$version,&$url,$item_app,$reg["cod_user"]);
                $reg["version_apk"] = $version.",".$url;
                //tiempo de reporte de la aplicacion
                $tiempo=dame_tiempo_reporte_unidad($base,$reg["imei"]);
                if($tiempo<=0){
                    $reg["tiempo_apk"]=5;
                }else{
                    $reg["tiempo_apk"]= $tiempo;
                }
                $reg['cod_entity']= dame_cod_entity($reg["imei"]);
                //Evento de cuestionario
                $reg['cod_event']=10000;
                //Recorre las respuestas
                $array_respuesta = explode("|||", $reg["respu"]);
                $error=0;
                $reg['geo_punto']=0;
                $nuevo_gop="N";
                $cuenta_fotos=0;
                $fotos="";
                foreach ($array_respuesta as &$respuesta){
                    $array_resultados= explode("||", $respuesta);
                    $reg['pregunta']= trim($array_resultados[0]);
                    $reg['res_p'   ]= trim($array_resultados[1]);
                    $tipo=es_para_geopunto($reg['pregunta']);
                    $reg["geo_p"]=0;
                    //verifica si es para georeferencias en cuestionarios
                    if($tipo=="GEOPUNTO"){
                        $array_dtos_geop = explode(",", $reg['res_p']);
                        $tamano=sizeof($array_dtos_geop);
                        if($tamano==3){
                            $reg['radio'      ]=$array_dtos_geop[0];
                            $reg['descripcion']=$array_dtos_geop[1];
                            $reg['clave'      ]=strtoupper($array_dtos_geop[2]);
                            $reg['garbage'    ]="0"; 
                            $reg['geo_punto'  ]=existe_geopunto($reg['clave'],$reg['cod_client' ]);
                            //Si no existe el geopunto
                            if($reg['geo_punto']<=0){
                                $reg['geo_punto']=inserta_geopunto($reg);
                                inserta_cus_geop($reg);
                                $nuevo_gop="S";
                            }else{
                                inserta_cus_geop($reg);
                                $nuevo_gop="N";
                            }
                        }
                    }
                    //Referencia a un geopunto
                    if($tipo=="REFERENCIA"){
                        $reg['clave'      ]= strtoupper($reg['res_p' ]);
                        $reg['geo_punto'  ]= existe_geopunto($reg['clave'],$reg['cod_client' ]);
                        if($reg['geo_punto']>0){
                            inserta_cus_geop($reg);  
                            $nuevo_gop="N";
                        }else{
                            $nuevo_gop="S"; 
                            $reg['cod_client' ]=dame_cod_client_usuario($reg["cod_user"]);
                            $reg['radio'      ]=50;
                            $reg['descripcion']="INTENTO DE REFERENCIA VACIA";
                            $reg['clave'      ]=strtoupper($reg['res_p' ]);
                            $reg['garbage'    ]="1";   
                            $reg['geo_punto']=inserta_geopunto($reg);
                            inserta_cus_geop($reg);
                        }
                    }
                    //Es tupo foto
                    if($tipo=="FOTO"){
                        if($cuenta_fotos>0){
                            $fotos= $fotos.",".$reg['res_p'];
                        }else{
                            $fotos= $reg['res_p'];
                        }
                        $cuenta_fotos++;
                    }
                    //inserto la respuesta
                    if(inserta_respuesta($reg)<=0){
                        $error=1;
                        break;
                    }
                }
                //Si es nuevo geopunto y hay imagenes las guardo
                if($nuevo_gop=="S"){
                    $array_fotos= explode(",",$fotos);	
                    foreach ($array_fotos as $img) {
                        geop_img($reg['geo_punto'],$img);
                    }
                }
                //Si no hay error creo el evento y notifico todo guardado con exito
                if ($erro==0){
                    if($reg['cod_client' ]>0){
                        $ins_event=inst_evento($reg);
                        if ($ins_event>0){
                            if(trim($reg["tipo_cuest"])=="3"){
                                if(inserta_cuantitativo($reg)>0){
                                     echo "15,".$reg["version_apk"].",".$reg["tiempo_apk"];
                                }else{
                                    $respuesta="Error al escribir en datos cuantitativo";
                                    echo $respuesta;
                                }
                            }else{
                                echo "15,".$reg["version_apk"].",".$reg["tiempo_apk"];
                            }
                        }else{
                            //si encuentra error deshace todo lo anterior sobre los cuestionarios
                            elimina_respuesta($reg);
                            $respuesta="Error al escribir el evento";
                            if($ins_event==-1)  $respuesta="Error al escribir en tabla de ultimo evento";
                            if($ins_event==-2)  $respuesta="Error al escribir en tabla de Historico";
                            if($ins_event==-3)  $respuesta="Error al escribir en tabla de respuesta e historico";
                            if($ins_event==-4)  $respuesta="Error el evento no tiene una respuesta de cuestionario";
                            echo $respuesta;
                        }
                    }else{
                         elimina_respuesta($reg);
                         echo "Error al buscar Codigo de cliente";
                    }
                }else{
                    //si encuentra error deshace todo lo anterior sobre los cuestionarios
                    elimina_respuesta($reg);
                    echo "Errores al guardar la respuesta";
                }
            }else{
                echo "Error al guardar la respuesta";	
            }
        }
    }
	
    function Intserta_evento($imei,$feh,$bat,$cd_ev,$cellid,$lac,$mcc_mnc,$senal,$macc,$senal_w,$vel,$lon,$lat,$alt,$ang,$prov,$fech_r,$mts_e){
        $con = mysql_connect("localhost","savl","397LUP");
        $reg['respuesta']=0;
        $reg["imei"]=$imei;
        $reg["feh"]=$feh;
        $reg["bat"]=$bat;
        $reg['cod_event']=$cd_ev;
        $reg['cellid']=$cellid;
        $reg['lac']=$lac;
        $reg['mcc_mnc']=$mcc_mnc;
        $reg['senal']=$senal;
        $reg['macc']=$macc;
        $reg['senal_w']=$senal_w;
        $reg["vel"]=$vel;
        $reg["lon"]=$lon;
        $reg["lat"]=$lat;
        $reg["alt"]=$alt;
        $reg["ang"]=$ang;
        $reg["prov"]=$prov;
        $reg["fecha_red"]=$fech_r;
        $reg["mts_error"]=$mts_e;
        $reg["GC"]=$reg['mcc_mnc']."".$reg['lac']."".$reg['cellid'];
        $reg["mcc"]= substr($reg['mcc_mnc'],0,3);
        $reg["mnc"]= substr($reg['mcc_mnc'],3,3);
        if (!$con){
            return "Error de conexion al obtener las preguntas";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $reg['cod_client' ]=dame_cod_client_equipo($reg["imei"]);
            $reg['cod_entity']=dame_cod_entity($reg["imei"]);
            if ($reg['cod_entity']>0){
                if ($reg['cod_client']>0){
                    $ins_event=inst_evento($reg);
                    if ($ins_event>0){
                        echo "15";
                    }else{
                        $respuesta="Error al escribir el evento";
                        if($ins_event==-1)  $respuesta="Error al escribir en tabla de ultimo evento";
                        if($ins_event==-2)  $respuesta="Error al escribir en tabla de Historico";
                        if($ins_event==-3)  $respuesta="Error al escribir en tabla de respuesta e historico";
                        if($ins_event==-4)  $respuesta="Error el evento no tiene una respuesta de cuestionario";
                        echo $respuesta;
                    }
                }else{
                    echo "Error al buscar Codigo de cliente en evento";
                }
            }else{
                echo "Error al buscar cod_entity";
            }
        }
    }
	
    function dame_menu_catalogos($user){
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            return "Error de conexion al obtener las preguntas";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $sql="SELECT CAT_MENU.ID_MENU,
                         CAT_MENU.DESCRIPTION AS MENU,
                         CAT_SUBMENU.ID_SUBMENU,
                         CAT_SUBMENU.DESCRIPTION AS SUBMENU,
                         CAT_SUBMENU.ICONO_MOVIL,
                         CAT_SUBMENU.ITEM_NUMBER,
                         CAT_SUBMENU.UBICACION,
                         CAT_SUBMENU.ACCION,
                         CAT_SUBMENU.TIPO
                 FROM  ADM_USUARIOS
                         INNER JOIN CAT_USUARIO_SUBMENU ON CAT_USUARIO_SUBMENU.ID_USUARIO=ADM_USUARIOS.ID_USUARIO
                         INNER JOIN CAT_SUBMENU ON CAT_SUBMENU.ID_SUBMENU=CAT_USUARIO_SUBMENU.ID_SUBMENU
                         INNER JOIN CAT_MENU ON CAT_MENU.ID_MENU = CAT_SUBMENU.ID_MENU
                 WHERE ADM_USUARIOS.ID_USUARIO=".$user." AND CAT_SUBMENU.TIPO IN ('A','M') AND CAT_SUBMENU.ACTIVO='S'
                 ORDER BY CAT_MENU.ID_MENU,CAT_SUBMENU.SECUENCIA";
            $query=mysql_query($sql);
            if ($query){
                while($e=mysql_fetch_assoc($query)){
                    $output[]=$e;
                }
                $output= utf8_encode_array($output);
                return json_encode($output);
            }else{
                return "error";
            }
        }
    }

    function dame_archivo_catalogos($sub_menu){
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            return "Error de conexion al obtener las preguntas";
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $sql="SELECT CAT_CONTENIDO.UBICACION_LOCAL,
                     CAT_CONTENIDO.UBICACION_REMOTA
                  FROM  CAT_CONTENIDO
                  WHERE CAT_CONTENIDO.ID_SUBMENU=".$sub_menu."
                  ORDER BY CAT_CONTENIDO.ORDEN";
            $query=mysql_query($sql);
            if ($query){
                while($e=mysql_fetch_assoc($query)){
                    $output[]=$e;
                }
                $output= utf8_encode_array($output);
                echo json_encode($output);
            }else{
               echo "error";
            }
        }
    }
	
    function dameItinerario($imei){
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            $res = '<?xml version="1.0" encoding="UTF-8"?> 
                        <alert> 
                             <id>-51</id> 
                             <msg>Error de conexión</msg>
                        </alert>';  
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $res = "";
            $sql=" SELECT D.ID_DESPACHO,
                         D.DESCRIPCION AS VIAJE,
                         D.ITEM_NUMBER AS ITEM_VIAJE,
                         D.FECHA_INICIO,
                         D.FECHA_FIN,
                         D.TOLERANCIA,
                         D.ID_ESTATUS,
                         E.DESCRIPCION AS ESTATUS
                  FROM DSP_DESPACHO D
                         INNER JOIN DSP_UNIDAD_ASIGNADA U ON U.ID_DESPACHO = D.ID_DESPACHO AND U.ACTIVO = 1
                         INNER JOIN DSP_ESTATUS E ON D.ID_ESTATUS = E.ID_ESTATUS
                         INNER JOIN ADM_UNIDADES_EQUIPOS EN ON EN.COD_ENTITY = U.COD_ENTITY
                         INNER JOIN ADM_UNIDADES_EQUIPOS UE ON UE.COD_ENTITY= EN.COD_ENTITY
                         INNER JOIN ADM_EQUIPOS EQ ON EQ.COD_EQUIPMENT=UE.COD_EQUIPMENT
                         INNER JOIN DSP_ITINERARIO I ON I.ID_DESPACHO = D.ID_DESPACHO
                  WHERE EQ.IMEI =  '".$imei."' AND
                         (D.ID_ESTATUS NOT IN (3,5) OR CURRENT_DATE BETWEEN CAST(D.FECHA_INICIO AS DATE) AND CAST(D.FECHA_FIN AS DATE) )
                  GROUP BY D.ID_DESPACHO, D.DESCRIPCION
                  ORDER BY D.FECHA_INICIO";
            if ($query = mysql_query($sql)){
                $res = '<?xml version="1.0" encoding="UTF-8"?>';
                $res = $res.'<viajes>';
                while ($row = mysql_fetch_object($query)){
                    $id_despacho = $row->ID_DESPACHO;
                    $x = $x."<viaje>";
                    $x = $x."<id_viaje>".$row->ID_DESPACHO."</id_viaje>";
                    $x = $x."<nombre>".$row->VIAJE."</nombre>";
                    $x = $x."<item>".$row->ITEM_VIAJE."</item>";
                    $x = $x."<inicio>".$row->FECHA_INICIO."</inicio>";
                    $x = $x."<fin>".$row->FECHA_FIN."</fin>";
                    $x = $x."<tolerancia>".$row->TOLERANCIA."</tolerancia>";
                    $x = $x."<estatus>".$row->ESTATUS."</estatus>";
                    $x = $x."<id_estatus>".$row->ID_ESTATUS."</id_estatus>";
                    $x = $x."</viaje>";
                }
                $res = $res.$x."</viajes>";
                mysql_free_result($query);
            }else {
                $res='<?xml version="1.0" encoding="UTF-8"?> 
                      <alert> 
                         <id>-50</id> 
                         <msg>No es posible leer la los viajes</msg>
                      </alert>';
            }
            return $res;
        }
    }

    function dameEntregas($viaje){
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            $res = '<?xml version="1.0" encoding="UTF-8"?> 
                        <alert> 
                             <id>-51</id> 
                             <msg>Error de conexión</msg>
                        </alert>';  
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $res = "";
            $sql2 = "SELECT I.ID_DESPACHO,
                            I.ID_ENTREGA,
                            P.DESCRIPCION AS CLIENTE,
                            P.CALLE, 
                            P.COLONIA,
                            P.CP,
                            P.MUNICIPIO,
                            P.ESTADO,
                            P.LATITUDE,
                            P.LONGITUDE,
                            P.RADIO,
                            I.ID_ESTATUS,
                            IF(I.ITEM_NUMBER IS NULL,'SIN DATOS', IF (I.ITEM_NUMBER = '','SIN DATOS',I.ITEM_NUMBER) ) AS ITEM_ENTREGA,
                            IF(I.COMENTARIOS IS NULL,'SIN DATOS', IF (I.COMENTARIOS = '','SIN DATOS',I.COMENTARIOS)) AS COMENTARIOS,
                            I.FECHA_ENTREGA AS FECHA_PROGRAMADA,
                            E.DESCRIPCION AS ESTATUS,
                            IF (I.FECHA_ARRIBO IS NULL, 'NO HA LLEGADO A LA ENTREGA', I.FECHA_ARRIBO) AS ARRIBO_SITIO,
                            IF (I.FECHA_SALIDA IS NULL, 'NO HA SALIDO DE LA ENTREGA', I.FECHA_SALIDA) AS SALIDA_SITIO,
                            IF(D.ID_CUESTIONARIO IS NULL,-1,D.ID_CUESTIONARIO) AS ID_CUESTIONARIO
                     FROM DSP_ITINERARIO I
                            INNER JOIN DSP_ESTATUS E ON E.ID_ESTATUS = I.ID_ESTATUS
                            INNER JOIN ADM_GEOREFERENCIAS P ON P.ID_OBJECT_MAP = I.COD_GEO
                            LEFT JOIN DSP_DOCUMENTA_ITINERARIO D ON D.ID_ENTREGA = I.ID_ENTREGA
                     WHERE   I.ID_DESPACHO IN(".$viaje.") 
                     ORDER BY I.FECHA_ENTREGA ASC";
            if ($qry2 = mysql_query($sql2)){
                $res = '<?xml version="1.0" encoding="UTF-8"?>';
                $res = $res.'<entregas>';
                while ($row2 = mysql_fetch_object($qry2)){
                    $x = $x.'<entrega>';
                    $x = $x.'<id_viaje>'.$row2->ID_DESPACHO.'</id_viaje>';
                    $x = $x."<id_entrega>".$row2->ID_ENTREGA."</id_entrega>";
                    $x = $x."<cliente>".trim($row2->CLIENTE)."</cliente>"; 
                    $x = $x."<direccion>".$row2->CALLE." ".$row2->COLONIA." ".$row2->CP." "
                                         .$row2->MUNICIPIO." ".$row2->ESTADO.
                             "</direccion>"; 
                    $x = $x."<latitud>".$row2->LATITUDE."</latitud>"; 
                    $x = $x."<longitud>".$row2->LONGITUDE."</longitud>"; 
                    $x = $x."<item_entrega>".$row2->ITEM_ENTREGA."</item_entrega>"; 
                    $x = $x."<comentarios>".$row2->COMENTARIOS."</comentarios>"; 
                    $x = $x."<fecha_programada>".$row2->FECHA_PROGRAMADA."</fecha_programada>"; 
                    $x = $x."<estatus_entrega>".$row2->ESTATUS."</estatus_entrega>"; 
                    $x = $x."<fecha_arribo>".$row2->ARRIBO_SITIO."</fecha_arribo>"; 
                    $x = $x."<fecha_salida>".$row2->SALIDA_SITIO."</fecha_salida>";
                    $x = $x."<radio>".$row2->RADIO."</radio>";
                    $x = $x."<id_estatus>".$row2->ID_ESTATUS."</id_estatus>";
                    $x = $x."<id_cus>".$row2->ID_CUESTIONARIO."</id_cus>"; 
                    $x = $x."</entrega>";
                }
                mysql_free_result($qry2);
                $res = $res.$x."</entregas>";
            }else{
                $res = '<?xml version="1.0" encoding="UTF-8"?> 
                        <alert> 
                             <id>-50</id> 
                             <msg>No es posible leer la las entregas</msg>
                        </alert>';
            }
            return $res;
        }
    }
	
	
	function putIncidenteEntrega($imei,$codUser,$idTipo,$idEntrega,$fecha,$Comentarios,$latitud,$longitud,$evento,$bateria,$velocidad){ 
        $con = mysql_connect("localhost","savl","397LUP");
        if (!$con){
            $res = '<?xml version="1.0" encoding="UTF-8"?> 
                        <alert> 
                             <id>-51</id> 
                             <msg>Error de conexión</msg>
                        </alert>';  
        }else{
            $base = mysql_select_db("ALG_BD_CORPORATE_MOVI",$con);
            $cod_user = existeCodUser($codUser);
            if ($cod_user == $codUser){
                if (valida_evento($evento) == 1){
					$cod_client=dame_cod_client_usuario($codUser);
					$cod_entity=dame_cod_entity($imei);
                    $res = registraIncidente($imei,$codUser,$idTipo,$idEntrega,$fecha,$Comentarios,$latitud,$longitud,$evento,$bateria,$velocidad,$cod_client,$cod_entity);
                }else{
                    $res = '<?xml version="1.0" encoding="UTF-8"?> 
                            <alert> 
                              <id>-50</id> 
                              <msg>El código de evento no existe</msg>
                           </alert>';
                }
            }else{
                $res = '<?xml version="1.0" encoding="UTF-8"?> 
                        <alert> 
                             <id>-51</id> 
                             <msg>El código usuario es incorrecto</msg>
                        </alert>';  
            }
        }
        return $res;
    }
	
?>