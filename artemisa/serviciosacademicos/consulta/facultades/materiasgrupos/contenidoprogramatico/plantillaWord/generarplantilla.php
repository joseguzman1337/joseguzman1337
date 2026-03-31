<?php

/*ini_set('display_errors','On');
ini_set('xdebug.max_nesting_level', 500);*/

include "odt/odf.php";
require_once "../clasedividir.php";
require_once "../../../../../EspacioFisico/templates/template.php";
$db = getBD();
$instanciaObjeto = new exportarDocumento();

	if(!empty($_POST['guardar_data'])){
		$sarray = $_POST['arrayPlantilla2'];
		$arrayPlantilla=unserialize(base64_decode($sarray));
		$var = $instanciaObjeto->crearDocumentoTrasladoInterno($arrayPlantilla );
		$instanciaObjeto->abrirDocumento($arrayPlantilla);
	}
	if($_POST['action']=='guardarDocumento'){
		$instanciaObjeto->guardarContenidoGeneral($db);
		$instanciaObjeto->guardarDocumento($db);
	}

class exportarDocumento{

	public function crearDocumentoTrasladoInterno($arrayPlantilla) {
		$arrayPlantilla['vacio']=null;
		$odf = new odf("plantilla.odt");
		$odf->setVars( 'FACU' , utf8_decode($arrayPlantilla['nombrefacultad']) );
		$odf->setVars('Programa', utf8_decode($arrayPlantilla['nombrecarrera']));
		$odf->setVars('NombreAsignatura', utf8_decode($arrayPlantilla['nombremateria']));
		$odf->setVars('CodigoA', utf8_decode($arrayPlantilla['codigomateria']));
		$odf->setVars('Semestre',utf8_decode($arrayPlantilla['semestre']));
		$odf->setVars('Periodo', utf8_decode($arrayPlantilla['codigoperiodo']));
		$odf->setVars('Area', utf8_decode($arrayPlantilla['vacio']));
		if($arrayPlantilla['tipomateria'] == "1"){
			$odf->setVars('O', "X");
			$odf->setVars('E', "");
		}else{
			$odf->setVars('E', "X");
			$odf->setVars('O', "");
		}
		$odf->setVars('T', utf8_decode($arrayPlantilla['porcentajeteoricamateria']));
		$odf->setVars('P', utf8_decode($arrayPlantilla['porcentajepracticamateria']));
		$odf->setVars('TP', utf8_decode($arrayPlantilla['vacio']));
		$odf->setVars('PRE', utf8_decode($arrayPlantilla['prerequisito']));
		$odf->setVars('CO', utf8_decode($arrayPlantilla['vacio']));
		$odf->setVars('N', utf8_decode($arrayPlantilla['numerocreditosdetalleplanestudio']));
		$odf->setVars('H', utf8_decode($arrayPlantilla['numerohorassemanales']));
		$odf->setVars('HP', utf8_decode($arrayPlantilla['horaspresencialessemestre']));
		$hi= $arrayPlantilla['numerocreditosdetalleplanestudio'] * 3 - $arrayPlantilla['numerohorassemanales'];
		$odf->setVars('HI', $hi);
		$ts=$odf->saveToDisk( "plantillacontenido.doc" );

	}
	public function abrirDocumento($arrayPlantilla){
		$nombre= $arrayPlantilla['codigomateria'].'_'.$arrayPlantilla['nombremateria'];
		$nombre_documento = preg_replace('[\s+]',"", $nombre);
		header('Content-disposition: attachment; filename = '.$nombre_documento.'.doc');
		header("Content-type: MIME");
		readfile("plantillacontenido.doc");
	}
    //funcion de guardar los pdfs de contenidos
	public function guardarDocumento($db)
    {
		$consultaContenidoExitente=$this->consultarContenido($db,$_POST['periodo'],$_POST['codigomateria'],$_POST['usuario']);
		if($_FILES['archivo']['size']!=0){
            $usuario = $_POST['usuario'];
			 $nombre_archivo = $_FILES['archivo']['name'];
			$tipo_archivo = $_FILES['archivo']['type'];
			$tamano_archivo = $_FILES['archivo']['size'];
			$archivotmp = $_FILES['archivo']['tmp_name'];
			$nombrearchivoinstitucional="../institucional/institucional_".$consultaContenidoExitente['idcontenidoprogramatico'].".pdf";
			$eliminacion = false;
			if (unlink($nombrearchivoinstitucional)){
                $eliminacion = true;
            }; // si la ruta fisica del archivo existe se procede a eliminar

			//$extension = explode(".",$nombre_archivo);

            $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
            $mime = finfo_file($finfo, $_FILES['archivo']['tmp_name']);
            finfo_close($finfo);

            //if("pdf"!=$extension[2]) {
            if($_FILES['archivo']['type'] != "application/pdf" && $mime!="application/pdf")
            {
				$respuesta->mensaje = "El archivo de Institucional de Asignaturas debe ser de extensión PDF";
			}
			else if($tamano_archivo > 1024000) {
				$respuesta->mensaje = "El archivo de Institucional de Asignaturas sobrepasa el tamaño adecuado para ser subido, maximo de 1 MB";
			}
            else
            {
                if(move_uploaded_file($archivotmp, $nombrearchivoinstitucional))
                {
                    //Guardar archivo institucional general sin dividir
                    if(file_exists($nombrearchivoinstitucional))
                    {
                        $this->updateInstitucional($db,$consultaContenidoExitente['idcontenidoprogramatico'],$nombrearchivoinstitucional,$consultaContenidoExitente['fechafincontenidoprogramatico']);
                        $pdf = new ConcatPdf(); //dividir para syllabus
                        $pdf->setFiles(array($nombrearchivoinstitucional));
                        $resultado = $pdf->concat(1,2);
                        if($resultado== 'error')
                        {
                            $respuesta->estado = false;
                            $respuesta->mensaje = "El archivo tiene errores. Acérquese a la Mesa de servicio de tecnología con la plantilla de WORD. EXT:1555";
                        }
                        else
                        {
                            $pdf->Output('../institucional/Syllabus_'.$consultaContenidoExitente['idcontenidoprogramatico'].'.pdf', 'F');
                            $nombrearchivoSyllabus = '../institucional/Syllabus_'.$consultaContenidoExitente['idcontenidoprogramatico'].'.pdf';
                            $this->updateSyllabus($db,$consultaContenidoExitente['idcontenidoprogramatico'],$nombrearchivoSyllabus,$usuario);
                            $pdf = new ConcatPdf();//dividir para contenido programatico
                            $pdf->setFiles(array($nombrearchivoinstitucional));
                            $pdf->concat(3,20);
                            $pdf->Output('../contenido/contenido_'.$consultaContenidoExitente['idcontenidoprogramatico'].'.pdf', 'F');
                            $nombrearchivoContenido = '../contenido/contenido_'.$consultaContenidoExitente['idcontenidoprogramatico'].'.pdf';
                            $nombrearchivoSyllabus = '../institucional/Syllabus_'.$consultaContenidoExitente['idcontenidoprogramatico'].'.pdf';
                            $this->updateContenido($db,$consultaContenidoExitente['idcontenidoprogramatico'],$nombrearchivoContenido);
                            $respuesta->mensaje = "El archivo se guardo con Exito";
                            if ($eliminacion){
                                $respuesta->mensaje = "El archivo se actualizo con Exito Reemplazando el archivo anterior";
                            }
                        }
                    }else
                    {
                        $respuesta->estado = false;
                        $respuesta->mensaje = "El archivo institucional no se pudo subir al servidor, intentalo mas tarde";
                    }
				} else {
					$respuesta->estado = false;
					$respuesta->mensaje = "El archivo institucional no se pudo subir al servidor, intentalo mas tarde";
				}//else
            }//else
		}echo json_encode($respuesta);
	}
	public function guardarContenidoGeneral($db){
		$nombre_archivo = $_FILES['archivo']['name'];
		$codigoArchivo = intval(preg_replace('/[^0-9]+/', '_', $nombre_archivo), 10);
		if($codigoArchivo <> $_POST['codigomateria']){
			$respuesta->mensaje = "El archivo que intenta cargar no corresponde a la asignatura o esta vacío";
			echo json_encode($respuesta);
			exit();
		}

		$consultaContenidoExitente=$this->consultarContenido($db,$_POST['periodo'],$_POST['codigomateria'],$_POST['usuario']);
		if (empty($consultaContenidoExitente)){
			$query="SELECT fechainicioperiodo,fechavencimientoperiodo FROM periodo WHERE codigoperiodo = '".$_POST['periodo']."'";
			if($row_fechaperiodo=&$db->GetAll($query) === false){
				echo 'Ocurrio un error al consultar la data';
				die;
			}
			$query_guardar = "INSERT INTO contenidoprogramatico (codigomateria, codigoperiodo, fechainiciocontenidoprogramatico, fechafincontenidoprogramatico, usuario, codigoestado)
			values ('".$_POST['codigomateria']."','".$_POST['periodo']."','".$row_fechaperiodo[0]['fechainicioperiodo']."','".$row_fechaperiodo[0]['fechavencimientoperiodo']."', '".$_POST['usuario']."',100)";
			if ($insertar = $db->Execute($query_guardar) === false) {
				echo 'Error al insertar contenido';
				exit;
			}
		}

	}
	public function consultarContenido($db,$periodo,$codigomateria,$usuario){

		$query="SELECT idcontenidoprogramatico,fechafincontenidoprogramatico FROM contenidoprogramatico WHERE codigoperiodo = '".$periodo."' AND codigomateria = '".$codigomateria."'";
		if($row_data=&$db->GetAll($query) === false){
			echo 'Ocurrio un error al consultar la data';
			die;
		}
		if(empty($row_data[0])){
			$row_data[0] = null;
		}else{
			return $row_data[0];
		}

	}
	public function updateSyllabus($db,$idcontenidoprogramatico,$nombrearchivoSyllabus,$usuario){
		$query_updateInstitucional= "UPDATE contenidoprogramatico  SET  urlasyllabuscontenidoprogramatico = '".$nombrearchivoSyllabus."', usuario= '".$usuario."'  WHERE  idcontenidoprogramatico='".$idcontenidoprogramatico."'";

		if ($insertar = $db->Execute($query_updateInstitucional) === false) {
			echo 'Error al insertar contenido';
			exit;
		}

	}
	public function updateContenido($db,$idcontenidoprogramatico,$nombrearchivoContenido){
		$query_updateInstitucional= "UPDATE contenidoprogramatico SET urlcontenidoprogramatico ='".$nombrearchivoContenido."' WHERE  idcontenidoprogramatico='".$idcontenidoprogramatico."'";

		if ($insertar = $db->Execute($query_updateInstitucional) === false) {
			echo 'Error al insertar contenido';
			exit;
		}
	}
	public function updateInstitucional($db,$idcontenidoprogramatico,$nombrearchivoinstitucional,$fechaFin){
		$query_updateInstitucional= "UPDATE contenidoprogramatico  SET  urlaarchivofinalcontenidoprogramatico = '".$nombrearchivoinstitucional."' WHERE  idcontenidoprogramatico='".$idcontenidoprogramatico."'";
		if ($insertar = $db->Execute($query_updateInstitucional) === false) {
			echo 'Error al insertar contenido';
			exit;
		}
		
		$queryDetalleContenido="INSERT INTO detallecontenidoprogramatico (idcontenidoprogramatico, codigotipodetallecontenidoprogramatico, fechadetallecontenidoprogramatico, 
		codigoestado) VALUES (".$idcontenidoprogramatico.", '200', '".$fechaFin."', '100')";
		
		if ($insertarDetalle = $db->Execute($queryDetalleContenido) === false) {
			echo 'Error al insertar contenido';
			exit;
		}
	}
}


?>