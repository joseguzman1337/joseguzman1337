<?php

require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));
Factory::validateSession($variables);

$pos = strpos($Configuration->getEntorno(), "local");
if($Configuration->getEntorno()=="local"||$Configuration->getEntorno()=="pruebas"||$pos!==false){
    require_once(PATH_ROOT.'/kint/Kint.class.php');
}

require_once('../../Connections/sala2.php' );
require_once("../../funciones/validacion.php");
require_once("../../funciones/errores_plandeestudio.php");
require_once("../../funciones/funciontiempo.php");
require_once("../../funciones/funcionip.php");
require_once("asignahorarios/funciones/funcionesvalidacupo.php");

mysql_select_db($database_sala, $sala);
require_once('seguridadprematricula.php');
$materiasunserial = unserialize(stripcslashes($_GET['materiassinhorarios']));

// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre
$materiaselegidas = $materiasunserial;
$materiasserial = serialize($materiasunserial);

$codigoestudiante = $_SESSION['codigo'];
$msg = $_GET['msg'];
if (empty($msg)) {
    $msg = null;
}
?>
<html>
    <head>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <script src="<?php echo HTTP_ROOT;?>/sala/assets/js/jquery-3.1.1.js"></script>
        <!--  Space loading indicator  -->
        <script src="<?php echo HTTP_ROOT;?>/sala/assets/js/spiceLoading/pace.min.js"></script>

        <!--  loading cornerIndicator  -->
<!--        <link href="--><?php //echo HTTP_ROOT; ?><!--/sala/assets/css/CenterRadarIndicator/centerIndicator.css" rel="stylesheet">-->
        <link href="<?php echo HTTP_ROOT; ?>/sala/assets/css/CenterRadarIndicator/centerIndicator.css" rel="stylesheet">

        <script src="<?php echo HTTP_ROOT; ?>/sala/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_ROOT; ?>/sala/assets/css/bootstrap.min.css" rel="stylesheet">
        <?php
        foreach ($materiasunserial as $datos) {
            if ($_REQUEST["grupo" . $datos]) {
                $gruponumero = $_REQUEST['grupo' . $datos];
                ?>
                <script>
                    $(document).ready(function () {
                        $(window).load(function () {
                            Previsualizar(<?php echo $gruponumero; ?>);
                        });
                    });
                </script>
                <?php
            }//if
        }//foreach

        if (!empty($msg)) {
            ?>
            <script>
                alert("<?php echo $msg; ?>");
            </script>
            <?php
        }

        ?>

        <script>
            $(document).ready(function () {
                $(window).load(function () {
                    $('#limpiar').click(function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        Limpiar();
                    });
                });
            });
        </script>
    </head>	
    <body>
    <div class="container">
        <?php
        if (!isset($_SESSION['codigo'])) {
            ?><script language="javascript">
                    alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
            </script>
            <?php
        }
        $codigoestudiante = $_SESSION['codigo'];
        // Selecciona el periodo activo
        $codigoperiodo = $_SESSION['codigoperiodosesion'];
        if (isset($_GET['tieneenfasis'])) {
            $getenfasis = "tieneenfasis";
        }
        // Estos datos se usaran en toda la aplicación
        // Seleccionar los datos del estudiante
        // El primer query genera resultados si el estudiante tiene plan de estudios.
        $cuentaconplandeestudio = true;
        $query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera, e.numerocohorte, e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, pe.cantidadsemestresplanestudio, t.codigoreferenciatipoestudiante, c.codigoreferenciacobromatriculacarrera, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre, c.codigoindicadortipocarrera, c.codigoreferenciacobromatriculacarrera from estudiante e, estudiantegeneral eg, tipoestudiante t, carrera c, modalidadacademica m, planestudioestudiante pee, planestudio pe where e.codigoestudiante = '$codigoestudiante' and eg.idestudiantegeneral = e.idestudiantegeneral and e.codigotipoestudiante = t.codigotipoestudiante and e.codigocarrera = c.codigocarrera and c.codigomodalidadacademica = m.codigomodalidadacademica and pee.codigoestudiante = e.codigoestudiante and pee.codigoestadoplanestudioestudiante like '1%' and pe.idplanestudio = pee.idplanestudio and pe.codigoestadoplanestudio like '1%'";
        $datosestudiante = mysql_db_query($database_sala, $query_datosestudiante) or die("$query_datosestudiante" . mysql_error());
        $totalRows_datosestudiante = mysql_num_rows($datosestudiante);
        if ($totalRows_datosestudiante == "") {
            $cuentaconplandeestudio = false;
            // El segundo query genera resultados si el estudiante no tiene plan de estudios.
            $query_datosestudiante = "select concat(eg.nombresestudiantegeneral,' ',eg.apellidosestudiantegeneral) as nombre, e.codigocarrera, e.numerocohorte,  e.codigotipoestudiante, e.codigosituacioncarreraestudiante, e.codigojornada, e.codigoperiodo, c.codigoindicadorplanestudio, t.codigoreferenciatipoestudiante, c.codigoreferenciacobromatriculacarrera, e.idestudiantegeneral, c.codigomodalidadacademica, e.semestre, c.codigoindicadortipocarrera, c.codigoreferenciacobromatriculacarrera from estudiante e, estudiantegeneral eg, tipoestudiante t, carrera c, modalidadacademica m where e.codigoestudiante = '$codigoestudiante' and eg.idestudiantegeneral = e.idestudiantegeneral and e.codigotipoestudiante = t.codigotipoestudiante and e.codigocarrera = c.codigocarrera 	and c.codigomodalidadacademica = m.codigomodalidadacademica";
            $datosestudiante = mysql_db_query($database_sala, $query_datosestudiante) or die("$query_datosestudiante" . mysql_error());
            $totalRows_datosestudiante = mysql_num_rows($datosestudiante);
        }
        
        $row_datosestudiante = mysql_fetch_array($datosestudiante);
        $codigocarrera = $row_datosestudiante['codigocarrera'];
        $codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
        $codigojornada = $row_datosestudiante['codigojornada'];
        $codigosituacioncarreraestudiante = $row_datosestudiante['codigosituacioncarreraestudiante'];
        $codigoperiodoestudiante = $row_datosestudiante['codigoperiodo'];
        $codigoreferenciatipoestudiante = $row_datosestudiante['codigoreferenciatipoestudiante'];
        $codigoreferenciacobromatriculacarrera = $row_datosestudiante['codigoreferenciacobromatriculacarrera'];
        $idestudiantegeneral = $row_datosestudiante['idestudiantegeneral'];
        $codigomodalidadacademica = $row_datosestudiante['codigomodalidadacademica'];
        $semestredelestudiante = $row_datosestudiante['semestre'];
        $cantidadsemestreplanestudio = $row_datosestudiante['cantidadsemestreplanestudio'];
        $codigoindicadortipocarrera = $row_datosestudiante['codigoindicadortipocarrera'];

        $generarordenes100 = false;
        $generarprematricula = true;
        if (!$cuentaconplandeestudio) {
            if (!preg_match("/^1.+$/", $row_datosestudiante['codigoindicadorplanestudio'])) {
                // Para los estudiantes que no tengan plan de estudios no se le pueden inscribir asignaturas
                // y la generación de ordenes de pago va a ser por el 100%
                $generarordenes100 = true;
                $generarprematricula = false;
                $cuentaconplandeestudio = true;
            }
        }
        // Selecciona el subperiodo activo del estudiante
        $query_selsubperiodoestudiante = "select s.idsubperiodo, s.codigoestadosubperiodo from subperiodo s, carreraperiodo c where c.codigocarrera = '$codigocarrera' 			and c.idcarreraperiodo = s.idcarreraperiodo and c.codigoperiodo = '$codigoperiodo' and s.codigoestadosubperiodo not like '2%' order by 2 desc";
        $selsubperiodoestudiante = mysql_db_query($database_sala, $query_selsubperiodoestudiante) or die("$query_selsubperiodoestudiante");
        $totalRows_selsubperiodoestudiante = mysql_num_rows($selsubperiodoestudiante);
        $row_selsubperiodoestudiante = mysql_fetch_array($selsubperiodoestudiante);
        $idsubperiodo = $row_selsubperiodoestudiante['idsubperiodo'];

        // Selecciona las carreras del estudiante
        $query_selcarrerasestudiante = "select e.codigoestudiante from estudiante e where e.idestudiantegeneral = '$idestudiantegeneral'";
        $selcarrerasestudiante = mysql_db_query($database_sala, $query_selcarrerasestudiante) or die("$query_selcarrerasestudiante");
        $totalRows_selcarrerasestudiante = mysql_num_rows($selcarrerasestudiante);

        // Selecciona la cohorte del estudiante
        $query_datocohorte = "select numerocohorte, codigoperiodoinicial, codigoperiodofinal from cohorte where codigocarrera = '$codigocarrera' and codigoperiodo = '$codigoperiodo' and codigojornada = '$codigojornada' and '$codigoperiodoestudiante'*1 between codigoperiodoinicial*1 and codigoperiodofinal*1";
        $datocohorte = mysql_db_query($database_sala, $query_datocohorte) or die("$query_datocohorte");
        $totalRows_datocohorte = mysql_num_rows($datocohorte);
        $row_datocohorte = mysql_fetch_array($datocohorte);
        $numerocohorte = $row_datocohorte['numerocohorte'];

        // Seleccion de los grupos con horario
        $query_horarioinicial = "SELECT h.idgrupo, d.codigomateria FROM horario h, grupo g, detalleprematricula d, estudiante e, prematricula p where h.idgrupo = d.idgrupo 	and e.codigoestudiante = p.codigoestudiante and p.idprematricula = d.idprematricula and p.codigoperiodo = '$codigoperiodo' and g.codigoperiodo = p.codigoperiodo 		and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') and e.codigoestudiante = '$codigoestudiante' and g.codigoestadogrupo like '1%' 	and g.codigoindicadorhorario like '1%' 	and d.idgrupo = g.idgrupo";
        $horarioinicial = mysql_db_query($database_sala, $query_horarioinicial);
        $totalRows_premainicial1 = mysql_num_rows($horarioinicial);
        $tienehorario = false;
        $tiene_prema = false;
        while ($row_horarioinicial = mysql_fetch_array($horarioinicial)) {
            $grupo_inicial[] = $row_horarioinicial['idgrupo'];
            $materia_inicial[] = $row_horarioinicial['codigomateria'];
            $tienehorario = true;
            $tiene_prema = true;
        }
        // Seleccion de los grupos sin horario
        $query_horarioinicial = "SELECT g.idgrupo, d.codigomateria FROM grupo g, detalleprematricula d, estudiante e, prematricula p where e.codigoestudiante = p.codigoestudiante
		and p.idprematricula = d.idprematricula and p.codigoperiodo = '$codigoperiodo' and g.codigoperiodo = p.codigoperiodo and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%') and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%') and e.codigoestudiante =  '$codigoestudiante' and g.codigoestadogrupo like '1%' and g.codigoindicadorhorario like '2%' and d.idgrupo = g.idgrupo";
        $horarioinicial = mysql_db_query($database_sala, $query_horarioinicial);
        $totalRows_premainicial1 = mysql_num_rows($horarioinicial);
        $tienehorario = false;
        while ($row_horarioinicial = mysql_fetch_array($horarioinicial)) {
            $grupo_inicial[] = $row_horarioinicial['idgrupo'];
            $materia_inicial[] = $row_horarioinicial['codigomateria'];
            $tiene_prema = true;
        }
        ?>
        <form name="form1" method="post" action='matriculaautomaticahorarios.php?documentoingreso=<?php echo $_GET['documentoingreso'] . "&materiassinhorarios=$materiasserial&$getenfasis&lineaunica=" . $_GET['lineaunica'] . "&semestrerep=" . $_GET['semestrerep']; ?>'>
            <?php
            $ffechapago = 1;
            if ($codigomodalidadacademica == 100 && !$tiene_prema) {
                ?>
                <table class="table table-striped">
                    <tr>
                        <td colspan="2"><label id="labelresaltado">Seleccione el tipo de orden que quiere generar</label></td>
                    </tr>
                    <tr>
                        <td><strong>Orden de Matricula</strong>
                            <input type="radio" name="tipoorden" value="0"  checked/></td>
                            <!--<td>
                            <strong>Orden de Pensión</strong><input type="radio" name="tipoorden" value="1">
                            </td>-->
                    </tr>
                </table>
                <?php
            }

            if (preg_match("/^1.+/", $codigoreferenciatipoestudiante) && !preg_match("/^3.+$/", $codigoindicadortipocarrera)) {
                if (preg_match("/estudiante/", $_SESSION["MM_Username"])) {
                    $readonly = "readonly='true'";
                    $_POST['fechapago'] = calcularfechafutura(5, $sala);
                }
                // Si entra es por que para este tipo de estudiante debe solicitar fecha de vencimiento de la orden
                ?>
                <br>
                <h4>Fecha de plazo de pago de la orden para estudiantes nuevos. <br>
                    Esta fecha aplica en caso de generarse una nueva orden de pago.</h4>
                <table class="table table-striped">
                    <tr>
                        <td><strong>Fecha</strong></td>
                        <td><input type="date" name="fechapago" value="<?php
                            if (isset($_POST['fechapago'])) {
                                echo $_POST['fechapago'];
                            }
                            ?>" <?php echo $readonly ?>/>
                                   <?php
                                   if (isset($_POST['fechapago'])) {
                                       $fechapago = $_POST['fechapago'];
                                       $imprimir = true;
                                       $ffechapago = validar($fechapago, "fecha", $error3, $imprimir);
                                       if ($ffechapago != 0) {
                                           require('insertarfecha.php');
                                       } else {
                                           $ffechapago = 0;
                                           echo "La fecha digitada no es correcta<br>";
                                       }
                                   }
                                   ?>
                        </td>
                    </tr>
                    <?php
                    if (!$cuentaconplandeestudio && !isset($_POST['grabar'])) {
                        ?>
                        <tr>
                            <td colspan="2">
                                <form name="form1" method="post" action="matriculaautomaticahorarios.php?documentoingreso=<?php echo $_GET['documentoingreso'] . "&materiassinhorarios=$materiasserial&$getenfasis&lineaunica=" . $_GET['lineaunica'] . "&semestrerep=" . $_GET['semestrerep']; ?>">
                                    <input name="grabar" type="submit" id="grabar" value="Grabar"/>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
                <?php
                // Actualmente a los estudiantes a los que se les solicite fecha y que no tengan plan de estudio se les debe generar la orden al 100%
                if (!$cuentaconplandeestudio && !isset($_POST['grabar'])) {
                    // SI la carrera requiere plan de estudio y el estudiante no lo tiene sale
                    ?>
                    <script language="javascript">
                        alert("Se le debe asignar un plan de estudios al estudiante");
                    </script>
                    <?php
                    exit();
                }
            }//if
            if (isset($_SESSION['cursosvacacionalessesion'])) {
                ?>
                <p>Seleccione el concepto con el cual desea generar la orden por créditos académicos</p>
                <select name="conceptocobroxcreditos">
                    <?php
                    // Muestra los conceptos que requieren cobro por creditos
                    $query_selconceptocobroxcreditos = "select c.codigoconcepto, c.nombreconcepto, c.codigoindicadorconceptoprematricula, c.codigoindicadoraplicacobrocreditosacademicos from concepto c where c.codigoindicadoraplicacobrocreditosacademicos like '1%' and c.codigoestado like '1%'";
                    $selconceptocobroxcreditos = mysql_query($query_selconceptocobroxcreditos, $sala) or die("$query_selconceptocobroxcreditos");
                    $totalRows_selconceptocobroxcreditos = mysql_num_rows($selconceptocobroxcreditos);
                    while ($row_selconceptocobroxcreditos = mysql_fetch_array($selconceptocobroxcreditos)) {
                        ?>
                        <option value="<?php echo $row_selconceptocobroxcreditos['codigoconcepto']; ?>"><?php echo $row_selconceptocobroxcreditos['nombreconcepto']; ?></option>
                        <?php
                    }
                    ?>
                </select>
                <?php
            }//if
            // entra cuando se le pide la fecha
            if (!$cuentaconplandeestudio && isset($_POST['grabar'])) {
                // Entra aca cuando se le esta pidiendo fecha
                $permisograbar = true;
                if ($permisograbar) {
                    if (isset($_GET['tieneenfasis'])) {
                        $calcularcreditosenfasis = true;
                    } else {
                        $calcularcreditosenfasis = false;
                    }
                    $procesoautomatico = false;
                    if (isset($_GET['lineaunica'])) {
                        $lineaescogida = $_GET['lineaunica'];
                    } else {
                        $lineaescogida = "";
                    }
                    $ip = tomarip();
                    $procesoautomaticotodos = false;

                    $ruta = "../../funciones/";
                    require_once("../../funciones/ordenpago/claseordenpago.php");
                    $orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);
                    if (!$orden->valida_ordenmatricula()) {
                        ?>
                        <script language="javascript">
                            history.go(-3);
                        </script>
                        <?php
                    } else {
                        //require_once('../../Connections/sap.php' );
                        require("matriculaautomaticaguardar.php");
                        //	saprfc_close($rfc);
                    }
                    exit();
                }
            }//if
            if (!isset($_POST['grabar']) && !$cuentaconplandeestudio) {
                // Entra aca cuando se le esta pidiendo fecha
                $permisograbar = true;
                if (!$ffechapago) {
                    $permisograbar = false;
                }
                if ($permisograbar) {
                    if (isset($_GET['tieneenfasis'])) {
                        $calcularcreditosenfasis = true;
                    } else {
                        $calcularcreditosenfasis = false;
                    }
                    $procesoautomatico = false;
                    if (isset($_GET['lineaunica'])) {
                        $lineaescogida = $_GET['lineaunica'];
                    } else {
                        $lineaescogida = "";
                    }
                    echo "<br>linea" . $_GET['lineaunica'] . "<br>enfasis" . $_POST['tieneenfasis'] . "$calcularcreditosenfasis<br>";
                    $ip = tomarip();
                    $procesoautomaticotodos = false;

                    $ruta = "../../funciones/";
                    require_once("../../funciones/ordenpago/claseordenpago.php");
                    $orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);
                    if (!$orden->valida_ordenmatricula()) {
                        ?>
                        <script language="javascript">
                            history.go(-3);
                        </script>
                        <?php
                    } else {
                        require("matriculaautomaticaguardar.php");
                    }
                    exit();
                }
            }
            ?>
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        HORARIOS
                    </h3>
                </div>
            </div>
            <p>						
                <?php
                // Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
                if (is_array($materiasunserial)) {
                    foreach ($materiasunserial as $llave => $codigomateria) {
                        $deshabilitasincupo = 0;
                        // Selecciona los datos de las materias para aquellas que no son electivas, de acuerdo al plan de estudio
                        $query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio from materia m, detalleplanestudio dpe, planestudioestudiante pee where m.codigomateria = '$codigomateria' and pee.codigoestudiante = '$codigoestudiante' and m.codigomateria = dpe.codigomateria and pee.idplanestudio = dpe.idplanestudio and pee.codigoestadoplanestudioestudiante like '1%'";
                        // Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
                        // Tanto enfasis como electivas libres
                        $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                        $totalRows_datosmateria = mysql_num_rows($datosmateria);
                        if ($totalRows_datosmateria == "") {
                            // Toma los datos de la materia si es enfasis
                            $query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee where m.codigomateria = '$codigomateria' and lee.codigoestudiante = '$codigoestudiante' and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio and lee.idplanestudio = dle.idplanestudio and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio and dle.codigoestadodetallelineaenfasisplanestudio like '1%' and  (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
                            // Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
                            // Tanto enfasis como electivas libres
                            $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                            $totalRows_datosmateria = mysql_num_rows($datosmateria);
                            // Si se trata de una electiva
                        }
                        if ($totalRows_datosmateria == "") {

                            $query_datosmateria = "select m.nombremateria, m.codigomateria from materia m where m.codigomateria = '$codigomateria' and m.codigoestadomateria = '01'";
                            $datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
                            $totalRows_datosmateria = mysql_num_rows($datosmateria);
                            if (preg_match("/grupo[0-9]+/", $llave)) {
                                // Si la llave esta en materia la coje y la manda como codigomateriaelectiva
                                $query_materiapapa = "select m.nombremateria, m.codigomateria from materia m where m.codigomateria = '" . ereg_replace("grupo", "", $llave) . "' and m.codigoestadomateria = '01'";
                                $materiapapa = mysql_query($query_materiapapa, $sala) or die("$query_materiapapa");
                                $totalRows_materiapapa = mysql_num_rows($materiapapa);
                                if ($totalRows_materiapapa != "") {
                                    $mpapa = $llave;
                                }
                            } else if (preg_match("/electiva[0-9]+/", $llave)) {
                                // Al tratarse de una electiva selecciona la electiva del plan de estudios para el estudiante
                                $query_materiapapa = "select m.nombremateria, m.codigomateria from materia m where m.codigomateria = '" . ereg_replace("electiva", "", $llave) . "' and m.codigoestadomateria = '01'";
                                $materiapapa = mysql_query($query_materiapapa, $sala) or die("$query_materiapapa");
                                $totalRows_materiapapa = mysql_num_rows($materiapapa);
                                if ($totalRows_materiapapa != "") {
                                    $mpapa = $llave;
                                }
                            }
                        }
                        if ($totalRows_datosmateria != "") {
                            while ($row_datosmateria = mysql_fetch_array($datosmateria)) {
                                // Arreglo que guarda el nombre de las materias
                                $nombresmateria[$codigomateria] = $row_datosmateria['nombremateria'];
                                ?>
                            </p>
                            <div class="col-md-12">
                            <table class="table table-striped">
                                <tr>
                                    <td colspan="9" style="border-bottom-color:#000000 "><label id="labelresaltado"><?php echo $row_datosmateria['nombremateria']; ?></label></td>
                                    <td id="tdtitulogris" style="border-top-color:#000000; border-left-color:#000000; border-bottom-color:#000000">C&oacute;digo</td>
                                    <td style="border-top-color:#000000; border-right-color:#000000; border-bottom-color:#000000"><?php echo $row_datosmateria['codigomateria']; ?></td>
                                </tr>
                                <?php
                                //Selecciona los datos de los grupos para una materia
                                $query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo,  g.maximogrupoelectiva, g.matriculadosgrupo, g.matriculadosgrupoelectiva, g.codigoindicadorhorario, g.nombregrupo, g.fechainiciogrupo, g.fechafinalgrupo from grupo g, docente d where g.numerodocumento = d.numerodocumento and g.codigomateria = '$codigomateria' and g.codigoperiodo = '$codigoperiodo' and g.codigoestadogrupo = '10'";
                                $datosgrupos = mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
                                $totalRows_datosgrupos = mysql_num_rows($datosgrupos);

                                $chequear = "";
                                $desabilitar = "";

                                $poseemateria = false;
                                $vieneporelpost = false;
                                if (isset($materia_inicial)) {
                                    foreach ($materia_inicial as $llave => $codigomateriaprema) {
                                        if ($codigomateriaprema == $codigomateria) {
                                            $chequear = "";
                                            $desabilitar = "";
                                            $poseemateria = true;
                                            $desabilitardemas = true;
                                            break;
                                        }
                                    }
                                }
                                if (!$poseemateria) {
                                    // Arreglo que va a guardar el menor semestre para las materias seleccionadas de más
                                    $semestrematerias[] = $row_datosmateria['semestredetalleplanestudio'];
                                }
                                if ($totalRows_datosgrupos != "") {
                                    $tieneprimergrupoconhorarios = 0;
                                    $grupoencontrado = false;
                                    unset($desabilitardesabilitar);

                                    while ($row_datosgrupos = mysql_fetch_array($datosgrupos)) {
                                        // Selecciona los datos de los horarios
                                        $query_datoshorarios = "select h.codigodia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, d.nombredia,h.idhorario
											from horario h, dia d, salon s
											where h.codigodia = d.codigodia
											and h.codigosalon = s.codigosalon
											and h.idgrupo = '" . $row_datosgrupos['idgrupo'] . "'
											order by 1,2,3";
                                        $datoshorarios = mysql_query($query_datoshorarios, $sala) or die("$query_datoshorarios");
                                        $totalRows_datoshorarios = mysql_num_rows($datoshorarios);

                                        if ($desabilitardemas) {
                                            $desabilitar = "disabled";
                                            $chequear = "";
                                        }
                                        if ($totalRows_datoshorarios == "") {
                                            // Si el grupo no tiene horarios desabilita
                                            //$chequear = "checked";
                                            $desabilitar = "disabled";
                                        }
                                        if (preg_match("/^2+/", $row_datosgrupos['codigoindicadorhorario'])) {
                                            // Si el grupo no requiere horarios lo habilita
                                            $desabilitar = "";
                                            $chequear = "checked";
                                            $tieneprimergrupoconhorarios++;
                                        }
                                        if (!$vieneporelpost) {
                                            if ($row_datosgrupos['idgrupo'] == $_POST[$grupopost]) {
                                                $chequear = "checked";
                                                $vieneporelpost = true;
                                            }
                                        } else {
                                            $chequear = "";
                                        }
                                        if ($tieneprimergrupoconhorarios == 0) {
                                            // Si el grupo que entra tiene horario o no requiere lo chequea
                                            $chequear = "checked";
                                        }
                                        if (preg_match("/^1+/", $row_datosgrupos['codigoindicadorhorario']) || $desabilitardemas) {
                                            // Si el grupo requiere horarios lo desabilita
                                            $desabilitar = "disabled";
                                            $tieneprimergrupoconhorarios++;
                                        }
                                        if (!$poseemateria) {
                                            $desabilitar = "";
                                            //$chequear = "checked";
                                        }

                                        //$desabilitar == "disabled";
                                        $grupopost = "grupo" . $row_datosmateria['codigomateria'];

                                        // Si la materia pertenece a la carrera del estudiante se hace esto
                                        // Primero se cuentan el total y se mira si tine cupo la materia en el total
                                        // Si no se mira que la materia tenga cupo como electiva
                                        // Selecciona los datos de los horarios
                                        $query_pertenecemateria = "select codigomateria
											from materia
											where codigomateria = '$codigomateria'
											and codigocarrera = '$codigocarrera'";
                                        $pertenecemateria = mysql_query($query_pertenecemateria, $sala) or die("$query_pertenecemateria");
                                        $totalRows_pertenecemateria = mysql_num_rows($pertenecemateria);
                                        $sincupo = false;
                                        if ($totalRows_pertenecemateria != "") {
                                            $grupoencontrado = true;
                                            if (($row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva']) >= $row_datosgrupos['maximogrupo']) {
                                                $desabilitar = "disabled";
                                                $chequear = "";
                                                $sincupo = true;
                                            }
                                        } else {
                                            if (($row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva']) >= $row_datosgrupos['maximogrupo']) {
                                                $grupoencontrado = true;
                                                $desabilitar = "disabled";
                                                $chequear = "";
                                                $sincupo = true;
                                            } else if ($row_datosgrupos['maximogrupoelectiva'] != 0) {
                                                $sincupo = true;
                                                if ($row_datosgrupos['maximogrupoelectiva'] <= $row_datosgrupos['matriculadosgrupoelectiva']) {
                                                    //$sincupo;
                                                    /* $grupoencontrado = true;
                                                      $desabilitar = "disabled";
                                                      $chequear = "";
                                                      $sincupo = true;
                                                     */
                                                    continue;
                                                } else {
                                                    $grupoencontrado = true;
                                                }
                                            } else {
                                                $grupoencontrado = true;
                                            }
                                        }
                                        if ($desabilitardemas) {
                                            $chequear = "";
                                        }
                                        if (isset($grupo_inicial)) {
                                            foreach ($grupo_inicial as $llave => $idgrupoprematricula) {
                                                if ($row_datosgrupos['idgrupo'] == $idgrupoprematricula) {
                                                    $desabilitardemas = true;
                                                    $desabilitar = "disabled";
                                                    $chequear = "checked";
                                                    $deshabilitasincupo = 1;
                                                    break;
                                                }
                                            }
                                        }
                                        if ($totalRows_pertenecemateria != 0)
                                            $pertenecemateriaestudiante = 1;
                                        else
                                            $pertenecemateriaestudiante = 0;
                                        $sincupo = validacupoelectiva($row_datosgrupos, $pertenecemateriaestudiante);
                                        ?>
                                        <tr>
                                            <td id="tdtitulogris" style="border-top-color:#000000">Grupo</td>
                                            <td style="border-top-color:#000000"><?php echo $row_datosgrupos['idgrupo']; ?></td>
                                            <td id="tdtitulogris" style="border-top-color:#000000">Docente</td>
                                            <td style="border-top-color:#000000"><?php echo $row_datosgrupos['nombre']; ?></td>
                                            <td id="tdtitulogris" style="border-top-color:#000000">Nombre Grupo</td>
                                            <td style="border-top-color:#000000"><?php echo $row_datosgrupos['nombregrupo']; ?></td>
                                            <td id="tdtitulogris" style="border-top-color:#000000">Max. Grupo</td>
                                            <td style="border-top-color:#000000"><?php echo $row_datosgrupos['maximogrupo']; ?></td>
                                            <td id="tdtitulogris" style="border-top-color:#000000">Matri./Prematri.</td>
                                            <td style="border-top-color:#000000"><?php echo $row_datosgrupos['matriculadosgrupo'] + $row_datosgrupos['matriculadosgrupoelectiva']; ?></td>
                                            <td style="border-top-color:#000000">
                                                <?php
                                                if ($totalRows_materiapapa != "") {
                                                    ?>
                                                    <input type="hidden" name="<?php echo "papa" . $row_datosmateria['codigomateria']; ?>" id="<?php echo "papa" . $row_datosmateria['codigomateria']; ?>" value="<?php echo $mpapa ?>"/>
                                                    <?php
                                                }
                                                if ($chequear == "checked" && $desabilitar == "disabled") {
                                                    $desabilitardesabilitar = 1;
                                                }
                                                if (preg_match("/^1+/", $row_datosgrupos['codigoindicadorhorario'])) {
                                                    if ($totalRows_datoshorarios == "") {
                                                        $desabilitar = "disabled";
                                                        $type = "checkbox";
                                                    }
                                                }
                                                if ($sincupo) {
                                                    //$desabilitar="disabled";
                                                    if ($poseemateria) {
                                                        $type = "radio";
                                                        $desabilitardesabilitar = 1;
                                                    } else {
                                                        $type = "checkbox";
                                                        $desabilitar = "disabled";
                                                        $chequear = "";
                                                    }

                                                    if (isset($_POST["check" . $codigomateria])) {
                                                        $desabilitar = "disabled";
                                                        if (!$poseemateria)
                                                            $chequear = "";
                                                        //$id="inhabilita";
                                                    }

                                                    if (!$deshabilitasincupo)
                                                        $sincupo = "sincupo";
                                                    else
                                                        $sincupo = "habilita";
                                                    ?>
                                                    <label id="labelresaltado">Sin cupo</label>
                                                    <input name="<?php echo "grupo" . $row_datosmateria['codigomateria']; ?>" type="<?php echo $type ?>" id='<?php echo $sincupo ?>' value="<?php echo $row_datosgrupos['idgrupo']; ?>" <?php echo "$chequear $desabilitar"; ?>/>
                                                    <?php
                                                }
                                                else {
                                                    if (isset($_POST["check" . $codigomateria])) {
                                                        $desabilitar = "disabled";
                                                        $chequear = "";
                                                        //$id="inhabilita";
                                                    }
                                                    ?>
                                                    <input name="<?php echo "grupo" . $row_datosmateria['codigomateria']; ?>" type="radio" id='habilita' value="<?php echo $row_datosgrupos['idgrupo']; ?>" <?php echo "$chequear $desabilitar"; ?> onclick="Previsualizar(this.value)"/>
                                                    <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="11">
                                                <table cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="100%">
                                                    <td><strong>Fecha de Inicio:</strong></td>
                                                    <td><?php echo $row_datosgrupos['fechainiciogrupo']; ?></td>
                                                    <td><strong>Fecha de Vencimiento:</strong></td>
                                                    <td><?php echo $row_datosgrupos['fechafinalgrupo']; ?></td>
                                                    <?php
                                                    if (preg_match("/^1+/", $row_datosgrupos['codigoindicadorhorario'])) {
                                                        if ( !empty($totalRows_datoshorarios) ) {
                                                            $tieneprimergrupoconhorarios++;
                                                            ?>
                                                            <tr id="trtitulogris">
                                                                <td>D&iacute;a</td>
                                                                <td>Hora Inicial</td>
                                                                <td>Hora Final</td>
                                                                <td>Sal&oacute;n</td>
                                                            </tr>
                                                            <?php
                                                            while ($row_datoshorarios = mysql_fetch_array($datoshorarios)) {
                                                                $tieneprimergrupoconhorarios++;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo $row_datoshorarios['nombredia'];
                                                                        ?></td>
                                                                    <td><?php echo $row_datoshorarios['horainicial']; ?></td>
                                                                    <td><?php echo $row_datoshorarios['horafinal']; ?></td>
                                                                    <td><?php echo $row_datoshorarios['codigosalon']; ?></td>
                                                                </tr>
                                                                <?php
                                                            }
                                                        } else {
                                                            $horariorequerido = true;
                                                            $desabilitardesabilitar = 1;
                                                            //echo "totalRows_datoshorarios=" . $totalRows_datoshorarios;
                                                            //echo " row_datosgrupos[codigoindicadorhorario]" . $row_datosgrupos['codigoindicadorhorario'] . "<BR>";
                                                            ?>
                                                            <tr>
                                                                <td colspan="11"><label id="labelresaltado">Este grupo requiere horario, dirijase a su facultad para informarlo.</label></td>
                                                            </tr>
                                                            <?php
                                                        }
                                                    } else {
                                                        //continue;
                                                        ?>
                                                        <tr>
                                                            <td colspan="11"><label id="labelresaltado">Este grupo no necesita horario.</label></td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </table>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    if (!$grupoencontrado) {
                                        foreach ($materiaselegidas as $key => $value) {
                                            if ($value != $codigomateria) {
                                                $materiasseleccionadastemp[] = $value;
                                            } else {
                                                //codigomateria
                                            }
                                        }
                                        unset($materiaselegidas);
                                        $materiaselegidas = $materiasseleccionadastemp;
                                        unset($materiasseleccionadastemp);
                                        ?>
                                        <tr>
                                            <td colspan="11"><label id="labelresaltado">Esta materia no tiene grupos, informelo a la facultad. Regrese y deseleccione la materia, o si continua no le ser&aacute; adicionada la materia.</label></td>
                                        </tr>
                                        <?php
                                    }
                                } else {
                                    foreach ($materiaselegidas as $key => $llave) {
                                        if ($llave != $codigomateria) {
                                            $materiasseleccionadastemp[] = $llave;
                                        } else {
                                            //codigomateria;
                                        }
                                    }
                                    unset($materiaselegidas);
                                    $materiaselegidas = $materiasseleccionadastemp;
                                    unset($materiasseleccionadastemp);
                                    ?>
                                    <tr>
                                        <td colspan="11"><label id="labelresaltado">Esta materia no tiene grupos, informelo a la facultad. Regrese y deseleccione la materia, o si continua no le ser&aacute; adicionada la materia.</label></td>
                                    </tr>
                                    <?php
                                }
                                ?>
<!--                                <tr>-->
<!--                                    <td colspan="11">&nbsp;</td>	-->
<!--                                </tr>-->
                                <?php
                                if (!$desabilitardesabilitar) {
                                    if (isset($_POST["check" . $codigomateria]))
                                        $checkeddesabilitar = "checked";
                                    ?>
                                    <tr>
                                        <td colspan="11"  align="right" id="tdtitulogris">Deshabilitar
                                            <input name="check<?php echo $codigomateria ?>" value="check<?php echo $codigomateria ?>" type="checkbox"  <?php echo $checkeddesabilitar . " " . $desabilitar ?> onClick="desabilitarmateria('<?php echo "grupo" . $codigomateria ?>', this, '<?php echo $codigomateria ?>');"/>
                                        </td>
                                    </tr>
                                    <?php
                                }
                                ?>
                            </table>
                            </div>
                            <?php
                        }
                    }
                }
            }
            ?>
            <!-- ESTE DIV MUESTRA LA TABLA DEL CALENDARIO DE LOS GRUPOS SELECCIONADOS POR EL ESTUDIANTE-->
            <div style="position:fixed !important;right:0px; top:0px; z-index:10 !important; display:none">					
                <CENTER><p>PREVIZUALIZACION DEL HORARIO SELECCIONADO</p></CENTER>
                <table border="2" width="500px" id="calendario">
                    <thead style="font-size:90%;">
                    <th>Horas</th><th>LUNES</th><th>MARTES</th><th>MIERCOLES</th><th>JUEVES</th><th>VIERNES</th><th>SABADO</th>
                    </thead>
                    <tbody nowrap style="font-size:90%;">
                        <tr id="h7" style="display:none;">
                            <td>7:00</td><td id="d17"></td><td id="d27"></td><td id="d37"></td><td id="d47"></td><td id="d57"></td><td id="d67"></td>
                        </tr>
                        <tr id="h8" style="display:none;">
                            <td>8:00</td><td id="d18" ></td><td id="d28"></td><td id="d38"></td><td id="d48"></td><td id="d58"></td><td id="d68"></td>
                        </tr>
                        <tr id="h9" style="display:none;">
                            <td>9:00</td><td id="d19" ></td><td id="d29"></td><td id="d39"></td><td id="d49"></td><td id="d59"></td><td id="d69"></td>
                        </tr>
                        <tr id="h10" style="display:none;">
                            <td>10:00</td><td id="d110"></td><td id="d210"></td><td id="d310"></td><td id="d410"></td><td id="d510"></td><td id="d610"></td>
                        </tr>
                        <tr id="h11" style="display:none;">
                            <td>11:00</td><td id="d111"></td><td id="d211"></td><td id="d311"></td><td id="d411"></td><td id="d511"></td><td id="d611"></td>
                        </tr>
                        <tr id="h12" style="display:none;">
                            <td>12:00</td><td id="d112"></td><td id="d212"></td><td id="d312"></td><td id="d412"></td><td id="d512"></td><td id="d612"></td>
                        </tr>
                        <tr id="h13" style="display:none;">
                            <td>13:00</td><td id="d113"></td><td id="d213"></td><td id="d313"></td><td id="d413"></td><td id="d513"></td><td id="d613"></td>
                        </tr>
                        <tr id="h14" style="display:none;">
                            <td>14:00</td><td id="d114"></td><td id="d214"></td><td id="d314"></td><td id="d414"></td><td id="d514"></td><td id="d614"></td>
                        </tr>
                        <tr id="h15" style="display:none;">
                            <td>15:00</td><td id="d115"></td><td id="d215"></td><td id="d315"></td><td id="d415"></td><td id="d515"></td><td id="d615"></td>
                        </tr>
                        <tr id="h16" style="display:none;">
                            <td>16:00</td><td id="d116"></td><td id="d216"></td><td id="d316"></td><td id="d416"></td><td id="d516"></td><td id="d616"></td>
                        </tr>
                        <tr id="h17" style="display:none;">
                            <td>17:00</td><td id="d117"></td><td id="d217"></td><td id="d317"></td><td id="d417"></td><td id="d517"></td><td id="d617"></td>
                        </tr>
                        <tr id="h18" style="display:none;">
                            <td>18:00</td><td id="d118"></td><td id="d218"></td><td id="d318"></td><td id="d418"></td><td id="d518"></td><td id="d618"></td>
                        </tr>
                        <tr id="h19" style="display:none;">
                            <td>19:00</td><td id="d119"></td><td id="d219"></td><td id="d319"></td><td id="d419"></td><td id="d519"></td><td id="d619"></td>
                        </tr>
                        <tr id="h20" style="display:none;">
                            <td>20:00</td><td id="d120"></td><td id="d220"></td><td id="d320"></td><td id="d420"></td><td id="d520"></td><td id="d620"></td>
                        </tr>
                        <tr id="h21" style="display:none;">
                            <td>21:00</td><td id="d121"></td><td id="d221"></td><td id="d321"></td><td id="d421"></td><td id="d521"></td><td id="d621"></td>
                        </tr>
                    </tbody>
                </table>
                <button id="limpiar">limpiar</button>
                <p>Seleccione los grupos a los que se desea matricular. </p><p>Si en algun momento se muestra el color <span>ROJO</span> usted tiene un cruce de horarios.</p>
            </div>
            <!-- FIN DIV-->
            <p>				
                <input class="btn btn-info btn-sm" name="grabar" type="submit" id="grabar" value="Grabar"  onClick="habilitar(this.form.habilita);"/>&nbsp;
                <?php
                if ($_GET['documentoingreso']) {
                    ?>
                    <input type="hidden" value="<?php echo $_GET['documentoingreso']; ?>" name="documentoingreso"/>
                    <input class="btn btn-danger btn-sm" name="regresar" type="button" id="regresar" value="Regresar" onClick="window.location.href = 'matriculaautomatica.php?documentoingreso=<?php echo $_GET['documentoingreso']; ?>'"/>
                    <?php
                    //exit();
                } else {
                    ?>
                    <input class="btn btn-danger btn-sm" name="regresar" type="button" id="regresar" value="Regresar" onClick="window.location.href = 'matriculaautomatica.php?programausadopor=<?php echo $_GET['programausadopor']; ?>'"/>
                    <?php
                }
                ?>
            </p>
        </form>
        <?php
        //inicia el proceso de guradado
        $permisograbar = true;
        
        if (isset($_POST['grabar'])) {
            foreach ($_POST as $llavepost => $valorpost) {
                //VALIDA LOS NOMBRES DE LOS GRUPOS Y LOS CODIGOS DE CADA UNO
                if (preg_match("/grupo/", $llavepost)) {
                    $codmat = ereg_replace("grupo", "", $llavepost);
                    $materiasescogidaspost[] = $codmat;
                }
            }

            $materiasprerequisitosesion = $_SESSION["materiascorrequisitosesion"];

            for ($conprereq = 0; $conprereq < count($materiasprerequisitosesion["materiapapa"]); $conprereq++) {
                $seguir = 0;
                if (in_array($materiasprerequisitosesion["materiahija"][$conprereq], $materiasprerequisitosesion["materiapapa"])) {
                    if (in_array($materiasprerequisitosesion["materiapapa"][$conprereq], $materiasprerequisitosesion["materiapapa"])) {
                        $seguir = 1;
                    }
                }

                if ($seguir)
                    if ($materiasprerequisitosesion["estado"][$conprereq] == "200") {
                        if (!in_array($materiasprerequisitosesion["materiapapa"][$conprereq], $materiasescogidaspost)) {
                            echo '<script language="javascript"> alert("La materia ' . $materiasprerequisitosesion["materiapapa"][$conprereq] . ' debe seleccionarse ya que tiene seleccionado un corequisito doble"); //window.location.href="matriculaautomatica.php?programausadopor=' . $_GET['programausadopor'] . '"; </script>';
                            exit();
                        }
                        if (!in_array($materiasprerequisitosesion["materiahija"][$conprereq], $materiasescogidaspost)) {
                            echo '<script language="javascript"> alert("La materia ' . $materiasprerequisitosesion["materiahija"][$conprereq] . ' debe seleccionarse ya que tiene seleccionado un corequisito doble"); //window.location.href="matriculaautomatica.php?programausadopor=' . $_GET['programausadopor'] . '";	</script>';
                            exit();
                        }
                    }

                if ($seguir)
                    if ($materiasprerequisitosesion["estado"][$conprereq] == "201") {
                        if (in_array($materiasprerequisitosesion["materiahija"][$conprereq], $materiasescogidaspost)) {
                            if (!in_array($materiasprerequisitosesion["materiapapa"][$conprereq], $materiasescogidaspost)) {
                                echo '<script language="javascript"> alert("La materia ' . $materiasprerequisitosesion["materiapapa"][$conprereq] . ' debe seleccionarse ya que tiene como corequisito sencillo a ' . $materiasprerequisitosesion["materiahija"][$conprereq] . '"); 			//window.location.href="matriculaautomatica.php?programausadopor=' . $_GET['programausadopor'] . '"; </script>';
                                exit();
                            }
                        }
                    }
            }//for				
            unset($_SESSION["materiascorrequisitosesion"]);
            
            if (!$ffechapago) {
                $permisograbar = false;
            }
            foreach ($_POST as $llavepost => $valorpost) {
                //VALIDA LOS DATOS DE LAS VARIABLES grupo
                if (preg_match("/grupo/", $llavepost)) {
                    //ELIMINA LA PALABRA grupo  DE LOS IDGRUPOS
                    $codmat = ereg_replace("grupo", "", $llavepost);
                    $codmatpapa = $_POST['papa' . $codmat . ''];

                    //SE GUARDA EL CODIGO DEL GRUPO PARA UNA MATERIA
                    $materiascongrupo[$codmat] = $valorpost;
                    $materiaspapa[$codmat] = $codmatpapa;

                    // $valorpost SE ASLIGA EL IDGRUPO
                    $query_horarioselegidos = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon,h.idhorario,fechainiciogrupo,fechafinalgrupo from horario h, dia d, salon s, grupo g where h.codigodia = d.codigodia and h.codigosalon = s.codigosalon	and h.idgrupo = '$valorpost' and g.idgrupo = h.idgrupo and g.codigoindicadorhorario like '1%' order by 1,3,4";
                    $horarioselegidos = mysql_query($query_horarioselegidos, $sala) or die("$query_horarioselegidos");
                    $totalRows_horarioselegidos = mysql_num_rows($horarioselegidos);

                    while ($row_horarioselegidos = mysql_fetch_array($horarioselegidos)) {
                        //ASIGNACION DE DATOS A NUEVAS VARIABLES
                        $iniciogrupo[] = $row_horarioselegidos['fechainiciogrupo'];
                        $fingrupo[] = $row_horarioselegidos['fechafinalgrupo'];
                        $codigomateriahorarios[] = ereg_replace("grupo", "", $llavepost);
                        $diahorarios[] = $row_horarioselegidos['codigodia'];
                        $horainicialhorarios[] = $row_horarioselegidos['horainicial'];
                        $horafinalhorarios[] = $row_horarioselegidos['horafinal'];
                    }//while
                }//if
            }//for
            
            $maximohorarios = count($codigomateriahorarios) - 1;
            //SE EJECUTA MIENTRAS CONTENGA HORARIOS
            //EL PRIMER FOR COMPARAR CADA UNO DE LOS HORARIOS CON EL SEGUNDO FOR PARA VERIFICAR CRUCES DE HORARIOS
            for ($llavehorario1 = 0; $llavehorario1 <= $maximohorarios; $llavehorario1++) {
                for ($llavehorario2 = 0; $llavehorario2 <= $maximohorarios; $llavehorario2++) {
                    if ($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2) {
                        if ((date("H-i-s", strtotime($horainicialhorarios[$llavehorario1])) >= date("H-i-s", strtotime($horainicialhorarios[$llavehorario2])))and ( date("H-i-s", strtotime($horainicialhorarios[$llavehorario1])) < date("H-i-s", strtotime($horafinalhorarios[$llavehorario2])))) {
                            if ((($iniciogrupo[$llavehorario1] >= $iniciogrupo[$llavehorario2])and ( $iniciogrupo[$llavehorario1] < $fingrupo[$llavehorario2])) or ( ($iniciogrupo[$llavehorario2] >= $iniciogrupo[$llavehorario1])and ( $iniciogrupo[$llavehorario2] < $fingrupo[$llavehorario1]))) {
                                //SI SE PRESENTA CRUCE MUESTRA EL SIGUIENTE MENSAJE
                                $permisograbar = false;
                                echo '<script language="JavaScript">
										alert("FAVOR VERIFICAR HORARIOS SELECCIONADOS, SE PRESENTA CRUCE ENTRE LA MATERIA:  ' . $nombresmateria[$codigomateriahorarios[$llavehorario1]] . ' Y LA MATERIA:  ' . $nombresmateria[$codigomateriahorarios[$llavehorario2]] . '");
									</script>';
                                $llavehorario1 = $maximohorarios + 1;
                                $llavehorario2 = $maximohorarios + 1;
                            }//if
                        }//if
                    }//if
                }//for
            }//for
            
            if ($permisograbar == true) {
                if (isset($_GET['tieneenfasis'])) {
                    $calcularcreditosenfasis = true;
                } else {
                    $calcularcreditosenfasis = false;
                }
                $procesoautomatico = false;
                if (isset($_GET['lineaunica'])) {
                    $lineaescogida = $_GET['lineaunica'];
                } else {
                    $lineaescogida = "";
                }
                $ip = tomarip();
                $procesoautomaticotodos = false;

                $ruta = "../../funciones/";
                
                require_once("../../funciones/ordenpago/claseordenpago.php");
                
                $orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);

                // Si la generación de la orden se hace para los de pregrado o igual a ellos
                if (preg_match("/^1.+$/", $codigoindicadortipocarrera)) {
                    $orden_valida_ordenmatricula = $orden->valida_ordenmatricula();

                    if (!$orden_valida_ordenmatricula) {
                        ?>
                        <script language="javascript">
                            history.go(-3);
                        </script>
                        <?php
                    } else {
                        //Entro a valida_ordenmatricula en el archivo matriculaautomaticahorarios: :</h1>";
                        // Si la orden es generada para pregrados se hace lo siguiente
                        require("matriculaautomaticaguardar.php");
                        //saprfc_close($rfc);
                    }
                }
                // Si la generación de la orden se hace para los cursos certificados
                if (preg_match("/^2.+$/", $codigoindicadortipocarrera) && preg_match("/^1.+$/", $row_datosestudiante['codigoreferenciacobromatriculacarrera'])) {
                    if (!$orden->valida_ordenmatriculacursoscertificados()) {
                        //exit();
                        ?>
                        <script language="javascript">
                            history.go(-3);
                        </script>
                        <?php
                    } else {
                        // Si la orden es generada como se hace para pregrados se hace lo siguiente
                        echo "No lo encuentra";
                        require("matriculaautomaticaguardar.php");
                    }
                }
                // Si la generación de la orden se hace para los cursos libres
                if (preg_match("/^3.+$/", $codigoindicadortipocarrera)) {
                    if (!$orden->valida_ordenmatriculacursoslibres($materiascongrupo)) {
                        //exit();
                        ?>
                        <script language="javascript">
                            history.go(-3);
                        </script>
                        <?php
                    } else {
                        // Si la orden es generada para pregrados se hace lo siguiente
                        require("matriculaautomaticaguardar.php");
                    }
                }
            }//if permisograbar
        }//if grabar
        ?>

        <script type="text/javascript">
            function habilitar(campo){
                var entro = false;
                for (i = 0; i < campo.length; i++){
                    campo[i].disabled = false;
                    entro = true;
                }
                if(!entro){
                    form1.habilita.disabled = false;
                }
            }//function habilitar
            var desabilitado=true;

            function desabilitarmateria(botonradio,obj,codigomateria){
                var campo=form1.habilita;
                var campomateriapapa=document.getElementById("papa"+codigomateria);
                
                var totalcampos=campo.length;
                
                for (i = 0; i < totalcampos; i++){
                    if(campo[i].name==botonradio){
                        if(obj.checked){
                            campo[i].disabled = true;
                            campo[i].checked = false;
                            if(campomateriapapa!=null){
                                campomateriapapa.disabled=true;
                            }
                        }else{
                            campo[i].disabled = false;
                            if(campomateriapapa!=null){
                                campomateriapapa.disabled=false;
                                campo[i].type = "radio";
                            }
                        }
                    }
                }
            }//function desabilitarmateria

            function Previsualizar(grupoid){
                //var grupoid =  grupo.value;
                $.ajax({
                    type: 'post',
                    url: 'HorarioPrevisualizar.php',
                    data: {grupoid:grupoid},
                    success: function(data){
                        var datos = jQuery.parseJSON(data);
                        var horasi = datos.horai;
                        var horasf = datos.horaf;
                        var dias = datos.dia;
                        var gruponombre = datos.grupo;
                        var idgrupo = datos.idgrupo;
                        var codmateria = datos.codmateria;
                        var nombremateria = datos.nombremateria;
                        var tableReg = document.getElementById('calendario');
                        
                        for (var i = 1; i < tableReg.rows.length; i++){
                            var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                            for (var j = 0; j < cellsOfRow.length ; j++){
                                var compareWith = cellsOfRow[j].innerHTML.toLowerCase();
                                if (compareWith.indexOf(codmateria[0]+'m') > -1){
                                    var k = 6+i;
                                    $('#d'+j+k).text("");
                                    $('#d'+j+k).css("background-color", "#ffffff");//blanco
                                }
                            }
                        }
                        
                        $.each(dias, function( k, v ){
                            final = parseInt(horasf[k]);
                            inicial = parseInt(horasi[k]);
                            
                            for(var inicial = horasi[k]; inicial < final; inicial++){
                                $('#h'+inicial).show();
                                var textCell = $('#d'+v+''+inicial).text();
                                textCell = textCell.trim();
                                
                                if(textCell){
                                    if($('#d'+v+''+inicial).text().indexOf(idgrupo[0]) == -1){
                                        $('#d'+v+''+inicial).css("background-color", "#E72512");//rojo
                                        $('#d'+v+''+inicial).append(" ---------- "+nombremateria[0]+"<div style='display: none;'>"+idgrupo[0]+' - '+codmateria[0]+'m '+"<div>");
                                    }
                                }else{
                                    $('#d'+v+''+inicial).css("background-color", "#57A639");//verde
                                    $('#d'+v+''+inicial).append(nombremateria[0]+"<div style='display: none;'>"+idgrupo[0]+' - '+codmateria[0]+'m '+"<div>");
                                }
                            }
                        });
                    }//function data
                });
            }//function Previsualizar

            function Limpiar(){
                var tableReg = document.getElementById('calendario');
                for (var i = 1; i < tableReg.rows.length; i++){
                    var cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
                    for (var j = 0; j < cellsOfRow.length ; j++){
                        var k = 6+i;
                        $('#d'+j+k).text("");
                        $('#d'+j+k).css("background-color", "#ffffff");//blanco
                    }
                }
            }//function Limpiar	
        </script>
    </div>
    </body>
</html>