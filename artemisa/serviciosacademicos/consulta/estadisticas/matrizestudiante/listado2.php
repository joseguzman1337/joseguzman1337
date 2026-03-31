<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if(isset($_REQUEST['formato'])) {
    $formato = $_REQUEST['formato'];
    $formato = 'xls';
    $nombrearchivo = "matrizEstudiante";
    switch ($formato) {
        case 'xls' :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo.".xls";
            break;
        case 'doc' :
            $strType = 'application/msword';
            $strName = $nombrearchivo.".doc";
            break;
        case 'txt' :
            $strType = 'text/plain';
            $strName = $nombrearchivo.".txt";
            break;
        case 'csv' :
            $strType = 'text/plain';
            $strName = $nombrearchivo.".csv";
            break;
        case 'xml' :
            $strType = 'text/plain';
            $strName = $nombrearchivo.".xml";
            break;
        default :
            $strType = 'application/msexcel';
            $strName = $nombrearchivo.".xls";
            break;
    }
    header("Content-Type: $strType");
    header("Content-Disposition: attachment; filename=$strName\r\n\r\n");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //header("Cache-Control: no-store, no-cache");
    header("Pragma: public");

    echo $_SESSION['sesion_matrizEstudiante'];

    exit();
}
//echo date("H:i:s")."<br>";
$horainicial=mktime(date("H"),date("i"),date("s"));

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/sala/nota/nota.php');
require_once("EstadisticoEstudiante.php");
require_once("FiltroEstudiante2.php");
ini_set('max_execution_time','6000');
ini_set("memory_limit","120M");

$objetobase = new BaseDeDatosGeneral($sala);
$db = $objetobase->conexion;

require_once("MatrizEstudiante.php");
$codigocarrera = $_REQUEST['nacodigocarrera'];
$codigoperiodo = "20092";
$codigomodalidadacademicasic = $_REQUEST['nacodigomodalidadacademicasic'];
//$codigomodalidadacademicasic = "";
$codigoareadisciplinar = $_REQUEST['nacodigoareadisciplinar'];
$codigofacultad2 = $_REQUEST['nacodigofacultad'];
$matrizEstudiante = new MatrizEstudiante($codigocarrera, $codigoperiodo, $codigomodalidadacademicasic, $codigoareadisciplinar, $codigofacultad2);

$objestadisitico = new EstadisticoEstudiante($codigoperiodo,$objetobase);

if(isset($_SESSION['debug_sesion'])) {
    $db->debug = true;
}
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
//ob_start();
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Matriz Estudiante</title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
        <script type="text/javascript">
            function getElementsByAttribute(oElm, strTagName, strAttributeName, strAttributeValue){
                var arrElements = (strTagName == "*" && oElm.all)? oElm.all : oElm.getElementsByTagName(strTagName);
                var arrReturnElements = new Array();
                var oAttributeValue = (typeof strAttributeValue != "undefined")? new RegExp("(^|\\s)" + strAttributeValue + "(\\s|$)") : null;
                var oCurrent;
                var oAttribute;
                for(var i=0; i<arrElements.length; i++){
                    oCurrent = arrElements[i];
                    oAttribute = oCurrent.getAttribute && oCurrent.getAttribute(strAttributeName);
                    if(typeof oAttribute == "string" && oAttribute.length > 0){
                        if(typeof strAttributeValue == "undefined" || (oAttributeValue && oAttributeValue.test(oAttribute))){
                            arrReturnElements.push(oCurrent);
                        }
                    }
                }
                return arrReturnElements;
            }

            function ocultarTodos() {
                var elementosTodos = getElementsByAttribute(document.body,"div","title");
                for (i = 0; i < elementosTodos.length; i++) {
                    elementosTodos[i].style.visibility = 'hidden'
                }
            }

            function ocultarEspera() {
                document.getElementById('carguediv').style.visibility = 'hidden';
            }

            function activarPorcentajeNivelAcademico(nivel) {
                var elementosNivel = getElementsByAttribute(document.body,"div","title", "porcentajenivel"+nivel);
                ocultarTodos();
                for (i = 0; i < elementosNivel.length; i++) {
                    elementosNivel[i].style.visibility = 'visible'
                }
            }
        </script>
    </head>
    <body>
        <div id='carguediv' style='position:absolute; left:300px; top:350px; width:209px; height:34px; z-index:1; visibility: visible;  background-color: #FFFFFF; layer-background-color: #E9E9E9;'>
            <table width='300' border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
                <tr>
                    <td><img  src="../../facultades/imagesAlt2/cargando.gif" name="cargando"></td>
                </tr>
                <tr>
                    <td>Por favor espere, este proceso puede durar varios segundos...</td>
                </tr>
            </table>
        </div>
        <h1>Matriz de Estudiantes por Area Disciplinar</h1>
        <?php
        filtro($matrizEstudiante->filtroCarreras);
        ob_flush();
        flush();
        ob_end_clean();
        if(isset($_REQUEST['naenviar'])) {
        //$listaEstratos = $matrizEstudiante->getListaEstratos();
        //$arrayEstrato = $objestadisitico->rangoEstrato($codigomodalidadacademicasic);
            if(isset($_REQUEST['nacampoformulario'])) {
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                    $listaEstratos = $matrizEstudiante->getListaEstratos();
                    $arrayEstrato = $objestadisitico->rangoEstrato($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesEstrato = $objestadisitico->porcentajesTotalesArea("rangoEstrato", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                    $listaEdades = $matrizEstudiante->getListaEdades();
                    $arrayEdad = $objestadisitico->rangoEdad($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesEdad = $objestadisitico->porcentajesTotalesArea("rangoEdad", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario']) ) {
                    $listaGeneros = $matrizEstudiante->getListaGeneros();
                    $arrayGenero = $objestadisitico->rangoGenero($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesGenero = $objestadisitico->porcentajesTotalesArea("rangoGenero", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario']) ) {
                    $listaNivelesEducativos = $matrizEstudiante->getListaNivelesEducativos();
                    $arrayNivelEducativo = $objestadisitico->rangoNivelEducacion($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesNivelEducativo = $objestadisitico->porcentajesTotalesArea("rangoNivelEducacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario']) ) {
                    $listaPuestoIcfes = $matrizEstudiante->getListaPuestoIcfes();
                    $arrayPuestoIcfes = $objestadisitico->rangoPuestoIcfes($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesPuestoIcfes = $objestadisitico->porcentajesTotalesArea("rangoPuestoIcfes", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario']) ) {
                    $listaNacionalidad= $matrizEstudiante->getListaNacionalidad();
                    $arrayNacionalidad = $objestadisitico->rangoNacionalidad($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesNacionalidad = $objestadisitico->porcentajesTotalesArea("rangoNacionalidad", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionAcademica = $matrizEstudiante->getListaParticipacionAcademica();
                    $arrayParticipacionAcademica = $objestadisitico->rangoParticipacionAcademica($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesParticipacionAcademica = $objestadisitico->porcentajesTotalesArea("rangoParticipacionAcademica", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionInvestigacion = $matrizEstudiante->getListaParticipacionInvestigacion();
                    $arrayParticipacionInvestigacion = $objestadisitico->rangoLineaInvestigacion($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesParticipacionInvestigacion = $objestadisitico->porcentajesTotalesArea("rangoLineaInvestigacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario']) ) {
                    $listaProyeccionSocial = $matrizEstudiante->getListaProyeccionSocial();
                    $arrayProyeccionSocial = $objestadisitico->rangoProyeccionSocial($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesProyeccionSocial = $objestadisitico->porcentajesTotalesArea("rangoProyeccionSocial", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionBienestar = $matrizEstudiante->getListaParticipacionBienestar();
                    $arrayParticipacionBienestar = $objestadisitico->rangoParticipacionBienestar($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesParticipacionBienestar = $objestadisitico->porcentajesTotalesArea("rangoParticipacionBienestar", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionGobierno = $matrizEstudiante->getListaParticipacionGobierno();
                    $arrayParticipacionGobierno = $objestadisitico->rangoParticipacionGobierno($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesParticipacionGobierno = $objestadisitico->porcentajesTotalesArea("rangoParticipacionGobierno", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociacion',$_REQUEST['nacampoformulario']) ) {
                    $listaAsociacion = $matrizEstudiante->getListaAsociacion();
                    $arrayAsociacion = $objestadisitico->rangoAsociacion($codigomodalidadacademicasic);
                    $totalesAsociacion = $objestadisitico->porcentajesTotalesArea("rangoAsociacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionGestion = $matrizEstudiante->getListaParticipacionGestion();
                    $arrayParticipacionGestion = $objestadisitico->rangoParticipacionGestion($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesParticipacionGestion = $objestadisitico->porcentajesTotalesArea("rangoParticipacionGestion", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario']) ) {
                    $listaReconocimiento = $matrizEstudiante->getListaReconocimiento();
                    $arrayReconocimiento = $objestadisitico->rangoReconocimiento($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesReconocimiento = $objestadisitico->porcentajesTotalesArea("rangoReconocimiento", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario']) ) {
                    $listaTipoFinanciacion = $matrizEstudiante->getListaTipoFinanciacion();
                    $arrayTipoFinanciacion = $objestadisitico->rangoTipoFinanciacion($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesTipoFinanciacion = $objestadisitico->porcentajesTotalesArea("rangoTipoFinanciacion", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario']) ) {
                    $listaEstadoEstudiante = $matrizEstudiante->getListaEstadoEstudiante();
                    $arrayEstadoEstudiante = $objestadisitico->rangoEstadoEstudiante($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);
                    $totalesEstadoEstudiante = $objestadisitico->porcentajesTotalesArea("rangoEstadoEstudiante", "");
                }
                $listaHistoricoEstudiante = $matrizEstudiante->getListaHistoricoEstudiante();
                $arrayHistoricoEstudiante = $objestadisitico->historicoEstudiante($codigomodalidadacademicasic, $codigocarrera, $codigofacultad2, $codigoareadisciplinar);

                $totalQuienesSon = count($listaEstratos) + count($listaEdades) + count($listaGeneros) + count($listaNivelesEducativos) + count($listaPuestoIcfes);
                $totalDeDondeProvienen = count($listaNacionalidad);

                $totalTipoDeActividad = count($listaParticipacionAcademica) + count($listaParticipacionInvestigacion) + count($listaProyeccionSocial) + count($listaParticipacionBienestar) + count($listaParticipacionGobierno) + count($listaAsociacion) + count($listaParticipacionGestion);

                $totalReconocimientos = count($listaReconocimiento);

                $totalFinanciacion = count($listaTipoFinanciacion);
            }
    /*$horafinal=mktime(date("H"),date("i"),date("s"));
    echo date("H:i:s")."<br>";
    echo "<br>Diferencia Arreglos=".($horafinal-$horainicial)."<br>";*/
        }
        //$totalFinanciacion = count($listaTipoFinanciacion);
        //$objestadisitico->rangoHistorico($codigomodalidadacademicasic);

        if(isset($_REQUEST['naenviar'])) {
            ?>
        <!--<input type="button" value="Quitar Procentaje" onclick="ocultarTodos()">-->
        <form method="post" action="" name="f2">
            <input type="submit" value="Exportar a Excel" name="formato" />
        </form>
            <?php
            ob_start();
            ?>
        <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
            <!--<thead style="font-weight:bold;">-->
            <tr align="center" id="trtitulogris">
                <td colspan="5">
                    <b>MATRIZ DE INFORMACI&Oacute;N ESTAD&Iacute;STICA I</b>
                </td>
                    <?php
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])  || in_array('genero',$_REQUEST['nacampoformulario'])
                        || in_array('niveleducativo',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])
                        || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalQuienesSon+$totalDeDondeProvienen;?>">
                    CARACTER&Iacute;STICAS DEMOGR&Aacute;FICAS
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])
                        || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])  || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])
                        || in_array('participacionbienestar',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])
                        || in_array('asociacion',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalTipoDeActividad; ?>">
                    ACTIVIDADES DEL ESTUDIANTE
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalReconocimientos;?>">
                    EST&Iacute;MULOS, RECONOCIMIENTOS Y DISTINCIONES
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalFinanciacion;?>">
                    FINANCIACI&Oacute;N
                </td>
                <!--<td colspan="2">
                    BENEFICIARIOS DE BECAS Y EST&Iacute;MULOS
                </td>-->
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="2">
                    PROGRAMA DE ACOMPA&Ntilde;AMIENTO ESTUDIANTIL
                </td>
                    <?php
                    }
                    ?>
                <!--<td colspan="7"><br></td>-->
            </tr>
            <tr align="center">
                <td rowspan="5">
                    <b>TOTAL ESTUDIANTES</b>
                </td>
                <td rowspan="5">
                    <b>&Aacute;REA DISCIPLINAR</b>
                </td>
                <td rowspan="5">
                    <b>FACULTAD</b>
                </td>
                <td rowspan="5">
                    <b>NIVEL ACAD&Eacute;MICO</b>
                </td>
                <td rowspan="5">
                    <b>PROGRAMAS</b>
                </td>
                    <?php
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])  || in_array('genero',$_REQUEST['nacampoformulario'])
                        || in_array('niveleducativo',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalQuienesSon; ?>">
                    <b>&iquest;QU&Iacute;ENES SON?</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalDeDondeProvienen; ?>">
                    <b>&iquest;DE D&Oacute;NDE PROVIENEN?</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])
                        || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])  || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])
                        || in_array('participacionbienestar',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])
                        || in_array('asociacion',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalTipoDeActividad; ?>">
                    <b>TIPO DE ACTIVIDAD</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalReconocimientos;?>">
                    <b>CATEGOR&Iacute;A</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalFinanciacion;?>">
                    <b>TIPO DE FINANCIACI&Oacute;N</b>
                </td>
                <!--<td colspan="2">
                    <b>TIPO DE BENEFICIO</b>
                </td>-->
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="2">
                    <b>ESTADO DEL ESTUDIANTE</b>
                </td>
                    <?php
                    }
                    ?>
               <!-- <td colspan="7"><br></td> -->
            </tr>
            <tr id="trtitulogris">
                    <?php
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaEstratos); ?>" rowspan="2">
                    <b>ESTRATO AL QUE PERTENECE</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaEdades); ?>" rowspan="2">
                    <b>RANGO DE EDAD</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaGeneros); ?>" rowspan="2">
                    <b>G&Eacute;NERO</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaNivelesEducativos); ?>" rowspan="2">
                    <b>NIVEL EDUCATIVO</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaPuestoIcfes); ?>" rowspan="2">
                    <b>PUESTO ICFES</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaNacionalidad); ?>" rowspan="2">
                    <b>NACIONALIDAD</b>
                </td>
                <!-- <td colspan="5" rowspan="2">
                    <b>REGI&Oacute;N DE PROCEDENCIA</b>
                </td> -->
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionAcademica); ?>" rowspan="2">
                    <b>Acad&eacute;micas</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionInvestigacion); ?>" rowspan="2">
                    <b>Investigativas</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaProyeccionSocial); ?>" rowspan="2">
                    <b>Proyecci&oacute;n Social</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionBienestar); ?>" rowspan="2">
                    <b>Bienestar Universitario</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionGobierno); ?>" rowspan="2">
                    <b>Gobierno Universitario</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociacion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaAsociacion); ?>" rowspan="2">
                    <b>Asociaciones estudiantiles</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionGestion); ?>" rowspan="2">
                    <b>Gesti&oacute;n universitaria</b>
                </td>
                    <?php
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaReconocimiento,'rowspan="4"');
                    }
                    ?>
                <!--<td colspan="4" rowspan="4">EST&Iacute;MULOS</td>
                <td colspan="4" rowspan="4">RECONOCIMIENTOS</td>
                <td rowspan="4">DISTINCIONES</td>-->
                    <?php
                    /**
                     * Tipo Financiacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaTipoFinanciacion,'rowspan="4"');
                    }
                    /**
                     * Estado estudiante
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaEstadoEstudiante,'rowspan="4"');
                    }
                    ?>
                <!--<td rowspan="4">Universidad el Bosque</td>
                <td rowspan="4">ICETEX</td>
                <td rowspan="4">Otras Entidades</td>
                <td rowspan="4">Becas</td>
                <td rowspan="4">Est&iacute;mulos</td>
                <td rowspan="4">Estudiantes en acompa&ntilde;amiento</td>
                <td rowspan="4">Estudiante en situaci&oacute;n acad&eacute;mica normal</td>
                <td colspan="7"><br></td>-->
            </tr>
            <tr>
                <td></td>
            </tr>
            <tr>
                    <?php
                    /********
                     *  NOMBRES
                     */

                    /**
                     * Estrato
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaEstratos,'rowspan="2"');
                    }
                    ?>
                <!--<td rowspan="2">Estrato 6</td>
                <td rowspan="2">Estrato 5</td>
                <td rowspan="2">Estrato 4</td>
                <td rowspan="2">Estrato 3</td>
                <td rowspan="2">Estrato 2</td>
                <td rowspan="2">Estrato 1</td>
                <td rowspan="2">No Aplica</td>
                <td rowspan="2">No Registra</td>-->
                    <?php
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaEdades,'rowspan="2"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaGeneros,'rowspan="2"');
                    }
                    ?>
                <!--<td rowspan="2">Masculino</td>
                <td rowspan="2">Femenino</td>
                <td rowspan="2">Otro</td>-->
                    <?php
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaNivelesEducativos,'rowspan="2"');
                    }
                    ?>
                <!-- <td rowspan="2">No diligencia</td>
                <td rowspan="2">Primaria</td>
                <td rowspan="2">Secundaria</td>
                <td rowspan="2">Educaci&oacute;n continuada</td>
                <td rowspan="2">T&eacute;cnico</td>
                <td rowspan="2">Universitario</td>-->
                    <?php
                    /**
                     * Puesto Icfes
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaPuestoIcfes,'rowspan="2"');
                    }
                    ?>
                <!--<td rowspan="2">No registra</td>
                <td rowspan="2">1 - 199</td>
                <td rowspan="2">200 - 499</td>
                <td rowspan="2">500 - 799</td>
                <td rowspan="2">800 - 1000</td>
                <td rowspan="2">Mayor a 1000</td>-->
                    <?php
                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaNacionalidad,'rowspan="2"');
                    }
                    ?>
                <!-- <td rowspan="2">Nacionales</td>
                <td rowspan="2">Extranjeros</td> -->
                    <?php
                    // Región
                    ?>
                <!-- <td rowspan="2">Andina</td>
                <td rowspan="2">Pac&iacute;fica</td>
                <td rowspan="2">Oinoqu&iacute;a</td>
                <td rowspan="2">Atl&aacute;ntica</td>
                <td rowspan="2">Amazon&iacute;a</td> -->
                    <?php
                    /**
                     * Participación Académica
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaParticipacionAcademica,'rowspan="2"');
                    }
                    ?>
                <!-- <td rowspan="2">Prog. de intercambio</td>
                <td rowspan="2">Congresos</td>
                <td rowspan="2">Seminarios</td>
                <td rowspan="2">Talleres</td>
                <td rowspan="2">Diplomados</td>
                <td rowspan="2">Cursos de actualizaci&oacute;n</td>
                <td rowspan="2">Concursos y ferias</td>
                <td rowspan="2">Prácticas y Observatorios Laborales</td>
                <td rwspan="2">Actividades Culturales</td>-->
                    <?php
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaParticipacionInvestigacion,'rowspan="2"');
                    }
                    ?>
                <!--<td rowspan="2">Semilleros</td>
                <td rwspan="2">Actividades Culturales</td>-->
                    <?php
                    /**
                     * Proyección social
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaProyeccionSocial,'rowspan="2"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaParticipacionBienestar,'rowspan="2"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaParticipacionGobierno,'rowspan="2"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaAsociacion,'rowspan="2"');
                    }
                    /**
                     * Participación Gestión
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaParticipacionGestion,'rowspan="2"');
                    }
                    ?>
                <!--<td rowspan="2">soluciones a problematicas comunidades</td>
                <td rowspan="2">Procesos de docencia y pedagogia</td>
                <td rowspan="2">Salud Comunitaria</td>
                <td rowspan="2">Talleres de Liderazgo</td>
                <td rowspan="2">Culturales</td>
                <td rowspan="2">Deportivas</td>
                <td rowspan="2">Salud</td>-->

                <!--<td rowspan="2">Consejo de Facultad</td>
                <td rowspan="2">Consejo Academico</td>
                <td rowspan="2">Consejo Directivo</td>
                <td rowspan="2">Redes</td>
                <td rowspan="2">Asociaciones</td>
                <td rowspan="2">Bienestar Universitario</td>
                <td rowspan="2">Museo de Ciencias</td>
                <td rowspan="2">Mercadeo</td>-->
                    <?php
                    /**
                     * Historico
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaHistoricoEstudiante); ?>"><b>DATOS HIST&Oacute;RICOS</b></td>
                    <?php
                    }
                    ?>
            </tr>
            <tr>
                    <?php
                    /**
                     * Historico
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTD($listaHistoricoEstudiante,'rowspan="3"');
                    }
                    ?>
            </tr>
           <!-- </thead>-->
            <!--<tbody style="height:400px; overflow-y:auto; overflow-x:hidden;">-->
                <?php
                //$matrizEstudiante->obtenerDatosEnLinea = true;
                //$db->debug = true;
            /*$arrayTabla[0]['TOTAL ESTUDIANTES'] = $matrizEstudiante->getTotalEstudiantesMatriculados();
            $arrayTabla[1]['NIVEL ACADÉMICO'] = $matrizEstudiante->getArrayNivelAcademico();
            $selNiveles = $matrizEstudiante->getSelNivelAcademico();
            $arrayAreaDisciplinar = $matrizEstudiante->getArrayAreaDisciplinar();
            */
                //$arrayIzquierda = $matrizEstudiante->getMatrizIzquierda();
                $selEsqueletoIzquierda = $matrizEstudiante->selEsqueletoMatrizIzquierda2();
                //echo "<pre>"; print_r($selEsqueletoIzquierda); echo "</pre>";
                //exit();
                $arrayAreas = $selEsqueletoIzquierda['areas'];
                $totalEstudiantes = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo(""));
                ?>
            <tr align="right">
                <td rowspan="500" valign="top"><?php echo $totalEstudiantes; ?></td>
            <tr>
                <td colspan="4" align="center" bgcolor="#FFEE53"> % por Total Estudiantes</td>
                    <?php
                    /**
                     * POR TOTAL ESTUDIANTES
                     */
                    /**
                     * Estrato
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Puesto Icfes
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }

                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Académica
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Proyección social
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Gestión
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }

                    /**
                     * Financiacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }

                    /**
                     * Estado estudiante
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante['totalesfinal'], $totalEstudiantes, ' bgcolor="#FFEE53"');
                    }

                        /*if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                            if(is_array($listaHistoricoEstudiante))
                                foreach($listaHistoricoEstudiante as $llave=>$valor) {
                                ?>

                <td bgcolor="White">&nbsp;</td>
                            <?php
                                }
                        }*/
                    ?>
            </tr>
                <?php
                foreach($arrayAreas as $key_codigoareadisciplinar => $row_Area) {
                //$selEsqueletoAreaDisciplinar = $matrizEstudiante->selEsqueletoAreaDisciplinar($row_EsqueletoIzquierda['codigomodalidadacademicasic']);
                //$totalRows_Areas = $selEsqueletoAreaDisciplinar->RecordCount();

                    $entro = false;
                    //$entro = true;
                    $rowspannivel = " rowspan='4'";
                    //$rowspannivel = "";
                    //$rowspannivel = " rowspan='2'";
                    //$matrizEstudiante->setArrayMatrizIzquierda($row_EsqueletoIzquierda['codigomodalidadacademicasic']);
                    //print_r($matrizEstudiante->arrayMatrizIzquierda);
                    //exit();

                    if($row_Area['totalfacultades'] > 0) {
                        $rowspannivel = ' rowspan="'.($row_Area['totalfacultades']+$row_Area['totalniveles']+$row_Area['totalcarreras']+1).'"';
                    }
                    else {
                        echo "</tr><tr>";
                        $entro = true;
                    // bgcolor='#7EBAFF'
                    }
                    $totalArea = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo("","","",$key_codigoareadisciplinar));
                    ?>
            <td<?php echo $rowspannivel; ?> valign="top" onclick="activarPorcentajeNivelAcademico('<?php echo $row_EsqueletoIzquierda['codigomodalidadacademicasic'];?>')">
                <table border="0" width="100%">
                    <tr>
                        <td align="left"><?php echo $totalArea; ?></td>
                        <td align="right"><?php echo $row_Area['nombreareadisciplinar']; ?></td>
                    </tr>
                </table></td>
                    <?php
                    if(!$entro) {
                        ?>
            <!--<tr>-->
                    <?php
                    //continue;
                    }
                    ?>
            <td colspan="3" align="center" bgcolor="#7EBAFF"> % por Area Disciplinar</td>
                    <?php
                    /**
                     * POR AREA DISCIPLINAR
                     */
                    /**
                     * Estrato
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Puesto Icfes
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }

                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Participación Académica
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Proyección social
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Participación Gestión
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }

                    /**
                     * Financiacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }

                    /**
                     * Estado estudiante
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante[$key_codigoareadisciplinar]['arraytotales'], $totalArea, ' bgcolor="#7EBAFF"');
                    }

                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        if(is_array($listaHistoricoEstudiante))
                            foreach($listaHistoricoEstudiante as $llave=>$valor) {
                                ?>

            <td bgcolor="White">&nbsp;</td>
                            <?php
                            }
                    }
                    ?>
        </tr>
                <?php
                //continue;
                // Facultades
                //$db->debug = true;
                $arrayFacultades = $row_Area['facultades'];
                foreach($arrayFacultades as $key_codigofacultad => $row_Facultades) {
                    $rowspannivel = "";
                    $entro2 = false;
                    if($entro)
                        $rowspannivel = " rowspan='3'";
                    $nuevafila = "";

                    if($row_Facultades['totalniveles'] > 0) {
                        $rowspannivel = ' rowspan="'.($row_Facultades['totalniveles']+$row_Facultades['totalcarreras']+1).'"';
                    }
                    else {
                        $rowspannivel = " rowspan='3'";
                        //$rowspannivel = "";
                        $entro2 = true;
                    }
                    echo $nuevafila;

                    $totalFacultades = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo("", "", $key_codigofacultad, $key_codigoareadisciplinar));
                    ?>
        <td<?php echo $rowspannivel; ?> valign="top">
            <table border="0" width="100%">
                <tr>
                    <td align="left"><?php echo $totalFacultades; ?></td>
                    <td align="right"><?php echo $row_Facultades['nombrefacultad']; ?></td>
                </tr>
            </table>
        </td>
                    <?php
                    if($entro && $nuevafila == "" || $entro2) {
                        ?>
       <!-- <tr> -->
                    <?php
                    }
                    else {
                        ?>
       <!-- <tr> -->
                    <?php
                    }

                    ?>
        <td align="center" colspan="2" bgcolor="#97D9FF"> % por Facultad</td>
                    <?php
                    /**
                     * POR FACULTADES
                     */
                    /**
                     * Estrato
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Puesto Icfes
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }

                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Participación Académica
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Proyección social
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Participación Gestión
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }

                    /**
                     * Financiacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }

                    /**
                     * Estado estudiante
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['arraytotales'], $totalFacultades, ' bgcolor="#97D9FF"');
                    }

                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        if(is_array($listaHistoricoEstudiante))
                            foreach($listaHistoricoEstudiante as $llave=>$valor) {
                                ?>

        <td bgcolor="White">&nbsp;</td>
                            <?php
                            }
                    }
                    ?>
    </tr>
                <?php
                //continue;
                // Niveles


           /*             if($arrayNiveles['totalniveles'] == 0) {
           ?>
            <td></td>
        </tr>
            <?php
                        }*/
                $arrayNiveles = $row_Facultades['niveles'];
                foreach($arrayNiveles as $key_codigomodalidadacademicasic => $row_Niveles) {
                    $rowspannivel = "";
                    $entro2 = false;
                    if($entro)
                        $rowspannivel = " rowspan='2'";
                    $nuevafila = "";

                    if($row_Niveles['totalcarreras'] != 0) {
                        $rowspannivel = ' rowspan="'.($row_Niveles['totalcarreras'] + 1).'"';
                        $nuevafila = "</tr><tr>";
                    //" bgcolor='#97D9FF'";
                    }
                    else {
                        $rowspannivel = " rowspan='2'";
                        //$rowspannivel = "";
                        $entro2 = true;
                    }
                    //$rowspannivel = "";
                    echo $nuevafila;
                    $totalNivel = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($key_codigomodalidadacademicasic,"",$key_codigofacultad, $key_codigoareadisciplinar));
                    ?>
    <td <?php echo $rowspannivel; ?> valign="top">
        <table border="0" width="100%">
            <tr>
                <td align="left"><?php echo "$totalNivel"; ?></td>
                <td align="right"><?php echo $row_Niveles['nombremodalidadacademicasic']; ?></td>
            </tr>
        </table>
    </td>
    <td align="center" bgcolor="#00D0F0"> % por Nivel</td>

                    <?php
                    /**
                     * POR NIVEL
                     */
                    /**
                     * Estrato
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Puesto Icfes
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }

                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Participación Académica
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Proyección social
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Participación Gestión
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }

                    /**
                     * Financiacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }

                    /**
                     * Estado estudiante
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante[$key_codigoareadisciplinar]['facultades'][$key_codigofacultad]['modalidades'][$key_codigomodalidadacademicasic]['arraytotales'], $totalNivel, ' bgcolor="#00D0F0"');
                    }

                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        if(is_array($listaHistoricoEstudiante))
                            foreach($listaHistoricoEstudiante as $llave=>$valor) {
                                ?>

    <td bgcolor="White">&nbsp;</td>
                            <?php
                            }
                    }
                    ?>
</tr>
                <?php
                $arrayCarreras = $row_Niveles['carreras'];
                foreach($arrayCarreras as $key_codigocarrera => $row_carreras) {
                    /*if($row_EsqueletoAreaDisciplinar['cuentaCarrerasXArea'] > 1) {
                        echo "</tr><tr>";
                    }*/
                    $totalCarrera = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($key_codigomodalidadacademicasic,$key_codigocarrera));
                    ?>
<td>
    <table border="0" width="100%">
        <tr>
            <td align="left"><?php echo $totalCarrera; ?></td>
            <td align="right"><?php echo $key_codigocarrera." - ".$row_carreras['nombrecarrera']; ?></td>
        </tr>
    </table>
</td>
                    <?php
                    //continue;

                    /**
                     * Estrato
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                        foreach($listaEstratos as $nombreestrato) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayEstrato[$nombreestrato][$key_codigocarrera], $totalCarrera);?>&nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        foreach($listaEdades as $nombreedad) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayEdad[$nombreedad][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        foreach($listaGeneros as $nombregenero) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayGenero[$nombregenero][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                        foreach($listaNivelesEducativos as $nombrenivel) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayNivelEducativo[$nombrenivel][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Puesto Icfes
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                        foreach($listaPuestoIcfes as $nombrepuesto) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayPuestoIcfes[$nombrepuesto][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        foreach($listaNacionalidad as $nombrenacionalidad) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayNacionalidad[$nombrenacionalidad][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                            /*
                             * Región
                             */
                    ?>
<!-- <td rowspan="2">Andina</td>
<td rowspan="2">Pac&iacute;fica</td>
<td rowspan="2">Oinoqu&iacute;a</td>
<td rowspan="2">Atl&aacute;ntica</td>
<td rowspan="2">Amazon&iacute;a</td> -->
                    <?php
                            /*
                             * Partivipación Académica
                             */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                        foreach($listaParticipacionAcademica as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionAcademica[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                            /*
                             * Partivipación Investigativa
                             */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                        foreach($listaParticipacionInvestigacion as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionInvestigacion[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Proyección social
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                        foreach($listaProyeccionSocial as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayProyeccionSocial[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                        foreach($listaParticipacionBienestar as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionBienestar[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                        foreach($listaParticipacionGobierno as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionGobierno[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Participación Asociación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociacion',$_REQUEST['nacampoformulario'])) {
                        foreach($listaAsociacion as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayAsociacion[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Participación Gestión
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                        foreach($listaParticipacionGestion as $nombreparticipacion) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionGestion[$nombreparticipacion][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        foreach($listaReconocimiento as $nombre) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayReconocimiento[$nombre][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Financiacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                        foreach($listaTipoFinanciacion as $nombre) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayTipoFinanciacion[$nombre][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Estado estudiante
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                        foreach($listaEstadoEstudiante as $nombre) {
                            ?>
<td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayEstadoEstudiante[$nombre][$key_codigocarrera], $totalCarrera);?>
    &nbsp;</td>
                        <?php
                        }
                    }
                    /**
                     * Historico
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        foreach($listaHistoricoEstudiante as $nombre) {
                            ?>
<td><?php echo $arrayHistoricoEstudiante[$nombre][$key_codigocarrera];  ?>&nbsp;</td>
                        <?php
                        }
                    }
                    ?>
</tr>
                <?php
                }
                ?>
</tr>
            <?php
            }
        }
    }
    ?>
<!--</tbody>-->
</table>
<?php
}
$_SESSION['sesion_matrizEstudiante'] = ob_get_contents();
//ob_end_clean();
ob_end_flush();
//echo $_SESSION['sesion_matrizEstudiante'];

$horafinal=mktime(date("H"),date("i"),date("s"));
//   echo date("H:i:s")."<br>";
echo "<font color='White'><br>Diferencia Impresion Total=".($horafinal-$horainicial)."<br></font>";

//echo "Contenido = $contenido";
?>

</body>
<script type="text/javascript">
    ocultarEspera();
</script>
</html>
