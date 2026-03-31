<?php 
session_start();
include_once('../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//requiere el uso del adaptador de la base de datos
require_once(realpath(dirname(__FILE__) . "/../../../sala/includes/adaptador.php"));

$codigoestudiante = $_SESSION['codigo'];
require('funcionesestadocuenta.php');
$link = "../../../imagenes/estudiantes/";

//si la variable plan existe se redirreciona a plan de pagos
if (isset($_POST['Plan']) && !empty($_POST['Plan'])) {
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../interfacespeople/plandepago/plan_pagos.php'>";
    exit();
}
$colspan = "";
//obtiene los datos del estudiante
$row_dataestudiante = datosEstudianteEstadoCuenta($db, $codigoestudiante, $link);
?>
<html>
    <head>
        <title>Estado Cuenta</title>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <script src="../../../assets/js/jquery-3.6.0.min.js"></script>
        <script src="<?php echo HTTP_SITE; ?>/assets/js/bootstrap.min.js"></script>
        <link href="<?php echo HTTP_SITE; ?>/assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
        ?>
    </head>
    <body>
        <table class="table table-responsive" >
            <tr id="trtituloNaranjaInst">
                <td colspan="4" class="text-center">
                    ESTADO DE CUENTA
                </td>
            </tr>
            <tr id="trtitulogris">
                <td>Documento</td>
                <td colspan="2">Nombre Estudiante</td>
                <td colspan="0" rowspan="6" align="center"><img src="<?php echo $row_dataestudiante['linkimagen']; ?>"
                    style="margin-top: 20px" width="120px" ></td>
            </tr>
            <tr>
                <td><div><?php echo $row_dataestudiante['numerodocumento'];?></div></td>
                <td colspan="2"><div><?php echo $row_dataestudiante['nombre'];?></div></td>
            </tr>
            <tr id="trtitulogris">
                <td colspan="1">No. Plan de Estudio</td>
                <td colspan="1">Nombre Del Plan de Estudio</td>
                <td colspan="1">Semestre</td>
            </tr>
            <tr>
                <td colspan="1"><?php echo $row_dataestudiante['idplan'];?></td>
                <td colspan="1"><?php echo $row_dataestudiante['nombreplan'];?></td>
                <td colspan="1"><?php echo $row_dataestudiante['semestre'];?></td>
            </tr>
            <tr id="trtitulogris">
                <td>Carrera</td>
                <td colspan="1">Situación</td>
                <td>Fecha</td>
            </tr>
            <tr>
                <td><?php echo $row_dataestudiante['nombrecarrera'];?></td>
                <td><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'];?></td>
                <td><?php echo date("Y-m-d H:i:s");?></td>
            </tr>
        </table>
        <form name="form1" method="post" action="">
        <?php
        //consulta el historico de documento del estudiante
        $documentos = historicoDocumentos($db, $codigoestudiante);

        $integracion = '';
        $saldoEnContra = '';
        $saldoFavor = '';

        foreach($documentos as $documento){
            //consulta las deudas o saldos a favor del documento
            $resultados = saldoaFavorContra($db, $documento);

            // resultado de la integracion
            if (isset($resultados['error']['numero']) && !empty($resultados['error']['numero'])) {
                $integracion .= "<tr><td>".$documento['codigodocumentopeople']."</td><td>".$documento['nombrecortodocumento']."</td><td>".$documento['numerodocumento']."</td>";
                $integracion .= "<td>".$resultados['error']['numero']."</td><td>".utf8_encode($resultados['error']['descripcion'])."</td></tr>";
            }else{
                $integracion .= "<tr><td>".$documento['codigodocumentopeople']."</td><td>".$documento['nombrecortodocumento']."</td><td>".$documento['numerodocumento']."</td>";
                $integracion .= "<td>".'N/A'."</td><td>".'Consulta realizada con éxito'."</td></tr>";
            }

            // deudas del estudiante
            if (isset($resultados['saldoencontra']) && !empty($resultados['saldoencontra'])) {
                foreach($resultados['saldoencontra'] as $contra){
                    $desc = $contra[3];
                    $valorcuota = $contra[6];
                    $fechavencimiento = $contra[4];
                    $tipoDocumento = $contra[11];
                    $numeroDocumento = $contra[10];
                    $saldoEnContra .= "<tr><td ><div align='center' class='Estilo13 Estilo14'>" . $documento['codigodocumentopeople'] . "</div></td>";
                    $saldoEnContra .= "<td ><div align='center' class='Estilo13 Estilo14'>" . $documento['nombrecortodocumento'] . "</div></td>";
                    $saldoEnContra .= "<td ><div align='center' class='Estilo13 Estilo14'>" . $documento['numerodocumento'] . "</div></td>";
                    $saldoEnContra .= "<td ><div align='center' class='Estilo13 Estilo14'>" . $desc . "</div></td>";
                    $saldoEnContra .= "<td colspan='$colspan'><div align='center' class='Estilo13 Estilo14'>" . $fechavencimiento . "</div></td>";
                    $saldoEnContra .= "<td colspan='2'><div align='center' class='Estilo13 Estilo14'>" . $valorcuota . "</div></td></tr>";
                }//for
            }//if

            //Saldos a favor del estudiante
            foreach ($resultados['saldoafavor'] as $favor) {
                $desc = $favor[2];
                $valortotal = convertirPositivo($favor[4]);
                $fechasaldoafavor = $favor[3];
                $saldoFavor .= "<tr><td ><div align='center' class='Estilo13 Estilo14'>" . $documento['codigodocumentopeople'] . "</div></td>";
                $saldoFavor .= "<td ><div align='center' class='Estilo13 Estilo14'>" . $documento['nombrecortodocumento'] . "</div></td>";
                $saldoFavor .= "<td ><div align='center' class='Estilo13 Estilo14'>" . $documento['numerodocumento'] . "</div></td>";
                $saldoFavor .= "<td ><div align='center' class='Estilo13 Estilo14'>" . $desc . "</div></td>";
                $saldoFavor .= "<td colspan='$colspan'><div align='center' class='Estilo13 Estilo14'>" . $fechasaldoafavor . "</div></td>";
                $saldoFavor .= "<td colspan='2'><div align='center' class='Estilo13 Estilo14'>" . $valortotal . "</div></td></tr>";
            }//for
        }//foreach

        ?>

        <?php //En esta seccion se imprimen los resultados ?>
        <table class="table table-bordered " style="font-size:12px">
            <tr id="trtituloNaranjaInst">
                <td colspan="5" class="text-center">
                    RESULTADOS DE INTEGRACIÓN
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Tipo Documento People</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Tipo Documento</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Documento</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Numero</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Descripción</span></div>
                </td>
            </tr>
            <?php echo $integracion;  ?>
        </table>

        <?php if($saldoEnContra !== ''): ?>
        <table class="table table-bordered">
            <tr id="trtituloNaranjaInst">
                <td colspan="6" class="text-center">
                    DEUDAS DEL ESTUDIANTE
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Documento People</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Documento</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Numero</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Descripción</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Fecha Vencimiento</span>
                    </div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Valor</span></div>
                </td>
            </tr>
            <?php
                echo $saldoEnContra;
            ?>
        </table>
        <?php endif; ?>

        <?php if($saldoFavor !== ''): ?>
        <table class="table table-bordered" >
            <tr id="trtituloNaranjaInst">
                <td colspan="6" class="text-center">
                    SALDOS A FAVOR DEL ESTUDIANTE
                </td>
            </tr>
            <tr>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Documento People</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Documento</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Numero</span></div>
                </td>
                <td>
                    <div align="center" colspan="5" class="Estilo12"><span
                                class="Estilo10">Descripción</span></div>
                </td>
                <td>
                    <div align="center" class="Estilo12"><span class="Estilo10">Fecha</span></div>
                </td>
                <td>
                    <div align="center" colspan="5" class="Estilo12"><span class="Estilo10">Valor</span>
                    </div>
                </td>
            </tr>
            <?php
                echo $saldoFavor;
            ?>
        </table>
        <?php endif; ?>
        <div align="left"><br>
            <input type="button" name="Imprimir" onClick="print()" value="Imprimir" class="btn btn-success">
            &nbsp;&nbsp;
            <input type="submit" name="Plan" value="Plan de Pagos" class="btn btn-success">
            &nbsp;&nbsp;
            <input type="button" name="Regresar" onClick="history.go(-1)" value="Regresar" class="btn btn-success">
        </div>
        </form>
    </body>
</html>
