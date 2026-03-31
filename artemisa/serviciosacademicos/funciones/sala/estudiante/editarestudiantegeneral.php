<?php
/*
 * borrardo de codigo y formateo
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Modificado 21 de Septiembre de 2017.
 */
global $db;
$query_selgenero = "select codigogenero, nombregenero
		from genero";
$selgenero = $db->Execute($query_selgenero);
$totalRows_selgenero = $selgenero->RecordCount();
$row_selgenero = $selgenero->FetchRow();
$query_trato = "select *
		from trato";
$trato = $db->Execute($query_trato);
$totalRows_trato = $trato->RecordCount();
$row_trato = $trato->FetchRow();
$query_documentos = "SELECT *
		FROM documento
		WHERE codigoestado like '1%'";
$documentos = $db->Execute($query_documentos);
$totalRows_documentos = $documentos->RecordCount();
$row_documentos = $documentos->FetchRow();
/*
 * @modified Luis Dario Gualteros C.
 * <castroluisd@unbosque.edu.co>
 * Se modifica la consulta de estado civil para que no muestre el estado civil 7 que pertenece a Vacio.
 * @since  December 15, 2016
 */
$query_estadocivil = "SELECT *
		FROM estadocivil WHERE idestadocivil <> 7";
$estadocivil = $db->Execute($query_estadocivil);
$totalRows_estadocivil = $estadocivil->RecordCount();
$row_estadocivil = $estadocivil->FetchRow();
// End Modificación.
$query_modalidad = "SELECT *
		FROM modalidadacademica order by 1";
$modalidad = $db->Execute($query_modalidad);
$totalRows_modalidad = $modalidad->RecordCount();
$row_modalidad = $modalidad->FetchRow();
$query_ciudad = "select *
		from ciudad c,departamento d
		where c.iddepartamento = d.iddepartamento
		order by 3";
$ciudad = $db->Execute($query_ciudad);
$totalRows_ciudad = $ciudad->RecordCount();
$row_ciudad = $ciudad->FetchRow();
$query_parentesco = "select *
		from tipoestudiantefamilia
		where idtipoestudiantefamilia <> 0
		order by 2";
$parentesco = $db->Execute($query_parentesco);
$query_parentesco2 = "select *
		from tipoestudiantefamilia
		where idtipoestudiantefamilia <> 0 AND idtipoestudiantefamilia IN (1,2) 
		order by 2";
$parentesco2 = $db->Execute($query_parentesco2);
$totalRows_parentesco = $parentesco->RecordCount();
$row_parentesco = $parentesco->FetchRow();
$query_estbarrio = "select *
		from estudiantebarrio
		where idestudiantegeneral = '" . $this->idestudiantegeneral . "'
		and codigoestado like '1%'
		order by 1";
$estbarrio = $db->Execute($query_estbarrio);
$totalRows_estbarrio = $estbarrio->RecordCount();
$row_estbarrio = $estbarrio->FetchRow();
$query_estextranjero = "select *
		from estudianteextranjero
		where idestudiantegeneral = '" . $this->idestudiantegeneral . "'
		and codigoestado like '1%'
		order by 1";
$estextranjero = $db->Execute($query_estextranjero);
$totalRows_estextranjero = $estextranjero->RecordCount();
$row_estextranjero = $estextranjero->FetchRow();
$query_localidad = "select *
		from localidad
		where codigoestado like '1%'
		order by 1";
$localidad = $db->Execute($query_localidad);
$totalRows_localidad = $localidad->RecordCount();
$row_localidad = $localidad->FetchRow();
$query_hijoEgresado = "select * 
		from PadreEgresadoEstudiantes 
		where idestudiantegeneral = '" . $this->idestudiantegeneral . "' 
		and codigoestado like '1%' 
		order by 1";
$hijoegresado = $db->Execute($query_hijoEgresado);
$totalRows_hijoegresado = $hijoegresado->RecordCount();
$row_hijoegresado = $hijoegresado->FetchRow();
/*
 * Query de consulta de rol de usuario
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Agregado 21 de Septiembre de 2017.
 */
$usuario = $_SESSION['MM_Username'];
$slqrol = "SELECT rol.idrol FROM usuario u 
            INNER JOIN UsuarioTipo ut on ut.UsuarioId = u.idusuario 
            INNER JOIN usuariorol rol on rol.idusuariotipo = ut.UsuarioTipoId WHERE
            u.usuario = '" . $usuario . "'";
$RolData = $db->GetRow($slqrol);
$Rol = $RolData['idrol'];
//end
?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <?php
    /*
     * Query y arreglo para estudiantes en situacion graduado
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Agregado 21 de Septiembre de 2017.
     */
    $querysituacionestudiantegeneral = 'SELECT codigosituacioncarreraestudiante ';
    $querysituacionestudiantegeneral .= 'FROM estudiante e ';
    $querysituacionestudiantegeneral .= 'INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral ';
    $querysituacionestudiantegeneral .= 'WHERE eg.numerodocumento="' . $this->numerodocumento . '" ';
    $selsituacionestudiantegeneral = $db->Execute($querysituacionestudiantegeneral);
    $totalRows_selsituacionestudiantegeneral = $selsituacionestudiantegeneral->RecordCount();
    $acum = '';
    while ($row_selsituacionestudiantegeneral = $selsituacionestudiantegeneral->FetchRow()) {
        $acum .= $row_selsituacionestudiantegeneral['codigosituacioncarreraestudiante'] . ',';
    }
    $tacum = substr($acum, 0, -1);
    $arreglo = array($tacum);
    ?>
    <tr>
        <td id="tdtitulogris">
            Trato personal
            <select name="trato" id="requerido">

                <option value="0" <?php
                if (!(strcmp("0", $this->idtrato))) {
                    echo "SELECTED";
                }
                ?>>Trato</option>
                <?php
                do {
                    ?>              <option value="<?php echo $row_trato['idtrato'] ?>"<?php
                            if (!(strcmp($row_trato['idtrato'], $this->idtrato))) {
                                echo "SELECTED";
                            }
                            ?>><?php echo $row_trato['inicialestrato'] ?></option>
    <?php
} while ($row_trato = $trato->FetchRow());
?>
            </select>
        </td>
        <td id="tdtitulogris">Nombre<label id="labelresaltado">*</label>
            <?php
            /*
             * If de rol de usuario si es 13 es editable (estudiante graduado) de lo contrario no
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Agregado 21 de Septiembre de 2017.
             */
            if ($Rol == 13) {
            ?>
            <input name="nombres" type="text" id="requerido" size="25" maxlength="50" value="<?php if (isset($_POST['nombres'])) echo $_POST['nombres'];
            else echo $this->nombresestudiantegeneral; ?>"> </td>
        <?php
        }else {
            /*
             * Switch de arreglo para estudiantes en situacion graduado
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Agregado 21 de Septiembre de 2017.
             */
            switch ($arreglo) {
                default:
                    ?>
                    <input name="nombres" type="text" id="requerido" size="25" maxlength="50" value="<?php if (isset($_POST['nombres'])) echo $_POST['nombres'];
                    else echo $this->nombresestudiantegeneral; ?>"> </td>
                    <?php
                    break;
                case in_array(400, $arreglo)://graduado
                    ?>
                    <input name="nombres" type="hidden" id="requerido" size="25" maxlength="50" value="<?php if (isset($_POST['nombres'])) echo $_POST['nombres'];
                    else echo $this->nombresestudiantegeneral; ?>">
                    <input name="nombres1" type="text" id="requerido" size="25" maxlength="50" value="<?php if (isset($_POST['nombres'])) echo $_POST['nombres'];
                    else echo $this->nombresestudiantegeneral; ?>" disabled>
                    <?php
                    break;
            }
            //end
        }
        //end
        ?>
        </td>

    <td id="tdtitulogris">Apellidos<label id="labelresaltado">*</label>
        <?php
        /*
         * If de rol de usuario si es 13 es editable (estudiante graduado) de lo contrario no
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Agregado 21 de Septiembre de 2017.
         */
        if ($Rol == 13) {
            ?>
            <input name="apellidos" type="text" id="requerido" size="30" maxlength="50"  value="<?php if (isset($this->apellidosestudiantegeneral)) echo $this->apellidosestudiantegeneral;
            else echo $_POST['apellidos']; ?>">
            <?php
        }else {
            /*
             * Switch de arreglo para estudiantes en situacion graduado
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Agregado 21 de Septiembre de 2017.
             */
            switch ($arreglo) {
                default:
                    ?>
                    <input name="apellidos" type="text" id="requerido" size="30" maxlength="50"  value="<?php if (isset($this->apellidosestudiantegeneral)) echo $this->apellidosestudiantegeneral;
                    else echo $_POST['apellidos']; ?>">
                    <?php
                    break;
                case in_array(400, $arreglo)://graduado
                    ?>
                    <input name="apellidos" type="hidden" id="requerido" size="30" maxlength="50"  value="<?php if (isset($this->apellidosestudiantegeneral)) echo $this->apellidosestudiantegeneral;
                    else echo $_POST['apellidos']; ?>">
                    <input name="apellidos1" type="text" id="requerido" size="30" maxlength="50"  value="<?php if (isset($this->apellidosestudiantegeneral)) echo $this->apellidosestudiantegeneral;
                    else echo $_POST['apellidos']; ?>" disabled>
                    <?php
                    break;
            }
            //end
        }
        //end
        ?>

    </td>

        <td colspan="" id="tdtitulogris">Tipo Documento<label id="labelresaltado">*</label>
            <?php
            /*
             * If de rol de usuario si es 13 es editable (estudiante graduado) de lo contrario no
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Agregado 21 de Septiembre de 2017.
             */
            if ($Rol == 13) {
                ?>
                <select name="tipodocumento" id="requerido">
                    <?php
                    do {
                        ?>
                        <option value="<?php echo $row_documentos['tipodocumento'] ?>"<?php
                        if (!(strcmp($row_documentos['tipodocumento'], $this->tipodocumento))) {
                            echo "SELECTED";
                        }
                        ?>><?php echo $row_documentos['nombredocumento'] ?></option>
                        <?php
                    } while ($row_documentos = $documentos->FetchRow());
                    ?>
                </select>
                <?php
            } else {
                /*
                 * Switch de arreglo para estudiantes en situacion graduado
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Agregado 21 de Septiembre de 2017.
                 */
                switch ($arreglo) {
                    default:
                        ?>
                        <select name="tipodocumento" id="requerido">
                            <?php
                            do {
                                ?>
                                <option value="<?php echo $row_documentos['tipodocumento'] ?>"<?php
                                if (!(strcmp($row_documentos['tipodocumento'], $this->tipodocumento))) {
                                    echo "SELECTED";
                                }
                                ?>><?php echo $row_documentos['nombredocumento'] ?></option>
                                <?php
                            } while ($row_documentos = $documentos->FetchRow());
                            ?>
                        </select>
                        <?php
                        break;
                    case in_array(400, $arreglo)://graduado
                        /*
                         * Query que trae el nombre del tipo de documento para estudiantes en situacion graduado
                         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                         * Universidad el Bosque - Direccion de Tecnologia.
                         * Agregado 21 de Septiembre de 2017.
                         */
                        $query_nomdocu = 'SELECT nombredocumento ';
                        $query_nomdocu .= 'FROM documento ';
                        $query_nomdocu .= 'WHERE tipodocumento="' . $this->tipodocumento . '" ';
                        $query_nomdocu .= '';
                        $nomdocu = $db->Execute($query_nomdocu);
                        $totalRows_nomdocu = $nomdocu->RecordCount();
                        $row_nomdocu = $nomdocu->FetchRow();
                        ?>
                        <input name="tipodocumento" type="hidden" id="requerido" size="11" maxlength="12" value="<?php if (isset($this->tipodocumento)) echo $this->tipodocumento;
                        else echo $_POST['tipodocumento']; ?>">
                        <input name="tipodocumento1" type="text" id="requerido" size="25" maxlength="50" value="<?php echo $row_nomdocu['nombredocumento']; ?>" disabled>
                        <?php
                        break;
                }
                //end
            }
            //end
            ?>

        </td>
        <td id="tdtitulogris">No. Documento<label id="labelresaltado">*</label>
            <?php
            /*
             * If de rol de usuario si es 13 es editable (estudiante graduado) de lo contrario no
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Agregado 21 de Septiembre de 2017.
             */
            if ($Rol == 13) {
                ?>
                <input name="numerodocumento" type="text" id="requerido" size="" maxlength="12" value="<?php if (isset($this->numerodocumento)) echo $this->numerodocumento;
                else echo $_POST['numerodocumento']; ?>">
                <?php
            }else {
                /*
                 * Switch de arreglo para estudiantes en situacion graduado
                 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
                 * Universidad el Bosque - Direccion de Tecnologia.
                 * Agregado 21 de Septiembre de 2017.
                 */
                switch ($arreglo) {
                    default:
                        ?>
                        <input name="numerodocumento" type="text" id="requerido" size="" maxlength="12" value="<?php if (isset($this->numerodocumento)) echo $this->numerodocumento;
                        else echo $_POST['numerodocumento']; ?>">
                        <?php
                        break;
                    case in_array(400, $arreglo)://graduado
                        ?>
                        <input name="numerodocumento" type="hidden" id="requerido" size="" maxlength="12" value="<?php if (isset($this->numerodocumento)) echo $this->numerodocumento;
                        else echo $_POST['numerodocumento']; ?>">
                        <input name="numerodocumento1" type="text" id="requerido" size="" maxlength="12" value="<?php if (isset($this->numerodocumento)) echo $this->numerodocumento;
                        else echo $_POST['numerodocumento']; ?>" disabled>
                        <?php
                        break;
                }
                //end
            }
            //end
            ?>
        </td>
</tr>

<tr>
    <td id="tdtitulogris" colspan="2">Lugar Expedición doc.<label id="labelresaltado">*</label>
        <?php
        /*
         * If de rol de usuario si es 13 es editable (estudiante graduado) de lo contrario no
         * Vega Gabriel <vegagabriel@unbosque.edu.do>.
         * Universidad el Bosque - Direccion de Tecnologia.
         * Agregado 21 de Septiembre de 2017.
         */
        if ($Rol == 13) {
            ?>
            <input name="expedidodocumento" type="text" id="requerido" size="" maxlength="15" value="<?php if ($this->expedidodocumento <> "") echo $this->expedidodocumento;
            else echo $_POST['expedidodocumento']; ?>">
            <?php
        }else {
            /*
             * Switch de arreglo para estudiantes en situacion graduado
             * Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Universidad el Bosque - Direccion de Tecnologia.
             * Agregado 21 de Septiembre de 2017.
             */
            switch ($arreglo) {
                default:
                    ?>
                    <input name="expedidodocumento" type="text" id="requerido" size="" maxlength="15" value="<?php if ($this->expedidodocumento <> "") echo $this->expedidodocumento;
                    else echo $_POST['expedidodocumento']; ?>">
                    <?php
                    break;
                case in_array(400, $arreglo)://graduado
                    ?>
                    <input name="expedidodocumento" type="hidden" id="requerido" size="" maxlength="15" value="<?php if ($this->expedidodocumento <> "") echo $this->expedidodocumento;
                    else echo $_POST['expedidodocumento']; ?>">
                    <input name="expedidodocumento1" type="text" id="requerido" size="" maxlength="15" value="<?php if ($this->expedidodocumento <> "") echo $this->expedidodocumento;
                    else echo $_POST['expedidodocumento']; ?>" disabled>
                    <?php
                    break;
            }
            //end
        }
        //end
        //end
        ?>

    </td>
    <td colspan="" id="tdtitulogris">G&eacute;nero<label id="labelresaltado">*</label>
        <select name="genero" id="requerido" style="width: 80%" >
            <option value="0" <?php
            if (!(strcmp(0, $this->codigogenero)) || $row_selgenero['codigogenero'] == null) {
                echo "SELECTED";
            }
            ?>>Seleccionar</option>
            <?php
            do {
                ?>
                <option value="<?php echo $row_selgenero['codigogenero'] ?>"<?php
                if (!(strcmp($row_selgenero['codigogenero'], $this->codigogenero))) {
                    echo "SELECTED";
                }
                ?>><?php echo $row_selgenero['nombregenero'] ?></option>
                <?php
            } while ($row_selgenero = $selgenero->FetchRow());
            ?>
        </select>
    </td>

    <td id="tdtitulogris">Estado Civil<label id="labelresaltado">*</label>
        <select name="civil" id="requerido">
            <?php
            do {
                ?>
                <option value="<?php echo $row_estadocivil['idestadocivil'] ?>"<?php
                if (!(strcmp($row_estadocivil['idestadocivil'], $this->idestadocivil))) {
                    echo "SELECTED";
                }
                ?>><?php echo $row_estadocivil['nombreestadocivil'] ?></option>
                <?php
            } while ($row_estadocivil = $estadocivil->FetchRow());
            ?>
        </select>
    </td>

    <td id="tdtitulogris" colspan="2">Estrato<label id="labelresaltado">*</label>
        <?php
        $query_estrato = "select *
from estrato
order by 1";
        $estrato = $db->Execute($query_estrato);
        $totalRows_estrato = $estrato->RecordCount();

        $query_estratohistorico = "select *
from estratohistorico
where idestudiantegeneral = '" . $this->idestudiantegeneral . "'
and codigoestado like '1%'
order by 1";
        $estratohistorico = $db->Execute($query_estratohistorico);
        $totalRows_estratohistorico = $estratohistorico->RecordCount();
        $row_estratohistorico = $estratohistorico->FetchRow();
        ?>
        <select name="idestrato"  style="width: 80%">
            <option value="">Seleccionar...</option>
            <?php
            while ($row_estrato = $estrato->FetchRow()) {
                ?>
                <option value="<?php echo $row_estrato['idestrato']; ?>" <?php
                if (isset($_POST['idestrato'])) {
                    if ($_POST['idestrato'] == $row_estrato['idestrato'])
                        echo "selected";
                } else if ($row_estrato['idestrato'] == $row_estratohistorico['idestrato'])
                    echo "selected";
                ?>><?php echo $row_estrato['nombreestrato']; ?></option>
                <?php
            }
            ?>
        </select>
    </td>
</tr>
<tr>
    <td colspan="3" id="tdtitulogris">Lugar Nacimiento <label id="labelresaltado">*</label>
        (Si usted es extranjero seleccione en el menú EXTRANJERO)
        <select name="ciudadnacimiento" id="ciudadnacimiento" onchange="if (this.value == '2000') {
                    estextranjero.style.display = '';
                    requeridodireccion.readOnly = false;
                } else {
                    estextranjero.style.display = 'none';
                    requeridodireccion.readOnly = true;
                }">
            <option value="0" <?php
            if (!(strcmp("0", $this->idciudadnacimiento))) {
                echo "SELECTED";
            }
            ?>>Seleccionar</option>
            <?php
            do {
                ?>
                <option value="<?php echo $row_ciudad['idciudad'] ?>"<?php
                if (!(strcmp($row_ciudad['idciudad'], $this->idciudadnacimiento))) {
                    echo "SELECTED";
                }
                ?>><?php echo $row_ciudad['nombreciudad']; ?></option>
                <?php
            } while ($row_ciudad = $ciudad->FetchRow());
            $ciudad->Move(0);
            ?>
        </select>
        <div id="estextranjero" style="display:none">Debe digitar el lugar de nacimiento *
            <input type="text" value="<?php if (isset($_POST['estudianteextranjero'])) echo $_POST['estudianteextranjero'];
            else echo $row_estextranjero['estudianteextranjero']; ?>" name="estudianteextranjero">
        </div>
        <?php
        if ($this->idciudadnacimiento == 2000) {
            ?>
            <script language="JavaScript">
                estextranjero.style.display = '';
            </script>
            <?php
        }
        ?>
    </td>

    <td id="tdtitulogris">Fecha Nacimiento<label id="labelresaltado">*</label>
        <input name="fecha1" type="text" id="requerido" size="10" value="<?php
        $fechanacimientoestudiantegeneral = explode(" ", $this->fechanacimientoestudiantegeneral);
        if (isset($this->fechanacimientoestudiantegeneral))
            echo $fechanacimientoestudiantegeneral[0];
        else
            echo $_POST['fecha1']
        ?>" maxlength="10" onchange="calcular_edad()">
        aaaa-mm-dd
    </td>
    <td id="tdtitulogris">Edad
        <input name="edad1" type="text" style="width: 80%" value="" maxlength="3">
    </td>
</tr>
<tr>
    <td colspan="2" id="tdtitulogris">Direcci&oacute;n Residencia<label id="labelresaltado">*</label>
        <input name="direccion1" size="80%" id="requeridodireccion"  onclick=""  value="<?php if (isset($_POST['direccion1'])) echo $_POST['direccion1'];
        else echo $this->direccionresidenciaestudiantegeneral; ?>">
        <input name="direccion1oculta" type="hidden" value="<?php if (isset($_POST['direccion1oculta'])) echo $_POST['direccion1oculta'];
        else echo $this->direccioncortaresidenciaestudiantegeneral; ?>">
    </td>
    <td id="tdtitulogris">Tel&eacute;fono Residencia<label id="labelresaltado">*</label>
        <input name="telefono1" type="text" id="requerido" size="15" maxlength="50" value="<?php if (isset($this->telefonoresidenciaestudiantegeneral)) echo $this->telefonoresidenciaestudiantegeneral;
        else echo $_POST['telefono1']; ?>">
    </td>
    <td id="tdtitulogris" colspan="2">Ciudad<label id="labelresaltado">*</label>
        <select name="ciudad1" id="requerido" onchange="if (this.value == '359') {
                    bogotabarrio.style.display = '';
                } else {
                    bogotabarrio.style.display = 'none'; }">
            <option value="0" <?php
            if (!(strcmp("0", $this->ciudadresidenciaestudiantegeneral))) {
                echo "SELECTED";
            }
            ?>>Seleccionar</option>
            <?php
            do {
                ?>
                <option value="<?php echo $row_ciudad['idciudad'] ?>"<?php
                if (!(strcmp($row_ciudad['idciudad'], $this->ciudadresidenciaestudiantegeneral))) {
                    echo "SELECTED";
                }
                ?>><?php echo $row_ciudad['nombreciudad']; ?></option>
                <?php
            } while ($row_ciudad = $ciudad->FetchRow());
            $ciudad->Move(0);
            ?>
        </select>
        <div id="bogotabarrio" style="display:none">Debe seleccionar una localidad*
            <select name="estudiantebarrio" id="requerido">
                <option value="" <?php
                if (!isset($_REQUEST['estudiantebarrio'])) {
                    echo "SELECTED";
                }
                ?>>Seleccione la localidad</option>
                <?php
                do {
                    ?>              <option value="<?php echo $row_localidad['nombrelocalidad'] ?>"<?php
                    if (!(strcmp($row_localidad['nombrelocalidad'], $row_estbarrio['estudiantebarrio']))) {
                        echo "SELECTED";
                    }
                    ?>><?php echo $row_localidad['nombrelocalidad'] ?></option>
                    <?php
                } while ($row_localidad = $localidad->FetchRow());
                ?>
            </select>
        </div>
        <?php
        if ($this->ciudadresidenciaestudiantegeneral == 359) {
            ?>
            <script language="JavaScript">
                bogotabarrio.style.display = '';
            </script>
            <?php
        }
        ?>
    </td>
</tr>
<tr>
    <td colspan="2" id="tdtitulogris">E-mail 1 <label id="labelresaltado">*</label>
        <font size="2" face="Tahoma"><input name="email" type="text" id="requerido" size="35" maxlength="50" value="<?php if (isset($_POST['email'])) echo $_POST['email'];
            else echo $this->emailestudiantegeneral; ?>"></font>
    </td>
    <td id="tdtitulogris">E-mail 2
        <span class="style1"><input name="email2" type="text" id="email2" size="20" maxlength="50" value="<?php if (isset($_POST['email2'])) echo $_POST['email2'];
            else echo $this->email2estudiantegeneral; ?>">
    </td>
            <td id="tdtitulogris" colspan="2">Celular  <label id="labelresaltado">*</label>
                <input name="celular" style="width: 60%" type="text" id="celular" maxlength="50" value="<?php if (isset($_POST['celular'])) echo $_POST['celular'];
                else echo $this->celularestudiantegeneral; ?>">
            </td>
</tr>
<tr>
    <td colspan="2" rowspan="2" id="tdtitulogris">En caso de EmergenciaLlamar a
        <input name="emergencia" type="text" id="" style="width: 80%" maxlength="70" value="<?php if (isset($_POST['emergencia'])) echo $_POST['emergencia'];
        else echo $this->casoemergenciallamarestudiantegeneral; ?>">
    </td>
    <td rowspan="2"  id="tdtitulogris">Parentesco
        <select name="parentesco" id="" style="width: 80%">
            <option value="0" <?php
            if (!(strcmp("0", $this->idtipoestudiantefamilia))) {
                echo "SELECTED";
            }
            ?>>Seleccionar</option>
            <?php
            do {
                ?>
                <option value="<?php echo $row_parentesco['idtipoestudiantefamilia'] ?>"<?php
                if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $this->idtipoestudiantefamilia))) {
                    echo "SELECTED";
                }
                ?>><?php echo $row_parentesco['nombretipoestudiantefamilia'] ?></option>
                <?php
            } while ($row_parentesco = $parentesco->FetchRow());
            ?>
        </select>
    </td>

    <td id="tdtitulogris" colspan="2">Tel&eacute;fono 1
        <input name="telemergencia1" style="width: 60%" type="text" id=""  maxlength="50" value="<?php if (isset($_POST['telemergencia1'])) echo $_POST['telemergencia1'];
        else echo $this->telefono1casoemergenciallamarestudiantegeneral; ?>">
    </td>
</tr>
<tr>
    <td id="tdtitulogris" colspan="2">Tel&eacute;fono 2
        <input name="telemergencia2" type="text" style="width: 60%" maxlength="50" value="<?php if (isset($_POST['telemergencia2'])) echo $_POST['telemergencia2'];
        else echo $this->telefono2casoemergenciallamarestudiantegeneral; ?>">
    </td>
</tr>
<tr>
    <td colspan="" rowspan="1" id="tdtitulogris">¿Es hijo de un egresado de la Universdidad El Bosque?
        <label id="labelresaltado">*</label><br>
        <input type="radio" name="hijo_egresado" id="requerido" class="requerido" value="1" <?php if ($row_hijoegresado != false && ($row_hijoegresado['idestudiantegeneral'] == $this->idestudiantegeneral || $_POST["hijo_egresado"] == 1)) {
            echo "checked";
        } ?>>Si &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="radio" name="hijo_egresado" id="requerido" class="requerido" value="0" <?php if (($row_hijoegresado == false || $row_hijoegresado['idestudiantegeneral'] == null) && $this->expedidodocumento <> "" && $_POST["hijo_egresado"] <> 1) {
            echo "checked";
        } ?>>No
    </td>
    <td rowspan="1" ><strong>Nombre de familiar</strong><br/>
        <input name="familiar_egresado" type="text" size="45" maxlength="70" value="<?php if (isset($_POST['familiar_egresado'])) echo $_POST['familiar_egresado'];
else echo $row_hijoegresado['NombrePadreEgresado']; ?>"></td>			
    <td rowspan="1"  id="tdtitulogris"><strong>Parentesco</strong> <br/>
        <select name="parentesco_egresado" style="width: 80%">
<?php
do {
    ?>
                <option value="<?php echo $row_parentesco['idtipoestudiantefamilia'] ?>"<?php
    if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $row_hijoegresado['idtipoestudiantefamilia']))) {
        echo "SELECTED";
    }
    ?>><?php echo $row_parentesco['nombretipoestudiantefamilia'] ?></option>
    <?php
} while ($row_parentesco = $parentesco2->FetchRow());
?>
        </select></td>
    <td><strong>Número documento</strong><br/>
        <input name="documento_egresado" type="text" style="width: 60%" maxlength="70" value="<?php if (isset($_POST['documento_egresado'])) echo $_POST['documento_egresado'];
else echo $row_hijoegresado['NumeroDocumento']; ?>"></td>			
    <td><strong>Tel&eacute;fono
        </strong><br/><input name="telefono_egresado" type="number" style="width: 80%" maxlength="50" value="<?php if (isset($_POST['telefono_egresado'])) echo $_POST['telefono_egresado'];
else echo $row_hijoegresado['Telefono']; ?>"></td>
</tr>
<?php
/*
 * If de rol de usuario si es != 13 debe mostrar el mensaje
 * Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Universidad el Bosque - Direccion de Tecnologia.
 * Agregado 21 de Septiembre de 2017.
 */
if ($Rol != 13) {
    /*
     * Mostrar texto para estudiantes en situacion graduado
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Direccion de Tecnologia.
     * Modificado 21 de Septiembre de 2017.
     */
    switch ($arreglo) {
        case in_array(400, $arreglo)://graduado
            ?>
            <tr>
                <td height="26" align="center" colspan="7">
                    <font style="color:red; font-weight:bold;">
                        LOS CAMPOS SOMBREADOS NO PUEDEN SER MODIFICADOS DEBIDO A LA SITUACI&Oacute;N DE
                        GRADUADO DEL ESTUDIANTE EN ESTE U OTRO PROGRAMA ACADEMICO.
                    </font>
                </td>
            </tr>
            <?php
            break;
    }
    //end
}
//end
?>
</table>   
<!--end-->