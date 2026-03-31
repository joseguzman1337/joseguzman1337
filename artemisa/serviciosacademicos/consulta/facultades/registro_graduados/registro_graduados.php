<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
if (empty($_SESSION['MM_Username']))
{
	echo "<h1>Usted no está autorizado para ver esta página</h1>";
	exit();
}

$rutaado=("../../../funciones/adodb/");
require_once("../../../funciones/clases/debug/SADebug.php");
require_once("../../../Connections/salaado-pear.php");
require_once("../../../funciones/clases/formulario/clase_formulario.php");
require_once("carta_egresados/funciones/validaciones.php");
require_once("funciones/obtener_datos.php");
$start1 = microtime(true);
?>
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
<link rel="stylesheet" type="text/css" href="../../../estilos/sala.css">
<script type="text/javascript" src="../../../funciones/javascript/funciones_javascript.js"></script>
<style type="text/css">@import url(../../../funciones/calendario_nuevo/calendar-win2k-1.css);</style>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-es.js"></script>
<script type="text/javascript" src="../../../funciones/calendario_nuevo/calendar-setup.js"></script><script type="text/javascript" src="../../../funciones/clases/formulario/globo.js"></script>
<?php //funcion que recarga cuando se digitan firmas
echo '<script language="Javascript">
function recargar() 
{
	window.location.reload("../registro_graduados.php?codigoestudiante='.$_GET['codigoestudiante'].'")
}
</script>';
	?>
<?php

$fechahoy=date("Y-m-d H:i:s");
$formulario=new formulario($sala,'form1','post','','true');
$periodo=$formulario->carga_periodo(1);
$ip=$formulario->GetIP();
$depurar=new SADebug();
if($_REQUEST['depurar']=="si")
{
	$debug=true;
	$depurar->trace($formulario,'','');
	$formulario->depurar();
}
$formulario->agregar_tablas('registrograduado','idregistrograduado',null,false);

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
if(isset($_GET['codigoestudiante']) and $_GET['codigoestudiante']!="")
{
	$array_datos_estudiante=$formulario->datos_estudiante_noprematricula($_GET['codigoestudiante']);
	$carga=$formulario->cargar_distintivo_condicional('registrograduado','codigoestudiante',$_GET['codigoestudiante'],"codigoestado=100");
	$formulario->cambiar_estado('registrograduado','codigoestado',200,"<script language='javascript'>window.location.reload('registro_graduados.php?codigoestudiante=".$_GET['codigoestudiante']."')</script>");
}
else
{
	echo "<h1>No hay codigoestudiante</h1>";
	exit();
}
$validaciones=new validaciones_requeridas($sala,$_GET['codigoestudiante'],$periodo,$debug);
$valido=$validaciones->verifica_validaciones();
$array_validaciones=$validaciones->retorna_array_validaciones();
if(!is_array($array_validaciones[0]))
{
	echo '<script language="javascript">alert("No se han parametrizado las tablas de validaciones(pazysalvoegresado, detallepazysalvoegresado para la carrera del estudiante)")</script>';
	echo '<script language="javascript">alert("Favor comunicarse con Dirección de Tecnología")</script>';
}
$array_documentos_pendientes=$validaciones->retorna_array_documentos_pendientes();
$array_materias_pendientes=$validaciones->retorna_array_materias_pendientes();
$array_materias_actuales=$validaciones->retorna_array_materias_actuales();
$start = microtime(true);
$array_pazysalvos_pendientes=$validaciones->retorna_array_pazysalvos_pendientes();
$time_elapsed1 = microtime(true) - $start;
$start = microtime(true);
$valor_pago_derechos_grado=$validaciones->retorna_valor_pago_derechos_grado();
$time_elapsed2 = microtime(true) - $start;
$start = microtime(true);
$array_deudas_sap=$validaciones->retorna_array_deudas_sap();
$time_elapsed3 = microtime(true) - $start;
if($carga==true)//carga variable para enviar al popup de las firmas, y datos para mostrar en pantalla
{
	$idregistrograduado=$formulario->array_datos_cargados['registrograduado']->idregistrograduado;
	$datos_varios=new datos_registro_graduados($sala);
	$array_incentivos=$datos_varios->muestra_incentivos($formulario->array_datos_cargados['registrograduado']->idregistrograduado);
	$array_firmas_acta=$datos_varios->muestra_firma_documento($formulario->array_datos_cargados['registrograduado']->idregistrograduado,2);
	$array_firmas_diploma=$datos_varios->muestra_firma_documento($formulario->array_datos_cargados['registrograduado']->idregistrograduado,1);
	$autorizadosino=$formulario->array_datos_cargados['registrograduado']->codigoautorizacionregistrograduado;
}

?>

<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="600">
	<caption align="left"><p>
	Datos para registro de grados</p></caption>
	<?php if(isset($idregistrograduado)){ ?>
	<tr>
	<td id="tdtitulogris"><label id="labelresaltado">Número de registro</label></td>
	<td><?php echo $idregistrograduado?></td>
	</tr>
	<?php }?>
	<tr>
	<td id="tdtitulogris"><label id="labelresaltado">Carrera estudiante</label></td>
	<td><?php echo $array_datos_estudiante['nombrecarrera']?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><label id="labelresaltado">Estudiante</label></td>
	<td><?php echo $array_datos_estudiante['nombre']?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><label id="labelresaltado">Género</label></td>
        <!--        
         * Se corrige el dato nombre por genero
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Modificado 25 de Agosto de 2017.
         -->
	<td><?php echo $array_datos_estudiante['genero'] ?></td>
        <!--end-->
	</tr>
	<tr>
	<td width="250" id="tdtitulogris"><?php $formulario->etiqueta('numeroacuerdoregistrograduado','Número de acuerdo','requerido');?></td>
	<td width="350"><?php $formulario->campotexto('numeroacuerdoregistrograduado','registrograduado',10);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('fechaacuerdoregistrograduado','Fecha de acuerdo','fecha');?></td>
	<td><?php $formulario->calendario('fechaacuerdoregistrograduado','registrograduado',10,'','','',''); ?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('responsableacuerdoregistrograduado','Responsable acuerdo','requerido');?></td>
	<td><?php $formulario->campotexto('responsableacuerdoregistrograduado','registrograduado',30);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('numeroactaregistrograduado','Número de acta','requerido');?></td>
	<td><?php $formulario->campotexto('numeroactaregistrograduado','registrograduado',8);
	if($carga==true)//Si hay registro, entonces, se pueden colocar las firmas. Antes NO
	{
		$formulario->boton_ventana_emergente('Firmas','popups/firmas.php','codigoestudiante='.$_GET['codigoestudiante'].'&documento=acta&idregistrograduado='.$idregistrograduado.'',300,400,50,150,'yes','yes','yes','yes');
	}
	?>
	</td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('fechaactaregistrograduado','Fecha acta','fecha');?></td>
	<td><?php $formulario->calendario('fechaactaregistrograduado','registrograduado',10);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('numerodiplomaregistrograduado','Número diploma','requerido');?></td>
	<td><?php $formulario->campotexto('numerodiplomaregistrograduado','registrograduado',8);
	if($carga==true)//Si hay registro, entonces, se pueden colocar las firmas. Antes NO
	{
		$formulario->boton_ventana_emergente('Firmas','popups/firmas.php','codigoestudiante='.$_GET['codigoestudiante'].'&documento=diploma&idregistrograduado='.$idregistrograduado.'',300,400,50,150,'yes','yes','yes','yes');
	}
	?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('fechadiplomaregistrograduado','Fecha diploma','requerido');?></td>
	<td><?php $formulario->calendario('fechadiplomaregistrograduado','registrograduado',10);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('fechagradoregistrograduado','Fecha grado','requerido');?></td>
	<td><?php $formulario->calendario('fechagradoregistrograduado','registrograduado',10);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('lugarregistrograduado','Sitio de graduación','');?></td>
	<td><?php $formulario->campotexto('lugarregistrograduado','registrograduado',30);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('presidioregistrograduado','Presidió registro','');?></td>
	<td><?php $formulario->campotexto('presidioregistrograduado','registrograduado',30);?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('observacionregistrograduado','Observación','');?></td>
	<td><?php $formulario->memo('observacionregistrograduado','registrograduado',50,6,'');?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('codigotiporegistrograduado','Modalidad de graduación','requerido');?></td>
	<td><?php $formulario->combo('codigotiporegistrograduado','registrograduado','post','tiporegistrograduado','codigotiporegistrograduado','nombretiporegistrograduado','','nombretiporegistrograduado','','','','');?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('idtipogrado','Tipo de graduación','requerido');?></td>
	<td><?php $formulario->combo('idtipogrado','registrograduado','post','tipogrado','idtipogrado','nombretipogrado','','nombretipogrado');?></td>
	</tr>
	<tr>
	<td id="tdtitulogris"><?php $formulario->etiqueta('numeropromocion','Número de promoción','requerido');?></td>
	<td><?php $formulario->campotexto('numeropromocion','registrograduado',8);?></td>
	</tr>
	<?php if($carga==true){ ?>
	<tr>
	<td colspan="2"><p>Documentos registrados:&nbsp;</p></td>
	</tr>
	<tr>
	<td colspan="2" align="center">
	<?php
	$formulario->boton_ventana_emergente('Registrar_Incentivos','popups/incentivos.php','codigoestudiante='.$_GET['codigoestudiante'].'&documento=incentivo&idregistrograduado='.$idregistrograduado.'',600,450,50,150,'yes','yes','yes','yes');
	?></td>
	</tr>
	<tr>
	<td id="tdtitulogris">Incentivos académicos</td>
	<td><?php
	if(is_array($array_incentivos))
	{
		foreach ($array_incentivos as $llave=>$valor)
		{
                    if($valor['codigoestado']==100){
                        echo $valor['nombreincentivoacademico'],"<br>";
                    }
                    else{
                        echo "***REGISTRO ANULADO***<br>";
                    }
		}
	}?>
	</td>
	</tr>
	<tr>
	<td id="tdtitulogris">Funcionario(s) Firmas Acta</td>
	<td><?php
	if(is_array($array_firmas_acta))
	{
		foreach ($array_firmas_acta as $llave => $valor)
		{
			echo $valor['nombre'],"<br>";
		}
	}
	?>
	</td>
	</tr>
	<tr>
	<td id="tdtitulogris">Funcionario(s) Firmas Diploma</td>
	<td><?php
	if(is_array($array_firmas_diploma))
	{
		foreach ($array_firmas_diploma as $llave => $valor)
		{
			echo $valor['nombre'],"<br>";
		}
	}
	?>
	</td>
	</tr>
	<?php }?>
	<tr>
	<td id="tdtitulogris">Estado Registro de grado</td>
	<td>
	<a name="chulos"></a>
	<?php if($autorizadosino==100)
	{
		if(is_array($array_firmas_diploma) and is_array($array_firmas_acta))
		{
			echo '<img src="imagenes/estado_verde.gif" width="10" height="10">'," Autorizado y firmas OK";
		}
		else
		{
			echo '<img src="imagenes/estado_amarillo.gif" width="10" height="10">'," Autorizado sin firmas de diploma y/o acta";
		}
	}
	else
	{
		echo '<img src="imagenes/estado_rojo.gif" width="10" height="10">', " No autorizado";
	}
	?>
	</td>
	</tr>
	<tr>
	<td id="tdtitulogris">Cumplimiento de requisitos</td>
	<td>
	<?php 
	foreach ($array_validaciones as $llave => $valor)
	{
		if($valor['requerido']==true)
		{
			if($valor['valido']==true)
			{
				echo '<img src="imagenes/estado_verde.gif" width="10" height="10">';
			}
			else
			{
				echo '<img src="imagenes/estado_rojo.gif" width="10" height="10">';
			}
			echo " ".$valor['validacion'],"<br>";
		}
	}
	$time_elapsed4 = microtime(true) - $start1;
	echo "Tiempo ejecución paz y salvos".number_format($time_elapsed1,12)."<br/>";
	echo "Tiempo ejecución pago derechos".number_format($time_elapsed2,12)."<br/>";
	echo "Tiempo ejecución estado cuenta".number_format($time_elapsed3,12)."<br/>"; 
	echo "Proceso completo ".number_format($time_elapsed4,12)."<br/>"; 
	?>
	</td>
	</tr>
	</table>
	<br>
	<input type="submit" name="Enviar" value="Enviar">
	<?php if(isset($_GET['link_origen']) and $_GET['link_origen']<>""){ ?>
		<input type="button" name="Regresar" value="Regresar" onclick="reCarga('<?php echo $_GET['link_origen']?>')">
	<?php } ?>

	<?php if($carga==true){ ?>
	<input type="button" name="Anular" value="Anular" onclick="Verificacion()">
	<?php }?>
	<?php

	if(isset($_REQUEST['Enviar']))
	{
		$formulario->submitir();
		$validacion=$formulario->valida_formulario();
		if($validacion==true)
		{
			if($carga==false)
			{
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'direccionipregistrograduado','valor'=>$ip);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'codigoestudiante','valor'=>$_GET['codigoestudiante']);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'fecharegistrograduado','valor'=>$fechahoy);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'codigoestado','valor'=>100);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'usuario','valor'=>$_SESSION['MM_Username']);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'codigoestudiante','valor'=>$_GET['codigoestudiante']);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'iddirectivo','valor'=>$iddirectivo['iddirectivo']);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'codigoautorizacionregistrograduado','valor'=>200);
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'fechaautorizacionregistrograduado','valor'=>'0000-00-00');
				$formulario->array_datos_formulario[]=array('tabla'=>'registrograduado','campo'=>'codigotipomodificaregistrograduado','valor'=>100);
			}
			$ids=$formulario->insertar("<script language='javascript'>reCarga('registro_graduados.php?codigoestudiante=".$_GET['codigoestudiante']."&link_origen=".$_GET['link_origen']."')</script>","<script language='javascript'>reCarga('registro_graduados.php?codigoestudiante=".$_GET['codigoestudiante']."&link_origen=".$_GET['link_origen']."')</script>");
		}
	}
	?>
	</form>
	<?php
	if($_REQUEST['depurar']=="si")
	{
		$depurar2=new SADebug();
		$depurar2->trace($formulario,'','');
		$formulario->depurar();
	}
	?>
<?php
if(!isset($_GET['novalida']))
{
	if($carga==false)
	{
		$validaciones_ok=true;
		if(is_array($array_validaciones))
		{
			foreach ($array_validaciones as $llave => $valor)
			{
				if($valor['requerido']==true)
				{
					if($valor['valido']==false)
					{
						$validaciones_ok=false;
					}
				}
			}

			if($validaciones_ok==false)
			{
				if (!isset($_GET['recargado']))
				{
					echo '<script language="javascript">alert("Estudiante no cumple con las validaciones requeridas por la facultad, no podrá ingresar los datos de grado hasta cumplir todas las validaciones")</script>';
					$recargado="&recargado";
					$ancla="#chulos";
					echo '<meta http-equiv="REFRESH" content="0;URL='.$REQUEST_URI.$recargado.$ancla.'" />';
				}
				else
				{
					echo '<meta http-equiv="REFRESH" content="4;URL=carta_egresados/carta_egresados.php?codigoestudiante='.$_GET['codigoestudiante'].'&link_origen=../registro_graduados.php?codigoestudiante='.$_GET['codigoestudiante'].'" />';
				}
			}
		}
	}
}
?>
