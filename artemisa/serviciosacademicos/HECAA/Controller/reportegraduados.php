<?php   
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');
    include_once (realpath(dirname(__FILE__)).'/../funciones/funciones.php');
    $funciones = new funcionesMatriculas();
    include_once (realpath(dirname(__FILE__)).'/../../utilidades/ValidacionesTipoDocumento.php');
    $validaciones = new validacionesDocumento();

    include_once(realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $usuario = $_SESSION['usuario'];

    $codigoperiodo = $_POST['periodo'];
    $contador = '0';

    if($codigoperiodo)
    {
        $anio = substr($codigoperiodo, 0, -1);
        $periodo = substr($codigoperiodo, 4, 1);
        
        //definicion de los titulos del reporte
        $html1 = "Error,Programa,Año,Semestre,Tipo_Documento,Numero_Documento,Pro_consecutivo,municipio,email_personal,telefono,saber_pro,numero_acta,fecha_grado,numero_folio\r\n";
        $htmlregistro ='';
        
        $fecha = date("Y-m-d");
        //Consulta de los estudiantes inscritos
        $graduados = $funciones->Graduados($db, $codigoperiodo);                                
        if(!empty($graduados))
        {
            foreach($graduados as $valores)
            {
                $codigoestudiante = $valores['codigoestudiante'];
                //consulta de los datos del estudiante
                $datosestudiante = $funciones->Infoparticipante($db, $codigoestudiante);                             
                  
                $tipodoc = $datosestudiante['TipoDocumento'];
                $numerodoc = $datosestudiante['numerodocumento'];
                $genero = $datosestudiante['Genero'];
                
                if($valores['telefono'])
                {
                     $numerotelefono =strlen($valores['telefono']);
                    if($numerotelefono < 7)
                    {
                        $resta = 7-$numerotelefono;
                        for($i=0;$i<$resta;$i++)
                        {
                            $valores['telefono'] = $valores['telefono']."0";            
                        }
                    }
                }else
                {
                    $valores['telefono'] = "6489000";
                }
                
                if($valores['codigomodalidadacademica']==200)
                {
                    $valores['icfes'] = trim($valores['icfes']);
                    if($valores['icfes'])
                    {                        
                        $tamano = strlen($valores['icfes']);                        
                        if($tamano < 14)
                        {                          
                            $Error="Error de icfes faltan digitos"; 
                            $carrera = $valores['nombrecarrera'];
                        }
                    }else
                    {
                        $Error="Error de icfes es obligatorio para pregrado";
                        $carrera = $valores['nombrecarrera'];
                    }
                }
            
                if($numerodoc != '')
                {
                    //validacion de los datos del estudiante
                    $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);
                    $validacion['programa'] = sanear_string($validacion['programa']);
                    //asignacion de los datos del estudiante a ala variable de muestras.
                  
                   $validacion['Error'].=$Error;
                   if(!$validacion['programa']){$validacion['programa'] = $carrera; }
                $htmlRegistro.=$validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$valores['numerodocumento'].",".$valores['pro'].",".$valores['ciudad'].",".$valores['email'].",".$valores['telefono'].",".$valores['icfes'].",".$valores['acta'].",".$valores['fecha_acta'].",".$valores['folio']."\r\n";    
                    $contador++;
                }
                $Error="";
                $carrera="";
            }//foreach incritos
        }
        //crear el registro del log de reportes
       $funciones->logReporte($db, "Graduados", $usuario, $contador, $codigoperiodo);
        
        $html = $html1.$htmlRegistro;
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Reporte_Graduados_".$codigoperiodo.".csv");// Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        echo $html;
    }
?>