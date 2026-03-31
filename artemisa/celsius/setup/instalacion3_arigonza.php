<?
  include "instalacion.inc"; 
  $idiomaseleccionado=$HTTP_POST_VARS["idiomaseleccionado"];
  $root_mysql_s=$HTTP_POST_VARS["root_mysql"];
  $root_mysql_contrasena_s=$HTTP_POST_VARS["root_mysql_contrasena"];
  //$celsius_login_s=$HTTP_POST_VARS["celsius_login"];
  //$celsius_contrasena_s=$HTTP_POST_VARS["celsius_contrasena"];
  $dbbasegeral_s=$HTTP_POST_VARS["dbbasegeral"];
  switch($idiomaseleccionado){
  case 1:$filename="archivos/instalaciones4.txt";break;
  case 2:$filename="archivos/instalacionen4.txt";break;
  case 3:$filename="archivos/instalacionpt4.txt";break;
  } 
  $fp = fopen($filename, "r");
  $linea=file($filename);
  Encabezado(4,$linea[0],$idiomaseleccionado);
 /* session_register("celsius_login_s");
  session_register("celsius_contrasena_s");
  session_register("dbbasegeral_s");
  session_register("tmpcelsius_login_s");
  session_register("tmpcelsius_contrasena_s");
  session_register('root_mysql_s');
  session_register('root_mysql_contrasena_s');*/
  $sock=ConectarDB("mysql",$root_mysql_s,$root_mysql_contrasena_s);
  $versao_geral = mysql_get_server_info();
  $versao_numero = $versao_geral[0]; 
  if ($sock==-1)
    Voltar($linea[1]."<br><br>".$linea[2].": <font color=black>".mysql_error()."</font>");
 //$tmpcelsius_login_s=$HTTP_POST_VARS["tmpcelsius_login"];
 //$tmpcelsius_contrasena_s=$HTTP_POST_VARS["tmpcelsius_contrasena"];
 //$query1="grant alter, create, delete, drop, index, insert, select, update on ".$dbbasegeral_s.".* to ".$celsius_login_s."@localhost identified by '".$celsius_contrasena_s."'";
 //Enviar($sock,$query1);
#Setea privilegios de usuario de celsius;
// $query3 = "INSERT INTO db (Host, Db, User, Select_priv, Insert_priv, Update_priv, Delete_priv, Create_priv, Drop_priv, References_priv, Index_priv, Alter_priv) VALUES ('localhost', '".$dbbasegeral_s."%', '".$celsius_login_s."', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y')";
//Enviar($sock, $query3);
//  $query5 = "FLUSH PRIVILEGES";
//  Enviar($sock, $query5);
  
  $query18 = "drop database ".$dbbasegeral_s;
  Enviar($sock, $query18);
  $query6 = "create database ".$dbbasegeral_s;
  Enviar($sock, $query6); 
 // $query8="grant alter, create, delete, drop, index, insert, select, update on Samb* to ".$celsius_login_s."@localhost identified by '".$celsius_contrasena_s."'";
 //Enviar($sock,$query8);
//$query9 = "INSERT INTO db (Host, Db, User, Select_priv, Insert_priv, Update_priv, Delete_priv, Create_priv, Drop_priv, References_priv, Index_priv, Alter_priv) VALUES ('localhost', 'Samb%', '".$celsius_login_s."', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y', 'Y')";

//  Enviar($sock, $query9);
//  $query10 = "FLUSH PRIVILEGES";
 // Enviar($sock, $query10);
 

#
  $query19 = "drop database Samb";
  Enviar($sock, $query19);
  $query7 = "create database Samb";

  Enviar($sock, $query7);
  
  mysql_close($sock);
  if (CrearBase($dbbasegeral_s,$root_mysql_s,$root_mysql_contrasena_s)==-1)
    Voltar($linea[2].": <font color=black>".mysql_error()."</font>");
// if (CrearBaseAux("Samb",$celsius_login_s,$celsius_contrasena_s)==-1)
  if (CrearBaseAux("Samb",$root_mysql_s,$root_mysql_contrasena_s)==-1)
    Voltar($linea[2].": <font color=black>".mysql_error()."</font>");
 
  echo("
    <script language=javascript>
      function Valida()
      {
        var ambiente=document.inst.ambiente.value;
        while (ambiente.search(\" \") != -1)
          ambiente = ambiente.replace(/ /, \"\");
        var raiz_www=document.inst.raiz_www.value;
        while (raiz_www.search(\" \") != -1)
          raiz_www = raiz_www.replace(/ /, \"\");
        var email_sitio=document.inst.email_sitio.value;
        while (email_sitio.search(\" \") != -1)
          email_sitio = email_sitio.replace(/ /, \"\");
        var titulo_sitio=document.inst.titulo_sitio.value;
        while (titulo_sitio.search(\" \") != -1)
          titulo_sitio = titulo_sitio.replace(/ /, \"\");
        
		if (ambiente==''  || raiz_www=='' || email_sitio=='' || titulo_sitio=='')
          {
            alert('Debe llenar los campos para poder continuar.');
            return false;
          }
         return true;
      }
    </script>
  ");
  AbrirFormulario();
  Parrafo("1 -".$linea[3]);
  Parrafo("2 -".$linea[4]);
  Parrafo("<hr>");
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
   $string=strstr($sistemaOperativo,"LINUX");
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
  
  Parrafo("<b><font size=+1>".$linea[5]."</font></b>");
 // CargaTexto($linea[6]."<b>Ej.:</b> /home/Celsius/public_html):","dircelsius");
  CargaTexto("Directorio donde se encontrara la carpeta INC","directorio","");
  CargaTexto($linea[7]."<b>Ej:</b> /services/upload):","ambiente","");
  CargaTexto($linea[8]."<b>Ej:</b> /celsius):","raiz_www",""); 
  CargaTexto($linea[9],"email_sitio","");
  CargaTexto($linea[10],"titulo_sitio",""); 
  echo "<INPUT TYPE='hidden' name='idiomaseleccionado' value='$idiomaseleccionado'>";
  echo "<INPUT TYPE='hidden' name='include_path' value='$include_total'>";
  echo "<INPUT TYPE='hidden' name='root_mysql' value='$root_mysql_s'>";
   echo "<INPUT TYPE='hidden' name='root_mysql_contrasena' value='$root_mysql_contrasena_s'>";
   //echo "<INPUT TYPE='hidden' name='celsius_login' value='$celsius_login_s'>";
   //echo "<INPUT TYPE='hidden' name='celsius_contrasena' value='$celsius_contrasena_s'>";
   echo "<INPUT TYPE='hidden' name='dbbasegeral' value='$dbbasegeral_s'>";
   //echo "<INPUT TYPE='hidden' name='tmpcelsius_login' value='$tmpcelsius_login_s'>";
   //echo "<INPUT TYPE='hidden' name='tmpcelsius_contrasena value='$tmpcelsius_contrasena_s'>";
  
  EncerrarPagina($linea[11]);
?>
