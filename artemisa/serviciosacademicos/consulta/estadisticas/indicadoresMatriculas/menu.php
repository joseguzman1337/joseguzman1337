<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
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
  <p align="left" class="Estilo3">INDICADORES SALA - MENU PRINCIPAL </p>
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
          <td nowrap id="tdtitulogris">Periodo Inicial</td>
          <td class="amarrillento"><select name="codigoperiodoini" id="codigoperiodoini">
              <option value="">Seleccionar</option>
              <?php foreach ($row_periodo as $llave => $valor){?>
              <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_GET['codigoperiodoini']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
              <?php }?>
            </select>
              <?php $validacion['codigoperiodoini']=validaciongenerica($_GET['codigoperiodoini'],"requerido","Periodo Inicial");?></td>
        </tr>
        <tr>
          <td nowrap id="tdtitulogris">Periodo Final</td>
          <td class="amarrillento"><select name="codigoperiodofin" id="codigoperiodofin">
              <option value="">Seleccionar</option>
              <?php foreach ($row_periodo as $llave => $valor){?>
              <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_GET['codigoperiodofin']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
              <?php }?>
            </select>
              <?php $validacion['codigoperiodofin']=validaciongenerica($_GET['codigoperiodofin'],"requerido","Periodo Final");?></td>
        </tr>
        
        <tr>
        	<td nowrap id="tdtitulogris">Indicador</td>
        	<td class="amarillento">
        	<select name="indicador" id="indicador">
        	<option value="">Seleccionar</option>
        	<option <?php if($_GET['indicador']=='Interesados'){echo "selected";}?> value="Interesados">Interesados</option>
        	<option <?php if($_GET['indicador']=='Aspirantes'){echo "selected";}?> value="Aspirantes">Aspirantes</option>
        	<option <?php if($_GET['indicador']=='a_seguir_aspirantes_vs_inscritos'){echo "selected";}?> value="a_seguir_aspirantes_vs_inscritos">a_seguir_aspirantes_vs_inscritos</option>
        	<option <?php if($_GET['indicador']=='Inscritos'){echo "selected";}?> value="Inscritos">Inscritos</option>
        	<option <?php if($_GET['indicador']=='a_seguir_inscritos_vs_matriculados_nuevos'){echo "selected";}?> value="a_seguir_inscritos_vs_matriculados_nuevos">a_seguir_inscritos_vs_matriculados_nuevos</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Nuevos'){echo "selected";}?> value="Matriculados_Nuevos">Matriculados_Nuevos</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Antiguos'){echo "selected";}?> value="Matriculados_Antiguos">Matriculados_Antiguos</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Transferencia'){echo "selected";}?> value="Matriculados_Transferencia">Matriculados_Transferencia</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Reintegro'){echo "selected";}?> value="Matriculados_Reintegro">Matriculados_Reintegro</option>
        	<option <?php if($_GET['indicador']=='Total_Matriculados'){echo "selected";}?> value="Total_Matriculados">Total_Matriculados</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Repitentes_1_semestre'){echo "selected";}?> value="Matriculados_Repitentes_1_semestre">Matriculados_Repitentes_1_semestre</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Transferencia_1_semestre'){echo "selected";}?> value="Matriculados_Transferencia_1_semestre">Matriculados_Transferencia_1_semestre</option>
        	<option <?php if($_GET['indicador']=='Matriculados_Reintegro_1_semestre'){echo "selected";}?> value="Matriculados_Reintegro_1_semestre">Matriculados_Reintegro_1_semestre</option>
        	<option <?php if($_GET['indicador']=='Total_Matriculados_1_semestre'){echo "selected";}?> value="Total_Matriculados_1_semestre">Total_Matriculados_1_semestre</option>
        	<option <?php if($_GET['indicador']=='a_seguir_Prematriculados'){echo "selected";}?> value="a_seguir_Prematriculados">a_seguir_Prematriculados</option>
        	<option <?php if($_GET['indicador']=='a_seguir_No_prematriculados'){echo "selected";}?> value="a_seguir_No_prematriculados">a_seguir_No_prematriculados</option>
        	</select>
        	<?php $validacion['indicador']=validaciongenerica($_GET['indicador'],"requerido","Indicador");?></td>
        	</td>
        </tr>
        
        <tr>
          <td colspan="2" nowrap><div align="center" class="verde">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
          </div></td>
        </tr>
  </table>
  <br>
  <strong>Nota: Para poder observar las gráficas, se debe tener en cuenta:</strong><br><br>
  <li>Si se desea graficar por periodos, se debe escojer solo una carrera</li>
  <li>Si se desea graficar por carreras, se debe escojer el mismo periodo en el campo periodo inicial y periodo final</li>
  <li>Si se escojen varias carreras/periodos, se presentará solamente el resúmen</li>
  
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
		$array_recarga[]=array('variable'=>'codigoperiodoini','valor_variable'=>$_GET['codigoperiodoini']);
		$array_recarga[]=array('variable'=>'codigoperiodofin','valor_variable'=>$_GET['codigoperiodofin']);
		$array_recarga[]=array('variable'=>'codigomodalidadacademica','valor_variable'=>$_GET['codigomodalidadacademica']);
		$array_recarga[]=array('variable'=>'codigocarrera','valor_variable'=>$_GET['codigocarrera']);
		$_SESSION['archivo_ejecuta_recarga']='tabla_estadisticas_matriculas.php';
		$_SESSION['array_recarga']=$array_recarga;
		echo '<script language="javascript">reCarga("indicadoresPrincipal.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarreraseleccion='.$_GET['codigocarrera'].'&codigoperiodoini='.$_GET['codigoperiodoini'].'&codigoperiodofin='.$_GET['codigoperiodofin'].'&indicador='.$_GET['indicador'].'");</script>';

	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>