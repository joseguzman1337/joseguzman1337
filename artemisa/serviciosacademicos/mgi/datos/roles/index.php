<?php

    include("../templates/template.php");
    $db =  writeHeader("Gestión de Roles y Permisos",true);
    
    $utils = new Utils_Datos();
    $esAdmin = $utils->esAdministradorMGI($db,$_SESSION['MM_Username']);
    if($esAdmin) { 
        $roles = $utils->getActives($db,"siq_rolesMGI","rol","ASC",true);
        $formularios = $utils->getActives($db,"siq_formulario","nombre","ASC",true);
        
        ?>  
        <div id="contenido">
        <!--<h4>Administrar Usuarios y Roles</h4>-->
        <div id="form"> 
			<div id="msg-error"><?php echo $_REQUEST["mensaje"]; ?></div>
    
    <form action="process.php" method="post" id="form_test" style="margin-top:20px;"  >
            <input type="hidden" name="entity" value="usuarios" />
            <input type="hidden" name="action" value="asociarUsuarios" />
            
            <fieldset>   
                <legend>Administrar Usuarios y Roles</legend>  
                
                <div class="seccionBox" style="margin-left: 10px; margin-right: 15px;width:100%;">
                    <h4 style="margin-left: 60px;margin-top: 0;margin-bottom: 20px;">Agregar permisos a un usuario de Sala</h4>
                    <label for="nombre" >Nombre/Usuario: </label>
                     <input type="text"  class="grid-5-12" minlength="2" name="nombreUsuario" id="nombreUsuario" title="Nombre del usuario" maxlength="200" tabindex="1" autocomplete="off" value="" /> 
						<select id="rolUsuario" name="rolUsuario" style="padding:2px;height:auto;">
                                                    <?php foreach($roles as $rol) { ?>
							<option value="<?php echo $rol["idsiq_rolesMGI"]; ?>"><?php echo $rol["rol"]; ?></option>
                                                    <?php } ?>
						</select>
                     <select id="formulario" name="formulario" style="display:none;padding:2px;height:auto;">
                                                    <?php foreach($formularios as $form) { ?>
							<option value="<?php echo $form["idsiq_formulario"]; ?>"><?php echo $form["nombre"]; ?></option>
                                                    <?php } ?>
						</select>
                              <input type="button" class="first small" id="agregarPermisos" value="Agregar permisos" style="padding: 3px 19px 4px;"> 
					<input type="hidden" value="" id="idUsuario" name="idUsuario" />
               </div>
                            
               <div class="vacio"></div>
               
               <div class="seccionBox" style="margin-left: 10px; margin-right: 15px;width:100%;">
                    <h4 style="margin-left: 60px;margin-top: 0;margin-bottom: 20px;">Eliminar permisos a un usuario</h4>
                    <label for="nombre" >Nombre/Usuario: </label>
                     <input type="text"  class="grid-5-12" minlength="2" name="nombreUsuarioEliminar" id="nombreUsuarioEliminar" title="Nombre del usuario" maxlength="200" tabindex="1" autocomplete="off" value="" />             
                        <select id="rolUsuarioEliminar" name="rolUsuarioEliminar" style="padding:2px;height:auto;">
							<option value="0">Todos</option>
							<?php foreach($roles as $rol) { ?>
                                                            <option value="<?php echo $rol["idsiq_rolesMGI"]; ?>"><?php echo $rol["rol"]; ?></option>
                                                        <?php } ?>
						</select>     
                        <input type="button" class="first small" id="eliminarPermisos" value="Eliminar permisos" style="padding: 3px 19px 4px;">  
						<input type="hidden" value="" id="idUsuarioEliminar" name="idUsuarioEliminar" />						  
               </div>
                            
               <div class="vacio"></div>
                
				
				<!-- Usuarios de EC -->
				<table style="border: 0px;margin:0px 70px 0;border-collapse:separate;border-spacing: 10px 30px;"> 
                                    <?php $cont=1; $fila=true;
                                    foreach($roles as $rol) {
                                        $usuarios = $utils->getUsuariosRol($db,$rol["idsiq_rolesMGI"]); 
                                        if($fila) { ?>
                    <tr>
                        <?php } ?>
                        <td valign="top" colspan="2" style="padding: 0.5em 0 0;">
                                    <legend>Usuarios con Rol <?php echo $rol["rol"]; ?></legend>
                                    <div id="fastLiveFilter<?php echo $rol["idsiq_rolesMGI"]; ?>" style="width:480px; height:520px; overflow: scroll;" >
                                      
                                      <ul id="sortableN<?php echo $rol["idsiq_rolesMGI"]; ?>" class="connectedSortable" style="min-height: 460px;list-style-type: none;margin: 5px 0 0;">  
                                            <?php
                                            if (!empty($usuarios)){
                                                    $i=0;
                                                    //var_dump($indicadores);
                                                    foreach($usuarios as $dt_sec){
                                                    // print_r($dt);
                                                           $nombre=$dt_sec['nombre']." (".$dt_sec['usuario'].")";
                                                            $id_in=$dt_sec['idusuario'];
                                                           //$id_in=$dt_sec['usuario'];
                                                    
                                                        //$id=$dt_sec['codigo'];
                                                        echo '<li class="ui-state-default idUsuario'.$id_in.' usuario'.$rol["idsiq_rolesMGI"].'" id="'.$id_in.' " style="font-size: 1.2em; margin: 0 0px 0px;padding: 5px;border-bottom:0px;background-color: #EDEDED;">'.$nombre;
                                                        echo'</li>';
                                                        $i++;
                                                    }
                                            }
                                            ?>
                                      </ul>
                                   </div>
                        </td>
                        <?php if(!$fila) { ?>
                    </tr>
                    <?php } $fila = !$fila; $cont++;} ?>
                </table>
                
            </fieldset>
            </form>
        </div>
        <script type="text/javascript">
             /***************************************
             * Volver a cargar los usuarios
             *******************************************/
            function reloadUsers(){
                    <?php foreach($roles as $rol) { ?>
                   //borrar usuarios
                    $('#fastLiveFilter<?php echo $rol["idsiq_rolesMGI"]; ?>').html("");  
                    var ajaxLoader = "<img src='../../images/ajax-loader2.gif' alt='cargando...' style='margin: 5px'/>"; 
                    jQuery("#fastLiveFilter<?php echo $rol["idsiq_rolesMGI"]; ?>")
                        .html(ajaxLoader)
                        .load('_usuariosMGI.php', { status: 1, rol: '<?php echo $rol["idsiq_rolesMGI"]; ?>'}, function(response){					
                        if(response) {
                            jQuery("#fastLiveFilter<?php echo $rol["idsiq_rolesMGI"]; ?>").css('display', '');                    
                        } else {                    
                            jQuery("#fastLiveFilter<?php echo $rol["idsiq_rolesMGI"]; ?>").css('display', 'none');               
                        }
                    });       
                    <?php } ?>
               }
            
            /***************************************
             * Agregar permisos
             *******************************************/
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
                                                                                form: $("#formulario").val(),
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
			
       /***************************************
             * Eliminar permisos
             *******************************************/
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
                                                                rol: $("#rolUsuarioEliminar").val(),
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
            
            /**********************************
             * Para llenar los autocomplete
             **********************************/
            $(document).ready(function() {
                $('#nombreUsuario').autocomplete({
                        source: function( request, response ) {
                            $.ajax({
                                url: "../searchs/lookForUsers.php",
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
                                url: "../searchs/lookForUsersMGI.php",
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
               
               $('#rolUsuario').bind("change", function(){
                    if($('#rolUsuario').val()=="3" || $('#rolUsuario').val()=="4"){
                        $('#formulario').attr("style","display:block;padding:2px;height:auto;clear:both;float:none;margin-left:210px;");
                        $('#agregarPermisos').attr("style","padding: 3px 19px 4px;margin-left:210px;");
                    } else {
                        $('#formulario').attr("style","display:none;padding:2px;height:auto;");
                        $('#agregarPermisos').attr("style","padding: 3px 19px 4px;");
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
            
         </script>
    <?php } else {
        echo "No tiene permisos para acceder a este módulo";
    }
    
    writeFooter(); 
?>
