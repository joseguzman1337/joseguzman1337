<?
  include "instalacion.inc"; 
  $idiomaseleccionado=$HTTP_POST_VARS["idiomaseleccionado"];
//  echo $idiomaseleccionado."fff";
  switch($idiomaseleccionado){
  case 1:$filename="archivos/instalaciones1.txt";break;
  case 2:$filename="archivos/instalacionen1.txt";break;
  case 3:$filename="archivos/instalacionpt1.txt";break;
  }
  $fp = fopen($filename, "r");
  $linea=file($filename);
  global $fase_g;
  $fase_g=1;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Instalacion de Celsius</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">
<!--
body {
	background-color: #e4e4e4;
	background-image: url(images/bg4.gif);
}
body,td,th {
	font-family: Tahoma;
	font-size: 9px;
}
.style1 {
	font-size: 12px;
	font-weight: bold;
	color: #006699;
	font-family: Tahoma;
}
.style3 {
	font-size: 11px;
	font-family: Tahoma;
}
.style5 {
	font-size: 9px;
	font-weight: bold;
	color: #006699;
	font-family: Tahoma;
}
.style6 {
	color: #666666;
	font-size: 9px;
	font-family: Tahoma;
}
a:link {
	color: #006699;
	text-decoration: none;
}
a:visited {
	color: #006699;
	text-decoration: none;
}
a:hover {
	color: #0099FF;
	text-decoration: underline;
}
a:active {
	color: #006699;
	text-decoration: none;
}
.style7 {
	color: #000000;
	font-family: Tahoma;
	font-size: 12px;
	font-weight: bold;
}
.style8 {
	color: #006699;
	font-family: Tahoma;
	font-size: 11px;
}
-->
</style></head>
<? echo("<script language=javascript>function Valida(){var dbbasegeral=document.inst.dbbasegeral.value;if (dbbasegeral=='' ){          alert('aca iria linea3');return false; } return true; } </script>");?>
<body>
<?  AbrirFormulario();?>
<table width="640" height="80%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="130"><img src="imagenes/head-celsius.jpg" width="640" height="130"></td>
  </tr>
  <tr>
    <td align="center" valign="middle" bgcolor="#FFFFFF"><table width="90%" height="90%"  border="0" align="center" cellpadding="1" cellspacing="0">
      <tr>
        <td><div align="left">
          <p>&nbsp;</p>
          <blockquote>
            <p><span class="style3"><span class="style5">Instalaci&oacute;n | Fase 2 de 5</span></span></p>
          </blockquote>
        </div>          <div align="center" class="style1">
          <blockquote>
            <p align="left" class="style7"><? echo $linea[0];?></p>
          </blockquote>
        </div>
          <blockquote>
            <p align="left" class="style3"><? echo $linea[1];?></p>
            <p align="left" class="style3"> <span class="style8"><? echo $linea[2];?></span>                
              <input name="dbbasegeral" type="text" class="style3">
            </p>
            <p align="center" class="style5">
 <? echo "<INPUT TYPE='hidden' name='idiomaseleccionado' value='$idiomaseleccionado'>";?>
  <? EncerrarPagina($linea[4]);?></p>
          </blockquote>          <p align="center" class="style3"><span class="style6">un producto dise&ntilde;ado integramente por el <a href="http://www.unlp.istec.org/prebi/">PrEBi</a></span></p>
          <p align="center" class="style3"></p></td>
      </tr>
    </table>      </td>
  </tr>
  <tr>
    <td height="15"><img src="imagenes/barra02.jpg" width="640" height="15"></td>
  </tr>
</table>
<p align="center"><img src="imagenes/banner-istec.jpg" width="88" height="31">  <img src="imagenes/banner-prebi.jpg" width="88" height="31"></p>
</body>
</html>
