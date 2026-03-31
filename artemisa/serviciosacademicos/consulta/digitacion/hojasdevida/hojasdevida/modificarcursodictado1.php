<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update cursoinformaldictado set  institucioncursoinformaldictado = '".$_POST['institucioncursoinformaldictado']."',areacursoinformaldictado ='".$_POST['areacursoinformaldictado']."',nombrecursoinformaldictado ='".$_POST['nombrecursoinformaldictado']."',unidadtiempocursoinformaldictado ='".$_POST['unidadtiempocursoinformaldictado']."',tiempocursoinformaldictado ='".$_POST['tiempocursoinformaldictado']."',fechacursoinformaldictado ='".date("Y-m-d",mktime(0,0,0,$_POST['mes'],$_POST['dia'],$_POST['ano']))."',lugarcursoinformaldictado ='".$_POST['lugarcursoinformaldictado']."',codigotipocursodictado ='".$_POST['codigotipocursodictado']."',tipoeventocursoinformaldictado='".$_POST['tipoeventocursoinformaldictado']."' where  idcursoinformaldictado = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5>Los datos han sido modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=cursodictado.php'>";
?>