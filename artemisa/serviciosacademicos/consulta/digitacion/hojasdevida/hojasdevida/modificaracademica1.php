<?php require_once('../../../../Connections/conexion.php');session_start();

 $fecha = $_POST['fgrado']; 
 echo $base= "update historialacademico set  
	 tituloobtenidohistorialacademico='".$_POST['tituloobtenidohistorialacademico']."',
	 institucionhistorialacademico='".$_POST['institucionhistorialacademico']."',
	 lugarhistorialacademico='".$_POST['lugarhistorialacademico']."',
	 fechagradohistorialacademico='".$_POST['fgrado']."',
	 codigotipogrado='".$_POST['codigotipogrado']."',
	 codigoprogramasnieshistorialacademico='".$_POST['codigoprograma']."',
	 codigonbcsnies= '".$_POST['codigonbcsnies']."',
	 codigopais='".$_POST['codigopais']."',
	 puntajeecaeshistorialacademico='".$_POST['puntajeecaes']."',
	 fechaecaeshistorialacademico='".$_POST['fechaecaes']."'
	  where  idhistorialacademico = '".$_POST['modificar']."'";
 $sol=mysql_db_query($database_conexion,$base);
 echo "<h5>Datos Modificados</h5>";
 echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=academica.php'>";
?>