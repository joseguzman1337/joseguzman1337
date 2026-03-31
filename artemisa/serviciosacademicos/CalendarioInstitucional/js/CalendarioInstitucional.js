$(document).ready(function () {
    $("#fecha_1").datepicker({
        changeMonth: true,
        changeYear: true,
        showOn: "button",
        buttonImage: "../../css/themes/smoothness/images/calendar.gif",
        buttonImageOnly: true,
        dateFormat: "yy-mm-dd",
        showOtherMonths: true,
        selectOtherMonths: true,
        minDate: new Date(),
        language:'es'
    });
    $("#fecha_2").datepicker({
        changeMonth: true,
        changeYear: true,
        showOn: "button",
        buttonImage: "../../css/themes/smoothness/images/calendar.gif",
        buttonImageOnly: true,
        dateFormat: "yy-mm-dd",
        showOtherMonths: true,
        selectOtherMonths: true,
        minDate: new Date()
    });

     $('#hora_1').datetimepicker({
            datepicker:false,
            format:'H:i',
            step:30

    });
    $('#hora_2').datetimepicker({
            datepicker:false,
            format:'H:i',
            step:30
    });
    $('#ui-datepicker-div').css('display', 'none');

    $('#nameEvento').click(
        function(){
            $('#nameEvento').val('');
        }
    );
    $('#lugar').click(
        function(){
            $('#lugar').val('');
        }
    );

    $('#SaveInfo').click(
        function(){
            var confirmar = 'Desea Guardar o Registrar el Evento...?';

            if(confirm(confirmar)){
                var validado = validardatos();
                if(validado){
                    $('.butonView').css('display','none');
                    SaveEventoCalendario();
                }
            }//if
        }//function
    );

    $('#Salir').click(
        function(){
            var confirmar = 'Desea Salir...?';

            if(confirm(confirmar)){
                $('.butonView').css('display','none');
                location.href='../Controller/CalendarioInstitucional_html.php';
            }//if
        }//function
    );

    $('#UpdateInfo').click(
        function(){
            var confirmar = 'Desea Modificar el Evento...?';

            if(confirm(confirmar)){
                $('.butonView').css('display','none');
                var validado = validardatos();
                if(validado){
                    EditEventoCalendario();
                }
            }//if
        }//function
    );
    $('#Nuevo').click(
        function(){
            var confirmar = 'Desea Crear un Nuevo Evento...?';

            if(confirm(confirmar)){
                DisplayCreate();
            }//if
        }//function
    );
    /**************************************/
    $(".messages").hide();
        //queremos que esta variable sea global
        var fileExtension = "";
        //función que observa los cambios del campo file y obtiene información
        $(':file').change(function()
        {
            //obtenemos un array con los datos del archivo
            var file = $("#imagenEvento")[0].files[0];
            //obtenemos el nombre del archivo
            var fileName = file.name;
            //obtenemos la extensión del archivo
            fileExtension = fileName.substring(fileName.lastIndexOf('.') + 1);
            //obtenemos el tamaño del archivo
            var fileSize = file.size/1024;

            //obtenemos el tipo de archivo image/png ejemplo
            var fileType = file.type;
            //mensaje con la información del archivo
            showMessage("<span class='info'>Archivo para subir: "+fileName+", peso total: "+fileSize+" KB.</span>");
        });
        var areaSeleccionada = $("#areaSeleccionada").val();
        if(areaSeleccionada != ''){
            $('#area').find('option').each(function() {
                if($(this).val() == areaSeleccionada) {
                    $(this).prop("selected", true);
                }
            });
        }
        $("#areaSeleccionada").val('');
});

function formatNumber (num) {
    return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
 function validardatos(){
     /*if(ValidaBoxText('nameEvento') && ValidaBoxText('lugar')  && ValidaBoxText('area')  && ValidaBoxText('fecha_1') && ValidaBoxText('fecha_2')   &&  ValidaBoxText('hora_1')   &&  ValidaBoxText('hora_2')  &&  ValidaBoxText('Observacion') ){*/
         return true;
     /*}*/
 }//function validardatos
function ValidaBoxText(name) {
    if (!$.trim($('#' + name).val())) {
        /************************************/
        $('#' + name).effect("pulsate", {
            times: 3
        }, 500);
        $('#' + name).css('border-color', '#F00');
        return false;
        /************************************/
    }else{
          $('#' + name).css('border-color', '');
    }
    var texto = $('#' + name).val();
    var num = texto.length;

    if (num < 3) {
        /************************************/
        alert('Debe escribir una plabra con m\xE1s de 3 letras');
        $('#' + name).effect("pulsate", {
            times: 3
        }, 500);
        $('#' + name).css('border-color', '#F00');
        return false;
        /************************************/
    }else{
          $('#' + name).css('border-color', '');
    }
    return true;
} //function ValidaBoxText
function DisplayCreate(){
    $.ajax({ //Ajax
            type: 'POST',
            url: '../Controller/CalendarioInstitucional_html.php',
            async: false,
            dataType: 'html',
            data:({action_ID: 'Inicio'}),
            error: function (objeto, quepaso, otroobj) {
                alert('Error de Conexi?n , Favor Vuelva a Intentar');
            },
            success: function (data) {
                    $('#PrincipalView').html(data);
                } //DATA
        }); //AJAX
}//function DisplayCreate
function SaveEventoCalendario(){
    $('#action_ID').val('SaveEvento');
    var formData = new FormData($(".CalendarioCreate")[0]);
    $.ajax({
        url: '../Controller/CalendarioInstitucional_html.php',
        type: 'POST',
        dataType: 'json',
        // Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function () {
            message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
            //showMessage(message)
        },
        //una vez finalizado correctamente
        success: function (data) {

            if (data.val === false) {
                if (data.Op === 1) {
                    alert('Error en el Tama\u00f1o de la imagen...');
                    message = $("<span class='error'>Error en el Tama\u00f1o de la imagen...</span>");
                    showMessage(message);
                    $('.butonView').css('display','block');
                    return false;
                } else {
                    alert(data.msj);
                    message = $("<span class='error'>" + data.msj + "</span>");
                    showMessage(message);
                    $('.butonView').css('display','block');
                    return false;
                }
            } else {
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);
                 if(data.img){
                    $(".showImage").html("<img src=../imagen/" + data.img + " width='300' />");
                 }
            }
        },
        //si ha ocurrido un error
        error: function () {
            message = $("<span class='error'>Ha ocurrido un error.</span>");
            showMessage(message);
            $('.butonView').css('display','block');
        }
    });
}//function SaveEventoCalendario
function EditEventoCalendario(){
    $('#action_ID').val('EditEvento');
    var formData = new FormData($(".CalendarioCreate")[0]);

    $.ajax({
        url: '../Controller/CalendarioInstitucional_html.php',
        type: 'POST',
        dataType: 'json',
        // Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function () {
            message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
            //showMessage(message)
        },
        //una vez finalizado correctamente
        success: function (data) {
            if (data.val === false) {
                if (data.Op === 1) {
                    alert('Error en el Tama\u00f1o de la imagen...');
                    message = $("<span class='error'>Error en el Tama\u00f1o de la imagen...</span>");
                    showMessage(message);
                    $('.butonView').css('display','block');
                    return false;
                } else {
                    alert(data.msj);
                    message = $("<span class='error'>" + data.mensaje + "</span>");
                    showMessage(message);
                    $('.butonView').css('display','block');
                    return false;
                }
            } else {
                message = $("<span class='success'>La imagen ha subido correctamente.</span>");
                showMessage(message);
                if(data.img){
                    $(".editimagen").html("<img src=" + data.img + " width='300' />");
                }
            }
        },
        //si ha ocurrido un error
        error: function () {
            message = $("<span class='error'>Ha ocurrido un error.</span>");
            showMessage(message);
            $('.butonView').css('display','block');
        }
    });
}//function EditEventoCalendario
function showMessage(message) {
    $(".messages").html("").show();
    $(".messages").html(message);
}//function showMessage

//comprobamos si el archivo a subir es una imagen
//para visualizarla una vez haya subido
function isImage(extension) {
    switch (extension.toLowerCase()) {
        case 'jpg':{return true;}break;
        case 'png':{return true;}break;
        case 'jpeg':{return true;}break;
        default:{
            return false;
        }break;
    }
}//function isImage
function val_texto(e) { //*onkeypress="return val_texto(event)"**//
    tecla = (document.all) ? e.keyCode : e.which;
        if(tecla===118){
            return false;
        }
    if (tecla===8 || tecla===0){
        return true;
    }else{

    patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s]+$/;
    te = String.fromCharCode(tecla);

    return patron.test(te);
}
}//function val_texto
    function val_textoNumero(e){
        if (tecla===8) return true; // backspace
        if (tecla===9) return true; // tab
        if (tecla===109) return true; // menos
        if (tecla===110) return true; // punto
        if (tecla===189) return true; // guion
        if ((tecla===47) || (tecla===40) || (tecla===41) || (tecla===61) || (tecla===63) || (tecla===191) || (tecla===161) || (tecla===124) || (tecla===58) || (tecla===59) || (tecla===44) || (tecla===46) || (tecla===45) || (tecla===95)) return true;
        if(tecla>=33 && tecla<=39)return true;//!
        if (tecla>=96 && tecla<=105){ return true;} //numpad
        if ((tecla===8) || (tecla===0)){
        return true;
        }else{

        patron = /[a-zA-ZñÑáéíóúÁÉÍÓÚ\s0-9]+$/;
        te = String.fromCharCode(tecla);

        return patron.test(te);
        }
}//function val_textoNumero
function DisplayEdit(){

    if(confirm('Desea modificar el Evento...?')){
        var id = $('#id_cargado').val();
        $.ajax({ //Ajax
            type: 'POST',
            url: '../Controller/CalendarioInstitucional_html.php',
            async: false,
            dataType: 'html',
            data:({action_ID: 'Inicio',id:id}),
            error: function (objeto, quepaso, otroobj) {
                alert('Error de Conexi?n , Favor Vuelva a Intentar');
            },
            success: function (data) {
                    $('#PrincipalView').html(data);
                } //DATA
        }); //AJAX
    }else{
         $('#id_cargado').val('');
         return false;
    }
}//function DisplayEdit