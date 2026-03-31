<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
//echo $_SESSION['codigo'],"session";
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
.Estilo1 {
	font-family: tahoma;
	font-size: 10px;
}
.Estilo2 {
	font-family: tahoma;
	font-size: 14px;
}
.Estilo5 {font-size: 10px}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">

  <?php 
  
  $fa=$_GET['ggg'];
  $digo = $_SESSION['codigofacultad'];
  //$digo=$digo;
  //$digo=$_GET['di'];
  //echo "aqui esta codigo carrera 126";
  include("pconexionbase.php");
  mysql_select_db($database_sala, $sala);
  $sql_carre= "SELECT  nombrecarrera FROM carrera where codigocarrera = '126'";
$carre=mysql_query($sql_carre,$sala);

     
	 $filacarre = mysql_fetch_assoc($carre);
	?>  

<p align="center" class="style1 Estilo1 Estilo2"><strong>UNIVERSIDAD EL BOSQUE </strong></p>
<p align="center" class="style1 Estilo1 Estilo2"><strong> FACULTAD<span class="style1"><strong><span class="style3"> 
  <?php echo $filacarre['nombrecarrera'];?></span></strong></span></strong> </p>
<p align="center" class="style1 Estilo1 Estilo2"><strong>EVALUACI&Oacute;N DEL DESARROLLO DE LAS 
  ASIGNATURAS </strong></p>
<p align="center" class="style1 Estilo1 Estilo2"><strong>POR PARTE DE LOS ESTUDIANTES </strong></p>
<p align="center" class="style1 Estilo1 Estilo2"><strong>20102</strong></p>
<p align="center" class="Estilo2 style1">&nbsp;</p>
<span class="Estilo2">
   <?php 


//echo "aqui va el  codigo de la materia:".$filamateria['codigomateria'];

$sql_noencuestas= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and codigoperiodo='20102'";
$resultadonoencuestas=mysql_query($sql_noencuestas,$sala);
$contanoencuestas=0;
while ($filanoencuestas=mysql_fetch_array($resultadonoencuestas))
{
$contanoencuestas++;
}

//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp1e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp1 = 'e' and codigoperiodo='20102'";
$resultadorp1e=mysql_query($sql_rp1e,$sala);
$contarp1e=0;
echo $resultadorp1e;
while ($filarp1e=mysql_fetch_array($resultadorp1e))
{
$contarp1e++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep1 =($contarp1e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp1b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp1 = 'b' and codigoperiodo='20102'";
$resultadorp1b=mysql_query($sql_rp1b,$sala);
$contarp1b=0;
while ($filarp1b=mysql_fetch_array($resultadorp1b))
{
$contarp1b++;
}
//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;
$porcenbp1=($contarp1b/$contanoencuestas)*100;
$np1=($porcenep1+$porcenbp1)/20;
//
$sql_rp1b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp1 = 'd' and codigoperiodo='20102'";
$resultadorp1d=mysql_query($sql_rp1b,$sala);
$contarp1d=0;
while ($filarp1d=mysql_fetch_array($resultadorp1d))
{
$contarp1d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
$porcendp1=($contarp1d/$contanoencuestas)*100;
//
$sql_rp1p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp1 = 'p' and codigoperiodo='20102'";
$resultadorp1p=mysql_query($sql_rp1p,$sala);
$contarp1p=0;
while ($filarp1p=mysql_fetch_array($resultadorp1p))
{
$contarp1p++;
}
//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;
$porcenpp1=($contarp1p/$contanoencuestas)*100;
//222222222222222222222222222222222222222222222222222222222222222222222222222222222
$sql_rp2e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp2 = 'e' and codigoperiodo='20102'";
$resultadorp2e=mysql_query($sql_rp2e,$sala);
$contarp2e=0;
while ($filarp2e=mysql_fetch_array($resultadorp2e))
{
$contarp2e++;
}
//echo "el numero de personas que respondieron e a la pregunta 2 son:".$contarp1e;
$porcenep2 =($contarp2e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp2b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp2 = 'b' and codigoperiodo='20102'";
$resultadorp2b=mysql_query($sql_rp2b,$sala);
$contarp2b=0;
while ($filarp2b=mysql_fetch_array($resultadorp2b))
{
$contarp2b++;
}
//echo "el numero de personas que respondieron b a la pregunta 2 son:".$contarp1b;
$porcenbp2=($contarp2b/$contanoencuestas)*100;
$np2=($porcenep2+$porcenbp2)/20;
//
$sql_rp2b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp2 = 'd' and codigoperiodo='20102'";
$resultadorp2d=mysql_query($sql_rp2b,$sala);
$contarp2d=0;
while ($filarp2d=mysql_fetch_array($resultadorp2d))
{
$contarp2d++;
}
//echo "el numero de personas que respondieron d a la pregunta 2 son:".$contarp1b;
$porcendp2=($contarp2d/$contanoencuestas)*100;
//
$sql_rp2p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp2 = 'p' and codigoperiodo='20102'";
$resultadorp2p=mysql_query($sql_rp2p,$sala);
$contarp2p=0;
while ($filarp2p=mysql_fetch_array($resultadorp2p))
{
$contarp2p++;
}
//echo "el numero de personas que respondieron p a la pregunta 2 son:".$contarp1p;
$porcenpp2=($contarp2p/$contanoencuestas)*100;
//33333333333333333333333333333333333333333333333333333333333333333333333333333
//echo "el numero de personas que respondieron la pregunta 3 son:".$contarp1;
$sql_rp3e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp3 = 'e' and codigoperiodo='20102'";
$resultadorp3e=mysql_query($sql_rp3e,$sala);
$contarp3e=0;
while ($filarp3e=mysql_fetch_array($resultadorp3e))
{
$contarp3e++;
}
//echo "el numero de personas que respondieron e a la pregunta 3 son:".$contarp1e;
$porcenep3 =($contarp3e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp3b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp3 = 'b' and codigoperiodo='20102'";
$resultadorp3b=mysql_query($sql_rp3b,$sala);
$contarp3b=0;
while ($filarp3b=mysql_fetch_array($resultadorp3b))
{
$contarp3b++;
}
//echo "el numero de personas que respondieron b a la pregunta 3 son:".$contarp1b;
$porcenbp3=($contarp3b/$contanoencuestas)*100;
$np3=($porcenep3+$porcenbp3)/20;
//
$sql_rp3b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp3 = 'd' and codigoperiodo='20102'";
$resultadorp3d=mysql_query($sql_rp3b,$sala);
$contarp3d=0;
while ($filarp3d=mysql_fetch_array($resultadorp3d))
{
$contarp3d++;
}
//echo "el numero de personas que respondieron d a la pregunta 3 son:".$contarp1b;
$porcendp3=($contarp3d/$contanoencuestas)*100;
//
$sql_rp3p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp3 = 'p' and codigoperiodo='20102'";
$resultadorp3p=mysql_query($sql_rp3p,$sala);
$contarp3p=0;
while ($filarp3p=mysql_fetch_array($resultadorp3p))
{
$contarp3p++;
}
//echo "el numero de personas que respondieron p a la pregunta 3 son:".$contarp1p;
$porcenpp3=($contarp3p/$contanoencuestas)*100;
//4444444444444444444444444444444444444444444444444444444444444444444444444444
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp4e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp4 = 'e' and codigoperiodo='20102'";
$resultadorp4e=mysql_query($sql_rp4e,$sala);
$contarp4e=0;
while ($filarp4e=mysql_fetch_array($resultadorp4e))
{
$contarp4e++;
}
//echo "el numero de personas que respondieron e a la pregunta 4 son:".$contarp1e;
$porcenep4 =($contarp4e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp4b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp4 = 'b' and codigoperiodo='20102'";
$resultadorp4b=mysql_query($sql_rp4b,$sala);
$contarp4b=0;
while ($filarp4b=mysql_fetch_array($resultadorp4b))
{
$contarp4b++;
}
//echo "el numero de personas que respondieron b a la pregunta 4 son:".$contarp1b;
$porcenbp4=($contarp4b/$contanoencuestas)*100;
$np4=($porcenep4+$porcenbp4)/20;
//
$sql_rp4b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp4 = 'd' and codigoperiodo='20102'";
$resultadorp4d=mysql_query($sql_rp4b,$sala);
$contarp4d=0;
while ($filarp4d=mysql_fetch_array($resultadorp4d))
{
$contarp4d++;
}
//echo "el numero de personas que respondieron d a la pregunta 4 son:".$contarp1b;
$porcendp4=($contarp4d/$contanoencuestas)*100;
//
$sql_rp4p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp4 = 'p' and codigoperiodo='20102'";
$resultadorp4p=mysql_query($sql_rp4p,$sala);
$contarp4p=0;
while ($filarp4p=mysql_fetch_array($resultadorp4p))
{
$contarp4p++;
}
//echo "el numero de personas que respondieron p a la pregunta 4 son:".$contarp1p;
$porcenpp4=($contarp4p/$contanoencuestas)*100;
//555555555555555555555555555555555555555555555555555555555555555555555555555555
//echo "el numero de personas que respondieron la pregunta 5 son:".$contarp1;
$sql_rp5e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp5 = 'e' and codigoperiodo='20102'";
$resultadorp5e=mysql_query($sql_rp5e,$sala);
$contarp5e=0;
while ($filarp5e=mysql_fetch_array($resultadorp5e))
{
$contarp5e++;
}
//echo "el numero de personas que respondieron e a la pregunta 5 son:".$contarp1e;
$porcenep5 =($contarp5e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp5b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp5 = 'b' and codigoperiodo='20102'";
$resultadorp5b=mysql_query($sql_rp5b,$sala);
$contarp5b=0;
while ($filarp5b=mysql_fetch_array($resultadorp5b))
{
$contarp5b++;
}
//echo "el numero de personas que respondieron b a la pregunta 5 son:".$contarp1b;
$porcenbp5=($contarp5b/$contanoencuestas)*100;
$np5=($porcenep5+$porcenbp5)/20;
//
$sql_rp5b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp5 = 'd' and codigoperiodo='20102'";
$resultadorp5d=mysql_query($sql_rp5b,$sala);
$contarp5d=0;
while ($filarp5d=mysql_fetch_array($resultadorp5d))
{
$contarp5d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
$porcendp5=($contarp5d/$contanoencuestas)*100;
//
$sql_rp5p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp5 = 'p' and codigoperiodo='20102'";
$resultadorp5p=mysql_query($sql_rp5p,$sala);
$contarp5p=0;
while ($filarp5p=mysql_fetch_array($resultadorp5p))
{
$contarp5p++;
}
//echo "el numero de personas que respondieron p a la pregunta 5 son:".$contarp1p;
$porcenpp5=($contarp5p/$contanoencuestas)*100;
//66666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666
//echo "el numero de personas que respondieron la pregunta 6 son:".$contarp1;
$sql_rp6e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp6 = 'e' and codigoperiodo='20102'";
$resultadorp6e=mysql_query($sql_rp6e,$sala);
$contarp6e=0;
while ($filarp6e=mysql_fetch_array($resultadorp6e))
{
$contarp6e++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep6 =($contarp6e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp6b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp6 = 'b' and codigoperiodo='20102'";
$resultadorp6b=mysql_query($sql_rp6b,$sala);
$contarp6b=0;
while ($filarp6b=mysql_fetch_array($resultadorp6b))
{
$contarp6b++;
}
//echo "el numero de personas que respondieron b a la pregunta 6 son:".$contarp1b;
$porcenbp6=($contarp6b/$contanoencuestas)*100;
$np6=($porcenep6+$porcenbp6)/20;
//
$sql_rp6b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp6 = 'd' and codigoperiodo='20102'";
$resultadorp6d=mysql_query($sql_rp6b,$sala);
$contarp6d=0;
while ($filarp6d=mysql_fetch_array($resultadorp6d))
{
$contarp6d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
$porcendp6=($contarp6d/$contanoencuestas)*100;
//
$sql_rp6p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp6 = 'p' and codigoperiodo='20102'";
$resultadorp6p=mysql_query($sql_rp6p,$sala);
$contarp6p=0;
while ($filarp6p=mysql_fetch_array($resultadorp6p))
{
$contarp6p++;
}
//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;
$porcenpp6=($contarp6p/$contanoencuestas)*100;
//7777777777777777777777777777777777777777777777777777777777777777777777777777777777
//echo "el numero de personas que respondieron la pregunta 7 son:".$contarp1;
$sql_rp7e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp7 = 'e' and codigoperiodo='20102'";
$resultadorp7e=mysql_query($sql_rp7e,$sala);
$contarp7e=0;
while ($filarp7e=mysql_fetch_array($resultadorp7e))
{
$contarp7e++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep7 =($contarp7e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp7b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp7 = 'b' and codigoperiodo='20102'";
$resultadorp7b=mysql_query($sql_rp7b,$sala);
$contarp7b=0;
while ($filarp7b=mysql_fetch_array($resultadorp7b))
{
$contarp7b++;
}
//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;
$porcenbp7=($contarp7b/$contanoencuestas)*100;
$np7=($porcenep7+$porcenbp7)/20;
//
$sql_rp7b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp7 = 'd' and codigoperiodo='20102'";
$resultadorp7d=mysql_query($sql_rp7b,$sala);
$contarp7d=0;
while ($filarp7d=mysql_fetch_array($resultadorp7d))
{
$contarp7d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
$porcendp7=($contarp7d/$contanoencuestas)*100;
//
$sql_rp7p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp7 = 'p' and codigoperiodo='20102'";
$resultadorp7p=mysql_query($sql_rp7p,$sala);
$contarp7p=0;
while ($filarp7p=mysql_fetch_array($resultadorp7p))
{
$contarp7p++;
}
//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;
$porcenpp7=($contarp7p/$contanoencuestas)*100;
//8888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888888
//echo "el numero de personas que respondieron la pregunta 1 son:".$contarp1;
$sql_rp8e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp8 = 'e' and codigoperiodo='20102'";
$resultadorp8e=mysql_query($sql_rp8e,$sala);
$contarp8e=0;
while ($filarp8e=mysql_fetch_array($resultadorp8e))
{
$contarp8e++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep8 =($contarp8e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp8b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp8 = 'b' and codigoperiodo='20102'";
$resultadorp8b=mysql_query($sql_rp8b,$sala);
$contarp8b=0;
while ($filarp8b=mysql_fetch_array($resultadorp8b))
{
$contarp8b++;
}
//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;
$porcenbp8=($contarp8b/$contanoencuestas)*100;
$np8=($porcenep8+$porcenbp8)/20;
//
$sql_rp8b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp8 = 'd' and codigoperiodo='20102'";
$resultadorp8d=mysql_query($sql_rp8b,$sala);
$contarp8d=0;
while ($filarp8d=mysql_fetch_array($resultadorp8d))
{
$contarp8d++;
}
//echo "el numero de personas que respondieron d a la pregunta 8 son:".$contarp1b;
$porcendp8=($contarp8d/$contanoencuestas)*100;
//
$sql_rp8p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp8 = 'p' and codigoperiodo='20102'";
$resultadorp8p=mysql_query($sql_rp8p,$sala);
$contarp8p=0;
while ($filarp8p=mysql_fetch_array($resultadorp8p))
{
$contarp8p++;
}
//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;
$porcenpp8=($contarp8p/$contanoencuestas)*100;
//9999999999999999999999999999999999999999999999999999999999999999999999
//echo "el numero de personas que respondieron la pregunta 9 son:".$contarp1;
$sql_rp9e= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp9 = 'e' and codigoperiodo='20102'";
$resultadorp9e=mysql_query($sql_rp9e,$sala);
$contarp9e=0;
while ($filarp9e=mysql_fetch_array($resultadorp9e))
{
$contarp9e++;
}
//echo "el numero de personas que respondieron e a la pregunta 1 son:".$contarp1e;
$porcenep9 =($contarp9e/$contanoencuestas)*100;
//echo "el porsentaje de la pregunta 1 e".$porcentagep1;
//echo $porcenep1;
//
$sql_rp9b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp9 = 'b' and codigoperiodo='20102'";
$resultadorp9b=mysql_query($sql_rp9b,$sala);
$contarp19b=0;
while ($filarp9b=mysql_fetch_array($resultadorp9b))
{
$contarp9b++;
}
//echo "el numero de personas que respondieron b a la pregunta 1 son:".$contarp1b;
$porcenbp9=($contarp9b/$contanoencuestas)*100;
$np9=($porcenep9+$porcenbp9)/20;
//
$sql_rp9b= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp9 = 'd' and codigoperiodo='20102'";
$resultadorp9d=mysql_query($sql_rp9b,$sala);
$contarp9d=0;
while ($filarp9d=mysql_fetch_array($resultadorp9d))
{
$contarp9d++;
}
//echo "el numero de personas que respondieron d a la pregunta 1 son:".$contarp1b;
$porcendp9=($contarp9d/$contanoencuestas)*100;
//
$sql_rp9p= "SELECT  distinct codigoestudiante  FROM evafacultad where codigocarrera = '126' and resp9 = 'p' and codigoperiodo='20102'";
$resultadorp9p=mysql_query($sql_rp9p,$sala);
$contarp9p=0;
while ($filarp9p=mysql_fetch_array($resultadorp9p))
{
$contarp9p++;
}
//echo "el numero de personas que respondieron p a la pregunta 1 son:".$contarp1p;
$porcenpp9=($contarp9p/$contanoencuestas)*100;
$tnp=(($np1+$np2+$np3+$np4+$np5+$np6+$np7+$np8+$np9)/9);



?>


   </span>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="388" height="23" class="Estilo2 style1"><strong>RESULTADO FACULTAD</strong></td>
    <td width="334" class="Estilo2">&nbsp; 
      <table width="100%" border="1" bordercolor="#0066FF">
        <tr> 
          <td><strong>TOTAL = </strong><strong class="style1 style7"><?php printf ( "%.2f", $tnp) ; ?></strong></td>
        </tr>
      </table></td>
  </tr>
  <tr> 
    <td class="Estilo2"> <strong class="style1">N&Uacute;MERO QUE EVALUARON</strong> </td>
    <td class="Estilo2"><?php echo $contanoencuestas ?></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr bgcolor="#C5D5D6" class="style2"> 
    <td width="532" class="Estilo2"> <span class="style6"><strong>PREGUNTA</strong> </span></td>
    <td width="103" class="Estilo2">&nbsp;  </td>
    <td width="85" bgcolor="#C5D5D6" class="Estilo2"><div align="center"><span class="style6"><strong><span class="Estilo5">RESPUESTA<br>
        (%) </span><br>
        </strong></span></div></td>
  </tr>
  <tr bordercolor="#000000"> 
    <td class="Estilo2"><p class="style8">1. El estudiante siempre encuentra 
        en la Facultad una respuesta amable y oportuna a sus inquietudes por parte 
        de las directivas  
      </p></td>
    <td valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np1) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td class="style1 Estilo1 Estilo2"><table width="85" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep1) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp1) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp1) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp1) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">2. La Facultad se preocupa 
        por el desempeño y bienestar de sus estudiantes en el aspecto académico, 
        personal y humano.  </p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np2) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep2) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp2) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp2) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp2) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">3. El estudiante siempre encuentra 
        en la Facultad una respuesta amable y oportuna a sus inquietudes por parte 
        del personal administrativo  </p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np3) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep3) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp3) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp3) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp3) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">4. Las notas son publicadas 
        a tiempo por la Facultad</p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np4) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep4) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp4) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp4) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp4) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">5. 
        Los procedimientos administrativos de la facultad adecuados..  
      </p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np5) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep5) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp5) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp5) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp5) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">6. La Facultad genera espacios 
        academicos que refuercen las diferentes areas de aprendizaje (Congresos, 
        Seminarios, Conferencias  </p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np6) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep6) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp6) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp6) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp6) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">7. El estudiante siempre 
        encuentra los recursos audiovisuales adecuados para el normal desarrollo 
        de su actividad académica.</p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np7) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep7) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp7) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp7) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp7) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">8. La Bibliografía de las 
        diferentes asignaturas siempre se encuentra en la Biblioteca.  
      </p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np8) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep8) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp8) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp8) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp8) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="586" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr> 
    <td width="532" class="Estilo2"><p class="style8">9. El acceso a las salas 
        de computo y laboratorios, es el adecuado</p></td>
    <td width="103" valign="top" class="style8 Estilo1 Estilo2"> <div align="left"> 
        <p>&nbsp;</p>
        <table width="99" border="1" align="right" bordercolor="#0066FF">
          <tr> 
            <td><div align="center"><strong>NOTA</strong></div></td>
          </tr>
          <tr> 
            <td><div align="center"><strong class="style1 style7"><?php printf ( "%.2f", $np9) ; ?></strong>&nbsp;</div></td>
          </tr>
        </table>
        <p>&nbsp;</p>
      </div></td>
    <td width="85" class="style1 Estilo1 Estilo2"><table width="85" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
        <tr> 
          <td width="81"><div align="center" class="style2">E</div></td>
        </tr>
        <tr> 
          <td> <div align="center"><?php printf ( "%.2f", $porcenep9) ; ?>% 
              </div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">B</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenbp9) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">R</div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style8"> 
              <div align="center"></div>
            </div>
            <div align="center"><span class="style8"><?php printf ( "%.2f", $porcendp9) ; ?>%</span></div></td>
        </tr>
        <tr> 
          <td><div align="center" class="style2">M</div></td>
        </tr>
        <tr> 
          <td><div align="center"><span class="style8"><?php printf ( "%.2f", $porcenpp9) ; ?>%</span></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<table width="586" border="0" align="center">
  <tr>
    <td class="Estilo2">OBSERVACIONES</td>
  </tr>
  <tr>
    <td class="Estilo2"><?php 
$sql_rp10b= "SELECT  resp10  FROM evafacultad where codigocarrera = '126' and codigoperiodo='20102'";
$resultadorp10d=mysql_query($sql_rp10b,$sala);
//$contarp10d=0;
while ($filarp10d=mysql_fetch_array($resultadorp10d))
{
echo $filarp10d['resp10']."<br>";
} 
?>&nbsp;</td>
  </tr>
  <tr>
    <td class="Estilo2"><div align="center"><font size="1" face="tahoma">
      <input name="imprimir" type="button" id="buton" value="Imprimir" onClick="print()">
    </font></div></td>
  </tr>
</table>
<span class="Estilo2">
<?php
/*include ("jpgraph.php");
include ("jpgraph_bar.php");

//$datay=array(5,40,48,20);

// Create the graph. These two calls are always required
$graph = new Graph(300,200,"auto");    
$graph->SetScale("textlin");

// Add a drop shadow
$graph->SetShadow();

// Adjust the margin a bit to make more room for titles
$graph->img->SetMargin(40,30,20,40);

// Create a bar pot
$bplot = new BarPlot($datay);
$graph->Add($bplot);

// Create and add a new text
$txt=new Text("This is a text");
$txt->Pos(0,0);
$txt->SetColor("red");
$graph->AddText($txt);


// Setup the titles
$graph->title->Set("A simple bar graph");
$graph->xaxis->title->Set("X-title");
$graph->yaxis->title->Set("Y-title");

$graph->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);

// Display the graph
$graph->Stroke();*/
?>
</span>
<p class="Estilo1">&nbsp;</p>
<p align="center">&nbsp;</p>
</body>
</html>