// JavaScript Document
bkLib.onDomLoaded(function() {
                     var myNicEditor = new nicEditor({fullPanel : true,iconsPath : '../../images/nicEditorIcons.gif'});
                    myNicEditor.setPanel('menuEditor');
                    myNicEditor.addInstance('Cuerpo');    
            });
			
function FormatDocumento(){
		$('#Documento').val('');
		$('#id_Documento').val('');
	}
function AutocompletDocumento(){
	/********************************************************/	
	$('#Datos_Tr').css('visibility','collapse');
		$('#Documento').autocomplete({
				
				source: "Texto_Inicio.html.php?actionID=AutoCompleteDocumento",
				minLength: 2,
				select: function( event, ui ) {
					
					$('#id_Documento').val(ui.item.id_Documento);
					/*******************************************/
					$('#Datos_Tr').css('visibility','visible');
					$('#Nombre').html(ui.item.Documento);
					$('#Entidad').html(ui.item.Entidad);
					$('#Tipo').html(ui.item.Tipo);
					$('#Inicial').html(ui.item.Inicial);
					$('#Final').html(ui.item.Final);
					
					}
				
			});//
	/********************************************************/	
	}
function FormatTitulo(){
		$('#Titulo').val('');
	}
function FormatAutor(){
		$('#Autor').val('');
	}
function FormatDependencia(){
		$('#Dependencia').val('');
	}
function SaveInfo(){
	/*******************************************************/
	
		if(!$.trim($('#id_Documento').val())){
				alert('Debe Selecionar o Buscar un Documento de Acreditacion para Poder Asociar');
				$('#Documento').effect("pulsate", {times:3}, 500);
				$('#Documento').css('border-color','#F00');
				return false;			
			}
		
	/*******************************************************/
	
		if(!$.trim($('#Titulo').val())){
				alert('Digite un Titulo Para el Documento que desea Adicionar');
				$('#Titulo').effect("pulsate", {times:3}, 500);
				$('#Titulo').css('border-color','#F00');
				return false;			
			}
	
	/*******************************************************/
		
	document.getElementById("Cuerpo").innerHTML = nicEditors.findEditor('Cuerpo').getContent();	
		
		if(!$.trim($('#Cuerpo').val())){
				alert('Digite El Cuerpo o Descripcion del Documento que Desea Asociar');
				$('#Cuerpo').effect("pulsate", {times:3}, 500);
				$('#Cuerpo').css('border-color','#F00');
				return false;			
			}
	
	 
	
	/*******************************************************/
		
		var id_Documento   = $('#id_Documento').val();
		var Titulo		   = $('#Titulo').val();
		var Cuerpo		   = $('#Cuerpo').val();
		var Autor  		   = $('#Autor').val();
		var Dependencia	   = $('#Dependencia').val();
		
		 $.ajax({//Ajax
					  type: 'POST',
					  url: 'Texto_Inicio.html.php',
					  async: false,
					  dataType: 'json',
					  data:({actionID:'Save',
					  		 id_Documento:id_Documento,
					  		 Titulo:Titulo,
							 Cuerpo:Cuerpo,
							 Autor:Autor,
							 Dependencia:Dependencia}),
					 error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
					 success:function(data){
						 	if(data.val=='FALSE'){
									alert(data.descrip);
									return false;
								}else{
									alert(data.descrip);
										if(confirm('Desea Adicionar Otro Texto Inicial...?')){
													
												$('#Titulo').val('');
												$('#Cuerpo').val('');
												$('#Autor').val('');
												$('#Dependencia').val('');	
													
											}else{
													location.href='Texto_Inicio.html.php';
												}
									}
				   }
		   		}); //AJAX
	
	/*******************************************************/
  }
		