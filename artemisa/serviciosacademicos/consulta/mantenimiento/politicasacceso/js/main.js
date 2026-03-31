$(function(){
    //#Paso 1 Al cambio habilita el campo de texto nombre de usuario
    $('#tipoUsuario').on('change',function(){
        if($('#tipoUsuario').val()==''){
            $('#usuario').val('');
            $('#emailAdministrativo').val('');
            $('#usuario').prop('disabled',true);
            $('#emailAdministrativo').prop('disabled',true);

        }else if($('#tipoUsuario').val()=='docente'){
            $('#usuario').val('');
            $('#usuario').prop('disabled',false);
            if ($('#emailAdministrativo')) {// si existe

                $('#emailAdministrativo').val('');
                $('#emailAdministrativo').prop('disabled', true);
            }
        }else{
            $('#usuario').prop('disabled',false);
        }
    });
//#2 Evento caja usuario carga de email
    $('#usuario').on('input',  function() {
        var tipoUsuario = $('#tipoUsuario').val();
        var cantidadCaracteres = $('#usuario').val().length;
        var nombreUsuario = $('#usuario').val();
        if (tipoUsuario =='administrativo' && cantidadCaracteres > 2){
            $("#emailAdministrativo").prop("disabled",false);
            var url = 'ajax/cargaDatosAjax.php?accion=administrativo&nombreUsuario='+nombreUsuario;
            $('#cargaAjax').load(url);
        }else{
            $('#cargaAjax').empty();
           // $('.filPaso2').fadeOut();
            $('#tpDocente').prop('checked',false);
            $('#emailAdministrativo').val('');
            $('#emailAdministrativo').prop('disabled',true);
        }
    });
// #fin 1 Evento caja usuario


    $('#Enviar').on('click',function() {
        event.preventDefault();
        if (validaForm()) {
            swal({
                title: "Desea confirmar la contraseña",
                text: "Una vez restaurado, el usuario debera dirigirse a sala para continuar con el proceso de cambio de clave.",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        //swal("Poof! Your imaginary file has been deleted!", {
                        //  icon: "success",
                        // });
                        $('#frmResetClave').submit();
                    } else {
                        swal("ok! Proceso cancelado!");
                    }
                });
        }
    });
    /*valida formulario campos*/
    function validaForm(){
        // Campos de texto
        var seleccion =  $("#tipoUsuario").val();
        var usuario = $('#usuario').val();
        if(seleccion == ''){
            swal("Alerta!","Seleccione el Tipo de Usuario","warning");
            $("#tipoUsuario").focus();       // Esta función coloca el foco de escritura del usuario en el campo Nombre directamente.
            return false;
        }
        if (usuario == ''){
            swal("Alerta!","Digite el nombre del usuario","warning");
            $('#usuario').focus();
            return false;
        }
        if ($('#emailAdministrativo').is(':enabled')) {//si esta habilitado

            if ($('#emailAdministrativo').val()==''){
                swal("Alerta!","Correo Electronico Obligatorio","warning");
                $('#emailAdministrativo').focus();
                return false;
            }
            if($("#emailAdministrativo").val().indexOf('@', 0) == -1 || $("#emailAdministrativo").val().indexOf('.', 0) == -1) {
                swal("Alerta!","Correo Electronico Incorrecto","error");
                return false;
            }
        }
        return true; // Si todo está correcto
    }
    /*Fin valida formulario campos*/
});