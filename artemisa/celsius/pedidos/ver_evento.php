<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<?

 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";
 Conexion();
 include_once "../inc/"."identif.php";
 Usuario();

?>
<html>
<head>
<? include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
?>
<script language="JavaScript">
</script>
<?
   global $IdiomaSitio;
   $Mensajes = Comienzo ("gen-eve",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);


   $Instruccion = "SELECT Codigo_Evento,Fecha,Observaciones,Es_Privado,Numero_Paginas,";
   $Instruccion = $Instruccion."Paises.Nombre,Instituciones.Nombre,Dependencias.Nombre,Usuarios.Apellido,Usuarios.Nombres,Id_Pedido";
   switch($Tabla)
   {
    case 1:
		$Instruccion.=" FROM Eventos";
		$Instruccion.=" LEFT JOIN Paises ON Paises.Id=Eventos.Codigo_Pais";
   		$Instruccion.=" LEFT JOIN Instituciones ON Eventos.Codigo_Institucion=Instituciones.Codigo";
   		$Instruccion.=" LEFT JOIN Usuarios ON Usuarios.Id=Eventos.Operador";
   		$Instruccion.=" LEFT JOIN Dependencias ON Dependencias.Id=Eventos.Codigo_Dependencia WHERE Eventos.Id='".$Id."'";
		break;
	case 2:
		$Instruccion.=" FROM EvHist";
		$Instruccion.=" LEFT JOIN Paises ON Paises.Id=EvHist.Codigo_Pais";
   		$Instruccion.=" LEFT JOIN Instituciones ON EvHist.Codigo_Institucion=Instituciones.Codigo";
   		$Instruccion.=" LEFT JOIN Usuarios ON Usuarios.Id=EvHist.Operador";
   		$Instruccion.=" LEFT JOIN Dependencias ON Dependencias.Id=EvHist.Codigo_Dependencia WHERE EvHist.Id='".$Id."'";
		break;
	case 3:
		$Instruccion.=" FROM EvAnula";
		$Instruccion.=" LEFT JOIN Paises ON Paises.Id=EvAnula.Codigo_Pais";
   		$Instruccion.=" LEFT JOIN Instituciones ON EvAnula.Codigo_Institucion=Instituciones.Codigo";
   		$Instruccion.=" LEFT JOIN Usuarios ON Usuarios.Id=EvAnula.Operador";
   		$Instruccion.=" LEFT JOIN Dependencias ON Dependencias.Id=EvAnula.Codigo_Dependencia WHERE EvAnula.Id='".$Id."'";
   }
//echo $Instruccion;
   $result = mysql_query($Instruccion);
   echo mysql_error();
   $row = mysql_fetch_row($result);

?>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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
	color: #000000;
	text-decoration: none;
}
a:visited {
	text-decoration: none;
	color: #000000;
}
a:hover {
	text-decoration: underline;
	color: #0099FF;
}
a:active {
	text-decoration: none;
	color: #000000;
}
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.style42 {color: #FFFFFF; font-size: 9px; font-family: verdana; }
-->
</style>

<body>
<br>
<div align="center">
  <table width="500"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ececec">
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? if (!isset($CamposFijos)) { $CamposFijos = array('');}
if (isset($CamposFijos[200])) {
echo $CamposFijos[200][0];} ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      </td>
      <td width="30" align="center" valign="top" bgcolor="#ECECEC"><div align="center">
      </div></td>
    </tr>
    <tr bgcolor="#D4D0C8">
       <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right">&nbsp;
       </div> </td>
    </tr>
    <tr bgcolor="#D4D0C8">
          <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right">
          <? echo $Mensajes["ec-1"]; ?>
         </div></td>
      <td align="left" valign="middle" bgcolor="#ececec" class="style23">
          <? echo $row[10]; ?>
      </td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23">
          <div align="right"><? echo $Mensajes["tf-1"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
      <input type="text" name="Evento" value="<? echo Devolver_Evento($row[0],$VectorIdioma); ?>" class="style23" size="40">
      </td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-2"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec"><input type="text" name="Pais" value="<? echo $row[5]; ?>" class="style23" size="40"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-3"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec"><input type="text" name="Institucion" value="<? echo $row[6]; ?>" class="style23" size="40"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-4"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec"><input type="text" name="Dependencia" value="<? echo $row[7]; ?>" class="style23" size="40"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-5"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec"><input type="text" name="Operador" value="<? echo $row[8].", ".$row[9]; ?>" class="style23" size="40"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-6"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">
	  <input type="checkbox" name="Es_Privado" value="ON" <? if($row[3]==1) { echo "checked"; } ?> class="style23" ></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-7"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">    <input type="text" name="fecha_evento" value="<? echo $row[1]; ?>" size="40" class="style23"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-8"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec">    <input type="text" name="Numero_Paginas" value="<? echo $row[4]; ?>" size="40" class="style23"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-11"]; ?></div></td>
      <td align="left" valign="middle" bgcolor="#ececec"> <textarea rows="3" name="Observaciones" class="style23" cols="40"><? echo $row[2];?></textarea></td>
    </tr>
    <tr bgcolor="#D4D0C8">
    <td width="150" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right">&nbsp;</div></td>
    <td align="left" valign="middle" bgcolor="#ececec"> <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B1" class="style23" OnClick="self.close()">
    </td>
    </tr>
 </table>
 </div>
</body>
</html>
 
