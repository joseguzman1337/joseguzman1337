<?php
require_once(realpath(dirname(__FILE__)).'/../../Connections/sala2.php' );
require_once(realpath(dirname(__FILE__))."/../../funciones/validacion.php");
require_once(realpath(dirname(__FILE__))."/../../funciones/errores_plandeestudio.php");
require_once(realpath(dirname(__FILE__))."/../../funciones/funcionboton.php");

$ruta = "../../funciones/";
$rutaorden = "../../funciones/ordenpago/";

session_start();
$codigoestudiante = $_SESSION['codigo'];

/*******************  E.G.R 2006-11-30 *******************/

	// Selecciono el periodo de la fecha actual.
	mysql_select_db($database_sala, $sala);
    $query_selperiodo = "SELECT p.codigoperiodo,fechainiciofinancierosubperiodo,fechafinalfinancierosubperiodo
	FROM periodo p, carreraperiodo cp, subperiodo s,estudiante e
	WHERE p.codigoperiodo  = cp.codigoperiodo
	AND s.idcarreraperiodo = cp.idcarreraperiodo
	AND cp.codigocarrera = e.codigocarrera
	AND e.codigoestudiante = '$codigoestudiante'
	AND fechainiciofinancierosubperiodo <= '".date("Y-m-d")."'
	AND fechafinalfinancierosubperiodo >= '".date("Y-m-d")."'";

	$selperiodo = mysql_query($query_selperiodo, $sala) or die("$query_selperiodo");
	$totalRows_selperiodo=mysql_num_rows($selperiodo);
	$row_selperiodo=mysql_fetch_array($selperiodo);
	$codigoperiodo = $row_selperiodo['codigoperiodo'];
    $codigoperiodo = $_SESSION['codigoperiodosesion'];

/******************* Fin  E.G.R 2006-11-30 *******************/
require_once($rutaorden.'claseordenpago.php');
mysql_select_db($database_sala, $sala);


$orden = new Ordenpago($sala, $codigoestudiante, $codigoperiodo);

if(!isset($_GET['todos'])){
	// Hacer un query con los conceptos que esten permitidos para la generación de ordenes
	$query_conceptos = "select c.codigoconcepto, c.nombreconcepto, r.codigoautorizacionreferenciaconcepto, ".
    " v.valorpecuniario, c.codigocambiovalorconcepto ".
    " from facturavalorpecuniario f ".
     " inner join detallefacturavalorpecuniario df on df.idfacturavalorpecuniario = f.idfacturavalorpecuniario ".
     " inner join valorpecuniario v on v.idvalorpecuniario = df.idvalorpecuniario ".
     " inner join estudiante e on e.codigotipoestudiante = df.codigotipoestudiante ".
     " inner join concepto c on c.codigoconcepto = v.codigoconcepto ".
     " inner join referenciaconcepto r on c.codigoreferenciaconcepto = r.codigoreferenciaconcepto ".
    " where f.codigocarrera = e.codigocarrera ".
	" and f.codigoperiodo = '".$codigoperiodo."' ".
	" and f.codigoperiodo = v.codigoperiodo ".
	" and e.codigoestudiante = '".$_SESSION['codigo']."' ".
	" and r.codigoaplicareferenciaconcepto = '100' ".
	" and c.codigoreferenciaconcepto = '".$_GET['codigoreferenciaconcepto']."' ".
	" and df.codigoestado like '1%' and c.codigoconcepto not in('159','C9076','C9077')";
	$conceptos = mysql_query($query_conceptos, $sala) or die("$query_conceptos".mysql_error());
	$totalRows_conceptos = mysql_num_rows($conceptos);
}
else{
	// Hacer un query con los conceptos que esten permitidos para la generación de ordenes
	$query_conceptos = "select c.codigoconcepto, c.nombreconcepto, r.codigoautorizacionreferenciaconcepto, v.valorpecuniario, c.codigocambiovalorconcepto
	from facturavalorpecuniario f, detallefacturavalorpecuniario df, valorpecuniario v, estudiante e, concepto c, referenciaconcepto r
	where f.codigocarrera = e.codigocarrera
	and df.idfacturavalorpecuniario = f.idfacturavalorpecuniario
	and v.idvalorpecuniario = df.idvalorpecuniario
	and f.codigoperiodo = '".$codigoperiodo."'
	and f.codigoperiodo = v.codigoperiodo
	and e.codigotipoestudiante = df.codigotipoestudiante
	and e.codigoestudiante = '".$_SESSION['codigo']."'
	and c.codigoconcepto = v.codigoconcepto
	and c.codigoreferenciaconcepto = r.codigoreferenciaconcepto
	and df.codigoestado like '1%'
    and c.codigoconcepto not in('159','C9076','C9077')";
	$conceptos = mysql_query($query_conceptos, $sala) or die("$query_conceptos".mysql_error());
	$totalRows_conceptos = mysql_num_rows($conceptos);
}


?>
<html>
    <head>
        <title>Conceptos Para Generar Ordenes</title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <?php
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/bootstrap.min.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/custom.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
        echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
        echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/sweetalert.css");

        echo Factory::printImportJsCss("js", HTTP_ROOT ."/assets/js/sweetalert.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.min.js");
        echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.js");
        ?>
    </head>
    <body>
    <h3>GENERACION Y VISUALIZACIÓN DE ORDENES DE PAGO PARA CONCEPTOS VARIOS</h3>
    <div class="container">
    <?php

    if($totalRows_conceptos != "") { ?>
        <form action="generarorden.php" name="f1" method="post">
            <table class="table table-responsive" style="font-size: 12px" >
                <tr id="trtituloNaranjaInst">
                    <td colspan="5"><strong>Observación</strong></td>
                </tr>
                <tr>
                    <td colspan="5">
                        <input type="text" name="observacion" placeholder="Detalle opcional de la generacion de la orden de pago"
                           value="<?php echo @$_POST['observacion']; ?>" size="80">
                    </td>
                </tr>
                <tr id="trtituloNaranjaInst">
                    <td>Código Concepto</td>
                    <td>Nombre Concepto</td>
                    <td>Cantidad</td>
                    <td>Valor</td>
                    <td>Seleccionar</td>
                </tr>
                <?php
                while($row_conceptos = mysql_fetch_assoc($conceptos)){
                    $puedemodificarvalor = false;
                    $autorizado = true;
                    ?>
                    <tr>
                        <td><?php echo $row_conceptos['codigoconcepto']; ?>&nbsp;</td>
                        <td><?php echo $row_conceptos['nombreconcepto']; ?>&nbsp;</td>
                        <td><input type="text" name="cantidad<?php echo $row_conceptos['codigoconcepto']?>" value="1" size="2">&nbsp;</td>
                        <td>
                            <?php
                            if($row_conceptos['codigocambiovalorconcepto'] == '200'){
                                $puedemodificarvalor = false;
                            }
                            else{
                                $puedemodificarvalor = true;
                            }

                            if(!$puedemodificarvalor){
                                ?>
                                $ <?php echo number_format($row_conceptos['valorpecuniario']); ?>&nbsp;
                                <?php
                            }
                            else{
                                ?>
                                $ <input type="text" value="<?php echo $row_conceptos['valorpecuniario'];?>"
                                 name="valor<?php echo $row_conceptos['codigoconcepto'];?>" size="10">
                                <?php
                            }
                            ?>
                        </td>
                        <td>
                            <?php
                            if(preg_match('/^1.+$/', $row_conceptos['codigoautorizacionreferenciaconcepto'])){
                                // Si entra aca es por que requiere autorización
                                // Ahora miramos si esta o no autorizado
                                $query_autorizacion = "select a.idautorizaconcepto
                                from autorizaconcepto a
                                where a.codigoestudiante = '".$_SESSION['codigo']."'
                                and a.codigoconcepto = '".$row_conceptos['codigoconcepto']."'
                                and a.fechavencimientoautorizaconcepto >= '".date("Y-m-d")."'";
                                $autorizacion = mysql_query($query_autorizacion, $sala) or die("$query_autorizacion".mysql_error());
                                $totalRows_autorizacion = mysql_num_rows($autorizacion);
                                if($totalRows_autorizacion == ""){
                                    $autorizado = false;
                                }
                            }

                            if($autorizado){
                                ?>
                                    <input
                                            class="selectConcepto"
                                            type="checkbox"
                                            value="<?php echo $row_conceptos['codigoconcepto']; ?>"
                                            name="concepto<?php echo $row_conceptos['codigoconcepto']; ?>"
                                    >
                                <?php
                            }
                            else{
                                echo "No esta autorizado";
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                } //while($row_conceptos = mysql_fetch_assoc($conceptos))
                ?>
                <tr>
                    <td colspan="5">
                        <input type="submit" class="btn btn-fill-green-XL" name="Generar" value="Generar Orden">&nbsp;&nbsp;
                        <input type="button" class="btn btn-fill-green-XL" value="Regresar" onClick="window.location.href='ordenpagovarias.php'">
                    </td>
                </tr>
            </table>
        </form>
        <?php
    }
    else{
        ?>
        <h4>NO HAY CONCEPTOS PARA SER GENERADOS, POSIBLEMENTE POR QUE NO EXISTEN O NO HAY VALORES</h4>
        <input type="button" class="btn btn-fill-green-XL" value="Regresar" onClick="window.location.href='ordenpagovarias.php'">
        </p>
    <?php
    }
    ?>
    </div>
</body>
<?php
    // Cargue de scripts para la validacion de programación y conceptos people
    $cargarVerificacionProgramaFtConcepto_Front = true;
    require_once  __DIR__ . '/parcialValidacionConceptoPorPrograma.php';
?>
<script>
    $(document).ready(function(){
        $('.selectConcepto').change(function () {
            if($(this).is(':checked'))
                objOrdenesPago.validarConcepto($(this).val(), '<?php echo  $codigoestudiante?>', $(this))
        });
    });
</script>
