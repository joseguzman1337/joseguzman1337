let formularioEdCon;

$(()=>{
    formularioEdCon = new FormularioEdCon
})

class FormularioEdCon{

    constructor(){
        this.setters().then(()=>{

            this.agregarFunciones()
            this.acciones()
            this.iniciadores()
        })
    }

    agregarFunciones(){

        this.funciones['limpiarFormulario'] = ()=>{

            setTimeout('document.formec.reset()',1000);

            $('#Ciudad').val('').trigger('chosen:updated');
            $('#Programa').val('').trigger('chosen:updated');


        }

        this.funciones['validarForm'] = ()=>{

            jQuery.validator.addMethod("lettersonly", function(value, element) {
                return this.optional(element) || /^[a-zA-Z\s ñáéíóú]+$/i.test(value);
            }, "Solo letras");


            jQuery.validator.setDefaults({

                highlight:function(element){
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight:function(element){
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement:'span',
                errorClass:'help-block',
                errorPlacement:function(error,element){


                    //función que asigna el mensaje de error debajo del input, acorde con su clase
                    if(element.hasClass('chosen-select')){

                        element = element.next()

                    }

                    error.insertAfter(element);

                }

            });

            $.validator.setDefaults({ ignore: ":hidden:not(select)" });

        }

        this.funciones['enviarInformacion'] = ()=>{

            this.buttonPressed = true

            /*Validación de cada uno de los campos del formulario para Programas de Educación Continuada*/

            $('#formec').validate({
                rules:{
                    Nombres:{required:true, lettersonly: true, minlength: 3},
                    Apellidos:{required:true, lettersonly: true, minlength: 3},
                    Email:{required:true, email: true},
                    Ciudad:{required:true},
                    Telefono:{required:true, number: true, minlength: 5},
                    Programa:{required:true},
                    valida:{required:true}
                },
                messages:{
                    Nombres:{required:"Debe digitar un Nombre", lettersonly:"Debe contener solo letras", minlength:"El Nombre debe contener mas de 3 Letras"},
                    Apellidos:{required:"Debe digitar un Apellido", lettersonly:"Debe contener solo letras", minlength:"El Apellido debe contener mas de 3 Letras"},
                    Email:{required:"Debe digitar un Email", email:"Digite un correo valido"},
                    Ciudad:{required:"Debe seleccionar una Ciudad"},
                    Telefono:{required:"Debe digitar un Telefono", number:"Solo se permiten números", minlength:"El telefono debe contener mas de 5 Letras"},
                    Programa:{required:"Debe seleccionar un Programa"},
                    valida:{required:"Debe aceptar los Términos y Condiciones"}
                }
            });
            if($('#formec').valid()){

                $.ajax({
                    type: 'POST',
                    url: '../../../serviciosacademicos/consulta/estadisticas/matriculasnew/apirantesWeb.php',
                    data: $('#formec').serialize(),
                    success: function (data) {
                        //Esta validacion garantiza que toda la información haya sido procesada adecuadamente
                        if(data.success){
                            //La siguiente línea ubica el frame en us posición incial, para desplegar le mensaje apropiadamente
                            $('html').scrollTop(0);
                            bootbox.alert({
                                message: "Datos Enviados Exitosamente",
                                buttons: {
                                    ok: {
                                        className: 'btn btn-fill-green-XL'
                                    }
                                }
                            });
                            //La siguiente linea llama a la instancia por su nombre, en vez de usar la palabra reservada this
                            formularioEdCon.funciones.limpiarFormulario();

                        }else{

                            //Ver línea 107
                            $('html').scrollTop(0);


                            bootbox.alert({
                                message: "Hubo un problema para cargar la información que solucionaremos en breve",
                                buttons: {
                                    ok: {
                                        className: 'btn btn-fill-green-XL'
                                    }
                                }
                            });


                        }

                    },

                    error: function (data)

                        //La presente función es llamada cuando no se establece una comunicación adecuada entre la vista y el modelo

                    {

                        console.log(data)

                        bootbox.alert({
                            message: "Hubo un problema para cargar la información que solucionaremos en breve",
                            buttons: {
                                ok: {
                                    className: 'btn btn-fill-green-XL'
                                }
                            }
                        });
                    }
                });

            }else{

                //Ver línea 107
                $('html').scrollTop(0);

                bootbox.alert({
                    message: "Por favor revisa la información antes de continuar",
                    buttons: {
                        ok: {
                            className: 'btn btn-fill-green-XL'
                        }
                    }
                });


            }
        }


    }


    acciones(){

        $(document).on('click','#btnenviar',(event)=>{
            event.preventDefault();
            this.funciones.enviarInformacion();
        })

        $(document).on('change','.select-chosen',(event)=>{


            //La siguiente función valida los chosen selects


            if(this.buttonPressed){
                $('#formec').validate({
                    rules:{
                        Nombres:{required:true, lettersonly: true, minlength: 3},
                        Apellidos:{required:true, lettersonly: true, minlength: 3},
                        Email:{required:true, email: true},
                        Ciudad:{required:true},
                        Telefono:{required:true, number: true, minlength: 5},
                        Programa:{required:true},
                        valida:{required:true}
                    },
                    messages:{
                        Nombres:{required:"Debe digitar un Nombre", lettersonly:"Debe contener solo letras", minlength:"El Nombre debe contener mas de 3 Letras"},
                        Apellidos:{required:"Debe digitar un Apellido", lettersonly:"Debe contener solo letras", minlength:"El Apellido debe contener mas de 3 Letras"},
                        Email:{required:"Debe digitar un Email", email:"Digite un correo valido"},
                        Ciudad:{required:"Debe seleccionar una Ciudad"},
                        Telefono:{required:"Debe digitar un Telefono", number:"Solo se permiten números", minlength:"El telefono debe contener mas de 5 Letras"},
                        Programa:{required:"Debe seleccionar un Programa"},
                        valida:{required:"Debe aceptar los Términos y Condiciones"}
                    }
                });

            }

        })

    }

    iniciadores(){

        console.log('modulo formularioEC iniciado')

        this.funciones.limpiarFormulario();

        this.funciones.validarForm();

        //con este cpmando se convierten los selects en chosen-selects
        $('.chosen-select').chosen();

    }


    setters(){
        return new Promise((resolve,reject)=>{

            this.funciones = []
            this.buttonPressed = false
            resolve(true)

        })
    }



}

