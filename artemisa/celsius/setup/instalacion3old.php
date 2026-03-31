<?
  include "instalacion.inc"; 
  $idiomaseleccionado=$HTTP_POST_VARS["idiomaseleccionado"];
  $root_mysql_s=$HTTP_POST_VARS["root_mysql"];
  $root_mysql_contrasena_s=$HTTP_POST_VARS["root_mysql_contrasena"];
  $celsius_login_s=$HTTP_POST_VARS["root_mysql"];
  $celsius_contrasena_s=$HTTP_POST_VARS["root_mysql_contrasena"];
  $mysqlpath=$HTTP_POST_VARS["mysqlpath"];
//  $celsius_login_s=$HTTP_POST_VARS["celsius_login"];
//  $celsius_contrasena_s=$HTTP_POST_VARS["celsius_contrasena"];
  $dbbasegeral_s=$HTTP_POST_VARS["dbbasegeral"];
  switch($idiomaseleccionado){
  case 1:$filename="archivos/instalaciones4.txt";break;
  case 2:$filename="archivos/instalacionen4.txt";break;
  case 3:$filename="archivos/instalacionpt4.txt";break;
  } 
  $fp = fopen($filename, "r");
  $linea=file($filename);
global $fase_g;
  $fase_g=4;

 $sock=ConectarDB("mysql",$root_mysql_s,$root_mysql_contrasena_s);
  $versao_geral = mysql_get_server_info();
  $versao_numero = $versao_geral[0]; 
  if ($sock==-1)
    Voltar($linea[1]."<br><br>".$linea[2].": <font color=black>".mysql_error()."</font>");

 $query1="grant alter, create, delete, drop, index, insert, select, update on ".$dbbasegeral_s.".* to ".$celsius_login_s."@localhost identified by '".$celsius_contrasena_s."'";
 Enviar($sock,$query1);
#Setea privilegios de usuario de celsius;
 $query3 = "INSERT INTO db (Host, Db, User, Select_priv, Insert_priv, Update_priv, Delete_priv, Create_priv, Drop_priv, References_priv, Index_priv, Alter_priv) VALUES ('localhost', '".$dbbasegeral_s."%', '".$celsius_login_s."', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y')";
Enviar($sock, $query3);
  $query5 = "FLUSH PRIVILEGES";
  Enviar($sock, $query5);
  
  $query18 = "drop database ".$dbbasegeral_s;
  Enviar($sock, $query18);
  $query6 = "create database ".$dbbasegeral_s;
 
  Enviar($sock, $query6); 
  $query8="grant alter, create, delete, drop, index, insert, select, update on Samb* to ".$celsius_login_s."@localhost identified by '".$celsius_contrasena_s."'";
 Enviar($sock,$query8);
$query9 = "INSERT INTO db (Host, Db, User, Select_priv, Insert_priv, Update_priv, Delete_priv, Create_priv, Drop_priv, References_priv, Index_priv, Alter_priv) VALUES ('localhost', 'Samb%', '".$celsius_login_s."', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y')";

  Enviar($sock, $query9);
  $query10 = "FLUSH PRIVILEGES";
  Enviar($sock, $query10);
 

#
  $query19 = "drop database Samb";
  Enviar($sock, $query19);
  $query7 = "create database Samb";

  Enviar($sock, $query7);
  
  mysql_close($sock);
  if (CrearBase($dbbasegeral_s,$celsius_login_s,$celsius_contrasena_s,$mysqlpath)==-1)
    Voltar($linea[2].": <font color=black>".mysql_error()."</font>");
 if (CrearBaseAux("Samb",$celsius_login_s,$celsius_contrasena_s)==-1)
    Voltar($linea[2].": <font color=black>".mysql_error()."</font>");
 
 

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
 
    <script language=javascript>
      function Valida()
      {
        var ambiente=document.inst.ambiente.value;
       // while (ambiente.search(\" \") != -1)
         // ambiente = ambiente.replace(/ /, \"\");
        var raiz_www=document.inst.raiz_www.value;
        //while (raiz_www.search(\" \") != -1)
          //raiz_www = raiz_www.replace(/ /, \"\");
        var email_sitio=document.inst.email_sitio.value;
        //while (email_sitio.search(\" \") != -1)
          //email_sitio = email_sitio.replace(/ /, \"\");
        var titulo_sitio=document.inst.titulo_sitio.value;
        //while (titulo_sitio.search(\" \") != -1)
          //titulo_sitio = titulo_sitio.replace(/ /, \"\");
        
		if (ambiente==''  || raiz_www=='' || email_sitio=='' || titulo_sitio=='')
          {
            alert('Debe llenar los campos para poder continuar.');
            return false;
          }
         return true;
      }
    </script>
 
 <body>
<? AbrirFormulario();?>
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
            <p><span class="style3"><span class="style5">Instalaci&oacute;n | Fase 4 de 5</span></span></p>
          </blockquote>
        </div>          <div align="center" class="style1">
	  <blockquote>
          <p align="left" class="style7"><? echo "1 -".$linea[3];?></p>
      </blockquote>
     </div>
        <div align="center" class="style1">
         		  <blockquote>
            <p align="left" class="style7"><? echo "2 -".$linea[4];?></p>
          </blockquote>

        </div>

<?
$path=realpath(".");
  $exp=explode("/",$path);
  if (count($exp)>2)
  {
    $ambiente="";
    for ($c=1; $c<count($exp)-2;$c++)
      $ambiente.="/".$exp[$c];
    $subcelsius=$exp[count($exp)-2];  
    $raiz_www="/~".$exp[count($exp)-3];
  }
  else
  {
    $ambiente="/home/Celsius";
    $subcelsius="public_html";
    $raiz_www="/";
  }
  //$dircelsius=$ambiente."/".$sublesius;
  //$arquivosweb=$dircelsius;
  $sistemaOperativo=PHP_OS;
  $string=strstr($sistemaOperativo,"Sun");
  
  if ($string!="")
    {
	 $include=ini_set("include_path","");
     
	 $include=substr($include,2);
     if (strpos($include,":")!=0)
    	{$include_total=substr($include,0,strpos($include,":")); }
     else {$include_total=$include;}
	 }
  $sistemaOperativo=PHP_OS;
   
   $string=strstr($sistemaOperativo,"Linux");
  
  if ($string!="")
    {
	 
	 $include=ini_set("include_path","");
     
	 $include=substr($include,2);
     if (strpos($include,":")!=0)
    	{$include_total=substr($include,0,strpos($include,":")); }
      else {$include_total=$include;}
	 }
  $sistemaOperativo=PHP_OS;
  $string=strstr($sistemaOperativo,"WIN");
  if ($string!="")
    {
	 
	 $include=ini_set("include_path","");
     $include=substr($include,2);
     if (strpos($include,";")!=0)
    	{$include_total=substr($include,0,strpos($include,";")); }
       else {$include_total=$include;}
	 }
  

?>




<div align="center" class="style1">
         		  <blockquote>
            <p align="left" class="style7"><? echo $linea[5];?></p>
          </blockquote>

        </div>
    <p align="left" class="style3"> <span class="style8">Directorio donde se encontrara la carpeta INC</span></p>
    <p align="left" class="style3">
      <input name="directorio" type="text" class="style3" size="50">
    </p>
    <p align="left" class="style3"> <span class="style8"><? echo $linea[7]."<b>Ej:</b> /services/upload):";?></span>
    </p>
    <p align="left" class="style3">
     <input name="ambiente" type="text" class="style3" size="50">
    </p>
    <p align="left" class="style3"> <span class="style8"><? echo $linea[8]."<b>Ej:</b> /celsius):";?></span>
    </p>
    <p align="left" class="style3">
     <input name="raiz_www" type="text" class="style3" size="50">
    </p>
    <p align="left" class="style3"> <span class="style8"><? echo $linea[9];?></span>
    </a>
    <p align="left" class="style3">
      <input name="email_sitio" type="text" class="style3" size="50">
    </p>
	<p align="left" class="style3"> <span class="style8"><? echo $linea[10];?></span>
    </p>
    <p align="left" class="style3">
     <input name="titulo_sitio" type="text" class="style3" size="50">
    </p>
<?

/*$nombre_de_maquina = $_SERVER['SERVER_NAME'];
  
  if ($nombre_de_maquina == "")
    $nombre_de_maquina = $_SERVER['SERVER_ADDR'];

$nombre_de_maquina="http://".$nombre_de_maquina."/".$host."/";
*/
   //$nombre=substr($nombre,strpos($nombre,'/')+1);
   //echo $nombre;

?>
<!--<p align="left" class="style3"> <span class="style8"><? echo $linea[8]."(Ej. www.unlp.istec.org): ";?></span>
              <input name="host" type="text" size="50" value=<? echo $nombre_de_maquina;?> class="style3">
            </p>
    -->
            <p align="center" class="style5">
			<?
  echo "<INPUT TYPE='hidden' name='idiomaseleccionado' value='".$idiomaseleccionado."'>";
  echo "<INPUT TYPE='hidden' name='include_path' value='".$include_total."'>";
  echo "<INPUT TYPE='hidden' name='root_mysql' value='".$root_mysql_s."'>";
   echo "<INPUT TYPE='hidden' name='root_mysql_contrasena' value='".$root_mysql_contrasena_s."'>";
   echo "<INPUT TYPE='hidden' name='celsius_login' value='".$celsius_login_s."'>";
   echo "<INPUT TYPE='hidden' name='celsius_contrasena' value='".$celsius_contrasena_s."'>";
   echo "<INPUT TYPE='hidden' name='dbbasegeral' value='".$dbbasegeral_s."'>";
//   echo "<INPUT TYPE='hidden' name='host' value='".$nombre_de_maquina."'>";
  EncerrarPagina($linea[11]);
			?>
			</p>
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
