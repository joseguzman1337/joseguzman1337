<?
  include_once "../inc/var.inc.php";
  include_once "../inc/conexion.inc.php";  
  Conexion();	
  include_once "../inc/identif.php"; 
  Administracion();

  include_once "../inc/fgenped.php";
  include_once "../inc/fgentrad.php";
  include_once "../inc/pidu.inc.php";
  if (! isset($Id))		$Id="";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("fin-001",$IdiomaSitio);
   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
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
.style34 {
	color: #FFFFFF;
	font-weight: normal;
	font-family: Verdana;
	font-size: 11px;
}

a.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
-->
</style>
<base target="_self">
</head>
<script language="JavaScript">
tabla_Localidades = new Array;
tabla_valores = new Array;
tabla_Longitud = new Array; 
<? armarScriptLocalidades("tabla_Localidades" , "tabla_valores" ,"tabla_Longitud")?>
function Generar_Localidades (valor){     


    			Codigo_pais=document.forms.form1.Codigo_pais.options[document.forms.form1.Codigo_pais.selectedIndex].value;    			
     			document.forms.form1.Localidad.length =tabla_Longitud[Codigo_pais]+1;
     			indice =0;
    			
    			if (document.forms.form1.Codigo_pais.length==0) 
    			 {
    			 	form1.Localidad.length=1;
    			 	i=0;
    			 }
    			else 
    			{ 
     			 for (i=0;i<tabla_Longitud[Codigo_pais];i++)
                {             	
                 document.forms.form1.Localidad.options[i].text=tabla_Localidades [Codigo_pais][i];
                 document.forms.form1.Localidad.options[i].value=tabla_valores [Codigo_pais][i];
                 if (document.forms.form1.Localidad.options[i].value==valor)
                  { indice = i }
                }       
                document.forms.form1.Localidad.length=i;	 
              } 
     			
              document.forms.form1.Localidad.selectedIndex=indice;
			    return null;
		}	    
		
function enviar_campos (){
// Estos campos los envío para presentarle al usuario
 
   document.forms.form1.DescPais.value=document.forms.form1.Codigo_pais.options[document.forms.form1.Codigo_pais.selectedIndex].text;
   document.forms.form1.DescLocal.value=document.forms.form1.Localidad.options[document.forms.form1.Localidad.selectedIndex].text;			  
   return null;			    
}     

</script>
<?   
	If ($dedonde==1)
	{	
	  $expresion = "SELECT Codigo,Nombre,Abreviatura,Direccion,Codigo_Pais";
	  $expresion = $expresion. ",Codigo_Localidad,Participa_Proyecto,Figura_Portal,Figura_Home";
	  $expresion = $expresion. ",Orden_Portal,Telefono,Sitio_Web,Codigo_Pedidos,Comentarios,Predeterminada, tipo_pedido_nuevo ";
	  $expresion .= " FROM Instituciones WHERE Codigo=".$Id;
	  $result = mysql_query($expresion);
	  
	  $rowg = mysql_fetch_array($result);
	 } 
	  
?>
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
        <td valign="top">            <div align="center">
              <center>

			  <form name="form1" method="POST" action="update_instit.php?dedonde=<? echo $dedonde; ?>&Id=<? echo $Id; ?>" onSubmit="enviar_campos()">
				<input type ="hidden" name="DescPais">
				<input type ="hidden" name="DescLocal"> 

                <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["ec-1"]; ?> </span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="2" cellspacing="0" class="style22">
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style42"><? echo $Mensajes["et-1"]; ?></div></td>
                          <td class="style22"><div align="left">
                            <select  class="style22" name="Codigo_pais" onChange="Generar_Localidades(0)" size=1>

							  <?
								  $Instruccion = "SELECT * FROM Paises ORDER BY Nombre";	
								  $result = mysql_query($Instruccion); 
								  
								  while ($row =mysql_fetch_row($result))
								  { 
									 if ($row[0]==$rowg[4])
									 {?>
										<option value="<?echo $row[0];?>" selected><?echo $row[1];?></option>
									  <? } else { ?>
									   <option value="<?echo $row[0];?>"><?echo $row[1];?></option>
									 <?
										}  
									  } ?> 	       							  
                            </select></div></td>
                        </tr>
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style33 style41">
                            <div align="right" class="style22"><? echo $Mensajes["et-2"]; ?></div>
                          </div></td>
                          <td class="style22"> <div align="left"><select  name="Localidad" class="style22">
                          </select></div></td>
                        </tr>
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style42">
                            <div align="right"><? echo $Mensajes["et-3"]; ?></div>
                          </div></td>
                          <td class="style22"><div align="left"><input type="text" name="Nombre" class="style22" size="50" value="<? if ( isset($rowg))echo $rowg[1]; ?>"></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-4"]; ?> </div></td>
                          <td class="style22"><div align="left"><input name="Abreviatura" value="<? if ( isset($rowg))echo $rowg[2]; ?>" size="7" class="style22" ></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-5"]; ?> </div></td>
                          <td class="style22"><div align="left"><input  class="style22" type="checkbox" name="ParticipaProyecto" value="ON" <? if(isset($rowg) && ($rowg[6]==1)) { echo " checked"; } ?>></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-6"]; ?> </div></td>
                          <td class="style22"><div align="left"><input  class="style22" type="checkbox" name="FiguraPortal" value="ON" <? if (isset($rowg) &&($rowg[7]==1)) { echo " checked"; } ?>></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-7"];  ?></div></td>
                          <td class="style22"><div align="left"><input class="style22"  type="checkbox" name="FiguraHome" value="ON" <? if (isset($rowg) &&($rowg[8]==1)) { echo " checked"; } ?>></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-8"]; ?> </div></td>
                          <td class="style22"><div align="left">
						   <input type="text" name="OrdenPortal" value="<? if (isset($rowg))echo $rowg[9];  ?>" size="7" class="style22" ></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right">Predeterminada</div></td>
                          <td class="style22"><div align="left"> <input type="checkbox" name="Predeterminada" class="style22" value="ON" <? if (isset ($rowg) && ($rowg[14]==1)) { echo " checked"; } ?>></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right">Tipo Pedido</div></td>
                          <td class="style22"><div align="left"><SELECT NAME="tipo_pedido_nuevo" class="style22"><option value="1" <?if ($rowg[15]==1){ echo "selected";} ?>>Busqueda</option><option value="2" <?if ($rowg[15]==2){ echo "selected";} ?>>Provision</option></SELECT> </div></td>
                        </tr>

						<tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-9"]; ?></div></td>
                          <td class="style22"><div align="left"><input type="text" name="Direccion" size="41" value="<? if (isset($rowg)) echo $rowg[3]; ?>" class="style22"></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-10"]; ?></div></td>
                          <td class="style22"><div align="left"><input type="text" name="Telefono" size="41" value="<? if (isset($rowg)) echo $rowg[10]; ?>" class="style22"></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-11"]; ?> </div></td>
                          <td class="style22"><div align="left"><input type="text" name="SitioWeb" size="44" value="<? if (isset($rowg)) echo $rowg[11]; ?>" class='style22'> </div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-12"]; ?> </div></td>
                          <td class="style22"><div align="left"><input type="text" name="Codigo_Pedidos" value="<? if ($dedonde==0) { echo 0; } else {echo $rowg[12]; }?>" size="9" class="style22"></div></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-13"]; ?> </div></td>
                          <td class="style22"><div align="left"><textarea rows="4" name="Comentarios" cols="42" class='style22'><? if (isset($rowg))echo $rowg[13]; ?></textarea></div></td>
                        </tr>
                        <tr>
                          <td width="30%" class="style22">&nbsp;</td>
                          <td class="style22"><div align="center" class="style33">
                              <div align="left">
							  
                                <input type="submit" class="style22" value="<? if ($dedonde==0) { echo $Mensajes["botc-1"];} else {echo $Mensajes["botc-2"];} ?>" name="B1">
                                <input  class="style22" type="reset" value="<? echo $Mensajes["bot-2"]; ?>" name="B2">
</div>
                          </div></td>
                        </tr>
                      </table>
                      </div>                      </td>
                    </tr>
                </table>
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
                              <span class="style33"><a  class="style33" href="../admin/indexadm.php" class="style33"><? echo $Mensajes["h-3"]; ?></a></span></p>
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
            <div align="center">fin-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
<? 

if (isset($result))
		   mysql_free_result($result);
           Desconectar();
?>

<script language="JavaScript">
<? if (isset($rowg) &&($rowg[5]!=0)){
?>
 Generar_Localidades(<? echo $rowg[5]; ?>);
<?}
  else {?>
 Generar_Localidades(0);
<?
}
?> 
 </script>
</body>
</html>