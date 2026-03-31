<?php   
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);

    include(realpath(dirname(__FILE__)).'/../../utilidades/funcionesTexto.php');
    include_once(realpath(dirname(__FILE__)).'/../funciones/funciones.php');
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
        //Consulta de los estudiantes
        $datosEstudiantes = $funciones->DatosParticipantes($db,$codigoperiodo);     
        $cantidad = count($datosEstudiantes);     
        
        //creacion de los titulos del reporte
        $html1 = "Error,Programa,Tipo Documento,Numero Documento,Fecha de Expedicion,Primer nombre, Segundo nombre,Primer Apellido,Segundo Apellido,Genero,Estado Civil,Fecha Nacimiento,Pais,Municipio,Telefono Contacto,Email Personal,Email Institucional,Dirreccion\r\n";
        
        foreach($datosEstudiantes as $estudiante)
        {
            $codigoestudiante = $estudiante['codigoestudiante'];
            //Consulta de los datos del estudiante
            $listaestudiantes = $funciones->Infoparticipante($db,$codigoestudiante);
            
            $tipodoc = $listaestudiantes['TipoDocumento'];                      
            $numerodoc = $listaestudiantes['numerodocumento'];
            $genero = $listaestudiantes['Genero'];
            
            if($numerodoc != '')
            {
                //saneamiento de las variables de nombres
                $primernombre = sanear_string($listaestudiantes['PRIMER_NOMBRE']);
                $listaestudiantes['PRIMER_NOMBRE'] = $primernombre;
                $segundonombre = sanear_string($listaestudiantes['SEGUNDO_NOMBRE']);
                $listaestudiantes['SEGUNDO_NOMBRE'] = $segundonombre;
                $primerapellido = sanear_string($listaestudiantes['PRIMER_APELLIDO']);
                $listaestudiantes['PRIMER_APELLIDO'] = $primerapellido;
                $segundoapellido = sanear_string($listaestudiantes['SEGUNDO_APELLIDO']);
                $listaestudiantes['SEGUNDO_APELLIDO'] = $segundoapellido;
                $html ='';
                
                //validaciones de campos para tipos de numeros de identifiacion
                $validacion = $validaciones->ValidacionDatos($db,$tipodoc,$genero,$numerodoc);
                $validacion['programa'] = sanear_string($validacion['programa']);
                
                $validacion['programa'] = sanear_string($validacion['programa']);
                //Si la fecha de expedicion del documento esta en ceros o no esta
                if($listaestudiantes['FechaDocumento'] == '00-00-0000' || $listaestudiantes['FechaDocumento'] == '')
                {
                    if($tipodoc == '01')
                    {
                        $anio = '19';
                        $fecha =$listaestudiantes['FECHA_NACIM'];
                        list($day,$mon,$year) = explode('-',$fecha);
                        $listaestudiantes['FechaDocumento'] =  date('d/m/Y',mktime(0,0,0,$mon,$day,$year+$anio)); 
                    }else if($tipodoc == '02')
                    {
                        $listaestudiantes['FechaDocumento']= '';
                    }
                }
				//limpia la fecha de expedicion para los de tarjeta de identidad
				if($tipodoc == '02'){
					$listaestudiantes['FechaDocumento']= '';
				}
				//limpia la fecha de expedicion para los de tarjeta de identidad
				if($tipodoc == '01'){
					$datetime1 = strtotime($listaestudiantes['FECHA_NACIM']);
					$datetime2 = strtotime($listaestudiantes['FechaDocumento']);

					$secs = $datetime2 - $datetime1;// == <seconds between the two times>
					$days = $secs / 86400;
					$years = $secs / 365;
					if($years<18){
                        $anio = '19';
                        $fecha =$listaestudiantes['FECHA_NACIM'];
                        list($day,$mon,$year) = explode('-',$fecha);
                        $listaestudiantes['FechaDocumento'] =  date('d/m/Y',mktime(0,0,0,$mon,$day,$year+$anio)); 
					}
				}
                if($listaestudiantes['Telefono'])
                {
                    //limpia el campo de cualquier carracter tipo alfabetico y solo deja los numeros
                    $listaestudiantes['Telefono'] = intval(preg_replace('/[^0-9-]+/', '', $listaestudiantes['Telefono']), 10); 
                    
                    $listaestudiantes['Telefono'] = trim($listaestudiantes['Telefono']);
                    $telefono = explode('-',$listaestudiantes['Telefono']);
                    if(is_array($telefono))
                    {
                        $numero = strlen($telefono[0]);
                        if($numero <= 3)
                        {
                            $listaestudiantes['Telefono'] = $telefono[1];    
                        }else
                        {
                            $listaestudiantes['Telefono'] = $telefono[0];    
                        }                        
                    }
                }
                //si el pais es diferente a colombia = 170
                if($listaestudiantes['Pais'] != '170')
                {
                    if($listaestudiantes['ciudad'])
                    {   
                        $listaestudiantes['ciudad']= '';
                    }
                }else
                {
                    //si la ciudad es cero se cambia a bogota = 110001 o en caso de extranjeros 11001
                    if($listaestudiantes['ciudad']== '0')
                    {   
                        $listaestudiantes['ciudad']= '11001';
                    }
                }
                //Si el email es "sin asginar" se cambia a vacio
                if($listaestudiantes['EmailPersonal']== 'SIN ASIGNAR')
                {
                    $listaestudiantes['EmailPersonal']='';
                }
                //se asgna el usuario como email.
                if($listaestudiantes['usuario'])
                {
                   $listaestudiantes['usuario'] = $listaestudiantes['usuario']."@unbosque.edu.co";
                }
               
               //definciin de las variables a mostrar
                $htmlRegistro=$validacion['Error'].",".$validacion['programa'].",".$validacion['TipoDocumento'].",'".$numerodoc.",".$listaestudiantes['FechaDocumento'].",".$listaestudiantes['PRIMER_NOMBRE'].",".$listaestudiantes['SEGUNDO_NOMBRE'].",".$listaestudiantes['PRIMER_APELLIDO'].",".$listaestudiantes['SEGUNDO_APELLIDO'].",".$listaestudiantes['Genero'].",".$listaestudiantes['EstadoCivil'].",".$listaestudiantes['FECHA_NACIM'].",".$listaestudiantes['Pais'].",".$listaestudiantes['ciudad'].",".$listaestudiantes['Telefono'].",".$listaestudiantes['EmailPersonal'].",".$listaestudiantes['usuario'].",".$listaestudiantes['Dirrecion']."\r\n";
                
                $contador++;    
                
                $html1.= $htmlRegistro;            
            }//if numero documento
        }//foreach 
    }//if  

    //crear el registro del log de reportes
    $funciones->logReporte($db, "Participantes", $usuario, $contador, $codigoperiodo);
       
    header("Content-Type: text/csv");
    header("Content-Disposition: attachment; filename=Reporte_participante_".$codigoperiodo.".csv");// Disable caching
    header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
    header("Pragma: no-cache"); // HTTP 1.0
    header("Expires: 0"); // Proxies

    echo $html1;
?>