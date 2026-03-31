<?
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";  
  Conexion();
  include_once "../inc/"."identif.php"; 
  Administracion();
  include_once "../inc/"."parametros.inc.php";
  include_once "../inc/"."funcarch.php";
  include_once "../inc/"."pclzip.lib.php";
  global $IdiomaSitio;
  $Mensajes = Comienzo ("bk-001",$IdiomaSitio);
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  set_time_limit(0);
  function file_init($name)
  {
   if (file_exists($name))
   { 
    unlink($name);
   }
   $arch = fopen($name,"w");
   return ($arch);
  }

   function add_line($archivo,$insert)
   {
   $retorno = fwrite($archivo,$insert."\r\n");
   return $retorno;
   }


	function armar_CREATE_TABLA($db , $tabla, $archivo) {
		$resultado = mysql_query("SHOW CREATE TABLE ".$tabla);
		$row=  mysql_fetch_array($resultado);
		$cadena= $row["Create Table"];
		add_line($archivo,$cadena);
		return $cadena;
	
	}

	function armar_INSERT_TABLA($db , $tabla, $archivo) {
	
		$local_query  = 'SELECT * FROM ' .$db.'.'.$tabla;
		$resultado_contenido_tabla = mysql_query($local_query);	
		$fields = mysql_list_fields($db, $tabla);
		$esquema_insert = "INSERT INTO ".$db.".".$tabla."  (" ;
		$cantidad_campos  = mysql_num_fields($fields);
        for ($i = 0 ; $i < $cantidad_campos ; $i++){
			$campo  = mysql_field_name($resultado_contenido_tabla , $i);	
			$esquema_insert.= $campo;
			if ($i < ($cantidad_campos - 1)) {
						$esquema_insert.=' , ';
				}
		}
		$esquema_insert.= ' ) VALUES ( '; 
		$cadena= "";
		while ($row = mysql_fetch_array($resultado_contenido_tabla )){
				
				$cadena = $esquema_insert;
				for ($i = 0 ; $i < $cantidad_campos ; $i++){ 
							//Tendria que reemplazar los valores
						$cadena.= ' `'.str_replace('`','&#96;',$row[$i]).'`';
						
						if ($i < ($cantidad_campos-1)) { 
								$cadena.=' , ';
							}
							
					}
				$cadena.= ' ); ' .'\\r\\n';
    			add_line($archivo,$cadena);
			}
        mysql_free_result($resultado_contenido_tabla); 
		return "";
	}



function armar_INSERT_TABLAS($db,$archivo){
//	"Armo los insert de cada tabla"

	$show_table = 'SHOW TABLES FROM '.$db;
	$resultado_tablas = mysql_query($show_table);
	$num_tables = mysql_num_rows($resultado_tablas);
	$consulta="";

	 
	while ($row = mysql_fetch_row($resultado_tablas)) {
			$tabla = $row[0];
			$consulta = armar_CREATE_TABLA($db , $tabla, $archivo);			 
			$consulta = armar_INSERT_TABLA($db , $tabla, $archivo);			
		
		}

	return $consulta;
	}

function armar_DROP($db,$archivo){
	//	"Borra la bd si existe"
	
	$drop_query ="DROP DATABASE ".$db.';'."\\r\\n";	
	add_line($archivo,$drop_query);
	return $drop_query ;
	}




function armar_CREATE($db,$archivo){
	//	"Crea la bd "
	
	$create_query = 'CREATE DATABASE '.$db.';'."\\r\\n" ;	
	add_line($archivo,$create_query);
	return $create_query ;
	
	}

function file_end($archivo,$filename,$db)
{ global $Mensajes;
  fclose($archivo);
  $texto= "
  
  <table width='95%' align='center'><tr>
	 <td width='100%' align='center'>
	  <embed src='../images/simple_countdown.swf' menu='false' quality='high' background='../images/banda.jpg' type='application/x-shockwave-flash'>
		</embed>
	</td>
  </tr>
  <tr>
  <td width='100%' align='center'>
	  <b><font face='MS Sans Serif' size='2' color='#000000'>".$Mensajes["tit-1"]." </font>
	  <br>
	  <img src='../images/diskette.gif'>
	  </b><font face='MS Sans Serif' color='#000000' size='2'>".$Mensajes["tit-2"]."
   </font> </td>
  </tr>

  <form name=form1 method=post action=backup_base.php> <input type=hidden name=db value='".$db."'> <input type=hidden name=filename value='".$filename."'> <input type=hidden name=paso2 value=1> </form> 
  ";
//echo $texto."dd";
	armarhtml($texto);
  
}








function armarhtml($texto){
	
  global $IdiomaSitio;

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
.style7 {color: #2D6FAC; font-size: 10px; }
.style11 {color: #006699; font-family: Arial, Helvetica, sans-serif; font-size: 11px; }
.style14 {
	font-size: 11px;
	font-family: Verdana;
	color: #FFFFFF;
}
.style15 {color: #006599}
.style17 {
	font-size: 11px;
	font-family: Verdana;
	color: #000000;
}
.style18 {color: #006699}
.style20 {color: #E4E4E4}
.style23 {font-size: 11}
.style26 {color: #006699; font-weight: bold; }
.style28 {font-size: 11px}
-->
</style>
<base target="_self">
	<script>
	function start() { document.forms.form1.submit(); } 
	</script> 
</head>


<body  topmargin="0" onload='start();'>
<div align="left">
  
  <table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
        <center>
          <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="0" cellspacing="5">
      <tr bgcolor="#E4E4E4">
        <td valign="top" bgcolor="#E4E4E4">
            <span align="center">
              <center>
                <table width="97%" border="0" style="margin-bottom: 0; border-collapse:collapse" bordercolor="#111111" cellpadding="0" cellspacing="0">
              <tr>
                <td class="style17" align=left><blockquote>
                         <p class="style17 style28">
						 <? echo $texto?>

						 </p>
                            </p>
                  </blockquote></td>
              </tr>
            </table>
              </center>
            </span>            </td>
       
        </tr>
    </table>    </center>    </td>
  </tr>
  <tr>
    <td height="44" bgcolor="#E4E4E4">
     <font face="Arial">
      <center> 
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="../images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
              <div align="right" class="style18">
                <div align="center">bk-001</div>
              </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0>
        </a>  
      </center>
     </font>
    </td>
  </tr>
</table>
</div>
</body>
</html>

<?

}










/* --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- 
*/





if (isset($paso2) &&($paso2 == 1))
{

  $straux = str_replace("/","//",devolverDirectorioArchivos());

  if ($straux == devolverDirectorioArchivos())
     $straux = str_replace('\\',"\\\\",devolverDirectorioArchivos());
   if (file_exists($straux.'//backup_'.$db.'_'.date('Ymd').'.zip'))
	{
      unlink($straux.'//backup_'.$db.'_'.date('Ymd').'.zip');
	}

  $zip= new PclZip($straux.'//backup_'.$db.'_'.date('Ymd').'.zip'); 
  $total =  $zip->create($filename);
  @unlink($filename); 
  
  $filename = devolverDirectorioArchivos().'//backup_'.$db.'_'.date('Ymd').'.zip';
  $filesize = filesize($filename);
  //echo $filename;
  header("Content-type: application/zip");
  header("Accept-Ranges: bytes");
  header("Content-Disposition:attachment; filename=backup_".$db."_".date('Ymd').".zip"); 
  @readfile($filename);
  @unlink($filename);


}
elseif ( (isset($paso1)) && $paso1 == 1)
{

$db= Devolver_Database(); 
$filename = 'backup_'.$db.'_'.date('Ymd').'.sql';
$name = devolverDirectorioArchivos()."/".$filename;
$archivo = file_init($name); //armo el nombre del archivo: backup_NombreBD_fecha
//$drop	= armar_DROP($db,$archivo);  
//$create	= armar_CREATE($db,$archivo); 
//$inserts	= armar_INSERT_TABLAS($db,$archivo); 
file_end($archivo,$name,$db);
}
else {


							$texto="
							
							
							  <table width='95%' align='center'> <tr>
								 <td width='100%' align='center'>
								 <embed src='../images/simple_countdown.swf' menu='false' quality='high' background='../images/banda.jpg' type='application/x-shockwave-flash'>
									</embed>
								</td>
							  </tr>
							 <tr>
							  <td width='100%' align='center'>
								  <b><font face='MS Sans Serif' size='2' color='#000000'>".$Mensajes["tit-1"]." </font></b>

							   </font> </td>
							  </tr>
							  
							<form name='form1' method='post' action='backup_base.php'> <input type=hidden name=paso1 value=1> </form>
							";
							armarhtml($texto);




}

?>