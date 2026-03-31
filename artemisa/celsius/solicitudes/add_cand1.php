<?
  include_once "../inc/var.inc.php";
  include_once "../inc/conexion.inc.php";
  Conexion();
  //include_once "../inc/"."identif.php";
  include_once "../inc/"."fgenped.php";
  include_once "../inc/fgentrad.php";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("aus-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  if (! isset($Id))			$Id ="";

 if ($dedonde==1)
  {
   $expresion = "SELECT Apellido,Nombres,EMail,Codigo_Pais,Otro_Pais,Codigo_Institucion,Otra_Institucion,Codigo_Dependencia,Otra_Dependencia,Codigo_Unidad,Otra_Unidad,Codigo_Categoria,Otra_categoria, Direccion,Codigo_Localidad,Otra_Localidad,Telefonos,Comentarios ";
   $expresion = $expresion."FROM Candidatos  WHERE Candidatos.Id =".$Id;
   //echo $expresion;
   $result = mysql_query($expresion);
   $rowg = mysql_fetch_row($result);   
  }	

?>
<html>
<head>
<title>PrEBi </title>
<script language="JavaScript">

tabla_Instituciones = new Array;

tabla_valores = new Array;
tabla_Longitud = new Array;



tabla_Paises = new Array;
tabla_val_Paises = new Array;
tabla_Dependencias = new Array;
tabla_val_Dep = new Array;
tabla_Long_Dep = new Array;
tabla_Unidades = new Array;
tabla_val_Uni = new Array;
tabla_Long_Uni = new Array;

tabla_Localidades = new Array;
tabla_val_Loc = new Array;
tabla_Long_Loc = new Array;

<?

		include_once "../inc/pidu.inc.php";
		armarScriptInstituciones("tabla_Instituciones" , "tabla_valores" , "tabla_Longitud");	
		armarScriptDependencia("tabla_Dependencias" , "tabla_val_Dep" , "tabla_Long_Dep");			
		armarScriptUnidades("tabla_Unidades" , "tabla_val_Uni" , "tabla_Long_Uni");
		armarScriptLocalidades("tabla_Localidades" , "tabla_val_Loc" , "tabla_Long_Loc");
?>

function Generar_Unidades(UniSel)
{
	       	Codigo_Dep=document.forms["partea"].Dependencias.options[document.forms["partea"].Dependencias.selectedIndex].value;
        	if (tabla_Long_Uni[Codigo_Dep]!=null)
        		{

        		 seleccion = 0;
     			 document.forms["partea"].Unidades.length =tabla_Long_Uni[Codigo_Dep]+1;
      			 for (i=0;i<tabla_Long_Uni[Codigo_Dep];i++)
			 {
			 document.forms["partea"].Unidades.options[i].text=tabla_Unidades [Codigo_Dep][i];
			 if (tabla_val_Uni [Codigo_Dep][i]==UniSel)
			   {
				 seleccion = i;
                           }
			 document.forms["partea"].Unidades.options[i].value=tabla_val_Uni [Codigo_Dep][i];
			 }
  
			 document.forms["partea"].Unidades.length=i;
			 document.forms["partea"].Unidades.options[document.forms["partea"].Unidades.length]=new Option("Otra",0);
     		 document.forms["partea"].Unidades.selectedIndex=seleccion;
			 return null;
		   }
			else
			   {
			    	document.forms["partea"].Unidades.length = 0;
					document.forms["partea"].Unidades.options[document.forms["partea"].Unidades.length]=new Option("Otra",0);
			   }

}
function Generar_Dependencias(DepSel){

        		Codigo_Instit=document.forms["partea"].Institucion.options[document.forms["partea"].Institucion.selectedIndex].value;
        		if (tabla_Long_Dep[Codigo_Instit]!=null)
        		{
        		 seleccion = 0;
     			 document.forms["partea"].Dependencias.length =tabla_Long_Dep[Codigo_Instit]+1;
      			 for (i=0;i<tabla_Long_Dep[Codigo_Instit];i++)
                {
                 document.forms["partea"].Dependencias.options[i].text=tabla_Dependencias [Codigo_Instit][i];
                 if (tabla_val_Dep [Codigo_Instit][i]==DepSel)
                 {
                   seleccion = i;
                 }
                 document.forms["partea"].Dependencias.options[i].value=tabla_val_Dep [Codigo_Instit][i];
                }
                document.forms["partea"].Dependencias.length=i;
				document.forms["partea"].Dependencias.options[document.forms["partea"].Dependencias.length]=new Option("Otra",0);

              document.forms["partea"].Dependencias.selectedIndex=seleccion;
			    return null;
			   }
			   else
			   {
			    	document.forms["partea"].Dependencias.length = 0;
					document.forms["partea"].Dependencias.options[document.forms["partea"].Dependencias.length]=new Option("Otra",0);

			   }
		}


function Generar_Instituciones (valorpredet){     

var Codigo_Pais=0;
var indice=0;
var i=0;
					
				
								
           	  Codigo_Pais = document.forms["partea"].Pais.options[document.forms["partea"].Pais.selectedIndex].value;			
                valorsumado = tabla_Longitud[Codigo_Pais];              
                document.forms["partea"].Institucion.length=0;
                
                for (i=0;i<valorsumado;i++)
                {             	
     				 document.forms["partea"].Institucion.options[document.forms["partea"].Institucion.length]=new Option(tabla_Instituciones [Codigo_Pais][i],tabla_valores [Codigo_Pais][i]);	
					  
                   if (document.forms["partea"].Institucion.options[i].value == valorpredet)
                      { indice =i; }
                 }       	 
     
              
                document.forms["partea"].Institucion.options[document.forms["partea"].Institucion.length]=new Option("Otra",0);	
             
              
              // Si el valor predet < 1
              // implica que la seleccion en un Change es Otra 
				
				 if (valorpredet>=0){document.forms["partea"].Institucion.selectedIndex=indice;} 
 		        else {document.forms["partea"].Institucion.selectedIndex=i;}
 
   			 
			    return null;
}
    
function Generar_Localidades (valorpredet){     





var Codigo_Pais=0;
var indice=0;
var i=0;
					
				
								
           	  Codigo_Pais = document.forms["partea"].Pais.options[document.forms["partea"].Pais.selectedIndex].value;			
                valorsumado = tabla_Long_Loc[Codigo_Pais];              
                document.forms["partea"].Localidad.length=0;
                
                for (i=0;i<valorsumado;i++)
                {             	
     				 document.forms["partea"].Localidad.options[document.forms["partea"].Localidad.length]=new Option(tabla_Localidades [Codigo_Pais][i],tabla_val_Loc [Codigo_Pais][i]);	
					  
                   if (document.forms["partea"].Localidad.options[i].value == valorpredet)
                      { indice =i; }
                 }       	 
     
              
                document.forms["partea"].Localidad.options[document.forms["partea"].Localidad.length]=new Option("Otra",0);	
             
              
              // Si el valor predet < 1
              // implica que la seleccion en un Change es Otra 
				
				 if (valorpredet>=0){document.forms["partea"].Localidad.selectedIndex=indice;} 
 		        else {document.forms["partea"].Localidad.selectedIndex=i;}
 
   			 
			    return null;
}

function enviar_campos (){
// Estos campos los envío para presentarle al usuario
      document.forms["partea"].PaisTexto.value=document.forms["partea"].Pais.options[document.forms["partea"].Pais.selectedIndex].text;
      document.forms["partea"].InstitucionTexto.value=document.forms["partea"].Institucion.options[document.forms["partea"].Institucion.selectedIndex].text;			  
      return null;			    
}

function verifica_Apellido()
{
	if (document.forms["partea"].Apellido.value.length==0 || document.forms["partea"].Apellido.value.substring(0,3)=="***")	 
		{
		  document.forms["partea"].Apellido.value = "<? echo $Mensajes ["me-1"];?>";
		  return false;
		}
    else
       {
         return true;
      }
 }        
 
function verifica_Nombre()
{
	if (document.forms["partea"].Nombres.value.length==0 || document.forms["partea"].Nombres.value.substring(0,3)=="***")	 
		{
		  document.forms["partea"].Nombres.value = "<? echo $Mensajes ["me-1"];?>";
		  return false;
		}
    else
       {
         return true;
      }
 }        
 
function verifica_Email()
{
	if (document.forms["partea"].Mail.value.length==0 || document.forms["partea"].Mail.value.substring(0,3)=="***")	 
		{
		  document.forms["partea"].Mail.value = "<? echo $Mensajes ["me-1"];?>";
		  return false;
		}
   else {
         if (document.forms["partea"].Mail.value.indexOf('@',0)== -1 || document.forms["partea"].Mail.value.indexOf('.',0)== -1)
           {
       		  document.forms["partea"].Mail.value = "<? echo $Mensajes ["me-2"];?>";
	            return false; }
		  else {
		      return true; }
         } 

}         

function verifica_Pais()
{
	if (document.forms["partea"].Pais.value==0 && document.forms["partea"].OtroPais.value.length==0)	 
		{
			alert ("<? echo $Mensajes ["me-3"];?>");
			return false;
		}
   else {
   
           if (document.forms["partea"].Pais.value!=0 && document.forms["partea"].OtroPais.value.length>0)	 
   			   {    alert ("<? echo $Mensajes ["me-4"];?>");
                  return false;   			}
   			else { return true; }  
         }    

}         

function verifica_Institucion()
{
	if (document.forms["partea"].Institucion.value==0 && document.forms["partea"].OtraInstitucion.value.length==0)	 
		{
			alert ("<? echo $Mensajes ["me-5"];?>");
			return false;
		}
   else {
   			if (document.forms["partea"].Institucion.value!=0 && document.forms["partea"].OtraInstitucion.value.length>0)	 
   			{
				alert ("<? echo $Mensajes ["me-6"];?>");
				return false;

   			}
   			else
			{
		      return true; 
		    }  
         } 
	
}

function verifica_Dependencia()
{
	if (document.forms["partea"].Dependencias.value==0 && document.forms["partea"].OtraDependencia.value.length==0)	 
		{
			alert ("<? echo $Mensajes ["me-7"];?>");
			return false;
		}
   else {
   			if (document.forms["partea"].Dependencias.value!=0 && document.forms["partea"].OtraDependencia.value.length>0)	 
   			{
				alert ("<? echo $Mensajes ["me-8"];?>");
				return false;

   			}
   			else
			{
		      return true; 
		    }  
         } 
	
}

function verifica_Unidad()
{
	if (document.forms["partea"].Unidades.value==0 && document.forms["partea"].OtraUnidad.value.length==0)	 
		{
			alert ("<? echo $Mensajes ["me-9"];?>");
			return false;
		}
   else {
   			if (document.forms["partea"].Unidades.value!=0 && document.forms["partea"].OtraUnidad.value.length>0)	 
   			{
				alert ("<? echo $Mensajes ["me-10"];?>");
				return false;

   			}
   			else
			{
		      return true; 
		    }  
         } 
	
}

function verifica_Actividad()
{
	if (document.forms["partea"].Categoria.value==0 && document.forms["partea"].OtraActividad.value.length==0)	 
		{
			alert ("<? echo $Mensajes ["me-11"];?>");
			return false;
		}
   else {
   			if (document.forms["partea"].Categoria.value!=0 && document.forms["partea"].OtraActividad.value.length>0)	 
   			{
				alert ("<? echo $Mensajes ["me-12"];?>");
				return false;

   			}
   			else
			{
		      return true; 
		    }  
         } 
	
}

function verifica_Localidad()
{
	if (document.forms["partea"].Localidad.value==0 && document.forms["partea"].OtraLocalidad.value.length==0)	 
		{
			alert ("<? echo $Mensajes ["me-15"];?>");
			return false;
		}
   else {
   			if (document.forms["partea"].Localidad.value!=0 && document.forms["partea"].OtraLocalidad.value.length>0)	 
   			{
				alert ("<? echo $Mensajes ["me-16"];?>");
				return false;

   			}
   			else
			{
		      return true; 
		    }  
         } 
	
}


function verifica_Telefono()
{
	if (document.forms["partea"].Telefono.value.length==0 || document.forms["partea"].Telefono.value.substring(0,3)=="***")	 
		{
		  document.forms["partea"].Telefono.value = "<? echo $Mensajes ["me-1"];?>";
		  return false;
		}
    else
       {
         return true;
      }
 } 

function verifica_campos()
{
	valor1 = true;
	valor1 = (valor1 && verifica_Apellido());
	valor1 = (valor1 && verifica_Nombre());	
	valor1 = (valor1 && verifica_Email());
    valor1 = (valor1 && verifica_Pais());
    valor1 = (valor1 && verifica_Institucion());
	valor1 = (valor1 && verifica_Dependencia());
	valor1 = (valor1 && verifica_Unidad());
	valor1 = (valor1 && verifica_Actividad());
	valor1 = (valor1 && verifica_Localidad());
	valor1 = (valor1 && verifica_Telefono());
	if (valor1==true)
	{
		enviar_campos();
		document.forms["partea"].action = "upd_cand.php";
		return true;
	} 
	
	return valor1;
 
}

function Generar(valor)
{
	Generar_Instituciones(valor);
	Generar_Localidades(valor);
}

</script>   
<style type="text/css">
<!--
body {
	margin:0px;
	background-color: #006599;
	margin-left: 10px;
	background-image: url();
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
.style42 {color: #FFFFFF; font-family: verdana; font-size: 9px; }
-->
</style>
 <base target="_self"> 
</head>

<body topmargin="0">
<div align="left">
<form name="partea" method="POST" onSubmit ="return verifica_campos();" >
 <input type="hidden" name="Desc_Inst">
 <input type="hidden" name="PaisTexto">
 <input type="hidden" name="InstitucionTexto">
 <input type="hidden" name="dedonde" value="<? echo $dedonde; ?>">
 <input type="hidden" name="Id" value="<? echo $Id; ?>">
  
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
                    <td height="20" colspan="2" valign="middle" bgcolor="#006699" class="style42"><div align="center"><? echo $Mensajes["et-3"];?> </div></td>
                    </tr>
                  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-1"]; ?></div></td>
                    <td width="*" valign="top" >
                      <div align="left">
                        <input name="Apellido"  type="text" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[0]; ?>">
                      </div></td>
                  </tr>
                  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-2"]; ?></div></td>
                    <td valign="top">
                      <div align="left">
                        <input name="Nombres"  type="text" class="style33" size="50" value="<?if (isset($rowg)) echo $rowg[1]; ?>">
                      </div></td>
                  </tr>
				   <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22">
                    <div align="right">  <? echo $Mensajes["ec-3"]; ?></div></td>
                    <td valign="top">
                      <div align="left">
                        <input name="Mail" type="text" class="style33" size="50" value="<? if (isset($rowg)) echo $rowg[2]; ?>">
                            </div></td>
                  </tr>
                  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-4"]; ?></div></td>
                    <td valign="top" align=left>
					<select name="Pais" class="style33" onChange="Generar(0)">
						<?        
						$Instruccion = "SELECT Id,Nombre FROM Paises ORDER BY Nombre";	
						$result = mysql_query($Instruccion); 
						while ($row =mysql_fetch_row($result))
						{                  
											  
						if ($dedonde==1 ){
								if (isset($rowg) && $row[0]==$rowg[3]) 
								{echo "<option selected value='".$row[0]."'>".$row[1]."</option>";}        	  
								else {echo "<option value='".$row[0]."'>".$row[1]."</option>";}                       
						}
							else {echo "<option value='".$row[0]."'>".$row[1]."</option>";}                       
						 }        
						
					      
						if (isset($rowg) && $rowg[3]==0) 
								echo "<option  value='0' selected>Otra</option>";
								else
								echo "<option value='0'>Otra</option>";                          
					   
					   ?>  	
					   
					 </select>
                    </td>
                  </tr>


				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-5"]; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtroPais" class="style33" size="50" value="<? if (isset($rowg)) echo $rowg[4]; ?>" >                   
                    </td>
                  </tr>
				  
                  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-6"]; ?></div></td>
                    <td valign="top" align=left> <select name="Institucion" class="style33" OnChange="Generar_Dependencias(0)">
                    </select>
                    </td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-7"]; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraInstitucion" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[6]; ?>">
                    </td>
                  </tr>
				   <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-8"]; ?></div></td>
                    <td valign="top" align=left> <select name="Dependencias" class="style33" OnChange="Generar_Unidades(0)">
                    </select>
                    </td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-9"]; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraDependencia" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[8]; ?>">
                    </td>
                  </tr>

				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-10"]; ?></div></td>
                    <td valign="top" align=left> <select name="Unidades" class="style33" >
                    </select>
                    </td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-11"]; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraUnidad" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[10]; ?>" >
                    </td>
                  </tr>

				   <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-12"]; ?></div></td>
                    <td valign="top" align=left><select name="Categoria" class="style33" >

					 
                       <?
                      $Instruccion = "SELECT Id,Nombre FROM Tab_Categ_usuarios ORDER BY Nombre";
                      $result = mysql_query($Instruccion);
                      while ($row =mysql_fetch_row($result))
                     {
                       
                        if ($dedonde==1 )
							if( isset ($rowg) && $row[0]==$rowg[11]){    
							 echo "<option selected value='".$row[0]."'>".$row[1]."</option>";}
							 else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
							 else { echo "<option value='".$row[0]."'>".$row[1]."</option>";}          
										
					  }       
					  if ($dedonde==1 && $rowg[11]==0) {
										echo "<option selected value='0'>".$Mensajes["ofe-1"]."</option>";}       
							 else	{ echo "<option value='0'>".$Mensajes["ofe-1"]."</option>";}     
                     ?>
                   </select></td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-13"]; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraActividad" class="style33" size="50" 
					value="<? if (isset($rowg))echo $rowg[12]; ?>" >
                    </td>
                  </tr>				  
				
				   <tr>
                    <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"> <? echo $Mensajes["ec-14"]; ?></div></td>
                    <td valign="top" align=left><input name="Direccion" type="text" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[13]; ?>">
                    </td>
                  </tr>
				   <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-15"]; ?></div></td>
                    <td valign="top" align=left>
                       <select name="Localidad" class="style33"size="1">       
                   </select></td>
                  </tr>
				  <tr>
                    <td width="30%" valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-16"]; ?></div></td>
                    <td valign="top" align=left> <input type="text" name="OtraLocalidad" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[15]; ?>">
                    </td>
				</tr>
				  
                  <tr>
                    <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-17"]; ?></div></td>
                    <td valign="top" align=left><input name="Telefono" type="text" class="style33" size="50" value="<? if (isset($rowg))echo $rowg[16]; ?>">
                    </td>
                  </tr>

                  <tr>
                    <td valign="middle" bgcolor="#CCCCCC" class="style22"><div align="right"><? echo $Mensajes["ec-18"]; ?></div></td>
                    <td valign="top" align=left><TEXTAREA NAME="Comentarios" ROWS="5" COLS="40" class="style33"><? if (isset($rowg))echo $rowg[17]; ?></TEXTAREA>
                    </td>
                  </tr>
                  

                  <tr>
                    <td colspan="2" class="style22"><div align="right"></div>                      <div align="center">					
                          <input name="B1" type="submit" class="style22" value="<? echo $Mensajes["bot-1"]; ?>" >
                          <input name="resetButton" type="reset" class="style22" value="<? echo $Mensajes["bot-2"]; ?>">
                      </div></td>
                    </tr>
                </table>
              </center>
            </div>            </td>
        <td width="150" valign="top"><div align="center" class="style22">
          <div align="left"><img src="../images/teclado.jpg" width="150" height="200"> </div>
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
<script language='JavaScript'>
   <?
if ($dedonde==1)
   {
     if (isset($rowg) && ($rowg[5]>0) ){
       echo "Generar_Instituciones(".$rowg[5].");";
     } else {
       echo "Generar_Instituciones(-1);";
     }  

   }
   else
   {  
	  echo "Generar_Instituciones(0);";
	}


//echo "alert(".$rowg[5].");";

	
if ($dedonde==1)
   {
     if (isset($rowg) && ($rowg[7]>0) ){
       echo "Generar_Dependencias(".$rowg[7].");";
     } else {
       echo "Generar_Dependencias(-1);";
     }  

   }
   else
   {  
	  echo "Generar_Dependencias(0);";
	}


if ($dedonde==1)
   {
     if (isset($rowg) && ($rowg[9]>0) ){
       echo "Generar_Unidades(".$rowg[9].");";
     } else {
       echo "Generar_Unidades(0);";
     }  

   }
   else
   {  
	  echo "Generar_Unidades(0);";
	}
if ($dedonde==1)
   {
     if (isset($rowg) && ($rowg[14]>0) ){
       echo "Generar_Localidades(".$rowg[14].");";
     } else {
       echo "Generar_Localidades(0);";
     }  

   }
   else
   {  
	  echo "Generar_Localidades(0);";
	}
//Generar_Dependencias(0); Generar_Localidades(0); Generar_Unidades(0);
	?>




</script>
<?
  
   Desconectar();
 ?>

</body>
</html>