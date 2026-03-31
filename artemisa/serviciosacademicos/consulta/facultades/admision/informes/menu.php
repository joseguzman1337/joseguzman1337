<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
//session_start();
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
require_once("../../../../../funciones/conexion/conexionpear.php");
require_once("../../../../../funciones/validaciones/validaciongenerica.php");
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$validaciongeneral=true;
?>
<?php
@session_start();
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
  <p align="center" class="Estilo3">ESTADISTICAS MATRICULAS - MENU PRINCIPAL </p>
  <table width="90%"  border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
    <tr>
      <td><table width="100%"  border="0" align="center" cellspacing="2">
        <tr>
          <td width="14%" nowrap class="verdoso">Modalidad acad&eacute;mica </td>
          <td width="86%" class="amarrillento"><select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_GET['codigomodalidadacademica']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php do{?>
              <option value="<?php echo $modalidadacademica->codigomodalidadacademica?>"<?php if($modalidadacademica->codigomodalidadacademica==$_GET['codigomodalidadacademica']){echo "Selected";}?>><?php echo $modalidadacademica->nombremodalidadacademica?></option>
              <?php } while ($modalidadacademica->fetch());?>
            </select>
              <?php $validacion['codigomodalidadacademica']=validaciongenerica($_GET['codigomodalidadacademica'], "requerido", "Modalidad acad&eacute;mica");?></td>
        </tr>
        <tr>
          <td nowrap class="verdoso">Programa</td>
          <td class="amarrillento"><select name="codigocarrera" id="codigocarrera">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_GET['codigocarrera']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php do{?>
              <option value="<?php echo $carrera->codigocarrera?>"<?php if($carrera->codigocarrera==$_GET['codigocarrera']){echo "Selected";}?>><?php echo $carrera->nombrecarrera?></option>
              <?php } while ($carrera->fetch());?>
            </select>
              <?php $validacion['codigocarrera']=validaciongenerica($_GET['codigocarrera'],"requerido","Programa");?></td>
        </tr>
        <tr>
          <td nowrap class="verdoso">Periodo</td>
          <td class="amarrillento"><select name="codigoperiodo" id="codigoperiodo">
              <option value="">Seleccionar</option>
              <?php do{?>
              <option value="<?php echo $periodo->codigoperiodo?>"<?php if($periodo->codigoperiodo==$_GET['codigoperiodo']){echo "Selected";}?>><?php echo $periodo->codigoperiodo?></option>
              <?php } while ($periodo->fetch());?>
            </select>
              <?php $validacion['codigoperiodo']=validaciongenerica($_GET['codigoperiodo'],"requerido","Periodo");?></td>
        </tr>
        <tr>
          <td colspan="2" nowrap><div align="center" class="verde">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
          </div></td>
        </tr>
      </table></td>
    </tr>
  </table>
</form>
<?php if(isset($_GET['Restablecer'])){?>
<script language="javascript">window.location.reload("menu.php")</script>
<?php } ?>
<?php
if(isset($_GET['Enviar']))
{
	foreach ($validacion as $key => $valor){/*echo $valor['valido'];*/if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		echo '<script language="javascript">window.location.reload("admisiones.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'");</script>';
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>