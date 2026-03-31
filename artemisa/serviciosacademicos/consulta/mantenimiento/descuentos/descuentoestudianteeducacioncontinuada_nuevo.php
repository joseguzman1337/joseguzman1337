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
@session_start();
require_once(realpath(dirname(__FILE__)).'/../../../funciones/clases/autenticacion/redirect.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/combo_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validaciongenerica.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/validaciones/validardosfechas.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/arreglarfecha.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/funcionip.php');
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
@session_start();
//print_r($_GET);
//DB_DataObject::debugLevel(5);
$descuentoestudianteeducacioncontinuada=DB_DataObject::factory('descuentoestudianteeducacioncontinuada');
$descuentoestudianteeducacioncontinuada->get('iddescuentoestudianteeducacioncontinuada',$_GET['iddescuentoestudianteeducacioncontinuada']);
$usuario = DB_DataObject::factory('usuario');
$directivo=DB_DataObject::factory('directivo');
$usuario_sesion=$_SESSION['MM_Username'];
$usuario->get('usuario',$usuario_sesion);
$directivo->orderBy('apellidosdirectivo');
$directivo->get('','*');
$fechahoy=date("Y-m-d");
$ip=tomarip();

//print_r($descuentoestudianteeducacioncontinuada);
?>
<p align="center"><span class="Estilo3">DESCUENTO ESTUDIANTE EDUCACION CONTINUADA - NUEVO </span></p>
<form name="form1" method="post" action="">
<table width="100%"  border="1" bordercolor="#000000">
  <tr>
    <td><table width="100%"  border="0">
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Descuento</div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['iddescuentoeducacioncontinuada']=combo_valida_post("iddescuentoeducacioncontinuada","descuentoeducacioncontinuada","iddescuentoeducacioncontinuada","nombredescuentoeducacioncontinuada","","fechahastadescuentoeducacioncontinuada>='".$fechahoy."'","","si","Descuento")//fechadesdedescuentoeducacioncontinuada<='".$fechahoy."' and ?>
            <div align="left"></div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Descripci&oacute;n descuento </div></td>
        <td bgcolor="#FEF7ED"><?php $validacion['descripciondescuentoestudianteeducacioncontinuada']=campotexto_valida_post("descripciondescuentoestudianteeducacioncontinuada","requerido","Descripci&oacute;n","50","descuentoestudianteeducacioncontinuada","iddescuentoestudianteeducacioncontinuada",$_GET['iddescuentoestudianteeducacioncontinuada'],"descripciondescuentoestudianteeducacioncontinuada")?>
            <div align="left"></div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Directivo autoriza</div></td>
        <td bgcolor="#FEF7ED"><select name="iddirectivo">
          <option value="">Seleccionar</option>
          <?php do{ ?>
          <option value="<?php echo $directivo->iddirectivo?>" <?php if($_POST['iddirectivo']==$directivo->iddirectivo){echo "selected";}?>><?php echo $directivo->apellidosdirectivo,' ',$directivo->nombresdirectivo?></option>
          <?php }while($directivo->fetch())?>
        </select>
          <?php
			$validacion['iddirectivo']=validaciongenerica($_POST['iddirectivo'], "requerido", "Directivo");
			?></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha desde</div></td>
        <td bgcolor="#FEF7ED"><div align="left"><span class="phpmaker"><span class="style2"><span class="Estilo5">
          <?php $validacion['fechadesdedescuentoestudianteeducacioncontinuada']=campotexto_valida_post("fechadesdedescuentoestudianteeducacioncontinuada","fecha","Fecha desde","7");?>
          <button id="btfechadesdedescuentoestudianteeducacioncontinuada">...</button>
        </span></span></span></div></td>
      </tr>
      <tr>
        <td bgcolor="#CCDADD" class="Estilo2"><div align="center">Fecha hasta </div></td>
        <td bgcolor="#FEF7ED"><div align="left"><span class="phpmaker"><span class="style2"><span class="Estilo5">
          <?php $validacion['fechahastadescuentoestudianteeducacioncontinuada']=campotexto_valida_post("fechahastadescuentoestudianteeducacioncontinuada","fecha","Fecha hasta","7");?>
          <button id="btfechahastadescuentoestudianteeducacioncontinuada">...</button>
        </span></span></span></div></td>
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
</form>
<?php
if(isset($_POST['Enviar']))
{
	//echo $fechadesdedescuentoeducacioncontinuada,$fechahastadescuentoeducacioncontinuada;
	if($fechadesdedescuentoestudianteeducacioncontinuada>$fechahastadescuentoestudianteeducacioncontinuada)
	{
		$valor['valido']=0;
		$valor['mensaje']="La fecha desde no puede ser mayor a la fecha hasta";
		$validacion['mayor_fechadesde_fechahasta']=$valor;
	}
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		$descuentoestudianteeducacioncontinuada->descripciondescuentoestudianteeducacioncontinuada=$_POST['descripciondescuentoestudianteeducacioncontinuada'];
		$descuentoestudianteeducacioncontinuada->fechadescuentoestudianteeducacioncontinuada=$fechahoy;
		$descuentoestudianteeducacioncontinuada->iddescuentoeducacioncontinuada=$_POST['iddescuentoeducacioncontinuada'];
		$descuentoestudianteeducacioncontinuada->fechadesdedescuentoestudianteeducacioncontinuada=$_POST['fechadesdedescuentoestudianteeducacioncontinuada'];
		$descuentoestudianteeducacioncontinuada->fechahastadescuentoestudianteeducacioncontinuada=$_POST['fechahastadescuentoestudianteeducacioncontinuada'];
		$descuentoestudianteeducacioncontinuada->idusuario=$usuario->idusuario;
		$descuentoestudianteeducacioncontinuada->ip=$ip;
		$descuentoestudianteeducacioncontinuada->iddirectivo=$_POST['iddirectivo'];
		$descuentoestudianteeducacioncontinuada->codigoestudiante=$_GET['codigoestudiante'];
		//print_r($descuentoestudianteeducacioncontinuada);
		//DB_DataObject::debugLevel(5);
		$insertar=$descuentoestudianteeducacioncontinuada->insert();
		//DB_DataObject::debugLevel(0);
		if($insertar)
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
	echo '<script language="javascript">window.close();</script>';
}
?>
<script type="text/javascript">
Calendar.setup(
{
inputField : "fechadesdedescuentoestudianteeducacioncontinuada", // ID of the input field
ifFormat : "%Y-%m-%d", // the date format
button : "btfechadesdedescuentoestudianteeducacioncontinuada" // ID of the button
}
);
</script>

<script type="text/javascript">
Calendar.setup(
	{
		inputField : "fechahastadescuentoestudianteeducacioncontinuada", // ID of the input field
		ifFormat : "%Y-%m-%d", // the date format
		button : "btfechahastadescuentoestudianteeducacioncontinuada" // ID of the button
	}
);
</script>
