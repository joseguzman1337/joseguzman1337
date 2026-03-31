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
function VerRuta($codigodiploma){
        
    
    
     //ruta actual
    
    
    
    if (is_dir("memorias/".$codigodiploma."/")){
        $directorio = opendir("memorias/".$codigodiploma."/");
                
    ?>
            <link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
            <table>
              <tr>
                <td colspan="2"><b>LISTA DE MEMORIAS</b></td>
              </tr><?php
    while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
    {
        if (is_dir($archivo))//verificamos si es o no un directorio
        {
            //echo "[".$archivo . "]<br />"; //de ser un directorio lo envolvemos entre corchetes
        }
        else
        {
            ?>
              <tr>
                <td><?php 
                
                if($archivo!="index.html"){
                   echo "<a href='memorias/".$codigodiploma."/".$archivo."'>".$archivo."</a>"; 
                }
                ?> 
                </td>
                
              </tr>
              
           
            
            <?php
            
        }
    }
    ?>
     </table>
    <?php }else{
        ?>
              
            <script language="JavaScript">
                alert("No hay documentos disponibles para Este diplomado");
                location.href = "./autenticacion_memorias.php?iddiploma=<?php echo $_GET["iddiploma"]; ?>";                
            </script>    
        <?php
        
    }    
        ?>
    
              
        
         </table>
    <?php
}

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

function esValido($db,$documento,$iddiploma)
{

    //echo "$usuario,$password";
    //exit();
    $query_datos = "SELECT
                        asistente.idasistente,
                        asistente.tipodocumento,
                        asistente.documentoasistente,
                        concat(apellidoasistente,' ', nombreasistente) AS nombre,
                        asistentediploma.iddiploma
                    FROM
                        asistente
                    INNER JOIN asistentediploma ON asistentediploma.idasistente = asistente.idasistente
                    WHERE documentoasistente = '".$documento."' AND
	                   asistentediploma.iddiploma='".$iddiploma."'";
    //echo $query_datos."<br>";
    $datos = $db->Execute($query_datos);
    $totalRows_datos = $datos->RecordCount();
    $row_datos = $datos->FetchRow();
    if($totalRows_datos > 0)
    {        
        return true;
        
    }
    else
    {
        return false;
    }
}

function VerCodDiploma($db,$documento,$diploma)
{

    //echo "$usuario,$password";
    //exit();
    $query_datos = "SELECT
                        asistentediploma.iddiploma
                    FROM
                        asistente
                    INNER JOIN asistentediploma ON asistentediploma.idasistente = asistente.idasistente
                    WHERE documentoasistente = '".$documento."' AND iddiploma=".$_REQUEST['iddiploma'];
    //echo $query_datos."<br>";
    $datos = $db->Execute($query_datos);
    $totalRows_datos = $datos->RecordCount();
    $row_datos = $datos->FetchRow();
    return $row_datos["iddiploma"];
}
if(isset($_REQUEST['documento']))
{
    if(esValido($db,$_REQUEST['documento'],$_REQUEST['iddiploma']))
    {
        
            VerRuta(VerCodDiploma($db,$_REQUEST['documento'],$_REQUEST['iddiploma']));
        

    }else{
        unset($_REQUEST['documento']);
?>
<script language="JavaScript">
    alert("El documento digitado no se encuentra con acesso para esta seccion, por favor revise el número de documento e ingréselo nuevamente");
</script>
<?php
    }
}


if((!isset($_REQUEST['documento']))){
    

?>

<link rel="stylesheet" type="text/css" href="../../estilos/sala.css">
<form method="POST" action="" name="f1">
<input type="hidden" name="iddiploma" value="<?php echo $_REQUEST['iddiploma'];?>">
<table>
  <tr>
    <td colspan="2"><b>Digite su numero de documento</b></td>
  </tr>
  <tr>
    <td>Documento</td>
    <td><input type="text" name="documento" value="" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="Descargar" value="Ver memorias" /></td>
  </tr>
</table>
</form>
<?php
}
?>