<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Certificados</title>
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
                <link type="text/css" rel="stylesheet" href="../../../../assets/css/sweetalert.css" />
                <style>

                    .header {
    color: #59ab52;
    font-size: 27px;
    padding: 10px;
}

.bigicon {
    font-size: 35px;
    color: #59ab52;
}
.well {background: #fcfafa;}

                    
            </style>

    </head>
    <body>



<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div>
                <form id="formulario" action="#" method="post" class="form-horizontal" method="post">
                    <fieldset>
                        <legend class="text-center header">Solicitante</legend>


                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-id-card bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" type="text" name="identificacionSolicitante" id="identificacionSolicitante" placeholder="Número de Documento" class="form-control">
                                <span class="help-block"></span>
                                <input type="hidden" name="tipoCertificado" id="tipoCertificado" value="<?php echo $_REQUEST['tipoCertificado']; ?>" />
                            </div>
                        </div>


                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="nombreSolicitante" id="nombreSolicitante" type="text" placeholder="Nombre solicitante" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="apellidoSolicitante" id="apellidoSolicitante" type="text" placeholder="Apellido solicitante" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>

                    <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-6">
                                <input input required="required" name="empresaSolicitante" id="empresaSolicitante" type="text" placeholder="Empresa solicitante" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-envelope-o bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="correoSolicitante" id="correoSolicitante" type="email" placeholder="Correo electrónico solicitante" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-envelope-o bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="confirmaCorreoSolicitante" id="confirmaCorreoSolicitante" type="email" placeholder="Confirmar correo electrónico solicitante" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>


                            <legend class="text-center header">Estudiante</legend>

                            <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="nombreEgresado" id="nombreEgresado" type="text" placeholder="Nombre egresado/estudiante a validar" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>

                    <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-user bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="apellidoEgresado" id="apellidoEgresado" type="text" placeholder="Apellidos egresado/estudiante a validar" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <span class="col-md-1 col-md-offset-3 text-center"><i class="fa fa-id-card bigicon"></i></span>
                            <div class="col-md-6">
                                <input required="required" name="identificacionEgresado" id="identificacionEgresado" type="text" placeholder="Identificación egresado/estudiante a validar" class="form-control">
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            
                            <div class="col-md-11  col-md-offset-1 text-center">
                                <input type="checkbox" required="required" name="checkCertifico" id="checkCertifico"/> He leido y estoy de acuerdo con los terminos de la politica de tratamiento y privacidad de la informacion. Ver politica <a target="blank" href="http://www.uelbosque.edu.co/sites/default/files/pdf/documentos_interes/politica_privacidad_informacion_pagina_web_universidad_el_bosque.pdf">aqui.</a>
                                <span class="help-block"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div align="center"class="g-recaptcha" data-sitekey="6LcjdXwUAAAAAEY_iO9aFV2jIesNp9OapO8L_xG8"></div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12 text-center">
                                <input class="btn btn-primary" id="buttonEnviar" type="button" value="Enviar" />
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>

            <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
            <script type="text/javascript" src="../../../../assets/js/sweetalert.min.js"></script>
            <script src="index.js"></script>
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </body>
    
</html>