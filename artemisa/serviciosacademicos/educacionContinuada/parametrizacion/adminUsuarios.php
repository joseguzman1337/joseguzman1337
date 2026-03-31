<?php

session_start;
	/*include_once(realpath(dirname(__FILE__)).'/../../utilidades/ValidarSesion.php'); 
    $ValidarSesion = new ValidarSesion();
    $ValidarSesion->Validar($_SESSION);*/
	
	include_once(realpath(dirname(__FILE__))."/../variables.php");
    include($rutaTemplate."template.php");
    $db = writeHeader("Administrar Usuarios y Roles",TRUE);

    include("./menu.php");
    writeMenu(3);
    $utils = Utils::getInstance();
	$user = $utils->getUser();
if($utils->esAdministrador($db,$user["usuario"])) {
	$usuariosAdmin = $utils->getUsuariosAdministradores($db);
	$usuariosFuncionarios = $utils->getUsuariosFuncionarios($db);
	//var_dump($usuariosAdmin); echo "<br/><br/>"; var_dump($usuariosFuncionarios);
?>  

    <div id="contenido">
        <!--<h4>Administrar Usuarios y Roles</h4>-->
        <div id="form"> 
			<div id="msg-error"><?php echo $_REQUEST["mensaje"]; ?></div>
    
    <form action="process.php" method="post" id="form_test" style="margin-top:20px;"  >
            <input type="hidden" name="entity" value="usuarios" />
            <input type="hidden" name="action" value="asociarUsuarios" />
            
            <span class="mandatory">* Son campos obligatorios</span>
            <fieldset>   
                <legend>Administrar Usuarios y Roles</legend>  
                
                <div class="seccionBox">
                    <h4>Agregar permisos a un usuario de Sala</h4>
                    <label for="nombre" >Nombre/Usuario: </label>
                     <input type="text"  class="grid-5-12" minlength="2" name="nombreUsuario" id="nombreUsuario" title="Nombre del usuario" maxlength="200" tabindex="1" autocomplete="off" value="" /> 
						<select id="rolUsuario" name="rolUsuario" style="padding:2px;height:auto;">
							<option value="1">Funcionario</option>
							<option value="2">Administrador</option>
						</select>
                              <input type="button" class="first small" id="agregarPermisos" value="Agregar permisos"> 
					<input type="hidden" value="" id="idUsuario" name="idUsuario" />
               </div>
                            
               <div class="vacio"></div>
               
               <div class="seccionBox">
                    <h4>Eliminar permisos a un usuario</h4>
                    <label for="nombre" >Nombre/Usuario: </label>
                     <input type="text"  class="grid-5-12" minlength="2" name="nombreUsuarioEliminar" id="nombreUsuarioEliminar" title="Nombre del usuario" maxlength="200" tabindex="1" autocomplete="off" value="" />             
                          <input type="button" class="first small" id="eliminarPermisos" value="Eliminar permisos">  
						<input type="hidden" value="" id="idUsuarioEliminar" name="idUsuarioEliminar" />						  
               </div>
                            
               <div class="vacio"></div>
                
				
				<!-- Usuarios de EC -->
				<table style="border: 0px;margin:20px 70px 0;">  
                    <tr>
                        <td valign="top" colspan="2" style="padding: 0.5em 0 0;">
                                    <legend>Usuarios Administradores</legend>
                                    <div id="fastLiveFilter" style="width:480px; height:520px; overflow: scroll;" >
                                      
                                      <ul id="sortable1" class="connectedSortable" style="min-height: 460px">  
                                            <li class="ui-state-highlight" id="0">Arrastrar hasta aquí</li>
                                            <?php
                                            if (!empty($usuariosAdmin)){
                                                    $i=0;
                                                    //var_dump($indicadores);
                                                    foreach($usuariosAdmin as $dt_sec){
                                                    // print_r($dt);
                                                           $nombre=$dt_sec['nombre']." (".$dt_sec['usuario'].")";
                                                            $id_in=$dt_sec['idusuario'];
                                                    
                                                        //$id=$dt_sec['codigo'];
                                                        echo '<li class="ui-state-default idUsuario'.$id_in.' usuarioAdmin" id="'.$id_in.' ">'.$nombre;
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                      </ul>
                                   </div>
                        </td>
                        <td  valign="top" colspan="2" style="padding: 0.5em 0 0;">
                                     <legend>Usuarios Funcionarios</legend>
                                     <div id="indicadoresAsociados" style="width:480px; height:520px; overflow: scroll;">
                                         
                                        <ul id="sortable2" class="connectedSortable" style="min-height: 490px">
                                            <li class="ui-state-highlight" id="0">Arrastrar hasta aquí
                                            </li>
                                            <?php
                                            if (!empty($usuariosFuncionarios)){
                                                    $i=0;
                                                    //var_dump($indicadores);
                                                    foreach($usuariosFuncionarios as $dt_sec){
                                                    // print_r($dt);
                                                           $nombre=$dt_sec['nombre']." (".$dt_sec['usuario'].")";
                                                            $id_in=$dt_sec['idusuario'];
                                                    
                                                        //$id=$dt_sec['codigo'];
                                                        echo '<li class="ui-state-default idUsuario'.$id_in.' usuarioFuncionario" id="'.$id_in.' ">'.$nombre;
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                        </ul>
                                     </div>                                    
                        </td>
                    </tr>
                </table>
                
            </fieldset>
            
			<!--<input type="submit" value="Guardar cambios" class="first" style="margin-left:10px;" />-->
        </form>
</div>
  
<script type="text/javascript">
       $(function() {
                $( "#sortable1, #sortable2" ).sortable({
                    connectWith: ".connectedSortable",
                    dropOnEmpty: true,
                    //placeholder: "ui-state-highlight",
                    start: function(e,ui){
                        ui.placeholder.height(ui.item.height());
                    }
                });
            });
			
			$('#agregarPermisos').click(function(e){
				if($("#idUsuario").val()==""){
					alert("Debe seleccionar un usuario primero.");
				} else {
						$.ajax({
							dataType: 'json',
							type: 'POST',
							url: 'process.php',
							data: {
										usuario: $("#idUsuario").val(),
										rol: $("#rolUsuario").val(),
										action: "agregarPermisosUsuario"
							},                
							success:function(data){
								if (data.success == true){
                                                                        reloadUsers();
									alert("Los permisos han sido agregados de forma correcta.");
									resetData();
								}
								else{      
									alert(data.message);
								}
							},
							error: function(data,error,errorThrown){alert(error + errorThrown);}
						});
					}
			});
			
			$('#eliminarPermisos').click(function(e){
                                if($("#idUsuarioEliminar").val()==""){
					alert("Debe seleccionar un usuario primero.");
				} else {
						$.ajax({
							dataType: 'json',
							type: 'POST',
							url: 'process.php',
							data: {
								usuario: $("#idUsuarioEliminar").val(),
								action: "eliminarPermisosUsuario"
							},                
							success:function(data){
								if (data.success == true){
                                                                        reloadUsers();
									alert("Los permisos han sido eliminados de forma correcta.");
									resetData2();
								}
								else{      
									alert(data.message);
								}
							},
							error: function(data,error,errorThrown){alert(error + errorThrown);}
						});
					}
			
			});
			
			$(document).ready(function() {
                $('#nombreUsuario').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForUsers.php",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-100;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            $('#idUsuario').val(ui.item.id);
                        }                
                    });
					
		$('#nombreUsuarioEliminar').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searches/lookForUsersEC.php",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function( data ) {
                                    response( $.map( data, function( item ) {
                                        return {
                                            label: item.label,
                                            value: item.value,
                                            id: item.id
                                        }
                                    }));
                                }
                            });
                        },
                        minLength: 2,
                        selectFirst: false,
                        open: function(event, ui) {
                            var maxWidth = $('#form_test').width()-100;  
                            var width = $(this).autocomplete("widget").width();
                            if(width>maxWidth){
                                $(".ui-autocomplete.ui-menu").width(maxWidth);                                 
                            }
                        },
                        select: function( event, ui ) {
                            $('#idUsuarioEliminar').val(ui.item.id);
                        }                
                    });
                    
                });
                
                $('#nombreUsuario').bind("change", function(){
                    if($('#nombreUsuario').val()==""){
                        resetData();
                    }
               });
			   
			   $('#nombreUsuarioEliminar').bind("change", function(){
                    if($('#nombreUsuarioEliminar').val()==""){
                        resetData2();
                    }
               });
               
               function resetData(){
                   $('#nombreUsuario').val("");
                   $('#idUsuario').val("");         
               } 
			   
	function resetData2(){
                   $('#nombreUsuarioEliminar').val("");
                   $('#idUsuarioEliminar').val("");         
               }
               
          $( "#sortable1" ).bind( "sortupdate", function(event, ui) {
            var clases=ui.item.attr('class').split(" "); 
            if(clases.length>1){
                var id=clases[1].replace("idUsuario",""); 
                var action2 = "eliminarPermisosUsuario";
                    var rol = 2;
                if($(".idUsuario"+id).hasClass("usuarioAdmin")){
                    rol = 1;
                } 

                var order = 'usuario=' + id + '&rol='+rol+'&action='+action2;
                 var posting = $.post("process.php", order);
                
                    posting.done(function( data ) {
                        var json = $.parseJSON(data); // create an object with the key of the array
                        if (json.success == true){
                                    //ahora vuelvo a activar los permisos
                                    action2 = "agregarPermisosUsuario";
                                    order = 'usuario=' + id + '&rol='+rol+'&action='+action2;

                                    $.post("process.php", order, function(data2){
                                        var json2 = $.parseJSON(data2); // create an object with the key of the array
                                        if (json2.success == true){                        
                                            if($(".idUsuario"+id).hasClass("usuarioAdmin")){
                                                $(".idUsuario"+id).removeClass("usuarioAdmin");
                                                $(".idUsuario"+id).addClass("usuarioFuncionario");
                                            } else {
                                                $(".idUsuario"+id).removeClass("usuarioFuncionario");
                                                $(".idUsuario"+id).addClass("usuarioAdmin");
                                            }                                
                                        }else{      
                                            alert(json2.message);
                                        }
                                    }); 
                        } else {
                            alert(json.message);
                        }
                    });
            }
        });
        
        $( "#sortable2" ).bind( "sortupdate", function(event, ui) {
            var clases=ui.item.attr('class').split(" "); 
            if(clases.length>1){
                var id=clases[1].replace("idUsuario",""); 
                var action2 = "eliminarPermisosUsuario";
                    var rol = 2;
                if($(".idUsuario"+id).hasClass("usuarioAdmin")){
                    rol = 1;
                } 

                var order = 'usuario=' + id + '&rol='+rol+'&action='+action2;
                 var posting = $.post("process.php", order);
                
                    posting.done(function( data ) {
                        var json = $.parseJSON(data); // create an object with the key of the array
                        if (json.success == true){
                                    //ahora vuelvo a activar los permisos
                                    action2 = "agregarPermisosUsuario";
                                    order = 'usuario=' + id + '&rol='+rol+'&action='+action2;

                                    $.post("process.php", order, function(data2){
                                        var json2 = $.parseJSON(data2); // create an object with the key of the array
                                        if (json2.success == true){                        
                                            if($(".idUsuario"+id).hasClass("usuarioAdmin")){
                                                $(".idUsuario"+id).removeClass("usuarioAdmin");
                                                $(".idUsuario"+id).addClass("usuarioFuncionario");
                                            } else {
                                                $(".idUsuario"+id).removeClass("usuarioFuncionario");
                                                $(".idUsuario"+id).addClass("usuarioAdmin");
                                            }                                
                                        }else{      
                                            alert(json2.message);
                                        }
                                    }); 
                        } else {
                            alert(json.message);
                        }
                    });
            }
        });
               
               function reloadUsers(){
                   //borrar administradores
                    $('#fastLiveFilter').html("");  
                   //borrar funcionarios
                    $('#indicadoresAsociados').html(""); 
                    var ajaxLoader = "<img src='../images/ajax-loader2.gif' alt='cargando...' style='margin: 5px'/>"; 
                    jQuery("#fastLiveFilter")
                        .html(ajaxLoader)
                        .load('_usuariosAdministradores.php', { status: 1}, function(response){					
                        if(response) {
                            jQuery("#fastLiveFilter").css('display', '');                    
                        } else {                    
                            jQuery("#fastLiveFilter").css('display', 'none');               
                        }
                    });   
                    jQuery("#indicadoresAsociados")
                        .html(ajaxLoader)
                        .load('_usuariosFuncionarios.php', { status: 1}, function(response){					
                        if(response) {
                            jQuery("#indicadoresAsociados").css('display', '');                    
                        } else {                    
                            jQuery("#indicadoresAsociados").css('display', 'none');               
                        }
                    });                  
               }
    
</script>
<?php } else {
	echo "No tiene permisos para acceder a esta página.";
} writeFooter(); ?>