<?php 
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../../Connections/sala2.php');
require_once('../../../funciones/validacion.php' ); 
require_once('../../../funciones/errores_creacionestudiante.php' ); 
require('../../../funciones/notas/funcionequivalenciapromedio.php');
require ('../../../funciones/notas/redondeo.php');
mysql_select_db($database_sala, $sala);
session_start();
$periodo = $_SESSION['codigoperiodosesion'];
$usuario = $_SESSION['MM_Username'];	
mysql_select_db($database_sala, $sala);
$query_tipousuario = "SELECT * from usuariofacultad where usuario = '".$usuario."'";
$tipousuario = mysql_query($query_tipousuario, $sala) or die(mysql_error());
$row_tipousuario = mysql_fetch_assoc($tipousuario);
$totalRows_tipousuario = mysql_num_rows($tipousuario);
//require_once('seguridadcrearestudiante.php');
$codigoestudiante = $_GET['codigocreado'];
if($_POST['regresar'])
{
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=menucrearnuevoestudiante.php'>";	        	     
  exit();
} 

if($_POST['regresar1'])
{
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=../matriculaautomaticaordenmatricula.php'>";	        	     
  exit();
} 
if($_POST['editar'])
{
  echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=editarestudiante.php?codigocreado=".$codigoestudiante."'>";	        	     
  exit();
}

$query_dataestudiante = "SELECT eg.idestudiantegeneral, c.nombrecarrera, eg.apellidosestudiantegeneral, 
eg.nombresestudiantegeneral, d.nombredocumento, d.tipodocumento, eg.numerodocumento, eg.fechanacimientoestudiantegeneral, 
eg.expedidodocumento, e.codigojornada, j.nombrejornada, e.semestre, e.numerocohorte, e.codigotipoestudiante, 
t.nombretipoestudiante, e.codigosituacioncarreraestudiante, s.nombresituacioncarreraestudiante, eg.celularestudiantegeneral, 
eg.emailestudiantegeneral, eg.codigogenero, g.nombregenero, eg.direccionresidenciaestudiantegeneral, eg.telefonoresidenciaestudiantegeneral, 
eg.ciudadresidenciaestudiantegeneral, eg.direccioncorrespondenciaestudiantegeneral, eg.telefonocorrespondenciaestudiantegeneral, 
eg.ciudadcorrespondenciaestudiantegeneral, p.nombreplanestudio
FROM estudiante e, carrera c,documento d, jornada j, tipoestudiante t, situacioncarreraestudiante s, genero g, estudiantegeneral eg, planestudio p, planestudioestudiante pee
WHERE e.codigocarrera = c.codigocarrera
AND eg.tipodocumento = d.tipodocumento
AND e.codigojornada = j.codigojornada
AND e.codigotipoestudiante = t.codigotipoestudiante
AND e.codigosituacioncarreraestudiante = s.codigosituacioncarreraestudiante
AND eg.codigogenero = g.codigogenero
AND e.codigoestudiante = '$codigoestudiante'
and eg.idestudiantegeneral = e.idestudiantegeneral
and e.codigoestudiante = pee.codigoestudiante
and p.idplanestudio = pee.idplanestudio";
//echo "$query_dataestudiante";
//exit();
$dataestudiante = mysql_query($query_dataestudiante, $sala) or die("$query_dataestudiante".mysql_error());
$row_dataestudiante = mysql_fetch_assoc($dataestudiante);
$totalRows_dataestudiante = mysql_num_rows($dataestudiante);

if($totalRows_dataestudiante != "")
{
?>
<html>
<head>



<title>Datos del Estudiante</title>



<style type="text/css">



<!--



.Estilo4 {font-family: tahoma}



.Estilo5 {font-size: xx-small}



.Estilo6 {font-family: tahoma; font-size: xx-small; }



-->



</style>



</head>



<style type="text/css">



<!--



.Estilo7 {color: #FF0000; font-size: xx-small; }



-->



</style>



<body>



<form name="form1" method="post" action="estudiantecreado.php?codigocreado=<?php echo $_GET['codigocreado']?>">



    <p align="center" class="Estilo4"><strong>DATOS DEL  ESTUDIANTE</strong></p>



    <table width="600" border="1" align="center" cellpadding="1" bordercolor="#003333">



      <tr>



       <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Facultad</strong></font></div></td>



        <td colspan="1" class="Estilo4" ><div align="center">          <span class="Estilo5"><?php echo $row_dataestudiante['nombrecarrera'] ?></span><font size="1">



          <strong>&nbsp;</strong> </font></div></td>



		<td bgcolor="#C5D5D6" class="Estilo4" colspan="2"><div align="center"><font size="1"><strong>Plan de Estudio  </strong></font></div></td>



		<td colspan="2" class="Estilo4" ><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['nombreplanestudio'] ?></span><font size="1"> <strong>&nbsp;</strong></font></div></td>



	  </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Nombre</strong></font></div></td>



        <td colspan="2" class="Estilo4">



        <div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['apellidosestudiantegeneral']." ".$row_dataestudiante['nombresestudiantegeneral']; ?></span><font size="1"> <strong>&nbsp;</strong></font></div></td>



		<td bgcolor="#C5D5D6" class="Estilo4" colspan="2"><div align="center"><font size="1"><strong>Fecha de Nacimiento</strong></font></div></td>



        <td colspan="1" class="Estilo4"><div align="center"><span class="Estilo5"><?php echo ereg_replace(" [0-9]+:[0-9]+:[0-9]+","",$row_dataestudiante['fechanacimientoestudiantegeneral']); ?></span></div></td>



      



      </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Tipo Documento</strong></font></div></td>



        <td colspan="1" class="Estilo4"><div align="center"><font size="2" face="Tahoma">



		  <font size="2">&nbsp;</font><span class="Estilo5"><?php echo $row_dataestudiante['nombredocumento'] ?></span><font size="2">&nbsp;</font><font size="1"><strong>&nbsp;</strong></font> </td>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Nï¿½mero</strong></font></div></td>



        <td class="Estilo4"><div align="center" class="Estilo5">        <?php echo $row_dataestudiante['numerodocumento'] ?> </div>



        <div align="center"><font size="1"></font></div></td>



		<td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Expedido en</strong> </font></div></td>



        <td class="Estilo4"><div align="center" class="Estilo5"><?php echo $row_dataestudiante['expedidodocumento'] ?> </div></td>



      </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Jornada</strong></font></div></td>



        <td class="Estilo4" colspan="1"><div align="center" class="Estilo5"><?php echo $row_dataestudiante['nombrejornada'] ?> </div>          



        <div align="center"><font size="1"></font></div>          <div align="center">



          </div></td>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Semestre</strong></font></div></td>



        <td class="Estilo4"><div align="center" class="Estilo5"><?php echo $row_dataestudiante['semestre'] ?> </div></td>



		<td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>G&eacute;nero</strong></font></div></td>



        <td class="Estilo4"><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['nombregenero'] ?></span><font size="1"> <strong>&nbsp;</strong> </font>



		</div></td>



	  </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><strong><font size="1">Tipo Estudiante </font></strong></div></td>



        <td class="Estilo4" colspan="1"><div align="center">          <span class="Estilo5"><?php echo $row_dataestudiante['nombretipoestudiante'] ?></span><font size="1"> <strong>&nbsp;</strong> </font></div></td>



        <td bgcolor="#C5D5D6" class="Estilo4" colspan="2"><div align="center"><font size="1"><strong>Situaci&oacute;n Estudiante</strong></font></div></td>



		<td colspan="2" class="Estilo4"><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['nombresituacioncarreraestudiante'] ?></span><font size="1">



          <strong>&nbsp;</strong> </font></div></td>



	  </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Celula</strong>r</font></div></td>



        <td colspan="1" class="Estilo4"><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['celularestudiantegeneral'] ?></span><font size="1">



              <strong>&nbsp;</strong> </font></div></td>



        <td bgcolor="#C5D5D6" class="Estilo4" colspan="2">



          <div align="center"><font size="1"><strong>E-mail </strong></font></div></td>



        <td class="Estilo4" colspan="2"><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['emailestudiantegeneral'] ?></span><font size="1">



              <strong>&nbsp;</strong> </font></div></td>



      </tr>



      <tr>



        



      <td bgcolor="#C5D5D6" class="Estilo4">



<div align="center"><font size="1"><strong>Dir. Estudiante</strong></font></div></td>



        <td colspan="1" class="Estilo4"><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['direccionresidenciaestudiantegeneral'] ?></span><font size="1">



              <strong>&nbsp;</strong> </font></div></td>



        <td bgcolor="#C5D5D6" class="Estilo4">



          <div align="center"><font size="1"><strong>Tel&eacute;fono </strong></font></div></td>



        <td class="Estilo4"><div align="center"><span class="Estilo5"><?php echo $row_dataestudiante['telefonoresidenciaestudiantegeneral'] ?></span><font size="1"> <strong>&nbsp;</strong> 



              </font></div></td>



         <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Ciudad</strong></font></div></td>



         <td class="Estilo4"><div align="center" class="Estilo5"><?php echo $row_dataestudiante['ciudadresidenciaestudiantegeneral'] ?></div></td>



      </tr>



      <tr>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Dir. Correspondencia</strong></font></div></td>



        <td colspan="1" class="Estilo4"><div align="center">        <span class="Estilo5"><?php echo $row_dataestudiante['direccioncorrespondenciaestudiantegeneral'] ?></span><font size="1"><strong>&nbsp;</strong> </font></div></td>



        <td bgcolor="#C5D5D6" class="Estilo4">



          <div align="center"><font size="1"><strong>Tel&eacute;fono</strong></font></div></td>



        <td class="Estilo4"><div align="center">          <font size="1"> <span class="Estilo5"><?php echo $row_dataestudiante['telefonocorrespondenciaestudiantegeneral'];?></span><span class="Estilo4"></font></div></td>



        <td bgcolor="#C5D5D6" class="Estilo4"><div align="center"><font size="1"><strong>Ciudad</strong></font></div></td>



        <td class="Estilo4"><div align="center">          <span class="Estilo5"><?php echo $row_dataestudiante['ciudadcorrespondenciaestudiantegeneral'] ?></span><font size="1"><strong>&nbsp;</strong> </font></div></td>



      </tr>



<?php 
if ($row_tipousuario['codigotipousuariofacultad'] == 200)
  {		
?>	 

	  <tr>
        <td colspan="7" bgcolor="#C5D5D6" class="Estilo4"><div align="center"><strong>

	<?php 
		    mysql_select_db($database_sala, $sala);

			$seleccion1="SELECT distinct p.codigoestudiante
			FROM prematricula p,ordenpago o
			WHERE o.codigoestudiante = p.codigoestudiante					
			AND p.codigoestadoprematricula LIKE '4%'
			AND o.codigoestadoordenpago LIKE '4%'
			and p.codigoestudiante = '".$codigoestudiante."'
			AND p.codigoperiodo = '$periodo'";
		    $datos1=mysql_db_query($database_sala,$seleccion1);
		    $registros1=mysql_fetch_array($datos1);	

		if ($registros1 <> "")
		 {
		   echo "ESTUDIANTE MATRICULADO";
		 }
		else
		 {
		    echo "ESTUDIANTE SIN MATRICULAR";		 
		 }
?>		
	</strong></div></td>
      </tr>
<?php 
  }
?>	
  </table>
   
<?php 
 if ($row_tipousuario['codigotipousuariofacultad'] == 200)
   {		
     $periodosemestral = $_GET['periodo'];     
?> 
	
    <p align="center" class="Estilo4"><strong>PROMEDIOS SEMESTRAL - ACUMULADO</strong></p>
  <table width="600" border="1" align="center" cellpadding="1" bordercolor="#003333">
    <tr> 



      <td align="center" bgcolor="#C5D5D6" class="Estilo4 Estilo5"><strong>Promedio Semestral&nbsp;<?php echo $periodosemestral;?></strong>&nbsp;</td>



	  <td align="center" bgcolor="#C5D5D6" class="Estilo6"><strong>Promedio Acumulado</strong>&nbsp;</td>



    </tr>



	<tr> 



      <td align="center" class="Estilo4" ><span class="Estilo5">
<?php 
//@require('../boletines/calculopromediosemestral.php');

// Tomo todas las materias que vio el estudiante con su nota y las coloco en un arreglo por periodo
	 $query_materiashistorico = "select n.codigomateria, n.notadefinitiva, case n.notadefinitiva > '5'
	when 0 then n.notadefinitiva
	when 1 then n.notadefinitiva / 100
	end as nota, n.codigoperiodo, m.nombremateria
	from notahistorico n, materia m
	where n.codigoestudiante = '$codigoestudiante' 
	and n.codigomateria = m.codigomateria
	AND codigoestadonotahistorico LIKE '1%'
	order by 5, 3 ";	
	//echo $query_materiashistorico; 
	//exit();
	$materiashistorico = mysql_query($query_materiashistorico, $sala) or die(mysql_error());
	$totalRows_materiashistorico = mysql_num_rows($materiashistorico);
	$cadenamateria = "";
	while($row_materiashistorico = mysql_fetch_assoc($materiashistorico))
	{
		// Coloco las materias equivalentes del estudiante en un arreglo y selecciono 
		// la mayor de esas notas, con el codigo de la materia mayor.
		// Arreglo de las materias con las mejores notas del estudiante
		if($materiapapaito = seleccionarequivalenciapapa($row_materiashistorico['codigomateria'],$codigoestudiante,$sala))
		{
		 //echo "PAPA ".$row_materiashistorico['codigomateria']." $materiapapaito<br>";
		 $formato = " n.codigomateria = ";
			// Con la materia papa selecciono las equivalencias y miro si estan en estudiante, y selecciono la mayor nota con su codigo
			// $Cad_equivalencias = seleccionarequivalenciascadena($materiapapaito, $codigoestudiante, $formato, $sala)."<br>";
			// $Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
			//echo "$Cad_equivalencias<br>";	
			// exit();
			$row_mejornota =  seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
			//echo "<br><br>".seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
		    $Array_materiashistorico[$row_mejornota['codigomateria']] = seleccionarequivalenciasrow($materiapapaito, $codigoestudiante, $formato, $sala);
			//echo "<br>materia: ".$row_mejornota['codigomateria']." nota ".$row_mejornota['nota']."<br>";
		}
		else
		{
			$Array_materiashistorico[$row_materiashistorico['codigomateria']] = $row_materiashistorico;
		}
	}
	//exit();
	$Array_materiashistoricoinicial = $Array_materiashistorico;
	// Del arreglo que forme anteriormente debo quitar las equivalencias con menor nota
	// Para esto primero creo un arreglo con las equivalencias de cada materia
	if(is_array($Array_materiashistorico))
	foreach($Array_materiashistorico as $codigomateria => $row_materia)
	{
		//echo "$codigomateria => ".$row_materia['codigoperiodo']." => ".$row_materia['nota']."<br>";
		$otranota = $row_materia['nota']*100;
		// Arreglo bidimensional con las materias en cada periodo
    	$cadenamateria = "$cadenamateria (n.codigomateria = '".$row_materia['codigomateria']."' and (n.notadefinitiva = '".$row_materia['nota']."' or n.notadefinitiva = '$otranota')) or";
    	$Array_materiasperiodo[$row_materia['codigoperiodo']][] = $row_materia;
	}

	//exit();

	$cadenamateria = $cadenamateria."fin";
	$cadenamateria = ereg_replace("orfin","",$cadenamateria);
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////	  
$periodoactual = $periodosemestral;
$promediosemestralperiodo = PeriodoSemestralReglamento ($codigoestudiante,$periodoactual,$cadenamateria,$_GET['tipocertificado']="",$sala);    
echo $promediosemestralperiodo;
?>
</span> &nbsp;</td>
  <td align="center" class="Estilo4" ><span class="Estilo5">
<?php
 //@require('../boletines/calculopromedioacumulado.php'); echo $promedioacumulado;
$promedioacumulado = AcumuladoReglamento ($codigoestudiante,$_GET['tipocertificado']="",$sala);     
echo $promedioacumulado;
?>
  </span> &nbsp;</td>
   </tr>          
  </table>  
  <?php 
  }
 ?> 	



	



  <!-- </span>



  <p align="center" class="Estilo4"><strong>DATOS INFORMATIVOS DE PUBLICIDAD&nbsp;</strong></p>



	



  <table width="600" border="1" align="center" cellpadding="1" bordercolor="#003333">



    <tr> 



      <td colspan="2" align="center" bgcolor="#C5D5D6" class="Estilo4 Estilo5"><strong>Por qu&eacute; decidi&oacute; 



        estudiar en la Universidad</strong>&nbsp;</td>



    </tr>



    <tr> 



      <td colspan="2" align="center" class="Estilo4">



	    <span class="Estilo5">



        <?php



/*		



	if($row_seldecision['nombredecisionuniversidad'] == "")



	{



		echo "<span class='Estilo7'>No ha escogido opciï¿½n por la que decidiï¿½ estudiar en la U</span>";



	}



	else



	{



		echo $row_seldecision['nombredecisionuniversidad'];



	}*/



?>



	  &nbsp;</span></td>



    </tr>



    <tr> 



      <td colspan="2" align="center" bgcolor="#C5D5D6" class="Estilo4"><span class="Estilo5"><strong>C&oacute;mo se enter&oacute; 



        de la Universidad&nbsp;</strong></span></td>



    </tr>



<?php



	/*$query_selmediocomunicacion = "select m.nombremediocomunicacion



	from mediocomunicacion m, estudiantemediocomunicacion e



	where m.codigomediocomunicacion = e.codigomediocomunicacion



	and e.codigoestudiante = '$codigoestudiante'";



	$selmediocomunicacion = mysql_query($query_selmediocomunicacion, $sala) or die("$query_selmediocomunicacion");



	$totalRows_selmediocomunicacion = mysql_num_rows($selmediocomunicacion);



	if($totalRows_selmediocomunicacion != "")



	{



		while($row_selmediocomunicacion = mysql_fetch_array($selmediocomunicacion))



		{



?>



    <tr> 



		  <td width="80%" class="Estilo4"><div align="center" class="Estilo5"><?php echo $row_selmediocomunicacion['nombremediocomunicacion'];?>&nbsp;</div></td>



	</tr>



<?php



		}



	}



	else



	{



?>



	<tr>



	  <td colspan="2" align="center" class="Estilo4"><span class='Estilo7'>Actualmente no ha seleccionado un medio de comunicaciï¿½n</span></td>



	</tr>



<?php



	}*/



?>



  </table>



    <p align="center" class="Estilo4"><strong>PUNTAJES&nbsp;</strong></p>



	



  <table width="600" border="1" align="center" cellpadding="1" bordercolor="#003333">



    <tr> 



      <td colspan="1" align="center" bgcolor="#C5D5D6" class="Estilo4"><span class="Estilo5"><strong>Prueba</strong></span></td>



      <td colspan="1" align="center" bgcolor="#C5D5D6" class="Estilo4"><span class="Estilo5"><strong>Cï¿½digo</strong></span></td>



	  <td colspan="1" align="center" bgcolor="#C5D5D6" class="Estilo4"><span class="Estilo5"><strong>Calificaciï¿½n</strong></span></td>



    </tr>



<?php



	/*$query_selpuntaje = "select r.nombreresultadoadmision, e.numeroestudianteresultadoadmision, e.resultadoadmision



	from resultadoadmision r, estudianteresultadoadmision e



	where e.idresultadoadmision = r.idresultadoadmision



	and e.codigoestudiante = '$codigoestudiante'";



	$selpuntaje = mysql_query($query_selpuntaje, $sala) or die("$query_selpuntaje");



	$totalRows_selpuntaje = mysql_num_rows($selpuntaje);



	if($totalRows_selpuntaje != "")



	{



		while($row_selpuntaje = mysql_fetch_array($selpuntaje))



		{



?>



	<tr> 



      <td class="Estilo4 Estilo5"><?php echo $row_selpuntaje['nombreresultadoadmision'];?></td>



      <td align="center" class="Estilo4 Estilo5"><?php echo $row_selpuntaje['numeroestudianteresultadoadmision'];?></td>	  



      <td align="center" class="Estilo4 Estilo5"><?php echo $row_selpuntaje['resultadoadmision'];?></td>



    </tr>



    <?php



		}



	}



	else



	{



?>



  <tr>



  	<td colspan="3" align="center" class="Estilo4"><span class='Estilo7'>Actualmente no tiene puntajes asignados</span></td>



  </tr>



<?php



	}*/



?>



  </table>



 -->    <p align="center" class="Estilo4">



      



<?php 



 if ($row_tipousuario['codigotipousuariofacultad'] <> 200)



   {		



?>	  



	  <input name="editar" type="submit" id="editar" value="Editar" style="width: 80px">



<?php 



   }



?>      



	  



	  &nbsp;



	  <input name="regresar" type="button" id="regresar" value="Regresar" onClick="history.go(-1)" style="width: 80px">



</p>



</form>



</body>



</html>



<?php



}



else



{



?>



<script language="javascript">



	alert("Este estudiante no tiene asignado un plan de estudio");



	history.go(-1);



</script>



<?php



	exit();



}



?>



