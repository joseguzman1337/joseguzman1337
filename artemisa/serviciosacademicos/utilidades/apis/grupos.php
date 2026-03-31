<?PHP 
if($_SERVER["REQUEST_METHOD"] == "POST"){     
    $usuario     = $_POST["idusuario"];
    $token       = $_POST["token"];
    $rol         = $_POST['idrol'] ;
    
    switch ($_POST["action"]){
        case 'obtener_grupos':{
            include_once 'funcionesValidacion.php';
            if(validarToken($usuario,$token)){
                
                    include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                    include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');

                    if($rol==2){

                        $C_obtener_materias = new obtener_materias($db,$usuario,$rol);

                        $json["materiasgrupos"] = $C_obtener_materias->ObtenerGruposApp();
                        $json["result"]          ="OK";
                        $json["codigoresultado"] =0;
                    }else{
                        $json["result"]          ="ERROR";
                        $json["codigoresultado"] =1;
                        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                        echo json_encode($json);
                        exit;
                    }
                
            }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            }
        }break;
        case 'obtener_estudiantes':{
           include_once 'funcionesValidacion.php';
            if(validarToken($usuario,$token)){
                
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                    include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');

                    $C_obtener_materias = new obtener_materias($db,$usuario,$rol);
                
                    $DatosUsuario = $C_obtener_materias->DataUsusario();

                    if($DatosUsuario['codigorol']==2){

                        $json["Estudiantesgrupos"] = $C_obtener_materias->ObtenerEstudianteGrupo($_POST['idgrupo']);
                        $json["Acceso"]            = $C_obtener_materias->ValidaAccesoHorrioGrupo($_POST['idgrupo']);
                        $json["result"]            ="OK";
                        $json["codigoresultado"]   =0;
                    }else{
                        $json["result"]          ="ERROR";
                        $json["codigoresultado"] =1;
                        $json["mensaje"]         ="Error de Conexión del Sistema SALA";
                        echo json_encode($json);
                        exit;
                    }
                
           }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            }
            
        }break;
        case 'registrar_inasistencias':{
         include_once 'funcionesValidacion.php';
                if(validarToken($_POST["idusuario"],$_POST["token"])){ 
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once(realpath(dirname(__FILE__)).'/RegistroFallasEstudiante_class.php');
               
                $C_codigoestudiante =  json_decode($_POST['Inasistentes'],true);
                $C_RegistroFallasEstudiante = new RegistroFallasEstudiante($db,$usuario,$_POST['idgrupo']);
              
                $C_RegistroFallasEstudiante->IngresoFallas($C_codigoestudiante,$_POST['tipomateria']);
                    
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;    
                    
             }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            }
        }break;   
        case 'obtener_cortes':{
            include_once 'funcionesValidacion.php';
            if(validarToken($_POST["idusuario"],$_POST["token"])){ 
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
                include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');

                $C_obtener_materias = new obtener_materias($db,$usuario,0);
                
                $json["Cortes"] = $C_obtener_materias->ObtenerCorte($_POST['idgrupo']);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
           }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            } 
        }break;    
        case 'obtener_notas_corte':{  
           include_once 'funcionesValidacion.php';
            if(validarToken($_POST["idusuario"],$_POST["token"])){
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
               
                include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');
                
                $C_obtener_materias = new obtener_materias($db,$usuario,0);
                
                $json["NotasCortes"]     = $C_obtener_materias->ObtenerNotasCorte($_POST['idgrupo'],$_POST['idcorte']);
                $json["Acceso"]          = $C_obtener_materias->ValidarFechaCorte($_POST['idcorte']);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
           }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            }
        }break;  
        case 'obtener_Total_notas':{
            include_once 'funcionesValidacion.php';
            if(validarToken($_POST["idusuario"],$_POST["token"])){ 
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
               
                include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');
                
                $C_obtener_materias = new obtener_materias($db,$usuario,0);
                
                $json["NotasTotalCortes"]     = $C_obtener_materias->ObtenerTotalNotas($_POST['idgrupo']);
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
            }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            }
        }break;       
        case 'digitar_notas':{
            include_once 'funcionesValidacion.php';
            if(validarToken($_POST["idusuario"],$_POST["token"])){
                include_once(realpath(dirname(__FILE__)).'/../../ReportesAuditoria/templates/mainjson.php');
               
                include_once(realpath(dirname(__FILE__)).'/obtener_materias_class.php');
                
                $C_obtener_materias = new obtener_materias($db,$usuario,0);
                
                $C_notas = json_decode($_POST['notas'],true);   
                
                $C_obtener_materias->DigitarNotasApp($_POST['idgrupo'],$C_notas);
            
                $json["result"]          ="OK";
                $json["codigoresultado"] =0;
            }else{
                $json["result"]          ="ERROR";
                $json["codigoresultado"] =3;
                $json["mensaje"]         ="Ocurrio un error en la autenticación del cliente ";
            }
        }break;    
    }//switch
 }//if
 //echo '<pre>';print_r($json);
echo json_encode($json);
?>