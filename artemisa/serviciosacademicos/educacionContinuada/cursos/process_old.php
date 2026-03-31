<?php

/*
 * Se encarga del procesamiento de datos
 */
// this starts the session 
 session_start(); 

include_once("../variables.php");
include($rutaTemplate."template.php");
include_once("./functionsRegistroCarrerasYGrupos.php");
$db = getBD();

$utils = Utils::getInstance();
//$api = new API_Monitoreo();



$action = $_REQUEST["action"];
$message = null;
if((strcmp($action,"inactivate")==0)){
        $now = date('Y-m-d H-i-s');
		
        $sql = "UPDATE carrera SET fechavencimientocarrera = '" .$now. "' WHERE codigocarrera = '" .$_REQUEST["id"]. "'";
        $result = $db->Execute($sql);
   
		$data = array('success'=> true,'message'=> "El curso se ha descontinuado correctamente.");
} else if((strcmp($action,"inactivateEntity")==0)){
    $fields["id".$_REQUEST["entity"]] = $_REQUEST["id"];
    $result = $utils->processData("inactivate",$_REQUEST["entity"],"id".$_REQUEST["entity"],$fields,false);
    $data = array('success'=> true,'message'=>'Se ha eliminado el pago de forma correcta.','id'=>$_REQUEST["id"]);
} else if((strcmp($action,"saveValoresPecunarios")==0)){
	$periodo = $utils->getPeriodoActual($db);
	$codigocarrera = $_REQUEST["codigocarrera"];
	$sql = "SELECT idfacturavalorpecuniario as id FROM facturavalorpecuniario WHERE codigoperiodo='".$periodo["codigoperiodo"]."' 
			AND codigocarrera = '".$codigocarrera."'";
	$result = $db->GetRow($sql);
	if(count($result)>0){
		//ya existe entonces se inactivan los anteriores valores
		$sql="UPDATE `detallefacturavalorpecuniario` SET `codigoestado`=200 WHERE `idfacturavalorpecuniario`='".$result["id"]."';";
		$db->Execute($sql);
	} else {
		//toca crearlo
		$fields["nombrefacturavalorpecuniario"] = "FACTURA ".$periodo["codigoperiodo"];
		$fields["fechafacturavalorpecuniario"] =  date("Y-m-d H:i:s"); 
		$fields["codigoperiodo"] = $periodo["codigoperiodo"];
		$fields["codigocarrera"] = $codigocarrera;
		$utils->processData("save","facturavalorpecuniario","idfacturavalorpecuniario",$fields,false);
		$result = $db->GetRow($sql);
	}
	
	$arreglo = $_REQUEST["aplica"];
	foreach($arreglo as $valor) {
		$fields = array();
		$valores = explode(";", $valor);
		$sql = "SELECT iddetallefacturavalorpecuniario as id FROM detallefacturavalorpecuniario 
			WHERE idfacturavalorpecuniario='".$result["id"]."'  
			AND idvalorpecuniario = '".$valores[0]."' AND codigotipoestudiante = '".$valores[1]."'";
		$row = $db->GetRow($sql);
		$fields["idfacturavalorpecuniario"] = $result["id"];
		$fields["idvalorpecuniario"] = $valores[0];
		$fields["codigotipoestudiante"] = $valores[1];
		$fields["codigoestado"] = 100;
		if(count($row)>0){
			//existe solo activarlo
			$fields["iddetallefacturavalorpecuniario"] = $row["id"];
			$utils->processData("update","detallefacturavalorpecuniario","iddetallefacturavalorpecuniario",$fields,false);
		} else {
			$utils->processData("save","detallefacturavalorpecuniario","iddetallefacturavalorpecuniario",$fields,false);
		}
		
	}
	
	$data = array('success'=> false,'message'=>'Se han guardado los valores de forma correcta.');
	
} else if((strcmp($action,"savePagoPatrocinado")==0)){
    if($_REQUEST["idEmpresa"]==null || $_REQUEST["idEmpresa"]==="null" ){
         //me toca crear la empresa
         $fields = array();
         $fields["nombreempresa"] = $_REQUEST["tmp_empresa"];
         $fields["codigoestado"] = "100";
         $fields["idcategoriaempresa"] = '12';
         $_POST["idEmpresa"] = $utils->processData("save","empresa","idempresa",$fields,false);
    } else {
        $_POST["idEmpresa"] = $_REQUEST["idEmpresa"];
    }
    
    $result = $utils->processData("save",$_REQUEST["entity"],"id".$_REQUEST["entity"]);
    if($result==0){
        $result = -1;
        $data = array('success'=> false,'message'=>'Ha ocurrido un error al registrar el pago.');
    } else {
        $datos = $utils->getDataEntity($_REQUEST["entity"], $result, "id".$_REQUEST["entity"]); 
        $empresa = $utils->getDataEntity("empresa", $datos["idEmpresa"], "idempresa"); 
        $data = array('success'=> true,'message'=>'Se ha registrado el pago de forma correcta.','data'=>$datos,'dataEmpresa'=>$empresa);
    }
} else if((strcmp($_REQUEST["entity"],"carrera")==0)){
		
		//verificar si la ciudad hay que agregarla o que... Solo cuando es presencial
		if($_REQUEST["categoria"]!=2){
			$_POST["ciudad"]=gestionarCiudadCurso($utils);
		} else {
			$_POST["ciudad"]=null;
		}

		//puede ser una nueva carrera
		if((strcmp($action,"save")==0)){
			//crear la carrera
                        $fields = array();
                        $dateHoy=date('Y-m-d H:i:s');
                        $peridoSelectRow = $utils->getPeriodoActual($db);                        
                        
                        $dateHoySimple=date('Y-m-d');
                        /*$fields["codigocortocarrera"] = microtime(true);
                        $fields["nombrecortocarrera"] = $_REQUEST["nombre"];
                        $fields["nombrecarrera"] = $_REQUEST["nombre"];
			$fields["codigofacultad"] = $_REQUEST["codigofacultad"];
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
						$result = crearCarrera($utils,$db,$_REQUEST["nombre"],$_REQUEST["codigofacultad"]);
                        
                        if($result!=0){
                            $_POST["codigocarrera"] = $result;
                            $resultCarrera = $result;
                            
                            if($_REQUEST["tipoCertificacion"]==3){
				$creditos = $_REQUEST["numerocreditos"];
                            } else {
                                $creditos = 0;
                            }
                        
                            //jornada carrera
                            $fields = array();
                            $fields["nombrejornadacarrera"] = $_REQUEST["nombre"];
                            $fields["codigocarrera"] = $result;
                            $fields["codigojornada"] = '01';
                            $fields["numerominimocreditosjornadacarrera"] = $creditos;
                            $fields["numeromaximocreditosjornadacarrera"] = $creditos;
                            $fields["fechajornadacarrera"] = $dateHoySimple;
                            $fields["fechadesdejornadacarrera"] = $dateHoySimple;
                            $fields["fechahastajornadacarrera"] = '2999-01-01';
                            $jornada = $utils->processData("save","jornadacarrera","idjornadacarrera",$fields,false);
               
                            $fields = array();
                            $fields["nombrecortomateria"] = $_REQUEST["nombre"];
                            $fields["nombremateria"] = $_REQUEST["nombre"];
                            $fields["numerocreditos"] = $creditos;
                            $fields["codigoperiodo"] = $peridoSelectRow["codigoperiodo"];
                            $fields["codigomodalidadmateria"] = '01';
                            $fields["codigolineaacademica"] = '001';
                            $fields["codigocarrera"] = $result;
                            $fields["codigoindicadorgrupomateria"] = '200';
                            $fields["codigotipomateria"] = '1';
                            $fields["codigoestadomateria"] = '01';
                            $fields["ulasc"] = '0';
                            $fields["codigoindicadorcredito"] = '100';
                            $fields["codigoindicadoretiquetamateria"] = '100';
                            $fields["codigotipocalificacionmateria"] = '100';
                            $materia = $utils->processData("save","materia","codigomateria",$fields,false);
                                                      
                            $data2 = $utils->getUser();
                            $idUsuario=$data2['idusuario']; 
                            
                            $profesores = $_REQUEST['idprofesor'];
                            $profesorPrincipal=lookForDocentePrincipal($profesores,$db);
                            $grupo = crearVersionGrupo($utils,$peridoSelectRow["codigoperiodo"],$materia,$profesorPrincipal,$db);
                
                            if($grupo!=0){                                
                                asignarDocentesGrupo($utils,$db,$profesores,$grupo);
                                
								//si es un curso abierto
								if($_REQUEST['tipo']!=2){
									//Valor matricula y fechas de inscripcion que maneja sala
									actualizarValorMatricula($utils,$db,$_REQUEST["valorMatricula"],$result);
                                
									//fecha pago matriculas
									actualizarFechaPagoMatricula($utils,$db,$grupo,$_REQUEST["fechaFinalMatriculas"]); 
								
                               $carreragrupo= actualizarFechasInscripcionCurso($utils,$db,$result,$_REQUEST["fechaInicioInscripcion"],
                                    $_REQUEST["fechaFinalInscripcion"],$peridoSelectRow,$idUsuario);                                 
                                }
								
								$detalle = getDetalleGrupo($utils,$db,$_POST["ciudad"],$grupo);
                                
                            } else {
                                $message = 'Ha ocurrido un problema al tratar de crear el grupo/nueva versión del curso.';
                                  //no pudo crear el grupo ... fuck!
                                  $data = array('success'=> false,'message'=>$message);
                                  echo json_encode($data);
                                  die;
                            }
                            
                            //empresas si el curso es cerrado
                            asignarEmpresasGrupo($utils,$db,$grupo);
                            
                            //detalleCurso            
                            $result = $utils->processData("save","detalleCursoEducacionContinuada","iddetalleCursoEducacionContinuada");
                        }
			$data = array('success'=> true,'message'=>'Se ha registrado el curso de forma correcta.','id'=>$resultCarrera);
		} else {
			//ya esta creada la carrera es solo el detalle
			$action2 = "save";
			if(isset($_REQUEST["iddetalleCursoEducacionContinuada"])){
				$action2 = "update";
			}
			//con créditos
			if($_REQUEST["tipoCertificacion"]==3){
				$fields = array();
				$fields["codigomateria"] = $_REQUEST["codigomateria"];
				$fields["numerocreditos"] = $_REQUEST["numerocreditos"];
				$utils->processData("update","materia","codigomateria",$fields,false);
			} 
			
			$fields = array();
			$fields["codigocarrera"] = $_REQUEST["codigocarrera"];
			$fields["nombrecarrera"] = $_REQUEST["nombre"];
			$fields["codigofacultad"] = $_REQUEST["codigofacultad"];
			$utils->processData("update","carrera","codigocarrera",$fields,false);
			
			$result = $utils->processData($action2,"detalleCursoEducacionContinuada","iddetalleCursoEducacionContinuada");
			
                        /*Valor matricula y fechas de inscripcion que maneja sala
                        actualizarValorMatricula($utils,$db,$_REQUEST["valorMatricula"],$fields["codigocarrera"]);                        
                        
                        $data2 = $utils->getUser();
                        $idUsuario=$data2['idusuario'];
                        $peridoSelectRow = $utils->getPeriodoActual($db);   
                        //fechas de inscripción
                        actualizarFechasInscripcionCurso($utils,$db,$fields["codigocarrera"],$_REQUEST["fechaInicioInscripcion"],
                                $_REQUEST["fechaFinalInscripcion"],$peridoSelectRow,$idUsuario); */                       
                        
			$data = array('success'=> true,'message'=>'Se han guardado los cambios de forma correcta.','id'=>$_REQUEST["codigocarrera"]);
		}
} else if((strcmp($action,"saveGroup")==0)){
                        //verificar si la ciudad hay que agregarla o que... Solo cuando es presencial                        
                        if($_REQUEST["categoria"]!=2){
                                $_POST["ciudad"]=gestionarCiudadCurso($utils);
                        } else {
                                $_POST["ciudad"]=null;
                        }
			
			if(!isset($_REQUEST["iddetalleCursoEducacionContinuada"])){
				$result = $utils->processData("save","detalleCursoEducacionContinuada","iddetalleCursoEducacionContinuada");
			} 
                        
                        $dateHoy=date('Y-m-d H:i:s');
                        $dateHoySimple=date('Y-m-d');
                        
                        $peridoSelectRow =  $utils->getPeriodoActual($db);   
                        $profesores = $_REQUEST['idprofesor'];
                        $profesorPrincipal = lookForDocentePrincipal($profesores,$db);
                            //crear la nueva version grupo
                        if(!isset($_REQUEST["idgrupo"])){
                            $grupo = crearVersionGrupo($utils,$peridoSelectRow["codigoperiodo"],$_REQUEST["codigomateria"],$profesorPrincipal,$db);
                        } else {
                            $grupo = $_REQUEST["idgrupo"];
                            actualizarGrupo($utils,$peridoSelectRow["codigoperiodo"],$_REQUEST["codigomateria"],$profesorPrincipal,$grupo);
                        }   

                            if($grupo!=0){                                
                                asignarDocentesGrupo($utils,$db,$profesores,$grupo);
                                
								//si es un curso abierto
								if($_REQUEST['tipo']!=2){
									//Valor matricula y fechas de inscripcion que maneja sala
									actualizarValorMatricula($utils,$db,$_REQUEST["valorMatricula"],$_REQUEST["codigocarrera"]);
                                
									//fecha pago matriculas
									actualizarFechaPagoMatricula($utils,$db,$grupo,$_REQUEST["fechaFinalMatriculas"]); 
								
								
                                    $data2 = $utils->getUser();
                                    $idUsuario=$data2['idusuario'];
                               $carreragrupo= actualizarFechasInscripcionCurso($utils,$db,$_REQUEST["codigocarrera"],$_REQUEST["fechaInicioInscripcion"],
                                    $_REQUEST["fechaFinalInscripcion"],$peridoSelectRow,$idUsuario);                                 
                                }
								
								$result = getDetalleGrupo($utils,$db,$_POST["ciudad"],$grupo);
                                
                                //empresas si el curso es cerrado
                                asignarEmpresasGrupo($utils,$db,$grupo);
                            } else {
                                $message = 'Ha ocurrido un problema al tratar de crear el grupo/nueva versión del curso.';
                                  //no pudo crear el grupo ... fuck!
                                  $data = array('success'=> false,'message'=>$message);
                                  echo json_encode($data);
                                  die;
                            }
			
			$data = array('success'=> true,'message'=>'Se han guardado los cambios de forma correcta.','id'=>$_REQUEST["codigocarrera"]);
}

    // Do lots of devilishly clever analysis and processing here...
    if($result == 0){ 
        // Set up associative array
        if($message===null){
            $data = array('success'=> false,'message'=>'Ha ocurrido un problema al tratar de crear el curso.');
        } else {
            $data = array('success'=> false,'message'=>$message);
        }

        // JSON encode and send back to the server
        echo json_encode($data);
    } else {        
        // Set up associative array
        //$data = array('success'=> true,'message'=> $result);

        // JSON encode and send back to the server
        echo json_encode($data);
    }
?>
