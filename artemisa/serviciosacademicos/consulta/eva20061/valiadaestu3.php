<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>EVALUACION</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 12px;
}
.Estilo2 {color: #006600}
-->
</style>
</head>

<body>
<div align="center">
  <form name="form1" method="post" action="valiadaestu.php">
      <table width="346" border="1" align="center">
      <tr bgcolor="#E6EEEC">
        <td colspan="2"><div align="center"><span class="Estilo1">Si desea deshabilitar la evaluaci&oacute;n del alg&uacute;n estudiante<br>
            <span class="Estilo2">digite la cedula</span></span></div></td>
      </tr>
      <tr>
        <td width="208"><div align="center">
          <input name="ceduli" type="text" id="ceduli">        
        </div></td>
        <td width="122"><div align="center">
          <input type="submit" name="Submit" value="Deshabilitar">
        </div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
  <?php 
  include("pconexionbase.php");

	$r = mysql_query("SELECT DATABASE()") or die (mysql_error());
	//echo "<br>Base".mysql_result($r,0);
  //echo $ceduli;
  //if(!(isset ($ceduli)))
  if($ceduli=='')
  {
  echo "debe digitar una cedula";
  
  } 
  
  else
  {
   $evinst="SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento='$ceduli'";
	 $teoc=mysql_db_query($database_sala,$evinst,$sala) or die(mysql_error());
     $idegen=mysql_fetch_array($teoc);
	 //echo "<br>".mysql_info($sala);
	 //echo "<br>".$database_sala;
	 $tomelo=$idegen['idestudiantegeneral'];
	 
	 $tener="SELECT codigoestudiante FROM respuestas WHERE codigoestudiante='$tomelo'";
	 $tino=mysql_db_query($database_sala,$tener,$sala) or die(mysql_error());
     $serve=mysql_fetch_array($tino);
	 //echo "<br>".mysql_info($sala);
	 
	 $exite=$serve['codigoestudiante'];
	 
	 //echo $exite;
	//echo $tomelo;
	 //echo $fccc.'no existe';
	   if ($tomelo=='')
	      {
	 echo "este estudiante no existe o <br>";
	      }
		  if ($tomelo==$exite && $tomelo!='' && $exite!='')
	      {
	 echo "ya habia sido desabilitado";
	      }
	      else
	       {
	 //$codili=$tdoc['idestudiantegeneral'];
	  $tuig="INSERT INTO respuestas VALUES('','$tomelo','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',20061)";
	  $res=mysql_db_query($database_sala,$tuig,$sala) or die(mysql_error());
	  //echo "<br>".$tuig;
	  //echo "<br>".mysql_affected_rows();
	  //echo "<br>".mysql_info();
	  $ceduli=0; 
	  //echo $tuig;
	  echo "Este estudiante ya NO tiene que presentar evaluación";
	        }
}
   
  ?>
</div>
</body>
</html>
