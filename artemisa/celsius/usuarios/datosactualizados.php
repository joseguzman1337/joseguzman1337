<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."cache.inc";
  include_once "../inc/"."identif.php";
  Usuario();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>PrEBi </title>
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
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 9px; }
.style23 {
	color: #000000;
	font-size: 9px;
	font-family: verdana;
}
.style28 {color: #FFFFFF}
.style29 {color: #006599}
.style41 {color: #666666}
-->
</style>
<base target="_self">
</head>

<body topmargin="0">
<?  //pagina para actualizacion de los datos personales de los usuarios
  include_once "../inc/"."fgenped.php";
  include_once "../inc/"."fgentrad.php";
  global  $IdiomaSitio ; 
  $Mensajes = Comienzo ("pau-003",$IdiomaSitio);
  if ($update == 1)
      {
	$query="UPDATE Usuarios
	        SET Nombres='$Nombres',Apellido='$Apellido',EMail='$Mail'";
		if (isset($Direccion))
		  $query .= ",Direccion='$Direccion'";
		if (isset($Telefono))
		  $query .= ",Telefonos='$Telefono'";
		if (isset($Cargo))
		  $query .= ",Cargo='$Cargo'";

		if (isset($Paises))
		  $query .= ", Codigo_Pais=$Paises";
		if (isset($Instituciones))
		  $query .= ", Codigo_Institucion=$Instituciones";
		if (isset($Dependencias))
		  $query .= ", Codigo_Dependencia=$Dependencias";
		if (isset($Unidades))
		   $query .= ", Codigo_Unidad=$Unidades";
		if (isset($Categoria))
		   $query .= ", Codigo_Categoria=$Categoria";
        $query .= " WHERE Id = $Id_usuario";

      	$resu = mysql_query($query);
        echo mysql_error();
   }
   else
     echo "No hay update";
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
                    <td width="567" height="130" align="center" valign="middle" class="style23">                         <div align="center" class="style41"><? echo $Mensajes['txt-1']; ?></div></td>
                  </tr>
                </table>                  

                  </td>
              </tr>
            </table>
              </center>
            </div>            </td>
        <td width="150" valign="top" bgcolor="#E4E4E4"><div align="center" class="style11">
          <? dibujar_menu_usuarios($Apellido.', '.$Nombres,1); ?>
          </div></td>
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
          <td><div align="center"><a href="http://www.unlp.istec.org/prebi" target="_blank"><img src="../images/logo-prebi.jpg" alt="PrEBi | UNLP" name="PrEBi | UNLP" width="100" height="33" border="0" lowsrc="../PrEBi%20:%20UNLP"></a></div></td>
          <td width="50"><div align="center" class="style11">pau-003</div></td>
        </tr>
      </table>
    </div></td>
  </tr>
</table>
</div>
</body>
</html>
