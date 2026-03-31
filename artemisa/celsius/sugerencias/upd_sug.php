<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
    include_once "../inc/"."fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("usu-001",$IdiomaSitio);
   
   
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
<base target="_self">
</head>
<body topmargin="0">
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

   if ($operacion == '0')
   {   
    $Instruccion = "INSERT INTO Sugerencias (Titulo,Comentario) VALUES('".$Titulo."','".$Comentario."')";	
   }
   else
   {
   	 $Instruccion = "UPDATE Sugerencias SET Titulo='".$Titulo."',Comentario='".$Comentario."' WHERE Id=".$Id;	
   } 
   
   $result = mysql_query($Instruccion); 
   
   if ($operacion == '0')
			$Id = mysql_insert_id();

   if (mysql_affected_rows()>0)
    { ?>
	   <table width="95%"  border="0" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr>
                    <td height="20" colspan="2" bgcolor="#0099CC" class="style34"><img src="../images/square-w.gif" width="8" height="8"> <?echo $Titulo;?></td>
                  </tr>
				  <tr>
                    <td colspan="2" class="style22"><div align="left"><?echo $Comentario;?> </div></td>
                  </tr>
				  <tr>
                    <td colspan="2" class="style22"><div align="left"><? echo $Mensajes["ec-1"]?>&nbsp;<?echo $Id;?></div></td>
                  </tr>
               </table>

<?
	} else	{
	?>
				<table width="95%"  border="0" cellpadding="1" cellspacing="1" >
                  <tr>
                    <td colspan="2" class="style22"><div align="left"><? echo $Mensajes["er-1"]?></td>
                  </tr>
               </table>
	<?

	}
   Desconectar();
?>
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
                              <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-1"]; ?></a></span></p>
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
            <div align="center">usu-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>






