<? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 include_once "../inc/"."parametros.inc.php";  
 Conexion();
 include_once "../inc/"."identif.php";
 Administracion();

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
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 11px;
	font-weight: bold;
}
.style42 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
.style43 {
	color: #66FFFF;
	font-family: verdana;
	font-size: 11px;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?  
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo ("gen-eve",$IdiomaSitio);  
   
 ?>
<script language="JavaScript">

tabla_Instituciones = new Array;
tabla_val_Instit = new Array;
tabla_Long_Instit = new Array; 
tabla_Paises = new Array;
tabla_val_Paises = new Array;
tabla_Dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Long_Dep = new Array; 

// Estas representan las opcionesque usan Institucion y Dependencia
// lo devuelve como un vector la funcion PHP y se comparan desde
// JavaScript

vector_usa = [<? echo Devuelve_Inst(); ?>];
<?  include_once "../inc/"."pidu.inc.php";
   armarScriptPaises("tabla_Paises","tabla_val_Paises");
   armarScriptInstituciones("tabla_Instituciones" , "tabla_val_Instit" , "tabla_Long_Instit");
   armarScriptDependencia("tabla_Dependencias","tabla_val_Dep","tabla_Long_Dep");

?>
    
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
		
function presentar_campos(Pais,Institucion,Dependencia)
{ 

  i=0;
  
  while (i<=vector_usa.length-1 && vector_usa[i]!=document.forms.form1.Evento.value)
  { 
    i++;
  }
  
  if (i<=vector_usa.length-1)
  {
       // Usa Institucion y dependencia 
       
       document.forms.form1.Paises.selectedIndex=0;
       Generar_Paises(Pais);
       Generar_Instituciones(Institucion,Dependencia);
      
  }
  else
  {
    	document.forms.form1.Instituciones.length = 0;
     	document.forms.form1.Dependencias.length = 0;
     	document.forms.form1.Paises.length = 0
     	
   
  }  

  
   if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_Recepcion(); ?>)
	{
	  <? 
	   $Dia = date ("d");
      $Mes = date ("m");
      $Anio = date ("Y");
      $FechaHoy =$Anio."-".$Mes."-".$Dia;
    
      ?>
	  
	  document.forms.form1.elements.Fecha_Recepcion.value = "<? echo $FechaHoy; ?>";
	  document.forms.form1.elements.Env_Mail.checked = true;
	}
	else
	{
	   document.forms.form1.elements.Fecha_Recepcion.value = "";
   }
   
   if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_paraConfirmar(); ?>)
   {
   		document.forms.form1.elements.Env_Mail.checked = true;
   }
 

}
   
function enviar_campos (){
// Estos campos los envío para presentarle al usuario
 
   if (document.forms.form1.Dependencias.length>0)
   {
    document.forms.form1.DescDepe.value=document.forms.form1.Dependencias.options[document.forms.form1.Dependencias.selectedIndex].value;
	
   }
   else
   { 
     document.forms.form1.DescDepe.value="";
   }
   
   return null;			    
}     


function archivo_es_correcto(nombreArchivo)
{ 
    
  aux = nombreArchivo.substring(nombreArchivo.lastIndexOf(".") + 1,nombreArchivo.length);
  
  if ((aux.toLowerCase() != "pdf") && (aux.toLowerCase() != "arv"))
     return false;
   else
     return true;
}

function valida_entrada()
{	if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_paraConfirmarPorRecursoWeb(); ?>)
	    {//la confirmacion por email es obligatoria para este evento
	      document.forms.form1.elements.Env_Mail.checked = true;
	    }
	    
	if ((document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_Solicitado();?> ||
	     document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_Recepcion();?>) &&
		(document.forms.form1.Instituciones.length==0))
		{
		 // Quiero impedir un evento con país sin institucion.
		 
		 alert ("<? echo $Mensajes["me-3"]; ?>");
	  	 return false;
		}
	
	if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_Recepcion(); ?> && document.forms.form1.elements.Numero_Paginas.value==0)
	{
	  alert ("<? echo $Mensajes["me-1"]; ?>");
	  return false;
	}
	
	
	if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_paraConfirmar(); ?> && document.forms.form1.elements.Observaciones.value=="")
	{
	  alert ("<? echo $Mensajes["me-4"];?>");
	  return false;	
	}
	
	if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_Recepcion(); ?> && document.forms.form1.elements.Instituciones.value==0)
	{
	  alert ("<? echo $Mensajes["me-2"]; ?>");	
	  return false;
	}


	if (document.forms.form1.elements.Evento.value==<? echo Devuelve_Evento_Recepcion(); ?>)

	{ if (document.getElementById("userfile").value != '')
	    if (!archivo_es_correcto(document.getElementById("userfile").value))
	     { alert ("<? echo $Mensajes["me-5"]; ?>");
     	   return false;
	     }
   	   if (document.getElementById("userfile1").value != '')
		 { if (!archivo_es_correcto(document.getElementById("userfile1").value))
	      {
		   alert ('<? echo $Mensajes["me-5"]; ?>');
	       return false;
	      }
	      if (document.getElementById("userfile1").value == document.getElementById("userfile").value)
	          {
		        alert ('<? echo $Mensajes["me-6"]; ?>');
        	    return false;
	      }
		 }

	       if (document.getElementById("userfile2").value != "")
	       {  if (!archivo_es_correcto(document.getElementById("userfile2").value))
   		       {
			    alert ('<? echo $Mensajes["me-5"]; ?>');
	    	    return false;
     	       }
		      if (document.getElementById("userfile1").value == document.getElementById("userfile2").value)
    	        {
		        alert ('<? echo $Mensajes["me-6"]; ?>');
        	    return false;
	             }
	          if (document.getElementById("userfile").value == document.getElementById("userfile2").value)
    	            {
		            alert ('<? echo $Mensajes["me-6"]; ?>');
        	        return false;
	               }
		   }
	       if (document.getElementById("userfile3").value != "")
	       {  if (!archivo_es_correcto(document.getElementById("userfile3").value))
   		       {
			    alert ('<? echo $Mensajes["me-5"]; ?>');
	    	    return false;
     	       }
		      if (document.getElementById("userfile1").value == document.getElementById("userfile3").value)
    	        {
		        alert ('<? echo $Mensajes["me-6"]; ?>');
        	    return false;
	             }
	          if (document.getElementById("userfile").value == document.getElementById("userfile3").value)
    	            {
		            alert ('<? echo $Mensajes["me-6"]; ?>');
        	        return false;
	               }
	          if (document.getElementById("userfile2").value == document.getElementById("userfile3").value)
    	            {
		            alert ('<? echo $Mensajes["me-6"]; ?>');
        	        return false;
	               }

	       }

	       if (document.getElementById("userfile4").value != "")
	       {  
			   if (!archivo_es_correcto(document.getElementById("userfile4").value))
   		       {
			    alert ('<? echo $Mensajes["me-5"]; ?>');
	    	    return false;
     	       }
		      if (document.getElementById("userfile1").value == document.getElementById("userfile4").value)
    	        {
		        alert ('<? echo $Mensajes["me-6"]; ?>');
        	    return false;
	             }
	          if (document.getElementById("userfile").value == document.getElementById("userfile4").value)
    	            {
		            alert ('<? echo $Mensajes["me-6"]; ?>');
        	        return false;
	               }
	          if (document.getElementById("userfile2").value == document.getElementById("userfile4").value)
    	            {
		            alert ('<? echo $Mensajes["me-6"]; ?>');
        	        return false;
	               }

	          if (document.getElementById("userfile3").value == document.getElementById("userfile4").value)
    	            {
		            alert ('<? echo $Mensajes["me-6"]; ?>');
        	        return false;
	               }

	       }

	  } // Evento_PDFEnviado

     if (document.forms.form1.Numero_Paginas.value == '')
		 document.forms.form1.Numero_Paginas.value = 0;
     enviar_campos();
	 document.forms.form1.action = "reg_evento.php";
     document.forms.form1.submit();
     return true;
   	
}

</script>    

<?
  
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   
   $Instruccion = "SELECT Ultimo_Pais_Solicitado,Ultima_Institucion_Solicitado,Ultima_Dependencia_Solicitado FROM Pedidos WHERE Id='".$Id."'";
   $result = mysql_query($Instruccion);
   echo mysql_error();
   $row = mysql_fetch_row($result);
  
?>

<div align="left">
   <form enctype="multipart/form-data" method="post" name="form1" OnSubmit="return false">

  <table width="500"  border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ececec">
    <tr align="center" bgcolor="#0099FF">
      <td height="20" colspan="2" class="style42"><? echo $Mensajes["ec-1"]; ?><span class="style43"><? echo $Id; ?></span></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-1"]; ?></div></td>

	  <td height="20" align="left" valign="middle" bgcolor="#ececec"><select size="1" name="Evento" OnChange="presentar_campos()" class="style23">
          <?
             
			 $Vector=Devolver_Opciones($Estado,$VectorIdioma);
             while (list($opcion,$valor)=each($Vector))
             {              
                  echo "<option value='".$valor."'>".$opcion."</option>";
             } 
           ?>              
          </select></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-2"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><select size="1" class="style23" name="Paises" OnChange="Generar_Instituciones(<? echo $row[1].",".$row[2]; ?>)">
      </select></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-3"]; ?></div></td
                    >
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><select size="1" name="Instituciones" class="style23" OnChange="Generar_Dependencias()">
       </select></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-4"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><select size="1" name="Dependencias" class="style23">
      </select></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-5"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><select size="1" class="style23" name="Operador">
       <?
        $Instruccion = "SELECT Id,Apellido,Nombres FROM Usuarios WHERE Personal=1 ORDER BY Apellido,Nombres ";	
        $result = mysql_query($Instruccion); 
        while ($rowg =mysql_fetch_row($result))
        {
         if ($rowg[0]==$usuario)
         {
        ?>       
         <option selected value="<?echo $rowg[0];?>"><?echo $rowg[1].",".$rowg[2];?></option>
         <?}
         else
         { ?>
         <option value="<?echo $rowg[0];?>"><?echo $rowg[1].",".$rowg[2];?></option>
         <? 
          } 
         } ?>
      </select>
	  
</td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-6"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="checkbox" class="style23" name="Es_Privado" value="ON"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-7"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="text" class="style23" name="Fecha_Recepcion"  size="40"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-8"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="text" name="Numero_Paginas" size="15" class="style23"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-9"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="checkbox" class="style23" name="Env_Mail" value="ON"></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-12"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
      <input name="userfile" class="style23" id="userfile" type="file" size="20" class="fixed" /></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-12"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="hidden" class="style23" name="MAX_FILE_SIZE" value="1000000000">
      <input name="userfile1" class="style23" id="userfile1" type="file" size="20" class="fixed" /></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-12"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
      <input name="userfile2" class="style23" id="userfile2" type="file" size="20" class="fixed" /></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-12"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
      <input name="userfile3" class="style23" id="userfile3" type="file" size="20" class="fixed" /></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="middle" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-12"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
      <input name="userfile4" class="style23" id="userfile4" type="file" size="20" class="fixed" /></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td width="150" height="20" align="right" valign="top" bgcolor="#CCCCCC" class="style23"><div align="right"><? echo $Mensajes["tf-11"]; ?></div></td>
      <td height="20" align="left" valign="middle" bgcolor="#ececec"><textarea rows="3" name="Observaciones" cols="41" class="style23"></textarea></td>
    </tr>
    <tr bgcolor="#D4D0C8">
      <td height="20" align="center" bgcolor="#ECECEC" class="style23">
        <div align="center"> </div></td>
      <td height="20" align="center" bgcolor="#ECECEC" class="style23"><div align="left">
        
		  <input type ="hidden" name="Id" value="<? echo $Id;?>">
      <input type ="hidden" name="Modo" value="<? echo $Modo;?>">
      <input type ="hidden" name="Mail" value="<? echo $Mail;?>">
      <input type ="hidden" name="Nombre" value="<? echo $Nombre; ?>">
	  <input type ="hidden" name="RolCreador" value="<? echo $RolCreador; ?>">	
	  <input type ="hidden" name="IdCreador" value="<? echo $IdCreador; ?>">	
	  <input type ="hidden" name="DescDepe">	
	  <input type="submit" class="style23" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" OnClick="valida_entrada()">
      <input type="button" class="style23" value="<? echo $Mensajes["bot-2"]; ?>" name="B2"  OnClick="javascript:self.close()">
      </div></td>
    </tr>
  </table>
  </div>
  <? 
           mysql_free_result($result);
           Desconectar();
    ?>

<script language="JavaScript">
	Generar_Instituciones(<? echo $row[1].",".$row[2]; ?>);
	presentar_campos(<? echo $row[0].",".$row[1].",".$row[2]; ?>);
</script>


</body>
</html>
