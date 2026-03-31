<?php require_once('../../../../Connections/conexion.php');session_start();?>
<?php
 $base= "update lengua set  codigoidioma = '".$_POST['codigoidioma']."',hablalengua ='".$_POST['hablalengua']."',leelengua ='".$_POST['leelengua']."',escribelengua ='".$_POST['escribelengua']."' where  idlengua = '".$_POST['modificar']."'";
 $sol=mysql_db_query("hojavida",$base);
 echo "<h5><font size='2' face='Tahoma'><strong>Los datos han sido modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=idioma.php'>";
?>