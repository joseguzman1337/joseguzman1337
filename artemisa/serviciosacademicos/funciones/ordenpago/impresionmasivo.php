<?php 
/*$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 
*/
require_once('Cimpresionescyc.php');
//require_once('../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
$codigocarrera = $_SESSION['codigofacultad'];
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Impresion Masivo</title>
</head>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {font-size: x-small}
.Estilo3 {
	font-size: small;
	font-weight: bold;
}
-->
</style>
<body>
<div align="center">
<form name="form1" method="get" action="impresionmasivo.php">
<p>&nbsp;</p>
<?php
if($_GET['seguro'])
{
	$query_impresionantes = "select eg.apellidosestudiantegeneral, o.numeroordenpago, e.codigoestudiante, eg.nombresestudiantegeneral, 
	eg.numerodocumento, e.semestre
	from estudiante e, ordenpago o, estudiantegeneral eg, detalleordenpago do
	where o.codigoestudiante = e.codigoestudiante
	and o.codigoestadoordenpago like '1%'
	and o.codigoimprimeordenpago = '01'
	and o.codigoperiodo = '20062'
	and o.codigocopiaordenpago = '200'
	and e.codigocarrera = '$codigocarrera'
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and do.numeroordenpago = o.numeroordenpago
	and do.codigoconcepto = '151'
	and e.codigoperiodo = '20062'
	having eg.apellidosestudiantegeneral > '".$_GET['apellido']."'
	order by 1";				
	//echo $query_cierre,"<br>";
	//exit();
	$impresionantes = mysql_query($query_impresionantes, $sala) or die("$query_impresionantes".mysql_error());
	$totalRows_impresionantes = mysql_num_rows($impresionantes);
	
	if($totalRows_impresionantes != "")
	{	
	
	
?>
<p align="center" class="Estilo1"><strong>Lista de estudiantes con impresion antes del proceso: </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Sem.</strong></td>
    <td align="center" class="Estilo1"><strong>Orden Pago</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
	<td align="center" class="Estilo1"><strong>Firma Estudiante</strong>&nbsp;</td>
	<!-- <td align="center" class="Estilo1"><strong>Fallo</strong>&nbsp;</td> -->
  </tr>
<?php	
		while($row_impresionantes = mysql_fetch_assoc($impresionantes))
		{
			$numeroordenpago = $row_impresionantes['numeroordenpago'];
			/*$query_pazysalvo = "select p.idpazysalvoestudiante
			from pazysalvoestudiante p, detallepazysalvoestudiante d
			where p.codigoestudiante = '".$row_impresionantes['codigoestudiante']."'
			and p.idpazysalvoestudiante = d.idpazysalvoestudiante
			and d.codigoestadopazysalvoestudiante like '1%'";
			$pazysalvo = mysql_db_query($database_sala,$query_pazysalvo) or die("$query_pazysalvo");
			$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
			$row_pazysalvo = mysql_fetch_array($pazysalvo);
			*/
			$est = $row_impresionantes["apellidosestudiantegeneral"]." ".$row_impresionantes["nombresestudiantegeneral"];
			$cc = $row_impresionantes["numerodocumento"];
			$cod = $row_impresionantes["codigoestudiante"];
			$semestre = $row_impresionantes["semestre"];
			echo "<tr>
			<td>$est&nbsp;</td>
			<td align='center'>$semestre&nbsp;</td>
			<td>$numeroordenpago&nbsp;</td>
			<td>$cc&nbsp;</td>
			<td>$cod&nbsp;</td>
			<td>&nbsp;</td>";
			if($totalRows_pazysalvo == "")
			{
				//echo "<td align='center'><input type='checkbox' name='numorden$cod' value='$numeroordenpago'></td>";
			}
			else
			{
				//echo "<td align='center'>DEUDA</td>";
			}
			echo "</tr>";
		}
?>
</table>
<br>
<br>
<?php
	}
	$query_impresion = "select eg.apellidosestudiantegeneral, o.numeroordenpago, e.codigoestudiante, eg.nombresestudiantegeneral, 
	eg.numerodocumento, e.semestre
	from estudiante e, ordenpago o, estudiantegeneral eg, detalleordenpago do
	where o.codigoestudiante = e.codigoestudiante
	and o.codigoestadoordenpago like '1%'
	and o.codigoimprimeordenpago = '01'
	and o.codigoperiodo = '20062'
	and o.codigocopiaordenpago = '100'
	and e.codigocarrera = '$codigocarrera'
	and e.idestudiantegeneral = eg.idestudiantegeneral
	and do.numeroordenpago = o.numeroordenpago
	and do.codigoconcepto = '151'
	and e.codigoperiodo = '20062'
	having eg.apellidosestudiantegeneral > '".$_GET['apellido']."'
	order by 1";				
	//echo $query_cierre,"<br>";
	//exit();
	$impresion = mysql_query($query_impresion, $sala) or die("$query_impresion".mysql_error());
	$totalRows_impresion = mysql_num_rows($impresion);
	
	if($totalRows_impresion != "")
	{	
	
	
?>
<p align="center" class="Estilo1"><strong>Lista de estudiantes a los que se les imprimio orden en este proceso: </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Sem.</strong></td>
    <td align="center" class="Estilo1"><strong>Orden Pago</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
	<td align="center" class="Estilo1"><strong>Firma Estudiante</strong>&nbsp;</td>
	<!-- <td align="center" class="Estilo1"><strong>Fallo</strong>&nbsp;</td> -->
  </tr>
<?php	
		while($row_impresion = mysql_fetch_assoc($impresion))
		{
			$numeroordenpago = $row_impresion['numeroordenpago'];
			/*$query_pazysalvo = "select p.idpazysalvoestudiante
			from pazysalvoestudiante p, detallepazysalvoestudiante d
			where p.codigoestudiante = '".$row_impresion['codigoestudiante']."'
			and p.idpazysalvoestudiante = d.idpazysalvoestudiante
			and d.codigoestadopazysalvoestudiante like '1%'";
			$pazysalvo = mysql_db_query($database_sala,$query_pazysalvo) or die("$query_pazysalvo");
			$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
			$row_pazysalvo = mysql_fetch_array($pazysalvo);
			if($totalRows_pazysalvo == "")
			{*/
			
			//require("impresionmas.php");
			//}
			$est = $row_impresion["apellidosestudiantegeneral"]." ".$row_impresion["nombresestudiantegeneral"];
			$cc = $row_impresion["numerodocumento"];
			$cod = $row_impresion["codigoestudiante"];
			$semestre = $row_impresion["semestre"];
			echo "<tr>
			<td>$est&nbsp;</td>
			<td align='center'>$semestre&nbsp;</td>
			<td>$numeroordenpago&nbsp;</td>
			<td>$cc&nbsp;</td>
			<td>$cod&nbsp;</td>
			<td>&nbsp;</td>";
			if($totalRows_pazysalvo == "")
			{
				//echo "<td align='center'><input type='checkbox' name='numorden$cod' value='$numeroordenpago'></td>";
			}
			else
			{
				//echo "<td align='center'>DEUDA</td>";
			}
			echo "</tr>";
		}
?>
<tr>
	  <td colspan='7' align='center'>
		<input type='button' value='Imprimir' onClick='print()'>
		<input type='submit' value='Aceptar' name="aceptar">
	  </td>
  </tr>
</table>
<br>
<br>
<?php
	}
}
else
{ 
	// if mayor 
	$query_selimpresora= "select s.idseleccionaimpresora, s.nombreseleccionaimpresora, s.ubicacionseleccionaimpresora, s.ipseleccionaimpresora
	from seleccionaimpresora s
	where s.fechafinalseleccionaimpresora >= '".date("Y-m-d")."'";
	$selimpresora=mysql_query($query_selimpresora, $sala) or die("$query_selimpresora".mysql_error());
	$totalRows_selimpresora = mysql_num_rows($selimpresora);
?>
<table width="410" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td  bgcolor="#607766"  class="Estilo1 Estilo4 Estilo1"> 
        <div align="center" class="Estilo18 Estilo1 Estilo3" style="color: #FFFFFF">UNIVERSIDAD EL BOSQUE            </div></td>
   </tr>
   <tr>
        <td  bgcolor="#C5D5D6" class="Estilo4 Estilo1 Estilo2"> 
          <div align="center">
       <p><span class="Estilo2 Estilo23 Estilo27 Estilo1 Estilo3">IMPRESI&Oacute;N DE ORDENES MASIVAS </span></p>
       <p><strong><font color="#000000"> En el campo de texto digite una letra o el apellido del alumno desde el cual va ha 
	   iniciar el proceso. </font></strong></p>
       <p><strong><font color="#000000">Si digita los apellidos completos, comnezara el proceso para los alumnos que tengan un apellido 
	     en orden alfabetico mayor al digitado</font></strong></p>
       <p><input type="text" name="apellido" value="a"></p>
       <p><strong><font color="#000000"> Recuerde que solamente se imprimiran las ordenes que no han sido impresas anteriormente.</font></strong></p>
       <p><strong><font color="#000000">&iquest; Esta seguro de generar la impresi&oacute;n? </font></strong></p>
       <p>&nbsp;</p>
          </div>
          <div align="center"> 
            <p><input name="seguro" type="submit" id="seguro" value="Generar Impresión">
&nbsp;&nbsp;&nbsp; &nbsp;
              <input type="button" onClick="window.location.reload('../../consulta/facultades/menuopcion.php')" value="Cancelar">   
            </p>
        </div></td>
   </tr>
<tr>
<td><table align="center" width="631" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
<tr>
<td align="center">
<strong>SELECCIONE LA IMPRESORA</strong>
</td>
</tr>
  <tr>
	<td align="center">
	<select name="ipimpresora">
<?php
while($row_selimpresora = mysql_fetch_array($selimpresora))
{
?>
	  <option value="<?php echo $row_selimpresora['ipseleccionaimpresora']; ?>">
	  <?php echo $row_selimpresora['nombreseleccionaimpresora'];?>
	  </option>
<?php
}
//echo "sadas".$_SERVER['HTTP_REFERER']."asDSADa".$HTTP_SERVER_VARS['HTTP_REFERER'];
?>
	</select>
	</td>
  </tr>
</table>  
  </td>
</tr>
 </table>
<p align="center">
<input type="button" onClick="window.location.reload('../../consulta/facultades/menuopcion.php')" value="Cancelar">
</p>
<?php
}
?>
</form>
</div>
</body>
</html>
<?php
if($_GET['aceptar'])
{
	foreach($_GET as $llavepost => $valorpost)
	{
		if(ereg("numorden",$llavepost))
		{
			//echo "Entro<br>";
			$query_updimpresion = "UPDATE ordenpago
			SET codigocopiaordenpago = '100'
			WHERE numeroordenpago = '$valorpost'"; 
			$updimpresion = mysql_query($query_updimpresion,$sala) or die("$query_updimpresion".mysql_error()); 
		}
	}
?>
<script language="javascript">
	function salir()
	{
		window.location.reload('../impresionmasivo.php');
	}
	</script>
<?php
}
?>
