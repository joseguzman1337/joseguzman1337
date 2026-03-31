<?PHP 
session_start();



if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 

switch($_REQUEST['actionID']){
	case 'CancelarTaller':{
		MainJson();
		 global $userid,$db;
		
		
		$id_Existe		= $_POST['id_Existe'];
		$P_General		= $_POST['P_General'];
		$id_Bienestar	= $_POST['id_Bienestar'];
		
		
		$SQL_Cancela='UPDATE   talleresBienestarEstudiante
		
					  SET		
					  			codigoestado=200
					  		   
					  WHERE
								codigoperiodo="'.$P_General.'"
								AND
								codigoestado=100
								AND
								id_bienestar="'.$id_Bienestar.'"
								AND
								id_talleresBienestarEstudiante="'.$id_Existe.'"';
								
								
					if($Cancelo=&$db->Execute($SQL_Cancela)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Cancelar el Taller.....'.$SQL_Cancela;
							echo json_encode($a_vectt);
							exit;
						}			
		/*************************************************/
			$a_vectt['val']			='TRUE';
			//$a_vectt['descrip']		='Error al Cancelar el Taller.....'.$SQL_Cancela;
			echo json_encode($a_vectt);
			exit;
		/*************************************************/ 
		}break;
	case 'BuscarData':{
		MainJson();
		 global $userid,$db;
		 
		$P_General		= $_POST['P_General'];
		$Estudiante_id	= $_POST['Estudiante_id'];
		$permiso	= $_POST['PermisoUsuario'];
                $disableSalud = 'disabled="disabled"';
                if($permiso==2 || $permiso=='2' || $permiso==''){
                    $disableSalud = "";
                }
                /******************************TRAE LOS CAMPOS CORRESPONDIENTES AL MONITOR DEL PERIODO*********/
                $a_vectt['selectMonitoresVoluntariado'] = getSelectMonitoresVoluntariado($db,$P_General);
                $a_vectt['actividadesPromocionSalud'] = pintarActividadesPromocionYPrevencion($db,$disableSalud);
		/******************************************************************************************/
			$SQL_B='SELECT 

							*
					
					FROM 
					
							bienestar
					
					WHERE
					
							idestudiantegenral="'.$Estudiante_id.'"
							AND
							codigoestado=100
							AND
							codigoperiodo="'.$P_General.'"';
				
				if($Busqueda=&$db->Execute($SQL_B)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Buscar Datos de Bienestar.....'.$SQL_B;
						echo json_encode($a_vectt);
						exit;
					}
					
			if(!$Busqueda->EOF){
                            $a_vectt['actividadesPromocionSalud'] = pintarActividadesPromocionYPrevencion($db,$disableSalud,$P_General,$Busqueda->fields['idbienestar']);
                            $array = pintarIncapacidades($db,$disableSalud,$Busqueda->fields['idbienestar']);	
                            $a_vectt['incapacidadesSalud'] = $array[0];	
                            $a_vectt['totalIncapacidadesSalud'] = $array[1];	
                            
                            /************************************************/
				
					$id_bienestar		= $Busqueda->fields['idbienestar'];
					$Selecion_U			= $Busqueda->fields['participaseleccionesuniversidad'];
					$tiposeleccion		= $Busqueda->fields['tiposeleccion'];
					$p_ini_Selecion		= $Busqueda->fields['periodoinicialseleccion'];
					$p_fin_Selecion		= $Busqueda->fields['periodofinalseleccion'];
					$Apoyo_U			= $Busqueda->fields['apoyouniversidad'];
					$Tipo_Apoyo			= $Busqueda->fields['tiposcompetenciasapoyada'];
					$p_ini_apoyo		= $Busqueda->fields['peridodinicialapoyo'];
					$p_fin_apoyo		= $Busqueda->fields['periodofinalapoyo'];
					$TalleresDeport		= $Busqueda->fields['talleresformativos'];
					$logroDeport		= $Busqueda->fields['logrosdeportuniversidad'];
					$logrodeportcual	= $Busqueda->fields['logrodeportcual'];
					$p_logrodeport		= $Busqueda->fields['periodologrodeport'];
					$BecasEstimuBiene	= $Busqueda->fields['becasestimulosbienestar'];
					$becasCual			= $Busqueda->fields['becasestimuloscual'];
					$p_Becadeport		= $Busqueda->fields['periodobecadeport'];
					$asistegym			= $Busqueda->fields['asistegym'];
					$frecuenciagym		= $Busqueda->fields['frecuenciagym'];
					$clubrunning		= $Busqueda->fields['clubrunning'];
					$P_ClubRunning		= $Busqueda->fields['fechavinculacionrunning'];
					$clubcaminantes		= $Busqueda->fields['clubcaminantes'];
					$P_Caminates		= $Busqueda->fields['fechavinculacioncaminantes'];
					$grupoculturales	= $Busqueda->fields['grupoculturales'];
					$P_ini_Grup			= $Busqueda->fields['periodo_ini_Grup'];
					$P_fin_Grup			= $Busqueda->fields['periodo_fin_Grup'];
					$TypeGrupCult		= $Busqueda->fields['tiposgruposculturales'];
					$TallerCultura		= $Busqueda->fields['talleresculturales'];
					$LogrosCulturales	= $Busqueda->fields['logrosculturales'];
					$CualLogroCult		= $Busqueda->fields['cuallogrocultural'];
					$P_logroCult		= $Busqueda->fields['periodologro'];
					$BecasCulturales	= $Busqueda->fields['becasculturales'];
					$CualbecaCultural	= $Busqueda->fields['cualbecacultural'];
					$P_Becacultural		= $Busqueda->fields['periodobecacultural'];
					$V_grupoapoyo		= $Busqueda->fields['pertenecegrupapoyo'];
					$V_periodoInicialApoyo		= $Busqueda->fields['periodoInicialApoyoBienestar'];
					$V_periodoFinalApoyo		= $Busqueda->fields['periodoFinalApoyoBienestar'];
					$V_monitor		= $Busqueda->fields['monitorbienestar'];
					$V_tipoMonitor		= $Busqueda->fields['tipoMonitorBienestar'];
					$V_periodoInicialMonitor		= $Busqueda->fields['periodoInicialMonitor'];
					$V_periodoFinalMonitor		= $Busqueda->fields['periodoFinalMonitor'];
					$V_voluntariado		= $Busqueda->fields['pertenecevoluntariado'];
					$V_inicialVoluntariado		= $Busqueda->fields['fechaInicialVoluntareado'];
					$V_finalVoluntariado	= $Busqueda->fields['fechaFinalVoluntareado'];
                                        $Num_Ase_PsicoSalud	= $Busqueda->fields['asesoriapsicologicaSalud'];
					
					
					if($TalleresDeport==0){
					/**********************************************************************/
						$SQL_T='SELECT 

										id_talleresBienestarEstudiante as id,
										id_bienestar,
										id_taller,
										periodo_inicial,
										periodo_fin
								
								FROM 
								
										talleresBienestarEstudiante
								
								WHERE
								
										tipoTaller=1
										AND
										codigoperiodo="'.$P_General.'"
										AND
										codigoestado=100
										AND
										id_bienestar="'.$id_bienestar.'"';
										
							if($TallerBiene=&$db->Execute($SQL_T)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Buscar de Taller Datos de Bienestar.....'.$SQL_T;
									echo json_encode($a_vectt);
									exit;
								}
								
							$C_Talleres	= '';
								
							if(!$TallerBiene->EOF){
								while(!$TallerBiene->EOF){
									/***********************************************/
									$C_Talleres	=$C_Talleres.'-'.$TallerBiene->fields['id'].'::'.$TallerBiene->fields['id_taller'].'::'.$TallerBiene->fields['periodo_inicial'].'::'.$TallerBiene->fields['periodo_fin'];
									/***********************************************/
									$TallerBiene->MoveNext();
								  } 
								}				
					/**********************************************************************/
					}else{
						$C_Talleres	= '';
						}
						
					if($TallerCultura==0){
						/*****************************************************************************/
						$SQL_T='SELECT 

										id_talleresBienestarEstudiante as id,
										id_bienestar,
										id_taller,
										periodo_inicial,
										periodo_fin
								
								FROM 
								
										talleresBienestarEstudiante
								
								WHERE
								
										tipoTaller=2
										AND
										codigoperiodo="'.$P_General.'"
										AND
										codigoestado=100
										AND
										id_bienestar="'.$id_bienestar.'"';
										
							if($TallerBiene=&$db->Execute($SQL_T)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Buscar de Taller Datos de Bienestar.....'.$SQL_T;
									echo json_encode($a_vectt);
									exit;
								}
								
							$C_TallerCultura	= '';
								
							if(!$TallerBiene->EOF){
								while(!$TallerBiene->EOF){
									/***********************************************/
									$C_TallerCultura	=$C_TallerCultura.'-'.$TallerBiene->fields['id'].'::'.$TallerBiene->fields['id_taller'].'::'.$TallerBiene->fields['periodo_inicial'].'::'.$TallerBiene->fields['periodo_fin'];
									/***********************************************/
									$TallerBiene->MoveNext();
								  } 
								}				
					/**********************************************************************/
						}else{
								$C_TallerCultura	='';
							}	
							
							
							
							
				/************************************************/
				$a_vectt['val']			='TRUE';
				/*******************************************************/
				$a_vectt['id_bienestar']			=$id_bienestar;
				$a_vectt['Selecion_U']				=$Selecion_U;
				$a_vectt['tiposeleccion']			=$tiposeleccion;
				$a_vectt['p_ini_Selecion']			=$p_ini_Selecion;
				$a_vectt['p_fin_Selecion']			=$p_fin_Selecion;
				$a_vectt['Apoyo_U']					=$Apoyo_U;
				$a_vectt['Tipo_Apoyo']				=$Tipo_Apoyo;
				$a_vectt['p_ini_apoyo']				=$p_ini_apoyo;
				$a_vectt['p_fin_apoyo']				=$p_fin_apoyo;
				$a_vectt['TalleresDeport']			=$TalleresDeport;
				$a_vectt['C_Talleres']				=$C_Talleres;
				$a_vectt['logroDeport']				=$logroDeport;
				$a_vectt['logrodeportcual']			=$logrodeportcual;
				$a_vectt['p_logrodeport']			=$p_logrodeport;
				$a_vectt['BecasEstimuBiene']		=$BecasEstimuBiene;
				$a_vectt['becasCual']				=$becasCual;
				$a_vectt['p_Becadeport']			=$p_Becadeport;
				$a_vectt['asistegym']				=$asistegym;
				$a_vectt['frecuenciagym']			=$frecuenciagym;
				$a_vectt['clubrunning']				=$clubrunning;
				$a_vectt['P_ClubRunning']			=$P_ClubRunning;
				$a_vectt['clubcaminantes']			=$clubcaminantes;
				$a_vectt['P_Caminates']				=$P_Caminates;
				$a_vectt['grupoculturales']			=$grupoculturales;
				$a_vectt['P_ini_Grup']				=$P_ini_Grup;
				$a_vectt['P_fin_Grup']				=$P_fin_Grup;
				$a_vectt['TypeGrupCult']			=$TypeGrupCult;
				$a_vectt['TallerCultura']			=$TallerCultura;
				$a_vectt['C_TallerCultura']			=$C_TallerCultura;
				$a_vectt['LogrosCulturales']		=$LogrosCulturales;
				$a_vectt['CualLogroCult']			=$CualLogroCult;
				$a_vectt['P_logroCult']				=$P_logroCult;
				$a_vectt['BecasCulturales']			=$BecasCulturales;
				$a_vectt['CualbecaCultural']		=$CualbecaCultural;
				$a_vectt['P_Becacultural']			=$P_Becacultural;
				$a_vectt['V_grupoapoyo']			=$V_grupoapoyo;
				$a_vectt['V_periodoInicialApoyo']			=$V_periodoInicialApoyo;
				$a_vectt['V_periodoFinalApoyo']			=$V_periodoFinalApoyo;
				$a_vectt['V_monitor']			=$V_monitor;
				$a_vectt['V_tipoMonitor']			=$V_tipoMonitor;
				$a_vectt['V_periodoInicialMonitor']			=$V_periodoInicialMonitor;
				$a_vectt['V_periodoFinalMonitor']			=$V_periodoFinalMonitor;
				$a_vectt['V_voluntariado']			=$V_voluntariado;
				$a_vectt['V_inicialVoluntariado']			=$V_inicialVoluntariado;
				$a_vectt['V_finalVoluntariado']			=$V_finalVoluntariado;
                                $a_vectt['Num_Ase_PsicoSalud'] = $Num_Ase_PsicoSalud;
				
				
				/*******************************************************/
				echo json_encode($a_vectt);
				exit;		
				
				}else{
					$a_vectt['val']			='Vacio';
					//$a_vectt['descrip']		='Error al Buscar de Taller Datos de Bienestar.....'.$SQL_T;
					echo json_encode($a_vectt);
					exit;
					}					
		/******************************************************************************************/					
		/******************************************************************************************/
		}break;
	case 'AutoCompletarEstudiante':{
		MainJson();
		 global $userid,$db,$Estudiante_id;
		 
		 $Letra   = $_REQUEST['term'];
		 
		   $SQL_Estudiante='SELECT 

							idestudiantegeneral AS id,
							nombresestudiantegeneral AS Nombre, 
							apellidosestudiantegeneral AS Apell,
							numerodocumento 
							
							FROM estudiantegeneral
							
							WHERE
							
							nombresestudiantegeneral LIKE "%'.$Letra.'%" 
							OR 
							apellidosestudiantegeneral LIKE "%'.$Letra.'%" 
							OR 
							numerodocumento LIKE "%'.$Letra.'%"';
							
					if($D_Estudiante=&$db->Execute($SQL_Estudiante)===false){
							echo 'Error en el Autocompletar Estudiante...<br>'.$SQL_Estudiante;
							die;
						}		
		 
		 $Result_F = array();
						
				while(!$D_Estudiante->EOF){
						$Rf_Vectt['label']=$D_Estudiante->fields['Nombre'].' '.$D_Estudiante->fields['Apell'].' :: '.$D_Estudiante->fields['numerodocumento']; 
						$Rf_Vectt['value']=$D_Estudiante->fields['Nombre'].' '.$D_Estudiante->fields['Apell'].' :: '.$D_Estudiante->fields['numerodocumento'];
						
						$Rf_Vectt['Estudiante_id']=$D_Estudiante->fields['id'];
						
						array_push($Result_F,$Rf_Vectt);
					$D_Estudiante->MoveNext();	
					}	
					
			echo json_encode($Result_F);
		 
		}break;
	case 'Save_Admin':{
		 MainJson();
		 global $userid,$db,$Estudiante_id;
		 
		// $userid = '4186';
		 
		 $pae						= $_GET['pae'];
		 $Academicas				= $_GET['Academicas'];
		 $psicosociales				= $_GET['psicosociales'];
		 $economicas				= $_GET['economicas'];
		 $Competencias				= $_GET['Competencias'];
		 $independecia				= $_GET['independecia'];
		 $Metodos					= $_GET['Metodos'];
		 $DistribuTiempo			= $_GET['DistribuTiempo'];
		 $TrabEquipo				= $_GET['TrabEquipo'];
		 $Socializacion				= $_GET['Socializacion'];
		 $PrioriActividades			= $_GET['PrioriActividades'];
		 $InterFamilia				= $_GET['InterFamilia'];
		 $CompLectura				= $_GET['CompLectura'];
		 $conflictos				= $_GET['conflictos'];
		 $Cual_Adaptacion			= $_GET['Cual_Adaptacion'];
		 $OtroEscala				= $_GET['OtroEscala']; 
		 $ReacionProblema			= $_GET['ReacionProblema']; 
		 $Cual_Problema				= $_GET['Cual_Problema'];
		 $Padre_Por					= $_GET['Padre_Por'];
		 $Padre_Descri				= $_GET['Padre_Descri'];
		 $Madre_Por					= $_GET['Madre_Por'];
		 $Madre_Descri				= $_GET['Madre_Descri'];
		 $Hermano_Por				= $_GET['Hermano_Por'];
		 $Hermano_Descri			= $_GET['Hermano_Descri'];
		 $Hermana_Por				= $_GET['Hermana_Por'];
		 $Hermana_Descri			= $_GET['Hermana_Descri'];
		 $Amigos_Por				= $_GET['Amigos_Por'];
		 $Amigos_Descri				= $_GET['Amigos_Descri'];
		 $Pareja_Por				= $_GET['Pareja_Por'];
		 $Pareja_Descri				= $_GET['Pareja_Descri'];
		 $ExitoEstudianti			= $_GET['ExitoEstudianti'];
		
		 /*********************Bienestar*****************************/
		 $Selecion_U				= $_GET['Selecion_U'];
		 $Tipo_Selecion				= $_GET['Tipo_Selecion'];
		 $Competencias_U			= $_GET['Competencias_U'];
		 $Tipo_Competencia			= $_GET['Tipo_Competencia'];
		 $Talleres					= $_GET['Talleres'];
		 $Tipo_Taller				= $_GET['Tipo_Taller'];
		 $LogroDeportivo			= $_GET['LogroDeportivo'];
		 $Cual_LogroDeportivo		= $_GET['Cual_LogroDeportivo'];
		 $BecasEstimos				= $_GET['BecasEstimos'];
		 $Cual_BecaEstimulo			= $_GET['Cual_BecaEstimulo'];
		 $Gimnasio					= $_GET['Gimnasio'];
		 $Frecuenca_Gym				= $_GET['Frecuenca_Gym'];
		 $ClubRunning				= $_GET['ClubRunning'];
		 $FechaVinculacion			= $_GET['FechaVinculacion'];
		 $ClubCaminantes			= $_GET['ClubCaminantes'];
		 $FechaVinculacionCaminantes= $_GET['FechaVinculacionCaminantes'];
		 $PeriodoBecasDeport		= $_GET['PeriodoBecasDeport'];
		 /************************************************************************/
		 $Num_Ase_Psico				= $_GET['Num_Ase_Psico'];
		 $Num_MedGeneral			= $_GET['Num_MedGeneral'];
		 $Num_MedDeporte			= $_GET['Num_MedDeporte'];
		 $Num_PromoPlaneacion		= $_GET['Num_PromoPlaneacion'];
		 $CadenaIncapacidad			= $_GET['CadenaIncapacidad'];
		 $Acidente_U				= $_GET['Acidente_U'];
		 $Fecha_Accidente			= $_GET['Fecha_Accidente'];
		 $Uso_Seguro				= $_GET['Uso_Seguro'];
		 /*************************************************************************/
		 $GrupoCultural				= $_GET['GrupoCultural'];
		 $P_ini_Grupo				= $_GET['P_ini_Grupo'];
		 $P_fin_Grupo				= $_GET['P_fin_Grupo'];
		 $Tipo_GrupoCultural		= $_GET['DatoGrupCult'];
		 $TalleresCultura			= $_GET['TalleresCultura'];
		 $DatoTaller				= $_GET['DatoTaller'];
		 $PeriodoLogroDeport		= $_GET['PeriodoLogroDeport'];
		 $LogroCultural				= $_GET['LogroCultural'];
		 $CualLogrosCulturales		= $_GET['CualLogrosCulturales'];
		 $PeriodoLogroCultural		= $_GET['PeriodoLogroCultural'];
		 $BecaCultural				= $_GET['BecaCultural'];
		 $CualBecasCulturales		= $_GET['CualBecasCulturales'];
		 $PeriodoBecasCultural		= $_GET['PeriodoBecasCultural'];
		 /************************************************************************/
		 $Voluntariado				= $_REQUEST['Voluntariado'];
		 $GrupoApoyo				= $_REQUEST['GrupoApoyo'];
		 $MonitoBienestar			= $_REQUEST['MonitoBienestar'];
		 $Bienestar					= $_REQUEST['Bienestar'];
		 $PermisoUsuario			= $_REQUEST['PermisoUsuario'];
		 $F_ini						= $_GET['F_ini'];
		 $F_fin						= $_GET['F_fin'];
		 $F_ini_Ap					= $_GET['F_ini_Ap'];
		 $F_fin_Ap					= $_GET['F_fin_Ap'];
		 /******************************************************/
		 $Representante				= $_GET['Representante'];
		 $ConsejoFacul				= $_GET['ConsejoFacul'];
		 $ConsejoAcad				= $_GET['ConsejoAcad'];
		 $ConsejoDir				= $_GET['ConsejoDir'];
		 $OrgaGobierno				= $_GET['OrgaGobierno'];
		 /******************************************************/
		 $Investiga					= $_GET['Investiga'];
		 $Semillero					= $_GET['Semillero'];
		 $Nom_Semillero				= $_GET['Nom_Semillero'];
		 $FechainicialSemillero		= $_GET['FechaVinculacionSemillero'];
		 $FechaFinSemillero			= $_GET['FechaFinSemillero'];
		 $Dependencia				= $_GET['Dependencia'];
		 /******************************************************/
		 $Asistente					= $_GET['Asistente'];
		 $NombreProyecto_invg		= $_GET['NombreProyecto_invg'];
		 $DocenteResp_invg			= $_GET['DocenteResp_invg'];
		 $Fechainicio_invg			= $_GET['Fechainicio_invg'];
		 $Fechafin_invg				= $_GET['Fechafin_invg'];
		 /******************************************************/
		 $Publicaciones				= $_GET['Publicaciones'];
		 $Autor_Publicacion			= $_GET['Autor_Publicacion'];
		 $Nom_Publicacion			= $_GET['Nom_Publicacion'];
		 $Coautor_Publicacion		= $_GET['Coautor_Publicacion'];
		 $Editorial_Publicacion		= $_GET['Editorial_Publicacion'];
		 $Rol						= $_GET['Rol'];
		 $Cual_Rol					= $_GET['Cual_Rol'];
		 $TipoPublicacion			= $_GET['TipoPublicacion'];	
		 $Indexada					= $_GET['Indexada'];	
		 $Otra_publicTipo			= $_GET['Otra_publicTipo'];
		 /******************************************************/ 
		 $PublicacionExt			= $_GET['PublicacionExt'];
		 $Autor_PublicacionExt		= $_GET['Autor_PublicacionExt'];
		 $Nom_PublicacionExt		= $_GET['Nom_PublicacionExt'];
		 $Coautor_PublicacionExt	= $_GET['Coautor_PublicacionExt'];
		 $Entidad_PublicacionExt	= $_GET['Entidad_PublicacionExt'];
		 $Rol_ext					= $_GET['Rol_ext'];
		 $CualRol_PublicacionExt	= $_GET['CualRol_PublicacionExt'];
		 $TipoPublicacion_Ext		= $_GET['TipoPublicacion_Ext'];
		 $Indexsada_Ext				= $_GET['Indexsada_Ext'];
		 $Otra_publicTipoExt		= $_GET['Otra_publicTipoExt'];
		 /******************************************************/
		 $AsisEventos				= $_GET['AsisEventos'];
		 $Fechaini_Evento			= $_GET['Fechaini_Evento'];
		 $Fechafin_Evento			= $_GET['Fechafin_Evento'];
		 $Nom_evento				= $_GET['Nom_evento'];
		 $Nom_EntidadOrg			= $_GET['Nom_EntidadOrg'];
		 /******************************************************/
		 $PonenteCongreso			= $_GET['PonenteCongreso'];
		 $Fechaini_CongBosque		= $_GET['Fechaini_CongBosque'];
		 $Fechafin_CongBosque		= $_GET['Fechafin_CongBosque'];
		 $NomEvento_CongBosque		= $_GET['NomEvento_CongBosque'];
		 $NomPonencia_CongBosque	= $_GET['NomPonencia_CongBosque'];
		 $Dependencia_CongBosque	= $_GET['Dependencia_CongBosque'];
		 /******************************************************/
		 $PonenteLocal				= $_GET['PonenteLocal'];
		 $Fechaini_Congreso			= $_GET['Fechaini_Congreso'];
		 $Fechafin_Congreso			= $_GET['Fechafin_Congreso'];
		 $NomEvento_Congreso		= $_GET['NomEvento_Congreso'];
		 $NomPonencia_Congreso		= $_GET['NomPonencia_Congreso'];
		 $Entidad_CongresoLocal		= $_GET['Entidad_CongresoLocal'];
		 /******************************************************/
		 $PonenteNacional			= $_GET['PonenteNacional'];
		 $Fechaini_CongNal			= $_GET['Fechaini_CongNal'];
		 $Fechafin_CongNal			= $_GET['Fechafin_CongNal'];
		 $NomEvento_CongNal			= $_GET['NomEvento_CongNal'];
		 $NomPonencia_CongNal		= $_GET['NomPonencia_CongNal'];
		 $id_CityCongreso			= $_GET['id_CityCongreso'];
		 $Entidad_CongresoNal		= $_GET['Entidad_CongresoNal']; 
		 /******************************************************/   
		 $PonenteInternacional		= $_GET['PonenteInternacional'];
		 $Fechaini_CongInter		= $_GET['Fechaini_CongInter'];
		 $Fechafin_CongInter		= $_GET['Fechafin_CongInter'];
		 $NomEvento_CongInter		= $_GET['NomEvento_CongInter'];
		 $NomPonencia_CongInter		= $_GET['NomPonencia_CongInter'];
		 $id_CityCongInter			= $_GET['id_CityCongInter'];
		 $id_Pais					= $_GET['id_Pais'];
		 $Entidad_CongInter			= $_GET['Entidad_CongInter'];
		 $InvesActividad			= $_GET['InvesActividad'];
		 /*************************VOLUNTAREADO******************************/
		 $VoluntariadoB 			= $_GET['VoluntariadoB'];
		 $FechaInicialVoluntareado 	= $_GET['FechaInicialVoluntareado'];
		 $FechaFinalVoluntareado 	= $_GET['FechaFinalVoluntareado'];
		 $GrupoApoyoB 				=$_GET['GrupoApoyoB'];
		 $PeriodoInicialApoyo 		= $_GET['PeriodoInicialApoyo'];
		 $PeriodoFinalApoyo 		= $_GET['PeriodoFinalApoyo'];
		 $MonitorBienestar			= $_GET['MonitorBienestar'];
		 $SelecionVoluntareado 		=$_GET['SelecionVoluntareado'];
		 $DatoSeleccionVoluntareado = $_GET['DatoSeleccionVoluntareado'];
		 $F_iniVoluntareado 		= $_GET['F_iniVoluntareado'];
		 $Num_Ase_PsicoSalud	 	 = $_REQUEST['Num_Ase_Psico'];
                 parse_str($_REQUEST['participacionActividades'],$participacionActividades);
                 $participacionActividades=$participacionActividades["actividadesPromocion"];
                    parse_str($_REQUEST['idsActividades'],$idsActividades);
                  $idsActividades = $idsActividades["idsActividadesPromocion"];
		 //$participacionActividades	 = unserialize($_REQUEST['participacionActividades']);
		 $Cadena_Incapacidad	 = $_REQUEST['Cadena_Incapacidad'];
		
		 
		 $Estudiante_id				= $_REQUEST['Estudiante_id'];
		 
		 $P_General					= $_REQUEST['P_General'];
		 
		 $id_Bienestar				= $_REQUEST['id_Bienestar'];
		 
/**************************************Exito Extudiantil****************************************************/
		if($ExitoEstudianti==1 || $ExitoEstudianti=='1'){ 
		 $SQL_insert_ExitoEstudiantil='INSERT INTO exito_estudiantil(idestudiantegeneral,pae,academicas,psicosociales,economicas,basicasestudios,independenciaautonomia,metodos,distribuciontiempo,trabajoequipo,socializacion,priorizacionactividadez,interiorfamilia,compresionlectura,manejoconflitos,otros,cual,tiporeaccionproblema,cualreaccion,porcentajepadre,descripcionpadre,porcentajemadre,descripcionmadre,porcentajehermano,descripcionhermano,porcentajehermana,descripcionhermana,porcentajeamigos,descripcionamigos,porcentajepareja,descripcionpareja,entrydate,userid)VALUES("'.$Estudiante_id.'"'.$pae.'","'.$Academicas.'","'.$psicosociales.'","'.$economicas.'","'.$Competencias.'","'.$independecia.'","'.$Metodos.'","'.$DistribuTiempo.'","'.$TrabEquipo.'","'.$Socializacion.'","'.$PrioriActividades.'","'.$InterFamilia.'","'.$CompLectura.'","'.$conflictos.'","'.$OtroEscala.'","'.$Cual_Adaptacion.'","'.$ReacionProblema.'","'.$Cual_Problema.'","'.$Padre_Por.'","'.$Padre_Descri.'","'.$Madre_Por.'","'.$Madre_Descri.'","'.$Hermano_Por.'","'.$Hermano_Descri.'","'.$Hermana_Por.'","'.$Hermana_Descri.'","'.$Amigos_Por.'","'.$Amigos_Descri.'","'.$Pareja_Por.'","'.$Pareja_Descri.'",NOW(),"'.$userid.'")';
		 
		 
		 		if($InsertExitoEstudiantil=&$db->Execute($SQL_insert_ExitoEstudiantil)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Exito Extudiantil.....'.$SQL_insert_ExitoEstudiantil;
						echo json_encode($a_vectt);
						exit;
					}
		 
		 
		}
		 
		 
/***********************************Bienestar Universitario*************************************************/


	if($Bienestar==1	|| $Bienestar=='1'){      
	
		/************************************************/
		if($PermisoUsuario==1 || $PermisoUsuario=='1'){
			
			if($id_Bienestar!=''){
				
				    $SQL_Up='UPDATE	bienestar
							 SET	participaseleccionesuniversidad="'.$Selecion_U.'",
							 		tiposeleccion="'.$Tipo_Selecion.'",
									apoyouniversidad="'.$Competencias_U.'",
									tiposcompetenciasapoyada="'.$Tipo_Competencia.'",
									talleresformativos="'.$Talleres.'",
									logrosdeportuniversidad="'.$LogroDeportivo.'",
									logrodeportcual="'.$Cual_LogroDeportivo.'",
									periodologrodeport="'.$PeriodoLogroDeport.'",
									becasestimulosbienestar="'.$BecasEstimos.'",
									becasestimuloscual="'.$Cual_BecaEstimulo.'",
									periodobecadeport="'.$PeriodoBecasDeport.'",
									asistegym="'.$Gimnasio.'",
									frecuenciagym="'.$Frecuenca_Gym.'",
									clubrunning="'.$ClubRunning.'",
									fechavinculacionrunning="'.$FechaVinculacion.'",
									clubcaminantes="'.$ClubCaminantes.'",
									fechavinculacioncaminantes="'.$FechaVinculacionCaminantes.'",
									changedate=NOW() ,
									useridestado="'.$userid.'",
									periodoinicialseleccion="'.$F_ini.'",
									periodofinalseleccion="'.$F_fin.'",
									peridodinicialapoyo="'.$F_ini_Ap.'",
									periodofinalapoyo="'.$F_fin_Ap.'"
						WHERE
									idestudiantegenral="'.$Estudiante_id.'"  
									AND 
									codigoperiodo="'.$P_General.'"  
									AND 
									idbienestar="'.$id_Bienestar.'" 
									AND  
									codigoestado=100';	
						/******************************************************************/			
						
						if($UpBienestar=&$db->Execute($SQL_Up)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar De Bienestar.....'.$SQL_Up;
							echo json_encode($a_vectt);
							exit;    
						}
						
						/******************************************************************/
					if($Talleres==0){				
						if($Tipo_Taller!=''){
						/*********************************************/
						
							$C_TipoTaller	= explode('-',$Tipo_Taller);		
							
							//echo '<pre>';print_r($C_TipoTaller);
							
							for($t=1;$t<count($C_TipoTaller);$t++){
								/******************************************/
									$C_Taller	= explode('::',$C_TipoTaller[$t]);
									
									//echo '<pre>';print_r($C_Taller);
									/*
									[0] => 19--> id taller
									[1] => 20122 -> fecha Inicial
									[2] => 20111 --> Fecha final
									*/
									
									$SQL_Taller='INSERT INTO talleresBienestarEstudiante(id_bienestar,id_taller,periodo_inicial,periodo_fin,tipotaller,codigoperiodo,entrydate,userid)VALUES("'.$id_Bienestar.'","'.$C_Taller[0].'","'.$C_Taller[1].'","'.$C_Taller[2].'",1,"'.$P_General.'",NOW(),"'.$userid.'")';
									
									if($TalleresBienestar=&$db->Execute($SQL_Taller)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error al Insertar Talleres De Bienestar.....'.$SQL_Taller;
										echo json_encode($a_vectt);
										exit;
									}
								/******************************************/
								}//for
		
						/*********************************************/
						}			
					}
				}else{
			/*********************************************/
			  $SQL='SELECT 

					idbienestar,
					idestudiantegenral,
					codigoestado
					
					FROM 
					
					bienestar
					
					WHERE
					
					codigoestado=100
					AND
					idestudiantegenral="'.$Estudiante_id.'"
					AND
					codigoperiodo="'.$P_General.'"';
					
				if($ExisteR=&$db->Execute($SQL)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error al Buscar Si Existe Algun Reguistro.....'.$$SQL;
					echo json_encode($a_vectt);
					exit;
					}	
			/*********************************************/
				if(!$ExisteR->EOF){  
					/*******************************************/
					$id_Existente	= $ExisteR->fields['idbienestar'];
					/************************************************/
					
					$SQL_Up='UPDATE	bienestar
							 SET	participaseleccionesuniversidad="'.$Selecion_U.'",
							 		tiposeleccion="'.$Tipo_Selecion.'",
									apoyouniversidad="'.$Competencias_U.'",
									tiposcompetenciasapoyada="'.$Tipo_Competencia.'",
									talleresformativos="'.$Talleres.'",
									logrosdeportuniversidad="'.$LogroDeportivo.'",
									logrodeportcual="'.$Cual_LogroDeportivo.'",
									periodologrodeport="'.$PeriodoLogroDeport.'",
									becasestimulosbienestar="'.$BecasEstimos.'",
									becasestimuloscual="'.$Cual_BecaEstimulo.'",
									periodobecadeport="'.$PeriodoBecasDeport.'",
									asistegym="'.$Gimnasio.'",
									frecuenciagym="'.$Frecuenca_Gym.'",
									clubrunning="'.$ClubRunning.'",
									fechavinculacionrunning="'.$FechaVinculacion.'",
									clubcaminantes="'.$ClubCaminantes.'",
									fechavinculacioncaminantes="'.$FechaVinculacionCaminantes.'",
									changedate=NOW() ,
									useridestado="'.$userid.'",
									periodoinicialseleccion="'.$F_ini.'",
									periodofinalseleccion="'.$F_fin.'",
									peridodinicialapoyo="'.$F_ini_Ap.'",
									periodofinalapoyo="'.$F_fin_Ap.'"
						WHERE
									idestudiantegenral="'.$Estudiante_id.'"  
									AND 
									codigoperiodo="'.$P_General.'"  
									AND 
									idbienestar="'.$id_Existente.'" 
									AND  
									codigoestado=100';	
									
						if($UpBienestar=&$db->Execute($SQL_Up)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Modificar De Bienestar.....'.$SQL_Up;
							echo json_encode($a_vectt);
							exit;
						}			
					
					
				if($Talleres==0){	
					if($Tipo_Taller!=''){
						/*********************************************/
						
							$C_TipoTaller	= explode('-',$Tipo_Taller);		
							
							//echo '<pre>';print_r($C_TipoTaller);
							
							for($t=1;$t<count($C_TipoTaller);$t++){
								/******************************************/
									$C_Taller	= explode('::',$C_TipoTaller[$t]);
									
									//echo '<pre>';print_r($C_Taller);
									/*
									[0] => 19--> id taller
									[1] => 20122 -> fecha Inicial
									[2] => 20111 --> Fecha final
									*/
									
									$SQL_Taller='INSERT INTO talleresBienestarEstudiante(id_bienestar,id_taller,periodo_inicial,periodo_fin,tipotaller,codigoperiodo,entrydate,userid)VALUES("'.$id_Existente.'","'.$C_Taller[0].'","'.$C_Taller[1].'","'.$C_Taller[2].'",1,"'.$P_General.'",NOW(),"'.$userid.'")';
									
									if($TalleresBienestar=&$db->Execute($SQL_Taller)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error al Insertar Talleres De Bienestar.....'.$SQL_Taller;
										echo json_encode($a_vectt);
										exit;
									}
								/******************************************/
								}//for
		
						/*********************************************/
						}
				}
					/*******************************************/
					}else{
						/***************************************/
						
					$SQL_Insert_Bienestar='INSERT INTO bienestar(idestudiantegenral,participaseleccionesuniversidad,tiposeleccion,apoyouniversidad,tiposcompetenciasapoyada,talleresformativos,logrosdeportuniversidad,logrodeportcual,periodologrodeport,becasestimulosbienestar,becasestimuloscual,periodobecadeport,asistegym,frecuenciagym,clubrunning,fechavinculacionrunning,clubcaminantes,fechavinculacioncaminantes,codigoperiodo,entrydate,userid,periodoinicialseleccion,periodofinalseleccion,peridodinicialapoyo,periodofinalapoyo)VALUES("'.$Estudiante_id.'","'.$Selecion_U.'","'.$Tipo_Selecion.'","'.$Competencias_U.'","'.$Tipo_Competencia.'","'.$Talleres.'","'.$LogroDeportivo.'","'.$Cual_LogroDeportivo.'","'.$PeriodoLogroDeport.'","'.$BecasEstimos.'","'.$Cual_BecaEstimulo.'","'.$PeriodoBecasDeport.'","'.$Gimnasio.'","'.$Frecuenca_Gym.'","'.$ClubRunning.'","'.$FechaVinculacion.'","'.$ClubCaminantes.'","'.$FechaVinculacionCaminantes.'","'.$P_General.'",NOW(),"'.$userid.'","'.$F_ini.'","'.$F_fin.'","'.$F_ini_Ap.'","'.$F_fin_Ap.'")';
						
	
				if($InsertBienestar=&$db->Execute($SQL_Insert_Bienestar)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_Insert_Bienestar;
						echo json_encode($a_vectt);
						exit;
					}
					
			#####################################
			$Last_id_Bienestar=$db->Insert_ID();
			#####################################		
			if($Talleres==0){
						
			$C_TipoTaller	= explode('-',$Tipo_Taller);		
			
			//echo '<pre>';print_r($C_TipoTaller);
			
			for($t=1;$t<count($C_TipoTaller);$t++){
				/******************************************/
					$C_Taller	= explode('::',$C_TipoTaller[$t]);
					
					//echo '<pre>';print_r($C_Taller);
					/*
					[0] => 19--> id taller
					[1] => 20122 -> fecha Inicial
					[2] => 20111 --> Fecha final
					*/
					
					$SQL_Taller='INSERT INTO talleresBienestarEstudiante(id_bienestar,id_taller,periodo_inicial,periodo_fin,tipotaller,codigoperiodo,entrydate,userid)VALUES("'.$Last_id_Bienestar.'","'.$C_Taller[0].'","'.$C_Taller[1].'","'.$C_Taller[2].'",1,"'.$P_General.'",NOW(),"'.$userid.'")';
					
					if($TalleresBienestar=&$db->Execute($SQL_Taller)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Talleres De Bienestar.....'.$SQL_Taller;
						echo json_encode($a_vectt);
						exit;
					}
				/******************************************/
				}//for
			
			}//if
		}
		/***************************************/
	   }//id_Bienestar
	}//ifPermisos
	
	if($PermisoUsuario==2 || $PermisoUsuario=='2'){
            $Last_id_Bienestar = -1;
            if($id_Bienestar!=''){
                $UpBienestar=actualizarRegistroBienestarSalud($db,$id_Bienestar,$P_General,$Estudiante_id,$Num_Ase_PsicoSalud);		
                if($UpBienestar[0]===false){
			$a_vectt['val']			='FALSE';
			$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$UpBienestar[1];
			echo json_encode($a_vectt);
			exit;
		}
                $Last_id_Bienestar = $id_Bienestar; 
            }else{
			/*****************************************************************/	
			 $ExisteR=buscarDatoBienestar($Estudiante_id,$P_General,$db);
				if($ExisteR[0]===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error al Buscar Si Existe Algún Registro.....'.$ExisteR[1];
					echo json_encode($a_vectt);
					exit;
					}	
                                        
				if(!$ExisteR[0]->EOF){
                                    $UpBienestar=actualizarRegistroBienestarSalud($db,$ExisteR[0]->fields['idbienestar'],$P_General,$Estudiante_id,$Num_Ase_PsicoSalud);		
                                    if($UpBienestar[0]===false){
                                            $a_vectt['val']			='FALSE';
                                            $a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$UpBienestar[1];
                                            echo json_encode($a_vectt);
                                            exit;
                                    }
                                    $Last_id_Bienestar = $ExisteR[0]->fields['idbienestar']; 
                                } else {
            
                                    $SQL_Insert_Bienestar='INSERT INTO bienestar(idestudiantegenral,asesoriapsicologicaSalud,codigoperiodo,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$Num_Ase_PsicoSalud.'","'.$P_General.'",NOW(),"'.$userid.'")';
                                                                                
                                                    if($InsertBienestar=&$db->Execute($SQL_Insert_Bienestar)===false){
                                                                    $a_vectt['val']			='FALSE';
                                                                    $a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_Insert_Bienestar;
                                                                    echo json_encode($a_vectt);
                                                                    exit;
                                                            }

                                                    /*************************************************/	
                                                    #####################################
                                                    $Last_id_Bienestar=$db->Insert_ID();
                                }
            }
                  //actualiza o inserta actividades              
                  actualizarActividadesPromocion($db,$Last_id_Bienestar,$participacionActividades,$idsActividades);
                  if($Cadena_Incapacidad!=""){
                      actualizarIncapacidades($db,$Last_id_Bienestar,$Cadena_Incapacidad);
                  }
        }
	
	if($PermisoUsuario==3 || $PermisoUsuario=='3'){
		
		if($id_Bienestar!=''){
			
			$SQL_UP='UPDATE		 bienestar
			
					 SET		 grupoculturales="'.$GrupoCultural.'",
								 periodo_ini_Grup="'.$P_ini_Grupo.'",
								 periodo_fin_Grup="'.$P_fin_Grupo.'",
								 tiposgruposculturales="'.$Tipo_GrupoCultural.'",
								 talleresculturales="'.$TalleresCultura.'",
								 logrosculturales="'.$LogroCultural.'",
								 cuallogrocultural="'.$CualLogrosCulturales.'",
								 periodologro="'.$PeriodoLogroCultural.'",
								 becasculturales="'.$BecaCultural.'",
								 cualbecacultural="'.$CualBecasCulturales.'",
								 periodobecacultural="'.$PeriodoBecasCultural.'"
								 
					 WHERE
					 
								idestudiantegenral="'.$Estudiante_id.'"  
								AND 
								codigoperiodo="'.$P_General.'"  
								AND 
								idbienestar="'.$id_Bienestar.'" 
								AND  
								codigoestado=100';
								
					if($UpBienestar=&$db->Execute($SQL_UP)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_UP;
						echo json_encode($a_vectt);
						exit;
					}	
					
			/****************************************************************************************/					
					
				if($TalleresCultura==0){
					if($DatoTaller!=''){
					/*********************************************************/
					$C_TallerCult		= explode('-',$DatoTaller);
					
					for($t=1;$t<count($C_TallerCult);$t++){
				/******************************************/
						$C_Taller	= explode('::',$C_TallerCult[$t]);
						
						//echo '<pre>';print_r($C_Taller);
						/*
						[0] => 19--> id taller
						[1] => 20122 -> fecha Inicial
						[2] => 20111 --> Fecha final
						*/
						
						$SQL_Taller='INSERT INTO talleresBienestarEstudiante(id_bienestar,id_taller,periodo_inicial,periodo_fin,tipotaller,codigoperiodo,entrydate,userid)VALUES("'.$id_Bienestar.'","'.$C_Taller[0].'","'.$C_Taller[1].'","'.$C_Taller[2].'",2,"'.$P_General.'",NOW(),"'.$userid.'")';
						
						if($TalleresBienestar=&$db->Execute($SQL_Taller)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar Talleres De Bienestar.....'.$SQL_Taller;
							echo json_encode($a_vectt);
							exit;
						}
					/******************************************/
					}//for
				}
			/******************************************/  
			}//if
								
				/****************************************************************************************/					
			
			}else{
			/*****************************************************************/	
			 $SQL='SELECT 

					idbienestar AS id,
					idestudiantegenral,
					codigoestado
					
					FROM 
					
					bienestar
					
					WHERE
					
					codigoestado=100
					AND
					idestudiantegenral="'.$Estudiante_id.'"
					AND
					codigoperiodo="'.$P_General.'"';
					
				if($ExisteR=&$db->Execute($SQL)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error al Buscar Si Existe Algun Reguistro.....'.$$SQL;
					echo json_encode($a_vectt);
					exit;
					}	
				
				if(!$ExisteR->EOF){
					
					
					$SQL_UP='UPDATE		 bienestar
			
							 SET		 grupoculturales="'.$GrupoCultural.'",
										 periodo_ini_Grup="'.$P_ini_Grupo.'",
										 periodo_fin_Grup="'.$P_fin_Grupo.'",
										 tiposgruposculturales="'.$Tipo_GrupoCultural.'",
										 talleresculturales="'.$TalleresCultura.'",
										 logrosculturales="'.$LogroCultural.'",
										 cuallogrocultural="'.$CualLogrosCulturales.'",
										 periodologro="'.$PeriodoLogroCultural.'",
										 becasculturales="'.$BecaCultural.'",
										 cualbecacultural="'.$CualBecasCulturales.'",
										 periodobecacultural="'.$PeriodoBecasCultural.'"
										 
							 WHERE
							 
										idestudiantegenral="'.$Estudiante_id.'"  
										AND 
										codigoperiodo="'.$P_General.'"  
										AND 
										idbienestar="'.$ExisteR->fields['id'].'" 
										AND  
										codigoestado=100';
										
							if($UpBienestar=&$db->Execute($SQL_UP)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_UP;
								echo json_encode($a_vectt);
								exit;
							}
				/****************************************************************************************/					
					
				if($TalleresCultura==0){
					if($DatoTaller!=''){
					/*********************************************************/
					$C_TallerCult		= explode('-',$DatoTaller);
					
					for($t=1;$t<count($C_TallerCult);$t++){
				/******************************************/
						$C_Taller	= explode('::',$C_TallerCult[$t]);
						
						//echo '<pre>';print_r($C_Taller);
						/*
						[0] => 19--> id taller
						[1] => 20122 -> fecha Inicial
						[2] => 20111 --> Fecha final
						*/
						
						$SQL_Taller='INSERT INTO talleresBienestarEstudiante(id_bienestar,id_taller,periodo_inicial,periodo_fin,tipotaller,codigoperiodo,entrydate,userid)VALUES("'.$ExisteR->fields['id'].'","'.$C_Taller[0].'","'.$C_Taller[1].'","'.$C_Taller[2].'",2,"'.$P_General.'",NOW(),"'.$userid.'")';
						
						if($TalleresBienestar=&$db->Execute($SQL_Taller)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar Talleres De Bienestar.....'.$SQL_Taller;
							echo json_encode($a_vectt);
							exit;
						}
					/******************************************/
					}//for
				}
			/******************************************/  
			}//if
								
				/****************************************************************************************/	
					}else{
						
						$SQL_Insert_Bienestar='INSERT INTO bienestar(idestudiantegenral,grupoculturales,periodo_ini_Grup,periodo_fin_Grup,tiposgruposculturales,talleresculturales,logrosculturales,cuallogrocultural,periodologro,becasculturales,cualbecacultural,periodobecacultural,codigoperiodo,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$GrupoCultural.'","'.$P_ini_Grupo.'","'.$P_fin_Grupo.'","'.$Tipo_GrupoCultural.'","'.$TalleresCultura.'","'.$LogroCultural.'","'.$CualLogrosCulturales.'","'.$PeriodoLogroCultural.'","'.$BecaCultural.'","'.$CualBecasCulturales.'","'.$PeriodoBecasCultural.'","'.$P_General.'",NOW(),"'.$userid.'")';
						
	
				if($InsertBienestar=&$db->Execute($SQL_Insert_Bienestar)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_Insert_Bienestar;
						echo json_encode($a_vectt);
						exit;
					}
					
				/*************************************************/	
				#####################################
				$Last_id_Bienestar=$db->Insert_ID();
				#####################################
				if($TalleresCultura==0){
					/*********************************************************/
					$C_TallerCult		= explode('-',$DatoTaller);
					
					for($t=1;$t<count($C_TallerCult);$t++){
				/******************************************/
						$C_Taller	= explode('::',$C_TallerCult[$t]);
						
						//echo '<pre>';print_r($C_Taller);
						/*
						[0] => 19--> id taller
						[1] => 20122 -> fecha Inicial
						[2] => 20111 --> Fecha final
						*/
						
						$SQL_Taller='INSERT INTO talleresBienestarEstudiante(id_bienestar,id_taller,periodo_inicial,periodo_fin,tipotaller,codigoperiodo,entrydate,userid)VALUES("'.$Last_id_Bienestar.'","'.$C_Taller[0].'","'.$C_Taller[1].'","'.$C_Taller[2].'",2,"'.$P_General.'",NOW(),"'.$userid.'")';
						
						if($TalleresBienestar=&$db->Execute($SQL_Taller)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar Talleres De Bienestar.....'.$SQL_Taller;
							echo json_encode($a_vectt);
							exit;
						}
					/******************************************/
					}//for
					/******************************************/  
					}//if
				/**********************************************/		
				}//if	
			/*****************************************************************/	
			}//if
		
		
		}
                
		/**********Voluntareado *************/
		if($PermisoUsuario==4 || $PermisoUsuario=='4'){
		
		if($id_Bienestar!=''){
			
			$SQL_UP='UPDATE		 bienestar
			
					 SET		 pertenecegrupapoyo="'.$GrupoApoyoB.'",
								 periodoInicialApoyoBienestar="'.$PeriodoInicialApoyo.'",
								 periodoFinalApoyoBienestar="'.$PeriodoFinalApoyo.'",
								 monitorbienestar="'.$MonitorBienestar.'",
								 tipoMonitorBienestar="'.$DatoSeleccionVoluntareado.'",
								 periodoInicialMonitor="'.$F_iniVoluntareado.'",
								 periodoFinalMonitor="'.$F_finVoluntareado.'",
								 pertenecevoluntariado="'.$VoluntariadoB.'",
								 fechaInicialVoluntareado="'.$FechaInicialVoluntareado.'",
								 fechaFinalVoluntareado="'.$FechaFinalVoluntareado.'"
								 
					 WHERE
					 
								idestudiantegenral="'.$Estudiante_id.'"  
								AND 
								codigoperiodo="'.$P_General.'"  
								AND 
								idbienestar="'.$id_Bienestar.'" 
								AND  
								codigoestado=100';
								
					if($UpBienestar=&$db->Execute($SQL_UP)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_UP;
						echo json_encode($a_vectt);
						exit;
					}						
			
			}else{
			/*****************************************************************/	
			 $SQL='SELECT 

					idbienestar AS id,
					idestudiantegenral,
					codigoestado
					
					FROM 
					
					bienestar
					
					WHERE
					
					codigoestado=100
					AND
					idestudiantegenral="'.$Estudiante_id.'"
					AND
					codigoperiodo="'.$P_General.'"';
					
				if($ExisteR=&$db->Execute($SQL)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error al Buscar Si Existe Algun Reguistro.....'.$$SQL;
					echo json_encode($a_vectt);
					exit;
					}	
				
				if(!$ExisteR->EOF){
					
					
					$SQL_UP='UPDATE		 bienestar
			
							 SET		 pertenecegrupapoyo="'.$GrupoApoyoB.'",
										 periodoInicialApoyoBienestar="'.$PeriodoInicialApoyo.'",
										 periodoFinalApoyoBienestar="'.$PeriodoFinalApoyo.'",
										 monitorbienestar="'.$MonitorBienestar.'",
										 tipoMonitorBienestar="'.$DatoSeleccionVoluntareado.'",
										 periodoInicialMonitor="'.$F_iniVoluntareado.'",
										 periodoFinalMonitor="'.$F_finVoluntareado.'",
										 pertenecevoluntariado="'.$VoluntariadoB.'",
										 fechaInicialVoluntareado="'.$FechaInicialVoluntareado.'",
										 fechaFinalVoluntareado="'.$FechaFinalVoluntareado.'"
										 
							 WHERE
							 
										idestudiantegenral="'.$Estudiante_id.'"  
										AND 
										codigoperiodo="'.$P_General.'"  
										AND 
										idbienestar="'.$ExisteR->fields['id'].'" 
										AND  
										codigoestado=100';
										
							if($UpBienestar=&$db->Execute($SQL_UP)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_UP;
								echo json_encode($a_vectt);
								exit;
							}
					}else{
						
						$SQL_Insert_Bienestar='INSERT INTO bienestar(idestudiantegenral,pertenecegrupapoyo,periodoInicialApoyoBienestar,periodoFinalApoyoBienestar
                                                    ,monitorbienestar,tipoMonitorBienestar,periodoInicialMonitor,periodoFinalMonitor,pertenecevoluntariado,fechaInicialVoluntareado
                                                    ,fechaFinalVoluntareado,codigoperiodo,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$GrupoApoyoB.'","'.$PeriodoInicialApoyo.'","'.$PeriodoFinalApoyo.'","'.$MonitorBienestar.'","'.$DatoSeleccionVoluntareado.'","'.$F_iniVoluntareado.'","'.$F_finVoluntareado.'","'.$VoluntariadoB.'","'.$FechaInicialVoluntareado.'","'.$FechaFinalVoluntareado.'","'.$P_General.'",NOW(),"'.$userid.'")';
						
	
				if($InsertBienestar=&$db->Execute($SQL_Insert_Bienestar)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_Insert_Bienestar;
						echo json_encode($a_vectt);
						exit;
					}
					
				/*************************************************/	
				#####################################
				$Last_id_Bienestar=$db->Insert_ID();
				#####################################
				/**********************************************/		
				}//if	
			/*****************************************************************/	
			}//if
		
		
		}
		
		$a_vectt['val']			='TRUE';
		echo json_encode($a_vectt);
		exit;
				
		die;	
		/************************************************/
		$SQL_Insert_Bienestar='INSERT INTO bienestar(idestudiantegenral,participaseleccionesuniversidad,tiposeleccion,apoyouniversidad,tiposcompetenciasapoyada,talleresformativos,tipotalleres,logrosdeportuniversidad,logrodeportcual,periodologrodeport,becasestimulosbienestar,becasestimuloscual,periodobecadeport,asistegym,frecuenciagym,clubrunning,fechavinculacionrunning,clubcaminantes,fechavinculacioncaminantes,asesoriapsicologica,medicinageneral,medicinadeporte,promocionprevencion,incapacidad,accidenteuniversidad,fechaaccidente,usosegurouniversidad,grupoculturales,tiposgruposculturales,talleresculturales,tipotalleresculturales,pertenecevoluntariado,pertenecegrupapoyo,monitorbienestar,logrosculturales,cuallogrocultural,periodologro,becasculturales,cualbecacultural,periodobecacultural,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$Selecion_U.'","'.$Tipo_Selecion.'","'.$Competencias_U.'","'.$Tipo_Competencia.'","'.$Talleres.'","'.$Tipo_Taller.'","'.$LogroDeportivo.'","'.$Cual_LogroDeportivo.'","'.$PeriodoLogroDeport.'","'.$BecasEstimos.'"    ,"'.$Cual_BecaEstimulo.'","'.$PeriodoBecasDeport.'","'.$Gimnasio.'","'.$Frecuenca_Gym.'","'.$ClubRunning.'","'.$FechaVinculacion.'","'.$ClubCaminantes.'"  ,"'.$FechaVinculacionCaminantes.'","'.$Num_Ase_Psico.'","'.$Num_MedGeneral.'","'.$Num_MedDeporte.'","'.$Num_PromoPlaneacion.'","0","'.$Acidente_U.'","'.$Fecha_Accidente.'","'.$Uso_Seguro.'","'.$GrupoCultural.'","'.$Tipo_GrupoCultural.'","'.$TalleresCultura.'","'.$Tipo_CulturaTaller.'","'.$Voluntariado.'","'.$GrupoApoyo.'","'.$MonitoBienestar.'","'.$LogroCultural.'","'.$CualLogrosCulturales.'","'.$PeriodoLogroCultural.'","'.$BecaCultural.'","'.$CualBecasCulturales.'","'.$PeriodoBecasCultural.'","NOW()","'.$userid.'")';
		
				if($InsertBienestar=&$db->Execute($SQL_Insert_Bienestar)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar Bienestar Universitario.....'.$SQL_Insert_Bienestar;
						echo json_encode($a_vectt);
						exit;
					}
		
		/*Preguntar sobre incapacidad*/
		
		#####################################
		$Last_id_Bienestar=$db->Insert_ID();
		#####################################
		
		$D_Incapacidad = explode('_',$CadenaIncapacidad);
		
		#echo '<pre>';print_r($D_Incapacidad);
		
		for($i=1;$i<count($D_Incapacidad);$i++){
			/*********************************************************/
				$C_incapacidad = explode('::',$D_Incapacidad[$i]);
				
				#echo '<pre>';print_r($C_incapacidad);
				
				$SQL_InsertIncapacida='INSERT INTO  detalleincapacidad(idbienestar,fechainicio,fechafinal,motivo,entrydate,userid)VALUES("'.$Last_id_Bienestar.'","'.$C_incapacidad[0].'","'.$C_incapacidad[1].'","'.$C_incapacidad[2].'","NOW()","'.$userid.'")';
				
							if($Bienestar=&$db->Execute($SQL_InsertIncapacida)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar Incapacida.....'.$SQL_InsertIncapacida;
									echo json_encode($a_vectt);
									exit;
								}
				
			/*********************************************************/
			}
		
		
	}/*Bienestar*/


/***********************************Organos De Gobierno*****************************************************/		

	if($OrgaGobierno==1	|| $OrgaGobierno=='1'){

		$SQL_insert_OrganosGobierno='INSERT INTO OrganosGobierno(idestudiantegeneral,representantesemestre,consejofacultad,consejoacademico,consejodirectivo,userid,entrydate)VALUES("'.$Estudiante_id.'","'.$Representante.'","'.$ConsejoFacul.'","'.$ConsejoAcad.'","'.$ConsejoDir.'","'.$userid.'",NOW())';
		
		
					if($InsertOrganosGobierno=&$db->Execute($SQL_insert_OrganosGobierno)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar Organos de Gobierno.....'.$SQL_insert_OrganosGobierno;
							echo json_encode($a_vectt);
							exit;
						}
		
		
	}/*OrganosGobierno*/
/**********************************Actividades de Investigacion**********************************************/		

	
	if($InvesActividad==1 || $InvesActividad=='1'){
	
		$SQL_insert_Investigacion='INSERT INTO actividadesInvestigacion(idestudiantegeneral,actividainvestigacion,semillero,auxiliarinvestigacion,publicacionesinternas,publicacionesexternas,eventosinvestigacion,congresoselbosque,congresoslocales,congresosnacionales,congresosinternacionales,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$Investiga.'","'.$Semillero.'","'.$Asistente.'","'.$Publicaciones.'","'.$PublicacionExt.'","'.$AsisEventos.'","'.$PonenteCongreso.'","'.$PonenteLocal.'","'.$PonenteNacional.'","'.$PonenteInternacional.'",NOW(),"'.$userid.'")';
		
		
					if($InsertInvestigacion=&$db->Execute($SQL_insert_Investigacion)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar Actividades de Investigacion.....'.$SQL_insert_Investigacion;
							echo json_encode($a_vectt);
							exit;
						}
		
		
		
		
		#####################################
		$Last_id_Investigacion=$db->Insert_ID();
		#####################################
		
		if($Semillero==0 || $Semillero=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,nombre,fechaini,fechafin,dependencia,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","1","'.$Nom_Semillero.'","'.$FechainicialSemillero.'","'.$FechaFinSemillero.'","'.$Dependencia.'",NOW(),"'.$userid.'")';
				
						if($InsertSemillero=&$db->Execute($SQL_Insert_Detalle)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar El Destalle del Semillero....'.$SQL_Insert_Detalle;
								echo json_encode($a_vectt);
								exit;
							}
			
			}
			
		if($Asistente==0 || $Asistente=='0'){
			
			$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,nombre,docenteresponsable,fechaini,fechafin,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","2","'.$NombreProyecto_invg.'","'.$DocenteResp_invg.'","'.$Fechainicio_invg.'","'.$Fechafin_invg.'",NOW(),"'.$userid.'")';
			
						if($InsertAsistente=&$db->Execute($SQL_Insert_Detalle)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar El Destalle del Auxiliar De Investigacion....'.$SQL_Insert_Detalle;
								echo json_encode($a_vectt);
								exit;
							}
			
			}	
		
		if($Publicaciones==0 || $Publicaciones=='0'){
			
			$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,autor,nombre,coautor,entidadeditora,otrorol,cualrol,tipopublicacion,cualpublicacion,indexada,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","3","'.$Autor_Publicacion.'","'.$Nom_Publicacion.'","'.$Coautor_Publicacion.'","'.$Editorial_Publicacion.'","'.$Rol.'","'.$Cual_Rol.'","'.$TipoPublicacion.'","'.$Otra_publicTipo.'","'.$Indexada.'",NOW(),"'.$userid.'")';
			
			
						if($InsertPublicaciones=&$db->Execute($SQL_Insert_Detalle)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar El Destalle del Publicaciones Internas...'.$SQL_Insert_Detalle;
								echo json_encode($a_vectt);
								exit;
							}
			
			}
			
		if($PublicacionExt==0 || $PublicacionExt=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,autor,nombre,coautor,entidadeditora,otrorol,cualrol,tipopublicacion,cualpublicacion,indexada,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","4","'.$Autor_PublicacionExt.'","'.$Nom_PublicacionExt.'","'.$Coautor_PublicacionExt.'","'.$Entidad_PublicacionExt.'","'.$Rol_ext.'","'.$CualRol_PublicacionExt.'","'.$TipoPublicacion_Ext.'","'.$Otra_publicTipoExt.'","'.$Indexsada_Ext.'",NOW(),"'.$userid.'")';
				
						if($InsertPublicacionExt=&$db->Execute($SQL_Insert_Detalle)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error al Insertar El Destalle del Publicacion Externas ...'.$SQL_Insert_Detalle;
								echo json_encode($a_vectt);
								exit;
							}
			
			}
			
		if($AsisEventos==0 || $AsisEventos=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,fechaini,fechafin,nombre,dependencia,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","5","'.$Fechaini_Evento.'","'.$Fechafin_Evento.'","'.$Nom_evento.'","'.$Nom_EntidadOrg.'",NOW(),"'.$userid.'")';
				
							if($InsertAsisEventos=&$db->Execute($SQL_Insert_Detalle)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar El Destalle del Asiste a Eventos de Investigacion...'.$SQL_Insert_Detalle;
									echo json_encode($a_vectt);
									exit;
								}
			
			}	
			
		if($PonenteCongreso==0 || $PonenteCongreso=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,fechaini,fechafin,nombre,nombreponencia,dependencia,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","6","'.$Fechaini_CongBosque.'","'.$Fechafin_CongBosque.'","'.$NomEvento_CongBosque.'","'.$NomPonencia_CongBosque.'","'.$Dependencia_CongBosque.'",NOW(),"'.$userid.'")';
				
						if($InsertPonenteCongreso=&$db->Execute($SQL_Insert_Detalle)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar El Destalle del Ponente Congresos U El Bosque...'.$SQL_Insert_Detalle;
									echo json_encode($a_vectt);
									exit;
								}
			
			}	
		
		if($PonenteLocal==0 || $PonenteLocal=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,fechaini,fechafin,nombre,nombreponencia,dependencia,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","7","'.$Fechaini_Congreso.'","'.$Fechafin_Congreso.'","'.$NomEvento_Congreso.'","'.$NomPonencia_Congreso.'","'.$Entidad_CongresoLocal.'",NOW(),"'.$userid.'")';
				
							if($InsertPonenteLocal=&$db->Execute($SQL_Insert_Detalle)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar El Destalle del Ponente Congresos Locales Bogota...'.$SQL_Insert_Detalle;
									echo json_encode($a_vectt);
									exit;
								}
			
			}	
			
		if($PonenteNacional==0 || $PonenteNacional=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,fechaini,fechafin,nombre,nombreponencia,dependencia,ciudad,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","8","'.$Fechaini_CongNal.'","'.$Fechafin_CongNal.'","'.$NomEvento_CongNal.'","'.$NomPonencia_CongNal.'","'.$Entidad_CongresoNal.'","'.$id_CityCongreso.'",NOW(),"'.$userid.'")';
				
							if($InsertPonenteNacional=&$db->Execute($SQL_Insert_Detalle)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar El Destalle del Ponente Congresos Nacional...'.$SQL_Insert_Detalle;
									echo json_encode($a_vectt);
									exit;
								}
			
			}
			
		if($PonenteInternacional==0 || $PonenteInternacional=='0'){
			
				$SQL_Insert_Detalle='INSERT INTO  detalleactividadesinvestigacion(idactividadinvestigacion,tipo,fechaini,fechafin,nombre,nombreponencia,dependencia,ciudad,pais,entrydate,userid)VALUES("'.$Last_id_Investigacion.'","9","'.$Fechaini_CongInter.'","'.$Fechafin_CongInter.'","'.$NomEvento_CongInter.'","'.$NomPonencia_CongInter.'","'.$Entidad_CongInter.'","'.$id_CityCongInter.'","'.$id_Pais.'",NOW(),"'.$userid.'")';
				
						if($InsertPonenteInternacional=&$db->Execute($SQL_Insert_Detalle)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar El Destalle del Ponente Congresos InterNacional...'.$SQL_Insert_Detalle;
									echo json_encode($a_vectt);
									exit;
								}
			
			}
			
	}/*Investioga Activida*/
		$a_vectt['val']			='TRUE';
		echo json_encode($a_vectt);
		exit;					

/************************************************************************************************************/

		}break;
	case 'AutoCompletePais':{
		
		 MainJson();
		 global $userid,$db,$Estudiante_id;	
		
		 $Letra   = $_REQUEST['term'];
		
		 $SQL_Pais='SELECT 
					
					idpais,
					nombrepais
					
					FROM 
					
					pais
					
					WHERE
					
					nombrepais LIKE "%'.$Letra.'%"
					AND
					codigoestado=100';
					
				if($Pais=&$db->Execute($SQL_Pais)===false){
						echo 'Error en el SQL Del Pais.....<br>'.$SQL_Pais;
						die;
					}	
					
					
				$Result_F = array();
						
				while(!$Pais->EOF){
						$Rf_Vectt['label']=$Pais->fields['nombrepais']; 
						$Rf_Vectt['value']=$Pais->fields['nombrepais'];
						
						$Rf_Vectt['id_Pais']=$Pais->fields['idpais'];
						
						array_push($Result_F,$Rf_Vectt);
					$Pais->MoveNext();	
					}	
					
			echo json_encode($Result_F);					
		
		}break;
	case 'Administrativo':{
		global $C_Hoja_Vida,$userid,$db,$rol_Usuario;
		define(AJAX,'ADMIN');
		define(BIENVENIDA,'FALSE');	
			MainGeneral();
			JsGenral();
			
			
			//echo 'userid->'.$userid;
			//echo '<pre>';print_r($_SESSION);
			
			$SQL_Rol='SELECT UR.idrol FROM usuariorol UR inner join UsuarioTipo UT ON ( UR.idusuariotipo = UT.UsuarioTipoId) inner join usuario U ON (UT.UsuarioId = U.idusuario) WHERE U.usuario ="'.$_SESSION['MM_Username'].'"';
			
			if($Rol_Admin=&$db->Execute($SQL_Rol)===false){
					echo 'Error en el SQL de Rol DEl Admin.....<br><br>'.$SQL_Rol;
					die;
				}
			
		    $Estudiante_id = $_GET['Estudiante_id'];
			
			$AdminRol		= $Rol_Admin->fields['idrol'];	
		
			
			
			$codigoEstudiante	= $_REQUEST['?codigoestudiante'];
			
			$SQL='SELECT idestudiantegeneral FROM estudiante WHERE codigoestudiante = "'.$codigoEstudiante.'"';
			
			if($C_Estudiante=&$db->Execute($SQL)===false){
					echo 'Error en el SQL <br><br>'.$SQL;
					die;
				}
			
			$Estudiante_id	= $C_Estudiante->fields['idestudiantegeneral'];
			
			/*echo '$AdminRol->'.$AdminRol;
			echo '<br>Estudiante_id->'.$Estudiante_id;*/
			
			$C_Hoja_Vida->SegundaPagina($Estudiante_id,$AdminRol);
		
		}break;
	case 'EdadValor':{
		MainGeneral();
		#JsGenral();
			
		global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		
		$dato  = $_GET['dato'];
		
		echo $Respuesta = edad($dato);
		
		}break;
	case 'Dirrecto':{
		
			define(AJAX,'FALSE');
			define(BIENVENIDA,'False');
			MainGeneral();
			JsGenral();
			
			global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
			
			#Rol 1-->Estudiantes
            
            $userid= '19725';
            
			$year = date('Y');
			$monunt = date('m');
			
			if($monunt<6){
					$Periodo_num = '1';
				}else{
						$Periodo_num = '2';
					}
					
			$CodigoPeriodo = $year.''.$Periodo_num;		
			############################################################
								
			
			############################################################  
			   $SQL_Estudiante='SELECT 

								numerodocumento,
								codigorol,
								tipodocumento
								
								FROM 
								
								usuario
								
								WHERE
								
								idusuario="'.$userid.'"
								AND
								codigoestadousuario=100
								AND
								codigorol=1';
								
								
							if($EstudiantTipoUser=&$db->Execute($SQL_Estudiante)===false){
									echo 'Error en el SQl del ususario estudiante....<br>'.$SQL_Estudiante;
									die;
								}	
							
				
				if(!$EstudiantTipoUser->EOF){
					
						 /*$SQL_idEstudiante='SELECT

											numerodocumento,
											idestudiantegeneral AS id
											
											FROM 
											
											estudiantegeneral
											
											WHERE
											
											numerodocumento="'.$EstudiantTipoUser->fields['numerodocumento'].'"';
											
									if($Estudiante=&$db->Execute($SQL_idEstudiante)===false){
											echo 'Error en el SQl del Id estudiante general....<br>'.$SQL_idEstudiante;
											die;
										}*/		
						
						
						$C_Hoja_Vida->Principal($Estudiante_id);		
					}else{
					  		echo '<blink><strong style="color:#F00; font-size:18px">Su Usuario del Sistema No es de Estudiante...</strong></blink>';
							exit();
						}
				
			
		
		}break;
	case 'SaveFinal':{
		MainJson();
		 global $userid,$db,$Estudiante_id;		
		
		$Estudiante_id      			= $_GET['Estudiante_id'];
		$Trabaja						= $_GET['Trabaja'];
		$tipo_Contrato					= $_GET['tipo_Contrato'];
		$Relacion_Trabajo				= $_GET['Relacion_Trabajo'];
		$tipoEmpresa					= $_GET['tipoEmpresa'];
		$RedInternacional 				= $_GET['RedInternacional'];
		$Nom_RedInter 					= $_GET['Nom_RedInter'];
		$Pais_Inter		 				= $_GET['Pais_Inter'];
		$Ciudad_Inter	 				= $_GET['Ciudad_Inter'];
		$FechaInicoRed	 				= $_GET['FechaInicoRed'];
		$FechaFinred	 				= $_GET['FechaFinred'];
		$RedVirtual		 				= $_GET['RedVirtual'];
		$Nom_RedVirtual	 				= $_GET['Nom_RedVirtual'];
		$Pais_Virtual	 				= $_GET['Pais_Virtual'];
		$Ciudad_Virtual 				= $_GET['Ciudad_Virtual'];
		$FechaInicoVirtual 				= $_GET['FechaInicoVirtual'];
		$FechaFinVirtual 				= $_GET['FechaFinVirtual'];
		$CursoLocal		 				= $_GET['CursoLocal'];
		$Nom_Universidad 				= $_GET['Nom_Universidad'];
		$Nom_Curso		 				= $_GET['Nom_Curso'];
		$FechaInicoCurso 				= $_GET['FechaInicoCurso'];
		$FechaFinCurso	 				= $_GET['FechaFinCurso'];
		$CursoNacional	 				= $_GET['CursoNacional'];
		$Nom_UniversidadOtra			= $_GET['Nom_UniversidadOtra'];
		$Nom_OtroCurso	 				= $_GET['Nom_OtroCurso'];
		$FechaInicoOtroCurso			= $_GET['FechaInicoOtroCurso'];
		$FechaFinOtroCurso 				= $_GET['FechaFinOtroCurso'];
		$CursoInternacional				= $_GET['CursoInternacional'];
		$Fre_inter		 				= $_GET['Fre_inter'];
		$UJoinUs		 				= $_GET['UJoinUs'];
		$Fre_UJoinUs	 				= $_GET['Fre_UJoinUs'];
		$Collaborate	 				= $_GET['Collaborate'];
		$Fre_Collaborate 				= $_GET['Fre_Collaborate'];
		$Sittio			 				= $_GET['Sittio'];
		$Fre_Sittio		 				= $_GET['Fre_Sittio'];		
		
		
		
	
															
		
		
		$SQL_EstudianteLaboral='INSERT INTO  estudianteactividalaboral(idestudiantegeneral,trabaja,tipocontrato,trabajorelacionadoestudio,tipoempresa,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$Trabaja.'","'.$tipo_Contrato.'","'.$Relacion_Trabajo.'","'.$tipoEmpresa.'",NOW(),"'.$userid.'")';
		
				
				if($InsertTrabajo=&$db->Execute($SQL_EstudianteLaboral)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_EstudianteLaboral;
						echo json_encode($a_vectt);
						exit;
					}
					
		###################################################################################################			
					
		$SQL_Movilidad='INSERT INTO  estudiantemovilidad(idestudiantegeneral,redinternacional,redvirtual,cursosotrasuniversidad,cursouniversidadnacional,cursouniversidaextranjera,frecuenciacursoextranjera,usoplataformaujoinus,frecuenciaujoinus,plataformacollaborate,frecuenciacollaborate,usoplataformasittio,frecuenciasittio,entrydate,userid)VALUES("'.$Estudiante_id.'","'.$RedInternacional.'","'.$RedVirtual.'","'.$CursoLocal.'","'.$CursoNacional.'","'.$CursoInternacional.'","'.$Fre_inter.'","'.$UJoinUs.'","'.$Fre_UJoinUs.'","'.$Collaborate.'","'.$Fre_Collaborate.'","'.$Sittio.'","'.$Fre_Sittio.'",NOW(),"'.$userid.'")';			
					
			
				if($InsertMovilidad=&$db->Execute($SQL_Movilidad)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Movilidad;
						echo json_encode($a_vectt);
						exit;
					}
			
			
			
				##################################
				$LastIdMovilidad=$db->Insert_ID();
				##################################	
			
			if($RedInternacional==0){
					
					$Tipo_Movilidad = 1;
					
					$SQL_Detalle = 'INSERT INTO  detallemovilidad(idestudiantemovilidad,tipomovilidad,nombrered,piasred,ciudadred,fechainicio,fechafin,entrydate,userid)VALUES("'.$LastIdMovilidad.'","'.$Tipo_Movilidad.'","'.$Nom_RedInter.'","'.$Pais_Inter.'","'.$Ciudad_Inter.'","'.$FechaInicoRed.'","'.$FechaFinred.'",NOW(),"'.$userid.'")';
					
					
					if($InsertDetalleMovilidad=&$db->Execute($SQL_Detalle)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Detalle;
							echo json_encode($a_vectt);
							exit;
						}
				
				}
				
			if($RedVirtual==0){
					
					$Tipo_Movilidad = 2;
					
					$SQL_Detalle = 'INSERT INTO  detallemovilidad(idestudiantemovilidad,tipomovilidad,nombrered,piasred,ciudadred,fechainicio,fechafin,entrydate,userid)VALUES("'.$LastIdMovilidad.'","'.$Tipo_Movilidad.'","'.$Nom_RedVirtual.'","'.$Pais_Virtual.'","'.$Ciudad_Virtual.'","'.$FechaInicoVirtual.'","'.$FechaFinVirtual.'",NOW(),"'.$userid.'")';
					
					
					if($InsertDetalleMovilidad=&$db->Execute($SQL_Detalle)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Detalle;
							echo json_encode($a_vectt);
							exit;
						}
				
				}	
			
			if($CursoLocal==0){
					
					$Tipo_Movilidad = 3;
					
					$SQL_Detalle = 'INSERT INTO  detallemovilidad(idestudiantemovilidad,tipomovilidad,universidad,nombrecurso,fechainicio,fechafin,entrydate,userid)VALUES("'.$LastIdMovilidad.'","'.$Tipo_Movilidad.'","'.$Nom_Universidad.'","'.$Nom_Curso.'","'.$FechaInicoCurso.'","'.$FechaFinCurso.'",NOW(),"'.$userid.'")';
					
					
					if($InsertDetalleMovilidad=&$db->Execute($SQL_Detalle)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Detalle;
							echo json_encode($a_vectt);
							exit;
						}
				
				}	
				
			if($CursoNacional==0){
					
					$Tipo_Movilidad = 4;
					
					$SQL_Detalle = 'INSERT INTO  detallemovilidad(idestudiantemovilidad,tipomovilidad,universidad,nombrecurso,fechainicio,fechafin,entrydate,userid)VALUES("'.$LastIdMovilidad.'","'.$Tipo_Movilidad.'","'.$Nom_UniversidadOtra.'","'.$Nom_OtroCurso.'","'.$FechaInicoOtroCurso.'","'.$FechaFinOtroCurso.'",NOW(),"'.$userid.'")';
					
					
					if($InsertDetalleMovilidad=&$db->Execute($SQL_Detalle)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Detalle;
							echo json_encode($a_vectt);
							exit;
						}
				
				}			
			
		
		
		$year = date('Y');
			$monunt = date('m');
			
			if($monunt<6){
					$Periodo_num = '1';
				}else{
						$Periodo_num = '2';
					}
					
			$CodigoPeriodo = $year.''.$Periodo_num;	
			
						$SQL_ValidaExtra='SELECT 

										idactualizacionusuario AS id,
										estadoactualizacion
								
								FROM 
								
										actualizacionusuario
								
								WHERE
								
										usuarioid="'.$userid.'"
										AND
										codigoperiodo="'.$CodigoPeriodo.'"
										AND
										tipoactualizacion=1
										AND
										codigoestado=200';
								
								if($ValidacionExistencia=&$db->Execute($SQL_ValidaExtra)===false){
										echo 'Error en el SQl del ususario estudiante Actualizacion....<br>'.$SQL_ValidaExtra;
										die;
									}
									
		if(!$ValidacionExistencia->EOF){
			
			$SQL_Update='UPDATE  actualizacionusuario
			
						 SET     changedate=NOW(),
						 	     codigoestado=100
								 
						 WHERE   idactualizacionusuario="'.$ValidacionExistencia->fields['id'].'"';
						 
						 if($InsertActualizacion=&$db->Execute($SQL_Update)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Update;
							echo json_encode($a_vectt);
							exit;
						}
			
			}else{							
				
		$SQL_Actualizar='INSERT INTO actualizacionusuario(usuarioid,tipoactualizacion,codigoperiodo,estadoactualizacion,userid,entrydate)VALUES("'.$userid.'",1,"'.$CodigoPeriodo.'",1,"'.$userid.'",NOW())';	
		
				
					if($InsertActualizacion=&$db->Execute($SQL_Actualizar)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_Actualizar;
							echo json_encode($a_vectt);
							exit;
						}
			}
		###################################################################################################
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error al Insertar el Registro del Estudiante.....'.$SQL_EstudianteLaboral;
				echo json_encode($a_vectt);
				exit;
		
		
		}break;
	case 'ModificaPlastico':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$Frecuencia				= $_GET['Frecuencia'];
		
		
		$SQL_ModificaPlastico='UPDATE	estudiantearteplastica	
							
							   SET		frecuenciaplastica="'.$Frecuencia.'",
							   			useriestado="'.$userid.'",
										changedate=NOW()
							 
							   WHERE	idestudiantearteplastica="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'"  AND  codigoestado=100';
							   
							   
							   if($ModificarPlastico=&$db->Execute($SQL_ModificaPlastico)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar  del Registro del Estudiante.....'.$SQL_ModificaPlastico;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;		
		
		
		}break;
	case 'DeletePlastico':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$CodigoEstado			= $_GET['CodigoEstado'];
		
		
		  $SQL_DeletePlastico='UPDATE	estudiantearteplastica	
							
							   SET		codigoestado="'.$codigoestado.'",
							   			useriestado="'.$userid.'",
										changedate=NOW()
							 
							   WHERE	idestudiantearteplastica="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'"';
							   
							 if($DeletePlastico=&$db->Execute($SQL_DeletePlastico)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar  del Registro del Estudiante.....'.$SQL_DeletePlastico;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;		
		
		}break;
	case 'ModificaLirica':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$Frecuencia				= $_GET['Frecuencia'];
		
		
		  $SQL_ModificaLirica='UPDATE	estudiantearteliterario
						
							   SET		frecuencialiteraria="'.$Frecuencia.'",
										useridestado="'.$userid.'",
										changedate=NOW()
							   
							   WHERE	idestudiantearteliterario="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'"  AND  codigoestado=100';
							   
							   if($ModificarLirico=&$db->Execute($SQL_ModificaLirica)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar  del Registro del Estudiante.....'.$SQL_ModificaLirica;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;		
							   
		
		}break;
	case 'DeleteLirico':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$CodigoEstado			= $_GET['CodigoEstado'];
		
		
		$SQL_DeleteLirico='UPDATE	estudiantearteliterario
						
						   SET		codigoestado="'.$CodigoEstado.'",
						   			useridestado="'.$userid.'",
									changedate=NOW()
						   
						   WHERE	idestudiantearteliterario="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'"';
						   
						   if($DeleteLirico=&$db->Execute($SQL_DeleteLirico)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar  del Registro del Estudiante.....'.$SQL_DeleteLirico;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			
						   
		
		}break;
	case 'ModificaEscena':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$Frecuencia				= $_GET['Frecuencia'];
		
		
		 $SQL_ModificarEscena='UPDATE	estudianteartesescenicas
							
							   SET		frecuanciaescenica="'.$Frecuencia.'",
										useriestado="'.$userid.'",
										changedate=NOW()
							   
							   WHERE	idestudiantesartesescenicas="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'" AND codigoestado=100';
							   
							   
							   if($ModifcarEscenica=&$db->Execute($SQL_ModificarEscena)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar  del Registro del Estudiante.....'.$SQL_ModificarEscena;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			
		
		
		}break;
	case 'DeleteEscena':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$CodigoEstado			= $_GET['CodigoEstado'];
		
		
		$SQL_EscenaDelete='UPDATE	estudianteartesescenicas
							
						   SET		codigoestado="'.$CodigoEstado.'",
						   			useriestado="'.$userid.'",
									changedate=NOW()
						   
						   WHERE	idestudiantesartesescenicas="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'"';
						   
						    if($DeleteEscenica=&$db->Execute($SQL_EscenaDelete)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar El codigo Estado del Registro del Estudiante.....'.$SQL_EscenaDelete;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			
		
		
		}break;
	case 'ModificaDanza':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$Frecuencia				= $_GET['Frecuencia'];
		
		
		$SQL_ModificarDanza='UPDATE	estudianteexprecioncorporal
		
							 SET	frecuenciaexprecion="'.$Frecuencia.'",
									useridestado="'.$userid.'",
									changedate=NOW()
										
							 WHERE	idestudianteexprecioncorporal="'.$registro_id.'" AND idestudiantegeneral="'.$Estudiante_id.'" AND codigoestado=100';
							 
							  if($ModificarDanza=&$db->Execute($SQL_ModificarDanza)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Cambiar O MOdifcar del Registro del Estudiante.....'.$SQL_ModificarDanza;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			
		
		
		}break;
	case 'DeleteDanza':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$CodigoEstado			= $_GET['CodigoEstado'];
		
		
		$SQL_DanzaDelet='UPDATE	estudianteexprecioncorporal
		
						 SET	codigoestado="'.$CodigoEstado.'",
						 		useridestado="'.$userid.'",
								changedate=NOW()
						 			
						 WHERE	idestudianteexprecioncorporal="'.$registro_id.'" AND idestudiantegeneral="'.$Estudiante_id.'"';
						 
						 
						 
						   if($DeleteDanza=&$db->Execute($SQL_DanzaDelet)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error el Cambio de estado del Registro del Estudiante.....'.$SQL_DanzaDelet;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			
		
		
		}break;
	case 'ModificaMusica':{
		MainJson();
		global $db,$userid;
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$Frecuencia				= $_GET['Frecuencia'];
		
		  $SQL_MusicaModifica='UPDATE	estudiantemusica
			
							   SET		frecuenciainstrumento="'.$Frecuencia.'",
										useridestado="'.$userid.'",
										changedate=NOW()
										
							   WHERE	idestudiantemusica="'.$registro_id.'" AND idestudiantegeneral="'.$Estudiante_id.'" AND codigoestado=100';
						   
						   
						   if($UpdateMusica=&$db->Execute($SQL_MusicaModifica)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificar Musica del Registro del Estudiante.....'.$SQL_MusicaModifica;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			   														  
		
		}break;
	case 'DeleteMusica':{
		MainJson();
		global $db,$userid;
		
		
		$registro_id			= $_GET['registro_id'];
		$Estudiante_id			= $_GET['Estudiante_id'];
		$CodigoEstado			= $_GET['CodigoEstado'];
		
		
		$SQL_MusicaDelete='UPDATE	estudiantemusica
		
						   SET		codigoestado="'.$CodigoEstado.'",
						   			useridestado="'.$userid.'",
									changedate=NOW()
									
						   WHERE	idestudiantemusica="'.$registro_id.'" AND idestudiantegeneral="'.$Estudiante_id.'"';
						   
						   
						   if($UpdateMusica=&$db->Execute($SQL_MusicaDelete)===FALSE){
							   		$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Elimar Musica del Registro del Estudiante.....'.$SQL_MusicaDelete;
									echo json_encode($a_vectt);
									exit;
							   }		
							   
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_MusicaDelete;
				echo json_encode($a_vectt);
				exit;			   
		
		}break;
	case 'ModificaDeporte':{
		MainJson();
		global $db,$userid;
		
		$registro_id				= $_GET['registro_id'];
		$Estudiante_id				= $_GET['Estudiante_id'];
		$Frecuencia					= $_GET['Frecuencia'];
		
		
		$SQL_DeleteDeporte='UPDATE	estudiantedeporte
							SET		frecuenciadeporte="'.$Frecuencia.'",
									useridestado="'.$userid.'",
									changedate=NOW()
									
							WHERE	idestudiantedeporte="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'"  AND codigoestado=100';
							
							
							 if($DeleteDeporte=&$db->Execute($SQL_DeleteDeporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_DeleteDeporte;
									echo json_encode($a_vectt);
									exit;
								}
				
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateVacunas;
				echo json_encode($a_vectt);
				exit;		
		
		
		
		}break;
	case 'DeleteDeporte':{
		MainJson();
		global $db,$userid;
		
		$registro_id				= $_GET['registro_id'];
		$Estudiante_id				= $_GET['Estudiante_id'];
		$codigoestado				= $_GET['codigoestado'];
		
		
		$SQL_DeleteDeporte='UPDATE	estudiantedeporte
							SET		codigoestado="'.$codigoestado.'",
									useridestado="'.$userid.'",
									changedate=NOW()
									
							WHERE	idestudiantedeporte="'.$registro_id.'"  AND  idestudiantegeneral="'.$Estudiante_id.'" ';
							
							
							 if($DeleteDeporte=&$db->Execute($SQL_DeleteDeporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Elimar El Deporte del Registro del Estudiante.....'.$SQL_DeleteDeporte;
									echo json_encode($a_vectt);
									exit;
								}
				
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateVacunas;
				echo json_encode($a_vectt);
				exit;					
		
																		
		}break;
	case 'UpdateHabitoAlimeto':{
		MainJson();
		global $db,$userid;
		
		$Estudiante_id             		= $_GET['Estudiante_id'];
		$id_HabitosSaludables      		= $_GET['id_HabitosSaludables'];
		$vegetariano					= $_GET['vegetariano'];
		$Fuma   						= $_GET['Fuma'];
		$Frecuencia_fuma  				= $_GET['Frecuencia_fuma'];
		$Alcohol						= $_GET['Alcohol'];
		$Frecuencia_Alcohol				= $_GET['Frecuencia_Alcohol'];
		
		
		$SQL_UpdateHabitoAlimento='UPDATE	estudiantehabitosaludable
									
								   SET		vegetariano="'.$vegetariano.'",
								   			fuma="'.$Fuma.'",
											frecuneciafumar="'.$Frecuencia_fuma.'",
											alcohol="'.$Alcohol.'",
											frecuenciaalcohol="'.$Frecuencia_Alcohol.'",
											changedate=NOW(),
											useridestado="'.$userid.'"
											
								   
								   WHERE	idestudiantehabisaludable="'.$id_HabitosSaludables.'"  AND idestudiantegeneral="'.$Estudiante_id.'"  AND  codigoestado=100';
								   
								   
								   if($UpdateHabitoAlimenticio=&$db->Execute($SQL_UpdateHabitoAlimento)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateHabitoAlimento;
									echo json_encode($a_vectt);
									exit;
								}
				
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateVacunas;
				echo json_encode($a_vectt);
				exit;					
		
		
		}break;
	case 'UpdateVacunas':{
		MainJson();
		global $db,$userid;
		
		$id_Vacunas               = $_GET['id_Vacunas'];
		$Estudiante_id			  = $_GET['Estudiante_id'];
		$TipoVacuna				  = $_GET['Vacuna'];
		$Dosis					  = $_GET['Dosis'];
		
		######################################################################
		if($TipoVacuna==0){
				$Vacuna  = 1;
				$CodigoEstado = 200;
			}else{
					$Vacuna  = 0;
					$CodigoEstado = 100;
				}
		######################################################################
		$SQL_UpdateVacunas='UPDATE	estudiantevacunas
							
							SET		vacunas="'.$Vacuna.'",
									tipovacunas="'.$TipoVacuna.'",
									dosisvacunas="'.$Dosis.'",
									useridchangedate="'.$userid.'"	,
									changedate=NOW(),
									codigoestado="'.$CodigoEstado.'"
							
							WHERE	codigoestado=100 AND idestudiantevacunas="'.$id_Vacunas.'" AND idestudiantegeneral="'.$Estudiante_id.'"';
							
							if($UpdateVacunas=&$db->Execute($SQL_UpdateVacunas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateVacunas;
									echo json_encode($a_vectt);
									exit;
								}
				
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateVacunas;
				echo json_encode($a_vectt);
				exit;				
		
		}break;
	case 'UPDATECondicionSalud':{
		MainJson();
		global $db,$userid;
		
		
		$Estudiante_id                           = $_GET['Estudiante_id'];
		$id_SaveCondicionSalud                   = $_GET['id_SaveCondicionSalud'];
		$Enfermeda                               = $_GET['Enfermeda'];
		$Enf_Endroquina                          = $_GET['Enf_Endroquina'];
		$DesordenMental                          = $_GET['DesordenMental'];
		$Enf_Circulatorio                        = $_GET['Enf_Circulatorio'];
		$Enf_Respiratorio                        = $_GET['Enf_Respiratorio'];
		$Enf_Locomotor                           = $_GET['Enf_Locomotor'];
		$Enf_Malformaciones                      = $_GET['Enf_Malformaciones'];
		$Enf_Otras                               = $_GET['Enf_Otras'];
		$Alergia                                 = $_GET['Alergia'];
		$Cual_Alergia                            = $_GET['Cual_Alergia'];
		$UsoMedicamentos                         = $_GET['UsoMedicamentos'];
		$Cual_UsoMed                             = $_GET['Cual_UsoMed'];
		$Trastorno                               = $_GET['Trastorno'];
		$Anorexia                                = $_GET['Anorexia'];
		$Bulimia                                 = $_GET['Bulimia'];
		$Obesidad                                = $_GET['Obesidad'];
		$Otra_Trastorno                          = $_GET['Otra_Trastorno'];
		$TrastornoText                           = $_GET['TrastornoText'];
		$Discapacida                             = $_GET['Discapacida'];
		$locomocion                              = $_GET['locomocion'];
		$inferior                                = $_GET['inferior'];
		$Superior                                = $_GET['Superior'];
		$Paralisis                               = $_GET['Paralisis'];
		$Visual                                  = $_GET['Visual'];
		$Auditiva                                = $_GET['Auditiva'];
		$Habla                                   = $_GET['Habla'];
		$ObservacionCondicionDiscapacidad		 = $_GET['ObservacionCondicionDiscapacidad'];
		
		######################################################################################
		if($Anorexia!=0){
				$TrastornoTipo = $Anorexia;
			}
		if($Bulimia!=0){
				$TrastornoTipo = $Bulimia;
			}
		if($Obesidad!=0){
				$TrastornoTipo = $Obesidad;
			}
		if($Otra_Trastorno!=0){
				$TrastornoTipo = $Otra_Trastorno;
			}
		######################################################################################
		if($locomocion!=0){
				$Fisica =  $locomocion;
			}
		if($inferior!=0){
				$Fisica =  $inferior;
			}
		if($Superior!=0){
				$Fisica =  $Superior;
			}	
		if($Paralisis!=0){
				$Fisica =  $Paralisis;
			}
		if($Visual!=0){
				$Sensorial =  $Visual;
			}
		if($Auditiva!=0){
				$Sensorial =  $Auditiva;
			}
		if($Habla!=0){
				$Sensorial =  $Habla;
			}				
		######################################################################################
		
		$SQL_UpdateCondicionSalud='UPDATE	estudiantecondicionsalud
		
								   SET		sufrealgunaenfermeda="'.$Enfermeda.'",
								   			enfermedadendocrina="'.$Enf_Endroquina.'",
											desordenmental="'.$DesordenMental.'",
											enfermedadsistemacirculatorio="'.$Enf_Circulatorio.'",
											enfermedadsistemarespiratorio="'.$Enf_Respiratorio.'",
											enfermedadsistemalocomotor="'.$Enf_Locomotor.'",
											malformacionescongenicas="'.$Enf_Malformaciones.'",
											otrasenfermedades="'.$Enf_Otras.'",
											alergias="'.$Alergia.'",
											alergiascual="'.$Cual_Alergia.'",
											medicamentospermanentes="'.$UsoMedicamentos.'",
											cualmedicamentos="'.$Cual_UsoMed.'",
											trsatornoalimenticio="'.$Trastorno.'",
											trastornosalimenticiostipos="'.$$TrastornoTipo.'",
											trastornocual="'.$TrastornoText.'",
											discapasidad="'.$Discapacida.'",
											condiciondiscapacidadfisica="'.$Fisica.'",
											condiciondiscapacidadsensorial="'.$Sensorial.'",
											observaciondiscapacidad="'.$ObservacionCondicionDiscapacidad.'",
											changedate=NOW(),
											useridchangedate="'.$userid.'"
								   
								   WHERE	idestudiantecondicionsalud="'.$id_SaveCondicionSalud.'"  AND  idestudiantegeneral="'.$Estudiante_id.'" AND  codigoestado=100';
								   
								   
								if($UpdateCondicionSalud=&$db->Execute($SQL_UpdateCondicionSalud)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateCondicionSalud;
										echo json_encode($a_vectt);
										exit;
									}
		
		
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpdateCondicionSalud;
					echo json_encode($a_vectt);
					exit;		   								         
															  
		}break;
	case 'SaveTab4':{
		MainJson();
		global $db,$userid;
		
		/**********************************************************************************/
			$id_Estudiante                  		= $_GET['id_Estudiante'];
			$Enfermeda_Si                  			= $_GET['Enfermeda_Si'];
			$Enf_Endroquina							= $_GET['Enf_Endroquina'];						
			$DesordenMental							= $_GET['DesordenMental'];
			$Enf_Circulatorio						= $_GET['Enf_Circulatorio'];
			$Enf_Respiratorio						= $_GET['Enf_Respiratorio'];
			$Enf_Locomotor							= $_GET['Enf_Locomotor'];
			$Enf_Malformaciones						= $_GET['Enf_Malformaciones'];
			$Enf_Otras								= $_GET['Enf_Otras'];
			$Alergia								= $_GET['Alegia'];
			$Cual_Alergia							= $_GET['Cual_Alergia'];
			$UsoMedicamentos						= $_GET['UsoMedicamentos'];
			$Cual_UsoMed							= $_GET['Cual_UsoMed'];
			$Trastorno								= $_GET['Trastorno'];
			$Anorexia								= $_GET['Anorexia'];
			$Bulimia								= $_GET['Bulimia'];
			$Obesidad								= $_GET['Obesidad'];
			$Otra_Trastorno							= $_GET['Otra_Trastorno'];
			$TrastornoText							= $_GET['TrastornoText'];
			$Discapacidad							= $_GET['Discapacidad'];
			$locomocion								= $_GET['locomocion'];
			$inferior								= $_GET['inferior'];
			$Superior								= $_GET['Superior'];
			$Paralisis								= $_GET['Paralisis'];
			$Visual									= $_GET['Visual'];
			$Auditiva								= $_GET['Auditiva'];
			$Habla									= $_GET['Habla'];
			$ObservacionCondicionDiscapacidad		= $_GET['ObservacionCondicionDiscapacidad'];
			$Sarampion								= $_GET['Sarampion'];
			$Hepati_Dosis							= $_GET['Hepati_Dosis'];
			$Rubeola								= $_GET['Rubeola'];
			$Hepatitis_B							= $_GET['Hepatitis_B'];
			$VPH									= $_GET['VPH'];
			$VPH_Dosis								= $_GET['VPH_Dosis'];
			$Vegetariano							= $_GET['Vegetariano'];
			$Fuma									= $_GET['Fuma'];
			$Frecuencia_fuma						= $_GET['Frecuencia_fuma'];
			$Alcohol								= $_GET['Alcohol'];
			$Frecuencia_Alcohol						= $_GET['Frecuencia_Alcohol'];
			$Act_Fisica								= $_GET['Act_Fisica'];
			$Act_FisicaCual							= $_GET['Act_FisicaCual'];
			$Fre_ActFisica							= $_GET['Fre_ActFisica'];
			$PracticaDepor							= $_GET['PracticaDepor'];
			$Futbol									= $_GET['Futbol'];
			$Frecuencia_Futbol						= $_GET['Frecuencia_Futbol'];
			$F_sala									= $_GET['F_sala'];
			$Frecuencia_F_sala						= $_GET['Frecuencia_F_sala'];
			$Basketball								= $_GET['Basketball'];
			$Frecuencia_Basketball					= $_GET['Frecuencia_Basketball'];
			$Voleibol								= $_GET['Voleibol'];
			$Frecuencia_Voleibol					= $_GET['Frecuencia_Voleibol'];
			$Rugby									= $_GET['Rugby'];
			$Frecuencia_Rugby						= $_GET['Frecuencia_Rugby'];
			$T_mesa									= $_GET['T_mesa'];
			$Frecuencia_T_mesa						= $_GET['Frecuencia_T_mesa'];
			$Ciclismo								= $_GET['Ciclismo'];
			$Frecuencia_Ciclismo					= $_GET['Frecuencia_Ciclismo'];
			$Natacion								= $_GET['Natacion'];
			$Frecuencia_Natacion					= $_GET['Frecuencia_Natacion'];
			$Atletismo								= $_GET['Atletismo'];
			$Frecuencia_Atletismo					= $_GET['Frecuencia_Atletismo'];
			$Beisbol								= $_GET['Beisbol'];
			$Frecuencia_Beisbol						= $_GET['Frecuencia_Beisbol'];
			$Ajedrez								= $_GET['Ajedrez'];
			$Frecuencia_Ajedrez						= $_GET['Frecuencia_Ajedrez'];
			$Squash									= $_GET['Squash'];
			$Frecuencia_Squash						= $_GET['Frecuencia_Squash'];
			$Taekwondo								= $_GET['Taekwondo'];
			$Frecuencia_Taekwondo					= $_GET['Frecuencia_Taekwondo'];
			$OtroPractica							= $_GET['OtroPractica'];
			$Otro_deporte_Text						= $_GET['Otro_deporte'];
			$Frecuencia_OtroPractica				= $_GET['Frecuencia_OtroPractica'];
			$PerteneceRed							= $_GET['PerteneceRed'];
			$Pertenece_Cual							= $_GET['Pertenece_Cual'];
			$Voluntariado							= $_GET['Voluntariado'];
			$Voluntariado_Cual						= $_GET['Voluntariado_Cual'];
			$musica									= $_GET['musica'];
			$Guitarra								= $_GET['Guitarra'];
			$Nivel_Guitarra							= $_GET['Nivel_Guitarra'];
			$Bateria								= $_GET['Bateria'];
			$Nivel_Bateria							= $_GET['Nivel_Bateria'];
			$Saxofon								= $_GET['Saxofon'];
			$Nivel_Saxofon							= $_GET['Nivel_Saxofon'];
			$Trompeta								= $_GET['Trompeta'];
			$Nivel_Trompeta							= $_GET['Nivel_Trompeta'];
			$Congas									= $_GET['Congas'];
			$Nivel_Congas							= $_GET['Nivel_Congas'];
			$Acordion								= $_GET['Acordion'];
			$Nivel_Acordion							= $_GET['Nivel_Acordion'];
			$Otro_Musica							= $_GET['Otro_Musica'];
			$Cual_Instrumentio						= $_GET['Cual_Instrumentio'];
			$Nivel_Otro_Musica						= $_GET['Nivel_Otro_Musica'];
			$ExpCorporal							= $_GET['ExpCorporal'];
			$Danza									= $_GET['Danza'];
			$Nivel_Danza							= $_GET['Nivel_Danza'];
			$Danza_Floclorica						= $_GET['Danza_Floclorica'];
			$Nivel_Danza_Floclorica					= $_GET['Nivel_Danza_Floclorica'];
			$Danza_Moderna							= $_GET['Danza_Moderna'];
			$Nivel_Danza_Moderna					= $_GET['Nivel_Danza_Moderna'];
			$Danza_Contemporanea					= $_GET['Danza_Contemporanea'];
			$Nivel_Danza_Contemporanea				= $_GET['Nivel_Danza_Contemporanea'];
			$Ballet									= $_GET['Ballet'];
			$Nivel_Ballet							= $_GET['Nivel_Ballet'];
			$Otra_Danza								= $_GET['Otra_Danza'];
			$Nivel_Otra_Danza						= $_GET['Nivel_Otra_Danza'];
			$Cual_Danzas							= $_GET['Cual_Danzas'];
			$Arte_escenicas							= $_GET['Arte_escenicas'];
			$Teatro									= $_GET['Teatro'];
			$Nivel_Teatro							= $_GET['Nivel_Teatro'];
			$actuacion								= $_GET['actuacion'];
			$Nivel_actuacion						= $_GET['Nivel_actuacion'];
			$narracion								= $_GET['narracion'];
			$Nivel_narracion						= $_GET['Nivel_narracion'];
			$standcomedy							= $_GET['standcomedy'];
			$Nivel_standcomedy						= $_GET['Nivel_standcomedy'];
			$Otro_Escenica							= $_GET['Otro_Escenica'];
			$Nivel_Otro_Escenica					= $_GET['Nivel_Otro_Escenica'];
			$Cual_arte_Escenico						= $_GET['Cual_arte_Escenico'];
			$Literaria								= $_GET['Literaria'];
			$poesia									= $_GET['poesia'];
			$Nivel_poesia							= $_GET['Nivel_poesia'];
			$cuento									= $_GET['cuento'];
			$Nivel_cuento							= $_GET['Nivel_cuento'];
			$novela									= $_GET['novela'];
			$Nivel_novela							= $_GET['Nivel_novela'];
			$cronica								= $_GET['cronica'];
			$Nivel_cronica							= $_GET['Nivel_cronica'];
			$Otro_Literatura						= $_GET['Otro_Literatura'];
			$Nivel_Otro_Literatura					= $_GET['Nivel_Otro_Literatura'];
			$Cual_Literatura						= $_GET['Cual_Literatura'];
			$Plastica								= $_GET['Plastica'];
			$fotografia								= $_GET['fotografia'];
			$Nivel_fotografia						= $_GET['Nivel_fotografia'];
			$video									= $_GET['video'];
			$Nivel_video							= $_GET['Nivel_video'];
			$DiseñoGrafico							= $_GET['DiseñoGrafico'];
			$Nivel_DiseñoGrafico					= $_GET['Nivel_DiseñoGrafico'];
			$Comic									= $_GET['Comic'];
			$Nivel_Comic							= $_GET['Nivel_Comic'];
			$Dibujo									= $_GET['Dibujo'];
			$Nivel_Dibujo							= $_GET['Nivel_Dibujo'];
			$Grafitty								= $_GET['Grafitty'];
			$Nivel_Grafitty							= $_GET['Nivel_Grafitty'];
			$Escultura								= $_GET['Escultura'];
			$Nivel_Escultura						= $_GET['Nivel_Escultura'];
			$Pintura								= $_GET['Pintura'];
			$Nivel_Pintura							= $_GET['Nivel_Pintura'];
			$Otro_Plastico							= $_GET['Otro_Plastico'];
			$Nivel_Otro_Plastico					= $_GET['Nivel_Otro_Plastico'];
			$Cual_ArtePlastico						= $_GET['Cual_ArtePlastico'];
			$GuardarSave                            = $_GET['GuardarSave'];
			$Tetano									= $_GET['Tetano'];
			$Tennis									= $_GET['Tennis'];
			$Frecuencia_Tennis						= $_GET['Frecuencia_Tennis'];
			
													   
		/**********************************************************************************/
		
	if($GuardarSave==0){	
			if($Trastorno==0){#Si sufre de Trastrorno alimenticio
					
					if($Anorexia!=0){
							$Tipo_Trastorno = $Anorexia;
						}
					if($Bulimia!=0){
							$Tipo_Trastorno = $Bulimia;
						}
					if($Obesidad!=0){
							$Tipo_Trastorno = $Obesidad;
						}
					if($Otra_Trastorno!=0){
							$Tipo_Trastorno = $Otra_Trastorno;
						}			
						
				}else{
						$Tipo_Trastorno = 0;
					}
			/*
			
			$ObservacionCondicionDiscapacidad
			*/		
			if($Discapacidad==0){
					
					if($locomocion!=0){
							$DiscapacidadFisica = $locomocion;
						}
					if($inferior!=0){
							$DiscapacidadFisica = $inferior;
						}	
					if($Superior!=0){
							$DiscapacidadFisica	= $Superior;
						}	
					if($Paralisis!=0){
							$DiscapacidadFisica = $Paralisis;
						}
					if($Visual!=0){
							$DiscapacidadSensorial = $Visual;
						}	
					if($Auditiva!=0){
							$DiscapacidadSensorial = $Auditiva;
						}	
					if($Habla!=0){
							$DiscapacidadSensorial = $Habla;
						}	
				}else{
						$DiscapacidadFisica = 0;
						$DiscapacidadSensorial = 0;
					}		
			
			$SQL_CondicionSalud='INSERT INTO  estudiantecondicionsalud(idestudiantegeneral,sufrealgunaenfermeda,enfermedadendocrina,desordenmental,enfermedadsistemacirculatorio,enfermedadsistemarespiratorio,enfermedadsistemalocomotor,malformacionescongenicas,otrasenfermedades,alergias,alergiascual,medicamentospermanentes,cualmedicamentos,trsatornoalimenticio,trastornosalimenticiostipos,trastornocual,discapasidad,condiciondiscapacidadfisica,condiciondiscapacidadsensorial,observaciondiscapacidad,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Enfermeda_Si.'","'.$Enf_Endroquina.'","'.$DesordenMental.'","'.$Enf_Circulatorio.'","'.$Enf_Respiratorio.'","'.$Enf_Locomotor.'","'.$Enf_Malformaciones.'","'.$Enf_Otras.'","'.$Alergia.'","'.$Cual_Alergia.'","'.$UsoMedicamentos.'","'.$Cual_UsoMed.'","'.$Trastorno.'","'.$Tipo_Trastorno.'","'.$TrastornoText.'","'.$Discapacidad.'","'.$DiscapacidadFisica.'","'.$DiscapacidadSensorial.'","'.$ObservacionCondicionDiscapacidad.'",NOW(),"'.$userid.'")';
		
					 if($InsertCondicionSalud=&$db->Execute($SQL_CondicionSalud)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_CondicionSalud;
							echo json_encode($a_vectt);
							exit;
						}
						
				##################################
				$CondicionSalud_Last_id=$db->Insert_ID();
				##################################		
						
		#
		if($Sarampion!=0){
			
			$SQL_Vacunas='INSERT INTO estudiantevacunas(idestudiantegeneral,vacunas,tipovacunas,dosisvacunas,entrydate,userid)VALUES("'.$id_Estudiante.'",0,"'.$Sarampion.'","",NOW(),"'.$userid.'")';
							
							
							 if($InsertSarampion=&$db->Execute($SQL_Vacunas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Vacunas;
									echo json_encode($a_vectt);
									exit;
								}
								
				##################################
				$Sarampion_Last_id=$db->Insert_ID();
				##################################			
							
			}
		if($Rubeola!=0){
			
			$SQL_Vacunas='INSERT INTO estudiantevacunas(idestudiantegeneral,vacunas,tipovacunas,dosisvacunas,entrydate,userid)VALUES("'.$id_Estudiante.'",0,"'.$Rubeola.'","",NOW(),"'.$userid.'")';
			
							 if($InsertRubeola=&$db->Execute($SQL_Vacunas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Vacunas;
									echo json_encode($a_vectt);
									exit;
								}
								
								
				##################################
				$Rubeola_Last_id=$db->Insert_ID();
				##################################				
			
			}
		if($Tetano!=0){
			
			$SQL_Vacunas='INSERT INTO estudiantevacunas(idestudiantegeneral,vacunas,tipovacunas,dosisvacunas,entrydate,userid)VALUES("'.$id_Estudiante.'",0,"'.$Tetano.'","",NOW(),"'.$userid.'")';
			
			
							 if($InsertTetano=&$db->Execute($SQL_Vacunas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Vacunas;
									echo json_encode($a_vectt);
									exit;
								}
								
				##################################
				$Tetano_Last_id=$db->Insert_ID();
				##################################				
			
			}	
		if($Hepatitis_B!=0){
			
			$SQL_Vacunas='INSERT INTO estudiantevacunas(idestudiantegeneral,vacunas,tipovacunas,dosisvacunas,entrydate,userid)VALUES("'.$id_Estudiante.'",0,"'.$Hepatitis_B.'","'.$Hepati_Dosis.'",NOW(),"'.$userid.'")';
			
							if($InsertHepatitis_B=&$db->Execute($SQL_Vacunas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Vacunas;
									echo json_encode($a_vectt);
									exit;
								}
								
				##################################
				$Hepatitis_B_Last_id=$db->Insert_ID();
				##################################				

			}
		if($VPH!=0){
			
			$SQL_Vacunas='INSERT INTO estudiantevacunas(idestudiantegeneral,vacunas,tipovacunas,dosisvacunas,entrydate,userid)VALUES("'.$id_Estudiante.'",0,"'.$VPH.'","'.$VPH_Dosis.'",NOW(),"'.$userid.'")';


							if($InsertVPH=&$db->Execute($SQL_Vacunas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Vacunas;
									echo json_encode($a_vectt);
									exit;
								}
								
				##################################
				$VPH_Last_id=$db->Insert_ID();
				##################################				
								
								
			}
		
		
		#
		
		$SQL_HabitoSaludable='INSERT INTO estudiantehabitosaludable(idestudiantegeneral,vegetariano,fuma,frecuneciafumar,alcohol,frecuenciaalcohol,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Vegetariano.'","'.$Fuma.'","'.$Frecuencia_fuma.'","'.$Alcohol.'","'.$Frecuencia_Alcohol.'",NOW(),"'.$userid.'")';
							
							
							if($InsertHabitoSaludable=&$db->Execute($SQL_HabitoSaludable)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_HabitoSaludable;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$HabitoSaludable_Last_id=$db->Insert_ID();
					##################################					
		
		#
		
		$SQL_ActividaFisica='INSERT INTO estudianteactividafisica(idestudiantegeneral,actividadfisica,actividadfisicacual,actividadfisicafrecuancia,redgruponacionalinternacional,cualredogrupo,voluntariado,cualvoluntariado,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Act_Fisica.'","'.$Act_FisicaCual.'","'.$Fre_ActFisica.'","'.$PerteneceRed.'","'.$Pertenece_Cual.'","'.$Voluntariado.'","'.$Voluntariado_Cual.'",NOW(),"'.$userid.'")';
		
							if($InsertActividaFisica=&$db->Execute($SQL_ActividaFisica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ActividaFisica;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$ActividaFisica_Last_id=$db->Insert_ID();
					##################################			
		
		#
		
		
		$CadenaDeporte = '';
		
		
		if($PracticaDepor==0){
			if($Futbol!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Futbol.'","'.$Frecuencia_Futbol.'","",NOW(),"'.$userid.'")';
				
							if($InsertFutbol=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Futbol_Last_id=$db->Insert_ID();
					##################################
					
					$CadenaDeporte = $CadenaDeporte.'::Futbol-'.$Futbol_Last_id;			
				
				}
			if($F_sala!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$F_sala.'","'.$Frecuencia_F_sala.'","",NOW(),"'.$userid.'")';
				
							if($InsertF_sala=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$F_sala_Last_id=$db->Insert_ID();
					##################################
					
					$CadenaDeporte = $CadenaDeporte.'::F_Sala-'.$F_sala_Last_id;
								
				
				}
			if($Basketball!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Basketball.'","'.$Frecuencia_Basketball.'","",NOW(),"'.$userid.'")';
				
							if($InsertBasketball=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Basketball_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaDeporte = $CadenaDeporte.'::Basketball-'.$Basketball_Last_id;			
				
				}
			if($Voleibol!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Voleibol.'","'.$Frecuencia_Voleibol.'","",NOW(),"'.$userid.'")';
				
				
							if($InsertVoleibol=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
						
					##################################
					$Voleibol_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaDeporte = $CadenaDeporte.'::Voleibol-'.$Voleibol_Last_id;			
				
				}
			if($Rugby!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Rugby.'","'.$Frecuencia_Rugby.'","",NOW(),"'.$userid.'")';
				
							if($InsertRugby=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Rugby_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaDeporte = $CadenaDeporte.'::Rugby-'.$Rugby_Last_id;
								
				
				}
			if($T_mesa!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$T_mesa.'","'.$Frecuencia_T_mesa.'","",NOW(),"'.$userid.'")';
				
							if($InsertT_mesa=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$T_mesa_Last_id=$db->Insert_ID();
					##################################			
						
					$CadenaDeporte = $CadenaDeporte.'::T_mesa-'.$T_mesa_Last_id;			
				
				}
			if($Ciclismo!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Ciclismo.'","'.$Frecuencia_Ciclismo.'","",NOW(),"'.$userid.'")';
				
				
							if($InsertCiclismo=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Ciclismo_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaDeporte = $CadenaDeporte.'::Ciclismo-'.$Ciclismo_Last_id;			
				
				}
			if($Natacion!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Natacion.'","'.$Frecuencia_Natacion.'","",NOW(),"'.$userid.'")';
				
							if($InsertNatacion=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Natacion_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaDeporte = $CadenaDeporte.'::Natacion-'.$Natacion_Last_id;			
				
				}
			if($Atletismo!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Atletismo.'","'.$Frecuencia_Atletismo.'","",NOW(),"'.$userid.'")';
				
				
							if($InsertAtletismo=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Atletismo_Last_id=$db->Insert_ID();
					##################################			
								
					$CadenaDeporte = $CadenaDeporte.'::Atletismo-'.$Atletismo_Last_id;			
				
				}
			if($Beisbol!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Beisbol.'","'.$Frecuencia_Beisbol.'","",NOW(),"'.$userid.'")';
				
							if($InsertBeisbol=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Beisbol_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaDeporte = $CadenaDeporte.'::Beisbol-'.$Beisbol_Last_id;			
				
				}
			if($Ajedrez!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Ajedrez.'","'.$Frecuencia_Ajedrez.'","",NOW(),"'.$userid.'")';
				
							if($InsertAjedrez=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Ajedrez_Last_id=$db->Insert_ID();
					##################################			
								
					$CadenaDeporte = $CadenaDeporte.'::Ajedrez-'.$Ajedrez_Last_id;				
				
				}
			if($Squash!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Squash.'","'.$Frecuencia_Squash.'","",NOW(),"'.$userid.'")';
				
				
							if($InsertSquash=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Squash_Last_id=$db->Insert_ID();
					##################################			
								
					$CadenaDeporte = $CadenaDeporte.'::Squash-'.$Squash_Last_id;
				
				
				}
			if($Taekwondo!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Taekwondo.'","'.$Frecuencia_Taekwondo.'","",NOW(),"'.$userid.'")';
				
							if($InsertTaekwondo=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Taekwondo_Last_id=$db->Insert_ID();
					##################################			
						
					$CadenaDeporte = $CadenaDeporte.'::Taekwondo-'.$Taekwondo_Last_id;			
				
				}
			if($OtroPractica!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$OtroPractica.'","'.$Frecuencia_OtroPractica.'","'.$Otro_deporte_Text.'",NOW(),"'.$userid.'")';
				
							if($InsertOtroPractica=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
					
					##################################
					$OtroDeporte_Last_id=$db->Insert_ID();
					##################################			
						
					$CadenaDeporte = $CadenaDeporte.'::OtroDeporte-'.$OtroDeporte_Last_id;			
				
				}
				
			if($Tennis!=0){
				
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$Tennis.'","'.$Frecuencia_Tennis.'","",NOW(),"'.$userid.'")';
				
							if($InsertTennis=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$Tennis_Last_id=$db->Insert_ID();
					##################################			
						
					$CadenaDeporte = $CadenaDeporte.'::Tennis-'.$Tennis_Last_id;	
				
				}									
				
		}else{
				$SQL_Deporte='INSERT INTO estudiantedeporte(idestudiantegeneral,practicadeporte,deporte,frecuenciadeporte,deportecual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$PracticaDepor.'","'.$OtroPractica.'","'.$Frecuencia_OtroPractica.'","'.$Otro_deporte_Text.'",NOW(),"'.$userid.'")';
				
							if($InsertPracticaDepor=&$db->Execute($SQL_Deporte)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Deporte;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$NoDeporte_Last_id=$db->Insert_ID();
					##################################
					
					$CadenaDeporte = $CadenaDeporte.'::NoDeporte-'.$NoDeporte_Last_id;				
				
			}
		
		#
		
		$CadenaMusica = '';
		
		if($musica==0){
			if($Guitarra!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Guitarra.'","'.$Nivel_Guitarra.'","",NOW(),"'.$userid.'")';
				
							if($InsertGuitarra=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Guitarra_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaMusica = $CadenaMusica.'::Guitarra-'.$Guitarra_Last_id;			
				
				}
			if($Bateria!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Bateria.'","'.$Nivel_Bateria.'","",NOW(),"'.$userid.'")';
				
							if($InsertBateria=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Bateria_Last_id=$db->Insert_ID();
					##################################
					
					$CadenaMusica = $CadenaMusica.'::Bateria-'.$Bateria_Last_id;
								
				
				}
			if($Saxofon!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Saxofon.'","'.$Nivel_Saxofon.'","",NOW(),"'.$userid.'")';
				
							if($InsertSaxofon=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Saxofon_Last_id=$db->Insert_ID();
					##################################
					
					$CadenaMusica = $CadenaMusica.'::Saxofon-'.$Saxofon_Last_id;
								
				
				}
			if($Trompeta!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Trompeta.'","'.$Nivel_Trompeta.'","",NOW(),"'.$userid.'")';
				
							if($InsertTrompeta=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Trompeta_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaMusica = $CadenaMusica.'::Trompeta-'.$Trompeta_Last_id;		
								
				
				}
			if($Congas!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Congas.'","'.$Nivel_Congas.'","",NOW(),"'.$userid.'")';
				
							if($InsertCongas=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Congas_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaMusica = $CadenaMusica.'::Congas-'.$Congas_Last_id;		
								
				
				}
			if($Acordion!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Acordion.'","'.$Nivel_Acordion.'","",NOW(),"'.$userid.'")';
				
							if($InsertAcordion=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Acordion_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaMusica = $CadenaMusica.'::Acordion-'.$Acordion_Last_id;		
				
				}
			if($Otro_Musica!=0){
				
				$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Otro_Musica.'","'.$Nivel_Otro_Musica.'","'.$Cual_Instrumentio.'",NOW(),"'.$userid.'")';
				
							if($InsertOtro_Musica=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$OtroMusica_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaMusica = $CadenaMusica.'::OtroMusica-'.$OtroMusica_Last_id;		
								
				
				}
		}else{
			
			$SQL_Musica='INSERT INTO  estudiantemusica(idestudiantegeneral,instrumentomusical,tipoinstrumento,frecuenciainstrumento,tipoinstrumentocual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$musica.'","'.$Otro_Musica.'","'.$Nivel_Otro_Musica.'","'.$Cual_Instrumentio.'",NOW(),"'.$userid.'")';
						
						
							if($Insertmusica=&$db->Execute($SQL_Musica)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Musica;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$NoMusica_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaMusica = $CadenaMusica.'::NoMusica-'.$NoMusica_Last_id;			
								
			}
		#
		
		$CadenaExpreCorporal='';
		
		if($ExpCorporal==0){
			if($Danza!=0){
				
				$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Danza.'","'.$Nivel_Danza.'","",NOW(),"'.$userid.'")';
								
								
							if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Danza_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::Danza-'.$Danza_Last_id;
				 
				}
			if($Danza_Floclorica!=0){
				
				$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Danza_Floclorica.'","'.$Nivel_Danza_Floclorica.'","",NOW(),"'.$userid.'")';
				
				
								if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$DzFloclorica_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::DzFloclorica-'.$DzFloclorica_Last_id;
								
				
				}
			if($Danza_Moderna!=0){
				
				$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Danza_Moderna.'","'.$Nivel_Danza_Moderna.'","",NOW(),"'.$userid.'")';
				
							if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$DzModerna_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::DzModerna-'.$DzModerna_Last_id;
				
				}
			if($Danza_Contemporanea!=0){
				
				$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Danza_Contemporanea.'","'.$Nivel_Danza_Contemporanea.'","",NOW(),"'.$userid.'")';
				
							if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$DzContemporanea_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::DzContemporanea-'.$DzContemporanea_Last_id;
				
				}
			if($Ballet!=0){
				
				$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Ballet.'","'.$Nivel_Ballet.'","",NOW(),"'.$userid.'")';
				
							if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$DzBallet_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::DzBallet-'.$DzBallet_Last_id;		
				
				}
			if($Otra_Danza!=0){
				
				$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Otra_Danza.'","'.$Nivel_Otra_Danza.'","'.$Cual_Danzas.'",NOW(),"'.$userid.'")';
				
							if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$OtraDanza_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::OtraDanza-'.$OtraDanza_Last_id;		
								
				
				}
		}else{
			
			$SQL_ExprecionCorporal='INSERT INTO  estudianteexprecioncorporal(idestudiantegeneral,exprecioncorporal,tipoexprecioncorporal,frecuenciaexprecion,cualtipoexprecion,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$ExpCorporal.'","'.$Otra_Danza.'","'.$Nivel_Otra_Danza.'","'.$Cual_Danzas.'",NOW(),"'.$userid.'")';
			
							if($InsertExpCorporal=&$db->Execute($SQL_ExprecionCorporal)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_ExprecionCorporal;
									echo json_encode($a_vectt);
									exit;
								}
								
								
					##################################
					$NoDanza_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaExpreCorporal  = $CadenaExpreCorporal.'::NoDanza-'.$NoDanza_Last_id;		
					
			}
		#
		
		$CadenaArteEscenica = '';
		
		if($Arte_escenicas==0){
			if($Teatro!=0){
				
				$SQL_Escenicas='INSERT INTO estudianteartesescenicas(idestudiantegeneral,artesescenicas,tipoarteescenica,frecuanciaescenica,escenicacual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Arte_escenicas.'","'.$Teatro.'","'.$Nivel_Teatro.'","",NOW(),"'.$userid.'")';
				
							if($InsertArte_escenicas=&$db->Execute($SQL_Escenicas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Escenicas;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Teatro_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaArteEscenica = $CadenaArteEscenica.'::Teatro-'.$Teatro_Last_id;			
				
				}
			if($actuacion!=0){
				
				$SQL_Escenicas='INSERT INTO estudianteartesescenicas(idestudiantegeneral,artesescenicas,tipoarteescenica,frecuanciaescenica,escenicacual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Arte_escenicas.'","'.$actuacion.'","'.$Nivel_actuacion.'","",NOW(),"'.$userid.'")';
				
				
							if($InsertArte_escenicas=&$db->Execute($SQL_Escenicas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Escenicas;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Actuacion_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaArteEscenica = $CadenaArteEscenica.'::Actuacion-'.$Actuacion_Last_id;
								
				
				}
			if($narracion!=0){
				
				$SQL_Escenicas='INSERT INTO estudianteartesescenicas(idestudiantegeneral,artesescenicas,tipoarteescenica,frecuanciaescenica,escenicacual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Arte_escenicas.'","'.$narracion.'","'.$Nivel_narracion.'","",NOW(),"'.$userid.'")';
				
				
							if($InsertArte_escenicas=&$db->Execute($SQL_Escenicas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Escenicas;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$Narracion_Last_id=$db->Insert_ID();
					##################################			
					
					$CadenaArteEscenica = $CadenaArteEscenica.'::Narracion-'.$Narracion_Last_id;			
				
				}
			if($standcomedy!=0){
				
				$SQL_Escenicas='INSERT INTO estudianteartesescenicas(idestudiantegeneral,artesescenicas,tipoarteescenica,frecuanciaescenica,escenicacual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Arte_escenicas.'","'.$standcomedy.'","'.$Nivel_standcomedy.'","'.$Cual_arte_Escenico.'",NOW(),"'.$userid.'")';
				
							if($InsertArte_escenicas=&$db->Execute($SQL_Escenicas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Escenicas;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$StandComedy_Last_id=$db->Insert_ID();
					##################################
					
					$CadenaArteEscenica = $CadenaArteEscenica.'::StandComedy-'.$StandComedy_Last_id;						
				
				}
			if($Otro_Escenica!=0){
				
				$SQL_Escenicas='INSERT INTO estudianteartesescenicas(idestudiantegeneral,artesescenicas,tipoarteescenica,frecuanciaescenica,escenicacual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Arte_escenicas.'","'.$Otro_Escenica.'","'.$Nivel_Otro_Escenica.'","",NOW(),"'.$userid.'")';
				
							if($InsertArte_escenicas=&$db->Execute($SQL_Escenicas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Escenicas;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$OtraEscenica_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaArteEscenica = $CadenaArteEscenica.'::OtraEscenica-'.$OtraEscenica_Last_id;		
				
				}
		}else{
			
			$SQL_Escenicas='INSERT INTO estudianteartesescenicas(idestudiantegeneral,artesescenicas,tipoarteescenica,frecuanciaescenica,escenicacual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Arte_escenicas.'","'.$Otro_Escenica.'","'.$Nivel_Otro_Escenica.'","",NOW(),"'.$userid.'")';
			
							if($InsertArte_escenicas=&$db->Execute($SQL_Escenicas)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Escenicas;
									echo json_encode($a_vectt);
									exit;
								}
								
					##################################
					$NoEscenica_Last_id=$db->Insert_ID();
					##################################	
					
					$CadenaArteEscenica = $CadenaArteEscenica.'::NoEscenica-'.$NoEscenica_Last_id;			
			
			}
		#
		
		
		$CadedenaLiteraria='';
		
		if($Literaria==0){		
			if($poesia!=0){
				
				$SQL_Literario='INSERT INTO  estudiantearteliterario (idestudiantegeneral,arteliterario,tipoarteliterario,frecuencialiteraria,cualarteliterario,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Literaria.'","'.$poesia.'","'.$Nivel_poesia.'","",NOW(),"'.$userid.'")';
				
								if($InsertLiteraria=&$db->Execute($SQL_Literario)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Literario;
										echo json_encode($a_vectt);
										exit;
									}
									
					##################################
					$Poesia_Last_id=$db->Insert_ID();
					##################################	
					
					$CadedenaLiteraria = $CadedenaLiteraria.'::Poesia-'.$Poesia_Last_id;		
				
				}
			if($cuento!=0){
				
				$SQL_Literario='INSERT INTO  estudiantearteliterario (idestudiantegeneral,arteliterario,tipoarteliterario,frecuencialiteraria,cualarteliterario,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Literaria.'","'.$cuento.'","'.$Nivel_cuento.'","",NOW(),"'.$userid.'")';
				
								if($InsertLiteraria=&$db->Execute($SQL_Literario)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Literario;
										echo json_encode($a_vectt);
										exit;
									}
									
					##################################
					$Cuento_Last_id=$db->Insert_ID();
					##################################			
					
					$CadedenaLiteraria = $CadedenaLiteraria.'::Cuento-'.$Cuento_Last_id;		
				
				}
			if($novela!=0){
				
				$SQL_Literario='INSERT INTO  estudiantearteliterario (idestudiantegeneral,arteliterario,tipoarteliterario,frecuencialiteraria,cualarteliterario,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Literaria.'","'.$novela.'","'.$Nivel_novela.'","",NOW(),"'.$userid.'")';
								
								if($InsertLiteraria=&$db->Execute($SQL_Literario)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Literario;
										echo json_encode($a_vectt);
										exit;
									}
									
					##################################
					$Novela_Last_id=$db->Insert_ID();
					##################################	
					
					$CadedenaLiteraria = $CadedenaLiteraria.'::Novela-'.$Novela_Last_id;			
				
				}
			if($cronica!=0){
				
				$SQL_Literario='INSERT INTO  estudiantearteliterario (idestudiantegeneral,arteliterario,tipoarteliterario,frecuencialiteraria,cualarteliterario,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Literaria.'","'.$cronica.'","'.$Nivel_cronica.'","",NOW(),"'.$userid.'")';
				
								if($InsertLiteraria=&$db->Execute($SQL_Literario)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Literario;
										echo json_encode($a_vectt);
										exit;
									}
									
									
					##################################
					$Cronica_Last_id=$db->Insert_ID();
					##################################	
					
					$CadedenaLiteraria = $CadedenaLiteraria.'::Cronica-'.$Cronica_Last_id;				
				
				}
			if($Otro_Literatura!=0){
				
				$SQL_Literario='INSERT INTO  estudiantearteliterario (idestudiantegeneral,arteliterario,tipoarteliterario,frecuencialiteraria,cualarteliterario,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Literaria.'","'.$Otro_Literatura.'","'.$Nivel_Otro_Literatura.'","'.$Cual_Literatura.'",NOW(),"'.$userid.'")';
				
								if($InsertLiteraria=&$db->Execute($SQL_Literario)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Literario;
										echo json_encode($a_vectt);
										exit;
									}
									
					##################################
					$OtroLiteratura_Last_id=$db->Insert_ID();
					##################################
					
					$CadedenaLiteraria = $CadedenaLiteraria.'::OtroLiteratura-'.$OtroLiteratura_Last_id;				
				
				}
		}else{
			
			$SQL_Literario='INSERT INTO  estudiantearteliterario (idestudiantegeneral,arteliterario,tipoarteliterario,frecuencialiteraria,cualarteliterario,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Literaria.'","'.$Otro_Literatura.'","'.$Nivel_Otro_Literatura.'","'.$Cual_Literatura.'",NOW(),"'.$userid.'")';
			
			
								if($InsertLiteraria=&$db->Execute($SQL_Literario)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Literario;
										echo json_encode($a_vectt);
										exit;
									}
									
					##################################
					$NoLiteratura_Last_id=$db->Insert_ID();
					##################################	
					
					$CadedenaLiteraria = $CadedenaLiteraria.'::NoLiteratura-'.$NoLiteratura_Last_id;			
			
			}
		
		#
		
		$CadenaPlastica = '';
		
		if($Plastica==0){
				if($fotografia!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$fotografia.'","'.$Nivel_fotografia.'","",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$Fotografia_Last_id=$db->Insert_ID();
						##################################
						
						$CadenaPlastica =$CadenaPlastica.'::Fotografia-'.$Fotografia_Last_id;			
					
					}
				if($video!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$video.'","'.$Nivel_video.'","",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$Video_Last_id=$db->Insert_ID();
						##################################
						
						$CadenaPlastica =$CadenaPlastica.'::Video-'.$Video_Last_id;						
					
					}
				if($DiseñoGrafico!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$DiseñoGrafico.'","'.$Nivel_DiseñoGrafico.'","",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$DiseñoGrafico_Last_id=$db->Insert_ID();
						##################################	
						
						$CadenaPlastica =$CadenaPlastica.'::DisenoGrafico-'.$DiseñoGrafico_Last_id;		
					
					}
				if($Comic!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Comic.'","'.$Nivel_Comic.'","",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
						
						##################################
						$Comic_Last_id=$db->Insert_ID();
						##################################	
						
						$CadenaPlastica =$CadenaPlastica.'::Comic-'.$Comic_Last_id;		
									
					}
				if($Dibujo!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Dibujo.'","'.$Nivel_Dibujo.'","",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$Dibujo_Last_id=$db->Insert_ID();
						##################################
						
						$CadenaPlastica =$CadenaPlastica.'::Dibujo-'.$Dibujo_Last_id;			
					
					}
				if($Grafitty!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Grafitty.'","'.$Nivel_Grafitty.'","",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$Grafitty_Last_id=$db->Insert_ID();
						##################################	
						
						$CadenaPlastica =$CadenaPlastica.'::Grafitty-'.$Grafitty_Last_id;			
					
					}
				if($Escultura!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Escultura.'","'.$Nivel_Escultura.'","",NOW(),"'.$userid.'")';
					
									if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
						
						##################################
						$Escultura_Last_id=$db->Insert_ID();
						##################################	
						
						$CadenaPlastica =$CadenaPlastica.'::Escultura-'.$Escultura_Last_id;		
					
					}
				if($Pintura!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Pintura.'","'.$Nivel_Pintura.'","",NOW(),"'.$userid.'")';
							
									if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$Pintura_Last_id=$db->Insert_ID();
						##################################	
						
						$CadenaPlastica =$CadenaPlastica.'::Pintura-'.$Pintura_Last_id;		
					
					}
				if($Otro_Plastico!=0){
					
					$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Otro_Plastico.'","'.$Nivel_Otro_Plastico.'","'.$Cual_ArtePlastico.'",NOW(),"'.$userid.'")';
					
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$OtroPlastico_Last_id=$db->Insert_ID();
						##################################
						
						$CadenaPlastica =$CadenaPlastica.'::OtroPlastico-'.$OtroPlastico_Last_id;			
					
					}
		}else{
			
			$SQL_Plastica='INSERT INTO estudiantearteplastica(idestudiantegeneral,arteplastica,tipoarteplastico,frecuenciaplastica,cualarteplastica,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Plastica.'","'.$Otro_Plastico.'","'.$Nivel_Otro_Plastico.'","'.$Cual_ArtePlastico.'",NOW(),"'.$userid.'")';
			
								if($InsertPlastica=&$db->Execute($SQL_Plastica)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
										echo json_encode($a_vectt);
										exit;
									}
									
						##################################
						$NoPlastico_Last_id=$db->Insert_ID();
						##################################	
						
						$CadenaPlastica =$CadenaPlastica.'::NoPlastico-'.$NoPlastico_Last_id;					
			
			}
			
	#######################################
	
		$a_vectt['val']						='TRUE';
		#$a_vectt['descrip']		='Error en la Insertar del Registro del Estudiante.....'.$SQL_Plastica;
		$a_vectt['CondicionSalud_id']     	=$CondicionSalud_Last_id;
		$a_vectt['Sarampion_id'] 			=$Sarampion_Last_id; 
		$a_vectt['Rubeola_id'] 				=$Rubeola_Last_id;
		$a_vectt['Tetano']  				=$Tetano_Last_id;
		$a_vectt['HepatitisB_id'] 			=$Hepatitis_B_Last_id;
		$a_vectt['VPH_id'] 					=$VPH_Last_id;
		$a_vectt['HabitoSaludable_id']		=$HabitoSaludable_Last_id;
		$a_vectt['ActividaFisica_id'] 		=$ActividaFisica_Last_id;
		$a_vectt['CadenaDeporte'] 			=$CadenaDeporte;
		$a_vectt['CadenaMusica'] 			=$CadenaMusica;
		$a_vectt['CadenaExpreCorporal'] 	=$CadenaExpreCorporal;
		$a_vectt['CadenaArteEscenica'] 		=$CadenaArteEscenica;
		$a_vectt['CadedenaLiteraria'] 		=$CadedenaLiteraria;
		$a_vectt['CadenaPlastica'] 			=$CadenaPlastica;
		echo json_encode($a_vectt);
		exit;
	
	#######################################		
			
	}#-->$GuardarSave
	$a_vectt['val']						='EXIT';
	echo json_encode($a_vectt);
		exit;
		
		########################################################################################################################################################################################################
		}break;
	case 'DeleteRecurso':{
		MainJson();
		global $db,$userid;
		
		
		$id_RecursoEstudiante    = $_GET['id_RecursoEstudiante'];
		$id                      = $_GET['id'];
		$id_Estudiante           = $_GET['id_Estudiante'];
		
		
		 $SQL_UP_DeleteRecurso='UPDATE  estudianterecursofinanciero
												
								SET     codigoestado=200
								
								WHERE   idestudiantegeneral="'.$id_Estudiante.'"  AND  idtipoestudianterecursofinanciero="'.$id.'"  AND   idestudianterecursofinanciero="'.$id_RecursoEstudiante.'"';
		
		
								 if($DeleteRecurso=&$db->Execute($SQL_UP_DeleteRecurso)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UP_DeleteRecurso;
									echo json_encode($a_vectt);
									exit;
								}
								
					$a_vectt['val']			='TRUE';
					echo json_encode($a_vectt);
					exit;				
		
		}break;
	case 'DeleteMedio':{
		MainJson();
		global $db,$userid;
		
		
		$id_EstudioanteMedio     = $_GET['id_EstudioanteMedio'];
		$id                      = $_GET['id'];
		$id_Estudiante           = $_GET['id_Estudiante'];
		
		  $SQL_Up_DeleteMedio='UPDATE	estudiantemediocomunicacion
										
							   SET		codigoestadoestudiantemediocomunicacion=200
										
							   WHERE	idestudiantegeneral="'.$id_Estudiante.'"  AND  idestudiantemediocomunicacion="'.$id_EstudioanteMedio.'"  AND  codigomediocomunicacion="'.$id.'"';
							   
							   if($DeleteMedio=&$db->Execute($SQL_Up_DeleteMedio)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_Up_DeleteMedio;
									echo json_encode($a_vectt);
									exit;
								}
								
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_Up_DeleteMedio;
					echo json_encode($a_vectt);
					exit;				
		
		}break;
	case 'SaveTabTres':{
		MainJson();
		global $db,$userid;
		
		
		$CadenaRecursoFianciero        = $_GET['CadenaRecursoFianciero'];
		$ComentariosRecursos           = $_GET['ComentariosRecursos'];
		$id_Estudiante                 = $_GET['id_Estudiante'];
		$Cadena_Medios                 = $_GET['Cadena_Medios'];
		
		
		
		$SQL_Inscripcion = 'SELECT 

							MAX(idinscripcion) as id
							
							
							FROM inscripcion
							
							
							WHERE
							
							idestudiantegeneral="'.$id_Estudiante.'"
							AND
							codigoestado=100';
							
							if($Inscrip=&$db->Execute($SQL_Inscripcion)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en el Consulta de la tabla ....'.$SQL_Inscripcion;
									echo json_encode($a_vectt);
									exit;
								}
								
		$inscripcion = $Inscrip->fields['id'];						
		
		/******************************************************************/
		
			$D_Medios = explode('::',$Cadena_Medios);
			
			#echo '<pre>';print_r($D_Medios);
			
			for($k=1;$k<count($D_Medios);$k++){
					
					$D_MediosDetalle = explode('-',$D_Medios[$k]);

						
						if(!$D_MediosDetalle[2]){
							
								 $SQL_InsertMedio='INSERT INTO estudiantemediocomunicacion (idestudiantegeneral,idinscripcion,codigomediocomunicacion,codigoestadoestudiantemediocomunicacion,observacionestudiantemediocomunicacion)VALUES("'.$id_Estudiante.'","'.$inscripcion.'","'.$D_MediosDetalle[0].'","100","'.$D_MediosDetalle[1].'")';
								 
								 	if($InsertMedio=&$db->Execute($SQL_InsertMedio)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insert del Registro del Estudiante.....'.$SQL_InsertMedio;
										echo json_encode($a_vectt);
										exit;
									}
									
									
									##################################
									$Last_idMedio=$db->Insert_ID();
									##################################
								 
							}else{
									
									
									$SQL_Up_Medio='UPDATE	estudiantemediocomunicacion
										
												   SET		codigomediocomunicacion="'.$D_MediosDetalle[0].'",
															observacionestudiantemediocomunicacion="'.$D_MediosDetalle[1].'"
															
												   WHERE	idestudiantegeneral="'.$id_Estudiante.'"  AND  idestudiantemediocomunicacion="'.$D_MediosDetalle[2].'"  AND  codigoestadoestudiantemediocomunicacion=100';
																   
																   
										if($UpdateMedio=&$db->Execute($SQL_Up_Medio)===false){
												$a_vectt['val']			='FALSE';
												$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_Up_Medio;
												echo json_encode($a_vectt);
												exit;
											}	
											
										##################################
										$Last_idMedio=$D_MediosDetalle[2];
										##################################
												   
								}
								
					##############################
					$CadenaMediosLast = $CadenaMediosLast.'::'.$D_MediosDetalle[0].'-'.$Last_idMedio;
					##############################			
					
				}
		
		/******************************************************************/
		/******************************************************************/
			
			$D_RecursoFinaciero  = explode('::',$CadenaRecursoFianciero);

			
				for($f=1;$f<count($D_RecursoFinaciero);$f++){
						
							$D_RecursoDetalle = explode('-',$D_RecursoFinaciero[$f]);

						if(!$D_RecursoDetalle[1]){		
						
							$SQL_InsertRecurso='INSERT INTO  estudianterecursofinanciero(idestudiantegeneral,idtipoestudianterecursofinanciero,descripcionestudianterecursofinanciero,codigoestado)VALUES("'.$id_Estudiante.'","'.$D_RecursoDetalle[0].'","'.$ComentariosRecursos.'","100")';
							
								if($InsertRecurso=&$db->Execute($SQL_InsertRecurso)===false){
										$a_vectt['val']			='FALSE';
										$a_vectt['descrip']		='Error en la Insert del Registro del Estudiante.....'.$SQL_InsertRecurso;
										echo json_encode($a_vectt);
										exit;
									}	
									
								##################################
								$Last_idRecurso=$db->Insert_ID();
								##################################	
							
						}else{
								$SQL_UpRecurso='UPDATE  estudianterecursofinanciero
												
												SET     descripcionestudianterecursofinanciero="'.$ComentariosRecursos.'"
												
												WHERE   idestudiantegeneral="'.$id_Estudiante.'"  AND  idtipoestudianterecursofinanciero="'.$D_RecursoDetalle[1].'"  AND  codigoestado=100  AND  idestudianterecursofinanciero="'.$D_RecursoDetalle[1].'"';
												
										if($ModificarRecurso=&$db->Execute($SQL_UpRecurso)===false){
												$a_vectt['val']			='FALSE';
												$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpRecurso;
												echo json_encode($a_vectt);
												exit;
											}
											
									##################################
									$Last_idRecurso=$D_RecursoDetalle[1];
									##################################	
														
							}
						
					##################################
					$CadenaFinacieraLast = $CadenaFinacieraLast.'::'.$D_RecursoDetalle[0].'-'.$Last_idRecurso;
					##################################		
						
				}
		/******************************************************************/													  
		
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Insert del Registro del Estudiante.....'.$SQL_InsertRecurso;
				#$a_vectt['MediosLast']		=$CadenaMediosLast;
				$a_vectt['FinacieraLast']		=$CadenaFinacieraLast;  
				echo json_encode($a_vectt);
				exit;
		
		}break;
	case 'SaveTabDos':{
		MainJson();
		global $db,$userid;
		
		
		
		$Si_Participa                = $_GET['Si_Participa'];
		$Semillero_inv               = $_GET['Semillero_inv'];
		$Repre_Colegio               = $_GET['Repre_Colegio'];
		$Parti_Semillero             = $_GET['Parti_Semillero'];
		$Otra_Participacion          = $_GET['Otra_Participacion'];
		$Part_Congreso               = $_GET['Part_Congreso'];
		$Intercambio                 = $_GET['Intercambio'];
		$Ninguna                     = $_GET['Ninguna'];
		$Cual_Participacion          = $_GET['Cual_Participacion'];
		$Si_Logros                   = $_GET['Si_Logros'];
		$GradoMeritorio              = $_GET['GradoMeritorio'];
		$MencionAcad                 = $_GET['MencionAcad'];
		$mencionActvExt              = $_GET['mencionActvExt'];
		$Becas                       = $_GET['Becas'];
		$Ninguna_Logro               = $_GET['Ninguna_Logro'];
		$Otro_Logro                  = $_GET['Otro_Logro'];
		$Cual_Logro                  = $_GET['Cual_Logro'];
		$Nivel_Secundaria            = $_GET['Nivel_Secundaria'];
		$Id_nivelSecundaria          = $_GET['Id_nivelSecundaria'];
		$Institucion                 = $_GET['Institucion'];
		$Id_Colegio                  = $_GET['Id_Colegio'];
		$id_TituloColegio            = $_GET['id_TituloColegio'];
		$Ciudad_Cole                 = $_GET['Ciudad_Cole'];
		$Pertenece_Cundi             = $_GET['Pertenece_Cundi'];
		$YearCole                    = $_GET['YearCole'];
		$Observacion                 = $_GET['Observacion'];
		$id_Estudiante               = $_GET['id_Estudiante'];
		$Guardar                     = $_GET['Guardar'];	
		$id_registroLogros           = $_GET['id_registroLogros'];
		$id_RegistroNewActividad     = $_GET['id_RegistroNewActividad'];
		$id_ColegioSave              = $_GET['id_ColegioSave'];
		
		
		$Last_idParticipa='';
		$Last_idLogros = '';	
		
if($Guardar=='true'){	

	if(!$id_RegistroNewActividad){	
			
		if($Si_Participa==0 || $Si_Participa==1){
				/******************************************************************************************************************************************************************************************/
					$SQL_InsertParticipa='INSERT INTO estudianteparticipacionacademica(idestudiantegeneral,participaacademicamente,reprecolegioactividades,semilleroinvestigacion,participasemilleros,participacioncongresos,intercambio,ninguna,otra,cual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Si_Participa.'","'.$Repre_Colegio.'","'.$Semillero_inv.'","'.$Parti_Semillero.'","'.$Part_Congreso.'","'.$Intercambio.'","'.$Ninguna.'","'.$Otra_Participacion.'","'.$Cual_Participacion.'",NOW(),"'.$userid.'")';

					
					if($InsertPractrica=&$db->Execute($SQL_InsertParticipa)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error en la Insert del Registro del Estudiante.....'.$SQL_InsertParticipa;
							echo json_encode($a_vectt);
							exit;
						}
						
					##################################
					$Last_idParticipa=$db->Insert_ID();
					##################################		
					
				/******************************************************************************************************************************************************************************************/
			}
	   }else{
		   			$SQL_UP_Participa='UPDATE   estudianteparticipacionacademica
					
									   SET		participaacademicamente="'.$Si_Participa.'",
									   			reprecolegioactividades="'.$Repre_Colegio.'",
												participasemilleros="'.$Semillero_inv.'",
												participacioncongresos="'.$Part_Congreso.'",
												intercambio="'.$Intercambio.'",
												ninguna="'.$Ninguna.'",
												otra="'.$Otra_Participacion.'",
												cual="'.$Cual_Participacion.'",
												changedate=NOW(),
												useridestado="'.$userid.'"
												
									   WHERE	idestudiantegeneral="'.$id_Estudiante.'" AND idestudianteparticipacionacademica="'.$id_RegistroNewActividad.'"  AND codigoestado=100';
									   
					#echo '<br>-->SQL_UP_Participa'.$SQL_UP_Participa;				   	
									   
					if($UpdatePractrica=&$db->Execute($SQL_UP_Participa)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UP_Participa;
							echo json_encode($a_vectt);
							exit;
						}	
						
					$Last_idParticipa   =  $id_RegistroNewActividad;
				   
									   
		   }
	
	
	if(!$id_registroLogros){	
	
		if($Si_Logros==0  || $Si_Logros==1){
				/******************************************************************************************************************************************************************************************/
				$SQL_InsertLogros='INSERT INTO estudiantelogrosdestinciones(idestudiantegeneral,logrosdestinciones,gradomeritorio,mencionacademica,mencionextracurricular,becas,ninguna,otra,cual,entrydate,userid)VALUES("'.$id_Estudiante.'","'.$Si_Logros.'","'.$GradoMeritorio.'","'.$MencionAcad.'","'.$mencionActvExt.'","'.$Becas.'","'.$Ninguna_Logro.'","'.$Otro_Logro.'","'.$Cual_Logro.'",NOW(),"'.$userid.'")';
				
					if($InsertLogros=&$db->Execute($SQL_InsertLogros)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error en la Insert del Registro del Estudiante.....'.$SQL_InsertLogros;
							echo json_encode($a_vectt);
							exit;
						}
						
					##################################
					$Last_idLogros=$db->Insert_ID();
					##################################		
		
				
				/******************************************************************************************************************************************************************************************/
			}
	   }else{
		   		$SQL_UP_Logros='UPDATE	 estudiantelogrosdestinciones
				
								SET		 logrosdestinciones="'.$Si_Logros.'",
										 gradomeritorio="'.$GradoMeritorio.'",
										 mencionacademica="'.$MencionAcad.'",
										 mencionextracurricular="'.$mencionActvExt.'",
										 becas="'.$Becas.'",
										 ninguna="'.$Ninguna_Logro.'",
										 otra="'.$Otro_Logro.'",
										 cual="'.$Cual_Logro.'",
										 changedate=NOW(),
										 useridestado="'.$userid.'"  
										 
								WHERE	 idestudiantegeneral="'.$id_Estudiante.'"  AND idestudiantelogrosdestinciones="'.$id_registroLogros.'" AND codigoestado=100';
								
						if($UpdateLogros=&$db->Execute($SQL_UP_Logros)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UP_Logros;
								echo json_encode($a_vectt);
								exit;
							}
							
					$Last_idLogros = $id_registroLogros;			
								
		   }
	   
}

/**************************************************************************************************************************************************************************************************************/

				$SQL_UpColegio='UPDATE  estudianteestudio
				
								SET		idniveleducacion="'.$Id_nivelSecundaria.'",
										anogradoestudianteestudio="'.$YearCole.'",
										idinstitucioneducativa="'.$Id_Colegio.'",
										otrainstitucioneducativaestudianteestudio="'.$Institucion.'",
										codigotitulo="'.$id_TituloColegio.'",
										observacionestudianteestudio="'.$Observacion.'",
										ciudadinstitucioneducativa="'.$Ciudad_Cole.'",
										colegiopertenececundinamarca="'.$Pertenece_Cundi.'"
										
								WHERE	idestudiantegeneral="'.$id_Estudiante.'"    AND  idestudianteestudio="'.$id_ColegioSave.'"  AND  codigoestado=100';
								
						if($UpdateColegio=&$db->Execute($SQL_UpColegio)===false){
								$a_vectt['val']			='FALSE';
								$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpColegio;
								echo json_encode($a_vectt);
								exit;
							}		
						
		
													 
/**************************************************************************************************************************************************************************************************************/
		
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en la Modificar del Registro del Estudiante.....'.$SQL_UpColegio;
				$a_vectt['Last_idParticipa']            =$Last_idParticipa;
				$a_vectt['Last_idLogros']		     	=$Last_idLogros;
				echo json_encode($a_vectt);
				exit;
		
		
		}break;
	case 'Save_TabUno':{
		MainJson();
		global $db,$userid;
		
		
		$Nombre                   = $_GET['Nombre'];
		$Apellidos                = $_GET['Apellidos'];
		$TipoDocumento            = $_GET['TipoDocumento'];
		$Num_Documento       	  = $_GET['Num_Documento'];
		$Expedida_Doc       	  = $_GET['Expedida_Doc'];
        $FechaDocu                = $_GET['FechaDocu'];
		$Genero        			  = $_GET['Genero'];
		$EstadiCivil       		  = $_GET['EstadiCivil'];
		$Estrato        		  = $_GET['Estrato'];
		$LibretaMilitar       	  = $_GET['LibretaMilitar'];
		$Distrito        		  = $_GET['Distrito'];
		$ExpedidaLibreta          = $_GET['ExpedidaLibreta'];
		$Ciuda_Naci       		  = $_GET['Ciuda_Naci'];
		$FechaNaci        		  = $_GET['FechaNaci'];
		$Dir_recidente    	      = $_GET['Dir_recidente'];
		$Tel_Recidente     		  = $_GET['Tel_Recidente'];
		$id_CiudadResid           = $_GET['id_CiudadResid'];
		$EmailBosque       		  = $_GET['EmailBosque'];
		$Email_2        		  = $_GET['Email_2'];
		$Nombre_Emerg     	      = $_GET['Nombre_Emerg'];
		$Parentesco       		  = $_GET['Parentesco'];
		$Telefono1_Parent         = $_GET['Telefono1_Parent'];
		$Telefono1_Parent2        = $_GET['Telefono1_Parent2'];
		$Eps       				  = $_GET['Eps'];
		$Tipo_Eps     			  = $_GET['Tipo_Eps'];
		$Familia       			  = $_GET['Familia'];
		$id_Estudiante            = $_GET['id_Estudiante'];
		$id_CiudadOrigen		  = $_GET['id_CiudadOrigen'];
        $Es_Extranjero            = $_GET['Es_Extranjero'];
		$GrupoEtnico			  = $_GET['GrupoEtnico'];
		$TipoSanguineo			  = $_GET['TipoSanguineo'];
		
		  $SQL_UpdateEstudiante='UPDATE estudiantegeneral 
								 SET    idestadocivil="'.$EstadiCivil.'" ,
										tipodocumento="'.$TipoDocumento.'" ,
										numerodocumento="'.$Num_Documento.'" ,
										expedidodocumento="'.$Expedida_Doc .'" ,
										numerolibretamilitar="'.$LibretaMilitar.'",
										numerodistritolibretamilitar="'.$Distrito.'",
										expedidalibretamilitar="'.$ExpedidaLibreta.'",
										nombresestudiantegeneral="'.$Nombre.'",
										apellidosestudiantegeneral="'.$Apellidos.'",
										fechanacimientoestudiantegeneral="'.$FechaNaci.'",
										idciudadnacimiento="'.$Ciuda_Naci.'",
										codigogenero="'.$Genero.'",
										direccionresidenciaestudiantegeneral="'.$Dir_recidente.'",
										ciudadresidenciaestudiantegeneral="'.$id_CiudadResid.'",
										telefonoresidenciaestudiantegeneral="'.$Tel_Recidente.'",
										emailestudiantegeneral="'.$EmailBosque.'",
										email2estudiantegeneral="'.$Email_2.'",
										fechaactualizaciondatosestudiantegeneral=NOW(),
										casoemergenciallamarestudiantegeneral="'.$Nombre_Emerg.'",
										telefono1casoemergenciallamarestudiantegeneral="'.$Telefono1_Parent.'",
										telefono2casoemergenciallamarestudiantegeneral="'.$Telefono1_Parent2.'",
										idtipoestudiantefamilia="'.$Parentesco.'",
										eps_estudiante="'.$Eps.'",
										tipoafiliacion="'.$Tipo_Eps.'",
										idciudadorigen="'.$id_CiudadOrigen.'",
                                        esextranjeroestudiantegeneral="'.$Es_Extranjero.'",
                                        FechaDocumento="'.$FechaDocu.'",
                                        GrupoEtnicoId="'.$GrupoEtnico.'",
                                        fechaactualizaciondatosestudiantegeneral = "'. date("Y-m-d G:i:s", time()) .'"
										
								WHERE
										idestudiantegeneral="'.$id_Estudiante.'"';
										
				
				$SQL_UpdateTipoSanguineo = 'UPDATE 
												gruposanguineoestudiante 
											SET idtipogruposanguineo = "'.$TipoSanguineo.'"
											WHERE idestudiantegeneral = "'.$id_Estudiante.'"';
											
				if($UpdateTipoSanguineo=&$db->Execute($SQL_UpdateTipoSanguineo)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificacion del Tipo Sanguineo del Estudiante.....'.$SQL_UpdateTipoSanguineo;
									echo json_encode($a_vectt);
									exit;
								}				
							
				#echo 'SQL_UpdateEstudiante-->'. $SQL_UpdateEstudiante;			
										
							if($Mod_Estudiante=&$db->Execute($SQL_UpdateEstudiante)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificacion del Registro del Estudiante.....'.$SQL_UpdateEstudiante;
									echo json_encode($a_vectt);
									exit;
								}			
										
		
		/********************************************************************************************************************/					
		
		 $SQL_Verifica='SELECT 
						
						es.idestratohistorico as id,
						es.idestrato
						FROM 
						
						estratohistorico AS es 
						WHERE
						
						es.idestudiantegeneral="'.$id_Estudiante.'"
						
						AND
						es.codigoestado=100';
						
			if($VerificaEstrato=&$db->Execute($SQL_Verifica)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en la Validacion del Estrato del Estudiante.....'.$SQL_Verifica;
					echo json_encode($a_vectt);
					exit;
				}			
							
		
		if(!$VerificaEstrato->EOF){
				################################################
				$SQL_Up_Estrato='UPDATE  estratohistorico
				
								 SET     idestrato="'.$Estrato.'"
		
								 WHERE   
								 		 idestudiantegeneral="'.$id_Estudiante.'" AND  codigoestado=100 AND idestratohistorico="'.$VerificaEstrato->fields['id'].'"';
										 
							if($Mod_Estrato=&$db->Execute($SQL_Up_Estrato)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en la Modificacion del Estrato del Estudiante.....'.$SQL_Up_Estrato;
									echo json_encode($a_vectt);
									exit;
								}			 					
				################################################		
			}else{
					#####################################################
					$SQL_insertEstrato='INSERT INTO estratohistorico(idestrato,idestudiantegeneral,fechaingresoestratohistorico,codigoestado)VALUES("'.$Estrato.'","'.$id_Estudiante.'",NOW(),"100")';
					
						if($Insert_Estrato=&$db->Execute($SQL_insertEstrato)===false){
							$a_vectt['val']			='FALSE';
							$a_vectt['descrip']		='Error al Insert el Estrato del Estudiante.....'.$SQL_insertEstrato;
							echo json_encode($a_vectt);
							exit;
						}
					
					#####################################################
				}
		
		
		/********************************************************************************************************************/
		
		
		/***************************Explode al la Cadena de Familia********************************/
			
			$D_Familia = explode('::',$Familia);
			
			#echo '<pre>';print_r($D_Familia);
			$Ultimos_id = '';
			
			for($x=1;$x<count($D_Familia);$x++){
					$D_FamiliaDetalle = explode('-',$D_Familia[$x]);
					
					#echo '<pre>';print_r($D_FamiliaDetalle);
					
					/*
					    $D_FamiliaDetalle[0] => id
						$D_FamiliaDetalle[1] => Parentesco_id
						$D_FamiliaDetalle[2] => Nombres
						$D_FamiliaDetalle[3] => Apellidos
						$D_FamiliaDetalle[4] => Ocupacion
						$D_FamiliaDetalle[5] => Nivel educacion id
						$D_FamiliaDetalle[6] => Tel
						$D_FamiliaDetalle[7] => Ciudad_id_Familia
						$D_FamiliaDetalle[8] => j
					*/
					
					if($D_FamiliaDetalle[0]){
							#################################
							$SQL_Up_Familia='UPDATE estudiantefamilia
											 SET	
											 		apellidosestudiantefamilia="'.$D_FamiliaDetalle[3].'",
													nombresestudiantefamilia="'.$D_FamiliaDetalle[2].'",
													telefonoestudiantefamilia="'.$D_FamiliaDetalle[6].'",
													idtipoestudiantefamilia="'.$D_FamiliaDetalle[1].'",
													ocupacionestudiantefamilia="'.$D_FamiliaDetalle[4].'",
													idniveleducacion="'.$D_FamiliaDetalle[5].'",
													idciudadestudiantefamilia="'.$D_FamiliaDetalle[7].'"
													
											 WHERE
											 		codigoestado=100 AND idestudiantegeneral="'.$id_Estudiante.'" AND  idestudiantefamilia="'.$D_FamiliaDetalle[0].'"';
												
												
										if($Mod_FamiliaEstudiante=&$db->Execute($SQL_Up_Familia)===false){
												$a_vectt['val']			='FALSE';
												$a_vectt['descrip']		='Error al Modificar Los Datos de la Familia del Estudiante.....'.$SQL_Up_Familia;
												echo json_encode($a_vectt);
												exit;
											}			
													
							################################	
						}else{
								############################
								$SQL_InsertFamilia='INSERT INTO estudiantefamilia(apellidosestudiantefamilia,nombresestudiantefamilia,telefonoestudiantefamilia,idtipoestudiantefamilia,ocupacionestudiantefamilia,idniveleducacion,idestudiantegeneral,codigoestado,idciudadestudiantefamilia)VALUES("'.$D_FamiliaDetalle[3].'","'.$D_FamiliaDetalle[2].'","'.$D_FamiliaDetalle[6].'","'.$D_FamiliaDetalle[1].'","'.$D_FamiliaDetalle[4].'","'.$D_FamiliaDetalle[5].'","'.$id_Estudiante.'","100","'.$D_FamiliaDetalle[7].'")';
								
								if($Insert_FamiliaEstudiante=&$db->Execute($SQL_InsertFamilia)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error al Insertar Los Datos de la Familia del Estudiante.....'.$SQL_InsertFamilia;
									echo json_encode($a_vectt);
									exit;
								}
								
								############################	
								##################################
								$Last_id=$db->Insert_ID();
								##################################	
								$Ultimos_id = $Ultimos_id.'::'.$Last_id.'-'.$D_FamiliaDetalle[8];
							}
					
				}
			
		/******************************************************************************************/		
			
		
			$a_vectt['val']			='TRUE';
			$a_vectt['Ultimos_id']	=$Ultimos_id;
			echo json_encode($a_vectt);
			exit;
													  
		
		}break;
	case 'Atras':{
		 define(AJAX,'TRUE');
		 MainGeneral();
		 JsGenral();
		 
		 global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		 
		 $C_Hoja_Vida->Principal();
		}break;
	case 'Save_Idioma':{
		MainJson();
		global $db,$userid;
		
		
		$id_Estudiante      = $_GET['id_Estudiante'];
		$id_idioma          = $_GET['id_idioma'];
		$id_registro        = $_GET['id_registro'];
		$Guardado           = $_GET['Guardado'];
		$ValorChechk        = $_GET['ValorChechk'];
		
		if($Guardado==0 || $Guardado=='0'){
			/************************************SAVE******************************************/
			
				$SQL_Idiomas='INSERT INTO estudianteidioma(idestudiantegeneral,ididioma,porcentajeleeestudianteidioma,porcentajeescribeestudianteidioma,porcentajehablaestudianteidioma,codigoestado)VALUES("'.$id_Estudiante.'","'.$id_idioma.'","'.$ValorChechk.'","'.$ValorChechk.'","'.$ValorChechk.'","100")';
				
				$Error='Error al Insertar en la Tabla de los idiomas Estudiantes';
			
			/************************************SAVE******************************************/
			}else{
				/************************************UPDATE******************************************/	
				
					$SQL_Idiomas='UPDATE estudianteidioma
								  
								  SET    porcentajeleeestudianteidioma="'.$ValorChechk.'",
								  		 porcentajeescribeestudianteidioma="'.$ValorChechk.'",
										 porcentajehablaestudianteidioma="'.$ValorChechk.'"
										 
								  WHERE  idestudiantegeneral="'.$id_Estudiante.'"  AND  idestudianteidioma="'.$id_registro.'" AND codigoestado=100';
								  
					$Error='Error al Modificar en la Tabla de los idiomas Estudiantes';			  
				
				/************************************UPDATE******************************************/	
				}		
		
		
				if($Loding_IdiomasEstud=&$db->Execute($SQL_Idiomas)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		=$Error.$SQL_Idiomas;
						echo json_encode($a_vectt);
						exit;
					}
				
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		=$Error.$SQL_Idiomas;
				echo json_encode($a_vectt);
				exit;	
		
		
		}break;
	case 'Delete_Univerd':{
		MainJson();
		global $db,$userid;
		
		$id_Estudiante      = $_GET['id_Estudiante'];
		$id                 = $_GET['id'];
		
		
		$SQL_Update='UPDATE estudianteestudio
		
					 SET	codigoestado=200
					
					 WHERE  idestudiantegeneral="'.$id_Estudiante.'"  AND idestudianteestudio="'.$id.'"';
					 
					if($Update_OtraEstudio=&$db->Execute($SQL_Update)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en el Eliminar en la tabla ....'.$SQL_Update;
						echo json_encode($a_vectt);
						exit;
					}
				
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error en el Insertar en la tabla ....'.$SQL_Insert;
					echo json_encode($a_vectt);
					exit;	
		
		}break;
	case 'Update_Univerd':{
		MainJson();
		global $db,$userid;
		
		$Nivel    			= $_GET['Nivel'];
		$Name      			= $_GET['Name'];
		$Titulo   			= $_GET['Titulo'];
		$Ciudad   			= $_GET['Ciudad'];
		$Year      			= $_GET['Year'];
		$id_Estudiante      = $_GET['id_Estudiante'];
		$id_Univd  	        = $_GET['id_Univd'];
		$id_Titulo          = $_GET['id_Titulo'];
		$id                 = $_GET['id'];
		
		
		$SQL_Update='UPDATE estudianteestudio
		
					 SET	idniveleducacion="'.$Nivel.'",
					 		anogradoestudianteestudio="'.$Year.'",
							idinstitucioneducativa="'.$id_Univd.'",
							otrainstitucioneducativaestudianteestudio="'.$Name.'",
							codigotitulo="'.$id_Titulo.'",
							otrotituloestudianteestudio="'.$Titulo.'",
							ciudadinstitucioneducativa="'.$Ciudad.'"
					
					 WHERE  idestudiantegeneral="'.$id_Estudiante.'" AND codigoestado=100 AND idestudianteestudio="'.$id.'"';
					 
					if($Update_OtraEstudio=&$db->Execute($SQL_Update)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en el Modificar en la tabla ....'.$SQL_Update;
						echo json_encode($a_vectt);
						exit;
					}
				
					$a_vectt['val']			='TRUE';
					#$a_vectt['descrip']		='Error en el Insertar en la tabla ....'.$SQL_Insert;
					echo json_encode($a_vectt);
					exit;	
		
		
		}break;
	case 'Cargar_OtrosEstud':{
		define(AJAX,'TRUE');
		 MainGeneral();
		 JsGenral();
		 
		 global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		 
		 $C_Hoja_Vida->OtrosEstudios($_GET['id_Estudiante']);
		}break;
	case 'AutoCompletTitulo':{
		MainJson();
		global $db,$userid;
		
		$Letra   = $_REQUEST['term'];
		$Dato    = $_REQUEST['Dato'];
		
		if($Dato==0){
			
				  $SQL_Titulo='SELECT 
									
											codigotitulo,
											nombretitulo
									
									FROM 
									
											titulo
									
									WHERE
									
											codigotitulo<>1
											AND
											nombretitulo  LIKE "%'.$Letra.'%"
											
									ORDER BY nombretitulo';					
											
								if($Titulo=&$db->Execute($SQL_Titulo)===false){
										echo 'Error en el SQL del Titulo............<br>'.$SQL_Titulo;
										die;
									}
									
					$Result_T = array();					
				
					while(!$Titulo->EOF){
						#################################################
						
							$Rf_Vectt['label']=$Titulo->fields['nombretitulo'];
							$Rf_Vectt['value']=$Titulo->fields['nombretitulo'];
							
							$Rf_Vectt['Titulo_id']=$Titulo->fields['codigotitulo'];
							
							array_push($Result_T,$Rf_Vectt);
						
						#################################################
						$Titulo->MoveNext();
						}
						
					echo json_encode($Result_T);							
			
			}
		}break;
	case 'Save_Univerd':{
		MainJson();
		global $db,$userid;
		
		$Nivel    			= $_GET['Nivel'];
		$Name      			= $_GET['Name'];
		$Titulo   			= $_GET['Titulo'];
		$Ciudad   			= $_GET['Ciudad'];
		$Year      			= $_GET['Year'];
		$id_Estudiante      = $_GET['id_Estudiante'];
		$Observacion        = $_GET['Observacion'];
		$id_Univd  	        = $_GET['id_Univd'];
		$id_Titulo          = $_GET['id_Titulo'];
				
			$SQL_Insert ='INSERT INTO estudianteestudio (idestudiantegeneral,idniveleducacion,anogradoestudianteestudio,idinstitucioneducativa,otrainstitucioneducativaestudianteestudio,codigotitulo,otrotituloestudianteestudio,observacionestudianteestudio,codigoestado,ciudadinstitucioneducativa)VALUES("'.$id_Estudiante.'","'.$Nivel.'","'.$Year.'","'.$id_Univd.'","'.$Name.'","'.$id_Titulo.'","'.$Titulo.'","'.$Observacion.'","100","'.$Ciudad.'")';	
			
			if($Insert_OtraEstudio=&$db->Execute($SQL_Insert)===false){
					$a_vectt['val']			='FALSE';
					$a_vectt['descrip']		='Error en el Insertar en la tabla ....'.$SQL_Insert;
					echo json_encode($a_vectt);
					exit;
				}
			
				$a_vectt['val']			='TRUE';
				#$a_vectt['descrip']		='Error en el Insertar en la tabla ....'.$SQL_Insert;
				echo json_encode($a_vectt);
				exit;	
												   
		
		}break;
	case 'AutoCompletUniversidad':{
		MainJson();
		global $db,$userid;
		
		$Letra   = $_REQUEST['term'];
		$Dato    = $_REQUEST['Dato'];
		
		if($Dato==0){
		
		 $SQL_Colegios='SELECT 

									idinstitucioneducativa,
									nombreinstitucioneducativa,
									paisinstitucioneducativa,
									departamentoinstitucioneducativa,
									municipioinstitucioneducativa
						
						FROM 
						
									institucioneducativa
						
						WHERE
						
									nombreinstitucioneducativa LIKE "%'.$Letra.'%"
									AND 
									idinstitucioneducativa<>1
									AND
									codigomodalidadacademica=200';
									
					if($Colegios=&$db->Execute($SQL_Colegios)===false){
							echo 'Error en el SQL de lOS Colegios....<br>'.$SQL_Colegios;
							die;
						}				
									
				$Result_C = array();					
				
				while(!$Colegios->EOF){
					#################################################
					
						$Rf_Vectt['label']=$Colegios->fields['nombreinstitucioneducativa'].'  ::  '.$Colegios->fields['municipioinstitucioneducativa'];
						$Rf_Vectt['value']=$Colegios->fields['nombreinstitucioneducativa'];
						
						$Rf_Vectt['id_Univerisidad']=$Colegios->fields['idinstitucioneducativa'];
						$Rf_Vectt['NameCiudad']=$Colegios->fields['municipioinstitucioneducativa'];
						
						array_push($Result_C,$Rf_Vectt);
					
					#################################################
					$Colegios->MoveNext();
					}
					
				echo json_encode($Result_C);	
		  }
		}break;
	case 'UPDATE_U':{
		MainJson();
		global $db,$userid;
		
		
		$institucion   = $_GET['institucion'];
		$Programa      = $_GET['Programa'];
		$Year          = $_GET['Year'];
		$id_Estudiante = $_GET['id_Estudiante'];
		$id            = $_GET['id'];
		
		
		$SQL_Mod='UPDATE estudianteuniversidad 
				  SET  institucioneducativaestudianteuniversidad="'.$institucion.'"  , 
				  	   programaacademicoestudianteuniversidad="'.$Programa.'"   ,
					   anoestudianteuniversidad = "'.$Year.'"
				  WHERE idestudianteuniversidad="'.$id.'"  AND  codigoestado=100';
				  
				  if($Update_U=&$db->Execute($SQL_Mod)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en el Modificar de la tabla ....'.$SQL_Mod;
						echo json_encode($a_vectt);
						exit;
					}
		
		
				  
			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error en el Modificar de la tabla ....'.$SQL_Mod;
			echo json_encode($a_vectt);
			exit;
		
		}break;
	case 'Delete_U':{
		MainJson();
		global $db,$userid;
		
		$id  = $_GET['id'];
		
		$SQL_Mod='UPDATE estudianteuniversidad 
				  SET  codigoestado=200
				  WHERE idestudianteuniversidad="'.$id.'"';
				  
				  if($Update_U=&$db->Execute($SQL_Mod)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en el Modificar de la tabla ....'.$SQL_Mod;
						echo json_encode($a_vectt);
						exit;
					}
				  
			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error en el Modificar de la tabla ....'.$SQL_Mod;
			echo json_encode($a_vectt);
			exit;
		
		}break;
	case 'Cargar_OtrasU':{
		define(AJAX,'TRUE');
		 MainGeneral();
		 JsGenral();
		 
		 global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		 
		 $C_Hoja_Vida->OtrasUniversidades($_GET['id_Estudiante']);
		 
		}break;
	case 'Save_U':{
		MainJson();
		global $db,$userid;
		
		
		$institucion   = $_GET['institucion'];
		$Programa      = $_GET['Programa'];
		$Year          = $_GET['Year'];
		$id_Estudiante = $_GET['id_Estudiante'];
		
		$SQL_Inscripcion = 'SELECT 

							MAX(idinscripcion) as id
							
							
							FROM inscripcion
							
							
							WHERE
							
							idestudiantegeneral="'.$id_Estudiante.'"
							AND
							codigoestado=100';
							
							if($Inscrip=&$db->Execute($SQL_Inscripcion)===false){
									$a_vectt['val']			='FALSE';
									$a_vectt['descrip']		='Error en el Consulta de la tabla ....'.$SQL_Inscripcion;
									echo json_encode($a_vectt);
									exit;
								}
		
		
		$SQL_Insert = 'INSERT INTO estudianteuniversidad (idestudiantegeneral,idinscripcion,institucioneducativaestudianteuniversidad,programaacademicoestudianteuniversidad,anoestudianteuniversidad,codigoestado)VALUES("'.$id_Estudiante.'","'.$Inscrip->fields['id'].'","'.$institucion.'","'.$Programa.'","'.$Year.'","100")';
		
				if($Insert_OtraUniversiadad=&$db->Execute($SQL_Insert)===false){
						$a_vectt['val']			='FALSE';
						$a_vectt['descrip']		='Error en el Insert de la tabla ....'.$SQL_Insert;
						echo json_encode($a_vectt);
						exit;
					}
					
			$a_vectt['val']			='TRUE';
			#$a_vectt['descrip']		='Error en el Insert de la tabla ....'.$SQL_Insert;
			echo json_encode($a_vectt);
			exit;		
											 
		
		}break;
	case 'AutoCompletColegio':{
		MainJson();
		global $db,$userid;
		
		$Letra   = $_REQUEST['term'];
		$Dato    = $_REQUEST['Dato'];
		
		if($Dato==0){
		
		 $SQL_Colegios='SELECT 

									idinstitucioneducativa,
									nombreinstitucioneducativa,
									paisinstitucioneducativa,
									departamentoinstitucioneducativa,
									municipioinstitucioneducativa
						
						FROM 
						
									institucioneducativa
						
						WHERE
						
									nombreinstitucioneducativa LIKE "%'.$Letra.'%"
									AND 
									idinstitucioneducativa<>1
									AND
									codigomodalidadacademica=100';
									
					if($Colegios=&$db->Execute($SQL_Colegios)===false){
							echo 'Error en el SQL de lOS Colegios....<br>'.$SQL_Colegios;
							die;
						}				
									
				$Result_C = array();					
				
				while(!$Colegios->EOF){
					#################################################
					
						$Rf_Vectt['label']=$Colegios->fields['nombreinstitucioneducativa'].'  ::  '.$Colegios->fields['municipioinstitucioneducativa'];
						$Rf_Vectt['value']=$Colegios->fields['nombreinstitucioneducativa'];
						
						$Rf_Vectt['id_Colegio']=$Colegios->fields['idinstitucioneducativa'];
						$Rf_Vectt['NameCiudad']=$Colegios->fields['municipioinstitucioneducativa'];
						
						array_push($Result_C,$Rf_Vectt);
					
					#################################################
					$Colegios->MoveNext();
					}
					
				echo json_encode($Result_C);	
		  }
		}break;
	case 'AutoCompletarCiudad':{
		MainJson();
		global $db,$userid;
		
		$Letra   = $_REQUEST['term'];
		
		$SQL_Ciuda='SELECT 

							idciudad,
							nombreciudad
					
					FROM 
					
							ciudad
					
					WHERE
					
							codigoestado=100
							AND
							nombreciudad LIKE "'.$Letra.'%"';
							
					if($Ciudad=&$db->Execute($SQL_Ciuda)===false){
							echo 'Error en el SQL Ciudad....<br>'.$SQL_Ciuda;
							die;
						}	
				
				$Result_F = array();
						
				while(!$Ciudad->EOF){
						$Rf_Vectt['label']=$Ciudad->fields['nombreciudad']; 
						$Rf_Vectt['value']=$Ciudad->fields['nombreciudad'];
						
						$Rf_Vectt['id_Ciudad']=$Ciudad->fields['idciudad'];
						
						array_push($Result_F,$Rf_Vectt);
					$Ciudad->MoveNext();	
					}	
					
			echo json_encode($Result_F);				
		
		}break;
	case 'AddFechas':{
		define(AJAX,'TRUE');
		#define(BIENVENIDA,'False');
		MainGeneral();
		#JsGenral();
		
		global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		
		$j = $_GET['Indice'];
		
		$C_Hoja_Vida->FechasIncapacidad($j);
		}break;
	case 'Siquiente':{
		 define(AJAX,'TRUE');
		 MainGeneral();
		 JsGenral();
		 
		 global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		 
		 $C_Hoja_Vida->SegundaPagina();
		}break;
	case 'AddColumnas':{
		    define(AJAX,'TRUE');
			#define(BIENVENIDA,'False');
			MainGeneral();
			#JsGenral();
			
			global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
				
			$C_Hoja_Vida->Add_Box($_GET['Indice']);
		}break;
	default:{
		
			define(AJAX,'FALSE');
			
			MainGeneral();
			
			
			global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
			
			#Rol 1-->Estudiantes
			$year = date('Y');
			$monunt = date('m');
			
			if($monunt<6){
					$Periodo_num = '1';
				}else{
						$Periodo_num = '2';
					}
					
			$CodigoPeriodo = $year.''.$Periodo_num;		
			############################################################
			
			   $SQL_ValidaExtra='SELECT   

										idactualizacionusuario,
										estadoactualizacion
								
								FROM 
								
										actualizacionusuario
								
								WHERE
								
										usuarioid="'.$userid.'"
										AND
										codigoperiodo="'.$CodigoPeriodo.'"
										AND
										tipoactualizacion=1
										AND
										codigoestado=200'; 
								
								if($ValidacionExistencia=&$db->Execute($SQL_ValidaExtra)===false){
										echo 'Error en el SQl del ususario estudiante Actualizacion....<br>'.$SQL_ValidaExtra;
										die;
									}
			
			if(!$ValidacionExistencia->EOF){
				
					
					define(BIENVENIDA,'TRUE');
					JsGenral();
					
					 $SQL_Estudiante='SELECT 

								numerodocumento,
								codigorol,
								tipodocumento
								
								FROM 
								
								usuario
								
								WHERE
								
								idusuario="'.$userid.'"
								AND
								codigoestadousuario=100
								AND
								codigorol=1';
								
								
							if($EstudiantTipoUser=&$db->Execute($SQL_Estudiante)===false){
									echo 'Error en el SQl del ususario estudiante....<br>'.$SQL_Estudiante;
									die;
								}
								
				if(!$EstudiantTipoUser->EOF){
					
						
						$C_Hoja_Vida->Principal($Estudiante_id,1);	
						exit;	
					}				
									
				
				}
			
			############################################################
            
           // echo '<pre>';print_r($_SESSION);
			
			   echo $SQL_Validacion='SELECT 

										idactualizacionusuario,
										estadoactualizacion
								
								FROM 
								
										actualizacionusuario
								
								WHERE
								
										usuarioid="'.$userid.'"
										AND
										codigoperiodo="'.$CodigoPeriodo.'"
										AND
										tipoactualizacion=1
										AND
										codigoestado=100'; 
								
								if($ValidacionActualizacion=&$db->Execute($SQL_Validacion)===false){
										echo 'Error en el SQl del ususario estudiante Actualizacion....<br>'.$SQL_Validacion;
										die;
									}		
									
										
			if($ValidacionActualizacion->EOF){							
			define(BIENVENIDA,'FALSE');
			JsGenral();
			############################################################  
			    $SQL_Estudiante='SELECT 

								numerodocumento,
								codigorol,
								tipodocumento
								
								FROM 
								
								usuario
								
								WHERE
								
								idusuario="'.$userid.'"
								AND
								codigoestadousuario=100
								AND
								codigorol=1';
								
								
							if($EstudiantTipoUser=&$db->Execute($SQL_Estudiante)===false){
									echo 'Error en el SQl del ususario estudiante....<br>'.$SQL_Estudiante;
									die;
								}	
							
				
				if(!$EstudiantTipoUser->EOF){
					
						
						$C_Hoja_Vida->Principal($Estudiante_id,0);	
                        
                        	
					}else{  
							echo '<blink><strong style="color:#F00; font-size:18px">Su Usuario del Sistema No es de Estudiante...</strong></blink>';
							exit();
						}
				
			}else{
				
				
				/* echo "<script type='text/javascript'> 
				 		window.parent.continuar();
						
						</script>";*/	#window.location.href='../../../consulta/prematricula/matriculaautomaticaordenmatricula.php
						?>
                    <script type='text/javascript'>
						/*window.location.href=' ../../../consulta/autoevaluacion/encuesta.php?idusuario=<?PHP echo $Estudiante_id?>';*/
						window.parent.continuar();
                    	/*window.location.href ='../../../consulta/encuesta/encuestaestudiantesnuevos/validaingresoestudiante.php?idencuesta=50&idusuario=<?PHP echo $Estudiante_id?>&codigotipousuario=600';*/
                    </script>
                    <?PHP	
				
				}
		}break;
	}
function MainGeneral(){
	
		
		global $C_Hoja_Vida,$userid,$db,$rol_Usuario,$Estudiante_id;
		$proyectoMonitoreo = "Monitoreo";
	    include("../../templates/template.php");
		#
		include('Hoja_Vida.class.php');  $C_Hoja_Vida = new Hoja_Vida();
		
		if(AJAX=='ADMIN'){
			
		$db=writeHeader("Hoja de Vida",true);	
			
		$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
		
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
						echo 'Error en el SQL Userid...<br>';
						die;
					}
					
		//$Estudiante_id = $_SESSION['sesion_idestudiantegeneral'];
		$userid=$Usario_id->fields['id'];	
		$rol_Usuario = $_SESSION['rol'];
		
		}elseif(AJAX=='FALSE'){
		
		$db=writeHeader("Hoja de Vida",true);
		
		 $SQL_Num='SELECT 

							numerodocumento
							
							FROM 
							
							estudiantegeneral
							
							WHERE
							
							idestudiantegeneral="'.$_SESSION['sesion_idestudiantegeneral'].'"';	
							
					if($Nummero=&$db->Execute($SQL_Num)===false){
							echo 'Erroe en El SQl Numero De Documento';
							die;
						}				   
							   
							   
							    $SQL_User='SELECT 

											idusuario as id
											
											FROM 
											
											usuario
											
											WHERE
											
											numerodocumento="'.$Nummero->fields['numerodocumento'].'"
                                            AND
            								codigoestadousuario=100
            								AND
            								codigorol=1';
											
			
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
						echo 'Error en el SQL Userid...<br>';
						die;
					}
					
		$Estudiante_id = $_SESSION['sesion_idestudiantegeneral'];
        
        if($_SESSION['idusuariofinalentradaentrada']){
            	$userid=$_SESSION['idusuariofinalentradaentrada'];
        }else{
            $userid = $Usario_id->fields['id'];
        }
        
		
		$rol_Usuario = $_SESSION['rol'];
		
		
		}else if(AJAX=='TRUE'){
			$db=writeHeaderBD();
			
			 $SQL_Num='SELECT 

							numerodocumento
							
							FROM 
							
							estudiantegeneral
							
							WHERE
							
							idestudiantegeneral="'.$_SESSION['sesion_idestudiantegeneral'].'"';	
							
					if($Nummero=&$db->Execute($SQL_Num)===false){
							echo 'Erroe en El SQl Numero De Documento';
							die;
						}				   
							   
							   
							    $SQL_User='SELECT 

											idusuario as id
											
											FROM 
											
											usuario
											
											WHERE
											
											numerodocumento="'.$Nummero->fields['numerodocumento'].'"
                                            AND
            								codigoestadousuario=100
            								AND
            								codigorol=1';
											
			
		
		if($Usario_id=&$db->Execute($SQL_User)===false){
						echo 'Error en el SQL Userid...<br>';
						die;
					}
					
		$Estudiante_id = $_SESSION['sesion_idestudiantegeneral'];
		
        if($_SESSION['idusuariofinalentradaentrada']){
            	$userid=$_SESSION['idusuariofinalentradaentrada'];
        }else{
            $userid = $Usario_id->fields['id'];
        }
        
		$rol_Usuario = $_SESSION['rol'];
			
			}
		
		
	}	
function MainJson(){
	
	    global $userid,$db,$Estudiante_id;
	    include("../../templates/template.php");
		$db=writeHeaderBD();
	    include_once("./functionsVoluntariado.php");
	    include_once("./functionsSalud.php");
		
		#echo '<pre>';print_r($_SESSION);		

		if($_SESSION['MM_Username']==='estudiante'){
				
						        $SQL_Num='SELECT 

							numerodocumento
							
							FROM 
							
							estudiantegeneral
							
							WHERE
							
							idestudiantegeneral="'.$_SESSION['sesion_idestudiantegeneral'].'"';	
							
					if($Nummero=&$db->Execute($SQL_Num)===false){
							echo 'Erroe en El SQl Numero De Documento';
							die;
						}				   
							   
							   
							    $SQL_User='SELECT 

											idusuario as id
											
											FROM 
											
											usuario
											
											WHERE
											
											numerodocumento="'.$Nummero->fields['numerodocumento'].'"
                                            AND
            								codigoestadousuario=100
            								AND
            								codigorol=1';
											
			
		
											
											
			}else{
					$SQL_User='SELECT idusuario as id FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';
			}
		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>';
				die;
			}

				
		 if($_SESSION['idusuariofinalentradaentrada']){
            	$userid=$_SESSION['idusuariofinalentradaentrada'];
        }else{
            $userid = $Usario_id->fields['id'];
        }
		 $Estudiante_id = $_SESSION['sesion_idestudiantegeneral'];
		 
	}
function JsGenral(){
	?>
   
    <style>
   .submit {
	   padding: 9px 17px;
	   font-family: Helvetica, Arial, sans-serif;
	   font-weight: bold;
	   line-height: 1;
	   color: #444;
	   border: none;
	   text-shadow: 0 1px 1px rgba(255, 255, 255, 0.85);
	   background-image: -webkit-gradient( linear, 0% 0%, 0% 100%, from(#fff), to(#bbb));
	   background-image: -moz-linear-gradient(0% 100% 90deg, #BBBBBB, #FFFFFF);
	   background-color: #fff;
	   border: 1px solid #f1f1f1;
	   border-radius: 10px;
	   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
	   cursor:pointer;
	}
	
	.CajasHoja{
		border:#88AB0C solid 1px;
		}
    </style>
     <link rel="stylesheet" href="../../css/style.css" type="text/css" />
    <!--><script type="text/javascript" src="../../js/ajax.js">/*TODAS LAS FUCNIONES DE AJAX*/</script><----> 
    <script type="text/javascript" src="Hoja_Vida.js">/*TODAS LAS FUCNIONES DE AJAX*/</script>
    <script type="text/javascript" src="Hoja_Vida_aux.js">/*TODAS LAS FUCNIONES DE AJAX*/</script> 
    <script type="text/javascript">
	
	
	
	
		calculateWidthMenu();
		//Para que arregle el menu al cambiar el tamaño de la página
		$(window).resize(function() {
			 calculateWidthMenu();
			 CalculatrTab();
		});
	
	
		
	function CalculatrTab(){
			 var maxWidth = $("#tabs-1").width();
			 var contenedor = $('#fielTab_1');
				contenedor.width(maxWidth);
		}	
		 
	</script>
   <script>
	$(document).ready(function() {
		$("#FechaVinculacion").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaVinculacionCaminantes").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#Fecha_Accidente").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaVinculacionSemillero").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaFinSemillero").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaInicoCurso").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaFinCurso").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaInicoOtroCurso").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaFinOtroCurso").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaNaci").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaInicoRed").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaInicoVirtual").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaFinred").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#FechaFinVirtual").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#Fechainicio_invg").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#Fechafin_invg").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		/*$("#Fechaini_Evento").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		$("#Fechafin_Evento").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});*/
		$(".Fecha").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		/****************************/
		$("#F_iniVoluntario").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
        $("#FechaDocu").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
		/**************************/
		$("#F_finVoluntario").datepicker({ 
			changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"
		});
               colocarCalendariosIncapacidades(); 
    });
	</script>
  <?PHP
	
  	if(BIENVENIDA=='TRUE'){
  ?>  
    <script>
	$(function() {
		
		$( "#Bienvenida" ).dialog({
			modal: true,
			width: 700,
			buttons: {
			Acepto: function() {
					var selectedEffect = 'explode';
					$( "#Bienvenida" ).effect( selectedEffect);  
					$( this ).dialog( "close" );
				}
			}
		});
	});
	</script>
   <?PHP
	}
   ?> 
     <script>
		
		$(function() {
			$( "#tabs" ).tabs();
		});
	</script>
    <script>
	 $(document).ready(function() {
                   $('#ui-datepicker-div').hide();
               });
 	
				
    </script>
    <?PHP
	}	
?>