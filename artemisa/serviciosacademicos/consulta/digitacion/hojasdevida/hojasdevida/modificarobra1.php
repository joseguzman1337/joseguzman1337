<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update autoria set  nombreautoria = '".$_POST['nombreautoria']."',fechaautoria ='".date("Y-m-d",mktime(0,0,0,$_POST['mes'],$_POST['dia'],$_POST['ano']))."',referenciaautoria ='".$_POST['referenciaautoria']."',codigotipoautoria ='".$_POST['codigotipoautoria']."' where  idautoria = '".$_POST['modificar']."'";
 $sol=mysql_db_query($database_conexion,$base);
 echo "<h5><font size='2' face='Tahoma'><strong>Los datos han sido modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=obra.php'>";
?>