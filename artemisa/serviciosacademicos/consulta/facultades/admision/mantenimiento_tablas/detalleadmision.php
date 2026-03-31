<?php
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

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
<script language="Javascript">
function recargar()
{
	window.location.reload("detalleadmision_listado.php");
}
</script>
<?php
    $rutaado=("../../../../funciones/adodb/");
    require_once('../../../../Connections/salaado-pear.php');
    require_once('../../../../funciones/clases/formulario/clase_formulario.php');
    require_once('../../../../funciones/clases/debug/SADebug.php');
    $fechahoy=date("Y-m-d H:i:s");
    //$_GET['idadmision'];
?>

<form name="form1" action="" method="POST">
<input type="hidden" name="AnularOK" value="">
<?php
$formulario = new formulario($sala,'form1','post','',true);
//definicion de tablas con las que el formulario trabajará
$formulario->agregar_tablas('detalleadmision','iddetalleadmision');
if($_REQUEST['depurar']=="si")
{
	$depurar=new SADebug();
	$depurar->trace($formulario,'','');
	$formulario->depurar();
	$debug=true;
}
if($_GET['iddetalleadmision']<>"")
{
	$formulario->cargar('idddetalleadmision',$_GET['iddetalleadmision']);
	$formulario->cambiar_estado('detalleadmision','codigoestado',200,"<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");
}
?>
<caption align="left"><p>Edición de pruebas</p></caption>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" width="640">
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('nombredetalleadmision','Nombre prueba','requerido');?></td>
		<td><?php $formulario->campotexto('nombredetalleadmision','detalleadmision',40);?></td>
	</tr>	
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('numeroprioridaddetalleadmision','Numero prioridad','numero');?></td>
		<td><?php $formulario->campotexto('numeroprioridaddetalleadmision','detalleadmision',5);?></td>
	</tr>	
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('porcentajedetalleadmision','Porcentaje prueba','numero'); ?></td>
		<td><?php $formulario->campotexto('porcentajedetalleadmision','detalleadmision',5);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('totalpreguntasdetalleadmision','Total preguntas','numero');?></td>
		<td><?php $formulario->campotexto('totalpreguntasdetalleadmision','detalleadmision',5);?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigotipodetalleadmision','Tipo prueba','requerido');?></td>
		<td><?php $formulario->combo('codigotipodetalleadmision','detalleadmision','post','tipodetalleadmision','codigotipodetalleadmision','nombretipodetalleadmision','','nombretipodetalleadmision');?></td>
	</tr>
	<tr>
		<td id="tdtitulogris"><?php $formulario->etiqueta('codigorequierepreselecciondetalleadmision','Requiere preselección','requerido');?></td>
		<td><?php $formulario->combo('codigorequierepreselecciondetalleadmision','detalleadmision','post','requierepreselecciondetalleadmision','codigorequierepreselecciondetalleadmision','nombrerequierepreselecciondetalleadmision','','nombrerequierepreselecciondetalleadmision');?></td>
	</tr>
</table>
	
<input type="submit" name="Enviar" value="Enviar">
<!--<input type="button" name="Regresar" value="Regresar" onClick="regresarGET()">-->
<?php
if($_GET['iddetalleadmision']<>"") //si hay admision, deberá cargar y mostrar boton verificacion
{
	echo '<input type="button" name="Anular" value="Anular" onclick="Verificacion()">';
}
?>
</form>
<?php
//Lógica del formulario
if(isset($_REQUEST['Enviar']))
{
    if(isset($_GET['idadmision'])&& 
           trim($_GET['idadmision'])!='' ){
	$formulario->submitir();
	$formulario->valida_formulario();
	$formulario->agregar_datos_formulario('detalleadmision','codigoestado',100);
	$formulario->agregar_datos_formulario('detalleadmision','idadmision',$_GET['idadmision']);
	$formulario->insertar("<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>","<script language='javascript'>window.close();</script><script language='javascript'>window.opener.recargar();</script>");
    }
    else{
        echo "
            <script language='javascript'>
            alert('No se identifica ningun registro de admision , si es necesario crearlo vaya la opción Administracion de admisiones');
            </script>";
    }
}
?>	
	<!--<a href="detalleadmisionlistado_listado.php?link_origen=detalleadmision_listado&idadmision=<?php echo $_SESSION['idadmision']?>&iddetalleadmision=<?php echo $_GET['iddetalleadmision'] ?>">Detalle de resultados de pruebas </a><br>-->
