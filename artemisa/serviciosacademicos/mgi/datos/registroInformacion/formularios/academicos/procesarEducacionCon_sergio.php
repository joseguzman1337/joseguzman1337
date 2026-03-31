<?php 

session_start();
require_once("../../../templates/template.php");
	
	$proces=new Procesar();
	$proces->Control();
	
	class Procesar{

		public function Control (){
					
			$db = getBD();
			 
			switch ($_REQUEST['procesID']){
				case 'registrar_formEducacion_Continuada':
					if( $_POST['formulario_edu']=='programas'){
						
						$query_periodoinf="select mes,anio from programamesesEducontinuada where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
						$periodoinf=$db->Execute($query_periodoinf);
						$totalRows_mesinf = $periodoinf->RecordCount();
						$row_mesinf = $periodoinf->FetchRow();
						$int=0;
						if($row_mesinf==0){	
											$query_inserta_mes="insert into programamesesEducontinuada (mes,anio,codigoestado)values('".$_POST['mes']."','".$_POST['anio']."', 100)";
											$inserta_mes=&$db->Execute($query_inserta_mes);
								foreach ($_POST['tipo_programa']as $row){
									if(isset ($_POST['tipo_categoria'])){
											$query_inserta="insert into programaEducacionContinuada (tipoprograma,categoria,num_abierto,num_cerrado,num_pres,num_vir,num_sem,numero_asistentes,pais_participantes,
											cantidad_participantes,pais_conferencistas,cantidad_conferencistas,mes,anio,estadoprograma)
				      							values('".$_POST['tipo_programa'][$int]."','".$_POST['tipo_categoria'][$_POST['tipo_programa'][$int]]."','".$_POST['num_abierto'][$int]."','".$_POST['num_cerrado'][$int]."',
				      									'".$_POST['num_pres'][$int]."','".$_POST['num_vir'][$int]."','".$_POST['num_sem'][$int]."','".$_POST['cant_asistentes'][$int]."','".$_POST['pais_parti'][$int]."',
				      									'".$_POST['cant_participantes'][$int]."','".$_POST['pais_confe'][$int]."','".$_POST['cant_conferencistas'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
									}else {
											echo $query_inserta="insert into programaEducacionContinuada (tipoprograma,num_abierto,num_cerrado,num_pres,num_vir,num_sem,numero_asistentes,pais_participantes,
											cantidad_participantes,pais_conferencistas,cantidad_conferencistas,mes,anio,estadoprograma)
				      						values('".$_POST['tipo_programa'][$int]."','".$_POST['num_abierto'][$int]."','".$_POST['num_cerrado'][$int]."',
				      									'".$_POST['num_pres'][$int]."','".$_POST['num_vir'][$int]."','".$_POST['num_sem'][$int]."','".$_POST['cant_asistentes'][$int]."','".$_POST['pais_parti'][$int]."','".$_POST['cant_participantes'][$int]."',
							      						'".$_POST['pais_confe'][$int]."','".$_POST['cant_conferencistas'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
									}
									if($inserta= &$db->Execute($query_inserta)===false){
      									$a_vectt['val']			='FALSE';
      									$a_vectt['descrip']		='Error En el SQL Insert O Consulta....'.$query_inserta;
      									echo json_encode($a_vectt);
      									exit;
      								}
      								
      								$int++;
      						}//foreach
      					

      						$a_vectt['val']			='TRUE';
      						$a_vectt['descrip']		='Almacenado Exitosamente ';
      						echo json_encode($a_vectt);
      						exit;
					}//if 
					else{
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Este mes ya fue registrado';
						echo json_encode($a_vectt);
						exit;
					}//else
					
				}//( $_POST['formulario_edu']=='programas')
			break;#case 'registrar_formEducacion_Continuada':
				case'registrar_ProgramasOfrecidos':
					if( $_POST['formulario_edu_dos']=='numero_programas'){
					
						$query_periodoinf="select mes,anio from numeroProgramaMesesContinuada where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
						$periodoinf=$db->Execute($query_perinf);
						$totalRows_mesinf = $periodoinf->RecordCount();
						$row_mesinf = $periodoinf->FetchRow();
						$int=0;
						if($row_mesinf==0){
							$query_inserta_mes="insert into numeroProgramaMesesContinuada (idmedioscontinuada,mes,anio,codigoestado)values(0,'".$_POST['mes']."','".$_POST['anio']."', 100)";
							$inserta_mes=&$db->Execute($query_inserta_mes);
							
							foreach ($_POST['tipo_programa']as $row){
											
											$query_inserta="insert into numeroOfrecidoscontinuada (tipoprograma,cantidad_salud,cantidad_vida,
											cantidad_nucleo,cantidad_academica,mes,anio,estadoprograma)
				      							values('".$_POST['tipo_programa'][$int]."','".$_POST['cantidad_salud'][$int]."','".$_POST['cantidad_vida'][$int]."',
				      									'".$_POST['cantidad_nucleo'][$int]."','".$_POST['cantidad_academica'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
								
								if($inserta= &$db->Execute($query_inserta)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error En el SQL Insert O Consulta....'.$query_inserta;
									echo json_encode($a_vectt);
									exit;
								}//if_insert
					
								$int++;
							}//foreach
							$a_vectt['val']			='TRUE';
							$a_vectt['descrip']		='Almacenado Exitosamente ';
							echo json_encode($a_vectt);
							exit;
						}//if
						else{
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Este mes ya fue registrado';
							echo json_encode($a_vectt);
							exit;
						}//else
							
					}//( $_POST['formulario_edu']=='programas')
			break;//case'registrar_ProgramasOfrecidos':
				case'registrar_abiertos_cerrados':
					if( $_POST['formulario_edu_tres']=='numero_programas'){
							
						$query_periodoinf="select mes,anio from abiertocerradomeses where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
						$periodoinf=$db->Execute($query_periodoinf);
						$totalRows_mesinf = $periodoinf->RecordCount();
						$row_mesinf = $periodoinf->FetchRow();
						$int=0;
						if($row_mesinf==0){
							$query_inserta_mes="insert into abiertocerradomeses (idmedioscontinuada,mes,anio,codigoestado)values(0,'".$_POST['mes']."','".$_POST['anio']."', 100)";
							//echo $query_inserta_mes;
                                                        $inserta_mes=$db->Execute($query_inserta_mes);
								
							foreach ($_POST['tipo_programa'] as $row){
									
								$query_inserta="insert into educacionabiertocerrado (tipoprograma,cantidad,procentaje,mes,anio,estado)
				      							values('".$_POST['tipo_programa'][$int]."','".$_POST['cantidad'][$int]."','".$_POST['procentaje'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
				
								if($inserta= $db->Execute($query_inserta)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error En el SQL Insert O Consulta....'.$query_inserta;
									echo json_encode($a_vectt);
									exit;
								}//if_insert
									
								$int++;
							}//foreach
							$a_vectt['val']			='TRUE';
							$a_vectt['descrip']		='Almacenado Exitosamente ';
							echo json_encode($a_vectt);
							exit;
						}//if
						else{
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Este mes ya fue registrado';
							echo json_encode($a_vectt);
							exit;
						}//else
							
					}//( $_POST['formulario_edu']=='programas')
				break;//case'registrar_abiertos_cerrados':
				
				case'insert_academica':
					
				if( $_POST['formulario_edu_cuatro']=='numero_programas'){
					
					$query_periodoinf="select mes,anio from continuadaacademicameses where anio='".$_POST['anio']."' and mes='".$_POST['mes']."'";
					$periodoinf=$db->Execute($query_periodoinf);
					$totalRows_mesinf = $periodoinf->RecordCount();
					$row_mesinf = $periodoinf->FetchRow();
					$int=0;
					if($row_mesinf==0){
						$query_inserta_mes="insert into continuadaacademicameses (idmedioscontinuada,mes,anio,codigoestado)values(0,'".$_POST['mes']."','".$_POST['anio']."', 100)";
						$inserta_mes=&$db->Execute($query_inserta_mes);
							
						foreach ($_POST['tipo_programa']as $row){
								
							 $query_inserta="insert into educacionacademica (tipoprograma,cant_curso,cant_diplomado,cant_evento,num_abierto,num_cerrado,num_pres,num_vir,num_sem,mes,anio,estado)
					      							values('".$_POST['tipo_programa'][$int]."','".$_POST['cant_curso'][$int]."','".$_POST['cant_diplomado'][$int]."',
				      									'".$_POST['cant_evento'][$int]."','".$_POST['num_abierto'][$int]."','".$_POST['num_cerrado'][$int]."',
				      									'".$_POST['num_pres'][$int]."','".$_POST['num_vir'][$int]."','".$_POST['num_sem'][$int]."','".$_POST['mes']."','".$_POST['anio']."', 100)";
								
							if($inserta= &$db->Execute($query_inserta)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error En el SQL Insert O Consulta....'.$query_inserta;
								echo json_encode($a_vectt);
								exit;
							}//if_insert
								
							$int++;
						}//foreach
						$a_vectt['val']			='TRUE';
						$a_vectt['descrip']		='Almacenado Exitosamente ';
						echo json_encode($a_vectt);
						exit;
					}//if
					else{
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Este mes ya fue registrado';
						echo json_encode($a_vectt);
						exit;
					}//else
				}//( $_POST['formulario_edu']=='programas')
				break;//case'insert_academica':
			}#switch
		}#control
	}#procesar

?>