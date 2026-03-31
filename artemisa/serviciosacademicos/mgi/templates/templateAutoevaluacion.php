<?php
    session_start();
    function writeHeader($title, $bd=false, $proyecto="") {
        
    //verifica la sesión del usuario, no se puede con todos... si acaso agregar un parametro por defecto en false
    /*$ruta = "../";
    while (!is_file($ruta.'utilidades/ValidarSesion.php'))
    {
        $ruta = $ruta."../";
    }
    require_once ($ruta.'utilidades/ValidarSesion.php');
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/

    if($bd){
        $db = writeHeaderBD();
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $title; ?></title>
        <style type="text/css" title="currentStyle">
                @import "../../../css/demo_page.css";
                @import "../../../css/demo_table_jui.css";
                @import "../../../css/demos.css";
                @import "../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css";
                @import "../../../css/jquery-ui.css";
                @import "../../css/styleAutoevaluacion.css";
                @import "../../css/jquery-ui-timepicker-addon.css";
        </style>
       <script type="text/javascript" language="javascript" src="../../js/jquery.js"></script>
       <!--<script type="text/javascript" language="javascript" src="../../js/jquery-3.6.0.js"></script>-->
        <script type="text/javascript" language="javascript" src="../../js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/jquery-ui-1.8.21.custom.min.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/jquery.fastLiveFilter.js"></script>
        <script type="text/javascript" language="javascript" src="../../js/functionsAutoevaluacion.js"></script>  
        <script type="text/javascript" language="javascript" src="../../js/jquery-ui-timepicker-addon.js"></script>
        <script src="../../js/nicEdit-latest.js" type="text/javascript"></script>
       <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-WWDFF92');</script>
        <!-- End Google Tag Manager -->
</head>
    <body id="dt_example">
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-WWDFF92"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <div>
<?php if($bd){ return $db; } }

function writeFooter() { ?>
       </div>
    </body>
</html>
<?php } 


function writeHeaderBD() { 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    $ruta = "../";
    while (!is_file($ruta.'monitoreo/class/Utils_monitoreo.php'))
    {
        $ruta = $ruta."../";
    }
    require_once ($ruta.'monitoreo/class/Utils_monitoreo.php');
    
    $ruta = "../";
    while (!is_file($ruta.'API_Monitoreo.php'))
    {
        $ruta = $ruta."../";
    }
    require_once ($ruta.'API_Monitoreo.php');
    
    return $db;
}

function writeHeaderSearchs() {     
    return writeHeaderBD();
}

function ver_preguntas($id_pregunta){
    //echo "hola";
            if (!empty($id_pregunta)){
                $entity = new ManagerEntity("Apregunta");
                $entity->sql_where = "idsiq_Apregunta = $id_pregunta";
            // $entity->debug = true;
                $data = $entity->getData();
                $data =$data[0];
            // print_r($data);
            }
            $tipo=$data['idsiq_Atipopregunta'];
            echo $data['titulo'];
            echo "<br>";

                $entity2 = new ManagerEntity("Apreguntarespuesta");
                $entity2->sql_where = "idsiq_Apregunta ='".$id_pregunta."' and codigoestado=100 ";
                // $entity2->debug = true;
                $data2 = $entity2->getData();
                //print_r($data2);
                if ($tipo==1){
                    $i=0;
                    echo "<table border=0>";
                    echo "<tr>";
                        foreach($data2 as $c => $v){
                            
                            $re=trim($v['respuesta']);
                             echo '<td width="80px"  valign="top"><center>'.$re.'</center><br></td>';
                            $i++;
                            
                        }
                        echo "</tr>";
                         echo "<tr>";
                        $i=0;
                        foreach($data2 as $c => $v){
                            $ur=$v['unica_respuesta'];
                            $mr=$v['multiple_respuesta'];
                            $re=trim($v['respuesta']);
                            if ($ur==1){
                                echo '<td width="80px"  valign="top"><center><input type="radio" name="valor" id="valor_'.$i.'" /></center></td>';
                            }
                            if ($mr==1){
                                echo '<td width="80px"  valign="top"><center><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" /></center></td>';
                            }

                            $i++;
                        }
                         echo "</tr>";
                    echo "</table>";
                }
                if ($tipo==2){
                    $i=0;
                    echo "<table border=0>";
                        echo "<tr>";
                        foreach($data2 as $c => $v){
                            $ur=$v['unica_respuesta'];
                            $mr=$v['multiple_respuesta'];
                            $ti=$v['texto_inicio'];
                            $tf=$v['texto_final'];
                            if ($i==0) echo "<td>".$ti."</td>";
                            $re=trim($v['respuesta']);
                            if ($ur==1){
                                echo '<td width="15px"><center><input type="radio" name="valor" id="valor_'.$i.'" /></center></td>';
                            }
                            if ($mr==1){
                                echo '<td width="15px"><center><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" /></center></td>';
                            }

                            $i++;
                        }
                        echo "<td>".$tf."</td>";
                        echo "</tr>";
                    echo "</table>";
                }
                if ($tipo==3){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $re=trim($v['respuesta']);
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                    }
                    echo "</table>";

                }
                if ($tipo==4){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $re=trim($v['respuesta']);
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                if ($tipo==5){
                    foreach($data2 as $c => $v){
                            $mc=$v['maximo_caracteres'];
                            echo '<td><input type="textbox" name="valor" id="valor" value="" maxlength="'.$mc.'" /></td>';
                    }
                }
                if ($tipo==6){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $re=trim($v['respuesta']);
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                    }
                    echo "</table>";
                }
                if ($tipo==8){
                    $i=0;
                    echo "<table border=0>";
                    foreach($data2 as $c => $v){
                        echo "<tr>";
                        $ur=$v['unica_respuesta'];
                        $mr=$v['multiple_respuesta'];
                        $an=$v['analisis'];
                        $re=trim($v['respuesta']);
                            if ($i==0){
                                echo "<td>".$an."</td></tr><tr>";
                            }
                        if ($ur==1){
                                echo '<td><input type="radio" name="valor" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                            if ($mr==1){
                                echo '<td><input type="checkbox" name="valor['.$i.']" id="valor_'.$i.'" />'.$re.'</td>';
                            }
                        echo "</tr>";
                        $i++;
                    }
                    echo "</table>";
                }
    }

?>