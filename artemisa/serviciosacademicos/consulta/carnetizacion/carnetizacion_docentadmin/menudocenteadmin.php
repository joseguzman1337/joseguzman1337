<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
    
//session_start();
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');
$varguardar=0;
/*
if(!isset ($_SESSION['MM_Username'])){

echo "No tiene permiso para acceder a esta opción";
exit();
}*/

$query_tipousuario="select * from tipousuarioadmdocen where codigoestado like '1%'";
$tipousuario= $db->Execute($query_tipousuario)or die(mysql_error());
$totalRows_tipousuario= $tipousuario->RecordCount();
//$row_tipousuario= $tipousuario->FetchRow();

?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
    </head>
    <body>
        <form name="f1" id="f1"  method="POST" action="">
            <table  border="0"  cellpadding="3" cellspacing="3">
                <TR>
                    <TD><LABEL id="labelresaltadogrande"> BUSQUEDA E INGRESO DE ADMINISTRATIVOS Y DOCENTES</LABEL></TD>
                </TR>
                <TR>
                    <TD><p>Señor Usuario si desea consultar o modificar un Usario por favor seleccione el tipo de usuario y digite el número de documento, si desea ingresar un nuevo registro por favor presione el botón Nuevo Registro</p></TD>
                </TR>
            </table>
            <table  border="0"  cellpadding="3" cellspacing="3">
                <tr>
                    <td  id="tdtitulogris" ><label id="labelasterisco">*</label> Seleccione Tipo de Usuario</td>
                    <td>
                        <select name="tipousuario">
                            <option value="">
                                Seleccionar
                            </option>
                            <?php while ($row_tipousuario = $tipousuario->FetchRow()) { ?>
                            <option value="<?php echo $row_tipousuario['idtipousuarioadmdocen']; ?>"
                            <?php
                            if ($row_tipousuario['idtipousuarioadmdocen'] == $_REQUEST['tipousuario']) {
                            echo "Selected";
                            } ?>>
                            <?php echo $row_tipousuario['nombretipousuarioadmdocen']; ?>
                            </option><?php } ?>
                        </select>
                    </td>
                </tr>
                <TR>
                    <td  id="tdtitulogris" >Número de Documento</td>
                    <td>
                        <input type="text" name="numerodocumento">
                    </td>
                </TR>
                <TR>
                    <td id="tdtitulogris" colspan="2" align="center">
                        <input type="submit" name="buscar" value="Consultar">
                        <input type="button" name="nuevo" value="Nuevo Registro" onclick="window.location.href='creaeditadocenteadmin.php'">
                    </td>
                </TR>
            </table>
            <?php
            if(isset ($_REQUEST['buscar'])){
                if($_POST['tipousuario']==''){
                    echo '<script language="JavaScript">alert("Debe seleccionar el tipo de usuario")</script>';
                    $varguardar = 1;
                }
                elseif($varguardar == 0){
                    if(isset ($_POST['numerodocumento']) && $_POST['numerodocumento']!=''){
                        $busquedadocumento='and numerodocumento='.$_POST['numerodocumento'];
                    }
                    $query_docenadmin = "SELECT idadministrativosdocentes, concat(nombresadministrativosdocentes,' ',apellidosadministrativosdocentes)
                    as nombre,date_format(fechaterminancioncontratoadministrativosdocentes, '%d-%m-%Y')as fechavencimiento,telefonoadministrativosdocentes,
                    emailadministrativosdocentes,celularadministrativosdocentes,codigogenero,idtipogruposanguineo,
                    numerodocumento,tipodocumento
                    FROM administrativosdocentes
                    where idtipousuarioadmdocen='".$_POST['tipousuario']."'
                    and codigoestado='100'
                    $busquedadocumento
                    order by nombresadministrativosdocentes";
                    $docenadmin= $db->Execute($query_docenadmin)or die(mysql_error());
                    $totalRows_docenadmin= $docenadmin->RecordCount();
                    $row_docenadmin= $docenadmin->FetchRow();
                    
                    if($totalRows_docenadmin !=''){
                    ?>
                        <br>
                        <table  border="1"  cellpadding="3" cellspacing="3">
                            <tr>
                                <td id="tdtitulogris" colspan="3" align="center">
                                    <label id="labelresaltadogrande">Información del Usuario</label>
                                </td>
                            </tr>
                            <tr>
                                <td id="tdtitulogris">Nombre
                                </td>
                                <td id="tdtitulogris">Documento
                                </td>
                                <td id="tdtitulogris">Terminación Contrato
                                </td>
                            </tr>
                            <?php
                            do {
                            ?>
                            <tr>
                                <td><a href="creaeditadocenteadmin.php?idadministrativosdocentes=<?php echo $row_docenadmin['idadministrativosdocentes']; ?>"><?php echo $row_docenadmin['nombre']; ?></a>
                                </td>
                                <td><?php echo $row_docenadmin['numerodocumento']; ?>
                                </td>
                                <td><?php echo $row_docenadmin['fechavencimiento']; ?>
                                </td>
                            </tr>
                            <?php
                            } while($row_docenadmin = $docenadmin->FetchRow())
                            ?>
                        </table>
                    <?php
                    }
                    else{
                         echo '<script language="JavaScript">alert("No se encuentra el usuario asociado con el numero de documento, por favor verifique el criterio de busqueda")</script>';
                    }
                }
            }           
            ?>
        </form>
    </body>
</html>

