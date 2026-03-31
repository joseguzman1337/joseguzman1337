<style type="text/css">@import url(../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-setup.js"></script>

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
<?php
//print_r($_POST);
echo '<script language="Javascript">
function recargar() 
{
	window.location.reload("fechafinancieradetalle_listado.php?codigocarrera='.$_GET['codigocarrera'].'&idfechafinanciera='.$_GET['idfechafinanciera'].'");
}
</script>';
?>
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
$fechahoy=date("Y-m-d");
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
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_novalida_post_bd.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');


//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
foreach($config as $class=>$values) {
	$options = &PEAR::getStaticProperty($class,'options');
	$options = $values;
}
//PEAR::setErrorHandling(PEAR_ERROR_PRINT);
PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'error_handler');
function error_handler(&$obj) {
$msg = $obj->getMessage();
$code = $obj->getCode();
$info = $obj->getUserInfo();
echo $msg,' ',$code,"<br>";
if ($info) {
print htmlspecialchars($info);
} 
}
$validaciongeneral=true;	
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
?>
<?php
$fechahoy=date("Y-m-d");
$descuentoeducacioncontinuada=DB_DataObject::factory('descuentoeducacioncontinuada');
$descuentoeducacioncontinuada->get('iddescuentoeducacioncontinuada',$_GET['iddescuentoeducacioncontinuada']);
/* $consulta_descuentoeducacioncontinuada=DB_DataObject::factory('descuentoeducacioncontinuada');
$consulta_descuentoeducacioncontinuada->get('','*');

do	{
		$ultimo_iddescuentoeducacioncontinuada=$consulta_descuentoeducacioncontinuada->iddescuentoeducacioncontinuada;
	} 
while($consulta_descuentoeducacioncontinuada->fetch());
 */
?>
<form name="form1" method="post" action="">
<p align="center"><span class="Estilo3">DESCUENTO EDUCACION CONTINUADA - EDITAR</span></p>
<table width="100%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td><table width="100%" border="0">
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Nombre</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['nombredescuentoeducacioncontinuada']=campotexto_valida_post_bd("nombredescuentoeducacioncontinuada","requerido","Nombre","30","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada",$_GET['iddescuentoeducacioncontinuada'],"nombredescuentoeducacioncontinuada")?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Concepto</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['codigoconcepto']=combo_valida_post_bd("codigoconcepto","concepto","codigoconcepto","nombreconcepto","","codigoestado='100' and codigotipoconcepto='02'","si","Concepto","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada",$_GET['iddescuentoeducacioncontinuada'],"codigoconcepto")?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Descuento</div></td>
        <td bgcolor="#FEF7ED"><?php campotexto_novalida_post_bd("porcentajedescuentoeducacioncontinuada","porcentaje","Descuento, porcentaje","10","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada",$_GET['iddescuentoeducacioncontinuada'],"porcentajedescuentoeducacioncontinuada");
		if($_POST['codigotipodescuentoeducacioncontinuada']=='100'){$validacion['porcentajedescuentoeducacioncontinuada']=validaciongenerica($_POST['porcentajedescuentoeducacioncontinuada'], "porcentaje", "Descuento, porcentaje");}
		elseif($_POST['codigotipodescuentoeducacioncontinuada']=='200'){$validacion['porcentajedescuentoeducacioncontinuada']=validaciongenerica($_POST['porcentajedescuentoeducacioncontinuada'], "numero", "Descuento, número");}
	
	
	?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Tipo descuento </div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['codigotipodescuentoeducacioncontinuada']=combo_valida_post_bd("codigotipodescuentoeducacioncontinuada","tipodescuentoeducacioncontinuada","codigotipodescuentoeducacioncontinuada","nombredescuentoeducacioncontinuada","","","si","Tipo descuento","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada",$_GET['iddescuentoeducacioncontinuada'],"codigotipodescuentoeducacioncontinuada") ?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha desde </div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
          <?php $validacion['fechadesdedescuentoeducacioncontinuada']=campotexto_valida_post_bd("fechadesdedescuentoeducacioncontinuada","fecha","Fecha desde","7","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada",$_GET['iddescuentoeducacioncontinuada'],"fechadesdedescuentoeducacioncontinuada");?><button id="btfechadesdedescuentoeducacioncontinuada">...</button>
        </span></span></span></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha hasta </div></td>
        <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
          <?php $validacion['fechahastadescuentoeducacioncontinuada']=campotexto_valida_post_bd("fechahastadescuentoeducacioncontinuada","fecha","Fecha hasta","7","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada",$_GET['iddescuentoeducacioncontinuada'],"fechahastadescuentoeducacioncontinuada");?><button id="btfechahastadescuentoeducacioncontinuada">...</button>       </span></span></span></td>
      </tr>
      <tr bgcolor="#CCDADD">
        <td colspan="2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;			
            <input name="Regresar" type="submit" id="Regresar" value="Regresar">			
        </div></td>
      </tr>
    </table></td>
  </tr>
</table>
<p align="center">&nbsp;</p>
</form>
<?php
if(isset($_POST['Enviar']))
{
	//echo $fechadesdedescuentoeducacioncontinuada,$fechahastadescuentoeducacioncontinuada;
	if($fechadesdedescuentoeducacioncontinuada>$fechahastadescuentoeducacioncontinuada)
	{
		$valor['valido']=0;
		$valor['mensaje']="La fecha hasta no puede ser menor a la fecha desde";
		$validacion['mayor_fechadesde_fechahasta']=$valor;
	}
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$descuentoeducacioncontinuada->fechadescuentoeducacioncontinuada=$fechahoy;
		$descuentoeducacioncontinuada->nombredescuentoeducacioncontinuada=$_POST['nombredescuentoeducacioncontinuada'];
		$descuentoeducacioncontinuada->porcentajedescuentoeducacioncontinuada=$_POST['porcentajedescuentoeducacioncontinuada'];
		$descuentoeducacioncontinuada->codigotipodescuentoeducacioncontinuada=$_POST['codigotipodescuentoeducacioncontinuada'];
		$descuentoeducacioncontinuada->fechadesdedescuentoeducacioncontinuada=$_POST['fechadesdedescuentoeducacioncontinuada'];
		$descuentoeducacioncontinuada->fechahastadescuentoeducacioncontinuada=$_POST['fechahastadescuentoeducacioncontinuada'];
		$descuentoeducacioncontinuada->codigoconcepto=$_POST['codigoconcepto'];
		//print_r($descuentoeducacioncontinuada);
		$actualizar=$descuentoeducacioncontinuada->update();
		if($actualizar)
		{
			echo "<script language='javascript'>alert('Datos actualizados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
		}
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
	
}
?>
<?php 
if(isset($_POST['Regresar']))
{
	echo '<script language="Javascript">window.close();</script>';
	
}
?>
<?php
if(isset($_POST['Eliminar']))
{
		$descuentoeducacioncontinuada->fechadesdedescuentoeducacioncontinuada='0000-00-00';
		$descuentoeducacioncontinuada->fechahastadescuentoeducacioncontinuada='0000-00-00';
		$eliminar=$descuentoeducacioncontinuada->update();
		if($eliminar)
		{
			echo "<script language='javascript'>alert('Datos eliminados correctamente');</script>";
			echo '<script language="javascript">window.close();</script>';
			echo '<script language="javascript">window.opener.recargar();</script>';
		}	
}
?>
<script type="text/javascript">
Calendar.setup(
{
inputField : "fechadesdedescuentoeducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechadesdedescuentoeducacioncontinuada" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
	{
		inputField : "fechahastadescuentoeducacioncontinuada", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		button : "btfechahastadescuentoeducacioncontinuada" // ID of the button
	}
);
</script>
