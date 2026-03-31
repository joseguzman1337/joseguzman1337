<style type="text/css">@import url(../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../funciones/calendario_nuevo/calendar-setup.js"></script>
<script language="Javascript">
function abrir(pagina,ventana,parametros) {
	window.open(pagina,ventana,parametros);
}
</script>
<script language="javascript">
function enviar()
{
	document.form1.submit()
}
</script>

<style type="text/css">
<!--
.Estilo1 {font-family: Tahoma; font-size: 11px}
.Estilo2 {font-family: Tahoma; font-size: 12px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {color: #FF0000}
.Estilo5 {font-family: Tahoma; font-size: 12px}
.verdoso {background-color: #CCDADD;font-family: Tahoma; font-size: 12px; font-weight: bold;}
.amarrillento {background-color: #FEF7ED;font-family: Tahoma; font-size: 11px}
-->
</style>
<?php
//echo ini_get('include_path');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
require_once('../funciones/validacion.php');
require_once('../funciones/conexion/conexion.php');
require_once('../funciones/pear/PEAR.php');
require_once('../funciones/pear/DB.php');
require_once('../funciones/pear/DB/DataObject.php');
require_once('../funciones/gui/combo_valida_post_bd.php');
require_once('../funciones/gui/campotexto_valida_post_bd.php');
require_once('../funciones/gui/campofecha_valida_post_bd.php');
require_once('../funciones/validaciones/validardosfechas.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
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
$fechahoy=date("Y-m-d H:i:s");
$valoreducacioncontinuada=DB_DataObject::factory('valoreducacioncontinuada');
$valoreducacioncontinuada->get('idvaloreducacioncontinuada',$_GET['idvaloreducacioncontinuada']);
//print_r($valoreducacioncontinuada);
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">VALORE EDUCACION CONTINUADA - EDITAR </p>
  <table width="100%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" cellpadding="2" cellspacing="2">
        <tr>
          <td class="verdoso">Carrera</td>
          <td class="amarrillento"><div align="left"><?php echo $_GET['nombrecarrera']?></div></td>
        </tr>
        <tr>
          <td class="verdoso">Nombre</td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['nombrevaloreducacioncontinuada']=campotexto_valida_post_bd("nombrevaloreducacioncontinuada","requerido","nombre","40","valoreducacioncontinuada","idvaloreducacioncontinuada",$_GET['idvaloreducacioncontinuada'],"nombrevaloreducacioncontinuada")?>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Concepto</td>
          <td class="amarrillento"><?php $validacion['codigoconcepto']=combo_valida_post_bd("codigoconcepto","concepto","codigoconcepto","nombreconcepto","","codigoestado=100","si","concepto","valoreducacioncontinuada","idvaloreducacioncontinuada",$_GET['idvaloreducacioncontinuada'],"codigoconcepto")?>              
            <div align="left"></div></td>
        </tr>
        <tr>
          <td class="verdoso">Precio</td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['preciovaloreducacioncontinuada']=campotexto_valida_post_bd("preciovaloreducacioncontinuada","numero","Precio","10","valoreducacioncontinuada","idvaloreducacioncontinuada",$_GET['idvaloreducacioncontinuada'],"preciovaloreducacioncontinuada")?>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Fecha Inicio </td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['fechainiciovaloreducacioncontinuada']=campofecha_valida_post_bd("fechainiciovaloreducacioncontinuada","fecha","Fecha inicio","7","valoreducacioncontinuada","idvaloreducacioncontinuada",$_GET['idvaloreducacioncontinuada'],"fechainiciovaloreducacioncontinuada")?>
              <button id="btfechainiciovaloreducacioncontinuada">...</button>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Fecha Final </td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['fechafinalvaloreducacioncontinuada']=campofecha_valida_post_bd("fechafinalvaloreducacioncontinuada","fecha","Fecha final","7","valoreducacioncontinuada","idvaloreducacioncontinuada",$_GET['idvaloreducacioncontinuada'],"fechafinalvaloreducacioncontinuada")?>
              <button id="btfechafinalvaloreducacioncontinuada">...</button>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="verdoso"><div align="center">
              <input name="Guardar" type="submit" id="Guardar" value="Guardar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Eliminar" type="submit" id="Eliminar" value="Eliminar">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
  </form>



<?php
if(isset($_POST['Guardar']))
{
		$validacion['fechainicial,fechafinal']=validardosfechas($_POST['fechainiciovaloreducacioncontinuada'], $_POST['fechafinalvaloreducacioncontinuada'], "La fecha final, no puede ser menor a la fecha de inicio");
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$valoreducacioncontinuada->nombrevaloreducacioncontinuada=$_POST['nombrevaloreducacioncontinuada'];
		$valoreducacioncontinuada->fechavaloreducacioncontinuada=$fechahoy;
		$valoreducacioncontinuada->codigoconcepto=$_POST['codigoconcepto'];
		$valoreducacioncontinuada->preciovaloreducacioncontinuada=$_POST['preciovaloreducacioncontinuada'];
		$valoreducacioncontinuada->fechainiciovaloreducacioncontinuada=$_POST['fechainiciovaloreducacioncontinuada'];
		$valoreducacioncontinuada->fechafinalvaloreducacioncontinuada=$_POST['fechafinalvaloreducacioncontinuada'];
		//print_r($valoreducacioncontinuada);
		$actualizar=$valoreducacioncontinuada->update();
		if($actualizar)
		{
			echo "<script language='javascript'>alert('Datos modificados correctamente');</script>";
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
if(isset($_POST['Eliminar']))
{
	$valoreducacioncontinuada->fechainiciovaloreducacioncontinuada='0000-00-00';
	$valoreducacioncontinuada->fechafinalvaloreducacioncontinuada='0000-00-00';
	$valoreducacioncontinuada->fechavaloreducacioncontinuada=$fechahoy;	
	$actualizar=$valoreducacioncontinuada->update();
	if($actualizar)
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
inputField : "fechainiciovaloreducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechainiciovaloreducacioncontinuada" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
{
inputField : "fechafinalvaloreducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechafinalvaloreducacioncontinuada" // ID of the button
}
);
</script>
