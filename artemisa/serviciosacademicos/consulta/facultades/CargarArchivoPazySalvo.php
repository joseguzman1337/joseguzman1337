<?php
    session_start();
    include_once('../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);
    
session_start();
if(!isset ($_SESSION['MM_Username'])){
	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
	exit();
} 
$rutaVistas = "./vistaPazySalvo"; /*carpeta donde se guardaran las vistas (html) de la aplicación */
require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */
      
$Carrera = $_SESSION['codigofacultad'];

switch($_REQUEST['action_ID']){
    case 'SaVePaZ_Y_Salvo':{
        include('../../Connections/sala2.php');
        $rutaado = "../../funciones/adodb/";
        include('../../Connections/salaado.php');
        $ArregloError = array();
        //SI EL ARCHIVO SE ENVIÓ Y ADEMÁS SE SUBIO CORRECTAMENTE
        if (isset($_FILES["file"]) && is_uploaded_file($_FILES['file']['tmp_name'])) {
         
             //SE ABRE EL ARCHIVO EN MODO LECTURA
             $fp = fopen($_FILES['file']['tmp_name'], "r");
             //SE RECORRE
             $i=0;
             while (!feof($fp)){ //LEE EL ARCHIVO A DATA, LO VECTORIZA A DATA
              
                  //SI SE QUIERE LEER SEPARADO POR TABULADORES
                  //$data  = explode(" ", fgets($fp));
                  //SI SE LEE SEPARADO POR COMAS
                  $data  = explode(";", fgets($fp));
                  
                  //AHORA DATA ES UN VECTOR Y EN CADA POSICIÓN CONTIENE UN VALOR QUE ESTA SEPARADO POR COMA.
                  //EJEMPLO    A, B, C, D
                  //$data[0] CONTIENE EL VALOR "A", $data[1] -> B, $data[2] -> C.
                
                  //SI QUEREMOS VER TODO EL CONTENIDO EN BRUTO:
                 // echo '<pre>';print_r($data);  
                  /*[0] => 52195631
                    [1] => DEUDA
                    [2] => 200*/
                  $Documento = $data[0];
                  $TextDeuda = $data[1];
                  $TipoDeuda = $data[2];
                  
                  if($Documento!='' && $Documento !=NULL){  
                      $Info = IDEstudianteGeneral($db,$Documento);  
                      
                      if($Info['Val']==1){
                          $Valida = Validar($db,$Carrera,$Info['IDEstudiante'],$TipoDeuda);
                          if($Valida){
                            InsertPazySalvo($db,$Carrera,$Info['IDEstudiante'],$TextDeuda,$TipoDeuda);
                          }  
                      }else{                        
                         $ArregloError[$i]['Documento'] = $Documento;
                         $ArregloError[$i]['Text']      = $TextDeuda;
                         $ArregloError[$i]['Tipo']      = $TipoDeuda;
                         $i++;
                      } 
                  } 
                }//while 
                
             $TextFin = 'Archivo Recorrido';
        
        } else{
            $TextFin = 'Error En El Archivo';   
        } 
         
        $template = $mustache->loadTemplate('PrintError'); /*carga la plantilla*/
        $QWERTY['title']    = 'Archivos de Cargar Paz Y Salvo';
        $QWERTY['Data']     = $ArregloError;
        $QWERTY['TextFin']  = $TextFin;
        echo $template->render($QWERTY);    
    }break;
    default:{
         $template = $mustache->loadTemplate('cargarArchivo'); /*carga la plantilla*/
          echo $template->render(array('title' => 'Archivos de Cargar Paz Y Salvo','Label' => 'Cargue Estudiantes Con Deuda Biblioteca'));
    }break;
}
function IDEstudianteGeneral($db,$Documento){
      $SQL='SELECT
      
            g.idestudiantegeneral
            
            FROM
            
            estudiantegeneral g INNER JOIN estudiante e ON e.idestudiantegeneral=g.idestudiantegeneral 
            
            WHERE
            
            g.numerodocumento="'.$Documento.'"
            
            GROUP BY g.idestudiantegeneral';
            
       if($Consulta=&$db->Execute($SQL)===false){
            echo 'Error en SQL del Numero de Documento Estudianta ID...<br><br>'.$SQL;
            die;
       }  
       
       if(!$Consulta->EOF){
            $Data['Val']          = 1;
            $Data['IDEstudiante'] = $Consulta->fields['idestudiantegeneral'];
       }else{
            $Data['Val']          = 0;
       }   
       
       return $Data;
}//function IDEstudianteGeneral
function InsertPazySalvo($db,$Carrera,$Estudiante,$Text,$Tipo){
    $query_periodo = "SELECT codigoperiodo FROM periodo where codigoestadoperiodo = 1";
    
    if($ConsultaPeriodo=&$db->Execute($query_periodo)===false){
        echo 'Error en el SQL Periodo ....<br><br>'.$query_periodo;
        die;
    }
    
    $Periodo = $ConsultaPeriodo->fields['codigoperiodo'];
    
    $Paz_Salvo='INSERT INTO pazysalvoestudiante(idestudiantegeneral,codigocarrera,codigoperiodo)VALUES("'.$Estudiante.'", "'.$Carrera.'","'.$Periodo.'")';
    
    if($InsertPazSalvo=&$db->Execute($Paz_Salvo)===false){
        echo 'Error en el SQL del Insert Paz Y Salvo Cabeza...<br><br>'.$Paz_Salvo;
        die;
    }
    
    $Last_ID=$db->Insert_ID(); 
    
    $Detalle='INSERT INTO detallepazysalvoestudiante(idpazysalvoestudiante,descripciondetallepazysalvoestudiante,fechainiciodetallepazysalvoestudiante,fechavencimientodetallepazysalvoestudiante,codigotipopazysalvoestudiante,codigoestadopazysalvoestudiante)VALUES("'.$Last_ID.'","'.$Text.'",NOW(),NOW(),"'.$Tipo.'",100)';
    
    if($InsertDetalle=&$db->Execute($Detalle)===false){
        echo 'Error en el SQL del Detalle del paz y Salvo...<br><br>'.$Detalle;
        die;
    }
}//function InsertPazySalvo
function Validar($db,$Carrera,$Estudiante,$TipoDeuda){
    
      $query_periodo = "SELECT codigoperiodo FROM periodo where codigoestadoperiodo = 1";
    
        if($ConsultaPeriodo=&$db->Execute($query_periodo)===false){
            echo 'Error en el SQL Periodo ....<br><br>'.$query_periodo;
            die;
        }
        
        $Periodo = $ConsultaPeriodo->fields['codigoperiodo'];
      
      $SQL='SELECT
            	*
            FROM
            	pazysalvoestudiante p INNER JOIN detallepazysalvoestudiante d ON d.idpazysalvoestudiante=p.idpazysalvoestudiante
            
            WHERE
            
            p.idestudiantegeneral="'.$Estudiante.'"
            AND
            p.codigoperiodo="'.$Periodo.'"
            AND
            p.codigocarrera="'.$Carrera.'"
            AND
            d.codigoestadopazysalvoestudiante=100
            AND
            d.codigotipopazysalvoestudiante="'.$TipoDeuda.'"';
            
       if($Validacion=&$db->Execute($SQL)===false){
            echo 'Error en el SQL de la Validacion...<br><br>'.$SQL;
            die;
       } 
       
       if(!$Validacion->EOF){
            return false;
       }else{
            return true;
       }    
}//function Validar
?>