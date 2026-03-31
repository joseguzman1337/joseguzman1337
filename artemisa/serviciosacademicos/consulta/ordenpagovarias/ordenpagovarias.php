<?php 
    require_once('../../Connections/sala2.php' );    
    require_once(realpath(dirname(__FILE__))."/../../funciones/validacion.php");
    require_once(realpath(dirname(__FILE__))."/../../funciones/errores_plandeestudio.php");
    require_once(realpath(dirname(__FILE__))."/../../funciones/funcionboton.php");
    require_once(realpath(dirname(__FILE__))."/../../funciones/sala_genericas/FuncionesFecha.php");

    session_start();
    mysql_select_db($database_sala, $sala);

    $ruta = "../../funciones/";
    $rutaorden = "../../funciones/ordenpago/";
    
    $codigoestudiante = $_SESSION['codigo'];
    $codigoperiodo = $_SESSION['codigoperiodosesion'];
    require_once($rutaorden.'claseordenpago.php');
    
    $query_refconceptos = "select r.codigoreferenciaconcepto, r.nombrereferenciaconcepto, ".
    " r.codigoautorizacionreferenciaconcepto, a.nombreautorizacionreferenciaconcepto ".
    " from referenciaconcepto r, autorizacionreferenciaconcepto a ".
    " where r.codigoestado like '1%' ".
    " and r.codigoaplicareferenciaconcepto like '1%' ".
    " and a.codigoautorizacionreferenciaconcepto = r.codigoautorizacionreferenciaconcepto";
    $refconceptos = mysql_query($query_refconceptos, $sala) or die("$query_refconceptos".mysql_error());
    $totalRows_refconceptos = mysql_num_rows($refconceptos);
    /// Primero muestra un formulario donde agrupa los conceptos a ser generados
    ?>
    <html>
        <head>
            <title>Ordenes de Pago Varias</title>
            <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <?php
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/bootstrap.css");
            echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/bootstrap.min.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/font-awesome.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/custom.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/assets/css/general.css");
            echo Factory::printImportJsCss("css",HTTP_ROOT."/sala/assets/css/loader.css");
            echo Factory::printImportJsCss("css", HTTP_ROOT ."/sala/assets/css/CenterRadarIndicator/centerIndicator.css");
            echo Factory::printImportJsCss("css", HTTP_ROOT ."/assets/css/sweetalert.css");

            echo Factory::printImportJsCss("js", HTTP_ROOT ."/assets/js/sweetalert.min.js");
            echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/jquery-3.1.1.js");
            echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/spiceLoading/pace.min.js");
            echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.min.js");
            echo Factory::printImportJsCss("js", HTTP_ROOT ."/sala/assets/js/bootstrap.js");
            ?>
        </head>
        <link rel="stylesheet" href="../../estilos/sala.css" type="text/css">
        <body>
            <div>
                <h3>FORMULARIO DE VISUALIZACIÓN Y GENERACIÓN DE ORDES DE PAGO POR CONCEPTOS VARIOS</h3>
                <p><strong>Seleccione la referencia de la cual desea generar ordenes:</strong></p>
                <?php
                if($totalRows_refconceptos != ""){
                    ?>
                    <table class="table table-responsive" style="font-size: 12px" width="750" border="1" cellpadding="1" cellspacing="0">
                        <tr id="trtituloNaranjaInst">
                            <td>Referencia de Concepto</td>
                            <td>Autorización</td>	
                        </tr>
                        <?php
                        while($row_refconceptos = mysql_fetch_assoc($refconceptos)){
                            ?>
                            <tr>
                                <td class='Estilo1'>
                                    <a href='conceptosxreferencia.php?codigoreferenciaconcepto=<?php echo $row_refconceptos['codigoreferenciaconcepto']; ?>'>
                                        <?php echo $row_refconceptos['nombrereferenciaconcepto']; ?>&nbsp;
                                    </a>
                                </td>
                                <td class='Estilo1'>
                                    <?php echo $row_refconceptos['nombreautorizacionreferenciaconcepto']; ?>&nbsp;
                                </td>
                            </tr>
                            <?php
                        }//while
                        if(!preg_match("/estudiante/",$_SESSION['MM_Username'])){
                            ?>
                            <tr>
                                <td class='Estilo1' colspan="2">
                                    <a href='conceptosxreferencia.php?todos'>
                                        Visualizar Todos Los Conceptos&nbsp;
                                    </a>
                                </td>
                            </tr>
                            <?php		
                        }//if
                        ?>
                    </table>
                    <?php
                }else{
                    ?>
                    <p>NO HAY CONCEPTOS PARA SER GENERADOS</p>
                    <?php
                }//else

                $query_selperiodoprevig = "SELECT p.codigoperiodo FROM periodo p WHERE ".
                " codigoestadoperiodo in (1, 3, 4) order by 1";   
                /*end*/
                $selperiodoprevig = mysql_query($query_selperiodoprevig, $sala) or die(mysql_error());
                $totalRows_selperiodoprevig = mysql_num_rows($selperiodoprevig);
                $row_selperiodoprevig = mysql_fetch_assoc($selperiodoprevig);
                                
                //si solo encuentra un periodo activo
                if($totalRows_selperiodoprevig == 1){
                    $codigoperiodoact = $row_selperiodoprevig['codigoperiodo'];
                    $ordenesxestudiante = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodoact);
                //si existe mas de un periodo
                }else{
                    //asigna el perimer periodo indentificado
                    $codigoperiodopre = $row_selperiodoprevig['codigoperiodo'];                    
                    $ordenesxestudiantepre = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodopre);                     
                    //consulta el siguinete periodo
                    $row_selperiodoprevig = mysql_fetch_assoc($selperiodoprevig);
                    
                    $codigoperiodoact = $row_selperiodoprevig['codigoperiodo'];                          
                    $ordenesxestudiante = new Ordenesestudiante($sala, $_SESSION['codigo'], $codigoperiodoact);	                                        
                }//else

                if(isset($codigoperiodopre)){                    
                    $ordenesxestudiantepre->mostrar_ordenespago($rutaorden,"");
                    ?>
                    <br>
                    <?php
                }//if            
                
                $ordenesxestudiante->mostrar_ordenespago($rutaorden,"");
                ?>
                <br>
                <?php

                if($_SESSION['MM_Username'] == "estudiante" || $_SESSION['MM_Username'] == "estudianterestringido"){
                    ?>
                    <!--<br><font color="#800000" ><a href="../../../libsoap/ayudapse/AyudaPSE.htm">NUEVO SISTEMA DE PAGO PSE</a></font><br><br>-->
                    <?php
                }//if
            ?>
            <input type="button" class="btn btn-fill-green-XL" onClick="window.location.href='../prematricula/matriculaautomaticaordenmatricula.php'" value="Regresar">
            </div>
        </body>
    </html>
