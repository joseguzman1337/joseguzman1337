$(document).ready(function(){
    var url = HTTP_SITE+'/index.php?option=moduloActividadesBienestar&tmpl=json';
    $('#image').fileupload({
        url: url,
        dataType: 'json',
        add: function (e, data) {
            var btnSave = '<button class="btn btn-success btn-labeled fa fa-floppy-o" id="guardar2"  type="button">Guardar</button>';
            var image=$("#image").val();
            var res = image.split("\\");
            $("#imagen").val(HTTP_SITE+'/uploads/moduloActividadesbienestar/'+res[2]);
            $("#seccionEnviar").html(btnSave);
            data.context = $("#task").val("subirArchivo");
            data.context = $("#guardar2").click(function () {
                data.submit();
                data.context = $("#task").val("save");
                save();
            });
        }
    });
//    $('#horaInicio').on('change', function() {
//        if(this.value>$('#horaFin').val()){
//            $('#horaFin').val(this.value);
//        }  
//    });    
//    $('#horaFin').on('change', function() {
//        if(this.value<$('#horaInicio').val()){
//            $('#horaInicio').val(this.value);
//        }  
//    });    
    $("#guardar1").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        save();
    });/**/
    
    // FORM VALIDATION FEEDBACK ICONS
    // =================================================================
    var faIcon = {
//            valid: 'fa fa-check-circle fa-lg text-success',
//            invalid: 'fa fa-times-circle fa-lg',
//            validating: 'fa fa-refresh'
    valid: 'glyphicon glyphicon-ok',
    invalid: 'glyphicon glyphicon-remove',
    validating: 'glyphicon glyphicon-refresh'
    }
    
    // FORM VALIDATION
    // =================================================================
    $('#adminForm').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'El nombre de la actividad es requerido'
                    }
                }
            },
            descripcion: {
                validators: {
                    notEmpty: {
                        message: 'La descripcion es requerida'
                    }
                }
            },
            fechaLimite: {
                validators: {
                    notEmpty: {
                        message: 'La Fecha Limite es requerida'
                    }
                }
            },
            cupo: {
                validators: {
                    notEmpty: {
                        message: 'El cupo es requerido'
                    }
                }
            },
            emailResponsable: {
                validators: {
                    notEmpty: {
                        message: 'El correo es requerido'
                    },
                    regexp: {
                        regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                        message: 'Direccion de correo electronico invalida'
                    }
                }
            },
            horaInicio: {
                validators: {
                    notEmpty: {
                        message: 'La Hora Inicio es requerida'
                    }
                }
            },
            horaFin: {
                validators: {
                    notEmpty: {
                        message: 'La Hora Fin es requerida'
                    }
                }
            },
            codigoEstado: {
                validators: {
                    notEmpty: {
                        message: 'El estado es requerido'
                    }
                }
            }
        }
    }).on('status.field.bv', function(e, data) {
        var $form     = $(e.target),
        validator = data.bv; 
    });
    
//    se agrega parametro 'date' para evitar usar fechas pasadas
    var date = new Date();
    date.setDate(date.getDate());
    $('.input-group.date').datepicker({        
        startDate: date,
        autoclose:true,
        todayBtn: "linked",
        format: "yyyy-mm-dd"
    });
     
    $('#horaInicio').timepicker({
        showMeridian: false,
        showInputs: false,
        disableFocus: true 
    });
    $('#horaFin').timepicker({
        showMeridian: false,
        showInputs: false,
        disableFocus: true 
    });
    
});

function save(){
    var datos = $('#adminForm').serializeArray();
    $.ajax({
        url: HTTP_SITE+'/index.php',
        type: "GET",
        dataType: "json",
        data: datos,
        success: function( data ){
            bootbox.hideAll();
            if(data.s){
                contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                showAlert(dataAlert[2].type,contentHTML,true);
                
                window.setTimeout(function() {
//                    $.ajax({
//                        url: HTTP_SITE+'/index.php',
//                        type: "GET",
//                        dataType: "html",
//                        data: {
//                            option: 'moduloNotificacionesApp',
//                            tmpl: 'json'
//                        },
//                        success: function( data ){
//                            //alert(data);
//                            $("#tablaDados").html(data);
//                        }
//                    });
                }, 1500);
            }else{
                contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
                contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                showAlert(dataAlert[4].type,contentHTML,true);
            }
        },
        error: function (xhr, ajaxOptions, thrownError) {
            contentHTML = alertContent.replace("fa-icon", dataAlert[4].icon);
            contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">El servidor no responde</span>');
            showAlert(dataAlert[4].type,contentHTML,true);
        }
    });
}
