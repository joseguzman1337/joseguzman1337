<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."identif.php";
  include_once "../inc/"."validacion.inc";
  Usuario();
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("app-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  $Campos = ObtenerVectorCampos ($IdiomaSitio,4);
  $CamposFijos = ObtenerVectorCampos ($IdiomaSitio,0);
?>
<head>
<title><? echo Titulo_Sitio(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../celsius.css" rel="stylesheet" type="text/css">
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {color: #006599}
.style42 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
-->
</style>
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
		//armarScriptUnidades("tabla_Unidades" , "tabla_val_Uni" , "tabla_Long_Uni");
		//armarScriptLocalidades("tabla_Localidades" , "tabla_val_Loc" , "tabla_Long_Loc");
?>


function Generar_Dependencias(DepSel){

        		Codigo_Instit=document.forms["partea"].InstitucionTesis.options[document.forms["partea"].InstitucionTesis.selectedIndex].value;
        		if (tabla_Long_Dep[Codigo_Instit]!=null)
        		{
        		 seleccion = 0;
     			 document.forms["partea"].DependenciaTesis.length =tabla_Long_Dep[Codigo_Instit]+1;
      			 for (i=0;i<tabla_Long_Dep[Codigo_Instit];i++)
                {
                 document.forms["partea"].DependenciaTesis.options[i].text=tabla_Dependencias [Codigo_Instit][i];
                 if (tabla_val_Dep [Codigo_Instit][i]==DepSel)
                 {
                   seleccion = i;
                 }
                 document.forms["partea"].DependenciaTesis.options[i].value=tabla_val_Dep [Codigo_Instit][i];
                }
                document.forms["partea"].DependenciaTesis.length=i;
				document.forms["partea"].DependenciaTesis.options[document.forms["partea"].DependenciaTesis.length]=new Option("Otra",0);

              document.forms["partea"].DependenciaTesis.selectedIndex=seleccion;
			    return null;
			   }
			   else
			   {
			    	document.forms["partea"].DependenciaTesis.length = 0;
					document.forms["partea"].DependenciaTesis.options[document.forms["partea"].DependenciaTesis.length]=new Option("Otra",0);

			   }
		}


function Generar_Instituciones (valorpredet){     

var Codigo_Pais=0;
var indice=0;
var i=0;
					
				
								
           	  Codigo_Pais = document.forms["partea"].PaisTesis.options[document.forms["partea"].PaisTesis.selectedIndex].value;			
                valorsumado = tabla_Longitud[Codigo_Pais];              
                document.forms["partea"].InstitucionTesis.length=0;
                
                for (i=0;i<valorsumado;i++)
                {             	
     				 document.forms["partea"].InstitucionTesis.options[document.forms["partea"].InstitucionTesis.length]=new Option(tabla_Instituciones [Codigo_Pais][i],tabla_valores [Codigo_Pais][i]);	
					  
                   if (document.forms["partea"].InstitucionTesis.options[i].value == valorpredet)
                      { indice =i; }
                 }       	 
     
              
                document.forms["partea"].InstitucionTesis.options[document.forms["partea"].InstitucionTesis.length]=new Option("Otra",0);	
             
              
              // Si el valor predet < 1
              // implica que la seleccion en un Change es Otra 
				
				 if (valorpredet>=0){document.forms["partea"].InstitucionTesis.selectedIndex=indice;} 
 		        else {document.forms["partea"].InstitucionTesis.selectedIndex=i;}
 
   			 
			    return null;
}
    

function Generar(valor)
{  
	Generar_Instituciones(valor);
//	Generar_Localidades(valor);
}

function ayuda (tabla,campo)
{
  ventana=window.open("help.php?Tabla="+tabla+"&campo="+campo,"Ayuda","dependent=yes,toolbar=no,width=512,height=120");
}


function verifica_campos()
{

  <? devuelve_validacion_tesis($Campos); ?>
   
   document.forms.partea.submit();
   
}

</script>
<base target="_self">

</head>

<body topmargin="0">
<?
    $Titulo_Revista = "";
   if (isset($Id_Col))
   {
	if ($Id_Col!=0)
    {
    	 $expresion = "SELECT Nombre,Id FROM Titulos_Colecciones WHERE Id=".$Id_Col;
         $result = mysql_query($expresion);
         if ($row = mysql_fetch_row($result))
         {
           $Titulo_Revista = stripslashes($row[0]);
		 }
    }
   }
     else $Id_Col = 0;
?>

<div align="left">
<form name="partea" method="POST" action="registra_ped.php?TipoMat=4" onsubmit="return false";>
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
        <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">            <div align="center">
              <center>
                <table width="97%"  border="0" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td height="20" colspan="3" bgcolor="#006599" class="style42"> <div align="center"><img src="../images/square-lb.gif" width="8" height="8"> <? echo $Mensajes["cf-17"]; ?> <img src="../images/square-lb.gif" width="8" height="8"></div></td>
                    </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $CamposFijos[200][0]; ?></div></td>
                    <td align="left" valign="middle">
                       <? 
		      // Agregado 24-9 para evitar que los pedidos ingresen con
			  // esta opcion cuando los carga el usuario voy a testear
			  // si está usando este script alguien que no sea staff
			  // si es de la misma institución que la predetrminada
			  // entra como pedido de busqueda sino como provisión
			  
		      $opcion1="Operacion_1";
           	  $opcion2="Operacion_2"; 
              echo "<span><select size='1' name='Tipo_Pedido' style='visibility:hidden;position:absolute' id='busq_prov'>"; 
              echo "<option value='1'>$VectorIdioma[$opcion1]</option> "; 
			  echo "<option value='2'>$VectorIdioma[$opcion2]</option> "; 
			  echo "</select> </span>";
			  echo "<span id='textoTipoPedido'> <font face='MS Sans Serif' size='1' color='#000099'><b>
			  <script>
			  function mostrarTipoPed() {
				  document.getElementById('busq_prov').style.visibility = 'visible';
				  document.getElementById('textoTipoPedido').style.visibility = 'hidden';
				  
			  } ";

			  $tipoPed = tipo_pedido($Alias_Id);
			  if ($tipoPed) {
			    echo "document.forms.partea.Tipo_Pedido[0].selected = true; </script>".$VectorIdioma[$opcion1];
			  }
			  else {
			    echo "document.forms.partea.Tipo_Pedido[1].selected = true; </script>".$VectorIdioma[$opcion2];
			  }
              echo "</b>&nbsp;&nbsp; <a href='Javascript:mostrarTipoPed()'> <span style='size:8px;color:#000099'>Cambiar</span> </a> </font></span>";
		
		  
			  // Agregado 24-9 para evitar que los pedidos ingresen con
			  // esta opcion cuando los carga el usuario voy a testear
			  // si está usando este script alguien que no sea staff
			  // si es de la misma institución que la predetrminada
			  // entra como pedido de busqueda sino como provisión

		     /* $opcion1="Operacion_1";
           	  $opcion2="Operacion_2";
              echo "<select size='1' name='Tipo_Pedido' class='style23'>";
              echo "<option selected value='1'>$VectorIdioma[$opcion1]</option> ";
			  echo "<option value='2'>$VectorIdioma[$opcion2]</option> ";
			  echo "</select>";
*/
			  ?>
                 </td>
                 <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(0,200)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[1][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="TituloTesis"  value="<?if (!isset($TituloTesis)) {$TituloTesis = '';}
					echo $TituloTesis; ?>" type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,1)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[2][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="AutorTesis" type="text" class="style23" size="60" value="<? if (!isset($AutorTesis)) {$AutorTesis= '';} echo $AutorTesis; ?>" ></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,2)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[3][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="DirectorTesis" value ="<? if (!isset($DirectorTesis)) {$DirectorTesis = '';} echo $DirectorTesis;?>" type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,3)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[4][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="GradoAccede" type="text" value="<?if (!isset($GradoAccede)) {$GradoAccede = '';} echo $GradoAccede; ?>" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,4)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[5][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="AnioTesis" value="<? if (!isset($AnioTesis)) {$AnioTesis = '';} echo $AnioTesis; ?>" type="text" class="style23" size="4"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,5)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"> <? echo $Campos[6][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="PagCapitulo" value="<? if (!isset($PagCapitulo)) {$PagCapitulo = '';} echo $PagCapitulo; ?>" type="text" class="style23" size="40"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,6)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"> <? echo $Campos[7][0]; ?></div></td>
                    <td align="left" valign="middle">
					<select name="PaisTesis" class="style23" onChange="Generar(0)">
						<?        
						$Instruccion = "SELECT Id,Nombre FROM Paises ORDER BY Nombre";	
						$result = mysql_query($Instruccion); 
						while ($row =mysql_fetch_row($result))
						{                  
						   	  
						 echo "<option value='".$row[0]."'>".$row[1]."</option>";                       
						 }        
						
						  echo "<option value='0'>Otra</option>";                          
					   ?>  					 
					 </select>
					
										
					</td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,7)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[8][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="OtroPaisTesis" value="<? if (!isset($OtroPaisTesis)) {$OtroPaisTesis = '';} echo $OtroPaisTesis; ?>" type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,8)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[9][0]; ?></div></td>
                    <td align="left" valign="middle"><select name="InstitucionTesis" OnChange="Generar_Dependencias(0)" class="style23">
                    </select></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,9)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"> <? echo $Campos[10][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="OtraInstitucionTesis" value="<? if (!isset($OtraInstitucionTesis)) {$OtraInstitucionTesis = '';} echo $OtraInstitucionTesis; ?>" type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,10)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"> <? echo $Campos[11][0]; ?></div></td>
                    <td align="left" valign="middle"><select name="DependenciaTesis" class="style23" >
                    </select></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,11)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[12][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="OtraDependenciaTesis" value="<? if (!isset($OtraDependenciaTesis)) {$OtraDependenciaTesis = '';} echo $OtraDependenciaTesis; ?>"type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,12)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $CamposFijos[204][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="Biblioteca" value="<? if (!isset($Biblioteca)) {$Biblioteca = '';} echo $Biblioteca; ?>" type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,204)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="top" bgcolor="#cccccc" class="style23"><div align="right"><? echo $CamposFijos[205][0]; ?></div></td>
                    <td align="left" valign="middle"><textarea name="Observaciones" cols="60" rows="4" class="style23"><? if (!isset($Observaciones)) {$Observaciones = '';} echo $Observaciones; ?></textarea></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(4,205)"><img src="../images/help.gif" border=0 width="22" height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td align="center" class="style23">
                      <div align="center">                      </div></td>
                    <td align="center" class="style23"><div align="left">
                        <input name="Enviar" type="button" class="style23" value="<? echo $Mensajes["botc-3"]; ?>" onclick='verifica_campos()'>
                        <input name="reset" type="reset" class="style23" value="<? echo $Mensajes["botc-4"]; ?>">
                    </div></td>
                    <td width="30">&nbsp;</td>
                  </tr>
                </table>
              </center>
            </div>            </td>
       <? if ($Rol!=1)
		   {
		?>
		<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
        <? dibujar_menu_usuarios($Usuario,1); ?>
          </div></td>
		  <?
		   }
		  else
		  {
		  ?>
            <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php"><? echo $Mensajes["cf-13"]; ?></a></span></p>
                  </div>                  </td>
          </div></td>
		  <?
		  }	  
		  ?>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">app-001</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
      <input type="hidden" name="Codigo_Autor_Libro" value=0>
  	   <input type="hidden" name="Titulos_Colecciones" value=0>
		<input type="hidden" name="Codigo_Usuario_Busca" value=0>
		<input type="hidden" name="Codigo_Usuario_Entrega" value=0>
		<input type="hidden" name="Tipo_Material" value=4>
		<input type="hidden" name="PaisCongreso" value=0>
		<input type="hidden" name="Indice" value=0>
      <input type="hidden" name="Pais" value=0>
       <input type="hidden" name="Alias_Id" value='<? if (isset($Alias_Id)) { echo $Alias_Id; }?>'>
    	<input type="hidden" name="Instit_Alias" value='<? if (isset($Instit_Alias)) {echo $Instit_Alias; } ?>'>
		<input type="hidden" name="Alias_Comunidad" value='<? if (isset($Alias_Comunidad)) { echo $Alias_Comunidad; } ?>'>
		<input type="hidden" name="Bandeja" value='<? if (!isset($Bandeja)) {$Bandeja = 0;} echo $Bandeja; ?>'>



    </form>

</div>
<script language="JavaScript">
Generar_Instituciones(0);
Generar_Dependencias(0);
//Generar_Localidades(0);
//Generar_Unidades(0);
 </script>

</body>
</html>
