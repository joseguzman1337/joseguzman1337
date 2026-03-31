<?php require_once('../../../../Connections/conexion.php');session_start();

 $fecha = $_POST['fgrado']; 
 echo $base= "update capacitacion set  
	 tituloobtenidocapacitacion='".$_POST['tituloobtenidocapacitacion']."',
	 codigopais='".$_POST['codigopais']."',
	 periodocapacitacion='".$_POST['periodocapacitacion']."',
	 aniocapacitacion='".$_POST['aniocapacitacion']."',
	 codigotipocapacitacion='".$_POST['codigotipocapacitacion']."',
	 codigotipofinanciacion='".$_POST['codigotipofinanciacion']."',
	 codigotipogrado='".$_POST['codigotipogrado']."'
	  where  idcapacitacion = '".$_POST['idcapacitacion']."'";
 $sol=mysql_db_query($database_conexion,$base);
 echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=capacitacion.php'>";
?>