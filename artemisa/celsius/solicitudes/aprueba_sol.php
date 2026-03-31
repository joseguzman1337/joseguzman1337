<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #006599;
	margin-left: 10px;
	margin-right:0px; margin-top:0px; margin-bottom:0px
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style60 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style1 {	color: #FFFFFF;
	font-family: Verdana;
	font-size: 10px;
}
.style61 {color: #000000}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 

  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";  
  Conexion();
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."identif.php"; 
	Administracion();
   global $IdiomaSitio;
   $Mensajes = Comienzo ("aus-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);

  
   
?>
<script language="JavaScript">
function aprueba(Id)
{
  if (document.forms.form1.AbrPais.value.length>0 && document.forms.form1.AbrInstit.value.length>0)
  {
    document.forms.form1.action="agrega_usuario.php";
    document.forms.form1.elements.Operacion.value=0;
    document.forms.form1.elements.Id.value = Id;
    document.forms.form1.submit();
  }
  else
  {
   alert ("<? echo $Mensajes["me-14"]; ?>");
  }  
}

function corrige(Id)
{
  document.forms.form1.action="add_cand1.php";
  document.forms.form1.elements.dedonde.value=1;
  
  document.forms.form1.elements.Id.value=Id;

  document.forms.form1.submit();

}

function rechaza(Id)
{
  document.forms.form1.action="rechaza.php";
  document.forms.form1.elements.Id.value=Id;
  document.forms.form1.elements.Operacion.value=0;
  document.forms.form1.submit();

}
</script>
<?   
   $expresion = "SELECT Apellido,Nombres,EMail,Paises.Nombre,Otro_Pais,Instituciones.Nombre,Otra_Institucion,";
   $expresion = $expresion."Dependencias.Nombre,Otra_Dependencia,Unidades.Nombre,Otra_Unidad,Tab_Categ_usuarios.Nombre,";
   $expresion = $expresion."Otra_Categoria,Candidatos.Direccion,Localidades.Nombre,Otra_Localidad,";
   $expresion = $expresion."Candidatos.Telefonos,Candidatos.Comentarios,Fecha_Registro,";
   $expresion = $expresion."Candidatos.Codigo_Pais,Candidatos.Codigo_Localidad,Candidatos.Codigo_Institucion,Candidatos.Codigo_Dependencia,Candidatos.Codigo_Unidad,Candidatos.Codigo_Categoria";
   $expresion = $expresion.",Paises.Abreviatura,Instituciones.Abreviatura FROM Candidatos ";
   $expresion = $expresion."LEFT JOIN Instituciones ON  Candidatos.Codigo_Institucion = Instituciones.Codigo ";
   $expresion = $expresion."LEFT JOIN Dependencias ON Candidatos.Codigo_Dependencia = Dependencias.Id ";
   $expresion = $expresion."LEFT JOIN Unidades ON Candidatos.Codigo_Unidad = Unidades.Id ";
   $expresion = $expresion."LEFT JOIN Paises ON Candidatos.Codigo_Pais = Paises.Id ";
   $expresion = $expresion."LEFT JOIN Localidades ON Candidatos.Codigo_Localidad = Localidades.Id ";
   $expresion = $expresion."LEFT JOIN Tab_Categ_usuarios ON Candidatos.Codigo_Categoria = Tab_Categ_usuarios.Id ";
   $expresion = $expresion."WHERE Candidatos.Id = ".$Id;
   $result = mysql_query($expresion);
   //echo $expresion;
   $row = mysql_fetch_row($result);
   
   list($Login,$Clave) = LoginyPassword($row[1],$row[0]);
  
?>


<form method="POST" name="form1">

<div align="left">
    <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#E4E4E4">
                  <tr align="left" valign="middle" bgcolor="#66CCFF">
                    <td height="20" bgcolor="#006699"><div align="center" class="style28"> 
                      <div align="left" class="style1"><img src="../images/square-lb.gif" width="8" height="8"><? echo $Mensajes["et-2"]; ?></div>
                    </div></td>
                  </tr>
                  <tr align="left" valign="middle">
                    <td><table width="100%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-1"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[0]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-2"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[1]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-3"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[2]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-4"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><? if (strlen($row[3])==0){echo $Mensajes["oma-1"];} else {echo $row[3];} ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-5"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[4]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-19"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
                            <input type="text" name="AbrPais" class="style55" size="20" value="<? echo $row[25]; ?>">

                          </div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-6"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? if (strlen($row[5])==0){echo $Mensajes["ofe-1"];} else {echo $row[5];} ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-7"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[6]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-20"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left">
                            <input type="text" name="AbrInstit" class="style55" size="20" value="<? echo $row[26]; ?>">

                          </div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-8"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? if (strlen($row[7])==0){echo $Mensajes["ofe-1"];} else {echo $row[7];} ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-9"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><?echo $row[8]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-10"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? if (strlen($row[9])==0){echo $Mensajes["ofe-1"];} else {echo $row[9];} ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-11"]; ?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[10]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-12"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? if (strlen($row[11])==0){echo $Mensajes["ofe-1"];} else {echo $row[11];} ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-13"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[12]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-14"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[13]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-15"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? if (strlen($row[14])==0){echo $Mensajes["ofe-1"] ;} else {echo $row[14];} ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-16"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[15]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-17"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[16]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-18"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left"><? echo $row[17]; ?></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-21"]; ?></div></td>
                          <td bgcolor="#ECECEC" class="style55"><div align="left">
						  <?
						  $instruccion2="select id,nombre from Forma_Pago ";
						  $result2=mysql_query($instruccion2);
						  ?>
						  <select  class="style55" size="1" name="FormaPago">						  
                             <?
							 while ($rownuevo=mysql_fetch_row($result2))
							 {
							  ?>
							  <option value="<? echo $rownuevo[0];?>"><? echo $rownuevo[1]; ?></option>
							  <?
							 }
							 ?>						  
        </select></div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-22"]?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
                  <input type="text" name="Login" size="30" class="style55" value = "<? echo $Login; ?>" >

                          </div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-23"]?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left">
                      <input type="text" name="Password" size="30" class="style55" value ="<? echo $Clave; ?>">

                          </div></td>
                        </tr>
                        <tr>
                          <td width="170" height="18" bgcolor="#CCCCCC" class="style1"><div align="right" class="style61"><? echo $Mensajes["ec-26"]?></div></td>
                          <td height="18" bgcolor="#ECECEC" class="style55"><div align="left"><select name="Bibliotecario" class="style55">
	    <option value="0"><? echo $Mensajes["tf-2"]; ?></option>
	  	<option value="1"><? echo $VectorIdioma["Perfil_Biblio_1"]; ?></option>
		<option value="2"><? echo $VectorIdioma["Perfil_Biblio_2"]; ?></option>
		<option value="3"><? echo $VectorIdioma["Perfil_Biblio_3"]; ?></option>
	  </select></div></td>
                        </tr>
                        <tr align="center" bgcolor="#ECECEC">
                          <td height="30" colspan="2" class="style1"><div align="center">
                              <input type="button"  value="<? echo $Mensajes["bot-5"]?>" name="Submit" class="style55" OnClick="aprueba(<? echo $Id; ?>)">
        <input type="button"  class="style55" value="<? echo $Mensajes["bot-6"]?>" name="Corrige"  OnClick="corrige(<? echo $Id; ?>)">
		<input type="button"  class="style55" value="<? echo $Mensajes["bot-7"]?>" name="Rechaza"  OnClick="rechaza(<? echo $Id; ?>)">
        
							  
							  							  
                          </div></td>
                        </tr>
                    </table></td>
                  </tr>
                </table>
                </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td valign="top" class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style60"><a href="../admin/indexadm.php"><? echo $Mensajes["h-3"];?> </a></span></div>                <div align="center" class="style55"></div></td>
            </tr>
          </table>
          </div>
          </td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">us-001</div></td>
        </tr>
      </table>
	  <input type = "hidden" name="Apellido" value = "<? echo $row[0]; ?>">
		<input type = "hidden" name="Nombre" value = "<? echo $row[1]; ?>">		    
		<input type = "hidden" name="Mail" value = "<? echo $row[2]; ?>">		    
		<input type = "hidden" name="CodigoPais" value = "<? echo $row[19]; ?>">		    
		<input type = "hidden" name="OtroPais" value = "<? echo $row[4]; ?>">		    
		<input type = "hidden" name="CodigoLocalidad" value = "<? echo $row[20]; ?>">		    
		<input type = "hidden" name="OtraLocalidad" value = "<? echo $row[15]; ?>">		    
		<input type = "hidden" name="CodigoInstitucion" value = "<? echo $row[21]; ?>">		    
		<input type = "hidden" name="OtraInstitucion" value = "<? echo $row[6]; ?>">		    
		<input type = "hidden" name="CodigoDependencia" value = "<? echo $row[22]; ?>">		    
       <input type = "hidden" name="OtraDependencia" value = "<? echo $row[8]; ?>">		    
       <input type = "hidden" name="CodigoUnidad" value = "<? echo $row[23]; ?>">		    
       <input type = "hidden" name="OtraUnidad" value = "<? echo $row[10]; ?>">		    
       <input type = "hidden" name="CodigoCategoria" value = "<? echo $row[24]; ?>">		    
       <input type = "hidden" name="OtraCategoria" value = "<? echo $row[12]; ?>">		    
       <input type = "hidden" name="Direccion" value = "<? echo $row[13]; ?>">		    
       <input type = "hidden" name="Telefono" value = "<? echo $row[16]; ?>">		    
       <input type = "hidden" name="Comentarios" value = "<? echo $row[17]; ?>">		           
		<input type = "hidden" name="FechaSolicitud" value = "<? echo $row[18]; ?>">
		<input type = "hidden" name="Id">
		<input type = "hidden" name="dedonde">		    
        <input type = "hidden" name="Operacion">	
      </div></td>
  </tr>
</table>
<?	
   Desconectar();
?>
</FORM>

</div>
</body>
</html>