<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jwt {

	/**
 	 * Decodes a JWT string into a PHP object.
 	 *
 	 * @param string      $jwt    The JWT
 	 * @param string|null $key    The secret key
 	 * @param bool        $verify Don't skip verification process
 	 *
 	 * @return object      The JWT's payload as a PHP object
 	 * @throws UnexpectedValueException Provided JWT was invalid
 	 * @throws DomainException          Algorithm was not provided
 	 *
 	 * @uses jsonDecode
 	 * @uses urlsafeB64Decode
 	 */

 	public static function decode($jwt, $key = null, $verify = true)
 	{

		$tmp = true;

 		$tks = explode('.', $jwt);
 		if (count($tks) != 3) {
			$tmp = FALSE;
 			//echo 'Wrong number of segments';
 		}
 		list($headb64, $bodyb64, $cryptob64) = $tks;
 		if (null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64)))) {
			$tmp = FALSE;
 			//echo 'Invalid segment encoding';
 		}
 		if (null === $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64))) {
 			throw new UnexpectedValueException('Invalid segment encoding');
 		}
 		$sig = JWT::urlsafeB64Decode($cryptob64);
 		if ($verify) {
 			if (empty($header->alg)) {
				$tmp = FALSE;
 				//echo 'Empty algorithm';
 			}
 			if ($sig != JWT::sign("$headb64.$bodyb64", $key, $header->alg)) {
				$tmp = FALSE;
 				//echo 'Signature verification failed';
 			}
 		}

		if ($tmp) {
			return $payload;
		} else {
			return "invalido";
		}

 	}
 	/**
 	 * Converts and signs a PHP object or array into a JWT string.
 	 *
 	 * @param object|array $payload PHP object or array
 	 * @param string       $key     The secret key
 	 * @param string       $algo    The signing algorithm. Supported
 	 *                              algorithms are 'HS256', 'HS384' and 'HS512'
 	 *
 	 * @return string      A signed JWT
 	 * @uses jsonEncode
 	 * @uses urlsafeB64Encode
 	 */
 	public static function encode($payload, $key, $algo = 'HS256')
 	{

		$header = array('typ' => 'JWT', 'alg' => $algo);
 		$segments = array();
 		$segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($header));
 		$segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($payload));
 		$signing_input = implode('.', $segments);
 		$signature = JWT::sign($signing_input, $key, $algo);
 		$segments[] = JWT::urlsafeB64Encode($signature);
 		return implode('.', $segments);
 	}
 	/**
 	 * Sign a string with a given key and algorithm.
 	 *
 	 * @param string $msg    The message to sign
 	 * @param string $key    The secret key
 	 * @param string $method The signing algorithm. Supported
 	 *                       algorithms are 'HS256', 'HS384' and 'HS512'
 	 *
 	 * @return string          An encrypted message
 	 * @throws DomainException Unsupported algorithm was specified
 	 */
 	public static function sign($msg, $key, $method = 'HS256')
 	{

		$methods = array(
 			'HS256' => 'sha256',
 			'HS384' => 'sha384',
 			'HS512' => 'sha512',
 		);
 		if (empty($methods[$method])) {
 			throw new DomainException('Algorithm not supported');
 		}
 		return hash_hmac($methods[$method], $msg, $key, true);
 	}
 	/**
 	 * Decode a JSON string into a PHP object.
 	 *
 	 * @param string $input JSON string
 	 *
 	 * @return object          Object representation of JSON string
 	 * @throws DomainException Provided string was invalid JSON
 	 */
 	public static function jsonDecode($input)
 	{
 		$obj = json_decode($input);
 		if (function_exists('json_last_error') && $errno = json_last_error()) {
 			JWT::_handleJsonError($errno);
 		} else if ($obj === null && $input !== 'null') {
 			throw new DomainException('Null result with non-null input');
 		}
 		return $obj;
 	}
 	/**
 	 * Encode a PHP object into a JSON string.
 	 *
 	 * @param object|array $input A PHP object or array
 	 *
 	 * @return string          JSON representation of the PHP object or array
 	 * @throws DomainException Provided object could not be encoded to valid JSON
 	 */
 	public static function jsonEncode($input)
 	{
 		$json = json_encode($input);
 		if (function_exists('json_last_error') && $errno = json_last_error()) {
 			JWT::_handleJsonError($errno);
 		} else if ($json === 'null' && $input !== null) {
 			throw new DomainException('Null result with non-null input');
 		}
 		return $json;
 	}
 	/**
 	 * Decode a string with URL-safe Base64.
 	 *
 	 * @param string $input A Base64 encoded string
 	 *
 	 * @return string A decoded string
 	 */
 	public static function urlsafeB64Decode($input)
 	{
 		$remainder = strlen($input) % 4;
 		if ($remainder) {
 			$padlen = 4 - $remainder;
 			$input .= str_repeat('=', $padlen);
 		}
 		return base64_decode(strtr($input, '-_', '+/'));
 	}
 	/**
 	 * Encode a string with URL-safe Base64.
 	 *
 	 * @param string $input The string you want encoded
 	 *
 	 * @return string The base64 encode of what you passed in
 	 */
 	public static function urlsafeB64Encode($input)
 	{
 		return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
 	}
 	/**
 	 * Helper method to create a JSON error.
 	 *
 	 * @param int $errno An error number from json_last_error()
 	 *
 	 * @return void
 	 */
 	private static function _handleJsonError($errno)
 	{
 		$messages = array(
 			JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
 			JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
 			JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
 		);
 		throw new DomainException(
 			isset($messages[$errno])
 			? $messages[$errno]
 			: 'Unknown JSON error: ' . $errno
 		);
 	}

	public  function decode_access_token($code) {

		$decrypted = openssl_decrypt(base64_decode($code), 'AES-128-CBC', KEY_TOKEN_API, OPENSSL_RAW_DATA, IV);

	  $access_token_decode = utf8_encode(trim($decrypted));

	  $vector_access_token_decode = explode("/", $access_token_decode);

    $resta_timestamp = time() - $vector_access_token_decode[1];

		if (SECRET_API == $vector_access_token_decode[0]) {

			if ($resta_timestamp < 1000000) {
		    return TRUE;
	    } else {
				return FALSE;
	   }

		} else {
			return FALSE;
		}

	}

	protected function hex2bin($hexdata) {

		$bindata = '';
		for ($i = 0; $i < strlen($hexdata); $i += 2) {
			$bindata .= chr(hexdec(substr($hexdata, $i, 2)));
		}
		return $bindata;

	}

	function jwt_api_val($auth_token){

		$data = $this->decode($auth_token, SECRET_API, TRUE);
		$info_jwt = json_decode(json_encode($data), true);

		if (is_array($info_jwt)) {
			//token valido
			return TRUE;
		} else {
			//token no valido
			return FALSE;
		}

	}

}
