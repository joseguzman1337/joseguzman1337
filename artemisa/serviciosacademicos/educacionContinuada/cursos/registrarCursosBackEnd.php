<?php
// Test CVS
session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	

include realpath(dirname(__FILE__)).'/../Excel/reader.php';
include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
require_once("functionsRegistroCarrerasYGrupos.php");
?>
<img src="../images/ajax-loader2.gif" style="display:block;clear:both;margin:20px auto;" id="loading"/>
<?php 
$db = getBD();

// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
$respuesta="";

// Set output Encoding.
$data->setOutputEncoding('CP1251');

$data->read($_FILES["file"]["tmp_name"]);

//error_reporting(E_ALL ^ E_NOTICE);
$dateHoy=date('Y-m-d H:i:s');
$dateHoySimple=date('Y-m-d');

$utils = Utils::getInstance();
$data2 = $utils->getUser();
$idUsuario=$data2['idusuario'];
$ip=$_SERVER['REMOTE_ADDR'];
$filas = $data->sheets[0]['numRows'];
$mensajesError = array();
$fila = 2;
$errores = 0;
for ($z = 2; $z <= $filas; $z++) {
    $datosRegistro = array();
    $curso=array();
	$error = 0;
$filaReal = false;
	//saco todas las variables
    for ($j = 1; $j <= 22; $j++) {
        $curso[$j]=$data->sheets[0]['cells'][$z][$j];
	if($curso[$j]!=""){
            $filaReal = true;
        }
    }
	
	//Sacamos las variables
	$codigoCurso = $curso[1];
    $nombreStr=utf8_encode($curso[2]);
    $facultadStr=utf8_encode($curso[3]);
    $tipoActividadStr=$curso[4];
    $categoriaStr=$curso[5];
    $ciudadStr=utf8_encode($curso[6]);
    $tipoStr=$curso[7];
	if($curso[8]!=null){
		//para convertir el valor que devuelve excel a la fecha
		$UNIX_DATE = ($curso[8] - 25569) * 86400;
		$fechaInicioInscripcion = date("Y-m-d", $UNIX_DATE); 
	} else {
		$fechaInicioInscripcion = null;
	}
	if($curso[9]!=null){
		$UNIX_DATE = ($curso[9] - 25569) * 86400;
		$fechaFinInscripcion = date("Y-m-d", $UNIX_DATE); 
	} else {
		$fechaFinInscripcion = null;
	}
	$valorMatricula = $curso[10];
	if($curso[11]!=null){
		$UNIX_DATE = ($curso[11] - 25569) * 86400;
		$fechaFinPagoMatricula = date("Y-m-d", $UNIX_DATE); 
	} else {
		$fechaFinPagoMatricula = null;
	}
    $nucleoStr=$curso[12];
	if($curso[13]!=null){
		$UNIX_DATE = ($curso[13] - 25569) * 86400;
		$fechaInicioDateTime=date("Y-m-d", $UNIX_DATE); 
	} else {
		$fechaInicioDateTime=null;
	}
	if($curso[14]!=null){
		$UNIX_DATE = ($curso[14] - 25569) * 86400;
		$fechaFinDateTime=date("Y-m-d", $UNIX_DATE); 
	} else {
		$fechaFinDateTime=null;
	}
    $intensidadInt=$curso[15];
	if($curso[16]==null){
		$empresasArray= array();
	} else {
		$empresasArray=  explode(';', utf8_encode($curso[16]));
	}
	if($curso[17]==null){
		$profesoresArray= array();
	} else {
		$profesoresArray=  explode(';', $curso[17]);
	}
    $modalidadStr=$curso[18];
    $tipoCertificacionStr=utf8_encode($curso[19]);
	if($curso[20]==""){
$creditosInt=0;
} else {
    $creditosInt=$curso[20];
}
    $porcentajeFallas=$curso[21];
    $autorizacion=utf8_encode($curso[22]);
	
	$idCarrera=-1;
    $idFacultad=-1;
	//si alguno de estos es diferente de null significa que hay información de 1 curso
    if($codigoCurso!=null || $nombreStr!=null || $facultadStr!=null || $tipoActividadStr!=null || 
		$categoriaStr!=null || $ciudadStr!=null || $tipoStr!=null || $nucleoStr!=null || $fechaInicioDateTime!=null 
		|| $fechaFinDateTime!=null || $intensidadInt!=null || $modalidadStr!=null || $tipoCertificacionStr!=null 
		|| $creditosInt!=null || $valorMatricula!=null){
		
		if($creditosInt==null){
			 $creditosInt = 0;
		}
		
		$peridoSelectRow = $utils->getPeriodoActual($db);     
    
		//encontrar categoria del curso
		$sql = "SELECT nombre,idcategoriaCursoEducacionContinuada FROM categoriaCursoEducacionContinuada 
		WHERE nombre LIKE '%".$categoriaStr."%'";
		$categoria = $db->GetRow($sql);
		
		if(count($categoria)>0){
			//verificar si la ciudad hay que agregarla o que... Solo cuando es presencial
			if($categoria["idcategoriaCursoEducacionContinuada"]!=2){
				if($ciudadStr!==""){
					$sql = "SELECT idciudad,nombreciudad FROM ciudad WHERE nombreciudad LIKE '%".$ciudadStr."%' OR 
								nombrecortociudad LIKE '%".$ciudadStr."%'";
					$ciudad = $db->GetRow($sql);
					
					if(count($ciudad)==0){
						//crear nueva ciudad
						$ciudad=gestionarCiudadCurso($utils,$ciudadStr);
					} else {
						$ciudad = $ciudad["idciudad"];
					}
					
				} else {
					//no tiene ciudad a pesar de ser presencial...
					$error++;
					$mensajesError[] = "En la fila ".$fila." no se especifico la ciudad a pesar de ser un curso presencial.";
				}
			} else {
				$ciudad=null;
			}
			
			//verificar la carrera si es nueva o no
			if($error==0){
				if($codigoCurso!=null){
					$sql = "SELECT * FROM carrera WHERE codigocarrera='".$codigoCurso."' AND codigomodalidadacademica=400";
					$cursoEC = $db->GetRow($sql);
				} else {
					$sql = "SELECT * FROM carrera WHERE nombrecarrera='".$nombreStr."' AND codigomodalidadacademica=400";
					$cursoEC = $db->GetRow($sql);
				}
				//echo "<pre>"; print_r($cursoEC);echo "</pre><br/>";
				if(count($cursoEC)==0){
					//es nuevo el curso, para tratar de ordenar por relevancia
					$sql = "SELECT * FROM facultad WHERE (nombrefacultad='".$facultadStr."' OR nombrefacultad LIKE '%".$facultadStr."%') AND codigoestado=100
							ORDER BY CASE 
								when nombrefacultad='".$facultadStr."' then 1 
								when nombrefacultad LIKE '%facultad%'  then 2 
								when nombrefacultad LIKE '".$facultadStr."' then 3 
								else 3 
							END";
					$facultad = $db->GetRow($sql);
					//echo "<pre>"; print_r($facultad);echo "</pre><br/>";
					//echo $facultadStr."<br/>";
					if(count($facultad)>0){
						/*$fields = array();
                        $fields["codigocortocarrera"] = microtime(true);
                        $fields["nombrecortocarrera"] = $nombreStr;
                        $fields["nombrecarrera"] = $nombreStr;
						$fields["codigofacultad"] = $facultad["codigofacultad"];
						$fields["centrocosto"] = $utils->getValorDefectoCampo($db,"Centro de Costo");
						$fields["codigocentrobeneficio"] = 'PE000090';
						$fields["codigosucursal"] = '60';
						$fields["codigomodalidadacademica"] = '400';
						$fields["fechainiciocarrera"] = $dateHoy;
						$fields["iddirectivo"] = $utils->getValorDefectoCampo($db,"Directivo");
						$fields["codigotitulo"] = '23';
						$fields["codigotipocosto"] = '200';
						$fields["codigoindicadorcobroinscripcioncarrera"] = '200';
						$fields["codigoindicadorprocesoadmisioncarrera"] = '200';
						$fields["codigoindicadorplanestudio"] = '200';
						$fields["codigoindicadortipocarrera"] = '300';
						$fields["codigoreferenciacobromatriculacarrera"] = '200';
						$fields["numerodiaaspirantecarrera"] = '15';
						$fields["codigoindicadorcarreragrupofechainscripcion"] = '100';
						$fields["codigomodalidadacademicasic"] = '400';
                        $result = $utils->processData("save","carrera","codigocarrera",$fields,false);*/
						$result = crearCarrera($utils,$db,$nombreStr,$facultad["codigofacultad"]);
						
						if($result!=0){
							$sql = "SELECT * FROM carrera WHERE nombrecarrera='$nombreStr' AND codigomodalidadacademica=400";
							$cursoEC = $db->GetRow($sql);
						} else {
							$error++;
							$mensajesError[] = "Ocurrio un error al crear el programa ".$fila.".";
						}
					} else {
						$error++;
						$mensajesError[] = "No se encontro la facultad indicada en la fila ".$fila.".";
					}
				} 
				
				if($error==0){
					$sql = "SELECT * FROM actividadEducacionContinuada WHERE nombre LIKE '%".$tipoActividadStr."%' ";
					//echo $sql."<br/>";
					$tipo = $db->GetRow($sql);
					
					$sql = "SELECT * FROM nucleoEstrategico WHERE nombre LIKE '%".$nucleoStr."%' ";
					//echo $sql."<br/>";
					$nucleo = $db->GetRow($sql);
					
					$sql = "SELECT * FROM modalidadCertificacionEducacionContinuada WHERE nombre LIKE '%".$modalidadStr."%' ";
					//echo $sql."<br/>";
					$mod = $db->GetRow($sql);
					
					$sql = "SELECT * FROM tipoCertificacionEducacionContinuada WHERE nombre LIKE '%".$tipoCertificacionStr."%' ";
					//echo $sql."<br/>";
					$tipoC = $db->GetRow($sql);
					if(count($tipo)>0 && count($nucleo)>0 && $tipoActividadStr!="" && $nucleoStr!=""
					&& $modalidadStr!="" && count($mod)>0 && $tipoCertificacionStr!="" && count($tipoC)>0){
						$sql = "SELECT * FROM detalleCursoEducacionContinuada WHERE codigocarrera='".$cursoEC["codigocarrera"]."' ";
						$row = $db->GetRow($sql);
						
						$fields = array();
						$fields["codigocarrera"] = $cursoEC["codigocarrera"];
						$fields["actividad"] = $tipo["idactividadEducacionContinuada"];
						$fields["categoria"] = $categoria["idcategoriaCursoEducacionContinuada"];
						$fields["ciudad"] = $ciudad;
						$fields["nucleoEstrategico"] = $nucleo["idnucleoEstrategico"];
						$fields["intensidad"] = $intensidadInt;
						$fields["modalidadCertificacion"] = $mod["idmodalidadCertificacionEducacionContinuada"];
						$fields["tipoCertificacion"] = $tipoC["idtipoCertificacionEducacionContinuada"];
						$fields["porcentajeFallasPermitidas"] = $porcentajeFallas;
						$fields["autorizacion"] = $autorizacion;
						if(count($row)>0){
							$result = $row["iddetalleCursoEducacionContinuada"];
							$fields["iddetalleCursoEducacionContinuada"] = $result;
							$utils->processData("update","detalleCursoEducacionContinuada","iddetalleCursoEducacionContinuada",$fields,false);
						} else {
							$result = $utils->processData("save","detalleCursoEducacionContinuada","iddetalleCursoEducacionContinuada",$fields,false);
						}
					} else {
						$error++;
						$mensajesError[] = "Ocurrio un error al registrar detalles de tipo de actividad, núcleo estrátegico, modalidad de certificación y tipo de certificanción en la fila ".$fila.".";
					}
				}
				
				if($error==0){
					$sql = "SELECT * FROM jornadacarrera WHERE codigocarrera='".$cursoEC["codigocarrera"]."'";
					$jornada = $db->GetRow($sql);
					if(count($jornada)==0){
						//jornada carrera
                        $fields = array();
                        $fields["nombrejornadacarrera"] = $nombreStr;
                        $fields["codigocarrera"] = $result;
                        $fields["codigojornada"] = '01';
                        $fields["numerominimocreditosjornadacarrera"] = $creditosInt;
                        $fields["numeromaximocreditosjornadacarrera"] = $creditosInt;
                        $fields["fechajornadacarrera"] = $dateHoySimple;
                        $fields["fechadesdejornadacarrera"] = $dateHoySimple;
                        $fields["fechahastajornadacarrera"] = '2999-01-01';
                        $jornada = $utils->processData("save","jornadacarrera","idjornadacarrera",$fields,false);
						
						if($jornada!=0){
							$sql = "SELECT * FROM jornadacarrera WHERE codigocarrera='".$cursoEC["codigocarrera"]."'";
							$jornada = $db->GetRow($sql);
						} else {
							$error++;
							$mensajesError[] = "Ocurrio un error al registrar la jornada para el programa ".$fila." para este periodo.";
						}
					}
				} //if error en curso
				
				if($error==0){
					$sql = "SELECT * FROM materia WHERE codigocarrera='".$cursoEC["codigocarrera"]."'";
					$materia = $db->GetRow($sql);
					if(count($materia)==0){
						$fields = array();
                        $fields["nombrecortomateria"] = $nombreStr;
                        $fields["nombremateria"] = $nombreStr;
                        $fields["numerocreditos"] = $creditosInt;
                        $fields["codigoperiodo"] = $peridoSelectRow["codigoperiodo"];
                        $fields["codigomodalidadmateria"] = '01';
                        $fields["codigolineaacademica"] = '001';
                        $fields["codigocarrera"] = $cursoEC["codigocarrera"];
                        $fields["codigoindicadorgrupomateria"] = '200';
                        $fields["codigotipomateria"] = '1';
                        $fields["codigoestadomateria"] = '01';
                        $fields["ulasc"] = '0';
                        $fields["codigoindicadorcredito"] = '100';
                        $fields["codigoindicadoretiquetamateria"] = '100';
                        $fields["codigotipocalificacionmateria"] = '100';
                        $materia = $utils->processData("save","materia","codigomateria",$fields,false);
						
						if($materia!=0){
							$sql = "SELECT * FROM materia WHERE codigocarrera='".$cursoEC["codigocarrera"]."'";
							$materia = $db->GetRow($sql);
						} else {
							$error++;
							$mensajesError[] = "Ocurrio un error al registrar la materia para el programa ".$fila.".";
						}
					}
				} //error despues de jornadacarrera
				
				if($error==0){
					if($fechaInicioDateTime!="" && $fechaFinDateTime!="" && $fechaFinDateTime!=null
					&& $fechaInicioDateTime!=null){
						$inidate=strtotime($fechaInicioDateTime);
						$findate=strtotime($fechaFinDateTime);
						if($findate>=$inidate){
							$profesorPrincipal=lookForDocentePrincipal($profesoresArray,$db);
							$periodoSelectSql="select * from periodo where '$fechaInicioDateTime' between fechainicioperiodo and fechavencimientoperiodo;";
							//echo $periodoSelectSql."<br/>";
							$periodo = $db->GetRow($periodoSelectSql);
							$codigoperiodo = $periodo["codigoperiodo"];
							$fields = array();     
							$grupo = 0;
							$fields["nombregrupo"] = substr($cursoEC["nombrecarrera"], 0, 20).'-'.$codigoperiodo;
							   $fields["codigomateria"] = $materia["codigomateria"];
							   $fields["codigoperiodo"] = $codigoperiodo;
							   $fields["numerodocumento"] = $profesorPrincipal;
							   $fields["codigogrupo"] = date("z").date("y");
								$fields["maximogrupo"] = '10000';
								$fields["matriculadosgrupo"] = '0';
								$fields["codigoestadogrupo"] = '20';
								$fields["codigoindicadorhorario"] = '200';
								$fields["fechainiciogrupo"] = $fechaInicioDateTime;
								$fields["fechafinalgrupo"] = $fechaFinDateTime;
							  $sql = "SELECT idgrupo FROM grupo WHERE codigogrupo = '" .$fields["codigogrupo"]. "'";
							  $result = $db->GetRow($sql);
								if($result==null || count($result)==0){
									//el utlimo false es el debug
									$grupo = $utils->processData("save","grupo","idgrupo",$fields,false,false);  
								} else {
								   $i = 0;
								   while($grupo==0 && $i<15){
										   //puede ser que se jodio porque estan tratando de crear varias versiones en el mismo dia
										   $array = array("a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v","w","z","y");
										   $fields["codigogrupo"] = $array[rand ( 0 , count($array) )].$array[rand ( 0 , count($array) )].$array[rand ( 0 , count($array) )].date("y");
										   $sql = "SELECT idgrupo FROM grupo WHERE codigogrupo = '" .$fields["codigogrupo"]. "'";
										   $result = $db->GetRow($sql);
										   if($result==null || count($result)==0){
												$grupo = $utils->processData("save","grupo","idgrupo",$fields,false);
										   }
										   $i++;
									}
								}
								if($grupo==0){
									//no se creo el grupo
									$error++;
									$mensajesError[] = "Ocurrio un error al registrar el grupo para el programa ".$fila.".";
								}
						} else {
							$error++;
							$mensajesError[] = "Le fecha de inicio del curso debe ser menor o igual que la fecha de finalización en la fila ".$fila.".";
						}
					} else {
						$error++;
						$mensajesError[] = "No se definieron las fechas de inicio y/o finalización del curso ".$fila.".";
					}
				} //error despues de materia
				
				if($error==0){ //echo "pa los profesores <pre>";print_r($profesoresArray);echo "<br/>".$grupo;
					//asignar docentes
					 asignarDocentesGrupo($utils,$db,$profesoresArray,$grupo);
					
					//echo $valorMatricula."<br/>";
					//Valor matricula y fechas de inscripcion que maneja sala
					if($valorMatricula!="" && $valorMatricula!=null && $valorMatricula!=0){
						actualizarValorMatricula($utils,$db,$valorMatricula,$cursoEC["codigocarrera"]);
					}
                                
					//fecha pago matriculas
					if($fechaFinPagoMatricula!="" && $fechaFinPagoMatricula!=null){
						actualizarFechaPagoMatricula($utils,$db,$grupo,$fechaFinPagoMatricula); 
					}
					
					//empresas 
					$num = count($empresasArray);
					$sql = "UPDATE `relacionEmpresaCursoEducacionContinuada` SET `codigoestado`=200 WHERE `idgrupo`='$grupo'";
					$db->Execute($sql);
					for($i=0;$i<$num;$i++){
						$sql = "SELECT * FROM empresa WHERE nombreempresa LIKE '%".$empresasArray[$i]."%'";
						$empresa = $db->GetRow($sql);
						if(count($empresa)==0){
							//me toca crearla
							$fields = array();
							$fields["nombreempresa"] = $empresasArray[$i];
							$fields["codigoestado"] = "100";
							$fields["idcategoriaempresa"] = '12';
							$id = $utils->processData("save","empresa","idempresa",$fields,false);
						} else {
							$id = $empresa["idempresa"];
						}
						
						$sql = "SELECT * FROM relacionEmpresaCursoEducacionContinuada WHERE idgrupo='$grupo' AND idempresa='$id'";
            
						$fields = array();
						$fields["idgrupo"] = $grupo;
						$fields["idempresa"] = $id;
						$row = $db->GetRow($sql);
						 if($row!=null && count($row)>0){
								 $fields["idrelacionEmpresaCursoEducacionContinuada"] = $row["idrelacionEmpresaCursoEducacionContinuada"];
								 $utils->processData("update","relacionEmpresaCursoEducacionContinuada","idrelacionDocenteCursoEducacionContinuada",$fields,false);
						 } else {
							$utils->processData("save","relacionEmpresaCursoEducacionContinuada","idrelacionEmpresaCursoEducacionContinuada",$fields,false);
						}
					}
					
					if($fechaInicioInscripcion!="" && $fechaInicioInscripcion!=null 
					&& $fechaFinInscripcion!="" && $fechaFinInscripcion!=null ){	
						$inidate=strtotime($fechaInicioInscripcion);
						$findate=strtotime($fechaFinInscripcion);	
						if($findate>=$inidate){
							$carreragrupo= actualizarFechasInscripcionCurso($utils,$db,$cursoEC["codigocarrera"],
							$fechaInicioInscripcion,$fechaFinInscripcion,$peridoSelectRow,$idUsuario);  
						} else{
							$error++;
							$mensajesError[] = "La fecha de inicio de inscripciones para el curso debe ser mayor o igual a la fecha de finalización en la fila ".$fila.".";
						}
					}
					
					$sql = "SELECT * FROM tipoEducacionContinuada WHERE nombre LIKE '%".$tipoStr."%' ";
					$tipo = $db->GetRow($sql);
					if(count($tipo)>0){
						$sql = "SELECT * FROM detalleGrupoCursoEducacionContinuada WHERE idgrupo='".$grupo."' ";
						$row = $db->GetRow($sql);
						
						$fields = array();
						$fields["idgrupo"] = $grupo;
						$fields["ciudad"] = $ciudad;
						$fields["tipo"] = $tipo["idtipoEducacionContinuada"];
						if(count($row)>0){
							$result = $row["iddetalleGrupoCursoEducacionContinuada"];
							$fields["iddetalleGrupoCursoEducacionContinuada"] = $result;
							$utils->processData("update","detalleGrupoCursoEducacionContinuada","iddetalleGrupoCursoEducacionContinuada",$fields,false);
						} else {
							$result = $utils->processData("save","detalleGrupoCursoEducacionContinuada","iddetalleGrupoCursoEducacionContinuada",$fields,false);
						}
					}
					
				} //error despues del grupo
				
				if($error!=0){
					$errores++; 
				} //if error, final
			} else {
				$errores++;
			} //if error
		} else {
			//ya nos jodimos
			$errores++;
			$mensajesError[] = "No se encontro la categoria especificada para el curso ".$fila.".";
		} //if categoria
	} else if($filaReal) { //if datos en null    
        $errores = $errores + 1;
	 $mensajesError[] = "La fila ".$fila." no contiene todos los campos obligatorios.";
    } 
 $fila++;

}

if($errores==0){
	$respuesta= "exito:Los cursos fueron registrados exitosamente";
} else {
	$respuesta= "fail:Ocurrió un error al registrar ".$errores." curso(s).";
	foreach($mensajesError as $error){
		$respuesta.= "<br/>".$error;
	}
}
//echo "<pre>";print_r($mensajesError);
//echo "<br/>".$respuesta;
?>

<script language="javascript" type="text/javascript">
    window.location.href="registrarCursos.php?mensaje=<?php echo $respuesta;?>";
</script>
