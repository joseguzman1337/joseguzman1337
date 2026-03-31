// JavaScript Document
function Prueba(id){
    /*********************************/

    if(id!=1 || id!='1'){
        if($('#EstadoGeneral').val()==0 || $('#EstadoGeneral').val()=='0'){
            ValidaGeneral();
            var Estudiante_id = $('#Estudiante_id').val();
            /*****************************/		
			Save_Tab1(Estudiante_id,1);  
			/*****************************/
            $('#EstadoGeneral').val('1');
        }//if
    }
    if(id!=2 || id!='2'){
        if($('#EstadoAcademico').val()==0 || $('#EstadoAcademico').val()=='0'){
            ValidaAcademica();
            var Estudiante_id = $('#Estudiante_id').val();
            /*****************************/		
			Save_Tab1(Estudiante_id,2);
			/*****************************/
            $('#EstadoAcademico').val('1');
        }//if
    }//if//if
    
    if(id!=4 || id!='4'){
        if($('#EstadoPersonal').val()==0 || $('#EstadoPersonal').val()=='0'){
            ValidadPersonal();
            var Estudiante_id = $('#Estudiante_id').val();
            /*****************************/		
			Save_Tab1(Estudiante_id,4);
			/*****************************/
            $('#EstadoPersonal').val('1');
        }//if
    }//if//if
    
    /*********************************/
}//Prueba
function CambiaGeneral(){
    /********************************/
    $('#EstadoGeneral').val('0');
    /********************************/
}//CambiaGeneral
function CambiaAcademico(){
    /********************************/
    $('#EstadoAcademico').val('0');
    /********************************/
}//CambiaAcademico
function CambiaPersonal(){
    /********************************/
    $('#EstadoPersonal').val('0');
    /********************************/
}//CambiaAcademico
function Ver_BecaCultural(){
		if($('#BecaCultural_Si').is(':checked')){
				$('#BecasCultural_TD').css('visibility','visible');
			}else{
					$('#BecasCultural_TD').css('visibility','collapse');
				}
	}
function Ver_LogroCultural(){
		if($('#LogroCultural_Si').is(':checked')){
				$('#LogrosCulturales_Td').css('visibility','visible');
			}else{
					$('#LogrosCulturales_Td').css('visibility','collapse');
				}
	}
function Ver_BecasEstimulos(){
	
		if($('#Si_BecasEstimulos').is(':checked')){
				
				$('#Tr_BecasEstimulos').css('visibility','visible');
				$('.Tr_BecasEstimulosCaja').css('visibility','visible');
			
			}else{
				
				$('#Tr_BecasEstimulos').css('visibility','collapse');
				$('.Tr_BecasEstimulosCaja').css('visibility','collapse');
				
				}
	
	}
	function Ver_AsisInvestigacion(){
			
			if($('#Si_Asistente').is(':checked')){
				
				$('#Tr_AsistenteInvestigacion').css('visibility','visible');
			
			}else{
				
				$('#Tr_AsistenteInvestigacion').css('visibility','collapse');
				
				}
		}	
	function Ver_Rol(){
		
			if($('#Si_Rol').is(':checked')){
				
				$('.Rol').css('visibility','visible');
			
			}else{
				
				$('.Rol').css('visibility','collapse');
				
				}
			
		}	
	function Ver_TiposPublicacios(){
		
			if($('#Revista').is(':checked')){
					$('.Revista').css('visibility','visible');
					$('.otrasPublicion').css('visibility','collapse');
				}else if($('#OtraPublic').is(':checked')){
					$('.otrasPublicion').css('visibility','visible');
					$('.Revista').css('visibility','collapse');
				}else{
						$('.Revista').css('visibility','collapse');
						$('.otrasPublicion').css('visibility','collapse');
					}
		
		}
	function Ver_RolExterno(){
		
			if($('#SiRol_ext').is(':checked')){
				
					$('.Rol_ext').css('visibility','visible');
				
				}else{
					
					$('.Rol_ext').css('visibility','collapse');
					
					}
		
		}
	function Ver_TiposPublicaciosExt(){
		
			if($('#RevistaExt').is(':checked')){
					$('.RevistaExt').css('visibility','visible');
					$('.otrasPublicionExt').css('visibility','collapse');
				}else if($('#OtraPublicExt').is(':checked')){
					$('.otrasPublicionExt').css('visibility','visible');
					$('.RevistaExt').css('visibility','collapse');
				}else{
						$('.RevistaExt').css('visibility','collapse');
						$('.otrasPublicionExt').css('visibility','collapse');
					}
		
		}	
	function FormatCityCongreso(){
			$('#Ciudad_Congreso').val('');
			$('#id_CityCongreso').val('');
		}
	function autocompletCityCongreso(){		
	/********************************************************/	
			$('#Ciudad_Congreso').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#id_CityCongreso').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/	
	}
	function FormatCityCongInter(){
			$('#Ciudad_CongresoInter').val('');
			$('#id_CityCongInter').val('');
		}	
	function autocompletCityCongInter(){		
	/********************************************************/	
			$('#Ciudad_CongresoInter').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#id_CityCongInter').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/	
	}	
	function autocompletPais(){		
	/********************************************************/	
			$('#Pais_Congreso').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletePais",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#id_Pais').val(ui.item.id_Pais);
						
						}
					
				});//LugarNaci
		/********************************************************/	
	}	
	function FormatPais(){
			$('#Pais_Congreso').val('');
			$('#id_Pais').val('');
		}
	function SaveAdmin(Estudiante_id,Ex,Bi,Or,Iv){
			
		
			
		// alert('Estudiante_id->'+Estudiante_id+'\n Ex->'+Ex+'\n Bi->'+Bi+'\n Or->'+Or+'\n Iv->'+Iv);
		
		if(Ex==1 || Ex=='1'){ExitoEstudiantil(Estudiante_id);}
		if(Bi==1 || Bi=='1'){Bienestar(Estudiante_id);}
		if(Or==1 || Or=='1'){OrganosGobierno(Estudiante_id);}
		if(Iv==1 || Iv=='1'){ActividaInvestiga(Estudiante_id);}	
		
		/******************************************Save  del Administrativo *********************************/	
			
			/* $.ajax({//Ajax
				      type: 'GET',
				      url: 'Hoja_Vida.html.php',
				      async: false,
				      dataType: 'json',
				      data:({actionID: 'Save_Admin',pae:pae,
					  								Academicas:Academicas,
													psicosociales:psicosociales,
													economicas:economicas,
													Competencias:Competencias,
													independecia:independecia,
													Metodos:Metodos,
													DistribuTiempo:DistribuTiempo,
													TrabEquipo:TrabEquipo,
													Socializacion:Socializacion,
													PrioriActividades:PrioriActividades,
													InterFamilia:InterFamilia,
													CompLectura:CompLectura,
													conflictos:conflictos,
													Cual_Adaptacion:Cual_Adaptacion,
													OtroEscala:OtroEscala,
													ReacionProblema:ReacionProblema,
													Cual_Problema:Cual_Problema,
													Padre_Por:Padre_Por,
													Padre_Descri:Padre_Descri,
													Madre_Por:Madre_Por,
													Madre_Descri:Madre_Descri,
													Hermano_Por:Hermano_Por,
													Hermano_Descri:Hermano_Descri,
													Hermana_Por:Hermana_Por,
													Hermana_Descri:Hermana_Descri,
													Amigos_Por:Amigos_Por,
													Amigos_Descri:Amigos_Descri,
													Pareja_Por:Pareja_Por,
													Pareja_Descri:Pareja_Descri,
													Selecion_U:Selecion_U,
													Tipo_Selecion:Tipo_Selecion,
													Competencias_U:Competencias_U,
													Tipo_Competencia:Tipo_Competencia,
													Talleres:Talleres,
													Tipo_Taller:Tipo_Taller,
													LogroDeportivo:LogroDeportivo,
													Cual_LogroDeportivo:Cual_LogroDeportivo,
													BecasEstimos:BecasEstimos,
													Cual_BecaEstimulo:Cual_BecaEstimulo,
													Gimnasio:Gimnasio,
													Frecuenca_Gym:Frecuenca_Gym,
													ClubRunning:ClubRunning,
													FechaVinculacion:FechaVinculacion,
													ClubCaminantes:ClubCaminantes,
													FechaVinculacionCaminantes:FechaVinculacionCaminantes,
													Num_Ase_Psico:Num_Ase_Psico,
													Num_MedGeneral:Num_MedGeneral,
													Num_MedDeporte:Num_MedDeporte,
													Num_PromoPlaneacion:Num_PromoPlaneacion,
													CadenaIncapacidad:CadenaIncapacidad,
													Acidente_U:Acidente_U,
													Fecha_Accidente:Fecha_Accidente,
													Uso_Seguro:Uso_Seguro,
													GrupoCultural:GrupoCultural,
													Tipo_GrupoCultural:Tipo_GrupoCultural,
													TalleresCultura:TalleresCultura,
													Tipo_CulturaTaller:Tipo_CulturaTaller,
													Voluntariado:Voluntariado,
													GrupoApoyo:GrupoApoyo,
													MonitoBienestar:MonitoBienestar,
													Representante:Representante,
													ConsejoFacul:ConsejoFacul,
													ConsejoAcad:ConsejoAcad,
													ConsejoDir:ConsejoDir,
													Investiga:Investiga,
													Semillero:Semillero,
													Nom_Semillero:Nom_Semillero,
													FechaVinculacionSemillero:FechaVinculacionSemillero,
													FechaFinSemillero:FechaFinSemillero,
													Dependencia:Dependencia,
													Asistente:Asistente,
													NombreProyecto_invg:NombreProyecto_invg,
													DocenteResp_invg:DocenteResp_invg,
													Fechainicio_invg:Fechainicio_invg,
													Fechafin_invg:Fechafin_invg,
													Publicaciones:Publicaciones,
													Autor_Publicacion:Autor_Publicacion,
													Nom_Publicacion:Nom_Publicacion,
													Coautor_Publicacion:Coautor_Publicacion,
													Editorial_Publicacion:Editorial_Publicacion,
													Rol:Rol,
													Cual_Rol:Cual_Rol,
													TipoPublicacion:TipoPublicacion,
													Indexada:Indexada,
													Otra_publicTipo:Otra_publicTipo,
													PublicacionExt:PublicacionExt,
													Autor_PublicacionExt:Autor_PublicacionExt,
													Nom_PublicacionExt:Nom_PublicacionExt,
													Coautor_PublicacionExt:Coautor_PublicacionExt,
													Entidad_PublicacionExt:Entidad_PublicacionExt,
													Rol_ext:Rol_ext,
													CualRol_PublicacionExt:CualRol_PublicacionExt,
													TipoPublicacion_Ext:TipoPublicacion_Ext,
													Indexsada_Ext:Indexsada_Ext,
													Otra_publicTipoExt:Otra_publicTipoExt,
													AsisEventos:AsisEventos,
													Fechaini_Evento:Fechaini_Evento,
													Fechafin_Evento:Fechafin_Evento,
													Nom_evento:Nom_evento,
													Nom_EntidadOrg:Nom_EntidadOrg,
													PonenteCongreso:PonenteCongreso,
													Fechaini_CongBosque:Fechaini_CongBosque,
													Fechafin_CongBosque:Fechafin_CongBosque,
													NomEvento_CongBosque:NomEvento_CongBosque,
													NomPonencia_CongBosque:NomPonencia_CongBosque,
													Dependencia_CongBosque:Dependencia_CongBosque,
													PonenteLocal:PonenteLocal,
													Fechaini_Congreso:Fechaini_Congreso,
													Fechafin_Congreso:Fechafin_Congreso,
													NomEvento_Congreso:NomEvento_Congreso,
													NomPonencia_Congreso:NomPonencia_Congreso,
													Entidad_CongresoLocal:Entidad_CongresoLocal,
													PonenteNacional:PonenteNacional,
													Fechaini_CongNal:Fechaini_CongNal,
													Fechafin_CongNal:Fechafin_CongNal,
													NomEvento_CongNal:NomEvento_CongNal,
													NomPonencia_CongNal:NomPonencia_CongNal,
													id_CityCongreso:id_CityCongreso,
													Entidad_CongresoNal:Entidad_CongresoNal,
													PonenteInternacional:PonenteInternacional,
													Fechaini_CongInter:Fechaini_CongInter,
													Fechafin_CongInter:Fechafin_CongInter,
													NomEvento_CongInter:NomEvento_CongInter,
													NomPonencia_CongInter:NomPonencia_CongInter,
													id_CityCongInter:id_CityCongInter,
													id_Pais:id_Pais,
													Entidad_CongInter:Entidad_CongInter,
													PeriodoLogroDeport:PeriodoLogroDeport,
													PeriodoBecasDeport:PeriodoBecasDeport,
													LogroCultural:LogroCultural,
													CualLogrosCulturales:CualLogrosCulturales,
													PeriodoLogroCultural:PeriodoLogroCultural,
													BecaCultural:BecaCultural,
													CualBecasCulturales:CualBecasCulturales,
													PeriodoBecasCultural:PeriodoBecasCultural,
													Estudiante_id:Estudiante_id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{*/
									/**********************************************/	
										/*alert('Se Ha Guardado Correctamente...');
										location.href='HojaVidaEstudiante.php';*/
									/**********************************************/	
									/*}
				   } 
			}); //AJAX*/
			
		/****************************************************************************************************/
		/*************************************************************************************************************/				
		}		
/*****************************************************************************************************************/	
   function AgregarFila(){
	
	var NumFiles   =  parseFloat($('#numIndices').val());
	
	//alert('NumFiles->'+NumFiles);
	var TblMain    =  document.getElementById("d_tabla_add");
	var NumFiles   =  parseFloat($('#numIndices').val()) + 1;
	//alert('NumFiles_2->'+NumFiles);
	var NewTr      =  document.createElement("tr");
	NewTr.id       =  'trNewDetalle'+NumFiles;
	
	TblMain.appendChild(NewTr);

   // $('#addFila').css('display','none');
    $.ajax({
       url: "Hoja_Vida.html.php",
       type: "GET",
       data: "actionID=AddColumnas&Indice="+NumFiles,
       success: function(data){
        $('#numIndices').val(NumFiles);
            //$('#addFila').css('display','inline');
			$('#trNewDetalle'+NumFiles).attr('align','center');  
            $('#trNewDetalle'+NumFiles).html(data);
                    $('#d_tabla_add tr:last').find('input.Autocompletar').autocomplete({/*
							source: function( request, response ) {
										$.ajax({
											url: "diagnostico_prescripcion.html.php",
											dataType: "json",
											data: {
												actionID: 'autocompletarProduct',
												a: request.term
												
											},
											success: function( data ) {
						
												response( $.map( data, function( item ) {
													return {
														label: item.label,
														value: item.value,
														producto_id:item.producto_id,
														Unida_medida:item.Unida_medida,
														Concetracion:item.Concetracion	
													
													}
												}
												));
											}
										});
							},
							minLength: 2,
							   select: function( event, ui ) { 
								$("#producto_id_"+NumFiles).val(ui.item.producto_id);
			                    $("#DivUnidaMedida_"+NumFiles).html(ui.item.Unida_medida);	
								$("#concetracion_"+NumFiles).val(ui.item.Concetracion);						   
   }
						*/});            
       }
    });
	
	}
	function Activar_B(){
			if($('#Hepatitis_B').is(':checked')){
				/***************************************/	
					$('#Tr_Dosis_Hep').css('visibility','visible');
					
					$('#Hepati_B_Uno').attr('checked',false);
					$('#Hepati_B_Dos').attr('checked',false);
					$('#Hepati_B_Tres').attr('checked',false);
				/***************************************/	
				}else{
					/***************************************/	
					$('#Tr_Dosis_Hep').css('visibility','collapse');
					
					$('#Hepati_B_Uno').attr('checked',false);
					$('#Hepati_B_Dos').attr('checked',false);
					$('#Hepati_B_Tres').attr('checked',false);
					/***************************************/		
					}
		}
	function Activar_VPH(){
			if($('#VPH').is(':checked')){
				/***************************************/	
					$('#Tr_Dosis_VPH').css('visibility','visible');
					
					$('#VPH_Uno').attr('checked',false);
					$('#VPH_Dos').attr('checked',false);
					$('#VPH_Tres').attr('checked',false);
				/***************************************/	
				}else{
					/***************************************/	
					$('#Tr_Dosis_VPH').css('visibility','collapse');
					
					$('#VPH_Uno').attr('checked',false);
					$('#VPH_Dos').attr('checked',false);
					$('#VPH_Tres').attr('checked',false);
					/***************************************/		
					}
		}
	/*function VerPregunta_Uno(){
			if($('#Open_Uno').val()=='0' || $('#Open_Uno').val()==0){
					$('#Open_Uno').val(1);
					$('#Pregunta_Uno').css('display','inline');
				}else{
					$('#Open_Uno').val(0);
					$('#Pregunta_Uno').css('display','none');
					}
			
		}	*/
	function AlergiasCual(){
		
			if($('#Alegia_Si').is(':checked')){
				
					$('#Td_AlergiaCual').css('visibility','visible');
					$('#Cual_Alergia').val('');
					
				}else if($('#Alergia_No').is(':checked')){
					
					$('#Td_AlergiaCual').css('visibility','collapse');
					$('#Cual_Alergia').val('');
					
					}
			
		}
	function Ver_CualUsoMed(){
			
			if($('#UsoMed_Si').is(':checked')){
				
					$('#Td_UsoMedCual').css('visibility','visible');
					$('#Cual_UsoMed').val('');
					
				}else if($('#UsoMed_No').is(':checked')){
					
					$('#Td_UsoMedCual').css('visibility','collapse');
					$('#Cual_UsoMed').val('');
					
					}
		}	
	/*function VerPregutna_Cuatro(){
		
			if($('#Pregunta_4').val()=='0' || $('#Pregunta_4').val()==0){
					$('#Pregunta_4').val(1);
					$('#Div_Pregunta4').css('display','inline');	
				}else{
					$('#Pregunta_4').val(0);
					$('#Div_Pregunta4').css('display','none');
					}
			
		}
	function Ver_Pregunta5(){
			
			if($('#Pregunta5').val()=='0' || $('#Pregunta5').val()==0){
					
					$('#Pregunta5').val(1);
					$('#Div_Pregunta5').css('display','inline');
					
				}else{
					
					$('#Pregunta5').val(0);
					$('#Div_Pregunta5').css('display','none');
					
					}
			
		}	
	function Ver_Pregunta6(){
			
			if($('#Pregunta6').val()=='0' || $('#Pregunta6').val()==0){
					$('#Pregunta6').val(1);
					$('#Div_Pregunta6').css('display','inline');
				}else{
					$('#Pregunta6').val(0);
					$('#Div_Pregunta6').css('display','none');
					}
			
		}	*/
	function Ver_Cigarillo(){
			
			if($('#Si_Cigarrillo').is(':checked')){
				
					$('#Div_Cigarillo').css('display','inline');
					
					$('#C_uno').attr('checked',false);//-->Menos de 1 al dia
					$('#C_dos').attr('checked',false);//-->Entre uno y Dos al dia
					$('#C_tres').attr('checked',false);//-->Entre 3 y 6 al dia
					$('#C_Cuatro').attr('checked',false);//--> Entre 7 y 10 al dia
					$('#C_cinco').attr('checked',false);//-->Mas de 11 al dia
					
				}else if($('#No_Cigarrillo').is(':checked')){
					
					$('#Div_Cigarillo').css('display','none');
					
					$('#C_uno').attr('checked',false);//-->Menos de 1 al dia
					$('#C_dos').attr('checked',false);//-->Entre uno y Dos al dia
					$('#C_tres').attr('checked',false);//-->Entre 3 y 6 al dia
					$('#C_Cuatro').attr('checked',false);//--> Entre 7 y 10 al dia
					$('#C_cinco').attr('checked',false);//-->Mas de 11 al dia
					
					}
			
		}
	function ActividaFisica(){
		
			if($('#Si_Act_Fisica').is(':checked')){
				/********************************************/
					$('#Div_ActFisica').css('visibility','visible');
					$('#Div_ActFisica_2').css('display','inline');
					$('#Act_FisicaCual').val('');
					
					$('#Frec_uno').attr('checked',false);
					$('#Frec_dos').attr('checked',false);
					$('#Frec_tres').attr('checked',false);
				/********************************************/
				}else{
					/********************************************/
						$('#Div_ActFisica').css('visibility','collapse');
						$('#Div_ActFisica_2').css('display','none');
						$('#Act_FisicaCual').val('');
						
						$('#Frec_uno').attr('checked',false);
						$('#Frec_dos').attr('checked',false);
						$('#Frec_tres').attr('checked',false);
					/********************************************/
					}
		
		}	
	function PracticaDeportiva(){
			if($('#Si_Practica').is(':checked')){
					
					$('#T_DeportePractica').css('visibility','visible');
					$('#Div_Practica').css('display','inline');
					
					/*****************************************************/
						$('#Futbol').attr('checked',false);
						$('#F_sala').attr('checked',false);
						$('#Basketball').attr('checked',false);
						$('#Voleibol').attr('checked',false);
						$('#Rugby').attr('checked',false);
						$('#T_mesa').attr('checked',false);
						$('#Tennis').attr('checked',false);
						$('#Ciclismo').attr('checked',false);
						$('#Natacion').attr('checked',false);
						$('#Atletismo').attr('checked',false);
						$('#Beisbol').attr('checked',false);
						$('#Ajedrez').attr('checked',false);
						$('#Squash').attr('checked',false);
						$('#Taekwondo').attr('checked',false);
						$('#OtroPractica').attr('checked',false);
						$('#Otro_deporte').val('');
					/****************************************************/
					
				}else{
					
					$('#T_DeportePractica').css('visibility','collapse');
					$('#Div_Practica').css('display','none');

					
					/*****************************************************/
						$('#Futbol').attr('checked',false);
						$('#F_sala').attr('checked',false);
						$('#Basketball').attr('checked',false);
						$('#Voleibol').attr('checked',false);
						$('#Rugby').attr('checked',false);
						$('#T_mesa').attr('checked',false);
						$('#Tennis').attr('checked',false);
						$('#Ciclismo').attr('checked',false);
						$('#Natacion').attr('checked',false);
						$('#Atletismo').attr('checked',false);
						$('#Beisbol').attr('checked',false);
						$('#Ajedrez').attr('checked',false);
						$('#Squash').attr('checked',false);
						$('#Taekwondo').attr('checked',false);
						$('#OtroPractica').attr('checked',false);
						$('#Otro_deporte').val('');
					/****************************************************/
					}
		}
	function Ver_Pertenece(){
			
			if($('#Si_Pertenece').is(':checked')){
				
					$('#Div_PerteneceCual').css('visibility','visible');
				
				}else{
					
					$('#Div_PerteneceCual').css('visibility','collapse');
					
					}
			
		}	
	function Ver_Voluntariado(){
			
			if($('#Si_Voluntariado').is(':checked')){
				
					$('#T_Voluntariado').css('visibility','visible');
					
				}else{
					$('#T_Voluntariado').css('visibility','collapse');
					}
		
		}	
          function Ver_ApoyoVoluntareado(){
                    if($('#Si_GrupoApoyoBienestar').is(':checked')){
				
					$('#Tr_FechasGrupoApoyoBienestar').css('visibility','visible');
					
				}else{
					$('#Tr_FechasGrupoApoyoBienestar').css('visibility','collapse');
					}
          
            }
          function Ver_MonitorVoluntareado(){
                    if($('#Si_MonitoBienestar').is(':checked')){
				
					$('#Tr_OpcionesMonitorBienestar').css('visibility','visible');
					
				}else{
					$('#Tr_OpcionesMonitorBienestar').css('visibility','collapse');
					}
          
            }
	function Ver_Musica(){
		
			if($('#Si_musica').is(':checked')){
				
					$('#Div_Musica').css('display','inline');
				
				}else{
					
					$('#Div_Musica').css('display','none');
					
					}
			
		}	
	function Ver_ExpCorporal(){
		
			if($('#Si_ExpCorporal').is(':checked')){
				
					$('#Div_ExpCorporal').css('display','inline');
					
				}else{
					
					$('#Div_ExpCorporal').css('display','none');
					
					}
		
		}	
	function Ver_arteEscenico(){
		
			if($('#Si_Arte').is(':checked')){
					$('#Div_ArteEscenico').css('display','inline');
				}else{
					$('#Div_ArteEscenico').css('display','none');
					}
		
		}
	function Ver_arteLiteraria(){
			
			if($('#Si_Literaria').is(':checked')){
				
					$('#Div_literatura').css('display','inline');
									
				}else{
					
					$('#Div_literatura').css('display','none');
					
					}
		
		}	
	function Ver_artePlastica(){
		
			if($('#Si_Plastica').is(':checked')){
					$('#Div_Plastica').css('display','inline');
				}else{
					$('#Div_Plastica').css('display','none');
					}
			
		}	
	function Siguiente(){
	
		$('#Cargar').css('display','none');
		$('#Cargar_Dos').css('display','inline');

		}	
	function Ver_Alcohol(){
			
			if($('#Si_Alcohol').is(':checked')){
					$('#Div_Alcohol').css('display','inline');
				}else{
						$('#Div_Alcohol').css('display','none');
					}
		
		}
	function Ver_PAE(){
			if($('#Si_Pae').is(':checked')){
					$('#Div_PAE').css('display','inline');
				}else{
						$('#Div_PAE').css('display','none');
					}
		
		}	
	function Ver_OtroProblema(){
			if($('#Otro_Problema').is(':checked')){
					$('#Tr_OtroProblema').css('visibility','visible');
				}else{
					$('#Tr_OtroProblema').css('visibility','collapse');
					}
		}
	function Ver_FrecuenciaDeprotiva(){
			if($('#Futbol').is(':checked')){
					$('#Tr_F_Futbol').css('visibility','visible');
				}
			if($('#Futbol').is(':checked')===false){
					$('#Tr_F_Futbol').css('visibility','collapse');
				}	
			/********************************************************/	
				if($('#F_sala').is(':checked')){
					$('#Tr_F_FutbolSala').css('visibility','visible');
				}
			if($('#F_sala').is(':checked')===false){
					$('#Tr_F_FutbolSala').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Basketball').is(':checked')){
					$('#Tr_Basketball').css('visibility','visible');
				}
			if($('#Basketball').is(':checked')===false){
					$('#Tr_Basketball').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Voleibol').is(':checked')){
					$('#Tr_Voleibol').css('visibility','visible');
				}
			if($('#Voleibol').is(':checked')===false){
					$('#Tr_Voleibol').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Rugby').is(':checked')){
					$('#Tr_Rugby').css('visibility','visible');
				}
			if($('#Rugby').is(':checked')===false){
					$('#Tr_Rugby').css('visibility','collapse');
				}	
			/********************************************************/	
				if($('#T_mesa').is(':checked')){
					$('#Tr_T_mesa').css('visibility','visible');
				}
			if($('#T_mesa').is(':checked')===false){
					$('#Tr_T_mesa').css('visibility','collapse');
				}	
			/********************************************************/	
				if($('#Tennis').is(':checked')){
					$('#Tr_Tennis').css('visibility','visible');
				}
			if($('#Tennis').is(':checked')===false){
					$('#Tr_Tennis').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#OtroPractica').is(':checked')){
					$('#Tr_OtroPractica').css('visibility','visible');
				}
			if($('#OtroPractica').is(':checked')===false){
					$('#Tr_OtroPractica').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Ciclismo').is(':checked')){
					$('#Tr_Ciclismo').css('visibility','visible');
				}
			if($('#Ciclismo').is(':checked')===false){
					$('#Tr_Ciclismo').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Natacion').is(':checked')){
					$('#Tr_Natacion').css('visibility','visible');
				}
			if($('#Natacion').is(':checked')===false){
					$('#Tr_Natacion').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Atletismo').is(':checked')){
					$('#Tr_Atletismo').css('visibility','visible');
				}
			if($('#Atletismo').is(':checked')===false){
					$('#Tr_Atletismo').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Beisbol').is(':checked')){
					$('#Tr_Beisbol').css('visibility','visible');
				}
			if($('#Beisbol').is(':checked')===false){
					$('#Tr_Beisbol').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Ajedrez').is(':checked')){
					$('#Tr_Ajedrez').css('visibility','visible');
				}
			if($('#Ajedrez').is(':checked')===false){
					$('#Tr_Ajedrez').css('visibility','collapse');
				}
			/********************************************************/	
				if($('#Squash').is(':checked')){
					$('#Tr_Squash').css('visibility','visible');
				}
			if($('#Squash').is(':checked')===false){
					$('#Tr_Squash').css('visibility','collapse');
				}	
			/********************************************************/	
				if($('#Taekwondo').is(':checked')){
					$('#Tr_Taekwondo').css('visibility','visible');
				}
			if($('#Taekwondo').is(':checked')===false){
					$('#Tr_Taekwondo').css('visibility','collapse');
				}									
		}				
	function VerNivelesMusicales(){
		
			/*************************************************************/
				if($('#Guitarra').is(':checked')){
						$('#Tr_Guitarra').css('visibility','visible');
					}
				if($('#Guitarra').is(':checked')===false){
						$('#Tr_Guitarra').css('visibility','collapse');
					}	
			/*************************************************************/
				if($('#Bateria').is(':checked')){
						$('#Tr_Bateria').css('visibility','visible');
					}
				if($('#Bateria').is(':checked')===false){
						$('#Tr_Bateria').css('visibility','collapse');
					}	
			/*************************************************************/
				if($('#Saxofon').is(':checked')){
						$('#Tr_Saxofon').css('visibility','visible');
					}
				if($('#Saxofon').is(':checked')===false){
						$('#Tr_Saxofon').css('visibility','collapse');
					}	
			/*************************************************************/
				if($('#Otro_Musica').is(':checked')){
						$('#Tr_Otro_Musica').css('visibility','visible');
					}
				if($('#Otro_Musica').is(':checked')===false){
						$('#Tr_Otro_Musica').css('visibility','collapse');
					}	
			/*************************************************************/
				if($('#Trompeta').is(':checked')){
						$('#Tr_Trompeta').css('visibility','visible');
					}
				if($('#Trompeta').is(':checked')===false){
						$('#Tr_Trompeta').css('visibility','collapse');
					}	
			/*************************************************************/
				if($('#Congas').is(':checked')){
						$('#Tr_Congas').css('visibility','visible');
					}
				if($('#Congas').is(':checked')===false){
						$('#Tr_Congas').css('visibility','collapse');
					}	
			/*************************************************************/
				if($('#Acordion').is(':checked')){
						$('#Tr_Acordion').css('visibility','visible');
					}
				if($('#Acordion').is(':checked')===false){
						$('#Tr_Acordion').css('visibility','collapse');
					}	
			/*************************************************************/
			
		}
	function Ver_ExprecionCorporal(){
			/*********************************************/
				if($('#Danza').is(':checked')){
						$('#Tr_Danza').css('visibility','visible');
					}
				if($('#Danza').is(':checked')===false){
						$('#Tr_Danza').css('visibility','collapse');
					}	
			/*********************************************/
			if($('#Danza_Floclorica').is(':checked')){
						$('#Tr_Danza_Floclorica').css('visibility','visible');
					}
				if($('#Danza_Floclorica').is(':checked')===false){
						$('#Tr_Danza_Floclorica').css('visibility','collapse');
					}	
			/*********************************************/
			if($('#Danza_Moderna').is(':checked')){
						$('#Tr_Danza_Moderna').css('visibility','visible');
					}
				if($('#Danza_Moderna').is(':checked')===false){
						$('#Tr_Danza_Moderna').css('visibility','collapse');
					}	
			/*********************************************/
			if($('#Otra_Danza').is(':checked')){
						$('#Tr_Otra_Danza').css('visibility','visible');
					}
				if($('#Otra_Danza').is(':checked')===false){
						$('#Tr_Otra_Danza').css('visibility','collapse');
					}	
			/*********************************************/
			if($('#Danza_Contemporanea').is(':checked')){
						$('#Tr_Danza_Contemporanea').css('visibility','visible');
					}
				if($('#Danza_Contemporanea').is(':checked')===false){
						$('#Tr_Danza_Contemporanea').css('visibility','collapse');
					}	
			/*********************************************/
			if($('#Ballet').is(':checked')){
						$('#Tr_Ballet').css('visibility','visible');
					}
				if($('#Ballet').is(':checked')===false){
						$('#Tr_Ballet').css('visibility','collapse');
					}	
			/*********************************************/
			
		}	
	function Ver_ArteEscenicas(){
			/***************************************************/
				if($('#Teatro').is(':checked')){
						$('#Tr_Teatro').css('visibility','visible');
					}
				if($('#Teatro').is(':checked')===false){
						$('#Tr_Teatro').css('visibility','collapse');
					}
			/***************************************************/
			if($('#actuacion').is(':checked')){
						$('#Tr_actuacion').css('visibility','visible');
					}
				if($('#actuacion').is(':checked')===false){
						$('#Tr_actuacion').css('visibility','collapse');
					}
			/***************************************************/
			if($('#narracion').is(':checked')){
						$('#Tr_narracion').css('visibility','visible');
					}
				if($('#narracion').is(':checked')===false){
						$('#Tr_narracion').css('visibility','collapse');
					}
			/***************************************************/
			if($('#standcomedy').is(':checked')){
						$('#Tr_standcomedy').css('visibility','visible');
					}
				if($('#standcomedy').is(':checked')===false){
						$('#Tr_standcomedy').css('visibility','collapse');
					}
			/***************************************************/
			if($('#Otro_arte').is(':checked')){
						$('#Tr_Otro_arte').css('visibility','visible');
					}
				if($('#Otro_arte').is(':checked')===false){
						$('#Tr_Otro_arte').css('visibility','collapse');
					}
			/***************************************************/
			
		}	
	function Ver_ArteLiterario(){
			/***************************************************/
			if($('#poesia').is(':checked')){
						$('#Tr_poesia').css('visibility','visible');
					}
				if($('#poesia').is(':checked')===false){
						$('#Tr_poesia').css('visibility','collapse');
					}
			/***************************************************/
			if($('#cuento').is(':checked')){
						$('#Tr_cuento').css('visibility','visible');
					}
				if($('#cuento').is(':checked')===false){
						$('#Tr_cuento').css('visibility','collapse');
					}
			/***************************************************/
			if($('#novela').is(':checked')){
						$('#Tr_novela').css('visibility','visible');
					}
				if($('#novela').is(':checked')===false){
						$('#Tr_novela').css('visibility','collapse');
					}
			/***************************************************/
			if($('#cronica').is(':checked')){
						$('#Tr_cronica').css('visibility','visible');
					}
				if($('#cronica').is(':checked')===false){
						$('#Tr_cronica').css('visibility','collapse');
					}
			/***************************************************/
			if($('#Otro_Literatura').is(':checked')){
						$('#Tr_Otro_Literatura').css('visibility','visible');
					}
				if($('#Otro_Literatura').is(':checked')===false){
						$('#Tr_Otro_Literatura').css('visibility','collapse');
					}
			/***************************************************/
			
		}	
	function VerArtePlasticaVisual(){
			/***************************************************/
			if($('#fotografia').is(':checked')){
						$('#Tr_fotografia').css('visibility','visible');
					}
				if($('#fotografia').is(':checked')===false){
						$('#Tr_fotografia').css('visibility','collapse');
					}
			/***************************************************/
			if($('#video').is(':checked')){
						$('#Tr_video').css('visibility','visible');
					}
				if($('#video').is(':checked')===false){
						$('#Tr_video').css('visibility','collapse');
					}
			/***************************************************/
			if($('#diseno_Gra').is(':checked')){
						$('#Tr_diseno_Gra').css('visibility','visible');
					}
				if($('#diseno_Gra').is(':checked')===false){
						$('#Tr_diseno_Gra').css('visibility','collapse');
					}
			/***************************************************/
			if($('#comic').is(':checked')){
						$('#Tr_comic').css('visibility','visible');
					}
				if($('#comic').is(':checked')===false){
						$('#Tr_comic').css('visibility','collapse');
					}
			/***************************************************/
			if($('#Otro_Plastico').is(':checked')){
						$('#Tr_Otro_Plastico').css('visibility','visible');
					}
				if($('#Otro_Plastico').is(':checked')===false){
						$('#Tr_Otro_Plastico').css('visibility','collapse');
					}
			/***************************************************/
			if($('#dibujo').is(':checked')){
						$('#Tr_dibujo').css('visibility','visible');
					}
				if($('#dibujo').is(':checked')===false){
						$('#Tr_dibujo').css('visibility','collapse');
					}
			/***************************************************/
			if($('#grafitty').is(':checked')){
						$('#Tr_grafitty').css('visibility','visible');
					}
				if($('#grafitty').is(':checked')===false){
						$('#Tr_grafitty').css('visibility','collapse');
					}
			/***************************************************/
			if($('#escultura').is(':checked')){
						$('#Tr_escultura').css('visibility','visible');
					}
				if($('#escultura').is(':checked')===false){
						$('#Tr_escultura').css('visibility','collapse');
					}
			/***************************************************/
			if($('#pintura').is(':checked')){
						$('#Tr_pintura').css('visibility','visible');
					}
				if($('#pintura').is(':checked')===false){
						$('#Tr_pintura').css('visibility','collapse');
					}
			/***************************************************/
		}
	function Ver_Empleo(){
			if($('#Trab_Si').is(':checked')){
					$('.Empleo_Ver').css('visibility','visible');
				}else{
					$('.Empleo_Ver').css('visibility','collapse');
					}
		}	
	function Ver_Seleciones(){
			if($('#Si_Selec').is(':checked')){
					$('#Tr_OpcioneSelecion').css('visibility','visible');
				}else{
						$('#Tr_OpcioneSelecion').css('visibility','collapse');
					}
		}	
	function Ver_ApoyosUniversida(){
			if($('#Si_Apoyo').is(':checked')){
					$('#Tr_ApoyosUniversidad').css('visibility','visible');
				}else{
						$('#Tr_ApoyosUniversidad').css('visibility','collapse');
					}
		}	
	function Ver_TalleresDeportivos(){
			if($('#Si_Talleres').is(':checked')){
					$('#Tr_TallerDeportes').css('visibility','visible');	
				}else{
						$('#Tr_TallerDeportes').css('visibility','collapse');
					}
		}	
	function Ver_LogroDeportivo(){
			if($('#Si_LogroDepor').is(':checked')){
					$('#Td_TituloCualLogro').css('visibility','visible');
					//$('.Td_Caja_CualLogro').css('visibility','visible');
				}else{
						$('#Td_TituloCualLogro').css('visibility','collapse');
						//$('.Td_Caja_CualLogro').css('visibility','collapse');
					}
		}			
	function Ver_AsitenciaGimnasio(){
			if($('#Si_Gym').is(':checked')){
					$('#Tr_CuantasVeces').css('visibility','visible');
				}else{
						$('#Tr_CuantasVeces').css('visibility','collapse');
					}
		}
	function Ver_ClubRunning(){
			if($('#Si_ClubRunning').is(':checked')){
					$('#Td_CajaFechaVinculacion').css('visibility','visible');
				}else{
						$('#Td_CajaFechaVinculacion').css('visibility','collapse');
					}
		}	
	function Ver_ClubCaminantes(){
			if($('#Si_ClubCaminantes').is(':checked')){
					$('#Td_CajaFechaVinculacionCaminantes').css('visibility','visible');
				}else{
						$('#Td_CajaFechaVinculacionCaminantes').css('visibility','collapse');
					}
		}	
                
        function colocarCalendariosIncapacidades(){
            $('.saludbienestar table#Table_Fechas input.dateInput').each(function() { 
                    var inputDate = $(this);
                    if(!inputDate.hasClass('hasDatepicker')){
                        inputDate.datepicker({changeMonth: true,
			changeYear: true,
			showOn: "button",
			buttonImage: "../../../css/themes/smoothness/images/calendar.gif",
			buttonImageOnly: true,
			dateFormat: "yy-mm-dd"})
                    }
                });
        }        
	function AddFechas(){
			var NumFiles   =  parseFloat($('#numIndicesFeha').val());
                        
					if((!$('#transcrita_incapacidad_'+NumFiles).is(':checked') && !$('#emitida_incapacidad_'+NumFiles).is(':checked'))
                                            || !$.trim($('#Fecha_InicioIncapacida_'+NumFiles).val())  ||
                                            !$.trim($('#Fecha_FinalizacionIncapacidad_'+NumFiles).val()) ||
                                            !$.trim($('#Motivo_incapacida_'+NumFiles).val())){
							alert('tiene que ingresar Todos los datos de la Incapacidad para adicionar otras celdas ');
							return false;
						} else {
                                                    var html = '<tr>';
                                                    html += '<td align="center"><strong>'+(NumFiles+2)+'. Incapacidad estudiante</strong></td>';
                                                    html += '<td align="center"><strong>Transcrita</strong>&nbsp;&nbsp;&nbsp;';
                                                    html += '<input type="radio" id="transcrita_incapacidad_'+(NumFiles+1)+'" name="tipoIncapacidad_'+(NumFiles+1)+'" value="1">&nbsp;&nbsp;&nbsp;';
                                                    html += '<strong>Emitida</strong>&nbsp;&nbsp;&nbsp;';
                                                    html += '<input type="radio" id="emitida_incapacidad_'+(NumFiles+1)+'" name="tipoIncapacidad_'+(NumFiles+1)+'" value="2"></td>';
                                                    html += '<td align="center">&nbsp;&nbsp;</td>';
                                                    html += '<td align="center"><input type="text" readonly value="" autocomplete="off" placeholder="Fecha de Inicio" tabindex="7" maxlength="12" title="Fecha de inico de la incapacidad" id="Fecha_InicioIncapacida_'+(NumFiles+1)+'" size="14" name="Fecha_InicioIncapacida_'+(NumFiles+1)+'" class="dateInput"></td>';
                                                    html += '<td align="center">&nbsp;&nbsp;</td>';
                                                    html += '<td align="center"><input type="text" readonly value="" autocomplete="off" placeholder="Fecha Final" tabindex="7" maxlength="12" title="Fecha final de la incapacidad" id="Fecha_FinalizacionIncapacidad_'+(NumFiles+1)+'" size="14" name="Fecha_FinalizacionIncapacidad_'+(NumFiles+1)+'" class="dateInput"></td>';
                                                    html += '<td align="center">&nbsp;&nbsp;</td>';
                                                    html += '<td align="center"><input type="text" size="50" placeholder="Motivo de la Incapacidad" class="CajasHoja" name="Motivo_incapacida_'+(NumFiles+1)+'" id="Motivo_incapacida_'+(NumFiles+1)+'">';
                                                    html += '<input type="hidden" value="" id="idIncapacidad_'+(NumFiles+1)+'" name="idIncapacidad_'+(NumFiles+1)+'" /></td></tr>';
                                                    $( "#Table_Fechas" ).append( html );
                                                    $('#numIndicesFeha').val(NumFiles+1);
                                                    colocarCalendariosIncapacidades();
                                                }
                        return true;
	
	}	
	function Ver_AcidenteUniversidad(){
			if($('#Si_Acidente').is(':checked')){
					$('#Td_TituloFechaAccidente').css('visibility','visible');
					$('#Td_CajaFechaAccidente').css('visibility','visible');
					$('#Tr_UsoSeguroUniversidad').css('visibility','visible');
				}else{
						$('#Td_TituloFechaAccidente').css('visibility','collapse');
						$('#Td_CajaFechaAccidente').css('visibility','collapse');
						$('#Tr_UsoSeguroUniversidad').css('visibility','collapse');
					}
		}
	function VerTiposGrupoCultura(){
			if($('#Si_GrupoCultura').is(':checked')){
					$('#Tr_TiposGruposCulturales').css('visibility','visible');
				}else{
					$('#Tr_TiposGruposCulturales').css('visibility','collapse');
					}
		}
	function Ver_TalleresCultura(){
			if($('#Si_TalleresCultura').is(':checked')){
					$('#Tr_TalleresCulturales').css('visibility','visible');
				}else{
						$('#Tr_TalleresCulturales').css('visibility','collapse');
					}
		}
	function VerInstigaciones(){
			if($('#Si_Investiga').is(':checked')){
					$('#Tr_Investigaciones').css('visibility','visible');
				}else{
						$('#Tr_Investigaciones').css('visibility','collapse');
					}
		}	
	function Ver_Semillero(){
			if($('#Si_Semillero').is(':checked')){
					$('#Tr_Semillero').css('visibility','visible');
				}else{
						$('#Tr_Semillero').css('visibility','collapse');
					}
		}			
	function Ver_Publicacion(){
			if($('#Si_Publicaciones').is(':checked')){
					$('#Table_Publicacion').css('visibility','visible');
				}else{
						$('#Table_Publicacion').css('visibility','collapse');
					}
		}	
	function Ver_PublicacionExterna(){
			if($('#Si_PublicacionExt').is(':checked')){
					$('#Table_PublicacionExterna').css('visibility','visible');
				}else{
						$('#Table_PublicacionExterna').css('visibility','collapse');
					}
		}	
	function Ver_EventosInvestigacion(){
			if($('#Si_AsisEventos').is(':checked')){
					$('#Tr_EventoInvesti').css('visibility','visible');
				}else{
						$('#Tr_EventoInvesti').css('visibility','collapse');
					}
		}	
	function Ver_PonenteCongreso(){
			if($('#Si_PonenteCongreso').is(':checked')){
					$('#Table_PonenteCongreso').css('visibility','visible');
				}else{
						$('#Table_PonenteCongreso').css('visibility','collapse');
					}
		}	
	function Ver_PonenteLocal(){
			if($('#Si_PonenteLocal').is(':checked')){
					$('#Tr_PonenteLocal').css('visibility','visible');
				}else{
						$('#Tr_PonenteLocal').css('visibility','collapse');
					}
		}	
	function Ver_PonenteNacional(){
			if($('#Si_PonenteNacional').is(':checked')){
					$('#Tr_PonenteNacional').css('visibility','visible');
				}else{
						$('#Tr_PonenteNacional').css('visibility','collapse');
					}
		}	
	function Ver_PonenteInternacional(){
			if($('#Si_PonenteInternacional').is(':checked')){
					$('#Tr_PonenteInternacional').css('visibility','visible');
				}else{
						$('#Tr_PonenteInternacional').css('visibility','collapse');
					}
		}	
	function Ver_CursoLocal(){
			if($('#Si_CursoLocal').is(':checked')){
					$('#Tr_CursoLocal').css('visibility','visible');
				}else{
						$('#Tr_CursoLocal').css('visibility','collapse');
					}
		}
	function Ver_CursoNacional(){
			if($('#Si_CursoNacional').is(':checked')){
					$('#Tr_CursoNacional').css('visibility','visible');
				}else{
						$('#Tr_CursoNacional').css('visibility','collapse');
					}
		}	
	function VerMovilidad(){
			if($('#Si_Movilidad').is(':checked')){
					$('#Tr_Movilidad').css('visibility','visible');
				}else{
						$('#Tr_Movilidad').css('visibility','collapse');
					}
		}	
	function Ver_CursoInternacional(){
			if($('#Si_CursoInternacional').is(':checked')){
					$('#Tr_CursoInternacional').css('visibility','visible');
				}else{
						$('#Tr_CursoInternacional').css('visibility','collapse');
					}
		}
	function Ver_UJoinUs(){
			if($('#Si_UJoinUs').is(':checked')){
					$('#Tr_UJoinUs').css('visibility','visible');
				}else{
						$('#Tr_UJoinUs').css('visibility','collapse');
					}
		}
	function Ver_Collaborate(){
			if($('#Si_Collaborate').is(':checked')){
					$('#Tr_Collaborate').css('visibility','visible');
				}else{
						$('#Tr_Collaborate').css('visibility','collapse');
					}
		}
	function Ver_Sittio(){
			if($('#Si_Sittio').is(':checked')){
					$('#Tr_Sittio').css('visibility','visible');
				}else{
						$('#Tr_Sittio').css('visibility','collapse');
					}		
		}						
	function Genero(){
			var Genero  = $('#Genero').val();
			
			if(Genero == 100 || Genero == '100'){
					$('#DatosMilitares').css('visibility','collapse');
					$('#DatosMilitares_2').css('visibility','collapse');
					$('#DatosMilitares_3').css('visibility','collapse');
					$('#DatosMilitares_4').css('visibility','collapse');
				}else if(Genero == 200 || Genero == '200'){
					$('#DatosMilitares').css('visibility','visible');
					$('#DatosMilitares_2').css('visibility','visible');
					$('#DatosMilitares_3').css('visibility','visible');
					$('#DatosMilitares_4').css('visibility','visible');
					}
		}	
	function CargarRecurso(){
			
			var R_Finaciero  = $('#RecursoFinaciero').val();
			
			
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Valida',R_Finaciero:R_Finaciero}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							$('#Cargar').html(data);
				   } 
			}); //AJAX
			
		}	
	function Format(){
			 $('#id_Ciudad').val('');
			 $('#LugarNaci').val('');
		}	
	function autocompletCiudad_Naci(){
		/********************************************************/	
			$('#LugarNaci').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#id_Ciudad').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/	
		}
	function autocompletCiudadResid(){
		/********************************************************/	
			$('#CiudadResid').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#id_CiudadResid').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/	
		}
	function FormatResident(){
			 $('#id_CiudadResid').val('');
			 $('#CiudadResid').val('');
		}
	function FormatCole(){
			$('#Institucion').val('');
			$('#Id_Colegio').val('');
		}	
	function autocompletColegios(){
		/********************************************************/	
		
		if($('#Otro_Colegio').is(':checked')){
				var dato = 1;
			}else{ 
				var dato = 0;
			}
		
		
		
			$('#Institucion').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletColegio&Dato="+dato,
					minLength: 2,
					select: function( event, ui ) {
						
						$('#Id_Colegio').val(ui.item.id_Colegio);
						$('#Ciudad_Cole').val(ui.item.NameCiudad)
						}
					
				});//LugarNaci
	
		/********************************************************/	
		}	
	function AutocompletarCityCole(){
		/********************************************************/	
			$('#Ciudad_Cole').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						//$('#id_CiudadResid').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/
		}	
	function OmitirEvento(){
			if($('#Otro_Colegio').is(':checked')){
					$('#Ciudad_Cole').attr('readonly',false);
				}else{ 
					$('#Ciudad_Cole').attr('readonly',true);
				}
		}	
	function Edit_U(j){
			/************************************************/
				$('#Muestra_info_'+j).css('display','none');
				$('#Edit_info_'+j).css('display','inline');
			/************************************************/
		}
	function Save_U(id_Estudiante){
			/*****************************************************/
			
			if($('#Si_otras').is(':checked')){//-->Si_otras
			
			var institucion  = $('#institucion_Admi').val();
			var Programa     = $('#Programa_Admi').val();
			var Year         = $('#Year_Admi').val();
			
			/*****************************************************/
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Save_U',institucion:institucion,
				   							 Programa:Programa,
											 Year:Year,
											 id_Estudiante:id_Estudiante}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										$.ajax({//Ajax
											   type: 'GET',
											   url: 'Hoja_Vida.html.php',
											   async: false,
											  // dataType: 'json',
											   data:({actionID: 'Cargar_OtrasU',id_Estudiante:id_Estudiante}),
											   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
											   success: function(data){
														$('#Div_otrasUniversidades').html(data);
											   } 
										}); //AJAX
									/**********************************************/	
									}
				   } 
			}); //AJAX
			/*****************************************************/
		}else{
				alert('Solo Puede Guardar los Datos si Seleciono la Opcion Si de la Pregunta \n ¿ Se ha presentado a otras universidades ?');
				return false;
			}//--> Si_otras		
	}
	function Delete_U(id,id_Estudiante){
		
		if(confirm('Seguro Desea El Registro...?'))	{
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Delete_U',id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										$.ajax({//Ajax
											   type: 'GET',
											   url: 'Hoja_Vida.html.php',
											   async: false,
											  // dataType: 'json',
											   data:({actionID: 'Cargar_OtrasU',id_Estudiante:id_Estudiante}),
											   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
											   success: function(data){
														$('#Div_otrasUniversidades').html(data);
											   } 
										}); //AJAX
									/**********************************************/	
									}
				   } 
			}); //AJAX
		  }
		}
	function Update_U(id,j,id_Estudiante){
		
		/*****************************************************/
		
		var institucion  = $('#institucion_Admi_'+j).val();
		var Programa     = $('#Programa_Admi_'+j).val();
		var Year         = $('#Year_Admi_'+j).val();
		
		if(!$.trim(institucion)){
				alert('Ingrese una Institucion....');
				return false;
			}
		if(!$.trim(Programa)){
				alert('Ingrese un Programa....');
				return false;
			}
		if(!$.trim(Year)){
				alert('Ingrese un A\u00f1o....');
				return false;
			}		
		
		/*****************************************************/
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'UPDATE_U',institucion:institucion,
				   							 Programa:Programa,
											 Year:Year,
											 id_Estudiante:id_Estudiante,
											 id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										$.ajax({//Ajax
											   type: 'GET',
											   url: 'Hoja_Vida.html.php',
											   async: false,
											  // dataType: 'json',
											   data:({actionID: 'Cargar_OtrasU',id_Estudiante:id_Estudiante}),
											   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
											   success: function(data){
														$('#Div_otrasUniversidades').html(data);
											   } 
										}); //AJAX
									/**********************************************/	
									}
				   } 
			}); //AJAX
			/*****************************************************/
		
		}	
	function Format_Uni(){
			$('#Institucion_Otros_estu').val('');
			$('#id_Universidad_Otros').val('');
		}	
	function AutocompletarUniverisidad(){
			/********************************************************/	
		
			if($('#OtraUniv_Text').is(':checked')){
					var dato = 1;
					
					$('#Ciudad_Otros').attr('readonly',false);
					
				}else{ 
					var dato = 0;
					$('#Ciudad_Otros').attr('readonly',true);
				}
			
			
			
				$('#Institucion_Otros_estu').autocomplete({
						
						source: "Hoja_Vida.html.php?actionID=AutoCompletUniversidad&Dato="+dato,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Universidad_Otros').val(ui.item.id_Univerisidad);
							$('#Ciudad_Otros').val(ui.item.NameCiudad)
							}
						
					});//LugarNaci
		
			/********************************************************/	
		}
	function AutocompletCytyUniv(){
		/********************************************************/	
			$('#Ciudad_Otros').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						//$('#id_CiudadResid').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/
		}		
	function Save_OtroEstud(id_Estudiante){
			/********************************************************/
				
				var Nivel     = $('#Nivel_otros').val();
				
				if(Nivel==-1 || Nivel=='-1'){
						alert('Seleccione un Nivel de Educacion...');
						return false;
					}
				
				if($('#OtraUniv_Text').is(':checked')){
						var Name = $('#Institucion_Otros_estu').val();
						
						if(!$.trim(Name)){
								alert('Ingrese un Nombre de Institucion....');
								return false;
							}
						
						var id_Univd ='1';
					}else{
						 var id_Univd = $('#id_Universidad_Otros').val();
						 if(!$.trim(id_Univd)){
								alert('Ingrese un Nombre de Institucion....');
								return false;
							}
						 var Name = '';
						}
				
				if($('#Titulo_No').is(':checked')){
						var Titulo  = $('#Titulo_otros').val();	
						if(!$.trim(Titulo)){
								alert('Ingrese un Titulo...');
								return false;
							}
						var id_Titulo = '1';
					}else{
						var Titulo  = '';	
						
						var id_Titulo = $('#Titulo_id').val();
						if(!$.trim(id_Titulo)){
								alert('Ingrese un Titulo...');
								return false;
							}
						}
				
					
				var Ciudad  = $('#Ciudad_Otros').val();
				var Year    = $('#Year_otros').val();
				var Observacion  = $('#Observacion_Otros').val();
				
			/********************************************************/
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Save_Univerd',Nivel:Nivel,
				   								   Name:Name,
												   id_Univd:id_Univd,
												   Titulo:Titulo,
												   Ciudad:Ciudad,
												   Year:Year,
												   id_Estudiante:id_Estudiante,
												   Observacion:Observacion,
												   id_Titulo:id_Titulo}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										$.ajax({//Ajax
											   type: 'GET',
											   url: 'Hoja_Vida.html.php',
											   async: false,
											  // dataType: 'json',
											   data:({actionID: 'Cargar_OtrosEstud',id_Estudiante:id_Estudiante}),
											   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
											   success: function(data){
														$('#Div_OtrosEstudios').html(data);
											   } 
										}); //AJAX
									/**********************************************/	
									}
				   } 
			}); //AJAX
			
			
			/********************************************************/
		}	
	function Format_Titulo(){
			$('#Titulo_otros').val('');
			$('#Titulo_id').val('');
		}	
	function AutoCompletTitulo(){
			/********************************************************/
				if($('#Titulo_No').is(':checked')){
					var dato = 1;
					
				}else{ 
					var dato = 0;
				}
			
			
			
				$('#Titulo_otros').autocomplete({
						
						source: "Hoja_Vida.html.php?actionID=AutoCompletTitulo&Dato="+dato,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#Titulo_id').val(ui.item.Titulo_id);
							}
						
					});//LugarNaci
			
			/********************************************************/
		}	
	function Edit_Otro(k){
			$('#Div_EditOtro_'+k).css('display','inline');
			$('#Div_Mostrar_'+k).css('display','none');
		}	
	function Format_UniOtro(k){
			$('#Institucion_Otros_'+k).val('');
			$('#id_Universidad_OtroEdit_'+k).val('');
		}	
	function AutocompletarUniverisidadOtro(k){
		/********************************************************/	
		
			if($('#OtraUniv_Edit_'+k).is(':checked')){
					var dato = 1;
					
					$('#Ciudad_OtrosEdit_'+k).attr('readonly',false);
					
				}else{ 
					var dato = 0;
					$('#Ciudad_OtrosEdit_'+k).attr('readonly',true);
				}
			
			
			
				$('#Institucion_Otros_'+k).autocomplete({
						
						source: "Hoja_Vida.html.php?actionID=AutoCompletUniversidad&Dato="+dato,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#id_Universidad_OtroEdit_'+k).val(ui.item.id_Univerisidad);
							$('#Ciudad_OtrosEdit_'+k).val(ui.item.NameCiudad)
							}
						
					});//LugarNaci
		
			/********************************************************/	
		}
	function Format_TituloEdit(k){
			$('#Titulo_otrosEdit_'+k).val('');
			$('#Titulo_id_Edit_'+k).val('');
		}
	function AutoCompletTituloEdit(k){
		/********************************************************/
				if($('#Titulo_No_Edit_'+k).is(':checked')){
					var dato = 1;
					
				}else{ 
					var dato = 0;
				}
			
			
			
				$('#Titulo_otrosEdit_'+k).autocomplete({
						
						source: "Hoja_Vida.html.php?actionID=AutoCompletTitulo&Dato="+dato,
						minLength: 2,
						select: function( event, ui ) {
							
							$('#Titulo_id_Edit_'+k).val(ui.item.Titulo_id);
							}
						
					});//LugarNaci
			
			/********************************************************/
		}	
	function AutocompletCytyUnivEdit(k){
		/********************************************************/	
			$('#Ciudad_OtrosEdit_'+k).autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						//$('#id_CiudadResid').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/
		}	
	function Update_Otro(id,k,id_Estudiante){
		/********************************************************/
				
				var Nivel     = $('#Nivel_'+k).val();
				
				if($('#OtraUniv_Edit_'+k).is(':checked')){
						var Name = $('#Institucion_Otros_'+k).val();
						
						if(!$.trim(Name)){
								alert('Ingrese un Nombre de Institucion....');
								return false;
							}
						
						var id_Univd ='1';
					}else{
						 var id_Univd = $('#id_Universidad_OtroEdit_'+k).val();
						 if(!$.trim(id_Univd)){
								alert('Ingrese un Nombre de Institucion....');
								return false;
							}
						 var Name = '';
						}
				
				if($('#Titulo_No_Edit_'+k).is(':checked')){
						var Titulo  = $('#Titulo_otrosEdit_'+k).val();	
						if(!$.trim(Titulo)){
								alert('Ingrese un Titulo...');
								return false;
							}
						var id_Titulo = '1';
					}else{
						var Titulo  = '';	
						
						var id_Titulo = $('#Titulo_id_Edit_'+k).val();
						if(!$.trim(id_Titulo)){
								alert('Ingrese un Titulo...');
								return false;
							}
						}
				
					
				var Ciudad  = $('#Ciudad_OtrosEdit_'+k).val();
				var Year    = $('#Year_Edit_'+k).val();
				//var Observacion  = $('#Observacion_Otros').val();
				
			/********************************************************/
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Update_Univerd',Nivel:Nivel,
				   								   Name:Name,
												   id_Univd:id_Univd,
												   Titulo:Titulo,
												   Ciudad:Ciudad,
												   Year:Year,
												   id_Estudiante:id_Estudiante,
												   id_Titulo:id_Titulo,
												   id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										$.ajax({//Ajax
											   type: 'GET',
											   url: 'Hoja_Vida.html.php',
											   async: false,
											  // dataType: 'json',
											   data:({actionID: 'Cargar_OtrosEstud',id_Estudiante:id_Estudiante}),
											   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
											   success: function(data){
														$('#Div_OtrosEstudios').html(data);
											   } 
										}); //AJAX
									/**********************************************/	
									}
				   } 
			}); //AJAX
			
			
			/********************************************************/
		}	
	function Delete_Otro(id,id_Estudiante){
		/********************************************************/
		
		if(confirm('Seguro Desea Eliminar El Registro...?')){
		
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Delete_Univerd',id_Estudiante:id_Estudiante,
												     id:id}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										$.ajax({//Ajax
											   type: 'GET',
											   url: 'Hoja_Vida.html.php',
											   async: false,
											  // dataType: 'json',
											   data:({actionID: 'Cargar_OtrosEstud',id_Estudiante:id_Estudiante}),
											   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
											   success: function(data){
														$('#Div_OtrosEstudios').html(data);
											   } 
										}); //AJAX
									/**********************************************/	
									}
				   } 
			}); //AJAX
			
		  }
			/********************************************************/
		}
	function Save_idioma(Op,i,id_idioma){
			/********************************************************/
			
			var id_Estudiante = $('#id_Estudiante').val();
			
			var Nombre   = $('#Nombre_idioma_'+i).val();
			
			if($('#B_'+Nombre).is(':checked')){
					var Guardado = $('#Guardado_'+id_idioma).val();//Puede ser un 1 o un 0
					var ValorChechk = 20;
				}
			
			if($('#I_'+Nombre).is(':checked')){
					var Guardado = $('#Guardado_'+id_idioma).val();
					var ValorChechk = 60;
				}
			
			if($('#A_'+Nombre).is(':checked')){
					var Guardado = $('#Guardado_'+id_idioma).val();
					var ValorChechk = 90;
				}
				
			var id_registro  = $('#id_registro_'+i).val();	
			
			$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   dataType: 'json',
				   data:({actionID: 'Save_Idioma',id_Estudiante:id_Estudiante,
												  id_idioma:id_idioma,
												  id_registro:id_registro,
												  Guardado:Guardado,
												  ValorChechk:ValorChechk}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}
				   } 
			}); //AJAX
			
			/********************************************************/
		}	
	function Atras(){
		
		/*************************************************/
		$('#Cargar_Dos').css('display','none');
		$('#Cargar').css('display','inline');
		}
	function Save_Tab1(id_Estudiante,ind){
		/****************************InformacionGeneral *************************************/	
		if(ind==1){
			
			var Nombre  = $('#Nombre').val();
			
			if(!$.trim(Nombre)){
					/*alert('Ingrese el Nombre del Estudiante...');
					return false;*/
				}
			
			var Apellidos  = $('#Apellidos').val();	
			
			if(!$.trim(Apellidos)){
					/*alert('Ingrese Los Apellidos del Estudiante...');
					return false;*/
				}
				
			var TipoDocumento  = $('#TipoDocumento').val();
			var Num_Documento  = $('#Num_Documento').val();
			
				if(!$.trim(Num_Documento)){
						/*alert('Ingrese El Numero de Documento...');
						return false;*/
					}
				
			var Expedida_Doc   = $('#Expedida_Doc').val();
				
				if(!$.trim(Expedida_Doc)){
						/*alert('Ingrese la Ciudad de Expedici\u00f3n del Documento...');
						return false;*/
				}
			var FechaDocu = $('#FechaDocu').val();
			var Genero  = $('#Genero').val();
			var EstadiCivil = $('#EstadiCivil').val();
			var Estrato = $('#Estrato').val();
			
			if(Genero==200 || Genero=='200'){
					var LibretaMilitar    = $('#LibretaMilitar').val();
					
					if(!$.trim(LibretaMilitar)){
							/*alert('Ingrese el Numero de Libreta Militar...');
							return false;*/
						}
					
					var Distrito          = $('#Distrito').val();
					
					if(!$.trim(Distrito)){
							/*alert('Ingrese el Distrito...');
							return false;*/
						}
					
					var ExpedidaLibreta   = $('#ExpedidaLibreta').val();
					
					if(!$.trim(ExpedidaLibreta)){
							/*alert('Ingrese la Ciudad Donde fue Expedida La libreta Militar');*/
						}
					
				}else{
					
						var LibretaMilitar    = '';
						var Distrito          = '';
						var ExpedidaLibreta   = '';
					}
			
			var Ciuda_Naci  = $('#id_Ciudad').val();
			var FechaNaci   = $('#FechaNaci').val();
			var Dir_recidente  = $('#Dir_recidente').val();
			var Tel_Recidente  = $('#Tel_Recidente').val();
			var id_CiudadResid  = $('#id_CiudadResid').val();
			var EmailBosque      = $('#EmailBosque').val();
			var Email_2          = $('#Email_2').val();
			var Nombre_Emerg      = $('#Nom_Emergencia').val();
			var Parentesco   = $('#Parentesco').val();
			var Telefono1_Parent  = $('#Telefono1_Parent').val();
			var Telefono1_Parent2  = $('#Telefono1_Parent2').val();
			var Eps  = $('#Eps').val();
			var GrupoEtnico = $('#GrupoEtnico').val( );
			var TipoSanguineo = $('#TipoSanguineo').val( );
			
			
			if(!$.trim(Eps)){
					/*alert('Ingrese el Nombre de Su EPS...');
					return false;*/
				}
			var Tipo_Eps ='';
			if($('#Benficiario').is(':checked')){
					var Tipo_Eps = 1
				}
			if($('#Cotizante').is(':checked')){
					var Tipo_Eps = 0
				}
				
			if($('#Benficiario').is(':checked')=== false && $('#Cotizante').is(':checked')===false){
					/*alert('Selecione un Tipo de Afiliacion \n ejemplo Beneficiario o Cotizante...');
					return false;*/
				}
				
			var numIndices = $('#numIndices').val();				
			$('#Cadena_Familia').val('');
			/***************************************************/
				for(j=0;j<=numIndices;j++){
					/***************************************************/
						var id_Existente  = $('#id_RegistroFami_'+j).val();
						var Parentesco_F    = $('#Parentesco_'+j).val();    
						var Nombre_Familia		  = $('#Nombre_'+j).val();
						var Apellido_familia     = $('#Apellido_'+j).val();
						var Ocupacion_F     = $('#Ocupacion_'+j).val(); 
						var NivelEdu_F	  = $('#NivelEdu_'+j).val(); 
						var TelefonoFami  = $('#TelefonoFami_'+j).val();
						var Ciudad_id_Familia = $('#Ciudad_id_Familia_'+j).val();

						if($.trim(Nombre_Familia) && $.trim(Apellido_familia)){
								$('#Cadena_Familia').val($('#Cadena_Familia').val()+'::'+id_Existente+'-'+Parentesco_F+'-'+Nombre_Familia+'-'+Apellido_familia+'-'+Ocupacion_F+'-'+NivelEdu_F+'-'+TelefonoFami+'-'+Ciudad_id_Familia+'-'+j)	
							}
					/***************************************************/	
					}
				var Familia = $('#Cadena_Familia').val();	
				
				
				var id_CiudadOrigen = $('#id_CiudadOrigen').val();
				
                if($('#No_Extranjero').is(':checked')){
                    var Es_Extranjero = 0;
                }else if($('#Si_Extranjero').is(':checked')){
                    var Es_Extranjero = 1;   
                }
			/***************************************************/
			
			/*************************************************/
				$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'Save_TabUno',Nombre:Nombre,
					   								  Apellidos:Apellidos,
													  TipoDocumento:TipoDocumento,
													  Num_Documento:Num_Documento,
													  Expedida_Doc:Expedida_Doc,
                                                      FechaDocu:FechaDocu,
													  Genero:Genero,
													  EstadiCivil:EstadiCivil,
													  Estrato:Estrato,
													  LibretaMilitar:LibretaMilitar,
													  Distrito:Distrito,
													  ExpedidaLibreta:ExpedidaLibreta,
													  Ciuda_Naci:Ciuda_Naci,
													  FechaNaci:FechaNaci,
													  Dir_recidente:Dir_recidente,
													  Tel_Recidente:Tel_Recidente,
													  id_CiudadResid:id_CiudadResid,
													  EmailBosque:EmailBosque,
													  Email_2:Email_2,
													  Nombre_Emerg:Nombre_Emerg,
													  Parentesco:Parentesco,
													  Telefono1_Parent:Telefono1_Parent,
													  Telefono1_Parent2:Telefono1_Parent2,
													  Eps:Eps,
													  Tipo_Eps:Tipo_Eps,
													  Familia:Familia,
													  id_Estudiante:id_Estudiante,
													  id_CiudadOrigen:id_CiudadOrigen,
                                                      Es_Extranjero:Es_Extranjero,
                                                      TipoSanguineo:TipoSanguineo,
                                                      GrupoEtnico:GrupoEtnico
                                                      }),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{
												var Ultimos_id = data.Ultimos_id;
												
												var D_ultimoid = Ultimos_id.split('::');
												
												var Num = D_ultimoid.length;
												
												for(t=1;t<Num;t++){
														
														var Detalle_id = D_ultimoid[t].split('-');
														
														$('#id_RegistroFami_'+Detalle_id[1]).val(Detalle_id[0]);
													
													}
											}
					   } 
				}); //AJAX
			/*************************************************/
			
		}
		/**************************InformacionGeneral*************************************/
	    /**************************InformacionAcademica*************************************/
		
		if(ind==2){
			
			/*****************************************/
				var Si_Participa = '';
				var Guardar  = true;
			/*****************************************/
			
			if($('#Si_Participa').is(':checked')){
				/*****************************************/
					var Si_Participa = 0;//SI Participa Cero 0
					var Guardar  = true;
				/*****************************************/
				}
			if($('#No_Participa').is(':checked')){
				/*****************************************/
					var Si_Participa         = 1;//NO Participa Uno 1
					var Semillero_inv        = 1;
					var Repre_Colegio        = 1;
					var Parti_Semillero      = 1;
					var Otra_Participacion   = 1;
					var Part_Congreso        = 1;
					var Intercambio          = 1;
					var Ninguna              = 1;
					var Cual_Participacion   = '';
					var Guardar  = true;
				/*****************************************/
				}	
			if($('#Semillero_inv').is(':checked')){
				/*****************************************/
					var Semillero_inv = 0;//
				/*****************************************/
				}else{
					/*****************************************/
						var Semillero_inv = 1;//
					/*****************************************/
					}
					
			if($('#Repre_Colegio').is(':checked')){
					/****************************************/
						var Repre_Colegio = 0;
					/****************************************/
				}else{
						/****************************************/
							var Repre_Colegio = 1;
						/****************************************/
					}
					
			if($('#Parti_Semillero').is(':checked')){
					/****************************************/
						var Parti_Semillero = 0;
					/****************************************/
				}else{
						/****************************************/
							var Parti_Semillero = 1;
						/****************************************/
					}
					
			if($('#Otra_Participacion').is(':checked')){
					/****************************************/
						var Otra_Participacion = 0;
						
						var Cual_Participacion = $('#Cual_Participacion').val();
					/****************************************/
				}else{
						/****************************************/
							var Otra_Participacion = 1;
							var Cual_Participacion = '';
						/****************************************/
					}
					
			if($('#Part_Congreso').is(':checked')){
					/****************************************/
						var Part_Congreso = 0;
					/****************************************/
				}else{
						/****************************************/
							var Part_Congreso = 1;
						/****************************************/
					}
					
			if($('#Intercambio').is(':checked')){
					/****************************************/
						var Intercambio = 0;
					/****************************************/
				}else{
						/****************************************/
							var Intercambio = 1;
						/****************************************/
					}	
			if($('#Ninguna').is(':checked')){
					/****************************************/
						var Ninguna = 0;
					/****************************************/
				}else{
						/****************************************/
							var Ninguna = 1;
						/****************************************/
					}										
							
					
		/******************************************************************************************************************/
		
		
		var Si_Logros  = '';
		
		if($('#Si_Logros').is(':checked')){
				/*******************************************/
					var Si_Logros = 0;
					var Guardar  = true;
				/*******************************************/	
			}
		if($('#No_Logros').is(':checked')){
				/************************************************/
					var Si_Logros           = 1;
					var GradoMeritorio      = 1;
					var MencionAcad         = 1;
					var mencionActvExt      = 1;
					var Becas               = 1;
					var Ninguna_Logro       = 1;
					var Otro_Logro          = 1;
					var Cual_Logro          = '';
					var Guardar  = true;
				/*************************************************/	
			}	
		
		if($('#GradoMeritorio').is(':checked')){
				/********************************************************/
					var GradoMeritorio = 0;
				/********************************************************/
			}else{
					/********************************************************/
						var GradoMeritorio = 1;
					/********************************************************/
				}
		
		if($('#MencionAcad').is(':checked')){
				/********************************************************/
					var MencionAcad = 0;
				/********************************************************/
			}else{
					/********************************************************/
						var MencionAcad = 1;
					/********************************************************/
				}
				
		if($('#mencionActv').is(':checked')){
				/********************************************************/
					var mencionActvExt = 0;
				/********************************************************/
			}else{
					/********************************************************/
						var mencionActvExt = 1;
					/********************************************************/
				}
				
		if($('#Becas').is(':checked')){
				/********************************************************/
					var Becas = 0;
				/********************************************************/
			}else{
					/********************************************************/
						var Becas = 1;
					/********************************************************/
				}
		
		if($('#Ninguna_Logro').is(':checked')){
				/********************************************************/
					var Ninguna_Logro = 0;
				/********************************************************/
			}else{
					/********************************************************/
						var Ninguna_Logro = 1;
					/********************************************************/
				}
				
		if($('#Otro_Logro').is(':checked')){
				/********************************************************/
					var Otro_Logro = 0;
					var Cual_Logro = $('#Cual_Logro').val();
				/********************************************************/
			}else{
					/********************************************************/
						var Otro_Logro = 1;
						var Cual_Logro = '';
					/********************************************************/
				}										
		
		/******************************************************************************************************************/
			var Nivel_Secundaria = $('#Nivel_Secundaria').val();
			var Id_nivelSecundaria  = $('#Id_nivelSecundaria').val();
			
					
			if($('#Otro_Colegio').is(':checked')){
					
					var Institucion  = $('#Institucion').val();
					
					if(!$.trim(Institucion)){
							/*alert('Ingrese El Nombre de la Institucion O Colegio...');
							return false;*/
						}
					var Id_Colegio  = 1;
					
					
				}else{
						var Institucion  = '';
						var Id_Colegio   = $('#Id_Colegio').val();
						
						
						if(!$.trim(Id_Colegio)){
							/*alert('Ingrese El Nombre de la Institucion O Colegio...');
							return false;*/
						}
						
					}
			
			var id_TituloColegio = $('#id_TituloColegio').val();// Agustar cuando este con el auto completar y el Check
			
			var	Ciudad_Cole   = $('#Ciudad_Cole').val();
			var Pertenece_Cundi  = '';
			if($('#Si_Colegio').is(':checked')){
					var Pertenece_Cundi = 'Si';
				}
			if($('#No_Colegio').is(':checked')){
					var Pertenece_Cundi = 'No';
				}	
		
			if($('#Si_Colegio').is(':checked')===false && $('#No_Colegio').is(':checked')===false){
					/*alert('Selecione Una de las Opciones de la Pregunta \n Colegio pertenece al Departamento de Cundinamarca y es publico');
					return false;*/
				}
			var YearCole  = $('#YearCole').val();	
			
			if(!$.trim(YearCole)){
					/*alert('Ingrese el A\u00f1o en que termino el Colegio...');
					return false;*/
				}
			var Observacion = $('#Observacion').val();	
			
			/*********************************************Ajax************************************************************/
		
		var id_registroLogros  = $('#id_registroLogros').val();
		var id_RegistroNewActividad  = $('#id_RegistroNewActividad').val();
		var id_ColegioSave  = $('#id_ColegioSave').val();
		
		
		
				$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'SaveTabDos',Si_Participa:Si_Participa,
					   								 Semillero_inv:Semillero_inv,
													 Repre_Colegio:Repre_Colegio,
													 Parti_Semillero:Parti_Semillero,
													 Otra_Participacion:Otra_Participacion,
													 Part_Congreso:Part_Congreso,
													 Intercambio:Intercambio,
													 Ninguna:Ninguna,
													 Cual_Participacion:Cual_Participacion,
													 Si_Logros:Si_Logros,
													 GradoMeritorio:GradoMeritorio,
													 MencionAcad:MencionAcad,
													 mencionActvExt:mencionActvExt,
													 Becas:Becas,
													 Ninguna_Logro:Ninguna_Logro,
													 Otro_Logro:Otro_Logro,
													 Cual_Logro:Cual_Logro,
													 Nivel_Secundaria:Nivel_Secundaria,
													 Id_nivelSecundaria:Id_nivelSecundaria,
													 Institucion:Institucion,
													 Id_Colegio:Id_Colegio,
													 id_TituloColegio:id_TituloColegio,
													 Ciudad_Cole:Ciudad_Cole,
													 Pertenece_Cundi:Pertenece_Cundi,
													 YearCole:YearCole,
													 Observacion:Observacion,
													 id_Estudiante:id_Estudiante,
													 Guardar:Guardar,
													 id_registroLogros:id_registroLogros,
													 id_RegistroNewActividad:id_RegistroNewActividad,
													 id_ColegioSave:id_ColegioSave}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{
													$('#id_registroLogros').val(data.Last_idLogros);
													$('#id_RegistroNewActividad').val(data.Last_idParticipa); 
											}
					   } 
				}); //AJAX
		
	
		/********************************************Fin Ajax*************************************************************/
			
			
			
			
		}
		
		
		
		/**************************InformacionAcademica*************************************/
		/**************************InformacionAdicional*************************************/
		if(ind==3){
			var IndexPadre  = $('#IndexPadre').val();
			
			$('#Cadena_Medios').val('');
			
			for(P=0;P<IndexPadre;P++){
					var IndexHijo  = $('#IndexHijo_'+P).val();
					
					for(H=0;H<IndexHijo;H++){
						
							if($('#Medio_'+P+'_'+H).is(':checked')){
									var id_medio  = $('#Medio_'+P+'_'+H).val();
									
									var Descrip   = $('#Descrip_'+id_medio).val();
									
									var id_EstudioanteMedio = $('#id_EstudioanteMedio_'+id_medio).val();
									
									$('#Cadena_Medios').val($('#Cadena_Medios').val()+'::'+id_medio+'-'+Descrip+'-'+id_EstudioanteMedio);
								}
						
						}
					
				}
		
			var Cadena_Medios   =  $('#Cadena_Medios').val();
			
			var IndexRecursoFinaciero  = $('#IndexRecursoFinaciero').val();
			
			$('#CadenaRecursoFianciero').val('');
			
			for(t=0;t<IndexRecursoFinaciero;t++){
					
					if($('#Recuso_id_'+t).is(':checked')){
							
							var Recuso_id = $('#Recuso_id_'+t).val();
							var id_RecursoEstudiante  = $('#id_RecursoEstudiante_'+Recuso_id).val();
							
							$('#CadenaRecursoFianciero').val($('#CadenaRecursoFianciero').val()+'::'+Recuso_id+'-'+id_RecursoEstudiante);
							
						}
						
				}
			
			
			var CadenaRecursoFianciero = $('#CadenaRecursoFianciero').val();
			var ComentariosRecursos  = $('#ComentariosRecursos').val();
			
			/******************************************************************************AJAX*******************************************************************************************************************/
					
					$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'SaveTabTres',CadenaRecursoFianciero:CadenaRecursoFianciero,
					   								  ComentariosRecursos:ComentariosRecursos,
													  id_Estudiante:id_Estudiante,
													  Cadena_Medios:Cadena_Medios}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{
												
											//	var MediosLast      = data.MediosLast;
//												
//												
//												/******************************************/
//													var C_MediosLast  = MediosLast.split('::');
//													
//													var Num_Medios  = C_MediosLast.length;
//												
//														for(X=1;X<Num_Medios;X++){
//																
//																var C_DetalleMedio = C_MediosLast[X].split('-');
//																
//																/*
//																	C_DetalleMedio[0]= id_medio
//																	C_DetalleMedio[1]= Ultimo_id
//																*/
//																
//																$('#id_EstudioanteMedio_'+C_DetalleMedio[0]).val(C_DetalleMedio[1]);
//																
//															}
												/******************************************/
												
												
												var FinacieraLast	  = data.FinacieraLast;
												
												/******************************************/
													var C_Fianciera    = FinacieraLast.split('::');
													
													var Num_Finan      = C_Fianciera.length;
													
														for(N=1;N<Num_Finan;N++){
															
																var C_DetalleFinan  = C_Fianciera[N].split('-');
																
																/*
																	C_DetalleFinan[0]=id recurso
																	C_DetalleFinan[1]=Ultimo id
																*/
																
																
																$('#id_RecursoEstudiante_'+C_DetalleFinan[0]).val(C_DetalleFinan[1]);
															
															}
													
												/******************************************/
													
											}
					   } 
				}); //AJAX
			
			/**********************************************************************Fin AJAX************************************************************************************************************************/
			
			
		}
		/**************************InformacionAdicional*************************************/	
		/**************************InformacionPersonal*************************************/
			if(ind==4){//-->Ninico Ind==4
				/************************************************/
				var GuardarSave = 1;
				
				if(!$.trim($('#id_SaveCondicionSalud').val())){//-->id_SaveCondicionSalud
					/************************SaveCondicionSalud********************************/
					
					if($('#Enfermeda_Si').is(':checked')){
						
						var GuardarSave = 0;
						/************************************************/
								var Enfermeda_Si 				 = 0;	
								var Enf_Endroquina 				 = $('#Enf_Endroquina').val();	
								var DesordenMental 				 = $('#DesordenMental').val();	
								var Enf_Circulatorio 			 = $('#Enf_Circulatorio').val();
								var Enf_Respiratorio			 = $('#Enf_Respiratorio').val();
								var Enf_Locomotor 				 = $('#Enf_Locomotor').val();		
								var Enf_Malformaciones  		 = $('#Enf_Malformaciones').val();
								var Enf_Otras  					 = $('#Enf_Otras').val();
						/************************************************/
						}else{
							
							/************************************************/
								var Enfermeda_Si = 1;	
								var Enf_Endroquina 				 = '';	
								var DesordenMental 				 = '';
								var Enf_Circulatorio 			 = '';
								var Enf_Respiratorio			 = '';
								var Enf_Locomotor 				 = '';		
								var Enf_Malformaciones  		 = '';
								var Enf_Otras  					 = '';				
							/************************************************/
							}
					
					if($('#Alegia_Si').is(':checked')){
						var GuardarSave = 0;
						/*************************************************/
							var Alegia       = 0;
							var Cual_Alergia = $('#Cual_Alergia').val();
						/*************************************************/	
						}else{
						
							/*************************************************/
								var Alegia       = 1;
								var Cual_Alergia = '';
							/*************************************************/
							}
							
					if($('#UsoMed_Si').is(':checked')){
						var GuardarSave = 0;
						/*************************************************/
							var UsoMedicamentos = 0;
							var Cual_UsoMed     = $('#Cual_UsoMed').val();
						/*************************************************/
						}else{
						
							/*************************************************/
								var UsoMedicamentos = 1;
								var Cual_UsoMed     = '';
							/*************************************************/
							}	
							
					if($('#Trastorno_Si').is(':checked')){
						var GuardarSave = 0;
						/*************************************************/
							var Trastorno    = 0;
							/*
							1=Anorexia
							2=Bulimia
							3=Obesidad
							4=Otra
							*/
							if($('#Anorexia').is(':checked')){
									var Anorexia = 1;
									var TrastornoText    = '';
								}else{
									var Anorexia = 0;
									var TrastornoText    = '';
									}
							if($('#Bulimia').is(':checked')){
									var Bulimia = 2;
									var TrastornoText    = '';
								}else{
									var Bulimia = 0;
									var TrastornoText    = '';
									}
							if($('#Obesidad').is(':checked')){
									var Obesidad = 3;
									var TrastornoText    = '';
								}else{
									var Obesidad = 0;
									var TrastornoText    = '';
									}	
							if($('#Otra_Trastorno').is(':checked')){
									var Otra_Trastorno = 4;
									var TrastornoText    = $('#TrastornoText').val();
								}else{
									var Otra_Trastorno = 0;
									var TrastornoText    = '';
									}						
						/*************************************************/
						}else{
							
							var Trastorno    = 1;
							/*************************************************/
								var Anorexia = 0;
								var Bulimia = 0;
								var Obesidad = 0;
								var Otra_Trastorno = 0;
								var Cual_UsoMed    = '';
							/*************************************************/	
							}	
							
					if($('#Si_discapacidad').is(':checked')){
						var GuardarSave = 0;
						/*************************************************/
						var Discapacidad = 0;
							/*
							Fisica
								1= Dificultad para la locomoción
								2=Anomalía o Ausencia en Estremidades Inferiores
								3=Anomalía o Ausencia enEestremidades Superiores
								4=Paralisis
							*/
							if($('#locomocion').is(':checked')){
									var locomocion  = 1;
								}else{
										var locomocion = 0;
									}
							if($('#inferior').is(':checked')){
									var inferior  = 2;
								}else{
										var inferior = 0;
									}
							if($('#Superior').is(':checked')){
									var Superior  = 3;
								}else{
										var Superior = 0;
									}
							if($('#Paralisis').is(':checked')){
									var Paralisis  = 4;
								}else{
										var Paralisis = 0;
									}
							/*
							Sensorial
								1=Deficiencia Visual
								2=Deficiencia Auditiva
								3= Deficiencia en el Habla
							*/		
							if($('#Visual').is(':checked')){
									var Visual = 1;
								}else{
										var Visual = 0;
									}
							if($('#Auditiva').is(':checked')){
									var Auditiva = 2;
								}else{
										var Auditiva = 0;
									}	
							if($('#Habla').is(':checked')){
									var Habla = 3;
								}else{
										var Habla = 0;
									}
							var ObservacionCondicionDiscapacidad = $('#ObservacionCondicionDiscapacidad').val();														
						/*************************************************/	
						}else{
							
							var Discapacidad = 1;
							/*************************************************/	
								var locomocion = 0;
								var inferior = 0;
								var Superior = 0;
								var Paralisis = 0;
								var Visual = 0;
								var Auditiva = 0;
								var Habla = 0;
								var ObservacionCondicionDiscapacidad = '';
							/*************************************************/	
							}			
					
					/************************SaveCondicionSalud********************************/
					}//-->id_SaveCondicionSalud
				
				/*********************Vacunas***************************/
					/*
					1=Sarampión
					2=Rubeola
					3=Tetano
					4=Hepatitis B -> re4laciona con dosis 
					5=Virus del Papiloma Humano VPH->relaciona con dosis	
					
					*/
					
				if(!$.trim($('#id_VacunasSarampion').val())){//-->id_VacunasSarampion
							
					if($('#Sarampion').is(':checked')){
						
						var GuardarSave = 0;
							var Sarampion  = 1;
							var Hepati_Dosis = '';
							var VPH_Dosis = '';
								
						}else{
							
								var Sarampion  = 0;
								var Hepati_Dosis = '';
								var VPH_Dosis = '';	
								
							}
							
				}//-->id_VacunasSarampion
				
				if(!$.trim($('#id_VacunasRubeola').val())){//id_VacunasRubeola
					
					if($('#Rubeola').is(':checked')){
						var GuardarSave = 0;
							var Rubeola  = 2;
							var Hepati_Dosis = '';
							var VPH_Dosis = '';	
						}else{
								var Rubeola  = 0;
								var Hepati_Dosis = '';
								var VPH_Dosis = '';	
							}
					
					}
				
				if(!$.trim($('#id_VacunasTetano').val())){
						
					if($('#Tetano').is(':checked')){
						var GuardarSave = 0;
							var Tetano  = 3;
							var Hepati_Dosis = '';
							var VPH_Dosis = '';	
						}else{
							var Tetano  = 0;
							var Hepati_Dosis = '';
							var VPH_Dosis = '';	
							}
				}
				
				
				if(!$.trim($('#id_VacunasHepatitisB').val())){
						
					if($('#Hepatitis_B').is(':checked')){
						var GuardarSave = 0;
							var Hepatitis_B  = 4;
							
							if($('#Hepati_B_Uno').is(':checked')){
									var Hepati_Dosis = 1;	
								}
							if($('#Hepati_B_Dos').is(':checked')){
									var Hepati_Dosis = 2;	
								}
							if($('#Hepati_B_Tres').is(':checked')){
									var Hepati_Dosis = 3;	
								}		
						}else{
								var Hepatitis_B  = 0;
								var Hepati_Dosis = 0;
							}
							
				}
				
				if(!$.trim($('#id_VacunasVPH').val())){
							
					if($('#VPH').is(':checked')){
						var GuardarSave = 0;
							var VPH  = 5;
							
							if($('#VPH_Uno').is(':checked')){
									var VPH_Dosis = 1;	
								}
							if($('#VPH_Dos').is(':checked')){
									var VPH_Dosis = 2;	
								}
							if($('#VPH_Tres').is(':checked')){
									var VPH_Dosis = 3;	
								}		
						}else{
								var VPH  = 0;
								var VPH_Dosis =0;
							}
							
				}
				/*******************Habitos Saludables*****************************/
				
				if(!$.trim($('#id_HabitosSaludables').val())){
					
					
					if($('#Si_Vegetales').is(':checked')){
						var GuardarSave = 0;
							var Vegetariano = 0;
						}else{
							
								var Vegetariano = 1;
							}
					
					if($('#Si_Cigarrillo').is(':checked')){
						var GuardarSave = 0;
							var Fuma = 0;
							/*
								1=Menos de 1 al día
								2=Entre 1 y 2 al día
								3=Entre 3 y 6 al día
								4=Entre 7 y 10 día
								5=Mas de 11 al día
							*/
							if($('#C_uno').is(':checked')){
									var Frecuencia_fuma = 1;
								}
							if($('#C_dos').is(':checked')){
									var Frecuencia_fuma = 2;
								}
							if($('#C_tres').is(':checked')){
									var Frecuencia_fuma = 3;
								}
							if($('#C_Cuatro').is(':checked')){
									var Frecuencia_fuma = 4;
								}
							if($('#C_cinco').is(':checked')){
									var Frecuencia_fuma = 5;
								}				
							
						}else{
							
								var Fuma = 1;
								var Frecuencia_fuma = '';
							}		
							
					if($('#Si_Alcohol').is(':checked')){
						var GuardarSave = 0;
							var Alcohol = 0;
							/*
								1=Menos de 1 vez a la semana
								2=1 vez a la semana
								3=Entre 2 y 3 veces a la semana 
								4=Entre 4 y 5 veces a la semana
								5=Más de 6 veces a la semana
							*/
							if($('#Alcohol_uno').is(':checked')){
									var Frecuencia_Alcohol = 1;
								}
							if($('#Alcohol_dos').is(':checked')){
									var Frecuencia_Alcohol = 2;
								}
							if($('#Alcohol_tres').is(':checked')){
									var Frecuencia_Alcohol = 3;
								}
							if($('#Alcohol_Cuatro').is(':checked')){
									var Frecuencia_Alcohol = 4;
								}
							if($('#Alcohol_cinco').is(':checked')){
									var Frecuencia_Alcohol = 5;
								}				
							
						}else{
							
							
								var Alcohol = 1;
								var Frecuencia_Alcohol = '';
							}			
					
					}
				
						
				
				/********************Actividad Fisica****************************/
				
				if(!$.trim($('#ActividaFisica_id').val())){
					
					if($('#Si_Act_Fisica').is(':checked')){
						var GuardarSave = 0;
							var Act_Fisica  = 0;
							
							var Act_FisicaCual  = $('#Act_FisicaCual').val();
							
							/*
								1= 1 vez a la semana
								2=3 veces a la semana
								3=Más de 3 veces a la semana
							*/
							
							if($('#Frec_uno').is(':checked')){
									var Fre_ActFisica = 1;
								}
							if($('#Frec_dos').is(':checked')){
									var Fre_ActFisica = 2;
								}
							if($('#Frec_tres').is(':checked')){
									var Fre_ActFisica = 3;
								}		
							
						}else{
							
								
								var Act_Fisica  = 1;
								var Act_FisicaCual  ='';
								var Fre_ActFisica = '';
							}
					
				if($('#Si_Pertenece').is(':checked')){
					
						var GuardarSave = 0;
							var PerteneceRed = 0;
							var Pertenece_Cual = $('#Pertenece_Cual').val();
						}else{
							
								var PerteneceRed = 1;
								var Pertenece_Cual ='';
							}
				/************************************************/
					if($('#Si_Voluntariado').is(':checked')){
						
						var GuardarSave = 0;
							var Voluntariado  = 0;
							var Voluntariado_Cual = $('#Voluntariado_Cual').val();
							
						}else{
							
								
								var Voluntariado  = 1;
								var Voluntariado_Cual = '';
							}
							
				/************************************************/	
					}
					
				
				
				/******************Practica Deporte******************************/
				
				if(!$.trim($('#No_Deporte_id').val())){
				
					if($('#Si_Practica').is(':checked')){
						var GuardarSave = 0;
							var PracticaDepor = 0;
							/************************************************/
								//var Practica_Text   = $('#Practica_Dep').val(); 
								/*
									1=Fútbol
									2=Fútbol Sala
									3=Basketball
									4=Voleibol
									5=Rugby
									6=Tennis de Mesa
									7=Tennis
									8=Ciclismo
									9=Natación
									10=Atletismo
									11=Beisbol
									12=Ajedrez
									13=Squash
									14=Taekwondo
									15=Otro

								*/
								
							if(!$.trim($('#Futbol_id').val())){//->Futbol_id
								
								if($('#Futbol').is(':checked')){
										var  Futbol = 	1;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_F_Uno').is(':checked')){
													var Frecuencia_Futbol  = 1;
												}
											if($('#Fr_F_Dos').is(':checked')){
													var Frecuencia_Futbol  = 2;
												}
											if($('#Fr_F_Tres').is(':checked')){
													var Frecuencia_Futbol  = 3;
												}		
										/************************************************/
									}else{
										
											var Futbol = 0;
											var Otro_deporte = '';
											var Frecuencia_Futbol  = 0;
										}
							}//->Futbol_id
							
							if(!$.trim($('#Sala_id').val())){//-->Sala_id
								
								if($('#F_sala').is(':checked')){
									
										var  F_sala = 	2;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_FS_Uno').is(':checked')){
													var Frecuencia_F_sala  = 1;
												}
											if($('#Fr_FS_Dos').is(':checked')){
													var Frecuencia_F_sala  = 2;
												}
											if($('#Fr_FS_Tres').is(':checked')){
													var Frecuencia_F_sala  = 3;
												}		
										/************************************************/
									}else{
											var F_sala = 0;
											var Otro_deporte = '';
											var Frecuencia_F_sala  = 0;
										}
										
							}//-->Sala_id
							
							if(!$.trim($('#Basketball_id').val())){//-->Basketball_id
										
								if($('#Basketball').is(':checked')){
										var Basketball  = 	3;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Bsk_Uno').is(':checked')){
													var Frecuencia_Basketball  = 1;
												}
											if($('#Fr_Bsk_Dos').is(':checked')){
													var Frecuencia_Basketball  = 2;
												}
											if($('#Fr_Bsk_Tres').is(':checked')){
													var Frecuencia_Basketball  = 3;
												}		
										/************************************************/
									}else{
											var Basketball = 0;
											var Otro_deporte = '';
											var Frecuencia_Basketball  = 0;
										}
										
							}//-->Basketball_id
							
							if(!$.trim($('#Voleibol_id').val())){//-->Voleibol_id
										
								if($('#Voleibol').is(':checked')){
										var Voleibol = 	4;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Vol_Uno').is(':checked')){
													var Frecuencia_Voleibol  = 1;
												}
											if($('#Fr_Vol_Dos').is(':checked')){
													var Frecuencia_Voleibol  = 2;
												}
											if($('#Fr_Vol_Tres').is(':checked')){
													var Frecuencia_Voleibol  = 3;
												}		
										/************************************************/
									}else{
											var Voleibol = 0;
											var Otro_deporte = '';
											var Frecuencia_Voleibol  = 0;
										}
										
							}//-->Voleibol_id
										
							if(!$.trim($('#Rugby_id').val())){//-->Rugby_id
							
								if($('#Rugby').is(':checked')){
										var Rugby = 	5;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Rby_Uno').is(':checked')){
													var Frecuencia_Rugby  = 1;
												}
											if($('#Fr_Rby_Dos').is(':checked')){
													var Frecuencia_Rugby  = 2;
												}
											if($('#Fr_Rby_Tres').is(':checked')){
													var Frecuencia_Rugby  = 3;
												}		
										/************************************************/
									}else{
											var Rugby = 0;
											var Otro_deporte = '';
											var Frecuencia_Rugby  = 0;
										}
										
							}//-->Rugby_id
										
							if(!$.trim($('#T_mesa_id').val())){//-->T_mesa_id
							
								if($('#T_mesa').is(':checked')){
										var  T_mesa = 	6;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_TMesa_Uno').is(':checked')){
													var Frecuencia_T_mesa  = 1;
												}
											if($('#Fr_TMesa_Dos').is(':checked')){
													var Frecuencia_T_mesa  = 2;
												}
											if($('#Fr_TMesa_Tres').is(':checked')){
													var Frecuencia_T_mesa  = 3;
												}		
										/************************************************/
									}else{
											var T_mesa = 0;
											var Otro_deporte = '';
											var Frecuencia_T_mesa  = 0;
										}
										
							}//-->T_mesa_id
							
							if(!$.trim($('#Tennis_id').val())){//--->Tennis_id
										
								if($('#Tennis').is(':checked')){
										var Tennis = 	7;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Tennis_Uno').is(':checked')){
													var Frecuencia_Tennis  = 1;
												}
											if($('#Fr_Tennis_Dos').is(':checked')){
													var Frecuencia_Tennis  = 2;
												}
											if($('#Fr_Tennis_Tres').is(':checked')){
													var Frecuencia_Tennis  = 3;
												}		
										/************************************************/
									}else{
											var Tennis = 0;
											var Otro_deporte = '';
											var Frecuencia_Tennis  = 0;
										}
										
										
							}//-->Tennis_id
							
							if(!$.trim($('#Ciclismo_id').val())){//-->Ciclismo_id
							
								if($('#Ciclismo').is(':checked')){
										var Ciclismo = 	8;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Cic_Uno').is(':checked')){
													var Frecuencia_Ciclismo  = 1;
												}
											if($('#Fr_Cic_Dos').is(':checked')){
													var Frecuencia_Ciclismo  = 2;
												}
											if($('#Fr_Cic_Tres').is(':checked')){
													var Frecuencia_Ciclismo  = 3;
												}		
										/************************************************/
									}else{
											var Ciclismo = 0;
											var Otro_deporte = '';
											var Frecuencia_Ciclismo  = 0;
										}
							
							}//-->Ciclismo_id
							
							if(!$.trim($('#Natacion_id').val())){//-->Natacion_id
										
								if($('#Natacion').is(':checked')){
										var Natacion = 	9;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Nata_Uno').is(':checked')){
													var Frecuencia_Natacion  = 1;
												}
											if($('#Fr_Nata_Dos').is(':checked')){
													var Frecuencia_Natacion  = 2;
												}
											if($('#Fr_Nata_Tres').is(':checked')){
													var Frecuencia_Natacion  = 3;
												}		
										/************************************************/
									}else{
											var Natacion = 0;
											var Otro_deporte = '';
											var Frecuencia_Natacion  = 0;
										}
										
							}//-->Natacion_id
							
							if(!$.trim($('#Atletismo_id').val())){//-->Atletismo_id
										
								if($('#Atletismo').is(':checked')){
										var Atletismo = 	10;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Atl_Uno').is(':checked')){
													var Frecuencia_Atletismo  = 1;
												}
											if($('#Fr_Atl_Dos').is(':checked')){
													var Frecuencia_Atletismo  = 2;
												}
											if($('#Fr_Atl_Tres').is(':checked')){
													var Frecuencia_Atletismo  = 3;
												}		
										/************************************************/
									}else{
											var Atletismo = 0;
											var Otro_deporte = '';
											var Frecuencia_Atletismo  = 0;
										}
										
							}//-->Atletismo_id
										
							if(!$.trim($('#Beisbol_id').val())){//-->Beisbol_id		
										
								if($('#Beisbol').is(':checked')){
										var Beisbol = 	11;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Bes_Uno').is(':checked')){
													var Frecuencia_Beisbol  = 1;
												}
											if($('#Fr_Bes_Dos').is(':checked')){
													var Frecuencia_Beisbol  = 2;
												}
											if($('#Fr_Bes_Tres').is(':checked')){
													var Frecuencia_Beisbol  = 3;
												}		
										/************************************************/
									}else{
											var Beisbol = 0;
											var Otro_deporte = '';
											var Frecuencia_Beisbol  = 0;
										}
										
							}//-->Beisbol_id
							
							if(!$.trim($('#Ajedrez_id').val())){//-->Ajedrez_id
										
								if($('#Ajedrez').is(':checked')){
										var Ajedrez = 	12;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Ajd_Uno').is(':checked')){
													var Frecuencia_Ajedrez  = 1;
												}
											if($('#Fr_Ajd_Dos').is(':checked')){
													var Frecuencia_Ajedrez  = 2;
												}
											if($('#Fr_Ajd_Tres').is(':checked')){
													var Frecuencia_Ajedrez  = 3;
												}		
										/************************************************/
									}else{
											var Ajedrez = 0;
											var Otro_deporte = '';
											var Frecuencia_Ajedrez  = 0;
										}
										
							}//-->Ajedrez_id
							
							if(!$.trim($('#Squash_id').val())){//-->Squash_id
										
								if($('#Squash').is(':checked')){
										var Squash = 	13;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Sqh_Uno').is(':checked')){
													var Frecuencia_Squash  = 1;
												}
											if($('#Fr_Sqh_Dos').is(':checked')){
													var Frecuencia_Squash  = 2;
												}
											if($('#Fr_Sqh_Tres').is(':checked')){
													var Frecuencia_Squash  = 3;
												}		
										/************************************************/
									}else{
											var Squash = 0;
											var Otro_deporte = '';
											var Frecuencia_Squash  = 0;
										}
										
							}//-->Squash_id
							
							if(!$.trim($('#Taekwondo_id').val())){//-->Taekwondo_id
										
								if($('#Taekwondo').is(':checked')){
										var Taekwondo = 	14;
										var Otro_deporte = '';
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_Tkw_Uno').is(':checked')){
													var Frecuencia_Taekwondo  = 1;
												}
											if($('#Fr_Tkw_Dos').is(':checked')){
													var Frecuencia_Taekwondo  = 2;
												}
											if($('#Fr_Tkw_Tres').is(':checked')){
													var Frecuencia_Taekwondo  = 3;
												}		
										/************************************************/
									}else{
											var Taekwondo = 0;
											var Otro_deporte = '';
											var Frecuencia_Taekwondo  = 0;
										}
										
							}//-->Taekwondo_id
							
							
							if(!$.trim($('#OtroDeporte_id').val())){//-->OtroDeporte_id
										
								if($('#OtroPractica').is(':checked')){
										var OtroPractica = 	15;
										var Otro_deporte = $('#Otro_deporte').val();
										/************************************************/
											
											/*
												1=1 vez a la semana
												2=3 veces a la semana
												3=Más de 3 veces a la semana
											*/
										    if($('#Fr_OtroDep_Uno').is(':checked')){
													var Frecuencia_OtroPractica  = 1;
												}
											if($('#Fr_OtroDep_Dos').is(':checked')){
													var Frecuencia_OtroPractica  = 2;
												}
											if($('#Fr_OtroDep_Tres').is(':checked')){
													var Frecuencia_OtroPractica  = 3;
												}		
										/************************************************/
									}else{
											var OtroPractica = 0;
											var Otro_deporte = '';
											var Frecuencia_OtroPractica  = 0;
										}																												
							/************************************************/
							}//-->OtroDeporte_id
							
						}else{
								
								
								
								var PracticaDepor = 1;
								/************************************************/
									var Futbol                 = 0;
									var Frecuencia_Futbol 	   = 0;
									var F_sala 				   = 0;
									var Frecuencia_F_sala      = 0;
									var Basketball 			   = 0;
									var Frecuencia_Basketball  = 0;
									var Voleibol 			   = 0;
									var Frecuencia_Voleibol    = 0;
									var Rugby 				   = 0;
									var Frecuencia_Rugby 	   = 0;
									var T_mesa 				   = 0;
									var Frecuencia_T_mesa      = 0;	
									var Ciclismo 			   = 0;
									var Frecuencia_Ciclismo    = 0;
									var Natacion 			   = 0;
									var Frecuencia_Natacion    = 0;
									var Atletismo 			   = 0;
									var Frecuencia_Atletismo   = 0;
									var Beisbol 			   = 0;
									var Frecuencia_Beisbol     = 0;
									var Ajedrez 			   = 0;
									var Frecuencia_Ajedrez     = 0;	
									var Squash 				   = 0;
									var Frecuencia_Squash      = 0;	
									var Taekwondo 			   = 0;
									var Frecuencia_Taekwondo   = 0;	
									var OtroPractica 		   = 0;
									var Otro_deporte 		   = '';
									var Frecuencia_OtroPractica  = 0;
									var Tennis = 0;
									var Frecuencia_Tennis  = 0;						
								/************************************************/
							}
				}
				/************************************************/
				
				/**********************Musica**************************/
				
				if(!$.trim($('#No_Musica_id').val())){//-->No_Musica_id
				
					if($('#Si_musica').is(':checked')){
						var GuardarSave = 0;
							var musica  = 0;
							/*
								1=Guitarra
								2=Bateria
								3=Saxofon
								4=Trompeta
								5=Congas
								6=Acordeón
								7=Otro
							*/
							/************************************************/
							if(!$.trim($('#Guitarra_id').val())){//-->Guitarra_id
							
								if($('#Guitarra').is(':checked')){
										var Guitarra  = 1;
										var Cual_Instrumentio = '';
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_Gui_Uno').is(':checked')){
													var Nivel_Guitarra = 1;
												}
											if($('#Nv_Gui_Dos').is(':checked')){
													var Nivel_Guitarra = 2;
												}
											if($('#Nv_Gui_Tres').is(':checked')){
													var Nivel_Guitarra = 3;
												}		
										/************************************************/
									}else{
											var Guitarra = 0;
											var Cual_Instrumentio = '';
											var Nivel_Guitarra = 0;
										}
										
							}//-->Guitarra_id
							
							if(!$.trim($('#Bateria_id').val())){//-->Bateria_id
										
								if($('#Bateria').is(':checked')){
										var Bateria  = 2;
										var Cual_Instrumentio = '';
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_Bat_Uno').is(':checked')){
													var Nivel_Bateria = 1;
												}
											if($('#Nv_Bat_Dos').is(':checked')){
													var Nivel_Bateria = 2;
												}
											if($('#Nv_Bat_Tres').is(':checked')){
													var Nivel_Bateria = 3;
												}		
										/************************************************/
									}else{
											var Bateria = 0;
											var Cual_Instrumentio = '';
											var Nivel_Bateria = 0;
										}
										
							}//-->Bateria_id
									
							if(!$.trim($('#Saxofon_id').val())){//-->Saxofon_id		
										
								if($('#Saxofon').is(':checked')){
										var Saxofon  = 3;
										var Cual_Instrumentio = '';
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_Sax_Uno').is(':checked')){
													var Nivel_Saxofon = 1;
												}
											if($('#Nv_Sax_Dos').is(':checked')){
													var Nivel_Saxofon = 2;
												}
											if($('#Nv_Sax_Tres').is(':checked')){
													var Nivel_Saxofon = 3;
												}		
										/************************************************/
									}else{
											var Saxofon = 0;
											var Cual_Instrumentio = '';
											var Nivel_Saxofon = 0;
										}
										
							}//->Saxofon_id
										
							if(!$.trim($('#Trompeta_id').val())){//-->Trompeta_id		
										
								if($('#Trompeta').is(':checked')){
										var Trompeta  = 4;
										var Cual_Instrumentio = '';
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_Trop_Uno').is(':checked')){
													var Nivel_Trompeta = 1;
												}
											if($('#Nv_Trop_Dos').is(':checked')){
													var Nivel_Trompeta = 2;
												}
											if($('#Nv_Trop_Tres').is(':checked')){
													var Nivel_Trompeta = 3;
												}		
										/************************************************/
									}else{
											var Trompeta = 0;
											var Cual_Instrumentio = '';
											var Nivel_Trompeta = 0;
										}
										
							}//-->Trompeta_id
							
							if(!$.trim($('#Congas_id').val())){//-->Congas_id
										
										
								if($('#Congas').is(':checked')){
										var Congas  = 5;
										var Cual_Instrumentio = '';
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_Cong_Uno').is(':checked')){
													var Nivel_Congas = 1;
												}
											if($('#Nv_Cong_Dos').is(':checked')){
													var Nivel_Congas = 2;
												}
											if($('#Nv_Cong_Tres').is(':checked')){
													var Nivel_Congas = 3;
												}		
										/************************************************/
									}else{
											var Congas = 0;
											var Cual_Instrumentio = '';
											var Nivel_Congas = 0;
										}
										
							}//-->Congas_id

							
							if(!$.trim($('#Acordion_id').val())){//-->Acordion_id
										
								if($('#Acordion').is(':checked')){
										var Acordion  = 6;
										var Cual_Instrumentio = '';
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_Acord_Uno').is(':checked')){
													var Nivel_Acordion = 1;
												}
											if($('#Nv_Acord_Dos').is(':checked')){
													var Nivel_Acordion = 2;
												}
											if($('#Nv_Acord_Tres').is(':checked')){
													var Nivel_Acordion = 3;
												}		
										/************************************************/
									}else{
											var Acordion = 0;
											var Cual_Instrumentio = '';
											var Nivel_Acordion = 0;
										}
										
							}//-->Acordion_id
										
							if(!$.trim($('#OtraMusica_id').val())){//--->OtraMusica_id			
										
								if($('#Otro_Musica').is(':checked')){
										var Otro_Musica  = 7;
										var Cual_Instrumentio = $('#Cual_Instrumentio').val();
										/*
											1=Básico
											2=Medio
											3=Avanzado
										*/
										/************************************************/
											if($('#Nv_OtroMusica_Uno').is(':checked')){
													var Nivel_Otro_Musica = 1;
												}
											if($('#Nv_OtroMusica_Dos').is(':checked')){
													var Nivel_Otro_Musica = 2;
												}
											if($('#Nv_OtroMusica_Tres').is(':checked')){
													var Nivel_Otro_Musica = 3;
												}		
										/************************************************/
									}else{
											var Otro_Musica = 0;
											var Cual_Instrumentio = '';
											var Nivel_Otro_Musica = 0;
										}
										
							}//-->OtraMusica_id
							/************************************************/
						}else {
							
								
								var musica  = 1;
								/************************************************/
									var Guitarra 		  = 0;
									var Nivel_Guitarra 	  = 0;
									var Bateria 		  = 0;
									var Nivel_Bateria 	  = 0;
									var Saxofon 		  = 0;
									var Nivel_Saxofon 	  = 0;
									var Trompeta 		  = 0;
									var Nivel_Trompeta 	  = 0;
									var Congas 			  = 0;
									var Nivel_Congas	  = 0;
									var Acordion 		  = 0;
									var Nivel_Acordion 	  = 0;
									var Otro_Musica 	  = 0;
									var Cual_Instrumentio = '';
									var Nivel_Otro_Musica = 0;
								/************************************************/
							}
							
				}//-->No_Musica_id
				/*****************Exprecion Corporal*******************************/
				if(!$.trim($('#NoDanza_id').val())){//-->NoDanza_id
				
					if($('#Si_ExpCorporal').is(':checked')){
						var GuardarSave = 0;
							var ExpCorporal  = 0;
							/*
								1=Danza
								2=Danza Folclorica
								3=Danza Moderna
								4=Danza Contemporanea
								5=Ballet 
								6=Otro
							*/
								/************************************************/
								
								if(!$.trim($('#Danza_id').val())){//-->Danza_id
								
									if($('#Danza').is(':checked')){
											var Danza = 1;
											var Cual_Danzas = '';
											/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
												if($('#Nv_Danza_Uno').is(':checked')){
														var Nivel_Danza  = 1;
													}
												if($('#Nv_Danza_Dos').is(':checked')){
														var Nivel_Danza  = 2;
													}
												if($('#Nv_Danza_Tres').is(':checked')){
														var Nivel_Danza  = 3;
													}		
											/************************************************/
										}else{
												var Danza = 0;
												var Nivel_Danza  = 0;
												var Cual_Danzas = '';
											}
								
								}//-->Danza_id
								
								if(!$.trim($('#DzFloclorica_id').val())){//-->DzFloclorica_id
											
									if($('#Danza_Floclorica').is(':checked')){
											var Danza_Floclorica = 2;
											var Cual_Danzas = '';
											/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
												if($('#Nv_DzFol_Uno').is(':checked')){
														var Nivel_Danza_Floclorica  = 1;
													}
												if($('#Nv_DzFol_Dos').is(':checked')){
														var Nivel_Danza_Floclorica  = 2;
													}
												if($('#Nv_DzFol_Tres').is(':checked')){
														var Nivel_Danza_Floclorica  = 3;
													}		
											/************************************************/
										}else{
												var Danza_Floclorica = 0;
												var Nivel_Danza_Floclorica  = 0;
												var Cual_Danzas = '';
											}	
											
								}//-->DzFloclorica_id
								
								if(!$.trim($('#DzModerna_id').val())){//-->DzModerna_id
											
									if($('#Danza_Moderna').is(':checked')){
											var Danza_Moderna = 3;
											var Cual_Danzas = '';
											/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
												if($('#Nv_DzMod_Uno').is(':checked')){
														var Nivel_Danza_Moderna  = 1;
													}
												if($('#Nv_DzMod_Dos').is(':checked')){
														var Nivel_Danza_Moderna  = 2;
													}
												if($('#Nv_DzMod_Tres').is(':checked')){
														var Nivel_Danza_Moderna  = 3;
													}		
											/************************************************/
										}else{
												var Danza_Moderna = 0;
												var Nivel_Danza_Moderna  = 0;
												var Cual_Danzas = '';
											}	
											
								}//-->DzModerna_id
								
								if(!$.trim($('#DzContemporanea_id').val())){//-->DzContemporanea_id
											
									if($('#Danza_Contemporanea').is(':checked')){
											var Danza_Contemporanea = 4;
											var Cual_Danzas = '';
											/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
												if($('#Nv_DzCont_Uno').is(':checked')){
														var Nivel_Danza_Contemporanea  = 1;
													}
												if($('#Nv_DzCont_Dos').is(':checked')){
														var Nivel_Danza_Contemporanea  = 2;
													}
												if($('#Nv_DzCont_Tres').is(':checked')){
														var Nivel_Danza_Contemporanea  = 3;
													}		
											/************************************************/
										}else{
												var Danza_Contemporanea = 0;
												var Nivel_Danza_Contemporanea  = 0;
												var Cual_Danzas = '';
											}
											
								}//-->DzContemporanea_id
								
								if(!$.trim($('#DzBallet_id').val())){//-->DzBallet_id
											
									if($('#Ballet').is(':checked')){
											var Ballet = 5;
											var Cual_Danzas = '';
											/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
												if($('#Nv_Ballet_Uno').is(':checked')){
														var Nivel_Ballet  = 1;
													}
												if($('#Nv_Ballet_Dos').is(':checked')){
														var Nivel_Ballet  = 2;
													}
												if($('#Nv_Ballet_Tres').is(':checked')){
														var Nivel_Ballet  = 3;
													}		
											/************************************************/
										}else{
												var Ballet = 0;
												var Nivel_Ballet  = 0;
												var Cual_Danzas = '';
											}
											
								}//__>DzBallet_id
								
								if(!$.trim($('#DzOtra_id').val())){//->DzOtra_id
											
									if($('#Otra_Danza').is(':checked')){
											var Otra_Danza = 6;
											var Cual_Danzas = $('#Cual_Danzas').val();
											/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
												if($('#Nv_DzOtra_Uno').is(':checked')){
														var Nivel_Otra_Danza  = 1;
													}
												if($('#Nv_DzOtra_Dos').is(':checked')){
														var Nivel_Otra_Danza  = 2;
													}
												if($('#Nv_DzOtra_Tres').is(':checked')){
														var Nivel_Otra_Danza  = 3;
													}		
											/************************************************/
										}else{
												var Otra_Danza = 0;
												var Nivel_Otra_Danza  = 0;
												var Cual_Danzas = '';
											}	
											
								}//-->DzOtra_id
								/************************************************/
						}else {
							
							
								var ExpCorporal  = 1;
								/************************************************/
									var Danza					  	 = 0;
									var Nivel_Danza 				 = 0;
									var Danza_Floclorica 			 = 0;
									var Nivel_Danza_Floclorica 		 = 0;
									var Danza_Moderna				 = 0;
									var Nivel_Danza_Moderna 		 = 0;
									var Danza_Contemporanea			 = 0;
									var Nivel_Danza_Contemporanea 	 = 0;
									var Ballet						 = 0;
									var Nivel_Ballet 				 = 0;
									var Otra_Danza					 = 0;
									var Nivel_Otra_Danza 			 = 0;
									var Cual_Danzas					 = '';
								/************************************************/
							}
				}//-->NoDanza_id
				
				/*******************Esecnica Arte*****************************/
				if(!$.trim($('#NoEscenica_id').val())){//-->NoEscenica_id
				
					if($('#Si_Arte').is(':checked')){
						var GuardarSave = 0;
							var Arte_escenicas  = 0;
							/************************************************/
							/*
								1=Teatro
								2=Actuación
								3=Narración Oral
								4= Stand Up Comedy
								5=otro
							*/
							if(!$.trim($('#Teatro_id').val())){//->Teatro_id
							
								if($('#Teatro').is(':checked')){
										var Teatro = 1;
										var Cual_arte_Escenico = '';
										/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
											if($('#Nv_Teatro_Uno').is(':checked')){
													var Nivel_Teatro = 1;
												}
											if($('#Nv_Teatro_Dos').is(':checked')){
													var Nivel_Teatro = 2;
												}	
											if($('#Nv_Teatro_Tres').is(':checked')){
													var Nivel_Teatro = 3;
												}	
										/************************************************/
									}else{
											var Teatro = 0;
											var Nivel_Teatro = 0;
											var Cual_arte_Escenico = '';
										}
										
							}//-->Teatro_id
							
							if(!$.trim($('#Actuacion_id').val())){//-->Actuacion_id
										
								if($('#actuacion').is(':checked')){
										var actuacion = 2;
										var Cual_arte_Escenico = '';
										/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
											if($('#Nv_Actua_Uno').is(':checked')){
													var Nivel_actuacion = 1;
												}
											if($('#Nv_Actua_Dos').is(':checked')){
													var Nivel_actuacion = 2;
												}	
											if($('#Nv_Actua_Tres').is(':checked')){
													var Nivel_actuacion = 3;
												}	
										/************************************************/
									}else{
											var actuacion = 0;
											var Nivel_actuacion = 0;
											var Cual_arte_Escenico = '';
										}	
										
							}//-->Actuacion_id
							
							if(!$.trim($('#Narracion_id').val())){//->Narracion_id
										
								if($('#narracion').is(':checked')){
										var narracion = 3;
										var Cual_arte_Escenico = '';
										/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
											if($('#Nv_Narra_Uno').is(':checked')){
													var Nivel_narracion = 1;
												}
											if($('#Nv_Narra_Dos').is(':checked')){
													var Nivel_narracion = 2;
												}	
											if($('#Nv_Narra_Tres').is(':checked')){
													var Nivel_narracion = 3;
												}	
										/************************************************/
									}else{
											var narracion = 0;
											var Nivel_narracion = 0;
											var Cual_arte_Escenico = '';
										}	
										
							}//->Narracion_id
							
							if(!$.trim($('#Standcomedy_id').val())){//-->Standcomedy_id
										
								if($('#standcomedy').is(':checked')){
										var standcomedy = 4;
										var Cual_arte_Escenico = '';
										/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
											if($('#Nv_Stand_Uno').is(':checked')){
													var Nivel_standcomedy = 1;
												}
											if($('#Nv_Stand_Dos').is(':checked')){
													var Nivel_standcomedy = 2;
												}	
											if($('#Nv_Stand_Tres').is(':checked')){
													var Nivel_standcomedy = 3;
												}	
										/************************************************/
									}else{
											var standcomedy = 0;
											var Nivel_standcomedy = 0;
											var Cual_arte_Escenico = '';
										}
								
							}//-->Standcomedy_id
							
							if(!$.trim($('#OtroArte_id').val())){//-->OtroArte_id
										
								if($('#Otro_arte').is(':checked')){
										var Otro_Escenica = 5;
										var Cual_arte_Escenico = $('#Cual_arte').val();
										/************************************************/
												/*
													1=Básico
													2=Medio
													3=Avanzado
												*/
											if($('#Nv_OtroEscen_Uno').is(':checked')){
													var Nivel_Otro_Escenica = 1;
												}
											if($('#Nv_OtroEscen_Dos').is(':checked')){
													var Nivel_Otro_Escenica = 2;
												}	
											if($('#Nv_OtroEscen_Tres').is(':checked')){
													var Nivel_Otro_Escenica = 3;
												}	
										/************************************************/
									}else{
											var Otro_Escenica = 0;
											var Nivel_Otro_Escenica = 0;
											var Cual_arte_Escenico = '';
										}
										
							}//-->OtroArte_id
							/************************************************/
						}else { 
										
																
								var Arte_escenicas  = 1;
								/************************************************/
									var Teatro 				= 0;
									var Nivel_Teatro 		= 0;
									var actuacion 			= 0;
									var Nivel_actuacion 	= 0;
									var narracion 			= 0;
									var Nivel_narracion 	= 0;
									var standcomedy 		= 0;
									var Nivel_standcomedy 	= 0;
									var Otro_Escenica 		= 0;
									var Nivel_Otro_Escenica = 0;
									var Cual_arte_Escenico 	= '';
								/************************************************/
							}
							
				}//->NoEscenica_id
				/********************Arte Lileraria**************************/
				if(!$.trim($('#NoLirica_id').val())){//-->NoLirica_id
				
					if($('#Si_Literaria').is(':checked')){
						var GuardarSave = 0;
							var Literaria = 0;
							/************************************************/
								/*
									1=Poesia
									2=Cuento
									3=Novela
									4=Crónica
									5=Otro
								*/
							if(!$.trim($('#poesia_id').val())){//-->poesia_id	
								
								if($('#poesia').is(':checked')){
										var poesia = 1;
										var Cual_Literatura = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_poesia_Uno').is(':checked')){
													var Nivel_poesia  =1;
												}
											if($('#Nv_poesia_Dos').is(':checked')){
													var Nivel_poesia  =2;
												}	
											if($('#Nv_poesia_Tres').is(':checked')){
													var Nivel_poesia  =3;
												}	
										/************************************************/
									}else{
											var poesia = 0;
											var Nivel_poesia  = 0;
											var Cual_Literatura = '';
										}
							}//-->poesia_id
							
							if(!$.trim($('#cuento_id').val())){//-->cuento_id			
								
								if($('#cuento').is(':checked')){
										var cuento = 2;
										var Cual_Literatura = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_cuento_Uno').is(':checked')){
													var Nivel_cuento  =1;
												}
											if($('#Nv_cuento_Dos').is(':checked')){
													var Nivel_cuento  =2;
												}	
											if($('#Nv_cuento_Tres').is(':checked')){
													var Nivel_cuento  =3;
												}	
										/************************************************/
									}else{
											var cuento = 0;
											var Nivel_cuento  = 0;
											var Cual_Literatura = '';
										}
										
							}//-->cuento_id
							
							if(!$.trim($('#novela_id').val())){//-->novela_id
										
								if($('#novela').is(':checked')){
										var novela = 3;
										var Cual_Literatura = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_novela_Uno').is(':checked')){
													var Nivel_novela  =1;
												}
											if($('#Nv_novela_Dos').is(':checked')){
													var Nivel_novela  =2;
												}	
											if($('#Nv_novela_Tres').is(':checked')){
													var Nivel_novela  =3;
												}	
										/************************************************/
									}else{
											var novela = 0;
											var Nivel_novela  = 0;
											var Cual_Literatura = '';
										}
							
							}//->novela_id
							
							if(!$.trim($('#cronica_id').val())){//-->cronica_id						
										
								if($('#cronica').is(':checked')){
										var cronica = 4;
										var Cual_Literatura = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_cronica_Uno').is(':checked')){
													var Nivel_cronica  =1;
												}
											if($('#Nv_cronica_Dos').is(':checked')){
													var Nivel_cronica  =2;
												}	
											if($('#Nv_cronica_Tres').is(':checked')){
													var Nivel_cronica  =3;
												}	
										/************************************************/
									}else{
											var cronica = 0;
											var Nivel_cronica  = 0;
											var Cual_Literatura = '';
										}	
										
							}//-->cronica_id
							
							if(!$.trim($('#OtraLirica_id').val())){//-->OtraLirica_id
										
								if($('#Otro_Literatura').is(':checked')){
										var Otro_Literatura = 5;
										var Cual_Literatura = $('#Cual_Literatura').val();
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_Otro_Literatura_Uno').is(':checked')){
													var Nivel_Otro_Literatura  =1;
												}
											if($('#Nv_Otro_Literatura_Dos').is(':checked')){
													var Nivel_Otro_Literatura  =2;
												}	
											if($('#Nv_Otro_Literatura_Tres').is(':checked')){
													var Nivel_Otro_Literatura  =3;
												}	
										/************************************************/
									}else{
											var Otro_Literatura = 0;
											var Nivel_Otro_Literatura  = 0;
											var Cual_Literatura = '';
										}
								
							}//->OtraLirica_id
							/************************************************/
						}else {
							
								
								var Literaria = 1;
								/************************************************/
									var poesia 					= 0;
									var Nivel_poesia 	 		= 0;
									var cuento 					= 0;
									var Nivel_cuento  			= 0;
									var novela 					= 0;
									var Nivel_novela  			= 0;
									var cronica 				= 0;
									var Nivel_cronica  			= 0;
									var Otro_Literatura 		= 0;
									var Nivel_Otro_Literatura 	= 0;
									var Cual_Literatura 		= '';
								/************************************************/
							}
							
				}//-->NoLirica_id
				/********************Arte Plastico****************************/
				if(!$.trim($('#NoPlastica_id').val())){//-->NoPlastica_id
				
					if($('#Si_Plastica').is(':checked')){
						var GuardarSave = 0;
							var Plastica = 0;
							
							/************************************************/
								/*
									1=Fotografía
									2=Video
									3=Diseño Gráfico
									4=Comic
									5=Dibujo
									6=Grafitty
									7=Escultura
									8=Pintura
									9=Otro
								*/
							if(!$.trim($('#fotografia_id').val())){//-->fotografia_id	
								
								if($('#fotografia').is(':checked')){
										var  fotografia = 1;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_fotografia_Uno').is(':checked')){
													var Nivel_fotografia = 1;
												}
											if($('#Nv_fotografia_Dos').is(':checked')){
													var Nivel_fotografia = 2;
												}			
											if($('#Nv_fotografia_Tres').is(':checked')){
													var Nivel_fotografia = 3;
												}	
										/************************************************/
									}else{
											var fotografia  = 0;
											var Nivel_fotografia = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->fotografia_id
							
							if(!$.trim($('#video_id').val())){//-->video_id
										
								if($('#video').is(':checked')){
										var  video = 2;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_video_Uno').is(':checked')){
													var Nivel_video = 1;
												}
											if($('#Nv_video_Dos').is(':checked')){
													var Nivel_video = 2;
												}			
											if($('#Nv_video_Tres').is(':checked')){
													var Nivel_video = 3;
												}	
										/************************************************/
									}else{
											var video  = 0;
											var Nivel_video = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->video_id
							
							if(!$.trim($('#disenoGra_id').val())){//-->disenoGra_id
										
								if($('#diseno_Gra').is(':checked')){
										var DiseñoGrafico  = 3;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_diseno_Gra_Uno').is(':checked')){
													var Nivel_DiseñoGrafico = 1;
												}
											if($('#Nv_diseno_Gra_Dos').is(':checked')){
													var Nivel_DiseñoGrafico = 2;
												}			
											if($('#Nv_diseno_Gra_Tres').is(':checked')){
													var Nivel_DiseñoGrafico = 3;
												}	
										/************************************************/
									}else{
											var DiseñoGrafico   = 0;
											var Nivel_DiseñoGrafico = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->disenoGra_id
										
							if(!$.trim($('#Comic_id').val())){//-->Comic_id
										
								if($('#comic').is(':checked')){
										var Comic  = 4;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_comic_Uno').is(':checked')){
													var Nivel_Comic = 1;
												}
											if($('#Nv_comic_Dos').is(':checked')){
													var Nivel_Comic = 2;
												}			
											if($('#Nv_comic_Tres').is(':checked')){
													var Nivel_Comic = 3;
												}	
										/************************************************/
									}else{
											var Comic   = 0;
											var Nivel_Comic = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->Comic_id
							
							if(!$.trim($('#Dibujo_id').val())){//-->Dibujo_id
										
								if($('#dibujo').is(':checked')){
										var  Dibujo = 5;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_dibujo_Uno').is(':checked')){
													var Nivel_Dibujo = 1;
												}
											if($('#Nv_dibujo_Dos').is(':checked')){
													var Nivel_Dibujo = 2;
												}			
											if($('#Nv_dibujo_Tres').is(':checked')){
													var Nivel_Dibujo = 3;
												}	
										/************************************************/
									}else{
											var Dibujo   = 0;
											var Nivel_Dibujo = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->Dibujo_id
							
							if(!$.trim($('#Grafitty_id').val())){//-->Grafitty_id
										
								if($('#grafitty').is(':checked')){
										var Grafitty  = 6;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_grafitty_Uno').is(':checked')){
													var Nivel_Grafitty = 1;
												}
											if($('#Nv_grafitty_Dos').is(':checked')){
													var Nivel_Grafitty = 2;
												}			
											if($('#Nv_grafitty_Tres').is(':checked')){
													var Nivel_Grafitty = 3;
												}	
										/************************************************/
									}else{
											var Grafitty   = 0;
											var Nivel_Grafitty = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->Grafitty_id
							
							if(!$.trim($('#Escultura_id').val())){//-->Escultura_id
										
								if($('#escultura').is(':checked')){
										var Escultura  = 7;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_escultura_Uno').is(':checked')){
													var Nivel_Escultura = 1;
												}
											if($('#Nv_escultura_Dos').is(':checked')){
													var Nivel_Escultura = 2;
												}			
											if($('#Nv_escultura_Tres').is(':checked')){
													var Nivel_Escultura = 3;
												}	
										/************************************************/
									}else{
											var Escultura   = 0;
											var Nivel_Escultura = 0;
											var Cual_ArtePlastico  = '';
										}	
										
							}//-->Escultura_id
							
							if(!$.trim($('#Pintura_id').val())){//-_>Pintura_id
										
								if($('#pintura').is(':checked')){
										var Pintura = 8;
										var Cual_ArtePlastico  = '';
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_pintura_Uno').is(':checked')){
													var Nivel_Pintura = 1;
												}
											if($('#Nv_pintura_Dos').is(':checked')){
													var Nivel_Pintura = 2;
												}			
											if($('#Nv_pintura_Tres').is(':checked')){
													var Nivel_Pintura = 3;
												}	
										/************************************************/
									}else{
											var Pintura   = 0;
											var Nivel_Pintura = 0;
											var Cual_ArtePlastico  = '';
										}
										
							}//-->Pintura_id
							
							if(!$.trim($('#OtroPlastico_id').val())){//-->OtroPlastico_id
										
								if($('#Otro_Plastico').is(':checked')){
										var Otro_Plastico  = 9;
										var Cual_ArtePlastico  = $('#Cual_ArtePlastico').val();
										/************************************************/
											/*
												1=Básico
												2=Medio
												3=Avanzado
											*/
											if($('#Nv_Otro_PV_Uno').is(':checked')){
													var Nivel_Otro_Plastico = 1;
												}
											if($('#Nv_Otro_PV_Dos').is(':checked')){
													var Nivel_Otro_Plastico = 2;
												}			
											if($('#Nv_Otro_PV_Tres').is(':checked')){
													var Nivel_Otro_Plastico = 3;
												}	
										/************************************************/
									}else{
											var Otro_Plastico   = 0;
											var Nivel_Otro_Plastico = 0;
											var Cual_ArtePlastico  = '';
										}	
										
							}//-->OtroPlastico_id
							/************************************************/
						}else{
							
							
								var Plastica = 1;
								/************************************************/
									var fotografia  = 0;
									var Nivel_fotografia = 0;
									var video  = 0;
									var Nivel_video = 0;
									var DiseñoGrafico   = 0;
									var Nivel_DiseñoGrafico = 0;
									var Comic   = 0;
									var Nivel_Comic = 0;
									var Dibujo   = 0;
									var Nivel_Dibujo = 0;
									var Grafitty   = 0;
									var Nivel_Grafitty = 0;
									var Escultura   = 0;
									var Nivel_Escultura = 0;
									var Pintura   = 0;
									var Nivel_Pintura = 0;
									var Otro_Plastico   = 0;
									var Nivel_Otro_Plastico = 0;
									var Cual_ArtePlastico  = '';
								/************************************************/
							}
							
				}//->NoPlastica_id
				/************************************************/
				/*******************Ajax*****************************/
					$.ajax({//Ajax
						   type: 'GET',
						   url: 'Hoja_Vida.html.php',
						   async: false,
						   dataType: 'json',
						   data:({actionID: 'SaveTab4',id_Estudiante:id_Estudiante,
						   							   Enfermeda_Si:Enfermeda_Si,
													   Enf_Endroquina:Enf_Endroquina,
													   DesordenMental:DesordenMental,
													   Enf_Circulatorio:Enf_Circulatorio,
													   Enf_Respiratorio:Enf_Respiratorio,
													   Enf_Locomotor:Enf_Locomotor,
													   Enf_Malformaciones:Enf_Malformaciones,
													   Enf_Otras:Enf_Otras,
													   Alegia:Alegia,
													   Cual_Alergia:Cual_Alergia,
													   UsoMedicamentos:UsoMedicamentos,
													   Cual_UsoMed:Cual_UsoMed,
													   Trastorno:Trastorno,
													   Anorexia:Anorexia,
													   Bulimia:Bulimia,
													   Obesidad:Obesidad,
													   Otra_Trastorno:Otra_Trastorno,
													   TrastornoText:TrastornoText,
													   Discapacidad:Discapacidad,
													   locomocion:locomocion,
													   inferior:inferior,
													   Superior:Superior,
													   Paralisis:Paralisis,
													   Visual:Visual,
													   Auditiva:Auditiva,
													   Habla:Habla,
													   ObservacionCondicionDiscapacidad:ObservacionCondicionDiscapacidad,
													   Sarampion:Sarampion,
													   Hepati_Dosis:Hepati_Dosis,
													   Rubeola:Rubeola,
													   Hepatitis_B:Hepatitis_B,
													   VPH:VPH,
													   VPH_Dosis:VPH_Dosis,
													   Vegetariano:Vegetariano,
													   Fuma:Fuma,
													   Frecuencia_fuma:Frecuencia_fuma,
													   Alcohol:Alcohol,
													   Frecuencia_Alcohol:Frecuencia_Alcohol,
													   Act_Fisica:Act_Fisica,
													   Act_FisicaCual:Act_FisicaCual,
													   Fre_ActFisica:Fre_ActFisica,
													   PracticaDepor:PracticaDepor,
													   Futbol:Futbol,
													   Frecuencia_Futbol:Frecuencia_Futbol,
													   F_sala:F_sala,
													   Frecuencia_F_sala:Frecuencia_F_sala,
													   Basketball:Basketball,
													   Frecuencia_Basketball:Frecuencia_Basketball,
													   Voleibol:Voleibol,
													   Frecuencia_Voleibol:Frecuencia_Voleibol,
													   Rugby:Rugby,
													   Frecuencia_Rugby:Frecuencia_Rugby,
													   T_mesa:T_mesa,
													   Frecuencia_T_mesa:Frecuencia_T_mesa,
													   Ciclismo:Ciclismo,
													   Frecuencia_Ciclismo:Frecuencia_Ciclismo,
													   Natacion:Natacion,
													   Frecuencia_Natacion:Frecuencia_Natacion,
													   Atletismo:Atletismo,
													   Frecuencia_Atletismo:Frecuencia_Atletismo,
													   Beisbol:Beisbol,
													   Frecuencia_Beisbol:Frecuencia_Beisbol,
													   Ajedrez:Ajedrez,
													   Frecuencia_Ajedrez:Frecuencia_Ajedrez,
													   Squash:Squash,
													   Frecuencia_Squash:Frecuencia_Squash,
													   Taekwondo:Taekwondo,
													   Frecuencia_Taekwondo:Frecuencia_Taekwondo,
													   OtroPractica:OtroPractica,
													   Otro_deporte:Otro_deporte,
													   Frecuencia_OtroPractica:Frecuencia_OtroPractica,
													   PerteneceRed:PerteneceRed,
													   Pertenece_Cual:Pertenece_Cual,
													   Voluntariado:Voluntariado,
													   Voluntariado_Cual:Voluntariado_Cual,
													   musica:musica,
													   Guitarra:Guitarra,
													   Nivel_Guitarra:Nivel_Guitarra,
													   Bateria:Bateria,
													   Nivel_Bateria:Nivel_Bateria,
													   Saxofon:Saxofon,
													   Nivel_Saxofon:Nivel_Saxofon,
													   Trompeta:Trompeta,
													   Nivel_Trompeta:Nivel_Trompeta,
													   Congas:Congas,
													   Nivel_Congas:Nivel_Congas,
													   Acordion:Acordion,
													   Nivel_Acordion:Nivel_Acordion,
													   Otro_Musica:Otro_Musica,
													   Cual_Instrumentio:Cual_Instrumentio,
													   Nivel_Otro_Musica:Nivel_Otro_Musica,
													   ExpCorporal:ExpCorporal,
													   Danza:Danza,
													   Nivel_Danza:Nivel_Danza,
													   Danza_Floclorica:Danza_Floclorica,
													   Nivel_Danza_Floclorica:Nivel_Danza_Floclorica,
													   Danza_Moderna:Danza_Moderna,
													   Nivel_Danza_Moderna:Nivel_Danza_Moderna,
													   Danza_Contemporanea:Danza_Contemporanea,
													   Nivel_Danza_Contemporanea:Nivel_Danza_Contemporanea,
													   Ballet:Ballet,
													   Nivel_Ballet:Nivel_Ballet,
													   Otra_Danza:Otra_Danza,
													   Nivel_Otra_Danza:Nivel_Otra_Danza,
													   Cual_Danzas:Cual_Danzas,
													   Arte_escenicas:Arte_escenicas,
													   Teatro:Teatro,
													   Nivel_Teatro:Nivel_Teatro,
													   actuacion:actuacion,
													   Nivel_actuacion:Nivel_actuacion,
													   narracion:narracion,
													   Nivel_narracion:Nivel_narracion,
													   standcomedy:standcomedy,
													   Nivel_standcomedy:Nivel_standcomedy,
													   Otro_Escenica:Otro_Escenica,
													   Nivel_Otro_Escenica:Nivel_Otro_Escenica,
													   Cual_arte_Escenico:Cual_arte_Escenico,
													   Literaria:Literaria,
													   poesia:poesia,
													   Nivel_poesia:Nivel_poesia,
													   cuento:cuento,
													   Nivel_cuento:Nivel_cuento,
													   novela:novela,
													   Nivel_novela:Nivel_novela,
													   cronica:cronica,
													   Nivel_cronica:Nivel_cronica,
													   Otro_Literatura:Otro_Literatura,
													   Nivel_Otro_Literatura:Nivel_Otro_Literatura,
													   Cual_Literatura:Cual_Literatura,
													   Plastica:Plastica,
													   fotografia:fotografia,
													   Nivel_fotografia:Nivel_fotografia,
													   video:video,
													   Nivel_video:Nivel_video,
													   DiseñoGrafico:DiseñoGrafico,
													   Nivel_DiseñoGrafico:Nivel_DiseñoGrafico,
													   Comic:Comic,
													   Nivel_Comic:Nivel_Comic,
													   Dibujo:Dibujo,
													   Nivel_Dibujo:Nivel_Dibujo,
													   Grafitty:Grafitty,
													   Nivel_Grafitty:Nivel_Grafitty,
													   Escultura:Escultura,
													   Nivel_Escultura:Nivel_Escultura,
													   Pintura:Pintura,
													   Nivel_Pintura:Nivel_Pintura,
													   Otro_Plastico:Otro_Plastico,
													   Nivel_Otro_Plastico:Nivel_Otro_Plastico,
													   Cual_ArtePlastico:Cual_ArtePlastico,
													   GuardarSave:GuardarSave,
													   Tetano:Tetano,
													   Tennis:Tennis,
													   Frecuencia_Tennis:Frecuencia_Tennis}),
						   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
						   success: function(data){
										if(data.val=='FALSE'){
												alert(data.descrip);
												return false;
											}else if(data.val=='TRUE'){
												/*	
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
												*/		
												
												$('#id_SaveCondicionSalud').val(data.CondicionSalud_id);
												$('#id_VacunasSarampion').val(data.Sarampion_id);
												$('#id_VacunasRubeola').val(data.Rubeola_id);
												$('#id_VacunasTetano').val(data.Tetano);
												$('#id_VacunasHepatitisB').val(data.HepatitisB_id);
												$('#id_VacunasVPH').val(data.VPH_id);
												$('#id_HabitosSaludables').val(data.HabitoSaludable_id);
												$('#ActividaFisica_id').val(data.ActividaFisica_id);
												/*********************************************************/
												
												var C_Deporte  = data.CadenaDeporte;
												
												var C_DetalleDeporte = C_Deporte.split('::')
												
												var Num_Dep =  C_DetalleDeporte.length;
												
												
												for(d=1;d<Num_Dep;d++){
													
														var D_Detalle = C_DetalleDeporte[d].split('-');
														/***********************************************/
															switch(D_Detalle[0]){
																	case 'Futbol':{
																			$('#Futbol_id').val(D_Detalle[1]);
																		}break;
																	case 'F_Sala':{
																			$('#Sala_id').val(D_Detalle[1]);
																		}break;
																	case 'Basketball':{
																			$('#Basketball_id').val(D_Detalle[1]);
																		}break;
																	case 'Voleibol':{
																			$('#Voleibol_id').val(D_Detalle[1]);
																		}break;
																	case 'Rugby':{
																			$('#Rugby_id').val(D_Detalle[1]);
																		}break;
																	case 'T_mesa':{
																			$('#T_mesa_id').val(D_Detalle[1]);
																		}break;
																	case 'Ciclismo':{
																			$('#Ciclismo_id').val(D_Detalle[1]);
																		}break;
																	case 'Natacion':{
																			$('#Natacion_id').val(D_Detalle[1]);
																		}break;
																	case 'Atletismo':{
																			$('#Atletismo_id').val(D_Detalle[1]);
																		}break;
																	case 'Beisbol':{
																			$('#Beisbol_id').val(D_Detalle[1]);
																		}break;
																	case 'Ajedrez':{
																			$('#Ajedrez_id').val(D_Detalle[1]);
																		}break;
																	case 'Squash':{
																			$('#Squash_id').val(D_Detalle[1]);
																		}break;
																	case 'Taekwondo':{
																			$('#Taekwondo_id').val(D_Detalle[1]);
																		}break;
																	case 'OtroDeporte':{
																			$('#OtroDeporte_id').val(D_Detalle[1]);
																		}break;
																	case 'NoDeporte':{
																			$('#No_Deporte_id').val(D_Detalle[1]);
																		}break;
																	case 'Tennis':{
																			$('#Tennis_id').val(D_Detalle[1]);
																		}break;	
																}
														/***********************************************/
													}//->For
												/*********************************************************/
												var C_Musica        = data.CadenaMusica;
												
												var C_DetalleMusica = C_Musica.split('::')
												
												var Num_Mus =  C_DetalleMusica.length;	
												
												for(m=1;m<Num_Mus;m++){
													/*********************************************************/	
														var M_Detalle  = C_DetalleMusica[m].split('-');
														
														switch(M_Detalle[0]){
																case 'Guitarra':{
																		$('#Guitarra_id').val(M_Detalle[1]);
																	}break;
																case 'Bateria':{
																		$('#Bateria_id').val(M_Detalle[1]);
																	}break;
																case 'Saxofon':{
																		$('#Saxofon_id').val(M_Detalle[1]);
																	}break;
																case 'Trompeta':{
																		$('#Trompeta_id').val(M_Detalle[1]);
																	}break;
																case 'Congas':{
																		$('#Congas_id').val(M_Detalle[1]);
																	}break;
																case 'Acordion':{
																		$('#Acordion_id').val(M_Detalle[1]);
																	}break;
																case 'OtroMusica':{
																		$('#OtraMusica_id').val(M_Detalle[1]);
																	}break;
																case 'NoMusica':{
																		$('#No_Musica_id').val(M_Detalle[1]);
																	}break;							
															}
													/*********************************************************/	
													}//->For
												
												/*********************************************************/	
												var C_Exprecion        = data.CadenaExpreCorporal;
												
												var C_DetalleExprecion = C_Exprecion.split('::')
												
												var Num_Exp =  C_DetalleExprecion.length;
												
												for(e=1;e<Num_Exp;e++){
													/*********************************************************/	
														var Exp_Detalle  = C_DetalleExprecion[e].split('-');
														
														switch(Exp_Detalle[0]){
																case 'Danza':{
																		$('#Danza_id').val(Exp_Detalle[1]);
																	}break;
																case 'DzFloclorica':{
																		$('#DzFloclorica_id').val(Exp_Detalle[1]);
																	}break;	
																case 'DzModerna':{
																		$('#DzModerna_id').val(Exp_Detalle[1]);
																	}break;
																case 'DzContemporanea':{
																		$('#DzContemporanea_id').val(Exp_Detalle[1]);
																	}break;
																case 'DzBallet':{
																		$('#DzBallet_id').val(Exp_Detalle[1]);
																	}break;
																case 'OtraDanza':{
																		$('#DzOtra_id').val(Exp_Detalle[1]);
																	}break;
																case 'NoDanza':{
																		$('#NoDanza_id').val(Exp_Detalle[1]);
																	}break;					
															} 
													/*********************************************************/		
													}//-->For	
												/*********************************************************/	
												var C_Escenica        = data.CadenaArteEscenica;
												
												var C_DetalleEscenica = C_Escenica.split('::')
												
												var Num_Esc =  C_DetalleEscenica.length;
												
												for(s=1;s<Num_Esc;s++){
													/*********************************************************/	
													var Esc_Detalle  = C_DetalleEscenica[s].split('-');
														
														switch(Esc_Detalle[0]){
																case 'Teatro':{
																		$('#Teatro_id').val(Esc_Detalle[1]);
																	}break;
																case 'Actuacion':{
																		$('#Actuacion_id').val(Esc_Detalle[1]);
																	}break;
																case 'Narracion':{
																		$('#Narracion_id').val(Esc_Detalle[1]);
																	}break;
																case 'StandComedy':{
																		$('#Standcomedy_id').val(Esc_Detalle[1]);
																	}break;
																case 'OtraEscenica':{
																		$('#OtroArte_id').val(Esc_Detalle[1]);
																	}break;
																case 'NoEscenica':{
																		$('#NoEscenica_id').val(Esc_Detalle[1]);
																	}break;
																						
															}
													/*********************************************************/	
													}//->for
												
												/*********************************************************/	
												var C_Literario        = data.CadedenaLiteraria;
												
												var C_DetalleLiterario = C_Literario.split('::')
												
												var Num_Lirico =  C_DetalleLiterario.length;
												
												for(l=1;l<Num_Lirico;l++){
													/*********************************************************/	
													var LiricoDetalle  = C_DetalleLiterario[l].split('-');
														
														switch(LiricoDetalle[0]){
																case 'Poesia':{
																		$('#poesia_id').val(LiricoDetalle[1]);
																	}break;
																case 'Cuento':{
																		$('#cuento_id').val(LiricoDetalle[1]);
																	}break;
																case 'Novela':{
																		$('#novela_id').val(LiricoDetalle[1]);
																	}break;
																case 'Cronica':{
																		$('#cronica_id').val(LiricoDetalle[1]);
																	}break;
																case 'OtroLiteratura':{
																		$('#OtraLirica_id').val(LiricoDetalle[1]);
																	}break;
																case 'NoLiteratura':{
																		$('#NoLirica_id').val(LiricoDetalle[1]);
																	}break;					
															}
													/*********************************************************/	
													}//->For
												/*********************************************************/	
												var C_Plastica        = data.CadenaPlastica;
												
												var C_DetallePlastica = C_Plastica.split('::')
												
												var Num_Plastica =  C_DetallePlastica.length;
												
												for(p=1;p<Num_Plastica;p++){
													/**********************************************************/
													var PlasticaDetalle  = C_DetallePlastica[p].split('-');
														
														switch(PlasticaDetalle[0]){
																case 'Fotografia':{
																		$('#fotografia_id').val(PlasticaDetalle[1]);
																	}break;
																case 'Video':{
																		$('#video_id').val(PlasticaDetalle[1]);
																	}break;
																case 'DisenoGrafico':{
																		$('#disenoGra_id').val(PlasticaDetalle[1]);
																	}break;
																case 'Comic':{
																		$('#Comic_id').val(PlasticaDetalle[1]);
																	}break;
																case 'Dibujo':{
																		$('#Dibujo_id').val(PlasticaDetalle[1]);
																	}break;
																case 'Grafitty':{
																		$('#Grafitty_id').val(PlasticaDetalle[1]);
																	}break;
																case 'Escultura':{
																		$('#Escultura_id').val(PlasticaDetalle[1]);
																	}break;
																case 'Pintura':{
																		$('#Pintura_id').val(PlasticaDetalle[1]);
																	}break;
																case 'OtroPlastico':{
																		$('#OtroPlastico_id').val(PlasticaDetalle[1]);
																	}break;
																case 'NoPlastico':{
																		$('#NoPlastica_id').val(PlasticaDetalle[1]);
																	}break;									
															}
													/**********************************************************/
													}//->for
												/*********************************************************/	
												}
						   } 
					}); //AJAX
				
				/*****************Fin Ajax***************************/
				}//-->Ind==4 fin
				
				
		/**************************InformacionPersonal*************************************/	
	}				
	function AutoCityFamilia(j){
		/********************************************************/	
			$('#CiudadFamilia_'+j).autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#Ciudad_id_Familia_'+j).val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/		
		}	
	function FormatCityFamily(j){
			$('#CiudadFamilia_'+j).val('');
			$('#Ciudad_id_Familia_'+j).val('');
		}	
	function Ver_ParticipacionAcad(){
			if($('#Si_Participa').is(':checked')){
					$('#Tr_ParticipacionAcademica').css('visibility','visible');
					
				}else{
						$('#Tr_ParticipacionAcademica').css('visibility','collapse');
					}
		}	
	function Ver_Logros(){
			if($('#Si_Logros').is(':checked')){
					$('#Tr_LogrosDistincion').css('visibility','visible');
					
				}else{
						$('#Tr_LogrosDistincion').css('visibility','collapse');
					}
		}	
	function DeleteMedio(p,h,id,id_Estudiante){
		
			if($('#Medio_'+p+'_'+h).is(':checked')===false){
				
				var id_EstudioanteMedio   = $('#id_EstudioanteMedio_'+id).val();
					
		/******************************************************************************AJAX*******************************************************************************************************************/
					
					$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'DeleteMedio',id_EstudioanteMedio:id_EstudioanteMedio,
					   								  id:id,
													  id_Estudiante:id_Estudiante}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{
												
												$('#id_EstudioanteMedio_'+id).val('');
												$('#Descrip_'+id).val('');
													
											}
					   } 
				}); //AJAX
			
			/**********************************************************************Fin AJAX************************************************************************************************************************/
			
					
				}
			
		}	
	function DeleteRecursoFinaciero(t,id,id_Estudiante){
			if($('#Recuso_id_'+t).is(':checked')===false){
				
					var id_RecursoEstudiante   = $('#id_RecursoEstudiante_'+id).val();
					
					
 	/******************************************************************************AJAX*******************************************************************************************************************/
					
					$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'DeleteRecurso',id_RecursoEstudiante:id_RecursoEstudiante,
					   								    id:id,
													    id_Estudiante:id_Estudiante}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{
												
												$('#id_RecursoEstudiante_'+id).val('');    
												
													
											}
					   } 
				}); //AJAX
			
			/**********************************************************************Fin AJAX************************************************************************************************************************/
			
				
				}
		}
	function Ver_EnfermedadesUno(){
			if($('#Enfermeda_Si').is(':checked')){
					$('#Pregunta_Uno').css('visibility','visible');
					
				}else{
					$('#Pregunta_Uno').css('visibility','collapse');
					}
		
		}
	function Ver_Trastorno(){
			if($('#Trastorno_Si').is(':checked')){
					$('#Div_Pregunta4').css('display','inline');
				}else{
						$('#Div_Pregunta4').css('display','none');
					}
		}	
	function Ver_Discapaciada(){
			if($('#Si_discapacidad').is(':checked')){
					$('#Div_Pregunta5').css('display','inline');
				}else{
						$('#Div_Pregunta5').css('display','none');
					}
		}	
	function Update_Registro(Op){
		var Estudiante_id  = $('#Estudiante_id').val();	
			if(Op==1){//-->Op==1
				/***********************************************************/
					var id_SaveCondicionSalud  = $('#id_SaveCondicionSalud').val();
					
					if($.trim(id_SaveCondicionSalud)){
						/*********************************************************/
							if($('#Enfermeda_No').is(':checked')){
									var Enfermeda = 1;
									var Enf_Endroquina      = '';
									var DesordenMental      = '';
									var Enf_Circulatorio    = '';
									var Enf_Respiratorio    = '';
									var Enf_Locomotor  		= '';
									var Enf_Malformaciones  = '';
									var Enf_Otras           = '';
								}
							if($('#Enfermeda_Si').is(':checked')){
									var Enfermeda = 0;
									var Enf_Endroquina  = $('#Enf_Endroquina').val();
									var DesordenMental  = $('#DesordenMental').val();
									var Enf_Circulatorio = $('#Enf_Circulatorio').val();
									var Enf_Respiratorio = $('#Enf_Respiratorio').val();
									var Enf_Locomotor  = $('#Enf_Locomotor').val();
									var Enf_Malformaciones  = $('#Enf_Malformaciones').val();
									var Enf_Otras   = $('#Enf_Otras').val();
								}
							if($('#Alegia_Si').is(':checked')){
									var Alergia = 0;
									var Cual_Alergia = $('#Cual_Alergia').val();
								}
							if($('#Alergia_No').is(':checked')){
									var Alergia = 1;
									var Cual_Alergia = '';
								}	
							if($('#UsoMed_Si').is(':checked')){
									var UsoMedicamentos  = 0;
									var Cual_UsoMed = $('#Cual_UsoMed').val();
								}
							if($('#UsoMed_No').is(':checked')){
									var UsoMedicamentos  = 1;
								  	var Cual_UsoMed = '';
								}
							if($('#Trastorno_Si').is(':checked')){
									var Trastorno = 0;
									/******************************************/
										if($('#Anorexia').is(':checked')){
												var Anorexia = 1;
												var TrastornoText = '';
											}
										if($('#Bulimia').is(':checked')){
												var Bulimia = 2;
												var TrastornoText = '';
											}
										if($('#Obesidad').is(':checked')){
												var Obesidad = 3;
												var TrastornoText = '';
											}
										if($('#Otra_Trastorno').is(':checked')){
												var Otra_Trastorno = 4;
												var TrastornoText = $('#TrastornoText').val();
											}			
									/******************************************/
								}
							if($('#Trastorno_No').is(':checked')){
									var Trastorno = 1;
									
									var Anorexia = 0;
									var Bulimia = 0;
									var Obesidad = 0;
									var Otra_Trastorno = 0;
									var TrastornoText = '';
								}
							if($('#Si_discapacidad').is(':checked')){
									var Discapacida = 0;
									/*************************************************/
									/*
									1= Dificultad para la locomoción
									2=Anomalía o Ausencia en Estremidades Inferiores
									3=Anomalía o Ausencia enEestremidades Superiores
									4=Paralisis
									**************************************
									1=Deficiencia Visual
									2=Deficiencia Auditiva
									3= Deficiencia en el Habla
									*/
										if($('#locomocion').is(':checked')){
												var locomocion = 1;
												var inferior = 0;
												var Superior = 0;
												var Paralisis = 0;
											}
										if($('#inferior').is(':checked')){
												var inferior = 2;
												var locomocion = 0;
												var Superior = 0;
												var Paralisis = 0;
											}
										if($('#Superior').is(':checked')){
												var Superior = 3;
												var locomocion = 0;
												var inferior = 0;
												var Paralisis = 0;
											}
										if($('#Paralisis').is(':checked')){
												var Paralisis = 4;
												var locomocion = 0;
												var inferior = 0;
												var Superior = 0;
											}
										if($('#Visual').is(':checked')){
												var Visual = 1;
												var Auditiva = 0;
												var Habla = 0;
											}
										if($('#Auditiva').is(':checked')){
												var Auditiva = 2;
												var Visual = 0;
												var Habla = 0;
											}
										if($('#Habla').is(':checked')){
												var Habla = 3;
												var Visual = 0;
												var Auditiva = 0;
											}	
										var ObservacionCondicionDiscapacidad = $('#ObservacionCondicionDiscapacidad').val();						
									/*************************************************/	
								}
							if($('#No_discapacidad').is(':checked')){
									var Discapacida = 1;
									var locomocion = 0;
									var inferior = 0;
									var Superior = 0;
									var Paralisis = 0;
									var Visual = 0;
									var Auditiva = 0;
									var Habla = 0;
									var ObservacionCondicionDiscapacidad ='';
								}							
						/*********************************************************/
						}
				/***********************************************************/
				
				/**************************AJAX*********************************/
					$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'UPDATECondicionSalud',Estudiante_id:Estudiante_id,
					   								           id_SaveCondicionSalud:id_SaveCondicionSalud,
													    	   Enfermeda:Enfermeda,
															   Enf_Endroquina:Enf_Endroquina,
															   DesordenMental:DesordenMental,
															   Enf_Circulatorio:Enf_Circulatorio,
															   Enf_Respiratorio:Enf_Respiratorio,
															   Enf_Locomotor:Enf_Locomotor,
															   Enf_Malformaciones:Enf_Malformaciones,
															   Enf_Otras:Enf_Otras,
															   Alergia:Alergia,
															   Cual_Alergia:Cual_Alergia,
															   UsoMedicamentos:UsoMedicamentos,
															   Cual_UsoMed:Cual_UsoMed,
															   Trastorno:Trastorno,
															   Anorexia:Anorexia,
															   Bulimia:Bulimia,
															   Obesidad:Obesidad,
															   Otra_Trastorno:Otra_Trastorno,
															   TrastornoText:TrastornoText,
															   Discapacida:Discapacida,
															   locomocion:locomocion,
															   inferior:inferior,
															   Superior:Superior,
															   Paralisis:Paralisis,
															   Visual:Visual,
															   Auditiva:Auditiva,
															   Habla:Habla,
															   ObservacionCondicionDiscapacidad:ObservacionCondicionDiscapacidad}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}
					   } 
					}); //AJAX
				/**********************Fin***AJAX*******************************/
				}//-->Op==1
			if(Op==2){//-->X==2
					var id_HabitosSaludables = $('#id_HabitosSaludables').val();
						if($.trim(id_HabitosSaludables)){
					/**********************************************************************************/
								if($('#Si_Vegetales').is(':checked')){
										var vegetariano  = 0;
									}
								if($('#No_Vegetales').is(':checked')){
										var vegetariano  = 1;
									}
								if($('#Si_Cigarrillo').is(':checked')){
										var Fuma = 0;
										/*
											1=Menos de 1 al día
											2=Entre 1 y 2 al día
											3=Entre 3 y 6 al día
											4=Entre 7 y 10 día
											5=Mas de 11 al día
										*/
										if($('#C_uno').is(':checked')){
												var Frecuencia_fuma = 1;
											}
										if($('#C_dos').is(':checked')){
												var Frecuencia_fuma = 2;
											}
										if($('#C_tres').is(':checked')){
												var Frecuencia_fuma = 3;
											}
										if($('#C_Cuatro').is(':checked')){
												var Frecuencia_fuma = 4;
											}
										if($('#C_cinco').is(':checked')){
												var Frecuencia_fuma = 5;
											}			
									}
								if($('#No_Cigarrillo').is(':checked')){
										var Fuma = 1;
										var Frecuencia_fuma = 0;
									}
								if($('#Si_Alcohol').is(':checked')){
										
										var Alcohol = 0;
										/*
											1=Menos de 1 vez a la semana
											2=1 vez a la semana
											3=Entre 2 y 3 veces a la semana 
											4=Entre 4 y 5 veces a la semana
											5=Más de 6 veces a la semana
										*/
										if($('#Alcohol_uno').is(':checked')){
												var Frecuencia_Alcohol = 1;
											}
										if($('#Alcohol_dos').is(':checked')){
												var Frecuencia_Alcohol = 2;
											}
										if($('#Alcohol_tres').is(':checked')){
												var Frecuencia_Alcohol = 3;
											}
										if($('#Alcohol_Cuatro').is(':checked')){
												var Frecuencia_Alcohol = 4;
											}
										if($('#Alcohol_cinco').is(':checked')){
												var Frecuencia_Alcohol = 5;
											}	
									}
								if($('#No_Alcohol').is(':checked')){
										var Alcohol = 1;
										var Frecuencia_Alcohol = 0;
									}				
					/**********************************************************************************/		
							}
					/**************************************AJAX************************************************/		
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'UpdateHabitoAlimeto',Estudiante_id:Estudiante_id,
							   										  id_HabitosSaludables:id_HabitosSaludables,
																	  vegetariano:vegetariano,
																	  Fuma:Fuma,
																	  Frecuencia_fuma:Frecuencia_fuma,
																	  Alcohol:Alcohol,
																	  Frecuencia_Alcohol:Frecuencia_Alcohol}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}else{
														
														$('#id_EstudioanteMedio_'+id).val('');
														$('#Descrip_'+id).val('');
															
													}
							   } 
						}); //AJAX
					/****************************FIN***AJAX******************************************************/
				}//-->X==2;	
			
		}	
	function UpdateVacuna(X){
		/*
			1=Sarampión
			2=Rubeola
			3=Tetano
			4=Hepatitis B -> re4laciona con dosis 
			5=Virus del Papiloma Humano VPH->relaciona con dosis
		*/
			if(X==1){
					if($.trim($('#id_VacunasSarampion').val())){
						var id_Vacunas = $('#id_VacunasSarampion').val();
							if($('#Sarampion').is(':checked')){

									var Vacuna = 1;//-->1=Sarampión
									var Dosis  = 0;
								}
							if($('#Sarampion').is(':checked')===false){
									var Vacuna = 0;
									var Dosis  = 0;
								}	
						}
				}
			if(X==2){
					if($.trim($('#id_VacunasRubeola').val())){
						var id_Vacunas = $('#id_VacunasRubeola').val();
							if($('#Rubeola').is(':checked')){
									var Vacuna = 2;//-->2=Rubeola
									var Dosis  = 0;
								}
							if($('#Rubeola').is(':checked')===false){
									var Vacuna = 0;
									var Dosis  = 0;
								}
						}
				}
			if(X==3){
					if($.trim($('#id_VacunasTetano').val())){
						var id_Vacunas = $('#id_VacunasTetano').val();
							if($('#Tetano').is(':checked')){
									var Vacuna = 3;//-->3=Tetano
									var Dosis  = 0;
								}
							if($('#Tetano').is(':checked')===false){
									var Vacuna = 0;
									var Dosis  = 0;
								}
						}
				}
			if(X==4){
					if($.trim($('#id_VacunasHepatitisB').val())){
						var id_Vacunas = $('#id_VacunasHepatitisB').val();
							if($('#Hepatitis_B').is(':checked')){
									var Vacuna = 4;//-->4=Hepatitis B -> re4laciona con dosis 
									if($('#Hepati_B_Uno').is(':checked')){
											var Dosis  = 1;
										}
									if($('#Hepati_B_Dos').is(':checked')){
											var Dosis  = 2;
										}
									if($('#Hepati_B_Tres').is(':checked')){
											var Dosis  = 3;
										}
								}
							if($('#Hepatitis_B').is(':checked')===false){
									var Vacuna = 0;
									var Dosis  = 0;
								}
						}
				}
			if(X==5){
					if($.trim($('#id_VacunasVPH').val())){
						var id_Vacunas = $('#id_VacunasVPH').val();
							if($('#VPH').is(':checked')){
									var Vacuna = 5;//-->5=Virus del Papiloma Humano VPH->relaciona con dosis
									if($('#VPH_Uno').is(':checked')){
											var Dosis  = 1;
										}
									if($('#VPH_Dos').is(':checked')){
											var Dosis  = 2;
										}
									if($('#VPH_Tres').is(':checked')){
											var Dosis  = 3;
										}
								}
							if($('#VPH').is(':checked')===false){
									var Vacuna = 0;
									var Dosis  = 0;
								}
						}
				}
			
			var Estudiante_id  = $('#Estudiante_id').val();
				
			/*********************************AJAX****************************************************/
				$.ajax({//Ajax
					   type: 'GET',
					   url: 'Hoja_Vida.html.php',
					   async: false,
					   dataType: 'json',
					   data:({actionID: 'UpdateVacunas',id_Vacunas:id_Vacunas,
					   									Estudiante_id:Estudiante_id,
														Vacuna:Vacuna,
														Dosis:Dosis}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
						   			if(data.val=='FALSE'){
											alert(data.descrip);
											return false;
										}else{
												switch(X){
														case 1:{
																if(Vacuna==0){
																		$('#id_VacunasSarampion').val('');
																	}
															}break;
														case 2:{
																if(Vacuna==0){
																		$('#id_VacunasRubeola').val('');
																	}
															}break;
														case 3:{
																if(Vacuna==0){
																		$('#id_VacunasTetano').val('');
																	}
															}break;
														case 4:{
																if(Vacuna==0){
																		$('#id_VacunasHepatitisB').val('');
																	}
															}break;
														case 5:{
																if(Vacuna==0){
																		$('#id_VacunasVPH').val('');
																	}
															}break;				
													}
											}
					   } 
				}); //AJAX
			/*******************************FIN***AJAX************************************************/					
		}
	function DeleteDeporte(deporte,registro_id){
		var Estudiante_id  = $('#Estudiante_id').val();
		/*******************************************************/
			if($('#'+deporte).is(':checked')===false){
					var codigoestado = 200;
				}
			if($('#'+deporte).is(':checked')===true){
					var codigoestado = 100;
				}	
				
				var  Dato    = $('#'+registro_id).val();
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'DeleteDeporte',registro_id:Dato,
																Estudiante_id:Estudiante_id,
																codigoestado:codigoestado}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
				}
		
		/*******************************************************/
		}
	function ModificarDeporte(deporte,registro_id,fr){
		var Estudiante_id  = $('#Estudiante_id').val();
		/*******************************************************/
			if($('#'+deporte).is(':checked')===true){
				
				var  Dato    = $('#'+registro_id).val();
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'ModificaDeporte',registro_id:Dato,
																  Estudiante_id:Estudiante_id,
																  Frecuencia:fr}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
				}
			}
		
		/*******************************************************/
		}
	function DeleteMusica(instrumento,registro_id){
			var Estudiante_id  = $('#Estudiante_id').val();
			/********************************************************************/
				if($('#'+instrumento).is(':checked')===false){
					/**************************************/
						var CodigoEstado = 200;
					/**************************************/
					}
				if($('#'+instrumento).is(':checked')===true){
					/**************************************/
						var CodigoEstado = 100;
					/**************************************/
					}	
					
				var Dato = $('#'+registro_id).val();		
				
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'DeleteMusica',registro_id:Dato,
																Estudiante_id:Estudiante_id,
																CodigoEstado:CodigoEstado}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				
			/***********************************************************************/
		}
	function ModificarMusica(instrumento,registro_id,Frecuencia){
			/***********************************************************************/
				var Estudiante_id  = $('#Estudiante_id').val();
				
				if($('#'+instrumento).is(':checked')===true){
				
				var  Dato    = $('#'+registro_id).val();
				
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'ModificaMusica',registro_id:Dato,
																  Estudiante_id:Estudiante_id,
																  Frecuencia:Frecuencia}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				}
			/***********************************************************************/
		}	
	function DeleteExprecion(Danza,regristo_id){
		var Estudiante_id  = $('#Estudiante_id').val();
			/********************************************************************/
				if($('#'+Danza).is(':checked')===false){
					/**************************************/
						var CodigoEstado = 200;
					/**************************************/
					}
				if($('#'+Danza).is(':checked')===true){
					/**************************************/
						var CodigoEstado = 100;
					/**************************************/
					}	
					
				var Dato = $('#'+regristo_id).val();		
				
				if($.trim($('#'+regristo_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'DeleteDanza',registro_id:Dato,
																Estudiante_id:Estudiante_id,
																CodigoEstado:CodigoEstado}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				
			/***********************************************************************/
		}	
	function ModificarExprecion(Danza,registro_id,Frecuencia){
			/***********************************************************************/
				var Estudiante_id  = $('#Estudiante_id').val();
				
				if($('#'+Danza).is(':checked')===true){
				
				var  Dato    = $('#'+registro_id).val();
				
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'ModificaDanza',registro_id:Dato,
																  Estudiante_id:Estudiante_id,
																  Frecuencia:Frecuencia}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				}
			/***********************************************************************/
		}
	function DeleteEscenica(Escena,regristo_id){
		
		var Estudiante_id  = $('#Estudiante_id').val();
			/********************************************************************/
				if($('#'+Escena).is(':checked')===false){
					/**************************************/
						var CodigoEstado = 200;
					/**************************************/
					}
				if($('#'+Escena).is(':checked')===true){
					/**************************************/
						var CodigoEstado = 100;
					/**************************************/
					}	
					
				var Dato = $('#'+regristo_id).val();		
				
				if($.trim($('#'+regristo_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'DeleteEscena',registro_id:Dato,
																Estudiante_id:Estudiante_id,
																CodigoEstado:CodigoEstado}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				
			/***********************************************************************/
		}	
	function ModificarEscenica(Escena,registro_id,Frecuencia){
			/***********************************************************************/
				var Estudiante_id  = $('#Estudiante_id').val();
				
				if($('#'+Escena).is(':checked')===true){
				
				var  Dato    = $('#'+registro_id).val();
				
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'ModificaEscena',registro_id:Dato,
																  Estudiante_id:Estudiante_id,
																  Frecuencia:Frecuencia}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				}
			/***********************************************************************/
		}
	function DeleteLirico(Lirico,regristo_id){
		
		var Estudiante_id  = $('#Estudiante_id').val();
			/********************************************************************/
				if($('#'+Lirico).is(':checked')===false){
					/**************************************/
						var CodigoEstado = 200;
					/**************************************/
					}
				if($('#'+Lirico).is(':checked')===true){
					/**************************************/
						var CodigoEstado = 100;
					/**************************************/
					}	
					
				var Dato = $('#'+regristo_id).val();		
				
				if($.trim($('#'+regristo_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'DeleteLirico',registro_id:Dato,
																Estudiante_id:Estudiante_id,
																CodigoEstado:CodigoEstado}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				
			/***********************************************************************/
		}
	function ModificaLirico(Lirico,registro_id,Frecuencia){
			/***********************************************************************/
				var Estudiante_id  = $('#Estudiante_id').val();
				
				if($('#'+Lirico).is(':checked')===true){
				
				var  Dato    = $('#'+registro_id).val();
				
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'ModificaLirica',registro_id:Dato,
																  Estudiante_id:Estudiante_id,
																  Frecuencia:Frecuencia}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				}
			/***********************************************************************/
		}
	function DeletePlastica(Plastico,regristo_id){
		
		var Estudiante_id  = $('#Estudiante_id').val();
			/********************************************************************/
				if($('#'+Plastico).is(':checked')===false){
					/**************************************/
						var CodigoEstado = 200;
					/**************************************/
					}
				if($('#'+Plastico).is(':checked')===true){
					/**************************************/
						var CodigoEstado = 100;
					/**************************************/
					}	
					
				var Dato = $('#'+regristo_id).val();		
				
				if($.trim($('#'+regristo_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'DeletePlastico',registro_id:Dato,
																Estudiante_id:Estudiante_id,
																CodigoEstado:CodigoEstado}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				
			/***********************************************************************/
		}	
	function ModificarPlastica(Plastico,registro_id,Frecuencia){
			/***********************************************************************/
				var Estudiante_id  = $('#Estudiante_id').val();
				
				if($('#'+Plastico).is(':checked')===true){
				
				var  Dato    = $('#'+registro_id).val();
				
				if($.trim($('#'+registro_id).val())){
					/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'ModificaPlastico',registro_id:Dato,
																  Estudiante_id:Estudiante_id,
																  Frecuencia:Frecuencia}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
					}
				}
			/***********************************************************************/
		}							
	function SaveGeneral(){
		/********************************************************************************/
			
			
			/********************************************************************************/
				
				
			/********************************************************************************/
			/**************************InformacionAdicional*************************************/
					
			
			
			var IndexPadre  = $('#IndexPadre').val();
			
			var ContadorMedios = 0;
			var ContadorHijos = 0;
			
			for(P=0;P<IndexPadre;P++){
					var IndexHijo  = $('#IndexHijo_'+P).val();
					
					for(H=0;H<IndexHijo;H++){
						
							if($('#Medio_'+P+'_'+H).is(':checked')===false){
									
									
									ContadorMedios =  parseFloat(ContadorMedios)+1;
									
								}
						
						}
					
					ContadorHijos = parseFloat(ContadorHijos)+parseFloat(IndexHijo);	
					
				}
		
				
			
		//orale...aca		
		/**************************InformacionPersonal*************************************/
		
		
		
		
		/**************************InformacionPersonal*************************************/
        
        
            if($('#EstadoGeneral').val()==0 || $('#EstadoGeneral').val()=='0'){
                ValidaGeneral();
                var Estudiante_id = $('#Estudiante_id').val();
                /*****************************/		
    			Save_Tab1(Estudiante_id,1);  
    			/*****************************/
                $('#EstadoGeneral').val('1');
            }//if
        
        
            if($('#EstadoAcademico').val()==0 || $('#EstadoAcademico').val()=='0'){
                ValidaAcademica();
                var Estudiante_id = $('#Estudiante_id').val();
                /*****************************/		
    			Save_Tab1(Estudiante_id,2);
    			/*****************************/
                $('#EstadoAcademico').val('1');
            }//if
        
        
        
            if($('#EstadoPersonal').val()==0 || $('#EstadoPersonal').val()=='0'){
                ValidadPersonal();
                var Estudiante_id = $('#Estudiante_id').val();
                /*****************************/		
    			Save_Tab1(Estudiante_id,4);
    			/*****************************/
                $('#EstadoPersonal').val('1');
            }//if
        
				
			/*****************************/		
			//Save_Tab1(Estudiante_id,1);  
			/*****************************/
			/*****************************/		
			//Save_Tab1(Estudiante_id,2);
			/*****************************/
			/*****************************/		
			//Save_Tab1(Estudiante_id,3);
			/*****************************/	
			/*****************************/		
			//Save_Tab1(Estudiante_id,4);
			/*****************************/	
			
			
			Siguiente();
					
		/********************************************************************************/
		}	
	function GuardarFinal(){
			
			if($('#Trab_Si').is(':checked')===false  && $('#Trab_No').is(':checked')===false){
					alert('Selecione una de las Opciones a la Pregunta...\n Trabaja Actualmente');
					return false;
				}
			
			if($('#Trab_Si').is(':checked')){
					if($('#Empl_Si').is(':checked')===false  && $('#Ind_Si').is(':checked')===false){
							alert('Selecione una Opcion a la Pregunta... \n Tipo de Contrato ');
							return false;
						}
					if($('#Relacion_Si').is(':checked')===false  && $('#Relacion_No').is(':checked')===false){
							alert('Selecione una de las Opciones a la Pregunta... \n Su trabajo está Relacionado con la Carrera');
							return false;
						}
					if($('#Propia').is(':checked')===false  && $('#Familiar').is(':checked')===false  && $('#Externa').is(':checked')===false){
							alert('Selecione una de las Opciones a la Pregunta... \n La empresa en la que trabaja es:');
							return false;
						}		
				}		
			/********************************************************************************/
				if($('#Trab_Si').is(':checked')){
						var Trabaja  = 0;
						/***************************************/
							if($('#Empl_Si').is(':checked')){
									var tipo_Contrato = 0; 
								}
							if($('#Ind_Si').is(':checked')){
									var tipo_Contrato = 1; 
								}
							if($('#Relacion_Si').is(':checked')){
									var Relacion_Trabajo =  0;
								}
							if($('#Relacion_No').is(':checked')){
									var Relacion_Trabajo =  1;
								}	
							if($('#Propia').is(':checked')){
									var tipoEmpresa = 1;
								}
							if($('#Familiar').is(':checked')){
									var tipoEmpresa = 2;
								}
							if($('#Externa').is(':checked')){
									var tipoEmpresa = 3;
								}				
						/***************************************/
					}
				if($('#Trab_No').is(':checked')){
						var Trabaja  = 1;
						var tipo_Contrato = '';
						var Relacion_Trabajo =  '';
						var tipoEmpresa = '';
					}
			/**********************************************************************************/		
				if($('#Si_RedInternacional').is(':checked')===false  && $('#No_RedInternacional').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Experiencias académicas con redes internacionales - En otros paises');
						return false;
					}		
				if($('#Si_RedInternacional').is(':checked')){
						if(!$.trim($('#Nom_RedInter').val())){
								alert('Ingrese el Nombre de la Red Internacional');
								return false;
							}
						if(!$.trim($('#Pais_Inter').val())){
								alert('Ingrese el Pais de la Red Internacional');
								return false;
							}
						if(!$.trim($('#Ciudad_Inter').val())){
								alert('Ingrese la Ciudad de la Red Internacional');
								return false;
							}		
						if(!$.trim($('#FechaInicoRed').val())){
								alert('Ingrese la Fecha Inicial de la Red Internacional');
								return false;
							}
						if(!$.trim($('#FechaFinred').val())){
								alert('Ingrese la Fecha Inicial de la Red Internacional');
								return false;
							}		
					}
					
				if($('#Si_RedVirtual').is(':checked')===false  && $('#No_RedVirtual').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Experiencias académicas con redes internacionales - Virtuales');
						return false;
					}		
				if($('#Si_RedVirtual').is(':checked')){
						if(!$.trim($('#Nom_RedVirtual').val())){
								alert('Ingrese el Nombre de la Red Internacional Virtuales');
								return false;
							}
						if(!$.trim($('#Pais_Virtual').val())){
								alert('Ingrese el Pais de la Red Internacional Virtuales');
								return false;
							}
						if(!$.trim($('#Ciudad_Virtual').val())){
								alert('Ingrese la Ciudad de la Red Internacional Virtuales');
								return false;
							}		
						if(!$.trim($('#FechaInicoVirtual').val())){
								alert('Ingrese la Fecha Inicial de la Red Internacional Virtuales');
								return false;
							}
						if(!$.trim($('#FechaFinVirtual').val())){
								alert('Ingrese la Fecha Inicial de la Red Internacional Virtuales');
								return false;
							}		
					}
					
				if($('#Si_CursoLocal').is(':checked')===false  && $('#No_CursoLocal').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Cursos tomados en otras universidades locales (Bogota)');
						return false;
					}
					
				if($('#Si_CursoLocal').is(':checked')){
						if(!$.trim($('#Nom_Universidad').val())){
								alert('Ingrese el Nombre de la Universidad - Bogota');
								return false;
							}
						if(!$.trim($('#Nom_Curso').val())){
								alert('Ingrese el Nombre del Curso - Bogota');
								return false;
							}
								
						if(!$.trim($('#FechaInicoCurso').val())){
								alert('Ingrese la Fecha Inicial del Curso - Bogota');
								return false;
							}
						if(!$.trim($('#FechaFinCurso').val())){
								alert('Ingrese la Fecha Inicial del Curso - Bogota');
								return false;
							}		
					}
					
				if($('#Si_CursoNacional').is(':checked')===false  && $('#No_CursoNacional').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Cursos tomados en otra universidad del pais');
						return false;
					}
					
				if($('#Si_CursoNacional').is(':checked')){
						if(!$.trim($('#Nom_UniversidadOtra').val())){
								alert('Ingrese el Nombre de la Universidad - Nivel Nacional');
								return false;
							}
						if(!$.trim($('#Nom_OtroCurso').val())){
								alert('Ingrese el Nombre del Curso - Nivel Nacional');
								return false;
							}
								
						if(!$.trim($('#FechaInicoOtroCurso').val())){
								alert('Ingrese la Fecha Inicial del Curso - Nivel Nacional');
								return false;
							}
						if(!$.trim($('#FechaFinOtroCurso').val())){
								alert('Ingrese la Fecha Inicial del Curso - Nivel Nacional');
								return false;
							}		
					}
					
				if($('#Si_CursoInternacional').is(':checked')===false  && $('#No_CursoInternacional').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Cursos tomados en universidades extranjeras');
						return false;
					}	
					
				if($('#Si_CursoInternacional').is(':checked')){
						if($('#C_Inter_Uno').is(':checked')===false  && $('#C_Inter_Dos').is(':checked')===false  && $('#C_Inter_Tres').is(':checked')===false && $('#C_Inter_Cuatro').is(':checked')===false){
								alert('Selecione una de las Opciones de la Frecuencia Relacionada con los Cursos tomados en universidades extranjeras');
								return false;
							}
					}
					
				if($('#Si_UJoinUs').is(':checked')===false  && $('#No_UJoinUs').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Ha usado la plataforma UJoinUs');
						return false;
					}	
					
				if($('#Si_UJoinUs').is(':checked')){
						if($('#UJoinUs_Uno').is(':checked')===false  && $('#UJoinUs_Dos').is(':checked')===false  && $('#UJoinUs_Tres').is(':checked')===false && $('#UJoinUs_Cuatro').is(':checked')===false){
								alert('Selecione una de las Opciones de la Frecuencia Relacionada con Ha usado la plataforma UJoinUs');
								return false;
							}
					}
					
				if($('#Si_Collaborate').is(':checked')===false  && $('#No_Collaborate').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Ha usado la Plataforma Blackboard Collaborate');
						return false;
					}	
					
				if($('#Si_Collaborate').is(':checked')){
						if($('#Collaborate_Uno').is(':checked')===false  && $('#Collaborate_Dos').is(':checked')===false  && $('#Collaborate_Tres').is(':checked')===false && $('#Collaborate_Cuatro').is(':checked')===false){
								alert('Selecione una de las Opciones de la Frecuencia Relacionada con Ha usado la Plataforma Blackboard Collaborate');
								return false;
							}
					}
					
				if($('#Si_Sittio').is(':checked')===false  && $('#No_Sittio').is(':checked')===false){
						alert('Selecione una de las Opciones a la Pregunta ...\n Ha usado la Plataforma Blackboard Collaborate');
						return false;
					}	
					
				if($('#Si_Sittio').is(':checked')){
						if($('#Sittio_Uno').is(':checked')===false  && $('#Sittio_Dos').is(':checked')===false  && $('#Sittio_Tres').is(':checked')===false && $('#Sittio_Cuatro').is(':checked')===false){
								alert('Selecione una de las Opciones de la Frecuencia Relacionada con Ha usado la Plataforma Blackboard Collaborate');
								return false;
							}
					}			
			/********************************Captura de datos*************************************************/								
			if($('#Si_RedInternacional').is(':checked')){
					var  RedInternacional = 0;
						
						var Nom_RedInter = $('#Nom_RedInter').val();
						
						var Pais_Inter = $('#Pais_Inter').val();
						
						var Ciudad_Inter = $('#Ciudad_Inter').val();
							
						var FechaInicoRed = $('#FechaInicoRed').val();
						
						var FechaFinred = $('#FechaFinred').val();		
					}
				
				if($('#No_RedInternacional').is(':checked')){
					var  RedInternacional = 1;
						
						var Nom_RedInter = '';
						
						var Pais_Inter = '';
						
						var Ciudad_Inter = '';
							
						var FechaInicoRed = '';
						
						var FechaFinred = '';		
					}
					
				if($('#Si_RedVirtual').is(':checked')){
					
					var  RedVirtual = 0;
						
						var Nom_RedVirtual = $('#Nom_RedVirtual').val();
						
						var Pais_Virtual = $('#Pais_Virtual').val();
						
						var Ciudad_Virtual = $('#Ciudad_Virtual').val();
							
						var FechaInicoVirtual = $('#FechaInicoVirtual').val();
						
						var FechaFinVirtual = $('#FechaFinVirtual').val();	
					}	
				if($('#No_RedVirtual').is(':checked')){
					var  RedVirtual = 1;
						
						var Nom_RedVirtual = '';
						
						var Pais_Virtual = '';
						
						var Ciudad_Virtual = '';
							
						var FechaInicoVirtual = '';
						
						var FechaFinVirtual = '';		
					}
					
				if($('#Si_CursoLocal').is(':checked')){
					var  CursoLocal = 0;
						
						var Nom_Universidad = $('#Nom_Universidad').val();
						
						var Nom_Curso = $('#Nom_Curso').val();
						
						var FechaInicoCurso = $('#FechaInicoCurso').val();
							
						var FechaFinCurso = $('#FechaFinCurso').val();
					}	
				
				if($('#No_CursoLocal').is(':checked')){
					var  CursoLocal = 1;
						
						var Nom_Universidad = '';
						
						var Nom_Curso = '';
						
						var FechaInicoCurso = '';
							
						var FechaFinCurso = '';
								
					}		
					
					
				if($('#Si_CursoNacional').is(':checked')){
					
					var  CursoNacional = 0;
						
						var Nom_UniversidadOtra = $('#Nom_UniversidadOtra').val();
						
						var Nom_OtroCurso = $('#Nom_OtroCurso').val();
						
						var FechaInicoOtroCurso = $('#FechaInicoOtroCurso').val();
							
						var FechaFinOtroCurso = $('#FechaFinOtroCurso').val();
							
					}	
					
				if($('#No_CursoNacional').is(':checked')){
					var  CursoNacional = 1;
						
						var Nom_UniversidadOtra = '';
						
						var Nom_OtroCurso = '';
						
						var FechaInicoOtroCurso = '';
							
						var FechaFinOtroCurso = '';
								
					}
					
				if($('#Si_CursoInternacional').is(':checked')){
					
					var  CursoInternacional = 0;
					
						
						if($('#C_Inter_Uno').is(':checked')){
								var Fre_inter = 1;
							}
						if($('#C_Inter_Dos').is(':checked')){
								var Fre_inter = 2;
							}
						if($('#C_Inter_Tres').is(':checked')){
								var Fre_inter = 3;
							}
						if($('#C_Inter_Cuatro').is(':checked')){
								var Fre_inter = 4;
							}				
							
					}
				
				if($('#No_CursoInternacional').is(':checked')){
					
					var  CursoInternacional = 1;
					var Fre_inter = 0;
					}
				
				
					
				if($('#Si_UJoinUs').is(':checked')){
					
					var  UJoinUs = 0;
					
						
						if($('#UJoinUs_Uno').is(':checked')){
								var Fre_UJoinUs = 1;
							}
						if($('#UJoinUs_Dos').is(':checked')){
								var Fre_UJoinUs = 2;
							}
						if($('#UJoinUs_Tres').is(':checked')){
								var Fre_UJoinUs = 3;
							}
						if($('#UJoinUs_Cuatro').is(':checked')){
								var Fre_UJoinUs = 4;
							}				
							
					}
				
				if($('#No_UJoinUs').is(':checked')){
					
					var  UJoinUs = 1;
					var Fre_UJoinUs = 0;
					}
				
					
				if($('#Si_Collaborate').is(':checked')){
					
					var  Collaborate = 0;
					
						
						if($('#Collaborate_Uno').is(':checked')){
								var Fre_Collaborate = 1;
							}
						if($('#Collaborate_Dos').is(':checked')){
								var Fre_Collaborate = 2;
							}
						if($('#Collaborate_Tres').is(':checked')){
								var Fre_Collaborate = 3;
							}
						if($('#Collaborate_Cuatro').is(':checked')){
								var Fre_Collaborate = 4;
							}				
							
					}
				
				if($('#No_Collaborate').is(':checked')){
					
					var  Collaborate = 1;
					var Fre_Collaborate = 0;
					}		
					
					
				
					
				if($('#Si_Sittio').is(':checked')){
					
					var  Sittio = 0;
					
						
						if($('#Sittio_Uno').is(':checked')){
								var Fre_Sittio = 1;
							}
						if($('#Sittio_Dos').is(':checked')){
								var Fre_Sittio = 2;
							}
						if($('#Sittio_Tres').is(':checked')){
								var Fre_Sittio = 3;
							}
						if($('#Sittio_Cuatro').is(':checked')){
								var Fre_Sittio = 4;
							}				
							
					}
				
				if($('#No_Sittio').is(':checked')){
					
					var  Sittio = 1;
					var Fre_Sittio = 0;
					}			
				
					
			/********************************************************************************/
			var Estudiante_id  = $('#Estudiante_id').val();
			/*********************************AJAX****************************************************/
						$.ajax({//Ajax
							   type: 'GET',
							   url: 'Hoja_Vida.html.php',
							   async: false,
							   dataType: 'json',
							   data:({actionID: 'SaveFinal',Estudiante_id:Estudiante_id,
							   								Trabaja:Trabaja,
															tipo_Contrato:tipo_Contrato,
															Relacion_Trabajo:Relacion_Trabajo,
															tipoEmpresa:tipoEmpresa,
															RedInternacional:RedInternacional,
															Nom_RedInter:Nom_RedInter,
															Pais_Inter:Pais_Inter,
															Ciudad_Inter:Ciudad_Inter,
															FechaInicoRed:FechaInicoRed,
															FechaFinred:FechaFinred,
															RedVirtual:RedVirtual,
															Nom_RedVirtual:Nom_RedVirtual,
															Pais_Virtual:Pais_Virtual,
															Ciudad_Virtual:Ciudad_Virtual,
															FechaInicoVirtual:FechaInicoVirtual,
															FechaFinVirtual:FechaFinVirtual,
															CursoLocal:CursoLocal,
															Nom_Universidad:Nom_Universidad,
															Nom_Curso:Nom_Curso,
															FechaInicoCurso:FechaInicoCurso,
															FechaFinCurso:FechaFinCurso,
															CursoNacional:CursoNacional,
															Nom_UniversidadOtra:Nom_UniversidadOtra,
															Nom_OtroCurso:Nom_OtroCurso,
															FechaInicoOtroCurso:FechaInicoOtroCurso,
															FechaFinOtroCurso:FechaFinOtroCurso,
															CursoInternacional:CursoInternacional,
															Fre_inter:Fre_inter,
															UJoinUs:UJoinUs,
															Fre_UJoinUs:Fre_UJoinUs,
															Collaborate:Collaborate,
															Fre_Collaborate:Fre_Collaborate,
															Sittio:Sittio,
															Fre_Sittio:Fre_Sittio}),
							   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
							   success: function(data){
											if(data.val=='FALSE'){
													alert(data.descrip);
													return false;
												}else{
														alert('Se Ha Guardado Correctamente.');
														$('#SaveGenral').attr('disabled',true);
														/*location.href=' ../../../consulta/autoevaluacion/encuesta.php?idusuario='+Estudiante_id;
														/*location.href ='../../../consulta/encuesta/encuestaestudiantesnuevos/validaingresoestudiante.php?idencuesta=50&idusuario='+Estudiante_id+'&codigotipousuario=600';*/
														//window.location.href='../../../consulta/prematricula/matriculaautomaticaordenmatricula.php';*/
														location.href = 'Hoja_Vida.html.php?actionID=Dirrecto';
													}
							   } 
						}); //AJAX
					/*******************************FIN***AJAX************************************************/	
		}	
	function autocompletCiudadOrigen(){
		/********************************************************/	
			$('#CiudadOrigen').autocomplete({
					
					source: "Hoja_Vida.html.php?actionID=AutoCompletarCiudad",
					minLength: 2,
					select: function( event, ui ) {
						
						$('#id_CiudadOrigen').val(ui.item.id_Ciudad);
						
						}
					
				});//LugarNaci
		/********************************************************/
		}	
	function FormatOrigen(){
			$('#CiudadOrigen').val('');
			$('#id_CiudadOrigen').val('');
		}	
	function Ver_CualRecurso(id,text){
			if(id==8 || id =='8'){
				if($('#'+text).is(':checked')){
						$('#Tr_Cual_'+id).css('visibility','visible');
						$('#Tr_Cual2_'+id).css('visibility','visible');
					}else{
							$('#Tr_Cual_'+id).css('visibility','collapse');
							$('#Tr_Cual2_'+id).css('visibility','collapse');
						}
					
				}	
					
		}
	function VerOtrosEstudiosRealizados(){
			if($('#Estudios_si').is(':checked')){
					$('#Tr_OtrosEstudiosCajas_1').css('visibility','visible');
					$('#Tr_OtrosEstudiosCajas_2').css('visibility','visible');
					$('#Tr_OtrosEstudiosCajas_3').css('visibility','visible');
					$('#Tr_OtrosEstudiosCajas_4').css('visibility','visible');
					$('#Tr_OtrosEstudiosCajas_5').css('visibility','visible');
					$('#Tr_OtrosEstudiosCajas_6').css('visibility','visible');
				}else{
					$('#Tr_OtrosEstudiosCajas_1').css('visibility','collapse');
					$('#Tr_OtrosEstudiosCajas_2').css('visibility','collapse');
					$('#Tr_OtrosEstudiosCajas_3').css('visibility','collapse');
					$('#Tr_OtrosEstudiosCajas_4').css('visibility','collapse');
					$('#Tr_OtrosEstudiosCajas_5').css('visibility','collapse');
					$('#Tr_OtrosEstudiosCajas_6').css('visibility','collapse');
					}
		}	
	function Ver_RedInternacional(){
			if($('#Si_RedInternacional').is(':checked')){
					$('#Tr_RedInternacional').css('visibility','visible');
				}else{
					$('#Tr_RedInternacional').css('visibility','collapse');	
					}
		}
	function Ver_RedVirtual(){
			if($('#Si_RedVirtual').is(':checked')){
					$('#Tr_RedVirtual').css('visibility','visible');
				}else{
					$('#Tr_RedVirtual').css('visibility','collapse');	
					}
		}
	function isNumberKey(evt)
{
	var e = evt; 
	var charCode = (e.which) ? e.which : e.keyCode
        console.log(charCode);
        
        //el comentado me acepta negativos
	//if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
        if( charCode > 31 && (charCode < 48 || charCode > 57) ){
            //si no es - ni borrar
            if((charCode!=8 && charCode!=45)){
                return false;
            }
        }

	return true;

}

	function EdaNew(){
		
		var dato = $('#FechaNaci').val();
		
		$.ajax({//Ajax
				   type: 'GET',
				   url: 'Hoja_Vida.html.php',
				   async: false,
				   //dataType: 'json',
				   data:({actionID: 'EdadValor',dato:dato}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
					   
					   		$('#Edad').val(data)()	
				   } 
			}); //AJAX
		}
function ExitoEstudiantil(Estudiante_id){
	/********************Exito Estudiantil*****************************/	
			if($('#Si_Pae').is(':checked')){
				var pae = 0;
				/*********Por Que Razones...**************************/	
					var Academicas 		= $('#Academicas_PAE').val();
					var psicosociales 	= $('#psicosociales_PAE').val();
					var economicas		= $('#economicas_PAE').val();
					var Competencias	= $('#Competencias_PAE').val();
				/*****************************************************/	
				}
			if($('#No_Pae').is(':checked')){
				var pae = 1;
					var Academicas 		= '';
					var psicosociales 	= '';
					var economicas		= '';
					var Competencias	= '';
				
				}
			/*********************ESCALAS*************************************/
			
				var independecia		= $('#independecia').val();
				
				if(independecia=='-1' || independecia==-1){
						alert('Califique Manejo de la independencia y autonomia ');
						return false;
					}
					
				var Metodos				= $('#Metodos').val();	
				
				if(Metodos==-1 || Metodos=='-1'){
						alert('Califique Metodos, tecnicas y habitos de estudio');
						return false;
					}
					
				var DistribuTiempo 		= $('#DistribuTiempo').val();	
				
				if(DistribuTiempo=='-1' || DistribuTiempo==-1){
						alert('Califique Manejo y distribucion del tiempo');
						return false;
					}
				
				var TrabEquipo 			= $('#TrabEquipo').val();	
				
				if(TrabEquipo=='-1' || TrabEquipo==-1){
						alert('Califique Trabajo en equipo');
						return false;
					}
					
				var Socializacion		= $('#Socializacion').val();
				
				if(Socializacion=='-1' || Socializacion==-1){
						alert('Califique Socializacion');
						return false;
					}	
					
				var PrioriActividades	= $('#PrioriActividades').val();	
				
				if(PrioriActividades=='-1' || PrioriActividades==-1){
						alert('Califique Priorizacion de actividades');
						return false;
					}
					
				var InterFamilia 		= $('#InterFamilia').val();	
				
				if(InterFamilia=='-1' || InterFamilia==-1){
						alert('Califique Cambios al interior de la familia');
						return false;
					}
				
				var CompLectura 		= $('#CompLectura').val();	
				
				if(CompLectura=='-1' || CompLectura==-1){
						alert('Califique Comprensión de lectura');
						return false;
					}
				
				var conflictos			= $('#conflictos').val();	
				
				if(conflictos=='-1' || conflictos==-1){
						alert('Califique Manejo de conflictos');
						return false;
					}
					
				var Cual_Adaptacion = $('#Cual_Adaptacion').val();	
				var OtroEscala      = $('#OtroEscala').val();
			/***************************************************************/	
				
				if(!$('#Lo_evade').is(':checked') && !$('#Lo_afronta').is(':checked') && !$('#Se_agrede').is(':checked') && !$('#enfermarse').is(':checked') && !$('#Se_desquita').is(':checked') && !$('#Se_deprime').is(':checked') && !$('#Ansieda').is(':checked') && !('#Otro_Problema').is(':checked')){
					
						alert('Selecione una Opcion de la Pregunta \n Cuál de las siguientes opciones describe mejor la forma en que el estudiante reacciona cuando tiene un problema');
						return false;
					
					}
				
				if($('#Lo_evade').is(':checked')){
					
						var ReacionProblema	= 0;//Si
						var Cual_Problema   ='';
					
					}
				
				if($('#Lo_afronta').is(':checked')){
					
						var ReacionProblema	= 1;//Si
						var Cual_Problema   ='';
						
					}	
				
				if($('#Se_agrede').is(':checked')){
					
						var ReacionProblema	= 2;//Si
						var Cual_Problema   ='';
					
					}	
				
				if($('#enfermarse').is(':checked')){
						
						var ReacionProblema	= 3;//Si
						var Cual_Problema   ='';
						
					}
					
				if($('#Se_desquita').is(':checked')){
					
						var ReacionProblema	= 4;//Si
						var Cual_Problema   ='';
					
					}	
					
				if($('#Se_deprime').is(':checked')){
						
						var ReacionProblema	= 5;//Si
						var Cual_Problema   ='';
						
					}	
				
				if($('#Ansieda').is(':checked')){
					
						var ReacionProblema	= 6;//Si
						var Cual_Problema   ='';
					
					}
					
				if($('#Otro_Problema').is(':checked')){
						
						var ReacionProblema	= 7;//Si
						var Cual_Problema   = $('#Cual_Problema').val();
						
						if(!$.trim($('#Cual_Problema').val())){
								alert('Describa Cual');
								return false;
							}
						
					}		
					
			if(!$.trim($('#Padre_Por').val()) && !$.trim($('#Madre_Por').val()) && !$.trim($('#Hermano_Por').val()) && !$.trim($('#Hermana_Por').val()) && !$.trim($('#Amigos_Por').val()) && !$.trim($('#Pareja_Por').val())){
						
						alert('Describa \n Indique el grado de apoyo que representa para el estudiante cada una de las siguientes personas');
						return false;
						
				}		
			
			var Padre_Por 		= $('#Padre_Por').val();
			var Padre_Descri 	= $('#Padre_Descri').val();
			
			var Madre_Por		= $('#Madre_Por').val();
			var Madre_Descri	= $('#Madre_Descri').val();
			
			var Hermano_Por		= $('#Hermano_Por').val();
			var Hermano_Descri	= $('#Hermano_Descri').val();
			
			var Hermana_Por		= $('#Hermana_Por').val();
			var Hermana_Descri	= $('#Hermana_Descri').val();
			
			var Amigos_Por		= $('#Amigos_Por').val();
			var Amigos_Descri	= $('#Amigos_Descri').val();
			
			var Pareja_Por		= $('#Pareja_Por').val();
			var Pareja_Descri	= $('#Pareja_Descri').val();
			
		/**************************Ajax********************************/	
			 $.ajax({//Ajax
				      type: 'GET',
				      url: 'Hoja_Vida.html.php',
				      async: false,
				      dataType: 'json',
				      data:({actionID: 'Save_Admin',pae:pae,
					  								Academicas:Academicas,
													psicosociales:psicosociales,
													economicas:economicas,
													Competencias:Competencias,
													independecia:independecia,
													Metodos:Metodos,
													DistribuTiempo:DistribuTiempo,
													TrabEquipo:TrabEquipo,
													Socializacion:Socializacion,
													PrioriActividades:PrioriActividades,
													InterFamilia:InterFamilia,
													CompLectura:CompLectura,
													conflictos:conflictos,
													Cual_Adaptacion:Cual_Adaptacion,
													OtroEscala:OtroEscala,
													ReacionProblema:ReacionProblema,
													Cual_Problema:Cual_Problema,
													Padre_Por:Padre_Por,
													Padre_Descri:Padre_Descri,
													Madre_Por:Madre_Por,
													Madre_Descri:Madre_Descri,
													Hermano_Por:Hermano_Por,
													Hermano_Descri:Hermano_Descri,
													Hermana_Por:Hermana_Por,
													Hermana_Descri:Hermana_Descri,
													Amigos_Por:Amigos_Por,
													Amigos_Descri:Amigos_Descri,
													Pareja_Por:Pareja_Por,
													Pareja_Descri:Pareja_Descri,
													Estudiante_id:Estudiante_id,
													ExitoEstudianti:1}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										alert('Se Ha Guardado Correctamente...');
										$('#SaveGenral').css('display','none');
										//location.href='HojaVidaEstudiante.php';
									/**********************************************/	
									}
				   } 
			}); //AJAX
		/*************************Fin AJAx*****************************/
	}
function Bienestar(Estudiante_id){  
	/****************************BienestarUniversitario**************************************/
		var PermisoUsuario	= $('#PermisoUsuario').val();
		var P_General		= $('#P_General').val();
		var id_Bienestar	= $('#id_Bienestar').val();
		
		if(P_General==-1 || P_General=='-1'){
			/********************************/
			alert('Debe Selecionar Un Periodo');
			$('#P_General').effect("pulsate", {times:3}, 500);
			$('#P_General').css('border-color','#F00');
			return false;
			/********************************/
			}
		//**************************************Permiso usuario Deporte************************//	
		/***************************Primera Pregunta*********************************************/
		if(PermisoUsuario==1 || PermisoUsuario=='1'){
			/*******************************************************/
			if($('#Si_Selec').is(':checked')==false && $('#No_Selec').is(':checked')==false){
					
				alert('Selecione una de las Opciones a la pregunta...\n Participación en selecciones de la Universidad ');
				return false;
			}
			/*******************************************************/
			
			/*******************************************************/
				if($('#Si_Selec').is(':checked')){
					/***********************************************/
					var Selecion_U = 0;
					
						var F_ini	= $('#Perido_inicial_Seleccion').val();
						var F_fin	= $('#Perido_Final_Seleccion').val();
						
						if(F_ini==-1 || F_ini=='-1'){
							/********************************/
							alert('Debe Selecionar Un Periodo Inicial');
							$('#Perido_inicial_Seleccion').effect("pulsate", {times:3}, 500);
							$('#Perido_inicial_Seleccion').css('border-color','#F00');
							return false;
							/********************************/
							}
							
						var index_SL	= $('#index_SL').val();	
						
						for(i=0;i<index_SL;i++){
							/***************************************/
							
							if($('#'+i+'_Selec').is(':checked')){
								/************************************/
								$('#Cadena').val($('#'+i+'_Selec').val());
								/************************************/
								}//if
							/***************************************/
							}//for
						var DatoSeleccion	= $('#Cadena').val();	
					/***********************************************/
					}else{
						var Selecion_U  	= 1;
						var F_ini			='';
						var F_fin			='';
						var DatoSeleccion	=0;
						}//if
					
					if($('#Si_Selec').is(':checked')){
						/***************************************************/
							if(!$.trim($('#Cadena').val())){
								alert('Selecione un Tipo de Seleccion de la Pregunta ....\n Participación en selecciones de la Universidad');
								return false;
								}
						/***************************************************/
						}
						
						
				/**********************Segunda Pregunta****************************************************/		
				if($('#Si_Apoyo').is(':checked')==false && $('#No_Apoyo').is(':checked')==false){
					
					alert('Seleccione una de las Opciones de la Pregunta...\n Participación en competencias con apoyo de la Universidad');
					return false;
				}
			/*******************************************************/
				if($('#Si_Apoyo').is(':checked')){
					/************************************************/
					var Competencias_U = 0;
					
					var F_ini_Ap	= $('#Perido_ini_Apoyo').val();
					var F_fin_Ap	= $('#Perido_Fin_Apoyo').val();
					
					if(F_ini_Ap==-1 || F_ini_Ap=='-1'){
						/********************************/
						alert('Debe Selecionar Un Periodo Inicial');
						$('#Perido_ini_Apoyo').effect("pulsate", {times:3}, 500);
						$('#Perido_ini_Apoyo').css('border-color','#F00');
						return false;
						/********************************/
						}
						
					var indexAp	= $('#indexAp').val();	
					
						for(i=0;i<indexAp;i++){
							/***************************************/
							
							if($('#'+i+'_Apoyo').is(':checked')){
								/************************************/
								$('#CadeanaAp').val($('#'+i+'_Apoyo').val());
								/************************************/
								}//if
							/***************************************/
							}//for
						var DatoApoyo	= $('#CadeanaAp').val();
							
					/************************************************/
					}else{
						/*********************************************/
						var Competencias_U = 1;
						var F_ini_Ap	= '';
						var F_fin_Ap	= '';
						var DatoApoyo	=0;
						/*********************************************/
						}
			/*********************************************************/						
			if($('#Si_Apoyo').is(':checked')){
				
				if(!$.trim($('#CadeanaAp').val())){
						alert('Selecione Un Tipo de Competecia Patrocian o Con apoyo de la Universidad');
						return false;
					}
			}
			/*******************************Tercera Pregunta****************************************/
			if($('#Si_Talleres').is(':checked')==false && $('#No_Talleres').is(':checked')==false){
				alert('Seleccione una Opcion a la Pregunta...\n Participacion en Talleres Formativos Deportivos');
				return false;
			}
				if($('#Si_Talleres').is(':checked')){
						var Talleres = 0;
						/**********************************************/
							
							$('#CadenaTll').val('');
							
							var indexTll	= $('#indexTll').val();
							
							for(i=0;i<indexTll;i++){
							/***************************************/
								if($('#'+i+'_Taller').is(':checked')){
									/************************************/
									var P_ini	= $('#P_ini_'+i).val();
									var P_Fin	= $('#P_fin_'+i).val();
									
									if(P_ini==-1 || P_ini=='-1'){
										/**********************/
										alert('Debe Selecionar Un Periodo Inicial');
										$('#P_ini_'+i).effect("pulsate", {times:3}, 500);
										$('#P_ini_'+i).css('border-color','#F00');
										return false;
										/**********************/
										}
									if(P_Fin==-1 || P_Fin=='-1'){
										/**********************/
										alert('Debe Selecionar Un Periodo Final');
										$('#P_fin_'+i).effect("pulsate", {times:3}, 500);
										$('#P_fin_'+i).css('border-color','#F00');
										return false;
										/**********************/
										}	
									if(!$.trim($('#id_tallerB_'+i).val())){	
									/************************************/
									$('#CadenaTll').val($('#CadenaTll').val()+'-'+$('#'+i+'_Taller').val()+'::'+P_ini+'::'+P_Fin);
									/************************************/
									}
								}//if
							/***************************************/
							}//for
							var DatoTaller	= $('#CadenaTll').val();
							//alert(DatoTaller);return false;
						/**********************************************/
					}else{
						/*********************************************/
						var Talleres    = 1;
						var DatoTaller	= '';
						/*********************************************/
						}
					if($('#Si_Talleres').is(':checked')){
						if(!$.trim($('#CadenaTll').val())){
								alert('Seleccione un Tipo de Taller Formativo');
								return false;
							}
					}	
			/***************************Cuarta Pregunta**********************************************/
				if($('#Si_LogroDepor').is(':checked')==false && $('#No_LogroDepor').is(':checked')==false){
						alert('Selecione uan De las Opciones de pal Pregunta...\n Logros Deportivos en representacion de la Universidad');
						return false;
					}	
				/****************************************/	
				if($('#Si_LogroDepor').is(':checked')){
						
						var LogroDeportivo = 0;
						
						var Cual_LogroDeportivo = $('#Cual_logroDeprot').val();
						
						var PeriodoLogroDeport	= $('#P_ini_LogroDeport').val();
					}else{
						var LogroDeportivo = 1;
						
						var Cual_LogroDeportivo = '';
						
						var PeriodoLogroDeport	= '';
						}
				
				if($('#Si_LogroDepor').is(':checked')){
						if(!$.trim($('#Cual_logroDeprot').val())){
								alert('Describa Cual Logro Deportivo');
								$('#Cual_logroDeprot').effect("pulsate", {times:3}, 500);
								$('#Cual_logroDeprot').css('border-color','#F00');
								return false;
							}
						if($('#P_ini_LogroDeport').val()==-1 || $('#P_ini_LogroDeport').val()=='-1'){
								alert('Selecione el Periodo del Logro Deportivo');
								$('#P_ini_LogroDeport').effect("pulsate", {times:3}, 500);
								$('#P_ini_LogroDeport').css('border-color','#F00');
								return false;
								
							}	
					}
			/***********************************Quinta Pregunta******************************************/
			if($('#Si_BecasEstimulos').is(':checked')==false && $('#No_BecasEstimulos').is(':checked')==false){
					alert('Selecione una Opcion en la Pregunta...\n Ha recibido Becas o Estímulos de Bienestar');
					return false;
				}	
				
				if($('#Si_BecasEstimulos').is(':checked')){
						var BecasEstimos = 0;
						
						var Cual_BecaEstimulo = $('#Cua_BecasEstimulos').val();
						
						var PeriodoBecasDeport	= $('#P_ini_BecasDeport').val();
					}else{
						var BecasEstimos = 1;
						
						var Cual_BecaEstimulo = '';
						
						var PeriodoBecasDeport	='';
						}		
				
				if($('#Si_BecasEstimulos').is(':checked')){
						if(!$.trim($('#Cua_BecasEstimulos').val())){
								alert('Describe Cual Tipo de Beca o Que Estimulo de Bienestar...');
								$('#Cua_BecasEstimulos').effect("pulsate", {times:3}, 500);
								$('#Cua_BecasEstimulos').css('border-color','#F00');
								return false;
							}
						if($('#P_ini_BecasDeport').val()==-1 || $('#P_ini_BecasDeport').val()=='-1'){
								alert('Seleccione el Peridod en el Cual Recibio la Beca por Deporte');
								$('#P_ini_BecasDeport').effect("pulsate", {times:3}, 500);
								$('#P_ini_BecasDeport').css('border-color','#F00');	
								return false;
									
							}
					}
			/******************************************Sexta Pregunta***************************************/
			if($('#Si_Gym').is(':checked')==false && $('#No_Gym').is(':checked')==false){
				alert('Selecione una Opcion de la Pregunta...\n Actualmente asiste a el Centro de Acondicionamiento Fisico');
				return false;
			}		
				if($('#Si_Gym').is(':checked')){
						
					var Gimnasio = 0;
					/*************************************************/
						if($('#Gym_Menos').is(':checked')){
								var Frecuenca_Gym = 0;
							}
					/*************************************************/
						if($('#Gym_Uno').is(':checked')){
								var Frecuenca_Gym = 1;
							}
					/*************************************************/
						if($('#Gym_dos').is(':checked')){
								var Frecuenca_Gym = 2;
							}
					/*************************************************/
						if($('#Gym_tres').is(':checked')){
								var Frecuenca_Gym = 3;
							}
					/*************************************************/
					if($('#Gym_Mas').is(':checked')){
								var Frecuenca_Gym = 4;
							}
					/*************************************************/
					
				}else{
						var Gimnasio = 1;
						var Frecuenca_Gym = '';//Ninguna
					}	
				
				if($('#Si_Gym').is(':checked')){
					if($('#Gym_Menos').is(':checked')==false && $('#Gym_Uno').is(':checked')==false && $('#Gym_dos').is(':checked')==false && $('#Gym_tres').is(':checked')==false && $('#Gym_Mas').is(':checked')==false){
							alert('Indique cuantas Veces Asiste a el Gimnasio');
							return false;
						}
				}		
			/***************************Septima Pregunta******************************************/	
			if($('#Si_ClubRunning').is(':checked')==false && $('#No_ClubRunning').is(':checked')==false){
				alert('Selecione una Opcion a la Pregunta...\n Hace parte del Club Running');
				return false;
			}		
			
				if($('#Si_ClubRunning').is(':checked')){
						
						var ClubRunning = 0;
						
						var FechaVinculacion = $('#FechaVinculacion').val();
					}else{
						var ClubRunning = 1;
						
						var FechaVinculacion = '';
						}
				if($('#Si_ClubRunning').is(':checked')){
						if($('#FechaVinculacion').val()==-1 || $('#FechaVinculacion').val()=='-1'){
								alert('Ingrese el Periodo de Vinculacion');
								$('#FechaVinculacion').effect("pulsate", {times:3}, 500);
								$('#FechaVinculacion').css('border-color','#F00');	
								return false;
							}
					}		
			/***************************Octava Pregunta***********************************************/	
			if($('#Si_ClubCaminantes').is(':checked')==false && $('#No_ClubCaminantes').is(':checked')==false){
				alert('Seleccione una opcion a la Pregunta...\n Club de Caminantes');
				return false;
			}		
				if($('#Si_ClubCaminantes').is(':checked')){
						
						var ClubCaminantes = 0;
						
						var FechaVinculacionCaminantes = $('#FechaVinculacionCaminantes').val();
						
					}else{
						var ClubCaminantes = 1;
						
						var FechaVinculacionCaminantes = '';
						}	
				if($('#Si_ClubCaminantes').is(':checked')){
						if($('#FechaVinculacionCaminantes').val()==-1 || $('#FechaVinculacionCaminantes').val()=='-1'){
								alert('Ingrese El Periodo de Vinculacion');
								$('#FechaVinculacionCaminantes').effect("pulsate", {times:3}, 500);
								$('#FechaVinculacionCaminantes').css('border-color','#F00');
								return false;
							}
					}							
			/*******************************************************/
			/**************************Ajax********************************/
			
				
				 $.ajax({//Ajax
						  type: 'GET',
						  url: 'Hoja_Vida.html.php',
						  async: false,
						  dataType: 'json',
						  data:({actionID: 'Save_Admin',Selecion_U:Selecion_U,
														Tipo_Selecion:DatoSeleccion,
														Competencias_U:Competencias_U,
														Tipo_Competencia:DatoApoyo,
														Talleres:Talleres,
														Tipo_Taller:DatoTaller,
														LogroDeportivo:LogroDeportivo,
														PeriodoLogroDeport:PeriodoLogroDeport,  
														Cual_LogroDeportivo:Cual_LogroDeportivo,
														BecasEstimos:BecasEstimos,
														Cual_BecaEstimulo:Cual_BecaEstimulo,
														PeriodoBecasDeport:PeriodoBecasDeport,
														Gimnasio:Gimnasio,
														Frecuenca_Gym:Frecuenca_Gym,
														ClubRunning:ClubRunning,
														FechaVinculacion:FechaVinculacion,
														ClubCaminantes:ClubCaminantes,
														FechaVinculacionCaminantes:FechaVinculacionCaminantes,
														Estudiante_id:Estudiante_id,
														Bienestar:1,
														PermisoUsuario:PermisoUsuario,
														P_General:P_General,
														F_ini:F_ini,
														F_fin:F_fin,
														F_ini_Ap:F_ini_Ap,
														F_fin_Ap:F_fin_Ap,
														id_Bienestar:id_Bienestar}),
					   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					   success: function(data){
								if(data.val=='FALSE'){
										alert(data.descrip);
										return false;
									}else{
										/**********************************************/	
											alert('Se Ha Guardado Correctamente...');
											
											
											//location.href='HojaVidaEstudiante.php';
										/**********************************************/	
										}
					   } 
				}); //AJAX
			/*************************Fin AJAx*****************************/
			}//if
		
		//**************************************Permiso usuario Salud************************//
		if(PermisoUsuario==2 || PermisoUsuario=='2'){
			/*******************Pregunta 1**************************************************/
			/********************************Participación en acciones del cuidado de la salud***************************/	
		
			var Num_Ase_Psico 		= $('#Num_Ase_Psico').val();	
			//var Num_MedGeneral		= $('#Num_MedGeneral').val();
			//var Num_MedDeporte		= $('#Num_MedDeporte').val();
			if(Num_Ase_Psico==""){
                            alert("Indique el número de usos del servicio Asesoria psicológica");
                            return false;
                        }
                        
                        //Verificamos participación en actividades de promoción y prevención
                        $('.saludbienestar table.requiredInputs input').each(function() { 
                            if($(this).val()==""){
                                alert("Por favor indique la participación en todas las actividades de promoción y prevención");
                                return false;
                            }
                        });
                        var participacionActividades = $('.saludbienestar input[name="actividadesPromocion[]"]').serialize();
                        var idsActividades = $('.saludbienestar input[name="idsActividadesPromocion[]"]').serialize()
                        
			var numIndicesFeha = $('#numIndicesFeha').val();
			
			$('#CadenaIncapacidad').val('');
			var Cadena_Incapacidad = "";
			for(i=0;i<=numIndicesFeha;i++){
                            if((!$('#transcrita_incapacidad_'+i).is(':checked') && !$('#emitida_incapacidad_'+i).is(':checked'))
                                            || !$.trim($('#Fecha_InicioIncapacida_'+i).val())  ||
                                            !$.trim($('#Fecha_FinalizacionIncapacidad_'+i).val()) ||
                                            !$.trim($('#Motivo_incapacida_'+i).val())){
                                            //no lleno los datos entonces no guardo
						} else {
				/*********************************************************/
                                        var transcrito_emitido = 2;
                                        if($('#transcrita_incapacidad_'+i).is(':checked')){
                                            transcrito_emitido = 1;
                                        }
						var Fecha_InicioIncapacida			= $('#Fecha_InicioIncapacida_'+i).val();
						var Fecha_FinalizacionIncapacidad	= $('#Fecha_FinalizacionIncapacidad_'+i).val();
						var Motivo_incapacida				= $('#Motivo_incapacida_'+i).val();
						var idIncapacidad				= $('#idIncapacidad_'+i).val();
						
						if($.trim(Fecha_InicioIncapacida) && $.trim(Fecha_FinalizacionIncapacidad) && $.trim(Motivo_incapacida)){
								
                                                            $('#CadenaIncapacidad').val($('#CadenaIncapacidad').val()+'_'+transcrito_emitido+'::'+Fecha_InicioIncapacida+'::'+Fecha_FinalizacionIncapacidad+'::'+Motivo_incapacida+'::'+idIncapacidad);
                                                             Cadena_Incapacidad = $('#CadenaIncapacidad').val();
								
							}
                                   }
				
				/*********************************************************/
				}//Fin For
			
                                $.ajax({//Ajax
                                            type: 'POST',
                                            url: 'Hoja_Vida.html.php',
                                            async: false,
                                            dataType: 'json',
                                            data:({actionID: 'Save_Admin',Num_Ase_Psico:Num_Ase_Psico,
                                                participacionActividades: participacionActividades,
                                                idsActividades:idsActividades,
                                                Estudiante_id:Estudiante_id,
                                                Cadena_Incapacidad: Cadena_Incapacidad,
                                                Bienestar:1,
                                                PermisoUsuario:PermisoUsuario,
                                                P_General:P_General,
                                                id_Bienestar:id_Bienestar}),
                                        error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                                        success: function(data){
                                                                if(data.val=='FALSE'){
                                                                                alert(data.descrip);
                                                                                return false;
                                                                        }else{
                                                                alert('Se Ha Guardado Correctamente...');	
                                                         }
                                        } 
                                }); //AJAX
			
			}//if		
		if(PermisoUsuario==3|| PermisoUsuario=='3'){
			/*******************Pregunta 1**************************************************/
			if($('#Si_GrupoCultura').is(':checked')==false && $('#No_GrupoCultura').is(':checked')==false){
			 alert('Indique una opcion a la Pregunta..\n Participación en grupos culturales de la Universidad');
				return false;
			}
			
			
				
			if($('#Si_GrupoCultura').is(':checked')){
				/**********************************************/
				var GrupoCultural = 0;
				
				var P_ini_Grupo	= $('#P_ini_Grupo').val();
				var P_fin_Grupo	= $('#P_fin_Grupo').val();
				
				if(P_ini_Grupo==-1 || P_ini_Grupo=='-1'){
					alert('Seleccione periodo Incial ');
					$('#P_ini_Grupo').effect("pulsate", {times:3}, 500);
					$('#P_ini_Grupo').css('border-color','#F00');
					return false;
					}
				
				var IndexGrupCul	= $('#IndexGrupCul').val();	
					
						for(i=0;i<IndexGrupCul;i++){
							/***************************************/
							if($('#'+i+'_Grup').is(':checked')){
								/************************************/
								$('#C_GrupCultura').val($('#'+i+'_Grup').val());
								/************************************/
								}//if
							/***************************************/
							}//for
						var DatoGrupCult	= $('#C_GrupCultura').val();
						
				/**********************************************/
				}else{
					var GrupoCultural = 1;
					var P_ini_Grupo	= '';
					var P_fin_Grupo	= '';
					var DatoGrupCult	= '';
					}
				
				if($('#Si_GrupoCultura').is(':checked')){
					if(!$.trim($('#C_GrupCultura').val())){
							alert('Indique que Tipo de Grupo Cultural');
							return false;
						}
				}		
			/**********************Pregunta 2****************************************/
			if($('#Si_TalleresCultura').is(':checked')==false && $('#No_TalleresCultura').is(':checked')==false){
			 alert('Indique una opcion a la Pregunta..\n Participación en Talleres formativos Culturales');
				return false;
			}	
				
				
			if($('#Si_TalleresCultura').is(':checked')){
				/*******************************************/
				var TalleresCultura = 0;
				
					$('#C_TallerCultura').val('');
							
							var IndexTllCultura	= $('#IndexTllCultura').val();
							
							for(i=0;i<IndexTllCultura;i++){
							/***************************************/
								if($('#'+i+'_TllCult').is(':checked')){
									/************************************/
									var P_ini	= $('#P_ini'+i).val();
									var P_Fin	= $('#P_fin'+i).val();
									
									if(P_ini==-1 || P_ini=='-1'){
										/**********************/
										alert('Debe Selecionar Un Periodo Inicial');
										$('#P_ini_'+i).effect("pulsate", {times:3}, 500);
										$('#P_ini_'+i).css('border-color','#F00');
										return false;
										/**********************/
										}
									if(P_Fin==-1 || P_Fin=='-1'){
										/**********************/
										alert('Debe Selecionar Un Periodo Final');
										$('#P_fin_'+i).effect("pulsate", {times:3}, 500);
										$('#P_fin_'+i).css('border-color','#F00');
										return false;
										/**********************/
										}
									if(!$.trim($('#id_BineTll_'+i).val())){		
									/************************************/
									$('#C_TallerCultura').val($('#C_TallerCultura').val()+'-'+$('#'+i+'_TllCult').val()+'::'+P_ini+'::'+P_Fin);
									/************************************/
									}
								}//if
							/***************************************/
							}//for
							var DatoTaller	= $('#C_TallerCultura').val();
							
				/*******************************************/
				}else{
					var TalleresCultura = 1;
					var DatoTaller	='';
					}
					
				if($('#Si_TalleresCultura').is(':checked')){
					if(!$.trim($('#C_TallerCultura').val())){
							alert('Indique que Tipo(s) de Talleres formativos');
							return false;
						}
				}	
			/*********************Pregunta 3************************************************/
			if($('#LogroCultural_Si').is(':checked')==false && $('#LogroCultural_No').is(':checked')==false){
			 alert('Indique una opcion a la Pregunta..\n Logros Culturales');
				return false;
			}	
			if($('#LogroCultural_Si').is(':checked')){
					
				if(!$.trim($('#CualLogrosCulturales').val())){
						alert('Indique Cual Logro Cultural');
						$('#CualLogrosCulturales').effect("pulsate", {times:3}, 500);
						$('#CualLogrosCulturales').css('border-color','#F00');
						return false;
					}
					
				if($('#P_ini_LogorCultura').val()==-1  ||  $('#P_ini_LogorCultura').val()=='-1'){
						alert('Seleccione Periodo del Logro Cultural');
						$('#P_ini_LogorCultura').effect("pulsate", {times:3}, 500);
						$('#P_ini_LogorCultura').css('border-color','#F00');
						return false;
						
					}	
			
			}	
			if($('#LogroCultural_Si').is(':checked')){
				/*****************************************************/
					var LogroCultural			= 0;
					var CualLogrosCulturales	= $('#CualLogrosCulturales').val();
					var PeriodoLogroCultural	= $('#P_ini_LogorCultura').val();
				/*****************************************************/
				}else{
					/***********************************************/
					var LogroCultural			= 1;
					var CualLogrosCulturales	= '';
					var PeriodoLogroCultural	= '';
					/***********************************************/
					}
			/************************Pregunta 4**************************************/	
			if($('#BecaCultural_Si').is(':checked')==false && $('#BecaCultural_No').is(':checked')==false){
			 alert('Indique una opcion a la Pregunta..\n Logros Culturales');
				return false;
			}
			if($('#BecaCultural_Si').is(':checked')){
						
					if(!$.trim($('#CualBecasCulturales').val())){
							alert('Describa Cual Beca o Estimulo por Cultura');
							$('#CualBecasCulturales').effect("pulsate", {times:3}, 500);
							$('#CualBecasCulturales').css('border-color','#F00');
							return false;
						}
						
					if($('#P_ini_BecaCultura').val()==-1 || $('#P_ini_BecaCultura').val()=='-1'){
							alert('Seleccione el Periodo del la Beca o Estimulo');
							$('#P_ini_BecaCultura').effect("pulsate", {times:3}, 500);
							$('#P_ini_BecaCultura').css('border-color','#F00');
							return false;
						}	
					
				}	
			if($('#BecaCultural_Si').is(':checked')){
				/**********************************************************/
					var BecaCultural		= 0;
					var CualBecasCulturales	= $('#CualBecasCulturales').val();
					var PeriodoBecasCultural = $('#P_ini_BecaCultura').val();
				/**********************************************************/
				}else{
					var BecaCultural		= 1;
					var CualBecasCulturales	= '';
					var PeriodoBecasCultural = '';
					}
			/********************************************************************************/		
			/******************************AJUAX*********************************************/
			
			 $.ajax({//Ajax
				  type: 'GET',
				  url: 'Hoja_Vida.html.php',
				  async: false,
				  dataType: 'json',
				  data:({actionID: 'Save_Admin',GrupoCultural:GrupoCultural,
												P_ini_Grupo:P_ini_Grupo,
												P_fin_Grupo:P_fin_Grupo,
												DatoGrupCult:DatoGrupCult,
												TalleresCultura:TalleresCultura,
												DatoTaller:DatoTaller,
												LogroCultural:LogroCultural,
												PeriodoLogroCultural:PeriodoLogroCultural,
												CualLogrosCulturales:CualLogrosCulturales,
												PeriodoLogroCultural:PeriodoLogroCultural,
												BecaCultural:BecaCultural,
												CualBecasCulturales:CualBecasCulturales,
												PeriodoBecasCultural:PeriodoBecasCultural,
												Estudiante_id:Estudiante_id,
												Bienestar:1,
												PermisoUsuario:PermisoUsuario,
												P_General:P_General,
												id_Bienestar:id_Bienestar}),
			   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
			   success: function(data){
						if(data.val=='FALSE'){
								alert(data.descrip);
								return false;
							}else{
								/**********************************************/	
									alert('Se Ha Guardado Correctamente...');
									
									
									//location.href='HojaVidaEstudiante.php';
								/**********************************************/	
								}
					   } 
				}); //AJAX
			/*************************Fin Ajax***********************************************/
			/********************************************************************************/
			}//if	
                        
                        
                      if(PermisoUsuario==4|| PermisoUsuario=='4'){  
                        
                        /***************************Participación en Grupos Universitarios*******************************************/ 		 
		var Voluntariado = 1;
			if($('#Si_Volunta').is(':checked')){
					Voluntariado = 0;
				}
			
			
			if($('#Si_Volunta').is(':checked')==false && $('#No_Volunta').is(':checked')==false){
					alert('Indique una de las Opciones a la Pregunta...\n Pertenece al Voluntariado');
					return false;
				}
                                
                                var FechaInicialVoluntareado = $('#F_iniVoluntario').val();
                                var FechaFinalVoluntareado = $('#F_finVoluntario').val();
                                if($('#Si_Volunta').is(':checked') && FechaInicialVoluntareado==''){
					alert('Indique una de las Opciones a la Pregunta...\n Pertenece al Voluntariado');
					return false;				
                                }
				
			/***************************************************************************/	
			var GrupoApoyo = 1;
			if($('#Si_GrupoApoyoBienestar').is(':checked')){
					GrupoApoyo = 0;
				}
			
			if($('#Si_GrupoApoyoBienestar').is(':checked')==false && $('#No_GrupoApoyo').is(':checked')==false){
					alert('Indique una de las Opciones a la Pregunta...\n Pertenece al Grupo de Apoyo');
					return false;
				}	
                                var PeriodoInicialApoyo = $('#periodoInicialApoyoBienestar').val();
                                var PeriodoFinalApoyo = $('#periodoFinalApoyoBienestar').val();
                                if($('#Si_GrupoApoyoBienestar').is(':checked') && PeriodoInicialApoyo=='-1'){
					alert('Indique una de las Opciones a la Pregunta...\n Pertenece al Grupo de Apoyo');
					return false;				
                                }
				
			/***************************************************************************/		
			
			if($('#Si_MonitoBienestar').is(':checked')){
					var MonitoBienestar = 0;
				}
			
			if($('#No_MonitoBienestar').is(':checked')){
					var MonitoBienestar = 1;
				}
			
			if($('#Si_MonitoBienestar').is(':checked')==false && $('#No_MonitoBienestar').is(':checked')==false){
					alert('Indique una de las Opciones a la Pregunta...\n Monitor Bienestar Universitario');
					return false;
				}
                                
                                /******** VERIFICAR EL LISTADO DE MONITOREOS **********/
                                /*******************************************************/
				if($('#Si_MonitoBienestar').is(':checked')){
					/***********************************************/
                                                var Selecion_UM = 0;
					
						var F_iniM	= $('#periodoInicialMonitor').val();
						var F_finM	= $('#periodoFinalMonitor').val();
						
						if(F_iniM==-1 || F_iniM=='-1'){
							/********************************/
							alert('Debe Selecionar Un Periodo Inicial');
							$('#periodoInicialMonitor').effect("pulsate", {times:3}, 500);
							$('#periodoInicialMonitor').css('border-color','#F00');
							return false;
							/********************************/
							}
							
						var DatoSeleccionM	= $('#tipoMonitorBienestar').val();	
					/***********************************************/
					}else{
						var Selecion_UM  	= 1;
						var F_iniM			='';
						var F_finM			='';
						var DatoSeleccionM	=0;
						}//if
					
					if($('#Si_MonitoBienestar').is(':checked')){
						/***************************************************/
							if(!$.trim($('#tipoMonitorBienestar').val()) || $('#tipoMonitorBienestar').val()==-1 || $('#tipoMonitorBienestar').val()=="-1"){
								alert('Selecione un Tipo de Selección de la Pregunta ....\n Monitor Bienestar Universitario');
								return false;
								}
						/***************************************************/
						}
                                
                                
			/**************************Ajax********************************/	
			 $.ajax({//Ajax
				      type: 'GET',
				      url: 'Hoja_Vida.html.php',
				      async: false,
				      dataType: 'json',
				      data:({actionID: 'Save_Admin',SelecionVoluntareado:Selecion_UM,VoluntariadoB:Voluntariado,
                                          PeriodoInicialApoyo: PeriodoInicialApoyo, PeriodoFinalApoyo: PeriodoFinalApoyo,
                                          GrupoApoyoB:GrupoApoyo,FechaInicialVoluntareado:FechaInicialVoluntareado,
                                          FechaFinalVoluntareado:FechaFinalVoluntareado,
                                        DatoSeleccionVoluntareado:DatoSeleccionM,
                                        F_iniVoluntareado:F_iniM,
                                        F_finVoluntareado:F_finM,
                                        MonitorBienestar:MonitoBienestar,
                                        Estudiante_id:Estudiante_id,
                                        Bienestar:1,
                                        PermisoUsuario:PermisoUsuario,
                                        P_General:P_General,
                                        id_Bienestar:id_Bienestar}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										alert('Se Ha Guardado Correctamente...');
										//$('#SaveGenral').css('display','none');
										
										//location.href='HojaVidaEstudiante.php';
									/**********************************************/	
									}
				   } 
			}); //AJAX
		/*************************Fin AJAx*****************************/
                      } //if
			
			return false;		
	}	
function OrganosGobierno(Estudiante_id){  
	/***********************************************OrganosGobierno************************************************/
				if($('#Si_Representante').is(':checked')){
						var Representante  = 0;
					}
				
				if($('#No_Representante').is(':checked')){
						var Representante  = 1;
					}	
					
				if($('#Si_Representante').is(':checked')==false && $('#No_Representante').is(':checked')==false){
						alert('Indique una de las Opciones a la Pregunta...\n  Representante de Semestre');
						return false;
					}
					
				/******************************************************/		
				
				if($('#Si_ConsejoFacul').is(':checked')){
						var ConsejoFacul  = 0;
					}
				
				if($('#No_ConsejoFacul').is(':checked')){
						var ConsejoFacul  = 1;
					}	
					
				if($('#Si_ConsejoFacul').is(':checked')==false && $('#No_ConsejoFacul').is(':checked')==false){
						alert('Indique una de las Opciones a la Pregunta...\n  Representante al Consejo de la Facultad');
						return false;
					}
				
				/******************************************************/		
				
				if($('#Si_ConsejoAcad').is(':checked')){
						var ConsejoAcad  = 0;
					}
				
				if($('#No_ConsejoAcad').is(':checked')){
						var ConsejoAcad  = 1;
					}	
					
				if($('#Si_ConsejoAcad').is(':checked')==false && $('#No_ConsejoAcad').is(':checked')==false){
						alert('Indique una de las Opciones a la Pregunta...\n  Representante al Consejo Academico');
						return false;
					}
					
				/******************************************************/		
				
				if($('#Si_ConsejoDir').is(':checked')){
						var ConsejoDir  = 0;
					}
				
				if($('#No_ConsejoDir').is(':checked')){
						var ConsejoDir  = 1;
					}	
					
				if($('#Si_ConsejoDir').is(':checked')==false && $('#No_ConsejoDir').is(':checked')==false){
						alert('Indique una de las Opciones a la Pregunta...\n  Representante al Consejo Directivo');
						return false;
					}
					
		/**************************Ajax********************************/	
			 $.ajax({//Ajax
				      type: 'GET',
				      url: 'Hoja_Vida.html.php',
				      async: false,
				      dataType: 'json',
				      data:({actionID: 'Save_Admin',Representante:Representante,
													ConsejoFacul:ConsejoFacul,
													ConsejoAcad:ConsejoAcad,
													ConsejoDir:ConsejoDir,
													Estudiante_id:Estudiante_id,
													OrgaGobierno:1}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										alert('Se Ha Guardado Correctamente...');
										$('#SaveGenral').css('display','none');
										//location.href='HojaVidaEstudiante.php';
									/**********************************************/	
									}
				   } 
			}); //AJAX
		/*************************Fin AJAx*****************************/					
					
	}	
function ActividaInvestiga(Estudiante_id){
	/***********************************************ActividadInvestigacion**************************************************************/	
	
	/*******************************************Validacion***************************************************************/		
	
	if($('#Si_Investiga').is(':checked')==false && $('#No_Investiga').is(':checked')==false){
			alert('Indique una Opciona a la Pregunta...\n El estudiante ha participado en alguna de las actividades de Investigacion');
			return false;
		}
		
	if($('#Si_Investiga').is(':checked')){
			/*****************************************************************************/
				if($('#Si_Semillero').is(':checked')==false && $('#No_Semillero').is(':checked')==false){
						alert('indique una Opcion a la pregunta...\n 1. Semillero de investigación ');
						return false;
					}
			/*****************************************************************************/		
					if($('#Si_Semillero').is(':checked')){
						/*****************************************************************/
							if(!$.trim($('#Nom_Semillero').val())){
									alert('Describa el Niombre del Semillero');
									return false;
								}
						/*****************************************************************/		
							if(!$.trim($('#FechaVinculacionSemillero').val())){
									alert('inidique la fecha inicial de vinculacion a el semillero');
									return false;
								}
						/*****************************************************************/
							if(!$.trim($('#FechaFinSemillero').val())){
									alert('inidique la fecha final de vinculacion a el semillero');
									return false;
								}
						/*****************************************************************/
							if(!$.trim($('#Dependencia').val())){
									alert('inidique la Dependencia de el semillero');
									return false;
								}
						/*****************************************************************/
						}
			/*****************************************************************************/
				if($('#Si_Asistente').is(':checked')==false && $('#No_Asistente').is(':checked')==false){
						alert('Indique una Opcion a la pregunta..\n Asistente o auxiliar de investigacion');
						return false;
					}
			/******************************************************************************/
					if($('#Si_Asistente').is(':checked')){
						/******************************************************************/	
							if(!$.trim($('#NombreProyecto_invg').val())){
									alert('describa el Nombre del proyecto a la pregunta \n Asistente o auxiliar de investigacion');
									return false;
								}
						/******************************************************************/
							if(!$.trim($('#DocenteResp_invg').val())){
									alert('describa el Docente Responsable a la pregunta \n Asistente o auxiliar de investigacion');
									return false;
								}
						/******************************************************************/
							if(!$.trim($('#Fechainicio_invg').val())){
									alert('indique la fecha de Inicio a la pregunta \n Asistente o auxiliar de investigacion');
									return false;
								}
						/******************************************************************/
							if(!$.trim($('#Fechafin_invg').val())){
									alert('indique la fecha de final a la pregunta \n Asistente o auxiliar de investigacion');
									return false;
								}
						/******************************************************************/
						}
			/*****************************************************************************/
				if($('#Si_Publicaciones').is(':checked')==false && $('#No_Publicaciones').is(':checked')==false){
						alert('indique una opcion a la pregunta...\n Participacion en Publicaciones Internas (de la Facultad) ');
						return false;
					}
			/*****************************************************************************/
				if($('#Si_Publicaciones').is(':checked')){
					/*********************************************************************/
						if(!$.trim($('#Autor_Publicacion').val())){
								alert('describa el Nombre del Autor a la Pregunta \n Participacion en Publicaciones Internas (de la Facultad)');
								return false;
							}
					/*********************************************************************/	
						if(!$.trim($('#Nom_Publicacion').val())){
								alert('describa el Nombre de la publicacion a la Pregunta \n Participacion en Publicaciones Internas (de la Facultad)');
								return false;
							}
					/*********************************************************************/	
						if(!$.trim($('#Coautor_Publicacion').val())){
								alert('describa el Nombre del coautor de la publicacion a la Pregunta \n Participacion en Publicaciones Internas (de la Facultad)');
								return false;
							}
					/*********************************************************************/
						if(!$.trim($('#Editorial_Publicacion').val())){
								alert('describa el Nombre del Editorial de la publicacion a la Pregunta \n Participacion en Publicaciones Internas (de la Facultad)');
								return false;
							}
					/*********************************************************************/	
						if($('#Si_Rol').is(':checked')==false && $('#No_Rol').is(':checked')==false){
								alert('Indique si desempeño algun rol');
								return false;
							}
					/*********************************************************************/
						if($('#Revista').is(':checked')){
								if($('#Indexada').is(':checked')==false && $('#NoIndexada').is(':checked')==false){
									alert('indique el tipo de revista');
									return false;
									}
								
							}
					/*********************************************************************/
						if($('#Revista').is(':checked')==false && $('#Libro').is(':checked')==false && $('#Cartilla').is(':checked')==false && $('#Protocolo').is(':checked')==false && $('#OtraPublic').is(':checked')==false){
								alert('indique un Tipo de Plublicacion');
								return false;
							}
					/*********************************************************************/
						if($('#OtraPublic').is(':checked')){
								if(!$.trim($('#Otra_publicTipo').val())){
										alert('Describa Cual Otra Publicacion');
										return false;
									}
							}
					/*********************************************************************/	
					}
					if($('#Si_PublicacionExt').is(':checked')==false && $('#No_PublicacionExt').is(':checked')==false){
								alert('indique una Opcion a la pregunta...\n Participación en publicaciones externas');
								return false;
							}
				/*********************************************************************/
					if($('#Si_Publicaciones').is(':checked')){
						/*************************************************************/
							if(!$.trim($('#Autor_PublicacionExt').val()) || !$.trim($('#Nom_PublicacionExt').val()) || !$.trim($('#Coautor_PublicacionExt').val()) || !$.trim($('#Entidad_PublicacionExt').val())){
									
									alert('Diligencie todos los campos relacionados con la Pregunta \n Participación en publicaciones externas');
									return false;
									
								}
								
							if($('#SiRol_ext').is(':checked')==false && $('#NoRol_ext').is(':checked')==false){
									alert('inidque si tiene otro rol en la Investigacion...');
									return false;
								}	
								
							if($('#Si_Rol').is(':checked')){
									if(!$.trim($('#CualRol_PublicacionExt').val())){
											alert('Describa el Rol en la Investigacion');
											return false;
										}
								}	
								
							if($('#RevistaExt').is(':checked')){
									if($('#IndexadaExt').is(':checked')==false && $('#NoIndexadaExt').is(':checked')==false){
										alert('indique de que tipo es la revista');
										return false;
										}
								}
								
							if($('#RevistaExt').is(':checked')==false && $('#LibroExt').is(':checked')==false && $('#CartillaExt').is(':checked')==false && $('#ProtocoloExt').is(':checked')==false && $('#OtraPublicExt').is(':checked')==false){
									alert('indique un Tipo de Publicacion Externa');
									return false;
								}
								
							if($('#OtraPublicExt').is(':checked')){
									if(!$.trim($('#Otra_publicTipoExt').val())){
											alert('Describa cual es la Otra Publicacion');
											return false;
										}
								}			
					/*************************************************************/
					}
				/*************************************************************************/
					if($('#Si_AsisEventos').is(':checked')==false && $('#No_AsisEventos').is(':checked')==false){
							alert('indique una opcion a la pregunta..\n Asistencia a eventos de investigacion');
							return false;
						}
				/*************************************************************************/	
					if($('#Si_AsisEventos').is(':checked')){
					/*********************************************************************/	
						if(!$.trim($('#Fechaini_Evento').val()) || !$.trim($('#Fechafin_Evento').val()) || !$.trim($('#Nom_evento').val()) || !$.trim($('#Nom_EntidadOrg').val())){
									
									alert('deligencie todos los campos relacionados a la Pregunta \n Asistencia a eventos de investigacion');
									return false;
							}
					/*********************************************************************/
						}
				/*************************************************************************/
					if($('#Si_PonenteCongreso').is(':checked')==false && $('#No_PonenteCongreso').is(':checked')==false){
							alert('indique una opcion a la pregunta...\n Ponente en Congresos en la Universidad El Bosque');
							return false;
						}
					
					if($('#Si_PonenteCongreso').is(':checked')){
						/*****************************************************************/
							if(!$.trim($('#Fechaini_CongBosque').val()) || !$.trim($('#Fechafin_CongBosque').val()) || !$.trim($('#NomEvento_CongBosque').val()) || !$.trim($('#NomPonencia_CongBosque').val()) || !$.trim($('#Dependencia_CongBosque').val())){
									alert('Diligencie todos los campos relacionados con la pregunta \n Ponente en Congresos en la Universidad El Bosque');
									return false;
								}
						/*****************************************************************/
						}	
				/*************************************************************************/
					if($('#Si_PonenteLocal').is(':checked')==false && $('#No_PonenteLocal').is(':checked')==false){
							alert('indique una opcion a la pregunta...\n Ponente en Congresos locales (Bogota)');
							return false;
						}
						
					if($('#Si_PonenteLocal').is(':checked')){
						/*****************************************************************/
							if(!$.trim($('#Fechaini_Congreso').val()) || !$.trim($('#Fechafin_Congreso').val()) || !$.trim($('#NomEvento_Congreso').val()) || !$.trim($('#NomPonencia_Congreso').val()) || !$.trim($('#Entidad_Congreso').val())){
									alert('Dilegencie todos los campos relacionados con la pregunta \n Ponente en Congresos locales (Bogota)');
									return false;
								}
						/*****************************************************************/
						}	
				/*************************************************************************/
					if($('#Si_PonenteNacional').is(':checked')==false && $('#No_PonenteNacional').is(':checked')==false){
							alert('indique una opcion a la Pregunta.. \n Ponente en Congresos Nacionales');
							return false;
						}
						
					if($('#Si_PonenteNacional').is(':checked')){
						/*****************************************************************/	
							if(!$.trim($('#Fechaini_CongNal').val()) || !$.trim($('#Fechafin_CongNal').val()) || !$.trim($('#NomEvento_CongNal').val()) || !$.trim($('#NomPonencia_CongNal').val()) || !$.trim($('#id_CityCongreso').val()) || !$.trim($('#Entidad_Congreso').val())){
									
									alert('Deligencie todos los campos relacionados con la pregunta \n Ponente en Congresos Nacionales');
									return false;
								
								}
						/*****************************************************************/
						}	
				/*************************************************************************/
					if($('#Si_PonenteInternacional').is(':checked')==false && $('#No_PonenteInternacional').is(':checked')==false){
							alert('indique una opcion a la pregunta...\n Ponente en Congresos Internacionales');
							return false;
						}
					
					if($('#Si_PonenteInternacional').is(':checked')){
						/*****************************************************************/	
							if(!$.trim($('#Fechaini_CongInter').val()) || !$.trim($('#Fechafin_CongInter').val()) || !$.trim($('#NomEvento_CongInter').val()) || !$.trim($('#NomPonencia_CongInter').val()) || !$.trim($('#id_CityCongInter').val()) || !$.trim($('#id_Pais').val()) || !$.trim($('#Entidad_CongInter').val())){
								
									alert('Deligencie todos los campos relacionados con la pregunta \n Ponente en Congresos Internacionales');
									return false;
								}
						/*****************************************************************/
						}	
				/*************************************************************************/
			/*****************************************************************************/
		}	
	
/********************************************************************************************************************/	
			if($('#Si_Investiga').is(':checked')){
					
					var Investiga = 0;
					
					/***************************************************/
						if($('#Si_Semillero').is(':checked')){
								var Semillero = 0;//Si
								/***************************************************/
									var Nom_Semillero 				= $('#Nom_Semillero').val();
									var FechaVinculacionSemillero	= $('#FechaVinculacionSemillero').val();
									var FechaFinSemillero			= $('#FechaFinSemillero').val();
									var Dependencia					= $('#Dependencia').val();
								/***************************************************/
							}
						
						if($('#No_Semillero').is(':checked')){
								var Semillero = 1;//No
								/***************************************************/
									var Nom_Semillero 				= '';
									var FechaVinculacionSemillero	= '';
									var FechaFinSemillero			= '';
									var Dependencia					= '';
								/***************************************************/
							}	
					/***************************************************/
						if($('#Si_Asistente').is(':checked')){
								var Asistente	= 0;
								/***************************************************/
									var NombreProyecto_invg			= $('#NombreProyecto_invg').val();
									var DocenteResp_invg			= $('#DocenteResp_invg').val();
									var Fechainicio_invg			= $('#Fechainicio_invg').val();
									var Fechafin_invg				= $('#Fechafin_invg').val();
								/***************************************************/
							}
						
						if($('#No_Asistente').is(':checked')){
								var Asistente	= 1;
								/***************************************************/
									var NombreProyecto_invg			= '';
									var DocenteResp_invg			= '';
									var Fechainicio_invg			= '';
									var Fechafin_invg				= '';
								/***************************************************/
							}	
					/***************************************************/	
						if($('#Si_Publicaciones').is(':checked')){
								var Publicaciones	= 0;//Si
								/***************************************************/
									var Autor_Publicacion		= $('#Autor_Publicacion').val();
									var Nom_Publicacion			= $('#Nom_Publicacion').val();
									var Coautor_Publicacion		= $('#Coautor_Publicacion').val();
									var Editorial_Publicacion	= $('#Editorial_Publicacion').val();
									
									if($('#Si_Rol').is(':checked')){
											var Rol = 1;
											var Cual_Rol	= $('#Cual_Rol').val();
										}
									if($('#No_Rol').is(':checked')){
											var Rol = 2;
											var Cual_Rol	= '';
										}	
										
									/*********************************************/	
									
										if($('#Revista').is(':checked')){
												
												var TipoPublicacion = 1;//Revista
												var Otra_publicTipo	= '';
												
												if($('#Indexada').is(':checked')){
														var Indexada = 0;
													}
												
												if($('#NoIndexada').is(':checked')){
														var Indexada = 1;
													}	
												
											}
										
										if($('#Libro').is(':checked')){
												
												var TipoPublicacion = 2;//Libro
												var Otra_publicTipo	= '';
												
											}
											
										if($('#Cartilla').is(':checked')){
												
												var TipoPublicacion = 3;//Cartilla	
												var Otra_publicTipo	= '';
												
											}
										
										if($('#Protocolo').is(':checked')){
												
												var TipoPublicacion = 4;//Protocolo	
												var Otra_publicTipo	= '';
												
											}
											
										if($('#OtraPublic').is(':checked')){
												
												var TipoPublicacion = 5;//OtraPublic	
												var Otra_publicTipo	= $('#Otra_publicTipo').val();
												
											}		
									
									/*********************************************/
								/***************************************************/
							}
							
						if($('#No_Publicaciones').is(':checked')){
								var Publicaciones	= 1;//No
								/***************************************************/
									var Autor_Publicacion		= '';
									var Nom_Publicacion			= '';
									var Coautor_Publicacion		= '';
									var Editorial_Publicacion	= '';
									var Rol = 0;//NInguno
									var Cual_Rol	= '';
									var TipoPublicacion = 0;//Ninguno
									var Otra_publicTipo	= '';
											
								/***************************************************/
							}
					/************************************************************************/			
						if($('#Si_PublicacionExt').is(':checked')){
								var PublicacionExt = 0;
								/************************************************************/
									var Autor_PublicacionExt		= $('#Autor_PublicacionExt').val();
									var Nom_PublicacionExt			= $('#Nom_PublicacionExt').val();
									var Coautor_PublicacionExt		= $('#Coautor_PublicacionExt').val();
									var Entidad_PublicacionExt		= $('#Entidad_PublicacionExt').val();
									
									if($('#SiRol_ext').is(':checked')){
											var Rol_ext	= 1;
											var CualRol_PublicacionExt	= $('#CualRol_PublicacionExt').val();
										}
										
									if($('#NoRol_ext').is(':checked')){
											var Rol_ext	= 2;
											var CualRol_PublicacionExt	= '';
										}
									/********************************************************/		
										if($('#RevistaExt').is(':checked')){
												var TipoPublicacion_Ext = 1;//RevistaExt
												var Otra_publicTipoExt	='';
												
												if($('#IndexadaExt').is(':checked')){
														var Indexsada_Ext	= 1;
													}
												if($('#NoIndexadaExt').is(':checked')){
														var Indexsada_Ext	= 2;
													}	
											}
											
										if($('#LibroExt').is(':checked')){
												var TipoPublicacion_Ext = 2;//LibroExt
												var Otra_publicTipoExt	='';
											}
										if($('#CartillaExt').is(':checked')){
												var TipoPublicacion_Ext = 3;//CartillaExt
												var Otra_publicTipoExt	='';
											}
										if($('#ProtocoloExt').is(':checked')){
												var TipoPublicacion_Ext = 4;//ProtocoloExt
												var Otra_publicTipoExt	='';
											}
										if($('#OtraPublicExt').is(':checked')){
												var TipoPublicacion_Ext = 5;//OtraPublicExt
												var Otra_publicTipoExt	= $('#Otra_publicTipoExt').val();
											}				
									/********************************************************/
								/************************************************************/
							}
							
						if($('#No_PublicacionExt').is(':checked')){
								var PublicacionExt = 1;
								/************************************************************/
									var Autor_PublicacionExt		= '';
									var Nom_PublicacionExt			= '';
									var Coautor_PublicacionExt		= '';
									var Entidad_PublicacionExt		= '';
									var Rol_ext	= 0;//Ningun Rol
									var CualRol_PublicacionExt	= '';
									var TipoPublicacion_Ext = 0;//Ninguna Publicacion
									var Otra_publicTipoExt	= '';
								/************************************************************/
							}	
					/************************************************************************/
						if($('#Si_AsisEventos').is(':checked')){
								var AsisEventos	= 0;
								/************************************************************/
									var Fechaini_Evento			= $('#Fechaini_Evento').val();
									var Fechafin_Evento			= $('#Fechafin_Evento').val();
									var Nom_evento				= $('#Nom_evento').val();
									var Nom_EntidadOrg			= $('#Nom_EntidadOrg').val();
								/************************************************************/
							}
						
						if($('#No_AsisEventos').is(':checked')){
								var AsisEventos	= 1;
								/************************************************************/
									var Fechaini_Evento			= '';
									var Fechafin_Evento			= '';
									var Nom_evento				= '';
									var Nom_EntidadOrg			= '';
								/************************************************************/
							}
					/************************************************************************/
						if($('#Si_PonenteCongreso').is(':checked')){
								var PonenteCongreso 	= 0;
								/*************************************************************/
									var Fechaini_CongBosque		= $('#Fechaini_CongBosque').val();
									var Fechafin_CongBosque		= $('#Fechafin_CongBosque').val();
									var NomEvento_CongBosque 	= $('#NomEvento_CongBosque').val();
									var NomPonencia_CongBosque	= $('#NomPonencia_CongBosque').val();
									var Dependencia_CongBosque	= $('#Dependencia_CongBosque').val();
								/*************************************************************/
							}
						
						if($('#No_PonenteCongreso').is(':checked')){
								var PonenteCongreso 	= 1;
								/****************************************************************/
									var Fechaini_CongBosque		= '';
									var Fechafin_CongBosque		= '';
									var NomEvento_CongBosque	= '';
									var NomPonencia_CongBosque	= '';
									var Dependencia_CongBosque	= '';
								/****************************************************************/
							}
					/************************************************************************/
						if($('#Si_PonenteLocal').is(':checked')){
								var PonenteLocal	= 0;
								/*************************************************************/
									var Fechaini_Congreso		= $('#Fechaini_Congreso').val();
									var Fechafin_Congreso		= $('#Fechafin_Congreso').val();
									var NomEvento_Congreso		= $('#NomEvento_Congreso').val();
									var NomPonencia_Congreso	= $('#NomPonencia_Congreso').val();
									var Entidad_CongresoLocal		= $('#Entidad_Congreso').val();
								/*************************************************************/
							}
						
						if($('#No_PonenteLocal').is(':checked')){
								var PonenteLocal	= 1;
								/************************************************************/
									var Fechaini_Congreso		= '';
									var Fechafin_Congreso		= '';
									var NomEvento_Congreso		= '';
									var NomPonencia_Congreso	= '';
									var Entidad_CongresoLocal		= '';
								/************************************************************/
							}
					/************************************************************************/
						if($('#Si_PonenteNacional').is(':checked')){
								var PonenteNacional		= 0;
								/*************************************************************/
									var Fechaini_CongNal		= $('#Fechaini_CongNal').val();
									var Fechafin_CongNal		= $('#Fechafin_CongNal').val();
									var NomEvento_CongNal		= $('#NomEvento_CongNal').val();
									var NomPonencia_CongNal		= $('#NomPonencia_CongNal').val();
									var id_CityCongreso			= $('#id_CityCongreso').val();
									var Entidad_CongresoNal		= $('#Entidad_Congreso').val();
								/*************************************************************/
							}
						
						if($('#No_PonenteNacional').is(':checked')){
								var PonenteNacional		= 1;
								/*************************************************************/
									var Fechaini_CongNal		= '';
									var Fechafin_CongNal		= '';
									var NomEvento_CongNal		= '';
									var NomPonencia_CongNal		= '';
									var id_CityCongreso			= '';
									var Entidad_CongresoNal		= '';
								/**************************************************************/
							}
					/************************************************************************/
						if($('#Si_PonenteInternacional').is(':checked')){
								var PonenteInternacional	= 0;
								/*************************************************************/
									var Fechaini_CongInter		= $('#Fechaini_CongInter').val();
									var Fechafin_CongInter		= $('#Fechafin_CongInter').val();
									var NomEvento_CongInter		= $('#NomEvento_CongInter').val();
									var NomPonencia_CongInter	= $('#NomPonencia_CongInter').val();
									var id_CityCongInter		= $('#id_CityCongInter').val();
									var id_Pais					= $('#id_Pais').val();
									var Entidad_CongInter		= $('#Entidad_CongInter').val();
								/************************************************************/
							}
						
						if($('#No_PonenteInternacional').is(':checked')){
								var PonenteInternacional	= 1;
								/*************************************************************/
									var Fechaini_CongInter		= '';
									var Fechafin_CongInter		= '';
									var NomEvento_CongInter		= '';
									var NomPonencia_CongInter	= '';
									var id_CityCongInter		= '';
									var id_Pais					= '';
									var Entidad_CongInter		= '';
								/************************************************************/
							}
					/************************************************************************/
				}
			if($('#No_Investiga').is(':checked')){
					var Investiga = 1;
				}	
		/****************************************************************/	
		/**************************Ajax********************************/	
			 $.ajax({//Ajax
				      type: 'GET',
				      url: 'Hoja_Vida.html.php',
				      async: false,
				      dataType: 'json',
				      data:({actionID: 'Save_Admin',Investiga:Investiga,
													Semillero:Semillero,
													Nom_Semillero:Nom_Semillero,
													FechaVinculacionSemillero:FechaVinculacionSemillero,
													FechaFinSemillero:FechaFinSemillero,
													Dependencia:Dependencia,
													Asistente:Asistente,
													NombreProyecto_invg:NombreProyecto_invg,
													DocenteResp_invg:DocenteResp_invg,
													Fechainicio_invg:Fechainicio_invg,
													Fechafin_invg:Fechafin_invg,
													Publicaciones:Publicaciones,
													Autor_Publicacion:Autor_Publicacion,
													Nom_Publicacion:Nom_Publicacion,
													Coautor_Publicacion:Coautor_Publicacion,
													Editorial_Publicacion:Editorial_Publicacion,
													Rol:Rol,
													Cual_Rol:Cual_Rol,
													TipoPublicacion:TipoPublicacion,
													Indexada:Indexada,
													Otra_publicTipo:Otra_publicTipo,
													PublicacionExt:PublicacionExt,
													Autor_PublicacionExt:Autor_PublicacionExt,
													Nom_PublicacionExt:Nom_PublicacionExt,
													Coautor_PublicacionExt:Coautor_PublicacionExt,
													Entidad_PublicacionExt:Entidad_PublicacionExt,
													Rol_ext:Rol_ext,
													CualRol_PublicacionExt:CualRol_PublicacionExt,
													TipoPublicacion_Ext:TipoPublicacion_Ext,
													Indexsada_Ext:Indexsada_Ext,
													Otra_publicTipoExt:Otra_publicTipoExt,
													AsisEventos:AsisEventos,
													Fechaini_Evento:Fechaini_Evento,
													Fechafin_Evento:Fechafin_Evento,
													Nom_evento:Nom_evento,
													Nom_EntidadOrg:Nom_EntidadOrg,
													PonenteCongreso:PonenteCongreso,
													Fechaini_CongBosque:Fechaini_CongBosque,
													Fechafin_CongBosque:Fechafin_CongBosque,
													NomEvento_CongBosque:NomEvento_CongBosque,
													NomPonencia_CongBosque:NomPonencia_CongBosque,
													Dependencia_CongBosque:Dependencia_CongBosque,
													PonenteLocal:PonenteLocal,
													Fechaini_Congreso:Fechaini_Congreso,
													Fechafin_Congreso:Fechafin_Congreso,
													NomEvento_Congreso:NomEvento_Congreso,
													NomPonencia_Congreso:NomPonencia_Congreso,
													Entidad_CongresoLocal:Entidad_CongresoLocal,
													PonenteNacional:PonenteNacional,
													Fechaini_CongNal:Fechaini_CongNal,
													Fechafin_CongNal:Fechafin_CongNal,
													NomEvento_CongNal:NomEvento_CongNal,
													NomPonencia_CongNal:NomPonencia_CongNal,
													id_CityCongreso:id_CityCongreso,
													Entidad_CongresoNal:Entidad_CongresoNal,
													PonenteInternacional:PonenteInternacional,
													Fechaini_CongInter:Fechaini_CongInter,
													Fechafin_CongInter:Fechafin_CongInter,
													NomEvento_CongInter:NomEvento_CongInter,
													NomPonencia_CongInter:NomPonencia_CongInter,
													id_CityCongInter:id_CityCongInter,
													id_Pais:id_Pais,
													Entidad_CongInter:Entidad_CongInter,
													Estudiante_id:Estudiante_id,
													InvesActividad:1}),
				   error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
				   success: function(data){
							if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									/**********************************************/	
										alert('Se Ha Guardado Correctamente...');
										$('#SaveGenral').css('display','none');
										//location.href='HojaVidaEstudiante.php';
									/**********************************************/	
									}
				   } 
			}); //AJAX
		/*************************Fin AJAx*****************************/	
	}	
function Ver_Voluntariado(){
		if($('#Si_Volunta').is(':checked')){
				$('.Tr_FechasVoluntario').css('visibility','visible');
			}else{
					$('.Tr_FechasVoluntario').css('visibility','collapse');
				}
	}	
function ValidaGeneral(){ 
    /******************************************************/
    var Nombre  = $('#Nombre').val();
			
			if(!$.trim(Nombre)){
					alert('Ingrese el Nombre del Estudiante...');
					return false;
				}
			
			var Apellidos  = $('#Apellidos').val();	
			
			if(!$.trim(Apellidos)){
					alert('Ingrese Los Apellidos del Estudiante...');
					return false;
				}
				
			var TipoDocumento  = $('#TipoDocumento').val();
			var Num_Documento  = $('#Num_Documento').val();
			
				if(!$.trim(Num_Documento)){
						alert('Ingrese El Numero de Documento...');
						return false;
					}
				
			var Expedida_Doc   = $('#Expedida_Doc').val();
				
				if(!$.trim(Expedida_Doc)){
						alert('Ingrese la Ciudad de Expedici\u00f3n del Documento...');
						return false;
				}
                
            var FechaDocu  = $('#FechaDocu').val();
            
            if(!$.trim(FechaDocu)){
                alert('Ingrese la fecha de Expedicion de su Documento de Identificacion.');
                return false;
            }    
			
			var Genero  = $('#Genero').val();
			var EstadiCivil = $('#EstadiCivil').val();
			var Estrato = $('#Estrato').val();
			
			if(Genero==200 || Genero=='200'){
					var LibretaMilitar    = $('#LibretaMilitar').val();
					
					/*if(!$.trim(LibretaMilitar)){
							alert('Ingrese el Numero de Libreta Militar...');
							return false;
						}*/
					
					var Distrito          = $('#Distrito').val();
					
					/*if(!$.trim(Distrito)){
							alert('Ingrese el Distrito...');
							return false;
						}*/
					
					var ExpedidaLibreta   = $('#ExpedidaLibreta').val();
					
					/*if(!$.trim(ExpedidaLibreta)){
							alert('Ingrese la Ciudad Donde fue Expedida La libreta Militar');
							return false;
						}*/
					
				}else{
					
						var LibretaMilitar    = '';
						var Distrito          = '';
						var ExpedidaLibreta   = '';
					}
			
			var Ciuda_Naci  = $('#id_Ciudad').val();
			if(!$.trim(Ciuda_Naci)){
					alert('Ingrese la Ciudad de Nacimiento O Lugar de Nacimiento');
					return false;
				}
			var FechaNaci   = $('#FechaNaci').val();
			var Dir_recidente  = $('#Dir_recidente').val();
			if(!$.trim(Dir_recidente)){
					alert('Ingrese la Direccion de recidencia Actual');
					return false;
				}
			var Tel_Recidente  = $('#Tel_Recidente').val();
			if(!$.trim(Tel_Recidente)){
					alert('Ingrese el Numero de Telefono de su Lugar de Residencia');
					return false;
				}
			var id_CiudadResid  = $('#id_CiudadResid').val();
			if(!$.trim(id_CiudadResid)){
					alert('Ingrese la Ciudad de Residencia');
					return false;
				}
                
            var No_Extranjero = $('#No_Extranjero').val();
            var Si_Extranjero = $('#Si_Extranjero').val();
            
            if($('#No_Extranjero').is(':checked')===false && $('#Si_Extranjero').is(':checked')===false){
                alert('Indique Si Ud es Extranjero...?');
                return false;
            }//if
                
			var EmailBosque      = $('#EmailBosque').val();
			var Email_2          = $('#Email_2').val();
			var Nombre_Emerg      = $('#Nom_Emergencia').val();
			if(!$.trim(Nombre_Emerg)){
					alert('Ingrese el Nombre de un Familiar para Casos de Emergencia');
					return false;
				}
			var Parentesco   = $('#Parentesco').val();
			
			if(Parentesco==0){
					alert('Selecione un Parentesco del Familiar en caso de Emergencia');
					return false;
				}
			
			var Telefono1_Parent  = $('#Telefono1_Parent').val();
			if(!$.trim(Telefono1_Parent)){
					alert('Ingrese el Numero de telefono 1 del Familiar para Casos de Emergencia');
					return false;
				}
			var Telefono1_Parent2  = $('#Telefono1_Parent2').val();
			var Eps  = $('#Eps').val();
			
			if(!$.trim(Eps)){
					alert('Ingrese el Nombre de Su EPS...');
					return false;
				}
			var Tipo_Eps ='';
			if($('#Benficiario').is(':checked')){
					var Tipo_Eps = 1
				}
			if($('#Cotizante').is(':checked')){
					var Tipo_Eps = 0
				}
				
			if($('#Benficiario').is(':checked')=== false && $('#Cotizante').is(':checked')===false){
					alert('Selecione un Tipo de Afiliacion \n ejemplo Beneficiario o Cotizante...');
					return false;
				}
				
			if(!$.trim($('#id_CiudadOrigen').val())){
					alert('Ingrese la Ciudad de Origen');
					return false;
				}
                
        /*********************************************************************************/
			var numIndices = $('#numIndices').val();				
			$('#Cadena_Familia').val('');
			/***************************************************/
				for(j=0;j<=numIndices;j++){
					/***************************************************/
						//var id_Existente  = $('#id_RegistroFami_'+j).val();
						var Parentesco_Familia    = $('#Parentesco_'+j).val();  
						  
							if(Parentesco_Familia==0){
									alert('Selecione un Parentesco para uno de los Familiares adicionados');
									return false;
								}
						
						var NivelEdu_Familia	  = $('#NivelEdu_'+j).val(); 
						
								if(NivelEdu_Familia==-1){
									alert('Selecione un Nivel de Educacion para uno de los Familiares adicionados');
									return false;
								}					
						
					/***************************************************/	
					}
		/*******************************************************************************/
        var IndexRecursoFinaciero  = $('#IndexRecursoFinaciero').val();
			
			var ContadorFianciero = 0;
			
			for(t=0;t<IndexRecursoFinaciero;t++){
					
					if($('#Recuso_id_'+t).is(':checked')===false){
							
							ContadorFianciero = parseFloat(ContadorFianciero)+1;
							
						}
						
				}
		
			
			if(ContadorFianciero==IndexRecursoFinaciero){
					alert('Selecione una o mas Opciones de medios de Finaciacion...');
					return false;
				}
			if(ContadorFianciero!=IndexRecursoFinaciero){//ContadorMedios!=ContadorHijos  &&  
					var Save = 2;
				}        	
    /******************************************************/
}//function ValidaGeneral    
function ValidaAcademica(){
    /*******************************************/
    if(!$.trim($('#id_registroLogros').val()) && !$.trim($('#id_RegistroNewActividad').val())){
						
		if($('#Semillero_inv').is(':checked')===false && $('#Repre_Colegio').is(':checked')===false  && $('#Parti_Semillero').is(':checked')===false  && $('#Otra_Participacion').is(':checked')===false  && $('#Part_Congreso').is(':checked')===false  && $('#Intercambio').is(':checked')===false  && $('#Ninguna').is(':checked')===false){
						
						alert('Selecione una O mas de las Opciones...\n *Semilleros de Investigacion \n *Representacion del Colegio en actividades academicas \n *Participacion en Seminarios \n *Participacion en Congresos \n *Intercambio \n *Ninguna \n *Otra');
						return false;
						
					}
				
				if($('#Otra_Participacion').is(':checked')){
						if(!$.trim($('#Cual_Participacion').val())){
								alert('Describa Cual Participacion Academica...');
								return false;
							}
					}	
			
		
			
    if($('#GradoMeritorio').is(':checked')===false  && $('#MencionAcad').is(':checked')===false  && $('#mencionActv').is(':checked')===false  && $('#Becas').is(':checked')===false  && $('#Ninguna_Logro').is(':checked')===false   && $('#Otro_Logro').is(':checked')===false){
						
						alert('Selecione una O mas Opciones...\n *Grado Meritorio \n *Menciones Academicas \n Menciones de Actividades Extracurriculares \n *Becas \n *Ninguna \n *Otra');
						return false;
							
					}
					
				if($('#Otro_Logro').is(':checked')){
						if(!$.trim($('#Cual_Logro').val())){
								alert('Describa Cual Otro Logro Academico...');
								return false;
							}
					}	
			
		
		var Save = 1;		
	
	}
    /*******************************************/
}//function ValidaAcademica
function ValidadPersonal(){
    
    if($('#Enfermeda_Si').is(':checked')===false  && $('#Enfermeda_No').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n 1.Sufre o ha sufrido alguna de los siguientes tipos de Enfermedades ');
				return false;
			}
			
		if($('#Enfermeda_Si').is(':checked')){
				
				if(!$.trim($('#Enf_Endroquina').val())  && !$.trim($('#DesordenMental').val())  && !$.trim($('#Enf_Circulatorio').val())  && !$.trim($('#Enf_Respiratorio').val())  && !$.trim($('#Enf_Locomotor').val())  && !$.trim($('#Enf_Malformaciones').val())  && !$.trim($('#Enf_Otras').val())){
					
						alert('Describa si Usted Sufre de alguna Enfermedad...');
						return false;
					
					}
				
			}
		
		if($('#Alegia_Si').is(':checked')===false  && $('#Alergia_No').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n 2.Alergias');
				return false;
			}
		
		if($('#Alegia_Si').is(':checked')){
				if(!$.trim($('#Cual_Alergia').val())){
						alert('Describa Cual Alegria');
						return false;
					}
			}
		
		
		if($('#UsoMed_Si').is(':checked')===false  && $('#UsoMed_No').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n 3.Uso de Medicamentos Permanentes');
				return false;
			}
		
		if($('#UsoMed_Si').is(':checked')){
				if(!$.trim($('#Cual_UsoMed').val())){
						alert('Describa Cual Medicamento');
						return false;
					}
			}
		
		if($('#Trastorno_Si').is(':checked')===false  && $('#Trastorno_No').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n 4.Trastornos Alimenticios');
				return false;
			}
		
		
		if($('#Trastorno_Si').is(':checked')){
			
				if($('#Anorexia').is(':checked')===false  && $('#Bulimia').is(':checked')===false  && $('#Obesidad').is(':checked')===false  && $('#Otra_Trastorno').is(':checked')===false){
						alert('Selecione una de las Siguientes Opciones \n *Anorexia \n *Bulimia \n *Obesidad \n *Otro');
						return false;
					}
				if($('#Otra_Trastorno').is(':checked')){
						if(!$.trim($('#TrastornoText').val())){
								alert('Describa Cual Otro Trastorno..');
								return false;
							}
					}	
			}
		
		if($('#Si_discapacidad').is(':checked')===false  && $('#No_discapacidad').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n 5. Condición de Discapacidad');
				return false;
			}
		
		if($('#Si_discapacidad').is(':checked')){
			
				if($('#locomocion').is(':checked')===false  && $('#inferior').is(':checked')===false  && $('#Superior').is(':checked')===false  && $('#Paralisis').is(':checked')===false && $('#Visual').is(':checked')===false  && $('#Auditiva').is(':checked')===false  && $('#Habla').is(':checked')===false){
						
						alert('Selecione una De las Opciones de Discapacidad Fisica o Sensorial');
						return false;
					
					}
				if(!$.trim($('#ObservacionCondicionDiscapacidad').val())){
						alert('Describa Su Condicion de Discapacidad');
						return false;
					}	
					
			}
		
		if($('#Sarampion').is(':checked')===false  && $('#Rubeola').is(':checked')===false  && $('#Tetano').is(':checked')===false  && $('#Hepatitis_B').is(':checked')===false  && $('#VPH').is(':checked')===false){
				alert('Selecione que Vacunas Tiene Aplicadas');
				return false;
			
			}
		
		if($('#Hepatitis_B').is(':checked')){
				
				if($('#Hepati_B_Uno').is(':checked')===false  && $('#Hepati_B_Dos').is(':checked')===false  && $('#Hepati_B_Tres').is(':checked')===false){
						alert('Selecione la Dosis de su Vacunacion de Hepatitis B');
						return false;
					}
			}
			
		if($('#VPH').is(':checked')){
				
				if($('#VPH_Uno').is(':checked')===false  && $('#VPH_Dos').is(':checked')===false  && $('#VPH_Tres').is(':checked')===false){
						alert('Selecione la Dosis de su Vacunacion de Virus de Papiloma Humano');
						return false;
					}
			}	
		
		if($('#Si_Vegetales').is(':checked')===false  && $('#No_Vegetales').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n  Es Vegetariano(a)');
				return false;
			}
		
		if($('#Si_Cigarrillo').is(':checked')===false  && $('#No_Cigarrillo').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n  Consume Ud Cigarrillo');
				return false;
			}
			
		if($('#Si_Cigarrillo').is(':checked')){
			
				if($('#C_uno').is(':checked')===false  && $('#C_dos').is(':checked')===false  && $('#C_tres').is(':checked')===false  && $('#C_Cuatro').is(':checked')===false  && $('#C_cinco').is(':checked')===false){
						alert('Selecione una Frecuencia de Consumo de Cigarrillo...');
						return false;
					}
			}
		
		if($('#Si_Alcohol').is(':checked')===false  && $('#No_Alcohol').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Consume Ud Alcohol');
				return false;
			}
			
		if($('#Si_Alcohol').is(':checked')){
			
				if($('#Alcohol_uno').is(':checked')===false  && $('#Alcohol_dos').is(':checked')===false  && $('#Alcohol_tres').is(':checked')===false  && $('#Alcohol_Cuatro').is(':checked')===false  && $('#Alcohol_cinco').is(':checked')===false){
						alert('Selecione una Frecuencia de Consumo de Alcohol...');
						return false;
					}
			}
			
		if($('#Si_Act_Fisica').is(':checked')===false  && $('#No_Act_Fisica').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Realiza algún tipo de Actividad Fisica');
				return false;
			}
		
		if($('#Si_Act_Fisica').is(':checked')){
				if(!$.trim($('#Act_FisicaCual').val())){
						alert('Describa Cual Actividad Fisica...');
						return false;
					}
					
				if($('#Frec_uno').is(':checked')===false  && $('#Frec_dos').is(':checked')===false  && $('#Frec_tres').is(':checked')===false){
						alert('Selecione una Frecuencia de Actividad Fisica...');
						return false;
					}	
			}
		
		if($('#Si_Practica').is(':checked')===false  && $('#No_Practica').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Practica alguna disciplina deportiva');
				return false;
			}
		
		if($('#Si_Practica').is(':checked')){
			
				if($('#Futbol').is(':checked')===false  && $('#F_sala').is(':checked')===false  && $('#Basketball').is(':checked')===false  && $('#Voleibol').is(':checked')===false  && $('#Rugby').is(':checked')===false  && $('#T_mesa').is(':checked')===false  && $('#Tennis').is(':checked')===false  && $('#OtroPractica').is(':checked')===false  && $('#Ciclismo').is(':checked')===false  && $('#Natacion').is(':checked')===false  && $('#Atletismo').is(':checked')===false  && $('#Beisbol').is(':checked')===false  && $('#Ajedrez').is(':checked')===false  && $('#Squash').is(':checked')===false  && $('#Taekwondo').is(':checked')===false){
						alert('Selecione uno o mas Deportes...\n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
						return false;
					}
					
				if($('#Futbol').is(':checked')){
						if($('#Fr_F_Uno').is(':checked')===false  && $('#Fr_F_Dos').is(':checked')===false  && $('#Fr_F_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Futbol \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#F_sala').is(':checked')){
						if($('#Fr_FS_Uno').is(':checked')===false  && $('#Fr_FS_Dos').is(':checked')===false  && $('#Fr_FS_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Futbol Sala \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}	
				/*****************************************/
				if($('#Basketball').is(':checked')){
						if($('#Fr_Bsk_Uno').is(':checked')===false  && $('#Fr_Bsk_Dos').is(':checked')===false  && $('#Fr_Bsk_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Basketball \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Voleibol').is(':checked')){
						if($('#Fr_Vol_Uno').is(':checked')===false  && $('#Fr_Vol_Dos').is(':checked')===false  && $('#Fr_Vol_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Voleibol \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Rugby').is(':checked')){
						if($('#Fr_Rby_Uno').is(':checked')===false  && $('#Fr_Rby_Dos').is(':checked')===false  && $('#Fr_Rby_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Rugby \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#T_mesa').is(':checked')){
						if($('#Fr_TMesa_Uno').is(':checked')===false  && $('#Fr_TMesa_Dos').is(':checked')===false  && $('#Fr_TMesa_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Tennis de Mesa \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
							}
					}
				/*****************************************/
				if($('#Tennis').is(':checked')){
						if($('#Fr_Tennis_Uno').is(':checked')===false  && $('#Fr_Tennis_Dos').is(':checked')===false  && $('#Fr_Tennis_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Tennis \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#OtroPractica').is(':checked')){
						if($('#Fr_OtroDep_Uno').is(':checked')===false  && $('#Fr_OtroDep_Dos').is(':checked')===false  && $('#Fr_OtroDep_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Otro Deporte \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
						if(!$.trim($('#Otro_deporte').val())){
								alert('Describa que Otro Deporte');
								return false;
							}	
					}
				/*****************************************/
				if($('#Ciclismo').is(':checked')){
						if($('#Fr_Cic_Uno').is(':checked')===false  && $('#Fr_Cic_Dos').is(':checked')===false  && $('#Fr_Cic_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Ciclismo \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Natacion').is(':checked')){
						if($('#Fr_Nata_Uno').is(':checked')===false  && $('#Fr_Nata_Dos').is(':checked')===false  && $('#Fr_Nata_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Natacion \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Beisbol').is(':checked')){
						if($('#Fr_Bes_Uno').is(':checked')===false  && $('#Fr_Bes_Dos').is(':checked')===false  && $('#Fr_Bes_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Besibol \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Atletismo').is(':checked')){
						if($('#Fr_Atl_Uno').is(':checked')===false  && $('#Fr_Atl_Dos').is(':checked')===false  && $('#Fr_Atl_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Atletismo \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Ajedrez').is(':checked')){
						if($('#Fr_Ajd_Uno').is(':checked')===false  && $('#Fr_Ajd_Dos').is(':checked')===false  && $('#Fr_Ajd_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Ajedrez \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Squash').is(':checked')){
						if($('#Fr_Sqh_Uno').is(':checked')===false  && $('#Fr_Sqh_Dos').is(':checked')===false  && $('#Fr_Sqh_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Squash \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}
				/*****************************************/
				if($('#Taekwondo').is(':checked')){
						if($('#Fr_Tkw_Uno').is(':checked')===false  && $('#Fr_Tkw_Dos').is(':checked')===false  && $('#Fr_Tkw_Tres').is(':checked')===false){
								alert('Selecione una Frecuencia relacionada a Taekwondo \n Relacionados a la Pregunta \n Practica alguna disciplina deportiva');
								return false;
							}
					}														
			
			}
		/************************************************************************************************************/
		if($('#Si_Pertenece').is(':checked')===false  && $('#No_Pertenece').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Pertenece o ha pertenecido a algun grupo, red o agremiacion nacional o internacional');
				return false;
			}
		if($('#Si_Pertenece').is(':checked')){
				if(!$.trim($('#Pertenece_Cual').val())){
						alert('Describa a Cual Pertenece o Pertenecio Con relacion a \n Pertenece o ha pertenecido a algun grupo, red o agremiacion nacional o internacional');
						return false;
					}
			}	

		if($('#Si_Voluntariado').is(':checked')===false  && $('#No_Voluntariado').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Pertenece o Ha Pertenecido a Algun Tipo de Voluntariado');
				return false;
			}	
		if($('#Si_Voluntariado').is(':checked')){
				if(!$.trim($('#Voluntariado_Cual').val())){
						alert('Describa Cual Voluntariado con Relacion a la Pregunta \n Pertenece o Ha Pertenecido a Algun Tipo de Voluntariado');
						return false;
					}
			}
		/************************************************************************************************************/
		if($('#Si_musica').is(':checked')===false  && $('#No_musica').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
				return false;
			}
		if($('#Si_musica').is(':checked')){
			
			if($('#Guitarra').is(':checked')===false  && $('#Bateria').is(':checked')===false && $('#Saxofon').is(':checked')===false  && $('#Otro_Musica').is(':checked')===false  && $('#Trompeta').is(':checked')===false  && $('#Congas').is(':checked')===false  && $('#Acordion').is(':checked')===false){
					
					alert('Selecione una o mas Opciones... con Relacion a \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
					return false;
				}
				
			/****************************************************/
			if($('#Guitarra').is(':checked')){
					if($('#Nv_Gui_Uno').is(':checked')===false  && $('#Nv_Gui_Dos').is(':checked')===false && $('#Nv_Gui_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Guitarra \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
				}
			/****************************************************/
			if($('#Bateria').is(':checked')){
					if($('#Nv_Bat_Uno').is(':checked')===false  && $('#Nv_Bat_Dos').is(':checked')===false && $('#Nv_Bat_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Bateria \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
				}
			/****************************************************/
			if($('#Saxofon').is(':checked')){
					if($('#Nv_Sax_Uno').is(':checked')===false  && $('#Nv_Sax_Dos').is(':checked')===false && $('#Nv_Sax_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Saxofon \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
				}
			/****************************************************/
			if($('#Otro_Musica').is(':checked')){
					if($('#Nv_OtroMusica_Uno').is(':checked')===false  && $('#Nv_OtroMusica_Dos').is(':checked')===false && $('#Nv_OtroMusica_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Otro Instrumentro \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
					if(!$.trim($('#Cual_Instrumentio').val())){
							alert('Describa Cual Instrumento');
							return false;
						}	
				}
			/****************************************************/
			if($('#Trompeta').is(':checked')){
					if($('#Nv_Trop_Uno').is(':checked')===false  && $('#Nv_Trop_Dos').is(':checked')===false && $('#Nv_Trop_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Trompeta \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
				}
			/****************************************************/
			if($('#Congas').is(':checked')){
					if($('#Nv_Cong_Uno').is(':checked')===false  && $('#Nv_Cong_Dos').is(':checked')===false && $('#Nv_Cong_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Congas \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
				}
			/****************************************************/
			if($('#Acordion').is(':checked')){
					if($('#Nv_Acord_Uno').is(':checked')===false  && $('#Nv_Acord_Dos').is(':checked')===false && $('#Nv_Acord_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Acordion \n Interpreta algun Intrumento Musical  (hobbie o profesional)');
							return false;
						}
				}						
					
		}
	/************************************************************************************************************************/	
		if($('#Si_ExpCorporal').is(':checked')===false  && $('#No_ExpCorporal').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
				return false;
			}
		
		if($('#Si_ExpCorporal').is(':checked')){
			
				if($('#Danza').is(':checked')===false  && $('#Danza_Floclorica').is(':checked')===false  && $('#Danza_Moderna').is(':checked')===false && $('#Otra_Danza').is(':checked')===false  && $('#Danza_Contemporanea').is(':checked')===false  && $('#Ballet').is(':checked')===false){
					
						alert('Selecione una o mas Opciones... \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
						return false;
					
					}
					
				/***********************************/	
				if($('#Danza').is(':checked')){
						if($('#Nv_Danza_Uno').is(':checked')===false  && $('#Nv_Danza_Dos').is(':checked')===false && $('#Nv_Danza_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Danza \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Danza_Floclorica').is(':checked')){
						if($('#Nv_DzFol_Uno').is(':checked')===false  && $('#Nv_DzFol_Dos').is(':checked')===false && $('#Nv_DzFol_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Danza Floclorica \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Danza_Moderna').is(':checked')){
						if($('#Nv_DzMod_Uno').is(':checked')===false  && $('#Nv_DzMod_Dos').is(':checked')===false && $('#Nv_DzMod_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Danza Moderna \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Otra_Danza').is(':checked')){
						if($('#Nv_DzOtra_Uno').is(':checked')===false  && $('#Nv_DzOtra_Dos').is(':checked')===false && $('#Nv_DzOtra_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Otra Danza  \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
							return false;
						}
					   if(!$.trim($('#Cual_Danzas').val())){
						   	alert('Describa Cual Danza');
							return false;
						   }	
					}
				/***********************************/	
				if($('#Danza_Contemporanea').is(':checked')){
						if($('#Nv_DzCont_Uno').is(':checked')===false  && $('#Nv_DzCont_Dos').is(':checked')===false && $('#Nv_DzCont_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Danza Contemporanea \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Ballet').is(':checked')){
						if($('#Nv_Ballet_Uno').is(':checked')===false  && $('#Nv_Ballet_Dos').is(':checked')===false && $('#Nv_Ballet_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Ballet \n  Ejecuta Algun Tipo de Practica de Expresión Corporal (hobbie o profesional)');
							return false;
						}
					}					
			}
		/*******************************************************************************************************************/
		if($('#Si_Arte').is(':checked')===false  && $('#No_Arte').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
				return false;
			}
		
		if($('#Si_Arte').is(':checked')){
				if($('#Teatro').is(':checked')===false  && $('#actuacion').is(':checked')===false  && $('#narracion').is(':checked')===false && $('#standcomedy').is(':checked')===false  && $('#Otro_arte').is(':checked')===false){
					
						alert('Selecione una o mas Opciones... \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
						return false;
					
					}
				/***********************************/	
				if($('#Teatro').is(':checked')){
						if($('#Nv_Teatro_Uno').is(':checked')===false  && $('#Nv_Teatro_Dos').is(':checked')===false && $('#Nv_Teatro_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Teatro \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#actuacion').is(':checked')){
						if($('#Nv_Actua_Uno').is(':checked')===false  && $('#Nv_Actua_Dos').is(':checked')===false && $('#Nv_Actua_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Actuacion  \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#narracion').is(':checked')){
						if($('#Nv_Narra_Uno').is(':checked')===false  && $('#Nv_Narra_Dos').is(':checked')===false && $('#Nv_Narra_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Narracion  \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#standcomedy').is(':checked')){
						if($('#Nv_Stand_Uno').is(':checked')===false  && $('#Nv_Stand_Dos').is(':checked')===false && $('#Nv_Stand_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Stand Comedy  \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Otro_arte').is(':checked')){
						if($('#Nv_OtroEscen_Uno').is(':checked')===false  && $('#Nv_OtroEscen_Dos').is(':checked')===false && $('#Nv_OtroEscen_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Otro Arte Escenico \n  realiza usted alguntipo de artes escenicas (hobbie o profesional)');
							return false;
						}
						if(!$.trim($('#Cual_arte').val())){
								alert('Describa Cual Arte Escenico');
								return false;
							}
					}						
			}
		/*************************************************************************************************************************************/
		
		if($('#Si_Literaria').is(':checked')===false  && $('#No_Literaria').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n   Realiza Algun Arte Literaria (hobbie o profesional)');
				return false;
			}
		
		if($('#Si_Literaria').is(':checked')){
				if($('#poesia').is(':checked')===false  && $('#cuento').is(':checked')===false  && $('#novela').is(':checked')===false && $('#cronica').is(':checked')===false  && $('#Otro_Literatura').is(':checked')===false){
					
						alert('Selecione una o mas Opciones...\n   Realiza Algun Arte Literaria (hobbie o profesional)');
						return false;
					
					}
				/***********************************/	
				if($('#poesia').is(':checked')){
						if($('#Nv_poesia_Uno').is(':checked')===false  && $('#Nv_poesia_Dos').is(':checked')===false && $('#Nv_poesia_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Poesia \n   Realiza Algun Arte Literaria (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#cuento').is(':checked')){
						if($('#Nv_cuento_Uno').is(':checked')===false  && $('#Nv_cuento_Dos').is(':checked')===false && $('#Nv_cuento_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Cuento \n   Realiza Algun Arte Literaria (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#novela').is(':checked')){
						if($('#Nv_novela_Uno').is(':checked')===false  && $('#Nv_novela_Dos').is(':checked')===false && $('#Nv_novela_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Novela \n   Realiza Algun Arte Literaria (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#cronica').is(':checked')){
						if($('#Nv_cronica_Uno').is(':checked')===false  && $('#Nv_cronica_Dos').is(':checked')===false && $('#Nv_cronica_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a  Cronica \n   Realiza Algun Arte Literaria (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Otro_Literatura').is(':checked')){
						if($('#Nv_Otro_Literatura_Uno').is(':checked')===false  && $('#Nv_Otro_Literatura_Dos').is(':checked')===false && $('#Nv_Otro_Literatura_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Otro Arte Literario \n   Realiza Algun Arte Literaria (hobbie o profesional)');
							return false;
						}
						if(!$.trim($('#Cual_Literatura').val())){
								alert('Describa Cual Arte Literario');
								return false;
							}
					}		
			
			}
		
		/******************************************************************************************************************************************/
		if($('#Si_Plastica').is(':checked')===false  && $('#No_Plastica').is(':checked')===false){
				alert('Selecione una de las Opciones de la Pregunta... \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)  ');
				return false;
			}
		
		if($('#Si_Plastica').is(':checked')){
				if($('#fotografia').is(':checked')===false  && $('#video').is(':checked')===false  && $('#diseno_Gra').is(':checked')===false && $('#comic').is(':checked')===false  && $('#Otro_Plastico').is(':checked')===false && $('#dibujo').is(':checked')===false  && $('#grafitty').is(':checked')===false && $('#escultura').is(':checked')===false  && $('#pintura').is(':checked')===false){
					
						alert('Selecione una o mas Opciones... \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
						return false;
					
					}
					
				/***********************************/	
				if($('#fotografia').is(':checked')){
						if($('#Nv_fotografia_Uno').is(':checked')===false  && $('#Nv_fotografia_Dos').is(':checked')===false && $('#Nv_fotografia_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Fotografia \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#video').is(':checked')){
						if($('#Nv_video_Uno').is(':checked')===false  && $('#Nv_video_Dos').is(':checked')===false && $('#Nv_video_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Video \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#diseno_Gra').is(':checked')){
						if($('#Nv_diseno_Gra_Uno').is(':checked')===false  && $('#Nv_diseno_Gra_Dos').is(':checked')===false && $('#Nv_diseno_Gra_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Dise\u00f1o Grafico \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#comic').is(':checked')){
						if($('#Nv_comic_Uno').is(':checked')===false  && $('#Nv_comic_Dos').is(':checked')===false && $('#Nv_comic_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Comic \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#Otro_Plastico').is(':checked')){
						if($('#Nv_Otro_PV_Uno').is(':checked')===false  && $('#Nv_Otro_PV_Dos').is(':checked')===false && $('#Nv_Otro_PV_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Otro Arte Plastico \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
						if(!$.trim($('#Cual_ArtePlastico').val())){
								alert('Describa Cual Arte Plastico');
								return false;
							}
					}	
				/***********************************/	
				if($('#dibujo').is(':checked')){
						if($('#Nv_dibujo_Uno').is(':checked')===false  && $('#Nv_dibujo_Dos').is(':checked')===false && $('#Nv_dibujo_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Dibujo \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#grafitty').is(':checked')){
						if($('#Nv_grafitty_Uno').is(':checked')===false  && $('#Nv_grafitty_Dos').is(':checked')===false && $('#Nv_grafitty_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Grafitty \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#escultura').is(':checked')){
						if($('#Nv_escultura_Uno').is(':checked')===false  && $('#Nv_escultura_Dos').is(':checked')===false && $('#Nv_escultura_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Escultura \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}
				/***********************************/	
				if($('#pintura').is(':checked')){
						if($('#Nv_pintura_Uno').is(':checked')===false  && $('#Nv_pintura_Dos').is(':checked')===false && $('#Nv_pintura_Tres').is(':checked')===false){
							alert('Selecione una Opcion de Nivel Relacionado a Pintura \n Realiza Algun Arte Plastica y/o Visual  (hobbie o profesional)');
							return false;
						}
					}		
			}
		/********************************************************************************************************************************/
}//function ValidadPersonal