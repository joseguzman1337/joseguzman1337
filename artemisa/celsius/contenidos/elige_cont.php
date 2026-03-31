<?
 include_once "../inc/var.inc.php"; 
 include_once "../inc/"."conexion.inc.php";  
 Conexion();	
 include_once "../inc/"."identif.php"; 
 Administracion();
 if (! isset($dedonde) )		$dedonde =0;
 if (! isset($Secciones) )	$Secciones =0;
 if (! isset($Seccion) )		$Seccion =0;
 include_once "../inc/fgenped.php";
 include_once "../inc/fgentrad.php";
 global $IdiomaSitio;
 $Mensajes = Comienzo ("eco-001",$IdiomaSitio);   
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
-->
</style>
<base target="_self">
</head>



<script language="JavaScript">

tabla_Secciones = new Array;
tabla_valores = new Array;
tabla_Longitud = new Array; 


     <?
	 	 
        	
         $Instruccion = "SELECT Codigo_Idioma,Nombre,Id FROM Secciones ORDER BY Codigo_Idioma,Orden";	
         $result = mysql_query($Instruccion);  
		 $cod_anterior="";
         if (mysql_num_rows ($result)>0)
         {
           while ($row =mysql_fetch_row($result))
           {
           	 If ($cod_anterior  != $row[0])
           		{
					$Indice[$row[0]]=0;
					$cod_anterior = $row[0];
					echo "\n";
            		echo "tabla_Secciones[".$row[0]."]=new Array;\n";
            		echo "tabla_valores[".$row[0]."]=new Array;\n";            
        	     }	
			 $pos = $Indice[$row[0]];
           	 echo "tabla_Secciones[".$row[0]."][".$pos."]='".$row[1]."';\n";
             echo "tabla_valores[".$row[0]."][".$pos."]=".$row[2].";\n";
           
               $Indice[$row[0]]+=1;
            }
          
            echo "//Reflejo las longitudes de los vectores\n";
            while (list($key,$valor)=each($Indice))
            {	
          		echo "tabla_Longitud[".$key."]=".$valor.";\n";
            }		                              
         }
    ?>
    
function Generar_Secciones (valor){     

                
    			Codigo_Idioma=document.forms.form1.Codigo_Idioma.options[document.forms.form1.Codigo_Idioma.selectedIndex].value;    			
     			
				document.forms.form1.Secciones.length =tabla_Longitud[Codigo_Idioma]+1;
     			indice =0;
    			
    			if (document.forms.form1.Codigo_Idioma.length==0) 
    			 {
    			 	document.forms.form1.Secciones.length=1;
    			 	i=0;
    			 }
    			else 
    			{ 
     			 for (i=0;i<tabla_Longitud[Codigo_Idioma];i++)
                {             	
                 document.forms.form1.Secciones.options[i].text=tabla_Secciones [Codigo_Idioma][i];
                 document.forms.form1.Secciones.options[i].value=tabla_valores [Codigo_Idioma][i];
                 if (form1.Secciones.options[i].value==valor)
                  { indice = i }
                }       
                document.forms.form1.Secciones.length=i;	 
              } 
     			
              document.forms.form1.Secciones.selectedIndex=indice;
			  return null;
		}	    


 function confirmar()
 {
 	if (confirm("<? echo $Mensajes["me-1"]; ?>"))
 	{
 		return true
 	}
 	else
 	{
 		return false
 	}
 	
 }
</script>

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
              <?      
      if ($dedonde==2)
     {
      	 
		          $expresion = "DELETE FROM Contenidos WHERE Id=".$Id;                 	   
      		      $result = mysql_query($expresion);
		       	
        
      }
             
      if ($Secciones==0)
      {      	
       
	 ?> 
     <form name="form1" method="POST" action="elige_cont.php">
    
				
				<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-3"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td width="150" class="style22"><div align="right"><? echo $Mensajes["tf-1"]; ?></div></td>
                          <td>
                            <div align="left">
                              <select size="1" class="style22"  name="Codigo_Idioma" OnChange="Generar_Secciones()"> 
							 <?
              	   
							   $expresion = "SELECT Nombre,Id FROM Idiomas ORDER BY Nombre";                 	   
							   $result = mysql_query($expresion);
     							while ($row = mysql_fetch_array($result))
										{
								  ?>
								  <option value="<? echo $row[1]; ?>"><? echo $row[0] ?></option>	
								  <? } ?>
								  </select>
                          </div></td>
                        </tr>
                       <tr>
						<td width="150" class="style22"><div align="right"><? echo $Mensajes["tf-2"]; ?></div></td>
                          <td>
                            <div align="left">
                            <select  class="style22"size="1" name="Secciones">
                            </select></td>
                     </tr>  
									
						
						<tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" class="style22" value="<? echo $Mensajes["bot-1"]; ?>" name="B1">    </td>
                        </tr>
                      </table>
					 </form>
					  </div>                      </td>
                    </tr>
                </table>
     <?
      }
     else
     { 
     ?>    

			<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["et-1"];?> </span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
					<?   
					  
					   $expresion = "SELECT Titulo,Id FROM Contenidos WHERE Id_Seccion=".$Secciones." ORDER BY Orden,Titulo";   
					   $result = mysql_query($expresion);
						 
					   while ($row = mysql_fetch_array($result))
					   {
					  
					?> <br>
					   
						<div align="center">
						  <center>
							 <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
									<tr>
									   <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-1"]; ?></div></td>
											  <td class="style33"><? echo $row[0]; ?></td>
											</tr>
											<tr>
											  <td><div align="right"></div></td>
											  <td><div align="right" class="style33"><a href="form_cont.php?dedonde=1&Id=<?echo $row[1]; ?>"><? echo $Mensajes["h-2"]; ?></a>|<a href="elige_cont.php?dedonde=2&Id=<? echo $row[1]; ?>&Seccion=<? echo $Seccion; ?>" onClick="return confirmar()"><? echo $Mensajes["h-3"]; ?> </a></div></td>
											</tr>
										  </table>

							</center>
						 </div>

					<?
					 }
					 ?>
					 </td>
					 </tr>
			</table>
 <?
  mysql_free_result ($result);
  
 }

 Desconectar();
  
?>
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
                              <span class="style33"><a href="../admin/indexadm.php"> <? echo $Mensajes["h-1"];?></a></span></p>
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
            <div align="center">eco-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
<?

if ($Seccion==0)
{
?>
<script language="JavaScript">
 Generar_Secciones(0);
</script>
<? }
?>

