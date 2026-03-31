<html>
<?
  include_once "../inc/var.inc.php"; 
  include_once "../inc/conexion.inc.php";
  include_once "../inc/"."identif.php";
  Conexion();
  Bibliotecario();	
  include_once "../inc/"."fgenped.php";
  include_once "../inc/fgentrad.php";
  global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("aus-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);



?>
<head>
<title><? echo Titulo_Sitio(); ?></title>
<script language="JavaScript">
tabla_Dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Unidades = new Array;
tabla_val_Uni = new Array;
tabla_Long_Uni = new Array; 


 <?	  
  		  		  
         echo "// Armo el vector de Dependencias\n";
         echo "\n";
                   
         $Instruccion = "SELECT Id,Nombre FROM Dependencias WHERE Codigo_Institucion=".$Instit_usuario." ORDER BY Nombre";	
         $result = mysql_query($Instruccion);   
         if (mysql_num_rows($result)>0)
         {
		   $contdepe = 0;
           while ($row =mysql_fetch_row($result))
           {
              echo "\n";
           	  echo "tabla_Dependencias[".$contdepe."]='".$row[1]."';\n";
              echo "tabla_val_Dep[".$contdepe."]=".$row[0].";\n";
             $contdepe++;
            }
			$contdepe++;
          	echo "contdepe=".$contdepe;
		  	
            echo "//Reflejo las longitudes de los vectores\n";
         }
         
     	 echo "\n";
         echo "//Armo el vector de Unidades \n";
	
         $Instruccion = "SELECT Codigo_Dependencia,Nombre,Id FROM Unidades WHERE Codigo_Institucion=".$Instit_usuario." ORDER BY Codigo_Dependencia,Nombre";	
         $result = mysql_query($Instruccion);   
		 echo mysql_error();
         if (mysql_num_rows($result)>0)
		  {
           while ($row =mysql_fetch_row($result))
           {            
           		
          If (!($Ind[$row[0]]>0))
           	 {
                $Ind[$row[0]]=0;
            	  echo "tabla_Unidades[".$row[0]."]=new Array;\n";
            	  echo "tabla_val_Uni[".$row[0]."]=new Array;\n";
				  echo "\n";	
        	     }
           	 echo "tabla_Unidades[".$row[0]."][".$Ind[$row[0]]."]='".$row[1]."';\n";
               echo "tabla_val_Uni[".$row[0]."][".$Ind[$row[0]]."]=".$row[2].";\n";
           
               $Ind[$row[0]]+=1;
            }
          
            echo "//Reflejo las longitudes de los vectores\n";
            echo "\n";
            
            while (list($key1,$valor1)=each($Ind))
            {
          		   echo "tabla_Long_Uni[".$key1."]=".$valor1.";\n";
            }		                              
         }
    ?>
    
function Generar_Unidades (UniSel){     

				<? if ($Bibliotecario==1)
				{?>
        		Codigo_Depe=form1.Dependencias.options[form1.Dependencias.selectedIndex].value;    			
				<? } else {?>
				Codigo_Depe=<? echo $Dependencia; ?>;    			
				<? } ?>
			
        		if (tabla_Long_Uni[Codigo_Depe]!=null)
        		{
        		 seleccion = 0;
     			 form1.Unidades.length =tabla_Long_Uni[Codigo_Depe]+1;    			
      			 for (i=0;i<tabla_Long_Uni[Codigo_Depe];i++)
                {             	
                   form1.Unidades.options[i].text=tabla_Unidades [Codigo_Depe][i];
                   if (tabla_val_Uni [Codigo_Depe][i]==UniSel)
                   {
                     seleccion = i;
                   }
                   form1.Unidades.options[i].value=tabla_val_Uni [Codigo_Depe][i];
                }       
				
                form1.Unidades.options[i].text='<? echo $Mensajes["tf-2"]; ?>';
                form1.Unidades.options[i].value=0
	 
     			
                form1.Unidades.selectedIndex=seleccion;

			   }
			   else
			   {       		
		    	form1.Unidades.length = 1;			    	
                form1.Unidades.options[0].text='<? echo $Mensajes["tf-2"]; ?>';
                form1.Unidades.options[0].value=0
				form1.Unidades.selectedIndex=0;

			   } 
  			    return null;
		}	    		

<? if ($Bibliotecario==1)
   {?>		
function Generar_Dependencias (DepSel){     
    
          form1.Dependencias.length = contdepe;
          seleccion = 0;
     		for (i=0;i<contdepe-1;i++)
                {             	
                 form1.Dependencias.options[i].text=tabla_Dependencias [i];
                 form1.Dependencias.options[i].value=tabla_val_Dep [i];
                  if (tabla_val_Dep [i]==DepSel)
                  {
                   seleccion = i;
                  }

                } 
				
			form1.Dependencias.options[i].text='<? echo $Mensajes["tf-2"]; ?>';
            form1.Dependencias.options[i].value=0
            form1.Dependencias.length=contdepe;	      			
            form1.Dependencias.selectedIndex=seleccion;
            return null;
		}	    
		
<? } ?>		
		
function verifica_Apellido()
{
	if (document.forms["form1"].Apellido.value.length==0 || document.forms["form1"].Apellido.value.substring(0,3)=="***")	 
		{
		  document.forms["form1"].Apellido.value = "*** Por favor complete este campo";
		  return false;
		}
    else
       {
         return true;
      }
 }        
 
function verifica_Nombre()
{
	if (document.forms["form1"].Nombres.value.length==0 || document.forms["form1"].Nombres.value.substring(0,3)=="***")	 
		{
		  document.forms["form1"].Nombres.value = "*** Por favor complete este campo";
		  return false;
		}
    else
       {
         return true;
      }
 }        
 
function verifica_Email()
{
	if (document.forms["form1"].Mail.value.length==0 || document.forms["form1"].Mail.value.substring(0,3)=="***")	 
		{
		  document.forms["form1"].Mail.value = "*** Por favor complete este campo";
		  return false;
		}
   else {
         if (document.forms["form1"].Mail.value.indexOf('@',0)== -1 || document.forms["form1"].Mail.value.indexOf('.',0)== -1)
           {
       		  document.forms["form1"].Mail.value = "*** Dirección de E-Mail Inválida";
	            return false; }
		  else {
		      return true; }
         } 

}         


          
function verifica_campos()
{
	valor1 = true;
	valor1 = (valor1 && verifica_Apellido());
	valor1 = (valor1 && verifica_Nombre());	
	valor1 = (valor1 && verifica_Email());

	if (valor1==true)
	{
		
		 document.forms.form1.action = "upd_us_bib.php";
 		 document.forms.form1.submit();	
		
	} 
	
} 		
</script>    
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
.style42 {color: #FFFFFF; font-family: verdana; font-size: 11px; }
.style4 {
	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #0599B4;
}
.style5 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: normal;
	color: #FFFFFF;
}
.style6 {
	font-family: Arial;
	font-size: 9px;
	font-weight: normal;
	color: #666666;
}
.style7 {

	font-family: Arial;
	font-size: 9px;
	font-weight: normal;
	color: #0599B4;
}
.style8 {

	font-family: Verdana;
	font-size: 11px;
	font-weight: normal;
	color: #333333;
}


-->
</style>
 <base target="_self"> 
</head>

<body topmargin="0">
<?
 if ($operacion==1)
  {
   $expresion = "SELECT Apellido,Nombres,EMail,";
   $expresion = $expresion."Direccion,Codigo_Categoria,Telefonos,Codigo_Dependencia,Codigo_Unidad,Codigo_Localidad,Comentarios "; 
   $expresion = $expresion."FROM Usuarios WHERE Usuarios.Id =".$Id;
   $result = mysql_query($expresion);
   echo mysql_error();
   $rowg = mysql_fetch_row($result);   
   mysql_free_result($result);

  }	
?>


<div align="left">
<form name="form1" method="POST" onSubmit ="return false" >
  
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
                <table width="97%">
                  <tr>
                    <td height="20" colspan="2" valign="middle" bgcolor="#006699" class="style42"><div align="center"> <? echo $Mensajes['et-3']; ?></div></td>
                    </tr>
                  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right">  <? echo $Mensajes['ec-1']; ?></div></td>
                    <td width="*" valign="top" >
                      <div align="left">
                        <input type="text" name="Apellido" class="style33" size="50" value="<?echo $rowg[0]; ?>">
                      </div></td>
                  </tr>
                  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right">  <? echo $Mensajes['ec-2']; ?></div></td>
                    <td valign="top">
                      <div align="left">
                        <input type="text" name="Nombres" class="style33" size="50" value="<? echo $rowg[1]; ?>">
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22">
                    <div align="right"> <? echo $Mensajes['ec-3']; ?></div></td>
                    <td valign="top">
                      <div align="left">
                        <input type="text" name="Mail" class="style33" size="50" value="<?echo $rowg[2]; ?>">
				     </div></td>
                  </tr>
                
					   <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22">
                    <div align="right"> <? echo $Mensajes['ec-14']; ?>:</div></td>
                    <td valign="top">
                      <div align="left">
                        <input type="text" name="Direccion"  class="style33" size="41" value="<? echo $rowg[3]; ?>">
					  </div></td>
                  </tr>
                  <tr>
                    <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes['ec-17']; ?></div></td>
                    <td valign="top" align=left>
					<input type="text" name="Telefono" class="style33" size="50" value="<? echo $rowg[5]; ?>">
                    </td>
                  </tr>
		
				   <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes['ec-12']; ?>:</div></td>
                    <td valign="top" align=left><select name="Categoria" class="style33">
<?
          $Instruccion = "SELECT Id,Nombre FROM Tab_Categ_usuarios ORDER BY Nombre";	
          $result = mysql_query($Instruccion); 
          while ($row =mysql_fetch_row($result))
          {
             if ($row[0]==$rowg[4]){    
                        echo "<option selected value='".$row[0]."'>".$row[1]."</option>";}
             else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
                        
           }       
        ?>
		
                   </select></td>
                  </tr>
				
				  
        <? 
   $Mensajes = Comienzo ("aus-001",$IdiomaSitio); 	
   if ($Bibliotecario==1)
   {?>		
        
				
				   <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes['ec-8']; ?>:</div></td>
                    <td valign="top" align=left> <select name="Dependencias" class="style33" OnChange="Generar_Unidades(0)">
                    </select>
                    </td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes['ec-9']; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraDependencia" class="style33" size="50" >
                    </td>
                  </tr>
              <?}
   if ($Bibliotecario<3)
   {    
    ?>					
	
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes['ec-10']; ?></div></td>
                    <td valign="top" align=left> <select name="Unidades" class="style33" >
                    </select>
                    </td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes['ec-13']; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraUnidad" class="style33" size="50" >
                    </td>
                  </tr>
		  <?
			}
   		  ?>
				 
				   <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes['ec-15']; ?></div></td>
                    <td valign="top" align=left>
                    <select name="Localidad" class="style33" size="1">
         <?
		  // Obtengo el país de la institucion del Bibliotecario
		  $Instruccion = "SELECT Codigo_Pais FROM Instituciones WHERE Codigo=".$Instit_usuario;
		  $result = mysql_query($Instruccion); 
          $row = mysql_fetch_row($result);
		  $Pais = $row[0];		  
		  
          $Instruccion = "SELECT Id,Nombre FROM Localidades WHERE Codigo_Pais=".$Pais." ORDER BY Nombre";	
          $result = mysql_query($Instruccion); 
          while ($row =mysql_fetch_row($result))
          {
             if ($row[0]==$rowg[8]){    
                        echo "<option selected value='".$row[0]."'>".$row[1]."</option>";}
             else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
                        
           }       
         ?>
        </select>
    <input type="hidden" name="Id" value="<? echo $Id; ?>">
	<input type="hidden" name="operacion" value="<? echo $operacion; ?>">
	<input type="hidden" name="dedonde" value="0">
	<?
		if ($Bibliotecario>1)
		{
	?>
	<input type="hidden" name="Dependencias" value="<? echo $Dependencia; ?>">	
	<?   } 
		if ($Bibliotecario==3)
		{
	?>
	<input type="hidden" name="Unidades" value="<? echo $Unidad; ?>">			
	<?  }?>                   
				   
				   
				   </td>
                  </tr>
			
                  <tr>
                    <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes['ec-18']; ?></div></td>
                    <td valign="top" align=left><textarea rows="6" name="Comentarios" cols="36" class="style33"><? echo $rowg[9]; ?></textarea>
                    </td>
                  </tr>
                  

                  <tr>
                    <td colspan="2" class="style22"><div align="right"></div>                      <div align="center">					
                          
						  <?   $Mensajes = Comienzo ("pau-002",$IdiomaSitio); ?>

	   <input type="submit" class="style22" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" onClick="verifica_campos()">
	   <input type="reset"  value="<? echo $Mensajes["bot-2"]; ?>" class="style22" name="B2">
						  
                      </div></td>
                    </tr>
                </table>
              </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
           <?
                 dibujar_menu_usuarios($Usuario,1);

             ?>
		 <!-- <div align="left"><img src="../images/teclado.jpg" width="150" height="200"> </div>-->
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50"><div align="right" class="style33">
            <div align="center">aus-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</form>
</div>
<? 
   mysql_free_result($result);
	Desconectar();
 ?>
<script language="JavaScript">
<? if ($Bibliotecario==1) { ?>
 Generar_Dependencias(<? if ($operacion==0) { echo "0"; } else { echo $rowg[6]; }?>);
<? } 
  if ($Bibliotecario<3) {?> 
 Generar_Unidades(<? if ($operacion==0) { echo "0"; } else { echo $rowg[7]; }?>);
<? } ?> 
</script>


</body>
</html>

   

  


