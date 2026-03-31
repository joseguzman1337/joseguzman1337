<?  //pagina para actualizacion de los datos personales de los usuarios
  include_once "../inc/var.inc.php";
  include_once "../inc/"."conexion.inc.php";
  Conexion();
  include_once "../inc/"."cache.inc";
  include_once "../inc/"."identif.php";
  Usuario();
  include_once "../inc/"."fgentrad.php";
  include_once "../inc/"."fgenped.php";
  global  $IdiomaSitio ;   
  $Mensajes = Comienzo ("uup-001",$IdiomaSitio);  
  $VectorIdioma = ObtenerVectorIdioma ($IdiomaSitio);
  

?>

<html>
  <head>
    <title><? echo Titulo_Sitio();?></title>
  </head>
  <body background="../imagenes/banda.jpg">
  
  <? if (isset($update) && ($update == 1))
      {
	$query="UPDATE Usuarios
	        SET Nombres='$Nombres',Apellido='$Apellido',EMail='$Mail'";
		if ($Direccion != '')
		  $query .= ",Direccion='$Direccion'";
		if ($Telefono != '')
		  $query .= ",Telefonos='$Telefono'";
		if ($Cargo != '')  
		  $query .= ",Cargo='$Cargo'";
		 
		if ($Paises != '')
		  $query .= ", Codigo_Pais=$Paises";
		if ($Instituciones != '')
		  $query .= ", Codigo_Institucion=$Instituciones";
		if ($Dependencias != '')
		  $query .= ", Codigo_Dependencia=$Dependencias";
		if ($Unidades != '')
		   $query .= ", Codigo_Unidad=$Unidades";
		if ($Categoria != '')
		   $query .= ", Codigo_Categoria=$Categoria";
        $query .= " WHERE Id = $Id_usuario";
	
	$resu = mysql_query($query);
        echo mysql_error();
	?>   	  	<br>
<div align="center">
  <center>
   	  	<table border="1" width="65%" bgcolor="#0099CC" height="158">
   	  	  <tr>
		    <td width="100%" height="78" bordercolorlight="#0099CC" bordercolordark="#0099CC">
      		<p align="center"><img border="0" src="../imagenes/fondo.jpg" width="303" height="79"></p>
    		</td>
  		  </tr>
          <tr>
		    <td width="100%" height="78" bordercolorlight="#0099CC" bordercolordark="#0099CC">
            <p align="center"><b><font face="MS Sans Serif" size="2" color="#FFFFCC"><? echo $Mensajes['tf-1']; ?></font></b>
    		</td>
          </tr>
   	  	  <tr>
		    <td width="100%" height="25" bordercolorlight="#0099CC" bordercolordark="#0099CC">
                    <p align="center"><font face="MS Sans Serif" size="1"><a href="sitiousuariologed.php"><font color="#FFFFCC"><? echo $Mensajes['h-1']; ?></font></a></font>
    		</td>
  		  </tr>
   	  	</table>
  </center>
</div>
	      
      <? }
  ?>
  <P ALIGN="center"><FONT FACE="MS Sans Serif" SIZE="1"><FONT COLOR="#000080">cp:</FONT>uup-001</FONT></P>

  </body>
