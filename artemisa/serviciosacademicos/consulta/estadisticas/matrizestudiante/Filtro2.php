<?php
function Filtro($filtroCarreras="") {
    global $db;
    ?>
<form action="" method="post" name="f1" onsubmit="return validar(this)">
    <table border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
        <tr>
            <td colspan="2"><label id="labelresaltado">Seleccione los filtros que desee para efectuar la consulta y oprima el botón Enviar</label></td>
        </tr>
        <tr>
            <td id="tdtitulogris">
                Area Disciplinar<label id="labelresaltado"></label>
            </td>
            <td>
                    <?php
                    //echo $filtroCarreras;
                    if($filtroCarreras == "in()") {
                        $filtroCarrerastmp = "";
                    }
                    elseif($filtroCarreras != "") {
                        $filtroCarrerastmp = " and ca.codigocarrera $filtroCarreras";
                    }
                    $query_areadisciplinar = "select distinct a.codigoareadisciplinar, a.nombreareadisciplinar
                    from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
                    where a.codigoareadisciplinar = f.codigoareadisciplinar
                    and f.codigofacultad = ca.codigofacultad
                    and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
                    $filtroCarrerastmp";
                    $areadisciplinar = $db->Execute($query_areadisciplinar);
                    $totalRows_areadisciplinar = $areadisciplinar->RecordCount();
                    //$row_areadisciplinar = $areadisciplinar->FetchRow();
                    $filtroCarreras = "";
                    ?>
                <select name="nacodigoareadisciplinar" id="modalidad" onChange="document.f1.submit()">
                    <option value=""<?php if (!(strcmp("", $_REQUEST['nacodigoareadisciplinar']))) {echo "SELECTED";} ?>>
                        *Todas
                    </option>
                    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigoareadisciplinar'])) || !isset($_REQUEST['nacodigoareadisciplinar'])) {echo "SELECTED";} ?>>
                        Seleccionar
                    </option>
                        <?php
                        while($row_areadisciplinar = $areadisciplinar->FetchRow()) {
                            ?>
                    <option value="<?php echo $row_areadisciplinar['codigoareadisciplinar']?>" <?php if (!(strcmp($row_areadisciplinar['codigoareadisciplinar'], $_REQUEST['nacodigoareadisciplinar']))) {echo "SELECTED";} ?>>
                                <?php echo $row_areadisciplinar['nombreareadisciplinar']?>
                    </option>
                        <?php
                        }
                        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td id="tdtitulogris">
                Facultad<label id="labelresaltado"></label>
            </td>
            <td>
                    <?php
                    $filtroArea = " and a.codigoareadisciplinar = '".$_REQUEST['nacodigoareadisciplinar']."' ";
                    if(isset($_REQUEST['nacodigoareadisciplinar']) && $_REQUEST['nacodigoareadisciplinar'] == "") {

                        $filtroArea="";
                    }
                    if($filtroCarreras == "in()") {
                        $filtroCarreras = "";
                    }
                    if($filtroCarreras != "") {
                        $filtroCarrerastmp = " and ca.codigocarrera $filtroCarreras";
                    }
                    $query_facultad = "select distinct f.nombrefacultad, f.codigofacultad
                    from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
                    where a.codigoareadisciplinar = f.codigoareadisciplinar
                    and f.codigofacultad = ca.codigofacultad
                    and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
                    $filtroCarrerastmp
                    $filtroArea
                    order by 1";
                    $facultad = $db->Execute($query_facultad);
                    $totalRows_facultad = $facultad->RecordCount();
                    //$row_facultad = $facultad->FetchRow();
                    $filtroArea = "";
                    //print_r($_REQUEST);
                    ?>
                <select name="nacodigofacultad" id="modalidad" onChange="document.f1.submit()">
                    <option value=""<?php if (!(strcmp("", $_REQUEST['nacodigofacultad']))) {echo "SELECTED";} ?>>
                        *Todas
                    </option>
                    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigofacultad'])) || !isset($_REQUEST['nacodigofacultad'])) {echo "SELECTED";} ?>>
                        Seleccionar
                    </option>
                        <?php
                        while($row_facultad = $facultad->FetchRow()) {
                            ?>
                    <option value="<?php echo $row_facultad['codigofacultad']?>" <?php if (!(strcmp($row_facultad['codigofacultad'], $_REQUEST['nacodigofacultad']))) {echo "SELECTED";} ?>>
                                <?php echo $row_facultad['nombrefacultad']?>
                    </option>
                        <?php
                        }                        
                        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td id="tdtitulogris">
                Nivel Acad&eacute;mico<label id="labelresaltado"></label>
            </td>
            <td>
                    <?php
                    if(!isset($_REQUEST['nacodigofacultad']) || $_REQUEST['nacodigofacultad'] != "") {
                        $filtroFacultad = " and ca.codigofacultad = '".$_REQUEST['nacodigofacultad']."' ";
                    }
                    if(!isset($_REQUEST['nacodigoareadisciplinar']) || $_REQUEST['nacodigoareadisciplinar'] != "") {
                        $filtroArea = " and f.codigoareadisciplinar = '".$_REQUEST['nacodigoareadisciplinar']."' ";
                    }
                    if($filtroCarreras == "in()") {
                        $filtroCarreras = "";
                    }
                    if($filtroCarreras != "") {
                        $filtroCarrerastmp = " and c.codigocarrera $filtroCarreras";
                    }
                    $query_modalidad = "select distinct m.codigomodalidadacademicasic, m.nombremodalidadacademicasic
                    from areadisciplinar a, carrera ca, facultad f, modalidadacademicasic m
                    where a.codigoareadisciplinar = f.codigoareadisciplinar
                    and f.codigofacultad = ca.codigofacultad
                    and ca.codigomodalidadacademicasic = m.codigomodalidadacademicasic
                    $filtroFacultad
                    $filtroArea
                    $filtroCarrerastmp
                    order by 1";
                    $modalidad = $db->Execute($query_modalidad);
                    $totalRows_modalidad = $modalidad->RecordCount();
                    //$row_modalidad = $modalidad->FetchRow();
                    ?>
                <select name="nacodigomodalidadacademicasic" id="modalidad" onChange="document.f1.submit()">
                    <option value=""<?php if (!(strcmp("", $_REQUEST['nacodigomodalidadacademicasic']))) {echo "SELECTED";} ?>>
                        *Todos
                    </option>
                    <option value="0"<?php if (!(strcmp("0", $_REQUEST['nacodigomodalidadacademicasic'])) || !isset($_REQUEST['nacodigomodalidadacademicasic'])) {echo "SELECTED";} ?>>
                        Seleccionar
                    </option>
                        <?php
                        while($row_modalidad = $modalidad->FetchRow()) {
                            ?>
                    <option value="<?php echo $row_modalidad['codigomodalidadacademicasic']?>" <?php if (!(strcmp($row_modalidad['codigomodalidadacademicasic'], $_REQUEST['nacodigomodalidadacademicasic']))) {echo "SELECTED";} ?>>
                                <?php echo $row_modalidad['nombremodalidadacademicasic']?>
                    </option>
                        <?php
                        }
                        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td id="tdtitulogris">
                Nombre del Programa<label id="labelresaltado"></label>
            </td>
            <td>
                    <?php
                    $fecha = date("Y-m-d G:i:s",time());
                    if(!isset($_REQUEST['nacodigofacultad']) || $_REQUEST['nacodigofacultad'] != "") {
                        $filtroFacultad = " and ca.codigofacultad = '".$_REQUEST['nacodigofacultad']."' ";
                    }
                    if(!isset($_REQUEST['nacodigoareadisciplinar']) || $_REQUEST['nacodigoareadisciplinar'] != "") {
                        $filtroArea = " and f.codigoareadisciplinar = '".$_REQUEST['nacodigoareadisciplinar']."' ";
                    }
                    if(!isset($_REQUEST['nacodigomodalidadacademicasic']) || $_REQUEST['nacodigomodalidadacademicasic'] != "") {
                        $filtroModalidad = " and ca.codigomodalidadacademicasic = '".$_REQUEST['nacodigomodalidadacademicasic']."' ";
                    }
                    if($filtroCarreras == "in()") {
                        $filtroCarreras = "";
                    }
                    if($filtroCarreras != "") {
                        $filtroCarrerastmp = " and c.codigocarrera $filtroCarreras";
                    }
                    $query_carrera = "SELECT distinct ca.nombrecortocarrera as nombrecarrera, ca.codigocarrera
                    FROM carrera ca, facultad f
                    where ca.codigofacultad = f.codigofacultad
                        $filtroArea
                        $filtroModalidad
                        $filtroCarrerastmp
                        $filtroFacultad
                    order by 1";
                    $carrera = $db->Execute($query_carrera);
                    $totalRows_carrera = $carrera->RecordCount();
                    //$row_carrera = $carrera->FetchRow();
                    ?>
                <select name="nacodigocarrera" id="especializacion">
                    <option value="" <?php if (!(strcmp("", $_REQUEST['nacodigocarrera']))) {echo "SELECTED";} ?>>
                        *Todas
                    </option>
                    <option value="0" <?php if (!(strcmp("0", $_REQUEST['nacodigocarrera'])) || !isset($_REQUEST['nacodigocarrera'])) {echo "SELECTED";} ?>>
                        Seleccionar
                    </option>
                        <?php
                        while($row_carrera = $carrera->FetchRow()) {
                        //$algo2 = ereg_replace("^.+ - ","",$row_car['codigocarrera']." - ".$row_car['codigoperiodo']);
                            ?>
                    <option value="<?php echo $row_carrera['codigocarrera'];?>" <?php if (!(strcmp($row_carrera['codigocarrera'], $_REQUEST['nacodigocarrera']))) {echo "SELECTED";} ?>>
                                <?php echo $row_carrera['nombrecarrera']; ?>
                    </option>
                        <?php
                        }

                        ?>
                </select>
            </td>
        </tr>
        <tr>
            <td id="tdtitulogris">
                Campo del Formulario: <br><label id="labelresaltado">(Seleccione los campos del formulario que desea visualizar, <br>si quiere más de uno use control y haga la selección, <br>si quiere todos de clic en "*Todos los datos",<br> despues de hacer la selección de clic en el botón enviar)</label>
            </td>
            <td><select id="nacampoformulario" name="nacampoformulario[]" size="12" multiple="multiple">
                        <?php
                        $selected = "";
                        if(in_array('todos',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="todos" <?php echo $selected;?>>*Todos los datos</option>
                        <?php
                        $selected = "";
                        if(in_array('edad',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="edad" <?php echo $selected;?>>Rango De Edad</option>
                        <?php
                        $selected = "";
                        if(in_array('genero',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="genero" <?php echo $selected;?>>Género</option>
                        <?php
                        $selected = "";
                        if(in_array('niveleducativodocencia',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="niveleducativodocencia" <?php echo $selected;?>>Nivel educativo docencia</option>
                        <?php
                        $selected = "";
                        if(in_array('niveleducativodisciplinar',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="niveleducativodisciplinar" <?php echo $selected;?>>Nivel educativo disciplinar</option>
                        <?php
                        $selected = "";
                        if(in_array('niveleducativoinvestigacion',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="niveleducativoinvestigacion" <?php echo $selected;?>>Nivel educativo investigación</option>
                        <?php
                        $selected = "";
                        if(in_array('idiomas',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="idiomas" <?php echo $selected;?>>Idiomas</option>
                        <?php
                        $selected = "";
                        if(in_array('tics',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="tics" <?php echo $selected;?>>Tecnologias de la Información y Comunicación</option>
                        <?php
                        $selected = "";
                        if(in_array('nacionalidad',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="nacionalidad" <?php echo $selected;?>>Nacionalidad</option>
                        <?php
                        $selected = "";
                        if(in_array('investigativas',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="investigativas" <?php echo $selected;?>>Investigativas</option>
                        <?php
                        $selected = "";
                        if(in_array('bienestaruniversitario',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="bienestaruniversitario" <?php echo $selected;?>>Bienestar Universitario</option>
                        <?php
                        $selected = "";
                        if(in_array('gobiernouniversitario',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="gobiernouniversitario" <?php echo $selected;?>>Gobierno Universitario</option>
                        <?php
                        $selected = "";
                        if(in_array('asociaciones',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="asociaciones" <?php echo $selected;?>>Asociaciones</option>
                        <?php
                        $selected = "";
                        if(in_array('estimulos',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="estimulos" <?php echo $selected;?>>Estímulos, reconocimientos y distinciones</option>
                        <?php
                        $selected = "";
                        if(in_array('tipocontrato',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="tipocontrato" <?php echo $selected;?>>Tipo de Contrato</option>
                        <?php
                        $selected = "";
                        if(in_array('historicos',$_REQUEST['nacampoformulario']))
                            $selected = "selected";
                        ?>
                    <option value="historicos" <?php echo $selected;?>>Datos Históricos</option>
                </select>
            </td>
        </tr>
    </table>
    <br>
    <input type="submit" value="Enviar" name="naenviar" onclick="">
    <input type="button" value="Restablecer" onClick="window.location.href=''">

    <br><br>
</form>
<script type="text/javascript">
    function validar(formulario) {
        var indice1 = formulario.nacodigomodalidadacademicasic.selectedIndex;
        var indice2 = formulario.nacodigoareadisciplinar.selectedIndex;
        var indice3 = formulario.nacodigocarrera.selectedIndex;
        //var indice4 = formulario.nacampoformulario.selectedIndex;
        var selObj = document.getElementById('nacampoformulario');
        var i;
        var count = 0;
        for (i=0; i<selObj.options.length; i++) {
            if (selObj.options[i].selected) {
                count++;
                break;
            }
        }

        //alert(selObj.options.length);
        if(formulario.nacodigomodalidadacademicasic.options[indice1].value == '0') {
            alert('Debe seleccionar un nivel académico');
            return false;
        }
        if(formulario.nacodigoareadisciplinar.options[indice2].value == '0') {
            alert('Debe seleccionar una área disciplinar');
            return false;
        }
        if(formulario.nacodigocarrera.options[indice3].value == '0') {
            alert('Debe seleccionar una carrera');
            return false;
        }
        if(count == 0) {
            alert('Debe seleccionar un campo para generar la matriz');
            return false;
        }
    }
</script>
<?php
}
?>
