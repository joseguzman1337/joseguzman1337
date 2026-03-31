$(document).ready(function(){
    $("#save").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        save();
    });
    /*$("#adminForm").submit(function(e){
        e.preventDefault();
        e.stopPropagation();
        save();
    });/**/
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
            nombremenuopcion: {
                validators: {
                    notEmpty: {
                        message: 'El nombre del menú es requerido'
                    }
                }
            },
            clave: {
                linkAbsoluto: {
                    notEmpty: {
                        message: 'La URL absoluta es requerida, puede ser # en caso de que no lleve a ninguna página'
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
    var linkmenuopcion = $("#linkmenuopcion").val();
    if(linkmenuopcion.trim()==""){
        $("#linkmenuopcion").val($("#linkAbsoluto").val());
    }
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
                    $(".adm_menu").trigger("click"); 
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
    });/**/
}

