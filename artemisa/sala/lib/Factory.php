<?php
defined('_EXEC') or die;
require_once(PATH_ROOT.'/sala/lib/adodb5/adodb.inc.php');
require_once(PATH_SITE.'/interfaces/Model.php');
require_once(PATH_SITE.'/interfaces/Entidad.php');
require_once(PATH_SITE.'/lib/Servicios.php');
/**
 * Clase Factory para la construccion de objetos de uso global * 
 * Este archivo contiene las fabricas de objetos de uso global para la aplicacion
 * entre ellos los mas importantes son:
 * - creacion del singleton de coneccion a base de datos
 * - creacion del singleton de renderizacion de componentes
 * - funcion global para la validacion de session
 * - funciones globales para setear y consultar variables de session
 * - funciones globales para setear y consultar variables de cookies
 * - funcion global estantdar para la creacion de etiqueta de importacion de librerias javascript y css
 * 
 * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
 * @copyright Dirección de Tecnología Universidad el Bosque
 * @package lib
 */
abstract class Factory{
    /**
     * $db es una variable protejida estatica, es la contenedora de la 
     * instancia singleton del objeto adodb de conexion a base de datos de sala
     * 
     * @var adodb Object
     * @access protected static
     */
    protected static $db;

    /**
     * $dbAndover es una variable protejida estatica, es la contenedora de la 
     * instancia singleton del objeto conexion a base de datos de Andover
     * 
     * @var adodb Object
     * @access protected static
     */
    protected static $dbAndover;
    
    /**
     * $ControlRender es una variable protejida estatica,es la contenedora de la 
     * instancia singleton del objeto controlador de render
     * 
     * @var ControlRender Object
     * @access protected static
     */
    protected static $ControlRender;
    
    /**
     * $diasDeLaSemana es una variable protejida estatica,es la contenedora de  
     * un array con los nombres de los dias de la semana iniciado en lunes y
     * termiado en domingo, se utiliza para la funcion printDateString
     * 
     * @var String dias de la semana
     * @access protected static
     */
    protected static $diasDeLaSemana = array("lunes","martes","miercoles","jueves","viernes","sabado","domingo");
    
    /**
     * $diasDeLaSemana es una variable protejida estatica,es la contenedora de  
     * un array con los nombres de los meses del año iniciado en enero y 
     * terminado en diciembre, se utiliza para la funcion printDateString
     * 
     * @var array String meses del año
     * @access protected static
     */
    protected static $mesesDelAgno = array("enero","febrero","marzo","abril","mayo","junio","julio","agosto","septiembre","octubre","noviembre","diciembre");
    
    /**
     * Retorna la instancia creada del objeto adodb de conexion a sala, 
     * importante recordar que el objeto adodb se concibe como un singleton
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return adodb Object
     */
    public static function createDbo($type = "sala"){
        $conf = Configuration::getInstance();
        $dbReturn = null;
        
        switch($type){
            case "sala":
                $dbReturn = self::$db;
                break;
            case "andover":
                $dbReturn = self::$dbAndover;
                break;
        }
        
        try{
            $dbReturn = Factory::getDbInstance($conf, $type);
        }catch (RuntimeException $e){
            if (!headers_sent()){
                    header('HTTP/1.1 500 Internal Server Error');
            }
            die('Database Error: ' . $e->getMessage());
        }
        
        switch($type){
            case "sala":
                self::$db = $dbReturn;
                break;
            case "andover":
                self::$dbAndover = $dbReturn;
                break;
        }
        
        return $dbReturn;
        
    }
    
    /**
     * Retorna la instancia creada del objeto adodb de conexion, 
     * importante recordar que el objeto adodb se concibe como un singleton
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access private static
     * @return adodb Object
     */
    private static function getDbInstance($conf, $type = "sala") {
        $dbReturn = null;
        $typeConn = "";
        $hostName = "";
        $dbUserName = "";
        $dbUserPasswd = "";
        $dbName = "";
        
        switch($type){
            case "sala":
                $dbReturn = self::$db;
                $typeConn = 'mysql';
                $hostName = $conf->getHostName();
                $dbUserName = $conf->getDbUserName();
                $dbUserPasswd = $conf->getDbUserPasswd();
                $dbName = $conf->getDbName();
                break;
            case "andover":
                $dbReturn = self::$dbAndover;
                $typeConn = 'mssql';
                $hostName = $conf->getHostNameAndover();
                $dbUserName = $conf->getDbUserNameAndover();
                $dbUserPasswd = $conf->getDbUserPasswdAndover();
                $dbName = $conf->getDbNameAndover();
                break;
        }
                
        if (empty($dbReturn)){
            $dbReturn = ADONewConnection($typeConn);
            $dbReturn->Connect($hostName, $dbUserName, $dbUserPasswd, $dbName);
        }
        
        switch($type){
            case "sala":
                self::$db = $dbReturn;
                break;
            case "andover":
                self::$dbAndover = $dbReturn;
                break;
        }
        //d($dbReturn);
        
        return $dbReturn;
    }
    
    /**
     * Retorna la instancia creada del objeto ControlRender controlador del 
     * render, importante recordar que el objeto adodb se concibe como un singleton
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return ControlRender Object
     */
    public static function getRenderInstance() {
        require_once (PATH_SITE.'/control/ControlRender.php');
        if (empty(self::$ControlRender)){
            self::$ControlRender = new ControlRender();
        }
        return self::$ControlRender;
    }
    
    /**
     * Crea y retorna el breadCrumbs de navegacion dependiendo del item de 
     * menu seleccionado
     * @param String $option nombre del componente
     * @param stdObject $variables objeto de variables recibidas del request
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return String html
     */
    public static function getBreadCrumbs($option, $variables){
        require_once(PATH_SITE.'/control/ControlMenu.php');
        if($option == "dashBoard"){
            $usuario = Factory::getSessionVar("MM_Username");
            $ControlMenu = new ControlMenu($usuario,Factory::createDbo());
            $menu = $ControlMenu->getCurrentMenu();
            
            $return = Factory::renderBreadCrumbs($menu);
            
            return $return;
        }
    }
    
    /**
     * Renderiza y retorna un html del breadCrumbs de navegacion de un arbol de
     * menu
     * @param stdObject $menu DTO de las opciones de menu
     * @param boolean $showHref determina si la opcion se muestra o no en un hipervinculo
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return String html
     */
    public static function renderBreadCrumbs($menu, $showHref = true){
        $return = "";
        $class = "";
        $reliframe = ' rel="" ';
        $uriBase=HTTP_ROOT;
        
        if(empty($menu->child)){
           $class = " active "; 
        }
        //d($menu);
        
        $link = @$menu->linkAbsoluto;
        $t = explode("/",$link);
    	$reliframe = ' rel="" ';
    	if(empty($link)||($link=="#")){
    		$link = "#";
    	}else{
            if(($t[0] !== "https:") && ($t[0] !== "http:")){
                $link = $uriBase.'/'.$link; 
            }

            if($t[0]=="sala"){
                $reliframe = ' rel="" ';
            }else{
                $reliframe = ' rel="iframe" ';
            }
    	}
        
        //$link = @$menu->link;
                
        if(@$menu->id == 0){
            $return = '<ol class="breadcrumb">';
        }
        
        if($showHref){
            $return .= '<li><a href="'.$link.'" id="menuId_'.@$menu->id.'" class="menuItem '.$class.'" '.$reliframe.'>'.ucwords(mb_strtolower(@$menu->text,"UTF-8")).'</a></li>';
        }else{
            $return .= '<li>'.ucwords(mb_strtolower(@$menu->text,"UTF-8")).'</li>';
        }
        if(!empty($menu->child)){
            $return .= self::renderBreadCrumbs($menu->child,$showHref);
        }else{
            $return .= '</ol>';
        }
        //ddd($return);
        return $return;
    }
    
    /**
     * Renderiza y retorna un String del path de navegacion de un arbol de
     * menu
     * @param stdObject $menu DTO de las opciones de menu
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return String
     */
    public static function renderParentPath($menu){ 
        $return = "";
        
        $return .= ucwords(mb_strtolower(@$menu->text,"UTF-8")).'/';
        
        if(!empty($menu->child)){
            $return .= self::renderParentPath(@$menu->child);
        }
        //ddd($return);
        return $return;
    }
    
    /**
     * Retorna el titulo del menu seleccionado actualmente
     * @param stdObject $menu DTO de las opciones de menu
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return String
     */
    public static function getCurrenTitle($menu){
        $return = ""; 
        $child = @$menu->child;
        if(empty($child)){
            $parentId = @$menu->parent_id;
            if(is_null($parentId)){
                $return = "Sistema de gestión académica en línea - SALA"; 
            }else{
                $return = ucwords(mb_strtolower(@$menu->text,"UTF-8")); 
            }
        }else{
            $return = self::getCurrenTitle(@$menu->child);
        } 
        
        return $return;
    }
    
    /**
     * Valida si existe una session de usuario activa dentro de los tiempos de 
     * vida configurados en el objeto de configuración
     * @param stdObject $variables objeto de variables recibidas del request
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return void
     */
    public static function validateSession($variables){
        session_start();
        $MM_Username = self::getSessionVar('MM_Username');
        $auth = self::getSessionVar('auth');
        
        /**
         * @modified Andres Ariza <arizaandres@unbosque.edu.do>
         * Se agrega la variable $iscripcion activa, la cual solo se valida en 
         * el caso de que el usuario este en proceso de inscripcion
         * @since octubre 29, 2018
         */
        $inscripcionactiva = self::getSessionVar('inscripcionactiva');
        
        //d($variables);
        if(empty($MM_Username) || empty($auth) || $auth!==TRUE ){
            if($variables->option!="login" && empty($inscripcionactiva)){
                header("Location: ".HTTP_SITE."/?tmpl=login&option=login", true, 302);
                exit();
            }
        }elseif(@$variables->option!="login" && @$variables->task!="validarVidaSesion"){
            $curTime = mktime();
            self::setSessionVar("lastActivity",$curTime);
        }
    }
    
    /**
     * Retorna una variable de session si existe, en caso contrario retorna null
     * @param String $variable nombre de la variable que se quirere recuperar
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return $_SESSION var
     */
    public static function getSessionVar($variable){
        if(!empty($_SESSION) && !empty($_SESSION[$variable])){
            return @$_SESSION[$variable];
        }else{
            return null;
        }
    }
    
    /**
     * Setea un valor a una variable de session
     * @param String $variable nombre de la variable que se quirere setear
     * @param var $value valor a setear en la variable
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return void
     */
    public static function setSessionVar($variable, $value){
        if(!empty($_SESSION)){
            return $_SESSION[$variable] = $value;
        }
    }
    
    /**
     * Retorna una variable cookie si existe, en caso contrario retorna null
     * @param String $variable nombre de la variable que se quirere recuperar
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return $_SESSION var
     */
    public static function getCookieVar($variable){
        if(!empty($_SESSION) &&isset($_COOKIE[$variable])){
            return @$_COOKIE[$variable];
        }else{
            return null;
        }
    }
    
    /**
     * Setea un valor a una variable cookie
     * @param String $variable nombre de la variable que se quirere setear
     * @param var $value valor a setear en la variable
     * @param var $liveTime valor a en segundos de la duracion de vida de la cookie
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return void
     */
    public static function setCookieVar($variable, $value, $liveTime){
        if(!empty($_SESSION)){
            $currentValue = self::getCookieVar($variable);
            if($currentValue!=$value){
                return setcookie($variable, $value, $liveTime);
            }else{
                return true;
            }
        }
    }
    
    /**
     * Destruye la session
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return void
     */
    public static function destroySession(){
        if(!empty($_SESSION)){
            session_destroy();
        }
    }
    
    /**
     * Crea y retorna los htmltags para la importacion de librerias js y css 
     * junto con la version del sistema es utilizado para controlar el cache de
     * los archivos
     * @param string $type nombre del tipo de archivo que se va a importar
     * @param string $path url del archivo que se va a importar
     * @param string $asybc indica si el archivo debe ser cargado de forma asincrona
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return String htmltags
     */
    public static function printImportJsCss($type="js",$path=null,$async=false){
        $conf = Configuration::getInstance();
        $asyncTagJS = "";
        $asyncTagCSS = "";
        $return = "";
        
        if($async){
            $asyncTagJS = " async ";
            $asyncTagCSS = '  media="none" onload="if(media!=\'all\')media=\'all\'" ';
        }
        
        if(!empty($path)){
            $path .= "?v=".$conf->getVersionSistema();
            switch($type){
                case "js":
                    $return = '
                        <script type="text/javascript" src="'.$path.'" '.$asyncTagJS.'></script>';
                    break;
                case "css":
                    $return = '
                        <link type="text/css" rel="stylesheet" href="'.$path.'" '.$asyncTagCSS.'> ';
                    break;
            }
        }
        
        return $return;
    }
    
    /**
     * Crea y retorna un string en español de la fecha que se pasa como parametros
     * @param int $dia numero del dia del mes
     * @param int $mes numero del mes del año
     * @param int $agno numero del año
     * @param int $diaDeLaSemana numero del dia de la semana (lunes = 0, domingo = 6)
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return String
     */
    public static function printDateString($dia,$mes,$agno=null,$diaDeLaSemana=null){
        $return = "";
        
        if(!empty($diaDeLaSemana)){
            $return .= self::$diasDeLaSemana[$diaDeLaSemana]." ";
        }
        
        if(!empty($dia)){
            $return .= $dia." ";
            if(!empty($mes)||!empty($mes)){
                $return .= "de ";
            }
        }
        
        if(!empty($mes)){
            $return .= self::$mesesDelAgno[$mes]." ";
            if(!empty($agno)){
                $return .= "de ";
            }
        }
        
        if(!empty($agno)){
            $return .= $agno;
        }
        
        return $return;
    }
    
    /**
     * Importa las librerias genericas para el funcionamiento del sitio
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return void
     */
    public static function importGeneralLibraries(){
        require_once(PATH_ROOT.'/sala/lib/adodb5/adodb.inc.php');
        require_once(PATH_SITE."/entidad/Carrera.php");
        require_once(PATH_SITE."/entidad/Usuario.php");
        require_once(PATH_SITE."/entidad/Periodo.php");
        require_once(PATH_SITE."/entidad/PeriodoVirtualCarrera.php");
    }
    
    /**
     * Inicializa en sesion los periodos genericos y virtuales por defecto para 
     * el usuario logueado
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.co>
     * @access public static
     * @return void
     */
    public static function inicializarPeridos(){
        //d($_SESSION);
        $codigofacultad = Factory::getSessionVar('codigofacultad');
        $idCarrera = Factory::getSessionVar('codigofacultad');
        $codigoperiodosesion = Factory::getSessionVar('codigoperiodosesion'); 
        
        $rol = Factory::getSessionVar('rol');
        
        if((empty($codigofacultad) && $rol==1) || ($codigofacultad==1 && !empty($idCarrera))){
            $idCarrera = Factory::getSessionVar('idCarrera');
        }
        if(empty($idCarrera)){
            $idCarrera = $codigofacultad;
        }

        $carreraSession = Factory::getSessionVar("carreraEstudiante");
        
        if(empty($carreraSession) || ($carreraSession->getCodigocarrera() != $idCarrera)){
            $Carrera = new Carrera();
            $Carrera->setDb();
            $Carrera->setCodigocarrera($idCarrera);
            $Carrera->getByCodigo();
            Factory::setSessionVar('carreraEstudiante', $Carrera);
            $carreraSession = $Carrera;
        }
        
        $PeriodoSession = Factory::getSessionVar("PeriodoSession");
        if(empty($PeriodoSession) || ($PeriodoSession->getCodigoperiodo()!=$codigoperiodosesion)){
            $Periodo = new Periodo();
            $Periodo->setDb();
            $Periodo->setCodigoperiodo($codigoperiodosesion);
            $Periodo->getById();
            /*$PeriodoVigente = Servicios::getPeriodoVigente();
            d($PeriodoVigente);/**/
            Factory::setSessionVar('PeriodoSession', $Periodo);
        }
        
        $PeriodoVirtualSession = Factory::getSessionVar("PeriodoVirtualSession");
        if(empty($PeriodoVirtualSession)){
            //ddd($PeriodoVirtualSession);
            $PeriodoVirtual = Servicios::getPeriodoVirtualVigente($carreraSession);
            Factory::setSessionVar('PeriodoVirtualSession', $PeriodoVirtual);
        }
        //ddd($PeriodoVirtualSession);
        //ddd($_SESSION);
    }
}