<?php
session_start();
unset($_SESSION['codigocarrerainfdetalle']);
unset($_SESSION['codigocarrerainf']);
unset($_SESSION['codigoperiodoinf']);
unset($_SESSION['codigomodalidadacademicainf']);
//print_r($_SESSION);
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
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<?php
$fechahoy=date("Y-m-d H:i:s");
$rutaado=("../../../funciones/adodb/");
require_once('../../../Connections/salaado-pear.php');
require_once("../../../funciones/validaciones/validaciongenerica.php");
$mensajegeneral='Los campos marcados con *, no han sido correctamente diligenciados\n';
$validaciongeneral=true;
class carrera extends ADODB_Active_Record {}
class periodo extends ADODB_Active_Record {}
class modalidadacademica extends ADODB_Active_Record {}

$modalidadacademica=new modalidadacademica('modalidadacademica');
$row_modalidadacademica=$modalidadacademica->Find('codigoestado=100 order by nombremodalidadacademica asc');
$carrera=new carrera('carrera');
if($_GET['codigomodalidadacademica']!="todos")
{
	$row_carrera=$carrera->Find("codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
}
else
{
	$row_carrera=$carrera->Find("codigomodalidadacademica='".$_GET['codigomodalidadacademica']."' and fechainiciocarrera <= '".$fechahoy."' and fechavencimientocarrera >= '".$fechahoy."' order by nombrecarrera");
}
$periodo=new periodo('periodo');
//$periodo=$sala->GetActiveRecords('periodo');
$row_periodo=$periodo->Find('codigoperiodo <> 1 order by codigoperiodo desc');
?>
<?php
@session_start();
//print_r($_GET);

?>
<form name="form1" method="get" action="">
	  <p align="left" class="Estilo3">INFORME - MATRICULADOS VARIOS PROGRAMAS</p>
  <table border="1" cellpadding="1" cellspacing="0" width="60%" bordercolor="#E9E9E9">
          <tr>
          <td width="14%" nowrap id="tdtitulogris">Modalidad acad&eacute;mica </td>
          <td width="86%"><select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_GET['codigomodalidadacademica']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php foreach ($row_modalidadacademica as $llave => $valor){?>
              <option value="<?php echo $valor->codigomodalidadacademica;?>"<?php if($valor->codigomodalidadacademica==$_GET['codigomodalidadacademica']){echo "Selected";}?>><?php echo $valor->nombremodalidadacademica?></option>
              <?php }?>
            </select>
              <?php $validacion['codigomodalidadacademica']=validaciongenerica($_GET['codigomodalidadacademica'], "requerido", "Modalidad acad&eacute;mica");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Programa</td>
          <td class="amarrillento"><select name="codigocarrera" id="codigocarrera">
              <option value="">Seleccionar</option>
              <option value="todos"<?php if($_GET['codigocarrera']=="todos"){echo "Selected";}?>>*Todos*</option>
              <?php foreach ($row_carrera as $llave => $valor){?>
              <option value="<?php echo $valor->codigocarrera?>"<?php if($valor->codigocarrera==$_GET['codigocarrera']){echo "Selected";}?>><?php echo $valor->nombrecarrera?></option>
              <?php };?>
            </select>
              <?php $validacion['codigocarrera']=validaciongenerica($_GET['codigocarrera'],"requerido","Programa");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Periodo</td>
          <td class="amarrillento"><select name="codigoperiodo" id="codigoperiodo">
              <option value="">Seleccionar</option>
              <?php foreach ($row_periodo as $llave => $valor){?>
              <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_GET['codigoperiodo']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
              <?php }?>
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
		/**
		 * Si existe array de recarga, se podrá recargar de nuevo
		 */
		$array_recarga[]=array('variable'=>'codigoperiodoinf','valor_variable'=>$_GET['codigoperiodo']);
		$array_recarga[]=array('variable'=>'codigomodalidadacademica','valor_variable'=>$_GET['codigomodalidadacademica']);
		$array_recarga[]=array('variable'=>'codigocarrerainf','valor_variable'=>$_GET['codigocarrera']);

		$_SESSION['archivo_ejecuta_recarga']='informe.php';
		$_SESSION['array_recarga']=$array_recarga;


		echo '<script language="javascript">reCarga("informe.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrerainf='.$_GET['codigocarrera'].'&codigoperiodoinf='.$_GET['codigoperiodo'].'");</script>';
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>