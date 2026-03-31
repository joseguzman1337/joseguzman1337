/**
 * @author Ivan quintero 
 * Febrero 22, 2017
 */

    $(function( ){
        $( "#btnActualizarMetaSec").click(function(){
                guardarMetaSecundaria();
        });
        $( "#mensageActualizar" ).dialog({
            autoOpen: false,
            show: "blind",
            modal: true,
            resizable: false,
            title: "Mensaje de Confirmación",
            width: 350,
            height: 200,
            hide: "explode",
            open: function() {
                $buttonPane = $(this).next();
                $buttonPane.find('button').addClass('btn').addClass('btn-warning');
            }
        });
    });


    jQuery.validator.setDefaults({
       highlight:function(element){
        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
       },
       unhighlight:function(element){
           $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
       },
       errorElement:'span',
       errorClass:'help-block',
       errorPlacement:function(error,element){
           if(element.parent('.input-group').length){
               error.insertAfter(element.parent());
           }else{
               error.insertAfter(element);
           }
       }
    });

    $("#btnCancelarActualizarMetaSec").click(function(){
        $("#actualizaPlan").dialog("close");
        $("#nuevaMetaPrincipal").empty();
    });
	
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
	
    $("#ckTipoIndicadorActualizaCuantitativo").change(function( event ){
        if( this.checked ){
            $("#ckTipoIndicadorActualizaCualitativo").attr('checked', false);
        }
    });
	
    $("#ckTipoIndicadorActualizaCualitativo").change(function( event ){
        if( this.checked ){
            $("#ckTipoIndicadorActualizaCuantitativo").attr('checked', false);
        }
    });
	
    /*Modified Diego Fernando Rivera Castro<riveradiego@unbosque.edu.co>
     *Se agrega  autocompletar a campo a plica en edicion de avance anual   y edicion de plan desarrollo
     *Since April 19 , 2017  
     */	
    $("#txtEmail").autocomplete({
        source: "../interfaz/autocompletarEmail.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtEmail').val(ui.item.txtEmail);
            $('#txtActualizaResponsableMeta').val(ui.item.txtActualizaResponsableMeta);

	}
    });

    $("#txtActualizaResponsableMeta").autocomplete({
        source: "../interfaz/autocompletarNombre.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtActualizaResponsableMeta').val(ui.item.txtActualizaResponsableMeta);
            $('#txtEmail').val(ui.item.txtEmail);
        }
    });
	
    $("#txtemailResponsableMeta").autocomplete({
        source: "../interfaz/autocompletarEmail.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtemailResponsableMeta').val(ui.item.txtEmail);
            $('#txtActualizaResponsableMeta').val(ui.item.txtActualizaResponsableMeta);
        }
    });
	
    $("#txtActualizaResponsableMeta").autocomplete({
        source: "../interfaz/autocompletarNombre.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtemailResponsableMeta').val(ui.item.txtEmail);
            $('#txtActualizaResponsableMeta').val(ui.item.txtActualizaResponsableMeta);
        }
    });
	
    $("#txtEmailPrograma").autocomplete({
        source: "../interfaz/autocompletarEmail.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtEmailPrograma').val(ui.item.txtEmail);
            $('#txtResponsableActualizaPrograma').val(ui.item.txtActualizaResponsableMeta);
        }
    });

    $("#txtResponsableActualizaPrograma").autocomplete({
        source: "../interfaz/autocompletarNombre.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtActualizaResponsableMeta').val(ui.item.txtActualizaResponsableMeta);
            $('#txtEmailPrograma').val(ui.item.txtEmail);
        }
    });
    //campo numerico
    $('.campoNumeros').keyup(function (){
        this.value = (this.value + '').replace(/[^0-9]/g, '');
    });
    // fin campo numerico
    // fin modificacion

    var datesA = $( "#txtFechaActualizaInicioMeta, #txtFechaActualizaFinalMeta" ).datepicker({
        defaultDate: "0w",
        changeMonth: true,
        numberOfMonths: 2,
        changeYear: true,
        dateFormat : 'yy-mm-dd',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        minDate: 0,
            onSelect: function( selectedDate ) {
                var option = this.id == "txtFechaActualizaInicioMeta" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" ),
                    dateA = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings );
                datesA.not( this ).datepicker( "option", option, dateA );
            }
    },$.datepicker.regional["es"]);

    var datesVA = $( "#txtVigenciaActualizaMetaPrincipal" ).datepicker({
        defaultDate: "0w",
        changeMonth: true,
        numberOfMonths: 2,
        changeYear: true,
        dateFormat : 'yy-mm-dd',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
        minDate: 0,
            onSelect: function( selectedDate ) {
                var option = this.id,
                        instance = $( this ).data( "datepicker" ),
                        dateVA = $.datepicker.parseDate(
                                instance.settings.dateFormat ||
                                $.datepicker._defaults.dateFormat,
                                selectedDate, instance.settings );
                datesVA.not( this ).datepicker( "option", option, dateVA );
            }
    },$.datepicker.regional["es"]);


    var dvMetaActualiza = '<div id="dvMetaIndicadorAgregadoNueva" class="dvMetaIndicadorAgregadoNueva">\
                           <br />\
                           <table width="75%" border="0">\
                                <tr>\
                                    <td >Descripción Avance:</td>\
                                    <td ><input type="text" id="txtMetaAgregadoNueva" name="txtActualizaMeta[]" class="txtNombreMeta" /><button id="btnDeleteMetaAgregadoNueva" class="btnAddMetaActualiza btn btn-warning" rel="dvContenedorMetaAgregadoNueva_" alt="dvContenedorMetaAgregado_"><i class="fa fa-minus-circle" aria-hidden="true"></i> Meta</button></td>\
                                </tr>\
                                <tr>\
                                    <td>&nbsp;</td>\
                                </tr>\
                            </table>\
                            <table width="75%" border="0">\
                                <tr>\
                                    <td width="230">Fecha Inicio: </td>\
                                    <td width="180"><input type="text" id="txtFechaInicioMetaAgregadoNueva" name="txtFechaActualizaInicioMeta[]" /></td>\
                                    <td width="92">Fecha Final: </td>\
                                    <td width="180"><input type="text" id="txtFechaFinalMetaAgregadoNueva" name="txtFechaActualizaFinalMeta[]" /></td>\
                                </tr>\
                                <tr>\
                                    <td>&nbsp;</td>\
                                </tr>\
                            </table>\
                            <table width="75%" border="0">\
                                <tr>\
                                    <td width="185">Avance Esperado:</td>\
                                    <td width="388"><input type="text" id="txtValorMetaAgregadoNueva" name="txtActualizaValorMeta[]" class="valor campoNumeros acumulado" /></td>\
                                </tr>\
                                <tr>\
                                    <td>&nbsp;</td>\
                                </tr>\
                                <tr>\
                                    <td>Acciones:</td>\
                                    <td><textarea id="txtAccionMetaAgregadoNueva" name="txtActualizaAccionMeta[]" rows="3"></textarea></td>\
                                </tr>\
                                <tr>\
                                    <td>&nbsp;</td>\
                                </tr>\
                                <tr>\
                                    <td width="185">Responsable:</td>\
                                    <td width="388"><input type="text" id="txtResponsableMetaAgregadoNueva" name="txtActualizaResponsableMeta[]" /></td>\
                                </tr>\
                                <tr>\
                                    <td>&nbsp;</td>\
                                </tr>\
                                <tr>\
                                    <td width="185">Email:</td>\
                                    <td width="388"><input type="text" id="txtemailResponsableMeta" name="txtemailResponsableMeta[]" class="correos" /><br/><strong>"Para múltiples responsables,separar los correos con coma"</strong> </td>\
                                </tr>\
                                <tr>\
                                    <td>&nbsp;</td>\
                                </tr>\
                            </table>\
                            </div>\ ';
    $(function( ){
        var xMetaActualiza = $(".dvMetaIndicadorAgregadoNueva div").length;
        var limiteActualiza = 14;
        var cuentaActualiza = 0;
        var txtNumeroMetaSecundaria = $("#txtNumeroMetaSecundaria").val( );
        if( txtNumeroMetaSecundaria != 0 ){
                xMetaActualiza = txtNumeroMetaSecundaria;
        }
        $("#btnAddMetaActualiza").button( ).click(function( ){
            if( xMetaActualiza < limiteActualiza ){
                xMetaActualiza++;
                cuentaActualiza++;
                /*txtNumeroMetaSecundaria++;*/
                $(".dvAgregarMeta").append( '<div id="dvContenedorMetaAgregadoNueva_'+cuentaActualiza+'">'+dvMetaActualiza+'</div>');
                $("#dvContenedorMetaAgregadoNueva_"+cuentaActualiza).find("input, button, div, a").each(function( ){
                        var idNuevoMetaPrincipal = $( this ).attr( "id" );
                        $( this ).attr( "id", ""+idNuevoMetaPrincipal+cuentaActualiza );
                        var relMetaAgregadoNueva = $( this ).attr( "rel" );
                        if( relMetaAgregadoNueva !== undefined ){
                                $( this ).attr( "rel", ""+relMetaAgregadoNueva+cuentaActualiza );	
                        }
                });

                $("#btnDeleteMetaAgregadoNueva"+cuentaActualiza).button( ).click(function( ){
                    if( xMetaActualiza > 0 ){
                        var relMeta = $( this ).attr( "rel" );
                        $("#"+relMeta ).remove( );
                        xMetaActualiza--;
                    }else{
                        alert( "Debe existir al menos una meta a cumplir" );
                    }
                    return false;
                });
                var datesAM = $( "#txtFechaInicioMetaAgregadoNueva"+cuentaActualiza+", #txtFechaFinalMetaAgregadoNueva"+cuentaActualiza  ).datepicker({
                    defaultDate: "0w",
                    changeMonth: true,
                    numberOfMonths: 2,
                    changeYear: true,
                    dateFormat : 'yy-mm-dd',
                    monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                    minDate: 0,
                    onSelect: function( selectedDate ) {
                        var option = this.id == "txtFechaInicioMetaAgregadoNueva"+cuentaActualiza ? "minDate" : "maxDate",
                                instance = $( this ).data( "datepicker" ),
                                dateAM = $.datepicker.parseDate(
                                        instance.settings.dateFormat ||
                                        $.datepicker._defaults.dateFormat,
                                        selectedDate, instance.settings );
                        datesAM.not( this ).datepicker( "option", option, dateAM );
                    }
                },$.datepicker.regional["es"]);	

                $("#txtemailResponsableMeta"+cuentaActualiza+"").autocomplete({
                    source: "../interfaz/autocompletarEmail.php",
                    minLength: 3,
                    select: function(event, ui) {
                        event.preventDefault();
                        $("#txtemailResponsableMeta"+cuentaActualiza+"").val(ui.item.txtEmail);
                        $("#txtResponsableMetaAgregadoNueva"+cuentaActualiza+"").val(ui.item.txtActualizaResponsableMeta);
                    }
                });

                $("#txtResponsableMetaAgregadoNueva"+cuentaActualiza+"").autocomplete({
                    source: "../interfaz/autocompletarNombre.php",
                    minLength: 3,
                    select: function(event, ui) {
                    event.preventDefault();
                        $("#txtemailResponsableMeta"+cuentaActualiza+"").val(ui.item.txtEmail);
                        $("#txtResponsableMetaAgregadoNueva"+cuentaActualiza+"").val(ui.item.txtActualizaResponsableMeta);
                    }
                });
                
                $(".campoNumeros").keyup(function ( ){
                    this.value = (this.value + "").replace(/[^0-9]/g, "");
                });
                
                actualizarTextoMeta();

            }else{
                alert( "No puede ingresar más metas" );
            }
            return false;
        });
    });


    $("#btnCancelarActualizarPlan").button( ).click(function( ){
        $( "#actualizaPlan" ).dialog( "close" );
    });

    //autocompletarproyecto
    $("#txtEmailProyecto").autocomplete({
        source: "../interfaz/autocompletarEmail.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtEmailProyecto').val(ui.item.txtEmail);
            $('#txtResponsableActualizaProyecto').val(ui.item.txtActualizaResponsableMeta);
        }
    });

    $("#txtResponsableActualizaProyecto").autocomplete({
        source: "../interfaz/autocompletarNombre.php",
        minLength: 3,
        select: function(event, ui) {
            event.preventDefault();
            $('#txtEmailProyecto').val(ui.item.txtEmail);
            $('#txtResponsableActualizaProyecto').val(ui.item.txtActualizaResponsableMeta);
        }
    });
    
    actualizarTextoMeta();
    
    $("#txtValorMetaActualizaPrincipal").on("keyup",function(){
        var metaSecundaria = $("#txtValoresMetaSecundaria").val( );
        var mPrincipal = $("#txtValorMetaActualizaPrincipal").val();
        var acumuladorValorMetas = 0;
        $(".acumulado").each(function() {
           acumuladorValorMetas +=Number($(this).val());
        });
        
        
        var valorMetaSecundaria = parseFloat(metaSecundaria) + parseFloat(acumuladorValorMetas);
        if(valorMetaSecundaria <= mPrincipal ) {
          $("#pendiente").text( mPrincipal - valorMetaSecundaria );
         }else{
          $("#pendiente").text( "El valor de los avances es mayor al alcance de la Meta Principal" );
         }
    });
    
    
    $("#btnActualizarPlan").button( ).click(function( ){
        var bandera = true;
	$(".txtNombreMeta").each(function( ){
            var txtNombreMeta = $( this ).val( );
            if( txtNombreMeta != "" ){
                $("#detalleIndicador").find("input[type=text]").each(function( ){
                    var valor = trim($( this ).val( ));
                    if( valor == "" ){
                        bandera = false;
                    }
                });
            }
	});
	
        /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
         *Se añade validacion para que los avances  no superen el alcance de la meta principal 
         *Since May 30,2018
         */
        var mPrincipal = $("#txtValorMetaActualizaPrincipal").val();
        var metaSecundaria = $("#txtValoresMetaSecundaria").val( );
        if (metaSecundaria ==""){
            metaSecundaria = 0;
        }
        var acumuladorValorMetas = 0;
        var valorMetaSecundaria = 0;
        $(".acumulado").each(function() {
           acumuladorValorMetas +=Number($(this).val());
        });
        
         valorMetaSecundaria = parseFloat(metaSecundaria) + parseFloat(acumuladorValorMetas);
         
        if(valorMetaSecundaria <= mPrincipal ) {
                
            if( mPrincipal==0 ){
                alert("La meta a alcanzar debe ser mayor a cero");
            }else if( bandera ){
                $( "#btnActualizarPlan" ).button({ label: "Guardando <img width='16' height='16' src='../css/images/cargando.gif' />" });
                $( "#btnActualizarPlan" ).button( "option" , "disabled" , true );
                $( "#mensageActualizar" ).dialog( "option", "buttons", {
                    "Aceptar": function() {
                        $.ajax({
                            url: "../servicio/registrar.php",
                            type: "POST",
                            data: $( "#formActualizar" ).serialize( ),
                            success: function( data ){
                                if( data != 1 ){
                                    if( data.length > 0 ){
                                        alert( "Ha ocurrido un problema" );
                                        $( "#mensageActualizar" ).dialog( "close" );
                                        $( "#btnActualizarPlan" ).button({ label: "Guardar" });
                                        $( "#btnActualizarPlan" ).button( "option", "disabled", false );
                                    }else{
                                        alert("Se han guardado los cambios");
                                        $( "#mensageActualizar" ).dialog( "close" );
                                        $( "#btnActualizarPlan" ).button({ label: "Guardar" });
                                        $( "#btnActualizarPlan" ).button( "option", "disabled", false );
                                        $( "#actualizaPlan" ).dialog( "close" );
                                        $( "#btnConsultar" ).trigger( "click" );
                                    }
                                }else{
                                    alert( "Ha completado el número de metas anuales" );
                                    $( "#mensageActualizar" ).dialog( "close" );
                                    $( "#btnActualizarPlan" ).button({ label: "Guardar" });
                                    $( "#btnActualizarPlan" ).button( "option", "disabled", false );
                                }
                            }
                        });
                    },
                    "Cancelar":function(){
                        $( "#mensageActualizar" ).dialog( "close" );
                        $( "#btnActualizarPlan" ).button({ label: "Guardar" });
                        $( "#btnActualizarPlan" ).button( "option", "disabled", false );
                    }
                });
                $( "#mensageActualizar" ).dialog( "open" );
            }else{
                alert( "Por favor diligencie todos los campos" );
                }
        } else {
            alert("Error: El valor de los avances es mayor al alcance de la Meta Principal")
        }
    });
    
    $("#txtActualizaValorMeta").on("keyup",function (){
       var avances = parseFloat($("#txtValorAvances").val( ));
       var avanceActual = parseFloat($("#txtActualizaValorMeta").val( ));
       var suma = parseFloat(avances)+parseFloat(avanceActual);  
       $("#txtValorAvancesAct").val( parseFloat(avances) + parseFloat($(this).val()));
       
    });

    function guardarMetaSecundaria(){
	var txtIdMetaSecundaria = trim( $( "#txtIdMetaSecundaria" ).val(  ) );
	var txtActualizaMeta = trim( $( "#txtActualizaMeta" ).val(  ) );
	var txtFechaActualizaInicioMeta = trim( $( "#txtFechaActualizaInicioMeta" ).val(  ) );
	var txtFechaActualizaFinalMeta = trim( $( "#txtFechaActualizaFinalMeta" ).val(  ) );
	var txtActualizaValorMeta = trim( $( "#txtActualizaValorMeta" ).val(  ) );
	var txtActualizaAccionMeta = trim($( "#txtActualizaAccionMeta" ).val( ) );
	var txtActualizaResponsableMeta = trim( $( "#txtActualizaResponsableMeta" ).val(  ) );
	var txtEmail = trim( $( "#txtEmail" ).val( ) );
        var txtAlcanceMeta = $( "#txtAlcanceMeta" ).val( );
        var txtValorAvancesAct = $( "#txtValorAvancesAct" ).val( );
	var error = false;
	
        if( txtActualizaMeta=="" || txtFechaActualizaInicioMeta=="" || txtFechaActualizaFinalMeta=="" || txtActualizaValorMeta=="" || txtActualizaAccionMeta=="" || txtActualizaResponsableMeta==""  || txtEmail==""){
            error = true;
	} 
	
	if(error){
            alert( "Por favor diligencie todos los campos");
	}else if( txtActualizaValorMeta==0 ){
            alert ("El valor del avance esperado debe ser mayor a cero");	
	}else if ( parseFloat(txtValorAvancesAct) > parseFloat(txtAlcanceMeta) ){
            alert ("El valor de los avances supera el alcance de la Meta Principal");
        }
	else{ 
            var tipoOperacion = "actualizarMetaSecundaria";
            $( "#mensageActualizarMetaSec" ).dialog( "option", "buttons", {
                "Aceptar": function() {
                    $.ajax({
                            url: "../servicio/meta.php",
                            type: "POST",
                            data: { 
                                tipoOperacion : tipoOperacion,
                                txtIdMetaSecundaria : txtIdMetaSecundaria,
                                txtActualizaMeta : txtActualizaMeta,
                                txtFechaActualizaInicioMeta : txtFechaActualizaInicioMeta,
                                txtFechaActualizaFinalMeta : txtFechaActualizaFinalMeta,
                                txtActualizaValorMeta : txtActualizaValorMeta,
                                txtActualizaAccionMeta : txtActualizaAccionMeta,
                                txtActualizaResponsableMeta : txtActualizaResponsableMeta,
                                txtEmail : txtEmail 
                            },
                            success: function( data ){
                                if( data.length > 0 ){
                                    alert( "Ha ocurrido un problema" ); 
                                    $( "#mensageActualizarMetaSec" ).dialog( "close" );
                                    $( "#actualizaPlan" ).dialog( "close" );
                                }else{
                                    alert("Se han guardado los cambios");
                                    $( "#mensageActualizarMetaSec" ).dialog( "close" );
                                    $( "#actualizaPlan" ).dialog( "close" );
                                    $( "#btnConsultar" ).trigger( "click" );
                                }
                            }
                    });
		},
                "Cancelar":function(){
                        $( "#mensageActualizarMetaSec" ).dialog( "close" );
                        $( "#btnActualizarPlan" ).button({ label: "Guardar" });
                        $( "#btnActualizarPlan" ).button( "option", "disabled", false );
                }
            });
            $( "#mensageActualizarMetaSec" ).dialog( "open" );
	}
    }
/*Modified Diego Rivera <riveradiego@unbosque.edu.co>
 *Se crea funcion para acumular valores de avances e indicar el valor del alcance pendiente para alcanzar el alcance de la meta principal
 *Since May 31 , 2018
 */
function actualizarTextoMeta(){
    $(".acumulado").on("keyup",function(){
        var metaSecundaria = $("#txtValoresMetaSecundaria").val( );
        if(metaSecundaria == ""){
            metaSecundaria=0;
        }
        var mPrincipal = $("#txtValorMetaActualizaPrincipal").val();
        var acumuladorValorMetas = 0;
        $(".acumulado").each(function() {
           acumuladorValorMetas +=Number($(this).val());
        });
        var valorMetaSecundaria = parseFloat(metaSecundaria) + parseFloat(acumuladorValorMetas);
     
          $("#pendiente").text( mPrincipal - valorMetaSecundaria );
          if(valorMetaSecundaria > mPrincipal ) {
              $("#color").css("color", "red");
              $("#pendiente").css("color", "red");
              $("#pendienteMsg").text("El valor de los avances es mayor al alcance de la Meta Principal");
          }else{
               $("#pendienteMsg").text("");
               $("#color").css("color", "black");
               $("#pendiente").css("color", "black");
          }
    });
}