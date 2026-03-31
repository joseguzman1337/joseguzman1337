<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
$fecha=
 $base= "update membresia set  nombremembresia = '".$_POST['nombremembresia']."',fechamembresia = '".date("Y-m-d",mktime(0,0,0,$_POST['mes'],$_POST['dia'],$_POST['ano']))."' where  idmembresia = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5><font size='2' face='Tahoma'><strong>Los datos han sido modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=membresia.php'>";
?>