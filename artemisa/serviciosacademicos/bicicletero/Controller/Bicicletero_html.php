<?php
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/

$rutaVistas = "../View"; /*carpeta donde se guardaran las vistas (html) de la aplicaci?n */
 
require_once(realpath(dirname(__FILE__))."/../../../Mustache/load.php"); /*Ruta a /html/Mustache */

 switch($_REQUEST['action_ID']){
    case 'DeleteBici':{
        global $db,$C_Bicicletero,$userid;
        define(CLASE,true);
        MainGeneral();
       if($_POST['opc']==1){//estudiante
            define(ESTUDIANTE,true);
       }else{//Admin
            define(ESTUDIANTE,false);
            $$userid = 2;
       }
       
       SeccionStarActiva($db);  
       
       $BicicleteroId = $_POST['BicicleteroId'];
       $BiciDetalle   = $_POST['BiciDetalle'];
       
        $SQLDelete='UPDATE DetalleBicicletero
       
                   SET    CodigoEstado=200,
                          UsuarioUltimaModificacion="'.$userid.'",
                          FechaUltimaModificacion=NOW()
                     
                   WHERE  DetalleBicicleteroId="'.$BiciDetalle.'"  AND BicicleteroId="'.$BicicleteroId.'"  AND CodigoEstado=100'; 
                   
       if($DeleteBiciletero=&$db->Execute($SQLDelete)===false){
                $info['val'] = false;
                $info['msj'] = "Error en el Sistema..12";
                echo json_encode($info);
                exit;
           }          
                   
        $info['val'] = true;
        //$info['msj'] = "Error en el Sistema..11";
        echo json_encode($info);
        exit;                    
    }break;
    case 'Edit':{
      global $db,$C_Bicicletero,$userid;
        define(CLASE,true);
        MainGeneral();
       if($_POST['opc']==1){//estudiante
            define(ESTUDIANTE,true);
       }else{//Admin
            define(ESTUDIANTE,false);
            $$userid = 2;
       }
       
       SeccionStarActiva($db);  
       
       $idUser        = $_POST['idUser'];
       $Marca         = $C_Bicicletero->limpiarCadena(filter_var($_POST['Marca'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
       $Color         = $C_Bicicletero->limpiarCadena(filter_var($_POST['Color'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
       $BiciType      = $_POST['BiciType'];
       $Observacion   = $C_Bicicletero->limpiarCadena(filter_var($_POST['Observacion'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
       $Cual          = $C_Bicicletero->limpiarCadena(filter_var($_POST['Cual'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
       $BicicleteroId = $_POST['BicicleteroId'];
       $BiciDetalle   = $_POST['BiciDetalle'];
       
       $SQLUpdate='UPDATE DetalleBicicletero
       
                   SET    marca="'.$Marca.'",
                          color="'.$Color.'",
                          TipoBicicleta="'.$BiciType.'",
                          otra="'.$Cual.'",
                          observaciones="'.$Observacion.'",
                          UsuarioUltimaModificacion="'.$userid.'",
                          FechaUltimaModificacion=NOW()
                     
                   WHERE  DetalleBicicleteroId="'.$BiciDetalle.'"  AND BicicleteroId="'.$BicicleteroId.'"  AND CodigoEstado=100';
                   
         
         if($UpdateBiciletero=&$db->Execute($SQLUpdate)===false){
                $info['val'] = false;
                $info['msj'] = "Error en el Sistema..11";
                echo json_encode($info);
                exit;
           }          
                   
        $info['val'] = true;
        //$info['msj'] = "Error en el Sistema..11";
        echo json_encode($info);
        exit;          
       
    }break;
    case 'ViewBicicletas':{
        global $db,$C_Bicicletero,$userid;
        define(CLASE,true);
        MainGeneral();
        
        $idUser = $_POST['idUser'];
        $op     = $_POST['op'];
        
        if($op!=1){
              define(ESTUDIANTE,false);
         }else{
              define(ESTUDIANTE,true);
         }   
         SeccionStarActiva($db);  
        
        $Info['Label']            = 'Bicicletas Registradas';
        $Info['idUser']           = $idUser;
        $Info['op']               = $op;
        $Info['Datos']            = $C_Bicicletero->ViewBicicletas($db,$idUser,$op);
        $Info['TipoBicicleta']    = $C_Bicicletero->TipoBicicleta($db);
        
        $C_Bicicletero->ViewBicicletaEdit($Info);          
    }break;
    case 'SaveData':{ 
        /*        
        [Bicicleta] => Array
        (
            [name] => bicic 2.jpg
            [type] => image/jpeg
            [tmp_name] => D:\wamp\tmp\phpB1C2.tmp
            [error] => 0
            [size] => 740363
        )
        [action_ID] => SaveData
        [BiciType] => 1
        [marcaBici] => asdasd
        [colorBici] => sadasd
        [OtroTipoBici] => 
        [observacionBici] => sadasdasd
        */
        global $db,$C_Bicicletero,$userid;
        define(CLASE,true);
        MainGeneral();
        if($_POST['opc']==1){
            define(ESTUDIANTE,false);
        }else{
           define(ESTUDIANTE,true); 
        }
        SeccionStarActiva($db);
      
        $name         = $_FILES['Bicicleta']['name'];
        $type         = $_FILES['Bicicleta']['type'];
        $size         = $_FILES['Bicicleta']['size'];
        $tmp_name     = $_FILES['Bicicleta']['tmp_name'];
        $BiciType     = $_POST['BiciType'];
        $marca        = $C_Bicicletero->limpiarCadena(filter_var($_POST['marcaBici'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $color        = $C_Bicicletero->limpiarCadena(filter_var($_POST['colorBici'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $OtroTipo     = $C_Bicicletero->limpiarCadena(filter_var($_POST['OtroTipoBici'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $observacion  = $C_Bicicletero->limpiarCadena(filter_var($_POST['observacionBici'],FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
        $op           = $_POST['opc'];   
        $idUser       = $_POST['idUser']; 
        
        $Tam = $C_Bicicletero->CalcularTamano($size);
          
        
        if($Tam[1]!='KB' && $Tam[1]!='B'){ 
            $info['val'] = false;
            $info['Op'] = 1;
            echo json_encode($info);
            exit;
        }
        
        if($Tam[1]=='KB'){
            if($Tam[0]>100){
                $info['val'] = false;
                $info['Op'] = 1;
                echo json_encode($info);
                exit; 
            }
        }       
        
        $finfo = finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
       
        $mime = finfo_file($finfo, $tmp_name); 
        finfo_close($finfo);                   
        
        
        
        if(($type!='image/jpeg' && $type!='image/png' && $type!='image/jpg') || ($mime!='image/jpeg' && $mime!='image/png' && $mime!='image/jpg')){
            $info['val'] = false;
            $info['msj'] = "Error la Imgen no es tipo jpeg-png-jpg";
            echo json_encode($info);
            exit;
        }
        
        /*****************************/
        $Data = pathinfo($_FILES["Bicicleta"]["name"]);
       /*****************************/
        
        if($op==1){
             $SQLExiste='SELECT
                         	BicicleteroId
                         FROM
                        	Bicicletero
                         WHERE
                        	idadministrativosdocentes = "'.$idUser.'"
                         AND CodigoEstado = 100
                         LIMIT 1'; 
            
           $SQL_Insert='INSERT INTO Bicicletero(idadministrativosdocentes,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$idUser.'","2",NOW(),"2",NOW())';
            $userid = '2';
        }else{
            
             $SQLExiste='SELECT
                         	BicicleteroId
                         FROM
                        	Bicicletero
                         WHERE
                        	idestudiantegeneral = "'.$idUser.'"
                         AND CodigoEstado = 100
                         LIMIT 1'; 
            
            $SQL_Insert='INSERT INTO Bicicletero(idestudiantegeneral,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$idUser.'","'.$userid.'",NOW(),"'.$userid.'",NOW())';
        }
        
        
          if($ExisteDato=&$db->Execute($SQLExiste)===false){
                $info['val'] = false;
                $info['msj'] = "Error en el Sistema..1";
                echo json_encode($info);
                exit;
          }
          
          if(!$ExisteDato->EOF){
            
             $Last_id = $ExisteDato->fields['BicicleteroId'];
             
          }else{                
        
              if($Biciletero=&$db->Execute($SQL_Insert)===false){
                    $info['val'] = false;
                    $info['msj'] = "Error en el Sistema..1";
                    echo json_encode($info);
                    exit;
               }
           
           $Last_id=$db->Insert_ID();
           
           }
           
           $URL = '../ImagenBici_upload/';
           
            $SQL_Dll='INSERT INTO DetalleBicicletero(BicicleteroId,imagen,marca,color,TipoBicicleta,otra,observaciones,CodigoEstado,UsuarioCreacion,FechaCreacion,UsuarioUltimaModificacion,FechaUltimaModificacion)VALUES("'.$Last_id.'","'.$URL.'","'.$marca.'","'.$color.'","'.$BiciType.'","'.$OtroTipo.'","'.$observacion.'","100","'.$userid.'",NOW(),"'.$userid.'",NOW())';
           
           if($DetalleBiciletero=&$db->Execute($SQL_Dll)===false){
                $info['val'] = false;
                $info['msj'] = "Error en el Sistema..2";
                echo json_encode($info);
                exit;
           }
           
           
           $Last_id=$db->Insert_ID();
          
           move_uploaded_file($tmp_name,"../ImagenBici_upload/".$Last_id.'.'.$Data['extension']);
           
           $URL="ImagenBici_upload/".$Last_id.'.'.$Data['extension'];  
           
           
           $UpdateSql='UPDATE DetalleBicicletero
                       SET    imagen="'.$URL.'"
                       WHERE  DetalleBicicleteroId ="'.$Last_id.'"';
                       
           if($UpdateDetalle=&$db->Execute($UpdateSql)===false){
                $info['val'] = false;
                $info['msj'] = "Error en el Sistema..2";
                echo json_encode($info);
                exit;
           }            
           
           
           
        $info['val'] = true;
        $info['type'] = $Data['extension'];
        $info['img']  = '../'.$URL;
        echo json_encode($info);
        exit; 
    }break;
    case 'ValidarAcceso':{
        session_start();
        if ($_POST['captcha'] == $_SESSION['cap_code']) {
            global $db,$C_Bicicletero;
            define(CLASE,true);
            MainGeneral();
            define(ESTUDIANTE,false);
            SeccionStarActiva();
            
            $C_Bicicletero->ValidaDocenteAdmin($db,$_POST);
        }else{
            $info['val'] = false;
            $info['msj'] = "Error en el Captcha";
            $info['msj2'] = "El texto de la imagen no es correcto...";
            echo json_encode($info);
            exit;
        }
    }break;
    case 'Acceso':{
        session_start();
        define(ESTUDIANTE,false);
        SeccionStarActiva();
        
        $Info['title']                   = 'Formulario de Acceso a Docentes y Administrativos';
        
        $template_index = $mustache->loadTemplate('BicicleteroAccesoExterno'); /*carga la plantilla index*/
        
        echo $template_index->render($Info);
    }break;
    default:{ 
        global $db,$C_Bicicletero,$userid;
        define(CLASE,true);
        MainGeneral();
        if($_POST['op']==1){
            define(ESTUDIANTE,false);
          
            $Info['title']                   = 'Inscripcion Bicicletas Docentes y Administrativos';
            $Info['Label']                   = 'Inscripcion Bicicletas Docentes, Administrativos y Directivos';
            $Info['DatosAdmin']              = $C_Bicicletero->InfoAdminDocente($db,$_POST['dato']);
            $Info['view']                    = '';
            $Info['funcion']                 = 'SaveDocenteAdmin';
            $Info['id']                      = $_POST['dato'];
            $Info['ViewFunction']            = 'ViewBiciletaAdmin';
        }else{
            define(ESTUDIANTE,true);
            
            $Info['title']                   = 'Inscripcion Bicicletas Estudiante';
            $Info['Label']                   = 'Inscripcion Bicicletas Estudiante';
            $Info['view']                    = 'display:none';
            $Info['funcion']                 = 'SaveEstudiante';
            $Info['id']                      = $C_Bicicletero->EstudianteId($db,$_SESSION['codigo'],$_SESSION['codigofacultad']);
            $Info['ViewFunction']            = 'ViewBicileta';
        } 
        SeccionStarActiva($db);  
        
        $TipoBicicleta = $C_Bicicletero->TipoBicicleta($db);
        
        $template_index = $mustache->loadTemplate('Bicicletero'); /*carga la plantilla index*/
        
            $Info['TipoBicicleta']           = $TipoBicicleta;        
        
        echo $template_index->render($Info);
    }break;
 }
 function MainGeneral(){
    global $db,$C_Bicicletero;
    
    include_once ('../../EspacioFisico/templates/template.php');
   
    if(CLASE==true){
        include_once ('../Class/Bicicletero_class.php');  $C_Bicicletero = new Bicicletero();
    }
    $db = getBD();
   
 }//function MainGeneral
 function SeccionStarActiva($db){
    
    if(ESTUDIANTE==TRUE){
    global $userid;    
     session_start();
        if(!isset ($_SESSION['MM_Username'])){
        	echo '<blink><strong style="color:#F00; font-size:18px">No ha iniciado sesión en el sistema</strong></blink>';
        	exit();
        }
        
        $SQL_User='SELECT idusuario as id,codigorol FROM usuario WHERE usuario="'.$_SESSION['MM_Username'].'"';

		if($Usario_id=&$db->Execute($SQL_User)===false){
				echo 'Error en el SQL Userid...<br>'.$SQL_User;
				die;
			}
		
		 $userid=$Usario_id->fields['id'];
    }     
 }//function SeccionStarActiva
?>