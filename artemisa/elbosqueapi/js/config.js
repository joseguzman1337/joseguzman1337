var base_url = 'https://artemisa.unbosque.edu.co/elbosqueapi/index.php/';
var base_url_img = 'https://artemisa.unbosque.edu.co/elbosqueapi/'; 

var _URL = window.URL || window.webkitURL;
$(document).ready(function(){

	$('#btn_actualizar').click(function(event){

		event.preventDefault();
		$('#form_error_ed').hide();

		if ($('#titulo_act').val() == '') 
		{
			$('#titulo_act').focus();
			$('#form_error_ed').html('Ingresa un título');
			$('#form_error_ed').show();
		}
		else if ($('#contenido_act').val() == '') 
		{
			$('#contenido_act').focus();
			$('#form_error_ed').html('Ingresa un contenido');
			$('#form_error_ed').show();
		}
		else
		{	
			$(this).attr('disabled',true);
			$('#form_actualizar').submit();
		}

	});

	

	$('#input_img_act').bind('change', function() {
        $('#form_error').html('');

        
        if ($('#input_img_act').val() == '')
        {
        	return false;
        }

        var size = this.files[0].size /1000000;
        var file, img;
        var type = this.files[0].type.split('/')[1];

        if ((file = this.files[0])) 
        {	
            img = new Image();

			$('#form_error_ed').hide();

            img.onload = function () {
                if (this.width  != this.height)
                {
                    $('#form_error_ed').html("La imagen debe ser cuadrada");
                    $('#label_recurso_act').html('');
                    $('#input_img_act').val('');
					$('#form_error_ed').show();
                }
                else if(this.width < 600 || this.height < 600)
                {
                	$('#form_error_ed').html("La imagen debe mínimo de 600x600");
                    $('#label_recurso_act').html('');
                    $('#input_img_act').val('');
					$('#form_error_ed').show();
                }
                else if(type != 'png' && type != 'jpg' && type != 'jpeg')
                {
                    $('#form_error_ed').html("Formato de la imagen incorrecto");
                    $('#label_recurso_act').html('');
                    $('#input_img_act').val('');
					$('#form_error_ed').show();
                }
            }

            img.src = _URL.createObjectURL(file);
        }
    });

     $('#input_video_act').bind('change', function() {
        $('#form_error_ed').html('');

        var size = this.files[0].size /1000000;
        var file, img;


        if ((file = this.files[0])) 
        {	

            img = new Image();

			$('#form_error_ed').hide();

			if (size > 5)
            {
                $('#form_error_ed').html("El video no debe pesar más de 5MG");
                $('#label_recurso_act').html('');
                $('#input_video_act').val('');
				$('#form_error_ed').show();
            }

            img.onload = function () {
                if (size > 5)
                {
                    $('#form_error_ed').html("El video no debe pesar más de 5MG");
                    $('#label_recurso_act').html('');
                    $('#input_video_act').val('');
					$('#form_error_ed').show();
                }
            }

            img.src = _URL.createObjectURL(file);
        }
    });

	

	$('#input_foto').bind('change', function() {
        $('#form_error').html('');

        if ($('#input_foto').val() == '')
        {
        	return false;
        }

        var size = this.files[0].size /1000000;
        var file, img;
        var type = this.files[0].type.split('/')[1];

        if ((file = this.files[0])) 
        {
            img = new Image();

			$('#form_error').hide();

            img.onload = function () {
                if (this.width  != this.height)
                {
                    $('#form_error').html("La imagen debe ser cuadrada");
                    $('#label_recurso').html('');
                    $('#input_foto').val('');
					$('#form_error').show();
                }
                else if(this.width < 600 || this.height < 600)
                {
                    $('#form_error').html("La imagen debe mínimo de 600x600");
                    $('#label_recurso').html('');
                    $('#input_foto').val('');
					$('#form_error').show();
                }
                else if(type != 'png' && type != 'jpg' && type != 'jpeg')
                {
                    $('#form_error').html("Formato de la imagen incorrecto");
                    $('#label_recurso').html('');
                    $('#input_foto').val('');
					$('#form_error').show();
                }
            }

            img.src = _URL.createObjectURL(file);
        }
    });

    $('#input_video').bind('change', function() {
        $('#form_error').html('');

        var size = this.files[0].size /1000000;
        var file, img;

        if ((file = this.files[0])) 
        {
            img = new Image();

			$('#form_error').hide();

			if (size > 5)
            {
                $('#form_error').html("El video no debe pesar más de 5MG");
                $('#label_recurso').html('');
                $('#input_video').val('');
				$('#form_error').show();
            }

            img.onload = function () {
                if (size > 5)
                {
                    $('#form_error').html("El video no debe pesar más de 5MG");
                    $('#label_recurso').html('');
                    $('#input_video').val('');
					$('#form_error').show();
                }
            }

            img.src = _URL.createObjectURL(file);
        }
    });
	
	$('#btn_publicar').click(function(event){

		event.preventDefault();
		$('#form_error').hide();

		if ($('#titulo').val() == '') 
		{
			$('#titulo').focus();
			$('#form_error').html('Ingresa un título');
			$('#form_error').show();
		}
		else if ($('#contenido').val() == '') 
		{
			$('#contenido').focus();
			$('#form_error').html('Ingresa un contenido');
			$('#form_error').show();
		}
		else
		{	
			$(this).attr('disabled',true);
			$('#form_crear').submit();
		}

	});

	$('.input_file').change(function(){
		$($(this).data('target')).html($(this).val());
	});

	$('.btn_upload').click(function(){
		$($(this).data('target')).trigger('click');
	});

	$('#input_video').change(function(){
		$('#input_foto').val("");	
	});

	$('#input_foto').change(function(){
		$('#input_video').val("");	
	});	



});

var id_post = 0;

function lanzar_ppup_editar(_id_post)
{
	id_post = _id_post;

	/*Get post data*/
	var dataSend = new Object();
	dataSend['id_post'] = id_post;

	$('.loader_normal').toggle();
	$('#img_update').hide();
	$('#content_video').hide();
	$('#img_update input').val('');
	$('#content_video input').val('');
	$('#label_recurso_act').html("");

	$.ajax({
		url:base_url+'get_post',
		data:dataSend,
		dataType:'JSON',
		type:'POST',
		success:function(json){

			if (json['Code'] == 1)
			{	
				$('#id_post').val(json['Post']['id_post']);
				$('#tipo_recurso').val(json['Post']['tipo_recurso']);
				$('#titulo_act').val(json['Post']['titulo']);
				$('#contenido_act').val(json['Post']['descripcion']);
				$('#old_recurso').val(json['Post']['recurso']);

				if (json['Post']['tipo_recurso'] == 'imagen')
				{
					$('#img_update img').attr('src', base_url_img+'imgs_recursos/'+json['Post']['recurso']);
					$('#img_update').show();
				}
				else if (json['Post']['tipo_recurso'] == 'video')
				{
					
					$('#content_video video').attr('src', base_url+'imgs_recursos/'+json['Post']['recurso']);
					$('#content_video').show();

				}

				$('.loader_normal').toggle();
				$('.updateModal').modal('toggle');
			}
			else if(json['Code'] == 0)
			{
				location.reload();
			}
			else if(json['Code'] == 102)
			{	
				$('.loader_normal').toggle();
			}
		},
		error:function(error){
			$('.loader_normal').toggle();
		}
	});
}

function eliminar_post(_id_post)
{
	id_post = _id_post;

	$('.sureModal').modal('toggle');

	$('.sureModal button').show();

}

function eliminar_post_db(element)
{
	var dataSend = new Object();
	dataSend['id_post'] = id_post;

	$('.loader_popup').toggle();
	$('.sureModal button').hide();

	$.ajax({
		url:base_url+'eliminar_db',
		data:dataSend,
		dataType:'JSON',
		type:'POST',
		success:function(json){

			if (json['Code'] == 1)
			{	
				$('.loader_popup').toggle();

				$('#form_success_des').html("Post eliminado con éxito");
				$('#form_success_des').toggle();

				setTimeout(function(){
					location.reload();
				},3000);
			}
			else if(json['Code'] == 0)
			{
				location.reload();
			}
			else if(json['Code'] == 102)
			{	
				$('.loader_popup').toggle();
			}
		},
		error:function(error){
			$('.loader_popup').toggle();
		}
	});
}

function popup_comments(_id_post)
{	
	var dataSend = new Object();
	dataSend['id_post'] = _id_post;

	$.ajax({
		url:base_url+'get_commets',
		data:dataSend,
		dataType:'JSON',
		type:'POST',
		success:function(json){

			if (json['Code'] == 1)
			{	
				if (json['comments'].length > 0)
				{
					html = '';

					for (var i = 0; i < json['comments'].length; i++) 
					{
						html = html + '<div>';
						html = html + '<p class="text_green bold no_margin">'+json['comments'][i]['fecha']+'</p>';
						html = html + '<p>'+json['comments'][i]['comentario']+'</p>';
						html = html + '</div> <hr>';
					}

				}
				else
				{

					html = '<p>No hay comentarios disponibles</p>';
				}
				
				$('#table_coments').html(html);

				$('.commentsModal').modal('toggle');
			}
			else if(json['Code'] == 0)
			{
				location.reload();
			}
			else if(json['Code'] == 102)
			{	
				$('.loader_popup').toggle();
			}
		},
		error:function(error){
			$('.loader_popup').toggle();
		}
	});
}