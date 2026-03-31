<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
session_start();
require_once('../../../../funciones/clases/autenticacion/redirect.php' ); 
//ini_set('memory_limit', '64M');
//ini_set('max_execution_time','90');
?>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
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
<script LANGUAGE="JavaScript">
function quitarFrame()
{
	if (self.parent.frames.length != 0)
	self.parent.location=document.location.href="../../../../aspirantes/aspirantes.php";

}
function regresarGET()
{
	document.location.href="<?php echo $_GET['link_origen']?>";
}
function Verificacion()
{
	if(confirm('Seleccionó anular el registro. ¿Desea continuar?'))
	{
		document.form1.AnularOK.value="OK";
		document.form1.submit();
	}
}
</script>

<?php
$rutaado=("../../../../funciones/adodb/");
require_once('../../../../Connections/salaado-pear.php');
require_once('../../../../funciones/clases/formulario/clase_formulario.php');
require_once('../../../../funciones/clases/debug/SADebug.php');
$fechahoy=date("Y-m-d H:i:s");
?>
<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<?php
$formulario = new formulario($sala,'form1','post','',true);

if($_REQUEST['depurar']=="si")
{
	$sala->debug=true;
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}

if($_GET['idadmision']<>"")
{
	//simula una carga de datos de la tabla papa de los chulitos, para poder decidir si carga=false (datos nuevos) o carga=true (datos viejos)
	$query_cuenta_detalle="SELECT COUNT(iddetallesitioadmision) as cant FROM detallesitioadmision
	WHERE
	idadmision='".$_GET['idadmision']."'
	AND
	codigoestado='100'
	";
	$operacion=$sala->query($query_cuenta_detalle);
	$row_operacion=$operacion->fetchRow();
	
	//engaño a objeto formulario para que instancie los chulitos, pero con carga=false
	//echo "<h1>".$row_operacion['cant']."</h1>";
	if($row_operacion['cant']==0)
	{	
		$formulario->agregar_tablas('admision','idadmision');
		//$formulario->cargar('idadmision',$_GET['idadmision']);
		$formulario->carga=false;
	}
	elseif($row_operacion['cant']>0)
	{
		//engaño a objeto formulario para que instancie los chulitos, pero con carga=true
		$formulario->agregar_tablas('admision','idadmision');
		$formulario->cargar('idadmision',$_GET['idadmision']);
		$formulario->carga=true;
	}
}

?>
<caption align="left"><p>Selección de Salones asignados a sitio de admisión</p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigosede','Sede','');?></td>
		<td><?php $formulario->combo('codigosede','','post','sede','codigosede','nombresede','','nombresede','OnChange=enviar()');?></td>
	</tr>
</table>
<br>
<?php
if(isset($_POST['codigosede']) and $_POST['codigosede']<>"")
{
	$formulario->cuadro_chulitos_bd('Seleccione Salones','salon',"codigosede='".$_POST['codigosede']."'",'codigosalon','codigosalon','codigosalon','detallesitioadmision','iddetallesitioadmision','codigoestado',100,200,10);
}
else
{
	$formulario->cuadro_chulitos_bd('Seleccione Salones','salon',"",'codigosalon','codigosalon','codigosalon','detallesitioadmision','iddetallesitioadmision','codigoestado',100,200,10);
}
?>
<input type="submit" name="Enviar" value="Enviar">
<input type="button" name="Regresar" value="Regresar" onClick="window.close()">
<?php
if($_GET['iddetallesitioadmision']<>"") //si hay admision, deberá cargar y mostrar boton verificacion
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>

<?php
//Lógica del formulario
if(isset($_REQUEST['Enviar']))
{
	$formulario->submitir();
	$formulario->valida_formulario();
	$formulario->insertar();

	$datos_sql_detallesitioadmision[]=array('campo'=>'idadmision','valor'=>$_GET['idadmision']);
	$datos_sql_detallesitioadmision[]=array('campo'=>'codigoestado','valor'=>100);
	$formulario->sql_cuadro_chulitos_bd($datos_sql_detallesitioadmision,'detallesitioadmision','codigosalon','codigoestado',100,200,1,"<script language='javascript'>window.location.reload('$REQUEST_URI');</script>","<script language='javascript'>window.location.reload('$REQUEST_URI');</script>",true);
}
?>