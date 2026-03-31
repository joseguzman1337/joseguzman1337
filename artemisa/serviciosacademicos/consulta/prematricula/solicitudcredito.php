<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php' );
session_start();
// Selecciona el periodo activo
$codigoperiodo = $_SESSION['codigoperiodosesion'];

if(!isset($_SESSION['codigo']))
{
?>
<html>
<head>
<title>Solicitud de Crédito</title>
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>

	<script language="javascript">
	alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
</script>

<?php
}
?>
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: x-small;
}
.Estilo2 {font-size: x-small}
.Estilo16 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo17 {font-size: 16px}
.Estilo18 {
	color: #FFFFFF;
	font-weight: bold;
}
.Estilo19 {
	font-size: xx-small;
	font-weight: bold;
}
.Estilo20 {font-size: xx-small}
.Estilo21 {font-size: 12px}
-->
</style>
</head>
<body>
<?php
$codigoestudiante = $_SESSION['codigo'];
/*$pagina = $_SERVER['HTTP_REFERER'];
$inicio_pagina = strpos ($pagina, "?");
$dir = substr ($pagina, $inicio_pagina);
echo $dir;
*/
//echo "<form name='form1' method='post' action='solicitudcredito.php?programausadopor='".$_GET['programausadopor']."&ordenpago=".$_GET['ordenpago']."'>";
$usadopor = $_GET['programausadopor'];
$numorden = $_GET['ordenpago'];
//echo "$usadopor y $numorden<br>";
//echo "solicitudcredito.php?programausadopor=$usadopor&ordenpago=$numorden";
?>
<form name="form1" method="get" action="solicitudcredito.php">
<div align="center">
<p class="Estilo1 Estilo2 Estilo4 Estilo7 Estilo1"><strong>SOLICITUD DE CREDITO</strong></p>
<span class="Estilo1 Estilo4 Estilo1">
 &nbsp;
 </span>
<p class="Estilo1 Estilo4 Estilo1">&nbsp;</p>
<input type="hidden" name="programausadopor" value="<?php echo $usadopor;?>">
<input type="hidden" name="ordenpago" value="<?php echo $numorden;?>">
    <table width="350" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
      <tr>
        <td  bgcolor="#607766"  class="Estilo1 Estilo4 Estilo1"> 
        <div align="center" class="Estilo18">UNIVERSIDAD EL BOSQUE</div></td>
   </tr>
   <tr>
        <td  bgcolor="#C5D5D6" class="Estilo1 Estilo4 Estilo1"> 
          <div align="center">
            <p><font color="#000000"><strong>¿DESEA SOLICITAR CREDITO INSTITUCIONAL <br> 
            O TIENE CREDITO ICETEX?</strong></font></p>
          </div>
          <div align="center"> 
            <p>              <input name="seguro" type="submit" value="SI">
&nbsp;&nbsp;&nbsp; 
              <input name="cancelar" type="button" value="NO" onClick="window.location.href='matriculaautomaticaordenmatricula.php'">    
            </p>
        </div></td>
   </tr>
 </table>  
</div>
</form>
</body>
</html>
<?php
if($_GET['seguro'])
{	   
	$numerodeorden = $_GET['ordenpago'];
	//echo "EL n : $numerodeorden<br>"; 
	$base1="update ordenpago set codigoimprimeordenpago = '02'
	where codigoestudiante ='$codigoestudiante'
	and numeroordenpago = '$numerodeorden'"; 
	$sol1=mysql_db_query($database_sala,$base1) or die("$base1");	
	//echo $base1."<br>";
	//exit();
	echo '<script language="javascript">
	window.location.href="matriculaautomaticaordenmatricula.php";
	</script>';
}
?>
