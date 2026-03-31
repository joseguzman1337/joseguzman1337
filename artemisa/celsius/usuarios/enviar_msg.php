<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   global  $IdiomaSitio ;   
 ?>
<html>

<head>
<title><? echo Titulo_Sitio(); ?></title>
</head>

<script language="JavaScript">
function recargo(Letra)
{
	document.forms.form1.action = "enviar_msg.php?Letra="+Letra;
	document.forms.form1.submit();
}

function retornaSin()
{
	document.forms.form1.action = "../admin/indexadm.php";
	document.forms.form1.submit();
}


</script>    


<body>
<?
    include_once "../inc/"."fgenped.php";
    include_once "../inc/"."fgentrad.php";
    $Mensajes = Comienzo ("sus-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>
<form method="POST" name="form1" OnSubmit="recargo(form1.Busca.value)">
  <div align="center">
    <center>
  <table border="0" width="90%" bgcolor="#66CCFF">
    <tr>
      <td width="100%" colspan="2" align="center" bgcolor="#FFFFCC"><b><font face="MS Sans Serif" size="1" color="#155CAA"><? echo $Mensajes["tc-1"]." ".$Letra; ?></font></b></td>
    </tr>
    <tr>
      <td width="22%"><font face="MS Sans Serif" size="1"><b><font color="#155CAA"><? echo $Mensajes["tf-2"]; ?>&nbsp;
        </font> &nbsp;&nbsp; </b></font>&nbsp;</td>
      <td width="78%" rowspan="3">
  <p align="center">
  <input type="button" value="A" name="B3" OnClick="recargo('A')">
  <input type="button" value="B" name="B4" OnClick="recargo('B')">
  <input type="button" value="C" name="B5" OnClick="recargo('C')">
  <input type="button" value="D" name="B6" OnClick="recargo('D')">
  <input type="button" value="E" name="B7" OnClick="recargo('E')">
  <input type="button" value="F" name="B8" OnClick="recargo('F')">
  <input type="button" value="G" name="B9" OnClick="recargo('G')">
  <input type="button" value="H" name="B10" OnClick="recargo('H')" >
  <input type="button" value="I" name="B11" OnClick="recargo('I')">
  <input type="button" value="J" name="B12" OnClick="recargo('J')">
  <input type="button" value="K" name="B13" OnClick="recargo('K')">
  <input type="button" value="L" name="B14" OnClick="recargo('L')">
  <input type="button" value="M" name="B15" OnClick="recargo('M')">
  <input type="button" value="N" name="B16" OnClick="recargo('N')"><br>
  <input type="button" value="O" name="B17" OnClick="recargo('O')">
  <input type="button" value="P" name="B18" OnClick="recargo('P')">
  <input type="button" value="Q" name="B19" OnClick="recargo('Q')">
  <input type="button" value="R" name="B20" OnClick="recargo('R')">
  <input type="button" value="S" name="B21" OnClick="recargo('S')">
  <input type="button" value="T" name="B22" OnClick="recargo('T')">
  <input type="button" value="U" name="B23" OnClick="recargo('U')">
  <input type="button" value="V" name="B24" OnClick="recargo('V')">
  <input type="button" value="W" name="B25" OnClick="recargo('W')">
  <input type="button" value="X" name="B26" OnClick="recargo('X')">
  <input type="button" value="Y" name="B27" OnClick="recargo('Y')">
  <input type="button" value="Z" name="B28" OnClick="recargo('Z')">
  <font face="MS Sans Serif" size="1">
  <b><input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="Boton" OnClick="retornaSin()"></b></font></p>
      </td>
    </tr>
    <tr>
      <td width="22%"><input type="text" name="Busca" size="30" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold">
      </td>
    </tr>
    <tr>
      <td width="22%"><input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="Enviar" OnClick="recargo(form1.Busca.value)"></td>
    </tr>
  </table>
    </center>
  </div>
</form>

<p>

<?   
   $expresion = "SELECT Apellido,Nombres,Instituciones.Nombre,Dependencias.Nombre";
   $expresion = $expresion.",Unidades.Nombre,Usuarios.Login,Usuarios.Password,Usuarios.Id,Personal,Bibliotecario FROM Usuarios";
   $expresion = $expresion." LEFT JOIN Instituciones ON Instituciones.Codigo=Usuarios.Codigo_Institucion";
   $expresion = $expresion." LEFT JOIN Dependencias ON Dependencias.Id=Usuarios.Codigo_Dependencia";
   $expresion = $expresion." LEFT JOIN Unidades ON Unidades.Id=Usuarios.Codigo_Unidad";
   $expresion = $expresion." WHERE Usuarios.Apellido LIKE '".$Letra."%' ORDER BY Apellido,Usuarios.Nombres";
   $result = mysql_query($expresion);
   echo mysql_error();
   
    while($row = mysql_fetch_row($result))
     {
?></p>
<div align="center">
  <center>

<?
	$color = "#1C74A4";
	if ($row[8]==1)
	{
		$color = "#993333";
	}
	elseif ($row[9]>=1)
	{
		$color = "#669999";
	}
	

?> 

<table border="0" width="90%" cellspacing="0" height="63">
  <tr>
     <td width="1%" bgcolor="<? echo $color; ?>" height="21" valign="middle">&nbsp;
     <td width="25%" bgcolor="<? echo $color; ?>" height="21" valign="middle" colspan="2"><font face="MS Sans Serif" size="1" color="#FFFFCC">
      <b>
      <?echo $row[0].",".$row[1] ; ?></b></font>
     <td width="40%" bgcolor="<? echo $color; ?>" height="21" valign="middle"><font face="MS Sans Serif" size="1" color="#FFFFFF">
     <? echo $row[2]."-".$row[3]."-".$row[4]; ?></font>
     <td width="29%" bgcolor="<? echo $color; ?>" height="21" valign="middle">
     <font face="MS Sans Serif" size="1" color="#00FFFF">
     <? echo $row[5]."-".$row[6]; ?></font>
  </tr>
  <tr>
    <td width="1%" height="15" colspan="2"></td>
    <td width="25%" height="15"></td>
    <td width="40%" height="15"><font face="MS Sans Serif" size="1">
	
    <a href="escribir_msg.php?idUsuario=<?echo $row[7] ?>&usuario=<? echo $row[0].', '.$row[1] ?>"><? echo $Mensajes["h-2"]; ?></a></font></td>
    <td width="29%" height="15"><font face="MS Sans Serif" size="1"></font></td>
  </tr>
</table>
  </center>
</div>
<?
   }
   mysql_free_result($result);
   Desconectar();
?>
<tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">
      <hr>
       
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="33" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">pau-003</div></td>
        </tr>
      </table>
    </div></td>
  </tr>

</body>

</html>
