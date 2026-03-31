<?php
    session_start();
    include_once('../../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
?>    
<link rel="stylesheet" href="../../../../estilos/sala.css" type="text/css">

<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->

.Estilo2{
    border-collapse:collapse;
}
</style>
<?php  if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
<div id="tableDiv">
    <?php } ?>
<table width="50%"  border="0" align="center" cellpadding="3" cellspacing="3">
    <?php if (!isset($reporteporsemestre)) { ?>
<TR><TD><img src="../../../../../imagenes/noticias_logo.gif" height="71" ></TD></TR>
    <?php } ?>
<TR><TD align="center"><h3 style="font-weight:bold;">PLAN DE ESTUDIO<?php if (isset($reporteporsemestre) && $reporteporsemestre==true) {echo ": ".$row_planestudio['nombreplanestudio']; } ?></h3></TD></TR>
</table>
<?php if (!isset($reporteporsemestre)) { ?>
<table width="780"  cellpadding="2" cellspacing="1" bordercolor="#003333">
  <tr id="trgris" >
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Plan Estudio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Nombre</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center"><?php echo $idplanestudio; ?></td>
	<td align="center">	 <?php echo $row_planestudio['nombreplanestudio']; ?>	  </td>
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechacreacionplanestudio']); ?></td>
  </tr>
  <tr id="trgris">
  	<td align="center" colspan="2" bgcolor="#C5D5D6"><strong>Nombre Encargado</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Cargo</strong></td>
  </tr>
  <tr id="trgris">
	<td align="center" colspan="2"><?php echo $row_planestudio['responsableplanestudio']; ?>
    </td>
	<td align="center"><?php echo $row_planestudio['cargoresponsableplanestudio']; ?>
    </td>
  </tr>
  <tr id="trgris">
  	<td align="center" bgcolor="#C5D5D6"><strong>Nº Semestres</strong></td>
  	<td align="center" bgcolor="#C5D5D6"><strong>Carrera</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Autorización Nº</strong></td>
  </tr>
  <tr id="trgris">
  	<td align="center"><?php echo $row_planestudio['cantidadsemestresplanestudio']; ?></td>
	<td align="center"><?php echo $row_planestudio['nombrecarrera']; ?></td>
	<td align="center" ><?php echo $row_planestudio['numeroautorizacionplanestudio']; ?></td>
  </tr>
 <tr id="trgris">
  	<!-- <td align="center"><strong>Tipo de Electivas</strong></td>
	<td align="center"><strong>Cantidad</strong></td> -->
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Inicio</strong></td>
	<td align="center" bgcolor="#C5D5D6"><strong>Fecha de Vencimiento</strong></td>
	<td rowspan="2">&nbsp;</td>
  </tr>
  <tr id="trgris">
  	<!-- <td align="center"><?php echo $row_planestudio['nombretipocantidadelectivalibre']; ?></td>
	<td align="center"><?php echo $row_planestudio['cantidadelectivalibre']; ?></td> -->
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechainioplanestudio']); ?></td>
	<td align="center"><?php echo ereg_replace("[0-9]+:[0-9]+:[0-9]+","",$row_planestudio['fechavencimientoplanestudio']); ?></td>
  </tr>
</table>
<?php } ?>
<table width="1100" border="1" cellpadding='0' cellspacing='0' bordercolor='#FFE6B1' >
  <tr>
<?php
$hayelectiva = false;
$totalcreditoselectivas = 0;
$semestrereal = $row_planestudio['cantidadsemestresplanestudio'];
if($row_planestudio['cantidadsemestresplanestudio']<10)
{
	$row_planestudio['cantidadsemestresplanestudio'] = 10;
}
for($columnasemestre=1; $columnasemestre<=$row_planestudio['cantidadsemestresplanestudio']; $columnasemestre++)
{
	$cuentamateria[$columnasemestre]=0;
	$query_cojemateriassemestre = "select d.codigomateria, m.nombremateria, m.numerohorassemanales, d.numerocreditosdetalleplanestudio, d.codigotipomateria
	from detalleplanestudio d, materia m
	where d.idplanestudio = '$idplanestudio'
	and d.semestredetalleplanestudio = '$columnasemestre'
	and m.codigomateria = d.codigomateria";
	$cojemateriassemestre = mysql_query($query_cojemateriassemestre, $sala) or die("$query_cojemateriassemestre");
	$totalRows_cojemateriassemestre = mysql_num_rows($cojemateriassemestre);
	$cuentacredito[$columnasemestre] = 0;
	$cuentahoras[$columnasemestre] = 0;
	$numeromaterias[$columnasemestre] = 0;
	while($row_cojemateriassemestre = mysql_fetch_assoc($cojemateriassemestre))
	{
		$semestre[$columnasemestre][] = $row_cojemateriassemestre['codigomateria']."<br>".$row_cojemateriassemestre['nombremateria'];
		$credito[$columnasemestre][] = $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
		$horas[$columnasemestre][] = $row_cojemateriassemestre['numerohorassemanales'];
		$tipomateria[$columnasemestre][] = $row_cojemateriassemestre['codigotipomateria'];
		$sintotales[$columnasemestre] = true;
		if($row_cojemateriassemestre['codigotipomateria'] != 5)
		{
			$cuentacredito[$columnasemestre] = $cuentacredito[$columnasemestre] + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			$cuentahoras[$columnasemestre] = $cuentahoras[$columnasemestre] + $row_cojemateriassemestre['numerohorassemanales'];
			$numeromaterias[$columnasemestre]++;
			$sintotales[$columnasemestre] = false;
		}
		else
		{
			$cuentacredito[$columnasemestre] = $cuentacredito[$columnasemestre] + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
			$cuentahoras[$columnasemestre] = $cuentahoras[$columnasemestre] + $row_cojemateriassemestre['numerohorassemanales'];
			$numeromaterias[$columnasemestre]++;
			$haytecnica[$columnasemestre] = true;
		}
		if($row_cojemateriassemestre['codigotipomateria'] == 4)
		{
			$hayelectiva = true;
			$totalcreditoselectivas = $totalcreditoselectivas + $row_cojemateriassemestre['numerocreditosdetalleplanestudio'];
		}
		//$semestre[$columnasemestre][] = $row_cojemateriassemestre['nombremateria'];
	}
?>
    <td align="center"><strong><?php echo $columnasemestre;?>&nbsp;</strong> </td>
    <?php
}
?>
  </tr>
<?php
$query_cuentamateriassemestre = "select d.semestredetalleplanestudio, count(*) as conteo
from detalleplanestudio d
where d.idplanestudio = '$idplanestudio'
group by d.semestredetalleplanestudio
order by 2 desc";
$cuentamateriassemestre = mysql_query($query_cuentamateriassemestre, $sala) or die("$query_detalleplanestudio");
$totalRows_cuentamateriassemestre = mysql_num_rows($cuentamateriassemestre);
$row_cuentamateriassemestre = mysql_fetch_assoc($cuentamateriassemestre);
$espacio = false;
$tieneenfasis = false;

for($filamateria=1; $filamateria<=$row_cuentamateriassemestre['conteo']; $filamateria++)
{
	$materiaesenfasis = false;
?>
  <tr>
    <?php
	if(!$espacio)
	{
		$espacio = true;
	}
	for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
	{
		$posmateria = strpos ($semestre[$columnamateria][$cuentamateria[$columnamateria]], "<br>");
		$codmateria = substr ($semestre[$columnamateria][$cuentamateria[$columnamateria]],0,$posmateria);
		$eselectiva = false;
		$materiaesenfasis = false;
		if($codmateria != "")
		{
                    
                
                if (isset($reporteporsemestre) && $reporteporsemestre==true) {
                    //toca averiguar matriculados y grupos
                    
                    $querygrupos = "select idgrupo from grupo where codigoperiodo='".$codigoperiodo."' 
                    and codigomateria='".$codmateria."'";
                       $resultado = mysql_query($querygrupos, $sala) or die("$querygrupos");
                        $grupo[$columnamateria][$cuentamateria[$columnamateria]] = mysql_num_rows($resultado);
                      
                      
                    /*$querygrupos = "select idgrupo from grupo where codigoperiodo='".$codigoperiodo."' 
                    and codigomateria='".$codmateria."' GROUP BY numerodocumento";
                       $resultado = mysql_query($querygrupos, $sala) or die("$querygrupos");
                       $docente[$columnamateria][$cuentamateria[$columnamateria]] = mysql_num_rows($resultado);*/
                        
                        //todos los matriculados en la materia
                       /*$query ="select * from prematricula pr 
                        inner join detalleprematricula dp on dp.idprematricula=pr.idprematricula 
                        where pr.codigoperiodo='".$codigoperiodo."'  and pr.codigoestadoprematricula IN (40,41) 
                            and dp.codigomateria='".$codmateria."' and dp.codigoestadodetalleprematricula=30";*/
                        
                        //todos los matriculados en la materia que pertenezcan al plan de estudios
                       $query ="select pr.*,dp.* from prematricula pr 
                        inner join detalleprematricula dp on dp.idprematricula=pr.idprematricula 
                        inner join planestudioestudiante pe on pe.codigoestudiante=pr.codigoestudiante and pe.idplanestudio='".$idplanestudio."' 
                            and pe.codigoestadoplanestudioestudiante!=200 
                        where pr.codigoperiodo='".$codigoperiodo."'  and pr.codigoestadoprematricula IN (40,41) 
                            and dp.codigomateria='".$codmateria."' and dp.codigoestadodetalleprematricula=30";
                       //echo $query;
                       $resultado = mysql_query($query, $sala) or die("$query");
                        $estudiantes[$columnamateria][$cuentamateria[$columnamateria]] = mysql_num_rows($resultado);
                }
                    
                    
			$query_tieneprerequisitos = "select codigomateria
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '1%'";
			$tieneprerequisitos = mysql_query($query_tieneprerequisitos, $sala) or die("$query_tieneprerequisitos");
			$totalRows_tieneprerequisitos = mysql_num_rows($tieneprerequisitos);

			$query_tienecorequisitos = "select codigomateria
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '2%'";
			$tienecorequisitos = mysql_query($query_tienecorequisitos, $sala) or die("$query_tienecorequisitos");
			$totalRows_tienecorequisitos = mysql_num_rows($tienecorequisitos);

			$query_tieneequivalencias = "select codigomateria
			from referenciaplanestudio
			where idplanestudio = '$idplanestudio'
			and codigomateria = '$codmateria'
			and codigotiporeferenciaplanestudio like '3%'";
			$tieneequivalencias = mysql_query($query_tieneequivalencias, $sala) or die("$query_tieneequivalencias");
			$totalRows_tieneequivalencias = mysql_num_rows($tieneequivalencias);

			//$row_seltiporeferencia = mysql_fetch_assoc($tieneprerequisitos);
			//echo $row_seltiporeferencia['codigotiporeferenciaplanestudio']."ASKLA";
			//exit();
                        $ponercursor = false;
                        if (!isset($reporteporsemestre)) { 
                            $ponercursor = true;
                        }
                        
			if($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#B9B9FF";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}

			}
			else if($totalRows_tieneprerequisitos != "" && $totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#CCFFFF";				
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
 			}
			else if($totalRows_tieneprerequisitos != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#C5D6FC";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
			}
			else if($totalRows_tieneequivalencias != "" && $totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#C8D5E4";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
			}
			else if($totalRows_tieneprerequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#6699CC";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
			}
			else if($totalRows_tienecorequisitos != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#FFCC33";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
			}
			else if($totalRows_tieneequivalencias != "" && $tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "#D9FFA0";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
			}
			else if($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '1')
			{
				$colorfondo = "";
                                if($ponercursor){$cursor = 'style="cursor: pointer"';}
			}
			else if($tipomateria[$columnamateria][$cuentamateria[$columnamateria]] == '4')
			{
				$colorfondo = "";
				$cursor = "";
				$eselectiva = true;
			}
			else
			{
				$colorfondo = "#CC9900";
				$cursor = "";
				$tieneenfasis = true;
				$materiaesenfasis = true;
			}
			if(isset($_GET['visualizado']))
			{
				//$cursor = "";
			}
?>
	<td class="Estilo2" align="center" <?php echo $cursor; ?> bgcolor="<?php echo $colorfondo; ?>">
        <table border="1" class="Estilo2" width="120" height="60">
          <tr>
            <td width="15%" class="estilostd"><?php echo $credito[$columnamateria][$cuentamateria[$columnamateria]];?></td>
            <td rowspan="2"<?php if (!isset($reporteporsemestre)) { ?> width="85%" <?php } else { ?> width="70%" <?php } ?>><?php // si es solo visualizar, haz todo normal 
                if (!isset($reporteporsemestre)) { ?>
			<label  style="font-size: 8px" onClick="
<?php
			if(!isset($_GET['visualizado']))
			{
				if($eselectiva)
					echo "alert('Las electivas no tienen referencias')";
				else if(!$materiaesenfasis)
					echo "window.open('opcionesreferenciaplanestudio.php?planestudio=".$idplanestudio."&codigodemateria=".$codmateria."&limitesemestre=".$columnamateria."&tipomateriaenplan=".$tipomateria[$columnamateria][$cuentamateria[$columnamateria]]."&lineaenfasis=1','miventana','width=300,height=220,left=300,top=300')";
				else echo "alert('Oprima el boton Líneas de Enfasis')";
			}
			else
			{
				if($eselectiva)
					echo "alert('Las electivas no tienen referencias')";
				else if(!$materiaesenfasis)
					echo "window.open('opcionesreferenciaplanestudio.php?planestudio=".$idplanestudio."&codigodemateria=".$codmateria."&limitesemestre=".$columnamateria."&tipomateriaenplan=".$tipomateria[$columnamateria][$cuentamateria[$columnamateria]]."&lineaenfasis=1&visualizado','miventana','width=300,height=220,left=300,top=300')";
				else echo "alert('Oprima el boton Líneas de Enfasis')";
			}
?>
				" title="<?php echo ereg_replace("<br>"," ",$semestre[$columnamateria][$cuentamateria[$columnamateria]]);?>"><strong><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></strong>
			</label>
                <?php } else { 
                    //si es el reporte => no debe tener acciones onclick ?>
                <div><?php echo $semestre[$columnamateria][$cuentamateria[$columnamateria]];?></div>
               <?php } ?>
</td>
            <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
                <td width="15%" class="estilostd"><?php echo $grupo[$columnamateria][$cuentamateria[$columnamateria]];?></td>
            <?php } ?>
          </tr>
          <tr>
            <td width="15%" ><?php echo $horas[$columnamateria][$cuentamateria[$columnamateria]];?></td>
            <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
                <td width="15%" ><?php echo $estudiantes[$columnamateria][$cuentamateria[$columnamateria]];?></td>
            <?php } ?>
          </tr>
      </table></td>
    <?php
                if (isset($reporteporsemestre) && $reporteporsemestre==true) {
                    $cuentagrupos[$columnamateria]+=$grupo[$columnamateria][$cuentamateria[$columnamateria]];
                }
                
		}
		else
		{
?>
    <td>&nbsp;</td>
    <?php
		}
		$cuentamateria[$columnamateria]++;
               
	}
?>
  </tr>
  <?php
	//$cuentamateria++;
}
?>
  </table>
    <table width="1100" border="1" cellpadding='0' cellspacing='0' style="margin-top:10px;" class="separar">
        <tr>
            <th colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio']; ?>">Cuadro resumen</th>
        </tr>
  <tr>
    <?php
$totalcreditos = 0;
$totalhoras = 0;
$totalmaterias = 0;
$totalEstudiantesFinal = 0;
$mostrarbotonenfasis = true;
for($columnamateria=1; $columnamateria<=$row_planestudio['cantidadsemestresplanestudio']; $columnamateria++)
{
    if (isset($reporteporsemestre) && $reporteporsemestre==true) {
        //toca los matriculados en el semestre
        $query = "select pr.codigoestudiante from prematricula pr 
                inner join planestudioestudiante pe on pe.codigoestudiante=pr.codigoestudiante and pe.idplanestudio='".$idplanestudio."' 
                    and pe.codigoestadoplanestudioestudiante!=200 
                where pr.codigoperiodo='".$codigoperiodo."' and pr.codigoestadoprematricula IN (40,41)
                and pr.semestreprematricula='".$columnamateria."'";
        $resultado = mysql_query($query, $sala) or die("$query");
        $totalEstudiantes = mysql_num_rows($resultado);
                $totalEstudiantesFinal += $totalEstudiantes; 
    }
	if($cuentacredito != "")
	{
		$totalcreditos = $totalcreditos + $cuentacredito[$columnamateria];
		$totalhoras = $totalhoras + $cuentahoras[$columnamateria];
		$totalmaterias = $totalmaterias + $numeromaterias[$columnamateria];
?>
    <td align="center" <?php if($haytecnica[$columnamateria])  echo 'bgcolor="#CCCCCC"';?>>
	<table border="1" class="Estilo2" width="120" height="60">
        <tr>
          <td width="15%" class="bordes"><strong><?php echo $cuentacredito[$columnamateria];?></strong></td>
          <td rowspan="2" <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?> width="70%" class="bordes" <?php } else { ?> width="85%" <?php } ?> align="center"><label  ><strong><?php echo $numeromaterias[$columnamateria];?></strong></label>
&nbsp; </td>
          
            <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
                <td width="15%" class="bordes"><?php echo $cuentagrupos[$columnamateria];?></td>
            <?php } ?>
        </tr>
        <tr>
          <td width="15%" class="bordes"><strong><?php echo $cuentahoras[$columnamateria];?></strong></td>
          
            <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
                <td width="15%" class="bordes"><?php echo $totalEstudiantes;?></td>
            <?php } ?>
        </tr>
    </table></td>
    <?php 
		if($columnamateria <= $semestrereal && $numeromaterias[$columnamateria] == 0)
		{
			$mostrarbotonenfasis = false;
		}
?>
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
  </table>
    <table width="1100" border="0" cellpadding='2' cellspacing='1' style="margin-top:10px;"  align="center" class="separar">
  <tr  id="trgris">
    <td colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>" align="center">
	<table align="center" border="1" cellpadding="2" cellspacing="1" bordercolor="#B0B6C2">
        <tr  id="trgris">
          <td>
		  <table border="1" width="154" height="50" align="center" cellpadding="2" cellspacing="1" bordercolor="#B0B6C2">
              <tr  id="trgris">
                <td width="20%" ><strong>Créditos</strong></td>
                <td rowspan="2" <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>width="60%"<?php } else { ?> width="80%"<?php } ?> align="center" ><div style="font-size:10px;font-weight: bold;">Código<br>
                  Asignatura
                  <br/>
                  o
                  <br/>
                  Materias</div></td>
                <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
                <td width="20%" ><strong>Grupos</strong></td>
                <?php } ?>
              </tr>
              <tr id="trgris">
                <td width="20%" ><strong>Horas</strong></td>
                 <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
                <td width="20%" ><strong>Estudiantes matriculados</strong></td>
                <?php } ?>
              </tr>
          </table>
		  </td>
          <td>
		  <table align="center" border="0" height="80">
              <tr>
                <td ><strong>Sin Referenciar</strong></td>
                <td bgcolor="#CC9900" ><strong>Línea de Enfasis</strong></td>
              </tr>
              <tr>
                <td bgcolor="#6699CC" ><strong>Prerequisitos</strong></td>
                <td bgcolor="#C5D6FC" ><strong>Prerequisitos y Corequisitos</strong></td>
              </tr>
              <tr>
                <td bgcolor="#FFCC33" ><strong>Corequisitos</strong></td>
                <td bgcolor="#CCFFFF" ><strong>Prerequisitos y Equivalencias</strong></td>
              </tr>
              <tr>
                <td bgcolor="#D9FFA0" ><strong>Equivalencias</strong></td>
                <td bgcolor="#C8D5E4" ><strong>Corequisitos y Equivalencias</strong></td>
              </tr>
              <tr>
                <td bgcolor="#B9B9FF" colspan="2" ><strong>Prerequisitos, Corequisitos y Equivalencias</strong></td>
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
		  	  <td align="center" ><strong>Total de Créditos <br> Electivas</strong></td>
		    </tr>
			<tr>
			  <td align="center" ><?php echo $totalcreditoselectivas;?></td>
			</tr>
		  </table>
		  </td>
<?php
}
?>
        </tr>
    </table></td>
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
            <?php if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>                
                    <td></td>
                    <td></td>
                    <td><strong>Estudiantes matriculados:</strong></td>
                    <td><?php echo $totalEstudiantesFinal; ?></td>   
            <?php } ?>
        </tr>
    </table></td>
  </tr>
  <?php
if($tieneenfasis)
{
?>
  <tr id="trgris">
    <td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio']+1;?>"><strong>Nota:</strong> <font color="#800000">Los totales para los semestres que poseen línea de énfasis cambian, de acuerdo a las materias que posea cada línea.</font> </td>
  </tr>
  <?php
}
?>
</table>
    <?php  if (isset($reporteporsemestre) && $reporteporsemestre==true) { ?>
</div>
<table width="1100" border="0" cellpadding='0' cellspacing='0' style="margin-top:10px;">
    <tbody>
  <tr id="trgris">
    <td align="center" colspan="<?php echo $row_planestudio['cantidadsemestresplanestudio'];?>">
<?php
if(isset($_GET['estudiante']))
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="history.go(-1)">
<?php
}
else if(isset($_GET['visualizado']))
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="window.location.href='plandeestudioinicial.php'">
<?php
}
else
{
?>
	<input type="button" name="regresar" value="Regresar" onClick="window.location.href='editarmateriasseleccionadas.php?planestudio=<?php echo $idplanestudio;?>'">
<?php
}
if($tieneenfasis && $mostrarbotonenfasis && !isset($_GET['estudiante']))
{
	if(isset($_GET['visualizado']))
	{
?>
        <input type="button" name="lineasenfasis" value="Lineas de Enfasis" onClick="window.location.href='lineadeenfasis/lineadeenfasisinicial.php?planestudio=<?php  echo "$idplanestudio&visualizado";?>'">
<?php
	}
	else
	{
?>
	   <input type="button" name="lineasenfasis" value="Lineas de Enfasis" onClick="window.location.href='lineadeenfasis/lineadeenfasisinicial.php?planestudio=<?php  echo $idplanestudio;?>'">
<?php
	}
}
if (isset($reporteporsemestre) && $reporteporsemestre==true) {
?>
<input type="button" name="esxportarPDF" value="Exportar a PDF" onClick="exportarPDF();">
<input type="button" name="esxportarExcel" value="Exportar a Excel" onClick="esxportarExcel();">
<?php } 
if(!isset($_GET['estudiante']))
{
?>        <input type="button" name="salir" value="Salir" onClick="window.location.href='plandeestudioinicial.php'">
<?php
} ?>
    </td>
  </tr>
</tbody>
</table>
    <?php } ?>

