<script language="Javascript">
    function abrir(pagina, ventana, parametros) {
        window.open(pagina, ventana, parametros);
    }
    function enviar() {
        document.form1.submit()
    }
</script>

<style type="text/css">
    .Estilo1 {font-family: Tahoma; font-size: 11px}
    .Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
    .Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
    .Estilo4 {color: #FF0000}
    .Estilo5 {font-family: Tahoma; font-size: 12px}
    .verdoso {background-color: #CCDADD;font-family: Tahoma; font-size: 12px; font-weight: bold;}
    .amarrillento {background-color: #FEF7ED;font-family: Tahoma; font-size: 11px}
</style>
<?php
ini_set("include_path", ".:/usr/share/pear_");
require_once('../funciones/validacion.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/pear/PEAR.php');
require_once('../funciones/pear/DB.php');
require_once('../funciones/pear/DB/DataObject.php');
require_once('../funciones/gui/combo_valida_get.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');

$config = parse_ini_file('../funciones/conexion/basedatos.ini', TRUE);
$config['DB_DataObject']['database'] = "mysql://" . $username_sala . ":" . $password_sala . "@" . $hostname_sala . "/" . $database_sala;

foreach ($config as $class => $values) {
    $options = &PEAR::getStaticProperty($class, 'options');
    $options = $values;
}
?>
<?php
$fechahoy = date("Y-m-d H:i:s");

if (isset($_GET['codigocarrera']) && $_GET['codigocarrera'] != "") {
    /**
     * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Se reemplaza el <= por >= en la condicional fechainiciovaloreducacioncontinuada
     * y se reemplaza el >= por <= en la condicional fechafinalvaloreducacioncontinuada
     * para que permita mostrar los registros de los valores de los conceptos de pago
     * @since Abril 9, 2019.
     */
    $periodo = $_SESSION['codigoperiodosesion'];
    $sqlperiodo = "select fechainicioperiodo, fechavencimientoperiodo from periodo where codigoperiodo ='" . $periodo . "'";
    $valperiodo = $sala->query($sqlperiodo);
    $totalRows_valperiodo = $valperiodo->numRows();
    $row_valperiodo = $valperiodo->fetchRow();

    /**
     *@modified Diego Rivera <riveradiego@unbosque.edu.co>
     *se modifica sentencia sql se elimina restriccion de fechas v.fechainiciovaloreducacioncontinuada >= '" . $row_valperiodo['fechainicioperiodo'] . "' " .
     *and v.fechafinalvaloreducacioncontinuada <= '" . $row_valperiodo['fechavencimientoperiodo']  y se agrega limit en orden desc con el fin 
     * de traer el ultimo registro de la carrera
     *@since June 14,2019    
    */
    
    $query_valeducon = "SELECT * " .
            " FROM " .
            " valoreducacioncontinuada v" .
            " JOIN carrera c ON ( c.codigocarrera = v.codigocarrera )" .
            " JOIN concepto co ON ( co.codigoconcepto = v.codigoconcepto ) " .
            " WHERE ".
            " v.codigocarrera = '" . $_GET['codigocarrera'] . "'".
            " ORDER BY ".
            " v.idvaloreducacioncontinuada DESC ".
            " LIMIT 1";
    
    $valeducon = $sala->query($query_valeducon);
    $totalRows_valeducon = $valeducon->numRows();
    $row_valeducon = $valeducon->fetchRow();
}
?>
<form name="form1" method="get" action="">
    <p align="center" class="Estilo3">VALOR EDUCACION CONTINUADA - LISTADO </p>
    <table width="70%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
            <td><table width="100%"  border="0" cellpadding="2" cellspacing="2">
                    <tr>
                        <td width="22%" class="verdoso">Modalidad acad&eacute;mica </td>
                        <td width="78%" class="amarrillento"><?php $validacion['codigomodalidadacademica'] = combo_valida_get("codigomodalidadacademica", "modalidadacademica", "codigomodalidadacademica", "nombremodalidadacademica", "onchange=enviar()", "", "nombremodalidadacademica asc", "si", "Modalidad acad&eacute;mica") ?></td>
                    </tr>
                    <tr>
                        <td class="verdoso">Carrera</td>
                        <td class="amarrillento"><?php $validacion['codigocarrera'] = combo_valida_get("codigocarrera", "carrera", "codigocarrera", "nombrecarrera", "onchange=enviar()", "fechainiciocarrera <= '" . $fechahoy . "' and fechavencimientocarrera >= '" . $fechahoy . "' and codigomodalidadacademica='" . $_GET['codigomodalidadacademica'] . "'", "nombrecarrera asc", "si", "Carrera") ?></td>
                    </tr>
                </table></td>
        </tr>
    </table>
    <br>
    <table width="70%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr>
            <td><table width="100%" cellpadding="2" cellspacing="2">
                    <tr class="verdoso">
                        <td><div align="center">ID</div></td>
                        <td><div align="center">Nombre</div></td>
                        <td><div align="center">Carrera</div></td>
                        <td><div align="center">Concepto</div></td>
                        <td><div align="center">Precio</div></td>
                        <td><div align="center">Fecha inicio </div></td>
                        <td><div align="center">Fecha Final</div></td>
                    </tr>
                    <?php
                    if (isset($_GET['codigocarrera']) and $totalRows_valeducon != "") {
                        do {
                            ?>
                            <tr class="amarrillento"><td><div align="center"><a href="#" onclick="abrir('valoreducacioncontinuada_detalle.php?idvaloreducacioncontinuada=<?php echo $row_valeducon['idvaloreducacioncontinuada']; ?>&nombrecarrera=<?php echo str_replace('"', "_", $row_valeducon['nombrecarrera']); ?>', 'Editarvaloreducacioncontinuada', 'width=850,height=500,top=50,left=50,scrollbars=yes', event);return false"><?php echo $row_valeducon['idvaloreducacioncontinuada']; ?></a></div></td>
                                <td><div align="center"><?php echo $row_valeducon['nombrevaloreducacioncontinuada']; ?></div></td>
                                <td><div align="center"><?php echo $row_valeducon['nombrecarrera']; ?></div></td>
                                <td><div align="center"><?php echo $row_valeducon['nombreconcepto']; ?></div></td>
                                <td><div align="center"><?php echo $row_valeducon['preciovaloreducacioncontinuada']; ?></div></td>
                                <td><div align="center"><?php echo $row_valeducon['fechainiciovaloreducacioncontinuada']; ?></div></td>
                                <td><div align="center"><?php echo $row_valeducon['fechafinalvaloreducacioncontinuada']; ?></div></td>
                            </tr>
                        <?php } while ($row_valeducon = $valeducon->fetchRow());
                    } ?>
                    <tr class="verdoso">
                        <td colspan="7"><div align="center">
                                <input name="Nuevo valor" type="submit" id="Nuevo valor" value="Nuevo" onclick="abrir('valoreducacioncontinuada_nuevo.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica'] ?>', 'Nuevovaloreducacioncontinuada', 'width=600,height=350,top=50,left=50,scrollbars=yes');return false">
                            </div></td>
                    </tr>

                </table></td>
        </tr>
    </table>
</form>
<script language="Javascript">
    function recargar()
    {
        window.location.reload("valoreducacioncontinuada_listado.php?codigomodalidadacademica=<?php echo $_GET['codigomodalidadacademica'] ?>&codigocarrera=<?php echo $_GET['codigocarrera'] ?>");
    }
</script>
