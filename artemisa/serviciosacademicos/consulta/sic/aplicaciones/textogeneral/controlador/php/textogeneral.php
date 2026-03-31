<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
session_set_cookie_params(86400);
@session_start();
//print_r($_SESSION);
require(realpath(dirname(__FILE__)).'/../../../../../../Connections/sala2.php');
$rutaado = "../../../../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/salaado.php');
require_once(realpath(dirname(__FILE__)).'/../../../../../../funciones/clases/autenticacion/redirect.php');
$codigocarrera = $_SESSION['codigofacultad'];

$rutaPHP = '../../../../librerias/php/';
require_once($rutaPHP.'funcionessic.php');

$rutaJS = '../../../../librerias/js/';
$rutaEstilos = '../../../../estilos/';
$rutaImagenes = '../../../../imagenes/';

$rutaModelo = '../../modelo/textogeneral.php';
$rutaVista = '../../vista/textogeneral.php';
require_once($rutaModelo);

$itemsic = new textogeneral($_REQUEST['iditemsic']);

$mensaje = "";
if($_REQUEST['Aceptar'])
{
    //$db->debug = true;
    //$validarvalor = str_replace("\n","",$_REQUEST["valoritemsiccarrera"]);
    //$validarvalor
    //echo "".strlen(ereg_replace("\n","",$_REQUEST["valoritemsiccarrera"]))." >  $itemsic->longituddescripcionitemsic";
    if(strlen(str_replace("\n","",$_REQUEST["valoritemsiccarrera"])) >  $itemsic->longituddescripcionitemsic)
    {
?>
<script language="JavaScript">
    alert("El valor no pudo ser insertado ya que supera el máximo de caracteres permitidos que es de <?php echo $itemsic->longituddescripcionitemsic; ?>");
</script>
<?php
    }
    else
        $mensaje = $itemsic->insertarItemsiccarrera();
}

$row_itemsiccarrera = $itemsic->obtenerItemSicCarrera();
if($row_itemsiccarrera['iditemsiccarrera'] == '')
{
    $row_itemsiccarrera['iditemsiccarrera'] = 0;
}
if($itemsic->cantidadadjuntositemsic > 0)
{
    $adjuntos = $itemsic->obtenerItemSicCarreraAdjuntos();
}
require_once($rutaVista);
?>