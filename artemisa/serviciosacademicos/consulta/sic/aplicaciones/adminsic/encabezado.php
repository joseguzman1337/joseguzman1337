<?php 
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<Form>
<head>
<link rel="stylesheet" type="text/css" href="../../../../estilos/sala.css">
<script type="text/javascript">
function save(){
//alert(window.parent.frames[1].location);
window.parent.frames[1].saveMyTree();
}
function nuevo(){
//alert(window.parent.frames[2].location);
window.parent.frames[2].location.href="formularioitem.php";
//window.parent.frames[1].saveMyTree();
}

</script>

<title>Servicios Académicos</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body  bgcolor="" leftmargin="0"  marginwidth="0" marginheight="0"  topmargin="0">

<table align="center" width="100%" bgcolor="#FFF6DC" height="40" ><TR ><TD align="center" id='tdtituloencuesta' valign="top" height="23">SISTEMA DE INFORMACION DE CALIDAD DE LA UNIVERSIDAD EL BOSQUE</TD></TR>
<TR bgcolor="#F8F8F8" ><TD  valign="top" ><input type='button' onclick='save();' value='Guardar'><input type='button' onclick='nuevo();' value='NuevoItem'><br><br></TD></TR>
</table>

</body>
</html>