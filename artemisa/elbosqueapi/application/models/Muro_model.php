<?php
class Muro_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}


	function posts($uid, $inicia){

		$datos = $this->db->query("select a.id_post, a.fecha, a.titulo, a.descripcion, a.recurso, a.tipo_recurso,
		ifnull((select id_favorito from bns_muro_favoritos where id_post = a.id_post and uid = " . $uid . " limit 1), 0) as favorito
		from bns_muro a
		where a.estado = 'activo'
		order by fecha DESC");


		if ($datos->num_rows() > 0) {

			$tmp = array();

			foreach ($datos->result() as $post) :

				$datos_comentarios = $this->db->query("select id_comentario, comentario, fecha from bns_muro_comentarios where id_post = " . $post->id_post . " order by id_comentario DESC");

				$tmp[] = array(
					'id_post' => $post->id_post,
					'fecha' => $post->fecha,
					'titulo' => $post->titulo,
					'descripcion' => $post->descripcion,
					'recurso' => config_item('imgs_recursos') . $post->recurso,
					'tipo_recurso' => $post->tipo_recurso,
					'favorito' => $post->favorito,
					'comentarios' => $datos_comentarios->result()
				);

				unset($datos_comentarios);

			endforeach;

			$salida = array (
			'code' => '100',
			'data' => $tmp
			);

			return $salida;

		} else {

			return crear_salida('code', '102');
		}

	}


	function agregar_comentario($id_post, $uid, $comentario){

		$datos = array(
			'id_post' => $id_post,
			'comentario' => $comentario,
			'uid' => $uid,
			'fecha' => date('Y-m-d H:i:s', NOW())
		);

		$this->db->insert('bns_muro_comentarios',$datos);

		if ($this->db->affected_rows() > 0) {
			return crear_salida('code', '100');
		} else {
			return crear_salida('code', '102');
		}

	}

	function marcar_favorito($id_post, $uid, $accion){

		if ($accion == 'desmarcar') {

				$this->db->query("delete from bns_muro_favoritos where id_post = " . $id_post . " and uid = " . $uid);

				if ($this->db->affected_rows() > 0) {
					return crear_salida('code', '100');
				} else {
					return crear_salida('code', '102');
				}

		} else {

				$datos = array(
					'id_post' => $id_post,
					'uid' => $uid,
					'fecha' => date('Y-m-d H:i:s', NOW())
				);

				$this->db->insert('bns_muro_favoritos',$datos);

				if ($this->db->affected_rows() > 0) {
					return crear_salida('code', '100');
				} else {
					return crear_salida('code', '102');
				}
		}

	}


}

?>
