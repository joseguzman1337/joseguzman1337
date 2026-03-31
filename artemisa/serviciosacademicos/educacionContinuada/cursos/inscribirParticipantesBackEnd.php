<?php
// Test CVS
//ini_set('display_errors', 'On');
//error_reporting(E_ALL);
session_start;
/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
include realpath(dirname(__FILE__)).'/../Excel/reader.php';
include_once(realpath(dirname(__FILE__))."/../variables.php");
include($rutaTemplate."template.php");
include("functionsParticipantes.php");
?>
<img src="../images/ajax-loader2.gif" style="display:block;clear:both;margin:20px auto;" id="loading"/>
<?php
$db = getBD();

$carrera=$_POST['codigocarrera'];
$idgrupo = $_POST['idgrupo'];
$esAbierto = $_POST['tipocurso'];
//print_r($_POST);
$utils = Utils::getInstance();
$user=$utils->getUser();
$login=$user["idusuario"];
$matriculados = 0;

// ExcelFile($filename, $encoding);
$data = new Spreadsheet_Excel_Reader();
$respuesta="";

// Set output Encoding.
$data->setOutputEncoding('UTF-8');
$data->read($_FILES["file"]["tmp_name"]);
$filas = $data->sheets[0]['numRows'];
$mensajesError = array();
$fila = 2;
$dateHoy=date('Y-m-d H:i:s');
$date=date('Y-m-d');

$periodoSelectSql="select codigoperiodo from grupo where idgrupo='$idgrupo'";
$peridoSelectRow = $db->GetRow($periodoSelectSql);
$idPeriodo=$peridoSelectRow['codigoperiodo'];

//$sacarGrupoSql="select g.idgrupo from grupo g inner join materia m on (g.codigomateria=m.codigomateria) where g.fechafinalgrupo>'$date' and m.codigocarrera='$carrera' ORDER BY g.fechainiciogrupo DESC;";
//$sacarGrupoSqlRow = $db->GetRow($sacarGrupoSql);

//if($sacarGrupoSqlRow!=NULL && count($sacarGrupoSqlRow)>0){
   // $idgrupo=$sacarGrupoSqlRow['idgrupo'];
    //echo $data->sheets[0]['numRows'];
	$failInsertados=0;	
        for ($z = 2; $z <= $filas; $z++) {
            $rollback="";
            $deboInsertarRelacion=false;
			$filaReal = false;
			$error = 0;
            $participante=array();
            for ($j = 1; $j <= 16; $j++) {
                //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
                $participante[$j]=$data->sheets[0]['cells'][$z][$j];
				if($participante[$j]!=""){
					$filaReal = true;
				}
            }
            $nombres=utf8_encode($participante[1]);
            $apellidos=utf8_encode($participante[2]);

            $fecha=$participante[3];
            $profesion=utf8_encode($participante[4]);
            $especialidad=utf8_encode($participante[5]);
            $paisOrigen=utf8_encode($participante[6]);
            $ciudadOrigen=utf8_encode($participante[7]);
            $tipoDocumento=$participante[8];
            $numeroDocumento=$participante[9];
            $genero=0;
            if(strcmp($participante[10],'Femenino')==0){
                $genero=100;
            }
            else{
                $genero=200;
            }

            $correo=$participante[11];
            $correoAlterno=$participante[12];
            $telefono=$participante[13];
            $celular=$participante[14];
            $empresasArray=explode(';', utf8_encode($participante[15]));
            $numFactura=$participante[16];
			$result=true;
		
			//echo $carrera."-".$grupo."-".$idPeriodo." - ".$esAbierto."<br/>";
			//echo "<pre>";print_r($participante); 
            if($nombres!=null || $apellidos!=null || $fecha!=null || $profesion!=null || $tipoDocumento!=null 
            || $numeroDocumento!=null || $correo!=null || $correoAlterno!=null || $telefono!=null || $celular!=null){
			
				$idEstudianteGeneral=-1;
                $idCiudad=-1;
                $idTitulo=-1;
                $idEstudiante=-1;

                $idInscripcion=-1;
                $idTipoDocumento=-1;
				
				/*if($esAbierto=="true" || $esAbierto==true)
				{	
					//es abierto tiene que tener las empresas patrocinadoras sino pailas porque no lo puede registrar por acá, que se registre el estudiante
					if($participante[15]==null || $participante[15]==""){
						$failInsertados++;
						$mensajesError[] = "El curso es abierto y por tanto debe indicar las empresas patrocinadoras correspondientes al estudiante en la fila ".$fila.".";
					}
				}*/
				
				if($error===0){
					$estudiantegeneralSelectRow = getEstudianteGeneral($db,$numeroDocumento);
					//var_dump($estudiantegeneralSelectRow);
					if($estudiantegeneralSelectRow!=NULL && count($estudiantegeneralSelectRow)>0){
						$idEstudianteGeneral=$estudiantegeneralSelectRow['idestudiantegeneral'];
						
						$cond = "";
						if($telefono!=null && $telefono!=""){
							$cond = "telefonorecidenciaestudiantegeneral='$telefono'";
						}
						if($celular!=null && $celular!=""){
							if($cond!==""){
								$cond .= ",";
							}
							$cond .= " celularestudiantegeneral='$celular'";
						}
						if($correo!=null && $correo!=""){
							if($cond!==""){
								$cond .= ",";
							}
							$cond .= " emailestudiantegeneral='$correo'";
						}
						if($correoAlterno!=null && $correoAlterno!=""){
							if($cond!==""){
								$cond .= ",";
							}
							$cond .= " email2estudiantegeneral='$correoAlterno'";
						}
						if($ciudadOrigen!=null && $ciudadOrigen!=""){
							if($cond!==""){
								$cond .= ",";
							}
							$idCiudad  = getCiudad($db,$ciudadStr);
							$cond .= " ciudadresidenciaestudiantegeneral='$idCiudad'";
						}
						
						if($cond!==""){
							$estudiantegeneralUpdateSql="update estudiantegeneral set  
								fechaactualizaciondatosestudiantegeneral='$dateHoy',
								update_at = '" . date("Y-m-d G:i:s", time()) . "'
								, $cond
								where idestudiantegeneral='$idEstudianteGeneral';";
							$result=$db->Execute($estudiantegeneralUpdateSql);
						}
					} else {
						//toca insertarlo
						$idCiudad  = getCiudad($db,$ciudadStr);
						$documentoSelectSql="select * from documento where nombrecortodocumento='$tipoDocumento';";
						$documentoSelectRow = $db->GetRow($documentoSelectSql);
						if($documentoSelectRow!=NULL && count($documentoSelectRow)>0){
							$idTipoDocumento=$documentoSelectRow['tipodocumento'];
							
							$estudiantegeneralInsertSql="INSERT into `estudiantegeneral` (`idtrato`, `idestadocivil`, 
									`tipodocumento`, `numerodocumento`, `expedidodocumento`, 
									`nombrecortoestudiantegeneral`, `nombresestudiantegeneral`, 
									`apellidosestudiantegeneral`, `fechanacimientoestudiantegeneral`, 
									`idciudadnacimiento`, `codigogenero`, `telefonoresidenciaestudiantegeneral`, 
									`celularestudiantegeneral`, `emailestudiantegeneral`, `email2estudiantegeneral`, 
									`fechacreacionestudiantegeneral`, `fechaactualizaciondatosestudiantegeneral`, 
									`codigotipocliente`, `casoemergenciallamarestudiantegeneral`, 
									`telefono1casoemergenciallamarestudiantegeneral`, 
									`telefono2casoemergenciallamarestudiantegeneral`, `idtipoestudiantefamilia`, 
									`ciudadresidenciaestudiantegeneral`) VALUES ('1', '1', '$idTipoDocumento', 
									'$numeroDocumento', '', '$numeroDocumento', '$nombres', '$apellidos', '$fecha', 
									'$idCiudad', '$genero', '$telefono', '$celular', '$correo', '$correoAlterno', 
									'$dateHoy', '$dateHoy', '0', '', '','','0', '$idCiudad');";

							$result=$db->Execute($estudiantegeneralInsertSql);
							
							$estudiantegeneralSelectRow = getEstudianteGeneral($db,$numeroDocumento);

							if($estudiantegeneralSelectRow!=NULL && count($estudiantegeneralSelectRow)>0){
								$idEstudianteGeneral=$estudiantegeneralSelectRow['idestudiantegeneral'];
							}
						} 
					}
					//echo "sali de estudiante general"; 
					if($idEstudianteGeneral!=-1){
						//relacion estudiante carrera
						$estudianteSelectSql="select * from estudiante where idestudiantegeneral='$idEstudianteGeneral' 
						AND codigocarrera='$carrera';";
						$estudianteSelectRow = $db->GetRow($estudianteSelectSql);
						//print_r($estudianteSelectRow);
						if($estudianteSelectRow!=NULL && count($estudianteSelectRow)>0){
							$idEstudiante=$estudianteSelectRow['codigoestudiante'];
						} else {
							$estudianteInsertSql="INSERT into `estudiante` (`idestudiantegeneral`, `codigocarrera`, `numerocohorte`, 
							`codigotipoestudiante`, `codigosituacioncarreraestudiante`, `codigoperiodo`, `codigojornada`) 
							VALUES ('$idEstudianteGeneral', '$carrera', '1', '10', '107', '$idPeriodo', '01');";
							$result=$db->Execute($estudianteInsertSql);
							
							$estudianteSelectRow = $db->GetRow($estudianteSelectSql);
							if($estudianteSelectRow!=NULL && count($estudianteSelectRow)>0){
								$idEstudiante=$estudianteSelectRow['codigoestudiante'];
							} else {
								//ya nos jodimos
								$failInsertados++;
								$error++;
								//$rollback+="delete from estudiantegeneral where idestudiantegeneral='".$idEstudianteGeneral."';";
								$mensajesError[] = "Ocurrio un error al tratar de inscribir el estudiante ".$fila." en el programa.";
							}
						}
					} else {
						//ya nos jodimos
						$failInsertados++;
						$error++;
						$mensajesError[] = "Ocurrio un error al registrar el estudiante ".$fila.".";
					}
				} //por el curso abierto
				//echo "estudiante ".$idEstudianteGeneral." - ".$idEstudiante; echo "<br/>".$error."<br/>";
				if($error===0){
					//echo "hola titulos ".$profesion."<br/>";
					//titulos estudiantes
					if(strcmp($profesion,'')!=0){
						//verificamos si el estudiante ya tiene estudios registrados
						$estudiantestudioSelectSql="select idestudianteestudio from estudianteestudio where 
								idestudiantegeneral='$idEstudianteGeneral'";
                        $estudiantestudioSelectRow = $db->GetRow($estudiantestudioSelectSql);
						//print_r($estudiantestudioSelectRow); echo "<br/>";
                        if(!($estudiantestudioSelectRow!=NULL && count($estudiantestudioSelectRow)>0)){
									
											$tituloSelectSql="select * from titulo where nombretitulo='$profesion' OR nombretitulo 
											LIKE '%".$profesion."%'
											ORDER BY CASE 
												when nombretitulo='".$profesion."' then 1 
												when nombretitulo LIKE '%".$profesion."%' then 2 
												else 3 
											END";
											$tituloSelectRow = $db->GetRow($tituloSelectSql);
							
											if(!($tituloSelectRow!=NULL && count($tituloSelectRow)>0)){
												$tituloInsertSql="INSERT into `titulo` (`nombretitulo`, `registrotitulo`) 
												VALUES ('$profesion', '1');";
												$result=$db->Execute($tituloInsertSql);
												if($result){
													$rollback+="delete from titulo where codigotitulo='".$db->Insert_ID()."';";
												}
												$tituloSelectRow = $db->GetRow($tituloSelectSql);
											}
											
											$idTitulo=$tituloSelectRow['codigotitulo'];
											if($idTitulo!=null){
													$estudianteestudioInsertSql="INSERT into `estudianteestudio` (`idestudiantegeneral`, `idniveleducacion`, 
													`idinstitucioneducativa`, `otrainstitucioneducativaestudianteestudio`,`otrotituloestudianteestudio`, 
													`codigotitulo`, `codigoestado`, `ciudadinstitucioneducativa`, `colegiopertenececundinamarca`) 
													VALUES ('$idEstudianteGeneral', '6','1', '','$especialidad', '$idTitulo','100','','');";
													$reuslt=$db->Execute($estudianteestudioInsertSql);
													
													if($result){
														$rollback+="delete from estudianteestudio where idestudianteestudio='".$db->Insert_ID()."';";
													} else {
														$failInsertados++;
														$error++;
														$mensajesError[] = "Ocurrio un error al registrar la profesión y/o especialidad del estudiante ".$fila.".";
													}	
											}
							}
                        }
				} else {
					//$db->Execute($rollback);
				} // if titulos
				
				//echo "titulos "; print_r($mensajesError); echo "<br/>".$error."<br/>"; 
				if($error===0){ //por la profesion y especialidad
					$inscripcionSelectSql="select * from inscripcion where codigoperiodo='$idPeriodo' and 
					idestudiantegeneral='$idEstudianteGeneral';";
                    $inscripcionSelectRow = $db->GetRow($inscripcionSelectSql);
					//print_r($inscripcionSelectRow); echo "<br/>";
                    if($inscripcionSelectRow!=NULL && count($inscripcionSelectRow)>0){
                        $idInscripcion=$inscripcionSelectRow['idinscripcion']; 
					} else {
                                $inscripcionInsertSql="INSERT into `inscripcion` (`fechainscripcion`, 
								`codigomodalidadacademica`, `codigoperiodo`, `idestudiantegeneral`, 
								`codigosituacioncarreraestudiante`, `codigoestado`) VALUES 
								('$dateHoy','400','$idPeriodo','$idEstudianteGeneral','107','100');";
                                $result=$db->Execute($inscripcionInsertSql);
								$inscripcionSelectRow = $db->GetRow($inscripcionSelectSql);
								$idInscripcion=$inscripcionSelectRow['idinscripcion']; 
								//echo "<pre>"; print_r($result); echo "<br/>".$inscripcionInsertSql."<br/>";
                                if($idInscripcion==null || $idInscripcion===-1){
									$failInsertados++;
									$error++;
									$mensajesError[] = "Ocurrio un error al realizar la inscripción del estudiante ".$fila.".";
                                }

                    }
				} //if inscripcion
				//echo "inscripcion "; print_r($mensajesError); echo "<br/>".$error."<br/>";
				if($error===0){ //por la inscripcion
					$estudiantecarrerainscripcionSelectSql="select * from estudiantecarrerainscripcion where idinscripcion='$idInscripcion' 
					and codigocarrera='$carrera';";
                    $estudiantecarrerainscripcionSelectRow = $db->GetRow($estudiantecarrerainscripcionSelectSql);
					//echo "inscripcion "; print_r($estudiantecarrerainscripcionSelectRow); echo "<br/>".$error."<br/>";
                    if(!($estudiantecarrerainscripcionSelectRow!=NULL && count($estudiantecarrerainscripcionSelectRow)>0)){
                        $estudiantecarrerainscripcionInsertSql="INSERT into estudiantecarrerainscripcion 
						(`codigocarrera`, `idinscripcion`, `idnumeroopcion`, `idestudiantegeneral`, `codigoestado`) 
						VALUES ('$carrera', '$idInscripcion', '1', '$idEstudianteGeneral', '100');";
                        $result=$db->Execute($estudiantecarrerainscripcionInsertSql);

                                    if($result){
                                        $rollback+="delete from estudiantecarrerainscripcion where idestudiantecarrerainscripcion='".$db->Insert_ID()."';";
                                        
                                    }

                    }
				}
				
				if($error===0){ //por carrerainscripcion
					$idpais=0;
                    $paisSelectSql="select idpais from pais where nombrepais like '%$paisOrigen%' or 
					nombrecortopais like '%$paisOrigen%';";
                    $paisSelectRow = $db->GetRow($paisSelectSql);
                    if(!($paisSelectRow!=NULL && count($paisSelectRow)>0)){
                        $paisInsertSql="INSERT into pais (`nombrepais`, `nombrecortopais`, `codigoestado`) 
						VALUES ('$paisOrigen', '$paisOrigen', '100');";
                        $result=$db->Execute($paisInsertSql);
                        $paisSelectRow = $db->GetRow($paisSelectSql);
                    }
					$idpais=$paisSelectRow['idpais'];
					//echo "pais "; print_r($idpais); echo "<br/>".$error."<br/>";
					if($idpais==null){
						$failInsertados++;
						$error++;
						$mensajesError[] = "Ocurrio un error al registrar el país de residencia del estudiante ".$fila.".";
                    }
				}
				//echo "carrerainscripcion<br/>";
				if($error===0){ //por pais de residencia 
					$sql = "SELECT idrelacionEstudianteGrupoInscripcion FROM relacionEstudianteGrupoInscripcion 
					WHERE idEstudianteGeneral='".$idEstudianteGeneral."' and idGrupo='".$idgrupo."'";
					$relacion = $db->GetRow($sql);
					//echo "relacion "; print_r($relacion); echo "<br/>".$error."<br/>";
					if(!($relacion!=NULL && count($relacion)>0)){
						if($numFactura===""){
							$relacionEstudianteGrupoInscripcionInsertSql="INSERT into `relacionEstudianteGrupoInscripcion` 
						(`idEstudianteGeneral`, `idInscripcion`, `idGrupo`, `fecha_creacion`, `usuario_creacion`, 
						`codigoestado`, `idPaisResidenciaEstudiante`) VALUES 
						('$idEstudianteGeneral', '$idInscripcion', '$idgrupo', '$dateHoy', '$login', '100', '$idpais');";
						} else {
							$relacionEstudianteGrupoInscripcionInsertSql="INSERT into `relacionEstudianteGrupoInscripcion` 
						(`idEstudianteGeneral`, `idInscripcion`, `idGrupo`, `fecha_creacion`, `usuario_creacion`, 
						`codigoestado`, `idPaisResidenciaEstudiante`, `numeroFactura`) VALUES 
						('$idEstudianteGeneral', '$idInscripcion', '$idgrupo', '$dateHoy', '$login', '100', '$idpais', '$numFactura');";
						}
						$result=$db->Execute($relacionEstudianteGrupoInscripcionInsertSql);
						if($result){
							$rollback+="delete from relacionEstudianteGrupoInscripcion where 
							idrelacionEstudianteGrupoInscripcion='".$db->Insert_ID()."';";
						} else {
							$failInsertados++;
							$error++;
							$mensajesError[] = "Ocurrio un error al registrar el estudiante ".$fila." en el grupo.";
						}
					}
				}
				//echo "<br/> pais de residencia ".$error."<br/>";
				if($error){ //por relacionEstudianteGrupo
					if($esAbierto=="true" || $esAbierto==true){
                            //el curso es abierto, procesar lo de empresas
						foreach($empresasArray as $empresa){
							$empresaSelectSql="select * from empresa where nombreempresa='$nombreEmpresa';";
                            $empresaSelectRow = $db->GetRow($empresaSelectSql);
                            $idEmpresa=$empresaSelectRow['idempresa'];
							if($idEmpresa==NULL || strcmp($idEmpresa,'null')==0 ){
                                $empresaInsertSql="INSERT into `empresa` (`nombreempresa`, `idcategoriaempresa`, 
								`codigoestado`) VALUES ('$nombreEmpresa', '12', '100');";
                                $result=$db->Execute($empresaInsertSql);

                                $empresaSelectSql="select * from empresa where nombreempresa='$nombreEmpresa';";
                                $empresaSelectRow = $db->GetRow($empresaSelectSql);
                                $idEmpresa=$empresaSelectRow['idempresa'];

                            }
							
							$sql="select * from relacionEmpresaCursoAbiertoEducacionContinuada 
							where idEmpresa='$idEmpresa' AND idCarrera='$carrera' AND 
							idEstudianteGeneral='$idEstudianteGeneral';";
                            $row = $db->GetRow($sql);
                            if($row==null || count($row)==0){
								$relacionEmpresaInsertSql="INSERT into `relacionEmpresaCursoAbiertoEducacionContinuada` 
								(`idEmpresa`, `idCarrera`, `idEstudianteGeneral`, `fecha_creacion`, `usuario_creacion`, 
								`codigoestado`, `fecha_modificacion`, `usuario_modificacion`) VALUES ('$idEmpresa', '$carrera', 
								'$idEstudianteGeneral', '$dateHoy', '$login', '100', '$dateHoy', '$login');";
                                $result=$db->Execute($relacionEmpresaInsertSql);
							}
						}

                    }
                    
				}
				
				//echo "voy pa prematriculas ".$error." - ".$esAbierto;
				if($error===0){ //matricularlos si son de cursos cerrados
					$sql="select dp.idprematricula from prematricula pm 
							INNER JOIN detalleprematricula dp on dp.idprematricula=pm.idprematricula and dp.codigoestadodetalleprematricula=30 
							where codigoestudiante='$idEstudiante' and dp.idgrupo='$idgrupo'";
                            $row = $db->GetRow($sql);
					//echo "<br/>".$sql."<br/>"; var_dump($row);echo "<br/>";var_dump(($esAbierto=="false" || $esAbierto==false) && count($row)===0);
					if(($esAbierto=="false" || $esAbierto==false) && count($row)===0){
						$sql="INSERT INTO `prematricula` (`fechaprematricula`, `codigoestudiante`, `codigoperiodo`, `codigoestadoprematricula`, `semestreprematricula`) 
						VALUES ('$dateHoy', '$idEstudiante', '$idPeriodo', '40', '1')";
						//echo "<br/>".$sql."<br/>";
						$result=$db->Execute($sql);
						if($result){
							$idprematricula = $db->Insert_ID();
							$rollback+="delete from prematricula where 
							idprematricula='".$idprematricula."';";
							
							$sql="select codigomateria from materia 
									where codigocarrera='$carrera'";
								$row = $db->GetRow($sql);
								$materia = $row["codigomateria"];
								
							$sql="INSERT INTO `detalleprematricula` (`idprematricula`, `codigomateria`, `codigomateriaelectiva`, `codigoestadodetalleprematricula`, 
								`codigotipodetalleprematricula`, `idgrupo`, `numeroordenpago`) VALUES ('$idprematricula', '$materia', '0', '30', '20', '$idgrupo', '1')";
								
							$result=$db->Execute($sql);
							if($result){
								
								$sql="UPDATE `estudiante` SET `codigosituacioncarreraestudiante`='300' WHERE (`codigoestudiante`='$idEstudiante')";
								$result=$db->Execute($sql);
								$matriculados++;
							} else {
								$failInsertados++;
								$error++;
								$mensajesError[] = "Ocurrio un error al matricular el estudiante ".$fila." en el grupo.";
							}
						} else {
							$failInsertados++;
							$error++;
							$mensajesError[] = "Ocurrio un error al matricular el estudiante ".$fila.".";
						}
					}
				}
				//echo "<br/> relacion estudiante grupo ".$error."<br/>";	
			} else if($filaReal) { //if datos en null en la fila? 
				$failInsertados++;
				$mensajesError[] = "La fila ".$fila." no contiene todos los campos obligatorios.";
			}
			$fila++;
        } //for de las filas del excel
		
		if($matriculados>0){
			$sql="UPDATE `grupo` SET `matriculadosgrupo`=matriculadosgrupo+".$matriculados." WHERE (`idgrupo`='$idgrupo')";
			$result=$db->Execute($sql);
		}
		//echo "<br/><br/>mat ".$matriculados;die;
        if($failInsertados>0){
            $respuesta= "fail:Ocurrió un error al inscribir ".$failInsertados." participante(s).";
			foreach($mensajesError as $error){
				$respuesta.= "<br/>".$error;
			}
        }
        else{
            $respuesta= "exito:Los participantes fueron registrados exitosamente";
        }
 
    
/*}
else{
    $respuesta="fail:El curso no tiene fechas de inscripcion activas";
}*/

?>

<script language="javascript" type="text/javascript">
    window.location.href="inscribirParticipantes.php?id=row_<?php echo $carrera;?>&mensaje=<?php echo $respuesta;?>";
</script>
