<?
include_once "../inc/var.inc.php";   
include_once "../inc/"."conexion.inc.php";
Conexion();	
include_once "../inc/"."identif.php";
Administracion();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio(); ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #006599;
	margin-left: 11px;
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 11px;
}
.style45 {
	font-family: Verdana;
	color: #FFFFFF;
	font-size: 11px;
}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 11px;
	font-style: normal;
	font-weight: bold;
}
.style49 {font-family: verdana; font-size: 11px; color: #006599; }
.style56 {color: #00FFFF}
.style63 {font-size: 11px; font-family: Arial; }
.style64 {color: #006599}
.style65 {font-family: Arial}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<? 
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  
   global $IdiomaSitio;
   $Mensajes = Comienzo ("lhi-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  
   
?>

<script language="JavaScript">
function rutear_pedidos (Id,dedonde)
 {
	ventana=open("verped_col.php?Id="+Id+"&Tabla="+dedonde+"&dedonde=1","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");   
    return null	
	
 }
</script>

<div align="left">
  <?   
  
   $expresion = "SELECT Nombre FROM Titulos_Colecciones WHERE Id=".$Id_Col;
 	$result = mysql_query($expresion);
 	$row = mysql_fetch_row($result);

   	echo mysql_error();
  ?>

<form name="form1">
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
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="3" align="left" bgcolor="#0099CC" class="style45"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tf-1"]; ?><span class="style56"></span></td>
                  </tr>
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top">                            <div align="left">
						  <? echo $Mensajes["tf-2"]; ?><? echo "<span class='style46'> $row[0]</span> -- Vol:$Vol  Año:$Anio  Numero:$Numero"; ?>
						  
						  <br>
                              <a href="javascript:history.back()"><? echo $Mensajes["h-1"]; ?></a><br>
                                    </div>                            <div align="center"></div></td>
                          </tr>
                      </table>
                      <hr>
                    </td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
              <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#ECECEC">
                <tr bgcolor="#0099CC">
                  <td height="20" colspan="6"><div align="left"><span class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-3"]; ?></span></div></td>
                  </tr>
				  <?
      $expresion = "SELECT Pedidos.Id,Pedidos.Estado,Pedidos.Volumen_Revista,Pedidos.Numero_Revista,Pedidos.Anio_Revista,";   
      $expresion = $expresion."Pedidos.Fecha_Solicitado,Fecha_Recepcion,PaisSol.Nombre,InstSol.Nombre,DepSol.Nombre ";
      $expresion = $expresion."FROM Pedidos ";
      $expresion = $expresion."LEFT JOIN Paises AS PaisSol ON Pedidos.Ultimo_Pais_Solicitado=PaisSol.Id ";
      $expresion = $expresion."LEFT JOIN Instituciones AS InstSol ON Pedidos.Ultima_Institucion_Solicitado=InstSol.Codigo ";
      $expresion = $expresion."LEFT JOIN Dependencias AS DepSol ON Pedidos.Ultima_Dependencia_Solicitado=DepSol.Id ";
      $expresion = $expresion."WHERE (Pedidos.Estado=".Devolver_Estado_Recibido()." OR Pedidos.Estado=".Devolver_Estado_Pedido().")";
      $expresion = $expresion." AND Pedidos.Codigo_Titulo_Revista=".$Id_Col." AND Pedidos.Id<>'".$Id."'";
      $expresion = $expresion." ORDER BY Pedidos.Fecha_Recepcion DESC";
      $result = mysql_query($expresion);
      echo mysql_error();
      
      while ($row=mysql_fetch_row($result))
	  {	
    ?>
                <tr class="style63">
                  <td><div align="left"><? echo
        $row[0]; ?></div></td>
                  <td class="style63"><p align="left"><? echo Devolver_Estado($VectorIdioma,$row[1],0); ?></p>                    </td>
				   <? if ($row[2]==$Vol) { $row[2]="<b>$row[2]</b>"; } ?>
      <? if ($row[3]==$Numero) { $row[3]="<b>$row[3]</b>"; } ?>
	   <? if ($row[4]==$Anio) { $row[4]="<b>$row[4]</b>"; } ?>
                  <td><div align="left"><span class="style63">Vol:<span class="style64"><? echo $row[2];?></span> A&ntilde;o:<span class="style64"><? echo $row[4];?></span> No:<span class="style64"><? echo $row[3];?></span></span> </div></td>
                  

				  <td class="style63"><div align="left"><span class="style63">FS: <span class="style64"><? echo $row[5];?> </span>FR:<span class="style64"><? echo $row[6];?></span></span></div></td>
                  <td class="style63"><div align="left"><? echo $row[7]."-".$row[8]."-".$row[9]; ?></div></td>
                  <td class="style63"><input type="button" class="style63" name="boton" OnClick="rutear_pedidos(<? echo "'$row[0]',1"; ?>)" value="C"></td>
                </tr>
     <?
      }
    ?>

             
                <tr>
                  <td height="20" colspan="6" bgcolor="#0099CC"><div align="left"><span class="style45"><img src="../images/square-w.gif" width="8" height="8"> <? echo $Mensajes["tf-4"]; ?> </span></div></td>
                  </tr>
				  <?
      $expresion = "SELECT PedHist.Id,PedHist.Tipo_Material,PedHist.Volumen_Revista,PedHist.Numero_Revista,PedHist.Anio_Revista,";   
      $expresion = $expresion."PedHist.Fecha_Solicitado,Fecha_Recepcion,PaisSol.Nombre,InstSol.Nombre,DepSol.Nombre ";
      $expresion = $expresion."FROM PedHist ";
      $expresion = $expresion."LEFT JOIN Paises AS PaisSol ON PedHist.Ultimo_Pais_Solicitado=PaisSol.Id ";
      $expresion = $expresion."LEFT JOIN Instituciones AS InstSol ON PedHist.Ultima_Institucion_Solicitado=InstSol.Codigo ";
      $expresion = $expresion."LEFT JOIN Dependencias AS DepSol ON PedHist.Ultima_Dependencia_Solicitado=DepSol.Id ";
      $expresion = $expresion."WHERE PedHist.Codigo_Titulo_Revista=".$Id_Col;
      $expresion = $expresion." ORDER BY PedHist.Fecha_Recepcion DESC LIMIT 60";
      $result = mysql_query($expresion);
      echo mysql_error();
      
      while ($row=mysql_fetch_row($result))
	  {	
    ?>
      <? if ($row[2]==$Vol) { $row[2]="<b>$row[2]</b>"; } ?>
      <? if ($row[3]==$Numero) { $row[3]="<b>$row[3]</b>"; } ?>
	   <? if ($row[4]==$Anio) { $row[4]="<b>$row[4]</b>"; } ?>


                <tr class="style63">
                  <td height="20"><div align="left"><? echo
        $row[0]; ?></div></td>
                  <td height="20" class="style63"><div align="left">Hist&oacute;rico</div></td>
				  
                  <td height="20"><div align="left"><span class="style63">Vol:<span class="style64"><? echo $row[2];?></span> A&ntilde;o:<span class="style64"><? echo $row[4];?></span> No:<span class="style64"><? echo $row[3];?></span></span> </div></td>
                  <td height="20" class="style63"><div align="left">FS: <span class="style64"><? echo $row[5];?> </span>FR:<span class="style64"><? echo $row[6]; ?></span></div></td>
                  <td height="20" class="style63"><div align="left"><? echo $row[7]."-".$row[8]."-".$row[9]; ?></div></td>
                  <td height="20" class="style63"><input class="style63" type="button" name="boton" OnClick="rutear_pedidos(<? echo "'$row[0]',2"; ?>)" value="C"></td>
                </tr>
				<?
      }
    ?>
              </table>
      </form>
			  </center>
            </div>
			<? 
   $Mensajes = Comienzo ("par-001",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
   include_once "../inc/"."parser.php";

   mostrarExistencias($Id_Col,$Anio,$Mensajes,$VectorIdioma);

?>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"></div>                <div align="center" class="style11"><img src="../images/image001.jpg" width="150" height="118"><br>
              <a href="../admin/indexadm.php">Volver a administraci&oacute;n</a></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">lhi-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
</body>
</html>
<?
   mysql_free_result($result);
   Desconectar();
?>