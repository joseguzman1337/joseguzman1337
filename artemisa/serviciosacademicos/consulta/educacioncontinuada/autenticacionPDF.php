<?php
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
//$rutazado = "../../../funciones/zadodb/";
require_once('../../Connections/salaado.php');
// //print_r($_SERVER);
//exit();
/*if($_SERVER['PHP_AUTH_USER'] != 'foro')
{
    $_SERVER['PHP_AUTH_USER'] = '';
    $_SERVER['PHP_AUTH_PW'] = '';
}*/
//exit();
/*if ( $_SERVER['PHP_AUTH_PW']=="" && $_SERVER['PHP_AUTH_USER']==""  )
{
    authenticate();
   //echo "funciona";
}
else
{*/

/*    if(esValido($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']))
         //header('WWW-Authenticate: Basic realm="Autenticacion Facultad Psicologia1"');
         header("Location: popupcertificados.php");

    else
    {
        //authenticate();
        //header("Location: autenticacion.php?salir");
        authenticate();
    }

//}
*/
if(!isset($_REQUEST['ruta']))
    $_REQUEST['ruta'] = "diplomadoAtencionPsicosocial/diploma/";
//$_REQUEST['ruta'] .= "/diploma/";
$rutaCarpeta = $_REQUEST['ruta'];

function authenticate()
{
    header('WWW-Authenticate: Basic realm="Descarga de certificados: El usuario es foro y la clave es su número de documento"');
    header('HTTP/1.0 401 Unauthorized');
    echo "Debe entrar un login y un password autorizado\n";
?>
<a href="javascript:window.location.href='autenticacion.php'">Volver</a>
<?php
    exit;
}

function esValido($documento)
{
    global $db;
    //echo $_REQUEST['ruta'];//."$usuario,$password";
    //exit();
    if(is_file($_REQUEST['ruta']."$documento.pdf")) {
        return true;
    }
    else {
        return false;
    }
}
if(isset($_REQUEST['documento']))
{
    if(esValido($_REQUEST['documento'])) {
        //header($_REQUEST['ruta']."$documento.pdf");
        header("Location: ".$_REQUEST['ruta'].$_REQUEST['documento'].".pdf");
        /*header("Location: popupcertificados.php?documento=".$_REQUEST['documento']."&iddiploma=".$_REQUEST['iddiploma']);*/
    }
    else {
?>
<script language="JavaScript">
    alert("El documento digitado no se encuentra, por favor revise el número de documento e ingréselo nuevamente");
</script>
<?php
    }
}

?>
<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<form method="POST" action="" name="f1">
        <input type="hidden" name="ruta" value="<?php echo $_REQUEST['ruta'];?>">
<table>
  <tr>
    <td colspan="2"><b>Digite su número de documento</b></td>
  </tr>
  <tr>
    <td>Documento</td>
    <td><input type="text" name="documento" value="" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="Descargar" value="Descargar" /></td>
  </tr>
</table>
</form>
