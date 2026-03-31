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
        $html1 = "Error,Programa,Año,Semestre,Tipo_Documento,Numero_Documento,Primer_nombre,Segundo_nombre,Primer_apellido,Segundo_apellido,sexo_biologico\r\n";
        $htmlregistro ='';
        
        $fecha = date("Y-m-d");
        //Consulta de los estudiantes inscritos
        $Inscritos = $funciones->Inscritos($db, $codigoperiodo);
        
        if(!empty($Inscritos))
        {
            foreach($Inscritos as $valores)
            {
                $codigoestudiante = $valores['codigoestudiante'];
                //consulta de los datos del estudiante
                $datosestudiante = $funciones->Infoparticipante($db, $codigoestudiante); 
                $codigocarrera = $carreras['codigocarrera'];                    
                    
                $tipodoc = $datosestudiante['TipoDocumento'];
                $numerodoc = $datosestudiante['numerodocumento'];
                $genero = $datosestudiante['Genero'];

                if($numerodoc != '')
                {
                    //validacion de los datos del estudiante
                    $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);
                    
                    $primernombre = sanear_string($datosestudiante['PRIMER_NOMBRE']);
                    $datosestudiante['PRIMER_NOMBRE'] = $primernombre;
                    $segundonombre = sanear_string($datosestudiante['SEGUNDO_NOMBRE']);
                    $datosestudiante['SEGUNDO_NOMBRE'] = $segundonombre;
                    $primerapellido = sanear_string($datosestudiante['PRIMER_APELLIDO']);
                    $datosestudiante['PRIMER_APELLIDO'] = $primerapellido;
                    $segundoapellido = sanear_string($datosestudiante['SEGUNDO_APELLIDO']);
                    $datosestudiante['SEGUNDO_APELLIDO'] = $segundoapellido;
                   
                    //asignacion de los datos del estudiante a ala variable de muestras.
                    $htmlRegistro.=$validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$datosestudiante['numerodocumento'].",".$datosestudiante['PRIMER_NOMBRE'].",".$datosestudiante['SEGUNDO_NOMBRE'].",".$datosestudiante['PRIMER_APELLIDO'].",".$datosestudiante['SEGUNDO_APELLIDO'].",".$datosestudiante['Genero']."\r\n";     
                    
                    $contador++;
                }               
            }//foreach incritos
        }        
        //crear el registro del log de reportes
        $funciones->logReporte($db, "Inscritos", $usuario, $contador, $codigoperiodo);
        
        $html = $html1.$htmlRegistro;
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Reporte_Inscritos_".$codigoperiodo.".csv");// Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        echo $html;
    }
?>