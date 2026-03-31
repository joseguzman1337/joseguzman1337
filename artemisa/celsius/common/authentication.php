<?

function authenticate_digest($getUserCallback,$getPasswordCallback){
	$realm = 'Restricted area';

	//chequeo que el usuario user autenticacion http digest
	if (empty($_SERVER['PHP_AUTH_DIGEST'])) {
		header('HTTP/1.1 401 Unauthorized');
		header('WWW-Authenticate: Digest realm="'.$realm.'",qop="auth",nonce="'.uniqid(rand(), true).'",opaque="'.md5($realm).'"');
		die('Access Denied');
	}

	// analizo PHP_AUTH_DIGEST para ver si es valida y si tiene usuario
	if (!($data = http_digest_parse($_SERVER['PHP_AUTH_DIGEST'])) ||
	    empty($data['username'])){
		header('HTTP/1.1 401 Unauthorized');
		die('Wrong Credentials!');
	}

	//compruebo que el usuario (instancia) exista
	$user = call_user_func($getUserCallback, $data['username']);
	
	if (empty($user)){
		header('HTTP/1.1 401 Unauthorized');
		die('Wrong Credentials!');
	}

	// genero la respuesta valida en base al password real de la instancia
	$password = call_user_func($getPasswordCallback, $user);
	$A1 = md5($data['username'] . ':' . $realm . ':' . $password);
	$A2 = md5($_SERVER['REQUEST_METHOD'].':'.$data['uri']);
	$valid_response = md5($A1.':'.$data['nonce'].':'.$data['nc'].':'.$data['cnonce'].':'.$data['qop'].':'.$A2);

	//comparo la respuesta valida con la recibida
	if ($data['response'] != $valid_response){
		header('HTTP/1.1 401 Unauthorized');
		die('Wrong Credentials!');
	}

	// El usuario esta correctamente logueado
	return true;

}



// function to parse the http auth header
function http_digest_parse($txt)
{
   
    // protect against missing data
    $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
    $data = array();
    preg_match_all('@(\w+)=(?:([\'"])([^$2]+)$2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);
   
    foreach ($matches as $m) {
	$data[$m[1]] = $m[3] ? trim($m[3],"\",'") : trim($m[4],"\",'");
	unset($needed_parts[$m[1]]);
    }
   
    return $needed_parts ? false : $data;
}

/*
HTTP Authentication Basic anda pero se reemplazo con Digest porque es mas segura
*/
function authenticate_basic($getUserCallback,$getPasswordCallback){

	if (empty($_SERVER['PHP_AUTH_USER'])) {
	    header('WWW-Authenticate: Basic realm="My Realm"');
	    header('HTTP/1.0 401 Unauthorized');
	    die('Text to send if user hits Cancel button');
	}
	$user = call_user_func($getUserCallback, $data['username']);
	
	if (empty($user)){
		header('HTTP/1.1 401 Unauthorized');
		die('Wrong Credentials!');
	}

	// genero la respuesta valida en base al password real de la instancia
	$password = call_user_func($getPasswordCallback, $user);

	if (empty($password)){
		header('HTTP/1.1 401 Unauthorized');
		die('Wrong Credentials!');
	}

	return true;
}



?>