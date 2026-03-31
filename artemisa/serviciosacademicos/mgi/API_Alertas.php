<?php
// this starts the session 
session_start();
/*include_once('../utilidades/ValidarSesion.php'); 
$ValidarSesion = new ValidarSesion();
$ValidarSesion->Validar($_SESSION);*/
 

/**
 * Description of API_Alertas
 *
 * @author proyecto_mgi_cp
 */
require_once('ManagerEntity.php');
class API_Alertas {
    
    var $rutaProyecto = "monitoreo";
    
    var $db = null;
    
    public function __construct() {
        
    }
    
    public function initialize($database) {
        $this->db = $database;
    }
    
    public function enviarAlerta ($to, $asunto, $mensaje, $reportSend = false){
        //$headers = "From: no-responder@unbosque.edu.co \r\n";
        
        // Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
        $cabeceras  = 'MIME-Version: 1.0' . "\r\n";
        //$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";        

        // Cabeceras adicionales
        //$cabeceras .= 'To: ' .$to. "\r\n";
        $cabeceras .= 'From: Equipo MGI <equipomgi@unbosque.edu.co>' . "\r\n";
        //$cabeceras .= 'Cc: birthdayarchive@example.com' . "\r\n";
        //$cabeceras .= 'Bcc: birthdaycheck@example.com' . "\r\n";
        
          // Enviamos el mensaje
          if (mail($to, $asunto, $mensaje, $cabeceras)) {
                $aviso = "Su mensaje fue enviado.";
                $succed = true;
          } else {
                $aviso = "Error de envío.";
                $succed = false;
          }
          if($reportSend){
            return array("mensaje" =>$aviso, "succes"=>$succed); 
          } else {
            return $aviso;
          }
    }
    
    public function programarAlertaEvento ($to, $asunto, $mensaje, $fecha_envio, $idAlerta=null){
       //guarda en la bd siq_colaAlertaPorEvento;
       
        $entity = new ManagerEntity("usuario",$this->rutaProyecto);
        $entity->sql_select = "idusuario";
        $entity->prefix ="";
        $entity->sql_where = " usuario='".$_SESSION['MM_Username']."' ";
            //$entity->debug = true;
        $data = $entity->getData();
        $userid = $data[0]['idusuario'];        
        
       $entity = new ManagerEntity("colaAlertaPorEvento",$this->rutaProyecto);
       
       $fields = array();
       
       if($idAlerta!=null){
            $fields["idAlerta"] = $idAlerta;
       }
       
            $fields["asunto"] = $asunto;
            $fields["mensaje"] = $mensaje;
            $fields["fecha_envio"] = $fecha_envio;
            $fields["destinatarios"] = $to;
                        
            $currentdate  = date("Y-m-d H:i:s");
       
            if(!isset($_SESSION['MM_Username'])){
                //$_SESSION['MM_Username'] = 'admintecnologia';
                echo "No ha iniciado sesión en el sistema"; die();
            }
            
            $fields['fecha_modificacion'] = $currentdate;
            $fields['usuario_modificacion'] = $userid;
            $fields['fecha_creacion'] = $currentdate;
            $fields['usuario_creacion'] = $userid;
            $fields['codigoestado'] = 100;
       
       $entity->SetEntity($fields);
       //var_dump($entity);
       //$entity->debug = true;
       return $entity->insertRecord();
    }
    
    public function programarAlertaEventoConPlantilla ($idAlerta, $destinatarios, $parametros, $fecha_envio){
        //guarda en la bd siq_colaAlertaPorEvento;        
        
        $message = $this->procesarPlantillaAlertaPorEvento($idAlerta,$parametros,true);
        
        if(count($message)>0){
            $asunto = $message["asunto"];
            $mensaje = $message["mensaje"];
        
            return $this->programarAlertaEvento($destinatarios, $asunto, $mensaje, $fecha_envio,$idAlerta);
        } else {
            return "la plantilla de la alerta indicada no existe o no está activa";
        }        
        
    }
    
    public function enviarAlertaEventoConPlantilla ($idAlerta, $destinatarios, $parametros){
        $asunto = "";
        $mensaje = "";
        
        $message = $this->procesarPlantillaAlertaPorEvento($idAlerta,$parametros);
        
        if(count($message)>0){
            $asunto = $message["asunto"];
            $mensaje = $message["mensaje"];
        
            return $this->enviarAlerta($destinatarios,$asunto,$mensaje);
        } else {
            return "la plantilla de la alerta indicada no existe o no está activa";
        }
    }
    
    /**
     *De codifica la plantilla de las alertas pre-definidas
     * @param type $idAlerta id de la alertaPredefinida
     * @param type $parametros con llave el nombre dado en la plantilla
     * @param type $programacion indica si el mensaje se va a enviar enseguida o no
     * @return type 
     */
    public function procesarPlantillaAlertaPorEvento ($idAlerta,$parametros,$programacion=false){
        $result = array();
        
        $entity = new ManagerEntity("tipoAlertaPredefinida",$this->rutaProyecto);
        //$entity->sql_select = "idusuario";
        //$entity->prefix ="";
         $entity->sql_where = "idsiq_tipoAlertaPredefinida = '".$idAlerta."' AND codigoestado='100'";
        
        $data = $entity->getData();
        if(count($data)>0){
            $data = $data[0];           
        
            $asunto = $data['asunto_correo'];
            $mensaje = $data['plantilla_correo'];
            
            //procesar todas las variables en el asunto -> no se permiten for
            $asunto=$this->procesarVariablesEnTexto($asunto,$parametros);
            //por si es la fecha del dia y esta programado entonces debe ser la fecha en la que se envie
            if(!$programacion){
                $asunto=$this->procesarFuncionesEnTexto($asunto);
            }
            
            $mensaje = $this->procesarForEnTexto($mensaje,$parametros);
            $mensaje = $this->procesarVariablesEnTexto($mensaje,$parametros);
            if(!$programacion){
                $mensaje=$this->procesarIndicadoresEnTexto($mensaje,$parametros);
                $mensaje=$this->procesarFuncionesEnTexto($mensaje);
            }
            //var_dump($mensaje);
            $result = array("asunto"=>$asunto,"mensaje"=>$mensaje);
        }
        
        return $result;
        
    }
    
    private function procesarVariablesEnTexto ($texto,$parametros){
        $pos = strpos($texto, "{{ var.");
        $pos2 = strpos($texto, " }}");
        while ($pos !== false && $pos2 !== false) {
           $var = substr($texto, $pos+7);
           $var = trim(substr($var, 0, strpos($var, "}")));
                
           $replace = substr($texto, $pos);  
           $replace = substr($replace, 0, strpos($replace, " }}")+3); 
           
           $texto = str_replace($replace, $parametros[$var], $texto);
           //var_dump($texto);
           
           $pos = strpos($texto, "{{ var.");
           $pos2 = strpos($texto, " }}");
           
           //var_dump($pos);
           //die();
        }
        return $texto;
    }
    
    public function procesarFuncionesEnTexto ($texto){
        //función fecha del día
        $texto = str_replace("{{ getdate() }}", date("d/m/Y"), $texto);
        
        $pos = strpos($texto, "{{ getCounter() }}");
        $contador = 1;
        while ($pos !== false) {
            $texto = $this->str_replace_first('{{ getCounter() }}', $contador, $texto);
            
            $contador = $contador + 1;
            $pos = strpos($texto, "{{ getCounter() }}");
        }
        
        return $texto;
    }
    
    private function procesarIndicadoresEnTexto ($texto,$parametros){
        $pos = strpos($texto, "{{ getIndicadoresACargo() }}");
        
        if($pos !== false){
            $ciclo = $var = substr($texto, $pos);
            $var = substr($texto, $pos+28);
            $pos = strpos($var, "{{ endGetIndicadoresACargo }}");
            $var = trim(substr($var, 0, $pos));
            $ciclo = substr($ciclo, 0, strpos($ciclo, "{{ endGetIndicadoresACargo }}")+29);

            $indicadores_id = $parametros["getIndicadoresACargo()"];
            //var_dump($indicadores_id);
            $replace = "";
            foreach ($indicadores_id as $key => $row){
                //var_dump($row[0]);
                $arreglo["idsiq_indicador"] = $row[0];
                $result = $this->procesarVariablesDinamicasEnTexto($var,$arreglo);
                $replace = $replace.$result;
            }
            
            $texto = str_replace($ciclo, $replace, $texto);
        }
        
        return $texto;
    }
    
    
    private function procesarForEnTexto ($texto,$parametros){
        $pos = strpos($texto, "{{ for ");
        $pos2 = strpos($texto, "{{ endfor }}");
        
        while ($pos !== false && $pos2 !== false) {
           $var = substr($texto, $pos+7);
           $var = trim(substr($var, 0, strpos($var, "}")));
           
           //var_dump($var);
           
           $replace = substr($texto, $pos);  
           $replace = substr($replace, 0, strpos($replace, " }}")+3); 
           //var_dump($replace);
           
           $arreglo = $parametros[$var];
           $textoFor = substr($texto, $pos+strlen($replace));
           $textoFor = substr($textoFor, 0, strpos($textoFor, "{{ endfor }}"));
           $lenght = count($arreglo);
           $textoForFinal = "";
           for ($i=0; $i<$lenght; $i++){
               $textoForFinal = $textoForFinal.$this->procesarVariablesEnTexto($textoFor,$arreglo[$i]);
           }
                   
           //$texto = preg_replace('/'.$textoFor.'/', "", $texto, 1);
           $texto = $this->str_replace_first($textoFor, "", $texto);
           $texto = $this->str_replace_first($replace, "", $texto);           
           $texto = $this->str_replace_first('{{ endfor }}', $textoForFinal, $texto);   
           //var_dump($texto);
           
           $pos = strpos($texto, "{{ for ");
           $pos2 = strpos($texto, "{{ endfor }}");
        }
        
        return $texto;
    }
    
    private function str_replace_first($search, $replace, $subject) {
        $pos = strpos($subject, $search);
        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }
    
    public function programarAlertaPeriodica ($to, $asunto, $mensaje, $fecha_envio){
        //guarda en la bd siq_colaAlertas;
    }
    
    public function enviarAlertaPeriodicaConPlantilla ($idAlerta, $parametros, $destinatario=null){
        $to = "";
        $asunto = "";
        $mensaje = "";
        
        $message = $this->procesarPlantillaAlertaPeriodica($idAlerta,$parametros);
        
        if(count($message)>0){
            $asunto = $message["asunto"];
            $mensaje = $message["mensaje"];
            if($destinatario!=null && $destinatario!=""){
                $to = $destinatario;
            } else {
                //tocaria buscarlo
            }
        
            return $this->enviarAlerta($to,$asunto,$mensaje);
        } else {
            return "la plantilla de la alerta indicada no existe o no está activa";
        }
    }
    
    public function programarAlertaPeriodicaConPlantilla ($idAlerta, $parametros, $fecha_envio){
        //guarda en la bd siq_colaAlertaPorEvento;        
        
        $message = $this->procesarPlantillaAlertaPeriodica($idAlerta,$parametros,true);
        
        if(count($message)>0){
            $asunto = $message["asunto"];
            $mensaje = $message["mensaje"];
        
            return $this->programarAlertaPeriodica($destinatarios, $asunto, $mensaje, $fecha_envio);
        } else {
            return "la plantilla de la alerta indicada no existe o no está activa";
        }        
        
    }
    
    /*
     * Parametros es un arreglo con los id de las entidades necesarias
     * Para indicador debe ser "siq_indicador" => $idIndicador
     */
    public function procesarPlantillaAlertaPeriodica ($idAlerta, $parametros, $programacion=false){
        $result = array();
        
        $entity = new ManagerEntity("tipoAlerta",$this->rutaProyecto);
        $entity->sql_where = "idsiq_tipoAlerta = '".$idAlerta."' AND codigoestado='100'";
        
        $data = $entity->getData();
        if(count($data)>0){
            $data = $data[0];       
            //var_dump($data);var_dump("<br/><br/>");
            $asunto = $data['asunto_correo'];
            $mensaje = $data['plantilla_correo'];
            
            //procesar todas las variables en el asunto -> no se permiten for
            $asunto=$this->procesarVariablesDinamicasEnTexto($asunto,$parametros);
            //var_dump($asunto);var_dump("<br/><br/>");
            
            //por si es la fecha del dia y esta programado entonces debe ser la fecha en la que se envie
            if(!$programacion){
                $asunto=$this->procesarFuncionesEnTexto($asunto);
            }
            //var_dump($asunto);var_dump("<br/><br/>");
            
            $mensaje = $this->procesarForVariablesDinamicasEnTexto($mensaje,$parametros);
            //var_dump($mensaje);var_dump("<br/><br/>");
            $mensaje = $this->procesarVariablesDinamicasEnTexto($mensaje,$parametros);
            //var_dump($mensaje);var_dump("<br/><br/>");
            if(!$programacion){
                $mensaje=$this->procesarFuncionesEnTexto($mensaje);
            }
            
            //buscar destinatarios y por cada uno llamar a al de procesar variables por usuario
            //$param["usuario"] = $idUsuario;
            //$asunto=$this->procesarVariablesUsuarioEnTexto($asunto,$param);
            //$mensaje = $this->procesarVariablesUsuarioEnTexto($mensaje,$param);
            
            
            //var_dump($mensaje);
            $result = array("asunto"=>$asunto,"mensaje"=>$mensaje);
        }
        
        return $result;
    }
    
    private function procesarForVariablesDinamicasEnTexto ($texto,$parametros){
        $pos = strpos($texto, "{{ for ");
        $pos2 = strpos($texto, "{{ endfor }}");
        
        while ($pos !== false && $pos2 !== false) {
           $var = substr($texto, $pos+7);
           $var = trim(substr($var, 0, strpos($var, "}")));
           
           //var_dump($var);var_dump("<br/><br/>");
           
           $replace = substr($texto, $pos);  
           $replace = substr($replace, 0, strpos($replace, " }}")+3); 
           //var_dump($replace);
           
           $arreglo = $parametros[$var];
           $textoFor = substr($texto, $pos+strlen($replace));
           $textoFor = substr($textoFor, 0, strpos($textoFor, "{{ endfor }}"));
           $lenght = count($arreglo);
           $textoForFinal = "";
           //var_dump($textoFor);var_dump("<br/><br/>");
           //var_dump($arreglo);var_dump("<br/><br/>");
           for ($i=0; $i<$lenght; $i++){
               $textoForFinal = $textoForFinal.$this->procesarVariablesDinamicasEnTexto($textoFor,$arreglo[$i]);
           }
                   
           //$texto = preg_replace('/'.$textoFor.'/', "", $texto, 1);
           $texto = $this->str_replace_first($textoFor, "", $texto);
           $texto = $this->str_replace_first($replace, "", $texto);           
           $texto = $this->str_replace_first('{{ endfor }}', $textoForFinal, $texto);   
           //var_dump($texto);
           
           $pos = strpos($texto, "{{ for ");
           $pos2 = strpos($texto, "{{ endfor }}");
        }
        
        return $texto;
    }
    
     /*private function procesarVariablesUsuarioEnTexto ($texto,$parametros){
        //Datos de usuarios
        $pos = strpos($texto, "{{ usuario.");
        $pos2 = strpos($texto, " }}");
        while ($pos !== false && $pos2 !== false) {
           $var = substr($texto, $pos+11);
           $var = trim(substr($var, 0, strpos($var, "}")));
                
           $replace = substr($texto, $pos);  
           $replace = substr($replace, 0, strpos($replace, " }}")+3);            
           
           var_dump($var);
           var_dump($replace);
           var_dump($parametros);
           $texto = str_replace($replace, $parametros["usuario"][$var], $texto);
           var_dump($texto);
           
           $pos = strpos($texto, "{{ usuario.");
           $pos2 = strpos($texto, " }}");
           
           var_dump($pos);
           die();
        }
         
     }*/
    
    private function procesarVariablesDinamicasEnTexto ($texto,$parametros){        
        //Datos de indicador
        $pos = strpos($texto, "{{ siq_indicador.");
        $pos2 = strpos($texto, " }}");
        while ($pos !== false && $pos2 !== false) {
            
           $var = substr($texto, $pos+17);
           $var = trim(substr($var, 0, strpos($var, "}")));
                
           $replace = substr($texto, $pos);  
           $replace = substr($replace, 0, strpos($replace, " }}")+3); 
           
           $value = "";
           $entity = new ManagerEntity("indicador",$this->rutaProyecto);
           $entity->sql_where = "idsiq_indicador = '".$parametros["idsiq_indicador"]."' AND codigoestado='100'";
           
           $data = $entity->getData();
           $data = $data[0];
           
           //verificar si es en otra tabla o es un dato directo del indicador
           $posSub = strpos($var, ".");
           
           if($posSub !== false){
               $posSub = strpos($var, "siq_indicadorGenerico.");
               
               if($posSub !== false){
                   $var = substr($var, $posSub+22);
                   
                   $data = $this->getAttributeIndicador("indicadorGenerico",$data["idIndicadorGenerico"]);
               }else{
                   $posSub = strpos($var, "siq_factor.");
                   
                   if($posSub !== false){
                      $var = substr($var, $posSub+11); 
                      $data = $this->getAttributeIndicador("factor",$data["idIndicadorGenerico"]);
                   } else {
                       $posSub = strpos($var, "carrera.");
                       
                       $var = substr($var, $posSub+8); 
                       
                        $entity2 = new ManagerEntity("carrera",$this->rutaProyecto);
                        $entity2->prefix ="";
                        $entity2->sql_where = "codigocarrera = '".$data["idCarrera"]."'";
                        
                        $data = $entity2->getData();
                        if(count($data)>0){
                            $data = $data[0];
                        } else {
                            $data["nombrecarrera"] = "Institucional";
                        }
                   }
               }             
           }
           //var_dump($var);
           //var_dump($replace);
           //var_dump($data);
           $value = $data[$var];
           //var_dump($value);
           
           $texto = str_replace($replace, $value, $texto);
           //var_dump($texto);
           
           $pos = strpos($texto, "{{ siq_indicador.");
           $pos2 = strpos($texto, " }}");
           
           //var_dump($pos);
           //die();
        }        
        //var_dump($texto);
        return $texto;
    }    
    
    private function getAttributeIndicador ($tipo,$idIndicadorGenerico){
       $entity2 = new ManagerEntity("indicadorGenerico",$this->rutaProyecto);
       $entity2->sql_where = "idsiq_indicadorGenerico = '".$idIndicadorGenerico."' AND codigoestado='100'";

       $data = $entity2->getData();
       $data = $data[0];          
              
       if($tipo=="indicadorGenerico"){
           return $data;
       }
                        
       $entity2 = new ManagerEntity("aspecto",$this->rutaProyecto);
       $entity2->sql_where = "idsiq_aspecto = '".$data["idAspecto"]."' AND codigoestado='100'";

       $data = $entity2->getData();
       $data = $data[0];   
       
       if($tipo=="aspecto"){
           return $data;
       }
                        
       $entity2 = new ManagerEntity("caracteristica",$this->rutaProyecto);
       $entity2->sql_where = "idsiq_caracteristica = '".$data["idCaracteristica"]."' AND codigoestado='100'";

       $data = $entity2->getData();
       $data = $data[0];
       
       if($tipo=="caracteristica"){
           return $data;
       }
                        
        if($tipo=="factor"){
                      
            $entity2 = new ManagerEntity("factor",$this->rutaProyecto);
            $entity2->sql_where = "idsiq_factor = '".$data["idFactor"]."' AND codigoestado='100'";

            $data = $entity2->getData();
            $data = $data[0];
            
            return $data;
            
        }
         
    }
    
    public function enviarAlertaEventoProgramada ($idAlertaEnCola){
        $asunto = "";
        $mensaje = "";
        
        $entity = new ManagerEntity("colaAlertaPorEvento",$this->rutaProyecto);
        $entity->sql_where = "idsiq_colaAlertaPorEvento = '".$idAlerta."' AND codigoestado='100' AND enviado='0'";
        
        $data = $entity->getData();
        
        if(count($data)>0){
            $asunto = $data[0]["asunto"];
            $mensaje = $data[0]["mensaje"];
            $destinatarios = $data[0]["destinatarios"];
            
            $asunto=$this->procesarFuncionesEnTexto($asunto);
            $mensaje=$this->procesarFuncionesEnTexto($mensaje);
        
            return $this->enviarAlerta($destinatarios,$asunto,$mensaje);
        } else {
            return "La alerta programada no es correcta";
        }
    }
    
    public function __destruct() {
        
    }
}

?>
