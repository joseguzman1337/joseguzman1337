<?php
class detalleplanestudio {

    // Variables
    var $idplanestudio;
    var $codigomateria;
    var $semestredetalleplanestudio;
    var $valormateriadetalleplanestudio;
    var $numerocreditosdetalleplanestudio;
    var $codigoformacionacademica;
    var $codigoareaacademica;
    var $fechacreaciondetalleplanestudio;
    var $fechainiciodetalleplanestudio;
    var $fechavencimientodetalleplanestudio;
    var $codigoestadodetalleplanestudio;
    var $codigotipomateria;

    // This is the constructor for this class
    // Initialize all your default variables here
    function detalleplanestudio($idplanestudio, $codigomateria, $idlineaenfasisplanestudio=0) {
        global $db;
        $query = "SELECT idplanestudio, codigomateria, semestredetalleplanestudio * 1 as semestredetalleplanestudio,
		valormateriadetalleplanestudio, numerocreditosdetalleplanestudio, codigoformacionacademica,
		codigoareaacademica, fechacreaciondetalleplanestudio, fechainiciodetalleplanestudio,
		fechavencimientodetalleplanestudio, codigoestadodetalleplanestudio, codigotipomateria
		FROM detalleplanestudio
		where idplanestudio = '$idplanestudio'
		and codigomateria = '$codigomateria'";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();
        if($totalRows_rta != "") {
            $row_rta = $rta->FetchRow();
            $this->idplanestudio = $row_rta['idplanestudio'];
            $this->codigomateria = $row_rta['codigomateria'];
            $this->semestredetalleplanestudio = $row_rta['semestredetalleplanestudio'];
            $this->valormateriadetalleplanestudio = $row_rta['valormateriadetalleplanestudio'];
            $this->numerocreditosdetalleplanestudio = $row_rta['numerocreditosdetalleplanestudio'];
            $this->codigoformacionacademica = $row_rta['codigoformacionacademica'];
            $this->codigoareaacademica = $row_rta['codigoareaacademica'];
            $this->fechacreaciondetalleplanestudio = $row_rta['fechacreaciondetalleplanestudio'];
            $this->fechainiciodetalleplanestudio = $row_rta['fechainiciodetalleplanestudio'];
            $this->fechavencimientodetalleplanestudio = $row_rta['fechavencimientodetalleplanestudio'];
            $this->codigoestadodetalleplanestudio = $row_rta['codigoestadodetalleplanestudio'];
            $this->codigotipomateria = $row_rta['codigotipomateria'];
        }
        else {
            $query = "SELECT idplanestudio, codigomateriadetallelineaenfasisplanestudio as codigomateria,
			semestredetallelineaenfasisplanestudio as semestredetalleplanestudio, codigotipomateria,
			valormateriadetallelineaenfasisplanestudio as valormateriadetalleplanestudio,
			numerocreditosdetallelineaenfasisplanestudio as numerocreditosdetalleplanestudio
			FROM detallelineaenfasisplanestudio
			where idlineaenfasisplanestudio = '$idlineaenfasisplanestudio'
			and codigomateriadetallelineaenfasisplanestudio = '$codigomateria'
			and codigoestadodetallelineaenfasisplanestudio like '1%'";
            $rta = $db->Execute($query);
            $totalRows_rta = $rta->RecordCount();
            $row_rta = $rta->FetchRow();

            $this->idplanestudio = $row_rta['idplanestudio'];
            $this->codigomateria = $row_rta['codigomateria'];
            $this->semestredetalleplanestudio = $row_rta['semestredetalleplanestudio'];
            $this->valormateriadetalleplanestudio = $row_rta['valormateriadetalleplanestudio'];
            $this->numerocreditosdetalleplanestudio = $row_rta['numerocreditosdetalleplanestudio'];
            $this->codigoformacionacademica = $row_rta['codigoformacionacademica'];
            $this->codigoareaacademica = $row_rta['codigoareaacademica'];
            $this->fechacreaciondetalleplanestudio = $row_rta['fechacreaciondetalleplanestudio'];
            $this->fechainiciodetalleplanestudio = $row_rta['fechainiciodetalleplanestudio'];
            $this->fechavencimientodetalleplanestudio = $row_rta['fechavencimientodetalleplanestudio'];
            $this->codigoestadodetalleplanestudio = $row_rta['codigoestadodetalleplanestudio'];
            $this->codigotipomateria = $row_rta['codigotipomateria'];
        }
    }

    function mostrarDetallePlanEstudio() {
        global $db;
        $query = "SELECT codigomateria, nombrecortomateria, nombremateria, numerocreditos, codigoperiodo, notaminimaaprobatoria, notaminimahabilitacion, numerosemana, numerohorassemanales, porcentajeteoricamateria, porcentajepracticamateria, porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria, codigomodalidadmateria, codigolineaacademica, codigocarrera, codigoindicadorgrupomateria, codigotipomateria, codigoestadomateria, ulasa, ulasb, ulasc, codigoindicadorcredito, codigoindicadoretiquetamateria, codigotipocalificacionmateria
		FROM materia
		where codigomateria = '$this->codigomateria'";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();

        ?>
<table border="1" style="font-size: 8px" height="50">
    <tr id="trtitulogirs">
        <td width="10%"><?php echo $this->numerocreditosdetalleplanestudio;?></td>
        <td rowspan="2" width="90%" align="center"><label><?php echo "$this->codigomateria<br>".$row_rta['nombremateria'];?></label>
            &nbsp; </td>
    </tr>
    <tr>
        <td width="10%"><?php echo $row_rta['numerohorassemanales'];?></td>
    </tr>
</table>
        <?php
    }

    function mostrarDetallePlanEstudioEstudiante($materiascarga, $conimagen = false) {
        global $db, $credito, $nota, $codigoestudiante, $mensajemateria;
        $query = "SELECT codigomateria, nombrecortomateria, nombremateria, numerocreditos, codigoperiodo, notaminimaaprobatoria, notaminimahabilitacion, numerosemana, numerohorassemanales, porcentajeteoricamateria, porcentajepracticamateria, porcentajefallasteoriamodalidadmateria, porcentajefallaspracticamodalidadmateria, codigomodalidadmateria, codigolineaacademica, codigocarrera, codigoindicadorgrupomateria, codigotipomateria, codigoestadomateria, ulasa, ulasb, ulasc, codigoindicadorcredito, codigoindicadoretiquetamateria, codigotipocalificacionmateria
		FROM materia
		where codigomateria = '$this->codigomateria'";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();
        $row_rta = $rta->FetchRow();

        if(isset($materiascarga['aprobadas'][$this->codigomateria])) {
            $imprime1 = $materiascarga['aprobadas'][$this->codigomateria];
            $imprime2 = "A";
            //$colorfondo = "#A9C743";#e0fb86#003322#4a9339
            //$colorfondo = "#e0fb86";
            //$colorfondo = "#003322";
            $colorfondo = "#4a9339";
            if($conimagen == true)
                $imagen = "<img src='aprobada.png' width='10px' height='10px'>";
            //$cursor = 'style="cursor: pointer"';
        }
        else if(isset($materiascarga['cargapropuesta'][$this->codigomateria])) {
            $imprime1 = $materiascarga['cargaobligatoria'][$this->codigomateria];
            $colorfondo = "#858200";
            $imprime2 = "M";
            if($conimagen == true)
                $imagen = "<img src='matriculada.png' width='10px' height='10px'>";
            /*$imprime1 = $materiascarga['cargapropuesta'][$this->codigomateria];
			$colorfondo = "#d25400";
			$imprime2 = "C";
			if($conimagen == true)
				$imagen = "<img src='cursada.png' width='10px' height='10px'>";*/
        }
        else {
            $imprime1 = $materiascarga['cargaobligatoria'][$this->codigomateria];
            //#ac0000
            $colorfondo = "#ac0000";
            $imprime2 = "P";
            if($conimagen == true)
                $imagen = "<img src='pendiente.png' width='10px' height='10px'>";
        }
        if(isset($_SESSION['codigoperiodosesion'])) {
            // Mira si la materia estï¿½ en la prematricula paga del periodo que se estï¿½ mirando
            if(!isset($materiascarga['aprobadas'][$this->codigomateria])) {
                $query_pre = "select p.idprematricula
			from prematricula p, detalleprematricula dp
			where p.idprematricula = dp.idprematricula
			and p.codigoestadoprematricula like '4%'
			and (dp.codigomateria = '$this->codigomateria' or dp.codigomateriaelectiva = '$this->codigomateria')
			and dp.codigoestadodetalleprematricula like '3%'
			and p.codigoestudiante = '$codigoestudiante'
			and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."'";
                $rtapre = $db->Execute($query_pre);
                /*echo "$query_pre";
			exit();*/
                $totalRows_rtapre = $rtapre->RecordCount();
                if($totalRows_rtapre > 0) {
                    $imprime1 = $materiascarga['cargapropuesta'][$this->codigomateria];
                    $colorfondo = "#d25400";
                    $imprime2 = "C";
                    if($conimagen == true)
                        $imagen = "<img src='cursada.png' width='10px' height='10px'>";
                    /*$imprime1 = $materiascarga['cargaobligatoria'][$this->codigomateria];
				$colorfondo = "#858200";
				$imprime2 = "M";
				if($conimagen == true)
					$imagen = "<img src='matriculada.png' width='10px' height='10px'>";*/
                }
            }

            //$row_rtapre = $rtapre->FetchRow();
        }
        else {
            $mensajemateria = "Debe seleccionar un periodo, para que le muestre información";
        }

        $prerequisistosMensaje = $this->getPrerrequisitosMensaje();

        ?>
<table border="1" cellpadding="1" cellspacing="0" bordercolor="<?php echo $colorfondo; ?>" style="font-size: 8px;" height="30px" width="100%">
    <tr id="trtitulogirs" bgcolor="<?php echo $colorfondo; ?>" style="color: #FFFFFF; font: bold" onclick="return overlib('<?php echo $prerequisistosMensaje; ?>', STICKY, CAPTION, 'Referencias:', BGCOLOR, '#E9E9E9', CAPCOLOR, '#000000', FGCOLOR, '#FFFFFF', BORDER, 2, TEXTSIZE, '8px');">
        <td width="33%"><?php echo $imprime1;?></td>
        <td width="33%" align="center"><?php echo $row_rta['numerocreditos'];?></td>
        <td width="34%" align="right"><?php echo "$imprime2"." $imagen";?></td>
    </tr>
    <tr style="font: bold;">
        <td colspan="3" align="center"><label onclick="return overlib('<?php echo $mensajemateria; ?>', STICKY, CAPTION, 'Información:', BGCOLOR, '#E9E9E9', CAPCOLOR, '#000000', FGCOLOR, '#FFFFFF', BORDER, 2, TEXTSIZE, '8px');"><?php echo "$this->codigomateria<br>".$row_rta['nombremateria'];?></label>
            &nbsp;
        </td>
    </tr>
</table>
        <?php
        $credito = $row_rta['numerocreditos'];
        $nota = $imprime1;
    }

    /**
     * @return returns value of variable $idplanestudio
     * @desc getIdplanestudio : Getting value for variable $idplanestudio
     */
    function getPrerrequisitosMensaje() {
        global $db;
/*Visualizacion contenido Programático*/
           $query_registros="SELECT *
                    FROM contenidoprogramatico  c
                    where c.codigomateria = '$this->codigomateria'
                    and now() between c.fechainiciocontenidoprogramatico and c.fechafincontenidoprogramatico
                    and c.codigoestado like '1%'";
                    $registros = $db->Execute ($query_registros) or die("$query_registros".mysql_error());
                    $total_Rows_registros= $registros->RecordCount();
                    $row_registros = $registros->FetchRow();
                    $idcontenidoprogramatico=$row_registros['idcontenidoprogramatico'];
                    if($idcontenidoprogramatico == ""){
                        $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
                        <tr id="trtitulogris"><td colspan="2">No Se ha Ingresado el contenido Prográmatico de Esta Materia</td></tr>';
                    }else{
                        if($row_registros['codigoperiodo'] >= 20122){
                            $urlmaterias = "http://172.16.3.227/serviciosacademicos/consulta/facultades/materiasgrupos/contenidoprogramatico/toPdf.php?usuariosesion=".$_SESSION['MM_Username'];
                            $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
                            <tr id="trtitulogris"><td colspan="2">Contenido Prográmatico <br> <a href="'.$urlmaterias.'&type=2&periodosesion="'.$row_registros['codigoperiodo'].'&codigomateria='.$row_registros['codigomateria'].'" target="new">Ver Contenido Programático</a></td></tr>
                            <tr id="trtitulogris"><td colspan="2">Syllabus<br><a href="'.$urlmaterias.'&type=1&periodosesion="'.$row_registros['codigoperiodo'].'&codigomateria='.$row_registros['codigomateria'].'" target="new">Ver Syllabus</a></td></tr>';
                        }else{
                            $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
                            <tr id="trtitulogris"><td colspan="2">Contenido Prográmatico <br> <a href="../materiasgrupos/contenidoprogramatico/'.$row_registros['urlaarchivofinalcontenidoprogramatico'].'" target="new">Ver Contenido Programático</a></td></tr>
                            <tr id="trtitulogris"><td colspan="2">Syllabus<br><a href="../materiasgrupos/contenidoprogramatico/'.$row_registros['urlasyllabuscontenidoprogramatico'].'" target="new">Ver Syllabus</a></td></tr>';
                        }                        
                    }
         $query = "select m.codigomateria, m.nombremateria
		from referenciaplanestudio r, materia m
		where m.codigomateria = r.codigomateriareferenciaplanestudio
		and r.codigotiporeferenciaplanestudio like '1%'
		and r.codigomateria = '$this->codigomateria'
		and r.idplanestudio = '$this->idplanestudio'";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();

        $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
		<tr id="trtitulogris"><td colspan="2">Prerrequisitos</td></tr> ';
        if($totalRows_rta > 0) {
            $html .= '<tr id="trtitulogris"><td>Codigo</td><td>Nombre</td></tr>';
            while($row_rta = $rta->FetchRow()) {
                $html .= '<tr><td>'.$row_rta['codigomateria'].'</td><td>'.$row_rta['nombremateria'].'</td></tr>';
            }

        }
        else
            $html .= '<tr><td colspan="2"><b>Esta materia no tiene prerrequisitos</b></td></tr>';

        $html .= '</table><br>';

        $query = "select m.codigomateria, m.nombremateria
		from referenciaplanestudio r, materia m
		where m.codigomateria = r.codigomateriareferenciaplanestudio
		and r.codigotiporeferenciaplanestudio like '2%'
		and r.codigomateria = '$this->codigomateria'
		and r.idplanestudio = '$this->idplanestudio'";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();

        $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
		<tr id="trtitulogris"><td colspan="2">Correquisitos</td></tr>';
        if($totalRows_rta > 0) {
            $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
			<tr id="trtitulogris"><td colspan="2">Correquisitos</td></tr>
			<tr id="trtitulogris"><td>Codigo</td><td>Nombre</td></tr>';
            while($row_rta = $rta->FetchRow()) {
                $html .= '<tr><td>'.$row_rta['codigomateria'].'</td><td>'.$row_rta['nombremateria'].'</td></tr>';
            }

        }
        else
            $html .= '<tr><td colspan="2"><b>Esta materia no tiene correquisitos</b></td></tr>';

        $html .= '</table><br>';

        $query = "select m.codigomateria, m.nombremateria
		from referenciaplanestudio r, materia m
		where m.codigomateria = r.codigomateriareferenciaplanestudio
		and r.codigotiporeferenciaplanestudio like '3%'
		and r.codigomateria = '$this->codigomateria'
		and r.idplanestudio = '$this->idplanestudio'";
        $rta = $db->Execute($query);
        $totalRows_rta = $rta->RecordCount();

        if($totalRows_rta > 0) {
            $html .= '<table  border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9" style="font-size: 8px;" width="100%">
			<tr id="trtitulogris"><td colspan="2">Equivalencias</td></tr>
			<tr id="trtitulogris"><td>Codigo</td><td>Nombre</td></tr>';
            while($row_rta = $rta->FetchRow()) {
                $html .= '<tr><td>'.$row_rta['codigomateria'].'</td><td>'.$row_rta['nombremateria'].'</td></tr>';
            }
        }
        else
            $html .= '<tr><td colspan="2"><b>Esta materia no tiene equivalencias</b></td></tr>';

        $html .= '</table><br>';

        $html = trim($html);
        $sustituye = array("\r\n", "\n\r", "\n", "\r");
        $html = str_replace($sustituye, "", $html);
        $html = ereg_replace("\"","",$html);
        //echo "$html";
        return trim($html);
    }

    /**
     * @return returns value of variable $idplanestudio
     * @desc getIdplanestudio : Getting value for variable $idplanestudio
     */
    function getIdplanestudio() {
        return $this->idplanestudio;
    }

    /**
     * @param param : value to be saved in variable $idplanestudio
     * @desc setIdplanestudio : Setting value for $idplanestudio
     */
    function setIdplanestudio($value) {
        $this->idplanestudio = $value;
    }

    /**
     * @return returns value of variable $codigomateria
     * @desc getCodigomateria : Getting value for variable $codigomateria
     */
    function getCodigomateria() {
        return $this->codigomateria;
    }

    /**
     * @param param : value to be saved in variable $codigomateria
     * @desc setCodigomateria : Setting value for $codigomateria
     */
    function setCodigomateria($value) {
        $this->codigomateria = $value;
    }

    /**
     * @return returns value of variable $semestredetalleplanestudio
     * @desc getSemestredetalleplanestudio : Getting value for variable $semestredetalleplanestudio
     */
    function getSemestredetalleplanestudio() {
        return $this->semestredetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $semestredetalleplanestudio
     * @desc setSemestredetalleplanestudio : Setting value for $semestredetalleplanestudio
     */
    function setSemestredetalleplanestudio($value) {
        $this->semestredetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $valormateriadetalleplanestudio
     * @desc getValormateriadetalleplanestudio : Getting value for variable $valormateriadetalleplanestudio
     */
    function getValormateriadetalleplanestudio() {
        return $this->valormateriadetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $valormateriadetalleplanestudio
     * @desc setValormateriadetalleplanestudio : Setting value for $valormateriadetalleplanestudio
     */
    function setValormateriadetalleplanestudio($value) {
        $this->valormateriadetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $numerocreditosdetalleplanestudio
     * @desc getNumerocreditosdetalleplanestudio : Getting value for variable $numerocreditosdetalleplanestudio
     */
    function getNumerocreditosdetalleplanestudio() {
        return $this->numerocreditosdetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $numerocreditosdetalleplanestudio
     * @desc setNumerocreditosdetalleplanestudio : Setting value for $numerocreditosdetalleplanestudio
     */
    function setNumerocreditosdetalleplanestudio($value) {
        $this->numerocreditosdetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $codigoformacionacademica
     * @desc getCodigoformacionacademica : Getting value for variable $codigoformacionacademica
     */
    function getCodigoformacionacademica() {
        return $this->codigoformacionacademica;
    }

    /**
     * @param param : value to be saved in variable $codigoformacionacademica
     * @desc setCodigoformacionacademica : Setting value for $codigoformacionacademica
     */
    function setCodigoformacionacademica($value) {
        $this->codigoformacionacademica = $value;
    }

    /**
     * @return returns value of variable $codigoareaacademica
     * @desc getCodigoareaacademica : Getting value for variable $codigoareaacademica
     */
    function getCodigoareaacademica() {
        return $this->codigoareaacademica;
    }

    /**
     * @param param : value to be saved in variable $codigoareaacademica
     * @desc setCodigoareaacademica : Setting value for $codigoareaacademica
     */
    function setCodigoareaacademica($value) {
        $this->codigoareaacademica = $value;
    }

    /**
     * @return returns value of variable $fechacreaciondetalleplanestudio
     * @desc getFechacreaciondetalleplanestudio : Getting value for variable $fechacreaciondetalleplanestudio
     */
    function getFechacreaciondetalleplanestudio() {
        return $this->fechacreaciondetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $fechacreaciondetalleplanestudio
     * @desc setFechacreaciondetalleplanestudio : Setting value for $fechacreaciondetalleplanestudio
     */
    function setFechacreaciondetalleplanestudio($value) {
        $this->fechacreaciondetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $fechainiciodetalleplanestudio
     * @desc getFechainiciodetalleplanestudio : Getting value for variable $fechainiciodetalleplanestudio
     */
    function getFechainiciodetalleplanestudio() {
        return $this->fechainiciodetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $fechainiciodetalleplanestudio
     * @desc setFechainiciodetalleplanestudio : Setting value for $fechainiciodetalleplanestudio
     */
    function setFechainiciodetalleplanestudio($value) {
        $this->fechainiciodetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $fechavencimientodetalleplanestudio
     * @desc getFechavencimientodetalleplanestudio : Getting value for variable $fechavencimientodetalleplanestudio
     */
    function getFechavencimientodetalleplanestudio() {
        return $this->fechavencimientodetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $fechavencimientodetalleplanestudio
     * @desc setFechavencimientodetalleplanestudio : Setting value for $fechavencimientodetalleplanestudio
     */
    function setFechavencimientodetalleplanestudio($value) {
        $this->fechavencimientodetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $codigoestadodetalleplanestudio
     * @desc getCodigoestadodetalleplanestudio : Getting value for variable $codigoestadodetalleplanestudio
     */
    function getCodigoestadodetalleplanestudio() {
        return $this->codigoestadodetalleplanestudio;
    }

    /**
     * @param param : value to be saved in variable $codigoestadodetalleplanestudio
     * @desc setCodigoestadodetalleplanestudio : Setting value for $codigoestadodetalleplanestudio
     */
    function setCodigoestadodetalleplanestudio($value) {
        $this->codigoestadodetalleplanestudio = $value;
    }

    /**
     * @return returns value of variable $codigotipomateria
     * @desc getCodigotipomateria : Getting value for variable $codigotipomateria
     */
    function getCodigotipomateria() {
        return $this->codigotipomateria;
    }

    /**
     * @param param : value to be saved in variable $codigotipomateria
     * @desc setCodigotipomateria : Setting value for $codigotipomateria
     */
    function setCodigotipomateria($value) {
        $this->codigotipomateria = $value;
    }
}
?>
