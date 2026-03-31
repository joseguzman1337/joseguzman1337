<?php
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

require_once('../../../Connections/sala2.php');
session_start();
mysql_select_db($database_sala, $sala);
$query_Recordset1 = "SELECT * FROM documento";
$Recordset1 = mysql_query($query_Recordset1, $sala) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

function verificaconSalaInterno($tipodocumento, $nombres, $apellidos, $numerodocumento, $sala) {
    $query = "select idusuario,usuario from usuario where numerodocumento='" . $numerodocumento . "' and codigotipousuario = 500";
    $resultado = mysql_query($query, $sala);
    $row_user = mysql_fetch_assoc($resultado);
    $totalfilas = mysql_num_rows($resultado);
    if ($row_user <> "") {
        $querys = "select * from permisousuariomenuopcion where idusuario='" . $row_user['idusuario'] . "' ";
        $resultadob = mysql_query($querys, $sala);
        $row = mysql_fetch_assoc($resultadob);
        $cont = mysql_num_rows($resultadob);
        if ($cont == 0) {
            $query = "insert into permisousuariomenuopcion (idpermisomenuopcion,idusuario,codigoestado) values (251," . $row_user['idusuario'] . ",'100')";
            mysql_query($query, $sala);
        }
        $queryt = "select * from docente where numerodocumento='" . $numerodocumento . "' ";
        $resultadoc = mysql_query($queryt, $sala);
        $rowt = mysql_fetch_assoc($resultadoc);
        $contar = mysql_num_rows($resultadoc);
        if ($contar == 0) {
            $query = "INSERT INTO `docente` (`codigodocente`, `apellidodocente`, `nombredocente`, `tipodocumento`, `numerodocumento`, 
            `clavedocente`, `emaildocente`, `codigogenero`, `fechanacimientodocente`) 
            VALUES ('" . $numerodocumento . "', '" . $apellidos . "', '" . $nombres . "', '" . $tipodocumento . "', '" . $numerodocumento . "', '0', '" . $row_user['usuario'] . "@unbosque.edu.co', '100', '0000-00-00')";
            mysql_query($query, $sala);
        }
        $queryr = "select * from UsuarioTipo where UsuarioId='" . $row_user['idusuario'] . "' ";
        $resultadod = mysql_query($queryr, $sala);
        $rowt = mysql_fetch_assoc($resultadod);
        $conta = mysql_num_rows($resultadod);
        if ($conta == 0) {
            $sqlUsuarioTipo = "insert into UsuarioTipo (CodigoTipoUsuario, UsuarioId, CodigoEstado) value ('" . $codtipousuario . "', '" . $row_user['idusuario'] . "', '100' );";
            mysql_query($sqlUsuarioTipo, $sala);
        }
    }
}

if ($_SESSION['MM_Username'] == "") {
    ?>
    <script>
        window.location.reload("../../login.php");
    </script>
    <?php
}
?>
<style type="text/css">
    <!--
    .Estilo5 {font-family: tahoma}
    .Estilo6 {font-size: x-small}
    .Estilo7 {font-family: tahoma; font-size: x-small; }
    .Estilo8 {font-size: xx-small}
    -->
</style>


<form name="form1" method="post" action="creardocente.php">
    <div align="center">
        <p><br>
            <span class="Estilo5 style7"><strong>CREACI&Oacute;N Y MODIFICACI&Oacute;N DE DOCENTES</strong></span></p>
        <p class="Estilo5">&nbsp;
        </p>
    </div>
    <table width="80%"  border="0" align="center" cellpadding="2" cellspacing="2">
        <tr>
            <td width="26%" align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>Nro documento</strong></span></td>
            <td width="74%" class="Estilo7"><span class="Estilo3"><span class="style5">
                        <input name="numerodocumento" id="numerodocumento" type="text" value="<?php echo $_POST['numerodocumento']; ?>" size="23">
                        <?php
                        $grabar = 0;
                        if (!eregi("^[0-9]{1,15}$", $_POST['numerodocumento']) and ( $_POST['consultar'] == true or $_POST['guardar'] == true)) {
                            echo "Documento Incorrecto";
                            $grabar = 1;
                        }
                        ?>
                    </span></span></td>
        </tr>
        <tr>
            <?php
            if ($_POST['consultar'] == false and $_POST['guardar'] == false) {
                echo "<td ><p align='left'><input type='submit' name='consultar' value='Consultar'></p><td>";
                exit();
            } else
            if ($_POST['consultar'] == true or $_POST['guardar'] == true) { // else
                if ($_POST['consultar']) {
                    $indicador = 0;
                } else {
                    $indicador = 1;
                }
                if ($_POST['consultar'] or $_POST['guardar']) {
                    mysql_select_db($database_conexion, $sala);

                    $sqladmdoc = "SELECT  * from administrativosdocentes where numerodocumento = '" . $_POST['numerodocumento'] . "' ";
                    $resultado = mysql_query($sqladmdoc, $sala);
                    $row_admdoc = mysql_fetch_assoc($resultado);
                    if ($row_admdoc <> "") {
                        $query_docente = "SELECT * FROM docente where numerodocumento = '" . $_POST['numerodocumento'] . "' ";
                        $docente = mysql_query($query_docente, $sala) or die(mysql_error());
                        $row_docente = mysql_fetch_assoc($docente);
                        $totalRows_docente = mysql_num_rows($docente);
                        /*
                         * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
                         * Se agrega esta validacion para los docentes que se encuentren inactivos
                         * @since Noviembre 27, 2019
                         */
                        if ($row_docente <> "") {
                            if ($row_docente['codigoestado'] == 200) {
                                echo '<script language="JavaScript">';
                                echo 'alert("Docente ya existe y se encuentra inactivo, por favor dirigirse a Talento Humano");';
                                echo 'window.close();';
                                echo '</script>';
                            } else {
                                $update = 1;
                            }
                        } else {
                            $grabar = 3;
                            $update = 2;
                        }
                    } else {
                        echo '<script language="JavaScript">';
                        echo 'alert("Docente no esta creado por favor dirigirse a talento hunano");';
                        echo 'window.close();';
                        echo '</script>';
                    }
                }
                ?>
            <div align="left"></div>
            </tr>
            <tr>
                <td align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>Tipo documento</strong></span></td>
                <td class="Estilo5"><span class="Estilo4 Estilo6">
                        <select name="tipodocumento" id="tipodocumento">
                            <?php
                            do {
                                ?>
                                <option value="<?php echo $row_Recordset1['tipodocumento'] ?>"<?php
                                        if (!(strcmp($row_Recordset1['tipodocumento'], $row_docente['tipodocumento']))) {
                                            echo "SELECTED";
                                        }
                                        ?>><?php echo $row_Recordset1['nombredocumento'] ?></option>
                                        <?php
                                    } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1));
                                    $rows = mysql_num_rows($Recordset1);
                                    if ($rows > 0) {
                                        mysql_data_seek($Recordset1, 0);
                                        $row_Recordset1 = mysql_fetch_assoc($Recordset1);
                                    }
                                    ?>
                        </select>
                        <?php
                        if ($_POST['consultar'] or $_POST['guardar']) {
                            if ($_POST['tipodocumento'] == 0 and $indicador == 1) {
                                echo "Campo Requerido";
                                $grabar = 1;
                            }
                            ?>
                        </span></td>
                </tr>
                <tr>
                    <td align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>Genero</strong></span></td>
                    <td class="Estilo5"><span class="Estilo4 Estilo6">
                            <select name="genero" id="genero">
                                <OPTION value="100" <?php if ($row_docente['codigogenero'] == '100') echo "selected=true" ?> >Femenino</OPTION>
                                <OPTION value="200" <?php if ($row_docente['codigogenero'] == '200') echo "selected=true" ?>>Masculino</OPTION>
                            </select>	
                        </span></td>
                </tr>
                <tr>
                    <td align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>Apellidos</strong></span></td>
                    <td class="Estilo5"><span class="Estilo3 Estilo6">
                            <input name="apellidos" id="apellidos" type="text" value="<?php if ($row_docente <> "")
                                echo $row_docente['apellidodocente'];
                            else
                                echo $_POST['apellidos'];
                            ?>" size="23">
                            <?php
                            if ($_POST['apellidos'] == "" and $indicador == 1) {
                                echo "Por favor coloque los apellidos";
                                $grabar = 1;
                            }
                            ?>
                        </span></td>
                </tr>
                <tr>
                    <td align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>Nombres</strong></span></td>
                    <td class="Estilo5"><span class="Estilo3 Estilo6">
                            <input name="nombres" id="nombres" type="text" value="<?php if ($row_docente <> "")
                                echo $row_docente['nombredocente'];
                            else
                                echo $_POST['nombres'];
                            ?>" size="23">
                            <?php
                            if ($_POST['nombres'] == "" and $indicador == 1) {
                                echo "Por favor coloque los nombres";
                                $grabar = 1;
                            }
                            ?>
                        </span></td>
                </tr>
                <tr>
                    <td align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>C&oacute;digo Nomina &oacute; Nro Documento </strong></span></td>
                    <td class="Estilo5"><span class="Estilo3 Estilo6">
                            <input name="codigousuario" id="codigousuario" type="text" value="<?php if ($row_docente <> "")
                               echo $row_docente['codigodocente'];
                           else
                               echo $_POST['codigousuario'];
                           ?>" size="23">
                                   <?php
                                   if (!eregi("^[0-9]{1,15}$", $_POST['codigousuario']) and $indicador == 1) {
                                       echo "Debe colocar el código del Docente";
                                       $grabar = 1;
                                   }
                                   ?>
                        </span></td>
                </tr>
                <tr>
                    <td align="right" class="Estilo5" bgcolor="#C6CFD0"><span class="Estilo2 Estilo8"><strong>E-mail Docente</strong></span></td>
                    <td class="Estilo5"><span class="Estilo3 Estilo6">
                            <input name="email" id="email" type="text" value="<?php if ($row_docente <> "")
                               echo $row_docente['emaildocente'];
                           else
                               echo $_POST['email'];
                           ?>" size="23">
        <?php
        $email = "^[A-z0-9\._-]+@[A-z0-9][A-z0-9-]*(\.[A-z0-9_-]+)*\.([A-z]{2,6})$";


        if (!eregi($email, $_POST['email']) and $indicador == 1 and $_POST['email'] <> "") {
            echo "E-mail Incorrecto";
            $grabar = 1;
        }
        ?>
                        </span></td>
                </tr>
                <tr>
                    <td colspan="2" align="right" class="Estilo5"><div align="center" class="Estilo6">
                            <div align="left">
                                <input name="guardar" type="submit" id="Submit22" value="Guardar">&nbsp;
                                <input type="submit" name="actualizar" value="Restablecer">&nbsp;
                                <input type="button" name="Submit" onClick="window.close()" value="Cerrar">
                            </div>
                        </div></td>
                </tr>    
                <?php
            } 
        } 

        if (($_POST['guardar'] and $grabar == 0) or ( $grabar == 3)) {
            if ($update == 2) {
                if ($row_admdoc <> "") {

                    $sql = "insert into docente (codigodocente,codigogenero,apellidodocente,nombredocente,tipodocumento,numerodocumento,clavedocente,emaildocente)";
                    $sql .= "VALUES('" . $_POST['numerodocumento'] . "','" . $row_admdoc['codigogenero'] . "','" . $row_admdoc['apellidosadministrativosdocentes'] . "','" . $row_admdoc['nombresadministrativosdocentes'] . "','" . $row_admdoc['tipodocumento'] . "','" . $row_admdoc['numerodocumento'] . "','0','" . $row_admdoc['emailadministrativosdocentes'] . "')";
                    $result = mysql_query($sql, $sala);
                    verificaconSalaInterno($row_admdoc['tipodocumento'], $row_admdoc['nombresadministrativosdocentes'], $row_admdoc['apellidosadministrativosdocentes'], $_POST['numerodocumento'], $sala);
                    mysql_select_db($database_conexion, $sala);
                    $query_docente = "SELECT * FROM docente where numerodocumento = '" . $_POST['numerodocumento'] . "' ";
                    $docente = mysql_query($query_docente, $sala) or die(mysql_error());
                    $row_docente = mysql_fetch_assoc($docente);
                    $totalRows_docente = mysql_num_rows($docente);

                    if ($row_docente <> "") {
                        ?>
                        <script language="JavaScript">
                            document.getElementById('tipodocumento').value = "<?php echo $row_admdoc['tipodocumento'] ?>";
                            document.getElementById('genero').value = "<?php echo $row_admdoc['codigogenero'] ?>";
                            document.getElementById('apellidos').value = "<?php echo $row_admdoc['apellidosadministrativosdocentes'] ?>";
                            document.getElementById('nombres').value = "<?php echo $row_admdoc['nombresadministrativosdocentes'] ?>";
                            document.getElementById('codigousuario').value = "<?php echo $_POST['numerodocumento'] ?>";
                            document.getElementById('email').value = "<?php echo $row_admdoc['emailadministrativosdocentes'] ?>";
                            alert("DOCENTE CREADO CON LA INFORMACION REGISTRADA POR TALENTO HUMANO");
                            window.close();
                        </script>
                        <?php
                    } else {
                        echo '<script language="JavaScript">';
                        echo 'alert("DOCENTE NO CREADO");';
                        echo 'window.close();';
                        echo '</script>';
                    }
                } else {
                    echo '<script language="JavaScript">';
                    echo 'alert("Docente no esta creado por favor dirigirse a talento hunano");';
                    echo 'window.close();';
                    echo '</script>';
                }
            } else if ($update == 1) {
                $base = "update docente
		        set codigodocente ='" . $_POST['codigousuario'] . "',
                            apellidodocente ='" . $_POST['apellidos'] . "',
                            nombredocente ='" . $_POST['nombres'] . "',
                            codigogenero ='" . $_POST['genero'] . "',
                            tipodocumento ='" . $_POST['tipodocumento'] . "',
                            numerodocumento ='" . $_POST['numerodocumento'] . "',				
                            emaildocente ='" . $_POST['email'] . "'
                            where numerodocumento ='" . $_POST['numerodocumento'] . "'";
                
                $sol = mysql_db_query($database_sala, $base);
                verificaconSalaInterno($_POST['tipodocumento'], $_POST['nombres'], $_POST['apellidos'], $_POST['numerodocumento'], $sala);
                echo '<script language="JavaScript">';
                echo 'alert("DOCENTE MODIFICADO");';
                echo 'window.close();';
                echo '</script>';
            }
        }
        ?>
    </table>
    <div align="center"></div>
</form>
