<?php 
    session_start();
    include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
    $rutaVistas  = "../view"; /*carpeta donde se guardaran las vistas (html) de la aplicación */ 
    require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */
    $template_index = $mustache->loadTemplate('listado'); /*carga la plantilla index*/
    //require_once('/../funciones/obtener_datos_hecca.php');
    
    //Conexion de base de datos
    include_once (realpath(dirname(__FILE__)).'/../../EspacioFisico/templates/template.php');
    $db = getBD();    
    
    $sql_periodo= "select codigoperiodo from periodo order by codigoperiodo desc limit 25";    
    $datos_periodo = $db->GetAll($sql_periodo); 
    
    $variable['0']['idvariable']= "1"; 
    $variable['0']['nombrevariable']="Participante";

    $variable['1']['idvariable']= "5"; 
    $variable['1']['nombrevariable']="Inscrito";

    $variable['2']['idvariable']= "7"; 
    $variable['2']['nombrevariable']="InscritoPrograma";
    
    $variable['3']['idvariable']= "3"; 
    $variable['3']['nombrevariable']="Admitidos";

    $variable['4']['idvariable']= "4"; 
    $variable['4']['nombrevariable']="Primercurso";

    $variable['5']['idvariable']= "2"; 
    $variable['5']['nombrevariable']="Matriculados";

    $variable['6']['idvariable']= "8"; 
    $variable['6']['nombrevariable']="MateriasMatriculados";

    $variable['7']['idvariable']= "6"; 
    $variable['7']['nombrevariable']="Graduados";
 
    echo $template_index->render(array(
            'title' => 'REPORTES HECAA',
            'periodo' => $datos_periodo,
            'variable' => $variable
        )
    );
?>