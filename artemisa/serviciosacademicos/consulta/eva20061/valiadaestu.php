<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require("../../Connections/sala2.php");
session_start();
mysql_select_db($database_sala, $sala);   
//echo $_SESSION['codigo'],"session";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Tahoma;
	font-size: 12px;
}
.Estilo3 {color: #FF0000}
-->
</style>
</head>

<body>
<div align="center">
  <form name="form1" method="get" action="valiadaestu.php">
    <table width="346" border="1" align="center">
      <tr bgcolor="#E6EEEC">
        <td colspan="2"><div align="center"><span class="Estilo1">Si desea deshabilitar la evaluaci&oacute;n del alg&uacute;n estudiante<br>
            <span class="Estilo3">digite la cedula</span></span></div></td>
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
  mysql_select_db($database_sala, $sala);
  //if(!(isset ($ceduli)))
  $ceduli=$_POST['ceduli'];
  //$ceduli=$_SESSION['ceduli'];
  echo "hola".$ceduli;
  if($ceduli=='')
  {
  echo "debe digitar una cedula";
  
  } 
  
  else
  {
   $evinst="SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento='$ceduli'";
	 $teoc=mysql_query($evinst,$sala) or die(mysql_error.$evinst);
     $idegen=mysql_fetch_array($teoc);
	 
	 
	 $tomelo=$idegen['idestudiantegeneral'];
	 //echo $fccc.'no existe';
	   if ($tomelo=='')
	      {
	 echo "este estudiante no existe";
	      }
	      else
	       {
	 //$codili=$tdoc['idestudiantegeneral'];
	  $tuig="INSERT INTO respuestas VALUES('','$tomelo','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',20102)";
	  mysql_query($tuig,$sala) or die(mysql_error.$tuig);
	  //echo $trg.grabo;
	  $ceduli=0; 
	  //echo $tuig;
	  echo "Este estudiante ya NO tiene que presentar evaluación";
	        }
}
   
  ?>
</div>
</body>
</html>
