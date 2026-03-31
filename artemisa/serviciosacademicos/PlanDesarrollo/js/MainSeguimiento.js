/**
 * @author Ivan quintero 
 * Febrero 22, 2017
 */

$(document).ready(function(){ 

    $( "#detallePlan" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Detalle Plan de Desarrollo",
        width: 700,
        height: 'auto',
        show: {
        effect: "blind",
        duration: 500
        },
        hide: {
              effect: "blind",
              duration: 500
        },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
    });

    $( "#verAvance" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Detalle Avances Indicador",
        width: 750,
        height: 'auto',
        show: {
            effect: "blind",
            duration: 500
        },
         hide: {
            effect: "blind",
            duration: 500
         },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
         }
    });


    $("#actualizarObservacion").dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Observación Indicador",
        width: 500,
        height: 'auto',
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
    });

    $("#actualizarEvidencia").dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Actualizar Evidencia",
        width: 700,
        height: 'auto',
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
    });

    $("#nuevaMetaPrincipal").dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Nueva Meta Principal",
        width: 800,
        height: 'auto',
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
    });

    $("#actualizarObservacion").dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Observación Indicador",
        width: 500,
        height: 'auto',
        show: {
        effect: "blind",
        duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
    });

    $( "#verEvidencias" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Archivos de envidencias",
        width: 700,
        height: 'auto',
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        open: function() {
           $buttonPane = $(this).next();
           $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
    });

    $( "#actualizaPlan" ).dialog({
        autoOpen: false,
        modal: true,
        draggable: true,
        resizable: false,
        title: "Actualizar Plan de Desarrollo",
        width: 900,
        height: 'auto',
        show: {
            effect: "blind",
            duration: 500
        },
        hide: {
            effect: "blind",
            duration: 500
        },
        open: function() {
              $buttonPane = $(this).next();
        }
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

    $("#btnConsultar").click(function( ){
        var datosD = $("#formConsultar").serialize( );
        var camposVacios = validarFormulario( datosD );
        camposVacios = camposVacios.trim();
        if(camposVacios==""){
            var tipoOperacion = "consultarPlan";
            $( "#btnConsultar" ).button({ label: "Buscando <img width='16' height='16' src='../css/images/cargando.gif' />" });
            $( "#btnConsultar" ).button( "option" , "disabled" , true );
            $.ajax({
                    url: "../interfaz/seguimientoPlanDesarrollo.php",
                    type: "POST",
                    data: $( "#formConsultar" ).serialize( ) + "&option="+tipoOperacion,
                    success: function( data ){
                            data = trim( data );
                            $( "#dvTablaConsultarPlan" ).css( "display", "block" );
                            $( "#btnConsultar" ).button({ label: "Consultar" });
                            $( "#TablaConsultarPlan" ).html( data );
                            $( "#btnConsultar" ).button( "option", "disabled", false );
                    }
            });
        }else{
                crearMensaje( camposVacios );
        }
    });

    $("#btnNuevaMeta").click(function( ){

        var idProyecto = $("#cmbProyectoConsultar").find(':selected').val();
        var facultad = $("#txtCodigoFacultad").find(':selected').text();
        var programaAcademico = $("#cmbCarrera").find(':selected').text();
        var linea = $("#cmbLineaConsulta").find(':selected').text();
        var programa = $("#cmbProgramaConsultar").find(':selected').text();
        var proyecto  = $("#cmbProyectoConsultar").find(':selected').text();
        if(idProyecto=='-1'){
                alert("Debe seleccionar Proyecto ");

        } else {
            var url="../interfaz/registrarMeta.php";

            $.ajax({
                    url : url,
                    type : "POST",
                    data :{idProyecto : idProyecto , facultad : facultad , programaAcademico : programaAcademico , linea : linea , programa : programa , proyecto : proyecto },
                    success:function(data){
                            $("#nuevaMetaPrincipal").html(data);
                            $("#nuevaMetaPrincipal").dialog("open");
                    }
            });
        }
    });


    $('#formConsultar').submit(function(){ 
            return false;
    });

    $('#btnRestaurar').click(function(){
            $(".chosen-select").val('-1').trigger("chosen:updated");
            $("#formConsultar").reset( );
            updateSelectLists( );
            $( "#dvTablaConsultarPlan" ).css( "display", "none" );
    }); 


    $("#btnGuardarObservaciones").button( ).click(function( e ){
            e.stopPropagation();
            e.preventDefault();
    });

    $("#btnRestaurarObservaciones").button( ).click(function( e ){
            e.stopPropagation();
            e.preventDefault();
    });

    $("#btnRegresarConsultar").on("click",function( ){
            volver( );
    });

    $('#txtCodigoFacultad,#cmbLineaConsulta,#cmbCarrera,#cmbProgramaConsultar,#cmbProyectoConsultar').change(function(){
            updateSelectLists();
    });
    $('#txtCodigoFacultad').change(function(){
                    var emptyselect = '<option value="-1" >Seleccionar</option>';
            $("#cmbProgramaConsultar,#cmbProyectoConsultar,#cmbIndicadorConsultar").html(emptyselect);
            $("#cmbLineaConsulta,#cmbProgramaConsultar,#cmbProyectoConsultar,#cmbIndicadorConsultar").val('-1').trigger("chosen:updated");
    });



    $(".aprobado").click(function(){

        var tipoOperacion = "aprobacion";	
        var idClaseAprobado = $(this).attr("id");
        var valor=($(this).attr("value"));
        var numeroId = idClaseAprobado.split("_");
        var id = numeroId[1];
        var idMetaSecundaria=$("#idMetaSecundaria_"+id+"").val();

        /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
         *se añade variable idMetaPrincipal para enviar como parametro y poder acutalizar el alcance de la meta pricipal
         *Since March 28,2017 
         */
        var idMetaPrincipal=$("#idMetaPrinciapl_"+id+"").val();

        var url = "../servicio/registrar.php";

                    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                     *se añade condicional para realizar cambio de color en estas y avances
                     *Since March 28,2017 
                     */
        $('#spanMessage').html('¿Desea guardar los cambios?');
        $("#dialogConfirm").dialog({
            resizable: false,
            width:350,
            height: 140,
            modal: true,
            title: 'Mensaje de confirmacion',
            show: {
                effect: "blind",
                duration: 500
            },
            hide: {
                effect: "blind",
                duration: 500
            },
            open: function() {
                $buttonPane = $(this).next();
                $buttonPane.find('button').addClass('btn').addClass('btn-warning');
              },
            buttons: {
                'Aceptar': function () {

                   if( valor == 'Aprobado' ){
                        tipoOperacion='aprobacion';
                        $( "#vAprobado_"+id+"" ).val( 'Aprobado' );
                    }
                    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                    *Se añade validacion con el fin de asignar valor eliminarAprobacion a la variable tipoOperacion para identificar que esta dando click en la opcion de elimnar aprobacion  
                    *Since August 23 ,2017
                    */		

                    else if ( valor == 'Sinestadodeaprobacion' ) {
                        tipoOperacion='eliminarAprobacion';
                    } 	
                    //Fin modificacion
                    else  {
                        tipoOperacion='nAprobacion';
                    }
                    $.ajax({
                            type : "POST",
                            url : url,
                            data : { tipoOperacion : tipoOperacion , id : id , valor : valor , metaSecundaria : idMetaSecundaria , idMetaPrincipal : idMetaPrincipal },
                            success:function( data ){
                                if ( valor == 'Sinestadodeaprobacion' ) {
                                        alert("Estado de la evidencia: Sin estado de aprobacion");
                                }else{
                                        alert("Estado de la evidencia:"+valor);
                                }
                                $("#aprobado_"+id+"").html(valor);
                                if( data == 'NO' ){

                                        $("#aprobado_"+id+"").html(valor);
                                        $("#avance_"+idMetaSecundaria+"").html('-');
                                        $("#btnRegistrarEvidenciaAvance_"+idMetaSecundaria+"").show( );
                                        $("#observacion_"+id+"").text("");
                                        $( "#verAvance" ).dialog("close");
 
                                       var direccion = "../cron/alertaAprobacion.php";
                                        $.ajax({
                                                type : "POST",
                                                url : direccion,
                                                data : { metaSecundaria : idMetaSecundaria },
                                                success:function( data ){
                                                }

                                        });

                                } else {

                                    /*Modified Diego Rivera <riveradiego@unbosque.edu.co>
                                     *se recibe data y se delimita por _ para poder identificar las div a acutulizar cambiando los colores dependiendo el porcentaje de avance
                                     *Since March 28,2017
                                     */
                                    identificador=data.split("_");
                                    metaPrincipal=identificador[0];
                                    metaSecundaria=identificador[1];
                                    avanceMetaPrincipal=parseFloat(identificador[2]);
                                    avanceMetaSecundaria=parseFloat(identificador[3]);
                                    alcanceMetaPrincipal =parseFloat($("#meta_"+metaPrincipal+"").text());
                                    alcanceMetaSecundaria=parseFloat($("#indicadoActual_"+metaSecundaria+"").text());
                                    textoAlcance= $("#meta_"+metaPrincipal+"").text();

                                    if(isNaN(alcanceMetaPrincipal)){
                                            alcanceMetaPrincipal=1;
                                            texto ='<font color="white">&nbsp</font>';	
                                            color = '#84c3be';								
                                            titulo ='Sobrepasa el indicador';

                                            porcentajeMetaPrincipal = avanceMetaPrincipal * 100;
                                            porcentajeMetaPrincipal =parseFloat(porcentajeMetaPrincipal/alcanceMetaPrincipal).toFixed(2);
                                            porcentajeMetaSecundaria = avanceMetaSecundaria * 100;
                                            porcentajeMetaSecundaria =parseFloat(porcentajeMetaSecundaria/alcanceMetaSecundaria).toFixed(2);

                                    } else {

                                            porcentajeMetaPrincipal = avanceMetaPrincipal * 100;
                                            porcentajeMetaPrincipal =parseFloat(porcentajeMetaPrincipal/alcanceMetaPrincipal).toFixed(2);

                                            porcentajeMetaSecundaria = avanceMetaSecundaria * 100;
                                            porcentajeMetaSecundaria =parseFloat(porcentajeMetaSecundaria/alcanceMetaSecundaria).toFixed(2);

                                            if( porcentajeMetaPrincipal  > 100 )
                                            {
                                                    texto ='<font color="white">'+porcentajeMetaPrincipal+'</font>';	
                                                    color = '#84c3be';								
                                                    titulo ='Sobrepasa el indicador';
                                            }
                                            else if( porcentajeMetaPrincipal > 75 && porcentajeMetaPrincipal < 101 )
                                            {
                                                    texto ='<font color="white">'+porcentajeMetaPrincipal+'</font>';
                                                    color = 'blue';
                                                    titulo ='Muy alto';
                                            }
                                            else if( porcentajeMetaPrincipal > 50 && porcentajeMetaPrincipal <= 75 )
                                            {
                                                    texto ='<font color="white">'+porcentajeMetaPrincipal+'</font>';
                                                    color = 'green';
                                                    titulo ='Alto';
                                            }
                                            else if( porcentajeMetaPrincipal > 25 && porcentajeMetaPrincipal <= 50 )
                                            {
                                                    texto ='<font color="black">'+porcentajeMetaPrincipal+'</font>';
                                                    color = 'yellow';
                                                    titulo ='Medio';
                                            }
                                            else if( porcentajeMetaPrincipal  < 26 )
                                            {
                                                    texto ='<font color="white">'+porcentajeMetaPrincipal+'</font>';
                                                    color = 'red';
                                                    titulo ='Bajo';
                                            }	
                                    //fin	
                                    }			
                                    $("#valorIndicadorMeta_"+metaPrincipal+"").css("background-color", color);
                                    $("#valorIndicadorMeta_"+metaPrincipal+"").attr("data-original-title",titulo);
                                    $("#valorIndicadorMeta_"+metaPrincipal+"").html( texto );

                                    if( porcentajeMetaSecundaria  > 100 )
                                    {
                                        texto ='<font color="white">'+porcentajeMetaSecundaria+'</font>';	
                                        color = '#84c3be';								
                                        titulo ='Sobrepasa el indicador';
                                    }
                                    else if( porcentajeMetaSecundaria > 75 && porcentajeMetaSecundaria < 101 )
                                    {
                                        texto ='<font color="white">'+porcentajeMetaSecundaria+'</font>';
                                        color = 'blue';
                                        titulo ='Muy alto';
                                    }
                                    else if( porcentajeMetaSecundaria > 50 && porcentajeMetaSecundaria <= 75 )
                                    {
                                        texto ='<font color="white">'+porcentajeMetaSecundaria+'</font>';
                                        color = 'green';
                                        titulo ='Alto';
                                    }
                                    else if( porcentajeMetaSecundaria > 25 && porcentajeMetaSecundaria <= 50 )
                                    {
                                        texto ='<font color="black">'+porcentajeMetaSecundaria+'</font>';
                                        color = 'yellow';
                                        titulo ='Medio';
                                    }
                                    else if( porcentajeMetaSecundaria  < 26 )
                                    {
                                        texto ='<font color="white">'+porcentajeMetaSecundaria+'</font>';
                                        color = 'red';
                                        titulo ='Bajo';
                                    }	
                                    //fin	

                                    $("#valorIndicador_"+metaSecundaria+"").css("background-color", color);
                                    $("#valorIndicador_"+metaSecundaria+"").attr("data-original-title",titulo);
                                    $("#valorIndicador_"+metaSecundaria+"").html( texto );
                                    $txtObs=$("#observacion_"+id+"").text( );
                                    $("#observacion_"+id+"").text("");
                                    $("#observacion_"+id+"").text( $txtObs );
                                    $("#estado_"+id+"").text("-");
                                     if ( valor == 'Sinestadodeaprobacion' ) {
                                          $("#avance_"+metaSecundaria+"").text("Existen Avances Pendiente por aprobar");
                                    } else {
                                          $("#avance_"+metaSecundaria+"").text(avanceMetaSecundaria);
                                    }
                                    $("#estado_"+id+"").text("-");
                                    $("#txtFileAvance").val("");
                                    $( "#verAvance" ).dialog("close");

                                    //fin modificacion		
                                    }

                            }

                    });	     

                $(this).dialog("close");
                },
                    'Cancelar': function () {
                     $(".aprobado").attr('checked', false);  
                     $(this).dialog("close");
                    }
                }
        });

        $("#btnActAvance").hide();
    });


    function updateSelectLists(){
            var cbmLineaConsulta = $('#cmbLineaConsulta').val();
            var cmbProgramaConsultar = $('#cmbProgramaConsultar').val();
            var cmbProyectoConsultar = $('#cmbProyectoConsultar').val();
            /*
            * @ivan quintero <quinteroivan@unbosque.edu.co>
            * Modificacion de texto  cmbIndicadorConsultar a cmbMetaConsultar
            * Marzo 13, 2017
            */	
            var cmbMetaConsultar = $('#cmbMetaConsultar').val();
            /*
            * END
            */
            var txtCodigoFacultad = $('#txtCodigoFacultad').val();
            var cmbCarrera = $("#cmbCarrera").val();

            var url =  '../interfaz/seguimientoPlanDesarrollo.php'; 	
        $.ajax({
            dataType: 'json',
            type: 'POST',
            url: url,
            data: {
                option : 'updateSelectLists',
                txtCodigoFacultad:txtCodigoFacultad,
                cmbCarrera:cmbCarrera, 
                cbmLineaConsulta:cbmLineaConsulta, 
                cmbProgramaConsulta:cmbProgramaConsultar, 
                        cmbProyectoConsulta:cmbProyectoConsultar, 
                        /*
                        * @ivan quintero <quinteroivan@unbosque.edu.co>
                        * Modificacion de texto  cmbIndicadorConsultar a cmbMetaConsultar
                        * Marzo 13, 2017
                        */
                        cmbMetaConsultar:cmbMetaConsultar
                        /*
                        * END
                        */
            },
            success: function(data) {
                if(data.success){
                    $('#cmbCarrera').html(data.values.carreras);
                    $('#cmbProgramaConsultar').html(data.values.programas);
                    $('#cmbProyectoConsultar').html(data.values.proyectos);
                    /*
                            * @ivan quintero <quinteroivan@unbosque.edu.co>
                            * Modificacion de texto  cmbIndicadorConsultar a cmbMetaConsultar
                            * Marzo 13, 2017
                            */
                    $('#cmbMetaConsultar').html(data.values.metas);
                            /*
                            * END
                            */
                    //console.log(data.values );
                    $(".chosen-select").trigger("chosen:updated");
                }
            },
            error: function(xhr, status, error) {
                    alert("An error occured: " + status + "\nError: " + error);
            }
        });  
    }
    function validar(){
            return true;
    }
    /*modified Diego Rivera<riveradiego@unbosque.edu.co>
     * se añaden meses en español y bloqueo de fechas anteriores a la actual
     * Since March 21,2017 
     */
    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
     *Se cambia activan dias anterios en fecha y se blosquean dias posteriores a la fecha actual
     *se reemplaza parametro minDate:0 por maxDate: 0
     *Since May 29 , 2018
     */
        
    var dates = $( "#txtFechaActividad" ).datepicker({
            defaultDate: "0w",
            changeMonth: true,
            numberOfMonths: 2,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            maxDate: 0,
            onSelect: function( selectedDate ) {
                var option = this.id,
                    instance = $( this ).data( "datepicker" ),
                    date = $.datepicker.parseDate(
                            instance.settings.dateFormat ||
                            $.datepicker._defaults.dateFormat,
                            selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
    },$.datepicker.regional["es"]);

    $("#txtFileAvance").filestyle({
        input: false,
        buttonName: "btn-warning",
        buttonText: "Examinar",
    });


    $(".txtFileEvidencia").filestyle({
        input: false,
        buttonName: "btn-warning",
        buttonText: "Examinar",

    });	 

    //fin modificacion
    
    	$( "#confirmarAlcance" ).dialog({
                autoOpen: false,
                modal: true,
                draggable: true,
                resizable: false,
                title: "Advertencia",
                width: 'auto',
                height: 'auto',
                show: {
                effect: "blind",
                duration: 500
                 },
                hide: {
                effect: "blind",
                duration: 500
                 },
                buttons: {
                        "Cerrar": function( ) { 
                        $(this).dialog("close"); 
                            }
                         },
        open: function() {
            $buttonPane = $(this).next();
            $buttonPane.find('button').addClass('btn').addClass('btn-warning');
        }
	});
    
    

    $("#btnGuardarActividad").button( ).click( function( e ){
        e.stopPropagation();
        e.preventDefault();
        var numero = "";
        var idAvance = $(".identificador").attr('id');
        /*modified Diego Rivera<riveradiego@unbosque.edu.co>
         * se añade variable idAvanceMeta para capturar el id de la metaprincipal y poder calcular el porcentaje actual
         * Since March 23,2017
         */
        var idAvanceMeta = $(".identificadorMeta").attr('id');	
        var alcanceMetaPrincipal = parseFloat($("#meta_"+idAvanceMeta+"").text());
        //fin modificacion	
        var txtProyectoPlanDesarrolloId = $( "#txtProyectoPlanDesarrolloId" ).val( );
        var txtIndicadorPlanDesarrolloId = $( "#txtIndicadorPlanDesarrolloId" ).val( );
        var txtNombreActividad = $( "#txtNombreActividad" ).val( );
        var txtFechaActividad = $( "#txtFechaActividad" ).val( );
        var txtAvancePropuesto = $( "#txtAvancePropuesto" ).val( );
        var txtTipoIndicador = $( "#tipoIndicador" ).val( );
        var inputFile = document.getElementById( "txtFileAvance" );
        var alcanceMetaSecundaria = $( "#alcanceMetaSecundaria" ).val( );
        var file = inputFile.files;
        var data = new FormData();
        var cuenta = "1";
        for(i=0; i<file.length; i++){

                cuenta = cuenta+data.append('fileToUpload'+i,file[i]); //Añadimos cada archivo a el arreglo con un indice direfente
        }

        $('#formObservaciones').validate({

            rules:{
                    txtNombreActividad : { required: true },
                    txtFechaActividad : { required: true },
                    txtAvancePropuesto : { required: true, number : true },
                    txtFileAvance : { required: true }
            },
            messages:{
                    txtNombreActividad : { required:"Registre la actividad" },
                    txtFechaActividad : { required:"Seleccione una fecha" },
                    txtAvancePropuesto : { required:"Registre el avance" , number:"Ingrese un valor numerico"},
                    txtFileAvance :{ required:"Seleccione el archivo de evidencia" },	
                    idMetaPrincipal:{}	
            }
        });

        if($('#formObservaciones').valid()){
            //data.append("fileToUpload",file);
            data.append( "cuenta", cuenta );
            data.append( "txtIndicadorPlanDesarrolloId" , txtIndicadorPlanDesarrolloId );
            data.append( "txtNombreActividad" , txtNombreActividad );
            data.append( "txtFechaActividad" , txtFechaActividad );
            data.append( "txtAvancePropuesto" , txtAvancePropuesto );
            data.append( "idMetaPrincipal" , idAvanceMeta );
            data.append("tipoOperacion","submit");
            
            var fn = function (){
                return ( 
                    $.ajax({//Ajax
                        type: "POST",
                        url: "../servicio/evidenciaIndicador.php",
                        contentType:false,
                        data: data ,
                        processData:false,
                        cache:false,
                        success: function( data ){
                            if ( data > 0  ) {
                                var valorAvance  = $("#avance_"+idAvance+"").text();
                                var msg='<br>Avance pendiente por aprobar';
                                var Valor = valorAvance.concat(msg );
                                $("#btnRegistrarEvidenciaAvance_"+idAvance+"").hide();
                                $("#avance_"+idAvance+"").html( Valor );		
                                var texto = "";
                                var color = "";
                                var titulo = "";
                                alert( "Se han guardado los cambios" );
                                var direccion = "../cron/alertaEvidencia .php";
                                $.ajax({
                                    type : "POST",
                                    url : direccion,
                                    data : { metaSecundaria : txtIndicadorPlanDesarrolloId },
                                    success:function( data ){
                                    }
                                });
                                 $("#detallePlan").dialog("close");
                            } else {
                                if ( data == -2 ) {
                                    alert("Disculpa, el archivo es demasiado pesado");
                                }

                                if ( data == -3 ) {
                                    alert("El tipo de  archivo no es valido");
                                }

                                if ( data == 0 ) {
                                    $("#txtFileAvance").val("");
                                    alert( "El numero de evidencias permitidas es 10" );
                                }
                            }

                        }
                    })
                );
            };
               
            if( parseFloat(txtAvancePropuesto) > parseFloat(alcanceMetaSecundaria) ){
                $( "#confirmarAlcance" ).dialog( 
                "option", "buttons", {
                    "Aceptar": function() {
                        fn();
                        $( "#confirmarAlcance" ).dialog( "close" );
                        
                    },
                    "Cancelar":function(){
                            $( "#confirmarAlcance" ).dialog( "close" );
                    }
                });
                $( "#confirmarAlcance" ).dialog( "open" );
            } else{
                fn();
            }
        } else {
            return false;
         }
    });

    $("#btnNuevaObservacion").button( ).click(function ( e ){
            e.stopPropagation();
            e.preventDefault();
            var tipoOperacion = "nuevaObservacion";
            /*MOdified Diego Rivera <riveradiego@unbosque.edu.co
             *se cambia variables  idAvanceIndicador = $("#idAvanceIndicador").val( ); por  var idMetaSecundaria = $("#idMetaSecundaria").val( );
             * Since April 10 , 2017
             */
            var aprobacion = $("#aprobacion").val( );						
            var idMetaSecundaria = $("#idMetaSecundaria").val( );
            var conteo = $("#conteo").val();
            var observacion = $("#txtNuevaObservacion").val( );
            var url="../servicio/registrar.php";

            $('#registroObsevacion').validate({

                rules:{
                        txtNuevaObservacion : { required: true },
                },
                messages:{
                        txtNuevaObservacion: { required:"Registre la observacion" }
                }
            });

            if($('#registroObsevacion').valid()){
                /*MOdified Diego Rivera <riveradiego@unbosque.edu.co>
                 *se cambia variable idAvanceIndicador : idAvanceIndicador por idMetaSecundaria : idMetaSecundaria
                 * Since April 10 , 2017
                 */
                $.ajax({
                    type: "POST",
                    url:url,
                    data:{ tipoOperacion : tipoOperacion , idMetaSecundaria : idMetaSecundaria , observacion : observacion  , aprobacion : aprobacion},
                    success : function ( data ){
                       alert("Se ha registrado la observacion");
                       $("#observacion_"+conteo+"").html(observacion);
                       $("#actualizarObservacion").dialog( "close" );
                    }
                }); 
            }	
    });
     /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
     *Se cambia activan dias anterios en fecha y se blosquean dias posteriores a la fecha actual
     *se reemplaza parametro minDate:0 por maxDate: 0
     *Since May 29 , 2018
     */
    //validacion formulario actualizar evidencia
     var datesActualizar = $( "#fechaActividad" ).datepicker({
            defaultDate: "0w",
            changeMonth: true,
            numberOfMonths: 2,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
            maxDate: 0,
            onSelect: function( selectedDate ) {
                    var option = this.id,
                        instance = $( this ).data( "datepicker" ),
                        date = $.datepicker.parseDate(
                                    instance.settings.dateFormat ||
                                    $.datepicker._defaults.dateFormat,
                                    selectedDate, instance.settings 
                                );
                    datesActualizar.not( this ).datepicker( "option", option, date );
            }
    },$.datepicker.regional["es"]);

    $("#txtFileAvanceActualizar").filestyle({ input: false, buttonName: "btn-warning", buttonText: "Examinar" }  );


    $("#btnActualizarEvidencia").button( ).click( function( e ){
            e.stopPropagation();
            e.preventDefault();

            var idAvance=$("#idAvance").val();
            var archivo=$("#archivo").val();
            var actividad=$("#actividadA").val();
            var fechaActividad=$("#fechaActividad").val();
            var avancePropuesto=$("#avanceA").val();
            var inputFile = document.getElementById( "txtFileAvanceActualizar" );
            var ArchivoNuevo =$("#txtFileAvanceActualizar").val();
            var contador = parseInt($("#contador").val());
            var data = new FormData();
            var cuenta = "1";

            if( inputFile!='' ){
                var file = inputFile.files;

                for(i=0; i<file.length; i++){
                        cuenta = cuenta+data.append('fileToUpload'+i,file[i]); //Añadimos cada archivo a el arreglo con un indice direfente
                }	
            } else {
                    inputFile='1';
            }

            data.append( "cuenta", cuenta );
            data.append( "idAvance" , idAvance );
            data.append( "archivo" , archivo );
            data.append( "actividad" , actividad );
            data.append( "fechaActividad" , fechaActividad );
            data.append( "avancePropuesto" , avancePropuesto );
            data.append(" contador " , contador );   
            data.append("tipoOperacion","submitActualizar");

            $('#formActualizarEvidencia').validate({

                rules : {
                    actividad : { required : true }	,
                    avance :{ required: true, number : true , min : 1 }
                },
                messages : {
                    actividad : { required :"Registre la actividad"},
                    avance :{ required:"Registre el avance" , number:"Ingrese un valor numerico" , min : "El valor del avance debe ser mayor a cero"}
                }
            });

            if($('#formActualizarEvidencia').valid()){	
                $.ajax({
                    type: "POST",
                    url: "../servicio/evidenciaIndicadorActualizacion.php",
                    contentType:false,
                    data: data ,
                    processData:false,
                    cache:false,
                    success: function( data ){
                        identificador = data.split("_");
                        actualizar = identificador[0];
                        nombreArchivo =identificador[1];

                        if(	actualizar > 0 ){
                            alert( "Se han guardado los cambios" );
                            $("#fecha_"+contador+"").html( fechaActividad );
                            $("#actividad_"+contador+"").html( actividad );
                            $("#avances_"+contador+"").text( avancePropuesto );
                            $("#aLink").attr('href','../evidencia/'+nombreArchivo+'');
                            $("#txtFileAvance").val("");
                            $("#actualizarEvidencia").dialog( "close" );
                        }else {
                            if( actualizar == -2 ){
                                alert("Disculpa, el archivo es demasiado pesado");
                                $("#txtFileAvance").val("");
                            }
                            if( actualizar == -3 ){
                                alert("El tipo de  archivo no es valido");
                                $("#txtFileAvance").val("");
                            }

                        }
                    }
                });
            }
    });

    $("#btnRestaurarActividad").click(function( e ){
            e.stopPropagation();
            e.preventDefault();
            $( "#detallePlan" ).dialog("close");
    } );

    $("#btnCerrarAvances").click(function( e ){
            e.stopPropagation();
            e.preventDefault();
            $( "#verAvance" ).dialog("close");
    } );

    $("#btnSalirNuevaObservacion").click(function( e ){
            e.stopPropagation();
            e.preventDefault();
            $( "#actualizarObservacion" ).dialog("close");
    } );


    $("#btnRestaurarEvidencia").click(function( e ){
            e.stopPropagation();
            e.preventDefault();
            $( "#actualizarEvidencia" ).dialog("close");
    } );


    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
     *se añade funcion keyup para consultar indicadores en autocompletar de la pagina interfaz/registrarmeta.php 
     * Since April 6 ,2017
     * */

    $("#indicadorPlan").keyup(function(){

            $("#nIndicador").html("");
            $("#rdbCualitativo").removeAttr("disabled");
            $("#rdbCuantitativo").removeAttr("disabled");
            $("#idIndicador").val("");


            var NIndicador = unescape(($(this).val()));
            var idProyecto = $("#idProyecto").val();
            if( NIndicador != '' ){
                    $.ajax({
                            url:"autocompletar.php",
                            method:"POST",
                            data:{ NIndicador:NIndicador , idProyecto:idProyecto },
                            success: function(data){
                                $("#nIndicador").fadeIn();
                                $("#nIndicador").html(data);

                            }
                    });

            }else if( NIndicador.length<1){
                    $("#nIndicador").html("");
                    $("#rdbCualitativo").removeAttr("disabled");
                    $("#rdbCuantitativo").removeAttr("disabled");
            }

    });
    //fin modificacion

    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
     *se añade funcion que permite cargar el textarea al dar click en la respuesta del autocompletar  dependiendo el resultado activa e inactiva radiobutton  interfaz/registrarmeta.php 
     * Since April 6 ,2017
     * */


        $(document).on('click' , 'li' , function(){

                var nombreIndicador=$(this).text();
                var descripcion = nombreIndicador.split("-");
                var indicadorid=descripcion[0];
                var tipoIndicador=descripcion[1];
                var textoIndicador=descripcion[2];

                $("#indicadorPlan").val(textoIndicador);
                $("#tipoIndicador").val(tipoIndicador);
                $("#idIndicador").val(indicadorid);
                $("#nIndicador").fadeOut();

                if(tipoIndicador == 1){
                        $("#rdbCuantitativo").prop( "checked", true );
                        $("#rdbCualitativo").attr("disabled", true);
                }
                else if (tipoIndicador == 2){
                        $("#rdbCualitativo").prop( "checked", true );
                        $("#rdbCuantitativo").attr("disabled", true);
                }
                else if(tipoIndicador == ""){
                        $("#rdbCualitativo").removeAttr("disabled");
                        $("#rdbCuantitativo").removeAttr("disabled");
                }
        });

    //fin


    /*Modified Diego Rivera<riveradiego@unbosque.edu.co>
     *se añade funcion la cual permite capturar datos de  interfaz/registrarmeta.php para registrar la nueva meta e indicador segun el caso 
     * Since April 6 ,2017
     * */

    $("#btnRegistrarNuevaMeta").button( ).click(function( e ){

        e.stopPropagation();
        e.preventDefault();
        var idProyecto = $("#idProyecto").val();
        var idIndicador = $("#idIndicador").val();
        var tipoIndicador = $('input:radio[name=tIndicador]:checked').val();
        var indicadorPlan = $("#indicadorPlan").val();
        var metaPlan = $("#metaPlan").val();
        var valorMeta = $("#valorMeta").val();
        var url='nuevaMeta.php';


            $('#metasNuevas').validate({

                rules:{
                    genre: {
                    required: true,
                    number: true
                    },
                    tIndicador: { required: true },
                    indicadorPlan: { required: true },
                    metaPlan : { required: true },
                    valorMeta: { required: true, number : true , min: 1 },
                },
                messages:{
                    tIndicador: { required:"<font bgcolor='#a94441'>Seleccione tipo de indicador</font" },
                    indicadorPlan : { required:"Ingrese el Indicador de la Meta" },
                    metaPlan : { required:"Ingrese la Meta Principal" },
                    valorMeta : { required:"Ingrese el valor de la meta" , number:"Ingrese un valor numerico" , min : "El alcance de la meta debe ser mayor a cero"},
                },
                errorPlacement: function(error, element) 
                {
                    if ( element.is(":radio") ) 
                    {
                        error.appendTo( element.parents('.contenedorRadio') );
                    }
                    else
                    { 
                        error.insertAfter( element );
                    }
                }
            });

            if($('#metasNuevas').valid()){

                $.ajax({
                        type:"POST",
                        url:url,
                        data:{ idProyecto : idProyecto , idIndicador : idIndicador , tipoIndicador : tipoIndicador , indicadorPlan : indicadorPlan , metaPlan : metaPlan , valorMeta : valorMeta },
                        success:function( data ){
                            if(data==1){
                                alert("Meta Principal Creada");
                                updateSelectLists();
                                $("#nuevaMetaPrincipal").dialog("close"); 

                            }
                        }
                });

            }

    });
    //fin 


    $("#btnCancelarNuevaMeta").click(function( e ){
            e.stopPropagation();
            e.preventDefault();
            $("#nuevaMetaPrincipal").dialog("close");

    } );


    $("#btnCerrarCambioAvances").click(function ( e ){
            e.stopPropagation();
            e.preventDefault();
            $( "#verEvidencias" ).dialog( "close" );

    });


    $("#btnGuardarCambioAvances").click(function ( e ){
        e.stopPropagation();
        e.preventDefault();

        $('#actualizaEvindecia').validate({

            rules:{
                    txtFileEvidencia: { required: true }
            },
            messages:{
                    txtFileEvidencia: { required:'Seleccione minimo una evidencia' }
            }

        });

        if($('#actualizaEvindecia').valid()){

            var inputFile = document.getElementById( "txtFileEvidencia" );
            var file = inputFile.files;
            var data = new FormData();
            var cuenta = "1";
            var fechas = $("#fechas").val( );
            var actividades = $("#actividades").val( );
            var vAvance = $("#vAvance").val( );
            var idMetaSecundaria = $("#idMetaSecundaria").val( );
            var permitidos = $("#permitidos").val( );
            var tamañoArchivos = 0;

            if ( inputFile != '' ) {

                var file = inputFile.files;

                for (i=0; i<file.length; i++ ) {
                        cuenta = cuenta+data.append('fileToUpload'+i,file[i]); //Añadimos cada archivo a el arreglo con un indice direfente
                }	
            } else {
                inputFile='1';
            }

            if( i > permitidos){
                            alert("Puede seleccionar maximo:"+permitidos+" evidencia(s)");

            }else {
                data.append( "permitidos" , permitidos );
                data.append( "cuenta", cuenta );
                data.append( "fechas" , fechas );
                data.append( "actividades" , actividades );
                data.append( "vAvance" , vAvance );
                data.append( "idMetaSecundaria" , idMetaSecundaria );
                data.append("tipoOperacion","submitActualizacion");

                $.ajax({//Ajax
                    type: "POST",
                    url: "../servicio/actuliazarEvindenciasArchivos.php",
                    contentType:false,
                    data: data ,
                    processData:false,
                    cache:false,
                    success: function( data ){

                        if( data == 1 ) { 
                                alert( "Evidencia actualizada" );
                                $( "#verEvidencias" ).dialog( "close" );

                        } else if ( data == -2){
                                alert("El archivo es demasiado pesado");

                        } else if ( data == -3 ){
                                alert("El tipo de archivo no es valido");

                        }else if( data == 0 ){
                                alert("Ha ocurrido un error");

                        }


                    }
                });



            }	

        }


    });

});