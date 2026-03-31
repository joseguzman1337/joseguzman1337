$(document).ready(function(){ 
    $("#save").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        save();
    });
    // FORM VALIDATION FEEDBACK ICONS
    // =================================================================
    var faIcon = {
            valid: 'fa fa-check-circle fa-lg text-success',
            invalid: 'fa fa-times-circle fa-lg',
            validating: 'fa fa-refresh'
    }
    
    // FORM VALIDATION
    // =================================================================
    $('#adminForm').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
            url: {
                validators: {
                    notEmpty: {
                        message: 'la Url es requerida'
                    }
                }
            },
            tipo: {
                validators: {
                    notEmpty: {
                        message: 'El tipo de Url es requerido'
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
//                            option: 'moduloActividadesBienestar',
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

