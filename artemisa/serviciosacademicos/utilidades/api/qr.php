<?PHP 
/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
require_once('generador-qr/QR_class.php');


if($_SERVER["REQUEST_METHOD"] == "POST"){
    switch ($_POST["action"]){
        case 'obtener_qr':{
            include_once 'funcionesValidacion.php';
                if(validarToken($_POST["idusuario"],$_POST["token"])){ 
					
                    $QR_Generador = new QR_Generador('http://www.uelbosque.edu.co/');
            
                    $QR_View = $QR_Generador->CrearQR();

                    if($QR_View['val']){
                        $json["result"]   ="OK";
                        $json["codigoresultado"] =0;
                              $url= "https://artemisa.unbosque.edu.co/serviciosacademicos/utilidades/apis/".$QR_View['img'];//Ojo Hay que realizar el cambio
                       
                        $json["img_qr"]             = $url;
                       

                    }else{
                        $json["result"]          ="Error";
                        $json["codigoresultado"] = 6;
                    }
				} else {
					$json["result"]          ="ERROR";
					$json["codigoresultado"] =2;
					$json["mensaje"]         ="El token no es válido.";
				}
            
        }break;
        
    }
}    
echo json_encode($json);

?>
