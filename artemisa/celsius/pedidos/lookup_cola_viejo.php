<? 

include_once "../inc/"."conexion.inc.php";  
Conexion();
include_once "../inc/var.inc.php";
include_once "../inc/"."identif.php";
Administracion();
 	
?>  

<html>

<head>
<title><? echo Titulo_Sitio();?></title>
</head>

<script language="JavaScript">
function AgregaColecc()
{
	form1.Id.value="<? echo $Id; ?>";
    form1.operacion.value=1;
	form1.action = "lookup_cola.php";
	form1.Titulo_Revista.value = "<? echo $Titulo_Revista; ?>";
	form1.submit();
}

function recargo(Letra)
{
	form1.Letra.value=Letra;
	form1.CantAutor.value="<? echo $CantAutor; ?>";
	form1.Id.value="<? echo $Id; ?>";
	form1.operacion.value=0;
	form1.action = "lookup_cola.php";	
	form1.Titulo_Revista.value = "<? echo $Titulo_Revista; ?>";
	form1.submit();
}

function retornaSin()
{
    form1.action = "verped_col.php?CantAutor=<?echo $CantAutor; ?>&Id_Col=0";
	form1.submit();
}

function retornaAgrega(valor)
{	    
	form1.Id_Col.value = valor;
    form1.action = "verped_col.php";
	form1.submit();
}

</script>    


<body>
<? 
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("tes-001",$IdiomaSitio);  
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
 
   
 if ($operacion==0)
  {
  
//  $Titulo_Revista=stripslashes($Titulo_Revista);
  
 
?>
<form method="POST" name="form1" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnSubmit="recargo(form1.Busca.value)">
  <div align="center">
    <center>
  <table border="0" width="90%" bgcolor="#66CCFF">
    <tr>
      <td width="100%" colspan="2" align="center" bgcolor="#FFFFCC"><b><font face="MS Sans Serif" size="1" color="#155CAA"><? echo $Mensajes["tf-1"]; ?> <? echo $Letra; ?></font></b></td>
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
  <font face="MS Sans Serif" size="1"><b>
  <input type="button" value="<? echo $Mensajes["bot-1"]; ?>" name="Boton" OnClick="retornaSin()">
  <input type="button" value="<? echo $Mensajes["bot-3"]; ?>" name="Agrega" OnClick="AgregaColecc()"></b></font></p>
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
  <input type="hidden" name="CantAutor" value="<? echo $CantAutor; ?>">
  <input type="hidden" name="dedonde" value=<? echo $dedonde; ?>>
  <input type="hidden" name="adonde" value=<? echo $adonde; ?>>
  <input type="hidden" name="Letra" value="<? echo $Letra; ?>">
  <input type="hidden" name="Id" value="<? echo $Id; ?>">
  <input type="hidden" name="Alias_Id" value=<? if (!isset($Alias_Id)){$Alias_Id=0;}echo $Alias_Id; ?>>
  <input type="hidden" name="Instit_Alias" value=<? if (!isset($Instit_Alias)){$Instit_Alias=0;} echo $Instit_Alias; ?>>
  <input type="hidden" name="Alias_Comunidad" value="<? echo $Alias_Comunidad; ?>">
  <input type="hidden" name="operacion">
  <input type="hidden" name="Titulo_Revista" value=<? echo $Titulo_Revista; ?>> 
  <input type="hidden" name="Id_Col">
  <input type="hidden" name="Tabla" value="<? echo $Tabla; ?>">
  
<div align="center">
  <table border="0" width="90%" bgcolor="#0099CC">
    <tr>
      <td width="100%" align="left" bgcolor="#0099CC">
        <p align="left"><b><font face="MS Sans Serif" size="1" color="#FFFFFF"><? echo $Mensajes["tf-3"]; ?></font></b><font face="MS Sans Serif" size="1" color="#FFFFFF"><b>&nbsp;&nbsp;
        </b><? echo $Titulo_Revista; ?></font></p>
      </td>
  <center>
    </tr>
  </table>
  </center>
</div>


  
</form>

<p>

<?
   $expresion = "SELECT Nombre,Abreviado,Id FROM Titulos_Colecciones WHERE Nombre LIKE '".AddSlashes($Letra)."' ORDER BY Nombre";
   $result = mysql_query($expresion);
   echo mysql_error();
   
    while($row = mysql_fetch_row($result))
     {
?></p>
<div align="center">
  <center>


<table border="0" width="582" cellspacing="0">
  <tr>
     <td width="8" bgcolor="#1C74A4" height="18" valign="middle">&nbsp;
     <td width="328" bgcolor="#1C74A4" height="18" valign="middle"><font face="MS Sans Serif" size="1" color="#FFFFCC">
     <a href="verped_col.php?CantAutor=<? echo $CantAutor; ?>&Id_Col=<? echo $row[2]; ?>&Id=<? echo $Id; ?>&dedonde=<? echo $dedonde; ?>&adonde=<? echo $adonde; ?>&Titulo_Recien_Llegado=<? echo $row[0]; ?>&Tabla=<? echo $Tabla; ?>" style="color: #FFFFCC"><?echo $row[0] ; ?></a></font>
     <td width="238" bgcolor="#1C74A4" height="18" valign="middle"><font face="MS Sans Serif" size="1" color="#FFFFFF"><?echo $row[1]; ?></font>
  </tr>
  <tr>
    <td width="561" height="9" colspan="3"><font face="MS Sans Serif" size="1" color="#FFFFCC">&nbsp;</font></td>
  </tr>
</table>
  </center>
</div>
<?
    }
  
 mysql_free_result($result);
 Desconectar();
  
 } 
 
 else 
 {
 
 	
    $Instruccion = "INSERT INTO Titulos_Colecciones(Nombre,Abreviado,ISSN) VALUES('".AddSlashes($Titulo_Revista)."','','')";	
    $result = mysql_query($Instruccion);  
     
    if (mysql_affected_rows()>0) {     
	
    $Id_Col = mysql_insert_id();

	// Le saco los slashes porque vuelve al form 
    $Titulo_Revista = stripslashes($Titulo_Revista);
      ?>
<P ALIGN="center"><IMG BORDER="0" SRC="../imagenes/logoeventos.jpg"></P>
     <div align="center">
     <center>
     <table border="0" width="77%" cellspacing="0" cellpadding="0" style="font-family: MS Sans Serif; font-size: 10 px" height="112">
    <tr>
      <td width="3%" bgcolor="#CCCCFF" height="52" valign="middle" align="left">&nbsp;&nbsp;&nbsp;</td>
      <td width="132%" bgcolor="#CCCCFF" height="52" valign="middle" align="left"><font face="MS Sans Serif" size="2"><b><? echo $Mensajes["tf-4"]; ?>
        <font color="#0000FF"> 
        <? echo $Titulo_Revista; ?></font> </b></font></td>
      <td width="1%" bgcolor="#CCCCFF" height="52" valign="top" align="left">&nbsp;</td>
    </tr>
    <tr>
      <td width="3%" bgcolor="#CCCCFF" height="15" valign="middle" align="center">&nbsp;</td>
      <td width="132%" bgcolor="#CCCCFF" height="15" valign="middle" align="center">
        <form method="POST" name="form1">        
        
         <input type="hidden" name="CantAutor" value="<? echo $CantAutor; ?>">
		  <input type="hidden" name="dedonde" value=<? echo $dedonde; ?>>
		  <input type="hidden" name="adonde" value=<? echo $adonde; ?>>
		  <input type="hidden" name="Letra" value="<? echo $Letra; ?>">
		  <input type="hidden" name="Id" value="<? echo $Id; ?>">
		  <input type="hidden" name="operacion">
		  <input type="hidden" name="Titulo_Recien_Llegado" value="<? echo $Titulo_Revista; ?>"> 
		  <input type="hidden" name="Tabla" value="<? echo $Tabla; ?>">
		  <input type="hidden" name="Id_Col">
  
          <p>
          <input type="button" value="<? echo $Mensajes["bot-4"]; ?>" name="retorna" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="retornaAgrega(<? echo $Id_Col; ?>)">
          <input type="button" value="<? echo $Mensajes["bot-5"]; ?>" name="B2" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="javascript:self.close()">
          </p>
        </form>
      </td>
      <td width="1%" bgcolor="#CCCCFF" height="15" valign="top" align="center">&nbsp;&nbsp;&nbsp;</td>
    </tr>
</table>

  </center>
</div>
<?


   }
   else
   {
?>
<p align="center">&nbsp;</p>
<p ALIGN="center"><IMG BORDER="0" SRC="../imagenes/logoeventos.jpg"></p>
<div align="center">
  <center>
<table border="1" width="80%" bgcolor="#800000">
  <tr>
    <td width="100%" align="center"><b><font face="MS Sans Serif" size="2" color="#FFFFCC"><? echo $Mensajes["err-1"]; ?></font></b>
      <p><input type="button" value="<? echo $Mensajes["bot-5"]; ?>" name="B2" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" OnClick="javascript:self.close()">
    </td>
  </tr>
</table>	
   
  </center>
</div>
   
<?   
	}
  Desconectar();


}
?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#155CAA">cp:</FONT>tes-001</FONT></P>

</body>

</html>























