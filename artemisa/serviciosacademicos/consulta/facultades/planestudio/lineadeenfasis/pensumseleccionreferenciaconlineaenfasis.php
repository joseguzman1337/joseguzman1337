<?php
if(!isset($_SESSION['MM_Username'])){
    session_start();
}
is_file(dirname(__FILE__) ."/../../../../utilidades/ValidarSesion.php")
    ? include_once(dirname(__FILE__) .'/../../../../utilidades/ValidarSesion.php')
    : include_once(realpath(dirname(__FILE__) .'/../../../../utilidades/ValidarSesion.php'));
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);

?>
<h2>PLAN DE ESTUDIO CON LA LINEA DE ENFASIS <br>
<?php echo strtoupper($row_planestudio['nombrelineaenfasisplanestudio']); ?></h2>
<table width="780" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Plan Estudio</strong></td>
	<td align="center"><strong>Nombre</strong></td>
	<td align="center"><strong>Fecha</strong></td>
  </tr>
  <tr>
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
	<td align="center"><?php
        $datecreacion = new DateTime($row_planestudio['fechacreacionplanestudio']);
        echo $datecreacion->format('Y-m-d'); ?></td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center" colspan="2"><strong>Nombre Encargado</strong></td>
  	<td align="center"><strong>Cargo</strong></td>
  </tr>
  <tr>
	<td align="center" colspan="2"><?php echo $row_planestudio['responsableplanestudio']; ?>
    </td>
	<td align="center"><?php echo $row_planestudio['cargoresponsableplanestudio']; ?>
    </td>
  </tr>
  <tr bgcolor="#C5D5D6">
  	<td align="center"><strong>Nº Semestres</strong></td>
  	<td align="center"><strong>Carrera</strong></td>
	<td align="center"><strong>Autorización Nº</strong></td>
  </tr>
  <tr>
  	<td align="center"><?php echo $row_planestudio['cantidadsemestresplanestudio']; ?></td>
	<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
	<td align="center"><?php echo $row_planestudio['numeroautorizacionplanestudio']; ?></td>
  </tr>
 <tr>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
  	<!-- <td align="center"><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></td>
	<td align="center"><?php echo $row_planestudio['cantidadelectivalibre']; ?></td> -->
	<td align="center"><?php
        $dateinicioplan = new DateTime($row_planestudio['fechainioplanestudio']);
        echo $dateinicioplan->format('Y-m-d'); ?></td>
	<td align="center"><?php
        $datevencimiento = new DateTime($row_planestudio['fechavencimientoplanestudio']);
        echo $datevencimiento->format('Y-m-d'); ?></td>
  </tr>
</table>
<table width="1100" border="1" cellspacing='0' bordercolor='#D76B00'>
  <tr>
      
<?php
$hayelectiva = false;
$totalcreditoselectivas = 0;
$semestrereal = $row_planestudio['cantidadsemestresplanestudio'];
if($row_planestudio['cantidadsemestresplanestudio']<10){
	$row_planestudio['cantidadsemestresplanestudio'] = 10;
}

for($columnasemestre=1; $columnasemestre<=$row_planestudio['cantidadsemestresplanestudio']; $columnasemestre++){
	$cuentamateria[$columnasemestre]=0;
	$query_cojemateriassemestre = "select d.codigomateria, m.nombremateria, m.numerohorassemanales, ".
    " d.numerocreditosdetalleplanestudio, d.codigotipomateria ".
	" from detalleplanestudio d, materia m ".
	" where d.idplanestudio = '$idplanestudio' ".
	" and d.semestredetalleplanestudio = '$columnasemestre' ".
	" and m.codigomateria = d.codigomateria";
	$cojemateriassemestre = mysql_query($query_cojemateriassemestre, $sala) or die("$query_cojemateriassemestre");
	$totalRows_cojemateriassemestre = mysql_num_rows($cojemateriassemestre);
	$cuentacredito[$columnasemestre] = 0;
	$cuentahoras[$columnasemestre] = 0;
	$numeromaterias[$columnasemestre] = 0;
	while($row_cojemateriassemestre = mysql_fetch_assoc($cojemateriassemestre)){
		if($row_cojemateriassemestre['codigotipomateria'] != 5){
			$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
			$credito[$columnasemestre][] = $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			$horas[$columnasemestre][] = $row_cojemateriassemestre['numerohorassemanales'];
			$tipomateria[$columnasemestre][] = $row_cojemateriassemestre['codigotipomateria'];
			$cuentacredito[$columnasemestre] = $cuentacredito[$columnasemestre] + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			$cuentahoras[$columnasemestre] = $cuentahoras[$columnasemestre] + $row_cojemateriassemestre['numerohorassemanales'];
			$numeromaterias[$columnasemestre]++;
			if($row_cojemateriassemestre['codigotipomateria'] == 4){
				$hayelectiva = true;
				$totalcreditoselectivas = $totalcreditoselectivas + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			}
		}
		else
		{
			$query_materiahija = "select d.codigomateriadetallelineaenfasisplanestudio, ".
			" m.nombremateria, d.numerocreditosdetallelineaenfasisplanestudio, d.codigotipomateria, ".
			" m.numerohorassemanales, d.semestredetallelineaenfasisplanestudio ".
			" from detallelineaenfasisplanestudio d, materia m ".
			" where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria ".
			" and d.idlineaenfasisplanestudio = '$idlineaenfasis' ".
			" and d.idplanestudio = '$idplanestudio' ".
			" and d.codigomateria = '".$row_cojemateriassemestre['codigomateria']."'";
			$materiahija = mysql_query($query_materiahija, $sala) or die("$query_materiahija");
			$totalRows_materiahija = mysql_num_rows($materiahija);
			if($totalRows_materiahija != ""){
				while($row_materiahija = mysql_fetch_assoc($materiahija)){
					$semestre[$columnasemestre][] = $row_materiahija['codigomateriadetallelineaenfasisplanestudio']."<br>".$row_materiahija['nombremateria'];
					$credito[$columnasemestre][] = $row_materiahija['numerocreditosdetallelineaenfasisplanestudio'];
					$horas[$columnasemestre][] = $row_materiahija['numerohorassemanales'];
					$tipomateria[$columnasemestre][] = $row_materiahija['codigotipomateria'];
					$cuentacredito[$columnasemestre] = $cuentacredito[$columnasemestre] + $row_materiahija['numerocreditosdetallelineaenfasisplanestudio'];
					$cuentahoras[$columnasemestre] = $cuentahoras[$columnasemestre] + $row_materiahija['numerohorassemanales'];
					$numeromaterias[$columnasemestre]++;
				}
			}
		}
	}
?>
    <td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio'])-2;?>" align="center"><strong><?php echo $columnasemestre;?>&nbsp;</strong> </td>
    <?php
}
?>
  </tr>
  <?php
$query_cuentamateriassemestre = "select d.semestredetalleplanestudio, count(*) as conteo ".
" from detalleplanestudio d ".
" where d.idplanestudio = '$idplanestudio' group by d.semestredetalleplanestudio ".
" order by 2 desc";
$cuentamateriassemestre = mysql_query($query_cuentamateriassemestre, $sala) or die("$query_detalleplanestudio");
$totalRows_cuentamateriassemestre = mysql_num_rows($cuentamateriassemestre);
$row_cuentamateriassemestre = mysql_fetch_assoc($cuentamateriassemestre);
$espacio = false;
$tieneenfasis = false;

for($filamateria=0; $filamateria<=$row_cuentamateriassemestre['conteo']; $filamateria++){
?>
  <tr>
    <?php
	if(!$espacio){
		$espacio = true;
	}
	for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++) {
        $tieneenfasislocal = false;
        $eselectiva = false;
        $materiaesenfasis = false;
        if (isset($semestre[$columnamateria][$cuentamateria[$columnamateria]])) {
            $posmateria = strpos($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
            $codmateria = substr($semestre[$columnamateria][$cuentamateria[$columnamateria]], 0, $posmateria);
            if ($codmateria != "") {
                $query_tieneprerequisitos = "select codigomateria from referenciaplanestudio " .
                    " where idplanestudio = '$idplanestudio' " .
                    " and codigomateria = '$codmateria' " .
                    " and codigotiporeferenciaplanestudio like '1%'";
                $tieneprerequisitos = mysql_query($query_tieneprerequisitos, $sala) or die("$query_tieneprerequisitos");
                $totalRows_tieneprerequisitos = mysql_num_rows($tieneprerequisitos);

                $query_tienecorequisitos = "select codigomateria from referenciaplanestudio " .
                    " where idplanestudio = '$idplanestudio' and codigomateria = '$codmateria' " .
                    " and codigotiporeferenciaplanestudio like '2%'";
                $tienecorequisitos = mysql_query($query_tienecorequisitos, $sala) or die("$query_tienecorequisitos");
                $totalRows_tienecorequisitos = mysql_num_rows($tienecorequisitos);

                $query_tieneequivalencias = "select codigomateria from referenciaplanestudio " .
                    " where idplanestudio = '$idplanestudio' and codigomateria = '$codmateria' " .
                    " and codigotiporeferenciaplanestudio like '3%'";
                $tieneequivalencias = mysql_query($query_tieneequivalencias, $sala) or die("$query_tieneequivalencias");
                $totalRows_tieneequivalencias = mysql_num_rows($tieneequivalencias);

                if ($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#B9B9FF";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneprerequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#CCFFFF";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#C5D6FC";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneequivalencias != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#C8D5E4";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneprerequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#6699CC";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#FFCC33";
                    $cursor = 'style="cursor: pointer"';
                } else if ($totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "#D9FFA0";
                    $cursor = 'style="cursor: pointer"';
                } else if ($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1') {
                    $colorfondo = "";
                    $cursor = 'style="cursor: pointer"';
                } else if ($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '4') {
                    $colorfondo = "";
                    $cursor = "";
                    $eselectiva = true;
                } else {
                    $colorfondo = "#CC9900";
                    $cursor = 'style="cursor: pointer"';
                    $tieneenfasis = true;
                    $materiaesenfasis = true;
                    $tieneenfasislocal = true;
                }
                if (isset($_GET['visualizado'])) {
                    //$cursor = "";
                }
                ?>
                <td width="<?php echo (1000 / $row_planestudio['cantidadsemestresplanestudio']) + 2; ?>" class="Estilo2"
                    align="center" <?php echo $cursor; ?> bgcolor="<?php echo $colorfondo; ?>">
                    <table border="1" class="Estilo2" width="98" height="50">
                        <tr>
                            <td width="10%"><?php echo $credito[$columnamateria][$cuentamateria[$columnamateria]]; ?></td>
                            <td rowspan="2" width="90%">
                                <label style="font-size: 8px" onClick="
                                <?php
                                if (!isset($_GET['visualizado'])) {
                                    if ($eselectiva)
                                        echo "alert('Las electivas no tienen referencias')";
                                    else
                                        echo "window.open('opcionesreferenciaplanestudio.php?planestudio=" . $idplanestudio . "&codigodemateria=" . $codmateria . "&limitesemestre=" . $columnamateria . "&tipomateriaenplan=" . $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] . "&lineaenfasis=" . $idlineaenfasis . "','miventana','width=300,height=220,left=300,top=300')";
                                } else {
                                    if ($eselectiva)
                                        echo "alert('Las electivas no tienen referencias')";
                                    else
                                        echo "window.open('opcionesreferenciaplanestudio.php?planestudio=" . $idplanestudio . "&codigodemateria=" . $codmateria . "&limitesemestre=" . $columnamateria . "&tipomateriaenplan=" . $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] . "&lineaenfasis=" . $idlineaenfasis . "&visualizado','miventana','width=300,height=220,left=300,top=300')";
                                }
                                ?>
                                        "
                                       title="<?php echo ereg_replace("<br>", " ", $semestre[$columnamateria][$cuentamateria[$columnamateria]]); ?>"><strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]]; ?></strong>
                                </label>
                                &nbsp;
                            </td>
                        </tr>
                        <tr>
                            <td width="10%"><?php echo $horas[$columnamateria][$cuentamateria[$columnamateria]]; ?></td>
                        </tr>
                    </table>
                    <?php
                    /*}
                    else
                    {
                        // Imprime las materias que pertenencen a la línea de énfasis
                        $query_materiahija = "select d.codigomateriadetallelineaenfasisplanestudio,
                        m.nombremateria, d.numerocreditosdetallelineaenfasisplanestudio,
                        m.numerohorassemanales, d.semestredetallelineaenfasisplanestudio
                        from detallelineaenfasisplanestudio d, materia m
                        where d.codigomateriadetallelineaenfasisplanestudio = m.codigomateria
                        and d.idlineaenfasisplanestudio = '$idlineaenfasis'
                        and d.idplanestudio = '$idplanestudio'
                        and d.codigomateria = '$codmateria'";
                        $materiahija = mysql_query($query_materiahija, $sala) or die("$query_materiahija");
                        $totalRows_materiahija = mysql_num_rows($materiahija);
                        //$row_selprerequisitos = mysql_fetch_assoc($selprerequisitos);
                        if($totalRows_materiahija != "")
                        {
                            while($row_materiahija = mysql_fetch_assoc($materiahija))
                            {
                                $cuentacredito[$columnamateria] = $cuentacredito[$columnamateria] + $row_materiahija['numerocreditosdetallelineaenfasisplanestudio'];
                                $cuentahoras[$columnamateria] = $cuentahoras[$columnamateria] + $row_materiahija['numerohorassemanales'];
                                $numeromaterias[$columnamateria]++;
                                */
                    ?>
                    <?php
                    //}
                    //}
                    //}
                    ?>
                </td>
                <?php
            } else {
                ?>
                <td>&nbsp;</td>
                <?php
            }
            $cuentamateria[$columnamateria]++;
        }else{
            ?>
            <td>&nbsp;</td>
            <?php
        }
	}//for
?>
  </tr>
  <?php
	//$cuentamateria++;
}
?>
  <tr>
    <?php
$totalcreditos = 0;
$totalhoras = 0;
$totalmaterias = 0;

for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
{
	if($cuentacredito != "")
	{
		$totalcreditos = $totalcreditos + $cuentacredito[$columnamateria];
		$totalhoras = $totalhoras + $cuentahoras[$columnamateria];
		$totalmaterias = $totalmaterias + $numeromaterias[$columnamateria];
?>
    <td width="<?php echo (1000/$row_planestudio['cantidadsemestresplanestudio']);?>" align="center" style=" font-size:11px" <?php if($sintotales[$columnamateria])  echo 'bgcolor="#CCCCCC"';?>><table border="1" class="Estilo2" width="100" height="50">
        <tr>
          <td width="10%" style="font-size: 10px"><strong><?php echo $cuentacredito[$columnamateria];?></strong></td>
          <td rowspan="2" width="90%" align="center"><label  style="font-size: 10px"><strong><?php echo $numeromaterias[$columnamateria];?></strong></label>
&nbsp; </td>
        </tr>
        <tr>
          <td width="10%" style="font-size: 10px"><strong><?php echo $cuentahoras[$columnamateria];?></strong></td>
        </tr>
    </table></td>
    <?php
	}
	else
	{
?>
    <td>&nbsp;</td>
    <?php
	}
}
?>
  </tr>
  <tr>
    <td colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>" align="center"><table border="1" class="Estilo2" cellpadding="2" cellspacing="1" bordercolor="#003333">
        <tr>
          <td>
		  <table border="1" class="Estilo2" width="104" height="50" cellpadding="2" cellspacing="1" bordercolor="#003333">
              <tr>
                <td width="10%" style="font-size: 10px"><strong>Créditos</strong></td>
                <td rowspan="2" width="90%" align="center" valign="bottom"><label  style="font-size: 10px"><strong>Código<br>
                  Asignatura<br>
                  <br>
                  o<br>
                  <br>
                  Materias</strong></label>
&nbsp;</td>
              </tr>
              <tr>
                <td width="10%" style="font-size: 10px"><strong>Horas</strong></td>
              </tr>
          </table>
		  </td>
          <td>
		  <table align="center" border="0" height="80">
          	  <tr>
             	<td style="font-size: 12px"><strong>Sin Referenciar</strong></td>
              	<td bgcolor="#CC9900" style="font-size: 12px"><strong>Línea de Enfasis</strong></td>
              </tr>
              <tr>
              	<td bgcolor="#6699CC" style="font-size: 12px"><strong>Prerequisitos</strong></td>
              	<td bgcolor="#C5D6FC" style="font-size: 12px"><strong>Prerequisitos y Corequisitos</strong></td>
			  </tr>
              <tr>
              	<td bgcolor="#FFCC33" style="font-size: 12px"><strong>Corequisitos</strong></td>
                <td bgcolor="#CCFFFF" style="font-size: 12px"><strong>Prerequisitos y Equivalencias</strong></td>
              </tr>
              <tr>
                <td bgcolor="#D9FFA0" style="font-size: 12px"><strong>Equivalencias</strong></td>
				<td bgcolor="#C8D5E4" style="font-size: 12px"><strong>Corequisitos y Equivalencias</strong></td>
              </tr>
              <tr>
                <td bgcolor="#B9B9FF" colspan="2" style="font-size: 12px"><strong>Prerequisitos, Corequisitos y Equivalencias</td>
              </tr>
          </table>
		  </td>
<?php
if($hayelectiva)
{
?>
		  <td>
		  <table align="center" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
		    <tr>
		  	  <td align="center" style="font-size: 12px"><strong>Total de Créditos <br> Electivas</strong></td>
		    </tr>
			<tr>
			  <td align="center" style="font-size: 12px"><?php echo $totalcreditoselectivas;?></td>
			</tr>
		  </table>
		  </td>
<?php
}
?>
       </tr>
    </table>
	</td>
  </tr>
  <tr>
    <td colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>" align="center"><table align="center">
        <tr>
          <td><strong>Creditos:</strong></td>
          <td><?php echo $totalcreditos; ?></td>
          <td></td>
          <td></td>
          <td><strong>Horas:</strong></td>
          <td><?php echo $totalhoras; ?></td>
          <td></td>
          <td></td>
          <td><strong>Materias:</strong></td>
          <td><?php echo $totalmaterias; ?></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>">
<?php
if(isset($_GET['visualizado']))
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="window.location.href='lineadeenfasisinicial.php?planestudio=<?php echo "$idplanestudio&visualizado";?>'">
<?php
}
else
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="window.location.href='visualizarlineadeenfasis.php?planestudio=<?php echo "$idplanestudio&lineaenfasis=$idlineaenfasis";?>'">
<?php
}
if($tieneenfasis)
{
	if(!isset($_GET['visualizado']))
	{
?>
        <input type="button" name="lineasenfasis" value="Otra Linea de Enfasis" onClick="window.location.href='lineadeenfasisinicial.php?planestudio=<?php  echo $idplanestudio;?>'">
<?php
	}
	else
	{
?>
        <input type="button" name="lineasenfasis" value="Otra Linea de Enfasis" onClick="window.location.href='lineadeenfasisinicial.php?planestudio=<?php  echo "$idplanestudio&visualizado";?>'">
<?php
	}
}
?>
        <input type="button" name="salir" value="Salir" onClick="window.location.href='../plandeestudioinicial.php'">
    </td>
  </tr>
</table>
