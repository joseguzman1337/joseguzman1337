<?
   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();

  	include_once "../inc/fgenped.php";
	include_once "../inc/fgentrad.php";
	 include_once "../inc/pidu.inc.php";
	if (! isset($Dependencias))	$Dependencias ="";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("eun-001",$IdiomaSitio);
   
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
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
tabla_val_Instit = new Array;
tabla_Long_Instit = new Array; 

tabla_Paises = new Array;
tabla_val_Paises = new Array;

tabla_Dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Long_Dep = new Array; 

<? armarScriptInstituciones("tabla_Instituciones" , "tabla_val_Instit" ,"tabla_Long_Instit")?>
<? armarScriptDependencia("tabla_Dependencias" , "tabla_val_Dep" ,"tabla_Long_Dep")?>
<? armarScriptPaises("tabla_Paises" , "tabla_val_Paises")?>

// Estas representan las opciones que usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript
    
function Generar_Dependencias (DepSel){     

        		Codigo_Instit=document.forms.form1.Instituciones.options[document.forms.form1.Instituciones.selectedIndex].value;    			
        		if (tabla_Long_Dep[Codigo_Instit]!=null)
        		{
        		 seleccion = 0;
     			 document.forms.form1.Dependencias.length =tabla_Long_Dep[Codigo_Instit]+1;    			
      			 for (i=0;i<tabla_Long_Dep[Codigo_Instit];i++)
                {             	
                 document.forms.form1.Dependencias.options[i].text=tabla_Dependencias [Codigo_Instit][i];
                 if (tabla_val_Dep [Codigo_Instit][i]==DepSel)
                 {
                   seleccion = i;
                 }
                 document.forms.form1.Dependencias.options[i].value=tabla_val_Dep [Codigo_Instit][i];
                }       
                document.forms.form1.Dependencias.length=i;	 
     			
              document.forms.form1.Dependencias.selectedIndex=seleccion;
			    return null;
			   }
			   else
			   {       		
			    	document.forms.form1.Dependencias.length = 0;			    	

			   } 
		}	    		

function Generar_Instituciones(InstSel,DepSel)
{     

          if (document.forms.form1.Paises.length>0)
          {
              seleccion = 0;
    			Codigo_Pais=document.forms.form1.Paises.options[document.forms.form1.Paises.selectedIndex].value;    			
    			if (tabla_Long_Instit[Codigo_Pais]!=null)
              {
     			  document.forms.form1.Instituciones.length = tabla_Long_Instit[Codigo_Pais]+1;    			
     			  for (i=0;i<tabla_Long_Instit[Codigo_Pais];i++)
                {             	
                 document.forms.form1.Instituciones.options[i].text=tabla_Instituciones [Codigo_Pais][i];
                 if (tabla_val_Instit [Codigo_Pais][i]==InstSel)
                 { seleccion = i; }
                 
                 document.forms.form1.Instituciones.options[i].value=tabla_val_Instit [Codigo_Pais][i];
                }       
                document.forms.form1.Instituciones.length=i;	 
     			
               document.forms.form1.Instituciones.selectedIndex=seleccion;
			     Generar_Dependencias(DepSel);
			     }
			    else
			    {
			    	document.forms.form1.Instituciones.length = 0;
			    	document.forms.form1.Dependencias.length = 0;			    	
			    } 
			}    
  			return null;
}	    
		
function Generar_Paises (PaisSel){     
    
          document.forms.form1.Paises.length = contpaises;
          seleccion = 0;
     		for (i=0;i<contpaises;i++)
                {             	
                 document.forms.form1.Paises.options[i].text=tabla_Paises [i];
                 document.forms.form1.Paises.options[i].value=tabla_val_Paises [i];
                 if (tabla_val_Paises [i]==PaisSel)
                 {
                   seleccion = i;
                 }

                }       
            document.forms.form1.Paises.length=i;	      			
            document.forms.form1.Paises.selectedIndex=seleccion;
			  return null;
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
     if ($Dependencias==0)
     {      	
    ?> 
    <form name="form1" method="POST" action="elige_unid.php">
    
				
				<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><?  echo $Mensajes["et-1"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
                        <tr>
                          <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-1"]; ?></div></td>
                          <td>
                            <div align="left">
							 <select size="1" name="Paises" OnChange="Generar_Instituciones(0,0)" class="style22"></select>
                          </div></td>
                        </tr>
						<tr>
                          <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-2"]; ?></div></td>
                          <td>
                            <div align="left">
						   <select size="1" name="Instituciones" OnChange="Generar_Dependencias(0)" class="style22"></select>
                          </div></td>
                        </tr>

						<tr>
                          <td width="150" class="style22"><div align="right"><? echo $Mensajes["ec-3"]; ?></div></td>
                          <td>
                            <div align="left">
						   <select size="1" name="Dependencias" class="style22"></select>
                          </div></td>
                        </tr>

                        <tr>
                          <td>&nbsp;</td>
                          <td><input type="submit" class="style22" value="<? echo $Mensajes["bot-1"]; ?>" name="B1"></td>
                        </tr>
                      </table>
    </form>
   
					  </div>                      </td>
                    </tr>
                </table>
				</form>
	<?
      }
     else
     { 
     ?>        

<table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["h-1"]; ?></span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
					<?   
					  
					     $expresion = "SELECT Nombre,Id FROM Unidades WHERE Codigo_Dependencia=".$Dependencias." ORDER BY Nombre";   
					     $result = mysql_query($expresion);
						 
					     while ($row = mysql_fetch_array($result))
					     {
					  
					?>
					<br>
						</p>
						<div align="center">
						  <center>
							 <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" class="style22">
									<tr>
									   <td width="150" class="style22"><div align="right"><? echo $Mensajes["et-2"]; ?></div></td>
									   <td class="style33"><? echo $row[0]; ?></td>
									   
									   
											</tr>
											<tr>
											  <td><div align="right"></div></td>
											  <td><div align="right" class="style33"><a  class="style33" href="form_unid.php?operacion=1&Id=<?echo $row[1]; ?>""><? echo $Mensajes["h-2"]; ?></a></div></td>
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
 if ($Dependencias==0)
{
?>
<script language="JavaScript">
 Generar_Paises(0);
 Generar_Instituciones(0,0);
</script>
<? }
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
                              <span class="style33"><a  class="style33" href="../admin/indexadm.php"> <? echo $Mensajes["h-1"] ?></a></span></p>
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
            <div align="center">eun-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>







