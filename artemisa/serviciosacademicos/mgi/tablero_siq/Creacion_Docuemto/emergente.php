<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
// session_start();
require_once("../../datos/templates/template.php");
$rutaVistas = "./vistas";
require_once(realpath(dirname(__FILE__)) . "/../../../../Mustache/load.php");
include(realpath(dirname(__FILE__)) . "/../../../utilidades/helpers/funcionesLoop.php");

$db = getBD();
if (isset($_REQUEST["action"]) && $_REQUEST["action"] == "inactivate") {
    if ($_POST["tp"] == "pa") {
        $query = "UPDATE siq_factorautoevaluacion SET codigoestado='200' "
        . "WHERE idsiq_factorautoevaluacion=" . $_POST["idsiq_factorautoevaluacion"] . " "
        . "and idsiq_factor=" . $_POST["idsiq_factor"].""
        . "and idsiq_estructuradocumento = ".$_REQUEST['idsiq_estructuradocumento']." ";
        $db->Execute($query);

        $query = "UPDATE siq_archivo_documento SET codigoestado='200' 
        WHERE siq_documento_id IN (
            SELECT idsiq_documento FROM siq_factorautoevaluacion WHERE 
            idsiq_factorautoevaluacion=" . $_POST["idsiq_factorautoevaluacion"] . " "
            . "and idsiq_factor=" . $_POST["idsiq_factor"] . ""
        . ")";

        $db->Execute($query);
    } else if ($_POST["tp"] == "va") {
        $query = "UPDATE siq_archivo_documento SET codigoestado='200' "
        . "WHERE idsiq_archivodocumento=" . $_POST["idsiq_factorautoevaluacion"];
        $db->Execute($query);
    }
    echo json_encode(array("success" => true));
    exit();
}
?>


<?php
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);

$utils = new Utils_datos();
require_once("../../API_Monitoreo.php");
$api = new API_Monitoreo();
$user = null;
$guardar = false;
$user = $utils->getUser();

/* * ************************************************************************************ */
/* * ************************************ GUARDAR DATOS ********************************* */
if ($_REQUEST["accion"] == "Guardar") {
    $guardar = true;
    $dateTime = date("Y-m-d h:m:s");

    function FileUploadErrorMsg($error_code) {
        switch ($error_code) {
            case UPLOAD_ERR_INI_SIZE:
                return "El archivo es mÃ¡s grande que lo permitido por el Servidor.";
            case UPLOAD_ERR_FORM_SIZE:
                return "El archivo subido es demasiado grande.";
            case UPLOAD_ERR_PARTIAL:
                return "El archivo subido no se terminÃ³ de cargar (probablemente cancelado por el usuario).";
            case UPLOAD_ERR_NO_FILE:
                return "No se subiÃ³ ningÃºn archivo";
            case UPLOAD_ERR_NO_TMP_DIR:
                return "Error del servidor: Falta el directorio temporal.";
            case UPLOAD_ERR_CANT_WRITE:
                return "Error del servidor: Error de escritura en disco";
            case UPLOAD_ERR_EXTENSION:
                return "Error del servidor: Subida detenida por la extenciÃ³n";
            default:
                return "Error del servidor: " . $error_code;
        }
    }

    if ($_REQUEST["tp"] == "dg1") {
        if (empty($_REQUEST["idsiq_factorinformaciongeneral"])) {
            $sql = "insert into siq_factorinformaciongeneral
                    (resumen
                    ,valoracion
                    ,op_consolodacion
                    ,op_mejora
                    ,plan_desarrollo
                    ,idsiq_factor
                    ,codigoestado
                    ,idsiq_estadoActividadActualizar
                    ,fecha_creacion
                    ,idusuario_creacion
                    ,fecha_ultima_modificacion
                    ,idusuario_ultima_modificacion
                    ,idsiq_estructuradocumento)
                values ( '" . $_REQUEST["resumen"] . "'
                    ,0
                    ,'" . $_REQUEST["op_consolodacion"] . "'
                    ,'" . $_REQUEST["op_mejora"] . "'
                    ,'" . $_REQUEST["plan_desarrollo"] . "'
                    ," . $_REQUEST["idsiq_factor"] . "
                    ,'100'
                    ,1
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . "
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . "
                    ,'" . $_REQUEST["idsiq_estructuradocumento"] . "')";
        } else {
            $sql = "update siq_factorinformaciongeneral
                set	 resumen='" . $_REQUEST["resumen"] . "'
                        ,valoracion=0
                        ,op_consolodacion='" . $_REQUEST["op_consolodacion"] . "'
                        ,op_mejora='" . $_REQUEST["op_mejora"] . "'
                        ,plan_desarrollo='" . $_REQUEST["plan_desarrollo"] . "'
                        ,idsiq_factor=" . $_REQUEST["idsiq_factor"] . "
                        ,fecha_ultima_modificacion='" . $dateTime . "'
                        ,idusuario_ultima_modificacion=" . $user["idusuario"] . "
                        ,idsiq_estructuradocumento=" . $_REQUEST["idsiq_estructuradocumento"] . "
                where idsiq_factorinformaciongeneral=" . $_REQUEST["idsiq_factorinformaciongeneral"];
        }
        //echo $sql;exit;
        $db->Execute($sql);
    }
    if ($_REQUEST["tp"] == "dg2") {
        if (empty($_REQUEST["idsiq_caracteristicainformaciongeneral"])) {
            $sql = "insert into siq_caracteristicainformaciongeneral
                    (resumen
                    ,idsiq_caracteristica
                    ,codigoestado
                    ,id_estadoActividadActualizar
                    ,fechacreacion
                    ,idusuario_creacion
                    ,fecha_ultima_modificacion
                    ,idusuario_ultima_modificacion
                    ,idsiq_estructuradocumento)
                values ( '" . $_REQUEST["resumen"] . "'
                    ," . $_REQUEST["idsiq_caracteristica"] . "
                    ,'100'
                    ,1
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . "
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . "
                    ," . $_REQUEST["idsiq_estructuradocumento"] . ")";
        } else {
            $sql = "update siq_caracteristicainformaciongeneral
                set resumen='" . $_REQUEST["resumen"] . "'
                    ,idsiq_caracteristica=" . $_REQUEST["idsiq_caracteristica"] . "
                    ,fecha_ultima_modificacion='" . $dateTime . "'
                    ,idusuario_ultima_modificacion=" . $user["idusuario"] . "
                    ,idsiq_estructuradocumento=" . $_REQUEST["idsiq_estructuradocumento"] . "
                where idsiq_caracteristicainformaciongeneral=" . $_REQUEST["idsiq_caracteristicainformaciongeneral"];
        }
        $db->Execute($sql);
    }
    if ($_REQUEST["tp"] == "np") {
        if ($_FILES["archivo"]["error"] > 0) {
            echo FileUploadErrorMsg($_FILES["archivo"]["error"]);
            exit;
        } else {

            $periodo = substr($_SESSION["codigoperiodosesion"], 0, 4) . "-" . substr($_SESSION["codigoperiodosesion"], 4, 1);

            $sql = "insert into siq_documento 
                    (siqfactor_id
                    ,periodo
                    ,fecha_ingreso
                    ,userid
                    ,entrydate)
                values (" . $_REQUEST["idsiq_factor"] . "
                    ,'" . $periodo . "'
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . "
                    ,'" . $dateTime . "')";
            
            $db->Execute($sql);

            $sql = "select max(idsiq_documento) as id from siq_documento";
            $reg = &$db->Execute($sql);
            $id = $reg->fields["id"];

            $sql = "insert into siq_factorautoevaluacion
                    (idsiq_factor
                    ,idsiq_estructuradocumento
                    ,nombre
                    ,descripcion
                    ,idsiq_documento
                    ,codigoestado
                    ,id_estadoActividadActualizar
                    ,fecha_creacion
                    ,idusuario_creacion
                    ,fecha_ultima_modificacion
                    ,idusuario_ultima_modificacion)
                values (" . $_REQUEST["idsiq_factor"] . "
                    ,". $_REQUEST["idsiq_estructuradocumento"]. " 
                    ,'" . $_REQUEST["nombreproceso"] . "'
                    ,'" . $_REQUEST["descripcionproceso"] . "'
                    ," . $id . "
                    ,'100'
                    ,1
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . "
                    ,'" . $dateTime . "'
                    ," . $user["idusuario"] . ")";            
            $db->Execute($sql);


            $sql = "insert into siq_archivo_documento
                    (siq_documento_id
                    ,descripcion
                    ,file_size
                    ,nombre_archivo
                    ,tamano_unida
                    ,tipo_documento
                    ,fecha_carga
                    ,tipo
                    ,extencion
                    ,userid
                    ,entrydate)
                values (" . $id . "
                    ,'" . $_REQUEST["descripcionarchivo"] . "'
                    ,'" . $_FILES["archivo"]["size"] . "'
                    ,'" . $_FILES["archivo"]["name"] . "'
                    ,'KBs'
                    ,3
                    ,'" . date("Y-m-d") . "'
                    ,'" . $_FILES["archivo"]["type"] . "'
                    ,'" . end(explode(".", $_FILES["archivo"]["name"])) . "'
                    ," . $user["idusuario"] . "
                    ,'" . $dateTime . "')";
            
            $db->Execute($sql);

            $sql = "select max(idsiq_archivodocumento) as id from siq_archivo_documento";
            $reg = &$db->Execute($sql);
            $id = $reg->fields["id"];


            $url = "../../SQI_Documento/";
            $url_compl = "Documento_upload/" . $id . "." . end(explode(".", $_FILES["archivo"]["name"]));
            copy($_FILES["archivo"]["tmp_name"], $url . $url_compl);

            $sql = "update siq_archivo_documento set Ubicaicion_url='" . $url_compl . "' where idsiq_archivodocumento=" . $id;
            //echo $sql."<br><br>";
            $db->Execute($sql);

            echo "<script>
                    alert('Proceso almacenado');
                    location.href='emergente.php?idsiq_estructuradocumento=". $_REQUEST["idsiq_estructuradocumento"] . 
                    "&idsiq_factor=" . $_REQUEST["idsiq_factor"] . "&tp=pa';
                </script>";
        }
    }
    if ($_REQUEST["tp"] == "aa") {
        if ($_FILES["archivo"]["error"] > 0) {
            echo FileUploadErrorMsg($_FILES["archivo"]["error"]);
            exit;
        } else {

            $periodo = substr($_SESSION["codigoperiodosesion"], 0, 4) . "-" . substr($_SESSION["codigoperiodosesion"], 4, 1);

            $sql = "insert into siq_archivo_documento
                    (siq_documento_id
                    ,descripcion
                    ,file_size
                    ,nombre_archivo
                    ,tamano_unida
                    ,tipo_documento
                    ,fecha_carga
                    ,tipo
                    ,extencion
                    ,userid
                    ,entrydate)
                values (" . $_REQUEST["idsiq_documento"] . "
                    ,'" . $_REQUEST["descripcionarchivo"] . "'
                    ,'" . $_FILES["archivo"]["size"] . "'
                    ,'" . $_FILES["archivo"]["name"] . "'
                    ,'KBs'
                    ,3
                    ,'" . date("Y-m-d") . "'
                    ,'" . $_FILES["archivo"]["type"] . "'
                    ,'" . end(explode(".", $_FILES["archivo"]["name"])) . "'
                    ," . $user["idusuario"] . "
                    ,'" . $dateTime . "')";
            
            $db->Execute($sql);

            $sql = "select max(idsiq_archivodocumento) as id from siq_archivo_documento";
            $reg = &$db->Execute($sql);
            $id = $reg->fields["id"];


            $url = "../../SQI_Documento/";
            $url_compl = "Documento_upload/" . $id . "." . end(explode(".", $_FILES["archivo"]["name"]));
            copy($_FILES["archivo"]["tmp_name"], $url . $url_compl);

            $sql = "update siq_archivo_documento set Ubicaicion_url='" . $url_compl . "' where idsiq_archivodocumento=" . $id;
            //echo $sql."<br><br>";
            $db->Execute($sql);
        }
    }
    ?>
    <?php
}
/* * ********************************* FIN GUARDAR DATOS ******************************** */
/* * ************************************************************************************ */

if ($_REQUEST["tp"] == "pa") {
    $sql = "select f.nombre
        from siq_factor f
        where idsiq_factor=" . $_REQUEST["idsiq_factor"];
    $reg = $db->Execute($sql);

    //permisos de actualizar
    $query_factores = $api->getQueryFactoresACargo($user["idusuario"], 1);
    //echo "SELECT * FROM ($query_factores) x WHERE x.idFactor=".$_REQUEST["idsiq_factor"];
    $result = $db->GetRow("SELECT * FROM ($query_factores) x WHERE x.idFactor=" . $_REQUEST["idsiq_factor"]);

    $periodo = substr($_SESSION["codigoperiodosesion"], 0, 4) . "-" . substr($_SESSION["codigoperiodosesion"], 4, 1);
    $sql = "select idsiq_factorautoevaluacion
            ,nombre
            ,descripcion
            ,idsiq_documento
            ,fecha_creacion
        from siq_factorautoevaluacion f 
        join siq_documento using(idsiq_documento)
        where idsiq_factor=" . $_REQUEST["idsiq_factor"] . " "
        . "and f.codigoestado=100 and f.idsiq_estructuradocumento = ".$_REQUEST['idsiq_estructuradocumento']."
        order by fecha_creacion DESC";    
    $procesos = $db->GetAll($sql);

    $template = $mustache->loadTemplate('procesosAutoevaluacion');
    $g_counterProcesos = 1;
    echo $template->render(array('title' => 'Procesos de AutoevaluaciÃ³n',
        'tp' => $_REQUEST["tp"],
        'nombre' => $reg->fields["nombre"],
        'tienePermisos' => (count($result) > 0 && $result !== false),
        'idsiq_factor' => $_REQUEST["idsiq_factor"],
        'idsiq_estructuradocumento' => $_REQUEST["idsiq_estructuradocumento"],
        'procesos' => $procesos,
        'class_even' => $helper_contadorParImpar,
        'variable' => 'g_counterProcesos',
        'guardar' => $guardar
            )
    );
} else if ($_REQUEST["tp"] == "dg1") {
    $sql = "SELECT f.nombre
            ,fig.idsiq_factorinformaciongeneral
            ,fig.resumen
            ,fig.valoracion
            ,fig.op_consolodacion
            ,fig.op_mejora
            ,fig.plan_desarrollo
        FROM siq_factor f
        LEFT JOIN siq_factorinformaciongeneral fig ON (f.idsiq_factor = fig.idsiq_factor AND fig.idsiq_estructuradocumento = ".$_REQUEST["idsiq_estructuradocumento"].") 
        WHERE f.idsiq_factor=" . $_REQUEST["idsiq_factor"];
    //echo $sql;
    $reg = $db->Execute($sql);

    //permisos de actualizar
    $query_factores = $api->getQueryFactoresACargo($user["idusuario"], 1);
    //echo "SELECT * FROM ($query_factores) x WHERE x.idFactor=".$_REQUEST["idsiq_factor"];
    $result = $db->GetRow("SELECT * FROM ($query_factores) x WHERE x.idFactor=" . $_REQUEST["idsiq_factor"]);
    $template = $mustache->loadTemplate('descripcionFactor');


  $sqlFactoresEstructuraDocumento="
        SELECT
                idsiq_factoresestructuradocumento 
        FROM
                siq_factoresestructuradocumento 
        WHERE
                factor_id = ".$_REQUEST["idsiq_factor"]."
        	AND idsiq_estructuradocumento = ".$_REQUEST["idsiq_estructuradocumento"]."";
  
    $resultSqlFactoresEstructuraDocumento= $db->GetRow( $sqlFactoresEstructuraDocumento);    
     
    $sqlOportunidadesMejora = "SELECT
                                    idsiq_oportunidad,
                                    nombre,
                                    descripcion,
                                    idsiq_tipooportunidad,
                                    Valoracion,
                                    (case
                                        WHEN Valoracion <=25 THEN 'Bajo'
                                        WHEN Valoracion >25 && Valoracion <51 THEN 'Medio'
                                        WHEN Valoracion >50   && Valoracion <76 THEN 'Alto'
                                        WHEN Valoracion >75 THEN 'Muy alto'
                                    else 1																				
                                            END																					
                                    )as avance
                            FROM
                                    siq_oportunidades 
                            WHERE
                                    idsiq_factorestructuradocumento = ".$resultSqlFactoresEstructuraDocumento["idsiq_factoresestructuradocumento"]." 
                                    AND idsiq_tipooportunidad=1
                                    AND codigoestado = 100";
       
    $sqlOportunidadesConsolidadcion = "SELECT
                                    idsiq_oportunidad,
                                    nombre,
                                    descripcion,
                                    idsiq_tipooportunidad,
                                    Valoracion,
                                    (case
                                        WHEN Valoracion <=25 THEN 'Bajo'
                                        WHEN Valoracion >25 && Valoracion <51 THEN 'Medio'
                                        WHEN Valoracion >50   && Valoracion <76 THEN 'Alto'
                                        WHEN Valoracion >75 THEN 'Muy alto'
                                    else 1																				
                                            END																					
                                    )as avance
                            FROM
                                    siq_oportunidades 
                            WHERE
                                    idsiq_factorestructuradocumento = ".$resultSqlFactoresEstructuraDocumento["idsiq_factoresestructuradocumento"]." 
                                    AND idsiq_tipooportunidad=2
                                    AND codigoestado = 100";
    
    $resultSqlMejora=$db->GetAll( $sqlOportunidadesMejora );
    $resultSqlConsolidacion=$db->GetAll( $sqlOportunidadesConsolidadcion );
   echo $template->render(array('title' => 'DescripciÃ³n General del Factor',
        'tp' => $_REQUEST["tp"],
        'idsiq_estructuradocumento' => $_REQUEST["idsiq_estructuradocumento"],
        'nombreFactor' => $reg->fields["nombre"],
        'tienePermisos' => (count($result) > 0 && $result !== false),
        'idsiq_factor' => $_REQUEST["idsiq_factor"],
        'idsiq_factorinformaciongeneral' => $reg->fields["idsiq_factorinformaciongeneral"],
        'resumen' => $reg->fields["resumen"],
        'op_consolodacion' => $reg->fields["op_consolodacion"],
        'op_mejora' => $reg->fields["op_mejora"],
        'oportunidadMejora'=>$resultSqlMejora,
        'oportunidadConsolidacion'=>$resultSqlConsolidacion,
        'plan_desarrollo' => $reg->fields["plan_desarrollo"],
        'guardar' => $guardar
            )
    );

 
}
if ($_REQUEST["tp"] == "dg2") {
    $sql = "SELECT
            concat(c.codigo,c.nombre) as nombre
            ,cig.idsiq_caracteristicainformaciongeneral
            ,cig.resumen,
            c.idFactor 
        FROM siq_caracteristica c
        LEFT JOIN siq_caracteristicainformaciongeneral cig ON (c.idsiq_caracteristica = cig.idsiq_caracteristica AND cig.idsiq_estructuradocumento = ".$_REQUEST["idsiq_estructuradocumento"].")
        WHERE c.idsiq_caracteristica=" . $_REQUEST["idsiq_caracteristica"];
    $reg = $db->Execute($sql);

    //permisos de actualizar
    $query_factores = $api->getQueryCaracteristicasACargo($user["idusuario"], 1);
    
    $result = $db->GetRow("SELECT * FROM ($query_factores) x WHERE x.idCaracteristica=" . $_REQUEST["idsiq_caracteristica"]);
    $template = $mustache->loadTemplate('descripcionCaracteristica');
    echo $template->render(array('title' => 'DescripciÃ³n General de la CaracterÃ­stica',
        'tp' => $_REQUEST["tp"],
        'idsiq_estructuradocumento' => $_REQUEST["idsiq_estructuradocumento"],
        'nombreFactor' => $reg->fields["nombre"],
        'tienePermisos' => (count($result) > 0 && $result !== false),
        'idsiq_caracteristica' => $_REQUEST["idsiq_caracteristica"],
        'idsiq_caracteristicainformaciongeneral' => $reg->fields["idsiq_caracteristicainformaciongeneral"],
        'resumen' => $reg->fields["resumen"],
        'guardar' => $guardar
            )
    );
}
if ($_REQUEST["tp"] == "np") {
    $sql = "select f.nombre
        from siq_factor f
        where idsiq_factor=" . $_REQUEST["idsiq_factor"];
    $reg = &$db->Execute($sql);

    //permisos de actualizar
    $query_factores = $api->getQueryFactoresACargo($user["idusuario"], 1);
    
    $result = $db->GetRow("SELECT * FROM ($query_factores) x WHERE x.idFactor=" . $_REQUEST["idsiq_factor"]);
    $template = $mustache->loadTemplate('nuevoProceso');
    echo $template->render(array('title' => 'DescripciÃ³n General de la CaracterÃ­stica',
        'tp' => $_REQUEST["tp"],
        'nombreFactor' => $reg->fields["nombre"],
        'tienePermisos' => (count($result) > 0 && $result !== false),
        'idsiq_factor' => $_REQUEST["idsiq_factor"],
        'idsiq_estructuradocumento' => $_REQUEST["idsiq_estructuradocumento"],
        'guardar' => $guardar
            )
    );
}
if ($_REQUEST["tp"] == "aa") {
    $sql = "select f.nombre
        from siq_factor f
        where idsiq_factor=" . $_REQUEST["idsiq_factor"];
    $reg = $db->Execute($sql);

    $sql = "select nombre
            ,descripcion
        from siq_factorautoevaluacion
        where idsiq_documento=" . $_REQUEST["idsiq_documento"];
    $documento = $db->Execute($sql);

    $template = $mustache->loadTemplate('adjuntarArchivo');
    echo $template->render(array('title' => 'Adjuntar Archivo',
        'tp' => $_REQUEST["tp"],
        'nombre' => $reg->fields["nombre"],
        'idsiq_factor' => $_REQUEST["idsiq_factor"],
        'idsiq_estructuradocumento' => $_REQUEST["idsiq_estructuradocumento"],
        'nombreProceso' => $documento->fields["nombre"],
        'descripcion' => $documento->fields["descripcion"],
        'guardar' => $guardar
            )
    );
} else if ($_REQUEST["tp"] == "va") {
    $sql = "select f.nombre
        from siq_factor f
        where idsiq_factor=" . $_REQUEST["idsiq_factor"];
    $reg = $db->Execute($sql);

    $sql = "select idsiq_documento
            ,nombre
            ,descripcion
        from siq_factorautoevaluacion
        where idsiq_factorautoevaluacion=" . $_REQUEST["idsiq_factorautoevaluacion"] . " and "
        . "codigoestado=100 and idsiq_estructuradocumento = ".$_REQUEST['idsiq_estructuradocumento']." ";
    $documento = $db->Execute($sql);

    $periodo = substr($_SESSION["codigoperiodosesion"], 0, 4) . "-" . substr($_SESSION["codigoperiodosesion"], 4, 1);
    $sql2 = "select idsiq_archivodocumento
            ,nombre_archivo
            ,descripcion
            ,fecha_carga
            ,Ubicaicion_url
            ,changedate
        from siq_archivo_documento
        where siq_documento_id=" . $documento->fields["idsiq_documento"] . " and codigoestado=100";
    $archivos = $db->GetAll($sql2);
    //var_dump($archivos);die;
    $template = $mustache->loadTemplate('archivosProcesos');
    $g_counter = 1;
    echo $template->render(array('title' => 'Archivos de Soporte',
        'tp' => $_REQUEST["tp"],
        'nombre' => $reg->fields["nombre"],
        'idsiq_factor' => $_REQUEST["idsiq_factor"],
        'idsiq_estructuradocumento' => $_REQUEST["idsiq_estructuradocumento"],
        'nombreProceso' => $documento->fields["nombre"],
        'descripcion' => $documento->fields["descripcion"],
        'documentos' => $archivos,
        'class_even' => $helper_contadorParImpar,
        'variable' => 'g_counter',
        'guardar' => $guardar
            )
    );
}
?>
<!--/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*-->

