<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../Connections/sala2.php');
$rutaado = "../../funciones/adodb/";
require_once('../../Connections/salaado.php');
require_once("funcionesreclamos.php");
session_start();
$varguardar = 0;
//require_once("../../funciones/phpmailer/class.phpmailer.php");
//require_once("funcionesreclamos.php");
/*echo "<pre>";
print_r($_SESSION);
echo "</pre>";*/
if (!isset ($_SESSION['session_sqr'])){
    if($HTTP_SERVER_VARS['HTTP_REFERER'] != '')
        $_SERVER['HTTP_REFERER'] = $HTTP_SERVER_VARS['HTTP_REFERER'];
    $_SESSION['session_sqr'] = $_SERVER['HTTP_REFERER'];
}
?>
<SCRIPT language="JavaScript" type="text/javascript">
function cambio()
        {
            document.form1.submit();
        }      

function confirmar() {
        if(confirm('¿Estás Seguro de Generar el Nuevo estado para esta solicitud?')) {
            document.getElementById('estado').value='ok';
            document.form1.submit();
        }
    }
</SCRIPT>
<?php
        $query_impreso="SELECT s.idsolicitudquejareclamo, concat(p.nombrespersonaquejareclamo, ' ', p.apellidospersonaquejareclamo)as nombre,
            p.numerodocumentopersonaquejareclamo, p.emailpersonaquejareclamo, p.telefonopersonaquejareclamo,
            u.nombreusuarioquejareclamo, ar.nombreareaquejareclamo as area_pertenece,
            dq.nombredependenciaquejareclamo as dependencia_pertenece, ta.nombretipoasuntoquejareclamo,
            ap.nombreareaquejareclamo as area_destino, ap.codigoareaquejareclamo,
            d.nombredependenciaquejareclamo as dependencia_destino, d.iddependenciaquejareclamo,
            a.nombreaspectotipoasuntoquejareclamo, s.fechasolicitudquejareclamo, e.nombreestadoquejareclamo,
            e.descripcionestadoquejareclamo, s.comentariosolicitudquejareclamo, s.codigoestadoquejareclamo
        FROM usuarioquejareclamo u, personaquejareclamo p, dependenciaquejareclamo dq, 
        tipoasuntoquejareclamo ta, solicitudquejareclamo s, aspectotipoasuntoquejareclamo a,
        estadoquejareclamo e, dependenciaquejareclamo d, areaquejareclamo ar, areaquejareclamo ap
        where s.idsolicitudquejareclamo='".$_REQUEST['idsolicitudquejareclamo']."'
        and s.idpersonaquejareclamo = p.idpersonaquejareclamo
        and u.codigousuarioquejareclamo= p.codigousuarioquejareclamo        
        and dq.iddependenciaquejareclamo=p.iddependenciaquejareclamo
        and s.codigotipoasuntoquejareclamo = ta.codigotipoasuntoquejareclamo
        and s.codigoaspectotipoasuntoquejareclamo = a.codigoaspectotipoasuntoquejareclamo 
        and s.codigoestadoquejareclamo = e.codigoestadoquejareclamo 
        and d.iddependenciaquejareclamo=s.iddependenciaquejareclamo
        and dq.codigoareaquejareclamo = ar.codigoareaquejareclamo 
        and d.codigoareaquejareclamo = ap.codigoareaquejareclamo 
        order by 1";
        $impreso= $db->Execute($query_impreso);
                $totalRows_impreso = $impreso->RecordCount();
                $row_impreso = $impreso->FetchRow();

    if (isset($_POST['estado']) && $_POST['estado'] != '') {
        if ($_POST['descripcion'] == '') {
            echo '<script language="JavaScript">alert("Debe digitar una respuesta para la sugerencia.")</script>';
                    $varguardar = 1;
              }              
        elseif ($varguardar == 0) {
            
            $query_actualizar = "UPDATE solicitudquejareclamo SET codigoestadoquejareclamo = '".$_REQUEST['codigoestado']."'
            where idsolicitudquejareclamo = '".$_REQUEST['idsolicitudquejareclamo']."'";
            $actualizar = $db->Execute ($query_actualizar) or die("$query_actualizar".mysql_error());
            
            $query_generarestado = "INSERT INTO descripcionsolicitudquejareclamo (iddescripcionsolicitudquejareclamo,
            idsolicitudquejareclamo, descripcionsolicitudquejareclamo, estadoorigen, estadodestino,
            fechadescripcionsolicitudquejareclamo)
            values (0,'".$_REQUEST ['idsolicitudquejareclamo']."','{$_REQUEST['descripcion']}',
            '{$row_impreso['codigoestadoquejareclamo']}', '".$_REQUEST['codigoestado']."', now())";
            $generarestado = $db->Execute ($query_generarestado) or die("$query_generarestado".mysql_error());
            
            echo "<script language='javascript'>
            alert('!!Gracias!! La información se ha Enviado Correctamente');    window.location.href='listadoestado.php?tipolistado=".$_REQUEST['tipolistado']."';
            </script>";
        }
    }   
?>
<html>
    <head>
        <title>EL Bosque Te Escucha</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">        
</head>
    <body>
        <form name="form1" id="form1"  method="POST">
            <?php if ($totalRows_impreso !='') { ?>
            <table width="50%"  border="1" align="center" cellpadding="3" cellspacing="3">
                <tr id="trgris">
                    <td align="center" colspan="2">
                        <label id="labelresaltadogrande">Información de la Sugerencia</label>
                    </td>
                </tr>
                <tr id="trgris">
                    <td align="left" colspan="2">
                        <label id="labelresaltado">Datos Usuario</label>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Nombre Solicitante</td>
                    <td><?php echo $row_impreso['nombre']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Número Documento</td>
                    <td><?php echo $row_impreso['numerodocumentopersonaquejareclamo']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td id="tdtitulogris">E-mail</td>
                    <td><?php echo $row_impreso['emailpersonaquejareclamo']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Télefono</td>
                    <td><?php echo $row_impreso['telefonopersonaquejareclamo']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Tipo de Usuario</td>
                    <td><?php echo $row_impreso['nombreusuarioquejareclamo']; ?>&nbsp;</td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Área</td>
                    <td><?php echo $row_impreso['area_pertenece']; ?>&nbsp;</td>
                </tr>
                 <tr>
                    <td id="tdtitulogris">Programa o Dependencia </td>
                    <td><?php echo $row_impreso['dependencia_pertenece']; ?>&nbsp;</td>
                </tr>
                <tr id="trgris">
                    <td align="left" colspan="2">
                        <label id="labelresaltado">Tipo de Requerimiento</label>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Requerimiento </td>
                    <td><?php echo $row_impreso['nombretipoasuntoquejareclamo']; ?></td>
                </tr>
                <tr id="trgris">
                    <td align="left" colspan="2">
                        <label id="labelresaltado">Área para felicitar, analizar o presentar solicitud</label>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Área Destino </td>
                    <td><?php echo $row_impreso['area_destino']; ?></td>
                </tr>
                <tr>
                    <td id="tdtitulogris">Programa o Dependencia Destino </td>
                    <td><?php echo $row_impreso['dependencia_destino']; ?></td>
                </tr>
                <tr id="trgris">
                    <td align="left" colspan="2">
                        <label id="labelresaltado">Aspecto para analizar</label>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris"> Aspecto del Asunto  </td>
                    <td><?php echo $row_impreso['nombreaspectotipoasuntoquejareclamo']; ?></td>
                </tr>
                <tr id="trgris">
                    <td align="left" colspan="2">
                        <label id="labelresaltado">Comentario</label>
                    </td>
                </tr>
                <tr>
                    <td id="tdtitulogris"> Descripción del Requerimiento  </td>
                    <td><?php echo $row_impreso['comentariosolicitudquejareclamo']; ?></td>
                </tr>
            </table>            
            <BR>
            <?php
            estadoquejareclamo ($_REQUEST['idsolicitudquejareclamo']);
            }
            
            if ($row_impreso['codigoestadoquejareclamo']==100 || $row_impreso['codigoestadoquejareclamo']==300 || $row_impreso['codigoestadoquejareclamo']==500){                
                if (isset ($_REQUEST['tipolistado'])&& $_REQUEST['tipolistado']=='atencionalusuario'){
                    if(!isset ($_SESSION['MM_Username'])){
                        echo "<script language='javascript'>
                                alert('Su sesión ha sido cerrada por favor reinicie.');
                                window.location.href='index.php';
                                          </script>";
                        exit();
                    }
                    ?>

                <table width="50%"  border="1" align="center" cellpadding="3" cellspacing="3">
                    <tr id="trgris">
                        <td align="center" colspan="2">
                            <label id="labelresaltadogrande">Aprobacion y Respuestas a la Sugerencia</label>
                        </td>
                    </tr>
                    <tr>
                        <?php
                        $query_modificarestado = "SELECT codigoestadoquejareclamo, nombreestadoquejareclamo FROM estadoquejareclamo
                        where codigoestadoquejareclamo in (200, 500) ";
                        $modificarestado= $db->Execute($query_modificarestado);
                        $totalRows_modificarestado = $modificarestado->RecordCount();
                        $row_modificarestado = $modificarestado->FetchRow();
                        ?>
                        <td id="tdtitulogris" width="40%">Seguimiento
                            <select name="codigoestado" id="codigoestado" >
                                <option value="">Seleccionar</option>
                                <?php do {?>
                                <option value="<?php echo $row_modificarestado['codigoestadoquejareclamo'];?>"
                                <?php
                                if($row_modificarestado['codigoestadoquejareclamo'] == $_POST['codigoestado']) {
                                echo "Selected";
                                } ?>>
                                <?php echo $row_modificarestado['nombreestadoquejareclamo'];?>
                                </option>
                                <?php } while($row_modificarestado= $modificarestado->FetchRow())?>
                            </select>
                        </td>
                        <td>
                        <TEXTAREA name="descripcion" cols="50" rows="4" ></TEXTAREA>
                        </td>
                    </tr>
                    <tr>
                        <td id="tdtitulogris" colspan="2" align="center">
                            <INPUT type="hidden" value="" name="estado" id="estado">
                            <INPUT type="button" value="Enviar Respuesta" onclick="return confirmar()">
                        </td>
                    </tr>
                    </table>
                <?php
                }
                
            }
            elseif (isset ($_REQUEST['tipolistado'])) {                                
                if ($row_impreso['codigoestadoquejareclamo'] == 200 || $row_impreso['codigoestadoquejareclamo'] == 500){
                    if($_REQUEST['tipolistado']=='solicitante'){                    
                    modificarestado($row_impreso['codigoestadoquejareclamo'], $_REQUEST['idsolicitudquejareclamo']);
                    }
                }            
            }           
            ?>
            <DIV align="center">
                <INPUT type="button" value="Regresar" onclick="window.location.href='<?php echo $_SESSION['session_sqr']; ?>'">                    
            </DIV>           
        </form>
    </body>
</html>
