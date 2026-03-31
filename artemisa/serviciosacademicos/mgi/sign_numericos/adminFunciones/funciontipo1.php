<?php



// Helper method to get a string description for an HTTP status code
// From http://www.gen-x-design.com/archives/create-a-rest-api-with-php/ 
function getStatusCodeMessage($status)
{
    // these could be stored in a .ini file and loaded
    // via parse_ini_file()... however, this will suffice
    // for an example
    $codes = Array(
        100 => 'Continue',
        101 => 'Switching Protocols',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        306 => '(Unused)',
        307 => 'Temporary Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported'
    );

    return (isset($codes[$status])) ? $codes[$status] : '';
}


// Helper method to send a HTTP response code/message
function sendResponse($status = 200, $body = '', $content_type = 'text/html')
{
    $status_header = 'HTTP/1.1 ' . $status . ' ' . getStatusCodeMessage($status);
    header($status_header);
    header('Content-type: ' . $content_type);
    echo $body;
}


function array_recibe($url_array) { 
    $tmp = stripslashes($url_array); 
    $tmp = urldecode($tmp); 
    $tmp = unserialize($tmp); 
   return $tmp; 
} 



class RedeemAPI {

    // Constructor - open DB connection
    function __construct() {

    }

    // Destructor - close DB connection
    function __destruct() {
        
    }

    // Main method to redeem a code
    function redeem() {
    
        
        
$array=$_GET['array'];
 // el mÃ©todo de envio usado. (en el ejemplo un link genera un GET. En el formulario se usa PO
$array=array_recibe($array);
//var_dump($array);

 /*
  *   Conexion  a DB
  */
             global $hostname_sala, $database_sala, $username_sala, $password_sala;  
             
            $ruta = "../";
            while (!is_file($ruta.'Connections/sala2.php'))
            {
                $ruta = $ruta."../";
            }
           include($ruta.'Connections/sala2.php');
           
           
           


$con = mysql_connect($hostname_sala,$username_sala,$password_sala) or
die("Could not connect: " . mysql_error());
if (!$con)
  {
    echo("conection fail");
  die('Could not connect: ' . mysql_error());
  }else{
  }

mysql_select_db("sala", $con);


While(list($clave, $valor) = each($array))
{
    if($valor[0] == 0){
           $sql="INSERT INTO siq_funcionTipo1(funcionIndicadores, idPeriodo, tipo,valor)
VALUES ($valor[1], $valor[2],'$valor[3]', $valor[4])";

if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record added";

}else if($valor[0] == 1) {
     $sql="UPDATE siq_funcionTipo1 SET idPeriodo=$valor[1],
         tipo='$valor[2]', valor=$valor[3] WHERE idsiq_funcionTipo1 =$valor[4]";
if (!mysql_query($sql,$con))
  {
  die('Error: ' . mysql_error());
  }
echo "1 record update";
     
}

}
 




mysql_close($con);

/*
            $user_id = 0;
            $stmt = $this->db->prepare('SELECT idsiq_funcionTipo1, siq_funcionIndicadores FROM siq_funcionTipo1 WHERE idsiq_funcionTipo1=? AND siq_funcionIndicadores=?');
            $idsiq_funcionTipo1 = 6;
            $siq_funcionIndicadores = 50;
            $stmt->bind_param("is", $idsiq_funcionTipo1, $siq_funcionIndicadores);
            $stmt->execute();
            $stmt->bind_result($id, $funcion);
            while ($stmt->fetch()) {
                 //var_dump($stmt);
                break;
            }
            $stmt->close();*/
             /*
While(list($clave, $valor) = each($array))
{
echo "El libro con codigo $valor[0] de nombre $valor[1] tiene un costo de S/.
$valor[2] <br>"; 

        $stmt = $this->db->prepare("INSERT INTO siq_funcionTipo1 (`siq_funcionIndicadores`, `idPeriodo`, `tipo`) VALUES (?, ? ,?)");
       $valorm = "'$valor[2]'";
        $stmt->bind_param("is", $valor[0], $valor[1],$valorm);
            $stmt->execute();
           echo "INSERT INTO siq_funcionTipo1 (`siq_funcionIndicadores`, `idPeriodo`, `tipo`) VALUES( $valor[0], $valor[1],$valorm)<br>"; 
}
 $stmt->close();
 */
/*
        // Check for required parameters
        if (isset($_GET[$array]) && isset($_GET["code"]) && isset($_GET["device_id"])) {
        
            // Put parameters into local variables
            $rw_app_id = $_GET["rw_app_id"];
            $code = $_GET["code"];
            $device_id = $_GET["device_id"];
            
            // Look up code in database
            $user_id = 0;
            $stmt = $this->db->prepare('SELECT id, unlock_code, uses_remaining FROM rw_promo_code WHERE rw_app_id=? AND code=?');
            $stmt->bind_param("is", $rw_app_id, $code);
            $stmt->execute();
            $stmt->bind_result($id, $unlock_code, $uses_remaining);
            while ($stmt->fetch()) {
                break;
            }
            $stmt->close();
            
            // Bail if code doesn't exist
            if ($id <= 0) {
                sendResponse(400, 'Invalid code');
                return false;
            }
            
            // Bail if code already used		
            if ($uses_remaining <= 0) {
                sendResponse(403, 'Code already used');
                return false;
            }	
            
            // Check to see if this device already redeemed	
            $stmt = $this->db->prepare('SELECT id FROM rw_promo_code_redeemed WHERE device_id=? AND rw_promo_code_id=?');
            $stmt->bind_param("si", $device_id, $id);
            $stmt->execute();
            $stmt->bind_result($redeemed_id);
            while ($stmt->fetch()) {
                break;
            }
            $stmt->close();
            
            // Bail if code already redeemed
            if ($redeemed_id > 0) {
                sendResponse(403, 'Code already used');
                return false;
            }
            
            // Add tracking of redemption
            $stmt = $this->db->prepare("INSERT INTO rw_promo_code_redeemed (rw_promo_code_id, device_id) VALUES (?, ?)");
            $stmt->bind_param("is", $id, $device_id);
            $stmt->execute();
            $stmt->close();
            
            // Decrement use of code
            $this->db->query("UPDATE rw_promo_code SET uses_remaining=uses_remaining-1 WHERE id=$id");
            $this->db->commit();
            
            // Return unlock code, encoded with JSON
            $result = array(
                "unlock_code" => $unlock_code,
            );
            sendResponse(200, json_encode($result));
            return true;
        }
        sendResponse(400, 'Invalid request');
        return false;
    
    */}
}

// This is the first thing that gets called when this page is loaded
// Creates a new instance of the RedeemAPI class and calls the redeem method
$api = new RedeemAPI;
$api->redeem();


?>
