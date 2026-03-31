<?php
    session_start();
    require_once('../../../../kint/Kint.class.php');
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_WARNING);

    ini_set('memory_limit', '128M');
    ini_set('max_execution_time', '216000');

    $rutaado = ("../../../funciones/adodb/");
    require_once('../../../Connections/salaado-pear.php');

    $_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
    if (!isset($_SESSION['array_sesion'])) {
        echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
        exit();
    }
    require_once("../../../funciones/clases/motor/motor.php");
?>
    <script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
    <meta charset="UTF-8">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
    <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
<?php
    if (isset($_GET['codigoestudiante'])) {
        $_SESSION['estudiante'] = $_GET['codigoestudiante'];
    }
    for ($i = 0; $i < count($_SESSION['array_sesion']); $i++){
        if(isset($_SESSION['array_sesion'][$i]['codigoestudiante']) && !empty($_SESSION['array_sesion'][$i]['codigoestudiante'])) {
            $sql = "select t.nombretipoestudianterecursofinanciero from estudiante e " .
                " INNER JOIN estudianterecursofinanciero er on e.idestudiantegeneral = er.idestudiantegeneral " .
                " INNER JOIN tipoestudianterecursofinanciero t on t.idtipoestudianterecursofinanciero = er.idtipoestudianterecursofinanciero " .
                " where e.codigoestudiante ='" . $_SESSION['array_sesion'][$i]['codigoestudiante'] . "'";
            $tipo_recurso = $sala->query($sql);
            $row_recurso = $tipo_recurso->fetchRow();
            if (isset($row_recurso['nombretipoestudianterecursofinanciero']) && !empty($row_recurso['nombretipoestudianterecursofinanciero'])) {
                $_SESSION['array_sesion'][$i]['recurso'] = $row_recurso['nombretipoestudianterecursofinanciero'];
            } else {
                $_SESSION['array_sesion'][$i]['recurso'] = "";
            }

            $sql2 = "SELECT r.numeroregistroresultadopruebaestado, r.PuntajeGlobal, r.fecharesultadopruebaestado " .
                " FROM resultadopruebaestado r " .
                " INNER JOIN estudiante e ON e.idestudiantegeneral = r.idestudiantegeneral " .
                " WHERE e.codigoestudiante = '" . $_SESSION['array_sesion'][$i]['codigoestudiante'] . "' " .
                " AND r.codigoestado = 100 AND r.fecharesultadopruebaestado = ( " .
                " SELECT max( fecharesultadopruebaestado ) FROM resultadopruebaestado resultadopruebaestado " .
                " INNER JOIN estudiante estudiante ON estudiante.idestudiantegeneral = resultadopruebaestado.idestudiantegeneral " .
                " WHERE resultadopruebaestado.codigoestado =  r.codigoestado AND estudiante.codigoestudiante = e.codigoestudiante) " .
                " AND r.idresultadopruebaestado IN( " .
                " SELECT idresultadopruebaestado FROM detalleresultadopruebaestado " .
                " WHERE idresultadopruebaestado=r.idresultadopruebaestado AND codigoestado=100 )";
            $reulstadopruebaestado = $sala->query($sql2);
            $row_pruebaestado = $reulstadopruebaestado->fetchRow();
            $_SESSION['array_sesion'][$i]['numero_registro_saber11'] = $row_pruebaestado['numeroregistroresultadopruebaestado'];
            $_SESSION['array_sesion'][$i]['PuntajeGlobal_saber11'] = $row_pruebaestado['PuntajeGlobal'];
            $_SESSION['array_sesion'][$i]['fecha_saber11'] = $row_pruebaestado['fecharesultadopruebaestado'];
        }
    }//for
?>
<?php
    $queryUsuarioFacultad = "SELECT uf.codigofacultad FROM usuariofacultad uf ".
    " WHERE uf.usuario='" . $_SESSION['MM_Username'] . "'";
    $usuarioFacultad = $sala->query($queryUsuarioFacultad);
    $rowUsuarioFacultad = $usuarioFacultad->fetchRow();
    do {
        $arrayAcceso[] = $rowUsuarioFacultad['codigofacultad'];
    } while ($rowUsuarioFacultad = $usuarioFacultad->fetchRow());

    if (isset($_REQUEST['Fecha_Proximo_Contacto'])) {
        if ($_REQUEST['Fecha_Proximo_Contacto'] != ''){
            $_SESSION['sesionFecha_Proximo_Contacto'] = $_REQUEST['Fecha_Proximo_Contacto'];
            $_SESSION['sesionf_Fecha_Proximo_Contacto'] = $_REQUEST['f_Fecha_Proximo_Contacto'];
        }
    }
    
    if (isset($_SESSION['sesionFecha_Proximo_Contacto'])) {
        $_REQUEST['Fecha_Proximo_Contacto'] = $_SESSION['sesionFecha_Proximo_Contacto'];
        $_REQUEST['f_Fecha_Proximo_Contacto'] = $_SESSION['sesionf_Fecha_Proximo_Contacto'];
    }

    if($_SESSION['descriptor_reporte']){
        $newArray = $_SESSION['array_sesion'];
        for ($i = 0; $i < count($newArray); $i++){
            $sqldatosextra = "SELECT gt.NombreGrupoEtnico as 'GrupoEtnico', v.NombreVinculacion ".
            " as 'vinculacion', ts.nombretipogruposanguineo as 'gruposanguineo', g.FechaDocumento ".
            " as 'fechaDocumento' FROM estudiantegeneral g ".
            " INNER JOIN estudiante e on e.idestudiantegeneral = g.idestudiantegeneral ".
            " INNER JOIN GrupoEtnico gt ON gt.GrupoEtnicoId = g.GrupoEtnicoId ".
            " INNER JOIN Vinculacion v on v.VinculacionId = e.VinculacionId ".
            " INNER JOIN gruposanguineoestudiante se on se.idestudiantegeneral = g.idestudiantegeneral ".
            " INNER JOIN tipogruposanguineo ts on ts.idtipogruposanguineo = se.idtipogruposanguineo ".
            " where g.numerodocumento = '".$newArray[$i]['numerodocumento']."' limit 1";
            $rta_query = $sala->query($sqldatosextra);        
            $row_query = $rta_query->fetchRow();
            if(isset($row_query['Grupo_Etnico']) && !empty($row_query['Grupo_Etnico'])) {
                $newArray[$i]['Grupo_Etnico'] = $row_query['Grupo_Etnico'];
                $newArray[$i]['Vinculacion'] = $row_query['Vinculacion'];
                $newArray[$i]['Grupo_sanguineo'] = $row_query['Grupo_sanguineo'];
                $newArray[$i]['Fecha_Expedicion_Documento'] = $row_query['Fecha_Expedicion_Documento'];
            }
        }
        $_SESSION['array_sesion'] = $newArray;
    }

    if ($_SESSION['descriptor_reporte'] == 'Interesados' or $_SESSION['descriptor_reporte'] == 'subtotal_Interesados'){
        $newArray = $_SESSION['array_sesion'];

        for ($i = 0; $i < count($newArray); $i++) {
            if (@$newArray[$i]['numerodocumento'] != ''){
                $query = "SELECT e.codigoestudiante,e.codigoperiodo,e.codigosituacioncarreraestudiante ".
                " FROM ordenpago o, detalleordenpago d, estudiante e, concepto co, estudiantegeneral eg ".
                " WHERE o.numeroordenpago=d.numeroordenpago AND e.codigoestudiante=o.codigoestudiante ".
                " AND d.codigoconcepto=co.codigoconcepto AND co.cuentaoperacionprincipal=153 ".
                " AND (o.codigoestadoordenpago LIKE '1%' or o.codigoestadoordenpago LIKE '4%') ".
                " AND o.codigoperiodo='" . $_SESSION['codigoperiodo_reporte'] . "' ".
                " and eg.idestudiantegeneral = e.idestudiantegeneral ".
                " and eg.numerodocumento = '" . $newArray[$i]['numerodocumento'] . "'";
                $rta_query = $sala->query($query);
                $row_query = $rta_query->fetchRow();
                if (!$row_query) {
                    $newArray[$i]['nombre'] = '<a href="../../prematricula/interesados/preinscripcion_seguimiento.php?link_origen=../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&idpreinscripcion=' . $newArray[$i]['idpreinscripcion'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=seguimiento">**' . $newArray[$i]['nombre'] . "</a>";
                }
            }else{
                @$newArray[$i]['nombre'] = '<a href="../../prematricula/interesados/preinscripcion_seguimiento.php?link_origen=../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&idpreinscripcion=' . $newArray[$i]['idpreinscripcion'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=seguimiento">--' . $newArray[$i]['nombre'] . "</a>";
            }
        }//for
        $_SESSION['array_sesion'] = $newArray;
    }//if

    if ($_SESSION['descriptor_reporte'] == 'Inscritos' or $_SESSION['descriptor_reporte'] == 'subtotal_Inscripciones'){
        $newArray = $_SESSION['array_sesion'];     
        for ($i = 0; $i < count($newArray); $i++) {
            if ($newArray[$i]['numerodocumento'] != ''){
                $numerodocumento = $newArray[$i]['numerodocumento'];            
                $query = "SELECT e.codigoestudiante,e.codigoperiodo,e.codigosituacioncarreraestudiante ".
                " FROM ordenpago o, detalleordenpago d, estudiante e, concepto co, estudiantegeneral eg ".
                " WHERE o.numeroordenpago=d.numeroordenpago AND e.codigoestudiante=o.codigoestudiante ".
                " AND d.codigoconcepto=co.codigoconcepto AND co.cuentaoperacionprincipal=151 ".
                " AND (o.codigoestadoordenpago LIKE '4%') ".
                " AND o.codigoperiodo='" . $_SESSION['codigoperiodo_reporte'] . "' ".
                " and eg.idestudiantegeneral = e.idestudiantegeneral ".
                " and eg.numerodocumento = '" . $newArray[$i]['numerodocumento'] . "'";
                $rta_query = $sala->query($query);
                $row_query = $rta_query->fetchRow();
                if (empty($row_query)){
                    if (!ereg(">", $newArray[$i]['numerodocumento'])) {
                        $newArray[$i]['numerodocumento'] = '<a href="../../prematricula/aspirante/aspiranteseguimiento.php?link_origen=../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&codigoestudiante=' . $newArray[$i]['codigoestudiante'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=pantallazo_estudiante&documentoingreso=' . $numerodocumento . '">' . $numerodocumento . '</a>';
                    }
                }
                if (!ereg(">", $newArray[$i]['nombre'])){
                    $newArray[$i]['nombre'] = '<a href="../../../../aspirantes/enlineacentral.php?link_origen=../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&codigoestudiante=' . $newArray[$i]['codigoestudiante'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=pantallazo_estudiante&documentoingreso=' . $numerodocumento . '">' . $newArray[$i]['nombre'] . '</a>';
                }
            }
     
            $query = "SELECT tp.nombretipoorigenpreinscripcion FROM preinscripcion pr, tipoorigenpreinscripcion tp ".
            " WHERE pr.numerodocumento ='" . $newArray[$i]['numerodocumento'] . "' ".
            " and pr.codigoperiodo ='" . $_SESSION['codigoperiodo_reporte'] . "'";
            $rta_query = $sala->query($query);
            $row_query = $rta_query->fetchRow();
            if (isset($row_query) && !empty($row_query)){
                $newArray[$i]['tipoorigenpreinscripcion'] = $row_query['nombretipoorigenpreinscripcion'];
            } else {
                $newArray[$i]['tipoorigenpreinscripcion'] = "No especificado";
            }
        }
        $_SESSION['array_sesion'] = $newArray;
    }

    if ($_SESSION['descriptor_reporte'] == 'Aspirantes' or $_SESSION['descriptor_reporte'] == 'subtotal_Aspirantes'){
        $newArray = $_SESSION['array_sesion'];
        for ($i = 0; $i < count($newArray); $i++) {
            $query = "SELECT tp.nombretipoorigenpreinscripcion FROM preinscripcion pr, tipoorigenpreinscripcion tp ".
            " WHERE pr.numerodocumento ='" . $newArray[$i]['numerodocumento'] . "' ".
            " and pr.codigoperiodo ='" . $_SESSION['codigoperiodo_reporte'] . "'";
            $rta_query = $sala->query($query);
            $row_query = $rta_query->fetchRow();
            if (isset($row_query) && !empty($row_query)) {
                $newArray[$i]['tipoorigenpreinscripcion'] = $row_query['nombretipoorigenpreinscripcion'];
            } else {
                $newArray[$i]['tipoorigenpreinscripcion'] = "No especificado";
            }
        }
        $_SESSION['array_sesion'] = $newArray;
    }

    if ($_SESSION['descriptor_reporte'] == 'MatriculadosNuevos' or $_SESSION['descriptor_reporte'] == 'subtotal_MatriculadosNuevos') 
    {    
        $newArray = $_SESSION['array_sesion'];
        for ($i = 0; $i < count($newArray); $i++) 
        {
            $query = "SELECT tp.nombretipoorigenpreinscripcion FROM preinscripcion pr, tipoorigenpreinscripcion tp ".
            " WHERE pr.numerodocumento ='" . $newArray[$i]['numerodocumento'] . "' ".
            " and pr.codigoperiodo ='" . $_SESSION['codigoperiodo_reporte'] . "'";
            $rta_query = $sala->query($query);
            $row_query = $rta_query->fetchRow();
            if (isset($row_query) && !empty($row_query)) {
                $newArray[$i]['tipoorigenpreinscripcion'] = $row_query['nombretipoorigenpreinscripcion'];
            } else {
                $newArray[$i]['tipoorigenpreinscripcion'] = "No especificado";
            }
        }
        $_SESSION['array_sesion'] = $newArray;
    }
    
    if ($_SESSION['descriptor_reporte'] == 'Admitidos_No_Matriculados' or $_SESSION['descriptor_reporte'] == 'subtotal_Admitidos_No_Matriculados'){
        $newArray = $_SESSION['array_sesion'];

        $k = 0;
        foreach ($newArray as $valores){
            $codigoEstudiante = $valores['codigoestudiante'];
            $query = "SELECT e.idestudiantegeneral,c.nombreciudad,c.idciudad ".
            " FROM estudiante e, estudiantegeneral eg,ciudad c ".
            " WHERE e.idestudiantegeneral = eg.idestudiantegeneral AND ".
            " c.idciudad = eg.ciudadresidenciaestudiantegeneral AND e.codigoestudiante=".$codigoEstudiante;
            $rta_query = $sala->query($query);
            $row_query = $rta_query->fetchRow();
            if (isset($row_query) && !empty($row_query)) {
                $newArray[$k]['ciudadresidencia'] = $row_query['nombreciudad'];
                $k++;
            }else{
                $newArray[$k]['ciudadresidencia'] ='No especificado';
            }
        }//foreach
        $_SESSION['array_sesion'] = $newArray;
    }
    $informe = new matriz($_SESSION['array_sesion'], $_SESSION['titulo'], "tabla_estadisticas_matriculas_detalle.php", "si", "si", "tabla_estadisticas_matriculas.php", "menu.php");

    if ($_SESSION['descriptor_reporte'] != 'Inscritos' and $_SESSION['descriptor_reporte'] != 'subtotal_Inscripciones'){
        if ($_SESSION['descriptor_reporte'] == 'Interesados' or $_SESSION['descriptor_reporte'] == 'subtotal_Interesados'){
            $informe->agregarllave_drilldown('emailestudiante', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'emailestudiante');
        }else if ($_SESSION['descriptor_reporte'] == 'Aspirantes' or
            $_SESSION['descriptor_reporte'] == 'subtotal_Aspirantes' or
            $_SESSION['descriptor_reporte'] == 'Inscritos' or
            $_SESSION['descriptor_reporte'] == 'subtotal_Inscripciones' or
            $_SESSION['descriptor_reporte'] == 'a_seguir_aspirantes_vs_inscritos' or
            $_SESSION['descriptor_reporte'] == 'subtotal_a_seguir_aspirantes_vs_inscritos' ||
            $_SESSION['descriptor_reporte'] == 'Admitidos_No_Matriculados'){
            $numerodocumento = $newArray[$i]['numerodocumento'];

            if ($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username'] == 'adminatencionusuario' or $_SESSION['MM_Username'] == 'admincredito'){
                $informe->agregarllave_drilldown('nombre', '../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../../../aspirantes/enlineacentral.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'numerodocumento', 'documentoingreso');
            }else{
                if (in_array($_SESSION['codigocarrera_reporte'], $arrayAcceso)){
                    $informe->agregarllave_drilldown('nombre', '../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../../../aspirantes/enlineacentral.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'numerodocumento', 'documentoingreso');
                }
            }
        }else{
            $_SESSION['descriptor_reporte'];
            if ($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username'] == 'adminatencionusuario' or $_SESSION['MM_Username'] == 'admincredito'){
                $informe->agregarllave_drilldown('nombre', '../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../prematricula/loginpru.php', 'pantallaestudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante');
            } else{
                if (in_array($_SESSION['codigocarrera_reporte'], $arrayAcceso)){
                    $informe->agregarllave_drilldown('nombre', '../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../prematricula/loginpru.php', 'pantallaestudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante');
                }
            }
        }
    }
    
    if ($_SESSION['descriptor_reporte'] != 'Inscritos' and $_SESSION['descriptor_reporte'] != 'subtotal_Inscripciones'){
        if ($_SESSION['sesioncodigoprocesovidaestudiante'] != 100){
            $informe->agregarllave_drilldown('numerodocumento', '../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../prematricula/aspirante/aspiranteseguimiento.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'numerodocumento', 'documentoingreso', "", "Seguimiento al aspirante");   
        }
    }

    if ($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username'] == 'adminatencionusuario' or $_SESSION['MM_Username'] == 'admincredito'){
        $informe->agregarllave_drilldown('email', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email');
        $informe->agregarllave_drilldown('email2', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email2');
    }else{
        if (in_array($_SESSION['codigocarrera_reporte'], $arrayAcceso)){
            $informe->agregarllave_drilldown('email', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email');
            $informe->agregarllave_drilldown('email2', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email2');
        }
    }
    $informe->mostrar();