<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package entidades
 */ 

class CurlRestFul{
 	
    /**
     * @type curl object
     * @access private
     */
    private $curl;
 	
    /**
     * @type String
     * @access private
     */
    private $url;
    
    /**
     * @type String
     * @access private
     */
    private $http_status;
    
    /**
     * @type String
     * @access private
     */
    private $result;
    
    /**
     * @type String
     * @access private
     */
    private $error;
 	
    /**
     * @type String
     * @access private
     */
    private $tipoEnvio;
 	
    /**
     * @type String
     * @access private
     */
    private $tipoRespuesta;
 	
    /**
     * @type array
     * @access private
     */
    private $headers;
 	
    /**
     * @type array
     * @access private
     */
    private $options;
    
    
    /**
     * Constructor
     * @param Singleton $persistencia
     */
    public function CurlRestFul( $url, $getData, $tipoEnvio="application/json", $tipoRespuesta="application/json", $headers=null, $options=null, $post=null ){
        $this->url = $url;
        $this->tipoEnvio = $tipoEnvio;
        $this->tipoRespuesta = $tipoRespuesta;
        
        //Se agrega el getData a la url base
        if(!empty($getData)){
            if(is_array($getData)){
                $getData = implode("&",$getData);
            }
            $this->url .= "?".$getData;
        }
        
        //Se inicializa el array de headers
        $this->headers = array();
        if(!empty($headers) && (is_array($headers))){ 
            foreach ($headers as $k => $v) {
                $this->headers[] = "$k: $v";
            } 
        }
        $this->headers[] = 'accept: '.$this->tipoRespuesta;
        $this->headers[] = 'Content-Type: '.$this->tipoEnvio;
        
        //Se inicializa el array de opciones
        $this->options = array();
        if(!empty($options) && (is_array($options)) ){ 
            $this->options=$options;
        }
        
        //Se agrega post variable al array de opciones
        if(!empty($post)){
            if(is_array($post)){
                $post = implode("&",$post);
            }
            $this->options[CURLOPT_POST] = 1;
            $this->options[CURLOPT_POSTFIELDS] = $post;
        }
        //d($this);
    }
    
    /**
     * Inicializa el objeto curl y lo deja listo para la consulta de informacion
     * @access public
     * @return void
     */
    public function setInit(){
        try {
            $this->curl = curl_init();
            
            curl_setopt($this->curl,CURLOPT_URL,$this->url);
            curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($this->curl,CURLOPT_HEADER, false);
            $pos = strpos($this->url, "https");
            if($pos !== false){
                curl_setopt($this->curl,CURLOPT_SSL_VERIFYPEER, false);
            }
            
            if (!empty($this->headers)) { 
                curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);
            }
            
            if (!empty($this->options)) {
                foreach ($this->options as $key => $var) { 
                    curl_setopt($this->curl, $key, $var);
                }
            }
            //d($this->curl);
        }catch (Exception $e) {
            $this->curl = null;
            $this->error = $e->getMessage();
            trigger_error($this->error, E_USER_WARNING); 
        }
    }
    
    /**
     * Retorna el resultado del WSRestful, dependiendo del formato de respuesta lo convierte en Json
     * @access public
     * @return Strin/JsonObject
     */
    public function getResult(){
        //d($this->curl);
        if(!empty($this->curl)){
            $this->result = curl_exec($this->curl);
            
            $this->error = curl_error($this->curl);
            
            if(empty($this->error)){
                if($this->tipoRespuesta == "application/json"){
                   $this->result = json_decode($this->result);
                }
            }else{
                $this->result = $this->error;
            }
            $this->http_status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        }else{
            $this->result = $this->error;
            $this->http_status = null;
        }
        curl_close($this->curl); 
        
        return $this->result;
    }
}