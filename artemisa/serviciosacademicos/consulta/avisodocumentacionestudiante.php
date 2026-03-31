<?php  require_once('../Connections/sala2.php');
//session_start();
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<script language="javascript">
var browser = navigator.appName;
function hRefCentral(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.contenidocentral.location.href(url);
	}
	else{
		parent.contenidocentral.location=url;
	}
	return true;
}

function hRefIzq(url){
	if(browser == 'Microsoft Internet Explorer'){
		parent.leftFrame.location.href(url);
	}
	else{
		parent.leftFrame.location=url;
	}
	return true;
}

function destruirFrames(url){
	parent.document.location.href=url;
}
</script>
<?php
if(!isset($_SESSION['nuevoMenu'])){
	require_once('encabezado.php');
}
$codigoestudiante=$_SESSION['codigo'];
$periodo = $_SESSION['codigoperiodosesion'];

$query_carrera= "SELECT e.codigocarrera,eg.codigogenero
				FROM estudiante e,estudiantegeneral eg
				WHERE e.idestudiantegeneral = eg.idestudiantegeneral 
				AND e.codigoestudiante = '$codigoestudiante'";
$sols=mysql_db_query($database_sala,$query_carrera);
$rows=mysql_fetch_array($sols);

$carrera = $rows['codigocarrera'];
//$fecha = date("Y-m-d G:i:s",time());
mysql_select_db($database_sala, $sala);
$query_valida = "SELECT *
		         FROM documentacion d,documentacionfacultad df
			     where d.iddocumentacion = df.iddocumentacion
				 and df.codigocarrera = '$carrera'
				 AND (df.codigogenerodocumento = '300' OR df.codigogenerodocumento = '".$rows['codigogenero']."')";
//echo $query_valida,"<br>";
$valida = mysql_query($query_valida, $sala) or die(mysql_error());
$row_valida = mysql_fetch_assoc($valida);
$totalRows_valida = mysql_num_rows($valida);
if (!$row_valida)
{

	/*if(isset($_SESSION['nuevoMenu'])){
		//echo "ENTRE HABER 1";
	//exit();

		$accion='facultades/central.php';
		 echo "<script language='javascript'>
		 		//alert('Usted no tiene permiso para entrar a esta opcion');
	   			document.location.href='facultades/central.php';
	 	  </script>";

		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=facultades/central.php'>";
	}
	else{*/
		$accion='consultanotas.htm';
		 echo "<script language='javascript'>
		 		//alert('Usted no tiene permiso para entrar a esta opcion');
	   			//document.location.href='consultanotas.htm';
				hRefIzq('facultades/facultadeslv2.php');
				hRefCentral('facultades/central.php');
	 	  </script>";		
		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultanotas.htm'>";
	//}

}
echo $accion;
$contadordocumentos=1;
$indicadordocumentos=0;
do{
	$query_documentosestuduante = "SELECT DISTINCT codigotipodocumentacionfacultad,fechavencimientodocumentacionestudiante
		FROM documentacionestudiante d,documentacionfacultad df 
		WHERE d.codigoestudiante = '".$codigoestudiante."' 
		AND d.iddocumentacion = '".$row_valida['iddocumentacion']."'	 
		AND d.codigotipodocumentovencimiento = '100'
		AND d.codigoperiodo = '$periodo'
		AND d.iddocumentacion = df.iddocumentacion
		AND codigocarrera = '$carrera'
		";
	//  echo $query_documentosestuduante,"<br><br>";
	$documentosestuduante  = mysql_query($query_documentosestuduante , $sala) or die(mysql_error());
	$row_documentosestuduante  = mysql_fetch_assoc($documentosestuduante );
	$totalRows_documentosestuduante  = mysql_num_rows($documentosestuduante );
	if (!$row_documentosestuduante)
	{
		$documentosfaltantes[$contadordocumentos] = $row_valida['nombredocumentacion'];
		$contadordocumentos ++;
		$indicadordocumentos = 1;

	}
	else
	if ($row_documentosestuduante['codigotipodocumentacionfacultad'] == 200 and $row_documentosestuduante['fechavencimientodocumentacionestudiante'] < date("Y-m-d"))
	{
		$documentosfaltantes[$contadordocumentos] = $row_valida['nombredocumentacion'];
		$contadordocumentos ++;
		$indicadordocumentos = 1;

	}

}while($row_valida = mysql_fetch_assoc($valida));

if ($indicadordocumentos == 1)
  {//validadocente ?>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo3 {font-family: Tahoma; font-size: 14px; font-weight: bold;}
.Estilo4 {
	color: #990000;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 10px;
}
-->
</style>
 <form name="form1" method="post" action="consultanotas.htm">
<table width="60%"  border="3" bordercolor="#003333">
  <tr>
 
    <td><p align="center" class="Estilo3 Estilo4">USTED TIENE PENDIENTE POR ENTREGAR LOS SIGUIENTES DOCUMENTOS:</p>
      <p align="center" class="Estilo2">Por favor ac&eacute;rquese a su Facultad.</p>
      <table width="100%" border="1" align="center" cellpadding="2" cellspacing="2" bordercolor="#003333">
      <tr>
        
        <td width="49%" align="center" bgcolor="#C5D5D6" class="Estilo2">Documento</td>
      </tr>
 <?php 
 for($i=1;$i<$contadordocumentos;$i++)
 {
 	echo '<tr>
					<td><div align="center" class="Estilo1">'.$documentosfaltantes[$i].'&nbsp;</div></td>				
					</tr>';
 }
		?>
       </table>
       
      </td>
  </tr>
</table>
 
    <div align="center"></div>
   <?php
   if(!isset($_GET['prema']))
   {
?> 
    <div align="left">
  <?php if(!isset($_SESSION['nuevoMenu'])){?>  
  <input name="Aceptar" type="submit" id="Aceptar" value="Continuar">
  <?php } else{ ?>
  <input name="Aceptar" type="button" id="Aceptar" value="Continuar" onclick="hRefIzq('facultades/facultadeslv2.php');hRefCentral('facultades/central.php');">
  <?php } ?>
  
  <?php
   }
   else
   {
?>
       <input name="Aceptar" type="button" id="Aceptar" value="Cerrar" onClick="window.close()"> 
      <?php
   }
?>
&nbsp;
      </div>
 </form>
<?php 
  }
  else
  {
  	if(isset($_SESSION['nuevoMenu'])){
		//echo "ENTRE HABER 1";
	//exit();

  		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=facultades/central.php'>";
				/* echo "<script language='javascript'>
		 		//alert('Usted no tiene permiso para entrar a esta opcion');
	   			document.location.href='facultades/central.php';
	 	  </script>";*/
		  	echo "<script language='javascript'>
		 		//alert('Usted no tiene permiso para entrar a esta opcion');
	   			//document.location.href='consultanotas.htm';
				hRefIzq('facultades/facultadeslv2.php');
				hRefCentral('facultades/central.php');
	 	  </script>";		


  	}
  	else{
		//echo "ENTRE HABER 2";
	//exit();

		 echo "<script language='javascript'>
		 		//alert('Usted no tiene permiso para entrar a esta opcion');
	   			document.location.href='consultanotas.htm';
	 	  </script>";

  		//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=consultanotas.htm'>";
  	}
  }
?>