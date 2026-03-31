<?php
$fechahoy=date("Y-m-d H:i:s");
require_once('../../../Connections/sala2.php');
$rutaado = "../../../funciones/adodb/";
require_once('../../../Connections/salaado.php');


    $query_codigoperiodo = "SELECT codigoperiodo FROM periodo where codigoestadoperiodo in (1,4)";
    $codigoperiodo= $db->Execute($query_codigoperiodo);
    $totalRows_codigoperiodo = $codigoperiodo->RecordCount();

    $query ="SELECT ch.idcohorte,ch.numerocohorte,ch.codigocarrera,c.nombrecarrera,ch.codigoperiodo,ec.nombreestadocohorte,ch.codigoperiodoinicial,ch.codigoperiodofinal FROM
cohorte ch, carrera c, estadocohorte ec WHERE
ch.codigocarrera=c.codigocarrera AND
ch.codigoestadocohorte=ec.codigoestadocohorte and
ch.codigoperiodo='".$_GET['codigoperiodo']."' and
ch.codigoestadocohorte='01'
order by c.nombrecarrera asc, ch.numerocohorte asc";
        $rta= $db->Execute($query);
                $totalRows_rta = $rta->RecordCount();
$row_rta = $rta->FetchRow();
?>
<script language="javascript">
    function cambio()
        {
            document.form1.submit();
        }
</script>

<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../estilos/sala.css" type="text/css">
</head>
    <body>
<form name="form1" id="form1"  method="GET">

<table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
<TR >
           <TD colspan="2" align="center"><label id="labelresaltadogrande" >Carreras con Cohortes Asignados al Periodo Vigente</label></TD>
          </TR>

          <tr align="left" >
                    <td width="50%" id="tdtitulogris"><div align="center">Seleccione el Periodo </div>
                    </td>
                    <td width="50%" id="tdtitulogris">
                        <div align="justify">
                            <select name="codigoperiodo" id="codigoperiodo" onchange="cambio()">
                            <option value="">
                                Seleccionar
                            </option>
                                <?php while($row_codigoperiodo = $codigoperiodo->FetchRow()){?>
                            <option value="<?php echo $row_codigoperiodo['codigoperiodo'];?>"
                                <?php
                                 if($row_codigoperiodo['codigoperiodo']==$_GET['codigoperiodo']) {
                                echo "Selected";
                                 }
                                ?>>
                                <?php echo $row_codigoperiodo['codigoperiodo'];?>
                            </option>
                            <?php }?>
                            </select>
                        </div>
                    </td>
                </tr>
 </table>

       <TABLE width="750px"  border="1" align="center">
        <TR id="trgris">
            <TD width="5%" align="center"><label id="labelresaltado">No. Cohorte </label></TD>
            <TD align="center"><label id="labelresaltado">Carrera Cohorte </label></TD>
            <TD width="5%" align="center"><label id="labelresaltado">Periodo de Aplicación</label></TD>
            <TD width="5%" align="center"><label id="labelresaltado">Estado</label></TD>
            <TD width="5%" align="center"><label id="labelresaltado">Periodo Inicial </label></TD>
            <TD width="5%" align="center"><label id="labelresaltado">Periodo Final </label></TD>
            <TD width="5%" align="center"><label id="labelresaltado">Detalle Cohorte </label></TD>

        </TR>
            <?php do {?>
        <TR>
            <TD width="5%" align="center"><?php echo $row_rta['numerocohorte']; ?></TD>
            <TD align="center"><A id="aparencialink" href="insertar_modificar.php?idcohorte=<?php echo $row_rta['idcohorte']."&codigocarrera=".$row_rta['codigocarrera']."&codigoperiodo=".$row_rta['codigoperiodo']; ?>"><?php echo $row_rta['nombrecarrera']; ?></A></TD>
            <TD width="5%" align="center"><?php echo $row_rta['codigoperiodo']; ?></TD>
            <TD width="5%" align="center"><?php echo $row_rta['nombreestadocohorte']; ?></TD>
            <TD width="5%" align="center"><?php echo $row_rta['codigoperiodoinicial']; ?></TD>
            <TD width="5%" align="center"><?php echo $row_rta['codigoperiodofinal']; ?></TD>
            <TD width="5%" align="center"><a id="aparencialink" href="lista_insertar_modificar.php?codigoperiodo=<?php echo $_GET['codigoperiodo']."&idcohorte=".$row_rta['idcohorte']."&codigocarrera=".$row_rta['codigocarrera']?>">Detalle</a></TD>

        </TR>
        <?php }while($row_rta = $rta->FetchRow());
         ?>
        <TR align="left">
                <TD id="tdtitulogris" colspan="4"  align="center">

                <INPUT type="button" value="Adicionar" onClick="window.location.href='insertar_modificar.php?codigoperiodo=<?php echo $_GET['codigoperiodo']; ?>'">

                </TD>
       </TABLE>

</form>
</body>
</html>