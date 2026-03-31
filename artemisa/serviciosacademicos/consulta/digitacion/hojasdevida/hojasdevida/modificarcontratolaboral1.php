<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
	 $fecha = $_POST['finicio']; 
	 $fecha2= $_POST['ffinal']; 
	 $base= "update contratolaboral set  numerocontratolaboral = '".$_POST['numerocontratolaboral']."',codigoperiodoacademico ='".$_POST['codigoperiodoacademico']."',fechainiciocontratolaboral ='".$fecha."',fechafinalcontratolaboral ='".$fecha2."',codigotipocontrato ='".$_POST['codigotipocontrato']."',codigoestadotipocontrato ='".$_POST['codigoestadotipocontrato']."' where  idcontratolaboral = '".$_POST['modificar']."'";
	 $sol=mysql_db_query($database_conexion,$base);
	 echo "<h5>Datos Modificados</h5>";
	 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=contratolaboral.php'>";
?>
