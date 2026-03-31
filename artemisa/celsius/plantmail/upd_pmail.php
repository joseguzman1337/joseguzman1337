<?

   include_once "../inc/var.inc.php";
   include_once "../inc/conexion.inc.php";  
   Conexion();	
   include_once "../inc/identif.php"; 
   Administracion();
   
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
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
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {
	color: #006599;
	font-family: Verdana;
	font-size: 9px;
}
.style42 {color: #FFFFFF; font-size: 9px; font-family: verdana; }

.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}

a.style33 {
	font-family: verdana;
	font-size: 9px;
	color: #006699;
}
-->
</style>
<base target="_self">
</head>
 <body topmargin="0">
 <?
  	include_once "../inc/fgenped.php";
	include_once "../inc/fgentrad.php";
    global $IdiomaSitio;
   $Mensajes = Comienzo ("pma-001",$IdiomaSitio);
   if (!isset($Anio))   {$Anio = date('Y');}
   if (!isset($Mes))   {$Mes = date('m');}
   if (!isset($Dia))   {$Dia = date('d');}
   


	$Fecha = $Anio."-".$Mes."-".$Dia;	
     
    if ($operacion==0)
   {   
    $Instruccion = "INSERT INTO Plantmail (Denominacion,Cuando_Usa,Texto) VALUES('".$Denominacion."',".$Cuando_Usa.",'".$Texto."')";	
   }
   else
   {
   	 $Instruccion = "UPDATE Plantmail SET Denominacion='".$Denominacion."',Cuando_Usa=".$Cuando_Usa.",Texto='".$Texto."' WHERE Id=".$Id;	
   } 
  $result = mysql_query($Instruccion); 
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
        <td align="center" valign="middle" bgcolor="#E4E4E4">            <div align="center">

              <center>
                <table width="57%" height="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
				<?
                   if (mysql_affected_rows()>0)
				{ ?>
				<tr align="center">
                    <td colspan="2" align="left" valign="middle" class="style42" width="50%"> 
					<div align="justify" class="style23">
                      <p>&nbsp;</p>
                      <p> <? echo $Denominacion ;?> </span></p>
                      <p>&nbsp;</p>
                      <p> <? echo $Texto ;?> </span></p>
                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
					
					<tr align="center">
                    <td colspan="3" align="center" valign="middle" class="style42"> <div align="center" class="style23">
                      <p>&nbsp;</p>
                      <p> <? if (isset($Mensajes["opc_".$Cuando_Usa])) { echo $Mensajes["opc_".$Cuando_Usa]; } ?> </span></p>
                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
                  <?
					} 
					else	{ ?>
					<tr align="left">
                    <td colspan="3" align="left" valign="middle" class="style42"> <div align="left" class="style23">
                      <p>&nbsp;</p>
                      <p> <? $Mensajes["err-2"]; ?> </span></p>
                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
					<?
					}
					Desconectar();
					?>
					
					<? if ($operacion==0)
				      {
				      ?> 
					  <tr align="center">
                    <td colspan="3" align="center" valign="middle" class="style42"> <div align="center" class="style23">
                      
                      <a href="form_pmail.php?operacion=0" class="style33">&nbsp;<? echo $Mensajes["h-1"]; ?></a></font></span>
                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
				      <?
				      }
				      else
				      {
				      ?>
					   <tr align="center">
                    <td colspan="3" align="center" valign="middle" class="style42"> <div align="center" class="style23">
                      <a href="elige_pmail.php" class="style33">&nbsp;<? echo $Mensajes["h-2"]; ?></a>      </a></font></span></p>
                      <p>&nbsp;</p>
                    </div>                      </td>
                    </tr>
					   
				      <? 
				      }
					  ?> 
                </table>
              </center>

            </div>   </td>
                      <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
                <p><img src="../images/image001.jpg" width="150" height="118"><br>
                    <a href="../admin/indexadm.php" class="style33"><? echo $Mensajes["h-3"]; ?></a></span></p>
                  </div>                  </td>
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
            <div align="center">pma-001</div>
          </div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>

</body>
  
</html>
