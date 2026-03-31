$(document).ready(function(){ 
    $("#save").click(function(e){
        e.stopPropagation();
        e.preventDefault();
        save();
    });
    
    if(!$('#id').val()){
    if($('#estado').val('Pendiente')){
            $('#codigoEstado').val(100);
        }
        }
    $('#estado').on('change', function() {
        if(this.value=='Pendiente'){
            $('#codigoEstado').val(100);
        }else if(this.value=='Anulado'){
            $('#codigoEstado').val(200);            
        }  
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
            texto: {
                validators: {
                    notEmpty: {
                        message: 'El texto es requerido'
                    }
                }
            },
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'La Fecha es requerida'
                    }
                }
            },
            codigoEstado: {
                validators: {
                    notEmpty: {
                        message: 'El estado es requerido'
                    }
                }
            },
            estado: {
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
               
//    se agrega parametro date para evitar usar fechas pasadas
    var date = new Date();
    date.setDate(date.getDate());
    $('#demo-dp-component, .input-group.date').datepicker({       
        startDate: date,
        autoclose:true,
        todayBtn: "linked",
        format: "yyyy-mm-dd"
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

