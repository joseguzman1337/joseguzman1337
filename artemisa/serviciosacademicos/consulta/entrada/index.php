<?php
session_start();
$rutaado=("../../funciones/adodb/");

require_once("../../Connections/salaado-pear.php");
require_once("../../funciones/sala_genericas/clasebasesdedatosgeneral.php");
require_once("../../funciones/sala_genericas/FuncionesCadena.php");
require_once("../../funciones/sala_genericas/FuncionesFecha.php");
require_once("../../funciones/clases/formulario/clase_formulario.php");
require_once("../../funciones/sala_genericas/formulariobaseestudiante.php");
unset($_SESSION['tmptipovotante']);
$fechahoy=date("Y-m-d H:i:s");
//$formulario=new formulariobaseestudiante($sala,'form1','post','','true');
$objetobase=new BaseDeDatosGeneral($sala);
//$datosusuario=$formulario->datos_usuario();

/*echo "_SESSION<pre>";
print_r($datosusuario);
echo "</pre>";*/
$tablas="usuario u left join estudiantegeneral eg on eg.numerodocumento=u.numerodocumento
left join docente d on d.numerodocumento=u.numerodocumento";

$datosusuariocompleto=$objetobase->recuperar_datos_tabla($tablas,"u.idusuario",$_SESSION["idusuariofinalentradaentrada"],""," , u.numerodocumento numerodocumentofinal, eg.idestudiantegeneral idestudiantegeneralfinal, d.iddocente iddocentefinal",0);

$_SESSION["redireccionentrada"]=str_replace("<idestudiantegeneral>",$datosusuariocompleto["idestudiantegeneralfinal"],$_SESSION["redireccionentrada"]);

$_SESSION["redireccionentrada"]=str_replace("<numerodocumento>",$datosusuariocompleto["numerodocumentofinal"],$_SESSION["redireccionentrada"]);

$_SESSION["redireccionentrada"]=str_replace("<iddocente>",$datosusuariocompleto["iddocentefinal"],$_SESSION["redireccionentrada"]);

if($datosusuariocompleto["codigotipousuario"]=="500")
{
$_SESSION["direccionposteriorentrada"]="../".$_SESSION["direccionposteriorentrada"];
}
/*if($datosusuariocompleto["codigotipousuario"]=="400")
{
$_SESSION["direccionposteriorentrada"]="../facultades/".$_SESSION["direccionposteriorentrada"];
}*/

//echo '<pre>',print_r($_SESSION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<title>Servicios Academicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script type="text/javascript">


// self executing function here
(function() {
   // your page initialization code here
   // the DOM will be available here

//console.log("<?PHP echo $_SESSION["redireccionentrada"]?>");
if(window.parent.name== "contenidocentral"){
//console.log(window.parent.frames.document.getElementById("marcosuperior"));
//console.log(window.parent.frames[0]);
window.parent.parent.document.getElementById("frameMovible").cols="0%,100%"
        window.parent.parent.frames[1].cols="0";
window.parent.parent.frames[2].document.getElementById("marcosuperior").src = "<?PHP echo $_SESSION["redireccionentrada"]?>";
window.close();

} else {
        var lateral = window.parent.frames[1].name;
        window.parent.document.getElementById("frameMovible").cols="0%,100%"
        window.parent.frames[1].cols="0";
}


})();


function continuar(){
        var lateral = window.parent.frames[1].name;
        window.parent.document.getElementById("frameMovible").cols="240,*";
        window.parent.frames[1].cols="0";

window.location.href=window.location.href.replace('index.php','')+'<?php echo $_SESSION["direccionposteriorentrada"]; ?>';
}

function continuar2(location){
//alert(window.parent.frames[1].location);
        var lateral = window.parent.frames[1].name;
        window.parent.document.getElementById("frameMovible").cols="240,*";
        window.parent.frames[1].cols="0";
window.location.href=location;

//window.location.href=window.location.href.replace('index.php','')+'<?php echo $_SESSION["direccionposteriorentrada"]; ?>';
}

function continuar3(){
//alert(window.parent.frames[1].location);
        var lateral = window.parent.frames[1].name;
        window.parent.document.getElementById("frameMovible").cols="240,*";
        window.parent.frames[1].cols="0";
//alert(window.location.href);

window.location.href=window.location.href.replace('entrada/index.php','')+'<?php echo $_SESSION["direccionposteriorentrada"]; ?>';
}

function salir(){
//alert(window.parent.frames[1].location);
window.location.href='http://<?php echo $_SERVER['SERVER_NAME'];?>' ;
}

</script>
<?PHP //echo $_SESSION["redireccionentrada"].'xxxxxxxxxxxxxxxxxxxxxxxxxxx'?>
</head>
<frameset onunload="" name="principal" id="principal" rows="100" cols="*" frameborder="no" border="0" framespacing="1">
  <frame name="marcosuperior" id="marcosuperior" src="<?PHP echo $_SESSION["redireccionentrada"]; ?>"  scrolling="yes" noresize> 
 </frameset>
<noframes><body>
</body></noframes>
</html>