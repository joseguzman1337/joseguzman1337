<?
 include_once "../inc/var.inc.php";
 include_once "../inc/"."conexion.inc.php";  
 Conexion();	
 include_once "../inc/"."identif.php"; 
 Administracion();
 include_once "../inc/"."dbutiles.inc";
 $PaginaTitulo = "Ejecuta SQL";
 if (!isset($Archivo)){$Archivo=0;}
 
 if (!empty($query) && $Archivo) 
	{
	
     $tabla="Consulta";
     $ext="csv";
	 $sep = ",";

     @set_time_limit(600);
     $crlf="\r\n";

     header("Content-disposition: filename=$tabla.$ext");
	 header("Content-type: application/octetstream");
	 header("Pragma: no-cache");
	 header("Expires: 0");
	

	
	$query = stripSlashes($query) ;
    $result = mysql_query($query);
	echo mysql_error();
	
	if (!empty($query2))
	{
		$query2 = stripSlashes($query2) ;
		$result = mysql_query($query2);		
	}
	
     $schema_insert = "";
	 for ($i = 0; $i < mysql_num_fields($result); $i++) {
              $schema_insert.= mysql_field_name($result,$i) . $sep;
            }
			
     $schema_insert = str_replace($sep."\$", "", $schema_insert);
     echo trim($schema_insert);
     echo $crlf;
	
     $i = 0;
     while($row = mysql_fetch_row($result))
     {
        $schema_insert = "";
		 
        for($j=0; $j<mysql_num_fields($result);$j++)
        {
            if(!isset($row[$j]))
                $schema_insert .= "NULL".$sep;
            elseif ($row[$j] != "")
                $schema_insert .= "$row[$j]".$sep;
            else
                $schema_insert .= "".$sep;
        }
        $schema_insert = str_replace($sep."\$", "", $schema_insert);
        echo trim($schema_insert);
	    echo $crlf;
        $i++;
     }
	
	
   } else
   {
   
   include_once "../inc/"."fgenped.php";
   include_once "../inc/"."fgentrad.php";
   $Mensajes = Comienzo ("sql-001",$IdiomaSitio);  
  
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi</title>
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
.style49 {font-family: verdana; font-size: 11px; color: #006599; }
.style55 {
	font-size: 11px;
	color: #000000;
	font-family: Verdana;
}
.style33 {	font-family: verdana;
	font-size: 11px;
	color: #006699;
}
.style58 {font-size: 11px}
.style60 {font-family: Arial}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<div align="left">
<form method="post" action="ejecutaSql.php">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">      <div align="center"><center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td align="center" valign="top" bgcolor="#E4E4E4">
            <div align="center">
              <center>
            <table width="576" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4"><table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td colspan="3" align="left" class="style45">
                      <table width="95%"  border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td valign="top"><div align="center">
                            <table width="95%"  border="0" cellpadding="1" cellspacing="1">
                              <tr>
                                <td colspan="2" bgcolor="#006699" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tf-6"]; ?></td>
                                </tr>
                              <tr>
                                <td width="150" class="style49" valign='top'><div align="right"><? echo $Mensajes["tf-1"]?></div></td>
                                <td class="style43" valign='top'><div align="left">
								<TEXTAREA NAME="query" COLS=50 ROWS=10 class="style43"><? if (isset($query))echo stripSlashes($query); ?> </TEXTAREA>
								  
                                </div></td>
                              </tr>
                              <tr>
                                <td width="150" class="style49" valign='top'><div align="right"><? echo $Mensajes["tf-2"];?></div></td>
                                <td class="style43" valign='top'><div align="left"><TEXTAREA  class="style43" NAME="query2" COLS=50 ROWS=10><? if (isset($query2))echo stripSlashes($query2); ?></TEXTAREA>
                                </div></td>
                              </tr>
							   <tr>
                                <td width="150" class="style49" valign='top' ><div align="right"><? echo $Mensajes["tf-3"]; ?></div></td>
                                <td class="style43" valign='top'><div align="left"><input  class="style43" type="checkbox" name="Archivo">
                                </div></td>
                              </tr>
																
                              <tr>
                                <td width="150" class="style49" valign='top'><div align="right"></div><div align="center"></div></td>
                                <td class="style49"  valign='top'>
								<INPUT TYPE=SUBMIT VALUE="<? echo $Mensajes["bot-1"]?>" class="style43">
								
								</td>
                              </tr>
							  <tr> 
									<td width="150" class="style49" valign='top'><div align="right"></div><div align="center"></div></td>
									<td class="style49" valign='top'>
								<?if (!empty($query)):
									
									
									  $query = stripSlashes($query) ;
									  $result = mysql_query($query);
									  if (!empty($query2))
									  {
									   $result = mysql_query($query2);
									  } 
								?>
								<? echo $Mensajes["tf-4"];?><B><?php echo($query); ?>
								
								<?php
									if ($result == 0):
										echo("<B>Error " . mysql_errno() . ": " . mysql_error() . "</B>");
									elseif (mysql_num_rows($result) == 0):
										echo("<B><font face='MS Sans Serif' size='1' color='#155CAA'>".$Mensajes["tf-5"]."</font></B>");
									else:
										 TablaMuestra($result);
									endif;
									
								endif;
								}
								?>
																</td>
                              </tr>


							
                            </table>
                            </div>                            
                            </td>
                          </tr>
                      </table>
					  </form>
                    </td>
                  </tr>
                </table>                  </td>
              </tr>
            </table>
	
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"><img src="../images/image001.jpg" width="150" height="118"><br>
                  <span class="style33"><a href="../admin/indexadm.php"><? echo $Mensajes["h-1"]; ?></a></span> </div>                <div align="center" class="style55"></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">sql-001</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
</table>
</div>
<?

	Desconectar();

?>
</body>
</html>









