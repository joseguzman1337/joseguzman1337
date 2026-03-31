<?php 
$id = $_REQUEST["id"];
$idsiq_estructuradocumento = $_REQUEST["idsiq_estructuradocumento"];
$idsiq_factor = $_REQUEST["idsiq_factor"];
$tp = $_REQUEST["tp"];
session_start();
include_once('../../../utilidades/ValidarSesion.php');
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);
require_once("../../datos/templates/template.php");

require('oportunidad.php');
error_reporting(E_ALL);
ini_set('display_errors', '1');
$numeroEvidencias = conteoEvidencia($db,$id);
$numeroEvidencias["evidencias"];
?>
<html>
    <head>
     	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	     
                <script type="text/javascript" language="javascript" src="../../../../sala/assets/js/jquery-3.1.1.js"></script>
                <script type="text/javascript" language="javascript" src="../../../../sala/assets/js/bootstrap.min.js"></script>
                <script type="text/javascript" language="javascript" src="../../../../assets/js/bootstrap-filestyle.min.js"></script>
                <link rel="stylesheet" type="text/css" href="../../../../sala/assets/css/bootstrap.min.css" />   
                <link rel="stylesheet" type="text/css" href="../../../../assets/css/font-awesome.min.css" />   
                <script type="text/javascript" language="javascript" src="../../../../sala/assets/plugins/bootstrap-validator/bootstrapValidator.js"></script>
                <link rel="stylesheet" type="text/css" href="../../../../sala/assets/plugins/bootstrap-validator/bootstrapValidator.min.css" />   
                <script type="text/javascript" language="javascript" src="oportunidad.js"></script>
    </head>
    <?php

        
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        /*@modified Diego Rivera <riveradiego@unbosque.edu.co>
         *Se agrega funcion  getBrowser para identificar navegador ie,edge y adiconar scroll debido a quen no lo
         toma automaticamente
         *@Since December 18,2018 
         */
        function getBrowser($user_agent) {

            if (strpos($user_agent, 'MSIE') !== FALSE)
                return '<style>
                            #scrollNavegador{
                                overflow:scroll;
                                width:100%;
                                height: 700px;
                               }
                        </style>';
            elseif (strpos($user_agent, 'Edge') !== FALSE) //Microsoft Edge
                return '<style>
                            #scrollNavegador{
                                overflow:scroll;
                                width:100%;
                                height: 700px;
                            }
                        </style>';
            elseif (strpos($user_agent, 'Trident') !== FALSE) //IE 11
                return '<style>
                            #scrollNavegador{
                                overflow:scroll;
                                width:100%;
                                height: 700px;
                            }
                        </style>';
            elseif (strpos($user_agent, 'Opera Mini') !== FALSE)
                return "";
            elseif (strpos($user_agent, 'Opera') || strpos($user_agent, 'OPR') !== FALSE)
                return "";
            elseif (strpos($user_agent, 'Firefox') !== FALSE)
                return '';
            elseif (strpos($user_agent, 'Chrome') !== FALSE)
                return '';
            elseif (strpos($user_agent, 'Safari') !== FALSE)
                return "";
            else
                return '';
        }

    $navegador = getBrowser($user_agent);

        echo "".$navegador;

    ?>
    
    <title>visualizar</title>
    <body  class="body">
         <?php 
        $oportunidad = ver( $id , $db);
        ?>
        <div id="pageContainer">
            <fieldset>
                <legend>&nbsp;Evidencias - Oportunidades </legend>  
                <div id="scrollNavegador">   <br>
                        <p align="center">Evidencia por oportunidades</p><br>
                        <div width="98%">
                        <div><p><strong>Nombre : </strong>  <?php echo $oportunidad["nombre"]?></p></div>
                        <div><p><strong>Tipo de oportunidad : </strong> <?php echo $oportunidad["tipo"]?></p></div>
                        <div><p><strong>Valoración : </strong> 
                            <?php $valoracion=$oportunidad["Valoracion"];
                                    if( $valoracion < 26 ){
                                        echo "Bajo";
                                    }else if( $valoracion > 25 and $valoracion < 51 ){
                                        echo "Medio";
                                    }else if($valoracion > 50 and $valoracion < 76){
                                        echo "Alto";
                                    }else if($valoracion > 76 ){
                                        echo "Muy alto";
                                    }
                            ?>
                            </p>
                        </div>
                        <div style="text-align:right"><p  style="text-align:rigth"><a href="modificarAvance.php?id=<?php echo $id?>" class="btn btn-success" id="modificarAvance">Modificar avance</a>&nbsp;
                        <?php
                            /*@modfied Diego Rivera <riveradiego>
                             *Se cambia limite de envidencias de 10 a 50 (caso aranda 108343 )
                             *@since December 18,2018   
                             */
                            if($numeroEvidencias["evidencias"]<=50){
                        ?>
                            <a href="#" class="btn btn-danger" attr-accion="registrarEvidencia" attr-id="<?php echo $id?>" id="agregarEvidencia">Agregar evidencia</a></p></div><br>
                        <?php }?>
                        </div>
                        <table cellspacing="0" cellpadding="0" align="center" width="98%" border="1">
                            <tbody>
                                <tr bgcolor="#2964B1">
                                    <td style="border:#FFF solid 1px; color:#FFF" align="center" ><strong>N°.</strong></td>
                                    <td style="border:#FFF solid 1px; color:#FFF" align="center" ><strong>Nombre archivo</strong></td>
                                    <td style="border:#FFF solid 1px; color:#FFF" align="center" ><strong>Nombre de la evidencia</strong></td>
                                    <td style="border:#FFF solid 1px; color:#FFF" align="center" ><strong>Fecha de carga</strong></td>
                                    <td style="border:#FFF solid 1px; color:#FFF" align="center" ><strong>Fecha de Modificacion</strong></td>
                                    <td style="border:#FFF solid 1px; color:#FFF" align="center" ><strong>Opcion</strong></td>
                                </tr>
                            </tbody>
                            <?php 
                                $evidencia = verEvidencia($id ,$db);
                                $numerador=1;
                                foreach ($evidencia as $evidencias ){
                            ?>
                             <tr>
                                <td><?php echo $numerador; ?></td>
                                <td><?php echo $evidencias["nombre"]?></td>
                                <td><?php echo $evidencias["descripcion"]?></td>
                                <td><?php echo $evidencias["fechacreacion"]?></td>
                                <td><?php echo $evidencias["fechamodificacion"]?></td>
                                <td style="text-align:center">
                                    <a href="<?php echo $evidencias["Ubicacion_url"].$evidencias["nombre"]?>" download>
                                        <i class="fa fa-download"></i>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a href="#" class="modificar" attr-id="<?php echo $evidencias["idsiq_evidenciaoportunidad"] ?>">
                                        <i class="fa fa-edit"></i>
                                    </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <?php
                                        if($numeroEvidencias["evidencias"]>1){
                                    ?>
                                    <a href="#" class="eliminar" attr-id="<?php echo $evidencias["idsiq_evidenciaoportunidad"] ?>" attr-idOportunidad ="<?php echo $id;?>">
                                        <i class="fa fa-remove"></i>
                                    </a> 
                                    <?php 
                                        }
                                    ?>
                                </td>
                            </tr>
                                <?php
                                    $numerador++;
                                }
                                ?>
                        </table>
                        <center><br>
                        <a href="emergente.php?idsiq_estructuradocumento=<?php echo $idsiq_estructuradocumento;?>&idsiq_factor=<?php echo $idsiq_factor ?>&tp=<?php echo $tp?>" class="btn btn-default">Regresar</a>

                        </center>
                        <br><br><br><br><br>
                </div>
            </fieldset>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title" id="tituloModal"></h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>


