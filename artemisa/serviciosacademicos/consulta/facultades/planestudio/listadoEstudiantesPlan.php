<?php
    session_start();
    include_once('../../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION); 

//session_start(); 
 
    $ruta = "../";
    while (!is_file($ruta.'Connections/sala2.php'))
    {
        $ruta = $ruta."../";
    }
    require_once($ruta.'Connections/sala2.php');
    $rutaado = $ruta."funciones/adodb/";
    require_once($ruta.'Connections/salaado.php');
    
    //global $db; 
    
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <!--<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">-->
        <title>Estudiantes en el Plan 092</title>
        <link rel="stylesheet" href="../../../mgi/css/normalize.css" type="text/css" />  
        <link rel="stylesheet" href="../../../css/themes/smoothness/jquery-ui-1.8.4.custom.css" type="text/css" /> 
        <link rel="stylesheet" href="../../../mgi/css/style.css" type="text/css"  media="screen, projection" /> 
        <style>
            div#pageContainer{
                margin: 30px 50px;
            }

            table{
                font-size: 0.95em;
            }

            table th, table td{
                border: 1px solid #98BF21;
                padding: 4px 10px 3px;
            }

            tfoot tr td.title{
                font-weight: bold;
            }

            table tr.dataColumns th, table tr#totalColumns td, table tr#contentColumns th{
                background-color: #90A860;
            }

            table tr.contentColumns th.category, table tr.contentColumns td.category{
                /*background-color: #C0D890;*/
                background-color: #D8D8C0;
            }

            table tr.dataColumns th span{
                color: #000;
                background-color: transparent;
                border:0;
            }

            th.right{
                text-align:right;
            }

            table td.center{
                text-align:center;
            }
        </style>
        
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery.js"></script>
        <script type="text/javascript" language="javascript" src="../../../mgi/js/jquery-ui-1.8.21.custom.min.js"></script>   
    </head>
    <body>
        <div id="pageContainer">
            <h4>Estudiantes en el Plan 092 de Psicología que no han tomado la asignatura Métodos de Investigación II ((Experimental y Caso Único)</h4>
            <table style="margin-top:10px;">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Documento</th>
                        <th>Carrera</th>
                        <th>Correo Electrónico</th>
                        <th>Semestre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT semestre,e.codigoestudiante, eg.* FROM sala.planestudioestudiante pe 
                        INNER JOIN estudiante e ON pe.codigoestudiante=e.codigoestudiante 
                        AND e.codigosituacioncarreraestudiante NOT IN (109,400,500)
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                            WHERE pe.idplanestudio IN (451,494) AND pe.codigoestadoplanestudioestudiante!=200 AND pe.codigoestudiante NOT IN (
                            SELECT p.codigoestudiante FROM sala.prematricula p 
                            INNER join detalleprematricula dp ON dp.idprematricula=p.idprematricula
                            WHERE dp.codigomateria IN (11975) AND p.codigoestadoprematricula NOT IN (21,42)) ORDER BY semestre ASC";
                    $estudiantes = $db->GetAll($sql); 
                    foreach ($estudiantes as $estudiante) {  
                            $sql = "SELECT c.* FROM sala.planestudioestudiante pe 
                                    INNER JOIN planestudio p ON p.idplanestudio=pe.idplanestudio 
                                    INNER JOIN carrera c ON c.codigocarrera=p.codigocarrera 
                                    WHERE pe.codigoestudiante='".$estudiante["codigoestudiante"]."' AND pe.codigoestadoplanestudioestudiante!=200";
                            $carreras = $db->GetAll($sql); 
                            $carrera = "";
                            foreach ($carreras as $row) {  
                                if($carrera===""){
                                    $carrera = $row["nombrecarrera"];
                                } else {
                                    $carrera = "<br/>".$row["nombrecarrera"];
                                }
                            }
                            
                            $sql = "SELECT * from usuario 
                                        WHERE numerodocumento='".$estudiante["numerodocumento"]."' AND codigotipousuario=600";
                            $usuarios = $db->GetAll($sql); 
                            $correo = "";
                            foreach ($usuarios as $row) {  
                                if($correo===""){
                                    $correo = $row["usuario"]."@unbosque.edu.co";
                                } else {
                                    $correo = "<br/>".$row["usuario"]."@unbosque.edu.co";
                                }
                            }
                            //si no tiene usuario es que no acabo el proceso de matriculas
                            if($correo!==""){
                        ?>
                        <tr>
                            <td class="center"><?php echo $estudiante["nombresestudiantegeneral"]." ".$estudiante["apellidosestudiantegeneral"]; ?></td>
                            <td class="center"><?php echo $estudiante["numerodocumento"]; ?></td>
                            <td class="center"><?php echo $carrera; ?></td>
                            <td class="center"><?php echo $correo; ?></td>
                            <td class="center"><?php echo $estudiante["semestre"]; ?></td>
                        </tr>                    
                        <?php  } } ?>
                </tbody>
            </table>
            
            <h4>Estudiantes en el Plan 092 de Psicología que tomaron la asignatura Métodos de Investigación II ((Experimental y Caso Único) pero no la han aprobado</h4>
            <table style="margin-top:10px;">
                <thead>
                    <tr>
                        <th>Estudiante</th>
                        <th>Documento</th>
                        <th>Carrera</th>
                        <th>Correo Electrónico</th>
                        <th>Semestre</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $sql = "SELECT semestre,e.codigoestudiante, eg.* FROM sala.planestudioestudiante pe 
                        INNER JOIN estudiante e ON pe.codigoestudiante=e.codigoestudiante 
                        AND e.codigosituacioncarreraestudiante NOT IN (109,400,500)
                        INNER JOIN estudiantegeneral eg ON eg.idestudiantegeneral=e.idestudiantegeneral
                            WHERE pe.idplanestudio IN (451,494) AND pe.codigoestadoplanestudioestudiante!=200 
                            AND pe.codigoestudiante IN (
                            SELECT p.codigoestudiante FROM sala.prematricula p 
                            INNER join detalleprematricula dp ON dp.idprematricula=p.idprematricula
                            WHERE dp.codigomateria IN (11975) AND p.codigoestadoprematricula NOT IN (21,42)) AND pe.codigoestudiante NOT IN (
                            SELECT n.codigoestudiante FROM sala.notahistorico n where n.codigomateria=11975 
                            AND n.notadefinitiva>=3 AND n.codigoestadonotahistorico=100 )                            
                            ORDER BY semestre ASC";
                    $estudiantes = $db->GetAll($sql); 
                    foreach ($estudiantes as $estudiante) {  
                            $sql = "SELECT c.* FROM sala.planestudioestudiante pe 
                                    INNER JOIN planestudio p ON p.idplanestudio=pe.idplanestudio 
                                    INNER JOIN carrera c ON c.codigocarrera=p.codigocarrera 
                                    WHERE pe.codigoestudiante='".$estudiante["codigoestudiante"]."' AND pe.codigoestadoplanestudioestudiante!=200";
                            $carreras = $db->GetAll($sql); 
                            $carrera = "";
                            foreach ($carreras as $row) {  
                                if($carrera===""){
                                    $carrera = $row["nombrecarrera"];
                                } else {
                                    $carrera = "<br/>".$row["nombrecarrera"];
                                }
                            }
                            
                            $sql = "SELECT * from usuario 
                                        WHERE numerodocumento='".$estudiante["numerodocumento"]."' AND codigotipousuario=600";
                            $usuarios = $db->GetAll($sql); 
                            $correo = "";
                            foreach ($usuarios as $row) {  
                                if($correo===""){
                                    $correo = $row["usuario"]."@unbosque.edu.co";
                                } else {
                                    $correo = "<br/>".$row["usuario"]."@unbosque.edu.co";
                                }
                            } 
                        
                        ?>
                        <tr>
                            <td class="center"><?php echo $estudiante["nombresestudiantegeneral"]." ".$estudiante["apellidosestudiantegeneral"]; ?></td>
                            <td class="center"><?php echo $estudiante["numerodocumento"]; ?></td>
                            <td class="center"><?php echo $carrera; ?></td>
                            <td class="center"><?php echo $correo; ?></td>
                            <td class="center"><?php echo $estudiante["semestre"]; ?></td>
                        </tr>                  
                        <?php  } ?>
                </tbody>
            </table>
            </div>
    </body>
</html>