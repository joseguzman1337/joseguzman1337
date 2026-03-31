<?
  
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   include_once "../inc/fgenped.php";
   include_once "../inc/fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("eco-002",$IdiomaSitio);
   
 ?>

<html>

<head>
<title>PrEBi</title>
<base target="_self">
<style>
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
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 9px;
}
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
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr>
        <td valign="top">       
		<div align="center">
              <center>

<?
   $Vector = upload ($Archivo);
   if (!isset($Contenidos)) { $Contenidos = 0;}
   if (!isset($Nombre)) { $Nombre = 0;}
   if ($Vector[0]!="" && $Contenidos!=0 && $Nombre!="")
   {
   		$Dia = date ("d");
   		$Mes = date ("m");
   		$Anio = date ("Y");
   		$FechaHoy =$Anio."-".$Mes."-".$Dia;

   		$Instruccion = "INSERT INTO ElemContenidos (Id_Contenido,Nombre,Orden,Archivo_Elemento,Tipo,Tamanio) VALUES(".$Contenidos.",'".$Nombre."',".$Orden.",'".$Vector[0]."',".$Vector[1].",".$Vector[2].")";	
		$result = mysql_query($Instruccion); 
   		echo mysql_error();
?>

<?
	   if (mysql_affected_rows()>0)
   { ?>
   			 <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" width="100" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-1"]; ?></td>
                    <td height="20" class="style33"><span class="style34"><? echo $Nombre; ?></span></td>
                    </tr>
                  <tr bgcolor="#006699">
                    <td height="20" width="100" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-5"]; ?></span></td>
                    <td height="20" class="style33"><span class="style34"><? echo $Orden; ?></span></td>
                    </tr>
                  <tr bgcolor="#006699">
                    <td height="20" width="100" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["ec-6"]; ?></span></td>
                    <td height="20" class="style33"><span class="style34"><? echo $Vector[0]; ?></span></td>
                    </tr>
  		    </table>

<?
	} else	{
     ?>	 <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["me-1"]; ?></td>
                    </tr>
         </table>  
	   <? 
	}
  }
  else
  {
  	?>	 <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33" bgcolor="#ECECEC"><? echo $Mensajes["me-2"]; ?></td>
                    </tr>
         </table>  
	   <? 
  }

?>


  </center>
</div>

<div align="center">
  <center>
  <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33" bgcolor="#ECECEC"  align="center">
					<a href="form_econt.php?dedonde=0"><? echo $Mensajes["h-1"]; ?></a></td>
                    </tr>
         </table>  
  </center>
</div>
<?
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
                              <span class="style33"><A href="../admin/indexadm.php"><? echo $Mensajes["h-2"];?></a></span></p>
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
            <div align="center">eco-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>


