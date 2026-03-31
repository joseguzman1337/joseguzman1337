<?php
/**
 * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
 * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas
 * se activa la visualizacion de todos los errores de php
 * @modified Andres Ariza <andresariza@unbosque.edu.do>.
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @since 19 de octubre de 2018.
 */
require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

/**
 * Si la aplicacion se corre en un entorno local o de pruebas se activa la visualizacion
 * de todos los errores de php
 */
$pos = strpos($Configuration->getEntorno(), "local");
if ($Configuration->getEntorno() == "local" || $Configuration->getEntorno() == "pruebas" || $pos !== false) {
    //@error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    //@ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!
    /**
     * Se incluye la libreria Kint para hacer debug controlado de variables y objetos
     */
    require_once(PATH_ROOT . '/kint/Kint.class.php');
}

session_start();
/* include_once('../../../utilidades/ValidarSesion.php');
 $ValidarSesion = new ValidarSesion();
 $ValidarSesion->Validar($_SESSION);*/

//session_start();
require('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";

//$rutazado = "../../../funciones/zadodb/";
require_once('../../../Connections/salaado.php');
require_once('../../../funciones/sala/estudiante/estudiante.php');
require_once('../../../funciones/sala/inscripcion/inscripcion.php');
require_once('../../../funciones/enviamail.php');
$salatmp = $sala;
//require_once("../../../funciones/funcionboton.php");
$rutaado = ("../../../funciones/adodb/");

require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/phpmailer/class.phpmailer.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
$ruta = "../../../funciones/sala/inscripcion/";

set_time_limit(900000000);

$objetobase = new BaseDeDatosGeneral($sala);
$sala = $salatmp;
//print_r($_SERVER);
//echo $_SERVER['argv'][0];
$codigocarrera = $_SESSION['codigocarrerasesion'];
if (!isset($_SESSION['fppal'])) {
    if ($_SERVER['argv'][0] == '') {
        $_SESSION['fppal'] = $_SERVER['QUERY_STRING'];
    } else
        $_SESSION['fppal'] = $_SERVER['argv'][0];
}

//echo "<h1>".$_SESSION['fppal']."</h1>";
?>
<html>
<head><title>FORMULARIO DE INSCRIPCION</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <script language="JavaScript" src="calendario/javascripts.js"></script>
    <script type="text/javascript" src="../../../../assets/js/chosen.jquery.min.js"></script>
    <script type="text/javascript" src="../../../observatorio/js/jquery-3.6.0.js"></script>
    <script type="text/javascript" src="../../../observatorio/js/jquery-ui-1.8.21.custom.min.js"></script>

    <script type="text/javascript">
        /*function desabilitar(guardarinformacionaspirante)
    {

    }*/


        function alternar(division) {
            var txtCodigoCarrera = $("#txtCodigoCarrera").val();
            var informacionMedicina = $(division).attr("id");

            calcular_edad();
            if (division.style.display == "none") {
                if (informacionMedicina == "informacionestudiossecundaria" && txtCodigoCarrera == "10") {
                    alert("Señor aspirante al Programa de Medicina: \nNo olvide diligenciar el puntaje que obtuvo en la prueba de Estado (Saber 11) en la casilla destinada para tal fin en el punto 8 de éste formulario. Recuerde que su puntaje tiene un peso del 50% dentro del proceso de admisión\nRecuerde traer Lápiz No.2, Borrador y tajalápiz al examen de ingreso.");
                }
                division.style.display = "";
            } else {
                division.style.display = "none"
            }
        }

        function ocultaMostrarInfoOtrasUniversidades(div, condicion) {
            if (condicion)
                div.style.display = "";
            else
                div.style.display = "none";
        }

        function recargar(direccioncompleta, direccioncompletalarga) {
            document.informacionAspirante.direccion1.value = direccioncompletalarga;
            document.informacionAspirante.direccion1oculta.value = direccioncompleta;
        }

        function calcular_edad() {
            var fecha = document.informacionAspirante.fecha1.value;
            now = new Date()
            bD = fecha.split('-');
            if (bD.length == 3) {
                born = new Date(bD[0], bD[1] * 1 - 1, bD[2]);
                years = Math.floor((now.getTime() - born.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
            }
            document.informacionAspirante.edad1.value = years;
            return years;
        }

        // Esta funcion recargar1 sirve para los datos de estudios
        function recargar1(codigocolegio, nombrecolegio, estudios) {
            //alert(estudios);
            if (estudios == "informacionestudiossecundaria") {
                document.informacionEstudiosSecundaria.idinstitucioneducativa.value = codigocolegio;
                document.informacionEstudiosSecundaria.institucioneducativa.value = nombrecolegio;
            } else if (estudios == "otrosestudios") {
                document.otrosEstudios.idinstitucioneducativa.value = codigocolegio;
                document.otrosEstudios.institucioneducativa.value = nombrecolegio;
            } else {
                document.informacionEstudios.idinstitucioneducativa.value = codigocolegio;
                document.informacionEstudios.institucioneducativa.value = nombrecolegio;
            }
            /*   //alert(document.getElementById("informacionestudiossecundaria").style.display);
                if(document.getElementById("informacionestudiossecundaria").style.display != "none" && document.getElementById("informacionestudiossecundaria").style.display != "") {
                    document.informacionEstudiosSecundaria.idinstitucioneducativa.value = codigocolegio;
                    document.informacionEstudiosSecundaria.institucioneducativa.value = nombrecolegio;
                }
                else{
                    document.otrosEstudios.idinstitucioneducativa.value = codigocolegio;
                    document.otrosEstudios.institucioneducativa.value = nombrecolegio;
                }
            }*/
        }
    </script>
    <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    <link rel="stylesheet" href="../../../../assets/css/chosen.css" type="text/css">

</head>
<body>
<h3>FORMULARIO DE INSCRIPCIONES <a
            onClick="window.open('../../../manuales/formularioinscripcion.html','mensajes','width=700,height=500,left=300,top=100,scrollbars=yes')"
            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a></h3>
<p>PARA DESPLEGAR LA INFORMACIÓN DEL FORMULARIO DE CLIC EN LA CABECERA DE CADA ITEM </p>
<label id="labelresaltado">Por favor diligencie su formulario de inscripción</label>
<?php
$numerodocumento = $_REQUEST['documento'];
$codigomodalidadacademica = $_REQUEST['modalidad'];
$codigomodalidadacademicasesion = $_SESSION['modalidadacademicasesion'];

//echo "<pre>".print_r($_REQUEST)."</pre>";
$idestudiantegeneral = tomarIdestudiantegeneral($numerodocumento);
$estudiantegeneral = new estudiantegeneral($idestudiantegeneral);
//echo "<pre>".print_r($estudiantegeneral)."</pre>";

$idsubperiodo = $_REQUEST['idsubperiodo'];
$idinscripcion = $_REQUEST['inscripcionactiva'];
$inscripcion = new inscripcion($estudiantegeneral, $idsubperiodo, $idinscripcion, $codigomodalidadacademica);

/* if(!isset($_SESSION['inscripcionsession']))
  { */
$_SESSION['inscripcionsession'] = $idinscripcion;
//}


if (!isset($_REQUEST['sininsertar'])) {
    //$guardoInfo = false;
    if (isset($_REQUEST['guardarinformacionaspirante']) || isset($_REQUEST['guardartodo'])) {
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionaspirante";
        $inscripcion->estudiantegeneral->guardar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionfinanciera']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionfinanciera";
        $inscripcion->guardarInformacionFinanciera();
        //$inscripcion->limpiarInformacionFinanciera();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionfamiliar']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionfamiliar";
        $inscripcion->guardarInformacionFamiliar();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionestudios']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionestudios";
        $inscripcion->guardarInformacionEstudios();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarotrosestudios']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "otrosestudios";
        $inscripcion->guardarOtrosEstudios();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionestudiossecundaria']) || isset($_REQUEST['guardartodo'])) {
        //ddd($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionestudiossecundaria";
        $inscripcion->guardarInformacionEstudiosSecundaria();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionidiomas']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionidiomas";
        $inscripcion->guardarInformacionIdiomas();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionsegundaopcion']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionsegundaopcion";
        $inscripcion->guardarInformacionSegundaOpcion();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionotrasu']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionotrasu";
        $inscripcion->guardarInformacionOtrasU();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionmediocomunicacion']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionmediocomunicacion";
        $inscripcion->guardarInformacionMedioComunicacion();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionocupacionesexperiencia']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionocupacionesexperiencia";
        $inscripcion->guardarInformacionOcupacionesExperiencia();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    if (isset($_REQUEST['guardarinformacionoactividadesdestacar']) || isset($_REQUEST['guardartodo'])) {
        //print_r($_REQUEST);
        //exit();
        //$db->debug = true;
        $_SESSION['modulosesion'] = "informacionoactividadesdestacar";
        $inscripcion->guardarInformacionActividadesDestacar();
        //$inscripcion->limpiarInformacionFamiliar();
        //$db->debug = false;
        //$guardoInfo = true;
    }
    /* if($guardoInfo)
      exit(); */
}
$idEstudianteCarreraInscripcion = "";

if (isset($_REQUEST['idEstudianteCarreraInscripcion'])) {

    $idEstudianteCarreraInscripcion = $_REQUEST['idEstudianteCarreraInscripcion'];

}

//CONSULTA LOS MODULOS DE INSCRIPCION EN LA RUTA serviciosacademicos/funciones/sala/inscripcion/
$query_ordenformulario = "SELECT linkinscripcionmodulo,posicioninscripcionformulario,nombreinscripcionmodulo,im.idinscripcionmodulo,ip.codigoindicadorinscripcionformulario
        FROM inscripcionformulario ip, inscripcionmodulo im
        WHERE ip.idinscripcionmodulo = im.idinscripcionmodulo
        AND ip.codigomodalidadacademica = '$inscripcion->codigomodalidadacademica'
        AND ip.codigoestado LIKE '1%'
        ORDER BY posicioninscripcionformulario";
$ordenformulario = $db->Execute($query_ordenformulario);
$totalRows_ordenformulario = $ordenformulario->RecordCount();
$cuentapasos = 0;
$ratafinal = 0;
$cuentaratas = 0;
while ($row_ordenformulario = $ordenformulario->FetchRow()) {
    $idinscripcionmodulo = $row_ordenformulario['idinscripcionmodulo'];
    $cuentapasos++;
    switch ($idinscripcionmodulo) {
        // Aca vienen Información del aspirante
        case 1:
            ?>
            <form action="" method="post" name="informacionAspirante">
                <fieldset>
                    <legend onClick="alternar(informacionaspirante);" style="cursor: pointer"
                    '>
                    <a name="anclainformacionaspirante"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a>
                    <a onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                       style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                alt="Ayuda"></a></legend>
                    <div id="informacionaspirante" style="display:none">

                        <?php
                        /* , casoemergenciallamarestudiantegeneral,
                          telefono1casoemergenciallamarestudiantegeneral,idtipoestudiantefamilia */
                        //$db->debud = true;
                        $query = "select nombresestudiantegeneral, apellidosestudiantegeneral,
			tipodocumento, numerodocumento,	expedidodocumento,
			codigogenero, idciudadnacimiento,
			fechanacimientoestudiantegeneral, direccionresidenciaestudiantegeneral,
			telefonoresidenciaestudiantegeneral, ciudadresidenciaestudiantegeneral,
			emailestudiantegeneral
			from estudiantegeneral
			where idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'";
                        $ratatotal = $inscripcion->valida_formulario($query);
                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        //echo $ratatotal;
                        //$ratatotal=1;
                        $inscripcion->estudiantegeneral->editar();

                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionaspirante" id="guardarinformacionaspirante"
                                       value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <?php
            break;
//      Informacion Financiera
        case 10:
            ?>
            <form action="" method="post" name="informacionFinanciera">
                <fieldset>
                    <legend onClick="alternar(informacionfinaciera);" style="cursor: pointer"
                    '>
                    <a name="anclainformacionfinaciera"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                            onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                     alt="Ayuda"></a></legend>
                    <div id="informacionfinaciera" style="display:none">

                        <?php
                        /*
                         * Caso  105179.
                         * Modificado por Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
                         * Se modifica la consulta para que agrupe los registros por t.idtipoestudianterecursofinanciero y evitar duplicados.
                         * Modificado 25 de Septiembre 2018.
                        */
                        $query = "SELECT nombretipoestudianterecursofinanciero
			FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t
			WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
			and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero
			and e.codigoestado like '1%'
                        GROUP BY t.idtipoestudianterecursofinanciero
			ORDER BY t.idtipoestudianterecursofinanciero desc";
                        //End Caso 105179.
                        $ratatotal = $inscripcion->valida_formulario($query);
                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->informacionFinanciera();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionfinanciera"
                                       id="guardarinformacionfinanciera" value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <?php
            break;
//      Familia y contexto
        #se omite familia y contexto por solicitud de atencion al usuario para pasarlo a entrevistas
//      Informacion de estudios
        case 2:
            ?>
            <form action="" method="post" name="informacionEstudios">
                <fieldset>
                    <legend onClick="alternar(informacionestudios);" style="cursor: pointer"
                    '>
                    <a name="anclainformacionestudios"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                            onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                     alt="Ayuda"></a></legend>
                    <div id="informacionestudios" style="display:none">

                        <?php
                        if ($inscripcion->codigomodalidadacademica != 300) {
                            $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
			    e.codigotitulo, e.ciudadinstitucioneducativa, e.idestudianteestudio,
			    concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa,
			    concat(t.nombretitulo,'',e.otrotituloestudianteestudio) as nombretitulo
			    FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
			    WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
			    and e.idniveleducacion = n.idniveleducacion
			    and ins.idinstitucioneducativa = e.idinstitucioneducativa
			    and e.codigotitulo = t.codigotitulo
			    and e.codigoestado like '1%'
			    and e.idniveleducacion = 2
			    order by anogradoestudianteestudio";
                        } else {
                            $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
                e.codigotitulo, e.ciudadinstitucioneducativa, e.idestudianteestudio,
                concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa,
                concat(t.nombretitulo,'',e.otrotituloestudianteestudio) as nombretitulo
                FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
                WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                and e.idniveleducacion = n.idniveleducacion
                and ins.idinstitucioneducativa = e.idinstitucioneducativa
                and e.codigotitulo = t.codigotitulo
                and e.codigoestado like '1%'
                order by anogradoestudianteestudio";
                        }
                        $rata1 = $inscripcion->valida_formulario($query);

                        $query = "SELECT r.nombreresultadopruebaestado, r.numeroregistroresultadopruebaestado, r.puestoresultadopruebaestado
			FROM detalleresultadopruebaestado d,resultadopruebaestado r
			WHERE r.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
			and r.idresultadopruebaestado = d.idresultadopruebaestado
			and d.codigoestado like '1%'";
                        $rata2 = $inscripcion->valida_formulario($query);

                        /* if($inscripcion->codigomodalidadacademica == 200)
                          $ratatotal = ($rata1 + $rata2) / 2;
                          else
                          $ratatotal = $rata1; */
                        $ratatotal = $rata1;
                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->informacionEstudios();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionestudios" id="guardarinformacionestudios"
                                       value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <?php
            break;
//      Informacion de Idiomas
        #se omite por solicitud de atencion al usuario para pasarlo a entrevistas
//      Segunda Opcion
        case 4:
            ?>
            <form action="" method="post" name="informacionSegundaOpcion">
                <fieldset>
                    <legend onClick="alternar(informacionsegundaopcion);" style="cursor: pointer">
                        <a name="anclainformacionsegundaopcion"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                                onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                                style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                         alt="Ayuda"></a></legend>
                    <div id="informacionsegundaopcion" style="display:none">

                        <?php
                        //$db->debug = true;
                        $query = "SELECT idnumeroopcion, c.nombrecarrera, m.nombremodalidadacademica, c.codigocarrera,
			e.idinscripcion , e.idestudiantecarrerainscripcion
			FROM estudiantecarrerainscripcion e,carrera c,modalidadacademica m
			WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
			and m.codigomodalidadacademica = c.codigomodalidadacademica
			and e.codigocarrera = c.codigocarrera
			and e.codigoestado like '1%'
			and e.idinscripcion = '" . $inscripcion->idinscripcion . "'
			and e.idnumeroopcion > 1
			order by idnumeroopcion";
                        $ratatotal = $inscripcion->valida_formulario($query);
                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->informacionSegundaOpcion();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionsegundaopcion"
                                       id="guardarinformacionsegundaopcion" value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <?php
            break;
//      Otras universidades
        #se omite por solicitud de atencion al usuario para pasarlo a entrevistas
//      decicion universidad
        case 6:
            ?>
            <form action="" method="post" name="decisionUniversidad">
                <fieldset>
                    <legend onClick="alternar(decisionuniversidad);" style="cursor: pointer"
                    '>
                    <a name="ancladecisionuniversidad"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                            onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                     alt="Ayuda"></a></legend>
                    <div id="decisionuniversidad" style="display:none">

                        <?php
                        //$db->debug = true;
                        $query = "select e.codigodecisionuniversidad
            from estudiantedecisionuniversidad e
            where e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
            and e.codigoestadoestudiantedecisionuniversidad like '1%'
            and e.idinscripcion = '" . $inscripcion->idinscripcion . "'";
                        $ratatotal = $inscripcion->valida_formulario($query);

                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->decisionUniversidad();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionotrasu" id="guardarinformacionotrasu"
                                       value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <?php
            break;
//       Ocupaciones Experiencia
        case 3:
            ?>
            <form action="" method="post" name="ocupacionesExperiencia">
                <fieldset>
                    <legend onClick="alternar(ocupacionesexperiencia);" style="cursor: pointer"
                    '>
                    <a name="anclaocupacionesexperiencia"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                            onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                     alt="Ayuda"></a></legend>
                    <div id="ocupacionesexperiencia" style="display:none">

                        <?php
                        //$db->debug = true;
                        $query = "SELECT e.idestudiantegeneral
            FROM estudiantelaboral e,tipoestudiantelaboral t
            WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
            and e.idtipoestudiantelaboral = t.idtipoestudiantelaboral
            and e.codigoestado like '1%'
            order by e.idtipoestudiantelaboral";
                        $ratatotal = $inscripcion->valida_formulario($query);

                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->ocupacionesExperiencia();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionocupacionesexperiencia"
                                       id="guardarinformacionocupacionesexperiencia" value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>

            <?php
            break;
//      Actividades a destacar
        case 12:
            ?>
            <form action="" method="post" name="actividadesDestacar">
                <fieldset>
                    <legend onClick="alternar(actividadesdestacar);" style="cursor: pointer"
                    '>
                    <a name="anclaactividadesdestacar"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a>
                    <a onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                       style="cursor: pointer">
                        &nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif" alt="Ayuda"></a>
                    </legend>
                    <div id="actividadesdestacar" style="display:none">
                        <?php
                        $query = "SELECT e.idestudiantegeneral
                        FROM estudianteaspectospersonales e,tipoestudianteaspectospersonales t
                        WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                        and e.idtipoestudianteaspectospersonales = t.idtipoestudianteaspectospersonales
                        and e.codigoestado like '1%'";
                        $ratatotal = $inscripcion->valida_formulario($query);

                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->actividadesDestacar();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionoactividadesdestacar"
                                       id="guardarinformacionactividadesdestacar" value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <?php
            break;
//      Informacion de medio de comunicación
        #se omite por solicitud de atencion al usuario para pasarlo a entrevistas
//      Informacion de estudios Secundaria
        case 13:
            ?>
            <form action="" method="post" name="informacionEstudiosSecundaria">
                <p><input type="hidden" id="txtCodigoCarrera" name="txtCodigoCarrera"
                          value="<?php echo $codigocarrera; ?>"/></p>
                <fieldset>
                    <legend onClick="alternar(informacionestudiossecundaria);" style="cursor: pointer"
                    '>
                    <a name="anclainformacionestudiossecundaria"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                            onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                     alt="Ayuda"></a></legend>
                    <div id="informacionestudiossecundaria" style="display:none">
                        <?php {
                            $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
                            e.codigotitulo, e.ciudadinstitucioneducativa, e.idestudianteestudio,
                            concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa
                            FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
                            WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                            and e.idniveleducacion = n.idniveleducacion
                            and ins.idinstitucioneducativa = e.idinstitucioneducativa
                            and e.codigotitulo = t.codigotitulo
                            and e.codigoestado like '1%'
                            order by anogradoestudianteestudio";
                        }
                        $rata1 = $inscripcion->valida_formulario($query);

                        $query = "SELECT r.nombreresultadopruebaestado, r.numeroregistroresultadopruebaestado, r.puestoresultadopruebaestado
			FROM detalleresultadopruebaestado d,resultadopruebaestado r
			WHERE r.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
			and r.idresultadopruebaestado = d.idresultadopruebaestado
			and d.codigoestado like '1%'";
                        $rata2 = $inscripcion->valida_formulario($query);

                        $ratatotal = $rata1;
                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->informacionEstudiosSecundaria();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarinformacionestudiossecundaria"
                                       id="guardarinformacionestudiossecundaria" value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <?php
            break;
//      Otros Estudios
        case 14:
            ?>
            <form action="" method="post" name="otrosEstudios">
                <fieldset>
                    <legend onClick="alternar(otrosestudios);" style="cursor: pointer"
                    '>
                    <a name="anclaotrosestudios"><?php echo $row_ordenformulario['nombreinscripcionmodulo']; ?></a><a
                            onClick="window.open('pregunta.php?id=<?php echo 1; ?>','mensajes','width=400,height=200,left=300,top=500,scrollbars=yes')"
                            style="cursor: pointer">&nbsp;&nbsp;<img src="../../../../imagenes/pregunta.gif"
                                                                     alt="Ayuda"></a></legend>
                    <div id="otrosestudios" style="display:none">
                        <?php
                        {
                            $query = "SELECT e.anogradoestudianteestudio, n.nombreniveleducacion , e.idinstitucioneducativa,
                            e.codigotitulo, e.ciudadinstitucioneducativa, e.idestudianteestudio,
                            concat(ins.nombreinstitucioneducativa,'',e.otrainstitucioneducativaestudianteestudio) as nombreinstitucioneducativa,
                            concat(t.nombretitulo,'',e.otrotituloestudianteestudio) as nombretitulo
                            FROM estudianteestudio e,niveleducacion n,institucioneducativa ins,titulo t
                            WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                            and e.idniveleducacion = n.idniveleducacion
                            and ins.idinstitucioneducativa = e.idinstitucioneducativa
                            and e.codigotitulo = t.codigotitulo
                            and e.codigoestado like '1%'
                            and e.codigotitulo not in(74,99,100,119,163)
                            order by anogradoestudianteestudio";
                        }
                        $rata1 = $inscripcion->valida_formulario($query);

                        $query = "SELECT r.nombreresultadopruebaestado, r.numeroregistroresultadopruebaestado, r.puestoresultadopruebaestado
			FROM detalleresultadopruebaestado d,resultadopruebaestado r
			WHERE r.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
			and r.idresultadopruebaestado = d.idresultadopruebaestado
			and d.codigoestado like '1%'";
                        $rata2 = $inscripcion->valida_formulario($query);
                        $ratatotal = $rata1;
                        if ($row_ordenformulario['codigoindicadorinscripcionformulario'] == 100) {
                            $ratafinal = $ratafinal + $ratatotal;
                            $cuentaratas++;
                        }
                        $inscripcion->otrosEstudios();
                        ?>
                    </div>
                    <table width="100%">
                        <tr>
                            <td>
                                <?php
                                $inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE " . $row_ordenformulario['nombreinscripcionmodulo'], $ratatotal * 100);
                                ?>
                            </td>
                            <td align="left">
                                <input type="hidden" value="<?php echo $codigomodalidadacademica; ?>" name="modalidad">
                                <input type="submit" name="guardarotrosestudios" id="guardarotrosestudios"
                                       value="Guardar">
                            <td>
                        </tr>
                    </table>
                </fieldset>
            </form>
            <?php
            break;
    }
}
if ($cuentaratas != 0)
    $ratafinal = $ratafinal / $cuentaratas;
// Al final muestra cuanto falta por diligenciar del formulario completo
$inscripcion->barra("ESTADO DE DILIGENCIAMIENTO DE TODO EL FORMULARIO", $ratafinal * 100);
if ($ratafinal >= 1) {
    if ($inscripcion->codigomodalidadacademica == 400) {
        ?>
    <input id="botoncontinuar" type="button" value="Continuar" name="continuar"
           onClick="window.location.href='../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $numerodocumento . "&codigocarrera=" . $codigocarrera . "&idEstudianteCarreraInscripcion=" . $idEstudianteCarreraInscripcion; ?>'">
    <input type="button" value="Imprimir" name="imprimir"
           onClick="window.open('formulariodeinscripcionimpresion.php?<?php echo $_SESSION['fppal'] . "&imprimir"; ?>','impresion','width=730,height=300,left=300,top=500,scrollbars=yes')">
        <script type="text/javascript">
            alert('El formulario esta completamente diligenciado.');
            document.getElementById('botoncontinuar').focus();
        </script>

    <?php
    $query_estudiantecarrera = "select generaOrdenAutomatica from detalleCursoEducacionContinuada
                    where codigocarrera = '" . $_SESSION['codigocarrerasesion'] . "'";
    $curso = $db->Execute($query_estudiantecarrera);
    $totalRows_curso = $curso->RecordCount();
    $row_curso = $curso->FetchRow();

    if ($totalRows_curso > 0 && $row_curso["generaOrdenAutomatica"] == 1){
    $query_estudiantecarrera = "select max(codigoestudiante) maxcodigoestudiante from estudiante
                        where idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                        and codigocarrera = '" . $_SESSION['codigocarrerasesion'] . "'";
    $estudiantecarrera = $db->Execute($query_estudiantecarrera);
    $totalRows_estudiantecarrera = $estudiantecarrera->RecordCount();
    $row_estudiantecarrera = $estudiantecarrera->FetchRow();

    $codigoestudiantecarrera = $row_estudiantecarrera['maxcodigoestudiante'];

    $query_per = "select cp.codigoperiodo
                        from subperiodo s, carreraperiodo cp
                        where s.idcarreraperiodo  = cp.idcarreraperiodo
                        and s.idsubperiodo = '$idsubperiodo'";
    $per = $db->Execute($query_per);
    $totalRows_per = $per->RecordCount();
    $row_per = $per->FetchRow();

    $query_ordenpagoinscripcion = "SELECT o.numeroordenpago, o.codigoestadoordenpago
                        FROM ordenpago o, detalleordenpago do, concepto c
                        where o.codigoestudiante = '$codigoestudiantecarrera'
                        and o.numeroordenpago = do.numeroordenpago
                        and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
                        and o.codigoperiodo = '" . $row_per['codigoperiodo'] . "'
                        and do.codigoconcepto = c.codigoconcepto 
                        and c.codigoconcepto='151'";
    $ordenpagoinscripcion = $db->Execute($query_ordenpagoinscripcion);
    $totalRows_ordenpagoinscripcion = $ordenpagoinscripcion->RecordCount();
    $row_ordenpagoinscripcion = $ordenpagoinscripcion->FetchRow();

    if ($totalRows_ordenpagoinscripcion == 0) {
    //actualizar situacion del estudiante a admitido
    $query = "UPDATE `estudiante` SET `codigosituacioncarreraestudiante`='300' WHERE (`codigoestudiante`='$codigoestudiantecarrera')";
    $db->Execute($query);
    // exit();
    ?>
        <script language="javascript">
            //alert("Se le va a generar orden de pago");
            window.location.href = "generaordenpagomatriculaEC.php?documentoingreso=<?php echo $numerodocumento . "&codigoestudiante=$codigoestudiantecarrera&codigoperiodo=" . $row_per['codigoperiodo'] . "&todos"; ?>";
        </script>
    <?php
    exit();
    }
    }
    } else {
    ?>
    <input id="botoncontinuar" type="button" value="Continuar" name="continuar"
           onClick="window.location.href='../../../../aspirantes/enlineacentral.php?documentoingreso=<?php echo $numerodocumento . "&codigocarrera=" . $codigocarrera . "&idEstudianteCarreraInscripcion=" . $idEstudianteCarreraInscripcion; ?>'">
    <input type="button" value="Imprimir" name="imprimir"
           onClick="window.open('formulariodeinscripcionimpresion.php?<?php echo $_SESSION['fppal'] . "&imprimir"; ?>','impresion','width=730,height=300,left=300,top=500,scrollbars=yes')">
    <?php
    /*
     * Caso  105179.
     * Modificado por Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
     * Se comenta el bloque de valiadación de ser pilo Pago temporalmente ya que no esta activo este programa.
     * Modificado 21 de Septiembre 2018.
     */

    /* $query_serPilo = "SELECT t.idtipoestudianterecursofinanciero, t.nombretipoestudianterecursofinanciero
      FROM estudianterecursofinanciero e,tipoestudianterecursofinanciero t
      WHERE e.idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
      and e.idtipoestudianterecursofinanciero = t.idtipoestudianterecursofinanciero
      and e.codigoestado like '1%'
      order by nombretipoestudianterecursofinanciero";

      $serPiloEstudiante = $db->Execute($query_serPilo);
      $totalRows_serPilo = $serPiloEstudiante->RecordCount();
      $row_serPilo = $serPiloEstudiante->FetchRow();

      if( $row_serPilo["idtipoestudianterecursofinanciero"] != "13" ){	*/
    /*
     * Ivan Dario Quintero Rios
     * Abril 20 del 2018
     */
    ?>
        <script type="text/javascript">
            alert('El formulario está completamente diligenciado:\n De clic en el botón continuar que aparece al final del formulario y posterior a esto, genere e imprima su orden de pago de derechos de inscripción para pagar en los bancos Itaú, Davivienda, Banco de Bogota, Bancolombia o de click en el sistema de pago PSE para pagos en linea');
            document.getElementById('botoncontinuar').focus();
        </script>
    <?php
    /* }else{
         ?>
         <script type="text/javascript">
             alert('El formulario está completamente diligenciado: De clic en el botón continuar que aparece al final del formulario y programe su prueba o entrevista');
             document.getElementById('botoncontinuar').focus();
         </script>
         <?php
     } */ //End Caso 105179.
    // Generar la orden de pago con inscripción y formulario
    /* *************************************************************** */
    // 1. Mirar que la carrera tenga codigoindicadorcobroinscripcio si se debe cobrar muestra el link generar orden de pago
    // si no no mostrar el link, si el estudiante no tiene orden de pago por concepto de inscripción y formulario se le debe
    // generar la orden con los conceptos correspondientes.
    //echo "<h1>$query_facultad <br>ACA:  ".$row_facultad['codigoindicadorcobroinscripcioncarrera']."</h1>";
    //exit();
    //$db->debug=true;
    $query_estudiantecarrera = "select * from estudiante
                    where idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                    and codigocarrera = '" . $_SESSION['codigocarrerasesion'] . "'";
    $estudiantecarrera = $db->Execute($query_estudiantecarrera);
    $totalRows_estudiantecarrera = $estudiantecarrera->RecordCount();
    $row_estudiantecarrera = $estudiantecarrera->FetchRow();

    $query_facultad = "select nombrecarrera, codigoindicadorcobroinscripcioncarrera
                    from carrera c where c.codigocarrera = '" . $_SESSION['codigocarrerasesion'] . "'";
    $facultad = $db->Execute($query_facultad);
    $totalRows_facultad = $facultad->RecordCount();
    $row_facultad = $facultad->FetchRow();

    if (ereg("^1.+$", $row_facultad['codigoindicadorcobroinscripcioncarrera'])) {
    if ($row_serPilo["idtipoestudianterecursofinanciero"] != "13"){
    $query_estudiantecarrera = "select max(codigoestudiante) maxcodigoestudiante from estudiante
                            where idestudiantegeneral = '" . $inscripcion->estudiantegeneral->idestudiantegeneral . "'
                            and codigocarrera = '" . $_SESSION['codigocarrerasesion'] . "'";
    $estudiantecarrera = $db->Execute($query_estudiantecarrera);
    $totalRows_estudiantecarrera = $estudiantecarrera->RecordCount();
    $row_estudiantecarrera = $estudiantecarrera->FetchRow();

    $codigoestudiantecarrera = $row_estudiantecarrera['maxcodigoestudiante'];

    if ($_SESSION['formularioinscripcionincompleto']) {
        enviaCorreoFacultad($objetobase, $codigoestudiantecarrera);
        $_SESSION['formularioinscripcionincompleto'] = 0;
    }//if

    // Validación de las ordenes por concepto de matricula
    // Creación del objeto ordenes de pago
    //$ordenesxestudiante = new Ordenesestudiante($sala, $row_data['codigoestudiante'], $row_data['codigoperiodo']);
    //$cuentaconceptos = $ordenesxestudiante->existe_conceptosinscripcion($pagos, $porpagar, $enproceso, $sinpagar, $cuentaconceptos)
    // Aqui aparece un link llamado ordenes de pago, en el cual aparece un formulario donde se generan o visualizan las ordenes de inscripción
    $query_per = "select cp.codigoperiodo
                            from subperiodo s, carreraperiodo cp
                            where s.idcarreraperiodo  = cp.idcarreraperiodo
                            and s.idsubperiodo = '$idsubperiodo'";
    $per = $db->Execute($query_per);
    $totalRows_per = $per->RecordCount();
    $row_per = $per->FetchRow();

    $query_ordenpagoinscripcion = "SELECT o.numeroordenpago, o.codigoestadoordenpago
                            FROM ordenpago o, detalleordenpago do, concepto c
                            where o.codigoestudiante = '$codigoestudiantecarrera'
                            and o.numeroordenpago = do.numeroordenpago
                            and (o.codigoestadoordenpago like '1%' or o.codigoestadoordenpago like '4%')
                            and o.codigoperiodo = '" . $row_per['codigoperiodo'] . "'
                            and do.codigoconcepto = c.codigoconcepto
                            and c.codigoreferenciaconcepto like '6%'";
    $ordenpagoinscripcion = $db->Execute($query_ordenpagoinscripcion);
    $totalRows_ordenpagoinscripcion = $ordenpagoinscripcion->RecordCount();
    $row_ordenpagoinscripcion = $ordenpagoinscripcion->FetchRow();

    if ($totalRows_ordenpagoinscripcion == 0) {
    $_SESSION['redirectInsc'] = $_SERVER['HTTP_HOST'] . "/proyecto/aspirantes/enlineacentral.php?documentoingreso=$numerodocumento&codigocarrera=$codigocarrera";
    $query_valorpecuniario = "select v.idvalorpecuniario
                                from valorpecuniario v, concepto c
                                where v.codigoperiodo = '" . $row_per['codigoperiodo'] . "'
                                and v.codigoconcepto = c.codigoconcepto
                                and c.codigoreferenciaconcepto = '600'";
    $ordenpagoinscripcion = $db->Execute($query_valorpecuniario);
    $totalRows_ordenpagoinscripcion = $ordenpagoinscripcion->RecordCount();

    $query_facturavalorpecuniario = "select f.idfacturavalorpecuniario
                                from facturavalorpecuniario f, estudiante e
                                where f.codigoperiodo = '" . $row_per['codigoperiodo'] . "'
                                and f.codigocarrera = e.codigocarrera
                                and e.codigoestudiante = '" . $codigoestudiantecarrera . "'";
    $ordenpagoinscripcion = $db->Execute($query_facturavalorpecuniario);
    $totalRows_ordenpagoinscripcion2 = $ordenpagoinscripcion->RecordCount();

    if ($totalRows_ordenpagoinscripcion == 0) {
    ?>
        <script language="javascript">
            alert("No se ha parametrizado la tabla valorpecuniario con los conceptos con codigoreferencia=600");
        </script>
    <?php
    } else if ($totalRows_ordenpagoinscripcion2 == 0){
    ?>
        <script language="javascript">
            alert("No se ha parametrizado la tabla tabla facturavalorpecuniario");
        </script>
    <?php
    } else {
    ?>
        <script language="javascript">
            //alert("Se le va a generar orden de pago");
            window.location.href = "generarordenpagoinscripcion.php?documentoingreso=<?php echo $numerodocumento . "&codigoestudiante=$codigoestudiantecarrera&codigoperiodo=" . $row_per['codigoperiodo'] . "&todos"; ?>";
        </script>
        <?php
    }
        exit();
                }
            }
        }
    }
} else {
    $_SESSION['formularioinscripcionincompleto'] = 1;
}
?>
</body>
<?php
if (isset($_SESSION['modulosesion'])) {
    ?>
    <script type="text/javascript">
        //alert("<?php echo $_SESSION['modulosesion']; ?>");
        <?php echo $_SESSION['modulosesion'] . '.style.display="";'; ?>
    </script>
    <?php
}
?>
</html>
