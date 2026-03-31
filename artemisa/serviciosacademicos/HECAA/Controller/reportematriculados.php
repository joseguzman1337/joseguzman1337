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

    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();
    
    $usuario = $_SESSION['usuario'];

    $contador = '0';
    $codigoperiodo = $_POST['periodo'];
    
    //encabezado de los campos del documento
    $html1 = "Error,programa,Año,Semestre,Tipo_Documento,Numero_Documento,Codigo_Estudiante,Pro_consecutivo,ID_municipio,Fecha_Nacimiento,ID_Pais_Nacimiento,ID_Municipio_Nacimiento,ID_Zona_Residencia,Es_Reintegro\r\n";  

    if($codigoperiodo)
    {
        $anio = substr($codigoperiodo, 0, -1);
        $periodo = substr($codigoperiodo, 4, 1);
        
        $fecha = date("Y-m-d");
        //lista de materias activas
        $sqlcarreras="SELECT c.codigocarrera, c.nombrecarrera, c.codigomodalidadacademica, cr.*  
                FROM carrera c 
                LEFT JOIN carreraregistro cr ON cr.codigocarrera = c.codigocarrera 
                WHERE c.fechainiciocarrera <= '".$fecha."' 
                AND c.fechavencimientocarrera >= '".$fecha."' 
                AND c.codigocarrera <> '13' AND c.codigocarrera <> '1' 
                AND c.codigomodalidadacademica IN (200,300,600,800,810) 
                AND c.nombrecarrera not LIKE '%CURSO%' ORDER BY c.codigocarrera"; 
        $carreras = $db->GetAll($sqlcarreras);

        foreach($carreras as $carrera)
        {
            if($carrera['codigocarrera']=='')
            {
                $codigocarrera = $carrera[0] ;
            }else
            {
                $codigocarrera = $carrera['codigocarrera'];
            }          
            //lista de estudiantes nuevos matriculados
            $matriculadosnuevos = $funciones->MatriculadosNuevos($db,$codigocarrera,$codigoperiodo);                             
            //lista de estudiantes antiguos matriculados
            $datosmatriculadosantiguos = $funciones->MatriculadosAntiguos($db,$codigocarrera,$codigoperiodo);               
            //listado de estudiantes de reintegro
            $datosmatriculadosreintegro = $funciones->reintegro($db,$codigocarrera,$codigoperiodo);
            
            //pro_consecutivo
            if($carrera['numeroregistrocarreraregistro'])
            {
                $pro_consecutivo = $carrera['numeroregistrocarreraregistro'];
            }
            else
            {
                $pro_consecutivo = '0';
            }
            
            if (is_array($datosmatriculadosantiguos))
            {
                foreach ($datosmatriculadosantiguos as $valor)
                {
                    if($valor['codigoestudiante']!="")
                    {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante']."-N-".$pro_consecutivo;                        
                    }
                }
            }
            if (is_array($matriculadosnuevos))
            {
                foreach ($matriculadosnuevos as $valor)
                {
                    if($valor['codigoestudiante']!="")
                    {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante']."-N-".$pro_consecutivo;                        
                    }
                }
            }
            if (is_array($datosmatriculadosreintegro))
            {
                foreach ($datosmatriculadosreintegro as $valor)
                {
                    if($valor['codigoestudiante']!="")
                    {
                        $resultado[]['codigoestudiante']=$valor['codigoestudiante']."-S-".$pro_consecutivo;                        
                    }
                }
            }
           
        }
        
        foreach($resultado as $listado)
        {
            $datosestudiante = explode("-", $listado['codigoestudiante']);            
            
            $codigoestudiante = $datosestudiante[0];
            $reintegro = $datosestudiante[1];
            $pro_consecutivo = $datosestudiante[2];            
            
            $totaldatos = $funciones->infoestudiante($db,$codigoestudiante); 
                
            $tipodoc = $totaldatos['tipodocumento'];
            $numerodoc = $totaldatos['numerodocumento'];
            $genero = $totaldatos['Genero'];
           
            //validaciones de campos para tipos de numeros de identifiacion
            $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);            
            
            $validacion['programa'] = sanear_string($validacion['programa']);
            $zonapos = strpos($totaldatos['dirrecion'], "VEREDA");            
            if($zonapos)
            {
                $zona ='2'; //rural
            }
            else
            {
                $zona ='1'; //urbana
            }
            if($totaldatos['idciudad'] == "0" && $totaldatos['idpais']==170)
            {
               $totaldatos['idciudad'] = '11001'; 
            } else if($totaldatos['idpais']<>170){
				$totaldatos['idciudad'] = ''; 
			}
            
            /**
             * @modified Vega Gabriel <vegagabriel@unbosque.edu.do>.
             * Se cambia el valor del campo ID_municipio por 11001 ya que es del municipio del programa
             * y no del municipio de nacimiento del estudiante.
             * @since Marzo 8, 2019
             */             
            //asignacion de los datos del estudiante a la variable de html
            $htmlRegistro.= $validacion['Error'].",".$validacion['programa'].",".$anio.",".$periodo.",".$validacion['TipoDocumento'].",'".$numerodoc.",".$totaldatos['codigoestudiante'].",".$pro_consecutivo.",11001,".$totaldatos['FECHA_NACIM'].",".$totaldatos['idpais'].",".$totaldatos['idciudad'].",".$zona.",".$reintegro."\r\n";
            
            $contador++;
        }
        
        //crear el registro del log de reportes
        $funciones->logReporte($db, "Matriculados", $usuario, $contador, $codigoperiodo);
        
        $html = $html1.$htmlRegistro;        
        
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=Reporte_Matriculados_".$codigoperiodo.".csv");// Disable caching
        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
        header("Pragma: no-cache"); // HTTP 1.0
        header("Expires: 0"); // Proxies
        
        echo $html;
    }       
?>