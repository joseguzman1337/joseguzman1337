<?php
/*
 * @modified Andres Ariza <arizaancres@unbosque.edu.co>
 * Se unifica la declaracion del archivo de configuracion general para validacion de sesion
 * @since  Agosto 9 2018
*/
require_once(realpath(dirname(__FILE__)."/../../../../sala/config/Configuration.php"));
$Configuration = Configuration::getInstance();

if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"){
    require_once (PATH_ROOT.'/kint/Kint.class.php');
}

require_once (PATH_SITE.'/lib/Factory.php');
Factory::importGeneralLibraries();
$variables = new stdClass();
$option = "";
$tastk = "";
$action = "";
if(!empty($_REQUEST)){
    $keys_post = array_keys($_REQUEST);
    foreach ($keys_post as $key_post) {
        $variables->$key_post = strip_tags(trim($_REQUEST[$key_post]));
        //d($key_post);
        switch($key_post){
            case 'option':
                @$option = $_REQUEST[$key_post];
                break;
            case 'task':
                @$task = $_REQUEST[$key_post];
                break;
            case 'action':
                @$action = $_REQUEST[$key_post];
                break;
            case 'layout':
                @$layout = $_REQUEST[$key_post];
                break;
                break;
            case 'itemId':
                @$itemId = $_REQUEST[$key_post];
                break;
        }
    }
}
Factory::validateSession($variables);

switch($_REQUEST['actionID']){
    case 'DuplicarEstructuraPrograma':
        MainJson();
        global $userid,$db;
        
        $id = $_GET['id'];
        $Programa_id  = $_GET['Programa_id'];
        $SQL='SELECT 
                    idsiq_estructuradocumento as id,
                    nombre_documento,
                    nombre_entidad,
                    tipo_documento,
                    id_carrera
              FROM			
                    siq_estructuradocumento
              WHERE     
                    idsiq_estructuradocumento="'.$id.'" AND codigoestado=100';
        
        if($Select_Datos=&$db->Execute($SQL)===false){
            $a_vectt['val'] ='FALSE';
            $a_vectt['descrip'] ='Error al Buscar Datos ....'.$SQL_Datos;
            echo json_encode($a_vectt);
            exit;
        }	
        ##############################
        #echo '<br>SQL-->'.$SQL.'<br>';
        ##############################	
        ##########################################Insert para Cabesera en la Tabla siq_estructuradocumento #########################################################################
	
        $SQL_Insert_Cabeza='INSERT INTO siq_estructuradocumento(nombre_documento,nombre_entidad,tipo_documento,id_carrera,userid,entrydate)VALUES("'.$Select_Datos->fields['nombre_documento'].'_Duplicado","'.$Select_Datos->fields['nombre_entidad'].'","'.$Select_Datos->fields['tipo_documento'].'","'.$Programa_id.'","'.$userid.'",NOW())';
        
        if($Insert_Cabeza=&$db->Execute($SQL_Insert_Cabeza)===false){
            $a_vectt['val'] ='FALSE';
            $a_vectt['descrip'] ='Error al Insertar la Estructura del Documento....<br>'.$SQL_Insert_Cabeza;
            echo json_encode($a_vectt);
            exit;
        }
        #echo '<br>'.$SQL_Insert_Cabeza.'<br>';
        #############################
        $id_Cabeza=$db->Insert_ID();
        #############################
        
        $SQL_Indicador='SELECT
            indEstru.idsiq_indicadoresestructuradocumento as id,
            indEstru.idsiq_factoresestructuradocumento,
            indEstru.indicador_id,
            indEstru.Orden,
            factorEstru.idsiq_factoresestructuradocumento,
            factorEstru.factor_id,
            ind.idsiq_indicador,
            ind.idCarrera,
            ind.idIndicadorGenerico,
            indGen.idsiq_indicadorGenerico,
            indGen.nombre
            FROM 
            siq_indicadoresestructuradocumento AS indEstru 
            INNER JOIN siq_factoresestructuradocumento AS factorEstru  ON indEstru.idsiq_factoresestructuradocumento=factorEstru.idsiq_factoresestructuradocumento 
            INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador
            INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico 
            WHERE indEstru.codigoestado=100
            AND factorEstru.idsiq_estructuradocumento="'.$id.'"
            AND factorEstru.codigoestado=100
            AND ind.codigoestado=100
            AND indGen.codigoestado=100
            GROUP BY factorEstru.factor_id';
        
        if($Indicador_Estru=&$db->Execute($SQL_Indicador)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar los Indicadores del Documento....<br>'.$SQL_Indicador;
            echo json_encode($a_vectt);
            exit;
        }
        ##############
        #echo '<br>SQL_Indicador->'.$SQL_Indicador.'<br>';
        ################
        
        $Indicaro_Ex = $Indicador_Estru->GetArraY();
        
        $SQL_indicador_new='SELECT
            ind.idsiq_indicador,
            ind.idCarrera,
            ind.idIndicadorGenerico,
            indGen.idsiq_indicadorGenerico,
            indGen.nombre,
            fac.idsiq_factor
            FROM siq_indicador AS ind 
            INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
            INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
            INNER JOIN siq_caracteristica AS car ON asp.idCaracteristica=car.idsiq_caracteristica
            INNER JOIN siq_factor as fac ON car.idFactor=fac.idsiq_factor
            WHERE ind.codigoestado=100
            AND indGen.codigoestado=100
            AND ind.idCarrera="'.$Programa_id.'"
            AND asp.codigoestado=100
            AND car.codigoestado=100
            AND fac.codigoestado=100 OR indGen.area=1
            GROUP BY fac.idsiq_factor';
        
        if($Indicador_New=&$db->Execute($SQL_indicador_new)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar los Indicadores nuevos para Documento....<br>'.$SQL_indicador_new;
            echo json_encode($a_vectt);
            exit;
        }
        				
        $Indicar_Nuevo  = $Indicador_New->GetArray();
                
        for($i=0;$i<count($Indicaro_Ex);$i++){#For 1
            for($j=0;$j<count($Indicar_Nuevo);$j++){#For 2
                if($Indicaro_Ex[$i]['factor_id']==$Indicar_Nuevo[$j]['idsiq_factor']){#If
                    $SQL_Insert_Factor='INSERT INTO siq_factoresestructuradocumento(idsiq_estructuradocumento,factor_id,Orden,userid,entrydate)VALUES("'.$id_Cabeza.'","'.$Indicaro_Ex[$i]['factor_id'].'","'.$i.'","'.$userid.'",NOW())';
                    
                    if($Insert_Factor=&$db->Execute($SQL_Insert_Factor)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error al Insertar la Estructura del Factor....<br>'.$SQL_Insert_Factor;
                        echo json_encode($a_vectt);
                        exit;
                    }
                    
                    $id_Factor=$db->Insert_ID();
											
                    $SQL_indicador_new2='SELECT
                        ind.idsiq_indicador,
                        ind.idCarrera,
                        ind.idIndicadorGenerico,
                        indGen.idsiq_indicadorGenerico,
                        indGen.nombre,
                        fac.idsiq_factor
                        FROM siq_indicador AS ind 
                        INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico
                        INNER JOIN siq_aspecto AS asp ON indGen.idAspecto=asp.idsiq_aspecto 
                        INNER JOIN siq_caracteristica AS car ON asp.idCaracteristica=car.idsiq_caracteristica
                        INNER JOIN siq_factor as fac ON car.idFactor=fac.idsiq_factor
                        WHERE ind.codigoestado=100
                        AND indGen.codigoestado=100
                        AND ind.idCarrera="'.$Programa_id.'"
                        AND asp.codigoestado=100
                        AND car.codigoestado=100
                        AND fac.codigoestado=100
                        AND indGen.idsiq_indicadorGenerico IN (SELECT  ind.idIndicadorGenerico FROM siq_indicadoresestructuradocumento AS indEstru INNER JOIN siq_indicador AS ind ON indEstru.indicador_id=ind.idsiq_indicador INNER JOIN siq_indicadorGenerico AS indGen ON ind.idIndicadorGenerico=indGen.idsiq_indicadorGenerico WHERE indEstru.codigoestado=100 AND indEstru.idsiq_factoresestructuradocumento="'.$Indicaro_Ex[$i]['idsiq_factoresestructuradocumento'].'" AND ind.codigoestado=100 AND indGen.codigoestado=100);';
                    
                    if($Indicador_New2=&$db->Execute($SQL_indicador_new2)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error al Buscar los Indicadores nuevos para Documento....<br>'.$SQL_indicador_new2;
                        echo json_encode($a_vectt);
                        exit;
                    }			
                    $Indicar_Nuevo2  = $Indicador_New2->GetArray();
                    
                    for($y=0;$y<count($Indicar_Nuevo2);$y++){#Fro 4
                        $SQL_Insert_Indicador='INSERT INTO siq_indicadoresestructuradocumento(idsiq_factoresestructuradocumento,indicador_id,Orden,userid,entrydate)VALUES("'.$id_Factor.'","'.$Indicar_Nuevo2[$y]['idsiq_indicador'].'","'.$y.'","'.$userid.'",NOW())';
                        
                        if($Insert_Indicador=&$db->Execute($SQL_Insert_Indicador)===false){
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'Error al Insertar la Estructura del Indicador....<br>'.$SQL_Insert_Indicador;
                            echo json_encode($a_vectt);
                            exit;
                        }
                    }#For4
                }#IF
            }#For 2
        }#For1
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['Nombre'] = $Select_Datos->fields['nombre_documento'].'_Duplicado';
        echo json_encode($a_vectt);
        exit;
        break;
    case 'DialogoDuplicar':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        
        $C_Estructura_documento->DuplicarDialogo($_GET['id']);	
        break;    
    case 'DuplicarEstructura':
        MainJson();
        global $userid,$db;
        
        $id    = $_GET['id'];
        
        $SQL='SELECT 
            idsiq_estructuradocumento as id,
            nombre_documento,
            nombre_entidad,
            tipo_documento,
            id_carrera
            FROM siq_estructuradocumento
            WHERE idsiq_estructuradocumento="'.$id.'" AND codigoestado=100';
        
        if($Select_Datos=&$db->Execute($SQL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar Datos ....'.$SQL_Datos;
            echo json_encode($a_vectt);
            exit;
        }
        
        $Datos_Cabeza = $Select_Datos->GetArray();
        
        ##########################################Insert para Cabesera en la Tabla siq_estructuradocumento #########################################################################
        $SQL_Insert_Cabeza='INSERT INTO siq_estructuradocumento(nombre_documento,nombre_entidad,tipo_documento,id_carrera,userid,entrydate)VALUES("'.$Datos_Cabeza[0]['nombre_documento'].'_Duplicado","'.$Datos_Cabeza[0]['nombre_entidad'].'","'.$Datos_Cabeza[0]['tipo_documento'].'","'.$Datos_Cabeza[0]['id_carrera'].'","'.$userid.'",NOW())';
        
        if($Insert_Cabeza=&$db->Execute($SQL_Insert_Cabeza)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Insertar la Estructura del Documento....<br>'.$SQL_Insert_Cabeza;
            echo json_encode($a_vectt);
            exit;
        }
        
        $id_Cabeza=$db->Insert_ID();
        
        $SQL_Factor='SELECT
            idsiq_factoresestructuradocumento as id,
            idsiq_estructuradocumento as Doc_id,
            factor_id,
            Orden
            FROM siq_factoresestructuradocumento
            WHERE idsiq_estructuradocumento="'.$id.'"
            AND codigoestado=100';
        
        if($Factor_Estruc=&$db->Execute($SQL_Factor)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error Buscar los Facotres del Documento....<br>'.$SQL_Factor;
            echo json_encode($a_vectt);
            exit;
        }
        
        $Factor = $Factor_Estruc->GetArray();
        
        for($i=0;$i<count($Factor);$i++){
            ##########################################Insert para Factores en la Tabla siq_factoresestructuradocumento####################################################################
            $SQL_Insert_Factor='INSERT INTO siq_factoresestructuradocumento(idsiq_estructuradocumento,factor_id,Orden,userid,entrydate)VALUES("'.$id_Cabeza.'","'.$Factor[$i]['factor_id'].'","'.$Factor[$i]['Orden'].'","'.$userid.'",NOW())';
            
            if($Insert_Factor=&$db->Execute($SQL_Insert_Factor)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error al Insertar la Estructura del Factor....<br>'.$SQL_Insert_Factor;
                echo json_encode($a_vectt);
                exit;
            }
            
            $id_Factor=$db->Insert_ID();
            
            $SQL_Indicador='SELECT
                idsiq_indicadoresestructuradocumento as id,
                idsiq_factoresestructuradocumento,
                indicador_id,
                Orden
                FROM siq_indicadoresestructuradocumento
                WHERE idsiq_factoresestructuradocumento="'.$Factor[$i]['id'].'"
                AND codigoestado=100';
            
            if($Indicador_Estru=&$db->Execute($SQL_Indicador)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error al Buscar los Indicadores del Documento....<br>'.$SQL_Indicador;
                echo json_encode($a_vectt);
                exit;
            }
            
            $Indicador  = $Indicador_Estru->GetArray();
            
            for($j=0;$j<count($Indicador);$j++){
                ##########################################Insert para Factores en la Tabla siq_indicadoresestructuradocumento#############################################################
                
                $SQL_Insert_Indicador='INSERT INTO siq_indicadoresestructuradocumento(idsiq_factoresestructuradocumento,indicador_id,Orden,userid,entrydate)VALUES("'.$id_Factor.'","'.$Indicador[$j]['indicador_id'].'","'.$Indicador[$j]['Orden'].'","'.$userid.'",NOW())';
                
                if($Insert_Indicador=&$db->Execute($SQL_Insert_Indicador)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error al Insertar la Estructura del Indicador....<br>'.$SQL_Insert_Indicador;
                    echo json_encode($a_vectt);
                    exit;
                }
            }
        }
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['Nombre'] = $Datos_Cabeza[0]['nombre_documento'].'_Duplicado';
        echo json_encode($a_vectt);
        exit;
        break;
    case 'BuscarNombre':
        MainJson();
        global $userid,$db;
        $id  =  str_replace('row_','',$_GET['id']);
        
        $SQL='SELECT
            idsiq_estructuradocumento as id,
            nombre_documento,
            tipo_documento
            FROM siq_estructuradocumento
            WHERE idsiq_estructuradocumento="'.$id.'" AND codigoestado=100';
        
        if($Select_Datos=&$db->Execute($SQL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip']		='Error al Buscar Datos ....'.$SQL_Datos;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['id'] = $Select_Datos->fields['id'];
        $a_vectt['Nombre'] = $Select_Datos->fields['nombre_documento'];
        $a_vectt['tipo'] = $Select_Datos->fields['tipo_documento'];
        echo json_encode($a_vectt);
        exit;
        break;
    case 'EliminarDocumento':
        MainJson();
        global $userid,$db;
        $id  =  str_replace('row_','',$_GET['id']);
        $SQL='UPDATE siq_estructuradocumento
            SET codigoestado=200,userid_estado="'.$userid.'" , changedate=NOW()
            WHERE  idsiq_estructuradocumento="'.$id.'" AND codigoestado=100';
        
        if($EliminarCabeza=&$db->Execute($SQL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Eliminar los Datos del Docuemnto ....'.$SQL;
            echo json_encode($a_vectt);
            exit;
        }
        $a_vectt['val'] = 'TRUE';
        echo json_encode($a_vectt);
        exit;
	break;
    case 'Update_Doc':
        MainJson();
        global $userid,$db;
        
        $id = $_GET['id'];
        $Nom_Documento = $_GET['Nom_Documento'];
        $Nom_entidad = $_GET['Nom_entidad'];
        $Tipo_doc = $_GET['Tipo_doc'];
        $Programa_id = $_GET['Programa_id'];
        $fechainicio = $_GET['fechainicio'];
        $fechafin = $_GET['fechafin'];
        
        $SQL='UPDATE siq_estructuradocumento
            SET userid_estado="'.$userid.'" , changedate=NOW(), nombre_documento="'.$Nom_Documento.'" , nombre_entidad="'.$Nom_entidad .'" , tipo_documento="'.$Tipo_doc.'" , id_carrera="'.$Programa_id.'",
                fechainicial="'.$fechainicio.'" , fechafinal="'.$fechafin.'" 
            WHERE  idsiq_estructuradocumento="'.$id.'" AND codigoestado=100';
        
        if($UpdateCabeza=&$db->Execute($SQL)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Modificar los Datos del Docuemnto ....'.$SQL;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val'] = 'TRUE';
        echo json_encode($a_vectt);
        exit;
        break;
    case 'ModificarPocisionInd':
        MainJson();
        global $userid,$db;
        
        $list = $_GET['list'];
        $id = $_GET['id'];

        $C_List = explode('::',$list);
        
        for($i=1;$i<count($C_List);$i++){
            $C_Factor  = explode('-',$C_List[$i]);
            
            for($j=1;$j<count($C_Factor);$j++){
                $C_Ind = explode(',',$C_Factor[$j]);
                
                for($k=1;$k<count($C_Ind);$k++){
                    $C_Datos = explode('_',$C_Ind[$k]);
                    $SQL='UPDATE  siq_indicadoresestructuradocumento
                        SET userid_estado="'.$userid.'",changedate=NOW(),Orden="'.$k.'",idsiq_factoresestructuradocumento="'.$C_Factor[0].'"
                        WHERE idsiq_indicadoresestructuradocumento="'.$C_Datos[1].'" AND codigoestado=100 AND indicador_id="'.$C_Datos[0].'"  ';
                    
                    if($ModificarOrdenInd=&$db->Execute($SQL)===false){
                        $a_vectt['val'] = 'FALSE';
                        $a_vectt['descrip'] = 'Error al Ordenar los Indicadores ....'.$SQL;
                        echo json_encode($a_vectt);
                        exit;
                    }
                }
            }
        }
        
        $SQL_Datos='SELECT				
            tipo_documento,
            id_carrera
            FROM siq_estructuradocumento
            WHERE idsiq_estructuradocumento="'.$id.'"
            AND codigoestado=100';
        
        if($Select_Datos=&$db->Execute($SQL_Datos)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar Datos ....'.$SQL_Datos;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['tipo'] = $Select_Datos->fields['tipo_documento'];
        $a_vectt['programa'] = $Select_Datos->fields['id_carrera'];
        echo json_encode($a_vectt);
        exit;
        break;
    case 'New_indicador':
        MainJson();
        global $userid,$db;
        $id = $_GET['id'];
        $list = $_GET['list'];
        $indicador_id = $_GET['indicador_id'];
        $Factor_id = $_GET['Factor_id'];
        
        $C_indicador   = explode(',',$list);
        
        for($i=1;$i<count($C_indicador);$i++){
            if($indicador_id==$C_indicador[$i]){
                $j = $i;
                $SQL_Insert_Indicador='INSERT INTO siq_indicadoresestructuradocumento(idsiq_factoresestructuradocumento,indicador_id,Orden,userid,entrydate)VALUES("'.$Factor_id.'","'.$C_indicador[$i].'","'.$j.'","'.$userid.'",NOW())';
                
                if($inser_NewIndicador=&$db->Execute($SQL_Insert_Indicador)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error Insertar el Indicador nuevo  los Datos ....'.$SQL_Insert_Indicador;
                    echo json_encode($a_vectt);
                    exit;
                }
                
                $id_Cabeza=$db->Insert_ID();
            }else{
                $C_Mod = explode('_',$C_indicador[$i]);
                
                $SQL='UPDATE  siq_indicadoresestructuradocumento
                    SET userid_estado="'.$userid.'",changedate=NOW(),Orden="'.$i.'",idsiq_factoresestructuradocumento="'.$Factor_id.'"
                    WHERE idsiq_indicadoresestructuradocumento="'.$C_Mod[1].'" AND codigoestado=100 AND indicador_id="'.$C_Mod[0].'"  ';
                
                if($ModificarOrdenInd=&$db->Execute($SQL)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error al Ordenar los Indicadores ....'.$SQL;
                    echo json_encode($a_vectt);
                    exit;
                }
            }
        }
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['Ultimo_id'] = $id_Cabeza;
        echo json_encode($a_vectt);
        exit;
        break;
    case 'ModificarPocision':
        MainJson();
        global $userid,$db;
        $id = $_GET['id']; 
        $list = $_GET['list'];
        
        $C_Dato = explode(',',$list);
        
        for($i=0;$i<count($C_Dato);$i++){
            $t = $i+1;
            $SQL='UPDATE  siq_factoresestructuradocumento
                SET     userid_estado="'.$userid.'",changedate=NOW(), Orden="'.$t.'"
                WHERE   codigoestado=100 AND idsiq_estructuradocumento="'.$id.'" AND factor_id="'.$C_Dato[$i].'"';
            
            if($ModificarFactores=&$db->Execute($SQL)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error Modificar los Datos ....'.$SQL;
                echo json_encode($a_vectt);
                exit;
            }
        }
        
        $a_vectt['val'] = 'TRUE';
        
        echo json_encode($a_vectt);
        exit;
        break;
    case 'New_Factor':
        MainJson();
        global $userid,$db;
        
        $id = $_GET['id'];
        $lis = $_GET['list'];
        $factor_id = $_GET['factor_id'];
        
        $C_Dato = explode(',',$list);
        
        for($i=0;$i<count($C_Dato);$i++){
            if($factor_id==$C_Dato[$i]){
                $j = $i+1;
                $SQL='INSERT INTO siq_factoresestructuradocumento(idsiq_estructuradocumento,factor_id,Orden,userid,entrydate)VALUES("'.$id.'","'.$C_Dato[$i].'","'.$j.'","'.$userid.'",NOW())';
                
                if($ModificarFactores=&$db->Execute($SQL)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error Modificar los Datos ....'.$SQL;
                    echo json_encode($a_vectt);
                    exit;
                }
            }
        }
        
        $a_vectt['val'] = 'TRUE';
        echo json_encode($a_vectt);
        exit;
        break;
    case 'Indicador':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        $C_Estructura_documento->IndicadoresEdit($_GET['i'],$_GET['id'],$_GET['idFactor']);
        break;
    case 'Eliminar_Indicador':
        MainJson();
        global $userid,$db;
        
        $id_indicador = $_GET['id_indicador'];
        $id = $_GET['id'];
        
        $SQL_UpdateIndicadorNew='UPDATE siq_indicadoresestructuradocumento
            SET    codigoestado=200, userid_estado="'.$userid.'",changedate=NOW()
            WHERE  idsiq_indicadoresestructuradocumento="'.$id.'" AND codigoestado=100 AND indicador_id="'.$id_indicador.'"';
        
        if($Elimiar_Indicador=&$db->Execute($SQL_UpdateIndicadorNew)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Elimanr el Indicador del Documento ....'.$SQL_UpdateIndicadorNew;
            echo json_encode($a_vectt);
            exit;
        }
        $a_vectt['val'] = 'TRUE';
        echo json_encode($a_vectt);
        exit;
        break;
    case'Factor':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        $C_Estructura_documento->FactorEdit($_GET['id']);
        break;
    case 'Eliminar_Factor':
        MainJson();
        global $userid,$db;
        
        $id_factor = $_GET['id_factor'];
	$id_doc = $_GET['id_doc'];
        
        $SQL_Select='SELECT idsiq_factoresestructuradocumento  as id
            FROM siq_factoresestructuradocumento  
            WHERE factor_id="'.$id_factor.'"
            AND codigoestado=100
            AND idsiq_estructuradocumento="'.$id_doc.'"';
        
        if($Select_id=&$db->Execute($SQL_Select)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Buscar el Id ....'.$SQL_Select;
            echo json_encode($a_vectt);
            exit;
        }
        
        $SQL_UpdateFactor='UPDATE siq_factoresestructuradocumento
            SET codigoestado=200, userid_estado="'.$userid.'",changedate=NOW()
            WHERE factor_id="'.$id_factor.'" AND idsiq_estructuradocumento="'.$id_doc.'" AND idsiq_factoresestructuradocumento="'.$Select_id->fields['id'].'"';
        
        if($EliminarFactor=&$db->Execute($SQL_UpdateFactor)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Elimnar el Factor del Documento ....'.$SQL_UpdateFactor;
            echo json_encode($a_vectt);
            exit;
        }
        
        $SQL_UpdateIndicador='UPDATE siq_indicadoresestructuradocumento
            SET    codigoestado=200, userid_estado="'.$userid.'",changedate=NOW()
            WHERE  idsiq_factoresestructuradocumento="'.$Select_id->fields['id'].'" AND codigoestado=100';
        
        if($ElimnarIndicadorFactor=&$db->Execute($SQL_UpdateIndicador)===false){
            $a_vectt['val']			='FALSE';
            $a_vectt['descrip']		='Error al Elimnar el Indicador Relacionado al Factor del Documento ....'.$SQL_UpdateIndicador;
            echo json_encode($a_vectt);
            exit;
        }
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['id'] = $id_doc;
        echo json_encode($a_vectt);
        exit;
        break;
    case 'Buscar_Indicador':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        
        $C_Estructura_documento->BuscarIndicadores($_GET['id'],$_GET['tipo'],$_GET['programa']);
        break;
    case 'Buscar_Factor':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        $C_Estructura_documento->Buscar_Factores($_GET['id'],$_GET['tipo'],$_GET['programa']);
        break;
    case 'Indicadores':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        
        $C_Estructura_documento->Indicadores($_GET['Estructura_id'],$_GET['tipo'],$_GET['Programa']);
        break;
    case 'Factores':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        
        $C_Estructura_documento->Factores($_GET['Estructura_id'],$_GET['tipo'],$_GET['Programa']);
        break;
    case 'Editar':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        $id  =  str_replace('row_','',$_GET['id']);
        $C_Estructura_documento->Editar($id);
        break;
    case 'Save':
        MainJson();
        global $userid,$db;
        
        $Nom_Documento = $_GET['Nom_Documento'];
        $Nom_entidad = $_GET['Nom_entidad'];
        $Tipo_doc = $_GET['Tipo_doc'];
        $Programa_id = $_GET['Programa_id'];
        $CadenaPadreFin = $_GET['CadenaPadreFin'];
        $CadenaHijoFin = $_GET['CadenaHijoFin'];
        $fechainicio = $_GET['fechainicio'];
        $fechafin = $_GET['fechafin'];
        $Estructura_id = $_GET['Estructura_id'];
        
        $where = "";
        $SQL_Insert_Cabeza='INSERT INTO ';
        if(!empty($Estructura_id)){
            $SQL_Insert_Cabeza='UPDATE ';
            $where = " WHERE idsiq_estructuradocumento = ".$Estructura_id;
        }

        $SQL_Insert_Cabeza .= ' siq_estructuradocumento SET '
                .' nombre_documento = "'.$Nom_Documento.'",
                nombre_entidad = "'.$Nom_entidad.'",
                tipo_documento = "'.$Tipo_doc.'",
                id_carrera = "'.$Programa_id.'",
                fechainicial = "'.$fechainicio.'",
                fechafinal = "'.$fechafin.'",
                userid = "'.$userid.'",
                entrydate = NOW()'
                .$where;
        //d($SQL_Insert_Cabeza);
        if($Insert_Cabeza=&$db->Execute($SQL_Insert_Cabeza)===false){
            $a_vectt['val'] = 'FALSE';
            $a_vectt['descrip'] = 'Error al Insertar la Estructura del Documento....<br>';
            echo json_encode($a_vectt);
            exit;
        }
        
        if(!empty($Estructura_id)){
            $id_Cabeza = $Estructura_id;
        }else{
            $id_Cabeza = $db->Insert_ID();
        }
        
        $C_Factor    = explode('-',$CadenaPadreFin);
        
        $F_indicadores = explode('-',$CadenaHijoFin);
        //d($F_indicadores);
        for($j=1;$j<count($F_indicadores);$j++){
            $C_indicadores = explode('|',$F_indicadores[$j]);
            
            $SQL_Insert_Factor='INSERT INTO  ';
            
            $query = "SELECT idsiq_factoresestructuradocumento "
                    . " FROM siq_factoresestructuradocumento "
                    . " WHERE idsiq_estructuradocumento = ".$id_Cabeza
                    . " AND factor_id = ".$C_indicadores[0]
                    . " AND codigoestado = 100";
            //d($query);
            $datosExisteFactor = $db->Execute($query);
            
            $SQL_Insert_Factor = ' INSERT INTO ';
            $where = ' , userid = "'.$userid.'" , entrydate = NOW() ';
            
            if(!empty($datosExisteFactor)){
                $dExisteFactor = $datosExisteFactor->FetchRow();
                if(!empty($dExisteFactor) && !empty($dExisteFactor["idsiq_factoresestructuradocumento"])){
                    $idsiq_factoresestructuradocumento = $dExisteFactor["idsiq_factoresestructuradocumento"];
                    $SQL_Insert_Factor = ' UPDATE ';
                    $where = " , userid_estado = '".$userid."'  , changedate = NOW()  WHERE  idsiq_factoresestructuradocumento = ".$idsiq_factoresestructuradocumento;
                }
            }
            
            $SQL_Insert_Factor .= ' siq_factoresestructuradocumento SET 
                    idsiq_estructuradocumento = "'.$id_Cabeza.'",
                    factor_id = "'.$C_indicadores[0].'",
                    Orden = "'.$j.'" '
                    .$where;
            //d($SQL_Insert_Factor);
            if($Insert_Factor=&$db->Execute($SQL_Insert_Factor)===false){
                $a_vectt['val'] = 'FALSE';
                $a_vectt['descrip'] = 'Error al Insertar la Estructura del Factor....<br>'.$SQL_Insert_Factor;
                echo json_encode($a_vectt);
                exit;
            }
            
            $id_Factor = $db->Insert_ID();
            if(empty($id_Factor)){
                $id_Factor = $idsiq_factoresestructuradocumento;
            }
            
            $i_Cadena = explode(':',$C_indicadores[1]);
            
            for($k=1;$k<count($i_Cadena);$k++){
                
                $query = "SELECT idsiq_indicador, idsiq_estructuradocumento, "
                        . " ubicacion,  es_objeto_analisis, "
                        . " tiene_anexo, inexistente, "
                        . " idIndicadorGenerico, discriminacion, "
                        . " idCarrera, usuario_creacion"
                        . " FROM siq_indicador "
                        . " WHERE ";
                //d($query. "idsiq_indicador = ".$db->qstr($i_Cadena[$k]));
                
                $indicadorOriginal = $db->Execute($query. "idsiq_indicador = ".$db->qstr($i_Cadena[$k]));
                $dIndicadorOriginal = $indicadorOriginal->FetchRow();
                $idIndDoc = $dIndicadorOriginal['idsiq_indicador'];
                    
                $query .= " idIndicadorGenerico = ".$db->qstr($dIndicadorOriginal['idIndicadorGenerico']);
                //d($query);
                $indicadorDoc = $db->Execute($query);                
                
                $perteneceIndicadorDocumento = false;
                $indicadorDuplicar = null;
                
                if(!empty($indicadorDoc)){
                    $dIndicadorDoc = $indicadorDoc->GetArray();
                    if(!empty($dIndicadorDoc)){
                        $indicadorDuplicar = $dIndicadorDoc[0];
                        foreach($dIndicadorDoc as $indDoc){
                            if($indDoc['idsiq_estructuradocumento']==$id_Cabeza){
                                $perteneceIndicadorDocumento = true;
                                $idIndDoc = $indDoc['idsiq_indicador'];
                            }
                        }
                    }
                }
                ///d($perteneceIndicadorDocumento);
                if(!$perteneceIndicadorDocumento){
                    $idusuario = $_SESSION['idusuario'];
                    $query = "INSERT INTO siq_indicador SET "
                            . " ubicacion = ".$db->qstr($indicadorDuplicar['ubicacion']).", "
                            . " es_objeto_analisis = ".$db->qstr($indicadorDuplicar['es_objeto_analisis']).","
                            . " tiene_anexo = ".$db->qstr($indicadorDuplicar['tiene_anexo']).","
                            . " inexistente = ".$db->qstr($indicadorDuplicar['inexistente']).","
                            . " idIndicadorGenerico = ".$db->qstr($indicadorDuplicar['idIndicadorGenerico']).","
                            . " discriminacion = ".$db->qstr($indicadorDuplicar['discriminacion']).","
                            . " idCarrera = ".$db->qstr($indicadorDuplicar['idCarrera']).","
                            . " fecha_creacion = NOW(),"
                            . " usuario_creacion = ".$db->qstr($idusuario).","
                            . " codigoestado = 100,"
                            . " idEstado = 1,"
                            . " idsiq_estructuradocumento = ".$db->qstr($id_Cabeza);
                
                    $db->Execute($query);
                    $idIndDoc= $db->Insert_ID(); 
                }
                
                $query = "SELECT idsiq_indicadoresestructuradocumento"
                        . " FROM siq_indicadoresestructuradocumento "
                        . " WHERE idsiq_factoresestructuradocumento = ".$id_Factor
                        . " AND indicador_id = ".$idIndDoc
                        . " AND codigoestado = 100 ";
                //d($query);
                $datosExisteIndicador = $db->Execute($query);

                $SQL_Insert_Factor = ' INSERT INTO ';
                $where = ' , userid = "'.$userid.'" , entrydate = NOW() ';

                if(!empty($datosExisteFactor)){
                    $dExisteFactor = $datosExisteFactor->FetchRow();
                    if(!empty($dExisteFactor) && !empty($dExisteFactor["idsiq_factoresestructuradocumento"])){
                        $idsiq_factoresestructuradocumento = $dExisteFactor["idsiq_factoresestructuradocumento"];
                        $SQL_Insert_Factor = ' UPDATE ';
                        $where = " , userid_estado = '".$userid."'  , changedate = NOW()  WHERE  idsiq_factoresestructuradocumento = ".$idsiq_factoresestructuradocumento;
                    }
                }

                $SQL_Insert_Factor .= ' siq_factoresestructuradocumento SET 
                        idsiq_estructuradocumento = "'.$id_Cabeza.'",
                        factor_id = "'.$C_indicadores[0].'",
                        Orden = "'.$j.'" '
                        .$where;
                //ddd($SQL_Insert_Indicador);
                if($Insert_Indicador=&$db->Execute($SQL_Insert_Factor)===false){
                    $a_vectt['val'] = 'FALSE';
                    $a_vectt['descrip'] = 'Error al Insertar la Estructura del Factor....<br>'.$SQL_Insert_Factor;
                    echo json_encode($a_vectt);
                    exit;
                }

                $id_Factor = $db->Insert_ID();
                if(empty($id_Factor)){
                    $id_Factor = $idsiq_factoresestructuradocumento;
                }

                $i_Cadena = explode(':',$C_indicadores[1]);
                //ddd($i_Cadena);
                for($k=1;$k<count($i_Cadena);$k++){
                    if(!empty($i_Cadena[$k])){
                        $query = "SELECT idsiq_indicador, idsiq_estructuradocumento, "
                                . " ubicacion,  es_objeto_analisis, "
                                . " tiene_anexo, inexistente, "
                                . " idIndicadorGenerico, discriminacion, "
                                . " idCarrera, usuario_creacion"
                                . " FROM siq_indicador "
                                . " WHERE ";
                        //d($query. "idsiq_indicador = ".$db->qstr($i_Cadena[$k]));

                        $indicadorOriginal = $db->Execute($query. "idsiq_indicador = ".$db->qstr($i_Cadena[$k]));
                        $dIndicadorOriginal = $indicadorOriginal->FetchRow();
                        $idIndDoc = $dIndicadorOriginal['idsiq_indicador'];

                        $query .= " idIndicadorGenerico = ".$db->qstr($dIndicadorOriginal['idIndicadorGenerico']);
                        //d($query);
                        $indicadorDoc = $db->Execute($query);                

                        $perteneceIndicadorDocumento = false;
                        $indicadorDuplicar = null;

                        if(!empty($indicadorDoc)){
                            $dIndicadorDoc = $indicadorDoc->GetArray();
                            if(!empty($dIndicadorDoc)){
                                $indicadorDuplicar = $dIndicadorDoc[0];
                                foreach($dIndicadorDoc as $indDoc){
                                    if($indDoc['idsiq_estructuradocumento']==$id_Cabeza){
                                        $perteneceIndicadorDocumento = true;
                                        $idIndDoc = $indDoc['idsiq_indicador'];
                                    }
                                }
                            }
                        }
                        //d($perteneceIndicadorDocumento);
                        if(!$perteneceIndicadorDocumento){
                            $idusuario = $_SESSION['idusuario'];
                            $query = "INSERT INTO siq_indicador SET "
                                    . " ubicacion = ".$db->qstr($indicadorDuplicar['ubicacion']).", "
                                    . " es_objeto_analisis = ".$db->qstr($indicadorDuplicar['es_objeto_analisis']).","
                                    . " tiene_anexo = ".$db->qstr($indicadorDuplicar['tiene_anexo']).","
                                    . " inexistente = ".$db->qstr($indicadorDuplicar['inexistente']).","
                                    . " idIndicadorGenerico = ".$db->qstr($indicadorDuplicar['idIndicadorGenerico']).","
                                    . " discriminacion = ".$db->qstr($indicadorDuplicar['discriminacion']).","
                                    . " idCarrera = ".$db->qstr($indicadorDuplicar['idCarrera']).","
                                    . " fecha_creacion = NOW(),"
                                    . " usuario_creacion = ".$db->qstr($idusuario).","
                                    . " codigoestado = 100,"
                                    . " idEstado = 1,"
                                    . " fecha_proximo_vencimiento = ".$db->qstr($fechafin).","
                                    . " idsiq_estructuradocumento = ".$db->qstr($id_Cabeza);
                            //d($query);
                            $db->Execute($query);
                            $idIndDoc= $db->Insert_ID(); 
                        }

                        $query = "SELECT idsiq_indicadoresestructuradocumento"
                                . " FROM siq_indicadoresestructuradocumento "
                                . " WHERE idsiq_factoresestructuradocumento = ".$id_Factor
                                . " AND indicador_id = ".$idIndDoc
                                . " AND codigoestado = 100 ";
                        //d($query);
                        $datosExisteIndicador = $db->Execute($query);

                        $SQL_Insert_Indicador = ' INSERT INTO ';
                        $where = ' , userid = "'.$userid.'" , entrydate = NOW() ';

                        if(!empty($datosExisteIndicador)){
                            $dExisteIndicador = $datosExisteIndicador->FetchRow();
                            if(!empty($dExisteIndicador) && !empty($dExisteIndicador["idsiq_indicadoresestructuradocumento"])){
                                $idsiq_indicadoresestructuradocumento = $dExisteIndicador["idsiq_indicadoresestructuradocumento"];
                                $SQL_Insert_Indicador = ' UPDATE ';
                                $where = " , userid_estado = '".$userid."'  , changedate = NOW() WHERE  idsiq_indicadoresestructuradocumento = ".$idsiq_indicadoresestructuradocumento;
                            }
                        }
                        $SQL_Insert_Indicador .= ' siq_indicadoresestructuradocumento SET
                                idsiq_factoresestructuradocumento = "'.$id_Factor.'",
                                indicador_id = "'.$idIndDoc.'",
                                Orden = "'.$k.'" '
                                .$where;
                        //d($SQL_Insert_Indicador);
                        if($Insert_Indicador=&$db->Execute($SQL_Insert_Indicador)===false){
                            $a_vectt['val'] = 'FALSE';
                            $a_vectt['descrip'] = 'Error al Insertar la Estructura del Indicador....<br>'.$SQL_Insert_Indicador;
                            echo json_encode($a_vectt);
                            exit;
                        }
                        
                    }

                }
                
            }
        }
        
        $a_vectt['val'] = 'TRUE';
        $a_vectt['descrip'] = 'Se Ha Almacenado La Estructura Correctamente...';
        echo json_encode($a_vectt);
        exit;
        break;
    case 'BuscarFactoresPrograma':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        
        $Tipo_doc  = $_GET['Tipo_doc'];
        $Programa_id  = $_GET['Programa_id'];
        $Estructura_id  = $_GET['Estructura_id'];
        
        $C_Estructura_documento->BuscarFactoresPrograma($Tipo_doc,$Programa_id, $Estructura_id);
        break;    
    case 'BuscarFactores':
        define(AJAX,'TRUE');
        MainGeneral();
        JsGenral();
        global $C_Estructura_documento,$userid,$db;
        
        $Tipo_doc  = $_GET['Tipo_doc'];
        $Estructura_id  = $_GET['Estructura_id'];
        
        $C_Estructura_documento->BuscarFactoresInstitucionales($Tipo_doc, $Estructura_id);
        break;
    case'Gestion':
        define(AJAX,'FALSE');
        include('../../Menu.class.php');
        
        MainGeneral();
        JsGenral();

        global $C_Estructura_documento,$userid,$db;
        
        $URL = array();
        $URL[0] = 'Estructura_documento.html.php?actionID=Gestion';
        $URL[1] = 'Estructura_documento.html.php';
        $nombre = array();
        $nombre[0]= 'Gesti&oacute;n de Estructura de Documentos...';
        $nombre[1]= 'Estructura Documento.';
        $Active = array();
        $Active[0] = 1;
        $Active[1] = 0;

        Menu_Global::writeMenu($URL,$nombre,$Active);

        $C_Estructura_documento->Gestion();
        break;
    default:
        include('../../Menu.class.php');
        define(AJAX,'FALSE');
        MainGeneral();
        JsGenral();

        $URL = array();
        $URL[0] = 'Estructura_documento.html.php?actionID=Gestion';
        $URL[1] = 'Estructura_documento.html.php';
        $nombre = array();
        $nombre[0]= 'Gesti&oacute;n de Estructura de Documentos...';
        $nombre[1]= 'Estructura Documento.';
        $Active = array();
        $Active[0] = 0;
        $Active[1] = 1;
        Menu_Global::writeMenu($URL,$nombre,$Active);

        global $C_Estructura_documento,$userid,$db;
        $C_Estructura_documento->Principal();
        break;
}

function MainGeneral(){
    global $C_Estructura_documento,$userid,$db;
    $proyectoMonitoreo = "Monitoreo";
    include("../../templates/template.php");
    include('Estructura_documento.class.php');  $C_Estructura_documento = new Estructura_documento();
    
    if(AJAX=='FALSE'){
        $db=writeHeader("Estrutura Doscuento",true);
    }else{
        $db=writeHeaderBD();
    }
    
    $SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    
    if($Usario_id=&$db->Execute($SQL_User)===false){
        echo 'Error en el SQL Userid...<br>';
        die;
    }
    
    $userid=$Usario_id->fields['id'];
}

function MainJson(){
    global $userid,$db;
    include("../../templates/template.php");
    $db=writeHeaderBD();
    $SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
    if($Usario_id=&$db->Execute($SQL_User)===false){
        echo 'Error en el SQL Userid...<br>';
        die;
    }
    $userid=$Usario_id->fields['id'];
}

function JsGenral(){
    ?>
    <style>
        #sortable1,sortable2,sortable_Factores, sortable_F, sortable_Ind { list-style-type: none; margin: 0; padding: 0; width: 60%; }
        #sortable1 li, sortable2 li , sortable_Factores, li sortable_F li, sortable_Ind li{ margin: 0 3px 3px 3px; padding: 0.4em; padding-left: 1.5em; font-size: 1.4em; height: 18px; }
        #sortable1 li span,sortable2 li span,sortable_Factores li span,sortable_F li span,sortable_Ind li span{ position: absolute; margin-left: -1.3em; }
        .first{
            padding: 0px 14px 0px;
            padding: 0px 14px 0px;
            font-size: 20px;
            cursor: pointer;
            text-align: center;
            display:inline-block;
            /*border:1px solid #D4D4D4; */ 
            -moz-border-radius: 10px;
            -webkit-border-radius: 10px;
            -khtml-border-radius: 10px;
            border-radius: 10px;
            -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.2);
            -moz-box-shadow: 0 1px 2px rgba(0,0,0,.2);
            box-shadow: 0 1px 2px rgba(0,0,0,.2);
            background: #5D7D0E;
            text-shadow: 0 1px 1px rgba(0,0,0,.3);
            background:-moz-linear-gradient(center top , #7DB72F, #4E7D0E) repeat scroll 0 0 transparent; 
            background: -webkit-gradient(linear, left top, left bottom, from(#7DB72F), to(#4E7D0E));
            /*filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#7DB72F', endColorstr='#4E7D0E');*/
            border: 1px solid #538312;
            color: #E8F0DE;
            margin-left: 10px;
                }
        .submit {
            padding: 9px 17px;
            font-family: Helvetica, Arial, sans-serif;
            font-weight: bold;
            line-height: 1;
            color: #444;
            border: none;
            text-shadow: 0 1px 1px rgba(255, 255, 255, 0.85);
            background-image: -webkit-gradient( linear, 0% 0%, 0% 100%, from(#fff), to(#bbb));
            background-image: -moz-linear-gradient(0% 100% 90deg, #BBBBBB, #FFFFFF);
            background-color: #fff;
            border: 1px solid #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5)
        }	
    </style>
    
    <script type="text/javascript" language="javascript" src="../../js/jquery.fastLiveFilter.js"></script> 
    <script>
        $(document).ready(function() {
            $("#fechainicio").datepicker({
                changeMonth: true,
                changeYear: true,
                showOn: "button",
                buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
                buttonImageOnly: true,
                dateFormat: "yy-mm-dd"
            });
            
            $("#fechafin").datepicker({ 
                changeMonth: true,
                changeYear: true,
                showOn: "button",
                buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
                buttonImageOnly: true,
                dateFormat: "yy-mm-dd"
            });
        });
        
        $(function(){
            var fastLiveFilterNumDisplayed = $('#fastLiveFilter .connectedSortable');
            $("#fastLiveFilter .filter_input").fastLiveFilter("#fastLiveFilter .connectedSortable");
        });
        
        $(function(){
            $( "#sortable1" ).sortable().disableSelection();
            $( "#sortable_Factores" ).sortable({connectWith: ".connectedSortable"}).disableSelection();
            $( "#sortable_F" ).sortable({connectWith: ".connectedSortable"}).disableSelection();
            $( "#sortable_Ind" ).sortable({connectWith: ".connectedSortable"}).disableSelection();
        });
        
        var oTable;
        var aSelected = [];
       
        $(document).ready(function() {
            var sql;
            
            sql='SELECT Estru.idsiq_estructuradocumento,Estru.nombre_documento, Estru.nombre_entidad , dis.nombre, Estru.id_carrera, Estru.tipo_documento,car.nombrecarrera, Estru.fechainicial,Estru.fechafinal, date(Estru.entrydate) AS fecha';
            sql+=' FROM siq_estructuradocumento AS Estru INNER JOIN siq_discriminacionIndicador AS dis ON Estru.tipo_documento=dis.idsiq_discriminacionIndicador  INNER JOIN carrera AS car ON (Estru.id_carrera=car.codigocarrera OR Estru.id_carrera=0)  AND Estru.codigoestado=100 AND dis.codigoestado=100 ';
            
            oTable = $('#example').dataTable({
                "bJQueryUI": true,
                "sPaginationType": "full_numbers",
                "bProcessing": true,
                "bServerSide": true,                
                "sAjaxSource": "../../server_processing.php?table=siq_estructuradocumento&sql="+sql+"&wh=Estru.codigoestado&tableNickname=Estru&group=Estru.idsiq_estructuradocumento&join=true",
                "aoColumns": [
                    { "bVisible": true, "aTargets": [ 0 ] },
                    { "bVisible": true, "aTargets": [ 1 ] },
                    { "fnRender": function ( oObj ) {
                            if(oObj.aData[4]==1){
                                return oObj.aData[2];
                            }else if(oObj.aData[4]==3){
                                return oObj.aData[2]+' :: '+oObj.aData[5];
                            }
                        },
                        "aTargets": [ 2 ]
                    },
                    { "bVisible": false, "aTargets": [ 3 ] },
                    { "bVisible": false, "aTargets": [ 4 ] },
                    { "bVisible": false, "aTargets": [ 5 ] },
                    { "sClass": "column_fecha","bVisible": true, "aTargets": [ 6 ] },
                    { "sClass": "column_fecha","bVisible": true, "aTargets": [ 7 ] },
                    { "sClass": "column_fecha","bVisible": true, "aTargets": [ 8 ] },
                ]
            });
            /* Click event handler
			
            /* Click event handler */
           
            $('#example tbody tr').live('click', function () {
                var id = this.id;
		
                var index = jQuery.inArray(id, aSelected);
                if ( $(this).hasClass('row_selected') && index === -1  ) {
                    aSelected1.splice(index, 1);
                    $("#ToolTables_example_1").addClass('DTTT_disabled');
                    $("#ToolTables_example_2").addClass('DTTT_disabled');
                    $("#ToolTables_example_3").addClass('DTTT_disabled');
                }else{
                    aSelected.push(id); 
		
                    if (aSelected.length>1) aSelected.shift();
                    
                    oTable.$('tr.row_selected').removeClass('row_selected');
                    $(this).addClass('row_selected');
                    $("#ToolTables_example_1").removeClass('DTTT_disabled');                    
                    $("#ToolTables_example_2").removeClass('DTTT_disabled');
                    $("#ToolTables_example_3").removeClass('DTTT_disabled');
                }
            });
            
            $('#ToolTables_example_1').click( function () {
                if(!$('#ToolTables_example_1').hasClass('DTTT_disabled')){
                    Editar_Estructura();
                }
            });
            
            $('#ToolTables_example_2').click( function () {
                if(!$('#ToolTables_example_2').hasClass('DTTT_disabled')){
                    Eliminar_Estructura();
                }
            });
            
            $('#ToolTables_example_3').click( function () {
                if(!$('#ToolTables_example_3').hasClass('DTTT_disabled')){
                    Duplicar_Estructura();
                }
            });
        });
        
        function BuscarFactores(){
            var Estructura_id = $('#Estructura_id').val();
            var Nom_Documento = $('#Nom_Documento').val();
            var Nom_entidad     = $('#Nom_entidad').val();
            var Tipo_doc        = $('#Tipo_doc').val();
            var Programa_id     = $('#Programa_id').val();
            
            if(!$.trim(Nom_Documento)){
                alert('Ingrese El Nombre del Documento...!');
                return false;
            }
            
            if(!$.trim(Nom_entidad)){
                alert('Ingrese El Nombre de la Entidad a Presentar...!');
                return false;
            }
            
            if(Tipo_doc=='-1' || Tipo_doc==-1){
                alert('Elige un Tipo De Documento...!');
                return false;
            }
            
            if(Tipo_doc=='3' || Tipo_doc==3){
                if(Programa_id=='-1' || Programa_id==-1){
                    alert('Elige un Programa...!');
                    return false;
                }
            }
            
            if(Tipo_doc=='3' || Tipo_doc==3){
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    data:({actionID: 'BuscarFactoresPrograma',Tipo_doc:Tipo_doc,Programa_id:Programa_id}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#DivCargar').html(data);
                    }
                });
            }else{
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    data:({
                        actionID: 'BuscarFactores',
                        Tipo_doc:Tipo_doc,
                        Estructura_id:Estructura_id
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#DivCargar').html(data);
                    }
                });
            }
        }
        
        function Add(x,id){
            if($('#Indi_ver_'+x).is(':checked')){
                $('#Cadena_padre').val($('#Cadena_padre').val()+'-'+id);
            }else{
                var xx = '-'+id;
                var Cadena = $('#Cadena_padre').val();
                var Resultado = Cadena.replace(xx,'');
                $('#Cadena_padre').val(Resultado);
            }
        }
        
        function Add_hijo(x,id,i){
            var Factor_id = $('#Factor_id_'+i).val();
            
            if(!$.trim($('#Cadena_hijo_'+i).val())){
                $('#Cadena_hijo_'+i).val($('#Cadena_hijo_'+i).val()+Factor_id+'-');
            }
            
            if($('#item_'+i+'_'+x).is(':checked')){
                $('#Cadena_hijo_'+i).val($('#Cadena_hijo_'+i).val()+':'+id);
            }else{
                var xx = ':'+id;
                var Cadena = $('#Cadena_hijo_'+i).val();
                var Resultado = Cadena.replace(xx,'');
                $('#Cadena_hijo_'+i).val(Resultado);
            }
        }
        
        function Save(){
            var Estructura_id  = $('#Estructura_id').val(); 
            var index_padre  = $('#index_Padre').val(); 
            var list = $("#sortable1").sortable('toArray');
            $('#CadenaListaPadre').val(list);
            var CadenaOrdenPadre = $('#CadenaListaPadre').val();
            var Cadena_SelecionPadre = $('#Cadena_padre').val();
            var C_OrdenPadre = CadenaOrdenPadre.split(',');
            var N_ordenP = C_OrdenPadre.length;
            var C_SelecionPadre = Cadena_SelecionPadre.split('-');
            var N_SelecionP = C_SelecionPadre.length;
            for(i=0;i<N_ordenP;i++){
                for(j=1;j<N_SelecionP;j++){
                    if(C_OrdenPadre[i]==C_SelecionPadre[j]){
                        $('#CadenaPadreFin').val($('#CadenaPadreFin').val()+'-'+C_SelecionPadre[j]);
                    }
                }
            }
            
            var Cadena_final = $('#CadenaPadreFin').val().split('-');
            var Num_final = Cadena_final.length;
            var index = $('#index_Padre').val();
            for(t=1;t<Num_final;t++){
                for(Q=0;Q<index;Q++){
                    var factor = $('#Factor_id_'+Q).val();
                    if(Cadena_final[t]==factor){
                        $('#CadenaHijoFin').val($('#CadenaHijoFin').val()+'-'+factor+'|');
                        var index_hijo = $('#index_hijo_'+Q).val();
                        var CadenaOrdenHijo = $('#Cadena_'+Q).val();
                        var Cadena_SelectHijo = $('#Cadena_hijo_'+Q).val();
                        var D_ordenHijo = CadenaOrdenHijo.split('-');
                        var D_SelectHijo = Cadena_SelectHijo.split('-');
                        if(D_ordenHijo[0]==factor && D_SelectHijo[0]==factor){
                            var C_OrdenHijo = D_ordenHijo[1].split(',');
                            var C_SelectHijo =  D_SelectHijo[1].split(':');
                            var Num_OrdenHijo = C_OrdenHijo.length;
                            var Num_selectHijo = C_SelectHijo.length;
                            
                            for(k=0;k<Num_OrdenHijo;k++){
                                for(l=1;l<Num_selectHijo;l++){
                                    if(C_OrdenHijo[k]==C_SelectHijo[l]){
                                        $('#CadenaHijoFin').val($('#CadenaHijoFin').val()+':'+C_SelectHijo[l]);
                                    }
                                }
                            }
                        }
                    }
                }
            }
            /*##################################################################Funcion JSON#######################################################################################*/
            var Nom_Documento   = $('#Nom_Documento').val();
            var Nom_entidad     = $('#Nom_entidad').val();
            var Tipo_doc        = $('#Tipo_doc').val();	
            var Programa_id     = $('#Programa_id').val();
            
            if(!$.trim(Nom_Documento)){
                alert('Ingrese El Nombre del Documento...!');
                return false;
            }
            if(!$.trim(Nom_entidad)){
                alert('Ingrese El Nombre de la Entidad a Presentar...!');
                return false;
            }
            
            if(Tipo_doc=='-1' || Tipo_doc==-1){
                alert('Elige un Tipo De Documento...!');
                return false;
            }
            
            if(Tipo_doc=='3' || Tipo_doc==3){
                if(Programa_id=='-1' || Programa_id==-1){
                    alert('Elige un Programa...!');
                    return false;
                }
            }
            
            if(Tipo_doc==1 || Tipo_doc=='1'){
                var Programa_id = 0;
            }else{
                var Programa_id = $('#Programa_id').val();
            }
            
            var CadenaPadreFin   = $('#CadenaPadreFin').val();
            var CadenaHijoFin    = $('#CadenaHijoFin').val();
            var fechainicio = $('#fechainicio').val();
            var fechafin    = $('#fechafin').val();
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'Save',
                    Nom_Documento:Nom_Documento,
                    Nom_entidad:Nom_entidad,
                    Tipo_doc:Tipo_doc,
                    Programa_id:Programa_id,
                    CadenaPadreFin:CadenaPadreFin,
                    CadenaHijoFin:CadenaHijoFin,
                    fechainicio:fechainicio,
                    fechafin:fechafin,
                    Estructura_id:Estructura_id
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert(data.descrip);
                        if(typeof Estructura_id !== null){
                            $("#DivCargar").html(data.descrip  );
                            location.href='Estructura_documento.html.php?actionID=Gestion';
                        }else{
                            location.href='Estructura_documento.html.php';
                        }
                    }
                }
            });
            /*##################################################################Funcion JSON#######################################################################################*/
	}
        
        function Editar_Estructura(){
            if(aSelected.length==1){
                var id = aSelected[0];
            }else{
                return false;
            }
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                data:({actionID: 'Editar',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#container').html(data);
                }
            });
        }
        
        function Ver(){
            var Tipo_doc  = $('#Tipo_doc').val();
            
            if(Tipo_doc=='-1' || Tipo_doc==-1 || Tipo_doc=='1' || Tipo_doc==1){
                $('#Div_Facultad').css('display','none');
                $('#Td_Facultad').css('visibility','collapse');
                $('#Contenedor_Td').css('visibility','collapse');
                $('#Carga').html('');
            }else{
                $('#Div_Facultad').css('display','block');
                $('#Td_Facultad').css('visibility','visible');
            }
	}
        
        function VerPrograma(id){
            $.ajax({
                type: 'GET',
                url: '../Administradores/admin_Proceso.html.php',
                async: false,
                data:({actionID: 'Programa',id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){ 
                    $('#Contenedor_Td').css('visibility','visible');
                    $('#Carga').html(data);
                }
            });
	}
        
        function EditarContenido(){
            var Estructura_id = $('#Estructura_id').val();
            var tipo          = $('#tipo').val();
            var Programa      = $('#Programa').val();
            
            if($('#Factores').is(':checked')){
                NewModificarInd(Estructura_id);
                $('#Update_in').css('display','none');
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    data:({
                        actionID: 'Factores',
                        Estructura_id:Estructura_id,
                        tipo:tipo,
                        Programa:Programa
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#DivCargar').html(data);
                    }
                });
            }else{
                ModificatTwo(Estructura_id);
                $('#Update_in').css('display','none');
                
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    data:({
                        actionID: 'Indicadores',
                        Estructura_id:Estructura_id,
                        tipo:tipo,
                        Programa:Programa
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        $('#DivCargar').html(data);
                    }
                });
            }
        }
        
        function Buscar_Factor(id,tipo,programa){
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                data:({
                    actionID: 'Buscar_Factor',
                    id:id,
                    tipo:tipo,
                    programa:programa
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#Buscar_F').css('display','none');
                    $('#DivMasFactor').css('display','block');
                    $('#DivMasFactor').html(data);
                }
            });
        }
        
        function Close(){
            $('#Buscar_F').css('display','block');
            $('#DivMasFactor').css('display','none');
        }
        
        function Buscar_Indicador(id,tipo,programa){
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                data:({
                    actionID: 'Buscar_Indicador',
                    id:id,
                    tipo:tipo,
                    programa:programa
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#BuscarIndi').css('display','none');
                    $('#DivMasIndicadores').css('display','block');
                    $('#DivMasIndicadores').html(data);
                }
            });
	}
        
        function Closed(){
            $('#BuscarIndi').css('display','block');
            $('#DivMasIndicadores').css('display','none');
        }
        
        function EliminarFactor(id_factor,id_doc,i){
            if(confirm('Seguro Desea Eliminar El Factor...?')){
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({
                        actionID: 'Eliminar_Factor',
                        id_factor:id_factor,
                        id_doc:id_doc
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            alert('Se Ha Eliminado El Factor Correctamente...');
                            Factores(data.id);
                        }
                    }
                });
            }else{
                $('#Factor_'+i).attr('checked',true);
                $('#Factor_'+i).attr('checked',true);
            }
        }
        
        function Factores(id){
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                data:({
                    actionID: 'Factor',
                    id:id
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#DivFactor').html(data);
                }
            });
        }
        
        function EliminarIndicador(id_indicador,id,posicion,i,id_doc,idFactor){
            if(confirm('Seguro Desea Eliminar El Indicador \n de la Estructura del Documento')){
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({
                        actionID: 'Eliminar_Indicador',
                        id_indicador:id_indicador,
                        id:id
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            alert('Se Ha Eliminado El Indicador Correctamente...');
                            Indicador(i,id_doc,idFactor);
                        }
                    }
                });
            }else{
                $('#Indicador_'+posicion).attr('checked',true);
            }
        }
        
        function Indicador(i,id,idFactor){
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                data:({
                    actionID: 'Indicador',
                    i:i,
                    id:id,
                    idFactor:idFactor
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#sortable_Indicador_'+i).html(data);
                } 
            });
        }
        
        function NuevoFactor(factor_id,id,i){
            if($('#item_'+i).is(':checked')){
                var list = $("#sortable_Factores").sortable('toArray');
                $('#Cadena_List').val('');
		$('#Cadena_List').val(list);
		var Cadena_List = $('#Cadena_List').val();
                
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({
                        actionID: 'New_Factor',
                        id:id,
                        list:Cadena_List,
                        factor_id:factor_id
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            alert('Se Ha Agrego Correctamente el Factor...');
                        }
                    }
                });
            }else{
                EliminarFactor(factor_id,id,i);
            }
        }
        
        function Modifcar(id){
            Update(id);
            var list = $("#sortable_Factores").sortable('toArray');
            $('#Cadena_List').val('');
            $('#Cadena_List').val(list);
            var Cadena_List = $('#Cadena_List').val();
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({
                    actionID: 'ModificarPocision',
                    id:id,
                    list:Cadena_List
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert('Se Ha Modificado Correctamente los Factores...');
                        Factores(id);
                    }
                }
            });
        }
        
        function ModificatTwo(id){
            Update(id);
            var list = $("#sortable_Factores").sortable('toArray');
            $('#Cadena_List').val('');
            $('#Cadena_List').val(list);
            var Cadena_List = $('#Cadena_List').val();
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({
                    actionID: 'ModificarPocision',
                    id:id,
                    list:Cadena_List
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }											
                } 
            });//Ajax
	}
        
        function NuevoIndicador(indicador_id,id){
            if($('#item_'+indicador_id).is(':checked')){
                var index = $('#index').val();
                
                for(i=0;i<index;i++){
                    var list = $("#sortable_Indicador_"+i).sortable('toArray');
                    $('#Cadena_ind_'+i).val('');
                    $('#Cadena_ind_'+i).val(list);
                    var Cadena_ind  = $('#Cadena_ind_'+i).val();
                    var Factor_id   = $('#Factor_id_'+i).val();
                    
                    if($.trim(Cadena_ind)){
                        $.ajax({
                            type: 'GET',
                            url: 'Estructura_documento.html.php',
                            async: false,
                            dataType: 'json',
                            data:({
                                actionID: 'New_indicador',
                                id:id,
                                list:Cadena_ind,
                                indicador_id:indicador_id,
                                Factor_id:Factor_id
                            }),
                            error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                            success: function(data){
                                if(data.val=='FALSE'){
                                    alert(data.descrip);
                                    return false;
                                }else{
                                    if(data.Ultimo_id!=null){
                                        $('#Ultimo_id_'+indicador_id).val(data.Ultimo_id);
                                        alert('Se Ha Agrego Correctamente el Indicador...');
                                        Indicador(i,id,Factor_id);
                                    }
                                }
                            } 
                        });
                    }
                }
            }else{
                EliminarIndicador_New(indicador_id,id);
            }
        }
        
        function ModificarInd(id){
            Update(id);
            var index  = $('#index').val();
            $('#Cadena_UP').val('');
            
            for(i=0;i<index;i++){
                $('#Cadena_ind_'+i).val('');
                var list = $('#sortable_Indicador_'+i).sortable('toArray');
                $('#Cadena_ind_'+i).val(list);
                var Cadena_ind = $('#Cadena_ind_'+i).val();
                var Factor_id   = $('#Factor_id_'+i).val();
                $('#Cadena_UP').val($('#Cadena_UP').val()+'::'+Factor_id+'-'+Cadena_ind);
            }
            
            var Cadena_UP  = $('#Cadena_UP').val();
                
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({
                    actionID: 'ModificarPocisionInd',
                    list:Cadena_UP,
                    id:id
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert('Se Ha Modificado Correctamente los Indicadores...');
                        CargarIndicadores(id,data.tipo,data.programa);
                    }
                }
            });
	}
        
        function NewModificarInd(id){
            Update(id);
            var index  = $('#index').val();
            $('#Cadena_UP').val('');
            
            for(i=0;i<index;i++){
                $('#Cadena_ind_'+i).val('');
                var list = $('#sortable_Indicador_'+i).sortable('toArray');
                $('#Cadena_ind_'+i).val(list);
                var Cadena_ind = $('#Cadena_ind_'+i).val();
                var Factor_id   = $('#Factor_id_'+i).val();
                $('#Cadena_UP').val($('#Cadena_UP').val()+'::'+Factor_id+'-'+Cadena_ind);
            }
            
            var Cadena_UP  = $('#Cadena_UP').val();
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({
                    actionID: 'ModificarPocisionInd',
                    list:Cadena_UP,
                    id:id
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }
                }
            });
        }
        
        function CargarIndicadores(id,tipo,programa){
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                data:({
                    actionID: 'Indicadores',
                    Estructura_id:id,
                    tipo:tipo,
                    Programa:programa
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    $('#DivCargar').html(data);
                }
            });
        }
        
        function Update(id){
            var Nom_Documento  = $('#Nom_Documento').val();
            var Nom_entidad    = $('#Nom_entidad').val();
            var Tipo_doc       = $('#Tipo_doc').val();
            var Programa_id    = 0;
            var fechainicio    = $('#fechainicio').val();
            var fechafin       = $('#fechafin').val();

            if(Tipo_doc!=1 || Tipo_doc!='1'){
                var Programa_id    = $('#Programa_id').val();

                if(Programa_id=='-1' || Programa_id==-1){
                            alert('Elige Programa....!');
                            return false;
                }
            }
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({
                    actionID: 'Update_Doc',
                    id:id,
                    Nom_Documento:Nom_Documento,
                    Nom_entidad:Nom_entidad,
                    Tipo_doc:Tipo_doc,
                    Programa_id:Programa_id,
                    fechainicio:fechainicio,
                    fechafin:fechafin
                }),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        alert('Se Ha Guardado Correctamente..');
                    }
                }
            });
	}
        
        function Eliminar_Estructura(){
            if(aSelected.length==1){
                var id = aSelected[0];
            }else{
                return false;
            }
            
            if(confirm('Seguro Desea Eliminar la Estrucutura del Documento Selecionado...?')){
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({actionID: 'EliminarDocumento', id:id}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            alert('Se ha Eliminado la Estructura Completa del Documento...');
                            location.href='Estructura_documento.html.php?actionID=Gestion';
                        }
                    }
                });
            }
        }
        
        function Duplicar_Estructura(){
            if(aSelected.length==1){
                var id = aSelected[0];
            }else{
                return false;
            }
            
            $.ajax({
                type: 'GET',
                url: 'Estructura_documento.html.php',
                async: false,
                dataType: 'json',
                data:({actionID: 'BuscarNombre', id:id}),
                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                success: function(data){
                    if(data.val=='FALSE'){
                        alert(data.descrip);
                        return false;
                    }else{
                        Duplica(data.id,data.Nombre,data.tipo);
                    }
                }
            });
        }
        
        function Duplica(id,Nombre,tipo){
            if(confirm('Desea Duplicar el Documento '+Nombre)){
                if(tipo==3 || tipo=='3'){
                    $.ajax({
                        type: 'GET',
                        url: 'Estructura_documento.html.php',
                        async: false,
                        //dataType: 'json',
                        data:({actionID: 'DialogoDuplicar',id:id}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){
                            $('#container').html(data);
                        }
                    });
                }else{
                    $.ajax({
                        type: 'GET',
                        url: 'Estructura_documento.html.php',
                        async: false,
                        dataType: 'json',
                        data:({actionID: 'DuplicarEstructura', id:id}),
                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                        success: function(data){	   
                            if(data.val=='FALSE'){
                                alert(data.descrip);
                                return false;
                            }else{
                                alert('Se Ha Creado la Estructura Correctamente Con El Nombre \n'+data.Nombre);
                                location.href='Estructura_documento.html.php?actionID=Gestion';
                            }
                        }
                    });
                }
            }
        }
        
        function DuplicarPrograma(id){
            var id_Programa  = $('#id_Programa').val();
            var Programa_id  = $('#Programa_id').val();
            
            if(Programa_id==-1 || Programa_id=='-1'){
                alert('Por favor Selecione un Programa...!');
                return false;
            }
            
            if(id_Programa==Programa_id){
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({actionID: 'DuplicarEstructura',
                                   id:id}),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){	   
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            alert('Se Ha Creado la Estructura Correctamente Con El Nombre \n'+data.Nombre+'\n Por Favor Verifique El contenido');
                            location.href='Estructura_documento.html.php?actionID=Gestion';
                        }
                    } 
                });
            }else{
                $.ajax({
                    type: 'GET',
                    url: 'Estructura_documento.html.php',
                    async: false,
                    dataType: 'json',
                    data:({
                        actionID: 'DuplicarEstructuraPrograma',
                        id:id,
                        Programa_id:Programa_id
                    }),
                    error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                    success: function(data){
                        if(data.val=='FALSE'){
                            alert(data.descrip);
                            return false;
                        }else{
                            alert('Se Ha Creado la Estructura Correctamente Con El Nombre \n'+data.Nombre+'\n Por Favor Verifique El contenido');
                            location.href='Estructura_documento.html.php?actionID=Gestion';
                        }
                    } 
                });
            }
	}			
    </script>
    <?php 
}
?>