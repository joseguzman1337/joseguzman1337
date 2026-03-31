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
require_once("EstadisticoDocente.php");
require_once("Filtro.php");
ini_set('max_execution_time','6000');
ini_set("memory_limit","120M");

$objetobase = new BaseDeDatosGeneral($sala);
$db = $objetobase->conexion;

require_once("MatrizDocente.php");
$codigocarrera = $_REQUEST['nacodigocarrera'];
$codigoperiodo = "20092";
$codigomodalidadacademicasic = $_REQUEST['nacodigomodalidadacademicasic'];
//$codigomodalidadacademicasic = "";
$codigoareadisciplinar = $_REQUEST['nacodigoareadisciplinar'];
$matrizDocente = new MatrizDocente($codigocarrera, $codigoperiodo, $codigomodalidadacademicasic, $codigoareadisciplinar);

$objestadisitico = new EstadisticoDocente($codigoperiodo,$objetobase);

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
        <title>Matriz Docente</title>
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
        <h1>Matriz de Docentes por Nivel Académico</h1>
        <?php
        filtro($matrizDocente->filtroCarreras);
        ob_flush();
        flush();
        ob_end_clean();
        if(isset($_REQUEST['naenviar'])) {
        //$listaEstratos = $matrizDocente->getListaEstratos();
        //$arrayEstrato = $objestadisitico->rangoEstrato($codigomodalidadacademicasic);
            if(isset($_REQUEST['nacampoformulario'])) {
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                    $listaEdades = $matrizDocente->getListaEdades();
                    $arrayEdad = $objestadisitico->rangoEdad($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesEdad = $objestadisitico->porcentajesTotales("rangoEdad", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario']) ) {
                    $listaGeneros = $matrizDocente->getListaGeneros();
                    $arrayGenero = $objestadisitico->rangoGenero($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesGenero = $objestadisitico->porcentajesTotales("rangoGenero", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario']) ) {
                    $listaNivelesEducativosDocencia = $matrizDocente->getListaNivelesEducativos();
                    $arrayNivelEducativoDocencia = $objestadisitico->rangoNivelEducacionDocencia($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesNivelEducativoDocencia = $objestadisitico->porcentajesTotales("rangoNivelEducacionDocencia", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario']) ) {
                    $listaNivelesEducativosDisciplinar = $matrizDocente->getListaNivelesEducativos();
                    $arrayNivelEducativoDiciplinar = $objestadisitico->rangoNivelEducacionDisciplinar($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesNivelEducativoDiciplinar = $objestadisitico->porcentajesTotales("rangoNivelEducacionDisciplinar", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario']) ) {
                    $listaNivelesEducativosInvestigacion = $matrizDocente->getListaNivelesEducativos();
                    $arrayNivelEducativoInvestigacion = $objestadisitico->rangoNivelEducacionInvestigacion($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesNivelEducativoInvestigacion = $objestadisitico->porcentajesTotales("rangoNivelEducacionInvestigacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                    $listaIdioma = $matrizDocente->getListaIdiomas();
                    $arrayIdioma = $objestadisitico->rangoIdioma($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesIdioma = $objestadisitico->porcentajesTotales("rangoIdioma", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                    $listaTic = $matrizDocente->getListaTics();
                    $arrayTic = $objestadisitico->rangoManejoTic($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesTic = $objestadisitico->porcentajesTotales("rangoManejoTic", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario']) ) {
                    $listaNacionalidad= $matrizDocente->getListaNacionalidad();
                    $arrayNacionalidad = $objestadisitico->rangoNacionalidad($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesNacionalidad = $objestadisitico->porcentajesTotales("rangoNacionalidad", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionInvestigacion = $matrizDocente->getListaParticipacionInvestigacion();
                    $arrayParticipacionInvestigacion = $objestadisitico->rangoLineaInvestigacion($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesParticipacionInvestigacion = $objestadisitico->porcentajesTotales("rangoLineaInvestigacion", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionBienestar = $matrizDocente->getListaParticipacionBienestar();
                    $arrayParticipacionBienestar = $objestadisitico->rangoParticipacionBienestar($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesParticipacionBienestar = $objestadisitico->porcentajesTotales("rangoParticipacionBienestar", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario']) ) {
                    $listaParticipacionGobierno = $matrizDocente->getListaParticipacionGobierno();
                    $arrayParticipacionGobierno = $objestadisitico->rangoParticipacionGobierno($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesParticipacionGobierno = $objestadisitico->porcentajesTotales("rangoParticipacionGobierno", "");
                }
                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario']) ) {
                    $listaAsociacion = $matrizDocente->getListaAsociacion();
                    $arrayAsociacion = $objestadisitico->rangoAsociacion($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesAsociacion = $objestadisitico->porcentajesTotales("rangoAsociacion", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario']) ) {
                    $listaReconocimiento = $matrizDocente->getListaReconocimiento();
                    $arrayReconocimiento = $objestadisitico->rangoReconocimiento($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesReconocimiento = $objestadisitico->porcentajesTotales("rangoReconocimiento", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario']) ) {
                    $listaContrato = $matrizDocente->getListaContrato();
                    $arrayContrato = $objestadisitico->rangoContrato($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                    $totalesContrato = $objestadisitico->porcentajesTotales("rangoContrato", "");
                }

                if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario']) ) {
                    $listaHistorico = $matrizDocente->getListaHistorico();
                    $arrayHistorico = $objestadisitico->rangoHistorico($codigomodalidadacademicasic, $codigocarrera, "", $codigoareadisciplinar);
                }
                //print_r($arrayParticipacionAcademica);
                //exit();

                $totalQuienesSon = count($listaEstratos) + count($listaEdades) + count($listaGeneros) + count($listaNivelesEducativosDisciplinar) + count($listaNivelesEducativosDocencia) + count($listaNivelesEducativosInvestigacion) + count($listaPuestoIcfes) + count($listaIdioma) + count($listaTic);
                $totalDeDondeProvienen = count($listaNacionalidad);

                $totalTipoDeActividad = count($listaParticipacionAcademica) + count($listaParticipacionInvestigacion) + count($listaProyeccionSocial) + count($listaParticipacionBienestar) + count($listaParticipacionGobierno) + count($listaAsociacion) + count($listaParticipacionGestion);

                $totalReconocimientos = count($listaReconocimiento);

                $totalContratos = count($listaContrato);
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
            <tr align="center" id="trtitulogris">
                <td colspan="4">
                    <b>MATRIZ DE INFORMACI&Oacute;N ESTAD&Iacute;STICA I</b>
                </td>
                    <?php
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])  || in_array('genero',$_REQUEST['nacampoformulario'])
                        || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])
                        || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])
                        || in_array('tics',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalQuienesSon+$totalDeDondeProvienen;?>">
                    CARACTER&Iacute;STICAS DEMOGR&Aacute;FICAS
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario']) ||
                        in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])  ||
                        in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])  || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalTipoDeActividad; ?>">
                    ACTIVIDADES DEL DOCENTE
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
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalContratos;?>">
                    CONTRATOS
                </td>
                    <?php
                    }
                    ?>
            </tr>
            <tr align="center">
                <td rowspan="5">
                    <b>TOTAL DOCENTES</b>
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
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])  ||
                        in_array('genero',$_REQUEST['nacampoformulario'])  || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])
                        || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])
                        || in_array('idiomas',$_REQUEST['nacampoformulario'])  || in_array('tics',$_REQUEST['nacampoformulario'])) {
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
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario']) ||
                        in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])  ||
                        in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])  || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
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
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo $totalContratos;?>">
                    <b>TIPO DE CONTRATO</b>
                </td>
                    <?php
                    }
                    ?>
            </tr>
            <tr id="trtitulogris">
                    <?php
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
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaNivelesEducativosDocencia); ?>" rowspan="2">
                    <b>NIVEL EDUCATIVO DOCENCIA</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaNivelesEducativosDisciplinar); ?>" rowspan="2">
                    <b>NIVEL EDUCATIVO DISCIPLINAR</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaNivelesEducativosInvestigacion); ?>" rowspan="2">
                    <b>NIVEL EDUCATIVO INVESTIGACION</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaIdioma); ?>" rowspan="2">
                    <b>IDIOMA</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaTic); ?>" rowspan="2">
                    <b>TECNOLOGIAS DE LA INFORMACION Y COMUNICACION</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaNacionalidad); ?>" rowspan="2">
                    <b>NACIONALIDAD</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionInvestigacion); ?>" rowspan="2">
                    <b>Investigativas</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionBienestar); ?>" rowspan="2">
                    <b>Bienestar Universitario</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaParticipacionGobierno); ?>" rowspan="2">
                    <b>Gobierno Universitario</b>
                </td>
                    <?php
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaAsociacion); ?>" rowspan="2">
                    <b>Asociaciones</b>

                </td>
                    <?php
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaReconocimiento,'rowspan="4"');
                    }
                    //echo "<pre>".print_r($listaReconocimiento)."</pre>";
                    //echo "<pre>".print_r($listaContrato)."</pre>";

                    /**
                     * Contratos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaContrato,'rowspan="4"');
                    }
                    ?>
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
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaEdades,'rowspan="2"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaGeneros,'rowspan="2"');
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaNivelesEducativosDocencia,'rowspan="2"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaNivelesEducativosDisciplinar,'rowspan="2"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaNivelesEducativosInvestigacion,'rowspan="2"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaIdioma,'rowspan="2"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaTic,'rowspan="2"');
                    }
                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaNacionalidad,'rowspan="2"');
                    }
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaParticipacionInvestigacion,'rowspan="2"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaParticipacionBienestar,'rowspan="2"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaParticipacionGobierno,'rowspan="2"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTD($listaAsociacion,'rowspan="2"');
                    }
                    /**
                     * Historico
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                        ?>
                <td colspan="<?php echo count($listaHistorico); ?>" align="center"><b>DATOS HIST&Oacute;RICOS</b></td>
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
                        $matrizDocente->printArregloTD($listaHistorico,'rowspan="5"');
                    }
                    ?>
            </tr>
                <?php
                //$matrizDocente->obtenerDatosEnLinea = true;
                //$db->debug = true;
            /*$arrayTabla[0]['TOTAL ESTUDIANTES'] = $matrizDocente->getTotalEstudiantesMatriculados();
            $arrayTabla[1]['NIVEL ACADÉMICO'] = $matrizDocente->getArrayNivelAcademico();
            $selNiveles = $matrizDocente->getSelNivelAcademico();
            $arrayAreaDisciplinar = $matrizDocente->getArrayAreaDisciplinar();
            */
                //$arrayIzquierda = $matrizDocente->getMatrizIzquierda();
                $selEsqueletoIzquierda = $matrizDocente->selEsqueletoMatrizIzquierda();
                $totalDocentes = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo(""));
                ?>
            <tr align="right">
                <td rowspan="500" valign="top"><?php echo $totalDocentes; ?></td>
            <tr>
                <td colspan="3" align="center" bgcolor="#FFEE53"> % por Total Docentes</td>
                    <?php
                    /**
                     * POR TOTAL DOCENTES
                     */
                    /**
                     * Edad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaEdades, $totalesEdad['totalesfinal'], $totalDocentes, ' bgcolor="#FFEE53"');
                    }
                    /**
                     * Genero
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaGeneros, $totalesGenero['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * Nivel Educativo
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaNivelesEducativosDocencia, $totalesNivelEducativoDocencia['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaNivelesEducativosDisciplinar, $totalesNivelEducativoDiciplinar['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaNivelesEducativosInvestigacion, $totalesNivelEducativoInvestigacion['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaIdioma, $totalesIdioma['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaTic, $totalesTic['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * Nacionalidad
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * ParticipacionInvestigación
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Bienestar
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Gobierno
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * Participación Asociacion
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaAsociacion, $totalesAsociacion['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    /**
                     * Reconocimientos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    //echo "<pre>".print_r($totalesReconocimiento['totalesfinal'])."</pre>";
                    //echo "<pre>".print_r($totalesContrato['totalesfinal'])."</pre>";

                    /**
                     * Contratos
                     */
                    if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                        $matrizDocente->printArregloTotalesTD($listaContrato, $totalesContrato['totalesfinal'], $totalDocentes,' bgcolor="#FFEE53"');
                    }
                    ?>
            </tr>
                <?php
                while($row_EsqueletoIzquierda = $selEsqueletoIzquierda->FetchRow()) {
                    $selEsqueletoAreaDisciplinar = $matrizDocente->selEsqueletoAreaDisciplinar($row_EsqueletoIzquierda['codigomodalidadacademicasic']);
                    $totalRows_Areas = $selEsqueletoAreaDisciplinar->RecordCount();

                    $entro = false;
                    $rowspannivel = " rowspan='3'";
                    $matrizDocente->setArrayMatrizIzquierda($row_EsqueletoIzquierda['codigomodalidadacademicasic']);
                    //print_r($matrizDocente->arrayMatrizIzquierda);
                    //exit();

                    if($matrizDocente->arrayMatrizIzquierda['cuentacarreras'] != 0) {
                        $rowspannivel = ' rowspan="'.($matrizDocente->arrayMatrizIzquierda['cuentaareas'] + $matrizDocente->arrayMatrizIzquierda['cuentacarreras'] + 1 + $totalRows_Areas).'"';
                    }
                    else /*if($row_EsqueletoIzquierda['cuentaCarrerasXModalidad'] > 1)*/ {
                        echo "</tr><tr>";
                        $entro = true;
                    // bgcolor='#7EBAFF'
                    }
                    $totalNivel = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($row_EsqueletoIzquierda['codigomodalidadacademicasic']));
                    ?>
            <td<?php echo $rowspannivel; ?> valign="top" onclick="activarPorcentajeNivelAcademico('<?php echo $row_EsqueletoIzquierda['codigomodalidadacademicasic'];?>')">
                <table border="0" width="100%">
                    <tr>
                        <td align="left"><?php echo $totalNivel; ?></td>
                        <td align="right"><?php echo $row_EsqueletoIzquierda['nombremodalidadacademicasic']; ?></td>
                    </tr>
                </table></td>
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
                         * Edad
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaEdades, $totalesEdad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Genero
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaGeneros, $totalesGenero[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Nivel Educativo
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaNivelesEducativosDocencia, $totalesNivelEducativoDocencia[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaNivelesEducativosDisciplinar, $totalesNivelEducativoDiciplinar[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaNivelesEducativosInvestigacion, $totalesNivelEducativoInvestigacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaIdioma, $totalesIdioma[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaTic, $totalesTic[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Nacionalidad
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * ParticipacionInvestigación
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Bienestar
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Gobierno
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Participación Asociacion
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Reconocimientos
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        /**
                         * Contratos
                         */
                        if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                            $matrizDocente->printArregloTotalesTD($listaContrato, $totalesContrato[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['arraytotales'], $totalNivel, ' bgcolor="#7EBAFF"');
                        }
                        ?>
            </tr>
                    <?php
                    // Area disciplinar
                    //$db->debug = true;
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
                        <td align="left"><?php echo $totalDisicplinar; ?></td>
                        <td align="right"><?php echo $row_EsqueletoAreaDisciplinar['nombreareadisciplinar']; ?></td>
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
                             * Edad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaEdades, $totalesEdad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Genero
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaGeneros, $totalesGenero[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Nivel Educativo
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaNivelesEducativosDocencia, $totalesNivelEducativoDocencia[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaNivelesEducativosDisciplinar, $totalesNivelEducativoDiciplinar[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaNivelesEducativosInvestigacion, $totalesNivelEducativoInvestigacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaIdioma, $totalesIdioma[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaTic, $totalesTic[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Nacionalidad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaNacionalidad, $totalesNacionalidad[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * ParticipacionInvestigación
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaParticipacionInvestigacion, $totalesParticipacionInvestigacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Bienestar
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaParticipacionBienestar, $totalesParticipacionBienestar[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Gobierno
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaParticipacionGobierno, $totalesParticipacionGobierno[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Participación Asociacion
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaAsociacion, $totalesAsociacion[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Reconocimientos
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaReconocimiento, $totalesReconocimiento[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            /**
                             * Contratos
                             */
                            //echo "<pre>".print_r($totalesReconocimiento[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'])."</pre>";
                            //echo "<pre>".print_r($totalesContrato[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'])."</pre>";
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                                $matrizDocente->printArregloTotalesTD($listaContrato, $totalesContrato[$row_EsqueletoIzquierda['codigomodalidadacademicasic']]['areas'][$row_EsqueletoAreaDisciplinar['codigoareadisciplinar']]['arraytotales'], $totalDisicplinar, ' bgcolor="#97D9FF"');
                            }
                            if(is_array($listaHistorico))
                                foreach($listaHistorico as $llave=>$valor) {
                                    ?>

                <td bgcolor="White">&nbsp;</td>
                                <?php
                                }
                            ?>
            </tr>
                        <?php
                        // Carreras
                        $selEsqueletoCarrera = $matrizDocente->selEsqueletoCarrera($row_EsqueletoIzquierda['codigomodalidadacademicasic'], $row_EsqueletoAreaDisciplinar['codigoareadisciplinar']);
                        while($row_EsqueletoCarrera = $selEsqueletoCarrera->FetchRow()) {
                            if($row_EsqueletoAreaDisciplinar['cuentaCarrerasXArea'] > 1) {
                                echo "</tr><tr>";
                            }
                            $totalCarrera = array_sum($objestadisitico->rangoHistoricoXPeriodoActivo($row_EsqueletoIzquierda['codigomodalidadacademicasic'],$row_EsqueletoCarrera['codigocarrera']));
                            ?>
            <td>
                <table border="0" width="100%">
                    <tr>
                        <td align="left"><?php echo $totalCarrera; ?></td>
                        <td align="right"><?php echo $row_EsqueletoCarrera['codigocarrera']." - ".$row_EsqueletoCarrera['nombrecarrera']; ?></td>
                    </tr>
                </table>
            </td>
                            <?php
                            /**
                             * Edad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('edad',$_REQUEST['nacampoformulario'])) {
                                foreach($listaEdades as $nombreedad) {
                                    ?>
            <td><!--<div style="visibility:hidden" title="porcentajenivel<?php echo $row_EsqueletoIzquierda['codigomodalidadacademicasic'];?>"> % UNO </div>-->
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayEdad[$nombreedad][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Genero
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('genero',$_REQUEST['nacampoformulario'])) {
                                foreach($listaGeneros as $nombregenero) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayGenero[$nombregenero][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Nivel Educativo
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodocencia',$_REQUEST['nacampoformulario'])) {
                                foreach($listaNivelesEducativosDocencia as $nombrenivel) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayNivelEducativoDocencia[$nombrenivel][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario'])) {
                                foreach($listaNivelesEducativosDisciplinar as $nombrenivel) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayNivelEducativoDiciplinar[$nombrenivel][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario'])) {
                                foreach($listaNivelesEducativosInvestigacion as $nombrenivel) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayNivelEducativoInvestigacion[$nombrenivel][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('idiomas',$_REQUEST['nacampoformulario'])) {
                                foreach($listaIdioma as $nombrenivel) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayIdioma[$nombrenivel][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tics',$_REQUEST['nacampoformulario'])) {
                                foreach($listaTic as $nombrenivel) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayTic[$nombrenivel][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Puesto Icfes
                             */
                            /*foreach($listaPuestoIcfes as $nombrepuesto) {
                                ?>
                <td><?php echo $arrayPuestoIcfes[$nombrepuesto][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                            <?php
                            }*/
                            /**
                             * Nacionalidad
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('nacionalidad',$_REQUEST['nacampoformulario'])) {
                                foreach($listaNacionalidad as $nombrenacionalidad) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayNacionalidad[$nombrenacionalidad][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
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
                            /*foreach($listaParticipacionAcademica as $nombreparticipacion) {
                                ?>
                <td><?php echo $arrayParticipacionAcademica[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                            <?php
                            }*/
                            /*
                             * Partivipación Investigativa
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('investigativas',$_REQUEST['nacampoformulario'])) {
                                foreach($listaParticipacionInvestigacion as $nombreparticipacion) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayParticipacionInvestigacion[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Proyección social
                             */
                            /*foreach($listaProyeccionSocial as $nombreparticipacion) {
                                ?>
                <td><?php echo $arrayProyeccionSocial[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                            <?php
                            }*/
                            /**
                             * Participación Bienestar
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('bienestaruniversitario',$_REQUEST['nacampoformulario'])) {
                                foreach($listaParticipacionBienestar as $nombreparticipacion) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayParticipacionBienestar[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Participación Gobierno
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('gobiernouniversitario',$_REQUEST['nacampoformulario'])) {
                                foreach($listaParticipacionGobierno as $nombreparticipacion) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayParticipacionGobierno[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Participación Asociación
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('asociaciones',$_REQUEST['nacampoformulario'])) {
                                foreach($listaAsociacion as $nombreparticipacion) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayAsociacion[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Participación Gestión
                             */
                            /*foreach($listaParticipacionGestion as $nombreparticipacion) {
                                ?>
                <td><?php echo $arrayParticipacionGestion[$nombreparticipacion][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                            <?php
                            }*/
                            /**
                             * Reconocimientos
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('estimulos',$_REQUEST['nacampoformulario'])) {
                                foreach($listaReconocimiento as $nombre) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayReconocimiento[$nombre][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Contratos
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('tipocontrato',$_REQUEST['nacampoformulario'])) {
                                foreach($listaContrato as $nombre) {
                                    ?>
            <td>
                                        <?php echo $matrizDocente->getCalcularPorcentanje($arrayContrato[$nombre][$row_EsqueletoCarrera['codigocarrera']], $totalCarrera); ?>
                &nbsp;
            </td>
                                <?php
                                }
                            }
                            /**
                             * Financiacion
                             */
                            /*foreach($listaTipoFinanciacion as $nombre) {
                                ?>
                <td><?php echo $arrayTipoFinanciacion[$nombre][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                            <?php
                            }*/
                            /**
                             * Estado estudiante
                             */
                            /*foreach($listaEstadoEstudiante as $nombre) {
                                ?>
                <td><?php echo $arrayEstadoEstudiante[$nombre][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
                            <?php
                            }*/
                            /**
                             * Historico
                             */
                            if(in_array('todos',$_REQUEST['nacampoformulario']) || in_array('historicos',$_REQUEST['nacampoformulario'])) {
                                foreach($listaHistorico as $nombre) {
                                    ?>
            <td><?php echo $arrayHistorico[$nombre][$row_EsqueletoCarrera['codigocarrera']];  ?>&nbsp;</td>
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
