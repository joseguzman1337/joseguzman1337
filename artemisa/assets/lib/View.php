<?php


class View
{
	private $data = array();
	
	private $root ; 
	
	private $render = FALSE;
        
        private $return;
	
	public function __construct($template, $root=null, $return = false){
            if(empty($root)){
                $root = dirname(dirname(__FILE__));
	    }
            
            $this->return = $return;
            $this->root = $root;
            $file = $this->root.'/templates/' . ($template) . '.php';
            //echo $file;exit;
            if (file_exists($file)) {
                $this->render = $file;
            }else{
                $file = $this->root.'/templates/default.php';
                $this->render = $file;
            }
	    /*try {}
	    catch (Exception $e) {
	        echo $e->errorMessage();
	    }/**/
	}
	
	public function assign($variable, $value) { 
	    $this->data[$variable] = $value;
	}
	
        public function getResult(){
            if($this->return){
                extract($this->data);
                ob_start();
                include($this->render);
                $ret = ob_get_contents();
                ob_end_clean();
                //$ret = include($this->render);
                return $ret;
            }else{
                return false;
            }
                
        }
        
	public function __destruct() {
            if(!$this->return){ 
                extract($this->data);
                include($this->render);
            }
	}
}
?>
