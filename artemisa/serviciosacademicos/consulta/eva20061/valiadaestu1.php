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
  <form name="form1" method="post" action="valiadaestu1.php">
    <table width="346" border="1" align="center">
      <tr bgcolor="#E4F3F0">
        <td colspan="2"><div align="center">
          <p class="Estilo1">Si desea deshabilitar la evaluación del algún estudiante<br> 
            <span class="Estilo2">digite la cedula</span></p>
          </div></td>
      </tr>
      <tr>
        <td width="208"><div align="center">
          <input name="ceduli" type="text" id="ceduli">        
        </div></td>
        <td width="122"><div align="center">
          <input type="submit" name="Submit" value="Enviar">
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
  //if(!(isset ($ceduli)))
 
   $evinst="SELECT idestudiantegeneral FROM estudiantegeneral WHERE numerodocumento='$ceduli'";
	  $rdoc=mysql_query($evinst,$sala);
     $tdoc=mysql_fetch_assoc($rdoc);
	 
	 $codili=$tdoc['idestudiantegeneral'];
	 echo $codili;
	  $tuig="INSERT INTO respuestas VALUES('','$codili','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','','',20061)";
	  mysql_query($tuig,$sala);
	  echo $tuig;
	  $ceduli=0; 
	  echo "este estudiante ya no tiene que  presentar evaluacion";
	 
	
   
  ?>
</div>
</body>
</html>
