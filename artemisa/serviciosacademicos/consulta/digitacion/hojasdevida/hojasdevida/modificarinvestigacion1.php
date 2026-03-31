<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update investigacion set  tituloinvestigacion = '".$_POST['tituloinvestigacion']."',institucioninvestigacion ='".$_POST['institucioninvestigacion']."',entidadfinanciamientoinvestigacion ='".$_POST['entidadfinanciamientoinvestigacion']."',unidadtiempoinvestigacion ='".$_POST['unidadtiempoinvestigacion']."',tiempoinvestigacion ='".$_POST['tiempoinvestigacion']."',liderinvestigacion ='".$_POST['liderinvestigacion']."',cantidadinvestigadores ='".$_POST['cantidadinvestigadores']."',codigotipoinvestigacion ='".$_POST['codigotipoinvestigacion']."' where  idinvestigacion = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5>Los datos han sido modificados.</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=investigacion.php'>";
?>