<?

set_time_limit(0);
session_start();

function RetornaSessionID()
{
  return SID;
}

function Encabezado($fase,$titulo,$idiomaseleccionado)
{
  global $fase_g;
  $fase_g=$fase;
  if ($fase==4)
     {$fase=$fase-1;}
  if ($fase==5)
     {$fase=$fase-1;}
  if ($fase==6)
     {$fase=$fase-1;}
  
    echo("<html><head>\n");
  switch($idiomaseleccionado){
  case 1:$filename="archivos/encabezadoes.txt";break;
  case 2:$filename="archivos/encabezadoen.txt";break;
  case 3:$filename="archivos/encabezadopt.txt";break;
  }
  $fp = fopen($filename, "r");
  $linea=file($filename);
  echo("<title>".$linea[0]."</title>\n");
  echo("</head>\n");
  echo("<style>\n");
  echo(".block {\n");
  echo("  font-family: sans-serif;\n");
  echo("  font-size: 11pt;\n");
  echo("  font-weight: bold;\n");
  echo("  color: #0000ff;\n");
  echo("  position: absolute;\n");
  echo("  visibility: hidden;\n");
  echo("}\n");
  echo("</style>\n");

  echo("<body bordercolor=#111111 bgcolor=#E4E4E4 style=border-collapse: collapse >\n");//text=#000000 bgcolor=#FFFFFF link=#0000FF vlink=#0000FF ALINK=#0000FF background='imagenes/banda.jpg'>\n");
  echo("<table width=100% cols=2>\n");
  echo("  <tr valign=bottom>\n");
  echo("    <td><img SRC=imagenes/logo1baja.jpg border=0 height=79 width=330></td>\n");
  echo("    <td align=right>\n");

  echo("      <font face=Verdana,Arial,Helvetica color=#990000 size=+1>".$linea[1]." ".$fase." de 5</font>\n");
  echo("    </td>\n");
  echo("  </tr>\n");
  echo("</table>\n");
  echo("<hr>\n");
  echo("<table border=0 width=100%><tr><td align=center><font face=Verdana,Arial,Helvetica size=+1><b>".$titulo."</b></font></td></tr></table><br>\n");
}

function AbrirFormulario()
{
  global $fase_g;
  $fase=$fase_g;
  if ($fase==4)
     {$fase=$fase-1;}
  if ($fase==5)
     {$fase=$fase-1;}
    echo("<form action='instalacion".($fase+1).".php?".RetornaSessionID()."&' name=inst onSubmit='return(Valida());' method=post>\n");
}

function AbrirFormularioFinal($raiz_www)
{
  global $fase_g;
  $fase=$fase_g;
  echo("<form action='..".$raiz_www."/index.php'>\n");
}

function Parrafo($texto)
{
  echo("<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=Verdana,Arial,Helvetica size=-1>\n");
  echo($texto);
  echo("\n</font></p>\n");
}

function EncerrarPagina($titulo)
{
  echo("<input type=submit value=".$titulo." class='style5'>\n");
  echo("</form>\n");
  echo("</body></html>\n");
}

function EncerrarPaginaFinal()
{
  echo("<br><hr><br><br><input type=submit value='Entrar al sitio Celsius'>\n");
  echo("</form>\n");
  echo("</body></html>\n");
}

function Destaque($texto)
{
  echo("<ul><font face=Verdana,Arial,Helvetica size=-1>\n");
  echo($texto);
  echo("\n</font></ul>\n");
}

function CargaTexto($texto,$nome_var,$padrao)
{
  if (func_num_args() > 3)
    $arg = func_get_arg(3);
  else
    $arg = "";
  echo("<font face=Verdana,Arial,Helvetica size=-1>$texto<br><input size='30' type=text name=".$nome_var." value='".$padrao."'></font>".$arg."<br><br>\n");
}

function Radio($texto,$nome_var,$check,$padrao)
{
  echo("<font face=Verdana,Arial,Helvetica size=-1><input type='radio' name=".$nome_var." value='".$padrao."' ".$check."> $texto</font><br>\n");
}

function CargaContrasena($texto,$nome_var)
{
  echo("<font face=Verdana,Arial,Helvetica size=-1>$texto<br><input size='30' type=password name=".$nome_var."></font><br><br>\n");
}

/* *******************************************
   ConectarDB - Conecta a la base de datos pedida
   Entrada: $base - nombre de la base de datos
   Salida: socket del servidor de la base de datos, se ok.
          interrompe o código e envia alerta caso contrario
*/
function ConectarDB($base,$dbuser,$dbpassword)
{

  if (! $sock = mysql_connect('localhost',$dbuser,$dbpassword))
  {
    return -1;
  }
  else
  {
    if (! mysql_select_db($base, $sock))
    {
      return -1;
    }
    else
    {
      echo("</div>\n");
      return($sock);
    }
  }
}

function Enviar($sock, $query)
{
  if (!($ms = mysql_query($query, $sock)))
    return -1;
  else
    return($ms);
}

function Voltar($mensagem)
{
  echo("<p><font face=Verdana,Arial,Helvetica size=-1 color=red><b>\n");
  echo($mensagem);
  echo("\n<b></font></p>\n");
  echo("<form><input type=button value='Voltar' onClick=history.go(-1);></form>\n");
  echo("</body></html>\n");
  die;
}

function CrearBase($dbbasegeral,$celsius_login,$celsius_contrasena,$mysqlpath)
{

  $sock=ConectarDB($dbbasegeral,$celsius_login,$celsius_contrasena);

  if ($sock==-1)
    return -1;

 /* Agregado por gonzalo para probar desde abajo */
  $password = 'root';
  $str = $mysqlpath.'/mysql -uroot -p"'.$password.'" '.$dbbasegeral.' < .\celsius.sql';
//  c:\Archiv~1\Apache~1\Apache\htdocs\celsiu~1\instal~1\celsius.sql';
  $res = `$str`;
  return 1;
/* FIN Agregado por gonzalo para probar desde abajo */

  if ($fh=fopen("celsius.sql","r"))
  {
    $comando="";
    while (!feof($fh))
    {
      $linha=fgets($fh,1024);
      if ($linha[0]!="#")
      {
        $linha=eregi_replace("\n"," ",$linha);
        $linha=trim($linha);
        $comando .= $linha;

        if (eregi(";",$linha))
        {
          $comando=eregi_replace(";"," ",$comando);
          $comando=trim($comando);
          Enviar($sock,$comando);
          $comando ="";
        }
      }
    }
  }
  else {
	  echo "<b>El archivo celsius.sql no ha podido ser leido</b>";
    return -1;
  }
  mysql_close($sock);

  fclose($fh);
  return 0;
}



function CrearBaseAux($dbbasegeral,$celsius_login,$celsius_contrasena)
{

  $sock=ConectarDB($dbbasegeral,$celsius_login,$celsius_contrasena);

  if ($sock==-1)
    return -1;

  if ($fh=fopen("samb.sql","r"))
  {
    $comando="";
    while (!feof($fh))
    {
      $linha=fgets($fh,1024);
      if ($linha[0]!="#")
      {
        $linha=eregi_replace("\n"," ",$linha);
        $linha=trim($linha);
        $comando .= $linha;

        if (eregi(";",$linha))
        {
          $comando=eregi_replace(";"," ",$comando);
          $comando=trim($comando);
	  Enviar($sock,$comando);
          $comando ="";
        }
      }
    }
    }
    else
    return -1;

  mysql_close($sock);

  fclose($fh);
  return 0;
}



function CreaCelsiusConf($archivo,$dbbasegeral,$celsius_login,$celsius_contrasena,$tmpcelsius_login,$tmpcelsius_contrasena,$root_mysql_s,$root_mysql_contrasena_s,$ambiente,$raiz_www,$email_sitio,$titulo_sitio,$host)
{

   if (file_exists($archivo))
     unlink($archivo);
  
   
    $function_dbnamebase="function Devolver_Database(){return '".$dbbasegeral."';}\n";
    $function_dbuser="function Devolver_UsuarioCelsius(){return '".$celsius_login."';}\n";
    $function_mysql_usuario="function Devolver_Usuario(){return '".$root_mysql_s."';}\n";
    $function_mysql_contrasena="function Devolver_Clave(){ return '".$root_mysql_contrasena_s."';}\n";
    $function_celsius_contrasena="function Devolver_UsuarioClaveCelsius(){return '".$celsius_contrasena."';}\n";
    $function_destino="function Destino(){return '".$ambiente."';}\n";
    $function_puerto="function Devolver_Puerto(){return ':3306';}\n";
    $function_carpeta="function Carpeta(){return '".$raiz_www."';}\n";
    $function_servidor="function Devolver_Servidor(){return 'localhost';}\n";
    $function_email_sitio="function Destino_Mail(){return '".$email_sitio."';}\n";
    $function_titulo_sitio="function Titulo_Sitio(){return '".$titulo_sitio."';}\n";
    $function_maximo="function Maximo_Sesion(){return 3600;}\n";   
    $function_url="function Devolver_URL_completa(){return '".$host."';}\n";
    $function_conectan="function Celsius_se_Conecta(){return 0;}\n";

	$fh=@fopen($archivo,"w+");
   if ($fh)
    {
    fputs($fh,"<?\n");
    fputs($fh,$function_dbnamebase);
    fputs($fh,$function_dbuser);
    fputs($fh,$function_mysql_usuario);
    fputs($fh,$function_mysql_contrasena);
    fputs($fh,$function_destino);
    fputs($fh,$function_puerto);
    fputs($fh,$function_carpeta);
    fputs($fh,$function_servidor);
    fputs($fh,$function_email_sitio);
    fputs($fh,$function_titulo_sitio);
    fputs($fh,$function_maximo);
    fputs($fh,$function_url);
    fputs($fh,$function_conectan);
    fputs($fh,"?>");
    fclose($fh); 
	
    
  }
   //no se pudo crear el archivo (posible falta de permisos). Por lo tanto, creo un string con el texto que contendría el mismo y le sugiero al usuario que lo cree el mismo
if ((file_exists($archivo) && (filesize($archivo) > 0)) || (!file_exists($archivo))) //retorno 0 solo si el archivo fue creado y tiene algun contenido
  $str = "<?\n";
  $str .= $function_dbnamebase."\n";
  $str .= $function_dbuser."\n";
  $str .= $function_mysql_usuario."\n";
  $str .= $function_mysql_contrasena."\n";
  $str .= $function_destino."\n";
  $str .= $function_puerto."\n";
  $str .= $function_carpeta."\n";
  $str .= $function_servidor."\n";
  $str .= $function_email_sitio."\n";
  $str .= $function_titulo_sitio."\n";
  $str .= $function_maximo."\n";
  $str .= $function_url."\n";
  $str .= $function_conectan."\n";
  $str .= "?>";
  return $str;

    
  
}

function CrearDirectorio($diretorio)
{
  $r1=mkdir ($diretorio, 0777);
  $r2=chmod ($diretorio, 0777);
  return ($r1 & $r2);
}

function CompareRetornaArrayDiretorio($ar1, $ar2)
{
  if ($ar1['Diretorio']<$ar2['Diretorio'])
    return -1;
  else if ($ar1['Diretorio']>$ar2['Diretorio'])
    return 1;
  if ($ar1['Arquivo']<$ar2['Arquivo'])
    return -1;
  else if ($ar1['Arquivo']>$ar2['Arquivo'])
    return 1;
  return 0;
}

function RetornaArrayDiretorio($diretorio)
{
  /* Coloca a barra no final, se não tiver */
  $diretorio .="/";
  $diretorio = implode("/",explode("//",$diretorio));

  /* Prepara lista de arquivos */
  clearstatcache();
  unset ($lista);
  $fp=popen("find ".$diretorio." -follow","r");

  $cont=0;
  while($s = fgets($fp, 1024))
  {
    /* cortando carro de linha */
    $enter=explode("\n",$s);
    $s=$enter[0];

    $lista[$cont]['Caminho']=$s;
    $quebrando=explode($diretorio,$s);
    $relativo=$quebrando[1];
    if (is_dir($s))
    {
      $lista[$cont]['Diretorio']=$relativo;
      $lista[$cont]['Arquivo']="";
      $lista[$cont]['Tamanho']=0;
    }
    else
    {
      unset($dir);
      $partes=explode("/",$relativo);
      for ($c=0;$c<count($partes)-1;$c++)
      {
        $dir.=$partes[$c];
        if ($c<count($partes)-2)
          $dir .="/";
      }
      $lista[$cont]['Diretorio']=$dir;
      $lista[$cont]['Arquivo']=$partes[count($partes)-1];
      $lista[$cont]['Tamanho']=filesize($s);
    }
    $lista[$cont]['Data']=filemtime($s);
    $cont++;
  }
  if (count($lista)>0)
    uasort ($lista, CompareRetornaArrayDiretorio);
  return ($lista);
}

function EspalharArquivoAuth($ambiente)
{
   $lista=RetornaArrayDiretorio("..");
  
  foreach($lista as $cod=>$linha)
    if ($linha['Arquivo']==".auth")
    {
      $fh=fopen($linha['Caminho'],"w");
      fputs($fh,$ambiente."/");
      fclose($fh);
    }
}

function CriaLinkSimbolico($origem,$destino)
{
  symlink($origem,$destino);
}


?>
