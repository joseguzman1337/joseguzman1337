<?php
/**
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package config
 */

class Configuration {
    /**
     * @type Configuration Object
     * @access protected static
     */
    private static $config;
    
    /**
     * @type String
     * @access private
     */
    private $template;
    
    /**
     * @type String
     * @access private
     */
    private $entorno;
    
    /**
     * @type String
     * @access private
     */
    private $hostName;
    
    /**
     * @type String
     * @access private
     */
    private $dbName;
    
    /**
     * @type String
     * @access private
     */
    private $dbUserName;
    
    /**
     * @type String
     * @access private
     */
    private $dbUserPasswd;
    
   /**
     * @type String
     * @access private
     */
    private $hostNameAndover;

    /**
     * @type String
     * @access private
     */
    private $dbNameAndover;

    /**
     * @type String
     * @access private
     */
    private $dbUserNameAndover;

    /**
     * @type String
     * @access private
     */
    private $dbUserPasswdAndover;


    /**
     * @type String
     * @access private
     */
    private $versionSistema;
    
    /**
     * @type int
     * @access private
     */
    private $SESSION_LIVE = 1800; //30 minutos * 60 segundos;
    
    /**
     * @type String
     * @access private
     */
    private $HTTP_SITE;
    
    /**
     * @type String
     * @access private
     */
    private $HTTP_ROOT;
    
    /**
     * @type String
     * @access private
     */
    private $PATH_ROOT; 
    
    /**
     * @type String
     * @access private
     */
    private $PATH_SITE;


    /**
     * $ANALYTICS es una variable privada, contiene el id de seguimiento para 
     * Google analytics
     * 
     * @var String
     * @access private
     */
    private $ANALYTICS;

    /**
     * $ANALYTICS_EST es una variable privada, contiene el id de seguimiento para 
     * Google analytics a estudiantes
     * 
     * @var String
     * @access private
     */
    private $ANALYTICS_EST;

    /**
     * $ANALYTICS_ADM es una variable privada, contiene el id de seguimiento para 
     * Google analytics a ADMINISTRATIVOS
     * 
     * @var String
     * @access private
     */
    private $ANALYTICS_ADM;


    
    private function __construct(){
        if (!defined('_EXEC')){ //constante de seguridad, si no esta definida no se debe entrar a ninguna seccion
            define('_EXEC', 1);
        }
        $this->template = "default";
        //$this->entorno = "preproduccion";
        $this->entorno = "produccion";
        $this->hostName = '172.16.3.208';
        $this->dbName = 'sala';
        $this->dbUserName = 'UsuAppConSal';
        $this->dbUserPasswd = '197DA72C7FEACUNB0$QU32016';
        $this->HTTP_SITE = "https://artemisa.unbosque.edu.co/sala";
        $this->HTTP_ROOT = "https://artemisa.unbosque.edu.co";
        $this->PATH_SITE = "/usr/local/apache2/htdocs/html/sala";
        $this->PATH_ROOT = "/usr/local/apache2/htdocs/html";
        $this->versionSistema = self::getDateLastFileModified($this->PATH_SITE);
        $this->hostNameAndover = "Molinetes";
        $this->dbNameAndover = "ContinuumDB";
        $this->dbUserNameAndover = "dba";
        $this->dbUserPasswdAndover = "Ubosque2012";
        $this->ANALYTICS = "UA-128035539-1";
        $this->ANALYTICS_EST = "UA-128035539-4";
        $this->ANALYTICS_ADM = "UA-128035539-5";


        // construye sala constantes
        if(!defined("HTTP_ROOT")){
            define("HTTP_ROOT", $this->getHTTP_ROOT());
        }
        if(!defined("HTTP_SITE")){
            define("HTTP_SITE", $this->getHTTP_SITE());
        }
        if(!defined("PATH_SITE")){ 
            define("PATH_SITE", $this->getPATH_SITE());
        }
        if(!defined("PATH_ROOT")){ 
            define("PATH_ROOT", $this->getPATH_ROOT());
        }
        if(!defined("SESSION_LIVE")){ 
            define("SESSION_LIVE", $this->getSESSION_LIVE());
        }

        /**
         * ANALYTICS se define como constante para acceso global inmediato a la
         * id de seguimiento de Google Analytics
         * 
         * @global string ANALYTICS 
         * @name ANALYTICS
         */
        if(!defined("ANALYTICS")){
            define("ANALYTICS", $this->getANALYTICS());
            define("ANALYTICS_EST", $this->getANALYTICS_EST());
            define("ANALYTICS_ADM", $this->getANALYTICS_ADM());
        }

    }
    public static function getInstance(){        
        if (empty(self::$config)){
            self::$config = new Configuration(); 
        }
        return self::$config;        
    }

    public function getTemplate() {
        return $this->template;
    }

    public function setTemplate($template) {
        $this->template = $template;
    }

    public function getHostName() {
        return $this->hostName;
    }

    public function getDbName() {
        return $this->dbName;
    }

    public function getDbUserName() {
        return $this->dbUserName;
    }

    public function getDbUserPasswd() {
        return $this->dbUserPasswd;
    }

    public function getHostNameAndover() {
        return $this->hostNameAndover;
    }

    public function getDbNameAndover() {
        return $this->dbNameAndover;
    }

    public function getDbUserNameAndover() {
        return $this->dbUserNameAndover;
    }

    public function getDbUserPasswdAndover() {
        return $this->dbUserPasswdAndover;
    }

    public function getEntorno() {
        return $this->entorno;
    }
    
    public function getVersionSistema() {
        if(empty($this->versionSistema)){
            $this->versionSistema = mktime(); 
        }
        return $this->versionSistema;
    }
    
    public function getSESSION_LIVE() {
        return $this->SESSION_LIVE;
    }
    
    function getHTTP_SITE() {
        return $this->HTTP_SITE;
    }
    
    function getHTTP_ROOT() {
        return $this->HTTP_ROOT;
    }

    function getPATH_SITE() {
        return $this->PATH_SITE;
    }

    function getPATH_ROOT() {
        return $this->PATH_ROOT;
    }

    /**
     * Retorna el ANALYTICS seteado para el site {@link $ANALYTICS}
     * @return string $ANALYTICS
     */
    function getANALYTICS() {
        return $this->ANALYTICS;
    }
    function getANALYTICS_EST() {
        return $this->ANALYTICS_EST;
    }

    /**
     * Retorna el ANALYTICS seteado para el site {@link $ANALYTICS}
     * @return string $ANALYTICS
     */
    function getANALYTICS_ADM() {
        return $this->ANALYTICS_ADM;
    }

    
    public static function getGitVersion() {
        exec('git describe --always',$version_mini_hash);
        exec('git rev-list HEAD | wc -l',$version_number);
        exec('git log -1',$line);
        $version['number'] = $version_number[0];
        $version['hash'] = $version_mini_hash[0];
        $version['short'] = "v1.".trim($version_number[0]).".".$version_mini_hash[0];
        $version['full'] = "v1.".trim($version_number[0]).".$version_mini_hash[0] (".str_replace('commit ','',$line[0]).")";
        return $version;
    }
    
    public static function getDateLastFileModified($path_site){
	exec('find '.$path_site.' -type f -name "*.css" -o -name "*.js" -printf "%T@\n" | sort -nr | head -1',$last1);
        $t = explode(".",(string) $last1[0]);
        if(is_array($t)){
            $t = $t[0];
        }else{
            $t = $last1[0];
        }
        return ((string) $t);
    }

}
