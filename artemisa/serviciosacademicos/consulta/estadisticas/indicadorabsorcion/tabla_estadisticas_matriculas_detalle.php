<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
//require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time', '216000');
//print_r($_GET);
error_reporting(0);
?>
<?php

$rutaado = ("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
//require_once("funciones/obtener_datos.php");
//echo "DESCRIPTOR=".$_SESSION['descriptor_reporte'] ;
//echo "<pre>"; print_r($_SESSION['array_sesion']); echo "</pre>";
?>
<?php

//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
//echo ini_get('memory_limit');
//print_r( ini_get_all());
error_reporting(0);
$_SESSION['nombreprograma'] = "matriculaautomaticabusquedaestudiante.php";
if (!isset($_SESSION['array_sesion'])) {
    echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
    exit();
}
require_once("../../../funciones/clases/motor/motor.php");
?>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<?php

if (isset($_GET['codigoestudiante'])) {
    $_SESSION['estudiante'] = $_GET['codigoestudiante'];
}
?>
<?php

//echo "<h1>".count($_SESSION['array_sesion'])."</h1>";
//echo $_SESSION['MM_Username'];
error_reporting(2047);
$queryUsuarioFacultad = "SELECT uf.codigofacultad FROM usuariofacultad uf WHERE uf.usuario='" . $_SESSION['MM_Username'] . "'";
$usuarioFacultad = $sala->query($queryUsuarioFacultad);
$rowUsuarioFacultad = $usuarioFacultad->fetchRow();
do {
    $arrayAcceso[] = $rowUsuarioFacultad['codigofacultad'];
} while ($rowUsuarioFacultad = $usuarioFacultad->fetchRow());

//print_r($arrayAcceso);
if (isset($_REQUEST['Fecha_Proximo_Contacto'])) {
    if ($_REQUEST['Fecha_Proximo_Contacto'] != '') {
        $_SESSION['sesionFecha_Proximo_Contacto'] = $_REQUEST['Fecha_Proximo_Contacto'];
        $_SESSION['sesionf_Fecha_Proximo_Contacto'] = $_REQUEST['f_Fecha_Proximo_Contacto'];
        //$_SESSION['sesionFiltrar'] = $_REQUEST['Filtrar'];
    }
}
if (isset($_SESSION['sesionFecha_Proximo_Contacto'])) {
    //echo "LA CAR>GO";
    $_REQUEST['Fecha_Proximo_Contacto'] = $_SESSION['sesionFecha_Proximo_Contacto'];
    $_REQUEST['f_Fecha_Proximo_Contacto'] = $_SESSION['sesionf_Fecha_Proximo_Contacto'];
    //$_REQUEST['Filtrar'] = $_SESSION['sesionFiltrar'];
}
if ($_SESSION['descriptor_reporte'] == 'Interesados' or $_SESSION['descriptor_reporte'] == 'subtotal_Interesados') {
    //print_r($_REQUEST);
    $newArray = $_SESSION['array_sesion'];

    for ($i = 0; $i < count($newArray); $i++) {
        if (@$newArray[$i]['numerodocumento'] != '') {
            // Valida con el documento si el pelado tiene de inscripciï¿½n pa rriba en el perido
            $query = "SELECT e.codigoestudiante,e.codigoperiodo,e.codigosituacioncarreraestudiante
            FROM ordenpago o, detalleordenpago d, estudiante e, concepto co, estudiantegeneral eg
            WHERE o.numeroordenpago=d.numeroordenpago
            AND e.codigoestudiante=o.codigoestudiante
            AND d.codigoconcepto=co.codigoconcepto
            AND co.cuentaoperacionprincipal=153
            AND (o.codigoestadoordenpago LIKE '1%' or o.codigoestadoordenpago LIKE '4%')
            AND o.codigoperiodo='" . $_SESSION['codigoperiodo_reporte'] . "'
            and eg.idestudiantegeneral = e.idestudiantegeneral
            and eg.numerodocumento = '" . $newArray[$i]['numerodocumento'] . "'";
            $rta_query = $sala->query($query);
            $row_query = $rta_query->fetchRow();
            if (!$row_query) {
                $newArray[$i]['nombre'] = '<a href="../../prematricula/interesados/preinscripcion_seguimiento.php?link_origen=../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&idpreinscripcion=' . $newArray[$i]['idpreinscripcion'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=seguimiento">' . $newArray[$i]['nombre'] . "</a>";
            }
        } else {
            @$newArray[$i]['nombre'] = '<a href="../../prematricula/interesados/preinscripcion_seguimiento.php?link_origen=../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&idpreinscripcion=' . $newArray[$i]['idpreinscripcion'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=seguimiento">' . $newArray[$i]['nombre'] . "</a>";
        }
    }
    $_SESSION['array_sesion'] = $newArray;
}

//print_r($_SESSION);
//exit();
if ($_SESSION['descriptor_reporte'] == 'Inscritos' or $_SESSION['descriptor_reporte'] == 'subtotal_Inscripciones') {
    //print_r($_REQUEST);
    $newArray = $_SESSION['array_sesion'];

    for ($i = 0; $i < count($newArray); $i++) {
        if ($newArray[$i]['numerodocumento'] != '') {
            $numerodocumento = $newArray[$i]['numerodocumento'];
            // Valida con el documento si el pelado tiene de inscripcion pa rriba en el perido
            $query = "SELECT e.codigoestudiante,e.codigoperiodo,e.codigosituacioncarreraestudiante
            FROM ordenpago o, detalleordenpago d, estudiante e, concepto co, estudiantegeneral eg
            WHERE o.numeroordenpago=d.numeroordenpago
            AND e.codigoestudiante=o.codigoestudiante
            AND d.codigoconcepto=co.codigoconcepto
            AND co.cuentaoperacionprincipal=151
            AND (o.codigoestadoordenpago LIKE '4%')
            AND o.codigoperiodo='" . $_SESSION['codigoperiodo_reporte'] . "'
            and eg.idestudiantegeneral = e.idestudiantegeneral
            and eg.numerodocumento = '" . $newArray[$i]['numerodocumento'] . "'";
            $rta_query = $sala->query($query);
            $row_query = $rta_query->fetchRow();
            if (!$row_query) {
                if (!ereg(">", $newArray[$i]['numerodocumento']))
                // $newArray[$i]['numerodocumento'] = '<a href="https://artemisa.unbosque.edu.co/serviciosacademicos/consulta/prematricula/aspirante/aspiranteseguimiento.php?link_origen=../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&codigoestudiante='.$newArray[$i]['codigoestudiante'].'&codigofacultad='.$_SESSION['codigocarrera_reporte'].'&programausadopor=facultad&descriptor=pantallazo_estudiante&documentoingreso='.$numerodocumento.'">'.$numerodocumento.'</a>';
                    $newArray[$i]['numerodocumento'] = '<a href="../../prematricula/aspirante/aspiranteseguimiento.php?link_origen=../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&codigoestudiante=' . $newArray[$i]['codigoestudiante'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=pantallazo_estudiante&documentoingreso=' . $numerodocumento . '">' . $numerodocumento . '</a>';
            }
            if (!ereg(">", $newArray[$i]['nombre'])) {
                //$newArray[$i]['nombre'] = '<a href=" https://artemisa.unbosque.edu.co/aspirantes/enlineacentral.php?link_origen=../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&codigoestudiante='.$newArray[$i]['codigoestudiante'].'&codigofacultad='.$_SESSION['codigocarrera_reporte'].'&programausadopor=facultad&descriptor=pantallazo_estudiante&documentoingreso='.$numerodocumento.'">'.$newArray[$i]['nombre'].'</a>';
                $newArray[$i]['nombre'] = '<a href="../../../../aspirantes/enlineacentral.php?link_origen=../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php&codigoestudiante=' . $newArray[$i]['codigoestudiante'] . '&codigofacultad=' . $_SESSION['codigocarrera_reporte'] . '&programausadopor=facultad&descriptor=pantallazo_estudiante&documentoingreso=' . $numerodocumento . '">' . $newArray[$i]['nombre'] . '</a>';
            }
        }
        // Valida con el documento si el pelado tiene de inscripcion pa rriba en el perido
        $query = "SELECT tp.nombretipoorigenpreinscripcion
        FROM preinscripcion pr, tipoorigenpreinscripcion tp
        WHERE pr.numerodocumento ='" . $newArray[$i]['numerodocumento'] . "'
        and pr.codigoperiodo ='" . $_SESSION['codigoperiodo_reporte'] . "'";
        $rta_query = $sala->query($query);
        $row_query = $rta_query->fetchRow();
        if ($row_query) {
            // Entra la información de la preinscripcion
            $newArray[$i]['tipoorigenpreinscripcion'] = $row_query['nombretipoorigenpreinscripcion'];
        } else {
            $newArray[$i]['tipoorigenpreinscripcion'] = "No especificado";
        }
    }
    $_SESSION['array_sesion'] = $newArray;
}

if ($_SESSION['descriptor_reporte'] == 'Aspirantes' or $_SESSION['descriptor_reporte'] == 'subtotal_Aspirantes') {
    //print_r($_REQUEST);
    $newArray = $_SESSION['array_sesion'];
    for ($i = 0; $i < count($newArray); $i++) {

        // Valida con el documento si el pelado tiene de inscripcion pa rriba en el perido
        $query = "SELECT tp.nombretipoorigenpreinscripcion
            FROM preinscripcion pr, tipoorigenpreinscripcion tp
            WHERE pr.numerodocumento ='" . $newArray[$i]['numerodocumento'] . "'
            and pr.codigoperiodo ='" . $_SESSION['codigoperiodo_reporte'] . "'";
        $rta_query = $sala->query($query);
        $row_query = $rta_query->fetchRow();
        if ($row_query) {
            // Entra la información de la preinscripcion
            $newArray[$i]['tipoorigenpreinscripcion'] = $row_query['nombretipoorigenpreinscripcion'];
        } else {
            $newArray[$i]['tipoorigenpreinscripcion'] = "No especificado";
        }
    }
    $_SESSION['array_sesion'] = $newArray;
}

if ($_SESSION['descriptor_reporte'] == 'MatriculadosNuevos' or $_SESSION['descriptor_reporte'] == 'subtotal_MatriculadosNuevos') {
    //print_r($_REQUEST);
    $newArray = $_SESSION['array_sesion'];
    for ($i = 0; $i < count($newArray); $i++) {

        // Valida con el documento si el pelado tiene de inscripcion pa rriba en el perido
        $query = "SELECT tp.nombretipoorigenpreinscripcion
            FROM preinscripcion pr, tipoorigenpreinscripcion tp
            WHERE pr.numerodocumento ='" . $newArray[$i]['numerodocumento'] . "'
            and pr.codigoperiodo ='" . $_SESSION['codigoperiodo_reporte'] . "'";
        $rta_query = $sala->query($query);
        $row_query = $rta_query->fetchRow();
        if ($row_query) {
            // Entra la información de la preinscripcion
            $newArray[$i]['tipoorigenpreinscripcion'] = $row_query['nombretipoorigenpreinscripcion'];
        } else {
            $newArray[$i]['tipoorigenpreinscripcion'] = "No especificado";
        }
    }
    $_SESSION['array_sesion'] = $newArray;
}

$informe = new matriz($_SESSION['array_sesion'], $_SESSION['titulo'], "tabla_estadisticas_matriculas_detalle.php", "si", "si", "tabla_estadisticas_matriculas.php", "menu.php");

if ($_SESSION['descriptor_reporte'] != 'Inscritos' and $_SESSION['descriptor_reporte'] != 'subtotal_Inscripciones') {
    if ($_SESSION['descriptor_reporte'] == 'Interesados' or $_SESSION['descriptor_reporte'] == 'subtotal_Interesados') {
        //echo $_SESSION['descriptor_reporte']."==".'Interesados'." or ".$_SESSION['descriptor_reporte']."==".'subtotal_Interesados';
        //if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
        /* $newArray = $_SESSION['array_sesion'];

          $informe->matriz = $newArray; */
        //$informe->agregarllave_drilldown('nombre','../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php',"seguimiento",'idpreinscripcion','','','','','','');
        $informe->agregarllave_drilldown('emailestudiante', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'emailestudiante');
        //}
        //else{
        //if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
        //$informe->agregarllave_drilldown('nombre','../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/interesados/preinscripcion_seguimiento.php',"seguimiento",'idpreinscripcion','','','','','','');
        //$informe->agregarllave_drilldown('emailestudiante','tabla_estadisticas_matriculas.php','../../prematricula/loginpru.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'codigoestudiante','estudiante','emailestudiante');
        //}
        //}
    } elseif ($_SESSION['descriptor_reporte'] == 'Aspirantes' or $_SESSION['descriptor_reporte'] == 'subtotal_Aspirantes' or $_SESSION['descriptor_reporte'] == 'Inscritos' or $_SESSION['descriptor_reporte'] == 'subtotal_Inscripciones' or $_SESSION['descriptor_reporte'] == 'a_seguir_aspirantes_vs_inscritos' or $_SESSION['descriptor_reporte'] == 'subtotal_a_seguir_aspirantes_vs_inscritos' or $_SESSION['Admitidos_No_Matriculados']) {
        $numerodocumento = $newArray[$i]['numerodocumento'];
        if ($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username'] == 'adminatencionusuario' or $_SESSION['MM_Username'] == 'admincredito') {
            $informe->agregarllave_drilldown('nombre', '../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../../../aspirantes/enlineacentral.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'numerodocumento', 'documentoingreso');
        } else {
            if (in_array($_SESSION['codigocarrera_reporte'], $arrayAcceso)) {
                $informe->agregarllave_drilldown('nombre', '../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../../../aspirantes/enlineacentral.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'numerodocumento', 'documentoingreso');
            }
        }
    } else {
        if ($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username'] == 'adminatencionusuario' or $_SESSION['MM_Username'] == 'admincredito') {
            $informe->agregarllave_drilldown('nombre', '../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../prematricula/loginpru.php', 'pantallaestudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante');
        } else {
            if (in_array($_SESSION['codigocarrera_reporte'], $arrayAcceso)) {
                $informe->agregarllave_drilldown('nombre', '../../estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../prematricula/loginpru.php', 'pantallaestudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante');
            }
        }
    }
}
/* else
  {
  if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito')
  {
  $informe->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
  }
  else
  {
  if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
  $informe->agregarllave_drilldown('nombre','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../../../aspirantes/enlineacentral.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso');
  }
  }
  } */
//if ($_SESSION['descriptor_reporte']<>"Interesados" and $_SESSION['descriptor_reporte']=="Aspirantes" or  $_SESSION['descriptor_reporte']=="a_seguir_aspirantes_vs_inscritos" or $_SESSION['descriptor_reporte']=="Inscritos" or $_SESSION['descriptor_reporte']=="Prematriculados" or $_SESSION['descriptor_reporte']=="Noprematriculados")
//{
//if($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username']=='adminatencionusuario' or $_SESSION['MM_Username']=='admincredito'){
//if($_SESSION['ciclocontacto'])
if ($_SESSION['descriptor_reporte'] != 'Inscritos' and $_SESSION['descriptor_reporte'] != 'subtotal_Inscripciones') {
    if ($_SESSION['sesioncodigoprocesovidaestudiante'] != 100)
        $informe->agregarllave_drilldown('numerodocumento', '../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php', '../../prematricula/aspirante/aspiranteseguimiento.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'numerodocumento', 'documentoingreso', "", "Seguimiento al aspirante");
}

//}
/* else{
  if(in_array($_SESSION['codigocarrera_reporte'],$arrayAcceso)){
  $informe->agregarllave_drilldown('numerodocumento','../serviciosacademicos/consulta/estadisticas/matriculas/tabla_estadisticas_matriculas_detalle.php','../../prematricula/aspirante/aspiranteseguimiento.php','pantallazo_estudiante','codigoestudiante',"codigofacultad=".$_SESSION['codigocarrera_reporte']."&programausadopor=facultad",'numerodocumento','documentoingreso',"","Seguimiento al aspirante");
  }
  } */
//}

if ($_SESSION['MM_Username'] == 'admintecnologia' or $_SESSION['MM_Username'] == 'escobarcarlosf' or $_SESSION['MM_Username'] == 'adminatencionusuario' or $_SESSION['MM_Username'] == 'admincredito') {
    $informe->agregarllave_drilldown('email', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email');
    $informe->agregarllave_drilldown('email2', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email2');
} else {
    if (in_array($_SESSION['codigocarrera_reporte'], $arrayAcceso)) {
        $informe->agregarllave_drilldown('email', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email');
        $informe->agregarllave_drilldown('email2', 'tabla_estadisticas_matriculas.php', '../../prematricula/loginpru.php', 'pantallazo_estudiante', 'codigoestudiante', "codigofacultad=" . $_SESSION['codigocarrera_reporte'] . "&programausadopor=facultad", 'codigoestudiante', 'estudiante', 'email2');
    }
}

//echo "<pre>"; print_r($_SESSION['array_sesion']); echo "</pre>";
//exit();
$informe->mostrar();
//echo "sdasdadasdasdsad".$_SESSION['sesioncodigoprocesovidaestudiante']."";
?>

