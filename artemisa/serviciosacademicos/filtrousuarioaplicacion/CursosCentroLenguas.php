<?php
    session_start();
    include_once('../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    include_once ('../EspacioFisico/templates/template.php');
    if(!isset ($_SESSION['MM_Username'])){
            //header('Location: ../../consulta/facultades/consultafacultadesv22.htm');
            echo "No ha iniciado sesión en el sistema";
            exit();
        }
    $db = getBD();
?>
<html>
    <head>
        <meta http-equiv="pragma" content="no-cache"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <title>Reporte de carnetizacion</title><style type="text/css"></style>
    </head>
    <body>
       <div align="center">
            <form name="f1" action="ReporteCentroLenguas.php" method="post">
                <p class="Estilo3">CONSULTAR CURSOS Y ACTIVIDADES ESTUDANTES
                </p>
                <table width="707" border="1" cellpadding="2" cellspacing="1" bordercolor="#003333">
                    
                        <tr><td align="center">             
                            <label>Periodo inicial</label>
                            <?php 
                                $sql2= 'SELECT codigoperiodo FROM periodo ORDER BY codigoperiodo DESC';
                                if($Consulta=&$db->Execute($sql2)===false){
                                    echo 'Error en el SQL de la Consulta....<br><br>'.$sql2;
                                    die;
                                }   
                                $valor_periodo = &$db->Execute($sql2);
                                $datos_periodo =  $valor_periodo->getarray();
                                $totaldatos=count($datos_periodo);
                                if ($totaldatos>0){
                            ?>
                            <select name="codigoperiodoinicial" id="codigoperiodoinicial">
                                <option value=""></option>  
                                <?php
                                    foreach($valor_periodo as $datos){
                                ?>
                                <option value="<?php echo $datos['codigoperiodo'] ?>"><?php echo $datos['codigoperiodo'] ?></option>
                                <?php
                                    }
                                    }
                                ?>
                            </select>
                       <br />
                       </td><td align="center">
                       <label>Periodo final </label>
                       <select name="codigoperiodofinal" id="codigoperiodofinal">
                                <option value=""></option>  
                                <?php
                                    foreach($valor_periodo as $datos){
                                ?>
                                <option value="<?php echo $datos['codigoperiodo'] ?>"><?php echo $datos['codigoperiodo'] ?></option>
                                <?php
                                    }
                                    
                                ?>
                            </select>
                           
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" align="center" class="Estilo1">
                        <input name="buscar" type="submit" value="Buscar">&nbsp;
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </body>
</html>