<?
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   Conexion();	
   include_once "../inc/"."identif.php"; 
   Administracion();
   if (!isset($Operacion))		$Operacion =0;
   if (!isset($IdiomaPivot))	$IdiomaPivot =0;
   if (!isset($IdiomaDestino))	$IdiomaDestino =$IdiomaSitio; 
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
<script language="JavaScript">
 function confirmar()
 {
   	if (confirm("Con esta operación eliminará las definiciones seleccionadas. Confirma la Operación?"))
 	{
 	   return true;
 	}
 	else
 	{
 		return false;
 	}
 	
 }
 function envia_campos()
 {
	document.forms.form1.IdiomaNombre.value = document.forms.form1.IdiomaDestino.options[document.forms.form1.IdiomaDestino.selectedIndex].text; 
	document.forms.form1.action="elige_campos.php";
	document.forms.form1.submit();
 }
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #006599;
	margin-left: 10px;
	margin-right:0px; margin-top:0px; margin-bottom:0px
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
	color: #000000;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 9px;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style56 {color: #00FFFF}
.style66 {
	color: #006699;
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.style11Copy {
color: #000000; font-family: Arial, Helvetica, sans-serif; font-size: 9px;
}
.style67 {font-size: 9px}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 

  include_once "../inc/"."fgenped.php"; 
  include_once "../inc/"."fgentrad.php"; 
  global $IdiomaSitio;
   $Mensajes = Comienzo ("sca-001",$IdiomaSitio);  
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
    ?>
<form method="POST" name="form1">
<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">            <div align="center">
              <center>
            <table width="95%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="1" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" align="left" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["ele-1"] ; ?>&nbsp;<? echo Devolver_Tipo_Material($VectorIdioma,$Tipo_Material); ?><span class="style56"></span></td>
                  </tr>
                  <tr>
                    <td align="left" class="style45"><table width="450" border="0" align="center" cellpadding="1" cellspacing="0" bgcolor="#CCCCCC">
                      <tr class="style43">
                        <td width="40%" align="left" bgcolor="#0099CC" class="style45"><div align="right"><? echo $Mensajes["ele-2"];?> </div></td>
                        <td align="left" bgcolor="#0099CC" class="style45"><div align="left">
                          <select size="1" name="IdiomaPivot" class="style43">
							<? $Instruccion = "SELECT Id,Nombre FROM Idiomas ORDER BY Nombre";
							   $result =  mysql_query($Instruccion); 
							   while ($row =mysql_fetch_row($result))
								{ if ($row[0]==$IdiomaPivot) {?>
							<option value="<?echo $row[0];?>" selected><? echo $row[1]; ?></option>
							<? } else { ?>
							<option value="<?echo $row[0];?>"><? echo $row[1]; ?></option>
							<? } } ?> 
						  </select>
                        </div></td>
                      </tr>
                      <tr class="style43">
                        <td width="40%" align="left" bgcolor="#0099CC" class="style45"><div align="right"><?echo $Mensajes["ele-3"];?>
                              
                      </div></td>
                        <td align="left" bgcolor="#0099CC" class="style45"><div align="left">
                          <select size="1" name="IdiomaDestino" class="style43">
            <? mysql_data_seek ($result,0); 
               while ($row=mysql_fetch_row($result)) 
               { if ($row[0]==$IdiomaDestino)
            {?>
            <option value="<?echo $row[0];?>" selected><? echo $row[1]; ?></option>
            <? } else { ?>
            <option value="<?echo $row[0];?>"><? echo $row[1]; ?></option>
            <? } } ?>
          </select>
                        </div></td>
                      </tr>
                      <tr class="style43">
                        <td width="40%" align="left" bgcolor="#0099CC" class="style45">
                          <div align="right"></div></td>
                        <td align="left" bgcolor="#0099CC" class="style45"><div align="left">
                          <input type="submit" value="Enviar" name="B1" OnClick="envia_campos()" class="style11Copy" >
						  <input type="hidden" name="Tipo_Material" value="<? echo $Tipo_Material; ?>" >
						  <input type="hidden" name="IdiomaNombre">
						</div></td>
                      </tr>
                    </table>                      
					</form>
					<?   
   
   if ($Operacion==3)
   {
    	$expresion = "DELETE FROM Campos WHERE Tipo_Material=".$Tipo_Material." AND Numero_Campo=".$Numero_Campo." AND Codigo_Idioma=".$Codigo_Idioma;   
   	   $result = mysql_query($expresion);
   	   echo mysql_error();

   
   }
   
 if ($IdiomaPivot!=0 && $IdiomaDestino!=0)
   {
   // Construyo vector asociativo entre numeros de campos
   // y headers
   // Todos los campos tienen 2 valores mas referidos al texto
   // JavaScript aplicado antes y después en el código de validación
   // El código se aplica en mensaje de Ayuda    
   
   switch ($Tipo_Material)
   {
     case 0:
       $vectorcampos = array (200,201,202,203,204,205);
       break;
     case 1:
       $vectorcampos = array (1,2,3,4,5,6,7,8,998,999);
       break;
     case 2:
       $vectorcampos = array (1,2,3,4,5,6,7,8,9,998,999);
       break;
     case 3:
       $vectorcampos = array (1,2,3,4,998,999);       
       break;
     case 4:
       $vectorcampos = array (1,2,3,4,5,6,7,8,9,10,11,12,998,999);       
       break;
	  case 5:        
       $vectorcampos = array (1,2,3,4,5,6,7,8,998,999);       
       break;
  
   } 	   

  
   // Obtengo una consulta con las ayudas cargadas al momento para este
   // tipo de material
   
   $expresion = "SELECT Campos.Numero_Campo,Campos.Heading";
   $expresion = $expresion." FROM Campos WHERE Tipo_Material=".$Tipo_Material." AND Codigo_Idioma=".$IdiomaDestino." ORDER BY Numero_Campo";   
   $result = mysql_query($expresion);
   
   
   $expresion = "SELECT Campos.Numero_Campo,Campos.Heading";
   $expresion = $expresion." FROM Campos WHERE Tipo_Material=".$Tipo_Material." AND Codigo_Idioma=".$IdiomaPivot." ORDER BY Numero_Campo";   
   $result2 = mysql_query($expresion);
        

   reset ($vectorcampos);   
   while ($par=each($vectorcampos))
   {
      // Aca hay que buscar este campo dentro del resultado
      // No hay forma de buscar adentro de una consulta
      // asi es que recorro secuencialmente 
  
      $exito =  0;
      
	  $HeadingDestino=""; 
	  if (mysql_num_rows($result)>0)
      {
        mysql_data_seek ($result,0);
        while ($row=mysql_fetch_row($result))      
        {
          if ($row[0]==$par[1])
          { 
            $HeadingDestino = $row[1];
            break;
          } 
         }
      }
     
      $HeadingPivot=""; 
	  if (mysql_num_rows($result2)>0)
      {
        mysql_data_seek ($result2,0);
        while ($row=mysql_fetch_row($result2))      
        {
          if ($row[0]==$par[1])
          { 
            $HeadingPivot = $row[1];
            break;
          } 
         }
      }

      
      if ($HeadingDestino!="")
      {
   
?>
                      <hr align="center" width="450">
                      <table width="450" border="0" align="center" cellpadding="1" cellspacing="0">
                        <tr>
                          <td bgcolor="#006699"><div align="right" class="style45"><?echo $Mensajes["ele-4"];?></div></td>
                          <td bgcolor="#006699" class="style56"><? echo
      $par[1]; ?></td>
                        </tr>
                        <tr>
                          <td width="40%" class="style66"><div align="right"><? echo $Mensajes["ele-5"];?></div></td>
                          <td> <? echo $HeadingPivot; ?> </td>
                        </tr>
                        <tr>
                          <td width="40%" class="style66"><div align="right"><? echo $Mensajes["ele-6"];?> </div></td>
                          <td><? echo $HeadingDestino; ?> </td>
                        </tr>
                        <tr>
                          <td colspan="2"> <div align="right" class="style49 style67"><a href="carga_campos.php?Operacion=2&Tipo_Material=<? echo $Tipo_Material; ?>&NumeroCampo=<? echo $par[1]; ?>&Idioma=<? echo $IdiomaDestino; ?>&IdiomaNombre=<? echo $IdiomaNombre; ?>&IdiomaPivot=<? echo $IdiomaPivot;?>"><?echo $Mensajes["ele-7"];?></a> |<a href="elige_campos.php?Operacion=3&Tipo_Material=<? echo $Tipo_Material; ?>&Numero_Campo=<? echo $par[1]; ?>&Codigo_Idioma=<? echo $IdiomaDestino; ?>&IdiomaDestino=<? echo $IdiomaDestino; ?>&IdiomaPivot=<? echo $IdiomaPivot;?>" OnClick="return confirmar(this.href)"><? echo $Mensajes["ele-8"];?></a></div></td>
                          </tr>
                      </table>
					  <?
      }
     else
     {
?>
                      <hr align="center" width="450">                      <table width="450" border="0" align="center" cellpadding="1" cellspacing="0">
                        <tr>
                          <td bgcolor="#006699"><div align="right" class="style45"><?echo $Mensajes["ele-4"];?></div></td>
                          <td bgcolor="#006699" class="style56"><? echo
      $par[1]; ?></td>
                        </tr>
                        <tr>
                          <td width="40%" class="style66"><div align="right"><? echo $Mensajes["ele-5"];?></div></td>
                          <td><? echo $HeadingPivot; ?> </td>
                        </tr>
                        <tr>
                          <td width="40%" class="style66"><div align="right"><? echo $Mensajes["ele-6"];?> </div></td>
                          <td><? echo $HeadingDestino; ?></td>
                        </tr>
                        <tr>
                          <td colspan="2">
                            <div align="right" class="style49 style67"><a href="carga_campos.php?Operacion=1&Tipo_Material=<? echo $Tipo_Material; ?>&NumeroCampo=<? echo $par[1]; ?>&Idioma=<? echo $IdiomaDestino; ?>&IdiomaNombre=<? echo $IdiomaNombre; ?>&IdiomaPivot=<? echo $IdiomaPivot;?>"><? echo $Mensajes["ele-9"];?></a></div></td>
                        </tr>
                      </table>    
					  <?      
   }
 }
 // de la comparacion
 mysql_free_result($result);
 mysql_free_result($result2);
}
 Desconectar();
  
?></td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"></div>                <div align="center" class="style11"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a> </div></td>
            </tr>
          </table>
          </div>
          </td>
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
          <td width="50" class="style49"><div align="center" class="style11">sca-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>