<?
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 Conexion();	
 include_once "../inc/"."identif.php"; 
 Administracion(); 
 include_once "../inc/"."fgentrad.php";
 global $IdiomaSitio; 
 $Mensajes = Comienzo ("ftr-001",$IdiomaSitio);
 
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
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 9px;
}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style33 {	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
.style58 {font-size: 9px}
.style60 {font-family: Arial}
-->
</style>

<SCRIPT LANGUAGE = "JavaScript">
<!--
var secs = 10;
var timerID = null
var timerRunning = false
var delay = 1000

function InitializeTimer()
{
    // Set the length of the timer, in seconds
    secs = 2
    StopTheClock()
    StartTheTimer()
}

function StopTheClock()
{
    if(timerRunning)
        clearTimeout(timerID)
    timerRunning = false
    

}

function StartTheTimer()
{
    if (secs==0)
    {
        StopTheClock()
        // Here's where you put something useful that's
        // supposed to happen after the allotted time.
        // For example, you could display a message:
        window.close();
		window.opener.document.forms.form1.action='elige_trad.php';
        window.opener.document.forms.form1.submit(); 

    }
    else
    {
        self.status = secs
        secs = secs - 1
        timerRunning = true
        timerID = self.setTimeout("StartTheTimer()", delay)
    }
}
//-->
</SCRIPT>


<base target="_self">
</head>

<body topmargin="0" onLoad="InitializeTimer()">
<?
   include_once "../inc/fgenped.php";

   if ($dedonde==0)
   {
  
   $Instruccion = "INSERT INTO Traducciones (Codigo_Pantalla,Codigo_Elemento,Codigo_Idioma";
   $Instruccion = $Instruccion. ",Texto,Nombre_Archivo";
   $Instruccion = $Instruccion. ") VALUES('$Codigo_Pantalla','$Codigo_Elemento',$Codigo_Idioma";
   $Instruccion = $Instruccion. ",'".$Texto."','".$Archivo."')";	
  
   }
   else {
   
   $Instruccion = "UPDATE Traducciones SET ";
   $Instruccion = $Instruccion. "Texto='".$Texto."',Nombre_Archivo='".$Archivo."'";
   $Instruccion = $Instruccion. " WHERE Codigo_Pantalla='".$Codigo_Pantalla."' AND Codigo_Elemento='".$Codigo_Elemento."' AND Codigo_Idioma=".$Codigo_Idioma;	 
   } 
   
   $result = mysql_query($Instruccion); 
   echo mysql_error();
  ?>

<div align="left">
  <table width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="580" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="center" valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="540" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><div align="center">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1"><?
                              if (!mysql_error()){ ?>
							  <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ec-1"];?></div></td>
                                <td width="50%" class="style43"><div align="left"> <?echo $Codigo_Pantalla;?></div></td>
                              </tr>
                              <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ec-2"];?></div></td>
                                <td width="50%" class="style43"><div align="left"><? echo $Codigo_Elemento; ?>
                                  </div></td>
                              </tr>

							   <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ec-3"];?> </div></td>
                                <td width="50%" class="style43"><div align="left"><? echo $DescIdioma; ?>
                                  </div></td>
                              </tr>

							  <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ec-4"];?> </div></td>
                                <td width="50%" class="style43"><div align="left"><? echo $Texto; ?>
                                  </div></td>
                              </tr>
							  <tr>
                                <td width="50%" class="style49"><div align="right"><? echo $Mensajes["ec-5"];?> </div></td>
                                <td width="50%" class="style43"><div align="left"><?echo        $Archivo; ?>
                                  </div></td>
                              </tr>
							  <tr>
                                <td width="50%" class="style49"><div align="right"> </div></td>
                                <td width="50%" class="style43"><div align="left"><? echo $Codigo_Elemento; ?>
                                  </div></td>
                              </tr>
							<?}
							  
							  else
							  {?>
							   <tr>
                                <td colspan="2" class="style49"><div align="right"><? echo $Mensajes["not-1"];?></div>
								<div align="right"><? echo $Mensajes["not-2"];?>
			                       </div></td>
                                </tr>
							  <?}?>

                             <tr>
                                <td colspan="2" class="style49"><div align="right"><input type="submit" value="Cerrar Ventana" name="B1" OnClick="javascript: top.opener.location.reload();self.close();">
			                       </div></td>
                                </tr>

                            </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
                    </td>
                  </tr>
                </table>


				
				</td>
              </tr>
            </table>
              </center>
            </div>            </td>
        
        </tr>
    </table>    </center>
      </div>    </td>
  </tr>
  <?
   Desconectar();
?>

  <tr>
    <td height="44" bgcolor="#E4E4E4"><div align="center">      
      <hr>
      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="50">&nbsp;</td>
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">ftr-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>