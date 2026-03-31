<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  include_once "../inc/"."parametros.inc.php";
  
  Conexion();
  	
  if (isset($download) && $download != '')
  {
	header("Content-type: application/octetstream");
    header("Pragma: no-cache");
    header("Location:".Destino().$download);
  }
  else {


  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("dds-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
 

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
.style28 {color: #FFFFFF; font-size: 11px; }
.style43 {
	font-family: verdana;
	font-size: 10px;
}
.style45 {font-family: Verdana; color: #FFFFFF;}
.style46 {
	color: #006599;
	font-family: verdana;
	font-size: 10px;
	font-style: normal;
	font-weight: bold;
}
.style47 {font-size: 11px}
.style48 {color: #006599}
.style49 {font-family: verdana; font-size: 10px; color: #006599; }
.style51 {font-family: verdana; color: #000000; }
.style52 {color: #000000}
.style54 {font-family: verdana; font-size: 10px; color: #000000; }
.style55 {
	font-size: 10px;
	color: #000000;
	font-family: Verdana;
}
.style56 {font-family: Verdana}
.style57 {font-size: 10px}
.style58 {color: #006699}
-->
</style>
<base target="_self">
</head>

<body top-margin=0>

<div align="left">
  <table width="780" border="0" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#EFEFEF" style="border-collapse: collapse">
  <tr>
    <td bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <a name="top"></a>      <div align="center">
        <center>
      <table width="100%" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#EFEFEF">
        <td bgcolor="#E4E4E4">

            <div align="center">
              <center>
            <table width="95%" border="0" style="margin-bottom: 0; margin-top:0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td valign="top" bgcolor="#E4E4E4">
                <table width="100%"  border="0" cellpadding="0" cellspacing="0" class="style43">
                  <tr>
                    <td height="20" colspan="3" class="style45"><blockquote>
                      <p align="left" class="style54"><span class="style46"><strong><img src="../images/square-w.gif" width="8" height="8"> <span class="style47"><? echo $Mensajes['st-001']; ?></span></strong></span><span class="style47"><br>
                       <? echo $Mensajes['st-002']; ?></span></p>
                      </blockquote>                      <hr></td>
                    </tr>


                    <tr bgcolor="#cccccc">
                        <td width="14" height="20" class="style45"><div align="left"></div></td>
                           <td width="547" class="style45 style52"><div align="left">
                           <a name="link1"> </a>
                           <a href="http://www.istec.org" target=_BLANK> <? echo $Mensajes['st-003']; ?><br>
                           <? echo $Mensajes['st-004']; ?> </a>
                            </div></td>
                           <td width="15" class="style45">&nbsp;</td>
                           </tr>
                           <tr>
                           <td colspan="3"> <div align="left">

	                          <blockquote class="style43">
   	                          <? echo $Mensajes['st-005']; ?><br><br>
                              <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46">
                               <? echo $Mensajes['st-006']; ?> 
                              </span></strong><br>
                              <? echo $Mensajes['st-007']; ?> 
                              <a href="#top"><span class="style58">^</span></a>
                              <br><br>
                               <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46"><? echo $Mensajes['st-008']; ?> </span></strong><br>
                              <? echo $Mensajes['st-009']; ?> <br><br>
                              <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46"><? echo $Mensajes['st-010']; ?></span></strong><br>
                              <? echo $Mensajes['st-011']; ?>
                              <ul>
                                <li> <? echo $Mensajes['st-012']; ?>
                                <li> <? echo $Mensajes['st-013']; ?>
                                <li> <? echo $Mensajes['st-014']; ?>
                                <li> <? echo $Mensajes['st-015']; ?>
                              </ul>
							  <br><a href="#top"><span class="style58">^</span></a><br>
                              <strong><img src="../images/square-lb.gif" width="8" height="8">
                              <span class="style46"><a name="link2"></a><? echo $Mensajes['st-016']; ?></span></strong><br><br>
                              <? echo $Mensajes['st-017']; ?><br>
                              <? echo $Mensajes['p-1'];?><br>
                              <? echo $Mensajes['st-018']; ?><br>
                              <? echo $Mensajes['i-1'];?> <br>
                            <? echo $Mensajes['st-019']; ?><br>
                            <? echo $Mensajes['i-2'];?><br>
                            <br>
							<? echo $Mensajes['st-23']; ?>
                             <? echo $Mensajes['i-3'];?>
                          </blockquote>

                            </div>
                            <tr> <td algin=left> <a href="#top"><span class="style58">^</span></a> </td> </tr>
                          <hr align="left"></td>
                          </tr>
                       <tr bgcolor="#cccccc">
                           <td width="14" height="20" class="style45"><div align="left"></div></td>
                           <td width="547" class="style45 style52"><div align="left">
                           <a name="link3"><? echo $Mensajes["st-021"];?> </a> </div></td>
                           <td width="15" class="style45">&nbsp;</td>
                       </tr>
                       <tr>
                        <td colspan="3" align=left>
                      <blockquote class="style43">
                      <strong><img src="../images/square-lb.gif" width="8" height="8">
                      <span class="style46"> <? echo $Mensajes["st-022"];?></span>
                         </strong><br>
                       <br>
                      <?
                        $cons = "Select Apellido, Nombres, Email, Cargo
                                 from Usuarios
                                 where Staff = 1
                                 Order By Orden_Staff";
                                 
                        $resu = mysql_query($cons);
                        //echo mysql_error($resu);
                        echo "<table> <div align=3>";
                        while ($row = mysql_fetch_array($resu))
                        {
                          echo "<tr> <td align=left valign='top'>
                                     <a href='mailto:".$row[2]."'>".$row[0].", ".$row[1]."</a> </td>
                                     <td> &nbsp;&nbsp;&nbsp;</td>
                                    <td align=left valign='top'> ".$row[3]." </td> </tr>     ";
                        }
                        ?>

                        </div></table>

                      </blockquote>
                       </td>
                       </tr>
                       <tr> <td algin=left> <a href="#top"><span class="style58">^</span></a> </td> </tr>

          </table>
          </div>
          </td>
		      <td width="200" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="98%" bgcolor="#ececec">
            <tr>
              <td height="20" bgcolor="#006599" class="style28"><div align="center"><? echo $Mensajes["men-1"];?> </div></td>
            </tr>
            <tr>
              <td height="18" class="style11"><div align="left" class="style55 style43 style56 style57">
                <p style="margin-top: 0; margin-bottom: 0"><img src="../images/square-w.gif" width="8" height="8"> <a href="#link1"><? echo $Mensajes["st-006"];?></a> </div></td>
            </tr>
            <tr>
              <td height="18" class="style11"><div align="center" class="style54 style56 style57">
                <p align="left" style="margin-top: 0; margin-bottom: 0"><img src="../images/square-w.gif" width="8" height="8">  <a href="#link2"><? echo $Mensajes["st-016"];?></a></p>
                </div></td>
            </tr>
            <tr>
              <td height="18" class="style11"><div align="center" class="style55">
                <p align="left" style="margin-top: 0; margin-bottom: 0"><img src="../images/square-w.gif" width="8" height="8"> <a href="#link3"><? echo $Mensajes["st-021"];?></a></p>
                </div></td>
            </tr>


          </table>
          </div>
          </td>
        </tr>
    </table>    </center>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" border="0" lowsrc="../PrEBi%20:%20UNLP"></a> </div></td>
          <td width="50" class="style49"><div align="center" class="style11">dds-001</div></td>
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

