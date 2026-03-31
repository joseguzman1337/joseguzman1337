<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//require_once('Connections/sala.php');
$rutaado=("../funciones/adodb/");
//require_once('../../../funciones/sala/nota/nota.php');
//require_once('../../../funciones/sala/estudiante/estudiante.php');
require_once('../Connections/sala2.php');
//$rutazado = "../../../funciones/zadodb/";
require_once('../Connections/salaado.php');
//require_once('Connections/sala2.php');
//require_once('funciones/clases/autenticacion/redirect.php');

$query_campana = "select nombrecampanapublicitaria
from campanapublicitaria
group by nombrecampanapublicitaria";
$rta_campana = $db->Execute($query_campana);
$totalRows_campana = $rta_campana->RecordCount();

$query_periodo = "select codigoperiodo, nombreperiodo
from periodo
order by codigoperiodo desc
limit 5";
$rta_periodo = $db->Execute($query_periodo);
$totalRows_periodo = $rta_periodo->RecordCount();
?>
<!DOCTYPE html PUBLIC
    "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <title>Reporte de campañas publicitarias</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link rel="stylesheet" type="text/css" href="../estilos/sala.css" />
        <script src="JSCal/src/js/jscal2.js" type="text/javascript"></script>
        <script src="JSCal/src/js/lang/es.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="JSCal/src/css/jscal2.css" />
        <link rel="stylesheet" type="text/css" href="JSCal/src/css/border-radius.css" />
        <link rel="stylesheet" type="text/css" href="JSCal/src/css/steel/steel.css" />
    </head>
    <body>
        <form method="post" action="" name="f1">
            <table border="1" cellpadding="0" cellspacing="0" align="">
                <thead>
                    <tr id="trtitulogris">
                        <th colspan="2">Criterios de Filtro</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td id="tdtitulogris">Origen campaña</td>
                        <td><?php
                            while($row_campana = $rta_campana->FetchRow()) {
                                echo strtoupper($row_campana['nombrecampanapublicitaria']);
                                $checked = "";
                                if($row_campana['nombrecampanapublicitaria'] == $_REQUEST['nombrecampanapublicitaria']) {
                                    $checked = " checked";
                                }
                                ?>
                            <input type="radio" name="nombrecampanapublicitaria" value="<?php echo $row_campana['nombrecampanapublicitaria']; ?>" <?php echo $checked; ?> />
                            <br />
                                <?php
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td id="tdtitulogris">Periodo</td>
                        <td>
                            <select name="codigoperiodo">
                                <option value="" selected>Seleccionar...</option>
                                <?php
                                while($row_periodo = $rta_periodo->FetchRow()) {
                                    $selected = "";
                                    if($row_periodo['codigoperiodo']  == $_REQUEST['codigoperiodo']) {
                                        $selected = " selected";
                                    }
                                    ?>
                                <option value="<?php echo $row_periodo['codigoperiodo'];?>" <?php echo $selected;?>>
                                        <?php echo $row_periodo['nombreperiodo'];?>
                                </option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td id="tdtitulogris">Fecha Inicial</td>
                        <td>
                            <input id="fechainicial" name="fechainicial" value="<?php echo $_REQUEST['fechainicial']; ?>" />
                            <script type="text/javascript">
                                Calendar.setup({
                                    inputField : "fechainicial",
                                    trigger    : "fechainicial",
                                    onSelect   : function() { this.hide() }
                                });
                            </script>

                        </td>
                    </tr>
                    <tr>
                        <td id="tdtitulogris">Fecha Final</td>
                        <td>
                            <input id="fechafinal" name="fechafinal" value="<?php echo $_REQUEST['fechafinal']; ?>" />
                            <script type="text/javascript">
                                Calendar.setup({
                                    inputField : "fechafinal",
                                    trigger    : "fechafinal",
                                    onSelect   : function() { this.hide() }
                                });
                            </script>

                        </td>
                    </tr>
                    <tr align="center">
                        <td colspan="2"><input type="submit" name="Filtrar" value="Filtrar" /></td>
                    </tr>
                </tbody>
            </table>
        </form>
<?php
if ($_POST['Filtrar'] == "Filtrar") {
    //print_r($_REQUEST);
    $reportUnit = "%2FReportes%2FAntencionUsuario%2FReporteCampanas&origenCampana=".$_REQUEST['nombrecampanapublicitaria']."&codigoPeriodo=".$_REQUEST['codigoperiodo']."&fechaInicial=".$_REQUEST['fechainicial']."&fechaFinal=".$_REQUEST['fechafinal'];
    $rutaado = "../funciones/adodb/";
    $rutaConeccion = "../";
    $rutaJS = "../consulta/sic/librerias/js/";
    $conJquery = false;
    require_once('../Reporteador/ReporteCentralInterno.php');
}
?>
    </body>
</html>
