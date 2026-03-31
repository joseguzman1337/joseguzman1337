<?
   include_once "../inc/var.inc.php";
   include_once "../inc/"."parametros.inc.php";
   include_once "../inc/"."conexion.inc.php";
   Conexion();	
   include_once "../inc/"."identif.php";
   Administracion();
   global  $IdiomaSitio ; 
 
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?></title>
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
.style39 {color: #006699}
.style40 {
	color: #FFFFFF;
	font-family: Verdana;
	font-size: 11px;
}
.style41 {color: #006599}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
 
 
  $Mensajes = Comienzo ("pau-002",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
  
   
?>
<script language="JavaScript">
function enviar_campos (){
// Estos campos los envío para presentarle al usuario

      if (document.forms.form1.Unidades.selectedIndex>=0)
      {
        document.forms.form1.UnidadDesc.value=document.forms.form1.Unidades.options[document.forms.form1.Unidades.selectedIndex].text;
       }
       else
      {
      	 document.forms.form1.UnidadDesc.value="<? echo $Mensajes["me-1"];?>";
       }  
      
      if (document.forms.form1.Localidad.selectedIndex>=0)
      {
       document.forms.form1.LocalidadDesc.value=document.forms.form1.Localidad.options[document.forms.form1.Localidad.selectedIndex].text;			  
      }
      else
      {
      	document.forms.form1.LocalidadDesc.value="<? echo $Mensajes["me-1"];?>";
      } 
      return null;			    
}

function verifica_campos()
{
	enviar_campos();
	document.forms.form1.action = "upd_usuario.php";
	document.forms.form1.submit();
}

</script>


<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <form name="form1" method="POST"  onSubmit ="return false">
       <input type="hidden" name="Desc_Loc"><input type="hidden" name="Desc_Inst">
	  <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">            <div align="center">
              <center>
                <table width="97%">
                  <tr>
                    <td height="20" colspan="2" align="right" valign="middle" bgcolor="#006699" class="style22"><div align="left" class="style40"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?></div></td>
                    </tr>
                  <tr>
				  <?
 // Borro slashes porque viene del form anterior
 $Apellido = stripslashes($Apellido);
 $Nombres = stripslashes($Nombres);
 

?>  

                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-2"]; ?></div></td>
                    <td width="*" height="20" align="left" valign="top" class="style33" >
                      <div align="left"><? echo $Apellido; ?></div></td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-3"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33">
                      <div align="left"><? echo $Nombres; ?></div></td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-4"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33">
                      <div align="left"><? echo $InstDesc; ?></div></td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-5"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33"><? echo $DepDesc; ?></td>
                  </tr>
                  
				  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? 
					
					echo $Mensajes["et-1"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33">
					<select size="1" name="Unidades" class="style22">
									<?
						  $Instruccion = "SELECT Id,Nombre FROM Unidades WHERE Codigo_Dependencia=".$Dependencias." ORDER BY Nombre";
						   $result = mysql_query($Instruccion); 
						   if (mysql_num_rows($result)>0)
						   {
							  while ($row =mysql_fetch_row($result))
							  {
							   if ($row[0]==$Unidadval){    
								 echo "<option selected id='unidad_actual' value='".$row[0]."'>".$row[1]."</option>";}
							 else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
										
							  }
						   }
						   else
						   {echo "<option value='0' selected id='unidad_actual'>Ninguna</option>";}
						 ?>
						   <script>
						  // document.getElementById('unidad_actual').selected = true;
						</script>
						</select>
					</td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-2"]; ?></div></td>
                    <td height="20" align="left" valign="top" class="style33"><select name="Localidad" size="1" class="style22">
						 <?
						  $Instruccion = "SELECT Id,Nombre FROM Localidades WHERE Codigo_Pais=".$Paises." ORDER BY Nombre";	
						  $result = mysql_query($Instruccion); 
						  
						  while ($row =mysql_fetch_row($result))
						  {  
							 if ($row[0]==$Localidadval){    
										echo "<option selected id='localidad_actual' value='".$row[0]."'>".$row[1]."</option>";}
							 else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
										
						   }       
						 ?>

						</select>
						<script>
							//document.getElementById('localidad_actual').selected = true;
						</script>
						</td>
                  </tr>
                  <tr>
                    <td width="30%" align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-3"]; ?></div></td>
                    <td height="20" align="left" valign="top"><? if ($operacion==0)
						{
						   list($Loginv,$Passwordv) = LoginyPassword(str_replace("'","",$Nombres),str_replace("'","",$Apellido));
						} 
					   ?> 
					  <input type="text"  class="style22" name="Login" size="30" value = "<? echo $Loginv; ?>" ></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-4"]; ?></td>
                    <td height="20" align="left" valign="top"><input type="text" name="Password" class="style22" size="30" value ="<? echo $Passwordv; ?>"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-5"]; ?></td>
                    <td height="20" align="left" valign="top"><input type="checkbox" name="Administracion" value="ON" <? if ($Personalval==1) { echo "checked"; } ?>></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-7"]; ?></td>
                    <td height="20" align="left" valign="top"><select name="Bibliotecario" class="style22">
						<option value="0"<? if ($Bibliotecarioval==0) { echo " selected "; } ?>><? echo $Mensajes["tf-6"]; ?></option>
						<option value="1"<? if ($Bibliotecarioval==1) { echo " selected "; } ?>><? echo $VectorIdioma["Perfil_Biblio_1"]; ?></option>
						<option value="2"<? if ($Bibliotecarioval==2) { echo " selected "; } ?>><? echo $VectorIdioma["Perfil_Biblio_2"]; ?></option>
						<option value="3"<? if ($Bibliotecarioval==3) { echo " selected "; } ?>><? echo $VectorIdioma["Perfil_Biblio_3"]; ?></option>
					  </select></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-8"]; ?></td>
                    <td height="20" align="left" valign="middle"><input type="checkbox" class="style22" name="Staff" value="ON" <? if ($Staffval==1) { echo "checked"; } ?>></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-9"]; ?></td>
                    <td height="20" align="left" valign="top"><input type="text" name="OrdenStaff" size="2" value="<? if ($OrdenStaffval!="") { echo $OrdenStaffval; } else { echo "0"; }  ?>"></td>
                  </tr>
                  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-10"]; ?></td>
                    <td height="20" align="left" valign="middle"><input type="text" name="CargoStaff" class="style22" size="30" value="<? echo $CargoStaffval  ?>"></td>
                  </tr>
					<? if ($operacion==0)
						{ ?>
							<input type="hidden" name="Contabilizar" value="ON">
						<? } ?>
				  <tr>
                    <td align="right" valign="middle" bgcolor="#CCCCCC" class="style22"><? echo $Mensajes["et-6"]; ?></td>
                    <td height="20" align="left" valign="top"><textarea rows="6" class="style22" name="Comentarios" cols="36"><? echo $Comentariosval; ?></textarea></td>
                  </tr>
    
                  <tr>
                    <td colspan="2" class="style22"><div align="right"></div>                      
                      <div align="center">
                  <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" onClick="verifica_campos()" class="style22">
	   <input type="reset" value="<? echo $Mensajes["bot-2"]; ?>" name="B2" class="style22">
	  <input type="hidden" name="Apellido" value="<? echo $Apellido ?>">
      <input type="hidden" name="Nombres" value="<? echo $Nombres ?>">
      <input type="hidden" name="Mail" value="<? echo $Mail ?>">
      <input type="hidden" name="Paises" value=<? echo $Paises ?>>
      <input type="hidden" name="Instituciones" value=<? echo $Instituciones; ?>>
      <input type="hidden" name="Dependencias" value=<? echo $Dependencias; ?>>
      <input type="hidden" name="Direccion" value="<? echo $Direccion ?>">
      <input type="hidden" name="Telefono" value="<? echo $Telefono ?>">
      <input type="hidden" name="Categoria" value=<? echo $Categoria ?>>

	   <input type="hidden" name="InstDesc" value="<? echo $InstDesc ?>">
      <input type="hidden" name="DepDesc" value="<? echo $DepDesc ?>">
      <input type="hidden" name="UnidadDesc">
      <input type="hidden" name="LocalidadDesc">
      <input type="hidden" name="FormaPagoDesc">

      <input type="hidden" name="operacion" value=<? echo $operacion ?>>
	  <input type="hidden" name="Id" value="<? echo $Id; ?>">
	
      </form>
    
					  </div></td>
                    </tr>
                </table>
              </center>
            </div>            </td>
      
		<td width="150" valign="top" bgcolor="#Ececec"><div align="center" class="style22">
          <div align="left">
        	
			<table width="97%"  border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td><div align="center">
                  <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php"><span class="style33"><? echo $Mensajes['txt-1']; ?></span></a></p>
                  </div>                  </td>
              </tr>
            </table>
            </div>
        </div></td>
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?
   include_once "../inc/barrainferior.php";
   DibujarBarraInferior($IdiomaSitio)

  ?>
  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">pau-002</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>