<?
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";
include_once "../inc/"."parametros.inc.php";
Conexion();
include_once "../inc/"."identif.php";
Administracion();
if (!isset($Id_Entrega)){$Id_Entrega=0;}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><? echo Titulo_Sitio();?> </title>
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
	font-weight: normal;
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
.style67 {
	font-size: 9px;
	font-family: Verdana;
	font-weight: normal;
	color: #000000;
}
.style13 {
color: #006699; font-family: Verdana; font-size: 9px;
}
-->
</style>
<base target="_self">
</head>
<script language="JavaScript">
 function download(Id,Tipo)
{
   document.forms.form1.action="reg_download.php";
   document.forms.form1.Id.value = Id;
   document.forms.form1.Tipo_Material.value = Tipo;
   document.forms.form1.submit();

 }

 function download_todos(User)
{
   document.forms.form1.action="download_todo.php";
   document.forms.form1.User.value = User;
   document.forms.form1.submit();

 }

 function rutear_pedidos (TipoPed,Id)
 {

     switch (TipoPed)
	  {
	    case 1:
	      ventana=open("verped_col.php?Id="+Id+"&dedonde=2&Tabla=1","Colecciones","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 2:
	      ventana=open("verped_cap.php?Id="+Id+"&dedonde=2&Tabla=1","Capitulos","scrollbars=yes,width=700,height=450,alwaysLowered");
	      break;
	    case 3:
          ventana=open("verped_pat.php?Id="+Id+"&dedonde=2&Tabla=1","Patentes","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;
        case 4:
          ventana=open("verped_tes.php?Id="+Id+"&dedonde=2&Tabla=1","Tesis","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;
		 case 5:
          ventana=open("verped_con.php?Id="+Id+"&dedonde=2&Tabla=1","Congresos","scrollbars=yes,width=700,height=450,alwaysRaised");
          break;

	  }

	 return null

 }
</script>

<body topmargin="0">
<?
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."tabla_ped_unnoba.inc";

  Conexion();
  global $IdiomaSitio;
   $Mensajes = Comienzo ("adm-002",$IdiomaSitio);
   $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);


?>

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
                  
				<form name="form2" action="manpedent4.php">
                  <tr>
                    <td align="left" class="style45"><table width="450" border="0" align="center" cellpadding="1" cellspacing="0" >
                      <tr class="style43">
                        <td width="40%" align="left" class="style49"><div align="right"><? echo $Mensajes["tc-3"]?> </div></td>
                        <td align="left"  class="style49"><div align="left">
                       <select size="1" name="Id_Entrega" class="style43">

						<?

						   $expresion = "SELECT Usuarios.Id,Usuarios.Apellido,Usuarios.Nombres,COUNT(*) ";
						   $expresion .= "FROM Pedidos ";
						   $expresion .= "LEFT JOIN Usuarios ON Pedidos.Codigo_Usuario = Usuarios.Id ";
						   $expresion .= "WHERE Pedidos.Estado=".Devolver_Estado_SolicitarPDF();
						   $expresion .=" GROUP BY Pedidos.Codigo_Usuario ORDER BY Usuarios.Apellido,Usuarios.Nombres";

                           
							$result = mysql_query($expresion);
							echo mysql_error();

							while($row = mysql_fetch_row($result))
						   {

							if ($Id_Entrega==$row[0])
							{
							 ?>
						   <option selected value="<? echo $row[0]; ?>"><? echo $row[1].",".$row[2]." [".$row[3]."]"; ?></option>
						  <?
							} else { ?>
							<option value="<? echo $row[0]; ?>"><? echo $row[1].",".$row[2]." [".$row[3]."]"; ?></option>
						  <? }
						   } ?>
							</select>
                        </div></td>
                      </tr>

                      <tr class="style43">
                        <td width="40%" align="left"  class="style49">
                          <div align="right"></div></td>
                        <td align="left"  class="style45"><div align="left">
                           <input type="submit" value="<? echo $Mensajes["bot-1"]; ?>" name="B1" class="style43">
                        </div></td>
                      </tr>
                    </table>                      
<?
   if ($Id_Entrega!=0)
   {

  	  $expresion = armar_expresion_busqueda();
     $expresion = $expresion."WHERE Pedidos.Estado=".Devolver_Estado_SolicitarPDF()." AND Pedidos.Codigo_Usuario=".$Id_Entrega;
     $result = mysql_query($expresion);
     echo mysql_error();
?>

					  <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="1" bgcolor="#006699" class="style45">
                        <tr valign="top" bgcolor="#006699" class="style43">
                          <td class="style43"> <div align="left" class="style45"><img src="../images/square-w.gif" width="8" height="8"><? echo $Mensajes["tc-4"]; ?>-<? echo mysql_num_rows($result); ?></div>                            </td>
                          </tr>
                      </table>
                      <br>
<?
      while($row = mysql_fetch_row($result))
     {
 		Dibujar_Tabla_Comp_Cur($VectorIdioma,$row,$Mensajes);

   ?>

						 <form name="form3" method="POST">
						  <p align="center">
						  <input type="button" value="<? echo $Mensajes["bot-2"]; ?>" name="B3" class="style43" OnClick="rutear_pedidos(<? echo $row[4]; ?>,'<? echo $row[1]; ?>')">
						  <input type="button" value="<? echo $Mensajes["botc-5"]; ?>" name="B1" class="style43" OnClick="download('<? echo $row[1]; ?>',<? echo $row[4]; ?>)">
						  <input type="button" value="<? echo $Mensajes["botc-6"]; ?>" name="B4" class="style43" OnClick="download_todos(<? echo $row[39]; ?>)">
						  </p>
						  <input type="hidden" name="Modo">
						 </form>
						 </td></tr></table>
						 <br>
    <?
       }
    ?>
<form name="form1" method="post">
 <input type="hidden" name="dedonde" value=0>
 <input type="hidden" name="Id">
 <input type="hidden" name="Operador" value="<? echo $Id_usuario; ?>">
 <input type="hidden" name="Tipo_Material">
 <input type="hidden" name="User">

</form>





<?


  }
   mysql_free_result($result);
   
?>

             </td>
              </tr>
            </table>
              </center>
            </div>
            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <table width="100%" bgcolor="#ececec">
            <tr>
              <td class="style28"><div align="center"></div>                <div align="center" class="style11"><img src="../images/image001.jpg" width="150" height="118"><br>
                <a href="../admin/indexadm.php"><? echo $Mensajes["h-1"];?></a></div></td>
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
          <td width="50" class="style49"><div align="center" class="style11">adm-002</div></td>
        </tr>
      </table>
      </div></td>
  </tr>
  
</table>
</div>
</body>
</html>