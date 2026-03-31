<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

$fechahoy = date("Y-m-d H:i:s");
require_once('../../../../Connections/sala2.php');
$rutaado = "../../../../funciones/adodb/";
require_once('../../../../Connections/salaado.php');
require_once('admisionvirtualprueba.php');

$query_mecanismopruebaadmision = "SELECT idtipomecanismoprueba, nombretipomecanismoprueba FROM tipomecanismoprueba order by nombretipomecanismoprueba";
$mecanismopruebaadmision = $db->Execute($query_mecanismopruebaadmision);
$totalRows_mecanismopruebaadmision = $mecanismopruebaadmision->RecordCount();
$row_mecanismopruebaadmision = $mecanismopruebaadmision->FetchRow();
?>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">
    </head>
    <script language="javascript">
        function cambiar()
        {
            document.form1.submit();
        }
    </script>

    <body>
        <table width="60%"  border="1" align="center" cellpadding="3" cellspacing="3">
            <TR >
                <TD colspan="2" align="center">
                    <label id="labelresaltadogrande" >FORMULARIO ADMISION VIRTUAL</label>

                </TD>
            </TR>
        </table>
        <?php
        filtroPrueba();
        ?>
        <!--   <form action=""  name="form1" id="form1"  method="POST">-->

<!-- <input type="hidden" name="naidtipopruebaadmision" value="<?php echo $_REQUEST['naidtipopruebaadmision']; ?>">-->
<!-- <input type="hidden" name="naiddetalleadmision" value="<?php echo $_REQUEST['naiddetalleadmision']; ?>">-->
        <?php
       $query_actualizaradmision = "SELECT tp.idtipopruebaadmision,tp.nombretipopruebaadmision,da.iddetalleadmision,da.nombredetalleadmision,
dt.idtipodetalledescripcionprueba,dt.nombretipodescripcionprueba,dd.textodetalledescripcionprueba,
tm.idtipomecanismoprueba, tm.nombretipomecanismoprueba, pd.idpruebadescripcionadmision
       FROM pruebadescripcionadmision pd
       left join detalletipomecanismoprueba dm on dm.idpruebadescripcionadmision=pd.idpruebadescripcionadmision 
left join tipomecanismoprueba tm on dm.idtipomecanismoprueba=tm.idtipomecanismoprueba
,    
       
tipopruebaadmision tp, detalleadmision da,
 tipodetalledescripcionprueba dt,
detalledescripcionprueba dd
       where tp.idtipopruebaadmision='" . $_REQUEST['naidtipopruebaadmision'] . "'
       and pd.idtipopruebaadmision=tp.idtipopruebaadmision and da.iddetalleadmision='" . $_REQUEST['naiddetalleadmision'] . "'
and pd.iddetalleadmision=da.iddetalleadmision 
and dd.idtipodetalledescripcionprueba=dt.idtipodetalledescripcionprueba and dd.idpruebadescripcionadmision = pd.idpruebadescripcionadmision";

        $actualizaradmision = $db->Execute($query_actualizaradmision);
        $totalRows_actualizaradmision = $actualizaradmision->RecordCount();
        $row_actualizaradmision = $actualizaradmision->FetchRow();
        do {
            $arraytextos[$row_actualizaradmision['idtipodetalledescripcionprueba']] = $row_actualizaradmision['textodetalledescripcionprueba'];

            $pruebadescripcionadmision = $row_actualizaradmision['idpruebadescripcionadmision'];
        } while ($row_actualizaradmision = $actualizaradmision->FetchRow());

      /*  echo "arraytextos<pre>";
        print_r($arraytextos);
        echo "</pre>";*/
        
        $query_actualizarmecanismo = "SELECT dm.contactodetalletipomecanismoprueba,tm.idtipomecanismoprueba,
      tm.nombretipomecanismoprueba, pd.idpruebadescripcionadmision
       FROM tipomecanismoprueba tm,detalletipomecanismoprueba dm, pruebadescripcionadmision pd
       where tm.idtipomecanismoprueba=dm.idtipomecanismoprueba
and pd.idpruebadescripcionadmision='" . $pruebadescripcionadmision . "'
    and dm.codigoestado like '1%'
 and dm.idpruebadescripcionadmision=pd.idpruebadescripcionadmision";

        $actualizarmecanismo = $db->Execute($query_actualizarmecanismo);
        $totalRows_actualizarmecanismo = $actualizarmecanismo->RecordCount();
        $row_actualizarmecanismo = $actualizarmecanismo->FetchRow();
        do {
            $mecanismos1[$row_actualizarmecanismo['idtipomecanismoprueba']] = $row_actualizarmecanismo;
        } while ($row_actualizarmecanismo = $actualizarmecanismo->FetchRow());

        /* SELECCION MECANISMO DE LA PRUEBA */

        if (isset($_REQUEST['naidtipopruebaadmision']) && $_REQUEST['naidtipopruebaadmision'] != "") {
            if ($totalRows_mecanismopruebaadmision != "") {
        ?>
                <TABLE width="50%"  border="1" align="center">
                    <tr align="left" >

                        <TD  align="center">
                            <label id="labelresaltado">Modalidad de la Entrevista </label>
                        </TD>
                        <TD  align="center">
                            <label                id="labelresaltado">Seleccionar </label>
                        </TD>
                    </tr>
            <?php
                do {
                    $checked = "";
                    if ($totalRows_permisoitemsic > 0)
                        $checked = 'checked';
                    $mecanismos[] = $row_mecanismopruebaadmision['idtipomecanismoprueba']["idtipomecanismoprueba"];
                    if ($_POST['activar' . $mecanismos]) {
                        $checked = 'checked';
                    }
                    if ($mecanismos1[$row_mecanismopruebaadmision['idtipomecanismoprueba']]["idtipomecanismoprueba"] > 0) {
                        $checked = 'checked';
                    }
            ?>
                    <TR>

                        <TD align="left">
                    <?php echo $row_mecanismopruebaadmision['nombretipomecanismoprueba'];
                    ?>
                </TD>
                <TD align="left">
                    <INPUT type="checkbox" name="activar<?php echo $row_mecanismopruebaadmision['idtipomecanismoprueba']; ?>" value="<?php echo $row_mecanismopruebaadmision['idtipomecanismoprueba']; ?>" <?php echo $checked; ?>>
                </TD>
            </TR>
            <TR>

                <TD align="left">
                    <?php echo "CONTACTO " . $row_mecanismopruebaadmision['nombretipomecanismoprueba']; ?>
                </TD>
                <TD align="left">
                    <INPUT type="text"  size="40" name="contacto<?php echo $row_mecanismopruebaadmision['idtipomecanismoprueba']; ?>" value="<?php echo $mecanismos1[$row_mecanismopruebaadmision['idtipomecanismoprueba']]["contactodetalletipomecanismoprueba"]; ?>" <?php echo $checked; ?>>
                </TD>
            </TR>


            <?php
                } while ($row_mecanismopruebaadmision = $mecanismopruebaadmision->FetchRow());
            ?>

            <?php
                /* TEXTO DESCRIPCION PRUEBA */
                $query_descripcionprueba = "SELECT nombretipodescripcionprueba, idtipodetalledescripcionprueba FROM tipodetalledescripcionprueba";
                $descripcionprueba = $db->Execute($query_descripcionprueba);
                $totalRows_descripcionprueba = $descripcionprueba->RecordCount();
                $row_descripcionprueba = $descripcionprueba->FetchRow();
                do {
            ?>
                    <TR>

                        <TD align="left">
                    <?php echo $row_descripcionprueba['nombretipodescripcionprueba'];
                    ?>
                </TD>
                <td>
                    <textarea cols="60" rows="5" name="textarea<?php echo $row_descripcionprueba['idtipodetalledescripcionprueba']; ?>"><?php echo $arraytextos[$row_descripcionprueba['idtipodetalledescripcionprueba']]; ?></textarea>
                </td>
            </TR>
            <?php
                } while ($row_descripcionprueba = $descripcionprueba->FetchRow());


                /* Guardar informacion en tabla Prueba descripcion Admision */
                if (isset($_POST['grabarprueba'])) {

                    $query_usuariodependencia1 = "SELECT pd.idpruebadescripcionadmision,tp.idtipopruebaadmision,tp.nombretipopruebaadmision,da.iddetalleadmision,da.nombredetalleadmision
       FROM pruebadescripcionadmision pd, tipopruebaadmision tp, detalleadmision da
       where tp.idtipopruebaadmision='" . $_REQUEST['naidtipopruebaadmision'] . "'
       and pd.idtipopruebaadmision=tp.idtipopruebaadmision and da.iddetalleadmision='" . $_REQUEST['naiddetalleadmision'] . "'
and pd.iddetalleadmision=da.iddetalleadmision";
                    $usuariodependencia1 = $db->Execute($query_usuariodependencia1);
                    $totalRows_usuariodependencia1 = $usuariodependencia1->RecordCount();


                    if ($totalRows_usuariodependencia1 > 0) {

                        $query_guardar = "UPDATE pruebadescripcionadmision set codigoestado = 100 where idtipopruebaadmision='" . $_REQUEST['naidtipopruebaadmision'] . "' and iddetalleadmision='" . $_REQUEST['naiddetalleadmision'] . "' ";

                        $guardar = $db->Execute($query_guardar) or die("$query_guardar" . mysql_error());
                        $datosdescripcionadmision = $usuariodependencia1->fetchRow();
                        $idpruebadescripcionadmision = $datosdescripcionadmision["idpruebadescripcionadmision"];
                    } else {
                        $query_guardar = "INSERT INTO pruebadescripcionadmision(idpruebadescripcionadmision,idtipopruebaadmision,iddetalleadmision, codigoestado)
                VALUE(0, '{$_REQUEST['naidtipopruebaadmision']}','{$_REQUEST['naiddetalleadmision']}','100')";
                        $guardar = $db->Execute($query_guardar);
                        $idpruebadescripcionadmision = $db->Insert_ID();
                    }
                    $mecanismostmp = $mecanismos;
                    foreach ($mecanismostmp as $key => $valor) {
                        // if (ereg('activar', $key)) {
                        $codigodependencia = $valor;


                        if (isset($codigodependencia)) {

                            $query_usuariodependencia2 = "SELECT tm.idtipomecanismoprueba, tm.nombretipomecanismoprueba, pd.idpruebadescripcionadmision
       FROM tipomecanismoprueba tm,detalletipomecanismoprueba dm, pruebadescripcionadmision pd
       where dm.idtipomecanismoprueba='$codigodependencia' and tm.idtipomecanismoprueba=dm.idtipomecanismoprueba
and pd.idpruebadescripcionadmision='$idpruebadescripcionadmision' and dm.idpruebadescripcionadmision=pd.idpruebadescripcionadmision";
                            $usuariodependencia2 = $db->Execute($query_usuariodependencia2);
                            $totalRows_usuariodependencia2 = $usuariodependencia2->RecordCount();

                            if ($totalRows_usuariodependencia2 > 0) {
                                if ($_POST["activar" . $codigodependencia]) {
                                    $codigoestadomecanismo = '100';
                                } else {
                                    $codigoestadomecanismo = '200';
                                }

                                $query_guardar = "UPDATE detalletipomecanismoprueba set codigoestado = " . $codigoestadomecanismo . " , contactodetalletipomecanismoprueba='" . $_POST["contacto" . $codigodependencia] . "' where  idtipomecanismoprueba='$codigodependencia' and idpruebadescripcionadmision='$idpruebadescripcionadmision'";
                                $guardar = $db->Execute($query_guardar) or die("$query_guardar" . mysql_error());
                            } else {
                                if ($_POST["activar" . $codigodependencia]) {
                                    $query_guardar = "INSERT INTO detalletipomecanismoprueba(iddetalletipomecanismoprueba,contactodetalletipomecanismoprueba,idtipomecanismoprueba,idpruebadescripcionadmision, codigoestado)
                VALUE(0, '" . $_POST["contacto" . $codigodependencia] . "','{$codigodependencia}','{$idpruebadescripcionadmision}','100')";
                                    $guardar = $db->Execute($query_guardar);
                                }
                            }
                        }
                        //}
                    }
                    /* echo "_POST<pre>";
                      print_r($_POST);
                      echo "</pre>";
                      exit(); */

                    /* Insertar Detalle Descripcion Prueba */


                    foreach ($_POST as $key1 => $valor1) {

                        /* echo "pruebas<pre>";
                          print_r($valor1);
                          echo "</pre>"; */


                        if (ereg('textarea', $key1)) {

                            $codigodependencia1 = ereg_replace('textarea', "", $key1);

                            if (ereg('textarea', $key1)) {

                                $codigodependencia2 = ($valor1);

                                $query_usuariodependencia3 = "SELECT dt.idtipodetalledescripcionprueba,
       d.idpruebadescripcionadmision, dt.nombretipodescripcionprueba
       FROM tipodetalledescripcionprueba dt, pruebadescripcionadmision d, detalledescripcionprueba dd
       where dt.idtipodetalledescripcionprueba ='$codigodependencia1'
       and dd.idtipodetalledescripcionprueba=dt.idtipodetalledescripcionprueba
         and d.idpruebadescripcionadmision = '$idpruebadescripcionadmision' and
       dd.idpruebadescripcionadmision = d.idpruebadescripcionadmision";
                                $usuariodependencia3 = $db->Execute($query_usuariodependencia3);
                                $totalRows_usuariodependencia3 = $usuariodependencia3->RecordCount();


                                if ($totalRows_usuariodependencia3 > 0) {

                                    $query_guardar = "UPDATE detalledescripcionprueba set
     codigoestado = 100,
     textodetalledescripcionprueba='$codigodependencia2' where idtipodetalledescripcionprueba ='$codigodependencia1' and  idpruebadescripcionadmision = '$idpruebadescripcionadmision'";
                                    $guardar = $db->Execute($query_guardar) or die("$query_guardar" . mysql_error());
                                } else {
                                    $query_guardar = "INSERT INTO detalledescripcionprueba(iddetalledescripcionprueba,idtipodetalledescripcionprueba,
idpruebadescripcionadmision,textodetalledescripcionprueba, codigoestado)
                VALUE(0, '{$codigodependencia1}','{$idpruebadescripcionadmision}','{$codigodependencia2}','100')";
                                    $guardar = $db->Execute($query_guardar) or die("$query_guardar" . mysql_error());
                                }
                            }
                        }
                    }
                    echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $REQUEST_URI . "?nacodigocarrera=" . $_REQUEST["nacodigocarrera"] . "&naiddetalleadmision=" . $_REQUEST["naiddetalleadmision"] . "&naidtipopruebaadmision=" . $_REQUEST["naidtipopruebaadmision"] . "'>";
                }
            }
            ?>

            <TR>
                <TD colspan="3" align="center">
                    <INPUT type="submit" value="Enviar" name="grabarprueba">
                    <INPUT type="button" value="Restablecer" name="restablecer" onclick="window.location.href='formularioadmisionfacultad.php'">
                </TD>
            </TR>
        </TABLE>
<?php
        }
?>
    </form>
</body>
</html>
