<?php
    /*
    * Ivan Dario Quintero Rios
    * Modificado 28 diciembre del 2017
    */

    include_once '../Class/NewIscripcionEducacionContinuada_class.php';  
    if($db==null){
        include_once ('../../../../../EspacioFisico/templates/template.php');
        $db = getBD(); 
    }
    
    $tipoOperacion = $_POST['tipoOperacion'];
  
    switch ($tipoOperacion) 
    {
        case 'validacion':
        {
            $estudiante = new Inscripcion();
            $txtNumeroDocumento = $_POST["txtNumeroDocumento"];
            $Tipocurso          = $_POST['Tipocurso'];
            $Curso              = $_POST['Curso'];
            $codigoPeriodo      = $_POST["codigoperiodo"];
            /*0,1,2*/
            if($Tipocurso>='0' && $Tipocurso<='2')
            {
                $Valida = $estudiante->ValidacionCarrera($db,$Curso);
                if($Valida)
                {
                    if($Tipocurso=='1')
                    {
                        //valida Comunidad el Bosque Estudiantes de pre-pos y Docentes
                        $Acceso = $estudiante->ValidadComunidadBosque($db,$txtNumeroDocumento);
                        if($Acceso==2)
                        {
                            $info['val'] = 1;
                            $info['msj'] = 'Estimando usuario usted no pertenece a la comunidad de la Universidad EL Bosque.';
                            echo json_encode($info);
                            exit;
                        }
                        else
                        {
                            //cuando el estudiante o dcocente pertenece a la universidad
                            $info['val'] = 2;
                            echo json_encode($info);
                            exit;
                        }
                    }
                    else
                    {
                        //cuando el usuario es apto para el curso
                        $info['val'] = 0;
                        echo json_encode($info);
                        exit;
                    }
                }
                else
                {
                    $info['val'] = 1;
                    $info['msj'] = 'Parametro no Valido';
                    echo json_encode($info);
                    exit; 
                }
            }
            else
            {
                $info['val'] = 1;
                $info['msj'] = 'Parametro no Valido';
                echo json_encode($info);
                exit;
            }
        }break;
        case 'buscar':
        {
            $estudiante = new Inscripcion();
            $txtNumeroDocumento = $_POST["txtNumeroDocumento"];

            $datosEstudiante = $estudiante->buscarEstudiante($db, $txtNumeroDocumento);

            foreach( $datosEstudiante as $datoEstudiante)
            {
                $txtIdEstudiante = $datoEstudiante["idestudiantegeneral"];
                $nombreEstudiante = $datoEstudiante["nombresestudiantegeneral"];
                $apellidoEstudiante = $datoEstudiante["apellidosestudiantegeneral"];
                $fechaNacimientoEstudiante = $datoEstudiante["fechanacimientoestudiantegeneral"];
                $telefonoResidencia = $datoEstudiante["telefonoresidenciaestudiantegeneral"];
                $emailEstudiante = $datoEstudiante["emailestudiantegeneral"];
                $celularEstudiante = $datoEstudiante["celularestudiantegeneral"];
                $tipoDocumento = $datoEstudiante["tipodocumento"];
                $nombreDocumento = $datoEstudiante["nombredocumento"];
                $codigoGenero = $datoEstudiante["codigogenero"];
                $nombreGenero = $datoEstudiante["nombregenero"];
                $telefonoOficina = $datoEstudiante["telefono2estudiantegeneral"];
                $cadena = "txtIdEstudiante=" . $txtIdEstudiante .
                                "&NombreInscripto=" . $nombreEstudiante .
                                "&ApellidoInscripto=" . $apellidoEstudiante .
                                "&FechaNaci=" . $fechaNacimientoEstudiante .
                                "&TelefonoResidencia=" . $telefonoResidencia .
                                "&TelefonoOficina=" . $telefonoOficina .
                                "&Email=" . $emailEstudiante .
                                "&Celular=" . $celularEstudiante .
                                "&Genero=" . $codigoGenero .
                                "&TipoDocumento=".$tipoDocumento."";
                echo $cadena;
            }//foreach
        }//buscar        		
        break;
        case "crearContacto":
        {            
            $Tipocurso = $_POST['Tipocurso'];
            $codigoCarrera = $_POST["Curso"];

            if ($_POST['captcha'] == $_SESSION['cap_code']) 
            {
                $Tipocurso  = $_POST['Tipocurso'];
                $codigoCarrera = $_POST["Curso"];
                $codigoPeriodo = $_POST["codigoperiodo"];
                $tipoDocumento = $_POST["TipoDocumento"];
                $nombreEstudiante = $_POST["NombreInscripto"];
                $apellidoEstudiante = $_POST["ApellidoInscripto"];
                $fechaNacimiento = $_POST["FechaNaci"];
                $generoEstudiante = $_POST["Genero"];
                $telefonoResidencia = $_POST["TelefonoResidencia"];
                $emailEstudiante = $_POST["Email"];
                $telefonoOficina = $_POST["TelefonoOficina"];
                $celularEstudiante = $_POST["Celular"];
                $txtNumeroDocumento = $_POST["txtNumeroDocumento"];

                $anoaspira = substr($codigoPeriodo, 0, 4);
                $periodoaspira = substr($codigoPeriodo, 4, 5);
                
                $sqlbuscar = "select idestudiantegeneral from estudiantegeneral where "
                        . "tipodocumento = '".$tipoDocumento."' and numerodocumento= '".$txtNumeroDocumento."'";
                
                $estudiantegenenarl = &$db->GetRow($sqlbuscar);
                
                if($estudiantegenenarl['idestudiantegeneral'] == null )
                {
                    //Si no existe el estudiante se procede a crearse
                    $sqlInsertEGeneral = "INSERT INTO estudiantegeneral (
                    idtrato,
                    idestadocivil,
                    tipodocumento,
                    numerodocumento,
                    nombrecortoestudiantegeneral,
                    nombresestudiantegeneral,
                    apellidosestudiantegeneral,
                    fechanacimientoestudiantegeneral,
                    idciudadnacimiento,
                    direccionresidenciaestudiantegeneral,
                    codigogenero,
                    telefonoresidenciaestudiantegeneral,
                    telefono2estudiantegeneral,
                    celularestudiantegeneral,
                    emailestudiantegeneral,
                    fechacreacionestudiantegeneral,
                    fechaactualizaciondatosestudiantegeneral,
                    codigotipocliente,
                    idtipoestudiantefamilia,
                    ciudadresidenciaestudiantegeneral                    
                    )
                    VALUES
                    (
                        '1',
                        '1',
                        '" . $tipoDocumento . "',
                        '" . $txtNumeroDocumento . "',
                        '" . $txtNumeroDocumento . "',
                        '" . $nombreEstudiante . "',
                        '" . $apellidoEstudiante . "',
                        '" . $fechaNacimiento . "',
                        '359',
                        'KR 7B BIS No. 132-11',
                        '" . $generoEstudiante . "',
                        '" . $telefonoResidencia . "',
                        '" . $telefonoOficina . "',
                        '" . $celularEstudiante . "',
                        '$emailEstudiante',
                        NOW(),
                        NOW(),
                        '0',
                        '1',
                        '1'                    
                        )";
                    
                    if($insertarEGeneral = &$db->Execute( $sqlInsertEGeneral )===false)
                    {
                        $info['val'] = 1;
                        $info['msj'] = "Ha ocurrido un problema...1";
                        echo json_encode($info);
                        exit;
                    }
                    $idestudiantegeneral = $db->Insert_ID();
                    
                    $sqlInsertEDocumento = "INSERT INTO estudiantedocumento (
                    idestudiantegeneral,
                    tipodocumento,
                    numerodocumento,
                    fechainicioestudiantedocumento,
                    fechavencimientoestudiantedocumento
                    )
                    VALUES
                    (	'$idestudiantegeneral',
                        '" . $tipoDocumento . "',
                        '" . $txtNumeroDocumento . "',
                        NOW(),
                        '2999-12-31'
                        )";
                    
                    if($insertEstudianteDocumento = &$db->Execute( $sqlInsertEDocumento )===false)
                    {
                        $info['val'] = 1;
                        $info['msj'] = "Ha ocurrido un problema....2";
                        echo json_encode($info);
                        exit;
                    }
                }
                else
                {
                    $idestudiantegeneral = $estudiantegenenarl['idestudiantegeneral'];
                }
                          
                $sqlestudiante = "select 
                                codigoestudiante 
                                from 
                                estudiante 
                                where 
                                idestudiantegeneral= '".$idestudiantegeneral."' 
                                and codigocarrera = '".$codigoCarrera."' 
                                and codigoperiodo='".$codigoPeriodo."'";                
                $CoEstudiante = &$db->GetRow( $sqlestudiante );
                
                if($CoEstudiante['codigoestudiante']== null )
                {                    
                    $sqlInsertEstudiante = "INSERT INTO estudiante (
                    idestudiantegeneral,
                    codigocarrera,
                    semestre,
                    numerocohorte,
                    codigotipoestudiante,
                    codigosituacioncarreraestudiante,
                    codigoperiodo,
                    codigojornada
                    )
                    VALUES
                    (
                        '$idestudiantegeneral',
                        '" . $codigoCarrera . "',
                        '1',
                        '1',
                        '10',
                        '106',
                        '" . $codigoPeriodo . "',
                        '01'
                    )";
                    if($insertEstudiante = &$db->Execute( $sqlInsertEstudiante )===false)
                    {
                        $info['val'] = 1;
                        $info['msj'] = "Ha ocurrido un problema....3";
                        echo json_encode($info);
                        exit;
                    }
                    
                    $CodigoEstudiante = $db->Insert_ID();
                }
                else
                {                    
                   $CodigoEstudiante =  $CoEstudiante['codigoestudiante'];
                }                
                
                $sqlMaxOpcion = " SELECT
                            max(idnumeroopcion) as mayor
                        FROM
                            estudiantecarrerainscripcion e 
                        INNER JOIN inscripcion i ON (i.idinscripcion = e.idinscripcion )
                        WHERE e.idestudiantegeneral = ".$idestudiantegeneral."
                        AND i.codigomodalidadacademica = '400'";

                if($mayorOpcion = &$db->Execute( $sqlMaxOpcion )===false)
                {
                    $info['val'] = 1;
                    $info['msj'] = "Ha ocurrido un problema....4";
                    echo json_encode($info);
                    exit;
                }
                
                $numeroOpcion = $mayorOpcion->fields["mayor"];
                
                $sqlinscripcion = "select i.idinscripcion from inscripcion i where i.codigoperiodo = '".$codigoPeriodo."' and i.idestudiantegeneral = '".$idestudiantegeneral."' and i.codigoestado = 100 and i.codigosituacioncarreraestudiante = 106";
                
                $inscripcion = $db->GetRow($sqlinscripcion);
                
                if($inscripcion['idinscripcion']== null)
                {
                    $sqlInsertInscripcion = "INSERT INTO inscripcion (
                                    numeroinscripcion,
                                    fechainscripcion,
                                    codigomodalidadacademica,
                                    codigoperiodo,
                                    anoaspirainscripcion,
                                    periodoaspirainscripcion,
                                    idestudiantegeneral,
                                    codigosituacioncarreraestudiante,
                                    codigoestado
                                )
                                VALUES
                                    (
                                        '".$_POST['formulario']."',
                                        NOW(),
                                        '400',
                                        '".$codigoPeriodo."',
                                        '$anoaspira',
                                        '$periodoaspira',
                                        '$idestudiantegeneral',
                                        '106',
                                        100
                                    )";
                    if($insertarInscripcion = &$db->Execute( $sqlInsertInscripcion )===false)
                    {
                        $info['val'] = 1;
                        $info['msj'] = "Ha ocurrido un problema....5";
                        echo json_encode($info);
                        exit;
                    }
                    $idnumeroinscripcion = $db->Insert_ID();
                }
                else
                {
                   $idnumeroinscripcion = $inscripcion['idinscripcion'];
                }
               
                
                $sqlMayor = "SELECT
                        max(idnumeroopcion) AS mayor
                    FROM
                        estudiantecarrerainscripcion e,
                        inscripcion i
                    WHERE
                        e.idestudiantegeneral = '" . $idestudiantegeneral . "'
                    AND e.idinscripcion = i.idinscripcion
                    AND i.idinscripcion = '$idnumeroinscripcion'
                    AND i.codigoestado LIKE '1%'";
                
                if($mayor = &$db->Execute($sqlMayor)===false)
                {
                    $info['val'] = 1;
                    $info['msj'] = "Ha ocurrido un problema....6";
                    echo json_encode($info);
                    exit;
                }
                
                $totalRows_mayor = $mayor->RecordCount();
                $row_mayor = $mayor->FetchRow();
                $idnumeroinscripciones = $row_mayor['mayor'] + 1;
                
                $sqlestudianteinscripcion = "select e.idestudiantecarrerainscripcion from estudiantecarrerainscripcion e where e.codigocarrera = ".$codigoCarrera." and e.idestudiantegeneral = ".$idestudiantegeneral." and  codigoestado = 100";
                
                $idestudianteinscripcion = $db->GetRow($sqlestudianteinscripcion);
                    
                if($idestudianteinscripcion['idestudiantecarrerainscripcion']== null)
                {
                    $sqlInsertEstudianteCarrera = "INSERT INTO estudiantecarrerainscripcion (
                                        codigocarrera,
                                        idnumeroopcion,
                                        idinscripcion,
                                        idestudiantegeneral,
                                        codigoestado
                                    )
                                    VALUES
                                        (
                                            '" . $codigoCarrera . "',
                                            '$idnumeroinscripciones',
                                            '$idnumeroinscripcion',
                                            '$idestudiantegeneral',
                                            '100'
                                        ) ";
                    $insertarEstudianteCarrera = &$db->Execute( $sqlInsertEstudianteCarrera );
                    if( $insertarEstudianteCarrera === false )
                    {            
                        $info['val'] = 1;
                        $info['msj'] = "Ha ocurrido un problema....7";
                        echo json_encode($info);
                        exit;
                    }
                }
                        
                if($Tipocurso!=2)
                {
                    //si el tipo de curso es 0 o 1 
                    $estudiante = new Inscripcion();                
                    $estudiante->GenerarOrdenPago($CodigoEstudiante,$codigoPeriodo,$db);
                    echo json_encode($info);
                    exit;
                }
                else
                {
                    $SQL_insert='INSERT INTO EstudianteConvenioEducacionContinuada (Idestudiantegeneral, CodigoCarrera, UsuarioCreacion, UsuarioUltimaModificacion, '
                            . 'FechaCreacion, FechaultimaModificacion) VALUES ("'.$idestudiantegeneral.'","'.$codigoCarrera.'","32957","32957",NOW(),NOW())';

                    if($EstudianteConvenio=&$db->Execute($SQL_insert)===false)
                    {
                        $info['val'] = 1;
                        $info['msj'] = "Ha ocurrido un problema....8";
                        echo json_encode($info);
                        exit;
                    }

                    $info['val'] = 3;
                    $info['msj'] = "Se ha inscrito correctamente. Por favor comunicarse con la universidad para Generar la Orden de Pago.";
                    echo json_encode($info);
                    exit;
                }                
            }//if                        
            else
            {
                $info['val'] = 1;
                $info['val_2'] = 1;
                $info['curso'] = $codigoCarrera;
                $info['Tipocurso'] = $Tipocurso;
                $info['msj'] = "Error en el Captcha";
                echo json_encode($info);
                exit; 

            }
        /*}else{
            $info['val'] = 1;
            $info['msj'] = 'Parametro no Valido';
            echo json_encode($info);
            exit;
        }*/
    }break;
/*	case 'buscar':
        $estudiante = new Inscripcion();
		$txtNumeroDocumento = $_POST["txtNumeroDocumento"];
       	
		$datosEstudiante = $estudiante->buscarEstudiante($db, $txtNumeroDocumento);
		
		
			foreach( $datosEstudiante as $datoEstudiante){
					
				$txtIdEstudiante = $datoEstudiante["idestudiantegeneral"];
				$nombreEstudiante = $datoEstudiante["nombresestudiantegeneral"];
				$apellidoEstudiante = $datoEstudiante["apellidosestudiantegeneral"];
				$fechaNacimientoEstudiante = $datoEstudiante["fechanacimientoestudiantegeneral"];
				$telefonoResidencia = $datoEstudiante["telefonoresidenciaestudiantegeneral"];
				$emailEstudiante = $datoEstudiante["emailestudiantegeneral"];
				$celularEstudiante = $datoEstudiante["celularestudiantegeneral"];
				$tipoDocumento = $datoEstudiante["tipodocumento"];
				$nombreDocumento = $datoEstudiante["nombredocumento"];
				$codigoGenero = $datoEstudiante["codigogenero"];
				$nombreGenero = $datoEstudiante["nombregenero"];
				$telefonoOficina = $datoEstudiante["telefono2estudiantegeneral"];
				
					
				$cadena = "txtIdEstudiante=" . $txtIdEstudiante .
							"&NombreInscripto=" . $nombreEstudiante .
							"&ApellidoInscripto=" . $apellidoEstudiante .
							"&FechaNaci=" . $fechaNacimientoEstudiante .
							"&TelefonoResidencia=" . $telefonoResidencia .
							"&TelefonoOficina=" . $telefonoOficina .
							"&Email=" . $emailEstudiante .
							"&Celular=" . $celularEstudiante .
							"&Genero=" . $codigoGenero .
							"&TipoDocumento=".$tipoDocumento."";
							
							//if ( $tipoDocumento != null )
							//$cadena .= $nombreDocumento;
				echo $cadena;
				
				
				//echo "<pre>";print_r($datoEstudiante["nombresestudiantegeneral"]);
			
         }
	break; */
        /*
         * Modified Dario Gualteros C <castroluisd@unbosque.edu.co> 
         * Se modifica el case actualizarContacto ya que estaba duplicado el case crearContacto y generaba
         * Inconvenientes a la hora de la inscripción a los programas de Educación Continuada.
         * 1 de Agosto de 2018.
         */
        
        case "actualizarContacto":
        {

            if ($_POST['captcha'] == $_SESSION['cap_code']) 
            {
                $Tipocurso     = $_POST['Tipocurso'];
                $codigoCarrera = $_POST["Curso"];		
                $codigoPeriodo = $_POST["codigoperiodo"];
                $tipoDocumento = $_POST["TipoDocumento"];
                $nombreEstudiante = $_POST["NombreInscripto"];
                $apellidoEstudiante = $_POST["ApellidoInscripto"];
                $fechaNacimiento = $_POST["FechaNaci"];
                $generoEstudiante = $_POST["Genero"];
                $telefonoResidencia = $_POST["TelefonoResidencia"];
                $emailEstudiante = $_POST["Email"];
                $telefonoOficina = $_POST["TelefonoOficina"];
                $celularEstudiante = $_POST["Celular"];
                $txtNumeroDocumento = $_POST["txtNumeroDocumento"];
                $txtIdEstudiante = $_POST["txtIdEstudiante"];
                
                //Actualizacion de datos del estudiante general
                $sqlActualizaEstudiante = "UPDATE estudiantegeneral
                                            SET
                                             nombresestudiantegeneral = '" . $nombreEstudiante . "',
                                             apellidosestudiantegeneral = '" . $apellidoEstudiante . "',
                                             fechanacimientoestudiantegeneral = '" . $fechaNacimiento . "',
                                             telefonoresidenciaestudiantegeneral = '" . $telefonoResidencia . "',
                                             telefono2estudiantegeneral = '" . $telefonoOficina . "',
                                             celularestudiantegeneral = '" . $celularEstudiante . "',
                                             emailestudiantegeneral = '" . $emailEstudiante . "',
                                             fechaactualizaciondatosestudiantegeneral = '" . date("Y-m-d G:i:s", time()) . "'
                                            WHERE
                                                idestudiantegeneral = '$txtIdEstudiante'";
                $actualizaEstudiante = $db->Execute( $sqlActualizaEstudiante );
                
                if( $actualizaEstudiante === false )
                {
                    echo "Ha ocurrido un problema"; die;
                }
                
                //Consulta del codigo de estudiante 
                $SQL='SELECT
                        codigoestudiante
                    FROM
                        estudiante
                    WHERE
                        codigocarrera ="'.$codigoCarrera.'"
                    AND codigoperiodo ="'.$codigoPeriodo.'"
                    AND idestudiantegeneral ="'.$txtIdEstudiante.'"';

                if($ExisteCursoEstuiante=&$db->Execute($SQL)===false)
                {
                    echo 'Ha ocurido un Error en el Sistema...';
                    die;
                } 
                
                if($ExisteCursoEstuiante->EOF)
                {
                    //crea el estudiante
                    $sqlInsertEstudiante = "INSERT INTO estudiante (
                                    idestudiantegeneral,
                                    codigocarrera,
                                    semestre,
                                    numerocohorte,
                                    codigotipoestudiante,
                                    codigosituacioncarreraestudiante,
                                    codigoperiodo,
                                    codigojornada
                                )
                                VALUES
                                    (
                                        '$txtIdEstudiante',
                                        '" . $codigoCarrera . "',
                                        '1',
                                        '1',
                                        '10',
                                        '106',
                                        '" . $codigoPeriodo . "',
                                        '01'
                                    )";
                    $insertEstudiante = $db->Execute( $sqlInsertEstudiante );
                    $CodigoEstudiante = $db->Insert_ID();
                    
                    $sqlMaxOpcion = " SELECT
                                        max(idnumeroopcion) as mayor
                                    FROM
                                        estudiantecarrerainscripcion e 
                                    INNER JOIN inscripcion i ON (i.idinscripcion = e.idinscripcion )
                                    WHERE e.idestudiantegeneral = ".$txtIdEstudiante."
                                    AND i.codigomodalidadacademica = '400'";
                    $mayorOpcion = $db->Execute( $sqlMaxOpcion );
                    $numeroOpcion = $mayorOpcion->fields["mayor"];
                    
                    $sqlinscripcion = "select i.idinscripcion from inscripcion i where i.codigoperiodo = '".$codigoPeriodo."' and i.idestudiantegeneral = '".$txtIdEstudiante."' and i.codigoestado = 100 and i.codigosituacioncarreraestudiante = 106";
                    
                    $inscripcion = $db->GetRow($sqlinscripcion);
                
                    if($inscripcion['idinscripcion']== null)
                    {
                        $sqlInsertInscripcion = "INSERT INTO inscripcion (
                                                numeroinscripcion,
                                                fechainscripcion,
                                                codigomodalidadacademica,
                                                codigoperiodo,
                                                anoaspirainscripcion,
                                                periodoaspirainscripcion,
                                                idestudiantegeneral,
                                                codigosituacioncarreraestudiante,
                                                codigoestado
                                            )
                                            VALUES
                                                (
                                                    '" . $_POST[' formulario '] . "',
                                                    NOW(),
                                                    '400',
                                                    '" . $codigoPeriodo . "',
                                                    '$anoaspira',
                                                    '$periodoaspira',
                                                    '$txtIdEstudiante',
                                                    '106',
                                                    100
                                                )";                					
                        $insertarInscripcion = $db->Execute( $sqlInsertInscripcion );
                        $idnumeroinscripcion = $db->Insert_ID();
                        
                    }
                    else
                    {
                        $idnumeroinscripcion = $inscripcion['idinscripcion'];
                    } 

                    $sqlMayor = "SELECT
                                        max(idnumeroopcion) AS mayor
                                    FROM
                                        estudiantecarrerainscripcion e,
                                        inscripcion i
                                    WHERE
                                        e.idestudiantegeneral = '" . $txtIdEstudiante . "'
                                    AND e.idinscripcion = i.idinscripcion
                                    AND i.idinscripcion = '$idnumeroinscripcion'
                                    AND i.codigoestado LIKE '1%'";

                    $mayor = $db->Execute($sqlMayor);
                    $totalRows_mayor = $mayor->RecordCount();
                    $row_mayor = $mayor->FetchRow();
                    $idnumeroinscripciones = $row_mayor['mayor'] + 1;
                    
                    $sqlestudianteinscripcion = "select e.idestudiantecarrerainscripcion from estudiantecarrerainscripcion e where e.codigocarrera = ".$codigoCarrera." and e.idestudiantegeneral = ".$txtIdEstudiante." and  codigoestado = 100";
                
                    $idestudianteinscripcion = $db->GetRow($sqlestudianteinscripcion);

                    if($idestudianteinscripcion['idestudiantecarrerainscripcion']== null)
                    {

                        $sqlInsertEstudianteCarrera = "INSERT INTO estudiantecarrerainscripcion (
                                                        codigocarrera,
                                                        idnumeroopcion,
                                                        idinscripcion,
                                                        idestudiantegeneral,
                                                        codigoestado
                                                    )
                                                    VALUES
                                                        (
                                                            '" . $codigoCarrera . "',
                                                            '$idnumeroinscripciones',
                                                            '$idnumeroinscripcion',
                                                            '$txtIdEstudiante',
                                                            '100'
                                                        ) ";                
                        $insertarEstudianteCarrera = $db->Execute( $sqlInsertEstudianteCarrera );
                        if( $insertarEstudianteCarrera === false )
                        {
                            echo "Ha ocurrido un problema";
                        }
                    }
                    
                    $estudiante = new Inscripcion();                    
                    $estudiante->GenerarOrdenPago($CodigoEstudiante,$codigoPeriodo,$db);                                      
                }
                else
                {
                    if($Tipocurso!=2)
                    {
                        $estudiante = new Inscripcion();                    
                        $estudiante->GenerarOrdenPago($ExisteCursoEstuiante->fields['codigoestudiante'],$codigoPeriodo,$db);
                    }
                    else
                    {
                        /*****************************************************/   
                        $SQL='SELECT
                                numeroordenpago
                                FROM
                                ordenpago
                                WHERE
                                codigoestudiante="'.$ExisteCursoEstuiante->fields['codigoestudiante'].'"
                                AND
                                codigoperiodo="'.$codigoperiodo.'"
                                AND
                                codigoestadoordenpago IN (10,40)';

                        if($Existe=&$db->Execute($SQL)===false)
                        {
                            echo 'Error en el SQL Existe....';
                            die;
                        } 

                        /*****************************************************/
                        if($Existe->EOF)
                        {
                            $SQL_insert='INSERT INTO EstudianteConvenioEducacionContinuada (Idestudiantegeneral, CodigoCarrera, UsuarioCreacion, UsuarioUltimaModificacion, FechaCreacion, FechaultimaModificacion) VALUES ("'.$txtIdEstudiante.'","'.$codigoCarrera.'","32957","32957",NOW(),NOW())';

                            if($EstudianteConvenio=&$db->Execute($SQL_insert)===false)
                            {
                                $info['val'] = 1;
                                $info['msj'] = "Ha ocurrido un problema....8";
                                echo json_encode($info);
                                exit;
                            }

                            $info['val'] = 3;
                            $info['msj'] = "Se ha inscrito correctamente. Por favor comunicarse con la universidad para Generar la Orden de Pago.";
                            echo json_encode($info);
                            exit;
                        }
                        else
                        {
                            $info['val'] = 2;
                            $info['msj'] = "Usted ya se encuentra inscrito y con una Orden de Pago.";
                            $info['codigoestudiante'] = $ExisteCursoEstuiante->fields['codigoestudiante'];
                            $info['codigoperiodo'] = $codigoperiodo;                        
                            echo json_encode($info);
                            exit;
                        }
                    }
                }
            }
            else
            {
                $info['val'] = 1;
                $info['val_2'] = 1;
                $info['curso'] = $codigoCarrera;
                $info['Tipocurso'] = $Tipocurso;
                $info['msj'] = "Error en el Captcha";
                echo json_encode($info);
                exit;
            }
        }//actualizarContacto
        break;   
        case 'VerOrdenes':
        {
            $estudiante = new Inscripcion();
            $estudiante->VerOrdenes($db,$_POST['codigoestudiante'],$_POST['codigoperiodo']);   
        }break;
        /*
         * Caso 103169.
         * Modifield Luis Dario Gualteros C <castroluisd@unbosque.edu.co>
         * Se adiciona el caso ConsultarProgramaActivo para que consulte las carreras activas para inscripción.
         * 08 de Agosto de 2018.
         */
        //Este caso verifica la fecha final para las Inscripciones para que el aspirante se enterre que no estan abiertas en el mommento.
        case "ConsultarProgramaActivo": {
            $Carrera = $_POST['carrera'];
            $hoy = date("Y-m-d");
            $SQL_Activo = "SELECT   
                MAX(cgfi.fechahastacarreragrupofechainscripcion ) as fecha
                FROM
                        CarrerasEducacionContinuada cec
                        INNER JOIN materia m ON cec.CodigoCarrera = m.codigocarrera
                        INNER JOIN carreragrupofechainscripcion cgfi ON cec.CodigoCarrera = cgfi.codigocarrera
                        INNER JOIN grupo g ON m.codigomateria = g.codigomateria
                WHERE
                       cec.CodigoCarrera = '" . $Carrera . "' 
                       AND cgfi.fechahastacarreragrupofechainscripcion  >= '" . $hoy . "' ";

            $ExistePrograma = $db->GetRow($SQL_Activo);

            if ($ExistePrograma['fecha'] == null) {
                $info['val'] = false;
                echo json_encode($info);
                exit;
            } else {

                $info['val'] = true;
                echo json_encode($info);
                exit;   
            }
        }
}//switch
?>  