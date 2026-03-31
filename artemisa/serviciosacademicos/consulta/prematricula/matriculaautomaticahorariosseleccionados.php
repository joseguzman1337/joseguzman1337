<?php 
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
require_once('../../Connections/sala2.php' );
mysql_select_db($database_sala, $sala);
session_start();
require_once('../../funciones/clases/autenticacion/redirect.php' ); 
$link = "../../../imagenes/estudiantes/";
require_once('../../funciones/datosestudiante.php');

//require_once('seguridadprematricula.php');

// Esta variable se usa en el resto de la aplicación en el archivo calculocreditossemestre
$materiaselegidas = $materiasunserial;

$materiasserial = serialize($materiasunserial);
$codigoestudiante = $_SESSION['codigo'];
//echo $_GET['materiassinhorarios']."<br>";
//echo "$materiasserial<br>";
/*foreach($materiasunserial as $llave => $codigomateria)
{
	echo "$llave => $codigomateria<br>";
}
exit();*/

 switch($_POST['actionID']){
    case 'BuscarInfo':{
        
        Buscar($database_sala,$_POST['numEstudiante'],$_POST['FechaInicial'],$_POST['FechaFinal']);
    }exit;
 }


if(isset($_POST['modificar']))
{
	//echo "$materiasserial<br>";
	//exit();
	echo "<script language='javascript'>
		window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial';
	</script>";
		//Se dirige a los horarios donde un estudiante elige
}

$semestre[$row_materiascarga['semestredetalleplanestudio']]++;

?>
<html>
<head>
<title>HORARIOS</title>
</head>
<link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
<body>
<?php
if(!isset($_SESSION['codigo']))
{
?><script language="javascript">
	alert("Por seguridad su sesion ha sido cerrada, por favor reinicie.");
</script>
<?php
}
$codigoestudiante = $_SESSION['codigo'];
$codigoperiodo = $_SESSION['codigoperiodosesion'];

/* Obtener el documento del estudiante */
$SQL_DOC = 'SELECT eg.numerodocumento FROM estudiantegeneral eg INNER JOIN estudiante e ON e.idestudiantegeneral = eg.idestudiantegeneral WHERE e.codigoestudiante = '.$codigoestudiante;
$documentoestudiante = mysql_db_query($database_sala,$SQL_DOC) or die("$SQL_DOC");
$row_documentoestudiante = mysql_fetch_array($documentoestudiante);
$documentoestudiante = $row_documentoestudiante['numerodocumento'];
// Seleccionar los datos del estudiante
// Estos datos se usaran en toda la aplicación
/*$query_datosestudiante = "select concat(nombresestudiante,' ',apellidosestudiante) as nombre, codigocarrera, numerocohorte, 
codigotipoestudiante, codigosituacioncarreraestudiante, codigojornada
from estudiante
where codigoestudiante = '$codigoestudiante'";
//echo "$query_horarioinicial<br>";
$datosestudiante = mysql_db_query($database_sala,$query_datosestudiante) or die("$query_datosestudiante");
$totalRows_datosestudiante = mysql_num_rows($datosestudiante);
$row_datosestudiante = mysql_fetch_array($datosestudiante);
$codigocarrera = $row_datosestudiante['codigocarrera'];
$numerocohorte = $row_datosestudiante['numerocohorte'];
$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
$codigojornada = $row_datosestudiante['codigojornada'];
$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
//$codigotipoestudiante = $row_datosestudiante['codigotipoestudiante'];
*/

/* Sumar 6 dias a la fecha actual para hacer el calculo de los salones */
$fecha = date('Y-m-j');
$nuevafecha = strtotime ( '+6 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'Y-m-j' , $nuevafecha );

/***Consulta para el grupo y el salon***/

$SQL_ASIG = 'SELECT
				p.idprematricula,
				d.idgrupo,
				x.codigodia,
				x.nombredia,
				m.nombremateria,
				g.nombregrupo,
				sg.SolicitudAsignacionEspacioId,

			IF (
				c.Nombre IS NULL,
				"Falta Por Asignar",
				c.Nombre
			) AS Nombre,
			 a.FechaAsignacion,

			IF (
				a.HoraInicio IS NULL,
				h.horainicial,
				a.HoraInicio
			) AS HoraInicio,

			IF (
				a.HoraFin IS NULL,
				h.horafinal,
				a.HoraFin
			) AS HoraFin,
			 cc.Nombre AS Bloke,
			 ccc.Nombre AS Campus,
			 g.numerodocumento AS numDocente,
			 m.nombremateria,
			 CONCAT(
				dc.nombredocente,
				" ",
				dc.apellidodocente
			) AS DocenteName,
			 p.idprematricula,
			 p.codigoestudiante,
			 CONCAT(
				eg.nombresestudiantegeneral,
				" ",
				eg.apellidosestudiantegeneral
			) AS NameEstudiante,
			 eg.numerodocumento
			FROM
				prematricula p
			INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula
			INNER JOIN horario h ON h.idgrupo = d.idgrupo
			INNER JOIN dia x ON x.codigodia = h.codigodia
			INNER JOIN grupo g ON g.idgrupo = d.idgrupo
			INNER JOIN materia m ON m.codigomateria = g.codigomateria
			INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
			INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
			INNER JOIN docente dc ON dc.numerodocumento = g.numerodocumento
			LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
			LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
			LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId
			LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
			LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
			LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
			WHERE
				eg.numerodocumento = "'.$documentoestudiante.'"
			AND (
				a.EstadoAsignacionEspacio = 1
				OR a.EstadoAsignacionEspacio IS NULL
			)
			AND d.codigoestadodetalleprematricula = 30
			AND p.codigoestadoprematricula IN (40, 41)
			AND p.codigoperiodo = "'.$codigoperiodo.'"
			AND (
				sg.codigoestado = 100
				OR sg.codigoestado IS NULL
			)
			AND (
				a.codigoestado = 100
				OR a.codigoestado IS NULL
			)
			AND (
				a.FechaAsignacion BETWEEN CURDATE()
				AND "'.$nuevafecha.'"
				OR a.FechaAsignacion IS NULL
			)
			AND (
				s.codigodia = h.codigodia
				OR s.codigodia IS NULL
			)
			AND s.codigoestado = 100
			GROUP BY
				x.codigodia,
				m.codigomateria,
				d.idgrupo,
				HoraInicio,
				HoraFin,
				a.FechaAsignacion
			ORDER BY
				x.codigodia,
				a.FechaAsignacion,
				a.HoraInicio,
				a.HoraFin';


$asignaturas = mysql_db_query($database_sala,$SQL_ASIG) or die("$SQL_ASIG");
$arreglo_asignaturas = array();
while($row_asignaturas = mysql_fetch_array($asignaturas))
{	
	$arreglo_asignaturas[$row_asignaturas['idgrupo']][$row_asignaturas['nombredia']]['sede'] = $row_asignaturas['Campus'];	
	$arreglo_asignaturas[$row_asignaturas['idgrupo']][$row_asignaturas['nombredia']]['salon'] = $row_asignaturas['Nombre'];
}



// Seleccion de los horarios que ya tiene matriculados un estudiante
$query_materiasestudiante = "SELECT d.codigomateria, d.codigomateriaelectiva, edp.nombreestadodetalleprematricula, d.idgrupo, d.numeroordenpago
FROM detalleprematricula d, prematricula p, materia m, estudiante e, estadodetalleprematricula edp
where d.codigomateria = m.codigomateria 
and d.idprematricula = p.idprematricula
and p.codigoestudiante = e.codigoestudiante
and e.codigoestudiante = '$codigoestudiante'
and edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula
and (p.codigoestadoprematricula like '4%' or p.codigoestadoprematricula like '1%')
and (d.codigoestadodetalleprematricula like '3%' or d.codigoestadodetalleprematricula like '1%' or d.codigoestadodetalleprematricula = '23')
and p.codigoperiodo = '$codigoperiodo'";
//echo "$query_materiasestudiante<br>"; die;
$materiasestudiante = mysql_query($query_materiasestudiante, $sala) or die("$query_materiasestudiante");
$totalRows_materiasestudiante = mysql_num_rows($materiasestudiante);
$tieneprema = false;
if($totalRows_materiasestudiante == "")
{
	if($_GET['programausadopor'] != "creditoycartera" && $_SESSION['MM_Username'] != "estudianterestringido")
	{
?>
		<SCRIPT LANGUAGE="JavaScript">
		alert("Actualmente no tiene materias seleccionadas, a continuación debe hacerlo")
		</SCRIPT>
<?php
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomatica.php?programausadopor=".$_GET['programausadopor']."'>";
		exit();
	}
	else
	{
?>
		<SCRIPT LANGUAGE="JavaScript">
		alert("Actualmente no tiene materias seleccionadas");
		</SCRIPT>
<?php
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=matriculaautomaticaordenmatricula.php?programausadopor=".$_GET['programausadopor']."'>";
	}

}
/*else
{
	while($row_materiasestudiante = mysql_fetch_array($premainicial1))
	{
		if($row_premainicial1['codigomateriaelectiva'] == "")
		{
			$materiaselegidas[] = $row_premainicial1['codigomateria'];
		}
		else
		{
			$materiaselegidas[$row_premainicial1['codigomateriaelectiva']] = $row_premainicial1['codigomateria'];
		}
	}
}*/
?>
<form name="form1" method="post" action="matriculaautomaticahorariosseleccionados.php">   
<?php 
datosestudiante($codigoestudiante,$sala,$database_sala,$link);

?>


  <p>HORARIOS</p>
  <?php
 // var_dump(is_file(dirname(__FILE__).'../../../EspacioFisico/Interfas/EspaciosFisicosAsigandosReporte.php'));die;

$fecha_Now = date('Y-m-d');
    
$dia = DiasSemana($fecha_Now);

$Falta  =  1-$dia;
//$X = '-4';
$FechaFutura_1 = dameFecha($fecha_Now,$Falta);
$FechaFutura_2 = dameFecha($FechaFutura_1,6); 


?>
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery.js"></script> 
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
<script>
    $(document).ready(function(){
		$("#FechaInicial").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "<?PHP echo $url?>../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
        $("#FechaFinal").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "<?PHP echo $url?>../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
        
        $('#ui-datepicker-div').css('display','none');
      }); 
      function BuscarInfo(){
       // $('#actionID').val('BuscarInfo');
         var numEstudiante = $('#numEstudiante').val();
         var FechaInicial = $('#FechaInicial').val();
         var FechaFinal = $('#FechaFinal').val();
         
        $.ajax({//Ajax
              type: 'POST',
              url: 'matriculaautomaticahorariosseleccionados.php',
              async: false,
              dataType: 'html',
              data:{actionID:'BuscarInfo',numEstudiante:numEstudiante,FechaInicial:FechaInicial,FechaFinal:FechaFinal},
              error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
              success: function(data){
                  $('#CargaHorario').html(data);
              }  
        });
      }//function BuscarInfo
    </script>     
<form id="Horariostudiante">  
<input type="hidden" id="numEstudiante" name="numEstudiante" value="<?PHP echo $documentoestudiante?>" />
<input type="hidden" id="actionID" name="actionID" />      
<table>
    <tr>
        <td><label>Fecha Inicial</label></td>
        <td>
            <input type="text" id="FechaInicial" name="FechaInicial" value="<?PHP echo $FechaFutura_1?>" />
        </td>
    </tr>
    <tr>
        <td><label>Fecha Final</label></td>
        <td>
            <input type="text" id="FechaFinal" name="FechaFinal" value="<?PHP echo $FechaFutura_2?>" />
        </td>
    </tr>
    <tr>
        <td>
            <input type="button" value="Buscar" onclick="BuscarInfo()" />
        </td>
    </tr>
</table>
</form>
<br />
<div id="CargaHorario">
    <?PHP 
    Buscar($database_sala,$documentoestudiante,$FechaFutura_1,$FechaFutura_2);
    ?>
</div>
<?PHP
function Buscar($database_sala,$Num_Estudiante,$FechaFutura_1,$FechaFutura_2){
    
  $Periodo = Periodo($database_sala);
  
  $SQL='SELECT codigocarrera FROM estudiante e INNER JOIN estudiantegeneral ee ON ee.idestudiantegeneral=e.idestudiantegeneral AND ee.numerodocumento="'.$Num_Estudiante.'"';
  
  $CodigoCarrera = mysql_db_query($database_sala,$SQL) or die("$SQL");
  $DataCarrera = mysql_fetch_array($CodigoCarrera);
//echo '<pre>';print_r($DataCarrera);


     $SQL = 'SELECT
				p.idprematricula,
				d.idgrupo,
				x.codigodia,
				x.nombredia,
				m.nombremateria,
				g.nombregrupo,
				sg.SolicitudAsignacionEspacioId,

			IF (
				c.Nombre IS NULL,
				"Falta Por Asignar",
				c.Nombre
			) AS Nombre,
			 a.FechaAsignacion,

			IF (
				a.HoraInicio IS NULL,
				h.horainicial,
				a.HoraInicio
			) AS HoraInicio,

			IF (
				a.HoraFin IS NULL,
				h.horafinal,
				a.HoraFin
			) AS HoraFin,
			 cc.Nombre AS Bloke,
			 ccc.Nombre AS Campus,
			 g.numerodocumento AS numDocente,
			 CONCAT(
				dc.nombredocente,
				" ",
				dc.apellidodocente
			) AS DocenteName,
			 p.codigoestudiante,
			 CONCAT(
				eg.nombresestudiantegeneral,
				" ",
				eg.apellidosestudiantegeneral
			) AS NameEstudiante,
			 eg.numerodocumento,
			 d.numeroordenpago,
			 m.numerocreditos,
			 edp.nombreestadodetalleprematricula,
			 m.codigomateria,
			 d.codigomateriaelectiva
			FROM
				prematricula p
			INNER JOIN detalleprematricula d ON d.idprematricula = p.idprematricula 
			INNER JOIN estadodetalleprematricula edp ON edp.codigoestadodetalleprematricula = d.codigoestadodetalleprematricula 
			INNER JOIN grupo g ON g.idgrupo = d.idgrupo
			INNER JOIN materia m ON m.codigomateria = g.codigomateria
			INNER JOIN estudiante e ON e.codigoestudiante = p.codigoestudiante
			INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral = e.idestudiantegeneral
			INNER JOIN docente dc ON dc.numerodocumento = g.numerodocumento 			
			LEFT JOIN horario h ON h.idgrupo = d.idgrupo 
			LEFT JOIN dia x ON x.codigodia = h.codigodia 
			LEFT JOIN SolicitudEspacioGrupos sg ON sg.idgrupo = d.idgrupo
			LEFT JOIN AsignacionEspacios a ON a.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId AND 
				a.FechaAsignacion BETWEEN "'.$FechaFutura_1.'" AND "'.$FechaFutura_2.'" and a.codigoestado=100 
			LEFT JOIN SolicitudAsignacionEspacios s ON s.SolicitudAsignacionEspacioId = sg.SolicitudAsignacionEspacioId 
				AND s.codigodia = h.codigodia 
			LEFT JOIN ClasificacionEspacios c ON c.ClasificacionEspaciosId = a.ClasificacionEspaciosId
			LEFT JOIN ClasificacionEspacios cc ON cc.ClasificacionEspaciosId = c.ClasificacionEspacionPadreId
			LEFT JOIN ClasificacionEspacios ccc ON ccc.ClasificacionEspaciosId = cc.ClasificacionEspacionPadreId
			WHERE
				eg.numerodocumento = "'.$Num_Estudiante.'"
			AND (
				a.EstadoAsignacionEspacio = 1
				OR a.EstadoAsignacionEspacio IS NULL
			)
			AND d.codigoestadodetalleprematricula = 30
			AND p.codigoestadoprematricula IN (40, 41)
			AND p.codigoperiodo = "'.$Periodo.'"
			AND (
				sg.codigoestado = 100
				OR sg.codigoestado IS NULL
			)
			AND (
				a.codigoestado = 100
				OR a.codigoestado IS NULL
			)
			AND (
				a.FechaAsignacion BETWEEN "'.$FechaFutura_1.'" AND "'.$FechaFutura_2.'" 
				OR a.FechaAsignacion IS NULL
			)
			AND (
				s.codigodia = h.codigodia
				OR a.FechaAsignacion IS NULL 
				OR h.codigodia IS NULL 
			)
			AND (
					s.codigoestado = 100
					OR s.codigoestado IS NULL
				)
			GROUP BY
				m.codigomateria,
				d.idgrupo,
				x.codigodia,
				HoraInicio,
				HoraFin,
				a.FechaAsignacion
			ORDER BY
				x.codigodia,
				a.FechaAsignacion,
				a.HoraInicio,
				a.HoraFin';
                    //echo $SQL;
                    
                    $Datos = mysql_db_query($database_sala,$SQL) or die("$SQL");
                    //echo $SQL."<br/><br/>"; 
                    
                    //echo '<pre>';print_r($row_Datos);
                    $i=0;
                    while($row_Datos = mysql_fetch_array($Datos)){
						$eselectivalibre = false;
						$eselectivatecnica = false;
						
						$codigomateria = $row_Datos['codigomateria'];
						$codigoestudiante = $row_Datos['codigoestudiante'];
						$codigomateriaelectiva = $row_Datos['codigomateriaelectiva'];
						
						$query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos
						from materia m, detalleplanestudio dpe, planestudioestudiante pee
						where m.codigomateria = '$codigomateria'
						and pee.codigoestudiante = '$codigoestudiante'
						and m.codigomateria = dpe.codigomateria
						and pee.idplanestudio = dpe.idplanestudio
						and pee.codigoestadoplanestudioestudiante like '1%'";
						//echo "6. ".$query_datosmateria;
						$datosmateria = mysql_db_query($database_sala,$query_datosmateria) or die("$query_datosmateria");
						$totalRows_datosmateria = mysql_num_rows($datosmateria);
						$DataCarrera = mysql_fetch_array($CodigoCarrera);
						
						if($totalRows_datosmateria == "")
							{
								// Toma los datos de la materia si es enfasis
								$query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio,
								dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos
								from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
								where m.codigomateria = '$codigomateria'
								and lee.codigoestudiante = '$codigoestudiante'
								and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
								and lee.idplanestudio = dle.idplanestudio
								and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
								and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
								and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
								// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
								// Tanto enfasis como electivas libres		
								//echo "5. ".$query_datosmateria;
								$datosmateria=mysql_db_query($database_sala,$query_datosmateria) or die("$query_datosmateria");
								$totalRows_datosmateria = mysql_num_rows($datosmateria);
								// Si se trata de una electiva
							}
							if($totalRows_datosmateria == "")
							{
								//echo "Mirar papa <br>";
								// Mira si tiene papa, si el papa es electiva libre toma los creditos directamente del hijo
								// Si no tiene papa toma los datos como si fuera una materia externa		
								$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos,
								dpe.codigotipomateria, gm.codigotipogrupomateria
								from grupomaterialinea gml, materia m, grupomateria gm, detalleplanestudio dpe, planestudioestudiante pee
								where gm.codigoperiodo = '$Periodo'
								and gml.codigomateria = '$codigomateriaelectiva'
								and gml.codigoperiodo = gm.codigoperiodo
								and gm.codigoperiodo = gml.codigoperiodo
								and pee.codigoestudiante = '$codigoestudiante'
								and pee.idplanestudio = dpe.idplanestudio
								and dpe.codigomateria = m.codigomateria
								and gml.codigomateria = m.codigomateria
								and gml.idgrupomateria = gm.idgrupomateria
								and pee.codigoestadoplanestudioestudiante like '1%'
								order by m.nombremateria";
								
								//echo "4. ".$query_datosmateriapapa;
								$datosmateriapapa = mysql_db_query($database_sala,$query_datosmateriapapa) or die("$query_datosmateriapapa");
								$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);
								if($totalRows_datosmateriapapa == "")
								{
									//echo "<br>$codigomateria2 EXTERNA<br>";
									// En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
									// Actualmente todos los planes de estudio tiene el ismo numero de creditos para una materia
									// Toca empezar a guardar el plan de estudio de la materia externa en cargaacademica y de este tomar el semestre y
									// y los creditos de la materia y efectuar el conteo de creditos a partir de aca.
									// Debido a que esto no se hiso  para el semestre 20052 toca dejar el codigo siguiente.
									$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
									from materia m
									where m.codigomateria = '$codigomateria'
									and m.codigoestadomateria = '01'";
									//echo "3. ".$query_datosmateria;
									$datosmateria=mysql_db_query($database_sala,$query_datosmateria) or die("$query_datosmateria");
									$totalRows_datosmateria = mysql_num_rows($datosmateria);
								}
								else 
								{
									//echo "tienen papa<br>";
									// Si entra aca quiere decir que la materia tiene hijos.
									$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
									
									if($row_datosmateriapapa['codigotipogrupomateria'] == "100")
									{
										// Materia electiva libre
										// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
										//echo "LIBRE $codigomateria<br>";
										$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
										from materia m
										where m.codigomateria = '$codigomateria'
										and m.codigoestadomateria = '01'";
										//echo "2. ".$query_datosmateria;
										$datosmateria=mysql_db_query($database_sala,$query_datosmateria) or die("$query_datosmateria");
										$totalRows_datosmateria = mysql_num_rows($datosmateria);
										$eselectivalibre = true;
									}
									else if($row_datosmateriapapa['codigotipogrupomateria'] == "200")
									{
										// Materia electiva tecnica
										// Si entra aca es por que la materia debe tomar el numero de creditos del papa
										//echo "TECNICA $codigomateria<br>";
										$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
										from materia m
										where m.codigomateria = '$codigomateria'
										and m.codigoestadomateria = '01'";
										//echo "1. ".$query_datosmateria;
										$datosmateria = mysql_db_query($database_sala,$query_datosmateria) or die("$query_datosmateria");
										$totalRows_datosmateria = mysql_num_rows($datosmateria);
										/*$row_datosmateria['semestredetalleplanestudio'] =*/
										$creditospapa = $row_datosmateriapapa['numerocreditos'];
										$eselectivatecnica = true;
									}
								}
							}
						$row_datosmateria = mysql_fetch_array($datosmateria);
						//var_dump($datosmateria);
						//var_dump($row_datosmateria);
						if($eselectivatecnica)
						{
							//$creditoshijo = $row_datosmateria['numerocreditos'];
							$Data[$i]['semestre']=$row_datosmateriapapa['semestredetalleplanestudio'];							
							$Data[$i]['creditos']=$row_datosmateriapapa['numerocreditos'];
							$Data[$i]['nombremateria']=$row_datosmateria['nombremateria'];
							$Data[$i]['codigomateria']=$row_datosmateria['codigomateria'];
						} else if(!$eselectivalibre)
						{
							$Data[$i]['semestre']=$row_datosmateria['semestredetalleplanestudio'];		
							$Data[$i]['creditos']=$row_datosmateria['numerocreditos'];	
							$Data[$i]['nombremateria']=$row_datosmateria['nombremateria'];	
							$Data[$i]['codigomateria']=$row_datosmateria['codigomateria'];				
						} else {
							$Data[$i]['semestre']="Materia Electiva";	
							$Data[$i]['creditos']=$row_datosmateria['numerocreditos'];	
							$Data[$i]['nombremateria']=$row_datosmateria['nombremateria'];
							$Data[$i]['codigomateria']=$row_datosmateria['codigomateria'];
						}
                        
                        $Data[$i]['idprematricula']=$row_Datos['idprematricula'];
                        $Data[$i]['idgrupo']=$row_Datos['idgrupo'];
                        $Data[$i]['codigodia']=$row_Datos['codigodia'];
                        $Data[$i]['nombredia']=$row_Datos['nombredia'];
                        $Data[$i]['nombregrupo']=$row_Datos['nombregrupo'];
                        $Data[$i]['SolicitudAsignacionEspacioId']=$row_Datos['SolicitudAsignacionEspacioId'];
                        $Data[$i]['Nombre']=$row_Datos['Nombre'];
                        $Data[$i]['FechaAsignacion']=$row_Datos['FechaAsignacion'];
                        $Data[$i]['HoraInicio']=$row_Datos['HoraInicio'];
                        $Data[$i]['HoraFin']=$row_Datos['HoraFin'];
                        $Data[$i]['Bloke']=$row_Datos['Bloke'];
                        $Data[$i]['Campus']=$row_Datos['Campus'];
                        $Data[$i]['numDocente']=$row_Datos['numDocente'];
                        $Data[$i]['DocenteName']=$row_Datos['DocenteName'];
                        $Data[$i]['codigoestudiante']=$row_Datos['codigoestudiante'];
                        $Data[$i]['NameEstudiante']=$row_Datos['NameEstudiante'];
                        $Data[$i]['numerodocumento']=$row_Datos['numerodocumento'];
                        $Data[$i]['numeroordenpago']=$row_Datos['numeroordenpago'];
                        $Data[$i]['estadomateria']=$row_Datos['nombreestadodetalleprematricula'];
                        $i++;
                        
                    }
                  
         ViewReport($Data);         
                    
}                    
 
function ViewReport($Data){
    
    ?>
         <style type="text/css" title="currentStyle">
                @import "../../observatorio/data/media/css/demo_page.css";
                @import "../../observatorio/data/media/css/demo_table_jui.css";
                @import "../../observatorio/data/media/css/ColVis.css";
                @import "../../observatorio/data/media/css/TableTools.css";
                @import "../../observatorio/data/media/css/ColReorder.css";
                @import "../../observatorio/data/media/css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../observatorio/data/media/css/jquery.modal.css";
                
        </style>
       
        <!--<script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.js"></script>
        <script type="text/javascript" charset="utf-8" src="../jquery/js/jquery-3.6.0.js"></script>-->
        <script type="text/javascript" language="javascript" src="../../observatorio/data/media/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColVis.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ZeroClipboard.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/TableTools.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/FixedColumns.js"></script>
        <script type="text/javascript" charset="utf-8" src="../../observatorio/data/media/js/ColReorder.js"></script>
        <script type="text/javascript" language="javascript">
        /****************************************************************/
        	$(document).ready( function () {
        			
        			oTable = $('#example').dataTable({
                                    "sDom": '<"H"Cfrltip>',
                                    "bJQueryUI": true,
                                    "bPaginate": true,
                                    "sPaginationType": "full_numbers",
                                    "oColVis": {
                                          "buttonText": "Ver/Ocultar Columns",
                                           //"aiExclude": [ 0 ]
                                    }
                                });
                                var oTableTools = new TableTools( oTable, {
        					"buttons": [
        						"copy",
        						"csv",
        						"xls",
        						"pdf",
        						{ "type": "print", "buttonText": "Print me!" }
        					]
        		         });
                                 //$('#demo').before( oTableTools.dom.container );
        		} );
        	/**************************************************************/
        </script>
        <table cellpadding="0" cellspacing="0" border="0" class="display" style="width: 100%;" id="example">
                    <thead>
                        <tr>    
                            <th>#</th>    
                            <th>Sede o Campus</th> 
                            <th>Bloque</th> 
                            <th>Espacio F&iacute;sico</th>
                            <th>Id. Grupo</th>
                            <th>Grupo</th>
                            <th>Id. Materia</th> 
                            <th>Materia</th> 
                            <th>Fecha</th> 
                            <th>D&iacute;a</th>
                            <th>Hora Inicial</th>                     
                            <th>Hora Final</th>
                            <th>Nombre Docente</th>
                            <th>N&deg; OrdenPago</th>
                            <th>Semestre</th>
                            <th>Cr&eacute;ditos</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?PHP 
                    //echo '<pre>';print_r($Datos);die;
                    for($i=0;$i<count($Data);$i++){
                        ?>
                        <tr>
                            <td><?PHP echo $i+1?></td>    
                            <td><?PHP echo $Data[$i]['Campus']?></td>                             
                            <td><?PHP echo $Data[$i]['Bloke']?></td>  
                            <td><?PHP echo $Data[$i]['Nombre']?></td>       
                            <td><?PHP echo $Data[$i]['idgrupo']?></td>                   
                            <td><?PHP echo $Data[$i]['nombregrupo']?></td>
                            <td><?PHP echo $Data[$i]['codigomateria']?></td> 
                            <td><?PHP echo $Data[$i]['nombremateria']?></td> 
                            <td><?PHP echo $Data[$i]['FechaAsignacion']?></td> 
                            <td><?PHP echo $Data[$i]['nombredia'];//$DiaSemana = DiasSemana($Data[$i]['FechaAsignacion'],'Nombre');?></td>
                            <td><?PHP echo $Data[$i]['HoraInicio']?></td>                     
                            <td><?PHP echo $Data[$i]['HoraFin']?></td>
                            <td><?PHP echo $Data[$i]['DocenteName']?></td>
                            <td><?PHP echo $Data[$i]['numeroordenpago']?></td>
                            <td><?PHP echo $Data[$i]['semestre']?></td>
                            <td><?PHP echo $Data[$i]['creditos']?></td>
                            <td><?PHP echo $Data[$i]['estadomateria']?></td>
                        </tr>
                        <?PHP
                    }//for
                    ?>      
                    </tbody>
               </table>    
    <?PHP
} 
             
function DiasSemana($Fecha,$Op=''){
    
if($Op=='Nombre'){
    $dias = array('','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');    
}else{
    $dias = array('','1','2','3','4','5','6','7');    
}

$fecha = $dias[date('N', strtotime($Fecha))]; 

return $fecha;

}//  function DiasSemana
function dameFecha($fecha,$dia){   
list($year,$mon,$day) = explode('-',$fecha);
return date('Y-m-d',mktime(0,0,0,$mon,$day+$dia,$year));        
}//function dameFecha
 function Periodo($database_sala){ //
        /****************************************************/
          $SQL='SELECT 
                
                codigoperiodo AS id,
                codigoperiodo
                
                FROM periodo
                
                WHERE
                
                codigoestadoperiodo IN(1,3)';
                
           $periodos = mysql_db_query($database_sala,$SQL) or die("$SQL");
           $row_periodos = mysql_fetch_array($periodos);
          // echo '<pre>';print_r($row_periodos);
           return $row_periodos['id'];     
        /****************************************************/
    }//function Periodo
  die;
// Selecciona los datos de la materia y los horarios para las materias que tiene el estudiante
while($row_materiasestudiante = mysql_fetch_array($materiasestudiante))
{
	$eselectivalibre = false;
	$eselectivatecnica = false;
	
	$codigomateria = $row_materiasestudiante['codigomateria'];
	$codigomateriaelectiva = $row_materiasestudiante['codigomateriaelectiva'];
	$idgrupo = $row_materiasestudiante['idgrupo'];
	$estado = $row_materiasestudiante['nombreestadodetalleprematricula'];
	// Selecciona los datos de las materias para aquellas que no son electivas, de acuerdo al plan de estudio
	$query_datosmateria = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos
	from materia m, detalleplanestudio dpe, planestudioestudiante pee
	where m.codigomateria = '$codigomateria'
	and pee.codigoestudiante = '$codigoestudiante'
	and m.codigomateria = dpe.codigomateria
	and pee.idplanestudio = dpe.idplanestudio
	and pee.codigoestadoplanestudioestudiante like '1%'";
	// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
	// Tanto enfasis como electivas libres	
	$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
	$totalRows_datosmateria = mysql_num_rows($datosmateria);
	if($totalRows_datosmateria == "")
	{
		// Toma los datos de la materia si es enfasis
		$query_datosmateria = "select m.nombremateria, m.codigomateria, dle.semestredetallelineaenfasisplanestudio as semestredetalleplanestudio,
		dle.numerocreditosdetallelineaenfasisplanestudio as numerocreditos
		from materia m, detallelineaenfasisplanestudio dle, lineaenfasisestudiante lee
		where m.codigomateria = '$codigomateria'
		and lee.codigoestudiante = '$codigoestudiante'
		and m.codigomateria = dle.codigomateriadetallelineaenfasisplanestudio
		and lee.idplanestudio = dle.idplanestudio
		and lee.idlineaenfasisplanestudio = dle.idlineaenfasisplanestudio
		and dle.codigoestadodetallelineaenfasisplanestudio like '1%'
		and (NOW() between lee.fechainiciolineaenfasisestudiante and lee.fechavencimientolineaenfasisestudiante)";
		// Otro query para selecciona los datos de las materias cuando el anterior es vacio para las demás materias
		// Tanto enfasis como electivas libres		
		$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
		$totalRows_datosmateria = mysql_num_rows($datosmateria);
		// Si se trata de una electiva
	}
	if($totalRows_datosmateria == "")
	{
		//echo "Mirar papa <br>";
		// Mira si tiene papa, si el papa es electiva libre toma los creditos directamente del hijo
		// Si no tiene papa toma los datos como si fuera una materia externa		
		$query_datosmateriapapa = "select m.nombremateria, m.codigomateria, dpe.semestredetalleplanestudio, dpe.numerocreditosdetalleplanestudio as numerocreditos,
		dpe.codigotipomateria, gm.codigotipogrupomateria
		from grupomaterialinea gml, materia m, grupomateria gm, detalleplanestudio dpe, planestudioestudiante pee
		where gm.codigoperiodo = '$codigoperiodo'
		and gml.codigomateria = '$codigomateriaelectiva'
		and gml.codigoperiodo = gm.codigoperiodo
		and gm.codigoperiodo = gml.codigoperiodo
		and pee.codigoestudiante = '$codigoestudiante'
		and pee.idplanestudio = dpe.idplanestudio
		and dpe.codigomateria = m.codigomateria
		and gml.codigomateria = m.codigomateria
		and gml.idgrupomateria = gm.idgrupomateria
		and pee.codigoestadoplanestudioestudiante like '1%'
		order by m.nombremateria";
		
		//echo "<br>$query_datosmateriapapa<br>";
		$datosmateriapapa = mysql_query($query_datosmateriapapa, $sala) or die("$query_datosmateriapapa");
		$totalRows_datosmateriapapa = mysql_num_rows($datosmateriapapa);
		if($totalRows_datosmateriapapa == "")
		{
			//echo "<br>$codigomateria2 EXTERNA<br>";
			// En el caso de haber hecho la prematricula y de tratarse de una materia externa en carga academica se
			// Actualmente todos los planes de estudio tiene el ismo numero de creditos para una materia
			// Toca empezar a guardar el plan de estudio de la materia externa en cargaacademica y de este tomar el semestre y
			// y los creditos de la materia y efectuar el conteo de creditos a partir de aca.
			// Debido a que esto no se hiso  para el semestre 20052 toca dejar el codigo siguiente.
			$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
			from materia m
			where m.codigomateria = '$codigomateria'
			and m.codigoestadomateria = '01'";
			$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
			$totalRows_datosmateria = mysql_num_rows($datosmateria);
		}
		else 
		{
			//echo "tienen papa<br>";
			// Si entra aca quiere decir que la materia tiene hijos.
			$row_datosmateriapapa = mysql_fetch_array($datosmateriapapa);
			
			if($row_datosmateriapapa['codigotipogrupomateria'] == "100")
			{
				// Materia electiva libre
				// Si entra es por que la materia hija es libre y debe tomar el numero de creditos de ella
				//echo "LIBRE $codigomateria<br>";
				$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
				from materia m
				where m.codigomateria = '$codigomateria'
				and m.codigoestadomateria = '01'";
				//echo $query_datosmateria;
				$datosmateria=mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
				$totalRows_datosmateria = mysql_num_rows($datosmateria);
				$eselectivalibre = true;
			}
			else if($row_datosmateriapapa['codigotipogrupomateria'] == "200")
			{
				// Materia electiva tecnica
				// Si entra aca es por que la materia debe tomar el numero de creditos del papa
				//echo "TECNICA $codigomateria<br>";
				$query_datosmateria = "select m.nombremateria, m.codigomateria, m.numerocreditos
				from materia m
				where m.codigomateria = '$codigomateria'
				and m.codigoestadomateria = '01'";
				//echo $query_datosmateria;
				$datosmateria = mysql_query($query_datosmateria, $sala) or die("$query_datosmateria");
				$totalRows_datosmateria = mysql_num_rows($datosmateria);
				$row_datosmateria['semestredetalleplanestudio'] =
				$creditospapa = $row_datosmateriapapa['numerocreditos'];
				$eselectivatecnica = true;
			}
		}
	}
	if($totalRows_datosmateria != "")
	{
		
		while($row_datosmateria = mysql_fetch_array($datosmateria))
		{
			if($eselectivatecnica)
			{
				//$creditoshijo = $row_datosmateria['numerocreditos'];
				$row_datosmateria['semestredetalleplanestudio'] = $row_datosmateriapapa['semestredetalleplanestudio'];
				$row_datosmateria['numerocreditos'] = $row_datosmateriapapa['numerocreditos'];
				//echo "aca $creditospapa<br>";
			}
?>
  <table width="750" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
    <tr> 
      <td colspan="5" style="border-top-color:#000000"><label id="labelresaltado"><?php echo $row_datosmateria['nombremateria'];?></label>      </td>
      <td id="tdtitulogris" style="border-top-color:#000000"> 
      Orden de Pago</td>
      <td style="border-top-color:#000000">
        <?php echo $row_materiasestudiante['numeroordenpago'];?>
      </td>
	  <td id="tdtitulogris" style="border-top-color:#000000">Estado</td>
      <td style="border-top-color:#000000"><?php echo $estado;?></td>
	  <td width="3%" id="tdtitulogris" style="border-top-color:#000000">Código</td>
      <td style="border-top-color:#000000"><?php echo $row_datosmateria['codigomateria'];?></td>
    </tr>
<?php 
			// Selecciona los datos de los grupos para una materia   
			$query_datosgrupos = "select g.idgrupo, concat(d.nombredocente,' ',d.apellidodocente) as nombre, g.maximogrupo, g.matriculadosgrupo, g.codigoindicadorhorario, g.nombregrupo
			from grupo g, docente d
			where g.numerodocumento = d.numerodocumento
			and g.codigomateria = '$codigomateria'
			and g.codigoperiodo = '$codigoperiodo'
			and g.idgrupo = '$idgrupo'
			and g.codigoestadogrupo = '10' 
			and d.codigoestado=100";
			//echo $query_datosgrupos;
			$datosgrupos=mysql_query($query_datosgrupos, $sala) or die("$query_datosgrupos");
			$totalRows_datosgrupos = mysql_num_rows($datosgrupos);
			if($totalRows_datosgrupos != "")
			{
				while($row_datosgrupos = mysql_fetch_array($datosgrupos))
				{
					$query_datoshorarios = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon, se.codigosede
					from horario h, dia d, salon s, sede se
					where h.codigodia = d.codigodia
					and h.codigosalon = s.codigosalon
					and h.idgrupo = '$idgrupo'
					and s.codigosede = se.codigosede
					order by 1,3,4";					
					//echo "<br>ACA:$query_datoshorarios<br>";
					$datoshorarios=mysql_query($query_datoshorarios, $sala) or die("$query_datoshorarios");
					$totalRows_datoshorarios = mysql_num_rows($datoshorarios);
?>
    <tr> 
      <td id="tdtitulogris">Grupo</td>
      <td><?php echo $row_datosgrupos['idgrupo'];?></td>
      <td colspan="2" id="tdtitulogris">Docente</td>
      <td><?php echo $row_datosgrupos['nombre'];?></td>
      <td cellpadding="2" cellspacing="1" id="tdtitulogris">Nombre Grupo</td>
      <td><?php echo $row_datosgrupos['nombregrupo'];?></td>
<?php
				if(!$eselectivalibre)
				{
?> 
      <td id="tdtitulogris">Semestre</td>
      <td><?php echo $row_datosmateria['semestredetalleplanestudio'];?></td>
<?php
				}
				else
				{
?>
      <td width="5%" colspan="2" id="tdtitulogris">Materia Electiva</td>
<?php
				}
?>
      <td id="tdtitulogris">Créditos</td>
      <td><?php echo $row_datosmateria['numerocreditos'];?>&nbsp;</td>
    </tr>
<?php
					if(ereg("^1+",$row_datosgrupos['codigoindicadorhorario']))
					{
						if($totalRows_datoshorarios != "")
						{
							$tieneprimergrupoconhorarios = true;
?>
	 <tr>
	 <td colspan="11"> 
	  <table width="100%" border="1" cellpadding="1" cellspacing="0" bordercolor="#E9E9E9">
	    <tr id="trtitulogris"> 
		  <td> 
			Sede 
		  </td>
		  <td> 
			D&iacute;a 
		  </td>
		  <td>Hora Inicial
		    </td>
		  <td> 
		  Hora Final</td>
		  <td> 
		  Sal&oacute;n</td>
 	    </tr>
<?php
							while($row_datoshorarios = mysql_fetch_array($datoshorarios))
							{
?>
	    <tr>
		  <td><?php echo ($arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['sede'] == '') ? 'Falta por asignar' : $arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['sede'];?></td>
		  <td><?php echo $row_datoshorarios['nombredia'];?></td>
		  <td><?php echo $row_datoshorarios['horainicial'];?></td>
		  <td><?php echo $row_datoshorarios['horafinal'];?></td>
		  <td><?php echo ($arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['salon'] == '') ? 'Falta por asignar' : $arreglo_asignaturas[$idgrupo][$row_datoshorarios['nombredia']]['salon'];?></td>
	    </tr>
<?php		
							}
?>
	</table>
	</td>
	</tr>
<?php
						}
						else
						{
							$horariorequerido = true;
?>
	<tr><td colspan="11"><label id="labelresaltado">Este grupo requiere horario, dirijase a su facultad para informarlo</label></td>
	</tr>
<?php
						}
					}
					else
					{
						//continue;
?>
	<tr><td colspan="11"><label id="labelresaltado">Este grupo no necesita horario</label></td>
	</tr>
<?php 
					}
				}
			}
			if($tieneprimergrupo)
			{
?>
</table>
<?php
			}
			else
			{
?>
<tr><td colspan="11"><!-- Esta materia no tiene grupos con cupo o con horarios, informelo a la facultad. <br> Si desea tomar grupos en otra jornada oprima el botón <font color="#000000">Modificar Horarios.  --></td></tr>
<!-- <tr><td colspan="11">&nbsp;</td></tr> -->
</table>
<?php
			}
		}
	}
}
?>
<br>   
</p>
    
  <p>
    <input name="imprimir" type="button" id="imprimir" value="Imprimir" onClick="window.print()">
&nbsp;
<input name="volver" type="button" id="volver" value="Regresar" onClick="history.go(-1)">
</p>

</form>
<?php
$permisograbar = true;
if(isset($_POST['grabar']))
{
	foreach($_POST as $llavepost => $valorpost)
	{
		if(ereg("grupo",$llavepost))
		{
			//echo "$llavepost => $valorpost<br>";
			$codmat = ereg_replace("grupo","",$llavepost);
			// Se guardan el codigo del grupo para una materia
			$materiascongrupo[$codmat] = $valorpost;
			// $valorpost lleva el idgrupo
			$query_horarioselegidos = "select d.codigodia, d.nombredia, h.horainicial, h.horafinal, s.nombresalon, s.codigosalon
			from horario h, dia d, salon s, grupo g
			where h.codigodia = d.codigodia
			and h.codigosalon = s.codigosalon
			and h.idgrupo = '$valorpost'
			and g.idgrupo = h.idgrupo
			and g.codigoindicadorhorario like '1%'
			order by 1,3,4";
			$horarioselegidos=mysql_query($query_horarioselegidos, $sala) or die("$query_horarioselegidos");
			$totalRows_horarioselegidos = mysql_num_rows($horarioselegidos);
			
			while($row_horarioselegidos = mysql_fetch_array($horarioselegidos))
			{
				$codigomateriahorarios[] = ereg_replace("grupo","",$llavepost);
				$diahorarios[] = $row_horarioselegidos['codigodia'];
				$horainicialhorarios[] = $row_horarioselegidos['horainicial'];
				$horafinalhorarios[] = $row_horarioselegidos['horafinal'];
			}
		}
	}
	// Este for lo va a hacer mientras halla horarios
	$maximohorarios = count($codigomateriahorarios)-1;
	for($llavehorario1 = 0; $llavehorario1 <= $maximohorarios; $llavehorario1++) 
  	{
   		for($llavehorario2 = 0; $llavehorario2 <= $maximohorarios; $llavehorario2++) 
     	{	  
	  		if($diahorarios[$llavehorario1] == $diahorarios[$llavehorario2] and $llavehorario1 != $llavehorario2)
	    	{
		  		if((date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) >= date("H-i-s",strtotime($horainicialhorarios[$llavehorario2])))and(date("H-i-s",strtotime($horainicialhorarios[$llavehorario1])) < date("H-i-s",strtotime($horafinalhorarios[$llavehorario2]))))
		      	{				         
					$permisograbar = false;
					echo '<script language="JavaScript">
						alert("FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE '.$nombresmateria[$codigomateriahorarios[$llavehorario1]].' Y  '.$nombresmateria[$codigomateriahorarios[$llavehorario2]].'");
						history.go(-1);
					</script>';
					/*echo "<script language='javascript'>
						window.location.href='matriculaautomaticahorarios.php?programausadopor=".$_GET['programausadopor']."&materiassinhorarios=$materiasserial';
					</script>";*/
				
				 	// echo "<font color=\"#003333\">FAVOR VERIFICAR HORARIOS SELECCIONADOS PRESENTA CRUCE ENTRE&nbsp;",$codigomateria[$c]," &nbsp; Y  &nbsp;",$codigomateria[$b],"</br>";			     
				 	$llavehorario1 = $maximohorarios+1;
				 	$llavehorario2 = $maximohorarios+1;
				}
		   	}
		}
	}
	if($permisograbar)
	{
		$procesoautomatico = false;
		require("matriculaautomaticaguardar.php");
	}
}
?>
<script language="javascript">
function habilitar(campo)
{
	var entro = false;
	for (i = 0; i < campo.length; i++)
	{
		campo[i].disabled = false;
		entro = true;
	}
	if(!entro)
	{
		form1.habilita.disabled = false;
	}
}
</script>
</body>
</html>