<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php' );
$fechahoy=date("Y-m-d H:i:s");
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
session_start();
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}
$_SESSION['MM_Username'];
$codigoestudiante = $_REQUEST['codigoestudiante'];
$query_estgeneral ="select idestudiantegeneral
    from estudiante
    where codigoestudiante='$codigoestudiante'";
$estgeneral= $db->Execute($query_estgeneral);
$row_estgeneral= $estgeneral->FetchRow();

$idestudiantegeneral= $row_estgeneral['idestudiantegeneral'];

$query_datopadre ="select *
    from usuariopadre
    where idestudiantegeneral='$idestudiantegeneral' AND codigoestado=100";
$datopadre= $db->Execute($query_datopadre);
 $totalRows_datopadre= $datopadre->RecordCount();
$row_datopadre= $datopadre->FetchRow();

if($totalRows_datopadre!=""){
?>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="">
            <table  width="70%" border="1"  cellpadding="3" cellspacing="3">
                <TR id="trgris">
                    <TD colspan="5" align="center"><LABEL id="labelresaltadogrande">DATOS DEL PADRE</LABEL></TD>
                </TR>
                
                <TR>
                    <TD id="tdtitulogris" align="center">Usuario</TD>
                    <TD id="tdtitulogris" align="center">Número Documento</TD>
                    <TD id="tdtitulogris" align="center">Apellidos Padre</TD>
                    <TD id="tdtitulogris" align="center">Nombres Padre</TD>
                    <TD id="tdtitulogris" align="center">E-Mail Padre</TD>
                </TR>
                <?php
                do{
                ?>
                <TR>
                    <TD><?php echo $row_datopadre['usuario']; ?></TD>
                    <TD><?php if($row_datopadre['documentousuariopadre']!=""){ echo $row_datopadre['documentousuariopadre']; } else{ echo "&nbsp;"; } ?></TD>
                    <TD><?php echo $row_datopadre['apellidosusuariopadre']; ?></TD>
                    <TD><?php echo $row_datopadre['nombresusuariopadre']; ?></TD>
                    <TD><?php echo $row_datopadre['emailusuariopadre']; ?></TD>
                </TR>                
                <?php }while($row_datopadre = $datopadre->FetchRow())
                ?>
                <TR id="trgris" >
                    <TD colspan="5" align="center">
                        <input type="button" name="enviar" value="Nuevo Registro" onclick="window.location.href='formulariopadre.php?idestudiantegeneral=<?php echo $idestudiantegeneral; ?>&codigoestudiante=<?php echo $codigoestudiante; ?>'">
                        <INPUT type="button" value="Regresar" onclick="window.location.href='../../prematricula/matriculaautomaticaordenmatricula.php';">
                    </TD>
                </TR>
            </table>
        </form>
    </body>
</html>
<?php
}
else{
    $verifica=true;
    echo "<script language='javascript'>
             window.location.href='formulariopadre.php?idestudiantegeneral=$idestudiantegeneral&codigoestudiante=$codigoestudiante&verifica=$verifica' ; </script>";
}
?>

