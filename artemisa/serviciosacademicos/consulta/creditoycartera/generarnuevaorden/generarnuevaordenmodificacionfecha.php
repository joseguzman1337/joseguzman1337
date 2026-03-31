<?php
     // ESTE SCRIPT GENERA UNA NUEVA ORDEN DEBIDO A QUE SE MODIFICO LA FECHA DE PAGO DE LA ORDEN
    is_file(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php")
    ? require_once(dirname(__FILE__) . "/../../../../sala/includes/adaptador.php")
    : require_once(realpath(dirname(__FILE__) . "/../../sala/includes/adaptador.php"));

    require_once('../../../funciones/validacion.php');
    require_once('../../../funciones/zfica_crea_estudiante.php');
    require_once('../../../funciones/funcionip.php');
    require_once('errores_generarnuevaorden.php');
    require_once('OrdenesModificacion.php');
    session_start();
    $formulariovalido = 1;

    if(isset($_POST['codigo']) && !empty($_POST['codigo'])){
        $codigo = $_POST['codigo'];
    }else{
        $codigo ="";
    }
    if(isset($_POST['orden']) && !empty($_POST['orden'])) {
        $orden = $_POST['orden'];
    }else{
        $orden = "";
    }

    if(isset($_POST['porcentaje']) && !empty($_POST['porcentaje'])){
        $porcentaje = $_POST['porcentaje'];
    }else{
        $porcentaje = "0";
    }

    if(isset($_POST['fecha']) && !empty($_POST['fecha'])){
        $fecha = $_POST['fecha'];
    }else{
        $fecha = "";
    }

    if(isset($_POST['diasinteres']) && !empty($_POST['diasinteres'])){
        $diasinteres = $_POST['diasinteres'];
    }else{
        $diasinteres = "";
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Generar Nueva Orden</title>
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/normalize.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-page.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/font-awesome.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/general.css"> 
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/chosen.css"> 
        <script type="text/javascript" src="../../../../assets/js/jquery-3.6.0.min.js"></script> 
        <script type="text/javascript" src="../../../../assets/js/bootstrap.js"></script>

        <script src="<?php echo HTTP_ROOT;?>/sala/assets/js/spiceLoading/pace.min.js"></script>
        <link href="<?php echo HTTP_ROOT; ?>/sala/assets/css/CenterRadarIndicator/centerIndicator.css" rel="stylesheet">
        
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap-datetimepicker.css">
        <link type="text/css" rel="stylesheet" href="../../../../assets/css/bootstrap-datetimepicker.min.css">   
        <script type="text/javascript" src="../../../../assets/js/moment.js"></script>   
        <script type="text/javascript" src="../../../../assets/js/moment-with-locales.js"></script>
        <script type="text/javascript" src="../../../../assets/js/bootstrap-datetimepicker.js"></script>
        <script type="text/javascript"> 
            $( document ).ready(function() {
                $(".form_datetime").datetimepicker({ format: 'YYYY-MM-DD', locale: 'es' });              
            });
        </script>

    </head>
    <body>
        <div class="container">
            <h3 align="center">MODIFICAR ORDEN DE MATRÍCULA POR CAMBIO DE FECHA</h3>
            <form action="generarnuevaordenmodificacionfecha.php" method="post">
                <input type="hidden" id="rol" name="rol" value="<?php echo $_SESSION['rol'];?>">
                <table class="table"  width="100%">
                    <tr>
                        <td  class="info" width="50%">
                            <strong>Documento estudiante : </strong>
                        </td>
                        <td>
                            <input type="text" id= "codigo" name="codigo" size="10" value="<?php echo $codigo;?>">
                            <?php
                            if(isset($codigo) && !empty($codigo)){
                                $imprimir = true;
                                $codnum = validar($codigo,"numero",$error1,$imprimir);
                                $codnum = validar($codigo,"requerido",$error5,$imprimir);
                                $formulariovalido = $formulariovalido*$codnum;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="info" >
                            <strong>Número de orden : </strong>
                        </td>
                        <td>
                            <input type="text" name="orden" size="10" value="<?php echo $orden;?>">
                            <?php
                            if(isset($orden) && !empty($orden)){
                                $imprimir = true;
                                $ordnum = validar($orden,"numero",$error1,$imprimir);
                                $ordnum = validar($orden,"requerido",$error6,$imprimir);
                                $formulariovalido = $formulariovalido*$ordnum;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="info" >
                            <strong>Porcentaje a pagar: </strong>
                             <br/>
                            <input type="radio" id="incremento" name="porcentajedescuento" value="incremento" required>
                            <label for="incremento">Incremento</label><br>
                            <input type="radio" id="descuento" name="porcentajedescuento" value="descuento" required>
                            <label for="descuento">Descuento</label><br>
                        </td>
                        <td>
                            <input type="text" name="porcentaje" size="10" value="<?php echo $porcentaje;?>">
                            <?php
                                if(isset($porcentaje) && !empty($porcentaje)){
                                    $imprimir = true;
                                    $vporcentaje = validar($porcentaje,"porcentaje",$error2,$imprimir);
                                    $formulariovalido = $formulariovalido*$vporcentaje;
                                }
                            ?>
                       </td>
                    </tr>
                    <tr>
                        <td class="info" >
                            <strong>Fecha de pago: </strong>
                        </td>
                        <td>
                            <div class='input-group date'>
                                <input class="form_datetime" name="fecha" type="text" value="<?php echo $fecha;?>" size="10">
                                <?php
                                if(isset($fecha) && !empty($fecha)){
                                    $imprimir = true;
                                    $vfecha = validar($fecha,"fecha",$error3,$imprimir);
                                    $vfecha = validar($fecha,"fechamayor",$error4,$imprimir);
                                    $formulariovalido = $formulariovalido*$vfecha;
                                }
                                ?>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="info" >
                            <strong>Días Interés <br>
                                (Obligatorio para colegio solamente si diligencia porcentaje a pagar):
                            </strong>
                        </td>
                        <td>
                            <input type="text" name="diasinteres" size="10" value="<?php echo $diasinteres;?>">
                            <?php
                            if(isset($diasinteres) && !empty($diasinteres)){
                                $imprimir = true;
                                $vdiasinteres = validar($diasinteres,"numero",$error1,$imprimir);
                                $formulariovalido = $formulariovalido*$vdiasinteres;
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <div id="botonAceptar" >
                                <input type="submit" class="btn btn-success btn-lg" name="aceptar" value="Aceptar">
                            </div>
                        </td>
                    </tr>
                </table>
            </form>
            <?php
                if(isset($_POST['aceptar'])){
                    $validacion= 0;
                    if(!isset($_POST['fecha']) || empty($_POST['fecha'])){
                        $validacion= 1;
                    }
                    else{
                        if(!isset($_POST['porcentaje']) || $_POST['porcentaje'] == null){
                            $validacion= 1;
                        }
                        else{
                            if(!isset($_POST['orden']) || empty($_POST['orden'])){
                                $validacion= 1;
                            }
                            else{
                                if(!isset($_POST['codigo']) || empty($_POST['codigo'])){
                                    $validacion= 1;
                                }
                            }
                        }
                    }

                    if($validacion == 0){
                        //consulta los datos del estudiante y orden para el periodo de la session
                        $query_ordenpago = "select concat(eg.nombresestudiantegeneral, ' ', eg.apellidosestudiantegeneral) as nombre, ".
                        " e.numerocohorte, e.codigoestudiante, e.codigocarrera, e.codigotipoestudiante, ".
                        " o.numeroordenpago, p.codigoperiodo, o.codigoestadoordenpago ".
                        " from estudiante e ".
                        " inner join ordenpago o on e.codigoestudiante = o.codigoestudiante ".
                        " inner join periodo p on p.codigoperiodo = o.codigoperiodo ".
                        " inner join estudiantegeneral eg on e.idestudiantegeneral = eg.idestudiantegeneral ".
                        " inner join estudiantedocumento ed on e.idestudiantegeneral = ed.idestudiantegeneral ".
                        " where ed.numerodocumento = '$codigo' and o.numeroordenpago = '$orden' ".
                        " and o.codigoestadoordenpago like '1%' ".
                        " and p.codigoperiodo = '".$_SESSION['codigoperiodosesion']."' ".
                        " and ed.fechainicioestudiantedocumento <= '".date("Y-m-d H:m:s",time())."' ".
                        " and ed.fechavencimientoestudiantedocumento >= '".date("Y-m-d H:m:s",time())."'";
                        $row_ordenpago = $db->GetRow($query_ordenpago);

                        if(isset($row_ordenpago['nombre']) && !empty($row_ordenpago['nombre'])) {
                            $nombre = $row_ordenpago['nombre'];
                            $codigoestudiante = $row_ordenpago['codigoestudiante'];
                            $codigocarrera = $row_ordenpago['codigocarrera'];
                            $numeroordenpago = $row_ordenpago['numeroordenpago'];
                            $codigoperiodo = $row_ordenpago['codigoperiodo'];
                            $numerocohorte = $row_ordenpago['numerocohorte'];
                            $codigotipoestudiante = $row_ordenpago['codigotipoestudiante'];
                            $codigoestadoordenpago1 = $row_ordenpago['codigoestadoordenpago'];
                            require("generarygrabarordenpago.php");
                        }else{
                            ?>
                            <script language="javascript">
                                alert("No se obtuvo ningún resultado, verifique el documento del estudiante o el número de orden");
                            </script>
                            <?php
                        }
                    }else{
                        ?>
                        <script language="javascript">
                            alert("Debe completar el formulario");
                        </script>
                        <?php
                    }
                }
            ?>
        </div>
    </body>
</html>