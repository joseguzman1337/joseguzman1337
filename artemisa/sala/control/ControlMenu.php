<?php
/**
 * Clase encargada del control de procesos globales relacionados con el menu
 * @author Andres Ariza <arizaandres@unbosque.edu.do>
 * @copyright Universidad el Bosque - Dirección de Tecnología
 * @since January 2, 2017
 * @package Menu
*/
defined('_EXEC') or die;
class ControlMenu{
    /**
     * @type adodb Object
     * @access private
     */
    private $db;
    
    /**
     * @type String
     * @access private
     */
    private $usuario;

    /**
     * @type String
     * @access public
     */
    public $queryBase;
    
    /**
     * @type String
     * @access private
     */
    private $textoBusqueda;

    /**
     * @type Array
     * @access private
     */
    private $menu;
    
    function __construct($usuario, $db) {
        $this->usuario = $usuario;
        $this->db = $db;
        $this->setQueryBase();
    }
    
    public function setQueryBase(){
        if($this->usuario == "estudianterestringido"){
            $this->usuario = "estudiante";
            // el usuario estudianterestringido solo se utiliza para temas de prematricula y no deberia setearse como usuario de sesion
            Factory::setSessionVar('MM_Username', $this->usuario);
        }
        /*$this->queryBase = "
                SELECT mu.idmenuopcion AS id, 
                           mu.idpadremenuopcion AS parent_id,
                           UPPER(mu.nombremenuopcion) AS text,
                           mu.linkmenuopcion AS link,
                           mu.linkAbsoluto AS linkAbsoluto,
                           mu.framedestinomenuopcion AS linkTarget/ 
                  FROM usuario u
        INNER JOIN permisousuariomenuopcion pumu ON u.idusuario = pumu.idusuario
        INNER JOIN permisomenuopcion pmu ON pumu.idpermisomenuopcion = pmu.idpermisomenuopcion
        INNER JOIN detallepermisomenuopcion dpmu ON pmu.idpermisomenuopcion = dpmu.idpermisomenuopcion
        INNER JOIN tipousuario tu ON u.codigotipousuario = tu.codigotipousuario
        INNER JOIN menuopcion mu ON dpmu.idmenuopcion = mu.idmenuopcion
        
                 WHERE now() BETWEEN u.fechainiciousuario
                   AND u.fechavencimientousuario
                   AND pmu.codigoestado = 100
                   AND pumu.codigoestado = 100
                   AND dpmu.codigoestado = 100
                   AND mu.codigoestadomenuopcion = '01'
                   AND u.usuario = '".$this->usuario."'";
        if(empty($this->usuario)){
            $this->queryBase = "
                    SELECT mu.idmenuopcion AS id, 
                               mu.idpadremenuopcion AS parent_id,
                               UPPER(mu.nombremenuopcion) AS text,
                               mu.linkmenuopcion AS link,
                               mu.framedestinomenuopcion AS linkTarget 
                      FROM menuopcion mu  
                     WHERE  1 ";
        }/**/
        $this->queryBase = "
                /*qc=on*/SELECT id,parent_id, UPPER(text) AS text, link, linkAbsoluto, linkTarget
                  FROM ViewMenuOpciones
        
                 WHERE now() BETWEEN fechainiciousuario AND fechavencimientousuario
                   AND pmuCodigoEstado = 100
                   AND pumoCodigoEstado = 100
                   AND dpmuCodigoEstado = 100
                   AND codigoestadomenuopcion = '01'
                   AND usuario = '".$this->usuario."'";
        if(empty($this->usuario)){
            $this->queryBase = "
                    /*qc=on*/SELECT id, parent_id,text,link,linkTarget 
                      FROM ViewMenuOpciones  
                     WHERE  1 ";
        }
                   
        //d($this);
    }
    
    public function setDb($db) {
        $this->db = $db;
    }
    
    
    
    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }
    /**
     * Consulta las y retorna el listado items de menu relacionados a un id padre 
     * @access public
     * @param Int $parent_id
     * @param String $textoBusqueda
     * @return Array <menu>
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.do>
     * @since January 3, 2017
    */
    public function getMenu($parent_id=0, $textoBusqueda=null) {		
        $query = $this->queryBase;

        if($parent_id<0){
                if(empty($textoBusqueda)){
                        $query .="
                           AND parent_id <> 0 ";
                }
        } else {
                $query .="
                   AND parent_id = ".$parent_id;
        }

        if(!empty($textoBusqueda)){
                $query .="
                   AND (text LIKE '%".$textoBusqueda."%') 
                   AND link <> '' ";

        }
        $query .="
          GROUP BY id
          ORDER BY text, parent_id 
        ";

        $datos = $this->db->Execute($query);
        //d($query);
        $nRows = $datos->NumRows(); 
        //$db->setQuery($query);
        $this->menu = $datos;
        //var_dump($menu );
        $temp=array();
        while($d = $datos->FetchRow()){
            $m = new stdClass();
            foreach($d as $k=>$v){
                if(!is_numeric($k)){
                    $m->$k = $v;
                }
            }
            $temp[] = $m;
        }
        $this->menu = $temp;
        unset( $temp );
        //var_dump($menu );
        $temp=array();
        foreach($this->menu as $m){
            $m->child = $this->getMenu($m->id, $textoBusqueda);
            $temp[] = $m;
        }

        $this->menu =  $temp;
        unset( $temp );

        if( empty($this->menu) ){
                return null;
        }else{
                return ($this->menu);
        } 
    }
    
    
	
    /**
     * Estructura el html de los items del menu
     * @access public
     * @param Array $menu
	 * @param Boolean $child
     * @return Array <menu>
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.do>
     * @since January 3, 2017
    */
    public function printMenuItem( $menu, $child=false ){
        //d($menu);
    	$uriBase=HTTP_ROOT;
    	if(!empty($menu->fa_icon)){
            $icon = $menu->fa_icon;
    	}else{
            $icon = 'fa-archive';
            if($child){
                    $icon="fa-clone";
            } 
    	}
    	
    	if($child){
            $menu->text = mb_strtolower($menu->text,"UTF-8");
    	}else{
            $menu->text = strtoupper($menu->text);
    	}
    	//ddd($menu);
    	/*$link = $menu->link;
    	$reliframe = ' rel="" ';
    	if(empty($link)){
    		$link = "#";
    	}else{
            $link = $uriBase.'/serviciosacademicos/consulta/facultades/'.$link;
            $t = explode('../',$link);

            if(count($t)>0){
                $reliframe = ' rel="iframe" ';
            }
    	}/**/
        $link = $menu->linkAbsoluto;
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
		
    	$li = '
				<li >
					<a href="'.$link.'" id="menuId_'.$menu->id.'" class="menuItem" '.$reliframe.'>';
					
		if(!$child){
    		$li .= '
						<i class="fa '.$icon.'"></i>';
		}
		
    	$li .= '
						<span class="menu-title">
							<strong>'.ucwords($menu->text).'</strong>
						</span>
			';
		if(!empty($menu->child)){
			$li.='
						<i class="arrow"></i>
					</a>
					<!--Submenu-->
					<ul class="collapse" aria-expanded="true" style="">
				';
			foreach($menu->child as $c){
				$li.= $this->printMenuItem( $c , true);
			}
			$li.='
					</ul>
				';
						
		}else{
			$li.='
					</a>
				';
			
		}
		$li.='
		
				</li>
			';
		//if(!empty($menu->child)){
			$li.='
			<li class="list-divider"></li>
				';
			
		//}
		return $li;
    }
    /**
     * Consulta las y retorna el listado items de menu padres relacionados a un id
     * @access public
     * @param Int $id
     * @return Array <menu>
     * @author Andres Alberto Ariza <arizaandres@unbosque.edu.do>
     * @since January 3, 2017
    */
    public function getCurrentMenu($id=0, $child = null) {
        $m = new stdClass();
        if($id>0){
            $query = $this->queryBase;

            if(!empty($id)){
                    $query .="
                       AND id = ".$id;
            }

            $query .="
              GROUP BY id
              ORDER BY text, parent_id
            ";

            $datos = $this->db->Execute($query);
            //d($query);
            //$db->setQuery($query);
            //$this->menu = $datos;
            $temp=array();
            $d = $datos->FetchRow();
            //d($d);
            if(!empty($d)){
                foreach($d as $k=>$v){
                    if(!is_numeric($k)){
                        $m->$k = $v;
                    }
                }
                $m->child = $child;
            }
            //d($m);
            return $this->getCurrentMenu(@$m->parent_id, $m);
            
        }else{
            $m->id = 0;
            $m->parent_id = null;
            $m->text = "Inicio";
            $m->link = HTTP_SITE;
            $m->linkAbsoluto = "sala/index.php";
            $m->child = $child;
            return $m;
        }
    }
 }