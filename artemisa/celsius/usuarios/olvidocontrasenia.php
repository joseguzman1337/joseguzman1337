<?
  include_once "../inc/var.inc.php"; 
  include_once "../inc/"."conexion.inc.php";  
  Conexion();
  include_once "../inc/"."fgenhist.php";
  include_once "../inc/"."fgentrad.php";    
  global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("pwd-001",$IdiomaSitio);  
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style22 {
	color: #333333;
	font-family: verdana;
	font-size: 11px;
}
.style23 {
	color: #FFFFFF;
	font-size: 11px;
}
.style26 {color: #FFFFFF; font-size: 10; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style30 {
	font-size: 11px;
	color: #000000;
	font-family: Verdana;
}
.style32 {font-size: 11px}
.style33 {
	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style36 {font-family: verdana; font-size: 9px; color: #006699; font-weight: bold; }
-->
</style>
<base target="_self">
</head>
<?

if (!isset($Operacion)){
		$Operacion = 0;
	}
if ($Operacion==0)
{
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
      <tr bgcolor="#EFEFEF">
        <td valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td bgcolor="#E4E4E4">                  <blockquote class="style30">
                <form name='form1' action='olvidocontrasenia.php' method=POST>
                  <p align="left" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;"> <? echo $Mensajes['txt-1']; ?> </p>
                  <p align="center" style="font-family: verdana; font-size: 10px;"><span class="style36"><? echo $Mensajes["ec-1"]?> </span>

                      <input name="Direccion"  type="text" class="style22" size="40">
                      <input name="Submit3" type="submit" class="style22" value="<? echo $Mensajes["bot-1"];?>">
                      <input type="hidden" name="Operacion" value="1">

                    </p>
                  <p align="center" style="font-family: verdana; font-size: 10px;"><img src="../images/password.gif" width="32" height="32"><br>
                                      </p>
                </blockquote>
                                   </form>
                </td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" border="0" bgcolor="#EFEFEF">
            <tr>
              <td height="100" bgcolor="#006699" class="style28"><div align="center"><img src="../images/email.jpg" width="150" height="113"></div></td>
            </tr>
          </table>
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
            <div align="center">ayc</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
<?
} // de Operacion
else
{
    $Exito = 0;
    if ($Direccion!="")
    {
	  $Instruccion = "SELECT Id,Login,Password,Apellido,Nombres FROM Usuarios WHERE EMail='".$Direccion."'";
	  $result = mysql_query($Instruccion);

	  if (mysql_num_rows($result)>0)
	  {

	    $row = mysql_fetch_array($result);
		mysql_free_result($result);
		$Nombre = $row[3].",".$row[4];

	    // Se usa el codigo 100 para indicar el envío de un e-mail de clave
	    $Instruccion = "SELECT Denominacion,Texto FROM Plantmail WHERE Cuando_Usa=100";
        $result = mysql_query($Instruccion);
		echo mysql_error();
    	$roww = mysql_fetch_array($result);

		$cita = "";
	    $roww[1] = reemplazar_variables ($roww[1],"",$Nombre,0,$cita,0,"",$row[1],$row[2]);

	    $Dia = date ("d");
        $Mes = date ("m");
        $Anio = date ("Y");
        $fecha =$Anio."-".$Mes."-".$Dia;

        $hora = strftime ("%H:%M:%S");

  	    $Instruccion = "INSERT INTO mail (Codigo_usuario,Fecha,Hora,Direccion,Asunto,Texto,Codigo_Pedido)";
  	    $Instruccion = $Instruccion." VALUES ($row[0],'$fecha','$hora','$Direccion','$roww[0]','$roww[1]','0')";
	    $result = mysql_query($Instruccion);
  	    echo mysql_error();


	    mail ($Direccion,$roww[0],$roww[1],"From:".Destino_Mail());
		$Exito = 1;
		}
		}
	echo '<div align="left">
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
                <td bgcolor="#E4E4E4">
                <blockquote class="style30">';

                     if ($Exito == 1)
                     	{
                   ?>
                       <p align="center" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;">
                        <? echo $Mensajes['txt-2']; ?>
                      </p>
                   <?
                          }
                       else
                     {
                         ?>
                       <p align="center" style="margin-top:0; margin-bottom:0; font-family: verdana; font-size: 10px;">
                       <? echo $Mensajes['txt-3']; ?>
                      </p>
                   <?
                       }
                  ?>

                 </p>
                </blockquote>
                                   </form>
                </td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" border="0" bgcolor="#EFEFEF">
            <tr>
              <td height="100" bgcolor="#006699" class="style28"><div align="center"><img src="../images/email.jpg" width="150" height="113"></div></td>
            </tr>
          </table>
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
            <div align="center">pwd-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
<?
  }
?>

</html>
