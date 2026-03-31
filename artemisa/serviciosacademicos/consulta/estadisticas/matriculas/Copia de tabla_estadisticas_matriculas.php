<?php
session_start();
require_once('../../../funciones/clases/autenticacion/redirect.php');
ini_set('memory_limit', '128M');
ini_set('max_execution_time','216000');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<table  border="1" cellpadding="1" cellspacing="0" width="100%" bordercolor="#E9E9E9">
  <tr>
    <td id="tdtitulogris" nowrap>Interesados</td>
    <td colspan="2" nowrap>Personas que presentan alg&uacute;n tipo de inter&eacute;s en uno o m&aacute;s programas institucionales, registrados en la base de datos.</td>
  </tr>
  <tr>
    <td id="tdtitulogris" nowrap>&nbsp;</td>
    <td nowrap><label id="labelresaltado">Seguimiento</label></td>
    <td nowrap>Orientado a ampliar la informaci&oacute;n del (los) programa(s)de inter&eacute;s y direccionar a uno solo. Identificar sus necesidades y alimentar la la base de datos institucional.</td>
  </tr>
  <tr>
    <td id="tdtitulogris" nowrap>Aspirantes</td>
    <td colspan="2" nowrap>Interesados que manifiestan seria voluntad en iniciar el proceso de inscripci&oacute;n en un programa institucional, han diligenciado preinscripci&oacute;n y tienen n&uacute;mero de orden de pago de derechos de inscripci&oacute;n.</td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td nowrap ><label id="labelresaltado">Seguimiento</label></td>
    <td nowrap> Orientado a Motivar  el pago de inscripci&oacute;n y orientar sobre proceso de selecci&oacute;n correspondiente.</td>
  </tr>
  <tr>
    <td nowrap id="tdtitulogris">Inscritos</td>
    <td colspan="2" nowrap>Aspirantes que ya han cancelado derechos de inscripci&oacute;n y est&aacute; en curso el proceso de selecci&oacute;n correspondiente a cada programa acad&eacute;mico.</td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td nowrap><label id="labelresaltado">Seguimiento</label></td>
    <td nowrap>Citaci&oacute;n al proceso mencionado con par&aacute;metros y t&eacute;rminos definidos.</td>
  </tr>
  <tr>
    <td nowrap id="tdtitulogris">Prematriculados</td>
    <td colspan="2" nowrap>Estudiantes que han realizado su proceso de prematricula, se les ha generado orden de pago que a&uacute;n no han pagado o su pago no ha sido registrado en el sistema.</td>
  </tr>
  <tr>
    <td nowrap>&nbsp;</td>
    <td nowrap><label id="labelresaltado">Seguimiento</label></td>
    <td nowrap>Orientado a motivar el pago de matr&iacute;cula, indicando alternativas de financiaci&oacute;n y t&eacute;rminos.</td>
  </tr>
  <tr>
    <td nowrap id="tdtitulogris">Matriculados</td>
    <td colspan="2" nowrap>Estudiantes que han cancelado el valor de su matr&iacute;cula.</td>
  </tr>
  <tr>
    <td nowrap id="tdtitulogris">&nbsp;</td>
    <td nowrap><label id="labelresaltado">Seguimiento</label></td>
    <td nowrap>Orientado a evaluar el proceso de ingreso realizado y a indicar sobre inducci&oacute;n, fechas de ingreso, examen m&eacute;dicao y dem&aacute;s requisitos particulares al programa vinculado.</td>
  </tr>
</table>
<?php
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
//echo ini_get('memory_limit');
//print_r( ini_get_all());
//error_reporting(0);
$_SESSION['get']=$_GET;
if(!isset($_SESSION['array_estadisticas']))
{
	echo '<script language="javascript">alert("Sesion perdida, no se puede continuar")</script>';
	exit();
}
require_once("../../../funciones/clases/motor/motor.php");
?>
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<?php
$informe=new matriz($_SESSION['array_estadisticas'],"Estadísticas matrículas periodo ".$_SESSION['codigoperiodo_reporte'],"tabla_estadisticas_matriculas.php","si","no","menu.php","estadisticas_matriculas.php");
$informe->definir_llave_globo_general('Programa');
$informe->agregarllave_drilldown('Interesados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Interesados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."","","","","Seguimiento a alumnos interesados");
$informe->agregarllave_drilldown('Aspirantes','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Aspirantes','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Formularios','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Formularios','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('a_seguir_aspirantes_vs_inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','a_seguir_aspirantes_vs_inscritos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Inscritos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('a_seguir_inscritos_vs_matriculados_nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','inscripcionvsmatriculadosnuevos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");

$informe->agregarllave_drilldown('Matriculados_Nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosNuevos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Matriculados_Antiguos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosAntiguos','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Matriculados_Transferencia','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosTransferencia','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Matriculados_Reintegro','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','MatriculadosReintegro','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Total_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','TotalMatriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");

$informe->agregarllave_drilldown('Matriculados_Repitentes_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Matriculados_Repitentes_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Matriculados_Transferencia_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Matriculados_Transferencia_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Matriculados_Reintegro_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Matriculados_Reintegro_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('Total_Matriculados_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Total_Matriculados_1_semestre','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");

$informe->agregarllave_drilldown('a_seguir_Prematriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Prematriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."");
$informe->agregarllave_drilldown('a_seguir_No_prematriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','Noprematriculados','codigocarrera',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."","","","","");


$informe->agregar_llaves_totales('Interesados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Interesados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Interesados');
$informe->agregar_llaves_totales('Aspirantes','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Aspirantes',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Aspirantes');
$informe->agregar_llaves_totales('Inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Inscripciones',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Inscripciones');
$informe->agregar_llaves_totales('a_seguir_inscritos_vs_matriculados_nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_a_seguir_inscripcion_vs_matriculados_nuevos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','a_seguir_inscripcion_vs_matriculados_nuevos');
$informe->agregar_llaves_totales('a_seguir_aspirantes_vs_inscritos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_a_seguir_aspirantes_vs_inscritos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','a_seguir_aspirantes_vs_inscritos');
$informe->agregar_llaves_totales('Matriculados_Nuevos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_MatriculadosNuevos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Nuevos');
$informe->agregar_llaves_totales('Matriculados_Antiguos','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_MatriculadosAntiguos',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Antiguos');
$informe->agregar_llaves_totales('Matriculados_Repitentes_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Repitentes_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Repitentes_1_semestre');
$informe->agregar_llaves_totales('Matriculados_Transferencia','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Transferencia',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Transferencia');
$informe->agregar_llaves_totales('Matriculados_Transferencia_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Transferencia_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Transferencia_1_semestre');
$informe->agregar_llaves_totales('Matriculados_Reintegro','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Reintegro',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Reintegro');
$informe->agregar_llaves_totales('Matriculados_Reintegro_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Matriculados_Reintegro_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Matriculados_Reintegro_1_semestre');
$informe->agregar_llaves_totales('Total_Matriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Total_Matriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Total_Matriculados');
$informe->agregar_llaves_totales('Total_Matriculados_1_semestre','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_Total_Matriculados_1_semestre',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','Total_Matriculados_1_semestre');
$informe->agregar_llaves_totales('a_seguir_Prematriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_a_seguir_Prematriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','a_seguir_Prematriculados');
$informe->agregar_llaves_totales('a_seguir_No_prematriculados','tabla_estadisticas_matriculas.php','estadisticas_matriculas_detalle.php','subtotal_a_seguir_No_prematriculados',"codigoperiodo=".$_SESSION['codigoperiodo_reporte']."",'codigocarrera','','a_seguir_No_prematriculados');
$informe->mostrar();
?>
<?php
$matriz=$_SESSION['array_estadisticas'];
$array_combo_columnas=array_keys($matriz[0]);
function DatosColumnaParaEstadisticas($columna_nombres,$columna_valores,$matriz)
{
	unset($_SESSION['datos_pie']);
	for ($i=0;$i<count($matriz);$i++)
	{
		$array_datos_pie[$i]=array('etiquetas'=>$array_etiquetas_pie[$i]=$matriz[$i][$columna_nombres],'valores'=>$matriz[$i][$columna_valores]);
	}
	$_SESSION['datos_pie']=$array_datos_pie;
}
?>
<form name="form2" method="get" action="">
<input name="Grafico" type="submit" id="Grafico" value="Grafico">
<select name="columna" id="columna">
<option value="">Seleccionar</option>
<?php foreach ($array_combo_columnas as $llave => $valor)
{ ?>
	<option value="<?php echo $valor?>"><?php echo $valor?></option>
<? } ?>
</select>

<?php
if($_GET['columna']<>"")
{
	DatosColumnaParaEstadisticas('Programa',$_GET['columna'],$matriz);


?>
	<script language="javascript">window.open('pie_estadisticas_matriculas.php?datos_pie=<?php echo $datos_pie;?>&etiquetas_pie=<?php echo $datos_etiquetas_pie?>&columna=<?php echo $_GET['columna']?>')</script>
<? } ?>
</form>