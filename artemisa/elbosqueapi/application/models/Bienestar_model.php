<?php
class Bienestar_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	}

	public function get_posts($start, $per_page)
	{
		/*Get posts paginated*/
		$posts = $this->db->query("SELECT a.id_post, a.fecha, a.titulo, a.descripcion, a.recurso, a.tipo_recurso, a.estado, COALESCE(COUNT(distinct b.id_comentario)) AS comentarios, COALESCE(COUNT(distinct c.id_favorito)) AS favoritos
									FROM bns_muro a
									LEFT JOIN bns_muro_comentarios b ON a.id_post = b.id_post
									LEFT JOIN bns_muro_favoritos c ON a.id_post = c.id_post
									WHERE a.estado = 'activo'
									GROUP BY id_post
									ORDER BY a.id_post DESC
									LIMIT ". ($start-1) * $per_page .",".$per_page )->result();

		return $posts;
	}

	public function total_post()
	{
		/*Get the total posts*/
		$total = $this->db->query("SELECT COUNT(id_post) AS total 
			   					   FROM bns_muro
								   WHERE estado = 'activo'
			   					   ")->result();
		return $total[0]->total;
	}

	public function get_commets($id_post)
	{
		$comments = $this->db->query("SELECT a.id_comentario, a.comentario, a.fecha, a.uid
									  FROM bns_muro_comentarios a
									  WHERE a.id_post = ? 
									  ORDER BY id_comentario DESC", array(intval($id_post)))->result();

		$rest['Code'] = 1;
		$rest['comments'] = $comments;

		return $rest; 
	}

	public function get_post($id_post)
	{	
		/*Get posts paginated*/
		$post = $this->db->query("SELECT a.id_post, a.fecha, a.titulo, a.descripcion, a.recurso, a.tipo_recurso, a.estado, COALESCE(COUNT(distinct b.id_comentario)) AS comentarios, COALESCE(COUNT(distinct c.id_favorito)) AS favoritos
									FROM bns_muro a
									LEFT JOIN bns_muro_comentarios b ON a.id_post = b.id_post
									LEFT JOIN bns_muro_favoritos c ON a.id_post = c.id_post
									WHERE a.estado = 'activo'
									AND a.id_post = ?
									", array(intval($id_post)))->result();

		if (count($post) > 0) 
		{
			$rest['Code'] = 1;
			$rest['Post'] = $post[0];
		}
		else
		{
			$rest['Code'] = 404;
		}


		return $rest;

	}

	public function delete_db($id_post)
	{
		/*Change state to inactivo*/
		$data_update = array('estado' => 'inactivo');

		$this->db->where('id_post', $id_post);

		$this->db->update('bns_muro', $data_update);

		$rest['Code'] = 1;

		return $rest;
	}

	public function update_post($data)
	{	
		$data['recurso'] = $data['old_recurso'];

		/*Validate if resources change*/
		if ($data['tipo_recurso'] == 'imagen' && $data['files']['foto']['name'] != '') 
		{
			/*Upload image*/
			$photo = $this->upload_file('foto', 'imgs_recursos');

			if ($photo) 
			{	
				chown('imgs_recursos/'.$photo['file_name'], 777, 'root');
				unlink('imgs_recursos/'.$data['old_recurso']);
				$data['recurso'] = $photo['file_name'];
				$data['tipo_recurso'] = 'imagen';
			}
			else
			{
				$data['recurso'] = false;
			}
		}
		else if($data['tipo_recurso'] == 'video' && $data['files']['video']['name'] != '')
		{
			/*upload_video*/
			$video = $this->upload_file('video', 'imgs_recursos');


			if ($video) 
			{	
				chown('imgs_recursos/'.$video['file_name'], 777, 'root');
				unlink('imgs_recursos/'.$data['old_recurso']);
				$data['recurso'] = $video['file_name'];
				$data['tipo_recurso'] = 'video';
			}
			else
			{
				$data['recurso'] = false;
			}
		}


		/*crerate post*/
		$data_update = array(
				'titulo' => $data['titulo'],
				'descripcion' => $data['descripcion'],
				'recurso' => $data['recurso']
				);

		$this->db->where('id_post', $data['id_post']);
		$this->db->update('bns_muro', $data_update);

	}

	public function create_post($data)
	{	
		$data['recurso'] = '-';
		$data['tipo_recurso'] = 'texto';

		if ($data['files']['foto']['name'] != '') 
		{
			/*upload_photo*/
			$photo = $this->upload_file('foto', 'imgs_recursos');

			if ($photo) 
			{	
				chown('imgs_recursos/'.$photo['file_name'], 777, 'root');
				$data['recurso'] = $photo['file_name'];
				$data['tipo_recurso'] = 'imagen';
			}
			else
			{
				$data['recurso'] = false;
			}
		}
		else if($data['files']['video']['name'] != '')
		{
			/*upload_video*/
			$video = $this->upload_file('video', 'imgs_recursos');


			if ($video) 
			{	
				chown('imgs_recursos/'.$video['file_name'], 777, 'root');
				$data['recurso'] = $video['file_name'];
				$data['tipo_recurso'] = 'video';
			}
			else
			{
				$data['recurso'] = false;
			}
		}

		/*crerate post*/
		$data_insert = array(
				'fecha' => date('Y-m-d'),
				'titulo' => $data['titulo'],
				'descripcion' => $data['descripcion'],
				'recurso' => $data['recurso'],
				'tipo_recurso' => $data['tipo_recurso'],
				'estado' => 'activo'
				);

		$this->db->insert('bns_muro', $data_insert);
	}

	public function upload_file($newImage, $folder, $fileName = '')
	{
		//RUTA DONDE SE GUARDA
		$config['upload_path'] = $folder;

		//TYPES OF FILES
		$config['allowed_types'] = '*';
	
		if ($fileName != '') 
		{
			$config['file_name'] = $fileName;

			//NO SOBRE ESCRIBIR
			$config['overwrite'] = TRUE;
		}	
		else
		{
			//NO SOBRE ESCRIBIR
			$config['overwrite'] = FALSE;
			
			//ENCRIPTA EL fullname
			$config['encrypt_name'] = TRUE;
		}		
			
		
		/*Cargamos la libreria*/
		$this->load->library('upload', $config);

	    //INICIALIZA LA CONFIGURACION
	    $this->upload->initialize($config);

	    //TOMA LA IMAGEN
	    if ($this->upload->do_upload($newImage)) 
	    {	    	
	    	//Obtiene la información de la imagen
	    	$data = $this->upload->data(); 

	    	//Retorna la información de la imagen       
	    	return $data;
	    }	
	    else
	    {	
	    	die($this->upload->display_errors());
	    	$img_error = $this->upload->display_errors();
	    	$this->session->set_flashdata($img_error);
	    	return false;
	    }    
	}
}