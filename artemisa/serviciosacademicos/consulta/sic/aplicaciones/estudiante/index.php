<?php

session_start();
	/*if($_GET["entrada"])
		echo "<H1>ENTRO 1</H1>";		
	else
		echo "<H1>ENTRO 2</H1>";		*/

//if(isset($_GET["listado"])&&trim($_GET["listado"])!='')
   $_SESSION["sissic_idestudiantegeneral"]=$_GET["idusuario"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Servicios Academicos</title>
<?php
if(!isset($_SESSION["sissic_idestudiantegeneral"])){
    //print_r($_SESSION);
    //print_r($_REQUEST);
    $_SESSION["sissic_idestudiantegeneral"] = $_SESSION['sesion_idestudiantegeneral'];
    //exit();
//echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresodocente.php'>";
}
/*else
    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=../../../index.php'>";*/
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">
        var lateral = window.parent.frames[1].name;
	//alert(window.document.location+" - "+window.parent.document.location+" - ");
        window.parent.document.getElementById("frameMovible").cols="0%,100%"
        window.parent.frames[1].cols="0";
        //alert(lateral);
function continuar(){
	<?php 
	if($_GET["entrada"])
		echo "window.parent.continuar();";		
	else{
		//echo "alert('Entro en continuar index');";
		echo "window.parent.document.getElementById('frameMovible').cols='240,*';";
		//echo "window.parent.frames[1].cols='0'";
		echo "window.location.href='../../../facultades/creacionestudiante/estudiante.php'";
	}
	?>
}

</script>
</head>
<frameset onunload="" name="principalestudiante" id="principalestudiante" rows="25,*" cols="*" frameborder="no" border="0" framespacing="1">
  <frame name="marcosuperior" id="marcosuperior" src="<?php echo "encabezado.php?listado=".$_GET["listado"] ?>"  scrolling="no" noresize>

 <frameset name="frameMovible" id="marcoinferior" rows="*" cols="200,*" framespacing="0" scrolling="no" frameborder="no" border="0" >
    <frame name="marcoizquierdo" id="marcoizquierdo" src="creararbolsic.php"  scrolling="yes" border="0"  >
    <frame name="marcocentral" id="marcocentral" src="central.php"  framespacing="0" frameborder="no" border="0" scrolling="auto">
  </frameset>
</frameset>
<noframes><body>
</body></noframes>
</html>
