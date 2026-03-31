<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
      
require_once('../../../Connections/sala2.php');
session_start();
$GLOBALS['codigoestudiantecolegio'];
$GLOBALS['codigoestudiantecolegionuevo'];
$GLOBALS['idcodigocolegioestudiante'];
$direccion = "editarestudiante.php";
?>
<form name="f1" action="editarestudiantecolegio.php" method="get" onSubmit="return validar(this)">
<?php


if (isset($_GET['insertar']))
  {
  session_unregister('idcodigocolegioestudiante');
  }
 

if (isset($_GET['codigo']))
 {
  
   $_SESSION['codigoestudiantecolegio'] = $_GET['codigo'];
   $codigoestudiante = $_SESSION['codigoestudiantecolegio'];
 }
//else

if ($_GET['id'] <> "")
 {
   
  session_unregister('idcodigocolegioestudiante');
  $_SESSION['idcodigocolegioestudiante'] = $_GET['id']; 
  
  $colegiostudy5= "SELECT * FROM institucioneducativa WHERE idinstitucioneducativa = '".$_GET['idcol']."'";
  //echo $colegiostudy5;
  $respuestacolegio5=mysql_db_query($database_sala,$colegiostudy5);
  $colegioultimo5=mysql_fetch_array($respuestacolegio5);
  $colegioseleccionado = $colegioultimo5['nombreinstitucioneducativa'];
  //echo $colegioseleccionado;
 }
?>
<html>
<head>
<title></title>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {font-size: xx-small}
-->
</style>
</head>

<script language='javascript'>
function cambia_tipo()
{
    var tipo 
    tipo = document.f1.tipo[document.f1.tipo.selectedIndex].value 
    //miro a ver si el tipo está definido 
    if (tipo == 1)
	{
	  window.location.reload('editarestudiantecolegio.php?busqueda=nombre');
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
		window.location.reload("editarestudiantecolegio.php?buscar="+busca); 
	} 
} 
</script>
<body>
<div align="center" class="Estilo1">
<?php
if ($_GET['guardar'])
  {     
     $ano = substr($_GET['fechagrado'],0,4);
	 $mes= substr($_GET['fechagrado'],5,2);	 
	 $dia = substr($_GET['fechagrado'],8,2);
  	if (! checkdate($mes,$dia,$ano) or $_GET['fechagrado'] > date('Y-m-d'))
	 {
	   echo '<script language="javascript">alert("Fecha Incorrecta")</script>'; 
	   echo '<script language="javascript">history.go(-1)</script>'; 
	 }
	else
	 if ($_SESSION['idcodigocolegioestudiante'] <> "")
	 {
	   
	   $base="update institucioneducativaestudiante 
	           set  idinstitucioneducativa = '".$_GET['idcolegio']."',
			   fechagradoinstitucioneducativaestudiante = '".$_GET['fechagrado']."'
			   where idinstitucioneducativaestudiante = '".$_SESSION['idcodigocolegioestudiante']."'"; 
	   
	     $sol=mysql_db_query($database_sala,$base);	
	    session_unregister('idcodigocolegioestudiante');
	    session_unregister('codigoestudiantecolegio');
	    echo "<script language='javascript'>
		  window.opener.recargar('".$direccion."');
		  window.opener.focus();
		  window.close();
		  </script>";
		  exit();
	 }	
	else	 
	 {
	    $sql = "insert into institucioneducativaestudiante(idinstitucioneducativa,codigoestudiante,fechagradoinstitucioneducativaestudiante)";
	    $sql.= "VALUES('".$_GET['idcolegio']."','".$_SESSION['codigoestudiantecolegio']."','".$_GET['fechagrado']."')"; 
	    //echo $sql;
		//exit();
	    $result = mysql_query($sql,$sala) or die (mysql_error());    
	      session_unregister('codigoestudiantecolegio');
		 echo "<script language='javascript'>
		  window.opener.recargar('".$direccion."');
		  window.opener.focus();
		  window.close();
		  </script>";
		  exit();
	 }
 }

if ($_GET['colegio'] <> "")
  { 
		$codigocolegio = $_GET['colegio'];
		$colegiostudy= "SELECT * FROM institucioneducativa WHERE idinstitucioneducativa = '$codigocolegio'";
	    $respuestacolegio=mysql_db_query($database_sala,$colegiostudy);
	    $colegioultimo=mysql_fetch_array($respuestacolegio);
		
	  if ($colegioultimo <> "")
	   {
	        $colegiostudy1= "SELECT * FROM institucioneducativaestudiante
			                 WHERE idinstitucioneducativaestudiante = '".$_SESSION['idcodigocolegioestudiante']."'";
			$respuestacolegio1=mysql_db_query($database_sala,$colegiostudy1);
			$colegioultimo1=mysql_fetch_array($respuestacolegio1);
	      //echo $colegiostudy1;
	  ?>
       <table width="500" border="1" bordercolor="#003333">
       <tr bgcolor="#C5D5D6">
           <td width="327" align="center" class="Estilo2"><strong>Nombre Colegio</strong></td>
		   <td width="157" align="center" class="Estilo2"><strong>Fecha de Grado</strong></td>		   
       </tr>  
	    <tr>
           <td align="center" class="Estilo2"><strong><?php echo  $colegioultimo['nombreinstitucioneducativa'];?><input name="idcolegio" type="hidden" id="idcolegio" value="<?php echo $_GET['colegio'];?>"> <input name="codigoestudiante" type="hidden" id="codigoestudiante" value="<?php echo $_GET['codigo'];?>"></strong></td>
		   <td align="center" class="Estilo2"><strong>		
		   <input name="fechagrado" type="text" id="fechagrado" value="<?php if($colegioultimo1 <> "") echo $colegioultimo1['fechagradoinstitucioneducativaestudiante']; else echo "0000-00-00";?>" size="8">
		   </strong>aaaa-mm-dd</td>
       </tr>
	   <td colspan="2" align="center"><input name="guardar" type="submit" value="Guardar">&nbsp;</span></td>  
       </table>  
 
 <?php 
       }
    exit();
  }
?>
  <p><strong>CRITERIO DE BUSQUEDA</strong></p>
  <table width="70%" border="1" bordercolor="#003333">
  <tr>
    <td width="250" bgcolor="#C5D5D6"><div align="center"><span class="Estilo3"> <strong>Digite el Nombre del Colegio  : </strong>
            <!--  <select name="tipo" onChange="cambia_tipo()">
		  <option value="0">Seleccionar</option>
		  <option value="1">Nombre</option>		  
	      </select> -->
	&nbsp;
	  </span></div></td>
	<td><span class="Estilo3">&nbsp;
<?php

	 echo "<input name='busqueda_nombre' type='text' size='30' value='".$colegioultimo5['nombreinstitucioneducativa']."'>";
if (isset($_GET['nuevo'])) 
 {	
    echo "<input name='nuevo' type='hidden' size='2' value='1'>";
 }
?>
</span>
</td>
 </tr>
  <tr>
  	<td colspan="2" align="center"><span class="Estilo3">
  	  <input name="buscar" type="submit" value="Buscar">
  	  &nbsp;</span></td>
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

<p align="center" class="Estilo2"><strong>Seleccione el Colegio: </strong></p>
<table width="70%" border="1" bordercolor="#003333">
  <tr>
    <td width="308" align="center" class="Estilo2"><strong>Colegio</strong></td>
    <td width="176" align="center" class="Estilo2"><strong>Ciudad</strong></td>
  </tr>
<?php
  	$vacio = false;
	if(isset($_GET['busqueda_nombre']))
	{
		
		
		$nombre = $_GET['busqueda_nombre'];
		mysql_select_db($database_sala, $sala);
		$query_solicitud = "SELECT
					*
				FROM
					institucioneducativa
				WHERE					
					 nombreinstitucioneducativa LIKE '$nombre%'
			    order by nombreinstitucioneducativa
				";
					// echo $query_solicitud;
		$res_solicitud = mysql_query($query_solicitud, $sala) or die(mysql_error());
		if($_GET['busqueda_nombre'] == "")
			$vacio = true;
	}
	//echo $codigoestudiante;
	if(!$vacio)
	{
		
		while($solicitud = mysql_fetch_assoc($res_solicitud))
		{
			$est = $solicitud["nombreinstitucioneducativa"];			
			$cod = $solicitud["idinstitucioneducativa"];
			$ciudad = $solicitud["municipioinstitucioneducativa"];			
			 if (isset($_GET['nuevo'])) 
	 
			   {
				echo "<tr>
					<td><a href='crearestudiantecolegio.php?colegio=".$cod."&codigo=".$_SESSION['codigoestudiantecolegio']."'&nuevo='1'>$est&nbsp;</a></td>
					<td>".$ciudad."</td>					
					</tr>";
			   }
			else
			 {
			 echo "<tr>
					<td><a href='editarestudiantecolegio.php?colegio=".$cod."&codigo=".$_SESSION['codigoestudiantecolegio']."'&nuevo='1'>$est&nbsp;</a></td>
					<td>".$ciudad."</td>					
					</tr>";		  
			 }
		}
	}
	
	echo '<tr><td colspan="4" align="center"><input type="submit" name="cancelar" value="Cancelar" onClick="recargar()">&nbsp;<input type="button" name="nuevo" value="Ingresar Nuevo Colegio" onClick="crear()"></td></tr>';
 }

?>
</table>
<p class="Estilo2">

</p>
</form>
</div>
</body>
<script language="javascript">
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
