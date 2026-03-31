<?php
// Test CVS

/*ini_set('display_errors', 'On');
error_reporting(E_ALL);*/

include '../../../educacionContinuada/Excel/reader.php';
include("../../templates/templateAutoevaluacion.php");
$db = writeHeaderBD(false);
include '../../../educacionContinuada/class/Utils.php';
?>
<img src="../../../educacionContinuada/images/ajax-loader2.gif" style="display:block;clear:both;margin:20px auto;" id="loading"/>
<?php 

function agregarRespuestasInstrumento($db,$encuesta,$publicoRow,$instrumentoRow,$login,$grupo){
	$todobien = true;
	$hoy = date('Y-m-d H:i:s');
	reset($encuesta["respuestas"]);
	$first_key = key($encuesta["respuestas"]);
	
	$totalParticipantes = 0;
	foreach($encuesta["respuestas"][$first_key] as $cantidadRespuestas){
		$totalParticipantes+=$cantidadRespuestas;
	}
		//echo "<br/>participantes->".$totalParticipantes;
	
	for($i=1; $i<=$totalParticipantes; $i++){
		
		$sqlI = "INSERT INTO `siq_Apublicoobjetivocsv` (`idsiq_Apublicoobjetivo`, `cedula`, `nombre`, `apellido`, `correo`, `estudiante`, `docente`, `padre`, `vecinos`, `practica`, `docencia_servicio`, `administrativos`, `otros`, `codigoestado`, `fechacreacion`) VALUES ('".$publicoRow["idsiq_Apublicoobjetivo"]."', '".$i."', '-', '-', '-', '0', '0', '0', '0', '0', '0', '0', '1', '100', '".$hoy."')";
		$db->Execute($sqlI);
		//echo $sqlI."<br/>";
		
		$sqlI = "INSERT INTO `actualizacionusuario` (`id_instrumento`, `codigoperiodo`, `estadoactualizacion`, `numerodocumento`) VALUES ('".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."', '20142', '2', '".$i."')";
		$db->Execute($sqlI);
		//echo $sqlI."<br/>";
		
		$sql = "SELECT idactualizacionusuario FROM actualizacionusuario WHERE cedula='".$i."' AND id_instrumento='".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."'";
		$actualizacionRow = $db->GetRow($sql);
		
		foreach($encuesta["respuestas"] as $idpregunta=>$respuestas){
			$valor = null;
			if($respuestas[0]>0){
				$valor = -1;
				$encuesta["respuestas"][$idpregunta][0] = $encuesta["respuestas"][$idpregunta][0]-1;
			} else if($respuestas[1]>0){
				$valor = 1;
				$encuesta["respuestas"][$idpregunta][1] = $encuesta["respuestas"][$idpregunta][1]-1;
			} else if($respuestas[2]>0){
				$valor = 2;
				$encuesta["respuestas"][$idpregunta][2] = $encuesta["respuestas"][$idpregunta][2]-1;
			} else if($respuestas[3]>0){
				$valor = 3;
				$encuesta["respuestas"][$idpregunta][3] = $encuesta["respuestas"][$idpregunta][3]-1;
			} else if($respuestas[4]>0){
				$valor = 4;
				$encuesta["respuestas"][$idpregunta][4] = $encuesta["respuestas"][$idpregunta][4]-1;
			}
			
			$sql = "SELECT idsiq_Apreguntarespuesta FROM siq_Apreguntarespuesta WHERE idsiq_Apregunta='".$idpregunta."' AND valor='".$valor."'";
			$respuestaRow = $db->GetRow($sql);
			//echo $sql."<br/>";
			
			$sqlI = "INSERT INTO `siq_Arespuestainstrumento` (`idsiq_Ainstrumentoconfiguracion`, `idsiq_Apregunta`, `idsiq_Apreguntarespuesta`, `cedula`, `nombre`, `apellido`, `correo`, `codigoestado`, `fechacreacion`, `fechamodificacion`) VALUES ('".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."', '".$idpregunta."', '".$respuestaRow["idsiq_Apreguntarespuesta"]."', '".$i."', '-', '-', '-', '100', '".$hoy."', '".$hoy."')";
			$db->Execute($sqlI);
			//echo $sqlI."<br/>";
			
			$sql = "SELECT idsiq_Arespuestainstrumento FROM siq_Arespuestainstrumento WHERE idsiq_Apregunta='".$idpregunta."' AND cedula='".$i."' AND idsiq_Ainstrumentoconfiguracion='".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."'";
			$respuestaInstrumentoRow = $db->GetRow($sql);
			
			$sqlI = "INSERT INTO `siq_ARelacionRespuestaActualizacion` (`idactualizacionusuario`, `idsiq_Arespuestainstrumento`, `UsuarioCreacion`, `FechaCreacion`) VALUES ('".$actualizacionRow["idactualizacionusuario"]."', '".$respuestaInstrumentoRow["idsiq_Arespuestainstrumento"]."', '".$login."', '".$hoy."')";
			$db->Execute($sqlI);
			
			$sqlI = "INSERT INTO `siq_ADetallesRespuestaInstrumentoEvaluacionDocente` (`idactualizacionusuario`, `idgrupo`, `codigojornada`, `UsuarioCreacion`, `FechaCreacion`, `codigoestado`, `UsuarioUltimaModificacion`, `FechaUltimaModificacion`) VALUES ('".$actualizacionRow["idactualizacionusuario"]."', '".$grupo."', '01', '".$login."', '".$hoy."', '100', '".$login."', '".$hoy."')";
			$db->Execute($sqlI);
			
		}
	}
	return $todobien;
}

function agregarPreguntasEInstrumento($db,$hojaExcel,$tipoEncuestaTexto,$fila,$user,$opcionesRespuesta){
	$filaI = $fila;
	$total = $hojaExcel['numRows'];
	$columnas = $hojaExcel['numCols'];
	$hoy = date('Y-m-d H:i:s');
	$respuestas = array();
	$preguntasEncuesta = array();
	$ultimaPregunta = null;
	for ($i = $filaI; $i <= $total; $i++) {
		$filaReal = false;
		$datosFila = array();
		for ($j = 1; $j <= $columnas; $j++) {
			$datosFila[$j] = $hojaExcel['cells'][$i][$j];
			if($datosFila[$j]!=""){
				$filaReal = true;
			}
		}
		if($filaReal && $datosFila[2]!=NULL){
			//es pregunta
			$pregunta = utf8_encode(trim($datosFila[2]));
			$sql = "SELECT idsiq_Apregunta FROM siq_Apregunta WHERE titulo='".$pregunta."' AND cat_ins='EC'";
			$preguntaRow = $db->GetRow($sql);
			//echo $sql."<br/>";
			if(! (count($preguntaRow)>0 && $preguntaRow!=false)){
				$sqlI = "INSERT INTO `siq_Apregunta` (`titulo`, `obligatoria`, `idsiq_Atipopregunta`, `categoriapregunta`, `codigoestado`, `fechacreacion`, `fechamodificacion`, `cat_ins`) VALUES ('".$pregunta."', '1', '1', '1', '100', '".$hoy."', '".$hoy."','EC')";
				$db->Execute($sqlI);
				//echo $sqlI."<br/>";
				$preguntaRow = $db->GetRow($sql);
				
				foreach($opcionesRespuesta as $respuesta=>$valor){
					$sqlI = "INSERT INTO `siq_Apreguntarespuesta` (`respuesta`, `valor`, `correcta`, `unica_respuesta`, `multiple_respuesta`, `maximo_caracteres`, `aparejamiento`, `analisis`, `idsiq_Apregunta`, `codigoestado`, `fechacreacion`, `fechamodificacion`) VALUES ('".$respuesta."', '".$valor."', '0', '1', '0', '0', '0', '0', '".$preguntaRow["idsiq_Apregunta"]."', '100', '".$hoy."', '".$hoy."')";
					$db->Execute($sqlI);
					//echo $sqlI."<br/>";
				}
			}
			$preguntasEncuesta[] = $preguntaRow["idsiq_Apregunta"];
			$ultimaPregunta = $preguntaRow["idsiq_Apregunta"];
		} else if($filaReal && $ultimaPregunta!=null){
			//son la cantidad de respuestas
			$respuestas[$ultimaPregunta][0] = $datosFila[3];
			$respuestas[$ultimaPregunta][1] = $datosFila[4];
			$respuestas[$ultimaPregunta][2] = $datosFila[5];
			$respuestas[$ultimaPregunta][3] = $datosFila[6];
			$respuestas[$ultimaPregunta][4] = $datosFila[7];
		} 
		$fila++;
	}
	return array("respuestas"=>$respuestas,"preguntas"=>$preguntasEncuesta);
}

$utils = Utils::getInstance();
$user=$utils->getUser();
$login=$user["idusuario"];
$carrera = $_POST["codigocarrera"];
	$sql = "SELECT nombrecarrera,codigocarrera FROM carrera WHERE codigocarrera='".$carrera."'";
	$carreraRow = $db->GetRow($sql);
$grupo = $_POST["idgrupo"];
$data = new Spreadsheet_Excel_Reader();
$respuesta="";

// Set output Encoding.
$data->setOutputEncoding('CP1251');

$data->read($_FILES["file"]["tmp_name"]);

$dateHoy=date('Y-m-d H:i:s');
$todobien = true;
$errores = 0;
$mensajesError = array();
$opcionesRespuesta = array ("NA"=>"-1","1 (Inferior)"=>1,"2 (Regular)"=>2,"3 (Bueno)"=>3,"4 (Óptimo)"=>4);
foreach($data->sheets as $hojaExcel){
	//por cada hoja de excel

	$fila = 4;
	
	//titulo de la encuesta para ver el tipo
	$tipoEncuestaTexto = utf8_encode(trim($hojaExcel['cells'][1][1]));
	//echo "<br/>hoja->".$tipoEncuestaTexto."<pre>";print_r($hojaExcel);
	/*if (strpos($tipoEncuestaTexto,"ADMINISTRATIVA") !== false) {
		// es administrativa
		$tipoEncuesta=1;
	} else if(strpos($tipoEncuestaTexto,"GENERAL") !== false){
		//es general
		$tipoEncuesta=2;
	} else {
		//es docente
		$tipoEncuesta=3;
	}*/
		
	
	//agregar preguntas
	$encuesta = agregarPreguntasEInstrumento($db,$hojaExcel,$tipoEncuestaTexto,$fila,$user,$opcionesRespuesta);
	//echo "<br/><br/>encuesta-> <pre>"; print_r($encuesta); die;
	
	//encontrar la seccion
	$sql = "SELECT idsiq_Aseccion FROM siq_Aseccion WHERE cat_ins='EC'";
	$seccionRow = $db->GetRow($sql);
	
	if(count($seccionRow)>0 && $seccionRow!==false){
		//crear el instrumento
		$sqlI = "INSERT INTO `siq_Ainstrumentoconfiguracion` (`nombre`, `fecha_inicio`, `fecha_fin`, `estado`, `secciones`, `codigocarrera`, `codigoestado`, `cat_ins`) VALUES ('".$tipoEncuestaTexto." - ".$carreraRow["nombrecarrera"]."', '2014-12-01 09:11:35', '2014-12-02 09:11:39', '1', '1', '".$carrera."', '100', 'EC')";
		$db->Execute($sqlI);
		//echo $sqlI."<br/>";
		
		$sql = "SELECT idsiq_Ainstrumentoconfiguracion FROM siq_Ainstrumentoconfiguracion WHERE cat_ins='EC' ORDER BY idsiq_Ainstrumentoconfiguracion DESC";
		$instrumentoRow = $db->GetRow($sql);
		
		$sqlI = "INSERT INTO `siq_Ainstrumentoseccion` (`idsiq_Ainstrumentoconfiguracion`, `idsiq_Aseccion`, `codigoestado`, `fechacreacion`, `fechamodificacion`) VALUES ('".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."', '".$seccionRow["idsiq_Aseccion"]."', '100', '".$dateHoy."', '".$dateHoy."')";
		$db->Execute($sqlI);
		//echo $sqlI."<br/>";
		
		//asociar las preguntas
		foreach ($encuesta["preguntas"] as $pregunta){
			$sqlI = "INSERT INTO `siq_Ainstrumento` (`idsiq_Ainstrumentoconfiguracion`, `idsiq_Apregunta`, `idsiq_Aseccion`, `codigoestado`) VALUES ('".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."', '".$pregunta."', '".$seccionRow["idsiq_Aseccion"]."', '100')";
			$db->Execute($sqlI);
			//echo $sqlI."<br/>";
		}
		
		//público objetivo
		$sqlI = "INSERT INTO `siq_Apublicoobjetivo` (`idsiq_Ainstrumentoconfiguracion`, `estudiante`, `docente`, `admin`, `entrydate`, `obligar`, `userid`) VALUES ('".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."', '0', '0', '0', '".$dateHoy."', '0', '".$login."')";
		$db->Execute($sqlI);
	    //echo $sqlI."<br/>";
		
		$sql = "SELECT idsiq_Apublicoobjetivo from siq_Apublicoobjetivo WHERE idsiq_Ainstrumentoconfiguracion='".$instrumentoRow["idsiq_Ainstrumentoconfiguracion"]."'";
		$publicoRow = $db->GetRow($sql);
		
		//insertar las respuestas
		$todobien = agregarRespuestasInstrumento($db,$encuesta,$publicoRow,$instrumentoRow,$login,$grupo);
	} else {
		$errores = $errores + 1;
		$todobien = false;
		$mensajesError[] = "Ocurrio un problema con la seccion en la hoja :".$tipoEncuestaTexto." y fila ".$fila.".";
	}
	//echo "<br/><br/>respuestas-> <pre>"; print_r($encuesta["respuestas"]);
}

if($todobien){
    $respuesta= "exito:Las respuestas fueron registradas exitosamente.";
}   else {
    $respuesta= "fail:Ocurrio un error con ".$errores." respuesta(s) al tratar de realizar el registro.";
	foreach($mensajesError as $error){
		$respuesta.= "<br/>".$error;
	}
}
    

?>

<script language="javascript" type="text/javascript">
    window.location.href="cargarRespuestas.php?mensaje=<?php echo $respuesta;?>";
</script>