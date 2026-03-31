<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

function filtroPrueba() {
    global $db;
    $_SESSION['codigoperiodosesion'] = '20112';
    $_SESSION['codigofacultad'] = '10';
    $_SESSION['MM_Username'] = 'admintecnologia';

    /*echo "<pre>";
    print_r($_POST);
    echo "<pre>";*/

    $query_facultad = "SELECT c.codigocarrera, u.usuario ,c.nombrecarrera FROM carrera c, usuariofacultad u
where u.codigofacultad=c.codigocarrera and u.usuario='" . $_SESSION['MM_Username'] . "' ";
    //echo "$query_hijos<br>";
    $facultad = $db->Execute($query_facultad);
    $totalRows_facultad = $facultad->RecordCount();
    //if($totalRows_dependencia != 0) {
    $row_facultad = $facultad->FetchRow();
?>
    <form method="post" action="" name="fsel">
        <table border="0" align="center">
            <tr>
                <td>FACULTAD</td>
                <td><select name="nacodigocarrera" onchange="document.fsel.submit()">
                        <option value="" selected>Seleccionar</option>
                    <?php
                    do {
                        $selected = "";
                        if ($row_facultad['codigocarrera'] == $_REQUEST['nacodigocarrera'])
                            $selected = "selected";
                    ?>
                        <option value="<?php echo $row_facultad['codigocarrera']; ?>" <?php echo $selected; ?>>
                        <?php echo $row_facultad['nombrecarrera']; ?>
                    </option>
                    <?php
                    }
                    while ($row_facultad = $facultad->FetchRow());
                    ?>
                </select>
            </td>
        </tr>

        <?php
                    if (isset($_REQUEST['nacodigocarrera'])) {
                       $query_prueba = "SELECT da.iddetalleadmision, da.nombredetalleadmision
FROM admision a, detalleadmision da, carreraperiodo cp, subperiodo sp, carrera c, periodo p
where da.idadmision=a.idadmision and sp.idcarreraperiodo=cp.idcarreraperiodo
and c.codigocarrera=cp.codigocarrera and a.idsubperiodo=sp.idsubperiodo and p.codigoperiodo=cp.codigoperiodo
and c.codigocarrera= '" . $_REQUEST['nacodigocarrera'] . "' and p.codigoperiodo='" . $_SESSION['codigoperiodosesion'] . "'";
                        //echo "$query_hijos<br>";
                        $prueba = $db->Execute($query_prueba);
                        $totalRows_prueba = $prueba->RecordCount();
                        if ($totalRows_prueba != 0) {
                            $row_prueba = $prueba->FetchRow();
        ?>
                            <tr>
                                <td>MODALIDAD TIPO PRUEBA:</td>
                                    <td colspan="2"><select name="naiddetalleadmision" onchange="document.fsel.submit()">
                                        <option value="" selected>Seleccionar</option>
                    <?php
                            $entro = false;
                            do {
                                $selected = "";
                                if ($row_prueba['iddetalleadmision'] == $_REQUEST['naiddetalleadmision']) {
                                    $selected = "selected";
                                    $entro = true;
                                }
                    ?>
                                <option value="<?php echo $row_prueba['iddetalleadmision']; ?>" <?php echo $selected; ?>>
                        <?php echo $row_prueba['nombredetalleadmision']; ?>
                            </option>
                    <?php
                            } while ($row_prueba = $prueba->FetchRow());
                    ?>
                        </select>
                    </td>
                </tr>
        <?php
                        } else {
        ?>
                            <tr><td colspan="2">No hay informaciï¿½n</td></tr>
        <?php
                        }
                        /*if (!$entro)
                            $_REQUEST['naiddetalleadmision'] = "";*/
                    }
        ?>
        <?php
                    if (isset($_REQUEST['naiddetalleadmision'])) {

                        $query_tipopruebaadmision = "SELECT idtipopruebaadmision, nombretipopruebaadmision
                     FROM tipopruebaadmision where codigoestado='100' order by nombretipopruebaadmision";
                        $tipopruebaadmision = $db->Execute($query_tipopruebaadmision);
                        $totalRows_tipopruebaadmision = $tipopruebaadmision->RecordCount();
                        if ($totalRows_tipopruebaadmision != 0) {
                            $row_tipopruebaadmision = $tipopruebaadmision->FetchRow();
        ?>
                            <tr>
                                <td>TIPO PRUEBA:</td>

                                <td colspan="2"><select name="naidtipopruebaadmision" onchange="document.fsel.submit()">
                                        <option value="" selected>Seleccionar</option>
                    <?php
                            $entro = false;
                            do {
                                $selected = "";
                                if ($row_tipopruebaadmision['idtipopruebaadmision'] == $_REQUEST['naidtipopruebaadmision']) {
                                    $selected = "selected";
                                    $entro = true;
                                }
                    ?>
                                <option value="<?php echo $row_tipopruebaadmision['idtipopruebaadmision']; ?>" <?php echo $selected; ?>>
                        <?php echo substr($row_tipopruebaadmision['nombretipopruebaadmision'], 0, 30); ?>
                            </option>
                    <?php
                            } while ($row_tipopruebaadmision = $tipopruebaadmision->FetchRow());
                    ?>
                        </select>
                    </td>
                </tr>
        <?php
                        } else {
        ?>
                            <tr><td colspan="2">No hay informaciÃ³n</td></tr>
        <?php
                        }
                        if (!$entro)
                            $_REQUEST['naidtipopruebaadmision'] = "";
                    }
        ?>

                </table>
            
<?php
                }
?>
