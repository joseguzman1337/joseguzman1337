// FORM VALIDATION FEEDBACK ICONS
// =================================================================
var faIcon = {
        valid: 'fa fa-check-circle fa-lg text-success',
        invalid: 'fa fa-times-circle fa-lg',
        validating: 'fa fa-refresh'
}
var allowSave = false;

$(document).ready(function(){    
    $("#crearEditarOportunidad").submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        $("#save").removeAttr("disabled");
        if (allowSave){
            save();
        }
        return false;
    });
    
    $("#idsiq_estructuradocumento").change(function(){
        actualizarFactores(this);
    });    
    
    // FORM VALIDATION
    // =================================================================
    $('#crearEditarOportunidad').bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: faIcon,
        fields: {
            nombre: {
                validators: {
                    notEmpty: {
                        message: 'El nombre de la oportunidad es requerido'
                    }
                }
            },
            idsiq_estructuradocumento: {
                validators: {
                    notEmpty: {
                        message: 'El documento de acreditación es requerido'
                    },
                    greaterThan: {
                            inclusive:false,
                            value: 0,
                            message: 'El documento de acreditación es requerido'
                    }
                    
                }
            },
            idsiq_factorestructuradocumento: {
                validators: {
                    notEmpty: {
                        message: 'El factor es requerido'
                    },
                    greaterThan: {
                            inclusive:false,
                            value: 0,
                            message: 'El factor es requerido'
                    }
                }
            },
            idsiq_tipooportunidad: {
                validators: {
                    notEmpty: {
                        message: 'El tipo de oportunidad es requerido'
                    },
                    greaterThan: {
                            inclusive:false,
                            value: 0,
                            message: 'El tipo de oportunidad es requerido'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e, data) {
        allowSave = true;
    }).on('error.form.bv', function(e, data) {
        allowSave = false;
    });
});

function save(){
    if (allowSave){
        var datos = $('#crearEditarOportunidad').serializeArray();
        $.ajax({
            url: HTTP_GESTION+'/index.php',
            type: "POST",
            dataType: "json",
            data: datos,
            success: function( data ){
                bootbox.hideAll();
                if(data.s){
                    contentHTML = alertContent.replace("fa-icon", dataAlert[2].icon);
                    contentHTML = contentHTML.replace('<span class="text-2x"></span>', '<span class="text-2x">'+data.msj+'</span>');
                    showAlert(dataAlert[2].type,contentHTML,true);

                    window.setTimeout(function() {
                        location.reload();
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
}

function actualizarFactores(obj){
    $.ajax({
        url: HTTP_GESTION+'/index.php',
        type: "GET",
        dataType: "json",
        data: {
            option:'default',
            task:'actualizarFactores',
            id:$(obj).val()
        },
        success: function( data ){
            if(data.s){
                $('#idsiq_factorestructuradocumento').find('option').remove();
                $('#idsiq_factorestructuradocumento').append(data.valores);
                $('#idsiq_factorestructuradocumento').trigger("chosen:updated");
                $('#idsiq_factorestructuradocumento').trigger('change');
            }
        }
    });
}