<?


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

  echo("<body text=#000000 bgcolor=#FFFFFF link=#0000FF vlink=#0000FF ALINK=#0000FF background='imagenes/banda.jpg'>\n");
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

function AbrirFormularioFinal()
{
  global $fase_g;
  $fase=$fase_g;
  echo("<form action='../index.php'>\n");
}

function Parrafo($texto)
{
  echo("<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font face=Verdana,Arial,Helvetica size=-1>\n");
  echo($texto);
  echo("\n</font></p>\n");
}

function EncerrarPagina($titulo)
{
  echo("<br><hr><br><br><input type=submit value=".$titulo.">\n");
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

function CrearBase($dbbasegeral,$celsius_login,$celsius_contrasena)
{

  $sock=ConectarDB($dbbasegeral,$celsius_login,$celsius_contrasena);

  if ($sock==-1)
    return -1;
         $filename = "celsius.sql";
	  	$fpt = fopen($filename,"r");
	  	if (!$fpt) {
	  	echo "Error al acceder al archivo";
	  	exit;}
        //mysql_connect($server,$username,$password);
        //mysql_create_db('GonzaloBorrable');
        //$pt = mysql_select_db('GonzaloBorrable'); 
	  	$str = "";
	  	while (!feof($fpt)) {
	  	   $car = fread($fpt,1);
	  	   if ($car == '#') {
	  	   	if ($str != "")
  		  	   	  $link = mysql_query($str);
	  	   	  echo "<h3>".mysql_error()."</h3>";
	  	   	  $str = "";
	  	   	  
	  	   }
	  	   else {
	  	   	   /*if ($car == ";")
	  	   	      $car = "";*/
	  	     $str .= "$car";
	  	   }
	  	}

		$restart_counter = "UPDATE Instituciones SET Codigo_Pedidos = 0";
		$link = mysql_query($restart_counter);
		echo "<h3>".mysql_error()."</h3>";
		

/*    if ($fh=fopen("celsius.sql","r"))
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
*/
  fclose($fpt); 
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


function CreaCelsiusDir($archivo,$directorio)
 {
  if (file_exists($archivo));
    { $var=unlink($archivo);}
  
  $fh=fopen($archivo,"a+");   
  if ($fh)
  {
    $directorio.="/";
    $function_param1="if (__Parametros_inc == 1)return;\n";
    $function_param2="define ('__Parametros_inc', 1);\n";
    $function_direccion="function Obtener_Direccion($"."opcion = 1){return '".$directorio."';}";
    fputs($fh,"<?\n");
    fputs($fh,$function_param1);
    fputs($fh,$function_param2);
    fputs($fh,$function_direccion);
    fputs($fh,"?>");  
  }
  else
    return -1;
 
 fclose($fh);  
  return 0;
 
 }
function CreaCelsiusConf($archivo,$dbbasegeral,$celsius_login,$celsius_contrasena,$tmpcelsius_login,$tmpcelsius_contrasena,$root_mysql_s,$root_mysql_contrasena_s,$ambiente,$raiz_www,$email_sitio,$titulo_sitio,$host)
{

  
  if (file_exists($archivo));
    { $var=@unlink($archivo);}

    $function_dbnamebase="function Devolver_Database(){return '".$dbbasegeral."';}\n";
    $function_dbuser="function Devolver_UsuarioCelsius(){return '".$celsius_login."';}\n";
    $function_mysql_usuario="function Devolver_Usuario(){return '".$root_mysql_s."';}\n";
    $function_mysql_contrasena="function Devolver_Clave(){ return '".$root_mysql_contrasena_s."';}\n";
    $function_celsius_contrasena="function Devolver_UsuarioClaveCelsius(){return '".$celsius_contrasena."';}\n";
    $function_destino="function Destino(){return '".$ambiente."';}\n";
    $function_puerto="function Devolver_Puerto(){return ':3306';}\n";
    $function_carpeta="function Carpeta(){return '".$raiz_www."';}\n";
    $function_servidor="function Devolver_Servidor(){return 'localhost';}\n";
    $function_param1="if (__Parametros_inc == 1)return;\n";
    $function_param2="define ('__Parametros_inc', 1);\n";
    $function_email_sitio="function Destino_Mail(){return '".$email_sitio."';}\n";
    $function_titulo_sitio="function Titulo_Sitio(){return '".$titulo_sitio."';}\n";
    $function_maximo="function Maximo_Sesion(){return 3600;}\n";   
    $function_url="function Devolver_URL_completa(){return '".$host."';}\n";
    $function_conectan="function Celsius_se_Conecta(){return 0;}\n";

  $fh=@fopen($archivo,"a+");   
  if ($fh)
  {
 

    fputs($fh,"<?\n");
  //  fputs($fh,$function_param1);
  //  fputs($fh,$function_param2);
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
	$retorno = "";
  }
  else {
//    $retorno = "<hr> No se pudo crear el archivo parametros.inc.php, posiblemente porque el servidor web no tiene privilegios sobre la carpeta inc. Dicho archivo deberá ser generado manualmente, y guardado en la carpeta inc dentro del directorio Celsius. El contenido del archivo deberá ser: <br> <textarea>";
//    $retorno =  $function_param1."\n";
//	$retorno .= $function_param2."\n";
	$retorno .= $function_dbnamebase."\n";
	$retorno .= $function_dbuser."\n";
	$retorno .= $function_mysql_usuario."\n";
	$retorno .= $function_mysql_contrasena."\n";
	$retorno .= $function_destino."\n";
	$retorno .= $function_carpeta."\n";
	$retorno .= $function_puerto."\n";
	$retorno .= $function_servidor."\n";
	$retorno .= $function_email_sitio."\n";
	$retorno .= $function_titulo_sitio."\n";
	$retorno .= $function_maximo."\n";
    $retorno .= $function_url."\n";
    $retorno .= $function_conectan."\n";
    
  }
  
 

  return $retorno;
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
