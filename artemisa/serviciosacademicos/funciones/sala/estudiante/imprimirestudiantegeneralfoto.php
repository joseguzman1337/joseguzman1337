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

$query_seldocumentos = "select ed.numerodocumento, ed.fechainicioestudiantedocumento, ed.fechavencimientoestudiantedocumento, u.linkidubicacionimagen
from estudiantedocumento ed, estudiante e, ubicacionimagen u
where ed.idestudiantegeneral = e.idestudiantegeneral
and e.idestudiantegeneral = '$this->idestudiantegeneral'
and u.idubicacionimagen like '1%'
and u.codigoestado like '1%'
order by 2 desc";
$seldocumentos = $db->Execute($query_seldocumentos) or die(mysql_error());
$totalRows_seldocumentos = $seldocumentos->RecordCount();
$link = "../../../../../../imagenes/estudiantes/";
while($row_seldocumentos = $seldocumentos->FetchRow()) {

    $imagenjpg = $row_seldocumentos['numerodocumento'].".jpg";
    $imagenJPG = $row_seldocumentos['numerodocumento'].".JPG";

    //echo "<br>".is_file($link.$imagenjpg);
    //echo "<br>".is_file($link.$imagenJPG);
    if(is_file($link.$imagenjpg)) {
        $linkimagen = $link.$imagenjpg;
        break;
    }
    elseif(is_file($link.$imagenJPG)) {
        $linkimagen = $link.$imagenJPG;
        break;
    }
}
?>

<table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr>
        <td colspan="8" align="left">
            <?php
            if($aprobarHV) :
                $query_selforms = "select f.idformulario
from formularioestudiante f
where f.idestudiantegeneral = '$this->idestudiantegeneral'
and f.codigoestado like '1%'
and f.codigoestadodiligenciamiento like '2%'
and f.idformulario = '22'";
                $selforms = $db->Execute($query_selforms) or die(mysql_error());
                $totalRows_selforms = $selforms->RecordCount();
                $checked = "";
                if($totalRows_selforms > 0) {
                    $checked = "checked";
                }
                ?>
            <input type="checkbox" onclick="selapruebadocente(this,'22');" <?php echo $checked; ?> />
            <?php
            endif;
            ?>
            <label id="labelresaltado">INFORMACIÓN BÁSICA</label>
        </td>
    </tr>
    <tr>
        <td id="tdtitulogris">
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_trato['idtrato'], $this->idtrato))) {echo $row_trato['inicialestrato'];} ?>
            <?php
            }
            while($row_trato = $trato->FetchRow());
            ?>
        </td>
        <td  id="tdtitulogris">Nombre</td>
        <td><?php echo $this->nombresestudiantegeneral; ?></td>
        <td id="tdtitulogris">Apellidos</td>
        <td colspan="3"><?php echo $this->apellidosestudiantegeneral; ?></td>
        <td colspan="0" rowspan="6" align="center" valign="top"><img src="<?php echo $linkimagen; ?>" width="80" height="120"></td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Tipo Documento</td>
        <td>
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_documentos['tipodocumento'], $this->tipodocumento))) {
                    echo $row_documentos['nombredocumento'];
                } ?>
            <?php
            }
            while($row_documentos = $documentos->FetchRow());
            ?>
        </td>
        <td id="tdtitulogris">No. Documento</td>
        <td>
            <?php echo $this->numerodocumento; ?>
        </td>
        <td id="tdtitulogris">Expedida en</td>
        <td>
            <?php echo $this->expedidodocumento; ?>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Libreta Militar</td>
        <td>
            <?php echo $this->numerolibretamilitar; ?>
        </td>
        <td id="tdtitulogris">Distrito</td>
        <td>
            <?php echo $this->numerodistritolibretamilitar; ?>
        </td>
        <td id="tdtitulogris">Expedida en </td>
        <td>
            <?php echo $this->expedidalibretamilitar; ?>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">G&eacute;nero</td>
        <td>
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_selgenero['codigogenero'], $this->codigogenero))) {echo $row_selgenero['nombregenero'];} ?>
            <?php
            }
            while($row_selgenero = $selgenero->FetchRow());
            ?>
        </td>
        <td id="tdtitulogris">Estado Civil</td>
        <td colspan="1">
            <strong></strong>
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_estadocivil['idestadocivil'], $this->idestadocivil))) {echo $row_estadocivil['nombreestadocivil'];} ?>
            <?php
            }
            while($row_estadocivil = $estadocivil->FetchRow());
            ?>
        </td>
        <td id="tdtitulogris">Estrato</td>
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

            while($row_estrato = $estrato->FetchRow()) {
            //echo $_POST['idestrato'];
                ?>
                <?php if($row_estrato['idestrato'] == $row_estratohistorico['idestrato']) echo $row_estrato['nombreestrato']; ?>
            <?php
            }
            ?>
        </td>
    </tr>
    <tr>
        <td colspan="1" id="tdtitulogris">Lugar Nacimiento</td>
        <td>
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_ciudad['idciudad'], $this->idciudadnacimiento))) {echo $row_ciudad['nombreciudad'];} ?>
            <?php
            }
            while($row_ciudad = $ciudad->FetchRow());
            $ciudad->Move(0);
            ?>
                <!-- <input type="button" name="nuevo" value="..." onClick="crear()"> -->
            <?php
            //crearmenubotones($_SESSION['MM_Username'], ereg_replace(".*\/","",$HTTP_SERVER_VARS['SCRIPT_NAME']), $valores, $sala2);?>
        </td>
        <td id="tdtitulogris">Fecha Nacimiento</td>
        <td colspan="2">
            <?
            $fechanacimientoestudiantegeneral=explode(" ",$this->fechanacimientoestudiantegeneral);
 /*escribe_formulario_fecha_vacio("fecha1","inscripcion",$this->fechanacimientoestudiantegeneral']);*/
            ?>
            <input type="hidden" name="fecha1" id="fechaOK"  value="<?php echo $fechanacimientoestudiantegeneral[0]; ?>">
            <?php echo $this->fechanacimientoestudiantegeneral; ?>
        </td>
        <td id="tdtitulogris">Edad</td>
        <td colspan="1">
            <?
 /*escribe_formulario_fecha_vacio("fecha1","inscripcion",$this->fechanacimientoestudiantegeneral']);*/
            ?>
            <input name="edad1" type="text" id="edadOK" size="3" value="" maxlength="3" readonly>
        </td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Direcci&oacute;n Residencia</td>
        <td colspan="5">
            <?php echo $this->direccionresidenciaestudiantegeneral; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" id="tdtitulogris">Tel&eacute;fono Residencia</td>
        <td>
            <?php echo $this->telefonoresidenciaestudiantegeneral; ?>
        </td>
        <td id="tdtitulogris">Ciudad</td>
        <td colspan="4">
<!-- <input name="ciudad1" type="text" id="ciudad1" size="12" maxlength="50" value="<?php if(isset($this->ciudadresidenciaestudiantegeneral)) echo $this->ciudadresidenciaestudiantegeneral; else echo $_POST['ciudad1']; ?>"> -->
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_ciudad['idciudad'], $this->ciudadresidenciaestudiantegeneral))) {echo $row_ciudad['nombreciudad'];} ?>
            <?php
            }
            while($row_ciudad = $ciudad->FetchRow());
            $ciudad->Move(0);
            if ($this->ciudadresidenciaestudiantegeneral == 359) {
                echo " -- ".$row_estbarrio['estudiantebarrio'];
            }
            ?>
        </td>
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
      <option value="0" <?php
    if (!(strcmp("0", $this->ciudadcorrespondenciaestudiantegeneral))) {echo "SELECTED";} ?>>Seleccionar</option>
    <?php
    do {
        ?>
      <option value="<?php echo $row_ciudad['idciudad']?>"<?php if (!(strcmp($row_ciudad['idciudad'], $this->ciudadcorrespondenciaestudiantegeneral))) {echo "SELECTED";} ?>><?php echo $row_ciudad['nombreciudad'];?></option>
    <?php
    }
    while($row_ciudad = $ciudad->FetchRow());
    ?>
    </select>
    </td>
   </tr> -->
    <tr>
        <td colspan="2" id="tdtitulogris">E-mail 1 </td>
        <td><font size="2">
            <?php echo $this->emailestudiantegeneral; ?></font></td>
        <td id="tdtitulogris">E-mail 2</td>
        <td>
            <?php echo $this->email2estudiantegeneral; ?>
        </td>
        <td id="tdtitulogris">Celular</td>
        <td colspan="2">
            <?php echo $this->celularestudiantegeneral; ?>
        </td>
    </tr>
    <tr>
        <td colspan="2" rowspan="2" id="tdtitulogris">En caso de Emergencia<br> Llamar a
        </td>
        <td rowspan="2" ><?php echo $this->casoemergenciallamarestudiantegeneral; ?></td>
        <td rowspan="2"  id="tdtitulogris">Parentesco  </td>
        <td rowspan="2">
            <?php
            do {
                ?>
                <?php if (!(strcmp($row_parentesco['idtipoestudiantefamilia'], $this->idtipoestudiantefamilia))) { echo $row_parentesco['nombretipoestudiantefamilia']; }?>
            <?php
            }
            while($row_parentesco = $parentesco->FetchRow());
            ?>
        </td>
        <td id="tdtitulogris">Tel&eacute;fono1
        </td>
        <td colspan="2"><?php echo $this->telefono1casoemergenciallamarestudiantegeneral; ?>
        </td>
    </tr>
    <tr>
        <td id="tdtitulogris">Tel&eacute;fono2</td>
        <td colspan="2"><?php echo $this->telefono2casoemergenciallamarestudiantegeneral; ?></td>
    </tr>
</table>
