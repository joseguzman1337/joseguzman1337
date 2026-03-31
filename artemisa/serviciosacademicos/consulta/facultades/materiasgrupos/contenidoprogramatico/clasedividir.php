<?php

require_once('fpdf17/fpdf.php');
require_once('fpdi/fpdi.php');

class ConcatPdf extends FPDI {
	public $files = array();
	public function setFiles($files) {
		$this->files = $files;
	}
    
    public function concat($inicio,$fin) {
		foreach ($this->files AS $file) 
        {
            $numero =  $this->numeroPaginasPdf($file);             
            if($numero =='0')
            {
                return 'error';               
            }else
            {   
                $Countpage = explode(' ',$numero[0]);                
                $pageCount = trim($Countpage[1]);                 
                if($pageCount > '0')
                {
                    $pageCount = $this->setSourceFile($file);
                    for ($pageNo = $inicio; $pageNo <= $pageCount; $pageNo++) {
                        $tplIdx = $this->ImportPage($pageNo);                    
                        $s = $this->getTemplatesize($tplIdx);
                        $this->AddPage($s['w'] > $s['h'] ? 'L' : 'P', array($s['w'], $s['h']));
                        $this->useTemplate($tplIdx);
                        if ($pageNo == $fin) {
                            break;                             
                        }
                    }//for
                }else
                {
                   return 'error';    
                }
            }//else
		}//foreach
	}
}
?>