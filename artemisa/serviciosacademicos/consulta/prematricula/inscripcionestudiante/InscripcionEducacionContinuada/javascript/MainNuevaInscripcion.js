
$(function () {
    $(".txtNumeroDocumento").focusout(function () {
        var Tipocurso = $('#Tipocurso').val();
        var Curso = $('#Curso').val();
        var codigoperiodo = $('#codigoperiodo').val();
        var txtNumeroDocumento = $(this).val( );
        if ($.trim(txtNumeroDocumento)) {
            $.ajax({
                url: "../servicio/contacto.php",
                type: "POST",
                dataType: 'json',
                data: ({tipoOperacion: 'validacion', txtNumeroDocumento: txtNumeroDocumento, Tipocurso: Tipocurso, Curso: Curso, codigoperiodo: codigoperiodo}),
                success: function (data) {
                    if (data.val == 1) {
                        alert(data.msj);
                        return false;
                    } else {

                        if (data.val != 0)
                        {
                            /*****************************************************************/
                            $.ajax({
                                url: "../servicio/contacto.php",
                                type: "POST",
                                data: {tipoOperacion: 'buscar', txtNumeroDocumento: txtNumeroDocumento},
                                success: function (data)
                                {
                                    if (data.length > 0) {
                                        $('#NumeroDocumento').attr('readonly', true);
                                        llenarFormulario(data);
                                        $("#btnActualizaInscripcion").css("display", "block");
                                        $("#btnNuevaInscripcion").css("display", "none");

                                    } else {
                                        $("#InscripcionEducacion").reset();
                                        $("#btnNuevaInscripcion").css("display", "block");
                                        $("#btnActualizaInscripcion").css("display", "none");
                                    }
                                }
                            });
                            /*****************************************************************/

                        } else
                        {
                            $("#btnNuevaInscripcion").css("display", "block");
                            $("#btnActualizaInscripcion").css("display", "none");
                        }

                    }
                }
            });
        } else {
            $('#NumeroDocumento').effect("pulsate", {times: 3}, 500);
            $('#NumeroDocumento').css('border-color', '#F00');
            return false;
        }

    });

    $("#btnNuevaInscripcion").click(function (e) {
        e.stopPropagation();
        e.preventDefault();
        var valida = Validacion();
        if (valida['1'] == true)
        {
            $('#OrdenesVer').show();
            var txtNumeroDocumento = $("#NumeroDocumento").val();
            var tipoOperacion = "crearContacto";
            $('#distraer').html('<img id="loading" style="display: inline-block; margin-left: 16.4%;margin-right:10px" src="../../../../../educacionContinuada/images/ajax-loader2.gif">Realizando Inscripci\u00f3n');
            $("#btnNuevaInscripcion").css('display', 'none');

            caracteres =
                    [
                        '!', '"', '#', '$', '%', '&', ' ', '(', ')', '*', '+', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', '\\', ']', '^', '_', '`', '{', '|', '}', '~', 'Ç', 'ü', 'é', 'â', 'ä', 'à', 'å', 'ç', 'ê', 'ë', 'è', 'ï', 'î', 'ì', 'Ä', 'Å', 'É', 'æ', 'Æ', 'ô', 'ö', 'ò', 'û', 'ù', 'ÿ', 'Ö', 'Ü', 'ø', '£', 'Ø', 'á', 'í', 'ó', 'ú', 'ñ', 'Ñ', 'ª', 'º', '¿', '®', '¬', '½', '¼', '¡', '«', '»', '│', '┤', 'Á', 'Â', 'À', '©', '╣', '║', '╗', '╝', '¢', '¥', '┐', '└', '┴', '┬', '├', '─', '┼', 'ã', 'Ã', '╚', '╔', '╩', '╦', '╠', '═', '╬', '¤', 'ð', 'Ð', 'Ê', 'Ë', 'È', 'ı', 'Í', 'Î', 'Ï', '┘', '┌', 'Ó', 'ß', 'Ô', 'Ò', 'õ', 'Õ', 'µ', 'þ', 'Þ', 'Ú', 'Û', 'Ù', 'ý', 'Ý', '¯', '´', '­', '±', '‗', '¾', '¶', '§', '÷', '¸', '°', '¨', '·', '¹', '³', '²'
                    ];
            for (i = 0; i < caracteres.length; i++)
            {
                if (txtNumeroDocumento.indexOf(caracteres[i]) != -1)
                {
                    alert('el numero de documento no debe contener caracteres especiales:' + i);
                    return false;
                }
            }
            $.ajax({
                url: "../servicio/contacto.php",
                type: "POST",
                dataType: 'json',
                data: $("#InscripcionEducacion").serialize( ) + '&txtNumeroDocumento=' + txtNumeroDocumento + '&tipoOperacion=' + tipoOperacion,
                success: function (data) {
                    if (data.val == 1) {
                        alert(data.msj);
                        if (data.val == 1) {
                            return false;
                        }

                    } else {
                        alert(data.msj);
                        if (data.val != 3) {
                            VerOrdenes(data.codigoestudiante, data.codigoperiodo);
                            EnviarCorreo(data.codigoestudiante);
                        }
                        $('#distraer').html('');
                    }
                }
            });
        } else
        {
            alert(valida['0']);
            return false;
        }

    });

    $("#btnActualizaInscripcion").click(function (e) {

        e.stopPropagation();
        e.preventDefault();
        var valida = Validacion();
        if (valida['1'] == true)
        {
            $('#OrdenesVer').show();
            var txtIdEstudiante = $("#txtIdEstudiante").val();
            var tipoOperacion = "actualizarContacto";
            var txtNumeroDocumento = $("#NumeroDocumento").val();

            $("#btnActualizaInscripcion").css('display', 'none');

            var formulario = $("#InscripcionEducacion").serialize( );
            formulario = formulario + '&txtIdEstudiante=' + txtIdEstudiante + '&tipoOperacion=' + tipoOperacion + '&txtNumeroDocumento=' + txtNumeroDocumento;

            $.ajax({
                url: "../servicio/contacto.php",
                type: "POST",
                dataType: 'json',
                data: formulario,
                success: function (data) {
                    if (data.val == 1) {
                        alert(data.msj);
                        return false;
                    } else {
                        alert(data.msj);
                        if (data.val != 3) {
                            VerOrdenes(data.codigoestudiante, data.codigoperiodo);
                            EnviarCorreo(data.codigoestudiante);
                        }
                    }
                }
            });
        } else
        {
            alert(valida['0']);
            return false;
        }

    });

});


jQuery.fn.reset = function () {
    $(this).each(function () {
        this.reset();
    });
};

function VerOrdenes(codigoestudiante, codigoperiodo)
{
    $.ajax({
        url: "../servicio/contacto.php",
        type: "POST",
        dataType: 'html',
        data: ({tipoOperacion: 'VerOrdenes', codigoestudiante: codigoestudiante, codigoperiodo: codigoperiodo}),
        success: function (data) {
            $('#OrdenesVer').html(data);
        }
    });
}

function EnviarCorreo(codigoestudiante) {
    $.ajax({
        url: "../../../../../educacionContinuada/enviarCorreoOrdenPago.php",
        type: "POST",
        dataType: 'json',
        data: ({codigoestudiante: codigoestudiante, tipoOperacionCorreo: 1}),
        success: function (data) {
            alert(data.msj);
        }
    });
}


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

var pasado = parseInt(yyyy) - 17;

var fechapasada = pasado + '-12-31';

function Validacion()
{
    var NumeroDocumento = $('#NumeroDocumento').val();
    var TipoDocumento = $('#TipoDocumento').val();//select
    var NombreInscripto = $('#NombreInscripto').val();
    var ApellidoInscripto = $('#ApellidoInscripto').val();
    var FechaNaci = $('#FechaNaci').val();
    var Genero = $('#Genero').val();//select    
    var Email = $('#Email').val();
    var Celular = $('#Celular').val();

    var aprobacion = $('#aprobacion').prop('checked');

    var resultado = new Array();

    if (aprobacion == false)
    {
        resultado['0'] = 'verifique la aprobacion de terminos y condiciones';
        resultado['1'] = false;
        return resultado;
    }
    if (!$.trim($('#captcha').val()))
    {
        resultado['0'] = 'Complete la informacion del codigo de seguridad';
        resultado['1'] = false;
        return resultado;
    }

    if (!$.trim(NumeroDocumento)) {
        resultado['0'] = 'Verifique el numero de documento';
        resultado['1'] = false;
        return resultado;
    }
    if (TipoDocumento == -1 || TipoDocumento == '-1') {
        resultado['0'] = 'Por favor seleccione el tipo de documento';
        resultado['1'] = false;
        return resultado;
    }
    if (!$.trim(NombreInscripto)) {
        resultado['0'] = 'Por favor digite el nombre';
        resultado['1'] = false;
        return resultado;
    }

    if (!$.trim(ApellidoInscripto)) {
        resultado['0'] = 'Por favor digite el apellido';
        resultado['1'] = false;
        return resultado;
    }

    if (!$.trim(FechaNaci)) {
        resultado['0'] = 'Seleccione una fecha de nacimiento valida';
        resultado['1'] = false;
        return resultado;
    } else if (FechaNaci > fechapasada) {
        resultado['0'] = 'Fecha de nacimiento debe ser mayor de 16 años';
        resultado['1'] = false;
        return resultado;
    }

    if (Genero == -1 || Genero == '-1') {
        resultado['0'] = 'Seleccione un genero';
        resultado['1'] = false;
        return resultado;
    }
    if (!$.trim(Email)) {
        resultado['0'] = 'Digite el email personal';
        resultado['1'] = false;
        return resultado;
    }
    if (!$.trim(Celular)) {
        resultado['0'] = 'Digite un numero de celular';
        resultado['1'] = false;
        return resultado;
    }
    resultado['1'] = true;
    return resultado;
}