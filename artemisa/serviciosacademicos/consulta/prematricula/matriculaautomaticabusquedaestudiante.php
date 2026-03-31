<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

session_start();
include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));

$aplicararp = "";
if(isset($_GET['aplicaarp'])){
    $aplicararp = "&aplicaarp";
}
$strperidosesion = "";
if(isset($_SESSION['codigoperiodosesion'])){
    $strperidosesion = "and est.codigoperiodo <= '".$_SESSION['codigoperiodosesion']."'";
}

if($_SESSION['MM_Username'] == 'admincredito') {
    session_unregister($_SESSION['codigofacultad']);
    unset($_SESSION['codigofacultad']);
}

$codigocarrera = $_SESSION['codigofacultad'];
foreach($_POST as $materia => $valor){
    $asignacion = "\$" . $materia . "='" . $valor . "';";
}
?>
<html lang="es">
<head>
    <title>Busqueda estudiante</title>
    <meta http-equiv="pragma" content="no-cache"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <script src="../../../assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
    <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
    </style>
    <!--  loading cornerIndicator  -->
    <link href="<?php echo HTTP_SITE; ?>/assets/css/cornerIndicator/cornerIndicator.css" rel="stylesheet">
    <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
</head>
<script language="javascript">
    function cambia_tipo(){
        //tomo el valor del select del tipo elegido
        var tipo;
        tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value
        //miro a ver si el tipo estï¿½ definido
        if (tipo == 1){
            window.location.href="matriculaautomaticabusquedaestudiante.php?busqueda=nombre<?php
                if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
        }
        if (tipo == 2){
            window.location.href="matriculaautomaticabusquedaestudiante.php?busqueda=apellido<?php
                if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
        }
        if (tipo == 3){
            window.location.href="matriculaautomaticabusquedaestudiante.php?busqueda=codigo<?php
                if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
        }
        if (tipo == 4){
            window.location.href="matriculaautomaticabusquedaestudiante.php?busqueda=documento<?php
                if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
        }
        if (tipo == 5){
            window.location.href="matriculaautomaticabusquedaestudiante.php?busqueda=email<?php
                if(isset($_GET['aplicaarp'])){echo $aplicararp;}?>";
        }
    }

    function buscar(){
        //tomo el valor del select del tipo elegido
        var busca
        busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value
        //miro a ver si el tipo estï¿½ definido
        if (busca != 0){
            window.location.href="matriculaautomaticabusquedaestudiante.php?buscar="+busca;
        }
    }
</script>

<body>
<div align="center">
    <form name="f1" action="matriculaautomaticabusquedaestudiante.php" method="get">
        <table class="table table-bordered " style="width: 70%;font-size:13px">
            <tr id="trtituloNaranjaInst">
                <td class="text-center">
                CRITERIO DE B&Uacute;SQUEDA
                </td>
            </tr>
            <tr>
                <td style="width: 30%" class="tdtituloWhiteInst" align="center">
                    B&uacute;squeda por:
                    <select name="tipo" onChange="cambia_tipo()" class="form-control" style="width: 50%">
                        <option value="0">Seleccionar</option>
                        <option value="1" <?php echo ($_GET['busqueda']=='nombre')?'selected':''?>>Nombre</option>
                        <option value="2" <?php echo ($_GET['busqueda']=='apellido')?'selected':''?>>Apellido</option>
                        <!-- <option value="3">Cï¿½digo</option> -->
                        <option value="4" <?php echo ($_GET['busqueda']=='documento')?'selected':''?>>Documento</option>
                        <option value="5" <?php echo ($_GET['busqueda']=='email')?'selected':''?>>Correo institucional o personal</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="tdtituloWhiteInst text-center" style="align-items: center">
                    <div align="center">
                    <?php
                    if(isset($_GET['busqueda'])){
                        if($_GET['busqueda']=="nombre"){
                            echo "<strong>Digite un nombre : </strong>
                            <input class='form-control' style='width:50% ' name='busqueda_nombre' type='text'>";
                        }
                        if($_GET['busqueda']=="apellido"){
                            echo "<strong>Digite un Apellido : </strong>
                            <input class='form-control' style='width:50% ' name='busqueda_apellido' type='text'>";
                        }
                        if($_GET['busqueda']=="codigo"){
                            echo "<strong>Digite un C&oacute;digo : </strong>
                            <input class='form-control' style='width:50%' name='busqueda_codigo' type='text'>";
                        }
                        if($_GET['busqueda']=="documento"){
                            echo "<strong>Digite Documento o C&oacute;digo: </strong>
                            <input class='form-control' style='width:50%' name='busqueda_documento' type='text'>";
                        }
                        if($_GET['busqueda']=="email"){
                            echo "<strong>Digite correo institucional o personal: </strong>
                                <input class='form-control' style='width:50%' name='busqueda_email' type='text'>";
                        }
                        if($_GET['busqueda']=="credito"){
                            echo "Digite un N&uacute;mero de Credito : 
                            <input class='form-control' style='width:50%' name='busqueda_credito' type='text'>";
                        }
                        ?>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="tdtituloWhiteInst">
                        <strong>Toda la Universidad <input type="radio" name="tipobusqueda" checked value="Universidad">&nbsp;
                            Toda la Facultad <input type="radio" name="tipobusqueda" checked value="Facultad"></strong></td>
                </tr>
                <tr>
                    <td align="center" class="tdtituloWhiteInst">
                        <strong>Periodo de Ingreso:
                            <?php
                            //lista de periodos de las carreras activas
                            $query_selperiodos = "select p.codigoperiodo, p.nombreperiodo ".
                            " from periodo p, carreraperiodo cp where cp.codigocarrera = '$codigocarrera' ".
                            " and p.codigoperiodo = cp.codigoperiodo  ORDER BY p.codigoperiodo DESC";
                            $selperiodos = $db->GetAll($query_selperiodos);
                            $totalRows_selperiodos = count($selperiodos);
                            //si el resultado es 0 muestra los periodos registrados
                            if($totalRows_selperiodos == "0"){
                                $query_selperiodos = "select p.codigoperiodo, p.nombreperiodo from periodo p ".
                                " ORDER BY p.codigoperiodo DESC";
                                $selperiodos = $db->GetAll($query_selperiodo);
                            }
                            ?>
                            <select name="periodo" class="form-control" style="width: 50%;">
                                <option value="0" selected>Todos</option>
                                <?php
                                foreach($selperiodos as $row_selperiodos){
                                ?>
                                    <option value="<?php echo $row_selperiodos['codigoperiodo'];?>">
                                        <?php echo $row_selperiodos['nombreperiodo'];?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" align="center" class="Estilo1">
                        <?php
                        if(isset($_GET['aplicaarp'])){
                            ?>
                            <input type="hidden" name="aplicaarp" value="<?php echo $_GET['aplicaarp'];?>">
                            <?php
                        }
                        ?>
                        <input name="buscar" type="submit" value="Buscar" class="btn btn-success">&nbsp;
                    </td>
                </tr>
                <?php
            }

            if(isset($_GET['buscar'])){
                ?>
        </table>
        <div class="alert alert-info" role="alert" class="col-md-offset-1" style="width: 60%">
            <p style="font-size: 17px;font-family: 'Darker Grotesque', sans-serif">
                Seleccione el estudiante que desee consultar de la siguiente tabla:
            </p>
        </div>

        <table style="width: 70%;font-size:13px" class="table table-bordered">
            <tr id="trtituloNaranjaInst">
                <td align="center">Nombre estudiante</td>
                <td align="center">Documento</td>
                <td align="center">Periodo de ingreso</td>
                <td align="center">Situaci&oacute;n</td>
            </tr>
            <?php
            $query_solicitud = "";
            $strperiodo = "";
            if ($_GET['periodo'] != "0") {
                $strperiodo = "and est.codigoperiodo = '" . $_GET['periodo'] . "'";
            }

            $sqlbusqueda = "SELECT DISTINCT eg.idestudiantegeneral, " .
                " concat(eg.apellidosestudiantegeneral,' ',eg.nombresestudiantegeneral) AS nombre," .
                " eg.numerodocumento, p.nombreperiodo, s.nombresituacioncarreraestudiante " .
                " FROM estudiante est " .
                " inner join estudiantegeneral eg on est.idestudiantegeneral = eg.idestudiantegeneral " .
                " inner join estudiantedocumento ed on eg.idestudiantegeneral = ed.idestudiantegeneral " .
                " inner join carrera c on est.codigocarrera = c.codigocarrera " .
                " inner join periodo p on est.codigoperiodo = p.codigoperiodo " .
                " inner join situacioncarreraestudiante s on est.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante" .
                " where " .
                " ed.fechainicioestudiantedocumento <= '" . date("Y-m-d H:m:s", time()) . "' " .
                " and ed.fechavencimientoestudiantedocumento >= '" . date("Y-m-d H:m:s", time()) . "' ";

            //busqueda por nombre
            if (isset($_GET['busqueda_nombre']) && !empty($_GET['busqueda_nombre'])) {
                $nombre = $_GET['busqueda_nombre'];
                if ($_GET['tipobusqueda'] == "Universidad") {
                    $query_solicitud = " and eg.nombresestudiantegeneral LIKE '%$nombre%' $strperidosesion " .
                        " $strperiodo ORDER BY 3, est.codigoperiodo";
                }
                if ($_GET['tipobusqueda'] == "Facultad") {
                    $query_solicitud = " and eg.nombresestudiantegeneral LIKE '%$nombre%' $strperidosesion " .
                        " and est.codigocarrera = '" . $_SESSION['codigofacultad'] . "' $strperiodo ORDER BY 2";
                }
            }
            if (isset($_GET['busqueda_apellido']) && !empty($_GET['busqueda_apellido'])) {
                $apellido = $_GET['busqueda_apellido'];
                if ($_GET['tipobusqueda'] == "Universidad") {
                    $query_solicitud = " and eg.apellidosestudiantegeneral LIKE '$apellido%' " .
                        " $strperidosesion $strperiodo ORDER BY 3, est.codigoperiodo";
                }
                if ($_GET['tipobusqueda'] == "Facultad") {
                    $query_solicitud = " and eg.apellidosestudiantegeneral LIKE '$apellido%' " .
                    " $strperidosesion  and est.codigocarrera = '" . $_SESSION['codigofacultad'] . "' $strperiodo " .
                    " ORDER BY 2";
                }
            }
            if (isset($_GET['busqueda_documento']) && !empty($_GET['busqueda_documento'])) {
                $documento = $_GET['busqueda_documento'];
                if ($_GET['tipobusqueda'] == "Universidad") {
                    $query_solicitud = " and ed.numerodocumento LIKE '$documento%' $strperidosesion " .
                        " $strperiodo ORDER BY 3, est.codigoperiodo";
                }
                if ($_GET['tipobusqueda'] == "Facultad") {
                    $query_solicitud = " and  ed.numerodocumento LIKE '$documento%' $strperidosesion " .
                        " and est.codigocarrera = '" . $_SESSION['codigofacultad'] . "' $strperiodo  ORDER BY 2";
                }
            }
            if (isset($_GET['busqueda_email']) && !empty($_GET['busqueda_email'])) {
                $email = $_GET['busqueda_email'];
                if ($_GET['tipobusqueda'] == "Universidad") {
                    $query_solicitud = " and (eg.emailestudiantegeneral like  '%".$email."%' or ".
                    " eg.email2estudiantegeneral like '%".$email."%')".
                        " $strperiodo ORDER BY 3, est.codigoperiodo";
                }
                if ($_GET['tipobusqueda'] == "Facultad") {
                    $query_solicitud = "and (eg.emailestudiantegeneral like  '%".$email."%' or ".
                    " eg.email2estudiantegeneral like '%".$email."%') $strperidosesion " .
                    " and est.codigocarrera = '" . $_SESSION['codigofacultad'] . "' $strperiodo  ORDER BY 2";
                }
            }

            $sqlconsulta = $sqlbusqueda." ".$query_solicitud;
            $res_solicitud = $db->GetAll($sqlconsulta);

            foreach ($res_solicitud as $solicitud) {
                $idestudiantegeneral = $solicitud["idestudiantegeneral"];
                $codigoestudiante = $solicitud["numerodocumento"];
                $nombre = $solicitud["nombre"];
                $numerodocumento = $solicitud["numerodocumento"];
                $nombreperiodo = $solicitud["nombreperiodo"];
                $situacioncarrera = $solicitud["nombresituacioncarreraestudiante"];

                if (!isset($_GET['aplicaarp'])) {
                    ?>
                    <tr>
                        <td>
                            <b>
                                <a href='../facultades/creacionestudiante/estudiante.php?codigocreado=<?php echo $codigoestudiante ?>'>
                                    <?php echo $nombre ?>&nbsp;</a>
                            </b>
                        </td>
                        <td align='center'><?php echo $numerodocumento ?>&nbsp;</td>
                        <td class="text-center"><?php echo $nombreperiodo ?>&nbsp;</td>
                        <td><?php echo $situacioncarrera ?>&nbsp;</td>
                    </tr>
                    <?php
                } else {
                    echo "<tr>
                        <td ><a href='../facultades/arp/estudiantearpmenu.php?idestudiantegeneral=$idestudiantegeneral'>$nombre&nbsp;</a></td>
                        <td class='text-center'>$numerodocumento&nbsp;</td>
                        <td >$nombreperiodo&nbsp;</td>
                        </tr>";
                }
            }//foreach
            ?>
            </table>
        <?php
        }
        ?>
    </form>
</div>
</body>
</html>
<!--  Space loading indicator  -->
<script src="<?php echo HTTP_SITE; ?>/assets/js/spiceLoading/pace.min.js"></script>