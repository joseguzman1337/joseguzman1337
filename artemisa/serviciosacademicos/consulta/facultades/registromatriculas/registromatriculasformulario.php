<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 
     
require_once('../../../Connections/sala2.php');
$periodo = $_SESSION['codigoperiodosesion'];

if (isset($_GET['codigo']))
 {
  $codigo = $_GET['codigo'];
 }
else
 {
   $codigo = $_SESSION['codigo'];
 }
mysql_select_db($database_sala, $sala);
$query_estudiante = "SELECT eg.nombresestudiantegeneral,eg.apellidosestudiantegeneral,pl.idplanestudio,d.codigomateria,c.nombrecarrera,
                     m.nombremateria,p.semestreprematricula,m.numerocreditos,do.nombredocente,do.apellidodocente,d.codigomateriaelectiva, eg.numerodocumento, per.nombreperiodo
					 FROM estudiante e,prematricula p,detalleprematricula d,planestudioestudiante pl,carrera c,materia m,grupo g,docente do, estudiantegeneral eg, periodo per
					 where p.codigoestudiante = e.codigoestudiante
					 and p.idprematricula = d.idprematricula	
					 and d.idgrupo = g.idgrupo
					 and do.numerodocumento = g.numerodocumento			
					 and pl.codigoestudiante = p.codigoestudiante
					 and c.codigocarrera = e.codigocarrera
					 and m.codigomateria = d.codigomateria
					 and p.codigoestadoprematricula like '4%'
					 and d.codigoestadodetalleprematricula like '3%'
					 and pl.codigoestadoplanestudioestudiante like '1%'
					 and p.codigoestudiante = '".$codigo."'
					 and p.codigoperiodo = '$periodo'
					 and eg.idestudiantegeneral = e.idestudiantegeneral
					 and per.codigoperiodo = p.codigoperiodo
					 order by m.nombremateria 
				 ";
//echo $query_estudiante;
$estudiante = mysql_query($query_estudiante, $sala) or die(mysql_error());
$row_estudiante = mysql_fetch_assoc($estudiante);

if (!$row_estudiante)
 { 
    echo '<script language="JavaScript">alert("No se produjo ningun resultado, favor verificar si esta matriculado")</script>';	
	echo '<script language="JavaScript">history.go(-1)</script>';
 }
$query_creditos = "SELECT d.semestredetalleplanestudio, SUM(d.numerocreditosdetalleplanestudio) numerocreditos
					FROM detalleplanestudio d
					WHERE d.idplanestudio='".$row_estudiante['idplanestudio']."'
					and d.semestredetalleplanestudio = '".$row_estudiante['semestreprematricula']."'
					and d.codigotipomateria not like '4'
	                and d.codigotipomateria not like '5'
					GROUP by 1
				 ";
//echo $query_creditos;
$creditos = mysql_query($query_creditos, $sala) or die(mysql_error());
$row_creditos = mysql_fetch_assoc($creditos);

$query_seltotalcreditossemestre2 = "select sum(d.numerocreditosdetallelineaenfasisplanestudio) as totalcreditossemestre, d.idplanestudio
	from detallelineaenfasisplanestudio d, lineaenfasisestudiante l
	where d.idlineaenfasisplanestudio = l.idlineaenfasisplanestudio
	and l.codigoestudiante = '$codigo'
	and d.semestredetallelineaenfasisplanestudio = '".$row_estudiante['semestreprematricula']."'
	and d.codigotipomateria not like '4'
        and l.fechavencimientolineaenfasisestudiante > now()
	group by 2 ";
	//echo "$query_seltotalcreditossemestre2<br>";
	$seltotalcreditossemestre2 = mysql_db_query($database_sala,$query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2".mysql_error());
	$totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
	$row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);
	$totalcreditossemestre2 = $row_seltotalcreditossemestre2['totalcreditossemestre'];
	if($totalcreditossemestre2 == "")
	{
		$query_seltotalcreditossemestre2 = "select sum(d.numerocreditosdetalleplanestudio) as totalcreditossemestre, d.idplanestudio
		from detalleplanestudio d, planestudioestudiante p
		where d.idplanestudio = p.idplanestudio
		and p.codigoestudiante = '$codigo'
		and d.semestredetalleplanestudio = ".$row_estudiante['semestreprematricula']."
		and d.codigoestadodetalleplanestudio like '1%'
		and d.codigotipomateria like '5%'
		group by 2";
		//echo "$query_horarioinicial<br>";
		$seltotalcreditossemestre2 = mysql_db_query($database_sala,$query_seltotalcreditossemestre2) or die("$query_seltotalcreditossemestre2".mysql_error());
		$totalRows_seltotalcreditossemestre2 = mysql_num_rows($seltotalcreditossemestre2);
		$row_seltotalcreditossemestre2 = mysql_fetch_array($seltotalcreditossemestre2);
		$totalcreditossemestre2 = $row_seltotalcreditossemestre2['totalcreditossemestre'];
	}
?>
<style type="text/css">
<!--
.Estilo1 {font-family: tahoma}
.Estilo2 {
	font-size: x-small;
	font-weight: bold;
}
.Estilo4 {font-size: xx-small}
.Estilo6 {font-size: xx-small; font-weight: bold; }
-->
</style>

<form action="" method="post" name="form1" class="Estilo1">

  <p align="center" class="Estilo2">REGISTRO DE MATRICULA<br>
  INSCRIPCI&Oacute;N DE ASIGNATURAS</p>
  <table border="1" align="center" cellpadding="1" bordercolor="#003333">
  <tr>
    <td colspan="3"  bgcolor="#C5D5D6"><div align="center"><span class="Estilo2 Estilo4">Nombre</span></div>      <span class="Estilo4"></span></td>
    <td bgcolor="#C5D5D6" colspan ="2"><div align="center"><span class="Estilo4"><strong>Documento</strong></span></div></td>
    </tr>
   <tr>
     <td colspan="3" ><div align="center"><span class="Estilo4"><?php echo $row_estudiante['apellidosestudiantegeneral'];?>&nbsp;<?php echo  $row_estudiante['nombresestudiantegeneral'];?></span></div></td>
     <td colspan="3"><div align="center"><span class="Estilo4"><?php echo  $row_estudiante['numerodocumento'];?></span></div></td>
   </tr>
   <tr>
     <td colspan="3" bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong>Programa</strong></span><span class="Estilo4">&nbsp;</span></div></td>
     <td bgcolor="#C5D5D6" colspan="3"><div align="center"><span class="Estilo4"><strong>Fecha</strong></span></div></td>     
   </tr>
   <tr>
     <td colspan="3"><div align="center"><span class="Estilo4"><?php echo $row_estudiante['nombrecarrera'];?></span></div>       <div align="center"></div></td>
     <td colspan="2" ><div align="center"><span class="Estilo4"><?php echo date("Y-m-d");?></span></div></td>
    </tr>
   <tr>
     <td colspan="1%" bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong>Semestre</strong></span></div></td>
     <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong>Créditos Semestre</strong></span></div></td>
     <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong><strong>Cr&eacute;ditos Seleccionados</strong></strong></span></div></td>
     <td colspan="2"  bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong>Periodo</strong></span></div></td>
   </tr>
   <tr>
     <td><div align="center"><span class="Estilo4"></span><span class="Estilo4"><?php echo $row_estudiante['semestreprematricula'];?></span></div></td>
     <td><div align="center"><span class="Estilo4"></span><span class="Estilo4"><?php echo $row_creditos['numerocreditos'] +  $totalcreditossemestre2;?></span></div></td>
     <td><div align="center"><span class="Estilo4"></span><span class="Estilo4"><?php echo $_GET['creditoscalculados'];?></span></div></td>
    <td colspan="2" ><div align="center"><span class="Estilo4"><?php echo  $row_estudiante['nombreperiodo'];?></span></div></td>
   </tr>
   <tr>
     <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong>No. Orden</strong></span></div></td>
     <td bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong><strong>Id Prematricula</strong></strong></span></div></td>
     <td colspan="3" bgcolor="#C5D5D6"><div align="center"><span class="Estilo4"><strong>Valor Matricula </strong></span></div></td>
    </tr>
<?php 
$query_orden = "SELECT *
					FROM ordenpago o,detalleordenpago d
					WHERE o.numeroordenpago = d.numeroordenpago
					and d.codigoconcepto = '151'
					and o.codigoestudiante='".$codigo."'
					and o.codigoperiodo = '".$periodo."'
					AND o.codigoestadoordenpago LIKE '4%'					
				 ";
//echo $query_orden;
$orden = mysql_query($query_orden, $sala) or die(mysql_error());
$row_orden = mysql_fetch_assoc($orden);
do{  
?> 
   <tr>
     <td><div align="center"><span class="Estilo4"><?php echo $row_orden['numeroordenpago'];?></span></div></td>
     <td><div align="center"><span class="Estilo4"><?php echo $row_orden['idprematricula'];?></span></div></td>
     <td colspan="3" ><div align="center"><span class="Estilo4">$&nbsp;<?php echo number_format ($row_orden['valorconcepto'],2);?>
	 <?php 
	 
	 
	 ?></span></div></td>
    </tr>
<?php 
}while($row_orden = mysql_fetch_assoc($orden));  
?> 
 
   <tr bgcolor="#C5D5D6">
    <td><div align="center" class="Estilo4"><strong>Código&nbsp;</strong></div></td>
    <td><div align="center" class="Estilo4"><strong>Nombre Materia &nbsp;</strong></div></td>
    <td><div align="center"><span class="Estilo4"><strong>Docente</strong></span></div></td>
    <td><div align="center" class="Estilo4"><strong>Semestre</strong>&nbsp;</div></td>
    <td><div align="center" class="Estilo4"><strong>Créditos&nbsp;</strong></div></td>
  </tr>
<?php 
 do {
      mysql_select_db($database_sala, $sala);
		$query_materia = "SELECT *
							 FROM detalleplanestudio d,materia m
							 where d.codigomateria = m.codigomateria							
							 and d.idplanestudio = '".$row_estudiante['idplanestudio']."'
							 and d.codigomateria = '".$row_estudiante['codigomateria']."'";
		//echo $query_materia;
		$materia = mysql_query($query_materia, $sala) or die(mysql_error());
		$row_materia = mysql_fetch_assoc($materia); 
         
		 /* if (!$row_materia)
		  {
				 $query_materia = "SELECT *
								 FROM detalleplanestudio d,materia m
								 where d.codigomateria = m.codigomateria							
								 and d.idplanestudio = '".$row_estudiante['idplanestudio']."'
								 and d.codigomateria = '".$row_estudiante['codigomateriaelectiva']."'";
				echo $query_materia;
				$materia = mysql_query($query_materia, $sala) or die(mysql_error());
				$row_materia = mysql_fetch_assoc($materia); 
		  } */
			   if ($row_materia <> "")
			    {			
				  $semestre = $row_materia['semestredetalleplanestudio'];
				  $numerocreditos = $row_materia['numerocreditosdetalleplanestudio'];
				}  
			 else		 
				{			
				  //Revisar si es materia de linea de enfasis
				  $query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio,
						dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos
						from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
						where m.codigomateria = '".$row_estudiante['codigomateria']."'
						and lee.codigoestudiante = '".$codigo."'
						and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
						and lee.idplanestudio = dle.idplanestudio
						and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
						and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
						and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";	
				
					$materia = mysql_query($query_datosmateria, $sala) or die(mysql_error());
					$row_materia = mysql_fetch_assoc($materia); 
					if ($row_materia <> "")
					{			
					  $semestre = $row_materia['semestredetalleplanestudio'];
					  $numerocreditos = $row_materia['numerocreditos'];
					}  else {
						$semestre = $row_estudiante['semestreprematricula'];
						$numerocreditos = $row_estudiante['numerocreditos'];
					}
				}

?> 
  <tr>
    <td><div align="center"><span class="Estilo4"><?php echo $row_estudiante['codigomateria'];?>&nbsp;</span></div></td>
    <td><span class="Estilo4"><?php echo $row_estudiante['nombremateria'];?>&nbsp;</span></td>
    <td><div align="center" class="Estilo4"><?php echo $row_estudiante['nombredocente'];?>&nbsp;<?php echo $row_estudiante['apellidodocente'];?></div></td>
    <td><div align="center" class="Estilo4"><?php echo $semestre;?>&nbsp;</div></td>
    <td><div align="center" class="Estilo4"><?php echo $numerocreditos;?>&nbsp;</div></td>
  </tr>
<?php 
 }while($row_estudiante = mysql_fetch_assoc($estudiante));

?>
<tr>
    <td colspan="5"><span class="Estilo4">
	<table align="center">
	<tr>
	  <td>&nbsp;</td>
	  <td>&nbsp;</td>
	<tr>
	<tr>
	  <td><span class="Estilo6">Firma</span></td>
	  <td>_________________________</td>
	<tr>
	<tr>
	  <td><span class="Estilo6">No. Documento</span></td>
	  <td>_________________________</td>
	<tr>
	<tr>
	  <td><span class="Estilo6">Fecha:</span></td>
	  <td>_________________________</td>
	<tr>
	</table>
    </tr>  
</table>
  <br><br>
		<p align="center">
		  <input type="button" name="Submit" value="Regresar" onClick="history.go(-1)">
		  <input type="button" name="Submit" value="Imprimir" onClick="window.print()">
		</p>
</form>
