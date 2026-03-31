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
        
        $html1 = "Error,programa,Año,Semestre,Tipo_Documento,Numero_Documento,pro_consecutivo,municipio_programa,vinculacion,grupo_ectnico,pueblo_indigena,comunidad_negra,discapacitados,tipo_discapacitado,capacidad_excepcional,prueba_saber_pro_11\r\n";
        $htmlregistro ='';
        
        $fecha = date("Y-m-d");
        
        $primercurso = $funciones->primercurso($db,$codigoperiodo, $fecha);
        if(is_array($primercurso))
        {                
            foreach ($primercurso as $valor)
            {
                $codigoestudiante =  $valor['codigoestudiante'];
                if($valor['numeroregistrocarreraregistro'])
                {
                     $pro_consecutivo = $valor['numeroregistrocarreraregistro'];    
                }
                else
                {
                    $pro_consecutivo=0;
                }
                
                
                $datosEstudiante = $funciones->infoprimercurso($db,$codigoestudiante);
                
                $tipodoc = $datosEstudiante['tipodocumento'];
                $numerodoc = $datosEstudiante['numerodocumento'];
                $genero = $datosEstudiante['Genero'];

                if($numerodoc != '')
                {
                    //validaciones de campos para tipos de numeros de identifiacion
                    $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);

                    if($datosEstudiante['idciudad'] == 0)
                    {
                       $datosEstudiante['idciudad'] == '11001'; 
                    }
                    if($validacion['TipoDocumento'] == 'TI' || $validacion['TipoDocumento'] == 'CC')
                    {
                        if(!$datosEstudiante['icfes'])
                        {
                           $validacion['Error'].= "Es obligatorio el numero icfes"; 
						   $datosEstudiante['icfes'] = "AC200000000000";
                        }
                    }
                    if(!$datosEstudiante['idestudianteestudio'])
                    {
                        $validacion['Error'].= "No existe en estudianteestudio";   
                        $validacion['programa'].= $valor['nombrecarrera'];
                    }
					//no se tiene el detalle del grupo etnico todavia entonces no se puede reportar
					if($datosEstudiante['GrupoEtnicoId']==1){
						$datosEstudiante['GrupoEtnicoId']=4;
					}
                     //$htmlRegistro.=$validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$numerodoc.",".$pro_consecutivo.",".$datosEstudiante['idciudad'].",".$datosEstudiante['VinculacionId'].",".$datosEstudiante['GrupoEtnicoId'].",0,0,0,0,0,".$datosEstudiante['icfes']."\r\n";  
                    
					/*
					 * @modified David Perez <perezdavid@unbosque.edu.co>
					 * @since  Enero 18, 2018
					 * Por solicitud de evaluación y planeacion se pone como dato estandar el 11001 en el municipio.
					*/
					
					$htmlRegistro.=$validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$numerodoc.",".$pro_consecutivo.",11001,".$datosEstudiante['VinculacionId'].",".$datosEstudiante['GrupoEtnicoId'].",0,0,0,0,0,".$datosEstudiante['icfes']."\r\n";  
                    $contador++;
                }
            }//foraech matriculas  
             //crear el registro del log de reportes
           //$funciones->logReporte($db, "Primer Curso", $usuario, $contador, $codigoperiodo);
        }        
        
        $html = $html1.$htmlRegistro;
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Reporte_Primer_Curso_".$codigoperiodo.".csv");// Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        echo $html;
    }
?>