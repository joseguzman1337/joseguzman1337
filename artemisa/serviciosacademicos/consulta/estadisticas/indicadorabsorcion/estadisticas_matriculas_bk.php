<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
?>

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
.verdoso {
	background-color: #CCDADD;
	font-family: Tahoma; font-size: 12px; font-weight: bold;
}
.amarrillento {
	background-color: #FEF7ED;
	font-family: Tahoma; font-size: 11px
}
.rojo {color: #FF0000}
.verde {background-color: #CCDADD;}
-->
</style>
<?php
require_once("../../../../funciones/conexion/conexionpear.php");
require_once("../../../../funciones/gui/combo_valida_get.php");
require_once("filtro.php");
require_once("obtener_datos.php");
require_once("imprimir_arrays_bidimensionales.php");
?>
<?php
//@session_start();
//print_r($_GET);
$fechahoy=date("Y-m-d H:i:s");
$modalidadacademica=DB_DataObject::factory('modalidadacademica');
$modalidadacademica->whereAdd("codigoestado=100");
$modalidadacademica->orderBy("nombremodalidadacademica");
$modalidadacademica->find();
$modalidadacademica->fetch();
$carrera=DB_DataObject::factory('carrera');
$carrera->whereAdd("fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."'");
if($_GET['codigomodalidadacademica']!="todos")
{
	$carrera->whereAdd("codigomodalidadacademica='".$_GET['codigomodalidadacademica']."'");
}
$carrera->orderBy("nombrecarrera");
$carrera->find();
$carrera->fetch();
$referenciaconcepto=DB_DataObject::factory('referenciaconcepto');
$referenciaconcepto->whereAdd("codigoestado=100");
$referenciaconcepto->orderBy("nombrereferenciaconcepto");
$referenciaconcepto->find();
$referenciaconcepto->fetch();
$periodo=DB_DataObject::factory('periodo');
$periodo->orderBy("codigoperiodo desc");
$periodo->find();
$periodo->fetch();
?>
<form name="form1" method="get" action="">
  <table width="80%"  border="1" align="center">
    <tr>
      <td width="14%" nowrap>Modalidad acad&eacute;mica </td>
      <td width="86%"><select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
      <option value="">Seleccionar</option>
      <option value="todos"<?php if($_GET['codigomodalidadacademica']=="todos"){echo "Selected";}?>>*Todos*</option>
      <?php do{?><option value="<?php echo $modalidadacademica->codigomodalidadacademica?>"<?php if($modalidadacademica->codigomodalidadacademica==$_GET['codigomodalidadacademica']){echo "Selected";}?>><?php echo $modalidadacademica->nombremodalidadacademica?></option><?php } while ($modalidadacademica->fetch());?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Programa</td>
      <td><select name="codigocarrera" id="codigocarrera">
      <option value="">Seleccionar</option>
      <option value="todos"<?php if($_GET['codigocarrera']=="todos"){echo "Selected";}?>>*Todos*</option>
      <?php do{?><option value="<?php echo $carrera->codigocarrera?>"<?php if($carrera->codigocarrera==$_GET['codigocarrera']){echo "Selected";}?>><?php echo $carrera->nombrecarrera?></option><?php } while ($carrera->fetch());?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Concepto</td>
      <td><select name="codigoreferenciaconcepto" id="codigoreferenciaconcepto">
      <option value="">Seleccionar</option>
      <option value="todos"<?php if($_GET['codigoreferenciaconcepto']=="todos"){echo "Selected";}?>>*Todos*</option>
      <?php do{?><option value="<?php echo $referenciaconcepto->codigoreferenciaconcepto?>"<?php if($referenciaconcepto->codigoreferenciaconcepto==$_GET['codigoreferenciaconcepto']){echo "Selected";}?>><?php echo $referenciaconcepto->nombrereferenciaconcepto?></option><?php } while ($referenciaconcepto->fetch());?>
      </select></td>
    </tr>
    <tr>
      <td nowrap>Periodo</td>
      <td><select name="codigoperiodo" id="codigoperiodo">
      <option value="">Seleccionar</option>
      <option value="todos"<?php if($_GET['codigoperiodo']=="todos"){echo "Selected";}?>>*Todos*</option>
      <?php do{?><option value="<?php echo $periodo->codigoperiodo?>"<?php if($periodo->codigoperiodo==$_GET['codigoperiodo']){echo "Selected";}?>><?php echo $periodo->codigoperiodo?></option><?php } while ($periodo->fetch());?>
      </select></td>
    </tr>
    <tr>
      <td colspan="2" nowrap><div align="center">
        <input name="Enviar" type="submit" id="Enviar" value="Enviar">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
</div></td>
    </tr>
  </table>
</form>
<?php if(isset($_GET['Restablecer'])){?>
<script language="javascript">window.location.reload("estadisticas_matriculas.php")</script>
<?php } ?>
<?php
if(isset($_GET['Enviar']))
{
	if(isset($_GET['codigoperiodo']) and $_GET['codigoperiodo']!="" and $_GET['codigoperiodo']!="todos")
	{
		$criterio="o.codigoperiodo";
		$valor=$_GET['codigoperiodo'];
	}
	elseif (isset($_GET['codigomodalidadacademica']) and $_GET['modalidadacademica']!="" and $_GET['modalidadacademica']!="todos")
	{
		$criterio="ma.codigomodalidadacademica";
		$valor=$_GET['codigomodalidadacademica'];
	}
	elseif (isset($_GET['codigocarrera']) and $_GET['codigocarrera']!="" and $_GET['codigocarrera']!="todos")
	{
		$criterio="c.codigocarrera";
		$valor=$_GET['codigocarrera'];
	}
	$datos_matriculas=new obtener_datos_matriculas($sala);
	$row_datos_base=$datos_matriculas->obtener_datos_base($criterio,$valor);
}
?>