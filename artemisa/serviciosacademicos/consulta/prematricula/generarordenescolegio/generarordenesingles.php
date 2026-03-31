<?php
    $fechahoy = date("Y-m-d H:i:s");
    session_start();

    require_once(realpath(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php"));

    if(!isset($_SESSION['MM_Username'])){
        echo "No tiene permiso para acceder a esta opción";
        exit();
    }
    $codigoestudiante = $_SESSION['codigo'];
    $codigoperiodo = $_SESSION['codigoperiodosesion'];

    //consulta de listado de materias
    $query_materia = "select m.codigomateria, m.nombremateria, m.codigocarrera, ca.nombrecarrera ".
    " from carrera ca, materia m where ca.codigocarrera = m.codigocarrera ".
    " and ca.codigocarrera = '341' and m.codigoestadomateria = '01' order by m.nombremateria";
    $row_materia = $db->GetAll($query_materia);
?>
<html>
    <head>
        <title>Ordenes de ingles</title>
        <?php
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/bootstrap.min.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/custom.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/general.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT . "/assets/css/sweetalert.css");

        echo Factory::printImportJsCss("js", HTTP_ROOT . "/assets/js/sweetalert.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/jquery-3.1.1.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/spiceLoading/pace.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/sala/assets/js/bootstrap.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT . "/serviciosacademicos/consulta/prematricula/generarordenescolegio/ordenesingles.js");
        ?>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
    <div class="container">
        <h3>GENERACIÓN ORDENES DE INGLES</h3>
        <form class="form-horizontal" name="formIngles" id="formIngles"  method="POST" enctype="multipart/form-data">
            <input type="hidden" id="codigoestudiante" name="codigoestudiante" value="<?php echo $codigoestudiante; ?>">
            <input type="hidden" id="codigoperiodo" name="codigoperiodo" value="<?php echo $codigoperiodo; ?>">
            <div class="row">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="materia">Seleecione la Materia:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="codigomateria" id="codigomateria" onchange="mostrarGrupos(this);">
                            <option value="">Seleccionar</option>
                            <?php
                            foreach ($row_materia as $materias) {
                                ?>
                                <option value="<?php echo $materias['codigomateria']; ?>"
                                    <?php
                                    if (isset($_POST['codigomateria']) && $materias['codigomateria'] == $_POST['codigomateria']) {
                                        echo "Selected";
                                    }
                                    ?>>
                                    <?php echo $materias['nombremateria']; ?>
                                </option>
                                <?php
                            }//foreach
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            </table>
            <div class="row col-md-12" id="divgruposyhorarios">

            </div>
            <div class="row col-md-12" id="divgenerarorden">

            </div>
        </form>
        <div class="col-md-12 row">
            <?php
            //consulta de periodo activo o en inscripcion
            $query_selperiodoprevig = "select p.codigoperiodo from periodo p where ".
                "(p.codigoestadoperiodo like '1%' or p.codigoestadoperiodo like '3%') order by 1";
            $row_periodo = $db->GetRow($query_selperiodoprevig);
            if(isset($row_periodo['codigoperiodo']) && !empty($row_periodo['codigoperiodo'])) {
                $codigoperiodoact = $row_periodo['codigoperiodo'];
                $codigoperiodopre = $_SESSION['codigoperiodosesion'];
            }
            else{
                ?>
                <div class="alert alert-info" role="alert" >
                    <p style="font-size: 17px;font-family: 'Darker Grotesque', sans-serif">
                        El sistema no tiene un periodo activo.
                    </p>
                </div>
                <?php
            }

            //$ordenesxestudiante->mostrar_ordenespago($rutaorden, "");
            $queryOrdenesEstudiante = " SELECT count(numeroordenpago) as 'conteo' FROM ordenpago ".
                " where codigoperiodo = ".$_SESSION['codigoperiodosesion']." ".
                " and codigoestudiante = $codigoestudiante ".
                " and (codigoestadoordenpago like '1%' or codigoestadoordenpago like '4%' or codigoestadoordenpago like '6%')";
            $row_ordenes = $db->GetRow($queryOrdenesEstudiante);

            if(isset($row_ordenes['conteo']) && $row_ordenes['conteo'] > 0) {
                ?>
                <button class="btn btn-fill-green-XL" onclick="verOrdenes('<?php echo $_SESSION['codigo']; ?>','<?php
                echo $codigoperiodopre; ?>','<?php echo $codigoperiodoact; ?>','<?php echo $codigoperiodo; ?>')">
                    Ver Ordenes de Pago
                </button>
                <?php
            }
            else{
                ?>
                <div class="alert alert-info" role="alert" >
                    <p style="font-size: 17px;font-family: 'Darker Grotesque', sans-serif">
                        El estudiante no posee ordenes
                    </p>
                </div>
                <?php
            }
            ?>
        </div>
        <div class="row col-md-12" id="divOrdenes">

        </div>
        <div class="row col-md-12">
            <button class="btn btn-fill-green-XL" onClick="window.location.href='../matriculaautomaticaordenmatricula.php'">Regresar</button>
        </div>
    </div>
    </body>
</html>
