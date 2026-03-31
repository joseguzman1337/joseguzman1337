<?php
session_start();
//print_r($_SESSION);
$rutaado=("../../../funciones/adodb/");
require_once('../../../funciones/clases/autenticacion/redirect.php');
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once('../../../Connections/sap_ado_pear.php');
require_once('funciones/datos_sap.php');
?>
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<script language="javascript">
function Verificacion()
{
	if(confirm('La autorización de grado no es reversible. ¿Desea continuar?'))
	{
		document.form1.AnularOK.value="OK";
		document.form1.submit();
	}
}
</script>

<?php
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulario($sala,'form1','post','','true');
$formulario->agregar_tablas('carrera','codigocarrera');
$formulario->agregar_tablas('jornadacarrera','idjornadacarrera');

if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
$array_combo_centrobeneficio=valida_centrobeneficio($rfc);
$query_directivo="SELECT iddirectivo,concat(apellidosdirectivo,' ',nombresdirectivo) as nombre FROM directivo order by apellidosdirectivo";
$directivo=$sala->query($query_directivo);
$row_directivo=$directivo->fetchRow();
do
{
	$array_directivo[]=$row_directivo;
}
while($row_directivo=$directivo->fetchRow());
$contador_array=0;
if(isset($_GET['codigocarrera']) and $_GET['codigocarrera']!="")
{
	$formulario->cargar_distintivo('carrera','codigocarrera',$_GET['codigocarrera']);
	$formulario->limites_flechas_tabla_padre_hijo('carrera','jornadacarrera','codigocarrera','idjornadacarrera',$_GET['codigocarrera']);
	$maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
	if($maximo > 0 )
	{
		$formulario->iterar_flechas_tabla_padre_hijo('idjornadacarrera',null);
		$carga=$formulario->cargar_distintivo('jornadacarrera','idjornadacarrera',$_SESSION['contador_flechas'],'','');
		if($carga==false)
		{
			$carga=$formulario->cargar_distintivo_nocarga('jornadacarrera','idjornadacarrera',$_SESSION['contador_flechas'],'','');
		}
		$formulario->cambiar_estado('carrera','fechavencimientocarrera','0000-00-00',"<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
		$formulario->resetear_objeto_para_asignar_nuevo_flechas('jornadacarrera',$carga);
	}



}
?>
<form name="form1" method="POST" action="">
<p>MANTENIMIENTO - CARRERAS</p>
<input type="hidden" name="AnularOK" value="">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td colspan="2"><div align="center"><p>Datos carrera</p></div></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigomodalidadacademica','Modalidad académica','requerido');?></td>
		<td><?php $formulario->combo('codigomodalidadacademica','carrera','post','modalidadacademica','codigomodalidadacademica','nombremodalidadacademica',"","nombremodalidadacademica asc","onChange='document.form1.submit()'","","Modalidad académica","Modalidad académica")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigofacultad','Facultad','requerido')?></td>
		<td><?php $formulario->combo('codigofacultad','carrera','post','facultad','codigofacultad','nombrefacultad',"","nombrefacultad","submit","","Facultad","Facultad a la que pertenece la carrera")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigotipocosto','Tipo de costo','requerido');?></td>
		<td><?php $formulario->combo('codigotipocosto','carrera','post','tipocosto','codigotipocosto','nombretipocosto',"codigoestado=100","nombretipocosto asc","onChange='document.form1.submit()'","requerido","Tipo de costo","Tipo de costo")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php if($_REQUEST['codigotipocosto']==100)
		{
			$formulario->etiqueta('codigocentrobeneficio','Centro de beneficio','requerido');
			?><td><?php $formulario->combo_array('codigocentrobeneficio','carrera','post',$array_combo_centrobeneficio,'valor','etiqueta',"","","Centro de beneficio","Centro de beneficio proveniente de SAP")?></td><?php
		}
		else
		{
			//$formulario->etiqueta('codigocentrobeneficio','Centro de beneficio','');
		}
		?></td>
		
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('iddirectivo','Directivo','requerido')?></td>
		<td><?php $formulario->combo_array('iddirectivo','carrera','post',$array_directivo,'iddirectivo','nombre',"","","","Director de la carrera")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigotitulo','Titulo','requerido');?></td>
		<td><?php $formulario->combo('codigotitulo','carrera','post','titulo','codigotitulo','nombretitulo',"","nombretitulo asc","","","","Titulo que se obtiene")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigosucursal','Sucursal','requerido');?></td>
		<td><?php $formulario->combo('codigosucursal','carrera','post','sucursal','codigosucursal','nombresucursal',"","nombresucursal asc","","","","Sucursal")?>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoindicadorcobroinscripcioncarrera','Indicador cobro inscripción','requerido')?></td>
		<td><?php $formulario->combo('codigoindicadorcobroinscripcioncarrera','carrera','post','indicadorcobroinscripcioncarrera','codigoindicadorcobroinscripcioncarrera','nombreindicadorcobroinscripcioncarrera',"","nombreindicadorcobroinscripcioncarrera","","","","Indicador de cobro de inscripción")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoindicadorprocesoadmisioncarrera','Indicador proceso de admisión','requerido')?></td>
		<td><?php $formulario->combo('codigoindicadorprocesoadmisioncarrera','carrera','post','indicadorprocesoadmicioncarrera','codigoindicadorprocesoadmisioncarrera','nombreindicadorprocesoadmisioncarrera',"","nombreindicadorprocesoadmisioncarrera","","","","Indicador de proceso de admisión")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoindicadorplanestudio','Indicador de plan de estudio','requerido')?></td>
		<td><?php $formulario->combo('codigoindicadorplanestudio','carrera','post','indicadorplanestudio','codigoindicadorplanestudio','nombreindicadorplanestudio',"","nombreindicadorplanestudio","","","","Indicador de si aplica plan de estudio o no")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoindicadortipocarrera','Indicador tipo de carrera','requerido')?></td>
		<td><?php $formulario->combo('codigoindicadortipocarrera','carrera','post','indicadortipocarrera','codigoindicadortipocarrera','nombrendicadortipocarrera',"","nombrendicadortipocarrera","","","","Indicador del tipo de carrera")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoreferenciacobromatriculacarrera','Referencia de cobro matrícula','requerido')?></td>
		<td><?php $formulario->combo('codigoreferenciacobromatriculacarrera','carrera','post','referenciacobromatriculacarrera','codigoreferenciacobromatriculacarrera','nombrereferenciacobromatriculacarrera',"","nombrereferenciacobromatriculacarrera","","","","Referencia de cobro de matrícula")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechainiciocarrera','Fecha de inicio','requerido');?></td>
		<td><?php $formulario->calendario('fechainiciocarrera','carrera','8',"","","Fecha inicio de la carrera","")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechavencimientocarrera','Fecha de vencimiento','requerido');?></td>
		<td><?php $formulario->calendario('fechavencimientocarrera','carrera','8',"","","Fecha vencimiento de la carrera","")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombrecarrera','Nombre','requerido');?></td>
		<td><?php $formulario->campotexto('nombrecarrera','carrera',30,'','Nombre de la carrera','Nombre de la carrera')?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigocortocarrera','Codigo corto','requerido');?></td>
		<td><?php $formulario->campotexto('codigocortocarrera','carrera','20','','Codigo corto de la carrera','Código corto para identificar la carrera','');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('abreviaturacodigocarrera','Abreviatura','requerido');?></td>
		<td><?php $formulario->campotexto('abreviaturacodigocarrera','carrera',10,'','','Abreviatura de la carrera');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('centrocosto','Centro de costo','requerido')?></td>
		<td><?php $formulario->campotexto('centrocosto','carrera',10,'','','Centro de costo');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('numerodiaaspirantecarrera','Numero días aspirante','numero')?></td>
		<td><?php $formulario->campotexto('numerodiaaspirantecarrera','carrera','8','','','Número de dias para ser aspirante a la carrera');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigoindicadorcarreragrupofechainscripcion','Indicador grupo','requerido');?></td>
		<td><?php $formulario->combo('codigoindicadorcarreragrupofechainscripcion','carrera','post','indicadorcarreragrupofechainscripcion','codigoindicadorcarreragrupofechainscripcion','nombreindicadorcarreragrupofechainscripcion',"codigoestado=100",'nombreindicadorcarreragrupofechainscripcion',"","","","Indicador de fecha de vencimiento para las inscripciones de la facultad"); ?></td>
	</tr>
	<tr>
	<td colspan="2"><div align="center"><p>Datos jornada carrera</p></div></td>
	</tr>
	<tr>
		<td id="tdtitulogris">Recorrer incentivos registrados</td>
		<td align="left"><?php $formulario->mostrar_flechas_tabla_padre_hijo();?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombrejornadacarrera','Nombre jornada','requerido')?></td>
		<td><?php $formulario->campotexto('nombrejornadacarrera','jornadacarrera',50,'','','Nombre de la jornada');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigojornada','Jornada','requerido');?></td>	
		<td><?php $formulario->combo('codigojornada','jornadacarrera','post','jornada','codigojornada','nombrejornada',"","nombrejornada","","","","Nombre de la jornada")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('numerominimocreditosjornadacarrera','Número mínimo de créditos','numero');?></td>
		<td><?php $formulario->campotexto('numerominimocreditosjornadacarrera','jornadacarrera',20,'','','Número mínimo de créditos para la carrera')?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('numeromaximocreditosjornadacarrera','Número maximo de créditos','numero');?></td>
		<td><?php $formulario->campotexto('numeromaximocreditosjornadacarrera','jornadacarrera',20,'','','Número mínimo de créditos para la carrera')?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechadesdejornadacarrera','Fecha inicial de la jornada','fecha')?></td>
		<td><?php $formulario->calendario('fechadesdejornadacarrera','jornadacarrera','8',"","","Fecha inicial de la jornada")?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechahastajornadacarrera','Fecha final de la jornada','fecha')?></td>
		<td><?php $formulario->calendario('fechahastajornadacarrera','jornadacarrera','8',"","","Fecha final de la jornada")?></td>
	</tr>
</table>
<input type="submit" name="Enviar" value="Enviar">
<input type="submit" name="Regresar" value="Regresar">
<?php if($carga==true)
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>
<?php
if(isset($_REQUEST['Enviar']))
{
	if($_REQUEST['codigotipocosto']<>100){
		$formulario->array_datos_formulario[]=array('tabla'=>'carrera','campo'=>'codigocentrobeneficio','valor'=>1);
	}
	$formulario->array_datos_formulario[]=array('tabla'=>'carrera','campo'=>'nombrecortocarrera','valor'=>$_REQUEST['nombrecarrera']);
	$formulario->array_datos_formulario[]=array('tabla'=>'jornadacarrera','campo'=>'fechajornadacarrera','valor'=>$fechahoy);
	$formulario->valida_formulario();
	$formulario->insertar("<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>","<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>");
}
if(isset($_REQUEST['Regresar']))
{
	echo "<script language='javascript'>window.location.reload('".$_GET['link_origen']."')</script>";
}
if($_REQUEST['depurar']=="si")
{
	$formulario->depurar();
}
?>
