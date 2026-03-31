<script language="javascript">
	function enviar()
		{
			document.form1.submit();
		}
</script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
-->
</style>
<?php
   session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//print_r($_POST);
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validarporcentaje.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');

//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
$fechahoy=date("Y-m-d");
//DB_DataObject::debugLevel(5);
$descuentoeducacioncontinuada=DB_DataObject::factory('descuentoeducacioncontinuada');
$descuentoeducacioncontinuada->whereAdd("fechahastadescuentoeducacioncontinuada>='".$fechahoy."'"); //fechadesdedescuentoeducacioncontinuada<='".$fechahoy."' and 
$descuentoeducacioncontinuada->get('','*');
//DB_DataObject::debugLevel(0);
?>
<form name="form1" action="" method="get">
<p align="center" class="Estilo3">DESCUENTO EDUCACION CONTINUADA - LISTADO</p>
<table width="100%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0" align="center">
      <tr bgcolor="#CCDADD" class="Estilo2">
        <td><div align="center">ID</div></td>
        <td><div align="center">Fecha</div></td>
        <td><div align="center">Nombre</div></td>
        <td><div align="center">Porcentaje</div></td>
        <td><div align="center">Tipo</div></td>
        <td><div align="center">Fecha Desde </div></td>
        <td><div align="center">Fecha Hasta </div></td>
        <td><div align="center">Concepto</div></td>
        <td bgcolor="#CCDADD"><div align="center">Accion</div></td>
      </tr>
      <?php do{
	   $tipodescuentoeducacioncontinuada=$descuentoeducacioncontinuada->getLink('codigotipodescuentoeducacioncontinuada','tipodescuentoeducacioncontinuada','codigotipodescuentoeducacioncontinuada');
	   $codigoconcepto=$descuentoeducacioncontinuada->getLink('codigoconcepto','concepto','codigoconcepto');
	  ?>
      <tr class="Estilo1">
        <td><div align="center"><?php echo $descuentoeducacioncontinuada->iddescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $descuentoeducacioncontinuada->fechadescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><a href="descuentoeducacioncontinuada_detalle.php" onclick="abrir('descuentoeducacioncontinuada_detalle.php?iddescuentoeducacioncontinuada=<?php echo $descuentoeducacioncontinuada->iddescuentoeducacioncontinuada?>','Editardetalledescuentoeducacioncontinuada','width=400,height=330,top=50,left=50,scrollbars=yes');return false"><?php echo $descuentoeducacioncontinuada->nombredescuentoeducacioncontinuada?></a></div></td>
        <td><div align="center"><?php echo $descuentoeducacioncontinuada->porcentajedescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $tipodescuentoeducacioncontinuada->nombredescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $descuentoeducacioncontinuada->fechadesdedescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $descuentoeducacioncontinuada->fechahastadescuentoeducacioncontinuada?></div></td>
        <td><div align="center"><?php echo $codigoconcepto->nombreconcepto?></div></td>
        <td><div align="center"><a href="descuentocarreraeducacioncontinuada_nuevo.php" onclick="abrir('descuentocarreraeducacioncontinuada_nuevo.php?accion=asociar&iddescuentoeducacioncontinuada=<?php echo $descuentoeducacioncontinuada->iddescuentoeducacioncontinuada?>&nombredescuentoeducacioncontinuada=<?php echo $descuentoeducacioncontinuada->nombredescuentoeducacioncontinuada?>','Nuevodescuentocarreraeducacioncontinuada','width=800,height=300,top=50,left=50,scrollbars=yes');return false">Asociar descuento a carrera</a></div></td>
      </tr>
      <?php } while($descuentoeducacioncontinuada->fetch());?>
      <tr bgcolor="#CCDADD">
        <td colspan="9"><div align="center">
            <input name="Nuevo" type="submit" id="Nuevo" value="Nuevo descuento" onclick="abrir('descuentoeducacioncontinuada_nuevo.php','Nuevodetalledescuentoeducacioncontinuada','width=400,height=300,top=50,left=50,scrollbars=yes');return false">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">
</div></td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
<script language="javascript">
function recargar()
{
	window.location.reload('descuentoeducacioncontinuada_listado.php');
}
</script>
<?php 
if(isset($_GET['Regresar']))
{
	echo '<script language="Javascript">window.location.reload("menu.php");</script>';
	
}
?>
