<?php  
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php'); 

@@session_start();
$GLOBALS['codigoestudiantecolegio'];
$GLOBALS['codigoestudiantecolegionuevo'];
$GLOBALS['idcodigocolegioestudiante'];
$direccion = "editarestudiante.php";
?>
<form name="f1" action="" method="get">
<html>
<head>
<title>..:Institución Educativa:..</title>
</head>
<link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
<script language='javascript'>
function cambia_tipo()
{
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
	  window.location.reload('editarestudiantecolegio_new.php?busqueda=nombre');
	} 
}
</script>
<script language="javascript"> 
function buscar()
{ 
    //tomo el valor del select del tipo elegido 
    var busca 
    busca = document.f1.busqueda[document.f1.busqueda.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (busca != 0)
	{
		window.location.reload("editarestudiantecolegio_new.php?buscar="+busca); 
	} 
} 
</script>
<body>
  <p>CRITERIO DE B&Uacute;SQUEDA</p>
  <table width="70%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr>
    <td width="250"  id="tdtitulogris">Nombre de la instituci&oacute;n</td>
	<td>&nbsp;
<?php
	 echo "<input name='busqueda_nombre' type='text' size='30' value='".$colegioultimo5['nombreinstitucioneducativa']."'>";
?>
</td>
 </tr>
  <tr>
  	<td colspan="2">
  	  <input name="buscar" type="submit" value="Buscar">&nbsp;</td>
  </tr>
<?php
// } 
if(isset($_GET['buscar']))
{    
    /*session_unregister('codigoestudiantecolegionuevo');
    session_unregister('idcodigocolegioestudiante');
	session_unregister('codigoestudiantecolegio');*/
?>
</table>
<p>Seleccione la instituci&oacute;n educativa de la siguiente tabla: </p>
<table width="70%"  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
  <tr id="trtitulogris">
    <td>Instituci&oacute;n</td>
    <td>Ciudad</td>
  </tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		$nombre = $_GET['busqueda_nombre'];
		$query_solicitud = "SELECT *
		FROM institucioneducativa
		WHERE nombreinstitucioneducativa LIKE '%$nombre%'
	    order by nombreinstitucioneducativa";
		// echo $query_solicitud;
		$res_solicitud = $db->Execute($query_solicitud);
	    if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	//echo $codigoestudiante;
	if(!$vacio)
	{
		while($solicitud = $res_solicitud->FetchRow())
		{
			$est = $solicitud["nombreinstitucioneducativa"];			
			$cod = $solicitud["idinstitucioneducativa"];
			$ciudad = $solicitud["municipioinstitucioneducativa"];			
		   	//<td><a href='crearestudiantecolegio.php?colegio=$cod'>$est&nbsp;</a></td>
			echo "<tr>
					<td><a href='crearestudiantecolegio.php?colegio=$cod'>$est&nbsp;</a></td>
					<td>".$ciudad."</td>					
					</tr>";			
		}
	}
	echo '<tr><td colspan="4"><input type="submit" name="cancelar" value="Cancelar" onClick="recargar()"></td></tr>';
 }

?>
</table>
<p>
</p>
</form>
</body>
<script language="javascript">
function terminar(idinstitucion)
{
	window.opener.recargar_institucion(idinstitucion);
	window.opener.focus();
	window.close();
}
function recargar()
{
	window.location.reload("modificarhistoricobusqueda.php");
}
</script>
<script language="javascript">
function crear()
{
	window.location.reload("editarestudiantecolegionuevo.php");
}
</script>
</html>