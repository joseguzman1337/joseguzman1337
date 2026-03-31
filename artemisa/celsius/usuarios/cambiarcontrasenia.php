<? 
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";
 Conexion();
 include_once "../inc/"."identif.php";
 Usuario();	
?> 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>

<head>
<title><? echo Titulo_Sitio();?></title>
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 10px; }
.style28 {color: #FFFFFF}
.style30 {color: #FFFFFF; font-size: 11px; font-family: verdana; }
.style31 {
	color: #000000;
	font-family: Verdana;
	font-size: 11px;
}
.style34 {color: #006699; font-family: Verdana; font-size: 11px; }
.style41 {color: #666666}
.style23 {
	color: #000000;
	font-size: 11px;
	font-family: verdana;
}
-->
</style>
<base target="_self">
</head>

<body topmargin="0" onload="init()";>
<?
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("ccu-001",$IdiomaSitio);

   $expresion = "SELECT Apellido,Nombres,EMail,Codigo_Pais,Codigo_Institucion,Codigo_Dependencia";
   $expresion = $expresion.",Direccion,Codigo_Categoria,Telefonos,Codigo_Unidad,Codigo_Localidad,Login,Password,Comentarios,";
   $expresion = $expresion."Codigo_FormaPago,Personal,Bibliotecario,Staff,Orden_Staff,Cargo ";
   $expresion = $expresion."FROM Usuarios WHERE Usuarios.Id =".$Id_usuario;
   $result = mysql_query($expresion);
   echo mysql_error();
   $rowg = mysql_fetch_row($result);
?>
<script language="JavaScript">
function ver_clave(Str1,Str2)
{
  if (Str1!=Str2)
  {
  	alert ("<? echo $Mensajes['err-1']; ?>");
  	return false;
  }
  else
  {
   // Pruebo el uso de expresiones regulares
   
   expresion = /^[a-z,A-Z]{3}[0-9]{4}$/
   if (expresion.test(Str1))
   {

   		
		document.forms.form1.senia.value=2;
		document.forms.form1.action = "cambiarcontrasenia.php";
		document.forms.form1.submit();
   }
   else
   {
   		alert ("<? echo $Mensajes['err-2']; ?>");
   		return false;
   }
  } 
}

function init()
{
  document.forms.form1.Clave1.onkeypress = keyhandler;
  document.forms.form1.Clave2.onkeypress = keyhandler;
  document.forms.form1.Clave1.focus();

}
function keyhandler(e) {
    if (!window.event)
        Key = e.which;
    else
        Key = window.event.keyCode;
        
    if (Key == 13)  //le dio al enter
    {
        if ((document.forms.form1.Clave1.value != '') && (document.forms.form1.Clave2.value != ''))
            ver_clave(document.forms.form1.Clave1.value,document.forms.form1.Clave2.value);
        else
          if (document.forms.form1.Clave1.value == '')
            document.forms.form1.Clave1.focus();
          else
            document.forms.form1.Clave2.focus();

     }

  }
</script>

<? if (isset($senia)&&($senia==2))
	{
	  // Hago el cambio de clave
	  global $Id_usuario;

	  $Instruccion = "UPDATE Usuarios SET Password='".$Clave1."' WHERE Id='".$Id_usuario."'";
   	  $result=mysql_query($Instruccion);
   	  echo mysql_error();



   	  ?>
   <div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <div align="center">
       <center>
      <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4"><table width="100%"  border="0">
                  <tr>
                    <td width="567" height="130" align="center" valign="middle" class="style23"><div align="center" class="style41"><? echo $Mensajes['txt-1']; ?></div></td>
                  </tr>
                </table>                  

                  </td>
              </tr>
            </table>
              </center>
            </div></td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <?  dibujar_menu_usuarios($rowg[0].', '.$rowg[1],1); ?>
          </div></td>
       </tr>
     </table>
     </center>
     </div>    </td>
  </tr>
  			<?php
    include_once "../inc/"."barrainferior.php";

    DibujarBarraInferior();

  ?>

  <tr>

       <td height="44" bgcolor="#E4E4E4"><div align="center">
       <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">ccu-001</div></td>
        </tr>
		</table>
	   </div>    </td>
  </tr>


<?

     }
      else
      {
?>   <div align="left">
	<form name="form1" method="POST">

	  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
	  <tr>
		<td bgcolor="#E4E4E4">
		  <hr color="#E4E4E4" size="1">
		  <div align="center">
			<center>
		  <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
		  <tr bgcolor="#EFEFEF">
			<td valign="top" bgcolor="#E4E4E4">
				<div align="center">
				  <center>
				<table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">

				  <tr>
					<td bgcolor="#E4E4E4"><table width="100%"  border="0">
					  <tr>
						<td width="576" height="20" bgcolor="#006599" class="style30"><div align="left" class="style28">
						  <div align="center"> <? echo $Mensajes['txt-2']; ?></div>
						</div></td>
					  </tr>
					  <tr>
						<td class="style30"><div align="center" class="style31">
						  <p> <? echo $Mensajes['txt-3']; ?> </p>
						  <table  border="0" cellspacing="0" cellpadding="1">
							<tr>
							  <td height="20" align="right" bgcolor="#CCCCCC"><? echo $Mensajes['txt-4']; ?></td>
							  <td height="20" align="left"><input  type="password" class="style31" name="Clave1">
							  </td>
							</tr>
							<tr>
							  <td height="20" align="right" bgcolor="#CCCCCC"><? echo $Mensajes['txt-5']; ?></td>
							  <td height="20" align="left"><input type="password" class="style31" name="Clave2"></td>
							</tr>
							<tr align="center">
							  <td height="20" colspan="2">
								<input name="b1" type="button" class="style31" value="<? echo $Mensajes['bot-1']; ?>" onClick="javascript:ver_clave(document.forms.form1.Clave1.value,document.forms.form1.Clave2.value)">
								<input name="b2" type="reset" class="style31" value="<? echo $Mensajes['bot-2']; ?>">
								<input type="hidden" name="senia" value=1>
								</td>
							  </tr>
						  </table>
						  <p>&nbsp;</p>
						</div></td>
					  </tr>
					</table>                  
					</td>
				  </tr>
				</table>
				  </center>
				</div>            </td>
			<td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11"><? dibujar_menu_usuarios($rowg[0].', '.$rowg[1],1); ?>
			
				  </div></td>
				</tr>
			 
	

      </table>
    </div></td>
    </tr>
			</tr>
			<?php
    include_once "../inc/"."barrainferior.php";

    DibujarBarraInferior();

  ?>
			<tr>
       <td height="44" bgcolor="#E4E4E4" colspan=2><div align="center">
       <hr>
       <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100"  border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">ccu-001</div></td>
        </tr>
		</table>    </center>
		  </div>    </td>
	  </tr>
  </table>
  </form>
  </div>

  	
<? } ?>

</body>
</html>
