<?php 
//require_once('https://artemisa.unbosque.edu.co/serviciosacademicos/Connections/sala2.php');
$hostname_sala = "200.31.79.227";
$database_sala = "sala";
$username_sala = "emerson";
$password_sala = "kilo999";
$sala = mysql_pconnect($hostname_sala, $username_sala, $password_sala) or trigger_error(mysql_error(),E_USER_ERROR); 

//require_once('../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
$codigocarrera = $_GET['carrera'];
//echo $codigocarrera;
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
<form name="form1" method="post" action="listadoimpresiones.php?carrera=<?php echo  $codigocarrera;?>">
<p>&nbsp;</p>
<?php
if($_POST['seguro'])
{
	$query_impresion = "select e.apellidosestudiante, o.numeroordenpago, e.codigoestudiante, e.nombresestudiante, 
	e.numerodocumento, e.semestre, o.codigocopiaordenpago, o.codigoimprimeordenpago, f.valorfechaordenpago
	from estudiante e, ordenpago o, fechaordenpago f
	where o.codigoestudiante = e.codigoestudiante
	and o.codigoestadoordenpago like '1%'
	and o.codigoperiodo = '20052'
	and e.codigocarrera = '$codigocarrera'
	and o.numeroordenpago = f.numeroordenpago
	and f.porcentajefechaordenpago = '0'
	having e.apellidosestudiante > '".$_POST['apellido']."'
	order by 1";				
	//and o.codigoimprimeordenpago = '01'
	//and o.codigocopiaordenpago = '200'
	//echo $query_cierre,"<br>";
	//exit();
	$impresion = mysql_query($query_impresion, $sala) or die("$query_impresion".mysql_error());
	$totalRows_impresion = mysql_num_rows($impresion);
	
	if($totalRows_impresion != "")
	{	
?>
<p align="center" class="Estilo1"><strong>Lista de estudiantes a los con impresion de orden : </strong></p>
<table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr>
    <td align="center" class="Estilo1"><strong>Nº</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Nombre Estudiante</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Sem.</strong></td>
    <td align="center" class="Estilo1"><strong>Orden Pago</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Valor</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Cédula</strong>&nbsp;</td>
    <td align="center" class="Estilo1"><strong>Código</strong>&nbsp;</td>
	<td align="center" class="Estilo1"><strong>Firma Estudiante</strong>&nbsp;</td>
	<td align="center" class="Estilo1"><strong>Estado</strong>&nbsp;</td>
  </tr>
<?php	
		$cuenta = 1;
		while($row_impresion = mysql_fetch_assoc($impresion))
		{
			$numeroordenpago = $row_impresion['numeroordenpago'];
			$query_pazysalvo = "select p.idpazysalvoestudiante
			from pazysalvoestudiante p, detallepazysalvoestudiante d
			where p.codigoestudiante = '".$row_impresion['codigoestudiante']."'
			and p.idpazysalvoestudiante = d.idpazysalvoestudiante
			and d.codigoestadopazysalvoestudiante like '1%'";
			$pazysalvo = mysql_db_query($database_sala,$query_pazysalvo) or die("$query_pazysalvo");
			$totalRows_pazysalvo = mysql_num_rows($pazysalvo);
			$row_pazysalvo = mysql_fetch_array($pazysalvo);
			
			$est = $row_impresion["apellidosestudiante"]." ".$row_impresion["nombresestudiante"];
			$cc = $row_impresion["numerodocumento"];
			$cod = $row_impresion["codigoestudiante"];
			$semestre = $row_impresion["semestre"];
			$valor = number_format($row_impresion["valorfechaordenpago"]);
			echo "<tr>
			<td>$cuenta&nbsp;</td>
			<td>$est&nbsp;</td>
			<td align='center'>$semestre&nbsp;</td>
			<td>$numeroordenpago&nbsp;</td>
			<td>$valor&nbsp;</td>
			<td>$cc&nbsp;</td>
			<td>$cod&nbsp;</td>
			<td>&nbsp;</td>";
			if($row_impresion['codigoimprimeordenpago'] == '02' && $totalRows_pazysalvo != "")
			{
				echo "<td align='center'>CREDITO Y DEUDA</td>";
			}
			else if($row_impresion['codigoimprimeordenpago'] == '02')
			{
				echo "<td align='center'>CREDITO</td>";
			}
			else if($totalRows_pazysalvo != "") 
			{
				echo "<td align='center'>DEUDA</td>";
			}
			else
			{
				echo "<td align='center'><input type='checkbox' name='numorden$cod' value='$numeroordenpago'></td>";
			}
			echo "</tr>";
			$cuenta++;
		}
?>
<tr>
	  <td colspan='9' align='center'>
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
{ // if mayor 
?>
<table width="410" border="1" align="center" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td  bgcolor="#607766"  class="Estilo1 Estilo4 Estilo1"> 
        <div align="center" class="Estilo18 Estilo1 Estilo3" style="color: #FFFFFF">UNIVERSIDAD EL BOSQUE            </div></td>
   </tr>
   <tr>
        <td  bgcolor="#C5D5D6" class="Estilo4 Estilo1 Estilo2"> 
          <div align="center">
       <p><span class="Estilo2 Estilo23 Estilo27 Estilo1 Estilo3">LISTADO DE IMPRESI&Oacute;N DE ORDENES MASIVAS </span></p>
       <p><strong><font color="#000000"> En el campo de texto digite una letra o el apellido del alumno desde el cual va ha 
	   listar el proceso. </font></strong></p>
       <p><strong><font color="#000000">Si digita los apellidos completos, comnezara el proceso para los alumnos que tengan un apellido 
	     en orden alfabetico mayor al digitado</font></strong></p>
       <p><input type="text" name="apellido" value="a"></p>
       <p><strong><font color="#000000"> Recuerde que solamente se listaran las ordenes que no han sido impresas anteriormente.</font></strong></p>
       <p><strong><font color="#000000">&iquest; Esta seguro de generar la impresi&oacute;n? </font></strong></p>
       <p>&nbsp;</p>
          </div>
          <div align="center"> 
            <p><input name="seguro" type="submit" id="seguro" value="Generar Impresión">
&nbsp;&nbsp;&nbsp; &nbsp;
              <input type="button" onClick="window.location.reload('../facultades/menuopcion.php')" value="Cancelar">   
            </p>
        </div></td>
   </tr>
 </table>
<p>
</p>
<?php
}
?>
</form>
</div>
</body>
</html>
<?php
if($_POST['aceptar'])
{
	foreach($_POST as $llavepost => $valorpost)
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
		window.location.reload('../listadoimpresiones.php');
	}
	</script>
<?php
}
?>
