<?PHP 
/**
*
*/
class QR_Generador {
	var $data;    
	function __construct($data){ 
		$this->data  = $data;
	}//__construct
	function CrearQR(){ 
        $Data = $this->data;
		$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
        
        $PNG_WEB_DIR = 'generador-qr/temp/';
       
        require_once "generador-qr/phpqrcode/phpqrcode.php";    
        
        if(!file_exists($PNG_TEMP_DIR)){ 
            mkdir($PNG_TEMP_DIR);    
        }
        
        $filename = $PNG_TEMP_DIR.'test.png';        
        
        $errorCorrectionLevel = 'L';
        
        $matrixPointSize = 20;
        
        if(isset($Data)){
            if (trim($Data) == ''){
                $Result['val'] = false;    
            }else{
                $filename = $PNG_TEMP_DIR.'test'.md5($Data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
                QRcode::png($Data, $filename, $errorCorrectionLevel, $matrixPointSize, 2); 
                
                $Result['val'] = true;
                $Result['img'] = $PNG_WEB_DIR.basename($filename);
                
            }
        }else{
            $Result['val'] = false;
        }
        
        return $Result; 
	}//function validarfechas
}//class
?>
