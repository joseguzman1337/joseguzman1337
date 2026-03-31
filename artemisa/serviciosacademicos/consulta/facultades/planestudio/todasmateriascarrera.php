<?php
require(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

Factory::validateSession($variables);
$usuario = Factory::getSessionVar('usuario');

$itemId = Factory::getSessionVar('itemId');
require_once('../../../../assets/lib/Permisos.php');
if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
    header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
    exit();
}

ini_set('max_execution_time', '6000');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script LANGUAGE="JavaScript">
    function  ventanaprincipal(pagina) {
        opener.focus();
        opener.location.href = pagina.href;
        window.close();
        return false;
    }
    function reCarga() {
        document.location.href = "<?php echo 'todasmateriascarrera.php'; ?>";
    }
    function regresarGET() {
        document.location.href = "<?php echo 'todasmateriascarrera.php'; ?>";
    }
    function enviarmenu() {
        form3.action = "";
        form3.submit();
    }
</script>

<?php
$rutaado = ("../../../funciones/adodb/");
require_once("../../../funciones/clases/motorv2/motor.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../../funciones/sala_genericas/FuncionesMatriz.php");
require_once("../../../funciones/sala_genericas/formulariobaseestudiante.php");
require_once("../../../funciones/sala_genericas/clasebasesdedatosgeneral.php");

$objetobase = new BaseDeDatosGeneral($sala);
$formulario = new formulariobaseestudiante($sala, 'form2', 'post', '', 'true');



echo "	<form name=\"form3\" action=\"todasmateriascarrera.php\" method=\"post\"  >
	<table border=\"1\" cellpadding=\"1\" cellspacing=\"0\" bordercolor=\"#E9E9E9\" width=\"750\">";

$formulario->dibujar_fila_titulo('LISTA VERIFICACION CONTENIDOS PROGRAMATICOS', 'labelresaltado', "2", "align='center'");

$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("modalidadacademica f", "codigomodalidadacademica", "nombremodalidadacademica", "");
$formulario->filatmp[""] = "Seleccionar";
$campo = 'menu_fila';

$vlr_default_modalidad = ($_POST['codigomodalidadacademicaaux']) ? $_POST['codigomodalidadacademicaaux'] : $_SESSION['codigomodalidadacademicaaux'];
$parametros = "'codigomodalidadacademicaaux','" . $vlr_default_modalidad . "','onchange=enviarmenu();'";
$formulario->dibujar_campo($campo, $parametros, "Modalidad Academica", "tdtitulogris", 'codigomodalidadacademicaaux', '');

$condicion = "c.codigomodalidadacademica='" . $vlr_default_modalidad . "' order by c.nombrecarrera";
$formulario->filatmp = $objetobase->recuperar_datos_tabla_fila("carrera c", "codigocarrera", "nombrecarrera", $condicion, '', 0);
$formulario->filatmp[""] = "Seleccionar";
$vlr_default_carrera = ($_POST['codigocarreraaux']) ? $_POST['codigocarreraaux'] : $_SESSION['codigocarreraaux'];
$campo = 'menu_fila';
$parametros = "'codigocarreraaux','" . $vlr_default_carrera . "','onchange=enviarmenu();'";
$formulario->dibujar_campo($campo, $parametros, "Carrera", "tdtitulogris", 'codigocarreraaux', '');

$query = "select distinct codigoperiodo,concat(substring(codigoperiodo,1,4),'-',substring(codigoperiodo,5,5)) from contenidoprogramatico 
    ORDER BY codigoperiodo;";
$peridodos = $objetobase->conexion->query($query);

while ($row_periodo = $peridodos->fetchRow()) {
    $row_operacionb[$row_periodo['codigoperiodo']] = $row_periodo['codigoperiodo'];
}

$formulario->filatmp = $row_operacionb;
$formulario->filatmp[""] = "Seleccionar";

$vlr_default_PERIDO = ($_POST['codigoperidoaux']) ? $_POST['codigoperidoaux'] : $_SESSION['codigoperidoaux'];

$campo = 'menu_fila';
$parametros = "'codigoperidoaux','" . $vlr_default_PERIDO . "','onchange=enviarmenu();'";

$formulario->dibujar_campo($campo, $parametros, "Perido Academico", "tdtitulogris", 'codigoperidoaux', '');


echo "</table></form>";


if ($_REQUEST['codigocarreraaux'] != '' || $_SESSION['codigocarreraaux']) {
    $_SESSION['codigomodalidadacademicaaux'] = ($_REQUEST['codigomodalidadacademicaaux']) ? $_REQUEST['codigomodalidadacademicaaux'] : $_SESSION['codigomodalidadacademicaaux'];
    $_SESSION['codigocarreraaux'] = ($_REQUEST['codigocarreraaux']) ? $_REQUEST['codigocarreraaux'] : $_SESSION['codigocarreraaux'];
    $_SESSION['codigoperidoaux'] = ($_POST['codigoperidoaux']) ? $_POST['codigoperidoaux'] : $_SESSION['codigoperidoaux'];

    if ($_SESSION['codigocarreraaux'] == '1') {
        $carrera = "";
    } else {
        $carrera = " AND m.codigocarrera = '" . $_SESSION['codigocarreraaux'] . "' ";
    }
    echo "<hr>";
    $query = "SELECT 	
                            *
                        FROM (  
                                SELECT
                                c.nombrecarrera,
                                m.codigomateria,
                                g.idgrupo,
                                g.nombregrupo,
                                d.apellidodocente,
                                d.nombredocente,
                                d.emaildocente,
                                concat(u.usuario,'@unbosque.edu.co') as emaildocenteinstitucional,
                                m.nombremateria,
                                COALESCE (
                                        cp.urlasyllabuscontenidoprogramatico,
                                        'no'
                                ) AS syllabus,
                                COALESCE (
                                        cp.urlaarchivofinalcontenidoprogramatico,
                                        'no'
                                ) AS contenidoprogramatico,
                                cp.urlcontenidoprogramatico,
                                cp.codigoperiodo,
                                cp.idcontenidoprogramatico,
                                dcp.idcontenidoprogramatico AS decontenido
                        FROM
                            materia m
                            INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera)
                            INNER JOIN grupo g ON (m.codigomateria = g.codigomateria)
                            INNER JOIN docente d ON (g.numerodocumento = d.numerodocumento)
                            LEFT JOIN usuario u ON (d.numerodocumento=u.numerodocumento and u.codigotipousuario=500)
                            LEFT JOIN contenidoprogramatico cp ON (m.codigomateria = cp.codigomateria AND g.codigoperiodo = cp.codigoperiodo AND cp.codigoestado = '100')
                            INNER JOIN detallecontenidoprogramatico dcp ON (dcp.idcontenidoprogramatico = cp.idcontenidoprogramatico)
                        WHERE
                            g.codigoperiodo = '" . $_SESSION['codigoperidoaux'] . "' 
                            AND g.codigoestadogrupo = '10' $carrera
                            AND c.codigomodalidadacademica = '" . $_SESSION['codigomodalidadacademicaaux'] . "'    
                            AND dcp.idcontenidoprogramatico IS NOT NULL
                        GROUP BY
                                m.codigomateria
                        UNION
                        SELECT
                                c.nombrecarrera,
                                m.codigomateria,
                                g.idgrupo,
                                g.nombregrupo,
                                d.apellidodocente,
                                d.nombredocente,
                                d.emaildocente,
                                concat(u.usuario,'@unbosque.edu.co') as emaildocenteinstitucional,
                                m.nombremateria,
                                COALESCE (
                                        cp.urlasyllabuscontenidoprogramatico,
                                        'no'
                                ) AS syllabus,
                                COALESCE (
                                        cp.urlaarchivofinalcontenidoprogramatico,
                                        'no'
                                ) AS contenidoprogramatico,
                                cp.urlcontenidoprogramatico,
                                cp.codigoperiodo,
                                cp.idcontenidoprogramatico,
                                dcp.idcontenidoprogramatico AS decontenido
                        FROM
                            materia m
                            INNER JOIN carrera c ON (m.codigocarrera = c.codigocarrera)
                            INNER JOIN grupo g ON (m.codigomateria = g.codigomateria)
                            INNER JOIN docente d ON (g.numerodocumento = d.numerodocumento)
                            LEFT JOIN usuario u ON (d.numerodocumento=u.numerodocumento and u.codigotipousuario=500)
                            LEFT JOIN contenidoprogramatico cp ON (m.codigomateria = cp.codigomateria AND g.codigoperiodo = cp.codigoperiodo AND cp.codigoestado = '100')
                            LEFT JOIN detallecontenidoprogramatico dcp ON (dcp.idcontenidoprogramatico = cp.idcontenidoprogramatico)
                        WHERE
                            g.codigoperiodo = '" . $_SESSION['codigoperidoaux'] . "'
                        AND g.codigoestadogrupo = '10' $carrera
                        AND c.codigomodalidadacademica = '" . $_SESSION['codigomodalidadacademicaaux'] . "'        
                        AND dcp.idcontenidoprogramatico IS NULL	
                        AND cp.urlaarchivofinalcontenidoprogramatico IS NULL
                        GROUP BY
                                m.codigomateria) datos
                        ORDER BY datos.nombrecarrera";

    $operacion = $objetobase->conexion->query($query);

    while ($row_operacion = $operacion->fetchRow()) {
        if ($row_operacion['codigoperiodo'] >= 20122) {
            if (empty($row_operacion["urlcontenidoprogramatico"])) {
                $row_operacion['syllabus'] = ($row_operacion['decontenido'] != '') ? "<a href='../materiasgrupos/contenidoprogramatico/toPdf.php?usuariosesion=" . $_SESSION['MM_Username'] . "&type=1&periodosesion=" . $row_operacion['codigoperiodo'] . "&codigomateria=" . $row_operacion['codigomateria'] . "' target='_blank'>Ver syllabus</a>" : "No";
                $row_operacion['contenidoprogramatico'] = ($row_operacion['decontenido'] != '') ? "<a href='../materiasgrupos/contenidoprogramatico/toPdf.php?usuariosesion=" . $_SESSION['MM_Username'] . "&type=2&periodosesion=" . $row_operacion['codigoperiodo'] . "&codigomateria=" . $row_operacion['codigomateria'] . "' target='_blank'>Ver contenido program&aacute;tico</a>" : "No";
                "to</a></td></tr>";
            } else {
                $row_operacion['syllabus'] = ($row_operacion['decontenido'] != '') ? "<a href='../materiasgrupos/contenidoprogramatico/" . trim($row_operacion["syllabus"], "../") . "' target='_blank' >Ver syllabus</a>" : "No";
                $row_operacion['contenidoprogramatico'] = ($row_operacion['decontenido'] != '') ? "<a href='../materiasgrupos/contenidoprogramatico/" . trim($row_operacion["contenidoprogramatico"], "../") . "' target='_blank' >Ver contenido program&aacute;tico</a>" : "No";
                "to</a></td></tr>";
            }
        } else {
            $row_operacion['syllabus'] = ($row_operacion['syllabus'] != 'no') ? "<a href='../materiasgrupos/contenidoprogramatico/" . $row_operacion['syllabus'] . "' target='_blank'>Ver syllabus</a>" : $row_operacion['syllabus'];
            $row_operacion['contenidoprogramatico'] = ($row_operacion['contenidoprogramatico'] != 'no') ? "<a href='../materiasgrupos/contenidoprogramatico/" . $row_operacion['contenidoprogramatico'] . "' target='_blank'>Ver contenido program&aacute;tico</a>" : $row_operacion['contenidoprogramatico'];
        }


        if ($_SESSION['usuario'] == 'fdusyllabus1')
            unset($row_operacion['contenidoprogramatico']);
        $array_interno[] = $row_operacion;
    }
    $motor = new matriz($array_interno, "MATERIAS DEL PROGRAMA", "todasmateriascarrera.php", 'si', 'si', 'todasmateriascarrera.php', 'todasmateriascarrera.php', false, "si", "../../../");
    $motor->botonRecargar = false;
    $motor->botonRegresar = false;
    $motor->mostrar();
}