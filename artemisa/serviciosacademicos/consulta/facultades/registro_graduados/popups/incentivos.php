<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//$_SESSION['MM_Username']='dirsecgeneral';
//print_r($_SESSION);
$rutaado=("../../../../funciones/adodb/");
require_once("../../../../funciones/clases/debug/SADebug.php");
require_once("../../../../Connections/salaado-pear.php");
require_once("../../../../funciones/clases/formulario/clase_formulario.php");
require_once("../funciones/obtener_datos.php");

?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript" src="../../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
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

<?php //funcion que recarga cuando se digitan firmas
echo '<script language="Javascript">
function recargar() 
{
	window.location.reload("incentivos.php?documento=incentivo&idregistrograduado='.$_GET['idregistrograduado'].'&codigoestudiante='.$_GET['codigoestudiante'].'")
}
</script>';
?>
<?php
$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulario($sala,'form1','post','','true');
$ip=$formulario->GetIP();
$depurar=new SADebug();
if($_REQUEST['depurar']=="si")
{
	$depurar->trace($formulario,'','');
	$formulario->depurar();
}
$formulario->agregar_tablas('registroincentivoacademico','idregistroincentivoacademico');
if($_SESSION['MM_Username']!="")
{
	$iddirectivo=$formulario->datos_directivo();
}
else
{
	echo "<h1>Sesion perdida</h1>";
	exit();
}
//carga el formulario
if(isset($_GET['idregistrograduado']) and $_GET['idregistrograduado']!="")
{
	$formulario->limites_flechas_tabla_padre_hijo('registrograduado','registroincentivoacademico','idregistrograduado','idregistroincentivoacademico',$_GET['idregistrograduado'],"registroincentivoacademico.codigoestado in ('100','200')");
	$maximo=count($_SESSION['array_flechas_tabla_padre_hijo']);
	//carga las tablas de manera distintiva, porque hay varios seguimientos

	if($maximo >0)
	{
		$formulario->iterar_flechas_tabla_padre_hijo('idregistrograduado',null);
		if(!isset($_REQUEST['nuevo']))
		{
			$carga=$formulario->cargar_distintivo_condicional('registroincentivoacademico','idregistroincentivoacademico',$_SESSION['contador_flechas'],"codigoestado in (100,200)","idregistrograduado",$_GET['idregistrograduado']);
		}
		$formulario->cambiar_estado('registroincentivoacademico','codigoestado',200,"<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>'");
		$idregistroincentivoacademico=$formulario->array_datos_cargados['registroincentivoacademico']->idregistroincentivoacademico;
	}
}
else
{
	echo "<h1>No hay codigoestudiante</h1>";
	exit();
}
$usuario=$formulario->datos_usuario();
if($carga==true)//carga variable para enviar al popup de las firmas, y datos para mostrar en pantalla
{
	$idregistrograduado=$formulario->array_datos_cargados['registrograduado']->idregistrograduado;
	$datos_varios=new datos_registro_graduados($sala);
	$array_firmas_incentivos=$datos_varios->muestra_firmas_incentivos_idregistroincentivoacademico($idregistroincentivoacademico);

}
?>
<a href="../../../../aspirantes/aspirantes.php" onClick="quitarFrame()" id="aparencialinknaranja">inicio</a>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="550">
	<caption align="left"><p>
    Datos para registro de incentivos</p></caption>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombreregistroincentivoacademico','Descripción incentivo','requerido');?></td>
		<td><?php $formulario->campotexto('nombreregistroincentivoacademico','registroincentivoacademico',30,'requerido','','','');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('idincentivoacademico','Tipo de Incentivo','requerido');?></td>
		<td><?php $formulario->combo('idincentivoacademico','registroincentivoacademico','post','incentivoacademico','idincentivoacademico','nombreincentivoacademico',"codigoestado=100",'nombreincentivoacademico');?></td>
	</tr>
    
    <tr>
    <td width="250" id="tdtitulogris"><?php $formulario->etiqueta('numeroacuerdoregistroincentivoacademico','Número de acuerdo','requerido');?></td>
		<td width="350"><?php $formulario->campotexto('numeroacuerdoregistroincentivoacademico','registroincentivoacademico',10);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechaacuerdoregistroincentivoacademico','Fecha de acuerdo','fecha');?></td>
		<td><?php $formulario->calendario('fechaacuerdoregistroincentivoacademico','registroincentivoacademico',8,'','','',''); ?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('numeroactaregistroincentivoacademico','Número de acta','requerido');?></td>
		<td><?php $formulario->campotexto('numeroactaregistroincentivoacademico','registroincentivoacademico',8);?>
		</td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('fechaactaregistroincentivoacademico','Fecha acta','fecha');?></td>
		<td><?php $formulario->calendario('fechaactaregistroincentivoacademico','registroincentivoacademico',8);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('observacionregistroincentivoacademico','Observación','');?></td>
		<td><?php $formulario->memo('observacionregistroincentivoacademico','registroincentivoacademico',35,6,'');?></td>
	</tr>
	<tr>
		<td colspan="2"><p>Firmas registradas:&nbsp;</p></td>
	</tr>
	<tr>
		<td colspan="2" align="center"><?php 
		if($carga==true)//Si hay registro, entonces, se pueden colocar las firmas. Antes NO
		{
			$formulario->boton_ventana_emergente('Registrar_Firmas','firmas.php','idregistrograduado='.$_GET['idregistrograduado'].'&documento=incentivo&idregistroincentivoacademico='.$idregistroincentivoacademico.'&idincentivoacademico='.$formulario->array_datos_cargados['registroincentivoacademico']->idincentivoacademico.'',600,450,50,150,'yes','yes','yes','yes');
		}
		?></td>
	</tr>
	<tr>
		<td id="tdtitulogris">Incentivos académicos</td>
		<td><?php 
		if(is_array($array_firmas_incentivos))
		{
			foreach ($array_firmas_incentivos as $llave=>$valor)
			{
				echo $valor['nombre'],"<br>";
			}
		}
		?>
		</td>
	</tr>
	<tr>
		<td id="tdtitulogris">Recorrer incentivos registrados</td>
		<td align="left"><?php $formulario->mostrar_flechas_tabla_padre_hijo();?></td>
	</tr>
</table>
<br>
<input type="submit" name="Enviar" value="Enviar">
</form>
<?php 
if($carga==true)
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
<?php
if(isset($_REQUEST['Enviar']))
{
	$formulario->submitir();
	$formulario->agregar_datos_formulario('registroincentivoacademico','idregistrograduado',$_GET['idregistrograduado']);
	$formulario->agregar_datos_formulario('registroincentivoacademico','fecharegistroincentivoacademico',$fechahoy);
	$formulario->agregar_datos_formulario('registroincentivoacademico','codigoestado',100);
	$formulario->agregar_datos_formulario('registroincentivoacademico','idusuario',$usuario['idusuario']);
	$formulario->valida_formulario();
	$ids=$formulario->insertar("<script language='javascript'>window.close();</script>'<script language='javascript'>window.opener.recargar();</script>'","<script language='javascript'>window.close();</script>'<script language='javascript'>window.opener.recargar();</script>'");
}
?>

<?php
if($_REQUEST['depurar']=="si")
{
	$depurar2=new SADebug();
	$depurar2->trace($formulario,'','');
	$formulario->depurar();
}
?>
