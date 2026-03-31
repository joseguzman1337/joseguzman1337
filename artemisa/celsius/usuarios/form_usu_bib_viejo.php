<? 
 include "direccionador.inc.php"; 
 include Obtener_Direccion(0)."conexion.inc";  
 Conexion();

 include Obtener_Direccion(0)."identif.php";
 Bibliotecario();	
?>  
<html>

<head>
<title>Fecha de la Noticia</title>
</head>

<body background="../imagenes/banda.jpg">

<? 
  include Obtener_Direccion(0)."fgenped.php";
  include Obtener_Direccion(0)."fgentrad.php";
    
   $Mensajes = Comienzo ("pau-001",$IdiomaSitio);
  
   
?>

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
<p>

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

  <div align="center">
    <center>
    <table border="1" width="605" bgcolor="#808080">
      <tr>
        <td width="100%" align="center">
          <p align="center"><font face="MS Sans Serif" size="3" color="#FFFF00"><? echo $Mensajes["tf-1"]; ?></font></p>
        </td>
      </tr>
    </table>
    </center>
  </div>
  <br>

<table border="0" width="100%" height="291" cellspacing="0" cellpadding="0" align="center">
    <tr>
    <td width="100%" height="285" valign="top">
      <form name="form1" method="POST" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold" onSubmit ="return false">
       <font face="MS Sans Serif" size="1"><b>
 	   </b></font>
       <div align="center">
       <center>
       <table border="1" width="80%" height="85" cellspacing="0" cellpadding="0" style="border-style: solid" bgcolor="#808080" bordercolor="#808080">
       <tr>
       <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font face="MS Sans Serif" size="1">&nbsp;<? echo $Mensajes["et-1"]; ?></font></b></td>
       <td width="55%" height="23" bgcolor="#B6D0D3" style="font-family: MS Sans Serif; font-size: 10 px; font-weight: bold; border-style: solid; border-width: 2" align="left"> 
       <p align="left"> 
       <font face="MS Sans Serif" size="1">
       <input type="text" name="Apellido" size="54" value="<?echo $rowg[0]; ?>"></font></p>
       </td>
     </tr>
        <center>
    <tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font size="1" face="MS Sans Serif">&nbsp;<? echo $Mensajes["et-2"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" align="left"><font face="MS Sans Serif" size="1"><span style="background-color: #800000">
      <input type="text" name="Nombres" size="54" value="<? echo $rowg[1]; ?>"></font></span></td>
    </tr>
    <tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font face="MS Sans Serif" size="1">&nbsp;<? echo $Mensajes["et-3"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" align="left"><font face="MS Sans Serif" size="1">
      <input type="text" name="Mail" size="54" value="<?echo $rowg[2]; ?>"></font></td>
    </tr>
    <tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font size="1" face="MS Sans Serif">&nbsp;<? echo $Mensajes["et-7"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" bordercolor="#808080"><b><font face="MS Sans Serif" size="1" color="#FFFFCC">
      <input type="text" name="Direccion" size="41" value="<? echo $rowg[3]; ?>"></font></b></td>
    </tr>
    <tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font face="MS Sans Serif" size="1">&nbsp;<? echo $Mensajes["et-8"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" bordercolor="#808080"><b><font face="MS Sans Serif" size="1" color="#FFFFCC">
      <input type="text" name="Telefono" size="41" value="<? echo $rowg[5]; ?>">&nbsp;&nbsp;</font></b></td>
    </tr>
	<tr>
	 <td width="45% height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"  bordercolor="#808080"><b><font size="1" face="MS Sans Serif">&nbsp;<? echo $Mensajes["et-9"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" bordercolor="#808080">
        <b>
        <font face="MS Sans Serif" size="1" color="#FFFFCC">
        <select name="Categoria" size="1">
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
        </select></font></b></td>
		</tr>
<? 
   $Mensajes = Comienzo ("aus-001",$IdiomaSitio); 	
   if ($Bibliotecario==1)
   {?>		
	     <tr>
    		<td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font size="1" face="MS Sans Serif">&nbsp;<? echo $Mensajes["ec-8"]; ?></font></b></td>
      		<td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" bordercolor="#808080">
        	<b>
        	 <font face="MS Sans Serif" size="1" color="#FFFFCC">
        
        		<select name="Dependencias" OnChange="Generar_Unidades(0)">
        		</select>        
        
        	  </font>
        	</b>
    	  </tr>
		  <tr>
		  <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font size="1" face="MS Sans Serif">&nbsp;<? echo $Mensajes["ec-9"]; ?></font></b></td>
      	  <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" align="left"><font face="MS Sans Serif" size="1"><span style="background-color: #800000">
      	   <input type="text" name="OtraDependencia" size="54"></font></td>
    	  </tr>
		  
<? 
   }
 
   
   if ($Bibliotecario<3)
   {    
    ?>
   <tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" style="border-style: solid; border-width: 2"  bordercolor="#808080" valign="middle"><font face="MS Sans Serif" size="1"><b>&nbsp;<? echo $Mensajes["ec-10"]; ?></b></font></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" align="left" style="border-style: solid; border-width: 2" bordercolor="#808080">
      	<select size="1" name="Unidades">        
       </select></td>
    </tr>
	<tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"><b><font size="1" face="MS Sans Serif">&nbsp;<? echo $Mensajes["ec-11"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2" align="left"><font face="MS Sans Serif" size="1"><span style="background-color: #800000">
      <input type="text" name="OtraUnidad" size="54"></font></td>
    </tr>
<?  } 
	?>	    
    <tr>
    <td width="45%" height="23" bgcolor="#B6D0D3" align="left" valign="middle" style="border-style: solid; border-width: 2"  bordercolor="#808080"><b><font color="#FFFFFF" size="1" face="MS Sans Serif">&nbsp;</font><font color="#000000" size="1" face="MS Sans Serif"><? echo $Mensajes["ec-15"]; ?></font></b></td>
      <td width="55%" height="23" bgcolor="#B6D0D3" style="border-style: solid; border-width: 2"  bordercolor="#808080">
        <b>
        <font face="MS Sans Serif" size="1" color="#FFFFCC">
        <select name="Localidad" size="1">
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
        </select></font></b></td>
    </tr>
    <tr>
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
    <tr>
    <td width="45%" height="22" bgcolor="#B6D0D3" align="left" valign="top" style="border-style: solid; border-width: 2"  bordercolor="#808080"><b><font face="MS Sans Serif" size="1">&nbsp;<? echo $Mensajes["ec-18"]; ?>&nbsp;</font></b></td>
      <td width="55%" height="22" bgcolor="#B6D0D3" align="left" valign="top" style="border-style: solid; border-width: 2"  bordercolor="#808080">
      <textarea rows="6" name="Comentarios" cols="36"><? echo $rowg[9]; ?></textarea>
      </td>
    </tr>
    <tr>
      <td width="45%" height="28" valign="top" bgcolor="#B6D0D3" align="left" style="border-style: solid; border-width: 2"  bordercolor="#808080">&nbsp;</td>
      <td width="55%" height="28" valign="top" bgcolor="#B6D0D3" align="left" style="border-style: solid; border-width: 2"  bordercolor="#808080">
        <p align="left">
		<?   $Mensajes = Comienzo ("pau-002",$IdiomaSitio); ?>

	   <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" onClick="verifica_campos()">
	   <input type="reset" value="<? echo $Mensajes["bot-2"]; ?>" name="B2">
	
        </p>
      </td>
    </tr>
  </table>
  </form>
    </td>
  </tr>
</table>
<? 
   mysql_free_result($result);
	Desconectar();
 ?>
<P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>pau-001/aus-001/pau-002</FONT></P>


<script language="JavaScript">
<? if ($Bibliotecario==1) { ?>
 Generar_Dependencias(<? if ($operacion==0) { echo "0"; } else { echo $rowg[6]; }?>);
<? } 
  if ($Bibliotecario<3) {?> 
 Generar_Unidades(<? if ($operacion==0) { echo "0"; } else { echo $rowg[7]; }?>);
<? } ?> 
</script>

</body>

