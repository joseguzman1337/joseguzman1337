<?php 

    @error_reporting(1023); // NOT FOR PRODUCTION SERVERS!
    @ini_set('display_errors', '1'); // NOT FOR PRODUCTION SERVERS!

    if(!defined("HTTP_ROOT")){
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode("/serviciosacademicos", $actual_link);
        define("HTTP_ROOT", $actual_link[0]);
    }
    if(!defined("PATH_ROOT")){
        //Definimos el root del http
        $actual_link = getcwd();
        $actual_link = explode("/serviciosacademicos", $actual_link);
        define("PATH_ROOT", $actual_link[0]);
    }

    require(PATH_ROOT.'/serviciosacademicos/Connections/sala2.php');
    $sala2 = $sala;
    $rutaado = PATH_ROOT."/serviciosacademicos/funciones/adodb/";
    require_once(PATH_ROOT.'/serviciosacademicos/Connections/salaado.php');

    $variables = $_REQUEST['action'];        

    if($variables)
    {
        switch($variables)
        {
            case 'carreras':
            {
                $sqlcarreras = "select codigocarrera, nombrecarrera from carrera where codigomodalidadacademica = 200 ORDER BY nombrecarrera";
                $datos = $db->GetAll($sqlcarreras);
                $html ="";
                
                foreach($datos as $valores)
                {
                    $html.= "<option value='".$valores['codigocarrera']."'>".$valores['nombrecarrera']."</option>";
                }
                echo $html;
            }
            break;
            case 'periodos':
            {
                $sqlperiodo = "select codigoperiodo, nombreperiodo from periodo ORDER BY codigoperiodo desc";
                $datos = $db->GetAll($sqlperiodo);
                $html ="";
                
                foreach($datos as $valores)
                {
                    $html.= "<option value='".$valores['codigoperiodo']."'>".$valores['nombreperiodo']."</option>";
                }
                echo $html;
            }
            break;
            case 'consultacanceladas':
            {
                if(isset($_POST['carrera']) && $_POST['carrera'] <> '1' )
                {
                    $carrera = " and eci.codigocarrera = '".$_POST['carrera']."'";    
                }else
                {
                    $carrera = "";
                }
                
                if(isset($_POST['periodo']))
                {
                    $periodo = " and i.codigoperiodo = '".$_POST['periodo']."'";    
                }else
                {
                    $periodo = "";
                }
                
                if(isset($_POST['estado']))
                {
                    $estado = " and i.codigoperiodo = '".$_POST['estado']."'";    
                }else
                {
                    $estado = "";
                }

                $contador = 0;
                $sqlcanceladas = "SELECT                                    
                                    et.FechaEntrevista,
                                    et.HoraInicio,
                                    et.HoraFin,
                                    aen.FechaUltimaModificacion,
                                    sae.NombreSalonEntrevistas,
                                    aen.Observacion,
                                    eg.numerodocumento, 
                                    eg.nombresestudiantegeneral,
                                    eg.apellidosestudiantegeneral,
                                    c.codigocarrera,
                                    c.nombrecarrera,
                                    aen.EstadoAsignacionEntrevista                                        
                                FROM
                                    AsignacionEntrevistas aen
                                INNER JOIN Entrevistas et ON ( aen.EntrevistaId = et.EntrevistaId )
                                INNER JOIN estudiantecarrerainscripcion eci ON ( aen.IdEstudianteCarreraInscripcion = eci.idestudiantecarrerainscripcion 	AND eci.idnumeroopcion = 1 )
                                INNER JOIN carrera c ON ( eci.codigocarrera = c.codigocarrera )
                                INNER JOIN CarreraSalones cs ON ( et.CarreraSalonId = cs.CarreraSalonId )
                                INNER JOIN SalonEntrevistas sae ON ( cs.SalonEntrevistasId = sae.SalonEntrevistasId )
                                INNER JOIN inscripcion i ON ( eci.idinscripcion = i.idinscripcion )
                                INNER JOIN estudiantegeneral eg on (eci.idestudiantegeneral = eg.idestudiantegeneral)
                                WHERE
                                    aen.EstadoAsignacionEntrevista = 300
                                    ".$carrera." ".$periodo." ".$estado."
                                    GROUP BY aen.IdEstudianteCarreraInscripcion";
                                
                $resultados = $db->GetAll($sqlcanceladas);
                $html ="";
                foreach($resultados as $listado)
                {
                    $contador++;
                    $html.= "<tr>
                            <td>".$contador."</td>
                            <td>".$listado['nombresestudiantegeneral']."</td>
                            <td>".$listado['apellidosestudiantegeneral']."</td>
                            <td>".$listado['nombrecarrera']."</td>
                            <td>".$listado['Observacion']."</td>
                            <td>".$listado['FechaUltimaModificacion']."</td>
                            <td>".$listado['EstadoAsignacionEntrevista']."</td>
                            </tr>";   
                }
                echo $html;
            }
            break;
        }
    }
    
?>