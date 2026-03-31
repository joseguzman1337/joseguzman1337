<? 
 include "direccionador.inc.php"; 
 include Obtener_Direccion(0)."conexion.inc";  
 Conexion();

 include Obtener_Direccion(0)."identif.php";
 Bibliotecario();
 	
?>  
<html>

<head>
<title>Pagina nueva 1</title>
</head>


<body>

<?
    include Obtener_Direccion(0)."fgenped.php";
    include Obtener_Direccion(0)."fgentrad.php";
    
    $Mensajes = Comienzo ("sus-001",$IdiomaSitio);  
    $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
?>

<script language="JavaScript">
function recargo(Letra)
{
	form1.action = "elige_us_bib.php?Letra="+Letra;
	form1.submit();
}

function retornaSin()
{
	form1.action = "indexcom2.php";
	form1.submit();
}


</script>    


<form method="POST" name="form1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnSubmit="recargo(form1.Busca.value)">
  <div align="center">
    <center>
  <table border="0" width="90%" bgcolor="#66CCFF">
    <tr>
      <td width="100%" colspan="2" align="center" bgcolor="#FFFFCC"><b><font face="MS Sans Serif" size="1" color="#155CAA"><? echo $Mensajes["tf-1"]; ?><? echo $Letra; ?></font></b></td>
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
  <input type="button" value="Z" name="B28" OnClick="recargo('Z')"><font face="MS Sans Serif" size="1"><b><br>
  <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="Boton" OnClick="retornaSin()"></b></font></p>
  <input type="hidden" name="dedonde" value="<? echo $dedonde; ?>">
      </td>
    </tr>
    <tr>
      <td width="22%"><input type="text" name="Busca" size="30" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold">
      </td>
    </tr>
    <tr>
      <td width="22%"><input type="button" value="<? echo $Mensajes["bot-2"] ?>" name="Enviar" OnClick="recargo(form1.Busca.value)"></td>
    </tr>
  </table>
    </center>
  </div>
</form>

<p>

<?   
   $expresion = "SELECT Apellido,Nombres,Instituciones.Nombre,Dependencias.Nombre";
   $expresion = $expresion.",Unidades.Nombre,Usuarios.Login,Usuarios.Password,Usuarios.Id,Instituciones.Codigo,Usuarios.Email FROM Usuarios";
   $expresion = $expresion." LEFT JOIN Instituciones ON Instituciones.Codigo=Usuarios.Codigo_Institucion";
   $expresion = $expresion." LEFT JOIN Dependencias ON Dependencias.Id=Usuarios.Codigo_Dependencia";
   $expresion = $expresion." LEFT JOIN Unidades ON Unidades.Id=Usuarios.Codigo_Unidad";
   $expresion = $expresion." WHERE Usuarios.Apellido LIKE '".$Letra."%' ";
   switch ($Bibliotecario)
   {
   	case 1:
		$expresion.="AND Usuarios.Codigo_Institucion=".$Instit_usuario;
		break;
	case 2:
		$expresion.="AND Usuarios.Codigo_Dependencia=".$Dependencia;
		break;
	case 3:
		$expresion.="AND Usuarios.Codigo_Unidad=".$Unidad;
		break;
   }
   
   $expresion.=" ORDER BY Apellido,Usuarios.Nombres";
   $result = mysql_query($expresion);
   echo mysql_error();
   
    while($row = mysql_fetch_row($result))
     {
?></p>
<div align="center">
  <center>


<table border="0" width="90%" cellspacing="0" height="63">
  <tr>
     <td width="1%" bgcolor="#1C74A4" height="21" valign="middle">&nbsp;
     <td width="25%" bgcolor="#1C74A4" height="21" valign="middle" colspan="2">
     
     <? switch ($dedonde)
        {
        case 1:
         
       ?>
           <a href="..\pedidos\agrega_ped_alias.php?alias=1&Alias_Id=<? echo $row[7]; ?>&Alias_Comunidad=<? echo $row[0].",".$row[1]; ?>&Instit_Alias=<? echo $row[8]; ?>">
     <?  break; 
         
        case 2:
        
      ?>     
           <a href="..\pedidos\manpedushist.php?Id_Alias=<? echo $row[7]; ?>&Modo=1&fila=0&Alias_Comunidad=<? echo $row[0].",".$row[1]; ?>">
     <?   break;
     
     	  case 3:
     ?>
       <a href="form_usu_bib.php?Id=<? echo $row[7]; ?>&operacion=1">       
     <?
         break;
        case 4:   
	 ?>			  	
	 	 <a href="..\mail\form_mail.php?Id_Usuario=<? echo $row[7]; ?>&Nom_Usu=<? echo $row[0].",".$row[1]; ?>&mail=<? echo $row[9]; ?>">       
	 <?  break;
	 
	    case 5:
	  ?>
		 <a href="..\mail\cons_mail.php?Id_Usuario=<? echo $row[7]; ?>&Nom_Usu=<? echo $row[0].",".$row[1]; ?>">       
	 <?   
	  } 
     ?>
      <b>
      <font face="MS Sans Serif" size="1" color="#00FFFF">
      <?echo $row[0].",".$row[1] ; ?></font>
      </b></a>
     <td width="40%" bgcolor="#1C74A4" height="21" valign="middle"><font face="MS Sans Serif" size="1" color="#FFFFFF"><?echo
      $row[2]."-".$row[3]."-".$row[4]; ?></font>
     <td width="29%" bgcolor="#1C74A4" height="21" valign="middle">
     <font face="MS Sans Serif" size="1" color="#00FFFF">
     <? echo $row[5]."-".$row[6]; ?></font>
  </tr>
  <tr>
    <td width="1%" height="8" colspan="2"></td>
    <td width="25%" height="8"></td>
    <td width="40%" height="8"></td>
    <td width="29%" height="8"></td>
  </tr>
</table>
  </center>
</div>
<?
   }
   mysql_free_result($result);
   Desconectar();	
?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>sus-001</FONT></P>

</body>

</html>



































