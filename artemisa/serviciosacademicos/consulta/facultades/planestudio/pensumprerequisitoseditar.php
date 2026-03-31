<?php
is_file(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php")
    ? require_once(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php")
    : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

if(!isset ($_SESSION['MM_Username'])) {
    session_start();
}
    include_once(realpath(dirname(__FILE__)).'/../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
//validacion de fecha inicial
if(isset($fechainicio) && !empty($fechainicio)){
    if($fechainicio == "0000-00-00 00:00:00"){
        $fechainicio = date('Y-m-d');
    }else{
        $date = new DateTime($fechainicio);
        $fechainicio = $date->format('Y-m-d');
    }
}
else if(isset($_POST['finicioprerequisito'])){
    $fechainicio =  $_POST['finicioprerequisito'];
}
//validacion de fecha final
if(isset($fechavencimiento) && !empty($fechavencimiento)){
    if($fechavencimiento == "0000-00-00 00:00:00"){
        $fechavencimiento  = "2099-12-31";
    }else {
        $date = new DateTime($fechavencimiento);
        $fechavencimiento = $date->format('Y-m-d');
    }
}else if(isset($_POST['fvencimientoprerequisito'])){
    $fechavencimiento = $_POST['fvencimientoprerequisito'];
}

if(isset($_POST['finicioprerequisito']) && !empty($_POST['finicioprerequisito'])){
    $fechainicio = $_POST['finicioprerequisito'];
    $imprimir = true;
    $fechainiciofecha = validar($fechainicio,"fecha",$error3,$imprimir);

    $formulariovalido = $formulariovalido*$fechainiciofecha;
    if($formulariovalido == 1){
        $inicio = new DateTime($_POST['finicioprerequisito']);
        $vencimiento = new DateTime($_POST['fvencimientoprerequisito']);
        if($inicio > $vencimiento){
            $msgfechainicio =  "La Fecha de Inicio debe ser menor que la Fecha de Vencimiento";
            $formulariovalido = 0;
        }
        if($inicio == $vencimiento){
            $msgfechainicio =  "La Fecha de Inicio debe ser diferente que la Fecha de Vencimiento";
            $formulariovalido = 0;
        }
    }
}

if(!isset($msgfechainicio) || empty($msgfechainicio)){
    $msgfechainicio = "";
}

if(isset($_POST['fvencimientoprerequisito']) && !empty($_POST['fvencimientoprerequisito'])){
    $fechavencimiento = $_POST['fvencimientoprerequisito'];
    $imprimir = true;
    $fechavencimientofecha = validar($fechavencimiento,"fecha",$error3,$imprimir);
    $formulariovalido = $formulariovalido*$fechavencimientofecha;
    if($formulariovalido == 1){
        $inicio = new DateTime($_POST['finicioprerequisito']);
        $vencimiento = new DateTime($_POST['fvencimientoprerequisito']);
        if($inicio > $vencimiento){
            $msgfechavenicimiento =  "La Fecha de Vencimiento debe ser mayor que la Fecha de Vencimiento";
            $formulariovalido = 0;
        }
        if($inicio == $vencimiento){
            $msgfechavenicimiento =  "La Fecha de Vencimiento debe ser diferente que la Fecha de Inicio";
            $formulariovalido = 0;
        }
    }
}

if(!isset($msgfechavenicimiento) || empty($msgfechavenicimiento)){
    $msgfechavenicimiento = "";
}

?>
<h2>SELECCION DE PREREQUISITOS</h2>
<input type="hidden" name="tipodereferencia" value="<?php echo $Vartipodereferencia;?>">
<input type="hidden" name="editar" value="<?php echo $limite;?>">
<input type="hidden" name="codigodemateria" value="<?php echo $Varcodigodemateria;?>">
</p>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
	<td width="50%" align="center" class="Estilo1"><strong>Nombre Materia</strong></td>
	<td width="50%" align="center" class="Estilo1"><strong>Codigo Materia</strong></td>
  </tr>
  <tr>
	<td align="center" class="Estilo1"><?php echo $row_referenciasmateria['nombremateria']; ?></td>
	<td align="center" class="Estilo1"><?php echo $Varcodigodemateria; ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center" colspan="2"><strong>Nombre Plan de Estudio</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center" colspan="2">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Fecha Inicio Prerequisito</strong></td>
	<td align="center" colspan="2"><strong>Fecha Vencimiento Prerequisito</strong></td>
  </tr>
  <tr>
	<td align="center">
        <input type="text" name="finicioprerequisito" placeholder="aaaa-mm-dd"
               value="<?php echo $fechainicio;?>" size="10" onBlur="iniciarinicio(this)" onFocus="limpiarinicio(this)">
	  <font size="1" face="Tahoma"><font color="#FF0000">
	  <?php echo $msgfechainicio; ?>
    </font></font></td>
	<td align="center" colspan="2">
        <input type="text" name="fvencimientoprerequisito" placeholder="2999-12-31"
               value="<?php echo $fechavencimiento;?>" size="10" onBlur="iniciarvencimiento(this)" onFocus="limpiarvencimiento(this)">
	  <font size="1" face="Tahoma"><font color="#FF0000">
	  <?php echo $msgfechavenicimiento; ?>
    </font></font></td>
  </tr>
</table>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#D76B00">
<tr>
<?php
for($columnasemestre=1; $columnasemestre<=$row_planestudio['cantidadsemestresplanestudio']; $columnasemestre++){
	$cuentamateria[$columnasemestre]=0;
	$query_cojemateriassemestre = "select d.codigomateria, m.nombremateria, d.codigotipomateria ".
	" from detalleplanestudio d, materia m where d.idplanestudio = '$idplanestudio' ".
	" and d.semestredetalleplanestudio = '$columnasemestre' ".
	" and m.codigomateria = d.codigomateria";
	$cojemateriassemestre = $db->GetAll($query_cojemateriassemestre);
	$totalRows_cojemateriassemestre = count($cojemateriassemestre);
	foreach($cojemateriassemestre as $row_cojemateriassemestre){
		if($estaEnenfasis == "no"){
			$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
			$tipomateria[$columnasemestre][] = $row_cojemateriassemestre['codigotipomateria'];
		}
		else{
			if($row_cojemateriassemestre['codigotipomateria'] != 5){
				$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
				$tipomateria[$columnasemestre][] = $row_cojemateriassemestre['codigotipomateria'];
			}
			else{
				$query_materiahija = "select d.codigomateriadetallelineaenfasisplanestudio, ".
				" m.nombremateria, d.numerocreditosdetallelineaenfasisplanestudio, d.codigotipomateria, ".
				" m.numerohorassemanales, d.semestredetallelineaenfasisplanestudio ".
				" from detallelineaenfasisplanestudio d, materia m ".
				" where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria ".
				" and d.idlineaenfasisplanestudio = '$idlineaenfasis' ".
				" and d.idplanestudio = '$idplanestudio' ".
				" and d.codigomateria = '".$row_cojemateriassemestre['codigomateria']."'";
				$materiahija = $db->GetAll($query_materiahija);
				$totalRows_materiahija = count($materiahija);
				if($totalRows_materiahija != ""){
					foreach($materiahija as $row_materiahija){
						$semestre[$columnasemestre][] = $row_materiahija['codigomateriadetallelineaenfasisplanestudio']."<br>".$row_materiahija['nombremateria'];
						$tipomateria[$columnasemestre][] = $row_materiahija['codigotipomateria'];
					}
				}
			}
		}
	}
?>
	<td width="<?php echo (780/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" align="center">
        <strong><?php echo $columnasemestre;?>&nbsp;</strong>
    </td>
<?php
}
?>
</tr>
<?php
$query_cuentamateriassemestre = "select d.semestredetalleplanestudio, count(*) as conteo ".
" from detalleplanestudio d where d.idplanestudio = '$idplanestudio' ".
" group by d.semestredetalleplanestudio  order by 2 desc";
$cuentamateriassemestre = $db->GetRow($query_cuentamateriassemestre);
$totalRows_cuentamateriassemestre = count($cuentamateriassemestre);
$row_cuentamateriassemestre = $cuentamateriassemestre;

if(isset($row_cuentamateriassemestre2['semestredetalleplanestudio']) && !empty($row_cuentamateriassemestre2['semestredetalleplanestudio'])){
    $query_cuentamateriassemestre2 = "select dl.semestredetallelineaenfasisplanestudio ".
    " from detallelineaenfasisplanestudio dl where dl.idplanestudio = '$idplanestudio' ".
    " and idlineaenfasisplanestudio = '$idlineaenfasis' ".
    " and semestredetallelineaenfasisplanestudio = '".$row_cuentamateriassemestre2['semestredetalleplanestudio']."'";
    $cuentamateriassemestre2 = $db->GetRow($query_cuentamateriassemestre2);
    $totalRows_cuentamateriassemestre2 = count($cuentamateriassemestre2);
    $row_cuentamateriassemestre2 = $cuentamateriassemestre2;
}else{
    $row_cuentamateriassemestre2['semestredetallelineaenfasisplanestudio'] = "";
}

for($filamateria=0; $filamateria<=($row_cuentamateriassemestre['conteo']+$row_cuentamateriassemestre2['semestredetallelineaenfasisplanestudio']); $filamateria++){
    ?>
    <tr>
    <?php
	for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++) {
        if (isset($semestre[$columnamateria][$cuentamateria[$columnamateria]]) &&
            !empty($semestre[$columnamateria][$cuentamateria[$columnamateria]])) {
            $posmateria = strpos($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
            $codmateria = substr($semestre[$columnamateria][$cuentamateria[$columnamateria]], 0, $posmateria);

            if ($codmateria != $Varcodigodemateria) {
                if ($columnamateria <= $limite) {
                    ?>
                <td width="<?php echo (780 / $row_planestudio['cantidadsemestresplanestudio']) - 2; ?>"
                    class="Estilo2" align="center">
                    <strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]]; ?></strong>
                    <?php
                    if (isset($codmateria) && !empty($codmateria)) {
                        if ($estaEnenfasis == "si") {
                            ?>
                            <input type="checkbox" name="<?php echo "prerequisito$codmateria"; ?>"
                                   value="<?php echo "$codmateria"; ?>" class="Estilo3"
                                <?php
                                $esprerequisito = false;
                                if (isset($Arregloprerequisitos)) {
                                    foreach ($Arregloprerequisitos as $key3 => $selPrerequisitos) {
                                        if ($selPrerequisitos['codigomateriareferenciaplanestudio'] == $codmateria) {
                                            $esprerequisito = true;
                                            echo "checked";
                                        }
                                    }//foreach
                                }
                                ?>
                            ></td>
                            <?php
                        }
                        if ($estaEnenfasis == "no") {
                            if ($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] != '5') {
                                ?>
                                <input type="checkbox" name="<?php echo "prerequisito$codmateria"; ?>"
                                       value="<?php echo "$codmateria"; ?>" class="Estilo3"
                                    <?php
                                    $esprerequisito = false;
                                    if (isset($Arregloprerequisitos)) {
                                        foreach ($Arregloprerequisitos as $key3 => $selPrerequisitos) {
                                            if ($selPrerequisitos['codigomateriareferenciaplanestudio'] == $codmateria) {
                                                $esprerequisito = true;
                                                echo "checked";
                                            }
                                        }//foreach
                                    }
                                    ?>
                                ></td>
                                <?php
                            }
                        }
                    }
                } else {
                    ?>
                    <td>&nbsp;</td>
                    <?php
                }
            } else {
                ?>
                <td width="<?php echo (780 / $row_planestudio['cantidadsemestresplanestudio']) - 2; ?>"
                    class="Estilo2" bgcolor="#FFCC99" align="center">
                    <strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]]; ?></strong>&nbsp;
                </td>
                <?php
            }
            $cuentamateria[$columnamateria]++;
        }//if
        else {
            ?>
            <td>&nbsp;</td>
            <?php
        }
	}//for
    ?>
    </tr>
    <?php
}//for
?>
  <tr>
	<td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>">
        <input type="submit" name="aceptarprerequisitos" value="Aceptar">
        <?php
        if($estaEnenfasis == "no"){
            ?>
	        <input type="button" name="regresar" value="Regresar"
                   onClick="window.location.href='materiasporsemestre.php?planestudio=<?php echo "$idplanestudio";?>'">
            <?php
        }
        else{
            ?>
	        <input type="button" name="regresar" value="Regresar"
            onClick="window.location.href='materiaslineadeenfasisporsemestre.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>'">
            <?php
        }
        ?>
	</td>
  </tr>
</table>
