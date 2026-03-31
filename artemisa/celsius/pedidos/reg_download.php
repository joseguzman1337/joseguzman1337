<? 
include_once "../inc/var.inc.php";
include_once "../inc/"."conexion.inc.php";  
include_once "../inc/"."parametros.inc.php";  
Conexion();
include_once "../inc/"."identif.php";
Administracion();
?> 
<html>
<head>
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><? echo Titulo_Sitio();?></title>
<style type="text/css">
<!--
body {
	background-color: #0099CC;
	margin-left: 10px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
-->
</style>
<link href="../celsius.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style19 {font-size: 11px; color: #FFFFFF; font-family: Verdana;}
-->
</style>
</head>
<? 
   include_once "../inc/"."fgenhist.php";
   include_once "../inc/"."fgentrad.php";
   global $IdiomaSitio;
   $Mensajes = Comienzo("dow-2",$IdiomaSitio);
   $Dia = date ("d");
   $Mes = date ("m");
   $Anio = date ("Y");
   $FechaHoy =$Anio."-".$Mes."-".$Dia;

    
    if (!isset($Paises))
    {
       $Paises = 0;       
    }
    
    if (!isset($Instituciones))
    {
      $Instituciones = 0;
    }
    
    if (!isset($Dependencias))
    {
      $Dependencias = 0;
    }
    
    $Paises=0;
    $Instituciones=0;
    $Dependencias=0;
    $Observaciones="";
    global $Id_Usuario;

?>

<body>
<table width="780" border="0" align="left" cellpadding="0" cellspacing="0" bordercolor="#111111" bgcolor="#E4E4E4" style="border-collapse: collapse">
  <tr>
    <td valign="top" bgcolor="#E4E4E4">
      <hr color="#E4E4E4" size="1">
      <span align="center">
      <center>
        <table width="760" border="0" bgcolor="#E4E4E4" style="border-collapse: collapse" bordercolor="#111111" cellpadding="2" cellspacing="3">
          <tr bgcolor="#E4E4E4">
            <td valign="top"> <span align="center">
              <center>
                <span align="center">                </span>
                <span align="center">                </span>
                <span align="center"><span align="center">
                </span></span>
                <span align="center"><span align="center">
</span></span>
                <table width="600" height="120" border="0" align="center" cellpadding="3" cellspacing="2" bgcolor="#F5F5F5">
                  <tr>
                    <td valign="middle"><div align="center">
                      <table  border="0" cellspacing="2" cellpadding="2">
                        <tr>
                          <td><img src="../images/absoluteftp48x.gif" width="48" height="48"></td>
                          <td><p align="center"><span class="style18"><span class="style2"><span class="style4">
						  	<?
       $query = "SELECT * from Pedidos where Id ='".$Id."'";
       $resu = mysql_query($query);
       echo mysql_error();
        if ($row = mysql_fetch_array($resu))
         {
   		  $cantArchivos = $row['Archivos_Totales'];
		 
		  $query2 = "SELECT codigo from Archivos_Pedidos where codigo_pedido = '".$Id."'";
		  $archivos = mysql_query($query2);
		  while ($archivo = mysql_fetch_row($archivos))
			 {$Id_Archivo = $archivo[0];
		 	 //registro el Download que se acaba de realizar. Se pone download_forzado en 1, para marcar que el download lo hizo un administrador para poner el pedido como download aunque el usuario no lo haya hecho
	        $query4 = "INSERT INTO Downloads (codigo_archivo,codigo_usuario,Fecha,IP_usuario,download_forzado) VALUES (".$Id_Archivo.",".$Id_usuario.",NOW(),'".$_SERVER['REMOTE_ADDR']."',1)";
        	 $resu = mysql_query($query4);
        	  echo mysql_error();

			  $query_upd = "UPDATE Archivos_Pedidos set Permitir_Download = 0 WHERE codigo=".$Id_Archivo;
			  $resu = mysql_query($query_upd);
			  echo mysql_error();
			 }
		    $query2 = "UPDATE Pedidos SET Estado=".Devolver_Estado_Download()." , Archivos_Bajados = Archivos_Totales  WHERE Id = '".$Id."'";
            $resu = mysql_query($query2);
             echo mysql_error();
			 Bajar_Historico($Id);
             echo $Mensajes["tc-001"];
   }
	else
	  echo $Mensajes['tc-004'];?>
					  
						  
</span></span></span></p>
                            <p><span class="style2"><a href="manpedent4.php"><? echo $Mensajes["tc-003"]; ?></a></span></p></td>
                        </tr>
                      </table>
                      </div>                      <div align="left" class="style7"></div></td>
                  </tr>
                </table>
                <span align="center"><span align="center">
</span></span>
              </center>
            </span> </td>
            <td valign="top" bgcolor="#E4E4E4"><div align="center">
              <table width="150"  border="0" bgcolor="#ececec">
                <tr>
                  <td height="20"><img src="../images/image001.jpg" width="150" height="118">
				  <a href="../admin/indexadm.php"><? echo $Mensajes["tc-002"]; ?></a>  
				  
				  </td>
                </tr>
              </table>
            </div></td>
          </tr>
        </table>
      </center>
    </span></td>
  </tr>
  
  <tr>
    <td height="44" bgcolor="#E4E4E4"> <font face="Arial">
      <center>
        <hr>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50">&nbsp;</td>
            <td><div align="center"><font face="Arial"><a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0><img border="0" src="../images/logo-prebi.jpg"></a></font></div></td>
            <td width="50"><div align="center" class="style17">
                <div align="right" class="style18">
                  <div align="center" class="style7">ini_001</div>
                </div>
            </div></td>
          </tr>
        </table>
        <a href='http://www.unlp.istec.org/prebi' target=_BLANK border=0> </a>
      </center>
    </font> </td>
  </tr>
</table>
<?  
	Desconectar();
?>
</body>
</html>
