<?php
class Muro extends CI_Controller{

	public function __construct() {
      parent::__construct();
			$this->load->model('muro_model','modelo');
  }

	function encrypt() {
			echo base64_encode(openssl_encrypt($str = SECRET_API ."/". time(), 'AES-128-CBC', KEY_TOKEN_API, OPENSSL_RAW_DATA, IV));
	}

	 /**
	 * @api {GET} muro/jwt/ jwt
	 * @apiVersion 1.0.0
	 * @apiName jwt
	 * @apiGroup Muro
	 * @apiDescription Genera el token de autenticación para validar los llamados, 'IV', 'r0c8309Rc40s=j9a', 'KEY_TOKEN_API', '1e+Art2a47-hsv0y', 'SECRET_API', 's3v53su1i+=10t3a'
	 *
	 * @apiHeader {String} X-BQ-Access-Token Header Access token.
	 *
	 * @apiSuccess {Number} code 100 Ok, 102 Hash no válido.
	 * @apiSuccess {Object[]} data vector con variables de respuesta.
	 * @apiSuccess {String} data.auth_token Token de autenticación
	 */
	function jwt(){

		$salida = array (
		'code' => '100',
		'data' => crear_salida(
			'auth_token',"87734t1837518358753"
			)
		);

		echo json_encode($salida);

		/*$access_token = $this->input->get_request_header('X-BQ-Access-Token');
		$validacion_access = $this->jwt->decode_access_token($access_token);

		if ($validacion_access) {
			//Token valido
			$token = array(
			'iat' => time(), // Tiempo que inició el token
			'nbf' => time(),
			'exp' => time() + (60*60), // Tiempo que expirará el token (+1 hora)
			'data' => [ // información del usuario
					'uid' => $access_token
				]
			);

			$salida = array (
			'code' => '100',
			'data' => crear_salida(
				'auth_token',$this->jwt->encode($token, SECRET_API)
				)
			);

			echo json_encode($salida);

		} else {
			//Access token invalido expirado
			echo json_encode(crear_salida('code', '102'));
		}*/

	}

	/**
	* @api {GET} muro/posts/inicia posts
	* @apiVersion 1.0.0
	* @apiName posts
	* @apiGroup Muro
	* @apiDescription Obtiene la lista de post
	*
	* @apiHeader {String} X-BQ-Auth-Token Header Auth token.
	* @apiParam {String} inicia Comienza de 0 en cero e incrementa en 20
	*
	* @apiSuccess {Number} code 100 Ok, <br /> 102 No hay datos, <br /> 120 Auth Token invalido
	* @apiSuccess {Object[]} data Vector con variables
	* @apiSuccess {Array} data.
	*/
	public function posts(){

		//if ($this->jwt->jwt_api_val($this->input->get_request_header('X-BQ-Auth-Token'))) {

			$uid = $this->uri->segment(3);
			$inicia = $this->uri->segment(4);

			$data = $this->modelo->posts($uid, $inicia);
			echo json_encode($data);

		//}else{
			//echo json_encode(crear_salida('code', '120'));
		//}

	}


	/**
	* @api {POST} muro/agregar_comentario/ agregar_comentario
	* @apiVersion 1.0.0
	* @apiName agregar_comentario
	* @apiGroup Muro
	* @apiDescription Agrega un comentario a un POST
	*
	* @apiHeader {String} X-BQ-Auth-Token Header Auth token.
	* @apiParam {String} comentario
	* @apiParam {String} uid Id de usuario de El Bosque
	* @apiParam {Number} id_post
	*
	* @apiSuccess {Number} code 100 Ok, <br /> 102 No hay datos, <br /> 120 Auth Token invalido
	*/
	public function agregar_comentario(){

		//if ($this->jwt->jwt_api_val($this->input->get_request_header('X-BQ-Auth-Token'))) {

			$uid = $_POST["uid"];
			$comentario = $_POST["comentario"];
			$id_post = $_POST["id_post"];

			$data = $this->modelo->agregar_comentario($id_post, $uid, $comentario);
			echo json_encode($data);

		//}else{
			//echo json_encode(crear_salida('code', '120'));
		//}

	}

	/**
	* @api {GET} muro/marcar_favorito/uid/id_post/accion marcar_favorito
	* @apiVersion 1.0.0
	* @apiName marcar_favorito
	* @apiGroup Muro
	* @apiDescription Marca o desmarca un post como favorito
	*
	* @apiHeader {String} X-BQ-Auth-Token Header Auth token.
	* @apiParam {String} uid Id de usuario de El Bosque
	* @apiParam {Number} id_post
	* @apiParam {Number} accion marcar / desmarcar
	*
	* @apiSuccess {Number} code 100 Ok, <br /> 102 No hay datos, <br /> 120 Auth Token invalido
	*/
	public function marcar_favorito(){

		//if ($this->jwt->jwt_api_val($this->input->get_request_header('X-BQ-Auth-Token'))) {

			$uid = $this->uri->segment(3);
			$id_post = $this->uri->segment(4);
			$accion = $this->uri->segment(5);

			$data = $this->modelo->marcar_favorito($id_post, $uid, $accion);
			echo json_encode($data);

		//}else{
			//echo json_encode(crear_salida('code', '120'));
		//}

	}


}
