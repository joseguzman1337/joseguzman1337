<?php
function writeForm($edit, $id="", $db) {
    $data = array();
    $action = "save";
	$tipos =$db->GetAll("SELECT * FROM TipoPublicacion WHERE codigoestado=100");
    if($edit){
        $action = "update";
        if($id!=""){                
			   $data =$db->GetRow("SELECT n.*,u.usuario,CONCAT(u.nombres,' ',u.apellidos) as nombre FROM NoticiaEvento n 
			   LEFT JOIN usuario u on u.idusuario=n.UsuarioCreacionId 
			   WHERE n.NoticiaEventoId=".$id);
        }
    }

?>
<div id="form"> 
    <div id="msg-error"></div>
    
    <form action="processNoticias.php" method="post" name="publicaciones" id="publicaciones" enctype="multipart/form-data">
            <input type="hidden" name="entity" value="NoticiaEvento" />
            <input type="hidden" name="action" id="action" value="<?php echo $action; ?>" />
            <input type="hidden" name="reload" value="1" />
            <?php
            if($edit&&$id!=""){
                echo '<input type="hidden" name="NoticiaEventoId" value="'.$id.'">';
            }
            ?>
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Información Noticia</legend>
                <label for="titulonoticia" class="grid-2-12">Titulo: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-5-12 required" name="titulonoticia" id="titulonoticia" title="Titulo de la noticia" maxlength="150" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['TituloNoticia']; } ?>" />
            
                <label for="descnoticia" class="grid-2-12">Descripción: </label>
                <input type="text" class="grid-5-12" name="descnoticia" id="descnoticia" title="Descripción de la noticia" maxlength="150" tabindex="1" autocomplete="off" value="<?php if($edit){ echo $data['DescripcionNoticia']; } ?>" />
            
                <label for="tipopublicacion" class="grid-2-12">Tipo: <span class="mandatory">(*)</span></label>
				<select name="tipopublicacion">
					<?php foreach($tipos as $tipo){ ?>
					<option value="<?php echo $tipo["TipoPublicacionId"]; ?>" <?php if($tipo["TipoPublicacionId"]==$data["Tipo"]){ echo "selected"; }?>><?php echo $tipo["NombreTipo"]; ?></option>
					<?php } ?>
				</select>
				
                <label for="fechainicio" class="grid-2-12">Fecha Inicio: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-2-12 required" minlength="2" name="fechainicio" id="fechainicio" title="Fecha de Inicio Vigencia" maxlength="20" tabindex="1" readonly="readonly" autocomplete="off" value="<?php if($edit){ echo $data['FechaInicioVigencia']; } ?>" />
            
                <label for="fechafin" class="grid-2-12">Fecha Fin: <span class="mandatory">(*)</span></label>
                <input type="text"  class="grid-2-12 required" minlength="2" name="fechafin" id="fechafin" title="Fecha Final de Vigencia" maxlength="20" tabindex="1" readonly="readonly" autocomplete="off" value="<?php if($edit){ echo $data['FechaFinalVigencia']; } ?>" />
            
				<label for="firma" class="grid-2-12">Imagen vertical (380 x 450px): </label>
                <input type="file" name="file" id="file" style="margin-bottom:3px;">
				<span style='float:left;margin-left:10px;margin-top:1px;font-size:0.8em'>Puede dejar este campo en blanco si<br/>no desea mostrar una imagen.</span>
                
				<div class="vacio"></div>
				<span style="margin-left:15%;"></span><span style="margin-left:17px;font-size:0.8em;">Imagenes de tipo gif, png y jpg.</span>
				
				<div class="vacio" style="margin-bottom:10px;"></div>
				<label for="firma" class="grid-2-12">Imagen horizontal (900 x 250px): </label>
                <input type="file" name="file2" id="file2" style="margin-bottom:3px;">
				<span style='float:left;margin-left:10px;margin-top:1px;font-size:0.8em'>Puede dejar este campo en blanco si<br/>no desea mostrar una imagen.</span>
                
				<div class="vacio"></div>
				<span style="margin-left:15%;"></span><span style="margin-left:17px;font-size:0.8em;">Imagenes de tipo gif, png y jpg.</span>
            </fieldset>
            
            <?php if($edit){ ?><input type="submit" value="Guardar cambios" class="first" />
            <?php } else { ?><input type="submit" value="Registrar noticia" class="first" /> <?php } ?>
        </form>
</div>

<script type="text/javascript">
    $(':submit').click(function(event) {
        event.preventDefault();
        var valido= validateForm("#publicaciones");
        
        if(valido){ 
            if($('#file').val()!="" || $('#file2').val()!=""){
                var ext = $('#file').val().split('.').pop().toLowerCase();
                var ext2 = $('#file2').val().split('.').pop().toLowerCase();
                if($.inArray(ext, ['gif','png','jpg','jpeg','PNG','JPG']) == -1 || $.inArray(ext2, ['gif','png','jpg','jpeg','PNG','JPG']) == -1) {
                    alert('Extensión no válida. Solo puede subir imagenes de tipo: gif, png, jpg o jpeg.');
                } else { 
                   document.publicaciones.submit();
                } 
            } else if($('#descnoticia').val()!="") {                
                document.publicaciones.submit();
            } else if($('#action').val()!="update") {
				alert("Debe incluir ambas imagenes o agregar una descripción antes de continuar.");
			} else {
				document.publicaciones.submit();
			}
        } 
            
    });
    
    /*function sendForm(){
         $.ajax({
            dataType: 'json',
            type: 'POST',
            url: 'processNoticias.php',
            data: $('#form_test').serialize(),                
            success:function(data){
                if (data.success == true){
                    alert(data.message);
                    window.location.href="noticias.php";
                }
                else{                        
                    $('#msg-error').html('<p>' + data.message + '</p>');
                    $('#msg-error').addClass('msg-error');
                }
            },
            error: function(data,error,errorThrown){alert(error + errorThrown);}
         });            
    }*/
	
	$(function() {
                        
                    $( "#fechainicio" ).datepicker({
                        defaultDate: "+0d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "+0d"
                        }
                    );
                    
                    $( "#fechafin" ).datepicker({
                        defaultDate: "+0d",
                        changeMonth: true,
                        dateFormat: "yy-mm-dd",
                        minDate: "+0d"
                        }
                    );
                        
                    $( "#ui-datepicker-div" ).hide();
        });
    
</script>
<?php } ?>
