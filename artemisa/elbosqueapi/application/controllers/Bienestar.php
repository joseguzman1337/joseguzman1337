<?php

class Bienestar extends CI_Controller{

	public function __construct() {
      	parent::__construct();
		$this->load->model('bienestar_model','modelo');
 	}


 	public function index()
 	{	
 		/*Define title page*/
 		$data['title'] = 'Muro de bienestar';

 		/*Set pagination*/
 		$this->load->library('pagination'); //Cargamos la librería de paginación	

		/*Configuramos la paginacion*/
		$config['base_url'] = base_url().'posts';
		$config['first_url'] = base_url().'posts';
		$config['prefix'] = '/page/';
		$config['use_page_numbers'] = TRUE;
		$config['total_rows'] = $this->modelo->total_post();
		$config['per_page'] = 50;
		$config['num_links'] = 2;
		$config['uri_segment'] = 3;
		
		/*Pagination styles*/
		$config['full_tag_open'] 	= '<div class="pagging text-center"><ul class="pagination">';
		$config['full_tag_close'] 	= '</ul></div>';
		$config['num_tag_open'] 	= '<li class="page-item"><span class="page-link">';
		$config['num_tag_close'] 	= '</span></li>';
		$config['cur_tag_open'] 	= '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] 	= '<span class="sr-only">(current)</span></span></li>';
		$config['next_tag_open'] 	= '<li class="page-item"><span class="page-link">';
		$config['next_tagl_close'] 	= '<span aria-hidden="true">&raquo;</span></span></li>';
		$config['prev_tag_open'] 	= '<li class="page-item"><span class="page-link">';
		$config['prev_tagl_close'] 	= '</span></li>';
		$config['first_tag_open'] 	= '<li class="page-item"><span class="page-link">';
		$config['first_tagl_close'] = '</span></li>';
		$config['last_tag_open'] 	= '<li class="page-item"><span class="page-link">';
		$config['last_tagl_close'] 	= '</span></li>';
		$config['first_link'] = '<<';
		$config['last_link'] = '>>';

		/*Set first link*/
		$start = 1;

		if($this->uri->segment(3))
		{
			$start = $this->uri->segment(3);
		}

		/*Inicioamos la paginacion*/
		$this->pagination->initialize($config);

 		/*Get posts*/
 		$data['post'] = $this->modelo->get_posts($start, $config['per_page']);

 		/*Load view*/
 		$this->load->view('bienestar/bienestar', compact('data'));
 	}

 	public function get_post()
 	{
 		if ($this->input->is_ajax_request()) 
 		{
 			/*Recibimos la información del post*/
 			$data = $_POST;

 				/*Llamamos la función del modelo encargada de crear la categoría y le pasamos la información*/
 			$rest = $this->modelo->get_post($data['id_post']);

 			echo json_encode($rest);
 		}
 		else
 		{
 			/*Si no es ajax lanzamos 404*/
 			show_404();
 		}
 	}

 	public function get_commets()
 	{
 		if ($this->input->is_ajax_request()) 
 		{
 			/*Recibimos la información del post*/
 			$data = $_POST;

 			/*Llamamos la función del modelo encargada de crear la categoría y le pasamos la información*/
 			$rest = $this->modelo->get_commets($data['id_post']);

 			echo json_encode($rest);
 		}
 		else
 		{
 			/*Si no es ajax lanzamos 404*/
 			show_404();
 		}
 	}

 	public function delete_db()
 	{
 		/*Validamos si es ajax*/
		if (true) 
		{
			/*Recibimos la información del post*/
			$data = $_POST;

				/*Llamamos la función del modelo encargada de crear la categoría y le pasamos la información*/
			$rest = $this->modelo->delete_db($data['id_post']);

			echo json_encode($rest);
		}
		else
		{
			/*Si no es ajax lanzamos 404*/
			show_404();
		}
 	}

 	public function update_post()
 	{
 		/*Validamos si es ajax*/
 		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
 		{
 			/*Recibimos la información del post*/
 			$data = $this->input->post();
 			$data['files'] = $_FILES;

 			/*Llamamos la función del modelo encargada de crear la categoría y le pasamos la información*/
 			$id_banner = $this->modelo->update_post($data);

 			redirect(base_url());
 		}
 		else
 		{
 			/*Si no es ajax lanzamos 404*/
 			show_404();
 		}
 	}

 	public function create_post()
	{
		/*Validamos si es ajax*/
		if ($_SERVER['REQUEST_METHOD'] == 'POST') 
		{
			/*Recibimos la información del post*/
			$data = $this->input->post();
			$data['files'] = $_FILES;

				/*Llamamos la función del modelo encargada de crear la categoría y le pasamos la información*/
			$id_banner = $this->modelo->create_post($data);

			redirect(base_url());
		}
		else
		{
			/*Si no es ajax lanzamos 404*/
			show_404();
		}
	}

}