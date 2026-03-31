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
require_once('../funciones/gui/combo_valida_post.php');
require_once('../funciones/gui/campotexto_valida_post.php');
require_once('../funciones/validaciones/validardosfechas.php');
require_once('../../../funciones/clases/autenticacion/redirect.php');
//DB_DataObject::debugLevel(5);

$config = parse_ini_file('../funciones/conexion/basedatos.ini',TRUE);
$config['DB_DataObject']['database']="mysql://".$username_sala.":".$password_sala."@".$hostname_sala."/".$database_sala;
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
?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo3">VALORE EDUCACION CONTINUADA - NUEVO</p>
  <table width="100%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%" cellpadding="2" cellspacing="2">
        <tr>
          <td class="verdoso">Carrera</td>
          <td class="amarrillento"><div align="left"><?php $validacion['codigocarrera']=combo_valida_post("codigocarrera","carrera","codigocarrera","nombrecarrera","","fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' and codigomodalidadacademica='".$_GET['codigomodalidadacademica']."'","nombrecarrera asc","si","Carrera")?></div></td>
        </tr>
        <tr>
          <td class="verdoso">Nombre</td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['nombrevaloreducacioncontinuada']=campotexto_valida_post("nombrevaloreducacioncontinuada","requerido","nombre","40")?>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Concepto</td>
          <td class="amarrillento"><?php $validacion['codigoconcepto']=combo_valida_post("codigoconcepto","concepto","codigoconcepto","nombreconcepto","","codigoestado=100","nombreconcepto asc","si","concepto")?>              
            <div align="left"></div></td>
        </tr>
        <tr>
          <td class="verdoso">Precio</td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['preciovaloreducacioncontinuada']=campotexto_valida_post("preciovaloreducacioncontinuada","numero","Precio","10")?>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Fecha Inicio </td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['fechainiciovaloreducacioncontinuada']=campotexto_valida_post("fechainiciovaloreducacioncontinuada","fecha","Fecha inicio","7")?>
              <button id="btfechainiciovaloreducacioncontinuada">...</button>
          </div></td>
        </tr>
        <tr>
          <td class="verdoso">Fecha Final </td>
          <td class="amarrillento"><div align="left">
              <?php $validacion['fechafinalvaloreducacioncontinuada']=campotexto_valida_post("fechafinalvaloreducacioncontinuada","fecha","Fecha final","7")?>
              <button id="btfechafinalvaloreducacioncontinuada">...</button>
          </div></td>
        </tr>
        <tr>
          <td colspan="2" class="verdoso"><div align="center">
              <input name="Guardar" type="submit" id="Guardar" value="Guardar">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
		$valoreducacioncontinuada->codigocarrera=$_POST['codigocarrera'];
		//print_r($valoreducacioncontinuada);
		$insertar=$valoreducacioncontinuada->insert();
		if($insertar)
		{
			echo "<script language='javascript'>alert('Datos agregados correctamente');</script>";
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
