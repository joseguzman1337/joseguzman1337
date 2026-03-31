/**
 * @created Vega Gabriel <vegagabriel@unbosque.edu.do>.
 * Se hacen validaciones
 * @sinceSeptiembre 13, 2019
 */

var date = new Date();
// GET YYYY, MM AND DD FROM THE DATE OBJECT
var yyyy = date.getFullYear().toString();
var mm = (date.getMonth() + 1).toString();
var dd = date.getDate().toString();
// CONVERT mm AND dd INTO chars
var mmChars = mm.split('');
var ddChars = dd.split('');
// CONCAT THE STRINGS IN YYYY-MM-DD FORMAT
var datestring = yyyy + '-' + (mmChars[1] ? mm : "0" + mmChars[0]) + '-' + (ddChars[1] ? dd : "0" + ddChars[0]);
var pasado = parseInt(yyyy) - 13;
var fechapasada = pasado + '-12-31';

$(document).ready(function () {
    jQuery.validator.addMethod("emailvalido", function (value, element) {
        return this.optional(element) || /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i.test(value);
    }, "E-Mail Valido");
    jQuery.validator.addMethod("check", function (value) {
        var result = true;
        if (!$('#politica').is(':checked')) {
            result = false;
        }
        return result;
    }, "Invalido");
    jQuery.validator.setDefaults({
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        }
    });
    ciudad();
    $("#Enviar").click(function () {
        $("#egresados").validate({
            rules: {
                documento: {required: true, minlength: 7, maxlength: 15},
                fechaDocumento: {required: true},
                apellidos: {required: true, maxlength: 50},
                nombres: {required: true, maxlength: 50},
                ciudad: {required: true},
                correo: {required: true, email: true, emailvalido: true, maxlength: 100},
                celular: {required: true, minlength: 10, maxlength: 15},
                direccion: {required: true},

                politica: {check: true}
            },
            messages: {
                documento: {
                    required: "Debe Ingresar el Documento de identidad",
                    minlength: "Minimo 7 digitos",
                    maxlength: "Maximo 15 digitos"
                },
                fechaDocumento: {required: "Debe ingresar Fecha Expedicion"},
                apellidos: {required: "Debe ingresar Apellidos", maxlength: "Maximo 50 caracteres"},
                nombres: {required: "Debe ingresar Nombres", maxlength: "Maximo 50 caracteres"},
                ciudad: {required: "Debe seleccionar Ciudad donde reside"},
                correo: {required: "Debe Ingresar E-Mail", email: "E-Mail debe ser valido", maxlength: "Maximo 100 caracteres"},
                celular: {required: "Debe ingresar Celular", minlength: "Minimo 10 digitos", maxlength: "Maximo 15 digitos"},
                telefono: {required: "Debe ingresar Telefono", minlength: "Minimo 7 digitos", maxlength: "Maximo 15 digitos"},
                direccion: {required: "Debe ingresar Celular"},

                politica: {check: "?"}
            }

        });

        if ($('#egresados').valid()) {
            modal();
            var documento = $('#documento').val();
            var fechadocu = $('#fechaDocumento').val();
            var apellidos = $('#apellidos').val();
            var nombres = $('#nombres').val();
            var ciudad = $('#ciudad').val();
            var correo = $('#correo').val();
            var celular = $('#celular').val();
            var telefono = $('#telefono').val();
            var direccion = $('#direccion').val();
            var encuentra_laborando = $('input:radio[name=encuentra_laborando]:checked').val();
            var usted_es = $('input:radio[name=usted_es]:checked').val();
            var entidaddondetrabaja = $('#entidaddondetrabaja').val();
            var cargoempleo = $('#cargoempleo').val();
            // var sector_empresa = $('input:radio[name=sector_empresa]:checked').val();
            var nivelcoincidencia = $('input:radio[name=nivelcoincidencia]:checked').val();
            var tipocontrato = $('input:radio[name=tipocontrato]:checked').val();
            var ingresosalarial = $('input:radio[name=ingresosalarial]:checked').val();
            var tienecarnet = $('input:radio[name=tienecarnet]:checked').val();
            var politica = $('#politica').val();
            $.ajax({
                type: 'POST',
                url: 'funcionesEgresados.php',
                dataType: "html",
                data: {
                    documento: documento,
                    fechadocu: fechadocu,
                    apellidos: apellidos,
                    nombres: nombres,
                    ciudad: ciudad,
                    correo: correo,
                    celular: celular,
                    telefono: telefono,
                    direccion: direccion,
                    encuentra_laborando: encuentra_laborando,
                    usted_es: usted_es,
                    entidaddondetrabaja: entidaddondetrabaja,
                    cargoempleo: cargoempleo,
                    nivelcoincidencia: nivelcoincidencia,
                    tipocontrato: tipocontrato,
                    ingresosalarial: ingresosalarial,
                    tienecarnet: tienecarnet,
                    politica: politica,
                    action: "Validar"
                },
                beforeSend: function () {
                },
                success: function (data) {
                    modal('hide');
                    var text = "";
                    var icon = "";
                    switch (data) {
                        case "1":
                            text += "No se encontró registrado como EGRESADO en el sistema. Gracias.";
                            icon += "warning";
                            break;
                        case "2":
                            text += "No se pudo realizar la actualización de la información. Por favor contáctese con la universidad para recibir ayuda en este proceso. Gracias.";
                            icon += "warning";
                            break;
                        case "3":
                            text += "La información ha sido actualizada correctamente. Gracias por contactarse con nosotros.";
                            icon += "success";
                            break;
                    }
                    setTimeout(function () {
                        swal({
                            title: "Estimado usuario!",
                            text: text,
                            icon: icon,
                            confirmButtonText: "OK"
                        });
                    }, 1000);
                },
                error: function (data, error)
                {
                    alert("Error en la consulta de los datos.");
                }
            });
        }
    });
    $(function () {
        $(document).on("cut copy paste", "#politica", function (e) {
            e.preventDefault();
        });
    });
});

function ciudad() {
    $.ajax({
        type: 'POST',
        url: 'funcionesEgresados.php',
        datatype: "html",
        data: {action: "consultaCiudad"},
        success: function (data) {
            $('#ciudad').html(data);
        },
        error: function (data, error) {
            alert("Error en la consulta de los datos de ciudad");
        }
    });
}

function val_texto(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8)
        return true;
    patron = /[a-zA-ZñÑ\s]+$/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}

function val_numero(e) {
    tecla = (document.all) ? e.keyCode : e.which;
    if (tecla == 8)
        return true;
    patron = /[0-9]+$/;
    te = String.fromCharCode(tecla);
    return patron.test(te);
}
function val_numero_documento(e) {
    var tip = $('#tipodoc').val();
    switch (tip) {
        case '05':
            //para que se pueda ingresar el pasaporte se deja vacio este case
            break;
        default:
            tecla = (document.all) ? e.keyCode : e.which;
            if (tecla == 8)
                return true;
            patron = /[0-9]+$/;
            te = String.fromCharCode(tecla);
            return patron.test(te);
            break;
    }
}