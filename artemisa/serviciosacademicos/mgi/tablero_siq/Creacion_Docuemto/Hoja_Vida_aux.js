// JavaScript Document
function BuscarDataBienestar(){
	/**************************************************/
	
	var P_General		= $('#P_General').val();
	var Estudiante_id	= $('#Estudiante_id').val();
        var PermisoUsuario	= $('#PermisoUsuario').val();

	 $.ajax({//Ajax
		  type: 'POST',
		  url: 'Hoja_Vida.html.php',
		  async: false,
		  dataType: 'json',
		  data:({actionID: 'BuscarData',P_General:P_General,PermisoUsuario:PermisoUsuario,
		  								Estudiante_id:Estudiante_id}),
	  	  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
	      success: function(data){
                                if(data.selectMonitoresVoluntariado!=null){
                                    $('#tipoMonitorBienestar').html(data.selectMonitoresVoluntariado);
                                }
				if(data.val=='FALSE'){
						alert(data.descrip);
						return false;
					}else if(data.val=='TRUE'){
						/********************************************/	
							//alert(data.id_bienestar);
							$('#id_Bienestar').val(data.id_bienestar);
							/**********************Carca Info Primera Pregunta**************************/
							if(data.Selecion_U==0){
									$('#Si_Selec').attr('checked',true);
									$('#No_Selec').attr('checked',false);
									$('#Tr_OpcioneSelecion').css('visibility','visible');
									$('#Perido_inicial_Seleccion').val(data.p_ini_Selecion);
									$('#Perido_Final_Seleccion').val(data.p_fin_Selecion);
									var index_SL	= $('#index_SL').val();
									
									for(i=0;i<index_SL;i++){
									/***************************************/
									
									if($('#'+i+'_Selec').is(':checked')==false){
										/************************************/
										if($('#'+i+'_Selec').val()==data.tiposeleccion){
												$('#'+i+'_Selec').attr('checked',true);
											}
										/************************************/
										}//if
									/***************************************/
									}//for
									
								}else if(data.Selecion_U==1){
										$('#Si_Selec').attr('checked',false);
										$('#No_Selec').attr('checked',true);
										$('#Tr_OpcioneSelecion').css('visibility','collapse');
									}
							/*********************Carga Info Segunda Pregunta*****************************/		
							if(data.Apoyo_U==0){
								$('#Si_Apoyo').attr('checked',true);
								$('#No_Apoyo').attr('checked',false);
								$('#Tr_ApoyosUniversidad').css('visibility','visible');
								$('#Perido_ini_Apoyo').val(data.p_ini_apoyo);
								$('#Perido_Fin_Apoyo').val(data.p_fin_apoyo);
								var indexAp		= $('#indexAp').val();
								
								for(i=0;i<indexAp;i++){
									/***************************************/
									if($('#'+i+'_Apoyo').is(':checked')==false){
										/************************************/
										if($('#'+i+'_Apoyo').val()==data.Tipo_Apoyo){
												$('#'+i+'_Apoyo').attr('checked',true);
											}
										/************************************/
										}//if
									/***************************************/
									}//for
								}else if(data.Apoyo_U==1){
										$('#Si_Apoyo').attr('checked',false);
										$('#No_Apoyo').attr('checked',true);
										$('#Tr_ApoyosUniversidad').css('visibility','collapse');
									}
						/**********************Carga info tercera Pregunta*************************/	
						if(data.TalleresDeport==0){
							$('#Si_Talleres').attr('checked',true);
							$('#No_Talleres').attr('checked',false);
							$('#Tr_TallerDeportes').css('visibility','visible');
							var indexTll	= $('#indexTll').val();
							$('#CadenaExite').val(data.C_Talleres);
							for(i=0;i<indexTll;i++){
							/***************************************/
								if($('#'+i+'_Taller').is(':checked')==false){
									/************************************/
									
									var D_Taller	= data.C_Talleres.split('-');
									
									//alert(D_Taller);
									
									var Num			= D_Taller.length;
									
									for(j=1;j<Num;j++){
										
											//alert(D_Taller[j]);
											var Data_T		= 	D_Taller[j].split('::');
											
											if($('#'+i+'_Taller').val()==Data_T[1]){
													$('#'+i+'_Taller').attr('checked',true);
													$('#id_tallerB_'+i).val(Data_T[0]);
													$('#P_ini_'+i).val(Data_T[2]);
													$('#P_fin_'+i).val(Data_T[3]);
												}
										
										}//for
									/************************************/
									
									/************************************/
								}//if
							}//for
							}else if(data.TalleresDeport==1){
									$('#Si_Talleres').attr('checked',false);
									$('#No_Talleres').attr('checked',true);
									$('#Tr_TallerDeportes').css('visibility','collapse');
								}
						/******************Cuarta Pregunta Carga Info***************************/		
						if(data.logroDeport==0){
							$('#Si_LogroDepor').attr('checked',true);
							$('#No_LogroDepor').attr('checked',false);
							$('#Td_TituloCualLogro').css('visibility','visible');
							$('#Cual_logroDeprot').val(data.logrodeportcual);
							$('#P_ini_LogroDeport').val(data.p_logrodeport);
							}else if(data.logroDeport==1){
								$('#Si_LogroDepor').attr('checked',false);
								$('#No_LogroDepor').attr('checked',true);
								$('#Td_TituloCualLogro').css('visibility','collapse');
								$('#Cual_logroDeprot').val('');
								$('#P_ini_LogroDeport').val('-1');
								}
						/****************cargar info 5 pregunta**********************************/		
						if(data.BecasEstimuBiene==0){
							$('#Si_BecasEstimulos').attr('checked',true);	
							$('#No_BecasEstimulos').attr('checked',false);	
							$('#Tr_BecasEstimulos').css('visibility','visible');
							$('#Cua_BecasEstimulos').val(data.becasCual);
							$('#P_ini_BecasDeport').val(data.p_Becadeport);
							}else if(data.BecasEstimuBiene==1){
								$('#Si_BecasEstimulos').attr('checked',false);	
								$('#No_BecasEstimulos').attr('checked',true);	
								$('#Tr_BecasEstimulos').css('visibility','collapse');
								$('#Cua_BecasEstimulos').val('');
								$('#P_ini_BecasDeport').val('-1');
								}
						/****************Carga Info 6 Pregunta***************************************/		
						if(data.asistegym==0){
							$('#Si_Gym').attr('checked',true);
							$('#No_Gym').attr('checked',false);	
							$('#Tr_CuantasVeces').css('visibility','visible');
									/*************************************************/
										if(data.frecuenciagym==0){
												$('#Gym_Menos').attr('checked',true);	
											}
									/*************************************************/
										if(data.frecuenciagym==1){
												$('#Gym_Uno').attr('checked',true);
											}
									/*************************************************/
										if(data.frecuenciagym==2){
												$('#Gym_dos').attr('checked',true);
											}
									/*************************************************/
										if(data.frecuenciagym==3){
												$('#Gym_tres').attr('checked',true);
											}
									/*************************************************/
										if(data.frecuenciagym==4){
												$('#Gym_Mas').attr('checked',true);
											}
									/*************************************************/
							}else if(data.asistegym==1){
								$('#Si_Gym').attr('checked',false);
								$('#No_Gym').attr('checked',true);	
								$('#Tr_CuantasVeces').css('visibility','collapse');
								}
						/********************cargar info 7 Pregunta*******************************/	
						if(data.clubrunning==0){
							$('#Si_ClubRunning').attr('checked',true);
							$('#No_ClubRunning').attr('checked',false);
							$('#Td_CajaFechaVinculacion').css('visibility','visible');
							$('#FechaVinculacion').val(data.P_ClubRunning);
							}else if(data.clubrunning==1){
								$('#Si_ClubRunning').attr('checked',false);
								$('#No_ClubRunning').attr('checked',true);
								$('#Td_CajaFechaVinculacion').css('visibility','collapse');
								$('#FechaVinculacion').val('-1');
								}
						/*********************Car ga Info 8 Pregunta********************************/			
						if(data.clubcaminantes==0){
							$('#Si_ClubCaminantes').attr('checked',true);
							$('#No_ClubCaminantes').attr('checked',false);
							$('#Td_CajaFechaVinculacionCaminantes').css('visibility','visible');
							$('#FechaVinculacionCaminantes').val(data.P_Caminates);
							}else if(data.clubcaminantes==1){
								$('#Si_ClubCaminantes').attr('checked',false);
								$('#No_ClubCaminantes').attr('checked',true);
								$('#Td_CajaFechaVinculacionCaminantes').css('visibility','collapse');
								$('#FechaVinculacionCaminantes').val('-1');
								}
                                                   if(data.clubcaminantes==null || data.clubrunning==null ||
                                                                        data.asistegym==null){
                                                                             $(".deportesForm input[type='radio']").removeAttr("checked");
                                                                                $(".deportesForm input[type='text']").val("");
                                                                                $(".deportesForm select").val("-1");
                                                                                $(".deportesForm input[type='checkbox']").removeAttr("checked");
                                                                                $('.deportesForm .toggleOptions').css('visibility','collapse');                                                                                
                                                                        }
                                                                        
						/********************************************/	
						/****************************Info Salud**************************************/
                                                if(data.Num_Ase_PsicoSalud!=null){
                                                    $(".saludbienestar input#Num_Ase_Psico").val(data.Num_Ase_PsicoSalud);
                                                } else {
                                                    $(".saludbienestar input#Num_Ase_Psico").val("0");
                                                }
                                                $(".saludbienestar table.requiredInputs").html(data.actividadesPromocionSalud);
                                                
                                                //limpio incapacidades
                                                var num = parseInt($("#numIndicesFeha").val());
                                                         for(i=1;i<=num;i++){
                                                             $('.saludbienestar table#Table_Fechas tr:last').remove();           
                                                         }     
                                                         $('.saludbienestar table#Table_Fechas input[type="hidden"]').val(""); 
                                                         $(".saludbienestar input[type='radio']").removeAttr("checked");
                                                         $(".saludbienestar table#Table_Fechas input[type='text']").val("");
                                                         $("#numIndicesFeha").val("0");
                                                if(data.incapacidadesSalud!=null&& data.incapacidadesSalud.length > 0){
                                                    //borro la cero
                                                    $('.saludbienestar table#Table_Fechas tr:last').remove();     
                                                    $(".saludbienestar table#Table_Fechas").append(data.incapacidadesSalud);
                                                    $("#numIndicesFeha").val(data.totalIncapacidadesSalud);
                                                    colocarCalendariosIncapacidades();
                                                }                                                
						/****************************Info Cultura************************************/
						if(data.grupoculturales==0){
							$('#Si_GrupoCultura').attr('checked',true);
							$('#No_GrupoCultura').attr('checked',false);
							$('#Tr_TiposGruposCulturales').css('visibility','visible');
							
							$('#P_ini_Grupo').val(data.P_ini_Grup);
							$('#P_fin_Grupo').val(data.P_fin_Grup);
							
							var IndexGrupCul		= $('#IndexGrupCul').val();
								
								for(i=0;i<IndexGrupCul;i++){
									/***************************************/
									if($('#'+i+'_Grup').is(':checked')==false){
										/************************************/
										if($('#'+i+'_Grup').val()==data.TypeGrupCult){
												$('#'+i+'_Grup').attr('checked',true);
											}
										/************************************/
										}//if
									/***************************************/
									}//for
							}else if(data.grupoculturales==1){
								$('#Si_GrupoCultura').attr('checked',false);
								$('#No_GrupoCultura').attr('checked',true);
								$('#Tr_TiposGruposCulturales').css('visibility','collapse');
								$('#P_ini_Grupo').val('-1');
								$('#P_fin_Grupo').val('-1');
								}
						/**************************Segunda Pregunta***********************/
						if(data.TallerCultura==0){
							$('#Si_TalleresCultura').attr('checked',true);
							$('#No_TalleresCultura').attr('checked',false);
							$('#Tr_TalleresCulturales').css('visibility','visible');
							
							var IndexTllCultura	= $('#IndexTllCultura').val();
							
							for(i=0;i<IndexTllCultura;i++){
							/***************************************/
								if($('#'+i+'_TllCult').is(':checked')==false){
									/************************************/
									
									var D_Taller	= data.C_TallerCultura.split('-');
									
									//alert(D_Taller);
									
									var Num			= D_Taller.length;
									
									for(j=1;j<Num;j++){
										
											//alert(D_Taller[j]);
											var Data_T		= 	D_Taller[j].split('::');
											
											if($('#'+i+'_TllCult').val()==Data_T[1]){
													$('#'+i+'_TllCult').attr('checked',true);
													$('#id_BineTll_'+i).val(Data_T[0]);
													$('#P_ini'+i).val(Data_T[2]);
													$('#P_fin'+i).val(Data_T[3]);
												}
										
										}//for
									/************************************/
								}//if
							}//for
							}else if(data.TallerCultura==1){
									$('#Si_TalleresCultura').attr('checked',false);
									$('#No_TalleresCultura').attr('checked',true);
									$('#Tr_TalleresCulturales').css('visibility','collapse');
								}	
						/***********************Pregunta 3*************************************/		
						if(data.LogrosCulturales==0){
							$('#LogroCultural_Si').attr('checked',true);
							$('#LogroCultural_No').attr('checked',false);
							$('#LogrosCulturales_Td').css('visibility','visible');
							$('#CualLogrosCulturales').val(data.CualLogroCult);
							$('#P_ini_LogorCultura').val(data.P_logroCult);
							}else if(data.LogrosCulturales==1){
								$('#LogroCultural_Si').attr('checked',false);
								$('#LogroCultural_No').attr('checked',true);
								$('#LogrosCulturales_Td').css('visibility','collapse');
								}	
						/*********************Pregunta 4*********************************************/	
						if(data.BecasCulturales==0){
							$('#BecaCultural_Si').attr('checked',true);
							$('#BecaCultural_No').attr('checked',false);
							$('#BecasCultural_TD').css('visibility','visible');
							$('#CualBecasCulturales').val(data.CualbecaCultural);
							$('#P_ini_BecaCultura').val(data.P_Becacultural);
							}else if(data.BecasCulturales==1){
								$('#BecaCultural_Si').attr('checked',false);
								$('#BecaCultural_No').attr('checked',true);
								$('#BecasCultural_TD').css('visibility','collapse');
								}
                                                                
                                                if(data.BecasCulturales==null || data.LogrosCulturales==null ||
                                                                        data.TallerCultura==null){
                                                                             $(".culturalForm input[type='radio']").removeAttr("checked");
                                                                                $(".culturalForm input[type='text']").val("");
                                                                                $(".culturalForm select").val("-1");
                                                                                $(".culturalForm input[type='checkbox']").removeAttr("checked");  
                                                                                $('.culturalForm .toggleOptions').css('visibility','collapse');
                                                                        }
						/************************************************************************************/
                                                /********* Voluntariado ************/
                                                //console.log(data);
                                                
                                                if(data.V_voluntariado==0){
								$('#Si_Volunta').attr('checked',true);
								$('#No_Volunta').attr('checked',false);
								$('.Tr_FechasVoluntario').css('visibility','visible');
								$('#F_iniVoluntario').val(data.V_inicialVoluntariado);
								$('#F_finVoluntario').val(data.V_finalVoluntariado);
                                                }else if(data.V_voluntariado==1){
										$('#Si_Volunta').attr('checked',false);
										$('#No_Volunta').attr('checked',true);
										$('.Tr_FechasVoluntario').css('visibility','collapse');
									}
                                                if(data.V_grupoapoyo==0){
								$('#Si_GrupoApoyoBienestar').attr('checked',true);
								$('#No_GrupoApoyo').attr('checked',false);
								$('#Tr_FechasGrupoApoyoBienestar').css('visibility','visible');
								$('#periodoInicialApoyoBienestar').val(data.V_periodoInicialApoyo);
								$('#periodoFinalApoyoBienestar').val(data.V_periodoFinalApoyo);
                                                }else if(data.V_grupoapoyo==1){
										$('#Si_GrupoApoyoBienestar').attr('checked',false);
										$('#No_GrupoApoyo').attr('checked',true);
										$('#Tr_FechasGrupoApoyoBienestar').css('visibility','collapse');
									}
                                                if(data.V_monitor==0){
								$('#Si_MonitoBienestar').attr('checked',true);
								$('#No_MonitoBienestar').attr('checked',false);
								$('#Tr_OpcionesMonitorBienestar').css('visibility','visible');
								$('#periodoInicialMonitor').val(data.V_periodoInicialMonitor);
								$('#periodoFinalMonitor').val(data.V_periodoFinalMonitor);
                                                                $('#tipoMonitorBienestar').val(data.V_tipoMonitor);
								}else if(data.V_monitor==1){
										$('#Si_MonitoBienestar').attr('checked',false);
										$('#No_MonitoBienestar').attr('checked',true);
										$('#Tr_OpcionesMonitorBienestar').css('visibility','collapse');
									}
                                                                        
                                                                        if(data.V_voluntariado==null || data.V_monitor==null ||
                                                                        data.V_grupoapoyo==null){
                                                                             $(".voluntariadoForm input[type='radio']").removeAttr("checked");
                                                                                $(".voluntariadoForm input[type='text']").val("");
                                                                                $(".voluntariadoForm select").val("-1");
                                                                                $('.voluntariadoForm .toggleOptions').css('visibility','collapse');
                                                                        }
                                                
                                                
						}else if(data.val=='Vacio'){
							/*******************Limpiar Formulario***************************/
								$('#Si_Selec').attr('checked',false);
								$('#No_Selec').attr('checked',false);
								$('#Tr_OpcioneSelecion').css('visibility','collapse');
								$('#Perido_inicial_Seleccion').val('-1');
								$('#Perido_Final_Seleccion').val('-1');
								var index_SL	= $('#index_SL').val();
								
								for(i=0;i<index_SL;i++){
								/***************************************/
								
								if($('#'+i+'_Selec').is(':checked')==false){
									/************************************/
									$('#'+i+'_Selec').attr('checked',false);
									/************************************/
									}else{
										$('#'+i+'_Selec').attr('checked',false);
										}//if
								/***************************************/
								}//for
								/*****************Segunda Pregunta***************************/
								$('#Si_Apoyo').attr('checked',false);
								$('#No_Apoyo').attr('checked',false);
								$('#Tr_ApoyosUniversidad').css('visibility','collapse');
								$('#Perido_ini_Apoyo').val('-1');
								$('#Perido_Fin_Apoyo').val('-1');
								var indexAp		= $('#indexAp').val();
								
								for(i=0;i<indexAp;i++){
									/***************************************/
									if($('#'+i+'_Apoyo').is(':checked')==false){
										/************************************/
										$('#'+i+'_Apoyo').attr('checked',false);
										/************************************/
										}else{
											$('#'+i+'_Apoyo').attr('checked',false);
											}//if
									/***************************************/
									}//for
								/******************Tercera Pregunta*************************/	
								$('#Si_Talleres').attr('checked',false);
								$('#No_Talleres').attr('checked',false);
								$('#Tr_TallerDeportes').css('visibility','collapse');
								var indexTll	= $('#indexTll').val();
								
								for(i=0;i<indexTll;i++){
								/***************************************/
									if($('#'+i+'_Taller').is(':checked')==false){
										/************************************/
										$('#'+i+'_Taller').attr('checked',false);
										$('#id_tallerB_'+i).val('');
										$('#P_ini_'+i).val('-1');
										$('#P_fin_'+i).val('-1');
										/************************************/
									}else{
										$('#'+i+'_Taller').attr('checked',false);
										$('#id_tallerB_'+i).val('');
										$('#P_ini_'+i).val('-1');
										$('#P_fin_'+i).val('-1');
										}//if
								}//for
								/******************Cuarta Pregunta***************************/
								$('#Si_LogroDepor').attr('checked',false);
								$('#No_LogroDepor').attr('checked',false);
								$('#Td_TituloCualLogro').css('visibility','collapse');
								$('#Cual_logroDeprot').val('');
								$('#P_ini_LogroDeport').val('-1');
								/*****************Quinta Pregunta****************************/
								$('#Si_BecasEstimulos').attr('checked',false);	
								$('#No_BecasEstimulos').attr('checked',false);	
								$('#Tr_BecasEstimulos').css('visibility','collapse');
								$('#Cua_BecasEstimulos').val('');
								$('#P_ini_BecasDeport').val('-1');
								/****************Sexta Pregunta******************************/
								$('#Si_Gym').attr('checked',false);
								$('#No_Gym').attr('checked',false);	
								$('#Tr_CuantasVeces').css('visibility','collapse');
								$('#Gym_Menos').attr('checked',false);
								$('#Gym_Uno').attr('checked',false);
								$('#Gym_dos').attr('checked',false);
								$('#Gym_tres').attr('checked',false);
								$('#Gym_Mas').attr('checked',false);
								/****************Septima Pregunta****************************/
								$('#Si_ClubRunning').attr('checked',false);
								$('#No_ClubRunning').attr('checked',false);
								$('#Td_CajaFechaVinculacion').css('visibility','collapse');
								$('#FechaVinculacion').val('-1');
								/****************Octava Pregunta*****************************/		
								$('#Si_ClubCaminantes').attr('checked',false);
								$('#No_ClubCaminantes').attr('checked',false);
								$('#Td_CajaFechaVinculacionCaminantes').css('visibility','collapse');
								$('#FechaVinculacionCaminantes').val('-1');
								/****************Formulari Cultura***************************/
								$('#Si_GrupoCultura').attr('checked',false);
								$('#No_GrupoCultura').attr('checked',false);
								$('#Tr_TiposGruposCulturales').css('visibility','collapse');
								$('#P_ini_Grupo').val('-1');
								$('#P_fin_Grupo').val('-1');
								
								var IndexGrupCul		= $('#IndexGrupCul').val();
									
									for(i=0;i<IndexGrupCul;i++){
										/***************************************/
										if($('#'+i+'_Grup').is(':checked')==false){
											/************************************/
											$('#'+i+'_Grup').attr('checked',false);
											/************************************/
											}else{
												$('#'+i+'_Grup').attr('checked',false);
												}//if
										/***************************************/
										}//for
								/****************Segunda Pregunta****************************/		
								$('#Si_TalleresCultura').attr('checked',false);
								$('#No_TalleresCultura').attr('checked',false);
								$('#Tr_TalleresCulturales').css('visibility','collapse');
								
								var IndexTllCultura	= $('#IndexTllCultura').val();
								
								for(i=0;i<IndexTllCultura;i++){
								/***************************************/
									if($('#'+i+'_TllCult').is(':checked')==false){
										/************************************/
											$('#'+i+'_TllCult').attr('checked',false);
											$('#id_BineTll_'+i).val('');
											$('#P_ini'+i).val('-1');
											$('#P_fin'+i).val('-1');
										}else{
											$('#'+i+'_TllCult').attr('checked',false);
											$('#id_BineTll_'+i).val('');
											$('#P_ini'+i).val('-1');
											$('#P_fin'+i).val('-1');
											}
								}//for
								/*****************Tercera Pregunta***************************/
								$('#LogroCultural_Si').attr('checked',false);
								$('#LogroCultural_No').attr('checked',false);
								$('#LogrosCulturales_Td').css('visibility','collapse');
								$('#CualLogrosCulturales').val('');
								$('#P_ini_LogorCultura').val('-1');
								/*****************Cuarta Pregunta****************************/
								$('#BecaCultural_Si').attr('checked',false);
								$('#BecaCultural_No').attr('checked',false);
								$('#BecasCultural_TD').css('visibility','collapse');
								$('#CualBecasCulturales').val('');
								$('#P_ini_BecaCultura').val('-1');   
							/*****************************VOLUNTARIADO***********************************/
                                                            $(".voluntariadoForm input[type='radio']").removeAttr("checked");
                                                            $(".voluntariadoForm input[type='text']").val("");
                                                            $(".voluntariadoForm select").val("-1");
                                                            $('.voluntariadoForm .toggleOptions').css('visibility','collapse');
                                                         /*****************************SALUD***********************************/
                                                         $(".saludbienestar input[type='radio']").removeAttr("checked");
                                                         $(".saludbienestar input#Num_Ase_Psico").val("0");
                                                         $(".saludbienestar table.requiredInputs input[type='text']").val("0");
                                                         $(".saludbienestar table#Table_Fechas input[type='text']").val("");
                                                         $(".saludbienestar #CadenaIncapacidad").val("");
                                                         $('.saludbienestar table#Table_Fechas input[type="hidden"]').val(""); 
                                                         var num = parseInt($("#numIndicesFeha").val());
                                                         for(i=1;i<=num;i++){
                                                             $('.saludbienestar table#Table_Fechas tr:last').remove();           
                                                         }     
                                                         $("#numIndicesFeha").val("0");
							}
				   } 
	  }); //AJAX
	/**************************************************/
	}
function Cancelar(i,hidden){
	/************************************************************/
		var id_Existe		= $('#'+hidden+i).val();
		var P_General		= $('#P_General').val();
		var id_Bienestar	= $('#id_Bienestar').val();
		
		if($.trim(id_Existe)){
			/******************Lleno***************************/
			$.ajax({//Ajax
				  type: 'POST',
				  url: 'Hoja_Vida.html.php',
				  async: false,
				  dataType: 'json',
				  data:({actionID: 'CancelarTaller',id_Existe:id_Existe,
												    P_General:P_General,
													id_Bienestar:id_Bienestar}),
				  error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				  success: function(data){
						if(data.val=='FALSE'){
							alert(data.descrip);
							return false;
							}else{
								$('#'+hidden+i).val('');
								} 
				     }//Data
	 			 }); //AJAX
			/**************************************************/
			}
	/************************************************************/
	}	