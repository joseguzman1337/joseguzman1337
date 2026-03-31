<?php
//error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
//ini_set('display_errors', E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
 

if(isset($_REQUEST['idserialize'])){

require_once('../Connections/sala2.php');
$rutaado = "../funciones/adodb/";
require_once('../Connections/salaado.php');

?>


<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">

</head>
    <body bgcolor="#DDE0BD">
<form name="form1" id="form1"  method="POST">
    <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3">
         <tr>
           <td><img src="../aspirantes/Unbosque/imagenes/banner.gif"></td>
         </tr>
        </table>

     <table width="750px"  border="0" align="center" cellpadding="3" cellspacing="3" bgcolor="#F8F8F8" >
        <tr>
           <td style="color:#40482D;font-size:15px;"><b>Si realmente no deseas recibir más mensajes por favor haz clic en el boton Enviar.</b>
           </td>
        </tr>
	<tr>
           <td align="center">
                <input type="hidden" name="idserialize" value="<?php echo $_REQUEST['idserialize']; ?>">
                <input style="background-color:#DDE0BD" type="submit" name="enviar" value="Enviar">
           </td>
        </tr>
    </table>

<?php 
 if(isset($_POST['enviar'])){

   $query_actualiza = "update egresado_ext set recibeinfo=200 where codigoestudiante='".$_POST['idserialize']."'";
   $actualiza= $db->Execute($query_actualiza);

   if($actualiza){
   echo '<script language="JavaScript">alert("La solicitud ha sido procesada.")
   window.location.href="http://www.uelbosque.edu.co";
   </script>';

   }
 }
?>

<?php
}
else{
 echo '<script language="JavaScript">alert("Acceso Restringido.")
  window.location.href="http://www.uelbosque.edu.co";
   </script>';
}

?>
