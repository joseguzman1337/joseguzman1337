<?php
session_start();
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
//exit();


if(isset($_GET["listado"])&&trim($_GET["listado"])!='')
	$_SESSION["sissic_numerodocumentodocente"]=$_GET["idusuario"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Servicios Academicos</title>
<?php
if(!isset($_SESSION["sissic_numerodocumentodocente"])){
    if(isset($_SESSION["numerodocumento"])) {
        $_SESSION["sissic_numerodocumentodocente"] = $_SESSION["numerodocumento"];
    }
    else
        echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=ingresodocente.php'>";
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript" src="../../../../funciones/sala_genericas/ajax/requestxml.js"></script>
<script type="text/javascript">
        var lateral = window.parent.frames[1].name;
        window.parent.document.getElementById("frameMovible").cols="0%,100%"
        window.parent.frames[1].cols="0";
        //alert(lateral);
function continuar(){
var filetabla="validaformulariosdocente.php";
var params="numerodocumento=<?php echo  $_SESSION["sissic_numerodocumentodocente"]; ?>";

process(filetabla,params);
setTimeout("validaContinua()",1000);

	
}
function validaContinua(){
	var arrayverificacion=ArregloXMLObj("continua");
//alert(xmlHttp2.responseText);
	if(arrayverificacion[0]=="SI")
	{
		alert('Puede continuar');
		window.parent.continuar();
		
	}
	else
	{
		alert("Es necesario que todos los formularios sean diligenciados o revisados para poder continuar\n (El estado de cada opcion debe quedar con el color amarillo)");
	}
}

</script>
</head>
<frameset onunload="" name="principal" id="principal" rows="25,*" cols="*" frameborder="no" border="0" framespacing="1">
  <frame name="marcosuperior" id="marcosuperior" src="<?php echo "encabezado.php?entrada=".$_GET['entrada']."&listado=".$_GET["listado"] ?>"  scrolling="no" noresize>
 
 <frameset name="frameMovible" id="frameMovible" rows="*" cols="200,*" framespacing="0" scrolling="no" frameborder="no" border="0" >
    <frame name="marcoizquierdo" id="marcoizquierdo" src="creararbolsic.php"  scrolling="yes" border="0"  >
    <frame name="marcocentral" id="marcocentral" src="central.php"  framespacing="0" frameborder="no" border="0" scrolling="auto">
  </frameset>
</frameset>
<noframes><body>
</body></noframes>
</html>
