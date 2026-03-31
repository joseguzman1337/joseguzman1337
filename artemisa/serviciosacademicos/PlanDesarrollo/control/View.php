<?php


class View
{
	private $data = array();
	
	private $root ; 
	
	private $render = FALSE;
	
	public function __construct($template){
		$this->root = dirname(dirname(__FILE__));
	    
	        $file = $this->root.'/templates/' . ($template) . '.php';
			
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
	
	public function __destruct() {
	    extract($this->data);
	    include($this->render);
	
	}
}
?>
