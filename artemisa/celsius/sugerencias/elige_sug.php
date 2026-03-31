<?
    include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";

   
   global $IdiomaSitio;
   $Mensajes = Comienzo ("esu-001",$IdiomaSitio);
 ?>
<html>

<head>
<title>PrEBi</title>
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
}
body, td, th {
	color: #000000;
}
a:link {
	color: #006599;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #006599;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #006599;
}
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 11px;
}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
a.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
}
.style35 {color: #CCCCCC}
.style36 {color: #666666}
.style37 {font-size: 11px; font-family: verdana;}
-->
</style>
</head>
<?
	if (isset($Mensajes["con-1"]))	
		$mensaje = $Mensajes["con-1"];
		else
		$mensaje = "Con esta operación eliminará la Sugerencia seleccionada. Confirma la Operación?";

?>
<script language="JavaScript">
 function confirmar()
 {
 	if (confirm("<? echo $mensaje;?>"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }
</script>

<body background="../Imagenes/banda.jpg">


<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
		<form method=post name='dateForm' action="/celsius_gonzalo//noticias/elige_not.php?Inicio=0&Fin=0&fila_actual=0">

      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
	  
      <tr>
        <td valign="top">            <div align="center">
              <center>
<?   

   if (	!isset($operacion)) {$operacion = 0;}
 
	   if ($operacion==2)
   		{
   			$expresion = "DELETE FROM Sugerencias WHERE Id=".$Id;
		   $result = mysql_query($expresion);
   		
   		}
   
	   $expresion = "SELECT Titulo,Comentario,Id FROM Sugerencias";
   
   $result = mysql_query($expresion);
?>


<div align="center">
<center>
<table width="95%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
     <tr bgcolor="#006699">
                    <td height="" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tit-1"]?> </span><div align="center" class="style34 style35"></div></td>
                    </tr>
	 <?
     $contador=0; 
     while($row = mysql_fetch_row($result))
     {  //  <table width="95%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
   ?>    
			
			<tr><td align="center"><br>
			 <table width="90%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td height="20" colspan="2" bgcolor="#0099CC" class="style34"><img src="../images/square-w.gif" width="8" height="8"><?echo  $row[0];?> </td>
                  </tr>
				  <tr>
                    <td colspan="2" class="style22"><div align="left"><?echo $row[1];?> </div></td>
                  </tr>
                  <tr class="style33">
                    <td><div align="center" class="style33">&nbsp;</div></td>
                    <td><div align="center" class="style33"><a href="form_suger.php?operacion=1&Id=<? echo $row[2]; ?>"><? echo $Mensajes["ele-1"]?></a> |<a href="elige_sug.php?operacion=2&Id=<? echo $row[2]; ?>" onClick="return confirmar()"><? echo $Mensajes["ele-2"]?>  </a> </div></td>
                    </tr>
			  </table></td></tr>
              
    <?
    }
    ?> <tr><td align="center">&nbsp; </td></tr></table></center>  
  &nbsp;
</div>

<?
   mysql_free_result($result);
   Desconectar();
?>

                </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left">
            <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                      <td bgcolor="#ECECEC"><div align="center">
                          <p><img src="../images/image001.jpg" width="150" height="118"><br>
                              <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]?></a></span></p>
                      </div></td>
                    </tr>
                  </table>
                  </div></td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="43" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">esu-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>

