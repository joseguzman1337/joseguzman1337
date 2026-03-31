
$(document).ready(function () {
    $('#modalidad').change(function () {
        var modalidad = $(this).val();
        if (modalidad == 0) {
            alert('seleccione una modalidad antes de continuar');
        } else {
            cargar_facultad(modalidad);
            if (modalidad == 200) {
                $('#facultad').removeAttr('disabled');
                $('#programa').attr('disabled', 'true');
                $('#Div_Programa').removeAttr('style');
            }
            if (modalidad == 300) {
                $('#Div_Programa').css('display', 'none');
                $('#programa').removeAttr('disabled');
            }
            if (modalidad != 200 && modalidad != 300) {
                $('#Div_Programa').css('display', 'none');
                $('#programa').removeAttr('disabled');
            }
        }
    });

    $("#facultad").change(function () {
        var facultad_id;
        var periodo;
        var modalidad;
        facultad_id = $(this).val();
        periodo = $('#periodo').val();
        modalidad = $('#modalidad').val();
        if (facultad_id == 0) {
            alert('seleccione una facultad antes de continuar');
            $('#programa').attr('disabled', 'disabled');
        } else {
            cargar_programa_academico(facultad_id, periodo, modalidad);
            $('#programa').removeAttr('disabled');
        }
    });
});


function cargar_facultad(modalidad) {
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        async: false,
        dataType: 'json',
        data: ({actionID: 'carga_facultad',
            modalidad: modalidad
        }),
        error: function (objeto, quepaso, otroobj) {
            alert('Error de Conexión , Favor Vuelva a Intentar');
        },
        success: function (data) {
            if (data.val == 'FALSE') {
                alert(data.descrip);
                return false;
            } else {
                if (data.modalidad == 200) {
                    $('#facultad').html(data.option);
                } else {
                    $('#programa').html(data.option);
                }
            }
        }
    });
}

/* CARGAR PROGRAMA ACADEMICO */
function cargar_programa_academico(facultad_id, periodo_id, modalidad) {
    $.ajax({
        type: 'POST',
        url: 'peticiones_ajax.php',
        data: ({actionID: 'cargar_programa_academico', facultad_id: facultad_id, periodo_id: periodo_id, modalidad: modalidad}),
        error: function (objeto, quepaso, otroobj) {
            alert('Error de Conexión , Favor Vuelva a Intentar');
        },
        success: function (data) {
            $('#programa').html('');
            $('#programa').html(data);
        }
    });
}

/* ANTERIORES */

function validar() {
    /****************************/
    /*
     * Agregar, modificar y quitar algunas validaciones para el registro de correo
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Dirección de Tecnología.
     * Modificado 10 de abril de 2016.
     */
    if (!$.trim($('#nombres').val())) {
        alert('Digite un Nombre...');
        $("#nombres").focus();
        return false;
    }

    nombre = $('#nombres').val();
    if (soloLetras(nombre) == '1') {
        alert("El nombre digitado contiene caracteres invalidos");
        $("#nombres").focus();
        return false;
    }
    if (!$.trim($('#apellidos').val())) {
        alert('Digite un Apellido...');
        $("#apellidos").focus();
        return false;
    }

    apellido = $('#apellidos').val();
    if (soloLetras(apellido) == '1') {
        alert("El apellido digitado contiene caracteres invalidos");
        $("#nombres").focus();
        return false;
    }

    if ($("#correo").val().indexOf('@', 0) == -1 || $("#correo").val().indexOf('.', 0) == -1) {
        alert('Digite un correo a registrar valido...');
        $("#correo").focus();
        return false;
    }


    contactarNombre = $("#contactar").val();
    contactarNombreL = $.trim(contactarNombre);
    if (contactarNombreL == '') {
        alert('Digite el Nombre del Contacto...');
        $("#contactar").focus();
        return false;
    }
    if (soloLetras(contactarNombreL) == '1') {
        alert("El nombre del contacto digitado contiene caracteres invalidos");
        $("#contactar").focus();
        return false;
    }

    contactarApellido = $("#contactarA").val();
    contactarApellidoL = $.trim(contactarApellido);
    if (contactarApellidoL == '') {
        alert('Digite el Apellido del Contacto...');
        $("#contactarA").focus();
        return false;
    }
    if (soloLetras(contactarApellidoL) == '1') {
        alert("El apellido del contacto digitado contiene caracteres invalidos");
        $("#contactarA").focus();
        return false;
    }

    if ($("#area").val() == '') {
        alert('Digite un area a contactar valida...');
        $("#area").focus();
        return false;
    }
    if (soloLetras($("#area").val()) == '1') {
        alert("El area digitada contiene caracteres invalidos... Favor verificar.");
        $("#area").focus();
        return false;
    }
    
    if (soloLetras($("#dependencia").val()) == '1') {
        alert("La facultad y/o dependencia digitada contiene caracteres invalidos");
        $("#dependencia").focus();
        return false;
    }
    
    asunto = $("#asunto").val();
    asuntoL = $.trim(asunto);
    if (asuntoL == '') {
        alert('Digite el Motivo del Contacto...');
        $("#asunto").focus();
        return false;
    }
    if (soloLetras(asuntoL) == '1') {
        alert("El asunto digitado contiene caracteres invalidos");
        $("#asunto").focus();
        return false;
    }

    if ($("#correoelec").val().indexOf('@', 0) == -1 || $("#correoelec").val().indexOf('.', 0) == -1) {
        alert('Digite un correo a contactar valido...');
        $("#correoelec").focus();
        return false;
    }
    
    if ($("#telefono").val()!='') {
        if (alfanumerico($("#telefono").val()) == '2') {
            alert("El telefono o extension digitada contiene caracteres invalidos");
            $("#telefono").focus();
            return false;
        }
    }

    if (!$.trim($('#captcha').val())) {
        alert('Digite El Codigo Que Aprece en la Imagen...');
        $("#captcha").focus();
        return false;
    }
//    end
    /****************************/

}

function isNumberKey(evt) {

    var e = evt;
    var charCode = (e.which) ? e.which : e.keyCode
    console.log(charCode);

    //el comentado me acepta negativos
    //if ( (charCode > 31 && (charCode < 48 || charCode > 57)) ||  charCode == 109 || charCode == 173 )
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        //si no es - ni borrar
        if ((charCode != 8 && charCode != 45)) {
            return false;
        }
    }

    return true;

}
/* funciones varias*/

function validarEmail(email) {
    expr = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    if (!expr.test(email))
        alert("Error: La dirección de correo " + email + " es incorrecta.");
}
function soloLetras(e) {
    /*
     * Caso 94006.
     * @modified Luis Dario Gualteros 
     * <castroluisd@unbosque.edu.co>
     * Se modifica la expresión regular para que permita el ingreso de caracteres especiales.
     * @since Septiembre 18 de 2017
    */
    var filter6 = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ\s.,]*$/;
    // End Caso 94006.
    if (!filter6.test(e.replace(/\s/g, ''))) {
        return 1;
    }

}

function alfanumerico(val) {
    var regex = /^[0-9A-Za-z]+$/;
    /*
     * Agregar val.replace(val.replace(/\s/g, '')) a esta funcion
     * Vega Gabriel <vegagabriel@unbosque.edu.do>.
     * Universidad el Bosque - Dirección de Tecnología.
     * Modificado 7 de abril de 2016.
     */
    if (regex.test(val.replace(/\s/g, ''))) {
        //end
        return true;
    } else {
        return 2;
    }
}
function validarFechaMayorActual(date)
{
    var date2 = new Date();
    var today = date2.toLocaleFormat('%Y-%m-%d');

    if (date >= today)
    {
        return true;
    } else
    {
        return false;
    }
}


