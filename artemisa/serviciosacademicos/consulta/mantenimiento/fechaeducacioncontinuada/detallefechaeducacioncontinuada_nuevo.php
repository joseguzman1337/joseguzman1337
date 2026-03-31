<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<script language="JavaScript" src="../funciones/calendario/javascripts.js"></script><script language="JavaScript" src="../funciones/calendario/javascripts.js"></script>
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

//print_r($_POST);
//echo ini_get('include_path');
require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set("include_path", ".:/usr/share/pear_");
//error_reporting(2048);
//@session_start();
require_once(realpath(dirname(__FILE__)).'/../funciones/validacion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/conexion/conexion.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/PEAR.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/pear/DB/DataObject.php');
require_once(realpath(dirname(__FILE__)).'/../funciones/gui/campotexto_valida_post.php');
require_once(realpath(dirname(__FILE__)).'/calendario/calendario.php');
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
$detallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$query_ultimo_detallefechaeducacioncontinuada="select max(iddetallefechaeducacioncontinuada)as iddetallefechaeducacioncontinuada from detallefechaeducacioncontinuada where idfechaeducacioncontinuada='".$_GET['idfechaeducacioncontinuada']."'";
//echo $query_ultimo_detallefechaeducacioncontinuada;
$ultimo_detallefechaeducacioncontinuada=$sala->query($query_ultimo_detallefechaeducacioncontinuada);
$row_ultimodetallefechaeducacioncontinuada=$ultimo_detallefechaeducacioncontinuada->fetchRow();
$consultadetallefechaeducacioncontinuada=DB_DataObject::factory('detallefechaeducacioncontinuada');
$consultadetallefechaeducacioncontinuada->get('iddetallefechaeducacioncontinuada',$row_ultimodetallefechaeducacioncontinuada['iddetallefechaeducacioncontinuada']);
//print_r($consultadetallefechaeducacioncontinuada);

?>
<form name="form1" method="post" action="">
  <p align="center" class="Estilo2">FECHA EDUCACION CONTINUADA - DETALLE  NUEVO</p>
  <table width="100%" border="1" align="center" bordercolor="#000000">
    <tr>
      <td><table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Fecha</div></td>
          <td bgcolor="#FEF7ED"><span class="phpmaker"><span class="style2"><span class="Estilo5">
            <?php escribe_formulario_fecha_vacio("fechadetallefechaeducacioncontinuada","form1","",$_POST['fechadetallefechaeducacioncontinuada']);
				  $validacion['fechadetallefechaeducacioncontinuada']=validaciongenerica($_POST['fechadetallefechaeducacioncontinuada'], "requerido", "Fecha detalle");
				  $fechadetallefechaeducacioncontinuada=arreglarfecha($_POST['fechadetallefechaeducacioncontinuada']);
				  //echo $fechadetallefechaeducacioncontinuada;echo $consultadetallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada;
				  if($fechadetallefechaeducacioncontinuada <= $consultadetallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada)
					  {
							echo "<style type='text/css'><!--.Estilo99{font-size: 18px;color: #FF0000;}--></style>";
							echo "<span class='Estilo99'>*</span>";
							$valido['mensaje']="La fecha seleccionada, se cruza con fechas anteriores";
							$valido['valido'] = 0;
							$validacion['fechamayordetallefecuaeducacioncontinuada']=$valido;
					  }
		  ?>
          </span></span></span></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">N&uacute;mero</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['numerodetallefechaeducacioncontinuada']=campotexto_valida_post("numerodetallefechaeducacioncontinuada","requerido","Número","10")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Nombre</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['nombredetallefechaeducacioncontinuada']=campotexto_valida_post("nombredetallefechaeducacioncontinuada","requerido","Nombre","10")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td bgcolor="#CCDADD"><div align="center">Porcentaje</div></td>
          <td bgcolor="#FEF7ED"><?php $validacion['porcentajedetallefechaeducacioncontinuada']=campotexto_valida_post("porcentajedetallefechaeducacioncontinuada","porcentaje","Porcentaje","10")?></td>
        </tr>
        <tr bgcolor="#CCDADD" class="Estilo2">
          <td colspan="2"><div align="center">
            <input name="Enviar" type="submit" id="Enviar" value="Enviar">
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
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
	foreach ($validacion as $key => $valor){if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true){
		$detallefechaeducacioncontinuada->idfechaeducacioncontinuada=$_GET['idfechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->numerodetallefechaeducacioncontinuada=$_POST['numerodetallefechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->nombredetallefechaeducacioncontinuada=$_POST['nombredetallefechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->porcentajedetallefechaeducacioncontinuada=$_POST['porcentajedetallefechaeducacioncontinuada'];
		$detallefechaeducacioncontinuada->fechadetallefechaeducacioncontinuada=$_POST['fechadetallefechaeducacioncontinuada'];
		$insertar=$detallefechaeducacioncontinuada->insert();
		if($insertar)
		{
			echo "<script language='javascript'>alert('Datos insertados correctamente');</script>";
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
	echo '<script language="javascript">window.opener.recargar();</script>';
}
?>
