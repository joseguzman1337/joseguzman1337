<?
 
   include_once "../inc/var.inc.php";
   include_once "../inc/"."conexion.inc.php";  
   include_once "../inc/fgentrad.php";
   Conexion();
   global $IdiomaSitio;
   $Mensajes = Comienzo ("fma-001",$IdiomaSitio);
   include_once "../inc/"."identif.php"; 
   Administracion();
   
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
	background-image: url();
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
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style14 {
	font-size: 10px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 9px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 10}
.style24 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>
<script>

function cambiar_Plantilla()
	{
		document.forms.form1.action = "form_mail.php";
		document.forms.form1.submit();
	}

function verifyEmail(checkEmail) {

if ((checkEmail.indexOf('@') < 0) || ((checkEmail.charAt(checkEmail.length-4) != '.') && (checkEmail.charAt(checkEmail.length-3) != '.')))
{ alert('La direccion de email es inválida');
  return false;
}

else {
  return true;
}

}


function evaluarcampo(c)
{
 if (c.value == '')
   {
     c.value = ' *** Debe completar este campo';
     c.focus();
     return false;
   }
   return true;
}
function verificar()
{
    if ((evaluarcampo(document.forms.form1.nombre))
      &&  (evaluarcampo(document.forms.form1.email))
      &&  (verifyEmail(document.forms.form1.email.value))
      &&  (evaluarcampo(document.forms.form1.subject))
      &&  (evaluarcampo(document.forms.form1.texto)))
             document.forms.form1.submit();


}

</script>
<base target="_self">
</head>

<body topmargin="0">
<div align="left">

  <table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
        <center>
          <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#E4E4E4">
        <td valign="top" bgcolor="#E4E4E4">
            <span align="center">
              <center>
   
		  <?if ($operacion!=1)
   {   
   
?>
   
<div align="center">
  <center>
  
  <?
    if ($Plantilla=="")
    {
      $Instruccion = "SELECT Denominacion,Texto,Id FROM Plantmail" ;
    }
    else
    {  
	   $Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Id=".$Plantilla;
	 }  
   	 $result = mysql_query($Instruccion);
	 echo mysql_error();    		   
	 $row = mysql_fetch_array($result);
	 if ($Plantilla == "")
	 {
	 	$Plantilla = $row[3];
	 }
    
  ?>
  
  
<form method="POST" name="form1" action="form_mail.php?operacion=1">

				
				
				<table width="97%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td class="style17" align=left><blockquote>
                        <p class="style17 style23"><span class="style28"><span class="style26"></span> </span></p>
                          <p class="style17 style28">
                             <table valign="top">
                            <tr>
                             <td width=20% align=left valign="top">
                              <? echo $Mensajes["tf-1"]; ?> </td> <td align=left><?echo $Nom_Usu; ?>
                             </td>
                            </tr>
							<tr>
							<td align=left valign="top">
                                <? echo $Mensajes["ec-1"]; ?></td> <td align=left>
								<input class="style24" type="text" name="Direccion" size="51" value="<? echo $mail;  ?>">
                             </td>
                            </tr>
                          <tr>
               <td align="left" valign="top">
             <?
	           // Ahora me ocupo de recuperar la plantilla adecuada de acuerdo 
               // al tipo de evento generado y reemplazar los caracteres variables
              // de la misma
              $Instruccion = "SELECT Id,Denominacion FROM Plantmail";
   	          $result = mysql_query($Instruccion);
	          echo mysql_error();    		   
   	 
    echo $Mensajes["ec-2"]; ?>
    </td>
      <td >
      <select size="1" name="Plantilla" class="style24" OnChange="cambiar_Plantilla()">
        <?
    		while ($roww = mysql_fetch_array($result))
    		{
    			if ($roww[0]==$Plantilla)
    			{
    		?>
    			<option value=<? echo $roww[0]; ?> selected><? echo $roww[1]; ?></option>
    			
    		<?      		    
    		    }
    		    else
    		    {
    		 ?>
    			<option value=<? echo $roww[0]; ?>><? echo $roww[1]; ?></option>
    			

    	     <?   }	    	
    		 }
    	?>
    </select>
    </td>
  </tr>
							<tr>
    <td >
    </td>
    <td >
    <input type="checkbox" name="Corrige_Direccion" value="ON"><? echo $Mensajes["tf-3"]; ?></td>
  </tr>


							<tr>
                            <td valign="top"><? echo $Mensajes["ec-3"]; ?></td> <td align=left><input class="style24" type="text" name="Asunto" size="51" value="<? echo $row[0]; ?>" ></td>
                            </tr>
                            <tr> <td valign="top"><? echo $Mensajes["ec-4"]; ?>
                            </td> <td align=left>
                            <textarea rows="10" cols="45" name="Texto"><? echo $row[1]; ?></textarea>
                            </td>
                            </tr>
                            <tr td align=center><td> &nbsp;</td> <td colspan>
					        <input type="submit" class="style24" value="<? echo $Mensajes["bot-1"]; ?>">
                    	    <input type="reset" class="style24" value="<? echo $Mensajes["bot-2"]; ?>">
  <input type="hidden" name="Nom_Usu" value="<? echo $Nom_Usu; ?>">
  <input type="hidden" name="Id_Usuario" value="<? echo $Id_Usuario; ?>">
  <input type="hidden" name="mail" value="<? echo $mail; ?>">

                            </td> </tr> </table>
                          </form> </p>
                           <br>
                            </span><br>
                            </p>
                       <?
  }
  else
  {
    if ($Direccion!="")
    {
      $Dia = date ("d");
      $Mes = date ("m");
      $Anio = date ("Y");
      $fecha =$Anio."-".$Mes."-".$Dia;
     
      $hora = strftime ("%H:%M:%S"); 

  	  $Instruccion = "INSERT INTO mail(Codigo_usuario,Fecha,Hora,Direccion,Asunto,Texto,Codigo_Pedido)";
  	  $Instruccion = $Instruccion." VALUES($Id_Usuario,'$fecha','$hora','".AddSlashes($Direccion)."','".AddSlashes($Asunto)."','".AddSlashes($Texto)."','0')";
  	  $result = mysql_query($Instruccion);
  	  echo mysql_error();
  	  
  	  mail ($Direccion,$Asunto,$Texto,"From:".Destino_Mail());
 
  	 
  	  if ($Corrige_Direccion=="ON")
  	  {
  	  	$Instruccion = "UPDATE Usuarios SET EMail='".$Direccion."' WHERE Id=".$Id_Usuario;
       $result = mysql_query($Instruccion);
  	    echo mysql_error(); 
  	  }
  	 } 
 
?>
           <div align="center">
  <center>
 <table border="0" width="530" cellspacing="0" cellpadding="0" height="155">
  
  <tr>
    <td width="77" height="21" valign="middle" align="right" class="style24"><? echo $Mensajes["ec-1"]; ?></td>
    <td width="432" height="21" valign="middle" align="left" colspan="4" class="style24"><? echo $Direccion; ?>
    </td>
  </tr>
  <tr>
    <td width="77" height="21" valign="top" align="right" class="style24"><? echo
      $Mensajes["ec-3"]; ?></td>
    <td width="432" height="21" valign="top" align="left" colspan="4" class="style24"><b><? echo $Asunto; ?></b></td>
  </tr>
  <tr>
    <td width="77" valign="top" align="right" class="style24" height="21"><? echo
      $Mensajes["ec-5"]; ?></td>
    <td width="233" valign="top" align="left" class="style24"  height="21"><? echo $fecha; ?></td>
    <td width="70" valign="top" align="left" class="style24" height="21" colspan="2"><? echo
      $Mensajes["ec-6"]; ?></td>
    <td width="142" valign="top" align="left" class="style24" height="21"><? echo $hora; ?></td>
  </tr>
  <tr>
    <td width="77" valign="top" align="right" class="style24" height="71">&nbsp;</td>
    
    <td class="style24" height="71" width="432" colspan="4"><textarea rows="6" cols="49"><? echo $Texto; ?></textarea>
  </tr>
 <tr>
    <td width="77" valign="top" align="right"  height="27">&nbsp;</td>
    
   
    <td  height="27" width="215" colspan="2" class="style24">
    <a href="../admin/elige_usuario.php?dedonde=4&Letra=A"><? echo $Mensajes["h-2"];?></a>

  </tr>

</table>
  </center>
</div>
<? }?>
          </td>
          <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
            <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><span class="style55"><img src="../images/image001.jpg" width="150" height="118"></span><br>
                    <a href="../admin/indexadm.php"><span class="style33"><? echo $Mensajes["h-1"];?></span></a></td>
            </tr>
			
          </table>
          </div>
          </td>
        </tr>
    </table>    </center>    </td>
    

  </tr>
 
 
	
  <tr>
    <td height="44" bgcolor="#E4E4E4">
     <font face="Arial">
      <center>
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="../images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
              <div align="right" class="style18">
                <div align="center">cou-002</div>
              </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0>
        </a>
      </center>
     </font>
    </td>
  </tr>
</table>
</div>
</body>
</html>
