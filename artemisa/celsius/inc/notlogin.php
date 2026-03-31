<?
   

  include_once "./conexion.inc.php";
  Conexion();

  //include_once Obtener_Direccion(0)."fgenped.php";
  include_once "./fgentrad.php";


  $Mensajes = Comienzo ("notlogi",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
     
?>
<html>

<head>
<title>Celsius Software</title>
</head>

<body background="../imagenes/banda.jpg">

<br>
<br>

<div align="center">
  <center>

<table border="0" width="75%" cellspacing="0" cellpadding="0">
  <tr>
    <td width="100%">
      <p align="center"><img border="0" src="../imagenes/zapallo.jpg"></p>
    </td>
  </tr>
  <tr>
    <td width="100%"></td>
  </tr>
  <tr>
    <td width="100%">
      <p align="center"><font face="MS Sans Serif" size="2" color="#FF0000"><b><? echo $Mensajes["mensaj"];?></b></font></p>
    </td>
  </tr>
  <tr>
  <tr>
  	<td>&nbsp;</td>
  </tr>
  <td valign="top">
      <p align="center">
      <font face="MS Sans Serif" color="#000080" size="1">cp:</font><font face="MS Sans Serif" size="1" color="#000000">notlogi</font></p>
    </td>
  </tr>	
</table>

  </center>
</div>

</body>
<? 
  Desconectar();?>

</html>
