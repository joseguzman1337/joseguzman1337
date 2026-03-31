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
  if (! isset($operacion))		$operacion=0;
  if (! isset($dedonde))		$dedonde=0;
  global $IdiomaSitio;
  $Mensajes = Comienzo ("fus-001",$IdiomaSitio);
   
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
	font-family: verdana;
	font-size: 9px;
}
.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
a.style33 {	font-family: verdana;
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

// Estas representan las opciones que usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript

vector_usa = [<? echo Devuelve_Inst(); ?>];
<? armarScriptInstituciones("tabla_Instituciones" , "tabla_val_Instit" ,"tabla_Long_Instit")?>
<? armarScriptDependencia("tabla_Dependencias" , "tabla_val_Dep" ,"tabla_Long_Dep")?>
<? armarScriptPaises("tabla_Paises" , "tabla_val_Paises")?>

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
		
    
function enviar_campos (){
// Estos campos los envío para presentarle al usuario
 
   document.forms.form1.DescInst.value=document.forms.form1.Instituciones.options[document.forms.form1.Instituciones.selectedIndex].text;
   document.forms.form1.DescDepe.value=document.forms.form1.Dependencias.options[document.forms.form1.Dependencias.selectedIndex].text;			  
   return null;			    
}     

function valida_entrada(){
	if (document.forms.form1.Instituciones.value!=0)
	{
		if (document.forms.form1.Dependencias.value!=0)
		{
			enviar_campos();
			document.forms.form1.action = "upd_unid.php";
			document.forms.form1.submit()  

		}
		else
		{
			alert ("<?  
						if (isset($Mensajes["me-1"]))
						echo $Mensajes["me-1"]; ?>");
		}
	}
	else
	{
		alert ("<? 
						if (isset($Mensajes["me-2"]))
						echo $Mensajes["me-2"]; ?>");
	}
}
</script>    



<? 
	if ($operacion==1)
	{
		$Instruccion = "SELECT Instituciones.Codigo_Pais,Instituciones.Codigo,Unidades.Codigo_Dependencia,";
		$Instruccion = $Instruccion."Unidades.Nombre,Unidades.Direccion,Unidades.Telefonos,Unidades.Figura_Portada,Unidades.Hipervinculo1,Unidades.Hipervinculo2,Unidades.Hipervinculo3,Unidades.Comentarios";
		$Instruccion = $Instruccion." FROM Unidades";
		$Instruccion = $Instruccion." LEFT JOIN Dependencias ON Dependencias.Id=Unidades.Codigo_Dependencia ";
		$Instruccion = $Instruccion." LEFT JOIN Instituciones ON Instituciones.Codigo=Dependencias.Codigo_Institucion WHERE Unidades.Id=".$Id;
		$result = mysql_query($Instruccion);
		echo mysql_error();
		
		$rowa = mysql_fetch_row($result);
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

			  <form name="form1" method="POST" action="update_instit.php?dedonde=<? echo $dedonde; ?>&Id=<? echo $Id; ?>"  onSubmit="enviar_campos()">
				

                <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#ECECEC">
                  <tr bgcolor="#006699">
                    <td height="20" class="style33"><span class="style34"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-1"]; ?> </span></td>
                    </tr>
                  <tr align="left" valign="middle">
                    <td class="style22"><div align="center" class="style33">
                      <table width="90%"  border="0" align="center" cellpadding="2" cellspacing="0" class="style22">
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style42"><? echo $Mensajes["et-1"]; ?></div></td>
                          <td class="style22"><div align="right"></div>
						   <select size="1" name="Paises" onChange="Generar_Instituciones()" class="style22"></select></td>
                        </tr>
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style33 style41">
                            <div align="right" class="style22"><? echo $Mensajes["et-2"];?></div>
                          </div></td>
                          <td class="style22"> <select size="1" name="Instituciones" onChange="Generar_Dependencias()" class="style22"></select></td>
                        </tr>
                        <tr>
                          <td width="30%" bgcolor="#CCCCCC" class="style22"><div align="right" class="style42">
                            <div align="right"><? echo $Mensajes["et-3"]; ?></div>
                          </div></td>
                          <td class="style22"><select size="1" name="Dependencias" class="style22"></select></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-4"]; ?></div></td>
                          <td class="style22"><input type="text" name="Nombre_Unidad" size="45" value="<? if(isset($rowa))echo $rowa[3]; ?>" class="style22" ></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-5"]; ?> </div></td>
                          <td class="style22">
						  <input type="text" name="Direccion" size="45" value="<? if(isset($rowa))echo $rowa[4]; ?>" class="style22"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-6"]; ?> </div></td>
                          <td class="style22"><input type="text" name="Telefono" size="45" value="<? if(isset($rowa)) echo $rowa[5]; ?>" class="style22"><input type="hidden" name="DescInst"><input type="hidden" name="DescDepe"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-7"];  ?></div></td>
                          <td class="style22"><input class="style22" type="checkbox" name="FiguraPortada" value="ON" <? if (isset($rowa) &&($rowa[6]==1)) { echo "checked"; } ?>></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-8"]; ?> </div></td>
                          <td class="style22"><input type="text" class="style22" name="hipervinculo1" size="52" value="<? if (isset($rowa)) echo $rowa[7]; ?>"></td>
                        </tr>

						<tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-9"]; ?></div></td>
                          <td class="style22"> <input type="text" name="hipervinculo2" size="52" value="<? if (isset($rowa))echo $rowa[8]; ?>"  class="style22"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-10"]; ?></div></td>
                          <td class="style22"><input type="text" name="hipervinculo3" size="52" value="<?  if (isset($rowa)) echo $rowa[9]; ?>" class="style22"></td>
                        </tr>
                        <tr>
                          <td bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["et-11"]; ?> </div></td>
                          <td class="style22"><textarea rows="6" name="Comentarios" cols="45" class='style22'><? if (isset($rowa)) echo $rowa[10]; ?></textarea>  </td>
                        </tr>
                        <tr>
                          <td width="30%" class="style22">&nbsp;</td>
                          <td class="style22"><div align="center" class="style33">
                              <div align="left">
							  <input type="hidden" name="operacion" value="<? echo $operacion; ?>">
							  <input type="hidden" name="Id" value="<? echo $Id; ?>">        
							  <input type="submit" value="<? if ($operacion==0) { echo $Mensajes["botc-1"]; } else { echo $Mensajes["botc-2"]; } ?>" name="B1" OnClick="valida_entrada()" class="style22" >
							  <input type="reset" value="<? echo $Mensajes["bot-3"] ?>" name="B2" class="style22" ></div>
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
                              <span class="style33"><a class="style33" href="../admin/indexadm.php" class="style33"> <? echo $Mensajes["h-3"] ?></a></span></p>
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
            <div align="center">fus-001</div>
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
	Generar_Paises (<? if (isset($rowa)) echo $rowa[0]; else "0"?>);
	<? if (($operacion==0))
	{
	?>
	  Generar_Instituciones();
	<?}
	else
	{ ?>
	  Generar_Instituciones(<? echo $rowa[1].",".$rowa[2] ?>);
	<? } ?>  
</script>
</body>
</html>