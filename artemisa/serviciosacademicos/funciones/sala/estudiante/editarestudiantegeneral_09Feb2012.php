<?php
global $db;
//$db->debug = true;
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
		FROM documento";
$documentos = $db->Execute($query_documentos);
$totalRows_documentos = $documentos->RecordCount();
$row_documentos = $documentos->FetchRow();
$query_estadocivil = "SELECT *
		FROM estadocivil";
$estadocivil = $db->Execute($query_estadocivil);
$totalRows_estadocivil = $estadocivil->RecordCount();
$row_estadocivil = $estadocivil->FetchRow();
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
$totalRows_parentesco = $parentesco->RecordCount();
$row_parentesco = $parentesco->FetchRow();
$query_estbarrio = "select *
		from estudiantebarrio
		where idestudiantegeneral = '".$this->idestudiantegeneral."'
		and codigoestado like '1%'
		order by 1";
$estbarrio = $db->Execute($query_estbarrio);
$totalRows_estbarrio = $estbarrio->RecordCount();
$row_estbarrio = $estbarrio->FetchRow();
$query_estextranjero = "select *
		from estudianteextranjero
		where idestudiantegeneral = '".$this->idestudiantegeneral."'
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

?>
<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td id="tdtitulogris"><select name="trato" id="requerido">
                <option value="0" <?php if (!(strcmp("0", $this->idtrato))) {
                    echo "SELECTED";
                        } ?>>Trato</option>
                        <?php
                        do {
                    ?>              <option value="<?php echo $row_trato['idtrato']?>"<?php if (!(strcmp($row_trato['idtrato'], $this->idtrato))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_trato['inicialestrato']?></option>
                            <?php
                        }
                        while($row_trato = $trato->FetchRow());
                        ?>
            </select>
        </td>
        <td  id="tdtitulogris">Nombre<label id="labelresaltado">*</label></td>
        <td><input name="nombres" type="text" id="requerido" size="25" maxlength="50" value="<?php if(isset($_POST['nombres'])) echo $_POST['nombres']; else echo $this->nombresestudiantegeneral; ?>"> </td>
        <td id="tdtitulogris">Apellidos<label id="labelresaltado">*</label></td>
        <td colspan="3"><input name="apellidos" type="text" id="requerido" size="30" maxlength="50"  value="<?php if(isset($this->apellidosestudiantegeneral)) echo $this->apellidosestudiantegeneral; else echo $_POST['apellidos']; ?>"></td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Tipo Documento<label id="labelresaltado">*</label></td>
        <td><select name="tipodocumento" id="requerido">
                <?php
                do {
                    ?>
                <option value="<?php echo $row_documentos['tipodocumento']?>"<?php if (!(strcmp($row_documentos['tipodocumento'], $this->tipodocumento))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_documentos['nombredocumento']?></option>
                            <?php
                        }
                        while($row_documentos = $documentos->FetchRow());
                        ?>
            </select></td>
        <td id="tdtitulogris">No. Documento<label id="labelresaltado">*</label></td>
        <td>
            <input name="numerodocumento" type="text" id="requerido" size="11" maxlength="12" value="<?php if(isset($this->numerodocumento)) echo $this->numerodocumento; else echo $_POST['numerodocumento']; ?>">
        </td>
        <td id="tdtitulogris">Expedida en<label id="labelresaltado">*</label></td>
        <td><input name="expedidodocumento" type="text" id="requerido" size="12" maxlength="15" value="<?php if($this->expedidodocumento <> "") echo $this->expedidodocumento; else echo $_POST['expedidodocumento']; ?>"></td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Libreta Militar</td>
        <td>
            <input name="libreta" type="text" id="libreta" size="25" maxlength="50" value="<?php if(isset($_POST['libreta'])) echo $_POST['libreta']; else echo $this->numerolibretamilitar; ?>">
        </td>
        <td id="tdtitulogris">Distrito</td>
        <td>
            <input name="distrito" type="text" id="distrito" size="5" maxlength="2" value="<?php if(isset($_POST['distrito'])) echo $_POST['distrito']; else echo $this->numerodistritolibretamilitar; ?>">
        </td>
        <td id="tdtitulogris">Expedida en </td>
        <td><input name="expedidalibreta" type="text" id="expedidalibreta" size="12" maxlength="15" value="<?php if(isset($_POST['expedidalibreta'])) echo $_POST['expedidalibreta']; else echo $this->expedidalibretamilitar; ?>"></td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">G&eacute;nero<label id="labelresaltado">*</label></td>
        <td>
            <select name="genero" id="requerido">
                <option value="0" <?php if (!(strcmp(0, $this->codigogenero))) {
                    echo "SELECTED";
                        } ?>>Seleccionar</option>
                        <?php
                        do {
                            ?>
                <option value="<?php echo $row_selgenero['codigogenero']?>"<?php if (!(strcmp($row_selgenero['codigogenero'], $this->codigogenero))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_selgenero['nombregenero']?></option>
                            <?php
                        }
                        while($row_selgenero = $selgenero->FetchRow());
                        ?>
            </select>
        </td>
        <td id="tdtitulogris">Estado Civil<label id="labelresaltado">*</label></td>
        <td colspan="1">
            <strong></strong>
            <select name="civil" id="requerido">
                <option value="0" <?php if (!(strcmp(0, $this->idestadocivil))) {
                    echo "SELECTED";
                        } ?>>Seleccionar</option>
                        <?php
                        do {
                            ?>
                <option value="<?php echo $row_estadocivil['idestadocivil']?>"<?php if (!(strcmp($row_estadocivil['idestadocivil'], $this->idestadocivil))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_estadocivil['nombreestadocivil']?></option>
                            <?php
                        }
                        while($row_estadocivil = $estadocivil->FetchRow());
                        ?>
            </select>
        </td>
        <td id="tdtitulogris">Estrato<label id="labelresaltado">*</label></td>
        <td colspan="1">
            <?php
            $query_estrato = "select *
from estrato
order by 1";
            $estrato = $db->Execute($query_estrato);
            $totalRows_estrato = $estrato->RecordCount();

            $query_estratohistorico = "select *
from estratohistorico
where idestudiantegeneral = '".$this->idestudiantegeneral."'
and codigoestado like '1%'
order by 1";
            $estratohistorico = $db->Execute($query_estratohistorico);
            $totalRows_estratohistorico = $estratohistorico->RecordCount();
            $row_estratohistorico = $estratohistorico->FetchRow();
            ?>
            <select name="idestrato">
                <option value="">Seleccionar...</option>
                <?php
                while($row_estrato = $estrato->FetchRow()) {
//echo $_POST['idestrato'];
                    ?>
                <option value="<?php echo $row_estrato['idestrato']; ?>" <?php if(isset($_POST['idestrato'])) {
                        if($_POST['idestrato'] == $row_estrato['idestrato']) echo "selected";
                            } else if($row_estrato['idestrato'] == $row_estratohistorico['idestrato']) echo "selected"; ?>><?php echo $row_estrato['nombreestrato'];?></option>
                            <?php
                        }
                        ?>
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="1" id="tdtitulogris">Lugar Nacimiento <label id="labelresaltado">*</label></td>
        <td>
		(Si usted es extranjero seleccione en el menú EXTRANJERO)
            <select name="ciudadnacimiento" id="ciudadnacimiento" onchange="if(this.value == '2000'){ estextranjero.style.display=''; requeridodireccion.readOnly = false;} else {estextranjero.style.display='none'; requeridodireccion.readOnly = true;}">
                <option value="0" <?php if (!(strcmp("0", $this->idciudadnacimiento))) {
                    echo "SELECTED";
                        } ?>>Seleccionar</option>
                        <?php
                        do {
                            ?>
                <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $this->idciudadnacimiento))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_ciudad['nombreciudad'];?></option>
                            <?php
                        }
                        while($row_ciudad = $ciudad->FetchRow());
                        $ciudad->Move(0);
                        ?>
            </select>
            <div id="estextranjero" style="display:none">Debe digitar el lugar de nacimiento *
                <input type="text" value="<?php if(isset($_POST['estudianteextranjero'])) echo $_POST['estudianteextranjero']; else echo $row_estextranjero['estudianteextranjero']; ?>" name="estudianteextranjero">
            </div>
            <?php
            if ($this->idciudadnacimiento == 2000) {
                ?>
            <script language="JavaScript">
                estextranjero.style.display='';
            </script>
                <?php
            }
            ?>
                              <!-- <input type="button" name="nuevo" value="..." onClick="crear()"> -->
            <?php
//crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala2);?>
        </td>
        <td id="tdtitulogris">Fecha Nacimiento<label id="labelresaltado">*</label></td>
        <td colspan="2">
            <?php
            /*escribe_formulario_fecha_vacio("fecha1","inscripcion",$this->fechanacimientoestudiantegeneral']);*/
            ?>
            <input name="fecha1" type="text" id="requerido" size="10" value="<?php
            $fechanacimientoestudiantegeneral=explode(" ",$this->fechanacimientoestudiantegeneral);
                   if(isset($this->fechanacimientoestudiantegeneral)) echo $fechanacimientoestudiantegeneral[0]; else echo $_POST['fecha1']?>" maxlength="10" onchange="calcular_edad()">
	       aaaa-mm-dd  
        </td>
        <td id="tdtitulogris">Edad</td>
        <td colspan="1">
            <?php
            /*escribe_formulario_fecha_vacio("fecha1","inscripcion",$this->fechanacimientoestudiantegeneral']);*/
            ?>
            <input name="edad1" type="text" size="3" value="" maxlength="3" readonly>
        </td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Direcci&oacute;n Residencia<label id="labelresaltado">*</label></td>
        <td colspan="5">
            <INPUT name="direccion1" size="90" id="requeridodireccion" readonly onclick="if(ciudadnacimiento.value != '2000') { window.open('direccion.php?inscripcion=1','direccion','width=1000,height=300,left=10,top=150,scrollbars=yes'); this.readOnly=true; } else { this.readOnly=false;}"  value="<?php if(isset($_POST['direccion1'])) echo $_POST['direccion1']; else echo $this->direccionresidenciaestudiantegeneral ; ?>">
            <input name="direccion1oculta" type="hidden" value="<?php if(isset($_POST['direccion1oculta'])) echo $_POST['direccion1oculta']; else echo $this->direccioncortaresidenciaestudiantegeneral; ?>">
        </td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Tel&eacute;fono Residencia<label id="labelresaltado">*</label></td>
        <td>
            <input name="telefono1" type="text" id="requerido" size="15" maxlength="50" value="<?php if(isset($this->telefonoresidenciaestudiantegeneral)) echo $this->telefonoresidenciaestudiantegeneral; else echo $_POST['telefono1']; ?>">
        </td>
        <td id="tdtitulogris">Ciudad<label id="labelresaltado">*</label></td>
        <td colspan="3">
<!-- <input name="ciudad1" type="text" id="ciudad1" size="12" maxlength="50" value="<?php if(isset($this->ciudadresidenciaestudiantegeneral)) echo $this->ciudadresidenciaestudiantegeneral; else echo $_POST['ciudad1']; ?>"> -->           
            <select name="ciudad1" id="requerido" onchange="if(this.value == '359'){ bogotabarrio.style.display='';} else {bogotabarrio.style.display='none'; }">
                <option value="0" <?php if (!(strcmp("0", $this->ciudadresidenciaestudiantegeneral))) {
                    echo "SELECTED";
                        } ?>>Seleccionar</option>
                        <?php
                        do {
                            ?>
                <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $this->ciudadresidenciaestudiantegeneral))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_ciudad['nombreciudad'];?></option>
                            <?php
                        }
                        while($row_ciudad = $ciudad->FetchRow());
                        $ciudad->Move(0);
                        ?>
            </select>
            <div id="bogotabarrio" style="display:none">Debe seleccionar una localidad*
                <select name="estudiantebarrio" id="requerido">
                    <option value="" <?php if (!isset($_REQUEST['estudiantebarrio'])) {
                        echo "SELECTED";
                            } ?>>Seleccione la localidad</option>
                            <?php
                            do {
                        ?>              <option value="<?php echo $row_localidad['nombrelocalidad']?>"<?php if (!(strcmp($row_localidad['nombrelocalidad'], $row_estbarrio['estudiantebarrio']))) {
                            echo "SELECTED";
                                } ?>><?php echo $row_localidad['nombrelocalidad']?></option>
                                <?php
                            }
                            while($row_localidad = $localidad->FetchRow());
                            ?>
                </select>
                <!--input type="text" value="<?php if(isset($_POST['estudiantebarrio'])) echo $_POST['estudiantebarrio']; else echo $row_estbarrio['estudiantebarrio']; ?>" name="estudiantebarrio">-->
            </div>
            <?php
            if ($this->ciudadresidenciaestudiantegeneral == 359) {
                ?>
            <script language="JavaScript">
                bogotabarrio.style.display='';
            </script>
                <?php
            }
            ?>            </td>
    </tr>
<!--     <tr>
    <td colspan="2" id="tdtitulogris">Direcci&oacute;n Correspondencia</td>
<td colspan="5">
    <INPUT name="direccion2" size="90" readonly onclick="window.open('direccion.php?correo=1','direccion','width=1000,height=300,left=10,top=150,scrollbars=yes')"  value="<?php if(isset($_POST['direccion2'])) echo $_POST['direccion2']; else echo $this->direccioncorrespondenciaestudiantegeneral; ?>">
    <input name="direccion2oculta" type="hidden" size="25" value="<?php if(isset($_POST['direccion2oculta'])) echo $_POST['direccion2oculta']; else echo $this->direccioncortacorrespondenciaestudiantegeneral; ?>"></td>
 </tr>  -->
  <!-- <tr>
    <td colspan="2" id="tdtitulogris">Tel&eacute;fono Correspondencia</td>
    <td>
     <input name="telefono2" type="text" id="telefono2" size="15" maxlength="50" value="<?php if(isset($_POST['telefono2'])) echo $_POST['telefono2']; else echo $this->telefono2estudiantegeneral; ?>">
    </td>
    <td id="tdtitulogris">Ciudad</td>
   <td colspan="3">  -->
      <!-- <input name="ciudad2" type="text" id="ciudad2" size="12" maxlength="50" value="<?php if(isset($this->ciudadcorrespondenciaestudiantegeneral)) echo $this->ciudadcorrespondenciaestudiantegeneral; else echo $_POST['ciudad2']; ?>"> -->
          <!-- 	<select name="ciudad2">
      <option value="0" <?php if (!(strcmp("0", $this->ciudadcorrespondenciaestudiantegeneral))) {
        echo "SELECTED";
    } ?>>Seleccionar</option>
    <?php
    do {
        ?>
      <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $this->ciudadcorrespondenciaestudiantegeneral))) {
            echo "SELECTED";
        } ?>><?php echo $row_ciudad['nombreciudad'];?></option>
        <?php
    }
    while($row_ciudad = $ciudad->FetchRow());
    ?>
    </select>
    </td>
   </tr> -->
    <tr>
        <td colspan="2" id="tdtitulogris">E-mail 1 <label id="labelresaltado">*</label></td>
        <td><font size="2" face="Tahoma"><input name="email" type="text" id="requerido" size="35" maxlength="50" value="<?php if(isset($_POST['email'])) echo $_POST['email']; else echo $this->emailestudiantegeneral; ?>"></font></td>
        <td id="tdtitulogris">E-mail 2</td>
        <td><span class="style1"><input name="email2" type="text" id="email2" size="20" maxlength="50" value="<?php if(isset($_POST['email2'])) echo $_POST['email2']; else echo $this->email2estudiantegeneral; ?>"></td>
                <td id="tdtitulogris">Celular</td>
                <td><input name="celular" type="text" id="celular" size="12" maxlength="50" value="<?php if(isset($_POST['celular'])) echo $_POST['celular']; else echo $this->celularestudiantegeneral; ?>"></td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2" id="tdtitulogris">En caso de Emergencia<br> Llamar a
            <label id="labelresaltado">*</label></td>
        <td rowspan="2" ><input name="emergencia" type="text" id="requerido" size="45" maxlength="70" value="<?php if(isset($_POST['emergencia'])) echo $_POST['emergencia']; else echo $this->casoemergenciallamarestudiantegeneral; ?>"></td>
        <td rowspan="2"  id="tdtitulogris">Parentesco <label id="labelresaltado">*</label> </td>
        <td rowspan="2"><select name="parentesco" id="requerido">
                <option value="0" <?php if (!(strcmp("0", $this->idtipoestudiantefamilia))) {
                    echo "SELECTED";
                        } ?>>Seleccionar</option>
                        <?php
                        do {
                            ?>
                <option value="<?php echo $row_parentesco['idtipoestudiantefamilia']?>"<?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $this->idtipoestudiantefamilia))) {
                        echo "SELECTED";
                            } ?>><?php echo $row_parentesco['nombretipoestudiantefamilia']?></option>
                            <?php
                        }
                        while($row_parentesco = $parentesco->FetchRow());
                        ?>
            </select></td>
        <td id="tdtitulogris">Tel&eacute;fono1
            <label id="labelresaltado"> *</label></td>
        <td><input name="telemergencia1" type="text" id="requerido" size="12" maxlength="50" value="<?php if(isset($_POST['telemergencia1'])) echo $_POST['telemergencia1']; else echo $this->telefono1casoemergenciallamarestudiantegeneral; ?>"></td>
    </tr>
    <tr>
        <td id="tdtitulogris">Tel&eacute;fono2</td>
        <td><input name="telemergencia2" type="text" size="12" maxlength="50" value="<?php if(isset($_POST['telemergencia2'])) echo $_POST['telemergencia2']; else echo $this->telefono2casoemergenciallamarestudiantegeneral; ?>"></td>
    </tr>
</table>   
