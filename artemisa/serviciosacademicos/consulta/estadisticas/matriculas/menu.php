<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

//session_start();
unset($_SESSION['codigocarrerainfdetalle']);
unset($_SESSION['codigocarrerainf']);
unset($_SESSION['codigoperiodoinf']);
unset($_SESSION['codigomodalidadacademicainf']);
//require_once('../../../funciones/clases/autenticacion/redirect.php');
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
function enviofinal(opcion,cadenaget){

var formulario=document.getElementById('form1');
switch(opcion){
			case 1:
				formulario.action="estadisticas_matriculas.php";
				break;
			case 2:
				formulario.action="../estadisticasSemestrales/principal.php?"+cadenaget;
				formulario.method="post";
				alert(formulario.action);
				break;
			default:
				formulario.action="estadisticas_matriculas.php";
			break;
}
formulario.submit();

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
if($_GET['ciclocontacto']==1){
$_SESSION['ciclocontacto']=1;
}
if($_GET['ciclocontacto']==2){
$_SESSION['ciclocontacto']=0;
}

$row_periodo=$periodo->Find('codigoperiodo <> 1 order by codigoperiodo desc');

$situacioncarreraestudiante[]='Interesados';
$situacioncarreraestudiante[]='Aspirantes';

if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='a_seguir_aspirantes_vs_inscritos';

$situacioncarreraestudiante[]='Inscritos';
$situacioncarreraestudiante[]='Inscritos_Evaluados';
//$situacioncarreraestudiante[]='Evaluado_No_Admitido';
//$situacioncarreraestudiante[]='Admitido';

if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='a_seguir_inscritos_vs_matriculados_nuevos';

$situacioncarreraestudiante[]='Matriculados_Nuevos';

if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Matriculados_Antiguos';

if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Matriculados_Transferencia';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Matriculados_Reintegro';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Total_Matriculados';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Matriculados_Repitentes_1_semestre';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Matriculados_Transferencia_1_semestre';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Matriculados_Reintegro_1_semestre';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='Total_Matriculados_1_semestre';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='a_seguir_Prematriculados';
if(!$_SESSION['ciclocontacto'])
$situacioncarreraestudiante[]='a_seguir_No_prematriculados';
$_SESSION['listadoestadoestudiantesesionestadisticas']=$situacioncarreraestudiante;
?>
<?php
@session_start();
//print_r($_GET);

?>
  <p align="left" class="Estilo3">ESTADISTICAS MATRICULAS - MENU PRINCIPAL </p>

<form name="form1" id="form1" method="get" action="">
  <table border="1" cellpadding="1" cellspacing="0" width="80%" bordercolor="#E9E9E9">
          <tr>
          <td width="14%" nowrap id="tdtitulogris">Modalidad acad&eacute;mica </td>
          <td width="86%" colspan="2"><select name="codigomodalidadacademica" id="codigomodalidadacademica" onchange="enviar()">
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
          <td colspan="2" class="amarrillento"><select name="codigocarrera" id="codigocarrera">
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
          <td colspan="2" class="amarrillento"><select name="codigoperiodo" id="codigoperiodo">
              <option value="">Seleccionar</option>
              <?php foreach ($row_periodo as $llave => $valor){?>
              <option value="<?php echo $valor->codigoperiodo?>"<?php if($valor->codigoperiodo==$_GET['codigoperiodo']){echo "Selected";}?>><?php echo $valor->codigoperiodo?></option>
              <?php }?>
            </select>
              <?php $validacion['codigoperiodo']=validaciongenerica($_GET['codigoperiodo'],"requerido","Periodo");?></td>
        </tr>
        <tr>
        	<td nowrap id="tdtitulogris">Criterio</td>
        	<td colspan="2" class="amarillento">
        		<select name="criterio">
        			<option selected value="1">Estadísticas Generales</option>
        			<option value="2">Estadísticas matriculados x Semestre</option>
        		</select>
        	</td>
        </tr>
        <tr>
        	<td nowrap id="tdtitulogris">Estados </td>
	       	<td class="amarillento">
        		<select name="criteriosituacion[]" multiple='multiple'>
				<option value="todos">TODOS</option>
					<?php
					for($i=0;$i<count($situacioncarreraestudiante);$i++){
						if(is_array($_GET['criteriosituacion']))
						if(in_array($situacioncarreraestudiante[$i],$_GET['criteriosituacion']))
							$seleccionar=" selected";
						else
							$seleccionar="";
						echo "<option value='".$situacioncarreraestudiante[$i]."' ".$seleccionar.">".str_replace("_"," ",$situacioncarreraestudiante[$i])."</option>";
						}
					?>
        		</select>       		</td>
            <td class="amarillento"><div align="justify">Escoja los estados que prefiera en la estadistica con ayuda del click del mouse y las teclas (shift) o (ctrl). Para seleccionar todas no escoja ninguna opci&oacute;n o la opci&oacute;n TODOS </div></td>
        </tr>

        <tr>
          <td colspan="3" nowrap><div align="center" class="verde">
              <input name="Enviar" type="submit" id="Enviar" value="Enviar">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <input name="Restablecer" type="submit" id="Restablecer" value="Restablecer">
          </div></td>
        </tr>
  </table>
</form>
<?php if(isset($_GET['Restablecer'])){?>
<script language="javascript">window.location.href="menu.php"</script>
<?php } ?>
<?php
if(isset($_GET['Enviar']))
{

//exit();
	foreach ($validacion as $key => $valor){/*echo $valor['valido'];*/if($valor['valido']==0){$mensajegeneral=$mensajegeneral.'\n'.$valor['mensaje'];$validaciongeneral=false;}}
	if($validaciongeneral==true)
	{
		/**
		 * Si existe array de recarga, se podrá recargar de nuevo
		 */
		$array_recarga[]=array('variable'=>'codigoperiodo','valor_variable'=>$_GET['codigoperiodo']);
		$array_recarga[]=array('variable'=>'codigomodalidadacademica','valor_variable'=>$_GET['codigomodalidadacademica']);
		$array_recarga[]=array('variable'=>'codigocarrera','valor_variable'=>$_GET['codigocarrera']);
		$array_recarga[]=array('variable'=>'criterio','valor_variable'=>$_GET['criterio']);
		$array_recarga[]=array('variable'=>'criteriosituacion','valor_variable'=>$_GET['criteriosituacion']);

		$_SESSION['archivo_ejecuta_recarga']='tabla_estadisticas_matriculas.php';
		//$_SESSION['array_recarga']=$array_recarga;


		echo "<script language='javascript'>enviofinal(".$_GET['criterio'].",'".'codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrerainf='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo']."');</script>";
		/*switch ($_GET['criterio']){
			case 1:
				echo '<script language="javascript">reCarga("estadisticas_matriculas.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'&criteriosituacion='.$_GET['criteriosituacion'].'");</script>';
				break;
			case 2:
				echo '<script language="javascript">reCarga("../estadisticasSemestrales/principal.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrerainf='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'");</script>';
				break;
			default:
				echo '<script language="javascript">reCarga("estadisticas_matriculas.php?codigomodalidadacademica='.$_GET['codigomodalidadacademica'].'&codigocarrera='.$_GET['codigocarrera'].'&codigoperiodo='.$_GET['codigoperiodo'].'");</script>';
				break;
		}*/
	}
	else
	{
		echo "<script language='javascript'>alert('".$mensajegeneral."');</script>";
	}
}
?>