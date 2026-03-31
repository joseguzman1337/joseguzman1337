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

class RedeemAPI {

    private $db;

    // Constructor - open DB connection
    function __construct() {
        $this->db = new mysqli('172.16.3.227', 'desarrollo', 'desarrollosala', 'sala');
        $this->db->autocommit(FALSE);
    }

    // Destructor - close DB connection
    function __destruct() {
        $this->db->close();
    }

    // Main method to redeem a code
    function redeem() {
    
        // Check for required parameters
        if (isset($_GET["rw_app_id"]) && isset($_GET["code"]) && isset($_GET["device_id"])) {
        
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
    
    }

}

// This is the first thing that gets called when this page is loaded
// Creates a new instance of the RedeemAPI class and calls the redeem method
$api = new RedeemAPI;
$api->redeem();

?>