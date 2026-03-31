<?
 include_once "../inc/var.inc.php";
 include_once "../inc/conexion.inc.php";  
 Conexion();	
 include_once "../inc/identif.php"; 
 Administracion();
 include_once "../inc/fgenped.php";
 include_once "../inc/fgentrad.php"; 
 include_once "../inc/pidu.inc.php";
 global $IdiomaSitio;
 $Mensajes = Comienzo ("fde-001",$IdiomaSitio);
   if (! isset($Id))		$Id="";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
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
	font-family: Verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}

a.style33 {
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
<script language="JavaScript">
tabla_Instituciones = new Array;
tabla_valores = new Array;
tabla_Longitud = new Array; 

<? armarScriptInstituciones("tabla_Instituciones" , "tabla_valores" ,"tabla_Longitud");?>
function Generar_Instituciones (valorpredet){     

    			Codigo_Pais=document.forms.form1.Pais.options[document.forms.form1.Pais.selectedIndex].value;    			              
     			document.forms.form1.Institucion.length =tabla_Longitud[Codigo_Pais];
     			indice = 0;
    			
    			if (document.forms.form1.Institucion.length==0) 
    			 {
    			 	document.forms.form1.Institucion.length=1;
    			 	i=0;
    			 }
    			else 
    			{ 
     			 for (i=0;i<tabla_Longitud[Codigo_Pais];i++)
                {             	
                 document.forms.form1.Institucion.options[i].text=tabla_Instituciones [Codigo_Pais][i];
                 document.forms.form1.Institucion.options[i].value=tabla_valores [Codigo_Pais][i];				 
				 document.forms.form1.Institucion.options[i].className="style22";
                 if (document.forms.form1.Institucion.options[i].value == valorpredet)
                  { indice =i; }
                }       	 
              } 
              
          
// Si el valor predet < 1
// implica que la seleccion en un Change es Otra 
				
			  document.forms.form1.Institucion.selectedIndex=indice;		            
  		    return null;
}

function enviar_campos (){
// Estos campos los envío para presentarle al usuario
      document.forms.form1.Desc_Inst.value=document.forms.form1.Institucion.options[document.forms.form1.Institucion.selectedIndex].text;			  
      return null;			    
}

function validar_entrada(){
 if (document.forms.form1.Institucion.value!=0)
 {
 	enviar_campos();
 	document.forms.form1.action = "update_depe.php?dedonde=<? echo $dedonde; ?>&Id=<? echo $Id; ?>";
 	document.forms.form1.submit();
 }
 else
 {
 	alert ("<? echo $Mensajes["me-1"]; ?>");
 }

}     

</script>
<?   
	If ($dedonde==1)
	{	
	  $expresion = "SELECT Id,Codigo_Institucion,Dependencias.Nombre,Dependencias.Direccion,Dependencias.Telefonos";
	  $expresion = $expresion. ",Dependencias.Figura_Portada,Es_LibLink,Hipervinculo1,Hipervinculo2,Hipervinculo3";
	  $expresion = $expresion. ",Dependencias.Comentarios,Instituciones.Codigo_Pais FROM Dependencias";
	  $expresion = $expresion. " LEFT JOIN Instituciones ON Instituciones.Codigo=Dependencias.Codigo_Institucion";
	  $expresion = $expresion. " WHERE Id=".$Id;
	  $result = mysql_query($expresion);
	  echo mysql_error();
	  
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

			 <form method="POST" name="form1"  onSubmit="return false">
                <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["ec-1"]; ?> </span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="2" cellspacing="0" >
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style42"><? echo $Mensajes["tf-1"]; ?></div></td>
                          <td ><div align="right"></div>                           
							<select class="style22" size="1" name="Pais" onChange="Generar_Instituciones(<? if (isset ($rowg))echo $rowg[1]; else echo "0"; ?>)" >
							   <?
								   $Instruccion = "SELECT Nombre, Id FROM Paises ORDER BY Paises.Nombre ";	
								   $result = mysql_query($Instruccion); 
								   while ($row =mysql_fetch_row($result))
								  {
											
									if (isset($rowg) &&($row[1]==$rowg[11]))
									{
							   ?>
									   <option class="style22" selected value="<?echo $row[1];?>"><?echo $row[0];?></option>
								<?    }
									  else
									  {
								 ?>
									   <option class="style22" value="<?echo $row[1];?>"><?echo $row[0];?></option> 		       
								<?     
									  }
									}
								?>	   
							   </select></td>
                        </tr>
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style33 style41">
                            <div align="right" class="style22"><? echo $Mensajes["tf-2"]; ?></div>
                          </div></td>
                          <td class="style22"> <select size="1" name="Institucion" class="style22" ></select></td>
                        </tr>
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style42">
                            <div align="right"><? echo $Mensajes["tf-3"];  ?></div>
                          </div></td>
                          <td class="style22">
						  <input type="text" name="Nombre_Dependencia" class="style22" size="40" value="<? if ( isset($rowg)) echo $rowg[2] ;?>"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-4"]; ?> </div></td>
                          <td class="style22"> <input type="text" name="Direccion" size="40" value="<? if ( isset($rowg)) echo $rowg[3] ;?>" class="style22" ></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-5"]; ?> </div></td>
                          <td class="style22"><input type="checkbox" name="FiguraPortada" value="ON" <? if (isset($rowg) &&($rowg[5]==1)) {echo " checked";} ?> class='style22'></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-11"]; ?> </div></td>
                          <td class="style22"> <input type="checkbox" name="Es_Liblink" value="ON" <? if (isset($rowg) &&($rowg[6]==1)) {echo " checked";} ?> class="style22"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-6"];  ?></div></td>
                          <td class="style22">
						  <input class="style22" type="text" name="hipervinculo1" size="49" value="<? if (isset($rowg)) echo $rowg[7]; ?>"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-7"]; ?> </div></td>
                          <td class="style22">
						  <input type="text" name="hipervinculo2" size="49" value="<? if (isset($rowg))echo $rowg[8]; ?>" class="style22">
						  </td>
                        </tr>

						<tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-8"]; ?> </div></td>
                          <td class="style22">
						   <input type="text" name="hipervinculo3" size="49" value="<? if (isset($rowg))echo $rowg[9]; ?>"class="style22">
						  </td>
                        </tr>


						<tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-9"]; ?> </div></td>
                          <td class="style22">
						   <input type="text" name="Telefono" size="41" value="<? if (isset($rowg)) echo $rowg[4]; ?>" class="style22">
						   <input type="hidden" name="Desc_Inst">
						  </td>
                        </tr>

						<tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["tf-10"]; ?> </div></td>
                          <td class="style22">
						  <textarea rows="4" name="Comentario" cols="42" class="style22"  ><?  if (isset($rowg)) echo $rowg[10]; ?></textarea>
						  </td>
                        </tr>
                        <tr>
                          <td width="30%" class="style22">&nbsp;</td>
                          <td class="style22"><div align="center" class="style33">
                              <div align="left">
							    <input type="submit" class="style22" value="<? if ($dedonde==0) { echo $Mensajes["bot-1"];} else {echo $Mensajes["bot-2"];} ?>" name="B1" onClick="validar_entrada()">
                                <input  class="style22" type="reset" value="<? echo $Mensajes["bot-3"]; ?>" name="B2">
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
                              <span class="style33"><a class="style33" href="../admin/indexadm.php" class="style33"> <? echo $Mensajes["h-3"]; ?></a></span></p>
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
            <div align="center">fde-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>

<script language="JavaScript">
  Generar_Instituciones(<? if ($dedonde==0) { echo "0"; } else {if (isset($rowg))echo $rowg[1]; else "0";} ?>)
</script>


<? 

if (isset($result))
		   mysql_free_result($result);
           Desconectar();
?>


 </script>
</body>
</html>