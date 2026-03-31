<html>
<head>
<title>Celsius Software</title>
</head>

<body background="../imagenes/banda.jpg">
<p>
<? 
     
    include_once "fgentrad.php";	
    include_once "fgenped.php";
  
    if ($estado_login==3)
     {
	  $Mensajes = Comienzo ("lge-001",$IdiomaSitio);  
 
     
     ?>
      <table border="0" width="100%">
      <tr>
      <td width="100%">
      <p align="center"><img border="0" src="../imagenes/zapallo.jpg" width="212" height="185"></td>
      </tr>
      <tr>
      <td width="100%">
       <p align="center"><b><font face="MS Sans Serif" size="2" color="#800000"><? echo $Mensajes["tf-1"]; ?><a href="login.php"><BR>
       <? echo $Mensajes["h-1"]; ?></a></font></b></td>
      </tr>
    </table>
 
 
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>lge-001</FONT>
<P>



</body>
</html>
