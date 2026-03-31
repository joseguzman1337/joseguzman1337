<? 
 
include_once "../inc/"."conexion.inc.php";  
 Conexion();
include_once "../inc/var.inc.php";
 include_once "../inc/"."identif.php";
 Administracion();
 	
?> 

<html>

<head>
<title><? echo Titulo_Sitio();?></title>
</head>

<body>
<? 
   include_once "../inc/"."fgenhist.php";
   include_once "../inc/"."fgentrad.php";
     global $IdiomaSitio;
   $Mensajes = Comienzo ("dow-2",$IdiomaSitio);
  
  
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
    global $Id_usuario;

?>
<div align="center">
  <center>
<table border="0" width="65%" bgcolor="#006699">
  <tr>
    <td width="100%" align="center" colspan="2"><font face="MS Sans Serif" size="1" color="#FFFF00">
	<?
       $query = "SELECT Id,Archivos_Totales from Pedidos where Estado = ".Devolver_Estado_SolicitarPDF()." and Codigo_Usuario =".$User;

       $resu = mysql_query($query);
       echo mysql_error();
	   $cantPed = mysql_num_rows($resu);
        while ($row = mysql_fetch_array($resu))
         {
		  $Id = $row['Id']; //recorro todos los pedidos del usuario
   		  $cantArchivos = $row['Archivos_Totales'];
		  $query2 = "SELECT codigo from Archivos_Pedidos where codigo_pedido = '".$Id."'";
		  $archivos = mysql_query($query2);
		  
		  while ($archivo = mysql_fetch_row($archivos))
			 {
			  $Id_Archivo = $archivo[0];

		 	 //registro el Download que se acaba de realizar. Se pone download_forzado en 1, para marcar que el download lo hizo un administrador para poner el pedido como download aunque el usuario no lo haya hecho
	        $query4 = "INSERT INTO Downloads (codigo_archivo,codigo_usuario,Fecha,IP_usuario,download_forzado) VALUES (".$Id_Archivo.",".$Id_usuario.",NOW(),'".$_SERVER['REMOTE_ADDR']."',1)";
        	 $result = mysql_query($query4);
        	  echo mysql_error();

			  $query_upd = "UPDATE Archivos_Pedidos set Permitir_Download = 0 WHERE codigo=".$Id_Archivo;
			  $resultado = mysql_query($query_upd);
			  echo mysql_error();
			 }
		    $query2 = "UPDATE Pedidos SET Archivos_Bajados = Archivos_Totales  WHERE Id = '".$Id."'";
            $res = mysql_query($query2);
             echo mysql_error();
			 Bajar_Historico($Id);
        }
     if($cantPed==1)
	    echo $cantPed." ".$Mensajes["tc-005"]."</font></td>";
     elseif ($cantPed > 1)
	     echo $cantPed." ".$Mensajes["tc-006"]."</font></td>";
		 else
		   echo $Mensajes["tc-007"];
	 ?>
  </tr>
  <tr>
    <td width="50%" align="center">&nbsp;</td>
    <td width="50%" align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="50%" align="center"><font face="MS Sans Serif" size="1">
    
       <a href="manpedent4.php"> <font color="#FFFFFF"><? echo $Mensajes["tc-003"]; ?> </font></a>
             
    </font></td>
    <td width="50%" align="center">
    <font face="MS Sans Serif" size="1">

      <a href="../admin/indexadm.php"><font color="#FFFFFF"><? echo $Mensajes["tc-002"]; ?></font></a>   

    </font></td>
  </tr>
  </table>
  </center>
</div>

<P ALIGN="center"><img border="0" src="../imagenes/rueda.jpg">
<br>
<?  
	Desconectar();
?>
<P ALIGN="center">
<FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>dow-2</FONT>

</body>

</html>
















