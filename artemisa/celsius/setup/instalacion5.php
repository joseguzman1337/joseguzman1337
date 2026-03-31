<?
  include "instalacion.inc"; 
   $idiomaseleccionado=$HTTP_POST_VARS["idiomaseleccionado"];
   $celsius_login_s=$HTTP_POST_VARS["celsius_login"];
  $celsius_contrasena_s=$HTTP_POST_VARS["celsius_contrasena"];
  $dbbasegeral_s=$HTTP_POST_VARS["dbbasegeral"];
  $apellido_admin=$HTTP_POST_VARS["apellido_admin"];
   $nombre_admin=$HTTP_POST_VARS["nombre_admin"];
  $mail_admin=$HTTP_POST_VARS["mail_admin"];
  $contrasena_admin=$HTTP_POST_VARS["contrasena_admin"];
  $ambiente=$HTTP_POST_VARS["ambiente"];
  $host=$HTTP_POST_VARS["host"];
  $raiz_www=$HTTP_POST_VARS["raiz_www"];
  $pais=$HTTP_POST_VARS["Pais"];
  $institucion=$HTTP_POST_VARS["Institucion"];
  switch($idiomaseleccionado){
  case 1:$filename="archivos/instalaciones6.txt";break;
  case 2:$filename="archivos/instalacionen6.txt";break;
  case 3:$filename="archivos/instalacionpt6.txt";break;
  }
  $fp = fopen($filename, "r");
  $linea=file($filename);
global $fase_g;
  $fase_g=6;
 session_register("celsius_login_s");
  session_register("celsius_contrasena_s");
  session_register("dbbasegeral_s");
  $sock=ConectarDB($dbbasegeral_s,$celsius_login_s,$celsius_contrasena_s);
  if ($sock==-1)
    Voltar($linea[1]);
  $query="insert into Usuarios (Apellido,Nombres,EMail,Login,Password,Personal,Codigo_Pais,Codigo_Institucion) values ('".$apellido_admin."','".$nombre_admin."','".$mail_admin."','admin','".$contrasena_admin."','1','".$pais."','".$institucion."')";
  Enviar($sock,$query);
  $query1="insert into Parametros (directorio) values ('".$ambiente."')";

  Enviar($sock,$query1);
 
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
}
.style3 {font-size: 11px}
.style5 {font-size: 9px; font-weight: bold; color: #006699; }
.style6 {
	color: #666666;
	font-size: 9px;
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
.style7 {color: #000000}
-->
</style></head>

<body>
<?
AbrirFormularioFinal($raiz_www);
?>
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
            <p><span class="style3"><span class="style5">Instalaci&oacute;n | Fase 5 de 5</span></span></p>
          </blockquote>
        </div>          <div align="center" class="style1">
          <blockquote>
            <p align="left" class="style7"><? echo $linea[0];?></p>
          </blockquote>
        </div>
          <blockquote>
            <p align="left" class="style3"><? echo "1 -".$linea[2];?><br>
               <? echo $linea[3];?></p>
            <p align="center" class="style5"><? EncerrarPaginaFinal($linea[4]);?></p>
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
