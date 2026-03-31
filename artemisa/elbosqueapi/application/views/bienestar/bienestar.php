<!DOCTYPE html>
<html>
<head>
	<title><?php echo $data['title'] ?></title>
	<meta charset="utf-8">
	<link rel="icon" href="<?php echo base_url() ?>images/ueb_favicon.ico" type="image/png"/> 
	<link href="<?php echo base_url() ?>css/fonts.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url() ?>css/jquery-ui.css">
	<link rel="stylesheet" href="<?php echo  base_url()  ?>css/bootstrap/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>css/config.css?<?php echo config_item('version') ?>">
	<script src="<?php echo base_url() ?>js/jquery.js" type="text/javascript"></script>
	<script src="<?php echo base_url() ?>js/bootstrap/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>js/config.js?<?php echo config_item('version') ?>"></script>
</head>
<body>

<header>
	<nav class="navbar navbar-light bg-light">
	  <a class="navbar-brand" href="#">
	    <a href="<?php echo base_url() ?>"><img id="logo_header" src="<?php echo base_url() ?>images/logo_bosque.png" class="d-inline-block align-top navbar-right" alt=""></a>
	  </a>
	</nav>

</header>

<div id="content">

	<div class="loader loader_normal display_none"></div>
	
	<button type="button" class="btn btn_green float-right" data-toggle="modal" data-target=".createModal" style="width:270px">AGREGAR PUBLICACIÓN</button>

	<div class="modal fade sureModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	  <div class="modal-dialog ">
	    <div class="modal-content">
	    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">×</span>
	        </button>
	        <h4 class="bold align_center">¿Está seguro de eliminar esta publicación?</h4>
	        <div>
	        	<br>
					<div class="loader loader_popup display_none"></div>
					<div class="alert alert-success display_none" id="form_success_des">
					</div>
	        	<br>
	        	<div id="content_buttons" class="align_center">
	        		<button onclick="$('.sureModal').modal('toggle');" style="max-width:120px;" class="btn btn_green">CANCELAR</button>
	        		<button style="max-width:120px;" class="btn btn_white_black" onclick="eliminar_post_db(this)">ELIMINAR</button>
	        	</div>
	        </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade commentsModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
	  <div class="modal-dialog ">
	    <div class="modal-content">
	    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">×</span>
	        </button>
	        <h5 class="bold">Comentarios:</h5>
	        <div id="table_coments">
	        	<div>
	        		<p>Comentario: Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
	        		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
	        		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
	        		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
	        		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
	        		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	        	</div>
	        	<hr>
	        </div>
	    </div>
	  </div>
	</div>

	<div class="modal fade updateModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">×</span>
	        </button>
	        <form id="form_actualizar" method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>index.php/actualizar_post">
	        	<input type="hidden" name="id_post" id="id_post">
	        	<input type="hidden" name="tipo_recurso" id="tipo_recurso">
	        	<input type="hidden" name="old_recurso" id="old_recurso">
		     	<table id="table_crear">
		     		<tr>
		     			<td>

		     				<div id="content_upload">
		     					<div id="img_update" class="display_none">
		     						<img src="" class="img_update">
		     						<div data-target="#input_img_act" class="btn btn_white btn_upload" style="max-width: 230px;">CAMBIAR IMAGEN</div>
		     						<input accept="image/*" id="input_img_act" data-target="#label_recurso_act" type="file" class="input_file" name="foto">
		     					</div>
		     					<div id="content_video" class="display_none">
		     						<video controls>
		     						  Your browser does not support the video tag.
		     						</video>
		     						<div data-target="#input_video_act"  class="btn btn_white btn_upload" style="max-width: 230px;">CAMBIAR VIDEO</div>
		     						<input accept="video/*" id="input_video_act" data-target="#label_recurso_act" type="file" class="input_file" name="video">
		     					</div>
		     					<div id="label_recurso_act"></div>
		     				</div>
		     				
		     			</td>
		     			<td>
		     				<p class="no_margin">Título:</p>
		     				<input type="text" maxlength="60" id="titulo_act" placeholder="Máximo sesenta (60) caracteres" name="titulo">
		     			</td>
		     		</tr>
		     		<tr>
		     			<td colspan="2">
		     				<p class="no_margin">Contenido</p>
		     				<textarea id="contenido_act" maxlength="150" name="descripcion" placeholder="Máximo 150 caracteres"></textarea>
		     			</td>
		     		</tr>
		     		<tr>
		     			<td colspan="2" class="align_right">
			     			<div class="alert alert-danger display_none" id="form_error_ed">
			     			</div>
		     				<button id="btn_actualizar" class="btn btn_white_black" style="max-width: 230px;">ACTUALIZAR</button>
		     			</td>
		     		</tr>
		     	</table>
	     	</form>
	    </div>
	  </div>
	</div>


	<div class="modal fade createModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	    	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">×</span>
	        </button>
	        <form id="form_crear" method="POST" enctype="multipart/form-data" action="<?php echo base_url() ?>index.php/crear_post">
		     	<table id="table_crear">
		     		<tr>
		     			<td>

		     				<div id="content_upload">
		     					<p class="no_margin">Proporción 1:1 (Cuadrada)</p>
		     					<div id="content_buttons">
		     						<div data-target="#input_video" style="max-width: 100px;" class="btn btn_orange btn_upload">VIDEO</div>
		     						<input accept="video/*" id="input_video" data-target="#label_recurso" type="file" class="input_file" name="video">
		     						<div data-target="#input_foto" style="max-width: 100px;" class="btn btn_green btn_upload">FOTO</div>
		     						<input accept="image/*" id="input_foto" type="file" data-target="#label_recurso" class="input_file" name="foto">
		     						<div id="label_recurso">
		     							
		     						</div>

		     					</div>
		     					
		     				</div>
		     			</td>
		     			<td>
		     				<p class="no_margin">Título:</p>
		     				<input type="text" maxlength="60" id="titulo" placeholder="Máximo sesenta (60) caracteres" name="titulo">
		     			</td>
		     		</tr>
		     		<tr>
		     			<td colspan="2">
		     				<p class="no_margin">Contenido</p>
		     				<textarea id="contenido" maxlength="150" name="descripcion" placeholder="Máximo 150 caracteres"></textarea>
		     			</td>
		     		</tr>
		     		<tr>
		     			<td colspan="2" class="align_right">
			     			<div class="alert alert-danger" id="form_error">
			     			</div>
		     				<button id="btn_publicar" class="btn btn_white_black" style="max-width: 230px;">PUBLICAR</button>
		     			</td>
		     		</tr>
		     	</table>
	     	</form>
	    </div>
	  </div>
	</div>
	<h3 class="text_blue bold">Muro de bienestar</h3>

	<?php if (count($data['post']) > 0): ?>
			<?php foreach ($data['post'] as $post): ?>

			    <div class="card" >
			       	<?php if ($post->tipo_recurso == 'imagen'): ?>
			       		<div class="content_recurso">
			       			<img class="card-img-top" src="<?php echo base_url() ?>imgs_recursos/<?php echo $post->recurso ?>" alt="Card image cap">
			       		</div>
			       	<?php elseif($post->tipo_recurso == 'video'): ?>
			       		<div class="content_recurso">
				       		<video src="<?php echo base_url() ?>imgs_recursos/<?php echo $post->recurso ?>" controls>
				       		  Your browser does not support the video tag.
				       		</video>
			       		</div>
			       	<?php endif ?>
			     	<div class="card-body">
			      		<p class="card-text"><?php echo $post->fecha ?></p>
			        	<h4 class="card-text text_green bold"><span class="link" onclick="lanzar_ppup_editar(<?php echo $post->id_post ?>)"><?php echo $post->titulo ?></span></h4>
			        	<p class="card-text"><?php echo $post->descripcion ?></p>
			        	<p class="align-bottom"><b> <span onclick="popup_comments(<?php echo $post->id_post ?>)" class="link"><?php echo $post->comentarios ?> comentarios </span> · <?php echo $post->favoritos ?> favoritos</b></p>
			      	</div>
			      	<img onclick="eliminar_post(<?php echo $post->id_post ?>)" class="btn_close" src="<?php echo base_url() ?>images/btn_limpiar.png">
			    </div>
			<?php endforeach ?>
		</table>
		<div class="div_pagination">
			<?php echo $this->pagination->create_links();  ?>
		</div>
	<?php else: ?>
		<div id="content_no_data" class="align_center">
			<img src="<?php echo base_url() ?>images/img_vacio.png" >
			<p class="align_center">No hay información para mostrar</p>
			<button class="btn btn_white" style="width:270px" data-toggle="modal" data-target="#createModal">AGREGAR PUBLICACIÓN</button>
		</div>
	<?php endif ?>

	

</div>

</body>
</html>