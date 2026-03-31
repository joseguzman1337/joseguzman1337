<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."identif.php";
  Usuario();
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."validacion.inc";
  global $Rol;
  global $IdiomaSitio;
  $Mensajes = Comienzo ("app-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  $Campos = ObtenerVectorCampos ($IdiomaSitio,2);
  $CamposFijos = ObtenerVectorCampos ($IdiomaSitio,0);

?>
<head>
<title><? echo Titulo_Sitio(); ?></title>
<link href="../celsius.css" rel="stylesheet" type="text/css">
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
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

function agrega_autor()
{
	numeroAut=<? if (isset($CantAutor) )
                 echo $CantAutor;
                 else {
                 echo "1";
				 $CantAutor = 1; }
                 ?>;
 	document.forms.form1.Alias_Id.value=<? if (isset($Alias_Id)) { echo $Alias_Id;} else { echo "''";} ?>;
 	document.forms.form1.Instit_Alias.value=<? if (isset($Instit_Alias)) { echo $Instit_Alias;} else { echo "''";} ?>;
    document.forms.form1.Alias_Comunidad.value="<? if (isset($Alias_Comunidad)) { echo $Alias_Comunidad;} else { echo "''";} ?>";
 	document.forms.form1.Bandeja.value = "<?  if (!isset($Bandeja)){$Bandeja='';} echo $Bandeja; ?>";
   	document.forms.form1.CantAutor.value = <? echo $CantAutor+1; ?>;
 	document.forms.form1.action = "agrega_cap.php";
  	document.forms.form1.submit();
}



function verifica_campos()
{ 
<?  Devuelve_validacion_libros($Campos); ?> 
      document.forms.form1.submit();
     
}



function ayuda (tabla,campo)
{
  ventana=window.open("help.php?Tabla="+tabla+"&campo="+campo,"Ayuda","dependent=yes,toolbar=no,width=512,height=120");
}




</script>


<base target="_self">
</head>

<body topmargin="0">


<div align="left">
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
              <form name="form1" method="POST" action="registra_ped.php?TipoMaterial=2" onsubmit="return false;" >
                <table width="97%"  border="0" cellpadding="0" cellspacing="0">
                  <tr align="center">
                    <td height="20" colspan="3" bgcolor="#006599" class="style42"> <div align="center"><img src="../images/square-lb.gif" width="8" height="8"><? echo $Mensajes["cf-14"]; ?><img src="../images/square-lb.gif" width="8" height="8"></div></td>
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
			    echo "document.forms.form1.Tipo_Pedido[0].selected = true; </script>".$VectorIdioma[$opcion1];
			  }
			  else {
			    echo "document.forms.form1.Tipo_Pedido[1].selected = true; </script>".$VectorIdioma[$opcion2];
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
                    <td align="left" valign="middle"><input type="text" name="Titulo" size="60" value="<? if (!isset($Titulo)){$Titulo='';}echo $Titulo; ?>" class="style23">  </td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,1)"><img src="../images/help.gif" width="22" border=0 height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[2][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="AutorTitulo" type="text" value="<? if (!isset($AutorTitulo)){$AutorTitulo='';} echo $AutorTitulo; ?>" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,2)"><img src="../images/help.gif" width="22" border=0 height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[3][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="Editorial" type="text" value="<?  if(!isset($Editorial)) {$Editorial='';}  echo $Editorial; ?>" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,3)"><img src="../images/help.gif" width="22" height="22" border=0></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right">  <? echo $Campos[4][0]; ?></div></td>
                    <td align="left" valign="middle"><input type="text" name="AnioLibro" value="<? if (!isset($AnioLibro)){$AnioLibro='';} echo $AnioLibro; ?>" class="style23" size="40"></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,4)"><img src="../images/help.gif" width="22" border=0 height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[5][0]; ?></div></td>
                    <td align="left" valign="middle"><input type="checkbox" name="Indice" class="style23" value="ON" <? if (isset($Indice)){ if ($Indice=="ON") { echo "checked"; }} ?>></td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,5)"><img src="../images/help.gif" width="22" border=0 height="22"></a></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[6][0]; ?></div></td>
                    <td align="left" valign="middle"><input type="text" name="Capitulo_Libro" size="60" class="style23" value="<? if  (!isset($Capitulo_Libro)){$Capitulo_Libro='';}echo $Capitulo_Libro; ?>">                    </td>
                    <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,6)"><img src="../images/help.gif" width="22" border=0 height="22"></a></div></td>
                  </tr>


                  <?
                  if ($CantAutor == '')
                      $CantAutor = 1;
                   for ($i=1;$i<=$CantAutor;$i++)
                  { ?>
                  <tr>
                  <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23">
                  <div align="right"><? echo $Campos[7][0]; ?></div>   </td>
                  <td align="left" valign="middle">
                  <input type="text" size="55" name="Autor<? echo $i; ?>" class="style23" value = "<?  $nombrevar="Autor".$i; 
				  if (isset($$nombrevar)) { echo $$nombrevar; } ?>">
                  <? if ($i==$CantAutor and $i<=2)
                 {
                 ?>
                  <input type="button" value="+" name="B1" onClick="agrega_autor()"> </td>
                  <?
                  }
                 ?>
                 <td width="30" align="center" valign="top"><div align="center"><a href="javascript:ayuda(2,7)"><img src="../images/help.gif" width="22" height="22" border=0></a></div></td>
                 <?
                } ?>
                </tr>
                 <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[8][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="PagDesde" type="text" class="style23" size="40"></td>
                    <td width="30" align="center" valign="top"><div align="center"><img src="../images/help.gif" width="22" height="22"></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $Campos[9][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="PagHasta" type="text" class="style23" size="40"></td>
                    <td width="30" align="center" valign="top"><div align="center"><img src="../images/help.gif" width="22" height="22"></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="middle" bgcolor="#cccccc" class="style23"><div align="right"><? echo $CamposFijos[204][0]; ?></div></td>
                    <td align="left" valign="middle"><input name="Biblioteca" type="text" class="style23" size="60"></td>
                    <td width="30" align="center" valign="top"><div align="center"><img src="../images/help.gif" width="22" height="22"></div></td>
                  </tr>
                  <tr>
                    <td width="150" align="right" valign="top" bgcolor="#cccccc" class="style23"><div align="right"><? echo $CamposFijos[205][0]; ?></div></td>
                    <td align="left" valign="middle"><textarea name="Observaciones" cols="60" rows="4" class="style23"></textarea></td>
                    <td width="30" align="center" valign="top"><div align="center"><img src="../images/help.gif" width="22" height="22"></div></td>
                  </tr>
                  <tr>
                    <td align="center" class="style23">
                      <div align="center">                      </div></td>
                    <td align="center" class="style23"><div align="left">
                        <input name="Submit" type="button" class="style23" value="<? echo $Mensajes["botc-3"]; ?>" onClick="verifica_campos()">
                        <input name="Submit2" type="reset" class="style23" value="<? echo $Mensajes["botc-4"]; ?>">
                    </div></td>
                    <td width="30">&nbsp;</td>
                  </tr>
                </table>
        <input type="hidden" name="Tipo_Material" value=2>
        <input type="hidden" name="Codigo_Autor_Libro" value=0>
	    <input type="hidden" name="Pais" value=0>
  	    <input type="hidden" name="Titulos_Colecciones" value=0>
		<input type="hidden" name="Codigo_Usuario_Busca" value=0>
		<input type="hidden" name="Codigo_Usuario_Entrega" value=0>
		<input type="hidden" name="PaisCongreso" value=0>
		<input type="hidden" name="PaisTesis" value=0>
		<input type="hidden" name="InstitucionTesis" value=0>
		<input type="hidden" name="DependenciaTesis" value=0>
		<input type="hidden" name="CantAutor" value=<? if (isset($CantAutor))
                                                          echo $CantAutor;
                                                          else echo "1"; ?>>
    	<input type="hidden" name="Alias_Id" value='<? if (isset($Alias_Id)) {echo $Alias_Id;} ?>'>
		<input type="hidden" name="Instit_Alias" value='<? if (isset($Instit_Alias)) {echo $Instit_Alias; }?>'>
		<input type="hidden" name="Alias_Comunidad" value='<? if (isset($Alias_Comunidad)) {echo $Alias_Comunidad;} ?>'>
		<input type="hidden" name="Bandeja" value='<? if (!isset($Bandeja)){$Bandeja='';} echo $Bandeja; ?>'>

               </form>

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
</div>
</body>
</html>
