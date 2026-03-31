 $(document).on("ready",inicio);

function inicio(){
        

                        $("span.help-block").hide();
                        $("#buttonEnviar").click(function(){
                            if(ValidarFormulario()> 0){
                                swal("Por favor Diligenciar los campos");
                            }else{
                             EnviarFormulario();
                            }
                        });

                        $("#identificacionSolicitante").blur(ValidarFormulario);
                        $("#nombreSolicitante").blur(ValidarFormulario);
                        $("#apellidoSolicitante").blur(ValidarFormulario);
                        $("#empresaSolicitante").blur(ValidarFormulario);
                        $("#correoSolicitante").blur(ValidarFormulario);
                        $("#confirmaCorreoSolicitante").blur(ValidarFormulario);
                        $("#nombreEgresado").blur(ValidarFormulario);
                        $("#apellidoEgresado").blur(ValidarFormulario);
                        $("#identificacionEgresado").blur(ValidarFormulario);
                        $("#checkCertifico").change(ValidarFormulario);

                    };
                        

                        function EnviarFormulario(){
                       
                                event.preventDefault();
                                var identificacionSolicitante = $('#identificacionSolicitante').val(),
                                nombreSolicitante = $('#nombreSolicitante').val(),
                                apellidoSolicitante = $('#apellidoSolicitante').val(),
                                empresaSolicitante = $('#empresaSolicitante').val(),
                                correoSolicitante = $('#correoSolicitante').val(),
                                nombreEgresado = $('#nombreEgresado').val(),
                                apellidoEgresado = $('#apellidoEgresado').val(),
                                identificacionEgresado = $('#identificacionEgresado').val(),
                                tipoCertificado = $('#tipoCertificado').val();
                                captcha = $('#g-recaptcha-response').val();
                                if(correoSolicitante !== $('#confirmaCorreoSolicitante').val()){
                                    alert('Los correos ingresados no coinciden.');
                                }else{
                                    $.ajax({
                                        type: 'POST',
                                        url: 'controllerCertificado.php',
                                        async: false,
                                        dataType: 'json',
                                        data:({
                                            actionID: 'save',
                                            identificacionSolicitante:identificacionSolicitante,
                                            nombreSolicitante:nombreSolicitante,
                                            apellidoSolicitante:apellidoSolicitante,
                                            empresaSolicitante:empresaSolicitante,
                                            correoSolicitante:correoSolicitante,
                                            nombreEgresado:nombreEgresado,
                                            apellidoEgresado:apellidoEgresado,
                                            identificacionEgresado:identificacionEgresado,
                                            tipoCertificado:tipoCertificado,
                                            captcha: captcha
                                        }),

                                        success: function(data){
                                            swal({

                                                text: data.mensaje
                                                
                                            }).then(function(){
                                                if(data.bandera==1){
                                                    location.href ="../certificadosGraduadosEstudiantes";    
                                                }
                                            });
                                        },
                                       error: function(data,error,errorThrown){alert('Error de Conexión , Favor Vuelva a Intentar');}
                                    });
                                }
                    };
                       

                    function validar_email( email ) 
                    {
                        var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                        return regex.test(email) ? true : false;
                    }

                    function ValidarFormulario(){

                      var contador = 0;
                       identificacionSolicitante = document.getElementById("identificacionSolicitante").value;
                       nombreSolicitante = document.getElementById("nombreSolicitante").value;
                       apellidoSolicitante = document.getElementById("apellidoSolicitante").value;
                       empresaSolicitante = document.getElementById("empresaSolicitante").value;
                       correoSolicitante = document.getElementById("correoSolicitante").value;
                       confirmaCorreoSolicitante = document.getElementById("confirmaCorreoSolicitante").value;
                       nombreEgresado = document.getElementById("nombreEgresado").value;
                       apellidoEgresado = document.getElementById("apellidoEgresado").value;
                       identificacionEgresado = document.getElementById("identificacionEgresado").value;
                       checkCertifico = document.getElementById("checkCertifico").checked;

                      if(identificacionSolicitante == null || identificacionSolicitante.length ==0){
                        $("#identificacionSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#identificacionSolicitante").parent().children("span").text("Debe Ingresar el documento del solicitante").show();
                        contador = contador +1;
                      } else{
                        $("#identificacionSolicitante").parent().parent().attr("class", "form-group has-success");
                        $("#identificacionSolicitante").parent().children("span").text("").hide();
                      }
                      if(nombreSolicitante == null || nombreSolicitante.length ==0){
                        $("#nombreSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#nombreSolicitante").parent().children("span").text("Debe Ingresar el Nombre del solicitante").show();    
                         contador = contador +1;
                      }else{
                        $("#nombreSolicitante").parent().parent().attr("class", "form-group has-success");
                        $("#nombreSolicitante").parent().children("span").text("").hide();
                      }
                      if(apellidoSolicitante == null || apellidoSolicitante.length ==0){
                        $("#apellidoSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#apellidoSolicitante").parent().children("span").text("Debe Ingresar el apellido del solicitante").show();
                       contador = contador + 1;
                      }else{
                         $("#apellidoSolicitante").parent().parent().attr("class", "form-group has-success");
                        $("#apellidoSolicitante").parent().children("span").text("").hide();
                      }
                      if(empresaSolicitante == null || empresaSolicitante.length ==0){
                        $("#empresaSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#empresaSolicitante").parent().children("span").text("Debe Ingresar la empresa solicitante").show();
                       contador = contador + 1;

                      }else{
                        $("#empresaSolicitante").parent().parent().attr("class", "form-group has-success");
                        $("#empresaSolicitante").parent().children("span").text("").hide();
                      }
                      if(correoSolicitante == null || correoSolicitante.length ==0){
                        $("#correoSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#correoSolicitante").parent().children("span").text("Debe Ingresar el correo del solicitante").show();
                           contador = contador + 1;

                      }
                      if(validar_email(correoSolicitante) == false){
                        $("#correoSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#correoSolicitante").parent().children("span").text("Debe Ingresar un correo valido").show();
                           contador = contador + 1; 

                      }else{
                        
                        $("#correoSolicitante").parent().parent().attr("class", "form-group has-success");
                        $("#correoSolicitante").parent().children("span").text("").hide();
                      }
                    
                      if(confirmaCorreoSolicitante == null || confirmaCorreoSolicitante.length ==0){
                        $("#confirmaCorreoSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#confirmaCorreoSolicitante").parent().children("span").text("Debe Ingresar el correo del solicitante").show();
                           contador = contador + 1;

                      }

                      if(validar_email(confirmaCorreoSolicitante) == false){
                        $("#confirmaCorreoSolicitante").parent().parent().attr("class", "form-group has-error");
                        $("#confirmaCorreoSolicitante").parent().children("span").text("Debe Ingresar un correo valido").show();
                           contador = contador + 1; 

                      }else{
                        $("#confirmaCorreoSolicitante").parent().parent().attr("class", "form-group has-success");
                        $("#confirmaCorreoSolicitante").parent().children("span").text("").hide();
                      }
                      if(nombreEgresado == null || nombreEgresado.length ==0){
                        $("#nombreEgresado").parent().parent().attr("class", "form-group has-error");
                        $("#nombreEgresado").parent().children("span").text("Debe Ingresar el nombre del estudiante").show();
                           contador = contador + 1;

                      }else{
                        $("#nombreEgresado").parent().parent().attr("class", "form-group has-success");
                        $("#nombreEgresado").parent().children("span").text("").hide();
                      }
                      if(apellidoEgresado == null || apellidoEgresado.length ==0){
                        $("#apellidoEgresado").parent().parent().attr("class", "form-group has-error");
                        $("#apellidoEgresado").parent().children("span").text("Debe Ingresar el apellido del estudiante").show();
                           contador = contador + 1;

                      }else{
                        $("#apellidoEgresado").parent().parent().attr("class", "form-group has-success");
                        $("#apellidoEgresado").parent().children("span").text("").hide();
                      }
                      if(identificacionEgresado == null || identificacionEgresado.length ==0){
                        $("#identificacionEgresado").parent().parent().attr("class", "form-group has-error");
                        $("#identificacionEgresado").parent().children("span").text("Debe Ingresar el documento del estudiante").show();
                           contador = contador + 1;

                      }else{
                        $("#identificacionEgresado").parent().parent().attr("class", "form-group has-success");
                        $("#identificacionEgresado").parent().children("span").text("").hide();
                      }if(checkCertifico){
                        $("#checkCertifico").parent().parent().attr("class", "form-group has-success");
                        $("#checkCertifico").parent().children("span").text("").hide();
                      }else{
                        $("#checkCertifico").parent().parent().attr("class", "form-group has-error");
                        $("#checkCertifico").parent().children("span").text("Debe aceptar los terminos de la politica de tratamiento de informacion").show();
                           contador = contador + 1;
                      }
                      return contador;
                    };


                    function buscarDatos(){
                            var identificacionSolicitante = $('#identificacionSolicitante').val();
                            $.ajax({
                                type: 'POST',
                                url: 'controllerCertificado.php',
                                async: false,
                                dataType: 'json',
                                data:({ 
                                    actionID: 'buscarDocumento',
                                    identificacionSolicitante:identificacionSolicitante
                                }),
                                error:function(objeto, quepaso, otroobj){alert('Error de Conexión , Favor Vuelva a Intentar');},
                                success: function(data){
                                    if(data.idConsultaTitulos !== 0){
                                        $('#identificacionSolicitante').val(data.identificacionSolicitante);
                                        $('#nombreSolicitante').val(data.nombreSolicitante);
                                        $('#apellidoSolicitante').val(data.apellidoSolicitante);
                                        $('#empresaSolicitante').val(data.empresaSolicitante);
                                        $('#correoSolicitante').val(data.correoSolicitante);
                                    }
                                }
                            });
                        }