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
<title>Documento sin t&iacute;tulo</title>
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
  require("pconexionbase.php");
  //if(!(isset ($ceduli)))
  if($ceduli=='')
  {
  echo "debe digitar una cedula";
  
  } 
  
  else
  {
   $evinst="SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento='$ceduli'";
	 $rdoc=mysql_query($evinst,$sala) or die(mysql_error.$evinst);
     $tdoc=mysql_fetch_array($rdoc);
	 
	 
	 $fccc=$tdoc['idestudiantegeneral'];
	 //echo $fccc.'no existe';
	   if ($fccc=='')
	      {
	 echo "este estudiante no existe";
	      }
	      else
	       {
	 //$codili=$tdoc['idestudiantegeneral'];
	  $tuig="INSERT INTO respuestas VALUES('','$fccc','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',20061)";
	  mysql_query($tuig,$sala) or die(mysql_error.$tuig);
	  //echo $trg.grabo;
	  $ceduli=0; 
	  echo "Este estudiante ya NO tiene que presentar evaluaciónAAA";
	        }
}
   
  ?>
</div>
</body>
</html>
