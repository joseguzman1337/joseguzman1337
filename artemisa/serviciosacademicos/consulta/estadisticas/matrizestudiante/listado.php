<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
if(isset($_REQUEST['formato'])) {
    $formato = $_REQUEST['formato'];
    $formato = 'xls';
    $nombrearchivo = "matrizdocente";
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

    echo $_SESSION['sesion_matrizdocente'];

    exit();
}
//echo date("H:i:s")."<br>";
$horainicial=mktime(date("H"),date("i"),date("s"));

$rutaado=("../../../funciones/adodb/");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once('../../../funciones/sala/nota/nota.php');
require_once("EstadisticoEstudiante.php");
require_once("FiltroEstudiante.php");
ini_set('max_execution_time','6000');
ini_set("memory_limit","120M");
$objetobase = new BaseDeDatosGeneral($sala);
$db = $objetobase->conexion;

require_once("MatrizEstudiante.php");
$codigocarrera = $_REQUEST['nacodigocarrera'];

if(isset($_GET['codigoperiodo'])&&trim($_GET['codigoperiodo'])!='')
	$codigoperiodo = $_GET['codigoperiodo'];
else
	$codigoperiodo = $_SESSION['codigoperiodosesion'];

$codigomodalidadacademicasic = $_REQUEST['nacodigomodalidadacademicasic'];
//$codigomodalidadacademicasic = "";
$codigoareadisciplinar = $_REQUEST['nacodigoareadisciplinar'];
$matrizEstudiante = new MatrizEstudiante($codigocarrera, $codigoperiodo, $codigomodalidadacademicasic, $codigoareadisciplinar);

$objestadisitico = new EstadisticoEstudiante($codigoperiodo,$objetobase);

if(isset($_SESSION['debug_sesion'])) {
    $db->debug = true;
}
/*echo "<pre>";
print_r($_REQUEST);
echo "</pre>";*/
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
        <h1>Matriz de Estudiantes por Nivel Académico</h1>
        <?php
        filtro($matrizEstudiante->filtroCarreras);
        ob_flush();
        flush();
        ob_end_clean();
        if(isset($_REQUEST['naenviar'])) {
            if(isset($_REQUEST['nacampoformulario'])) {
            // Estrato
            //unset($arrayEstrato);
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                    $listaEstratos = $matrizEstudiante->getListaEstratos();
                    $arrayEstrato = $objestadisitico->rangoEstrato($codigomodalidadacademicasic);
                    $totalesEstrato = $objestadisitico->porcentajesTotales("rangoEstrato", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                    $listaEdades = $matrizEstudiante->getListaEdades();
                    $arrayEdad = $objestadisitico->rangoEdad($codigomodalidadacademicasic);
                    $totalesEdad = $objestadisitico->porcentajesTotales("rangoEdad", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario']) ) {
                    $listaGeneros = $matrizEstudiante->getListaGeneros();
                    $arrayGenero = $objestadisitico->rangoGenero($codigomodalidadacademicasic);
                    $totalesGenero = $objestadisitico->porcentajesTotales("rangoGenero", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario']) ) {
                    $listaNivelesEducativos = $matrizEstudiante->getListaNivelesEducativos();
                    $arrayNivelEducativo = $objestadisitico->rangoNivelEducacion($codigomodalidadacademicasic);
                    $totalesNivelEducativo = $objestadisitico->porcentajesTotales("rangoNivelEducacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario']) ) {
                    $listaPuestoIcfes = $matrizEstudiante->getListaPuestoIcfes();
                    $arrayPuestoIcfes = $objestadisitico->rangoPuestoIcfes($codigomodalidadacademicasic);
                    $totalesPuestoIcfes = $objestadisitico->porcentajesTotales("rangoPuestoIcfes", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario']) ) {
                    $listaNacionalidad= $matrizEstudiante->getListaNacionalidad();
                    $arrayNacionalidad = $objestadisitico->rangoNacionalidad($codigomodalidadacademicasic);
                    $totalesNacionalidad = $objestadisitico->porcentajesTotales("rangoNacionalidad", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionAcademica = $matrizEstudiante->getListaParticipacionAcademica();
                    $arrayParticipacionAcademica = $objestadisitico->rangoParticipacionAcademica($codigomodalidadacademicasic);
                    $totalesParticipacionAcademica = $objestadisitico->porcentajesTotales("rangoParticipacionAcademica", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionInvestigacion = $matrizEstudiante->getListaParticipacionInvestigacion();
                    $arrayParticipacionInvestigacion = $objestadisitico->rangoLineaInvestigacion($codigomodalidadacademicasic);
                    $totalesParticipacionInvestigacion = $objestadisitico->porcentajesTotales("rangoLineaInvestigacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario']) ) {
                    $listaProyeccionSocial = $matrizEstudiante->getListaProyeccionSocial();
                    $arrayProyeccionSocial = $objestadisitico->rangoProyeccionSocial($codigomodalidadacademicasic);
                    $totalesProyeccionSocial = $objestadisitico->porcentajesTotales("rangoProyeccionSocial", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionBienestar = $matrizEstudiante->getListaParticipacionBienestar();
                    $arrayParticipacionBienestar = $objestadisitico->rangoParticipacionBienestar($codigomodalidadacademicasic);
                    $totalesParticipacionBienestar = $objestadisitico->porcentajesTotales("rangoParticipacionBienestar", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionGobierno = $matrizEstudiante->getListaParticipacionGobierno();
                    $arrayParticipacionGobierno = $objestadisitico->rangoParticipacionGobierno($codigomodalidadacademicasic);
                    $totalesParticipacionGobierno = $objestadisitico->porcentajesTotales("rangoParticipacionGobierno", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociacion',$_REQUEST['nacampoformulario']) ) {
                    $listaAsociacion = $matrizEstudiante->getListaAsociacion();
                    $arrayAsociacion = $objestadisitico->rangoAsociacion($codigomodalidadacademicasic);
                    $totalesAsociacion = $objestadisitico->porcentajesTotales("rangoAsociacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionGestion = $matrizEstudiante->getListaParticipacionGestion();
                    $arrayParticipacionGestion = $objestadisitico->rangoParticipacionGestion($codigomodalidadacademicasic);
                    $totalesParticipacionGestion = $objestadisitico->porcentajesTotales("rangoParticipacionGestion", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario']) ) {
                    $listaReconocimiento = $matrizEstudiante->getListaReconocimiento();
                    $arrayReconocimiento = $objestadisitico->rangoReconocimiento($codigomodalidadacademicasic);
                    $totalesReconocimiento = $objestadisitico->porcentajesTotales("rangoReconocimiento", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario']) ) {
                    $listaTipoFinanciacion = $matrizEstudiante->getListaTipoFinanciacion();
                    $arrayTipoFinanciacion = $objestadisitico->rangoTipoFinanciacion($codigomodalidadacademicasic);
                    $totalesTipoFinanciacion = $objestadisitico->porcentajesTotales("rangoTipoFinanciacion", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario']) ) {
                    $listaEstadoEstudiante = $matrizEstudiante->getListaEstadoEstudiante();
                    $arrayEstadoEstudiante = $objestadisitico->rangoEstadoEstudiante($codigomodalidadacademicasic);
                    $totalesEstadoEstudiante = $objestadisitico->porcentajesTotales("rangoEstadoEstudiante", "");
                }
                $listaHistoricoEstudiante = $matrizEstudiante->getListaHistoricoEstudiante();
                $arrayHistoricoEstudiante = $objestadisitico->historicoEstudiante($codigomodalidadacademicasic);

                $totalQuienesSon = count($listaEstratos) + count($listaEdades) + count($listaGeneros) + count($listaNivelesEducativos) + count($listaPuestoIcfes);
                $totalDeDondeProvienen = count($listaNacionalidad);

                $totalTipoDeActividad = count($listaParticipacionAcademica) + count($listaParticipacionInvestigacion) + count($listaProyeccionSocial) + count($listaParticipacionBienestar) + count($listaParticipacionGobierno) + count($listaAsociacion) + count($listaParticipacionGestion);

                $totalReconocimientos = count($listaReconocimiento);

                $totalFinanciacion = count($listaTipoFinanciacion);
            }
        }

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
            <tr align="center" id="trtitulogris">
                <td colspan="4">
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
                    <b>NIVEL ACAD&Eacute;MICO</b>
                </td>
                <td rowspan="5">
                    <b>&Aacute;REA DISCIPLINAR</b>
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
                <?php
                //$matrizEstudiante->obtenerDatosEnLinea = true;
                //$db->debug = true;
            /*$arrayTabla[0]['TOTAL ESTUDIANTES'] = $matrizEstudiante->getTotalEstudiantesMatriculados();
            $arrayTabla[1]['NIVEL ACADÉMICO'] = $matrizEstudiante->getArrayNivelAcademico();
            $selNiveles = $matrizEstudiante->getSelNivelAcademico();
            $arrayAreaDisciplinar = $matrizEstudiante->getArrayAreaDisciplinar();
            */
                //$arrayIzquierda = $matrizEstudiante->getMatrizIzquierda();
                $selEsqueletoIzquierda = $matrizEstudiante->selEsqueletoMatrizIzquierda();
                $totalDocentes = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo(""));
                ?>
            <tr align="right">
                <td rowspan="500" valign="top"><?php echo $totalDocentes; ?></td>
            <tr>
                <td colspan="3" align="center" bgcolor="#FFEE53"> % por Total Estudiantes</td>
                    <?php
                    /**
                     * POR TOTAL ESTUDIANTES
                     */
                     /**
                         * Estrato
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Edad
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Genero
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Nivel Educativo
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Puesto Icfes
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }

                        /**
                         * Nacionalidad
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Participación Académica
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * ParticipacionInvestigación
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Proyección social
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Participación Bienestar
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Participación Gobierno
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Participación Asociacion
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Participación Gestión
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }
                        /**
                         * Reconocimientos
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }

                        /**
                         * Financiacion
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                        }

                        /**
                         * Estado estudiante
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
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
                    while($row_EsqueletoIzquierda = $selEsqueletoIzquierda->FetchRow()) {
                        $selEsqueletoAreaDisciplinar = $matrizEstudiante->selEsqueletoAreaDisciplinar($row_EsqueletoIzquierda['codigomodalidadacademicasic']);
                        $totalRows_Areas = $selEsqueletoAreaDisciplinar->RecordCount();

                        $entro = false;
                        $rowspannivel = " rowspan='3'";
                        $matrizEstudiante->setArrayMatrizIzquierda($row_EsqueletoIzquierda['codigomodalidadacademicasic']);

                        if($matrizEstudiante->arrayMatrizIzquierda['cuentacarreras'] != 0) {
                            $rowspannivel = ' rowspan="'.($matrizEstudiante->arrayMatrizIzquierda['cuentaareas'] + $matrizEstudiante->arrayMatrizIzquierda['cuentacarreras'] + 1 + $totalRows_Areas).'"';
                        }
                        else /*if($row_EsqueletoIzquierda['cuentaCarrerasXModalidad'] > 1)*/ {
                            echo "</tr><tr>";
                            $entro = true;
                        // bgcolor='#7EBAFF'
                        }
                        $totalNivel = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($row_EsqueletoIzquierda['codigomodalidadacademicasic']));
                        ?>
                <td<?php echo $rowspannivel; ?> valign="top">
                    <table border="0" width="100%">
                        <tr>
                            <td align="rigth"><?php echo $totalNivel; ?></td>
                            <td align="lefth"><?php echo $row_EsqueletoIzquierda['nombremodalidadacademicasic']; ?></td>
                        </tr>
                    </table>
                            <?php
                            if(!$entro) {
                                ?>
            <tr>
                        <?php
                        }
                        ?>
                <td colspan="2" align="center" bgcolor="#7EBAFF"> % por Nivel Académico</td>
                        <?php
                        /**
                         * POR NIVEL ACADÉMICO
                         */
                        /**
                         * Estrato
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Edad
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Genero
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Nivel Educativo
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Puesto Icfes
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }

                        /**
                         * Nacionalidad
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Académica
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * ParticipacionInvestigación
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Proyección social
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Bienestar
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Gobierno
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Asociacion
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Gestión
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Reconocimientos
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }

                        /**
                         * Financiacion
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }

                        /**
                         * Estado estudiante
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                            $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
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
                    // Area disciplinar
                    //$db->debug = true;
                    //$selEsqueletoAreaDisciplinar = $matrizEstudiante->selEsqueletoAreaDisciplinar($row_EsqueletoIzquierda['codigomodalidadacademicasic']);
                    while($row_EsqueletoAreaDisciplinar = $selEsqueletoAreaDisciplinar->FetchRow()) {
                        $rowspannivel = "";
                        $entro2 = false;
                        if($entro)
                            $rowspannivel = " rowspan='2'";
                        $nuevafila = "";

                        if($row_EsqueletoAreaDisciplinar['cuentaCarrerasXArea'] > 1) {
                            $rowspannivel = ' rowspan="'.($row_EsqueletoAreaDisciplinar['cuentaCarrerasXArea'] + 1 + 1).'"';
                            $nuevafila = "</tr><tr>";
                        //" bgcolor='#97D9FF'";
                        }
                        else {
                            $rowspannivel = " rowspan='2'";
                            $entro2 = true;
                        }
                        echo $nuevafila;

                        $totalDisicplinar = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($row_EsqueletoIzquierda['codigomodalidadacademicasic'], "", "", $row_EsqueletoAreaDisciplinar['codigoareadisciplinar']));
                        ?>
            <td<?php echo $rowspannivel; ?> valign="top">
                <table border="0" width="100%">
                    <tr>
                        <td align="rigth"><?php echo $totalDisicplinar; ?></td>
                        <td align="lefth"><?php echo $row_EsqueletoAreaDisciplinar['nombreareadisciplinar']; ?></td>
                    </tr>
                </table>
            </td>
                        <?php
                        if($entro && $nuevafila == "" || $entro2) {
                            ?>
                        <?php
                        }
                        else {
                            ?>
            <tr>
                            <?php
                            }
                            ?>
                <td align="center" bgcolor="#97D9FF"> % por Nivel Disciplinar</td>
                            <?php
                            /**
                             * POR NIVEL DISCIPLINAR
                             */
                            /**
                             * Estrato
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaEstratos, $totalesEstrato[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Edad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaEdades, $totalesEdad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Genero
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaGeneros, $totalesGenero[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Nivel Educativo
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativo',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaNivelesEducativos, $totalesNivelEducativo[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Puesto Icfes
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('icfes',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaPuestoIcfes, $totalesPuestoIcfes[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }

                            /**
                             * Nacionalidad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Académica
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionacademica',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaParticipacionAcademica, $totalesParticipacionAcademica[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * ParticipacionInvestigación
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacioninvestigacion',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Proyección social
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('proyeccionsocial',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaProyeccionSocial, $totalesProyeccionSocial[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Bienestar
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participacionbienestar',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Gobierno
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongobierno',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Asociacion
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Gestión
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('participaciongestion',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaParticipacionGestion, $totalesParticipacionGestion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Reconocimientos
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }

                            /**
                             * Financiacion
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('financiacion',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaTipoFinanciacion, $totalesTipoFinanciacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }

                            /**
                             * Estado estudiante
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estado',$_REQUEST['nacampoformulario'])) {
                                $matrizEstudiante->printArregloTotalesTD($listaEstadoEstudiante, $totalesEstadoEstudiante[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
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
                        // Carreras
                        $selEsqueletoCarrera = $matrizEstudiante->selEsqueletoCarrera($row_EsqueletoIzquierda['codigomodalidadacademicasic'], $row_EsqueletoAreaDisciplinar['codigoareadisciplinar']);
                        while($row_EsqueletoCarrera = $selEsqueletoCarrera->FetchRow()) {
                            if($row_EsqueletoAreaDisciplinar['cuentaCarrerasXArea'] > 1) {
                                echo "</tr><tr>";
                            }
                            $totalCarrera = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($row_EsqueletoIzquierda['codigomodalidadacademicasic'],$row_EsqueletoCarrera['codigocarrera']));
                            ?>
            <td>
                <table border="0" width="100%">
                    <tr>
                        <td align="rigth"><?php echo $totalCarrera; ?></td>
                        <td align="lefth"><?php echo $row_EsqueletoCarrera['codigocarrera']." - ".$row_EsqueletoCarrera['nombrecarrera']; ?></td>
                    </tr>
                </table>
            </td>
                            <?php
                            /**
                             * Estrato
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estrato',$_REQUEST['nacampoformulario'])) {
                                foreach($listaEstratos as $nombreestrato) {
                                    ?>
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayEstrato[$nombreestrato][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>&nbsp;</td>
                                <?php
                                }
                            }
                            /**
                             * Edad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                                foreach($listaEdades as $nombreedad) {
                                    ?>
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayEdad[$nombreedad][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayGenero[$nombregenero][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayNivelEducativo[$nombrenivel][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayPuestoIcfes[$nombrepuesto][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayNacionalidad[$nombrenacionalidad][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionAcademica[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionInvestigacion[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayProyeccionSocial[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionBienestar[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionGobierno[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayAsociacion[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayParticipacionGestion[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayReconocimiento[$nombre][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayTipoFinanciacion[$nombre][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $matrizEstudiante->getCalcularPorcentanje($arrayEstadoEstudiante[$nombre][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera);?>
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
            <td><?php echo $arrayHistoricoEstudiante[$nombre][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                                <?php
                                }
                            }
                            ?>
        </tr>
                    <?php
                    }
                }
            }
            ?>
    </table>
    <?php
    }
    $_SESSION['sesion_matrizdocente'] = ob_get_contents();
    //ob_end_clean();
    ob_end_flush();
    //echo $_SESSION['sesion_matrizdocente'];

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
