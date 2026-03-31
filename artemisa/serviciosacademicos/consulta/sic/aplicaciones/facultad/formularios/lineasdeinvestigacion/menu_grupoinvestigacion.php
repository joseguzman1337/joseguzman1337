<?php
session_start();
    include_once(realpath(dirname(__FILE__)).'/../../../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
$fechahoy=date("Y-m-d H:i:s");
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/sala2.php');
$rutaado = "../../../../../../funciones/adodb/";
require_once(realpath(dirname(__FILE__)).'/../../../../../../Connections/salaado.php');
session_start();
//unset ($_SESSION['sesion_planestudioporcarrera']);
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../../../estilos/sala.css" type="text/css">
         <SCRIPT language="JavaScript" type="text/javascript">

function prueba()
{
    document.form1.submit();
}

         </SCRIPT>
    </head>
 <body>
    <form name="form1" id="form1"  method="POST">
        <table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">

            <TR><TD id="tdtitulogris" align="center"><label id="labelresaltadogrande" >TABLA DE GRUPOS  DE INVESTIGACIÓN</label></TD></TR>
        </table>
                <?php
                $query_grupoinvestigacion = "SELECT g.idgrupoinvestigacion, g.codigofacultad, g.nombregrupoinvestigacion, c.codigocarrera, c.nombrecarrera FROM grupoinvestigacion g, carrera c
                where
                g.codigofacultad= c.codigofacultad
                and c.codigocarrera = '".$_SESSION['codigofacultad']."'
                and g.codigoestado like '1%'";
                $grupoinvestigacion= $db->Execute($query_grupoinvestigacion);
                $totalRows_grupoinvestigacion = $grupoinvestigacion->RecordCount();
                $row_grupoinvestigacion= $grupoinvestigacion->FetchRow();

                $codigodefacultad = $row_grupoinvestigacion['codigofacultad'];
                ?>

                            <table width="50%"  border="1" align="center">
                                <tr align="left" >
                                    <TD  align="center">
                                        <label id="labelresaltado">ID </label>
                                    </TD>
                                    <TD  align="center">
                                        <label id="labelresaltado">Nombre Grupo Investigación</label>
                                    </TD>
                                    <?php if ($totalRows_grupoinvestigacion !=0){ ?>
                                    <TD  align="center">
                                        <label id="labelresaltado">Líneas de Investigación</label>
                                    </TD>
                                     <?php } ?>
                                </tr>
                                <?php do {?>
                                <TR >
                                    <TD width="5%" align="center"><A id="aparencialink" href="insertar_modificar.php?idgrupoinvestigacion=<?php echo $row_grupoinvestigacion['idgrupoinvestigacion']."&iditemsic=".$_REQUEST['iditemsic']; ?>"><?php echo $row_grupoinvestigacion['idgrupoinvestigacion']; ?></A>
                                    </TD>
                                    <TD  align="center"><?php echo $row_grupoinvestigacion['nombregrupoinvestigacion']; ?>
                                    </TD>
                                    <?php if ($totalRows_grupoinvestigacion !=0){ ?>
                                    <TD width="5%" align="center"><A id="aparencialink" href="lista_lineasinvestigacion.php?idgrupoinvestigacion=<?php echo $row_grupoinvestigacion['idgrupoinvestigacion']; ?>">Ver</A>
                                    </TD>
                                    <?php } ?>
                                </TR>
                                <?php } while($row_grupoinvestigacion = $grupoinvestigacion->FetchRow());
                                ?>
                                <TR >
                                    <TD colspan="3" align="center"><INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_modificar.php?codigodefacultad=<?php echo $codigodefacultad."&iditemsic=".$_REQUEST['iditemsic']; ?>'">
                                    </TD>
                                </TR>
                            </table>

   </form>
 </body>
</html>