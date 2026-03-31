/**
 * @author Ivan quintero 
 * Febrero 22, 2017
 */

$("#addPrograma").on("click", function( ){
	
	var principal = $( this ).attr( "id" );
	$( "#dvDetallePrograma" ).slideToggle( "slow", function( ){
		var secundario = $( this ).attr( "id" );
		rotar( principal, secundario );	
	});
	
});

$("#addProyecto").on("click", function( ){
	var principal = $( this ).attr( "id" );
	$( "#dvDetalleProyecto" ).slideToggle( "slow", function( ){
		var secundario = $( this ).attr( "id" );
		rotar( principal, secundario );	
	});
});

$("#addMeta").on("click", function( ){
	var principal = $( this ).attr( "id" );
	$( "#detalleIndicador" ).slideToggle( "slow", function( ){
		var secundario = $( this ).attr( "id" );
		rotar( principal, secundario );
	});
});

$("#btnMetaPrincipal").button( ).click(function( ){
	
});

$("#cmbFacultadPlanDesarrollo").change(function(){
	updateSelectLists();
});


function updateSelectLists(){
	var cmbFacultadPlanDesarrollo = $("#cmbFacultadPlanDesarrollo").val(); 
	var url = '../interfaz/listaPlanDesarrollo.php';
	
	 $.ajax({
        dataType: 'json',
        type: 'POST',
        url: url,
        data: {
        
			cmbFacultadPlanDesarrollo : cmbFacultadPlanDesarrollo 
        },
        success: function(data) {
        	if(data.success){
        		//$("#log").html( data );
        		$('#cmbCarreraRegistrar').html(data.values.programasPlanDesarrollo);
        		$(".chosen-select").trigger("chosen:updated");
        	}
        },
        error: function(xhr, status, error) {
        	alert("An error occured: " + status + "\nError: " + error);
        }
    });  
	 
}



var dates = $( "#txtFechaInicioMeta, #txtFechaFinalMeta"  ).datepicker({
	defaultDate: "0w",
	changeMonth: true,
	numberOfMonths: 2,
	changeYear: true,
	dateFormat : 'yy-mm-dd',
	monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	  minDate: 0,
	onSelect: function( selectedDate ) {
		var option = this.id == "txtFechaInicioMeta" ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
				instance.settings.dateFormat ||
				$.datepicker._defaults.dateFormat,
				selectedDate, instance.settings );
		dates.not( this ).datepicker( "option", option, date );
	}
},$.datepicker.regional["es"]);



/*modified Diego Fernando Rivera <riveradiego@unbosque.edu.co>
 *se añade autocompletar a campos  txtResponsableProgramaEmail y txtResponsableProyectoEmail
 * Since April 20 ,2017
 * */	
	$("#txtResponsableProgramaEmail").autocomplete({
	       source: "../interfaz/autocompletarEmail.php",
	       minLength: 3,
	       select: function(event, ui) {
		   event.preventDefault();
	       $('#txtResponsableProgramaEmail').val(ui.item.txtEmail);
		   $('#txtResponsablePrograma').val(ui.item.txtActualizaResponsableMeta);
		
		  }
	});
	
	$("#txtResponsableProyectoEmail").autocomplete({
	       source: "../interfaz/autocompletarEmail.php",
	       minLength: 3,
	       select: function(event, ui) {
		   event.preventDefault();
	       $('#txtResponsableProyectoEmail').val(ui.item.txtEmail);
		   $('#txtResponsableProyecto').val(ui.item.txtActualizaResponsableMeta);
		
		  }
	});
	
	
		$("#txtResponsableMetaEmail").autocomplete({
	       source: "../interfaz/autocompletarEmail.php",
	       minLength: 3,
	       select: function(event, ui) {
		   event.preventDefault();
	       $('#txtResponsableMetaEmail').val(ui.item.txtEmail);
		   $('#txtResponsableMeta').val(ui.item.txtActualizaResponsableMeta);
		
		  }
	});
	
	
	






/*$("#txtDirectivo").keyup(function(){
	//source: function( ) {
		var tipoOperacion = "listaUsuarios";
		var txtNombres = $("#txtDirectivo").val( );
		$.ajax({
	  		url: "../servicio/contacto.php",
	  		type: "POST",
	  		data: { tipoOperacion : tipoOperacion, txtNombres : txtNombres },
	  		beforeSend: function(){
				$("#txtDirectivo").css('background','#FFF url("../css/images/LoaderIcon.gif") no-repeat 100px');
			},
			success: function( data ){
				$("#suggesstion-box").show();
				$("#suggesstion-box").html(data);
				$("#txtDirectivo").css("background","#FFF");
				//$("#txtDirectivo").append( data );
			}
		});
	//}
});*/


/*$(function( ){
	
	var cuentaPrograma =0;
	var limiteResponsablePrograma = 2;
	$("#addResponsablePrograma").on("click", function( ){
		if( cuentaPrograma < limiteResponsablePrograma ){
			cuentaPrograma++;
			$("#responsablePrograma").append('<input type="text" id="programaResponsable_'+ cuentaPrograma +'" name="programaResponsable[]" class="form-control" />');
		//cuenta = cuenta + 1;
		}else{
			alert( "Ha excedido el límite de responsables" );
		}
		return false;
	});
	
	$("#deleteResponsablePrograma").on("click", function( ){
		if( cuentaPrograma > 0 ){
			$("#programaResponsable_"+ cuentaPrograma ).remove( );
			cuentaPrograma--;
		}
		return false;
	});
	
	
	
	
	var cuenta =0;
	var limiteResponsableProyecto = 2;
	$("#addResponsableProyecto").on("click", function( ){
		if( cuenta < limiteResponsableProyecto ){
			cuenta++;
			$("#contenedorResponsable").append('<input type="text" id="proyectoResponsable_'+ cuenta +'" name="proyectoResponsable[]" class="form-control" />');
		}else{
			alert( "Ha excedido el límite de responsables" );
		}
		return false;
	});
	
	$("#deleteResponsableProyecto").on("click", function( ){
		if( cuenta > 0 ){
			$("#proyectoResponsable_"+ cuenta ).remove( );
			cuenta--;
		}
		return false;
	});

});*/
              
 $('.campoNumeros').keyup(function (){
       this.value = (this.value + '').replace(/[^0-9]/g, '');
    });

                  
var divProyecto = '<div id="dvProyectoNuevo" class="dvProyectoNuevo">\
					<br/><div class="strike">\
	    					<span>Proyecto</span>\
						</div><br/>\
                    <table width="100%" border="0">\
                        <tr>\
                        	<td width="27%"><span>Proyecto:</span></td>\
	                        <td width="73%"><input type="text" id="txtProyectoNuevo" name="txtProyecto[]" /><img id="addProyectoNuevo" class="addPrograma" rel="dvDetalleProyectoNuevo" src="../css/images/plusAzul.png" width="24" height="24" /><button id="btnDeleteProyectoNuevo" class="btnDeleteProyecto btn btn-warning" rel="dvProyectoNuevo"><i class="fa fa-minus-circle" aria-hidden="true"></i> Proyecto</button></td>\
                        </tr>\
                        <tr>\
                        	<td>&nbsp;</td>\
                        </tr>\
                    </table>\
                    <table width="100%" border="0">\
                    <tr>\
						<td>\
							<div id="dvDetalleProyectoNuevo" style="display: none;">\
								<fieldset>\
									<legend>Detalles Proyecto</legend>\
									<table width="75%" border="0">\
										<tr>\
											<td width="36%"><span>Justificación:</span></td>\
											<td width="64%"><textarea id="justifiProyectoNuevo" name="justifiProyecto[]" rows="3"></textarea></td>\
										</tr>\
										<tr>\
				                        	<td>&nbsp;</td>\
				                        </tr>\
										<tr>\
											<td><span>Descripción:</span></td>\
											<td><textarea id="descProyectoNuevo" name="descProyecto[]" rows="3"></textarea></td>\
										</tr>\
										<tr>\
				                        	<td>&nbsp;</td>\
				                        </tr>\
										<tr>\
											<td><span>Objetivos:</span></td>\
											<td><textarea id="objProyectoNuevo" name="objProyecto[]" rows="3"></textarea></td>\
										</tr>\
										<tr>\
				                        	<td>&nbsp;</td>\
				                        </tr>\
										<tr>\
											<td><span>Acciones:</span></td>\
											<td><textarea id="accProyectoNuevo" name="accProyecto[]" rows="3"></textarea></td>\
										</tr>\
										<tr>\
				                        	<td>&nbsp;</td>\
				                        </tr>\
				                        <tr>\
											<td><span>Email:</span></td>\
											<td>\
												<div id="contenedorResponsableEmail">\
													<input type="text" id="txtResponsableProyectoEmailNuevo" name="txtResponsableProyectoEmail[]" />\
												<div>\
											</td>\
										</tr>\
										<tr>\
				                        	<td>&nbsp;</td>\
				                        </tr>\
										<tr>\
											<td><span>Responsable:</span></td>\
											<td>\
												<div id="responsableProyectoOtrodvProyectoNuevo">\
													<input type="text" id="txtResponsableProyectoNuevo" name="txtResponsableProyecto[]" />\
												<div>\
											</td>\
										</tr>\
										<tr>\
				                        	<td>&nbsp;</td>\
				                        </tr>\
									</table>\
								</fieldset>\
							</div>\
						</td>\
					</tr>\
                    </table>\
                        <div id="dvIndicadorNuevo">\
                        <table width="100%" border="0">\
                            <tr>\
                                <td width="27%">Tipo Indicador:</td>\
                                <td width="35%"><input type="radio" id="ckTipoIndicadorCuantitativoNuevo" name="ckTipoIndicador" value="1" />Cuantitativo</td>\
                                <td width="38%"><input type="radio" id="ckTipoIndicadorCualitativoNuevo" name="ckTipoIndicador" value="2" />Cualitativo<button id="btnAddIndicadorNuevo" class="btnOtroIndicador btn btn-warning" rel="dvIndicadorNuevo" alt="dvProyectoNuevo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Indicador</button></td>\
                            </tr>\
                            <tr>\
	                        	<td>&nbsp;</td>\
	                        </tr>\
                        </table>\
                        <table width="100%" border="0">\
                        	<tr>\
                                <td width="27%">Indicador</td>\
                                <td width="73%"><input type="text" id="txtIndicadorNuevo" name="txtIndicador" /><img id="addMetaNuevo" class="addPrograma" rel="detalleIndicadorNuevo" src="../css/images/plusAzul.png" width="24" height="24" /><!--<a id="btnMetaPrincipalNuevo" class="btnMetaPrincipal btn btn-warning" rel="detalleIndicadorNuevo" alt="dvProyectoNuevo">+ Meta Principal</a>--></td>\
                            </tr>\
                            <tr>\
	                        	<td>&nbsp;</td>\
	                        </tr>\
                        </table>\
                        <table width="100%" border="0">\
                            <tr>\
                                <td>\
                                    <div id="detalleIndicadorNuevo" class="dvDetalleIndicadorNuevo" style="display: none;">\
                                        <fieldset>\
                                            <legend>Metas Indicador</legend>\
                                            <div id="dvMetaIndicadorNuevo" class="dvMetaIndicadorNuevo">\
                                                <br />\
                                                <table width="84%" border="0">\
                                                	<tr>\
                                                		<td width="30%">Meta Principal</td>\
                                                		<td width="70%"><input type="text" id="txtMetaPrincipalNuevo" name="txtMetaPrincipal" /></td>\
                                                	</tr>\
                                                	<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                	<tr>\
                                                		<td>Vigencia</td>\
                                                		<td><input type="text" id="txtVigenciaMetaPrincipalNuevo" name="txtVigenciaMetaPrincipal" value="2021" /> </td>\
                                                	</tr>\
                                                	<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                	<tr>\
                                                		<td>Valor Meta</td>\
                                                		<td><input type="text" class="campoNumeros" id="txtValorMetaPrincipalNuevo" name="txtValorMetaPrincipal" /></td>\
                                                	</tr>\
                                                	<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>\
                                                <!-- <legend>Avances Anuales</legend>\
                                                <table width="75%" border="0">\
                                                    <tr>\
                                                        <td width="195">Meta Secundaria:</td>\
                                                        <td width="388"><input type="text" id="txtMetaNuevo" name="txtMeta" /><a id="btnAddMetaNuevo" class="btnAddMeta btn btn-warning" rel="dvProyectoNuevo" alt="dvAgregarMetaNuevo"><i class="fa fa-plus-circle" aria-hidden="true"></i> Meta</a></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                 </table>\
                                                 <table width="75%" border="0">\
                                                 	<tr>\
                                                        <td width="195">Fecha Inicio: </td>\
                                                        <td width="144"><input type="text" id="txtFechaInicioMetaNuevo" name="txtFechaInicioMeta" /></td>\
                                                        <td width="92">Fecha Final: </td>\
                                                        <td width="144"><input type="text" id="txtFechaFinalMetaNuevo" name="txtFechaFinalMeta" /></td>\
                                                    </tr>\
                                                     <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>\
                                                <table width="75%" border="0">\
                                            		<tr>\
                                                        <td width="195">Avance Esperado:</td>\
                                                        <td width="388"><input type="text" class="campoNumeros" id="txtValorMetaNuevo" name="txtValorMeta" /></td>\
                                                    </tr>\
                                                     <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
							                        <tr>\
							                        	<td>Acciones:</td>\
														<td><textarea id="txtAccionMetaNuevo" name="txtAccionMeta" rows="3"></textarea></td>\
													</tr>\
													<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                    <tr>\
                                                        <td width="195">Responsable:</td>\
                                                        <td width="388"><input type="text" id="txtResponsableMetaNuevo" name="txtResponsableMeta" /></td>\
                                                    </tr>\
                                                     <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table> -->\
                                            </div>\
                                            <div id="dvAgregarMetaNuevo" class="dvAgregarMetaNuevo">\
											</div>\
											<br />\
                                        </fieldset>\
                                    </div>\
                                </td>\
                            </tr>\
                        </table>\
                        </div>\
                    </div>';

var divIndicador = '<div id="dvIndicadorAgregado" class="dvIndicadorAgregado">\
						<br/><div class="strike">\
	    					<span>Indicador</span>\
						</div><br/>\
                        <table width="100%" border="0">\
                            <tr>\
                                <td width="27%">Tipo Indicador:</td>\
                                <td width="35%"><input type="radio" id="ckTipoIndicadorCuantitativoAgregado" name="ckTipoIndicador" value="1" />Cuantitativo</td>\
                                <td width="38%"><input type="radio" id="ckTipoIndicadorCualitativoAgregado" name="ckTipoIndicador" value="2" />Cualitativo</td>\
                            </tr>\
                             <tr>\
	                        	<td>&nbsp;</td>\
	                        </tr>\
                        </table>\
                        <table width="100%" border="0">\
                        	<tr>\
                                <td width="20%">Indicador</td>\
                                <td width="80%"><input type="text" id="txtIndicadorAgregado" name="txtIndicador" /><img id="addMetaAgregado" class="addPrograma" rel="detalleIndicadorAgregado" src="../css/images/plusAzul.png" width="24" height="24" /><button id="btnDeleteIndicadorAgregado" class="btnDeleteProyecto btn btn-warning" rel="dvIndicadorAgregado"><i class="fa fa-minus-circle" aria-hidden="true"></i> Indicador</button></td>\
                            </tr>\
                            <tr>\
	                        	<td>&nbsp;</td>\
	                        </tr>\
                        </table>\
                        <table width="100%" border="0">\
                            <tr>\
                                <td>\
                                    <div id="detalleIndicadorAgregado" class="dvDetalleIndicadorAgregado" style="display: none;">\
                                        <fieldset>\
                                            <legend>Metas Indicador</legend>\
                                            <div id="dvMetaIndicadorAgregado" class="dvMetaIndicadorAgregado">\
                                                <br />\
                                                <table width="84%" border="0">\
                                                	<tr>\
                                                		<td width="30%">Meta Principal</td>\
                                                		<td width="70%"><input type="text" id="txtMetaPrincipalAgregado" name="txtMetaPrincipal" /><!--<a id="btnMetaPrincipalAgregado" class="btnMetaPrincipal" rel="detalleIndicadorAgregado" alt="dvIndicadorAgregado">+ Meta Principal</a>--> </td>\
                                                	</tr>\
                                                	<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                	<tr>\
                                                		<td>Vigencia</td>\
                                                		<td><input type="text" id="txtVigenciaMetaPrincipalAgregado" name="txtVigenciaMetaPrincipal" value="2021" /> </td>\
                                                	</tr>\
                                                	<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                	<tr>\
                                                		<td>Valor Meta</td>\
                                                		<td><input type="text" class="campoNumeros" id="txtValorMetaPrincipalAgregado" name="txtValorMetaPrincipal" /></td>\
                                                	</tr>\
                                                	<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>\
                                                <!--<legend>Avances Anuales</legend>\
                                                <table width="75%" border="0">\
                                                    <tr>\
                                                        <td width="195">Meta Secundaria:</td>\
                                                        <td width="388"><input type="text" id="txtMetaAgregado" name="txtMeta" /><button id="btnAddMetaAgregado" class="btnAddMeta btn btn-warning" rel="dvAgregarMetaAgregado" alt="dvIndicadorAgregado"><i class="fa fa-plus-circle" aria-hidden="true"></i> Meta</button></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                 </table>\
                                                 <table width="75%" border="0">\
                                                 	<tr>\
                                                        <td width="195">Fecha Inicio: </td>\
                                                        <td width="144"><input type="text" id="txtFechaInicioMetaAgregado" name="txtFechaInicioMeta" /></td>\
                                                        <td width="92">Fecha Final: </td>\
                                                        <td width="144"><input type="text" id="txtFechaFinalMetaAgregado" name="txtFechaFinalMeta" /></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>\
                                                <table width="75%" border="0">\
                                                	<tr>\
                                                        <td width="195">Avance Esperado:</td>\
                                                        <td width="388"><input type="text" class="campoNumeros"  id="txtValorMetaAgregado" name="txtValorMeta" /></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
							                        <tr>\
							                        	<td>Acciones:</td>\
														<td><textarea id="txtAccionMetaAgregado" name="txtAccionMeta" rows="3"></textarea></td>\
													</tr>\
													<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                    <tr>\
                                                        <td width="195">Responsable:</td>\
                                                        <td width="388"><input type="text" id="txtResponsableMetaAgregado" name="txtResponsableMeta" /></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>-->\
                                            </div>\
                                            <div id="dvAgregarMetaAgregado" class="dvAgregarMetaAgregado">\
											</div>\
											<br />\
                                        </fieldset>\
                                    </div>\
                                </td>\
                            </tr>\
                        </table>\
                        </div>';
                        
var dvMeta = '<div id="dvMetaIndicadorAgregadoNueva" class="dvMetaIndicadorAgregadoNueva">\
                                                <br />\
                                                <table width="100%" border="0">\
                                                    <tr>\
                                                        <td width="27%">Meta Secundaria:</td>\
                                                        <td width="73%"><input type="text" id="txtMetaAgregadoNueva" name="txtMeta"  /><button id="btnDeleteMetaAgregadoNueva" class="btnAddMeta btn btn-warning" rel="dvContenedorMetaAgregadoNueva_" alt="dvContenedorMetaAgregado_"><i class="fa fa-minus-circle" aria-hidden="true"></i> Meta</button></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                 </table>\
                                                 <table width="75%" border="0">\
                                                 	<tr>\
                                                        <td width="195">Fecha Inicio: </td>\
                                                        <td width="144"><input type="text" id="txtFechaInicioMetaAgregadoNueva" name="txtFechaInicioMeta" /></td>\
                                                        <td width="92">Fecha Final: </td>\
                                                        <td width="144"><input type="text" id="txtFechaFinalMetaAgregadoNueva" name="txtFechaFinalMeta" /></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>\
                                                <table width="100%" border="0">\
                                            		<tr>\
                                                        <td width="195">Avance Esperado:</td>\
                                                        <td width="388"><input type="text" class="campoNumeros"  id="txtValorMetaAgregadoNueva" name="txtValorMeta" style="width: 100px" /></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
							                        <tr>\
							                        	<td>Acciones:</td>\
														<td><textarea id="txtAccionMetaAgregadoNueva" name="txtAccionMeta" rows="3" style="width: 550px"></textarea></td>\
													</tr>\
													<tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
							                        <tr>\
                                                        <td width="195">Email:</td>\
                                                        <td width="388"><input type="text" id="txtResponsableMetaAgregadoNuevaEmail" name="txtResponsableMetaEmail" style="width: 550px"/></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                    <tr>\
                                                        <td width="195">Responsable:</td>\
                                                        <td width="388"><input type="text" id="txtResponsableMetaAgregadoNueva" name="txtResponsableMeta" style="width: 550px"/></td>\
                                                    </tr>\
                                                    <tr>\
							                        	<td>&nbsp;</td>\
							                        </tr>\
                                                </table>\
                                            </div>\
                                            ';
                                            
/*var divMetaPrincipal = '<div id="detalleIndicadorMPrincipal" class="dvDetalleIndicadorMPrincipal">\
                                        <fieldset>\
                                            <legend>Metas Indicador</legend>\
                                            <div id="dvMetaIndicadorMPrincipal" class="dvMetaIndicadorMPrincipal">\
                                                <br />\
	                                                <table width="84%" border="0">\
	                                                	<tr>\
	                                                		<td width="30%">Meta Principal</td>\
	                                                		<td width="70%"><input type="text" id="txtMetaPrincipalMPrincipal" name="txtMetaPrincipal[]" /><!--<a id="btnDeleteMetaMPrincipal" class="btnMetaPrincipal btn btn-warning" rel="detalleIndicadorMPrincipal">- M Principal</a>--> </td>\
	                                                	</tr>\
	                                                	<tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
	                                                	<tr>\
	                                                		<td>Vigencia</td>\
	                                                		<td><input type="text" id="txtVigenciaMetaPrincipalMPrincipal" name="txtVigenciaMetaPrincipal[]" value="2021" /> </td>\
	                                                	</tr>\
	                                                	<tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
	                                                	<tr>\
	                                                		<td>Valor Meta</td>\
	                                                		<td><input type="text" class="campoNumeros" id="txtValorMetaPrincipalMPrincipal" name="txtValorMetaPrincipal[]" /></td>\
	                                                	</tr>\
	                                                	<tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
	                                                </table>\
                                                	<legend>Metas Secundarias</legend>\
	                                                <table width="75%" border="0">\
	                                                    <tr>\
	                                                        <td width="195">Meta Secundaria:</td>\
	                                                        <td width="388"><input type="text" id="txtMetaMPrincipal" name="txtMeta[]" /><a id="btnAddMetaMPrincipal" class="btnAddMeta btn btn-warning" rel="dvAgregarMetaMPrincipal" alt="detalleIndicadorMPrincipal"><i class="fa fa-plus-circle" aria-hidden="true"></i> Meta</a></td>\
	                                                    </tr>\
	                                                    <tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
                                              		</table>\
	                                                 <table width="75%" border="0">\
	                                                 	<tr>\
	                                                        <td width="195">Fecha Inicio: </td>\
	                                                        <td width="144"><input type="text" id="txtFechaInicioMetaMPrincipal" name="txtFechaInicioMeta[]" /></td>\
	                                                        <td width="92">Fecha Final: </td>\
	                                                        <td width="144"><input type="text" id="txtFechaFinalMetaMPrincipal" name="txtFechaFinalMeta[]" /></td>\
	                                                    </tr>\
	                                                    <tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
	                                                </table>\
	                                                <table width="75%" border="0">\
	                                               		<tr>\
	                                                        <td width="195">Valor:</td>\
	                                                        <td width="388"><input type="text" id="txtValorMetaMPrincipal" name="txtValorMeta[]" /></td>\
	                                                    </tr>\
	                                                    <tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
	                                                    <tr>\
	                                                        <td width="195">Responsable:</td>\
	                                                        <td width="388"><input type="text" id="txtResponsableMetaMPrincipal" name="txtResponsableMeta[]" /></td>\
	                                                    </tr>\
	                                                    <tr>\
								                        	<td>&nbsp;</td>\
								                        </tr>\
	                                                </table>\
                                            </div>\
                                            <div id="dvAgregarMetaMPrincipal" class="dvAgregarMetaMPrincipal">\
											</div>\
                                        </fieldset>\
                                    </div>';*/

$(function( ){                                            
	var cuentaProyecto = 0;
	var limiteProyecto = 4;
	var cuentaDivProyectoNuevo = 0;
	$("#btnAddProyecto").button( ).click( function(e ){
		e.stopPropagation();
		e.preventDefault();
		var bandera = true;
		$("#dvPrograma").find("input[type=text]").each(function( ){
		
			var valor = trim($( this ).val( ));
			var name = $( this ).attr( "name" );
			
		   if ( name == 'txtMeta[0][0][]'  || name == 'txtFechaInicioMeta[0][0][]' || name == 'txtFechaFinalMeta[0][0][]' || name == 'txtValorMeta[0][0][]' || name == 'txtResponsableMeta[0][0][]' || name == 'txtResponsableMetaEmail[0][0][]' && valor == ""){
					 	
			
				 } else if( valor == "" ){
						bandera = false;
				 }
		});
		
		//$(divProyecto).insertAfter( "#dvProyecto" );
		if( bandera ){
				var xProyectoNuevo = $(".dvProyectoNuevo").length;
				/**
				 * Agregar Nuevo Proyecto
				 */
				/*alert( "cuentaDiv "+xProyectoNuevo );
				alert( "cuentaProyecto "+cuentaProyecto );
				alert( "contadorProyecto "+cuentaDivProyectoNuevo );*/
				if( cuentaDivProyectoNuevo < limiteProyecto ){
					//if( cuentaDivProyectoNuevo == 0 ){
						$("#dvProyecto").append( divProyecto );
						//$(divProyecto).insertAfter( "#dvProyecto" );
					/*}else{
						$(divProyecto).insertAfter( "#dvProyectoNuevo"+cuentaProyecto);
					}*/
					cuentaProyecto++;
					xProyectoNuevo++;
					cuentaDivProyectoNuevo++;
					var idProyecto = $("#dvProyectoNuevo").attr( "id" );
					$( "#dvProyectoNuevo" ).attr( "id", ""+idProyecto+cuentaProyecto );
					$("#dvProyectoNuevo"+cuentaProyecto).find("input, button, img, div, a, textarea").each(function( ){
						var idNuevo = $( this ).attr( "id" );
						var nameNuevo = $( this ).attr( "name" );
						//alert( idNuevo );
						if( idNuevo !== undefined ){
							$( this ).attr( "id", ""+idNuevo+cuentaProyecto );
						}
						var relProyectoNuevo = $( this ).attr( "rel" );
						if( relProyectoNuevo === "dvProyectoNuevo" || relProyectoNuevo === "dvDetalleProyectoNuevo" || relProyectoNuevo === "detalleIndicadorNuevo" || relProyectoNuevo === "dvIndicadorNuevo" || relProyectoNuevo === "responsableProyectoOtrodvProyectoNuevo" ){
							$( this ).attr( "rel", ""+relProyectoNuevo+cuentaProyecto );
						}
						var altProyectoNuevo = $( this ).attr( "alt" );
						if( altProyectoNuevo !== undefined ){
							$( this ).attr( "alt", ""+altProyectoNuevo+cuentaProyecto );
						}
						
						if( nameNuevo == "ckTipoIndicador" || nameNuevo == "txtIndicador" || nameNuevo == "txtMetaPrincipal" || nameNuevo == "txtVigenciaMetaPrincipal" || nameNuevo == "txtValorMetaPrincipal"){
							$( this ).attr( "name", ""+nameNuevo+"["+cuentaProyecto+"][0]" );
						}
						
						if( nameNuevo == "txtMeta" || nameNuevo == "txtFechaInicioMeta" || nameNuevo == "txtFechaFinalMeta" || nameNuevo == "txtValorMeta" || nameNuevo == "txtAccionMeta" || nameNuevo == "txtResponsableMeta" || nameNuevo == "txtResponsableMetaEmail" ){
							$( this ).attr( "name", ""+nameNuevo+"["+cuentaProyecto+"][0][]" );
						}
						//var idNuevoNameProyecto = $( this ).attr( "name" );
					});
					
					$("#addProyectoNuevo"+ cuentaProyecto).on("click", function( ){
						var principal = $( this ).attr( "id" );
						var relProyectoDivDetalle = $( this ).attr( "rel" );
						$( "#"+relProyectoDivDetalle ).slideToggle( "slow", function( ){
							rotar( principal,relProyectoDivDetalle );
						});
					});
					$("#addMetaNuevo"+ cuentaProyecto).on("click", function( ){
						var principal = $( this ).attr( "id" );
						var relProyectoIndicadorDivDetalle = $( this ).attr( "rel" );
						$( "#"+relProyectoIndicadorDivDetalle).slideToggle( "slow",function( ){
							rotar( principal,relProyectoIndicadorDivDetalle );	
						});
					});
					
					
					$(".campoNumeros").keyup(function ( ){
	       		
			     	   this.value = (this.value + "").replace(/[^0-9]/g, "");
					 });	
					
					
				$("#txtResponsableProyectoEmailNuevo"+cuentaProyecto+"").autocomplete({
			     source: "../interfaz/autocompletarEmail.php",
			     minLength: 3,
			     select: function(event, ui) {
			     
			     event.preventDefault();
			     $("#txtResponsableProyectoEmailNuevo"+cuentaProyecto+"").val(ui.item.txtEmail);  
			     $("#txtResponsableProyectoNuevo"+cuentaProyecto+"").val(ui.item.txtActualizaResponsableMeta);
				  
				  }
				  
			 });
					
					
					/**
					 * Agregar Responsable Nuevo Proyecto
					 */
					/*var cuentaProyectoOtro =0;
					var limiteResponsableProyectoOtro = 2;
					$("#addResponsableProyectoNuevo"+cuentaProyecto).on("click", function( ){
						var relResponsableProyecto = $( this ).attr( "rel" );
						if( cuentaProyectoOtro < limiteResponsableProyectoOtro ){
							cuentaProyectoOtro++;
							$("#"+relResponsableProyecto).append('<input type="text" id="proyectoResponsableOtro_'+cuentaProyectoOtro+relResponsableProyecto+'" name="proyectoResponsableOtro[]" class="form-control" />');
						}else{
							alert( "Ha excedido el límite de responsables" );
						}
						return false;
					});
					
					$("#deleteResponsableProyectoNuevo"+cuentaProyecto).on("click", function( ){
						var relDeleteResponsableProyecto = $( this ).attr( "rel" );
						if( cuentaProyectoOtro > 0 ){
							$("#proyectoResponsableOtro_"+cuentaProyectoOtro+relDeleteResponsableProyecto ).remove( );
							cuentaProyectoOtro--;
						}
						return false;
					});*/
					/**Termina Agregar Nuevo Responsable**/
					
					/**
					 * Agregar Indicador cuando se agrega nuevo Proyecto
					 */
					
					var limiteIndicadorProyecto = 4;
					var cuentaIndicadorProyecto = 0;
					var cuentaDivIndicadorProyectoNuevo = 0;		
					$("#btnAddIndicadorNuevo"+ cuentaProyecto).button( ).click(function( e ){
						e.stopPropagation();
						e.preventDefault()
						var relProyectoNuevoIndicador = $( this ).attr( "rel");
						var altProyectoNuevoIndicador = $( this ).attr( "alt" );
						var xIndicadorAgregadoProyectoNuevo = $(".dvIndicadorAgregadodvProyectoNuevo").length;
						if( cuentaDivIndicadorProyectoNuevo < limiteIndicadorProyecto ){
							//if( cuentaDivIndicadorProyectoNuevo == 0 ){
								$("#"+relProyectoNuevoIndicador).append( divIndicador );
								//$(divIndicador).insertAfter( "#"+relProyectoNuevoIndicador );
							/*}else{
								$(divIndicador).insertAfter( "#dvIndicadorAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador );
							}*/
							cuentaIndicadorProyecto++;
							xIndicadorAgregadoProyectoNuevo++;
							cuentaDivIndicadorProyectoNuevo++;
							$("#"+altProyectoNuevoIndicador).find("input, button, img, div, a").each(function( ){
								var idIndicadorNuevo = $( this ).attr( "id" );
								if( idIndicadorNuevo == "dvIndicadorAgregado"){
									$( this ).attr( "id", ""+idIndicadorNuevo+cuentaIndicadorProyecto+altProyectoNuevoIndicador );
									$( this ).attr( "class", "dvIndicadorAgregadodvProyectoNuevo" );
									$("#dvIndicadorAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador).find("input, button, img, div, a, textarea").each(function( ){
										var idIndicadorNuevo2 = $( this ).attr( "id" );
										var relIndicador = $( this ).attr( "rel" );
										var altIndicadorNuevo2 = $( this ).attr("alt");
										var nameIndicadorNuevo2 = $( this ).attr("name");
										if( idIndicadorNuevo2 !== undefined ){
											//alert( idIndicadorNuevo2 );
											$( this ).attr( "id", ""+idIndicadorNuevo2+cuentaIndicadorProyecto+altProyectoNuevoIndicador );
										}
										if( relIndicador !== undefined ){
											$( this ).attr( "rel", ""+relIndicador+cuentaIndicadorProyecto+altProyectoNuevoIndicador );
										}
										if( altIndicadorNuevo2 == "dvIndicadorAgregado"){
											$( this ).attr( "alt", ""+altIndicadorNuevo2+cuentaIndicadorProyecto+altProyectoNuevoIndicador );
										}
										
										if( nameIndicadorNuevo2 == "ckTipoIndicador" || nameIndicadorNuevo2 == "txtIndicador" || nameIndicadorNuevo2 == "txtMetaPrincipal" || nameIndicadorNuevo2 == "txtVigenciaMetaPrincipal" || nameIndicadorNuevo2 == "txtValorMetaPrincipal"){
											$( this ).attr( "name", ""+nameIndicadorNuevo2+"["+cuentaProyecto+"]["+cuentaIndicadorProyecto+"]" );
										}
										
										if( nameIndicadorNuevo2 == "txtMeta" || nameIndicadorNuevo2 == "txtFechaInicioMeta" || nameIndicadorNuevo2 == "txtFechaFinalMeta" || nameIndicadorNuevo2 == "txtValorMeta" || nameIndicadorNuevo2 == "txtAccionMeta" || nameIndicadorNuevo2 == "txtResponsableMeta" ){
											$( this ).attr( "name", ""+nameIndicadorNuevo2+"["+cuentaProyecto+"]["+cuentaIndicadorProyecto+"][]" );
										}
										
										
									});
								}
								
								
							});
							
							$("#addMetaAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador).on("click", function( ){
								var principal = $( this ).attr( "id" );
								var divDetalle = $(this).attr('rel');
								$( "#"+divDetalle ).slideToggle( "slow",function( ){
									rotar( principal,divDetalle );
								});
							});
							
							$("#btnDeleteIndicadorAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador).button( e ).click(function( ){
									e.stopPropagation();
									e.preventDefault();
								var divIndicadorEliminar = $(this).attr('rel');
								if( cuentaDivIndicadorProyectoNuevo > 0 ){
									$( "#"+divIndicadorEliminar ).remove( );
									cuentaDivIndicadorProyectoNuevo--;
								}
								return false;
								//cuentaIndicadorProyecto--;
							});
							
							var datesIP = $( "#txtFechaInicioMetaAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador+", #txtFechaFinalMetaAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador ).datepicker({
								defaultDate: "0w",
								changeMonth: true,
								numberOfMonths: 2,
								changeYear: true,
								dateFormat : 'yy-mm-dd',
								onSelect: function( selectedDate ) {
									var option = this.id == "txtFechaInicioMetaAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador ? "minDate" : "maxDate",
										instance = $( this ).data( "datepicker" ),
										dateIP = $.datepicker.parseDate(
											instance.settings.dateFormat ||
											$.datepicker._defaults.dateFormat,
											selectedDate, instance.settings );
									datesIP.not( this ).datepicker( "option", option, dateIP );
								}
							},$.datepicker.regional["es"]);	
							
							
							
							var limiteMetaIndicadorAgregado = 4;
							var cuentaMetaIndicadorAgregado = 0;
							var cuentaDivMetaIndicadorAgregado = 0;
							$("#btnAddMetaAgregado"+cuentaIndicadorProyecto+altProyectoNuevoIndicador).button(  ).click(function( e ){
								e.stopPropagation();
								e.preventDefault();
								var divMetaIndicadorAgregado = $( this ).attr( "rel" );
								var altdivMetaIndicadorAgregado = $( this ).attr( "alt" );
								
								if( cuentaDivMetaIndicadorAgregado < limiteMetaIndicadorAgregado ){
									//var addMetaproyectoNuevo = $(".dvMetaIndicadorNuevo").html( );
									cuentaMetaIndicadorAgregado++;
									cuentaDivMetaIndicadorAgregado++;
									$("#"+divMetaIndicadorAgregado).append( '<div id="dvContenedorMetaAgregado_'+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado+'">'+dvMeta+'</div>');
									$("#dvContenedorMetaAgregado_"+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado).find("input, button, img, div, a, textarea").each(function( ){
										//alert( $( this ).attr( "id" ) );
										var idMetaIndicadorAgregado = $( this ).attr( "id" );
										var altMetaAgregadoIndicadorNuevo = $( this ).attr( "alt" );
										var nameMetaAgregadoIndicadorNuevo = $( this ).attr( "name" );
										if( idMetaIndicadorAgregado !== undefined ){
											//alert( idMetaIndicadorAgregado );
											$( this ).attr( "id", ""+idMetaIndicadorAgregado+"_"+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado );
											//$( this ).attr("name", nameMetaAgregadoIndicadorNuevo+"["+cuentaProyecto+"]["+cuentaIndicadorProyecto+"][]");
										}
										if( altMetaAgregadoIndicadorNuevo !== undefined ){
											$( this ).attr( "alt", ""+altMetaAgregadoIndicadorNuevo+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado );
										}
										
										if( nameMetaAgregadoIndicadorNuevo !== undefined ){
											$( this ).attr("name", nameMetaAgregadoIndicadorNuevo+"["+cuentaProyecto+"]["+cuentaIndicadorProyecto+"][]");
										}
									});
									//$(".dvAgregarMeta").append( '<div id="dvContenedorMeta_'+cuenta+'">'+addMeta+'</div>');
									
									$("#btnDeleteMetaAgregadoNueva_"+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado).button( ).click(function( e ){
										e.stopPropagation();
										e.preventDefault();
										 var altDeleteMetaIndicadorNueva = $(this).attr("alt");
											$("#"+altDeleteMetaIndicadorNueva).remove( );
											cuentaDivMetaIndicadorAgregado--;
										
											return false;
									});
									
									var datesIMP = $( "#txtFechaInicioMetaAgregadoNueva_"+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado+", #txtFechaFinalMetaAgregadoNueva_"+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado ).datepicker({
										defaultDate: "0w",
										changeMonth: true,
										numberOfMonths: 2,
										changeYear: true,
										dateFormat : 'yy-mm-dd',
										monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
									 	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
										  minDate: 0,
	
										onSelect: function( selectedDate ) {
											var option = this.id == "txtFechaInicioMetaAgregadoNueva_"+cuentaMetaIndicadorAgregado+altdivMetaIndicadorAgregado ? "minDate" : "maxDate",
												instance = $( this ).data( "datepicker" ),
												dateIMP = $.datepicker.parseDate(
													instance.settings.dateFormat ||
													$.datepicker._defaults.dateFormat,
													selectedDate, instance.settings );
											datesIMP.not( this ).datepicker( "option", option, dateIMP );
										}
									},$.datepicker.regional["es"]);	
									
									
									
								}else{
									alert( "No puede ingresar más metas" );
								}
								return false;
							});
							
							
							
							
						}else{
							alert( "No puede ingresar más indicadores" );
						}
						return false;
					});
					
					
					
					/**Termina Agregar Indicador**/
					/**
					 * Agrega Meta Principal
					 */
					/*var limiteMetaPrincipalProyectoNuevo = 4;
					var cuentaMetaPrincipalProyectoNuevo = 0;
					var cuentaDivMetaPrincipalProyectoNuevo= 0;
					$("#btnMetaPrincipalNuevo"+cuentaProyecto).button( ).click(function( ){
						var relMetaPrincipalProyecto = $( this ).attr( "rel" );
						var altMetaPrincipalProyecto = $( this ).attr( "alt" );
						
						if( cuentaDivMetaPrincipalProyectoNuevo < limiteMetaPrincipalProyectoNuevo ){
						
							$("#"+relMetaPrincipalProyecto).append( divMetaPrincipal );
							cuentaMetaPrincipalProyectoNuevo++;
							cuentaDivMetaPrincipalProyectoNuevo++;
							var idMetaPrincipalProyectoNuevo = $("#detalleIndicadorMPrincipal").attr( "id" );
							$( "#detalleIndicadorMPrincipal" ).attr( "id", ""+idMetaPrincipalProyectoNuevo+cuentaMetaPrincipalProyectoNuevo+altMetaPrincipalProyecto );
							$("#detalleIndicadorMPrincipal"+cuentaMetaPrincipalProyectoNuevo+altMetaPrincipalProyecto).find("input, button, img, div, a").each(function( ){
								var idMetaPrincipalNuevo = $(this).attr("id");
								var relMetaPrincipalNuevo = $(this).attr("rel");
								if( idMetaPrincipalNuevo !== undefined ){
									$( this ).attr( "id", ""+idMetaPrincipalNuevo+cuentaMetaPrincipalProyectoNuevo+altMetaPrincipalProyecto );
								}
								if( relMetaPrincipalNuevo !== undefined ){
									alert( relMetaPrincipalNuevo );
									$( this ).attr( "rel", ""+relMetaPrincipalNuevo+cuentaMetaPrincipalProyectoNuevo+altMetaPrincipalProyecto );
								}
							});
							
							$("#btnDeleteMetaMPrincipal"+cuentaMetaPrincipalProyectoNuevo+altMetaPrincipalProyecto).button( ).click(function( ){
								 var relDeleteMetaPrincipalProyecto = $(this).attr("rel");
								 $("#"+relDeleteMetaPrincipalProyecto).remove( );
								 cuentaDivMetaPrincipalProyectoNuevo--;
								 return false;
								 
							});
						
						}else{
							alert("Ha excedido el límite para agregar metas principales");
						}
					});*/
					/**
					 * Fin Meta Principal
					 */
					
					/**
					 * Agregar Meta cuando se agrega un Nuevo Proyecto
					*/ 
					//var xMetaProyectoNuevo = $(".dvMetaIndicadorNuevo div").length;
					var limiteMetaNuevo = 4;
					var cuentaMetaNuevo = 0;
					var cuentaDivMetaProyectoNuevo = 0;
					$("#btnAddMetaNuevo"+cuentaProyecto).button( ).click(function( ){
						 var relDvMetaNuevoProyectoNuevo = $(this).attr("rel");
						 var altDvMetaNuevoProyectoNuevo = $( this ).attr( "alt" );
						 
						if( cuentaDivMetaProyectoNuevo < limiteMetaNuevo ){
							//var addMetaproyectoNuevo = $(".dvMetaIndicadorNuevo").html( );
							cuentaMetaNuevo++;
							cuentaDivMetaProyectoNuevo++;
							$("#"+altDvMetaNuevoProyectoNuevo).append( '<div id="dvContenedorMetaNuevo_'+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo+'">'+dvMeta+'</div>');
							$("#dvContenedorMetaNuevo_"+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo).find("input, button, img, div, a, textarea").each(function( ){
								var idMetaProyectoNuevo = $( this ).attr( "id" );
								var nameMetaProyectoNuevo = $( this ).attr( "name" );
								if( idMetaProyectoNuevo !== undefined ){
									$( this ).attr( "id", ""+idMetaProyectoNuevo+"_"+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo );
								}
								var relMetaProyectoNuevo = $( this ).attr( "rel" );
								if( relMetaProyectoNuevo !== undefined ){
									$( this ).attr( "rel", "dvContenedorMetaNuevo_"+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo );
								}
								
								if( nameMetaProyectoNuevo !== undefined ){
									$( this ).attr("name", nameMetaProyectoNuevo+"["+cuentaProyecto+"][0][]");
								}
								
							});
							//$(".dvAgregarMeta").append( '<div id="dvContenedorMeta_'+cuenta+'">'+addMeta+'</div>');
							//xMetaProyectoNuevo++;
							
							$("#btnDeleteMetaAgregadoNueva_"+ cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo).button( ).click(function( ){
								var relProyectoNuevo = $(this).attr("rel");
								if( cuentaMetaNuevo > 0 ){
									$("#"+relProyectoNuevo ).remove( );
									//$(".dvAgregarMeta").remove( );
									//xMetaProyectoNuevo--;
									cuentaDivMetaProyectoNuevo--;
								}else{
									alert( "Debe existir al menos una meta a cumplir" );
								}
								return false;
							});
							
							var datesIMAP = $( "#txtFechaInicioMetaAgregadoNueva_"+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo+", #txtFechaFinalMetaAgregadoNueva_"+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo ).datepicker({
										defaultDate: "0w",
										changeMonth: true,
										numberOfMonths: 2,
										changeYear: true,
										dateFormat : 'yy-mm-dd',
										monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
									 	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
										  minDate: 0,
	
										onSelect: function( selectedDate ) {
											var option = this.id == "txtFechaInicioMetaAgregadoNueva_"+cuentaMetaNuevo+relDvMetaNuevoProyectoNuevo ? "minDate" : "maxDate",
												instance = $( this ).data( "datepicker" ),
												dateIMAP = $.datepicker.parseDate(
													instance.settings.dateFormat ||
													$.datepicker._defaults.dateFormat,
													selectedDate, instance.settings );
											datesIMAP.not( this ).datepicker( "option", option, dateIMAP );
										}
									},$.datepicker.regional["es"]);	
							
							
						}else{
							alert( "No puede ingresar más metas" );
						}
						return false;
					});
					
					/*$("#btnDeleteMetaNuevo"+cuentaProyecto).button( ).click(function( ){
						if( cuentaMetaNuevo > 0 ){
							$("#dvContenedorMetaNuevo_"+ cuentaMetaNuevo+"dvProyectoNuevo"+cuentaProyecto ).remove( );
							//$(".dvAgregarMeta").remove( );
							xMetaProyectoNuevo--;
							cuentaMetaNuevo--;
						}else{
							alert( "Debe existir al menos una meta a cumplir" );
						}
						return false;
					});*/
					/**Termina Agregar Meta**/
					
					/**
					 * Eliminar Proyecto
					 */
					
					$("#btnDeleteProyectoNuevo"+ cuentaProyecto).button( ).click( function( e ){
						e.stopPropagation();
						e.preventDefault();
						var relProyectoNuevoDelete = $( this ).attr( "rel" );
						if( cuentaDivProyectoNuevo > 0 ){
							$("#"+relProyectoNuevoDelete).remove( );
							cuentaDivProyectoNuevo--;
						}
						return false;
					});
					/**Termina Eliminar Proyecto**/
					
					var datesP = $( "#txtFechaInicioMetaNuevo"+cuentaProyecto+", #txtFechaFinalMetaNuevo"+cuentaProyecto  ).datepicker({
						defaultDate: "0w",
						changeMonth: true,
						numberOfMonths: 2,
						changeYear: true,
						dateFormat : 'yy-mm-dd',
						onSelect: function( selectedDate ) {
							var option = this.id == "txtFechaInicioMetaNuevo"+cuentaProyecto ? "minDate" : "maxDate",
								instance = $( this ).data( "datepicker" ),
								dateP = $.datepicker.parseDate(
									instance.settings.dateFormat ||
									$.datepicker._defaults.dateFormat,
									selectedDate, instance.settings );
							datesP.not( this ).datepicker( "option", option, dateP );
						}
					},$.datepicker.regional["es"]);	
					
				}else{
					alert( "No puede ingresar más proyectos" );
				}
				/**Termina Agregar Proyecto**/
				
				return false;
		}else{
			alert( "Por favor diligencie todos los campos" );
		}
		
	});

});

$(function( ){
var limiteIndicador = 4;
var cuentaIndicador = 0;
$("#btnAddIndicador").button( ).click(function( e ){
	e.stopPropagation();
	e.preventDefault();
	//$(divIndicador).insertAfter( "#dvIndicador" );
	/*var limiteIndicador = 4;
	var cuentaIndicador = $(".dvIndicadorAgregado").length;*/
	if( cuentaIndicador < limiteIndicador ){
		
		//if( cuentaIndicador == 0 ){
			$("#dvIndicador").append( divIndicador );
			//$(divIndicador).insertAfter( "#dvIndicador" );
		/*}else{
			$(divIndicador).insertAfter( "#dvIndicadorAgregado"+cuentaIndicador);
		}*/
		cuentaIndicador++;
		var idIndicador = $("#dvIndicadorAgregado").attr( "id" );
		$( "#dvIndicadorAgregado" ).attr( "id", ""+idIndicador+cuentaIndicador );
		$("#dvIndicadorAgregado"+cuentaIndicador).find("input, button, img, div, a, textarea").each(function( ){
			var idNuevoIndicador = $( this ).attr( "id" );
			var nameNuevoIndicador = $( this ).attr( "name" );
			if( idNuevoIndicador !== undefined ){
				$( this ).attr( "id", ""+idNuevoIndicador+cuentaIndicador );
			}
			var relNuevoIndicador = $( this ).attr( "rel" );
			if( relNuevoIndicador !== undefined ){
				$( this ).attr( "rel", ""+relNuevoIndicador+cuentaIndicador );
			}
			var altNuevoIndicador = $( this ).attr( "alt");
			if( altNuevoIndicador !== undefined ){
				$( this ).attr( "alt", ""+altNuevoIndicador+cuentaIndicador );
			}
			if( nameNuevoIndicador == "ckTipoIndicador" || nameNuevoIndicador == "txtIndicador" || nameNuevoIndicador == "txtMetaPrincipal" || nameNuevoIndicador == "txtVigenciaMetaPrincipal" || nameNuevoIndicador == "txtValorMetaPrincipal"){
				$( this ).attr( "name", ""+nameNuevoIndicador+"[0]["+cuentaIndicador+"]" );
			}
			
			if( nameNuevoIndicador == "txtMeta" || nameNuevoIndicador == "txtFechaInicioMeta" || nameNuevoIndicador == "txtFechaFinalMeta" || nameNuevoIndicador == "txtValorMeta" || nameNuevoIndicador == "txtAccionMeta" || nameNuevoIndicador == "txtResponsableMeta" ){
				$( this ).attr( "name", ""+nameNuevoIndicador+"[0]["+cuentaIndicador+"][]" );
			}
		});
		
		$("#addMetaAgregado"+ cuentaIndicador).on("click", function( ){
			var principal = $( this ).attr( "id" );
			var relIndicadorPrincipalAgregado = $(this).attr("rel");
					$( "#"+relIndicadorPrincipalAgregado).slideToggle( "slow", function( ){
						rotar( principal, relIndicadorPrincipalAgregado );
					});
		});
		
		/*var cuentaIndicadorMPrincipalAgregado = 0;
		var limiteIndicadorMPrincipalAgregado = 4;
		var cuentaDivIndicadorMPrincipalAgregado = 0;
		$("#btnMetaPrincipalAgregado"+ cuentaIndicador).button( ).click( function( ){
			var relIndicadorMPrincipalAgregado = $( this ).attr( "rel" );
			var altIndicadorMPrincipalAgregado = $( this ).attr( "alt" );
			
			if( cuentaDivIndicadorMPrincipalAgregado < limiteIndicadorMPrincipalAgregado ){
				$("#"+relIndicadorMPrincipalAgregado).append( divMetaPrincipal );
				
				cuentaIndicadorMPrincipalAgregado++;
				cuentaDivIndicadorMPrincipalAgregado++;
				var idMetaPrincipalIndicadorAgregado = $("#detalleIndicadorMPrincipal").attr("id");
				
				$( "#detalleIndicadorMPrincipal" ).attr( "id", ""+idMetaPrincipalIndicadorAgregado+cuentaIndicadorMPrincipalAgregado+altIndicadorMPrincipalAgregado );
				$( "#detalleIndicadorMPrincipal"+cuentaIndicadorMPrincipalAgregado+altIndicadorMPrincipalAgregado ).find("input, button, img, div, a").each(function( ){
					var idDetalleMetaPrincipalIndicadorAgregado = $(this).attr("id");
					if ( idDetalleMetaPrincipalIndicadorAgregado !== undefined ){
						$( this ).attr( "id", ""+idDetalleMetaPrincipalIndicadorAgregado+cuentaIndicadorMPrincipalAgregado+altIndicadorMPrincipalAgregado );
					}
					var relDetalleMetaPrincipalIndicadorAgregado = $(this).attr("rel");
					if ( relDetalleMetaPrincipalIndicadorAgregado !== undefined ){
						$( this ).attr( "rel", ""+relDetalleMetaPrincipalIndicadorAgregado+cuentaIndicadorMPrincipalAgregado+altIndicadorMPrincipalAgregado );
					}
					var altDetalleMetaPrincipalIndicadorAgregado = $(this).attr("alt");
					if ( altDetalleMetaPrincipalIndicadorAgregado !== undefined ){
						$( this ).attr( "alt", ""+altDetalleMetaPrincipalIndicadorAgregado+cuentaIndicadorMPrincipalAgregado+altIndicadorMPrincipalAgregado );
					}
				});
				
				$("#btnDeleteMetaMPrincipal"+cuentaIndicadorMPrincipalAgregado+altIndicadorMPrincipalAgregado).button( ).click(function( ){
					var relDelete
				});
				
			}else{
				alert( "Ha excedido el limite de metas principales" );
			}
			//$("#detalleIndicador").append( divMetaPrincipal );
		});*/
		var cuentaIndicadorMetaAgregadoPrincipal = 0;
		var limiteIndicadorMetaAgregadoPrincipal = 4;
		var cuentaDivIndicadorMetaAgregadoPrincipal = 0;
		$("#btnAddMetaAgregado"+ cuentaIndicador).button( ).click( function( e ){
			e.stopPropagation();
			e.preventDefault();
			if( cuentaDivIndicadorMetaAgregadoPrincipal < limiteIndicadorMetaAgregadoPrincipal ){
			var relIndicadorMetaAgregadoPrincipal = $( this ).attr( "rel" );
			var altIndicadorMetaAgregadoPrincipal = $( this ).attr( "alt" );
			
			cuentaIndicadorMetaAgregadoPrincipal++;
			cuentaDivIndicadorMetaAgregadoPrincipal++;
			
			$("#"+relIndicadorMetaAgregadoPrincipal).append( '<div id="dvContenedorMetaAgregado_'+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal+'">'+dvMeta+'</div>');
			$("#dvContenedorMetaAgregado_"+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal).find("input, button, img, div, a, textarea").each(function( ){
										//alert( $( this ).attr( "id" ) );
				var idMetaIndicadorAgregadoPrincipal = $( this ).attr( "id" );
				var altMetaAgregadoIndicadorNuevoPrincipal = $( this ).attr( "alt" );
				var relMetaAgregadoIndicadorNuevoPrincipal = $( this ).attr( "rel" );
				var nameMetaAgregadoIndicadorNuevoPrincipal = $( this ).attr( "name" );
				if( idMetaIndicadorAgregadoPrincipal !== undefined ){
					$( this ).attr( "id", ""+idMetaIndicadorAgregadoPrincipal+"_"+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal );
					
				}
				if( altMetaAgregadoIndicadorNuevoPrincipal !== undefined ){
					$( this ).attr( "alt", ""+altMetaAgregadoIndicadorNuevoPrincipal+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal );
				}
				if( relMetaAgregadoIndicadorNuevoPrincipal !== undefined ){
					$( this ).attr( "rel", ""+relMetaAgregadoIndicadorNuevoPrincipal+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal );
				}
				
				if( nameMetaAgregadoIndicadorNuevoPrincipal !== undefined ){
					$( this ).attr("name", nameMetaAgregadoIndicadorNuevoPrincipal+"[0]["+cuentaIndicador+"][]");
				}
				
			});
			
				$("#btnDeleteMetaAgregadoNueva_"+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal).button( ).click(function( ){
					var altDeleteIndicadorMetaAgregadoPrincipal = $( this ).attr( "alt" );
					$("#"+altDeleteIndicadorMetaAgregadoPrincipal).remove( );
					cuentaDivIndicadorMetaAgregadoPrincipal--;
				});
				
				var datesIN = $( "#txtFechaInicioMetaAgregadoNueva_"+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal+", #txtFechaFinalMetaAgregadoNueva_"+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal  ).datepicker({
				defaultDate: "0w",
				changeMonth: true,
				numberOfMonths: 2,
				changeYear: true,
				dateFormat : 'yy-mm-dd',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			 	monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
				  minDate: 0,
	
				onSelect: function( selectedDate ) {
					var option = this.id == "txtFechaInicioMetaAgregadoNueva_"+cuentaIndicadorMetaAgregadoPrincipal+altIndicadorMetaAgregadoPrincipal ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						dateIN = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
					datesIN.not( this ).datepicker( "option", option, dateIN );
				}
			},$.datepicker.regional["es"]);	
			
			}else{
				alert( "Ha excedido el número de metas anuales para agregar" );
			}
			
		});
		
		
				
		$("#btnDeleteIndicadorAgregado"+ cuentaIndicador).button( ).click(function( ){
			
			if( cuentaIndicador > 0 ){
				$("#dvIndicadorAgregado"+cuentaIndicador).remove( );
				cuentaIndicador--;
			}
			return false;
		});
		
		var datesI = $( "#txtFechaInicioMetaAgregado"+cuentaIndicador+", #txtFechaFinalMetaAgregado"+cuentaIndicador  ).datepicker({
				defaultDate: "0w",
				changeMonth: true,
				numberOfMonths: 2,
				changeYear: true,
				dateFormat : 'yy-mm-dd',
				onSelect: function( selectedDate ) {
					var option = this.id == "txtFechaInicioMetaAgregado"+cuentaIndicador ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						dateI = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
					datesI.not( this ).datepicker( "option", option, dateI );
				}
			},$.datepicker.regional["es"]);


	}else{
		alert( "No puede ingresar más indicadores" );
	}
	
	return false;
});

});

$("#btnSaveResponsable").button( );

/*$(function( ){
	var limiteMetaPrincipal = 4;
	var cuentaMetaPrincipal = 0;
	var cuentaDivMetaPrincipal = 0;
	$("#btnMetaPrincipal").button( ).click(function( ){
		if( cuentaDivMetaPrincipal < limiteMetaPrincipal ){
			$("#detalleIndicador").append( divMetaPrincipal );
			
			cuentaMetaPrincipal++;
			cuentaDivMetaPrincipal++;
			var idMetaPrincipal = $("#detalleIndicadorMPrincipal").attr("id");
			
			$( "#detalleIndicadorMPrincipal" ).attr( "id", ""+idMetaPrincipal+cuentaMetaPrincipal );
			$("#detalleIndicadorMPrincipal"+cuentaMetaPrincipal).find("input, button, img, div, a").each(function( ){
			var idNuevoMetaPrincipal = $( this ).attr( "id" );
			if( idNuevoMetaPrincipal !== undefined ){
				$( this ).attr( "id", ""+idNuevoMetaPrincipal+cuentaMetaPrincipal );
			}
			var relNuevoMetaPrincipal = $( this ).attr( "rel" );
			var altNuevoMetaPrincipal = $( this ).attr( "alt" ); 
			if( relNuevoMetaPrincipal !== undefined ){
				$( this ).attr( "rel", ""+relNuevoMetaPrincipal+cuentaMetaPrincipal );
			}
			if( altNuevoMetaPrincipal !== undefined ){
				$( this ).attr( "alt", ""+altNuevoMetaPrincipal+cuentaMetaPrincipal );
			}
			
			});
			
			
			/*var limiteMetaPrincipalIndicador = 4;
			var cuentaMetaPrincipalIndicador = 0;
			var cuentaDivMetaPrincipalIndicador = 0;
			$("#btnAddMetaMPrincipal"+cuentaMetaPrincipal).button( ).click(function( ){
				var relMetaPrincipalIndicador = $( this ).attr( "rel" );
				var altMetaPrincipalIndicador = $( this ).attr( "alt" );
				if( cuentaDivMetaPrincipalIndicador < limiteMetaPrincipalIndicador ){
					//$("#"+relMetaPrincipalIndicador).append(  );
					cuentaMetaPrincipalIndicador++;
					cuentaDivMetaPrincipalIndicador++;
					
					$("#"+relMetaPrincipalIndicador).append( '<div id="dvContenedorMetaAgregadoNueva_'+cuentaMetaPrincipalIndicador+altMetaPrincipalIndicador+'">'+dvMeta+'</div>');
					$("#dvContenedorMetaAgregadoNueva_"+cuentaMetaPrincipalIndicador+altMetaPrincipalIndicador).find("input, button, img, div, a").each(function( ){
						var idNuevoMetaAgregadaPrincipal = $( this ).attr( "id" );
						if( idNuevoMetaAgregadaPrincipal !== undefined ){
							$( this ).attr( "id", ""+idNuevoMetaAgregadaPrincipal+cuentaMetaPrincipalIndicador+altMetaPrincipalIndicador );
						}
						var relNuevoMetaAgregadaPrincipal = $( this ).attr( "rel" );
						var altNuevoMetaAgregadaPrincipal = $( this ).attr( "alt" );
						if( relNuevoMetaAgregadaPrincipal !== undefined ){
							$( this ).attr( "rel", ""+relNuevoMetaAgregadaPrincipal+cuentaMetaPrincipalIndicador+altMetaPrincipalIndicador );
						}
						if( altNuevoMetaAgregadaPrincipal !== undefined ){
							$( this ).attr( "alt", ""+altNuevoMetaAgregadaPrincipal+cuentaMetaPrincipalIndicador+altMetaPrincipalIndicador );
						}
					});
					
					
					$("#btnDeleteMetaAgregadoNueva"+cuentaMetaPrincipalIndicador+altMetaPrincipalIndicador).button( ).click(function( ){
						var relDeleteMetaAgregadoNuevaMPrincipal = $( this ).attr( "rel" );
						$("#"+relDeleteMetaAgregadoNuevaMPrincipal).remove( );
						cuentaDivMetaPrincipalIndicador--;
					})
					
				}else{
					alert( "Ha excedido el número de metas secundarias para agregar" );
				}
				
			});*/
			
	/*		$("#btnDeleteMetaMPrincipal"+cuentaMetaPrincipal).button( ).click(function( ){
				var relDeleteMetaMPrincipal = $( this ).attr("rel");
				if( cuentaMetaPrincipal > 0 ){
					$("#"+relDeleteMetaMPrincipal).remove( );
					cuentaDivMetaPrincipal--;
				}
			});
			
			
		}else{
			alert("No puede ingresar más metas principales");
		}
	});
});*/

$(function( ){
	var xMeta = $(".dvMetaIndicadorAgregadoNueva div").length;
	var limite = 14;
	var cuenta = 0;
	$("#btnAddMeta").button( ).click(function( e ){
			e.stopPropagation();
			e.preventDefault();
		if( xMeta < limite ){
			//var addMeta = $(".dvMetaIndicador").html( );
			xMeta++;
			cuenta++;
			$(".dvAgregarMeta").append( '<div id="dvContenedorMetaAgregadoNueva_'+cuenta+'">'+dvMeta+'</div>');
			$("#dvContenedorMetaAgregadoNueva_"+cuenta).find("input, button, div, a, textarea").each(function( ){
				var idNuevoMetaPrincipal = $( this ).attr( "id" );
				$( this ).attr( "id", ""+idNuevoMetaPrincipal+cuenta );
				var relMetaAgregadoNueva = $( this ).attr( "rel" );
				var nameMetaAgregadoNueva = $( this ).attr( "name" );
				if( relMetaAgregadoNueva !== undefined ){
					$( this ).attr( "rel", ""+relMetaAgregadoNueva+cuenta );	
				}
				
				if( nameMetaAgregadoNueva !== undefined ){
					$( this ).attr( "name", ""+nameMetaAgregadoNueva+"[0][0][]" );	
				}
			});
			//$(".dvAgregarMeta").append( '<div id="dvContenedorMeta_'+cuenta+'">'+addMeta+'</div>');
			
			
			$("#btnDeleteMetaAgregadoNueva"+cuenta).button( ).click(function( ){
				if( xMeta > 0 ){
					var relMeta = $( this ).attr( "rel" );
					$("#"+relMeta ).remove( );
					xMeta--;
					//cuenta--;
				}else{
					alert( "Debe existir al menos una meta a cumplir" );
				}
				/*alert( cuenta );
				if( xMeta > 0 ){
					$("#dvContenedorMetaAgregadoNueva_"+ xMeta ).remove( );
					//$(".dvAgregarMeta").remove( );
					xMeta--;
					cuenta--;
				}else{
					alert( "Debe existir al menos una meta a cumplir" );
				}*/
				return false;
			});
			
			var datesM = $( "#txtFechaInicioMetaAgregadoNueva"+cuenta+", #txtFechaFinalMetaAgregadoNueva"+cuenta  ).datepicker({
				defaultDate: "0w",
				changeMonth: true,
				numberOfMonths: 2,
				changeYear: true,
				dateFormat : 'yy-mm-dd',
				monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 				monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	  			minDate: 0,
	
				onSelect: function( selectedDate ) {
					var option = this.id == "txtFechaInicioMetaAgregadoNueva"+cuenta ? "minDate" : "maxDate",
						instance = $( this ).data( "datepicker" ),
						dateM = $.datepicker.parseDate(
							instance.settings.dateFormat ||
							$.datepicker._defaults.dateFormat,
							selectedDate, instance.settings );
					datesM.not( this ).datepicker( "option", option, dateM );
				}
			},$.datepicker.regional["es"]);	
			
			
			
			
			$("#txtResponsableMetaAgregadoNuevaEmail"+cuenta+"").autocomplete({
			     source: "../interfaz/autocompletarEmail.php",
			     minLength: 3,
			     select: function(event, ui) {
			     
			     event.preventDefault();
			     $("#txtResponsableMetaAgregadoNuevaEmail"+cuenta+"").val(ui.item.txtEmail);  
			     $("#txtResponsableMetaAgregadoNueva"+cuenta+"").val(ui.item.txtActualizaResponsableMeta);
				  
				  }
				  
			 });
						
			$(".campoNumeros").keyup(function ( ){
	       		
	     	   this.value = (this.value + "").replace(/[^0-9]/g, "");
			 });
			
		}else{
			alert( "No puede ingresar más metas" );
		}
		return false;
	});
	
	
});

/*$(function( ){
	var xMetaIndicador = $(".dvIndicador div").length;
	var limiteIndicador = 5;
	var cuentaIndicador = 1;
	var cuentaDiv = 0;
	$("#btnAddIndicador").button( ).click(function( ){
		if( cuentaIndicador < limiteIndicador ){
			var addIndicador = $(".dvIndicador").html( );
			$(".dvAgregarIndicador").append( '<div id="dvContenedorIndicador_'+cuentaIndicador+'">'+addIndicador+'</div>');
			$("#dvContenedorIndicador_"+cuentaIndicador).find("input, button, img, div, a").each(function( ){
				var idNuevo = $( this ).attr( "id" );
				var idNuevoName = $( this ).attr( "name" );
				$( this ).attr( "id", ""+idNuevo+"_"+cuentaIndicador );
			});
			$("#addMeta_"+ cuentaIndicador).on("click", function( ){
				$( "#detalleIndicador_"+cuentaDiv).slideToggle( "slow" );
			});
			xMetaIndicador++;
			cuentaIndicador++;
			cuentaDiv++;
			
		}else{
			alert( "No puede ingresar más indicadores" );
		}
		
		return false;
	});
	
});

$(function( ){
	
	$("#btnAddMeta_1").button( ).click(function( ){
		alert( cuenta2 );
});
	
	/*$("#btnDeleteMeta_"+xMeta2).button( ).click(function( ){
		if( xMeta2 > 0 ){
			$("#dvContenedorMeta2_"+ xMeta2 ).remove( );
			//$(".dvAgregarMeta").remove( );
			xMeta2--;
			cuenta2--;
		}else{
			alert( "Debe existir al menos una meta a cumplir" );
		}
		return false;
	});	*/
/*});*/

$("#btnRegistrarPlan").button( ).click(function( e ){
	e.stopPropagation();
	e.preventDefault();
	
	var formulario = "formRegistrar";
	var camposVacios = validarForm( formulario );
	var validacion = validar( camposVacios );
	
	var vMeta= $("#txtValorMetaPrincipal").val();
	
	 if(vMeta.length < 1) { 
	 	
	 	 }else	if( vMeta == 0 ){

		alert("El valor de la meta principal debe ser mayor a cero");
		
	}else {
	


	
	if( validacion ){
		$( "#btnRegistrarPlan" ).button({ label: "Guardando <img width='16' height='16' src='../css/images/cargando.gif' />" });
		$( "#btnRegistrarPlan" ).button( "option" , "disabled" , true );
		$( "#mensageRegistrar" ).dialog( "option", "buttons", {
		      
			"Aceptar": function() {
				$.ajax({
					url: "../servicio/registrar.php",
			  		type: "POST",
			  		data: $( "#formRegistrar" ).serialize( ),
					success: function( data ){
						if( data != 1 ){
							if( data.length > 0 ){
								alert( "Ha ocurrido un problema" );
								$( "#mensageRegistrar" ).dialog( "close" );
								$( "#btnRegistrarPlan" ).button({ label: "Guardar" });
								$( "#btnRegistrarPlan" ).button( "option", "disabled", false );
							}else{
								alert("Se han guardado los cambios");
								$( "#mensageRegistrar" ).dialog( "close" );
								volver( );
							}
						}else{
							alert( "Ha completado el número de metas anuales" );
							$( "#mensageRegistrar" ).dialog( "close" );
							$( "#btnRegistrarPlan" ).button({ label: "Guardar" });
							$( "#btnRegistrarPlan" ).button( "option", "disabled", false );
						}
					}
				});
			},
			"Cancelar":function(){
				$( "#mensageRegistrar" ).dialog( "close" );
				$( "#btnRegistrarPlan" ).button({ label: "Guardar" });
				$( "#btnRegistrarPlan" ).button( "option", "disabled", false );
				
			}
		});
		$( "#mensageRegistrar" ).dialog( "open" );
	}
 }	
});

$("#btnRestaurar").button( ).click(function( ){
	$("#formRegistrar").reset( );
});

$("#btnRegresar").on("click",function( ){
	volver( );
});



