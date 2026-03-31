<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update condecoracion set  nombrecondecoracion = '".$_POST['nombrecondecoracion']."',institucioncondecoracion ='".$_POST['institucioncondecoracion']."',fechacondecoracion ='".date("Y-m-d",mktime(0,0,0,$_POST['mes'],$_POST['dia'],$_POST['ano']))."',codigotipocondecoracion ='".$_POST['codigotipocondecoracion']."' where  idcondecoracion = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=condecoracion.php'>";
?>