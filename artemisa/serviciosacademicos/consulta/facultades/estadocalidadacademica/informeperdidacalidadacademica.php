<?php 
    /**
     * Ivan Dario Quintero Rios <quinteroivan@unbosque.edu.co>
     * Enero 08 del 2019
     */
    /**
      * Caso 986.
      * Se incluye el archivo adaptador para tener acceso a las funciones basicas de
      * del nuevo sala si la aplicacion se corre en un entorno local o de pruebas 
      * se activa la visualizacion de todos los errores de php
      * @modified Dario Gaulteros Castro <castroluisd@unbosque.edu.co>.
      * @copyright Dirección de Tecnología Universidad el Bosque
      * @since 24 de Abril 2019.
    */
    require_once(realpath(dirname(__FILE__)."/../../../../sala/includes/adaptador.php"));
    /**
     * El metodo Factory::validateSession($variables) hace una validacion de session activa en el sistema
     * dependiendo de los parametros que se le envíen, si determina que la session acabo redirige el sistema al login
    */
    Factory::validateSession($variables);
    $usuario = Factory::getSessionVar('usuario');
    
    /**
     * Caso 986.
     * @modified Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
     * Ajuste de acceso por usuario por la opción de Gestion de Permisos.
     * @since 24 de Abril 2019.
    */
    $itemId = Factory::getSessionVar('itemId');
        require_once('../../../../assets/lib/Permisos.php');
        if (!Permisos::validarPermisosComponenteUsuario($usuario, $itemId)) {
          header("Location: " . HTTP_ROOT . "/serviciosacademicos/GestionRolesYPermisos/index.php?option=error");
           exit();
    }

    ?>
   <html>
    <head>
        <title>Informe Calidad Académica</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css">
        
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script> 
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>
        <script type="text/javascript" src="js/informePerdidaCalidadAcademica.js"></script>
    </head>
    <body>        
        <div class="container">
            <input type="hidden" name="facultad" id="facultad" value="<?php echo $_SESSION['codigofacultad'];?>">
            <center>
            <div class="row">
                <div class="col-md-8">
                    <h3>Facultad:</h3>
                </div>
                <div class="col-md-4">
                    <h3>Situación:</h3>
                </div>
            </div>
            <div class="row">                
                <div class="col-md-8">
                    <select id="carrera" name="carrera">
                    </select>
                </div> 
                <div class="col-md-4">
                    <select id="situacion" name="situacion">
                    </select>
                </div>
            </div>      
            <div class="row">
                <div class="col-md-4">
                    <input class="btn btn-fill-green-XL" type="button" id="consultar" value="consultar" onclick="consultardatos()">
                </div>
                <div class="col-md-4" id="exportarbtn" style="display:none;">
                    <button class="btn btn-fill-green-XL" type="button" id="exportExcel1">
                        Exportar a Excel
                    </button>
                    <form id="formInforme" method="post" action="../../../../assets/lib/ficheroExcel.php">
                        <input  id="datos_a_enviar" type="hidden" name="datos_a_enviar">
                    </form>
               </div>
            </div>
            <div id="procesando" style="display:none">
                <img witdh="400px" src="../../../../assets/ejemplos/img/Procesando.gif" ><br>
                <p>Procesando, por favor espere...</p>
            </div>            
            <div class="table-responsive" id="tabla" style="display: none">                
                <table id="dataR1" width="80%" class="table table-bordered table-line-ColorBrandDark-headers">
                    <thead>
                        <tr>
                            <th>N°</th>                                               
                            <th>Número Documento</th>
                            <th>Nombre Completo</th>
                            <th>Situación Académica</th>
                            <th>Periodo</th>                            
                            <th>Programa Académico</th>                            
                            <th>Modalidad Académica</th>
                            <th>Semestre</th>
                            <th>Fecha Inicio Situación</th>
                            <th>Fecha Final Situación</th>
                            <th>Correo Personal</th>
                            <th>Correo Institucional</th>
                            <th>Género</th>
                        </tr> 
                    </thead>
                    <tbody id="dataReporte">
                    </tbody>
                </table>      
            </div>
        </div>
    <script type="text/javascript">
        $(document).ready(function(){             
            carreras();   
            situaciones();            
        });
        
        $('#exportExcel1').click(function (e){
            $("#datos_a_enviar").val($("<div>").append($("#dataR1").eq(0).clone()).html());
            $("#formInforme").submit();
        });
    </script>
    </body>
   </html>